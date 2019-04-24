<?php
require_once('database_config.php');



			$datetstart =$_POST['datetstartt'];
			$datetend = $_POST['datetendd'];
			$pid = $_POST['pidd'];
			$ctypes =$_POST['ctypess'];
			$currencies =$_POST['currenciess'];
			$ttype = $_POST['ttypee'];
			$recurring = $_POST['recurringg'];
			$agents = $_POST['agentss'];
			$merchants = $_POST['merchantss'];
			$mid = $_POST['midd'];
			$bin = $_POST['binn'];
			

if($datetstart=='' && $datetend=='' && $ctypes=='0' && $currencies=='0' && $ttype=='0'   && $pid=='0' && $recurring=='0' && $agents=='0' && $merchants=='0' && $mid=='0' && $bin=='0'){

	$query= "SELECT a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id";
	
	$query1="SELECT  count(*) AS cnt, c.dispute_result AS status    FROM transactions t INNER JOIN chargebacks c ON c.id_transaction_id = t.id_transaction_id  GROUP BY dispute_result";
	
	
	   
}
else if($datetstart!='' && $datetend!=''){
		$query= "SELECT a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id WHERE currency ='$currencies' AND a.action_type = '$ttype' AND server_datetime_trans>='$datetstart' AND server_datetime_trans<='$datetend'";
		
		$query1="SELECT  count(*) AS cnt, c.dispute_result AS status FROM transactions t INNER JOIN chargebacks c ON c.id_transaction_id = t.id_transaction_id  GROUP BY dispute_result";
	
}else
{
		$query= "SELECT  a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id 
          INNER JOIN merchants m ON m.idmerchants = t.merchant_id WHERE currency ='$currencies' AND a.action_type = '$ttype'";	

        $query1="SELECT  count(*) AS cnt , c.dispute_result AS status    FROM transactions t INNER JOIN chargebacks c ON c.id_transaction_id = t.id_transaction_id  GROUP BY dispute_result";	

  
}

//print_r($query);

$data = $db->rawQuery($query); 

$data1 = $db->rawQuery($query1); 

$queryy="SELECT count(*) as cont, c.reason_code, r.response_explanation FROM transactions t LEFT JOIN chargebacks c ON c.id_transaction_id =t.id_transaction_id LEFT JOIN reason_code_text r ON c.reason_code =r.code GROUP BY c.reason_code, r.response_explanation";

$dataa = $db->rawQuery($queryy); 


$volume = array();
	$salesuccess = 0;
	$salefailed = 0;
	$saletotal = 0;
	$salevisa = 0;
	$salerupay = 0;
	$salemc = 0;
	$refundsuccess = 0;
	$refundfailed = 0;
	$refundtotal = 0;
	$refundvisa = 0;
	$refundrupay = 0;
	$refundmc = 0;
	$authsuccess = 0;
	$authfailed = 0;
	$authtotal = 0;
	$motosales = 0;
	$totaltransactions = 0;
	$numsalesuccess = 0;
	$numsaletotal = 0;
	$numsalevisa = 0;
	$numsalerupay = 0;
	$numsalemc = 0;
	$numsalefailed = 0;
	$numauthfailed = 0;
	$numauthuccess = 0;
	$numrefundfailed = 0;
	$numrefundsuccess = 0;
	$numtotaltransactions = 0;
	$numrefundtotal = 0;
	$numrefundvisa = 0;
	$numrefundrupay = 0;
	$numrefundmc = 0;
	$numauthtotal = 0;
	$nummotosales = 0;



