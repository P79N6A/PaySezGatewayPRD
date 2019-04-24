<?php 
require_once( 'header.php');

//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');

require_once( 'php/inc_chargebacks.php');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Transaction Details</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li>
				<a href="transactions.php">Transactions</a>
			</li>
			<li class="active">
				<strong>Transaction Details</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Transaction Details</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table  class="table table-bordered">
							<tbody>
								<tr>
									<th>Transaction ID</th>
									<td><?php echo $trans["id_transaction_id"]; ?></td>
								</tr>
								<?php if($is_cb){ ?>
								<tr>
									<th>Processor ID</th>
									<td><?php echo $processorsname; ?></td>
								</tr>
								<?php } ?>
								<tr>
									<th>Platform ID</th>
									<td><?php echo $trans["platform_id"]; ?></td>
								</tr>
								<tr>
									<th>Transaction Type</th>
									<td><?php echo $trans["action_type"]; ?></td>
								</tr>
								<tr>
									<th>Amount</th>
									<td><?php echo number_format($trans["amount"],2); ?></td>
								</tr>
								<tr>
									<th>Shipping</th>
									<td><?php echo number_format($trans["shipping"]); ?></td>
								</tr>
								<tr>
									<th>Tax</th>
									<td><?php echo number_format($trans["tax"],2); ?></td>
								</tr>
								<tr>
									<th>Currency</th>
									<td><?php echo $trans["currency"]; ?></td>
								</tr>
								<tr>
									<th>Transaction Result</th>
									<td><?php echo ($trans["success"]==1)?"Succeeded":"Failed"; ?></td>
								</tr>
								<tr>
									<th>Status</th>
									<td><?php echo ucfirst($trans["condition"]); ?></td>
								</tr>
								<tr>
									<th>Settled Date</th>
									<td><?php echo $trans["processor_settlement_date"]; ?></td>
								</tr>
								<tr>
									<th>Authorization Code</th>
									<td><?php echo $trans["authorization_code"]; ?></td>
								</tr>
								<tr>
									<th>PO Number</th>
									<td><?php echo $trans["ponumber"]; ?></td>
								</tr>
								<tr>
									<th>Order ID</th>
									<td><?php echo $trans["order_id"]; ?></td>
								</tr>
								<tr>
									<th>Order Description</th>
									<td><?php echo $trans["order_description"]; ?></td>
								</tr>
								<tr>
									<th>Transaction date</th>
									<td><?php echo $trans["transaction_date"]; ?></td>
								</tr>
								<tr>
									<th>IP Address</th>
									<td><?php echo $trans["ipaddress"]; ?></td>
								</tr>
								<tr>
									<th>Affiliate</th>
									<td><?php echo $trans["mdf_6"]; ?></td>
								</tr>
								<tr>
									<th>Affiliate ID</th>
									<td><?php echo $trans["mdf_7"]; ?></td>
								</tr>
								<tr>
									<th>Rebill</th>
									<td><?php echo $trans["rebill_number"]; ?></td>
								</tr>
								<tr>
									<th>Response</th>
									<td><?php echo $trans["error_code"]; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
		</div>	
		<div class="col-lg-6">
			<?php 
			if(!$is_cb){ 
			?>
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Refund Transaction</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<form id="vtrefundform">
							<div class="row">
							  <div class="col-xs-12 form-group required">
								<label class="control-label">Transaction ID <span class="text-danger">*</span></label>
								<input type="text" value="<?php echo $trans["id_transaction_id"]; ?>" name="TID" class="form-control required" readonly>
							  </div>
							</div>
							<div class="row">
								  <div class="col-xs-4 form-group required">
									<label class="control-label required">Amount <span class="text-danger">*</span></label>
									<input type="text" value="<?php echo number_format($trans["amount"],2); ?>" name="amount" id="amount" class="form-control required">
								  </div>
								   <div class="col-xs-4 form-group required">
									<label class="control-label">Tax <span class="text-danger">*</span></label>
									<input type="text" value="0" name="tax" class="form-control required">
								  </div>
								  <div class="col-xs-4 form-group required">
									<label class="control-label">Currency <span class="text-danger">*</span></label>
									<input type="text" value="<?php echo $trans["currency"]; ?>" name="currency" class="form-control required" readonly>
								  </div>
							</div>
							<div class='row'>
							  <div class='col-xs-12 form-group'>
								<input type="hidden" value="<?php echo $api_key; ?>" name="apikey" class="form-control">
								<input type="hidden" value="test" name="env" class="form-control">
								<input type="hidden" value="1" name="PartialCancelCode" id="partial" class="form-control">
								<input type="hidden" value="AC" name="TransactionType" class="form-control">
								<div class="refundresult"></div>
								<a class="btn btn-lg btn-primary btn-block refund" 
								href="transaction.php?t_id=<?php echo $trans["id_transaction_id"];?>">Cancel</a>
								</div>
								 <div class='col-xs-12 form-group'>	
								<button class="btn btn-lg btn-primary btn-block refund" type="submit">Refund</button>								 
								
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php } ?>
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Credit Card Details</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table  class="table table-bordered">
							<tbody>
								<tr>
									<th>Credit card</th>
									<td><?php echo $cc_last4; ?></td>
								</tr>
								<tr>
									<th>Credit card Type</th>
									<td><?php echo $cc_type; ?></td>
								</tr>
								<tr>
									<th>Expire</th>
									<td><?php echo $cc_exp; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Customer Details</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table  class="table table-bordered">
							<tbody>
								<tr>
									<th>Billing Address:</th>
									<th>Shipping Address:</th>
								</tr>
								<tr>
									<td><?php 
										echo $trans["first_name"]." ".$trans["last_name"]."<br />"; 
										if($trans["company"] != " ") echo $trans["company"]."<br />"; 
										echo $trans["address1"]." ".$trans["address2"]."<br />"; 
										echo $trans["city"]." ".$trans["us_state"]."<br />"; 
										echo $trans["postal_code"]." ".$trans["country"]."<br />"; 
										echo $trans["email"]."<br />"; 
										echo $trans["phone"]."<br />"; 
									?></td>
									<td><?php 
										echo $trans["shipping_first_name"]." ".$trans["shipping_last_name"]."<br />"; 
										if($trans["shipping_company"] != " ") echo $trans["company"]."<br />"; 
										echo $trans["shipping_address1"]." ".$trans["shipping_address2"]."<br />"; 
										echo $trans["shipping_city"]." ".$trans["shipping_us_state"]."<br />"; 
										echo $trans["shipping_postal_code"]." ".$trans["shipping_country"]."<br />"; 
										echo $trans["shipping_email"]."<br />"; 
										echo $trans["shipping_carrier"]." ".$trans["tracking_number"]."<br />"; 
										echo $trans["shipping_date"]."<br />"; 
									?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<?php if($is_cb){ ?>
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Chargeback Data</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table  class="table table-bordered">
							<tbody>
								<tr>
									<th>Reference Number</th>
									<td><?php echo $cb["ACQ_REF_NR"]; ?></td>
								</tr>
								<tr>
									<th>Status</th>
									<td><?php echo $cb["name"]; ?></td>
								</tr>
								<tr>
									<th>Dispute Result</th>
									<td><?php echo $cb["dispute_result"]; ?></td>
								</tr>
								<tr>
									<th>Chargeback Amount</th>
									<td><?php echo number_format($cb["cb_amount"], 2); ?></td>
								</tr>
								<tr>
									<th>Reason Code</th>
									<td><?php echo $cb["reason_code"]; ?></td>
								</tr>
								<tr>
									<th>Response Date</th>
									<td><?php echo $cb["response_date"]; ?></td>
								</tr>
								<tr>
									<th>Update Date</th>
									<td><?php echo $cb["update_date"]; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<?php } ?>
			</div>	
	</div>
	<div class="row">
		<div class="col-lg-12">
				<div class="ibox float-e-margins" id="related">
					<div class="ibox-title">
						<h5>Related Transactions</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-down"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content" style="display: none;">
						<div id="related_content"></div>
					</div>
				</div>
		</div>		
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins" id="customerhistory">
				<div class="ibox-title">
					<h5>Customer Transaction History</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-down"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content" style="display: none;">
					<div id="customerhistory_content"></div>
				</div>
			</div>
		</div>
	</div>	
