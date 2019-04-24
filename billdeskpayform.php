<?php
date_default_timezone_set("Asia/kolkata");

/**** BillDesk Configuration ****/
include('Billdesk/config.php');
// $Checksum_key = 'qeHCGJNlCb4s';
// $Security_ID = 'EZSWYPE-NA';
/********************************/

/**** Transaction Modes ****/
$Ttype = 'CC'; // Transaction Modes ===> Credit Card => CC, Net Banking => NB, Wallets => WT

$MerchantID = 'EZ5TST';
$CustomerID = 'E01010000000038'.date("YmdHis");
$Filler1 = 'NA';
$TxnAmount = '1.00'; // '10.00';

$api_url = '';
if($Ttype == 'NB') {
	/**** For Net Banking => IndusInd Bank - IDS, Bank of Maharastra - BOM, Indian Overseas Bank - IOB ****/
	$api_url = "https://pgi.billdesk.com/pgidsk/PGIMerchantRequestHandler?";
	$BankID  = 'IOB'; // 'BOM';
} else if($Ttype == 'WT') {
	/**** For Wallets => DCB Chippy - DCW ****/
	$api_url = "https://pgi.billdesk.com/pgidsk/PGIMerchantRequestHandler?";
	$BankID  = 'DCW';
} else if($Ttype == 'CC') {
	/**** For Credit Card => CIT ****/
	$api_url = "https://pgi.billdesk.com/pgidsk/PGICommonGateway";
	// $api_url = "https://pgi.billdesk.com/pgidsk/PGIMerchantRequestHandler?";
	$BankID  = 'CIT';

	// $cnumber = '';
	// $expmon  = '';
	// $expyr   = '';
	// $cvv2    = '';
	// $cardType= 'NA';
	// $cname2  = '';
}

// echo $api_url; exit;

$Filler2 = 'NA';
$Filler3 = 'NA';
$CurrencyType = 'INR';
$ItemCode = 'DIRECT';
$TypeField1 = 'R';
$SecurityID = $Security_ID; //'NG-NA';
$Filler4 = 'NA';
$Filler5 = 'NA';
$TypeField2 = 'F';
$AdditionalInfo1 = 'AA12345';
$AdditionalInfo2 = 'John@example.com';
$AdditionalInfo3 = '9999955555';
$AdditionalInfo4 = 'NA';
$AdditionalInfo5 = 'NA';
$AdditionalInfo6 = 'NA';
$AdditionalInfo7 = 'NA';
$RU = 'https://paymentgateway.test.credopay.in/testspaysez/responsefrombdk.php';

$str = $MerchantID."|".$CustomerID."|".$Filler1."|".$TxnAmount."|".$BankID."|".$Filler2."|".$Filler3."|".$CurrencyType."|".$ItemCode."|".$TypeField1."|".$SecurityID."|".$Filler4."|".$Filler5."|".$TypeField2."|".$AdditionalInfo1."|".$AdditionalInfo2."|".$AdditionalInfo3."|".$AdditionalInfo4."|".$AdditionalInfo5."|".$AdditionalInfo6."|".$AdditionalInfo7."|".$RU;

$checksum_key = $Checksum_key; // '';

$checksum = hash_hmac('sha256',$str,$checksum_key, false);
$checksum = strtoupper($checksum);

$msg = $str."|".$checksum;

$request_array = [
	"msg" => $msg,

	"cnumber" => $cnumber,
	"expmon" => $expmon,
	"expyr" => $expyr,
	"cvv2" => $cvv2,
	"cardType" => $cardType,
	"cname2" => $cname2,

	"hidOperation" => "ME100",
	"hidRequestId" => "PGIME1000",
	"reqid" => "cc_processall"
];

// $request_array = [
// 	"msg" => $msg,
// 	"reqid" => "cc_processall"
// ];

/**** BillDesk Pay API URL ****/
$Pay_api_url = $api_url; // "https://pgi.billdesk.com/pgidsk/PGIMerchantRequestHandler?";


function outputForm($postarray) {
	foreach($postarray as $key => $value) {
		echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />'."\n";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3./org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BillDesk</title>
<script type="text/javascript">
function submitForm(){
	alert("Hiiii");
	// var form = document.forms[0];
	// form.submit();
}
</script>
</head>
<body onload="javascript:submitForm();">
<center>
<table width="500px;">
	<tr>
		<td align="center" valign="middle">Do Not Refresh or Press Back <br/> Redirecting to BillDesk</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<form action="<?php echo $Pay_api_url; ?>" method="GET">
            <?php outputForm($request_array); ?>
			</form>
		</td>
	</tr>
</table>

</center>
</body>
</html>