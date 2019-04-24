<?php
require_once('database_config.php');

$arr_new  = array();
$arr_merchant_bank_fees  = array();
$arr_agent_bank_fees  = array();
$arr_bank_fees  = array();
$KeysArray = array_keys($_POST); 
//print_r($KeysArray);
foreach($KeysArray as $item)
{
        $str = explode("-",$item);
		switch($str[0]){
			case 'merchant_bank_fees':
				$arr_merchant_bank_fees[$str[1]] = $_POST[$item];
			break;
			case 'agent_bank_fees':
				$arr_agent_bank_fees[$str[2]][$str[1]] = $_POST[$item];
			break;
			case 'bank_fees':
				$arr_bank_fees[$str[1]] = $_POST[$item];
			case 'merchant_acuity_fees':
				if($str[0] == 'merchant_acuity_fees') {
					$arr_merchant_acuity_fees[$str[1]] = $_POST[$item];
				}
			case 'agent_acuity_fees':
				if($str[0] == 'agent_acuity_fees') {
					$arr_agent_acuity_fees[$str[2]][$str[1]] = $_POST[$item];
				}
			case 'merchant_gateway_fees':
				if($str[0] == 'merchant_gateway_fees') {
					$arr_merchant_gateway_fees[$str[1]] = $_POST[$item];
				}
			
			case 'agent_gateway_fees':
				if($str[0] == 'agent_gateway_fees') {
					$arr_agent_gateway_fees[$str[2]][$str[1]] = $_POST[$item];
				}
			break;
		}
		
        //$arr_new[$key][$str[0].$k]=$str[1];
}

$arr_agents = array_keys($arr_agent_bank_fees);
foreach($arr_agents as $item)
{	
	$agent_bankfees = $arr_agent_bank_fees[$item];
	$agent_bankfees_id = $item;
	//print_r($agent_bankfees_id.'--');
	agent_bank_fees($agent_bankfees, $agent_bankfees_id);
}

$arr_acuity_agents = array_keys($arr_agent_acuity_fees);
foreach($arr_acuity_agents as $item)
{	
	$agent_acuity_fees = $arr_agent_acuity_fees[$item];
	$agent_acuity_fees_id = $item;
	//print_r($agent_acuity_fees_id.'--');
	agent_acuity_fees($agent_acuity_fees, $agent_acuity_fees_id);
}

$arr_gateway_agents = array_keys($arr_agent_gateway_fees);
foreach($arr_gateway_agents as $item)
{	
	$agent_gateway_fees = $arr_agent_gateway_fees[$item];
	$agent_gateway_fees_id = $item;
	//print_r($agent_acuity_fees_id.'--');
	agent_gateway_fees($agent_gateway_fees, $agent_gateway_fees_id);
}

//print_r($arr_bank_fees);
//print_r('---merchant='.$_POST['merchant_id-0-0']);
//print_r('---processor='.$_POST['processor_id-0-0']);

