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

// echo $iid;

function number_point($value) {
    $myAngloSaxonianNumber = number_format($value, 2, '.', ','); //Conversion of single decimal point to two decimal point ex: 5,678.9 =>5,678.90
    return $myAngloSaxonianNumber;
}

$vcols1 = Array ("mer_map_id");
$db->where("userid",$iid);
$merDet = $db->get("merchants", null, $vcols1);

$i = 0;
foreach ($merDet as $key => $val) {
	$db->where("pg_merchant_id",$val['mer_map_id']);
	$VendorDet = $db->get('vendor_config');
	foreach ($VendorDet as $ven) {
		if(in_array($ven['vendor_name'], ['alipay', 'grabpay'])) {
			$vendor[$ven['vendor_name']]   = $ven['vendor_name'];
			$merchants[$ven['vendor_name']]= $ven['pg_merchant_id'];
			// $i++;
		}
	}
}

// echo "<pre>";
// print_r($vendor); 

// echo "<br>"; 

// echo "<pre>";
// print_r($merchants);
// exit;

$currentdate = date('Y-m-d');
$currentdate_start = date('Y-m-d 00:00:00');
$currentdate_end   = date('Y-m-d 23:59:59');
?>

<!-- <style type="text/css">
#exTab2 h3 {
	color : white;
	background-color: #428bca;
	padding : 5px 15px;
}
</style> -->

