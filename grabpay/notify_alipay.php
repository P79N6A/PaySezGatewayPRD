<?php

//date_default_timezone_set("Asia/Hong_Kong");
date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");
/** Log File Function starts **/
function poslogs($path,$log) {
$myfile = file_put_contents($path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}
/**  Log File Function Ends **/
foreach($_POST as $key=>$value)
{
    //$postdata .= $key.'='.$value.''.PHP_EOL;
  $postdata .= $key.'='.$value.', ';
}
$log = date("Y-m-d H:i:s") . " Asynchrounous Notification Response POS :" . $postdata . " \n\n";
poslogs($alipay_config['log-path'], $log);

if($postdata!="") echo "success";

// $duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
// $dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";


require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
require_once('../api/encrypt.php');
// require_once("alipay.config.php");
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);
//print_r($db);exit;
$data = Array (
    "extra_common_param" => $_POST['extra_common_param'], // $mmerch, // this should be ID of account using our gateway service
    "trade_no" => $_POST['trade_no'],
    "subject" => $_POST['subject'],
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
$db->where("out_trade_no" , $_POST['out_trade_no']);
$trans_type = $db->getone("transaction_alipay");
$tran_req_type = $trans_type['transaction_type'];
$terminal_id = $trans_type['terminal_id'];
$currency = $trans_type['currency'];
$total_fee = $trans_type['total_fee'];
$callback_url_pos = $trans_type['mer_callback_url'];

// $callUrl = date("Y-m-d H:i:sa") . "\n---------------------\n Call Back URL:\n" . $callback_url_pos . " \n\n";
//     $myfile = file_put_contents($alipay_config['log-path'], $callUrl . PHP_EOL, FILE_APPEND | LOCK_EX);

$response_data = array(
    "out_trade_no" => $_POST['out_trade_no'],
    "transaction_status" => $_POST['extra_common_param'],
    "terminal_id" => $terminal_id,
    "tran_req_type" => $tran_req_type,
    "currency" => $currency,
    "amount" => $total_fee,
    "ack_notify_url" => $alipay_config['ack_url']
);
$enco = json_encode($response_data);

if($tran_req_type == 1 || $tran_req_type == 's1') {
//"https://123.231.14.207:8080/AliPayCallBack/CallBack",//"http://220.247.222.76:8080/AliPayCallBack/CallBack",

    /*** Call back url for both Static and Dynamic from Async response "subject" ***/

    if($_POST['subject'] == 'Alipay_Static_QR') {
      $callback_pos = "https://123.231.14.207:8080/AliPayCallBack/CallBack";
      $callback_pos_exp = explode(":", $callback_pos);
      $callback_pos_port = substr($callback_pos_exp[2], 0, 4);
    } else {
      $callback_pos = $callback_url_pos;
      $callback_pos_exp = explode(":", $callback_pos);
      $callback_pos_port = substr($callback_pos_exp[2], 0, 4);
    }

    // $callUrl = date("Y-m-d H:i:s")  . " Call Back URL:" . $callback_pos . " \n\n";
    //     poslogs($alipay_config['log-path'], $callUrl);

    $Async_succs = date("Y-m-d H:i:s")  . " Async response log send to pos:" . json_encode($response_data) . " \n\n";
    poslogs($alipay_config['log-path'], $Async_succs);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => $callback_pos_port,
      CURLOPT_URL => $callback_pos,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $enco,
      CURLOPT_FOLLOWLOCATION => 1,
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "Content-Length:".strlen($enco)
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      //echo $response;
    }
   
    exit;
}
//https://paymentgateway.test.credopay.in/Spaysez/response.php?json={%22out_trade_no%22:%2212344%22,%22transaction_status%22:%22succ%22,%22terminal_id%22:%22678%22,%22tran_req_type%22:%225%22}
// $resp = date("Y-m-d H:i:sa") . "\n\n--------------------\nAsynchrounous Success Transaction :\n" . json_encode($response_data) . " \n\n";
// $myfile = file_put_contents($alipay_config['log-path'], $resp . PHP_EOL, FILE_APPEND | LOCK_EX);
//print_r($response_data);exit;die();
// if($_POST['trade_status'] == 'TRADE_SUCCESS'){
// // header("Refresh:0; url=" . $qrImage)
//     //123.231.14.207:8088/AliPayCallBack/CallBack
//     "Refresh:0; url=" . $qrImage
//     

// }
/**** Get the Merchant Details for Sending SMS Messages ****/
// $db->where('out_trade_no',$_POST['out_trade_no']);
// $merchantDet = $db->getone("transaction_alipay");

// $merchantID     = (int)$merchantDet['merchant_id'];
// $transtotal_fee = $merchantDet['total_fee'];
// $transcurrency  = $merchantDet['currency'];
// $transact_id    = $merchantDet['id_transaction_id'];
// $transact_refno = $merchantDet['out_trade_no'];

// $db->where('idmerchants',$merchantID);
// $merchantCDet = $db->getone("merchants");
// // $merchantCDet   = getMerchantDetailsbyId($merchantID);
// $merchantPhone  = $merchantCDet['csphone'];
// $merchantName   = $merchantCDet['merchant_name'];

// $apikey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJmOTZmYmMzMC01ODQ0LTExZTgtYWU4MC1hMTk0ZTYzMWI4NDciLCJzdWIiOiJTSE9VVE9VVF9BUElfVVNFUiIsImlhdCI6MTUyNjM5MTM5MCwiZXhwIjoxODQyMDEwNTkwLCJzY29wZXMiOnsiYWN0aXZpdGllcyI6WyJyZWFkIiwid3JpdGUiXSwibWVzc2FnZXMiOlsicmVhZCIsIndyaXRlIl0sImNvbnRhY3RzIjpbInJlYWQiLCJ3cml0ZSJdfSwic29fdXNlcl9pZCI6IjE3ODQiLCJzb191c2VyX3JvbGUiOiJ1c2VyIiwic29fcHJvZmlsZSI6ImFsbCIsInNvX3VzZXJfbmFtZSI6IiIsInNvX2FwaWtleSI6Im5vbmUifQ.WyA-2bDKJpIY-miSuY3pO90fx6E5n8RGv2-rc3yRJXg';
// $source  = 'Esol';
// $message = $merchantName.', TransId:'.$transact_id.', RefNo:'.$transact_refno.', Trade Finished Successfully, Amount '.$transcurrency.$transtotal_fee;
// $number  = $merchantPhone; // '919791783537'; //'94777759173';
// $ch = curl_init("http://anankesms.com/smsservice/send?message=".urlencode($message)."&number=".$number."&source=".$source."&api_key=".$apikey);
// if (!$ch) {
//     die("Couldn't initialize a cURL handle");
// }
// curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
// $curlresponse = curl_exec($ch);

// $log = "\r\n".date("Y-m-d H:i:sa") . "\n".$curlresponse."
// -----------------------------------\n".$message."\n";
// file_put_contents('/var/www/html/Spaysez/smsAPILOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

// curl_close($ch);

?>