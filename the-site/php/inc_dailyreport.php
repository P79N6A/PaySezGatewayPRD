<?php require_once('inc_dashboard.php');setlocale(LC_MONETARY, 'en_US');  ?>
<div class="row">
	<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-primary pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"Today";?></span>
					<h5>Successful Sales</h5>
				</div>
				<div class="ibox-content">
					<div class="text-navy col-lg-4 text-left"><h2># <?php echo $num_daily_transactions; ?> </h2></div>
					<h1 class="no-margins col-lg-8 text-right">$ <?php echo $total_daily_transactions." ".$currency; ?></h1>
					
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr role="row">
								<th></th>
								<th>Count</th>
								<th>Amount</th>
							</tr>
						 </thead>
						<tbody>
						  <tr>
								<td>Visa</td>
								<td class="text-right"><?php echo $visa_num_sale; ?></td>
								<td class="text-right">$ <?php echo $visa_total_sale; ?></td>	
						  </tr>
						  <tr>
								<td>MasterCard</td>
								<td class="text-right"><?php echo $mc_num_sale; ?></td>
								<td class="text-right">$ <?php echo $mc_total_sale; ?></td>	
						  </tr>
						  <tr>
								<td>Discover</td>
								<td class="text-right"><?php echo $discover_num_sale; ?></td>
								<td class="text-right">$ <?php echo $discover_total_sale; ?></td>		
						  </tr>
						  <tr>
								<td>American Express</td>
								<td class="text-right"><?php echo $amex_num_sale; ?></td>
								<td class="text-right">$ <?php echo $amex_total_sale; ?></td>		
						  </tr>
						  </tbody>
					</table>
					<div class="text-right"><a id="sales-details">More Details &raquo;</a></div>
				</div>
			</div>
		</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-warning pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"Today";?></span>
				<h5>Successful Refunds</h5>
			</div>
			<div class="ibox-content">
				<div class="text-warning col-lg-4 text-left"><h2># <?php echo $num_daily_refunds; ?> </h2></div>
				<h1 class="no-margins col-lg-8 text-right">$ (<?php echo $total_daily_refunds.") ".$currency; ?></h1>
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr role="row">
							<th></th>
							<th>Count</th>
							<th>Amount</th>
						</tr>
					 </thead>
					<tbody>
					  <tr>
							<td>Visa</td>
							<td class="text-right"><?php echo $visa_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $visa_total_refunds; ?>)</td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right"><?php echo $mc_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $mc_total_refunds; ?>)</td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right"><?php echo $discover_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $discover_total_refunds; ?>)</td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right"><?php echo $amex_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $amex_total_refunds; ?>)</td>		
					  </tr>
					  </tbody>
				</table>
				<div class="text-right"><a id="refunds-details">More Details &raquo;</a></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"Today";?></span>
				<h5>Successful Net</h5>
			</div>
			<div class="ibox-content">
				<div class="text-primary col-lg-4 text-left"><h2># <?php $net_num = ((int)$num_daily_transactions + (int)$num_daily_refunds); echo $net_num; ?> </h2></div>
				<h1 class="no-margins col-lg-8 text-right">$ <?php echo $net_total =($total_daily_transactions - $total_daily_refunds)." ".$currency; ?></h1>
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr role="row">
							<th></th>
							<th>Count</th>
							<th>Amount</th>
						</tr>
					 </thead>
					<tbody>
					  <tr>
							<td>Visa</td>
							<td class="text-right"><?php echo ((int)$visa_num_sale + (int)$visa_num_refunds); ?></td>
							<td class="text-right">$ <?php echo (money_format('%i', (int)$visa_total_sale - (int)$visa_total_refunds)); ?></td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right"><?php echo ((int)$mc_num_sale + (int)$mc_num_refunds); ?></td>
							<td class="text-right">$ <?php echo (money_format('%i', (int)$mc_total_sale - (int)$mc_total_refunds)); ?></td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right"><?php echo ((int)$discover_num_sale + (int)$discover_num_refunds); ?></td>
							<td class="text-right">$ <?php echo (money_format('%i', (int)$discover_total_sale - (int)$discover_total_refunds)); ?></td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right"><?php echo ((int)$amex_num_sale + (int)$amex_num_refunds); ?></td>
							<td class="text-right">$ <?php echo (money_format('%i', (int)$amex_total_sale - (int)$amex_total_refunds)); ?></td>		
					  </tr>
					  </tbody>
				</table>
				<div class="text-right">&nbsp;</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-danger pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"Today";?></span>
				<h5>Chargebacks</h5>
			</div>
			<div class="ibox-content">
				<div class="text-danger col-lg-4 text-left"><h2># <?php echo $num_daily_chargebacks; ?> </h2></div>
				<h1 class="no-margins col-lg-8 text-right">$ <?php echo $total_daily_chargebacks." ".$currency; ?></h1>
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr role="row">
							<th></th>
							<th>Count</th>
							<th>Amount</th>
						</tr>
					 </thead>
					<tbody>
					  <tr>
							<td>Visa</td>
							<td class="text-right"><?php echo $visa_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $visa_total_chargebacks; ?></td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right"><?php echo $mc_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $mc_total_chargebacks; ?></td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right"><?php echo $discover_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $discover_total_chargebacks; ?></td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right"><?php echo $amex_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $amex_total_chargebacks; ?></td>		
					  </tr>
					  </tbody>
				</table>
				<div class="text-right"><a id="chargebacks-details">More Details &raquo;</a></div>
			</div>
		</div>
	</div>
