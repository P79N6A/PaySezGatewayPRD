<?php
error_reporting(0);

$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$db = new Mysqlidb ($confighost, $userd, $passd, 'suprpaysez');

date_default_timezone_set("Asia/Hong_Kong");

$arrayVals = [
'2018-10-27 08:36:16||2018102722001460251008969193|617050224402753457858326468301939406691540600576620|41.00|285.56|0.00|0.00|40.59|282.70|0.41|2.86|||USD|6.964800|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 19:04:37||2018102622001474081007706722|612902108018618867385408843567199610181540551876312|0.03|0.21|0.00|0.00|0.03|0.21|0.00|0.00|||USD|6.964800|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 19:02:47||2018102622001474081007710340|1884040772461657272961382117713369020401540551765716|0.03|0.21|0.00|0.00|0.03|0.21|0.00|0.00|||USD|6.964800|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 18:30:58||2018102622001474081007696823|2457777314614941902817004240360946561021540549858353|0.03|0.21|0.00|0.00|0.03|0.21|0.00|0.00|||USD|6.964800|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 15:52:15||2018102622001474081007624439|526861248560361276850346016517668193001540540335821|0.03|0.21|0.00|0.00|0.03|0.21|0.00|0.00|||USD|6.970460|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 00:27:26||2018102622001484291006462960|2542095531081709460294581903815555922081540484845244|35.00|243.42|0.00|0.00|34.65|240.99|0.35|2.43|||USD|6.954830|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 00:26:46||2018102622001434371006710401|117760483386629647045363988086973984261540484806285|35.00|243.42|0.00|0.00|34.65|240.99|0.35|2.43|||USD|6.954830|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 00:22:04||2018102622001421331006661822|2089326391134537115237602931424229259701540484524542|27.00|187.78|0.00|0.00|26.73|185.90|0.27|1.88|||USD|6.954830|Flemingo Duty Free (Departure)|SPOT|P|P|N|',
'2018-10-26 00:04:29||2018102622001452281006426004|2883630287644260388938459780895899125021540483437058|28.00|194.74|0.00|0.00|27.72|192.79|0.28|1.95|||USD|6.954830|Flemingo Duty Free (Departure)|SPOT|P|P|N|'
];

$arrayVals_reverse = array_reverse($arrayVals);

echo "<pre>";
print_r($arrayVals_reverse);
echo "<br>";
// exit;
// die();

$i = 0; $j = 0;

foreach ($arrayVals_reverse as $key => $var) {
	if($var) {
		$i++; 
		// echo $i.",";
		// // echo $var;
		// echo "<br>";
		$firstexp[$i] = explode("|",$var);
		// echo $firstexp[$i][0];
		// echo "<br>";

		$secondexp[$i] = explode(" ",$firstexp[$i][0]);

		// echo $firstexp[$i][0].'=>'.$secondexp[$i][0].'=>'.$secondexp[$i][1].'<br>';

		if($firstexp[$i][18] == 'R') {
			// $db->where("out_trade_no",$firstexp[$i][3]);
			// $record_check = $db->get('transaction_alipay_test');
			// $count = count($record_check);
			$trans_type[$i] = 2;
		} else if($firstexp[$i][18] == 'P') {
			$trans_type[$i] = 1;
		}

		if($firstexp[$i][18] == 'P' && $firstexp[$i][19] == 'P') {
			$result_code[$i] = 'SUCCESS';
			$trade_status[$i]='TRADE_SUCCESS';
			$total_fee[$i] = $firstexp[$i][4];
			$refund_amount[$i] = NULL;
		} else if($firstexp[$i][18] == 'R' && $firstexp[$i][19] == 'S') {
			$result_code[$i] = 'SUCCESS';
			$trade_status[$i]= NULL;
			$total_fee[$i] = abs($firstexp[$i][4]);
			$refund_amount[$i] = abs($firstexp[$i][4]);
		}

		/**** India Time Conversion ****/
		$given_datetime[$i] = $firstexp[$i][0];
		$given[$i] = new DateTime($given_datetime[$i]);
		$given[$i]->setTimezone(new DateTimeZone("Asia/kolkata"));
		$updated_datetime[$i] = $given[$i]->format("Y-m-d H:i:s");
		$updated_date[$i] = $given[$i]->format("Y-m-d");
		$updated_time[$i] = $given[$i]->format("H:i:s");

		$data[$i] = Array(
	        "cst_trans_datetime" => $firstexp[$i][0],
	        "trans_datetime" => $updated_datetime[$i],
	        "trans_time"   => $updated_time[$i],
	        "trans_date"   => $updated_date[$i],
	        "trade_no"     => ($firstexp[$i][2]!='' ? $firstexp[$i][2] : ''),
	        "out_trade_no" => ($firstexp[$i][3]!='' ? $firstexp[$i][3] : ''),
	        "total_fee"    => $total_fee[$i],
	        "exchange_rate"=> ($firstexp[$i][15]!='' ? $firstexp[$i][15] : ''),
	        "currency"     => ($firstexp[$i][14]!='' ? $firstexp[$i][14] : ''),
	        "transaction_type" => $trans_type[$i],
	        "result_code" => $result_code[$i],
	        "trade_status" => $trade_status[$i],
	        "refund_amount" => $refund_amount[$i],
	        "merchant_id" => 'E01010000000001'
	    );

	    echo $given_datetime[$i].'=>'.$updated_datetime[$i].'<br>';

	    $id_transaction_id = $db->insert('transaction_alipay_temp', $data[$i]);
	    if($id_transaction_id) {
	    	$j++;
	    }

	}
}

echo $i." => ".$j;