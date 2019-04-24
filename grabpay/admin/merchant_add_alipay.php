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

                            if (isset($_SESSION['descrtn'])) {
                            echo "-&nbsp;&nbsp;";
                            echo $_SESSION['descrtn'];
                            unset($_SESSION['descrtn']);
                            }

                            $Merchant_MDR = $db->rawQuery("SELECT * FROM merchant_MDR");
                            if($_POST) {
                                // echo "<pre>";
                                // print_r($_POST);
                                // die();
                                // require_once('api/alipaymerchantAPI.php');
                                // $results = merchantandterminalchecking($_POST);
                                $results = merchantaddupdatestatus($_POST, $_POST['pg_merchant_action'],'');

                                $results += array("user" => $_SESSION['username']);
                                $results_enc = json_encode($results);
                                $results_dec = json_decode($results_enc);
                                echo $results_dec->ResponseDesc;

                                if($_SESSION['descrtn']!='') {
                                    $logs = "Merchant Add Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
                                    poslogs($logs);
                                }
                                echo "<br><br>";
                                echo "<a href='merchant_add.php'>CREATE ANOTHER MERCHANT</a>";
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
                                 #topright {
                                      position: absolute;
                                      top: 8px;
                                      right: 33px;
                                      font-size: 13px;
                                    }
                                
                            </style>
                            <button id="topright" class="btn btn-warning" onclick="location.href='merchant_add.php'">Back</button>
                            <form action="#" onsubmit="return merchant()" autocomplete="off" method="POST">
                             </fieldset>
                             <legend> AliPay : -</legend>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3">
                                            <label>Merchant ID</label><BR>
                                            <input class="form-control" readonly type="text" name="pg_merchant_id" id="pg_merchant_id">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Name <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_name" id="pg_merchant_name">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Merchat Start Date  <span id="color">*</span></label><BR>
                                            <div class="input-group date datesummary">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input class="form-control" name="pg_merchant_start_date" id="pg_merchant_start_date" type="text" value="<?php echo date('m/d/Y'); ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Address1 <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_address1" id="pg_merchant_address1">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Address2</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_address2" id="pg_merchant_address2">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat City <span id="color">*</span> </label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_city" id="pg_merchant_city">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat State <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_state" id="pg_merchant_state">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Country <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_country" id="pg_merchant_country">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Postalcode <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_postalcode" id="pg_merchant_postalcode">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Phone <span id="color">*</span> </label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_phone" id="pg_merchant_phone">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Email <span id="color">*</span> </label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_email" id="pg_merchant_email">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Mcc <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_mcc" id="pg_merchant_mcc">
                                        </div>
                                         <div class="col-sm-3 mrb-15">
                                            <label>Merchat Ifsccode <span id="color">*</span></label><BR>
                                            <input class="form-control" type="text" name="pg_ifsccode" id="pg_ifsccode">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Accountno <span id="color">*</span></label><BR> 
                                            <input class="form-control" type="text" name="pg_accountno" id="pg_accountno">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Currency <span id="color">*</span></label><BR>
                                            <select name="pg_merchant_currency" class="form-control" id="pg_merchant_currency">
                                                <option value="0">Select</option>
                                                <option value="USD">USD</option>
                                                <option value="SGD">SGD</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Status <span id="color">*</span></label><BR>
                                            <select name="pg_merchant_status" class="form-control" id="pg_merchant_status">
                                                <option value="0">Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">In-Active</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="pg_merchant_action" id="pg_merchant_action" value="1">
                                        </div>
                                        <!-- <div class="col-sm-3 mrb-15">
                                            <label>Merchat Action</label><BR>
                                            <select name="pg_merchant_action" class="form-control"  id="pg_merchant_action">
                                                <option value="0">Action</option>
                                                <option value="1">Add</option>
                                                <option value="2">Update</option>
                                                <option value="3">Status</option>
                                            </select>
                                        </div> -->

                                        <div class="col-sm-5 mrb-15">
                                            <label>Merchat Permission</label><BR>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission1" value="1" checked>Purchase</label>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission2" value="1" checked>Cancel</label>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission3" value="1" checked>Query</label>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission4" value="1" checked>Refund</label>
                                        </div>
                                        <!-- <div class="col-sm-5 mrb-15">
                                        <label for="Merchant MDR">Merchant MDR</label><br>
                                            <?php 
                                            // foreach ($Merchant_MDR as $value) {
                                            ?>
                                            <input type="checkbox"  id="<?php // echo $value['id']; ?>" name="Merchant_MDR[]" value="<?php // echo $value['ranges']; ?>"> <?php // echo $value['vendors']; ?>

                                                <?php
                                             // }
                                            ?>
                                         </div> -->
                                         <div class="col-sm-3" style="left: -82px;">
                                            <label for="Merchant MDR">Merchant MDR <span id="color">*</span></label><br>
                                        <?php 
                                        $i=0;
                                         foreach ($Merchant_MDR as $value) {
                                            $i++;
                                            ?>

                                           <?php if($i=='1') { ?>
                                             <div class="input-group"> 
                                                <span class="input-group-addon my-addon" style="width: 114px;">
                                                    <input type="checkbox" aria-label="..." id="<?php echo $value['id']; ?>" name="<?php echo $value['vendors']; ?>" value ="<?php echo $value['id']; ?>" checked >&nbsp;<?php echo $value['vendors']; ?>
                                                </span>
                                                <input type="text"  class="form-control" aria-label="..."
                                                name="<?php echo $value['vendors']; ?>[]"  disabled id="<?php echo $value['vendors']; ?>" placeholder=" MDR % " style="width:120px;">
                                            </div>
                                          <?php } ?>
                                          <?php if($i=='2') { ?>
                                           
                                          <?php } } ?>

                                        </div>
                                         <!-- <div class="col-sm-3" id="mdr" style="left: 386px;">
                                            <span> </span><br><br>
                                        <span id="alipay_range" style="padding: 17.5px;"></span> <span><input type="text" class="form-control" name="alipay[]" placeholder="Percentage for Alipay" id="alipay"></span>

                                        </div>
                                        <div class="col-sm-3" id="mdr1" style="left: 404px;top: 1px;">
                                            <span> </span><br><br>
                                        <span id=grabpay_range style="padding: 17.5px;" > </span>  <input type="text" class="form-control" name="grabpay[]"  placeholder="Percentage for grabpay" id="grabpay">
                                        </div> -->
                                        
                                    </div>
                                </div>
                                &nbsp; &nbsp; <input type="submit" class="btn btn-warning" value="Submit">
                                <br><br>
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


