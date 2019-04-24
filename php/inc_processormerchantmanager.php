<?php
require_once('database_config.php');
require_once('common_functions.php');
$iid = $_SESSION['iid'];
//filter post
$db->orderBy("processor_name","asc");
	$processors = $db->get("processors");
	//$db->where("p_id",$p_id);
	$db->orderBy("merchant_name","asc");
	$merchants = $db->get("merchants");
if($usertype == 1){
	//var_dump(getAgentsAffiliateofAdmin());die();
	$MerchantsofUser = getMerchantsofAdmin();
	$AgentsofUser = getAgentsofAdmin();
	$AgentsAffiliateofAdmin = array();
	$AffiliationofAgents = array();
	$AgentsAffiliateofAdmin = getAgentsAffiliateofAdmin();
	$MerchantsofAdmin = getMerchantsofAdmin();
	$AgentsofUsercolNames0 = array_keys(reset($AgentsofUser));
	$AgentsAffiliateofAdmincolNames1 = array_keys(reset($AgentsAffiliateofAdmin));
	$AffiliationofAgents = getAffiliationofAgents($userAgentId);
	$AffiliationofAgentscolNames1 = array_keys(reset($AffiliationofAgents));
//var_dump($MerchantsofAdmin);
}else{
	if($userMerchantId != NULL){
	//not tested
		$MerchantsofUser = getUsersofmerchant($userMerchantId);
	}
	//var_dump($MerchantsofUser);
	if($userAgentId != NULL){
		$AgentsofUser = getAgentsofUser($userAgentId);
		$AffiliationofAgents = getAffiliationofAgents($userAgentId);
	}
}
	//TESTING AREA//
//$_POST['agent_id'] = '42';	
//$_POST['merchant_id'] = '1';
//$_POST['processor_id'] = '63';
//$test = agent_acuity_fees();
//var_dump($test);
	//END TESTING AREA//
if(isset($_POST['pgsearch'])){	
//filter post
	$cols = Array ("distinct p_id processor_id", "p.processor_name processor_name");
	$db->join("merchant_trans_permissions m", "m.processor_id=p.p_id", "left");
	$ids = $db->subQuery ();
	$ids->where ("merchant_id", $_POST['merchant_id']);
	$ids->get ("merchant_trans_permissions", null, "processor_id");
	$db->where('p.gateway_or_bank', 1);
	$db->where ("p.p_id", $ids, 'not in');
	$db->orderBy("processor_name","asc");
	$mprocessors = $db->get("processors p", null, $cols);
	//echo "Last executed query was ". $db->getLastQuery();
//var_dump($mprocessors);
	$cols = Array ("distinct p.p_id processor_id", "p.processor_name processor_name");
	$db->join("merchant_trans_permissions m", "m.processor_id=p.p_id", "left");
	$ids = $db->subQuery ();
	$ids->where ("merchant_id", $_POST['merchant_id']);
	$ids->get ("merchant_trans_permissions", null, "processor_id");
	$db->where('p.gateway_or_bank', 0);
	$db->where ("p.p_id", $ids, 'not in');
	$db->orderBy("processor_name","asc");
	$mgateways = $db->get("processors p", null, $cols);
	//echo "Last executed query was ". $db->getLastQuery();
}
//functions created by greg for all tables that have merchant/processor_name
//below is for creds with just merchant and processor id//
function merchant_trans_permissions(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$vars = array(
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'auth' =>	$auth,
					'capture' =>	$capture,
					'sale' =>	$sale,
					'refund' =>	$refund,
					'void' =>	$void,
					'auto_capture' =>	$auto_capture,
					'delay_hours' =>	$delay_hours
				);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$lastid = $db->getone("merchant_trans_permissions");
	if ($db->count > 0){
		$db->where('idmerchant_trans_permissions',$lastid['idmerchant_trans_permissions']);
		$db->update('merchant_trans_permissions', $vars);
		return 'done';
	}else{
		$db->insert('merchant_trans_permissions', $var);
		return 'done';	
	}
}

//below is for creds with just merchant, gateway, and processor ids//
function merchant_processors_mid(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$vars = array(
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'mid' =>	$mid,
					'routing' =>	$routing,
					'rebill_routing' =>	$rebill_routing,
					'is_active' =>	$is_active,
					'affiliate' =>	$affiliate,
					'bank_id' =>	$bank_id,
					'start_date' =>	$start_date,
					'currency' =>	$currency,
					'username' =>	$username,
					'password' =>	$password,
					'gateway_id' =>	$gateway_id,
					'download_from_platform' =>	$download_from_platform,
					'mpc_id' =>	$mpc_id,
					'validate_transaction_data' =>	$validate_transaction_data,
					'notes' =>	$notes,
					'descriptor' =>	$descriptor,
					'is_for_moto' =>	$is_for_moto,
					'sdquery_un' =>	$sdquery_un,
					'sdquery_pwd' =>	$sdquery_pwd
				);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$lastid = $db->getone("merchant_processors_mid");
	if ($db->count > 0){
		$db->where('id',$lastid['id']);
		$db->update('merchant_processors_mid', $vars);
		return 'done';
	}else{
		$db->insert('merchant_processors_mid', $var);
		return 'done';	
	}
}

