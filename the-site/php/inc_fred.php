<?php
require_once('database_config.php');
$iid = 133;

$user_users = array();
$db->where("id",$iid);
$user = $db->getOne("users");

$the_merchant =  $user["merchant_id"];
$the_agent =  $user["agent_id"];

//get all merchant users	
if($the_merchant != "" &&  $the_merchant != NULL )
{
	$db->where("merchant_id",$the_merchant);
	$merchant_users = $db->get("users");
	foreach($merchant_users as $merchant_user) {
		$user_users[] = array(
					"id" 			=> $merchant_user["id"],
					"username" 		=> $merchant_user["username"],
					"first_name" 	=> $merchant_user["first_name"],
					"last_name"	 	=> $merchant_user["last_name"]
					);
	}
}

//get all agent users
function getUserByAffiliation($db, $the_agent)
{
	$db->where("agent_id",$the_agent);
	$agent_users = $db->get("users");
	foreach($agent_users as $agent_user) {
		$user_users[] = array(
					"id" 			=> $agent_user["id"],
					"username" 		=> $agent_user["username"],
					"first_name" 	=> $agent_user["first_name"],
					"last_name"	 	=> $agent_user["last_name"]
					);
	}
	
	$db->where("idagents",$the_agent);
	$data = $db->getOne("agents");
	$affiliation = $data['affiliation'];
	if($affiliation != "" &&  $affiliation != NULL )
	{
		$user_users[] = getUserByAffiliation($db, $affiliation);
	}
	return $user_users;
}

if($the_agent != "" &&  $the_agent != NULL )
{
	$user_users[] = getUserByAffiliation($db, $the_agent);
}
var_dump($user_users);
?>