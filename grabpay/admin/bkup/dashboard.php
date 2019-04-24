<?php

require_once('header.php'); 

if($_SESSION['user_type'] === 6)
	include_once('forbidden.php');

require_once('php/inc_agents_tree.php'); 


$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$user_id=$_SESSION['iid'];
$event="view";
$auditable_type="CORE PHP AUDIT";
$new_values="";
$old_values="";
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent= $_SERVER['HTTP_USER_AGENT'];
audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip, $user_agent);

$search_type = 'trans';

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

//var_dump(getTransactions($_SESSION['iid']));die();

//if user is merchant 

if( $usertype == 4 || $usertype == 5) {

$omg ='';

if(!empty($env) && $env == 0) {
	$omg = 'TEST MODE ENABLED';
}
$iid = $_SESSION['iid'];



$currentdate = date('Y-m-d');
$currentdate_start = date('Y-m-d 00:00:00');
$currentdate_end   = date('Y-m-d 23:59:59');

$db->where("userid",$iid);
$merchantDet = $db->getOne('merchants');

// echo $merchantDet['mer_map_id'];

$db->where("pg_merchant_id",$merchantDet['mer_map_id']);
$VendorDet = $db->get('vendor_config');
//echo "<pre>";

foreach ($VendorDet as $vendor_name) {
$vendor[]= $vendor_name['vendor_name'];
	//echo "<br>";
}

if($merchantDet['currency_code'] == 'SGD') {
	setlocale(LC_MONETARY, 'en_US');
	$ccode = '$';
} else if($merchantDet['currency_code'] == 'LKR') {
	// setlocale(LC_MONETARY, 'en_IN');
	setlocale(LC_MONETARY, 'en_US');
	$ccode = 'Rs';
}

function number_point($value) {
    $myAngloSaxonianNumber = number_format($value, 2, '.', ','); //Conversion of single decimal point to two decimal point ex: 5,678.9 =>5,678.90
    return $myAngloSaxonianNumber;
}


if (in_array('grabpay',$vendor)) {
		require_once('dash_grabpay.php');
}
if(in_array('alipay',$vendor)) {
		require_once('dash_alipay.php');
}
//  if(){
// 	echo 'You have not merchants Alipay and Grabpay';
// }


/**** Set the Currency Code and Displaying Format ****/



?>

<!-- Overall Transaction Report in Column Tiles 1 -->
<!-- <div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 report-bk">

		<h3>Design 1</h3>
		<div class="row row-left-right">
			<div class="col-sm-6 col-md-3 mb pad-left-right">
				<div class="st-panel st-panel--border">
					<div class="st-panel__cont">
						<div class="st-panel__header">
							<div class="fluid-cols">
								<div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Income</span>
										<small>Month</small>
									</span>
									<div class="st-panel__tools">
										<div class="st-panel-tool">
											<span class="label label-success">$1,200</span>
										</div>
									</div>
								</div>
								<div class="min-col">
									
								</div>
							</div>
						</div>
						<div class="st-panel__content">
							<div class="text-ellipsis text-center" style="font-size: 24px;">$25,235.00</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-md-3 mb pad-left-right">
	            <div class="st-panel st-panel--border">
					<div class="st-panel__cont">
						<div class="st-panel__header">
							<div class="fluid-cols">
								<div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Payments</span><small>Out</small>
									</span>
								</div>
								<div class="min-col">
									<div class="st-panel__tools">
										<div class="st-panel-tool">
										  <div class="sparkline" values="15, 14, 13, 14, 16, 17, 15" sparktype="bar" sparkbarcolor="#45BDDC" sparkbarwidth="3" sparkbarspacing="1" sparkchartrangemin1="0">
										  	<canvas style="display: inline-block; width: 27px; height: 19px; vertical-align: top;" width="27" height="19"></canvas>
										  </div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="st-panel__content">
							<div class="text-ellipsis text-center" style="font-size: 24px;">$120,840.00</div>
						</div>
					</div>
	            </div>
	        </div>

	        <div class="col-sm-4 col-md-2 mb pad-left-right">
	            <div class="st-panel st-panel--border">
					<div class="st-panel__cont">
						<div class="st-panel__header">
							<div class="fluid-cols">
								<div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Rating</span><small>Avg</small>
									</span>
								</div>
								<div class="min-col">
									<div class="st-panel__tools">
										<div class="st-panel-tool"><i class="text-warning fa fa-star"></i></div>
									</div>
								</div>
							</div>
						</div>
						<div class="st-panel__content">
							<div class="text-ellipsis text-center" style="font-size: 24px;">4.8</div>
						</div>
					</div>
	            </div>
	        </div>

			<div class="col-sm-4 col-md-2 mb pad-left-right">
				<div class="st-panel st-panel--border">
					<div class="st-panel__cont">
						<div class="st-panel__header">
							<div class="fluid-cols">
								<div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Growth</span>
									</span>
								</div>
								<div class="min-col">
									<div class="st-panel__tools">
										<div class="st-panel-tool">
											<span class="label label-info">25</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="st-panel__content" style="height: 36px;">
							<iframe id="resize-iframe" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
							<div class="sparkline_1" values="8, 2, 4, 3, 5, 4, 3, 5, 5, 6, 3, 9, 7, 3, 5, 6, 9, 5, 6, 7, 2, 3, 9, 6, 6, 7, 8, 10, 15, 16, 17, 15" sparktype="line" sparkwidth="100%" sparkheight="36" sparkfillcolor="#dff7fd" sparklinewidth="1" sparklinecolor="#45BDDC" sparkhighlightlinecolor="#45BDDC" sparkchartrangemin="" sparkspotcolor="" sparkminspotcolor="" sparkmaxspotcolor="">
								<canvas width="135" height="36" style="display: inline-block; height: 36px; vertical-align: top;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4 col-md-2 mb pad-left-right">
				<div class="st-panel st-panel--border">
					<div class="st-panel__cont">
						<div class="st-panel__header">
							<div class="fluid-cols">
								<div class="expand-col text-ellipsis text-center">
									<span class="st-panel__title">
										<span>Users</span>
									</span>
								</div>
							</div>
						</div>
						<div class="st-panel__content">
							<div class="text-ellipsis text-center" style="font-size: 24px;">180 / <small>20</small></div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</div> -->

<!-- Overall Transaction Report in Column Tiles 2 -->


<?php } else { ?>

<?php
// $q = 'SELECT  FROM merchants';
// $records = $db->rawQuery($q);
// echo "<pre>";
// print_r($records);
// sleep(40);
function convertnumber( $num, $precision = 1 ) {
	$last=preg_replace("/[^a-zA-Z]/", '', $num);
	$remaining=preg_replace("/[^0-9\.]/", '', $num);
	//$remaining = (float)$remaining;
	
	if($last == 'K') {
		$amount = number_format(($remaining*1000), $precision);
	} else if($last == 'M') {
		$amount = number_format(($remaining*1000000), $precision);
	} else if($last == 'B') {
		$amount = number_format(($remaining*1000000000), $precision);
	} else if($last == 'T')  {
		$amount = number_format(($remaining*1000000000000), $precision);
	} else {
		$amount = number_format($remaining, $precision);
	}
	return $amount;
}

function number_format_short( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
	// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
	// Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}

$currentdate = date('Y-m-d');
$lastmonthdate= date('Y-m-d', strtotime(date('Y-m')." -1 month")); // date('Y-m-d', strtotime("-30 days"));
$currentdate_start = date('Y-m-d 00:00:00');
$currentdate_end   = date('Y-m-d 23:59:59');

/**** Get the Merchant Wise  Month-wise "Monthly Recurring Revenue" ****/
function get_merchant_sale_groupby_ccode($currentdate,$merchant_id) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND transaction_alipay.transaction_type IN ('1','s1') AND transaction_alipay.merchant_id ='$merchant_id' AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trade_status='TRADE_SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month, merchants.currency_code";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;	
}

/**** Get the Merchant Wise Month-wise "Cancel Amount by Currency" ****/
function get_merchant_cancel_by_ccode($ccode,$currentdate,$merchant_id) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND transaction_alipay.transaction_type IN ('4','s4')
		AND transaction_alipay.merchant_id ='$merchant_id' AND  transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}

