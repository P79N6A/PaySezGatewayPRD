<?php
require_once('database_config.php');

function displayArr($value, $level){
	$sublevel = $level;
	foreach($value as $item){
		 $cclass = (empty($item['Children']) && empty($item['Merchants']))?'class="no-children"':'';
		 $active = (empty($item['Children']) && empty($item['Merchants']))?"Inactive":"Active";
		 echo '<tr data-level="'.$level.'" id="level_'.$level.'_'.$item['Id'].'" '.$cclass.'>
					<td><i class="fa fa-users"></i> <a href="viewagent.php?agentid='.$item['Id'].'">'.$item['Name'].'</td>
					<td class="data">'.$item['Email'].'</td>
					<td class="data">'.$item['Phone'].'</td>
					<td class="data">'.$active.'</td>
				</tr>';
		 if(is_array($item['Children'])){
			  displayArr($item['Children'], $level+1);
		 }
		 
		  if(is_array($item['Merchants'])){
				$mlevel = $level + 1;
				displayMerchants($item['Merchants'], $mlevel);
		  }
	}
}

function displayMerchants($value, $level){
	foreach($value as $item){
		$active = ($item['Active'] == 1)?"Active":"Inactive";
		 echo '<tr data-level="'.$level.'" id="level_'.$level.'_'.$item['Mid'].'" class="no-children">
					<td><i class="fa fa-male"></i> <a href="viewagent.php?merchantid='.$item['Mid'].'">'.$item['Name'].'</td>
					<td class="data">'.$item['Email'].'</td>
					<td class="data">'.$item['Phone'].'</td>
					<td class="data">'.$active.'</td>
				</tr>';
	}
}

function getMerchants($agentid, $level){
	
	global $db;
	$arr = array();
	$cols = Array ("merchant_name", "idmerchants", "csphone", "csemail", "is_active","mer_map_id");
  $db->where("affiliate_id",$agentid);
	$db->orderBy("merchant_name","Asc");
    $results = $db->get("merchants", null, $cols);
	

	 foreach($results as $row) {
				$arr[] 	= array(
				"Name" 	=> $row["merchant_name"],
				"Mid" 	=>  $row["idmerchants"],
				"Email" => $row["csemail"],
				"Phone" => $row["csphone"],
				"Active" => $row["is_active"],
				"Level" =>  $level
				);
	 }
	return $arr;
}

function getAgents($rootid, $level){
   global $db;
   $arr = array();
   $cols = Array ("idagents", "agentname", "affiliation", "csphone", "csemail");
  $db->where("affiliation",$rootid);
   $db->orderBy("agentname","Asc");
   $results = $db->get("agents", null, $cols);
   $clevel = $level+1;
   foreach($results as $row) {
	  if($row["affiliation"] > 0){
			$arr[] = array(
			"Id" 		=> $row["idagents"],
			"Name" 		=> $row["agentname"],
			"Email" 	=> $row["csemail"],
			"Phone" 	=> $row["csphone"],
			"Level" 	=> $level,
			"Merchants" => getMerchants($row["idagents"], $clevel),
			"Children" 	=> getAgents($row["idagents"], $clevel)
			);
	  }
   }
  
   return $arr;
}

//--------------------------------------------------------------//
$id = $_SESSION['iid'];
//$id = 160;
$a = 1;
$m = 2; 

//if admin 
if($usertype == 1 || !empty($_POST["usertype"])) {

	if(!empty($_POST["keyword"])) {
		// echo $_POST["usertype"]."=>".$_POST["keyword"];
		// echo "<br>";
		// $result_per_page= 10;
		$query ="SELECT merchant_name, idmerchants, csphone, csemail, is_active, mer_map_id FROM merchants WHERE merchant_name like '" . $_POST["keyword"] . "%' ORDER BY merchant_name";
		$results = $db->rawQuery($query);
		// $number_of_results=mysql_num_rows($results);
		// while ($rows = mysqli_fetch_array($results)) {
		// 	echo $rows['id']. ' ' .$row['merchant_name'] . '<br>';
		// }
		// $number_of_pages = ceil($number_of_results/$result_per_page)
		if($results) {
            $result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			//$result .='<table class="table table-hover table-responsive">';
			$result .='<thead>
					<tr data-level="header" class="header">
						<th>Merchant Name</th>
						<th>Customer Service Email</th>
						<th>Customer Service Phone</th>
						<th>Status</th>
					</tr>
				  </thead>
				  <tbody>';
			foreach($results as $row) {
				$cclass = 'class="no-children"';
				$active = $row['is_active'] == 1 ? "Active":"In-Active";
				$merchant_Name = strip_tags($row['merchant_name']);

				$result .=  '<tr class="gradeX">
						<td><i class="fa fa-male"></i> <a href="viewagent.php?merchantid='.strip_tags($row['idmerchants']).'">'.$merchant_Name.'</td>

						<td class="data">'.strip_tags($row['csemail']).'</td>
						<td class="data">'.strip_tags($row['csphone']).'</td>
						<td class="data">'.strip_tags($active).'</td>
						</tr>';
			}

			$result .= '</tbody></table>';
		} else {
			$result ="No Records Found";
		}
		echo $result;
	}

	//find top agents
	$cols = Array ("idagents", "agentname", "csphone", "csemail");
	$db->where("affiliation", NULL, '<=>');
	$db->orderBy("agentname","Asc");
    $topagents = $db->get("agents", null, $cols);
	$tree = array();
	foreach($topagents as $topagent) {
		$tree[] = array(
			"Id" => $topagent["idagents"],
			"Name" => $topagent["agentname"],
			"Email" => $topagent["csemail"],
			"Phone" => $topagent["csphone"],
			"Level" => $a,
			"Merchants" => getMerchants($topagent["idagents"], $m++),
			"Children" => getAgents($topagent["idagents"], $a++)
			);
		
	}


	$cols1 = Array ("merchant_name", "idmerchants", "csphone", "csemail", "is_active","mer_map_id");
	//$db->where("affiliate_id",$agentid);
	$db->orderBy("merchant_name","Asc");
	$results = $db->get("merchants", null, $cols1);
	$arr = array();

	foreach($results as $row) {
		$arr[] 	= array(
		"Name" 	=> $row["merchant_name"],
		"Mid" 	=> $row["idmerchants"],
		"Email" => $row["csemail"],
		"Phone" => $row["csphone"],
		"Active"=> $row["is_active"],
		"Level" => $level,
		"mer_map_id"=>$row['mer_map_id']
		);
	}
	
} elseif($usertype == 2 || $usertype == 3) {
	$user_users = array();
	$db->where("id",$id);
	$user = $db->getOne("users");
	$agent_id =  $user["agent_id"];
	
	$cols = Array ("idagents", "agentname", "csphone", "csemail");
	$db->where("idagents", $agent_id);
    $agents = $db->getOne("agents", null, $cols);
	
	$tree = array();
	$tree[] = array(
			"Id" => $agents["idagents"],
			"Name" => $agents["agentname"],
			"Email" => $agents["csemail"],
			"Phone" => $agents["csphone"],
			"Level" => $a,
			"Merchants" => getMerchants($agents["idagents"], $m++),
			"Children" => getAgents($agent_id, $a++)
			);
}


if(isset($_POST['from']) && $_POST['from'] == 'EMI_Cal') {
	echo "<pre>";
	print_r($_POST); exit;
}

	
?>