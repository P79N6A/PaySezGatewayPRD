<?php
		$callUrl = "https://tpay.smilepay.co.kr/trans/cardTrans.jsp";
		//String merchantKey = "ImgZK3xcQtuUYY4vwWQO3PfhIat6OdAtIyH9EYgcpJ0x0M9yppgH26JywLvrmHg+98zUVp5vcGbfo3ugl7VOWw==";
		//String sendMID = "mcajpa392m";	//SECURE_TYPE A
		$merchantKey = "lkviD+J6o1+I/iFlxnRj3Xo+znBOmuo6G4gVCASJAaP65i8w0FiV24c/4PXkY2DEuPuk8bFhrZQ4HvIGijH3Zg==";
		$sendMID = "gompay001m";	//SECURE_TYPE A
		
		$reference = "1004";
		$transactionType = "AA";
		$acquireType = "1";
		$currency ="USD";
		$amount = "9900";
		$cardNum = "4907639999990022";
		$expiryYYMM = "1512";
		$cvc = "029";
		$secureType = "A";
		$ProductName ="winnie";
		$buyerEmail ="wkskvk@naver.com";
		$buyerName ="kim-urim";
		$buyerIP = "111.111.111.111";
		$buyerID = "buyer";
		$verify = "";
		$resType = "X";
//int deliIdx = (Integer.parseInt(reference.substring(reference.length()-4, reference.length())) + Integer.parseInt(amount.replaceAll("\\.", "").replaceAll(",", ""))) % 86;
$deliIdx = (int)(substring($reference, -4, 4) + str_replace('.', '', $amount)) % 86;
$deliIdx2 = (int)(substring($reference, -4, 4) + str_replace(',', '', str_replace('.', '', $amount))) % 4;
if($deliIdx2 == 0){
	//var_dump($deliIdx2);
	$keyData = substring($merchantKey, 0, 16);
}else{
//var_dump($deliIdx2);	
	$keyData = substring($merchantKey, (16*$deliIdx2), (16*$deliIdx2+16));
}		
//var_dump(16*$deliIdx2);
//var_dump(16*$deliIdx2+16);
//var_dump(substring($merchantKey, 0, 10));
$encyptcc = encrypt($cardNum, $keyData);
//var_dump($encyptcc);
//String[] delimeters = getDelimeters(merchantKey.substring(0, merchantKey.length()-2), 4, 3, deliIdx);
$delimeters = getDelimeters(substring($merchantKey, 0, strlen($merchantKey)-2), 4, 3, (int)$deliIdx);

$vsb ='';
//---THIS---
//vsb.append(new String(Base64.encodeBase64(reference.getBytes()))).append(delimeters[0]);
$vsb .= base64_encode($reference); $vsb .= $delimeters[0];
//vsb.append(new String(Base64.encodeBase64(amount.getBytes()))).append(delimeters[1]);
$vsb .= base64_encode($amount); $vsb .= $delimeters[1];
//vsb.append(new String(Base64.encodeBase64(sendMID.getBytes()))).append(delimeters[2]);
$vsb .= base64_encode($sendMID); $vsb .= $delimeters[2];
$vsb .= base64_encode($acquireType);
/*
//---OR-------------
//vsb.append(new String(Base64.encodeBase64(reference.getBytes()))).append(delimeters[0]);
$vsb .= base64_encode(unpack('H*',$reference).$delimeters[0]);
echo '----';
echo $vsb;
//vsb.append(new String(Base64.encodeBase64(amount.getBytes()))).append(delimeters[1]);
$vsb .= base64_encode(unpack('H*',$amount).$delimeters[1]);
echo '----';
echo $vsb;
//vsb.append(new String(Base64.encodeBase64(sendMID.getBytes()))).append(delimeters[2]);
$vsb .= base64_encode(unpack('H*',$sendMID).$delimeters[2]);
echo '----';
echo $vsb;
echo '----';
*/
//var_dump($delimeters);
//vsb.append(new String(Base64.encodeBase64(acquireType.getBytes())));
//$vsb .= base64_encode($acquireType); //will always be 'MzE='
$verify = hash('sha256', $vsb);
$verifyValue = base64_encode($verify);
//echo 'Final verifyValue=:   '; var_dump($verifyValue);

//wrote below to replace substring function used in java notice the subtraction)
function substring($string, $from, $to){
    return substr($string, $from, $to - $from);
}
//static String[] getDelimeters(String keyStr, int deliCnt, int byteSize, int startIndex) {
function getDelimeters($keyStr, $deliCnt, $byteSize, $startIndex){

		//String temp = keyStr + keyStr;
		$temp = $keyStr.$keyStr;
		//var_dump($keyStr);
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
function encrypt($str, $key){
     $block = mcrypt_get_block_size('rijndael_128', 'ecb');
     $pad = $block - (strlen($str) % $block);
     $str .= str_repeat(chr($pad), $pad);
     return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}
/*
//public static String arsClientEncrypt(String keyString, String Data, String reference, String amount) throws Exception {
function arsClientEncrypt($keyString, $Data, $reference, $amount){

		$keyData = '';//new byte[1];
		
		$deliIdx = (Integer.parseInt(reference.substring(reference.length()-4, reference.length()))
				+ Integer.parseInt(amount.replaceAll("\\.", "").replaceAll(",", ""))) % 4;
		
		$keyData = $deliIdx==0?keyString.substring(0, 16).getBytes():keyString.substring(16*$deliIdx, 16*$deliIdx+16).getBytes();
		
		Cipher cipher = Cipher.getInstance("AES/ECB/PKCS5Padding");
		SecretKeySpec keySpec = new SecretKeySpec(keyData, "AES");
		cipher.init(Cipher.ENCRYPT_MODE, keySpec);
		$cipherbyte = cipher.doFinal(Data.getBytes());
		
		return base64_encode($cipherbyte));

}


//echo 'delimeters=:    ';
//var_dump($delimeters);

?>