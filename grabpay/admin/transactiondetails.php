<?php 
require_once( 'header.php');

//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');

require_once( 'php/inc_chargebacks.php');

date_default_timezone_set('Asia/Kolkata');

// Cancel Enable Condition
// if($trans['transaction_type'] == 1 && $trans['result_code'] =='SUCCESS' && $trans["trade_status"]=='TRADE_SUCCESS') {

// }

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Transaction Details</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<!-- <li>
				<a href="transactions.php">Transactions</a>
			</li> -->
			<li class="active">
				<strong>Transaction Details</strong>
			</li>
		</ol>
	</div>
</div>
<?php
function custom_echo($x, $length) {
                        if(strlen($x)<=$length) {
                                            return $x;
                            } else { 
                                $y=substr($x,0,$length) . '';
                                return $y;
                            }
    }

function number_point($value) {
		$myAngloSaxonianNumber = number_format($value, 2, '.', ','); // -> 5,678.90 
		return $myAngloSaxonianNumber;
	}
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Transaction Details
                        </h5>

						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
                        <?php

                        $trade_stats = ['TRADE_SUCCESS','TRADE_CLOSED'];
                        if($trans["transaction_type"] == 's1' && !in_array($trans['trade_status'], $trade_stats) ) {?>
                            <span class="pull-right"><input type="button" class="btn btn-success" value="Call Query" onclick="doQuery();"></span>
                        <?php } ?>
						<table  class="table table-bordered">
							<tbody>
								<!-- <tr>
									<th>Transaction ID</th>
									<td><?php// echo $trans["gp_transaction_id"]; ?></td>
								</tr> -->
								<tr>
									<th>Transaction ID.</th>
									<td><?php
									 echo custom_echo($trans["gp_partnerTxID"],12); ?></td>
								</tr>
								<?php if($_SESSION['user_type']==1) {
							    ?>
								<tr>
									<th>Trade No.</th>
									<td><?php echo $trans["trade_no"]; ?></td>
								</tr>
							    <?php } ?>
								<tr>
									<th>Transaction Type</th>
									<td>
										<?php 
										$transaction_type='';
			                            if($trans['gp_transaction_type'] == 1) {
			                                $transaction_type = 'GP - PURCHASE';
			                            } else if($trans['gp_transaction_type'] == 2) {
			                                $transaction_type = 'GP - REFUND';
			                            } else if($trans['gp_transaction_type'] == 3) {
			                                $transaction_type = 'GP - CANCEL';
			                            } else if($trans['gp_transaction_type'] == 4) {
			                                $transaction_type = 'GP - INQUERY';
			                            }
										echo $transaction_type;
										?>
									</td>
								</tr>
								<?php if($_SESSION['user_type']==1) { ?>
								<tr>
									<th>Transaction Product Code</th>
									<td><?php echo $trans["product_code"]; ?></td>
								</tr>
							    <?php } ?>

								<tr>
									<th>Amount</th>
									<td>
									<?php 
									if($trans['gp_transaction_type'] == 1 || $trans['transaction_type'] == 4 || $trans['transaction_type'] == 's1' || $trans['transaction_type'] == 's4'|| $trans['transaction_type'] == 's3' || $trans['transaction_type'] == 's3'||$trans['transaction_type'] == 'cb1'||$trans['transaction_type'] == 'cb3') {
										$transaction_amount = $trans["gp_amount"]/100;
										if (is_float($transaction_amount)) {
					                    		echo $trans["gp_currency"].' '.number_point($transaction_amount);
					                		} else {
					                	
					                	$transaction_amount = $transaction_amount.'.00';
					                    echo $trans["gp_currency"].' '.number_point($transaction_amount);
					                    }
									} else {
										$transaction_amount = $trans["gp_amount"]/100;
										if (is_float($transaction_amount)) {
					                    		echo $trans["gp_currency"].' '.number_point($transaction_amount);
					                		} else {
					                	
					                	$transaction_amount = $transaction_amount.'.00';
					                    echo $trans["gp_currency"].' '.number_point($transaction_amount);
					                    }
									} 
									?>	
									</td>
								</tr>
								<?php if($_SESSION['user_type']==1) {
							    ?>
								<tr>
									<th>Buyer Id</th>
									<td><?php echo $trans["buyer_id"]; ?></td>
								</tr>
								<tr>
									<th>Buyer Email</th>
									<td><?php echo $trans["buyer_email"]; ?></td>
								</tr>
								<tr>
									<th>Seller Id</th>
									<td><?php echo $trans["res_seller_id"]; ?></td>
								</tr>
								<tr>
									<th>Seller Email</th>
									<td><?php echo $trans["res_seller_email"]; ?></td>
								</tr>
							<?php } ?>
								<tr>
									<th>Status</th>
									<td><?php
										if($trans['gp_transaction_type'] == 1 || $trans['transaction_type'] == 's1'||$trans['transaction_type'] == 'cb1'||$trans['transaction_type'] == 'cb3') {
	                                        if($trans["gp_status"]=='success') echo wordwrap("The trade succeeds and finishes and is not operable",50,"<br>\n");
										    else if($trans["gp_status"]=='TRADE_SUCCESS') echo wordwrap("The trade succeeds and is operable, such as multi-level royalty distribution, refund, etc.",50,"<br>\n");
	                                        else if($trans["gp_status"]=='TRADE_CLOSED') echo wordwrap("Trade closed whose payment has not been completed within specified time; <br>Trades closed whose payment has been fully returned when the trade completes.",50,"<br>\n");
	                                        else if($trans["gp_status"]=='WAIT_BUYER_PAY') echo wordwrap("The trade has been established and is waiting for the buyer to make payment.",50,"<br>\n");
	                                        else echo "transaction not found";
	                                    } else if($trans['gp_transaction_type'] == 2 || $trans['transaction_type'] == 4 || $trans['transaction_type'] == 's2' || $trans['transaction_type'] == 's4'|| $trans['transaction_type'] == 'cb2') {
	                                    	if($trans['gp_status'] == "success"||$trans['refund_status'] == 'REFUND_SUCCESS') {
	                                    		echo 'Refund Sucess';
	                                    	} else {
	                                    		echo "Refund Failed";
	                                    	}
	                                    }else if( $trans['gp_transaction_type'] == 3 ) {
	                                    	if($trans['gp_status'] == "" && $trans['gp_reason'] == "" ) {
	                                    		echo 'Cancel Sucess';
	                                    	} else {
	                                    		echo 'Cancel Failed';
	                                    	}
	                                    } ?></td>
								</tr>
								<tr>
									<th>Settled Date</th>
									<td><?php echo $trans["gp_cst_trans_datetime"]; ?></td>
								</tr>
								<!--<tr>
									<th>Goods Details</th>
									<td><?php /*echo $trans["goods_detail"]; */?></td>
								</tr>
								<tr>
									<th>Extend Params</th>
									<td><?php /*echo wordwrap($trans["extend_params"],50,"<br>\n"); */?></td>
								</tr>-->
								<tr>
									<th>Merchant ID</th>
									<td><?php echo $trans["gp_merchant_id"]; ?></td>
								</tr>
								<tr>
									<th>Terminal ID</th>
									<td><?php echo $trans["gp_terminal_id"]; ?></td>
								</tr>
								<tr>
									<th>Response</th>
									<td><?php       
							            if($trans['gp_transaction_type'] == 1) { 
							            	if($trans['gp_status'] == "success") {
							                    echo $trans['gp_status']; 
							                } else { 
							                   echo "fail"; 
							                }
							            } else if($trans['gp_transaction_type'] == 3) {
							                if($trans['gp_status'] == "" && $trans['gp_reason'] == ""){
							                    echo "success";
							                } else {
							                    echo  "fail";
							                }
							            } else if($trans['gp_transaction_type']==2) {
							                if($trans['gp_status'] == ""){
							                    echo "fail";
							                } else {
							                    echo $trans['gp_status'];
							                }
							            } else {
							               echo $trans['gp_status']; 
							            } ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
		</div>	
		<div class="col-lg-6">
			<?php 
			if(!$is_cb){

				/**** Check if the success sale transaction is already Cancelled or not ****/
				$db->where("out_trade_no",$trans['out_trade_no']);
				$db->where("transaction_type",'s4');
				$db->where("result_code", 'SUCCESS');
				$data_cancel = $db->get("transaction_alipay");
				$cancel_flag = count($data_cancel) >= 1 ? 1 : 0;

				/**** Check if the success sale transaction is already Refunded or not ****/
				$db->where("partner_trans_id",$trans['out_trade_no']);
				$db->where("transaction_type",'s2');
				$db->where("result_code", 'SUCCESS');
				$data_refund = $db->get("transaction_alipay");
				$refund_flag = count($data_refund) >= 1 ? 1 : 0;

				// If transaction is success then only display the 'Refund' and 'Cancel' part
				if($trans['transaction_type'] == 's1' && $trans['result_code'] == 'SUCCESS' && $trans['trade_status'] == 'TRADE_SUCCESS') {
					$flag = 1;
				} else {
					$flag = 0;
				}
				?>
				<div class="ibox float-e-margins" <?php if($flag == 0) { echo "style='display:none;'"; } ?>>
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
									<input type="text" value="<?php echo number_format($trans["total_fee"],2); ?>" name="amount" id="amount" class="form-control required" readonly>
                                      <input type="hidden" value="<?php echo $trans['trans_datetime']; ?>" id="trandate">
                                      <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" id="todaydate">
								  </div>
								   <div class="col-xs-4 form-group required">
									<label class="control-label">Tax <span class="text-danger">*</span></label>
									<input type="text" value="0" name="tax" class="form-control required" readonly>
								  </div>
								  <div class="col-xs-4 form-group required">
									<label class="control-label">Currency <span class="text-danger">*</span></label>
									<input type="text" value="<?php echo $trans["currency"]; ?>" name="currency" class="form-control required" readonly>
								  </div>
							</div>
							<div class='row'>
							  	<!-- <div class='col-xs-12 form-group'>
									<input type="hidden" value="<?php //echo $api_key; ?>" name="apikey" class="form-control">
									<input type="hidden" value="test" name="env" class="form-control">
									<input type="hidden" value="1" name="PartialCancelCode" id="partial" class="form-control">
									<input type="hidden" value="AC" name="TransactionType" class="form-control">
									<div class="refundresult"></div>
									<a class="btn btn-lg btn-primary btn-block refund" 
									href="transaction.php?t_id=<?php //echo $trans["id_transaction_id"];?>">Cancel</a>
								</div>
								<div class='col-xs-12 form-group'>	
									<button class="btn btn-lg btn-primary btn-block refund" type="submit">Refund</button>
								</div> -->

								<div class='col-xs-12 form-group threebtns'>
									<input type="hidden" value="<?php echo $api_key; ?>" name="apikey" class="form-control">
									<input type="hidden" value="test" name="env" class="form-control">
									<input type="hidden" value="1" name="PartialCancelCode" id="partial" class="form-control">
									<input type="hidden" value="AC" name="TransactionType" class="form-control">
									<div class="refundresult"></div>
									<div class="btn-group" <?php if($cancel_flag >= 1 || $refund_flag >= 1) { echo "style='display:none;'"; } ?>>
                                        <input type="button" class="btn btn-primary" onclick="doCancel();" value="Cancel">
										<input class="btn btn-primary" type="button" onclick="doRefund();" value="Refund">
										<input class="btn btn-primary" type="button" onclick="doPartialRefund();" value="Partial Refund"></input>                                   
									</div>
									<?php if($cancel_flag >= 1) { echo "<h3>Transaction Already Cancelled</h3>"; } ?>
									<?php if($refund_flag >= 1) { echo "<h3>Transaction Already Refunded</h3>"; } ?>
								</div>

							</div>
						</form>
					</div>
				</div>
			<?php } ?>
				<div class="ibox float-e-margins" style="display: none;">
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

				<div class="ibox float-e-margins" style="display:none;">
					<div class="ibox-title">
						<h5>Customer Details</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-down"></i>
							</a>
						</div>
					</div>
					<!-- <div class="ibox-content" style="display: none;">
						<table  class="table table-bordered">
							<tbody>
								<tr>
									<th>Billing Address:</th>
									<th>Shipping Address:</th>
								</tr>
								<tr>
									<td><?php 
										// echo $merchantDatas["first_name"]." ".$merchantDatas["last_name"]."<br />"; 
										echo $merchantDatas["merchant_name"]."<br />";
										if($merchantDatas["company"] != " ") echo $merchantDatas["company"]."<br />"; 
										echo $merchantDatas["address1"]." ".$merchantDatas["address2"]."<br />"; 
										echo $merchantDatas["city"]." ".$merchantDatas["us_state"]."<br />"; 
										echo $merchantDatas["zippostal_code"]." ".$merchantDatas["country"]."<br />"; 
										echo $merchantDatas["csemail"]."<br />"; 
										echo $merchantDatas["csphone"]."<br />"; 
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
					</div> -->
				</div>
				<?php if($is_cb){ ?>
				<div class="ibox float-e-margins" style="display: none;">
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

    function doCancel() {
        var trandate=$('#trandate').val();
        var todaydate=$('#todaydate').val();

        todaydate=new Date(todaydate);
        trandate=new Date(trandate);

        var difference = todaydate - trandate;
        var daysDifference = Math.floor(difference/1000/60/60);

        // if(daysDifference < 24){
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to cancel?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: function () {
                	$("#pageloaddiv").show();
                    $.ajax({
                        method: "POST",
                        url: "alipayapi_qr.php",
                        dataType: "json",
                        data: {from:'pg', action: 's4', device: 'QR', currency: '<?php echo $trans['currency']; ?>', timestamp: '<?php echo $trans['timestamp']; ?>', WIDout_trade_no: '<?php echo $trans['out_trade_no']; ?>', merchantid: '<?php echo $trans['merchant_id']; ?>', terminal_id: '<?php echo $trans['terminal_id']; ?>' },
                        success: function(response) { 
				          $("#pageloaddiv").hide();
				          // alert("Success");			
				        }
                    })
                    .done(function (msg) {
                        $.alert({
                            title: 'Cancellation !',
                            content: msg['res'] + "\n\n" + msg['desc'],
                            type: 'green',
                            typeAnimated: true,
                        });
                        window.setTimeout(function(){
					        // Move to a new location or you can do something else
					        window.location.href = 'dashboard.php';
					    }, 3000);
                    });
                },
                cancel: function () {

                }
            }
        });
        /*}
        else {
            alert("Unable to perform cancel after 24 hours. Try refund");
        }*/
    }

    function doRefund() {

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to Refund whole amount?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: function () {
                	$("#pageloaddiv").show();
                    $.ajax({
                        method: "POST",
                        url: "alipayapi_qr.php",
                        dataType: "json",
                        data: {from:'pg', action: 's2', device: 'QR', currency: '<?php echo $trans['currency']; ?>', return_amount: '<?php echo $trans['total_fee']; ?>', partner_refund_id:'<?php echo
                            $trans['terminal_id'].date('YmdHis'); ?>', partner_trans_id: '<?php echo $trans['out_trade_no']; ?>', merchantid: '<?php echo $trans['merchant_id']; ?>', terminal_id: '<?php echo $trans['terminal_id']; ?>'},
                        success: function(response) { 
				          $("#pageloaddiv").hide();
				          // alert("Success");			
				        }
                    })
                    .done(function (msg) {
                        $.alert({
                            title: 'Refund !',
                            content: msg['res'] + "\n\n" + msg['desc'],
                            type: 'green',
                            typeAnimated: true,
                        });
                        window.setTimeout(function(){
					        // Move to a new location or you can do something else
					        window.location.href = 'dashboard.php';
					    }, 3000);
                    });
                },
                cancel: function () {

                }
            }
        });


    }

    function doPartialRefund() {

    	$.confirm({
            title: 'Confirm!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Enter refund amount</label>' +
            '<input type="text" placeholder="Maximum of <?php echo number_format($trans['total_fee'],2); ?>" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Refund amount should not be empty..!');
                            return false;
                        }
                        var tot = <?php echo $trans['total_fee']; ?>;
                        var rgx = /^[0-9]*\.?[0-9]*$/;
                        if(name.match(rgx)==null){
                            $.alert("Entered Invalid amount");
                        } else {
                            if(name <= tot){
                            	$("#pageloaddiv").show();
                                $.ajax({
                                    method: "POST",
                                    url: "alipayapi_qr.php",
                                    dataType: "json",
                                    data: {from:'pg', action: 's2', device: 'QR', currency: '<?php echo $trans['currency']; ?>', return_amount: name, partner_refund_id:'<?php echo $trans['terminal_id'].date('YmdHis'); ?>', partner_trans_id: '<?php echo $trans['out_trade_no']; ?>', merchantid: '<?php echo $trans['merchant_id']; ?>', terminal_id: '<?php echo $trans['terminal_id']; ?>'},
			                        success: function(response) { 
							          $("#pageloaddiv").hide();
							          // alert("Success");			
							        }
                                })
                                .done(function (msg) {
                                    $.alert({
                                        title: 'Partial Refund !',
                                        content: msg['res'] + "\n\n" + msg['desc'],
                                        type: 'green',
                                        typeAnimated: true,
                                    });
                                    window.setTimeout(function(){
								        // Move to a new location or you can do something else
								        window.location.href = 'dashboard.php';
								    }, 3000);

                                });
                            } else {
                                $.alert("Refund amount Exceeded");
                            }
                        }
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function doQuery() {

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to call Query API?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: function () {
                	$("#pageloaddiv").show();
                    $.ajax({
                        method: "POST",
                        url: "alipayapi_qr.php",
                        data: {from:'pg', action: 's3', device: 'QR', currency: '<?php echo $trans['currency']; ?>', out_trade_no: '<?php echo $trans['out_trade_no']; ?>', merchantid: '<?php echo $trans['merchant_id']; ?>', terminal_id: '<?php echo $trans['terminal_id']; ?>'},
                        success: function(response) { 
				          $("#pageloaddiv").hide();
				          // alert("Success");			
				        }
                    })
                    .done(function (msg) {
                        if(msg==1){
                            $.alert({
                                title: 'Query Process !',
                                content: "Query processed successfully",
                                type: 'green',
                                typeAnimated: true,
                            });
                        } else if(msg==2){
                            $.alert({
                                title: 'Query Process !',
                                content: "Query Denied for this success transaction",
                                type: 'green',
                                typeAnimated: true,
                            });
                        } else if(msg==3){
                            $.alert({
                                title: 'Query Process !',
                                content: "Query process WAIT_BUYER_PAY",
                                type: 'green',
                                typeAnimated: true,
                            });
                        } else if(msg==4){
                            $.alert({
                                title: 'Query Process !',
                                content: "Query process TRADE_CLOSED",
                                type: 'green',
                                typeAnimated: true,
                            });
                        } else {
                            $.alert({
                                title: 'Query Process !',
                                content: "Query process Failed",
                                type: 'green',
                                typeAnimated: true,
                            });
                        }

                        window.setTimeout(function(){
					        // Move to a new location or you can do something else
					        window.location.href = 'dashboard.php';
					    }, 3000);
                    });
                },
                cancel: function () {

                }
            }
        });


    }

$(document).ready(function(){



	$("#vtrefundform").validate({
		submitHandler: function(form) {
			if($("#amount").val() < <?php echo $trans["total_fee"]; ?>)
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