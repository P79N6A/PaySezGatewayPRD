<?php

// if($_POST) {

// 	// get merchant_id passed via AJAX
// 	$merchant_id = $_POST['merchant_id'];

// 	$db->where('mer_map_id', $merchant_id);
//     $lastid = $db->getone("merchants");

//     echo $lastid; exit;

// 	// do check
// 	if ( email_exists($email) ) {
// 	    $response->result = true;
// 	}
// 	else {
// 	    $response->result = false;
// 	}

// 	// echo json
// 	echo json_encode($response);
// }

function merchantaddupdatestatus($postData,$action,$merchantId) {

	global $db;
    if($action == 1) {
		// echo "<pre>";
		// print_r($postData);
		// echo "<br>"; exit;
		$permission = isset($postData['Permission1']) ? $postData['Permission1'] : 0;
		$permission.= "~";
        $permission.= isset($postData['Permission2']) ? $postData['Permission2'] : 0;
        $permission.= "~";
        $permission.= isset($postData['Permission4']) ? $postData['Permission4'] : 0;
        $permission.= "~";
        $permission.= isset($postData['Permission3']) ? $postData['Permission3'] : 0;

		// echo $permission;
		// exit;

        $data = Array(
		    "merchant_name" => $postData['pg_merchant_name'],
		    // "idmerchants" => $postData['pg_merchant_map_id'],
		    "start_date" => date('Y-m-d', strtotime($postData['pg_merchant_start_date'])),
		    "address1" => $postData['pg_merchant_address1'],
		    "address2" => $postData['pg_merchant_address2'],
		    "city" => $postData['pg_merchant_city'],
		    "us_state" => $postData['pg_merchant_state'],
		    "country" => $postData['pg_merchant_country'],
		    "zippostalcode" => $postData['pg_merchant_postalcode'],
		    "csphone" => $postData['pg_merchant_phone'],
		    "csemail" => $postData['pg_merchant_email'],
		    "mer_map_id" => $postData['pg_merchant_id'],
		    "mcc" => $postData['pg_merchant_mcc'],
		    "currency_code" => $postData['pg_merchant_currency'],
		    "pcrq" => $permission,

		    "is_active" => 1 // 1 - active, 2 - Inactive
	    );
	    $id_merchant_id = $db->insert('merchants', $data);


	    $data_mid = array(
		    "merchant_id" => $id_merchant_id, // $postData['pg_merchant_map_id'],
		    "processor_id" => 3,
		    "gateway_id" => 3,
		    "mer_map_id" => $postData['pg_merchant_id'],
		    "accountno" => $postData['pg_accountno'],
		    "ifsccode" => $postData['pg_ifsccode']
	    );
	    $db->insert('merchant_processors_mid', $data_mid);

	    /**** Alipay Config for Test ****/
	    $partner_id = "2088621911453772";
	    $key_md5 = "og8qf0j66v2vlpjv0z4oyxtzoumowndp";
	    $data_config = array(
	    	"partner_id" => $partner_id,
	    	"currency" => $postData['pg_merchant_currency'],
	    	"key_md5" => $key_md5,
	    	"merchant_id" => $postData['pg_merchant_id'] 
	    );
	    $db->insert('alipay_config', $data_config);


	    $resdesc = 'Merchant Added successfully';
	    $success = 'S';

	    $Merchant_results = [
	        "MerchantID" => $postData['pg_merchant_id'],
	        "ResponseDesc" => $resdesc,
	        "ResponseCode" => $success
	    ];

	    $results = $Merchant_results;

	} else if($action == 2) {

		// echo "<pre>";
		// print_r($postData); 
		// echo "<br>";
		// echo $action;
		// echo "<br>";
		// echo $merchantId;
		// exit;

		// Getting data for merchant_processor_mid table starts
	    if ($postData['pg_merchant_map_id'] != "") { $data_mid["merchant_id"] = $postData['pg_merchant_map_id']; }

	    if ($postData['pg_merchant_id'] != "") { $data_mid["mer_map_id"] = $postData['pg_merchant_id']; }

	    if ($postData['pg_accountno'] != "") { $data_mid["accountno"] = $postData['pg_accountno']; }

	    if ($postData['pg_ifsccode'] != "") { $data_mid["ifsccode"] = $postData['pg_ifsccode']; }
	    //Getting for merchant_processor_mid table ends

	    //Getting for merchants table starts
	    if ($postData['pg_merchant_name'] != "") { $data["merchant_name"] = $postData['pg_merchant_name']; } 
	    if ($postData['pg_merchant_map_id'] != "") { $data["idmerchants"] = $postData['pg_merchant_map_id']; }    
	    if ($postData['pg_merchant_start_date'] != "") { $data["start_date"] = $postData['pg_merchant_start_date']; }   
	    if ($postData['pg_merchant_address1'] != "") { $data["address1"] = $postData['pg_merchant_address1']; }   
	    if ($postData['pg_merchant_address2'] != "") { $data["address2"] = $postData['pg_merchant_address2']; }    
	    if ($postData['pg_merchant_city'] != "") { $data["city"] = $postData['pg_merchant_city']; }  
	    if ($postData['pg_merchant_state'] != "") { $data["us_state"] = $postData['pg_merchant_state']; }

	    if ($postData['pg_merchant_country'] != "") { $data["country"] = $postData['pg_merchant_country']; }
	        
	    if ($postData['pg_merchant_postalcode'] != "") { $data["zippostalcode"] = $postData['pg_merchant_postalcode']; }
	        
	    if ($postData['pg_merchant_phone'] != "") { $data["csphone"] = $postData['pg_merchant_phone']; }

	    if ($postData['pg_merchant_email'] != "") { $data["csemail"] = $postData['pg_merchant_email']; }

	    if ($postData['pg_merchant_id'] != "") { $data["mer_map_id"] = $postData['pg_merchant_id']; }
	        
	    if ($postData['pg_merchant_mcc'] != "") { $data["mcc"] = $postData['pg_merchant_mcc']; }

	    if ($postData['pg_merchant_currency'] != "") { $data["currency_code"] = $postData['pg_merchant_currency']; }

	    //Getting for merchants table ends
	    //Update merchants table
	    $db->where('idmerchants', $merchantId);
	    $db->update('merchants', $data);

	    //Update processor mid table
	    $db->where("merchant_id", $merchantId);
	    $db->update('merchant_processors_mid', $data_mid);

		$success = 'S';
		$resdesc = 'Merchant Updated successfully';
		$results = [
			"MerchantID" => $postData['pg_merchant_id'],
			"ResponseDesc" => $resdesc,
			"ResponseCode" => $success
		];

	} else if($action == 3) {
		
		if ($postData['pg_merchant_status'] != "") { // 1 - active, 2 - Inactive
	        if($postData['pg_merchant_status'] == 1) {
	            $resdesc = 'Merchant Status Activated successfully';
	            $data["is_active"] = $postData['pg_merchant_status']; 
	        } else if($postData['pg_merchant_status'] == 2) {
	            $resdesc = 'Merchant Status In-Activated successfully';
	            $data["is_active"] = 0; // 1 - active, 0 - Inactive
	        }
	    }
	    //Update merchants table
	    $db->where('idmerchants', $merchantId);
	    $db->update('merchants', $data);
	    $success = 'S';
		$results = [
			"MerchantID" => $postData['pg_merchant_id'],
			"ResponseDesc" => $resdesc,
			"ResponseCode" => $success
		];
	
	}
	return $results;
}

