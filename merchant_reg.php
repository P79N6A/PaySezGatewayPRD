<?php
session_start();



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
require_once("MD5HtmlBuildSubmit.php");
$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);


/*MD5 class definition */
$HtmlBuild_Submit = new MD5HtmlBuildSubmit();


$service = $_POST['service'];
$partner =$_POST['partner'];
$_input_charset = $_POST['_input_charset'];
$timestamp = date('Y-m-d H:i:s');
$secondary_merchant_name = $_POST['secondary_merchant_name'];
$secondary_merchant_id = $_POST['secondary_merchant_id'];
$store_id =$_POST['store_id'];
$store_name = $_POST['store_name'];
$store_country =$_POST['store_country'];
$store_address =$_POST['store_address'];
$store_industry =$_POST['store_industry']; //mcc code
$csphone =$_POST['csphone'];
$csemail =$_POST['csemail'];
$req_type=$_POST['req_type'];
$sign=$_POST['sign'];
$sign_type = 'MD5';

$extend_param ='{"merchant_name": "'.$secondary_merchant_name.'",  "store_id": "'.$store_id.'", "store_name": "'.$store_name.'","store_country":"'.$store_country.'","store_address":"'.$store_address.'","store_industry":"'.$store_industry.'","csphone":"'.$csphone.'","csemail":"'.$csemail.'"}';


$parameter_ins = array(
    "extend_params" => $extend_param,
    "service"=> $service,
    "partner"=> $partner,
    "input_charset" => $_input_charset,
    "timestamp" => $timestamp,
    "merchant_id" => $secondary_merchant_id,
    "sign" => $sign,
    "sign_type" => $sign_type,
    "transaction_type" => $req_type
);

$insert_precreate = $db->insert('transaction_alipay', $parameter_ins);


$aurl="https://mapi.alipaydev.com/gateway.do?";

#/ Log path declare by variable use in function poslogs /
$log_path = $alipay_config['log-path'];

/* Log File Function starts */
function poslogs($log) {
   GLOBAL $log_path;
$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}

    $_SESSION['sign'] =$sign;

//     print_r($_SESSION);
// die();
//old one    

        // $parameter = array(
        //     "_input_charset" => $_input_charset,
        //     "partner" => $partner,
        //     "service" => $service,
        //     "secondary_merchant_name" => $secondary_merchant_name,
        //     "secondary_merchant_id" => $secondary_merchant_id,
        //     "store_id" => $store_id,
        //     "store_name" => $store_name,
        //     "store_country" => $store_country,
        //     "store_address" => $store_address,
        //     "store_industry" => $store_industry,
        //     "secondary_merchant_type"=>"ENTERPRISE",
        //     "registration_no"=>"NA",
        //     "register_country"=>"NA",
        //     "register_address"=>"NA",
        //     "representative_name"=>"NA",
        //     "representative_id"=>"NA",
        //     "settlement_no"=>"NA",
        //     "contact_email"=>$csemail,
        //     "contact_no"=>$csphone,
        //     "timestamp" => $timestamp
        // );

