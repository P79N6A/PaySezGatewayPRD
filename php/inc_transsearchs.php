<?php 
require_once('database_config.php');
$merchantid=$_POST['merchantid'];
$sdate=$_POST['period_start_date'];


$period_start_date=date('Y-m-d', strtotime($sdate));

$edate=$_POST['period_end_date'];

$period_end_date=date('Y-m-d', strtotime($edate));

$min_amount_range=$_POST['min_amount_range'];

$max_amount_range=$_POST['max_amount_range'];


 if($_POST['period_start_date']=='' && $_POST['period_end_date']==''  && $min_amount_range=='' && $max_amount_range=='' && $merchantid=='0') {
//echo "<br>Hi12_3";
			
    			$query="SELECT * FROM transaction";
				$result = 'No Transactions Found';
			$transactions = $db->rawQuery($query);
				
			
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']==''  &&$min_amount_range=='' && $max_amount_range=='' && $merchantid!='0'){
			
			 //echo "<br>Hi12_4";
			$merchantid=$_POST['merchantid'];
	
					$query="SELECT * FROM merchants where idmerchants='$merchantid'";
					$tran = $db->rawQuery($query);
					$transaction1=$tran[0]['idmerchants'];
					
					// print_r($transactions);
					
					$query="SELECT * FROM transaction where RIGHT(merchant_id, 3)='$transaction1'";
					$result = 'No Transactions Found';
						$transactions = $db->rawQuery($query);
				
		}
		else if($_POST['period_start_date']!='' && $_POST['period_end_date']!='' && $min_amount_range=='' && $max_amount_range=='' && $merchantid=='0'){
			
			
			
			    			$query="SELECT * FROM transaction WHERE trans_date>='$period_start_date' AND trans_date<='$period_end_date'";
							
							
							$result = 'No Transactions Found';
							$transactions = $db->rawQuery($query);
							
		}
		else if($_POST['period_start_date']!='' && $_POST['period_end_date']!='' && $min_amount_range=='' && $max_amount_range==''&& $merchantid!='0'){
			 //echo "<br>Hi12_6";
					$merchantid=$_POST['merchantid'];
	
					$query="SELECT * FROM merchants where idmerchants='$merchantid'";
					$tran = $db->rawQuery($query);
					$transaction1=$tran[0]['idmerchants'];
					
					// print_r($transactions);
					
					$query="SELECT * FROM transaction where RIGHT(merchant_id, 3)='$transaction1' AND trans_date>='$period_start_date' AND trans_date<='$period_end_date'" ;
					
					$result = 'No Transactions Found';
					
					$transactions = $db->rawQuery($query);
			
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']==''  && $min_amount_range!='' && $max_amount_range!='' && $merchantid=='0'){
			 //echo "<br>Hi12_7";
			 
			 $min= sprintf("%02d", $min_amount_range);
			 $max= sprintf("%02d", $max_amount_range);
			 
			 
			                $query="SELECT * FROM transaction WHERE total_fee>='$min' AND total_fee<='$max'";
							$result = 'No Transactions Found';
							$transactions = $db->rawQuery($query);
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']==''  && $min_amount_range!='' && $max_amount_range!='' && $merchantid!='0'){
			// echo "<br>Hi12_8";
					$merchantid=$_POST['merchantid'];
	
					$query="SELECT * FROM merchants where idmerchants='$merchantid'";
					$tran = $db->rawQuery($query);
					$transaction1=$tran[0]['idmerchants'];
					
					$min= sprintf("%02d", $min_amount_range);
			       $max= sprintf("%02d", $max_amount_range);
					
					$query="SELECT * FROM transaction where RIGHT(merchant_id, 3)='$transaction1' AND total_fee>='$min' AND total_fee<='$max'";
					
					$result = 'No Transactions Found';
					
					$transactions = $db->rawQuery($query);
		}
		else if($_POST['period_start_date']!='' && $_POST['period_end_date']!=''  && $min_amount_range!='' && $max_amount_range!='' && $merchantid=='0'){
			// echo "<br>Hi12_9";
		        	$min= sprintf("%02d", $min_amount_range);
			       $max= sprintf("%02d", $max_amount_range);
			
			
							$query="SELECT * FROM transaction WHERE total_fee>='$min' AND total_fee<='$max' AND trans_date>='$period_start_date' AND trans_date<='$period_end_date'";
							$result = 'No Transactions Found';
							$transactions = $db->rawQuery($query);
			
		}
		else if($_POST['period_start_date']!='' && $_POST['period_end_date']!=''  && $min_amount_range!='' && $max_amount_range!=''  && $merchantid!='0'){
					// echo "<br>Hi12_10";
					$merchantid=$_POST['merchantid'];
	
					$query="SELECT * FROM merchants where idmerchants='$merchantid'";
					$tran = $db->rawQuery($query);
					$transaction1=$tran[0]['idmerchants'];
					
					$min= sprintf("%02d", $min_amount_range);
			       $max= sprintf("%02d", $max_amount_range);
					
					$query="SELECT * FROM transaction where RIGHT(merchant_id, 3)='$transaction1' AND total_fee>='$min' AND total_fee<='$max' AND trans_date>='$period_start_date' AND trans_date<='$period_end_date'";
					
					$result = 'No Transactions Found';
					
					$transactions = $db->rawQuery($query);
		}
		else if($_POST['period_start_date']!='' && $_POST['period_end_date']==''  && $min_amount_range=='' && $max_amount_range==''  && $merchantid=='0'){
			 echo "Select END DATE";
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']!=''  && $min_amount_range=='' && $max_amount_range==''  && $merchantid=='0'){
			 echo "Select START DATE";
		}
		else if($_POST['period_start_date']!='' && $_POST['period_end_date']=''  && $min_amount_range=='' && $max_amount_range==''  && $merchantid!='0'){
			 echo "Select START DATE";
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']!=''  && $min_amount_range=='' && $max_amount_range==''  && $merchantid!='0'){
			 echo "Select END DATE";
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']==''  && $min_amount_range!='' && $max_amount_range==''  && $merchantid=='0'){
			 echo "Enter Maximum Amount of Transaction";
		}
		else if($_POST['period_start_date']=='' && $_POST['period_end_date']==''  && $min_amount_range=='' && $max_amount_range!=''  && $merchantid=='0'){
			 echo "Enter Minimum Amount of Transaction";
		}
		
		
		else{
			 echo "select Correct Transaction values";
		}
				
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
				foreach($transactions as $tr) {
					//$tstatus = ($tr["status"] == 0 ? 'failed' : 'completed');
					//if($tr['trade_status']!="") $sta=$tr['trade_status']; else $sta="Failed";
					$result .= '<tr class="gradeX">
										<td>'.$tr["id_transaction_id"].'</td>
										<td>'.$tr["out_trade_no"].'</td>
										<td>'.$tr["trade_no"].'</td>							
										<td>'.$tr["trade_status"].'</td>
										<td>'.$tr["trans_datetime"].'</td>
										<td>'.$tr["currency"].' '.number_format($tr["total_fee"],2).'</td>							
										<td><a target="_blank" href="transactiondetails.php?t_id='.$tr["id_transaction_id"].'"><i class="fa fa-folder-open fa-2x"></i></a></td>
									</tr>';
				}
				$result .= '</tbody></table>';
			}
		echo $result;

?>