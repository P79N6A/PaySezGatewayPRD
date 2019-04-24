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
//filter post
if(isset($_POST['t_id']))
{
	foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
	}

	$db->join("merchants", "merchants.mer_map_id = t.merchant_id", "LEFT");
	$db->where("t.id_transaction_id",$t_id);
	$trann = $db->getOne("transactions t");
	
	
	
	//get transaction info
	$db->join("actions", "actions.id_transaction_id = t.id_transaction_id", "LEFT");
	$db->where("t.id_transaction_id",$t_id);
	$trans = $db->getOne("transactions t");
	
	$cc_number 	= $trans["cc_number"];
	$cc_hash 	= $trans["cc_hash"];
	$cc = mc_decrypt($cc_number, $cc_hash);
	$cc_last4 = "******".substr($cc, -4);
	$cc_type = getCCType($cc);
	
	$data = Array ();
	$data['processor_id'] 			= $trans['processor_id'];
	$data['m_id'] 					= $trann['idmerchants'];
	$data['reason_code'] 			= $cb_reason;
	//$data['account_id'] 			= $_SESSION['iid'];
	$data['cb_id'] 					= $t_request_id;
	$data['cb_date'] 				= date("Y-m-d"); 
	$data['cb_amount'] 				= $cb_amount;
	$data['cc_type'] 				= $cc_type;
	$data['ccnum'] 					= $cc_last4;
	$data['first_name'] 			= $trans['first_name'];
	$data['last_name'] 				= $trans['last_name'];
	$data['sale_date'] 				= date('Y-m-d', strtotime($trans['transaction_date']));
	$data['sale_value'] 			= $trans['amount'];
	$cut 							= $trans["platform_id"];
	$sale_transaction_id 			= preg_replace('/'.$cut.'$/', '', $t_id);
	$data['sale_transaction_id'] 	= $sale_transaction_id;
	$data['user'] 					= $_SESSION['iid'];
	$data['response_date'] 			= date('Y-m-d', strtotime($cb_response_date));
	//$data['response_text'] 		= $cb_response_text;
	$data['status'] 				= $cb_status;
	$data['dispute_result'] 		= $cb_dispute_result;
	$data['update_date'] 			= date('Y-m-d', strtotime($cb_update_date));
	$data['charged_date'] 			= date('Y-m-d', strtotime($cb_charged_date));
	$data['cb_type'] 				= $cb_request_type;
	$data['cb_comment'] 			= $cb_comment;
	$data['id_transaction_id'] 		= $trans['id_transaction_id'];	

	
	$cb_id = $db->insert ('chargebacks', $data);
	
	
	if ($cb_id)
	{
		//response correspondance
		if($cb_new_response != '') {
			$newresponse = Array(	"type" => "merchant",
									"response_text" => $cb_new_response,
									"cb_id" => $cb_id
			);
			$db->insert('cb_responses', $newresponse);
		}
		echo $cb_id;
	}
	else
	{
		echo '<div class="alert alert-danger"  data-animation="fadeIn">Error' . $db->getLastError() . ' </div>';
	}	

	

}
?>