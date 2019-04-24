<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<body>

<div id="demo" class="alert alert-success">
<strong>Success!</strong> order success pay inprocess</div>

<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once("MysqliDb.php");
require_once("encrypt.php");
require_once("alipayconfig.php");
require_once("lib/alipay_submit_class.php");

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
/* china time call in function */
function conversionfrom_indiatochinatime($datetime) {
	$given_cncl = new DateTime($datetime);
	$given_cncl->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
	$updated_datetime_cncl = $given_cncl->format("Y-m-d H:i:s");
	return $updated_datetime_cncl;
}

$datetime = date('Y-m-d H:i:s');
$datetime_ch = conversionfrom_indiatochinatime($datetime);

	if($_POST['terminal_id']!="") {


	$terminal_id 		= $_POST['terminal_id'];

	$db->where("mso_terminal_id",$terminal_id);
	$terminal_res = $db->getOne("terminal");
	$terminalIdds = $terminal_res['mso_terminal_id'];
	$terminal_active = $terminal_res['active']; 

		if($terminalIdds != "" && $terminal_active == 1) {
		$merchant_id  = $terminal_res['idmerchants'];
		$mso_location = $terminal_res['mso_ter_location'];

		} else if($terminalIdds != "" && $terminal_active != 1) {
	 		$terminal_active_sts = "Pre_auth Terminal Acive Log:".date("Y-m-d H:i:s") . " Terminal Not Active Id:" .json_encode($ter_act). " \n\n";
	 		poslogs($terminal_active_sts);
	echo 'Terminal Id Not Active';
	die();

		} else {
			$terminal_id_empty = "Pre_auth terminal Id wrong Log:".date("Y-m-d H:i:s") . " Received wrong terminal From pos:" .$terminal_wrong. " \n\n";
		 	poslogs($terminal_id_empty);
		echo 'Terminal Id Wrong';
		die();

		}

	} else {
	 	$terminal_id_empty = "Pre_auth terminal check Log:".date("Y-m-d H:i:s") . " Received empty terminal From pos:" .$terminal_empty. " \n\n";
	 	poslogs($terminal_id_empty);
	echo 'Terminal Id Empty';
	die();
	}

			 $db->where('idmerchants',$merchant_id);
			 $merchant_details = $db->getOne("merchants");
			 $secondary_merchant_name_init = preg_replace('!\s+!', ' ',$merchant_details['merchant_name']);
			 $secondary_merchant_name = str_replace(' ','_',$secondary_merchant_name_init);
			 $secondary_merchant_id = $merchant_details['mer_map_id'];
			 $secondary_merchant_industry = $merchant_details['mcc'];
			$currency_code = $merchant_details['currency_code'];
			$store_id = $merchant_details['mer_map_id'];
			
			if($mso_location == ""){
			$name_split = explode(' ',$secondary_merchant_name);
			$loc_name = $name_split[0];
			$store_name = $loc_name;
			}
	
			else{
			 $store_name = $mso_location;
			 }

			 $pcrq = $merchant_details['pcrq'];
			 $str = explode("~",$pcrq);
			

// echo $terminal_id;
// echo "<br><br>";
// echo $terminal_active;
// echo "<br><br>";
//  echo $secondary_merchant_id;
//  echo "<br><br>";
 
