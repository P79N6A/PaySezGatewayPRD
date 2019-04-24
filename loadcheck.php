<?php 
// $callback="https://123.231.14.207:8080/AliPayCallBack/CallBack";
// $url="http://payments.supremepaysez.com/testspaysez/test_load.php?terminal_id=E0000001&amount=1&callback_notify_url=".$callback."&currency=USD&out_trade_no=E0000001&tran_req_type=1";
?>



<form name="testform" method="POST" action="test_load.php" target="_blank" id="formtest">
	<input type="hidden" name="terminal_id" value="E0000001">
	<input type="hidden" name="amount" value="1">
	<input type="hidden" name="callback_notify_url" value="https://123.231.14.207:8080/AliPayCallBack/CallBack">
	<input type="hidden" name="currency" value="USD">
	<input type="hidden" name="out_trade_no" value="E0000001<?php echo date('YmdHis'); ?>">
	<input type="hidden" name="tran_req_type" value="1">
	<input type="number" name="num" id="num" value="5">
	<!-- <input type="submit" name="submit"> -->
</form>

<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	// document.getElementById("formtest").submit();
	// $("#formtest").submit();
	// var num = $("#num").val();
	// alert(num);
	for(var i=0; i < 5; i++) {  
	// sleep(10);
	// $("#formtest").submit();
	document.getElementById("formtest").submit();
	console.log(i);
	}
});
</script>

<!-- var randomnumber = Math.floor((Math.random()*100)+1); 
 window.open(yoururl,"_blank",'PopUp',randomnumber,'scrollbars=1,menubar=0,resizable=1,width=850,height=500');
 window.open(yoururl,"_blank",'PopUp'+ ++counter +'…') -->