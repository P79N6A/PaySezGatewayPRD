<?php 
require_once('database_config.php');
$processors = $db->get("processors");
?>
<table class="table table-striped table-bordered table-hover dataTables-processors">
	<thead>
		<tr>
			<th>ID</th>
			<th>Processor Name</th>
			<th>Short name</th>
			<th>Email</th>
			<th>Wire Fee</th>
			<th>Time Zone</th>
			<th>Type</th>
			<th>Is Integrated</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($processors as $processor)
		{ ?>
			<tr class="gradeX">
				<td><?php echo $processor["p_id"]; ?></td>
				<td><?php echo $processor["processor_name"]; ?></td>
				<td><?php echo $processor["processor_name2"]; ?></td>
				<td><?php echo $processor["email"]; ?></td>
				<td><?php echo $processor["wire_fee"]; ?></td>
				<td><?php echo $processor["tz_processor"]; ?></td>
				<td><?php echo ($processor["gateway_or_bank"]==0)?"Gateway":"Bank"; ?></td>
				<td><?php echo ($processor["integrated_to_prof"]==0)?"False":"True"; ?></td>
				<td style="font-size: 18px;white-space:nowrap;">
					<a id="<?php echo $processor["p_id"]; ?>" class="edit-processor"><i class="fa fa-pencil-square-o"></i></a>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>