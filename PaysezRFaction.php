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

// echo "<pre>";
// print_r($_POST);
// echo "<br>";
// exit;

/**** Log Function ****/
function logwrite($log) {
    GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
}

if($_POST['p_type'] == 'CP') {

	/**** Log Paths ****/
	$log_path = '/var/www/html/testspaysez/api/transactions_CP.log';

	$db->where("id_transaction_id", $_POST['t_id']);
	$transDet = $db->getone("transactions");
	$merchant_id = $transDet['merchant_id'];
	$TxnRefNo = $transDet['original_transaction_id'];
	$TransDate    = date('Ymd', strtotime($transDet['localtrans_date']));
	$Org_TransId  = $transDet['transaction_id'];
	$Trans_Amount = $transDet['amount'];
  $card_type    = $transDet['tax'];

	$db->where("vendor_id", $transDet['mdf_11']);
	$vendorDet = $db->getone('vendor_config');
	$vendor_id = $vendorDet['vendor_id'];
	$vendor_name = $vendorDet['vendor_name'];
	$Security_ID  = $vendorDet['vendor_password']; // Security_ID
	$Checksum_key = $vendorDet['vendor_secretkey']; // Checksum Key
	$MerchantID   = $vendorDet['ap_mercid']; // App Merchant ID
}
if($_POST['p_type'] == 'NB') {

	/**** Log Paths ****/
	$log_path = '/var/www/html/testspaysez/api/transactions_NB.log';

	$db->where("id_transaction_id", $_POST['t_id']);
	$transDet = $db->getone("transaction_airpay_netbank");
	$merchant_id = $transDet['merchant_id'];
	$TxnRefNo = $transDet['NB_ap_transactionid'];
	$TransDate= date('Ymd', strtotime($transDet['trans_date']));
	$Org_TransId  = $transDet['NB_transactionid'];
	$Trans_Amount = $transDet['NB_amount'];

	$db->where("vendor_id", $transDet['transaction_vendor']);
	$vendorDet = $db->getone('vendor_config');
	$vendor_id = $vendorDet['vendor_id'];
	$vendor_name = $vendorDet['vendor_name'];
	$Security_ID  = $vendorDet['vendor_password']; // Security_ID
	$Checksum_key = $vendorDet['vendor_secretkey']; // Checksum Key
	$MerchantID   = $vendorDet['ap_mercid']; // App Merchant ID
}
if($_POST['p_type'] == 'WT') {

	/**** Log Paths ****/
	$log_path = '/var/www/html/testspaysez/api/transactions_WT.log';

	$db->where("id_transaction_id", $_POST['t_id']);
	$transDet = $db->getone("transaction_airpay_wallet");
	$merchant_id = $transDet['merchant_id'];
	$TxnRefNo = $transDet['WT_ap_transactionid'];
	$TransDate= date('Ymd', strtotime($transDet['trans_date']));
	$Org_TransId  = $transDet['WT_transactionid'];
	$Trans_Amount = $transDet['WT_amount'];

	$db->where("vendor_id", $transDet['transaction_vendor']);
	$vendorDet = $db->getone('vendor_config');
	$vendor_id = $vendorDet['vendor_id'];
	$vendor_name = $vendorDet['vendor_name'];
	$Security_ID  = $vendorDet['vendor_password']; // Security_ID
	$Checksum_key = $vendorDet['vendor_secretkey']; // Checksum Key
	$MerchantID   = $vendorDet['ap_mercid']; // App Merchant ID
}

$ref_amount = ($_POST['refund_amount']!='') ? number_format($_POST['refund_amount'],2) : $Trans_Amount;
$orderid = $MerchantID.date('YmdHis');

$RequestType      = '0400';
$Merchant_ID      = $MerchantID; // App Merchant ID
$TxnReferenceNo   = $TxnRefNo;
$TxnDate          = $TransDate;
$CustomerID       = $Org_TransId;
$TxnAmount        = $Trans_Amount;
$RefAmount        = $ref_amount;
$RefDateTime      = date("YmdHis");
$MerchantRefNo    = 'RF'.date("YmdHis");
$Filler1          = 'NA';
$Filler2          = 'NA';
$Filler3          = 'NA';

$str = $RequestType."|".$Merchant_ID."|".$TxnReferenceNo."|".$TxnDate."|".$CustomerID."|".$TxnAmount."|".$RefAmount."|".$RefDateTime."|".$MerchantRefNo."|".$Filler1."|".$Filler2."|".$Filler3;

$logs = $vendor_name."'s Refund Request Data:".date("Y-m-d H:i:s") . "\n" .$str. " \n\n";
logwrite($logs);

