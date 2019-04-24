<?php 
require_once('database_config.php');
$cols = Array ("id", "environment", "api_key", "p.processor_name as processor_name", "g.processor_name as gateway_name");
$db->join("processors p", "p.p_id = mpm.processor_id", "INNER");
$db->join("processors g", "g.p_id = mpm.gateway_id", "INNER");
$db->where("merchant_id",$mid);
$apis = $db->get("merchant_processors_mid mpm", null, $cols);
?>