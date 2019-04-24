<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	
	<title>Pre_Auth</title>
</head>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="css/style.css">

<body>

<?php date_default_timezone_set('Asia/Kolkata'); ?>
	<div class="header">
		<div class="container black">
			<div class="qrcode">
				<div class="littlecode">
					<img width="16px" src="img/little_qrcode.jpg" id="licode">
					<div class="showqrs" id="showqrs">
						<div class="shtoparrow"></div>
						<div class="guanzhuqr">
							<img src="img/guanzhu_qrcode.png" width="80">
							<div class="shmsg" style="margin-top:5px;">
                            pls scan to follow
							</div>
							<div class="shmsg" style="margin-bottom:5px;">
                                accept important info
							</div>
						</div>
					</div>
				</div>		
			</div>
		</div>
		<div class="container">
			<div class="nav">
				<a href="https://www.alipay.com/" class="logo"><img src="img/alipay_logo.png" height="30px"></a>
				<span class="divier"></span>
			</div>
		</div>
		<div class="container blue">
			<div class="title">Pre_Auth Voucher Create</div>
		</div>
	</div>
	<div class="content">
		<form action="alipayapi.php" class="alipayform" method="post" onsubmit="return confirm('Do you really want to submit the form?');">
			<div class="element" style="margin-top:60px;">
				<div class="legend">Pre_Auth </div>
			</div>			
			<div class="element">
				<div class="etitle">out_order_no:</div>
				<div class="einput"><input type="text" name="out_order_no" id="out_order_no"></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">out_request_no:</div>
				<div class="einput"><input type="text" name="out_request_no" id="out_request_no"></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">amount:</div>
				<div class="einput"><input type="text" name="amount" value="1.00"></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">trans_currency:</div>
				<div class="einput"><input type="text" name="trans_currency" value="USD"></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">settle_currency:</div>
				<div class="einput"><input type="text" name="settle_currency" value="USD"></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">terminal_id:</div>
				<div class="einput"><input type="text" name="terminal_id" value=""></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">tran_req_type:</div>
				<div class="einput"><input type="text" name="tran_req_type" value="PA1"></div>
				<br>
			</div>
			<div class="element">
				<div class="etitle">timestamp:</div>
				<div class="einput"><input type="text" name="timestamp" value="<?php echo date('Y-m-d H:i:s'); ?>"></div>
				<br>
			<input type="hidden" name="version" value="1.0">
			<input type="hidden" name="app_id" value="2018060601228996">
			<input type="hidden" name="method" value="alipay.fund.auth.order.voucher.create">
			<input type="hidden" name="extra_param" value="{&#34;secondaryMerchantId&#34;:&#34;MerchantDavidTest01&#34;,&#34;outStoreCode&#34;:&#34;StoreDavidTest01&#34;}">
			<input type="hidden" name="order_title" value="PreAuth Scanning Test0001">
			<input type="hidden" name="product_code" value="OVERSEAS_INSTORE_AUTH">
			<input type="hidden" name="Pre_Auth"  id="Pre_Auth" value="voucher">
			<!-- <input type="hidden" name="tran_req_type"  id="tran_req_type" value="PA1"> -->
			</div>
			<div class="element" >
				<input type="submit" class="alisubmit" value ="Voucher">
			</div>
		</form>
	</div>
</body>
<script>

	var even = document.getElementById("licode");	
	var showqrs = document.getElementById("showqrs");
	 even.onmouseover = function(){
	 	showqrs.style.display = "block"; 
	 }
	 even.onmouseleave = function(){
	 	showqrs.style.display = "none";
	 }
	 
	 var out_order_no = document.getElementById("out_order_no");

	 //Set the time formating function
	 Date.prototype.format = function (format) {
           var args = {
               "M+": this.getMonth() + 1,
               "d+": this.getDate(),
               "h+": this.getHours(),
               "m+": this.getMinutes(),
               "s+": this.getSeconds(),
           };
           if (/(y+)/.test(format))
               format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
           for (var i in args) {
               var n = args[i];
               if (new RegExp("(" + i + ")").test(format))
                   format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? n : ("00" + n).substr(("" + n).length));
           }
           return format;
       };
       
	 out_order_no.value = 'PO'+ new Date().format("yyyyMMddhhmmss");
	 out_request_no.value='PR'+ new Date().format("yyyyMMddhhmmss");

</script>
</html>