function terminaladdupdatestatus($postData,$action,$merchantId) {
	
	global $db;

	if($action == 1) {

		// echo "<pre>";
		// print_r($postData);
		// echo "<br>";
		// echo $merchantId;
		// exit;
		$data = Array(
		    "idmerchants" => $merchantId,
		    "mso_terminal_id" => $postData['pg_terminal_id'],
		    "mso_ter_location" => $postData['pg_terminal_address'],
		    "mso_ter_state_code" => $postData['pg_terminal_state'],
		    "mso_ter_city_name" => $postData['pg_terminal_city'],
		    "mso_ter_pincode" => $postData['pg_terminal_pincode'],
		    "active" => 1 // 1 - active, 2 - Inactive
	    );

	    $id_terminal_id = $db->insert('terminal', $data);
	    if($id_terminal_id) {
	    	$resdesc = 'Terminal Added successfully';
		    $success = 'S';
		    $results = [
		        "TerminalID" => $postData['pg_terminal_id'],
		        "ResponseDesc" => $resdesc,
		        "ResponseCode" => $success
		    ];	
	    }
	    
	} else if($action == 2) {
		//Getting for terminal table starts
	    if ($postData['pg_terminal_address'] != "") { $data["mso_ter_location"] = $postData['pg_terminal_address']; }
	    if ($postData['pg_terminal_state'] != "") { $data["mso_ter_state_code"] = $postData['pg_terminal_state']; }
	    if ($postData['pg_terminal_city'] != "") { $data["mso_ter_city_name"] = $postData['pg_terminal_city']; }
	    if ($postData['pg_terminal_pincode'] != "") { $data["mso_ter_pincode"] = $postData['pg_terminal_pincode']; }

	    $db->where('idmerchants', $merchantId);
	    $db->where('mso_terminal_id', $postData['pg_terminal_id']);
	    $db->update('terminal', $data);

	    $resdesc = 'Terminal Updated successfully';
	    $success = 'S';
	    $results = [
	        "TerminalID" => $postData['pg_terminal_id'],
	        "ResponseDesc" => $resdesc,
	        "ResponseCode" => $success
	    ];

	} else if($action == 3) {
		if ($postData['pg_terminal_status'] != "") { // 1 - active, 2 - Inactive
	        if($postData['pg_terminal_status'] == 1) {
	            $resdesc = 'Terminal Status Activated successfully';
	            $data["active"] = $postData['pg_terminal_status']; 
	        } else if($postData['pg_terminal_status'] == 2) {
	            $resdesc = 'Terminal Status In-Activated successfully';
	            $data["active"] = 0; // 1 - active, 0 - Inactive
	        }
	    }

	    $db->where('idmerchants', $merchantId);
	    $db->where('mso_terminal_id', $postData['pg_terminal_id']);
	    $db->update('terminal', $data);

	    $success = 'S';
		$results = [
			"TerminalID" => $postData['pg_terminal_id'],
			"ResponseDesc" => $resdesc,
			"ResponseCode" => $success
		];
	
	}
	return $results;
}

?>