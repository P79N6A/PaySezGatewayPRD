<?php


date_default_timezone_set('Asia/Kolkata');
//require_once("alipay.config.php");
require_once("grabPay.config.php");
function poslogs($log) {
	GLOBAL $log_path;
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}
$log_path = $grabpay_config['log-path'];

//*** Request as "JSON with POST" OR "Form with POST" methods ***/
 $json_str = file_get_contents('php://input');
 if($json_str!=null) {
	$_POST = array_merge($_POST, (array) json_decode(file_get_contents('php://input')));
} else {
	$_POST = $_POST;
}
$data = json_encode($_POST);

$log = "Application Log GP:".date("Y-m-d H:i:s") . " GP Async Response :" . $data . " \n\n";
poslogs($log);

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
require_once('../api/encrypt.php');

error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$db = new Mysqlidb ($confighost, $userd, $passd, $grabpay_config['dataBase_con']);


// header('Content-Type: application/json');
// echo "Payment notification Response #:" . $data;

$not_url    = 'https://paymentgateway.test.credopay.in/testspaysez/grabpay/terminal_response.php';
$characters = json_decode($data,true);// decode the JSON feed

$status         = $characters['status'];
$txType         = $characters['txType'];
$partnerID      = $characters['partnerID'];
$partnerTxID    = $characters['partnerTxID'];
$txID           = $characters['txID'];
$origTxID       = $characters['origTxID'];
$amount         = $characters['amount'];
$currency       = $characters['currency'];
$createdAt      = $characters['createdAt'];
$completedAt    = $characters['completedAt'];
$payload        = $characters['payload'];
$TerminalID     = $characters['TerminalID'];

$payload_encod  = json_encode($payload);

$asyn_response_data = array(
    "gp_status"         => $status,
    "gp_txType"         => $txType,
    "gp_partnerID"      => $partnerID,
    "gp_partnerTxID"    => $partnerTxID,
    "gp_txID"           => $txID,
    "gp_origTxID"       => $origTxID,
    "gp_amount"         => $amount,
    "gp_currency"       => $currency,
    "gp_createdAt"      => $createdAt,
    "gp_completedAt"    => $completedAt,
    "gp_payload"        => $payload_encod,
    "gp_terminal_id_grab" => $TerminalID
);


// ebe code change start


//API access key from Google API's Console
define( 'SERVER_API_KEY', 'AIzaSyCY0DH3S8shXPxsXKTclFyfWOrG7rQeKoA');
$tokens = ['dsIc4dqrsAs:APA91bGf9UyHvFzNcse8jSgx6t265Xd33RPyLZkfGRaCpcQ649Uv9O0527kfs3ZcjyZJHWk2mIbxl84-Ec4mNTl9tXKc8nbFu2KSTncFi8hDg5ENzQnS6oSUfobtpZzc7eemFTUUkN6n'];
// prep the bundle
$msg = [
    'gp_status' 		=> $status,
    'gp_partnerTxID'    => $partnerTxID,
    'gp_amount'         => $amount,
    'gp_terminal_id' 	=> $TerminalID
];
// $msg=['{"gp_status":"'.$status.'","gp_txType":"'.$txType.'","gp_partnerID":"'.$partnerID.'","gp_partnerTxID":"'.$partnerTxID.'","gp_txID":"'.$txID.'","gp_origTxID":"'.$origTxID.'","gp_amount":"'.$amount.'","gp_currency":"'.$currency.'","gp_createdAt":"'.$createdAt.'","gp_completedAt":"'.$completedAt.'","gp_payload":"'.$payload_encod.'","gp_terminal_id":"'.$TerminalID.'"}'];

$payloaded =[
    'registration_ids'  => $tokens,
    'data'              => $msg
];
 
$headers =[
    'Authorization: key=' . SERVER_API_KEY,
    'Content-Type: application/json'
];
 
$curl= curl_init();

curl_setopt_array($curl,array(
CURLOPT_URL             => 'https://fcm.googleapis.com/fcm/send',
CURLOPT_RETURNTRANSFER  => true,
CURLOPT_CUSTOMREQUEST   => "POST",
CURLOPT_POSTFIELDS      => json_encode($payloaded),
CURLOPT_HTTPHEADER      => $headers
));
$responsess  =curl_exec($curl);
$err         =curl_error($curl);
curl_close($curl); 

if($err){
    echo "cURL Error #:". $err;
    $log = "Application Log GP:".date("Y-m-d H:i:s") . "Push Notification Error:" .json_encode($err) . " \n\n";
        poslogs($log);
}
else{
    echo $responsess;
    $log = "Application Log GP:".date("Y-m-d H:i:s") . "Push Notification:" .json_encode($responsess) . " \n\n";
        poslogs($log);
}


//ebe code change end



