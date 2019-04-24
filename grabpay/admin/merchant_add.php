<?php
/**
 * Created by PhpStorm.
 * User: GCCOE_01
 * Date: 24-04-2018
 * Time: 05:15 PM
 */
require_once('header.php');

if($_SESSION['user_type'] === 6)
    include_once('forbidden.php');

require_once('php/inc_agents_tree.php');

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$user_id=$_SESSION['iid'];
$event="view";
$auditable_type="CORE PHP AUDIT";
$new_values="";
$old_values="";
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent= $_SERVER['HTTP_USER_AGENT'];
audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip, $user_agent);

$search_type = 'trans';

require_once('api/merchant_addupdate_api.php');

$log_path = '/var/www/html/revopay/admin/api/merchantslogs.log';

    function poslogs($log) {
        GLOBAL $log_path;
        $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
        return $myfile;     
    }

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

    // var_dump(getTransactions($_SESSION['iid']));die();

    // if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';

        if(!empty($env) && $env == 0){
            $omg = 'TEST MODE ENABLED';
        }
    } else { ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>CREATE MERCHANT</h5>

                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->


                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                                if($_POST) {

                                    if($_POST['method']=='grabpay'){
                                        header("Location: https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/merchant_add_grabpay.php"); /* Redirect browser */
                                            exit();
                                    } elseif ($_POST['method']=='alipay') {
                                        header("Location: https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/merchant_add_alipay.php"); /* Redirect browser */
                                            exit();
                                       
                                    } else {
                                        echo "Not in alipay And Grabpay";
                                    }
                                    die();
                            } else {
                            ?>
                            <style>
                                label {
                                    font-weight: bold;
                                }
                                #color{
                                    color:red;
                                }
                                .mrb-15 {
                                    margin-bottom: 15px;
                                }.SmallInput 
                                { width: 91px; height: 30px; }
                                .none {
                                    display:none;
                                }
                                
                            </style>
                            <form method="POST">
                                <fieldset>
                                 <legend > Choose the Payment Method</legend>


                                <input type="radio" name="method" data-id="grabpay" value="grabpay"></legend> Grabpay  &nbsp; &nbsp;&nbsp;&nbsp;<input type="radio" name="method" data-id="alipay"  value="alipay"></legend> Alipay &nbsp; &nbsp;&nbsp; &nbsp; <input type="submit" id='button' class="btn btn-warning" value="Proceed" style="display: none">
                                </fieldset>

                            </form>
                            
                            <?php } ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php

    }

} elseif($usertype == 6) {

    echo 'show virtual terminal';

    ajax_redirect('/virtualterminal.php');

} else {

    echo '<a href="login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>


<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
$(':radio').change(function (event) {
    var id = $(this).data('id');
    $('#' + id).addClass('none').siblings().removeClass('none');
     $('#button').show();

});
$('#pg_merchant_id_alipay').on('change', function() {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = $('#pg_merchant_id_alipay').val();
    $.ajax({
        url: "php/inc_reportsearch_alipay.php",
        data: {
            'merchant_id' : mer_id
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            console.log(data.result);
            if(data.result == true) {
                swal('Merchant ID '+mer_id+' Already Exists');
                $("#pg_merchant_id_alipay").val("");
            }
        },
        error: function(data){
            //error
        }
    });
});

// function toggle(grabpay, obj) {
//     var $input = $(obj);
//     if ($input.prop('checked')) $('.grabpay').show();
//     else $('.grabpay').hide();
// }
// function toggle1(alipay, obj) {
//     var $input = $(obj);
//     if ($input.prop('checked')) $('.alipay').show();
//     else $('.alipay').hide();
// }


// document.getElementById('1').onchange = function() {
//     document.getElementById('Alipay').disabled = !this.checked;
// };

// document.getElementById('2').onchange = function() {
//     document.getElementById('Grabpay').disabled = !this.checked;
// };
// jquery
$('#grab_merchant_id').on('change', function() {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = $('#grab_merchant_id').val();
    //console.log(mer_id);
    $.ajax({
        url: "php/inc_reportsearch1.php",
        data: {
            'grab_merchant_id' : mer_id
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            console.log(data);
            if(data.result == true) {
                swal('Grab_Merchant ID '+mer_id+' Already Exists');
                $("#grab_merchant_id").val("");
                $("#pg_merchant_id").val("");
            }
            if (data.mer_id) {
                $("#pg_merchant_id").val(data.mer_id);
            }
        },
        error: function(data){
            //error
        }
    });
});

function merchant() {
    var grab_merchant_id=document.getElementById('grab_merchant_id').value;
    var pg_merchant_id=document.getElementById('pg_merchant_id').value;
    var pg_merchant_name=document.getElementById('pg_merchant_name').value;
    var pg_merchant_start_date=document.getElementById('pg_merchant_start_date').value;
    var pg_merchant_address1=document.getElementById('pg_merchant_address1').value;
    var pg_merchant_city=document.getElementById('pg_merchant_city').value;
    var pg_merchant_state=document.getElementById('pg_merchant_state').value;
    var pg_merchant_country=document.getElementById('pg_merchant_country').value;
    var pg_merchant_postalcode=document.getElementById('pg_merchant_postalcode').value;
    var pg_merchant_phone=document.getElementById('pg_merchant_phone').value;
    var pg_merchant_email=document.getElementById('pg_merchant_email').value;
    var pg_merchant_mcc=document.getElementById('pg_merchant_mcc').value;
    var pg_ifsccode=document.getElementById('pg_ifsccode').value;
    var pg_accountno=document.getElementById('pg_accountno').value;

    var e = document.getElementById("pg_merchant_status");
    var pg_merchant_status = e.options[e.selectedIndex].value;
    //var pg_merchant_status=document.getElementById('pg_merchant_status').value;

    // var e1 = document.getElementById("pg_merchant_action");
    // var pg_merchant_action = e1.options[e1.selectedIndex].value;

    var e2 = document.getElementById("pg_merchant_currency");
    var pg_merchant_currency=e2.options[e2.selectedIndex].value;
    
    if(grab_merchant_id == "") {
            swal('Please Enter the grab_Merchant_Id');
            return false
    }
    if(grab_merchant_id.length != 36) {
            swal('grab_Merchant_Id should be of length 36');
            return false
    }
    if(pg_merchant_id == "") {
            swal('Please Enter the Merchant_Id');
            return false
    }

    if(pg_merchant_name == "") {
            swal('Please Enter the Merchant_Name');
            return false
    }   
    if(pg_merchant_start_date == "") {
            swal('Please Enter the Merchant_Start_Date');
            return false
    }
    if(pg_merchant_address1 == "") {
            swal('Please Enter the Merchant_Address1');
            return false
    }
    if(pg_merchant_city == "") {
            swal('Please Enter the Merchant_City');
            return false
    }  
    if(pg_merchant_address1 == "") {
            swal('Please Enter the Merchant_Address1');
            return false
    }  
    if(pg_merchant_state == "") {
            swal('Please Enter the Merchant_State');
            return false
    }   
    if(pg_merchant_country == "") {
            swal('Please Enter the Merchant_Country');
            return false
    }  
    if(pg_merchant_postalcode == "") {
            swal('Please Enter the Merchant_Postalcode');
            return false;
    }  
    
    if(!(/^[0-9]+$/.test(document.getElementById('pg_merchant_postalcode').value))) {
        swal(" Merchant_Postalcode contains only number!");
        return false;
    }

    if(pg_merchant_phone == "") {
        swal('Please Enter the  Merchant_Phone');
        return false;
    }

    if(!(/^[0-9]+$/.test(document.getElementById('pg_merchant_phone').value))) {
        swal(" Merchant_Phone contains only number!");
        return false;
    }

    if(pg_merchant_phone.length != 12) {
        swal(' Merchant_Phone should be of length 12');
        return false;
    }  
    if(pg_merchant_email == "")  {
        swal('Please Enter the Merchant_Email');
        return false;
    }  
    
    if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById('pg_merchant_email').value))) {
        swal("invalid Mail format!");
        return false;
    }

    if(pg_merchant_mcc == "")  {
        swal('Please Enter the Merchant_Mcc');
        return false
    }

    if (!(/^[0-9]+$/.test(document.getElementById('pg_merchant_mcc').value)))   {
        swal(" Merchant_Mcc contains only number!");
        return false;
    }

    if(pg_ifsccode == "")   {
            swal('Please Enter the ifsccode');
            return false
    }   
    if(pg_accountno == "")  {
            swal('Please Enter the Accountno');
            return false
    }
    if(!(/^[0-9]+$/.test(document.getElementById('pg_accountno').value)))  {
        swal(" Accountno contains only number!");
        return false;
    }

    if(pg_merchant_currency == 0)  {
        swal('Please Select the Currency');
        return false
    }


    if(pg_merchant_status == 0)  {
        swal('Please Enter the Merchant_Status');
        return false
    } 
    if(pg_merchant_action == 0)  {
    swal('Please Enter the Merchant_Action');
    return false
     }

}

