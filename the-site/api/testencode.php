<?php
//require_once('../php/MysqliDb.php');
//error_reporting(E_ALL);
//$db = new Mysqlidb('localhost', 'root', '25kUHbWZTA', 'profitorius');
//$data = array();
require_once('encrypt.php');
$key = '74946c614d25a4d1d6dffa96a814b3134f254ad2999fb4d2691cdeaa11f057e7';
$encrypt = 'CX81G4zxKSzo2vnQLorgUZ9wjjCziT8h93wRORkED5Q';
$decrypt = mc_encrypt($encrypt, $key);
$data = mc_decrypt($encrypt, $key);
print_r($data);
$myArray = explode(',', $data);
print_r($myArray);
