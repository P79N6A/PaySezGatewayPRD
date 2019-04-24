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

$query .= 	"SELECT idchargebacks,
					id_transaction_id,
					sale_transaction_id,
					m_id,
					merchants.merchant_name,
					reason_code,charged_date,
					cb_amount,
					chargebacks.first_name,
					chargebacks.last_name,
					status,
					cb_stati.name as status_name, 
					dispute_result"; 		
	$query .= 	" FROM chargebacks 
				  LEFT JOIN cb_stati ON cb_stati.cb_stati_id = chargebacks.status
			      INNER JOIN merchants ON merchants.idmerchants = chargebacks.m_id  
				  INNER JOIN users ON users.agent_id = merchants.affiliate_id";
	if($usertype['user_type'] =! 1) $query .= 	 " WHERE users.id = ".$iid;

if($new_chargebacks 	== 1)	
{ $query .=  " AND new = '1' ";} 
else
{			
	if($processorid > 0) $query .= 	" AND processor_id = ".$processorid." ";
	if($merchantid > 0) $query .= 	" AND m_id = ".$merchantid." ";

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
		$query .=  " AND DATE_FORMAT(cb_date, '%Y-%m') = '".$m_date."'";
		
	} elseif($date != '')
	{
		$query .=  " AND DATE_FORMAT(cb_date, '%Y-%m-%d') = '".$date."'";
		
	} else {
		if($period_start_date 	!= "" && $period_end_date	!= "") 		
		{ 
			$query .=  " AND cb_date BETWEEN '".$period_start_date."' AND '".$period_end_date."' ";
		} else {
			if($period_start_date 	!= "") 		{ $query .=  " AND cb_date >= '".$period_start_date."' ";  }
			if($period_end_date 	!= "") 		{ $query .=  " AND cb_date <= '".$period_end_date."' ";  }
		}
	}

	if($min_amount_range 	!= "") 	{ $query .=  " AND cb_amount >= ".$min_amount_range." ";  }
	if($max_amount_range 	!= "") 	{ $query .=  " AND cb_amount <= ".$max_amount_range." ";  }
	if($transaction_id 		!= "") 	{ $query .=  " AND sale_transaction_id like '%".$transaction_id."%' ";  }
	if($reference_number 	!= "") 	{ $query .=  " AND sale_transaction_id like '%".$reference_number."%' ";  }
	if($dispute_result 		!= 0) 	{ $query .=  " AND dispute_result = '".$dispute_result."' ";  }
	if($status 				!= 0) 	{ $query .=  " AND status = '".$status."' ";  }
	if($first_name 			!= "") 	{ $query .=  " AND chargebacks.first_name = '".$first_name."' ";  }
	if($last_name 			!= "") 	{ $query .=  " AND chargebacks.last_name = '".$last_name."' ";  }
	if($last4_ccn 			!= "") 	{ $query .=  " AND ccnum = '%".$last4_ccn."' ";  }

}

$query .= 	" ORDER BY idchargebacks DESC ";	
$query .= 	"  LIMIT 5000";	
						
if($new_chargebacks 	== 1)	
{
	$result = '<h2>All New Chargebacks</h2>';
} else {
	$result = '';
}
$chargebacks = $db->rawQuery($query);
if(!empty($chargebacks)){
	$result .= '<table class="table table-striped table-bordered table-hover dataTables-example">';
	/*<th class="black-cell"><input type="checkbox" name="selectall" id="selectall" value="0"  /></th>*/
	$result .= '<thead>
					<tr>
						<th>Chargback</th>
						<th>Transaction ID</th>
						<th>Merchant</th>
						<th>Reason</th>
						<th>Chargeback Date</th>
						<th>Amount</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Status</th>
						<th>Dispute Result</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';
	foreach($chargebacks as $cb)
	{
		/*<td><input type="checkbox" name="selected['.$cb["idchargebacks"].']" id="cb_'.$cb["idchargebacks"].'" value="'.$cb["idchargebacks"].'" /></td>*/
			$result .= '<tr class="gradeX">
							<td>'.$cb["idchargebacks"].'</td>
							<td>'.$cb["id_transaction_id"].'</td>
							<td>'.$cb["merchant_name"].'</td>
							<td>'.$cb["reason_code"].'</td>
							<td>'.$cb["charged_date"].'</td>
							<td>'.$cb["cb_amount"].'</td>
							<td>'.$cb["first_name"].'</td>
							<td>'.$cb["last_name"].'</td>
							<td>'.$cb["status_name"].'</td>
							<td>'.$cb["dispute_result"].'</td>
							<td style="font-size: 18px;white-space:nowrap;"><a href="chargeback.php?cb_id='.$cb["idchargebacks"].'" target="_blank"><i class="fa fa-pencil-square-o"></i></a></td>
						</tr>';
	}
	$result .= '</tbody></table>';
} else {
	$result = 'No Chargebacks Found';
}
echo $result;

?>