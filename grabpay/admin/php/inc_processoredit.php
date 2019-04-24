<?php
require_once('database_config.php');

//filter post
if(isset($_POST['processor_id']))
{
	$p_id = $_POST['processor_id'];
	$db->where("p_id",$p_id);
	$processor = $db->getOne("processors");
	
	if($processor["gateway_or_bank"] == 1)
	{
		$processor_type_bank = "selected='selected'";
		$processor_type_gateway = "";
	} 
	else
	{
		$processor_type_bank = "";
		$processor_type_gateway = "selected='selected'";
	}
	
	$integrated = ($processor["integrated_to_prof"] == 1)?"checked='checked'":"";
	
	$i = 1;
	for($j=-12;$j<13;$j++)
	{
		$t = ($j>0)?"+".strval($j):strval($j);
		if($processor["processor_timezone"] == $t)
		{
			$checked[$i] ="selected='selected'";
		} else {
			$checked[$i] ="";
		}
		$i++;
	}

	$result = '<a href="processors.php" class="btn btn-outline btn-primary pull-right" type="button"><i class="fa fa-plus"></i> Add Processor</a><div class="clearfix"></div>
		<div id="msg"></div>
		<form id="addeditprocessor" action="processors.php" method="POST">
			<br />
				<div class="form-group">
					<label>Business Name</label> 
					<input value="'.$processor["processor_name"].'" type="text" class="form-control" name="p_bussiness_name" id="p_bussiness_name">
				</div>
				<div class="form-group">
					<label>Short Name</label> 
					<input value="'.$processor["processor_name2"].'" type="text" class="form-control" name="p_short_name" id="p_short_name">
				</div>
				<div class="form-group">
					<label>Email</label> 
					<input value="'.$processor["email"].'" type="text" class="form-control" name="p_email" id="p_email">
				</div>
				<div class="form-group">
					<label>Wire Fee</label> 
					<input value="'.$processor["wire_fee"].'" type="text" class="form-control" name="p_wire_fee" id="p_wire_fee">
				</div>
				<div class="form-group">
					<label>Bank or Gateway</label> 
					<select name="processor_type" id="processor_type" class="form-control m-b">
						<option value="1" '.$processor_type_bank.'>Bank</option>
						<option value="0" '.$processor_type_gateway.'>Gateway</option>
					</select>
				</div>
				<div class="form-group">
					<label>Time Zone</label> 
					<select name="processor_timezone" id="processor_timezone" class="form-control m-b">
						  <option value="-12" '.$checked["1"].'>(GMT -12:00) Eniwetok, Kwajalein</option>
						  <option value="-11" '.$checked["2"].'>(GMT -11:00) Midway Island, Samoa</option>
						  <option value="-10" '.$checked["3"].'>(GMT -10:00) Hawaii</option>
						  <option value="-9" '.$checked["4"].'>(GMT -9:00) Alaska</option>
						  <option value="-8" '.$checked["5"].'>(GMT -8:00) Pacific Time (US &amp; Canada)</option>
						  <option value="-7" '.$checked["6"].'>(GMT -7:00) Mountain Time (US &amp; Canada)</option>
						  <option value="-6" '.$checked["7"].'>(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
						  <option value="-5" '.$checked["8"].'>(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
						  <option value="-4" '.$checked["9"].'>(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
						  <option value="-3" '.$checked["10"].'>(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
						  <option value="-2" '.$checked["11"].'>(GMT -2:00) Mid-Atlantic</option>
						  <option value="-1" '.$checked["12"].'>(GMT -1:00 hour) Azores, Cape Verde Islands</option>
						  <option value="0" '.$checked["13"].'>(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
						  <option value="1" '.$checked["14"].'>(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
						  <option value="2" '.$checked["15"].'>(GMT +2:00) Kaliningrad, Riga, South Africa</option>
						  <option value="3" '.$checked["16"].'>(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
						  <option value="4" '.$checked["17"].'>(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
						  <option value="5" '.$checked["18"].'>(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
						  <option value="6" '.$checked["19"].'>(GMT +6:00) Almaty, Dhaka, Colombo</option>
						  <option value="7" '.$checked["20"].'>(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
						  <option value="8" '.$checked["21"].'>(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
						  <option value="9" '.$checked["22"].'>(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
						  <option value="10" '.$checked["23"].'>(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
						  <option value="11" '.$checked["24"].'>(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
						  <option value="12" '.$checked["25"].'>(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
					</select>
				</div>
				<div class="form-group">
					<div class="checkbox i-checks"><label> <input type="checkbox" value="" name="integrated" id="integrated" '.$integrated.'> <i></i> Integrated into Profitorius </label></div>
				</div>
				<br />
				<input type="hidden" value="'.$p_id.'" name="processor_id" />
				<button id="edit" class="btn btn-primary btn-lg btn-block" type="button"><i class="fa fa-pencil-square-o"></i> Edit Processor</button>
			</form><script src="js/plugins/iCheck/icheck.min.js"></script>
			<script>
            $(document).ready(function () {
                $(".i-checks").iCheck({
                    checkboxClass: "icheckbox_square-green",
                    radioClass: "iradio_square-green",
                });
				$("#edit").click(function () {
					var postData = $("#addeditprocessor").serializeArray();
						$.ajax({
							method: "POST",
							url: "php/inc_processorupdate.php",
							data:  postData
						})
						.done(function( msg ) {
							$("#msg").html(msg);
						});
				});

            });
        </script>';
echo $result;
}


?>