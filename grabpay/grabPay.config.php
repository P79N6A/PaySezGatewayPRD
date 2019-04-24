<?php



/* DB config */
//$alipay_config['dataBase_con']		= 'suprpaysez'; //production
$grabpay_config['dataBase_con']		= 'testSpaysez'; //test


//$grabpay_config['notify_url'] ="http://169.38.91.246/testspaysez/grabpay/notify_url.php";

$grabpay_config['log-path']= '/var/www/html/testspaysez/grabpay/GrabPay.log'; //test

$grabpay_config['url'] = "https://partner-api.stg-myteksi.com";//test
//$grabpay_config['url'] = "https://partner-gateway.grab.com";//live
$grabpay_config['pay_order_url_string'] = "/grabpay/partner/v1/terminal/qrcode/create";


//Service name of the interface.No need to modify.
$grabpay_config['method_type'] = "POST";
$grabpay_config['refund_method_type'] = "PUT";
$grabpay_config['cancel_method_type'] = "PUT";
$grabpay_config['inquiry_method_type'] = "GET";
$grabpay_config['content_type'] = "application/json";
$grabpay_config['query_content_type'] = "application/x-www-form-urlencoded";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
//↑↑↑↑↑↑↑↑↑↑Please configure your basic information here↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑		
?>