/**** Get the Merchant Wise Month-wise "Refund Amount by Currency" ****/
function get_merchant_refund_by_ccode($ccode,$currentdate,$merchant_id) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.refund_amount) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND transaction_alipay.transaction_type IN ('2','s2') AND transaction_alipay.merchant_id = '$merchant_id' AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}
/**** Get the Month-wise "Monthly Recurring Revenue" ****/
function get_sale_groupby_ccode($currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND gp_transaction.gp_transaction_type IN ('1','s1') AND gp_transaction.gp_status='success' AND MONTH(gp_transaction.gp_trans_datetime) = MONTH('$currentdate') GROUP BY year, month, merchants.currency_code";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;	
}

/**** Get the Month-wise "Cancel Amount by Currency" ****/
function get_cancel_by_ccode($ccode,$currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND gp_transaction.gp_transaction_type IN ('4','s4') AND gp_transaction.gp_status='success' AND MONTH(gp_transaction.gp_trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}

/**** Get the Month-wise "Refund Amount by Currency" ****/
function get_refund_by_ccode($ccode,$currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND gp_transaction.gp_transaction_type IN ('2','s2') AND gp_transaction.gp_status='success' AND MONTH(gp_transaction.gp_trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}

$transactions_M_R_amt = '';
$transactions_M_R_Net_amt = '';

$transactions_M_R_Sale_amount = 0;
$transactions_M_R_Refd_amount = 0;
$transactions_M_R_Canl_amount = 0;
$transactions_M_R_Net_amount  = 0;

$transactions_M_R_Sale_amt1 = '';
$transactions_M_R_Sale_amt_lastlist = '';

$transactions_M_R_Net_amt1 = '';
$transactions_M_R_Net_amt_lastlist = '';

$transactions_M_R = get_sale_groupby_ccode($currentdate); // Get the Current Month Sale
foreach ($transactions_M_R as $key => $trans) {
	$ccode = $trans['currency_code'];
	if($ccode == 'SGD') {
		setlocale(LC_MONETARY, 'en_US');
	} else if($ccode == 'LKR') {
		setlocale(LC_MONETARY, 'en_US');
		// setlocale(LC_MONETARY, 'en_IN');
	}
	$ccode_part = '<small>'.$ccode.'</small>';
	$transactions_M_R_amt .= '<h1 class="no-margins">'.($trans['transamount']!='' ?number_format_short($trans['transamount'],2).' '.$ccode_part : '--').'</h1>';
	$transactions_M_R_amt1 .= ($trans['transamount']!='' ?number_format_short($trans['transamount'],2).' '.$ccode_part : '--');
	$transactions_M_R_Sale_amount = $trans['transamount'];

	$transactions_M_R_Canl_Detail = '';
	$transactions_M_R_Canl_Detail = get_cancel_by_ccode($ccode,$currentdate); // Get the Current Month Cancel
	$transactions_M_R_Canl_amount = $transactions_M_R_Canl_Detail[0]['transamount'];

	$transactions_M_R_Refd_Detail = '';
	$transactions_M_R_Refd_Detail = get_refund_by_ccode($ccode,$currentdate); // Get the Current Month Refund
	$transactions_M_R_Refd_amount = $transactions_M_R_Refd_Detail[0]['transamount'];
	
	$transactions_M_R_Net_amount = $transactions_M_R_Sale_amount - ($transactions_M_R_Canl_amount+$transactions_M_R_Refd_amount);

	$transactions_M_R_Net_amt .= '<h1 class="no-margins">'.($transactions_M_R_Net_amount!='' ?number_format_short($transactions_M_R_Net_amount,2).' '.$ccode_part : '--').'</h1>';
	$transactions_M_R_Net_amt1 .=($transactions_M_R_Net_amount!='' ?number_format_short($transactions_M_R_Net_amount,2).' '.$ccode_part : '--');
	$transactions_M_R_Net_amt1 .= '~';

	$transactions_M_R_Sale_amt1 .=($transactions_M_R_Sale_amount!='' ?number_format_short($transactions_M_R_Sale_amount,2).' '.$ccode : '--');
	$transactions_M_R_Sale_amt1 .= '~';
}

$transactions_M_R_last = get_sale_groupby_ccode($lastmonthdate); // Get the Previous Month Sale
foreach ($transactions_M_R_last as $key => $trans_last) {	
	$ccode = $trans_last['currency_code'];
	if($ccode == 'SGD') {
		setlocale(LC_MONETARY, 'en_US');
	} else if($ccode == 'LKR') {
		setlocale(LC_MONETARY, 'en_US');
		// setlocale(LC_MONETARY, 'en_IN');
	}
	$ccode_part_last = '<small>'.$ccode.'</small>';
	$transactions_M_R_Sale_amount_lastlist.= ($trans_last['transamount']!='' ?number_format_short($trans_last['transamount'],2).' '.$ccode_part_last : '--');
     $transactions_M_R_Sale_last_amount = $trans_last['transamount'];

	$transactions_M_R_Canl_last_Detail = '';
	$transactions_M_R_Canl_last_Detail = get_cancel_by_ccode($ccode,$lastmonthdate); // Get the Previous Month Cancel
	$transactions_M_R_Canl_last_amount = $transactions_M_R_Canl_last_Detail[0]['transamount'];

	$transactions_M_R_Refd_last_Detail = '';
	$transactions_M_R_Refd_last_Detail = get_refund_by_ccode($ccode,$lastmonthdate); // Get the Previous Month Refund
	$transactions_M_R_Refd_last_amount = $transactions_M_R_Refd_last_Detail[0]['transamount'];
	
	$transactions_M_R_Net_last_amount = $transactions_M_R_Sale_last_amount - ($transactions_M_R_Canl_last_amount+$transactions_M_R_Refd_last_amount);
	$transactions_M_R_Net_amt_lastlist .= ($transactions_M_R_Net_last_amount!='' ?number_format_short($transactions_M_R_Net_last_amount,2).' '.$ccode_part_last : '--');
	$transactions_M_R_Net_amt_lastlist .= '~';

	$transactions_M_R_Sale_amt_lastlist .=($transactions_M_R_Sale_last_amount!='' ?number_format_short($transactions_M_R_Sale_last_amount,2).' '.$ccode : '--');
	$transactions_M_R_Sale_amt_lastlist .= '~';
}

// echo $transactions_M_R_Sale_amt1.'=>'.$transactions_M_R_Sale_amt_lastlist;
// exit;

$transactions_M_R_Sale_amt1_firstExp = explode("~", $transactions_M_R_Sale_amt1);
$LKR_current_Sale_amt = substr($transactions_M_R_Sale_amt1_firstExp[0],0,strpos($transactions_M_R_Sale_amt1_firstExp[0],"SGD"));

$USD_current_Sale_amt = substr($transactions_M_R_Sale_amt1_firstExp[1],0,strpos($transactions_M_R_Sale_amt1_firstExp[1],"USD"));
$LKR_current_Sale_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim($LKR_current_Sale_amt),2));

