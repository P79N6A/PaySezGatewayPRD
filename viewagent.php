<?php 
require_once('php/inc_viewagent.php');
require_once('header.php');

if(!checkPermission('A'))
include_once('forbidden.php');

$iid = $_SESSION['iid'];
$agentid = '';
$merchantid ='';
if(isset($_GET['agentid'])){
	$agentid 	= $_GET['agentid'];
}
if(isset($_GET['merchantid'])){
	$merchantid = $_GET['merchantid'];

	$db->where("idmerchants",$_GET['merchantid']);
    $dgot = $db->getOne("merchants");
    $mer_map_id = $dgot['mer_map_id'];
    $merchantname = $dgot['merchant_name'];

    $db->where('idmerchants', $_GET['merchantid']);
    $terminalGet = $db->get("terminal");
    // echo "<pre>";
    // print_r($terminalGet);
    foreach ($terminalGet as $key => $value) {
    	$terminal_id = $value['mso_terminal_id'];
    	$mso_ter_img_path = $value['mso_ter_img_path'];
    	// echo $value['mso_terminal_id'];
    	// echo "<br>";
    	if($terminal_id!='' && $mso_ter_img_path == '') {
    		text_image_create($mer_map_id, $merchantname,$terminal_id);
    	}
    }
}

function text_image_create($merchantid,$merchantname,$terminalid) {

	// Set the content-type
	header('Content-type: image/png');

	// Create the image
	$im = imagecreatetruecolor(200, 20);

	// Create some colors
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, 299, 19, $white);

	// The text to draw
	$text = substr($merchantname, 0, 15)." - ".$terminalid;
	// Replace path by your own font path
	$font = 'fonts/OpenSans-Regular.ttf';

	// Add some shadow to the text
	imagettftext($im, 10, 0, 10, 15, $grey, $font, $text);

	// Add the text
	imagettftext($im, 10, 0, 10, 15, $black, $font, $text);

	// Using imagepng() results in clearer text compared with imagejpeg()
	// imagepng($im);

	imagepng($im, 'merchTXT/text_'.$merchantid.$terminalid.'.png');

	imagedestroy($im);

	global $db;
	$ddata = array(
	   "mso_ter_img_path" => 'merchTXT/text_'.$merchantid.$terminalid.'.png'
	);
	$db->where('mso_terminal_id', $terminalid);
	$val = $db->update('terminal', $ddata);
	return TRUE;
	exit;
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
				window.location = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/testspaysez/dashboard.php';
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
		<h2>View <?php if(isset($_GET['
		'])){ echo 'Merchant'; }else{ echo 'Agent'; } ?></h2>
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
									<!-- <li class="">
										<a data-toggle="tab" href="#tab-3" onclick="showAgent('processors&agentid=<?php echo $agentid; ?>&merchantid=<?php echo $merchantid; ?>')" aria-expanded="true">Processors</a>
									</li> -->
									
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
			<style type="text/css">
			.daterangepicker.show-calendar .drp-buttons {
				display: none !important;
			}
			#button1 {color: #e8edef;
			    background-color: #44b547;}
			#loading{
			    	display:    none;
    				position:   relative;
    				z-index:    1000;
    				top:        0;
    				left:       0;
    				height:     100%;
    				width:      100%;
    				background: rgba( 255, 255, 255, .8 )  
                	no-repeat;
			    }
			</style>
			<div class="row">
				<div class="col-lg-12">
					<div class="tab-content" id="tab-content"></div>	
				</div>
			</div>
			<?php 
			// print_r($_SESSION);
			$db->where("idmerchants",$_GET['merchantid']);
			$merchant_Det = $db->get("merchants", null,"mer_map_id");
			foreach ($merchant_Det as $key => $value) {
				$merchantid=$value;
			}
			?>	
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title  back-change">
							<h5>Filters</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<form id="reports_form">
							
								<div class="row">

									<div class="col-md-4 date-sec">
										<label>Start Date and End Date *</label>
										<div class="input-group date datesummary">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input class="form-control" name="date2" id="date2" type="text"  value="" >
											<input type="hidden" name="date_1" id="date_1" value="<?php echo date('m/d/Y'); ?>">
											<input type="hidden" name="merchantid" id="merchantid" value="<?php echo $merchantid['mer_map_id']; ?>">
											<input type="hidden" name="searchtype" value="report" id="searchtype" />
										</div>
									</div>
										
									<div class="col-md-2">
										<label>Transaction Type</label>
									    <select class="form-control m-b" name="transaction_type" id="transaction_type">
											<option value="">-- Any Types-- </option>
											<option value="1">POS Sale</option>
											<option value="2">POS Refund</option>
											<option value="4">POS Cancel</option>
											<option value="s1">QR Sale</option>
											<option value="s2">QR Refund</option>
											<option value="s4">QR Cancel</option>
											<option value="cb1">CBP Sale</option>
											<option value="cb2">CBP Refund</option>
											<option value="cb3">CBP Cancel</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
									  <label>&nbsp;</label>
									  <!-- onclick="showReport('true')" -->
									  <button id="submit" class="btn btn-primary btn-lg btn-block reportsearch" type="button" id="button1"><i class="fa fa-check"></i>&nbsp;Submit</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div id="reportresults" style="padding: 15px 15px 1px; background-color: #fff;"></div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title  back-change">
							<h5>Results</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div id="loading">
  							<p><img src="img/loader4.gif"/></p>
						</div>
						<div class="ibox-content" id="cbresults">
							<div id="cbresults"></div>
						</div>
						<div class="ibox-content" id="searchresults" style="display: none">
							<div id="searchresults"></div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<!-- <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script> -->
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">
<div class="clearfix"></div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?>


<script>	
  $(document).ajaxStart(function(){
    
 }).ajaxStop(function(){
    $('#loading').hide();
 })
		function myrefresh(){
    window.location.reload();
    } 
     $(function() {
        $('input[name="date2"]').daterangepicker({
            timePicker: true,
            startDate: '<?php echo date('m/d/Y 00:00'); ?>',
            endDate: '<?php echo date('m/d/Y 23:59'); ?>',
            locale: {
                format: 'MM/DD/YYYY HH:mm'
            }
        });
        var selected_date = $('#date2').val();
        var period_start_date = selected_date.slice(0, 16);
        var period_end_date = selected_date.slice(19, 36);
        var selected_merchantid =$('#merchantid').val();
        var Trans='1';
        if(selected_date!='') {
            $('.rlt_row').show();
        }

        /**** Total Transaction Amount with count ****/
        var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1,Trans:Trans,merchantid:selected_merchantid};
        // $("#reports_form").serializeArray();
        console.log(postData);
        $.ajax({
            method: "POST",
            url: "php/inc_reportmerchant1.php",
            data: postData
        })
        .done(function( msg ) {
            $("#reportresults").html(msg);
        });
    });

  $(function() {
		//alert($('#date_1').val());
		var selected_date = $('#date_1').val();
		var selected_merchantid =$('#merchantid').val();


		// alert($('#date_1').val());
		if(selected_date!='') {
			$('.rlt_row').show();
		}

		$.ajax({
			method: "POST",
			url: "php/inc_reportmerchant1.php",
			data: {S_Date: selected_date,merchantid:selected_merchantid}
		})
		.done(function( msg ) {
			$("#cbresults").html(msg);

			if(msg.slice(0,21) == 'No Transactions Found') {
				$("#exportlink_date").hide();
			} else {
				$("#exportlink_date").show();
			}

			$('.dataTables-example').dataTable({
				"order": [[ 0, "asc" ]],
				responsive: true,
				"dom": 'T<"clear">lfrtip',
				"tableTools": {
					"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
				}
			});
			$('input:checkbox').change(function() { 
				if($(this).attr('id') == 'selectall') {
					jqCheckAll2( this.id);
				}
			});
			function jqCheckAll2( id ) {
				$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
			}

			$("#exportlink_date").attr("href", "php/inc_reportmerchant1.php?date="+selected_date);
		});

	});

     $("#date2").on("change", function () {
		// alert("OnChange=> "+ $(this).val());
		//var selected_date = $(this).val();
        var selected_date = $('#date2').val();
        var period_start_date = selected_date.slice(0, 16);
        var period_end_date = selected_date.slice(19, 36);
        var selected_merchantid =$('#merchantid').val();
        //var trans_type = $("#transaction_type").val();
        var trans_type = $("#transaction_type").val()=='' ? "0" :$("#transaction_type").val();
        var Trans='1';
		if(selected_date!='') {
			$('.rlt_row').show();
		}

		/**** Total Transaction Amount with count ****/
        var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:trans_type, from_dash: 1,Trans:Trans,merchantid:selected_merchantid};
        // $("#reports_form").serializeArray();
        console.log(postData);
        $.ajax({
            method: "POST",
            url: "php/inc_reportmerchant1.php",
            data: postData
        })
        .done(function( msg ) {
            $("#reportresults").html(msg);
        });
     })
        // END
     /** Datepicker Click on Transaction History ***/
     $(document).ready(function(){
        $("#submit").click(function(){
        	$('#cbresults').hide();
        	$('#loading').show();
        	$('#searchresults').hide();
        var selected_date = $('#date2').val();
        var period_start_date = selected_date.slice(0, 16);
        var period_end_date = selected_date.slice(19, 36);
        if(selected_date!='') {
            $('.rlt_row').show();
        }
        var trans_type = $("#transaction_type").val();
        // alert(trans_type);
        var searchtype = $("#searchtype").val();
        /**** Total Transaction Amount with count ****/
        //var postData = {date2:selected_date, trans_type:trans_type,searchtype:searchtype}
        var postData = $("#reports_form").serializeArray();
        //alert(postData);
        console.log(postData);
            $.ajax({
                type: 'POST',
                url: 'php/inc_reportmerchant1.php',
                data:postData
                })
            .done(function( msg ) {

                	$('#cbresults').hide();
                	$('#searchresults').show();
					$("#searchresults").html(msg);
					$('#loading').hide();
					if(msg.slice(0,21) == 'No Transactions Found') {
                    	$("#exportlink_date").hide();
                	} else {
                    	$("#exportlink_date").show();
                	}

                	$('.dataTables-example').dataTable({
                	destroy: true,
                    "order": [[ 0, "asc" ]],
                    responsive: true,
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                    	}
                	});
                	$('input:checkbox').change(function() {
                    if($(this).attr('id') == 'selectall') {
                        jqCheckAll2( this.id);
                    	}
                	});
                	function jqCheckAll2( id ) {
                    	$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
                	}
	     		});
	});
});
</script>