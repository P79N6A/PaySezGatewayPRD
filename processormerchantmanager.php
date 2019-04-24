<?php 
require_once( 'header.php');
require_once('php/database_config.php');
global $db;
//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');

require_once( 'php/common_functions.php');

$MerchantsofUser = getMerchantsofAdmin();
$userdata = getUsermerchant();

$merchant_name = "admin";
$search_type = 'trans';
$search_type_text = 'Transactions';
$merchantname=getSmerchant($id);
if ($usertype == 1) {
	$VTMerchants = getVTMerchantsofAdmin();
} else {	
	if(!empty($mid) && $mid > 0) {
		$merchant_name = getUserMerchantName($id);
		$tttt = getMerchantName($id);
		$merchant_processors = getUserMerchantProcessors($mid);
		}
}

if($_POST['merchantid']!=""){
	$proc_id=$_POST['processor_id'];
	$mer_id=$_POST['merchantid'];
	foreach($proc_id as $proid){
		$dat=array(
			'userid' => $mer_id
		);
		$db->where ('idmerchants', $proid);
		$db->update ('merchants', $dat);

	}
}
	
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $search_type_text; ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong><?php echo 'Assign Merchant'; ?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<form id="cb_form" action="processormerchantmanager.php" method="POST">
<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<!--<div class="col-lg-6">
					<div class="ibox float-e-margins">
						<?php
						if(!empty($mid) && $mid > 0) {
								$merchant_processors = getUserMerchantProcessors($mid);
							?>
							<div class="ibox-title">
								<h5>Merchant</h5>
							</div>
							<div class="ibox-content">
								<h5><?php echo $merchant_name; ?></h5>
								<input type="hidden" value="<?php echo $mid; ?>" name="merchant_id">
							</div>
							<?php
						} else {
							?>
							<div class="ibox-title">
								<h5>Merchants</h5>
							</div>
							<div class="ibox-content">
								<select name="merchantid" id="merchantid" class="form-control m-b">
									<option value="0">-- All Merchants --</option>
									<?php foreach($agent_merchants as $agent_merchant){ ?>
									<option value="<?php echo $agent_merchant['idmerchants']; ?>"><?php echo $agent_merchant['merchant_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>
					</div>
				</div> --> 
				
				<div class="col-lg-4">
				<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Users</h5>
						</div>
						<div class="ibox-content">
						<?php if($usertype == 1) { ?>
							<select name="merchantid" id="merchantid" class="form-control m-b chosen-select cbsearch required" tabindex="2">
								<option value="0">-- All Users --</option>
								<?php foreach($userdata  as $merchant) { 
								
								if($merchant['username']!=='admin'){
								?>
								
								
								<option <?php if(isset($_POST['merchant_id'])){if($_POST['merchant_id'] == $merchant['idmerchants']){echo selected;}} ?>  value="<?php echo $merchant['id']; ?>"><?php echo $merchant['username']; ?></option>
								<?php } } ?>
							</select>
						<?php } else { ?>
							<h3 class="m-t-none m-b">Merchant</h3>
							<select name="merchantid" id="" class="form-control m-b chosen-select required" tabindex="2">
								<option value="0">-- All Merchant --</option>
								<?php foreach($merchantname as $merchant) { ?>
								<option <?php if(isset($_POST['merchant_id'])){if($_POST['merchant_id'] == $merchant['idmerchants']){echo selected;}} ?>  value="<?php echo $merchant['idmerchants']; ?>"><?php echo $merchant['merchant_name']; ?></option>
								<?php } ?>
							</select>
							<!--	<h5><?php echo $merchant_name; ?></h5> 
							<input type="hidden" value="<?php if(!empty($mid)) echo $mid; ?>" name="merchant_id" id="merchant_id">-->
						<?php } ?>
					</div>
					</div>
					</div>
				<div class="col-lg-4">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Merchant</h5>
						</div>
						<div class="ibox-content">
						<?php if((!empty($mid) && $mid>0 && count($merchant_processors) > 0 ) || $usertype==1) { ?>
							<div id="processoridbox">
								
							</div>
							<?php } ?>
								<!--<div class="alert alert-danger">
									You don't have any processors set up!
								</div> -->
							
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5></h5>
						</div>
						<div class="ibox-content">
							<button class="btn btn-primary btn-lg btn-block" type="submit"> Assign </button>
						</div>
					</div>
				</div>
				
			</div>
			
				
			</div>
		</div>
	</div>

</form>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>List of Assigned Merchant</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				<div id="cbresults">
					Choose User to view List merchant under the perticular user.
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once( 'footerjs.php'); ?>
<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<script>
$(document).ready(function(){					
		$('#start_date .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			dateFormat: 'yyyy-mm-dd',
			autoclose: true
		});

		$('#end_date .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,			
			dateFormat: 'yyyy-mm-dd',
			autoclose: true
		});
		
		$("#merchantid").change(function () {
			 
			if($(this).val()){
				$.ajax({
					method: "POST",
					url: "php/inc_merchant_test.php",
					data: { m_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?>  }
				})
				.done(function( msg ) {
					$("#processoridbox").html(msg);
					$("#processorid").change(function () {
						$(this).attr('selected', 'selected');
					});
				});
			} else {
				$("#cb-filter").hide();
			}
		});
		
		
		
		$(".cbsearch").change(function () {
			$( "#cbresults" ).html('Searching. Please wait...');
			$('html, body').animate({
					scrollTop: $("#cbresults").offset().top
				}, 1000);			
			$("#new_chargebacks").val(0);		
			var m_val = $("#merchantid").val();
			var p_val = $("#processorid").val();
			var postData = $("#cb_form").serializeArray();
			$.ajax({
				method: "POST",
				url: "php/inc_table_view.php",
				data: postData
			})
			.done(function( msg ) {
				$("#cbresults").html(msg);
				$('.dataTables-example').dataTable({
					"order": [[ 1, "desc" ]],
					responsive: true,
					"dom": 'T<"clear">lfrtip',
					"tableTools": {
						"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
					}
				});
				$('input:checkbox').change(function(){ 
					if($(this).attr('id') == 'selectall')	
					{
						jqCheckAll2( this.id);
					}
				});
				function jqCheckAll2( id )
				{
					$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
				}
			});
		});
		
		$(".cbsearchnew").click(function () {
		$( "#cbresults" ).html('Searching. Please wait...');	
			$("#new_chargebacks").val(1);
			var m_val = $("#merchantid").val();
			var p_val = $("#processorid").val();
			var postData = $("#cb_form").serializeArray();
			$.ajax({
				method: "POST",
				url: "php/inc_table_view.php",
				data: postData
			})
			.done(function( msg ) {
				$("#cbresults").html(msg);
				$('html, body').animate({
					scrollTop: $("#cbresults").offset().top
				}, 1000);
				$('.dataTables-example').dataTable({
					"order": [[ 1, "desc" ]],
					responsive: true,
					"dom": 'T<"clear">lfrtip',
					"tableTools": {
						"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
					}
				});
				$('input:checkbox').change(function(){ 
					if($(this).attr('id') == 'selectall')	
					{
						jqCheckAll2( this.id);
					}
				});
				function jqCheckAll2( id )
				{
					$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
				}
			});
		});
		
});
</script>
<?php require_once( 'footer.php'); ?> 