foreach($data as $index => $record){
	if($record['moto_trans'] !== 1){
		$motosales = $record['amount'] + $motosales;
		$nummotosales++;
	}
    if($record['action_type'] == 'sale'){

		if($record['condition'] =='complete'){
			
			$salesuccess = $record['amount'] + $salesuccess;
			$numsalesuccess++;
		}elseif($record['condition'] == 'failed'){
			$salefailed = $record['amount'] + $salefailed;
			$numsalefailed++;
		}
		$saletotal = $record['amount'] + $saletotal;
		
		
		//calculate visa sales
		if($record['network'] == 'Visa')
		{
			$salevisa = $record['amount'] + $salevisa;
			$numsalevisa++;
		}
		if($record['network'] == 'RUPAY')
		{
			$salerupay = $record['amount'] + $salerupay;
			$numsalerupay++;
			
			
		}
		if($record['network'] == 'MC')
		{
			$salemc = $record['amount'] + $salemc;
			$numsalemc++;
						
		}
		$numsaletotal++;
	}elseif($record['action_type'] == 'refnd'){
		if($record['success'] == 1){
			$refundsuccess = $record['amount'] + $refundsuccess;
			$numrefundsuccess++;
		}elseif($record['success'] == 0){
			$refundfailed = $record['amount'] + $refundfailed;
			$numrefundfailed++;
		}
		$refundtotal = $record['amount'] + $refundtotal;
		//calculate visa sales
		if($record['network'] == 'Visa')
		{
			$refundvisa = $record['amount'] + $refundvisa;
			$numrefundvisa++;
		}
		//rupay
		if($record['network'] == 'RUPAY')
		{
			$refundrupay = $record['amount'] + $refundrupay;
			$numrefundrupay++;
		}
		
		if($record['network'] == 'MC')
		{
			$refundmc 	= $record['amount'] + $refundmc;
			$numrefundmc++;
		}
		$numrefundtotal++;
	}elseif($record['action_type'] == 'auth'){
		if($record['success'] == 1){
			$authsuccess = $record['amount'] + $authsuccess;
			$numauthuccess++;
		}elseif($record['success'] == 0){
			$authfailed = $record['amount'] + $authfailed;
			$numauthfailed++;
		}
		$authtotal = $record['amount'] + $authtotal;
		$numauthtotal++;
	}
	$totaltransactions = $record['amount'] + $totaltransactions;
	$numtotaltransactions++;
}
/*
foreach($data1 as $index => $records){
	$cnt= $records['cnt'];
	$status= $records['status'];
}*/


 ?>
<script type="text/javascript">
 function piechart(){              
anychart.onDocumentReady(function() {
  // create pie chart with passed data
  data = anychart.data.set([
    ['MC TOTAL AMOUNT', <?php echo  $salemc; ?>, 24.2],
    ['RUPAY TOTAL AMOUNT', <?php echo  $salerupay; ?>, 334]
  ]);

  var wealth = data.mapAs({
    x: [0],
    value: [1]
  });

  chart = anychart.pie(wealth);
  chart.labels()
    .hAlign("center")
    .position('outside')
    .format("{%Value} Rs.({%PercentOfCategory}%)");

  // set chart title text settings
  chart.title('Transaction Amount');

  // set legend title text settings
  chart.legend()
    .title(false)
    // set legend position and items layout
    .position('bottom')
    .itemsLayout('horizontal')
    .align('center');

  // set container id for the chart
  chart.container('containerss');
  // initiate chart drawing
  chart.draw();
});
 }   
        </script>
	<script>
	function piechart1(){
Highcharts.chart('containerss1', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Sales by  Rebill Number'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [
            ['Rebill 1', 45.0],
            ['Rebill 2', 26.8],
            {
                name: 'Rebill 3',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Rebill 4', 8.5],
            ['Rebill 5', 6.2],
            ['Rebill 6', 0.7]
        ]
    }]
});
	}
</script>
	<script>
	function piechart2(){
Highcharts.chart('containerss2', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Sales by Card Brand'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [
            
            ['MC', <?php echo $numsalerupay; ?>],
			{
                name: 'RUPAY',
                y: <?php echo $numsalemc; ?>,
                sliced: true,
                selected: true
            }
			
            
           
        ]
    }]
});
	}