$USD_current_Sale_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim($USD_current_Sale_amt),2));


$transactions_M_R_Sale_amt_lastlist_firstExp = explode("~", $transactions_M_R_Sale_amt_lastlist);
$LKR_previous_Sale_amt = substr($transactions_M_R_Sale_amt_lastlist_firstExp[0],0,strpos($transactions_M_R_Sale_amt_lastlist_firstExp[0],"SGD"));
$USD_previous_Sale_amt = substr($transactions_M_R_Sale_amt_lastlist_firstExp[1],0,strpos($transactions_M_R_Sale_amt_lastlist_firstExp[1],"USD"));
$LKR_previous_Sale_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim($LKR_previous_Sale_amt),2));
$USD_previous_Sale_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim($USD_previous_Sale_amt),2));


$Sale_divide_per_LKR = ($LKR_current_Sale_amt_num / $LKR_previous_Sale_amt_num)*100;
$Sale_divide_per_USD = ($USD_current_Sale_amt_num / $USD_previous_Sale_amt_num)*100;

$Sale_average_percentage = ($Sale_divide_per_LKR + $Sale_divide_per_USD) / 2;

// echo $transactions_M_R_Sale_amt1;
// echo "<br>";
//echo $Sale_average_percentage."<br>";
 //echo $Sale_divide_per_LKR."&&&&&&".$Sale_divide_per_USD;
//echo "<br>";
		

// echo $LKR_current_Sale_amt_num."&&&".$LKR_previous_Sale_amt_num.PHP_EOL."<br><br><br>";
// echo "<br>";
// echo (float)$LKR_current_Sale_amt_num."&&&".(float)$LKR_previous_Sale_amt_num.PHP_EOL."<br><br><br>";
// //echo 	$transactions_M_R_Sale_amount_lastlist."<br><br><br>";
// echo $USD_current_Sale_amt_num."&&&".$USD_previous_Sale_amt_num."<br>";
// // echo $USD_current_Sale_amt."&&&".$USD_previous_Sale_amt."<br>";
// // echo $Sale_divide_per_LKR."&&&".$Sale_divide_per_USD."<br>";
// // echo  number_format($Sale_average_percentage,2);
// //echo $LKR."<br>";




$Sale_variation_arrow = ($Sale_average_percentage > 100) ? 'fa-chevron-up' : 'fa-chevron-down';


$transactions_M_R_Net_amt1_firstExp = explode("~", $transactions_M_R_Net_amt1);
$LKR_current_Net_amt = substr($transactions_M_R_Net_amt1_firstExp[0],0,strpos($transactions_M_R_Net_amt1_firstExp[0],"SGD"));

$USD_current_Net_amt = substr($transactions_M_R_Net_amt1_firstExp[1],0,strpos($transactions_M_R_Net_amt1_firstExp[1],"USD"));
$LKR_current_Net_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim(strip_tags($LKR_current_Net_amt)),2));
$USD_current_Net_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim(strip_tags($USD_current_Net_amt)),2));

//echo $LKR_current_Net_amt_num;

$transactions_M_R_Net_amt_lastlist_firstExp = explode("~", $transactions_M_R_Net_amt_lastlist);
$LKR_previous_Net_amt = substr($transactions_M_R_Net_amt_lastlist_firstExp[0],0,strpos($transactions_M_R_Net_amt_lastlist_firstExp[0],"SGD"));
$USD_previous_Net_amt = substr($transactions_M_R_Net_amt_lastlist_firstExp[1],0,strpos($transactions_M_R_Net_amt_lastlist_firstExp[1],"USD"));
$LKR_previous_Net_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim(strip_tags($LKR_previous_Net_amt)),2));
$USD_previous_Net_amt_num =preg_replace("/[^0-9\.]/",'',convertnumber(trim(strip_tags($USD_previous_Net_amt)),2));

