<?php
require_once('header.php'); 

if($_SESSION['user_type'] === 6)
	include_once('forbidden.php');

?>
<style type="text/css">
.dataTables_filter label, a.DTTT_button.DTTT_button_print {
	display: none;
}
</style>
<?php
$iid = $_SESSION['iid'];
$db->where("id",$iid);
$userDet = $db->getOne('users');
$username = $userDet['username'];

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
// echo $userDet['username']; exit;
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


$userDet = getUserdata2($_SESSION['iid']);
if($userDet['terminal_id'] !='') {
	$terminal_id = $userDet['terminal_id'];
	$db->where("idmerchants",$userDet['merchant_id']);
	$merchantDet = $db->getOne("merchants");
} else {
	$terminal_id = '';
	$merchantDet = getUserdata3($_SESSION['iid']);
}

if($merchantDet['currency_code'] == 'USD') {
	setlocale(LC_MONETARY, 'en_US');
	$ccode = '$';
} else if($merchantDet['currency_code'] == 'LKR') {
	setlocale(LC_MONETARY, 'en_US');
	// setlocale(LC_MONETARY, 'en_IN');
	$ccode = 'Rs';
}

/**** Terminal and Merchant based Queries ****/
if($terminal_id!='') {
	require_once('dash_terminal.php'); 
} else {
	require_once('dash_merchant.php');
}
?>

