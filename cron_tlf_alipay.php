<?php 

/**** Alipay TLF Process ****/

error_reporting(0);
$servername = "10.162.104.214";
$username = "pguat";
$password = "pguat";
$dbname   = "testSpaysez";
//$dbname   = "suprpaysez";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  

// added count code 
$fp = fopen("counterlog.txt", "r");
$count = fread($fp, 1024);
fclose($fp); 		
$count = $count + 1; 
$count= sprintf('%02d', $count);
// echo "<p>Page views:" . $count . "</p>"; 

date_default_timezone_set("Asia/kolkata");

// // Hourly Basis
// $currentdate = date('Y-m-d H:00:00',strtotime("-1 days"));
// $sdate=date('Y-m-d H:59:59',strtotime("-1 days"));

// Day Basis
// $currentdate = date('Y-m-d 00:00:00',strtotime("-1 days"));
// $sdate=date('Y-m-d 23:59:59',strtotime("-1 days"));

// $l=date('H', strtotime("-1 days"));
// $m=date('i', strtotime("-1 days"));
// $d=date('Ymd', strtotime("-1 days"));
// $fn1=$d.''.$l.$m;
// $fn=$d.''.$l;

$currentdate = "2018-11-28 00:00:00";
$sdate="2018-11-28 23:59:59";

$l=date('H', strtotime($currentdate));
$m=date('i', strtotime($currentdate));
$d=date('Ymd', strtotime($currentdate));
$fn1=$d.''.$l.$m;
$fn=$d.''.$l;

$data = ''; 
$data_Rp = '';

/**** China Time Conversion ****/
// $given_datetime = $project['trans_datetime'];
// $given = new DateTime($given_datetime);
// $given->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
// $updated_datetime = $given->format("Y-m-d H:i:s");
// $updated_time = $given->format("H:i:s");

/**** Payment Success ****/
$sql_payment="SELECT * FROM transaction_alipay WHERE transaction_type IN ('1','s1') AND cst_trans_datetime >= '".$currentdate ."' AND cst_trans_datetime <='".$sdate ."' AND result_code='SUCCESS' AND trade_status='TRADE_SUCCESS' AND tlf_flag=0";
$payment_projects = mysqli_query($conn, $sql_payment);
if(is_object($payment_projects)) {
    foreach ($payment_projects as $project) {

        $data .= "||||||".$project['buyer_email']. "|".$project['buyer_id']. "|".$project['currency']. "||||||".$project['extra_common_param']. "||".$project['gmt_create']. "|".$project['gmt_payment']. "|||||||".$project['merchant_id']. "|ALIPAY||".$project['notify_id']. "|".$project['notify_time']. "|".$project['notify_type']. "|||".$project['out_trade_no']. "|".$project['partner']. "||||".$project['paytools_pay_amount']. "|".$project['price']. "|".$project['product_code']. "|".$project['quantity']."|||||||||".$project['result_code']. "||".$project['seller_email']. "|".$project['seller_id']. "||".$project['subject']. "|".$project['terminal_id']. "|||".$project['total_fee']. "|".$project['trade_no']. "|".$project['trade_status']. "|".$project['trans_amount_cny']."|".$project['trans_amount']."|".$project['trans_currency']."||".$project['trans_datetime']. "|".$project['trans_time']. "|".$project['transaction_type']. "||\r\n";

        // $date_updt=date('Y-m-d H:i:s');
        // $transaction_id=$project['id_transaction_id'];
        // $sqlupdate="update transaction set tlf_flag=1, tlf_updatedon='".$date_updt."' where id_transaction_id=".$transaction_id;
        // mysqli_query($conn, $sqlupdate);
    }
}

/**** Payment Cancel ****/
$sql_payment_cancel="SELECT * FROM transaction_alipay WHERE transaction_type IN ('4','s4') AND cst_trans_datetime >= '".$currentdate ."' AND cst_trans_datetime <='".$sdate ."' AND result_code='SUCCESS' AND tlf_flag=0";
$payment_projects_cancel = mysqli_query($conn, $sql_payment_cancel);
if(is_object($payment_projects_cancel)) {
    foreach ($payment_projects_cancel as $project) {

        $data .= $project['action']."||||||||".$project['currency']. "||||||||||||||||".$project['merchant_id']."|ALIPAY|||||||".$project['out_trade_no']. "|".$project['partner']. "||||||||||||||||".$project['result_code']. "|".$project['retry_flag']. "|||||".$project['terminal_id']."||||".$project['trade_no']."|".$project['trade_status']. "|".$project['trans_amount_cny']."|".$project['trans_amount']."|".$project['trans_currency']."||".$project['trans_datetime']. "|".$project['trans_time']. "|".$project['transaction_type']. "||\r\n";

        // $date_updt=date('Y-m-d H:i:s');
        // $transaction_id=$project['id_transaction_id'];
        // $sqlupdate="update transaction set tlf_flag=1, tlf_updatedon='".$date_updt."' where id_transaction_id=".$transaction_id;
        // mysqli_query($conn, $sqlupdate);
    }
}

/**** Payment Refund ****/
$sql_payment_refund="SELECT * FROM transaction_alipay WHERE transaction_type IN ('2','s2') AND cst_trans_datetime >= '".$currentdate ."' AND cst_trans_datetime <='".$sdate ."' AND result_code='SUCCESS' AND tlf_flag=0";
$payment_projects_refund = mysqli_query($conn, $sql_payment_refund);
if(is_object($payment_projects_refund)) {
    foreach ($payment_projects_refund as $project) {

        $data .= "||||".$project['alipay_trans_id']."||||".$project['currency']."||||".$project['exchange_rate']."||||||||||||".$project['merchant_id']. "|ALIPAY|||||||||".$project['partner_refund_id']. "|".$project['partner_trans_id']. "||||||".$project['refund_amount_cny']. "|".$project['refund_amount']. "|||||||".$project['result_code']. "||||||".$project['terminal_id']."|||||||".$project['trans_currency']."||".$project['trans_datetime']. "|".$project['trans_time']. "|".$project['transaction_type']. "||\r\n";

        // $date_updt=date('Y-m-d H:i:s');
        // $transaction_id=$project['id_transaction_id'];
        // $sqlupdate="update transaction set tlf_flag=1, tlf_updatedon='".$date_updt."' where id_transaction_id=".$transaction_id;
        // mysqli_query($conn, $sqlupdate);
    }
}

// echo $data;
// exit;
// die();

// $numRows = mysqli_num_rows($payment_projects); 
$numRows = mysqli_num_rows($payment_projects) + mysqli_num_rows($payment_projects_cancel) + mysqli_num_rows($payment_projects_refund);

alipay_tlf_log($data, $fn, $fn1, $count, $numRows); // /var/www/html/Spaysez/TLF

function alipay_tlf_log($msg, $fn, $fn1, $count, $num) {
    if ($num > 0) {
        $msg = substr($msg, 0, -2);
        // $logfile1 = 'TLF/PG_ALIPAY_TLF_' . $fn . $count . '.log';
        $logfile1 = '/var/www/html/testspaysez/api/tlflog/tlftemp1/PG_ALIPAY_TLF_' . $fn . $count . '.log';
        if($msg != "") {
            $fp = fopen("counterlog.txt", "w");
            fwrite($fp, $count);
            fclose($fp);
            file_put_contents($logfile1, $msg, FILE_APPEND);
        }
        
        //end of count code
        if ($count == "24") {
            file_put_contents("counterlog.txt", "");

            echo "successfully generated";
        }
    }
}

// echo $data;
// exit;


?>