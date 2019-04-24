<style>
input{ width: 500px; margin-left: 20px;}
</style>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Canada/Eastern');
	//echo '->'.hex2bin('asd');
	include_once("netpayclient.php");
	//die();
	$merid = buildKey("MerPrK_808080101694375_20141016142610.key");
	if(!$merid) {
		echo "Failed to import the private key file！";
		exit;
	}
	
	$_POST['URL'] = 'http://payment-test.chinapay.com/pay/TransGet0_En';
	$_POST['MerId'] = '808080101694375';
	$_POST['OrdId'] = '4321123400000006';
	$_POST['TransAmt'] = '000000001234';
	$_POST['CuryId'] = 'USD';
	$_POST['CountryId'] = '0086';
	$_POST['TransDate'] = '20141109';
	$_POST['TransType'] = '0001';
	$_POST['Version'] = '20080515';
	$_POST['BgRetUrl'] = '216.52.148.144/api/netpay.php';
	$_POST['PageRetUrl'] = '216.52.148.144/api/netpay.php';
	$_POST['GateId'] = '123';
	$_POST['Priv1'] = 'Memo';
	$_POST['TimeZone'] = '+06';
	$_POST['TransTime'] = '122340';
	$_POST['DSTFlag'] = '1';
	$_POST['ExtFlag'] = '00';
	
	$postVars = array(
	'MerId'=>$_POST['MerId'],
	'OrdId'=>$_POST['OrdId'],
	'TransAmt'=>$_POST['TransAmt'],
	'CuryId'=>$_POST['CuryId'],
	'CountryId'=>$_POST['CountryId'],
	'TransDate'=>$_POST['TransDate'],
	'TransType'=>$_POST['TransType'],
	'Version'=>$_POST['Version'],
	'BgRetUrl'=>$_POST['BgRetUrl'],
	'PageRetUrl'=>$_POST['PageRetUrl'],
	'GateId'=>$_POST['GateId'],
	'Priv1'=>$_POST['Priv1'],
	'TimeZone'=>$_POST['TimeZone'],
	'TransTime'=>$_POST['TransTime'],
	'DSTFlag'=>$_POST['DSTFlag'],
	'ExtFlag'=>$_POST['ExtFlag']
	
	
	);
	
	$plain = $_POST['MerId'].
									$_POST['OrdId'].
									$_POST['TransAmt'].
									$_POST['CuryId'].
									$_POST['TransDate'].
									$_POST['TransTime'].
									$_POST['TransType'].
									$_POST['CountryId'].
									$_POST['TimeZone'].
									$_POST['DSTFlag'].
									$_POST['ExtFlag'].
									$_POST['Priv1'];
	/*foreach($postVars as $v)
	{
		$plain .= $v;
	}*/
	echo 'Signed String: '.$plain;
	$chkvalue = sign($plain);
	
	
	
	echo "<br>Verified: '".verify($plain,$chkvalue)."'";
	?>
<br /><br /><br />

<form action='http://payment-test.chinapay.com/pay/TransGet0_En' method='POST' >

MerId:<input type='text' name='MerId' value='808080101694375' /><br />
OrdId<input type='text' name='OrdId' value='0000000000000006' /><br />
TransAmt<input type='text' name='TransAmt' value='000000001234' /><br />
CuryId<input type='text' name='CuryId' value='156' /><br />
CountryId<input type='text' name='CountryId' value='0086' /><br />
TransDate<input type='text' name='TransDate' value='20141109' /><br />
TransType<input type='text' name='TransType' value='0001' /><br />
Version<input type='text' name='Version' value='20070129' /><br />
BgRetUrl<input type='text' name='BgRetUrl' value='216.52.148.144/api/netpay.php' /><br />
PageRetUrl<input type='text' name='PageRetUrl' value='216.52.148.144/api/netpay.php' /><br />
GateId<input type='text' name='GateId' value='123' /><br />
Priv1<input type='text' name='Priv1' value='Memo' /><br />
TimeZone<input type='text' name='TimeZone' value='+06' /><br />
TransTime<input type='text' name='TransTime' value='122340' /><br />
DSTFlag<input type='text' name='DSTFlag' value='1' /><br />
ExtFlag<input type='text' name='ExtFlag' value='00' /><br />
chkvalue<input type='text' name='ChkValue' value='<?php echo $chkvalue; ?>' /><br />
<br /><br /><br />
	
<input type='submit' value='Go' />

</form>
<?php


	
	
if(isset($_POST['Priv1']))
{

?>
<hr>
Results:
<?php



	date_default_timezone_set('Canada/Eastern');
	//echo '->'.hex2bin('asd');
	include_once("netpayclient.php");
	//die();
	$merid = buildKey("MerPrK_808080101694375_20141016142610.key");
	if(!$merid) {
		echo "Failed to import the private key file！";
		exit;
	}
	$site_url = "secure.profitorius.com";
	$PageRetUrl = "$site_url/netpay.php";
	$BgRetUrl = "$site_url/netpay.php";
	
	
	
	
	$postVars = array(
	'MerId'=>$_POST['MerId'],
	'OrdId'=>$_POST['OrdId'],
	'TransAmt'=>$_POST['TransAmt'],
	'CuryId'=>$_POST['CuryId'],
	'CountryId'=>$_POST['CountryId'],
	'TransDate'=>$_POST['TransDate'],
	'TransType'=>$_POST['TransType'],
	'Version'=>$_POST['Version'],
	'BgRetUrl'=>$_POST['BgRetUrl'],
	'PageRetUrl'=>$_POST['PageRetUrl'],
	'GateId'=>$_POST['GateId'],
	'Priv1'=>$_POST['Priv1'],
	'TimeZone'=>$_POST['TimeZone'],
	'TransTime'=>$_POST['TransTime'],
	'DSTFlag'=>$_POST['DSTFlag'],
	'ExtFlag'=>$_POST['ExtFlag']
	
	
	);
	$plain = '';
	foreach($postVars as $v)
	{
		$plain .= $v;
	}
	
	$chkvalue = sign($plain);
	if (!$chkvalue) {
		echo "Signature Failure";
		exit;
	}
	
	
	$out = fopen('curl.txt','w');
	$ch = curl_init($_POST['URL']);
	//$postVars = "MerId=808080101694375&OrdId=0000000000000006&TransAmt=000000001234&CuryId=156&CountryId=0086&TransDate=20080601&TransType=0001&Version=20080515&BgRetUrl=$BgRetUrl&PageRetUrl=$PageRetUrl&GateId=&Priv1=Memo&TimeZone=+06&TransTime=122340&DSTFlag=1&ExtFlag=00&Priv2=priv2&ChkValue=$chkvalue";
	

	$postVars['ChkValue'] = $chkvalue;
	
	echo "Post Vars<pre>".print_r($postVars,1)."</pre>";
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);
	//curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_STDERR, $out);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_HEADER, true);
	
	$o = curl_exec($ch);
	
	print str_replace('action=\'','action=\'http://payment-test.chinapay.com/pay/TransGet0_En',$o);
	
	$output = fread($out,2048);
	
	echo "<hr>URL:http://payment-test.chinapay.com/pay/PayDetail_En.jsp";
	echo "<hr>Post Vars<pre>".print_r($postVars,1)."</pre>";
	


}
?>