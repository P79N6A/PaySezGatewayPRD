<?php 
// $terminal_timestamp = date('YmdHis');
// $callback="https://123.231.14.207:8080/AliPayCallBack/CallBack";
require_once('php/database_config.php');

$db->where('gp_status',1);
$merchants = $db->get('merchants');

$items = array();
foreach ($merchants as  $id) {
	$items[] = $id['mer_map_id'];
}

 $url ="https://paymentgateway.test.credopay.in/testspaysez/excelnew.php?";
?>
<form  id="form1" method="POST" onsubmit="openInNewTab()">
	<input type="text" name="url" id="url" readonly value="<?php echo $url;?>">
	<input type="number" name="num" id="num" value="<?php echo $items;?>">
	<input type="submit" name="submit" >
<!--<button id="myBtn" onclick="openInNewTab('<?php echo $url;?>');">Button</button>-->
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

$('#form1').submit(function(){return true;});
function openInNewTab() {

var str1 = document.getElementById("url").value;
var str2 = document.getElementById("num").value;
var res = str1.concat(str2);
//var numbers = document.getElementById("num").value;
var url = document.getElementById("res").value;   
  window.open(url);
  // setTimeout(function(){alert(); }, 1000);
   //setTimeout("window.open(url)",2000);    
}
</script>

<!-- var randomnumber = Math.floor((Math.random()*100)+1); 
 window.open(yoururl,"_blank",'PopUp',randomnumber,'scrollbars=1,menubar=0,resizable=1,width=850,height=500');
 window.open(yoururl,"_blank",'PopUp'+ ++counter +'…') -->