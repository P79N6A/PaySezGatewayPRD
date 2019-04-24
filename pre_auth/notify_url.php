<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once("MysqliDb.php");
require_once("encrypt.php");
require_once("alipayconfig.php");

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);
		
$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

$log_path = $alipay_config['log-path'];

/** Log File Function starts **/
function poslogs($log) {
	GLOBAL $log_path;
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}

$postdata = '';
foreach($_POST as $key=>$value) {
   $postdata .= $key.'='.$value.''.PHP_EOL; 
}
$postdata.= '==========================='.PHP_EOL;
$log = "Notify Response 2 ".date("Y-m-d H:i:s")."=>".$postdata."\n\n";
poslogs($log);


if($_POST['out_trade_no']!= '') { // Pay

	$log = "Notify Response ".date("Y-m-d H:i:s")."=>".json_encode($_POST)."\n\n";
	poslogs($log);

	$outputres = [];

	$outputres['gmt_create'] 			= isset($_POST['gmt_create']) ? $_POST['gmt_create'] : '';
	$outputres['seller_email'] 			= isset($_POST['seller_email']) ? $_POST['seller_email'] : '';
	$outputres['subject'] 				= isset($_POST['subject']) ? $_POST['subject'] : '';
	$outputres['sign'] 					= isset($_POST['sign']) ? $_POST['sign'] : '';
	$outputres['buyer_id'] 				= isset($_POST['buyer_id']) ? $_POST['buyer_id'] : '';
	$outputres['invoice_amount']		= isset($_POST['invoice_amount']) ? $_POST['invoice_amount'] : '';
	$outputres['notify_id'] 			= isset($_POST['notify_id']) ? $_POST['notify_id'] : '';
	$outputres['fund_bill_list'] 		= isset($_POST['fund_bill_list']) ? $_POST['fund_bill_list'] : '';
	$outputres['notify_type'] 			= isset($_POST['notify_type']) ? $_POST['notify_type'] : '';
	$outputres['receipt_amount'] 		= isset($_POST['receipt_amount']) ? $_POST['receipt_amount'] : '';
	$outputres['buyer_pay_amount'] 		= isset($_POST['buyer_pay_amount']) ? $_POST['buyer_pay_amount'] : '';
	$outputres['app_id'] 				= isset($_POST['app_id']) ? $_POST['app_id'] : '';
	$outputres['sign_type'] 			= isset($_POST['sign_type']) ? $_POST['sign_type'] : '';
	$outputres['seller_id'] 			= isset($_POST['seller_id']) ? $_POST['seller_id'] : '';
	$outputres['gmt_payment'] 			= isset($_POST['gmt_payment']) ? $_POST['gmt_payment'] : '';
	$outputres['notify_time'] 			= isset($_POST['notify_time']) ? $_POST['notify_time'] : '';
	$outputres['version']				= isset($_POST['version']) ? $_POST['version'] : '';
	$outputres['out_trade_no'] 			= isset($_POST['out_trade_no']) ? $_POST['out_trade_no'] : '';
	$outputres['total_amount'] 			= isset($_POST['total_amount']) ? $_POST['total_amount'] : '';
	$outputres['trade_no'] 				= isset($_POST['trade_no']) ? $_POST['trade_no'] : '';
	$outputres['auth_app_id'] 			= isset($_POST['auth_app_id']) ? $_POST['auth_app_id'] : '';
	$outputres['buyer_logon_id'] 		= isset($_POST['buyer_logon_id']) ? $_POST['buyer_logon_id'] : '';
	$outputres['point_amount'] 			= isset($_POST['point_amount']) ? $_POST['point_amount'] : '';
	$outputres['trade_status'] 			= isset($_POST['trade_status']) ? $_POST['trade_status'] : '';
	$outputres['input_charset'] 		= isset($_POST['charset']) ? $_POST['charset'] : '';

	$db->where("out_trade_no", $_POST['out_trade_no']);
	$trans_update = $db->update('transaction_alipay', $outputres);
}