// new one
    $parameter = array(
            "secondary_merchant_name"   =>  $secondary_merchant_name,
            "secondary_merchant_id"     =>  $secondary_merchant_id,
            "store_id"                  =>  $store_id,
            "store_name"                =>  $store_name,
            "store_country"             =>  $store_country,
            "store_address"             =>  $store_address,
            "store_industry"            =>  $store_industry,
            "secondary_merchant_type"   =>  "INDIVIDUAL",
            "registration_no"           =>  "NA",
            "register_country"          =>  "NA",
            "register_address"          =>  "NA",
            "representative_name"       =>  "NA",
            "representative_id"         =>  "NA",
            "settlement_no"             =>  "NA",
            "contact_no"                =>  $csphone,
            "contact_email"             =>  $csemail,
            "timestamp"                 =>  $timestamp,
            "service"                   =>  $service,
            "partner"                   =>  $partner,   //2088621898856371
            "_input_charset"            =>  $_input_charset
        );

    // $parameter = array(
    //         "secondary_merchant_name"   =>  "hanguo",
    //         "secondary_merchant_id"     =>  "2016051446800462",
    //         "store_id"                  =>  "23372327348",
    //         "store_name"                =>  "LV",
    //         "store_country"             =>  "HK",
    //         "store_address"             =>  "store address",
    //         "store_industry"            =>  "4121",
    //         "secondary_merchant_type"   =>  "INDIVIDUAL",
    //         "registration_no"           =>  "012345678",
    //         "register_country"          =>  "HK",
    //         "register_address"          =>  "No.277, Road YinCheng, Shanghai, China",
    //         "representative_name"       =>  "Tom Li",
    //          "representative_id"         =>  "123456789",
    //         "settlement_no"             =>  "2600100000",
    //         "contact_no"                =>  "18600000000",
    //         "contact_email"             =>  "support@xcompany.com",
    //         "timestamp"                 =>  $timestamp,
    //         "service"                   =>  "alipay.overseas.secmerchant.offline.maintain",
    //         "partner"                   =>  $partner,
    //         "_input_charset"            =>  "UTF-8"
    //     );


       
               #/ payment request data log ,send to alipay /
        $log1 = "Application Log for Merchant:".date("Y-m-d H:i:s") . " URL alipay:" . $aurl. " \n\n";
        poslogs($log1);

        $log2 = "Application Log for Merchant:".date("Y-m-d H:i:s") . " Merchant Register Request Data Before Build :" .json_encode($parameter). " \n\n";
         poslogs($log2);
        /* MD5 class parameter passing to function*/ 
        $html_text = $HtmlBuild_Submit->buildMD5Data($parameter);  
        //print_r($html_text );
        //die();      

        $log3 = "Application Log for Merchant:".date("Y-m-d H:i:s") . " Build Data send to Alipay:" . $html_text. " \n\n";
         poslogs($log3);

        $url=$aurl . $html_text ;
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        /* Payment response log*/
        if(curl_errno($ch)){
            $log = date("Y-m-d H:i:s") . "  Merchant register Response:" . curl_errno($ch) . " \n\n";
             poslogs($log);

        } else {
            $log = date("Y-m-d H:i:s") . " Merchant register Response:" . $server_output . " \n\n";
             poslogs($log);
        }

        curl_close($ch);
        
        $result_code=$HtmlBuild_Submit->get_from_tag($server_output, '<result_code>','</result_code>');
        $sign=$HtmlBuild_Submit->get_from_tag($server_output, '<sign>','</sign>');
        $sign_type=$HtmlBuild_Submit->get_from_tag($server_output, '<sign_type>','</sign_type>');
        $data = array(
            "result_code" => $result_code,
            "sign" => $sign,
            "sign_type" => $sign_type
        );
        $data_succs_update = array(
            "result_code" => $result_code,
            "res_sign" => $sign,
            "res_sign_type" => $sign_type
        );
        $data_error_update = array(
            "result_code" => $error,
            "res_sign" => $sign,
            "res_sign_type" => $sign_type
        );

    /* registeration response log */

        $final_reg_res = date("Y-m-d H:i:s") . " Fianl Registration response for merchant:" . json_encode($data) . " \n\n";
            poslogs($final_reg_res);

        if($result_code == 'SUCCESS'){
            /* Update Success response in transaction_alipay */
            $db->where("merchant_id",$secondary_merchant_id);
            $db->where("transaction_type",$req_type);
            $reg_res_update = $db->update('transaction_alipay', $data_succs_update);

            $update_am_status = array("am_status" => '1');
             $db->where("mer_map_id", $secondary_merchant_id);
             $am_status_update = $db->update('merchants', $update_am_status);
             echo "Registration Success";
             exit;die();

     }else{
            /* Update Error response in transaction_alipay */
            $db->where("merchant_id",$secondary_merchant_id);
            $db->where("transaction_type",$req_type);
            $reg_res_update = $db->update('transaction_alipay', $data_error_update);
            echo "Registration Not Success Retry";
            exit;die();
      }

        ?>