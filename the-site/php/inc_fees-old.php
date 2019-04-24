<?php
require_once('database_config.php');
require_once('common_functions.php');
$userdata = getUserdata($_SESSION['iid']);
$userMerchantId = $userdata["merchant_id"];
$userAgentId = $userdata["agent_id"];

foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
	}

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
if(isset($_POST['feesearch'])){
	$result_agent_acuity_fees = select_agent_acuity_fees($_POST['agent_id'],$_POST['merchant_id'],$_POST['processor_id']);
	//displaysearchresults();
	//var_dump($_POST);
	echo $result_agent_acuity_fees;
	//die();
	
}
	//TESTING AREA//
//$_POST['agent_id'] = '42';	
//$_POST['merchant_id'] = '1';
//$_POST['processor_id'] = '63';
//$test = agent_acuity_fees();
//var_dump($test);
	//END TESTING AREA//
	
//after selecting a merchant show processor and gateway dropdowns using code below:
if(isset($_POST['pgsearch'])){	
//filter post
	$cols = Array ("p.p_id processor_id", "p.processor_name processor_name");
	$db->join("processors p", "m.processor_id=p.p_id", "left");
	$db->where('m.merchant_id', $_POST['merchant_id']);
	$db->where('p.gateway_or_bank', 1);
	$db->orderBy("processor_name","asc");
	$mprocessors = $db->get("merchant_trans_permissions m", null, $cols);
//var_dump($mprocessors);
	$cols = Array ("p.p_id processor_id", "p.processor_name processor_name");
	$db->join("processors p", "m.processor_id=p.p_id", "left");
	$db->where('m.merchant_id', $_POST['merchant_id']);
	$db->where('p.gateway_or_bank', 0);
	$db->orderBy("processor_name","asc");
	$mgateways = $db->get("merchant_trans_permissions m", null, $cols);
}

