<?php 
if($_POST['tran_req_type'] == '5'){
    // if (isset($_POST['username']))
    // {
        
    $terminal_id ='54f50424894fe164971a3020f';
    $IMEI = $_POST['IMEI'];
    $user = $_POST['user'];
    $password = $_POST['password'];

    if($user != "" && $password != ""){

    $login_array = array(
    "IMEI" => $IMEI,
    "user" => $user,
    "password" => $password
    );

    $login_request = "Application Log GP:".date("Y-m-d H:i:s") . " Login Request data:" . json_encode($login_array) . " \n\n";
    poslogs($login_request);


    $login_res_array = array(
    "login_status" => 'SUCCESS',
    "IMEI" => $IMEI,
    "terminal_id" => $terminal_id,
    "merchant_id" => $merchant_id
    );

    $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
    poslogs($login_response);

    $login_response_encode = json_encode($login_res_array);
    header('Content-Type: application/json');
    echo $login_response_encode;
    exit;
} else{
    $login_array = array(
    "IMEI" => $IMEI,
    "user" => $user,
    "password" => $password
    );
    $login_request = "Application Log GP:".date("Y-m-d H:i:s") . " Login Request data:" . json_encode($login_array) . " \n\n";
    poslogs($login_request);

    $login_res_array = array(
    "login_status" => 'FAILURE',
    "IMEI" => $IMEI
    );

    $login_response= "Application Log GP:".date("Y-m-d H:i:s") . " Login Response Send to App :" .json_encode($login_res_array) . " \n\n";
    poslogs($login_response);

    $login_response_encode = json_encode($login_res_array);
    header('Content-Type: application/json');
    echo $login_response_encode;
    exit;
}
}
?>