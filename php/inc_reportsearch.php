<?php
require_once('database_config.php');

// echo "<pre>";
// print_r($_POST);
// echo "<br>";
// echo $_POST['date_timepicker_start'].'=>'.$_POST['date_timepicker_end'];
// foreach ($_POST as $key => $value) {
// 	filter_input(INPUT_POST, $key);
// 	$$key = $_POST[$key];
// 	$key = $value;
// }
// exit;

if(isset($_POST['searchtype']) && $_POST['searchtype'] == 'report') {
	// echo "<pre>";
	// print_r($_POST);
	// exit;

	$start_end = explode('-', $_POST['date2']);

	$start_date = (isset($_POST['date2']) && $start_end[0]!='') ? date('Y-m-d 00:00:00',strtotime($start_end[0])) : '';
	$end_date   = (isset($_POST['date2']) && $start_end[1]!='') ? date('Y-m-d 23:59:59',strtotime($start_end[1])) : '';

	// echo $start_date."=>".$end_date; exit;

	// $start_date = (isset($_POST['date_timepicker_start']) && $_POST['date_timepicker_start']!='') ? $_POST['date_timepicker_start'] : '';
	// $end_date   = (isset($_POST['date_timepicker_end']) && $_POST['date_timepicker_end']!='') ? $_POST['date_timepicker_end'] : '';
	$currencies = (isset($_POST['currencies']) && $_POST['currencies']!='') ? $_POST['currencies'] : '';
	$trans_type = (isset($_POST['transaction_type']) && $_POST['transaction_type']!='') ? $_POST['transaction_type'] : '';
	$merchants  = (isset($_POST['merchants']) && $_POST['merchants']!='') ? $_POST['merchants'] : '';

	$query = "SELECT * FROM transaction_alipay WHERE trans_datetime >= '$start_date' AND trans_datetime <= '$end_date'";

	if($currencies!='') {
		$query.= " AND currency='$currencies'";
	}

	if($trans_type!='') {
		$query.= " AND transaction_type='$trans_type'";
	}

	$query.= " ORDER BY trans_datetime DESC";
    $result = 'No Transactions Found';
    $transactions = $db->rawQuery($query);

    $i = 0;
    if(!empty($transactions)){
		$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
        $result .= '<thead>
                        <tr>
                            <th>S.No</th>
                            <th>Transaction<br>Type</th>
                            <th>Out Trade Number</th>
                            <th>Refund Org ID</th>						
                            <th>Terminal ID</th>
                            <th>Status</th>
                            <th>Transaction<br>Date</th>				
                            <th>Amount</th>				
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach($transactions as $tr) {
        	$i++;
            $t_id = $tr["id_transaction_id"]; // $_GET['t_id'];

            $transaction_type='';
            if($tr['transaction_type'] == 1) {
                $transaction_type = 'POS - SALE';
            } else if($tr['transaction_type'] == 2) {
                $transaction_type = 'POS - REFUND';
            } else if($tr['transaction_type'] == 3) {
                $transaction_type = 'POS - QUERY';
            } else if($tr['transaction_type'] == 4) {
                $transaction_type = 'POS - CANCEL';
            } else if($tr['transaction_type'] == 's1') {
                $transaction_type = 'QR - SALE';
            } else if($tr['transaction_type'] == 's2') {
                $transaction_type = 'QR - REFUND';
            } else if($tr['transaction_type'] == 's3') {
                $transaction_type = 'QR - QUERY';
            } else if($tr['transaction_type'] == 's4') {
                $transaction_type = 'QR - CANCEL';
            }

            $transaction_amount='';
            if($tr['transaction_type'] == 2 || $tr['transaction_type'] == 's2') {
                $transaction_amount = number_format($tr["refund_amount"],2);
            } else {
                $transaction_amount = number_format($tr["total_fee"],2);    
            }

            if($tr['transaction_type'] == 1 || $tr['transaction_type'] == 's1') { 
                if($tr['trade_status']!="") { 
                    $sta=$tr['trade_status']; 
                } else { 
                    $sta="ACK_NOT_RECEIVED"; 
                }
            } else {
                $sta=$tr['result_code'];
            }
            
            $result .= '<tr class="gradeX">
                            <td style="text-align:center;">'.$i.'</td>
                            <td>'.$transaction_type.'</td>
                            <td>'.$tr["out_trade_no"].'</td>
                            <td>'.$tr["partner_trans_id"].'</td>
                            <td>'.$tr["terminal_id"].'</td>							
                            <td>'.$sta.'</td>
                            <td>'.$tr["trans_datetime"].'</td>
                            <td>'.$tr["currency"].' '.$transaction_amount.'</td>							
                            <td align="center"><a href="transactiondetails.php?t_id='.$tr["id_transaction_id"].'" title="Click To View Details"><i class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></i></a></td>
                        </tr>';

        }
        $result .= '</tbody></table>';
    }
    echo $result;

}