function merchant_alipay() {
    var pg_merchant_id=document.getElementById('pg_merchant_id_alipay').value;
    var pg_merchant_name=document.getElementById('pg_merchant_name_alipay').value;
    var pg_merchant_start_date=document.getElementById('pg_merchant_start_date_alipay').value;
    var pg_merchant_city=document.getElementById('pg_merchant_city_alipay').value;
    var pg_merchant_state=document.getElementById('pg_merchant_state_alipay').value;
    var pg_merchant_country=document.getElementById('pg_merchant_country_alipay').value;
    var pg_merchant_postalcode=document.getElementById('pg_merchant_postalcode_alipay').value;
    var pg_merchant_phone=document.getElementById('pg_merchant_phone_alipay').value;
    var pg_merchant_email=document.getElementById('pg_merchant_email_alipay').value;
    var pg_merchant_mcc=document.getElementById('pg_merchant_mcc_alipay').value;
    var pg_ifsccode=document.getElementById('pg_ifsccode_alipay').value;
    var pg_accountno=document.getElementById('pg_accountno_alipay').value;

    var e = document.getElementById("pg_merchant_status");
    var pg_merchant_status = e.options[e.selectedIndex].value;
    //var pg_merchant_status=document.getElementById('pg_merchant_status').value;

    // var e1 = document.getElementById("pg_merchant_action");
    // var pg_merchant_action = e1.options[e1.selectedIndex].value;

    var e2 = document.getElementById("pg_merchant_currency");
    var pg_merchant_currency=e2.options[e2.selectedIndex].value;
    
    if(pg_merchant_id == "") {
            swal('Please Enter the Merchant_Id');
            return false
    } 

    if(pg_merchant_id != "") {
        $.ajax({
            url: "php/inc_reportsearch1.php",
            data: {
                'merchant_id' : pg_merchant_id
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                console.log(data.result);
                if(data.result == true) {
                    swal('Merchant ID Already Exists');
                }
            },
            error: function(data){
                //error
            }
        });
        // return false;
    }

    if(pg_merchant_name == "") {
            swal('Please Enter the Merchant_Name');
            return false
    }   
    if(pg_merchant_start_date == "") {
            swal('Please Enter the Merchant_Start_Date');
            return false
    }  
    if(pg_merchant_city == "") {
            swal('Please Enter the Merchant_City');
            return false
    }  
    if(pg_merchant_state == "") {
            swal('Please Enter the Merchant_State');
            return false
    }   
    if(pg_merchant_country == "") {
            swal('Please Enter the Merchant_Country');
            return false
    }  
    if(pg_merchant_postalcode == "") {
            swal('Please Enter the Merchant_Postalcode');
            return false;
    }  
    
    if(!(/^[0-9]+$/.test(document.getElementById('pg_merchant_postalcode').value))) {
        swal(" Merchant_Postalcode contains only number!");
        return false;
    }

    if(pg_merchant_phone == "") {
        swal('Please Enter the  Merchant_Phone');
        return false;
    }

    if(!(/^[0-9]+$/.test(document.getElementById('pg_merchant_phone').value))) {
        swal(" Merchant_Phone contains only number!");
        return false;
    }

    if(pg_merchant_phone.length != 12) {
        swal(' Merchant_Phone should be of length 12');
        return false;
    }  
    if(pg_merchant_email == "")  {
        swal('Please Enter the Merchant_Email');
        return false;
    }  
    
    if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById('pg_merchant_email').value))) {
        swal("invalid Mail format!");
        return false;
    }

    if(pg_merchant_mcc == "")  {
        swal('Please Enter the Merchant_Mcc');
        return false
    }

    if (!(/^[0-9]+$/.test(document.getElementById('pg_merchant_mcc').value)))   {
        swal(" Merchant_Mcc contains only number!");
        return false;
    }

    if(pg_ifsccode == "")   {
            swal('Please Enter the ifsccode');
            return false
    }   
    if(pg_accountno == "")  {
            swal('Please Enter the Accountno');
            return false
    }

    if(pg_merchant_currency == 0)  {
        swal('Please Select the Currency');
        return false
    }

    if(!(/^[0-9]+$/.test(document.getElementById('pg_accountno').value)))  {
        swal(" Accountno contains only number!");
        return false;
    }

    if(pg_merchant_status == 0)  {
        swal('Please Enter the Merchant_Status');
        return false
    } 
    // if(pg_merchant_action == 0)  {
    // swal('Please Enter the Merchant_Action');
    // return false
    // }

}


