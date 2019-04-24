<?php 
require_once('php/inc_viewagent.php');
require_once('header.php');

if(!checkPermission('A'))
include_once('forbidden.php');

$iid = $_SESSION['iid'];
$agentid = '';
$merchantid ='';

?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>View <?php if(isset($_GET['userid'])){ echo 'Users'; } else { echo 'Agent'; } ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong><?php if(isset($_GET['userid'])){ echo 'Users'; }else{ echo 'Agent'; } ?> Details</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<?php
			$db->where("id",$_GET['userid']);
			$userDet = $db->getone("users");
			$terminal_id = $userDet['terminal_id'];
			$merchant_id = $userDet['merchant_id'];
			$db->where("idmerchants",$merchant_id);
			$merchant_Det = $db->getone("merchants");
			?>	
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins" style="margin: 0 0 5px;">
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
											<input type="hidden" name="merchantid" id="merchantid" value="<?php echo $merchant_Det['mer_map_id']; ?>">
											<input type="hidden" name="terminalid" id="terminalid" value="<?php echo $terminal_id; ?>">
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
				
			</div>

			<div id="reportresults" style="padding: 15px 15px 1px; background-color: #fff;"></div>

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
    var selected_merchantid = $('#merchantid').val();
    var selected_terminalid = $('#terminalid').val();
    var Trans='1';
    if(selected_date!='') {
        $('.rlt_row').show();
    }

    /**** Total Transaction Amount with count ****/
    var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:'0', from_dash: 1,Trans:Trans,merchantid:selected_merchantid,terminalid:selected_terminalid};
    // $("#reports_form").serializeArray();
    console.log(postData);
    $.ajax({
        method: "POST",
        url: "php/inc_reporthutchmercht.php",
        data: postData
    })
    .done(function( msg ) {
        $("#reportresults").html(msg);
    });
});


$(function() {
	//alert($('#date_1').val());
	var selected_date = $('#date_1').val();
	var selected_merchantid = $('#merchantid').val();
	var selected_terminalid = $('#terminalid').val();

	// alert($('#date_1').val());
	if(selected_date!='') {
		$('.rlt_row').show();
	}

	$.ajax({
		method: "POST",
		url: "php/inc_reporthutchmercht.php",
		data: {S_Date: selected_date,merchantid:selected_merchantid,terminalid:selected_terminalid}
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
	var selected_merchantid = $('#merchantid').val();
	var selected_terminalid = $('#terminalid').val();
	//var trans_type = $("#transaction_type").val();
	var trans_type = $("#transaction_type").val()=='' ? "0" :$("#transaction_type").val();
	var Trans='1';
	if(selected_date!='') {
		$('.rlt_row').show();
	}

	/**** Total Transaction Amount with count ****/
	var postData = {start_date:period_start_date, end_date:period_end_date, currencies:'0', transaction_type:trans_type, from_dash: 1,Trans:Trans,merchantid:selected_merchantid,terminalid:selected_terminalid};
	// $("#reports_form").serializeArray();
	console.log(postData);
	$.ajax({
	    method: "POST",
	    url: "php/inc_reporthutchmercht.php",
	    data: postData
	})
	.done(function( msg ) {
	    $("#reportresults").html(msg);
	});
})

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