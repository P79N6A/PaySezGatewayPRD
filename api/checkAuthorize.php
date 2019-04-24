<?php
/**
 * Created by PhpStorm.
 * User: GCCOE_01
 * Date: 23-09-2017
 * Time: 04:02 PM
 */
date_default_timezone_set('Asia/Calcutta');
$partner_id=$_POST['partner_id'];
$merchant_password=$_POST['merchant_password'];
$env=$_POST['env'];
$duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
$dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";
require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
foreach($_POST as $key=>$value)
{
    if($key=="cc_number"){
        $newval = substr_replace($value, str_repeat("X", 8), 4, 12);
        $postdata .= $key.'='.$newval.''.PHP_EOL;
    }
	else if($key=="Cvv2"){
		$newval2 =substr_replace($value, str_repeat("X", 3), 0, 3);
		$postdata .= $key.'='.$newval2.''.PHP_EOL;
	}
    else {
        $postdata .= $key.'='.$value.''.PHP_EOL;
    }
}
foreach($_POST as $key=>$value)
{

    $postdatan .= $key.'='.$value.'&';

}

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
require_once('encrypt.php');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$db = new Mysqlidb ('localhost', $userd, $passd, 'rebanx');
$tran_id = $_POST['tran_id'];
$db = new Mysqlidb ('localhost', $userd, $passd, 'rebanx');

$db->where("transaction_id", $tran_id);
    $t = $db->getOne("transactions");


if($t['network']=='MC') {

        $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/checkAuthorize.php");
        curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/checkAuthorize.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdatan);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        if (curl_errno($ch)) {
            $afm = array(
                "author" => "xxxx",
                "status" => "FAILURE",
                "errorcode" => "202",
                //"errordesc " => "auth response failed",
                "apprcode" => 0,
                "refNbr" => 0,
                "RRN" => 0
            );
            echo json_encode($afm);
            if ($env != "testm" && $env != "livem") {
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------" . $afm . "";
                // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                $myfile = file_put_contents('http://10.162.104.221/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            } else {
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------" . $afm . "";
                // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                $myfile = file_put_contents('http://10.162.104.221/api/merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            /*
            $eecode= $afm->errorcode;
            $sql = 'UPDATE transactions SET  error_code ="'.$eecode.'", appr_code="'.$afm->apprcode.'" WHERE id_transaction_id="'.$tran_id.'"';
            $db->rawQuery($sql);

            $sql1 = 'UPDATE actions SET success ="failed", processor_transaction_timestamp ="'.date('h:m:i').'", processor_settlement_date ="'.date('Y-m-d').'" WHERE id_transaction_id="'.$tran_id.'"';
            $db->rawQuery($sql1);
            */
            exit;
        }
        print_r($server_output);
        curl_close($ch);
        exit;

}
else {
		$ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/checkAuthorize.php");
        curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/checkAuthorize.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdatan);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        if (curl_errno($ch)) {
            $afm = array(
                "author" => "xxxx",
                "status" => "FAILURE",
                "errorcode" => "202",
                //"errordesc " => "auth response failed",
                "apprcode" => 0,
				"refNbr" => 0,
                "RRN" => 0
            );
            echo json_encode($afm);
            if ($env != "testm" && $env != "livem") {
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------" . $afm . "";
                // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                $myfile = file_put_contents('http://10.162.104.221/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            } else {
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------" . $afm . "";
                // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                $myfile = file_put_contents('http://10.162.104.221/api/merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
			/*
            $eecode= $afm->errorcode;
            $sql = 'UPDATE transactions SET  error_code ="'.$eecode.'", appr_code="'.$afm->apprcode.'" WHERE id_transaction_id="'.$tran_id.'"';
            $db->rawQuery($sql);

            $sql1 = 'UPDATE actions SET success ="failed", processor_transaction_timestamp ="'.date('h:m:i').'", processor_settlement_date ="'.date('Y-m-d').'" WHERE id_transaction_id="'.$tran_id.'"';
            $db->rawQuery($sql1);
			*/
            exit;
        }
        print_r($server_output);
        curl_close($ch);
		exit;


	}

?>