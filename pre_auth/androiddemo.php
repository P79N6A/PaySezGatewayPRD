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

//Post Data

$terminal_id=$_POST['terminal_id'];
$amount=$_POST['amount'];
$tran_req_type=$_POST['tran_req_type'];

//build in Data

$trans_currency="USD";
$settle_currency="USD";
$out_order_no="PO20190227180318";
$out_request_no="PR20190227180318";
$order_title="PreAuth Scanning Test0001";
$extra_param='{"secondaryMerchantId":"MerchantDavidTest01","outStoreCode":"StoreDavidTest01"}';
$product_code="OVERSEAS_INSTORE_AUTH";
$method="alipay.fund.auth.order.voucher.create";
$app_id="2018060601228996";
$version="1.0";
$timestamp="2019-02-27 18:05:05";
// echo $terminal_id;
// echo "\n";
// echo $amount;
// echo "\n";
// echo $tran_req_type;

if($terminal_id!="") {

	 $db->where("mso_terminal_id",$terminal_id);
	 $terminal_res = $db->getOne("terminal");
	 $terminalIdds = $terminal_res['mso_terminal_id'];
	 $terminal_active = $terminal_res['active']; 

// echo $terminal_id;
// echo "\n";
// echo $amount;
// echo "\n";
// echo $tran_req_type;
// echo "\n";
//print_r($terminal_active);

	 	if($terminalIdds != "" && $terminal_active == 1) {
	 		$merchant_id  = $terminal_res['idmerchants'];
	 		$mso_location = $terminal_res['mso_ter_location'];

	 	} else if($terminalIdds != "" && $terminal_active != 1) {
	  		$terminal_active_sts = "Pre_auth Terminal Acive Log:".date("Y-m-d H:i:s") . " Terminal Not Active Id:" .json_encode($ter_act). " \n\n";
	 		//poslogs($terminal_active_sts);
	 echo 'Terminal Id Not Active';
	 die();

	 	} else {
			$terminal_id_empty = "Pre_auth terminal Id wrong Log:".date("Y-m-d H:i:s") . " Received wrong terminal From pos:" .$terminal_wrong. " \n\n";
		 	//poslogs($terminal_id_empty);
		echo 'Terminal Id Wrong';
		die();

		}

	} else {
	 	$terminal_id_empty = "Pre_auth terminal check Log:".date("Y-m-d H:i:s") . " Received empty terminal From pos:" .$terminal_empty. " \n\n";
	 	//poslogs($terminal_id_empty);
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

if ($tran_req_type=="PA1") {

		if($currency_code != $trans_currency) { 

		$currency_received = array(
		    "currency" 		=> $trans_currency,
		    "out_order_no" 	=> $out_order_no,
		    "terminal_id" 	=> $terminal_id,
		    "tran_req_type" => $tran_req_type,
		);
		    $currency_error = array(
		    "transaction_status" 	=> 'merchant not found',
		    "out_order_no" 			=> $out_order_no,
		    "terminal_id" 			=> $terminal_id,
		    "tran_req_type"			=> $tran_req_type,
		);
		    $currency_status = "Currency Matching log pre_auth:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
		    //poslogs($currency_status);

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
		    $db->where("out_order_no",$out_order_no);
		    $db->where("transaction_type",$tran_req_type);
		    $record_check = $db->get('transaction_alipay');
		    $count = count($record_check);

			if($count >=1){
			$error_otn = array(
			"out_order_no" => $out_order_no,
			"terminal_id" => $terminal_id,
			"transaction_type" => $tran_req_type,
			"error" => 'The given out order no already exist'
			);
			$otn_log = "Application Log for Already OTN exist Pre_Auth:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
			//poslogs($otn_log);
			echo "The given out order no already exist,use new one";
			exit;
			die();
			}

		$out_order_no 		= $out_order_no;	
		$out_request_no		= $out_request_no;
		$order_title		= $order_title;
		$amount				= $amount;
		$trans_currency		= $trans_currency;
		$settle_currency	= $settle_currency;		
		$extra_param		= $extra_param;
		$product_code 		= $product_code;
		$terminal_id 		= $terminal_id;
		$method				= $method;
		$app_id 			= $app_id;
		$version 			= $version;
		$timestamp 			= $timestamp;
		$transaction_type   = $tran_req_type;

		$biz_content='{"out_order_no":"'.$out_order_no.'","out_request_no":"'.$out_request_no.'","order_title":"'.$order_title.'","amount":"'.$amount.'","trans_currency":"'.$trans_currency.'","settle_currency":"'.$settle_currency.'","extra_param":'.$extra_param.',"product_code":"'.$product_code.'"}';

//echo $terminal_id;
//echo "<br>";
//echo $secondary_merchant_id;
//echo $store_id;
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
	//poslogs($log);

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
	//poslogs($log);

	// Closing
	curl_close($ch);

	$res = json_decode($result, true);
	echo "<br><br>";
	print_r($res);
	//die();
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
		//poslogs($log);

	//	$db->where("out_order_no", $out_order_no);
	//	$db->where("transaction_type",$transaction_type);
	//	$trans_update = $db->update('transaction_alipay', $outputres);


		// $refund_suc_res_pre = array(
		// $outputres['msg']					=> $res['alipay_fund_auth_order_voucher_create_response']['msg'],
		// // $outputres['code_type'] 			=> $res['alipay_fund_auth_order_voucher_create_response']['code_type'],
		// $outputres['code_url'] 				=> $res['alipay_fund_auth_order_voucher_create_response']['code_url'],
		// $outputres['code_value'] 			=> $res['alipay_fund_auth_order_voucher_create_response']['code_value'],
		// $outputres['out_order_no']			=> $res['alipay_fund_auth_order_voucher_create_response']['out_order_no'],
		// $outputres['out_request_no']		=> $res['alipay_fund_auth_order_voucher_create_response']['out_request_no']
		// );
		// $refund_suc_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_suc_res_pre) . " \n\n";
		//poslogs($refund_suc_res_pre_log);

	//	$refund_encode = json_encode($refund_suc_res_pre);
	//	header('Content-Type: application/json');
	//	echo $refund_encode;

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

		// $log = "Pre-auth".$_POST['Pre_Auth']."Fail Response:".date("Y-m-d H:i:s")."=>".$result."\n\n";
		// //poslogs($log);

		// $db->where("out_order_no", $out_order_no);
		// $db->where("transaction_type",$transaction_type);
		// $trans_update = $db->update('transaction_alipay', $outputres);

		// $refund_fail_res_pre = array(
		// $outputres['msg']					=> $res['alipay_fund_auth_order_voucher_create_response']['msg'],
		// $outputres['sub_code']				=> $res['alipay_fund_auth_order_voucher_create_response']['sub_code']
		// );
		// $refund_fail_res_pre_log = "Application Log Pre_auth:".date("Y-m-d H:i:s") . " Refund response send to pre_auth:" . json_encode($refund_fail_res_pre) . " \n\n";
		// //poslogs($refund_fail_res_pre_log);

		// $refund_encode = json_encode($refund_fail_res_pre);
		// header('Content-Type: application/json');
		// echo $refund_encode;

		}

 	} 


?>
