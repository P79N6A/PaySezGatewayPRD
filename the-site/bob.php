<?php
require_once('php/database_config.php');
function getAgents($rootid, $html){
   global $db;
   $cols = Array ("idagents", "agentname", "affiliation");
   $db->where("idagents",$rootid);
   $db->orderBy("agentname","Asc");
   $results = $db->get("agents", null, $cols);
	
   foreach($results as $row) {
	  $html = $row["idagents"]." - ".$row["agentname"]."<br />";
	  if($row["affiliation"] > 0){
		$html .= getAgents($row["affiliation"], $html);	
	  } 
   }
   return $html;
}
$agent_id = 3;
$agents_tree = getAgents($agent_id, "");

echo $agents_tree;
?>
<table class="table">
	<thead>
		<tr>
			<th>
			</th>
			<th>
				Setup
			</th>
			<th>
				Monthly
			</th>
			<th>
				Transaction fee
			</th>
			<th>
				Rebill Transaction fee
			</th>
		</tr>
	</thead>
	<tbody>
<tr id="row1">
	<td>
		Freddy's Fabulous Fixtures<input type="hidden" value="1" id="mid1" name="mid1">
	</td>
	<td id="acuitysetupfee">
		<input type="text" required="required" style="width: 70px" id="macuitysetupfee" name="macuitysetupfee">
	</td>
	<td id="acuitymonthlyfee">
		<input type="text" required="required" style="width: 70px" id="macuitymonthlyfee" name="macuitymonthlyfee">
	</td>
	<td id="acuitytransfee">
		<input type="text" required="required" style="width: 110px" id="macuitytransfee" name="macuitytransfee">
	</td>
	<td id="acuitytransfee2">
		<input type="text" style="width: 110px" id="macuitytransfee2" name="macuitytransfee2">
	</td>
</tr>
<tr id="row2">
	<td>
		One Secure Pay<input type="hidden" value="42" id="aid42" name="aid42">
	</td>
	<td class="acuitysetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitysetupfee42" name="aacuitysetupfee42">
	</td>
	<td class="acuitymonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitymonthlyfee42" name="aacuitymonthlyfee42">
	</td>
	<td class="acuitytransfee_sub">
		<input type="text" required="required" style="width: 110px" id="aacuitytransfee42" name="aacuitytransfee42">
	</td>
	<td class="acuitytransfee2_sub">
		<input type="text" style="width: 110px" id="aacuitytrans2fee42" name="aacuitytrans2fee42">
	</td>
</tr>
<tr id="row3">
	<td>
		JRC - al1<input type="hidden" value="33" id="aid33" name="aid33">
	</td>
	<td class="acuitysetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitysetupfee33" name="aacuitysetupfee33">
	</td>
	<td class="acuitymonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitymonthlyfee33" name="aacuitymonthlyfee33">
	</td>
	<td class="acuitytransfee_sub">
		<input type="text" required="required" style="width: 110px" id="aacuitytransfee33" name="aacuitytransfee33">
	</td>
	<td class="acuitytransfee2_sub">
		<input type="text" style="width: 110px" id="aacuitytrans2fee33" name="aacuitytrans2fee33">
	</td>
</tr>
<tr id="row4">
	<td>
		Veripay Payments - Cyprus<input type="hidden" value="32" id="aid32" name="aid32">
	</td>
	<td class="acuitysetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitysetupfee32" name="aacuitysetupfee32">
	</td>
	<td class="acuitymonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitymonthlyfee32" name="aacuitymonthlyfee32">
	</td>
	<td class="acuitytransfee_sub">
		<input type="text" required="required" style="width: 110px" id="aacuitytransfee32" name="aacuitytransfee32">
	</td>
	<td class="acuitytransfee2_sub">
		<input type="text" style="width: 110px" id="aacuitytrans2fee32" name="aacuitytrans2fee32">
	</td>
</tr>
<tr id="row5">
	<td>
		MMP<input type="hidden" value="4" id="aid4" name="aid4">
	</td>
	<td class="acuitysetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitysetupfee4" name="aacuitysetupfee4">
	</td>
	<td class="acuitymonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitymonthlyfee4" name="aacuitymonthlyfee4">
	</td>
	<td class="acuitytransfee_sub">
		<input type="text" required="required" style="width: 110px" id="aacuitytransfee4" name="aacuitytransfee4">
	</td>
	<td class="acuitytransfee2_sub">
		<input type="text" style="width: 110px" id="aacuitytrans2fee4" name="aacuitytrans2fee4">
	</td>
</tr>
<tr id="row6">
	<td>
		tachht<input type="hidden" value="3" id="aid3" name="aid3">
	</td>
	<td class="acuitysetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitysetupfee3" name="aacuitysetupfee3">
	</td>
	<td class="acuitymonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="aacuitymonthlyfee3" name="aacuitymonthlyfee3">
	</td>
	<td class="acuitytransfee_sub">
		<input type="text" required="required" style="width: 110px" id="aacuitytransfee3" name="aacuitytransfee3">
	</td>
	<td class="acuitytransfee2_sub">
		<input type="text" style="width: 110px" id="aacuitytrans2fee3" name="aacuitytrans2fee3">
	</td>
