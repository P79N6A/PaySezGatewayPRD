<?php  
$db->where('userid',$iid);
$merchants_details = $db->getOne('merchants');

$vcols1 = Array ("vendor_name","pg_merchant_id");
$db->groupBy("vendor_name","Asc");
$vendorDet = $db->get("vendor_config", null, $vcols1);
foreach ($vendorDet as $key => $vname) {
	if(in_array($vname['vendor_name'], ['grabpay'])) {
		$vendorName = $vname['vendor_name'];
	}
}

if($merchants_details['currency_code'] == 'SGD') {
	setlocale(LC_MONETARY, 'en_US');
	$ccode = '$';
} else {
	setlocale(LC_MONETARY, 'en_US');
	$ccode = '$';
}

// $merchants_details['mer_map_id'];

//echo number_point(5,678.9);

/**** Get the Current Day Transaction List ****/
$D_query="SELECT YEAR(gp_transaction.gp_trans_datetime) AS year, MONTH(gp_transaction.gp_trans_datetime) AS month, COUNT(DISTINCT gp_transaction.gp_transaction_id) AS transcount, SUM(gp_transaction.gp_amount) AS transamount FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success'  AND DATE(gp_transaction.gp_trans_datetime) = '$currentdate' GROUP BY year, month";
$transactions_Currday = $db->rawQuery($D_query);

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
$transCnts = implode(',', $transCntarr);

$transCntval = array_sum($transCntarr);

$transAmts = implode(',', $transAmtarr);

//echo $transAmts;

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
							        <small><?php  echo $CurrMonthTrans_cancel_amount; ?></small>
							      </div>
							      <div class="col-xs-6 col-sm-6">
							        <h5 class="no-margins f-w-b">Refund</h5><small><?php  echo $CurrMonthTrans_refund_amount;  ?></small>
							      </div>
							    </div><!-- end inner row -->

                                  <div class="row" id="today-payment1" style="display: none;">
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Cancel</h5>
                                          <small><?php echo $CurrTodayTrans_cancel_amount;   ?></small>
                                      </div>
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Refund</h5><small><?php echo $CurrTodayTrans_refund_amount; ?></small>
                                      </div>
                                  </div><!-- end inner row -->

                                  <div class="row"  id="week-payment1" style="display: none;">
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Cancel</h5>
                                          <small><?php  echo $CurrWeekTrans_cancel_amount;  ?></small>
                                      </div>
                                      <div class="col-xs-6 col-sm-6">
                                          <h5 class="no-margins f-w-b">Refund</h5><small><?php  echo $CurrWeekTrans_refund_amount;  ?></small>
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

<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins no-margins"><center><span style="color:red"><?php echo $omg; ?></span></center>

			<div class="ibox-title iboxsummary">

				<div class="col-xs-3 col-sm-3 no-padding title-sec">
					<h5>Daily Summary</h5>
				</div>
				<div class="col-xs-5 col-sm-4 date-sec" style="position: relative;">
					<input type="button" id="button1" name="button1" value="Submit" style="position: absolute;right: 56px;top: -4px;">

					<div class="input-group date datesummary" style="right: 111px;">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<!--<input class="form-control" name="date" id="date" type="text" value="<?php // echo date('m/d/Y'); ?>" >-->
						<input class="form-control" name="date2" id="date2" type="text"  value="" autocomplete="off">
						<input type="hidden" name="date_1" id="date_1" value="<?php echo date('m/d/Y'); echo date('m/d/Y',strtotime("-1 days")); ?>">
					</div>
				</div>
				<!-- <div class="col-xs-5 col-sm-4 date-sec" style="position: relative;">
					<input type="button" id="button1" name="button2" value="Submit" style="position: absolute; right: -50px; top: -4px;">

					<div class="input-group date datesummary">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input class="form-control" name="date" id="date" type="text" value="<?php  // echo date('m/d/Y'); ?>" >
						<input class="form-control" name="date2" id="date2" type="text"  value="" autocomplete="off">
						<input type="hidden" name="date_1" id="date_1" value="<?php // // echo date('m/d/Y'); // echo date('m/d/Y',strtotime("-1 days")); ?>">
					</div>
				</div> -->

				

				<!-- <button type="button" class="btn btn-default btn-sm refbtn">
					<span class="glyphicon glyphicon-refresh"></span> Refresh
				</button> -->

				<!-- <a class="btn btn-default btn-sm refbtn" href="#" onclick="callQueryapi(); myrefresh();" role="button">
					<span class="glyphicon glyphicon-refresh"></span> Refresh
				</a> -->

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
			   <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchants_details['mer_map_id']; ?>">
			   <input type="hidden" name="date_12" id="date_12" value="<?php echo date('m/d/Y'); ?>">
				<div class="col-xs-3 col-sm-3">
					<div class="form-group"> <!-- Date input -->
						<label class="control-label" for="date">Start Date</label>
						<input class="form-control" id="period_start_date" name="date" placeholder="MM/DD/YYY" type="text"  />
					</div>
				</div>

				<div class="col-xs-3 col-sm-3">
					<div class="form-group"> <!-- Date input -->
						<label class="control-label" for="date">End Date</label>
						<input class="form-control" id="period_End_date" name="date" placeholder="MM/DD/YYY" type="text" />
					</div>
				</div>

				<div class="col-xs-3 col-sm-3">
					<a id="exportnew_date" href="" target="_bank" style="top: 28px;position: relative;"> 
						<input type="button" name="button2" id="button2" value="Merchant Txn Report" style="width: 100%;">
					</a>
				</div>

				<div class="col-xs-3 col-sm-3">
					<a id="exportsummary_date" href="" target="_bank" style="top: 28px;position: relative;">
						<input type="button" name="button2" id="button3" value="Merchant Settlement report" style="width: 100%;">
					</a>
				</div>
				
			</div>

