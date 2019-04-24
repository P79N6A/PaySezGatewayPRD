<?php 

require_once('head.php');


require_once('php/inc_dashboard.php'); 


function audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip,$user_agent){

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
    
	global $db;
    $db->insert('audits', $data);   
    date_default_timezone_set("Asia/Kolkata");
    $lmsg =date("d-M-Y H:i:sa") . "\n".
        "-----------------------------------" ."\n". "user_id=" . $user_id ."\n" ."event=" . $event ."\n" . "auditable_type=" . $auditable_type . "\n" ."new_values=" . $new_values ."\n" . "old_values=" . $old_values ."\n" ."&url=" . $url . "\n" ."ip_address=" . $ip ."\n" . "user_agent=" . $user_agent."\n" ;

    $logfile='auditLog/auditLog.log';
    file_put_contents($logfile,$lmsg."\n", FILE_APPEND | LOCK_EX);

}

// dd($_SESSION['iid']);
?>

    <div id="wrapper">

       <?php  require_once('navigation.php'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">

        <?php require_once('topnavbar.php'); ?>


    