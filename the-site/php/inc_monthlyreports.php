<?php require_once('inc_dashboard.php');  ?>
<div class="row">
	<div class="col-lg-4">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-primary pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"MTD";?></span>
				<h5>Successful Sales</h5>
			</div>
			<div class="ibox-content">
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
							<td class="text-right"><?php echo $m_visa_num_sale; ?></td>
							<td class="text-right">$ <?php echo $m_visa_total_sale; ?></td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right"><?php echo $m_mc_num_sale; ?></td>
							<td class="text-right">$ <?php echo $m_mc_total_sale; ?></td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right"><?php echo $m_discover_num_sale; ?></td>
							<td class="text-right">$ <?php echo $m_discover_total_sale; ?></td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right"><?php echo $m_amex_num_sale; ?></td>
							<td class="text-right">$ <?php echo $m_amex_total_sale; ?></td>		
					  </tr>
					  <tr class="success">
							<td><strong>Total</strong></td>
							<td class="text-right"><strong><?php echo $m_num_monthly_transactions; ?></strong></td>
							<td class="text-right">$ <strong><?php echo $m_total_monthly_transactions; ?></strong></td>		
					  </tr>
					  </tbody>
				</table>
				<div class="text-right"><a id="sales-details">More Details &raquo;</a></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-warning pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"MTD";?></span>
				<h5>Successful Refunds</h5>
			</div>
			<div class="ibox-content">
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
							<td class="text-right"><?php echo $m_visa_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $m_visa_total_refunds; ?>)</td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right"><?php echo $m_mc_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $m_mc_total_refunds; ?>)</td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right"><?php echo $m_discover_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $m_discover_total_refunds; ?>)</td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right"><?php echo $m_amex_num_refunds; ?></td>
							<td class="text-right">$ (<?php echo $m_amex_total_refunds; ?>)</td>		
					  </tr>
					  <tr class="warning">
							<td><strong>Total</strong></td>
							<td class="text-right"><strong><?php echo $m_num_monthly_refunds; ?></strong></td>
							<td class="text-right"><strong>$ (<?php echo $m_total_monthly_refunds; ?>)</strong></td>		
					  </tr>
					  </tbody>
				</table>
				<div class="text-right"><a id="refunds-details">More Details &raquo;</a></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label  pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"MTD";?></span>
				<h5>Successful Net</h5>
			</div>
			<div class="ibox-content">
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
						<td class="text-right"><?php echo ($m_visa_num_sale + $m_visa_num_refunds); ?></td>
						<td class="text-right">$ <?php echo number_format((float)str_replace(',', '', $m_visa_total_sale) - (float)str_replace(',', '', $m_visa_total_refunds), 2, '.', ','); ?></td>	
				  </tr>
				  <tr>
						<td>MasterCard</td>
						<td class="text-right"><?php echo ($m_mc_num_sale + $m_mc_num_refunds); ?></td>
						<td class="text-right">$ <?php echo number_format((float)str_replace(',', '', $m_mc_total_sale) - (float)str_replace(',', '', $m_mc_total_refunds), 2, '.', ','); ?></td>	
				  </tr>
				  <tr>
						<td>Discover</td>
						<td class="text-right"><?php echo ($m_discover_num_sale + $m_discover_num_refunds); ?></td>
						<td class="text-right">$ <?php echo number_format((float)str_replace(',', '', $m_discover_total_sale) - (float)str_replace(',', '', $m_discover_total_refunds), 2, '.', ','); ?></td>		
				  </tr>
				  <tr>
						<td>American Express</td>
						<td class="text-right"><?php echo ($m_amex_num_sale + $m_amex_num_refunds); ?></td>
						<td class="text-right">$ <?php echo number_format((float)str_replace(',', '', $m_amex_total_sale) - (float)str_replace(',', '', $m_amex_total_refunds), 2, '.', ','); ?></td>		
				  </tr>
				  <tr>
						<td>Total</td>
						<td class="text-right"><?php echo ($m_num_monthly_transactions + $m_num_monthly_refunds); ?></td>
						<td class="text-right">$ <?php echo number_format((float)str_replace(',', '', $m_total_monthly_transactions) - (float)str_replace(',', '', $m_total_monthly_refunds), 2, '.', ','); ?></td>		
				  </tr>
				  </tbody></table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-5">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-danger pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"MTD";?></span>
				<h5>Chargebacks</h5>
			</div>
			<div class="ibox-content">
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
							<td class="text-right"><?php echo $m_visa_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $m_visa_total_chargebacks; ?></td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right"><?php echo $m_mc_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $m_mc_total_chargebacks; ?></td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right"><?php echo $m_discover_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $m_discover_total_chargebacks; ?></td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right"><?php echo $m_amex_num_chargebacks; ?></td>
							<td class="text-right">$ <?php echo $m_amex_total_chargebacks; ?></td>		
					  </tr>
					  <tr class="danger">
							<td><strong>Total</strong></td>
							<td class="text-right"><strong><?php echo $m_num_monthly_chargebacks; ?></strong></td>
							<td class="text-right"><strong>$ <?php echo $m_total_monthly_chargebacks; ?></strong></td>		
					  </tr>
					  </tbody>
				</table>
				<div class="text-right"><a id="chargebacks-details">More Details &raquo;</a></div>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-info pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"MTD";?></span>
				<h5>Fees</h5>
			</div>
			<div class="ibox-content">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr role="row">
							<th></th>
							<th>Amount</th>
						</tr>
					 </thead>
					<tbody>
					  <tr>
							<td>Visa</td>
							<td class="text-right">$ <?php echo number_format($visa_fee, 2); ?></td>	
					  </tr>
					  <tr>
							<td>MasterCard</td>
							<td class="text-right">$ <?php echo number_format($mc_fee,2); ?></td>	
					  </tr>
					  <tr>
							<td>Discover</td>
							<td class="text-right">$ <?php echo number_format($discover_fee,2); ?></td>		
					  </tr>
					  <tr>
							<td>American Express</td>
							<td class="text-right">$ <?php echo number_format($amex_fee,2); ?></td>		
					  </tr>
					  <tr class="info">
							<td><strong>Total</strong></td>
							<td class="text-right"><strong>$ <?php echo number_format(($visa_fee + $mc_fee + $discover_fee + $amex_fee), 2); ?></strong></td>		
					  </tr>
					  </tbody>
				</table>
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
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<span class="label label-info pull-right"><?php echo isset($_POST['date'])?$_POST['date']:"MTD";?></span>
				<h5>Other Fees</h5>
			</div>
			<div class="ibox-content">
				<?php echo $other_fees; ?>
			</div>
		</div>
	</div>
