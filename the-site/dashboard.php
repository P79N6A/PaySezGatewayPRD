<?php 

require_once('header.php'); 

require_once('php/inc_agents_tree.php'); 

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

//var_dump(getTransactions($_SESSION['iid']));die();

//if user is merchant 

if( $usertype == 4 || $usertype == 5) {

$omg ='';

if(!empty($env) && $env == 0){

$omg = 'TEST MODE ENABLED';

}

?>

<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins"><center><span style="color:red"><?php echo $omg; ?></span></center>

			<div class="ibox-title">

				<h5>Daily Summary</h5>

				<div class="ibox-tools">

					<a id="exportlink" href="phpexcel/report.php?date=<?php echo date('m/d/Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a>

					<a class="collapse-link">

						<i class="fa fa-chevron-up"></i>

					</a>

					<a class="close-link">

						<i class="fa fa-times"></i>

					</a>

				</div>

			</div>

			<div class="ibox-content">

				<h3 class="pull-left"><?php echo getUserMerchantName($id); ?><br /></h3>

				<div class="pull-right">

					<label class="col-sm-3 control-label">Date &nbsp;</label>

					<div class="col-sm-7 input-group date"> 

						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>

						<input class="form-control m-b" name="date" id="date" type="text" value="<?php echo date('m/d/Y');?>" ></div>

                </div>

				<div class="clearfix"></div>

			</div>

		</div>

	</div>

</div>

<div class="clearfix"></div>

<div id="dailyreport"></div>

<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins">

			<?php echo $error ; ?>

			<div class="ibox-title">

				<h5>Yearly Transactions Chart</h5>

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

					<div>

						<span class="pull-right text-right">

						<small>Total value of transactions for the current year</small>

							<br/>

							All transactions: <?php  echo !empty($num_yearly_transactions) ? $num_yearly_transactions : 0; ?>

						</span>

						<h1 class="m-b-xs">$ <?php echo number_format((float)str_replace(',', '', (!empty($total_yearly_transactions)) ? $total_yearly_transactions : 0 ) - (float)str_replace(',', '', (!empty($total_yearly_refunds)) ? $total_yearly_refunds : 0), 2, '.', ','); ?></h1>

						<h3 class="font-bold no-margins">

							Transactions

						</h3>

						<small></small>

					</div>



				<div>

					<canvas id="lineChart" height="70"></canvas>

				</div>



				<div class="m-t-md">

					<small class="pull-right">

						<i class="fa fa-clock-o"> </i>

						<strong>Updated on <?php echo date("m-d-y"); ?></strong>

					</small>

				   <small>

					   <strong>Analysis of transactions for the current year.</strong>

				   </small>

				</div>



			</div>

		</div>

	</div>

</div>

<?php } else { ?>

<div class="row">

	<div class="col-lg-12">

		<div class="ibox float-e-margins">

			<div class="ibox-title">

				<h5>Accounts </h5>

			</div>

			<div class="ibox-content">

				<div class="table-responsive">

				<?php

					echo '<table id="table1" class="controller table table-striped">';

					echo '<thead>

							<tr data-level="header" class="header">

								<th>Agent/Merchant Name</th>

								<th>Customer Service Email</th>

								<th>Customer Service Phone</th>

								<th>Status</th>

							</tr>

						  </thead>';

					foreach($tree as $item){

					  $cclass = (empty($item['Children']) && empty($item['Merchants']))?'class="no-children"':'';

					  $active = (empty($item['Children']) && empty($item['Merchants']))?"Inactive":"Active";

					  echo '<tr data-level="1" id="level_1_'.$item['Id'].'" '.$cclass.' >

								<td><i class="fa fa-users"></i> <a href="viewagent.php?agentid='.strip_tags($item['Id']).'">'.strip_tags($item['Name']).'</td>

								<td class="data">'.strip_tags($item['Email']).'</td>

								<td class="data">'.strip_tags($item['Phone']).'</td>

								<td class="data">'.strip_tags($active).'</td>

							</tr>

							';

					  if(is_array($item['Children'])){

						   displayArr($item['Children'], 2);

					  }

					  if(is_array($item['Merchants'])){

						   displayMerchants($item['Merchants'], 2);

					  }

					}

					echo '</table>';

					?>

				</div>

			</div>

		</div>

	</div>



</div>

<?php } ?>

<?php 

}elseif($usertype == 6){

	echo 'show virtual terminal';

	ajax_redirect('/virtualterminal.php');

}else{

	echo '<a href="/login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>



<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">



<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>

$(document).ready(function(){

	$.ajax({

		method: "POST",

		url: "php/inc_dailyreport.php",

		data: { mid: <?php echo $mid; ?> }

	})

	.done(function( msg ) {

		$("#dailyreport").html(msg);

	});

	$('#date').datepicker({

			todayBtn: "linked",

			keyboardNavigation: false,

			forceParse: false,

			calendarWeeks: true,

			autoclose: true

		});

	$("#date").change(function () {

		$.ajax({

			method: "POST",

			url: "php/inc_dailyreport.php",

			data: { date: $(this).val() }

		})

		.done(function( msg ) {

			$("#dailyreport").html(msg);

			$("#exportlink").attr("href", "phpexcel/report.php?date="+$("#date").val())

		});

	});

	var table1 = $('#table1').tabelize({

		/*onRowClick : function(){

			alert('test');

		}*/

		fullRowClickable : true,

		onReady : function(){

			console.log('ready');

		},

		onBeforeRowClick :  function(){

			console.log('onBeforeRowClick');

		},

		onAfterRowClick :  function(){

			console.log('onAfterRowClick');

		},

	});

	

	//$('#table1 tr').removeClass('contracted').addClass('expanded l1-first'); 

});

</script>



<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>

<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">



<script type="text/javascript">

  $('.tree').treegrid();

</script> 



<!-- ChartJS-->

    <script src="js/plugins/chartJs/Chart.min.js"></script>

	<script type="text/javascript">

	$(function () {



    var lineData = {

        labels: ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October", "November", "December"],

        datasets: [

           {

                label: "Example dataset",

                fillColor: "rgba(26,179,148,0.5)",

                strokeColor: "rgba(26,179,148,0.7)",

                pointColor: "rgba(26,179,148,1)",

                pointStrokeColor: "#fff",

                pointHighlightFill: "#fff",

                pointHighlightStroke: "rgba(26,179,148,1)",

                data: [<?php echo $transactions_data; ?>]

            },

            {

                label: "Example dataset",

                fillColor: "rgba(255,133,0,0.5)",

                strokeColor: "rgba(255,133,0,1)",

                pointColor: "rgba(255,133,0,1)",

                pointStrokeColor: "#fff",

                pointHighlightFill: "#fff",

                pointHighlightStroke: "rgba(255,133,0,1)",

                data: [<?php echo $chargebacks_data; ?>]

            }

        ]

    };



    var lineOptions = {

        scaleShowGridLines: true,

        scaleGridLineColor: "rgba(0,0,0,.05)",

        scaleGridLineWidth: 1,

        bezierCurve: true,

        bezierCurveTension: 0.4,

        pointDot: true,

        pointDotRadius: 4,

        pointDotStrokeWidth: 1,

        pointHitDetectionRadius: 20,

        datasetStroke: true,

        datasetStrokeWidth: 2,

        datasetFill: true,

        responsive: true,

    };





    var ctx = document.getElementById("lineChart").getContext("2d");

    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

});

	</script>

    <!--script src="js/demo/chartjs-demo.js"></script-->



<?php require_once('footer.php'); ?>