<!-- Overall Transaction Report in Column Tiles 2 -->
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
		<h3 style="padding-left: 15px; margin: 15px 0;">Transaction Activity Details</h3>
	    <div class="col-sm-6 col-md-6 col-lg-3">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-success pull-right">Today</span>
	                <h5>Transactions Value</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<a id="curtransamt_1" href="javascript:void(0);"><?php echo $CurrdayTransamount; ?></a>
	                </h1>
	                <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
	                <!-- <small>Total income</small> -->
	            </div>
	        </div>
	    </div>
	    <div class="col-sm-6 col-md-6 col-lg-3">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-info pull-right">Today</span>
	                <h5>Transactions Count</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<a id="curtranscnt_1" href="javascript:void(0);"><?php echo $CurrdayTranscount; ?></a>
	                </h1>
	                <!-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
	                <!-- <small>New orders</small> -->
	            </div>
	        </div>
	    </div>
	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
				<button class="label label-warning pull-right" id="monthbtn" onclick="month_show();">This Month</button>
				<button class="label label-primary pull-right" id="weekbtn" onclick="week_show();">This Week</button>
				<button class="label label-primary pull-right" id="todaybtn" onclick="today_show();">Today</button>
	                <!--span class="label label-primary pull-right">This month</span-->
	                <h5>Total Transactions Value</h5>
	            </div>
	            <div class="ibox-content five-cols">
	                <!-- <h1 class="no-margins"><?php // echo $CurrMonthTransamount; ?></h1> -->
	                <!-- <div class="row">
	                	<div class="col-sm-3 col-md-3 col-lg-3"><h5 class="no-margins f-w-b">Amount</h5><small>$1114</small></div>
	                	<div class="col-sm-2 col-md-2 col-lg-2"><h5 class="no-margins f-w-b">Count</h5><small>$1114</small></div>
	                	<div class="col-sm-3 col-md-3 col-lg-3"><h5 class="no-margins f-w-b">Sales</h5><small>$1114</small></div>
	                	<div class="col-sm-2 col-md-2 col-lg-2"><h5 class="no-margins f-w-b">Cancel</h5><small>$1114</small></div>
	                	<div class="col-sm-2 col-md-2 col-lg-2"><h5 class="no-margins f-w-b">Refund</h5><small>$1114</small></div>
	                </div> -->
	                <div class="row">
					<div id="cbresultsn"></div>
		                <div class="col-xs-12 col-sm-12">
							<div class="row">
							  <div class="col-xs-7 col-sm-7 five-three" style="font-size: 14px;">
							    <div class="row" id="month-payment">
							      <div class="col-xs-4 col-sm-5">
							      <h5 class="no-margins f-w-b">Amount</h5><small><?php echo $CurrMonthTransamount; ?></small>
							      </div>
							      <div class="col-xs-4 col-sm-2">
							      <h5 class="no-margins f-w-b">Count</h5><small><?php echo $CurrMonthTranscount; ?></small>
							      </div>
							      <div class="col-xs-4 col-sm-5">
							      <h5 class="no-margins f-w-b">Sales</h5><small><?php echo $CurrMonthTransamount; ?></small>
							      </div><!-- end inner row -->
							    </div>

                                  <div class="row" id="today-payment" style="display: none;">
                                      <div class="col-xs-4 col-sm-4">
                                          <h5 class="no-margins f-w-b">Amount</h5><small><?php echo $CurrTodayTransamount; ?></small>
                                      </div>
                                      <div class="col-xs-4 col-sm-4">
                                          <h5 class="no-margins f-w-b">Count</h5><small><?php echo $CurrTodayTranscount; ?></small>
                                      </div>
                                      <div class="col-xs-4 col-sm-4">
                                          <h5 class="no-margins f-w-b">Sales</h5><small><?php echo $CurrTodayTransamount; ?></small>
                                      </div><!-- end inner row -->
                                  </div>

                                  <div class="row" id="week-payment" style="display: none;">
                                      <div class="col-xs-4 col-sm-4">
                                          <h5 class="no-margins f-w-b">Amount</h5><small><?php echo $CurrWeekTransamount; ?></small>
                                      </div>
                                      <div class="col-xs-4 col-sm-4">
                                          <h5 class="no-margins f-w-b">Count</h5><small><?php echo $CurrWeekTranscount; ?></small>
                                      </div>
                                      <div class="col-xs-4 col-sm-4">
                                          <h5 class="no-margins f-w-b">Sales</h5><small><?php echo $CurrWeekTransamount; ?></small>
                                      </div><!-- end inner row -->
                                  </div>
							  </div>
							  <div class="col-xs-5 col-sm-5 five-two">
							    <div class="row"  id="month-payment1">
							      <div class="col-xs-6 col-sm-6">
							        <h5 class="no-margins f-w-b">Cancel</h5>
							        <small><?php echo $CurrMonthTrans_cancel_amount; ?></small>
							      </div>
							      <div class="col-xs-6 col-sm-6">
							        <h5 class="no-margins f-w-b">Refund</h5><small><?php echo $CurrMonthTrans_refund_amount; ?></small>
							      </div>
							    </div><!-- end inner row -->

                                  <div class="row" id="today-payment1" style="display: none;">
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Cancel</h5>
                                          <small><?php echo $CurrTodayTrans_cancel_amount; ?></small>
                                      </div>
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Refund</h5><small><?php echo $CurrTodayTrans_refund_amount; ?></small>
                                      </div>
                                  </div><!-- end inner row -->

                                  <div class="row"  id="week-payment1" style="display: none;">
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Cancel</h5>
                                          <small><?php echo $CurrWeekTrans_cancel_amount; ?></small>
                                      </div>
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Refund</h5><small><?php echo $CurrWeekTrans_refund_amount; ?></small>
                                      </div>
                                  </div><!-- end inner row -->
							  </div>
							</div><!-- end outer row -->
						</div>
					</div>

	            </div>
	        </div>
	    </div>
	    <!-- <div class="col-sm-6 col-md-6 col-lg-3">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-info pull-right">This month</span>
	                <h5>Transactions Count</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins"><?php echo $CurrMonthTranscount; ?></h1>
	                <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
	                <small>In first month</small>
	            </div>
	        </div>
		</div> -->
	</div>
</div>

<style type="text/css">
.daterangepicker.show-calendar .drp-buttons {
	display: none !important;
}
#button1 {color: #e8edef;
    background-color: #44b547;}
</style>


