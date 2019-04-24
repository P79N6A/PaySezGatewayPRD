<?php 
require_once( 'header.php');

//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');

require_once( 'php/common_functions.php');
$merchant_name = "admin";
$search_type = 'trans';
$search_type_text = 'Transactions';
$merchantname=getSmerchant($id);
if ($usertype == 1) {
	$VTMerchants = getVTMerchantsofAdmin();
} else {	
	if(!empty($mid) && $mid > 0) {
		$merchant_name = getUserMerchantName($id);
		$tttt = getMerchantName($id);
		$merchant_processors = getUserMerchantProcessors($mid);
		}
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $search_type_text; ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong><?php echo $search_type_text; ?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<form id="cb_form">
<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<!--<div class="col-lg-6">
					<div class="ibox float-e-margins">
						<?php
						if(!empty($mid) && $mid > 0) {
								$merchant_processors = getUserMerchantProcessors($mid);
							?>
							<div class="ibox-title">
								<h5>Merchant</h5>
							</div>
							<div class="ibox-content">
								<h5><?php echo $merchant_name; ?></h5>
								<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
							</div>
							<?php
						} else {
							?>
							<div class="ibox-title">
								<h5>Merchants</h5>
							</div>
							<div class="ibox-content">
								<select name="merchantid" id="merchantid" class="form-control m-b">
									<option value="0">-- All Merchants --</option>
									<?php foreach($agent_merchants as $agent_merchant){ ?>
									<option value="<?php echo $agent_merchant['idmerchants']; ?>"><?php echo $agent_merchant['merchant_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>
					</div>
				</div> --> 
				
				<div class="col-lg-6">
				<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Merchant</h5>
						</div>
						<div class="ibox-content">
						<?php if($usertype == 1) { ?>
							<select name="merchantid" id="merchantid" class="form-control m-b chosen-select required" tabindex="2">
								<option value="0">-- All Merchant --</option>
								<?php foreach($VTMerchants as $merchant) { ?>
								<option <?php if(isset($_POST['merchant_id'])){if($_POST['merchant_id'] == $merchant['idmerchants']){echo selected;}} ?>  value="<?php echo $merchant['idmerchants']; ?>"><?php echo $merchant['merchant_name']; ?></option>
								<?php } ?>
							</select>
						<?php } else { ?>
							<h3 class="m-t-none m-b">Merchant</h3>
							<select name="merchantid" id="" class="form-control m-b chosen-select required" tabindex="2">
								<option value="0">-- All Merchant --</option>
								<?php foreach($merchantname as $merchant) { ?>
								<option <?php if(isset($_POST['merchant_id'])){if($_POST['merchant_id'] == $merchant['idmerchants']){echo selected;}} ?>  value="<?php echo $merchant['idmerchants']; ?>"><?php echo $merchant['merchant_name']; ?></option>
								<?php } ?>
							</select>
							<!--	<h5><?php echo $merchant_name; ?></h5> 
							<input type="hidden" value="<?php if(!empty($mid)) echo $mid; ?>" name="merchant_id" id="merchant_id">-->
						<?php } ?>
					</div>
					</div>
					</div>
				<div class="col-lg-6">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Processor</h5>
						</div>
						<div class="ibox-content">
						<?php if((!empty($mid) && $mid>0 && count($merchant_processors) > 0 ) || $usertype==1) { ?>
							<div id="processoridbox">
								<select name="processorid" id="processorid" class="form-control m-b">
									<?php foreach($merchant_processors as $merchant_processor) { ?>
								<option value="<?php echo $merchant_processor['processor_id']; ?>"><?php echo $merchant_processor['processor_name']; ?></option>
								<?php } ?>
								</select>
							</div>
							<?php } ?>
								<!--<div class="alert alert-danger">
									You don't have any processors set up!
								</div> -->
							
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="cb-filter">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Filters</h5>
			</div>
			<div class="ibox-content">
				<div class="row">
					<div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Date Range</h3>
							<div id="start_date" class="form-group">
								<label>Period Start Date</label>
								<div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="" class="form-control" name="period_start_date" id="period_start_date">
                                </div>
                            </div>
                            <div id="end_date"  class="form-group">
                                <label>Period End Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="" class="form-control" name="period_end_date"  id="period_end_date">
                                </div>
                            </div>
					</div>
					<div class="col-sm-6"><h3 class="m-t-none m-b">Amount Range</h3>
							<div class="form-group"><label>Minimum</label> <input type="text" class="form-control" name="min_amount_range" id="min_amount_range"></div>
							<div class="form-group"><label>Maximum</label> <input type="text" class="form-control" name="max_amount_range" id="max_amount_range"></div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-sm-6 b-r"><h3 class="m-t-none m-b"></h3>
							<div class="form-group">
								<label>Transaction ID </label> 
								<input type="text" class="form-control" name="transaction_id" id="transaction_id">
							</div>
							<div class="form-group">
								<label>Transaction Type</label> 
								<select class="form-control m-b" id="transaction_type" name="transaction_type">
									<option value="all">All</option>
								   <option value="auth">Authorizations</option>
								   <option value="capture">Captures</option>
								   <option value="sale">Sales</option>
								   <option value="refund">Refunds</option>
								   <option value="void">Voids</option>
								   <option value="settle">Settle</option>
								   <option value="authcapture">Authorizations and Captures</option>
								   <option value="authcapturerefund">Authorizations, Captures and Refunds</option>
								   <option value="salerefund">Sales and Refunds</option>
							</select>
							</div>
							<div class="form-group">
								<label>Transaction Status</label> 
								<select class="form-control m-b" id="transaction_status" name="transaction_status">
									<option selected="selected" value="-1">All</option>
									<option value="0">Failed</option>
									<option value="1">Succeeded</option>
								</select>
							</div>
							<div class="form-group">
								<label>Order ID </label> 
								<input type="text" class="form-control" name="order_id" id="order_id">
							</div>
					</div>
					<div class="col-sm-6"><h3 class="m-t-none m-b">Customer</h3>
						<div class="form-group">
							<label>First Name </label> 
							<input type="text" class="form-control" name="first_name" id="first_name">
						</div>
						<div class="form-group">
							<label>Last Name </label> 
							<input type="text" class="form-control" name="last_name" id="last_name">
						</div>
						<div class="form-group">
							<label>Phone </label> 
							<input type="text" class="form-control" name="phone" id="phone">
						</div>
						<div class="form-group">
							<label>Email </label> 
							<input type="email" class="form-control" name="email" id="email">
						</div>
						<div class="form-group">
							<label>Customer IP address </label> 
							<input type="text" class="form-control" name="customer_ip_address" id="customer_ip_address">
						</div>
						<div class="form-group">
							<label>Last 4 digits of credit card number </label> 
							<input type="text" class="form-control" name="last4_ccn" id="last4_ccn">
						</div>					
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-sm-6">
					</div>
					<div class="col-sm-6">
						<input type="hidden" name="search_type" value="<?php echo $search_type; ?>" />
						<button class="btn btn-primary btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Search <?php echo $search_type_text; ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>	
</form>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>Results</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				<div id="cbresults"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once( 'footerjs.php'); ?>
<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<script>
$(document).ready(function(){					
		$('#start_date .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			dateFormat: 'yyyy-mm-dd',
			autoclose: true
		});

		$('#end_date .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,			
			dateFormat: 'yyyy-mm-dd',
			autoclose: true
		});
		
		$("#merchantid").change(function () {
			 
			if($(this).val()){
				$.ajax({
					method: "POST",
					url: "php/inc_merchantprocessors.php",
					data: { m_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?>  }
				})
				.done(function( msg ) {
					$("#processoridbox").html(msg);
					$("#processorid").change(function () {
						$(this).attr('selected', 'selected');
					});
				});
			} else {
				$("#cb-filter").hide();
			}
		});
		
		
		
		$(".cbsearch").click(function () {
			$( "#cbresults" ).html('Searching. Please wait...');
			$('html, body').animate({
					scrollTop: $("#cbresults").offset().top
				}, 1000);			
			$("#new_chargebacks").val(0);		
			var m_val = $("#merchantid").val();
			var p_val = $("#processorid").val();
			var postData = $("#cb_form").serializeArray();
			$.ajax({
				method: "POST",
				url: "php/inc_<?php echo $search_type; ?>search.php",
				data: postData
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
				$('input:checkbox').change(function(){ 
					if($(this).attr('id') == 'selectall')	
					{
						jqCheckAll2( this.id);
					}
				});
				function jqCheckAll2( id )
				{
					$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
				}
			});
		});
		
		$(".cbsearchnew").click(function () {
		$( "#cbresults" ).html('Searching. Please wait...');	
			$("#new_chargebacks").val(1);
			var m_val = $("#merchantid").val();
			var p_val = $("#processorid").val();
			var postData = $("#cb_form").serializeArray();
			$.ajax({
				method: "POST",
				url: "php/inc_<?php echo $search_type; ?>search.php",
				data: postData
			})
			.done(function( msg ) {
				$("#cbresults").html(msg);
				$('html, body').animate({
					scrollTop: $("#cbresults").offset().top
				}, 1000);
				$('.dataTables-example').dataTable({
					"order": [[ 1, "desc" ]],
					responsive: true,
					"dom": 'T<"clear">lfrtip',
					"tableTools": {
						"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
					}
				});
				$('input:checkbox').change(function(){ 
					if($(this).attr('id') == 'selectall')	
					{
						jqCheckAll2( this.id);
					}
				});
				function jqCheckAll2( id )
				{
					$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
				}
			});
		});
		
});
</script>
<?php require_once( 'footer.php'); ?> 