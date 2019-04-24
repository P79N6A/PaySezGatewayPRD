<?php

session_start();
 
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey = "ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
require_once('../api/encrypt.php');

error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");
require_once("MD5HtmlBuildSubmit.php");

$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

 /*MD5 class definition */
$HtmlBuild_Submit = new MD5HtmlBuildSubmit();

//product_code
$product_code ='OVERSEAS_MBARCODE_PAY'; 

$terminal_empty = "Terminal Id Received Empty From POS";
$terminal_wrong = "Terminal Id Wrong";

//alipay config values decalred as variable to use in global inside function
$notify_url = $alipay_config['notify_url'];
$input_charset = $alipay_config['input_charset'];
$service = $alipay_config['service-qr-pcr'];
$refund_service = $alipay_config['service-re-qr'];
$query_service = $alipay_config['service-qy-qr'];
$cancel_service = $alipay_config['service-qr-cl'];
$alipay_url = $alipay_config['alipay_url'];


 /* Log path declare by variable use in function poslogs */
$APlog_path = $alipay_config['log-path'];

 /** Log File Function starts **/

function grablogs($log) {
 GLOBAL $APlog_path;
  //echo $APlog_path;exit;
$myfile = file_put_contents($APlog_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;
}
/**  Log File Function Ends **/


// echo 'hi';
// /** Unix time to timestamp*/
// function unixtotime($time){
// $unix_timestamp = $time;
// $datetime = new DateTime("@$unix_timestamp");
// // Display GMT datetime
// //echo $datetime->format('d-m-Y H:i:s');
// $date_time_format = $datetime->format('Y-m-d H:i:s');
// $time_zone_from="UTC";
// $time_zone_to='Asia/Singapore';
// $display_date = new DateTime($date_time_format, new DateTimeZone($time_zone_from));
// // Date time with specific timezone
// $display_date->setTimezone(new DateTimeZone($time_zone_to));
// return $display_date->format('d-m-Y H:i:s');
// }
// $log = "Application Log POS:".date("Y-m-d H:i:s") . " Test Alipay:" . $alipay_config['log-path']. " \n\n";
//    poslogs($log);
// $hello = 'jhg';
// poslogs($hello);
// echo 'hi';exit;

//QR & Payment request  
function payment($req_terminal_id,$req_merchant_id,$req_total_fee,$req_currency,$req_terminal_timestamp,$req_out_trade_no,$req_partner_id_ap,$req_product_code,$req_subject,$req_partner_id_res_ap,$req_partner_key,$tran_req_type) {
 
    GLOBAL $db;
    GLOBAL $notify_url;
    GLOBAL $input_charset;
    GLOBAL $service;
    GLOBAL $alipay_url;
    GLOBAL $HtmlBuild_Submit;
    GLOBAL $APlog_path;


    // $numargs = func_num_args();
    //     echo "Number of arguments: $numargs \n";
    //     if ($numargs >= 2) {
    //         echo "Second argument is: " . func_get_arg(1) . "\n";
    //     }
    //     $arg_list = func_get_args();
    //     for ($i = 0; $i < $numargs; $i++) {
    //         echo "Argument $i is: " . $arg_list[$i] . "\n";
    //     }

     /* ttype =1 ,Purchase request */
    $terminal_id = $req_terminal_id;
    $merchant_id = $req_merchant_id;
    $total_fee = $req_total_fee/100;
    $currency = $req_currency;
    $timestamp = $req_terminal_timestamp;
    $out_trade_no = $req_out_trade_no;
    $partner_id_alipay = $req_partner_id_ap;
    $product_code = $req_product_code;
    $subject = $req_subject;
    $partner_id_res = $req_partner_id_res_ap;
    $ttype =  $tran_req_type;
    $partner_key = $req_partner_key;
    /* Making sign as a SESSION variable ,use in MD5*/
    $_SESSION['sign'] = $partner_key;

    /* terminal & merchant validation starts */
    if($terminal_id !="") {
            $db->where("mso_terminal_id",$terminal_id);
            $terminal_res = $db->getOne("terminal");
            $terminalIdds = $terminal_res['mso_terminal_id'];
            $terminal_active = $terminal_res['active']; 
        
            if($terminalIdds != "" && $terminal_active == 1){
                //$merchant_id  = $terminal_res['idmerchants'];
                $mso_location = $terminal_res['mso_ter_location'];
            }else if($terminalIdds != "" && $terminal_active != 1){
                $terminal_active_sts = "POS Terminal Acive Log:".date("Y-m-d H:i:s") . " Terminal Not Active Id:" .json_encode($ter_act). " \n\n";
                grablogs($terminal_active_sts);
                echo 'Terminal Id Not Active';
                exit;
                die();
            }else {
                $terminal_id_empty = "POS terminal Id wrong Log:".date("Y-m-d H:i:s") . " Received wrong terminal From pos:" .$terminal_wrong. " \n\n";
                grablogs($terminal_id_empty);
                echo 'Terminal Id Wrong';
                die();
            }
        } else {
                $terminal_id_empty = "POS terminal check Log:".date("Y-m-d H:i:s") . " Received empty terminal From pos:" .$terminal_empty. " \n\n";
                grablogs($terminal_id_empty);
                echo 'Terminal Id Empty';
                die();
        }



    $db->where('mer_map_id',$merchant_id);
    $merchant_details = $db->getOne("merchants");
//print_r($merchant_details);exit;
    $secondary_merchant_name_init = preg_replace('!\s+!', ' ',$merchant_details['merchant_name']);
    $secondary_merchant_name = str_replace(' ','_',$secondary_merchant_name_init);
    $secondary_merchant_id = $merchant_details['mer_map_id'];
    $secondary_merchant_industry = $merchant_details['mcc'];
    $currency_code = $merchant_details['currency_code'];
    $store_id = $merchant_details['mer_map_id'];
    if($mso_location == ""){
    $name_split = explode(' ',$secondary_merchant_name);
    $loc_name = $name_split[0];
    $store_name = $loc_name;
    }else{
    $store_name = $mso_location;
    }
    $pcrq = $merchant_details['pcrq'];
    $str = explode("~",$pcrq);

//print_r($str);exit;
    /* Singapore time set to insert in transaction_alipay table */

    $given_datetime = date('Y-m-d H:i:s');
    $given = new DateTime($given_datetime);
    $given->setTimezone(new DateTimeZone("Asia/Singapore"));
    $updated_datetime = $given->format("Y-m-d H:i:s");

    /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "partnerTxID" => $req_partner_id_res_ap,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype,
            );
                $currency_error = array(
                "transaction_status" => 'FAIL',
                "msgID" => '',
                "txID" => '',
                "terminal_id" => $terminal_id,
                "partnerTxID" => $req_partner_id_res_ap,
                "timestamp" => $updated_datetime,
                "qrcode_value" => ''
            );
                $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
                grablogs($currency_status);

                $currency_error_encode = json_encode($currency_error);
                header('Content-Type: application/json');
                echo $currency_error_encode;
                exit;
                die();

         } 

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
            $otn_log = "Application Log for Already OTN exist POS:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
            grablogs($otn_log);
            echo "The given partner Transaction id already exist,use new one";
            exit;
            die();
        }
        /* Merchant payment access Permission starts here */
        
    if($str[0] == 1){
        $parameter_ins = array(
        "currency" => $currency,
        "out_trade_no" => $out_trade_no,
        "timestamp" => date('YmdHis'),
        "total_fee" => $total_fee,
        "trans_datetime" => date('Y-m-d H:i:s'),
        "trans_time" => date('H:i:s'),
        "trans_date" => date('Y-m-d'),
        "cst_trans_datetime" => $updated_datetime,
        "terminal_id" => $terminal_id,
        "transaction_type" => $ttype,
        "merchant_id" => $secondary_merchant_id
        );
        //print_r($parameter_ins);exit;

        /* Inserting payment request data from pos into Transaction table */

        $insert_precreate = $db->insert('transaction_alipay', $parameter_ins);
        // if($insert_precreate){
        //     echo 'success';exit;
        // }else{
        //     echo 'Fail';
        // }

        $extend_param = '{"secondary_merchant_name":"'.$secondary_merchant_name.'","secondary_merchant_id":"'.$secondary_merchant_id.'","secondary_merchant_industry":"'.$secondary_merchant_industry.'","store_id":"'.$store_id.'","store_name":"'.$store_name.'"}';

        $parameter = array(
            "_input_charset" => trim(strtolower($input_charset)),
            "currency" => $currency,
            "extend_params" => $extend_param,
            "notify_url"    => $notify_url,
            "out_trade_no" => $out_trade_no,
            "partner" => $partner_id_alipay,
            "passback_parameters" => "success",
            "product_code" => $product_code,
            "service" => $service,
            "subject" => $subject,
            "timestamp" => date('YmdHis'),
            "total_fee" => $total_fee,
            "trans_currency" => $currency
        );
          
        /* payment request data log ,send to alipay */
        /* payment request data log ,send to alipay */
        $url_alipay = "Application Log POS:".date("Y-m-d H:i:s") . " URL alipay:" . $alipay_url. " \n\n";
        grablogs($url_alipay);
            
        $param_send = "Application Log POS:".date("Y-m-d H:i:s") . " Parameter send to alipay:" . json_encode($parameter). " \n\n";
         grablogs($param_send);

        $before_build = "Application Log POS:".date("Y-m-d H:i:s") . " Payment Request Data Before Build :" .json_encode($parameter). " \n\n";
         grablogs($before_build);

        /* MD5 class parameter passing to function*/ 
        $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

        $built_after = "Application Log POS:".date("Y-m-d H:i:s") . " Built Data send to Alipay:" . $html_text. " \n\n";
        grablogs($built_after);

            // echo $html_text;exit;
        $url = $alipay_url . $html_text ;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $error = curl_errno($ch);

        /* Payment response log*/
        if(curl_errno($ch)){
            $error_res = " Pre-create payment Response POS:".date("Y-m-d H:i:s")
            . $error . " \n\n";
            grablogs($error_res);
            

        } else {
            $succes_res =  " Pre-create payment Response POS:" .date("Y-m-d H:i:s") . $server_output . " \n\n";
             grablogs($succes_res);
            //echo $server_output;
        }

        curl_close($ch);

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

        if ($result_code != "SUCCESS" && $result_code != "") {
                $response_error_upd = array(
                        "result_code" => $result_code,
                        "sign" => $sign,
                        "sign_type" => $sign_type
                    );

                $pay_err_res_upd = date("Y-m-d H:i:s") . " Pay Status log update in table POS:" . json_encode($response_error_upd) . " \n\n";
                 grablogs($pay_err_res_upd);
                /* Updating error response to transaction table */

                $db->where("out_trade_no", $out_trade_no);
                $db->where("transaction_type",$ttype);
                $trans_err_update = $db->update('transaction_alipay', $response_error_upd);

                $response_error = array(
                    "transaction_status" => $result_code,
                    "msgID" => '',
                    "txID" => '',
                    "terminal_id" => $terminal_id,
                    "partnerTxID" => $partner_id_res,
                    "timestamp" => $updated_datetime,
                    "qrcode_value" => ''
                );

                $pay_err_res = date("Y-m-d H:i:s") . " Pay Status log send to POS:" . json_encode($response_error) . " \n\n";
                grablogs($pay_err_res);

                $response_encode = json_encode($response_error);
                header('Content-Type: application/json');
                echo $response_encode;

        }else if ($result_code != "FAIL" && $result_code != "SUCCESS") {
                $response_error_emp = array(
                        "result_code" => 'TIME OUT'
                    );

                $pay_emp_res_upd = date("Y-m-d H:i:s") . " Pay Status log update in table POS:" . json_encode($response_error_emp) . " \n\n";
                grablogs($pay_emp_res_upd);

                /* Updating error empty response to transaction table */

                $db->where("out_trade_no", $out_trade_no);
                $db->where("transaction_type",$ttype);
                $trans_emp_update = $db->update('transaction_alipay', $response_error_emp);

                $response_empty = array(
                    "transaction_status" => 'TIME OUT',
                    "msgID" => '',
                    "txID" => '',
                    "terminal_id" => $terminal_id,
                    "partnerTxID" => $partner_id_res,
                    "timestamp" => $updated_datetime,
                    "qrcode_value" => ''
                );
                $pay_err_res_emp = date("Y-m-d H:i:s") . " Pay Status log send to POS:" . json_encode($response_empty) . " \n\n";
                grablogs($pay_err_res_emp);

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
                "partner" => $partner_id_alipay,
                "passback_parameters" => "success",
                "service" => $alipay_config['service-qr-pcr'],
                "sign" => $sign,
                "sign_type" => $sign_type,
                "total_fee" => $total_fee,
                "trans_currency" => $currency,
                "product_code" => $product_code,
                "subject" => $subject,
                "trans_datetime" => date('Y-m-d H:i:s'),
                "trans_time" => date('H:i:s'),
                "trans_date" => date('Y-m-d'),
                "terminal_id" => $terminal_id,
            ); 
            /* Log for after getting payment trade successfully updating details */

            $final_pay_res = date("Y-m-d H:i:s") . " Final payment Response update in table POS:" . json_encode($data) . " \n\n";
                grablogs($final_pay_res);

            /* Updating Transaction table after success response */
            $db->where("out_trade_no", $out_trade_no);
            $db->where("transaction_type",$ttype);
            $trans_suc_update = $db->update('transaction_alipay', $data);

                $pay_response_suc = array(
                    "transaction_status" => $result_code,
                    "msgID" => '',
                    "txID" => '',
                    "terminal_id" => $terminal_id,
                    "partnerTxID" => $partner_id_res,
                    "timestamp" => $updated_datetime,
                    "qrcode_value" => $qrcode
                );

                $pay_success_res = date("Y-m-d H:i:s") . " Pay Status log send to POS:" . json_encode($pay_response_suc) . " \n\n";
                grablogs($pay_success_res);

                $response_encode = json_encode($pay_response_suc);
                header('Content-Type: application/json');
                echo $response_encode;

      //ebe code

                $serv_url = $_SERVER['HTTP_HOST'];
                $serv_path = dirname(__FILE__);
                $total_url= $serv_url.$serv_path;
                if (preg_match("/testspaysez/", $total_url))
                {
                    header( "Refresh:10;url=test.php?user=".$qrImage);
                }        
                                        
     //ebe code end

                

            }

        // $pay_response_suc = array(
        //         "transaction_status" => $result_code,
        //         "msgID" => '',
        //         "txID" => '',
        //         "terminal_id" => $terminal_id,
        //         "partnerTxID" => $partner_id_res,
        //         "timestamp" => $updated_datetime,
        //         "qrcode_value" => $qrcode
        //     );

        //     $pay_success_res = " Pay Status log send to POS:".date("Y-m-d H:i:s") . json_encode($pay_response_suc) . " \n\n";
        //     grablogs($pay_success_res);

        //     $response_encode = json_encode($pay_response_suc);
        //     header('Content-Type: application/json');
        //     echo $response_encode;
}else{
        $acs = $str[0];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $out_trade_no,
            'pay_access' => $acs
        );
        $mer_access_permsn = "Pay Access Log POS:".date("Y-m-d H:i:s") . " Pay Access not allowed:" .json_encode($access_den). " \n\n";
        grablogs($mer_access_permsn);

        echo 'permission denied to pay request for this merchant';
         exit;
    }
   
}
function refund($ref_terminal_id,$ref_merchant_id,$ref_total_fee,$ref_currency,$ref_out_trade_no_orig,$ref_partner_refund_id,$ref_partner_id_res_ap,$ref_partner_id_ap,$ref_partner_key,$tran_req_type) {
    //echo $req_merchant_id;
    GLOBAL $db;
    GLOBAL $notify_url;
    GLOBAL $input_charset;
    GLOBAL $refund_service;
    GLOBAL $alipay_url;
    GLOBAL $HtmlBuild_Submit;
    GLOBAL $APlog_path;

    /* ttype =2 ,Refund request */
    $terminal_id = $ref_terminal_id;
    $merchant_id = $ref_merchant_id;
    $refund_amount = $ref_total_fee/100;
    $currency = $ref_currency;
    $refund_orig_otno = $ref_out_trade_no_orig;
    $refund_out_trade_no = $ref_partner_refund_id;
    $refund_partner_id_res = $ref_partner_id_res_ap;
    $partner_id_alipay = $ref_partner_id_ap;
    $ttype =  $tran_req_type;
    $partner_key = $ref_partner_key;
    /* Making sign as a SESSION variable ,use in MD5*/
    $_SESSION['sign'] = $partner_key;

    /* Singapore time set to insert in transaction_alipay table */

    $given_datetime = date('Y-m-d H:i:s');
    $given = new DateTime($given_datetime);
    $given->setTimezone(new DateTimeZone("Asia/Singapore"));
    $updated_datetime = $given->format("Y-m-d H:i:s");

    /* terminal & merchant validation starts */
    if($terminal_id !="") {
            $db->where("mso_terminal_id",$terminal_id);
            $terminal_res = $db->getOne("terminal");
            $terminalIdds = $terminal_res['mso_terminal_id'];
            $terminal_active = $terminal_res['active']; 
        
            if($terminalIdds != "" && $terminal_active == 1){
                //$merchant_id  = $terminal_res['idmerchants'];
                $mso_location = $terminal_res['mso_ter_location'];
            }else if($terminalIdds != "" && $terminal_active != 1){
                $terminal_active_sts = "POS Terminal Acive Log:".date("Y-m-d H:i:s") . " Terminal Not Active Id:" .json_encode($ter_act). " \n\n";
                grablogs($terminal_active_sts);
                echo 'Terminal Id Not Active';
                exit;
                die();
            }else {
                $terminal_id_empty = "POS terminal Id wrong Log:".date("Y-m-d H:i:s") . " Received wrong terminal From pos:" .$terminal_wrong. " \n\n";
                grablogs($terminal_id_empty);
                echo 'Terminal Id Wrong';
                die();
            }
        } else {
                $terminal_id_empty = "POS terminal check Log:".date("Y-m-d H:i:s") . " Received empty terminal From pos:" .$terminal_empty. " \n\n";
                grablogs($terminal_id_empty);
                echo 'Terminal Id Empty';
                die();
        }

    $db->where('mer_map_id',$merchant_id);
    $merchant_details = $db->getOne("merchants");
//print_r($merchant_details);exit;
    $secondary_merchant_name_init = preg_replace('!\s+!', ' ',$merchant_details['merchant_name']);
    $secondary_merchant_name = str_replace(' ','_',$secondary_merchant_name_init);
    $secondary_merchant_id = $merchant_details['mer_map_id'];
    $secondary_merchant_industry = $merchant_details['mcc'];
    $currency_code = $merchant_details['currency_code'];
    $store_id = $merchant_details['mer_map_id'];
    if($mso_location == ""){
    $name_split = explode(' ',$secondary_merchant_name);
    $loc_name = $name_split[0];
    $store_name = $loc_name;
    }else{
    $store_name = $mso_location;
    }
    $pcrq = $merchant_details['pcrq'];
    $str = explode("~",$pcrq);

    /* Currency Match with Terminal to merchant */

    if($currency_code != $currency){
        $currency_received = array(
            "currency" => $currency,
            "out_trade_no" => $refund_orig_otno,
            "terminal_id" => $terminal_id,
            "tran_req_type" => $ttype,
        );

        $currency_error = array(
        "transaction_status" => 'Merchant Not Found',
        "refund_amount" => $refund_amount,
        "txID" => '',
        "terminal_id" => $terminal_id,
        "timestamp" => $updated_datetime,
        "partnerTxID" => $refund_partner_id_res
        );

        $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
        grablogs($currency_status);

        $currency_error_encode = json_encode($currency_error);
        header('Content-Type: application/json');
        echo $currency_error_encode;
        exit;
        die();

     } 

      /* validation for otn already exist or not */
    $db->where("out_trade_no",$refund_out_trade_no);
    $db->where("transaction_type",$ttype);
    $record_check = $db->get('transaction_alipay');
    $count = count($record_check);

        if($count >=1){
            $error_otn = array(
                "out_trade_no" => $refund_out_trade_no,
                "terminal_id" => $terminal_id,
                "transaction_type" => $ttype,
                "error" => 'The given out trade no already exist'
            );
            $otn_log = "Application Log for Already OTN exist POS:".date("Y-m-d H:i:s") . " Payment Request Data :" .json_encode($error_otn). " \n\n";
            grablogs($otn_log);
            echo "The given out trade no already exist,use new one";
            exit;
            die();
        }

if($str[2] == 1){

    $refund_req_data = array(
        "currency" => $currency,
        "merchant_id" => $secondary_merchant_id,
        "partner_trans_id" => $refund_orig_otno,
        "partner_refund_id" => $refund_out_trade_no,
        "refund_amount" => $refund_amount,
        "out_trade_no" => $refund_out_trade_no,
        "terminal_id" => $terminal_id,
        "transaction_type" => $ttype,
        "cst_trans_datetime" => $updated_datetime,
        "trans_datetime" => date('Y-m-d H:i:s'),
        "trans_time" => date('H:i:s'),
        "trans_date" => date('Y-m-d')
        );
        //print_r($parameter_ins);exit;

        $ref_req_data_pos = "Application Log POS:".date("Y-m-d H:i:s") . " Refund insert data :" . json_encode($refund_req_data) . " \n\n";
                grablogs($ref_req_data_pos);

        /* Refund request data inserting,received from POS */

        $refund_req_ins = $db->insert('transaction_alipay',$refund_req_data);

    $parameter = array(
            "currency" => $currency,
            "partner" => $partner_id_alipay,
            "partner_trans_id" => $refund_orig_otno,
            "partner_refund_id" => $refund_out_trade_no,
            "refund_amount" => $refund_amount,
            "service" => $refund_service
        );

    /* Refund request data to Alipay -  log */

    $before_build = "Application Log POS:".date("Y-m-d H:i:s") . " Refund request data Before Build:" . json_encode($parameter) . " \n\n";
    grablogs($before_build);

    // /* MD5 class parameter passing to function*/ 
    // $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);


    /* MD5 class parameter passing to function*/ 
    $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

    $after_built = "Application Log POS:".date("Y-m-d H:i:s") . " Refund Build Data Send to Alipay:" . $html_text. " \n\n";
    grablogs($after_built);

    $url = $alipay_url . $html_text;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    $error = curl_errno($ch);
    /* Refund response log */

    if(curl_errno($ch)) {
        $err_resp = " Refund Response POS:".date("Y-m-d H:i:s") .curl_errno($ch) . " \n\n";
        grablogs($err_resp);
    } else {
        $succs_resp =  " Refund Response POS:".date("Y-m-d H:i:s") . $server_output . " \n\n";
        grablogs($succs_resp);

    }

    $result_code = $HtmlBuild_Submit->get_from_tag($server_output, '<result_code>', '</result_code>');
    $desc = $HtmlBuild_Submit->get_from_tag($server_output, '<error>', '</error>');
    $is_success = $HtmlBuild_Submit->get_from_tag($server_output, '<is_success>', '</is_success>');
    $refund_amount_res = $HtmlBuild_Submit->get_from_tag($server_output, '<refund_amount>', '</refund_amount>');
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
        $data_refs = array(
           "result_code" => $result_code,
           "refund_amount" => $refund_amount_res,
           "refund_amount_cny" => $refund_amount_cny,
           "partner_refund_id" => $partner_refund_id,
           "partner_trans_id" => $partner_trans_id,
           "alipay_trans_id" => $alipay_trans_id,
           "currency" => $currency,
           "res_sign" => $sign,
           "res_sign_type" => $sign_type
            );


        $refund_succ_res_upd = "Application Log POS:".date("Y-m-d H:i:s") . " Refund success response update in table:" . json_encode($data_refs) . " \n\n";
        grablogs($refund_succ_res_upd);

        /* Response details update in refund inserted row */

        $db->where("partner_refund_id",$partner_refund_id);
        $db->where("transaction_type",$ttype);
        $refund_success_update = $db->update('transaction_alipay', $data_refs);

        $refund_response = array(
        "transaction_status" => $result_code,
        "refund_amount" => $refund_amount*100,
        "txID" => '',
        "terminal_id" => $terminal_id,
        "timestamp" => $updated_datetime,
        "partnerTxID" => $refund_partner_id_res
        );

        $refund_suc_res_pos_log = "Application Log POS:".date("Y-m-d H:i:s") . " Refund response send to pos:" . json_encode($refund_response) . " \n\n";
        grablogs($refund_suc_res_pos_log);

        $refund_encode = json_encode($refund_response);
        header('Content-Type: application/json');
        echo $refund_encode;

        // $refund_response = array(
        // "transaction_status" => $result_code,
        // "refund_amount" => $refund_amount,
        // "txID" => '',
        // "terminal_id" => $terminal_id,
        // "timestamp" => $updated_datetime,
        // "partnerTxID" => $refund_partner_id_res
        // );

        // $refund_suc_res_pos_log = "Application Log POS:".date("Y-m-d H:i:s") . " Refund response send to pos:" . json_encode($refund_response) . " \n\n";
        // grablogs($refund_suc_res_pos_log);
        
     }else if ($result_code != "SUCCESS" && $result_code != "FAILED") {
        $res_empty = array(
        "result_code" => 'TIME OUT',
        "refund_amount" => $refund_amount*100,
        "out_trade_no" => $partner_refund_id,
        "terminal_id" => $terminal_id
        );


        $refund_empty_res = "Application Log POS:".date("Y-m-d H:i:s") . " Refund empty response update in table:" . json_encode($res_empty) . " \n\n";
        grablogs($refund_empty_res);
        

        /* Update refund empty response in transaction table */

        $db->where("partner_refund_id",$partner_refund_id);
        $db->where("transaction_type",$ttype);
        $refund_empty_update = $db->update('transaction_alipay', $res_empty);

        // $res_empty_pos = array(
        //     "transaction_status" => 'TIME OUT',
        //     "refund_amount" => $refund_amount,
        //     "out_trade_no" => $partner_refund_id,
        //     "terminal_id" => $terminal_id
        // );
        $res_empty_pos = array(
        "transaction_status" => 'TIME OUT',
        "refund_amount" => $refund_amount*100,
        "txID" => '',
        "terminal_id" => $terminal_id,
        "timestamp" => $updated_datetime,
        "partnerTxID" => $refund_partner_id_res
        );

        $refund_empty_res_pos = "Application Log POS:".date("Y-m-d H:i:s") . " Refund empty response sent to pos:" . json_encode($res_empty_pos) . " \n\n";
        grablogs($refund_empty_res_pos);

        $refund_empty_encode = json_encode($res_empty_pos);
        header('Content-Type: application/json');
        echo $refund_empty_encode;

    }else{
            $data_refs = array(
            "is_success" => $is_success,
            "result_code" => $result_code,
            "error" => $error,
            "res_sign" => $sign,
            "res_sign_type" => $sign_type
            );

            $refund_err_res_upd = "Application Log POS:".date("Y-m-d H:i:s") . " Refund error response update in table:" . json_encode($data_refs) . " \n\n";
            grablogs($refund_err_res_upd);

            /*Refund error response update in refund inserted row */

            $db->where("partner_refund_id",$partner_refund_id);
            $db->where("transaction_type",$ttype);
            $refund_error_update = $db->update('transaction_alipay', $data_refs);

            /* Refund error response send to pos */

            // $data_ref = array(
            //     "transaction_status" => $result_code,
            //     "refund_amount" => $refund_amount,
            //     "out_trade_no" => $partner_refund_id,
            //     "terminal_id" => $terminal_id
            // );
            $data_ref = array(
            "transaction_status" => $result_code,
            "refund_amount" => $refund_amount*100,
            "txID" => '',
            "terminal_id" => $terminal_id,
            "timestamp" => $updated_datetime,
            "partnerTxID" => $refund_partner_id_res
            );

            $refund_err_res_pos_log = "Application Log POS:".date("Y-m-d H:i:s") . " Refund error response send to pos:" . json_encode($data_ref) . " \n\n";
            grablogs($refund_err_res_pos_log);

            $refund_encode1 = json_encode($data_ref);
            header('Content-Type: application/json');
            echo $refund_encode1;

     }

    // else{
    //     $refund_response = array(
    //     "transaction_status" => $result_code,
    //     "refund_amount" => $refund_amount,
    //     "txID" => '',
    //     "terminal_id" => $terminal_id,
    //     "timestamp" => $updated_datetime,
    //     "partnerTxID" => $refund_partner_id_res
    //     );

    //  }
    //     $response_encode = json_encode($refund_response);
    //     header('Content-Type: application/json');
    //     echo $response_encode;
    
}else{
        /* refund not allowed to merchant*/
        $acs = $str[2];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $partner_refund_id,
            'refund_access' => $acs
        );
        $mer_access_permsn = "Refund Access Log POS:".date("Y-m-d H:i:s") . " Refund Not Allowed Log:" .json_encode($access_den). " \n\n";
        grablogs($mer_access_permsn);

        echo 'Refund denied to this merchant';
    }
}//function End
function query($qry_terminal_id,$qry_merchant_id,$qry_currency,$qry_out_trade_no_orig,$qry_partner_id_ap,$qry_partner_id_res_ap,$qry_partner_key,$tran_req_type) {
    //echo $req_merchant_id;
    GLOBAL $db;
    GLOBAL $notify_url;
    GLOBAL $input_charset;
    GLOBAL $query_service;
    GLOBAL $alipay_url;
    GLOBAL $HtmlBuild_Submit;
    GLOBAL $APlog_path;

    /* ttype =2 ,Refund request */
    $terminal_id = $qry_terminal_id;
    $merchant_id = $qry_merchant_id;
    $currency = $qry_currency;
    $query_orig_otno = $qry_out_trade_no_orig;
    $partner_id_alipay = $qry_partner_id_ap;
    $partner_id_res =  $qry_partner_id_res_ap;
    $ttype =  $tran_req_type;
    $partner_key = $qry_partner_key;
    /* Making sign as a SESSION variable ,use in MD5*/
    $_SESSION['sign'] = $partner_key;

    /* Singapore time set to insert in transaction_alipay table */

    $given_datetime = date('Y-m-d H:i:s');
    $given = new DateTime($given_datetime);
    $given->setTimezone(new DateTimeZone("Asia/Singapore"));
    $updated_datetime = $given->format("Y-m-d H:i:s");

    $db->where('mer_map_id',$merchant_id);
    $merchant_details = $db->getOne("merchants");
//print_r($merchant_details);exit;
    $secondary_merchant_name_init = preg_replace('!\s+!', ' ',$merchant_details['merchant_name']);
    $secondary_merchant_name = str_replace(' ','_',$secondary_merchant_name_init);
    $secondary_merchant_id = $merchant_details['mer_map_id'];
    $secondary_merchant_industry = $merchant_details['mcc'];
    $currency_code = $merchant_details['currency_code'];
    $store_id = $merchant_details['mer_map_id'];
    if($mso_location == ""){
    $name_split = explode(' ',$secondary_merchant_name);
    $loc_name = $name_split[0];
    $store_name = $loc_name;
    }else{
    $store_name = $mso_location;
    }
    $pcrq = $merchant_details['pcrq'];
    $str = explode("~",$pcrq);


    /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
            "currency" => $currency,
            "out_trade_no" => $query_orig_otno,
            "terminal_id" => $terminal_id,
            "tran_req_type" => $ttype
            );

            $currency_error = array(
            "transaction_status" => 'Merchant Not Found',
            "amount" => $total_fee,
            "terminal_id" => $terminal_id,
            "partnerTxID" => $partner_id_res,
            "timestamp" => $updated_datetime
            );

            $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
            grablogs($currency_status);

            $currency_error_encode = json_encode($currency_error);
            header('Content-Type: application/json');
            echo $currency_error_encode;
            exit;
            die();

         } 
