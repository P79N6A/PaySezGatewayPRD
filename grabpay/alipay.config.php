<?php


//$alipay_config['partner']		= '2088621891276675';
$alipay_config['partner']		= '2088621891278220';

//$alipay_config['partner-qr']		= '2088231446546560'; //production
$alipay_config['partner-qr']		= '2088621911453772'; //test

//partner id = 2088031422140881

/* Log file path config*/

//$alipay_config['log-path']		= '/var/www/html/Spaysez/suprpaysezLOG.log'; //production
$alipay_config['log-path']		= '/var/www/html/testspaysez/grabpay/alipaytranLOG.log'; //test

/*Log file path UPI */

//$upi_config['log-path']  = '/var/www/html/Spaysez/api/mer_services_log.log'; //production
//$upi_config['log-path']  = '/var/www/html/testspaysez/api/mer_services_test_log.log'; //test

/* DB config */
//$alipay_config['dataBase_con']		= 'grabpay'; //production
$alipay_config['dataBase_con']		= 'testSpaysez'; //test

/*POS terminal ACK response ACK_url - ack notify url */
//$alipay_config['ack_url]		= 'https://paymentgateway.test.credopay.in/Spaysez/terminal_response.php'; //production
$alipay_config['ack_url']		= 'https://paymentgateway.test.credopay.in/testspaysez/terminal_response.php'; //test

// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://globalprod.alipay.com/order/myOrder.htm, see key
//MD5 key . The security check code, 32 bit string composed of numbers and letters.See your key at https://globalprod.alipay.com/order/myOrder.htm
//$alipay_config['key']			= '6cgz2arb7djrp0ohrcz580a4sl1n0pfz';
$alipay_config['key']			= 'x017pu0k7eunv1azw69w5tyoafr36w46';

//$alipay_config['key-qr']			= '6o3b4dubtf8olusby6hkwg8vk299cz2t'; // Production
$alipay_config['key-qr']			= 'og8qf0j66v2vlpjv0z4oyxtzoumowndp'; // Test

// 服务器异步通知页面路径  ,不能加?id=123这类自定义参数，必须外网可以正常访问
//Page for receiving asynchronous Notification. It should be accessable from outer net.No custom parameters like '?id=123' permitted.
$alipay_config['notify_url'] ="http://169.38.91.246/testspaysez/grabpay/notify_alipay.php";	

$alipay_config['alipay_url'] = "https://openapi.alipaydev.com/gateway.do?"; //test
//$alipay_config['alipay_url'] = "https://intlmapi.alipay.com/gateway.do?"; //Production

//$alipay_config['notify_url'] = "http://商户网址/create_forex_trade-PHP-UTF-8-MD5-new/notify_url.php";

// 页面跳转同步通知页面路径 需http(s)://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
 //Page for synchronous notification.It should be accessable from outer net.No custom parameters like '?id=123' permitted.
$alipay_config['return_url'] = "http://169.38.91.246/fbtest.php";
//product_code
$alipay_config['product_code'] ='OVERSEAS_MBARCODE_PAY';

//签名方式
//sign_type
$alipay_config['sign_type']    = strtoupper('MD5');

//字符编码格式 目前支持 gbk 或 utf-8
// input_charset   gbk and utf-8 are supported now.
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验,在verify_nofity中使用
//请保证cacert.pem文件在当前文件夹目录中
//The path of ca certificate,used to check ssl of curl in verify_notify
//make sure cacert.pem is at the current working directory
$alipay_config['cacert']    = getcwd().'\\cacert.pem'; 

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
//Access mode,choose https if your server support ssl and use http if not
$alipay_config['transport']    = 'https';//'http';
		
// 产品类型，无需修改
//Service name of the interface.No need to modify.
$alipay_config['service'] = "create_forex_trade";

$alipay_config['service-re'] = "forex_refund";

$alipay_config['service-qr-cr'] = "alipay.acquire.create";

$alipay_config['service-qr-cl'] = "alipay.acquire.cancel";

$alipay_config['service-qr-pcr'] = "alipay.acquire.precreate";

$alipay_config['service-re-qr'] = "alipay.acquire.overseas.spot.refund";

$alipay_config['service-qy-qr'] = "alipay.acquire.overseas.query";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
//↑↑↑↑↑↑↑↑↑↑Please configure your basic information here↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑		
?>