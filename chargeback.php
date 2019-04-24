<?php
require_once( 'header.php');

//check permission
if(!checkPermission('B'))
    include_once('forbidden.php');

require_once( 'php/inc_chargebacks.php');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Chargeback Validation and Dispute Entry</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Chargeback</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Edit Chargeback Information</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
					<form id="cb_form">
						<div class="row">
							<div class="col-sm-4 b-r"><h3 class="m-t-none m-b"><?php echo $merchantname; ?></h3><br /><br />
								<div class="form-group"><label>First Name</label> <input value="<?php echo $cb[0]["first_name"]; ?>" type="text" class="form-control" name="cb_first_name" id="cb_first_name" disabled="disabled"></div>
								<div class="form-group"><label>Last Name</label> <input value="<?php echo $cb[0]["last_name"]; ?>" type="text" class="form-control" name="cb_last_name" id="cb_last_name" disabled="disabled"></div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Sale Value</label> <input value="<?php echo $cb[0]["sale_value"]; ?>" type="text" class="form-control" name="cb_sale_value" id="cb_sale_value" disabled="disabled"></div>
								<div class="form-group"><label>Sale Transaction ID</label> <input value="<?php echo $cb[0]["sale_transaction_id"]; ?>" type="text" class="form-control" name="cb_sale_transaction_id" id="cb_sale_transaction_id" disabled="disabled"></div>
								<div class="form-group"><label>Sale Date</label> <input value="<?php echo $cb[0]["sale_date"]; ?>" type="text" class="form-control" name="cb_sale_date" id="cb_sale_date" disabled="disabled"></div>
							</div>
							<div class="col-sm-4">
								<div class="form-group"><label>Credit Card</label> <input value="<?php echo $cb[0]["ccnum"]; ?>" type="text" class="form-control" name="cb_credit_card" id="cb_credit_card" disabled="disabled"></div>
								<div class="form-group"><label>Credit Card Type</label> <input value="<?php echo $cb[0]["cc_type"]; ?>" type="text" class="form-control" name="cb_cc_type" id="cb_cc_type" disabled="disabled"></div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div id="cb_request_date_box"  class="form-group">
									<label>Request Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input value="<?php echo date('m/d/Y', strtotime($cb[0]["cb_date"])); ?>" type="text" value="" class="form-control required" name="cb_request_date"  id="cb_request_date">
									</div>
								</div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Amount</label> <input value="<?php echo $cb[0]["cb_amount"]; ?>" type="text" class="form-control" name="cb_amount" id="cb_amount" disabled="disabled"></div>
							</div>
							<div class="col-sm-4">
								<div class="form-group"><label>Request Type</label> <input value="chargeback" type="text" class="form-control" name="cb_request_type" id="cb_request_type" disabled="disabled"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group"><label>Reason</label> <input value="<?php echo $reason; ?>" type="text" class="form-control" name="cb_reason" id="cb_reason" disabled="disabled"></div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div id="cb_response_date_box"  class="form-group">
									<label>Response Due Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input value="<?php echo date('m/d/Y', strtotime($cb[0]["response_date"])); ?>" type="text" value="" class="form-control required" name="cb_response_date"  id="cb_response_date">
									</div>
								</div>
							</div>
							<div class="col-sm-4 b-r">
								<div id="cb_update_date_box"  class="form-group">
									<label>Update Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input value="<?php echo date('m/d/Y', strtotime($cb[0]["update_date"])); ?>" type="text" value="" class="form-control required" name="cb_update_date"  id="cb_update_date">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div id="cb_charged_date_box"  class="form-group">
									<label>Charged Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input value="<?php echo date('m/d/Y', strtotime($cb[0]["charged_date"])); ?>" type="text" value="" class="form-control required" name="cb_charged_date"  id="cb_charged_date">
									</div>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Dispute Result</label> 
									<select name="cb_dispute_result" id="cb_dispute_result" class="form-control m-b required">
										<option value="" <?php echo ($cb[0]["dispute_result"] == "")?"selected='selected'":""; ?>></option>
										<option value="Unknown" <?php echo ($cb[0]["dispute_result"] == "Unknown")?"selected='selected'":""; ?>>Unknown</option>
										<option value="Won" <?php echo ($cb[0]["dispute_result"] == "Won")?"selected='selected'":""; ?>>Won</option>
										<option value="Lost" <?php echo ($cb[0]["dispute_result"] == "Lost")?"selected='selected'":""; ?>>Lost</option>
										<option value="Undisputed" <?php echo ($cb[0]["dispute_result"] == "Undisputed")?"selected='selected'":""; ?>>Undisputed</option>
										<option value="Do-Not-Disputed" <?php echo ($cb[0]["dispute_result"] == "Do-Not-Disputed")?"selected='selected'":""; ?>>Do-Not-Disputed</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Status</label> 
									<select name="cb_status" id="cb_status" class="form-control m-b required">
										<option value=""></option>
										<?php foreach($cb_statuses as $cb_status) { ?>
										<option value="<?php echo $cb_status['cb_stati_id']; ?>"  <?php echo ($cb[0]["status"] == $cb_status["cb_stati_id"])?"selected='selected'":""; ?>><?php echo $cb_status['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group"><label>Description</label> 
									<select name="cb_description" id="cb_description" class="form-control m-b required">
										<option value=""></option>
										<option value="Nutritional Supplement (Weight Loss)">Nutritional Supplement (Weight Loss)</option>
										<option value="Nutritional Supplement (Other)">Nutritional Supplement (Other)</option>
										<option value="Skin Care Product">Skin Care Product</option>
										<option value="Electronic Cigarette">Electronic Cigarette</option>
									</select>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Reference Number</label> <input value="<?php echo $cb[0]["ACQ_REF_NR"]; ?>" type="text" class="form-control" name="cb_reference_number" id="cb_reference_number" disabled="disabled"></div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Currency</label> <input value="<?php echo $cb[0]["TR_CCY"]; ?>" type="text" class="form-control" name="cb_currency" id="cb_currency" disabled="disabled"></div>
							</div>
							<div class="col-sm-4">
								<div class="checkbox i-checks"><br /><label> <input type="checkbox" value="" <?php echo ($cb[0]["new"] == 1)?"checked='checked'":""; ?> name="cb_new_chargeback" id="cb_new_chargeback"> <i></i> New Chargeback </label></div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Comment</h3>
								<textarea class="form-control" name="cb_comment" id="cb_comment"><?php echo $cb[0]["cb_comment"]; ?></textarea>
							</div>
							<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">New Response</h3>
								<textarea class="form-control" name="cb_new_response" id="cb_new_response" placeholder="(Enter new response here)" ></textarea>
							</div>
							<div class="col-sm-4">
								<div id="cbsave"></div>
								<input value="<?php echo $cb[0]["idchargebacks"]; ?>" type="hidden" class="form-control" name="cb_edit" id="cb_edit" >
								<input value="<?php echo $cb[0]["id_transaction_id"]; ?>" type="hidden" class="form-control" name="t_id" id="t_id" >
								<button class="btn btn-primary btn-lg btn-block cbsave" type="button"><i class="fa fa-save"></i> Save</button>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="sendtobankresult"></div>
						<div class="row">
							<div class="col-sm-3"><a href="create-zip.php?t_id=<?php echo $cb[0]["id_transaction_id"]; ?>" class="btn btn-warning btn-lg btn-block cbsearch" type="button"><i class="fa fa-download"></i> Download ZIP </a></div>
							<div class="col-sm-3"><a href="chargeback.php?cb_id=<?php echo $cb_id; ?>" class="btn btn-warning btn-lg btn-block reset" type="button"><i class="fa fa-trash"></i> Reset!</a></div>
							<div class="col-sm-3"><button class="btn btn-warning btn-lg btn-block sendtobank" type="button"><i class="fa fa-bank"></i> Send To Bank</button></div>
							<div class="col-sm-3"><a href="transactiondetails.php?t_id=<?php echo $cb[0]["sale_transaction_id"]; ?>" target="_blank" class="btn btn-warning btn-lg btn-block cbsearch" type="button" id="original-transaction"><i class="fa fa-search"></i> Original Transaction</a>
							</div>
						</div>
					</form>
					</div>
	
				</div>
			</div>	
	</div>
	<div class="row" id="supportingdocuments">
		<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Supporting Documents</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-down"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content" style="display: none;">
						<div class="row">
							<div class="col-sm-6">
								<div id="documents"></div>
							</div>
							<div class="col-sm-6"><h3 class="m-t-none m-b">Add Supporting Document</h3>
								<form id="my-awesome-dropzone" class="dropzone" action="php/inc_cbupload.php">
									<div class="dropzone-previews"></div>
									<input type="hidden" name="transaction_id" value="<?php echo $cb[0]["sale_transaction_id"]; ?>" />
									<input type="hidden" name="cb_id" value="<?php echo $cb[0]["idchargebacks"]; ?>" />
									<!-- button type="submit" class="btn btn-primary pull-right" id="adddocument">Add Documents</button-->
								</form>
							</div>
						</div>
					</div>
	
				</div>
			</div>	
	</div>
	<div class="row" id="correspondances">
		<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Correspondances</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-down"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content" style="display: none;">
						<div class="row">
							<div class="col-sm-12">
								<div id="correspondances_content"></div>
							</div>
						</div>
					</div>
	
				</div>
			</div>	
	</div>

	</div>
<?php require_once( 'footerjs.php'); ?>
<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

 <!-- DROPZONE -->
<script src="js/plugins/dropzone/dropzone.js"></script>

<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>

<script>
$(document).ready(function(){
	$(".reset").click(function () {
		$('#myform')[0].reset();
	});
	
	$('#cb_request_date_box .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$('#cb_response_date_box .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$('#cb_update_date_box .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$('#cb_charged_date_box .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$(".cbsave").click(function () {
		$("#cb_form").validate();
		var postData = $("#cb_form").serializeArray();
		$.ajax({
			method: "POST",
			url: "php/inc_cbedit.php",
			data: postData
		})
		.done(function( msg ) {
			$("#cbsave").html(msg);
			$('#correspondances_content').hide();
		});
	});
	
	$(".sendtobank").click(function () {
		$(".sendtobankresult").html("Sending...");
		$.ajax({
			method: "POST",
			url: "php/inc_sendtobank.php",
			data: { cb_id: $("#cb_edit").val() }
		})
		.done(function( msg ) {
			$(".sendtobankresult").html(msg);
		});
	});
	
	$("#correspondances .fa-chevron-down").click(function () {
		$("#correspondances_content").html("Loading...");
		$.ajax({
			method: "POST",
			url: "php/inc_cbcorrespondances.php",
			data: { cb_id: $("#cb_edit").val() }
		})
		.done(function( msg ) {
			$("#correspondances_content").html(msg);
		});
	});
	
	$("#correspondances .fa-chevron-up").click(function () {
		$('#correspondances_content').hide();
	});
	
	$("#supportingdocuments .fa-chevron-down").click(function () {
		$("#documents").html("Loading...");
		$.ajax({
			method: "POST",
			url: "php/inc_cbdocuments.php",
			data: { cb_id: $("#cb_edit").val() }
		})
		.done(function( msg ) {
			$("#documents").html(msg);
		});
	});
	
	$("#supportingdocuments .fa-chevron-up").click(function () {
		$('#documents').hide();
	});
		
});
</script>
<?php require_once( 'footer.php'); ?> 