$db->where("gp_partnerTxID" , $partnerTxID);
$trans_type     = $db->getone("gp_transaction");
$tran_req_type  = $trans_type['gp_transaction_type'];
//$terminal_id = $trans_type['gp_terminal_id'];
// $test = "Application Log GP:".date("Y-m-d H:i:s") . " test:" . $tran_req_type.$status . " \n\n";
// 	 	poslogs($test);
$res_to_grab = '{"code":204,"response":""}';
if($tran_req_type == 1 && $status == 'success') {
		// if($status == 'success' || $status ==  'failed' || $status ==  'unknown' || $status ==  'pending' || $status ==  'bad_debt'){

		
		/* Updating Transaction table after success payment response */
        $db->where("gp_partnerTxID", $partnerTxID);
        $db->where("gp_transaction_type",$tran_req_type);
        $db->where("gp_payment_type",'GP');
        $asyn_res_upd = $db->update('gp_transaction', $asyn_response_data);


        $pay_success_res = "Application Log GP:".date("Y-m-d H:i:s") . " Pay notify response update in table:" . json_encode($asyn_response_data) . " \n\n";
        poslogs($pay_success_res);
		
		$async_response_app = array(
			"transaction_status" => $status,
			"txID"               => $txID,
			"origTxID"           => $origTxID,
			"terminal_id"        => $TerminalID,
			"currency"           => $currency,
			"amount"	         => $amount,
			"tran_req_type"      => $tran_req_type,
			"ack_notify_url"     => $not_url
		);

		// $pay_success_res_to_app = "Application Log GP:".date("Y-m-d H:i:s") . " Pay notify response send to mpos:" . json_encode($async_response_app) . " \n\n";
  //       poslogs($pay_success_res_to_app);

  //       $response_encode = json_encode($async_response_app);
  //       header('Content-Type: application/json');
		// echo "Payment notification Response #:" . $response_encode;

		
 }
		elseif($tran_req_type == 2 && $status == 'success'){

		/* Updating Transaction table after refund payment response */
        $db->where("gp_partnerTxID", $partnerTxID);
        $db->where("gp_transaction_type",$tran_req_type);
        $db->where("gp_payment_type",'GP');
        $asyn_res_upd = $db->update('gp_transaction', $asyn_response_data);


//         $refund_success_res = "Application Log GP:".date("Y-m-d H:i:s") . " Refund notification Success response:" . json_encode($asyn_response_data) . " \n\n";
//         poslogs($refund_success_res);
		
// 		$async_response_app = array(
// 			"transaction_status" => $status,
// 			"refund_amount"	=> $amount,
// 			"txID" => $txID,
// 			"terminal_id" => $TerminalID
// 		);

// 		// $refund_success_res_to_app = "Application Log GP:".date("Y-m-d H:i:s") . " Pay notify response send to mpos:" . json_encode($async_response_app) . " \n\n";
//   //       poslogs($refund_success_res_to_app);

//   //       $response_encode = json_encode($async_response_app);
//   //       header('Content-Type: application/json');
// 		// echo "Payment notification Response #:" . $response_encode;

}
		echo $res_to_grab;
		exit;


// $response_data = array(
//     "txType" => $_POST['out_trade_no'],
//     "partnerID" => $_POST['extra_common_param'],
//     "partnerTxID" => $terminal_id,
//     "txID" => $tran_req_type,
//     "origTxID" => $currency,
//     "amount" => $total_fee,
//     "currency" => $alipay_config['ack_url'],
//     "status" => $total_fee,
//     "createdAt" => $total_fee,
//     "completedAt" => $total_fee,
//     "payload" => $total_fee,
//     "payerName" => $total_fee,
//     "grabpayID" => $total_fee,
//     "TerminalID" => $total_fee,

// );
//  if($_POST['status'] == 'success') {


// }
// //DB connection
// $duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
// $dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

// $dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
// echo $_SERVER[''];
// require_once('../php/MysqliDb.php');
// require '../kint/Kint.class.php';
// require_once('../api/encrypt.php');
// error_reporting(0);
// $userd=mc_decrypt($duser, $dkey);
// $passd=mc_decrypt($dcode, $dkey);

// $db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

// /* Log path declare by variable use in function poslogs */
 
// /** Log File Function starts **/
// function poslogs($log) {
// 	GLOBAL $log_path;
// 	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
// 	return $myfile;     
// }
// if($_POST['notify_type'] == 'trade_status_sync'){

// $log = "Application Log CBP:".date("Y-m-d H:i:s") . " Payment Async Response:" . json_encode($_POST) . " \n\n";
// poslogs($log);

//  	//notify_id
//  	$notify_id = $_POST['notify_id'];

//  	//notify_type
//  	$notify_type = $_POST['notify_type'];

//  	//trade_status_sync
//  	$trade_status_sync = $_POST['trade_status_sync'];

//  	//sign
//  	$sign = $_POST['sign']; 

//  	//trade_no
//  	$trade_no = $_POST['trade_no'];

//  	//total_fee
//  	$total_fee = $_POST['total_fee'];

