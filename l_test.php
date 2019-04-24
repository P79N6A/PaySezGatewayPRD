<?php

// function doMyThings() {
// 	echo "Hi Team";
// 	echo "<br>";
// }

// $start_time = microtime(true);
// // Do something...
// $end_time = microtime(true);
// echo 'Script executed in '. round(($start_time), 3) . 'seconds.'; exit;

// echo $start = microtime(true); exit;

// $now = DateTime::createFromFormat('U.u', microtime(true));
// $now->setTimezone(new DateTimeZone('Asia/Kolkata'));
// echo $now->format("Y-m-d H:i:s")." ".($now->format("u"));
// exit;

echo $micro_date = microtime(); exit;

$micro_date = microtime(true); 
$micro_date = round(($micro_date), 3);
$micro_date_exp = explode(".", $micro_date);
echo sprintf("%03d",$micro_date_exp[1]);
// echo round(($micro_date_exp[1]), 3);
exit;

date_default_timezone_set('Asia/Kolkata');

$micro_date = microtime();
$date_array = explode(" ",$micro_date);
$date = date("Y-m-d H:i:s",$date_array[1]);
echo "Date: $date:" . $date_array[0]."<br>";
exit;

// $start = microtime(true);
// // set_time_limit(60);
// for ($i = 0; $i < 59; ++$i) {
// 	// echo $i." ";
// 	// echo date('d-m-Y H:i:s');
// 	// doMyThings();
//     require_once('alipayapi_pos_loadtest.php');
//     // time_sleep_until($start + $i + 1);
// }
?>