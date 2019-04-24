<?php
require_once('database_config.php');
$m_id = $_POST['m_id'];

$env_v = $_POST['env_v'];
$query = "UPDATE `merchant_processors_mid` SET `environment`='".$env_v."' WHERE `merchant_id`='".$m_id."'";


$change = $db->rawQuery($query);
?>