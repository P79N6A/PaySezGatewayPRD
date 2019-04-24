<?php 
$name=$_GET['name'];
echo $name;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/sample1.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name='.$name);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if(curl_error($ch))
{
    echo 'error:' . curl_error($ch);
}
echo 'error:' . curl_error($ch);
print_r($response);
?>