<?php
require_once('database_config.php');

// echo "hi";
// die();

if($usertype == 1 || !empty($_POST["usertype"])) {

	if(!empty($_POST["keyword"])) {
		// echo $_POST["usertype"]."=>".$_POST["keyword"];
		// echo "<br>";
		// $result_per_page= 10;

		$query ="SELECT merchant_name,currency_code, idmerchants, csphone, csemail, is_active, mer_map_id FROM merchants WHERE merchant_name like '" . $_POST["keyword"] . "%' AND  gp_status='1' AND  flag = '0' ORDER BY merchant_name";
		$results = $db->rawQuery($query);
		//print_r($results);

		// $number_of_results=mysql_num_rows($results);
		// while ($rows = mysqli_fetch_array($results)) {
		// 	echo $rows['id']. ' ' .$row['merchant_name'] . '<br>';
		// }
		// $number_of_pages = ceil($number_of_results/$result_per_page)
		if(!empty($results)) {
            $result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			//$result .='<table class="table table-hover table-responsive">';
			$result .='<thead>
					<tr data-level="header" class="header">
					<th><span class="notice"><b>Merchant_ID</b></span></th>
					<th><b>Merchant_Name</b></th>
					<th><b>Merchant_Email</b></th>
					<th><b>Merchant_Currency</b></th>
					<th><b>Merchant_Status</b></th>
					<th><b>Action</b></th>
					</tr>
				  </thead>
				  <tbody>';
			foreach($results as $row0){ 

                                          
                	$active = $row0['is_active'] == 1 ? "Active":"In-Active";

                	if ($active=="Active") {
                		$status = 'disabled';
                		$info ='';
                		
                	} else {
                		$status="";
                		$info="";
                	}

                //echo $active;exit;
                	$merchant_name  = $row0['merchant_name'];

                	$result .= '<tr class="gradeX">
			            <td class="data">'.$row0['mer_map_id'].'</td>

			            <td class="data">'.$row0['merchant_name'].'</td>

			            <td class="data">'.$row0['csemail'].'</td>

			            <td class="data">'.$row0['currency_code'].'</td>
			                                                                         
			            <td class="data">'.$active.'</td>
			            <td class="data">                                              
			            <a href="merchant_Details.php?m_id='.base64_encode( json_encode($row0['mer_map_id'])).'"><input type="button" class= "btn btn-primary btn-xs" value="Details" /></a>
			            <a href="merchant_Editdetails.php?m_id='.base64_encode( json_encode($row0['mer_map_id'])).'"><input type="button" class= "btn btn-primary btn-xs" value="Edit" /></a>
			            <button class = "btn btn-primary btn-xs" data-toggle = "modal" id='.$row0['mer_map_id'].' onclick="showdetails(this);" data-target="#confirm-submit"'.$status.'>Delete</button>'.$info.'
		            	</td>
		        		</tr>';
		    	}
			$result .= '</tbody></table>';
		} else {
			$result ="No Records Found";
		}
		//echo $active;
		echo $result;
	}
	if(!empty($_POST["keyword1"])) {
		// echo $_POST["usertype"]."=>".$_POST["keyword1"];
		// die();
		// echo "<br>";
		// $result_per_page= 10;

		$query = "SELECT * FROM merchants INNER JOIN terminal ON merchants.idmerchants = terminal.idmerchants WHERE  terminal.flag='0' AND mso_terminal_id like '" .$_POST["keyword1"]. "%'  ORDER BY terminal.id asc";
        $results = $db->rawQuery($query);

		//$usersofuser = $db->rawQuery($query);
		//print_r($results);

		// $number_of_results=mysql_num_rows($results);
		// while ($rows = mysqli_fetch_array($results)) {
		// 	echo $rows['id']. ' ' .$row['merchant_name'] . '<br>';
		// }
		// $number_of_pages = ceil($number_of_results/$result_per_page)
		if(!empty($results)) {
            $result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
			//$result .='<table class="table table-hover table-responsive">';
			$result .='<thead>
					<tr data-level="header" class="header">
					<th><span class="notice"><b>Merchant_ID <br> Merchant_Name</b></span></th>
					<th><b>Terminal_ID</b></th>
                    <th><b>Terminal_IMEI No</b></th>
                    <th><b>Terminal_Status</b></th>
                    <th style="width: 169px;" ><b>Action</b></th>
					</tr>
				  </thead>
				  <tbody>';
			foreach($results as $row0){ 

                                          
                	$active = $row0['active'] == 1 ? "Active":"In-Active";

                	if ($active=="Active") {
                		$status = 'disabled';
                		$info ='<div class="help"><div class="info-box1"><a></a> </div><a class="help-button1" title="You active Terminal so You will not be able to Delete from Terminal Account.">[?]</a></div>';
                		
                	} else {
                		$status="";
                		$info="";
                	}

                //echo $active;exit;
                	//$merchant_name  = $row0['merchant_name'];

                	$result .= '<tr class="gradeX">
			            <td class="data">'.$row0['mer_map_id']."<br>".$row0['merchant_name'].'</td>

			            <td class="data">'.$row0['mso_terminal_id'].'</td>

			            <td class="data">'.$row0['imei'].'</td>
			                                                                         
			            <td class="data">'.$active.'</td>
			            <td class="data">                                              
			            <a href="terminal_Details.php?m_id='.base64_encode( json_encode($row0['mso_terminal_id'])).'"><input type="button" class= "btn btn-primary btn-xs" value="Details" /></a>
			            <a href="terminal_Editdetails.php?m_id='.base64_encode( json_encode($row0['mso_terminal_id'])).'"><input type="button" class= "btn btn-primary btn-xs" value="Edit" /></a>
			            <button class = "btn btn-primary btn-xs" data-toggle = "modal" id='.$row0['merchant_name'].' onclick="showdetails(this);" value='.$row0['mso_terminal_id'].' data-target="#confirm-submit"'.$status.'>Delete</button>'.$info.'
		            	</td>
		        		</tr>';
		    	}
			$result .= '</tbody></table>';
		} else {
			$result ="No Records Found";
		}
		//echo $active;
		echo $result;
	}
}

?>
