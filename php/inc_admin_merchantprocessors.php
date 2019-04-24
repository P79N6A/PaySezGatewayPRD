<?php
require_once('database_config.php');

$m_id = $_POST['m_id'];
/*
$query = "SELECT distinct p_id, p.processor_name, merchant_id 
FROM processors p
INNER JOIN merchant_processors_mid m ON p.p_id = m.processor_id and merchant_id = ".$m_id." 
WHERE gateway_or_bank = 1 ";
*/

$query = "SELECT * FROM processors";
$merchant_processors = $db->rawQuery($query);
										
$result = '';
if(!empty($merchant_processors)){
	$result .= '<select name="processor_id" id="processor_id" class="form-control m-b  chosen-select">';
	$result .= '<option value="0">-- Select Processors --</option>';
	foreach($merchant_processors as $merchant_processor)
	{
		$result .= '<option value="'.$merchant_processor["p_id"].'">'.$merchant_processor["processor_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>