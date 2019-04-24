<?php 
error_reporting(0);
$servername = "localhost";
$username = "urebanx";
$password = "Rebanxpg";
$dbname = "rebanx";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  
date_default_timezone_set("Asia/kolkata");

$currentdate = date('Y-m-d H:00:00',strtotime("-1 hours"));
$sdate=date('Y-m-d H:59:59',strtotime("-1 hours"));


$currentdate = date('2017-11-16 00:00:00');
$sdate=date('2017-12-15 23:59:59');

//$f=date('H_00', strtotime("-1 hours"));
$l=date('H', strtotime($currentdate));
$m=date('i', strtotime($currentdate));
$d=date('Ymd', strtotime($currentdate));
$fn1="201801231806";
$fn="201801231806";

//$sql = "SELECT * FROM transactions";
//$sql = "SELECT * FROM transactions where shipping_date BETWEEN '".$currentdate ."' AND '".$sdate ."'";
/****changed on 24thnov****/
//$sql="SELECT * FROM transactions INNER JOIN actions ON transactions.id_transaction_id = actions.id_transaction_id where server_datetime_trans >= '".$currentdate ."' AND server_datetime_trans <='".$sdate ."' AND error_code='00' AND tlf_flag=1";
/*
$sql="SELECT * FROM transactions INNER JOIN actions ON transactions.id_transaction_id = actions.id_transaction_id LEFT JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id=transactions.merchant_id where server_datetime_trans >= '".$currentdate ."' AND server_datetime_trans <='".$sdate ."'  AND error_code='00' ";

$sql="SELECT * FROM transactions WHERE retrvl_refno = 802210003345 ";
*/


$sql="SELECT * FROM transactions LEFT JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id=transactions.merchant_id WHERE retrvl_refno = 735618002890 OR retrvl_refno =736011002932";
/**/
//echo $sql;
$projects = mysqli_query($conn, $sql);