$Net_divide_per_LKR = ($LKR_current_Net_amt_num / $LKR_previous_Net_amt_num)*100;
$Net_divide_per_USD = ($USD_current_Net_amt_num / $USD_previous_Net_amt_num)*100;

$Net_average_percentage = ($Net_divide_per_LKR + $Net_divide_per_USD) / 2;

//echo $transactions_M_R_Net_amt1."<br>";
//echo $LKR_current_Net_amt." = ".$USD_current_Net_amt;
// echo "<br>";
// echo $LKR_current_Net_amt_num."=".$USD_current_Net_amt_num."<br>";
// echo $LKR_previous_Net_amt_num."=".$USD_previous_Net_amt_num."<br>";
// echo $Net_divide_per_LKR."==".$Net_divide_per_USD;

// echo convertnumber("398.65K",2)."<br>";
// $trim=trim($LKR_current_Net_amt);
// echo  $var=preg_replace('/\s+/','',$LKR_current_Net_amt);
// echo "<br>";
// echo substr($LKR_current_Net_amt,-1)."<br>";
// echo number_format($var*1000,2);
//echo  convertnumber();

// echo $USD_current_Net_amt."&&&&&&&&&".$USD_previous_Net_amt."<br>";
// echo $Net_average_percentage;

$Net_variation_arrow = ($Net_average_percentage > 100) ? 'fa-chevron-up' : 'fa-chevron-down';
?>

<div class="row">
	 <?php
        $db->orderBy("mer_map_id","asc");
        $merchantDet = $db->get("merchants");
     ?>
  
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding" style="display: none">
		<h3 style="padding-left: 15px; margin: 15px 0;">Transaction Activity Details</h3>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label>Merchant_Name </label><BR>
        <select name="merchantid" class="form-control" id="merchantid">
            <option value="0">Select</option>
              <?php
                foreach ($merchantDet as $key => $value) {
                   echo '<option value="'.$value['mer_map_id'].'">'.$value['merchant_name'].'</option>';
                }
              ?>
        </select>
        </div>
	    <div class="col-sm-6 col-md-6 col-lg-6" id="sale">
	        <div class="ibox float-e-margins">
	            <div class="ibox-content admin">
	                <?php echo $transactions_M_R_amt; ?>
	                <strong class="pull-right">
	                <i class="fa <?php echo $Sale_variation_arrow; ?>" aria-hidden="true"></i>
	              <!-- 	<?php //echo number_format($Sale_average_percentage,2)." %"; ?><br> -->
	              <?php echo number_format($Sale_divide_per_LKR,2)." %"; ?><br>
	                <span>Previous 30 Days</span>
	                </strong>
	            </div>
	            <div class="titleDet">
	            	<h2 align="center">Monthly Recurring Revenue</h2>
	            </div>
	        </div>
	    </div>
	    <div class="col-sm-6 col-md-6 col-lg-6" id="sale1">
	    </div>
	    <div class="col-sm-6 col-md-6 col-lg-6" id="net">
	        <div class="ibox float-e-margins">
	            <!-- <div class="ibox-title">
	                <span class="label label-info pull-right">Today</span>
	                <h5>Transactions Count</h5>
	            </div> -->
	            <div class="ibox-content admin">
	                <!-- <h1 class="no-margins">
	                	<a id="curtransamt_1" href="javascript:void(0);">$ 20000</a>
	                </h1> -->
	                <?php echo $transactions_M_R_Net_amt; ?>
	                <strong class="pull-right">
	                	<i class="fa <?php echo $Net_variation_arrow; ?>" aria-hidden="true"></i>
	                	<!-- <?php // echo number_format($Net_average_percentage,2)." %"; ?><br> -->
	                	<?php  echo number_format($Net_divide_per_LKR,2)." %"; ?><br>
	                	<span>Previous 30 Days </span>
	                </strong>
	            </div>
	            <div class="titleDet">
	            	<h2 align="center">Net Revenue</h2>
	            </div>
	        </div>
	    </div>
	    <div class="col-sm-6 col-md-6 col-lg-6" id="net1">
	    </div>
	    <div class="col-sm-6 col-md-6 col-lg-4" style="display: none;">
	        <div class="ibox float-e-margins">
	            <!-- <div class="ibox-title">
	                <span class="label label-success pull-right">Today</span>
	                <h5>Transactions Value</h5>
	            </div> -->
	            <div class="ibox-content admin">
	                <h1 class="no-margins">
	                	<a id="curtransamt_1" href="javascript:void(0);">$ 10000</a>
	                </h1>
	                <strong class="pull-right">
	                	<i class="fa fa-chevron-up" aria-hidden="true"></i> 88.7 % <br>
	                	<span>Previous 30 Days</span>
	                </strong>
	            </div>
	            <div class="titleDet">
	            	<h2 align="center">Fees</h2>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins">

			<div class="ibox-title">

				<h5>Merchant Accounts  <?php //print_r($transactions_Merchant_M_R); ?></h5>

				<div class="frmSearch">
					<b>Search : </b>
					<input type="text" id="search-box" name="mer_name" placeholder="Search Merchant Name" />
					<div id="suggesstion-box"></div>
				</div>

			</div>

			<div class="ibox-content" id="cnt"></div>

			<div class="ibox-content" id="already">

				<div class="table-responsive">

				<?php
					//$result = '<table id="table1" class="controller table table-striped">';
					echo '<table class="table table-striped table-bordered table-hover dataTables-example">';

					echo '<thead>
					<tr data-level="header" class="header">
					<th>Merchant Name</th>
					<th>Customer Service Email</th>
					<th>Customer Service Phone</th>
					<th>Status</th>
					</tr>
					</thead>
					<tbody>';

					// foreach($tree as $item){
					
					//   $cclass = (empty($item['Children']) && empty($item['Agents']))?'class="no-children"':'';

					//   $active = (empty($item['Children']) && empty($item['Agents']))?"Inactive":"Active";

					//   echo '<tr data-level="1" id="level_1_'.$item['Id'].'" '.$cclass.' >

					// 			<td><i class="fa fa-users"></i> <a href="viewagent.php?agentid='.strip_tags($item['Id']).'">'.strip_tags($item['Name']).'</td>

					// 			<td class="data">'.strip_tags($item['Email']).'</td>

					// 			<td class="data">'.strip_tags($item['Phone']).'</td>

					// 			<td class="data">'.strip_tags($active).'</td>

					// 		</tr>

					// 		';

					//  if(is_array($item['Children'])){

					// 	   displayArr($item['Children'], 2);

					//   }

					//   if(is_array($item['Merchants'])){

					// 	   displayMerchants($item['Merchants'], 2);

					//   }

					// }

					$i = 0;
					// echo "<pre>";
					// print_r($arr);

					// foreach ($arr as $view) {
					// 		 $array[] = $view['Name'];
					// 		 $array[] = $view['Email'];
					// 		 $array[] = $view['Phone'];
					// 		// echo "<br>";					
					// }
					// print_r($array);
					foreach($arr as $item){

						$i++;
						//$trans_count= trans_history($item['mer_map_id']);

						// if(!is_empty($trans_status)) {
						// 	$count = $trans_status[0]['count'];
						// } else {
						// 	$count = 0;
						// }

						// echo $count;
						// echo "<br>";

						$cclass = (empty($item['Children']) && empty($item['Merchants']))?'class="no-children"':'';

						// $active = (empty($item['Children']) && empty($item['Merchants']))?"Inactive":"Active";
						$active = $item['Active'] == 1 ? "Active":"In-Active";

						$merchant_Name = $item['Name'];

						echo   '<tr class="gradeX">
						         <data-level="1" id="level_1_'.$item['Mid'].'" '.$cclass.'>
								<td><i class="fa fa-male"></i> <a href="viewagent.php?merchantid='.strip_tags($item['Mid']).'">'.$merchant_Name.'</td>

								<td class="data">'.strip_tags($item['Email']).'</td>
								<td class="data">'.strip_tags($item['Phone']).'</td>
								<td class="data">'.strip_tags($active).'</td>
								</tr>';

						if(is_array($item['Children'])){
							displayArr($item['Children'], 2);
						}
						if(is_array($item['Merchants'])){
							displayMerchants($item['Merchants'], 2);
						}
					}
					echo '</tbody></table>';
					?>

				</div>

			</div>

		</div>

	</div>



