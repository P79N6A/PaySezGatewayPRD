<?php 
$url ='https://partner-api.stg-myteksi.com?';
$url_dup = 'https://partner-api.stg-myteksi.com';

$msgID ='test123456';
$grabID ='520499d9-be82-422c-a6da-e4f5eeb6019e';
$terminalID ='G00000000000001';
$currency ='SGD';
$amount ='1';
$partnerTxID ='GP0123456789';

$request_parameters ='{"msgID" :"'.$msgID.'","grabID" :"'.$grabID.'","terminalID" :"'.$terminalID.'","currency" :"'.$currency.'","amount" :"'.$amount.'","partnerTxID" :"'.$partnerTxID.'"}';
//print_r($request_parameters);exit;

// Request body: {"identity":"event_import_eg@example.com","identity_source":"email","event_name":"Content View","event_source":"web","event_date":"2015-11-05 10:22:03.111","engagement_score":"15","identities":{"fb_event_import_eg":"facebook"}}
// X-Authorization-Content-SHA256: zC4p8Oa+aw6pTdoW1uFN0ngemDjd5QlZXBK5tcUKzCw=
// Authorization: acquia-http-hmac realm="AcquiaLiftWeb",id="efdde334-fe7b-11e4-a322-1697f925ec7b",nonce="d1954337-5319-4821-8427-115542e08d10",version="2.0",signature="R6y7kWkBnUdcSNXMxh4Vib6wSSHYKY4srCA1d4unW78="


$partner_id = '1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
$partner_secret = 'UcEYLPlrSpqWeZeW';
$terminal_id ='54f50424894fe164971a3020f';
$gmt_date = gmdate('D, d M Y H:i:s T');
$pay_order_url_string = '/grabpay/partner/v1/terminal/qrcode/create?';
$encoded_parameters = urlencode($request_parameters);
//echo $encoded_parameters;exit;
$url_parameter = $url_dup.$pay_order_url_string.$encoded_parameters;
//echo $url_parameter;exit;

$string_to_sign ='"POST"+"\n"+"application/json"+"\n"+'.$gmt_date.'+"\n"+'.$url_parameter.'+"\n"+""+"\n"';
//echo $string_to_sign;exit;  
//$message = 'vinoth';
// $secre_key ='abcdefghijklmnopqrstuvwxyz';
// $s = hash_hmac('sha256', $message,$secre_key, true);
// echo base64_encode($s);

$hmac_signature = hash_hmac("SHA256", $partner_secret, $string_to_sign);
// echo $hmac_signature;exit;
$base64_encoded_hmac_signature = base64_encode($hmac_signature);
//echo $base64_encoded_hmac_signature;exit;

date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");

/* Log path declare by variable use in function poslogs */
$log_path = $alipay_config['log-path'];

/** Log File Function starts **/
function poslogs($log) {
GLOBAL $log_path;
$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}
/**  Log File Function Ends **/
// $vino = "Authorization:".$partner_id.":".$base64_encoded_hmac_signature;
// echo $vino;exit;
$request_url = date("Y-m-d H:i:s") . " GP Request URL:" . $url . " \n\n";
poslogs($request_url);

$string_to_sign_GP= "Application Log GP:".date("Y-m-d H:i:s") . " String to sign:" .($string_to_sign) . " \n\n";
poslogs($string_to_sign_GP);

$url_parameter_GP = "Application Log GP:".date("Y-m-d H:i:s") . " URL Parameter:" .($url_parameter) . " \n\n";
poslogs($url_parameter_GP);

$request_parameter_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Payment Request Data:" .($partner_id) . " \n\n";
poslogs($request_parameter_GP);

$partner_id_Gp = "Application Log GP:".date("Y-m-d H:i:s") . " Partner_id:" .($request_parameters) . " \n\n";
poslogs($partner_id_Gp);

$base4_hmac_sign= "Application Log GP:".date("Y-m-d H:i:s") . " Hamca sign:" .($base64_encoded_hmac_signature) . " \n\n";
poslogs($base4_hmac_sign);


             $curl = curl_init();
             curl_setopt_array($curl, array(
             CURLOPT_URL => $url,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => "",
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 30,
             CURLOPT_SSL_VERIFYPEER => false,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => "POST",
             CURLOPT_POSTFIELDS => urlencode($request_parameters),
             CURLOPT_FOLLOWLOCATION => 1,
             CURLOPT_HTTPHEADER => array(
              "Content-Type: application/json",
              "Authorization:".$partner_id.":".$base64_encoded_hmac_signature,
              "Date:".$gmt_date
            ),
          ));
          // $response = curl_exec($curl);
          // $err = curl_error($curl);
          // curl_close($curl);
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Payment Response :" . json_encode($err) . " \n\n";
            poslogs($log2);
            echo "cURL Response #:" . $err;
            } else {
            $log2 = "Application Log GP:".date("Y-m-d H:i:s") . " Payment Response :" . json_encode($response) . " \n\n";
            poslogs($log2);
            echo "cURL Response #:" . $response;
            }




?>