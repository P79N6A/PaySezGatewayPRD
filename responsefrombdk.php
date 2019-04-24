<?php
date_default_timezone_set('Asia/Kolkata');
header( 'Expires: Sat, 28 Jul 2029 05:00:00 GMT' );
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

/**** DB Connection ****/
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

include('Billdesk/config.php');

$msg = $_POST['msg'];
$splitdata = explode('|', $msg);

$MerchantID       = $splitdata[0];
$CustomerID       = $splitdata[1];
$TxnReferenceNo   = $splitdata[2];
$BankReferenceNo  = $splitdata[3];
$TxnAmount        = $splitdata[4];
$BankID           = $splitdata[5];
$BankMerchantID   = $splitdata[6];
$TxnType          = $splitdata[7];
$CurrencyName     = $splitdata[8];
$ItemCode         = $splitdata[9];
$SecurityType     = $splitdata[10];
$SecurityID       = $splitdata[11];
$SecurityPassword = $splitdata[12];
$TxnDate          = $splitdata[13];
$AuthStatus       = $splitdata[14];
$SettlementType   = $splitdata[15];
$AdditionalInfo1  = $splitdata[16];
$AdditionalInfo2  = $splitdata[17];
$AdditionalInfo3  = $splitdata[18];
$AdditionalInfo4  = $splitdata[19];
$AdditionalInfo5  = $splitdata[20];
$AdditionalInfo6  = $splitdata[21];
$AdditionalInfo7  = $splitdata[22];
$ErrorStatus      = $splitdata[23];
$ErrorDescription = $splitdata[24];
$CheckSum         = $splitdata[25];

/**** Log Paths ****/
if($splitdata[5] == 'CIT') {
    $pay_option_name = "CardPayment";
    $log_path = '/var/www/html/testspaysez/api/transactions_CP.log';

    $data = array(
        "original_transaction_id"=> ($TxnReferenceNo!='') ? trim($TxnReferenceNo) : 'NULL',
        "error_code"             => ($AuthStatus == "0300") ? '200' : $ErrorStatus,
        "mdf_7"                  => 'BillDesk',
        "mdf_8"                  => ($AuthStatus == "0300") ? 'SUCCESS' : 'FAILED',
        "mdf_9"                  => ($ErrorDescription!='') ? trim($ErrorDescription) : 'NULL',
        "mdf_10"                 => $CheckSum
    );

    $logs = "BillDesk's ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('transaction_id', trim($CustomerID));
    $db->update('transactions', $data);

    $db->where('transaction_id', trim($CustomerID));
    $transDet = $db->getone('transactions');
    $response_url = $transDet['r_url'];
    $merchant_id  = $transDet['merchant_id'];
}

$bank_array = ['IOB', 'BOM', 'IDS'];
if(in_array($splitdata[5], $bank_array)) {
    $pay_option_name = "NetBanking";
    $log_path = '/var/www/html/testspaysez/api/transactions_NB.log';

    $data = array(
        "NB_ap_SecureHash"      => $CheckSum,
        "NB_ap_transactionid"   => ($TxnReferenceNo!='') ? trim($TxnReferenceNo) : 'NULL',
        "NB_bankname"           => $BankID,
        "NB_customvar"          => 'BillDesk',
        "NB_message"            => ($ErrorDescription!='') ? trim($ErrorDescription) : 'NULL',
        "NB_transaction_status" => ($AuthStatus == "0300") ? '200' : $ErrorStatus,
        "is_success"            => ($AuthStatus == "0300") ? 'SUCCESS' : 'FAILED'
    );

    $logs = "BillDesk's ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('NB_transactionid', trim($CustomerID));
    $db->update('transaction_airpay_netbank', $data);

    $db->where('NB_transactionid', trim($CustomerID));
    $transDet = $db->getone('transaction_airpay_netbank');
    $response_url = $transDet['mer_callback_url'];
    $merchant_id  = $transDet['merchant_id'];
}

if($splitdata[5] == 'DCW') {
    $pay_option_name = "Wallets";
    $log_path = '/var/www/html/testspaysez/api/transactions_WT.log';

    $data = array(
        "WT_ap_SecureHash"      => $CheckSum,
        "WT_ap_transactionid"   => ($TxnReferenceNo!='') ? trim($TxnReferenceNo) : 'NULL',
        "WT_bankname"           => $BankID,
        "WT_customvar"          => 'BillDesk',
        "WT_message"            => ($ErrorDescription!='') ? trim($ErrorDescription) : 'NULL',
        "WT_transaction_status" => ($AuthStatus == "0300") ? '200' : $ErrorStatus,
        "is_success"            => ($AuthStatus == "0300") ? 'SUCCESS' : 'FAILED'
    );

    $logs = "BillDesk's ".$pay_option_name." Transaction Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('WT_transactionid', trim($CustomerID));
    $db->update('transaction_airpay_wallet', $data);

    $db->where('WT_transactionid', trim($CustomerID));
    $transDet = $db->getone('transaction_airpay_wallet');
    $response_url = $transDet['mer_callback_url'];
    $merchant_id  = $transDet['merchant_id'];
}

