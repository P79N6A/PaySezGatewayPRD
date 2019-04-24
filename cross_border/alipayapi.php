<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Success -->
<div id ="success_msg"class="container" style='display:none'>
  <h2><center>Response Message:</center></h2>
  <div class="alert alert-success">
    <strong>SUCCESS!</strong> 
  </div>
</div>
<!--FAIL -->
<div id ="fail_msg"class="container" style='display:none'>
  <h2><center>Response Message:</center></h2>
  <div class="alert alert-danger">
    <strong>FAILURE!</strong>
  </div>
</div>
<!-- WAIT  BUYER -->
<div id ="wait_msg"class="container" style='display:none'>
  <h2><center>Response Message:</center></h2>
  <div class="alert alert-danger">
    <strong>WAIT BUYER PAY!</strong>
  </div>
</div>
<!-- TRADE CLOSED -->
<div id ="trade_closed"class="container" style='display:none'>
  <h2><center>Response Message:</center></h2>
  <div class="alert alert-danger">
    <strong>TRADE CLOSED!</strong>
  </div>
</div>

<?php

//session start
session_start();

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

//Default time zone set
date_default_timezone_set('Asia/Kolkata');

require_once("alipay.config.php");
//require_once("lib/alipay_submit.class.php");
require_once("MD5HtmlBuildSubmit.php");

$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

/*MD5 class definition */
$HtmlBuild_Submit = new MD5HtmlBuildSubmit();

/* Log path declare by variable use in function poslogs */
$log_path = $alipay_config['log-path'];

/** Log File Function starts **/
function poslogs($log) {
   GLOBAL $log_path;
$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}
/**  Log File Function Ends **/

/** china time call in function **/
function conversionfrom_indiatochinatime($datetime) {
    $given_cncl = new DateTime($datetime);
    $given_cncl->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
    $updated_datetime_cncl = $given_cncl->format("Y-m-d H:i:s");
    return $updated_datetime_cncl;
}


//config variable decalred here as new variable
$service = $alipay_config['service'];
$service_refund = $alipay_config['service_re'];
$service_query = $alipay_config['service_qry'];
$partner =  $alipay_config['partner'];
$notify_url = $alipay_config['notify_url'];
$return_url = $alipay_config['return_url'];
$input_charset = $alipay_config['input_charset'];
$req_url = $alipay_config['alipay_url'];

//request type
$ncb_request = $_POST['tran_req_type'];

//merchant order no,the unique transaction ID specified in merchant system ,not null
$out_trade_no = $_POST['WIDout_trade_no'];

//order name  ,not null
$subject = $_POST['WIDsubject'];

//The settlement currency code the merchant specifies in the contract. ,not null 
$currency = $_POST['currency'];

//payment amount in foreign currency ,not null
$total_fee = $_POST['amount'];

//product description ,nullable
$body = $_POST['WIDbody'];

//product_code
$product_code = $_POST['WIDproduct_code'];

//return amount
$return_amount = $_POST['refund_amount'];

//out return no
$out_return_no = $_POST['out_return_no'];

//trade no
$trade_no = $_POST['trade_no'];

//merchant_id 
$merchant_id = $_POST['merchant_id'];

//payment type
$payment_type = 'wap';

//************************************************************/
if($merchant_id != ''){
$db->where('mer_map_id',$merchant_id);
$merchant_details = $db->getOne("merchants");
$secondary_merchant_name_init = preg_replace('!\s+!', ' ',$merchant_details['merchant_name']);
$secondary_merchant_name = str_replace(' ','_',$secondary_merchant_name_init);
$secondary_merchant_id = $merchant_details['mer_map_id'];
$secondary_merchant_industry = $merchant_details['mcc'];
$currency_code = $merchant_details['currency_code'];

$pcrq = $merchant_details['pcrq'];
$str = explode("~",$pcrq);

$extend_param = '{"secondary_merchant_name":"'.$secondary_merchant_name.'","secondary_merchant_id":"'.$secondary_merchant_id.'","secondary_merchant_industry":"'.$secondary_merchant_industry.'"}';
}else{
  $merchant_empty = "Merchant Id Empty log POS:".date("Y-m-d H:i:s") . " Received Empty Merchant Id Log:" .json_encode($currency_received). " \n\n";
  poslogs($currency_status);
  echo 'Merchant id not given';
  exit;
  die();
}

