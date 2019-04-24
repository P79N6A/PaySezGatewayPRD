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

$orderid = $MerchantID.date('YmdHis');

$RequestType      = '0122';
$Merchant_ID      = $MerchantID; // App Merchant ID
$CustomerID       = $Org_TransId;
$CurrentTime      = trim(date('YmdHis'));

$str = $RequestType."|".$Merchant_ID."|".$CustomerID."|".$CurrentTime;

$logs = $vendor_name."'s Query Request Data:".date("Y-m-d H:i:s") . "\n" .$str. " \n\n";
logwrite($logs);

$checksum_key = $Checksum_key;

$checksum = hash_hmac('sha256',$str,$checksum_key, false);
$checksum = strtoupper($checksum);

$msg = $str."|".$checksum;

$logs = $vendor_name."'s Query Request Data with Checksum:".date("Y-m-d H:i:s") . "\n" .$msg. " \n\n";
logwrite($logs);

$request_array = [
    "msg" => $msg
];
$logs = $vendor_name."'s Query Request Data to API:".date("Y-m-d H:i:s A") . "\n" .json_encode($request_array). " \n\n";
logwrite($logs);

if($_POST['p_type'] == 'CP') {
	$data = Array (
		"environment" => trim($_POST['env']),
		"currency" => trim($_POST['currency']),
	    "merchant_id" => $merchant_id,
	    "transaction_id" => $merchant_id.date("YmdHis"),
	    "transaction_type" => trim($_POST['action']),
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

	$logs = $vendor_name."'s Card Payment Query Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
	logwrite($logs);

	$id_transaction_id = $db->insert('transactions', $data);
}

if($_POST['p_type'] == 'NB') {
	$data = Array(
      "env" => trim($_POST['env']),
      "merchant_id" => $merchant_id,
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

    $logs = $vendor_name."'s Net Banking Query Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transaction_airpay_netbank', $data);
}

if($_POST['p_type'] == 'WT') {
	$data = Array(
      "env" => trim($_POST['env']),
      "merchant_id" => $merchant_id,
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

/**** BillDesk Query API URL ****/
$Query_api_url = "https://www.billdesk.com/pgidsk/PGIQueryController";
$logs = "Query Request API URL :".date("Y-m-d H:i:s A") . "\n" .$Query_api_url. " \n\n";
logwrite($logs);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$Query_api_url);
curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, "postvar1=value1&postvar2=value2&postvar3=value3");
// In real life you should use something like:
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_array));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

/* Query response log */
if(curl_errno($ch)) {
    $logs = "Application Log Query : ".date("Y-m-d H:i:sa").", Query Response:".curl_errno($ch)."\n\n";
    // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    logwrite($logs);
    die();
} else {
    $logs = "Application Log Query : ".date("Y-m-d H:i:sa").", Query Response:" . $server_output."\n\n";
    // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    logwrite($logs);
}

curl_close ($ch);

$resp_msg = $server_output;
$splitdata = explode('|', $resp_msg);

$Q_RequestType       = $splitdata[0];
$Q_MerchantID        = $splitdata[1];
$Q_CustomerID        = $splitdata[2];
$Q_TxnReferenceNo    = $splitdata[3];
$Q_BankReferenceNo   = $splitdata[4];
$Q_TxnAmount         = $splitdata[5];
$Q_BankID            = $splitdata[6];
$Q_Filler1           = $splitdata[7];
$Q_TxnType           = $splitdata[8];
$Q_CurrencyType      = $splitdata[9];
$Q_ItemCode          = $splitdata[10];
$Q_Filler2           = $splitdata[11];
$Q_Filler3           = $splitdata[12];
$Q_Filler4           = $splitdata[13];
$Q_TxnDate           = $splitdata[14];
$Q_AuthStatus        = $splitdata[15];
$Q_Filler5           = $splitdata[16];
$Q_AdditionalInfo1   = $splitdata[17];
$Q_AdditionalInfo2   = $splitdata[18];
$Q_AdditionalInfo3   = $splitdata[19];
$Q_AdditionalInfo4   = $splitdata[20];
$Q_AdditionalInfo5   = $splitdata[21];
$Q_AdditionalInfo6   = $splitdata[22];
$Q_AdditionalInfo7   = $splitdata[23];
$Q_ErrorStatus       = $splitdata[24];
$Q_ErrorDescription  = $splitdata[25];
$Q_Filler6           = $splitdata[26];
$Q_Refund_Status     = $splitdata[27];
$Q_TotalRefundAmount = $splitdata[28];
$Q_LastRefundDate    = $splitdata[29];
$Q_LastRefundRefNo   = $splitdata[30];
$Q_QueryStatus       = $splitdata[31];
$Q_Checksum          = $splitdata[32];

