<?php 
$pa = 'vino.kumar226@okicici';
$pn = 'vinothkumar';
$am = '1';
$mode = '02';
$sign ='werwrwrwrrwrwe';
$orgid = '123456';

$upi_id = 'upi://pay?';

$secretKey = "secret_key";
  $postData = array( 
  "pa" => $pa, 
  "pn" => $pn, 
  "am" => $am, 
  "mode" => $mode, 
  "sign" => $sign, 
  "orgid" => $orgid
);
 $query_string = http_build_query($postData); 
 $upi_data = $upi_id.$query_string;
 $signature = base64_encode(hash("sha256", $secretKey, True));
 $postData2 = array( 
  "pa" => $pa, 
  "pn" => $pn, 
  "am" => $am, 
  "mode" => $mode, 
  "sign" => $sign, 
  "orgid" => $orgid,
  "sign" => $signature
);
 $query_string2 = http_build_query($postData2); 
 $upi_data_final = $upi_id.$query_string2;
 //header( "Refresh:5;url=test.php?user=".$upi_data_final);
 echo $upi_data_final;exit;

?>