function merchant_processor_creds(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$vars = array(
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'mid' =>	$mid,
					'uid' =>	$uid,
					'pwd' =>	$pwd,
					'gateway_id' =>	$gateway_id,
					'mpm_id' =>	$mpm_id,
					'is_for_moto' =>	$is_for_moto
				);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$lastid = $db->getone("merchant_processor_creds");
	if ($db->count > 0){
		$db->where('id',$lastid['idmerchant_processor_creds']);
		$db->update('merchant_processor_creds', $vars);
		return 'done';
	}else{
		$db->insert('merchant_processor_creds', $var);
		return 'done';	
	}
}

//BELOW IS FOR FEES//
function agent_acuity_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("agent_acuity_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idagent_acuity_fees',$lastid['idagent_acuity_fees']);
		$db->update('agent_acuity_fees', $closeold);
	}
	$vars = array(
					'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'setup_fee' =>	$setup_fee,
					'monthly_fee' =>	$monthly_fee,
					'transaction_fee' =>	$transaction_fee,
					'rebill_transaction_fee' =>	$rebill_transaction_fee,
					'effective_date' =>	$effective_date
				);
	$db->insert('agent_acuity_fees', $var);
	return 'done';	
}

function agent_bank_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("agent_bank_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idagent_bank_fees',$lastid['idagent_bank_fees']);
		$db->update('agent_bank_fees', $closeold);
	}
	$vars = array(
					'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'mid' =>	$mid,
					'transaction_fee' =>	$transaction_fee,
					'authorization_fee' =>	$authorization_fee,
					'capture_fee' =>	$capture_fee,
					'sale_fee' =>	$sale_fee,
					'decline_fee' =>	$decline_fee,
					'refund_fee' =>	$refund_fee,
					'cb_fee_1' =>	$cb_fee_1,
					'cb_fee_2' =>	$cb_fee_2,
					'cb_threshold' =>	$cb_threshold,
					'discount_rate' =>	$discount_rate,
					'avs_premium' =>	$avs_premium,
					'cvv_premium' =>	$cvv_premium,
					'interregional_premium' =>	$interregional_premium,
					'wire_fee' =>	$wire_fee,
					'reserve_rate' =>	$reserve_rate,
					'reserve_period_months' =>	$reserve_period_months,
					'initial_reserve' =>	$initial_reserve,
					'setup_fee' =>	$setup_fee,
					'monthly_fees' =>	$monthly_fees,
					'effective_date' =>	$effective_date,
					'miscsetup_name' =>	$miscsetup_name,
					'miscsetup_fee' =>	$miscsetup_fee,
					'miscmonthly_one_name' =>	$miscmonthly_one_name,
					'miscmonthly_one_fee' =>	$miscmonthly_one_fee,
					'miscmonthly_two_name' =>	$miscmonthly_two_name,
					'miscmonthly_two_fee' =>	$miscmonthly_two_fee,
					'misctrans_one_name' =>	$misctrans_one_name,
					'misctrans_one_fee' =>	$misctrans_one_fee,
					'misctrans_two_name' =>	$misctrans_two_name,
					'misctrans_two_fee' =>	$misctrans_two_fee
				);
	$db->insert('agent_bank_fees', $var);
	return 'done';	
}

function agent_gateway_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("agent_gateway_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idagent_gateway_fees',$lastid['idagent_gateway_fees']);
		$db->update('agent_gateway_fees', $closeold);
	}
	$vars = array(
					'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'setup_fee' =>	$setup_fee,
					'monthly_fee' =>	$monthly_fee,
					'transaction_fee' =>	$transaction_fee,
					'effective_date' =>	$effective_date
				);
	$db->insert('agent_gateway_fees', $var);
	return 'done';	
}
	
function merchant_acuity_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("merchant_acuity_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idmerchant_acuity_fees',$lastid['idmerchant_acuity_fees']);
		$db->update('merchant_acuity_fees', $closeold);
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'setup_fee' =>	$setup_fee,
					'monthly_fee' =>	$monthly_fee,
					'transaction_fee' =>	$transaction_fee,
					'rebill_transaction_fee' =>	$rebill_transaction_fee,
					'effective_date' =>	$effective_date
				);
	$db->insert('merchant_acuity_fees', $var);
	return 'done';	
}