</div>
<div class="row" id="details">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5 id="dailyreportdetails_title"></h5>
			</div>
			<div class="ibox-content">
				<div id="dailyreportdetails"></div>
			</div>
		</div>
			</div>
</div>
<form id="sales_form">
	<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
	<input type="hidden" value="sale" name="transaction_type">
	<input type="hidden" value="-1" name="transaction_status">
	<input type="hidden" name="search_type" value="trans" />
	<input type="hidden" name="date" id="date" value="<?php echo isset($_POST['date'])?$_POST['date']:date('m/d/Y');?>" />
</form>
<form id="refunds_form">
	<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
	<input type="hidden" value="refund" name="transaction_type">
	<input type="hidden" value="-1" name="transaction_status">
	<input type="hidden" name="search_type" value="trans" />
	<input type="hidden" name="date" id="date" value="<?php echo isset($_POST['date'])?$_POST['date']:date('m/d/Y');?>" />
</form>
<form id="cb_form">
	<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
	<input type="hidden" value="0" name="dispute_result">
	<input type="hidden" value="0" name="status">
	<input type="hidden" name="date" id="date" value="<?php echo isset($_POST['date'])?$_POST['date']:date('m/d/Y');?>" />
</form>
<script src="../js/jquery-2.1.1.js"></script>
<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script>
$(document).ready(function(){
	$("#sales-details").click(function () {
		$("#dailyreportdetails_title").html("Sales Details - "+ $("#date").val());
		$('html, body').animate({
				scrollTop: $("#dailyreportdetails").offset().top
			}, 1000);				
		var postData = $("#sales_form").serializeArray();
		$.ajax({
			method: "POST",
			url: "php/inc_transsearch.php",
			data: postData
		})
		.done(function( msg ) {
			$("#dailyreportdetails").html(msg);
			$('.dataTables-example').dataTable({
				"order": [[ 1, "desc" ]],
				responsive: true,
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
		});
	});
	$("#refunds-details").click(function () {
		$("#dailyreportdetails_title").html("Refunds Details - "+ $("#date").val());
		$('html, body').animate({
				scrollTop: $("#dailyreportdetails").offset().top
			}, 1000);				
		var postData = $("#refunds_form").serializeArray();
		$.ajax({
			method: "POST",
			url: "php/inc_transsearch.php",
			data: postData
		})
		.done(function( msg ) {
			$("#dailyreportdetails").html(msg);
			$('.dataTables-example').dataTable({
				"order": [[ 1, "desc" ]],
				responsive: true,
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
		});
	});
	$("#chargebacks-details").click(function () {
		$("#dailyreportdetails_title").html("Chargebacks Details - "+ $("#date").val());
		$('html, body').animate({
				scrollTop: $("#dailyreportdetails").offset().top
			}, 1000);				
		var postData = $("#cb_form").serializeArray();
		$.ajax({
			method: "POST",
			url: "php/inc_cbsearch.php",
			data: postData
		})
		.done(function( msg ) {
			$("#dailyreportdetails").html(msg);
			$('.dataTables-example').dataTable({
				"order": [[ 1, "desc" ]],
				responsive: true,
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
		});
	});
});
</script>