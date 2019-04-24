<?php
require_once('header.php');
include 'php/inc_apicreditations.php';
if(isset($_SESSION['iid'])){
	$iid = $_SESSION['iid'];
}
ini_set('memory_limit', '-1');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>API</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>API</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-7">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>API Creditations</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-striped table-bordered table-hover dataTables-processors">
						<thead>
							<tr>
								<th>ID</th>
								<th>Environment</th>
								<th>Processor</th>
								<th>Gateway</th>
								<th>API Key</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($apis as $api)
							{ 
							$env = ($api["environment"] == 0 ? 'Test' : 'Live');?>
								<tr class="gradeX">
									<td><?php echo $api["id"]; ?></td>
									<td>
										<select name="env" id="env" class="form-control m-b chosen-select" tabindex="2">
											<option <?php if($env == 'Test'){echo selected;} ?>  value="0">Test</option>
											<option <?php if($env == 'Live'){echo selected;} ?>  value="1">Live</option>
										</select>
									</td>
									<td><?php echo $api["processor_name"]; ?></td>
									<td><?php echo $api["gateway_name"]; ?></td>
									<td><textarea class="form-control" readonly rows="3" col="30"><?php echo $api["api_key"]; ?></textarea></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>API Documentation</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">

				<h4><a href="api/API-MerchantManual(Version 1.0).pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> API-MerchantManual(Version 1.0).pdf</a></h4>
				<br /><br />
				<h4>Examples</h4>				
				<div class="panel-body">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h5 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">PHP Example</a>
									</h5>
								</div>
								<div id="collapseOne" class="panel-collapse collapse">
									<div class="panel-body">
										Coming soon
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">ASP.NET Eaxmple</a>
									</h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
									<div class="panel-body">
										Coming soon
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Python Example</a>
									</h4>
								</div>
								<div id="collapseThree" class="panel-collapse collapse">
									<div class="panel-body">
										Coming soon
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){					
		$("#env").change(function () {
			if($(this).val()){
				$.ajax({
					method: "POST",
					url: "php/inc_changemerchantenv.php",
					data: { m_id: <?php echo $mid; ?>, env_v: $(this).val() }
				})
			}
		});	
});
</script>
<?php
require_once('footerjs.php');
require_once('footer.php');
?>