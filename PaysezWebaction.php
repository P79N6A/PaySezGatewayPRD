<?php
date_default_timezone_set('Asia/Kolkata');
header( 'Expires: Sat, 26 Jul 2019 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';

error_reporting(0);
require_once('api/encrypt.php');
require_once('api/baseurl.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

// ****DB Connection****
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

// $merchantDet = $db->get('merchants');
// echo "<pre>";
// print_r($merchantDet); exit;

// ****Airpay Config****
include('airpay_php/config.php');

echo "<pre>";
print_r($_POST);
echo "<br>"; exit;

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

$orderid = $mercid.date('YmdHis');

// ****Airpay Privatekey and Checksum Creation / Validation****
include('airpay_php/checksum.php');
include('airpay_php/validation.php');
$alldata   = $buyerEmail.$buyerFirstName.$buyerLastName.$buyerAddress.$buyerCity.$buyerState.$buyerCountry.$amount.$orderid;
$privatekey = Checksum::encrypt($username.":|:".$password, $secret);
$checksum = Checksum::calculateChecksum($alldata.date('Y-m-d'),$privatekey);
$hiddenmod = "";

// ****Log Paths****
$payment_option = $_POST['payment_option'];
if($payment_option == "NetBanking") {
	$log_path = '/var/www/html/testspaysez/api/transactions_NB.log';
}
if($payment_option == "Wallets") {
	$log_path = '/var/www/html/testspaysez/api/transactions_WT.log';
}
// ****Log Function****
function logwrite($log) {
	GLOBAL $log_path;
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}

$logs = "Airpay Transaction Request Data:".date("Y-m-d H:i:s") . "," .json_encode($_POST). " \n\n";
logwrite($logs);

// echo "<pre>";
// print_r($_POST);
// echo "<br>";

$post_array = [];
$post_array['buyerEmail']     = trim($_POST['buyerEmail']);
$post_array['buyerPhone']     = trim($_POST['buyerPhone']);
$post_array['buyerFirstName'] = trim($_POST['buyerFirstName']);
$post_array['buyerLastName']  = trim($_POST['buyerLastName']);
$post_array['buyerAddress']   = trim($_POST['buyerAddress']);
$post_array['buyerCity']      = trim($_POST['buyerCity']);
$post_array['buyerState']     = trim($_POST['buyerState']);
$post_array['buyerCountry']   = trim($_POST['buyerCountry']);
$post_array['buyerPinCode']   = trim($_POST['buyerPinCode']);
$post_array['amount']         = trim($_POST['amount']);
$post_array['customvar']      = trim($_POST['customvar']);
$post_array['txnsubtype']     = trim($_POST['txnsubtype']);

if($_POST['payment_option'] == "NetBanking") {
	$post_array['channel']        = trim($_POST['channel']);
	$post_array['bankCode']       = trim($_POST['bankCode']);
}
if($_POST['payment_option'] == "Wallets") { 
	$post_array['channel']        = trim($_POST['channel']);
	$post_array['prepaid_radio']  = trim($_POST['prepaid_radio']); 
}

$post_array['privatekey']  = $privatekey;
$post_array['mercid']      = $mercid;
$post_array['orderid']     = $orderid;
$post_array['currency']    = trim($_POST['currency']);
$post_array['isocurrency'] = trim($_POST['isocurrency']);
$post_array['chmod']       = $hiddenmod;

$post_array['checksum']    = $checksum;

$logs = "Airpay ".$payment_option." Request Data:".date("Y-m-d H:i:s") . "," .json_encode($post_array). " \n\n";
logwrite($logs);

// echo "<pre>";
// print_r($post_array); exit;

// "NB_savecard" => $_POST[''],
// "NB_wallet" => $_POST[''],

// "NB_ap_SecureHash" => $_POST[''],
// "NB_ap_transactionid" => $_POST[''],
// "NB_bankname" => $_POST[''],
// "NB_message" => $_POST[''],
// "NB_token" => $_POST[''],
// "NB_transaction_status" => $_POST[''],
// "is_success" => $_POST[''],

$data = Array(
  "env" => trim($_POST['env']),
  "merchant_id" => trim($_POST['merchant_id']),
  "NB_amount" => trim($_POST['amount']),
  "NB_bankCode" => trim($_POST['bankCode']),
  "NB_buyerAddress" => trim($_POST['buyerAddress']),
  "NB_buyerCity" => trim($_POST['buyerCity']),
  "NB_buyerCountry" => trim($_POST['Country']),
  "NB_buyerEmail" => trim($_POST['buyerEmail']),
  "NB_buyerFirstName" => trim($_POST['buyerFirstName']),
  "NB_buyerLastName" => trim($_POST['buyerLastName']),
  "NB_buyerPhone" => trim($_POST['buyerPhone']),
  "NB_buyerPincode" => trim($_POST['buyerPincode']),
  "NB_buyerState" => trim($_POST['buyerState']),
  "NB_channel" => trim($_POST['channel']),
  "NB_checksum" => $checksum,
  "NB_chmod" => $hiddenmod,
  "NB_currency" => trim($_POST['currency']),
  "NB_customvar" => trim($_POST['customvar']),
  "NB_isocurrency" => trim($_POST['isocurrency']),
  "NB_mercid" => $mercid,
  "NB_orderid" => $orderid,
  "NB_privatekey" => $privatekey,
  "NB_transactionid" => trim($_POST['Transaction_id']),
  "gmt_datetime" => gmdate('Y-m-d H:i:s'),
  "mer_callback_url" => trim($_POST['redirectionurl']),
  "timestamp" => trim($_POST['timestamp']),
  "trans_date" => date('Y-m-d', strtotime(trim($_POST['timestamp']))),
  "trans_datetime" => date('Y-m-d H:i:s', strtotime(trim($_POST['timestamp']))),
  "trans_time" => date('H:i:s', strtotime(trim($_POST['timestamp']))),
  "transaction_type" => trim($_POST['TransactionType']),
  "transaction_vendor" => "",
  "txnsubtype" => trim($_POST['txnsubtype'])
);
$id_transaction_id = $db->insert('transaction_airpay_netbank', $data);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
            <?php
			Checksum::outputForm_create($post_array);
			?>
			</form>
		</td>
	</tr>
</table>

</center>
</body>
</html>