document.getElementById('1').onchange = function() {
    document.getElementById('Alipay').disabled = !this.checked;
    $("#Alipay").attr("required", "true");
};
if ($("#1").is(':checked')){
     $('#Alipay').removeAttr("disabled");
    $("#Alipay").attr("required", "true")
}



//Calling function
// repeatAjax();


// function repeatAjax(){
//     alert('hi');
// jQuery.ajax({
//           type: "POST",
//           url: 'load.php',
//           dataType: 'json',
//           success: function(resp) {
//                     jQuery('#out1').html(resp[0]);
//                     jQuery('#out2').html(resp[1]);
//                     jQuery('#out3').html(resp[2]);

//           },
//           complete: function() {
//                 setTimeout(repeatAjax,1000); //After completion of request, time to redo it after a second
//              }
//         });
// }

function codeAddress() {
     //        if(msg.slice(0,21) == 'No Transactions Found') {
                    // $("#exportlink_date").hide();
                    // } else {
                    // $("#exportlink_date").show();
                // 
    var mer_id = '1';
    //console.log(mer_id);
    $.ajax({
        url: "php/inc_reportsearch_alipay.php",
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

        }
window.onload = codeAddress;
// jquery
// $('#grab_merchant_id').on('change', function() {
//     // alert($('#pg_merchant_id').val());
//     // ajax request
//     var mer_id = $('#grab_merchant_id').val();
//     //console.log(mer_id);
//     $.ajax({
//         url: "php/inc_reportsearch_alipay.php",
//         data: {
//             'grab_merchant_id' : mer_id
//         },
//         type: 'POST',
//         dataType: 'json',
//         success: function(data) {
//             // console.log(data);
//             console.log(data);
//             if(data.result == true) {
//                 swal('Grab_Merchant ID '+mer_id+' Already Exists');
//                 $("#grab_merchant_id").val("");
//                 $("#pg_merchant_id").val("");
//             }
//             if (data.mer_id) {
//                 $("#pg_merchant_id").val(data.mer_id);
//             }
//         },
//         error: function(data){
//             //error
//         }
//     });
// });

function merchant() {
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

