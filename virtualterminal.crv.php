<?php 
require_once( 'header.php');
//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Virtual Terminal</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li>
				<a href="dashboard.php">Virtual Terminal</a>
			</li>
			<li class="active">
				<strong>Captures, Refunds, and Voids</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
	<div class="col-lg-7">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Search for the original transaction</h5>
				<!--div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div-->
			</div>
			<div class="ibox-content">
				<form id="vt_search_form" action="#" method="post">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label>Transaction ID </label> 
								<input type="text" class="form-control" name="vt_transaction_id" id="vt_transaction_id">
							</div>
						</div>
						<div class="col-sm-6">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Month</label> 
								<select name="vt_month" id="vt_month" class="form-control">
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>
							<div class="form-group">
								<label>First Name</label> 
								<input type="text" class="form-control" name="vt_first_name" id="vt_first_name">
							</div>
							<div class="form-group">
								<label>ZIP/Postal Code</label> 
								<input type="text" class="form-control" name="vt_zip" id="vt_zip">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Year</label> 
								<input type="text" class="form-control" name="vt_year" id="vt_year">
							</div>
							<div class="form-group">
								<label>Last Name</label> 
								<input type="text" class="form-control" name="vt_last_name" id="vt_last_name">
							</div>
							<div class="form-group">
								<label>Phone</label> 
								<input type="text" class="form-control" name="vt_phone" id="vt_phone">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6"><button class="btn btn-default btn-lg btn-block cbsearch" type="button"><i class="fa fa-trash"></i> Reset</button></div>
						<div class="col-sm-6">
						<button class="btn btn-primary btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Search</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Process Capture, Refund, and Void Transactions</h5>
				<!--div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div-->
			</div>
			<div class="ibox-content">
				<form id="vt_capture_form" action="#" method="post">
					<div class="form-group">
							<label>Transaction Type</label> 
							<select name="vt_transaction_type" id="vt_transaction_type" class="form-control">
								<option selected="selected" value="capture">Capture</option>
								<option value="refund">Refund</option>
								<option value="void">Void</option>
							</select>
					</div>
					<div class="form-group">
							<label>Transaction ID <span class="text-danger">*</span><br />
							<small class="text-danger">* The transaction ID is always required for all supported transactions. The amount is required unless the transaction type is 'void'.</small></label> 
							<input type="text" class="form-control" name="vt_transaction_id" id="vt_transaction_id">
					</div>
					<div class="form-group">
						<label>Amount</label> 
						<input type="text" class="form-control" name="vt_amount" id="vt_amount">
					</div>
					<div class="row">
						<div class="col-sm-6"><button class="btn btn-default btn-lg btn-block cbsearch" type="button"><i class="fa fa-trash"></i> Reset</button></div>
						<div class="col-sm-6">
						<button class="btn btn-primary btn-lg btn-block cbsearch" type="button"><i class="fa fa-check"></i> Submit</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	
</div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?> 