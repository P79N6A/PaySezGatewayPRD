<?php
function audittrail($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip,$user_agent){
	
require_once('./php/MysqliDb.php');
$db = new Mysqlidb ('localhost', 'root', '', 'rebanx2');

  $data = Array (
        "user_id" => $user_id,
        "event" => $event,
        "auditable_type" => $auditable_type,
		"new_values" =>$new_values,
        "old_values" => $old_values,
        "url" => $url,
        "ip_address" => $ip,
        "user_agent" => $user_agent	
		);
   $db->insert('audits', $data); 
   
 /*  $txt = "user id date";
 $myfile = file_put_contents('logs.log', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
   */
   
  
$lmsg =date("d-M-Y H:i:sa") . "\n".
					"-----------------------------------" ."\n". "user_id=" . $user_id ."\n" ."event=" . $event ."\n" . "auditable_type=" . $auditable_type . "\n" ."new_values=" . $new_values ."\n" . "old_values=" . $old_values ."\n" . "&url=" . $url . "\n" ."ip_address=" . $ip ."\n" . "user_agent=" . $user_agent."\n" ;
	
//$logfile='log/log_'.date('d-M-Y') .'.log';
$logfile='log/auditLog.log';
file_put_contents($logfile,$lmsg."\n", FILE_APPEND | LOCK_EX);

}