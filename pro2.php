<?php

ini_set("allow_url_fopen", 1);

$url = 'http://paymentgateway.test.credopay.in/Spaysez/pro1.php'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$characters = json_decode($data); // decode the JSON feed

echo "<pre>";
print_r($characters);

exit;

$data_string = '{
  "terminal_id ": "11111111",
  "amount": "50000",
  "currency": "INR",
  "terminal_timestamp": "1456507704102",
  "out_trade_no": "100000381456507704102",
  "tran_req_type": "1"
}';

$ch = curl_init();
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

// $jsonStr = file_get_contents("php://input"); //read the HTTP body.
// $json = json_decode($jsonStr);

// echo "<pre>";
// print_r($json);

echo $result;

// $data = '{
//   "terminal_id ": "11111111",
//   "amount": "50000",
//   "currency": "INR",
//   "terminal_timestamp": "1456507704102",
//   "out_trade_no": "100000381456507704102",
//   "tran_req_type": "1"
// }';

// $data_string = json_decode($data);

// echo "<pre>";
// print_r($data_string);

// echo "<br>";

// $data_string1 = json_encode($data_string);

// echo "<pre>";
// print_r($data_string1);

// exit;

// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// $server_output = curl_exec($ch);

// //Send blindly the json-encoded string.
// //The server, IMO, expects the body of the HTTP request to be in JSON
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

// $jsonStr = file_get_contents("php://input"); //read the HTTP body.
// $json = json_decode($jsonStr);




// ini_set("allow_url_fopen", 1); 

// $url = 'https://paymentgateway.test.credopay.in/Spaysez/pro1.php';
// $json = file_get_contents('url_here');
// $obj = json_decode($json);
// echo $obj->access_token;

?> 	