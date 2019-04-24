<?php 
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 15-12-2017
 * Time: 16:54 PM
 */

$servername = "localhost";
$username = "urebanx";
$password = "Rebanxpg";
$dbname = "rebanx";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$mid=$_POST['merchantId'] ;
$env=$_POST['env'] ;
$sqlresp = 'select * from merchants where idmerchants="'.$mid.'" LIMIT 1';
$eresp=$conn->query($sqlresp);
$t=$eresp->fetch_assoc();
$gmid=$t['mer_map_id'];
if($env=='livem' || $env=='testm'){
if($gmid == "")
{
	$afm=array(
		'error_code' => 0,
		'Mermapid' => $gmid
	);
	echo json_encode($afm);
}
else {
	$afm=array(
		'error_code' => 1,
		'Mermapid' => ""
	);
	echo json_encode($afm);
}
}
else {
	$afm=array(
		'error_code' => 2,
		'Mermapid' => "NOT ALLOWED"
	);
	echo json_encode($afm);
}
