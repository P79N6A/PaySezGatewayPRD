<?php
require_once('database_config.php');
$id = $_SESSION['iid'];

function getUserType($id){
global $db;
	$db->where("id",$id);
    $data = $db->getOne("users");
	return $data['user_type'];
}

function merchant_processors_mid(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
	}
	//values for checkboxes
	$is_active 					= (isset($is_active))?1:0;
	$download_from_platform 	= (isset($download_from_platform))?1:0;
	$validate_transaction_data 	= (isset($validate_transaction_data))?1:0;
	$is_for_moto 				= (isset($is_for_moto))?1:0;
	$auth 						= (isset($auth))?1:0;
	$capture 					= (isset($capture))?1:0;
	$sale 						= (isset($sale))?1:0;
	$refund 					= (isset($refund))?1:0;
	$void 						= (isset($void))?1:0;
	$auto_capture 				= (isset($auto_capture))?1:0;
	
	$vars = array(
					'merchant_id' 				=>	$merchant_id,
					'processor_id' 				=>	$processor_id,
					'mid' 						=>	$mid,
					'routing' 					=>	$routing,
					'rebill_routing' 			=>	$rebill_routing,
					'is_active' 				=>	$is_active,
					'start_date' 				=>	$start_date,
					'currency' 					=>	$currency,
					'username' 					=>	$username,
					'password' 					=>	$password,
					'gateway_id' 				=>	$gateway_id,
					'download_from_platform' 	=>	$download_from_platform,
					'validate_transaction_data' =>	$validate_transaction_data,
					'notes' 					=>	$notes,
					'descriptor' 				=>	$descriptor,
					'is_for_moto' 				=>	$is_for_moto,
					'api_url_production'		=> 	$url_prod,
					'api_url_testing'			=> 	$url_test,
					'api_key'					=>	$api_key,
					'sdquery_un' 				=>	$sdquery_un,
					'sdquery_pwd' 				=>	$sdquery_pwd,
					'auth' 						=>	$auth,
					'capture' 					=>	$capture,
					'sale' 						=>	$sale,
					'refund' 					=>	$refund,
					'void' 						=>	$void,
					'auto_capture' 				=>	$auto_capture,
					'delay_hours' 				=>	$delay_hours
				);
				
				
	$db->where("merchant_id", $merchant_id);
	$db->where("processor_id", $processor_id);
	$db->where("gateway_id", $gateway_id);
	$lastid = $db->getone("merchant_processors_mid");
	
	if ($db->count > 0){
		$db->where('id',$lastid['id']);
		if($db->update('merchant_processors_mid', $vars))
		{
			return '<div class="alert alert-success"  data-animation="fadeIn">Succesfully Updated</div>';
		} else {
			return '<div class="alert alert-alert"  data-animation="fadeIn">Error while updating</div>';
		}	
	}else{
		
			if($db->insert('merchant_processors_mid', $vars))
		{
			return '<div class="alert alert-success"  data-animation="fadeIn">Succesfully Assigned</div>';
		} else {
			return '<div class="alert alert-alert"  data-animation="fadeIn">Error while assigning</div>';
		}
	}
}

$usertype = getUserType($id);
	
if($usertype == 1) {
	echo merchant_processors_mid();
}

?>