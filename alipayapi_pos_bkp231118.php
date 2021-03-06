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
if($_POST['from']!="pg"){ }
/**************************请求参数**************************/
/**************************request parameter**************************/
//商户订单号，商户网站订单系统中唯一订单号，必填
//merchant order no,the unique transaction ID specified in merchant system ,not null

/* Json format decode */
// $json = file_get_contents('https://paymentgateway.test.credopay.in/Spaysez/alipayapi_pos.php');
// $obj = json_decode($json);
// $obj->$out_trade_no;
$out_trade_no = $_POST['out_trade_no'];//$_POST['WIDout_trade_no'];
$terminal_id = $_POST['terminal_id'];
//订单名称，必填
//order name  ,not null
$subject = 'Alipay_Dynamic_QR';//$_POST['WIDsubject'];

//付款外币币种，必填
//The settlement currency code the merchant specifies in the contract. ,not null
$currency = $_POST['currency'];

//付款外币金额，必填
//payment amount in foreign currency ,not null
$total_fee = $_POST['amount'];
$terminal_timestamp = $_POST['terminal_timestamp'];
$callback_notify_url = $_POST['callback_notify_url'];
// $_SESSION['callback'] = $callback_notify_url;
//商品描述，可空
//product description ,nullable
$body = $_POST['WIDbody'];
$secondary_merchant_id = $_POST['secondary_merchant_id'];
$secondary_merchant_industry = $_POST['secondary_merchant_industry'];
$secondary_merchant_name = $_POST['secondary_merchant_name'];
//product_code
$product_code ='OVERSEAS_MBARCODE_PAY'; //$_POST['WIDproduct_code'];
$split_fund_info = $_POST['WIDsplit_fund_info'];
//************************************************************/
$terminal_empty = "Terminal Id Received Empty From POS";
$terminal_wrong = "Terminal Id Wrong";