exit;

function getCCType($CCNumber)
	{
		$creditcardTypes = array(
							array('Name'=>'American Express','cardLength'=>array(15),'cardPrefix'=>array('34', '37'))
							,array('Name'=>'Maestro','cardLength'=>array(12, 13, 14, 15, 16, 17, 18, 19),'cardPrefix'=>array('5018', '5020', '5038', '6304', '6759', '6761', '6763'))
							,array('Name'=>'Mastercard','cardLength'=>array(16),'cardPrefix'=>array('51', '52', '53', '54', '55'))
							,array('Name'=>'Visa','cardLength'=>array(13,16),'cardPrefix'=>array('4'))
							,array('Name'=>'JCB','cardLength'=>array(16),'cardPrefix'=>array('3528', '3529', '353', '354', '355', '356', '357', '358'))
							,array('Name'=>'Discover','cardLength'=>array(16),'cardPrefix'=>array('6011', '622126', '622127', '622128', '622129', '62213',
														'62214', '62215', '62216', '62217', '62218', '62219',
														'6222', '6223', '6224', '6225', '6226', '6227', '6228',
														'62290', '62291', '622920', '622921', '622922', '622923',
														'622924', '622925', '644', '645', '646', '647', '648',
														'649', '65'))
							,array('Name'=>'Solo','cardLength'=>array(16, 18, 19),'cardPrefix'=>array('6334', '6767'))
							,array('Name'=>'Unionpay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('622126', '622127', '622128', '622129', '62213', '62214',
														'62215', '62216', '62217', '62218', '62219', '6222', '6223',
														'6224', '6225', '6226', '6227', '6228', '62290', '62291',
														'622920', '622921', '622922', '622923', '622924', '622925'))
							,array('Name'=>'Diners Club','cardLength'=>array(14),'cardPrefix'=>array('300', '301', '302', '303', '304', '305', '36'))
							,array('Name'=>'Diners Club US','cardLength'=>array(16),'cardPrefix'=>array('54', '55'))
							,array('Name'=>'Diners Club Carte Blanche','cardLength'=>array(14),'cardPrefix'=>array('300','305'))
							,array('Name'=>'Laser','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6304', '6706', '6771', '6709'))
		);  
		$CCNumber= trim($CCNumber);
		$type='Unknown';
		foreach ($creditcardTypes as $card){
			if (! in_array(strlen($CCNumber),$card['cardLength'])) {
				continue;
			}
			$prefixes = '/^('.implode('|',$card['cardPrefix']).')/';            
			if(preg_match($prefixes,$CCNumber) == 1 ){
				$type= $card['Name'];
				break;
			}
		}
		return $type;
	}

function getUserType($id){
	global $db;
	$db->where("id",$id);
	$data = $db->getOne("users");
	return $data['user_type'];
}

$iid = $_SESSION['iid'];

$usertype = getUserType($iid);

