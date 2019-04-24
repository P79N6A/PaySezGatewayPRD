<?php
/** password resetter. You will need to have access to phpmyadmin (database) to use the hash and the new password. **/
require_once('php/inc_login.php');
$newpass = substr(str_shuffle(str_repeat("23456789abcdefghkmnpqrstuvwxyz", 8)), 0, 8);
$new_hash = create_hash($newpass);

echo '<strong>Generated Password to use to login:</strong><pre>' . $newpass . '</pre>';
echo '<br />';
echo '<strong>Generated Hash to be copied to database password field:<strong><pre>' . $new_hash . '</pre>';

//echo phpinfo();