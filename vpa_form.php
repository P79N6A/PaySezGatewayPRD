<?php 
$path = $_SERVER['HTTP_HOST'];
$root = $_SERVER['DOCUMENT_ROOT'];
$img =  $path.$root.'/testspaysez/Logo-Img.jpg';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<h2 align="center">VPA REQUEST - TEST</h2>
<form id="vpaRequestForm">
	<center>
	<table>
	<div>
		<tr>
			<td>
				<label>TxnId</label></td>
			<td>
				<input type="text" name="txnId" value="TXN00000002016518171904"></td></tr>	
	</div>
	<div>	
	<tr>
		<td>
			<label>TxnOrigin</label></td>
		<td>
			<input type="text" name="txnOrigin" value="paysez"></td></tr>
	</div>
	<div>
	<tr>
		<td><label>MobileNumber</label></td>
		<td><input type="number" name="mobileNumber" value="8879583355"></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>FirstName</label></td>
		<td><input type="text" name="firstName" value="test"></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>LastName</label></td>
		<td><input type="text" name="lastName" value="testing"></td>
	</tr>
	</div>
	<div>	
	<tr>
		<td><label>MerchantVaddr</label></td>
		<td><input type="text" name="merchantVaddr" value="vin@icici"></td>
	</tr>
	</div>
	<div>	
	<tr>
		<td><label>MCC</label></td>
		<td><input type="text" name="mcc" value="1234"></td>
	</tr>
	</div>
	<div>	
	<tr>
		<td><label>Email</label></td>
		<td><input type="email" name="email" value="vin@gmail.com"></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>PanNo</label></td>
		<td><input type="text" name="panNo" value="PANTEST113"></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>AadhaarNo</label></td>
		<td><input type="text" name="aadhaarNo" value="656524422343"></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>AddressDetails</label></td>
		<td><input type="text" name="addressDetails" value="chennai"></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>AccountNumber</label></td>
		<td><input type="text" name="accountNumber" value="1241242343242"></td>
	</tr>
	</div>
	<div>
	<tr>
	<td><label>AccountType</label></td>
	<td><select name="accountType">
    <option value="SAVINGS" checked="checked">SAVINGS</option>
    <option value="CURRENT">CURRENT</option>
  </select></td>
	</tr>
	</div>
	<div>
	<tr>
		<td><label>IFSC</label></td>
		<td><input type="text" name="ifsc" value="ICICI92342"></td>
	</tr>
	</div>
	<div>
	<tr>
	<td><label>Req Type</label></td>
	<td><select name="reqType">
    <option value="1" checked="checked">VPA Request</option>
    <option value="2">Transaction Notification</option>
    <option value="3">Transaction History</option>
  </select></td>
	</tr>
	</div>
</table>
	<div>
		<tr>
			<td><input type="submit" name="submit" value="Submit"></td>
			<td><input type="reset" name="clear"></td>
		</tr>
	</div>
</center>
</form>

<!-- where the response will be displayed -->
<div id='response'></div>
<!--Success-->
<div id ="suc" class="alert alert-success" style="display:none">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>Success!</strong> 
 </div>
 <!-- Error-->
 <div id="err" class="alert alert-danger" style="display:none">
 	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <strong>Danger!</strong>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
<script>
$(document).ready(function(){
$('#vpaRequestForm').submit(function(){

// show that something is loading
//$('#response').html("<b>Response...</b>");

// Call ajax for pass data to other place
$.ajax({
type: 'POST',
url: 'vpa_request.php',
data: $(this).serialize() // getting filed value in serialize form
})
.done(function(data){ // if getting done then call.

// show the response
$('#response').html(data);

})
.fail(function() { // if fail then getting message
// just in case posting your form failed
//alert( "Posting failed." );
$('#err').show();

});

// to prevent refreshing the whole page page
return false;

});
});
</script>
</body>
</html>


