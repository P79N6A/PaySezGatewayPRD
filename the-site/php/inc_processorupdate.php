<?php
require_once('database_config.php');
//filter post



if(isset($_POST['processor_id']))
{
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
}
?>