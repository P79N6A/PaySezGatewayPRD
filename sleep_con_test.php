<?php
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

include_once('php/db_connect.php');
$conn = connect();
//$conn = ConnectionFactory::getFactory()->getConnection();
//var_dump($conn);exit();

require_once('php/MysqliDb.php');
//require_once('php/ConnectionFactory.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

// $db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

// //date_default_timezone_set("Asia/Hong_Kong");
date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_md5.function.php");

$db = new Mysqlidb ('10.162.104.214', 'pguat', 'pguat', 'testSpaysez');
 $merchantGet = $db->get('alipay_config');
echo $merchantGet[0]['merchant_id'];
sleep(40);


?>