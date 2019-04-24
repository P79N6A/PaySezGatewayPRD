<?php
require_once('database_config.php');
$iid = $_SESSION['iid'];

function getUserType($id){
global $db;
	$db->where("id",$id);
    $data = $db->getOne("users");
	return $data;
}

$usertype = getUserType($iid);
$merchantid	= $usertype['merchant_id'];
foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
	}

$query = 	"";
$query .= 	"SELECT t.id_transaction_id as id, t.transaction_id as transaction_id,
				transaction_date as date,
				action_type as type,
				success as status,
				a.amount as amount,
				t.first_name as first_name,
				t.last_name as last_name,
				t.address1 as address1, t.address2 as address2,
				t.city as city,
				t.us_state as state,
				t.postal_code as postal_code,
				t.email as email"; 		
$query .= 	" FROM transactions t
			  INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id
			  INNER JOIN merchants m ON m.idmerchants = t.merchant_id  
			  INNER JOIN users u ON u.agent_id = m.affiliate_id";
if($usertype['user_type'] =! 1) $query .= 	 " WHERE u.id = ".$iid;

$query .= 	" WHERE 1 = 1 "; 
		
if($processorid > 0) $query .= 	"AND t.processor_id = ".$processorid." ";
if($merchantid > 0) $query .= 	"AND t.merchant_id = ".$merchantid." ";

//Filters
$m_d = DateTime::createFromFormat("m/d/Y", $m_date);
$d = DateTime::createFromFormat("m/d/Y", $date);
$psd = DateTime::createFromFormat("m/d/Y", $period_start_date);
$ped = DateTime::createFromFormat("m/d/Y", $period_end_date); 
$m_date 	= date_format($m_d, 'Y-m');
$date 	= date_format($d, 'Y-m-d');
$period_start_date 	= date_format($psd, 'Y-m-d');
$period_end_date 	= date_format($ped, 'Y-m-d'); 
//$start_date_unix = date_format($date_timepicker_start_val, 'U'); //to timestamp
if($m_date != '')
{
	$query .=  " AND DATE_FORMAT(transaction_date, '%Y-%m') = '".$m_date."'";
	
} elseif($date != '')
{
	$query .=  " AND DATE_FORMAT(transaction_date, '%Y-%m-%d') = '".$date."'";
	
} else {
	if($period_start_date 	!= "" && $period_end_date	!= "") 		
	{ 
		$query .=  " AND a.transaction_date BETWEEN '".$period_start_date."' AND '".$period_end_date."' ";
	} else {
		if($period_start_date 	!= "") 		{ $query .=  " AND a.transaction_date >= '".$period_start_date."' ";  }
		if($period_end_date 	!= "") 		{ $query .=  " AND a.transaction_date <= '".$period_end_date."' ";  }
	}
}
if($min_amount_range 	!= "") 		{ $query .=  " AND a.amount >= ".$min_amount_range." ";  }
if($max_amount_range 	!= "") 		{ $query .=  " AND a.amount <= ".$max_amount_range." ";  }
if($transaction_id 		!= "") 		{ $query .=  " AND a.id_transaction_id like '%".$transaction_id."%' ";  }
if($transaction_type 	!= "all") 	{ $query .=  " AND  action_type = '".$transaction_type."' ";  }
if($transaction_status 	!= "-1") 	{ $query .=  " AND success = ".$transaction_status." ";  }
if($order_id 			!= "") 		{ $query .=  " AND order_id = ".$order_id." ";  }

if($first_name 			!= "") 	{ $query .=  " AND t.first_name = '".$first_name."' ";  }
if($last_name 			!= "") 	{ $query .=  " AND t.last_name = '".$last_name."' ";  }
if($phone 				!= "") 	{ $query .=  " AND t.phone = '".$phone."' ";  }
if($email 				!= "") 	{ $query .=  " AND t.email = '".$email."' ";  }
if($customer_ip_address != "") 	{ $query .=  " AND ipaddress = '".$customer_ip_address."' ";  }
if($last4_ccn 			!= "") 	{ $query .=  " AND cc_number = '%".$last4_ccn."' ";  }

$query .=  " LIMIT 5000";
				
$result = 'No Transactions Found';
$transactions = $db->rawQuery($query);

if(!empty($transactions)){
	$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
	$result .= '<thead>
					<tr>
						<th>Transaction ID</th>
						<th>Date</th>
						<th>Type</th>
						<th>Status</th>
						<th>Amount</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>ZIP/Postal Code</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>';
	foreach($transactions as $tr)
	{
			$tstatus = ($tr["status"] == 0 ? 'failed' : 'completed');
			$result .= '<tr class="gradeX">
							<td>'.$tr["id"].'</td>
							<td>'.$tr["date"].'</td>
							<td>'.$tr["type"].'</td>
							<td>'.$tstatus.'</td>
							<td>'.$tr["amount"].'</td>
							<td>'.$tr["first_name"].'</td>
							<td>'.$tr["last_name"].'</td>
							<td>'.$tr["address1"].'</td>
							<td>'.$tr["city"].'</td>
							<td>'.$tr["state"].'</td>
							<td>'.$tr["postal_code"].'</td>
							<td>'.$tr["email"].'</td>
							<td><a target="_blank" href="transactiondetails.php?t_id='.$tr["id"].'"><i class="fa fa-folder-open fa-2x"></i></a></td>
						</tr>';
	}
	$result .= '</tbody></table>';
}

echo $result;

?>