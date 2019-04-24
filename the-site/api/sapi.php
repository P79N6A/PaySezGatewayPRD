<?php
require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
//error_reporting(E_ALL);
$db = new Mysqlidb('10.10.90.5', 'root', '25kUHbWZTA', 'profitorius');
$data = array();
require_once('encrypt.php');
header('Content-Type: application/json');
$file = 'postlogs.txt';
$postdata = date('l jS \of F Y h:i:s A').''.PHP_EOL;
foreach($_POST as $key=>$value)
{
  $postdata .= $key.'='.$value.''.PHP_EOL;
}
$postdata.= '---------------------------------'.PHP_EOL;
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $postdata, FILE_APPEND | LOCK_EX);
if(isset($_POST['env']) && !empty($_POST['env'])){
	if($_POST['env'] == 'test'){
		$callUrl = "https://tpay.smilepay.co.kr/trans/cardTrans.jsp";
		$merchantKey = "lkviD+J6o1+I/iFlxnRj3Xo+znBOmuo6G4gVCASJAaP65i8w0FiV24c/4PXkY2DEuPuk8bFhrZQ4HvIGijH3Zg==";
		$sendMID = "gompay001m";	//SECURE_TYPE A
		$environment = '0';
	}elseif($_POST['env'] == 'livetest'){
		$callUrl = "https://pay.smilepay.co.kr/trans/cardTrans.jsp";
		$merchantKey = "T+IbtWqgZdgRvbJ2p2SJJ6ZIhgaegUMNRE/FyrM/Q4YaxpSHfYsJGBuj79wQSKqYrJ4Y1ZIXzv3h4QCxZNlKvg==";
		$sendMID = "testga840m";	//SECURE_TYPE A	
		$environment = '0';
	}elseif($_POST['env'] == 'live'){
		$callUrl = "https://pay.smilepay.co.kr/trans/cardTrans.jsp";
		$merchantKey = "T+IbtWqgZdgRvbJ2p2SJJ6ZIhgaegUMNRE/FyrM/Q4YaxpSHfYsJGBuj79wQSKqYrJ4Y1ZIXzv3h4QCxZNlKvg==";
		$sendMID = "310nua840m";	//SECURE_TYPE A	
		$environment = '1';
	}
	$TransactionType = $_POST['TransactionType'];
	$moto = 0;
	if(isset($_POST['apikey']) && !empty($_POST['apikey'])){
		$key = '25548680445484262110fbd9d2769a2b58ace60c2aeae971a129009881c2871d';
		$KeyArray = explode(',', mc_decrypt($_POST['apikey'], $key));
	}elseif(isset($_POST['supersecret']) && !empty($_POST['supersecret']) && isset($_POST['merchant_id']) && !empty($_POST['merchant_id']) && isset($_POST['gateway_id']) && !empty($_POST['gateway_id'])){
		//should remove this after testing.
		$KeyArray = array();
		//echo 'Missing api key'; die();
		$KeyArray[0] = $_POST['merchant_id'];
		$KeyArray[1] = $_POST['processor_id'];
		$KeyArray[2] = $_POST['gateway_id'];
		$moto = 1;
	}else{
		die('Missing api key');
	}
	//should do check here to see if they merchant_processor_mid is enabled to use or not.
	$db->where ("merchant_id", $KeyArray[0]);
	$db->where ("processor_id", $KeyArray[1]);
	$db->where ("gateway_id", $KeyArray[2]);
	$db->where ("is_active", 1);
	$db->get('merchant_processors_mid');
	if($db->count == 0){
		die('Unauthorized');
	}
	if($TransactionType == 'AA'){
		$data = Array (
					"merchant_id" => $KeyArray[0], // this should be ID of account using our gateway service
					"platform_id" => $KeyArray[2], //should be our id
					"transaction_type" => $TransactionType,
					"first_name" => $_POST['first_name'],
					"last_name" => $_POST['last_name'],
					"address1" => $_POST['address1'],
					"address2" => $_POST['address2'],
					"city" => $_POST['city'],
					"us_state" => $_POST['us_state'],
					"postal_code" => $_POST['postal_code'],
					"country" => $_POST['country'],
					"ponumber" => $_POST['ponumber'],
					"email" => $_POST['email'],
					"phone" => $_POST['phone'],
					"shipping_first_name" => $_POST['shipping_first_name'],
					"shipping_last_name" => $_POST['shipping_last_name'],
					"shipping_address1" => $_POST['shipping_address1'],
					"shipping_address2" => $_POST['shipping_address2'],
					"shipping_city" => $_POST['shipping_city'],
					"shipping_us_state" => $_POST['shipping_us_state'],
					"shipping_postal_code" => $_POST['shipping_postal_code'],
					"shipping_country" => $_POST['shipping_country'],
					"shipping_email" => $_POST['shipping_email'],
					"cc_number" => mc_encrypt($_POST['cc_number'], $ENCRYPTION_KEY), //encrypt cc number with cc_hash
					"cc_hash" => $ENCRYPTION_KEY, //create encryption here
					"cc_exp" => mc_encrypt($_POST['cc_exp_yy'].$_POST['cc_exp_mm'], $ENCRYPTION_KEY), //encrypt this date  with cc_hash
					"cavv" => mc_encrypt($_POST['cavv'], $ENCRYPTION_KEY), //encrypt this cvv also  with cc_hash
					"processor_id" => $KeyArray[1], // this should be smartro ID
					"currency" => $_POST['currency'],
					"environment" => $environment,
					"tax" => $_POST['tax'],
					"cc_type" => getCCType($_POST['cc_number'])
				);
		$id_transaction_id = $db->insert('transactions', $data);
		
		if($id_transaction_id){
			$data2 = Array (
					"id_transaction_id" => $id_transaction_id, // this should be ID of above mysql insert
					"amount" => $_POST['amount'],
					"action_type" => 'sale',
					"transaction_date" => date("Y-m-d H:i:s"),
					"ipaddress" => $_POST['BuyerIP'],
					"asource" => get_client_ip(),
					"moto_trans" => $moto,
					"username" => $_POST['BuyerID']
				);
			$action_id = $db->insert('actions', $data2);
		}
		$reference = $id_transaction_id;
		$acquireType = $_POST['acquireType'];
		$currency = $_POST['currency'];
		$amount = number_format($_POST['amount'] + $_POST['tax'], 2, '.', '');
		$cardNum = $_POST['cc_number'];
		$expiryYYMM = $_POST['cc_exp_yy'].$_POST['cc_exp_mm'];
		$cvc = $_POST['cavv'];
		$secureType = "A";
		$ProductName = $_POST['ponumber'];
		$BuyerEmail = $_POST['email'];
		$BuyerName = $_POST['first_name'].'-'.$_POST['last_name'];
		$BuyerIP = $_POST['BuyerIP'];
		$BuyerID = $_POST['BuyerID'];
		$ServerIP = get_client_ip();
		$SiteURL = $_SERVER['HTTP_REFERER'];
		$verify = "";
		$OutputType = "X";
		$keyData = getKeyData($reference, $amount, $merchantKey);
		$encyptcc = encrypt($cardNum, $keyData);
		$encyptexpiryYYMM = encrypt($expiryYYMM, $keyData);
		$encyptcvc = encrypt($cvc, $keyData);
		$deliIdx = getDeliIdx($reference, $amount);	
		$delimeters = getDelimeters($merchantKey, $deliIdx);
		$vsb ='';
		$vsb .= base64_encode($reference); 
		$vsb .= $delimeters[0];
		$vsb .= base64_encode($amount); 
		$vsb .= $delimeters[1];
		$vsb .= base64_encode($sendMID); 
		$vsb .= $delimeters[2];
		$vsb .= base64_encode($acquireType);
		$verify = hash('sha256', $vsb);
		$verifyValue = base64_encode($verify);
		$postdata = http_build_query(
			array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'Currency' => $currency,
				'Amount' => $amount,
				'CardNumber' => $encyptcc,
				'ExpiryYYMM' => $encyptexpiryYYMM,
				'CVC' => $encyptcvc,
				'AcquireType' => $acquireType,
				'ProductName' => $ProductName,
				'BuyerEmail' => 'smartro@gregtampa.com',
				'BuyerName' => $BuyerName,
				'BuyerID' => $BuyerID,
				'BuyerIP' => $BuyerIP,
				'ServerIP' => $ServerIP,
				'SiteURL' => $SiteURL,
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue,
				'Pares' => '?'
			)
		);

		$jsonObject = doRequest($postdata, $callUrl);
		$ResponseCode = trim($jsonObject['ResponseCode']);
		$ResponseMessage = trim($jsonObject['ResponseMessage']);	
		$AuthCode = trim($jsonObject['AuthCode']);	
		$ResponseDate = trim($jsonObject['ResponseDate']);	
		$ResponseTime = trim($jsonObject['ResponseTime']);	
		$rTID = trim($jsonObject['TID']);
			if(!$rTID){
			$rTID = 'NA';
			}		
		$VerifyValue = trim($jsonObject['VerifyValue']);
		if($ResponseCode == '0000'){
			$success = 1;
			$condition = 'complete';
		}else{
			$success = 0;
			$condition = 'failed';
		}
		$data3 = Array (
					"transaction_id" => $rTID,
					"condition" => $condition,
					"authorization_code" => $AuthCode,
					"avs_response" => $VerifyValue,
					"csc_response" => $ResponseCode
				);
		//$db->where('id_transaction_id', $id_transaction_id);
		//$id_transaction_id2 = $db->update('transactions', $data3, false);
		$id_transaction_id2 = $db->rawQuery('UPDATE transactions SET `transaction_id` = "'.$rTID.'", `condition` = "'.$condition.'", `authorization_code` = "'.$AuthCode.'", `avs_response` = "'.$VerifyValue.'", `csc_response` = "'.$ResponseCode.'" WHERE `id_transaction_id` = '.$id_transaction_id);
		
		//$id_transaction_id2 = $db->rawQuery('transactions', $data3);
		$data4 = Array (
					"success" => $success, 
					"response_text" => $ResponseMessage,
					"processor_batch_id" => $rTID,
					"processor_transaction_timestamp" => $ResponseTime,
					"processor_settlement_date" => $ResponseDate
				);
		$db->where('action_id', $action_id);
		$action_id2 = $db->update('actions', $data4);	
			//then return ResponseMessage back to merchant
		//echo $ResponseMessage.'<br />';echo $ResponseCode.'<br />';
			//send $id_transaction_id back to them to store in case refund needed
		//echo 'transactions id: '.$id_transaction_id;
		//echo '<br />';
		//var_dump($jsonObject);
		//echo '<br />';
		//var_dump($postdata);
		########## DUMP VARIABLE ###########################
/*
		Kint::dump(array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'Currency' => $currency,
				'Amount' => $amount,
				'CardNumber' => $encyptcc,
				'ExpiryYYMM' => $encyptexpiryYYMM,
				'CVC' => $encyptcvc,
				'AcquireType' => $acquireType,
				'ProductName' => $ProductName,
				'BuyerEmail' => $BuyerEmail,
				'BuyerName' => $BuyerName,
				'BuyerID' => $BuyerID,
				'BuyerIP' => $BuyerIP,
				'ServerIP' => $ServerIP,
				'SiteURL' => $SiteURL,
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue,
				'Pares' => '?'
			), json_encode($jsonObject)); // pass any number of parameters
			*/
	$results = [
			"success" 			=> $success,
			"ResponseMessage" 	=> $jsonObject['ResponseMessage'],
			"TID" 				=> $id_transaction_id
	];
		
echo json_encode($results);
	}elseif($TransactionType == 'AC'){
		$db->where('id_transaction_id', $_POST['TID']);
		$db->where('merchant_id', $KeyArray[0]);
		$db->where('platform_id', $KeyArray[2]);
		$db->where('processor_id', $KeyArray[1]);
		$chargeback_flag = 0;
		$action_type = 'refund';
		if(isset($_POST['iscb'])){
			$chargeback_flag = 1;
			$action_type = 'chargeback';
			$success = 1;
			$condition = 'complete';
			$jsonObject['ResponseMessage'] = 'Processing Valid';
		}
		$transactiondata = $db->getOne('transactions');	
				$data = Array (
					"merchant_id" => $KeyArray[0], // this should be ID of account using our gateway service
					"platform_id" => $KeyArray[2], //should be our id
					"transaction_type" => $TransactionType,
					"first_name" => $transactiondata['first_name'],
					"last_name" => $transactiondata['last_name'],
					"address1" => $transactiondata['address1'],
					"address2" => $transactiondata['address2'],
					"city" => $transactiondata['city'],
					"us_state" => $transactiondata['us_state'],
					"postal_code" => $transactiondata['postal_code'],
					"country" => $transactiondata['country'],
					"ponumber" => $transactiondata['ponumber'],
					"email" => $transactiondata['email'],
					"phone" => $transactiondata['phone'],
					"shipping_first_name" => $transactiondata['shipping_first_name'],
					"shipping_last_name" => $transactiondata['shipping_last_name'],
					"shipping_address1" => $transactiondata['shipping_address1'],
					"shipping_address2" => $transactiondata['shipping_address2'],
					"shipping_city" => $transactiondata['shipping_city'],
					"shipping_us_state" => $transactiondata['shipping_us_state'],
					"shipping_postal_code" => $transactiondata['shipping_postal_code'],
					"shipping_country" => $transactiondata['shipping_country'],
					"shipping_email" => $transactiondata['shipping_email'],
					"cc_number" => $transactiondata['cc_number'], //encrypt cc number with cc_hash
					"cc_hash" => $transactiondata['cc_hash'], //create encryption here
					"cc_exp" => $transactiondata['cc_exp'], //encrypt this date  with cc_hash
					"cavv" => $transactiondata['cavv'], //encrypt this cvv also  with cc_hash
					"processor_id" => $KeyArray[1], // this should be smartro ID
					"currency" => $transactiondata['currency'],
					"tax" => number_format($_POST['tax'], 2, '.', ''),
					"chargeback_flag" => $chargeback,
					"first_trans" => '0',
					"environment" => $environment,
					"cc_type" => $transactiondata['cc_type'],
					"original_transaction_id" => $transactiondata['id_transaction_id']
				);
		$id_transaction_id = $db->insert('transactions', $data);
		
		if($id_transaction_id){
			$data2 = Array (
					"id_transaction_id" => $id_transaction_id, // this should be ID of above mysql insert
					"amount" => number_format($_POST['amount'], 2, '.', ''),
					"action_type" => $action_type,
					"transaction_date" => date("Y-m-d H:i:s"),
					"moto_trans" => $moto,
					"asource" => get_client_ip()
				);
			$action_id = $db->insert('actions', $data2);
		}
		$db->where('id_transaction_id', $transactiondata['id_transaction_id']);
		$actiondata = $db->getOne('actions');	
		$amount = number_format($_POST['amount'] + $_POST['tax'], 2, '.', '');
		$reference = $id_transaction_id;
		$PartialCancelCode = $_POST['PartialCancelCode'];
		$currency = $_POST['currency'];
		$TID = $transactiondata['transaction_id'];
		$AuthDate = $actiondata['processor_settlement_date'];
		$AuthCode = $transactiondata['authorization_code'];
		$verify = "";
		$OutputType = "X";
		$deliIdx = getDeliIdx($reference, $amount);	
		$delimeters = getDelimeters($merchantKey, $deliIdx);
		$vsb ='';
		$vsb .= base64_encode($reference); 
		$vsb .= $delimeters[0];
		$vsb .= base64_encode($sendMID); 
		$vsb .= $delimeters[1];
		$vsb .= base64_encode($TID); //merchant passes us id_transaction_id and from that we get TID
		$vsb .= $delimeters[2];
		$vsb .= base64_encode($amount); 
		$vsb .= $delimeters[3];	
		$vsb .= base64_encode($PartialCancelCode);
		$verify = hash('sha256', $vsb);
		$verifyValue = base64_encode($verify);
		$postdata = http_build_query(
			array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'Currency' => $currency,
				'Amount' => $amount,
				'TID' => $TID, //merchant passes us id_transaction_id and from that we get TID
				'AuthDate' => str_replace('-', "", $AuthDate), //merchant passes us id_transaction_id and from that we get "processor_settlement_date" => $ResponseDate from actions table
				'AuthCode' => $AuthCode,//merchant passes us id_transaction_id and from that we get "authorization_code" => $AuthCode from transaction table
				'PartialCancelCode' => $PartialCancelCode,
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue
			)
		);
		if(!isset($_POST['iscb'])){
			$jsonObject = doRequest($postdata, $callUrl);
			//var_dump($jsonObject);
			$ResponseCode = trim($jsonObject['ResponseCode']);
			$ResponseMessage = trim($jsonObject['ResponseMessage']);	
			$AuthCode = trim($jsonObject['AuthCode']);	
			$ResponseDate = trim($jsonObject['ResponseDate']);	
			$ResponseTime = trim($jsonObject['ResponseTime']);	
			$rTID = trim($jsonObject['TID']);
				if(!$rTID){
				$rTID = 'NA';
				}
			$VerifyValue = trim($jsonObject['VerifyValue']);
			//var_dump($jsonObject['TID']);
			//var_dump($TID);
			if($ResponseCode == '0000'){
				$success = 1;
				$condition = 'complete';
			}else{
				$success = 0;
				$condition = 'failed';
			}
			$data3 = Array (
						"transaction_id" => $rTID,
						"condition" => $condition,
						"authorization_code" => $AuthCode,
						"avs_response" => $VerifyValue,
						"csc_response" => $ResponseCode
					);
			//$db->where('id_transaction_id', $id_transaction_id);
			//$id_transaction_id2 = $db->update('transactions', $data3, false);
			$id_transaction_id2 = $db->rawQuery('UPDATE transactions SET `transaction_id` = "'.$rTID.'", `condition` = "'.$condition.'", `authorization_code` = "'.$AuthCode.'", `avs_response` = "'.$VerifyValue.'", `csc_response` = "'.$ResponseCode.'" WHERE `id_transaction_id` = '.$id_transaction_id);
			//echo 'UPDATE transactions SET `transaction_id` = "'.$rTID.'", `condition` = "'.$condition.'", `authorization_code` = "'.$AuthCode.'", `avs_response` = "'.$VerifyValue.'", `csc_response` = "'.$ResponseCode.'" WHERE `id_transaction_id` = '.$id_transaction_id;
			//echo "Last executed query was ". $db->getLastQuery();
			$data4 = Array (
						"success" => $success, 
						"response_text" => $ResponseMessage,
						"processor_batch_id" => $rTID,
						"processor_transaction_timestamp" => $ResponseTime,
						"processor_settlement_date" => $ResponseDate
					);
			$db->where('action_id', $action_id);
			$action_id2 = $db->update('actions', $data4);
			}else{
				//transaction info	
				$db->join("actions", "actions.id_transaction_id = t.id_transaction_id", "LEFT");
				$db->where("t.id_transaction_id",$transactiondata['id_transaction_id']);
				$trans = $db->getOne("transactions t");
				//die();
				//cc info and encrypt
				$cc_number 	= $trans["cc_number"];
				$cc_hash 	= $trans["cc_hash"];
				$cc = mc_decrypt($cc_number, $cc_hash);
				$cc_last4 = "******".substr($cc, -4);
				$cc_type = getCCType($cc);
				$cc_exp = mc_decrypt($trans["cc_exp"], $cc_hash);
				//insert into database
				
				$data = Array ();
				$data['processor_id'] 			= $trans['processor_id'];
				$data['m_id'] 					= $trans['merchant_id'];
				//$data['reason_code'] 			= $cb_reason;
				//$data['account_id'] 			= $_SESSION['iid'];
				$data['cb_id'] 					= $TID;
				$data['cb_date'] 				= date("Y-m-d H:i:s"); 
				$data['cb_amount'] 				= $amount;
				$data['cc_type'] 				= $cc_type;
				$data['ccnum'] 					= $cc_last4;
				$data['first_name'] 			= $trans['first_name'];
				$data['last_name'] 				= $trans['last_name'];
				$data['sale_date'] 				= $trans['transaction_date'];
				$data['sale_value'] 			= $trans['amount'];
				//$cut 							= $trans["platform_id"];
				//$sale_transaction_id 			= preg_replace('/'.$cut.'$/', '', $t_id);
				$data['sale_transaction_id'] 	= $trans['id_transaction_id'];
				$data['user'] 					= $trans['username'];
				//$data['response_date'] 			= $ResponseDate;
				//$data['response_text'] 			= $ResponseMessage;
				$data['status'] 				= $success;
				//$data['dispute_result'] 		= $ResponseCode;
				//$data['update_date'] 			= date('Y-m-d', strtotime($cb_update_date));
				//$data['charged_date'] 			= date('Y-m-d', strtotime($cb_charged_date));
				$data['cb_type'] 				= 'CB';
				$data['cb_comment'] 			= $_POST['cb_comment'];
				$data['id_transaction_id'] 		= $id_transaction_id;	
				//$data['authcode'] 				= $AuthCode;
				
				$data3 = Array (
						"processor_id" => $trans['processor_id'], // this should be ID of above mysql insert
						"m_id" => $trans['merchant_id'],
						"cb_amount" => $amount,
						"id_transaction_id" => $id_transaction_id,
						"moto_trans" => $moto,
						"sale_transaction_id" => $trans['id_transaction_id']
					);
				$cb_id2 = $db->insert ('chargebacks', $data3);
				$db->where('idchargebacks', $cb_id2);
				$cb_id = $db->update('chargebacks', $data);
				//echo "Last executed query was ". $db->getLastQuery();
				if($cb_id2)
				{
					//response correspondance
					if($ResponseMessage != '') {
						$newresponse = Array(	"type" => "merchant",
												"response_text" => $ResponseMessage,
												"cb_id" => $cb_id2
						);
						$db->insert('cb_responses', $newresponse);
						
					}
				}	
			}
		/*
		Kint::dump(array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'Currency' => $currency,
				'Amount' => $amount,
				'TID' => $TID, //merchant passes us id_transaction_id and from that we get TID
				'AuthDate' => str_replace('-', "", $AuthDate), //merchant passes us id_transaction_id and from that we get "processor_settlement_date" => $ResponseDate from actions table
				'AuthCode' => $AuthCode,//merchant passes us id_transaction_id and from that we get "authorization_code" => $AuthCode from transaction table
				'PartialCancelCode' => $PartialCancelCode,
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue
			), json_encode($jsonObject)); // pass any number of parameters
			*/ 
	$results = [
			"success" 			=> $success,
			"ResponseMessage" 	=> $jsonObject['ResponseMessage'],
			"TID" 				=> $id_transaction_id
	];
		
