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

}

if($usertype == 1) {
?>

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Reports</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Reports </strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
<!-- Overall Transaction Report in Column Tiles 2 -->
<div class="clearfix"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title  back-change">
				<h5>Filters</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">

				<form id="reports_form">
				
					<div class="row">

						<div class="col-md-4 date-sec">
							<label>Start Date and End Date *</label>
							<div class="input-group date datesummary">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input class="form-control" name="date2" id="date2" type="text"  value="" >
								<input type="hidden" name="date_1" id="date_1" value="<?php echo date('m/d/Y'); ?>">
								<input type="hidden" name="searchtype" value="report" />
							</div>
						</div>

						<!-- <div class="col-md-2">
							<label>Start Date *</label>
							<input class="form-control m-b" name="date_timepicker_start" id="date_timepicker_start" type="text" value="" required />
						</div>
						<div class="col-md-2">
							<label>End Date *</label>
							<input class="form-control m-b" name="date_timepicker_end" id="date_timepicker_end" type="text" value="" required />
							<input type="hidden" name="searchtype" value="report" />
						</div> -->
						<div class="col-md-2">
							<label>Currencies</label>
							<select class="form-control m-b" name="currencies" id="currencies">
							<option value="">-- All Currencies --</option>
								<option value="USD">USD</option>
								<option value="LKR">LKR</option>
								<option value="SGD">SGD</option>
								<option id="inr" value="356">INR</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Transaction Type</label>
							<select class="form-control m-b" name="transaction_type" id="transaction_type">
								<option value="">-- Any Types-- </option>
								<option value="1">GP Sale</option>
								<option value="2">GP Refund</option>
								<option value="3">GP Cancel</option>
								<option value="4">GP Inquiry</option>
							</select>
						</div>

						<div class="col-md-2">
							<label>Merchants</label>
							<div id="merchantsbox">
							<select class="form-control m-b" name="merchants" id="merchants">
								<option value="">-- All Merchants --</option>
								<?php 
                                $cols = array("idmerchants", "merchant_name", "mer_map_id", "is_active");
                                $db->where("is_active",1);
                                $db->where("gp_status",1);
                                $db->orderBy("mer_map_id","asc");
                                $merchantDet = $db->get("merchants", null, $cols);
                                foreach ($merchantDet as $key => $value) {
                                	echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>'; 
                                } 
                                ?>
							</select>
							</div>
						</div>
						<?php //getOptions($_SESSION['iid']); ?>
						<div class="col-md-2" id="appenddropdown">
							<label>Terminal ID</label>
							<select class="form-control m-b" name="terminal_id" id="terminal_id">
								<option value="">-- All TID --</option>
							</select>
						</div>

					</div>
					<div class="row">
						<div class="col-md-2">
						  <label>&nbsp;</label>
						  <!-- onclick="showReport('true')" -->
						  <button class="btn btn-primary btn-lg btn-block reportsearch" type="button"><i class="fa fa-check"></i>&nbsp;Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title  back-change">
				<h5>Results</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<div id="filterresult"></div>
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
$lastmonthdate= date('Y-m-d', strtotime("-30 days"));
$currentdate_start = date('Y-m-d 00:00:00');
$currentdate_end   = date('Y-m-d 23:59:59');

/**** Get the last 30 days "Monthly recurring revenue" ****/
function get_sale_grouplastby_ccode($lastmonthdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND transaction_alipay.transaction_type IN ('1','s1') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trade_status='TRADE_SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$lastmonthdate') GROUP BY year, month, merchants.currency_code";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;	
}

