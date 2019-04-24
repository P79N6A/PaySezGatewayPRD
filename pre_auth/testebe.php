<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once("MysqliDb.php");
require_once("encrypt.php");
require_once("alipayconfig.php");
require_once("lib/alipay_submit_class.php");

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);
		
$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

$log_path = $alipay_config['log-path'];

/** Log File Function starts **/
function poslogs($log) {
	GLOBAL $log_path;
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}
$merchant_id='482';

 $db->where('merchant_id',$merchant_id);
 $db->where('terminal_id','NULL','!=');
//$query = "SELECT * FROM users WHERE merchant_id='$merchant_id' AND  terminal_id!='NULL' ";
//$merchant_details=$db->rawQuery($query);
$merchant_details = $db->get("users");
//$user_type=$merchant_details['user_type'];


//echo "<pre>";
//print_r($db);
//die();
 // if($terminal_id !='NULL' && $user_type=='5')
 // {
// $Merchant_Name = $merchant_details['username'];
// $customer_phone_No = $merchant_details['phone'];
// $customer_email_id = $merchant_details['email_address'];
// $terminal_id = $merchant_details['terminal_id'];


// echo "<pre>";
// print_r($merchant_details);

foreach($merchant_details as $Merchant)
{
	$Merchant_Name=$Merchant['username'];
	$customer_phone_No = $Merchant['phone'];
	$customer_email_id = $Merchant['email_address'];
	$terminal_id = $Merchant['terminal_id'];

echo $Merchant_Name;
echo "<pre>";
echo $customer_phone_No;
echo "<pre>";
echo $customer_email_id;
echo "<pre>";
echo $terminal_id;
echo "<pre>";
echo "<br><br>";
}
// echo $Merchant_Name;
// echo "<pre>";
// echo $customer_phone_No;
// echo "<pre>";
// echo $customer_email_id;
// echo "<pre>";
// echo $terminal_id;
// echo "<pre>";
// print_r($customer_phone_No);
// echo "<pre>";
// print_r($customer_email_id);
// echo "<pre>";
// print_r($terminal_id);
// }
// else
// {
// 	echo "terminal id is NULL";
// }

?>