<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins no-margins"><center><span style="color:red"><?php echo $omg; ?></span></center>

			<div class="ibox-title iboxsummary">

				<div class="col-xs-3 col-sm-3 no-padding title-sec">
					<h5>Daily Summary</h5>
				</div>

				<div class="col-xs-5 col-sm-4 date-sec" style="position: relative;">
					<input type="button" name="button" id="button1" value="Submit" style="position: absolute; right: -50px; top: -4px;">

					<div class="input-group date datesummary">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<!--<input class="form-control" name="date" id="date" type="text" value="<?php echo date('m/d/Y'); ?>" >-->
						<input class="form-control" name="date2" id="date2" type="text"  value="" autocomplete="off" >
						<input type="hidden" name="date_1" id="date_1" value="<?php echo date('m/d/Y'); // echo date('m/d/Y',strtotime("-1 days")); ?>">
						<input type="hidden" name="merchantid" id="merchantid" value="<?php echo $merchantDet['mer_map_id']; ?>">
						<input type="hidden" name="terminalid" id="terminalid" value="<?php echo $terminal_id; ?>">
					</div>
				</div>

				<!-- <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="" class="form-control" name="period_start_date" id="period_start_date">
                </div> -->

				<!-- <button type="button" class="btn btn-default btn-sm refbtn">
					<span class="glyphicon glyphicon-refresh"></span> Refresh
				</button> -->

				<a class="btn btn-default btn-sm refbtn" style="display:none;" href="#" onclick="callQueryapi(); myrefresh();" role="button">
					<span class="glyphicon glyphicon-refresh"></span> Refresh
				</a>

				<div class="ibox-tools toolssummary">

					<!-- <a id="exportlink" href="phpexcel/report.php?date=<?php //echo date('m/d/Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a> -->

					<!-- <a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a> -->

					<!-- <a class="close-link">
						<i class="fa fa-times"></i>
					</a> -->

				</div>

			</div>

			<!-- <div class="ibox-content">

				<h3 class="pull-left"><?php //echo getUserMerchantName($id); ?><br /></h3>

				<div class="pull-right">

					<label class="col-sm-3 control-label">Date &nbsp;</label>

					<div class="col-sm-3"> 

						<div class="input-group date">
							<span class="input-group-addon m-b"><i class="fa fa-calendar"></i></span>
							<input class="form-control m-b" name="date" id="date" type="text" value="<?php //echo date('m/d/Y');?>" >
						</div>

					</div>

                </div>

				<div class="clearfix"></div>

			</div> -->

		</div>

		<div id="reportresults" style="padding: 15px 15px 1px; background-color: #fff;"></div>

	</div>

</div>

<div class="clearfix"></div>

<div class="row rlt_row" style="display: none;">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title  back-change">
				<h5>Results</h5>
				<div class="ibox-tools">
					<a id="exportlink_date" href="php/inc_transsearch.php?date=<?php echo date('m/d/Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a>
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<!-- <a class="close-link">
						<i class="fa fa-times"></i>
					</a> -->
				</div>
			</div>
			<div class="ibox-content">
				<!-- <div id="reportresults"></div> -->
				<div id="cbresults"></div>
			</div>
			
		</div>
	</div>
</div>

<!-- Button trigger modal -->
<!-- <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->

<div id="dailyreport" style="display: none;"></div>