</div>


<?php 


}

} elseif($usertype == 6) {

	echo 'show virtual terminal';

	ajax_redirect('/virtualterminal.php');

} else {

	echo '<a href="login.php"> Please Login Again</a>';

}

// function trans_history($merchantid){
// 	global $db;
// 	$current_date=date('Y-m-d');
// 	$count_transaction_query = "SELECT COUNT(id_transaction_id) AS count, merchant_id FROM transaction_alipay WHERE merchant_id='$merchantid' AND trans_date='$current_date' GROUP BY merchant_id";
//     $count_transaction = $db->rawQuery($count_transaction_query);
//     if(empty($count_transaction)) {
//     	$count = 0;
//     } else {
//     	$count = $count_transaction[0]['count'];
//     }
//     return $count;
// }
		

require_once('footerjs.php'); ?>



<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">



<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<style type="text/css">
#ToolTables_DataTables_Table_0_4,.DTTT_button_print {
	display: none;
}
</style>
<script>

            $("#merchant_date").on("change", function () {
				    var myDate = $('#merchant_date').val();
					var period_start_date = myDate.slice(0, 10);
				    var period_end_date = myDate.slice(12, 25);
				    if(myDate!='') {
				            $('.rlt_row').show();
				    }

				    var mer_id  = $('#merchant_id').val();
				    //alert(mer_id);
				    //alert(myDate);

				    // var url = '/excelnew.php?merchant_id='+mer_id'&date'+myDate;
				$("#exportnew_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/Transaction_Details.php?merchant_id="+mer_id+"&period_start_date="+period_start_date+"&period_end_date="+period_end_date);
	
				});


        $("#button3").on("click", function () {
				    var myDate = $('#merchant_date').val();
					var period_start_date = myDate.slice(0, 10);
				    var period_end_date = myDate.slice(12, 25);
				    if(myDate!='') {
				            $('.rlt_row').show();
				    }

				    var mer_id  = $('#merchant_id').val();

					var period_startdate = period_start_date.trim();
					var period_enddate = period_end_date.trim(); 
					if (period_startdate == period_enddate) {
					   	// alert('');
					$("#exportsummary_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/merchant_summary.php?merchant_id="+mer_id+"&date="+period_start_date);
					   	return true;
					  } else {
					   	$("#exportsummary_date").attr("href","");
					   	$("#exportsummary_date").removeAttr("href");

					   	alert('Start date and End date should be same on merchants Summary');
					   	// e.preventDefault();
					   	//return false;
					   	// $("#exportsummary_date").attr("href","");
					   	
					 }
	
				});


// AJAX call for autocomplete 
$(document).ready(function(){

	var myDate = $('#date_12').val();
	var period_start_date = myDate.slice(0, 10);
    var period_end_date = myDate.slice(12, 25);
    // if(myDate!='') {
    //         $('.rlt_row').show();
    // }
	var mer_id  = $('#merchant_id').val();

	$("#exportnew_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/Transaction_Details.php?merchant_id="+mer_id+"&period_start_date="+period_start_date+"&period_end_date="+period_end_date);

	

	$("div#cnt").hide();

	$("#search-box").keyup(function() {

		console.log($(this).val().length);
		if($(this).val().length > 0) {
			$("div#already").hide();
			$("div#cnt").show();
		} else {
			$("div#already").show();
			$("div#cnt").hide();
		}

		$.ajax({
			type: "POST",
			url: "php/inc_agents_tree.php",
			data:'keyword='+$(this).val()+'&usertype='+<?php echo $usertype; ?>,
			// beforeSend: function(){
			// 	$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			// },
			success: function(msg) {
				console.log(msg);
				$("#cnt").html(msg);
				if(msg.slice(0,21) == 'No Transactions Found') {
					$("#exportlink_date").hide();
					} else {
					$("#exportlink_date").show();
					}
				$('.dataTables-example').dataTable({
					destroy: true,
					"order": [[ 0, "asc" ]],
					responsive: true,
					"dom": 'T<"clear">lfrtip',
					"tableTools": {
						"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
					}
				});
				$('input:checkbox').change(function(){ 
					if($(this).attr('id') == 'selectall')	
					{
						jqCheckAll2( this.id);
					}
				});
			}
		});

		var table2 = $('#table2').tabelize({
			fullRowClickable : true,
			onReady : function(){
				console.log('ready');
			},
			onBeforeRowClick :  function(){
				console.log('onBeforeRowClick');
			},
			onAfterRowClick :  function(){
				console.log('onAfterRowClick');
			},
		});
	});
});
function codeAddress() {
     //        if(msg.slice(0,21) == 'No Transactions Found') {
					// $("#exportlink_date").hide();
					// } else {
					// $("#exportlink_date").show();
					// }
				$('.dataTables-example').dataTable({
					destroy: true,
					"order": [[ 1, "desc" ]],
					responsive: true,
					"dom": 'T<"clear">lfrtip',
					"tableTools": {
						"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
					}
				});
				$('input:checkbox').change(function(){ 
					if($(this).attr('id') == 'selectall')	
					{
						jqCheckAll2( this.id);
					}
				});
        }
