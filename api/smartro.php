<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 21-09-2017
 * Time: 04:36 PM
 */
session_start();

if ($_SESSION['mangaaaa']=="yes") {
    $_SESSION['mangaaaa'] = "";
    $reurl=$_SESSION['mangaaaaurl'];
    unset($_SESSION["mangaaaa"]);
    session_destroy();
    header('Refresh:1; url= rbredirect.php?url='.$reurl);
}

/**** Setting Session for Redirection ****/
$_SESSION['mangaaaa'] = "yes";
$redirectionurl = $_POST['redirectionurl'];
$_SESSION['mangaaaaurl'] = $redirectionurl;

/**** Database UserName and Password ****/
$duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
$dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";

$mycardtype=getCCType($_POST['cc_number']); // Get the Card Type

$TransactionType = $_POST['TransactionType'];
$redirectionurl = $_POST['redirectionurl'];
$appredirect = $_POST['camefrom'];
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
if($appredirect==""){
    $appredirect='http://169.38.91.250';
}
$env=$_POST['env'];
$senter="success";
if($env!="testm" && $env!="livem"){
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script language="javascript" src="https://cert.mwsrec.npci.org.in/MWS/Scripts/MerchantScript_v1.0.js" type="text/javascript"></script>
    <?php
    include('../fbtest.php');
	
}

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
require_once('encrypt.php');
error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$db = new Mysqlidb ('localhost', $userd, $passd, 'rebanx');
$conmy = mysqli_connect('localhost', $userd, $passd, 'rebanx');
//$db = new Mysqlidb ('localhost', 'root', '', 'rebanx1');

$data = array();

$file = 'postlogs.txt';
$postdata = date('l jS \of F Y h:i:s A').''.PHP_EOL;
foreach($_POST as $key=>$value)
{
	if($key=="cc_number"){
		$newval = substr_replace($value, str_repeat("X", 8), 4, 12);	
		$postdata .= $key.'='.$newval.''.PHP_EOL;
	}
	else if($key=="cvv2"){
		$newval2 =substr_replace($value, str_repeat("X", 3), 0, 3);
		$postdata .= $key.'='.$newval2.''.PHP_EOL;
	}
	else {
		$postdata .= $key.'='.$value.''.PHP_EOL;
	}
}

$postdata.= '==========================='.PHP_EOL;

foreach($_POST as $key=>$value) {
	$postdatan .= $key.'='.$value.'&';
}
$postdatan .= 'camefrom=http://169.38.91.250';


$moto = 0;


