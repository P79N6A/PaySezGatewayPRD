<?php

//error_reporting(0);

date_default_timezone_set('Etc/GMT-5');

require_once('include/helper.php'); // include Alain's helper functions
require_once('MysqliDb.php');
require_once('../api/encrypt.php');

// Enforce E_ALL, but allow users to set levels not part of E_ALL.
//error_reporting(E_ALL | error_reporting());

// initialize variables
$data = array();



// database configuration starts here //

// db var config
$server_host = $_SERVER['HTTP_HOST'];
$db_host = $confighost;
$dbpassdata="lkevacQaV6VckdEVKbAANqnxRfwspv6618DtG3D399dJST9ut/impGbyNP4mrqn4TB45yOmBdydBt1DR4FfsQd13T4LX5Wtprv4ADcPMZB/c7uDHY8WH2OMhGeH+hoyf|NinFqSYPFzRAARrSUMg5FwF5WjrjKNWMFVNrChgrWPM=";
$dbuserdata="KjQu4XDzpx6tbqhFGPUdfQaEUR/SjtQoiD9IHdx5H6qPa8O/jEUMjZL4s2bhtsa4qrbqb+UfIzUUPMOK2oFhP7JtN+6hwPGToyz1yuAoj83HbpwVfP+Z9SoUJqiJMA4J|ns24jfQxfvFyt2ac9jX0jCmWDkD8ik2dGYI6pboJ+kU=";
$dbkey="ccb5154d0fd67524f5aa6dc9dd388806022bd0c50831e10e9fef2e567b31ba76";

$userd=mc_decrypt($dbuserdata, $dbkey);
$passd=mc_decrypt($dbpassdata, $dbkey);

// $db_user = "supremeUser";
// $db_pass = "SupremeDb2018@Secure";
// $db_name = 'suprpaysez';

$db_user = "pguat";
$db_pass = "pguat";
$db_name = 'testSpaysez';

//$db = MysqliDb::getInstance();
//var_dump($db);exit();

$db = new Mysqlidb ($db_host, $db_user, $db_pass, $db_name);

// database configuration ends here //
if (isset($_GET['sid'])){ session_id($_GET['sid']); }
session_start();
ob_start();

//echo var_dump($_SESSION);
//die();

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

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
	echo '<a href="/login.php"> Please Login Againx</a>';
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
	echo '<a href="/login.php"> Please Login Againy</a>';

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
define("SITEURL", "https://".$_SERVER['HTTP_HOST']."/");

/**
 * Check if user session has the permission key
 * @param  [string] $permissionKey
 * @return [bool]
 */
function checkPermission($permissionKey) {
	return (in_array($permissionKey, $_SESSION['user_roles']));
}

/**
 * [sanitizeInput description]
 * @param  [string] $input the raw input
 * @return [string] the sanitized input
 */
function sanitizeInput($input) {
	//trim
	$input = trim($input);

	//escape html
	$input = htmlspecialchars($input);

	//strip tags
	$input = strip_tags($input);

	return $input;
}
