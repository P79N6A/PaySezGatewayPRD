<?php
require_once('database_config.php');
// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}
//Credit Card Type
function getCCType($CCNumber)
{
	$creditcardTypes = array(
						array('Name'=>'American Express','cardLength'=>array(15),'cardPrefix'=>array('34', '37'))
						,array('Name'=>'Maestro','cardLength'=>array(12, 13, 14, 15, 16, 17, 18, 19),'cardPrefix'=>array('5018', '5020', '5038', '6304', '6759', '6761', '6763'))
						,array('Name'=>'Mastercard','cardLength'=>array(16),'cardPrefix'=>array('51', '52', '53', '54', '55'))
						,array('Name'=>'Visa','cardLength'=>array(13,16),'cardPrefix'=>array('4'))
						,array('Name'=>'JCB','cardLength'=>array(16),'cardPrefix'=>array('3528', '3529', '353', '354', '355', '356', '357', '358'))
						,array('Name'=>'Discover','cardLength'=>array(16),'cardPrefix'=>array('6011', '622126', '622127', '622128', '622129', '62213',
													'62214', '62215', '62216', '62217', '62218', '62219',
													'6222', '6223', '6224', '6225', '6226', '6227', '6228',
													'62290', '62291', '622920', '622921', '622922', '622923',
													'622924', '622925', '644', '645', '646', '647', '648',
													'649', '65'))
						,array('Name'=>'Solo','cardLength'=>array(16, 18, 19),'cardPrefix'=>array('6334', '6767'))
						,array('Name'=>'Unionpay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('622126', '622127', '622128', '622129', '62213', '62214',
													'62215', '62216', '62217', '62218', '62219', '6222', '6223',
													'6224', '6225', '6226', '6227', '6228', '62290', '62291',
													'622920', '622921', '622922', '622923', '622924', '622925'))
						,array('Name'=>'Diners Club','cardLength'=>array(14),'cardPrefix'=>array('300', '301', '302', '303', '304', '305', '36'))
						,array('Name'=>'Diners Club US','cardLength'=>array(16),'cardPrefix'=>array('54', '55'))
						,array('Name'=>'Diners Club Carte Blanche','cardLength'=>array(14),'cardPrefix'=>array('300','305'))
						,array('Name'=>'Laser','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6304', '6706', '6771', '6709'))
	);  
	$CCNumber= trim($CCNumber);
	$type='Unknown';
	foreach ($creditcardTypes as $card){
		if (! in_array(strlen($CCNumber),$card['cardLength'])) {
			continue;
		}
		$prefixes = '/^('.implode('|',$card['cardPrefix']).')/';            
		if(preg_match($prefixes,$CCNumber) == 1 ){
			$type= $card['Name'];
			break;
		}
	}
	return $type;
}

$iid = $_SESSION['iid'];
if(isset($_GET['t_id'])){
	
	$t_id = $_GET['t_id'];

	//transaction info	
	$db->join("actions", "actions.id_transaction_id = t.id_transaction_id", "LEFT");
	$db->where("t.id_transaction_id",$t_id);
	$trans = $db->getOne("transactions t");
	
	//merchant
	$m_id = $trans["merchant_id"];
	$db->where("idmerchants",$m_id);
	$data = $db->getOne("merchants");
	$merchantname = $data['merchant_name'];
	
	//get api key
	$db->where("merchant_id",$m_id);
	$db->where("processor_id",$trans["processor_id"]);
	$db->where("gateway_id",$trans["platform_id"]);
	$data = $db->getOne("merchant_processors_mid");
	$api_key = $data['api_key'];
	//status
	$cb_statuses = $db->get("cb_stati");
	
	//cc info and encrypt
	$cc_number 	= $trans["cc_number"];
	$cc_hash 	= $trans["cc_hash"];
	$cc = mc_decrypt($cc_number, $cc_hash);
	$cc_last4 = "******".substr($cc, -4);
	$cc_type = getCCType($cc);
	$cc_exp = mc_decrypt($trans["cc_exp"], $cc_hash);
	
	//chargeback info
	$is_cb = false;
	$cut = $trans["platform_id"];
	$sale_transaction_id = preg_replace('/'.$cut.'$/', '', $t_id);
	$db->where("sale_transaction_id",$sale_transaction_id);
	$db->join("cb_stati", "chargebacks.status = cb_stati.cb_stati_id", "LEFT");
	$cb = $db->getOne("chargebacks");

	if($cb)
	{
		$is_cb = true;	
		$cb_id = $cb["idchargebacks"];
		if(!headers_sent()){
		exit(header( 'Location: http://'.$_SERVER['HTTP_HOST'].'/chargeback.php?cb_id='.$cb_id ));	
		}
		//processor
		$p_id = $cb["processor_id"];
		$db->where("p_id",$p_id);
		$data = $db->getOne("processors");
		$processorsname = $data['processor_name'];
	}
}
elseif(isset($_GET['cb_id']))
{
	$cb_id = $_GET['cb_id'];
	$db->where("idchargebacks",$cb_id);
	$cb = $db->get("chargebacks");
	
	//merchant
	$m_id = $cb[0]["m_id"];
	$db->where("idmerchants",$m_id);
	$data = $db->getOne("merchants");
	$merchantname = $data['merchant_name'];
	
	//processor
	$p_id = $cb[0]["processor_id"];
	$db->where("p_id",$p_id);
	$data = $db->getOne("processors");
	$processorsname = $data['processor_name'];
	
	//reason
	$reason_code = $cb[0]["reason_code"];
	$db->where("code",$reason_code);
	$data = $db->getOne("reason_code_text");
	$reason = $reason_code." - ".$data['response_explanation'];
	
	//status
	$cb_statuses = $db->get("cb_stati");
} else {
	$db->where("id",$iid);
	$data = $db->getOne("users");
	$user_type = $data['user_type'];

	$query = "SELECT DISTINCT(idmerchants), merchant_name, users.agent_id FROM users
			  INNER JOIN merchants ON users.agent_id = merchants.affiliate_id";
	if($user_type != 1) {
		$query .= " WHERE users.id = ".$iid;	
	}
	$agent_merchants = $db->rawQuery($query);	
}
						
?>