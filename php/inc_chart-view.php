<?php
require_once('database_config.php');

/*
			$datetstart =$_GET['datetstart'];
			$datetend = $_GET['datetend'];
			$pid = $_GET['pid'];
			$ctypes =$_GET['ctypes'];
			$currencies =$_GET['currencies'];
			$ttype = $_GET['ttype'];
			$recurring = $_GET['recurring'];
			$agents = $_GET['agents'];
			$merchants = $_GET['merchants'];
			$mid = $_GET['mid'];
			$bin = $_GET['bin'];

if($datetstart=='' && $datetend=='' && $card_types=='0' && $currencies=='0' && $ttype=='0'   && $pid=='0' && $recurring=='0' && $agents=='0' && $merchants=='0' && $mid=='0' && $bin=='0'){

	$query= "SELECT a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id";
	   
}
else if($datetstart!='' && $datetend!=''){
		$query= "SELECT a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id WHERE currency ='$currencies' AND a.action_type = '$ttype' AND server_datetime_trans>='$datetstart' AND server_datetime_trans<='$datetend'";
}
{
		$query= "SELECT  a.action_type, network, a.amount, success, moto_trans, cc_number FROM transactions t INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id 
          INNER JOIN merchants m ON m.idmerchants = t.merchant_id WHERE currency ='$currencies' AND a.action_type = '$ttype'";	 
}
$data = $db->rawQuery($query); 
	*/