<div id="exTab2" class="container no-padding">	
	<ul class="nav nav-tabs">
		<?php
		$i = 0;
		foreach ($vendor as $key => $value) {
			if(in_array($value, ['alipay', 'grabpay'])) {
				$i++;
				if($i == 1) {
					$active = 'active';
				} else {
					$active = '';
				}
				?>
				<li class="<?php echo $active; ?>">
					<a href="#<?php echo $i; ?>" data-toggle="tab"><?php echo ucfirst($value); ?></a>
				</li>
				<?php
			}
		}
		?>
		<!-- <li class="active"><a href="#1" data-toggle="tab">Overview</a></li>
		<li><a href="#2" data-toggle="tab">Without clearfix</a></li>
		<li><a href="#3" data-toggle="tab">Solution</a></li> -->
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="1">
			<h3>Standard tab panel created on bootstrap using nav-tabs</h3>
			<?php // echo require_once('dash_grabpay.php'); ?>
			<?php
			foreach ($vendor as $value) {
				if(in_array($value, ['grabpay'])) {
					$merchantId = $merchants[$value];
					$vendorName = $value;
				}
			}
			$db->where('mer_map_id',$merchantId);
			$merchants_details = $db->getOne('merchants');
			// echo "<pre>";
			// print_r($merchants_details);
			if($merchants_details['currency_code'] == 'SGD') {
				setlocale(LC_MONETARY, 'en_US');
				$ccode = '$';
			} else {
				setlocale(LC_MONETARY, 'en_US');
				$ccode = '$';
			}
			// echo $ccode;

			/**** Get the Current Day Transaction List ****/
			$D_query="SELECT YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success'  AND DATE(gp_transaction.gp_trans_datetime) = '$currentdate' GROUP BY year, month";
			$transactions_Currday = $db->rawQuery($D_query);

			// echo "<pre>";
			// print_r($transactions_Currday); exit;

			// Current Day Transaction Amount and Count
			$transactions_Currday1 = number_point($transactions_Currday[0]['transamount']/100);
			$CurrdayTransamount = $transactions_Currday1 !='' ? $ccode.' '.money_format('%!i', $transactions_Currday1) : '--';
			//$CurrdayTransamount = number_point($CurrdayTransamount);
			$CurrdayTranscount  = $transactions_Currday[0]['transcount']!='' ? $transactions_Currday[0]['transcount'] : '--';

			/**** Get the Current Month Transaction List ****/
			$M_query="SELECT YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success' AND MONTH(gp_transaction.gp_trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
			$transactions_Currmonth = $db->rawQuery($M_query);

			// Current Month Transaction/Sales Amount and Count
			$transactions_Currmonth_new =  number_point($transactions_Currmonth[0]['transamount']/100);
			$CurrMonthTransamount = $transactions_Currmonth_new!='' ? $ccode.' '.money_format('%!i', $transactions_Currmonth_new) : '--';
			$CurrMonthTranscount  = $transactions_Currmonth[0]['transcount']!='' ? $transactions_Currmonth[0]['transcount'] : '--';

			/**** Get the Current Month Transaction Cancel List ****/
			$MC_query="SELECT YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('3','s4') AND gp_transaction.gp_status='success' AND MONTH(gp_transaction.gp_trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
			$transactions_cancel_Currmonth = $db->rawQuery($MC_query);

			// Current Month Transaction Cancel Amount and Count
			$transactions_cancel_Currmonth_new = number_point($transactions_cancel_Currmonth[0]['transamount']/100);
			$CurrMonthTrans_cancel_amount = $transactions_cancel_Currmonth_new!='' ? $ccode.' '.money_format('%!i', $$transactions_cancel_Currmonth_new) : '--';
			$CurrMonthTrans_cancel_count  = $transactions_cancel_Currmonth[0]['transcount']!='' ? $transactions_cancel_Currmonth[0]['transcount'] : '--';

			/**** Get the Current Month Transaction Refund List ****/
			$MC_query="SELECT YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount, SUM(gp_transaction.gp_amount) AS refundamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('2','s2','cb2') AND gp_transaction.gp_status='success' AND MONTH(gp_transaction.gp_trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
			$transactions_refund_Currmonth = $db->rawQuery($MC_query);

			// Current Month Transaction Refund Amount
			$transactions_refund_Currmonth_new = number_point($transactions_refund_Currmonth[0]['refundamount']/100);
			$CurrMonthTrans_refund_amount = $transactions_refund_Currmonth_new!='' ? $ccode.' '.money_format('%!i', $transactions_refund_Currmonth_new) : '--';

			/**** Get the Current Year Transaction List ****/
			$Y_query="SELECT YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success'  AND YEAR(gp_transaction.gp_trans_datetime) = YEAR('$currentdate') GROUP BY year, month";
			$transactions_Curryear = $db->rawQuery($Y_query);

			$totTransamount = 0;
			$transCntval = 0;
			$transCntarr = [];
			$transAmtarr = []; 
			$i = 1;
			foreach ($transactions_Curryear as $key) {
				while($i <= $key['month']) {
					if($i == $key['month']) {
						$transCntarr[] = $key['transcount'];

						$transAmtarr[] = $key['transamount'];
						$totTransamount+= $key['transamount'];
					} else {
						$transCntarr[] = 0;

						$transAmtarr[] = 0;
						$totTransamount+= 0;
					}
					$i++; 
				}
			}
			$transCnts = implode(',', $transCntarr);
			$transCntval = array_sum($transCntarr);
			$transAmts = implode(',', $transAmtarr);

			//This week code
		    date_default_timezone_set('Asia/kolkata');
		    $first_day_of_the_week = 'Sunday';
		    $start_of_the_week     = strtotime("Last $first_day_of_the_week");
		    if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
		    {
		        $start_of_the_week = strtotime('today');
		    }
		    $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
		    $date_format =  'Y-m-d H:i:s';
		    $week_start=date($date_format, $start_of_the_week);
		    $week_end=date($date_format, $end_of_the_week);

		    /**** Get the Current Week Transaction List ****/
		    $W_query="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime<='".$week_end."' AND gp_transaction.gp_trans_datetime>='".$week_start."'";
		    $transactions_Currweek = $db->rawQuery($W_query);

			// Current Week Transaction/Sales Amount and Count
			$transactions_Currweek_new = number_point($transactions_Currweek[0]['transamount']/100);
		    $CurrWeekTransamount = $transactions_Currweek_new!='' ? $ccode.' '.money_format('%!i', $transactions_Currweek_new) : '--';
		    $CurrWeekTranscount  = $transactions_Currweek[0]['transcount']!='' ? $transactions_Currweek[0]['transcount'] : '--';

		    /**** Get the Current Week Transaction Cancel List ****/
		    $WC_query="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('3','s4') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime<='".$week_end."' AND gp_transaction.gp_trans_datetime>='".$week_start."'";
		    $transactions_cancel_Currweek = $db->rawQuery($WC_query);

		    // Current Week Transaction Cancel Amount and Count
		    $transactions_cancel_Currweek_new = number_point($transactions_cancel_Currweek[0]['transamount']/100);
		    $CurrWeekTrans_cancel_amount = $transactions_cancel_Currweek_new!='' ? $ccode.' '.money_format('%!i', $$transactions_cancel_Currweek_new) : '--';
		    $CurrWeekTrans_cancel_count  = $transactions_cancel_Currweek[0]['transcount']!='' ? $transactions_cancel_Currweek[0]['transcount'] : '--';

		    /**** Get the Current Week Transaction Refund List ****/
		    $WR_query="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount, SUM(gp_transaction.gp_amount) AS refundamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('2','s2','cb2') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime<='".$week_end."' AND gp_transaction.gp_trans_datetime>='".$week_start."'";
		    $transactions_refund_Currweek = $db->rawQuery($WR_query);

		    // Current Week Transaction Refund Amount
		    $transactions_refund_Currweek_new = number_point($transactions_refund_Currweek[0]['refundamount']/100);
		    $CurrWeekTrans_refund_amount = $transactions_refund_Currweek_new!='' ? $ccode.' '.money_format('%!i', $transactions_refund_Currweek_new) : '--';

		    $Today_start=date("Y-m-d 00:00:00");
		    $Today_end=date("Y-m-d 23:59:59");
		    /**** Get the Current Week Transaction List ****/
		    $T_query="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success'  AND gp_transaction.gp_trans_datetime<='".$Today_end."' AND gp_transaction.gp_trans_datetime>='".$Today_start."'";
		    $transactions_CurrToday = $db->rawQuery($T_query);

		    // Current Week Transaction/Sales Amount and Count
		    $transactions_CurrToday_new = number_point($transactions_CurrToday[0]['transamount']/100);
		    $CurrTodayTransamount = $transactions_CurrToday_new!='' ? $ccode.' '.money_format('%!i', $transactions_CurrToday_new) : '--';
		    $CurrTodayTranscount  = $transactions_CurrToday[0]['transcount']!='' ? $transactions_CurrToday[0]['transcount'] : '--';

		    /**** Get the Current Week Transaction Cancel List ****/
		    $TC_query="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('3','s4') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime<='".$Today_end."' AND gp_transaction.gp_trans_datetime>='".$Today_start."'";
		    $transactions_cancel_CurrToday = $db->rawQuery($TC_query);

		    // Current Week Transaction Cancel Amount and Count
		    $transactions_cancel_CurrToday_new = number_point($transactions_cancel_CurrToday[0]['transamount']/100);

		    $CurrTodayTrans_cancel_amount = $transactions_cancel_CurrToday_new!='' ? $ccode.' '.money_format('%!i', $transactions_cancel_CurrToday_new) : '--';
		    $CurrTodayTrans_cancel_count  = $transactions_cancel_CurrToday[0]['transcount']!='' ? $transactions_cancel_CurrToday[0]['transcount'] : '--';

		    /**** Get the Current Week Transaction Refund List ****/
		    $TR_query="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount, SUM(gp_transaction.gp_amount) AS refundamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('2','s2','cb2') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime<='".$Today_end."' AND gp_transaction.gp_trans_datetime>='".$Today_start."'";
		    $transactions_refund_CurrToday = $db->rawQuery($TR_query);

			// echo "<pre>";
			// print_r($transactions_refund_CurrToday); exit;

			// Current Week Transaction Refund Amount
			$transactions_refund_CurrToday = number_point($transactions_refund_CurrToday[0]['refundamount']/100); 
			$CurrTodayTrans_refund_amount = $transactions_refund_CurrToday!='' ? $ccode.' '.money_format('%!i', $transactions_refund_CurrToday) : '--';

			?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding" >
					<h3 style="padding-left: 15px; margin: 15px 0;"><?php echo ucfirst($vendorName); ?> - Transaction Activity Details <?php // echo $merchantDet['currency_code']; ?></h3>
				    <div class="col-sm-6 col-md-6 col-lg-3">
				        <div class="ibox float-e-margins">
				            <div class="ibox-title">
				                <span class="label label-success pull-right">Today</span>
				                <h5>Transactions Value</h5>
				            </div>
				            <div class="ibox-content">
				                <h1 class="no-margins">
				                	<a id="curtransamt_1" href="javascript:void(0);"><?php echo  $CurrdayTransamount; ?></a>
				                </h1>
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
				                
				                <div class="row">
								<div id="cbresultsn"></div>
					                <div class="col-xs-12 col-sm-12">
										<div class="row">
										  <div class="col-xs-7 col-sm-7 five-three">
										    <div class="row" id="month-payment">
										      <div class="col-xs-4 col-sm-4">
										      <h5 class="no-margins f-w-b">Amount</h5><small><?php echo $CurrMonthTransamount;?></small>
										      </div>
										      <div class="col-xs-4 col-sm-4">
										      <h5 class="no-margins f-w-b">Count</h5><small><?php echo $CurrMonthTranscount; ?></small>
										      </div>
										      <div class="col-xs-4 col-sm-4">
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
			                                          <h5 class="no-margins f-w-b">Amount</h5><small><?php echo $CurrWeekTransamount;  ?></small>
			                                      </div>
			                                      <div class="col-xs-4 col-sm-4">
			                                          <h5 class="no-margins f-w-b">Count</h5><small><?php echo $CurrWeekTranscount; ?></small>
			                                      </div>
			                                      <div class="col-xs-4 col-sm-4">
			                                          <h5 class="no-margins f-w-b">Sales</h5><small><?php  echo $CurrWeekTransamount;  ?></small>
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
											        <h5 class="no-margins f-w-b">Refund</h5><small><?php echo $CurrMonthTrans_refund_amount;  ?></small>
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
			                                          <small><?php echo $CurrWeekTrans_cancel_amount;  ?></small>
			                                      </div>
			                                      <div class="col-xs-6 col-sm-6">
			                                          <h5 class="no-margins f-w-b">Refund</h5><small><?php echo $CurrWeekTrans_refund_amount;  ?></small>
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
				                <h1 class="no-margins"><?php // echo $CurrMonthTranscount; ?></h1>
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
			#button1,#button2,#button3 {color: #e8edef;
			    background-color: #44b547;}
			#ToolTables_DataTables_Table_0_4.calendar-time{
				display: none !important;
			}
			</style>


			<?php // include_once('dash_grabpay_tab.php'); ?>
		</div>
		<div class="tab-pane" id="2">
			<h3>Notice the gap between the content and tab after applying a background color</h3>
			<?php // echo require_once('dash_alipay.php'); ?>
			<?php
			foreach ($vendor as $value) {
				if(in_array($value, ['alipay'])) {
					$merchantId = $merchants[$value];
					$vendorName = $value;
				}
			}
			$db->where('mer_map_id',$merchantId);
			$merchants_details = $db->getOne('merchants');
			// echo "<pre>";
			// print_r($merchants_details);
			// require_once('dash_alipay.php');

			$db->where('userid',$iid);
			$merchants_details = $db->getOne('merchants');

			$vcols1 = Array ("vendor_name","pg_merchant_id");
			$db->groupBy("vendor_name","Asc");
			$vendorDet = $db->get("vendor_config", null, $vcols1);
			foreach ($vendorDet as $key => $vname) {
				if(in_array($vname['vendor_name'], ['alipay'])) {
					$vendorName = $vname['vendor_name'];
				}
			}

			if($merchantDet['currency_code'] == 'SGD') {
				setlocale(LC_MONETARY, 'en_US');
				$ccode = '$';
			} else {
				setlocale(LC_MONETARY, 'en_US');
				$ccode = '$';
			}

			/**** Get the Current Day Transaction List ****/
			$D_query="SELECT YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('1','s1','cb1') AND transaction_alipay.result_code='SUCCESS' AND (transaction_alipay.trade_status='TRADE_SUCCESS' OR transaction_alipay.trade_status='TRADE_FINISHED') AND DATE(transaction_alipay.trans_datetime) = '$currentdate' GROUP BY year, month";
			$transactions_Currday = $db->rawQuery($D_query);

			// Current Day Transaction Amount and Count
			$CurrdayTransamount = $transactions_Currday[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_Currday[0]['transamount']) : '--';
			$CurrdayTranscount  = $transactions_Currday[0]['transcount']!='' ? $transactions_Currday[0]['transcount'] : '--';

			/**** Get the Current Month Transaction List ****/
			$M_query="SELECT YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('1','s1','cb1') AND transaction_alipay.result_code='SUCCESS' AND (transaction_alipay.trade_status='TRADE_SUCCESS' OR transaction_alipay.trade_status='TRADE_FINISHED') AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
			$transactions_Currmonth = $db->rawQuery($M_query);

			// Current Month Transaction/Sales Amount and Count
			$CurrMonthTransamount = $transactions_Currmonth[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_Currmonth[0]['transamount']) : '--';
			$CurrMonthTranscount  = $transactions_Currmonth[0]['transcount']!='' ? $transactions_Currmonth[0]['transcount'] : '--';

			/**** Get the Current Month Transaction Cancel List ****/
			$MC_query="SELECT YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('4','s4') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
			$transactions_cancel_Currmonth = $db->rawQuery($MC_query);

			// Current Month Transaction Cancel Amount and Count
			$CurrMonthTrans_cancel_amount = $transactions_cancel_Currmonth[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_cancel_Currmonth[0]['transamount']) : '--';
			$CurrMonthTrans_cancel_count  = $transactions_cancel_Currmonth[0]['transcount']!='' ? $transactions_cancel_Currmonth[0]['transcount'] : '--';

			/**** Get the Current Month Transaction Refund List ****/
			$MC_query="SELECT YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount, SUM(transaction_alipay.refund_amount) AS refundamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('2','s2','cb2') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
			$transactions_refund_Currmonth = $db->rawQuery($MC_query);

			// Current Month Transaction Refund Amount
			$CurrMonthTrans_refund_amount = $transactions_refund_Currmonth[0]['refundamount']!='' ? $ccode.' '.money_format('%!i', $transactions_refund_Currmonth[0]['refundamount']) : '--';

			/**** Get the Current Year Transaction List ****/
			$Y_query="SELECT YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('1','s1','cb1') AND transaction_alipay.result_code='SUCCESS' AND (transaction_alipay.trade_status='TRADE_SUCCESS' OR transaction_alipay.trade_status='TRADE_FINISHED') AND YEAR(transaction_alipay.trans_datetime) = YEAR('$currentdate') GROUP BY year, month";
			$transactions_Curryear = $db->rawQuery($Y_query);

			// echo "<pre>";
			// print_r($transactions_Curryear); exit;

			$totTransamount = 0;
			$transCntval = 0;
			$transCntarr = [];
			$transAmtarr = []; 
			$i = 1;
			foreach ($transactions_Curryear as $key) {
				while($i <= $key['month']) {
					if($i == $key['month']) {
						$transCntarr[] = $key['transcount'];

						$transAmtarr[] = $key['transamount'];
						$totTransamount+= $key['transamount'];
					} else {
						$transCntarr[] = 0;

						$transAmtarr[] = 0;
						$totTransamount+= 0;
					}
					$i++; 
				}
			}
			$transCnts_alipay = implode(',', $transCntarr);

			$transCntval_alipay = array_sum($transCntarr);

			$transAmts = implode(',', $transAmtarr);


			//This week code
			date_default_timezone_set('Asia/kolkata');
			$first_day_of_the_week = 'Sunday';
			$start_of_the_week     = strtotime("Last $first_day_of_the_week");
			if ( strtolower(date('l')) === strtolower($first_day_of_the_week) ) {
			    $start_of_the_week = strtotime('today');
			}
			$end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
			$date_format =  'Y-m-d H:i:s';
			$week_start=date($date_format, $start_of_the_week);
			$week_end=date($date_format, $end_of_the_week);

			/**** Get the Current Week Transaction List ****/
			$W_query="SELECT COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('1','s1','cb1') AND transaction_alipay.result_code='SUCCESS' AND (transaction_alipay.trade_status='TRADE_SUCCESS' OR transaction_alipay.trade_status='TRADE_FINISHED') AND transaction_alipay.trans_datetime<='".$week_end."' AND transaction_alipay.trans_datetime>='".$week_start."'";
			$transactions_Currweek = $db->rawQuery($W_query);

			// Current Week Transaction/Sales Amount and Count
			$CurrWeekTransamount = $transactions_Currweek[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_Currweek[0]['transamount']) : '--';
			$CurrWeekTranscount  = $transactions_Currweek[0]['transcount']!='' ? $transactions_Currweek[0]['transcount'] : '--';

			/**** Get the Current Week Transaction Cancel List ****/
			$WC_query="SELECT COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('4','s4') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trans_datetime<='".$week_end."' AND transaction_alipay.trans_datetime>='".$week_start."'";
			$transactions_cancel_Currweek = $db->rawQuery($WC_query);

			// Current Week Transaction Cancel Amount and Count
			$CurrWeekTrans_cancel_amount = $transactions_cancel_Currweek[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_cancel_Currweek[0]['transamount']) : '--';
			$CurrWeekTrans_cancel_count  = $transactions_cancel_Currweek[0]['transcount']!='' ? $transactions_cancel_Currweek[0]['transcount'] : '--';

			/**** Get the Current Week Transaction Refund List ****/
			$WR_query="SELECT COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount, SUM(transaction_alipay.refund_amount) AS refundamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('2','s2','cb2') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trans_datetime<='".$week_end."' AND transaction_alipay.trans_datetime>='".$week_start."'";
			$transactions_refund_Currweek = $db->rawQuery($WR_query);

			// Current Week Transaction Refund Amount
			$CurrWeekTrans_refund_amount = $transactions_refund_Currweek[0]['refundamount']!='' ? $ccode.' '.money_format('%!i', $transactions_refund_Currweek[0]['refundamount']) : '--';


			$Today_start=date("Y-m-d 00:00:00");
			$Today_end=date("Y-m-d 23:59:59");
			/**** Get the Current Week Transaction List ****/
			$T_query="SELECT COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('1','s1','cb1') AND transaction_alipay.result_code='SUCCESS' AND (transaction_alipay.trade_status='TRADE_SUCCESS' OR transaction_alipay.trade_status='TRADE_FINISHED') AND transaction_alipay.trans_datetime<='".$Today_end."' AND transaction_alipay.trans_datetime>='".$Today_start."'";
			$transactions_CurrToday = $db->rawQuery($T_query);

			// Current Week Transaction/Sales Amount and Count
			$CurrTodayTransamount = $transactions_CurrToday[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_CurrToday[0]['transamount']) : '--';
			$CurrTodayTranscount  = $transactions_CurrToday[0]['transcount']!='' ? $transactions_CurrToday[0]['transcount'] : '--';

			/**** Get the Current Week Transaction Cancel List ****/
			$TC_query="SELECT COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('4','s4') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trans_datetime<='".$Today_end."' AND transaction_alipay.trans_datetime>='".$Today_start."'";
			$transactions_cancel_CurrToday = $db->rawQuery($TC_query);

			// Current Week Transaction Cancel Amount and Count
			$CurrTodayTrans_cancel_amount = $transactions_cancel_CurrToday[0]['transamount']!='' ? $ccode.' '.money_format('%!i', $transactions_cancel_CurrToday[0]['transamount']) : '--';
			$CurrTodayTrans_cancel_count  = $transactions_cancel_CurrToday[0]['transcount']!='' ? $transactions_cancel_CurrToday[0]['transcount'] : '--';

			/**** Get the Current Week Transaction Refund List ****/
			$TR_query="SELECT COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount, SUM(transaction_alipay.refund_amount) AS refundamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND transaction_alipay.transaction_type IN ('2','s2','cb2') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trans_datetime<='".$Today_end."' AND transaction_alipay.trans_datetime>='".$Today_start."'";
			$transactions_refund_CurrToday = $db->rawQuery($TR_query);

			// echo "<pre>";
			// print_r($transactions_refund_CurrToday); exit;

			// Current Week Transaction Refund Amount
			$CurrTodayTrans_refund_amount = $transactions_refund_CurrToday[0]['refundamount']!='' ? $ccode.' '.money_format('%!i', $transactions_refund_CurrToday[0]['refundamount']) : '--';
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
					<h3 style="padding-left: 15px; margin: 15px 0;"><?php echo ucfirst($vendorName); ?> - Transaction Activity Details</h3>
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

				<style type="text/css">
