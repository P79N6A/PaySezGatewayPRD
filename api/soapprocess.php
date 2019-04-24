<?php
/**
 * Created by PhpStorm.
 * User: GCCOE_01
 * Date: 30-12-2017
 * Time: 11:05 AM
 */

$xml=$_POST['xml'];
$xml=urldecode($xml);
$wsdlurl=$_POST['wsdlurl'];
$wsdlurl=urldecode($wsdlurl);
//SOAP API Call (CHECKBIN)

$url = $wsdlurl;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$headers = array();
array_push($headers, "Content-Type: text/xml; charset=utf-8");
array_push($headers, "Accept: text/xml");
array_push($headers, "Cache-Control: no-cache");
array_push($headers, "Pragma: no-cache");
array_push($headers, "Connection: keep-alive");
array_push($headers, "User-Agent: PHP 7.0.22");

array_push($headers, "SOAPAction: https://paysecure/merchant.soap/CallPaySecure");
if($xml != null) {
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
array_push($headers, "Content-Length: " . strlen($xml));
}
curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); /* If required */
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$response222=$response;
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
/* if($env!="testm" && $env!="livem") {
$log = date("Y-m-d H:i:sa") . "\n\n
-----------------------------------\n\n" . $xml . "\n\n";
$myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
}
else {
$log = date("Y-m-d H:i:sa") . "\n\n
-----------------------------------\n\n" . $xml . "\n\n";
$myfile = file_put_contents('merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
}

if ($env != "testm" && $env != "livem") {
    $log = date("Y-m-d H:i:sa") . "\n\n
-----------------------------------\n\n" . $response . "\n\n";
    $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
} else {
    $log = date("Y-m-d H:i:sa") . "\n\n
-----------------------------------\n\n" . $response . "\n\n";
    $myfile = file_put_contents('merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
}
*/
print_r($response);
?>