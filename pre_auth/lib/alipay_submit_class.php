<?php

require_once("alipayconfig.php");

class AlipaySubmit {
	private $query_array;
	var $alipay_config;
	var $alipay_gateway_new = 'https://openapi.alipaydev.com/gateway.do?';
	
	function __construct($alipay_config){
		$this->alipay_config = $alipay_config;
	}
	function AlipaySubmit($alipay_config) {
		$this->__construct($alipay_config);
	}

	function createLinkstring($parameter) {
		ksort($parameter);
		$arg  = "";
		// while (list ($key, $val) = each ($parameter)) {
		foreach ($parameter as $key => $val) {
			$arg.=$key."=".$val."&";
		}
		//remove the last &
		// $arg = substr($arg,0,count($arg)-2);
		$arg = substr($arg,0,-1);

		//remove escape character if there's any
		if(get_magic_quotes_gpc()) { 
			$arg = stripslashes($arg);
		}
		return $arg;
	}

	function rsaSign($parameter, $private_key_path) {
	
		$build=$this->createLinkstring($parameter);
		$private_key_path='key/rsa_private_key.pem';
		$priKey = file_get_contents($private_key_path);
		$res = openssl_get_privatekey($priKey);
		openssl_sign($build, $sign, $priKey, OPENSSL_ALGO_SHA256);
		openssl_free_key($res);
		$sign1 = base64_encode($sign);

		return $sign1;
	}

	function build_http_query( $parameter,$private_key_path) { 
		$urlencode=$this->rsaSign($parameter, $private_key_path);
		ksort($parameter);
		$parameter['sign']=$urlencode;
		$this->query_array = array();
	
		foreach( $parameter as $key => $key_value ) {
			$this->query_array[] = $key . '=' . urlencode( $key_value );
		}
	
		$data = implode('~', $this->query_array );
		$data = htmlspecialchars_decode($data);

		$log =  " Pre-create payment Response POS:" .date("Y-m-d H:i:s") . "=>".$data."\n\n";
		poslogs($data);

		$data = str_replace("~", "&", $data);

		$log =  " Pre-create payment Response POS:" .date("Y-m-d H:i:s") . "=>".$data."\n\n";
		poslogs($data);
		// print_r($data);
		// die();
		return $data ;
	}

}
?>