if($_POST['out_order_no']!= '') {//voucher,unfreeze,cancel

	$log = "Notify Response ".date("Y-m-d H:i:s")."=>".json_encode($_POST)."\n\n";
	poslogs($log);

	$outputres = [];

	$outputres['operation_id'] 			= isset($_POST['operation_id']) ? $_POST['operation_id'] : '';
	$outputres['auth_no'] 				= isset($_POST['auth_no']) ? $_POST['auth_no'] : '';
	$outputres['sign_type'] 			= isset($_POST['sign_type']) ? $_POST['sign_type'] : '';
	$outputres['out_order_no'] 			= isset($_POST['out_order_no']) ? $_POST['out_order_no'] : '';
	$outputres['notify_type'] 			= isset($_POST['notify_type']) ? $_POST['notify_type'] : '';
	$outputres['payer_user_id']			= isset($_POST['payer_user_id']) ? $_POST['payer_user_id'] : '';
	$outputres['version'] 				= isset($_POST['version']) ? $_POST['version'] : '';
	$outputres['amount'] 				= isset($_POST['amount']) ? $_POST['amount'] : '';
	$outputres['trans_currency'] 		= isset($_POST['trans_currency']) ? $_POST['trans_currency'] : '';
	$outputres['rest_amount'] 			= isset($_POST['rest_amount']) ? $_POST['rest_amount'] : '';
	$outputres['notify_time'] 			= isset($_POST['notify_time']) ? $_POST['notify_time'] : '';
	$outputres['status'] 				= isset($_POST['status']) ? $_POST['status'] : '';
	$outputres['auth_app_id'] 			= isset($_POST['auth_app_id']) ? $_POST['auth_app_id'] : '';
	$outputres['operation_type'] 		= isset($_POST['operation_type']) ? $_POST['operation_type'] : '';
	$outputres['total_unfreeze_amount'] = isset($_POST['total_unfreeze_amount']) ? $_POST['total_unfreeze_amount'] : '';
	$outputres['sign'] 					= isset($_POST['sign']) ? $_POST['sign'] : '';
	$outputres['gmt_create']			= isset($_POST['gmt_create']) ? $_POST['gmt_create'] : '';
	$outputres['total_freeze_amount'] 	= isset($_POST['total_freeze_amount']) ? $_POST['total_freeze_amount'] : '';
	$outputres['payer_logon_id'] 		= isset($_POST['payer_logon_id']) ? $_POST['payer_logon_id'] : '';
	$outputres['out_request_no'] 		= isset($_POST['out_request_no']) ? $_POST['out_request_no'] : '';
	$outputres['app_id'] 				= isset($_POST['app_id']) ? $_POST['app_id'] : '';
	$outputres['total_pay_amount'] 		= isset($_POST['total_pay_amount']) ? $_POST['total_pay_amount'] : '';
	$outputres['notify_id'] 			= isset($_POST['notify_id']) ? $_POST['notify_id'] : '';
	$outputres['gmt_trans'] 			= isset($_POST['gmt_trans']) ? $_POST['gmt_trans'] : '';
	$outputres['input_charset'] 		= isset($_POST['charset']) ? $_POST['charset'] : '';
	$outputres['action'] 				= isset($_POST['action']) ? $_POST['action'] : '';
	

	$db->where("out_order_no", $_POST['out_order_no']);
	$trans_update = $db->update('transaction_alipay', $outputres);
}

// $log = "Notify Response 3 ".date("Y-m-d H:i:s")."=>".json_encode($_POST)."\n\n";
// poslogs($log);


exit;