foreach ($_POST as $key => $value) {
		filter_input(INPUT_POST, $key);
		$$key = $_POST[$key];
		$key = $value;
}/*
if($card_types != ""){
function getCCPrefixArray($CCType)
	{
		$creditcardTypes = array(
							array('Name'=>'amex','cardLength'=>array(15),'cardPrefix'=>array('34', '37'))
							,array('Name'=>'maestro','cardLength'=>array(12, 13, 14, 15, 16, 17, 18, 19),'cardPrefix'=>array('5018', '5020', '5038', '6304', '6759', '6761', '6763'))
							,array('Name'=>'mastercard','cardLength'=>array(16),'cardPrefix'=>array('51', '52', '53', '54', '55'))
							,array('Name'=>'visa','cardLength'=>array(13,16),'cardPrefix'=>array('4'))
							,array('Name'=>'JCB','cardLength'=>array(16),'cardPrefix'=>array('352', '353', '354', '355', '356', '357', '358'))
		);  

		foreach ($creditcardTypes as $card){
			if( $card['Name'] == $CCType )
			{
				return $card['cardPrefix'];
			}
		}
	}
	$r = array_search($q, $swm_array);
    $prefixes = getCCPrefixArray($card_types);

	
	print_r($prefixes);
	
}*/


$sdate=$date_timepicker_start;
$edate=$date_timepicker_end;



if($date_timepicker_start=='' && $date_timepicker_end=='' && $card_types=='0' && $currencies=='0' && $transaction_type=='0'   && $processorid=='0' && $recurring=='0' && $agents=='0' && $merchants=='0' && $mid=='0' && $bin=='0'){

	$query= "SELECT a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id";
	   
}
 else if($sdate!='' && $edate!=''){
		$query= "SELECT a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id WHERE currency ='$currencies' AND a.action_type = '$transaction_type' AND server_datetime_trans>='$sdate' AND server_datetime_trans<='$edate'";
}else{
		$query= "SELECT  a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id 
          INNER JOIN merchants m ON m.idmerchants = t.merchant_id WHERE currency ='$currencies' AND a.action_type = '$transaction_type'";	 
}


$data = $db->rawQuery($query); 

$volume = array();
	$salesuccess = 0;
	$salefailed = 0;
	$saletotal = 0;
	$salevisa = 0;
	$salerupay = 0;
	$salemc = 0;
	$refundsuccess = 0;
	$refundfailed = 0;
	$refundtotal = 0;
	$refundvisa = 0;
	$refundrupay = 0;
	$refundmc = 0;
	$authsuccess = 0;
	$authfailed = 0;
	$authtotal = 0;
	$motosales = 0;
	$totaltransactions = 0;
	$numsalesuccess = 0;
	$numsaletotal = 0;
	$numsalevisa = 0;
	$numsalerupay = 0;
	$numsalemc = 0;
	$numsalefailed = 0;
	$numauthfailed = 0;
	$numauthuccess = 0;
	$numrefundfailed = 0;
	$numrefundsuccess = 0;
	$numtotaltransactions = 0;
	$numrefundtotal = 0;
	$numrefundvisa = 0;
	$numrefundrupay = 0;
	$numrefundmc = 0;
	$numauthtotal = 0;
	$nummotosales = 0;



