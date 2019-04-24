<?php
require_once('database_config.php');
//filter post
if(isset($_POST['cb_edit']))
{
	foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
	}
	
	//response correspondance
	if($cb_new_response != '') {
		$newresponse = Array(	"type" => "merchant",
								"response_text" => $cb_new_response,
								"cb_id" => $cb_edit
		);
		$db->insert('cb_responses', $newresponse);
	}
	
	$data = Array ();
    if($cb_request_date != '') $data['cb_date'] = date('Y-m-d', strtotime($cb_request_date));
	if($cb_response_date != '') $data['response_date'] = date('Y-m-d', strtotime($cb_response_date));
	if($cb_update_date != '') $data['update_date'] = date('Y-m-d', strtotime($cb_update_date));
	if($cb_charged_date != '') $data['charged_date'] = date('Y-m-d', strtotime($cb_charged_date));
	if($cb_dispute_result != '') $data['dispute_result'] = $cb_dispute_result;
	if($cb_status != '') $data['status'] = $cb_status;
	if($cb_description != '') $data['description'] = $cb_description;
	if($cb_comment != '') $data['cb_comment'] = $cb_comment;

	$db->where ('idchargebacks', $cb_edit);
	if ($db->update ('chargebacks', $data))
	{
		echo '<div class="alert alert-success"  data-animation="fadeIn">Chargeback has beed saved successfully!</div>';
	}
	else
	{
		echo '<div class="alert alert-danger"  data-animation="fadeIn">Error' . $db->getLastError() . ' </div>';
	}	
	
	
}
?>