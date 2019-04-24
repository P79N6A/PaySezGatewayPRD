<?php 
require_once( 'header.php');

//check permission
if(!checkPermission('M'))
    include_once('forbidden.php');

require_once( 'php/common_functions.php');
$MerchantsofUser = getMerchantsofAdmin();
$userdata = getUsermerchant();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Assign / Update</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Processors</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Users</h5>
					</div>
					<div class="ibox-content">
						<select name="merchant_id" id="merchant_id" class="form-control m-b chosen-select" tabindex="2">
							<option value="0">-- Select Users --</option>
							<?php foreach($userdata as $MerchantfUser) { ?>
							<option <?php if(isset($_POST['merchant_id'])){if($_POST['merchant_id'] == $MerchantfUser['idmerchants']){echo selected;}} ?>  value="<?php echo htmlspecialchars($MerchantfUser['id']); ?>"><?php echo htmlspecialchars($MerchantfUser['username']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Merchants</h5>
					</div>
					<div class="ibox-content">
						<div id="processoridbox">
							<label>-- First Select a Users --</label>
						</div>
					</div>
				</div>
			</div>
		<!-- <div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Gateways</h5>
					</div>
					<div class="ibox-content">
						<div id="gatewaybox">
							<label>-- First Select a Merchant --</label>
						</div>
					</div>
				</div>
			</div> -->
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
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				<div id="settings"></div>
				</div>
			</div>
		</div>
	
	</div>
		
		
</div>
<?php require_once( 'footerjs.php'); ?>
  
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<!-- Chosen -->
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
<script>
$(document).ready(function(){					
		$("#merchant_id").change(function () {
			if($(this).val()){
				$.ajax({
					method: "POST",
					url: "php/inc_merchant_test.php",
					data: { m_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?> }
				})
					.done(function( msg ) {
					$("#processoridbox").html(msg);
					var config = {
					'.chosen-select'           : {},
					'.chosen-select-deselect'  : {allow_single_deselect:true},
					'.chosen-select-no-single' : {disable_search_threshold:10},
					'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
					'.chosen-select-width'     : {width:"95%"}
					}
					for (var selector in config) {
						$(selector).chosen(config[selector]);
					} 
					$("#processor_id").change(function () {
						var m_val = $("#merchant_id").val();
						if($(this).val()){
							$.ajax({
								method: "POST",
								url: "php/inc_table.php",
								data: { m_id: m_val, p_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?> }
							})
							
								.done(function( msg ) {
											$("#settings").html(msg);
										});
									}
								});
								var config = {
								'.chosen-select'           : {},
								'.chosen-select-deselect'  : {allow_single_deselect:true},
								'.chosen-select-no-single' : {disable_search_threshold:10},
								'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
								'.chosen-select-width'     : {width:"95%"}
							}
							for (var selector in config) {
								$(selector).chosen(config[selector]);
							}
							
								});
						} 
					
				});
		
		});	

			var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
</script>

<?php require_once( 'footer.php'); ?> 