/**** Get the last Month "Cancel Amount by Currency" ****/
function get_cancellast_by_ccode($ccode_last,$lastmonthdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode_last' AND transaction_alipay.transaction_type IN ('4','s4') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$lastmonthdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}

/**** Get the last Month "Refund Amount by Currency" ****/
function get_refundlast_by_ccode($ccode_last,$lastmonthdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.refund_amount) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode_last' AND transaction_alipay.transaction_type IN ('2','s2') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$lastmonthdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}


/**** Get the Current Month "Monthly Recurring Revenue" ****/
function get_sale_groupby_ccode($currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND transaction_alipay.transaction_type IN ('1','s1') AND transaction_alipay.result_code='SUCCESS' AND transaction_alipay.trade_status='TRADE_SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month, merchants.currency_code";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;	
}

/**** Get the Current Month "Cancel Amount by Currency" ****/
function get_cancel_by_ccode($ccode,$currentdate) {
	global $db;
	$M_R_query="SELECT merchants.currency_code, YEAR(transaction_alipay.trans_datetime) AS year, MONTH(transaction_alipay.trans_datetime) AS month, COUNT(DISTINCT transaction_alipay.id_transaction_id) AS transcount, SUM(transaction_alipay.total_fee) AS transamount FROM merchants JOIN transaction_alipay ON transaction_alipay.merchant_id = merchants.mer_map_id AND merchants.currency_code= '$ccode' AND transaction_alipay.transaction_type IN ('4','s4') AND transaction_alipay.result_code='SUCCESS' AND MONTH(transaction_alipay.trans_datetime) = MONTH('$currentdate') GROUP BY year, month";
	$transactionsDetails = $db->rawQuery($M_R_query);
	return $transactionsDetails;
}

/**** Get the Current Month "Refund Amount by Currency" ****/
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

$transactions_M_R = get_sale_groupby_ccode($currentdate);
foreach ($transactions_M_R as $key => $trans) {
	$ccode = $trans['currency_code'];
	if($ccode == 'USD') {
		setlocale(LC_MONETARY, 'en_US');
	} else if($ccode == 'LKR') {
		setlocale(LC_MONETARY, 'en_IN');
	}
	$ccode_part = '<small>'.$ccode.'</small>';
	$transactions_M_R_amt .= '<h1 class="no-margins">'.($trans['transamount']!='' ?number_format_short($trans['transamount'],2).' '.$ccode_part : '--').'</h1>';
	$transactions_M_R_amt1 .= ($trans['transamount']!='' ?number_format_short($trans['transamount'],2).' '.$ccode_part : '--');
	$transactions_M_R_Sale_amount = $trans['transamount'];

	$transactions_M_R_Canl_Detail = '';
	$transactions_M_R_Canl_Detail = get_cancel_by_ccode($ccode,$currentdate);
	$transactions_M_R_Canl_amount = $transactions_M_R_Canl_Detail[0]['transamount'];

	$transactions_M_R_Refd_Detail = '';
	$transactions_M_R_Refd_Detail = get_refund_by_ccode($ccode,$currentdate);
	$transactions_M_R_Refd_amount = $transactions_M_R_Refd_Detail[0]['transamount'];
	
	$transactions_M_R_Net_amount = $transactions_M_R_Sale_amount - ($transactions_M_R_Canl_amount+$transactions_M_R_Refd_amount);

	$transactions_M_R_Net_amt .= '<h1 class="no-margins">'.($transactions_M_R_Net_amount!='' ?number_format_short($transactions_M_R_Net_amount,2).' '.$ccode_part : '--').'</h1>';
	$transactions_M_R_Net_amt1 .=($transactions_M_R_Net_amount!='' ?number_format_short($transactions_M_R_Net_amount,2).' '.$ccode_part : '--');
}



$transactions_M_R_last = get_sale_grouplastby_ccode($lastmonthdate);
foreach ($transactions_M_R_last as $key => $trans_last) {	
	$ccode_last = $trans_last['currency_code'];
	if($ccode_last == 'USD') {
		setlocale(LC_MONETARY, 'en_US');
	} else if($ccode_last == 'LKR') {
		setlocale(LC_MONETARY, 'en_IN');
	}
	$ccode_part_last = '<small>'.$ccode_last.'</small>';
	$transactions_M_R_Sale_amount_lastlist.= ($trans_last['transamount']!='' ?number_format_short($trans_last['transamount'],2).' '.$ccode_part_last : '--');
     $transactions_M_R_Sale_last_amount = $trans_last['transamount'];

	$transactions_M_R_Canl_last_Detail = '';
	$transactions_M_R_Canl_last_Detail = get_cancellast_by_ccode($ccode_last,$lastmonthdate);
	$transactions_M_R_Canl_last_amount = $transactions_M_R_Canl_last_Detail[0]['transamount'];

	$transactions_M_R_Refd_last_Detail = '';
	$transactions_M_R_Refd_last_Detail = get_refundlast_by_ccode($ccode_last,$lastmonthdate);
	$transactions_M_R_Refd_last_amount = $transactions_M_R_Refd_last_Detail[0]['transamount'];
	
	$transactions_M_R_Net_last_amount = $transactions_M_R_Sale_last_amount - ($transactions_M_R_Canl_last_amount+$transactions_M_R_Refd_last_amount);
	$transactions_M_R_Net_amt_lastlist .= ($transactions_M_R_Net_last_amount!='' ?number_format_short($transactions_M_R_Net_last_amount,2).' '.$ccode_part_last : '--');
   }
/**** AMOUNT DIFFERNCE LAST MONTH ***/

/**LKR***/
 $LKR1 = substr($transactions_M_R_Sale_amount_lastlist,0,strpos($transactions_M_R_Sale_amount_lastlist,"LKR"));
 $LKR2 = substr($transactions_M_R_amt1,0,strpos($transactions_M_R_amt1,"LKR"));
 $LKR1 = preg_replace("/[^0-9\.]/",'', $LKR1);
 $LKR2 = preg_replace("/[^0-9\.]/", '', $LKR2);
// $LKR1=trim($LKR1);
 $dividelkr = $LKR1 - $LKR2;
 $percentagelkr = $dividelkr/$LKR1*100;
 $percentagelkr = (float)substr($percentagelkr, 0, 5);
 /**********/

/***USD****/
 $lkrLength=strpos($transactions_M_R_Sale_amount_lastlist,"LKR");
 $lkrLength=$lkrLength+3;
 $usdLength=strpos($transactions_M_R_Sale_amount_lastlist,"USD");
 $usdLength=$usdLength-$lkrLength;

 $USD1 = substr($transactions_M_R_Sale_amount_lastlist,$lkrLength,$usdLength);
 $USD1 = preg_replace("/[^0-9\.]/",'', $USD1);

 $lkrLength1=strpos($transactions_M_R_amt1,"LKR");
 $lkrLength1=$lkrLength1+3;
 $usdLength1=strpos($transactions_M_R_amt1,"USD");
 $usdLength1=$usdLength1-$lkrLength1;

 $USD2 = substr($transactions_M_R_amt1,$lkrLength1,$usdLength1);
 $USD2 = preg_replace("/[^0-9\.]/",'', $USD2);  
 $divideusd = $USD1 - $USD2;
 $percentageusd = $divideusd/$USD1*100;

 $percentageusd = (float)substr($percentageusd, 0, 5);

 /**********/
  
  /****Averge Percentage Sale Amount*****/

 $averge=$percentagelkr + $percentageusd/2;

 $averge = (float)substr($averge, 0, 4);

/************************************************************/

/**** NET AMOUNT LAST MONTH   ****/

/*****LKR*************/
 $LKR_net1 = substr($transactions_M_R_Net_amt_lastlist,0,strpos($transactions_M_R_Net_amt_lastlist,"LKR"));
 $LKR_net2 = substr($transactions_M_R_Net_amt1,0,strpos($transactions_M_R_Net_amt1,"LKR"));
 $LKR_net1 = preg_replace("/[^0-9\.]/",'', $LKR_net1);
 $LKR2_net2 = preg_replace("/[^0-9\.]/", '', $LKR_net2);
 
 $dividelkr_net = $LKR_net1 - $LKR2_net2;
 $percentagelkr_net = $dividelkr_net/$LKR1*100;

 $percentagelkr_net = (float)substr($percentagelkr_net, 0, 5);

/******************************/

/******USD******/
 $lkrLength_net=strpos($transactions_M_R_Net_amt_lastlist,"LKR");
 $lkrLength_net=$lkrLength_net+3;
 $usdLength_net=strpos($transactions_M_R_Net_amt_lastlist,"USD");
 $usdLength_net=$usdLength_net-$lkrLength_net;

 $USD_net1 = substr($transactions_M_R_Net_amt_lastlist,$lkrLength_net,$usdLength_net);
 $USD_net1 = preg_replace("/[^0-9\.]/",'', $USD_net1);

 $lkrLength_net1=strpos($transactions_M_R_Net_amt1,"LKR");
 $lkrLength_net1=$lkrLength_net1+3;
 $usdLength_net1=strpos($transactions_M_R_Net_amt1,"USD");
 $usdLength_net1=$usdLength_net1-$lkrLength_net1;

 $USD_net2 = substr($transactions_M_R_Net_amt1,$lkrLength_net1,$usdLength_net1);
 $USD_net2 = preg_replace("/[^0-9\.]/",'', $USD_net2);  
 $divide_net_usd = $USD_net1 - $USD_net2;
 $percentage_net_usd = $divide_net_usd/$USD_net1*100;

 $percentage_net_usd = (float)substr($percentage_net_usd, 0, 5);

 /*******************************/
 
 /*** Averge Percentage NET AMOUNT ***/
 $averge_net=$percentagelkr_net + $percentage_net_usd/2;

 $averge_net = (float)substr($averge_net, 0, 4);


/************************************************************/

?>

<?php 

}

} elseif($usertype == 6) {

	echo 'show virtual terminal';

	ajax_redirect('/virtualterminal.php');

} else {

	echo '<a href="login.php"> Please Login Again</a>';

}

		

