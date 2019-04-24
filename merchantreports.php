<?php
require_once('header.php');

//check permission
/*if(!checkPermission('M'))
    include_once('forbidden.php');
*/
//include 'php/inc_reports.php';
$vars = 1;
require_once('php/inc_chart-view.php');
//https://github.com/xdan/datetimepicker/blob/master/index.html
if(isset($_SESSION['iid'])){
	$iid = $_SESSION['iid'];
}
ini_set('memory_limit', '-1');

$db->where("userid", $iid);
$mer_results = $db->getone("merchants");
$mer_currency = $mer_results['currency_code'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Reports</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Reports </strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>Filters</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
	
					<form  id="reports_form">
					
						<div class="row">
							<div class="col-md-2"><label>Start Date *</label><input class="form-control m-b" name="date_timepicker_start" id="date_timepicker_start" type="text" value="" required /></div>
							<div class="col-md-2"><label>End Date *</label><input class="form-control m-b" name="date_timepicker_end" id="date_timepicker_end" type="text" value="" required /></div>
						<!--	<div class="col-md-2">
								<label>Processor</label>
								<div id="processoridbox">
								<select class="form-control m-b" name="processorid" id="processorid">
									<option value="0">-- All Processor --</option>
									<?php foreach($user_processors as $user_processor) { ?>
										<option value="<?php echo $user_processor['p_id']; ?>"><?php echo $user_processor['processor_name']; ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
							<div class="col-md-2">
								<label>Card Types</label>
								<select class="form-control m-b" name="card_types" id="card_types">
									<option   value="0">-- All Card Types --</option>
									<option  value="visa">Visa</option>
									<option  value="mastercard">Mastercard</option>
									<option  value="amex">AMEX</option>
									<option  value="maestro">Maestro</option>
									<option  value="jcb">JCB</option>
									<option  value="rupay">Rupay</option>
								</select>
							</div>  -->
							<div class="col-md-2">
								<label>Currencies</label>
								<select class="form-control m-b" name="currencies" id="currencies">
								<option value="0" selected="selected"><?php echo $mer_currency; ?></option>
								<!-- <option value="USD">USD</option>
			                    <option value="SGD">SGD</option>
			                    <option value="MYR">MYR</option>
			                    <option value="LKR">LKR</option> -->
								<!--	<option value="CAD">CAD</option>
								<option value="EUR">EUR</option>
								<option value="GBR">GBP</option>
								<option id="inr" value="356">INR</option> -->
								</select>
							</div>
							<div class="col-md-2">
								<label>Transaction Type</label>
								<select class="form-control m-b" name="transaction_type" id="transaction_type">
									<option value="0" selected="selected">-- All Types-- </option>
									<option value="sale">Sale</option>
									<option value="refund">Refund</option>
									<option value="cancel">Cancel</option>
								
								</select>
							</div>
							<!--<div class="col-md-2">
								<label>Bin</label>
								<select class="form-control m-b" name="bin" id="bin">
									<option value="0">-- All Bin --</option>
									<option>Top 10</option>
									<option>Top 15</option>
									<option>Top 25</option>
									<option>Top 50</option>
									<option>Top 100</option>
									<option>Top 250</option>
								</select>
							</div>-->
							<div class="col-md-2">
							  <label>&nbsp;</label>
							  <!-- onclick="showReport('true')" -->
							  <button class="btn btn-primary btn-lg btn-block reportsearch" type="button"><i class="fa fa-check"></i>&nbsp;Submit</button>
							</div>
						</div>
						<div class="row">
							<!--<div class="col-md-2">
								<label>Recurring</label>
								<select class="form-control m-b" name="recurring" id="recurring">
									<option value="0">-- All --</option>
									<option>1st</option>
									<option>2nd</option>
									<option>3rd</option>
									<option>4th</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Agents</label>
								<select class="form-control m-b" name="agents" id="agents">
									<option value="0">-- All Agents --</option>
									<?php if($user_agent != "") { ?>
											<option value="<?php echo $user_agent; ?>"><?php echo $user_agent_name; ?></option>
											<?php foreach($user_subagents as $user_subagent) { ?>
												<option value="<?php echo $user_subagent['id']; ?>"><?php echo $user_subagent['agentname']; ?></option>
											<?php } 
										} elseif($user_type == 1) { 
											 foreach($user_subagents as $user_subagent) { ?>
												<option value="<?php echo $user_subagent['idagents']; ?>"><?php echo $user_subagent['agentname']; ?></option>
											<?php }
										} ?>
								</select>
							</div>
							<div class="col-md-2">
								<label>Merchants</label>
								<div id="merchantsbox">
								<select class="form-control m-b" name="merchants" id="merchants">
									<option value="0">-- All Merchants --</option>
									<?php foreach($user_merchants as $user_merchant) { ?>
										<option value="<?php echo $user_merchant['idmerchants']; ?>"><?php echo $user_merchant['merchant_name']; ?></option>
									<?php } ?>
								</select>
								</div>
							</div>-->
							<?php //getOptions($_SESSION['iid']); ?>
							<!--<div class="col-md-2">
								<label>MID</label>
								<select class="form-control m-b" name="mid" id="mid">
									<option value="0">-- All MID --</option>
								</select>
							</div>-->
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>Results</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
							</a>
					</div>
				</div>
				<div class="ibox-content">
					<div id="reportresults">
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="display:none;">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>Charts</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="panel blank-panel">
						<div class="panel-heading">
							<div class="panel-options">
								<ul class="nav nav-tabs">
									<li class="active">
										<a data-toggle="tab" href="#tab-1" onclick="showAgent('affinfo')" aria-expanded="true">Sales & Refunds</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-2" onclick="showAgent2('accinfo')"  id="chartquery2" aria-expanded="false">Transaction Count</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-3" onclick="showAgent3('processors')"  id="chartquery3" aria-expanded="true">Charge Backs</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-4" onclick="showAgent4('fee')" id="chartquery4" aria-expanded="false">Charge Back Ratio By Volume</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-5" onclick="showagentt('affstatus')" id="chartquery" aria-expanded="false">Transaction Amount</a>
									</li>

								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content" id="tab-content">
                                <div id="" style="height: 300px; width: 100%;">
							<?php echo getAffInfo($_SESSION['iid']); ?>
							<input type="hidden" name="" value="<?php echo $volume[0]['numsalemc']; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

</div>


<!-- this should go after your </body> -->
<link rel="stylesheet" type="text/css" href="js/datetimepicker/jquery.datetimepicker.css"/ >
<script src="js/datetimepicker/jquery.datetimepicker.js"></script> 


<script>

$(document).ready(function() {
	$("#currencies").prop("disabled", true);
});

    function showAgent2(str2) {
       
			 									
                        $("#tab-content").html('<div class="panel panel-primary"><div class="panel-heading">Agent Information</div><div class="panel-body"><div class="chosen-container chosen-container-single"><div class="ibox float-e-margins"><div class="ibox-content"><label>Select option to view Transaction Count</label><select  id="security_question_1" class="form-control m-b" name="security_question_1"  onchange="myfunction();"><option selected>Select</option><option  value="1">Today</option><option  value="7">Last 7 Days</option><option value="30">Last 30 Days</option><option value="60">Last 60 Days</option></select></div></div></div><div class="tab-contents" id="tab-contents"><div id="" style="height: 300px; width: 100%;"></div></div></div></div>'); }
</script>
<script>
			function myfunction(){
				
				var selectvalue = $( "#security_question_1" ).val();
				
				//alert(selectvalue);
            
			
			var datetstart = $( "#date_timepicker_start" ).val();
			var datetend = $( "#date_timepicker_end" ).val();	
			var currencies = $( "#currencies" ).val();
			var ttype = $( "#transaction_type" ).val();			
			var bin = $( "#bin" ).val();
			
				 $.ajax({
                    method: "POST",
                    url: "php/inc_chartquery21.php",
                    data:  {'datetstartt': datetstart, 'datetendd': datetend,  'currenciess': currencies, 'ttypee': ttype, 'binn': bin,'selectvaluee': selectvalue }
                })
                    .done(function( msg ) {										
                        $("#tab-contents").html(msg);						
					
                    });
					
					if(selectvalue == 1){
					     setTimeout(function() {  lineviewchart1(); }, 500);	
					}
					else if(selectvalue == 7){
						
						 setTimeout(function() {  lineviewchart1(); }, 1500);	
					     setTimeout(function() {  lineviewchart2(); }, 2000);	
					     setTimeout(function() {  lineviewchart3(); }, 2500);	
					     setTimeout(function() {  lineviewchart4(); }, 3000);	
					     setTimeout(function() {  lineviewchart5(); }, 3500);	
					     setTimeout(function() {  lineviewchart6(); }, 4000);	
					     setTimeout(function() {  lineviewchart7(); }, 4500);	
					}
					else if(selectvalue == 30){
						
						setTimeout(function()  {  lineviewchart1(); }, 5500);	
					     setTimeout(function() {  lineviewchart2(); }, 6000);	
					     setTimeout(function() {  lineviewchart3(); }, 6500);	
					     setTimeout(function() {  lineviewchart4(); }, 7000);	
					     setTimeout(function() {  lineviewchart5(); }, 7500);	
					     setTimeout(function() {  lineviewchart6(); }, 8000);	
					     setTimeout(function() {  lineviewchart7(); }, 9000);	
					     setTimeout(function() {  lineviewchart8(); }, 10000);	
					     setTimeout(function() {  lineviewchart9(); }, 10500);	
					     setTimeout(function() {  lineviewchart10(); }, 11000);	
					     setTimeout(function() {  lineviewchart11(); }, 11500);	
					     setTimeout(function() {  lineviewchart12(); }, 12000);	
					     setTimeout(function() {  lineviewchart13(); }, 12500);	
					     setTimeout(function() {  lineviewchart14(); }, 13000);	
					     setTimeout(function() {  lineviewchart15(); }, 13500);	
					     setTimeout(function() {  lineviewchart16(); }, 14000);	
					     setTimeout(function() {  lineviewchart17(); }, 14500);	
					     setTimeout(function() {  lineviewchart18(); }, 15000);	
					     setTimeout(function() {  lineviewchart19(); }, 15500);	
					     setTimeout(function() {  lineviewchart20(); }, 16000);	
					     setTimeout(function() {  lineviewchart21(); }, 16500);	
					     setTimeout(function() {  lineviewchart22(); }, 17000);	
					     setTimeout(function() {  lineviewchart23(); }, 17500);	
					     setTimeout(function() {  lineviewchart24(); }, 18000);	
					     setTimeout(function() {  lineviewchart25(); }, 18500);	
					     setTimeout(function() {  lineviewchart26(); }, 19000);	
					     setTimeout(function() {  lineviewchart27(); }, 19500);	
					     setTimeout(function() {  lineviewchart28(); }, 20000);	
					     setTimeout(function() {  lineviewchart29(); }, 25000);	
					     setTimeout(function() {  lineviewchart30(); }, 30000);	
					   
					}
					else if(selectvalue == 60){
						setTimeout(function()  {  lineviewchart1(); }, 40000);	
					     setTimeout(function() {  lineviewchart2(); }, 40500);	
					     setTimeout(function() {  lineviewchart3(); }, 41000);	
					     setTimeout(function() {  lineviewchart4(); }, 41500);	
					     setTimeout(function() {  lineviewchart5(); }, 42000);	
					     setTimeout(function() {  lineviewchart6(); }, 42500);	
					     setTimeout(function() {  lineviewchart7(); }, 43000);	
					     setTimeout(function() {  lineviewchart8(); }, 43500);	
					     setTimeout(function() {  lineviewchart9(); }, 44000);	
					     setTimeout(function() {  lineviewchart10(); }, 44500);	
					     setTimeout(function() {  lineviewchart11(); }, 45000);	
					     setTimeout(function() {  lineviewchart12(); }, 45500);	
					     setTimeout(function() {  lineviewchart13(); }, 46000);	
					     setTimeout(function() {  lineviewchart14(); }, 46500);	
					     setTimeout(function() {  lineviewchart15(); }, 47000);	
					     setTimeout(function() {  lineviewchart16(); }, 47500);	
					     setTimeout(function() {  lineviewchart17(); }, 48000);	
					     setTimeout(function() {  lineviewchart18(); }, 48500);	
					     setTimeout(function() {  lineviewchart19(); }, 49000);	
					     setTimeout(function() {  lineviewchart20(); }, 49500);	
					     setTimeout(function() {  lineviewchart21(); }, 50000);	
					     setTimeout(function() {  lineviewchart22(); }, 50500);	
					     setTimeout(function() {  lineviewchart23(); }, 51000);	
					     setTimeout(function() {  lineviewchart24(); }, 51500);	
					     setTimeout(function() {  lineviewchart25(); }, 52000);	
					     setTimeout(function() {  lineviewchart26(); }, 52500);	
					     setTimeout(function() {  lineviewchart27(); }, 53000);	
					     setTimeout(function() {  lineviewchart28(); }, 53500);	
					     setTimeout(function() {  lineviewchart29(); }, 54000);
						 setTimeout(function() {  lineviewchart30(); }, 54500);	
					     setTimeout(function() {  lineviewchart31(); }, 55000);	
					     setTimeout(function() {  lineviewchart32(); }, 55500);	
					     setTimeout(function() {  lineviewchart33(); }, 56000);	
					     setTimeout(function() {  lineviewchart34(); }, 56500);	
					     setTimeout(function() {  lineviewchart35(); }, 57000);	
					     setTimeout(function() {  lineviewchart36(); }, 57500);	
					     setTimeout(function() {  lineviewchart37(); }, 58000);	
					     setTimeout(function() {  lineviewchart38(); }, 58500);	
					     setTimeout(function() {  lineviewchart39(); }, 59000);	
					     setTimeout(function() {  lineviewchart40(); }, 59500);	
					     setTimeout(function() {  lineviewchart41(); }, 60000);	
					     setTimeout(function() {  lineviewchart42(); }, 60500);	
					     setTimeout(function() {  lineviewchart43(); }, 61000);	
					     setTimeout(function() {  lineviewchart44(); }, 61500);	
					     setTimeout(function() {  lineviewchart45(); }, 62000);	
					     setTimeout(function() {  lineviewchart46(); }, 62500);	
					     setTimeout(function() {  lineviewchart47(); }, 63000);	
					     setTimeout(function() {  lineviewchart48(); }, 63500);	
					     setTimeout(function() {  lineviewchart49(); }, 64000);	
					     setTimeout(function() {  lineviewchart50(); }, 64500);	
					     setTimeout(function() {  lineviewchart51(); }, 65000);	
					     setTimeout(function() {  lineviewchart52(); }, 65500);	
					     setTimeout(function() {  lineviewchart53(); }, 66000);	
					     setTimeout(function() {  lineviewchart54(); }, 66500);	
					     setTimeout(function() {  lineviewchart55(); }, 67000);	
					     setTimeout(function() {  lineviewchart56(); }, 67500);	
					     setTimeout(function() {  lineviewchart57(); }, 68000);	
					     setTimeout(function() {  lineviewchart58(); }, 68500);
					     setTimeout(function() {  lineviewchart59(); }, 69000);
					     setTimeout(function() {  lineviewchart60(); }, 69500);
						
					}
					
					
					
					
					/*var x;
				   //for( x=1; x<=selectvalue; x++) 
					{
						
						//var test_id = x; 
						
					//alert(test_id);
					//setTimeout(function() {	eval('lineviewchart'+x+'()'); }, 1000);
					setTimeout(function() {	this['lineviewchart'+x]();}, 1000);
					//setTimeout(function() {  lineviewchart(); }, 1000);
					}
					
					
					/*<?php for($i=1;$i<=7; $i++){?>
					  setTimeout(function() {  lineviewchart<?php echo $i; ?>(); }, 1000);
					<?php }?>
				*/
			}
		
			
			</script>
						
<script>
    function showagentt(str5) {
		
		$("#tab-content").html('<div class="panel panel-primary"><div class="panel-heading">Agent Information</div><div class="panel-body"><div class="chosen-container chosen-container-single"><div class="ibox float-e-margins"><div class="ibox-content"><label>Select option to view Transaction Count</label><select  id="security_question_1" class="form-control m-b" name="security_question_1"  onchange="myfunctionn();"><option selected>Select</option><option  value="1">Today</option><option  value="7">Last 7 Days</option><option value="30">Last 30 Days</option><option value="60">Last 60 Days</option></select></div></div></div><div class="tab-contents" id="tab-contents"><div id="" style="height: 300px; width: 100%;"></div></div></div></div>');

		}
        

	
        </script>
			<script>
			function myfunctionn(){
				
					var selectvalue = $( "#security_question_1" ).val();
				
			
			
			var datetstart = $( "#date_timepicker_start" ).val();
			var datetend = $( "#date_timepicker_end" ).val();
			var currencies = $( "#currencies" ).val();
			var ttype = $( "#transaction_type" ).val();
			var bin = $( "#bin" ).val();
			
       
               $.ajax({
                    method: "POST",
                    url: "php/inc_chartqueryss.php",
                    data:  {'datetstartt': datetstart, 'datetendd': datetend,  'currenciess': currencies, 'ttypee': ttype, 'binn': bin,'selectvaluee': selectvalue}
                })
                    .done(function( msg ) {										
                        $("#tab-contents").html(msg);
                    });
            	
			
			
            //setTimeout(function() {  piechart3(); }, 1000);
			
			
			
					if(selectvalue == 1){
					     setTimeout(function() {  piechart1(); }, 500);	
					}
					else if(selectvalue == 7){
						
						 setTimeout(function() {  piechart1(); }, 1500);	
					     setTimeout(function() {  piechart2(); }, 2000);	
					     setTimeout(function() {  piechart3(); }, 2500);	
					     setTimeout(function() {  piechart4(); }, 3000);	
					     setTimeout(function() {  piechart5(); }, 3500);	
					     setTimeout(function() {  piechart6(); }, 4000);	
					     setTimeout(function() {  piechart7(); }, 4500);	
					}
					else if(selectvalue == 30){
						
						setTimeout(function()  {  piechart1(); }, 5500);	
					     setTimeout(function() {  piechart2(); }, 6000);	
					     setTimeout(function() {  piechart3(); }, 6500);	
					     setTimeout(function() {  piechart4(); }, 7000);	
					     setTimeout(function() {  piechart5(); }, 7500);	
					     setTimeout(function() {  piechart6(); }, 8000);	
					     setTimeout(function() {  piechart7(); }, 9000);	
					     setTimeout(function() {  piechart8(); }, 10000);	
					     setTimeout(function() {  piechart9(); }, 10500);	
					     setTimeout(function() {  piechart10(); }, 11000);	
					     setTimeout(function() {  piechart11(); }, 11500);	
					     setTimeout(function() {  piechart12(); }, 12000);	
					     setTimeout(function() {  piechart13(); }, 12500);	
					     setTimeout(function() {  piechart14(); }, 13000);	
					     setTimeout(function() {  piechart15(); }, 13500);	
					     setTimeout(function() {  piechart16(); }, 14000);	
					     setTimeout(function() {  piechart17(); }, 14500);	
					     setTimeout(function() {  piechart18(); }, 15000);	
					     setTimeout(function() {  piechart19(); }, 15500);	
					     setTimeout(function() {  piechart20(); }, 16000);	
					     setTimeout(function() {  piechart21(); }, 16500);	
					     setTimeout(function() {  piechart22(); }, 17000);	
					     setTimeout(function() {  piechart23(); }, 17500);	
					     setTimeout(function() {  piechart24(); }, 18000);	
					     setTimeout(function() {  piechart25(); }, 18500);	
					     setTimeout(function() {  piechart26(); }, 19000);	
					     setTimeout(function() {  piechart27(); }, 19500);	
					     setTimeout(function() {  piechart28(); }, 20000);	
					     setTimeout(function() {  piechart29(); }, 25000);	
					     setTimeout(function() {  piechart30(); }, 30000);	
					   
					}
					else if(selectvalue == 60){
						setTimeout(function()  {  piechart1(); }, 40000);	
					     setTimeout(function() {  piechart2(); }, 40500);	
					     setTimeout(function() {  piechart3(); }, 41000);	
					     setTimeout(function() {  piechart4(); }, 41500);	
					     setTimeout(function() {  piechart5(); }, 42000);	
					     setTimeout(function() {  piechart6(); }, 42500);	
					     setTimeout(function() {  piechart7(); }, 43000);	
					     setTimeout(function() {  piechart8(); }, 43500);	
					     setTimeout(function() {  piechart9(); }, 44000);	
					     setTimeout(function() {  piechart10(); }, 44500);	
					     setTimeout(function() {  piechart11(); }, 45000);	
					     setTimeout(function() {  piechart12(); }, 45500);	
					     setTimeout(function() {  piechart13(); }, 46000);	
					     setTimeout(function() {  piechart14(); }, 46500);	
					     setTimeout(function() {  piechart15(); }, 47000);	
					     setTimeout(function() {  piechart16(); }, 47500);	
					     setTimeout(function() {  piechart17(); }, 48000);	
					     setTimeout(function() {  piechart18(); }, 48500);	
					     setTimeout(function() {  piechart19(); }, 49000);	
					     setTimeout(function() {  piechart20(); }, 49500);	
					     setTimeout(function() {  piechart21(); }, 50000);	
					     setTimeout(function() {  piechart22(); }, 50500);	
					     setTimeout(function() {  piechart23(); }, 51000);	
					     setTimeout(function() {  piechart24(); }, 51500);	
					     setTimeout(function() {  piechart25(); }, 52000);	
					     setTimeout(function() {  piechart26(); }, 52500);	
					     setTimeout(function() {  piechart27(); }, 53000);	
					     setTimeout(function() {  piechart28(); }, 53500);	
					     setTimeout(function() {  piechart29(); }, 54000);
						 setTimeout(function() {  piechart30(); }, 54500);	
					     setTimeout(function() {  piechart31(); }, 55000);	
					     setTimeout(function() {  piechart32(); }, 55500);	
					     setTimeout(function() {  piechart33(); }, 56000);	
					     setTimeout(function() {  piechart34(); }, 56500);	
					     setTimeout(function() {  piechart35(); }, 57000);	
					     setTimeout(function() {  piechart36(); }, 57500);	
					     setTimeout(function() {  piechart37(); }, 58000);	
					     setTimeout(function() {  piechart38(); }, 58500);	
					     setTimeout(function() {  piechart39(); }, 59000);	
					     setTimeout(function() {  piechart40(); }, 59500);	
					     setTimeout(function() {  piechart41(); }, 60000);	
					     setTimeout(function() {  piechart42(); }, 60500);	
					     setTimeout(function() {  piechart43(); }, 61000);	
					     setTimeout(function() {  piechart44(); }, 61500);	
					     setTimeout(function() {  piechart45(); }, 62000);	
					     setTimeout(function() {  piechart46(); }, 62500);	
					     setTimeout(function() {  piechart47(); }, 63000);	
					     setTimeout(function() {  piechart48(); }, 63500);	
					     setTimeout(function() {  piechart49(); }, 64000);	
					     setTimeout(function() {  piechart50(); }, 64500);	
					     setTimeout(function() {  piechart51(); }, 65000);	
					     setTimeout(function() {  piechart52(); }, 65500);	
					     setTimeout(function() {  piechart53(); }, 66000);	
					     setTimeout(function() {  piechart54(); }, 66500);	
					     setTimeout(function() {  piechart55(); }, 67000);	
					     setTimeout(function() {  piechart56(); }, 67500);	
					     setTimeout(function() {  piechart57(); }, 68000);	
					     setTimeout(function() {  piechart58(); }, 68500);
					     setTimeout(function() {  piechart59(); }, 69000);
					     setTimeout(function() {  piechart60(); }, 69500);
						
					}
			
			
			}
			</script>
			

		<script>
		 function showAgent4(str4) {
        if (str4 == "") {
            document.getElementById("tab-content").innerHTML = "";
            return;
        } else {
			
			var datetstart = $( "#date_timepicker_start" ).val();
			var datetend = $( "#date_timepicker_end" ).val();
			var pid = $( "#processorid" ).val();
			var ctypes = $( "#card_types" ).val();
			var currencies = $( "#currencies" ).val();
			var ttype = $( "#transaction_type" ).val();
			var recurring = $( "#recurring" ).val();
			var agents = $( "#agents" ).val();
			var merchants = $( "#merchants" ).val();
			var mid = $( "#mid" ).val();
			var bin = $( "#bin" ).val();
			
           
		    $.ajax({
                    method: "POST",
                    url: "php/test.php",
                    data:  {'datetstart': datetstart, 'datetend': datetend, 'pid': pid, 'ctypes': ctypes, 'currencies': currencies, 'ttype': ttype, 'recurring': recurring, 'agents': agents, 'merchants': merchants, 'mid': mid, 'bin': bin}
                })
                    .done(function( msg ) {										
                        $("#tab-content").html(msg);
                    });
		   
		   
               $.ajax({
                    method: "POST",
                    url: "php/inc_chartquery4.php",
                    data:  {'datetstart': datetstart, 'datetend': datetend, 'pid': pid, 'ctypes': ctypes, 'currencies': currencies, 'ttype': ttype, 'recurring': recurring, 'agents': agents, 'merchants': merchants, 'mid': mid, 'bin': bin}
                })
                    .done(function( msg ) {										
                        $("#tab-content").html(msg);
                    });
            	
			setTimeout(function() {  callchart(); }, 1000);
            setTimeout(function() {  callchart2(); }, 1500);
			
						
			
        }
    }
		
		</script>
<script>
		 function showAgent3(str3) {
        if (str3 == "") {
            document.getElementById("tab-content").innerHTML = "";
            return;
        } else {
			
			var datetstart = $( "#date_timepicker_start" ).val();
			var datetend = $( "#date_timepicker_end" ).val();
			var pid = $( "#processorid" ).val();
			var ctypes = $( "#card_types" ).val();
			var currencies = $( "#currencies" ).val();
			var ttype = $( "#transaction_type" ).val();
			var recurring = $( "#recurring" ).val();
			var agents = $( "#agents" ).val();
			var merchants = $( "#merchants" ).val();
			var mid = $( "#mid" ).val();
			var bin = $( "#bin" ).val();
			
           
               $.ajax({
                    method: "POST",
                    url: "php/inc_chartquery3.php",
                    data:  {'datetstart': datetstart, 'datetend': datetend, 'pid': pid, 'ctypes': ctypes, 'currencies': currencies, 'ttype': ttype, 'recurring': recurring, 'agents': agents, 'merchants': merchants, 'mid': mid, 'bin': bin}
                })
                    .done(function( msg ) {										
                        $("#tab-content").html(msg);
                    });
            	
			setTimeout(function() {  linechart(); }, 1000);
            setTimeout(function() {  linechart2(); }, 1500);
            
						
			
        }
    }
		
		</script>
    <script>
        $(document).ready(function(){
            $('#date_timepicker_start').datetimepicker({
                    format:'Y-m-d H:i:s',
                    formatTime:'H:i:s',
                    formatDate:'Y-d-m'
                }
            );
            $('#date_timepicker_end').datetimepicker({
                format:'Y-m-d H:i:s',
                defaultTime:'00:00',
                formatTime:'H:i:s',
                formatDate:'Y-d-m'
            });

            $("#agents").change(function () {
                if($(this).val()){
                    $.ajax({
                        method: "POST",
                        url: "php/inc_agentmerchants.php",
                        data: { a_id: $(this).val(), u_id: <?php echo $iid; ?> }
                    })
                        .done(function( msg ) {
                            $("#merchantsbox").html(msg);
                            $("#merchants").change(function () {
                                $(this).attr('selected', 'selected');
                            });
                        });
                }
            });
            $("#merchants").change(function () {
                if($(this).val()){
                    $.ajax({
                        method: "POST",
                        url: "php/inc_merchantprocessors.php",
                        data: { m_id: $(this).val(), u_id: <?php echo $iid; ?> }
                    })
                    .done(function( msg ) {
                        $("#processoridbox").html(msg);
                        $("#processorid").change(function () {
                            $(this).attr('selected', 'selected');
                        });
                    });
                }
            });

            $(".reportsearch").click(function () {
				
				var start = $( "#date_timepicker_start" ).val();
				var end = $( "#date_timepicker_end" ).val();
				var currencies = $('#currencies').val();
				var transaction_type = $('#transaction_type').val();
			
				if(start=='' && end=='') {
					alert("Please select start and end date");
				} else {			
	                $("#reportresults").html('Bulding the report. Please wait...');
	                var postData = {start_date:start, end_date:end, currencies:currencies, transaction_type:transaction_type};
	                // $("#reports_form").serializeArray();
	                console.log(postData);
	                $.ajax({
	                    method: "POST",
	                    url: "php/inc_reportsearch1.php",
	                    data: postData
	                })
                    .done(function( msg ) {
                        $("#reportresults").html(msg);
                    });
				}
            });
			
			
        });
		
		
    </script>
	<!--<script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.min.js"></script>
<script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.flot/0.8.3/jquery.flot.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://www.flotcharts.org/flot/jquery.flot.js"></script>
<script src="http://www.flotcharts.org/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
  
	<script src="https://cdn.anychart.com/js/7.14.3/anychart-bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.anychart.com/css/7.14.3/anychart-ui.min.css" />	
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>-->
	

<script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.min.js"></script>
<script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.tooltip.min.js"></script>
	
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
  
	<script src="https://cdn.anychart.com/js/7.14.3/anychart-bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.anychart.com/css/7.14.3/anychart-ui.min.css" />	
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>

<?php
require_once('footerjs.php');
?> 
<?php
require_once('footer.php');
?>