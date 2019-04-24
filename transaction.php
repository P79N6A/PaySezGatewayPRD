<?php
ob_start();
require_once( 'header.php');

//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');

require_once( 'php/inc_chargebacks.php');
//if transaction is a chargeback - redirect tot the chargeback
if($is_cb)
{
	header( 'Location: '.$_SERVER[HTTP_HOST].'/chargeback.php?cb_id='.$cb['idchargebacks'] ) ;
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Transaction</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Transaction</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Transaction Managment - Create New Chargeback</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
					<form id="cb_form"  action="#" method="POST">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Enter Request ID, if the bank has provided one:</label> 
									<input value="" type="text" class="form-control" name="t_request_id" id="t_request_id" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 b-r"><h3 class="m-t-none m-b"><?php echo $merchantname; ?></h3><br /><br />
								<div class="form-group"><label>First Name</label> <input value="<?php echo $trans["first_name"]; ?>" type="text" class="form-control" name="t_first_name" id="t_first_name" disabled="disabled"></div>
								<div class="form-group"><label>Last Name</label> <input value="<?php echo $trans["last_name"]; ?>" type="text" class="form-control" name="t_last_name" id="t_last_name" disabled="disabled"></div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Sale Value</label> <input value="<?php echo $trans["amount"]; ?>" type="text" class="form-control" name="t_sale_value" id="t_sale_value" disabled="disabled"></div>
								<div class="form-group"><label>Sale Transaction ID</label> <input value="<?php echo $trans["id_transaction_id"]; ?>" type="text" class="form-control" name="t_sale_transaction_id" id="t_sale_transaction_id" disabled="disabled"></div>
								<div class="form-group"><label>Sale Date</label> <input value="<?php echo $trans["transaction_date"]; ?>" type="text" class="form-control" name="t_sale_date" id="t_sale_date" disabled="disabled"></div>
							</div>
							<div class="col-sm-4">
								<div class="form-group"><label>Credit Card</label> <input value="<?php echo $cc_last4; ?>" type="text" class="form-control" name="t_credit_card" id="t_credit_card" disabled="disabled"></div>
								<div class="form-group"><label>Credit Card Type</label> <input value="<?php echo $cc_type; ?>" type="text" class="form-control" name="t_cc_type" id="t_cc_type" disabled="disabled"></div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div id="end_date"  class="form-group">
									<label>Request Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input value="" type="text" value="" class="form-control required" name="cb_request_date"  id="cb_request_date" />
									</div>
								</div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Amount</label> <input value="" type="text" class="form-control required" name="cb_amount" id="cb_amount" /></div>
							</div>
							<div class="col-sm-4">
								<div class="form-group"><label>Request Type</label> 
									<select name="cb_request_type" id="cb_request_type" class="form-control m-b">
										<option value="CB">Chargeback</option>
										<option value="RR">Retieval Request</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group"><label>Reason</label> 
									<select id="cb_reason" name="cb_reason" class="form-control">
										<option value="28">VISA | RR | 28 | Cardholder Requests Copy Bearing Signature</option>
										<option value="29">VISA | RR | 29 | Request for T &amp; E Documents</option>
										<option value="30">VISA | RR | 30 | Cardholder Dispute Draft Requested</option>
										<option value="33">VISA | RR | 33 | Legal Process or Fraud Analysis</option>
										<option value="34">VISA | RR | 34 | Legal Process Request</option>
										<option value="98">VISA | RR | 98 | A dispute was initiated from Menu ADJ with the intent of only needing a retrieval request</option>
										<option value="99">VISA | RR | 99 | A dispute was initiated from Menu ADJ because the item is in question</option>
										<option value="none">VISA | RR | none | NONE</option>
										<option value="30">VISA | CB | 30 | Services/Merchandise Not Received</option>
										<option value="32">VISA | CB | 32 | unknown</option>
										<option value="41">VISA | CB | 41 | Cancelled Recurring Transaction</option>
										<option value="53">VISA | CB | 53 | Not as Described or Defective</option>
										<option value="57">VISA | CB | 57 | Fraudulent Multiple Drafts</option>
										<option value="60">VISA | CB | 60 | Copy Illegible or Invalid</option>
										<option value="62">VISA | CB | 62 | Counterfeit Transaction</option>
										<option value="70">VISA | CB | 70 | No Verification/Exception File</option>
										<option value="71">VISA | CB | 71 | Declined Authorization</option>
										<option value="72">VISA | CB | 72 | No Authorization</option>
										<option value="73">VISA | CB | 73 | Expired Card</option>
										<option value="74">VISA | CB | 74 | Late Presentment</option>
										<option value="75">VISA | CB | 75 | Cardholder Does Not Recognize</option>
										<option value="76">VISA | CB | 76 | Incorrect Transaction Code</option>
										<option value="77">VISA | CB | 77 | Non Matching Account Number</option>
										<option value="78">VISA | CB | 78 | Ineligible Transaction (International only)</option>
										<option value="79">VISA | CB | 79 | Non-receipt of Sales Draft</option>
										<option value="80">VISA | CB | 80 | Incorrect Amount or Account</option>
										<option value="81">VISA | CB | 81 | Fraudulent Transaction Card Present Environment</option>
										<option value="82">VISA | CB | 82 | Duplicate Processing</option>
										<option value="83">VISA | CB | 83 | Fraudulent Transaction Card Absent Environment</option>
										<option value="85">VISA | CB | 85 | Credit Not Processed</option>
										<option value="86">VISA | CB | 86 | Altered Amount / Paid by Other Means</option>
										<option value="90">VISA | CB | 90 | Non-Receipt of Cash or Merchandise</option>
										<option value="93">VISA | CB | 93 | Risk Identification Service</option>
										<option value="96">VISA | CB | 96 | Transaction Exceeds Limited Amount Terminal</option>
										<option value="6305">MasterCard | RR | 6305 | Do not agree with amount billed</option>
										<option value="6321">MasterCard | RR | 6321 | Cardholder does not recognize</option>
										<option value="6322">MasterCard | RR | 6322 | Chip transaction request</option>
										<option value="6323">MasterCard | RR | 6323 | Personal records request</option>
										<option value="6341">MasterCard | RR | 6341 | Fraud investigation</option>
										<option value="6342">MasterCard | RR | 6342 | Potential chargeback/compliance</option>
										<option value="none">MasterCard | RR | none | NONE</option>
										<option value="32">MasterCard | CB | 32 | unknown</option>
										<option value="4801">MasterCard | CB | 4801 | Requested Data Transaction Not Received</option>
										<option value="4802">MasterCard | CB | 4802 | Requested/Required Information Illegible or Missing</option>
										<option value="4807">MasterCard | CB | 4807 | Warning Bulletin File</option>
										<option value="4808">MasterCard | CB | 4808 | Requested/Required Authorization Not ObtainedRequested/Required Authorization Not Obtained </option>
										<option value="4812">MasterCard | CB | 4812 | Account Number Not on File</option>
										<option value="4831">MasterCard | CB | 4831 | Transaction Amount Differs</option>
										<option value="4834">MasterCard | CB | 4834 | Duplicate Processing</option>
										<option value="4835">MasterCard | CB | 4835 | Card Not Valid or Expired</option>
										<option value="4837">MasterCard | CB | 4837 | No Cardholder Authorization</option>
										<option value="4840">MasterCard | CB | 4840 | Fraudulent Processing of Transactions</option>
										<option value="4841">MasterCard | CB | 4841 | Cancelled Recurring Transaction</option>
										<option value="4842">MasterCard | CB | 4842 | Late Presentment</option>
										<option value="4846">MasterCard | CB | 4846 | Correct Transaction Currency Code Not Provided</option>
										<option value="4847">MasterCard | CB | 4847 | Requested/Required Authorization Not Obtained and Fraudulent Transaction</option>
										<option value="4849">MasterCard | CB | 4849 | Questionable Merchant Activity</option>
										<option value="4850">MasterCard | CB | 4850 | Credit Posted as a Purchase</option>
										<option value="4853">MasterCard | CB | 4853 | Cardholder Dispute-Defective/Not as Described</option>
										<option value="4854">MasterCard | CB | 4854 | Cardholder Dispute-Not Elsewhere Classified (U.S. Region Only)</option>
										<option value="4855">MasterCard | CB | 4855 | Non-receipt of Merchandise</option>
										<option value="4857">MasterCard | CB | 4857 | Card-Activated Telephone Transaction</option>
										<option value="4859">MasterCard | CB | 4859 | Services Not Rendered</option>
										<option value="4860">MasterCard | CB | 4860 | Credit Not Processed </option>
										<option value="4862">MasterCard | CB | 4862 | Counterfeit Transaction Magnetic Stripe POS Fraud</option>
										<option value="4863">MasterCard | CB | 4863 | Cardholder Does Not Recognize-Potential Fraud</option>
									</select>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div id="end_date"  class="form-group">
									<label>Response Due Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input value="" type="text" value="" class="form-control required" name="cb_response_date"  id="cb_response_date" />
									</div>
								</div>
							</div>
							<div class="col-sm-4 b-r">
								<div id="end_date"  class="form-group">
									<label>Update Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input value="" type="text" value="" class="form-control required" name="cb_update_date"  id="cb_update_date" / >
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div id="end_date"  class="form-group">
									<label>Charged Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input value="" type="text" value="" class="form-control required" name="cb_charged_date"  id="cb_charged_date">
									</div>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Dispute Result</label> 
									<select name="cb_dispute_result" id="cb_dispute_result" class="form-control m-b required">
										<option value="">Select</option>
										<option value="Unknown">Unknown</option>
										<option value="Won" >Won</option>
										<option value="Lost">Lost</option>
										<option value="Undisputed">Undisputed</option>
										<option value="Do-Not-Disputed">Do-Not-Disputed</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Status</label> 
									<select name="cb_status" id="cb_status" class="form-control m-b required">
										<option value="0"></option>
										<?php foreach($trans_statuses as $trans_status) { ?>
										<option value="<?php echo $trans_status['cb_stati_id']; ?>"  <?php echo ($trans["status"] == $trans_status["cb_stati_id"])?"selected='selected'":""; ?>><?php echo $trans_status['name']; ?></option>
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
								<div class="form-group"><label>Reference Number</label> <input value="" type="text" class="form-control required" name="cb_reference_number" id="cb_reference_number"></div>
							</div>
							<div class="col-sm-4 b-r">
								<div class="form-group"><label>Currency</label> <input value="" type="text" class="form-control required" name="cb_currency" id="cb_currency"></div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Comment</h3>
								<textarea class="form-control" name="cb_comment" id="cb_comment"></textarea>
							</div>
							<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">New Response</h3>
								<textarea class="form-control" name="cb_new_response" id="cb_new_response" placeholder="(Enter new response here)" ></textarea>
							</div>
							<div class="col-sm-4">
								<div id="cbsave"></div>
								<input value="<?php echo $trans["id_transaction_id"]; ?>" type="hidden" class="form-control" name="t_id" id="t_id" >
								<button class="btn btn-primary btn-lg btn-block cbsave" type="button"><i class="fa fa-search"></i> Save</button>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-sm-4"><a href="transactiondetails.php?t_id=<?php echo $trans["id_transaction_id"]; ?>" target="_blank" class="btn btn-warning btn-lg btn-block cbsearch" type="button" id="original-transaction"><i class="fa fa-search"></i> Original Transaction</a>
							</div>
							<div class="col-sm-4"></div>
							<div class="col-sm-4"><a href="transaction.php?t_id=<?php echo $trans["id_transaction_id"]; ?>" class="btn btn-warning btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Reset!</a></div>
							
						</div>
					</form>
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
	$(".cbsave").click(function () {
		$("#cb_form").validate();
		var postData = $("#cb_form").serializeArray();
		$.ajax({
			method: "POST",
			url: "php/inc_cbcreate.php",
			data: postData
		})
		.done(function( msg ) {
			if(msg > 0)
			{
				window.location.replace("http://<?php echo $_SERVER['HTTP_HOST']; ?>/chargeback.php?cb_id=" + msg);
			} else {
				$("#cbsave").html(msg);
			}
			$('#correspondances_content').hide();
		});
	});
	
	$('#cb_request_date .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$('#cb_response_date .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$('#cb_update_date .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
	
	$('#cb_charged_date .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
		
});
</script>
<?php require_once( 'footer.php'); ?> 