<div class="row">

	<div class="col-lg-12" <?php if($terminal_id!='') { echo 'style="display: none;"'; } ?>>
		<div class="ibox float-e-margins">
			<?php echo $error; ?>
			<div class="ibox-title">
				<h5>Year - To Date Transactions Chart</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<!-- <a class="close-link">
						<i class="fa fa-times"></i>
					</a> -->
				</div>
			</div>

			<?php
			//require_once('php/database_config.php');
			$iid = $_SESSION['iid'];
			?>
			<div class="ibox-content">
				<div>
					<span class="pull-right text-right">

						<small>Total value of transactions for the current year</small><br/>
						All transactions: 
						<?php  
						// echo !empty($num_yearly_transactions) ? $num_yearly_transactions : 0;
						echo $transCntval!= 0 ? $transCntval : 0;
						?>
					</span>

					<h1 class="m-b-xs">
						<?php echo $ccode; ?> 
						<?php
						// echo number_format((float)str_replace(',', '', (!empty($total_yearly_transactions)) ? $total_yearly_transactions : 0 ) - (float)str_replace(',', '', (!empty($total_yearly_refunds)) ? $total_yearly_refunds : 0), 2, '.', ','); 
						echo money_format('%!i', $totTransamount);
						?>
					</h1>
					<h3 class="font-bold no-margins">Transactions</h3>
					<small>
						<!-- <button class="btn btn-primary pull-right" style="background-color:#ffc27f;" value="Transaction count">Total Amount </button> -->
						<button class="btn btn-primary pull-right" style="background-color:rgba(26,179,148,0.5);" value="Transaction Amount">Total Count</button>
					</small>
				</div>

				<div>
					<canvas id="lineChart" height="70"></canvas>
				</div>

				<div class="m-t-md">
					<small class="pull-right">
						<i class="fa fa-clock-o"> </i>
						<strong>Updated on <?php echo date("d-m-Y H:i:s A"); ?></strong>
					</small>
					<small>
					<strong>Analysis of transactions for the current year.</strong>
					</small>
				</div>

			</div>

		</div>

	</div>

	

</div>

<?php } else { ?>

<?php
// $q = 'SELECT  FROM merchants';
// $records = $db->rawQuery($q);
// echo "<pre>";
// print_r($records);
// sleep(40);
$iid = $_SESSION['iid'];
$db->where("id",$iid);
$userDet = $db->getOne('users');
$username = $userDet['username'];

function convertnumber( $num, $precision = 1 ) {
	$last=substr($num, -1);
	$remaining=substr($num, 0, -1);
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

/**** Get the Month-wise "Monthly Recurring Revenue" ****/
function get_sale_groupby_ccode($currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND transaction_alipay.transaction_type IN ('1','s1') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trade_status='TRADE_SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month, merchants.currency_code";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;	
}

/**** Get the Month-wise "Cancel Amount by Currency" ****/
function get_cancel_by_ccode($ccode,$currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND transaction_alipay.transaction_type IN ('4','s4') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}

/**** Get the Month-wise "Refund Amount by Currency" ****/
function get_refund_by_ccode($ccode,$currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.refund_amount) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND transaction_alipay.transaction_type IN ('2','s2') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
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
	if($ccode == 'USD') {
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
	if($ccode == 'USD') {
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
$LKR_current_Sale_amt = substr($transactions_M_R_Sale_amt1_firstExp[0],0,strpos($transactions_M_R_Sale_amt1_firstExp[0],"LKR"));
$USD_current_Sale_amt = substr($transactions_M_R_Sale_amt1_firstExp[1],0,strpos($transactions_M_R_Sale_amt1_firstExp[1],"USD"));
$LKR_current_Sale_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim($LKR_current_Sale_amt),2));
$USD_current_Sale_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim($USD_current_Sale_amt),2));


$transactions_M_R_Sale_amt_lastlist_firstExp = explode("~", $transactions_M_R_Sale_amt_lastlist);
$LKR_previous_Sale_amt = substr($transactions_M_R_Sale_amt_lastlist_firstExp[0],0,strpos($transactions_M_R_Sale_amt_lastlist_firstExp[0],"LKR"));
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
$LKR_current_Net_amt = substr($transactions_M_R_Net_amt1_firstExp[0],0,strpos($transactions_M_R_Net_amt1_firstExp[0],"LKR"));
$USD_current_Net_amt = substr($transactions_M_R_Net_amt1_firstExp[1],0,strpos($transactions_M_R_Net_amt1_firstExp[1],"USD"));
$LKR_current_Net_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim(strip_tags($LKR_current_Net_amt)),2));
$USD_current_Net_amt_num = preg_replace("/[^0-9\.]/",'',convertnumber(trim(strip_tags($USD_current_Net_amt)),2));

