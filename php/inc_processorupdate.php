<?php
require_once('database_config.php');
//filter post
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


if(isset($_POST['processor_id']))
{

	$isd=$_POST['processor_id'];	
	$db->where('p_id',$isd);
    $datas1 = $db->getOne("processors");
	//$old_values=json_encode($datas1);	
	 $old_values=json_encode($datas1);	
	
	
/*	$result = mysqli_query("SELECT * FROM processors WHERE p_id = '$processor_id'");
	$row = mysqli_fetch_array($result);	*/

	foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
	}
	if(($p_bussiness_name != '') && ($p_short_name != '')&& ($p_wire_fee != ''))
	{
		$data = Array ();
		if($p_bussiness_name != '') 	$data['processor_name'] 	= $p_bussiness_name;
		if($p_short_name != '') 		$data['processor_name2'] 	= $p_short_name;
		if($p_email != '') 				$data['email'] 				= $p_email;
		if($p_wire_fee != '') 			$data['wire_fee'] 			= $p_wire_fee;
		if($processor_type != '') 		$data['gateway_or_bank'] 	= $processor_type;
		if($processor_timezone != '') 	$data['processor_timezone'] = $processor_timezone;
		$data['integrated_to_prof'] = (isset($_POST["integrated"]))?1:0;

		
		
		
		
		$db->where ('p_id', $processor_id);
		if ($db->update ('processors', $data))
		{
		
			echo '<div class="alert alert-success"  data-animation="fadeIn">Processor has beed updated successfully!</div>
			<script>
				$(document).ready(function () {
						$.ajax({
							method: "POST",
							url: "php/inc_processorstable.php"
						})
						.done(function( msg ) {
							$("#processorlist").html(msg);
							$(".dataTables-processors").dataTable({
								"order": [[ 0, "desc" ]],
								responsive: true
							});
						});
				});
        </script>';		
		}
		else
		{
			echo '<div class="alert alert-danger"  data-animation="fadeIn">Error' . $db->getLastError() . ' </div>';
		}	
	} else
	{
			echo '<div class="alert alert-danger"  data-animation="fadeIn">All fields are required! </div>';
	}
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $user_id=$_SESSION['iid'];
        $event="Edit Processor";
        $auditable_type="CORE PHP AUDIT";
        $new_values=json_encode($data);       		
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent= $_SERVER['HTTP_USER_AGENT'];
        audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip, $user_agent);
			
	   
}
?>