</tr>
<tr id="row7">
	<td>
		Buy Rate
	</td>
	<td class="acuitysetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="bracuitysetupfee" name="bracuitysetupfee">
	</td>
	<td class="acuitymonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="bracuitymonthlyfee" name="bracuitymonthlyfee">
	</td>
	<td class="acuitytransfee_sub">
		<input type="text" required="required" style="width: 110px" id="bracuitytransfee" name="bracuitytransfee">
	</td>
	<td class="acuitytransfee2_sub">
		<input type="text" style="width: 110px" id="bracuitytransfee2" name="bracuitytransfee2">
	</td>
</tr>
<tr id="row8">
	<td>
		Profit
	</td>
	<td class="acuitysetupfee_total">
		<input type="text" disabled="" style="width: 70px" id="acuitysetupfee_total" name="acuitysetupfee_total">
	</td>
	<td class="acuitymonthlyfee_total">
		<input type="text" disabled="" style="width: 70px" id="acuitymonthlyfee_tota" name="acuitymonthlyfee_tota">
	</td>
	<td class="acuitytransfee_total">
		<input type="text" disabled="" style="width: 110px" id="acuitytransfee_tota" name="acuitytransfee_tota">
	</td>
	<td class="acuitytransfee2_total">
		<input type="text" disabled="" style="width: 110px" id="acuitytransfee2_tota" name="acuitytransfee2_tota">
	</td>
</tr>
</tbody>
</table>

<table>
<tbody>
<tr>
	<th>
	</th>
	<th>
		Setup
	</th>
	<th>
		Monthly
	</th>
	<th>
		Transaction fee
	</th>
</tr>
<tr id="row1">
	<td>
		Freddy's Fabulous Fixtures<input type="hidden" value="1" id="mid1" name="mid1">
	</td>
	<td id="gsetupfee">
		<input type="text" required="required" style="width: 70px" id="mgsetupfee" name="mgsetupfee">
	</td>
	<td id="gmonthlyfee">
		<input type="text" required="required" style="width: 70px" id="mgmonthlyfee" name="mgmonthlyfee">
	</td>
	<td id="gtransfee">
		<input type="text" required="required" style="width: 110px" id="mgtransfee" name="mgtransfee">
	</td>
</tr>
<tr id="grow2">
	<td>
		One Secure Pay<input type="hidden" value="42" id="aid42" name="aid42">
	</td>
	<td class="gsetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="agsetupfee42" name="agsetupfee42">
	</td>
	<td class="gmonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="agmonthlyfee42" name="agmonthlyfee42">
	</td>
	<td class="gtransfee_sub">
		<input type="text" required="required" style="width: 110px" id="agtransfee42" name="agtransfee42">
	</td>
</tr>
<tr id="grow3">
	<td>
		JRC - al1<input type="hidden" value="33" id="aid33" name="aid33">
	</td>
	<td class="gsetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="agsetupfee33" name="agsetupfee33">
	</td>
	<td class="gmonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="agmonthlyfee33" name="agmonthlyfee33">
	</td>
	<td class="gtransfee_sub">
		<input type="text" required="required" style="width: 110px" id="agtransfee33" name="agtransfee33">
	</td>
</tr>
<tr id="grow4">
	<td>
		Veripay Payments - Cyprus<input type="hidden" value="32" id="aid32" name="aid32">
	</td>
	<td class="gsetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="agsetupfee32" name="agsetupfee32">
	</td>
	<td class="gmonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="agmonthlyfee32" name="agmonthlyfee32">
	</td>
	<td class="gtransfee_sub">
		<input type="text" required="required" style="width: 110px" id="agtransfee32" name="agtransfee32">
	</td>
</tr>
<tr id="grow5">
	<td>
		MMP<input type="hidden" value="4" id="aid4" name="aid4">
	</td>
	<td class="gsetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="agsetupfee4" name="agsetupfee4">
	</td>
	<td class="gmonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="agmonthlyfee4" name="agmonthlyfee4">
	</td>
	<td class="gtransfee_sub">
		<input type="text" required="required" style="width: 110px" id="agtransfee4" name="agtransfee4">
	</td>
</tr>
<tr id="grow6">
	<td>
		tachht<input type="hidden" value="3" id="aid3" name="aid3">
	</td>
	<td class="gsetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="agsetupfee3" name="agsetupfee3">
	</td>
	<td class="gmonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="agmonthlyfee3" name="agmonthlyfee3">
	</td>
	<td class="gtransfee_sub">
		<input type="text" required="required" style="width: 110px" id="agtransfee3" name="agtransfee3">
	</td>
</tr>
<input type="hidden" value="1" id="borg" name="borg">
<tr>
	<td>
		Network Merchants Inc.<input type="hidden" value="45" id="pid1" name="pid1">
	</td>
	<td class="gsetupfee_sub">
		<input type="text" required="required" style="width: 70px" id="pgsetupfee" name="pgsetupfee">
	</td>
	<td class="gmonthlyfee_sub">
		<input type="text" required="required" style="width: 70px" id="pgmonthlyfee" name="pgmonthlyfee">
	</td>
	<td class="gtransfee_sub">
		<input type="text" required="required" style="width: 110px" id="pgtransfee" name="pgtransfee">
	</td>
</tr>
<tr>
	<td>
		Profit
	</td>
	<td class="gsetupfee_total">
		<input type="text" disabled="" style="width: 70px" id="gsetupfee" name="gsetupfee">
	</td>
	<td class="gmonthlyfee_total">
		<input type="text" disabled="" style="width: 70px" id="gmonthlyfee" name="gmonthlyfee">
	</td>
	<td class="gtransfee_total">
		<input type="text" disabled="" style="width: 110px" id="gtransfee" name="gtransfee">
	</td>
</tr>
</tbody>
</table>