/* terminal & merchant validation starts */
    if($_POST['terminal_id']!="") {
            $db->where("mso_terminal_id",$_POST['terminal_id']);
            $terminal_res = $db->getOne("terminal");
            $terminalIdds = $terminal_res['mso_terminal_id'];
            $terminal_active = $terminal_res['active']; 
            $ter_act = array(
                'terminal_id'=> $terminalIdds,
                'active' => $terminal_active
            );
            if($terminalIdds != "" && $terminal_active == 1){
                $merchant_id  = $terminal_res['idmerchants'];
                $mso_location = $terminal_res['mso_ter_location'];
            }else if($terminalIdds != "" && $terminal_active != 1){
                $terminal_active_sts = "POS Terminal Acive Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nTerminal Not Active Id:\n" .json_encode($ter_act). " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $terminal_active_sts . PHP_EOL, FILE_APPEND | LOCK_EX);
                echo 'Terminal Id Not Active';
                exit;
                die();
            }else {
                $terminal_id_empty = "POS terminal Id wrong Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived wrong terminal From pos:\n" .$terminal_wrong. " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $terminal_id_empty . PHP_EOL, FILE_APPEND | LOCK_EX);
                echo 'Terminal Id Wrong';
                die();
            }
        } else {
                $terminal_id_empty = "POS terminal check Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived empty terminal From pos:\n" .$terminal_empty. " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $terminal_id_empty . PHP_EOL, FILE_APPEND | LOCK_EX);
                echo 'Terminal Id Empty';
                die();
        }

                $storeid = substr($terminal_id,4); 
                $db->where('idmerchants',$merchant_id);
                $merchant_details = $db->getOne("merchants");
                $secondary_merchant_name = $merchant_details['merchant_name'];
                $secondary_merchant_id = $merchant_details['mer_map_id'];
                $secondary_merchant_industry = $merchant_details['mcc'];
                $currency_code = $merchant_details['currency_code'];
                $store_id = $storeid;
            if($mso_location == ""){
                $name_split = explode(' ',$secondary_merchant_name);
                $loc_name = $name_split[0];
                //trim($secondary_merchant_name,"Duty Free PVT LTD");
                $store_name = $loc_name;
            }else{
                $store_name = $mso_location;
        }
                $pcrq = $merchant_details['pcrq'];
                $str = explode("~",$pcrq);

    /* terminal & merchant validation end */

    //pos test 210918
    $ttype = $_POST['tran_req_type'];
    $trans_amount = $_POST['trans_amount'];
    if($ttype == 1) {               /* ttype =1 ,Purchase request */

        /* Chinese time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
        $updated_datetime = $given->format("Y-m-d H:i:s");

        /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype,
            );
                $currency_error = array(
                "transaction_status" => 'merchant not found',
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype,
            );
                $currency_status = "Currency Matching log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived Currency Not Matched Log:\n" .json_encode($currency_received). " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $currency_status . PHP_EOL, FILE_APPEND | LOCK_EX);

                $currency_error_encode = json_encode($currency_error);
                header('Content-Type: application/json');
                echo $currency_error_encode;
                exit;
                die();

         } 
                 $db->where('currency',$currency_code);
                 $db->where('merchant_id',$secondary_merchant_id);  
                 $cur_res = $db->getOne('alipay_config');
                 $partner_id_alipay = $cur_res['partner_id'];
                 $key_md5_alipay = $cur_res['key_md5'];

                /* validation for otn already exist or not */
                $db->where("out_trade_no",$out_trade_no);
                $db->where("transaction_type",$ttype);
                $record_check = $db->get('transaction_alipay');
                $count = count($record_check);

        if($count >=1){
            $error_otn = array(
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "transaction_type" => $ttype,
                "error" => 'The given out trade no already exist'
            );
            $otn_log = "Application Log for Already OTN exist:\n".date("Y-m-d H:i:sa") . "\n---------------------\nPayment Request Data :\n" .json_encode($error_otn). " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $otn_log . PHP_EOL, FILE_APPEND | LOCK_EX);
            echo "The given out trade no already exist,use new one";
            exit;
            die();
        }
        /* Merchant payment access Permission starts here */
        
            if($str[0] == 1){

        /* Payment request data received from pos */

        $parameter_received = array(
            "currency" => $currency,
            "out_trade_no" => $out_trade_no,
            "timestamp" => $terminal_timestamp,
            "mer_callback_url" => $callback_notify_url,
            "total_fee" => $total_fee,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d'),
            "cst_trans_datetime" => $updated_datetime,
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "merchant_id" => $secondary_merchant_id
        );
        $parameter_ins = array(
            "currency" => $currency,
            "out_trade_no" => $out_trade_no,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "mer_callback_url" => $callback_notify_url,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d'),
            "cst_trans_datetime" => $updated_datetime,
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "merchant_id" => $secondary_merchant_id
        );

        /* payment request data log, received from POS terminal */

        $terminal_active_sts = "POS Terminal Acive Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nTerminal Active Id:\n" .json_encode($ter_act). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $terminal_active_sts . PHP_EOL, FILE_APPEND | LOCK_EX);


        $pos_data_log = "POS Data Request Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived Data From pos:\n" .json_encode($parameter_received). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $pos_data_log . PHP_EOL, FILE_APPEND | LOCK_EX);

        /* Inserting payment request data from pos into Transaction table */

        $insert_precreate = $db->insert('transaction_alipay', $parameter_ins);
        
        /* payment request data */

        // $extend_param = '{"secondary_merchant_name":"Lotte", "secondary_merchant_id":"123", "secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
        $extend_param = '{"secondary_merchant_name":"'.$secondary_merchant_name.'", "secondary_merchant_id":"'.$secondary_merchant_id.'", "secondary_merchant_industry":"'.$secondary_merchant_industry.'","store_id":"'.$store_id.'","store_name":"'.$store_name.'"}';

        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "currency" => $currency,
            "extend_params" => $extend_param,
            "notify_url"    => $alipay_config['notify_url'],
            "out_trade_no" => $out_trade_no,
            "partner" => $partner_id_alipay,
            "passback_parameters" => "success",
            "product_code" => $product_code,
            "service" => $alipay_config['service-qr-pcr'],
            "sign" => $key_md5_alipay,
            "sign_type" => $alipay_config['sign_type'],
            "subject" => $subject,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "trans_currency" => $currency
        );
        
        /* payment request data log ,send to alipay */
        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\URL alipay:\n" . $alipay_config['alipay_url']. " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nPayment Request Data to Alipay :\n" .json_encode($parameter). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\Build Data:\n" . $html_text. " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);


        $url=$alipay_config['alipay_url'] . $html_text ;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        /* Payment response log*/
        if(curl_errno($ch)){
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nPre-create payment Response:\n" . curl_errno($ch) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        } else {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nPre-create payment Response:\n" . $server_output . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        curl_close($ch);

        $qrcode =$alipaySubmit->get_from_tag($server_output, '<qr_code>','</qr_code>');
        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $error = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        $detail_error_code = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
        $is_success =$alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
        $qrImage  = $alipaySubmit->get_from_tag($server_output, '<small_pic_url>','</small_pic_url>');
        $big_pic = $alipaySubmit->get_from_tag($server_output, '<big_pic_url>','</big_pic_url>');
        $voucher_type =  $alipaySubmit->get_from_tag($server_output, '<voucher_type>','</voucher_type>');       
        $sign = $alipaySubmit->get_from_tag($server_output, '<sign>','</sign>');
        $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>','</sign_type>');
        $out_trade_no_resp = $alipaySubmit->get_from_tag($server_output, '<out_trade_no>','</out_trade_no>'); 

        if ($result_code != "SUCCESS" && $result_code != "") {
            $response_error_upd = array(
                    "result_code" => $result_code,
                    "sign" => $sign,
                    "sign_type" => $sign_type
                );

            $pay_err_res_upd = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log update in table:\n" . json_encode($response_error_upd) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $pay_err_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);
            /* Updating error response to transaction table */

            $db->where("out_trade_no", $out_trade_no);
            $db->where("transaction_type",$ttype);
            $trans_err_update = $db->update('transaction_alipay', $response_error_upd);

            $response_error = array(
                "transaction_status" => $result_code,
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "qrcode" => $qrImage,
                "qrcode_value" => $qrcode
            );

            $pay_err_res = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($response_error) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $pay_err_res . PHP_EOL, FILE_APPEND | LOCK_EX);

            $response_encode = json_encode($response_error);
            header('Content-Type: application/json');
            echo $response_encode;

        }else if ($result_code != "FAIL" && $result_code != "SUCCESS") {
            $response_error_emp = array(
                    "result_code" => 'TIME OUT'
                );

            $pay_emp_res_upd = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log update in table:\n" . json_encode($response_error_emp) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $pay_emp_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);

            /* Updating error empty response to transaction table */

            $db->where("out_trade_no", $out_trade_no);
            $db->where("transaction_type",$ttype);
            $trans_emp_update = $db->update('transaction_alipay', $response_error_emp);

            $response_empty = array(
                "transaction_status" => 'TIME OUT',
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "qrcode" => $qrImage,
                "qrcode_value" => $qrcode
            );
            $pay_err_res_emp = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($response_empty) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $pay_err_res_emp . PHP_EOL, FILE_APPEND | LOCK_EX);

            $response_encode_emp = json_encode($response_empty);
            header('Content-Type: application/json');
            echo $response_encode_emp;
        }else {
            
            $data = array(
            "big_pic_url" => $big_pic,
            "out_trade_no" => $out_trade_no_resp,
            "pic_url" => $qrImage,
            "qr_code" => $qrcode,
            "result_code" => $result_code,
            "small_pic_url" => $qrImage,
            "voucher_type" => $voucher_type,
            "is_success" => $is_success,
            "input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "extend_params" => $extend_param,
            "notify_url" => $alipay_config['notify_url'],
            "partner" => $alipay_config['partner-qr'],
            "passback_parameters" => "success",
            "service" => $alipay_config['service-qr-pcr'],
            "sign" => $alipay_config['key-qr'],
            "sign_type" => $alipay_config['sign_type'],
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "trans_currency" => $currency,
            "currency" => $currency,
            "product_code" => $product_code,
            "subject" => $subject,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d'),
            "terminal_id" => $terminal_id,
        ); 

        /* Log for after getting payment trade successfully updating details */

        $final_pay_res = date("Y-m-d H:i:sa") . "\n---------------------\nFianl payment Response update in table:\n" . json_encode($data) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $final_pay_res . PHP_EOL, FILE_APPEND | LOCK_EX);

        /* Updating Transaction table after success response */
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",$ttype);
        $trans_suc_update = $db->update('transaction_alipay', $data);

            $pay_response_suc = array(
                "transaction_status" => $result_code,
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "qrcode" => $qrImage,
                "qrcode_value" => $qrcode
            );
            $pay_success_res = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($pay_response_suc) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $pay_success_res . PHP_EOL, FILE_APPEND | LOCK_EX);

            $response_encode = json_encode($pay_response_suc);
            header('Content-Type: application/json');
            echo $response_encode;
        }
    }else{
        $acs = $str[0];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $out_trade_no,
            'pay_access' => $acs
        );
        $mer_access_permsn = "Pay Access Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\Pay Access not allowed:\n" .json_encode($access_den). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $mer_access_permsn . PHP_EOL, FILE_APPEND | LOCK_EX);
        echo 'permission denied to pay request for this merchant';
    }
    exit;

    } else if($ttype == 2) {                  /* Refund request */
     

            $ref_time_ind = date('Y-m-d H:i:s');
            $given_ref = new DateTime($ref_time_ind);
            $given_ref->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
            $updated_datetime_ref = $given_ref->format("Y-m-d H:i:s");

        /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype,
            );

            $currency_error = array(
            "transaction_status" => 'merchant not found',
            "out_trade_no" => $out_trade_no,
            "terminal_id" => $terminal_id,
            "tran_req_type" => $ttype,
            );

            $currency_status = "Currency Matching log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived Currency Not Matched Log:\n" .json_encode($currency_received). " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $currency_status . PHP_EOL, FILE_APPEND | LOCK_EX);

            $currency_error_encode = json_encode($currency_error);
            header('Content-Type: application/json');
            echo $currency_error_encode;
            exit;
            die();

         } 
             $db->where('currency',$currency_code);
             $db->where('merchant_id',$secondary_merchant_id);  
             $cur_res = $db->getOne('alipay_config');
             $partner_id_alipay = $cur_res['partner_id'];
             $key_md5_alipay = $cur_res['key_md5'];

        /* Merchant Refund access Permission starts here */
        
        if($str[2] == 1){
            $refund_req_data = array(
            "currency" => $currency,
            "merchant_id" => $secondary_merchant_id,
            "partner_trans_id" => $_POST['orig_out_trade_no'],
            "partner_refund_id" => $_POST['out_trade_no'],
            "refund_amount" => $_POST['refund_amount'],
            "out_trade_no" => $_POST['out_trade_no'],
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "cst_trans_datetime" => $updated_datetime_ref,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d')
        ); 
        
        /* Refund request data log creation ,received from POS */

        $ref_req_data_pos = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund request data from pos:\n" . json_encode($refund_req_data) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $ref_req_data_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

        /* Refund request data inserting,received from POS */

        $refund_req_ins = $db->insert('transaction_alipay',$refund_req_data);

        /* Refund request data to Alipay*/

        $parameter = array(
            "currency" => $currency,
            "partner" => $partner_id_alipay,
            "partner_trans_id" => $_POST['orig_out_trade_no'],
            "partner_refund_id" => $_POST['out_trade_no'],
            "refund_amount" => $_POST['refund_amount'],
            "service" => $alipay_config['service-re-qr'],
            "sign" => '',
            "sign_type" => ''
        );

        /* Refund request data to Alipay -  log */

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund request data to alipay:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\Build Data:\n" . $html_text. " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $url = $alipay_config['alipay_url'] . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        /* Refund response log */

        if(curl_errno($ch)) {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nRefund Response:\n".curl_errno($ch) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nRefund Response:\n" . $server_output . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $desc = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        $is_success = $alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
        $refund_amount = $alipaySubmit->get_from_tag($server_output, '<refund_amount>', '</refund_amount>');
        $currency = $alipaySubmit->get_from_tag($server_output, '<currency>', '</currency>');
        $error = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        $partner_refund_id = $alipaySubmit->get_from_tag($server_output, '<partner_refund_id>', '</partner_refund_id>');
        $partner_trans_id = $alipaySubmit->get_from_tag($server_output, '<partner_trans_id>', '</partner_trans_id>');
        $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
        $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
        $alipay_trans_id = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
        $exchange_rate = $alipaySubmit->get_from_tag($server_output, '<exchange_rate>', '</exchange_rate>');
        $refund_amount_cny = $alipaySubmit->get_from_tag($server_output, '<refund_amount_cny>', '</refund_amount_cny>');

        if ($result_code == "SUCCESS") {
            $data_refs = array(
               "result_code" => $result_code,
               "refund_amount" => $refund_amount,
               "refund_amount_cny" => $refund_amount_cny,
               "partner_refund_id" => $partner_refund_id,
               "partner_trans_id" => $partner_trans_id,
               "alipay_trans_id" => $alipay_trans_id,
               "currency" => $currency,
               "res_sign" => $sign,
               "res_sign_type" => $sign_type
            );

            $refund_succ_res_upd = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund success response update in table:\n" . json_encode($data_refs) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_succ_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);

            /* Response details update in refund inserted row */

            $db->where("partner_refund_id",$partner_refund_id);
            $db->where("transaction_type",$ttype);
            $refund_success_update = $db->update('transaction_alipay', $data_refs);

            /* Refund response send to pos */

            $refund_suc_res_pos = array(
                "transaction_status" => $result_code,
                "refund_amount" => $refund_amount,
                "out_trade_no" => $partner_refund_id,
                "terminal_id" => $terminal_id
            );
            $refund_suc_res_pos_log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund response send to pos:\n" . json_encode($refund_suc_res_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_suc_res_pos_log . PHP_EOL, FILE_APPEND | LOCK_EX);

            $refund_encode = json_encode($refund_suc_res_pos);
            header('Content-Type: application/json');
            echo $refund_encode;

        }else if ($result_code != "SUCCESS" && $result_code != "FAILED") {
            $res_empty = array(
                "result_code" => 'TIME OUT',
                "refund_amount" => $_POST['refund_amount'],
                "out_trade_no" => $_POST['out_trade_no'],
                "terminal_id" => $terminal_id
            );

            $refund_empty_res = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund empty response update in table:\n" . json_encode($res_empty) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_empty_res . PHP_EOL, FILE_APPEND | LOCK_EX);
            

            /* Update refund empty response in transaction table */

            $db->where("partner_refund_id",$_POST['out_trade_no']);
            $db->where("transaction_type",$ttype);
            $refund_empty_update = $db->update('transaction_alipay', $res_empty);

            $res_empty_pos = array(
                "transaction_status" => 'TIME OUT',
                "refund_amount" => $_POST['refund_amount'],
                "out_trade_no" => $_POST['out_trade_no'],
                "terminal_id" => $terminal_id
            );

            $refund_empty_res_pos = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund empty response sent to pos:\n" . json_encode($res_empty_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_empty_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

            $refund_empty_encode = json_encode($res_empty_pos);
            header('Content-Type: application/json');
            echo $refund_empty_encode;

        }else {
            $data_refs = array(
               "is_success" => $is_success,
               "result_code" => $result_code,
               "error" => $error,
               "res_sign" => $sign,
               "res_sign_type" => $sign_type
            );

            $refund_err_res_upd = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund error response update in table:\n" . json_encode($data_refs) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_err_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);

            /*Refund error response update in refund inserted row */

            $db->where("partner_refund_id",$_POST['out_trade_no']);
            $db->where("transaction_type",$ttype);
            $refund_error_update = $db->update('transaction_alipay', $data_refs);

            /* Refund error response send to pos */

            $data_ref = array(
                "transaction_status" => $result_code,
                "refund_amount" => $_POST['refund_amount'],
                "out_trade_no" => $_POST['out_trade_no'],
                "terminal_id" => $terminal_id
            );

            $refund_err_res_pos_log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund error response send to pos:\n" . json_encode($data_ref) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_err_res_pos_log . PHP_EOL, FILE_APPEND | LOCK_EX);

            $refund_encode1 = json_encode($data_ref);
            header('Content-Type: application/json');
            echo $refund_encode1;
        }
    }else{
        /* refund not allowed to merchant*/
        $acs = $str[2];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $out_trade_no,
            'refund_access' => $acs
        );
        $mer_access_permsn = "Refund Access Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\Refund Not Allowed Log:\n" .json_encode($access_den). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $mer_access_permsn . PHP_EOL, FILE_APPEND | LOCK_EX);
        echo 'Refund denied to this merchant';
    }
