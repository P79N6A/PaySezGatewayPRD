<?php

header('Content-Type: text/html; charset=UTF-8');
// $a= 'merchant test';
// echo $a;exit;
$postData = file_get_contents('php://input');


$post = utf8_decode(urldecode($postData));

 $log_path = '/var/www/html/testspaysez/api/mer_services_test_log.log';

function poslogs($log) {
        GLOBAL $log_path;
        $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
        return $myfile;     
}
// $url = "https://paymentgateway.test.credopay.in/testspaysez/mer_services_test.php";
// $xml = simplexml_load_file($url);


poslogs($post);

 // $merchantVaddr = (string) $post->merchantVaddr;
 // echo $merchantVaddr;

$xml = simplexml_load_string($post);
$merchantVaddr = (string) $xml->txnInfo->merchantDetails->merchantVaddr;

if (isset($post) && ($merchantVaddr)) {
$xml_new='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<MerchantWebSvcRes>
	<SvcHeader>
		<txnOrigin>TES</txnOrigin> <!--merchant name -->
	</SvcHeader>
	<txnInfo>
		<errCode>000</errCode>
		<errDesc>SUCCESS</errDesc>
		<merchantDetails>
			<merchantID>CUBM0001</merchantID>
			<mobileNumber>8754097479</mobileNumber>
			<merchantVaddr>vino.kumar226@okicici</merchantVaddr>
		</merchantDetails>
		<ReqType>Create_VPA</ReqType>
		<status>SUCCESS</status>
	</txnInfo>
</MerchantWebSvcRes>';
echo $xml_new;
}
else {
	echo "No data";
}

?>