$transactions_M_R_Net_amt_lastlist_firstExp = explode("~", $transactions_M_R_Net_amt_lastlist);
$LKR_previous_Net_amt = substr($transactions_M_R_Net_amt_lastlist_firstExp[0],0,strpos($transactions_M_R_Net_amt_lastlist_firstExp[0],"LKR"));
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

<?php if(!in_array($username, array("payableadmin", "hutchadminuser"))) {
	  // if($username != "payableadmin") { ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
	<h3 style="padding-left: 15px; margin: 15px 0;">Transaction Activity Details</h3>
	    <div class="col-sm-6 col-md-6 col-lg-6">
	        <div class="ibox float-e-margins">
	            <div class="ibox-content admin">
	                <?php echo $transactions_M_R_amt; ?>
	                <strong class="pull-right">
	                <i class="fa <?php echo $Sale_variation_arrow; ?>" aria-hidden="true"></i>
	              	<?php echo number_format($Sale_average_percentage,2)." %"; ?><br>
	                <span>Previous 30 Days</span>
	                </strong>
	            </div>
	            <div class="titleDet">
	            	<h2 align="center">Monthly Recurring Revenue</h2>
	            </div>
	        </div>
	    </div>
	    <div class="col-sm-6 col-md-6 col-lg-6">
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
	                	<?php echo number_format($Net_average_percentage,2)." %"; ?><br>
	                	<span>Previous 30 Days </span>
	                </strong>
	            </div>
	            <div class="titleDet">
	            	<h2 align="center">Monthly Net Revenue</h2>
	            </div>
	        </div>
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

<?php } ?>

<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins">

			<?php if(!in_array($username, array("hutchadminuser"))) { ?>

			<div class="ibox-title">

				<h5>Merchant Accounts <?php // echo $usertype; ?></h5>

				<?php // if($username != 'payableadmin') { ?>
				<div class="frmSearch">
					<b>Search : </b>
					<input type="text" id="search-box" name="mer_name" placeholder="Search Merchant Name" />
					<div id="suggesstion-box"></div>
				</div>
				<?php // } ?>

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

					// echo '<table id="table1" class="controller table table-striped">';

					// echo '<thead>
					// 		<tr data-level="header" class="header">
					// 			<th>Merchant Name</th>
					// 			<th>Customer Service Email</th>
					// 			<th>Customer Service Phone</th>
					// 			<th>Status</th>
					// 		</tr>
					// 	  </thead>';

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
					foreach($arr as $item){

						$i++;
						$trans_count = trans_history($item['mer_map_id']);

						$cclass = (empty($item['Children']) && empty($item['Merchants']))?'class="no-children"':'';

						// $active = (empty($item['Children']) && empty($item['Merchants']))?"Inactive":"Active";
						$active = $item['Active'] == 1 ? "Active":"In-Active";

						$merchant_Name = $trans_count > 0 ? "<strong>".strip_tags($item['Name'])."</strong><img src='img/spimg/time_loading.gif' width='16' height='16' />":strip_tags($item['Name']);

						echo   '<tr data-level="1" id="level_1_'.$item['Mid'].'" '.$cclass.'>
								<td style="padding:5px 5px 5px 10px !important;"><i class="fa fa-male"></i> 
								<a style="margin-left:5px;" href="viewagent.php?merchantid='.strip_tags($item['Mid']).'">'.$merchant_Name.'</td>

								<td class="data" style="padding:5px !important;">'.strip_tags($item['Email']).'</td>
								<td class="data" style="padding:5px !important;">'.strip_tags($item['Phone']).'</td>
								<td class="data" style="padding:5px !important;">'.strip_tags($active).'</td>
								</tr>';

						if(is_array($item['Children'])){
							displayArr($item['Children'], 2);
						}
						if(is_array($item['Merchants'])){
							displayMerchants($item['Merchants'], 2);
						}
					}
					echo '</table>';
					?>
				</div>

			</div>

			<?php } ?>

			<?php if(in_array($username, array("hutchadminuser"))) { ?>

			<div class="ibox-title">

				<h5>User Accounts</h5>
				<!-- <div class="frmSearch">
					<b>Search : </b>
					<input type="text" id="search-box" name="mer_name" placeholder="Search Merchant Name" />
					<div id="suggesstion-box"></div>
				</div> -->

			</div>

			<div class="ibox-content">

				<?php

				$db->where('merchant_id',$userDet['merchant_id']);
				$db->where('user_type',5);
				$db->where('terminal_id','NULL','!=');
				$merchant_details = $db->get("users");
				if($merchant_details) {
		            $merchant_result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
					//$merchant_result .='<table class="table table-hover table-responsive">';
					$merchant_result .='<thead>
							<tr data-level="header" class="header">
								<th>User Name</th>
								<th>User Email</th>
								<th>User Phone</th>
								<th>Terminal ID</th>
							</tr>
						  </thead>
						  <tbody>';
					foreach($merchant_details as $row) {
						$cclass = 'class="no-children"';
						$active = $row['is_active'] == 1 ? "Active":"In-Active";
						$User_Name = strip_tags($row['username']);
						$Terminal_id = strip_tags($row['terminal_id']);

						$merchant_result .=  '<tr class="gradeX">
								<td><i class="fa fa-male"></i><a href="viewagenthutch.php?userid='.strip_tags($row['id']).'"> '.$User_Name.'</td>
								<td class="data">'.strip_tags($row['email_address']).'</td>
								<td class="data">'.strip_tags($row['phone']).'</td>
								<td class="data">'.$Terminal_id.'</td>
								</tr>';
					}

					$merchant_result .= '</tbody></table>';
				} else {
					$merchant_result ="No Records Found";
				}
				echo $merchant_result;
				?>
				
			</div>

			<?php } ?>

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