if($TransactionType == 'AA'){


    if(getCCType($_POST['cc_number'])=="Rupay" && $_POST['tax']!='MC' && $_POST['tax']!='VISA'){

	    if(($env == "live" || $env == "test") && $mycardtype == "Rupay") {
        ?>
            <!-- <form id='retoapp' action="http://169.38.91.251/api/smartro.php" method="post">
                <?php // foreach($_POST as $key=>$value) { ?>
                <input type="hidden" name="<?php // echo $key; ?>" value="<?php // echo $value;?>">
                <?php // } ?>
                <input type="hidden" name="camefrom" value="http://169.38.91.250"> 
            </form>
            <script>
                $('#retoapp').submit();
            </script> -->
            <?php
            $ch = curl_init();

            // curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/smartro.php");
            curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/smartro.php"); //webresponse.php
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdatan);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $afm = array(
                    "status" => "FAILURE",
                        "errorcode" => "01",
                        //"errordesc " => "Initiate response failed",
                        "tran_id" => 0,
                        "guid" => 0,
                        "modulus" => 0,
                        "exponent" => 0
                );
                echo json_encode($afm);
                
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------" . $afm . "";
                // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                $myfile = file_put_contents('http://10.162.104.221/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            // print_r($server_output);
			$serverjson = json_decode($server_output, true);
			$location = $serverjson['Location']."?success=".$serverjson['success']."&txn=".$serverjson['txn']."&errordesc=".$serverjson['errordesc']."&".$serverjson['sendval'];
			?>
			<script>
                window.location.assign("<?php echo $location; ?>");
            </script>
			<?php
			curl_close($ch);
            ?>
			
        <?php
        } else {
		    
            $ch = curl_init();

            // curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/smartro.php");
            curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/smartro.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdatan);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $afm = array(
                    "status" => "FAILURE",
                        "errorcode" => "01",
                        //"errordesc " => "Initiate response failed",
                        "tran_id" => 0,
                        "guid" => 0,
                        "modulus" => 0,
                        "exponent" => 0
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
                exit;
            }
            print_r($server_output);
            curl_close($ch);
    		exit;
        }
    
    } else if($mycardtype=="Mastercard") {

        if($env=="live" || $env=="test") {
            ?>
            <!-- <form id='retoapp' action="http://169.38.91.251/api/smartro.php" method="post">
                <?php //foreach($_POST as $key=>$value) { ?>
                <input type="hidden" name="<?php //echo $key; ?>" value="<?php //echo $value;?>">
                <?php //} ?>
                <input type="hidden" name="camefrom" value="http://169.38.91.250">
            </form>
            <script>
                $('#retoapp').submit();
            </script> -->

            <?php

            $ch = curl_init();

            // curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/smartro.php");
            curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/smartro.php"); //webresponse.php
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdatan);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $afm = array(
                    "status" => "FAILURE",
                        "errorcode" => "01",
                        //"errordesc " => "Initiate response failed",
                        "tran_id" => 0,
                        "guid" => 0,
                        "modulus" => 0,
                        "exponent" => 0
                );
                echo json_encode($afm);
                
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------" . $afm . "";
                // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
                $myfile = file_put_contents('http://10.162.104.221/api/merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            // print_r($server_output);
            $serverjson = json_decode($server_output, true);
            $location = $serverjson['Location']."?success=".$serverjson['success']."&txn=".$serverjson['txn']."&errordesc=".$serverjson['errordesc']."&".$serverjson['sendval'];
            ?>
            <script>
                window.location.assign("<?php echo $location; ?>");
            </script>
            <?php
            curl_close($ch);

        } else {
            $ch = curl_init(); 

            // curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/smartro.php");
            curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/smartro.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdatan);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $afm = array(
                    "status" => "FAILURE",
                    'errorcode' => '01',
                    'tran_id' => "0",
                    "guid" => "0",
                    "modulus" => "0",
                    "exponent" => "0",
                    'Mermapid' => "0"
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
                    // $myfile = file_put_contents('http://169.38.91.251/api/merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX)
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
    }

}elseif($TransactionType == 'AC'){
    $db->where('id_transaction_id', $_POST['TID']);
    $db->where('merchant_id', $KeyArray[0]);
    $db->where('platform_id', $KeyArray[2]);
    $db->where('processor_id', $KeyArray[1]);
    $chargeback_flag = 0;
    $action_type = 'refund';
    if(isset($_POST['iscb'])){
        $chargeback_flag = 1;
        $action_type = 'chargeback';
        $success = 1;
        $condition = 'complete';
        $jsonObject['ResponseMessage'] = 'Processing Valid';
    }
    $transactiondata = $db->getOne('transactions');
    $data = Array (
        "merchant_id" => $KeyArray[0], // this should be ID of account using our gateway service
        "platform_id" => $KeyArray[2], //should be our id
        "transaction_type" => $TransactionType,
        "first_name" => $transactiondata['first_name'],
        "last_name" => $transactiondata['last_name'],
        "address1" => $transactiondata['address1'],
        "address2" => $transactiondata['address2'],
        "city" => $transactiondata['city'],
        "us_state" => $transactiondata['us_state'],
        "postal_code" => $transactiondata['postal_code'],
        "country" => $transactiondata['country'],
        "ponumber" => $transactiondata['ponumber'],
        "email" => $transactiondata['email'],
        "phone" => $transactiondata['phone'],
        "shipping_first_name" => $transactiondata['shipping_first_name'],
        "shipping_last_name" => $transactiondata['shipping_last_name'],
        "shipping_address1" => $transactiondata['shipping_address1'],
        "shipping_address2" => $transactiondata['shipping_address2'],
        "shipping_city" => $transactiondata['shipping_city'],
        "shipping_us_state" => $transactiondata['shipping_us_state'],
        "shipping_postal_code" => $transactiondata['shipping_postal_code'],
        "shipping_country" => $transactiondata['shipping_country'],
        "shipping_email" => $transactiondata['shipping_email'],
        "cc_number" => $transactiondata['cc_number'], //encrypt cc number with cc_hash
        "cc_hash" => $transactiondata['cc_hash'], //create encryption here
        "cc_exp" => $transactiondata['cc_exp'], //encrypt this date  with cc_hash
        "cavv" => $transactiondata['cavv'], //encrypt this cvv also  with cc_hash
        "processor_id" => $KeyArray[1], // this should be smartro ID
        "currency" => $transactiondata['currency'],
        "tax" => number_format($_POST['tax'], 2, '.', ''),
        "chargeback_flag" => $chargeback,
        "first_trans" => '0',
        "environment" => $environment,
        "cc_type" => $transactiondata['cc_type'],
        "original_transaction_id" => $transactiondata['id_transaction_id']
    );
    $id_transaction_id = $db->insert('transactions', $data);

    if($id_transaction_id){
        $data2 = Array (
            "id_transaction_id" => $id_transaction_id, // this should be ID of above mysql insert
            "amount" => number_format($_POST['amount'], 2, '.', ''),
            "action_type" => $action_type,
            "transaction_date" => date("Y-m-d H:i:s"),
            "moto_trans" => $moto,
            "asource" => get_client_ip()
        );
        $action_id = $db->insert('actions', $data2);
    }
    $db->where('id_transaction_id', $transactiondata['id_transaction_id']);
    $actiondata = $db->getOne('actions');
    $amount = number_format($_POST['amount'] + $_POST['tax'], 2, '.', '');
    $reference = $id_transaction_id;
    $PartialCancelCode = $_POST['PartialCancelCode'];
    $currency = $_POST['currency'];
    $TID = $transactiondata['transaction_id'];
    $AuthDate = $actiondata['processor_settlement_date'];
    $AuthCode = $transactiondata['authorization_code'];
    $verify = "";
    $OutputType = "X";
    $deliIdx = getDeliIdx($reference, $amount);
    $delimeters = getDelimeters($merchantKey, $deliIdx);
    $vsb ='';
    $vsb .= base64_encode($reference);
    $vsb .= $delimeters[0];
    $vsb .= base64_encode($sendMID);
    $vsb .= $delimeters[1];
    $vsb .= base64_encode($TID); //merchant passes us id_transaction_id and from that we get TID
    $vsb .= $delimeters[2];
    $vsb .= base64_encode($amount);
    $vsb .= $delimeters[3];
    $vsb .= base64_encode($PartialCancelCode);
    $verify = hash('sha256', $vsb);
    $verifyValue = base64_encode($verify);
    $postdata = http_build_query(
        array(
            'Request Start' => '?',
            'Ver' => '1000',
            'RequestType' => 'TRAN',
            'MID' => $sendMID,
            'TransactionType' => $TransactionType,
            'Reference' => $reference,
            'Currency' => $currency,
            'Amount' => $amount,
            'TID' => $TID, //merchant passes us id_transaction_id and from that we get TID
            'AuthDate' => str_replace('-', "", $AuthDate), //merchant passes us id_transaction_id and from that we get "processor_settlement_date" => $ResponseDate from actions table
            'AuthCode' => $AuthCode,//merchant passes us id_transaction_id and from that we get "authorization_code" => $AuthCode from transaction table
            'PartialCancelCode' => $PartialCancelCode,
            'OutputType' => $OutputType,
            'VerifyValue' => $verifyValue
        )
    );
    if(!isset($_POST['iscb'])){
        $jsonObject = doRequest($postdata, $callUrl);
        //var_dump($jsonObject);
        $postdata .= '-------->'.PHP_EOL;
        foreach($jsonObject as $key=>$value)
        {
            $postdata .= $key.'='.$value.''.PHP_EOL;
        }
        $ResponseCode = trim($jsonObject['ResponseCode']);
        $ResponseMessage = trim($jsonObject['ResponseMessage']);
        $AuthCode = trim($jsonObject['AuthCode']);
        $ResponseDate = trim($jsonObject['ResponseDate']);
        $ResponseTime = trim($jsonObject['ResponseTime']);
        $rTID = trim($jsonObject['TID']);
        if(!$rTID){
            $rTID = 'NA';
        }
        $VerifyValue = trim($jsonObject['VerifyValue']);
        //var_dump($jsonObject['TID']);
        //var_dump($TID);
        if($ResponseCode == '0000'){
            $success = 1;
            $condition = 'complete';
        }else{
            $success = 0;
            $condition = 'failed';
        }
        $data3 = Array (
            "transaction_id" => $rTID,
            "condition" => $condition,
            "authorization_code" => $AuthCode,
            "avs_response" => $VerifyValue,
            "csc_response" => $ResponseCode
        );
        //$db->where('id_transaction_id', $id_transaction_id);
        //$id_transaction_id2 = $db->update('transactions', $data3, false);
        $id_transaction_id2 = $db->rawQuery('UPDATE transactions SET `transaction_id` = "'.$rTID.'", `condition` = "'.$condition.'", `authorization_code` = "'.$AuthCode.'", `avs_response` = "'.$VerifyValue.'", `csc_response` = "'.$ResponseCode.'" WHERE `id_transaction_id` = '.$id_transaction_id);
        //echo 'UPDATE transactions SET `transaction_id` = "'.$rTID.'", `condition` = "'.$condition.'", `authorization_code` = "'.$AuthCode.'", `avs_response` = "'.$VerifyValue.'", `csc_response` = "'.$ResponseCode.'" WHERE `id_transaction_id` = '.$id_transaction_id;
        //echo "Last executed query was ". $db->getLastQuery();
        $data4 = Array (
            "success" => $success,
            "response_text" => $ResponseMessage,
            "processor_batch_id" => $rTID,
            "processor_transaction_timestamp" => $ResponseTime,
            "processor_settlement_date" => $ResponseDate
        );
        $db->where('action_id', $action_id);
        $action_id2 = $db->update('actions', $data4);
    }else{
        //transaction info
        $db->join("actions", "actions.id_transaction_id = t.id_transaction_id", "LEFT");
        $db->where("t.id_transaction_id",$transactiondata['id_transaction_id']);
        $trans = $db->getOne("transactions t");
        //die();
        //cc info and encrypt
        $cc_number 	= $trans["cc_number"];
        $cc_hash 	= $trans["cc_hash"];
        $cc = mc_decrypt($cc_number, $cc_hash);
        $cc_last4 = "******".substr($cc, -4);
        $cc_type = getCCType($cc);
        $cc_exp = mc_decrypt($trans["cc_exp"], $cc_hash);
        //insert into database

        $data = Array ();
        $data['processor_id'] 			= $trans['processor_id'];
        $data['m_id'] 					= $trans['merchant_id'];
        //$data['reason_code'] 			= $cb_reason;
        //$data['account_id'] 			= $_SESSION['iid'];
        $data['cb_id'] 					= $TID;
        $data['cb_date'] 				= date("Y-m-d H:i:s");
        $data['cb_amount'] 				= $amount;
        $data['cc_type'] 				= $cc_type;
        $data['ccnum'] 					= $cc_last4;
        $data['first_name'] 			= $trans['first_name'];
        $data['last_name'] 				= $trans['last_name'];
        $data['sale_date'] 				= $trans['transaction_date'];
        $data['sale_value'] 			= $trans['amount'];
        //$cut 							= $trans["platform_id"];
        //$sale_transaction_id 			= preg_replace('/'.$cut.'$/', '', $t_id);
        $data['sale_transaction_id'] 	= $trans['id_transaction_id'];
        $data['user'] 					= $trans['username'];
        //$data['response_date'] 			= $ResponseDate;
        //$data['response_text'] 			= $ResponseMessage;
        $data['status'] 				= $success;
        //$data['dispute_result'] 		= $ResponseCode;
        //$data['update_date'] 			= date('Y-m-d', strtotime($cb_update_date));
        //$data['charged_date'] 			= date('Y-m-d', strtotime($cb_charged_date));
        $data['cb_type'] 				= 'CB';
        $data['cb_comment'] 			= $_POST['cb_comment'];
        $data['id_transaction_id'] 		= $id_transaction_id;
        //$data['authcode'] 				= $AuthCode;

        $data3 = Array (
            "processor_id" => $trans['processor_id'], // this should be ID of above mysql insert
            "m_id" => $trans['merchant_id'],
            "cb_amount" => $amount,
            "id_transaction_id" => $id_transaction_id,
            "moto_trans" => $moto,
            "sale_transaction_id" => $trans['id_transaction_id']
        );
        $cb_id2 = $db->insert ('chargebacks', $data3);
        $db->where('idchargebacks', $cb_id2);
        $cb_id = $db->update('chargebacks', $data);
        //echo "Last executed query was ". $db->getLastQuery();
        if($cb_id2)
        {
            //response correspondance
            if($ResponseMessage != '') {
                $newresponse = Array(	"type" => "merchant",
                    "response_text" => $ResponseMessage,
                    "cb_id" => $cb_id2
                );
                $db->insert('cb_responses', $newresponse);

            }
        }
    }
    /*
    Kint::dump(array(
            'Request Start' => '?',
            'Ver' => '1000',
            'RequestType' => 'TRAN',
            'MID' => $sendMID,
            'TransactionType' => $TransactionType,
            'Reference' => $reference,
            'Currency' => $currency,
            'Amount' => $amount,
            'TID' => $TID, //merchant passes us id_transaction_id and from that we get TID
            'AuthDate' => str_replace('-', "", $AuthDate), //merchant passes us id_transaction_id and from that we get "processor_settlement_date" => $ResponseDate from actions table
            'AuthCode' => $AuthCode,//merchant passes us id_transaction_id and from that we get "authorization_code" => $AuthCode from transaction table
            'PartialCancelCode' => $PartialCancelCode,
            'OutputType' => $OutputType,
            'VerifyValue' => $verifyValue
        ), json_encode($jsonObject)); // pass any number of parameters
        */
    $results = [
        "success" 			=> $success,
        "ResponseMessage" 	=> $jsonObject['ResponseMessage'],
        "TID" 				=> $id_transaction_id
    ];

    echo json_encode($results);
}elseif($TransactionType == 'AD'){
    $vsb ='';
    $vsb .= base64_encode($reference);
    $vsb .= $delimeters[0];
    $vsb .= base64_encode($sendMID);
    $vsb .= $delimeters[1];
    $vsb .= base64_encode($amount);
    $vsb .= $delimeters[2];
    $vsb .= base64_encode($AuthDate);
    $verify = hash('sha256', $vsb);
    $verifyValue = base64_encode($verify);
    $postdata = http_build_query(
        array(
            'Request Start' => '?',
            'Ver' => '1000',
            'RequestType' => 'TRAN',
            'MID' => $sendMID,
            'TransactionType' => $TransactionType,
            'Reference' => $reference,
            'Currency' => $currency,
            'Amount' => $amount,
            'TID' => $TID,
            'AuthDate' => $AuthDate,
            'OutputType' => $OutputType,
            'VerifyValue' => $verifyValue
        )
    );
}elseif($TransactionType == 'AQ'){
    $vsb ='';
    $vsb .= base64_encode($reference);
    $vsb .= $delimeters[0];
    $vsb .= base64_encode($sendMID);
    $vsb .= $delimeters[1];
    $vsb .= base64_encode($TID);
    $vsb .= $delimeters[2];
    $vsb .= base64_encode($amount);
    $verify = hash('sha256', $vsb);
    $verifyValue = base64_encode($verify);
    $postdata = http_build_query(
        array(
            'Request Start' => '?',
            'Ver' => '1000',
            'RequestType' => 'TRAN',
            'MID' => $sendMID,
            'TransactionType' => $TransactionType,
            'Reference' => $reference,
            'TID' => $TID,
            'AuthDate' => $AuthDate,
            'AuthCode' => $AuthCode,
            'ServiceType' => 'A',
            'OutputType' => $OutputType,
            'VerifyValue' => $verifyValue
        )
    );
}elseif($TransactionType == 'SQ'){
    $vsb ='';
    $vsb .= base64_encode($reference);
    $vsb .= $delimeters[0];
    $vsb .= base64_encode($amount);
    $vsb .= $delimeters[1];
    $vsb .= base64_encode($sendMID);
    $vsb .= $delimeters[2];
    $vsb .= base64_encode($TransactionType);
    $verify = hash('sha256', $vsb);
    $verifyValue = base64_encode($verify);
    $postdata = http_build_query(
        array(
            'Request Start' => '?',
            'Ver' => '1000',
            'RequestType' => 'TRAN',
            'MID' => $sendMID,
            'TransactionType' => $TransactionType,
            'Reference' => $reference,
            'Currency' => $currency,
            'Amount' => $amount,
            'TID' => 'gompay001m01011506100921078314',
            'AuthDate' => '20150610',
            'AuthCode' => '338375',
            'OutputType' => $OutputType,
            'VerifyValue' => $verifyValue,
            'Pares' => '?'
        )
    );
}
else {
    echo 'Transaction type not found';
}
//print_r($jsonObject);
//echo 'sent verifyValue: '.$verifyValue;

