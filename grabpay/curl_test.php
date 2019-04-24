<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/transaction/partner-e20e4283b3c0cb69ff7b5d90?msgID=14e327312e8140f093b164f7faf76837&grabID=84dfaba5-7a1b-4e91-aa1c-f7ef93895266&terminalID=b010f1c9fb724de4962d6f23c5c96afd&currency=SGD&txType=P2M",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "Authorization: 1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c:bJ7TEK31BZCT+xMjsUGyDGSlSwYVkub0nsCPxw+OAcw=",
    "Content-Type: application/x-www-form-urlencoded",
    "Date: Fri, 08 Mar 2019 16:12:57 GMT",
    "Postman-Token: 15c29510-7893-485d-bc8c-4375641b5623",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}