exit;


}else if($ttype== 3) {          /* ttype=3, Query */
        $partner_trans_id = $_POST['orig_out_trade_no'];
        $db->where("out_trade_no",$partner_trans_id);
        $currency_get = $db->getOne('transaction_alipay');
        $currency = $currency_get['currency'];

        $qry_time_ind = date('Y-m-d H:i:s');
        $given_qry = new DateTime($qry_time_ind);
        $given_qry->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
        $updated_datetime_qry = $given_qry->format("Y-m-d H:i:s");

        /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype,
            );

            $currency_error = array(
            "transaction_status" => 'merchant not found',
            "out_trade_no" => $partner_trans_id,
            "terminal_id" => $terminal_id,
            "tran_req_type" => $ttype,
            );

            $currency_status = "Currency Matching log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived Currency Not Matched Log:\n" .json_encode($currency_received). " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $currency_status . PHP_EOL, FILE_APPEND | LOCK_EX);

            $currency_error_encode = json_encode($currency_error);
            header('Content-Type: application/json');
            echo $currency_error_encode;
            exit;
            die();

         } 
             $db->where('currency',$currency_code);
             $db->where('merchant_id',$secondary_merchant_id);  
             $cur_res = $db->getOne('alipay_config');
             $partner_id_alipay = $cur_res['partner_id'];
             $key_md5_alipay = $cur_res['key_md5'];

        /* Merchant Query access Permission starts here */
        
        if($str[3] == 1){
            $query_data_ins = array(
            "terminal_id" => $terminal_id,
            "merchant_id" => $secondary_merchant_id,
            "partner_trans_id" => $partner_trans_id,
            "transaction_type" => $ttype,
            "cst_trans_datetime" => $updated_datetime_qry,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d')
        );

        /* Query log data received from Pos */

        $query_log = "Query request data from pos:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRequest Data insert in table:\n" . json_encode($query_data_ins) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $query_log . PHP_EOL, FILE_APPEND | LOCK_EX);

