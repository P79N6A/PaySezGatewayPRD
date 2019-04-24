<?php 
//define('ROOT_PATH', dirname(__DIR__) . '/');
//echo $v;exit;
    date_default_timezone_set('Asia/Kolkata');
    require_once("alipay.config.php");
    
    /* Log path declare by variable use in function poslogs */
    $log_path = $alipay_config['log-path'];

    /** Log File Function starts **/
    function poslogs($log) {
    GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
    }



    $duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
    $dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

    $dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

    require_once('admin/php/MysqliDb.php');
    require 'admin/kint/Kint.class.php';
    //require_once('admin/api/encrypt.php');
        print_r(__LINE__);
    die();

//     //require_once("inc_login.php");
// print_r($_POST);
//     exit;
//     error_reporting(0);
//     $userd=mc_decrypt($duser, $dkey);
//     $passd=mc_decrypt($dcode, $dkey);

//     // date_default_timezone_set('Asia/Kolkata');
//     // require_once("alipay.config.php");
//     $db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);
    
//     if (isset($_POST['user']))
// {
    
    
//     $username = $_POST['user'];
//     $password = $_POST['password'];
    
    
    // $result = loginUser($username, $password);
    
    // if ($result != false)
    // {
    //     session_start();
    //     $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    //     $_SESSION['id'] = $result['id'];
    //     $_SESSION['iid'] = $result['id']; //<--need to encrypt this
    //     $_SESSION['username'] = $result['username'];
    //     $_SESSION['first_name'] = $result['first_name'];
    //     $_SESSION['last_name'] = $result['last_name'];
    //     $_SESSION['user_type'] = $result['user_type'];
    //     $_SESSION['is_first_login'] = $result['is_first_login'];

    //     switch ($_SESSION['user_type']) {
    //         case '1': //Master Administrator
    //             $_SESSION['user_roles'] = ['M','A','C','F','R','S','B','V','U'];
    //             break;                        

    //         case '2': //Agent Administrator
    //             $_SESSION['user_roles'] = ['M','A','F','R','S'];
    //             break;                        

    //         case '3': //Agent
    //             $_SESSION['user_roles'] = ['M','A','R','S'];
    //             break;                        

    //         case '4': //Merchant Administrator
    //             $_SESSION['user_roles'] = ['R','B','V'];
    //             break;                        

    //         case '5': //Merchant
    //             $_SESSION['user_roles'] = ['R','S','B','V'];
    //             break;                        

    //         case '6': //Merchant CSR
    //             $_SESSION['user_roles'] = ['V'];
    //             break;                 

    //         case '7': //Super Agent
    //             $_SESSION['user_roles'] = [];
    //             break;            
            
    //         default:
    //             $_SESSION['user_roles'] = [];
    //             break;
    //     }
        

//     $terminal_id ='54f50424894fe164971a3020f';
//     $IMEI = $_POST['IMEI'];
//     $user = $_POST['user'];
//     $password = $_POST['password'];

//     if($user != "" && $password != ""){

//     $login_array = array(
//     "IMEI" => $IMEI,
//     "user" => $user,
//     "password" => $password
//     );

//     $login_request = "Application Log GP:".date("Y-m-d H:i:s") . " Login Request data:" . json_encode($login_array) . " \n\n";
//     poslogs($login_request);


//     $login_res_array = array(
//     "login_status" => 'SUCCESS',
//     "IMEI" => $IMEI,
//     "terminal_id" => $terminal_id,
//     "merchant_id" => $merchant_id
//     );

//     $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
//     poslogs($login_response);

//     $login_response_encode = json_encode($login_res_array);
//     header('Content-Type: application/json');
//     echo $login_response_encode;
//     exit;
// } else{
//     $login_array = array(
//     "IMEI" => $IMEI,
//     "user" => $user,
//     "password" => $password
//     );
//     $login_request = "Application Log GP:".date("Y-m-d H:i:s") . " Login Request data:" . json_encode($login_array) . " \n\n";
//     poslogs($login_request);

//     $login_res_array = array(
//     "login_status" => 'FAILURE',
//     "IMEI" => $IMEI
//     );

//     $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
//     poslogs($login_response);

//     $login_response_encode = json_encode($login_res_array);
//     header('Content-Type: application/json');
//     echo $login_response_encode;
//     exit;
// }

?>