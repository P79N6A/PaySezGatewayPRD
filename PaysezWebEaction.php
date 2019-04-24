<?php
date_default_timezone_set('Asia/Kolkata');
header( 'Expires: Sat, 28 Jul 2029 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';

error_reporting(0);
require_once('api/encrypt.php');
require_once('api/baseurl.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

/**** DB Connection ****/
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

$redirectionurl = trim($_POST['redirectionurl']);

// echo "<pre>";
// print_r($_POST);
// echo "<br>";
// exit; 

$secureData = $_POST['amount'].$_POST['card_num'].$_POST['card_cvv'].$_POST['expiry_mm'].$_POST['expiry_yy'];
$secureData_enc = dec_enc('encrypt', $secureData);

// echo $secureData_enc;
// echo "<br>";
// echo $_POST['encData'];
// echo "<br>";
// exit;


$_POST['amount'] = dec_enc('decrypt', $_POST['amount']);

// echo $_POST['amount']; echo "<br>";

// $_POST['amount'] = mc_decrypt($_POST['amount'], $dkey);
$amount = number_format((float)$_POST['amount'], 2, '.', '');

// echo $amount; exit;

// echo "<pre>";
// print_r($_POST);
// echo "<br>";
// echo $amount;
// echo "<br>";
// var_dump($amount);
// exit;

/****Vendor Config****/
if($_POST['vendor'] == "AirPay" || $_POST['vendor'] == "AirPay_TestProd") {
    $merch_id = "E01010000000038";
} else {
    $merch_id = "E01010000000039";
}
$merchant_id = strlen(trim($_POST['merchant_id'])) == 3 ? $merch_id : trim($_POST['merchant_id']);
$vendor_payment_options = "CP";
// $vendor_name = "BillDesk"; // "AirPay"; // "AirPay_TestProd"; // "AirPay"; // "BillDesk";
$db->where("vendor_active_status", 1);
$db->where("vendor_payment_options", $vendor_payment_options);
// $db->where("vendor_name", $vendor_name);
$db->where("pg_merchant_id", $merchant_id);
$vendorDet = $db->getone('vendor_config');

$vendor_id = $vendorDet['vendor_id'];
$vendor_name = $vendorDet['vendor_name'];

/**** Log Paths ****/
$payment_option = $_POST['payment_option'];
if($payment_option == "CardPayment") {
    $log_path = '/var/www/html/testspaysez/api/transactions_CP.log';
}
/**** Log Function ****/
function logwrite($log) {
    GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
}

if($secureData_enc != $_POST['encData']) {
    /**** Log File Write ****/
    $logs = $vendor_name."'s Transaction Validation:".date("Y-m-d H:i:s A") . "\nInvalid Transaction Datas \n\n";
    logwrite($logs);
    header('Location: '.$redirectionurl."&success=false&txn=null&errordesc=Invalid Transaction Datas");
    die('Unauthorized');
}

/**** Airpay Payment Related Part (START) ****/
if($vendor_name == "AirPay") {

    $username = $vendorDet['vendor_username']; // Username
    $password = $vendorDet['vendor_password']; // Password
    $secret   = $vendorDet['vendor_secretkey']; // API key
    $mercid   = $vendorDet['ap_mercid']; //Merchant ID

    $buyerEmail = trim($_POST['buyerEmail']);
    $buyerPhone = trim($_POST['buyerPhone']);
    $buyerFirstName = trim($_POST['buyerFirstName']);
    $buyerLastName = trim($_POST['buyerLastName']);
    $buyerAddress = trim($_POST['buyerAddress']);
    // $amount = number_format((float)$_POST['amount'], 2, '.', ''); // trim($_POST['amount']);
    $buyerCity = trim($_POST['buyerCity']);
    $buyerState = trim($_POST['buyerState']);
    $buyerPinCode = trim($_POST['buyerPinCode']);
    $buyerCountry = trim($_POST['buyerCountry']);

    $bankCode_exp = explode(":", $_POST['emibank']);
    $bankCode     = trim($bankCode_exp[0]);

    $orderid = $mercid.date('YmdHis');

    // ****Airpay Privatekey and Checksum Creation / Validation****
    include('airpay_php/checksum.php');
    include('airpay_php/validation.php');
    $alldata   = $buyerEmail.$buyerFirstName.$buyerLastName.$buyerAddress.$buyerCity.$buyerState.$buyerCountry.$amount.$orderid;
    $privatekey = Checksum::encrypt($username.":|:".$password, $secret);
    $checksum = Checksum::calculateChecksum($alldata.date('Y-m-d'),$privatekey);
    $hiddenmod = "";

    $logs = $vendor_name."'s Transaction Request Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($_POST). " \n\n";
    logwrite($logs);

    $post_array = [];
    $post_array['buyerEmail']     = trim($_POST['buyerEmail']);
    $post_array['buyerPhone']     = trim($_POST['buyerPhone']);
    $post_array['buyerFirstName'] = trim($_POST['buyerFirstName']);
    $post_array['buyerLastName']  = trim($_POST['buyerLastName']);
    $post_array['buyerAddress']   = trim($_POST['buyerAddress']);
    $post_array['buyerCity']      = trim($_POST['buyerCity']);
    $post_array['buyerState']     = trim($_POST['buyerState']);
    $post_array['buyerCountry']   = trim($_POST['buyerCountry']);
    $post_array['buyerPinCode']   = trim($_POST['buyerPinCode']);
    $post_array['amount']         = $amount; // trim($_POST['amount']);
    $post_array['customvar']      = trim($_POST['customvar']);
    $post_array['txnsubtype']     = trim($_POST['txnsubtype']);

    if($_POST['payment_option'] == "CardPayment") {
        $post_array['channel']    = trim($_POST['channel']);
        $post_array['bankCode']   = $bankCode; // trim($_POST['emibank']);
        $post_array['card_num']   = trim($_POST['card_num']);
        $post_array['expiry_mm']  = trim($_POST['expiry_mm']);
        $post_array['expiry_yy']  = trim($_POST['expiry_yy']);
        $post_array['card_cvv']   = trim($_POST['card_cvv']);
        $post_array['token']      = $hiddenmod;

        if($_POST['emi_option'] == 1) {
            $post_array['emitenure']   = trim($_POST['emitenure']);
            $emi_content = "with ".trim($_POST['emitenure'])." Months EMI";
        } else {
            $emi_content = '';
        }
    }

    $post_array['privatekey']  = $privatekey;
    $post_array['mercid']      = $mercid;
    $post_array['orderid']     = $orderid;
    $post_array['currency']    = trim($_POST['currency']);
    $post_array['isocurrency'] = trim($_POST['isocurrency']);
    $post_array['chmod']       = $hiddenmod;

    $post_array['checksum']    = $checksum;

    // echo "<pre>";
    // print_r($_POST);
    // echo "<br>"; exit;

    $logs = "Airpay ".$payment_option." ".$emi_content." Request Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($post_array). " \n\n";
    logwrite($logs);

    $data = Array (
        "merchant_id" => $merchant_id, // this should be ID of account using our gateway service
        "transaction_id" => trim($_POST['Transaction_id']),
        "transaction_type" => trim($_POST['TransactionType']),
        "first_name" => trim($_POST['buyerFirstName']),
        "last_name" => trim($_POST['buyerLastName']),
        "address1" => trim($_POST['buyerAddress']),
        "address2" => trim($_POST['buyerAddress']),
        "city" => trim($_POST['buyerCity']),
        "us_state" => trim($_POST['buyerState']),
        "postal_code" => trim($_POST['buyerPincode']),
        "country" => trim($_POST['buyerCountry']),
        "email" => trim($_POST['buyerEmail']),
        "phone" => trim($_POST['buyerPhone']),
        "cc_number" => mc_encrypt(trim($_POST['card_num']), $ENCRYPTION_KEY),
        "cc_exp"    => mc_encrypt(trim($_POST['expiry_yy']).trim($_POST['expiry_mm']), $ENCRYPTION_KEY),
        "cavv_result" => trim($_POST['card_cvv']),
        //"cavv" => mc_encrypt($_POST['cavv'], $ENCRYPTION_KEY), //encrypt this cvv also  with cc_hash
        "currency" => trim($_POST['currency']),
        "environment" => trim($_POST['env']),
        "amount" => $amount,
        "trans_date_time" => date('Y-m-d H:i:s'),
        "localtrans_time" => date('H:i:s'),
        "localtrans_date" => date('Y-m-d'),

        "ponumber"  => $orderid,
        // "bank_code" => trim($_POST['emibank']),
        "bank_code" => $bankCode,
        "mdf_1"     => trim($_POST['channel']),
        "mdf_2"     => $checksum,
        "mdf_3"     => $mercid,
        "mdf_4"     => $privatekey,
        "mdf_5"     => trim($_POST['emitenure']),
        "mdf_11"     => $vendor_id,
        "r_url"     => trim($_POST['redirectionurl']),

        "tax"       => trim($_POST['tax']),
        "network"   => trim($_POST['tax']),
        "cc_type"   => trim($_POST['tax'])
    );

    // "tax" => $_POST['tax'],
    // "network" => 
    // "cc_type" => getCCType($_POST['cc_number'])
    // "orginal_transaction_id" => 

    //echo getCCType($_POST['cc_number']);
    //exit;

    $logs = "Airpay ".$payment_option." Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transactions', $data);

    $hashdata=array(
        "t_id" => $id_transaction_id, //transactionid
        "hash_value" => mc_encrypt($ENCRYPTION_KEY, $Ndkey) //create encryption here
        // "hash_value" => $ENCRYPTION_KEY //create encryption here
    );
    $db->insert('hash_tab', $hashdata);

    // echo "<pre>";
    // print_r($_POST);
    // echo "<br>"; exit;

    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3./org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Airpay</title>
    <script type="text/javascript">
    function submitForm(){
        var form = document.forms[0];
        form.submit();
    }
    </script>
    </head>
    <body onload="javascript:submitForm();">
    <center>
    <table width="500px;">
        <tr>
            <td align="center" valign="middle">Do Not Refresh or Press Back <br/> Redirecting to Airpay</td>
        </tr>
        <tr>
            <td align="center" valign="middle">
                <form action="https://payments.airpay.co.in/pay/directindexapi.php" method="post">
                <?php
                Checksum::outputForm_create($post_array);
                ?>
                </form>
            </td>
        </tr>
    </table>

    </center>
    </body>
    </html>
    <?php
    exit;
}
/**** Airpay Payment Related Part (END) ****/

/**** BillDesk Payment Related Part (START) ****/
if($vendor_name == "BillDesk") {

    $Security_ID  = $vendorDet['vendor_password']; // Security_ID
    $Checksum_key = $vendorDet['vendor_secretkey']; // Checksum Key
    $MerchantID   = $vendorDet['ap_mercid']; // App Merchant ID

    $CustomerID = $merchant_id.date("YmdHis"); // trim($_POST['Transaction_id']);
    $Filler1    = 'NA';
    $TxnAmount  = $amount; 
    // number_format((float)$_POST['amount'], 2, '.', ''); // trim($_POST['amount']); // '1.00'; // '10.00';

    $orderid = $MerchantID.date('YmdHis');

    $bankCode_exp = explode(":", $_POST['emibank']);
    $bankCode     = trim($bankCode_exp[0]);

    $api_url = "https://pgi.billdesk.com/pgidsk/PGICommonGateway";

    /**** For Credit Card ****/
    if($_POST['emi_option'] == "1") {
        $BankID  = 'CARD';    // If Card Payment with EMI BankID is "CARD"
        $ItemCode = $bankCode; // 'KTK3EMI';// If Card Payment with EMI ItemCode is "KTK3EMI"
    } else {
        $BankID  = 'CIT';     // If Card Payment BankID is "CIT"
        $ItemCode = 'DIRECT'; // If Card Payment ItemCode is "DIRECT"
    }

    // echo $ItemCode.'=>'.$bankCode; exit;

    $cnumber = $_POST['card_num'];
    $expmon  = $_POST['expiry_mm'];
    $expyr   = '20'.$_POST['expiry_yy'];
    $cvv2    = $_POST['card_cvv'];
    $cardType= 'NA';
    $cname2  = $_POST['nameoncard'];

    $Filler2 = 'NA';
    $Filler3 = 'NA';
    $CurrencyType = trim($_POST['isocurrency']); // 'INR';
    
    $TypeField1 = 'R';
    $SecurityID = $Security_ID; //'NG-NA';
    $Filler4 = 'NA';
    $Filler5 = 'NA';
    $TypeField2 = 'F';
    $AdditionalInfo1 = 'AA12345';
    $AdditionalInfo2 = 'John@example.com';
    $AdditionalInfo3 = '9999955555';
    $AdditionalInfo4 = 'NA';
    $AdditionalInfo5 = 'NA';
    $AdditionalInfo6 = 'NA';
    $AdditionalInfo7 = 'NA';
    $RU = 'https://paymentgateway.test.credopay.in/testspaysez/responsefrombdk.php';

    $str = $MerchantID."|".$CustomerID."|".$Filler1."|".$TxnAmount."|".$BankID."|".$Filler2."|".$Filler3."|".$CurrencyType."|".$ItemCode."|".$TypeField1."|".$SecurityID."|".$Filler4."|".$Filler5."|".$TypeField2."|".$AdditionalInfo1."|".$AdditionalInfo2."|".$AdditionalInfo3."|".$AdditionalInfo4."|".$AdditionalInfo5."|".$AdditionalInfo6."|".$AdditionalInfo7."|".$RU;

    $logs = $vendor_name."'s Transaction Request Data:".date("Y-m-d H:i:s") . "\n" .$str. " \n\n";
    logwrite($logs);

    $checksum_key = $Checksum_key;

    $checksum = hash_hmac('sha256',$str,$checksum_key, false);
    $checksum = strtoupper($checksum);

    $msg = $str."|".$checksum;

    $logs = $vendor_name."'s Transaction Request Data with Checksum:".date("Y-m-d H:i:s") . "\n" .$msg. " \n\n";
    logwrite($logs);

    $request_array = [
        "msg" => $msg,

        "cnumber"  => $cnumber,
        "expmon"   => $expmon,
        "expyr"    => $expyr,
        "cvv2"     => $cvv2,
        "cardType" => $cardType,
        "cname2"   => $cname2,

        "hidOperation" => "ME100",
        "hidRequestId" => "PGIME1000",
        "reqid" => "cc_processall"
    ];

    $request_array_log = [
        "msg" => $msg,

        "cnumber" => substr_replace($cnumber, str_repeat("X", 8), 4, 12),
        "expmon" => $expmon,
        "expyr" => $expyr,
        "cvv2" => substr_replace($cvv2, str_repeat("X", 3), 0, 3),
        "cardType" => $cardType,
        "cname2" => $cname2,

        "hidOperation" => "ME100",
        "hidRequestId" => "PGIME1000",
        "reqid" => "cc_processall"
    ];

    $logs = $vendor_name." Transaction Request Data to API:".date("Y-m-d H:i:s A") . "\n" .json_encode($request_array_log). " \n\n";
    logwrite($logs);

    /**** 
    trim($_POST['merchant_id']) => this should be ID of account using our gateway service
    trim($CustomerID) => trim($_POST['Transaction_id']),
    $BankID => trim($_POST['emibank'])
    ****/

    $data = Array (
        "merchant_id" => $merchant_id,
        "transaction_id" => trim($CustomerID),
        "transaction_type" => trim($_POST['TransactionType']),
        "first_name" => trim($_POST['buyerFirstName']),
        "last_name" => trim($_POST['buyerLastName']),
        "address1" => trim($_POST['buyerAddress']),
        "address2" => trim($_POST['buyerAddress']),
        "city" => trim($_POST['buyerCity']),
        "us_state" => trim($_POST['buyerState']),
        "postal_code" => trim($_POST['buyerPincode']),
        "country" => trim($_POST['buyerCountry']),
        "email" => trim($_POST['buyerEmail']),
        "phone" => trim($_POST['buyerPhone']),
        "cc_number" => mc_encrypt(trim($_POST['card_num']), $ENCRYPTION_KEY),
        "cc_exp"    => mc_encrypt(trim($_POST['expiry_yy']).trim($_POST['expiry_mm']), $ENCRYPTION_KEY),
        "cavv_result" => trim($_POST['card_cvv']),
        //"cavv" => mc_encrypt($_POST['cavv'], $ENCRYPTION_KEY), //encrypt this cvv also  with cc_hash
        "currency" => trim($_POST['currency']),
        "environment" => trim($_POST['env']),
        "amount" => $amount,
        "trans_date_time" => date('Y-m-d H:i:s'),
        "localtrans_time" => date('H:i:s'),
        "localtrans_date" => date('Y-m-d'),

        "ponumber"  => $orderid,
        "bank_code" => $BankID,
        "mdf_1"     => trim($_POST['channel']),
        "mdf_2"     => $checksum,
        "mdf_3"     => $MerchantID,
        "mdf_4"     => $checksum_key,
        "mdf_11"     => $vendor_id,
        "r_url"     => trim($_POST['redirectionurl']),

        "tax"       => trim($_POST['tax']),
        "network"   => trim($_POST['tax']),
        "cc_type"   => trim($_POST['tax'])
    );

    // "mdf_5"     => trim($_POST['emitenure']),

    $logs = $vendor_name."'s ".$payment_option." Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transactions', $data);

    $hashdata=array(
        "t_id" => $id_transaction_id, //transactionid
        "hash_value" => mc_encrypt($ENCRYPTION_KEY, $Ndkey) //create encryption here
        // "hash_value" => $ENCRYPTION_KEY //create encryption here
    );
    $db->insert('hash_tab', $hashdata);

    /**** BillDesk Pay API URL ****/
    $Pay_api_url = $api_url; // "https://pgi.billdesk.com/pgidsk/PGIMerchantRequestHandler?";
    $logs = $vendor_name."'s ".$payment_option." Request API URL :".date("Y-m-d H:i:s A") . "\n" .$Pay_api_url. " \n\n";
    logwrite($logs);

    function outputForm($postarray) {
        foreach($postarray as $key => $value) {
            echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />'."\n";
        }
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3./org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BillDesk</title>
    <script type="text/javascript">
    function submitForm(){
        // alert("Hiiii");
        var form = document.forms[0];
        form.submit();
    }
    </script>
    </head>
    <body onload="javascript:submitForm();">
    <center>
    <table width="500px;">
        <tr>
            <td align="center" valign="middle">Do Not Refresh or Press Back <br/> Redirecting to BillDesk</td>
        </tr>
        <tr>
            <td align="center" valign="middle">
                <form action="<?php echo $Pay_api_url; ?>" method="GET">
                <?php outputForm($request_array); ?>
                </form>
            </td>
        </tr>
    </table>

    </center>
    </body>
    </html>
    <?php
    exit;
}
/**** BillDesk Payment Related Part (END) ****/
?>