<?php
// if(isset($_POST)) {
// 	echo "<pre>";
// 	print_r($_POST);
// }


// $terminal_id=$_GET['terminal_id'];
// $amount=$_GET['amount'];
// $callback_notify_url=$_GET['callback_notify_url'];
// $currency=$_GET['currency'];
// $out_trade_no=$_GET['out_trade_no'].date('YmdHis');
// $tran_req_type=$_GET['tran_req_type'];
// $terminal_timestamp=date('YmdHis');

?>
<!-- <html>
<head>
</head>
<body> -->

<form name="testform" method="POST" action="new.php" id="formtest">
	<input type="hidden" name="terminal_id" value="E0000001">
	<input type="hidden" name="amount" value="1">
	<input type="hidden" name="callback_notify_url" value="https://123.231.14.207:8080/AliPayCallBack/CallBack">
	<input type="hidden" name="currency" value="USD">
	<input type="hidden" name="out_trade_no" value="E0000001<?php echo date('YmdHis'); ?>">
	<input type="hidden" name="out_trade_no_anthr" value="E0000001">
	<input type="hidden" name="tran_req_type" value="1">
	<!-- <input type="number" name="num" id="num" value="5"> -->
	<!-- <input type="submit" name="submit"> -->
</form>
<!-- </body>
</html> -->


<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">

	$(document).ready(function() {

		// document.getElementById("formtest").submit();
		$("#formtest").submit();
	});
	// document.getElementById("formtest").submit();
</script>