if($_POST['p_type'] == 'CP') {
	$data = array(
        "original_transaction_id"=> ($Q_TxnReferenceNo!='') ? trim($Q_TxnReferenceNo) : 'NULL',
        "error_code"             => $Q_ErrorStatus,
        "mdf_7"                  => 'BillDesk',
        "mdf_8"                  => ($Q_QueryStatus == "Y") ? 'SUCCESS' : 'FAILED',
        "mdf_9"                  => ($Q_ErrorDescription!='') ? trim($Q_ErrorDescription) : 'NULL',
        "mdf_10"                 => $Q_Checksum,
        
        "mdf_13"                 => $Q_LastRefundRefNo,
        "mdf_14"                 => $Q_Refund_Status,
        "mdf_15"                 => $Q_TotalRefundAmount,
        "mdf_16"                 => $Q_LastRefundDate
    );

    $logs = $vendor_name."'s Card Payment Query Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('id_transaction_id', trim($id_transaction_id));
    $db->update('transactions', $data);
}

if($_POST['p_type'] == 'NB') {
	$data = array(
        "NB_ap_SecureHash"      => $Q_Checksum,
        "NB_ap_transactionid"   => ($Q_TxnReferenceNo!='') ? trim($Q_TxnReferenceNo) : 'NULL',
        "NB_customvar"          => 'BillDesk',
        "NB_message"            => ($Q_ErrorDescription!='') ? trim($Q_ErrorDescription) : 'NULL',
        "NB_transaction_status" => ($Q_QueryStatus == "Y") ? '200' : $Q_ErrorStatus,
        "is_success"            => ($Q_QueryStatus == "Y") ? 'SUCCESS' : 'FAILED',

        "NB_RefundId"           => $Q_LastRefundRefNo,
        "NB_RefStatus"          => $Q_Refund_Status,
        "NB_RefAmount"          => $Q_TotalRefundAmount,
        "NB_RefDateTime"        => $Q_LastRefundDate
    );

    $logs = $vendor_name."'s Net Banking Query Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('id_transaction_id', trim($id_transaction_id));
    $db->update('transaction_airpay_netbank', $data);
}

if($_POST['p_type'] == 'WT') {
	$data = array(
        "WT_ap_SecureHash"      => $Q_Checksum,
        "WT_ap_transactionid"   => ($Q_TxnReferenceNo!='') ? trim($Q_TxnReferenceNo) : 'NULL',
        "WT_customvar"          => 'BillDesk',
        "WT_message"            => ($Q_ErrorDescription!='') ? trim($Q_ErrorDescription) : 'NULL',
        "WT_transaction_status" => ($Q_QueryStatus == "Y") ? '200' : $Q_ErrorStatus,
        "is_success"            => ($Q_QueryStatus == "Y") ? 'SUCCESS' : 'FAILED',

        "WT_RefundId"           => $Q_LastRefundRefNo,
        "WT_RefStatus"          => $Q_Refund_Status,
        "WT_RefAmount"          => $Q_TotalRefundAmount,
        "WT_RefDateTime"        => $Q_LastRefundDate
    );

    $logs = $vendor_name."'s Wallets Query Response Data Table Update :".date("Y-m-d H:i:s") . "," .json_encode($data). " \n\n";
    logwrite($logs, $log_path);

    $db->where('id_transaction_id', trim($id_transaction_id));
    $db->update('transaction_airpay_wallet', $data);
}

$response = array(
    "RefundId" => $Q_LastRefundRefNo,
    "res"      => ($Q_QueryStatus == "Y") ? 'SUCCESS' : 'FAILED',
    "desc"     => ($Q_ErrorDescription!='') ? trim($R_ErrorReason) : 'NULL'
);

print_r(json_encode($response));
exit;

?>