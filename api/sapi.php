<?php

date_default_timezone_set('Etc/GMT-5');

require_once('include/helper.php'); // include Alain's helper functions
require_once('MysqliDb.php');


// Enforce E_ALL, but allow users to set levels not part of E_ALL.
error_reporting(E_ALL | error_reporting());

// initialize variables
$data = array();



// database configuration starts here //

// db var config
$server_host = $_SERVER['HTTP_HOST'];
$db_host = 'localhost';
$db_user = '';
$db_pass = '';
$db_name = '';


// if( $server_host === 'https://rebanx.com' || $server_host === 'rebanx.com' || $server_host === 'www.rebanx.com' ):
if($server_host === 'rebanx.com' || $server_host === 'www.rebanx.com'):
	
	// live site db config
	// $db_user = 'rebanx84_norman';
	// $db_pass = 'cgz86UMAP47B';
	// $db_name = 'rebanx84_profitorious';
	$db_user = 'wwwreban_xxx';
	$db_pass = '8#JmVm&PGo-m';
	$db_name = 'wwwreban_xxx';

elseif( $server_host === 'rebanx.dev' ):

	// live site db config
	$db_user = 'homestead';
	$db_pass = 'secret';
	$db_name = 'rebanx';

elseif( $server_host === 'rebanx.app' ):

	// live site db config
	$db_user = 'homestead';
	$db_pass = 'secret';
	$db_name = 'rebanx';

elseif( $server_host === 'rebanx.local' ):

	// live site db config
	$db_user = 'root';
	$db_pass = '1234';
	$db_name = 'rebanx';

endif;

$db = new Mysqlidb ($db_host, $db_user, $db_pass, $db_name);

// database configuration ends here //
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
session_start();
ob_start();

// set cookies to secure 
/*$params = session_get_cookie_params();
if( isset($_COOKIE['PHPSESSID']) && $_COOKIE['PHPSESSID'] === session_id() ) {
	setcookie("PHPSESSID", session_id(), 0, $params["/"], $params["rebanx.com"],
	    true  // this is the httpOnly flag you need to set
	);
}*/

function ajax_redirect($url, $permanent=false, $statusCode=303) {
        if(!headers_sent()) {

            header('location: '.$url, $permanent, $statusCode);
        } else {
            echo "<script>location.href='$url'</script>";
        }
        exit(0);
}

if (!isset($_SESSION['LAST_ACTIVITY']) || (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	echo '<a href="/login.php"> Please Login Again</a>';
	echo '<script type="text/javascript">';
	echo 'alert("You have been logged out due to being idle");';  //not showing an alert box.
	echo 'window.location ="/login.php";</script>';
	echo "<script>window.top.location.href='/login.php'</script>";
	//ajax_redirect('/login.php');
	die();
	//header("Location:/login.php");exit;
}elseif(isset($_SESSION['id'])){
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}else{
	echo '<a href="/login.php"> Please Login Again</a>';
	
	?>
	<script type="text/javascript">
	alert("You have been logged out due to being idle");
	window.location. ="/login.php";</script>
	<?php
	echo "<script>window.top.location.href='/login.php'</script>";
	//ajax_redirect('/login.php');
	die();
}

//site url
define("SITEURL", "http://".$_SERVER['HTTP_HOST']."/");