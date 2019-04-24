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
header("Cache-Control: no-cache, must-revalidate");
?>

<?php
error_reporting(0);
require_once('api/encrypt.php');
require_once('api/baseurl.php');


// if($_POST) {
// 	echo "<pre>";
// 	print_r($_POST);
// }
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

<!DOCTYPE html>
<html>
<head>
<title>Payment Form</title>
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
<script type="text/javascript" src="phpform/js/jquery.min.js"></script>

<style type="text/css">
.submit_btn {
	padding: 8px 10px;
    font-size: 14px;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    background: #B5E045;
    box-shadow: none;
}
</style>

</head>
<body>
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

							// $("li.resp-tab-item").removeClass('resp-tab-active');
						
							$(".resp-tabs-list li").click(function() {
								// remove previously added selectedLi
								$('.selectedLi').removeClass('selectedLi');
								// add class `selectedLi`
								$(this).addClass('selectedLi');

								// $("li.resp-tab-item").removeClass('resp-tab-active');
								// $(this).addClass('resp-tab-active');

								var selText = $(this).data("id"); // $(this).text();///User selected value...****
								console.log(selText);
								$('#payment_option').val(selText);
								if(selText == 'NetBanking') {
									$('#channel').val('Nb');
								}
								if(selText == 'Wallets') {
									$('#channel').val('Ppc');
								}
								// $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+
								// ' <span class="caret"></span>');
							});

						});

					</script>
						<div class="sap_tabs">
							<form action="PaysezWebaction.php" method="post">
							<!-- <form action="airpay_php/sendtoairpay.php" method="post" > -->

							<input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $_POST['merchant_id']; ?>">
			                <input type="hidden" name="amount" id="ptamount" value="<?php echo number_format((float)$_POST['amount'], 2, '.', ''); ?>">
			                <input type="hidden" name="currency" id="currency" value="356">
			                <input type="hidden" name="isocurrency" id="isocurrency" value="<?php echo $_POST['currency']; ?>">
			                <input type="hidden" name="env" id="env" value="<?php echo $_POST['env']; ?>">
			                <input type="hidden" name="timestamp" id="timestamp" value="<?php echo $_POST['timestamp']; ?>">
			                <input type="hidden" name="Transaction_id" id="Transaction_id" value="<?php echo $_POST['Transaction_id']; ?>">
			                <input type="hidden" name="TransactionType" id="TransactionType" value="<?php echo $_POST['TransactionType']; ?>">
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
												</div>
												<input type="submit" name="btnsubmit_1" class="submit_btn" value="SUBMIT">
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
													<select name="bankCode">
														<option value="">SELECT BANK</option>
														<option value="HDF">HDFC BANK</option>
														<option value="AXIS">AXIS BANK</option>
														<option value="YES">YES BANK</option>
														<option value="KOT">KOTAK BANK</option>
														<option value="BDBDALB">ALLAHABAD BANK</option>
														<option value="BDBDADB">ANDHRA</option>
														<option value="BDBDBBR">BANK OF BARODA</option>
														<option value="BDBDBOI">BANK OF INDIA</option>
														<option value="BDBDCNB">CANARA BANK</option>
														<option value="BDBDCSB">CATHOLIC SYRIAN BANK</option>
														<option value="CBI">CENTRAL BANK OF INDIA</option>
														<option value="BDBDCUB">CITY UNION BANK</option>
														<option value="BDBDCOB">COSMOS BANK</option>
														<option value="BDBDDEN">DENA BANK</option>
														<option value="BDBDDCB">DEVELOPMENT CREDIT BANK</option>
														<option value="BDBDDLB">DHANLAKSHMI BANK</option>
														<option value="BDBDIDB">IDBI BANK</option>
														<option value="BDBDIOB">INDIAN OVERSEAS BANK</option>
														<option value="INDBK">INDIAN BANK</option>
														<option value="IndusInd">INDUSIND BANK</option>
														<option value="BDBDING">ING VYSYA BANK</option>
														<option value="BDBDJKB">JAMMU AND KASHMIR BANK</option>
														<option value="BDBDKBL">KARNATAKA BANK LTD</option>
														<option value="BDBDKVB">KARUR VYSYA BANK</option>
														<option value="BDBDLVC">LAXMI VILAS BANK</option>
														<option value="BDBDOBC">ORIENTAL BANK OF COMMERCE</option>
														<option value="BDBDPSB">PUNJAB AND SIND BANK</option>
														<option value="BDBDPNB">PUNJAB NATIONAL BANK</option>
														<option value="RBL">RATNAKAR BANK</option>
														<option value="BDBDSIB">SOUTH INDIAN BANK</option>
														<option value="BDBDSCB">STANDARD CHARTERED BANK</option>
														<option value="BDBDUBI">UNION BANK OF INDIA</option>
														<option value="BDBDUNI">UNITED BANK OF INDIA</option>
														<option value="BDBDVJB">VIJAYA BANK</option>
														<option value="ICICI">ICICI BANK</option>
														<option value="SBINB">STATE BANK OF INDIA</option>
														<option value="MAHNETBNK">BANK OF MAHARASHTRA</option>
														<option value="SBIBNJ">STATE BANK OF BIKANER AND JAIPUR</option>
														<option value="SBH">STATE BANK OF HYDERABAD</option>
														<option value="SBM">STATE BANK OF MYSORE</option>
														<option value="SBP">STATE BANK OF PATIALA</option>
														<option value="SBT">STATE BANK OF TRAVANCOR</option>
														<option value="VIJAYA">VIJAYA BANK</option>
														<option value="FEDERAL">FEDERAL BANK</option>
														<option value="BDBDBBC">BANK OF BARODA CORPORATE</option>
														<option value="BDBDDC2">DEVELOPMENT CREDIT BANK CORPORATE</option>
														<option value="BDBDCPN">PNB CORPORATE</option>
														<option value="BDBDSVC">SHYAMRAO VITTAL</option>
														<option value="SRST">SARASWAT BANK</option>
														<option value="BDBDSYD">SYNDICATE BAN</option>
														<option value="CORP">CORPORATION BANK</option>
														<option value="DEUT">DEUTSCHE BANK</option>
														<option value="INDBK">INDIAN BANK</option>
														<option value="BDBDUCO">UCOBANK</option>
														<option value="INDUSIND">INDUSIND BANK</option>
														<option value="BDBDTJB">TJSBBank</option>
														<option value="UNBI">UNION BANK Of INDIA</option>
														<option value="BDBDBCB">BASSIENCATHOLICCO-OPERATIVEBank</option>
														<option value="SRST">SARAWAT BANK</option>
													</select>
												</div>
											</div>
											<br>
											<input type="submit" name="btnsubmit_2" class="submit_btn" value="SUBMIT">
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
														<select>
															<option value="">SELECT WALLET</option>
															<option value="OXI">OxiCash</option>
															<option value="MONEY">MoneyonMobile</option>
															<option value="MOBIK">MobiKwik</option>
															<option value="PAYU">Payu</option>
															<option value="QUICK">QuickWallet</option>
															<option value="OLA">Ola</option>
															<option value="JIO">JIOMONEY</option>
															<option value="HDFCPP">PayZapp</option>
															<option value="SBUD">SBI Buddy</option>
															<option value="FREE">FreeCharge</option>
															<option value="AMAZON">Amazon</option>
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
												<input type="submit" name="btnsubmit_4" class="submit_btn" value="SUBMIT">
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
							</div>
							</form>
						</div>	

		</div>
		<p class="footer" style="display: none;">Copyright © 2016 Payment Form Widget. All Rights Reserved | Template by <a href="https://w3layouts.com/" target="_blank">w3layouts</a></p>
	</div>
</body>
</html>

