<?php
require_once('database_config.php');
	//check if username exsist already
		global $db;
	$db->where ("username", $_POST['username']);
	$user = $db->getOne ("users");
	if ($db->count == 1){
		echo 'exist';
	} else {
		echo 'not-exist';
	}
?>