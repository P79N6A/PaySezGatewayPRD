<?php

//ini_set( 'display_errors', 1 );
//error_reporting( E_ALL );
//require_once('database_config.php');
require_once('MysqliDb.php');
//error_reporting(E_ALL);
define('SITEURL', 'http://www.earthpaysystems.com/');
require_once('passwordhash.php');
$data = array();
//$db = new Mysqlidb('10.10.90.5', 'root', '25kUHbWZTA', 'profitorius');
$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
session_start();

function loginUser($username, $password)
{
    global $db;
    $db->where("username", $username);
    //$db->where("password",$password);
    $data = $db->getOne("users");
    //$password = 'test';
    //$correct_hash = create_hash($password);
    //echo 'the hash is: '.$correct_hash.'<br />';
    //$valide = validate_password($password, $correct_hash);
    //echo 'the valide is: '.$valide;
    //var_dump($data);
    $result = validate_password($password, $data['password']);

    //die();
    if ($result == 1)
    {
        return $data;
    }
    else
    {
        return false;
    }
    /*
      if($db->count > 0){
      return $data;
      }else{
      return false;
      }
     */
}

function forgotPass($email, $username)
{
    include_once ('PHPMailer/PHPMailerAutoload.php');
    $results_messages = array();
    $today = date("F j, Y, g:i a T");
    //$username = getUsernameByEmail($email);
    $fpstring = fpstring($username);
    $mail = new PHPMailer(true);
    $mail->CharSet = 'utf-8';

    //var_dump($email); 

    class phpmailerAppException extends phpmailerException {
        
    }

    $to = $email;
    $mail->isSMTP(); //$mail->isMail();
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = "smtpout.secureserver.net";
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = "noreply@cardfitness.com";
    $mail->Password = "123456";
    $mail->addReplyTo("noreply@earthpaysystems.com", "earthpaysystems");
    $mail->From = "noreply@earthpaysystems.com";
    $mail->FromName = "earthpaysystems";
    $mail->addAddress($email, $username);
    $mail->Subject = "earthpaysystems Password Request";
    $body = "You recently requested a password reset for your earthpaysystems account. <br />
	Your Username is : " . $username . " in-case you forgot.<br />
	To create a new password, click on the link below:<br /><br />
	
		<a href='" . SITEURL . "forgot-password.php?fpkey=" . $fpstring . "' \>Reset My Password</a><br /><br /> or copy the following URL and paste it into your browser. <br />
		
		 " . SITEURL . "forgot-password.php?fpkey=" . $fpstring . "
		<br /><br />
		
		This request was made on " . $today . "
		<br /><br />
		
		Regards,<br />
		earthpaysystems<br />
		Note: To ensure delivery to your inbox (not bulk or junk folders), please add noreply@earthpaysystems.com to your address book.";
    $mail->WordWrap = 78;
    $mail->msgHTML($body); //Create message bodies and embed images

    $mail->send();
    $results_messages[] = "Message has been sent using MAIL";
    return true;
}

function getUsernameByEmail($email)
{
    global $db;
    $cols = Array("username");
    $db->where("email_address", $email);
    $users = $db->getOne("users", null, $cols);
    return $users['username'];
}

function ResetPass($userid, $new_hash)
{
    global $db;
    $data = array(
        'password' => $new_hash,
        'forgotpass' => NULL
    );
    $db->where('id', $userid);
    //should do some kind of security checks to prevent duplicate entries...(not in scope)
    $db->update('users', $data);
    return true;
}

function fpcheckreset($fpkey)
{
    global $db;
    $db->where("forgotpass", $fpkey);
    $users = $db->getOne("users");
    if ($db->count == 0)
    {
        return false;
    }
    return true;
}

function fpgetid($fpkey)
{
    global $db;
    $db->where("forgotpass", $fpkey);
    $users = $db->getOne("users");
    if ($db->count == 0)
    {
        return false;
    }
    return $users['id'];
}

function fpstring($username)
{
    global $db;
    if (isset($username) && strlen($username) > 0)
    {
        $today = date("F j, Y, g:i a T");
        $data = Array(
            'forgotpass' => md5($username . 'lol' . $today)
        );
        $db->where("username", $username);
        $db->update('users', $data);
        return md5($username . 'lol' . $today);
    }
}

function checkEmailUser($email, $username)
{
    global $db;
    $db->where("email_address", $email);
    $db->where("username", $username);    
    $data = $db->getOne("users");    
   
    if ($db->count == 0)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function checkAvailability($username)
{
    global $db;
    $db->where("username", $username);
    $data = $db->getOne("users");
    if ($db->count == 0 && $username != "")
    {
        return true;
    }
    else
    {
        return false;
    }
}

?>