/*
if($_POST['payer_logon_id']!= '' && $_POST['trans_currency']!= '') {
	$outputres = [];

	$outputres['operation_id'] 			= $_POST['operation_id'];
	$outputres['auth_no'] 				= $_POST['auth_no'];
	$outputres['sign_type'] 			= $_POST['sign_type'];
	$outputres['out_order_no'] 			= $_POST['out_order_no'];
	$outputres['notify_type'] 			= $_POST['notify_type'];
	$outputres['payer_user_id']			= $_POST['payer_user_id'];
	$outputres['version'] 				= $_POST['version'];
	$outputres['amount'] 				= $_POST['amount'];
	$outputres['trans_currency'] 		= $_POST['trans_currency'];
	$outputres['rest_amount'] 			= $_POST['rest_amount'];
	$outputres['notify_time'] 			= $_POST['notify_time'];
	$outputres['status'] 				= $_POST['status'];
	$outputres['auth_app_id'] 			= $_POST['auth_app_id'];
	$outputres['operation_type'] 		= $_POST['operation_type'];
	$outputres['total_unfreeze_amount'] = $_POST['total_unfreeze_amount'];
	$outputres['sign'] 					= $_POST['sign'];
	$outputres['gmt_create']			= $_POST['gmt_create'];
	$outputres['total_freeze_amount'] 	= $_POST['total_freeze_amount'];
	$outputres['payer_logon_id'] 		= $_POST['payer_logon_id'];
	$outputres['out_request_no'] 		= $_POST['out_request_no'];
	$outputres['app_id'] 				= $_POST['app_id'];
	$outputres['total_pay_amount'] 		= $_POST['total_pay_amount'];
	$outputres['notify_id'] 			= $_POST['notify_id'];
	$outputres['gmt_trans'] 			= $_POST['gmt_trans'];
	$outputres['input_charset'] 		= $_POST['charset'];

	$db->where("out_order_no", $_POST['out_order_no']);
	$trans_update = $db->update('transaction_alipay', $outputres);

} elseif($_POST['buyer_logon_id']!= '') {

	$outputres = [];

	$outputres['gmt_create'] 			= $_POST['gmt_create'];
	$outputres['seller_email'] 			= $_POST['seller_email'];
	$outputres['subject'] 				= $_POST['subject'];
	$outputres['sign'] 					= $_POST['sign'];
	$outputres['buyer_id'] 				= $_POST['buyer_id'];
	$outputres['invoice_amount']		= $_POST['invoice_amount'];
	$outputres['notify_id'] 			= $_POST['notify_id'];
	$outputres['fund_bill_list'] 		= $_POST['fund_bill_list'];
	$outputres['notify_type'] 			= $_POST['notify_type'];
	$outputres['receipt_amount'] 		= $_POST['receipt_amount'];
	$outputres['buyer_pay_amount'] 		= $_POST['buyer_pay_amount'];
	$outputres['app_id'] 				= $_POST['app_id'];
	$outputres['sign_type'] 			= $_POST['sign_type'];
	$outputres['seller_id'] 			= $_POST['seller_id'];
	$outputres['gmt_payment'] 			= $_POST['gmt_payment'];
	$outputres['notify_time'] 			= $_POST['notify_time'];
	$outputres['version']				= $_POST['version'];
	$outputres['out_trade_no'] 			= $_POST['out_trade_no'];
	$outputres['total_amount'] 			= $_POST['total_amount'];
	$outputres['trade_no'] 				= $_POST['trade_no'];
	$outputres['auth_app_id'] 			= $_POST['auth_app_id'];
	$outputres['buyer_logon_id'] 		= $_POST['buyer_logon_id'];
	$outputres['point_amount'] 			= $_POST['point_amount'];
	$outputres['trade_status'] 			= $_POST['trade_status'];
	$outputres['input_charset'] 		= $_POST['charset'];

	$db->where("out_trade_no", $_POST['out_trade_no']);
	$trans_update = $db->update('transaction_alipay', $outputres);

} elseif($_POST['total_unfreeze_amount']!= '') {

	$outputres = [];

	$outputres['operation_id'] 			= $_POST['operation_id'];
	$outputres['notify_time'] 			= $_POST['notify_time'];
	$outputres['auth_no'] 				= $_POST['auth_no'];
	$outputres['status'] 				= $_POST['status'];
	$outputres['sign_type'] 			= $_POST['sign_type'];
	$outputres['auth_app_id']			= $_POST['auth_app_id'];
	$outputres['out_order_no'] 			= $_POST['out_order_no'];
	$outputres['notify_type'] 			= $_POST['notify_type'];
	$outputres['payer_user_id'] 		= $_POST['payer_user_id'];
	$outputres['operation_type'] 		= $_POST['operation_type'];
	$outputres['version'] 				= $_POST['version'];
	$outputres['sign'] 					= $_POST['sign'];
	$outputres['total_unfreeze_amount'] = $_POST['total_unfreeze_amount'];
	$outputres['amount'] 				= $_POST['amount'];
	$outputres['gmt_create'] 			= $_POST['gmt_create'];
	$outputres['rest_amount'] 			= $_POST['rest_amount'];
	$outputres['total_freeze_amount']	= $_POST['total_freeze_amount'];
	$outputres['payer_logon_id'] 		= $_POST['payer_logon_id'];
	$outputres['out_request_no'] 		= $_POST['out_request_no'];
	$outputres['app_id'] 				= $_POST['app_id'];
	$outputres['notify_id'] 			= $_POST['notify_id'];
	$outputres['total_pay_amount'] 		= $_POST['total_pay_amount'];
	$outputres['gmt_trans'] 			= $_POST['gmt_trans'];
	$outputres['input_charset'] 		= $_POST['charset'];

	$db->where("out_order_no", $_POST['out_order_no']);
	$trans_update = $db->update('transaction_alipay', $outputres);

} elseif($_POST['action']!= '') {

	$outputres = [];

	$outputres['operation_id'] 			= $_POST['operation_id'];
	$outputres['notify_time'] 			= $_POST['notify_time'];
	$outputres['auth_no'] 				= $_POST['auth_no'];
	$outputres['sign_type'] 			= $_POST['sign_type'];
	$outputres['auth_app_id']			= $_POST['auth_app_id'];
	$outputres['out_order_no'] 			= $_POST['out_order_no'];
	$outputres['notify_type'] 			= $_POST['notify_type'];
	$outputres['version'] 				= $_POST['version'];
	$outputres['sign'] 					= $_POST['sign'];
	$outputres['out_request_no'] 		= $_POST['out_request_no'];
	$outputres['app_id'] 				= $_POST['app_id'];
	$outputres['notify_id'] 			= $_POST['notify_id'];
	$outputres['action'] 				= $_POST['action'];
	$outputres['input_charset'] 		= $_POST['charset'];

	$db->where("out_order_no", $_POST['out_order_no']);
	$trans_update = $db->update('transaction_alipay', $outputres);

} else {
	echo "Data not Post Error";
}
*/



