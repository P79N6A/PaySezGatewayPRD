<?php
require_once('database_config.php');
$merchant_id = $_POST['m_id'];
//get agent id
$cols = Array ("affiliate_id");
$db->where("idmerchants",$merchant_id);
$data = $db->getOne("merchants m", null, $cols);
$agent_id = $data ["affiliate_id"];

$processor_id = $_POST['p_id'];
$gateway_id = $_POST['g_id'];


function getMiscHtml($id, $name, $fees, $type='agent_bank_fees') {
$html = '<tr>
			<td>
				'.$name.'<!--input type="hidden" value="'.$id.'" id="'.$type.'-id-'.$id.'" name="'.$type.'-id-'.$id.'"-->
			</td>
		<td>
			<input type="text"  class="form-control m-b required" id="'.$type.'-miscsetup_fee-'.$id.'" name="'.$type.'-miscsetup_fee-'.$id.'" value="'.$fees["miscsetup_fee"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="'.$type.'-miscmonthly_one_fee-'.$id.'" name="'.$type.'-miscmonthly_one_fee-'.$id.'" value="'.$fees["miscmonthly_one_fee"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="'.$type.'-miscmonthly_two_fee-'.$id.'" name="'.$type.'-miscmonthly_two_fee-'.$id.'" value="'.$fees["miscmonthly_two_fee"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="'.$type.'-misctrans_one_fee-'.$id.'" name="'.$type.'-misctrans_one_fee-'.$id.'" value="'.$fees["misctrans_one_fee"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="'.$type.'-misctrans_two_fee-'.$id.'" name="'.$type.'-misctrans_two_fee-'.$id.'" value="'.$fees["misctrans_two_fee"].'" />
		</td>
	</tr>';
return $html;
}

function getMiscNameHtml($fees) {
$html = '<tr>
			<td>
				Fee Name
			</td>
		<td>
			<input type="text"  class="form-control m-b required" id="miscsetup_name" name="miscsetup_name" value="'.$fees["miscsetup_name"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="miscmonthly_one_name" name="miscmonthly_one_name" value="'.$fees["miscmonthly_one_name"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="miscmonthly_two_name" name="miscmonthly_two_name" value="'.$fees["miscmonthly_two_name"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="misctrans_one_name" name="misctrans_one_name" value="'.$fees["misctrans_one_name"].'" />
		</td>
		<td>
			<input type="text"  class="form-control m-b required" id="misctrans_two_name" name="misctrans_two_name" value="'.$fees["misctrans_two_name"].'" />
		</td>
	</tr>';
return $html;
}

function getHtml($id, $name, $fees, $type='agent_bank_fees'){
	$html = '<tr>
					<td>
					'.$name.'<!--input type="hidden" value="'.$id.'" id="'.$type.'-id-'.$id.'" name="'.$type.'-id-'.$id.'"-->
					</td>
					<td>
						<input type="text" name="'.$type.'-transaction_fee-'.$id.'" id="'.$type.'-transaction_fee-'.$id.'" value="'.$fees["transaction_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-authorization_fee-'.$id.'" id="'.$type.'-authorization_fee-'.$id.'" value="'.$fees["authorization_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-capture_fee-'.$id.'" id="'.$type.'-capture_fee-'.$id.'" value="'.$fees["capture_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-sale_fee-'.$id.'" id="'.$type.'-sale_fee-'.$id.'" value="'.$fees["sale_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-decline_fee-'.$id.'" id="'.$type.'-decline_fee-'.$id.'" value="'.$fees["decline_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-refund_fee-'.$id.'" id="'.$type.'-refund_fee-'.$id.'" value="'.$fees["refund_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-cb_fee_1-'.$id.'" id="'.$type.'-cb_fee_1-'.$id.'" value="'.$fees["cb_fee_1"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-cb_fee_2-'.$id.'" id="'.$type.'-cb_fee_2-'.$id.'" value="'.$fees["cb_fee_2"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-cb_threshold-'.$id.'" id="'.$type.'-cb_threshold-'.$id.'" value="'.$fees["cb_threshold"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-discount_rate-'.$id.'" id="'.$type.'-discount_rate-'.$id.'" value="'.$fees["discount_rate"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-avs_premium-'.$id.'" id="'.$type.'-avs_premium-'.$id.'" value="'.$fees["avs_premium"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-cvv_premium-'.$id.'" id="'.$type.'-cvv_premium-'.$id.'" value="'.$fees["cvv_premium"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-interregional_premium-'.$id.'" id="'.$type.'-interregional_premium-'.$id.'" value="'.$fees["interregional_premium"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-wire_fee-'.$id.'" id="'.$type.'-wire_fee-'.$id.'" value="'.$fees["wire_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-reserve_rate-'.$id.'" id="'.$type.'-reserve_rate-'.$id.'" value="'.$fees["reserve_rate"].'"  class="form-control m-b required" />
					</td>
					<td>
						<select name="'.$type.'-reserve_rate-'.$id.'" id="'.$type.'-reserve_rate-'.$id.'" value="'.$fees["reserve_rate"].'"  class="form-control m-b required">
							<option value="4">Four</option>
							<option value="5">Five</option>
							<option selected="selected" value="6">Six</option>
							<option value="7">Seven</option>
							<option value="8">Eight</option>
						</select>
					</td>
					<td>
						<input type="text" name="'.$type.'-initial_reserve-'.$id.'" id="'.$type.'-initial_reserve-'.$id.'" value="'.$fees["initial_reserve"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-setup_fee-'.$id.'" id="'.$type.'-setup_fee-'.$id.'" value="'.$fees["setup_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-monthly_fee-'.$id.'" id="'.$type.'-monthly_fee-'.$id.'" value="'.$fees["monthly_fee"].'"  class="form-control m-b required" />
					</td>
				</tr>';
	return $html;
}

function getAcuityHtml($id, $name, $fees, $type='agent_acuity_fees'){
	$html = '<tr>
					<td>
					'.$name.'<!--input type="hidden" value="'.$id.'" id="'.$type.'-id-'.$id.'" name="'.$type.'-id-'.$id.'"-->
					</td>
					<td>
						<input type="text" name="'.$type.'-setup_fee-'.$id.'" id="'.$type.'-setup_fee-'.$id.'" value="'.$fees["setup_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-monthly_fee-'.$id.'" id="'.$type.'-monthly_fee-'.$id.'" value="'.$fees["monthly_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-transaction_fee-'.$id.'" id="'.$type.'-transaction_fee-'.$id.'" value="'.$fees["transaction_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-rebill_transaction_fee-'.$id.'" id="'.$type.'-rebill_transaction_fee-'.$id.'" value="'.$fees["rebill_transaction_fee"].'"  class="form-control m-b required" />
					</td>
				</tr>';
	return $html;
}

function getGatewayHtml($id, $name, $fees, $type='gateway_agent_fees'){
	$html = '<tr>
					<td>
					'.$name.'<!--input type="hidden" value="'.$id.'" id="'.$type.'-id-'.$id.'" name="'.$type.'-id-'.$id.'"-->
					</td>
					<td>
						<input type="text" name="'.$type.'-setup_fee-'.$id.'" id="'.$type.'-setup_fee-'.$id.'" value="'.$fees["setup_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-monthly_fee-'.$id.'" id="'.$type.'-monthly_fee-'.$id.'" value="'.$fees["monthly_fee"].'"  class="form-control m-b required" />
					</td>
					<td>
						<input type="text" name="'.$type.'-transaction_fee-'.$id.'" id="'.$type.'-transaction_fee-'.$id.'" value="'.$fees["transaction_fee"].'"  class="form-control m-b required" />
					</td>
				</tr>';
	return $html;
}

function getAgentsFees($rootid, $merchant_id ,$processor_id, $html, $fee_type = "normal"){
   global $db;
   $cols = Array ("idagents", "agentname", "affiliation");
   $db->where("idagents",$rootid);
   $db->orderBy("agentname","Asc");
   $results = $db->get("agents", null, $cols);
	
   foreach($results as $row) {
	  //$html = $row["idagents"]." - ".$row["agentname"]."<br />";  
		$db->where("agent_id",$row["idagents"]);
		$db->where("merchant_id",$merchant_id);
		if($processor_id != "0") $db->where("processor_id",$processor_id);
		$db->where("last_effective_date", NULL, '<=>');
		$agent_bank_fee = $db->getOne("agent_bank_fees");
		if($fee_type == 'misc') {
			$html = getMiscHtml($row["idagents"],$row["agentname"], $agent_bank_fee, 'agent_bank_fees');
		} else {
			$html = getHtml($row["idagents"],$row["agentname"], $agent_bank_fee, 'agent_bank_fees');
		}
	  if($row["affiliation"] > 0){
		$html .= getAgentsFees($row["affiliation"],$merchant_id ,$processor_id ,$html, $fee_type);	
	  } 
   }
   return $html;
}

function getProcessorFees($merchant_id,$processor_id, $fee_type = "normal"){
	global $db;
	$db->join("processors p", "b.processor_id = p.p_id", "INNER");
	$db->where("merchant_id",$merchant_id);
	$db->where("processor_id",$processor_id);
	$db->where("last_effective_date", NULL, '<=>');
	$bank_fee = $db->getOne("bank_fees b");
	$name = $bank_fee["processor_name"];
	
	if($fee_type == 'misc') {
		$html = getMiscHtml($processor_id, $name, $bank_fee, 'bank_fees');
	} else {
		$html = getHtml($processor_id, $name, $bank_fee, 'bank_fees');
	}
	return $html;	
}

function getMerchantFees($merchant_id,$processor_id, $fee_type = "normal"){
	global $db;
	if($processor_id != "0") {
		$db->join("merchant_bank_fees f", "f.merchant_id = m.idmerchants AND processor_id =".$processor_id." AND last_effective_date is NULL", "LEFT");
	} else {
		$db->join("merchant_bank_fees f", "f.merchant_id = m.idmerchants AND last_effective_date is NULL", "LEFT");
	}	
	$db->where("idmerchants",$merchant_id);
	$merchant_bank_fee = $db->getOne("merchants m");
	//echo "Last executed query was ". $db->getLastQuery();
	$name = $merchant_bank_fee["merchant_name"];
	if($fee_type == 'miscname') {
		$html = getMiscNameHtml($merchant_bank_fee);
	} elseif($fee_type == 'misc') {
		$html = getMiscHtml($merchant_id, $name, $merchant_bank_fee, 'merchant_bank_fees');
	} else {
		$html = getHtml($merchant_id, $name, $merchant_bank_fee, 'merchant_bank_fees');
	}
	return $html;	
}

function getAgentsAcuityFees($rootid, $merchant_id ,$processor_id, $html, $fee_type = "normal"){
   global $db;
   $cols = Array ("idagents", "agentname", "affiliation");
   $db->where("idagents",$rootid);
   $db->orderBy("agentname","Asc");
   $results = $db->get("agents", null, $cols);
	
   foreach($results as $row) { 
		$db->where("agent_id",$row["idagents"]);
		$db->where("merchant_id",$merchant_id);
		if($processor_id != "0") $db->where("processor_id",$processor_id);
		$db->where("last_effective_date", NULL, '<=>');
		$agent_acuity_fees = $db->getOne("agent_acuity_fees");
		$html = getAcuityHtml($row["idagents"],$row["agentname"], $agent_acuity_fees, 'agent_acuity_fees');

	  if($row["affiliation"] > 0){
		$html .= getAgentsAcuityFees($row["affiliation"],$merchant_id ,$processor_id ,$html, $fee_type);	
	  } 
   }
   return $html;
}

function getMerchantAcuityFees($merchant_id,$processor_id, $fee_type = "normal"){
	global $db;
	if($processor_id != "0") {
		$db->join("merchant_acuity_fees f", "f.merchant_id = m.idmerchants AND processor_id =".$processor_id." ", "LEFT");
	} else {
		$db->join("merchant_acuity_fees f", "f.merchant_id = m.idmerchants", "LEFT");
	}	
	$db->where("idmerchants",$merchant_id);
	
	$db->where("last_effective_date is NULL");
	$merchant_acuity_fees = $db->getOne("merchants m");
	//echo "Last executed query was ". $db->getLastQuery();
	$name = $merchant_acuity_fees["merchant_name"];
	$html = getAcuityHtml($merchant_id, $name, $merchant_acuity_fees, 'merchant_acuity_fees');

	return $html;	
}

function getAgentsGatewayFees($rootid, $merchant_id ,$processor_id, $html, $fee_type = "normal"){
   global $db;
   $cols = Array ("idagents", "agentname", "affiliation");
   $db->where("idagents",$rootid);
   $db->orderBy("agentname","Asc");
   $results = $db->get("agents", null, $cols);
	
   foreach($results as $row) { 
		$db->where("agent_id",$row["idagents"]);
		$db->where("merchant_id",$merchant_id);
		if($processor_id != "0") $db->where("processor_id",$processor_id);
		$db->where("last_effective_date", NULL, '<=>');
		$agent_gateway_fees = $db->getOne("agent_gateway_fees");
		$html = getGatewayHtml($row["idagents"],$row["agentname"], $agent_gateway_fees, 'agent_gateway_fees');

	  if($row["affiliation"] > 0){
		$html .= getAgentsGatewayFees($row["affiliation"],$merchant_id ,$processor_id ,$html, $fee_type);	
	  } 
   }
   return $html;
}

function getMerchantGatewayFees($merchant_id,$processor_id, $fee_type = "normal"){
	global $db;
	if($processor_id != "0") {
		$db->join("merchant_gateway_fees f", "f.merchant_id = m.idmerchants AND processor_id =".$processor_id." ", "LEFT");
	} else {
		$db->join("merchant_gateway_fees f", "f.merchant_id = m.idmerchants", "LEFT");
	}	
	$db->where("idmerchants",$merchant_id);
	
	$db->where("last_effective_date is NULL");
	$merchant_gateway_fees = $db->getOne("merchants m");
	//echo "Last executed query was ". $db->getLastQuery();
	$name = $merchant_gateway_fees["merchant_name"];
	$html = getGatewayHtml($merchant_id, $name, $merchant_gateway_fees, 'merchant_gateway_fees');

	return $html;	
}

$agents_acuity_fees 	= getAgentsAcuityFees($agent_id, $merchant_id ,$processor_id, ""); 
$merchant_acuity_fees 	= getMerchantAcuityFees($merchant_id ,$processor_id, ""); 

$agents_gateway_fees 	= getAgentsGatewayFees($agent_id, $merchant_id ,$processor_id, ""); 
$merchant_gateway_fees 	= getMerchantGatewayFees($merchant_id ,$processor_id, "");          

$agents_fees 	= getAgentsFees($agent_id, $merchant_id ,$processor_id, ""); 
$merchant_fees 	= getMerchantFees($merchant_id ,$processor_id, ""); 
$processor_fees = getProcessorFees($merchant_id ,$processor_id, "");      
                         
$merchant_misc_name_fees =  getMerchantFees($merchant_id ,$processor_id, "miscname"); 
$merchant_misc_fees =  getAgentsFees($agent_id, $merchant_id ,$processor_id, "", "misc"); 
$agents_misc_fees = getMerchantFees($merchant_id ,$processor_id, "misc"); 
$processor_misc_fees = getProcessorFees($merchant_id ,$processor_id, "misc");   
	
?>
<form id="savebankfees" action="#" method="POST">
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Billing Scheduling</h5>
			</div>
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-3">
						<div class="form-group">
							<label>Number of billing periods per week</label> 
							<select name="bill_cycles_pw" id="bill_cycles_pw" class="form-control m-b required">
								<option value="1">One</option>
								<option value="2">Two</option>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label>Bill period #1 starts on:</label> 
							<select size="1" id="day_of_week_one" name="day_of_week_one" class="form-control m-b required">
								<option selected="selected" value="1">Sunday</option>
								<option value="2">Monday</option>
								<option value="3">Tuesday</option>
								<option value="4">Wednesday</option>
								<option value="5">Thursday</option>
								<option value="6">Friday</option>
								<option value="7">Saturday</option>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label>Bill period #2 starts on:</label> 
							<select size="1" id="day_of_week_two" name="day_of_week_two" class="form-control m-b required">
								<option selected="selected" value="1">Sunday</option>
								<option value="2">Monday</option>
								<option value="3">Tuesday</option>
								<option value="4">Wednesday</option>
								<option value="5">Thursday</option>
								<option value="6">Friday</option>
								<option value="7">Saturday</option>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label>Time to settle(weeks)</label> 
							<select size="1" id="weeks_to_settle" name="weeks_to_settle" class="form-control m-b required">
								<option value="1">One</option>
								<option selected="selected" value="2">Two</option>
								<option value="3">Three</option>
								<option value="4">Four</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Transaction Antifraud Fees (All fees in US$)</h5>
			</div>
			<div class="ibox-content">
				<table class="table">
					<thead>
						<tr>
							<th>
							</th>
							<th>
								Setup
							</th>
							<th>
								Monthly
							</th>
							<th>
								Transaction fee
							</th>
							<th>
								Rebill Transaction fee
							</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						echo $merchant_acuity_fees;
						echo $agents_acuity_fees;		
						?>
					</tbody>
					</table>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Gateway Fees (All fees in US$)</h5>
			</div>
			<div class="ibox-content">
				<table class="table">
					<thead>
					<tr>
						<th>
						</th>
						<th>
							Setup
						</th>
						<th>
							Monthly
						</th>
						<th>
							Transaction fee
						</th>
					</tr>
					</thead>
					<tbody>
						<?php 
						echo $merchant_gateway_fees;
						echo $agents_gateway_fees;		
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Bank Fees (All fees in US$)</h5>
			</div>
			<div class="ibox-content">
				<div class="table-responsive">				
			    <table class="table">
					<thead>
						<tr>
							<th> </th>
							<th>Transaction</th>
							<th>Authorization</th>
							<th>Capture</th>
							<th>Sale</th>
							<th>Decline</th>
							<th>Refund</th>
							<th>Chargeback 1</th>
							<th>Chargeback 2</th>
							<th>Chargeback
								<br> Threshold</th>
							<th>Discount
								<br>rate (%)</th>
							<th>AVS Premium</th>
							<th>CVV Premium</th>
							<th>Interregional
								<br>Premium</th>
							<th>Wire</th>
							<th>Reserve
								<br>rate (%)</th>
							<th>Reserve
								<br>period
								<br>(months)</th>
							<th>Initial
								<br>Reserve</th>
							<th>Setup
								<br>fee</th>
							<th>Monthly
								<br>Fee</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						echo $merchant_fees;
						echo $agents_fees; 
						echo $processor_fees; ?>
						<tr id="row8">
							<td>Profit</td>
							<td class="trfee_total">
								<input type="text" disabled="" style="width: 80px" id="trfee" name="trfee-0-0">
							</td>
							<td class="aufee_total">
								<input type="text" disabled="" style="width: 100px" id="aufee" name="aufee-0-0">
							</td>
							<td class="cafee_total">
								<input type="text" disabled="" style="width: 60px" id="cafee" name="cafee-0-0">
							</td>
							<td class="safee_total">
								<input type="text" disabled="" style="width: 50px" id="safee" name="safee-0-0">
							</td>
							<td class="defee_total">
								<input type="text" disabled="" style="width: 50px" id="defee" name="defee-0-0">
							</td>
							<td class="refee_total">
								<input type="text" disabled="" style="width: 50px" id="refee" name="refee-0-0">
							</td>
							<td class="cb1fee_total">
								<input type="text" disabled="" style="width: 100px" id="cb1fee" name="cb1fee-0-0">
							</td>
							<td class="cb2fee_total">
								<input type="text" disabled="" style="width: 100px" id="cb2fee" name="cb2fee-0-0">
							</td>
							<td class="skip"> </td>
							<td class="drfee_total">
								<input type="text" disabled="" style="width: 60px" id="drfee" name="drfee-0-0">
							</td>
							<td class="avsfee_total">
								<input type="text" disabled="" style="width: 60px" id="avsfee" name="avsfee-0-0">
							</td>
							<td class="cvvfee_total">
								<input type="text" disabled="" style="width: 60px" id="cvvfee" name="cvvfee-0-0">
							</td>
							<td class="irfee_total">
								<input type="text" disabled="" style="width: 60px" id="irfee" name="irfee-0-0">
							</td>
							<td class="skip"> </td>
							<td class="skip"> </td>
							<td class="skip"> </td>
							<td class="skip"> </td>
							<td class="setupfee_total">
								<input type="text" disabled="" style="width: 70px" id="setupfee" name="setupfee-0-0">
							</td>
							<td class="monthlyfee_total">
								<input type="text" disabled="" style="width: 70px" id="monthlyfee" name="monthlyfee-0-0">
							</td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Miscellaneous Fees</h5>
			</div>
			<div class="ibox-content">
				<div class="table-responsive">
			    <table class="table">
					<thead>
					<tr>
						<th>
						</th>
						<th>
							Setup
						</th>
						<th>
							Monthly 1
						</th>
						<th>
							Monthly 2
						</th>
						<th>
							Transaction Fee 1
						</th>
						<th>
							Transaction Fee 2
						</th>
					</tr>
					</thead>
					<tbody>
						<?php
						echo $merchant_misc_name_fees;						
						echo $merchant_misc_fees;
						echo $agents_misc_fees; 
						echo $processor_misc_fees; ?>
					</tbody>
				</table>				
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="agent_id-0-0" id="agent_id" value="<?php echo $agent_id; ?>" />
<input type="hidden" name="merchant_id-0-0" id="merchant_id" value="<?php echo $merchant_id; ?>" />
<input type="hidden" name="processor_id-0-0" id="processor_id" value="<?php echo $processor_id; ?>" />
<input type="hidden" name="gateway_id-0-0" id="gateway_id" value="<?php echo $gateway_id; ?>" />
</form>
<div class="row">
	<div class="col-lg-8"></div>
	<div class="col-lg-4">
	<Br />
		<div id="savebankfees_result"></div>
		<button class="btn btn-w-m btn-block btn-primary savefees">Save</button>
	</div>
</div>

<?php
?>
<script src="../js/jquery-2.1.1.js"></script>
<!-- Jquery Validate -->
<script src="../js/plugins/validate/jquery.validate.min.js"></script>

<script>
	$(document).ready(function(){
		$("#savebankfees").validate();
		$(".savefees").click(function () {
			$('#savebankfees_result').html("Saving...");
			var postData = $("#savebankfees").serializeArray();
				$.ajax({
					method: "POST",
					url: "php/inc_admin_savebankfees.php",
					data: postData
				})
				.done(function( msg ) {
					$("#savebankfees_result").html(msg);
				});
		});
	});
</script>
