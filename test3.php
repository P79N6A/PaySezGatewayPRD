<!DOCTYPE html>
<html>
<head>
	<title>Click Jack Test page</title>
</head>
<body>

	<p>Website is vulnerable to clikcjacking</p>
	<iframe src="https://pg.credopay.net/forgot-password.php" width="700" height="700"></iframe>

<?php
//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if( $iPod || $iPhone ){
    //browser reported as an iPhone/iPod touch -- do something here
	echo "iphone ipod";
}else if($iPad){
    //browser reported as an iPad -- do something here
	echo "ipad";
}else if($Android){
    //browser reported as an Android device -- do something here
	echo "android";
}else if($webOS){
    //browser reported as a webOS device -- do something here
	echo "web";
}
echo $_SERVER['HTTP_USER_AGENT'];

?>
</body>
</html>