echo json_encode($results);
	}elseif($TransactionType == 'AD'){
		$vsb ='';
		$vsb .= base64_encode($reference); 
		$vsb .= $delimeters[0];
		$vsb .= base64_encode($sendMID);
		$vsb .= $delimeters[1];
		$vsb .= base64_encode($amount); 
		$vsb .= $delimeters[2];
		$vsb .= base64_encode($AuthDate);
		$verify = hash('sha256', $vsb);
		$verifyValue = base64_encode($verify);
		$postdata = http_build_query(
			array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'Currency' => $currency,
				'Amount' => $amount,
				'TID' => $TID,
				'AuthDate' => $AuthDate,
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue
			)
		);
	}elseif($TransactionType == 'AQ'){
		$vsb ='';
		$vsb .= base64_encode($reference); 
		$vsb .= $delimeters[0];
		$vsb .= base64_encode($sendMID); 
		$vsb .= $delimeters[1];
		$vsb .= base64_encode($TID); 
		$vsb .= $delimeters[2];
		$vsb .= base64_encode($amount);
		$verify = hash('sha256', $vsb);
		$verifyValue = base64_encode($verify);	
				$postdata = http_build_query(
			array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'TID' => $TID,
				'AuthDate' => $AuthDate,
				'AuthCode' => $AuthCode,
				'ServiceType' => 'A',
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue
			)
		);
	}elseif($TransactionType == 'SQ'){
		$vsb ='';
		$vsb .= base64_encode($reference); 
		$vsb .= $delimeters[0];
		$vsb .= base64_encode($amount); 
		$vsb .= $delimeters[1];
		$vsb .= base64_encode($sendMID); 
		$vsb .= $delimeters[2];
		$vsb .= base64_encode($TransactionType);
		$verify = hash('sha256', $vsb);
		$verifyValue = base64_encode($verify);	
		$postdata = http_build_query(
			array(
				'Request Start' => '?',
				'Ver' => '1000',
				'RequestType' => 'TRAN',
				'MID' => $sendMID,
				'TransactionType' => $TransactionType,
				'Reference' => $reference,
				'Currency' => $currency,
				'Amount' => $amount,
				'TID' => 'gompay001m01011506100921078314',
				'AuthDate' => '20150610',
				'AuthCode' => '338375',
				'OutputType' => $OutputType,
				'VerifyValue' => $verifyValue,
				'Pares' => '?'
			)
		);		
	}
	//print_r($jsonObject);
	//echo 'sent verifyValue: '.$verifyValue;
}
//Credit Card Type
function getCCType($CCNumber)
{
	$creditcardTypes = array(
						array('Name'=>'American Express','cardLength'=>array(15),'cardPrefix'=>array('34', '37'))
						,array('Name'=>'Maestro','cardLength'=>array(12, 13, 14, 15, 16, 17, 18, 19),'cardPrefix'=>array('5018', '5020', '5038', '6304', '6759', '6761', '6763'))
						,array('Name'=>'Mastercard','cardLength'=>array(16),'cardPrefix'=>array('51', '52', '53', '54', '55'))
						,array('Name'=>'Visa','cardLength'=>array(13,16),'cardPrefix'=>array('4'))
						,array('Name'=>'JCB','cardLength'=>array(16),'cardPrefix'=>array('3528', '3529', '353', '354', '355', '356', '357', '358'))
						,array('Name'=>'Discover','cardLength'=>array(16),'cardPrefix'=>array('6011', '622126', '622127', '622128', '622129', '62213',
													'62214', '62215', '62216', '62217', '62218', '62219',
													'6222', '6223', '6224', '6225', '6226', '6227', '6228',
													'62290', '62291', '622920', '622921', '622922', '622923',
													'622924', '622925', '644', '645', '646', '647', '648',
													'649', '65'))
						,array('Name'=>'Solo','cardLength'=>array(16, 18, 19),'cardPrefix'=>array('6334', '6767'))
						,array('Name'=>'Unionpay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('622126', '622127', '622128', '622129', '62213', '62214',
													'62215', '62216', '62217', '62218', '62219', '6222', '6223',
													'6224', '6225', '6226', '6227', '6228', '62290', '62291',
													'622920', '622921', '622922', '622923', '622924', '622925'))
						,array('Name'=>'Diners Club','cardLength'=>array(14),'cardPrefix'=>array('300', '301', '302', '303', '304', '305', '36'))
						,array('Name'=>'Diners Club US','cardLength'=>array(16),'cardPrefix'=>array('54', '55'))
						,array('Name'=>'Diners Club Carte Blanche','cardLength'=>array(14),'cardPrefix'=>array('300','305'))
						,array('Name'=>'Laser','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6304', '6706', '6771', '6709'))
	);  
	$CCNumber= trim($CCNumber);
	$type='Unknown';
	foreach ($creditcardTypes as $card){
		if (! in_array(strlen($CCNumber),$card['cardLength'])) {
			continue;
		}
		$prefixes = '/^('.implode('|',$card['cardPrefix']).')/';            
		if(preg_match($prefixes,$CCNumber) == 1 ){
			$type= $card['Name'];
			break;
		}
	}
	return $type;
}
function doRequest($postdata, $callUrl){
		$xml = getXML($postdata, $callUrl);
		$jsonObject = array(
			"Ver" => $xml->Ver,
			"ResponseCode" => $xml->ResponseCode,
			"ResponseMessage" => $xml->ResponseMessage,
			"AuthCode" => $xml->AuthCode,
			"ResponseDate" => $xml->ResponseDate,
			"ResponseTime" => $xml->ResponseTime,
			"TID" => $xml->TID,
			"TransactionType" => $xml->TransactionType,
			"VerifyValue" => $xml->VerifyValue
			
		);
	return $jsonObject;
}
function getXML($postdata, $callUrl){
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);

	$context  = stream_context_create($opts);

	$xmlResponse = file_get_contents($callUrl, false, $context);

	$xml = simplexml_load_string($xmlResponse);
	return $xml;
}
function getDelimeters($merchantKey, $deliIdx){
	//String[] delimeters = getDelimeters(merchantKey.substring(0, merchantKey.length()-2), 4, 3, deliIdx);
	$delimeters = getDelimeter(substring($merchantKey, 0, strlen($merchantKey)-2), 4, 3, (int)$deliIdx);
	return $delimeters;
}
function getDeliIdx($reference, $amount){
	//int deliIdx = (Integer.parseInt(reference.substring(reference.length()-4, reference.length())) + Integer.parseInt(amount.replaceAll("\\.", "").replaceAll(",", ""))) % 86;
	$deliIdx = (int)(substring($reference, -4, 4) + str_replace('.', '', $amount)) % 86;
	return $deliIdx;
}
function getKeyData($reference, $amount, $merchantKey){
//for credit card
	$deliIdx2 = (int)(substring($reference, -4, 4) + str_replace(',', '', str_replace('.', '', $amount))) % 4;
	if($deliIdx2 == 0){
		$keyData = substring($merchantKey, 0, 16);
	}else{	
		$keyData = substring($merchantKey, (16*$deliIdx2), (16*$deliIdx2+16));
	}	
	return $keyData;
}
function encrypt($str, $key){
     $block = mcrypt_get_block_size('rijndael_128', 'ecb');
     $pad = $block - (strlen($str) % $block);
     $str .= str_repeat(chr($pad), $pad);
     return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}
