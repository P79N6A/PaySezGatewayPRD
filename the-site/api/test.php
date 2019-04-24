<?php
/*
--test
URL : https://tpay.smilepay.co.kr/trans/cardTrans.jsp
MerchantKey : lkviD+J6o1+I/iFlxnRj3Xo+znBOmuo6G4gVCASJAaP65i8w0FiV24c/4PXkY2DEuPuk8bFhrZQ4HvIGijH3Zg==
MID : gompay001m

----live test
URL : https://pay.smilepay.co.kr/trans/cardTrans.jsp
MerchantKey : T+IbtWqgZdgRvbJ2p2SJJ6ZIhgaegUMNRE/FyrM/Q4YaxpSHfYsJGBuj79wQSKqYrJ4Y1ZIXzv3h4QCxZNlKvg==
MID : testga840m

*/
		$callUrl = "https://tpay.smilepay.co.kr/trans/cardTrans.jsp";
		$merchantKey = "lkviD+J6o1+I/iFlxnRj3Xo+znBOmuo6G4gVCASJAaP65i8w0FiV24c/4PXkY2DEuPuk8bFhrZQ4HvIGijH3Zg==";
		$sendMID = "gompay001m";	//SECURE_TYPE A
		$reference = "1004";
		$TransactionType = "AA";
		$acquireType = "1";
		$currency ="USD";
		$amount = '10.06';
		$cardNum = "4907639999990022";
		$expiryYYMM = "1512";
		$cvc = "029";
		$secureType = "A";
		$ProductName ="winnie";
		$BuyerEmail ="wkskvk@naver.com";
		$BuyerName ="kim-urim";
		$BuyerIP = "111.111.111.111";
		$BuyerID = "buyer";
		$ServerIP = '209.121.111.2';
		$SiteURL = 'https://www.aaaaaaaaa.com';
		$verify = "";
		$OutputType = "X";
		$TID = 'gompay001m01011506101050498346';
		$PartialCancelCode = '0';
		$AuthDate = '20150610';
		$AuthCode = '441507';
		$ResponseTime = "105052";
		
		
//int deliIdx = (Integer.parseInt(reference.substring(reference.length()-4, reference.length())) + Integer.parseInt(amount.replaceAll("\\.", "").replaceAll(",", ""))) % 86;
$deliIdx = (int)(substring($reference, -4, 4) + str_replace('.', '', $amount)) % 86;

//for credit card
$deliIdx2 = (int)(substring($reference, -4, 4) + str_replace(',', '', str_replace('.', '', $amount))) % 4;
if($deliIdx2 == 0){
	$keyData = substring($merchantKey, 0, 16);
}else{	
	$keyData = substring($merchantKey, (16*$deliIdx2), (16*$deliIdx2+16));
}		
$encyptcc = encrypt($cardNum, $keyData);
$encyptexpiryYYMM = encrypt($expiryYYMM, $keyData);
$encyptcvc = encrypt($cvc, $keyData);

//String[] delimeters = getDelimeters(merchantKey.substring(0, merchantKey.length()-2), 4, 3, deliIdx);
$delimeters = getDelimeters(substring($merchantKey, 0, strlen($merchantKey)-2), 4, 3, (int)$deliIdx);

$vsb ='';

if($TransactionType == 'AA'){
	$vsb .= base64_encode($reference); 
	$vsb .= $delimeters[0];
	$vsb .= base64_encode($amount); 
	$vsb .= $delimeters[1];
	$vsb .= base64_encode($sendMID); 
	$vsb .= $delimeters[2];
	$vsb .= base64_encode($acquireType);
}elseif($TransactionType == 'AC'){
	$vsb .= base64_encode($reference); 
	$vsb .= $delimeters[0];
	$vsb .= base64_encode($sendMID); 
	$vsb .= $delimeters[1];
	$vsb .= base64_encode($TID); 
	$vsb .= $delimeters[2];
	$vsb .= base64_encode($amount); 
	$vsb .= $delimeters[3];	
	$vsb .= base64_encode($PartialCancelCode);
}elseif($TransactionType == 'AD'){
	$vsb .= base64_encode($reference); 
	$vsb .= $delimeters[0];
	$vsb .= base64_encode($sendMID);
	$vsb .= $delimeters[1];
	$vsb .= base64_encode($amount); 
	$vsb .= $delimeters[2];
	$vsb .= base64_encode($AuthDate);
}elseif($TransactionType == 'AQ'){
	$vsb .= base64_encode($reference); 
	$vsb .= $delimeters[0];
	$vsb .= base64_encode($sendMID); 
	$vsb .= $delimeters[1];
	$vsb .= base64_encode($TID); 
	$vsb .= $delimeters[2];
	$vsb .= base64_encode($amount);
}elseif($TransactionType == 'AQ'){
	$vsb .= base64_encode($reference); 
	$vsb .= $delimeters[0];
	$vsb .= base64_encode($amount); 
	$vsb .= $delimeters[1];
	$vsb .= base64_encode($sendMID); 
	$vsb .= $delimeters[2];
	$vsb .= base64_encode($TransactionType);
}
$verify = hash('sha256', $vsb);
$verifyValue = base64_encode($verify);

