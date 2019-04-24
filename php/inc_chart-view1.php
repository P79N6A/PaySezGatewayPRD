<script type="text/javascript">
 function piechart(){              
anychart.onDocumentReady(function() {
  // create pie chart with passed data
  data = anychart.data.set([
    ['> USD 1 million', 69.2, 24.2],
    ['USD 100,000 to 1 million', 85, 334],
    ['USD 10,000 to 100,000', 32.1, 1045],
    ['< 10,000 USD', 8.2, 3038]
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
            
            ['MC', 50.8],
            {
                name: 'RUPAY',
                y: 48.2,
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
    ['> Transaction was declined  by Processor', 69.2, 24.2],
    ['Stolen Card', 85, 334],
    ['Pickup Card', 32.1, 1045],
    ['Insufficient Funds', 8.2, 3038]
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
    ['Fraudulent Transaction Card', 69.2, 24.2],
    ['No Cardholder Authorization', 85, 334],
    ['Cardholder Dispute Draft Requested', 32.1, 1045],
    ['Credit Not Processed', 8.2, 3038]
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
		
<?php
require_once('database_config.php');
if(isset($_GET['q'])){
$q = $_GET['q'];
$iid = $_SESSION['iid'];
print_r($iid);
switch ($q) {
    case 'affinfo':
        echo getAffInfo($iid);
        break;
    
	case 'affstatus':
        echo getAffStatus($iid);
        break;
}
}

	$dataPoints = array(
            array("y" => 35, "name" => "Health", "exploded" => true),
            array("y" => 20, "name" => "Finance"),
            array("y" => 18, "name" => "Career"),
            array("y" => 15, "name" => "Education"),
            array("y" => 5, "name" => "Family"),
            array("y" => 7, "name" => "Real Estate")
        );

function getAffInfo($iid){
	global $db;
	$db->where("id",$iid);
	$userdata = $db->getOne("users");
	if($db->count > 0){
	$db->where("idagents",$userdata['agent_id']);
	$agentdata = $db->getOne("agents");
    if($db->count > 0){
		return '<div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">

        <div class="form-group">
            <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                            <img src="/img/sales-and-refunds.jpg"><br>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
    }else{
		return false;
	}
	}else{
		return false;
	}
}
function getAffStatus($id){
	
	return '
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
	</div>';
}?>

		
	