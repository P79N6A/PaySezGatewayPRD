<?php
require_once('database_config.php');
$result = "";
if(isset($_POST['action']) && $_POST['action'] == 'add_processor')
{
	foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
	}
	
	$data = Array ();
    if($processor_name != '') 	$data['processor_name'] 	= $processor_name;
	if($processor_name2 != '') 		$data['processor_name2'] 	= $processor_name2;
	if($email != '') 				$data['email'] 				= $email;
	if($wire_fee != '') 			$data['wire_fee'] 			= $wire_fee;
	if($gateway_or_bank != '') 		$data['gateway_or_bank'] 	= $gateway_or_bank;
	if($processor_timezone != '') 	$data['processor_timezone'] = $processor_timezone;
	$data['integrated_to_prof'] 	= (isset($_POST["integrated_to_prof"]))?1:0;

	if ($db->insert ('processors', $data))
	{
		$result = '<div class="alert alert-success"  data-animation="fadeIn">Processor has been added successfully!</div>';
	}
	else
	{
		$result = '<div class="alert alert-danger"  data-animation="fadeIn">Error: Duplicate Name Exists</div>';
	}	
}

$processors = $db->get("processors");
?>