$checksum_key = $Checksum_key;

$checksum = hash_hmac('sha256',$str,$checksum_key, false);
$checksum = strtoupper($checksum);

$msg = $str."|".$checksum;

$logs = $vendor_name."'s Refund Request Data with Checksum:".date("Y-m-d H:i:s") . "\n" .$msg. " \n\n";
logwrite($logs);

$request_array = [
    "msg" => $msg
];
$logs = $vendor_name."'s Refund Request Data to API:".date("Y-m-d H:i:s A") . "\n" .json_encode($request_array). " \n\n";
logwrite($logs);

if($_POST['p_type'] == 'CP') {
	$data = Array (
  		"environment" => trim($_POST['env']),
  		"currency" => trim($_POST['currency']),
	    "merchant_id" => $merchant_id,
	    "transaction_id" => $merchant_id.date("YmdHis"),
	    "transaction_type" => trim($_POST['action']),
	    "amount" => $ref_amount,
      "tax" => $card_type,
	    "trans_date_time" => date('Y-m-d H:i:s'),
	    "localtrans_time" => date('H:i:s'),
	    "localtrans_date" => date('Y-m-d'),

	    "ponumber"  => $orderid,
	    "mdf_1"     => trim($_POST['from']),
	    "mdf_2"     => $checksum,
	    "mdf_3"     => $MerchantID,
	    "mdf_4"     => $Checksum_key,
	    "mdf_5"     => trim($_POST['action']),
	    "mdf_11"    => $vendor_id,
	    "mdf_12"    => $CustomerID
	);

	$logs = $vendor_name."'s Card Payment Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
	logwrite($logs);

	$id_transaction_id = $db->insert('transactions', $data);
}

if($_POST['p_type'] == 'NB') {
	$data = Array(
      "env" => trim($_POST['env']),
      "merchant_id" => $merchant_id,
      "NB_amount" => $ref_amount,
      "NB_channel" => trim($_POST['from']),
      "NB_checksum" => $checksum,
      "NB_mercid" => $MerchantID,
      "NB_orderid" => $orderid,
      "NB_privatekey" => $Checksum_key,
      "NB_transactionid" => $merchant_id.date("YmdHis"),
      "gmt_datetime" => gmdate('Y-m-d H:i:s'),
      "timestamp" => trim(date('YmdHis')),
      "trans_date" => date('Y-m-d'),
      "trans_datetime" => date('Y-m-d H:i:s'),
      "trans_time" => date('H:i:s'),
      "transaction_type" => trim($_POST['action']),
      "transaction_vendor" => trim($vendor_id),
      "txnsubtype" => "",

      "NB_original_tranid" => $CustomerID,
      "NB_currency" => trim($_POST['currency']),
      "NB_isocurrency" => trim($_POST['isocurrency'])
    );

    $logs = $vendor_name."'s Net Banking Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transaction_airpay_netbank', $data);
}

if($_POST['p_type'] == 'WT') {
	$data = Array(
      "env" => trim($_POST['env']),
      "merchant_id" => $merchant_id,
      "WT_amount" => $ref_amount,
      "WT_channel" => trim($_POST['from']),
      "WT_checksum" => $checksum,
      "WT_mercid" => $MerchantID,
      "WT_orderid" => $orderid,
      "WT_privatekey" => $Checksum_key,
      "WT_transactionid" => $merchant_id.date("YmdHis"),
      "gmt_datetime" => gmdate('Y-m-d H:i:s'),
      "timestamp" => trim(date('YmdHis')),
      "trans_date" => date('Y-m-d'),
      "trans_datetime" => date('Y-m-d H:i:s'),
      "trans_time" => date('H:i:s'),
      "transaction_type" => trim($_POST['action']),
      "transaction_vendor" => trim($vendor_id),
      "txnsubtype" => "",

      "WT_original_tranid" => $CustomerID,
      "WT_currency" => trim($_POST['currency']),
      "WT_isocurrency" => trim($_POST['isocurrency'])
    );

    $logs = $vendor_name."'s Wallets Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transaction_airpay_wallet', $data);
}

/**** BillDesk Refund API URL ****/
$Refund_api_url = "https://www.billdesk.com/pgidsk/PGIRefundController";
$logs = "Refund Request API URL :".date("Y-m-d H:i:s A") . "\n" .$Refund_api_url. " \n\n";
logwrite($logs);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$Refund_api_url);
curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, "postvar1=value1&postvar2=value2&postvar3=value3");
// In real life you should use something like:
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_array));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

