<?php

require_once('database_config.php');
?>
<style>
.anychart-credits-text{
	display:none;
}
.anychart-credits-logo{
	display:none;
}
</style>
<?php
$selectvaluee = $_POST['selectvaluee'];
$selctdate=date("Y-m-d");
	
for($i=1;$i<=$selectvaluee;$i++){

			$cdate="$selctdate";
			
			$time = $cdate.' '.'00:00:00';



			?>
<script type="text/javascript">
function lineviewchart<?php echo $i; ?>(){
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
  series_1.name('Total COUNT');
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
  series_2.name('RUPAY COUNT');
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
  series_3.name('MC COUNT');
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
  chart.container('containerrs<?php echo $i;?>');

  // initiate chart drawing
  chart.draw();
});
 
	//	var datt= document.getElementById("security_question_1");
		
function getData() {
   return [
	   <?php 

			for($j=0; $j<=23; $j++)
			{
			$timestamp = strtotime($time) + 60*60;
			$time1 =$cdate.' '. date('H:i:s', $timestamp);
				
				
			$sql="select  count(network) AS ntotal, network AS net from  transactions where  server_datetime_trans>='$time' AND server_datetime_trans<='$time1' GROUP BY network";
			
			
			$newvar= strtotime($time);
			$hours= date('H', $newvar);
			
			$testdate= strtotime($time);
			$pdate= date('Y-m-d', $testdate);
			
			$time = $time1; 		
			
			
			$databd = $db->rawQuery($sql);
		
		        $mcount=$databd[0]['ntotal'];
		        $mcnet=$databd[0]['net'];
		        $rupcount=$databd[1]['ntotal'];
		        $runet=$databd[1]['net'];
				$totalcount= $mcount + $rupcount;
				
				?>
			['<?php  echo $hours; ?>','<?php echo $totalcount; ?>','<?php echo $mcount; ?>','<?php echo $rupcount;?>'],
				<?php  }?>
				
			]		 
 }
}
</script>
	
	 <div class="form-group" >
	 	
		 <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
					<td>
					<b>Date :</b>&nbsp;&nbsp;<?php echo $pdate; ?> 
					</td>
					</tr>
					<tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                           <div id="containerrs<?php echo $i;?>"></div><br>
                        </center>
                      </td>
                    </tr>
					
                </tbody>
            </table>
	</div><br> 
	<?php   $selctdate=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $cdate) ) ));
			
	}  ?>
<!--	
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
  chart.container('containerrs2');

  // initiate chart drawing
  chart.draw();
});
 
	//	var datt= document.getElementById("security_question_1");
		
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
	<div class="form-group" >
	 		
		 <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    
					<tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                       
                           <div id="containerrs2"></div><br>
                         
                        </center>
                      </td>
                    </tr>
					
                </tbody>
            </table>	
	</div>
<script type="text/javascript">
function lineviewchart3(){
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
  chart.container('containerrs3');

  // initiate chart drawing
  chart.draw();
});
 
	//	var datt= document.getElementById("security_question_1");
		
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
	
	<div class="form-group" >
	 		
		 <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    
					<tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                       
                           <div id="containerrs3"></div><br>
                         
                        </center>
                      </td>
                    </tr>
					
                </tbody>
            </table>	
	</div>
-->