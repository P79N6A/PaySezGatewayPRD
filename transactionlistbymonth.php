<?php 

require_once('header.php'); 

if($_SESSION['user_type'] === 6)
	include_once('forbidden.php');

require_once('php/inc_agents_tree.php'); 


		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $user_id=$_SESSION['iid'];
        $event="view";
        $auditable_type="CORE PHP AUDIT";
        $new_values="";
        $old_values="";
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent= $_SERVER['HTTP_USER_AGENT'];
        audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip, $user_agent);

$search_type = 'trans';

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

//var_dump(getTransactions($_SESSION['iid']));die();

//if user is merchant 

if( $usertype == 4 || $usertype == 5) {

$omg ='';

if(!empty($env) && $env == 0) {

$omg = 'TEST MODE ENABLED';

}

?>

<input type="hidden" name="monthtime" id="monthtime" value="<?php echo $_GET['monthtime']; ?>">

<div class="row rlt_row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title  back-change">
				<h5>Results</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<div id="cbresults">
				</div>
			</div>
		</div>
	</div>
</div>

<?php

}


} elseif($usertype == 6) {

	echo 'show virtual terminal';

	ajax_redirect('/virtualterminal.php');

} else {

	echo '<a href="/login.php"> Please Login Again</a>';

}

		

require_once('footerjs.php'); ?>



<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">

<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>

$(document).ready(function(){

	var selected_date = $('#monthtime').val();
	
	// alert(selected_date);

	$.ajax({
		method: "POST",
		url: "php/inc_<?php echo $search_type; ?>search.php",
		data: {M_Date: selected_date}
	})
	.done(function( msg ) {
		$("#cbresults").html(msg);
		$('.dataTables-example').dataTable({
			"order": [[ 1, "desc" ]],
			responsive: true,
			"dom": 'T<"clear">lfrtip',
			"tableTools": {
				"sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
			}
		});
		$('input:checkbox').change(function() { 
			if($(this).attr('id') == 'selectall') {
				jqCheckAll2( this.id);
			}
		});
		function jqCheckAll2( id ) {
			$("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
		}
	});

});

</script>

<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>

<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">



<script type="text/javascript">

  $('.tree').treegrid();

</script> 

<?php require_once('footer.php'); ?>

