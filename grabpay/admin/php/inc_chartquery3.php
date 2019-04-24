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
<script>
function linechart(){
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
  chart.title('');
  chart.title().padding([0, 0, 5, 0]);

  // set yAxis title
  chart.yAxis().title('Chargeback Volume');
  chart.xAxis().labels().padding([5]);

  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('Reason Code');
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
  series_2.name('Network | Year');
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
  series_3.name('Exp.');
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
  chart.container('container');

  // initiate chart drawing
  chart.draw();
});
 
	//	var datt= document.getElementById("security_question_1");
		
function getData() {
		
		
		
	return [
  <?php
			$sql="select code  from reason_code_text";
			$var= $db->rawQuery($sql);
				foreach($var as $record){
					$code=$record['code'];
				     
					$sqls="SELECT t.network, t.amount, c.reason_code, t.server_datetime_trans AS sdate, r.response_explanation AS reexp FROM transactions t LEFT JOIN chargebacks c ON c.id_transaction_id =t.id_transaction_id LEFT JOIN reason_code_text r ON c.reason_code =r.code where c.reason_code='".$code."'";
					
					$vars= $db->rawQuery($sqls);
					
				
				$network=$vars[0]['network'];
		        $amount=$vars[0]['amount'];
		        $reason_code=$vars[0]['reason_code'];
		        $sdate=$vars[0]['sdate'];
				$date = strtotime($sdate);
                $varyear= date('Y', $date);
		        $reexp=$vars[0]['reexp'];
		
	?>
        ['<?php echo $code; ?>','<?php echo $amount; ?>','<?php echo $network; echo "|"; echo $varyear; ?>','<?php echo $reexp;?>',],
		
				<?php  }   ?>
  ]
     
 }
}
</script>
<script>
function linechart2(){
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
  chart.title('');
  chart.title().padding([0, 0, 5, 0]);

  // set yAxis title
  chart.yAxis().title('Chargeback Transaction Count');
  chart.xAxis().labels().padding([5]);

  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('Transaction Count');
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
  series_2.name('Network | Year');
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
  series_3.name('Reason Code');
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
  chart.container('container1');

  // initiate chart drawing
  chart.draw();
});
 
	//	var datt= document.getElementById("security_question_1");
		
function getData() {
		
	return [
	<?php
			$sql="select code  from reason_code_text";
			$var= $db->rawQuery($sql);
				foreach($var as $record){
					$code=$record['code'];
				     
					$sqls="select count(*) As cont,SUM(a.amount), c.reason_code, YEAR(server_datetime_trans) AS year ,network AS net from transactions t INNER JOIN chargebacks c ON c.id_transaction_id = t.id_transaction_id INNER JOIN actions a ON a.id_transaction_id = t.id_transaction_id INNER JOIN reason_code_text r ON r.code=c.reason_code WHERE c.reason_code='".$code."' GROUP BY network, YEAR(server_datetime_trans),c.reason_code";
					
					$vars= $db->rawQuery($sqls);
					
				
				$cont=$vars[0]['cont'];
		        $network=$vars[0]['net'];
		        $reason_code=$vars[0]['reason_code'];
		        $year=$vars[0]['year'];				
		        $amount=$vars[0]['amount'];
		
	?>
        ['<?php echo $code; echo $year; ?>','<?php echo $cont; ?>','<?php echo $network; echo "|"; echo $year;  ?>','<?php echo $reason_code;?>','<?php echo $amount?>'],
		
				<?php  }   ?>    
  ]
     
 }
}
</script>
<!--
<script>
function linechart3(){
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
  chart.title('');
  chart.title().padding([0, 0, 5, 0]);

  // set yAxis title
  chart.yAxis().title('Chargeback Transaction Volume');
  chart.xAxis().labels().padding([5]);

  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('Amount');
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
  series_2.name('Network');
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
  series_3.name('Exp');
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
  chart.container('container2');

  // initiate chart drawing
  chart.draw();
});
 
	//	var datt= document.getElementById("security_question_1");
		
function getData() {
		
	return [
	<?php
			$sql="select code  from reason_code_text";
			$var= $db->rawQuery($sql);
				foreach($var as $record){
					$code=$record['code'];
				     
					$sqls="SELECT t.network, t.amount, c.reason_code, t.server_datetime_trans AS sdate, r.response_explanation AS reexp FROM transactions t LEFT JOIN chargebacks c ON c.id_transaction_id =t.id_transaction_id LEFT JOIN reason_code_text r ON c.reason_code =r.code where c.reason_code='".$code."'";
					
					$vars= $db->rawQuery($sqls);
					
				
				$network=$vars[0]['network'];
		        $amount=$vars[0]['amount'];
		        $reason_code=$vars[0]['reason_code'];
		        $sdate=$vars[0]['sdate'];
				
				$newvar= strtotime($sdate);
			$dyear= date('Y', $newvar);
		        $reexp=$vars[0]['reexp'];
		
	?>
        ['<?php echo $code;?>','<?php echo $amount; ?>','<?php echo $network?>','<?php echo $reexp;?>','<?php echo $amount?>'],
		
				<?php  }   ?>
  ]
     
 }
}
</script>
-->
<div class="panel panel-primary">
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
						<center> <b></b></center>
                  
                        <td align="left" class="mainarea" style="padding: 10px;"><center>
				<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">
                           
                        </center>
                      </td>
                    </tr>
				
					 <tr>
					 	<center> <b></b></center><br>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>
					<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto">
                           
                        </center>
                      </td>
                    </tr>
				<!--	<tr>
					 	<center> <b></b></center><br>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>
					<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto">
                           
                        </center>
                      </td>
                    </tr> -->
                </tbody>
            </table>
	     </div>
	</div>
</div>
</div>
</div>