.daterangepicker.show-calendar .drp-buttons {
	display: none !important;
}
#button1,#button_2,#button_3 {color: #e8edef;
    background-color: #44b547;}
#ToolTables_DataTables_Table_0_4.calendar-time{
	display: none !important;
}
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
						<input class="form-control" name="date2" id="date_2" type="text"  value="" autocomplete="off" >
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

			<div class="col-xs-12 col-sm-12 no-padding">
			   <input type="hidden" name="date" id="date_merchant" value="<?php echo date('d/m/Y');?>">
			   <input type="hidden" name="merchant_id" id="merchant_id_alipay" value="<?php echo $mer_map_id; ?>">
			   <input type="hidden" name="date_12" id="date_12" value="<?php echo date('m/d/Y'); ?>">
				<div class="col-xs-3 col-sm-3">
					<div class="form-group"> <!-- Date input -->
						<label class="control-label" for="date">Start Date</label>
						<input class="form-control" id="period_start_date_alipay" name="date" placeholder="MM/DD/YYY" type="text"  />
					</div>
				</div>

				<div class="col-xs-3 col-sm-3">
					<div class="form-group"> <!-- Date input -->
						<label class="control-label" for="date">End Date</label>
						<input class="form-control" id="period_End_date_alipay" name="date" placeholder="MM/DD/YYY" type="text" />
					</div>
				</div>

				<div class="col-xs-3 col-sm-3">
					<a id="exportnew_date_alipay" href="" target="_bank" style="top: 28px;position: relative;"> 
						<input type="button" name="button2" id="button_2" value="Merchant Txn Report" style="width: 100%;">
					</a>
				</div>

				<div class="col-xs-3 col-sm-3">
					<a id="exportsummary_date_alipay" href="" target="_bank" style="top: 28px;position: relative;">
						<input type="button" name="button3" id="button_3" value="Merchant Settlement report" style="width: 100%;">
					</a>
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

				<div id="reportresult_alipay" style="padding: 15px 15px 1px; background-color: #fff;"></div>

			</div>

		</div>

		<div class="clearfix"></div>

		<div class="row rlt_row" style="display: none;">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title  back-change">
						<h5>Results</h5>
						<div class="ibox-tools">
							<a id="exportlink_date" href="php/inc_transsearch_alipay.php?date=<?php echo date('m/d/Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a>
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
						<div id="cbresults_alipay"></div>
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
								echo $transCntval_alipay!= 0 ? $transCntval_alipay : 0;
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
							<canvas id="lineChart1" height="70"></canvas>
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
			</div>
			<?php // require_once('dash_alipay.php'); ?>
		</div>
	</div>
