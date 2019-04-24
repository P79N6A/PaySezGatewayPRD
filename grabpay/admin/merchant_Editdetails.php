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

                        <h5>MERCHANT_DETAILS </h5>
                        
                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->
                            <?php if($_POST) {?>
                            <button id="topright" class="btn btn-warning" onclick="location.href='dashboard.php'">Home</button>
                            <?php } ?>

                            <?php if(!$_POST) {?>
                            <button id="topright" class="btn btn-warning" onclick="location.href='dashboard.php'">Home</button>
                            &nbsp;<a href="listmerchants.php"><button id="topright1" class="btn btn-warning">Back</button></a>
                            <?php } ?>
                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php

                            if ($_GET) {
                                $myData = json_decode( base64_decode( $_GET['m_id']));
                                 $merchant_details = "SELECT * FROM merchants WHERE mer_map_id = '$myData'";
                                 $pre_merchants_status = $db->rawQuery($merchant_details);
                                 // echo "<pre>";
                                 $Permission_status =  $pre_merchants_status[0]['pcrq'];
                                 $Permission = explode('~', $Permission_status);

                                  
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
                                // require_once('api/alipaymerchantAPI.php');
                                // $results = merchantandterminalchecking($_POST);
                                $results = merchantaddupdatestatus($_POST, $_POST['pg_merchant_action'],$pre_merchants_status[0]['idmerchants']);
                                $results += array("user" => $_SESSION['username']);
                                $results_enc = json_encode($results);
                                $results_dec = json_decode($results_enc);

                                $_SESSION['descrtn'] = $results_dec->ResponseDesc;
                                if($_SESSION['descrtn']!='') {
                                $logs = "Merchant Update Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
                                poslogs($logs);
                            }
                                echo $results_dec->ResponseDesc;
                                echo "<br><br>";
                                echo "<a href='listmerchants.php'> LIST MERCHANT</a>";
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
                                            <label>Merchant ID</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_id"  id="pg_merchant_id" value="<?php echo $pre_merchants_status['0']['mer_map_id'] ?>" readonly>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Grab_Merchant ID</label><BR>
                                            <input class="form-control" type="text" name="grab_merchant_id"  id="grab_merchant_id" value="<?php echo $pre_merchants_status['0']['grab_merchant_id'] ?>" readonly>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Name</label><BR>
                                            <input class="form-control"   type="text" name="pg_merchant_name" id="pg_merchant_name" value="<?php echo $pre_merchants_status['0']['merchant_name'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Start Date</label><BR>
                                            <div class="input-group date datesummary">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input class="form-control" name="pg_merchant_start_date" id="pg_merchant_start_date" type="text"  value="<?php echo strftime('%Y-%m-%d',
                                                    strtotime($pre_merchants_status['0']['start_date'])); ?>">
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-3 mrb-15"> -->
                                        <!-- <input type="hidden"  name="gp_status" value="1" > -->
                                        <!-- </div> -->
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Address1</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_address1"  id="pg_merchant_address1" value="<?php echo $pre_merchants_status['0']['address1'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Address2</label><BR>
                                            <input class="form-control"   type="text" name="pg_merchant_address2" id="pg_merchant_address2" value=" <?php echo $pre_merchants_status['0']['address2'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant City</label><BR>
                                            <input class="form-control"  type="text" name="pg_merchant_city" id="pg_merchant_city" value="<?php echo $pre_merchants_status['0']['city'] ?>">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant State</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_state"   id="pg_merchant_state" value="<?php echo $pre_merchants_status['0']['us_state'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Country</label><BR>
                                            <input class="form-control"   type="text" name="pg_merchant_country" id="pg_merchant_country" value="<?php echo  $pre_merchants_status['0']['country'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Postalcode</label><BR>
                                            <input class="form-control"   type="text" name="pg_merchant_postalcode" id="pg_merchant_postalcode" value="<?php echo  $pre_merchants_status['0']['zippostalcode'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Phone</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_phone"  id="pg_merchant_phone" value="<?php echo  $pre_merchants_status['0']['csphone'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Email</label><BR>
                                            <input class="form-control"   type="text" name="pg_merchant_email" id="pg_merchant_email" value="<?php echo $pre_merchants_status['0']['csemail'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Mcc</label><BR>
                                            <input class="form-control"  type="text" name="pg_merchant_mcc" id="pg_merchant_mcc" value="<?php  echo $pre_merchants_status['0']['mcc'] ?>" >
                                        </div>
                                         <div class="col-sm-3 mrb-15">
                                            <label>Merchant Ifsccode</label><BR>
                                            <input class="form-control"  readpnly type="text" name="pg_ifsccode" id="pg_ifsccode" value="<?php  echo $pre_merchants_details['0']['ifsccode'] ?>"  >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Accountno</label><BR>
                                            <input class="form-control" type="text" name="pg_accountno"   id="pg_accountno" value="<?php echo $pre_merchants_details['0']['accountno'] ?>" >
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Currency</label><BR>
                                            <select name="pg_merchant_currency" class="form-control"   id="pg_merchant_currency">
                                                <option value="0" <?php if( $pre_merchants_status['0']['currency_code']=="") echo 'selected="selected"'; ?> >Select</option>
                                                <option value="USD" <?php if($pre_merchants_status['0']['currency_code']=="USD") echo 'selected="selected"'; ?> >USD</option>
                                                <option value="SGD" <?php if($pre_merchants_status['0']['currency_code']=="SGD") echo 'selected="selected"'; ?> >SGD</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant Status</label><BR>
                                            <select name="pg_merchant_status" class="form-control"  readonly id="pg_merchant_status">
                                                <option value="0" <?php if($pre_merchants_status['0']['is_active']=="") echo 'selected="selected"'; ?> >Status</option>
                                                <option value="1" <?php if($pre_merchants_status['0']['is_active']=="1") echo 'selected="selected"'; ?> >Active</option>
                                                <option value="0" <?php if($pre_merchants_status['0']['is_active']=="0") echo 'selected="selected"'; ?>>In-Active</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="pg_merchant_action" id="pg_merchant_action" value="2">
                                        </div>
                                        <!-- <div class="col-sm-3 mrb-15">
                                            <label>Merchant Action</label><BR>
                                            <select name="pg_merchant_action" class="form-control"  id="pg_merchant_action">
                                                <option value="0">Action</option>
                                                <option value="1">Add</option>
                                                <option value="2">Update</option>
                                                <option value="3">Status</option>
                                            </select>
                                        </div> -->

                                        <div class="col-sm-5 mrb-15">
                                            <label>Merchant Permission</label><BR>
                                            <label class="checkbox-inline"><input type="checkbox"   name="Permission1" value="1"<?php echo ($Permission['0']=='1')?"checked" : "";?>   >Purchase</label>
                                            <label class="checkbox-inline"><input type="checkbox"  name="Permission2" value="1"   <?php echo ($Permission['1']=='1')?"checked" : "";?>    >Cancel</label>
                                            <label class="checkbox-inline"><input type="checkbox"  name="Permission3" value="1"  <?php echo ($Permission['2']=='1')?"checked" : "";?>    > Inquery</label>
                                            <label class="checkbox-inline"><input type="checkbox"  name="Permission4" value="1"  <?php echo ($Permission['3']=='1')?"checked" : "";?>   >Refund</label>
                                        </div>
                                        <div>
                                        <label>Merchant MDR</label><br>


                                        <?php if(!$MDR_cnt) {
                                            echo $MDR_cnt1;
                                           } else {
                                            echo "";
                                            } ?>
                                        
                                        </BR>
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

