<?php 
//error_reporting(0);
$schema=$_GET['schema'];
$merchantId=$_GET['merchantId'];
$transactionId=$_GET['transactionId'];
$pan=$_GET['pan'];
$expiration=$_GET['expiration'];
date_default_timezone_set('Etc/UTC');
$purchaseDate=date('Ymd H:i:s');
date_default_timezone_set('Asia/Kolkata');
//$purchaseDate=$_GET['purchaseDate'];
$purchaseAmount=$_GET['purchaseAmount'];
$currencyCodeNum=$_GET['currencyCodeNum'];
$currencyCodeChr=$_GET['currencyCodeChr'];
$currencyExponent=$_GET['currencyExponent'];
$returnUrl=$_GET['returnUrl'];
$got=$schema. ';' .$merchantId. ';' . $transactionId .';'. $pan .';'. $expiration. ';' .$purchaseDate. ';' .$purchaseAmount. ';' .$currencyCodeNum.';'.$currencyCodeChr. ';' .$currencyExponent. ';'.$returnUrl.';4884jdlojdj389ue';

$gotlog=$schema. ';' .$merchantId. ';' . $transactionId .';'. substr_replace($pan, str_repeat("X", 8), 4, 12) .';'. $expiration. ';' .$purchaseDate. ';' .$purchaseAmount. ';' .$currencyCodeNum.';'.$currencyCodeChr. ';' .$currencyExponent. ';url_here;4884jdlojdj389ue';

$ma=base64_encode(hash('SHA256', $got, true));

//exit;
if($_GET["env"]=="live" || $_GET["env"]=="test")
$logtosend='postvalue='.$gotlog.'&env='.$_GET["env"];
else
$logtosend='postvalue='.$got.'&env='.$_GET["env"];

$ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/loginsert.php");
curl_setopt($ch, CURLOPT_URL, "http://10.162.104.221/api/loginsert.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $logtosend);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close($ch);
/*
$log = date("Y-m-d H:i:sa") . '\n\n
					-----------------------------------'.$got.'';
					$myfile = file_put_contents('merchantapiMLOG.log', $gotlog . PHP_EOL, FILE_APPEND | LOCK_EX);
*/
?>
<html>
<head>
<title>MPI VISA/Mastercard</title>
</head>
<body>
<center><h3 style="color:blue;">Redirecting to MC3D Secure..</h3></center>
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
