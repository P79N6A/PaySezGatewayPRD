<?php

require_once('php/database_config.php');

if(isset($_SESSION['id'])) {
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {

    // last request was more than 30 minutes ago

    session_unset();     // unset $_SESSION variable for the run-time 

    session_destroy();   // destroy session data in storage

	echo '<script language="javascript">';

	echo 'alert("You have been logged out due to being idle");';  //not showing an alert box.

	echo 'window.location.href="testspaysez/grabpay/admin";</script>';

	//header("Location:login.php");exit;

}else{

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

}

$error = '';

if(isset($_GET['ilogout'])){

	$_SESSION['iid'] = $_SESSION['id'];

	$error = 'You Have Been Logged Out Of Your Assumed Identity';

	//die('You Have Been Logged Out Of Your Assumed Identity');

	header('Location: dashboard.php');

}

}

 ?>

<!DOCTYPE html>

<html>



<head>



    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>Gateway | Dashboard</title>

<link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">

<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">

<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">

<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">

<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">

<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">

<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">

<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">

<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">

<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">

<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">

<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">

<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">

<link rel="manifest" href="/favicon/manifest.json">

<meta name="msapplication-TileColor" content="#ffffff">

<meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">

<meta name="theme-color" content="#ffffff">

   <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

   	<link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

	<link href="css/plugins/dropzone/dropzone.css" rel="stylesheet">

	<link href="css/plugins/chosen/chosen.css" rel="stylesheet">

	<!-- Data Tables -->

    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">

    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

	

     <!-- Mainly scripts -->

    <script src="js/jquery-2.1.1.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>



    <!-- Custom and plugin javascript -->

    <script src="js/inspinia.js"></script>

    <script src="js/plugins/pace/pace.min.js"></script>



    <!-- Steps -->

    <script src="js/plugins/staps/jquery.steps.min.js"></script>



    <!-- Jquery Validate -->

    <script src="js/plugins/validate/jquery.validate.min.js"></script>

    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>





</head>









<body>

<div id="pageloaddiv">
    <div class="status"></div>
</div>