/* Checking transaction success or not ,if success dont send request to alipay */

        $db->where("out_trade_no", $partner_trans_id);
        $trans_result = $db->getOne("transaction_alipay");
        $trade_status = $trans_result['trade_status'];
        $total_fee = $trans_result['total_fee'];
        $result_code = $trans_result['result_code'];

        if($trade_status == 'TRADE_SUCCESS'){
            $query_stts = array(
                "transaction_status" => $result_code,
                "amount" => $total_fee,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
                );     

            $trans_succ_log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query Status send to pos:\n" . json_encode($query_stts) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $trans_succ_log . PHP_EOL, FILE_APPEND | LOCK_EX); 

            $query_stts_encode = json_encode($query_stts);
            header('Content-Type: application/json');
            echo $query_stts_encode;

            exit;
            die();  
        }

     /* Inserting query request data received from pos into Transaction table */
       
        $query_insert = $db->insert('transaction_alipay', $query_data_ins);

    
    /* Query data send to alipay*/

        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "partner" => $alipay_config['partner-qr'],
            "partner_trans_id" => $partner_trans_id,
            "service" => $alipay_config['service-qy-qr'],
            "sign_type" => $alipay_config['sign_type'],
            "sign" => $alipay_config['key-qr'],
        );

    /* Query data log ,send to alipay*/

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query Request Data:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\query Build Data:\n" . $html_text. " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $url = $alipay_config['alipay_url'] . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        /* Query response log */

        if(curl_errno($ch)) {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nQuery Response:\n".curl_errno($ch) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nQuery Response:\n" . $server_output . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $partner_trans_id = $alipaySubmit->get_from_tag($server_output,'<partner_trans_id>', '</partner_trans_id>');
            $is_success = $alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
            $partner = $alipaySubmit->get_from_tag($server_output, '<partner>', '</partner>');
            $input_charset = $alipaySubmit->get_from_tag($server_output, '<_input_charset>', '</_input_charset>');
            $service = $alipaySubmit->get_from_tag($service, '<service>', '</service>');
            $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
            $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $alipay_buyer_login_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_login_id>', '</alipay_buyer_login_id>');
            $alipay_buyer_user_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_user_id>', '</alipay_buyer_user_id>');
            $alipay_pay_time = $alipaySubmit->get_from_tag($server_output, '<alipay_pay_time>', '</alipay_pay_time>');
            $alipay_trans_id = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
            $alipay_trans_status = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_status>', '</alipay_trans_status>');
            $currency = $alipaySubmit->get_from_tag($server_output, '<currency>', '</currency>');
            $trans_amount_cny = $alipaySubmit->get_from_tag($server_output, '<trans_amount_cny>', '</trans_amount_cny>');
            $exchange_rate = $alipaySubmit->get_from_tag($server_output, '<exchange_rate>', '</exchange_rate>');
            $forex_total_fee = $alipaySubmit->get_from_tag($server_output, '<forex_total_fee>', '</forex_total_fee>');
            $out_trade_no_res = $alipaySubmit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
            $trans_amount = $alipaySubmit->get_from_tag($server_output, '<trans_amount>', '</trans_amount>');
            $trans_forex_rate =$alipaySubmit->get_from_tag($server_output, '<trans_forex_rate>', '</trans_forex_rate>');
            $error =$alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
            $detail_error_code = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');

            // if($result_code == "SUCCESS" && $alipay_trans_status == "TRADE_CLOSED" || $alipay_trans_status == "WAIT_BUYER_PAY"){
            if($result_code == "SUCCESS" && ($alipay_trans_status == "TRADE_CLOSED" || $alipay_trans_status == "WAIT_BUYER_PAY") ) {

                $query_trade_res_pos = array(
                    "buyer_email" => $alipay_buyer_login_id,
                    "res_sign_type" => $sign_type,
                    "res_sign" => $sign,
                    "result_code" => $result_code,
                    "alipay_buyer_user_id" => $alipay_buyer_user_id,
                    "alipay_trans_id" => $alipay_trans_id,
                    "currency" => $currency,
                    "exchange_rate" => $exchange_rate,
                    "total_fee" => $forex_total_fee,
                    "out_trade_no" => $out_trade_no_res,
                    "partner_trans_id" => $partner_trans_id,
                    "is_success" => $is_success,
                    "trade_status" => $alipay_trans_status,
                    "trans_amount" => $trans_amount,
                    "alipay_trans_status" => $alipay_trans_status
                );

            $query_response = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query trade closed response update:\n" . json_encode($query_trade_res_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);

            /*Updating query trade response in transaction stable */

                $db->where("out_trade_no",$partner_trans_id);
            $query_update3 = $db->update('transaction_alipay',$query_trade_res_pos);

                $db->where("partner_trans_id",$partner_trans_id);
                $db->where("transaction_type",$ttype);
            $query_update4 = $db->update('transaction_alipay', $query_trade_res_pos);

                $error_description = $db->get('error_details');
                foreach ($error_description as $key => $value) {
                //echo $key.'=>'.$value['error_id']; exit;
                if($value['error'] == $alipay_trans_status) {
                $des = $value['description'];
                }
                }
    
                $data_trade_query = array(
                "transaction_status" => $des,
                "amount" => $trans_amount,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
                );

                $query_trade_res_pos1 = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query trade response send to pos:\n" . json_encode($data_trade_query) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $query_trade_res_pos1 . PHP_EOL, FILE_APPEND | LOCK_EX);

                $query_trade_res_pos_encode = json_encode($data_trade_query);
                header('Content-Type: application/json');
                echo $query_trade_res_pos_encode;  

        }else if ($result_code == "SUCCESS" && $alipay_trans_status == "TRADE_SUCCESS") {
            $data2 = array(
                "alipay_buyer_user_id" => $alipay_buyer_user_id,
                "alipay_trans_id" => $alipay_trans_id,
                "alipay_trans_status" => $alipay_trans_status,
                "alipay_pay_time" => $alipay_pay_time,
                "currency" => $currency,
                "exchange_rate" => $exchange_rate,
                "out_trade_no" => $out_trade_no_res,
                "partner_trans_id" => $partner_trans_id,
                "result_code" => $result_code,
                "trans_amount" => $trans_amount,
                "is_success" => $is_success,
                "res_sign_type" => $sign_type,
                "res_sign" => $sign,
            );
            $query_response = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query response update in table:\n" . json_encode($data2) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);

        /* Updating query Success response in transaction table */

            $db->where("out_trade_no",$partner_trans_id);
            $query_update1 = $db->update('transaction_alipay', $data2);

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$ttype);
            $query_update2 = $db->update('transaction_alipay', $data2);

            $query_succs_res_pos = array(
                "transaction_status" => $result_code,
                "amount" => $trans_amount,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            ); 
            $query_response_to_pos = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query response send to pos:\n" . json_encode($query_succs_res_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response_to_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

            $query_succs_res_pos_encode = json_encode($query_succs_res_pos);
            header('Content-Type: application/json');
            echo $query_succs_res_pos_encode;  


        }
        else{
                $query_error_res_pos = array(
                    "is_success" => $is_success,
                    "res_sign_type" => $sign_type,
                    "res_sign" => $sign,
                    "result_code" => $result_code
                );

            $query_response = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query failure response update:\n" . json_encode($query_error_res_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);

            /* Updating query error response in query row */

                $db->where("out_trade_no",$partner_trans_id);
            $query_err_update = $db->update('transaction_alipay',$query_error_res_pos);

                $db->where("partner_trans_id",$partner_trans_id);
                $db->where("transaction_type",$ttype);
                $query_err_update2 = $db->update('transaction_alipay', $query_error_res_pos);

                $data_err_query = array(
                "transaction_status" => $result_code,
                "amount" => $trans_amount,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
                );

            $query_response_pos = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query failure response to pos:\n" . json_encode($data_err_query) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

                $query_err_res_pos_encode = json_encode($data_err_query);
                header('Content-Type: application/json');
                echo $query_err_res_pos_encode;  
        }
    }else{
        $acs = $str[3];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $partner_trans_id,
            'query_access' => $acs
        );
        $mer_access_permsn = "Query Access Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\Query Not Allowed Log:\n" .json_encode($access_den). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $mer_access_permsn . PHP_EOL, FILE_APPEND | LOCK_EX);
        echo 'Query denied to this merchant';
    }
    }else if($ttype == 4) {              /* Cancel request */
            //$terminal_id = $_POST['terminal_id'];
            $orig_out_trade_no = $_POST['orig_out_trade_no'];

            $db->where("out_trade_no",$orig_out_trade_no);
            $amount_get = $db->getOne('transaction_alipay');
            $amount = $amount_get['total_fee'];
            $currency = $amount_get['currency'];

            $cncl_time_ind = date('Y-m-d H:i:s');
            $given_cncl = new DateTime($cncl_time_ind);
            $given_cncl->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
            $updated_datetime_cncl = $given_cncl->format("Y-m-d H:i:s");

        /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "out_trade_no" => $orig_out_trade_no,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype,
            );

            $currency_error = array(
            "transaction_status" => 'merchant not found',
            "out_trade_no" => $orig_out_trade_no,
            "terminal_id" => $terminal_id,
            "tran_req_type" => $ttype,
            );
            
            $currency_status = "Currency Matching log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived Currency Not Matched Log:\n" .json_encode($currency_received). " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $currency_status . PHP_EOL, FILE_APPEND | LOCK_EX);

            $currency_error_encode = json_encode($currency_error);
            header('Content-Type: application/json');
            echo $currency_error_encode;
            exit;
            die();

         } 
             $db->where('currency',$currency_code);
             $db->where('merchant_id',$secondary_merchant_id);  
             $cur_res = $db->getOne('alipay_config');
             $partner_id_alipay = $cur_res['partner_id'];
             $key_md5_alipay = $cur_res['key_md5'];

        /* Merchant Cancel access Permission starts here */
        
        if($str[1] == 1){

            $can_req_data = array(
            "currency" => $currency,
            "total_fee" => $amount, 
            "merchant_id" => $secondary_merchant_id,
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "out_trade_no" => $orig_out_trade_no,
            "cst_trans_datetime" => $updated_datetime_cncl,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d')
            );
            $can_data_pos= "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Request Data:\n" . json_encode($can_req_data) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $can_data_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
           
            $can_insert = $db->insert('transaction_alipay', $can_req_data);

            $parameter = array(
                "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
                "out_trade_no" => $orig_out_trade_no,
                "partner" => $partner_id_alipay,
                "service" => $alipay_config['service-qr-cl'],
                "sign" => $key_md5_alipay,
                "sign_type" => $alipay_config['sign_type'],
                "timestamp" => date('YmdHis')
            );

            $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Request Data to alipay:\n" . json_encode($parameter) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

            $alipaySubmit = new AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

            $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\cancel Build Data:\n" . $html_text. " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

            $url = $alipay_config['alipay_url'] . $html_text;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            if(curl_errno($ch)) {
                $log = date("Y-m-d H:i:sa") . "\n---------------------\nCancel Response:\n".curl_errno($ch) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            } else {
                $log = date("Y-m-d H:i:sa") . "\n---------------------\nCancel Response:\n" . $server_output . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }

            $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
            $is_success = $alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
            $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
            $error = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
            $trade_no = $alipaySubmit->get_from_tag($server_output, '<trade_no>', '</trade_no>');
            $out_trade_no_res = $alipaySubmit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
            $retry_flag = $alipaySubmit->get_from_tag($server_output, '<retry_flag>', '</retry_flag>');
            $action = $alipaySubmit->get_from_tag($server_output, '<action>', '</action>');
            $detail_error_code = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
            $detail_error_des = $alipaySubmit->get_from_tag($server_output, '<detail_error_des>', '</detail_error_des>');

            if ($result_code == "SUCCESS") {
                $response = array(
                    "is_success" => $is_success,
                    "result_code" => $result_code,
                    "sign_type" => $sign_type,
                    "sign" => $sign,
                    "out_trade_no" => $out_trade_no_res,
                    "trade_no" => $trade_no,
                    "retry_flag" => $retry_flag
                );
                $can_response_success = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Success response update in table:\n" . json_encode($response) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_response_success . PHP_EOL, FILE_APPEND | LOCK_EX);
                
                $db->where("out_trade_no",$orig_out_trade_no);
                $db->where("transaction_type",$ttype);
                $update = $db->update('transaction_alipay', $response);
                
                $data3 = array(
                    "transaction_status" => $result_code,
                    "out_trade_no" => $orig_out_trade_no,
                    "terminal_id" => $terminal_id,
                    "amount" => $amount
                ); 

                $can_succs_res_pos= "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Success response to pos:\n" . json_encode($data3) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_succs_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

                $can_succs_res_pos_encode = json_encode($data3);
                header('Content-Type: application/json');
                echo $can_succs_res_pos_encode;
                     
            } else {
                $response = array(
                    "result_code" => $result_code,
                    "detail_error_code" => $detail_error_code,
                    "detail_error_des" => $detail_error_des,
                    "sign" => $sign,
                    "sign_type" => $sign_type
                );
                $can_response_error = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel error response update in table:\n" . json_encode($response) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_response_error . PHP_EOL, FILE_APPEND | LOCK_EX);

                $db->where("out_trade_no",$orig_out_trade_no);
                $amount_get = $db->getOne('transaction_alipay');
                $amount = $amount_get['total_fee'];

                $data4 = array(
                    "transaction_status" => $result_code,
                    "out_trade_no" => $orig_out_trade_no,
                    "terminal_id" => $terminal_id,
                    "amount" => $amount
                );

                $can_err_res_pos= "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel error response to pos:\n" . json_encode($data4) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_err_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

                $db->where("out_trade_no",$orig_out_trade_no);
                $db->where("transaction_type",$ttype);
                $cancel_update = $db->update('transaction_alipay', $response);

                $can_err_res_pos_encode = json_encode($data4);
                header('Content-Type: application/json');
                echo $can_err_res_pos_encode;
            }
        }else{
        $acs = $str[1];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $orig_out_trade_no,
            'cancel_access' => $acs
        );
        $mer_access_permsn = "Cancel Access Log:\n".date("Y-m-d H:i:sa") . "\n---------------------Cancel Not Allowed Log:\n" .json_encode($access_den). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $mer_access_permsn . PHP_EOL, FILE_APPEND | LOCK_EX);
        echo 'Cancel denied to this merchant';
    }
    }
