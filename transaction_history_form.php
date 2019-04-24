<?php 

?>

<!DOCTYPE html>
<html>
<title>details</title>
<body>
	<h2 align="center">Transaction History</h2>
<form method="post" action="https://paymentgateway.test.credopay.in/testspaysez/vpa_request.php">
	<center>
	<table>
	<div>
		<tr>
			<td><label>Ver</label></td>
			<td><input type="text" name="ver" value="1"></td>
		</tr>	
	</div>
	<div>	
		<tr>
			<td><label>V-ts</label></td>
			<td><input type="text" name="vts" value="20181212T154900+0500"></td>
		</tr>
	</div>
	<div>
		<tr>
			<td><label>MsgId</label></td>
			<td><input type="text" name="MsgId" value="MSGe552534d61d04d9887917dea95354546"></td>
		</tr>
	</div>
	<div>
		<tr>
			<td><label>Id</label></td>
			<td><input type="text" name="Id" value="TXN00000002016518171904"></td>
		</tr>
	</div>
	<div>
		<tr>
			<td><label>T-ts</label></td>
			<td><input type="text" name="tts" value="20181212T154900+0500"></td>
		</tr>
	</div>
	<div>
		<tr>
			<td><label>T-Type</label></td>
			<td><input type="text" name="ttype" value="TxnHistory"></td>
		</tr>
	</div>
	<div>	
		<tr>
			<td><label>Addr</label></td>
			<td><input type="text" name="addr" value="chennai"></td>
		</tr>
	</div>
	<div>	
		<tr>
			<td><label>Name</label></td>
			<td><input type="text" name="name" value="test"></td>
		</tr>
	</div>
	<div>	
		<tr>
			<td><label>P-Type</label></td>
			<td><input type="text" name="ptype" value="ENTITY"></td>
		</tr>
	</div>
	<div>
		<tr>
			<td><label>Code</label></td>
			<td><input type="text" name="code" value="1234"></td>
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
			<td><input type="submit" name="submit"></td>
			<td><input type="reset" name="clear"></td>
		</tr>
	</div>
</center>
</form>
</body>
</html>
