<style>
.anychart-credits-text{
		display: none;
}
.anychart-credits-logo{
	display: none;
}
</style>

<div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
	
    <div class="panel-body">
	<div class="chosen-container chosen-container-single">
	<div class="ibox float-e-margins">
	<div class="ibox-content">
	<label>Select option to view Transaction Count</label>
		<select  id="security_question_1" class="form-control m-b" name="security_question_1"  onclick="myfunction();">
			<option selected>Select</option>
			<option  value="<?php echo date("y-m-d");?>">Current Date</option>
			<option  value="<?php echo date('Y-m-d', strtotime('1 week ago'));?>">Before One Week</option>
			<option value="<?php echo date('Y-m-d', strtotime('1 month ago'));?>">Before One Month</option>
        </select>
	</div>
	</div>
	</div>
			<div class="tab-contents" id="tab-contents">
                                <div id="" style="height: 300px; width: 100%;">
							
							</div>
						</div>
					</div>
			
			</div>
		
			
			
			