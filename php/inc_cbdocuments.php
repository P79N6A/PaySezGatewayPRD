<?php
require_once('database_config.php');
$cb_id = $_POST['cb_id'];
$transaction_id = $_POST['transaction_id'];


//correspondance
$db->join("users", "supporting_documents.user_id=users.id", "LEFT");
$db->where("cb_id",$cb_id);
$cb_documents = $db->get("supporting_documents");
$result = '<table class="table  table-striped">
			<thead>
			<tr>
				<th>Supporting Document</th>
				<th>Date</th>
				<th>User</th>
			</tr>
			</thead>
			<tbody>';
			foreach($cb_documents as $cb_document){
			$ext = end(explode(".",$cb_document["filename"]));
			switch ($ext) {
				case 'docx':
					$icon = '-word';
					break;
				case 'jpg':
					$icon = '-image';
					break;
				case 'jpeg':
					$icon = '-image';
					break;
				case 'png':
					$icon = '-image';
					break;
				case 'xlsx':
					$icon = '-excel';
					break;
				case 'pdf':
					$icon = '-pdf';
					break;
				case 'zip':
					$icon = '-zip';
					break;
				default:
					$icon = '';
					
			}
			$result .= '<tr>
				<td><a href="../transactions/'.$cb_id.'/'.$cb_document["filename"].'" target="_blank"><i class="fa fa-file'.$icon.'-o"></i> '.$cb_document["filename"].'</a></td>
				<td>'.$cb_document["timestamp"].'</td>
				<td>'.$cb_document["first_name"].' '.$cb_document["last_name"].'</td>
			</tr>';
			}
			$result .= '</tbody>
		</table>';
		
echo $result;
?>