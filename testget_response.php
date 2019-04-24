<?php

if($_POST) {
	// echo "<pre>";
	// print_r($_POST);

	header('Content-Type: application/json');
	echo json_encode($_POST);
}

exit;

$query_string = $_SERVER['QUERY_STRING'];
$query_string_de = base64_decode($query_string);
parse_str($query_string_de, $get_array);
// echo "Transaction ".$get_array['TRANSACTIONPAYMENTSTATUS'];
// echo "<br>";

header('Content-Type: application/json');
echo json_encode($get_array);
?>
