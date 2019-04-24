<?php
date_default_timezone_set('Asia/Kolkata');

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';

error_reporting(0);
require_once('api/encrypt.php');
require_once('api/baseurl.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

// ****DB Connection****
$db  = new Mysqlidb ($dburl, $userd, $passd, $dbname);

// $terminal_ids = ['E0000011','E0000004','T0000004','E0000003','E0000005','T0000005','T0000006'];
// foreach ($terminal_ids as $key => $terminal_id) {
// 	$ddata = array(
// 	   "mso_ter_img_path" => NULL
// 	);
// 	$db->where('mso_terminal_id', $terminal_id);
// 	$val = $db->update('terminal', $ddata);
// }
// exit;

$que1 ="SELECT idmerchants, mso_terminal_id FROM terminal WHERE mso_ter_img_path IS NULL OR mso_ter_img_path='' OR mso_ter_img_path='NULL'";
$terminalDet = $db->rawQuery($que1);

// echo count($terminalDet); exit;

if(count($terminalDet) > 0) {
	foreach ($terminalDet as $key => $value) {
		// echo $value['idmerchants']." => ".$value['mso_terminal_id'];
		// echo "<br>";
		$db->where("idmerchants",$value['idmerchants']);
		$dgot = $db->getOne("merchants");
		$mer_map_id = $dgot['mer_map_id'];
		$merchantname = $dgot['merchant_name'];
		$terminal_id = $value['mso_terminal_id'];

		$update = text_image_create($mer_map_id, $merchantname,$terminal_id);

		if($update == TRUE) {
			echo $value['idmerchants']." => ".$value['mso_terminal_id']." Text Image Created and Updated";
		} else {
			echo $value['idmerchants']." => ".$value['mso_terminal_id']." Text Image Not Created";
		}
	}
}




function text_image_create($merchantid,$merchantname,$terminalid) {

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
	$text = substr($merchantname, 0, 15)." - ".$terminalid;
	// Replace path by your own font path
	$font = '/var/www/html/testspaysez/fonts/OpenSans-Regular.ttf';

	// Add some shadow to the text
	imagettftext($im, 10, 0, 10, 15, $grey, $font, $text);

	// Add the text
	imagettftext($im, 10, 0, 10, 15, $black, $font, $text);

	// Using imagepng() results in clearer text compared with imagejpeg()
	// imagepng($im);

	imagepng($im, '/var/www/html/testspaysez/merchTXT/text_'.$merchantid.$terminalid.'.png');

	imagedestroy($im);

	global $db;
	$ddata = array(
	   "mso_ter_img_path" => 'merchTXT/text_'.$merchantid.$terminalid.'.png'
	);
	$db->where('mso_terminal_id', $terminalid);
	$val = $db->update('terminal', $ddata);
	return TRUE;
	exit;
}