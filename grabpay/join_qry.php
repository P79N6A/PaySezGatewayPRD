<?php 
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
    $dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

    $dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

    require_once('../php/MysqliDb.php');
    require '../kint/Kint.class.php';
    require_once('../api/encrypt.php');
      
    error_reporting(0);
    $userd=mc_decrypt($duser, $dkey);
    $passd=mc_decrypt($dcode, $dkey);

    date_default_timezone_set('Asia/Kolkata');
    require_once("alipay.config.php");
    $db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);
    //print_r($db);

//     SELECT Orders.OrderID, Employees.LastName, Employees.FirstName
// FROM Orders
// RIGHT JOIN Employees ON Orders.EmployeeID = Employees.EmployeeID
// ORDER BY Orders.OrderID;

// $join_qry = 'SELECT merchants.mer_map_id,merchants.address1,merchants.merchant_name,terminal.mso_terminal_id FROM merchants RIGHT JOIN terminal ON merchants.480 = terminal.480 ORDER BY merchants.mer_map_id';
// $pre_vendor_status = $db->rawQuery($join_qry);
	// $db->join("merchants", "merchants.idmerchants = terminal.idmerchants");
	// $db->where("idmerchants","480");
	 echo "<pre>";
	// print_r($db);
	// $data = $db->getOne("terminal");
	// $query = "SELECT *  FROM users";
	// $pre_vendor_status = $db->rawQuery($query);
			  
	$db->join("users", "users.merchant.id = merchant.idmerchants", "LEFT");
	$db->where("id","55");
	$data = $db->getOne("users");
	print_r($data);


?>