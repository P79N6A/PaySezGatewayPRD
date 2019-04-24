<?php
require_once('database_config.php');

$m_id = $_POST['m_id'];

$test='';
$query = "SELECT * FROM merchants where userid='0'";


$merchant_processors = $db->rawQuery($query);

							
$result = '';
if(!empty($merchant_processors)){
	$result .= '<select name="processor_id[]" id="processor_id" class="form-control m-b  chosen-select" multiple>';
	$result .= '<option value="0">-- Select Merchants --</option>';
	foreach($merchant_processors as $merchant_processor)
	{
		$color = ($merchant_processor["idmerchants"] != NULL);
		$result .= '<option value="'.$merchant_processor["idmerchants"].'" '.$color.'>'.$merchant_processor["merchant_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>