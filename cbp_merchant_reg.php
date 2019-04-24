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

                        <h5>CREATE CBP MERCHANT </h5>

                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                                $db->where("cbp_status",'1');
                                $db->orderBy("mer_map_id","asc");
                                $merchantDet = $db->get("merchants");
                                $count_query = "SELECT COUNT(upi_status) FROM merchants WHERE upi_status != NULL";
                                $count = $db->rawQuery($count_query);
                                foreach ($count as $key => $value) {
                                    $count_val=$value;
                                }
                             ?>
                            <style>
                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                            </style>
                            <form method="POST">
                               <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <label>Merchant </label><BR>
                                                <select name="merchantid" class="form-control" id="merchantid">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($merchantDet as $key => $value) {
                                                        echo '<option value="'.$value['merchant_name'].'">'.$value['merchant_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                             </div>
                                    </div><br><br>
                            </form>
                             <div id="merchant_form">
                               <form id="form1" action="vpa_request.php" autocomplete="off" method="POST"  style="display: none;">
                                <input type="hidden" name="vendorId" id="vendorId" value="">
                                <input type="hidden" name="mer_id" id="mer_id" value="">

                                 <div class="row">
                                    <span>
                                    <div class="col-sm-12">
                                        <div class="col-sm-3 mrb-15">
                                            <label>TxnId</label><BR>
                                            <input class="form-control" type="text" readonly  name="txnId" id="txnId" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>TxnOrigin</label><BR>
                                            <input class="form-control" type="text" readonly required  name="txnOrigin" id="txnOrigin" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>MobileNumber</label><BR>
                                            <input class="form-control" type="text" name="mobileNumber" required id="mobileNumber" readonly value="">
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>FirstName</label><BR>
                                            <input class="form-control" type="text" readonly name="firstName" id="firstName" required value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>LastName</label><BR>
                                            <input class="form-control" type="text" readonly name="lastName" id="lastName" required value="">
                                        </div>
    
                                        <div class="col-sm-3 mrb-15">
                                            <label>MerchantVaddr</label><BR>
                                            <input class="form-control" type="text" name="merchantVaddr" id="merchantVaddr" readonly value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>MCC</label><BR>
                                            <input class="form-control" type="text" readonly name="mcc" id="mcc"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Email</label><BR>
                                            <input class="form-control" type="text" readonly name="email" id="email"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>PanNo</label><BR>
                                            <input class="form-control" type="text" readonly name="panNo" id="panNo"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>AadhaarNo</label><BR>
                                            <input class="form-control" type="text" readonly name="aadhaarNo" id="aadhaarNo" value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>AddressDetails</label><BR>
                                            <input class="form-control" type="text" name="addressDetails"  value="" id="addressDetails" readonly required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>AccountNumber</label><BR>
                                            <input class="form-control" type="text" name="accountNumber" id="accountNumber" readonly value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>City</label><BR>
                                            <input class="form-control" type="text" readonly name="city" id="city"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>State</label><BR>
                                            <input class="form-control" type="text" readonly name="state" id="state"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Country</label><BR>
                                            <input class="form-control" type="text" readonly name="country" id="country" value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Zipcode</label><BR>
                                            <input class="form-control" type="text" readonly name="zipcode" id="zipcode" value="" required>
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>AccountType</label><BR>
                                            <input class="form-control" type="text" name="accountType" id="accountType" value="" readonly  required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>IFSC</label><BR>
                                            <input class="form-control" type="text" name="ifsc" id="ifsc" value="" readonly  required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Req Type</label><BR>
                                            <input class="form-control" type="text" name="reqType" id="reqType" readonly value="" required>
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
                                        
                                    </div>
                                </div>
                                &nbsp; &nbsp; <input type="submit" class="btn btn-warning" value="Submit"><BR>
                                <br><br>
                            </span>
                            </form>
                                

                             </div>
                            <?php } ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    <?php


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

// jquery
$('#merchantid').on('change', function() {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = $('#merchantid').val();
    alert(mer_id);
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

