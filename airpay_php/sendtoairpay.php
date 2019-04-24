<?php
date_default_timezone_set('Asia/Kolkata');
header( 'Expires: Sat, 26 Jul 2019 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

	include('config.php');

	$buyerEmail = trim($_POST['buyerEmail']);
	$buyerPhone = trim($_POST['buyerPhone']);
	$buyerFirstName = trim($_POST['buyerFirstName']);
	$buyerLastName = trim($_POST['buyerLastName']);
	$buyerAddress = trim($_POST['buyerAddress']);
	$amount = trim($_POST['amount']);
	$buyerCity = trim($_POST['buyerCity']);
	$buyerState = trim($_POST['buyerState']);
	$buyerPinCode = trim($_POST['buyerPinCode']);
	$buyerCountry = trim($_POST['buyerCountry']);

	$_POST['orderid'] = $mercid.date('YmdHis');
	$orderid = trim($_POST['orderid']); //Your System Generated Order ID

	// $orderid = $mercid.date('YmdHis');

	$currency = trim($_POST['currency']); // trim($_POST['channel']);
	$bankCode = trim($_POST['bankCode']); // trim($_POST['channel']);
	$channel  = trim($_POST['channel']);

	// if($_POST['payment_option'] == "NetBanking") {
	// 	$channel  = 'Nb';
	// }

	// if($_POST['payment_option'] == "Wallets") { 
	// 	$channel  = 'Ppc'; 
	// }

	// echo "<pre>";
	// print_r($_POST);
	// echo "<br>";
	// exit;

    include('checksum.php');
    include('validation.php');

	$alldata   = $buyerEmail.$buyerFirstName.$buyerLastName.$buyerAddress.$buyerCity.$buyerState.$buyerCountry.$amount.$orderid;
	$privatekey = Checksum::encrypt($username.":|:".$password, $secret);
	$checksum = Checksum::calculateChecksum($alldata.date('Y-m-d'),$privatekey);
  	$hiddenmod = "";

  	// echo $checksum;
  	// echo "<br>";

  	// Checksum::outputForm($checksum);
  	// exit;
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3./org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Airpay</title>
<script type="text/javascript">
function submitForm(){
	var form = document.forms[0];
	form.submit();
}
</script>
</head>
<body onload="javascript:submitForm();">
<center>
<table width="500px;">
	<tr>
		<td align="center" valign="middle">Do Not Refresh or Press Back <br/> Redirecting to Airpay</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<form action="https://payments.airpay.co.in/pay/directindexapi.php" method="post">
                <input type="hidden" name="privatekey" value="<?php echo $privatekey; ?>">
                <input type="hidden" name="mercid" value="<?php echo $mercid; ?>">
				<input type="hidden" name="orderid" value="<?php echo $orderid; ?>">
 		        <input type="hidden" name="currency" value="356">
		        <input type="hidden" name="isocurrency" value="<?php echo $currency; ?>">
				<input type="hidden" name="chmod" value="<?php echo $hiddenmod; ?>">			
				<?php
				// Checksum::outputForm($checksum);
				?>
				<input type="hidden" name="checksum" value="<?php echo $checksum; ?>">

				<input type="hidden" name="buyerEmail" value="<?php echo $buyerEmail; ?>">
				<input type="hidden" name="buyerPhone" value="<?php echo $buyerPhone; ?>">
				<input type="hidden" name="buyerFirstName" value="<?php echo $buyerFirstName; ?>">
				<input type="hidden" name="buyerLastName" value="<?php echo $buyerLastName; ?>">
				<input type="hidden" name="buyerAddress" value="">
				<input type="hidden" name="buyerCity" value="">
				<input type="hidden" name="buyerState" value="">
				<input type="hidden" name="buyerCountry" value="">
				<input type="hidden" name="buyerPinCode" value="">
				<input type="hidden" name="amount" value="<?php echo $amount; ?>">
				<input type="hidden" name="customvar" value="<?php echo $customvar; ?>">
				<input type="hidden" name="txnsubtype" value="<?php echo $txnsubtype; ?>">
				<input type="hidden" name="channel" value="<?php  echo $channel; ?>">
				<input type="hidden" name="bankCode" value="<?php echo $bankCode; ?>">

			</form>
		</td>

	</tr>

</table>

</center>
</body>
</html>
