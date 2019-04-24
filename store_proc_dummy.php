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

// $db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

// //date_default_timezone_set("Asia/Hong_Kong");
date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_md5.function.php");
$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);
//print_r($db);exit;
//Create connection
$parameter_ins = array(
            "currency" => 'USD',
            "out_trade_no" => 'E000000120181114010050',
            "timestamp" => date('YmdHis'),
            "total_fee" =>'1',
            "mer_callback_url" => 'https://123.231.14.207:8080/AliPayCallBack/CallBack',
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d'),
            "cst_trans_datetime" => '20181114010050',
            "terminal_id" => 'E0000001',
            "transaction_type" => '1',
            "merchant_id" => 'E01010000000001'
        );
$extend_param = '{"secondary_merchant_name":"Lotte", "secondary_merchant_id":"123", "secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
$data_update = array(
            "big_pic_url" => 'http://mobilecodec.alipaydev.com/show.htm?code=bax087765b2vzqgqxbow00f8&amp;picSize=L',
            "out_trade_no" => 'E000000120181114010050',
            "pic_url" => 'http://mobilecodec.alipaydev.com/show.htm?code=bax087765b2vzqgqxbow00f8&amp;picSize=S',
            "qr_code" => 'https://qr.alipay.com/bax087765b2vzqgqxbow00f8',
            "result_code" => 'SUCCESS',
            "small_pic_url" =>'http://mobilecodec.alipaydev.com/show.htm?code=bax087765b2vzqgqxbow00f8&amp;picSize=S',
            "voucher_type" => 'qrcode',
            "is_success" => 'T',
            "input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "extend_params" => $extend_param,
            "notify_url" => $alipay_config['notify_url'],
            "partner" => '2088621911453772',
            "passback_parameters" => "success",
            "service" => $alipay_config['service-qr-pcr'],
            "sign" => 'og8qf0j66v2vlpjv0z4oyxtzoumowndp',
            "sign_type" => 'MD5',
            "timestamp" => date('YmdHis'),
            "total_fee" => '1',
            "trans_currency" => 'USD',
            "currency" => 'USD',
            "product_code" => 'OVERSEAS_MBARCODE_PAY',
            "subject" => 'Alipay_dynamic_qr',
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d'),
            "terminal_id" => 'E0000001',
        ); 
$id = 1;
//*****Insert*******

while($id <=69308){
	$insert_precreate = $db->insert('transaction_alipay_dump', $parameter_ins);


	if ($insert_precreate == TRUE) {
    echo "Inserted successfully  ".date('Y-m-d H:i:s').'<br>';
}

//*****Update*****
// 		$db->where("out_trade_no",'E000000120181114010052');
//         $db->where("transaction_type",1);
//         $record_check = $db->get('transaction_alipay_dump');
//         $count = count($record_check);
// while($id <= $count){
// 		$db->where("out_trade_no",'E000000120181114010052');
//         $db->where("transaction_type",1);
//         $trans_suc_update = $db->update('transaction_alipay_dump', $data_update);

// 	if ($trans_suc_update == TRUE) {
//     echo "Updated successfully  ".date('Y-m-d H:i:s').'<br>';
// }

//*******Display*****
// while($id <=10){
// 		$db->where("out_trade_no",'E000000120181114010050');
// 		$db->where("transaction_type",1);
//         $result = $db->getOne("transaction_alipay_dump");
//         $mer_callBack = $result['mer_callback_url'];
//         $merchant_id = $result['merchant_id'];
//         $partner = $result['partner'];
//         $sign_type = $result['sign_type'];
//         echo $mer_callBack.'<br>';
//         echo $merchant_id.'<br>';
//         echo $partner.'<br>';
//         echo $sign_type.'<br>';
// 	if ($result == TRUE) {
//     echo "Display successfully  ".date('Y-m-d H:i:s').'<br>';


// } 
$id++;
}



// Declare @Id int
// Set @Id = 1

// While @Id <= 12000
// Begin 
//    Insert Into tblAuthors values ('Author - ' + CAST(@Id as nvarchar(10)),
//               'Country - ' + CAST(@Id as nvarchar(10)) + ' name')
//    Print @Id
//    Set @Id = @Id + 1
// End
?>