</div>
<form id="sales_form">
	<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
	<input type="hidden" value="sale" name="transaction_type">
	<input type="hidden" value="-1" name="transaction_status">
	<input type="hidden" name="search_type" value="trans" />
	<input type="hidden" name="m_date" id="m_date" value="<?php echo (isset($_POST['month']) || isset($_POST['year']))?($_POST['month']."/1/".$_POST['year']):date('m/d/Y');?>" />
</form>
<form id="refunds_form">
	<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
	<input type="hidden" value="refund" name="transaction_type">
	<input type="hidden" value="-1" name="transaction_status">
	<input type="hidden" name="search_type" value="trans" />
	<input type="hidden" name="m_date" id="m_date" value="<?php echo isset($_POST['date'])?$_POST['date']:date('m/d/Y');?>" />
</form>
<form id="cb_form">
	<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
	<input type="hidden" value="0" name="dispute_result">
	<input type="hidden" value="0" name="status">
	<input type="hidden" name="m_date" id="m_date" value="<?php echo isset($_POST['date'])?$_POST['date']:date('m/d/Y');?>" />
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
		$("#dailyreportdetails_title").html("Sales Details - "+ $("#month").val() + "/" + $("#year").val());
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
		$("#dailyreportdetails_title").html("Refunds Details - "+ $("#month").val() + "/" + $("#year").val());
		$('html, body').animate({
				scrollTop: $("#dailyreportdetails").offset().top
			}, 1000);				
		var postData = $("#refunds_form").serializeArray();
		var date = $('#date').val();
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
		$("#dailyreportdetails_title").html("Chargebacks Details - "+ $("#month").val() + "/" + $("#year").val());
		$('html, body').animate({
				scrollTop: $("#dailyreportdetails").offset().top
			}, 1000);				
		var postData = $("#cb_form").serializeArray();
		var date = $('#date').val();
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