<!-- 			<div class="col-xs-12 col-sm-12 no-padding" style="display: none;">

				<div class="input-group date">
					<input type="hidden" name="date" id="date_merchant" value="<?php //echo //date('d/m/Y');?>">
					<input type="hidden" name="merchant_id" id="merchant_id" value="<?php //echo $merchants_details['mer_map_id']; ?>">

					<div>
                    <span class="input-group-addon"style="height: 34px;"><i class="fa fa-calendar"></i></span>
                    <input class="form-control" required name="date_2" id="merchant_date" type="text" style="right: -41px;top: -34px;width: 187px;"  >


                    <input type="hidden" name="date_12" id="date_12" value="<?php// echo date('m/d/Y'); ?>">
                    </div>

                   <a id="exportnew_date" href="" target="_bank"><input type="button" name="button2" id="button2" value="Settlement Report" style="left: 238px;right: 108px;top: -2px;position: absolute;"> </a>
                   <a id="exportsummary_date" href="" target="_bank"><input type="button" name="button2" id="button3" value="Settlement Summary" style="width: 139px;position: absolute;right: -189px;top: 25px;"> </a>
                </div>
            </div> -->

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

	<div class="col-lg-12">
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
			<div class="ibox-content" id="chart">
				<div>
					<span class="pull-right text-right">

						<small>Total value of transactions for the current year</small><br/>
						All transactions: 
						<?php  
						// echo !empty($num_yearly_transactions) ? $num_yearly_transactions : 0;
						echo $transCntval!= 0 ? $transCntval: 0;
						?>
					</span>

					<h1 class="m-b-xs">
						<?php echo $ccode; ?> 
						<?php
						// echo number_format((float)str_replace(',', '', (!empty($total_yearly_transactions)) ? $total_yearly_transactions : 0 ) - (float)str_replace(',', '', (!empty($total_yearly_refunds)) ? $total_yearly_refunds : 0), 2, '.', ','); 
						$totTransamount = $totTransamount/100;
						echo number_point($totTransamount);
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
		    <div class="ibox-content" id="chartnow" style="display: none;">
		    	<?php if(isset($Transaction_chart)) {?>
		    	<div>
					<span class="pull-right text-right">

						<small>Total value of transactions for the current year</small><br/>
						All transactions: 
						<?php  
						// echo !empty($num_yearly_transactions) ? $num_yearly_transactions : 0;
						echo $transCntval1!= 0 ? $transCntval1 : 0;
						?>
					</span>

					<h1 class="m-b-xs">
						<?php echo $ccode1; ?> 
						<?php
						// echo number_format((float)str_replace(',', '', (!empty($total_yearly_transactions)) ? $total_yearly_transactions : 0 ) - (float)str_replace(',', '', (!empty($total_yearly_refunds)) ? $total_yearly_refunds : 0), 2, '.', ','); 
						echo money_format('%!i', $totTransamount1);
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
		    <?php  }  ?>
		</div>

	</div>

</div>




<script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);



    var period_start_date = $('#period_start_date').val();
	var period_end_date = $('#period_End_date').val();

	var mer_id  = $('#merchant_id').val();

	$("#exportnew_date").attr("href","https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/Transaction_Details.php?merchant_id="+mer_id+"&period_start_date="+period_start_date+"&period_end_date="+period_end_date);
    })

    // $(document).ready(function(){

	// var myDate = $('#date_12').val();
	// var period_start_date =myDate.trim();
 //    var period_end_date = myDate.trim();
 //    if(myDate!='') {
 //            $('.rlt_row').show();
 //    }

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
</script