<?php
require_once('database_config.php');
//session_start();
/*
if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="169.38.91.250") {
    require_once('mcrypt.php');
}*/
require_once('passwordhash.php');
$user_type = getUserType($_SESSION['iid']);
function getagentofloguser($id){
global $db;
	$db->where("id",$id);
    $data = $db->getone("users");
	return $data['agent_id'];
}
if(isset($_POST['q'])){
	$iid = $_SESSION['iid'];
	//check if agentname exsist already
	$db->where ("agentname", $_POST['agentname']);
	$agentsfull = $db->get ("agents");
	//print_r($agentsfull);
	if ($db->count < 1){

		$useraccountid = createAgentAccount($_POST['email_address'], $iid, $_POST['username'], $_POST['cs_first_name'], $_POST['cs_last_name'], $_POST['csphone']);

		if($useraccountid != false){
			$agentidofuser = getagentofloguser($iid);
			if($user_type == 1){
				$agentidofuser = NULL;
			}
			//die();
			//add all the inputs to an array
			$vars = array(
					'agentname' =>	$_POST['agentname'],
					'shortname' =>	$_POST['agentname'],
					'country' =>	$_POST['country'],
					'address1' =>	$_POST['address1'],
					'address2' =>	$_POST['address2'],
					'city' =>	$_POST['city'],
					'us_state' =>	$_POST['us_state'],
					'zippostalcode' =>	$_POST['zippostalcode'],
					'website' =>	$_POST['website'],
					//'tz_name' =>	$_POST['tz_name'],
					'cs_first_name' =>	$_POST['cs_first_name'],
					'cs_last_name' =>	$_POST['cs_last_name'],
					//'sa_phone_number' =>	$_POST['sa_phone_number'],
					'cs_fax' =>	$_POST['cs_fax'],
					//'sa_email_address' =>	$_POST['sa_email_address'],
					'csemail' =>	$_POST['csemail'],
					'csphone' =>	$_POST['csphone'],
					'routing' =>	$_POST['routing'],
					'account' =>	$_POST['account'],
					'legal_name' =>	$_POST['legal_name'],
					'business_type' =>	$_POST['business_type'],
					'tax_id' =>	$_POST['tax_id'],
					//create user first then add the affiliation as that users id!! todo needs testing - greg
					'affiliation' =>	$agentidofuser,//needs to be agent_id of user creating the account if one is there. if admin should be null
					'timezone' =>	$_POST['tz_name']
					);
		//call the addagent function
			$agentid = addAgent($vars);
			if($agentid != false){
				updateuseraccount($useraccountid, $agentid);
				$result = '<div class="alert alert-success">Add Agent Successful: '.$vars['agentname'].". Please check your email.</div>";
			}else{
				$result = '<div class="alert alert-danger">Add Agent Failed error: UserName is already in use</div>';
			}
		}else{
				$result = '<div class="alert alert-danger">Add Agent Failed error: Email was not Sent containing password</div>';
		}
	}else{
		$result = '<div class="alert alert-danger">Add Agent Failed error: Agent name is already in use</div>';
	}
	
}
function updateuseraccount($id, $agentid){
global $db;
		$data = array(
				'agent_id' => $agentid
				);
	$db->where('id', $id);
	//should do some kind of security checks to prevent duplicate entries...(not in scope)
	$db->update('users', $data);
}
function createAgentAccount($email_address, $iid, $username, $first_name, $last_name, $phone){
   
//generate a password
//insert into user the user
$password = substr(str_shuffle(str_repeat("23456789abcdefghkmnpqrstuvwxyz", 8)), 0, 8);
$passwordhash = create_hash($password);
	global $db;
	$data = array(
				'username' =>	$username,
				'password' =>	$passwordhash,
				'email_address' =>	$email_address,
				'first_name' =>	$first_name, 
				'last_name' =>	$last_name, 
				'phone' =>	$phone,
				'user_type' =>	'3',
				'agent_id' =>	NULL
				);
	//should do some kind of security checks to prevent duplicate entries...(not in scope)
	$id = $db->insert('users', $data);
	//email user a password
	if($id){
		$resultEmail = emailAccount($data, $password);
		if($resultEmail){
			return $id;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function emailAccount($data, $password){
	date_default_timezone_set('America/New_York');
	$today = date("F j, Y, g:i a T");  
	require_once 'PHPMailer/PHPMailerAutoload.php';
	$msg = "Here is your login info for earthpaysystems <br />
		username: ".$data['username']."<br />
		password: ".$password."<br />
		<br />
		This request was made on ".$today."
		<br /><br />
		Regards,<br />
		earthpaysystems<br />
		Note: To ensure delivery to your inbox (not bulk or junk folders), please add noreply@earthpaysystems.com to your address book.";
	
	$results_messages = array();
	 
	$mail = new PHPMailer(true);
	$mail->CharSet = 'utf-8';
	 
	class phpmailerAppException extends phpmailerException {}
	 
	try {
	$to = $data['email_address'];
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
	$mail->addAddress($data['email_address'], $data['first_name'].' '.$data['last_name']);
	$mail->Subject  = "Account Login Information";
	$mail->msgHTML($msg); //Create message bodies and embed images
	 
	try {
	  $mail->send();
	  $results_messages[] = "Message has been sent using MAIL";
	}
	catch (phpmailerException $e) {
	  throw new phpmailerAppException('Unable to send to: ' . $to. ': '.$e->getMessage());
	}
	}
	catch (phpmailerAppException $e) {
	  $results_messages[] = $e->errorMessage();
	}
	 //var_dump($results_messages); 
	if (count($results_messages) > 0) {
		return true;
	}else{
		return true;
	 }
}
function addAgent($vars){
//do insert database for all the variables inside the agent table
	global $db;
	//should do some kind of security checks to prevent duplicate entries...(not in scope)
	$id = $db->insert('agents', $vars);
	if($id){
		//return id agentid
		return $id;
	}else{
		return false;
	}
	
}
?>