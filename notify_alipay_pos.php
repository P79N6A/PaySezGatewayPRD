<?php
foreach($_POST as $key=>$value)
{
    $postdata .= $key.'='.$value.''.PHP_EOL;
}
$log = date("Y-m-d H:i:sa") . "\n\n  
--------------------\nAsynchrounous Notification Response :\n" . $postdata . " \n\n";
$myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG_vino.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

if($postdata!="") echo "success";

// $duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
// $dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

date_default_timezone_set("Asia/Hong_Kong");
require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
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
$db->update('transaction_alipay', $data);

// $log = "Testing Purpose";
// file_put_contents('/var/www/html/Spaysez/smsAPILOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

/**** Get the Merchant Details for Sending SMS Messages ****/
$db->where('out_trade_no',$_POST['out_trade_no']);
$merchantDet = $db->getone("transaction");

$merchantID     = (int)$merchantDet['merchant_id'];
$transtotal_fee = $merchantDet['total_fee'];
$transcurrency  = $merchantDet['currency'];
$transact_id    = $merchantDet['id_transaction_id'];
$transact_refno = $merchantDet['out_trade_no'];

$db->where('idmerchants',$merchantID);
$merchantCDet = $db->getone("merchants");
// $merchantCDet   = getMerchantDetailsbyId($merchantID);
$merchantPhone  = $merchantCDet['csphone'];
$merchantName   = $merchantCDet['merchant_name'];

$apikey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJmOTZmYmMzMC01ODQ0LTExZTgtYWU4MC1hMTk0ZTYzMWI4NDciLCJzdWIiOiJTSE9VVE9VVF9BUElfVVNFUiIsImlhdCI6MTUyNjM5MTM5MCwiZXhwIjoxODQyMDEwNTkwLCJzY29wZXMiOnsiYWN0aXZpdGllcyI6WyJyZWFkIiwid3JpdGUiXSwibWVzc2FnZXMiOlsicmVhZCIsIndyaXRlIl0sImNvbnRhY3RzIjpbInJlYWQiLCJ3cml0ZSJdfSwic29fdXNlcl9pZCI6IjE3ODQiLCJzb191c2VyX3JvbGUiOiJ1c2VyIiwic29fcHJvZmlsZSI6ImFsbCIsInNvX3VzZXJfbmFtZSI6IiIsInNvX2FwaWtleSI6Im5vbmUifQ.WyA-2bDKJpIY-miSuY3pO90fx6E5n8RGv2-rc3yRJXg';
$source  = 'Esol';
$message = $merchantName.', TransId:'.$transact_id.', RefNo:'.$transact_refno.', Trade Finished Successfully, Amount '.$transcurrency.$transtotal_fee;
$number  = $merchantPhone; // '919791783537'; //'94777759173';
$ch = curl_init("http://anankesms.com/smsservice/send?message=".urlencode($message)."&number=".$number."&source=".$source."&api_key=".$apikey);
if (!$ch) {
    die("Couldn't initialize a cURL handle");
}
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$curlresponse = curl_exec($ch);

$log = "\r\n".date("Y-m-d H:i:sa") . "\n".$curlresponse."
-----------------------------------\n".$message."\n";
file_put_contents('/var/www/html/Spaysez/smsAPILOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

curl_close($ch);

?>