/* Refund response log */
if(curl_errno($ch)) {
    $logs = "Application Log Refund : ".date("Y-m-d H:i:sa").", Refund Response:".curl_errno($ch)."\n\n";
    // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    logwrite($logs);
    die();
} else {
    $logs = "Application Log Refund : ".date("Y-m-d H:i:sa").", Refund Response:" . $server_output."\n\n";
    // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    logwrite($logs);
}

curl_close ($ch);

$resp_msg = $server_output;
$splitdata = explode('|', $resp_msg);

$R_RequestType      = $splitdata[0];
$R_MerchantID       = $splitdata[1];
$R_TxnReferenceNo   = $splitdata[2];
$R_TxnDate          = $splitdata[3];
$R_CustomerID       = $splitdata[4];
$R_TxnAmount        = $splitdata[5];
$R_RefAmount        = $splitdata[6];
$R_RefDateTime      = $splitdata[7];
$R_RefStatus        = $splitdata[8];
$R_RefundId         = $splitdata[9];
$R_ErrorCode        = $splitdata[10];
$R_ErrorReason      = $splitdata[11];
$R_ProcessStatus    = $splitdata[12];
$R_CheckSum         = $splitdata[13];

// // Further processing ...
// if ($server_output == "OK") { ... } else { ... }

if($_POST['p_type'] == 'CP') {
	$data = array(
        "original_transaction_id"=> ($R_TxnReferenceNo!='') ? trim($R_TxnReferenceNo) : 'NULL',
        "error_code"             => $R_ErrorCode,
        "mdf_7"                  => 'BillDesk',
        "mdf_8"                  => ($R_ProcessStatus == "Y") ? 'SUCCESS' : 'FAILED',
        "mdf_9"                  => ($R_ErrorReason!='') ? trim($R_ErrorReason) : 'NULL',
        "mdf_10"                 => $R_CheckSum,
        
        "mdf_13"                 => $R_RefundId,
        "mdf_14"                 => $R_RefStatus,
        "mdf_15"                 => $R_RefAmount,
        "mdf_16"                 => $R_RefDateTime
    );

    $logs = $vendor_name."'s Card Payment Refund Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('id_transaction_id', trim($id_transaction_id));
    $db->update('transactions', $data);
}

if($_POST['p_type'] == 'NB') {
	$data = array(
        "NB_ap_SecureHash"      => $R_CheckSum,
        "NB_ap_transactionid"   => ($R_TxnReferenceNo!='') ? trim($R_TxnReferenceNo) : 'NULL',
        "NB_customvar"          => 'BillDesk',
        "NB_message"            => ($R_ErrorReason!='') ? trim($R_ErrorReason) : 'NULL',
        "NB_transaction_status" => ($R_ProcessStatus == "Y") ? '200' : $R_ErrorCode,
        "is_success"            => ($R_ProcessStatus == "Y") ? 'SUCCESS' : 'FAILED',

        "NB_RefundId"           => $R_RefundId,
        "NB_RefStatus"          => $R_RefStatus,
        "NB_RefAmount"          => $R_RefAmount,
        "NB_RefDateTime"        => $R_RefDateTime
    );

    $logs = $vendor_name."'s Net Banking Refund Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('id_transaction_id', trim($id_transaction_id));
    $db->update('transaction_airpay_netbank', $data);
}

if($_POST['p_type'] == 'WT') {
	$data = array(
        "WT_ap_SecureHash"      => $R_CheckSum,
        "WT_ap_transactionid"   => ($R_TxnReferenceNo!='') ? trim($R_TxnReferenceNo) : 'NULL',
        "WT_customvar"          => 'BillDesk',
        "WT_message"            => ($R_ErrorReason!='') ? trim($R_ErrorReason) : 'NULL',
        "WT_transaction_status" => ($R_ProcessStatus == "Y") ? '200' : $R_ErrorCode,
        "is_success"            => ($R_ProcessStatus == "Y") ? 'SUCCESS' : 'FAILED',

        "WT_RefundId"           => $R_RefundId,
        "WT_RefStatus"          => $R_RefStatus,
        "WT_RefAmount"          => $R_RefAmount,
        "WT_RefDateTime"        => $R_RefDateTime
    );

    $logs = $vendor_name."'s Wallets Refund Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('id_transaction_id', trim($id_transaction_id));
    $db->update('transaction_airpay_wallet', $data);
}

$response = array(
    "RefundId" => $R_RefundId,
    "res"      =>  ($R_ProcessStatus == "Y") ? 'SUCCESS' : 'FAILED',
    "desc"     => ($R_ErrorReason!='') ? trim($R_ErrorReason) : 'NULL'
);

print_r(json_encode($response));
exit;
?>