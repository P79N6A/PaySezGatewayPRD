<?php

date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");
require_once("grabPay.config.php");


// DB Connection starts here
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
require_once('../api/encrypt.php');
require_once("alipayapi_pos.php");

error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$db = new Mysqlidb ($confighost, $userd, $passd, $grabpay_config['dataBase_con']);

//DB Connection Ends here

/* Log path GP declare by variable use in function poslogs */
$log_path = $grabpay_config['log-path'];
/* Log path AP declare by variable use in function poslogs */
$log_path_ap = $alipay_config['log-path'];

/** Log File Function GP starts  **/
function poslogs($log) {
GLOBAL $log_path;
$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}

/** Log File Function AP starts  **/
function poslogsAlipay($log) {
GLOBAL $log_path_ap;
$myfile = file_put_contents($log_path_ap, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}

/** Unix time to timestamp*/
function unixtotime($time){
$unix_timestamp = $time;
$datetime = new DateTime("@$unix_timestamp");
// Display GMT datetime
//echo $datetime->format('d-m-Y H:i:s');
$date_time_format = $datetime->format('Y-m-d H:i:s');
$time_zone_from="UTC";
$time_zone_to='Asia/Singapore';
$display_date = new DateTime($date_time_format, new DateTimeZone($time_zone_from));
// Date time with specific timezone
$display_date->setTimezone(new DateTimeZone($time_zone_to));
return $display_date->format('d-m-Y H:i:s');
}

$date_month = date("dmy");
$six_digit_random_msg = mt_rand(100000, 999999);
$six_digit_random_partner = mt_rand(100000, 999999);
$six_digit_random_partner_ap = mt_rand(100000, 999999);

if($_POST['payment_type'] == 'GP'):

//merchant & terminal id retrieving from DB

//Merchant ID
$db->where("mer_map_id" , $_POST['merchant_id']);
$merchant_result = $db->getOne("merchants");
$grabID = $merchant_result['grab_merchant_id'];
//echo $grabID;exit;

//Terminal ID
$db->where("mso_terminal_id" , $_POST['terminal_id']);
$terminal_result = $db->getOne("terminal");
$terminal_id_orig = $terminal_result['grab_terminal_id'];

//partner id & partner secret for grabpay
$gp_config = $db->getone("grabpay_config");
$partner_id = $gp_config['partner_id'];


// 2088621911453772
//echo $partner_id_ap;exit;

// $msgID = //random_msg(32);
// $partnerTxID = //random_partner(32);
//$arr = '520499d9-be82-422c-a6da-e4f5eeb6019e';  

//Grabpay split info
$arr_result_msg = explode("-",$grabID);
$string_splt_msg = $arr_result_msg[2].$arr_result_msg[3].$arr_result_msg[4];
$arr_result_partner = explode("-",$partner_id);
$string_splt_partner = $arr_result_partner[2].$arr_result_partner[3].$arr_result_partner[4];  

$msgID = $date_month.$six_digit_random_msg.$string_splt_msg;
$partnerTxID = $date_month.$six_digit_random_partner.$string_splt_partner;
$partner_id_res = $date_month.$six_digit_random_partner;


//echo $partner_id_res;exit;
// $msgID = $date_month.$six_digit_random_msg;//random_msg(32);
// $partnerTxID = $date_month.$six_digit_random_partner;//random_partner(32);

// $url = "https://partner-api.stg-myteksi.com"; 
// $pay_order_url_string = "/grabpay/partner/v1/terminal/qrcode/create";

$url = $grabpay_config['url']; 
$pay_order_url_string = $grabpay_config['pay_order_url_string'];
$url_curl = $url.$pay_order_url_string; 
$method_type = $grabpay_config['method_type'];
$refund_method_type = $grabpay_config['refund_method_type'];
$cancel_method_type = $grabpay_config['cancel_method_type'];
$inquiry_method_type = $grabpay_config['inquiry_method_type'];
$content_type = $grabpay_config['content_type'];
$query_content_type = $grabpay_config['query_content_type'];
$gmt_date = gmdate('D, d M Y H:i:s T');
//$partner_secret = 'UcEYLPlrSpqWeZeW';
$partner_secret = $gp_config['partner_secret'];
$tran_req_type = "";
if($_POST['tran_req_type']){
  $tran_req_type = $_POST['tran_req_type'];
}else{
  $tran_req_type = $_GET['tran_req_type'];
}


switch ($tran_req_type) {
    case "1": //QR request
        $amount = $_POST['amount'];
        $terminal_timestamp = $_POST['terminal_timestamp'];
        $terminal_id = $_POST['terminal_id'];
        $currency = $_POST['currency'];
        $merchant_id = $_POST['merchant_id'];

        $received_parameter = array(
            "gp_amount" => $amount,
            "gp_terminal_id" => $terminal_id,
            "gp_currency" => $currency,
            "gp_transaction_type" => $tran_req_type,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_merchant_id" => $merchant_id
        );
        $request_param_orig = "Application Log GP:".date("Y-m-d H:i:s") . " QR Request Parameter Received from Mpos:" . json_encode($_POST) . " \n\n";
        poslogs($request_param_orig);

        // $request_param_log = "Application Log GP:".date("Y-m-d H:i:s") . " QR Request Parameter Received from Mpos:" . json_encode($received_parameter) . " \n\n";
        // poslogs($request_param_log);

         /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");

        $parameter_ins = array(
            "gp_amount" => $amount,
            "gp_terminal_id" => $terminal_id,
            "gp_currency" => $currency,
            "gp_msgID" => $msgID,
            "gp_grabID" => $grabID,
            "gp_partnerTxID" => $partnerTxID,
            "gp_trans_datetime" => date('Y-m-d H:i:s'),
            "gp_trans_time" => date('H:i:s'),
            "gp_trans_date" => date('Y-m-d'),
            "gp_transaction_type" => $tran_req_type,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_cst_trans_datetime" => $gmt_time_singapore,
            "gp_merchant_id" => $merchant_id
        );
        //print_r($parameter_ins);exit;
        /* Inserting Create Order request data from mpos into Transaction table */
        $insert_create_ord_param = $db->insert('gp_transaction', $parameter_ins);

        $req_parameter_arr_json = "{\n\t\"amount\":".$amount.",\n\t\"msgID\":\"".$msgID."\",\n\t\"grabID\":\"".$grabID."\",\n\t\"terminalID\":\"".$terminal_id_orig."\",\n\t\"currency\":\"".$currency."\",\n\t\"partnerTxID\":\"".$partnerTxID."\"\n}";


        $content_digest_base = base64_encode(hash("SHA256", $req_parameter_arr_json,true));

        $string_to_sign = $method_type."\n".$content_type."\n".$gmt_date."\n".$pay_order_url_string."\n".$content_digest_base."\n";

        $hmac_sign = hash_hmac("SHA256", $string_to_sign,$partner_secret,true);
        $base64_encoded_hmac_signature = base64_encode($hmac_sign);

        $authorization = $partner_id.':'.$base64_encoded_hmac_signature;

        // $request_url = "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Request URL:" . $url_curl . " \n\n";
        // poslogs($request_url);

        // $request_parameter_before_GP = "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Request Parameter Before Build:" .$req_parameter_arr_json. " \n\n";
        // poslogs($request_parameter_before_GP);

        // $request_parameter = "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Request Parameter :" .$req_parameter_arr_json. " \n\n";
        // poslogs($request_parameter);

        // $content_digest_hash_GP= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Content Digest Before base64_encode:" .$req_parameter_arr_json. " \n\n";
        // poslogs($content_digest_hash_GP);

        // $content_digest_base64_encode= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Content Digest After base64_encode :" .$content_digest_base. " \n\n";
        // poslogs($content_digest_base64_encode);

        // $string_to_sign_GP= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order String to sign:" .$string_to_sign. " \n\n";
        // poslogs($string_to_sign_GP);

        // $hmac_signature_GP= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order HMAC Signature Before  :" .$partner_secret.'+'.$string_to_sign. " \n\n";
        // poslogs($hmac_signature_GP);

        // $hmac_digest_GP= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Hmac digest After :" .$hmac_sign. " \n\n";
        // poslogs($hmac_digest_GP);

        // $hmac_signature_after_GP= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order HMAC Signature After base64_encode :" .$base64_encoded_hmac_signature. " \n\n";
        // poslogs($hmac_signature_after_GP);

        // $authorization_GP= "Application Log GP:".date("Y-m-d H:i:s") . " QR Create Order Authorization  :" .$authorization. " \n\n";
        // poslogs($authorization_GP);


        // $curl_header = "Application Log GP:".date("Y-m-d H:i:s")  .  " QR Create Order Curl Header Data:"  ."Content-Type:" .$content_type. ",Authorization:" .$authorization.",Date:".$gmt_date. "\n\n";
        // poslogs($curl_header);

        $curl_post_fields = "Application Log GP:".date("Y-m-d H:i:s")  .  " QR Create Order Curl Post Fields Data:"  ."URL:" .$url_curl. ",Request_type:" .$method_type.",PostFields:".$req_parameter_arr_json. "\n\n";
        poslogs($curl_post_fields);


        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url_curl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method_type,
        CURLOPT_POSTFIELDS => $req_parameter_arr_json,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HTTPHEADER => array(
        "Authorization:".$authorization,
        "Date:".$gmt_date,
        "Content-Type:".$content_type
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " QR Response :" . json_encode($err) . " \n\n";
        poslogs($log2);
        echo "Create Order Response #:" . $err;
        } else {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " QR Response :" .$response . " \n\n";
        poslogs($log2);

        //echo "Create Order Response #:" . $response;
        $characters = json_decode($response,true);// decode the JSON feed
        $msgID_res = $characters['msgID'];
        $qrcode_res = $characters['qrcode'];
        $txID_res = $characters['txID'];
        $devmsg = $characters['devMessage'];
        $arg = $characters['arg']; 

        // {"arg":"270319589834422ca6dae4f5eeb6019e","devMessage":"Endpoint: Call: undefined response code 503"} 
        if($qrcode_res != ''){
         $create_ord_resp_orig = array(
            "gp_msgID" => $msgID_res,
            "gp_qrcode" => $qrcode_res,
            "gp_txID" => $txID_res 
        );
        } else {
            $create_ord_resp_orig = array(
            "gp_DevMessage" => $devmsg,
            "gp_Arg" => $arg 
        );
    }
        //print_r($create_ord_resp_orig);exit;
        // $final_create_res_upd =  "Create Order QR Response update in table :".date("Y-m-d H:i:s") . json_encode($create_ord_resp_orig) . " \n\n";
        //     poslogs($final_create_res_upd);

        /* Updating Transaction table after success response */
        $db->where("gp_partnerTxID", $partnerTxID);
        $db->where("gp_transaction_type", $tran_req_type);
        $order_qr_Resupdate = $db->update('gp_transaction', $create_ord_resp_orig);

        /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");

        // $db->where("gp_partnerTxID" , $partnerTxID);
        // $db->where("gp_transaction_type" , $tran_req_type);
        // $trans_result = $db->getOne("gp_transaction");

        // $cst_time = $trans_result['gp_completedAt'];
        // echo $cst_time;exit;
        // $time_response = gmdate("Y-m-d H:i:s", $updated_res);
        if($qrcode_res != ''){
        $create_order_response = array(
                "transaction_status" => 'SUCCESS',
                "msgID" => $msgID_res,
                "txID" => $txID_res,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $partner_id_res,
                "timestamp" => $gmt_time_singapore,
                "qrcode_value" => $qrcode_res
            );

        } else {
            $create_order_response = array(
                "transaction_status" => 'FAILURE',
                "terminal_id" => $terminal_id
            );
        }
        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " QR Response Send to App :" .json_encode($create_order_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($create_order_response);
            header('Content-Type: application/json');
            echo $response_encode;
        //echo "Create Order Response #:" . $create_order_response;
        }
        break;
        exit;

    case "2": //Refund Request

        $terminal_id = $_POST['terminal_id'];
        $amount = $_POST['amount'];
        $currency = $_POST['currency'];
        $origPartnerTxID = $_POST['orig_partner_txid'] . $string_splt_partner;
        $merchant_id = $_POST['merchant_id'];
        //$reason = $_GET['reason'];

        $received_parameter = array(
        "gp_orig_partnerTxID" => $origPartnerTxID,
        "gp_terminal_id" => $terminal_id,
        "gp_amount" => $amount,
        "gp_transaction_type" => $tran_req_type,
        "gp_currency" => $currency,
        "gp_payment_type" => $_POST['payment_type'],
        "gp_merchant_id" => $merchant_id
        );

        $request_param_orig = "Application Log GP:".date("Y-m-d H:i:s") . " Refund Request Parameter Received from Mpos:" . json_encode($_POST) . " \n\n";
        poslogs($request_param_orig);

        /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");

        $parameter_ins = array(
            "gp_amount" => $amount,
            "gp_terminal_id" => $terminal_id,
            "gp_currency" => $currency,
            "gp_msgID" => $msgID,
            "gp_grabID" => $grabID,
            "gp_partnerTxID" => $partnerTxID,
            "gp_trans_datetime" => date('Y-m-d H:i:s'),
            "gp_trans_time" => date('H:i:s'),
            "gp_trans_date" => date('Y-m-d'),
            "gp_cst_trans_datetime" => $gmt_time_singapore,
            "gp_transaction_type" => $tran_req_type,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_orig_partnerTxID" => $origPartnerTxID,
            "gp_merchant_id" => $merchant_id
        );
        //print_r($parameter_ins);exit;
        /* Inserting Refund request data from mpos into Transaction table */
        $insert_refund_param = $db->insert('gp_transaction', $parameter_ins);


        $refund_req_path = "/grabpay/partner/v1/terminal/transaction/".$origPartnerTxID."/refund";
        $refund_req_url = $url.$refund_req_path;

        // $req_parameter_arr_json = "{\n\t\"msgID\":\"".$msgID."\",\n\t\"grabID\":\"".$grabID."\",\n\t\"terminalID\":\"".$terminal_id."\",\n\t\"currency\":\"".$currency."\",\n\t\"amount\":".$amount.",\n\t\"reason\":\"".$reason."\",\n\t\"partnerTxID\":\"".$partnerTxID."\"\n}";
        $req_parameter_arr_json = "{\n\t\"msgID\":\"".$msgID."\",\n\t\"grabID\":\"".$grabID."\",\n\t\"terminalID\":\"".$terminal_id_orig."\",\n\t\"currency\":\"".$currency."\",\n\t\"amount\":".$amount.",\n\t\"partnerTxID\":\"".$partnerTxID."\"\n}";


        $content_digest_base = base64_encode(hash("SHA256", $req_parameter_arr_json,true));

        $string_to_sign = $refund_method_type."\n".$content_type."\n".$gmt_date."\n".$refund_req_path."\n".$content_digest_base."\n";

        $hmac_sign = hash_hmac("SHA256", $string_to_sign,$partner_secret,true);
        $base64_encoded_hmac_signature = base64_encode($hmac_sign);


        //echo $base64_encoded_hmac_signature.'<br>';exit;

        $authorization = $partner_id.':'.$base64_encoded_hmac_signature;

        // $request_url = "Application Log GP:".date("Y-m-d H:i:s") . " Refund Request URL:" . $refund_req_url . " \n\n";
        // poslogs($request_url);

        // $request_parameter_after_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Refund Request Parameter:" .$req_parameter_arr_json. " \n\n";
        // poslogs($request_parameter_after_GP);

        // $content_digest_hash_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Refund Content Digest Before base64_encode:" .$req_parameter_arr_json. " \n\n";
        // poslogs($content_digest_hash_GP);

        // $content_digest_base64_encode= "Application Log GP:".date("Y-m-d H:i:s") . " Refund Content Digest After base64_encode :" .$content_digest_base. " \n\n";
        // poslogs($content_digest_base64_encode);

        // $string_to_sign_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Refund String to sign:" .$string_to_sign. " \n\n";
        // poslogs($string_to_sign_GP);

        // $hmac_signature_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Refund HMAC Signature Before  :" .$partner_secret.'+'.$string_to_sign. " \n\n";
        // poslogs($hmac_signature_GP);

        // $hmac_digest_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Refund Hmac digest After :" .$hmac_sign. " \n\n";
        // poslogs($hmac_digest_GP);

        // $hmac_signature_after_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Refund HMAC Signature After base64_encode :" .$base64_encoded_hmac_signature. " \n\n";
        // poslogs($hmac_signature_after_GP);

        // $authorization_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Refund Authorization  :" .$authorization. " \n\n";
        // poslogs($authorization_GP);


        // $curl_header = "Application Log GP:".date("Y-m-d H:i:s")  .  " Refund Curl Header Data:"  ."Content-Type:" .$content_type. ",Authorization:" .$authorization.",Date:".$gmt_date. "\n\n";
        // poslogs($curl_header);

        $curl_post_fields = "Application Log GP:".date("Y-m-d H:i:s")  .  " Refund Curl Put Fields Data:"  ."URL:" .$refund_req_url. ",Request_type:" .$refund_method_type.",PostFields:".$req_parameter_arr_json. "\n\n";
        poslogs($curl_post_fields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $refund_req_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $refund_method_type,
        CURLOPT_POSTFIELDS => $req_parameter_arr_json,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HTTPHEADER => array(
        "Authorization:".$authorization,
        "Date:".$gmt_date,
        "Content-Type:".$content_type
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Refund Response :" . json_encode($err) . " \n\n";
        poslogs($log2);
        echo "cURL Response #:" . $err;
        } else {
            $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Refund Response :" .json_encode($response) . " \n\n";
        poslogs($log2);
        // cURL Response #:{"msgID":"UteYvEaPKQHm0y1GV9r8noXsAWq2ZD3g","txID":"UteYvEaPKQHm0y1GV9r8noXsAWq2ZD3g","originTxID":"fb2438d66c444b48855f02ac67090c55","status":"success","description":""}
        $characters = json_decode($response,true);// decode the JSON feed

        $msgID_res = $characters['msgID'];
        $originTxID = $characters['originTxID'];
        $txID_res = $characters['txID'];
        $status = $characters['status'];
        $description = $characters['description'];
        $reason = $characters['reason'];
        $code = $characters['code'];
        $arg = $characters['arg'];
        $devMessage = $characters['devMessage'];
        
        if($status == 'success'){
        $refund_resp_orig = array(
            "gp_msgID" => $msgID_res,
            "gp_originTxID" => $originTxID,
            "gp_txID" => $txID_res,
            "gp_status" => $status,
            "gp_description" => $description
        );
    }else{
        $refund_resp_orig = array(
            "gp_reason" => $reason,
            "gp_code" => $code,
            "gp_Arg" => $arg,
            "gp_DevMessage" => $devMessage
        );

    }
    
        

        //print_r($refund_resp_orig);exit;
        // $final_create_res_upd =  "Refund Response update in table :".date("Y-m-d H:i:s") . json_encode($refund_resp_orig) . " \n\n";
        //     poslogs($final_create_res_upd);

        /* Updating Transaction table after success refund response */
        $db->where("gp_partnerTxID", $partnerTxID);
        $db->where("gp_transaction_type", $tran_req_type);
        $refund_Resupdate = $db->update('gp_transaction', $refund_resp_orig);

        // $db->where("gp_partnerTxID" , $partnerTxID);
        // $db->where("gp_transaction_type" , $tran_req_type);
        // $trans_result = $db->getOne("gp_transaction");
        // if($status == 'success'){
        // $cst_time = $trans_result['gp_completedAt'];

        // $time_response = unixtotime($cst_time);
        // }else{
        
        /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $time_response = $given->format("Y-m-d H:i:s");

    //}
        if($status == 'success'){
        $refund_response = array(
        "transaction_status" => $status,
        "refund_amount" => $amount,
        "txID" => $txID_res,
        "terminal_id" => $terminal_id,
        "timestamp" => $time_response,
        "partnerTxID" => $partner_id_res
        );
    }else{
        $refund_response = array(
        "transaction_status" => $reason,
        "refund_amount" => $amount,
        "txID" => $txID_res,
        "terminal_id" => $terminal_id,
        "timestamp" => $time_response,
        "partnerTxID" => $partner_id_res
        );

    }

        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Refund Response Send to App :" .json_encode($refund_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($refund_response);
            header('Content-Type: application/json');
            echo $response_encode;
        //echo "Create Order Response #:" . $create_order_response;
        }
        // $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Refund Response :" . json_encode($response) . " \n\n";
        // poslogs($log2);
        // echo "cURL Response #:" . $response;
        break;
        exit;

    case "3": //Cancel Request

        $terminal_id = $_POST['terminal_id'];
        $currency = $_POST['currency'];
        $origPartnerTxID = $_POST['orig_partner_txid'] .$string_splt_partner;
        $merchant_id = $_POST['merchant_id'];

        $cancel_req_path = "/grabpay/partner/v1/terminal/transaction/".$origPartnerTxID."/cancel";
        $cancel_req_url = $url.$cancel_req_path;

        $req_parameter_arr_json = "{\n\t\"msgID\":\"".$msgID."\",\n\t\"grabID\":\"".$grabID."\",\n\t\"terminalID\":\"".$terminal_id_orig."\",\n\t\"currency\":\"".$currency."\",\n\t\"origTxID\":\"".$origPartnerTxID."\",\n\t\"partnerTxID\":\"".$partnerTxID."\"\n}";

        $received_parameter = array(
            "gp_orig_partnerTxID" => $origPartnerTxID,
            "gp_terminal_id" => $terminal_id,
            "gp_transaction_type" => $tran_req_type,
            "gp_currency" => $currency,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_merchant_id" => $merchant_id
            );

        $request_param_orig = "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Request Parameter Received from Mpos:" . json_encode($_POST) . " \n\n";
        poslogs($request_param_orig);

        /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");


        $parameter_ins = array(
            "gp_terminal_id" => $terminal_id,
            "gp_currency" => $currency,
            "gp_msgID" => $msgID,
            "gp_grabID" => $grabID,
            "gp_partnerTxID" => $partnerTxID,
            "gp_trans_datetime" => date('Y-m-d H:i:s'),
            "gp_trans_time" => date('H:i:s'),
            "gp_trans_date" => date('Y-m-d'),
            "gp_cst_trans_datetime" => $gmt_time_singapore,
            "gp_transaction_type" => $tran_req_type,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_orig_partnerTxID" => $origPartnerTxID,
            "gp_merchant_id" => $merchant_id
        );
        //print_r($parameter_ins);exit;
        /* Inserting Cancel request data from mpos into Transaction table */
        $insert_cancel_param = $db->insert('gp_transaction', $parameter_ins);

        $content_digest_base = base64_encode(hash("SHA256", $req_parameter_arr_json,true));

        $string_to_sign = $cancel_method_type."\n".$content_type."\n".$gmt_date."\n".$cancel_req_path."\n".$content_digest_base."\n";

        $hmac_sign = hash_hmac("SHA256", $string_to_sign,$partner_secret,true);
        $base64_encoded_hmac_signature = base64_encode($hmac_sign);


        //echo $base64_encoded_hmac_signature.'<br>';exit;

        $authorization = $partner_id.':'.$base64_encoded_hmac_signature;

        // $request_url = "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Request URL:" . $cancel_req_url . " \n\n";
        // poslogs($request_url);

        // $request_parameter_after_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Request Parameter:" .$req_parameter_arr_json. " \n\n";
        // poslogs($request_parameter_after_GP);

        // $content_digest_hash_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Content Digest Before base64_encode:" .$req_parameter_arr_json. " \n\n";
        // poslogs($content_digest_hash_GP);

        // $content_digest_base64_encode= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Content Digest After base64_encode :" .$content_digest_base. " \n\n";
        // poslogs($content_digest_base64_encode);

        // $string_to_sign_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel String to sign:" .$string_to_sign. " \n\n";
        // poslogs($string_to_sign_GP);

        // $hmac_signature_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel HMAC Signature Before  :" .$partner_secret.'+'.$string_to_sign. " \n\n";
        // poslogs($hmac_signature_GP);

        // $hmac_digest_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Hmac digest After :" .$hmac_sign. " \n\n";
        // poslogs($hmac_digest_GP);

        // $hmac_signature_after_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel HMAC Signature After base64_encode :" .$base64_encoded_hmac_signature. " \n\n";
        // poslogs($hmac_signature_after_GP);

        // $authorization_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Authorization  :" .$authorization. " \n\n";
        // poslogs($authorization_GP);


        // $curl_header = "Application Log GP:".date("Y-m-d H:i:s")  .  " Cancel Curl Header Data:"  ."Content-Type:" .$content_type. ",Authorization:" .$authorization.",Date:".$gmt_date. "\n\n";
        // poslogs($curl_header);

        $curl_post_fields = "Application Log GP:".date("Y-m-d H:i:s")  .  " Cancel Curl Put Fields Data:"  ."URL:" .$cancel_req_url. ",Request_type:" .$cancel_method_type.",PostFields:".$req_parameter_arr_json. "\n\n";
        poslogs($curl_post_fields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $cancel_req_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $cancel_method_type,
        CURLOPT_POSTFIELDS => $req_parameter_arr_json,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HTTPHEADER => array(
        "Authorization:".$authorization,
        "Date:".$gmt_date,
        "Content-Type:".$content_type
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Response :" . json_encode($err) . " \n\n";
        poslogs($log2);
        echo "cURL Response #:" . $err;
        } else {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Response :" .json_encode($response) . " \n\n";
        poslogs($log2);
        // cURL Response #:{"msgID":"UteYvEaPKQHm0y1GV9r8noXsAWq2ZD3g","txID":"UteYvEaPKQHm0y1GV9r8noXsAWq2ZD3g","originTxID":"fb2438d66c444b48855f02ac67090c55","status":"success","description":""}
        // decode the JSON feed
// {"code":4040,"reason":"transaction not found"}
        // $db->where("gp_partnerTxID", $partnerTxID);
        // $db->where("gp_transaction_type", $tran_req_type);
        // $cancel_Resupdate = $db->update('gp_transaction', $cancel_resp_orig);

        $db->where("gp_partnerTxID" , $partnerTxID);
        $db->where("gp_transaction_type", $tran_req_type);
        $trans_type = $db->getone("gp_transaction");
        $mer_terminal_id = $trans_type['gp_terminal_id'];


        $db->where("gp_partnerTxID" , $origPartnerTxID);
        $db->where("gp_transaction_type", '1');
        $trans_type_amt = $db->getone("gp_transaction");
        $mer_amount = $trans_type_amt['gp_amount'];

        $db->where("gp_partnerTxID" , $partnerTxID);
        $db->where("gp_transaction_type" , $tran_req_type);
        $trans_result = $db->getOne("gp_transaction");

        $time_response = $trans_result['gp_cst_trans_datetime'];

        if($response == ''){
            $cancel_response = array(
            "transaction_status" => 'SUCCESS',
            "amount" => $mer_amount,
            "timestamp" => $time_response,
            "terminal_id" => $mer_terminal_id
        );

        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Response Send to App :" .json_encode($cancel_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($cancel_response);
            header('Content-Type: application/json');
            echo $response_encode;
            exit;
        }
        $characters = json_decode($response,true);
        $code = $characters['code'];
        $reason = $characters['reason'];

        $cancel_resp_orig = array(
            "gp_code" => $code,
            "gp_reason" => $reason
        );
        //print_r($refund_resp_orig);exit;
        // $final_cancel_res_upd =  "Cancel Response update in table :".date("Y-m-d H:i:s") . json_encode($cancel_resp_orig) . " \n\n";
        //     poslogs($final_cancel_res_upd);

        /* Updating Transaction table after success cancel response */
        $db->where("gp_partnerTxID", $partnerTxID);
        $db->where("gp_transaction_type", $tran_req_type);
        $cancel_Resupdate = $db->update('gp_transaction', $cancel_resp_orig);
        // $time_response = gmdate("Y-m-d H:i:s", $updated_res);
        // $time_response = unixtotime($cst_time);

        $cancel_response = array(
        "transaction_status" => $reason,
        "amount" => $mer_amount,
        "timestamp" => $time_response,
        "terminal_id" => $mer_terminal_id
        );

        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Cancel Response Send to App :" .json_encode($cancel_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($cancel_response);
            header('Content-Type: application/json');
            echo $response_encode;
        }
        break;
        exit;

    case "4": //Inquiry Request

        $terminal_id = $_POST['terminal_id'];
        $currency = $_POST['currency'];
        $txType = $_POST['txType'];
        $partnerTxnId_orig = $_POST['partnerTxnid_orig'] . $string_splt_partner;
        $merchant_id = $_POST['merchant_id'];

        $p2m_type = '1';
        $refund_type= '2';

        /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");

        $received_parameter = array(
            "gp_orig_partnerTxID" => $partnerTxnId_orig,
            "gp_terminal_id" => $terminal_id,
            "gp_currency" => $currency,
            "gp_txType" => $txType,
            "gp_transaction_type" => $tran_req_type,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_merchant_id" => $merchant_id
            );

        $request_param_orig = "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Request Parameter Received from Mpos:" . json_encode($_POST) . " \n\n";
        poslogs($request_param_orig);

    if($txType == 'P2M'){
        //Transaction Success already 
        $db->where("gp_partnerTxID" , $partnerTxnId_orig);
        $db->where("gp_transaction_type" , $p2m_type);
        $trans_result = $db->getOne("gp_transaction");
        //print_r($trans_result);exit;
        if(empty($trans_result)){
            $inquiry_response = array(
                "transaction_status" => 'FAILURE',
                "amount" => $amount_trans,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $_POST['partnerTxnid_orig'],
                "timestamp" => $gmt_time_singapore
            );

        $inq_res= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response Send to Mpos :" .json_encode($inquiry_response) . " \n\n";
        poslogs($inq_res);

        $response_encode = json_encode($inquiry_response);
        header('Content-Type: application/json');
        echo $response_encode;
        //echo "gp_partnerTxID in P2m Not Matched";
        exit;
        die();
        }
       
        }else if($txType == 'Refund'){
            
        $db->where("gp_partnerTxID" , $partnerTxnId_orig);
        $db->where("gp_transaction_type" , $refund_type);
        $trans_result = $db->getOne("gp_transaction");
        if(empty($trans_result)){
            $inquiry_response = array(
                "transaction_status" => 'FAILURE',
                "amount" => $amount_trans,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $_POST['partnerTxnid_orig'],
                "timestamp" => $gmt_time_singapore
            );

        $inq_res= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response Send to Mpos :" .json_encode($inquiry_response) . " \n\n";
        poslogs($inq_res);

        $response_encode = json_encode($inquiry_response);
        header('Content-Type: application/json');
        echo $response_encode;
        exit;
        die();
        }
        }
        

        $status_trans = $trans_result['gp_status'];
        $amount_trans = $trans_result['gp_amount'];
        if($status_trans == 'success'){
        $cst_time = $trans_result['gp_completedAt'];

        $time_response = unixtotime($cst_time);
        }else{
            $time_response = $gmt_time_singapore;
        }
        //echo $time_response;exit;
        if($status_trans == 'success'){

            $inquiry_response = array(
                "transaction_status" => $status_trans,
                "amount" => $amount_trans,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $_POST['partnerTxnid_orig'],
                "timestamp" => $time_response
            );

        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response Send to App :" .json_encode($inquiry_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($inquiry_response);
            header('Content-Type: application/json');
            echo $response_encode;
            exit;
            die();

        }

        

        $parameter_ins = array(
            "gp_terminal_id" => $terminal_id,
            "gp_currency" => $currency,
            "gp_msgID" => $msgID,
            "gp_grabID" => $grabID,
            "gp_txType" => $txType,
            "gp_orig_partnerTxID" => $partnerTxnId_orig,
            "gp_trans_datetime" => date('Y-m-d H:i:s'),
            "gp_trans_time" => date('H:i:s'),
            "gp_trans_date" => date('Y-m-d'),
            "gp_cst_trans_datetime" => $gmt_time_singapore,
            "gp_transaction_type" => $tran_req_type,
            "gp_payment_type" => $_POST['payment_type'],
            "gp_merchant_id" => $merchant_id
        );
        
        /* Inserting Cancel request data from mpos into Transaction table */
        $insert_inquiry_param = $db->insert('gp_transaction', $parameter_ins);

        $inquiry_req_path = "/grabpay/partner/v1/terminal/transaction/".$partnerTxnId_orig;
       
        $build_qry = '?'.'msgID='.$msgID.'&grabID='.$grabID.'&terminalID='.$terminal_id_orig.'&currency='.$currency.'&txType='.$txType;

        $final_inquiry_path = $inquiry_req_path.$build_qry;

        $inquiry_req_url = $url.$inquiry_req_path.$build_qry;
        
        $content_digest_base = '';

        $string_to_sign = $inquiry_method_type."\n".$query_content_type."\n".$gmt_date."\n".$final_inquiry_path."\n".$content_digest_base."\n";

        $hmac_sign = hash_hmac("SHA256", $string_to_sign,$partner_secret,true);
        $base64_encoded_hmac_signature = base64_encode($hmac_sign);

        $authorization = $partner_id.':'.$base64_encoded_hmac_signature;

        // $request_url = "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Request URL:" . $inquiry_req_url . " \n\n";
        // poslogs($request_url);

        // $request_parameter_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Request Parameter:" .$build_qry. " \n\n";
        // poslogs($request_parameter_after_GP);

        // $string_to_sign_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry String to sign:" .$string_to_sign. " \n\n";
        // poslogs($string_to_sign_GP);

        // $hmac_signature_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry HMAC Signature Before  :" .$partner_secret.'+'.$string_to_sign. " \n\n";
        // poslogs($hmac_signature_GP);

        // $hmac_digest_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Hmac digest After :" .$hmac_sign. " \n\n";
        // poslogs($hmac_digest_GP);

        // $hmac_signature_after_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry HMAC Signature After base64_encode :" .$base64_encoded_hmac_signature. " \n\n";
        // poslogs($hmac_signature_after_GP);

        // $authorization_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Authorization  :" .$authorization. " \n\n";
        // poslogs($authorization_GP);


        // $curl_header = "Application Log GP:".date("Y-m-d H:i:s")  .  " Inquiry Curl Header Data:"  ."Content-Type:" .$query_content_type. ",Authorization:" .$authorization.",Date:".$gmt_date. "\n\n";
        // poslogs($curl_header);

        $curl_post_fields = "Application Log GP:".date("Y-m-d H:i:s")  .  " Inquiry Curl Put Fields Data:"  ."URL:" .$inquiry_req_url. ",Request_type:" .$inquiry_method_type.",PostFields:".$build_qry. "\n\n";
        poslogs($curl_post_fields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $inquiry_req_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $inquiry_method_type,
        CURLOPT_POSTFIELDS => "",
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HTTPHEADER => array(
        "Authorization:".$authorization,
        "Date:".$gmt_date,
        "Content-Type:".$query_content_type
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response :" . json_encode($err) . " \n\n";
        poslogs($log2);
        echo "Inquiry Response #:" . $err;
        } else {
        $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response :" . json_encode($response) . " \n\n";
        poslogs($log2);
        //echo "Inquiry Response #:" . $response;

        $characters = json_decode($response,true);// decode the JSON feed
        $msgID_res = $characters['msgID'];
        $txID_res = $characters['txID'];
        $status_res = $characters['status'];
        $amount_res = $characters['amount'];
        $updated_res = $characters['updated'];
        $currency_res = $characters['currency'];
        $code_res = $characters['code'];
        $reason_res = $characters['reason'];
        //echo $updated_res;exit;
         //echo $reason_res;exit;
       //unix time to normal datetime
        //$time_response = gmdate("Y-m-d H:i:s", $updated_res);
        if($status_res == 'success'){
        $time_response = unixtotime($updated_res);
        }
        
        if($status_res == 'success'){

        $inquiry_response = array(
                "transaction_status" => $status_res,
                "amount" => $amount_res,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $_POST['partnerTxnid_orig'],
                "timestamp" => $time_response
            );

        $inquiry_response_upd = array(
                "gp_msgID" => $msgID_res,
                "gp_txID" => $txID_res,
                "gp_status" => $status_res,
                "gp_amount" => $amount_res,
                "gp_updated" => $updated_res,
                "gp_currency" => $currency_res,
                "gp_code" => $code_res,
                "gp_reason" => $reason_res
            );
        /* Updating inquiry Success response in transaction table */

        $db->where("gp_orig_partnerTxID", $partnerTxnId_orig);
        $db->where("gp_transaction_type", $tran_req_type);
        $inquiry_Resupdate = $db->update('gp_transaction', $inquiry_response_upd);


        $db->where("gp_partnerTxID" , $partnerTxnId_orig);
        $inquiry_orig_pay_upd = $db->update('gp_transaction', $inquiry_response_upd);

        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response Send to App :" .json_encode($inquiry_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($inquiry_response);
            header('Content-Type: application/json');
            echo $response_encode;
            exit;

    }else{
        $inquiry_response_upd = array(
                "gp_code" => $code_res,
                "gp_reason" => $reason_res
            );

        $inquiry_response = array(
                "transaction_status" => $reason_res,
                "amount" => $amount_res,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $_POST['partnerTxnid_orig'],
                "timestamp" => $gmt_time_singapore
            );

        /* Updating inquiry error response in transaction table */

        $db->where("gp_orig_partnerTxID", $partnerTxnId_orig);
        $db->where("gp_transaction_type", $tran_req_type);
        $inquiry_Resupdate = $db->update('gp_transaction', $inquiry_response_upd);


        $db->where("gp_partnerTxID" , $partnerTxnId_orig);
        $inquiry_orig_pay_upd = $db->update('gp_transaction', $inquiry_response_upd);

        $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response Send to App :" .json_encode($inquiry_response) . " \n\n";
        poslogs($log3);

        $response_encode = json_encode($inquiry_response);
            header('Content-Type: application/json');
            echo $response_encode;
            exit;

    }


        // $log3= "Application Log GP:".date("Y-m-d H:i:s") . " Inquiry Response Send to App :" .json_encode($inquiry_response) . " \n\n";
        // poslogs($log3);

        // $response_encode = json_encode($inquiry_response);
        //     header('Content-Type: application/json');
        //     echo $response_encode;
        }
        break;
        exit;

    // case "5": //Login Request
    //     $terminal_id ='54f50424894fe164971a3020f';
    //     $IMEI = $_POST['IMEI'];
    //     $user = $_POST['user'];
    //     $password = $_POST['password'];

    //     $login_array = array(
    //             "IMEI" => $IMEI,
    //             "user" => $user,
    //             "password" => $password
    //         );

    //     $login_request = "Application Log GP:".date("Y-m-d H:i:s") . " Login Request data:" . json_encode($login_array) . " \n\n";
    //     poslogs($login_request);

        
    //     $login_res_array = array(
    //             "login_status" => 'SUCCESS',
    //             "IMEI" => $IMEI,
    //             "terminal_id" => $terminal_id,
    //             "merchant_id" => $grabID
    //         );

    //     $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
    //     poslogs($login_response);

    //     $login_response_encode = json_encode($login_res_array);
    //         header('Content-Type: application/json');
    //         echo $login_response_encode;

    //     break;
    //     exit;

    case "6":
    /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");

    $payment_type = $_POST['pay_type'];
    $mer_id = $_POST['merchant_id'];

    $received_parameter = array(
            "settle_type" => $payment_type,
            "transaction_type" => $tran_req_type,
            "payment_type" => $_POST['payment_type'],
            "merchant_id" => $mer_id
            );
    // $sdate = date('Y-m-d 00:00:00',strtotime("-1 days"));
    // $edate = date('Y-m-d 23:59:59',strtotime("-1 days"));
    $settle_received_data = "Application Log GP:".date("Y-m-d H:i:s") . " Settlement Received Data from Mpos :" . json_encode($_POST) . " \n\n";
        poslogs($settle_received_data);


    $sdate = date('Y-m-d 00:00:00');
    $edate = date('Y-m-d 23:59:59');
    $current_date_time = date("Y-m-d H:i:s");

    $que1 ="SELECT gp_transaction.gp_merchant_id ,gp_transaction.gp_terminal_id,gp_transaction.gp_partnerID,gp_transaction.gp_cst_trans_datetime, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND gp_transaction.gp_merchant_id = '$mer_id' AND gp_transaction.gp_transaction_type IN ('1') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
    $data1 = $db->rawQuery($que1);

    $que2 ="SELECT gp_transaction.gp_merchant_id ,gp_transaction.gp_terminal_id,gp_transaction.gp_partnerID,gp_transaction.gp_cst_trans_datetime, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND gp_transaction.gp_merchant_id = '$mer_id' AND gp_transaction.gp_transaction_type IN ('2') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
    $data2 = $db->rawQuery($que2);

    if($data1) {
        foreach($data1 as $var1){
            $total_count = $var1['countt'];
            $total_amount= $var1['total'];
            $merchant_id = $var1['gp_merchant_id'];
            $terminal_id = $var1['gp_terminal_id'];
            $partner_id = $var1['gp_partnerID'];
            $singapr_time = $var1['gp_cst_trans_datetime'];

        }
    }
    if($data2) {
        foreach($data2 as $var2){
            $refund_count = $var2['countt'];
            $refund_amount= $var2['total'];
            $merchant_id = $var2['gp_merchant_id'];
            $terminal_id = $var2['gp_terminal_id'];
            $partner_id = $var2['gp_partnerIDnmm'];
            $singapr_time = $var2['gp_cst_trans_datetime'];
        }
    }

    $settlement_response = array(
        "pay_type" => $payment_type,
        "Total_Sale_Count"  => $total_count,
        "Total_Sale_Amount" => $total_amount,
        "Total_Refund_Count"  => $refund_count,
        "Total_Refund_Amount" => $refund_amount,
        "merchant_id" => $merchant_id,
        "terminal_id" => $terminal_id,
        "timestamp" => $gmt_time_singapore,
        "Period" => $sdate." To ".$gmt_time_singapore
    );

    $settle_res_send= "Application Log GP:".date("Y-m-d H:i:s") . " Settlement Response Send to App :" .json_encode($settlement_response) . " \n\n";
        poslogs($settle_res_send);

    $response_encode = json_encode($settlement_response);
    header('Content-Type: application/json');
    echo $response_encode;

    break;

    default:
        $invalid_req = "Application Log CBP:".date("Y-m-d H:i:s") . " Invalid Request Type:" .'Invalid Request' . $tran_req_type . " \n\n";
        poslogs($invalid_req);

        echo "Sent Invalid Request";
        exit;

}
elseif ($_POST['payment_type'] == 'AP'):

    $tran_req_type = "";
    if($_POST['tran_req_type']){
      $tran_req_type = $_POST['tran_req_type'];
    }else{
      $tran_req_type = $_GET['tran_req_type'];
    }

    $partner_substr_ap = substr($partner_id_ap,2);
    $partnerTxID_ap = $date_month.$six_digit_random_partner_ap.$partner_substr_ap;
    $partner_id_res_ap = $date_month.$six_digit_random_partner_ap;
    //product_code
    $product_code_ap = $alipay_config['product_code']; 
    $subject = 'Alipay_Dynamic_QR';

    switch ($tran_req_type) {

        case "1": //QR request
            $req_terminal_id = $_POST['terminal_id'];
            $req_merchant_id = $_POST['merchant_id'];
            $req_total_fee = $_POST['amount'];
            $req_currency = $_POST['currency'];
            $req_terminal_timestamp = $_POST['terminal_timestamp'];
            $req_out_trade_no = $partnerTxID_ap;
            $req_partner_id_ap = $partner_id_ap;
            $req_product_code = $product_code_ap;
            $req_subject = $subject;
            $req_partner_id_res_ap = $partner_id_res_ap;
            $req_partner_key = $partner_key_ap;

            ?>
            <html>
  <body>
   <script type="text/javascript"></script>
   <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
   <script>
        var req_terminal_id = 'hello';
        alert(req_terminal_id);
    //     var req_merchant_id = $_POST['merchant_id'];
    //     var req_total_fee = $_POST['amount'];
    //     var req_currency = $_POST['currency'];
    //     var req_terminal_timestamp = $_POST['terminal_timestamp'];
    //     var req_out_trade_no = $partnerTxID_ap;
    //     var req_partner_id_ap = $partner_id_ap;
    //     var req_product_code = $product_code_ap;
    //     var req_subject = $subject;
    //     var req_partner_id_res_ap = $partner_id_res_ap;
    //     var req_partner_key = $partner_key_ap;
    //    $.ajax({
    //     type: 'POST',
    //     url: 'alipayapi.php',
    //     data: { terminal_id:$req_terminal_id},
    //     success: function(response) {
    //         $('#result').html(response);
    //     }
    // });

   </script>
   </body>
</html>
   <?php 


            $request_param_orig = "Application Log AP:".date("Y-m-d H:i:s") . " QR Request Parameter Received from Mpos:" . json_encode($_POST) . " \n\n";
            poslogsAlipay($request_param_orig);

// echo 'success';
           // payment($req_terminal_id,$req_merchant_id,$req_total_fee,$req_currency,$req_terminal_timestamp,$req_out_trade_no,$req_partner_id_ap,$req_product_code,$req_subject,$req_partner_id_res_ap,$req_partner_key,$tran_req_type);
            //payment($req_terminal_id,$req_merchant_id);
            

            // $response_encode = json_encode($qr_response);
            //     header('Content-Type: application/json');
            //     echo $response_encode;
            // echo "Create Order Response #:" . $create_order_response;
            break;
            exit;
    case "2": 
            echo 'no valid request';
            break;
            exit;
    default:
        $invalid_req = "Application Log CBP:".date("Y-m-d H:i:s") . " Invalid Request Type:" .'Invalid Request' . $tran_req_type . " \n\n";
        poslogs($invalid_req);

        echo "Sent Invalid Request";
        exit;
    }

else:
    echo "Invlid Payment Request";

endif;

?>