//  	//out_trade_no
// 	$out_trade_no = $_POST['out_trade_no'];

// 	//notify_time
// 	$notify_time = $_POST['notify_time'];

// 	//currency
// 	$currency	 = $_POST['currency'];

// 	//trade_status
// 	$trade_status = $_POST['trade_status'];
	
// 	//sign_type
// 	$sign_type = $_POST['sign_type'];

	

// if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS'){
// 		$async_response = array(
// 		"notify_id" => $notify_id,
// 		"notify_type" => $notify_type,
// 		"res_sign" => $sign,
// 		"trade_no" => $trade_no,
// 		"total_fee"	=> $total_fee,
// 		"notify_time" => $notify_time,
// 		"currency" => $currency,
// 		"trade_status" => $trade_status,
// 		"res_sign_type" => $sign_type,
// 		"result_code" => 'SUCCESS'
// 		);

//     	/* Updating Transaction table after success response */
//         $db->where("out_trade_no", $out_trade_no);
//         $db->where("transaction_type",'cb1');
//         $db->where("payment_type",'wap');
//         $trans_suc_update = $db->update('transaction_alipay', $async_response);

//         $pay_success_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Pay notify response update in table:" . json_encode($async_response) . " \n\n";
//         poslogs($pay_success_res);

//         echo "success";	

//     }else{
//     	$async_response = array(
// 		"notify_id" => $notify_id,
// 		"notify_type" => $notify_type,
// 		"res_sign" => $sign,
// 		"trade_no" => $trade_no,
// 		"total_fee"	=> $total_fee,
// 		"notify_time" => $notify_time,
// 		"currency" => $currency,
// 		"trade_status" => $trade_status,
// 		"res_sign_type" => $sign_type,
// 		"result_code" => 'FAIL'
// 		);

//     	/* Updating Transaction table after fail response */
//         $db->where("out_trade_no", $out_trade_no);
//         $db->where("transaction_type",'cb1');
//         $db->where("payment_type",'wap');
//         $trans_fail_update = $db->update('transaction_alipay', $async_response);

//         $pay_fail_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Pay notify response update in table:" . json_encode($async_response) . " \n\n";
//         poslogs($pay_fail_res);
//     	echo "fail";
//     }
// }else if($_POST['notify_type'] == 'refund_status_sync'){

// 	$log = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund Async Response:" . json_encode($_POST) . " \n\n";
// 	poslogs($log);

//  	//notify_type
//  	$notify_type = $_POST['notify_type'];

//  	//return_amount
//  	$return_amount = $_POST['return_amount'];

//  	//notify_time
// 	$notify_time = $_POST['notify_time'];

// 	//out_trade_no
// 	$out_trade_no = $_POST['out_trade_no'];

// 	//refund_status
// 	$refund_status = $_POST['refund_status'];

// 	//sign
//  	$sign = $_POST['sign'];

//  	//out_return_no
//  	$out_return_no = $_POST['out_return_no'];

//  	//currency
// 	$currency	 = $_POST['currency'];

// 	//sign_type
// 	$sign_type = $_POST['sign_type'];

// 	//notify_id
//  	$notify_id = $_POST['notify_id'];


// if($_POST['refund_status'] == 'REFUND_SUCCESS'){
// 		$async_response = array(
// 		"notify_type" => $notify_type,
// 		"refund_amount" => $return_amount,
// 		"notify_time" => $notify_time,
// 		"refund_status" => $refund_status,
// 		"res_sign" => $sign,
// 		"currency" => $currency,
// 		"res_sign_type" => $sign_type,
// 		"notify_id" => $notify_id,
// 		"result_code" => 'SUCCESS'
// 		);

//     	/* Updating Transaction table after refund success response */
//         $db->where("out_trade_no", $out_trade_no);
//         $db->where("transaction_type",'cb2');
//         $db->where("payment_type",'wap');
//         $refund_suc_update = $db->update('transaction_alipay', $async_response);

//         $refund_success_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund notify response update in table:" . json_encode($async_response) . " \n\n";
//         poslogs($refund_success_res);

//         echo "success";	

//     }else{
//     	$async_response = array(
// 		"notify_type" => $notify_type,
// 		"refund_amount" => $return_amount,
// 		"notify_time" => $notify_time,
// 		"refund_status" => $refund_status,
// 		"res_sign" => $sign,
// 		"currency" => $currency,
// 		"res_sign_type" => $sign_type,
// 		"notify_id" => $notify_id,
// 		"result_code" => 'FAIL'
// 		);

//     	/* Updating Transaction table after refund fail response */
//         $db->where("out_trade_no", $out_trade_no);
//         $db->where("transaction_type",'cb2');
//         $db->where("payment_type",'wap');
//         $refund_fail_update = $db->update('transaction_alipay', $async_response);

//         $refund_fail_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund notify response update in table:" . json_encode($async_response) . " \n\n";
//         poslogs($refund_fail_res);
//     	echo "fail";
//     }

// }
	

 
?>