if(isset($_GET['q'])){
$q = $_GET['q'];
$iid = $_SESSION['iid'];


switch ($q) {
    case 'affinfo':
        echo getAffInfo($iid);
        break;
    case 'accinfo':
        echo getAccInfo($iid);
        break;
    case 'processors':
        echo getProcessors($iid);
        break;
	case 'fee':
        echo getFee($iid);
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
function getAccInfo($id){
	
	return '   <div class="panel panel-primary">
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

                           <div id="containerrs">
						   
						   </div>
                        </center>
                      </td>
                    </tr><br>
					<tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                           <div id="containerrs1"></div>
                        </center>
                      </td>
                    </tr>
					<br>
					<tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                           <div id="containerrs2"></div>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
}
function getProcessors($id){
	
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
				<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">
                           
                        </center>
                      </td>
                    </tr>
					 <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>
					<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto">
                           
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>
			</div>
			</div>
			</div>';
}
function getFee($id){
	
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

                          <div id="chartContainer" style="height: 300px; width: 100%;"><br><br>
                          
                        </center>
                      </td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                          <div id="chartContainer2" style="height: 300px; width: 100%;">
                          
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';

}
?>
<script type="text/javascript">
function lineviewchart(){
anychart.onDocumentReady(function() {
  // create data set on our data
  var dataSet = anychart.data.set(getData());

  // map data for the first series, take x from the zero column and value from the first column of data set
  var seriesData_1 = dataSet.mapAs({
    x: [0],
    value: [1]
  });

  // map data for the second series, take x from the zero column and value from the second column of data set
  var seriesData_2 = dataSet.mapAs({
    x: [0],
    value: [2]
  });

  // map data for the third series, take x from the zero column and value from the third column of data set
  var seriesData_3 = dataSet.mapAs({
    x: [0],
    value: [3]
  });

  // create line chart
  chart = anychart.line();

  // turn on chart animation
  chart.animation(true);

  // set chart padding
  chart.padding([10, 20, 5, 20]);

  // turn on the crosshair
  chart.crosshair()
    .enabled(true)
    .yLabel(false)
    .yStroke(null);

  // set tooltip mode to point
  chart.tooltip().positionMode('point');

  // set chart title text settings
  chart.title('Transaction Count Time of Day');
  chart.title().padding([0, 0, 5, 0]);

  // set yAxis title
  chart.yAxis().title('');
  chart.xAxis().labels().padding([5]);

  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('Total Sale');
  series_1.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_1.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // create second series with mapped data
  var series_2 = chart.line(seriesData_2);
  series_2.name('MC Sale');
  series_2.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_2.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // create third series with mapped data
  var series_3 = chart.line(seriesData_3);
  series_3.name('Rupay Sale');
  series_3.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_3.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // turn the legend on
  chart.legend()
    .enabled(true)
    .fontSize(13)
    .padding([0, 0, 10, 0]);

  // set container id for the chart and set up paddings
  chart.container('containerrs');

  // initiate chart drawing
  chart.draw();
});

function getData() {
  return [
    ['1986', 3.6, 2.3, 2.8, 11.5],
    ['1987', 7.1, 4.0, 4.1, 14.1],
    ['1988', 8.5, 6.2, 5.1, 17.5],
    ['1989', 9.2, 11.8, 6.5, 18.9],
    ['1990', 10.1, 13.0, 12.5, 20.8],
    ['1991', 11.6, 13.9, 18.0, 22.9],
    ['1992', 16.4, 18.0, 21.0, 25.2],
    ['1993', 18.0, 23.3, 20.3, 27.0],
    ['1994', 13.2, 24.7, 19.2, 26.5],
    ['1995', 12.0, 18.0, 14.4, 25.3],
    ['1996', 3.2, 15.1, 9.2, 23.4],
    ['1997', 4.1, 11.3, 5.9, 19.5],
    ['1998', 6.3, 14.2, 5.2, 17.8],
    ['1999', 9.4, 13.7, 4.7, 16.2],
    ['2000', 11.5, 9.9, 4.2, 15.4],
    ['2001', 13.5, 12.1, 1.2, 14.0],
    ['2002', 14.8, 13.5, 5.4, 12.5],
    ['2003', 16.6, 15.1, 6.3, 10.8],
    ['2004', 18.1, 17.9, 8.9, 8.9],
    ['2005', 17.0, 18.9, 10.1, 8.0],
    ['2006', 16.6, 20.3, 11.5, 6.2],
    ['2007', 14.1, 20.7, 12.2, 5.1],
    ['2008', 15.7, 21.6, 10, 3.7],
    ['2009', 12.0, 22.5, 8.9, 1.5]
  ]
}
}
</script>
<script type="text/javascript">
function lineviewchart1(){
anychart.onDocumentReady(function() {
  // create data set on our data
  var dataSet = anychart.data.set(getData());

  // map data for the first series, take x from the zero column and value from the first column of data set
  var seriesData_1 = dataSet.mapAs({
    x: [0],
    value: [1]
  });

  // map data for the second series, take x from the zero column and value from the second column of data set
  var seriesData_2 = dataSet.mapAs({
    x: [0],
    value: [2]
  });

  // map data for the third series, take x from the zero column and value from the third column of data set
  var seriesData_3 = dataSet.mapAs({
    x: [0],
    value: [3]
  });

  // create line chart
  chart = anychart.line();

  // turn on chart animation
  chart.animation(true);

  // set chart padding
  chart.padding([10, 20, 5, 20]);

  // turn on the crosshair
  chart.crosshair()
    .enabled(true)
    .yLabel(false)
    .yStroke(null);

  // set tooltip mode to point
  chart.tooltip().positionMode('point');

  // set chart title text settings
  chart.title('Transaction Count Time of Day');
  chart.title().padding([0, 0, 5, 0]);

  // set yAxis title
  chart.yAxis().title('');
  chart.xAxis().labels().padding([5]);

  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('Total Refund');
  series_1.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_1.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // create second series with mapped data
  var series_2 = chart.line(seriesData_2);
  series_2.name('MC Refund');
  series_2.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_2.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // create third series with mapped data
  var series_3 = chart.line(seriesData_3);
  series_3.name('Rupay Refund');
  series_3.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_3.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // turn the legend on
  chart.legend()
    .enabled(true)
    .fontSize(13)
    .padding([0, 0, 10, 0]);

  // set container id for the chart and set up paddings
  chart.container('containerrs1');

  // initiate chart drawing
  chart.draw();
});

function getData() {
  return [
    ['1986', 3.6, 2.3, 2.8, 11.5],
    ['1987', 7.1, 4.0, 4.1, 14.1],
    ['1988', 8.5, 6.2, 5.1, 17.5],
    ['1989', 9.2, 11.8, 6.5, 18.9],
    ['1990', 10.1, 13.0, 12.5, 20.8],
    ['1991', 11.6, 13.9, 18.0, 22.9],
    ['1992', 16.4, 18.0, 21.0, 25.2],
    ['1993', 18.0, 23.3, 20.3, 27.0],
    ['1994', 13.2, 24.7, 19.2, 26.5],
    ['1995', 12.0, 18.0, 14.4, 25.3],
    ['1996', 3.2, 15.1, 9.2, 23.4],
    ['1997', 4.1, 11.3, 5.9, 19.5],
    ['1998', 6.3, 14.2, 5.2, 17.8],
    ['1999', 9.4, 13.7, 4.7, 16.2],
    ['2000', 11.5, 9.9, 4.2, 15.4],
    ['2001', 13.5, 12.1, 1.2, 14.0],
    ['2002', 14.8, 13.5, 5.4, 12.5],
    ['2003', 16.6, 15.1, 6.3, 10.8],
    ['2004', 18.1, 17.9, 8.9, 8.9],
    ['2005', 17.0, 18.9, 10.1, 8.0],
    ['2006', 16.6, 20.3, 11.5, 6.2],
    ['2007', 14.1, 20.7, 12.2, 5.1],
    ['2008', 15.7, 21.6, 10, 3.7],
    ['2009', 12.0, 22.5, 8.9, 1.5]
  ]
}
}
    </script>
	<script type="text/javascript">
function lineviewchart2(){
anychart.onDocumentReady(function() {
  // create data set on our data
  var dataSet = anychart.data.set(getData());

  // map data for the first series, take x from the zero column and value from the first column of data set
  var seriesData_1 = dataSet.mapAs({
    x: [0],
    value: [1]
  });

  // map data for the second series, take x from the zero column and value from the second column of data set
  var seriesData_2 = dataSet.mapAs({
    x: [0],
    value: [2]
  });

  // map data for the third series, take x from the zero column and value from the third column of data set
  var seriesData_3 = dataSet.mapAs({
    x: [0],
    value: [3]
  });

  // create line chart
  chart = anychart.line();

  // turn on chart animation
  chart.animation(true);

  // set chart padding
  chart.padding([10, 20, 5, 20]);

  // turn on the crosshair
  chart.crosshair()
    .enabled(true)
    .yLabel(false)
    .yStroke(null);

  // set tooltip mode to point
  chart.tooltip().positionMode('point');

  // set chart title text settings
  chart.title('Transaction Count Time of Day');
  chart.title().padding([0, 0, 5, 0]);

  // set yAxis title
  chart.yAxis().title('');
  chart.xAxis().labels().padding([5]);

  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('Visa Sale');
  series_1.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_1.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // create second series with mapped data
  var series_2 = chart.line(seriesData_2);
  series_2.name('MC sale');
  series_2.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_2.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // create third series with mapped data
  var series_3 = chart.line(seriesData_3);
  series_3.name('Rupay Sale');
  series_3.hoverMarkers()
    .enabled(true)
    .type('circle')
    .size(4);
  series_3.tooltip()
    .position('right')
    .anchor('left')
    .offsetX(5)
    .offsetY(5);

  // turn the legend on
  chart.legend()
    .enabled(true)
    .fontSize(13)
    .padding([0, 0, 10, 0]);

  // set container id for the chart and set up paddings
  chart.container('containerrs2');

  // initiate chart drawing
  chart.draw();
});

function getData() {
  return [
    ['1986', 3.6, 2.3, 2.8, 11.5],
    ['1987', 7.1, 4.0, 4.1, 14.1],
    ['1988', 8.5, 6.2, 5.1, 17.5],
    ['1989', 9.2, 11.8, 6.5, 18.9],
    ['1990', 10.1, 13.0, 12.5, 20.8],
    ['1991', 11.6, 13.9, 18.0, 22.9],
    ['1992', 16.4, 18.0, 21.0, 25.2],
    ['1993', 18.0, 23.3, 20.3, 27.0],
    ['1994', 13.2, 24.7, 19.2, 26.5],
    ['1995', 12.0, 18.0, 14.4, 25.3],
    ['1996', 3.2, 15.1, 9.2, 23.4],
    ['1997', 4.1, 11.3, 5.9, 19.5],
    ['1998', 6.3, 14.2, 5.2, 17.8],
    ['1999', 9.4, 13.7, 4.7, 16.2],
    ['2000', 11.5, 9.9, 4.2, 15.4],
    ['2001', 13.5, 12.1, 1.2, 14.0],
    ['2002', 14.8, 13.5, 5.4, 12.5],
    ['2003', 16.6, 15.1, 6.3, 10.8],
    ['2004', 18.1, 17.9, 8.9, 8.9],
    ['2005', 17.0, 18.9, 10.1, 8.0],
    ['2006', 16.6, 20.3, 11.5, 6.2],
    ['2007', 14.1, 20.7, 12.2, 5.1],
    ['2008', 15.7, 21.6, 10, 3.7],
    ['2009', 12.0, 22.5, 8.9, 1.5]
  ]
}
}
</script>
<script type="text/javascript">
	function callchart () {
		var chart = new CanvasJS.Chart("chartContainer",
		{
			zoomEnabled: false,
                        animationEnabled: true,
			title:{
				text: "Chargeback ratio by volumne"
			},
			axisY2:{
				valueFormatString:"0.0 bn",

				maximum: 1.2,
				interval: .2,
				interlacedColor: "#F5F5F5",
				gridColor: "#D7D7D7",
	 			tickColor: "#D7D7D7"
			},
                        theme: "theme2",
                        toolTip:{
                                shared: true
                        },
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center",
				fontSize: 15,
				fontFamily: "Lucida Sans Unicode"

			},
			data: [
			{
				type: "line",
				lineThickness:3,
				axisYType:"secondary",
				showInLegend: true,
				name: "Total",
				dataPoints: [
				{ x: new Date(2001, 0), y: 0 },
				{ x: new Date(2002, 0), y: 0.001 },
				{ x: new Date(2003, 0), y: 0.01},
				{ x: new Date(2004, 0), y: 0.05 },
				{ x: new Date(2005, 0), y: 0.1 },
				{ x: new Date(2006, 0), y: 0.15 },
				{ x: new Date(2007, 0), y: 0.22 },
				{ x: new Date(2008, 0), y: 0.38  },
				{ x: new Date(2009, 0), y: 0.56 },
				{ x: new Date(2010, 0), y: 0.77 },
				{ x: new Date(2011, 0), y: 0.91 },
				{ x: new Date(2012, 0), y: 0.94 }


				]
			},
			{
				type: "line",
				lineThickness:3,
				showInLegend: true,
				name: "MC",
				axisYType:"secondary",
				dataPoints: [
				{ x: new Date(2001, 00), y: 0.18 },
				{ x: new Date(2002, 00), y: 0.2 },
				{ x: new Date(2003, 0), y: 0.25},
				{ x: new Date(2004, 0), y: 0.35 },
				{ x: new Date(2005, 0), y: 0.42 },
				{ x: new Date(2006, 0), y: 0.5 },
				{ x: new Date(2007, 0), y: 0.58 },
				{ x: new Date(2008, 0), y: 0.67  },
				{ x: new Date(2009, 0), y: 0.78},
				{ x: new Date(2010, 0), y: 0.88 },
				{ x: new Date(2011, 0), y: 0.98 },
				{ x: new Date(2012, 0), y: 1.04 }


				]
			},
			{
				type: "line",
				lineThickness:3,
				showInLegend: true,
				name: "RUPAY",
				axisYType:"secondary",
				dataPoints: [
				{ x: new Date(2001, 00), y: 0.16 },
				{ x: new Date(2002, 0), y: 0.17 },
				{ x: new Date(2003, 0), y: 0.18},
				{ x: new Date(2004, 0), y: 0.19 },
				{ x: new Date(2005, 0), y: 0.20 },
				{ x: new Date(2006, 0), y: 0.23 },
				{ x: new Date(2007, 0), y: 0.261 },
				{ x: new Date(2008, 0), y: 0.289  },
				{ x: new Date(2009, 0), y: 0.3 },
				{ x: new Date(2010, 0), y: 0.31 },
				{ x: new Date(2011, 0), y: 0.32 },
				{ x: new Date(2012, 0), y: 0.33 }


				]
			}


			],
          legend: {
            cursor:"pointer",
            itemclick : function(e) {
              if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
              }
              else {
                e.dataSeries.visible = true;
              }
              chart.render();
            }
          }
        });

chart.render();
}
    function callchart2 () {
        var chart1 = new CanvasJS.Chart("chartContainer2",
            {
                zoomEnabled: false,
                animationEnabled: true,
                title:{
                    text: "Chargeback ratio by count"
                },
                axisY2:{
                    valueFormatString:"0.0 bn",

                    maximum: 1.2,
                    interval: .2,
                    interlacedColor: "#F5F5F5",
                    gridColor: "#D7D7D7",
                    tickColor: "#D7D7D7"
                },
                theme: "theme2",
                toolTip:{
                    shared: true
                },
                legend:{
                    verticalAlign: "bottom",
                    horizontalAlign: "center",
                    fontSize: 15,
                    fontFamily: "Lucida Sans Unicode"

                },
                data: [
                    {
                        type: "line",
                        lineThickness:3,
                        axisYType:"secondary",
                        showInLegend: true,
                        name: "Total",
                        dataPoints: [
                            { x: new Date(2001, 0), y: 0 },
                            { x: new Date(2002, 0), y: 0.001 },
                            { x: new Date(2003, 0), y: 0.01},
                            { x: new Date(2004, 0), y: 0.05 },
                            { x: new Date(2005, 0), y: 0.1 },
                            { x: new Date(2006, 0), y: 0.15 },
                            { x: new Date(2007, 0), y: 0.22 },
                            { x: new Date(2008, 0), y: 0.38  },
                            { x: new Date(2009, 0), y: 0.56 },
                            { x: new Date(2010, 0), y: 0.77 },
                            { x: new Date(2011, 0), y: 0.91 },
                            { x: new Date(2012, 0), y: 0.94 }


                        ]
                    },
                    {
                        type: "line",
                        lineThickness:3,
                        showInLegend: true,
                        name: "MC Refund",
                        axisYType:"secondary",
                        dataPoints: [
                            { x: new Date(2001, 00), y: 0.18 },
                            { x: new Date(2002, 00), y: 0.2 },
                            { x: new Date(2003, 0), y: 0.25},
                            { x: new Date(2004, 0), y: 0.35 },
                            { x: new Date(2005, 0), y: 0.42 },
                            { x: new Date(2006, 0), y: 0.5 },
                            { x: new Date(2007, 0), y: 0.58 },
                            { x: new Date(2008, 0), y: 0.67  },
                            { x: new Date(2009, 0), y: 0.78},
                            { x: new Date(2010, 0), y: 0.88 },
                            { x: new Date(2011, 0), y: 0.98 },
                            { x: new Date(2012, 0), y: 1.04 }


                        ]
                    },
                    {
                        type: "line",
                        lineThickness:3,
                        showInLegend: true,
                        name: "RUPAY Refund",
                        axisYType:"secondary",
                        dataPoints: [
                            { x: new Date(2001, 00), y: 0.16 },
                            { x: new Date(2002, 0), y: 0.17 },
                            { x: new Date(2003, 0), y: 0.18},
                            { x: new Date(2004, 0), y: 0.19 },
                            { x: new Date(2005, 0), y: 0.20 },
                            { x: new Date(2006, 0), y: 0.23 },
                            { x: new Date(2007, 0), y: 0.261 },
                            { x: new Date(2008, 0), y: 0.289  },
                            { x: new Date(2009, 0), y: 0.3 },
                            { x: new Date(2010, 0), y: 0.31 },
                            { x: new Date(2011, 0), y: 0.32 },
                            { x: new Date(2012, 0), y: 0.33 }


                        ]
                    }



                ],
                legend: {
                    cursor:"pointer",
                    itemclick : function(e) {
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        }
                        else {
                            e.dataSeries.visible = true;
                        }
                        chart1.render();
                    }
                }
            });

        chart1.render();
    }
</script>