foreach($data as $index => $record){
	if($record['moto_trans'] !== 1){
		$motosales = $record['amount'] + $motosales;
		$nummotosales++;
	}
    if($record['action_type'] == 'sale'){

		if($record['condition'] =='complete'){
			
			$salesuccess = $record['amount'] + $salesuccess;
			$numsalesuccess++;
		}elseif($record['condition'] == 'failed'){
			$salefailed = $record['amount'] + $salefailed;
			$numsalefailed++;
		}
		$saletotal = $record['amount'] + $saletotal;
		
		
		//calculate visa sales
		if($record['network'] == 'Visa')
		{
			$salevisa = $record['amount'] + $salevisa;
			$numsalevisa++;
		}
		if($record['network'] == 'RUPAY')
		{
			$salerupay = $record['amount'] + $salerupay;
			$numsalerupay++;
			
			
		}
		if($record['network'] == 'MC')
		{
			$salemc = $record['amount'] + $salemc;
			$numsalemc++;
						
		}
		$numsaletotal++;
	}elseif($record['action_type'] == 'refnd'){
		if($record['success'] == 1){
			$refundsuccess = $record['amount'] + $refundsuccess;
			$numrefundsuccess++;
		}elseif($record['success'] == 0){
			$refundfailed = $record['amount'] + $refundfailed;
			$numrefundfailed++;
		}
		$refundtotal = $record['amount'] + $refundtotal;
		//calculate visa sales
		if($record['network'] == 'Visa')
		{
			$refundvisa = $record['amount'] + $refundvisa;
			$numrefundvisa++;
		}
		//rupay
		if($record['network'] == 'RUPAY')
		{
			$refundrupay = $record['amount'] + $refundrupay;
			$numrefundrupay++;
		}
		
		if($record['network'] == 'MC')
		{
			$refundmc 	= $record['amount'] + $refundmc;
			$numrefundmc++;
		}
		$numrefundtotal++;
	}elseif($record['action_type'] == 'auth'){
		if($record['success'] == 1){
			$authsuccess = $record['amount'] + $authsuccess;
			$numauthuccess++;
		}elseif($record['success'] == 0){
			$authfailed = $record['amount'] + $authfailed;
			$numauthfailed++;
		}
		$authtotal = $record['amount'] + $authtotal;
		$numauthtotal++;
	}
	$totaltransactions = $record['amount'] + $totaltransactions;
	$numtotaltransactions++;
}
$volume[] = array(
        'salesuccess' => $salesuccess,
		'salefailed' => $salefailed,
		'saletotal' => $saletotal,
		'salevisa' => $salevisa,
		'salerupay' => $salerupay,
		'salemc' => $salemc,
		'refundsuccess' => $refundsuccess,
		'refundfailed' => $refundfailed,
		'refundtotal' => $refundtotal,
		'refundvisa' => $refundvisa,
		'refundrupay' => $refundrupay,
		'refundmc' => $refundmc,
		'authsuccess' => $authsuccess,
		'authfailed' => $authfailed,
		'authtotal' => $authtotal,
		'motosales' => $motosales,
		'totaltransactions' => $totaltransactions,
		'numsalesuccess' => $numsalesuccess,
		'numsalefailed' => $numsalefailed,
		'numsaletotal' => $numsaletotal,
		'numsalevisa' => $numsalevisa,
		'numsalerupay' => $numsalerupay,
		'numsalemc' => $numsalemc,
		'numrefundtotal' => $numrefundtotal,
		'numrefundvisa' => $numrefundvisa,
		'numrefundrupay' => $numrefundrupay,
		'numrefundmc' => $numrefundmc,
		'numauthfailed' => $numauthfailed,
		'numauthuccess' => $numauthuccess,
		'numauthtotal' => $numauthtotal,
		'numrefundfailed' => $numrefundfailed,
		'numrefundsuccess' => $numrefundsuccess,
		'nummotosales' => $nummotosales,
		'numtotaltransactions' => $numtotaltransactions
    );

