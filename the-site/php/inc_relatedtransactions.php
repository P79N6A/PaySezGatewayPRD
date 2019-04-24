<?php
require_once('database_config.php');
$t_id = $_POST['t_id'];

$db->join("actions a", "a.id_transaction_id = t.id_transaction_id", "LEFT");
$db->where("t.transaction_id",$t_id.'%', 'like');
$relatedtransactions = $db->get("transactions t");
$result = '<table class="table  table-striped">
			<thead>
			<tr>
				<th>Transaction ID</th>	
				<th>Date</th>
				<th>Type</th>
				<th>Result</th>
				<th>Amount</th>
			</tr>
			</thead>
			<tbody>';
			foreach($relatedtransactions as $trans){
			$transresult = ($trans["success"]==1)?"Succeeded":"Failed";
			$result .= '<tr>
				<td>'.$trans["id_transaction_id"].'</td>
				<td>'.$trans["transaction_date"].'</td>
				<td>'.$trans["action_type"].'</td>
				<td>'.$transresult.'</td>
				<td>'.number_format($trans["amount"],2).'</td>
			</tr>';
			}
			$result .= '</tbody>
		</table>';
		
echo $result;
?>