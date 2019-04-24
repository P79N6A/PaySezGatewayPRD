<?php
require_once('database_config.php');
$iid = $_SESSION['iid'];
$db->where("id",$iid);
$data = $db->getOne("users");
$user_type = $data['user_type'];

$query = "SELECT DISTINCT(processor_id) as processor_id, processors.processor_name 
			FROM agent_bank_fees 
			INNER JOIN processors ON processors.p_id = agent_bank_fees.processor_id
			WHERE"; 
if($user_type != 1) {
	//ger agent id
	$u_id = $_POST['u_id'];
	$db->where("id",$u_id);
	$data = $db->getOne("users");
	$a_id = $data['agent_id'];
	$query .= " agent_id = ".$a_id." and ";
}	
$m_id = $_POST['m_id'];
$query .= " merchant_id = ".$m_id;

$merchant_processors = $db->rawQuery($query);
										
$result = '';
if(!empty($merchant_processors)){
	$result .= '<select name="processorid" id="processorid" class="form-control m-b">';
	$result .= '<option value="0">-- All Processors --</option>';
	foreach($merchant_processors as $merchant_processor)
	{
			$result .= '<option value="'.$merchant_processor["processor_id"].'">'.$merchant_processor["processor_name"].'</option>';
	}
	$result .= '</select>';
}
echo $result;
?>