<?php 
require_once('php/inc_viewagent.php');
require_once('header.php');

$iid = $_SESSION['iid'];
$agentid = '';
$merchantid ='';
if(isset($_GET['agentid'])){
	$agentid 	= $_GET['agentid'];
}
if(isset($_GET['merchantid'])){
	$merchantid = $_GET['merchantid'];
}

?>
<script>
function toggle_inputs() {
    var inputs = document.getElementsByTagName('input');
    for (var i = inputs.length, n = 0; n < i; n++) {
        inputs[n].disabled = !inputs[n].disabled;
    }
	document.getElementById('edit').innerHTML = 'submit';
	document.getElementById('edit').setAttribute('onclick','showAgent("editfee")');
}
var editagentinfo = 'editagentinfo';
var editagentstatus = 'editagentstatus';
var editfee = 'editfee';
var agentstatus = 'agentstatus';
var fee = 'fee';
var agentinfo = 'agentinfo';
function impersonate(uid) {
	if (uid == "") {
		document.getElementById("tab-content").innerHTML = showAgent('accinfo');
		return;
	} else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//document.getElementById("tab-content").innerHTML = xmlhttp.responseText;
				window.location = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/dashboard.php';
			}
		}
		xmlhttp.open("GET", "php/inc_viewagent.php?q=accinfo&iid=" + uid, true);
		xmlhttp.send();	

	}
}
function showAgent(str) {
	if (str == "") {
		document.getElementById("tab-content").innerHTML = showAgent('agentinfo');
		return;
	} else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("tab-content").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "php/inc_viewagent.php?q=" + str, true);
		xmlhttp.send();
	}
}
</script>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>View <?php if(isset($_GET['merchantid'])){ echo 'Merchant'; }else{ echo 'Agent'; } ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong><?php if(isset($_GET['merchantid'])){ echo 'Merchant'; }else{ echo 'Agent'; } ?> Details</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel blank-panel">
						<div class="panel-heading">
							<div class="panel-options">
								<ul class="nav nav-tabs">
									<?php if(isset($_POST['agentsaveinfo'])){ ?>
									<li class="active">
									<script>showAgent('agentinfo&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')</script>
										<a data-toggle="tab" href="#tab-1" onclick="showAgent('agentinfo&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="true"><?php if(isset($_GET['merchantid'])){ echo 'Merchant'; }else{ echo 'Agent'; } ?> Information</a>
									</li>
									<li class="">
									<?php }else{
									?><li class="">
									<script>showAgent('accinfo&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')</script>
										<a data-toggle="tab" href="#tab-1" onclick="showAgent('agentinfo&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="true"><?php if(isset($_GET['merchantid'])){ echo 'Merchant'; }else{ echo 'Agent'; } ?> Information</a>
									</li>
									<li class="active">
									<?php } ?>
									
										<a data-toggle="tab" href="#tab-2" onclick="showAgent('accinfo&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="false">Account Information</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-3" onclick="showAgent('processors&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="true">Processors</a>
									</li>
									<!--li class="">
										<a data-toggle="tab" href="#tab-4" onclick="showAgent('fee&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="false">Fee Schedule</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-5" onclick="showAgent('agentstatus&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="false"><?php if(isset($_GET['merchantid'])){ echo 'Merchant'; }else{ echo 'Agent'; } ?> Status</a>
									</li-->

								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="tab-content" id="tab-content"></div>	
				</div>
			</div>	

		</div>
	</div>
</div>

<div class="clearfix"></div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?>