function trans_history($merchantid){
	global $db;
	$current_date=date('Y-m-d');
	$count_transaction_query = "SELECT COUNT(id_transaction_id) AS count, merchant_id FROM transaction_alipay WHERE merchant_id='$merchantid' AND trans_date='$current_date' GROUP BY merchant_id";
    $count_transaction = $db->rawQuery($count_transaction_query);
    if(empty($count_transaction)) {
    	$count = 0;
    } else {
    	$count = $count_transaction[0]['count'];
    }
    return $count;
}		

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

<script>

// AJAX call for autocomplete 
$(document).ready(function(){

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
			success: function(data) {
				console.log(data);
				$("#cnt").html(data);

				if(data.slice(0,21) == 'No Transactions Found') {
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
				// $("#suggesstion-box").show();
				// $("#suggesstion-box").html(data);
				// $("#search-box").css("background","#FFF");
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

	// var table1 = $('#table1').tabelize({

	// 	/*onRowClick : function(){

	// 		alert('test');

	// 	}*/

	// 	fullRowClickable : true,

	// 	onReady : function(){

	// 		console.log('ready');

	// 	},

	// 	onBeforeRowClick :  function(){

	// 		console.log('onBeforeRowClick');

	// 	},

	// 	onAfterRowClick :  function(){

	// 		console.log('onAfterRowClick');

	// 	},

	// });

	

	//$('#table1 tr').removeClass('contracted').addClass('expanded l1-first'); 

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

	$( document ).ready(function() {
		/**** Daily Summary Report for selecting date from picker ****/
		$('#date2').on("change", function () {

			// alert("Hiiiii");
			// alert("OnChange=> "+ $(this).val());
			//var selected_date = $(this).val();
	        var selected_date = $('#date2').val();
	        var period_start_date = selected_date.slice(0, 16);
	        var period_end_date = selected_date.slice(19, 36);
	        var selected_merchantid = $('#merchantid').val();
			var selected_terminalid = $('#terminalid').val();
			if(selected_date!='') {
				$('.rlt_row').show();
			}

			var Trans='1';

			var session_id = <?php echo $iid; ?>

			/**** Total Transaction Amount with count ****/
	        // var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};

	        /**** Total Transaction Amount with count ****/
			if(selected_merchantid!='' && selected_terminalid!='') { // For Terminal Based User's Login
				var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1,Trans:Trans,merchantid:selected_merchantid,terminalid:selected_terminalid};
				var postUrl = "php/inc_reporthutchmercht.php";

				var postData_T = {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>,merchantid:selected_merchantid,terminalid:selected_terminalid};
				var postData_TUrl = "php/inc_reporthutchmercht.php";

				var exportLink = "php/inc_reporthutchmercht.php?start_d="+period_start_date+"&end_d="+period_end_date+"&merchantid="+selected_merchantid+"&terminalid="+selected_terminalid;
			} else {                                                 // For Merchant Based User's Login
		    	var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};
		    	var postUrl = "php/inc_reportsearch1.php";

		    	var postData_T = {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>};
				var postData_TUrl = "php/inc_<?php echo $search_type; ?>search.php";

				var exportLink = "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date+"&session_id="+session_id;
		    }

	        // $("#reports_form").serializeArray();
	        console.log(postData);
	        $.ajax({
	            method: "POST",
		        url: postUrl,
		        data: postData
	        })
	        .done(function( msg ) {
	            $("#reportresults").html(msg);
	        });
	        // END
	        console.log(postData_T);

	        /**** Transaction List ****/
			// alert(period_start_date+" => "+period_end_date);
			$.ajax({
				method: "POST",
				url: postData_TUrl,
				data: postData_T
			})
			.done(function( msg ) {

				// alert('Hiiiii');
				$("#cbresults").html(msg);
				console.log(msg);

				$('.dataTables-example').dataTable({
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

				// $("#exportlink_date").attr("href", "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date+"&session_id="+session_id);
				$("#exportlink_date").attr("href", exportLink);

				if(msg.slice(0,21) == 'No Transactions Found') {
		            $("#exportlink_date").hide();
		        } else {
		            $("#exportlink_date").show();
		        }
			});
			// END
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

    // $( document ).ready(function() {

    // 	alert("Hi2");
    //     //var selected_date = $('#date').val();
    //     var selected_date = $('#date2').val();
    //     var period_start_date = selected_date.slice(0, 16);
    //     var period_end_date = selected_date.slice(19, 36);
    //     if(selected_date!='') {
    //         $('.rlt_row').show();
    //     }

    //     /**** Total Transaction Amount with count ****/
    //     var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1};
    //     // $("#reports_form").serializeArray();
    //     console.log(postData);
    //     $.ajax({
    //         method: "POST",
    //         url: "php/inc_reportsearch1.php",
    //         data: postData
    //     })
    //     .done(function( msg ) {
    //         $("#reportresults").html(msg);
    //     });
    //     // END

    //     /**** Transaction List ****/
    //     $.ajax({
    //         method: "POST",
    //         url: "php/inc_<?php echo $search_type; ?>search.php",
    //         data: {period_start_date1: period_start_date, period_end_date1:period_end_date, session_id:<?php echo $iid; ?>}
    //     })
    //     .done(function( msg ) {
    //         $("#cbresults").html(msg);
    //         console.log(msg.slice(0,21));

    //         if(msg.slice(0,21) == 'No Transactions Found') {
    //             $("#exportlink_date").hide();
    //         } else {
    //             $("#exportlink_date").show();
    //         }

    //         $('.dataTables-example').dataTable({
    //             "order": [[ 0, "asc" ]],
    //             responsive: true,
    //             "dom": 'T<"clear">lfrtip',
    //             "tableTools": {
    //                 "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
    //             }
    //         });
    //         $('input:checkbox').change(function() {
    //             if($(this).attr('id') == 'selectall') {
    //                 jqCheckAll2( this.id);
    //             }
    //         });
    //         function jqCheckAll2( id ) {
    //             $("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
    //         }

    //         $("#exportlink_date").attr("href", "php/inc_transsearch.php?start_d="+period_start_date+"&end_d="+period_end_date);
    //     });
    //     // END
    // });

</script>
<?php require_once('footer.php'); ?>