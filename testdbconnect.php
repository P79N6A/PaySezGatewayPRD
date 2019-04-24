<?php
/* *
 * 功能：境外收单交易接口接入页
 * 版本：3.4
 * 修改日期：2016-03*08
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 *function:the access page of cross border payment interface 
 *version:3.4
 *modify date:2016-03-08
 *instructions:
 *This code below is a sample demo for merchants to do test.Merchants can refer to the integration documents and write your own code to fit your website.Not necessarily to use this code.  
 *Alipay provide this code for you to study and research on Alipay interface, just for your reference.

 *************************注意*****************
 
 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 *1、支持中心（https://global.alipay.com/service/service.htm）
 *2、支持邮箱（overseas_support@service.alibaba.com）
     业务支持邮箱(global.service@alipay.com)


 *如果想使用扩展功能,请按文档要求,自行添加到parameter数组即可。
 **********************************************
 *If you have problem during integration，we provide the below ways to help 
  
  *1、Development documentation center（https://global.alipay.com/service）
  *2、Technical assitant email（overseas_support@service.alibaba.com）
      Business assitant email (global.service@alipay.com)
  
  *If you want to use the extension,please add parameters according to the documentation.
 */

// $duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
// $dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$db = new Mysqlidb ($confighost, $userd, $passd, 'testSpaysez');
//mysqli_close($db);
// Check connection
if (!$db) {
    $connection_error = array(
                "transaction_status" => 'Server Error',
                "out_trade_no" => '123456',
                "terminal_id" => '11111111',
                "amount" => '2'
            );

            $con_err_res = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($connection_error) . " \n\n";
        $myfile = file_put_contents('/var/www/html/testspaysez/api/alipaytranLOG.log', $con_err_res . PHP_EOL, FILE_APPEND | LOCK_EX);

            $con_err_res_encode = json_encode($connection_error);
            header('Content-Type: application/json');
            echo $con_err_res_encode;
    die('Could not connect: ' . mysqli_error());
}
$mer_map_id = 'M00301110001000';
$db->where('mer_map_id',$mer_map_id);
$res = $db->getOne('merchants');
$pcrq = $res['pcrq'];
$str = explode("~",$pcrq);
$count = count($str);
//echo $count;
//echo $str[0] ;
print_r($str);
// for($i=0,$i<$count;$i++){


//  $str_data = 1;

// switch ($str_data) {
//     case "pay":
//  if (in_array("Glenn", $str[$i]))
//   {
//   echo "Match found";
//   }
//         break;
//     case "cancel":
//         echo "Your favorite color is blue!";
//         break;
//     case "refund":
//         echo "Your favorite color is green!";
//         break;
//     case "query":
//         echo "Your favorite color is green!";
//         break;
//     default:
//         echo "Your favorite color is neither red, blue, nor green!";
// }

// }










?>