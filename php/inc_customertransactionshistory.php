<?php
require_once('database_config.php');
$customer_email = $_POST['customer_email'];

$db->join("actions", "actions.id_transaction_id = transactions.id_transaction_id", "LEFT");
$db->where("email",$customer_email);
$transhistory = $db->get("transactions");

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
			foreach($transhistory as $trans){
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