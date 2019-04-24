<?php
require_once('database_config.php');

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


function sendEmail($email, $name, $body, $subject){
	include_once ('../PHPMailer/PHPMailerAutoload.php');
	$results_messages = array();
	$results_errors = array();
	$today = date("F j, Y, g:i a T");  
	$mail = new PHPMailer(true);
	$mail->CharSet = 'utf-8';
	 
	try {
	$to = $email;
	if(!PHPMailer::validateAddress($to)) {
	  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
	}
	$mail->isSMTP();//$mail->isMail();
	//$mail->SMTPDebug = 2;
	$mail->Debugoutput = 'html';
	$mail->Host = "smtpout.secureserver.net";
	$mail->Port = 465;
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true;
	$mail->Username = "noreply@cardfitness.com";
	$mail->Password = "123456";
	$mail->addReplyTo("noreply@earthpaysystems.com", "earthpaysystems");
	$mail->From       = "noreply@earthpaysystems.com";
	$mail->FromName   = "earthpaysystems";
	$mail->addAddress($email, $name);
	$mail->Subject  = $subject;
	$mail->WordWrap = 78;
	$mail->msgHTML($body); //Create message bodies and embed images
	 
	try {
	  $mail->send();
	  $results_messages[] = '<div class="alert alert-success">Message has been sent to the bank - &quot;'.$name.'&quot;</div>';
	}
	catch (phpmailerException $e) {
	  throw new phpmailerAppException('Unable to send to: ' . $to. ': '.$e->getMessage());
	}
	}
	catch (phpmailerAppException $e) {
	  $results_errors[] = '<div class="alert alert-danger">'.$e->errorMessage().'</div>';
	}
	//var_dump($results_messages); 
	if (count($results_errors) > 0) {
		return $results_errors;
	}else{
		return $results_messages;
	}	
}

