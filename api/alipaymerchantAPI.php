<?php
/**
* Created by Karthick Raja.
* Date: 08-10-2018
* Time: 02:00 PM
**/
// echo "<pre>";
// print_r($_POST); exit;
date_default_timezone_set('Asia/Kolkata');
require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
// $duser="KjQu4XDzpx6tbqhFGPUdfQaEUR/SjtQoiD9IHdx5H6qPa8O/jEUMjZL4s2bhtsa4qrbqb+UfIzUUPMOK2oFhP7JtN+6hwPGToyz1yuAoj83HbpwVfP+Z9SoUJqiJMA4J|ns24jfQxfvFyt2ac9jX0jCmWDkD8ik2dGYI6pboJ+kU=";
// $dcode="lkevacQaV6VckdEVKbAANqnxRfwspv6618DtG3D399dJST9ut/impGbyNP4mrqn4TB45yOmBdydBt1DR4FfsQd13T4LX5Wtprv4ADcPMZB/c7uDHY8WH2OMhGeH+hoyf|NinFqSYPFzRAARrSUMg5FwF5WjrjKNWMFVNrChgrWPM=";

$duser = 'yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=';
$dcode = '66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=';

//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
require_once('encrypt.php');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);
$db  = new Mysqlidb ('10.162.104.214', $userd, $passd, 'testSpaysez');
$db1 = new Mysqlidb ('10.162.104.214', $userd, $passd, 'mpi');

require_once('merchant_addupdate_api.php');

$log_path = '/var/www/html/testspaysez/api/merchantslogs.log';

function poslogs($log) {
	GLOBAL $log_path;
	$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
	return $myfile;     
}

/**** Request as "JSON with POST" OR "Form with POST" methods ****/
$json_str = file_get_contents('php://input');
if($json_str!=null) {
	$_POST = array_merge($_POST, (array) json_decode(file_get_contents('php://input')));
} else {
	$_POST = $_POST;
}

header('Content-Type: application/json');

// $db->where('mer_map_id', $_POST['pg_merchant_id']);
// $lastid = $db->getone("merchants");

// echo "<pre>";
// print_r($lastid); 

// echo "<br>";
// print_r($lastid['idmerchants']); exit;

