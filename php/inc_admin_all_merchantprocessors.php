<?php
require_once('database_config.php');

$m_id = $_POST['m_id'];
$query = "SELECT * FROM processors";


$merchant_processors = $db->rawQuery($query);
										
$result = '';
if(!empty($merchant_processors)){
	$result .= '<select name="processor_id" id="processor_id" class="form-control m-b  chosen-select" multiple>';
	$result .= '<option value="0">-- All Processors --</option>';
	foreach($merchant_processors as $merchant_processor)
	{
		$color = ($merchant_processor["p_id"] != NULL);
		$result .= '<option value="'.$merchant_processor["p_id"].'" '.$color.'>'.$merchant_processor["processor_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>