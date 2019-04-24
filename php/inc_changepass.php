<?php
//require_once('mcrypt.php');
require_once('passwordhash.php');

$msg ='Please enter your old password for security';
if (isset($_POST['oldpassword'])) {
	$oldpass = $_POST['oldpassword']; 
	$newpass = $_POST['newpass']; 
	$cnewpass = $_POST['cnewpass']; 

	//print_r($oldpass);exit();

	
	if(($newpass != $cnewpass) || (empty($newpass)) || (empty($cnewpass)))
	{
		$error = 'Your new password was not typed in correctly twice.';
	}
	//check if old password matches
	if(chkUserPass($_SESSION['id'], $oldpass)){
		$error = 'Your old password did not match.';
	}
	if($error == '')
	{	
		$new_hash = create_hash($newpass);
		//die('ok');
		$msg = ChangePassword($_SESSION['id'], $new_hash);
	}else{
		$msg = $error;
	}
}
function ChangePassword($id, $new_hash){
	global $db;
	$data = Array (
		'password' => $new_hash,
		'is_first_login' => 0
	);
	$db->where ('id', $id);
	if ($db->update ('users', $data)){
		return 'Your password has been updated';
	}else{
		return 'Opps Something Happened and your password was not updated!';
	}
}
function chkUserPass($id, $password){
global $db;
	$db->where("id",$id);
	//$db->where("password",$password);
	$data = $db->getOne("users");
	//$password = 'test';
	//$correct_hash = create_hash($password);
	//echo 'the hash is: '.$correct_hash.'<br />';
	//$valide = validate_password($password, $correct_hash);
	//echo 'the valide is: '.$valide;
	//var_dump($data);
	$result = validate_password($password, $data['password']);
	
	//die();
    if($result == 1){
		return false;
	}else{
		return true;
	}
	/*
	if($db->count > 0){
		return $data;
    }else{
		return false;
	}
	*/
}
?>