if($_POST['pg_merchant_id']!="" && !isset($_POST['pg_terminal_id'])) {

	$_POST['Permission1'] = 1;
	$_POST['Permission2'] = 1;
	$_POST['Permission3'] = 1;
	$_POST['Permission4'] = 1;

	$logs = "Merchant Request Data:".date("Y-m-d H:i:s") . "," .json_encode($_POST). " \n\n";
	poslogs($logs);

	$db->where('mer_map_id', $_POST['pg_merchant_id']);
    $lastid = $db->getone("merchants");

	if($lastid['idmerchants'] == "" && $_POST['pg_merchant_action'] == 1) {
		$results = merchantaddupdatestatus($_POST,$_POST['pg_merchant_action'],'');

		$logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant Added successfully';
	} else if($lastid['idmerchants'] == "" && ($_POST['pg_merchant_action'] == 2 || $_POST['pg_merchant_action'] == 3)) {
		$results = [
			"MerchantID"   => $_POST['pg_merchant_id'],
	        "ResponseDesc" => "Merchant ID is Not Found, So please Add",
	        "ResponseCode" => "F"
	    ];
	    $logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant ID is Not Found, So please Add';
	} else if($lastid['idmerchants'] != "" && $_POST['pg_merchant_action'] == 2) {
		$results = merchantaddupdatestatus($_POST,$_POST['pg_merchant_action'],$lastid['idmerchants']);
		$logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant Updated successfully';
	} else if($lastid['idmerchants'] != "" && $_POST['pg_merchant_action'] == 3) {
		$results = merchantaddupdatestatus($_POST,$_POST['pg_merchant_action'],$lastid['idmerchants']);
		$logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant Status In-Activated successfully';
	} else {
		$results = [
			"MerchantID"   => $_POST['pg_merchant_id'],
	        "ResponseDesc" => "Merchant ID Already Exists, So Not Added",
	        "ResponseCode" => "F"
	    ];
	    $logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant ID Already Exists, So Not Added';
	}

} else if($_POST['pg_merchant_id']!="" && $_POST['pg_terminal_id']!= "") {

	$logs = "Terminal Request Data:".date("Y-m-d H:i:s") . "," .json_encode($_POST). " \n\n";
	poslogs($logs);
	
	$db->where('mer_map_id', $_POST['pg_merchant_id']);
    $lastid = $db->getone("merchants");

    if($lastid['idmerchants']!="") {
    	$db->where('idmerchants', $lastid['idmerchants']);
	    $db->where('mso_terminal_id', $_POST['pg_terminal_id']);
	    $terminal_lastid = $db->getone("terminal");

	    $db->where('mso_terminal_id', $_POST['pg_terminal_id']);
	    $terminal_idlast = $db->getone("terminal");

	    // echo $terminal_lastid['id'].'=>'.$terminal_idlast['id'].'=>'.$_POST['pg_terminal_action'];
	    if($terminal_lastid['id'] == "" && $terminal_idlast['id'] != "") {
	    	$results = [
	    		"MerchantID"   => $_POST['pg_merchant_id'],
	    		"TerminalID"   => $_POST['pg_terminal_id'],
		        "ResponseDesc" => "Terminal ID Already Exists for another merchant, So Not Added/Updated for this merchant",
		        "ResponseCode" => "F"
		    ];
		    $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
            poslogs($logs);
            // echo 'Terminal ID Already Exists for another merchant, So Not Added/Updated for this merchant';
	    } else if($terminal_lastid['id'] == "" && $terminal_idlast['id'] == "" && $_POST['pg_terminal_action'] == 1) {
	    	$results = terminaladdupdatestatus($_POST,$_POST['pg_terminal_action'],$lastid['idmerchants']);
	    	$logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
            poslogs($logs);
            // echo 'Terminal Added successfully';
	    } else if($terminal_lastid['id'] == "" && $terminal_idlast['id'] == "" && ($_POST['pg_terminal_action'] == 2 || $_POST['pg_terminal_action'] == 3)) {
			$results = [
				"MerchantID"   => $_POST['pg_merchant_id'],
				"TerminalID"   => $_POST['pg_terminal_id'],
		        "ResponseDesc" => "Terminal ID is Not Found, So please Add",
		        "ResponseCode" => "F"
		    ];
		    $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
            poslogs($logs);
            // echo 'Terminal ID is Not Found, So please Add';
		} else if($terminal_lastid['id'] != "" && $_POST['pg_terminal_action'] == 2) {
			$results = terminaladdupdatestatus($_POST,$_POST['pg_terminal_action'],$lastid['idmerchants']);
				$logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
            poslogs($logs);
            // echo 'Terminal Updated successfullys';
		} else if($terminal_lastid['id'] != "" && $_POST['pg_terminal_action'] == 3) {
			$results = terminaladdupdatestatus($_POST,$_POST['pg_terminal_action'],$lastid['idmerchants']);

			if($_POST['pg_terminal_status'] == 1) { 
	            $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
	        } else if($_POST['pg_terminal_status'] == 2) {
	            $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
	        }
            poslogs($logs);
            // echo 'Terminal Status Activated successfully';
		} else {
			$results = [
				"MerchantID"   => $_POST['pg_merchant_id'],
				"TerminalID"   => $_POST['pg_terminal_id'],
		        "ResponseDesc" => "Terminal ID Already Exists for that merchant, So Not Added",
		        "ResponseCode" => "F"
		    ];
		    $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
            poslogs($logs);
            // echo 'Terminal ID Already Exists for that merchant, So Not Added';
		}
		// exit;
    } else {
    	$results = [
				"MerchantID"   => $_POST['pg_merchant_id'],
				"TerminalID"   => $_POST['pg_terminal_id'],
		        "ResponseDesc" => "Merchant ID not Exists",
		        "ResponseCode" => "F"
	    ];
	    $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant ID not Exists';
    }
    
} else {
	if(isset($_POST['pg_merchant_id']) && $_POST['pg_merchant_id'] == "") {
		$results = [
	        "ResponseDesc" => "Merchant ID is mandatory",
	        "ResponseCode" => "F"
	    ];
	    $logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Merchant ID is mandatory';
	}
	if(isset($_POST['pg_terminal_id']) && $_POST['pg_terminal_id'] == "") {
		$results = [
	        "ResponseDesc" => "Terminal ID is mandatory",
	        "ResponseCode" => "F"
	    ];
	    $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
        poslogs($logs);
        // echo 'Terminal ID is mandatory';
	}
}

echo json_encode($results);

function text_image_create($merchantid,$merchantname) {
	// Set the content-type
	header('Content-type: image/png');

	// Create the image
	$im = imagecreatetruecolor(200, 20);

	// Create some colors
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, 299, 19, $white);

	// The text to draw
	$text = $merchantname;
	// Replace path by your own font path
	$font = '../fonts/OpenSans-Regular.ttf';

	// Add some shadow to the text
	imagettftext($im, 10, 0, 10, 15, $grey, $font, $text);

	// Add the text
	imagettftext($im, 10, 0, 10, 15, $black, $font, $text);

	// Using imagepng() results in clearer text compared with imagejpeg()
	// imagepng($im);

	imagepng($im, '../merchQR/text_'.$merchantid.'.png');

	imagedestroy($im);

	exit;
}