/* Checking transaction success or not ,if success dont send request to alipay */

    $db->where("out_trade_no", $query_orig_otno);
    $trans_result = $db->getOne("transaction_alipay");
    $trade_status = $trans_result['trade_status'];
    $amount_conv_deci = $trans_result['total_fee'];
    $result_code = $trans_result['result_code'];
    $total_fee = $amount_conv_deci*100; 
 /* Merchant Query access Permission starts here */
        // echo $result_code;exit;
if($str[3] == 1){

        $query_data_ins = array(
        "terminal_id" => $terminal_id,
        "merchant_id" => $secondary_merchant_id,
        "partner_trans_id" => $query_orig_otno,
        "transaction_type" => $ttype,
        "cst_trans_datetime" => $updated_datetime,
        "trans_datetime" => date('Y-m-d H:i:s'),
        "trans_time" => date('H:i:s'),
        "trans_date" => date('Y-m-d')
        );

        
        if($trade_status == 'TRADE_SUCCESS'){
        $query_stts = array(
        "transaction_status" => $result_code,
        "amount" => $total_fee,
        "terminal_id" => $terminal_id,
        "partnerTxID" => $partner_id_res,
        "timestamp" => $updated_datetime
        );     

        $trans_succ_log = "Application Log POS:".date("Y-m-d H:i:s") . " Query Status send to pos:" . json_encode($query_stts) . " \n\n";
        grablogs($trans_succ_log); 

        $query_stts_encode = json_encode($query_stts);
        header('Content-Type: application/json');
        echo $query_stts_encode;

        exit;
        die();  
        }
        /* Query log data for insert */

        $query_log = "Query request data from POS:".date("Y-m-d H:i:s") . " Request Data insert in table:" . json_encode($query_data_ins) . " \n\n";
        grablogs($query_log);

        /* Inserting query request data received from pos into Transaction table */
       
        $query_insert = $db->insert('transaction_alipay', $query_data_ins);


        $parameter = array(
        "_input_charset" => trim(strtolower($input_charset)),
        "partner" => $partner_id_alipay,
        "partner_trans_id" => $query_orig_otno,
        "service" => $query_service
        );

        /* Query request data to Alipay -  log */

        $before_build = "Application Log POS:".date("Y-m-d H:i:s") . " Query request data Before Build:" . json_encode($parameter) . " \n\n";
        grablogs($before_build);

        // /* MD5 class parameter passing to function*/ 
        // $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);


        

        /* MD5 class parameter passing to function*/ 
        $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

        $after_built = "Application Log POS:".date("Y-m-d H:i:s") . " Query Build Data Send to Alipay:" . $html_text. " \n\n";
        grablogs($after_built);


        $url = $alipay_url . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $error = curl_errno($ch);
        /* Refund response log */

        if(curl_errno($ch)) {
            $err_resp = " Query Response POS:".date("Y-m-d H:i:s") .curl_errno($ch) . " \n\n";
            grablogs($err_resp);
        } else {
            $succs_resp =  " Query Response POS:".date("Y-m-d H:i:s") . $server_output . " \n\n";
            grablogs($succs_resp);

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

            $amount_deci = $trans_amount*100;

     if ($result_code == "SUCCESS" && ($alipay_trans_status == "TRADE_CLOSED" || $alipay_trans_status == "WAIT_BUYER_PAY")) {

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

            $query_response = "Application Log POS:".date("Y-m-d H:i:s") . " Query trade closed response update:" . json_encode($query_trade_res_pos) . " \n\n";
            grablogs($query_response);

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
                "amount" => $amount_deci,
                "terminal_id" => $terminal_id,
                "partnerTxID" => $partner_id_res,
                "timestamp" => $updated_datetime
                );

                $query_trade_res_pos1 = "Application Log POS:".date("Y-m-d H:i:s") . " Query trade response send to pos:" . json_encode($data_trade_query) . " \n\n";
                grablogs($query_trade_res_pos1);

                $query_trade_res_pos_encode = json_encode($data_trade_query);
                header('Content-Type: application/json');
                echo $query_trade_res_pos_encode;

        // $inquiry_response = array(
        //         "transaction_status" => $result_code,
        //         "amount" => $trans_amount,
        //         "terminal_id" => $terminal_id,
        //         "partnerTxID" => $partner_id_res,
        //         "timestamp" => $updated_datetime
        //     );

        // $query_suc_res_pos_log = "Application Log POS:".date("Y-m-d H:i:s") . " Query response send to pos:" . json_encode($inquiry_response) . " \n\n";
        // grablogs($query_suc_res_pos_log);
        
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
            $query_response = "Application Log POS:".date("Y-m-d H:i:s") . " Query response update in table:" . json_encode($data2) . " \n\n";
            grablogs($query_response);

        /* Updating query Success response in transaction table */

            $db->where("out_trade_no",$partner_trans_id);
            $query_update1 = $db->update('transaction_alipay', $data2);

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$ttype);
            $query_update2 = $db->update('transaction_alipay', $data2);

            $query_succs_res_pos = array(
            "transaction_status" => $result_code,
            "amount" => $amount_deci,
            "terminal_id" => $terminal_id,
            "partnerTxID" => $partner_id_res,
            "timestamp" => $updated_datetime
            ); 
            $query_response_to_pos = "Application Log POS:".date("Y-m-d H:i:s") . " Query response send to pos:" . json_encode($query_succs_res_pos) . " \n\n";
            grablogs($query_response_to_pos);

            $query_succs_res_pos_encode = json_encode($query_succs_res_pos);
            header('Content-Type: application/json');
            echo $query_succs_res_pos_encode;  


        }else{
                $query_error_res_pos = array(
                    "is_success" => $is_success,
                    "res_sign_type" => $sign_type,
                    "res_sign" => $sign,
                    "result_code" => $result_code
                );

            $query_response = "Application Log POS:".date("Y-m-d H:i:s") . " Query failure response update:" . json_encode($query_error_res_pos) . " \n\n";
            grablogs($query_response);

            /* Updating query error response in query row */

            $db->where("out_trade_no",$partner_trans_id);
            $query_err_update = $db->update('transaction_alipay',$query_error_res_pos);

            $db->where("partner_trans_id",$partner_trans_id);
            $db->where("transaction_type",$ttype);
            $query_err_update2 = $db->update('transaction_alipay', $query_error_res_pos);

            $data_err_query = array(
            "transaction_status" => $result_code,
            "amount" => $total_fee,
            "terminal_id" => $terminal_id,
            "partnerTxID" => $partner_id_res,
            "timestamp" => $updated_datetime
            );

            $query_response_pos = "Application Log POS:".date("Y-m-d H:i:s") . " Query failure response to pos:" . json_encode($data_err_query) . " \n\n";
            grablogs($query_response_pos);

            $query_err_res_pos_encode = json_encode($data_err_query);
            header('Content-Type: application/json');
            echo $query_err_res_pos_encode;  
        }
        // $response_encode = json_encode($inquiry_response);
        // header('Content-Type: application/json');
        // echo $response_encode;
    }else{
        $acs = $str[3];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $query_orig_otno,
            'query_access' => $acs
        );
        $mer_access_permsn = "Query Access Log POS:".date("Y-m-d H:i:s") . " Query Not Allowed Log:" .json_encode($access_den). " \n\n";
        grablogs($mer_access_permsn);

        echo 'Query denied to this merchant';
    }
} //function End
function cancel($cncl_terminal_id,$cncl_merchant_id,$cncl_currency,$cncl_out_trade_no_orig,$cncl_partner_id_ap,$cncl_partner_key,$cncl_out_trade_no_split,$tran_req_type) {
    //echo $req_merchant_id;
    GLOBAL $db;
    GLOBAL $notify_url;
    GLOBAL $input_charset;
    GLOBAL $cancel_service;
    GLOBAL $alipay_url;
    GLOBAL $HtmlBuild_Submit;
    GLOBAL $APlog_path;

    /* ttype =2 ,Refund request */
    $terminal_id = $cncl_terminal_id;
    $merchant_id = $cncl_merchant_id;
    $currency = $cncl_currency;
    $cancel_orig_otno = $cncl_out_trade_no_orig;
    $partner_id_alipay = $cncl_partner_id_ap;
    $ttype =  $tran_req_type;
    $partner_key = $cncl_partner_key;
    $cncl_out_trade_no_res = $cncl_out_trade_no_split;
    /* Making sign as a SESSION variable ,use in MD5*/
    $_SESSION['sign'] = $partner_key;

    /* Singapore time set to insert in transaction_alipay table */

    $given_datetime = date('Y-m-d H:i:s');
    $given = new DateTime($given_datetime);
    $given->setTimezone(new DateTimeZone("Asia/Singapore"));
    $updated_datetime = $given->format("Y-m-d H:i:s");

    $db->where("out_trade_no",$cancel_orig_otno);
    $amount_get = $db->getOne('transaction_alipay');
    $amount_deci = $amount_get['total_fee'];
    $amount = $amount_deci*100;
    //Currency code from merchant
    $db->where('mer_map_id',$merchant_id);
    $merchant_details = $db->getOne("merchants");
    $secondary_merchant_id = $merchant_details['mer_map_id'];
    $currency_code = $merchant_details['currency_code'];
    $pcrq = $merchant_details['pcrq'];
    $str = explode("~",$pcrq);

    /* Currency Match with Terminal to merchant */

         if($currency_code != $currency){
            $currency_received = array(
                "currency" => $currency,
                "out_trade_no" => $cancel_orig_otno,
                "terminal_id" => $terminal_id,
                "tran_req_type" => $ttype
            );

            $currency_error = array(
            "transaction_status" => 'Merchant Not Found',
            "amount" => $amount,
            "terminal_id" => $terminal_id,
            "txID" => $cncl_out_trade_no_res,
            "timestamp" => $updated_datetime
            );
            
            $currency_status = "Currency Matching log POS:".date("Y-m-d H:i:s") . " Received Currency Not Matched Log:" .json_encode($currency_received). " \n\n";
            grablogs($currency_status);

            $currency_error_encode = json_encode($currency_error);
            header('Content-Type: application/json');
            echo $currency_error_encode;
            exit;
            die();

         } 
if($str[1] == 1){

        $can_req_data = array(
        "currency" => $currency,
        "total_fee" => $amount_deci, 
        "merchant_id" => $secondary_merchant_id,
        "terminal_id" => $terminal_id,
        "transaction_type" => $ttype,
        "out_trade_no" => $cancel_orig_otno,
        "cst_trans_datetime" => $updated_datetime,
        "trans_datetime" => date('Y-m-d H:i:s'),
        "trans_time" => date('H:i:s'),
        "trans_date" => date('Y-m-d')
        );

        $can_data_pos= "Application Log POS:".date("Y-m-d H:i:s") . " Cancel Request Data:" . json_encode($can_req_data) . " \n\n";
        grablogs($can_data_pos);
           
        $can_insert = $db->insert('transaction_alipay', $can_req_data);

        $parameter = array(
        "_input_charset" => trim(strtolower($input_charset)),
        "out_trade_no" => $cancel_orig_otno,
        "partner" => $cncl_partner_id_ap,
        "service" => $cancel_service,
        "timestamp" => date('YmdHis')
        );

        /* Cancel request data to Alipay -  log */

        $before_build = "Application Log POS:".date("Y-m-d H:i:s") . " Cancel request data Before Build:" . json_encode($parameter) . " \n\n";
        grablogs($before_build);

        // /* MD5 class parameter passing to function*/ 
        // $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);


        

        /* MD5 class parameter passing to function*/ 
        $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);

        $after_built = "Application Log POS:".date("Y-m-d H:i:s") . " Cancel Build Data Send to Alipay:" . $html_text. " \n\n";
        grablogs($after_built);


        $url = $alipay_url . $html_text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $error = curl_errno($ch);
        /* Refund response log */

        if(curl_errno($ch)) {
            $err_resp = " Cancel Response POS:".date("Y-m-d H:i:s") .curl_errno($ch) . " \n\n";
            grablogs($err_resp);
        } else {
            $succs_resp =  " Cancel Response POS:".date("Y-m-d H:i:s") . $server_output . " \n\n";
            grablogs($succs_resp);

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
            $response = array(
            "is_success" => $is_success,
            "result_code" => $result_code,
            "res_sign_type" => $sign_type,
            "res_sign" => $sign,
            "out_trade_no" => $out_trade_no_res,
            "trade_no" => $trade_no,
            "retry_flag" => $retry_flag,
            "action" => $action,

            );

          $can_response_success = "Application Log POS:".date("Y-m-d H:i:s") . " Cancel Success response update in table:" . json_encode($response) . " \n\n";
          grablogs($can_response_success);
                
            $db->where("out_trade_no",$cancel_orig_otno);
            $db->where("transaction_type",$ttype);
            $update = $db->update('transaction_alipay', $response);
            
            $cancel_succ_res = array(
                "transaction_status" => $result_code,
                "amount" => $amount,
                "terminal_id" => $terminal_id,
                "txID" => $cncl_out_trade_no_res,
                "timestamp" => $updated_datetime  
            ); 

            $can_succs_res_pos= "Application Log POS:".date("Y-m-d H:i:s") . " Cancel Success response to pos:" . json_encode($cancel_succ_res) . " \n\n";
            grablogs($can_succs_res_pos);

            $can_succs_res_pos_encode = json_encode($cancel_succ_res);
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

                $can_response_error = "Application Log POS:".date("Y-m-d H:i:s") . " Cancel error response update in table:" . json_encode($response) . " \n\n";
                grablogs($can_response_error);

                // $db->where("out_trade_no",$cancel_orig_otno);
                // $amount_get = $db->getOne('transaction_alipay');
                // $amount = $amount_get['total_fee'];

                $cancl_err_resp = array(
                    "transaction_status" => $result_code,
                    "out_trade_no" => $cancel_orig_otno,
                    "terminal_id" => $terminal_id,
                    "txID" => $cncl_out_trade_no_res,
                    "amount" => $amount
                );

                $can_err_res_pos= "Application Log POS:".date("Y-m-d H:i:s") . " Cancel error response to pos:" . json_encode($cancl_err_resp) . " \n\n";
                grablogs($can_err_res_pos);

                $db->where("out_trade_no",$cancel_orig_otno);
                $db->where("transaction_type",$ttype);
                $cancel_update = $db->update('transaction_alipay', $response);

                $can_err_res_pos_encode = json_encode($cancl_err_resp);
                header('Content-Type: application/json');
                echo $can_err_res_pos_encode;
            }
        
    
}else{
        $acs = $str[1];
        $access_den = array(
            'merchant_id' => $secondary_merchant_id,
            'terminal_id' => $terminal_id,
            'out_trade_no' => $cancel_orig_otno,
            'cancel_access' => $acs
        );
        $mer_access_permsn = "Cancel Access Log POS:".date("Y-m-d H:i:s") . " Cancel Not Allowed Log:" .json_encode($access_den). " \n\n";
        grablogs($mer_access_permsn);

        echo 'Cancel denied to this merchant';
    }
}
function settlementAlipay($settle_terminal_id,$settle_mer_id,$payment_type){
    GLOBAL $db;
    

        $set_payment_type = $payment_type;
        $set_mer_id = $settle_mer_id;
        $set_terminal_id = $settle_terminal_id;

        /* Singapore time set to insert in transaction_alipay table */

        $given_datetime = date('Y-m-d H:i:s');//$project['trans_datetime'];
        $given = new DateTime($given_datetime);
        $given->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore = $given->format("Y-m-d H:i:s");

        $singapore_start = date('Y-m-d H:i:s');
        $given_start = new DateTime($singapore_start);
        $given_start->setTimezone(new DateTimeZone("Asia/Singapore"));
        $gmt_time_singapore_start = $given_start->format("Y-m-d 00:00:00");

        $sdate = $gmt_time_singapore_start;
        $edate = $gmt_time_singapore;
        $current_date_time = date("Y-m-d H:i:s");

        $que1 ="SELECT terminal_id,merchant_id, COUNT(transaction_alipay.id_transaction_id) AS countt, SUM(transaction_alipay.total_fee) AS total FROM transaction_alipay WHERE merchant_id = '$set_mer_id' AND terminal_id = '$set_terminal_id' AND transaction_type IN ('1') AND result_code='SUCCESS' AND trade_status='TRADE_SUCCESS' AND cst_trans_datetime>='$sdate' AND cst_trans_datetime<='$edate'";


        $data1 = $db->rawQuery($que1);

        $que2 ="SELECT terminal_id,merchant_id, COUNT(transaction_alipay.id_transaction_id) AS countt, SUM(transaction_alipay.refund_amount) AS total FROM transaction_alipay WHERE merchant_id = '$set_mer_id' AND terminal_id = '$set_terminal_id' AND transaction_type IN ('2') AND result_code='SUCCESS' AND cst_trans_datetime>='$sdate' AND cst_trans_datetime<='$edate'";

        $data2 = $db->rawQuery($que2);

        $que3 ="SELECT terminal_id,merchant_id, COUNT(transaction_alipay.id_transaction_id) AS countt, SUM(transaction_alipay.total_fee) AS total FROM transaction_alipay WHERE merchant_id = '$set_mer_id' AND terminal_id = '$set_terminal_id' AND transaction_type IN ('3') AND result_code='SUCCESS' AND action='refund' AND cst_trans_datetime>='$sdate' AND cst_trans_datetime<='$edate'";

        $data3 = $db->rawQuery($que3);

        if($data1) {
            foreach($data1 as $var1){
                $total_count = $var1['countt'];
                $total_amount= $var1['total'];
                $merchant_id = $var1['merchant_id'];
                $terminal_id = $var1['terminal_id'];
            }
        }
        if($data2) {
            foreach($data2 as $var2){
                $refund_count = $var2['countt'];
                $refund_amount= $var2['total'];
                $merchant_id = $var2['merchant_id'];
                $terminal_id = $var2['terminal_id'];
            }
        }

        if($data3) {
            foreach($data3 as $var3){
                $cancel_count = $var3['countt'];
                $cancel_amount= $var3['total'];
            }
        }

        $total_amt_deci = $total_amount*100;
        $refund_amt_deci = $refund_amount*100;
        $cancel_amt_deci = $cancel_amount*100;

        //Balance diff between total sale and refund
        $t_amt = $total_amt_deci;
        $r_amt = $refund_amt_deci;
        $c_amt = $cancel_amt_deci;
        $rc =$r_amt+$c_amt;
        $amt_lth = strlen($t_amt);
        $diff = $t_amt - $rc;
        $diff_ans = sprintf('%0'.$amt_lth.'d', $diff);

        $settlement_response = array(
            "pay_type" => $set_payment_type,
            "Total_Sale_Count"  => $total_count,
            "Total_Sale_Amount" => $total_amt_deci,
            "Total_Refund_Count"  => $refund_count+$cancel_count,
            "Total_Refund_Amount" => $rc,
            "balance" => $diff_ans,
            "merchant_id" => $merchant_id,
            "terminal_id" => $terminal_id,
            "timestamp" => $gmt_time_singapore,
            "Period" => $sdate." To ".$gmt_time_singapore
        );

        $settle_res_send= "Application Log POS:".date("Y-m-d H:i:s") . " Settlement Response Send to App :" .json_encode($settlement_response) . " \n\n";
            grablogs($settle_res_send);

        $response_encode = json_encode($settlement_response);
        header('Content-Type: application/json');
        echo $response_encode;
}

// $res = $db->get('merchants');
// print_r($res);exit;

// $obj = new alipay();
// $obj->grablogs(); 

?>