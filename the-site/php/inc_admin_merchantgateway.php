<?php
require_once('database_config.php');

$m_id = $_POST['m_id'];
$p_id = $_POST['p_id'];
$query = "SELECT distinct p_id, p.processor_name, merchant_id 
FROM processors p
INNER JOIN merchant_processors_mid m ON p.p_id = m.gateway_id and merchant_id = ".$m_id." 
WHERE processor_id = ".$p_id;
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
	$result .= '<option value="0">-- Select Gateways --</option>';
	foreach($merchant_processors as $merchant_processor)
	{
		$result .= '<option value="'.$merchant_processor["p_id"].'" >'.$merchant_processor["processor_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>