// $('input[type=checkbox]').click(function() {
//     if($(this).is(":checked")) {
//         $(".answer").show();
//         var checked = $(this).val();
//         alert(checked);
//         if(checked=='1'){
//             alert(checked);Grabpay
//                 $("#Grabpay").prop("disabled", true);
//                 $("#Alipay").prop("disabled", false);
//         } else {
//             $("#Alipay").prop("disabled", false);
//             $("#Grabpay").prop("disabled", true);
//         }

//         //alert('hi');
//     } else {
//         $(".answer").hide();
//     }
// });

// $('input[type=checkbox]').change(function(){
//     if ($('#Alipay').is(':checked') == true){
//         $('#txtNumHours').val('160').prop('disabled', true);
        
//     } else {
//         $('#txtNumHours').val('').prop('disabled', false);
//         console.log('unchecked');
//     }
// });
</script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">

<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>

    $('#pg_merchant_start_date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    function callQueryapi() {
        $.ajax({
            method: "POST",
            url: "alipayapi.php",
            data: {action: '7' }
        })
            .done(function (msg) {
                if(msg==1)
                    location.reload();
                else
                    alert("All Transactions are up to date");
            });
    }
    $(document).ready(function(){

        // $("#Grabpay").prop("disabled", true);
        // $("#Alipay").prop("disabled", true);
        $('.date-sec .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            dateFormat: 'yyyy-mm-dd',
            autoclose: true
        });

        var mid_1 = '<?php echo $mid; ?>';
        // alert(mid_1);

        $.ajax({

            method: "POST",

            url: "php/inc_dailyreport.php",

            data: { mid: mid_1 }

        })

            .done(function( msg ) {

                $("#dailyreport").html(msg);

            });

        $('#date').datepicker({

            todayBtn: "linked",

            keyboardNavigation: false,

            forceParse: false,

            calendarWeeks: true,

            autoclose: true

        });

        $("#date").change(function () {

            $.ajax({

                method: "POST",

                url: "php/inc_dailyreport.php",

                data: { date: $(this).val() }

            })

                .done(function( msg ) {

                    $("#dailyreport").html(msg);

                    $("#exportlink").attr("href", "phpexcel/report.php?date="+$("#date").val());

                });

        });

        var table1 = $('#table1').tabelize({

            /*onRowClick : function(){

             alert('test');

             }*/

            fullRowClickable : true,

            onReady : function(){

                console.log('ready');

            },

            onBeforeRowClick :  function(){

                console.log('onBeforeRowClick');

            },

            onAfterRowClick :  function(){

                console.log('onAfterRowClick');

            },

        });



        //$('#table1 tr').removeClass('contracted').addClass('expanded l1-first');

    });

