<?php 
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");

$log_path = $alipay_config['log-path'];

/* Log File Function starts */
function poslogs($log) {
   GLOBAL $log_path;
$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}

$terminal_id = $_GET['terminal_id'];
$callback_notify_url = $_GET['callback_notify_url'];
$out_trade_no = $_GET['out_trade_no'];
$tran_req_type =$_GET['tran_req_type'];
$amount = $_GET['amount'];
$currency =$_GET['currency'];

$array_details = array(
"terminal_id" => $terminal_id,
"amount" => $amount,
"callback_notify_url" => $callback_notify_url,
"out_trade_no" => $out_trade_no,
"tran_req_type" => $tran_req_type,
"currency" => $currency
);

$log1 = "Application Log for post_data time checking:".date("Y-m-d H:i:s") . " Time Checking:" . json_encode($array_details). " \n\n";
        poslogs($log1);



?>