window.onload = codeAddress;

function callQueryapi() {
	
    $.ajax({
        method: "POST",
        url: "alipayapi.php",
        data: {action: '7' }
    })
        .done(function (msg) {
            if(msg==1)
                location.reload();
            else
                alert("All Transactions are up to date");
        });
}
$(document).ready(function(){

/*
	$('.date-sec .input-group.date').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		dateFormat: 'yyyy-mm-dd',
		autoclose: true
	});*/

	var mid_1 = '<?php echo $mid; ?>';
	// alert(mid_1);

	$.ajax({

		method: "POST",

		url: "php/inc_dailyreport.php",

		data: { mid: mid_1 }

	})

	.done(function( msg ) {

		$("#dailyreport").html(msg);

	});

	/*$('#date').datepicker({

			todayBtn: "linked",

			keyboardNavigation: false,

			forceParse: false,

			calendarWeeks: true,

			autoclose: true

		});*/

	$("#date").change(function () {

		$.ajax({

			method: "POST",

			url: "php/inc_dailyreport.php",

			data: { date: $(this).val() }

		})

		.done(function( msg ) {

			$("#dailyreport").html(msg);

			$("#exportlink").attr("href", "phpexcel/report.php?date="+$("#date").val());

		});

	});

	var table1 = $('#table1').tabelize({

		/*onRowClick : function(){

			alert('test');

		}*/

		fullRowClickable : true,

		onReady : function(){

			console.log('ready');

		},

		onBeforeRowClick :  function(){

			console.log('onBeforeRowClick');

		},

		onAfterRowClick :  function(){

			console.log('onAfterRowClick');

		},

	});

	//$('#table1 tr').removeClass('contracted').addClass('expanded l1-first'); 

});

</script>

<script type="text/javascript">
	
	(function($){

    $.fn.extend({

        MyPagination: function(options) {
            var defaults = {

                height: 400,

                fadeSpeed: 400

            };
            var options = $.extend(defaults, options);

            //Creating a reference to the object
            var objContent = $(this);

            // other inner variables12
            var fullPages = new Array();

            var subPages = new Array();

            var height = 0;

            var lastPage = 1;

            var paginatePages;

            // initialization function

            init = function() {
                objContent.children().each(function(i){

                    if (height + this.clientHeight > options.height) {

                        fullPages.push(subPages);

                        subPages = new Array();

                        height = 0;

                    }

                    height += this.clientHeight;

                    subPages.push(this);

                });

                if (height > 0) {

                    fullPages.push(subPages);

                }

                // wrapping each full page

                $(fullPages).wrap("<div class='page'></div>");

                // hiding all wrapped pages
                objContent.children().hide();
                // making collection of pages for pagination
              	paginatePages = objContent.children();
                // show first page

                showPage(lastPage);

                // draw controls

              	showPagination($(paginatePages).length);

            };

            // update counter function

            updateCounter = function(i) {

                $('#page_number').html(i);

            };

            // show page function

            showPage = function(page) {

                i = page - 1;

                if (paginatePages[i]) {

                    // hiding old page, display new one
                    $(paginatePages[lastPage]).fadeOut(options.fadeSpeed);

                  lastPage = i;

                    $(paginatePages[lastPage]).fadeIn(options.fadeSpeed);

                    // and updating counter

                    updateCounter(page);

               }

            };

            // show pagination function (draw switching numbers)

            showPagination = function(numPages) {

                var pagins = '';

                for (var i = 1; i <= numPages; i++) {

                    pagins += '<li><a href="#" onclick="showPage(' + i + '); return false;">' + i + '</a></li>';

                }

                $('.pagination li:first-child').after(pagins);

          };

            // perform initialization

            init();

            // and binding 2 events - on clicking to Prev

           $('.pagination #prev').click(function() {

                showPage(lastPage);

            });

          // and Next

            $('.pagination #next').click(function() {

                showPage(lastPage+2);
            });
        }
    });

})(jQuery);

// custom initialization
jQuery(window).load(function() {

    $('#cnt').MyPagination({height: 400, fadeSpeed: 400});

});

</script>


<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>

<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">



<script type="text/javascript">

  $('.tree').treegrid();

</script> 



