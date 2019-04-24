<?php
foreach($_POST as $key=>$value)
{
    $postdata .= $key.'='.$value.''.PHP_EOL;
}
$log = date("Y-m-d H:i:sa") . "\n\n
--------------------\nAsynchrounous Notification Response :\n" . $postdata . " \n\n";
$myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

if($postdata!="") echo "success";

$duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
$dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

date_default_timezone_set("Asia/Hong_Kong");
require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$db = new Mysqlidb ($confighost, $userd, $passd, 'suprpaysez');

$data = Array (
    "extra_common_param" => $_POST['extra_common_param'], // $mmerch, // this should be ID of account using our gateway service
    "trade_no" => $_POST['trade_no'],
    "paytools_pay_amount" => $_POST['paytools_pay_amount'],
    "buyer_email" => $_POST['buyer_email'],
    "gmt_create" => $_POST['gmt_create'],
    "notify_type" => $_POST['notify_type'],
    "res_quantity" => $_POST['quantity'],
    "res_seller_id" => $_POST['seller_id'],
    "res_price" => $_POST['price'],
    "notify_time" => $_POST['notify_time'],
    "trade_status" => $_POST['trade_status'],
    "gmt_payment" => $_POST['gmt_payment'],
    "res_seller_email" => $_POST['seller_email'],
    "buyer_id" => $_POST['buyer_id'],
    "notify_id" => $_POST['notify_id'],
    "res_sign_type" => $_POST['sign_type'],
    "buyer_id" => $_POST['buyer_id'],
    "res_sign" => $_POST['sign']
);
$db->where("out_trade_no" , $_POST['out_trade_no']);
$db->update('transaction', $data);



?>
