<?php
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
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
date_default_timezone_set('Asia/Kolkata');

//caculate and get the result of verification
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功 verification is succeeded
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	//Please add yourprogram code here according to your business logic.
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	//——Please write program according to your business logic.(The below code is for your reference.)
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
    //To get the returned parameters from notification.You can refer to alipay's notification parameters list in integration documents.
	//商户订单号

	//out_trade_no
	$out_trade_no = $_GET['out_trade_no'];

	//total_fee
	$total_fee = $_GET['total_fee'];

	//trade status
	$trade_status = $_GET['trade_status'];

	//sign
	$sign = $_GET['sign'];

	//trade_no
	$trade_no = $_GET['trade_no'];

	//currency
	$currency = $_GET['currency'];

	//sign_type
	$sign_type = $_GET['sign_type'];


	$log_path = $alipay_config['log-path'];

	/* Log File Function starts */
	function poslogs($log) {
		GLOBAL $log_path;
		$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
		return $myfile;     
	}


	$log = "Application Log CBP:".date("Y-m-d H:i:s") . " Payment Return Sync Response:" . json_encode($_GET) . " \n\n";
	poslogs($log);


    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
    	$return_response = array(
		'total_fee' => $total_fee,
		'trade_status' => $trade_status,
		'return_sign' => $sign,
		'trade_no' => $trade_no,
		'currency' => $currency,
		'return_sign_type' => $sign_type,
		'result_code' => 'SUCCESS'
		);

    	/* Updating Transaction table after success response */
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",'cb1');
        $db->where("payment_type",'wap');
        $trans_suc_update = $db->update('transaction_alipay', $return_response);

        $pay_success_res ="Application Log CBP:".date("Y-m-d H:i:s") . " Pay return response update in table:" . json_encode($return_response) . " \n\n";
        poslogs($pay_success_res);

		echo 'SUCCESS';
		header( "Refresh:0;url=https://paymentgateway.test.credopay.in/shop/checkout1.php?success=true&order_id=".$trade_no);
    }
	

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	//Please write program according to your business logic.(The above code is only for reference.)    
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
		$return_response = array(
		'total_fee' => $total_fee,
		'trade_status' => $trade_status,
		'return_sign' => $sign,
		'trade_no' => $trade_no,
		'currency' => $currency,
		'return_sign_type' => $sign_type,
		'result_code' => 'FAIL'
		);

        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",'cb1');
        $db->where("payment_type",'wap');
        $trans_fail_update = $db->update('transaction_alipay', $return_response);

        $pay_fail_res ="Application Log CBP:".date("Y-m-d H:i:s") . " Pay return response update in table:" . json_encode($return_response) . " \n\n";
        poslogs($pay_fail_res);

        echo "FAIL";

		header( "Refresh:0;url=https://paymentgateway.test.credopay.in/shop/checkout1.php?fail=true&order_id=".$trade_no);
    	
}
?>
	</head>
    <body>
    </body>
</html>