</script>
	<script>
	function piechart3(){
Highcharts.chart('containerss3', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Declines by Rebill'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [
            ['Rebill 1', <?php echo '45.0'; ?>],
            ['Rebill 2', <?php echo '26.8'; ?>],
            {
                name: 'Rebill 3',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Rebill 4', 8.5],
            ['Rebill 5', 6.2],
            ['Rebill 6', 0.7]
        ]
    }]
});
	}
</script>
<script>
	function piechart4(){
Highcharts.chart('containerss4', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Sales by BIN'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [
            ['Visa', 45.0],
            ['MC', 26.8],
            {
                name: 'RUPAY',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['AMEX', 8.5],
            ['Discover', 6.2],
            ['Chine Union Pay', 0.7]
        ]
    }]
});
	}
</script>
 <script type="text/javascript">
 function piechart5(){              
anychart.onDocumentReady(function() {
  // create pie chart with passed data
  data = anychart.data.set([
  
    <?php foreach($dataa as $records){
		$exp= $records['response_explanation'];
	   $reason_code= $records['reason_code'];
	   $cont= $records['cont'];
	   ?>
    ['<?php echo $exp; echo $cont; ?>','<?php echo $reason_code ?>',22.4],   
		 <?php   }?>
  ]);

  var wealth = data.mapAs({
    x: [0],
    value: [1]
  });

  chart = anychart.pie(wealth);
  chart.labels()
    .hAlign("center")
    .position('outside')
    .format("{%Value} trn.n({%PercentOfCategory}%)");

  // set chart title text settings
  chart.title('Decline Reasons');

  // set legend title text settings
  chart.legend()
    .title(false)
    // set legend position and items layout
    .position('bottom')
    .itemsLayout('horizontal')
    .align('center');

  // set container id for the chart
  chart.container('containerss5');
  // initiate chart drawing
  chart.draw();
});
 }   
        </script>
		<script type="text/javascript">
 function piechart6(){              
anychart.onDocumentReady(function() {
  // create pie chart with passed data
  data = anychart.data.set([
   <?php foreach($data1 as $records){
	   $cnt= $records['cnt'];
	   $status= $records['status'];
	   ?>
    ['<?php echo $status; ?>','<?php echo $cnt ?>',22.4],   
   <?php }?>
   
  ]);

  var wealth = data.mapAs({
    x: [0],
    value: [1]
  });

  chart = anychart.pie(wealth);
  chart.labels()
    .hAlign("center")
    .position('outside')
    .format("{%Value} trn.n({%PercentOfCategory}%)");

  // set chart title text settings
  chart.title('Chargeback Reasons');

  // set legend title text settings
  chart.legend()
    .title(false)
    // set legend position and items layout
    .position('bottom')
    .itemsLayout('horizontal')
    .align('center');

  // set container id for the chart
  chart.container('containerss6');
  // initiate chart drawing
  chart.draw();
});
 }   
        </script>
	<style>
	.anychart-credits-text{
		display: none;
	}
	.anychart-credits-logo{
		display: none;
	}
	.highcharts-credits{
		display: none;
	}
</style>	

 <div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">
			  
			 <div class="row">
				<div class="col-sm-4">
						<div id="containerss" style="height:270px;"></div>
                </div>
				<div class="col-sm-4">
						<div id="containerss1" style="height:270px;"></div>
                </div>
				<div class="col-sm-4">
						<div id="containerss2" style="height:270px;">
						
						
						</div>
                </div>
				</div>
				<dic class="row">
				<div class="col-sm-4">
						
                </div>
				<div class="col-sm-4">
						<div id="containerss3" style="height:270px;"></div>
                </div>
				<div class="col-sm-4">
						<div id="containerss4" style="height:270px;"></div>
                </div>
				</div>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
					<div id="containerss5" style="height:270px;"></div>
					</div>
					<div class="col-sm-2"></div>
				</div>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
					<div id="containerss6" style="height:270px;"></div>
					</div>
					<div class="col-sm-2"></div>
				</div>
		</div>
	</div>


		
	