<?php 
/**** Alipay TLF Process ****/
error_reporting(0);
$servername = "10.162.104.214";
$username = "pguat";
$password = "pguat";
$dbname   = "testSpaysez";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');

$currentdate = "2018-10-15 00:00:00";
$sdate="2018-10-15 23:59:59";

// $sql_payment="SELECT * FROM transaction_alipay WHERE id_transaction_id >= 1241 AND id_transaction_id <= 1339";
// $sql_payment="SELECT * FROM transaction_alipay WHERE trans_datetime >= '2018-10-23 00:00:00' AND trans_datetime <='2018-10-23 23:59:59'";
$sql_payment="SELECT * FROM transaction_alipay";
$payment_projects = mysqli_query($conn, $sql_payment);

$i = 0; $j = 0;

if(is_object($payment_projects)) {
    foreach ($payment_projects as $project) {
    	$i++;
    	$given_datetime = $project['trans_datetime'];
    	$given_time = $project['trans_time'];
    	$given = new DateTime($given_datetime);
		$given->setTimezone(new DateTimeZone("Asia/Hong_Kong"));
		$updated_datetime = $given->format("Y-m-d H:i:s");
		$updated_time = $given->format("H:i:s");
		$updated_datetime_st = $given->format("YmdHis");
		$updated_date = $given->format("Y-m-d");
    	// echo $i.'=>'.$project['id_transaction_id'].'=>'.$given_datetime.'=>'.$given_time.'=>'.$updated_datetime.'=>'.$updated_time.'<br>';

		$transaction_id=$project['id_transaction_id'];
		$sqlupdate="update transaction_alipay set cst_trans_datetime='".$updated_datetime."' where id_transaction_id=".$transaction_id;
		$update_query = mysqli_query($conn, $sqlupdate);
		if($update_query) {
			$j++;
		}

		// $given = new DateTime($given_datetime);
		// $given->setTimezone(new DateTimeZone("Asia/Kolkata"));
		// $updated_datetime = $given->format("Y-m-d H:i:s");
		// $updated_time = $given->format("H:i:s");
		// echo $given_datetime.'=>'.$given_time.'=>'.$updated_datetime.'=>'.$updated_time.'<br>';
	}
}

echo $i."=>".$j;
exit;

?>