if(isset($_POST['cb_id'])){
	$cb_id = $_POST['cb_id'];
	
	//transaction info	
	$db->join("transactions", "transactions.id_transaction_id = chargebacks.id_transaction_id", "LEFT");
	$db->join("actions", "actions.id_transaction_id = transactions.id_transaction_id", "LEFT");
	$db->where("idchargebacks",$cb_id);
	$cb = $db->getOne("chargebacks");
	//carcgeback info
	/*$is_cb = false;
	$db->where("sale_transaction_id",$t_id);
	$db->join("cb_stati", "chargebacks.status = cb_stati.cb_stati_id", "LEFT");
	$cb = $db->getOne("chargebacks");
	*/

	//processor
	$p_id = $cb["processor_id"];
	$db->where("p_id",$p_id);
	$data = $db->getOne("processors");
	$processorsname = $data['processor_name'];

	$success = ($cb["success"]==1)?"Succeeded":"Failed";
	//create email body
	$body = '<h5>Transaction Details</h5><table border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Transaction ID</th>
									<td>'.$cb["transaction_id"].'</td>
								</tr>';
	$body .=					'<tr>
									<th>Processor ID</th>
									<td>'.$processorsname.'</td>
								</tr>';
	$body .= 					'<tr>
									<th>Platform ID</th>
									<td>'.$cb["platform_id"].'</td>
								</tr>
								<tr>
									<th>Transaction Type</th>
									<td>'.$cb["action_type"].'</td>
								</tr>
								<tr>
									<th>Amount</th>
									<td>'.number_format($cb["amount"],2).'</td>
								</tr>
								<tr>
									<th>Shipping</th>
									<td>'.number_format($cb["shipping"]).'</td>
								</tr>
								<tr>
									<th>Tax</th>
									<td>'.number_format($cb["tax"],2).'</td>
								</tr>
								<tr>
									<th>Currency</th>
									<td>'.$cb["currency"].'</td>
								</tr>
								<tr>
									<th>Transaction Result</th>
									<td>'.$success.'</td>
								</tr>
								<tr>
									<th>Status</th>
									<td>'.ucfirst($cb["condition"]).'</td>
								</tr>
								<tr>
									<th>Settled Date</th>
									<td>'.$cb["processor_settlement_date"].'</td>
								</tr>
								<tr>
									<th>Authorization Code</th>
									<td>'.$cb["authorization_code"].'</td>
								</tr>
								<tr>
									<th>PO Number</th>
									<td>'.$cb["ponumber"].'</td>
								</tr>
								<tr>
									<th>Order ID</th>
									<td>'.$cb["order_id"].'</td>
								</tr>
								<tr>
									<th>Order Description</th>
									<td>'.$cb["order_description"].'</td>
								</tr>
								<tr>
									<th>Transaction date</th>
									<td>'.$cb["transaction_date"].'</td>
								</tr>
								<tr>
									<th>IP Address</th>
									<td>'.$cb["ipaddress"].'</td>
								</tr>
								<tr>
									<th>Affiliate</th>
									<td>'.$cb["mdf_6"].'</td>
								</tr>
								<tr>
									<th>Affiliate ID</th>
									<td>'.$cb["mdf_7"].'</td>
								</tr>
								<tr>
									<th>Rebill</th>
									<td>'.$cb["rebill_number"].'</td>
								</tr>
								<tr>
									<th>Response</th>
									<td>'.$cb["response_text"].'</td>
								</tr>
							</tbody>
						</table>';
						
	$body .= '<h5>Credit Card Details</h5><table border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Credit card</th>
									<td>'.$cb["cc_number"].'</td>
								</tr>
								<tr>
									<th>Credit card Type</th>
									<td>'.getCCType($cb["cc_number"]).'</td>
								</tr>
								<tr>
									<th>CC Hash</th>
									<td>'.$cb["cc_hash"].'</td>
								</tr>
								<tr>
									<th>Expire</th>
									<td>'.$cb["cc_exp"].'</td>
								</tr>
							</tbody>
						</table>';

	$body .= '<br /><br /><h5>Customer Details</h5><table  border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Billing Address:</th>
									<th>Shipping Address:</th>
								</tr>
								<tr>
									<td>'.$cb["first_name"].' '.$cb["last_name"].'<br />'; 
										if($cb["company"] != " ") $body .= $cb["company"].'<br />'; 
										$body .= $cb["address1"].' '.$cb["address2"].'<br />'; 
										$body .= $cb["city"].' '.$cb["us_state"].'<br />'; 
										$body .= $cb["postal_code"].' '.$cb["country"].'<br />'; 
										$body .= $cb["email"].'<br />'; 
										$body .= $cb["phone"].'<br /></td>
									<td>'. $cb["shipping_first_name"].' '.$cb["shipping_last_name"].'<br />'; 
										if($cb["shipping_company"] != " ") $body .= $cb["company"].'<br />'; 
										$body .= $cb["shipping_address1"].' '.$cb["shipping_address2"].'<br />'; 
										$body .= $cb["shipping_city"].' '.$cb["shipping_us_state"].'<br />'; 
										$body .= $cb["shipping_postal_code"].' '.$cb["shipping_country"].'<br />'; 
										$body .= $cb["shipping_email"].'<br />'; 
										$body .= $cb["shipping_carrier"].' '.$cb["tracking_number"].'<br />'; 
										$body .= $cb["shipping_date"].'<br /></td>
								</tr>
							</tbody>
						</table>';
						
	$body .= '<h5>Chargeback Data</h5><table border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Refference Number</th>
									<td>'.$cb["ACQ_REF_NR"].'</td>
								</tr>
								<tr>
									<th>Status</th>
									<td>'.$cb["name"].'</td>
								</tr>
								<tr>
									<th>Dispute Result</th>
									<td>'.$cb["dispute_result"].'</td>
								</tr>
								<tr>
									<th>Chargeback Amount</th>
									<td>'.number_format($cb["cb_amount"], 2).'</td>
								</tr>
								<tr>
									<th>Reason Code</th>
									<td>'.$cb["reason_code"].'</td>
								</tr>
								<tr>
									<th>Response Date</th>
									<td>'.$cb["response_date"].'</td>
								</tr>
								<tr>
									<th>Update Date</th>
									<td>'.$cb["update_date"].'</td>
								</tr>
							</tbody>
						</table>';

$subject = 'earthpaysystems Chargeback '.$cb_id;

$email = $data['email'];
//$email = 'virginiya@gmail.com';
if($email != "" && isset($email)){						
	$results = sendEmail($email, $data['processor_name'], $body, $subject);
	foreach($results as $result)
	{
		echo $result;
	}
} else {
	echo '<div class="alert alert-danger">!!! There is no email associated to perform the requested action.</div>';
}
//change the status in the DB

}
?>