// echo $store_id;
// echo "<br><br>";
// echo $store_name;


	if ($_POST['Pre_Auth']=="voucher" && $_POST['tran_req_type']=="PA1") {


		if($currency_code != $_POST['trans_currency']) { 

		$currency_received = array(
		    "currency" 		=> $_POST['trans_currency'],
		    "out_order_no" 	=> $_POST['out_order_no'],
		    "terminal_id" 	=> $terminal_id,
		    "tran_req_type" => $_POST['tran_req_type'],
		);
		    $currency_error = array(
		    "transaction_status" 	=> 'merchant not found',
		    "out_order_no" 			=> $_POST['out_order_no'],
		    "terminal_id" 			=> $terminal_id,
		    "tran_req_type"			=> $_POST['tran_req_type'],
		);
		    $currency_status = "Currency Matching log pre_auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		    poslogs($currency_status);

		    $currency_error_encode = json_encode($currency_error);
		    header('Content-Type: application/json');
		    echo $currency_error_encode;
		    exit;
		    die();

		} 
		     $db->where('currency',$currency_code);
		     $db->where('merchant_id',$secondary_merchant_id);  
		     $cur_res = $db->getOne('alipay_config');
		     $partner_id_alipay = $cur_res['partner_id'];

		    /* validation for otn already exist or not */
		    $db->where("out_order_no",$_POST['out_order_no']);
		    $db->where("transaction_type",$_POST['tran_req_type']);
		    $record_check = $db->get('transaction_alipay');
		    $count = count($record_check);

			if($count >=1){
			$error_otn = array(
			"out_order_no" => $out_order_no,
			"terminal_id" => $terminal_id,
			"transaction_type" => $ttype,
			"error" => 'The given out order no already exist'
			);
			$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
			poslogs($otn_log);
			echo "The given out order no already exist,use new one";
			exit;
			die();
			}



		$out_order_no 		= $_POST['out_order_no'];	
		$out_request_no		= $_POST['out_request_no'];
		$order_title		= $_POST['order_title'];
		$amount				= $_POST['amount'];
		$trans_currency		= $_POST['trans_currency'];
		$settle_currency	= $_POST['settle_currency'];		
		$extra_param		= $_POST['extra_param'];
		$product_code 		= $_POST['product_code'];
		$terminal_id 		= $terminal_id;
		$method				= $_POST['method'];
		$app_id 			= $_POST['app_id'];
		$version 			= $_POST['version'];
		$timestamp 			= $_POST['timestamp'];
		$transaction_type   = $_POST['tran_req_type'];

		$biz_content='{"out_order_no":"'.$out_order_no.'","out_request_no":"'.$out_request_no.'","order_title":"'.$order_title.'","amount":"'.$amount.'","trans_currency":"'.$trans_currency.'","settle_currency":"'.$settle_currency.'","extra_param":'.$extra_param.',"product_code":"'.$product_code.'"}';

		$parameter_ins= array(
			"out_order_no"		=> $out_order_no,
			"out_request_no" 	=> $out_request_no,
			"order_title" 		=> $order_title,
			"amount"			=> $amount,
			"trans_currency" 	=> $trans_currency,
			"settle_currency" 	=> $settle_currency,
			"extra_param" 		=> $extra_param,
			"product_code" 		=> $product_code,
			"input_charset"		=> trim(strtoupper($alipay_config['charset'])),
			"biz_content" 		=> $biz_content,
			"terminal_id"		=> $terminal_id,
			"method" 			=> $method,
			"app_id"			=> $app_id,
			"version" 			=> $version,
			"sign_type" 		=> $alipay_config['sign_type'],
			"timestamp" 		=> $timestamp,
			"format"			=> 'JSON',
			"notify_url" 		=> $alipay_config['notify_url'],
			"transaction_type"	=> $transaction_type,
			"cst_trans_datetime"=> $datetime_ch,
			"trans_datetime" 	=> date('Y-m-d H:i:s'),
			"trans_time" 		=> date('H:i:s'),
			"trans_date" 		=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} elseif ($_POST['Pre_Auth']=="query" && $_POST['tran_req_type']=="PA2") {

		if($currency_code != $_POST['trans_currency']) { 

		$currency_received = array(
		    "currency" 		=> $_POST['trans_currency'],
		    "out_order_no" 	=> $_POST['out_order_no'],
		    "terminal_id" 	=> $terminal_id,
		    "tran_req_type" => $_POST['tran_req_type'],
		);
		    $currency_error = array(
		    "transaction_status" 	=> 'merchant not found',
		    "out_order_no" 			=> $_POST['out_order_no'],
		    "terminal_id" 			=> $terminal_id,
		    "tran_req_type"			=> $_POST['tran_req_type'],
		);
		    $currency_status = "Currency Matching log pre_Auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		   poslogs($currency_status);

		    $currency_error_encode = json_encode($currency_error);
		    header('Content-Type: application/json');
		    echo $currency_error_encode;
		    exit;
		    die();

		} 
		     $db->where('currency',$currency_code);
		     $db->where('merchant_id',$secondary_merchant_id);  
		     $cur_res = $db->getOne('alipay_config');
		     $partner_id_alipay = $cur_res['partner_id'];

		    /* validation for otn already exist or not */
		    $db->where("out_order_no",$_POST['out_order_no']);
		    $db->where("transaction_type",$_POST['tran_req_type']);
		    $record_check = $db->get('transaction_alipay');
		    $count = count($record_check);

			if($count >=1){
			$error_otn = array(
			"out_order_no" => $out_order_no,
			"terminal_id" => $terminal_id,
			"transaction_type" => $ttype,
			"error" => 'The given out order no already exist'
			);
			$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
			poslogs($otn_log);
			echo "The given out order no already exist,use new one";
			exit;
			die();
			}

		$auth_code 			= $_POST['auth_code'];  	
		$operation_id		= $_POST['operation_id'];
		$out_order_no		= $_POST['out_order_no'];
		$out_request_no		= $_POST['out_request_no'];
		$terminal_id 		= $terminal_id;
		$method				= $_POST['method'];
		$app_id 			= $_POST['app_id'];
		$version 			= $_POST['version'];
		$timestamp 			= $_POST['timestamp'];
		$transaction_type   = $_POST['tran_req_type'];

		$biz_content='{"out_order_no":"'.$out_order_no.'","out_request_no":"'.$out_request_no.'","auth_code":"'.$auth_code.'","operation_id":"'.$operation_id.'"}';

		$parameter_ins= array(
		"auth_code"			=> $auth_code,
		"operation_id" 		=> $operation_id,
		"out_order_no" 		=> $out_order_no,
		"out_request_no"	=> $out_request_no,
		"input_charset"		=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 		=> $biz_content,
		"terminal_id" 		=> $terminal_id,
		"method" 			=> $method,
		"app_id"			=> $app_id,
		"version" 			=> $version,
		"sign_type" 		=> $alipay_config['sign_type'],
		"timestamp" 		=> $timestamp,
		"format"			=> 'JSON',
		"notify_url" 		=> $alipay_config['notify_url'],
		"transaction_type"	=> $transaction_type,
		"cst_trans_datetime"=> $datetime_ch,
		"trans_datetime" 	=> date('Y-m-d H:i:s'),
		"trans_time" 		=> date('H:i:s'),
		"trans_date" 		=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} elseif ($_POST['Pre_Auth']=="pay" && $_POST['tran_req_type']=="PA3") {

		if($currency_code != $_POST['trans_currency']) { 

		$currency_received = array(
		    "currency" 		=> $_POST['trans_currency'],
		    "out_trade_no" 	=> $_POST['out_trade_no'],
		    "terminal_id" 	=> $terminal_id,
		    "tran_req_type" => $_POST['tran_req_type'],
		);
		    $currency_error = array(
		    "transaction_status" 	=> 'merchant not found',
		    "out_trade_no" 			=> $_POST['out_trade_no'],
		    "terminal_id" 			=> $terminal_id,
		    "tran_req_type"			=> $_POST['tran_req_type'],
		);
		    $currency_status = "Currency Matching log Pre_Auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		   	poslogs($currency_status);

		    $currency_error_encode = json_encode($currency_error);
		    header('Content-Type: application/json');
		    echo $currency_error_encode;
		    exit;
		    die();

		} 
		     $db->where('currency',$currency_code);
		     $db->where('merchant_id',$secondary_merchant_id);  
		     $cur_res = $db->getOne('alipay_config');
		     $partner_id_alipay = $cur_res['partner_id'];
		
		    /* validation for otn already exist or not */
		    $db->where("out_trade_no",$_POST['out_trade_no']);
		    $db->where("transaction_type",$_POST['tran_req_type']);
		    $record_check = $db->get('transaction_alipay');
		    $count = count($record_check);

			if($count >=1){
			$error_otn = array(
			"out_trade_no" => $out_trade_no,
			"terminal_id" => $terminal_id,
			"transaction_type" => $ttype,
			"error" => 'The given out trade no already exist'
			);
			$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
			poslogs($otn_log);
			echo "The given out trade no already exist,use new one";
			exit;
			die();
			}

		$auth_no 			= $_POST['auth_no'];  	
		$out_trade_no 		= $_POST['out_trade_no'];	
		$total_amount		= $_POST['total_amount'];
		$product_code 		= $_POST['product_code'];
		$subject 			= $_POST['subject'];
		$buyer_id 			= $_POST['buyer_id'];
		$seller_id 			= $_POST['seller_id'];
		$auth_confirm_mode 	= $_POST['auth_confirm_mode'];
		$store_id 			= $_POST['store_id'];
		$terminal_id 		= $terminal_id;
		$timeout_express	= $_POST['timeout_express'];
		$trans_currency		= $_POST['trans_currency'];
		$settle_currency	= $_POST['settle_currency'];		
		$sub_merchant		= $_POST['sub_merchant'];
		//$extend_params		= $_POST['WIDextend_params'];
		$method				= $_POST['method'];
		$app_id 			= $_POST['app_id'];
		$version 			= $_POST['version'];
		$timestamp 			= $_POST['timestamp'];
		$transaction_type   = $_POST['tran_req_type'];

		$biz_content='{"auth_no":"'.$auth_no.'","out_trade_no":"'.$out_trade_no.'","subject":"'.$subject.'","total_amount":"'.$total_amount.'","trans_currency":"'.$trans_currency.'","settle_currency":"'.$settle_currency.'","buyer_id":"'.$buyer_id.'","seller_id":"'.$seller_id.'","auth_confirm_mode":"'.$auth_confirm_mode.'","store_id":"'.$store_id.'","terminal_id":"'.$terminal_id.'","timeout_express":"'.$timeout_express.'","sub_merchant":'.$sub_merchant.',"product_code":"'.$product_code.'"}';

		$parameter_ins= array(
		"auth_no"				=> $auth_no,
		"out_trade_no" 			=> $out_trade_no,
		"subject" 				=> $subject,
		"total_amount"			=> $total_amount,
		"trans_currency" 		=> $trans_currency,
		"settle_currency" 		=> $settle_currency,
		"buyer_id" 				=> $buyer_id,
		"seller_id" 			=> $seller_id,
		"auth_confirm_mode" 	=> $auth_confirm_mode,
		"store_id"				=> $store_id,
		"terminal_id" 			=> $terminal_id,
		"timeout_express" 		=> $timeout_express,
		"sub_merchant" 			=> $sub_merchant,
		"product_code" 			=> $product_code,
		"input_charset"			=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 			=> $biz_content,
		"method" 				=> $method,
		"app_id"				=> $app_id,
		"version" 				=> $version,
		"sign_type" 			=> $alipay_config['sign_type'],
		"timestamp" 			=> $timestamp,
		"format"				=> 'JSON',
		"notify_url" 			=> $alipay_config['notify_url'],
		"transaction_type"		=> $transaction_type,
		"cst_trans_datetime" 	=> $datetime_ch,
		"trans_datetime" 		=> date('Y-m-d H:i:s'),
		"trans_time" 			=> date('H:i:s'),
		"trans_date" 			=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} elseif ($_POST['Pre_Auth']=="unfreeze" && $_POST['tran_req_type']=="PA4") {

		if($currency_code != $_POST['trans_currency']){
		$currency_received = array(
		"currency" 		=> $_POST['trans_currency'],
		"out_request_no" 	=> $_POST['out_request_no'],
		"terminal_id" 	=> $terminal_id,
		"tran_req_type" => $_POST['tran_req_type'],
		);
		$currency_error = array(
		"transaction_status" 	=> 'merchant not found',
		"out_request_no" 			=> $_POST['out_request_no'],
		"terminal_id" 			=> $terminal_id,
		"tran_req_type"			=> $_POST['tran_req_type'],
		);
		  $currency_status = "Currency Matching log Pre_Auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		 	poslogs($currency_status);

		$currency_error_encode = json_encode($currency_error);
		header('Content-Type: application/json');
		echo $currency_error_encode;
		exit;
		die();

		} 
		$db->where('currency',$currency_code);
		$db->where('merchant_id',$secondary_merchant_id);  
		$cur_res = $db->getOne('alipay_config');
		$partner_id_alipay = $cur_res['partner_id'];

		/* validation for otn already exist or not */
		$db->where("out_request_no",$_POST['out_request_no']);
		$db->where("transaction_type",$_POST['tran_req_type']);
		$record_check = $db->get('transaction_alipay');
		$count = count($record_check);

		if($count >=1){
		$error_otn = array(
		"out_request_no" => $out_request_no,
		"terminal_id" => $terminal_id,
		"transaction_type" => $ttype,
		"error" => 'The given out_request_no already exist'
		);
		$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
		poslogs($otn_log);
		echo "The given out_request_no already exist,use new one";
		exit;
		die();
		}

		$auth_no 			= $_POST['auth_no'];  	
		$out_request_no		= $_POST['out_request_no'];
		$amount				= $_POST['amount'];
		$remark				= $_POST['remark'];
		$method				= $_POST['method'];
		$terminal_id 		= $terminal_id;
		$app_id 			= $_POST['app_id'];
		$version 			= $_POST['version'];
		$timestamp 			= $_POST['timestamp'];
		$transaction_type   = $_POST['tran_req_type'];

		$biz_content='{"auth_no":"'.$auth_no.'","out_request_no":"'.$out_request_no.'","amount":"'.$amount.'","remark":"'.$remark.'"}';

		$parameter_ins= array(
		"auth_code"			=> $auth_code,
		"out_request_no"	=> $out_request_no,
		"remark" 			=> $remark,
		"product_code" 		=> $product_code,
		"input_charset"		=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 		=> $biz_content,
		"terminal_id"		=> $terminal_id,
		"method" 			=> $method,
		"app_id"			=> $app_id,
		"version" 			=> $version,
		"sign_type" 		=> $alipay_config['sign_type'],
		"timestamp" 		=> $timestamp,
		"format"			=> 'JSON',
		"notify_url" 		=> $alipay_config['notify_url'],
		"transaction_type"	=> $transaction_type,
		"cst_trans_datetime"=> $datetime_ch,
		"trans_datetime" 	=> date('Y-m-d H:i:s'),
		"trans_time" 		=> date('H:i:s'),
		"trans_date" 		=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} elseif ($_POST['Pre_Auth']=="refund" && $_POST['tran_req_type']=="PA5") {

		if($currency_code != $_POST['refund_currency']){
		$currency_received = array(
		"currency" 		=> $_POST['refund_currency'],
		"out_trade_no" 	=> $_POST['out_trade_no'],
		"terminal_id" 	=> $terminal_id,
		"tran_req_type" => $_POST['tran_req_type'],
		);
		$currency_error = array(
		"transaction_status" 	=> 'merchant not found',
		"out_trade_no" 			=> $_POST['out_trade_no'],
		"terminal_id" 			=> $terminal_id,
		"tran_req_type"			=> $_POST['tran_req_type'],
		);
		  $currency_status = "Currency Matching log Pre_Auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		 poslogs($currency_status);

		$currency_error_encode = json_encode($currency_error);
		header('Content-Type: application/json');
		echo $currency_error_encode;
		exit;
		die();

		} 
		$db->where('currency',$currency_code);
		$db->where('merchant_id',$secondary_merchant_id);  
		$cur_res = $db->getOne('alipay_config');
		$partner_id_alipay = $cur_res['partner_id'];

		/* validation for otn already exist or not */
		$db->where("out_trade_no",$_POST['out_trade_no']);
		$db->where("transaction_type",$_POST['tran_req_type']);
		$record_check = $db->get('transaction_alipay');
		$count = count($record_check);

		if($count >=1){
		$error_otn = array(
		"out_trade_no" => $out_trade_no,
		"terminal_id" => $terminal_id,
		"transaction_type" => $ttype,
		"error" => 'The given out trade no already exist'
		);
		$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
		poslogs($otn_log);
		echo "The given out trade no already exist,use new one";
		exit;
		die();
		}

		$out_trade_no 			= $_POST['out_trade_no'];	
		$trade_no				= $_POST['trade_no'];
		$out_request_no 		= $_POST['out_request_no'];
		$refund_amount 			= $_POST['refund_amount'];
		$refund_reason 			= $_POST['refund_reason'];
		$refund_currency 		= $_POST['refund_currency'];
		$operator_id 			= $_POST['operator_id'];
		$store_id 				= $_POST['store_id'];
		$terminal_id 			= $terminal_id;
		$method					= $_POST['method'];
		$app_id 				= $_POST['app_id'];
		$version 				= $_POST['version'];
		$timestamp 				= $_POST['timestamp'];
		$transaction_type   	= $_POST['tran_req_type'];

		$biz_content='{"out_trade_no":"'.$out_trade_no.'","trade_no":"'.$trade_no.'","out_request_no":"'.$out_request_no.'","refund_amount":"'.$refund_amount.'","refund_reason":"'.$refund_reason.'","refund_currency":"'.$refund_currency.'","operator_id":"'.$operator_id.'","auth_confirm_mode":"'.$auth_confirm_mode.'","store_id":"'.$store_id.'","terminal_id":"'.$terminal_id.'"}';

		$parameter_ins= array(
		"out_trade_no" 			=> $out_trade_no,
		"trade_no" 				=> $trade_no,
		"out_request_no"		=> $out_request_no,
		"refund_amount" 		=> $refund_amount,
		"refund_reason" 		=> $refund_reason,
		"refund_currency" 		=> $refund_currency,
		"operator_id" 			=> $operator_id,
		"auth_confirm_mode" 	=> $auth_confirm_mode,
		"store_id"				=> $store_id,
		"terminal_id" 			=> $terminal_id,
		"input_charset"			=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 			=> $biz_content,
		"method" 				=> $method,
		"app_id"				=> $app_id,
		"version" 				=> $version,
		"sign_type" 			=> $alipay_config['sign_type'],
		"timestamp" 			=> $timestamp,
		"format"				=> 'JSON',
		"notify_url" 			=> $alipay_config['notify_url'],
		"transaction_type"		=> $transaction_type,
		"cst_trans_datetime" 	=> $datetime_ch,
		"trans_datetime" 		=> date('Y-m-d H:i:s'),
		"trans_time" 			=> date('H:i:s'),
		"trans_date" 			=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} elseif ($_POST['Pre_Auth']=="cancel" && $_POST['tran_req_type']=="PA6") {

		if($currency_code != $_POST['trans_currency']){
		$currency_received = array(
		"currency" 		=> $_POST['trans_currency'],
		"out_order_no" 	=> $_POST['out_order_no'],
		"terminal_id" 	=> $terminal_id,
		"tran_req_type" => $_POST['tran_req_type'],
		);
		$currency_error = array(
		"transaction_status" 	=> 'merchant not found',
		"out_order_no" 			=> $_POST['out_order_no'],
		"terminal_id" 			=> $terminal_id,
		"tran_req_type"			=> $_POST['tran_req_type'],
		);
		  $currency_status = "Currency Matching log Pre_Auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		 poslogs($currency_status);

		$currency_error_encode = json_encode($currency_error);
		header('Content-Type: application/json');
		echo $currency_error_encode;
		exit;
		die();

		} 
		$db->where('currency',$currency_code);
		$db->where('merchant_id',$secondary_merchant_id);  
		$cur_res = $db->getOne('alipay_config');
		$partner_id_alipay = $cur_res['partner_id'];

		/* validation for otn already exist or not */
		$db->where("out_order_no",$_POST['out_order_no']);
		$db->where("transaction_type",$_POST['tran_req_type']);
		$record_check = $db->get('transaction_alipay');
		$count = count($record_check);

		if($count >=1){
		$error_otn = array(
		"out_order_no" => $out_order_no,
		"terminal_id" => $terminal_id,
		"transaction_type" => $ttype,
		"error" => 'The given out_order_no already exist'
		);
		$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
		poslogs($otn_log);
		echo "The given out_order_no already exist,use new one";
		exit;
		die();
		}


		$auth_code 		= $_POST['auth_code'];  	
		$operation_id	= $_POST['operation_id'];
		$out_order_no	= $_POST['out_order_no'];
		$out_request_no	= $_POST['out_request_no'];
		$remark			= $_POST['remark'];
		$terminal_id 	= $terminal_id;
		$method			= $_POST['method'];
		$app_id 		= $_POST['app_id'];
		$version 		= $_POST['version'];
		$timestamp 		= $_POST['timestamp'];
		$transaction_type   = $_POST['tran_req_type'];

		$biz_content='{"auth_code":"'.$auth_code.'","operation_id":"'.$operation_id.'","out_order_no":"'.$out_order_no.'","out_request_no":"'.$out_request_no.'","remark":"'.$remark.'"}';

		$parameter_ins= array(
		"auth_code"			=> $auth_code,
		"operation_id" 		=> $operation_id,
		"out_order_no" 		=> $out_order_no,
		"out_request_no"	=> $out_request_no,
		"remark" 			=> $remark,
		"input_charset"		=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 		=> $biz_content,
		"terminal_id"		=> $terminal_id,
		"method" 			=> $method,
		"app_id"			=> $app_id,
		"version" 			=> $version,
		"sign_type" 		=> $alipay_config['sign_type'],
		"timestamp" 		=> $timestamp,
		"format"			=> 'JSON',
		"notify_url" 		=> $alipay_config['notify_url'],
		"transaction_type"	=> $transaction_type,
		"cst_trans_datetime"=> $datetime_ch,
		"trans_datetime" 	=> date('Y-m-d H:i:s'),
		"trans_time" 		=> date('H:i:s'),
		"trans_date" 		=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} elseif ($_POST['Pre_Auth']=="payquery" && $_POST['tran_req_type']=="PA7") {

		if($currency_code != $_POST['trans_currency']){
		$currency_received = array(
		"currency" 		=> $_POST['trans_currency'],
		"out_trade_no" 	=> $_POST['out_trade_no'],
		"terminal_id" 	=> $terminal_id,
		"tran_req_type" => $_POST['tran_req_type'],
		);
		$currency_error = array(
		"transaction_status" 	=> 'merchant not found',
		"out_trade_no" 			=> $_POST['out_trade_no'],
		"terminal_id" 			=> $terminal_id,
		"tran_req_type"			=> $_POST['tran_req_type'],
		);
		  $currency_status = "Currency Matching log Pre_Auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		 poslogs($currency_status);

		$currency_error_encode = json_encode($currency_error);
		header('Content-Type: application/json');
		echo $currency_error_encode;
		exit;
		die();

		} 
		$db->where('currency',$currency_code);
		$db->where('merchant_id',$secondary_merchant_id);  
		$cur_res = $db->getOne('alipay_config');
		$partner_id_alipay = $cur_res['partner_id'];

		/* validation for otn already exist or not */
		$db->where("out_trade_no",$_POST['out_trade_no']);
		$db->where("transaction_type",$_POST['tran_req_type']);
		$record_check = $db->get('transaction_alipay');
		$count = count($record_check);

		if($count >=1){
		$error_otn = array(
		"out_trade_no" => $out_trade_no,
		"terminal_id" => $terminal_id,
		"transaction_type" => $ttype,
		"error" => 'The given out trade no already exist'
		);
		$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
		poslogs($otn_log);
		echo "The given out trade no already exist,use new one";
		exit;
		die();
		}

		$out_trade_no	= $_POST['out_trade_no'];
		$trade_no		= $_POST['trade_no'];
		$terminal_id  	= $terminal_id;
		$method			= $_POST['method'];
		$app_id 		= $_POST['app_id'];
		$version 		= $_POST['version'];
		$timestamp 		= $_POST['timestamp'];
		$transaction_type   = $_POST['tran_req_type'];

		$biz_content='{"out_trade_no":"'.$out_trade_no.'","trade_no":"'.$trade_no.'"}';	

		$parameter_ins= array(
		"out_trade_no" 		=> $out_trade_no,
		"trade_no" 			=> $trade_no,
		"input_charset"		=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 		=> $biz_content,
		"terminal_id"		=> $terminal_id,
		"method" 			=> $method,
		"app_id"			=> $app_id,
		"version" 			=> $version,
		"sign_type" 		=> $alipay_config['sign_type'],
		"timestamp" 		=> $timestamp,
		"format"			=> 'JSON',
		"notify_url" 		=> $alipay_config['notify_url'],
		"transaction_type"	=> $transaction_type,
		"cst_trans_datetime"=> $datetime_ch,
		"trans_datetime" 	=> date('Y-m-d H:i:s'),
		"trans_time" 		=> date('H:i:s'),
		"trans_date" 		=> date('Y-m-d')
		);
		//insert Data in Test DB
		$insert_preauth = $db->insert('transaction_alipay', $parameter_ins);

	} else {
	echo "Error:- Data not Post";
	die();
	}

if($biz_content!='') {

	//Common Parameter Value	
	$parameter= array(
		"input_charset"		=> trim(strtoupper($alipay_config['charset'])),
		"biz_content" 		=> $biz_content,
		"method" 			=> $method,
		"app_id"			=> $app_id,
		"version" 			=> $version,
		"sign_type" 		=> $alipay_config['sign_type'],
		"timestamp" 		=> $timestamp,
		"format"			=> 'JSON',
		"notify_url" 		=> $alipay_config['notify_url']
	);	


	$log = "Pre-auth".$_POST['Pre_Auth']."Request Parameter:".date("Y-m-d H:i:s")."=>".$parameter."\n\n";
	poslogs($log);

	//build request
	$private_key_path=$alipay_config['private_key_path'];
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->build_http_query($parameter,$private_key_path);
	//$html_text = $alipaySubmit->buildRequestForm($parameter,"GET", "OK",$private_key_path);

	// $log = " Pre-auth ".$_POST['Pre_Auth']." Request:" .date("Y-m-d H:i:s") . "=>".$html_text."\n\n";
	// poslogs($log);

	$url ="https://openapi.alipaydev.com/gateway.do?".$html_text;
	$log = "Pre-auth".$_POST['Pre_Auth']."Request:".date("Y-m-d H:i:s")."=>".$url."\n\n";
	poslogs($log);

print_r($url);
die();
	//  Initiate curl
	$ch = curl_init();
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Execute
	$result=curl_exec($ch);

	$log = "Pre-auth".$_POST['Pre_Auth']."Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
	poslogs($log);

	// Closing
	curl_close($ch);

	$res = json_decode($result, true);
	echo "<br><br>";
	print_r($res);
}

	if(isset($res['alipay_fund_auth_order_voucher_create_response'])) {
	
		if($res['alipay_fund_auth_order_voucher_create_response']['msg']=="Success") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_fund_auth_order_voucher_create_response']['code'];
		$outputres['msg'] 				= $res['alipay_fund_auth_order_voucher_create_response']['msg'];
		$outputres['code_type'] 		= $res['alipay_fund_auth_order_voucher_create_response']['code_type'];
		$outputres['code_url'] 			= $res['alipay_fund_auth_order_voucher_create_response']['code_url'];
		$outputres['code_value'] 		= $res['alipay_fund_auth_order_voucher_create_response']['code_value'];
		$outputres['out_order_no'] 		= $res['alipay_fund_auth_order_voucher_create_response']['out_order_no'];
		$outputres['out_request_no'] 	= $res['alipay_fund_auth_order_voucher_create_response']['out_request_no'];
		$outputres['sign'] 				= $res['sign'];

		
		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_order_voucher_create_response']['msg'],
		// $outputres['code_type'] 			=> $res['alipay_fund_auth_order_voucher_create_response']['code_type'],
		$outputres['code_url'] 				=> $res['alipay_fund_auth_order_voucher_create_response']['code_url'],
		$outputres['code_value'] 			=> $res['alipay_fund_auth_order_voucher_create_response']['code_value'],
		$outputres['out_order_no']			=> $res['alipay_fund_auth_order_voucher_create_response']['out_order_no'],
		$outputres['out_request_no']		=> $res['alipay_fund_auth_order_voucher_create_response']['out_request_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		$qrImage=$outputres['code_url'];

		$serv_url = $_SERVER['HTTP_HOST'];
		$serv_path = dirname(__FILE__);
		$total_url= $serv_url.$serv_path;
		if (preg_match("/testspaysez/", $total_url)) {
		header( "Refresh:10;url=test.php?user=".$qrImage);
		}
		}

		if($res['alipay_fund_auth_order_voucher_create_response']['msg']=="Business Failed") {
		
		$outputres = [];

		$outputres['code'] 				= $res['alipay_fund_auth_order_voucher_create_response']['code'];
		$outputres['msg'] 				= $res['alipay_fund_auth_order_voucher_create_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_fund_auth_order_voucher_create_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_fund_auth_order_voucher_create_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_order_voucher_create_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_fund_auth_order_voucher_create_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

 	} elseif(isset($res['alipay_fund_auth_operation_detail_query_response'])) {

		if($res['alipay_fund_auth_operation_detail_query_response']['msg']=="Success") {

		$outputres = [];

		$outputres['code'] 					= $res['alipay_fund_auth_operation_detail_query_response']['code'];
		$outputres['msg'] 					= $res['alipay_fund_auth_operation_detail_query_response']['msg'];
		$outputres['amount'] 				= $res['alipay_fund_auth_operation_detail_query_response']['amount'];
		$outputres['auth_no'] 				= $res['alipay_fund_auth_operation_detail_query_response']['auth_no'];
		$outputres['extra_param'] 			= $res['alipay_fund_auth_operation_detail_query_response']['extra_param'];
		$outputres['gmt_create'] 			= $res['alipay_fund_auth_operation_detail_query_response']['gmt_create'];
		$outputres['gmt_trans'] 			= $res['alipay_fund_auth_operation_detail_query_response']['gmt_trans'];
		$outputres['operation_id'] 			= $res['alipay_fund_auth_operation_detail_query_response']['operation_id'];
		$outputres['operation_type']		= $res['alipay_fund_auth_operation_detail_query_response']['operation_type'];
		$outputres['order_title'] 			= $res['alipay_fund_auth_operation_detail_query_response']['order_title'];
		$outputres['out_order_no'] 			= $res['alipay_fund_auth_operation_detail_query_response']['out_order_no'];
		$outputres['out_request_no'] 		= $res['alipay_fund_auth_operation_detail_query_response']['out_request_no'];
		$outputres['payer_logon_id']		= $res['alipay_fund_auth_operation_detail_query_response']['payer_logon_id'];
		$outputres['payer_user_id'] 		= $res['alipay_fund_auth_operation_detail_query_response']['payer_user_id'];
		$outputres['remark'] 				= $res['alipay_fund_auth_operation_detail_query_response']['remark'];
		$outputres['rest_amount'] 			= $res['alipay_fund_auth_operation_detail_query_response']['rest_amount'];
		$outputres['status'] 				= $res['alipay_fund_auth_operation_detail_query_response']['status'];
		$outputres['total_freeze_amount'] 	= $res['alipay_fund_auth_operation_detail_query_response']['total_freeze_amount'];
		$outputres['total_pay_amount'] 		= $res['alipay_fund_auth_operation_detail_query_response']['total_pay_amount'];
		$outputres['trans_currency'] 		= $res['alipay_fund_auth_operation_detail_query_response']['trans_currency'];
		$outputres['sign'] 					= $res['sign'];


		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_operation_detail_query_response']['msg'],
		 $outputres['auth_no'] 				=> $res['alipay_fund_auth_operation_detail_query_response']['auth_no'],
		$outputres['amount'] 				=> $res['alipay_fund_auth_operation_detail_query_response']['amount'],
		$outputres['operation_id'] 			=> $res['alipay_fund_auth_operation_detail_query_response']['operation_id'],
		$outputres['out_order_no']			=> $res['alipay_fund_auth_operation_detail_query_response']['out_order_no'],
		$outputres['out_request_no']		=> $res['alipay_fund_auth_operation_detail_query_response']['out_request_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;
		}

		if($res['alipay_fund_auth_operation_detail_query_response']['msg']=="Business Failed") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_fund_auth_operation_detail_query_response']['code'];
		$outputres['msg'] 				= $res['alipay_fund_auth_operation_detail_query_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_fund_auth_operation_detail_query_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_fund_auth_operation_detail_query_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_operation_detail_query_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_fund_auth_operation_detail_query_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

	} elseif(isset($res['alipay_trade_pay_response'])) {

		if($res['alipay_trade_pay_response']['msg']=="Success") {

		$outputres = [];

		$outputres['code'] 					= $res['alipay_trade_pay_response']['code'];
		$outputres['msg'] 					= $res['alipay_trade_pay_response']['msg'];
		$outputres['buyer_logon_id'] 		= $res['alipay_trade_pay_response']['buyer_logon_id'];
		$outputres['buyer_pay_amount'] 		= $res['alipay_trade_pay_response']['buyer_pay_amount'];
		$outputres['buyer_user_id'] 		= $res['alipay_trade_pay_response']['buyer_user_id'];
		$outputres['buyer_user_type'] 		= $res['alipay_trade_pay_response']['buyer_user_type'];
		$outputres['invoice_amount'] 		= $res['alipay_trade_pay_response']['invoice_amount'];
		$outputres['out_trade_no'] 			= $res['alipay_trade_pay_response']['out_trade_no'];
		$outputres['point_amount']			= $res['alipay_trade_pay_response']['point_amount'];
		$outputres['receipt_amount'] 		= $res['alipay_trade_pay_response']['receipt_amount'];
		$outputres['total_amount'] 			= $res['alipay_trade_pay_response']['total_amount'];
		$outputres['trade_no'] 				= $res['alipay_trade_pay_response']['trade_no'];
		$outputres['sign'] 					= $res['sign'];


		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_trade_no", $out_trade_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_trade_pay_response']['msg'],
		$outputres['buyer_user_id'] 		=> $res['alipay_trade_pay_response']['buyer_user_id'],
		$outputres['total_amount'] 			=> $res['alipay_trade_pay_response']['total_amount'],
		$outputres['buyer_logon_id'] 		=> $res['alipay_trade_pay_response']['buyer_logon_id'],
		$outputres['out_trade_no']			=> $res['alipay_trade_pay_response']['out_trade_no'],
		$outputres['trade_no']				=> $res['alipay_trade_pay_response']['trade_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;
		}


		if($res['alipay_trade_pay_response']['msg']=="Business Failed") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_trade_pay_response']['code'];
		$outputres['msg'] 				= $res['alipay_trade_pay_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_trade_pay_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_trade_pay_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_trade_no", $out_trade_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_trade_pay_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_trade_pay_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

	} elseif(isset($res['alipay_trade_refund_response'])) {

		if($res['alipay_trade_refund_response']['msg']=="Success") {

		$outputres = [];

		$outputres['code'] 					= $res['alipay_trade_refund_response']['code'];
		$outputres['msg'] 					= $res['alipay_trade_refund_response']['msg'];
		$outputres['buyer_logon_id'] 		= $res['alipay_trade_refund_response']['buyer_logon_id'];
		$outputres['buyer_user_id'] 		= $res['alipay_trade_refund_response']['buyer_user_id'];
		$outputres['gmt_refund_pay'] 		= $res['alipay_trade_refund_response']['gmt_refund_pay'];
		$outputres['out_trade_no'] 			= $res['alipay_trade_refund_response']['out_trade_no'];
		$outputres['refund_currency']		= $res['alipay_trade_refund_response']['refund_currency'];
		$outputres['refund_fee'] 			= $res['alipay_trade_refund_response']['refund_fee'];
		$outputres['send_back_fee'] 		= $res['alipay_trade_refund_response']['send_back_fee'];
		$outputres['trade_no'] 				= $res['alipay_trade_refund_response']['trade_no'];
		$outputres['sign'] 					= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_trade_no", $out_trade_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_trade_refund_response']['msg'],
		$outputres['buyer_user_id'] 		=> $res['alipay_trade_refund_response']['buyer_user_id'],
		$outputres['gmt_refund_pay'] 		=> $res['alipay_trade_refund_response']['gmt_refund_pay'],
		$outputres['buyer_logon_id'] 		=> $res['alipay_trade_refund_response']['buyer_logon_id'],
		$outputres['out_trade_no']			=> $res['alipay_trade_refund_response']['out_trade_no'],
		$outputres['trade_no']				=> $res['alipay_trade_refund_response']['trade_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;
		}

		if($res['alipay_trade_refund_response']['msg']=="Business Failed") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_trade_refund_response']['code'];
		$outputres['msg'] 				= $res['alipay_trade_refund_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_trade_refund_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_trade_refund_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_trade_no", $out_trade_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_trade_refund_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_trade_refund_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

	} elseif(isset($res['alipay_fund_auth_order_unfreeze_response'])) {
		
		if($res['alipay_fund_auth_order_unfreeze_response']['msg']=="Success") {

		$outputres = [];

		$outputres['code'] 					= $res['alipay_fund_auth_order_unfreeze_response']['code'];
		$outputres['msg'] 					= $res['alipay_fund_auth_order_unfreeze_response']['msg'];
		$outputres['amount'] 				= $res['alipay_fund_auth_order_unfreeze_response']['amount'];
		$outputres['auth_no'] 				= $res['alipay_fund_auth_order_unfreeze_response']['auth_no'];
		$outputres['gmt_trans'] 			= $res['alipay_fund_auth_order_unfreeze_response']['gmt_trans'];
		$outputres['operation_id'] 			= $res['alipay_fund_auth_order_unfreeze_response']['operation_id'];
		$outputres['out_order_no']			= $res['alipay_fund_auth_order_unfreeze_response']['out_order_no'];
		$outputres['out_request_no'] 		= $res['alipay_fund_auth_order_unfreeze_response']['out_request_no'];
		$outputres['status'] 				= $res['alipay_fund_auth_order_unfreeze_response']['status'];
		$outputres['sign'] 					= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_order_unfreeze_response']['msg'],
		$outputres['auth_no'] 				=> $res['alipay_fund_auth_order_unfreeze_response']['auth_no'],
		$outputres['amount'] 				=> $res['alipay_fund_auth_order_unfreeze_response']['amount'],
		$outputres['operation_id'] 			=> $res['alipay_fund_auth_order_unfreeze_response']['operation_id'],
		$outputres['status'] 				=> $res['alipay_fund_auth_order_unfreeze_response']['status'],
		$outputres['out_order_no']			=> $res['alipay_fund_auth_order_unfreeze_response']['out_order_no'],
		$outputres['out_request_no']		=> $res['alipay_fund_auth_order_unfreeze_response']['out_request_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;
		}

		if($res['alipay_fund_auth_order_unfreeze_response']['msg']=="Business Failed") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_fund_auth_order_unfreeze_response']['code'];
		$outputres['msg'] 				= $res['alipay_fund_auth_order_unfreeze_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_fund_auth_order_unfreeze_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_fund_auth_order_unfreeze_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_order_unfreeze_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_fund_auth_order_unfreeze_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

	} elseif(isset($res['alipay_trade_query_response'])) {

		if($res['alipay_trade_query_response']['msg']=="Success") {
		
		$outputres = [];

		$outputres['code'] 					= $res['alipay_trade_query_response']['code'];
		$outputres['msg'] 					= $res['alipay_trade_query_response']['msg'];
		$outputres['buyer_logon_id'] 		= $res['alipay_trade_query_response']['buyer_logon_id'];
		$outputres['buyer_pay_amount'] 		= $res['alipay_trade_query_response']['buyer_pay_amount'];
		$outputres['buyer_user_id'] 		= $res['alipay_trade_query_response']['buyer_user_id'];
		$outputres['buyer_user_type'] 		= $res['alipay_trade_query_response']['buyer_user_type'];
		$outputres['invoice_amount']		= $res['alipay_trade_query_response']['invoice_amount'];
		$outputres['out_trade_no'] 			= $res['alipay_trade_query_response']['out_trade_no'];
		$outputres['point_amount'] 			= $res['alipay_trade_query_response']['point_amount'];
		$outputres['receipt_amount'] 		= $res['alipay_trade_query_response']['receipt_amount'];
		$outputres['send_pay_date'] 		= $res['alipay_trade_query_response']['send_pay_date'];
		$outputres['total_amount']			= $res['alipay_trade_query_response']['total_amount'];
		$outputres['trade_no'] 				= $res['alipay_trade_query_response']['trade_no'];
		$outputres['trade_status'] 			= $res['alipay_trade_query_response']['trade_status'];
		$outputres['sign'] 					= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_trade_no", $out_trade_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_trade_query_response']['msg'],
		$outputres['buyer_user_id'] 		=> $res['alipay_trade_query_response']['buyer_user_id'],
		$outputres['total_amount'] 			=> $res['alipay_trade_query_response']['total_amount'],
		$outputres['buyer_logon_id'] 		=> $res['alipay_trade_query_response']['buyer_logon_id'],
		$outputres['out_trade_no']			=> $res['alipay_trade_query_response']['out_trade_no'],
		$outputres['trade_no']				=> $res['alipay_trade_query_response']['trade_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;
		}

		if($res['alipay_trade_query_response']['msg']=="Business Failed") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_trade_query_response']['code'];
		$outputres['msg'] 				= $res['alipay_trade_query_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_trade_query_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_trade_query_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_trade_no", $out_trade_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_trade_query_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_trade_query_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

	} elseif(isset($res['alipay_fund_auth_operation_cancel_response'])) {

		if($res['alipay_fund_auth_operation_cancel_response']['msg']=="Success") {		

		$outputres = [];

		$outputres['code'] 					= $res['alipay_fund_auth_operation_cancel_response']['code'];
		$outputres['msg'] 					= $res['alipay_fund_auth_operation_cancel_response']['msg'];
		$outputres['action'] 				= $res['alipay_fund_auth_operation_cancel_response']['action'];
		$outputres['auth_no'] 				= $res['alipay_fund_auth_operation_cancel_response']['auth_no'];
		$outputres['operation_id'] 			= $res['alipay_fund_auth_operation_cancel_response']['operation_id'];
		$outputres['out_order_no'] 			= $res['alipay_fund_auth_operation_cancel_response']['out_order_no'];
		$outputres['out_request_no']		= $res['alipay_fund_auth_operation_cancel_response']['out_request_no'];
		$outputres['sign'] 					= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Success Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);


		$refund_suc_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_operation_cancel_response']['msg'],
		$outputres['auth_no'] 				=> $res['alipay_fund_auth_operation_cancel_response']['auth_no'],
		$outputres['operation_id'] 			=> $res['alipay_fund_auth_operation_cancel_response']['operation_id'],
		$outputres['action'] 				=> $res['alipay_fund_auth_operation_cancel_response']['action'],
		$outputres['out_order_no']			=> $res['alipay_fund_auth_operation_cancel_response']['out_order_no'],
		$outputres['out_request_no']		=> $res['alipay_fund_auth_operation_cancel_response']['out_request_no']
		);
		$refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		poslogs($refund_suc_res_pre_log);

		$refund_encode = json_encode($refund_suc_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;
		}

		if($res['alipay_fund_auth_operation_cancel_response']['msg']=="Business Failed") {

		$outputres = [];

		$outputres['code'] 				= $res['alipay_fund_auth_operation_cancel_response']['code'];
		$outputres['msg'] 				= $res['alipay_fund_auth_operation_cancel_response']['msg'];
		$outputres['sub_code'] 			= $res['alipay_fund_auth_operation_cancel_response']['sub_code'];
		$outputres['sub_msg'] 			= $res['alipay_fund_auth_operation_cancel_response']['sub_msg'];
		$outputres['sign'] 				= $res['sign'];

		$log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		poslogs($log);

		$db->where("out_order_no", $out_order_no);
		$db->where("transaction_type",$transaction_type);
		$trans_update = $db->update('transaction_alipay', $outputres);

		$refund_fail_res_pre = array(
		$outputres['msg']					=> $res['alipay_fund_auth_operation_cancel_response']['msg'],
		$outputres['sub_code']				=> $res['alipay_fund_auth_operation_cancel_response']['sub_code']
		);
		$refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		poslogs($refund_fail_res_pre_log);

		$refund_encode = json_encode($refund_fail_res_pre);
		header('Content-Type: application/json');
		echo $refund_encode;

		}

	} else {
		echo "Data not Post Error";
		die();
	}

?>

</body>
</html>