<!-- ChartJS-->

    <script src="js/plugins/chartJs/Chart.min.js"></script>

	<script type="text/javascript">

	// $(function () {
	$(document).ready(function(){


	/**** Displaying the number of transactions per month in Line graph format ****/

    var lineData = {

        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

        datasets: [

           {

                label: "Count",

                fillColor: "rgba(26,179,148,0.5)",

                strokeColor: "rgba(26,179,148,0.7)",

                pointColor: "rgba(26,179,148,1)",

                pointStrokeColor: "#fff",

                pointHighlightFill: "#fff",

                pointHighlightStroke: "rgba(26,179,148,1)",

                data: [<?php echo $transCnts;?>]

            }
            // ,

            // {

            //     label: "Count",

            //     fillColor: "rgba(255,133,0,0.5)",

            //     strokeColor: "rgba(255,133,0,1)",

            //     pointColor: "rgba(255,133,0,1)",

            //     pointStrokeColor: "#fff",

            //     pointHighlightFill: "#fff",

            //     pointHighlightStroke: "rgba(255,133,0,1)",

            //     data: [<?php  echo $transAmts; // echo $chargebacks_data; ?>]

            // }

        ]

    };



    var lineOptions = {

        scaleShowGridLines: true,

        scaleGridLineColor: "rgba(0,0,0,.05)",

        scaleGridLineWidth: 1,

        bezierCurve: true,

        bezierCurveTension: 0.4,

        pointDot: true,

        pointDotRadius: 4,

        pointDotStrokeWidth: 1,

        pointHitDetectionRadius: 20,

        datasetStroke: true,

        datasetStrokeWidth: 2,

        datasetFill: true,

        responsive: true,

    };

    var ctx = document.getElementById("lineChart").getContext("2d");

    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

	});



	/**** Daily Summary Report for selecting date from picker for alipay ****/
	$('#date2').on("change", function () {
		// alert("OnChange=> "+ $(this).val());
		//var selected_date = $(this).val();
        var selected_date = $('#date2').val();
        var period_start_date = selected_date.slice(0, 16);
        var period_end_date = selected_date.slice(19, 36);
		if(selected_date!='') {
			$('.rlt_row').show();
		}

		/**** Total Transaction Amount with count ****/
        var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};
        // $("#reports_form").serializeArray();
        console.log(postData);
        $.ajax({
            method: "POST",
            url: "php/inc_reportsearch_alipay.php",
            data: postData
        })
        .done(function( msg ) {
            $("#reportresult_alipay").html(msg);
        });
        // END

        /**** Transaction List ****/
		// alert(period_start_date+" => "+period_end_date);
		$.ajax({
			method: "POST",
			url: "php/inc_transsearch_alipay.php",
			data: {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>}
		})
		.done(function( msg ) {

			// alert('Hiiiii');
			$("#cbresults_alipay").html(msg);

			if(msg == 'No Transactions Found') {
				$("#exportlink_date").hide();
			} else {
				$("#exportlink_date").show();
			}

			$('.dataTables-example').dataTable({
				destroy: true,
				"order": [[ 0, "asc" ]],
				responsive: true,
				"dom": 'T<"clear">lfrtip',
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
			$('input:checkbox').change(function() { 
				if($(this).attr('id') == 'selectall') {
					jqCheckAll2( this.id);
				}
			});
			function jqCheckAll2( id ) {
				$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
			}

			var session_id = <?php echo $iid; ?>

			$("#exportlink_date").attr("href", "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date+"&session_id="+session_id);
		});

	});
	/**** Daily Summary Report for selecting date from picker ****/
	$('#date2').on("change", function () {
		// alert("OnChange=> "+ $(this).val());
		//var selected_date = $(this).val();
        var selected_date = $('#date2').val();
        var period_start_date = selected_date.slice(0, 16);
        var period_end_date = selected_date.slice(19, 36);
		if(selected_date!='') {
			$('.rlt_row').show();
		}

		/**** Total Transaction Amount with count ****/
        var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};
        // $("#reports_form").serializeArray();
        console.log(postData);
        $.ajax({
            method: "POST",
            url: "php/inc_reportsearch1.php",
            data: postData
        })
        .done(function( msg ) {
            $("#reportresults").html(msg);
        });
        // END

        /**** Transaction List ****/
		// alert(period_start_date+" => "+period_end_date);
		$.ajax({
			method: "POST",
			url: "php/inc_<?php echo $search_type; ?>search.php",
			data: {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>}
		})
		.done(function( msg ) {

			// alert('Hiiiii');
			$("#cbresults").html(msg);

			if(msg == 'No Transactions Found') {
				$("#exportlink_date").hide();
			} else {
				$("#exportlink_date").show();
			}

			$('.dataTables-example').dataTable({
				destroy: true,
				"order": [[ 0, "asc" ]],
				responsive: true,
				"dom": 'T<"clear">lfrtip',
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
			$('input:checkbox').change(function() { 
				if($(this).attr('id') == 'selectall') {
					jqCheckAll2( this.id);
				}
			});
			function jqCheckAll2( id ) {
				$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
			}

			var session_id = <?php echo $iid; ?>

			$("#exportlink_date").attr("href", "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date+"&session_id="+session_id);
		});

	});

	$('#curtransamt, #curtranscnt').on("click", function () {
		// alert("Selected=> "+ $(this).val());
		location.reload();
		var selected_date = $('#date_1').val();
		// alert($('#date_1').val());
		if(selected_date!='') {
			$('.rlt_row').show();
		}

		$.ajax({
			method: "POST",
			url: "php/inc_<?php echo $search_type; ?>search.php",
			data: {S_Date: selected_date}
		})
		.done(function( msg ) {
			$("#cbresults").html(msg);

			if(msg.slice(0,21) == 'No Transactions Found') {
				$("#exportlink_date").hide();
			} else {
				$("#exportlink_date").show();
			}

			$('.dataTables-example').dataTable({
				destroy: true,
				"order": [[ 0, "asc" ]],
				responsive: true,
				"dom": 'T<"clear">lfrtip',
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
			$('input:checkbox').change(function() { 
				if($(this).attr('id') == 'selectall') {
					jqCheckAll2( this.id);
				}
			});
			function jqCheckAll2( id ) {
				$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
			}

			$("#exportlink_date").attr("href", "php/inc_transsearch.php?date="+selected_date);
		});

	});


	/**** Sparkline Graph jquery ****/
	$('.sparkline').sparkline('html', { enableTagOptions: true });

	$('.sparkline_1').sparkline('html', { enableTagOptions: true });

	// $(window).on('resize', function() {
	// 	$('.sparkline').sparkline('html', { enableTagOptions: true });
	// });


	</script>

    <!--script src="js/demo/chartjs-demo.js"></script-->
<script>


function myrefresh(){
    window.location.reload();
} 

function month_show() {
    $('#today-payment').hide();
    $('#today-payment1').hide();
    $('#month-payment').show();
    $('#month-payment1').show();
    $('#week-payment').hide();
    $('#week-payment1').hide();
    $('#monthbtn').removeClass('label-primary').addClass('label-warning');
    $('#weekbtn').removeClass('label-warning').addClass('label-primary');
    $('#todaybtn').removeClass('label-warning').addClass('label-primary');
}

function today_show() {
    $('#today-payment').show();
    $('#today-payment1').show();
    $('#month-payment').hide();
    $('#month-payment1').hide();
    $('#week-payment').hide();
    $('#week-payment1').hide();
    $('#todaybtn').removeClass('label-primary').addClass('label-warning');
    $('#weekbtn').removeClass('label-warning').addClass('label-primary');
    $('#monthbtn').removeClass('label-warning').addClass('label-primary');
}

function week_show() {
    $('#today-payment').hide();
    $('#today-payment1').hide();
    $('#month-payment').hide();
    $('#month-payment1').hide();
    $('#week-payment').show();
    $('#week-payment1').show();
    $('#weekbtn').removeClass('label-primary').addClass('label-warning');
    $('#todaybtn').removeClass('label-warning').addClass('label-primary');
    $('#monthbtn').removeClass('label-warning').addClass('label-primary');
}
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>

    $(function() {
        $('input[name="date2"]').daterangepicker({
            timePicker: true,
            startDate: '<?php echo date('m/d/Y 00:00'); ?>',
            endDate: '<?php echo date('m/d/Y 23:59'); ?>',
            locale: {
                format: 'MM/DD/YYYY HH:mm'
            }
        });
    });

     $(function() {
        $('input[name="date_2"]').daterangepicker({
            startDate: '<?php echo date('m/d/Y'); ?>',
            endDate: '<?php echo date('m/d/Y'); ?>',
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
    });

    $( document ).ready(function() {
        //var selected_date = $('#date').val();
        var selected_date = $('#date2').val();
        var period_start_date = selected_date.slice(0, 16);
        var period_end_date = selected_date.slice(19, 36);
        if(selected_date!='') {
            $('.rlt_row').show();
        }

        /**** Total Transaction Amount with count ****/
        var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};
        // $("#reports_form").serializeArray();
        console.log(postData);
        $.ajax({
            method: "POST",
            url: "php/inc_reportsearch1.php",
            data: postData
        })
        .done(function( msg ) {
            $("#reportresults").html(msg);
        });
        // END


        /**** Total Transaction Amount with count ****/
        var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};
        // $("#reports_form").serializeArray();
        console.log(postData);
        $.ajax({
            method: "POST",
            url: "php/inc_reportsearch_alipay.php",
            data: postData
        })
        .done(function( msg ) {
            $("#reportresult_alipay").html(msg);
        });
        // END

        /**** Transaction List ****/
        $.ajax({
            method: "POST",
            url: "php/inc_<?php echo $search_type; ?>search.php",
            data: {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>}
        })
            .done(function( msg ) {
                $("#cbresults").html(msg);
                console.log(msg.slice(0,21));

                if(msg.slice(0,21) == 'No Transactions Found') {
                    $("#exportlink_date").hide();
                } else {
                    $("#exportlink_date").show();
                }

                $('.dataTables-example').dataTable({
                	destroy: true,
                    "order": [[ 0, "asc" ]],   
                    responsive: true,
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                    }
                });
                $('input:checkbox').change(function() {
                    if($(this).attr('id') == 'selectall') {
                        jqCheckAll2( this.id);
                    }
                });
                function jqCheckAll2( id ) {
                    $("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
                }

                $("#exportlink_date").attr("href", "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date);
            });

             $.ajax({
            method: "POST",
            url: "php/inc_transsearch_alipay.php",
            data: {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>}
        })
            .done(function( msg ) {
                $("#cbresults_alipay").html(msg);
                console.log(msg.slice(0,21));

                if(msg.slice(0,21) == 'No Transactions Found') {
                    $("#exportlink_date").hide();
                } else {
                    $("#exportlink_date").show();
                }

                $('.dataTables-example').dataTable({
                	destroy: true,
                    "order": [[ 0, "asc" ]],
                    responsive: true,
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                    }
                });
                $('input:checkbox').change(function() {
                    if($(this).attr('id') == 'selectall') {
                        jqCheckAll2( this.id);
                    }
                });
                function jqCheckAll2( id ) {
                    $("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
                }

                $("#exportlink_date").attr("href", "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date);
            });
    });

</script>

<script type="text/javascript">
    
$(document).ready(function(){

        $("#merchantid").change(function(){
            if($(this).val()){
               var value1=$(this).val();
               if(value1=="0"||value1=="")
               {
               	$("#sale").show();
               	$("#net").show();
               	$("#sale1").hide();
               	$("#net1").hide();
               }
               else {
               	$("#sale1").show();
               	$("#net1").show();
               	$("#sale").hide();
               	$("#net").hide();

               }
                $.ajax({
                    type: 'POST',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'merchant_id'}),
                    url: "php/inc_reportmerchant.php",
                    sucess: function(msg) {
                    // console.log(data);
                    // thisDiv.find('#sale1').html(msg.sale);
                    // thisDiv.find('#net1').html(msg.net);
                    // var obj = JSON.parse(data);
                    // $('#sale1').html(obj.sale);
                    // $('#net1').html(obj.net);
        				//$('<div></div>').text(data.tournament).appendTo('body');
                    }
                }).done(function( msg ) {
         		console.log(msg);
         		     var obj = JSON.parse(msg);
                    $('#sale1').html(obj.sale);
                    $('#net1').html(obj.net);

           });
            }
        });

});

$(document).ready(function(){

        $("#date2").change(function(){
            if($(this).val()){
               // var value1=$(this).val();

               var selected_date = $(this).val();
        	   var period_start_date = selected_date.slice(0, 16);
        	   var period_end_date = selected_date.slice(19, 36);
               // if(value1=="0"||value1=="")
               // {
               // 	$("#sale").show();
               // 	$("#net").show();
               // 	$("#sale1").hide();
               // 	$("#net1").hide();
               // }
               // else {
               // 	$("#sale1").show();
               // 	$("#net1").show();
               // 	$("#sale").hide();
               // 	$("#net").hide();

               // }
               var postData = {start_date:period_start_date, end_date:period_end_date};
                $.ajax({
                    type: 'POST',
                    data:postData,
                    url: "php/inc_reportmerchant.php",
                    sucess: function(msg) {
                    // console.log(data);
                    // thisDiv.find('#sale1').html(msg.sale);
                    // thisDiv.find('#net1').html(msg.net);
                    // var obj = JSON.parse(data);
                    // $('#sale1').html(obj.sale);
                    // $('#net1').html(obj.net);
        				//$('<div></div>').text(data.tournament).appendTo('body');
                    }
                }).done(function( msg ) {
         		console.log(msg);
         		     var obj = JSON.parse(msg);
                    $('#sale1').html(obj.sale);
                    $('#net1').html(obj.net);

           });
            }
        });

});

</script>
<?php require_once('footer.php'); ?>