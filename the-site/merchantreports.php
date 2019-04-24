<?php
require_once('header.php');
include 'php/inc_reports.php';
$vars = 1;
require_once('php/inc_chart-view.php');
//https://github.com/xdan/datetimepicker/blob/master/index.html
if(isset($_SESSION['iid'])){
	$iid = $_SESSION['iid'];
}
$omg ='';
if(!empty($env) && $env == 0){
$omg = 'TEST MODE ENABLED';
}
ini_set('memory_limit', '-1');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Monthly Statement</h2><center><span style="color:red"><?php echo $omg; ?></span></center>
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
					<h5>Monthly Statement</h5>
					<div class="ibox-tools">
						<a id="exportlink" href="phpexcel/report.php?month=<?php echo date('m');?>&year=<?php echo date('Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a>
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<h3 class="pull-left"><?php echo getUserMerchantName($id); ?></h3>
					<div class="pull-right form-inline">
						<div class="form-group">
							<label class="control-label">Date &nbsp;</label>
							<select class="form-control" id="month" name="month">
								<option value="">Month</option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
							<select class="form-control" id="year" name="year">
								<option value="2015">2015</option>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
					<br />
					<div class="row" id="monthlyreports"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require_once('footerjs.php');
?> 
<script>
$(document).ready(function(){
	$("#month option[value=<?php echo date('m'); ?>]").prop('selected', true);
	$("#year option[value=<?php echo date('Y'); ?>]").prop('selected', true);
	$.ajax({
		method: "POST",
		url: "php/inc_monthlyreports.php",
		data: { mid: <?php echo $mid; ?> }
	})
	.done(function( msg ) {
		$("#monthlyreports").html(msg);
	});
	$("#month").change(function () {
		$.ajax({
			method: "POST",
			url: "php/inc_monthlyreports.php",
			data: { month: $("#month").val(), year: $("#year").val() }
		})
		.done(function( msg ) {
			$("#monthlyreports").html(msg);
			$("#exportlink").attr("href", "phpexcel/report.php?month="+$("#month").val()+"&year="+$("#year").val())
		});
	});
	$("#year").change(function () {
		$.ajax({
			method: "POST",
			url: "php/inc_monthlyreports.php",
			data: { month: $("#month").val(), year: $("#year").val() }
		})
		.done(function( msg ) {
			$("#monthlyreports").html(msg);
		});
	});
});
</script>
<?php
require_once('footer.php');
?>