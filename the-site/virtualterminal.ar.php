<?php 
require_once( 'header.php');
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
				<strong>Authorization Recordings</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	This form should not be used except by a merchant's user.
</div>
<div class="row">
	<div class="col-lg-5">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Record Authorization</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form id="vt_capture_form">
					<div class="form-group">
						<label>First Name</label> 
						<input type="text" class="form-control" name="vt_first_name_auth" id="vt_first_name_auth">
					</div>
					<div class="form-group">
						<label>Last Name</label> 
						<input type="text" class="form-control" name="vt_last_name_auth" id="vt_last_name_auth">
					</div>
					<div class="form-group">
						<label>Phone  <span class="text-danger">**</span></label> 
						<input type="text" class="form-control" name="vt_phone_auth" id="vt_phone_auth">
					</div>
					<div class="hr-line-dashed"></div>
					<div class="row">
						<div class="col-sm-6">
							<label>Voice Authorization Phone Number</label> 
						</div>
						<div class="col-sm-6">
							<span class="text-success">###</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label>Merchant Code</label> 
						</div>
						<div class="col-sm-6">
							<span class="text-success">###</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label>Account  Code</label> 
						</div>
						<div class="col-sm-6">
							<span class="text-success">###</span>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label>Agent Password <span class="text-danger">*</span></label> 
						<input type="text" class="form-control" name="vt_agent_password_auth" id="vt_agent_password_auth">
					</div>
					<div class="form-group">
						<label>Confirmation Number <span class="text-danger">*</span></label> 
						<input type="text" class="form-control" name="vt_confirmation_number_auth" id="vt_confirmation_number_auth">
					</div>
					<div class="form-group">
						<label>Confirmation Pin <span class="text-danger">*</span></label> 
						<input type="text" class="form-control" name="vt_confirmation_pin_auth" id="vt_confirmation_pin_auth">
					</div>
					<div class="row">
						<div class="col-sm-6"><button class="btn btn-default btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Reset</button></div>
						<div class="col-sm-6">
						<button class="btn btn-primary btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Submit</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-7">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Search for the original transaction</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form id="vt_search_form">
					<div class="row">
						<div class="col-sm-6">
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
								<label>ZIP/Postal Code  <span class="text-danger">**</span></label> 
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
								<label>Phone  <span class="text-danger">**</span></label> 
								<input type="text" class="form-control" name="vt_phone" id="vt_phone">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6"><button class="btn btn-default btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Reset</button></div>
						<div class="col-sm-6">
						<button class="btn btn-primary btn-lg btn-block cbsearch" type="button"><i class="fa fa-search"></i> Submit</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	
</div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?> 