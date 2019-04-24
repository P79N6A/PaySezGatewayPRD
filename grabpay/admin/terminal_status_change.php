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

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7) {
 ?>
  <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5> CHANGE TERMINAL STATUS</h5>&nbsp;&nbsp;
                        <?php
                        /**** Terminal Status Update ****/
                         if(isset($_SESSION['descrtn'])) {
                            echo "-&nbsp;&nbsp;";
                            echo $_SESSION['descrtn'];
                            unset($_SESSION['descrtn']);
                          }
                         if(isset($_POST['submit'])) {
                               $db->where("mer_map_id", $_POST['pg_merchant_id']);
                               $merchDet = $db->getOne('merchants');
                               $results = terminaladdupdatestatus($_POST, $_POST['pg_terminal_action'],$merchDet['idmerchants']);
                               $results += array("user" => $_SESSION['username']);
                               $results_enc = json_encode($results);
                               $results_dec = json_decode($results_enc);
                               $_SESSION['descrtn'] = $results_dec->ResponseDesc;
                               if($_SESSION['descrtn']!='') {
                                  $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
                                  poslogs($logs);
                             }
                             header('Location: ' . $_SERVER['PHP_SELF']);
                          }
                    ?>
                    </div>
                   <div class="ibox-content">
                        <div>
                            <style>
                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                            </style>

                             <?php 

                                 $db->where('gp_status','1');
                                 $db->where("flag",'0');
                                 $db->orderBy("mer_map_id","asc");
                                 $merchantDet = $db->get("merchants");
                             ?>

                            <form action=""  method="POST" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3  mrb-15">
                                            <!-- <label>Merchant ID</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_id" id="pg_merchant_id">
                                         </div> -->

                                          <label>Merchant_Id</label><BR>
                                          <select name="pg_merchant_id" class="form-control" id="merchantid">
                                                <option value="">Select</option>
                                                    <?php
                                                     foreach ($merchantDet as $key => $value) {
                                                     echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>';
                                                    }
                                                    
                                                    ?>
                                           </select>
                                        </div>
                                        <div class="col-sm-3  mrb-15">
                                          <label>Terminal_Id</label><BR>
                                          <select name="pg_terminal_id" class="form-control" id="pg_terminal_id">
                                                  <option value="">-- Terminal ID --</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal_Status</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_status1" readonly id="pg_terminal_status1" value="">
                                        </div>
                                        <div class="ibox-content">
                                         <div class="col-sm-9 col-md-9 col-lg-9">
                                            <div class="view">
                                                <div class="col-sm-3 mrb-15">
                                                    <label>Terminal_Change_Status</label><BR>
                                                        <div>
                                                            <select name="pg_terminal_status" class="form-control" id="pg_terminal_status" >
                                                               <option class="level-0"  value="1" >Active</option>
                                                               <option class="level-1"  value="2" >In-Active</option>
                                                            </select>
                                                        </div>
                                                        <input class="form-control" type="hidden" name="pg_terminal_action" id="pg_terminal_action" value="3">
                                                </div><br>
                                                &nbsp; &nbsp; <input type="submit" name="submit" class="btn btn-warning" value="Submit"><BR>
                                            </div>
                                        </div> <br><br>
                                      <div>
                            </form>
                        </div>
                <?php } ?>
                    </div>


                </div>

            </div>

        </div>
<?
require_once('footerjs.php'); ?>


<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>

// jquery

function merchant() {
    var pg_merchant_id=document.getElementById('pg_merchant_id').value;
    var pg_merchant_name=document.getElementById('pg_merchant_name').value;
    var pg_merchant_start_date=document.getElementById('pg_merchant_start_date').value;
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



<script type="text/javascript">


 $(document).ready(function(){
    $("#pg_merchant_id").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue==0){
                $("#pg_merchant_status1").val('');
                 $(".view").hide();
            } else{
                $(".view" ).show();
               
            }
        });
    }).change();
});



$(document).ready(function(){

        $("#merchantid").change(function(){
          var empty =$(this).val();
           if (!empty) {
                        $('#pg_terminal_id').val('');
                        $('#pg_terminal_status1').val('');
                        $(".view" ).hide(); 
                        $('#pg_terminal_id').empty();
                        var newOption = $('<option value="">-- Terminal ID --</option>');
                         $('#pg_terminal_id').append(newOption);
                          //$('#pg_terminal_status').empty();
                    } 
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'getmerchant'})
                })
                .done(function( msg ) {
                    console.log(msg);
                     //var msg = '<option value="">-- Terminal ID --</option>';
                    $("#pg_terminal_id").html(msg);
                    $('#pg_terminal_status1').val('');
                    $(".view" ).hide(); 


                });
            }
        });

});
$(document).ready(function(){
        $("#pg_terminal_id").change(function(){
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'t_id': $(this).val(), 'type':'terminalstatus'})
                })
                .done(function( msg ) {
                    console.log(msg);
                     //var msg = '<option value="">-- Terminal ID --</option>';
                     //var msg = '<option value="">-- Terminal ID --</option>';
                   if(msg==1) {
                         terminalact="Active";
                         $("#pg_terminal_status1").val(terminalact);
                         $('option[class="level-0"]').hide();
                         $('option[class="level-1"]').show();
                         $('option[class="level-1"]').attr("selected",true);
                         $('option[class="level-0"]').attr("selected",false);
                    } else  {
                            terminalinact="In-Active";
                            $("#pg_terminal_status1").val(terminalinact);
                            $('option[class="level-1"]').hide();
                            $('option[class="level-0"]').show();
                            $('option[class="level-0"]').attr("selected",true);
                            $('option[class="level-1"]').attr("selected",false);
                   }
                });
            }
        });

});

$(document).ready(function(){
    $("#pg_terminal_id").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue==0) {
                     $(".view").hide();
                     $("#pg_terminal_status1").val('');
            } else {
                     $(".view" ).show();  
            }
        });
    }).change();
});

</script>





<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

