<?php 
error_reporting(0);

require_once('../../php/MysqliDb.php');
require '../../kint/Kint.class.php';

$duser="KjQu4XDzpx6tbqhFGPUdfQaEUR/SjtQoiD9IHdx5H6qPa8O/jEUMjZL4s2bhtsa4qrbqb+UfIzUUPMOK2oFhP7JtN+6hwPGToyz1yuAoj83HbpwVfP+Z9SoUJqiJMA4J|ns24jfQxfvFyt2ac9jX0jCmWDkD8ik2dGYI6pboJ+kU=";
$dcode="lkevacQaV6VckdEVKbAANqnxRfwspv6618DtG3D399dJST9ut/impGbyNP4mrqn4TB45yOmBdydBt1DR4FfsQd13T4LX5Wtprv4ADcPMZB/c7uDHY8WH2OMhGeH+hoyf|NinFqSYPFzRAARrSUMg5FwF5WjrjKNWMFVNrChgrWPM=";
//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$dkey="ccb5154d0fd67524f5aa6dc9dd388806022bd0c50831e10e9fef2e567b31ba76";
require_once('../encrypt.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$servername = "10.162.104.214";
$username = $userd;
$password = $passd;
$dbname = "suprpaysez";

// echo $userd."=>".$passd;
// exit;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// $conn = mysqli_connect($servername, $username, $password, $dbname);
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

$currentdate = date('Y-m-d H:00:00',strtotime("-1 hours"));
$sdate=date('Y-m-d H:59:59',strtotime("-1 hours"));

// $currentdate = date('2018-07-05 00:00:00');
// $sdate = date('2018-07-13 23:59:59');

//$f=date('H_00', strtotime("-1 hours"));
$l=date('H', strtotime("-1 hours"));
$m=date('i', strtotime("-1 hours"));
$d=date('Ymd', strtotime("-1 hours"));
$fn1=$d.''.$l.$m;
$fn=$d.''.$l;

//$currentdate = date('2017-11-18 01:00:00');
//$sdate=date('2017-11-18 23:59:00');

//$sql = "SELECT * FROM transactions";
//$sql = "SELECT * FROM transactions where shipping_date BETWEEN '".$currentdate ."' AND '".$sdate ."'";
//$sql="SELECT * FROM transactions INNER JOIN actions ON transactions.id_transaction_id = actions.id_transaction_id where server_datetime_trans >= '".$currentdate ."' AND server_datetime_trans <='".$sdate ."' AND error_code='00' AND tlf_flag=0";

$sql="SELECT * FROM transaction  where trans_datetime >= '".$currentdate ."' AND trans_datetime <='".$sdate ."' AND trade_status='TRADE_SUCCESS' AND tlf_flag=0";

// $sql="SELECT * FROM transaction INNER JOIN actions ON transaction.id_transaction_id = actions.id_transaction_id LEFT JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id=transaction.merchant_id where transaction.trans_datetime >= '".$currentdate ."' AND transaction.trans_datetime <= '".$sdate ."' AND transaction.trade_status='TRADE_SUCCESS' AND transaction.tlf_flag=0";

$projects = mysqli_query($conn, $sql);

// print_r($projects);

// exit;

foreach ($projects as $project)
	{
	$sqlresp = "SELECT * FROM merchants where mer_map_id='".$project['mer_map_id']."'";
	$eresp=$conn->query($sqlresp);
	$t=$eresp->fetch_assoc();
	
	//hash get
	$sqlresphash = "SELECT * FROM hash_tab where t_id='".$project['id_transaction_id']."'";
	$eresphash=$conn->query($sqlresphash);
	$thash=$eresphash->fetch_assoc();
	
	// if($project['error_code']=="00"){
	if($project['trade_status'] == "TRADE_SUCCESS") {

		$data = $data."|" . $project['network']. "||||||||||||||||||||||||||||||||||||||||||||||||||||".$project['id_transaction_id']."|".$project['merchant_id']."|".$project['input_charset']."|".$project['service']."|".$project['partner']."|".$project['sign_type']."|".$project['sign']."|".$project['notify_url']."|".$project['timestamp']."|".$project['terminal_timestamp']."|".$project['out_trade_no']."|".$project['subject']."|".$project['product_code']."|".$project['total_fee']."|".$project['seller_id']."|".$project['seller_email']."|".$project['body']."|".$project['show_url']."|".$project['currency']."|".$project['trans_currency']."|".$project['price']."|".$project['quantity']."|".$project['goods_detail']."|".$project['extend_params']."|".$project['it_b_pay']."|".$project['passback_parameters']."|".$project['extra_common_param']."|".$project['trade_no']."|".$project['paytools_pay_amount']."|".$project['buyer_email']."|".$project['gmt_create']."|".$project['notify_type']."|".$project['notify_time']."|".$project['trade_status']."|".$project['gmt_payment']."|".$project['buyer_id']."|".$project['notify_id']."|".$project['res_seller_email']."|".$project['res_price']."|".$project['res_quantity']."|".$project['res_seller_id']."|".$project['res_sign_type']."|".$project['res_sign']."|".$project['pre_create_flag']."|".$project['refund_flag']."|".$project['refund_id']."|".$project['cancel_flag']."|".$project['cancel_id']."|".$project['trans_date']."|".$project['trans_time']."|".$project['trans_datetime']."|\r\n" ;
	}
	$datup=date('Y-m-d H:i:s');
	$tidup=$project['id_transaction_id'];
	$sqlup="update transaction set tlf_flag=1, tlf_updatedon='".$datup."' where id_transaction_id=".$tidup;

	mysqli_query($conn, $sqlup);
	}

wh_log($data, $data4, $data2, $data3, $fn, $fn1, $count, mysqli_num_rows($projects));
//echo "Log Generated Successfully!.";
function wh_log($msg, $msg4, $msg2, $msg3, $fn, $fn1, $count, $nov)
{
    if ($nov > 0) {
        $msg = substr($msg, 0, -2);
        $msg2 = substr($msg2, 0, -2);
        $logfile1 = 'tlftemp1/PG_TLF_' . $fn . $count . '.log';
        $logfile2 = 'tlftemp2/PG_MERTXNS_' . $fn1 . '.log';
        //$logfile3='PG_TLF_'.$fn. '.log';

        $logfile4 = 'tlf_reports/PG_TLF_' . $fn . $count . 'REPORT.log';
        $logfile5 = 'tlf_reports/PG_MERTXNS_' . $fn1 . 'REPORT.log';
        if ($msg != "") {

            $fp = fopen("counterlog.txt", "w");
            fwrite($fp, $count);
            fclose($fp);

            file_put_contents($logfile1, $msg, FILE_APPEND);
            //file_put_contents($logfile3,$msg, FILE_APPEND);
        }
        if ($msg2 != "") {

            file_put_contents($logfile2, $msg2, FILE_APPEND);
        }
        if ($msg4 != "") {

            $fp = fopen("counterlog.txt", "w");
            fwrite($fp, $count);
            fclose($fp);

            file_put_contents($logfile4, $msg4, FILE_APPEND);
        }
        if ($msg3 != "") {

            file_put_contents($logfile5, $msg3, FILE_APPEND);
        }

        //end of count code

        if ($count == "24") {
            file_put_contents("counterlog.txt", "");

            echo "successfully generated";
        }
    }
    else { echo "oooo"; }
}

?>