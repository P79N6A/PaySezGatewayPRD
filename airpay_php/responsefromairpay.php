<?php
date_default_timezone_set('Asia/Kolkata');

header( 'Expires: Sat, 28 Jul 2029 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';

error_reporting(0);
require_once('../api/encrypt.php');
require_once('../api/baseurl.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

// ****DB Connection****
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

// echo "<pre>";
// print_r($_POST); exit;

/**** Airpay Response Update ****/
$logs = "Airpay Response Data:".date("Y-m-d H:i:s") . "," .json_encode($_POST). " \n\n";
logwrite($logs);

// $merchantDet = $db->get('merchants');
// echo "<pre>";
// print_r($merchantDet); exit;

// ****Log Paths****
$payment_option = $_POST['CHMOD'];
if($payment_option == "pg") {
	$pay_option_name = "CardPayment with EMI";
	$log_path = '/var/www/html/testspaysez/api/transactions_CP.log';
}
if($payment_option == "NETBNK" || $payment_option == "nb") {
	$pay_option_name = "NetBanking";
	$log_path = '/var/www/html/testspaysez/api/transactions_NB.log';
}
if($payment_option == "PPC" || $payment_option == "ppc") {
	$pay_option_name = "Wallets";
	$log_path = '/var/www/html/testspaysez/api/transactions_WT.log';
}
// ****Log Function****
function logwrite($log) {
	GLOBAL $log_path;
	// $log_path = "http://169.38.91.246/testspaysez/api/transactions_NB.log";
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}

function outputForm($postarray) {
	//ksort($_POST);
	foreach($postarray as $key => $value) {
		// echo $key.'=>'.$value;
		// echo "<br>";
		echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />'."\n";
	}
}

include('config.php');

/**** Airpay Response Update ****/
$logs = "Airpay ".$pay_option_name." Transaction Response Data:".date("Y-m-d H:i:s") . "," .json_encode($_POST). " \n\n";
logwrite($logs);

// if($payment_option == "pg") {
// 	$logs = "Airpay ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
// 	logwrite($logs);
// }

// echo "<pre>";
// print_r($_POST); exit;


// "tax" => $_POST['tax'],
// "network" => 
// "cc_type" => getCCType($_POST['cc_number'])
// "orginal_transaction_id" =>

if($payment_option == "pg") {
	$data = array(
		"tax"    	            => isset($_POST['CARDISSUER']) ? trim(strtoupper($_POST['CARDISSUER'])) : '',
		"network"               => isset($_POST['CARDISSUER']) ? trim(strtoupper($_POST['CARDISSUER'])) : '',
		"cc_type" 	            => isset($_POST['CARDISSUER']) ? trim($_POST['CARDISSUER']) : '',
		"original_transaction_id"=> isset($_POST['APTRANSACTIONID']) ? trim($_POST['APTRANSACTIONID']) : '',
		"transaction_type"      => isset($_POST['TRANSACTIONTYPE']) ? trim($_POST['TRANSACTIONTYPE']) : '',
		"error_code"            => isset($_POST['TRANSACTIONSTATUS']) ? trim($_POST['TRANSACTIONSTATUS']) : '',
		"mdf_6"    	            => isset($_POST['ap_SecureHash']) ? trim($_POST['ap_SecureHash']) : '',
		"mdf_7"    	            => isset($_POST['MERCHANT_NAME']) ? trim($_POST['MERCHANT_NAME']) : '',
		"mdf_8"    	            => isset($_POST['TRANSACTIONPAYMENTSTATUS']) ? trim($_POST['TRANSACTIONPAYMENTSTATUS']) : ''
	);

	$logs = "Airpay ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
	logwrite($logs);

	$db->where('ponumber', trim($_POST['TRANSACTIONID']));
	$db->update('transactions', $data);

	$db->where('ponumber', trim($_POST['TRANSACTIONID']));
	$transDet = $db->getone('transactions');
	$response_url = $transDet['r_url'];
	$merchant_id  = $transDet['merchant_id'];
}

if($payment_option == "NETBNK" || $payment_option == "nb") {

	// "NB_transactionid"    	=> isset($_POST['TRANSACTIONID']) ? trim($_POST['TRANSACTIONID']) : '',
	$data = array(
		"NB_ap_SecureHash"    	=> isset($_POST['ap_SecureHash']) ? trim($_POST['ap_SecureHash']) : '',
		"NB_ap_transactionid" 	=> isset($_POST['APTRANSACTIONID']) ? trim($_POST['APTRANSACTIONID']) : '',
		"NB_bankname" 			=> isset($_POST['BANKNAME']) ? trim($_POST['BANKNAME']) : '',
		"NB_chmod" 				=> isset($_POST['CHMOD']) ? trim($_POST['CHMOD']) : '',
		"NB_customvar" 			=> isset($_POST['CUSTOMVAR']) ? trim($_POST['CUSTOMVAR']) : '',
		"NB_message" 			=> isset($_POST['MESSAGE']) ? trim($_POST['MESSAGE']) : '',
		"NB_token" 				=> isset($_POST['TOKEN']) ? trim($_POST['TOKEN']) : '',
		"NB_transaction_status" => isset($_POST['TRANSACTIONSTATUS']) ? trim($_POST['TRANSACTIONSTATUS']) : '',
		"transaction_type"      => isset($_POST['TRANSACTIONTYPE']) ? trim($_POST['TRANSACTIONTYPE']) : '',
		"is_success" 			=> isset($_POST['TRANSACTIONPAYMENTSTATUS']) ? trim($_POST['TRANSACTIONPAYMENTSTATUS']) : ''
	);

	$logs = "Airpay ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
	logwrite($logs);

	$db->where('NB_orderid', trim($_POST['TRANSACTIONID']));
	$db->update('transaction_airpay_netbank', $data);

	$db->where('NB_orderid', trim($_POST['TRANSACTIONID']));
	$transDet = $db->getone('transaction_airpay_netbank');
	$response_url = $transDet['mer_callback_url'];
	$merchant_id  = $transDet['merchant_id'];
}

if($payment_option == "PPC" || $payment_option == "ppc") {

	// "WT_transactionid"    	=> isset($_POST['TRANSACTIONID']) ? trim($_POST['TRANSACTIONID']) : '',
	$data = array(
		"WT_ap_SecureHash"    	=> isset($_POST['ap_SecureHash']) ? trim($_POST['ap_SecureHash']) : '',
		"WT_ap_transactionid" 	=> isset($_POST['APTRANSACTIONID']) ? trim($_POST['APTRANSACTIONID']) : '',
		"WT_bankname" 			=> isset($_POST['BANKNAME']) ? trim($_POST['BANKNAME']) : '',
		"WT_chmod" 				=> isset($_POST['CHMOD']) ? trim($_POST['CHMOD']) : '',
		"WT_customvar" 			=> isset($_POST['CUSTOMVAR']) ? trim($_POST['CUSTOMVAR']) : '',
		"WT_message" 			=> isset($_POST['MESSAGE']) ? trim($_POST['MESSAGE']) : '',
		"WT_token" 				=> isset($_POST['TOKEN']) ? trim($_POST['TOKEN']) : '',
		"WT_transaction_status" => isset($_POST['TRANSACTIONSTATUS']) ? trim($_POST['TRANSACTIONSTATUS']) : '',
		"transaction_type"      => isset($_POST['TRANSACTIONTYPE']) ? trim($_POST['TRANSACTIONTYPE']) : '',
		"is_success" 			=> isset($_POST['TRANSACTIONPAYMENTSTATUS']) ? trim($_POST['TRANSACTIONPAYMENTSTATUS']) : ''
	);

	$logs = "Airpay ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
	logwrite($logs);

	$db->where('WT_orderid', trim($_POST['TRANSACTIONID']));
	$db->update('transaction_airpay_wallet', $data);

	$db->where('WT_orderid', trim($_POST['TRANSACTIONID']));
	$transDet = $db->getone('transaction_airpay_wallet');
	$response_url = $transDet['mer_callback_url'];
	$merchant_id  = $transDet['merchant_id'];
}

$query_string    = http_build_query($data); // http_build_query($data, '', '&amp;');
$query_string_en = base64_encode($query_string);


// This is landing page where you will receive response from airpay. 
// The name of the page should be as per you have configured in airpay system
// All columns are mandatory

$TRANSACTIONID = trim($_POST['TRANSACTIONID']);
$APTRANSACTIONID  = trim($_POST['APTRANSACTIONID']);
$AMOUNT  = trim($_POST['AMOUNT']);
$TRANSACTIONSTATUS  = trim($_POST['TRANSACTIONSTATUS']);
$MESSAGE  = trim($_POST['MESSAGE']);
$ap_SecureHash = trim($_POST['ap_SecureHash']);
$CUSTOMVAR  = trim($_POST['CUSTOMVAR']);


$error_msg = '';
if(empty($TRANSACTIONID) || empty($APTRANSACTIONID) || empty($AMOUNT) || empty($TRANSACTIONSTATUS) || empty($ap_SecureHash)){
// Reponse has been compromised. So treat this transaction as failed.
if(empty($TRANSACTIONID)){ $error_msg = 'TRANSACTIONID '; } 
if(empty($APTRANSACTIONID)){ $error_msg .=  ' APTRANSACTIONID'; }
if(empty($AMOUNT)){ $error_msg .=  ' AMOUNT'; }
if(empty($TRANSACTIONSTATUS)){ $error_msg .=  ' TRANSACTIONSTATUS'; }
if(empty($ap_SecureHash)){ $error_msg .=  ' ap_SecureHash'; }
$error_msg .= '<tr><td>Variable(s) '. $error_msg.' is/are empty.</td></tr>';

//exit();
}

//THIS IS ADDITIONAL VALIDATION, YOU MAY USE IT.
//$SYSTEM_AMOUNT is amount you will fetch from your database/system against $TRANSACTIONID
//if( $AMOUNT != $SYSTEM_AMOUNT){
// Reponse has been compromised. So treat this transaction as failed.
//$error_msg .= '<tr><td>Amount mismatch in the system.</td></tr>';
//exit();
//}

// Generating Secure Hash
// $mercid = 	Merchant Id, $username = username
// You will find above two keys on the settings page, which we have defined here in config.php
$merchant_secure_hash = sprintf("%u", crc32 ($TRANSACTIONID.':'.$APTRANSACTIONID.':'.$AMOUNT.':'.$TRANSACTIONSTATUS.':'.$MESSAGE.':'.$mercid.':'.$username));

//comparing Secure Hash with Hash sent by Airpay
if($ap_SecureHash != $merchant_secure_hash){
// Reponse has been compromised. So treat this transaction as failed.
$error_msg .= '<tr><td>Secure Hash mismatch.</td></tr>';
//exit();
}

if($error_msg){
echo '<table><font color="red"><b>ERROR:</b> '.$error_msg.'</font></table>';
echo '<table>
<tr><td>Variable Name</td><td> Value</td></tr>
<tr><td>TRANSACTIONID:</td><td> '.$TRANSACTIONID.'</td></tr>
<tr><td>APTRANSACTIONID:</td><td> '.$APTRANSACTIONID.'</td></tr>
<tr><td>AMOUNT:</td><td> '.$AMOUNT.'</td></tr>
<tr><td>TRANSACTIONSTATUS:</td><td> '.$TRANSACTIONSTATUS.'</td></tr>
<tr><td>CUSTOMVAR:</td><td> '.$CUSTOMVAR.'</td></tr>

</table>';

exit();
}//if($error_msg)


if($TRANSACTIONSTATUS == 200){
echo '<table><tr><td>Success Transaction</td></tr></table>
<table>
<tr><td>Variable Name</td><td> Value</td></tr>
<tr><td>TRANSACTIONID:</td><td> '.$TRANSACTIONID.'</td></tr>
<tr><td>APTRANSACTIONID:</td><td> '.$APTRANSACTIONID.'</td></tr>
<tr><td>AMOUNT:</td><td> '.$AMOUNT.'</td></tr>
<tr><td>TRANSACTIONSTATUS:</td><td> '.$TRANSACTIONSTATUS.'</td></tr>
<tr><td>MESSAGE:</td><td> '.$MESSAGE.'</td></tr>
<tr><td>CUSTOMVAR:</td><td> '.$CUSTOMVAR.'</td></tr>

</table>';
// Process Successfull transaction
}else{
echo '<table><tr><td>Failed Transaction</td></tr></table>
<table>
<tr><td>Variable Name</td><td> Value</td></tr>
<tr><td>TRANSACTIONID:</td><td> '.$TRANSACTIONID.'</td></tr>
<tr><td>APTRANSACTIONID:</td><td> '.$APTRANSACTIONID.'</td></tr>
<tr><td>AMOUNT:</td><td> '.$AMOUNT.'</td></tr>
<tr><td>TRANSACTIONSTATUS:</td><td> '.$TRANSACTIONSTATUS.'</td></tr>
<tr><td>MESSAGE:</td><td> '.$MESSAGE.'</td></tr>
<tr><td>CUSTOMVAR:</td><td> '.$CUSTOMVAR.'</td></tr>

</table>';
// Process Failed Transaction
}


// echo "<pre>";
// print_r($_POST);

// $response_url = "https://paymentgateway.test.credopay.in/testspaysez/testget_response.php";
?>

<html>
<head>
<title>Paysez - Payment Page</title>
</head>
<body>
<center><h3 style="color:blue;">..Redirecting to Merchant Page..</h3></center>
<form id="resform" method="post" action="<?php echo $response_url;?>">
	<input type="hidden" name="status" value="<?php echo trim($_POST['TRANSACTIONPAYMENTSTATUS']); ?>" />
	<input type="hidden" name="errordesc" value="" />
	<input type="hidden" name="errorcode" value="<?php echo trim($_POST['TRANSACTIONSTATUS']); ?>" />
	<input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" />
	<input type="hidden" name="transaction_id" value="<?php echo trim($_POST['TRANSACTIONID']); ?>" />
	<input type="hidden" name="amount" value="<?php echo trim($_POST['AMOUNT']); ?>" />
	<input type="hidden" name="currency" value="<?php if(trim($_POST['CURRENCYCODE']) == "356") { echo "INR"; } ?>" />
	<input type="hidden" name="request_type" value="<?php echo trim($_POST['CHMOD']); ?>" />
</form>
</body>
</html>
<script>
    setTimeout(function(){ document.getElementById("resform").submit(); }, 2000);
</script>

<script>
// window.location.assign("https://paymentgateway.test.credopay.in/testspaysez/testget_response.php?<?php // echo $query_string_en; ?>");
</script>