
<?php

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
?>
<script>
  // generate random variables for the request
//var timestampString = new Date().toGMTString();
var msgID = 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });
var partnerTxID = 'partner-xxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });

<?php $msgID = "<script>document.write(msgID)</script>";?>   
<?php $partnerTxID = "<script>document.write(partnerTxID)</script>";?>


 </script>
 <?php 

//echo $msgID;exit;
$url ="https://partner-api.stg-myteksi.com?";
$url_dup ="https://partner-api.stg-myteksi.com"; 
$pay_order_url_string ="/grabpay/partner/v1/terminal/qrcode/create";
$url_curl =$url_dup.$pay_order_url_string; 
$method_type ="POST";
$content_type = "application/json";
$gmt_date = gmdate('D, d M Y H:i:s T');//"Thu, 07 Mar 2019 07:04:24 GMT";
$amount ="100";
//$partnerTxID ='';
// $msgID ='';
$grabID ='520499d9-be82-422c-a6da-e4f5eeb6019e';
$partner_id ='1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
$partner_secret ='UcEYLPlrSpqWeZeW';
$terminal_id ='54f50424894fe164971a3020f';
$currency="SGD";

// $req_parameter_arr = array(
// "amount" => $amount,
// "msgID" => $msgID,
// "grabID" => $grabID,
// "terminalID" => $terminal_id,
// "currency" => $currency,
// "partnerTxID" => $partnerTxID
// );
$req_parameter_arr_json = "{\n\t\"amount\":".$amount.",\n\t\"msgID\":\"".$msgID."\",\n\t\"grabID\":\"".$grabID."\",\n\t\"terminalID\":\"".$terminal_id."\",\n\t\"currency\":\"".$currency."\",\n\t\"partnerTxID\":\"".$partnerTxID."\"\n}";



//$req_parameter_arr_json = json_encode($req_parameter_arr);
// $req_parameter_arr_json = '{"amount":'.$amount.',"msgID":"'.$msgID.'","grabID":"'.$grabID.'","terminalID":"'.$terminal_id.'","currency":"'.$currency.'","partnerTxID":"'.$partnerTxID.'",}';
//echo $req_parameter_arr_json;exit;

//$content_digest_hash = hash("SHA256", $req_parameter_arr_json);

$content_digest_base = base64_encode(hash("SHA256", $req_parameter_arr_json,true));

//echo $content_digest_base;exit;
//echo "<br><br>";
// "{\namount: 100,\nmsgID: 4704dd63b5224f729017e7af8f7c5353,grabID: \"84dfaba5-7a1b-4e91-aa1c-f7ef93895266\",\n    \"terminalID\": \"b010f1c9fb724de4962d6f23c5c96afd\",\n    \"currency\": \"SGD\",\n    \"partnerTxID\": \"partner-f3014a059db67bc11e212bba\"\n}"

$string_to_sign = $method_type."\n".$content_type."\n".$gmt_date."\n".$pay_order_url_string."\n".$content_digest_base."\n";

// $string_to_sign = nl2br($method_type.' '."\n".$content_type.' '."\n".$gmt_date.' '."\n".$pay_order_url_string.' '."\n".$content_digest_base."\n");

//echo $string_to_sign;
//echo "<br><br>";

//$hmac_signature = ;
// echo $hmac_signature.'<br>';exit;
$hmac_sign =hash_hmac("SHA256", $string_to_sign,$partner_secret,true);
$base64_encoded_hmac_signature = base64_encode($hmac_sign);


//echo $base64_encoded_hmac_signature.'<br>';exit;

$authorization = $partner_id.':'.$base64_encoded_hmac_signature;
$request_url = "Application Log GP:".date("Y-m-d H:i:s") . " GP Request URL:" . $url_curl . " \n\n";
poslogs($request_url);

$request_parameter_before_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Request Parameter Before Build:" .$req_parameter_arr. " \n\n";
poslogs($request_parameter_before_GP);

$request_parameter_after_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Request Parameter After Build:" .$req_parameter_arr_json. " \n\n";
poslogs($request_parameter_after_GP);

$content_digest_hash_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Conten Digest Before base64_encode:" .$req_parameter_arr_json. " \n\n";
poslogs($content_digest_hash_GP);

$content_digest_sha256_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Conten Digest After  :" .$content_digest_hash. " \n\n";
poslogs($content_digest_sha256_GP);

$content_digest_base64_encode= "Application Log GP:".date("Y-m-d H:i:s") . " Conten Digest After base64_encode :" .$content_digest_base. " \n\n";
poslogs($content_digest_base64_encode);

$string_to_sign_GP= "Application Log GP:".date("Y-m-d H:i:s") . " String to sign:" .$string_to_sign. " \n\n";
poslogs($string_to_sign_GP);

$hmac_signature_GP= "Application Log GP:".date("Y-m-d H:i:s") . " HMAC Signature Before  :" .$partner_secret.'+'.$string_to_sign. " \n\n";
poslogs($hmac_signature_GP);

$hmac_digest_GP= "Application Log GP:".date("Y-m-d H:i:s") . " hmac digest After :" .$hmac_digest. " \n\n";
poslogs($hmac_digest_GP);

$authorization_GP= "Application Log GP:".date("Y-m-d H:i:s") . " Authorization  :" .$authorization. " \n\n";
poslogs($authorization_GP);



$hmac_signature_after_GP= "Application Log GP:".date("Y-m-d H:i:s") . " HMAC Signature After base64_encode :" .$base64_encoded_hmac_signature. " \n\n";
poslogs($hmac_signature_after_GP);

// $partner_id_Gp = "Application Log GP:".date("Y-m-d H:i:s") . " Partner Id:" .($partner_id) . " \n\n";
// poslogs($partner_id_Gp);

// $request_parameter_GP = "Application Log GP:".date("Y-m-d H:i:s") . " Partner_id:" .($request_parameters) . " \n\n";
// poslogs($request_parameter_GP);

$curl_header = "Application Log GP:".date("Y-m-d H:i:s")  .  " Curl Header Data:"  ."Content-Type:" .$content_type. ",Authorization:" .$authorization.",Date:".$gmt_date. "\n\n";
poslogs($curl_header);

$curl_post_fields = "Application Log GP:".date("Y-m-d H:i:s")  .  " Curl Post Fields Data:"  ."URL:" .$url_curl. ",Request_type:" .$method_type.",PostFields:".$request_parameter_array. "\n\n";
poslogs($curl_post_fields);


$curl = curl_init();
             curl_setopt_array($curl, array(
             CURLOPT_URL => $url_curl,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => "",
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 30,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => "POST",
             CURLOPT_POSTFIELDS => $req_parameter_arr_json,
             CURLOPT_FOLLOWLOCATION => 1,
             CURLOPT_HTTPHEADER => array(
              "Authorization:".$authorization,
              "Date:".$gmt_date,
              "Content-Type:".$content_type
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