//print_r($_POST['processor_id-0-0']);
$success = bank_fees($arr_bank_fees);
$success2 = merchant_bank_fees($arr_merchant_bank_fees);
$success_merchant_acuity_fees = merchant_acuity_fees($arr_merchant_acuity_fees);
$success_merchant_gateway_fees = merchant_gateway_fees($arr_merchant_gateway_fees);
merchant_bill_cycles();
if($success && $success2){
	echo '<div class="alert alert-success">Fees has been saves successfully</div>';
}
function merchant_bank_fees($arr_merchant_bank_fees){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$_POST['merchant_id-0-0']);
	$db->where("processor_id",$_POST['processor_id-0-0']);
	$db->where("last_effective_date is NULL");
	$lastid = $db->getone("merchant_bank_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => date("Y-m-d")
			);
		$db->where('idmerchant_bank_fees',$lastid['idmerchant_bank_fees']);
		$db->update('merchant_bank_fees', $closeold);
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'miscsetup_name' =>	$_POST['miscsetup_name'],
					'miscmonthly_one_name' =>	$_POST['miscmonthly_one_name'],
					'miscmonthly_two_name' =>	$_POST['miscmonthly_two_name'],
					'misctrans_one_name' =>	$_POST['misctrans_one_name'],
					'misctrans_two_name' =>	$_POST['misctrans_two_name'],
					'effective_date' =>	date("Y-m-d")
				);
	$final = array_merge ($vars,$arr_merchant_bank_fees);
	$db->insert('merchant_bank_fees', $final);
	return true;	
}
function agent_bank_fees($agent_bankfees, $agent_bankfees_id){
	global $db;
	$db->where("agent_id",$agent_bankfees_id);
	$db->where("merchant_id",$_POST['merchant_id-0-0']);
	$db->where("processor_id",$_POST['processor_id-0-0']);
	$db->where("last_effective_date is NULL");
	$lastid = $db->getone("agent_bank_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => date("Y-m-d")
			);
		$db->where('idagent_bank_fees',$lastid['idagent_bank_fees']);
		$db->update('agent_bank_fees', $closeold);
	}
	$vars = array(
					'agent_id' =>	$agent_bankfees_id,
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'miscsetup_name' =>	$_POST['miscsetup_name'],
					'miscmonthly_one_name' =>	$_POST['miscmonthly_one_name'],
					'miscmonthly_two_name' =>	$_POST['miscmonthly_two_name'],
					'misctrans_one_name' =>	$_POST['misctrans_one_name'],
					'misctrans_two_name' =>	$_POST['misctrans_two_name'],
					'effective_date' =>	date("Y-m-d")
					);
	$final = array_merge ($vars,$agent_bankfees);
	$db->insert('agent_bank_fees', $final);
	return true;	
}
function bank_fees($arr_bank_fees){
	global $db;
	//$processor_id = bank_fees-id;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$_POST['merchant_id-0-0']);
	$db->where("processor_id",$_POST['processor_id-0-0']);
	$db->where("last_effective_date is NULL");
	$lastid = $db->getone("bank_fees");
	//echo "Last executed query was ". $db->getLastQuery();
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => date("Y-m-d")
			);
		$db->where('idbank_fees',$lastid['idbank_fees']);
		$db->update('bank_fees', $closeold);
		//echo "Last executed query was ". $db->getLastQuery();
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'miscsetup_name' =>	$_POST['miscsetup_name'],
					'miscmonthly_one_name' =>	$_POST['miscmonthly_one_name'],
					'miscmonthly_two_name' =>	$_POST['miscmonthly_two_name'],
					'misctrans_one_name' =>	$_POST['misctrans_one_name'],
					'misctrans_two_name' =>	$_POST['misctrans_two_name'],
					'effective_date' =>	date("Y-m-d")
					);
	$final = array_merge ($vars,$arr_bank_fees);
	$db->insert('bank_fees', $final);
	//echo "Last executed query was ". $db->getLastQuery();
	return true;	
}
function merchant_gateway_fees($arr_merchant_gateway_fees){
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
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'effective_date' =>	date("Y-m-d")
				);
	$final = array_merge ($vars,$arr_merchant_gateway_fees);
	$db->insert('merchant_gateway_fees', $final);
	return true;	
}
function merchant_bill_cycles(){
	global $db;
	//$db->where("agent_id",$agent_id);
	$db->where("merchant_id",$_POST['merchant_id-0-0']);
	$db->where("processor_id",$_POST['processor_id-0-0']);
	$db->where("last_effective_date", NULL, '<=>');
	$lastid = $db->getone("merchant_bill_cycles");
	$today = date("Y-m-d");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $today
			);
		$db->where('idmerchant_bill_cycles',$lastid['idmerchant_bill_cycles']);
		$db->update('merchant_bill_cycles', $closeold);
		//echo "Last executed query was ". $db->getLastQuery();
	}
	$vars = array(
					//'agent_id' =>	$agent_id,
					'merchant_id' 		=>	$_POST['merchant_id-0-0'],
					'processor_id' 		=>	$_POST['processor_id-0-0'],
					'bill_cycles_pw' 	=>	$_POST['bill_cycles_pw'],
					'day_of_week_one' 	=>  $_POST['day_of_week_one'],
					'day_of_week_two' 	=>	$_POST['day_of_week_two'],
					'weeks_to_settle' 	=>	$_POST['weeks_to_settle'],
					'effective_date' 	=>	$today
				);
	
	$db->insert('merchant_bill_cycles', $vars);
	//echo "Last executed query was ". $db->getLastQuery();
	return true;	
}
function merchant_acuity_fees($arr_merchant_acuity_fees){
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
	$lastid = $db->getOne("merchant_acuity_fees");
	if ($db->count > 0){
		$closeold = array(
			'last_effective_date' => $effective_date
			);
		$db->where('idmerchant_acuity_fees',$lastid['idmerchant_acuity_fees']);
		$db->update('merchant_acuity_fees', $closeold);
	}
	$vars = array(
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'effective_date' =>	date("Y-m-d")
				);
	$final = array_merge ($vars,$arr_merchant_acuity_fees);
	$db->insert('merchant_acuity_fees', $final);
	return true;	
}
function agent_gateway_fees($agent_gateway_fees, $agent_gateway_fees_id){
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
					'agent_id' =>	$agent_gateway_fees_id,
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'effective_date' =>	date("Y-m-d")
					);
	$final = array_merge ($vars,$agent_gateway_fees);
	$db->insert('agent_gateway_fees', $final);
	return true;	
}
function agent_acuity_fees($agent_acuity_fees, $agent_acuity_fees_id){
	global $db;
	foreach ($_POST as $key => $value) {
			filter_input(INPUT_POST, $key);
			$$key = $_POST[$key];
			$key = $value;
		}
	$db->where("agent_id",$agent_acuity_fees_id);
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
					'agent_id' =>	$agent_acuity_fees_id,
					'merchant_id' =>	$_POST['merchant_id-0-0'],
					'processor_id' =>	$_POST['processor_id-0-0'],
					'effective_date' =>	date("Y-m-d")
					);
	$final = array_merge ($vars,$agent_acuity_fees);
	$db->insert('agent_acuity_fees', $final);
	return 'done';	
}

?>