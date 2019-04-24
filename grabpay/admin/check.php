<?php

require_once('php/database_config.php');

$partner_id = $db->get('grabpay_config');

print_r($partner_id);
?>