</script>



<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>

<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">



<script type="text/javascript">

    $('.tree').treegrid();

</script>



<!-- ChartJS-->

<script src="js/plugins/chartJs/Chart.min.js"></script>

<script type="text/javascript">

    // $(function () {
    // $(document).ready(function(){


    //     /**** Displaying the number of transactions per month in Line graph format ****/

    //     var lineData = {

    //         labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

    //         datasets: [

    //             {

    //                 label: "Example dataset",

    //                 fillColor: "rgba(26,179,148,0.5)",

    //                 strokeColor: "rgba(26,179,148,0.7)",

    //                 pointColor: "rgba(26,179,148,1)",

    //                 pointStrokeColor: "#fff",

    //                 pointHighlightFill: "#fff",

    //                 pointHighlightStroke: "rgba(26,179,148,1)",

    //                 data: [<?php echo $transCnts; // echo $transactions_data; ?>]

    //             },

    //             {

    //                 label: "Example dataset",

    //                 fillColor: "rgba(255,133,0,0.5)",

    //                 strokeColor: "rgba(255,133,0,1)",

    //                 pointColor: "rgba(255,133,0,1)",

    //                 pointStrokeColor: "#fff",

    //                 pointHighlightFill: "#fff",

    //                 pointHighlightStroke: "rgba(255,133,0,1)",

    //                 data: [<?php // echo $transAmts; // echo $chargebacks_data; ?>]

    //             }

    //         ]

    //     };



    //     var lineOptions = {

    //         scaleShowGridLines: true,

    //         scaleGridLineColor: "rgba(0,0,0,.05)",

    //         scaleGridLineWidth: 1,

    //         bezierCurve: true,

    //         bezierCurveTension: 0.4,

    //         pointDot: true,

    //         pointDotRadius: 4,

    //         pointDotStrokeWidth: 1,

    //         pointHitDetectionRadius: 20,

    //         datasetStroke: true,

    //         datasetStrokeWidth: 2,

    //         datasetFill: true,

    //         responsive: true,

    //     };

    //     var ctx = document.getElementById("lineChart").getContext("2d");

    //     var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    // });

    /**** Daily Summary Report for selecting date from picker ****/
    $('#date').on("change", function () {
        // alert($(this).val());
        var selected_date = $(this).val();
        if(selected_date!='') {
            $('.rlt_row').show();
        }

        $.ajax({
            method: "POST",
            url: "php/inc_<?php echo $search_type; ?>search.php",
            data: {S_Date: selected_date}
        })
            .done(function( msg ) {
                $("#cbresults").html(msg);
                $('.dataTables-example').dataTable({
                    "order": [[ 1, "desc" ]],
                    responsive: true,
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                    }
                });
                $('input:checkbox').change(function() {
                    if($(this).attr('id') == 'selectall') {
                        jqCheckAll2( this.id);
                    }
                });
                function jqCheckAll2( id ) {
                    $("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
                }

                $("#exportlink_date").attr("href", "php/inc_transsearch.php?date="+selected_date);
            });

    });

    /**** Sparkline Graph jquery ****/
    $('.sparkline').sparkline('html', { enableTagOptions: true });

    $('.sparkline_1').sparkline('html', { enableTagOptions: true });

    // $(window).on('resize', function() {
    //  $('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

