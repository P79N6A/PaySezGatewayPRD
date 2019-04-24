<?php
require_once('database_config.php');

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
}
	
$query = 	"SELECT action_type, a.amount, success, moto_trans, cc_number "; 		
$query .= 	" FROM transactions t
			  INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id
			  INNER JOIN merchants m ON m.idmerchants = t.merchant_id 
			  INNER JOIN users u ON u.agent_id = m.affiliate_id";
if($usertype =! 1) $query .= 	 " WHERE u.id = ".$iid;

$query .= 	" WHERE 1 = 1 "; 

//Filters
if($date_timepicker_start 	!= "" && $date_timepicker_end	!= "") 		{ $query .=  " AND a.transaction_date BETWEEN '".$date_timepicker_start."' AND '".$date_timepicker_end."' ";  } else {
	if($date_timepicker_start 	!= "") 		{ $query .=  " AND a.transaction_date >= '".$date_timepicker_start."' ";  }
	if($date_timepicker_end	!= "") 		{ $query .=  " AND a.transaction_date <= '".$date_timepicker_end."' ";  }
}			
if($processorid > 0) 		$query 	.= 	"AND processor_id = ".$processorid." ";
if($merchants > 0) 			$query 	.= 	"AND merchant_id = ".$merchants." ";
if($agents > 0)				$query 	.= 	"AND m.affiliate_id = ".$agents." ";
if($currencies 	!= "") 		$query 	.= 	"AND currency = '".$currencies."' ";
if($transaction_type != "") $query .= 	"AND a.action_type = '".$transaction_type."' ";
if($card_types != "") {
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
	$query .= " AND (";
	$i = 1;
	foreach($prefixes as $prefix) {
	  if($i >1 ) $query .= " OR ";
	  $query .= " cc_number LIKE '".$prefix."%'";
	  $i++;
	}
	$query .= " ) ";
}	

//its not defind properly, its not clear in scope
//if($recurring 	!= "") $query .= 	"AND a.recurring = '".$recurring."' ";
//if($mid 	!= "") $query .= 	"AND a.mid = '".$mid."' ";
//if($bin 	!= "") $query .= 	"AND a.bin = '".$bin."' ";

$data = $db->rawQuery($query); 

$volume = array();
	$salesuccess = 0;
	$salefailed = 0;
	$saletotal = 0;
	$salevisa = 0;
	$salemc = 0;
	$refundsuccess = 0;
	$refundfailed = 0;
	$refundtotal = 0;
	$refundvisa = 0;
	$refundmc = 0;
	$authsuccess = 0;
	$authfailed = 0;
	$authtotal = 0;
	$motosales = 0;
	$totaltransactions = 0;
	$numsalesuccess = 0;
	$numsaletotal = 0;
	$numsalevisa = 0;
	$numsalemc = 0;
	$numsalefailed = 0;
	$numauthfailed = 0;
	$numauthuccess = 0;
	$numrefundfailed = 0;
	$numrefundsuccess = 0;
	$numtotaltransactions = 0;
	$numrefundtotal = 0;
	$numrefundvisa = 0;
	$numrefundmc = 0;
	$numauthtotal = 0;
	$nummotosales = 0;