function merchant_bank_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("merchant_bank_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idmerchant_bank_fees',$lastid['idmerchant_bank_fees']);
		$db->update('merchant_bank_fees', $closeold);
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'mid' =>	$mid,
					'transaction_fee' =>	$transaction_fee,
					'authorization_fee' =>	$authorization_fee,
					'capture_fee' =>	$capture_fee,
					'sale_fee' =>	$sale_fee,
					'decline_fee' =>	$decline_fee,
					'refund_fee' =>	$refund_fee,
					'cb_fee_1' =>	$cb_fee_1,
					'cb_fee_2' =>	$cb_fee_2,
					'cb_threshold' =>	$cb_threshold,
					'discount_rate' =>	$discount_rate,
					'avs_premium' =>	$avs_premium,
					'cvv_premium' =>	$cvv_premium,
					'interregional_premium' =>	$interregional_premium,
					'wire_fee' =>	$wire_fee,
					'reserve_rate' =>	$reserve_rate,
					'reserve_period_months' =>	$reserve_period_months,
					'initial_reserve' =>	$initial_reserve,
					'setup_fee' =>	$setup_fee,
					'monthly_fees' =>	$monthly_fees,
					'effective_date' =>	$effective_date,
					'miscsetup_name' =>	$miscsetup_name,
					'miscsetup_fee' =>	$miscsetup_fee,
					'miscmonthly_one_name' =>	$miscmonthly_one_name,
					'miscmonthly_one_fee' =>	$miscmonthly_one_fee,
					'miscmonthly_two_name' =>	$miscmonthly_two_name,
					'miscmonthly_two_fee' =>	$miscmonthly_two_fee,
					'misctrans_one_name' =>	$misctrans_one_name,
					'misctrans_one_fee' =>	$misctrans_one_fee,
					'misctrans_two_name' =>	$misctrans_two_name,
					'misctrans_two_fee' =>	$misctrans_two_fee
				);
	$db->insert('merchant_bank_fees', $var);
	return 'done';	
}

function merchant_bill_cycles(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("merchant_bill_cycles");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idmerchant_bill_cycles',$lastid['idmerchant_bill_cycles']);
		$db->update('merchant_bill_cycles', $closeold);
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'setup_fee' =>	$setup_fee,
					'monthly_fee' =>	$monthly_fee,
					'transaction_fee' =>	$transaction_fee,
					'rebill_transaction_fee' =>	$rebill_transaction_fee,
					'effective_date' =>	$effective_date
				);
	$db->insert('merchant_bill_cycles', $var);
	return 'done';	
}

function merchant_gateway_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("merchant_gateway_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idmerchant_gateway_fees',$lastid['idmerchant_gateway_fees']);
		$db->update('merchant_gateway_fees', $closeold);
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'setup_fee' =>	$setup_fee,
					'monthly_fee' =>	$monthly_fee,
					'transaction_fee' =>	$transaction_fee,
					'effective_date' =>	$effective_date
				);
	$db->insert('merchant_gateway_fees', $var);
	return 'done';	
}

function bank_fees(){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("bank_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idbank_fees',$lastid['idbank_fees']);
		$db->update('bank_fees', $closeold);
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$merchant_id,
					'processor_id' =>	$processor_id,
					'mid' =>	$mid,
					'transaction_fee' =>	$transaction_fee,
					'authorization_fee' =>	$authorization_fee,
					'capture_fee' =>	$capture_fee,
					'sale_fee' =>	$sale_fee,
					'decline_fee' =>	$decline_fee,
					'refund_fee' =>	$refund_fee,
					'cb_fee_1' =>	$cb_fee_1,
					'cb_fee_2' =>	$cb_fee_2,
					'cb_threshold' =>	$cb_threshold,
					'discount_rate' =>	$discount_rate,
					'avs_premium' =>	$avs_premium,
					'cvv_premium' =>	$cvv_premium,
					'interregional_premium' =>	$interregional_premium,
					'wire_fee' =>	$wire_fee,
					'reserve_rate' =>	$reserve_rate,
					'reserve_period_months' =>	$reserve_period_months,
					'initial_reserve' =>	$initial_reserve,
					'setup_fee' =>	$setup_fee,
					'monthly_fees' =>	$monthly_fees,
					'effective_date' =>	$effective_date,
					'miscsetup_name' =>	$miscsetup_name,
					'miscsetup_fee' =>	$miscsetup_fee,
					'miscmonthly_one_name' =>	$miscmonthly_one_name,
					'miscmonthly_one_fee' =>	$miscmonthly_one_fee,
					'miscmonthly_two_name' =>	$miscmonthly_two_name,
					'miscmonthly_two_fee' =>	$miscmonthly_two_fee,
					'misctrans_one_name' =>	$misctrans_one_name,
					'misctrans_one_fee' =>	$misctrans_one_fee,
					'misctrans_two_name' =>	$misctrans_two_name,
					'misctrans_two_fee' =>	$misctrans_two_fee
				);
	$db->insert('bank_fees', $var);
	return 'done';	
}
	
?>