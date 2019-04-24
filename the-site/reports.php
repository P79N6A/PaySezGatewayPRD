<?php
require_once('header.php');
include 'php/inc_reports.php';
$vars = 1;
require_once('php/inc_chart-view.php');
//https://github.com/xdan/datetimepicker/blob/master/index.html
if(isset($_SESSION['iid'])){
	$iid = $_SESSION['iid'];
}
ini_set('memory_limit', '-1');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Reports</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Reports</strong>
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
							<div class="col-md-2">
								<label>Processor</label>
								<div id="processoridbox">
								<select class="form-control m-b" name="processorid" id="processorid">
									<option>-- All Processor --</option>
									<?php foreach($user_processors as $user_processor) { ?>
										<option value="<?php echo $user_processor['processor_id']; ?>"><?php echo $user_processor['processor_name']; ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
							<div class="col-md-2">
								<label>Card Types</label>
								<select class="form-control m-b" name="card_types" id="card_types">
									<option value="">-- All Card Types --</option>
									<option value="visa">Visa</option>
									<option value="mastercard">Mastercard</option>
									<option value="amex">AMEX</option>
									<option value="maestro">Maestro</option>
									<option value="jcb">JCB</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Currencies</label>
								<select class="form-control m-b" name="currencies" id="currencies">
									<option value="">-- All Currencies --</option>
									<option value="USD">USD</option>
									<option value="CAD">CAD</option>
									<option value="EUR">EUR</option>
									<option value="GBR">GBP</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Transaction Type</label>
								<select class="form-control m-b" name="transaction_type" id="transaction_type">
									<option value="">-- Any Types-- </option>
									<option value="sale">Sale</option>
									<option value="refund">Refund/Credit</option>
									<option value="auth">Authorize Only</option>
									<option value="capture">Capture</option>
									<option value="void">Void</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label>Recurring</label>
								<select class="form-control m-b" name="recurring" id="recurring">
									<option>-- All --</option>
									<option>1st</option>
									<option>2nd</option>
									<option>3rd</option>
									<option>4th</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Agents</label>
								<select class="form-control m-b" name="agents" id="agents">
									<option>-- All Agents --</option>
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
									<option>-- All Merchants --</option>
									<?php foreach($user_merchants as $user_merchant) { ?>
										<option value="<?php echo $user_merchant['idmerchants']; ?>"><?php echo $user_merchant['merchant_name']; ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
							<?php //getOptions($_SESSION['iid']); ?>
							<div class="col-md-2">
								<label>MID</label>
								<select class="form-control m-b" name="mid" id="mid">
									<option>-- All MID --</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Bin</label>
								<select class="form-control m-b" name="bin" id="bin">
									<option>-- All Bin --</option>
									<option>Top 10</option>
									<option>Top 15</option>
									<option>Top 25</option>
									<option>Top 50</option>
									<option>Top 100</option>
									<option>Top 250</option>
								</select>
							</div>
							<div class="col-md-2">
							  <label>&nbsp;</label>
							  <!-- onclick="showReport('true')" -->
							  <button class="btn btn-primary btn-lg btn-block reportsearch" type="button"><i class="fa fa-check"></i>&nbsp;Submit</button>
							</div>
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
					<div id="reportresults"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
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
										<a data-toggle="tab" href="#tab-2" onclick="showAgent('accinfo')" aria-expanded="false">Transaction Count</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-3" onclick="showAgent('processors')" aria-expanded="true">Charge Backs</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-4" onclick="showAgent('fee')" aria-expanded="false">Charge Back Ratio By Volume</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-5" onclick="showAgent('affstatus')" aria-expanded="false">Charge Back / Decline Reasons</a>
									</li>

								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content" id="tab-content">
							<?php echo getAffInfo($_SESSION['iid']); ?>
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
    function showAgent(str) {
        if (str == "") {
            document.getElementById("tab-content").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("tab-content").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("POST", "php/inc_chart-view.php?q=" + str, true);
            xmlhttp.send();
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
			$( "#reportresults" ).html('Bulding the report. Please wait...');		
			var postData = $("#reports_form").serializeArray();
			$.ajax({
				method: "POST",
				url: "php/inc_reportsearch.php",
				data: postData
			})
			.done(function( msg ) {
				$("#reportresults").html(msg);
			});
	});
});
</script>
<?php
require_once('footerjs.php');
?> 
<?php
require_once('footer.php');
?>