function substring($string, $from, $to){
    return substr($string, $from, $to - $from);
}
//static String[] getDelimeters(String keyStr, int deliCnt, int byteSize, int startIndex) {
function getDelimeter($keyStr, $deliCnt, $byteSize, $startIndex){

		//String temp = keyStr + keyStr;
		$temp = $keyStr.$keyStr;
		//if(keyStr.length() < deliCnt*byteSize)
		if(strlen($keyStr) < ($deliCnt*$byteSize)){
		//	return getDelimeters(temp, deliCnt, byteSize, startIndex);
			return getDelimeter($temp, $deliCnt, $byteSize, $startIndex);
		}
		//String[] result = new String[deliCnt];
		$result = array();
		/*
		for(int i = 0 ; i < deliCnt ; i++) {
			if(i > 0)
				result[i] = temp.substring(startIndex+(byteSize*i), startIndex+(byteSize*(i+1)));
			else
				result[i] = temp.substring(startIndex, startIndex+byteSize);
		}
		*/
		$i = 0;
		while($i < $deliCnt) {
			if($i > 0)
				$result[$i] = substring($temp, $startIndex+($byteSize*$i), $startIndex+($byteSize*($i+1)));
			else
				$result[$i] = substring($temp, $startIndex, $startIndex+$byteSize);
			$i++;
		}
	//return result;
	return $result;
}
// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