$postdata .= '---------------------------------'.PHP_EOL;
// Write the contents to the file,
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $postdata, FILE_APPEND | LOCK_EX);
//Credit Card Type
function getCCType($CCNumber)
{
    $creditcardTypes = array(
        array('Name'=>'American Express','cardLength'=>array(15),'cardPrefix'=>array('34', '37'))
    ,array('Name'=>'Maestro','cardLength'=>array(12, 13, 14, 15, 16, 17, 18, 19),'cardPrefix'=>array('5018', '5020', '5038', '6304', '6759', '6761', '6763'))
    ,array('Name'=>'Rupay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6', '50'))
    ,array('Name'=>'Mastercard','cardLength'=>array(16),'cardPrefix'=>array('51', '52', '53', '54', '55'))
    ,array('Name'=>'Visa','cardLength'=>array(13,16),'cardPrefix'=>array('4'))
    /*,array('Name'=>'JCB','cardLength'=>array(16),'cardPrefix'=>array('3528', '3529', '353', '354', '355', '356', '357', '358'))
    ,array('Name'=>'Discover','cardLength'=>array(16),'cardPrefix'=>array('6011', '622126', '622127', '622128', '622129', '62213',
            '62214', '62215', '62216', '62217', '62218', '62219',
            '6222', '6223', '6224', '6225', '6226', '6227', '6228',
            '62290', '62291', '622920', '622921', '622922', '622923',
            '622924', '622925', '644', '646', '647', '648',
            '649'))
    ,array('Name'=>'Solo','cardLength'=>array(16, 18, 19),'cardPrefix'=>array('6334', '6767'))
    ,array('Name'=>'Unionpay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('622126', '622127', '622128', '622129', '62213', '62214',
            '62215', '62216', '62217', '62218', '62219', '6222', '6223',
            '6224', '6225', '6226', '6227', '6228', '62290', '62291',
            '622920', '622921', '622922', '622923', '622924', '622925'))
    ,array('Name'=>'Diners Club','cardLength'=>array(14),'cardPrefix'=>array('300', '301', '302', '303', '304', '305', '36'))
    ,array('Name'=>'Diners Club US','cardLength'=>array(16),'cardPrefix'=>array('54', '55'))
    ,array('Name'=>'Diners Club Carte Blanche','cardLength'=>array(14),'cardPrefix'=>array('300','305'))
    ,array('Name'=>'Laser','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6304', '6706', '6771', '6709'))
*/
    );
    $CCNumber= trim($CCNumber);
    $type='Unknown';
    foreach ($creditcardTypes as $card){
        if (! in_array(strlen($CCNumber),$card['cardLength'])) {
            continue;
        }
        $prefixes = '/^('.implode('|',$card['cardPrefix']).')/';
        if(preg_match($prefixes,$CCNumber) == 1 ){
            $type= $card['Name'];
            break;
        }
    }
    return $type;
}
function doRequest($postdata, $callUrl){
    $xml = getXML($postdata, $callUrl);
    $jsonObject = array(
        "Ver" => $xml->Ver,
        "ResponseCode" => $xml->ResponseCode,
        "ResponseMessage" => $xml->ResponseMessage,
        "AuthCode" => $xml->AuthCode,
        "ResponseDate" => $xml->ResponseDate,
        "ResponseTime" => $xml->ResponseTime,
        "TID" => $xml->TID,
        "TransactionType" => $xml->TransactionType,
        "VerifyValue" => $xml->VerifyValue

    );
    return $jsonObject;
}
function getXML($postdata, $callUrl){
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );

    $context  = stream_context_create($opts);

    $xmlResponse = file_get_contents($callUrl, false, $context);

    $xml = simplexml_load_string($xmlResponse);
    return $xml;
}
function getDelimeters($merchantKey, $deliIdx){
    //String[] delimeters = getDelimeters(merchantKey.substring(0, merchantKey.length()-2), 4, 3, deliIdx);
    $delimeters = getDelimeter(substring($merchantKey, 0, strlen($merchantKey)-2), 4, 3, (int)$deliIdx);
    return $delimeters;
}
function getDeliIdx($reference, $amount){
    //int deliIdx = (Integer.parseInt(reference.substring(reference.length()-4, reference.length())) + Integer.parseInt(amount.replaceAll("\\.", "").replaceAll(",", ""))) % 86;
    $deliIdx = (int)(substring($reference, -4, 4) + str_replace('.', '', $amount)) % 86;
    return $deliIdx;
}
function getKeyData($reference, $amount, $merchantKey){
//for credit card
    $deliIdx2 = (int)(substring($reference, -4, 4) + str_replace(',', '', str_replace('.', '', $amount))) % 4;
    if($deliIdx2 == 0){
        $keyData = substring($merchantKey, 0, 16);
    }else{
        $keyData = substring($merchantKey, (16*$deliIdx2), (16*$deliIdx2+16));
    }
    return $keyData;
}
function encrypt($str, $key){
    $block = mcrypt_get_block_size('rijndael_128', 'ecb');
    $pad = $block - (strlen($str) % $block);
    $str .= str_repeat(chr($pad), $pad);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}
