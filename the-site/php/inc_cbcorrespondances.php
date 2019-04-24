<?php
require_once('database_config.php');
$cb_id = $_POST['cb_id'];

//correspondance
$db->join("users", "cb_responses.user_id=users.id", "LEFT");
$db->where("cb_id",$cb_id);
$cb_responses = $db->get("cb_responses");

$result = '<table class="table  table-striped">
			<thead>
			<tr>
				<th>Response ID</th>
				<th>Type</th>
				<th>Date</th>
				<th>Response Text</th>
				<th>User</th>
			</tr>
			</thead>
			<tbody>';
			foreach($cb_responses as $cb_response){
			$result .= '<tr>
				<td>'.$cb_response["cb_response_id"].'</td>
				<td>'.$cb_response["type"].'</td>
				<td>'.$cb_response["timestamp"].'</td>
				<td>'.$cb_response["response_text"].'</td>
				<td>'.$cb_response["first_name"].' '.$cb_response["last_name"].'</td>
			</tr>';
			}
			$result .= '</tbody>
		</table>';
		
echo $result;
?>