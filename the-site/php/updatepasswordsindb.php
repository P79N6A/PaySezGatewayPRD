<?php 
require_once('MysqliDb.php');
require_once('passwordhash.php');
error_reporting(E_ALL);
$data = array();
$db = new Mysqlidb ('10.10.90.5', 'root', '25kUHbWZTA', 'profitorius');
session_start();
$cols = Array ("id", "password");
$users = $db->get ("users", null, $cols);
//var_dump($users);

die('read me first inside the file');
//DO NOT RUN BELOW IF ALREADY RAN BEFORE!!!!
die('DO NOT RUN BELOW IF ALREADY RAN BEFORE!!!!');
foreach($users as $u){
$password = create_hash($u['password']);
$data = Array (
    'password' => $password
	);
$db->where ('id', $u['id']);
$db->update ('users', $data);
}

function loginUser($username, $password){
global $db;
	$db->where("username",$username);
	$db->where("password",$password);
	$data = $db->getOne("users");
    if($db->count > 0){
		return $data;
    }else{
		return false;
	}
}
?>
