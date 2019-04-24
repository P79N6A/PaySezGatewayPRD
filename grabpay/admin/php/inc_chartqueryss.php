<?php
require_once('database_config.php');
?>
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
	#flotTip {
    padding: 3px 5px;
    background-color: #000;
    z-index: 100;
    color: #fff;
    opacity: .80;
    filter: alpha(opacity=85);
}
</style>	

<?php
$selectvaluee = $_POST['selectvaluee'];

$selctdate=date("Y-m-d");


for($i=1;$i<=$selectvaluee;$i++){
	
			$cdate="$selctdate";	

			$time = $cdate.' '.'00:00:00';
			

?>

	<script>
	function piechart<?php echo $i; ?>(){
		
		<?php 
		 $timestamp = strtotime($time) + 60*60;
			$time1 =$cdate.' '. date('H:i:s', $timestamp);
		 
	$que1="select sum(total_fee) as total from transaction where cancel_flag='1' AND trans_date='$cdate' group by cancel_flag ";
    $que2="select sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id where t.trans_date='$cdate' Group By refund_flag";
    $que3="select sum(total_fee) as total from transaction where trans_date='$cdate'";

	
	
						$data1 = $db->rawQuery($que1); 
						$data2 = $db->rawQuery($que2); 
						$data3 = $db->rawQuery($que3); 
							
								 $cancel_amount= $data1[0]['total'];
								 $refund_amount= $data2[0]['total'];
								 $total_amount= $data3[0]['total'];
							
							
											$newvar= strtotime($time);
											$hours= date('H', $newvar);
											
											$testdate= strtotime($time);
											$pdate= date('Y-m-d', $testdate);
											
											$time = $time1; 
							
				
	   ?>
		
somePlot = $.plot($("#containerss<?php echo $i;?>"), 
[{"label":"SALE <?php if($total_amount==''){echo '0';} else { echo number_format($total_amount); } ?>" , "data":<?php if($total_amount==''){echo '0';} else { echo $total_amount; } ?>},
{"label":"REFUND <?php if($refund_amount==''){echo '0';} else { echo number_format($refund_amount); } ?>","data":<?php if($refund_amount==''){echo '0';} else { echo $refund_amount; } ?>},
{"label":"CANCEL <?php if($cancel_amount==''){echo '0';} else { echo number_format($cancel_amount); } ?>","data":<?php if($cancel_amount==''){echo '0';} else { echo $cancel_amount; } ?>},
],
 {
     series: {
     pie: {show: true, threshold: 0.1
        // label: {show: true}
    }
    },
     grid: {
        hoverable: true
    },
    tooltip: true,
    tooltipOpts: {
        cssClass: "flotTip",
        content: "%p.0%, %s" ,
        shifts: {
            x: 20,
            y: 0
        },
        defaultTheme: false
    },
	
    

});

if (isNaN(somePlot.getData()[0].percent)){
    var canvas = somePlot.getCanvas();
    var ctx = canvas.getContext("2d");  //canvas context
    var x = canvas.width / 2;
    var y = canvas.height / 2;
    ctx.font = '30pt Calibri';
    ctx.textAlign = 'center';
    ctx.fillText('No Data!', x, y);
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
                        <td align="left" class="mainarea" style="padding: 10px;">
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-4">
						   <div id="containerss<?php echo $i;?>" style="width:400px; height: 300px"></div>
						</div>
						<div class="col-sm-4"></div>
						   </div>
						  
                      
                      </td>
                    </tr>
					
                </tbody>
            </table>
	</div>
	<?php   $selctdate=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $cdate) ) ));
			
}  ?>




