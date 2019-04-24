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

$db = new Mysqlidb ($confighost, $userd, $passd, 'suprpaysez');

date_default_timezone_set("Asia/Hong_Kong");
require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_md5.function.php");
if($_POST['from']!="pg"){ ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php }
/**************************请求参数**************************/
/**************************request parameter**************************/
//商户订单号，商户网站订单系统中唯一订单号，必填
//merchant order no,the unique transaction ID specified in merchant system ,not null
$out_trade_no = $_POST['WIDout_trade_no'];

//订单名称，必填
//order name  ,not null
$subject = $_POST['WIDsubject'];

//付款外币币种，必填
//The settlement currency code the merchant specifies in the contract. ,not null
$currency = $_POST['currency'];

//付款外币金额，必填
//payment amount in foreign currency ,not null
$total_fee = $_POST['WIDtotal_fee'];

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

//pos test 210918
if(isset($_POST['device']) && $_POST['device'] == 'pos'){
    $string = $_GET['qstring'];
    $device = $_POST['device'];
    $terminal_id = $_POST['terminal_no'];
    //$amount = $_POST['WIDtotal_fee'];
    //$currency = $_POST['currency'];
    $terminal_time = $_POST['ter_time_stamp'];
    //$out_trade_no = $_POST['WIDout_trade_no'];
    //$product_code =$_POST['WIDproduct_code'];
    //$subject = $_POST['WIDsubject'];
    $ttype = $_POST['ttype'];
    // echo $device.'<br>';
    // echo $terminal_no.'<br>';
    // echo $amount.'<br>';
    // echo $currency.'<br>';
    // echo $terminal_time.'<br>';
    // echo $out_trade_no.'<br>';
    // echo $ttype.'<br>';
    // echo $string;
    //echo "<pre>";
    //print_r($_POST);

    $extend_param = '{"secondary_merchant_name":"Lotte", "secondary_merchant_id":"123", "secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
    // $parameter = array(
    //     "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
    //     "currency" => $currency,
    //     "extend_params" => $extend_param,
    //     "notify_url"    => $alipay_config['notify_url'],
    //     "out_trade_no" => $out_trade_no,
    //     "partner" => $alipay_config['partner-qr'],
    //     "passback_parameters" => "success",
    //     "product_code" => $product_code,
    //     "service" => $alipay_config['service-qr-pcr'],
    //     "sign" => $alipay_config['key-qr'],
    //     "sign_type" => $alipay_config['sign_type'],
    //     "subject" => $subject,
    //     "timestamp" => date('YmdHis'),
    //     "total_fee" => $total_fee,
    //     "trans_currency" => $currency,
    // );
    $parameter = '{"_input_charset":"utf-8","currency":"USD","extend_params":"{\"secondary_merchant_name\":\"Lotte\", \"secondary_merchant_id\":\"123\", \"secondary_merchant_industry\":\"56565665\",\"store_id\":\"A101\",\"store_name\":\"McDonald in 966 3rd Ave, New York\"}","notify_url":"http:\/\/169.38.91.246\/notify_alipay.php","out_trade_no":"test20180602125404","partner":"2088621894246640","passback_parameters":"success","product_code":"OVERSEAS_MBARCODE_PAY","service":"alipay.acquire.precreate","sign":"rrg7twngys8nktxx3ddghgt3pjb25v8b","sign_type":"MD5","subject":"Alipay","timestamp":"20180602205425","total_fee":"20","trans_currency":"USD"}';
    $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" .$parameter. " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG_vino.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $alipaySubmit = new AlipaySubmit($alipay_config);
    $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

    $url="https://openapi.alipaydev.com/gateway.do?".$html_text;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    if(curl_errno($ch)){
    $log = date("Y-m-d H:i:sa") . "\n
---------------------\nPre-create Response:\n" . curl_errno($ch) . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG_vino.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    } else {
    $log = date("Y-m-d H:i:sa") . "\n
---------------------\nPre-create Response:\n" . $server_output . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG_vino.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    $qrcode = $alipaySubmit->get_from_tag($server_output, '<qr_code>','</qr_code>');
    $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
}     


//pos test end 210918

//构造要请求的参数数组，无需改动
if($_POST['action']=='2'){
    $parameter = array(
        "service"       => $alipay_config['service-re'],
        "partner"       => $alipay_config['partner'],
        "sign_type"		=> $alipay_config['sign_type'],
        "sign"			=> $alipay_config['key'],
        "gmt_return"	=> $_POST['gmt_return'],
        "out_trade_no"	=> $out_trade_no,
        "out_return_no"	=> $_POST['out_return_no'],
        "return_amount"	=> $_POST['return_amount'],
        "currency" => $currency,
        "product_code" => $product_code,
        "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))

    );
}
else if($_POST['action']=='3'){
    $db->where("out_trade_no", $_POST['partner_trans_id']);
    $sd1=$db->get('transaction');
    $refund_flag=$sd1[0]['refund_flag'];
    if($refund_flag!='1') {
        $parameter = array(
            //"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
            "currency" => $currency,
            //"notify_url"	=> $alipay_config['notify_url'],
            "partner" => $alipay_config['partner-qr'],
            "partner_trans_id" => $_POST['partner_trans_id'],
            "partner_refund_id" => $_POST['partner_refund_id'],
            //"product_code" => $product_code,
            "refund_amount" => $_POST['return_amount'],
            "service" => $alipay_config['service-re-qr'],
            //"sign_type"		=> $alipay_config['sign_type'],
            //"sign"			=> $alipay_config['key-qr'],
        );

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
        $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        $log = date("Y-m-d H:i:sa") . "\n
---------------------\nRefund Response:\n" . $server_output . " \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $desc = $alipaySubmit->get_from_tag($server_output, '<error>', '</error>');
        if ($result_code == "SUCCESS") {
            $response = array(
                'res' => $result_code,
                'desc' => $desc
            );

            //insert refund details in refund table
            $data1 = Array(
                "id_transaction_id" => $sd1[0]['id_transaction_id'],
                "refund_amount" => $_POST['return_amount'],
                "refund_on" => date('Y-m-d H:i:s')
            );
            $refund_id=$db->insert('refund', $data1);

            // Update transaction table after cancellatio success
            $data = Array(
                "refund_flag" => 1,
                "refund_id" => $refund_id
            );
            $db->where("out_trade_no", $_POST['partner_trans_id']);
            $db->update('transaction', $data);



        } else {
            $response = array(
                'res' => $result_code,
                'desc' => $desc
            );
            //$response = $result_code . ' /\\n/g' . $desc;
        }
    } else {
        $response = array(
            'res' => "Transaction Already Refunded",
            'desc' => ""
        );
        $log = date("Y-m-d H:i:sa") . "\n
---------------------\nRefund Response:\nTransaction Already Refunded \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    print_r(json_encode($response));
    exit;

}
else if($_POST['action']=='1'){
    $extend_param='{"secondary_merchant_name":"Lotte", "secondary_merchant_id":"123", "secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
    $parameter = array(
        "_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
        "currency" => $currency,
        "extend_params" => $extend_param,
        "out_trade_no"	=> $out_trade_no,
        "partner"       => $alipay_config['partner-qr'],
        "product_code" => $product_code,
        "service"       => $alipay_config['service-qr-cr'],
        "sign"			=> $alipay_config['key-qr'],
        "sign_type"		=> $alipay_config['sign_type'],
        "subject"	=> $subject,
        "total_fee"	=> $total_fee,
        "trans_currency" => $currency,
        "buyer_id" => $_POST['buyerid'],


    );

    $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter). " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $alipaySubmit = new AlipaySubmit($alipay_config);
    $html_text = $alipaySubmit->buildRequestFormqrpay($parameter,"get", "OK");
    echo $html_text;
    exit;
    $url="https://openapi.alipaydev.com/gateway.do?".$html_text;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "UTF-8",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "postman-token: 60d6d5ef-0abb-8c17-5c31-96c31a5edb26"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    print_r($url);
    echo "<br><br>";
    print_r($response);
    echo "<br><br>";
    print_r($response);
    echo "<br><br>";
    curl_close($curl);
    exit;
}
else if($_POST['action']=='5') {
    // $extend_param = '{"secondary_merchant_name":"Lotte","secondary_merchant_id":"123","secondary_merchant_industry":"5812","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
    $extend_param = '{"secondary_merchant_name":"Lotte","secondary_merchant_id":"123","secondary_merchant_industry":"56565665","store_id":"A101","store_name":"McDonald in 966 3rd Ave, New York"}';
    $parameter = array(
        "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
        "currency" => $currency,
        "extend_params" => $extend_param,
        "notify_url"	=> $alipay_config['notify_url'],
        "out_trade_no" => $out_trade_no,
        "partner" => $alipay_config['partner-qr'],
        "passback_parameters" => "success",
        "product_code" => $product_code,
        "service" => $alipay_config['service-qr-pcr'],
        "sign" => '', // $alipay_config['key-qr'],
        "sign_type" => '', // $alipay_config['sign_type'],
        "subject" => $subject,
        "timestamp" => date('YmdHis'),
        "total_fee" => $total_fee,
        "trans_currency" => $currency
    );

    $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter) . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $alipaySubmit = new AlipaySubmit($alipay_config);
    $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

    $url="https://openapi.alipaydev.com/gateway.do?".$html_text;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    $log = date("Y-m-d H:i:sa") . "\n
---------------------\nPre-create Response:\n" . $server_output . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $qrcode = $alipaySubmit->get_from_tag($server_output, '<qr_code>','</qr_code>');
    $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');

    $data = Array(
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
        "merchant_id" => $_POST['merchantid'],
        "currency" => $currency,
        "product_code" => $product_code,
        "out_trade_no" => $out_trade_no,
        "subject" => $subject,
        "trans_datetime" => date('Y-m-d H:i:s'),
        "trans_time" => date('H:i:s'),
        "trans_date" => date('Y-m-d')
    );

    $id_transaction_id = $db->insert('transaction', $data);

    if ($result_code != "SUCCESS") {
        $error_code = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
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
else if($_POST['action']=='4'){
    //Fetch transaction to check its already cancelled or not
    $db->where("out_trade_no", $out_trade_no);
    $sd1=$db->get('transaction');
    $cancel_flag=$sd1[0]['cancel_flag'];
    if($cancel_flag!='1') {
        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "out_trade_no" => $out_trade_no,
            "partner" => $alipay_config['partner-qr'],
            "service" => $alipay_config['service-qr-cl'],
            "sign" => $alipay_config['key-qr'],
            "sign_type" => $alipay_config['sign_type'],
            "timestamp" => $_POST['timestamp'],

        );

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");
        //echo $html_text;
        $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        $log = date("Y-m-d H:i:sa") . "\n
---------------------\nCancel Response:\n" . $server_output . " \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');
        $desc = $alipaySubmit->get_from_tag($server_output, '<detail_error_code>', '</detail_error_code>');
        if ($result_code == "SUCCESS") {
            $response = array(
                'res' => $result_code,
                'desc' => $desc
            );
            // Update transaction table after cancellatio success
            $data = Array(
                "cancel_flag" => 1
            );
            $db->where("out_trade_no", $out_trade_no);
            $db->update('transaction', $data);

        } else {
            $response = array(
                'res' => $result_code,
                'desc' => $desc
            );
            //$response = $result_code . ' /\\n/g' . $desc;
        }
    } else {
        $response = array(
            'res' => "Transaction was already cancelled",
            'desc' => ""
        );
        $log = date("Y-m-d H:i:sa") . "\n
---------------------\nCancel Response:\nTransaction was already cancelled \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    print_r(json_encode($response));
    exit;
}
else if($_POST['action']=='6'){
    $parameter = array(
        "_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
        "partner"       => $alipay_config['partner-qr'],
        "partner_trans_id"	=> $_POST['partner_trans_id'],
        "service"       => $alipay_config['service-qy-qr'],
        "sign_type"		=> $alipay_config['sign_type'],
        "sign"			=> $alipay_config['key-qr'],
    );

    $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter) . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $alipaySubmit = new AlipaySubmit($alipay_config);
    $html_text = $alipaySubmit->buildRequestFormqrpay($parameter,"get", "OK");
    echo $html_text;
    /*
    $url="https://openapi.alipaydev.com/gateway.do?".$html_text;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    print_r($parameter);
    echo "<br><br>";
    print_r($html_text);
    echo "<br><br>";
    print_r($url);
    echo "<br><br>";
    print_r($server_output);
    exit;
    */
}
else if($_POST['action']=='7'){
    $db->where("trade_no", "");
    $sd1=$db->get('transaction');

    $chang=0;
    foreach ($sd1 as $sd) {
        $parameter = array(
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
            "partner" => $alipay_config['partner-qr'],
            "partner_trans_id" => $sd['out_trade_no'],
            "service" => $alipay_config['service-qy-qr'],
            "sign_type" => $alipay_config['sign_type'],
            "sign" => $alipay_config['key-qr'],
        );

        $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter) . " \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

        $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        $log = date("Y-m-d H:i:sa") . "\n
---------------------\nQuery Response:\n" . $server_output . " \n\n";
        $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

        $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');

        if ($result_code == "SUCCESS") {
            $alipay_trans_id = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
            $alipay_buyer_login_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_login_id>', '</alipay_buyer_login_id>');
            $trans_amount_cny = $alipaySubmit->get_from_tag($server_output, '<trans_amount_cny>', '</trans_amount_cny>');
            $alipay_trans_status = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_status>', '</alipay_trans_status>');
            $alipay_buyer_user_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_user_id>', '</alipay_buyer_user_id>');
            $alipay_pay_time = $alipaySubmit->get_from_tag($server_output, '<alipay_pay_time>', '</alipay_pay_time>');
            $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
            $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');

            // Update transaction table after query api success
            $data = Array (
                "trade_no" => $alipay_trans_id,
                "buyer_email" => $alipay_buyer_login_id,
                "res_price" => $trans_amount_cny,
                "trade_status" => $alipay_trans_status,
                "buyer_id" => $alipay_buyer_user_id,
                "gmt_payment" => $alipay_pay_time,
                "res_sign_type" => $sign_type,
                "res_sign" => $sign
            );
            $db->where("out_trade_no" , $sd['out_trade_no']);
            $db->update('transaction', $data);

            $chang=1;
        }

    }
    echo $chang;
    exit;
}
else if($_POST['action']=='8'){
    $ot_trade=$_POST['out_trade_no'];
    $chang=0;
    $parameter = array(
        "_input_charset" => trim(strtolower($alipay_config['input_charset'])),
        "partner" => $alipay_config['partner-qr'],
        "partner_trans_id" => $ot_trade,
        "service" => $alipay_config['service-qy-qr'],
        "sign_type" => $alipay_config['sign_type'],
        "sign" => $alipay_config['key-qr'],
    );

    $log = "Application Log:\n".date("Y-m-d H:i:sa") . "\n
---------------------\nRequest Data:\n" . json_encode($parameter) . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $alipaySubmit = new AlipaySubmit($alipay_config);
    $html_text = $alipaySubmit->buildRequestFormqr($parameter, "get", "OK");

    $url = "https://openapi.alipaydev.com/gateway.do?" . $html_text;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    $log = date("Y-m-d H:i:sa") . "\n
---------------------\nQuery Response:\n" . $server_output . " \n\n";
    $myfile = file_put_contents('/var/www/html/Spaysez/api/alipaytranLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);

    $result_code = $alipaySubmit->get_from_tag($server_output, '<result_code>', '</result_code>');

    if ($result_code == "SUCCESS") {
        $alipay_trans_id = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_id>', '</alipay_trans_id>');
        $alipay_buyer_login_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_login_id>', '</alipay_buyer_login_id>');
        $trans_amount_cny = $alipaySubmit->get_from_tag($server_output, '<trans_amount_cny>', '</trans_amount_cny>');
        $alipay_trans_status = $alipaySubmit->get_from_tag($server_output, '<alipay_trans_status>', '</alipay_trans_status>');
        $alipay_buyer_user_id = $alipaySubmit->get_from_tag($server_output, '<alipay_buyer_user_id>', '</alipay_buyer_user_id>');
        $alipay_pay_time = $alipaySubmit->get_from_tag($server_output, '<alipay_pay_time>', '</alipay_pay_time>');
        $sign_type = $alipaySubmit->get_from_tag($server_output, '<sign_type>', '</sign_type>');
        $sign = $alipaySubmit->get_from_tag($server_output, '<sign>', '</sign>');

        // Update transaction table after query api success
        $data = Array (
            "trade_no" => $alipay_trans_id,
            "buyer_email" => $alipay_buyer_login_id,
            "res_price" => $trans_amount_cny,
            "trade_status" => $alipay_trans_status,
            "buyer_id" => $alipay_buyer_user_id,
            "gmt_payment" => $alipay_pay_time,
            "res_sign_type" => $sign_type,
            "res_sign" => $sign
        );
        $db->where("out_trade_no" , $ot_trade);
        $db->update('transaction', $data);

        $chang=1;
    }
    echo $chang;
    exit;
}
else {
//package the request parameters
    $parameter = array(
        "service"       => $alipay_config['service'],
        "partner"       => $alipay_config['partner'],
        "notify_url"	=> $alipay_config['notify_url'],
        "sign_type"		=> $alipay_config['sign_type'],
        "sign"			=> $alipay_config['key'],
        //"return_url"	=> $alipay_config['return_url'],
        "return_url"	=> $_POST['return_url'],

        "out_trade_no"	=> $out_trade_no,
        "subject"	=> $subject,
        "total_fee"	=> $total_fee,
        "body"	=> $body,
        "currency" => $currency,
        "product_code" => $product_code,
        "secondary_merchant_id" => $secondary_merchant_id,
        "secondary_merchant_industry" => $secondary_merchant_industry,
        "secondary_merchant_name" => $secondary_merchant_name,
        //$split_fund_info => str_replace("\"", "'",'split_fund_info'),
        //"split_fund_info"=>$split_fund_info,
        "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        //其他业务参数根据在线开发文档，添加参数.文档地址:https://global.alipay.com/service
        //To add other parameters,please refer to development documents.Document address:https://global.alipay.com/service
        //如"参数名"=>"参数值"
        //eg"parameter name"=>"parameter value"

    );
}
//建立请求
//build request
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "OK");
echo $html_text;




?>