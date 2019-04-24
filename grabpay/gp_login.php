<?php 

    date_default_timezone_set('Asia/Kolkata');
    //require_once("alipay.config.php");
    require_once("grabPay.config.php");
    /* Log path declare by variable use in function poslogs */
    //$log_path = $alipay_config['log-path'];
    $log_path = $grabpay_config['log-path'];
    /** Log File Function starts **/
    function poslogs($log) {
    GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
    }

    $duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
    $dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

    $dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

    require_once('../php/MysqliDb.php');
    require '../kint/Kint.class.php';
    require_once('../api/encrypt.php');
    require_once("inc_login.php");
    
    error_reporting(0);
    $userd=mc_decrypt($duser, $dkey);
    $passd=mc_decrypt($dcode, $dkey);
 
    $db = new Mysqlidb ($confighost, $userd, $passd, $grabpay_config['dataBase_con']);
 
if ($_POST['user'] != "" && $_POST['password'] != "" && $_POST['IMEI'] != "") {
    
        $username = $_POST['user'];
        $password = $_POST['password'];
        $imei = $_POST['IMEI'];

        $login_array = array(
        "IMEI" => $imei,
        "user" => $username,
        "password" => $password
        );

        $login_request = "Application Log GP:".date("Y-m-d H:i:s") . " Login Request Received from Mpos:" . json_encode($login_array) . " \n\n";
        poslogs($login_request);

        $sql_terminal = 'SELECT * FROM terminal where imei = "'.$imei.'"';

        $data = $db->rawQuery($sql_terminal);
        //print_r($data);exit;
        $merchant_id = $data[0]['idmerchants'];
        $terminal_id = $data[0]['mso_terminal_id'];

        $sql_merchant = 'SELECT * FROM merchants where idmerchants = "'.$merchant_id.'"';
        $result = $db->rawQuery($sql_merchant);

        $merchant_name = $result[0]['merchant_name'];
        $address = $result[0]['address1'];
        $mer_map_id = $result[0]['mer_map_id'];

  if($terminal_id != ''){
        $login_res_array = array(
        "login_status" => 'SUCCESS',
        "IMEI" => $imei,
        "terminal_id" => $terminal_id,
        "merchant_id" => $mer_map_id,
        "merchant_name" => $merchant_name,
        "merchant_addrs" => $address
        );

        $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
        poslogs($login_response);

        $login_response_encode = json_encode($login_res_array);
        header('Content-Type: application/json');
        echo $login_response_encode;
        exit;
    }else{

        $login_res_array = array(
        "login_status" => 'FAILURE',
        "IMEI" => $imei
        );

        $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
        poslogs($login_response);

        $login_response_encode = json_encode($login_res_array);
        header('Content-Type: application/json');
        echo $login_response_encode;
        exit;
        }
    
}else {
        $login_res_array = array(
        "login_status" => 'FAILURE',
        "IMEI" => $imei
        );

        $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
        poslogs($login_response);

        $login_response_encode = json_encode($login_res_array);
        header('Content-Type: application/json');
        echo $login_response_encode;
        exit;
        }

?>

