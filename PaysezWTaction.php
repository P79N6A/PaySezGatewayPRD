<?php
date_default_timezone_set('Asia/Kolkata');
header( 'Expires: Sat, 26 Jul 2019 05:00:00 GMT' );
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

/****DB Connection****/
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

$redirectionurl = trim($_POST['redirectionurl']);

// echo "<pre>";
// print_r($_POST);
// echo "<br>";

$secureData = $_POST['amount'].$_POST['prepaid_radio'];
$secureData_enc = dec_enc('encrypt', $secureData);

// echo $secureData_enc;
// echo "<br>";
// echo $_POST['encData'];
// echo "<br>";
// exit;

$_POST['amount'] = dec_enc('decrypt', $_POST['amount']);
$amount = number_format((float)$_POST['amount'], 2, '.', '');

// echo $amount;
// echo "<br>";

/****Vendor Config****/
if($_POST['vendor'] == "AirPay" || $_POST['vendor'] == "AirPay_TestProd") {
    $merch_id = "E01010000000038";
} else {
    $merch_id = "E01010000000039";
}
$merchant_id = strlen(trim($_POST['merchant_id'])) == 3 ? $merch_id : trim($_POST['merchant_id']);
$vendor_payment_options = "WT";
// $vendor_name = "BillDesk"; // "AirPay_TestProd"; // "AirPay"; // "BillDesk";
$db->where("vendor_active_status", 1);
$db->where("vendor_payment_options", $vendor_payment_options);
// $db->where("vendor_name", $vendor_name);
$db->where("pg_merchant_id", $merchant_id);
$vendorDet = $db->getone('vendor_config');

$vendor_id = $vendorDet['vendor_id'];
$vendor_name = $vendorDet['vendor_name'];

