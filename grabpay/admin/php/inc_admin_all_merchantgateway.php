<?php
require_once('database_config.php');

$m_id = $_POST['m_id'];
$p_id = $_POST['p_id'];
$query = "SELECT distinct p_id, p.processor_name, merchant_id 
FROM processors p
LEFT JOIN merchant_processors_mid m ON p.p_id = m.processor_id and merchant_id = ".$m_id." AND processor_id = ".$p_id." 
WHERE gateway_or_bank = 0";
$merchant_processors = $db->rawQuery($query);

$cols = Array ("processor_id", "gateway_id", "processor_name");
$db->join("processors p", "p.p_id = m.gateway_id", "LEFT");
$db->where("merchant_id = ".$m_id."  and m.processor_id = ".$p_id." ");
$gateways = $db->get("merchant_processors_mid m", null, $cols);
$gateways_arr = array();
foreach($gateways as $gateway){
$gateways_arr[] = $gateway['gateway_id'];
}	
$result = '';
if(!empty($merchant_processors)){
	$result .= '<select name="gateway_id" id="gateway_id" class="form-control m-b  chosen-select">';
	$result .= '<option value="0">-- All Gateways --</option>';
	foreach($merchant_processors as $merchant_processor)
	{
		$color = (in_array($merchant_processor["p_id"], $gateways_arr))?"style='background: yellow'":"";
		$result .= '<option value="'.$merchant_processor["p_id"].'" '.$color.'>'.$merchant_processor["processor_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>