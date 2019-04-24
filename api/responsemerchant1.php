<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 26-08-2017
 * Time: 02:52 PM
 */
error_reporting(0);

$merchantId=$_POST['merchantId'];
$transactionId=$_POST['transactionId'];
$enrollmentStatus=$_POST['enrollmentStatus'];
$authenticationStatus=$_POST['authenticationStatus'];
$details=$_POST['details'];
$xid=$_POST['xid'];
$eci=$_POST['eci'];
$cavv=$_POST['cavv'];
$cavvAlg=$_POST['cavvAlg'];
$mac=$_POST['mac'];


					$log = date("Y-m-d H:i:sa") . '\n\n
					-----------------------------------Location: http://169.38.91.250/api/mpiconvert.php?merchantId='.$merchantId.'&transactionId='.$transactionId.'&enrollmentStatus='.$enrollmentStatus.'&authenticationStatus='.$authenticationStatus.'&xid='.$xid.'&eci='.$eci.'&cavv='.$cavv.'&cavvAlg='.$cavvAlg.'&mac='.$mac.'&details='.$details.'';

$logtosend='postvalue='.rawurlencode($log).'&env=live';
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
					$myfile = file_put_contents('merchantapiMLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
				*/
				
header('Location: http://169.38.91.250/api/mpiconvert.php?merchantId='.$merchantId.'&transactionId='.$transactionId.'&enrollmentStatus='.$enrollmentStatus.'&authenticationStatus='.$authenticationStatus.'&xid='.$xid.'&eci='.$eci.'&cavv='.utf8_encode($cavv).'&cavvAlg='.$cavvAlg.'&mac='.$mac.'&details='.$details);

