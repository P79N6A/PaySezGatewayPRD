<?php
	session_start();
	$_SESSION['new_session'] = "asdsa";
	echo "<pre>";
	var_dump($_SESSION);
	echo "</pre>";

?>