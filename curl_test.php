<?php
$response_data = array(
    "out_trade_no" => 'E000000120181023044601',
    "transaction_status" => 'SUCCESS',
    "terminal_id" => 'E0000001',
    "tran_req_type" => '1'
);
$enco = json_encode($response_data);
$curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8080",
      CURLOPT_URL => "http://220.247.222.76:8080/AliPayCallBack/CallBack",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $enco,
      CURLOPT_FOLLOWLOCATION => 1,
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "Content-Length:".strlen($enco)
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      //echo $response;
    }
    ?>