require_once('footerjs.php'); ?>



<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">



<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>
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
</script>

<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<!-- <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script> -->
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

<script type="text/javascript">

/**** Sparkline Graph jquery ****/
$('.sparkline').sparkline('html', { enableTagOptions: true });

$('.sparkline_1').sparkline('html', { enableTagOptions: true });

// $(window).on('resize', function() {
// 	$('.sparkline').sparkline('html', { enableTagOptions: true });
// });



$(document).ready(function(){

    /**** Daily Summary Report for selecting date from picker ****/
	$(".reportsearch").click(function () {
        $( "#filterresult" ).html('Bulding the report. Please wait...');
        var postData = $("#reports_form").serializeArray();
        console.log(postData);

        $.ajax({
            method: "POST",
            url: "php/inc_reportsearch1.php",
            data: postData
        })
        .done(function( msg ) {
            $("#filterresult").html(msg);

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

        });
    });

    // $("#merchants").change(function () {
    //     if($(this).val()){
    //         $.ajax({
    //             method: "POST",
    //             url: "php/inc_reportsearch1.php",
    //             dataType: 'json',
    //             data: { m_id: $(this).val(); }
    //         })
    //         .done(function( msg ) {
    //             $("#terminal_id").html(msg);
    //         });
    //     }
    // });

	$("#merchants").change(function () {
		// alert($(this).val());
		if($(this).val()){
			$.ajax({
				type: 'POST',
				// contentType: 'application/json',
				// dataType: 'json',
				url: 'php/inc_reportsearch1.php',
				data: JSON.stringify({'m_id': $(this).val(), 'type':'getmerchant'})
			})
			.done(function( msg ) {
				console.log(msg);
				$("#terminal_id").html(msg);
			});
		} else {
			// alert("Hi");
			var msg = '<option value="">-- Terminal ID --</option>';
			$("#terminal_id").html(msg);
		}
	});

});


</script>

    <!--script src="js/demo/chartjs-demo.js"></script-->
<script>
function myrefresh(){
    window.location.reload();
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

</script>
<?php require_once('footer.php'); ?>