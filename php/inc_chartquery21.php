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

?>
<?php
$selectvaluee = $_POST['selectvaluee'];
$selctdate=date("Y-m-d");


for($i=1;$i<=$selectvaluee;$i++){
	
$dd=date("Y-m-d");
$sql="select Count(*) AS cnt from transaction where trans_date='$selctdate'";
$data1 = $db->rawQuery($sql); 
$ss=$data1[0]['cnt'];
if($ss=='0'){
	echo '';
}else{
	 echo $ttal;
}	
			$cdate="$selctdate";
			
			$time = $cdate.' '.'00:00:00';

			?>
<script type="text/javascript">
function lineviewchart<?php echo $i; ?>(){
anychart.onDocumentReady(function() {
  // create data set on our data
  var dataSet = anychart.data.set(getData());

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
  
  var yScale = chart.yScale();
  yScale.minimum(0);
  yScale.maximum(<?php echo $ttal; ?>);
  var ticks = chart.yScale().ticks();
  ticks.interval(1);
  
  
  // create first series with mapped data
  var series_1 = chart.line(seriesData_1);
  series_1.name('SALE COUNT');
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
  series_2.name('REFUND COUNT');
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
  series_3.name('CANCEL COUNT');
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
							
			$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' AND trans_datetime>='$time' AND trans_datetime<='$time1' group by cancel_flag";

			$que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id where trans_datetime>='$time' AND trans_datetime<='$time1' Group By refund_flag";


			$que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction where  trans_datetime>='$time' AND trans_datetime<='$time1'";
   
								$data1 = $db->rawQuery($que1); 
								$data2 = $db->rawQuery($que2); 
								$data3 = $db->rawQuery($que3);	
																	
											$newvar= strtotime($time);
											$hours= date('H', $newvar);
											
											$testdate= strtotime($time);
											$pdate= date('Y-m-d', $testdate);
											
											$time = $time1; 		
			
								$countc=$data1[0]['countc']; //cancel_flag_count
								$countr=$data2[0]['countr'];   //refund_flag_count
								$countt=$data3[0]['countt'];  //total_count		       
				               $total=$countc + $countr +  $countt;
							   ?>
   
	  ['<?php  echo $hours; ?>',<?php echo $countt; ?>,<?php  if($countr==''){echo "0";}else{ echo $countr; }?>,<?php if($countc==''){echo "0";}else{ echo $countc;} ?>],
				<?php  } ?>
				
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