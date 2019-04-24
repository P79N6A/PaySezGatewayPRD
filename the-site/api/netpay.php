<?php
	if(!isset($_REQUEST['v'])) die('Nothing passed in...');
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	date_default_timezone_set('Canada/Eastern');
	
	include_once("netpayclient.php");
	$merid = buildKey("MerPrK_808080101694375_20141016142610.key");
	if(!$merid) {
		echo "Failed to import the private key file！";
		exit;
	}
	
	echo sign($_REQUEST['v']);
?>