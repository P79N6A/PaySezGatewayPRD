<?php
/**
 * Created by Karthick Raja.
 * Date: 02-01-2019
 * Time: 03:52 PM
 */
session_start();
?>
<script>
    /* if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
         alert('You pressed "Back" or "Forward" button. Transaction will be cancelled.');
         var urlvalue=document.getElementById("redirectionurl").value;
         window.location=urlvalue;
     }*/
</script>
<?php
$json_str = file_get_contents('php://input');
if($json_str!=null) {
	$_POST = array_merge($_POST, (array) json_decode(file_get_contents('php://input')));
} else {
	$_POST = $_POST;
}

header("Cache-Control: no-cache, must-revalidate");
?>

<!-- <div id="blurme"> -->
<?php
require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
error_reporting(0);
require_once('api/encrypt.php');
require_once('api/baseurl.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

/**** DB Connection ****/
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

$merchant_id = trim($_POST['merchant_id']);
$db->where("pg_merchant_id", $merchant_id);
$vendorDet = $db->getone('vendor_config');

$vendor_name = $vendorDet['vendor_name']!='' ? $vendorDet['vendor_name'] : '';

$amount = trim($_POST["amount"]); // mc_encrypt($_POST["amount"], $dkey);

if(isset($_POST['amount'])) {
    $amount   = dec_enc('encrypt', $_POST['amount']);
    $deamount = dec_enc('decrypt', $amount);
}


/**** Get the NetBanking's Bank List ****/
$CP_query="SELECT vendor_config.vendor_id, vendor_config.vendor_name, vendor_config.pg_merchant_id, vendor_bank_details.bank_code, vendor_bank_details.bank_name, vendor_bank_details.Emi_tenures, vendor_bank_details.Emi_tenures_percent, vendor_bank_details.Min_amount, vendor_bank_details.TnC FROM vendor_config JOIN vendor_bank_details ON vendor_config.vendor_id = vendor_bank_details.vendor_id AND vendor_config.vendor_active_status AND vendor_config.vendor_name='$vendor_name' AND vendor_config.pg_merchant_id='$merchant_id' AND vendor_config.vendor_payment_options='CP'";
$vendorCP_Details = $db->rawQuery($CP_query);

/**** Get the NetBanking's Bank List ****/
$NB_query="SELECT vendor_config.vendor_name, vendor_config.pg_merchant_id, vendor_bank_details.bank_code, vendor_bank_details.bank_name FROM vendor_config JOIN vendor_bank_details ON vendor_config.vendor_id = vendor_bank_details.vendor_id AND vendor_config.vendor_active_status AND vendor_config.vendor_name='$vendor_name' AND vendor_config.pg_merchant_id='$merchant_id' AND vendor_config.vendor_payment_options='NB'";
$vendorNB_Details = $db->rawQuery($NB_query);

/**** Get the Wallet's Wallet List ****/
$WT_query="SELECT vendor_config.vendor_name, vendor_config.pg_merchant_id, vendor_bank_details.bank_code, vendor_bank_details.bank_name FROM vendor_config JOIN vendor_bank_details ON vendor_config.vendor_id = vendor_bank_details.vendor_id AND vendor_config.vendor_active_status AND vendor_config.vendor_name='$vendor_name' AND vendor_config.pg_merchant_id='$merchant_id' AND vendor_config.vendor_payment_options='WT'";
$vendorWT_Details = $db->rawQuery($WT_query);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    function alipay() {
        $("#test").show();
        $("#test1").hide();
    }
    function debcred(){
        $("#test").hide();
        $("#test1").show();
    }
</script>

<!-- <div id="test1" style="display:block;">
<style>
    .fake-input { position: relative; width:100%; padding-left: 16px; padding-right: 16px; }
    .fake-input input { border:none: background:#fff; display:block; width: 100%; box-sizing: border-box }
    .fake-input img { position: absolute; top: 2px; right: 17px }
</style> -->

<!DOCTYPE html>
<html>
<head>
<title>Paysez - Payment Form</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Payment Form Widget Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="phpform/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Alegreya+Sans:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script type="text/javascript" src="phpform/js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<style type="text/css">
.submit_btn {
	padding: 8px 10px;
    font-size: 14px;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    background: #B5E045;
    box-shadow: none;
    max-width: 200px;
    width: 100%;
}

#emi_div p {
	font-size: 14px;
	color: #20a52a;
}
</style>

</head>
<body>

	<div id="pageloaddiv">
	    <div class="status"></div>
	</div>

	<div class="main">
		<h1 style="display: none;">Payment Form Widget</h1>
		<div class="content">
			
			<script src="phpform/js/easyResponsiveTabs.js" type="text/javascript"></script>
					<script type="text/javascript">
						$(document).ready(function () {
							$('#horizontalTab').easyResponsiveTabs({
								type: 'default', //Types: default, vertical, accordion           
								width: 'auto', //auto or any width like 600px
								fit: true   // 100% fit in a container
							});

							$("li.resp-tab-item").removeClass('resp-tab-active');
							$(".resp-accordion").removeClass('resp-tab-active');
							$(".resp-tab-content").removeClass('resp-tab-content-active');
							$(".resp-tab-content").hide();
							$(".resp-tabs-container").hide();

							$("#emioptions").hide();
						
							$(".resp-tabs-list li").click(function() {
								// remove previously added selectedLi
								$('.selectedLi').removeClass('selectedLi');
								// add class `selectedLi`
								$(this).addClass('selectedLi');
								$(".resp-tabs-container").show();

								$("li.resp-tab-item").removeClass('resp-tab-active');
								$(this).addClass('resp-tab-active');

								var selText = $(this).data("id"); // $(this).text();///User selected value...****
								console.log(selText);
								$('#payment_option').val(selText);
								if(selText == 'CardPayment') {
									$("#emioptions").hide();
									$('#channel').val('Pg');
									$('#payform').attr('action','https://pg.credopay.net/api/PaysezAppPG.php');
								}
								if(selText == 'UPIPayment') {
									$("#emioptions").hide();
									$('#channel').val('UPI');
									$('#payform').attr('action','PaysezWebaction.php');
								}
								if(selText == 'NetBanking') {
									$("#emioptions").hide();
									$('#channel').val('Nb');
									$('#payform').attr('action','PaysezNBaction.php');
								}
								if(selText == 'Wallets') {
									$("#emioptions").hide();
									$('#channel').val('Ppc');
									$('#payform').attr('action','PaysezWTaction.php');
								}
								// $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+
								// ' <span class="caret"></span>');
							});

							// $(".tab-form-left input[name$='emi_option']").click(function() {
							$("input[name$='emi_option']").click(function() {
						        var test = $(this).val();
						        console.log(test+'=>'+$('#vendor').val());
						        var vendor = $('#vendor').val();
						        if(vendor == "AirPay") {
						        	if(test == 1) {
							        	$('#channel').val('Pg');
										$('#payform').attr('action','PaysezWebEaction.php');
							        	$("#emioptions").show();
							        } else {
							        	$('#channel').val('Pg');
										$('#payform').attr('action','https://pg.credopay.net/api/PaysezAppPG.php');
							        	$("#emioptions").hide();
							        }
						        } else {
						        	if(test == 1) {
							        	$('#channel').val('Pg');
										$('#payform').attr('action','PaysezWebEaction.php');
							        	$("#emioptions").show();
							        } else {
							        	$('#channel').val('Pg');
										$('#payform').attr('action','PaysezWebEaction.php');
							        	$("#emioptions").hide();
							        }
						        }
						    });

							$("div#emi_div").hide();
							$('select.emibank').change(function() {
							    var emibank = $(this).val();
							    var res     = emibank.split(":");
							    var tncLink = $("#"+res[0]+"_tnc_link").val();

							    $.ajax({
				                    method: "POST",
				                    url: "cardencrypt.php",
				                    data:'from=EMI_Cal&bank_code='+emibank+'&p_type=CP&tnc_link='+tncLink,
				                    success: function(response) {
				                    	console.log(response);
				                    	$("div#emi_div").show();
							        	$("div#emi_div").html(response);
							        }
				                });
							});

						});

						// function submit_1() {
						// 	if(confirm("Verify the Details are correct and Click OK to Proceed")) {
						// 		$("#pageloaddiv").show();
						// 		return true;
						// 	} else {
						// 		return false;
						// 	}
						// }

						function loadDoc_1() {
							// alert("Hi");
							var amount    = $('#ptamount').val();
							var cardnum   = $('#card_no').val();
							var expiry_mm = $('#expiry_mm').val();
							var expiry_yy = $('#expiry_yy').val();
							var card_cvv  = $('#card_cvv').val();

							console.log(amount+'=>'+cardnum+'=>'+expiry_mm+'=>'+expiry_yy+'=>'+card_cvv);

					        $.ajax({
					            type: 'POST',
					            url:  "<?php echo 'cardencrypt.php'; ?>",
					            data: {
					            	'amount': amount,
					            	'cardnum': cardnum,
					            	'expiry_mm': expiry_mm,
					            	'expiry_yy': expiry_yy,
					            	'card_cvv': card_cvv
					            },
					            success: function (data) {
					                var aaa= data.trim();
					                $('#encData').val(data);
					            }
					        });
						}

						function loadDoc_2() {
							// alert("Hi");
							var amount    = $('#ptamount').val();
							var bankCode   = $('#bankCode').val();

							console.log(amount+'=>'+bankCode);

					        $.ajax({
					            type: 'POST',
					            url:  "<?php echo 'cardencrypt.php'; ?>",
					            data: {
					            	'amount': amount,
					            	'bankCode': bankCode
					            },
					            success: function (data) {
					                var aaa= data.trim();
					                $('#encData').val(data);
					            }
					        });
						}

						function loadDoc_3() {
							// alert("Hi");
							var amount    = $('#ptamount').val();
							var prepaid_radio   = $('#prepaid_radio').val();

							console.log(amount+'=>'+prepaid_radio);

					        $.ajax({
					            type: 'POST',
					            url:  "<?php echo 'cardencrypt.php'; ?>",
					            data: {
					            	'amount': amount,
					            	'prepaid_radio': prepaid_radio
					            },
					            success: function (data) {
					                var aaa= data.trim();
					                $('#encData').val(data);
					                return true;
					            }
					        });
						}

						function checkcard() {
					        var st=$('#card_no').val();
					        $.ajax({
					            type: 'POST',
					            url: "<?php echo 'cardtype.php?cardno=';?>"+st,
					            data: {
					                'cardno': st
					            },
					            success: function (data) {
					                //var str = ;
					                //alert(data);
					                var aaa= data.trim();
					                if (aaa == "American Express") { 
					                } else if(aaa=="Maestro") {
					                } else if(aaa=="Mastercard") {
					                    $('#tax').val('MC');
					                } else if(aaa=="Visa") {
					                    $('#tax').val('VISA');
					                    $("#merchant_id").val('115');
					                } else if(aaa=="JCB") {
					                } else if(aaa=="Solo") {
					                } else if(aaa=="Diners Club") {
					                } else if(aaa=="Laser") {
					                } else if(aaa=="Rupay") {
					                    $('#tax').val('RUPAY');
					                } else {
					                }
					            }
					        });
					    }

					</script>
						<div class="sap_tabs">
							<form id="payform" action="" method="post">
							<!-- <form action="airpay_php/sendtoairpay.php" method="post" > -->

							<!-- <input type="hidden" name="card_name" id="card_name" value=""> -->
							<input type="hidden" name="tax" id="tax" value="">

							<input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $_POST['merchant_id']; ?>">

							<input type="hidden" name="encData" id="encData" value="">

							<input type="hidden" name="vendor" id="vendor" value="<?php echo $vendor_name; ?>">

			                <input type="hidden" name="amount" id="ptamount" value="<?php echo $amount; // echo number_format((float)$_POST['amount'], 2, '.', ''); ?>">
			                <input type="hidden" name="currency" id="currency" value="356">
			                <input type="hidden" name="isocurrency" id="isocurrency" value="<?php echo $_POST['currency']; ?>">
			                <input type="hidden" name="env" id="env" value="<?php echo $_POST['env']; ?>">
			                <input type="hidden" name="timestamp" id="timestamp" value="<?php echo $_POST['timestamp']; ?>">
			                <input type="hidden" name="Transaction_id" id="Transaction_id" value="<?php echo $_POST['Transaction_id']; ?>">
			                <input type="hidden" name="TransactionType" id="TransactionType" value="<?php if($_POST['TransactionType'] == "AA") { echo $_POST['TransactionType']; } else { echo "AA"; } ?>">
			                <input type="hidden" name="redirectionurl" value="<?php echo $_POST['redirectionurl']; ?>">

			                <input type="hidden" name="buyerEmail" id="buyerEmail" value="<?php echo $_POST['buyerEmail']; ?>">
			                <input type="hidden" name="buyerPhone" id="buyerPhone" value="<?php echo $_POST['buyerPhone']; ?>">
			                <!-- <input type="hidden" name="orderid" id="orderid" value="<?php //echo $_POST['orderid']; ?>"> -->

			                <input type="hidden" name="buyerFirstName" id="buyerFirstName" value="<?php echo $_POST['buyerFirstName']; ?>">
			                <input type="hidden" name="buyerLastName" id="buyerLastName" value="<?php echo $_POST['buyerLastName']; ?>">
			                <input type="hidden" name="buyerAddress" id="buyerAddress" value="<?php echo $_POST['buyerAddress']; ?>">
			                <input type="hidden" name="buyerCity" id="buyerCity" value="<?php echo $_POST['buyerCity']; ?>">
			                <input type="hidden" name="buyerState" id="buyerState" value="<?php echo $_POST['buyerState']; ?>">
			                <input type="hidden" name="buyerPinCode" id="buyerPinCode" value="<?php echo $_POST['buyerPinCode']; ?>">
			                <input type="hidden" name="buyerCountry" id="buyerCountry" value="<?php echo $_POST['buyerCountry']; ?>">
			                <input type="hidden" name="customvar" id="customvar" value="">
			                <input type="hidden" name="txnsubtype" id="txnsubtype" value="">

							<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
								<div class="pay-tabs">
									<h5 style="font-size: 16px; margin: 0 0 0 22px; color: #9094c3;">Payment Amount : <b><?php echo number_format($deamount, 2); ?></b></h5>
									<h2>Select Payment Method</h2>
										<input type="hidden" name="payment_option" id="payment_option" value="">
										<input type="hidden" name="channel" id="channel" value="">
										<ul class="resp-tabs-list">
											<li class="resp-tab-item" data-id="CardPayment" aria-controls="tab_item-0" role="tab"><span><label class="pic1"></label>Credit / Debit</span></li>
											<li class="resp-tab-item" data-id="NetBanking" aria-controls="tab_item-1" role="tab"><span><label class="pic3"></label>Net Banking</span></li>
											<li class="resp-tab-item" data-id="UPIPayment" aria-controls="tab_item-2" role="tab"><span><label class="pic2"></label>UPI</span></li> 
											<li class="resp-tab-item" data-id="Wallets" aria-controls="tab_item-3" role="tab"><span><label class="pic2"></label>Wallets</span></li>
											<div class="clear"></div>
										</ul>	
								</div>
								<div class="resp-tabs-container">
									<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
										<div class="payment-info">
											<h3 style="display: none;">Personal Information</h3>
											<!-- <form style="display: none;"> -->
												<div class="tab-for" style="display: none;">				
													<h5>EMAIL ADDRESS</h5>
														<input type="text" value="">
													<h5>FIRST NAME</h5>													
														<input type="text" value="">
												</div>			
											<!-- </form> -->
											<h3 class="pay-title">Credit / Debit Card Info</h3>
											<!-- <form> -->
												<div class="tab-for">				
													<h5>NAME ON CARD</h5>
														<input type="text" name="nameoncard" value="">
													<h5>CARD NUMBER</h5>													
														<!-- <input class="pay-logo" name="card_num" type="text" value="0000-0000-0000-0000" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '0000-0000-0000-0000';}" required=""> -->

														<input class='pay-logo' type='text' onload="checkcard();" onclick="checkcard();" onblur="checkcard();" id="card_no" name="card_num" value='<?php if ($_POST['card_num']!="") { $var = $_POST['card_num']; $var = substr_replace($var, str_repeat("X", 8), 4, 8); echo $var;  } ?>' <?php if($senter=="success"){ echo "disabled"; } ?>>

												</div>	
												<div class="transaction">
													<div class="tab-form-left user-form">
														<h5>EXPIRATION</h5>
															<ul>
																<li>
																	<input name="expiry_mm" id="expiry_mm" type="number" class="text_box" type="text" value="06" min="1" />	
																</li>
																<li class="year">
																	<input name="expiry_yy" id="expiry_yy" type="number" class="text_box" type="text" value="19" min="1" />	
																</li>
															</ul>
													</div>
													<div class="tab-form-right user-form-rt">
														<h5>CVV NUMBER</h5>			
														<!-- <input name="card_cvv" type="text" value="xxxx" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'xxxx';}" required=""> -->
														<input name="card_cvv" id="card_cvv" type="password" maxlength="3" value="" onchange="loadDoc_1();">
													</div>
													<div class="clear"></div>
												</div>

												<div class="transaction">
													<div class="tab-form-left user-form">
														<h5>EMI OPTIONS</h5>
														<input type="radio" name="emi_option" value="1">YES&nbsp;&nbsp;
														<input type="radio" name="emi_option" value="0">NO
													</div>

													<!-- <div class="tab-form-right user-form-rt" id="emioptions_1">
														<h5>EMI BANK</h5>			
														<select class="emibank" name="emibank">
															<option value="">--SELECT--</option>
															<option value="AMEXEMI">AMEX EMI</option>
															<option value="AXISEMI">AXIS EMI</option>
															<option value="HDFCEMI">HDFC EMI</option>
															<option value="KOTAKEMI">KOTAK EMI</option>
															<option value="ICICIEMI">ICICI EMI</option>
															<option value="FDATASC">F DATA SC</option>
														</select>
														<h5>TENURE MONTHS</h5>			
														<select class="tenure_months" name="emitenure">
															<option value="">--SELECT--</option>
															<option value="3">3 MONTHS</option>
															<option value="6">6 MONTHS</option>
															<option value="9">9 MONTHS</option>
															<option value="12">12 MONTHS</option>
														</select>
													</div> -->

													<div class="clear"></div>
												</div>

												<input type="submit" name="btnsubmit_1" class="submit_btn" value="MAKE PAYMENT">
											<!-- </form> -->
											<!-- <div class="single-bottom">
													<ul>
														<li>
															<input type="checkbox"  id="brand" value="">
															<label for="brand"><span></span>By checking this box, I agree to the Terms & Conditions & Privacy Policy.</label>
														</li>
													</ul>
											</div> -->
										</div>
									</div>
									<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
										<div class="payment-info">
											<h3>Net Banking</h3>
											<!-- <div>
												<select>
													<option value="">HDFC BANK</option>
													<option value="">AXIS BANK</option>
													<option value="">YES BANK</option>
													<option value="">KOTAK BANK</option>
													<option value="">ALLAHABAD BANK</option>
													<option value="">ANDHRA BANK</option>
													<option value="">BANK OF BARODA</option>
												</select>
											</div> -->
											<!-- <div class="tab-for">
												<h5>SELECT BANK</h5>
												<div class="custom-select">
													<select id="example">
														<option value="">Option 1</option>
														<option value="">Option 2</option>
														<option value="">Option 3</option>
													</select>
												</div>
											</div> -->
											<div class="tab-for">
												<h5>SELECT BANK</h5>
												<div class="custom-select">
													<select name="bankCode" id="bankCode" onchange="loadDoc_2();">
														<option value="">SELECT BANK</option>
														<?php
														foreach ($vendorNB_Details as $key => $value) {
															echo "<option value='".$value['bank_code']."'>".$value['bank_name']."</option>";
														}
														?>
													</select>
												</div>
											</div>
											<br>
											<input type="submit" name="btnsubmit_2" class="submit_btn" value="MAKE PAYMENT">
											<!-- <a href="#">Continue</a> -->
										</div>
									</div>
									<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-2">
										<div class="payment-info">
											<h3>UPI Payment</h3>
											<!-- <h4>Already Have A UPI Account?</h4> -->
											<div class="login-tab">
												<div class="user-login">
													<!-- <h2>Login</h2> -->
													
													<div class="tab-for">
													<!-- <form> -->
														<h5>ENTER VPA ID</h5>
														<input type="text" value="name@email.com" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'name@email.com';}" required="">
														<!-- <input type="password" value="PASSWORD" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'PASSWORD';}" required=""> -->
															<div class="user-grids">
																<!-- <div class="user-left">
																	<div class="single-bottom">
																			<ul>
																				<li>
																					<input type="checkbox"  id="brand1" value="">
																					<label for="brand1"><span></span>Remember me?</label>
																				</li>
																			</ul>
																	</div>
																</div> -->
																<div class="user-right">
																	<input type="submit" name="btnsubmit_3" class="submit_btn" value="PAY">
																</div>
																<div class="clear"></div>
															</div>
													<!-- </form> -->
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-3">	
										<div class="payment-info">
											<h3>Wallets</h3>
											<!-- <form> -->
												<div class="tab-for">
													<h5>SELECT WALLET</h5>
													<div class="custom-select">
														<!-- <select id="example1">
															<option value="">Option 1</option>
															<option value="">Option 2</option>
															<option value="">Option 3</option>
														</select> -->
														<select name="prepaid_radio" id="prepaid_radio" onchange="loadDoc_3();">
															<option value="">SELECT WALLET</option>
															<?php
															foreach ($vendorWT_Details as $key => $value) {
																echo "<option value='".$value['bank_code']."'>".$value['bank_name']."</option>";
															}
															?>
															<!-- <option value="OXI">OxiCash</option>
															<option value="MONEY">MoneyonMobile</option>
															<option value="MOBIK">MobiKwik</option>
															<option value="PAYU">Payu</option>
															<option value="QUICK">QuickWallet</option>
															<option value="OLA">Ola</option>
															<option value="JIO">JIOMONEY</option>
															<option value="HDFCPP">PayZapp</option>
															<option value="SBUD">SBI Buddy</option>
															<option value="FREE">FreeCharge</option>
															<option value="AMAZON">Amazon</option> -->
														</select>
													</div>
												</div>
												<!-- <div class="tab-for">				
													<h5>NAME ON CARD</h5>
														<input type="text" value="">
													<h5>CARD NUMBER</h5>													
														<input class="pay-logo" type="text" value="0000-0000-0000-0000" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '0000-0000-0000-0000';}" required="">
												</div>	
												<div class="transaction">
													<div class="tab-form-left user-form">
														<h5>EXPIRATION</h5>
															<ul>
																<li>
																	<input type="number" class="text_box" type="text" value="6" min="1" />	
																</li>
																<li>
																	<input type="number" class="text_box" type="text" value="1988" min="1" />	
																</li>
																
															</ul>
													</div>
													<div class="tab-form-right user-form-rt">
														<h5>CVV NUMBER</h5>													
														<input type="text" value="xxxx" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'xxxx';}" required="">
													</div>
													<div class="clear"></div>
												</div> -->
												<br>
												<!-- <input type="submit" name="btnsubmit_4" class="submit_btn" value="SUBMIT"> -->
												<input type="submit" name="btnsubmit_4" class="submit_btn" value="MAKE PAYMENT" id="btnsubmit_4">
											<!-- </form> -->
											<div class="single-bottom" style="display: none;">
													<ul>
														<li>
															<input type="checkbox"  id="brand" value="">
															<label for="brand"><span></span>By checking this box, I agree to the Terms & Conditions & Privacy Policy.</label>
														</li>
													</ul>
											</div>
										</div>	
									</div>
								</div>	

								<div class="emi-container" id="emioptions">
									<div class="payment-info anthr">
										<h4>Pay Using EMI</h4>

										<h5>Please Select your EMI from the list below.</h5>
										<select class="emibank" name="emibank">
											<option value="">--SELECT--</option>
											<?php
											foreach ($vendorCP_Details as $key => $value) {
												echo "<option value='".$value['bank_code'].":".$value['vendor_id'].":".$value['Emi_tenures'].":".$value['Emi_tenures_percent'].":".$value['Min_amount'].":".$amount."'>".$value['bank_name']."</option>";
											}
											?>
										</select>
										<?php
										foreach ($vendorCP_Details as $key => $value) {
											echo "<input type='hidden' id='".$value['bank_code']."_tnc_link' name='tnc_link' value='".$value['TnC']."'>";
										}
										?>

										<div id="emi_div"></div>

										<h6>For refund policy or queries on foreclosure of EMI please contact the issuing bank<br> offering the EMI.</h6>

										<i>Applicable GST will be available on Interest Component of EMI.</i>

									</div>
								</div>

							</div>
							</form>
						</div>	

		</div>
		<p class="footer" style="display: none;">Copyright © 2016 Payment Form Widget. All Rights Reserved | Template by <a href="https://w3layouts.com/" target="_blank">w3layouts</a></p>
	</div>
</body>
</html>
	<!-- </div>
</div> -->

