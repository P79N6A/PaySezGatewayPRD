<?php 
require_once( 'header.php');
require_once( 'php/inc_processors.php');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Processors</h2>
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
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-8">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Processors</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content" id="processorlist">
							<?php include_once("php/inc_processorstable.php");?>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5 id="edit_title">Add Processor</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							<div id="processoridbox">
							<h2 id='result'><?php echo $result; ?></h2>
								<form id="addeditprocessor" action="#" method="POST">
								<br />
									<div class="form-group">
										<label>Processor Name</label> 
										<input value="" type="text" class="form-control required" name="processor_name" id="processor_name">
									</div>
									<div class="form-group">
										<label>Processor Short Name</label> 
										<input value="" type="text" class="form-control required" name="processor_name2" id="processor_name2">
									</div>
									<div class="form-group">
										<label>Email</label> 
										<input value="" type="text" class="form-control required email" name="email" id="email">
									</div>
									<div class="form-group">
										<label>Wire Fee</label> 
										<input value="" type="text" class="form-control required" name="wire_fee" id="wire_fee">
									</div>
									<div class="form-group">
										<label>Gateway or Bank</label> 
										<select name="gateway_or_bank" id="gateway_or_bank" class="form-control m-b required">
											<option value="0">Gateway</option>
											<option value="1">Bank</option>
										</select>
									</div>
									<div class="form-group">
										<label>Time Zone</label> 
										<select name="processor_timezone" id="processor_timezone" class="form-control m-b required">
											  <option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
											  <option value="-11">(GMT -11:00) Midway Island, Samoa</option>
											  <option value="-10">(GMT -10:00) Hawaii</option>
											  <option value="-9">(GMT -9:00) Alaska</option>
											  <option value="-8">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
											  <option value="-7">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
											  <option value="-6">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
											  <option value="-5" selected>(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
											  <option value="-4">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
											  <option value="-3">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
											  <option value="-2">(GMT -2:00) Mid-Atlantic</option>
											  <option value="-1">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
											  <option value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
											  <option value="1">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
											  <option value="2">(GMT +2:00) Kaliningrad, South Africa</option>
											  <option value="3">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
											  <option value="4">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
											  <option value="5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
											  <option value="6">(GMT +6:00) Almaty, Dhaka, Colombo</option>
											  <option value="7">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
											  <option value="8">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
											  <option value="9">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
											  <option value="10">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
											  <option value="11">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
											  <option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
										</select>
									</div>
									<div class="form-group">
										<div class="checkbox i-checks"><label> <input type="checkbox"  value="" name="integrated_to_prof" id="integrated_to_prof"> <i></i> Integrated into Profitorius </label></div>
									</div>
									<br />
									<input type="hidden" name="action" value="add_processor" />
									<button class="btn btn-primary btn-lg btn-block cbsearch" type="submit"><span id="addeditprocessor"><i class="fa fa-plus"></i> Add Processor</span></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php require_once( 'footerjs.php'); ?>
<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>

<script>
	$(document).ready(function(){
		$.validator.addMethod("alphaNumericRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    	}, "Username must contain only letters, numbers, or dashes.");

		$.validator.addMethod("numericRegex", function(value, element) {
        return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/.test(value);
    	}, "field must contain only currency value.");

		$("#addeditprocessor").validate({
			rules: {
	            "processor_name": {
	                required: true,
	                alphaNumericRegex: true,
	            },

	            "processor_name2": {
	            	required: true,
	            	alphaNumericRegex: true,
	            },

				"wire_fee": {
	            	required: true,
	            	numericRegex: true,
	            }	            
	        },
	        messages: {
	            "processor_name": {
	                required: "This field is required.",
	                alphaNumericRegex: "Processor Name format not valid"
	            },

	            "processor_name2": {
	                required: "This field is required.",
	                alphaNumericRegex: "Processor Short Name format not valid"
	            },

            	"wire_fee": {
	                required: "This field is required.",
	                numericRegex: "Wire Fee format not valid"
	            }
	        }
		});

		$(".edit-processor").click(function () {
			$('#edit_title').html("Edit Processor");
				$.ajax({
					method: "POST",
					url: "php/inc_processoredit.php",
					data:  { processor_id: this.id }
				})
				.done(function( msg ) {
					$("#processoridbox").html(msg);
				});
		});
		
		$('.dataTables-processors').dataTable({
					"order": [[ 0, "desc" ]],
					responsive: true
				});
			
	});
</script>
<?php require_once( 'footer.php'); ?> 