function mc_decrypt($decrypt, $key){
        $decrypt = explode('|', $decrypt.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if($calcmac!==$mac){ return false; }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }
	
foreach ($projects as $project)
{

	$sqlresp = "SELECT * FROM merchants where mer_map_id='".$project['mer_map_id']."'";
	$eresp=$conn->query($sqlresp);
	$t=$eresp->fetch_assoc();
	
	//hash get
	$sqlresphash = "SELECT * FROM hash_tab where t_id='".$project['id_transaction_id']."'";
	$eresphash=$conn->query($sqlresphash);
	$thash=$eresphash->fetch_assoc();
	
	/*print_r($t);
	print_r($t['merchant_name']);

	$sql1="SELECT * FROM merchants where mer_map_id='".$project['merchant_id']."'";
//echo $sql;
	$mname = mysqli_query($conn, $sql);
*/
	$addrs	= $t['merchant_name'].$t['address1'].$t['address2'];
	$amt	= sprintf('%012d', $project['amount']);
	$city	= $t['city'];
	if($city=="null")
	{
		$city="";
	}
	$state= $project['us_state'];
	$country= $project['country'];
	$length2 = strlen($addrs);
	$length3 = strlen($city);
	$length4 = strlen($state);
	$length5 = strlen($country);
	
	$cc_num=mc_decrypt($project['cc_number'], $project['cc_hash']);
	
	// address 23 chars
	if ($length2 < 23) {
		$addrs .= str_repeat(' ', 23 - $length2);
	} else {
		$addrs = substr($addrs, 0, 23);
	}
	
	// city 13 chars
	if ($length3 < 13) {
		$city .= str_repeat(' ', 13 - $length3);
	} else {
		$city = substr($city, 0, 13);
	}
	
	// state 2 chars
	if ($length4 < 2) {
		$state .= str_repeat(' ', 2 - $length4);
	} else {
		$state = substr($state, 0, 2);
	}
	 
	// country 2 chars
	if ($length5 < 2) {
		$country .= str_repeat(' ', 2 - $length5);
	} else {
		$country = substr($country, 0, 2);
	}
	
	$card_acc_name_loc=$addrs.$city.$state.$country;
	
	$maskcard=substr_replace($cc_num, str_repeat("X", 8), 4, 8);
	
	if($project['error_code']=="00"){
        if($project['network']!='MC') {
    $data=$data.$project['bank_code']. "|" . $project['network']. "|" . $project['unique_id']. "|" . $project['mti_response']. "|" . $cc_num. "|" . $project['processing_code']. "|" . $amt. "||" . $project['trans_date_time']. "||" . $project['sys_trace_audit_no']. "|" . $project['localtrans_time']. "|" . $project['localtrans_date']. "|" . $project['exp_date']. "||" . $project['merchant_type']. "|" . $project['country_code']. "|810|" . $project['pan_seq']. "|59||300045||" . $project['retrvl_refno']. "|".$project['appr_code']."|".$project['error_code']."|000|" . $t['terid']. "|" . $project['acq_inst_idfc_code']. "|" . $card_acc_name_loc. "||". $project['country_code']. "||||||||||" . $project['originate']. "|" . date('Ymd h:m:i', strtotime($project['server_datetime_trans'])). "|" . $project['settle_by']. "|" . date('Ymd', strtotime($project['server_datetime_trans'])). "|||" . $project['tran_is']. "|" . $project['tran_type_indicator']. "|" . $project['postal_code']. "|" . $project['ecom_indicator']. "|". $project['v_o_r_indicator']. "|| \r\n" ;
	
	$data4=$data4. $project['network']. "|".$project['retrvl_refno']. "|" .$project['appr_code']."|".$project['error_code']."|" . date('Ymd h:m:i', strtotime($project['server_datetime_trans']))."\r\n" ;
	
        }

        if($project['network']=='MC') {
            $data2 = $data2 . $project['bank_code'] . "|" . $project['network'] . "|" . $project['unique_id'] . "|" . $project['mti_response'] . "|" . $maskcard . "|" . $project['processing_code'] . "|" . $amt . "||" . $project['trans_date_time'] . "||" . $project['sys_trace_audit_no'] . "|" . $project['localtrans_time'] . "|" . $project['localtrans_date'] . "|" . $project['exp_date'] . "||" . $project['merchant_type'] . "|" . $project['country_code'] . "|810|" . $project['pan_seq'] . "|59||300045||" . $project['retrvl_refno'] . "|" . $project['appr_code'] . "|" . $project['error_code'] . "|000|" . $t['terid'] . "|" . $project['acq_inst_idfc_code'] . "|" . $card_acc_name_loc . "||" . $project['country_code'] . "||||||||||" . $project['originate'] . "|" . date('Ymd h:m:i', strtotime($project['server_datetime_trans'])) . "|" . $project['settle_by'] . "|" . date('Ymd', strtotime($project['server_datetime_trans'])) . "|||" . $project['tran_is'] . "|" . $project['tran_type_indicator'] . "|" . $project['postal_code'] . "|" . $project['ecom_indicator'] . "|" . $project['v_o_r_indicator'] . "||" . $project['accountno'] . "|" . $project['ifsccode'] . " \r\n";
			
			    $data3 = $data3 . $project['network'] . "|" . $project['retrvl_refno'] . "|" . $project['appr_code'] . "|" . $project['error_code'] .  "|" . date('Ymd h:m:i', strtotime($project['server_datetime_trans']))." \r\n";
			
        }
        else {
            $data2 = $data2 . $project['bank_code'] . "|" . $project['network'] . "|" . $project['unique_id'] . "|" . $project['mti_response'] . "|" . $maskcard . "|" . $project['processing_code'] . "|" . $amt . "||" . $project['trans_date_time'] . "||" . $project['sys_trace_audit_no'] . "|" . $project['localtrans_time'] . "|" . $project['localtrans_date'] . "|" . $project['exp_date'] . "||" . $project['merchant_type'] . "|" . $project['country_code'] . "|810|" . $project['pan_seq'] . "|59||300045||" . $project['retrvl_refno'] . "|" . $project['appr_code'] . "|" . $project['error_code'] . "|000|" . $t['terid'] . "|" . $project['acq_inst_idfc_code'] . "|" . $card_acc_name_loc . "||" . $project['country_code'] . "||||||||||" . $project['originate'] . "|" . date('Ymd h:m:i', strtotime($project['server_datetime_trans'])) . "|" . $project['settle_by'] . "|" . date('Ymd', strtotime($project['server_datetime_trans'])) . "|||" . $project['tran_is'] . "|" . $project['tran_type_indicator'] . "|" . $project['postal_code'] . "|" . $project['ecom_indicator'] . "|" . $project['v_o_r_indicator'] . "||" . $project['accountno'] . "|" . $project['ifsccode'] . " \r\n";
			
			 $data3 = $data3 . $project['network'] . "|" . $project['retrvl_refno'] . "|" . $project['appr_code'] . "|" . $project['error_code'] .  "|" . date('Ymd h:m:i', strtotime($project['server_datetime_trans']))." \r\n";
        }
		
	
	}
 /*  $datup=date('Y-m-d H:i:s');
   $tidup=$project['id_transaction_id'];
   /*
   $sqlup="update transactions set tlf_flag=1, tlf_updatedon='".$datup."' where id_transaction_id=".$tidup;

	mysqli_query($conn, $sqlup);
	*/
	
   
   }
/*
wh_log($data,$data4, $data2, $data3, $fn, $fn1, mysqli_num_rows($projects));
//echo "Log Generated Successfully!.";

function wh_log($msg, $msg4, $msg2, $msg3, $fn, $fn1, $nov){
	
	if($nov > 0) {
		$msg=substr($msg, 0, -2);
		$msg2=substr($msg2, 0, -2);
		$logfile1='shagen/PG_TLF_'.$fn. '.log';
		$logfile2='shagen/PG_MERTXNS_'.$fn1. '.log';		
		$logfile3='shagen/PG_TLF_'.$fn. 'REPORT.log';
		$logfile4='shagen/PG_MERTXNS_'.$fn1. 'REPORT.log';
		//$logfile3='PG_TLF_'.$fn. '.log';
		if($msg != "") {
		file_put_contents($logfile1,$msg."\n", FILE_APPEND);
		}
		if($msg4 != "") {
		
		file_put_contents($logfile3,$msg4."\n", FILE_APPEND);
		}
		if($msg2 != "") {
		//file_put_contents($logfile3,$msg."\n", FILE_APPEND);
		file_put_contents($logfile2,$msg2."\n", FILE_APPEND);
		}
		if($msg3 != "") {
		
		file_put_contents($logfile4,$msg3."\n", FILE_APPEND);
		}
		
		
	echo "successfully generated";
	}
}

$conn->close();

?>