/**** Log Function ****/
function logwrite($log, $log_path) {
    // GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
}

/**** Bill Desk Response Update ****/
$logs = "Bill Desk Response Data:".date("Y-m-d H:i:s") . "\n" .json_encode($_POST). " \n\n";
logwrite($logs, $log_path);


$common_string= $Checksum_key; // "qeHCGJNlCb4s";  // checksum key provided by BillDesk
if($msg!="") {
    $code = substr(strrchr($msg, "|"), 1); //Last check sum value
    $string_new=str_replace("|".$code,"",$msg);//string replace : with empy space
    $checksum = strtoupper(hash_hmac('sha256',$string_new,$common_string, false));// calculated  check sum

    $logs = "Bill Desk Last check sum value:".date("Y-m-d H:i:s") . "\n" .$code. " \n\n";
	logwrite($logs, $log_path);
    // echo $code;

    $logs = "Bill Desk String Replace with empy space:".date("Y-m-d H:i:s") . "\n" .$string_new. " \n\n";
	logwrite($logs, $log_path);
    // echo $string_new;

    $logs = "Bill Desk calculated Checksum:".date("Y-m-d H:i:s") . "\n" .$checksum. " \n\n";
	logwrite($logs, $log_path);
    // echo $checksum;

    if($checksum == $code && $splitdata[14]=="0300") {
    	$status = "Success";
		$logs = "Bill Desk Transaction Status:".date("Y-m-d H:i:s") . "\n" .$status. " \n\n";
		logwrite($logs, $log_path);

        echo '<table><tr><td><font color="green">Success Transaction</font></td></tr></table>
        <table>
        <tr><td>TRANSACTIONID:</td><td> '.$CustomerID.'</td></tr>
        <tr><td>TRANSACTION REF NO:</td><td> '.$TxnReferenceNo.'</td></tr>
        <tr><td>AMOUNT:</td><td> '.$TxnAmount.'</td></tr>
        <tr><td>TRANSACTION STATUS:</td><td> '.$AuthStatus.'</td></tr>
        <tr><td>TRANSACTION MESSAGE:</td><td> '.$ErrorDescription.'</td></tr>
        <tr><td>TRANSACTION DATE:</td><td> '.$TxnDate.'</td></tr>
        </table>';
		// echo "success";
    } else {
    	$status = "Failed";
    	$logs = "Bill Desk Transaction Status:".date("Y-m-d H:i:s") . "\n" .$status. " \n\n";
		logwrite($logs, $log_path);

        echo '<table><tr><td>Failed Transaction</td></tr></table>
        <table>
        <tr><td>TRANSACTIONID:</td><td> '.$CustomerID.'</td></tr>
        <tr><td>TRANSACTION REF NO:</td><td> '.$TxnReferenceNo.'</td></tr>
        <tr><td>AMOUNT:</td><td> '.$TxnAmount.'</td></tr>
        <tr><td>TRANSACTION STATUS:</td><td> '.$AuthStatus.'</td></tr>
        <tr><td>ERROR MESSAGE:</td><td> '.$ErrorDescription.'</td></tr>
        <tr><td>TRANSACTION DATE:</td><td> '.$TxnDate.'</td></tr>
        </table>';
		// echo "Txn Failed";
    }
}
// exit;
?>
<html>
<head>
<title>Paysez - Payment Page</title>
</head>
<body>
<center><h3 style="color:blue;">..Redirecting to Merchant Page..</h3></center>
<form id="resform" method="post" action="<?php echo $response_url;?>">
    <input type="hidden" name="status" value="<?php echo ($AuthStatus == "0300") ? 'SUCCESS' : 'FAILED'; ?>" />
    <input type="hidden" name="errordesc" value="<?php echo $ErrorDescription; ?>" />
    <input type="hidden" name="errorcode" value="<?php echo ($AuthStatus == "0300") ? '200' : $AuthStatus; ?>" />
    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" />
    <input type="hidden" name="transaction_id" value="<?php echo trim($CustomerID); ?>" />
    <input type="hidden" name="amount" value="<?php echo trim($TxnAmount); ?>" />
    <input type="hidden" name="currency" value="<?php echo trim($CurrencyName); ?>" />
    <input type="hidden" name="request_type" value="<?php echo trim($pay_option_name); ?>" />
</form>
</body>
</html>
<script>
    setTimeout(function(){ document.getElementById("resform").submit(); }, 2000);
</script>