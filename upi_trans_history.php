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

}

if($usertype == 1) {
?>

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>History</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li class="active">
				<strong>Transaction History </strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<!-- Overall Transaction Report in Column Tiles 2 -->
<div class="clearfix"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">

			<div class="ibox-content">

				<form id="reports_form">
				
					<div class="row">

						<div class="col-md-4">
							<label>Merchants</label>
							<div id="merchantsbox">
							<select class="form-control m-b" name="merchants" id="merchants">
								<option value="">-- All Merchants --</option>
								<?php 
                               // $cols = array("idmerchants", "merchant_name", "mer_map_id", "is_active");
                              //  $db->where("is_active",1);
                              $upi_merchant_query="SELECT * FROM merchants INNER JOIN transaction_upi ON merchants.mer_map_id = transaction_upi.upi_merchant_id WHERE  merchants.upi_status = '1' AND transaction_upi.upi_reg_active !='1'";
                            $upi_merchants_status = $db->rawQuery($upi_merchant_query);
                               // $db->orderBy("mer_map_id","asc");
                               // $merchantDet = $db->get("merchants", null, $cols);
                                foreach ($upi_merchants_status as $key => $value) {
                                	echo '<option value="'.$value['upi_merchant_vaddr'].'">'.$value['upi_merchant_vaddr'].' - '.$value['merchant_name'].'</option>'; 
                                } 
                                ?>
							</select>
							<input type="hidden" name="upi_value" value="upi_value">
							</div>
						</div>
						<?php //getOptions($_SESSION['iid']); ?>
					</div>
					<div class="row">
						<div class="col-md-2">
						  <label>&nbsp;</label>
						  <!-- onclick="showReport('true')" -->
						  <button class="btn btn-primary btn-lg btn-block reportsearch" type="button"><i class="fa fa-check"></i>&nbsp;Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title  back-change">
				<h5>History</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<div id="filterresult"></div>
			</div>
		</div>
	</div>
</div>

</div>


<?php } ?>



<?php 
// $q = 'SELECT  FROM merchants';
// $records = $db->rawQuery($q);
// echo "<pre>";
// print_r($records);
// sleep(40);


} elseif($usertype == 6) {

	echo 'show virtual terminal';

	ajax_redirect('/virtualterminal.php');

} else {

	echo '<a href="login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>

<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>




<!-- Data picker -->



<!-- <script>
function callQueryapi() {
	
    $.ajax({
        method: "POST",
        url: "alipayapi.php",
        data: {action: '7' }
    })
    .done(function (msg) {
        if(msg==1)
            location.reload();
        else
            alert("All Transactions are up to date");
    });
}
</script> -->

<script type="text/javascript">

/**** Sparkline Graph jquery ****/
// $('.sparkline').sparkline('html', { enableTagOptions: true });

// $('.sparkline_1').sparkline('html', { enableTagOptions: true });

// $(window).on('resize', function() {
// 	$('.sparkline').sparkline('html', { enableTagOptions: true });
// });



$(document).ready(function(){

    /**** Daily Summary Report for selecting date from picker ****/
	$(".reportsearch").click(function () {
         $( "#filterresult" ).html('Bulding the report. Please wait...');
        var postData = $("#reports_form").serializeArray();
        console.log(postData);

        $.ajax({
            method: "POST",
            url: "php/inc_reportsearch1.php",
            data: postData
        })
        .done(function( msg ) {
            $("#filterresult").html(msg);

			// $('.dataTables-example').dataTable({
   //              "order": [[ 0, "asc" ]],
   //              responsive: true,
   //              "dom": 'T<"clear">lfrtip',
   //              "tableTools": {
   //                  "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
   //              }
   //          });
   //          $('input:checkbox').change(function() {
   //              if($(this).attr('id') == 'selectall') {
   //                  jqCheckAll2( this.id);
   //              }
   //          });
   //          function jqCheckAll2( id ) {
   //              $("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
   //          }

        });
    });
  });


    // $("#merchants").change(function () {
    //     if($(this).val()){
    //         $.ajax({
    //             method: "POST",
    //             url: "php/inc_reportsearch1.php",
    //             dataType: 'json',
    //             data: { m_id: $(this).val(); }
    //         })
    //         .done(function( msg ) {
    //             $("#terminal_id").html(msg);
    //         });
    //     }
    // });

</script>

    <!--script src="js/demo/chartjs-demo.js"></script-->
<script>
function myrefresh(){
    window.location.reload();
}
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<?php require_once('footer.php'); ?>