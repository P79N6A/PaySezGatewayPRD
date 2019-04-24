<?php

header("Content-type: image/png");
$string = "Some Text";
$im     = imagecreatefrompng("merchQR/sha.png");
$orange = imagecolorallocate($im, 220, 210, 60);

$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);

$font = 'fonts/OpenSans-Regular.ttf';

$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
// imagestring($im, 13, $px, 19, $string, $orange);
imagettftext($im, 10, 0, 10, 15, $black, $font, $string);
imagepng($im);
imagedestroy($im);



// // Set the content-type
// header('Content-type: image/png');

// // Create the image
// $im = "merchQR/qrimg000000000000110.png"; // imagecreatetruecolor(200, 20);

// // Create some colors
// $white = imagecolorallocate($im, 255, 255, 255);
// $grey = imagecolorallocate($im, 128, 128, 128);
// $black = imagecolorallocate($im, 0, 0, 0);
// imagefilledrectangle($im, 0, 0, 299, 19, $white);

// // The text to draw
// $text = $merchantname;
// // Replace path by your own font path
// $font = 'fonts/OpenSans-Regular.ttf';

// // Add some shadow to the text
// imagettftext($im, 10, 0, 10, 15, $grey, $font, $text);

// // Add the text
// imagettftext($im, 10, 0, 10, 15, $black, $font, $text);

// // Using imagepng() results in clearer text compared with imagejpeg()
// // imagepng($im);

// imagepng($im, 'merchQR/textimage.png');

// // imagedestroy($im);

// // return TRUE;

exit;



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
	$font = 'fonts/OpenSans-Regular.ttf';

	// Add some shadow to the text
	imagettftext($im, 10, 0, 10, 15, $grey, $font, $text);

	// Add the text
	imagettftext($im, 10, 0, 10, 15, $black, $font, $text);

	// Using imagepng() results in clearer text compared with imagejpeg()
	// imagepng($im);

	imagepng($im, 'merchQR/text_'.$merchantid.'.png');

	// imagedestroy($im);

	// return TRUE;

	exit;
}

echo text_image_create('A000011','Flemingo Duty Free Pvt Ltd');



// header('Content-type: image/png');

// // Create a blank image and add some text
// $im = imagecreatetruecolor(120, 20);
// $text_color = imagecolorallocate($im, 233, 14, 91);
// imagestring($im, 2, 15, 15,  'Flemingo', $text_color);

// // // Save the image as 'simpletext.jpg'
// // imagepng($im, 'merchQR/simpletext.png');

// // Output the image
// imagepng($im);

// // Free up memory
// imagedestroy($im);

/**** Set 1 ****/
// // Set the content-type
// header('Content-type: image/png');

// // Create the image
// $im = imagecreatetruecolor(300, 20);

// // Create some colors
// $white = imagecolorallocate($im, 255, 255, 255);
// $grey = imagecolorallocate($im, 128, 128, 128);
// $black = imagecolorallocate($im, 0, 0, 0);
// imagefilledrectangle($im, 0, 0, 299, 19, $white);

// // The text to draw
// $text = 'Flemingo Duty Free Pvt Ltd';
// // Replace path by your own font path
// $font = 'fonts/OpenSans-Regular.ttf';

// // Add some shadow to the text
// imagettftext($im, 10, 0, 10, 10, $grey, $font, $text);

// // Add the text
// imagettftext($im, 10, 0, 10, 10, $black, $font, $text);

// // Using imagepng() results in clearer text compared with imagejpeg()
// imagepng($im);
// imagedestroy($im);
/**** Set 1 End ****/

// header('Content-type: image/jpeg');

// // Load And Create Image From Source
// $our_image = imagecreatefromjpeg('img/chargebackbyvolume.jpg');

// // Allocate A Color For The Text Enter RGB Value
// $white_color = imagecolorallocate($our_image, 0, 0, 0);

// // Set Path to Font File
// $font_path = 'fonts/OpenSans-Regular.ttf';

// // Set Text to Be Printed On Image
// $text ="Welcome To Talkerscode";

// $size=10;
// $angle=0;
// $left=125;
// $top=200;
	
// // Print Text On Image
// imagettftext($our_image, $size,$angle,$left,$top, $white_color, $font_path, $text);

// // Send Image to Browser
// imagejpeg($our_image);

// // Clear Memory
// imagedestroy($our_image);


// header('Content-type: image/png');

// //Adding image center to an QRcode starts
// $imgname="merchQR/qrimgM00601110005000M0060111.png";
// $logo="merchQR/sha.png";
// $QR = imagecreatefrompng($imgname);
// $logopng = imagecreatefrompng($logo);
// $QR_width = imagesx($QR);
// $QR_height = imagesy($QR);
// $logo_width = imagesx($logopng);
// $logo_height = imagesy($logopng);

// list($newwidth, $newheight) = getimagesize($logo);
// $out = imagecreatetruecolor($QR_width, $QR_width);
// imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
// imagecopyresampled($out, $logopng, $QR_width/2.65, $QR_height/2.65, 0, 0, $QR_width/4, $QR_height/4, $newwidth, $newheight);
// imagepng($out,$imgname);
// imagedestroy($out);

?>