</div>

<?php

// $db->where("userid",$iid);
// $merchantDet = $db->getOne('merchants');
// // echo $merchantDet['mer_map_id'];
// $db->where("pg_merchant_id",$merchantDet['mer_map_id']);
// $VendorDet = $db->get('vendor_config');
// //echo "<pre>";
// foreach ($VendorDet as $vendor_name) {
// $vendor[]= $vendor_name['vendor_name'];
// 	//echo "<br>";
// }

function number_point($value) {
    $myAngloSaxonianNumber = number_format($value, 2, '.', ','); //Conversion of single decimal point to two decimal point ex: 5,678.9 =>5,678.90
    return $myAngloSaxonianNumber;
}

// if (in_array('grabpay',$vendor)) {
// 	require_once('dash_grabpay.php');
// }

// if (in_array('alipay',$vendor)) {
// 	require_once('dash_alipay.php');
// }

// if (!in_array('grabpay',$vendor) ||  !in_array('alipay',$vendor)){
// 	echo 'You have not merchants Alipay and Grabpay';
// }


// if (in_array('grabpay',$vendor)) {
// 	require_once('dash_grabpay.php');
// } else if (in_array('alipay',$vendor)) {
// 	require_once('dash_alipay.php');
// } else {
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

<style type="text/css">
#ToolTables_DataTables_Table_1_4 {
	display: none !important;
}
</style>

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

		<div class="row">
		<?php
		$vcols1 = Array ("vendor_name","pg_merchant_id");
		$db->groupBy("vendor_name","Asc");
		$vendorDet = $db->get("vendor_config", null, $vcols1);
		// echo "<pre>";
		// print_r($vendorDet);

		foreach ($vendorDet as $key => $vname) {
			if(in_array($vname['vendor_name'], ['alipay','grabpay'])) {
				$vendorName = $vname['vendor_name'];
				$merchantId = $vname['pg_merchant_id'];
				?>
				<div class="col-lg-6">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5><?php echo ucfirst($vendorName); ?> Merchant Accounts</h5>
						</div>

						<div class="ibox-content" id="already">
							<div class="table-responsive">
							<?php
							echo '<table class="table table-striped table-bordered table-hover dataTables-example">';
							echo '<thead>
							<tr data-level="header" class="header">
							<th>Merchant Name</th>
							<th>Customer Service <br> Email / Phone</th>
							<th>Status</th>
							</tr>
							</thead>
							<tbody>';

							$mcols1 = Array ("vendor_name","pg_merchant_id");
							$db->where("vendor_name",$vendorName);
							$vendorDetM = $db->get("vendor_config", null, $mcols1);

							// echo "<pre>";
							// print_r($vendorDetM);

							foreach ($vendorDetM as $key => $val) {
								
								$tcols1 = Array ("merchant_name", "idmerchants", "csphone", "csemail", "is_active","mer_map_id");
								$db->where("is_active","1");
								$db->where("mer_map_id",$val['pg_merchant_id']);
								$db->orderBy("merchant_name","Asc");
								$results = $db->get("merchants", null, $tcols1);
								$arr_t = array();
								foreach($results as $row) {
									$arr_t[] 	= array(
									"Name" 	=> $row["merchant_name"],
									"Mid" 	=> $row["idmerchants"],
									"Email" => $row["csemail"],
									"Phone" => $row["csphone"],
									"Active"=> $row["is_active"],
									"Level" => $level,
									"mer_map_id"=>$row['mer_map_id']
									);
								}

								$i = 0;
								foreach($arr_t as $item) {
									$i++;
									$cclass = (empty($item['Children']) && empty($item['Merchants']))?'class="no-children"':'';

									$active = $item['Active'] == 1 ? "Active":"In-Active";

									$merchant_Name = $item['Name'];

									echo   '<tr class="gradeX">
									         <data-level="1" id="level_1_'.$item['Mid'].'" '.$cclass.'>
											<td><i class="fa fa-male"></i> <a href="viewagent.php?merchantid='.strip_tags($item['Mid']).'">'.$merchant_Name.'</td>

											<td class="data">'.strip_tags($item['Email']).' / '.strip_tags($item['Phone']).'</td>
											<td class="data">'.strip_tags($active).'</td>
											</tr>';
								}

							}
							echo '</tbody></table>';
							?>
							</div>
						</div>

					</div>
				</div>
				<?php
			}
		}
		?>
		</div>

		<div class="ibox float-e-margins" style="display: none;">

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

					$i = 0;
					
					foreach($arr as $item){

						$i++;
						
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

            $("#period_start_date,#period_End_date").on("change", function () {
					var period_start_date = $('#period_start_date').val();
				    var period_end_date = $('#period_End_date').val();
				    var mer_id  = $('#merchant_id').val();
				    //alert(mer_id);
				    //alert(myDate);

				    // var url = '/excelnew.php?merchant_id='+mer_id'&date'+myDate;
				$("#exportnew_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/Transaction_Details.php?merchant_id="+mer_id+"&period_start_date="+period_start_date+"&period_end_date="+period_end_date);
	
				});


        $("#button3").on("click", function () {
				 //    var myDate = $('#merchant_date').val();
					// var period_start_date = myDate.slice(0, 10);
				 //    var period_end_date = myDate.slice(12, 25);
				 //    if(myDate!='') {
				 //            $('.rlt_row').show();
				 //    }

				 	var period_start_date = $('#period_start_date').val();
				    var period_end_date = $('#period_End_date').val();

				    var mer_id  = $('#merchant_id').val();

					// var period_startdate = period_start_date.trim();
					// var period_enddate = period_end_date.trim(); 
					if (period_start_date == period_end_date) {
					   	// alert('');
					$("#exportsummary_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/merchant_summary_pdf.php?merchant_id="+mer_id+"&date="+period_start_date);
					   	return true;
					  } else {
					   	$("#exportsummary_date").attr("href","");
					   	$("#exportsummary_date").removeAttr("href");

					   	alert('Start date and End date should be same on merchants Summary Report');
					   	// e.preventDefault();
					   	//return false;
					   	// $("#exportsummary_date").attr("href","");
					   	
					 }
	
				});

  // $(document).ready(function(){


  // });


// AJAX call for autocomplete 
$(document).ready(function(){

	// var myDate = $('#date_12').val();
	// var period_start_date =myDate.trim();
 //    var period_end_date = myDate.trim();
 //    if(myDate!='') {
 //            $('.rlt_row').show();
 //    }
 // 	var period_start_date = $('#period_start_date').val();
	// var period_end_date = $('#period_End_date').val();

	// var mer_id  = $('#merchant_id').val();

	// $("#exportnew_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/Transaction_Details.php?merchant_id="+mer_id+"&period_start_date="+period_start_date+"&period_end_date="+period_end_date);

	

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