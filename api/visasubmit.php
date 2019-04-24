<?php 
//error_reporting(0);
$schema=$_GET['schema'];
$merchantId=$_GET['merchantId'];
$transactionId=$_GET['transactionId'];
$pan=$_GET['pan'];
$expiration=$_GET['expiration'];
$purchaseDate=date('Ymd H:i:m');
$purchaseAmount=$_GET['purchaseAmount'];
$currencyCodeNum=$_GET['currencyCodeNum'];
$currencyCodeChr=$_GET['currencyCodeChr'];
$currencyExponent=$_GET['currencyExponent'];
$returnUrl=$_GET['returnUrl'];
$got=$schema. ';' .$merchantId. ';' . $transactionId .';'. $pan .';'. $expiration. ';' .$purchaseDate. ';' .$purchaseAmount. ';' .$currencyCodeNum.';'.$currencyCodeChr. ';' .$currencyExponent. ';'.$returnUrl.';4884jdlojdj389ue';

$ma=base64_encode(hash('SHA256', $got, true));
$vsend="schema=".$schema."&merchantId=".$merchantId."&transactionId=".$transactionId."&pan=".$pan."&expiration=".$expiration."&purchaseDate=".$purchaseDate."&purchaseAmount=".$purchaseAmount."&currencyCodeNum=".$currencyCodeNum."&currencyCodeChr=".$currencyCodeChr."&currencyExponent=".$currencyExponent."&mac=".$ma."&returnUrl=".$returnUrl."&serviceUrl=mpi.jsp";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://169.38.91.250:8080/ipaympi/mpi.jsp");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$vsend);
curl_setopt($ch, CURLOPT_TIMEOUT, 200);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

$server_output = curl_exec ($ch);
$skuList = preg_split("/\\r\\n|\\r|\\n/", $server_output);
print_r($skuList);
echo "<br>----<br>";
$name_array = explode(' ', strip_tags($server_output));
print_r('0.  '.$name_array[0]);
echo "<br>";echo "<br>";
print_r('1.  '.$name_array[1]);
echo "<br>";echo "<br>";
print_r('2.  '.$name_array[2]);
echo "<br>";
echo "<br>";
print_r('3.  '.$name_array[3]);
echo "<br>";
echo "<br>";
print_r('4.  '.$name_array[4]);
echo "<br>";
echo "<br>";
print_r('5.  '.$name_array[5]);
echo "<br>";
echo "<br>";
print_r('6.  '.$name_array[6]);
echo "<br>";
echo "<br>";
print_r('7.  '.$name_array[7]);
echo "<br>";
echo "<br>";
print_r('8.  '.$name_array[8]);
echo "<br>";
echo "<br>";
print_r('9.  '.$name_array[9]);
echo "<br>";
echo "<br>";
print_r('10.  '.$name_array[10]);
echo "<br>";
echo "<br>";
print_r('11.  '.$name_array[11]);
echo "<br>";
echo "<br>";
//print_r("Error:".curl_error($ch));
curl_close ($ch);


?>
<!--
<html>
<head>
<title>MPI VISA/Mastercard</title>
</head>
<body>
<center><h3 style="color:blue;">Redirecting to VISA3D Secure..</h3></center>
<form id="visasub" method="post" action="http://169.38.91.250:8080/ipaympi/mpi.jsp">
<input type="hidden" size="20" name="schema" value="<?php echo $schema; ?>"/><br><br>
<input type="hidden" size="20" name="merchantId" value="<?php echo $merchantId; ?>"/><br><br>
<input type="hidden" size="20" name="transactionId" value="<?php echo $transactionId; ?>"/><br><br>
<input type="hidden" size="20" name="pan" value="<?php echo $pan; ?>"/><br><br>
<input type="hidden" size="10" name="expiration" value="<?php echo $expiration; ?>"/><br><br>
<input type="hidden" size="20" name="purchaseDate" value="<?php echo $purchaseDate;?>"/><br><br>
<input type="hidden" size="12" name="purchaseAmount" value="<?php echo $purchaseAmount; ?>"/><br><br>
<input type="hidden" size="5" name="currencyCodeNum" value="<?php echo $currencyCodeNum; ?>"/><br><br>
<input type="hidden" size="5" name="currencyCodeChr" value="<?php echo $currencyCodeChr; ?>"/><br><br>
<input type="hidden" size="5" name="currencyExponent" value="<?php echo $currencyExponent; ?>"/><br><br>
<input type="hidden" name="returnUrl" value="<?php echo $returnUrl; ?>"><br><br>
<input type="hidden" name="mac" value="<?php echo base64_encode(hash('SHA256', $got, true));?>"><br><br>
<input type="hidden" size="100" name="serviceUrl" value="mpi.jsp"/><br><br>
</form>
</body>
</html>
<script>
    setTimeout(function(){ document.getElementById("visasub").submit(); }, 2000);
</script>
-->