$_SESSION['sign'] = 'e7b8kwrnnky977fef6rmxypqzpr48xxz';
   
  switch ($ncb_request) {
  case "cb1":
/* Merchant payment access Permission starts here */
        
if($str[0] == 1){  
$datetime = date('Y-m-d H:i:s');
$datetime_ch = conversionfrom_indiatochinatime($datetime);
  //Currecny matching with merchant id
if($currency_code != $currency){
        $currency_received = array(
        "currency" => $currency,
        "out_trade_no" => $out_trade_no,
        "ncb_request_type" => $ncb_request
       );
        $currency_error = array(
        "transaction_status" => 'merchant not found',
        "out_trade_no" => $out_trade_no,
        "ncb_request_type" => $ncb_request
        );
        $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
        poslogs($currency_status);
        echo 'currency not matched';
        exit;
        die();

 }
  //package the request parameters
  $parameter_ins = array(
  "extend_params" => $extend_param,
  "merchant_id" => $secondary_merchant_id,
  "service" => $service,
  "partner" => $partner,
  "notify_url" => $notify_url,
  "return_url" => $return_url,
  "out_trade_no" => $out_trade_no,
  "cst_trans_datetime" => $datetime_ch,
  "subject" => $subject,
  "total_fee" => $total_fee,
  "currency" => $currency,
  "product_code" => $product_code,  
  "input_charset" => trim(strtolower($input_charset)),
  "transaction_type" => $ncb_request,
  "payment_type" => $payment_type,
  "trans_datetime" => date('Y-m-d H:i:s'),
  "trans_time" => date('H:i:s'),
  "trans_date" => date('Y-m-d')
  );

  $parameter = array(
  "service" => $service,
  "partner" => $partner,
  "notify_url" => $notify_url,
  "return_url" => $return_url,
  "out_trade_no" => $out_trade_no,
  "subject" => $subject,
  "total_fee" => $total_fee,
  "currency" => $currency,
  "product_code" => $product_code,  
  "_input_charset" => trim(strtolower($input_charset))
  );

  /* Inserting payment request data into Transaction table */
  $log = "Application Log CBP:".date("Y-m-d H:i:s") . " Payment Request Data Insert in Table:" . json_encode($parameter_ins) . " \n\n";
  poslogs($log);

  $insert_parameter = $db->insert('transaction_alipay', $parameter_ins);

  $log = "Application Log CBP:".date("Y-m-d H:i:s") . " Payment Request Data Before Build:" . json_encode($parameter) . " \n\n";
  poslogs($log);

  //build request

  /* MD5 class parameter passing to function*/ 
  $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

  $log = "Application Log CBP:".date("Y-m-d H:i:s") . " Build Data :" . $html_text. " \n\n";
  poslogs($log);

  $url = $req_url . $html_text ;

  $log2 = "Application Log CBP:".date("Y-m-d H:i:s") . " Build Data send to Alipay with URL:" . $url. " \n\n";
  poslogs($log2);
  header('location:'.$url);
  break;
   }else{
        $acs = $str[0];
        $access_den = array(
            'merchant_id' => $merchant_id,
            'out_trade_no' => $out_trade_no,
            'pay_access' => $acs
        );
        $mer_access_permsn = "Pay Access Log CBP:".date("Y-m-d H:i:s") . " Pay Access not allowed:" .json_encode($access_den). " \n\n";
        poslogs($mer_access_permsn);

        echo 'permission denied to pay request for this merchant';
    }
    exit;

  case "cb2": 
    if($str[2] == 1){
      $datetime = date('Y-m-d H:i:s');
      $datetime_ch = conversionfrom_indiatochinatime($datetime);

      if($currency_code != $currency){
        $currency_received = array(
        "currency" => $currency,
        "out_trade_no" => $out_trade_no,
        "ncb_request_type" => $ncb_request
        );
        $currency_error = array(
        "transaction_status" => 'merchant not found',
        "out_trade_no" => $out_trade_no,
        "ncb_request_type" => $ncb_request
        );
        $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
        poslogs($currency_status);
        echo 'currency not matched';
        exit;
        die();
      }
  //package the refund parameters
  $parameter_ins = array(
  "extend_params" => $extend_param,
  "merchant_id" => $secondary_merchant_id,
  "service" => $service_refund,
  "notify_url" => $notify_url,
  "partner" => $partner,
  "out_trade_no" => $out_trade_no,
  "cst_trans_datetime" => $datetime_ch,
  "out_return_no" => $out_return_no,
  "refund_reason" => 'out of supply',
  "refund_amount" => $return_amount,
  "currency" => $currency,
  "product_code" => $product_code,
  "input_charset" => trim(strtolower($input_charset)),
  "transaction_type" => $ncb_request,
  "payment_type" => $payment_type,
  "trans_datetime" => date('Y-m-d H:i:s'),
  "trans_time" => date('H:i:s'),
  "trans_date" => date('Y-m-d')
  );

  $parameter_refund = array(
  "service" => $service_refund,
  "notify_url" => $notify_url,
  "partner" => $partner,
  "out_trade_no" => $out_trade_no,
  "out_return_no" => $out_return_no,
  "reason" => 'out of supply',
  "return_amount" => $return_amount,
  "currency" => $currency,
  "product_code" => $product_code,
  "_input_charset" => trim(strtolower($input_charset))
  );

  /* Inserting refund request data into Transaction table */
  $log = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund Request Data Insert in Table:" . json_encode($parameter_ins) . " \n\n";
  poslogs($log);

  $insert_parameter = $db->insert('transaction_alipay', $parameter_ins);

  $refund_data = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund Request Data Before Build:" . json_encode($parameter_refund) . " \n\n";
  poslogs($refund_data);

  //build request

  /* MD5 class parameter passing to function*/ 
  $html_text = $HtmlBuild_Submit->buildMD5Data($parameter_refund);

  $refund_build_data = "Application Log CBP:".date("Y-m-d H:i:s") . " Build Data :" . $html_text. " \n\n";
  poslogs($refund_build_data);

  $url = $req_url . $html_text ;

  $refund_build_data_send = "Application Log CBP:".date("Y-m-d H:i:s") . " Build Data Send URL :" . $url. " \n\n";
  poslogs($refund_build_data_send);

  // $refund_data_send = "Application Log POS:".date("Y-m-d H:i:s") . " Build Data send to Alipay with URL:" . $url. " \n\n";
  //  poslogs($refund_data_send);
  //  header('location:'.$url);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output = curl_exec($ch);

  /* Refund response log */

  if(curl_errno($ch)) {
  $log ="Application Log CBP:".date("Y-m-d H:i:s") . " Refund Response CBP:".curl_errno($ch) . " \n\n";
  poslogs($log);
  } else {
  $log ="Application Log CBP:".date("Y-m-d H:i:s") . " Refund Response CBP:" . $server_output . " \n\n";
  poslogs($log);
  }

  $error = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
  $is_success = $HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
  if($is_success == 'T'){
            $refund_resp_data = array(
            "is_success" => $is_success
            );

            $refund_succ_res_upd = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund success response update in table:" . json_encode($refund_resp_data) . " \n\n";
            poslogs($refund_succ_res_upd);

            /* Response details update in refund inserted row */

            $db->where("out_trade_no",$out_trade_no);
            $db->where("transaction_type",'cb2');
            $db->where("payment_type",$payment_type);
            $refund_success_update = $db->update('transaction_alipay', $refund_resp_data);
            //echo 'REFUND SUCCESS';exit;
            if($is_success == 'T'){?>
            <script type="text/javascript">$('#success_msg').show()</script>
            <?php 
          }
           header( "Refresh:3;url=https://paymentgateway.test.credopay.in/shop/index.php");
              exit;
  } else{
            $refund_resp_data = array(
           "is_success" => $is_success,
           "error" => $error
            );

            $refund_fail_res_upd = "Application Log CBP:".date("Y-m-d H:i:s") . " Refund fail response update in table:" . json_encode($refund_resp_data) . " \n\n";
            poslogs($refund_fail_res_upd);

            /* Response details update in refund inserted row */

            $db->where("out_trade_no",$out_trade_no);
            $db->where("transaction_type",'cb2');
            $db->where("payment_type",$payment_type);
            $refund_fail_update = $db->update('transaction_alipay', $refund_resp_data);
            //echo 'REFUND FAIL';exit;
            if($is_success == 'F'){?>
            <script type="text/javascript">$('#fail_msg').show()</script>
            <?php 
          }
           header( "Refresh:3;url=https://paymentgateway.test.credopay.in/shop/index.php");
           exit;
  }
  break;
  }else{
        /* refund not allowed to merchant*/
        $acs = $str[2];
        $access_den = array(
            'merchant_id' => $merchant_id,
            'out_trade_no' => $out_trade_no,
            'refund_access' => $acs
        );
        $mer_access_permsn = "Refund Access Log CBP:".date("Y-m-d H:i:s") . " Refund Not Allowed Log:" .json_encode($access_den). " \n\n";
        poslogs($mer_access_permsn);

        echo 'Refund denied to this merchant';
    }
exit;
  case "cb3":
        if($str[3] == 1){
        $datetime = date('Y-m-d H:i:s');
        $datetime_ch = conversionfrom_indiatochinatime($datetime);
        
        $db->where("out_trade_no",$out_trade_no);
        $currency_get = $db->getOne('transaction_alipay');
        $currency = $currency_get['currency'];

        // $qry_time_ind = date('Y-m-d H:i:s');
        // $given_qry = new DateTime($qry_time_ind);
        // $given_qry->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
        // $updated_datetime_qry = $given_qry->format("Y-m-d H:i:s");

        /* Currency Match with merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "out_trade_no" => $out_trade_no,
                "ncb_request_type" => $ncb_request
            );

            $currency_error = array(
            "transaction_status" => 'merchant not found',
            "out_trade_no" => $out_trade_no,
            "ncb_request_type" => $ncb_request
            );

            $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
            poslogs($currency_status);

            echo 'currency not matched';
            // $currency_error_encode = json_encode($currency_error);
            // header('Content-Type: application/json');
            // echo $currency_error_encode;
            exit;
            die();

         } 
  $parameter_ins = array(
  "extend_params" => $extend_param,
  "currency" => $currency,
  "merchant_id" => $secondary_merchant_id,
  "service" => $service_query,
  "partner" => $partner,
  "out_trade_no" => $out_trade_no,
  "cst_trans_datetime" => $datetime_ch,
  "input_charset" => trim(strtolower($input_charset)),
  "transaction_type" => $ncb_request,
  "trans_datetime" => date('Y-m-d H:i:s'),
  "trans_time" => date('H:i:s'),
  "trans_date" => date('Y-m-d')
  );

  $parameter_query = array(
  "service" => $service_query,
  "partner" => $partner,
  "out_trade_no" => $out_trade_no,
  "_input_charset" => trim(strtolower($input_charset))
  );

  /* Inserting query request data into Transaction table */
  $log = "Application Log CBP:".date("Y-m-d H:i:s") . " Query Request Data Insert in Table:" . json_encode($parameter_ins) . " \n\n";
  poslogs($log);

  $insert_parameter = $db->insert('transaction_alipay', $parameter_ins);

  $query_data = "Application Log CBP:".date("Y-m-d H:i:s") . " Query Request Data Before Build:" . json_encode($parameter_query) . " \n\n";
  poslogs($query_data);

  //build request

  /* MD5 class parameter passing to function*/ 
  $html_text = $HtmlBuild_Submit->buildMD5Data($parameter_query);

  $query_build_data = "Application Log CBP:".date("Y-m-d H:i:s") . " Build Data :" . $html_text. " \n\n";
  poslogs($query_build_data);

  $url = $req_url . $html_text ;

  $query_build_data_send = "Application Log CBP:".date("Y-m-d H:i:s") . " Build Data Send URL :" . $url. " \n\n";
  poslogs($query_build_data_send);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output = curl_exec($ch);

  /* Query response log */

  if(curl_errno($ch)) {
  $log ="Application Log CBP:".date("Y-m-d H:i:s") . " Query Response CBP:".curl_errno($ch) . " \n\n";
  poslogs($log);
  } else {
  $log ="Application Log CBP:".date("Y-m-d H:i:s") . " Query Response CBP:" . $server_output . " \n\n";
  poslogs($log);
  }

  $body = $HtmlBuild_Submit->get_from_tag($server_output, '<body>', '</body>');
  $additional_trade_status = $HtmlBuild_Submit->get_from_tag($server_output, '<additional_trade_status>', '</additional_trade_status>');
  $buyer_email = $HtmlBuild_Submit->get_from_tag($server_output, '<buyer_email>', '</buyer_email>');
  $buyer_id = $HtmlBuild_Submit->get_from_tag($server_output, '<buyer_id>', '</buyer_id>');
  $discount= $HtmlBuild_Submit->get_from_tag($server_output, '<discount>', '</discount>');
  $flag_trade_locked = $HtmlBuild_Submit->get_from_tag($server_output, '<flag_trade_locked>', '</flag_trade_locked>');
  $gmt_close = $HtmlBuild_Submit->get_from_tag($server_output, '<gmt_close>', '</gmt_close>');
  $gmt_create = $HtmlBuild_Submit->get_from_tag($server_output, '<gmt_create>', '</gmt_create>');
  $gmt_last_modified_time = $HtmlBuild_Submit->get_from_tag($server_output, '<gmt_last_modified_time>', '</gmt_last_modified_time>');
  $gmt_payment = $HtmlBuild_Submit->get_from_tag($server_output, '<gmt_payment>', '</gmt_payment>');
  $is_total_fee_adjust = $HtmlBuild_Submit->get_from_tag($server_output, '<is_total_fee_adjust>', '</is_total_fee_adjust>');
  $operator_role = $HtmlBuild_Submit->get_from_tag($server_output, '<operator_role>', '</operator_role>');
  $out_trade_no = $HtmlBuild_Submit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
  $payment_type_query = $HtmlBuild_Submit->get_from_tag($server_output, '<payment_type>', '</payment_type>');
  $price = $HtmlBuild_Submit->get_from_tag($server_output, '<price>', '</price>');
  $quantity= $HtmlBuild_Submit->get_from_tag($server_output, '<quantity>', '</quantity>');
  $seller_email = $HtmlBuild_Submit->get_from_tag($server_output, '<seller_email>', '</seller_email>');
  $seller_id = $HtmlBuild_Submit->get_from_tag($server_output, '<seller_id>', '</seller_id>');
  $subject = $HtmlBuild_Submit->get_from_tag($server_output, '<subject>', '</subject>');
  $time_out = $HtmlBuild_Submit->get_from_tag($server_output, '<time_out>', '</time_out>');
  $time_out_type = $HtmlBuild_Submit->get_from_tag($server_output, '<time_out_type>', '</time_out_type>');
  $to_buyer_fee = $HtmlBuild_Submit->get_from_tag($server_output, '<to_buyer_fee>', '</to_buyer_fee>');
  $to_seller_fee = $HtmlBuild_Submit->get_from_tag($server_output, '<to_seller_fee>', '</to_seller_fee>');
  $total_fee = $HtmlBuild_Submit->get_from_tag($server_output, '<total_fee>', '</total_fee>');
  $trade_no = $HtmlBuild_Submit->get_from_tag($server_output, '<trade_no>', '</trade_no>');
  $trade_status = $HtmlBuild_Submit->get_from_tag($server_output, '<trade_status>', '</trade_status>');
  $use_coupon = $HtmlBuild_Submit->get_from_tag($server_output, '<use_coupon>', '</use_coupon>');
  $res_sign = $HtmlBuild_Submit->get_from_tag($server_output, '<sign>', '</sign>');
  $res_sign_type = $HtmlBuild_Submit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
  $is_success = $HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
  $error = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');

  if($trade_status == 'TRADE_FINISHED'){
        $query_res_data = array(
        "body" => $body,
        "buyer_email" => $buyer_email,
        "buyer_id" => $buyer_id,
        "m_discount_forex_amount" => $discount,
        "flag_trade_locked" => $flag_trade_locked,
        "gmt_create" => $gmt_create,
        "gmt_last_modified_time" => $gmt_last_modified_time,
        "gmt_payment" => $gmt_payment,
        "is_total_fee_adjust" => $is_total_fee_adjust,
        "operator_role" => $operator_role,
        "out_trade_no" => $out_trade_no,
        "payment_type" => $payment_type_query,
        "price" => $price,
        "quantity" => $quantity,
        "res_seller_email" => $seller_email,
        "res_seller_id" => $seller_id,
        "subject" => $subject,
        "to_buyer_fee" => $to_buyer_fee,
        "to_seller_fee" => $to_seller_fee,
        "total_fee" => $total_fee,
        "trade_no" => $trade_no,
        "trade_status" => $trade_status,
        "use_coupon" => $use_coupon,
        "res_sign" => $res_sign,
        "res_sign_type" => $res_sign_type,
        "is_success" => $is_success,
        "result_code" => 'SUCCESS'
        );

        $query_response = "Application Log CBP:".date("Y-m-d H:i:s") . " Query Success Response Update in Table:" . json_encode($query_res_data) . " \n\n";
        poslogs($query_response);

        /*Updating query success response in transaction stable */

        $db->where("out_trade_no",$out_trade_no);
        $db->where("transaction_type",'cb3');
        $query_update = $db->update('transaction_alipay',$query_res_data);
        
        //echo 'Query Success';exit;
        if($trade_status == 'TRADE_FINISHED'){?>
        <script type="text/javascript">$('#success_msg').show()</script>
        <?php 
      }
      header( "Refresh:3;url=https://paymentgateway.test.credopay.in/shop/index.php");
      exit;
  }else if($trade_status == 'WAIT_BUYER_PAY'){
                $query_res_data = array(
                "buyer_email" => $buyer_email,
                "buyer_id" => $buyer_id,
                "m_discount_forex_amount" => $discount,
                "flag_trade_locked" => $flag_trade_locked,
                "gmt_create" => $gmt_create,
                "gmt_last_modified_time" => $gmt_last_modified_time,
                "is_total_fee_adjust" => $is_total_fee_adjust,
                "operator_role" => $operator_role,
                "out_trade_no" => $out_trade_no,
                "payment_type" => $payment_type_query,
                "price" => $price,
                "quantity" => $quantity,
                "res_seller_email" => $seller_email,
                "res_seller_id" => $seller_id,
                "subject" => $subject,
                "time_out" => $time_out,
                "time_out_type" => $time_out_type,
                "to_buyer_fee" => $to_buyer_fee,
                "to_seller_fee" => $to_seller_fee,
                "total_fee" => $total_fee,
                "trade_no" => $trade_no,
                "trade_status" => $trade_status,
                "use_coupon" => $use_coupon,
                "res_sign" => $res_sign,
                "res_sign_type" => $res_sign_type,
                "is_success" => $is_success,
                "result_code" => 'WAIT_BUYER_PAY'
                );

                $query_response = "Application Log CBP:".date("Y-m-d H:i:s") . " Query Wait Buyer Response Update in Table:" . json_encode($query_res_data) . " \n\n";
                poslogs($query_response);

                /*Updating query wait response in transaction stable */

                $db->where("out_trade_no",$out_trade_no);
                $db->where("transaction_type",'cb3');
                $query_update = $db->update('transaction_alipay',$query_res_data);

                // echo 'Query- Waiting for buyer to pay';
                // exit;
                if($trade_status == 'WAIT_BUYER_PAY'){?>
                <script type="text/javascript">$('#wait_msg').show()</script>
                <?php }
                header( "Refresh:3;url=https://paymentgateway.test.credopay.in/shop/index.php");
                exit;

  }else if($trade_status == 'TRADE_CLOSED'){
                $query_res_data = array(
                "additional_trade_status" => $additional_trade_status,
                "buyer_email" => $buyer_email,
                "buyer_id" => $buyer_id,
                "m_discount_forex_amount" => $discount,
                "flag_trade_locked" => $flag_trade_locked,
                "gmt_close" => $gmt_close,
                "gmt_create" => $gmt_create,
                "gmt_last_modified_time" => $gmt_last_modified_time,
                "is_total_fee_adjust" => $is_total_fee_adjust,
                "operator_role" => $operator_role,
                "out_trade_no" => $out_trade_no,
                "payment_type" => $payment_type_query,
                "price" => $price,
                "quantity" => $quantity,
                "res_seller_email" => $seller_email,
                "res_seller_id" => $seller_id,
                "subject" => $subject,
                "to_buyer_fee" => $to_buyer_fee,
                "to_seller_fee" => $to_seller_fee,
                "total_fee" => $total_fee,
                "trade_no" => $trade_no,
                "trade_status" => $trade_status,
                "use_coupon" => $use_coupon,
                "res_sign" => $res_sign,
                "res_sign_type" => $res_sign_type,
                "is_success" => $is_success,
                "result_code" => 'TRADE_CLOSED'
                );

                $query_response = "Application Log CBP:".date("Y-m-d H:i:s") . " Query Trade Closed Response Update in Table:" . json_encode($query_res_data) . " \n\n";
                poslogs($query_response);

                /*Updating query trade closed response in transaction stable */

                $db->where("out_trade_no",$out_trade_no);
                $db->where("transaction_type",'cb3');
                $query_update = $db->update('transaction_alipay',$query_res_data);

                // echo 'Query- Trade Closed';
                // exit;
                if($trade_status == 'TRADE_CLOSED'){?>
                <script type="text/javascript">$('#trade_closed').show()</script>
                <?php 
              }
              header( "Refresh:3;url=https://paymentgateway.test.credopay.in/shop/index.php");
              exit;
                
  }else {
                $query_res_data = array(
                "is_success" => $is_success,
                "error" => $error,
                "result_code" => 'FAIL'
                  );

                $query_response = "Application Log CBP:".date("Y-m-d H:i:s") . " Query fail response update in table:" . json_encode($query_res_data) . " \n\n";
                poslogs($query_response);

                /*Updating query fail response in transaction stable */

                $db->where("out_trade_no",$out_trade_no);
                $db->where("transaction_type",'cb3');
                $query_update = $db->update('transaction_alipay',$query_res_data);
                //echo 'Query Failed';
                if($is_success == 'F'){?>
                <script type="text/javascript">$('#fail_msg').show()</script>
               <?php 
                }
                header( "Refresh:3;url=https://paymentgateway.test.credopay.in/shop/index.php");
                exit;
  }
  break;
  }else{
        $acs = $str[3];
        $access_den = array(
        'merchant_id' => $merchant_id,
        'out_trade_no' => $out_trade_no,
        'query_access' => $acs
        );
        $mer_access_permsn = "Query Access Log CBP:".date("Y-m-d H:i:s") . " Query Not Allowed Log:" .json_encode($access_den). " \n\n";
        poslogs($mer_access_permsn);

        echo 'Query denied to this merchant';
    }
    exit;

  default:
  $invalid_req = "Application Log CBP:".date("Y-m-d H:i:s") . " Invalid Request Type:" .'Invalid Request' . $ncb_request . " \n\n";
  poslogs($invalid_req);

  echo "Sent Invalid Request";
  }

   

?>
</body>
</html>