// /* *
//  * 功能：支付宝服务器异步通知页面
//  * 版本：3.3
//  * 日期：2012-07-23
//  * 说明：
//  * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
//  * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
//  * function:Server asynchronous notification page
//  * version:3.3
//  *modify date：2012-08-17
//  *instruction:
//  *This code below is a sample demo for merchants to do test.Merchants can refer to the integration documents and write your own code to fit your website.Not necessarily to use this code.  
//  *Alipay provide this code for you to study and research on Alipay interface, just for your reference.


//  *************************页面功能说明*************************
//  * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
//  * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
//  * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
//  * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
//  */
//  *************************function description*************************
//  * When creating this page file, please pay attention and ensure there's not any HTML code and space in the page file.
//  * This page cannot be tested locally. Please do the test on the server and make sure that it is accessable from outer net.
//  * The page debugging tool, please use the function logResult to write the log which is closed by default.Please refer to function verifyNotify in page alipay_notify_class.php.
//  *If Alipay system do not receive success returned on this page, If not, Alipay server would keep re-sending notification until over 24 hour according to retransmission strategy
//  * */
// require_once("alipay.config.php");
// require_once("lib/alipay_notify.class.php");

// //计算得出通知验证结果
// //caculate and get the result of verification
// $alipayNotify = new AlipayNotify($alipay_config);
// $verify_result = $alipayNotify->verifyNotify();

// if($verify_result) {//验证成功 verification is succeeded
// 	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 	//请在这里加上商户的业务逻辑程序代
// 	//Please add yourprogram code here according to your business logic.

	
// 	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
// 	//——Please write program according to your business logic.(The below code is for your reference.)
	
//     //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
//     //To get the returned parameters from notification.You can refer to alipay's notification parameters list in integration documents.
// 	//商户订单号
// 	//out_trade_no

// 	$out_trade_no = $_POST['out_trade_no'];

// 	//支付宝交易号
// 	//trade_no

// 	$trade_no = $_POST['trade_no'];

// 	//交易状态
// 	//trade_status
// 	$trade_status = $_POST['trade_status'];
	


//     if($_POST['trade_status'] == 'TRADE_FINISHED') {
// 		//判断该笔订单是否在商户网站中已经做过处理
// 			//Check whether the order has been processed in the partner's website.
// 			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
// 			//If it has not been processed,query the detail of the order in order system of your website according to the order number (out_trade_no) and perform program code of your business logic.
// 			//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
// 			//Please make sure the total_fee, seller_id get from notification are the same with the parameters in request.
// 			//如果有做过处理，不执行商户的业务程序
// 			//If the order has been processed in the partner's website,do not perform your program code of business logic.
				


//         //调试用，写文本函数记录程序运行情况是否正常
//         //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
// 	//For debug,write text function to record how your program behaves
//         //logResult("Write the variable or record of program you want to debug with");	
//     }
//     else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
// 		//判断该笔订单是否在商户网站中已经做过处理
// 		//To check whether the order has been processed in the partner's website.
// 			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
// 			//If it has not been processed,query the detail of the order in order system of your website according to the order number (out_trade_no) and perform program code of your business logic.
// 			//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
// 			//Please make sure the total_fee, seller_id get from notification are the same with the parameters in request.
// 			//如果有做过处理，不执行商户的业务程序
// 			//If the order has been processed in the partner's website,do not perform your program code of business logic.
				
// 		//注意：
// 			//note:
// 		//付款完成后，支付宝系统发送该交易状态通知
// 		//When transanction finished,Alipay system will notification with trade status 
//         //调试用，写文本函数记录程序运行情况是否正常
//         //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
// 	//For debug,write text function to record how your program behaves
//         //logResult("Write the variable or record of program you want to debug with");
//     }

// 	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
// 	//Please write program according to your business logic.(The above code is only for reference.)    
// 	echo "success";		//请不要修改或删除 do not modify or delete
	
// 	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// }
// else {
//     //验证失败
//     echo "fail";

//     //调试用，写文本函数记录程序运行情况是否正常
//     //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
//     //For debug,write text function to record how your program behaves
//     //logResult("Write the variable or record of program you want to debug with");
// }
?>