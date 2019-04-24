<?PHP

$alipay_config['partner']		= '2088621898856371';//'2088621911512174';//'2088621891276675';

$alipay_config['private_key_path']	= 'key/rsa_private_key.pem';

$alipay_config['ali_public_key_path']= 'key/sandbox_alipay_public_key.pem';

$alipay_config['notify_url'] ="https://paymentgateway.test.credopay.in/testspaysez/pre_auth/notify_url.php";//"/var/www/html/testspaysez/pre_auth/notify_url.php";

$alipay_config['log-path']='/var/www/html/testspaysez/pre_auth/pre_auth.log';	// '/var/www/html/testspaysez/preauth/preauth.log'; //test

//$alipay_config['return_url'] = "C:/wamp64/www/ebe/pre_auth/return_url.php";

/* DB config */
//$alipay_config['dataBase_con']		= 'suprpaysez'; //production
$alipay_config['dataBase_con']		= 'testSpaysez'; //test

	//sign_type
$alipay_config['sign_type'] = strtoupper('RSA2');

	// input_charset   gbk and utf-8 are supported now.
$alipay_config['charset']=strtoupper('UTF-8');
//The path of ca certificate,used to check ssl of curl in verify_notify
//make sure cacert.pem is at the current working directory
//$alipay_config['cacert']    = getcwd().'\\cacert.pem'; 

//Access mode,choose https if your server support ssl and use http if not
$alipay_config['transport']    = 'http';
		
//Service name of the interface.No need to modify.
// $alipay_config['service'] = "create_forex_trade";

?>