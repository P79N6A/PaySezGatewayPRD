<input type="button" value="Assing Merchant" onclick="myCall()"; />
 <!--?php
require_once('database_config.php');
$iid = $_SESSION['iid'];



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
$p_id = $_POST['p_id'];

		
		$query="SELECT * FROM merchants JOIN users  WHERE users.id=$m_id";
		
	
		
		$result = 'No Transactions Found';
		
		$transactions = $db->rawQuery($query);
		
?>
  
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Merchant ID</th>
                <th>Merchant Name</th>                
            </tr>
        </thead>
	<!--?php foreach($transactions as $tr) { ?>	
        <tbody>
            <tr>
                <td><?php echo $tr['idmerchants'] ?></td>
                <td><?php echo $tr['merchant_name'] ?></td>
            </tr>
        </tbody>
	<!--?php } ?-->
<!--/table>


<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>