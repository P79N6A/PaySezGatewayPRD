<?php
require_once('database_config.php');
$iid = $_SESSION['iid'];

if(isset($_POST['rmflag'])) {
	// echo "<pre>";
	// print_r($_POST);
	// exit;
	$mer_id  = $_POST['mer_id'];
	$user_id = $_POST['user_id'];
	$dat=array(
		'userid' => 0
	);
	$db->where('idmerchants', $mer_id);
	$db->where('userid', $user_id);
	$db->update('merchants', $dat);

	return true;

	// $query="UPDATE merchants SET userid='0' WHERE idmerchants=$mer_id AND userid=$user_id";
	// //SELECT * FROM merchants WHERE userid=$userid";
	// $transactions = $db->rawQuery($query);
}

function getUserType($id){
	global $db;
	$db->where("id",$id);
    $data = $db->getOne("users");
	return $data;
}

$usertype = getUserType($iid);
$merchantid	= $usertype['merchant_id'];
foreach ($_POST as $key => $value) {
	filter_input(INPUT_POST, $key);
	$$key = $_POST[$key];
	$key = $value;
}

$m_id = $_POST['m_id'];
$merchantid = $_POST['processor_id']; //this is the merchantid merchant table
$userid = $_POST['merchantid']; // this is the id user table

		
$query="SELECT * FROM merchants WHERE userid=$userid";

$result = 'No Merchants assigned for this USER';

$transactions = $db->rawQuery($query);
?>
  
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<?PHP if($transactions[0]['idmerchants']!=''){?>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
            	<!-- <th style="width:5%;">Select</th> -->
                <th>Merchant ID</th>
                <th>Merchant Name</th>
                <th style="width:20%;">Remove / UnAssign</th>                
            </tr>
        </thead>
	<?php foreach($transactions as $tr) { ?>	
	<!-- <form action="processormerchantmanager.php" method="POST"> -->
    <tbody>
        <tr>
        	<!-- <td style="width:5%;"><input type="radio" name="select_mer" value="<?php // echo $tr['idmerchants']; ?>"></td> -->
            <td><?php echo $tr['idmerchants'] ?></td>
            <td><?php echo $tr['merchant_name'] ?></td>
            <td style="width:15%;">

            	<button class="btn btn-primary btn-block no-margin" class="test" data-toggle="modal" id="<?php echo $tr['userid'] ?>" onclick="showdetails(this);" data-target="#confirm-submit" value="<?php echo $tr['idmerchants'] ?>">Remove/UnAssign</button>
            	<!-- <button class="btn btn-primary btn-block no-margin" type="submit">Remove/UnAssign</button> -->
            	<!-- <input type="button" name="unassign" class="btn btn-primary btn-block no-margin" value="Remove/UnAssign"> -->
            </td>
        </tr>
    </tbody>
	<!-- </form> -->
	<?php } ?>
</table>
<?php } else echo "<br><br>".$result; ?>

<script>
$(document).ready(function() {
    $('#example').DataTable();
});


</script>