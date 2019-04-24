<?php
session_start();
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

// date_default_timezone_set("Asia/Hong_Kong");
date_default_timezone_set("Asia/Kolkata");

function conversionfrom_indiatochinatime($datetime) {
    $given_cncl = new DateTime($datetime);
    $given_cncl->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
    $updated_datetime_cncl = $given_cncl->format("Y-m-d H:i:s");
    return $updated_datetime_cncl;
}

require_once("alipay.config.php");
// require_once("lib/alipay_submit.class.php");
// require_once("lib/alipay_md5.function.php");
require_once("MD5HtmlBuildSubmit.php");

$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

$path = $alipay_config['log-path'];

// if($_POST['from']!="pg") { }

/*MD5 class definition */
$HtmlBuild_Submit = new MD5HtmlBuildSubmit();

/**************************请求参数**************************/
/**************************request parameter**************************/
//商户订单号，商户网站订单系统中唯一订单号，必填
//merchant order no,the unique transaction ID specified in merchant system ,not null
if($_POST['action'] == 's1') {
    $out_trade_no = $_POST['terminal_id'].date('YmdHis');
} else {
    $out_trade_no = $_POST['WIDout_trade_no'];    
}

//订单名称，必填
//order name  ,not null
$subject = $_POST['WIDsubject'];

//付款外币币种，必填
//The settlement currency code the merchant specifies in the contract. ,not null
$currency = $_POST['currency'];

//付款外币金额，必填
//payment amount in foreign currency ,not null
$total_fee  = $_POST['WIDtotal_fee'];

$merchantid = $_POST['merchantid'];

$userPhone     = $_POST['userPhone']!='' ? $_POST['userPhone'] : '';
$refund_reason = $_POST['ref_reason']!='' ? $_POST['ref_reason'] : '';

// Get the Merchant Details
$db->where('mer_map_id',$merchantid);
$merchant_details = $db->getOne("merchants");
$pcrq = explode("~",$merchant_details['pcrq']);
$purchase_flag = $pcrq[0];
$cancel_flag   = $pcrq[1];
$refund_flag   = $pcrq[2];
$query_flag    = $pcrq[3];

$merchant_active = $merchant_details['is_active'];

// Get the Alipay Config details
$db->where('currency',$currency);
$db->where('merchant_id',$merchantid);  
$cur_res = $db->getOne('alipay_config');
$alipay_partner_id = $cur_res['partner_id'];
$alipay_key_md5    = $cur_res['key_md5'];
/* Making sign as SESSION variable ,use in MD5*/
$_SESSION['sign'] = $alipay_key_md5;

$terminal_id = $_POST['terminal_id'];

$callback_notify_url = $_POST['callback_notify_url'];

//商品描述，可空
//product description ,nullable
$body = $_POST['WIDbody'];
$secondary_merchant_id = $_POST['secondary_merchant_id'];
$secondary_merchant_industry = $_POST['secondary_merchant_industry'];
$secondary_merchant_name = $_POST['secondary_merchant_name'];
//product_code
$product_code = $_POST['WIDproduct_code'];
$split_fund_info = $_POST['WIDsplit_fund_info'];
//************************************************************/

$terminal_empty = "Terminal Id Received Empty From POS";
$terminal_wrong = "Terminal Id Wrong";