/****Log Paths****/
$payment_option = $_POST['payment_option'];
if($payment_option == "Wallets") {
    $log_path = '/var/www/html/testspaysez/api/transactions_WT.log';
}
/****Log Function****/
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
    // $amount = trim($_POST['amount']);
    $buyerCity = trim($_POST['buyerCity']);
    $buyerState = trim($_POST['buyerState']);
    $buyerPinCode = trim($_POST['buyerPinCode']);
    $buyerCountry = trim($_POST['buyerCountry']);

    $orderid = $mercid.date('YmdHis');

    /****Airpay Privatekey and Checksum Creation with Validation****/
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

    if($_POST['payment_option'] == "NetBanking") {
        $post_array['channel']        = trim($_POST['channel']);
        $post_array['bankCode']       = trim($_POST['bankCode']);
    }
    if($_POST['payment_option'] == "Wallets") { 
        $post_array['channel']        = trim($_POST['channel']);
        $post_array['prepaid_radio']  = trim($_POST['prepaid_radio']); 
    }

    $post_array['privatekey']  = $privatekey;
    $post_array['mercid']      = $mercid;
    $post_array['orderid']     = $orderid;
    $post_array['currency']    = trim($_POST['currency']);
    $post_array['isocurrency'] = trim($_POST['isocurrency']);
    $post_array['chmod']       = $hiddenmod;

    $post_array['checksum']    = $checksum;

    $logs = $vendor_name."'s ".$payment_option." Request Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($post_array). " \n\n";
    logwrite($logs);

    // $amount; // trim($_POST['amount'])

    $data = Array(
      "env" => trim($_POST['env']),
      "merchant_id" => $merchant_id,
      "WT_amount" => $amount,
      "WT_buyerAddress" => trim($_POST['buyerAddress']),
      "WT_buyerCity" => trim($_POST['buyerCity']),
      "WT_buyerCountry" => trim($_POST['buyerCountry']),
      "WT_buyerEmail" => trim($_POST['buyerEmail']),
      "WT_buyerFirstName" => trim($_POST['buyerFirstName']),
      "WT_buyerLastName" => trim($_POST['buyerLastName']),
      "WT_buyerPhone" => trim($_POST['buyerPhone']),
      "WT_buyerPincode" => trim($_POST['buyerPincode']),
      "WT_buyerState" => trim($_POST['buyerState']),
      "WT_channel" => trim($_POST['channel']),
      "WT_checksum" => $checksum,
      "WT_chmod" => $hiddenmod,
      "WT_currency" => trim($_POST['currency']),
      "WT_customvar" => trim($_POST['customvar']),
      "WT_isocurrency" => trim($_POST['isocurrency']),
      "WT_mercid" => $mercid,
      "WT_orderid" => $orderid,
      "WT_prepaid_radio" => trim($_POST['prepaid_radio']),
      "WT_privatekey" => $privatekey,
      "WT_transactionid" => trim($_POST['Transaction_id']),
      "gmt_datetime" => gmdate('Y-m-d H:i:s'),
      "mer_callback_url" => trim($_POST['redirectionurl']),
      "timestamp" => trim($_POST['timestamp']),
      "trans_date" => date('Y-m-d', strtotime(trim($_POST['timestamp']))),
      "trans_datetime" => date('Y-m-d H:i:s', strtotime(trim($_POST['timestamp']))),
      "trans_time" => date('H:i:s', strtotime(trim($_POST['timestamp']))),
      "transaction_type" => trim($_POST['TransactionType']),
      "transaction_vendor" => trim($vendor_id),
      "txnsubtype" => trim($_POST['txnsubtype'])
    );

    $logs = $vendor_name."'s ".$payment_option." Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transaction_airpay_wallet', $data);
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

    $CustomerID = $merchant_id.date("YmdHis");
    $Filler1    = 'NA';
    $TxnAmount  = $amount; // trim($_POST['amount']); // '1.00'; // '10.00';

    $orderid = $MerchantID.date('YmdHis');

    /**** For Wallets => DCB Chippy - DCW ****/
    $api_url = "https://pgi.billdesk.com/pgidsk/PGIMerchantRequestHandler?";
    $BankID  = $_POST['prepaid_radio']; // 'DCW';

    $Filler2 = 'NA';
    $Filler3 = 'NA';
    $CurrencyType = trim($_POST['isocurrency']); // 'INR';
    $ItemCode = 'DIRECT';
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

    $logs = $vendor_name."'s ".$payment_option." Request Data:".date("Y-m-d H:i:s A") . "\n" .$str. " \n\n";
    logwrite($logs);

    $checksum_key = $Checksum_key;

    $checksum = hash_hmac('sha256',$str,$checksum_key, false);
    $checksum = strtoupper($checksum);

    $msg = $str."|".$checksum;

    $logs = $vendor_name."'s ".$payment_option." Request Data with its Checksum:".date("Y-m-d H:i:s") . "\n" .$msg. " \n\n";
    logwrite($logs);

    $request_array = [
        "msg" => $msg,
        "hidOperation" => "ME100",
        "hidRequestId" => "PGIME1000",
        "reqid" => "cc_processall"
    ];

    $logs = $vendor_name."'s ".$payment_option." Transaction Request Data to API".date("Y-m-d H:i:s") . "\n" .json_encode($request_array). " \n\n";
    logwrite($logs);

    $data = Array(
      "env" => trim($_POST['env']),
      "merchant_id" => $merchant_id,
      "WT_amount" => $amount,
      "WT_buyerAddress" => trim($_POST['buyerAddress']),
      "WT_buyerCity" => trim($_POST['buyerCity']),
      "WT_buyerCountry" => trim($_POST['buyerCountry']),
      "WT_buyerEmail" => trim($_POST['buyerEmail']),
      "WT_buyerFirstName" => trim($_POST['buyerFirstName']),
      "WT_buyerLastName" => trim($_POST['buyerLastName']),
      "WT_buyerPhone" => trim($_POST['buyerPhone']),
      "WT_buyerPincode" => trim($_POST['buyerPincode']),
      "WT_buyerState" => trim($_POST['buyerState']),
      "WT_channel" => trim($_POST['channel']),
      "WT_checksum" => $checksum,
      "WT_chmod" => "",
      "WT_currency" => trim($_POST['currency']),
      "WT_customvar" => "",
      "WT_isocurrency" => trim($_POST['isocurrency']),
      "WT_mercid" => $MerchantID,
      "WT_orderid" => $orderid,
      "WT_prepaid_radio" => $BankID,
      "WT_privatekey" => $Checksum_key,
      "WT_transactionid" => trim($CustomerID),
      "gmt_datetime" => gmdate('Y-m-d H:i:s'),
      "mer_callback_url" => trim($_POST['redirectionurl']),
      "timestamp" => trim($_POST['timestamp']),
      "trans_date" => date('Y-m-d', strtotime(trim($_POST['timestamp']))),
      "trans_datetime" => date('Y-m-d H:i:s', strtotime(trim($_POST['timestamp']))),
      "trans_time" => date('H:i:s', strtotime(trim($_POST['timestamp']))),
      "transaction_type" => trim($_POST['TransactionType']),
      "transaction_vendor" => trim($vendor_id),
      "txnsubtype" => ""
    );

    $logs = $vendor_name."'s ".$payment_option." Request Insert Data:".date("Y-m-d H:i:s A") . "\n" .json_encode($data). " \n\n";
    logwrite($logs);

    $id_transaction_id = $db->insert('transaction_airpay_wallet', $data);

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