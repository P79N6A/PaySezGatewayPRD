<?php
session_start();
//$d = $_SERVER['DOCUMENT_ROOT'];
$serv_url = $_SERVER['HTTP_HOST'];
$serv_path = dirname(__FILE__);
$_SESSION['d']= 'test';
///$url = 'paymentgateway.test.credopay.in/var/www/html/Spaysez';
$total_url= $c.$e;
if (preg_match("/Spaysez/", $total_url))
{
	echo "the url $my_url contains Spaysez";
}
else
{
	echo "the url $my_url does not contain Spaysez";
}


// $my_url = "www.guru99.com";
// if (preg_match("/guru/", $my_url))
// {
// 	echo "the url $my_url contains guru";
// }
// else
// {
// 	echo "the url $my_url does not contain guru";
// }


?>