/** Log File Function starts **/
function alipayqrlogs($log) {
    global $path;
    $myfile = file_put_contents($path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
}
/**  Log File Function Ends **/

function terminal_check($terminal_id, $log_path) {
    global $db;
    if($terminal_id!="") {
        $db->where("mso_terminal_id", $terminal_id);
        $terminal_res = $db->getOne("terminal");
        $terminalIdds = $terminal_res['mso_terminal_id'];
        $terminal_active = $terminal_res['active']; 
        $ter_act = array(
            'terminal_id'=> $terminalIdds,
            'active' => $terminal_active
        );
        if($terminalIdds != "" && $terminal_active == 1) {
            $merchant_id  = $terminal_res['idmerchants'];
            $mso_location = $terminal_res['mso_ter_location'];

            $terminal_active_sts = "Terminal Acive Log:".date("Y-m-d H:i:sa").", Terminal Id ".$terminal_id." is Active"."\n\n";
            $myfile = file_put_contents($log_path, $terminal_active_sts . PHP_EOL, FILE_APPEND | LOCK_EX);
            return TRUE;

        } else if($terminalIdds != "" && $terminal_active != 1) {
            $terminal_active_sts = "Terminal Acive Log:".date("Y-m-d H:i:sa").", Terminal Not Active Id:" .json_encode($ter_act)."\n\n";
            $myfile = file_put_contents($log_path, $terminal_active_sts . PHP_EOL, FILE_APPEND | LOCK_EX);
            return FALSE;
            echo 'Terminal Id Not Active';
            exit;
            die();
        } else {
            $terminal_id_empty = "Terminal Id wrong Log:".date("Y-m-d H:i:sa").", Received wrong terminal From pos:" .$terminal_wrong."\n\n";
            $myfile = file_put_contents($log_path, $terminal_id_empty . PHP_EOL, FILE_APPEND | LOCK_EX);
            return FALSE;
            echo 'Terminal Id Wrong';
            die();
        }
    } else {
        $terminal_id_empty = "POS terminal check Log:".date("Y-m-d H:i:sa").", Received empty terminal From pos:" .$terminal_empty."\n\n";
        $myfile = file_put_contents($log_path, $terminal_id_empty . PHP_EOL, FILE_APPEND | LOCK_EX);
        return FALSE;
        echo 'Terminal Id Empty';
        die();
    }
}

if($merchant_active != 1) {
    $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Merchant ID : ".$merchantid." is Disabled\n\n";
    // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    alipayqrlogs($log);
    echo "<br><br><h4><center><b>Merchant is Disabled</b></center></h4><br><br>";
    die();
}

$terminal_check = terminal_check($terminal_id, $alipay_config['log-path']);

/******* Static QR Code Payment ********/
if(isset($_POST['device']) && $_POST['device'] == 'QR' && $terminal_check == 1) {

    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d', strtotime($datetime));
    $time = date('H:i:s', strtotime($datetime));
    $datetime_ch = conversionfrom_indiatochinatime($datetime);

    $transaction_type = $_POST['action'];
    if($transaction_type=='s1') { // PURCHASE (OR) SALE
        // $extend_param = '{"secondary_merchant_name":"Lotte","secondary_merchant_id":"123","secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
        // $extend_param = '{"secondary_merchant_name":"Lotte","secondary_merchant_id":"123","secondary_merchant_industry":"56565665","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';

        // Check if the merchant's purchase enabled or not
        if($purchase_flag != 1) {
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Purchase not enabled in this merchant\n\n";
            $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            echo "<br><br><center><b>Purchase not enabled in this merchant</b></center><br><br>";
            die();
        }

        $db->where('mer_map_id',$merchantid);
        $merchant_details = $db->getOne("merchants");

        $name_split = explode(' ',$merchant_details['merchant_name']);

        $secondary_merchant_name_init = preg_replace('!\s+!', ' ',$merchant_details['merchant_name']);
        $secondary_merchant_name = str_replace(' ','_',$secondary_merchant_name_init);

        $secondary_merchant_id = $merchant_details['mer_map_id'];
        $secondary_merchant_industry = $merchant_details['mcc'];
        $currency_code = $merchant_details['currency_code'];

        $store_id = $merchant_details['mer_map_id'];
        $store_name = $name_split[0];

        $extend_param = '{"secondary_merchant_name":"'.$secondary_merchant_name.'", "secondary_merchant_id":"'.$secondary_merchant_id.'", "secondary_merchant_industry":"'.$secondary_merchant_industry.'","store_id":"'.$store_id.'","store_name":"'.$store_name.'"}';

        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "currency" => $currency,
            "extend_params" => $extend_param,
            "notify_url"    => $alipay_config['notify_url'],
            "out_trade_no" => $out_trade_no,
            "partner" => $alipay_partner_id,
            "passback_parameters" => "success",
            "product_code" => $product_code,
            "service" => $alipay_config['service-qr-pcr'],
            "subject" => $subject,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "trans_currency" => $currency
        );
        // "sign" => '', // $alipay_key_md5,
        // "sign_type" => '', // $alipay_config['sign_type'],

        $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Request Data:" . json_encode($parameter)."\n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        $parameter_ins = array(
            "currency" => $currency,
            "out_trade_no" => $out_trade_no,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "cst_trans_datetime" => $datetime_ch,
            "trans_datetime" => $datetime,
            "trans_time" => $time,
            "trans_date" => $date,
            "transaction_type" => $transaction_type,
            "terminal_id" => $terminal_id,
            "merchant_id" => $merchantid,
            "buyer_user_id" => $userPhone
        );
        // "mer_callback_url" => $callback_notify_url

        $insert_precreate = $db->insert('transaction_alipay', $parameter_ins);

        $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Request Data to insert:" . json_encode($parameter)."\n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        // $alipaySubmit = new AlipaySubmit($alipay_config);
        // $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
        /* MD5 class parameter passing to function*/ 
        $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

        $log = "Application Log POS:".date("Y-m-d H:i:s") . " Build Data:" . $html_text. " \n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        $url= $alipay_config['alipay_url'] . $html_text;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Pre-create Response:".$server_output . " \n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        $qrcode = $HtmlBuild_Submit->get_from_tag($server_output, '<qr_code>','</qr_code>');
        $result_code = $HtmlBuild_Submit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $error = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
        $detail_error_code = $HtmlBuild_Submit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
        $is_success =$HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
        $qrImage  = $HtmlBuild_Submit->get_from_tag($server_output, '<small_pic_url>','</small_pic_url>');
        $big_pic = $HtmlBuild_Submit->get_from_tag($server_output, '<big_pic_url>','</big_pic_url>');
        $voucher_type =  $HtmlBuild_Submit->get_from_tag($server_output, '<voucher_type>','</voucher_type>');       
        $sign = $HtmlBuild_Submit->get_from_tag($server_output, '<sign>','</sign>');
        $sign_type = $HtmlBuild_Submit->get_from_tag($server_output, '<sign_type>','</sign_type>');
        $out_trade_no_resp = $HtmlBuild_Submit->get_from_tag($server_output, '<out_trade_no>','</out_trade_no>'); 

        $data = array(
            "big_pic_url" => $big_pic,
            "pic_url" => $qrImage,
            "qr_code" => $qrcode,
            "result_code" => $result_code,
            "small_pic_url" => $qrImage,
            "voucher_type" => $voucher_type,
            "is_success" => $is_success,
            "input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "extend_params" => $extend_param,
            "notify_url" => $alipay_config['notify_url'],
            "partner" => $alipay_partner_id,
            "passback_parameters" => "success",
            "service" => $alipay_config['service-qr-pcr'],
            "sign" => $sign,
            "sign_type" => $sign_type,
            "trans_currency" => $currency,
            "merchant_id" => $merchantid,
            "product_code" => $product_code,
            "subject" => $subject
        );

        $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Pre-create Response Update to Table : ".json_encode($data) . " \n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        // "sign" => $alipay_key_md5,
        // "sign_type" => $alipay_config['sign_type'],

        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type",$transaction_type);
        $trans_update = $db->update('transaction_alipay', $data);

        // $id_transaction_id = $db->insert('transaction_alipay', $data);

        if ($result_code != "SUCCESS") {
            $error_code = $HtmlBuild_Submit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
            $db->where("error_code", $error_code);
            $errres=$db->get('alipay_errors');
            ?><br><br><br><br><br><br><br><br><br>
            <div class="row" style="font-size: 30px;">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?php echo $error_code; ?>!</strong> <br><br><p><?php echo $errres[0]['error_desc']; ?></p>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <?php
        } else {
            echo "<br><br><center><b>Redirecting to Payment URL in few seconds...</b></center><br><br>";
            echo '<center><img src="load.gif" alt="Loading" id="gif" style="width: 100px; height:  100px;"></center>';

            header("Refresh:0; url=" . $qrcode);
        }
        exit;
        /*echo $html_text;
        exit;*/
    }

    if($transaction_type=='s2') { // Refund / Partial Refund
        // echo "<pre>";
        // print_r($_POST); exit;

        // Check if the merchant's refund enabled or not
        if($refund_flag != 1) {
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund not enabled in this merchant\n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
            echo "<br><br><center><b>Refund not enabled in this merchant</b></center><br><br>";
            die();
        }

        //Fetch transaction to check its already refunded or not
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type", $transaction_type);
        $db->where("result_code", 'SUCCESS');
        $transDet = $db->getone('transaction_alipay');
        if($transDet) {
            // echo "Hi1";
            $response = array(
                'res' => "Transaction was already refunded",
                'desc' => ""
            );
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund Response:Transaction Already Refunded\n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
        } else {
            // echo "Hi2";
            $refund_req_data = array(
                "currency" => $_POST['currency'],
                "merchant_id" => $merchantid,
                "partner_trans_id" => $_POST['partner_trans_id'],
                "partner_refund_id" => $_POST['partner_refund_id'],
                "refund_amount" => $_POST['return_amount'],
                "out_trade_no" => $_POST['partner_refund_id'],
                "terminal_id" => $terminal_id,
                "transaction_type" => $transaction_type,
                "cst_trans_datetime" => $datetime_ch,
                "trans_datetime" => $datetime,
                "trans_time" => $time,
                "trans_date" => $date,

                "refund_reason" => $refund_reason
            ); 
            /* Refund request data log creation */
            $ref_req_data_pos = "Application Log QR : "."Application Log:".date("Y-m-d H:i:sa").", Request Insert Data:" . json_encode($refund_req_data)."\n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $ref_req_data_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($ref_req_data_pos);
            /* Refund request data inserting,received from POS */
            $refund_req_ins = $db->insert('transaction_alipay',$refund_req_data);

            // Refund request data to Alipay
            $parameter = array(
                "currency" => $_POST['currency'],
                "partner" => $alipay_partner_id,
                "partner_trans_id" => $_POST['partner_trans_id'],
                "partner_refund_id" => $_POST['partner_refund_id'],
                "refund_amount" => $_POST['return_amount'],
                "service" => $alipay_config['service-re-qr'],
            );
            // "sign" => '',
            // "sign_type" => ''

            // Refund request data to Alipay -  log
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund request data to alipay:" . json_encode($parameter) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);

            // $alipaySubmit = new AlipaySubmit($alipay_config);
            // $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
            /* MD5 class parameter passing to function*/ 
            $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Build Data:" . $html_text. " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);

            $url = $alipay_config['alipay_url'] . $html_text;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);

            /* Refund response log */
            if(curl_errno($ch)) {
                $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund Response:".curl_errno($ch)."\n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($log);
                die();
            } else {
                $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund Response:" . $server_output."\n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($log);
            }

            $result_code = $HtmlBuild_Submit->get_from_tag($server_output, '<result_code>', '</result_code>');
            $desc = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
            $is_success = $HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
            $refund_amount = $HtmlBuild_Submit->get_from_tag($server_output, '<refund_amount>', '</refund_amount>');
            $currency = $HtmlBuild_Submit->get_from_tag($server_output, '<currency>', '</currency>');
            $error = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
            $partner_refund_id = $HtmlBuild_Submit->get_from_tag($server_output, '<partner_refund_id>', '</partner_refund_id>');
            $partner_trans_id = $HtmlBuild_Submit->get_from_tag($server_output, '<partner_trans_id>', '</partner_trans_id>');
            $sign = $HtmlBuild_Submit->get_from_tag($server_output, '<sign>', '</sign>');
            $sign_type = $HtmlBuild_Submit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $alipay_trans_id = $HtmlBuild_Submit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
            $exchange_rate = $HtmlBuild_Submit->get_from_tag($server_output, '<exchange_rate>', '</exchange_rate>');
            $refund_amount_cny = $HtmlBuild_Submit->get_from_tag($server_output, '<refund_amount_cny>', '</refund_amount_cny>');

            if ($result_code == "SUCCESS") {
                $refund_data = array(
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

                $refund_succ_res_upd = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund success response update in table:" . json_encode($refund_data) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $refund_succ_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($refund_succ_res_upd);
                
                /* Update refund response in transaction table */
                // $db->where("out_trade_no",$partner_trans_id);
                // $refund_success_update1 = $db->update('transaction_alipay', $refund_data);

                $db->where("partner_refund_id",$partner_refund_id);
                $db->where("transaction_type",$transaction_type);
                $refund_success_update = $db->update('transaction_alipay', $refund_data);

                $response = array(
                    "out_trade_no" => $partner_refund_id,
                    "res" => $result_code,
                    "desc" => $detail_error_code
                );
                $refund_suc_res_pos_log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund response send to pos:" . json_encode($response) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $refund_suc_res_pos_log . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($refund_suc_res_pos_log);

            } else if ($result_code != "SUCCESS" && $result_code != "FAILED") {
                $refund_data = array(
                    "result_code" => 'TIME OUT',
                    "refund_amount" => $_POST['return_amount'],
                    "out_trade_no" => $partner_refund_id
                );
                $response = array(
                    "out_trade_no" => $partner_refund_id,
                    "res" => 'TIME OUT',
                    "desc" => $detail_error_code
                );

                $refund_empty_res = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund empty response update in table:" . json_encode($refund_data)."\n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $refund_empty_res . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($refund_empty_res);
                
                /* Update refund empty response in transaction table */
                $db->where("partner_refund_id",$partner_refund_id);
                $db->where("transaction_type",$transaction_type);
                $refund_empty_update = $db->update('transaction_alipay', $refund_data);

                $refund_empty_res_pos = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund empty response sent to pos:" . json_encode($res_empty_pos) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $refund_empty_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($refund_empty_res_pos);
            
            } else {
                $refund_data = array(
                   "is_success" => $is_success,
                   "result_code" => $result_code,
                   "error" => $error,
                   "res_sign" => $sign,
                   "res_sign_type" => $sign_type
                );

                $refund_err_res_upd = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund error response update in table:" . json_encode($refund_data) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $refund_err_res_upd . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($refund_err_res_upd);

                // $db->where("out_trade_no",$_POST['orig_out_trade_no']);
                // $refund_error_update1 = $db->update('transaction_alipay', $refund_data);
                $db->where("partner_refund_id",$partner_refund_id);
                $db->where("transaction_type",$transaction_type);
                $refund_error_update = $db->update('transaction_alipay', $refund_data);

                $response = array(
                    "out_trade_no" => $partner_refund_id,
                    "res" =>  $result_code,
                    "desc" => $detail_error_code
                );

                $refund_err_res_pos_log = "Application Log QR : ".date("Y-m-d H:i:sa").", Refund error response send to pos:" . json_encode($response) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $refund_err_res_pos_log . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($refund_err_res_pos_log);
            }

        }
        print_r(json_encode($response));
        exit;
    }

    if($transaction_type=='s4') { // Cancel

        // echo "<pre>";
        // print_r($_POST); exit; die();

        // Check if the merchant's cancel enabled or not
        if($cancel_flag != 1) {
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel not enabled in this merchant\n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
            echo "<br><br><center><b>Cancel not enabled in this merchant</b></center><br><br>";
            die();
        }

        // Fetch transaction to check its already cancelled or not
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type", $transaction_type);
        $db->where("result_code", 'SUCCESS');
        $transDet = $db->getone('transaction_alipay');

        // Get the success transaction details
        $db->where("out_trade_no", $out_trade_no);
        $db->where("transaction_type", 's1');
        $amount_get = $db->getOne('transaction_alipay');
        $amount = $amount_get['total_fee'];
        $currency = $amount_get['currency'];

        // echo "<pre>";
        // print_r($_POST); 
        // echo "<br>";
        // echo $out_trade_no;
        // echo "<pre>";
        // print_r($amount_get);
        // // echo $amount; 
        // exit; die(); 

        if($transDet) {
            // echo "Hi1";
            $response = array(
                'res' => "Transaction was already cancelled",
                'desc' => ""
            );
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Response:Transaction was already cancelled \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
        } else {
            // echo "Hi2";
            $can_req_data = array(
                "currency" => $currency,
                "total_fee" => $amount, 
                "merchant_id" => $merchantid,
                "terminal_id" => $terminal_id,
                "transaction_type" => $transaction_type,
                "out_trade_no" => $out_trade_no,
                "cst_trans_datetime" => $datetime_ch,
                "trans_datetime" => $datetime,
                "trans_time" => $time,
                "trans_date" => $date
            );

            $can_data_pos= "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Request Insert Data:" . json_encode($can_req_data) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $can_data_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($can_data_pos);
            $can_insert = $db->insert('transaction_alipay', $can_req_data);

            $parameter = array(
                "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
                "out_trade_no" => $out_trade_no,
                "partner" => $alipay_partner_id,
                "service" => $alipay_config['service-qr-cl'],
                "timestamp" => $_POST['timestamp']
            );

            // "sign" => $alipay_key_md5,
            // "sign_type" => $alipay_config['sign_type'],

            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Request Data:" . json_encode($parameter) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);

            // $alipaySubmit = new AlipaySubmit($alipay_config);
            // $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
            /* MD5 class parameter passing to function*/ 
            $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Build Data:" . $html_text. " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);

            //echo $html_text;
            $url = $alipay_config['alipay_url'] . $html_text;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);

            if(curl_errno($ch)) {
                $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Response:".curl_errno($ch) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($log);
                die();
            } else {
                $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Response:" . $server_output . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($log);
            }

            $result_code = $HtmlBuild_Submit->get_from_tag($server_output, '<result_code>', '</result_code>');
            $is_success = $HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
            $sign_type = $HtmlBuild_Submit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $sign = $HtmlBuild_Submit->get_from_tag($server_output, '<sign>', '</sign>');
            $error = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
            $trade_no = $HtmlBuild_Submit->get_from_tag($server_output, '<trade_no>', '</trade_no>');
            $out_trade_no_res = $HtmlBuild_Submit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
            $retry_flag = $HtmlBuild_Submit->get_from_tag($server_output, '<retry_flag>', '</retry_flag>');
            $action = $HtmlBuild_Submit->get_from_tag($server_output, '<action>', '</action>');
            $detail_error_code = $HtmlBuild_Submit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
            $detail_error_des = $HtmlBuild_Submit->get_from_tag($server_output, '<detail_error_des>', '</detail_error_des>');

            if ($result_code == "SUCCESS") {
                $response_data = array(
                    "is_success" => $is_success,
                    "result_code" => $result_code,
                    "sign_type" => $sign_type,
                    "sign" => $sign,
                    "out_trade_no" => $out_trade_no_res,
                    "trade_no" => $trade_no,
                    "retry_flag" => $retry_flag
                );
                $can_response_success = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Success response update in table:" . json_encode($response_data)."\n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $can_response_success . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($can_response_success);

                $db->where("out_trade_no",$out_trade_no);
                $db->where("transaction_type",$transaction_type);
                $update = $db->update('transaction_alipay', $response_data);
                
                $response = array(
                    "out_trade_no" => $out_trade_no,
                    "res" => $result_code,
                    "desc" => $detail_error_code
                );

                $can_succs_res_pos= "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel Success response:" . json_encode($response) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $can_succs_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX); 
                alipayqrlogs($can_succs_res_pos);

            } else {
                $response_data = array(
                    "result_code" => $result_code,
                    "detail_error_code" => $detail_error_code,
                    "detail_error_des" => $detail_error_des,
                    "sign" => $sign,
                    "sign_type" => $sign_type
                );
                $can_response_error = "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel error response update in table:" . json_encode($response_data) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $can_response_error . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($can_response_error);

                $db->where("out_trade_no",$out_trade_no);
                $db->where("transaction_type",$transaction_type);
                $cancel_update = $db->update('transaction_alipay', $response_data);

                $response = array(
                    "out_trade_no" => $out_trade_no,
                    "res" => $result_code,
                    "desc" => $detail_error_code
                );

                $can_err_res_pos= "Application Log QR : ".date("Y-m-d H:i:sa").", Cancel error response to pos:" . json_encode($response) . " \n\n";
                // $myfile = file_put_contents($alipay_config['log-path'], $can_err_res_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
                alipayqrlogs($can_err_res_pos);
            }
        }
        print_r(json_encode($response));
        exit;  
    }

    if($transaction_type=='s3') { // Query

        // echo "<pre>";
        // print_r($_POST); exit;

        // Check if the merchant's query enabled or not
        if($query_flag != 1) {
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query not enabled in this merchant\n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
            echo "<br><br><center><b>Query not enabled in this merchant</b></center><br><br>";
            die();
        }

        $partner_trans_id = $_POST['out_trade_no'];
        // Checking transaction success or not ,if success dont send request to alipay
        $db->where("out_trade_no", $partner_trans_id);
        $trans_result = $db->getOne("transaction_alipay");
        $trade_status_org = $trans_result['trade_status'];
        $total_fee_org = $trans_result['total_fee'];
        $result_code_org = $trans_result['result_code'];

        if($trade_status_org == 'TRADE_SUCCESS') {
            $transquery_stts = array(
                "transaction_status" => $result_code_org,
                "amount" => $total_fee_org,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            );     
            $trans_succ_log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query Status send to pos:" . json_encode($transquery_stts) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $trans_succ_log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($trans_succ_log);
            $query = 2;
            echo $query;
            exit;
            die();
        }

        if($trade_status_org == 'TRADE_CLOSED') {
            $transquery_stts = array(
                "transaction_status" => $result_code_org,
                "amount" => $total_fee_org,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            );     
            $trans_succ_log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query Status send to pos:" . json_encode($transquery_stts) . "Trade Status already CLOSED \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $trans_succ_log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($trans_succ_log);
            $query = 4;
            echo $query;
            exit;
            die();
        }

        $query_data = array(
            "terminal_id" => $terminal_id,
            "merchant_id" => $merchantid,
            "partner_trans_id" => $partner_trans_id,
            "transaction_type" => $transaction_type,
            "cst_trans_datetime" => $datetime_ch,
            "trans_datetime" => $datetime,
            "trans_time" => $time,
            "trans_date" => $date
        );
        // Query log data received from Pos
        $query_log = "Application Log QR : ".", Query request data from pos:".date("Y-m-d H:i:sa").", Request Data insert in table:" . json_encode($query_data) . " \n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $query_log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($query_log);
        // Inserting query request data received from pos into Transaction table
        $query_insert = $db->insert('transaction_alipay', $query_data);

        // Query data send to alipay
        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "partner" => $alipay_partner_id,
            "partner_trans_id" => $partner_trans_id,
            "service" => $alipay_config['service-qy-qr']    
        );
        // "sign_type" => $alipay_config['sign_type'],
        // "sign" => $alipay_key_md5

        // Query data log ,send to alipay
        $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query Request Data:" . json_encode($parameter) . " \n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        // $alipaySubmit = new AlipaySubmit($alipay_config);
        // $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
        /* MD5 class parameter passing to function*/ 
        $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

        $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query Build Data:" . $html_text. " \n\n";
        // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
        alipayqrlogs($log);

        $url = $alipay_config['alipay_url'] . $html_text;
        // $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        /* Query response log */
        if(curl_errno($ch)) {
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query Response:\n".curl_errno($ch) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
            die();
        } else {
            $log = "Application Log QR : ".date("Y-m-d H:i:sa").", Query Response:\n" . $server_output . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($log);
        }

        $result_code = $HtmlBuild_Submit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $partner_trans_id = $HtmlBuild_Submit->get_from_tag($server_output,'<partner_trans_id>', '</partner_trans_id>');
        $is_success = $HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
        $partner = $HtmlBuild_Submit->get_from_tag($server_output, '<partner>', '</partner>');
        $input_charset = $HtmlBuild_Submit->get_from_tag($server_output, '<_input_charset>', '</_input_charset>');
        $service = $HtmlBuild_Submit->get_from_tag($service, '<service>', '</service>');
        $sign = $HtmlBuild_Submit->get_from_tag($server_output, '<sign>', '</sign>');
        $sign_type = $HtmlBuild_Submit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
        $alipay_buyer_login_id = $HtmlBuild_Submit->get_from_tag($server_output, '<alipay_buyer_login_id>', '</alipay_buyer_login_id>');
        $alipay_buyer_user_id = $HtmlBuild_Submit->get_from_tag($server_output, '<alipay_buyer_user_id>', '</alipay_buyer_user_id>');
        $alipay_pay_time = $HtmlBuild_Submit->get_from_tag($server_output, '<alipay_pay_time>', '</alipay_pay_time>');
        $alipay_trans_id = $HtmlBuild_Submit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
        $alipay_trans_status = $HtmlBuild_Submit->get_from_tag($server_output, '<alipay_trans_status>', '</alipay_trans_status>');
        $currency = $HtmlBuild_Submit->get_from_tag($server_output, '<currency>', '</currency>');
        $trans_amount_cny = $HtmlBuild_Submit->get_from_tag($server_output, '<trans_amount_cny>', '</trans_amount_cny>');
        $exchange_rate = $HtmlBuild_Submit->get_from_tag($server_output, '<exchange_rate>', '</exchange_rate>');
        $forex_total_fee = $HtmlBuild_Submit->get_from_tag($server_output, '<forex_total_fee>', '</forex_total_fee>');
        $out_trade_no_res = $HtmlBuild_Submit->get_from_tag($server_output, '<out_trade_no>', '</out_trade_no>');
        $trans_amount = $HtmlBuild_Submit->get_from_tag($server_output, '<trans_amount>', '</trans_amount>');
        $trans_forex_rate =$HtmlBuild_Submit->get_from_tag($server_output, '<trans_forex_rate>', '</trans_forex_rate>');
        $error =$HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
        $detail_error_code = $HtmlBuild_Submit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');

        if($result_code == "SUCCESS" && ($alipay_trans_status == "TRADE_CLOSED" || $alipay_trans_status == "WAIT_BUYER_PAY") ) {

            $query_trade_res = array(
                "buyer_email" => $alipay_buyer_login_id,
                "res_sign_type" => $sign_type,
                "res_sign" => $sign,
                "result_code" => $result_code,
                "alipay_buyer_user_id" => $alipay_buyer_user_id,
                "alipay_trans_id" => $alipay_trans_id,
                "currency" => $currency,
                "exchange_rate" => $exchange_rate,
                "out_trade_no" => $out_trade_no_res,
                "partner_trans_id" => $partner_trans_id,
                "is_success" => $is_success,
                "trade_status" => $alipay_trans_status,
                "trans_amount" => $trans_amount,
                "alipay_trans_status" => $alipay_trans_status
            );

            // "total_fee" => $forex_total_fee,

            $query_response = "Application Log QR : ".date("Y-m-d H:i:sa")."Query trade closed response update:" . json_encode($query_trade_res) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($query_response);

            // Updating query trade response in transaction stable
            $db->where("out_trade_no",$partner_trans_id);
            $query_update3 = $db->update('transaction_alipay',$query_trade_res);

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$transaction_type);
            $query_update4 = $db->update('transaction_alipay', $query_trade_res);

            $error_description = $db->get('error_details');
            foreach ($error_description as $key => $value) {
                if($value['error'] == $alipay_trans_status) {
                    $des = $value['description'];
                }
            }

            $data_trade_query = array(
                "transaction_status" => $des,
                "amount" => $forex_total_fee,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            );

            $query_trade_res1 = "Application Log QR : ".date("Y-m-d H:i:sa").", Query trade response send to pos:" . json_encode($data_trade_query) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $query_trade_res1 . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($query_trade_res1);

            if($alipay_trans_status == 'WAIT_BUYER_PAY') {
                $query = 3;
            } else if($alipay_trans_status == 'TRADE_CLOSED') {
                $query = 4;
            }

        } else if ($result_code == "SUCCESS" && $alipay_trans_status == "TRADE_SUCCESS") {
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
            $query_response = "Application Log QR : ".date("Y-m-d H:i:sa") . ", Query response update in table:" . json_encode($data2) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($query_response);

            // Updating query Success response in transaction table
            $db->where("out_trade_no",$partner_trans_id);
            $query_update1 = $db->update('transaction_alipay', $data2);

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$transaction_type);
            $query_update2 = $db->update('transaction_alipay', $data2);

            $query_succs_res = array(
                "transaction_status" => $result_code,
                "amount" => $forex_total_fee,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            ); 
            $query_response_to_pos = "Application Log QR : ".date("Y-m-d H:i:sa") . ", Query response send to pos:" . json_encode($query_succs_res) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $query_response_to_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($query_response_to_pos);
            $query = 1;

        } else {
            $query_error_res = array(
                "is_success" => $is_success,
                "res_sign_type" => $sign_type,
                "res_sign" => $sign,
                "result_code" => $result_code
            );

            $query_response = "Application Log QR : ".date("Y-m-d H:i:sa") . ", Query failure response update:" . json_encode($query_error_res) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $query_response . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($query_response);

            // Updating query error response in query row
            $db->where("out_trade_no",$partner_trans_id);
            $query_err_update = $db->update('transaction_alipay',$query_error_res);

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$transaction_type);
            $query_err_update2 = $db->update('transaction_alipay', $query_error_res);

            $data_err_query = array(
                "transaction_status" => $result_code,
                "amount" => $forex_total_fee,
                "orig_out_trade_no" => $partner_trans_id,
                "terminal_id" => $terminal_id
            );

            $query_response_pos = "Application Log QR : ".date("Y-m-d H:i:sa") . ", Query failure response to pos:" . json_encode($data_err_query) . " \n\n";
            // $myfile = file_put_contents($alipay_config['log-path'], $query_response_pos . PHP_EOL, FILE_APPEND | LOCK_EX);
            alipayqrlogs($query_response_pos);
            $query = 0;
        }
        echo $query;
        exit;
    }

}

?>