//functions created by greg for all tables that have merchant/processor_name
//BELOW IS FOR FEES//
function select_agent_acuity_fees($agent_id,$merchant_id,$processor_id){
	global $db;
	$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$agent_acuity_fee = $db->getOne("agent_acuity_fees");
	if ($db->count > 0){
		$result = '<h5>Agent Acuity Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective Date</th>
									<th>Setup Fee</th>
                                    <th>Monthly Fee</th>
                                    <th>Transaction Fee</th>
                                    <th>Rebill Transaction Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>'.$agent_acuity_fee["effective_date"].'</td>
									<td>'.$agent_acuity_fee["setup_fee"].'</td>
                                    <td>'.$agent_acuity_fee["monthly_fee"].'</td>
                                    <td>'.$agent_acuity_fee["transaction_fee"].'</td>
                                    <td>'.$agent_acuity_fee["rebill_transaction_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
}
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
function select_agent_bank_fees($agent_id,$merchant_id,$processor_id){
	global $db;
	$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$agent_bank_fee = $db->getOne("agent_bank_fees");
	if ($db->count > 0){
		$result = '<h5>Agent Bank Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective date</th>
                                    <th>MID</th>
                                    <th>Transaction Fee</th>
                                    <th>Authorization Fee</th>
									<th>Capture Fee</th>
									<th>Sale Fee</th>
                                    <th>Decline Fee</th>
                                    <th>Refund Fee</th>
                                    <th>CB Fee 1</th>
									<th>CB Fee 2</th>
									<th>CB Threshold</th>
                                    <th>Discount Rate</th>
                                    <th>AVS Premium</th>
                                    <th>CVV Premium</th>
									<th>Interregional Premium</th>
									<th>wire Fee</th>
                                    <th>Reserve Rate</th>
                                    <th>Reserve Period Months</th>
                                    <th>Initial Reserve</th>
									<th>Setup Fee</th>
									<th>Monthly Fees</th>
                                    <th>Miscsetup Name</th>
                                    <th>Miscsetup Fee</th>
                                    <th>Miscmonthly One Name</th>
									<th>Miscmonthly One Fee</th>
									<th>Miscmonthly Two Name</th>
                                    <th>Miscmonthly Two Fee</th>
                                    <th>Misctrans One Name</th>
                                    <th>Misctrans One Fee</th>
									<th>Misctrans Two Name</th>
									<th>Misctrans Two Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
									<td>'.$agent_bank_fee["effective_date"].'</td>
                                    <td>'.$agent_bank_fee["mid"].'</td>
									<td>'.$agent_bank_fee["transaction_fee"].'</td>
                                    <td>'.$agent_bank_fee["authorization_fee"].'</td>
                                    <td>'.$agent_bank_fee["capture_fee"].'</td>
                                    <td>'.$agent_bank_fee["sale_fee"].'</td>
									<td>'.$agent_bank_fee["decline_fee"].'</td>
									<td>'.$agent_bank_fee["refund_fee"].'</td>
									<td>'.$agent_bank_fee["cb_fee_1"].'</td>
									<td>'.$agent_bank_fee["cb_fee_2"].'</td>
									<td>'.$agent_bank_fee["cb_threshold"].'</td>
									<td>'.$agent_bank_fee["discount_rate"].'</td>
									<td>'.$agent_bank_fee["avs_premium"].'</td>
									<td>'.$agent_bank_fee["cvv_premium"].'</td>
									<td>'.$agent_bank_fee["interregional_premium"].'</td>
									<td>'.$agent_bank_fee["wire_fee"].'</td>
									<td>'.$agent_bank_fee["reserve_rate"].'</td>
									<td>'.$agent_bank_fee["reserve_period_months"].'</td>
									<td>'.$agent_bank_fee["initial_reserve"].'</td>
									<td>'.$agent_bank_fee["setup_fee"].'</td>
									<td>'.$agent_bank_fee["monthly_fees"].'</td>
									<td>'.$agent_bank_fee["miscsetup_name"].'</td>
									<td>'.$agent_bank_fee["miscsetup_fee"].'</td>
									<td>'.$agent_bank_fee["miscmonthly_one_name"].'</td>
									<td>'.$agent_bank_fee["miscmonthly_one_fee"].'</td>
									<td>'.$agent_bank_fee["miscmonthly_two_name"].'</td>
									<td>'.$agent_bank_fee["miscmonthly_two_fee"].'</td>
									<td>'.$agent_bank_fee["misctrans_one_name"].'</td>
									<td>'.$agent_bank_fee["misctrans_one_fee"].'</td>
									<td>'.$agent_bank_fee["misctrans_two_name"].'</td>
									<td>'.$agent_bank_fee["misctrans_two_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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
function select_agent_gateway_fees($agent_id,$merchant_id,$processor_id){
	global $db;
	$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$agent_gateway_fee = $db->getOne("agent_gateway_fees");
	if ($db->count > 0){
		$result = '<h5>Agent Gateway Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective Date</th>
									<th>Setup Fee</th>
                                    <th>Monthly Fee</th>
                                    <th>Transaction Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>'.$agent_gateway_fee["effective_date"].'</td>
									<td>'.$agent_gateway_fee["setup_fee"].'</td>
                                    <td>'.$agent_gateway_fee["monthly_fee"].'</td>
                                    <td>'.$agent_gateway_fee["transaction_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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
function select_merchant_acuity_fees($merchant_id,$processor_id){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$merchant_acuity_fee = $db->getOne("merchant_acuity_fees");
	if ($db->count > 0){
		$result = '<h5>Merchant Acuity Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective Date</th>
									<th>Setup Fee</th>
                                    <th>Monthly Fee</th>
                                    <th>Transaction Fee</th>
                                    <th>Rebill Transaction Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>'.$merchant_acuity_fee["effective_date"].'</td>
									<td>'.$merchant_acuity_fee["setup_fee"].'</td>
                                    <td>'.$merchant_acuity_fee["monthly_fee"].'</td>
                                    <td>'.$merchant_acuity_fee["transaction_fee"].'</td>
                                    <td>'.$merchant_acuity_fee["rebill_transaction_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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
function select_merchant_bank_fees($merchant_id,$processor_id){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$merchant_bank_fee = $db->getOne("merchant_bank_fees");
	if ($db->count > 0){
		$result = '<h5>Merchant Bank Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective date</th>
                                    <th>MID</th>
                                    <th>Transaction Fee</th>
                                    <th>Authorization Fee</th>
									<th>Capture Fee</th>
									<th>Sale Fee</th>
                                    <th>Decline Fee</th>
                                    <th>Refund Fee</th>
                                    <th>CB Fee 1</th>
									<th>CB Fee 2</th>
									<th>CB Threshold</th>
                                    <th>Discount Rate</th>
                                    <th>AVS Premium</th>
                                    <th>CVV Premium</th>
									<th>Interregional Premium</th>
									<th>wire Fee</th>
                                    <th>Reserve Rate</th>
                                    <th>Reserve Period Months</th>
                                    <th>Initial Reserve</th>
									<th>Setup Fee</th>
									<th>Monthly Fees</th>
                                    <th>Miscsetup Name</th>
                                    <th>Miscsetup Fee</th>
                                    <th>Miscmonthly One Name</th>
									<th>Miscmonthly One Fee</th>
									<th>Miscmonthly Two Name</th>
                                    <th>Miscmonthly Two Fee</th>
                                    <th>Misctrans One Name</th>
                                    <th>Misctrans One Fee</th>
									<th>Misctrans Two Name</th>
									<th>Misctrans Two Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
									<td>'.$merchant_bank_fee["effective_date"].'</td>
                                    <td>'.$merchant_bank_fee["mid"].'</td>
									<td>'.$merchant_bank_fee["transaction_fee"].'</td>
                                    <td>'.$merchant_bank_fee["authorization_fee"].'</td>
                                    <td>'.$merchant_bank_fee["capture_fee"].'</td>
                                    <td>'.$merchant_bank_fee["sale_fee"].'</td>
									<td>'.$merchant_bank_fee["decline_fee"].'</td>
									<td>'.$merchant_bank_fee["refund_fee"].'</td>
									<td>'.$merchant_bank_fee["cb_fee_1"].'</td>
									<td>'.$merchant_bank_fee["cb_fee_2"].'</td>
									<td>'.$merchant_bank_fee["cb_threshold"].'</td>
									<td>'.$merchant_bank_fee["discount_rate"].'</td>
									<td>'.$merchant_bank_fee["avs_premium"].'</td>
									<td>'.$merchant_bank_fee["cvv_premium"].'</td>
									<td>'.$merchant_bank_fee["interregional_premium"].'</td>
									<td>'.$merchant_bank_fee["wire_fee"].'</td>
									<td>'.$merchant_bank_fee["reserve_rate"].'</td>
									<td>'.$merchant_bank_fee["reserve_period_months"].'</td>
									<td>'.$merchant_bank_fee["initial_reserve"].'</td>
									<td>'.$merchant_bank_fee["setup_fee"].'</td>
									<td>'.$merchant_bank_fee["monthly_fees"].'</td>
									<td>'.$merchant_bank_fee["miscsetup_name"].'</td>
									<td>'.$merchant_bank_fee["miscsetup_fee"].'</td>
									<td>'.$merchant_bank_fee["miscmonthly_one_name"].'</td>
									<td>'.$merchant_bank_fee["miscmonthly_one_fee"].'</td>
									<td>'.$merchant_bank_fee["miscmonthly_two_name"].'</td>
									<td>'.$merchant_bank_fee["miscmonthly_two_fee"].'</td>
									<td>'.$merchant_bank_fee["misctrans_one_name"].'</td>
									<td>'.$merchant_bank_fee["misctrans_one_fee"].'</td>
									<td>'.$merchant_bank_fee["misctrans_two_name"].'</td>
									<td>'.$merchant_bank_fee["misctrans_two_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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
function select_merchant_bill_cycles($merchant_id,$processor_id){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$merchant_bill_cycle = $db->getOne("merchant_bill_cycles");
	if ($db->count > 0){
		$result = '<h5>Merchant Bill Cycles</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective Date</th>
									<th>Setup Fee</th>
                                    <th>Monthly Fee</th>
                                    <th>Transaction Fee</th>
                                    <th>Rebill Transaction Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>'.$merchant_bill_cycle["effective_date"].'</td>
									<td>'.$merchant_bill_cycle["setup_fee"].'</td>
                                    <td>'.$merchant_bill_cycle["monthly_fee"].'</td>
                                    <td>'.$merchant_bill_cycle["transaction_fee"].'</td>
                                    <td>'.$merchant_bill_cycle["rebill_transaction_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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
function select_merchant_gateway_fees($merchant_id,$processor_id){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$merchant_gateway_fee = $db->getOne("merchant_gateway_fees");
	if ($db->count > 0){
		$result = '<h5>Merchant Gateway Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective Date</th>
									<th>Setup Fee</th>
                                    <th>Monthly Fee</th>
                                    <th>Transaction Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>'.$merchant_gateway_fee["effective_date"].'</td>
									<td>'.$merchant_gateway_fee["setup_fee"].'</td>
                                    <td>'.$merchant_gateway_fee["monthly_fee"].'</td>
                                    <td>'.$merchant_gateway_fee["transaction_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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
function select_bank_fees($merchant_id,$processor_id){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$merchant_id);
	if($processor_id != "0") $db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$bank_fee = $db->getOne("bank_fees");
	if ($db->count > 0){
		$result = '<h5>Bank Fees</h5>
					<table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Effective date</th>
                                    <th>MID</th>
                                    <th>Transaction Fee</th>
                                    <th>Authorization Fee</th>
									<th>Capture Fee</th>
									<th>Sale Fee</th>
                                    <th>Decline Fee</th>
                                    <th>Refund Fee</th>
                                    <th>CB Fee 1</th>
									<th>CB Fee 2</th>
									<th>CB Threshold</th>
                                    <th>Discount Rate</th>
                                    <th>AVS Premium</th>
                                    <th>CVV Premium</th>
									<th>Interregional Premium</th>
									<th>wire Fee</th>
                                    <th>Reserve Rate</th>
                                    <th>Reserve Period Months</th>
                                    <th>Initial Reserve</th>
									<th>Setup Fee</th>
									<th>Monthly Fees</th>
                                    <th>Miscsetup Name</th>
                                    <th>Miscsetup Fee</th>
                                    <th>Miscmonthly One Name</th>
									<th>Miscmonthly One Fee</th>
									<th>Miscmonthly Two Name</th>
                                    <th>Miscmonthly Two Fee</th>
                                    <th>Misctrans One Name</th>
                                    <th>Misctrans One Fee</th>
									<th>Misctrans Two Name</th>
									<th>Misctrans Two Fee</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
									<td>'.$bank_fee["effective_date"].'</td>
                                    <td>'.$bank_fee["mid"].'</td>
									<td>'.$bank_fee["transaction_fee"].'</td>
                                    <td>'.$bank_fee["authorization_fee"].'</td>
                                    <td>'.$bank_fee["capture_fee"].'</td>
                                    <td>'.$bank_fee["sale_fee"].'</td>
									<td>'.$bank_fee["decline_fee"].'</td>
									<td>'.$bank_fee["refund_fee"].'</td>
									<td>'.$bank_fee["cb_fee_1"].'</td>
									<td>'.$bank_fee["cb_fee_2"].'</td>
									<td>'.$bank_fee["cb_threshold"].'</td>
									<td>'.$bank_fee["discount_rate"].'</td>
									<td>'.$bank_fee["avs_premium"].'</td>
									<td>'.$bank_fee["cvv_premium"].'</td>
									<td>'.$bank_fee["interregional_premium"].'</td>
									<td>'.$bank_fee["wire_fee"].'</td>
									<td>'.$bank_fee["reserve_rate"].'</td>
									<td>'.$bank_fee["reserve_period_months"].'</td>
									<td>'.$bank_fee["initial_reserve"].'</td>
									<td>'.$bank_fee["setup_fee"].'</td>
									<td>'.$bank_fee["monthly_fees"].'</td>
									<td>'.$bank_fee["miscsetup_name"].'</td>
									<td>'.$bank_fee["miscsetup_fee"].'</td>
									<td>'.$bank_fee["miscmonthly_one_name"].'</td>
									<td>'.$bank_fee["miscmonthly_one_fee"].'</td>
									<td>'.$bank_fee["miscmonthly_two_name"].'</td>
									<td>'.$bank_fee["miscmonthly_two_fee"].'</td>
									<td>'.$bank_fee["misctrans_one_name"].'</td>
									<td>'.$bank_fee["misctrans_one_fee"].'</td>
									<td>'.$bank_fee["misctrans_two_name"].'</td>
									<td>'.$bank_fee["misctrans_two_fee"].'</td>
                                </tr>
                                </tbody>
                            </table>';
	}
	return $result;	
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