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

                        <h5>TERMINAL_DETAILS </h5>
                        
                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->
                            <?php if($_POST) {?>
                            <button id="topright" class="btn btn-warning" onclick="location.href='dashboard.php'">Home</button>
                            <?php } ?>

                            <?php if(!$_POST) {?>
                            <button id="topright" class="btn btn-warning" onclick="location.href='dashboard.php'">Home</button>
                            &nbsp;<a href="listterminals.php"><button id="topright1" class="btn btn-warning">Back</button></a>
                            <?php } ?>
                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php

                            if ($_GET) {
                                $myData = json_decode( base64_decode( $_GET['m_id']));
                                 $merchant_details = "SELECT * FROM terminal WHERE mso_terminal_id = '$myData'";
                                 $pre_merchants_status = $db->rawQuery($merchant_details);
                                 // echo "<pre>";
                                  
                                  $db->where('pg_merchant_id',$myData);
                                  $vendor_details = $db->get('vendor_config');
                                  // echo "<pre>";
                                  // print_r($vendor_details['0']);

                                  //print_r($vendor_details);

                                        $MDR_cnt = '';
                                        $i=0;
                                     if(!empty($vendor_details)){
                                        foreach ($vendor_details as $key => $value) {
                                        $i++;
                                        $firstExp = explode('|',$value['merchant_MDR']);
                                        $vendorId = $firstExp[0];
                                        $secondExp = explode('~',$firstExp[1]);
                                        // echo $vendorId.':'.$secondExp[0].'=>'.$secondExp[1];
                                        // echo "<br>";
                                        $db->where('id',$vendorId);
                                        $vendor_name =$db->getOne('merchant_MDR');
                                        // print_r($vendor_name);

                                        if($i==1){

                                            $MDR_cnt1.= '<div class="input-group"> 
                                              <span class="input-group-addon my-addon">
                                                <input type="checkbox" aria-label="..." id="'.$vendor_name['id'].'" name="'.$vendor_name['vendors'].'"  >&nbsp;'.$vendor_name['vendors'].'</span>
                                                <input type="text" class="form-control" aria-label="..." name="'.$vendor_name['vendors'].'" value="'.$secondExp[0].'" style="width: 150px;" id="Alipay">
                                             </div>';
                                         ?><input type="hidden" id="alipay" value="1">
                                         <?php
                                        } 
                                       if($i==2){
                                                $MDR_cnt1.= '<div class="input-group"> 
                                              <span class="input-group-addon my-addon">
                                                <input type="checkbox" aria-label="..." id="'.$vendor_name['id'].'" name="'.$vendor_name['vendors'].'"  >&nbsp;'.$vendor_name['vendors'].'</span>
                                                <input type="text" class="form-control" aria-label="..." name="'.$vendor_name['vendors'].'" value="'.$secondExp[0].'" style="width: 132px;" id="Grabpay">
                                             </div>';
                                            ?> <input type="hidden" id="grabpay" value="1">
                                            <?php
                                        }
                                    }
                                } else {
                                    $MDR_cnt="1";
                                }
                                   $merchant_details_new = "SELECT * FROM merchant_processors_mid WHERE mer_map_id='$myData'";
                                  $pre_merchants_details = $db->rawQuery($merchant_details_new);
                                
                            } 
                            if($_POST) {
                                // echo "<pre>";
                                // print_r($_POST);
                                // print_r($pre_merchants_status);
                                // die();
                                // require_once('api/alipaymerchantAPI.php');
                                // $results = merchantandterminalchecking($_POST);
                                $results = terminaladdupdatestatus($_POST, $_POST['pg_terminal_action'],$pre_merchants_status[0]['idmerchants']);
                                $results += array("user" => $_SESSION['username']);
                                $results_enc = json_encode($results);
                                $results_dec = json_decode($results_enc);

                                $_SESSION['descrtn'] = $results_dec->ResponseDesc;
                                if($_SESSION['descrtn']!='') {
                                $logs = "Terminal Update Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
                                poslogs($logs);
                            }
                                echo $results_dec->ResponseDesc;
                                echo "<br><br>";
                                echo "<a href='listterminals.php'> LIST TERMINALS</a>";
                            } else {
                            ?>
                            <style>

                                /*input[type="checkbox"][readonly] {
                                        pointer-events: none;
                                    }*/
                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                                .SmallInput 
                                { width: 47px; height: 30px; }

                                #topright {
                                      position: absolute;
                                      top: 8px;
                                      right: 16px;
                                      font-size: 13px;
                                    }
                                #topright1 {
                                      position: absolute;
                                      top: 8px;
                                      right: 85px;
                                      font-size: 13px;
                                    }
                                #mdr1 {
                                border:grey;
                                border-left:10px #ccc;
                                background:#eee;
                                padding:3px; margin:2px;
                             }
                            </style>
                          <form action="#" onsubmit="return merchant()" autocomplete="off" method="POST">
                               <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal ID</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_id" readonly id="pg_terminal_id" value="<?php echo $pre_merchants_status['0']['mso_terminal_id'] ?>">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Grab_Terminal ID</label><BR>
                                            <input class="form-control" type="text" name="grab_terminal_id" readonly id="grab_terminal_id" value="<?php echo $pre_merchants_status['0']['grab_terminal_id'] ?>">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal Address</label><BR>
                                            <input class="form-control"  type="text" name="pg_terminal_address" id="pg_terminal_address" value="<?php echo $pre_merchants_status['0']['mso_ter_location'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal State</label><BR>
                                            <input class="form-control"  type="text" name="pg_terminal_state" id="pg_terminal_state" value="<?php echo $pre_merchants_status['0']['mso_ter_state_code'] ?>" >
                                        </div>
                                        <!-- <div class="col-sm-3 mrb-15"> -->
                                        <!-- </div> -->
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal City</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_city"  id="pg_terminal_city" value="<?php echo $pre_merchants_status['0']['mso_ter_city_name'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal Pincode</label><BR>
                                            <input class="form-control"  type="text" name="pg_terminal_pincode" id="pg_terminal_pincode" value=" <?php echo $pre_merchants_status['0']['mso_ter_pincode'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal IMEI No</label><BR>
                                            <input class="form-control" readonly type="text" name="pg_terminal_imei" id="pg_terminal_imei" value="<?php echo $pre_merchants_status['0']['imei'] ?>">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal Status</label><BR>
                                            <select name="pg_merchant_status" class="form-control" readonly id="pg_merchant_status">
                                                <option value="0" <?php if($pre_merchants_status['0']['active']=="") echo 'selected="selected"'; ?> >Status</option>
                                                <option value="1" <?php if($pre_merchants_status['0']['active']=="1") echo 'selected="selected"'; ?> >Active</option>
                                                <option value="0" <?php if($pre_merchants_status['0']['active']=="0") echo 'selected="selected"'; ?>>In-Active</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="pg_terminal_action" id="pg_terminal_action" value="2">
                                        </div>
                                        <!-- <div class="col-sm-3  mrb-15">
                                            <label>Terminal Action</label><BR>
                                            <select name="pg_terminal_action" class="form-control" id="pg_terminal_action">
                                                <option value="" selected="selected">Action</option>
                                                <option value="1">Add</option>
                                                <option value="2">Update</option>
                                                <option value="3">Status</option>
                                            </select>
                                        </div> -->
                                    </div>
                                </div>
                                &nbsp; &nbsp; <input type="submit" class="btn btn-warning" value="Submit"> &nbsp;  
                                <BR>
                                <br><br>
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

    echo '<a href="testspaysez/login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>


<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>

// jquery

document.getElementById('1').onchange = function() {
    document.getElementById('Alipay').disabled = !this.checked;
};

document.getElementById('2').onchange = function() {
    document.getElementById('Grabpay').disabled = !this.checked;
};

// document.getElementById('1').onchange = function() {
//     document.getElementById('1').disabled = !this.checked;
// };

// document.getElementById('2').onchange = function() {
//     document.getElementById('2').disabled = !this.checked;
// };
function terminal() {
    
    var pg_terminal_id =document.getElementById('pg_terminal_id').value;
    var pg_terminal_address = document.getElementById('pg_terminal_address').value;
    var pg_terminal_state   = document.getElementById('pg_terminal_state').value;
    var pg_terminal_city=document.getElementById('pg_terminal_city').value;
    var pg_terminal_pincode=document.getElementById('pg_terminal_pincode').value;
    var pg_terminal_imei=document.getElementById('pg_terminal_imei').value;

    var e = document.getElementById("pg_terminal_status");
    var pg_terminal_status = e.options[e.selectedIndex].value;

    // var e1 = document.getElementById("pg_terminal_action");
    // var pg_terminal_action = e1.options[e1.selectedIndex].value;


    if(pg_terminal_id == "") {
        swal('Please Enter the Terminal Id');
        return false;
    }

    if(pg_terminal_id.length != 12) {
        swal(' Terminal Id should be of length 12');
        return false;
    }
    if(pg_terminal_imei == "") {
        swal('Please Enter the Terminal IMEI No');
        return false;
    }
    if(pg_terminal_imei.length != 15) {
        swal(' Terminal IMEI No should be of length 15');
        return false;
    }

    if(pg_terminal_address == "") {
        swal('Please Enter the Terminal_Address');
        return false;
    }

    if(pg_terminal_state == "") {
        swal('Please Enter the Terminal_State');
        return false;
    }

    if(pg_terminal_city == "") {
        swal('Please Enter the Terminal_City');
        return false;
    }

    if(pg_terminal_pincode == "") {
        swal('Please Enter the Terminal_Pincode');
        return false;
    }

    if(pg_terminal_status == 0) {
        swal('Please Enter the Merchant_Status');
        return false;
    }

    // if(pg_terminal_action == "") {
    //     swal('Please Enter the Terminal_Action');
    //     return false;
    // }

    // return false;


    // var pg_merchant_id = document.getElementById('pg_merchant_id').value;
    // var pg_terminal_id =document.getElementById('pg_terminal_id').value;
    // var pg_terminal_address = document.getElementById('pg_terminal_address').value;
    // var pg_terminal_state   = document.getElementById('pg_terminal_state').value;
    // var pg_terminal_city=document.getElementById('pg_terminal_city').value;
    // var pg_terminal_pincode=document.getElementById('pg_terminal_pincode').value;
    // var pg_merchant_status=document.getElementById('pg_merchant_status').value;
    // var pg_merchant_action=document.getElementById('pg_merchant_action').value;

    // alert(pg_merchant_id);

    // if(pg_merchant_id == "") {
    //     swal('Please Enter the Merchant_Id');
    //     document.getElementById('pg_merchant_id');
    //     return false
    // } else {
    //     document.getElementById('pg_merchant_id');
    // }

    // if(pg_terminal_id == "") {
    //     swal('Please Enter the Terminal_Id');
    //     document.getElementById('pg_terminal_id');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_id');
    // }

    // if(pg_terminal_id.length != 8) {
    //     swal(' Terminal_Id should be of length 8');
    //     document.getElementById("pg_terminal_id");
    //     return false;
    // } else {
    //     document.getElementById("pg_terminal_id");
    // }

    // if(pg_terminal_address == "") {
    //     swal('Please Enter the Terminal_Address');
    //     document.getElementById('pg_terminal_address');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_address');
    // }

    // if(pg_terminal_state == "") {
    //     swal('Please Enter the Terminal_State');
    //     document.getElementById('pg_terminal_state');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_state');
    // }

    // if(pg_terminal_city == "") {
    //     swal('Please Enter the Terminal_City');
    //     document.getElementById('pg_terminal_city');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_city');
    // }

    // if(pg_terminal_pincode == "") {
    //     swal('Please Enter the Terminal_Pincode');
    //     document.getElementById('pg_terminal_pincode');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_pincode');
    // }

    // if(pg_merchant_status == "") {
    //     swal('Please Enter the Merchant_Status');
    //     document.getElementById('pg_merchant_status');
    //     return false
    // } else {
    //     document.getElementById('pg_merchant_status');
    // }

    // if(pg_merchant_action == "") {
    //     swal('Please Enter the Merchant_Action');
    //     document.getElementById('pg_merchant_action');
    //     return false
    // } else {
    //     document.getElementById('pg_merchant_action');
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

        var alipay = $('#alipay').val();
        var grabpay = $('#grabpay').val();
        if(alipay==1){
            // $('#alipay_checkbox').show();
            $("#1").prop('checked', true);
        } else {
            $( "#1").prop('checked', false);
        }
        if(grabpay==1){
            $( "#2").prop('checked', true);
        } else {
            $( "#2").prop('checked', false);
        }


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
    // 	$('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