if($TransactionType == 'AA'){
	$postdata = http_build_query(
		array(
			'Request Start' => '?',
			'Ver' => '1000',
			'RequestType' => 'TRAN',
			'MID' => $sendMID,
			'TransactionType' => $TransactionType,
			'Reference' => $reference,
			'Currency' => $currency,
			'Amount' => $amount,
			'CardNumber' => $encyptcc,
			'ExpiryYYMM' => $encyptexpiryYYMM,
			'CVC' => $encyptcvc,
			'AcquireType' => $acquireType,
			'ProductName' => $ProductName,
			'BuyerEmail' => $BuyerEmail,
			'BuyerName' => $BuyerName,
			'BuyerID' => $BuyerID,
			'BuyerIP' => $BuyerIP,
			'ServerIP' => $ServerIP,
			'SiteURL' => $SiteURL,
			'OutputType' => $OutputType,
			'VerifyValue' => $verifyValue,
			'Pares' => '?'
		)
	);
	var_dump($postdata);
}elseif($TransactionType == 'AC'){
	$postdata = http_build_query(
		array(
			'Request Start' => '?',
			'Ver' => '1000',
			'RequestType' => 'TRAN',
			'MID' => $sendMID,
			'TransactionType' => $TransactionType,
			'Reference' => $reference,
			'Currency' => $currency,
			'Amount' => $amount,
			'TID' => $TID,
			'AuthDate' => $AuthDate,
			'AuthCode' => $AuthCode,
			'PartialCancelCode' => $PartialCancelCode,
			'OutputType' => $OutputType,
			'VerifyValue' => $verifyValue
		)
	);

}elseif($TransactionType == 'AD'){
	$postdata = http_build_query(
		array(
			'Request Start' => '?',
			'Ver' => '1000',
			'RequestType' => 'TRAN',
			'MID' => $sendMID,
			'TransactionType' => $TransactionType,
			'Reference' => $reference,
			'Currency' => $currency,
			'Amount' => $amount,
			'TID' => $TID,
			'AuthDate' => $AuthDate,
			'OutputType' => $OutputType,
			'VerifyValue' => $verifyValue
		)
	);

}elseif($TransactionType == 'AQ'){
	$postdata = http_build_query(
		array(
			'Request Start' => '?',
			'Ver' => '1000',
			'RequestType' => 'TRAN',
			'MID' => $sendMID,
			'TransactionType' => $TransactionType,
			'Reference' => $reference,
			'TID' => $TID,
			'AuthDate' => $AuthDate,
			'AuthCode' => $AuthCode,
			'ServiceType' => 'A',
			'OutputType' => $OutputType,
			'VerifyValue' => $verifyValue
		)
	);

}elseif($TransactionType == 'AQ'){
	$postdata = http_build_query(
		array(
			'Request Start' => '?',
			'Ver' => '1000',
			'RequestType' => 'TRAN',
			'MID' => $sendMID,
			'TransactionType' => $TransactionType,
			'Reference' => $reference,
			'Currency' => $currency,
			'Amount' => $amount,
			'TID' => 'gompay001m01011506100921078314',
			'AuthDate' => '20150610',
			'AuthCode' => '338375',
			'OutputType' => $OutputType,
			'VerifyValue' => $verifyValue,
			'Pares' => '?'
		)
	);

}

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$xmlResponse = file_get_contents($callUrl, false, $context);

$xml = simplexml_load_string($xmlResponse);
var_dump($xml);
function encrypt($str, $key){
     $block = mcrypt_get_block_size('rijndael_128', 'ecb');
     $pad = $block - (strlen($str) % $block);
     $str .= str_repeat(chr($pad), $pad);
     return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}
function substring($string, $from, $to){
    return substr($string, $from, $to - $from);
}
//static String[] getDelimeters(String keyStr, int deliCnt, int byteSize, int startIndex) {
function getDelimeters($keyStr, $deliCnt, $byteSize, $startIndex){

		//String temp = keyStr + keyStr;
		$temp = $keyStr.$keyStr;
		//if(keyStr.length() < deliCnt*byteSize)
		if(strlen($keyStr) < ($deliCnt*$byteSize)){
		//	return getDelimeters(temp, deliCnt, byteSize, startIndex);
			return getDelimeters($temp, $deliCnt, $byteSize, $startIndex);
		}
		//String[] result = new String[deliCnt];
		$result = array();
		/*
		for(int i = 0 ; i < deliCnt ; i++) {
			if(i > 0)
				result[i] = temp.substring(startIndex+(byteSize*i), startIndex+(byteSize*(i+1)));
			else
				result[i] = temp.substring(startIndex, startIndex+byteSize);
		}
		*/
		$i = 0;
		while($i < $deliCnt) {
			if($i > 0)
				$result[$i] = substring($temp, $startIndex+($byteSize*$i), $startIndex+($byteSize*($i+1)));
			else
				$result[$i] = substring($temp, $startIndex, $startIndex+$byteSize);
			$i++;
		}
	//return result;
	return $result;
}

$jsonObject = array(
    "Ver" => $xml->Ver,
    "ResponseCode" => $xml->ResponseCode,
	"ResponseMessage" => $xml->ResponseMessage,
	"AuthCode" => $xml->AuthCode,
	"ResponseDate" => $xml->ResponseDate,
	"ResponseTime" => $xml->ResponseTime,
	"TID" => $xml->TID,
	"TransactionType" => $xml->TransactionType,
	"VerifyValue" => $xml->VerifyValue
	
);
print_r($jsonObject);

echo 'sent verifyValue: '.$verifyValue;

?>