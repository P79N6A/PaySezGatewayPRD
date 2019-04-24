<?php 

/**** Alipay TLF Process ****/

error_reporting(0);
$servername = "10.162.104.214";
$username = "pguat";
$password = "pguat";
$dbname   = "suprpaysez";

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

// // Day Basis
// $currentdate = date('Y-m-d 00:00:00',strtotime("-1 days"));
// $sdate=date('Y-m-d 23:59:59',strtotime("-1 days"));

// $l=date('H', strtotime("-1 days"));
// $m=date('i', strtotime("-1 days"));
// $d=date('Ymd', strtotime("-1 days"));
// $fn1=$d.''.$l.$m;
// $fn=$d.''.$l;

$currentdate = "2018-07-01 00:00:00";
$sdate="2018-07-31 23:59:59";

$l=date('H', strtotime($currentdate));
$m=date('i', strtotime($currentdate));
$d=date('Ymd', strtotime($currentdate));
$fn1=$d.''.$l.$m;
$fn=$d.''.$l;

$sql="SELECT * FROM transaction INNER JOIN actions ON transaction.id_transaction_id = actions.id_transaction_id WHERE trans_datetime >= '".$currentdate ."' AND trans_datetime <='".$sdate ."' AND trade_status='TRADE_SUCCESS' AND tlf_flag=0";

$projects = mysqli_query($conn, $sql);

$data = ''; 
$data_Rp = '';

foreach ($projects as $project) {
    $merchant_id = ltrim($project['merchant_id'], '0');
    $merchant_qy = "SELECT * FROM merchants where idmerchants='".$merchant_id."'";
    $merchant_ret= $conn->query($merchant_qy);
    $merchantDet = $merchant_ret->fetch_assoc();

    // echo $project['merchant_id']."=>".$project['id_transaction_id']."=>".$merchant_id."=>".$merchantDet['merchant_name']."<br>";

    $data .= "|ALIPAY||||||||||||||||||||||||||||||||||||||||||||||||||||".$project['id_transaction_id']. "|".$project['merchant_id']. "|".$project['input_charset']. "|".$project['service']. "|".$project['partner']. "|".$project['sign_type']. "|".$project['sign']. "|".$project['notify_url']. "|".$project['timestamp']. "|".$project['terminal_timestamp']. "|".$project['out_trade_no']. "|".$project['subject']. "|".$project['product_code']. "|".$project['total_fee']. "|".$project['seller_id']. "|".$project['seller_email']. "|".$project['body']. "|".$project['show_url']. "|".$project['currency']. "|".$project['trans_currency']. "|".$project['price']. "|".$project['quantity']. "|".$project['goods_detail']. "|".$project['extend_params']. "|".$project['it_b_pay']. "|".$project['passback_parameters']. "|".$project['extra_common_param']. "|".$project['trade_no']. "|".$project['paytools_pay_amount']. "|".$project['buyer_email']. "|".$project['gmt_create']. "|".$project['notify_type']. "|".$project['notify_time']. "|".$project['trade_status']. "|".$project['gmt_payment']. "|".$project['buyer_id']. "|".$project['notify_id']. "|".$project['res_seller_email']. "|".$project['res_price']. "|".$project['res_quantity']. "|".$project['res_seller_id']. "|".$project['res_sign_type']. "|".$project['res_sign']. "|".$project['pre_create_flag']. "|".$project['refund_flag']. "|".$project['refund_id']. "|".$project['cancel_flag']. "|".$project['cancel_id']. "|".$project['trans_date']. "|".$project['trans_time']. "|".$project['trans_datetime']. "|\r\n" ;

    // $data .= "<br>";
    $date_updt=date('Y-m-d H:i:s');
    $transaction_id=$project['id_transaction_id'];
    $sqlupdate="update transaction set tlf_flag=1, tlf_updatedon='".$date_updt."' where id_transaction_id=".$transaction_id;
    // $sqlupdate="update transaction set tlf_flag=0, tlf_updatedon=NULL where id_transaction_id=".$transaction_id;
    mysqli_query($conn, $sqlupdate);
}

alipay_tlf_log($data, $fn, $fn1, $count, mysqli_num_rows($projects)); // /var/www/html/Spaysez/TLF

function alipay_tlf_log($msg, $fn, $fn1, $count, $num) {
    if ($num > 0) {
        $msg = substr($msg, 0, -2);
        $logfile1 = 'TLF/PG_TLF_' . $fn . $count . '.log';
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