?>
	
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>&nbsp;</th>
          <th>Volume</th>
          <th>% Volume</th>
          <th>Num of Trx</th>
          <th>% Trx</th></tr>
        </thead>
      <tbody>       
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Successful Sales</td>
				<td><?php echo number_format($volume[0]['salesuccess'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['salesuccess'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalesuccess']; ?></td>
				<td><?php echo number_format($volume[0]['numsalesuccess'] / $volume[0]['numsaletotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Failed Sales</td>
				<td><?php echo number_format($volume[0]['salefailed'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['salefailed'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalefailed']; ?></td>
				<td><?php echo number_format($volume[0]['numsalefailed'] / $volume[0]['numsaletotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Transactions (Sales)</td>
				<td><?php echo number_format($volume[0]['saletotal'], 2); ?> INR</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numsaletotal']; ?></td>
				<td>100%</td>
		  </tr>
		 <tr class="gradeA even" role="row">
          <td class="sorting_1">Total MC Sales</td>
				<td><?php echo number_format($volume[0]['salemc'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['salemc'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalemc']; ?></td>
				<td><?php echo number_format($volume[0]['numsalemc'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Visa Sales</td>
				<td><?php echo number_format($volume[0]['salevisa'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['salevisa'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalevisa']; ?></td>
				<td><?php echo number_format($volume[0]['numsalevisa'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
		  
		  
		   <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Rupay Sales</td>
				<td><?php echo number_format($volume[0]['salerupay'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['salerupay'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalerupay']; ?></td>
				<td><?php echo number_format($volume[0]['numsalerupay'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
		  
        <tr class="gradeA odd" role="row">
          <td class="sorting_1">Total Successful Auths</td>
				<td><?php echo number_format($volume[0]['authsuccess'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['authsuccess'] / $volume[0]['authtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numauthuccess']; ?></td>
				<td><?php echo number_format($volume[0]['numauthuccess'] / $volume[0]['numauthtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Failed Auths</td>
				<td><?php echo number_format($volume[0]['authfailed'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['authfailed'] / $volume[0]['authtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numauthfailed']; ?></td>
				<td><?php echo number_format($volume[0]['numauthfailed'] / $volume[0]['numauthtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
          <td class="sorting_1">Total Auths</td>
				<td><?php echo number_format($volume[0]['authtotal'], 2); ?> INR</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numauthtotal']; ?></td>
				<td>100%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Successful Refunds</td>
				<td><?php echo number_format($volume[0]['refundsuccess'], 2); ?> INR</td>
				<td><?php echo number_format(($volume[0]['refundsuccess'] / $volume[0]['refundtotal'] *100), 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundsuccess']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundsuccess'] / $volume[0]['numrefundtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
          <td class="sorting_1">Total Failed Refunds</td>
				<td><?php echo number_format($volume[0]['refundfailed'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['refundfailed'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundfailed']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundfailed'] / $volume[0]['numrefundtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refunds</td>
				<td><?php echo number_format($volume[0]['refundtotal'], 2); ?> INR</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numrefundtotal']; ?></td>
				<td>100%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total MC Refunds</td>
				<td><?php echo number_format($volume[0]['refundmc'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['refundmc'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundmc']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundmc'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Visa Refunds</td>
				<td><?php echo number_format($volume[0]['refundvisa'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['refundvisa'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundvisa']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundvisa'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
		  <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Rupay Refunds</td>
				<td><?php echo number_format($volume[0]['refundrupay'], 2); ?> INR</td>
				<td><?php echo number_format($volume[0]['refundrupay'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundrupay']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundrupay'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
		  
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total MOTO Sales</td>
				<td><?php echo number_format($volume[0]['motosales'], 2); ?> INR</td>
				<td>%</td>
				<td><?php echo $volume[0]['nummotosales']; ?></td>
				<td><?php echo number_format($volume[0]['nummotosales'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Returns</td>
				<td><?php //echo number_format($volume[0][''], 2); ?> INR</td>
				<td>%</td>
				<td><?php //echo $volume[0]['']; ?></td>
				<td><?php //echo number_format($volume[0][''] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Transactions<br>
            (Sales+Refunds+Auths+Captures)</td>
				<td><?php echo number_format($volume[0]['totaltransactions'], 2); ?> INR</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numtotaltransactions']; ?></td>
				<td>100%</td>
		  </tr>
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">&nbsp;</th>
          <th  tabindex="0"  rowspan="1" colspan="1" style="width: 247px;">Volume</th>
          <th tabindex="0"  rowspan="1" colspan="1"  style="width: 231px;">% Volume</th>
          <th tabindex="0"  rowspan="1" colspan="1"  style="width: 158px;">Num of Trx</th>
          <th  tabindex="0"  rowspan="1" colspan="1" style="width: 117px;">% Trx</th>
          </tr>
        </tfoot>
      </table>
<?php 
//--------------------  CHARGEBACK REPORTS ---------------------------//

$query = "SELECT 	TR_CCY as currency,
					COUNT(idchargebacks) as total_num, 
					sum(cb_amount) as total_volume, 
					COUNT(if(cc_type = 'VISA', idchargebacks, NULL)) AS total_num_visa, 
					SUM(if(cc_type = 'VISA', cb_amount, 0)) AS total_volume_visa,
					COUNT(if(cc_type = 'MC', idchargebacks, NULL)) AS total_num_mc, 
					SUM(if(cc_type = 'MC', cb_amount, 0)) AS total_volume_mc,
					COUNT(if(moto_trans = 1, idchargebacks, NULL)) AS total_num_moto, 
					SUM(if(moto_trans = 1, cb_amount, 0)) AS total_volume_moto"; 		
$query .= 	" FROM 	chargebacks 
			  LEFT 	JOIN cb_stati 	ON cb_stati.cb_stati_id = chargebacks.status
			  INNER JOIN merchants 	ON merchants.idmerchants = chargebacks.m_id  
			  INNER JOIN users 		ON users.agent_id = merchants.affiliate_id";
if($usertype =! 1) $query .= 	 " WHERE users.id = ".$iid;

if($date_timepicker_start 	!= "" && $date_timepicker_end	!= "") 		{ $query .=  " AND cb_date BETWEEN '".$date_timepicker_start."' AND '".$date_timepicker_end."' ";  } else {
	if($date_timepicker_start 	!= "") 		{ $query .=  " AND cb_date >= '".$date_timepicker_start."' ";  }
	if($date_timepicker_end	!= "") 		{ $query .=  " AND cb_date <= '".$date_timepicker_end."' ";  }
}			
if($processorid > 0) 		$query 	.= 	" AND processor_id = ".$processorid." ";
if($merchants > 0) 			$query 	.= 	" AND m_id = ".$merchants." ";
if($agents > 0)				$query 	.= 	" AND merchants.affiliate_id = ".$agents." ";
if($currencies 	!= "") 		$query 	.= 	" AND TR_CCY = '".$currencies."' ";
if($card_types != "") 		$query 	.= 	" AND cc_type = '".$card_types."' ";

$chargebacks = $db->rawQuery($query);


?>	
	
	<table class="table table-striped table-bordered table-hover">
        <thead>
			<tr role="row">
				<th>Chargebacks</th>
				<th>Volume</th>
				<th>% Volume</th>
				<th>Num of Trx</th>
				<th>% Trx</th>
            </tr>
         </thead>
        <tbody>
          <tr>
				<td>Total Chargebacks</td>
				<td><?php echo $chargebacks[0]['total_volume']." ".$chargebacks['currency']; ?> </td>
				<td>100%</td>
				<td><?php echo $chargebacks[0]['total_num']; ?></td>
				<td>100%</td>
		  </tr>
          <tr>
				<td>Total MC Chargebacks</td>
				<td><?php echo $chargebacks[0]['total_volume_mc']." ".$chargebacks['currency']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_volume_mc'] / $chargebacks[0]['total_volume'] *100, 2); ?>%</td>
				<td><?php echo $chargebacks[0]['total_num_mc']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_num_mc'] / $chargebacks[0]['total_num'] *100, 2); ?>%</td>
		  </tr>
          <tr>
				<td>Total Visa Chargebacks</td>
				<td><?php echo $chargebacks[0]['total_volume_visa']." ".$chargebacks['currency']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_volume_visa'] / $chargebacks[0]['total_volume'] *100, 2); ?>%</td>
				<td><?php echo $chargebacks[0]['total_num_visa']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_num_visa'] / $chargebacks[0]['total_num'] *100, 2); ?>%</td>
		  </tr>
		<!--Rupay-->
		<tr>
				<td>Total Rupay Chargebacks</td>
				<td><?php echo $chargebacks[0]['total_volume_rupay']." ".$chargebacks['currency']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_volume_rupay'] / $chargebacks[0]['total_volume'] *100, 2); ?>%</td>
				<td><?php echo $chargebacks[0]['total_num_rupay']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_num_rupay'] / $chargebacks[0]['total_num'] *100, 2); ?>%</td>
		  </tr>
		  
          <tr>
				<td>Total MOTO Chargebacks</td>
				<td><?php echo $chargebacks[0]['total_volume_moto']." ".$chargebacks['currency']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_volume_moto'] / $chargebacks[0]['total_volume'] *100, 2); ?>%</td>
				<td><?php echo $chargebacks[0]['total_num_moto']; ?></td>
				<td><?php echo number_format($chargebacks[0]['total_num_moto'] / $chargebacks[0]['total_num'] *100, 2); ?>%</td>
		  </tr>
          </tbody>
        <tfoot>
          <tr>
            <th rowspan="1" colspan="1">&nbsp;</th>
            <th tabindex="0"  rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 247px;">Volume</th>
            <th tabindex="0"  rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 231px;">% Volume</th>
            <th tabindex="0"  rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 158px;">Num of Trx</th>
            <th tabindex="0"  rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 117px;">% Trx</th>
            </tr>
          </tfoot>
    </table>