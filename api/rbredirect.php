<?php
session_start();
$_SESSION['mangaaaa'] = "";
$reurl=$_SESSION['mangaaaaurl'];
unset($_SESSION["mangaaaa"]);
session_destroy();
$url=$_GET['url'];
header('Refresh:2; url= '.$url.'&success=false&trans=cancel&txn=null&errordesc=cancel');

?>
<html>
<head>
<title>Transaction Cancelled</title>
</head>
<body><br><br>
<center>
<h3>You pressed Back or Refresh. Transaction cancelled.</h3>
<h4 style="color:blue;">Redirecting to merchant..</h4>
</center>
</body>
</html>