function substring($string, $from, $to){
    return substr($string, $from, $to - $from);
}
//static String[] getDelimeters(String keyStr, int deliCnt, int byteSize, int startIndex) {
function getDelimeter($keyStr, $deliCnt, $byteSize, $startIndex){

    //String temp = keyStr + keyStr;
    $temp = $keyStr.$keyStr;
    //if(keyStr.length() < deliCnt*byteSize)
    if(strlen($keyStr) < ($deliCnt*$byteSize)){
        //	return getDelimeters(temp, deliCnt, byteSize, startIndex);
        return getDelimeter($temp, $deliCnt, $byteSize, $startIndex);
    }
    //String[] result = new String[deliCnt];
    $result = array();
    /*
    for(int i = 0 ; i < deliCnt ; i++) {
        if(i > 0)
            result[i] = temp.substring(startIndex+(byteSize*i), startIndex+(byteSize*(i+1)));
        else
            result[i] = temp.substring(startIndex, startIndex+byteSize);
    }
    */
    $i = 0;
    while($i < $deliCnt) {
        if($i > 0)
            $result[$i] = substring($temp, $startIndex+($byteSize*$i), $startIndex+($byteSize*($i+1)));
        else
            $result[$i] = substring($temp, $startIndex, $startIndex+$byteSize);
        $i++;
    }
    //return resul
    //t;
    return $result;
}
// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function getAuthorize(){
    $xml = '<?xml version="1.0" encoding="utf-8"?>'.
        '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mer="https://paysecure/merchant.soap.header/" xmlns:mer1="https://paysecure/merchant.soap/">
                                    <soapenv:Header>
                                    <RequestorCredentials xmlns="https://paysecure/merchant.soap.header/">
                                    <Token>AF165FBD-4E85-4c66-BEB1-C54DC16CD48B</Token>
                                    <Version>1.0.0.0</Version>
                                    <CallerID>720203</CallerID>
                                    <UserCredentials>
                                    <UserID>test@acculynk.com</UserID>
                                    <Password>Password!1</Password>
                                    </UserCredentials>
                                    </RequestorCredentials>
                                    </soapenv:Header>
                                    <soapenv:Body>
                                    <CallPaySecure xmlns="https://paysecure/merchant.soap/">
                                    <strCommand>initiate</strCommand>
                                    <mer1:strXML><strXML>&lt;paysecure&gt;&lt;partner_id&gt;testcttmerch1&lt;/partner_id&gt;&lt;merchant_password&gt;QPs@1234&lt;/merchant_password&gt;&lt;card_no&gt;6073849300004941&lt;/card_no&gt;&lt;card_exp_date&gt;122019&lt;/card_exp_date&gt;&lt;language_code&gt;en&lt;/language_code&gt;&lt;auth_amount&gt;2500&lt;/auth_amount&gt;&lt;currency_code&gt;356&lt;/currency_code&gt;&lt;cvd2&gt;0941&lt;/cvd2&gt;&lt;transaction_type_indicator&gt;SMS&lt;/transaction_type_indicator&gt;&lt;tid&gt;QAB00001&lt;/tid&gt;&lt;stan&gt;000055&lt;/stan&gt;&lt;tran_time&gt;173906&lt;/tran_time&gt;&lt;tran_date&gt;0919&lt;/tran_date&gt;&lt;mcc&gt;5999&lt;/mcc&gt;&lt;acquirer_institution_country_code&gt;356&lt;/acquirer_institution_country_code&gt;&lt;retrieval_ref_number&gt;117262000055&lt;/retrieval_ref_number&gt;&lt;card_acceptor_id&gt;000000000000125&lt;/card_acceptor_id&gt;&lt;terminal_owner_name&gt;Rahul&lt;/terminal_owner_name&gt;&lt;terminal_city&gt;Udupi&lt;/terminal_city&gt;&lt;terminal_state_code&gt;TN&lt;/terminal_state_code&gt;&lt;terminal_country_code&gt;IN&lt;/terminal_country_code&gt;&lt;merchant_postal_code&gt;576105&lt;/merchant_postal_code&gt;&lt;merchant_telephone&gt;9600057231&lt;/merchant_telephone&gt;&lt;order_id&gt;0000000000000007&lt;/order_id&gt;&lt;custom1&gt;signapp.quatrroprocessingservice.com&lt;/custom1&gt;&lt;custom2&gt;cust2sample&lt;/custom2&gt;&lt;custom3&gt;cust3sample&lt;/custom3&gt;&lt;custom4&gt;cust4sample&lt;/custom4&gt;&lt;custom5&gt;cust5sample&lt;/custom5&gt;&lt;/paysecure&gt;</strXML></mer1:strXML>
                                    </CallPaySecure>
                                    </soapenv:Body>
                                    </soapenv:Envelope>';

    $url = "https://cert.mwsrec.npci.org.in/MWS/MerchantWebService.asmx?WSDL";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $headers = array();
    array_push($headers, "Content-Type: text/xml; charset=utf-8");
    array_push($headers, "Accept: text/xml");
    array_push($headers, "Cache-Control: no-cache");
    array_push($headers, "Pragma: no-cache");
    array_push($headers, "SOAPAction: https://paysecure/merchant.soap/CallPaySecure");
    if($xml != null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
        array_push($headers, "Content-Length: " . strlen($xml));
    }
    curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); /* If required */
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $ressp=str_replace("&lt;","<",$response);
    $ressp=str_replace("&gt;",">",$ressp);

    $aaaaaa= strip_tags($ressp);

    $aaaaaa = preg_replace('/\s+/', ' ', $aaaaaa);

    $name_array = explode(' ', $aaaaaa);
    //echo '<br> status='.$name_array[1];
}
if(($env!="testm" || $env!="livem") && $mycardtype!="Rupay"){
?>
<script type="text/javascript" >
    function accu_FunctionResponse(strResponse){
        switch (strResponse) {
            case 'ACCU000': //Enrollment was completed successfully.
                Acculynk._modalHide();
                break;
            case 'ACCU200': //user pressed 'cancel' button
                Acculynk._modalHide();
                break;
            case 'ACCU400': //user was inactive
                Acculynk._modalHide();
                break;
            case 'ACCU600': //invalid data was posted to PaySecure
                Acculynk._modalHide();
                break;
            case 'ACCU800': //general catch all error
                Acculynk._modalHide();
                break;
            case 'ACCU999': //modal popup was opened successfully
//no action necessary, but open for Issuer to use
                break;
            default:
                break;
        }
        var url=document.getElementById("url").value;
        if(strResponse=="ACCU000")
        {
            $.ajax({
                type:'POST',
                url:'checkAuthorize.php',
                dataType: "json",
                data:{'partner_id':'<?php echo $partner_id; ?>', 'merchant_password':'<?php echo $merchant_password; ?>', 'tran_id':'<?php echo $transsid; ?>', 'auth_amount':'<?php echo $auth_amount; ?>', 'currency_code':'<?php echo $currency_code; ?>', 'Token':'<?php echo $Token; ?>',  'Version':'<?php echo $Version; ?>',  'CallerID':'<?php echo $CallerID; ?>',  'UserID':'<?php echo $UserID; ?>',  'Password':'<?php echo $Password; ?>'},
                success:function(data){
                    var res	=data['res1'];
                    var res2=data['res2'];
                    var res4=data['res4'];
                    var res3=data['res3'];
                    var res1 = res.split(" ");
                    var url=document.getElementById("url").value;
                    var cn=document.getElementById("card_no").value;
                    var mn=document.getElementById("mn").value;
                    var am=document.getElementById("amount").value;
                    ///  alert(res1[1]);
                    // alert(res1[2]);
                    //alert(res1[3]);
                    //alert(res1[4]);
                    //alert(res1[5]);
                    // alert(res1[6]);
                    //alert(res1[7]);
                    if(res2=='tsfailure')
                    {
                        //window.location=url+"?errordesc=Timeout on Transaction status check&success=false&txn="+res3;
                        window.location.assign("fbtestbackground.php?url="+url+"&errordesc=Timeout on Transaction status check&success=false&txn="+res3+"&cn="+cn+"&mn="+mn+"&am="+am);
                        //window.location.assign(url+"?errordesc=Timeout on Transaction status check&success=false&txn="+res3);
                    }
                    else if(res2=='tssuccess')
                    {
                        //window.location=url+"?&success=true&txn="+res1[6]+"errordesc="+res1[3];
                        if(res1[3]=="I"){
                            window.location.assign("fbtestbackground.php?url="+url+"&success=true&txn="+res1[4]+"&errordesc=Transaction status success&cn="+cn+"&mn="+mn+"&am="+am);
                        }
                        else {
                            window.location.assign("fbtestbackground.php?url="+url+"&success=false&txn="+res1[4]+"&errordesc="+res1[3]+"&cn="+cn+"&mn="+mn+"&am="+am);
                        }

                    }
                    else if(res1[1]=='success')
                    {                    				 //window.location=url+"?success=true&txn="+data['res3']+"errordesc="+res1[3];
                        window.location.assign("fbtestbackground.php?url="+url+"&success=true&txn="+data['res3']+"&errordesc="+data['res4']+"&cn="+cn+"&mn="+mn+"&am="+am);
                    }
                    else
                    {
                        window.location.assign("fbtestbackground.php?url="+url+"&success=false&txn="+data['res3']+"&errordesc="+data['res4']+"&cn="+cn+"&mn="+mn+"&am="+am);
                    }
                    //alert(res1[1]);
                }
            });

        }
        else if(strResponse=="ACCU200")
        {
            //alert("workign");
            //alert(cn);
            //window.location.assign("fbtestbackground.php?success=false&trans=cancel&cn="+cn+"&mn="+mn+"&am="+am);
            window.location.assign("responsemerchant.php?url="+url+"&success=false&trans=cancel&errordesc=ACCU200 Error");

        }
        else if(strResponse=="ACCU400")
        {
            //window.location.assign("responsemerchant.php?url="+url+"&success=false&trans=inactive&cn="+cn+"&mn="+mn+"&am="+am);
            <?php $log = date("Y-m-d H:i:sa")."\n\n
-----------------------------------\n\n ACCU400- User was Inactive \n\n";
            $myfile = file_put_contents('merchantapiLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
            ?>
            window.location.assign("responsemerchant.php?url="+url+"&success=false&trans=inactive&errordesc=ACCU400 Error");

        }
        else if(strResponse=="ACCU600")
        {
            //window.location.assign("responsemerchant.php?url="+url+"&success=false&cn="+cn+"&mn="+mn+"&am="+am);

            window.location.assign("responsemerchant.php?url="+url+"&success=false&errordesc=ACCU600 Error");

        }
        else if(strResponse=="ACCU800")
        {
            //window.location.assign("fbtestbackground.php?url="+url+"&success=false&cn="+cn+"&mn="+mn+"&am="+am);

            window.location.assign("responsemerchant.php?url="+url+"&success=false&errordesc=ACCU800 Error");

        }


    }
    $("#LinkButton1").click(function()
    {
        //alert("testtt");
        var url=document.getElementById("url").value;
        window.location.assign(url+"?success=false&txn=null&errordesc=pressed cancel button");
    });
    $("#LinkButton12").click(function()
    {
        //alert("testtt");
        var url=document.getElementById("url").value;
        window.location.assign(url+"?success=false&txn=null&errordesc=pressed cancel button");
    });

    $("#LinkButton13").click(function()
    {
        alert("testtt");
        var url=document.getElementById("url").value;
        window.location.assign(url+"?success=false&txn=null&errordesc=pressed cancel button");
    });
    /*
     window.onbeforeunload = function(event)
     {
     return confirm("Confirm Form Resubmission");
     };

     */
    $(document.body).on("keydown", this, function (event) {
        if (event.keyCode == 116) {
            if(confirm("Confirm Form Resubmission \n\nThe page that you're looking for used information that you entered. Returning to that page might cause any action that you took to be repeated. Do you want to continue?")){
                location.reload();
            }
            else {
                return false;
            }
        }
    });

    history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
    window.addEventListener('popstate', function(event)
    {
        var result = confirm("Are You Sure? This page is asking you to confirm that you want to leave - Transaction will be cancelled.");
        if (result) {
            //Logic to delete the item

            //window.location.assign("responsemerchant.php?success=false&trans=cancel&errordesc=");
            var url=document.getElementById("url").value;
            window.location.assign("rbredirect.php?url="+url);
        }
        //return "Leaving this page will reset the wizard";

    });

</script>
<?php } ?>