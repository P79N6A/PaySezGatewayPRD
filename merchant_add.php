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

                        <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p>


                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                            if($_POST) {
                                // echo "<pre>";
                                // print_r($_POST); 
                                // exit;
                                // require_once('api/alipaymerchantAPI.php');
                                // $results = merchantandterminalchecking($_POST);
                                $results = merchantaddupdatestatus($_POST, $_POST['pg_merchant_action'],'');
                                $results_enc = json_encode($results);
                                $results_dec = json_decode($results_enc);
                                echo $results_dec->ResponseDesc;
                                echo "<br><br>";
                                echo "<a href='merchant_add.php'>CREATE ANOTHER MERCHANT</a>";
                            } else {
                            ?>
                            <style>
                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                            </style>
                            <form action="#" onsubmit="return merchant()" autocomplete="off" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant ID</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_id" id="pg_merchant_id">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Name</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_name" id="pg_merchant_name">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Start Date</label><BR>
                                            <div class="input-group date datesummary">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input class="form-control" name="pg_merchant_start_date" id="pg_merchant_start_date" type="text" value="<?php echo date('m/d/Y'); ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Address1</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_address1" id="pg_merchant_address1">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Address2</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_address2" id="pg_merchant_address2">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat City</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_city" id="pg_merchant_city">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat State</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_state" id="pg_merchant_state">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Country</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_country" id="pg_merchant_country">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Postalcode</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_postalcode" id="pg_merchant_postalcode">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Phone</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_phone" id="pg_merchant_phone">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Email</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_email" id="pg_merchant_email">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Mcc</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_mcc" id="pg_merchant_mcc">
                                        </div>
                                         <div class="col-sm-3 mrb-15">
                                            <label>Merchat Ifsccode</label><BR>
                                            <input class="form-control" type="text" name="pg_ifsccode" id="pg_ifsccode">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Accountno</label><BR>
                                            <input class="form-control" type="text" name="pg_accountno" id="pg_accountno">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Currency</label><BR>
                                            <select name="pg_merchant_currency" class="form-control" id="pg_merchant_currency">
                                                <option value="0">Select</option>
                                                <option value="USD">USD</option>
                                                <option value="LKR">LKR</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchat Status</label><BR>
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

                                        <div class="col-sm-4 mrb-15">
                                            <label>Merchat Permission</label><BR>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission1" value="1" checked>Purchase</label>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission2" value="1" checked>Cancel</label>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission3" value="1" checked>Query</label>
                                            <label class="checkbox-inline"><input type="checkbox" name="Permission4" value="1" checked>Refund</label>
                                        </div>
                                        
                                    </div>
                                </div>
                                &nbsp; &nbsp; <input type="submit" class="btn btn-warning" value="Submit"><BR>
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
$('#pg_merchant_id').on('change', function() {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = $('#pg_merchant_id').val();
    $.ajax({
        url: "php/inc_reportsearch1.php",
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
                $("#pg_merchant_id").val("");
            }
        },
        error: function(data){
            //error
        }
    });
});

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

	if(pg_merchant_phone == "")	{
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

    if (!(/^[0-9]+$/.test(document.getElementById('pg_merchant_mcc').value))) 	{
        swal(" Merchant_Mcc contains only number!");
        return false;
    }

	if(pg_ifsccode == "")	{
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
    // 	$('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