foreach($data as $index => $record){
	if($record['moto_trans'] == 1){
		$motosales = $record['amount'] + $motosales;
		$nummotosales++;
	}
    if($record['action_type'] == 'sale'){
		if($record['success'] == 1){
			$salesuccess = $record['amount'] + $salesuccess;
			$numsalesuccess++;
		}elseif($record['success'] == 0){
			$salefailed = $record['amount'] + $salefailed;
			$numsalefailed++;
		}
		$saletotal = $record['amount'] + $saletotal;
		//calculate visa sales
		if(getCCType($record['cc_number']) == 'Visa') 		
		{
			$salevisa = $record['amount'] + $salevisa;
			$numsalevisa++;
		}
		if(getCCType($record['cc_number']) == 'Mastercard') 
		{
			$salemc = $record['amount'] + $salemc;
			$numsalemc++;
		}
		$numsaletotal++;
	}elseif($record['action_type'] == 'refund'){
		if($record['success'] == 1){
			$refundsuccess = $record['amount'] + $refundsuccess;
			$numrefundsuccess++;
		}elseif($record['success'] == 0){
			$refundfailed = $record['amount'] + $refundfailed;
			$numrefundfailed++;
		}
		$refundtotal = $record['amount'] + $refundtotal;
		//calculate visa sales
		if(getCCType($record['cc_number']) == 'Visa') 		
		{
			$refundvisa = $record['amount'] + $refundvisa;
			$numrefundvisa++;
		}
		if(getCCType($record['cc_number']) == 'Mastercard') 
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
		'salemc' => $salemc,
		'refundsuccess' => $refundsuccess,
		'refundfailed' => $refundfailed,
		'refundtotal' => $refundtotal,
		'refundvisa' => $refundvisa,
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
		'numsalemc' => $numsalemc,
		'numrefundtotal' => $numrefundtotal,
		'numrefundvisa' => $numrefundvisa,
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
				<td><?php echo number_format($volume[0]['salesuccess'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['salesuccess'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalesuccess']; ?></td>
				<td><?php echo number_format($volume[0]['numsalesuccess'] / $volume[0]['numsaletotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Failed Sales</td>
				<td><?php echo number_format($volume[0]['salefailed'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['salefailed'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalefailed']; ?></td>
				<td><?php echo number_format($volume[0]['numsalefailed'] / $volume[0]['numsaletotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Transactions (Sales)</td>
				<td><?php echo number_format($volume[0]['saletotal'], 2); ?> USD</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numsaletotal']; ?></td>
				<td>100%</td>
		  </tr>
		 <tr class="gradeA even" role="row">
          <td class="sorting_1">Total MC Sales</td>
				<td><?php echo number_format($volume[0]['salemc'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['salemc'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalemc']; ?></td>
				<td><?php echo number_format($volume[0]['numsalemc'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Visa Sales</td>
				<td><?php echo number_format($volume[0]['salevisa'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['salevisa'] / $volume[0]['saletotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numsalevisa']; ?></td>
				<td><?php echo number_format($volume[0]['numsalevisa'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
          <td class="sorting_1">Total Successful Auths</td>
				<td><?php echo number_format($volume[0]['authsuccess'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['authsuccess'] / $volume[0]['authtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numauthuccess']; ?></td>
				<td><?php echo number_format($volume[0]['numauthuccess'] / $volume[0]['numauthtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Failed Auths</td>
				<td><?php echo number_format($volume[0]['authfailed'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['authfailed'] / $volume[0]['authtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numauthfailed']; ?></td>
				<td><?php echo number_format($volume[0]['numauthfailed'] / $volume[0]['numauthtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
          <td class="sorting_1">Total Auths</td>
				<td><?php echo number_format($volume[0]['authtotal'], 2); ?> USD</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numauthtotal']; ?></td>
				<td>100%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Successful Refunds</td>
				<td><?php echo number_format($volume[0]['refundsuccess'], 2); ?> USD</td>
				<td><?php echo number_format(($volume[0]['refundsuccess'] / $volume[0]['refundtotal'] *100), 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundsuccess']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundsuccess'] / $volume[0]['numrefundtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA odd" role="row">
          <td class="sorting_1">Total Failed Refunds</td>
				<td><?php echo number_format($volume[0]['refundfailed'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['refundfailed'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundfailed']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundfailed'] / $volume[0]['numrefundtotal'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refunds</td>
				<td><?php echo number_format($volume[0]['refundtotal'], 2); ?> USD</td>
				<td>100%</td>
				<td><?php echo $volume[0]['numrefundtotal']; ?></td>
				<td>100%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total MC Refunds</td>
				<td><?php echo number_format($volume[0]['refundmc'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['refundmc'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundmc']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundmc'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Visa Refunds</td>
				<td><?php echo number_format($volume[0]['refundvisa'], 2); ?> USD</td>
				<td><?php echo number_format($volume[0]['refundvisa'] / $volume[0]['refundtotal'] *100, 2); ?>%</td>
				<td><?php echo $volume[0]['numrefundvisa']; ?></td>
				<td><?php echo number_format($volume[0]['numrefundvisa'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total MOTO Sales</td>
				<td><?php echo number_format($volume[0]['motosales'], 2); ?> USD</td>
				<td>%</td>
				<td><?php echo $volume[0]['nummotosales']; ?></td>
				<td><?php echo number_format($volume[0]['nummotosales'] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Returns</td>
				<td><?php //echo number_format($volume[0][''], 2); ?> USD</td>
				<td>%</td>
				<td><?php //echo $volume[0]['']; ?></td>
				<td><?php //echo number_format($volume[0][''] / $volume[0]['numtotaltransactions'] *100, 2); ?>%</td>
		  </tr>
        <tr class="gradeA even" role="row">
          <td class="sorting_1">Total Transactions<br>
            (Sales+Refunds+Auths+Captures)</td>
				<td><?php echo number_format($volume[0]['totaltransactions'], 2); ?> USD</td>
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