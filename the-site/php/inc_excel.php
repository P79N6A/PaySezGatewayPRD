<?php
require_once('database_config.php');
require_once('common_functions.php');
$id = $_SESSION['iid']; //change this to the id of who your looking up
$db->where("id",$id);
$datac = $db->getOne("users");
$mid = $datac['merchant_id'];
$usertype = getUserType($id);
$chargebacks = 0;
global $db;
//var_dump($usertype);
if ($usertype != 6){
	$userdata = getUserdata($id);
	$userMerchantId = $userdata["merchant_id"];
	$userAgentId = $userdata["agent_id"];
	//var_dump($userAgentId); die();
	if($usertype == 1){
		//var_dump(getAgentsAffiliateofAdmin());die();
		$MerchantsofUser = getUsersofAdmin();
		$AgentsofUser = getAgentsofAdmin();
		$AgentsAffiliateofAdmin = array();
		$AffiliationofAgents = array();
		$AgentsAffiliateofAdmin = getAgentsAffiliateofAdmin();
		$MerchantsofAdmin = getMerchantsofAdmin();
		$AgentsofUsercolNames0 = array_keys(reset($AgentsofUser));
		$AgentsAffiliateofAdmincolNames1 = array_keys(reset($AgentsAffiliateofAdmin));
		$AffiliationofAgents = getAffiliationofAgents($userAgentId);
		$AffiliationofAgentscolNames1 = array_keys(reset($AffiliationofAgents));
		//var_dump($MerchantsofUser);
		//foreach($AgentsofUser as $AffiliationofAgentsrow1) {
		//	echo $AffiliationofAgentsrow1['agent_id'].'---';
		//}//die();
			//$db->where("m_id",$MerchantsofAgentscbrow2['idmerchants']);
			//$db->where ("m_id", $MerchantsofAgentscbrow2['idmerchants'], 'in');
			$db->where("new",1);
			//echo $MerchantsofAgentscbrow2['idmerchants'].',';
			$cbdata = $db->get("chargebacks");
			$chargebacks = $db->count;
		//echo $chargebacks;
		//die();
	}elseif($usertype != 4 && $usertype != 5){
		if($userMerchantId != NULL){
			$MerchantsofUser = getUsersofmerchant($userMerchantId);
		}
		if($userAgentId != NULL){
			$AgentsofUser = getAgentsofUser($userAgentId);
			$AffiliationofAgents = getAffiliationofAgents($userAgentId);
			$AgentsofUsercolNames0 = array_keys(reset($AgentsofUser));
			$AffiliationofAgentscolNames1 = array_keys(reset($AffiliationofAgents));
			foreach($AgentsofUser as $AffiliationofAgentsrow1) {
			//echo $AffiliationofAgentsrow1['agent_id'].'---';
				$MerchantsofAgentscb = getMerchantsofAgents($AffiliationofAgentsrow1['agent_id']);
				foreach($MerchantsofAgentscb as $MerchantsofAgentscbrow2) { 
					$db->where("m_id",$MerchantsofAgentscbrow2['idmerchants']);
					//$db->where ("m_id", $MerchantsofAgentscbrow2['idmerchants'], 'in');
					$db->where("new",1);
					//echo $MerchantsofAgentscbrow2['idmerchants'].',';
					$cbdata = $db->get("chargebacks");
					$chargebacks = $db->count + $chargebacks;
					//$MerchantsofAgentscbrow2['idmerchants']
				} 
			}
		}
	}elseif( $usertype == 4 || $usertype == 5){
	 //Merchant Dashboard Statistics
	//$id = 133;

		$currency = "USD";
		$datevalue = '%Y-%m-%d';
		
		//daily stats
		if(isset($_GET['date']))
		{
			$date = date("Y-m-d", strtotime($_GET['date']));
			$datevalue = '%Y-%m-%d';
			$m_date = "%Y-%m-%d') = '".$date; 
		} elseif(isset($_GET['month']) && isset($_GET['year'])){
			$monthpicked = $_GET['month'];
			$yearpicked = $_GET['year'];
			$date = $_GET['year']."-".$_GET['month'];
			$datevalue = '%Y-%m';
			$m_date = "%Y-%m') = '".$_GET['year']."-".$_GET['month']; 
		}elseif(!isset($_GET['month']) && isset($_GET['year'])){
			$date = $_GET['year'];
			$datevalue = '%Y';
			$m_date = "%Y') = '".$_GET['year']; 
		}		
		$sale_query = "SELECT currency, SUM(if(action_type = 'sale' and success = '1', amount, 0)) AS total, 
						COUNT(if(currency = 'USD' AND action_type = 'sale', amount, NULL)) AS number,
						SUM(if(cc_type = 'Visa' AND action_type = 'sale'and success = '1', amount, 0)) AS visa_total, 
						COUNT(if(cc_type = 'Visa' AND action_type = 'sale', amount, NULL)) AS visa_number,
						SUM(if(cc_type = 'Mastercard' AND action_type = 'sale' and success = '1', amount, 0)) AS mc_total, 
						COUNT(if(cc_type = 'Mastercard' AND action_type = 'sale', amount, NULL)) AS mc_number,
						SUM(if(cc_type = 'Discover' AND action_type = 'sale' and success = '1', amount, 0)) AS discover_total, 
						COUNT(if(cc_type = 'Discover' AND action_type = 'sale', amount, NULL)) AS discover_number,
						SUM(if(cc_type = 'American Express' AND action_type = 'sale' and success = '1', amount, 0)) AS amex_total, 
						COUNT(if(cc_type = 'American Express' AND action_type = 'sale', amount, NULL)) AS amex_number 
						 FROM transactions t 
						INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id
						WHERE merchant_id = ".$mid." and success = '1'
						AND DATE_FORMAT(transaction_date, '".$datevalue."') = '".$date."'";
		//var_dump($sale_query);
		$sale_daily_data = $db->rawQuery($sale_query);
		$num_daily_transactions = $sale_daily_data[0]['number'];
		$total_daily_transactions = number_format($sale_daily_data[0]['total'], 2);
		$visa_num_sale = $sale_daily_data[0]['visa_number'];
		$visa_total_sale = number_format($sale_daily_data[0]['visa_total'], 2);
		$mc_num_sale = $sale_daily_data[0]['mc_number'];
		$mc_total_sale = number_format($sale_daily_data[0]['mc_total'], 2);
		$discover_num_sale = $sale_daily_data[0]['discover_number'];
		$discover_total_sale = number_format($sale_daily_data[0]['discover_total'], 2);
		$amex_num_sale = $sale_daily_data[0]['amex_number'];
		$amex_total_sale = number_format($sale_daily_data[0]['amex_total'], 2);
		
		$refunds_query = "SELECT currency, SUM(if(action_type = 'refund', amount, 0)) AS total, 
						 COUNT(if(currency = 'USD' AND action_type = 'refund', amount, NULL)) AS number,
						SUM(if(cc_type = 'Visa' AND action_type = 'refund', amount, 0)) AS visa_total, 
						COUNT(if(cc_type = 'Visa' AND action_type = 'refund', amount, NULL)) AS visa_number,
						SUM(if(cc_type = 'Mastercard' AND action_type = 'refund', amount, 0)) AS mc_total, 
						COUNT(if(cc_type = 'Mastercard' AND action_type = 'refund', amount, NULL)) AS mc_number,
						SUM(if(cc_type = 'Discover' AND action_type = 'refund', amount, 0)) AS discover_total, 
						COUNT(if(cc_type = 'Discover' AND action_type = 'refund', amount, NULL)) AS discover_number,
						SUM(if(cc_type = 'American Express' AND action_type = 'refund', amount, 0)) AS amex_total, 
						COUNT(if(cc_type = 'American Express' AND action_type = 'refund', amount, NULL)) AS amex_number						 
						 FROM transactions t 
						INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id
						WHERE merchant_id = ".$mid." and success = '1'
						AND DATE_FORMAT(transaction_date, '".$datevalue."') = '".$date."'";

		$refunds_daily_data = $db->rawQuery($refunds_query);
		$num_daily_refunds = $refunds_daily_data[0]['number'];
		$total_daily_refunds = number_format($refunds_daily_data[0]['total'], 2);
		$visa_num_refunds = $refunds_daily_data[0]['visa_number'];
		$visa_total_refunds = number_format($refunds_daily_data[0]['visa_total'], 2);
		$mc_num_refunds = $refunds_daily_data[0]['mc_number'];
		$mc_total_refunds = number_format($refunds_daily_data[0]['mc_total'], 2);
		$discover_num_refunds = $refunds_daily_data[0]['discover_number'];
		$discover_total_refunds = number_format($refunds_daily_data[0]['discover_total'], 2);
		$amex_num_refunds = $refunds_daily_data[0]['amex_number'];
		$amex_total_refunds = number_format($refunds_daily_data[0]['amex_total'], 2);
		
		$cb_query = "SELECT SUM(cb_amount) AS total, COUNT(cb_amount) AS number,
					SUM(if(cc_type = 'Visa', cb_amount, 0)) AS visa_total, 
					COUNT(if(cc_type = 'Visa', cb_amount, NULL)) AS visa_number,
					SUM(if(cc_type = 'Mastercard', cb_amount, 0)) AS mc_total, 
					COUNT(if(cc_type = 'Mastercard', cb_amount, NULL)) AS mc_number,
					SUM(if(cc_type = 'Discover', cb_amount, 0)) AS discover_total, 
					COUNT(if(cc_type = 'Discover', cb_amount, NULL)) AS discover_number,
					SUM(if(cc_type = 'American Express', cb_amount, 0)) AS amex_total, 
					COUNT(if(cc_type = 'American Express', cb_amount, NULL)) AS amex_number
					FROM chargebacks
					WHERE m_id = ".$mid."
					AND DATE_FORMAT(cb_date, '".$datevalue."') = '".$date."'";

		$cb_daily_data = $db->rawQuery($cb_query);
		$num_daily_chargebacks = $cb_daily_data[0]['number'];
		$total_daily_chargebacks = number_format($cb_daily_data[0]['total'], 2);
		$visa_num_chargebacks = $cb_daily_data[0]['visa_number'];
		$visa_total_chargebacks = number_format($cb_daily_data[0]['visa_total'], 2);
		$mc_num_chargebacks = $cb_daily_data[0]['mc_number'];
		$mc_total_chargebacks = number_format($cb_daily_data[0]['mc_total'], 2);
		$discover_num_chargebacks = $cb_daily_data[0]['discover_number'];
		$discover_total_chargebacks = number_format($cb_daily_data[0]['discover_total'], 2);
		$amex_num_chargebacks = $cb_daily_data[0]['amex_number'];
		$amex_total_chargebacks = number_format($cb_daily_data[0]['amex_total'], 2);
		
		//fees
		$cols = Array ("id", "p.p_id as pid", "g.p_id as gid");
		$db->join("processors p", "p.p_id = mpm.processor_id", "INNER");
		$db->join("processors g", "g.p_id = mpm.gateway_id", "INNER");
		$db->where("merchant_id",$mid);
		$db->where("is_active",1);
		$mpgs = $db->get("merchant_processors_mid mpm", null, $cols);

		function chargebackCount($mid, $pid, $m_date ) {
			global $db;
			$m_cb_query = "SELECT COUNT(cb_amount) as cb_num
					FROM chargebacks  
					WHERE m_id = ".$mid." and processor_id= ".$pid."  
					AND DATE_FORMAT(cb_date, '".$m_date."'";
			$m_cb_count = $db->rawQuery($m_cb_query);
			$cb_count = ($m_cb_count)?$m_cb_count[0]['cb_num']:0;
			return $cb_count;
		}
		
		function transactionCount($mid, $pid, $gid, $m_date, $t_type, $cc_type ) {
			global $db;
			$m_trans_query = "SELECT COUNT(amount) as trans_num
					FROM transactions t 
					INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id
					WHERE merchant_id = ".$mid." and processor_id= ".$pid." AND platform_id = ".$gid."
					AND DATE_FORMAT(transaction_date, '".$m_date."' AND action_type = '".$t_type."' AND cc_type = '".$cc_type."'";
			$m_trans_count = $db->rawQuery($m_trans_query);
			return $m_trans_count[0]['trans_num'];
		}
		
		function transactionSum($mid, $pid, $gid, $m_date, $t_type, $cc_type ) {
			global $db;
			$m_trans_query = "SELECT SUM(amount) as trans_total
					FROM transactions t 
					INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id
					WHERE merchant_id = ".$mid." and processor_id= ".$pid." AND platform_id = ".$gid." AND success = 1
					AND DATE_FORMAT(transaction_date, '".$m_date."' AND action_type = '".$t_type."' AND cc_type = '".$cc_type."'";
			$m_trans_sum = $db->rawQuery($m_trans_query);
			return $m_trans_sum[0]['trans_total'];
		}
		
		function getFees($mid, $pid) {
			global $db;
			$db->where("merchant_id",$mid);
			$db->where("processor_id",$pid);
			$fees = $db->getOne("merchant_bank_fees");
			return $fees;
		}
		
		function getGatewayFees($mid, $pid) {
			global $db;
			$db->where("merchant_id",$mid);
			$db->where("processor_id",$pid);
			$fees = $db->getOne("merchant_gateway_fees");
			return $fees;
		}
		
		function getAntifraudFees($mid, $pid) {
			global $db;
			$db->where("merchant_id",$mid);
			$db->where("processor_id",$pid);
			$fees = $db->getOne("merchant_acuity_fees");
			return $fees;
		}
		
		function percentage($val1, $val2, $precision) 
		{
			$division = $val1 * $val2;
			$res = $division / 100;
			$res = round($res, $precision);	
			return number_format($res, 2);
		}
		
		$visa_fee 			 = 0;
		$mc_sale_fee 		 = 0;
		$discover_fee 		 = 0;
		$amex_fee 			 = 0;
		$other_fees 		 = "";
		$chargebacks_num = 0;
		$chargebacks_amount = 0;
		$monthly_fee = 0;
		$account_on_file_monthly_fee = 0;
		$gateway_system_monthly_fee = 0;
		$antifraud_system_monthly_fee = 0;
		$wires_num = 0;
		$wire_fee = 0;
		
		foreach($mpgs as $mpg){
			$visa_sale_trans_num 		= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "Visa");
			$mc_sale_trans_num 			= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "Mastercard");
			$discover_sale_trans_num 	= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "Discover");
			$amex_sale_trans_num 		= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "American Express");
			
			
			$visa_refund_trans_num 		= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'refund', "Visa");
			$mc_refund_trans_num 		= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'refund', "Mastercard");
			$discover_refund_trans_num 	= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'refund', "Discover");
			$amex_refund_trans_num 		= transactionCount($mid, $mpg['pid'], $mpg['gid'], $m_date, 'refund', "American Express");
			
			$visa_sale_trans_total 		= transactionSum($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "Visa");
			$mc_sale_trans_total 		= transactionSum($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "Mastercard");
			$discover_sale_trans_total 	= transactionSum($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "Discover");
			$amex_sale_trans_total 		= transactionSum($mid, $mpg['pid'], $mpg['gid'], $m_date, 'sale', "American Express");
			
			$fees = getFees($mid, $pid);
			$gateway_fees = getGatewayFees($mid, $pid);
			$antifraud_fees = getAntifraudFees($mid, $pid);
		
			$discount_rate 		= $fees['discount_rate'];
			$transaction_fee 	= $fees['transaction_fee'];
			$authorization_fee 	= $fees['authorization_fee'];
			$capture_fee 		= $fees['capture_fee'];
			$sale_fee 			= $fees['sale_fee'];
			$avs_premium 		= $fees['avs_premium'];
			$cvv_premium 		= $fees['cvv_premium'];
			$interregional_fee 	= $fees['interregional_fee'];
			$refund_fee 		= $fees['interregional_fee'];
			
			$visa_fee 		= $visa_fee 
							+ percentage($discount_rate, $visa_sale_trans_total, 2) 
							+ ($visa_sale_trans_num*$transaction_fee)
							+ ($visa_sale_trans_num*$authorization_fee)
							+ ($visa_sale_trans_num*$capture_fee)
							+ ($visa_sale_trans_num*$sale_fee)
							+ ($visa_sale_trans_num*$avs_premium)
							+ ($visa_sale_trans_num*$cvv_premium)
							+ ($visa_sale_trans_num*$interregional_fee)
							+ ($visa_refund_trans_num*$transaction_fee)
							+ ($visa_refund_trans_num*$refund_fee);
			$mc_fee 		= $mc_fee 
							+ percentage($discount_rate, $mc_sale_trans_total, 2) 
							+ ($mc_sale_trans_num*$transaction_fee)
							+ ($mc_sale_trans_num*$authorization_fee)
							+ ($mc_sale_trans_num*$capture_fee)
							+ ($mc_sale_trans_num*$sale_fee)
							+ ($mc_sale_trans_num*$avs_premium)
							+ ($mc_sale_trans_num*$cvv_premium)
							+ ($mc_sale_trans_num*$interregional_fee)
							+ ($mc_refund_trans_num*$transaction_fee)
							+ ($mc_refund_trans_num*$refund_fee);
			$discover_fee 	= $discover_fee 
							+ percentage($discount_rate, $discover_sale_trans_total, 2) 
							+ ($discover_sale_trans_num*$transaction_fee)
							+ ($discover_sale_trans_num*$authorization_fee)
							+ ($discover_sale_trans_num*$capture_fee)
							+ ($discover_sale_trans_num*$sale_fee)
							+ ($discover_sale_trans_num*$avs_premium)
							+ ($discover_sale_trans_num*$cvv_premium)
							+ ($discover_sale_trans_num*$interregional_fee)
							+ ($discover_refund_trans_num*$transaction_fee)
							+ ($discover_refund_trans_num*$refund_fee);
			$amex_fee 		= $amex_fee 
							+ percentage($discount_rate, $amex_sale_trans_total, 2) 
							+ ($amex_sale_trans_num*$transaction_fee)
							+ ($amex_sale_trans_num*$authorization_fee)
							+ ($amex_sale_trans_num*$capture_fee)
							+ ($amex_sale_trans_num*$sale_fee)
							+ ($amex_sale_trans_num*$avs_premium)
							+ ($amex_sale_trans_num*$cvv_premium)
							+ ($amex_sale_trans_num*$interregional_fee)
							+ ($amex_refund_trans_num*$transaction_fee)
							+ ($amex_refund_trans_num*$refund_fee);
			
			$chargebacks_num 				= chargebackCount($mid, $mpg['pid'], $m_date);
			$chargebacks_fee 				= $fees['cb_fee_1'] + $fees['cb_fee_2'];
			$monthly_fee 					= $fees['monthly_fee'];
			$account_on_file_monthly_fee 	= 0;
			$gateway_system_monthly_fee 	= $gateway_fees['monthly_fee'];
			$antifraud_system_monthly_fee 	= $antifraud_fees['monthly_fee'];
			$wires_num 						= 0;
			$wire_fee 						= $fees['wire_fee'];
			
			$other_fees .= '<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr role="row">
										<th></th>
										<th class="text-right">Number</th>
										<th class="text-right">Amount</th>
										<th class="text-right">Total</th>
									</tr>
								 </thead>
								<tbody>
								<tr>
										<td>Chargebacks</td>
										<td class="text-right">'.$chargebacks_num.'</td>
										<td class="text-right">$ '.number_format($chargebacks_fee,2).'</td>
										<td class="text-right">$ '.number_format($chargebacks_num*$chargebacks_fee,2).'</td>								
								  </tr> 
								  <tr>
										<td>Monthly Fees</td>
										<td class="text-right">1</td>
										<td class="text-right">$ '.number_format($monthly_fee,2).'</td>
										<td class="text-right">$ '.number_format($monthly_fee,2).'</td>								
								  </tr>
								  <tr>
										<td>Account on File</td>
										<td class="text-right">1</td>
										<td class="text-right">$ '.number_format($account_on_file_monthly_fee,2).'</td>
										<td class="text-right">$ '.number_format($account_on_file_monthly_fee,2).'</td>								
								  </tr> 
								  <tr>
										<td>Gateway System</td>
										<td class="text-right">1</td>
										<td class="text-right">$ '.number_format($gateway_system_monthly_fee,2).'</td>
										<td class="text-right">$ '.number_format($gateway_system_monthly_fee,2).'</td>								
								  </tr>
								  <tr>
										<td>Antifraud System</td>
										<td class="text-right">1</td>
										<td class="text-right">$ '.number_format($antifraud_system_monthly_fee,2).'</td>
										<td class="text-right">$ '.number_format($antifraud_system_monthly_fee,2).'</td>								
								  </tr>
								  <tr>
										<td>Settlement Wire Fees</td>
										<td class="text-right">'.$wires_num.'</td>
										<td class="text-right">$ '.number_format($wire_fee,2).'</td>
										<td class="text-right">$ '.number_format($wires_num*$wire_fee,2).'</td>								
								  </tr>
								  <tr class="info">
										<td></td>
										<td></td>
										<td></td>
										<td class="text-right"><strong>$ '.number_format(($account_on_file_num*$account_on_file_amount+$monthly_fee+$account_on_file_monthly_fee+$gateway_system_monthly_fee+$antifraud_system_monthly_fee+$wires_num*$wire_fee),2).'</strong></td>								
								  </tr>
								  </tbody>
							</table>'; 						
		}
		
		//chart data
		$transactions_data = array();
		for($i=1; $i<13; $i++){
			$transactions_data[] =  getMonthlyTransactionData($i);
			
		}
		$transactions_data = implode(",", $transactions_data);
		
		$chargebacks_data = array();
		for($i=1; $i<13; $i++){
			$chargebacks_data[] =  getMonthlyChagebacksData($i);
		}
		
		$chargebacks_data = implode(",", $chargebacks_data);
	}
}
?>