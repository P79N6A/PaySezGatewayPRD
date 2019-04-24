<?php

// connect to mysql
$connection = new mysqli('10.162.104.214', 'pguat', 'pguat', 'testSpaysez');
echo "Before: " . memory_get_peak_usage() . "\n";
echo "<br>";

$res = $connection->query('SELECT * FROM `transactions` LIMIT 1');
echo "Limit 1: " . memory_get_peak_usage() . "\n";
echo "<br>";

$res = $connection->query('SELECT * FROM `transactions` LIMIT 10000');
echo "Limit 10000: " . memory_get_peak_usage() . "\n";
echo "<br>";

?>