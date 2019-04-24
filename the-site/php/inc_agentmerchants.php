<?php
require_once('database_config.php');
$iid = $_SESSION['iid'];
$db->where("id",$iid);
$data = $db->getOne("users");
$user_type = $data['user_type'];
$a_id = $_POST['a_id'];
if($user_type != 1) {
	$query = "SELECT DISTINCT(idmerchants), merchant_name, users.agent_id FROM users
			  INNER JOIN merchants ON users.agent_id = merchants.affiliate_id
			  WHERE merchants.affiliate_id = ".$a_id;
	$query .= " WHERE users.id = ".$iid;	
} else {
	$query = "SELECT DISTINCT(idmerchants), merchant_name FROM merchants WHERE merchants.affiliate_id =".$a_id;
}
$agent_merchants = $db->rawQuery($query);	 							
$result = '';
if(!empty($agent_merchants)){
	$result .= '<select name="processorid" id="processorid" class="form-control m-b">';
	$result .= '<option value="0">-- All Merchants --</option>';
	foreach($agent_merchants as $agent_merchant)
	{
			$result .= '<option value="'.$agent_merchant["idmerchants"].'">'.$agent_merchant["merchant_name"].'</option>';
	}
	$result .= '</select>';
} else {
	$result .= '<select name="processorid" id="processorid" class="form-control m-b">';
	$result .= '<option value="0">-- All Merchants --</option>';
	$result .= '</select>';
}
echo $result;
?>