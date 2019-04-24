<?php 
date_default_timezone_set('Asia/Kolkata');
/* Acknowledge received from Terminal */
if(isset($_POST['ack'])){
	$out_trade_no = $_POST['out_trade_no'];
	$terminal_id = $_POST['terminal_id'];
	$acknowledge = $_POST['ack'];
	$tran_req_type = $_POST['tran_req_type'];

	$ack_array = array(
		'out_trade_no' => $out_trade_no,
		'terminal_id' => $terminal_id,
		'acknowledge' => $acknowledge,
		'tran_req_type' => $tran_req_type
	);

	$ack_response = "POS Terminal response Ack Log:".date("Y-m-d H:i:sa") . "Ack response:" .json_encode($ack_array). " \n\n";
	$myfile = file_put_contents('/var/www/html/testspaysez/api/alipaytranLOG.log', $ack_response . PHP_EOL, FILE_APPEND | LOCK_EX);
}else {
	$not_receive_ack = 'Ack not recieved from terminal';
	$no_ack_response = "POS Terminal response Ack Log:".date("Y-m-d H:i:sa") . "Ack response:" .$not_receive_ack. " \n\n";
	$myfile = file_put_contents('/var/www/html/testspaysez/api/alipaytranLOG.log', $no_ack_response . PHP_EOL, FILE_APPEND | LOCK_EX);
}



?>