<?php
require_once('passwordhash.php');
//get user informetion
$first_name = "";
$last_name = "";
$title = "";
$email = "";
$username = "";
$type = "";
$resetpass = '';
$iid = $_SESSION['iid'];
$iiduserdata = getUserdata($iid);
$msg = '<span style="color:red">';
if(isset($_GET['userid']) && $_GET['userid'] > 0 ) {

	$userid = $_GET['userid'];
	//security check
	if($_SESSION['user_type'] != 1){
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
		if($the_agent != "" &&  $the_agent != NULL )
		{
			$user_users[] = getUserByAffiliation($db, $the_agent);
		}
		$security = true;
		foreach($user_users[0] as $uu) {
			if($uu['id'] == $userid){
				$security = false;
			}
		}
		if($security){
			$msg .= ' You are not authorized to edit this account.';
			die(' You are not authorized to edit this account.');
		}
	}
	$userlang = 'Edit User';
	$userinfo = getUserdata($userid);
	$edituserpage = '<input type="hidden" name="edituserform" id="edituserform" />';
	$resetpass = '<form role="form" id="resetpass" action="" method="post"><input type="hidden" id="reset_pass" name="reset_pass" /><button type="submit" id="resetpass" class="btn btn-md btn-primary pull-right m-t-n-xs"><strong>Reset User Password</strong></button></form>';
	//var_dump($userinfo);


	if(isset($_POST['edituserform'])){
			$edituser = edituser($userid, $_POST['first_name'], $_POST['last_name'], $_POST['email']);
			if($edituser){
				$msg .= ' The User has been edited';
			}else{
				$msg .= ' Failed to update user info';
			}
	}

	if(isset($_POST['reset_pass'])){
			$newpass = random_password(8);
			$new_hash = create_hash($newpass);
			if(ResetPass($userid, $new_hash)){
				$msg .= ' The new password for this account is: <b>'.$newpass.'</b>';
			}else{
				$msg .='Opps Something Happened and your password was not updated!';
			}
	}

//get all agent users
}else{
	$edituserpage = '<input type="hidden" name="adduserform" id="adduserform" />';
	$userlang = 'Add User';
	if(isset($_POST['adduserform'])) {
		//first do a check if username is already in db
		if(chkusernameex($_POST['username'])){
			$msg .=	'Username already in use Please Choose Another';	
		}else{
		//generate random password 
			$newpass = random_password(8);
			$new_hash = create_hash($newpass);
			$addnewu = addnewuserii($_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['username'],$_POST['user_type'], $iiduserdata, $new_hash);
			//echo $addnewu;die();
			if($addnewu){
				$msg .=	'New User Added and the password is: <b>'.$newpass.'</b>';
			}else{
				$msg .=	'Please Choose A User Type';
			}
		}
	}
}
$msg .= '</span>';
function chkusernameex($username){
	global $db;
	$db->where ("username", $username);
	$user = $db->getOne ("users");
	if ($db->count == 1){
		return true;
	} else {
		return false;
	}
}
function addnewuserii($first_name, $last_name, $email_address, $username, $user_type, $iiduserdata, $newpass){
	global $db;
	if($iiduserdate['agent_id'] = ''){
		$agent_id = NULL;
	}else{
		$agent_id = $iiduserdata['agent_id'];
	}
	if($iiduserdate['merchant_id'] = ''){
		$merchant_id = NULL;
	}else{
		$merchant_id = $iiduserdata['merchant_id'];
	}
	$data = Array (
		'first_name' => $first_name,
		'last_name' => $last_name,
		'email_address' => $email_address,
		'username' => $username,
		'password' => $newpass,
		'user_type' => $user_type,
		//get agent_id and merchant_id of current user iid to assign down
		'agent_id' => $iiduserdata['agent_id'],
		'merchant_id' => $iiduserdata['merchant_id']
	);
	//var_dump($db->insert('users', $data));
	//var_dump($db->getLastError());
	if ($db->insert('users', $data)){
		//echo "Last executed query was ". $db->getLastQuery();
		return true;
	}else{
		return false;
	}
}
function editUser($id, $first_name, $last_name, $email){
	global $db;
	$data = Array (
		'first_name' => $first_name,
		'last_name' => $last_name,
		'email_address' => $email
	);
	$db->where ('id', $id);
	if ($db->update ('users', $data)){
		return true;
	}else{
		return false;
	}
}

function getUserByAffiliation($db, $the_agent)
{	
	global $db;
	$user_users = array();
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
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
function ResetPass($id, $new_hash){
	global $db;
	$data = Array (
		'password' => $new_hash
	);
	$db->where ('id', $id);
	if ($db->update ('users', $data)){
		return true;
	}else{
		return false;
	}
}
?>