/* Test case starts here */ 

else if($ttype == 11) {               /* ttype =11 ,Purchase_test request */

        /* validation for otn already exist or not */
        $db->where("out_trade_no",$out_trade_no);
        $db->where("transaction_type",$ttype);
        $record_check = $db->get('transaction_alipay');
        $count = count($record_check);

        if($count >=1){
            $error_otn = array(
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "transaction_type" => $ttype,
                "error" => 'The given out trade no already exist'
            );
            $otn_log = "Application Log for Already OTN exist:\n".date("Y-m-d H:i:sa") . "\n---------------------\nPayment Request Data :\n" .json_encode($error_otn). " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $otn_log . PHP_EOL, FILE_APPEND | LOCK_EX);
           echo "The given out trade no already exist,use new one";
            exit;
        }
    
        if($_POST['terminal_id']!="") {
            $db->where("mso_terminal_id", $_POST['terminal_id']);
            $terminal_res = $db->getOne("terminal");
            $merchant_id  = $terminal_res['idmerchants'];
        } else {
            $merchant_id  = '';
        }

        /* Payment request data received from pos */

        $parameter_ins = array(
            "currency" => $currency,
            "out_trade_no" => $out_trade_no,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d'),
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "trans_amount" => $trans_amount
        );

        /* payment request data log, received from POS terminal */

        $pos_data_log = "POS Data Request test case Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nReceived Data:\n" .json_encode($parameter_ins). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $pos_data_log . PHP_EOL, FILE_APPEND | LOCK_EX);

        /* Inserting payment request data from pos into Transaction table */

        $insert_precreate = $db->insert('transaction_alipay', $parameter_ins);
        
        /* payment request data */

        $extend_param = '{"secondary_merchant_name":"Lotte", "secondary_merchant_id":"123", "secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';

        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "currency" => $currency,
            "extend_params" => $extend_param,
            "notify_url"    => $alipay_config['notify_url'],
            "out_trade_no" => $out_trade_no,
            "partner" => $alipay_config['partner-qr'],
            "passback_parameters" => "success",
            "product_code" => $product_code,
            "service" => 'alipay.acquire.overseas.spot.pay',
            "sign" => $alipay_config['key-qr'],
            "sign_type" => $alipay_config['sign_type'],
            "subject" => $subject,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "trans_currency" => $currency,
            "trans_amount" => $trans_amount
        );
        
        /* payment request data log ,send to alipay */

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nPayment Request Data test case:\n" .json_encode($parameter). " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $url="https://openapi.alipaydev.com/gateway.do?".$html_text;
        //$url="https://mapi.alipaydev.com/gateway.do?".$html_text;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        /* Payment response log*/
        if(curl_errno($ch)){
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nPre-create payment test case Response:\n" . curl_errno($ch) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nPre-create payment test case Response:\n" . $server_output . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        curl_close($ch);

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $error = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
        $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');

        if ($result_code != "SUCCESS" && $result_code != "") {

            $response = array(
                "transaction_status" => $result_code,
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "qrcode" => $qrImage
            );
            $pay_err_res = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($response) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $pay_err_res . PHP_EOL, FILE_APPEND | LOCK_EX);

            $response_encode = json_encode($response);
            header('Content-Type: application/json');
            echo $response_encode;
        }else if ($result_code != "FAIL" && $result_code != "SUCCESS") {

            $response_empty = array(
                "transaction_status" => 'FAIL',
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "qrcode" => $qrImage
            );
            $pay_err_res_emp = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($response_empty) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $pay_err_res_emp . PHP_EOL, FILE_APPEND | LOCK_EX);

            $response_encode_emp = json_encode($response_empty);
            header('Content-Type: application/json');
            echo $response_encode_emp;
        } else {
            // echo "<br><br><center><b>Redirecting to Payment URL in few seconds...</b></center><br><br>";
            $response = array(
                "transaction_status" => $result_code,
                "out_trade_no" => $out_trade_no,
                "terminal_id" => $terminal_id,
                "qrcode" => $qrImage
            );
            $pay_success_res = date("Y-m-d H:i:sa") . "\n---------------------\nPay Status log send to pos:\n" . json_encode($response) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $pay_success_res . PHP_EOL, FILE_APPEND | LOCK_EX);

            $response_encode = json_encode($response);
            header('Content-Type: application/json');
            echo $response_encode;
        }
        exit;
}else if($ttype == 44) {              /* Cancel request */
            $terminal_id = $_POST['terminal_id'];
            $orig_out_trade_no = $_POST['orig_out_trade_no'];

            $can_req_data = array( 
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "out_trade_no" => $orig_out_trade_no,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d')
            );
            $can_data_pos= "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Request Data Test:\n" . json_encode($can_req_data) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $can_data_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
           
            $can_insert = $db->insert('transaction_alipay', $can_req_data);

            $parameter = array(
                "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
                "out_trade_no" => $orig_out_trade_no,
                "partner" => $alipay_config['partner-qr'],
                "service" => 'alipay.acquire.cancel',
                "sign" => $alipay_config['key-qr'],
                "sign_type" => $alipay_config['sign_type'],
                "timestamp" => date('YmdHis')
            );

            $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Request  Test Data to alipay:\n" . json_encode($parameter) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

            $alipaySubmit = new AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
            $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            if(curl_errno($ch)) {
                $log = date("Y-m-d H:i:sa") . "\n---------------------\nCancel Response:\n".curl_errno($ch) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            } else {
                $log = date("Y-m-d H:i:sa") . "\n---------------------\nCancel Response:\n" . $server_output . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }

            $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
            $is_success = $alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
            $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
            $error = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
            $trade_no = $alipaySubmit->get_from_tag($server_output, '<trade_no>', '</trade_no>');
            $out_trade_no_res = $alipaySubmit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
            $retry_flag = $alipaySubmit->get_from_tag($server_output, '<retry_flag>', '</retry_flag>');
            $action = $alipaySubmit->get_from_tag($server_output, '<action>', '</action>');
            $detail_error_code = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
            $detail_error_des = $alipaySubmit->get_from_tag($server_output, '<detail_error_des>', '</detail_error_des>');
            $display_message = $alipaySubmit->get_from_tag($server_output, '<display_message>', '</display_message>');


            if ($result_code == "SUCCESS") {
                $response = array(
                    "is_success" => $is_success,
                    "result_code" => $result_code,
                    "sign_type" => $sign_type,
                    "sign" => $sign,
                    "out_trade_no" => $out_trade_no,
                    "retry_flag" => $retry_flag
                );
                $can_response_success = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Success response update in table:\n" . json_encode($response) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_response_success . PHP_EOL, FILE_APPEND | LOCK_EX);
                
                $db->where("out_trade_no",$orig_out_trade_no);
                $db->where("transaction_type",$ttype);
                $update = $db->update('transaction_alipay', $response);
                
                $db->where("out_trade_no",$orig_out_trade_no);
                $amount_get = $db->getOne('transaction_alipay');
                $amount = $amount_get['total_fee'];
                
                $data3 = array(
                    "transaction_status" => $result_code,
                    "out_trade_no" => $orig_out_trade_no,
                    "terminal_id" => $terminal_id,
                    "amount" => $amount
                ); 

                $can_succs_res_pos= "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel Success response to pos:\n" . json_encode($data3) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_succs_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

                $can_succs_res_pos_encode = json_encode($data3);
                header('Content-Type: application/json');
                echo $can_succs_res_pos_encode;
                     
            } else {
                $response = array(
                    "result_code" => $result_code,
                    "detail_error_code" => $detail_error_code,
                    "detail_error_des" => $detail_error_des,
                    "sign" => $sign,
                    "sign_type" => $sign_type
                );
                $can_response_error = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel error response update in table:\n" . json_encode($response) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_response_error . PHP_EOL, FILE_APPEND | LOCK_EX);

                $db->where("out_trade_no",$orig_out_trade_no);
                $amount_get = $db->getOne('transaction_alipay');
                $amount = $amount_get['total_fee'];

                $data4 = Array(
                    "action" => $action,
                    "detail_error_code" => $detail_error_code,
                    "detail_error_des" => $detail_error_des,
                    "display_message" => $display_message,
                    "out_trade_no" => $out_trade_no_res,
                    "retry_flag" => $retry_flag,
                    "sign" => $sign,
                    "sign_type" => $sign_type
                );

                $can_err_res_pos= "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nCancel error response to pos:\n" . json_encode($data4) . " \n\n";
                $myfile = file_put_contents($alipay_config['log-path'], $can_err_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

                $db->where("out_trade_no",$orig_out_trade_no);
                $db->where("transaction_type",$ttype);
                $cancel_update = $db->update('transaction_alipay', $response);

                $can_err_res_pos_encode = json_encode($data4);
                header('Content-Type: application/json');
                echo $can_err_res_pos_encode;
            }
    }else if($ttype == 22) {                  /* Refund request */
        $refund_req_data = array(
            "currency" => $currency,
            "partner_trans_id" => $_POST['orig_out_trade_no'],
            "partner_refund_id" => $_POST['out_trade_no'],
            "refund_amount" => $_POST['refund_amount'],
            "out_trade_no" => $_POST['out_trade_no'],
            "terminal_id" => $terminal_id,
            "transaction_type" => $ttype,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d')
        ); 

        /* Refund request data log creation ,received from POS */

        $ref_req_data_pos = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund request data from pos:\n" . json_encode($refund_req_data) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $ref_req_data_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

        /* Refund request data inserting,received from POS */

        $refund_req_ins = $db->insert('transaction_alipay',$refund_req_data);

        /* Refund request data to Alipay*/

        $parameter = array(
            "currency" => $currency,
            "partner" => $alipay_config['partner-qr'],
            "partner_trans_id" => $_POST['orig_out_trade_no'],
            "partner_refund_id" => $_POST['out_trade_no'],
            "refund_amount" => $_POST['refund_amount'],
            "service" => 'alipay.acquire.overseas.spot.refund',
            "sign" => '',
            "sign_type" => ''
        );

        /* Refund request data to Alipay log*/

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund request data to alipay:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\Build Data:\n" . $html_text. " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        /* Refund response log */

        if(curl_errno($ch)) {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nRefund Response:\n".curl_errno($ch) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nRefund Response:\n" . $server_output . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $desc = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        $is_success = $alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
        $refund_amount = $alipaySubmit->get_from_tag($server_output, '<refund_amount>', '</refund_amount>');
        $currency = $alipaySubmit->get_from_tag($server_output, '<currency>', '</currency>');
        $error = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        $partner_refund_id = $alipaySubmit->get_from_tag($server_output, '<partner_refund_id>', '</partner_refund_id>');
        $currency = $alipaySubmit->get_from_tag($server_output, '<currency>', '</currency>');
        $sign = $currency = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
        $sign_type = $currency = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');


        if ($result_code == "SUCCESS") {
            $response = array(
                'res' => $result_code,
                'desc' => $desc
            );
            
            $data_refs = array(
               "result_code" => $result_code,
               "refund_amount" => $refund_amount,//$_POST['refund_amount'],
               "partner_refund_id" => $partner_refund_id,
               "currency" => $currency
        
            );
            //print_r($data_refs);exit;die();
            $refund_succ_res_upd = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRefund request data to alipay:\n" . json_encode($data_refs) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $refund_succ_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);

            //$pid_success1 = $_POST['out_trade_no'];
            $db->where("partner_refund_id",$partner_refund_id);
            $refund_success_update = $db->update('transaction_alipay', $data_refs);

            $refund_suc_res_pos = array(
                "transaction_status" => $result_code,
                "refund_amount" => $refund_amount,//$_POST['refund_amount'],
                "out_trade_no" => $partner_refund_id,//$_POST['out_trade_no'],
                "terminal_id" => $terminal_id
            );

            $refund_encode = json_encode($refund_suc_res_pos);
            header('Content-Type: application/json');
            echo $refund_encode;

        } else {
            //echo $result_code; exit;
            $data_ref = array(
                "transaction_status" => $result_code,
                "refund_amount" => $refund_amount,
                "out_trade_no" => $partner_refund_id,
                "terminal_id" => $terminal_id
            );
            $data_refs = array(
               "result_code" => $result_code,
               "error" => $error,
               "sign" => $sign,
               "sign_type" => $sign_type
            );


            $db->where("partner_refund_id",$partner_refund_id);
            $refund_error_update = $db->update('transaction_alipay', $data_refs);
        
            $refund_encode1 = json_encode($data_refs);
            header('Content-Type: application/json');
            echo $refund_encode1;
        }
exit;


}else if($ttype == 33) {          /* ttype=33, Query-test */
        $terminal_id = $_POST['terminal_id'];
        $chang=0;
        $partner_trans_id = $_POST['orig_out_trade_no'];
        $query_data_ins = array(
            "terminal_id" => $terminal_id,
            "partner_trans_id" => $partner_trans_id,
            "transaction_type" => $ttype,
            "trans_datetime" => date('Y-m-d H:i:s'),
            "trans_time" => date('H:i:s'),
            "trans_date" => date('Y-m-d')
        );
        /* Query log data received from Pos */
        $query_log = "Query request data from pos:\n".date("Y-m-d H:i:sa") . "\n---------------------\nRequest Data:\n" . json_encode($query_data_ins) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $query_log . PHP_EOL, FILE_APPEND | LOCK_EX);

     /* Inserting query request data received from pos into Transaction table */
       
        $query_insert = $db->insert('transaction_alipay', $query_data_ins);

    /* Query data send to alipay*/

        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "partner" => $alipay_config['partner-qr'],
            "partner_trans_id" => $partner_trans_id,
            "service" => 'alipay.acquire.overseas.query',
            "sign_type" => $alipay_config['sign_type'],
            "sign" => $alipay_config['key-qr'],
        );
    /* Query data log ,send to alipay*/
        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query Request Data:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        /* Query response log */

        if(curl_errno($ch)) {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nQuery Response:\n".curl_errno($ch) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $log = date("Y-m-d H:i:sa") . "\n---------------------\nQuery Response:\n" . $server_output . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $detail_error_code = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
        $detail_error_des = $alipaySubmit->get_from_tag($server_output, '<detail_error_des>', '</detail_error_des>');
        $partner_trans_id = $alipaySubmit->get_from_tag($server_output,'<partner_trans_id>', '</partner_trans_id>');
            $is_success = $alipaySubmit->get_from_tag($server_output, '<is_success>', '</is_success>');
            $partner = $alipaySubmit->get_from_tag($server_output, '<partner>', '</partner>');
            $input_charset = $alipaySubmit->get_from_tag($server_output, '<_input_charset>', '</_input_charset>');
            $service = $alipaySubmit->get_from_tag($service, '<service>', '</service>');
            $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');
            $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $alipay_buyer_login_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_login_id>', '</alipay_buyer_login_id>');
            $alipay_buyer_user_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_user_id>', '</alipay_buyer_user_id>');
            $alipay_pay_time = $alipaySubmit->get_from_tag($server_output, '<alipay_pay_time>', '</alipay_pay_time>');
            $alipay_trans_id = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
            $alipay_trans_status = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_status>', '</alipay_trans_status>');
            $currency = $alipaySubmit->get_from_tag($server_output, '<currency>', '</currency>');
            $trans_amount_cny = $alipaySubmit->get_from_tag($server_output, '<trans_amount_cny>', '</trans_amount_cny>');
            $exchange_rate = $alipaySubmit->get_from_tag($server_output, '<exchange_rate>', '</exchange_rate>');
            $forex_total_fee = $alipaySubmit->get_from_tag($server_output, '<forex_total_fee>', '</forex_total_fee>');
            $out_trade_no = $alipaySubmit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
            $trans_amount = $alipaySubmit->get_from_tag($server_output, '<trans_amount>', '</trans_amount>');
            $trans_forex_rate =$alipaySubmit->get_from_tag($server_output, '<trans_forex_rate>', '</trans_forex_rate>');
            $error =$alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
            $retry_flag = $alipaySubmit->get_from_tag($server_output, '<retry_flag>', '</retry_flag>');
        if ($result_code == "SUCCESS") {
             
            $data2 = array(
                "currency" => $currency,
                "result_code" => $result_code,
                "buyer_email" => $alipay_buyer_login_id,
                "res_price" => $trans_amount_cny,
                "is_success" => $is_success,
                "trade_status" => $alipay_trans_status,
                "partner_trans_id" => $partner_trans_id,
                "buyer_id" => $alipay_buyer_user_id,
                "gmt_payment" => $alipay_pay_time,
                "res_sign_type" => $sign_type,
                "res_sign" => $sign,
                "trans_amount" => $trans_amount,
                "error" => $error
            );//print_r($data2);exit;

            $query_response = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query response update in table:\n" . json_encode($data2) . " \n\n";
        $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);

        /*Updating query Success response in transaction table */

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$ttype);
            $query_update = $db->update('transaction_alipay', $data2);
            
            $query_succs_res_pos = array(
                "transaction_status" => $alipay_trans_status,
                "amount" => $forex_total_fee,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            ); 
            $query_response_to_pos = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query response send to pos:\n" . json_encode($query_succs_res_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response_to_pos . PHP_EOL, FILE_APPEND | LOCK_EX);

            $query_succs_res_pos_encode = json_encode($query_succs_res_pos);
            header('Content-Type: application/json');
            echo $query_succs_res_pos_encode;  


        }else{
                $query_error_res_pos = array(
                    "detail_error_code" => $detail_error_code,
                    "detail_error_des" => $detail_error_des,
                    "partner_trans_id" => $partner_trans_id,
                    "retry_flag" => $retry_flag,
                    "sign_type" => $sign_type,
                    "sign" => $sign
                );

            $query_response = "Application Log:\n".date("Y-m-d H:i:sa") . "\n---------------------\n Query failure response:\n" . json_encode($query_error_res_pos) . " \n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);
            /*Updating query error response in transaction stable */
                $db->where("partner_trans_id",$partner_trans_id);
                $db->where("transaction_type",$ttype);
    $query_err_update = $db->update('transaction_alipay',$query_error_res_pos);

                $data_err_query = array(
                "transaction_status" => $alipay_trans_status,
                "amount" => $forex_total_fee,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
                );

                $query_err_res_pos_encode = json_encode($query_error_res_pos);
                header('Content-Type: application/json');
                echo $query_err_res_pos_encode;  

        }
    }
/* Test case ends here */
//pos test end 210918

?>