</div>
<input type="hidden" id="t_id" name="t_id" value="<?php echo $t_id; ?>" />
<input type="hidden" id="customer_email" name="customer_email" value="<?php echo $trans["email"]; ?>" />
<?php require_once( 'footerjs.php'); ?>
<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<!-- Chosen -->
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
<script>
$(document).ready(function(){
	$("#vtrefundform").validate({
		submitHandler: function(form) {
			if($("#amount").val() < <?php echo $trans["amount"]; ?>)
			{
				$("#partial").val(1);
			} else {
				$("#partial").val(0);
			}
			$(".refundresult").html("Sending...please wait");
			
			$.ajax({
				method: "POST",
				url: "../api/smartro.php",
				data: $("#vtrefundform").serializeArray()
			})
			.done(function( msg ) {
				var result;
				if(msg.success == 0){
					result = '<div class="alert alert-danger">'+msg.ResponseMessage+'</div>';
				} else {
					result = '<div class="alert alert-success">'+msg.ResponseMessage+'</div>';
				}
				$(".refundresult").html(result);
			});
		}
	});	
	$("#related .fa-chevron-down").click(function () {
		$("#related_content").html("Loading...");
		$.ajax({
			method: "POST",
			url: "php/inc_relatedtransactions.php",
			data: { t_id: $("#t_id").val() }
		})
		.done(function( msg ) {
			$("#related_content").html(msg);
		});
	});
	
	$("#related .fa-chevron-up").click(function () {
		$('#related_content').hide();
	});
	
	$("#customerhistory .fa-chevron-down").click(function () {
		$("#customerhistory_content").html("Loading...");
		$.ajax({
			method: "POST",
			url: "php/inc_customertransactionshistory.php",
			data: { customer_email: $("#customer_email").val() }
		})
		.done(function( msg ) {
			$("#customerhistory_content").html(msg);
		});
	});
	
	$("#customerhistory .fa-chevron-up").click(function () {
		$('#customerhistory_content').hide();
	});
		
});
</script>
<?php require_once('footer.php'); ?> 