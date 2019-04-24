<?php
require_once('database_config.php');

$a_id = $_POST['a_id'];
$query = "SELECT idmerchants, m.merchant_name 
FROM merchants m 
WHERE affiliate_id = ".$a_id;
$agent_merchants = $db->rawQuery($query);
										
$result = '';
if(!empty($agent_merchants)){
	$result .= '<select name="merchant_id" id="merchant_id" class="form-control m-b chosen-select" tabindex="2">';
	$result .= '<option value="0">-- Select Merchant --</option>';
	foreach($agent_merchants as $agent_merchant)
	{
		$result .= '<option value="'.$agent_merchant["idmerchants"].'" >'.$agent_merchant["merchant_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>