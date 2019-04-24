<?php
// echo "hii";
// echo "<pre>";
// print_r($_POST);exit;
date_default_timezone_set('Asia/Kolkata');

require_once("alipay.config.php");

//DB connection
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
require_once('../api/encrypt.php');
error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

/* Log path declare by variable use in function poslogs */
$log_path = $alipay_config['log-path'];

/** Log File Function starts **/
function poslogs($log) {
	GLOBAL $log_path;
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}
if($_POST['notify_type'] == 'trade_status_sync'){

$log = "Application Log CBP:".date("Y-m-d H:i:s") . " Payment Async Response:" . json_encode($_POST) . " \n\n";
poslogs($log);

 	//notify_id
 	$notify_id = $_POST['notify_id'];

 	//notify_type
 	$notify_type = $_POST['notify_type'];

 	//trade_status_sync
 	$trade_status_sync = $_POST['trade_status_sync'];

 	//sign
 	$sign = $_POST['sign']; 

 	//trade_no
 	$trade_no = $_POST['trade_no'];

 	//total_fee
 	$total_fee = $_POST['total_fee'];

 	//out_trade_no
	$out_trade_no = $_POST['out_trade_no'];

	//notify_time
	$notify_time = $_POST['notify_time'];

	//currency
	$currency	 = $_POST['currency'];

	//trade_status
	$trade_status = $_POST['trade_status'];
	
	//sign_type
	$sign_type = $_POST['sign_type'];

	

if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS'){
		$async_response = array(
		"notify_id" => $notify_id,
		"notify_type" => $notify_type,
		"res_sign" => $sign,
		"trade_no" => $trade_no,
		"total_fee"	=> $total_fee,
		"notify_time" => $notify_time,
		"currency" => $currency,
		"trade_status" => $trade_status,
		"res_sign_type" => $sign_type,
		"result_code" => 'SUCCESS'
		);

    	/* Updating Transaction table after success response */
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",'cb1');
        $db->where("payment_type",'wap');
        $trans_suc_update = $db->update('transaction_alipay', $async_response);

        $pay_success_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Pay notify response update in table:" . json_encode($async_response) . " \n\n";
        poslogs($pay_success_res);

        echo "success";	

    }else{
    	$async_response = array(
		"notify_id" => $notify_id,
		"notify_type" => $notify_type,
		"res_sign" => $sign,
		"trade_no" => $trade_no,
		"total_fee"	=> $total_fee,
		"notify_time" => $notify_time,
		"currency" => $currency,
		"trade_status" => $trade_status,
		"res_sign_type" => $sign_type,
		"result_code" => 'FAIL'
		);

    	/* Updating Transaction table after fail response */
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",'cb1');
        $db->where("payment_type",'wap');
        $trans_fail_update = $db->update('transaction_alipay', $async_response);

        $pay_fail_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Pay notify response update in table:" . json_encode($async_response) . " \n\n";
        poslogs($pay_fail_res);
    	echo "fail";
    }
}else if($_POST['notify_type'] == 'refund_status_sync'){

	$log = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund Async Response:" . json_encode($_POST) . " \n\n";
	poslogs($log);

 	//notify_type
 	$notify_type = $_POST['notify_type'];

 	//return_amount
 	$return_amount = $_POST['return_amount'];

 	//notify_time
	$notify_time = $_POST['notify_time'];

	//out_trade_no
	$out_trade_no = $_POST['out_trade_no'];

	//refund_status
	$refund_status = $_POST['refund_status'];

	//sign
 	$sign = $_POST['sign'];

 	//out_return_no
 	$out_return_no = $_POST['out_return_no'];

 	//currency
	$currency	 = $_POST['currency'];

	//sign_type
	$sign_type = $_POST['sign_type'];

	//notify_id
 	$notify_id = $_POST['notify_id'];


if($_POST['refund_status'] == 'REFUND_SUCCESS'){
		$async_response = array(
		"notify_type" => $notify_type,
		"refund_amount" => $return_amount,
		"notify_time" => $notify_time,
		"refund_status" => $refund_status,
		"res_sign" => $sign,
		"currency" => $currency,
		"res_sign_type" => $sign_type,
		"notify_id" => $notify_id,
		"result_code" => 'SUCCESS'
		);

    	/* Updating Transaction table after refund success response */
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",'cb2');
        $db->where("payment_type",'wap');
        $refund_suc_update = $db->update('transaction_alipay', $async_response);

        $refund_success_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund notify response update in table:" . json_encode($async_response) . " \n\n";
        poslogs($refund_success_res);

        echo "success";	

    }else{
    	$async_response = array(
		"notify_type" => $notify_type,
		"refund_amount" => $return_amount,
		"notify_time" => $notify_time,
		"refund_status" => $refund_status,
		"res_sign" => $sign,
		"currency" => $currency,
		"res_sign_type" => $sign_type,
		"notify_id" => $notify_id,
		"result_code" => 'FAIL'
		);

    	/* Updating Transaction table after refund fail response */
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",'cb2');
        $db->where("payment_type",'wap');
        $refund_fail_update = $db->update('transaction_alipay', $async_response);

        $refund_fail_res = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund notify response update in table:" . json_encode($async_response) . " \n\n";
        poslogs($refund_fail_res);
    	echo "fail";
    }

}
	

 
?>