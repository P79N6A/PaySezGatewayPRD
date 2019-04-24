<?php
$response_data = array(
    "out_trade_no" => '123',//$_POST['out_trade_no'],
    "transaction_status" => 'suc',//$_POST['extra_common_param'],
    "terminal_id" => '345',//$terminal_id,
    "tran_req_type" => '1'//$tran_req_type
);
$enco = json_encode($response_data);
//print_r($enco);exit;die();
header("Location: https://paymentgateway.test.credopay.in/Spaysez/response.php?json=$enco");
?>
