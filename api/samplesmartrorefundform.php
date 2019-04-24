<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
 <br>

<div class="container">
<div class='row'>
<h1 class="text-center">Refund Transaction</h1>
 <hr class="featurette-divider"></hr>
</div>
<div class='row'>
<form  role="form" method="post" action="smartro.php">
<h4 class="text-center">Prefilled Fields</h4>
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-12 form-group required'>
			<label class='control-label'>Transaction ID <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="TID" value=''>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>ENV <span class="text-danger">*</span></label>
			<select class='form-control' name="env">
				<option value="test" selected>test</option>
				<option value="livetest">livetest</option>
				<option value="live">live</option>
			</select>
		  </div>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>Refund Code <span class="text-danger">*</span></label>
			<select class='form-control' name="PartialCancelCode">
				<option value="0" selected>Full Refund</option>
				<option value="1">Partial Refund</option>
			</select>
		  </div>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>TransactionType <span class="text-danger">*</span></label>
			<select class='form-control'  name="TransactionType">
				<option value="AA">AA(Authorization)</option>
				<option value="AC" selected>AC(Refund)</option>
				<option value="AD">AD(Refund within Network)</option>
				<option value="AQ">AQ(Real_time Capture Request)</option>
				<option value="AS">AS(Verification Approval)</option>
				<option value="SQ">SQ(3D Secure Verification Approval)</option>
			</select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-12 form-group required'>
			<label class='control-label'>API KEY <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="apikey" value='wUPRa6YdT5HXp3N4G5lbiQC7IpleMwx9Iqhcz4XnHIwwI4mfD/RNoL01cG+sVAWekbSGE3OS0+h++wGoU6E86i9TGKrbFTx8BNH3OUwg0XjFCXbPWEJKvMee5eU3nonn|yXCgB9LcSmTbqeSCwBcI/D3CbefeHNBAVoXrB4yFhBg='>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>Currency <span class="text-danger">*</span></label>
			<select class='form-control'  name="currency">
				<option value="USD" selected>USD(US Dollar)</option>
				<option value="JPY">JPY(Japanese Yen)</option>
				<option value="EUR">EUR(Euro)</option>
				<option value="HKD">HKD(Hong Kong Dollar)</option>
				<option value="GBP">GBP(British Pound)</option>
				<option value="SGD">SGD(Singapore Dollar)</option>
				<option value="AUD">AUD(Australian Dollar)</option>
				<option value="THB">THB(Thailand Baht)</option>
				<option value="CAD">CAD(Canadian Dollar)</option>
				<option value="RUB">RUB(Russian Dollar)</option>
				<option value="CNY">CNY(Chinese Yuan)</option>
			</select>
		  </div>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>Tax <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="tax" value ='0'>
		  </div>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>Amount <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="amount" value='0'>
		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<hr class="featurette-divider"></hr>
<div class='row'>
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-12 form-group'>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<br /><br />
</form>
</div>
</body>
</html>