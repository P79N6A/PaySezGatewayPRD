<?php
require_once('header.php');

//check permission
if(!checkPermission('R'))
    include_once('forbidden.php');

include 'php/inc_reports.php';
$vars = 1;
require_once('php/inc_chart-view1.php');
//https://github.com/xdan/datetimepicker/blob/master/index.html
if(isset($_SESSION['iid'])){
	$iid = $_SESSION['iid'];
}
ini_set('memory_limit', '-1');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Reports</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Reports</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
		
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title  back-change">
					<h5>Charts</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="panel blank-panel">
						<div class="panel-heading">
							<div class="panel-options">
								<ul class="nav nav-tabs">
									<li class="active">
										<a data-toggle="tab" href="#tab-1" onclick="showAgent('affinfo')" aria-expanded="true">Sales & Refunds</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-2" onclick="showAgent('accinfo')" aria-expanded="false">Transaction Count</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-3" onclick="showAgent('processors')" aria-expanded="true">Charge Backs</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-4" onclick="showAgent('fee')" aria-expanded="false">Charge Back Ratio By Volume</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-5" onclick="showAgent('affstatus')" aria-expanded="false">Charge Back / Decline Reasons</a>
									</li>

								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content" id="tab-content">
                                <div id="chartContainer" style="height: 300px; width: 100%;">
							<?php echo getAffInfo($_SESSION['iid']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<link rel="stylesheet" type="text/css" href="js/datetimepicker/jquery.datetimepicker.css"/ >
<script src="js/datetimepicker/jquery.datetimepicker.js"></script> 
<script>
    function showAgent(str) {
        if (str == "") {
            document.getElementById("tab-content").innerHTML = "";
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
            xmlhttp.open("POST", "php/inc_chart-view1.php?q=" + str, true);
            xmlhttp.send();

            setTimeout(function() {  callchart(); }, 1000);
            setTimeout(function() {  callchart2(); }, 1500);
            setTimeout(function() {  linechart(); }, 1000);
            setTimeout(function() {  linechart2(); }, 1500);
            setTimeout(function() {  lineviewchart(); }, 1000);
            setTimeout(function() {  lineviewchart1(); }, 1500);
            setTimeout(function() {  lineviewchart2(); }, 2000);
			
			 setTimeout(function() {  piechart(); }, 1000);
            setTimeout(function() {  piechart1(); }, 1500);
            setTimeout(function() {  piechart2(); }, 2000);
            setTimeout(function() {  piechart3(); }, 2000);
            setTimeout(function() {  piechart4(); }, 2500);
            setTimeout(function() {  piechart5(); }, 2500);
            setTimeout(function() {  piechart6(); }, 2500);
        }
    }
</script>

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
  series_1.name('Brandy');
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
  series_2.name('Whiskey');
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
  series_3.name('Tequila');
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
  series_1.name('Brandy');
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
  series_2.name('Whiskey');
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
  series_3.name('Tequila');
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
  series_1.name('Brandy');
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
  series_2.name('Whiskey');
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
  series_3.name('Tequila');
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
				name: "India",
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
				name: "China",
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
				name: "USA",
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
                        name: "India",
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
                        name: "China",
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
                        name: "USA",
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
<script>
function linechart(){
	
Highcharts.chart('container', {

    title: {
        text: 'Chargeback Volume'
    },

    xAxis: {
        tickInterval: 1
    },

    yAxis: {
        type: 'logarithmic',
        minorTickInterval: 0.1
    },

    tooltip: {
        headerFormat: '<b>{series.name}</b><br />',
        pointFormat: 'x = {point.x}, y = {point.y}'
    },

    series: [{
        data: [1, 2, 4, 8, 16, 32, 64, 128, 256, 512],
        pointStart: 1
    }]
});
}
</script>
<script>
function linechart2(){
	
Highcharts.chart('container1', {

    title: {
        text: 'Chargeback Transaction Count'
    },

    xAxis: {
        tickInterval: 1
    },

    yAxis: {
        type: 'logarithmic',
        minorTickInterval: 0.1
    },

    tooltip: {
        headerFormat: '<b>{series.name}</b><br />',
        pointFormat: 'x = {point.x}, y = {point.y}'
    },

    series: [{
        data: [1, 2, 4, 8, 16, 32, 64, 128, 256, 512],
        pointStart: 1
    }]
});
}
</script>
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
            ['Firefox', 45.0],
            ['IE', 26.8],
            {
                name: 'Chrome',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Safari', 8.5],
            ['Opera', 6.2],
            ['Others', 0.7]
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
            ['Firefox', 45.0],
            ['IE', 26.8],
            {
                name: 'Chrome',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Safari', 8.5],
            ['Opera', 6.2],
            ['Others', 0.7]
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
            ['Firefox', 45.0],
            ['IE', 26.8],
            {
                name: 'Chrome',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Safari', 8.5],
            ['Opera', 6.2],
            ['Others', 0.7]
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
            ['Firefox', 45.0],
            ['IE', 26.8],
            {
                name: 'Chrome',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Safari', 8.5],
            ['Opera', 6.2],
            ['Others', 0.7]
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
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://cdn.anychart.com/js/7.14.3/anychart-bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.anychart.com/css/7.14.3/anychart-ui.min.css" />	
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>


<?php
require_once('footerjs.php');
?> 
<?php
require_once('footer.php');
?>