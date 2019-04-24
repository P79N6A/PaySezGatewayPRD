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

$processor_id=$_POST['processorid'];
$merchantid=$_POST['merchantid'];


$sdate=$_POST['period_start_date']. '00:00:00';
$edate=$_POST['period_end_date'] . '23:59:59';

$val1= date('Y-m-d H:i:s', strtotime($sdate));
$val2= date('Y-m-d H:i:s', strtotime($edate));

$iiiiid=$_POST['merchantid'];

if($merchantid==0)
{
	
	if($val1!='' && $val2!='' && $merchantid!=0){
		
		$query="SELECT * FROM transactions WHERE 
		server_datetime_trans >= '$val1' AND server_datetime_trans <= '$val2'";
		
		
		$result = 'No Transactions Found';
		$transactions = $db->rawQuery($query);
		
		if(!empty($transactions)){
			$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			$result .= '<thead>
					<tr>
						<th>Transaction ID</th>
						<th>Date</th>						
						<th>Status</th>
						<th>Amount</th>
						<th>First Name</th>
						<th>Address</th>						
						<th>ZIP/Postal Code</th>
						<th>Email</th>
						<th>RRN</th>
						<th></th>
					</tr>
				</thead>
				<tbody>';
		foreach($transactions as $tr)
		{
			$tstatus = ($tr["status"] == 0 ? 'failed' : 'completed');
			$result .= '<tr class="gradeX">
							<td>'.$tr["id_transaction_id"].'</td>
							<td>'.$tr["server_datetime_trans"].'</td>							
							<td>'.$tr["condition"].'</td>						
							<td>'.$tr["amount"].'</td>
							<td>'.$tr["first_name"].'</td>							
							<td>'.$tr["address1"].'</td>							
							<td>'.$tr["postal_code"].'</td>
							<td>'.$tr["email"].'</td>
							<td>'.$tr["retrvl_refno"].'</td>
							<td><a target="_blank" href="transactiondetails.php?t_id='.$tr["id_transaction_id"].'"><i class="fa fa-folder-open fa-2x"></i></a></td>
						</tr>';
		}
		$result .= '</tbody></table>';
	}

	echo $result;
		
	}
	else {
		
		$query="SELECT * FROM transactions";
		
		$result = 'No Transactions Found';
		$transactions = $db->rawQuery($query);
	
		if(!empty($transactions)){
			$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			$result .= '<thead>
					<tr>
						<th>Transaction ID</th>
						<th>Date</th>						
						<th>Status</th>
						<th>Amount</th>
						<th>First Name</th>
						<th>Address</th>						
						<th>ZIP/Postal Code</th>
						<th>Email</th>
						<th>RRN</th>
						<th></th>
					</tr>
				</thead>
				<tbody>';
		foreach($transactions as $tr)
			{
				$tstatus = ($tr["status"] == 0 ? 'failed' : 'completed');
				$result .= '<tr class="gradeX">
							<td>'.$tr["id_transaction_id"].'</td>
							<td>'.$tr["server_datetime_trans"].'</td>
							<td>'.$tr["condition"].'</td>							
							<td>'.$tr["amount"].'</td>
							<td>'.$tr["first_name"].'</td>
							<td>'.$tr["address1"].'</td>							
							<td>'.$tr["postal_code"].'</td>
							<td>'.$tr["email"].'</td>
							<td>'.$tr["retrvl_refno"].'</td>
							<td><a target="_blank" href="transactiondetails.php?t_id='.$tr["id_transaction_id"].'"><i class="fa fa-folder-open fa-2x"></i></a></td>
						</tr>';
			}
			$result .= '</tbody></table>';
		}

		echo $result;
	}	
}

else {
	
	if($val1!='' && $val2!='' && $merchantid==0 ){

			$merchantid=$_POST['merchantid'];
		
			$querys="SELECT * FROM merchants where idmerchants='$merchantid'";
			$tran1 = $db->rawQuery($querys);
			$transaction2=$tran1[0]['mer_map_id'];
			

		$query="SELECT * FROM transactions WHERE merchant_id='$transaction2'
		server_datetime_trans >= '$val1' AND server_datetime_trans <= '$val2'";

		$result = 'No Transactions Found';
		$transactions = $db->rawQuery($query);
		
		if(!empty($transactions)){
			$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			$result .= '<thead>
					<tr>
						<th>Transaction ID</th>
						<th>Date</th>						
						<th>Status</th>
						<th>Amount</th>
						<th>First Name</th>
						<th>Address</th>						
						<th>ZIP/Postal Code</th>
						<th>Email</th>
						<th>RRN</th>
						<th></th>
					</tr>
				</thead>
				<tbody>';
		foreach($transactions as $tr)
		{
			$tstatus = ($tr["status"] == 0 ? 'failed' : 'completed');
			$result .= '<tr class="gradeX">
							<td>'.$tr["id_transaction_id"].'</td>
							<td>'.$tr["server_datetime_trans"].'</td>							
							<td>'.$tr["condition"].'</td>						
							<td>'.$tr["amount"].'</td>
							<td>'.$tr["first_name"].'</td>							
							<td>'.$tr["address1"].'</td>							
							<td>'.$tr["postal_code"].'</td>
							<td>'.$tr["email"].'</td>
							<td>'.$tr["retrvl_refno"].'</td>
							<td><a target="_blank" href="transactiondetails.php?t_id='.$tr["id_transaction_id"].'"><i class="fa fa-folder-open fa-2x"></i></a></td>
						</tr>';
		}
		$result .= '</tbody></table>';
	}

	echo $result;
		
	}
	else{
		  $merchantid=$_POST['merchantid'];
		
		
			$query="SELECT * FROM merchants where idmerchants='$merchantid'";
			$tran = $db->rawQuery($query);
			$transaction1=$tran[0]['idmerchants'];
			
			print_r($transactions);
			

			$query1="SELECT * FROM transactions where RIGHT(merchant_id, 3)='$transaction1'";
			
			
		
			$result = 'No Transactions Found';
			$transactions = $db->rawQuery($query1);
			
			
			if(!empty($transactions)){
			$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			$result .= '<thead>
					<tr>
						<th>Transaction ID</th>
						<th>Out Trade Number</th>						
						<th>Trade Number</th>
						<th>Status</th>
						<th>Date</th>				
						<th>Amount</th>				
						<th></th>
					</tr>
				</thead>
				<tbody>';
			foreach($transactions as $tr)
			{
			$tstatus = ($tr["status"] == 0 ? 'failed' : 'completed');
			if($tr['error_code']!="") $sta=$tr['error_code']; else $sta="Failed";
			$result .= '<tr class="gradeX">
							<td>'.$tr["id_transaction_id"].'</td>
							<td>'.$tr["transaction_id"].'</td>
							<td>'.$tr["appr_code"].'</td>							
							<td>'.$sta.'</td>
							<td>'.$tr["server_datetime_trans"].'</td>
							<td>'.number_format($tr["amount"],2).'</td>							
							<td><a target="_blank" href="transactiondetails.php?t_id='.$tr["id_transaction_id"].'"><i class="fa fa-folder-open fa-2x"></i></a></td>
						</tr>';
			}
			$result .= '</tbody></table>';
		}

		echo $result;
	}
	
				
	}

	
?>