<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 25-11-2017
 * Time: 05:37 PM
 */

unset($_SESSION["mangaaaa"]);
session_destroy();
if($_POST['env']!='livem' && $_POST['env']!='testm') {
    ?>

    <br>
    <center></h4>Processing Visa/Mastercard Payment </h4></center>
    <?php
}
$postdata='{ ';
if($_POST["transType"]=="02" && $_POST["revResCode"]=='32') {
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "paymentIndicator") {
            $postdata .= '"' . $key . '" : "' . $value . '",';

        }

    }
}
else if($_POST["transType"]=="02") {
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "paymentIndicator" && $key != "partialRevAmt") {
            $postdata .= '"' . $key . '" : "' . $value . '",';

        }

    }
}
else if($_POST["transType"]=="28"){
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "revDateAndTime"  && $key != "revResCode" && $key != "partialRevAmt" && $key != "transactionID") {
            $postdata .= '"' . $key . '" : "' . $value . '",';

        }

    }
}
else if($_POST["transType"]=="20"){
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "paymentIndicator" && $key != "partialRevAmt") {
            $postdata .= '"' . $key . '" : "' . $value . '",';

        }

    }
}
else {
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "revDateAndTime" && $key != "paymentIndicator" && $key != "revResCode" && $key != "partialRevAmt") {
            $postdata .= '"' . $key . '" : "' . $value . '",';

        }

    }
}
$postdata=substr($postdata, 0,-1);
$postdata.=' }';

$postdatalog='{ ';
if($_POST["transType"]=="02" && $_POST["revResCode"]=='32') {
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "paymentIndicator") {
            if($key=="cardNo"){
				$newval = substr_replace($value, str_repeat("X", 8), 4, 12);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else if($key=="cvv2"){
				$newval = substr_replace($value, str_repeat("X", 3), 0, 3);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else {
				$postdatalog .= '"' . $key . '" : "' . $value . '",';
			}
        }

    }
}
else if($_POST["transType"]=="02") {
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "paymentIndicator" && $key != "partialRevAmt") {
            if($key=="cardNo"){
				$newval = substr_replace($value, str_repeat("X", 8), 4, 12);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else if($key=="cvv2"){
				$newval = substr_replace($value, str_repeat("X", 3), 0, 3);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else {
				$postdatalog .= '"' . $key . '" : "' . $value . '",';
			}
        }

    }
}
else if($_POST["transType"]=="28"){
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "revDateAndTime"  && $key != "revResCode" && $key != "partialRevAmt" && $key != "transactionID") {
            if($key=="cardNo"){
				$newval = substr_replace($value, str_repeat("X", 8), 4, 12);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else if($key=="cvv2"){
				$newval = substr_replace($value, str_repeat("X", 3), 0, 3);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else {
				$postdatalog .= '"' . $key . '" : "' . $value . '",';
			}
        }

    }
}
else if($_POST["transType"]=="20"){
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "paymentIndicator" && $key != "partialRevAmt") {
            if($key=="cardNo"){
				$newval = substr_replace($value, str_repeat("X", 8), 4, 12);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else if($key=="cvv2"){
				$newval = substr_replace($value, str_repeat("X", 3), 0, 3);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else {
				$postdatalog .= '"' . $key . '" : "' . $value . '",';
			}
        }

    }
}
else {
    foreach ($_POST as $key => $value) {
        if ($key != "appredirect" && $key != "transactionid" && $key != "action_id" && $key != "redirectionurl" && $key != "env" && $key != "revDateAndTime" && $key != "paymentIndicator" && $key != "revResCode" && $key != "partialRevAmt") {
			if($key=="cardNo"){
				$newval = substr_replace($value, str_repeat("X", 8), 4, 12);	
				$postdatalog .='"' . $key . '" : "' . $newval . '",';
			}
			else if($key=="cvv2"){
				$newval = substr_replace($value, str_repeat("X", 3), 0, 3);	
				$postdatalog .= '"' . $key . '" : "' . $newval . '",';
			}
			else {
				$postdatalog .= '"' . $key . '" : "' . $value . '",';
			}

        }

    }
}
$postdatalog=substr($postdatalog, 0,-1);
$postdatalog.=' }';
//print_r($postdata);
//$postdata=json_encode($postdata[]);
/*print_r($postdata);
//$my_array = json_decode($output);
echo "<br>";
//print_r($my_array);
exit;*/
if($_POST['env']!="testm" && $_POST['env']!="livem") {
    $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$postdatalog."";
    $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
}
else {
    $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$postdatalog."";
    $myfile = file_put_contents('merchantapiMLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
}

$ch = curl_init();                    // Initiate cURL
$url = "https://10.162.104.199:9600/TTSwitchOnPG_API/authRequest"; // Where you want to post data
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_PORT, "9600");
curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_CAINFO, '/usr/lib/jvm/java-8-openjdk-amd64/jre/lib/security/cacerts');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("cache-control: no-cache","Content-Type:  application/json"));
curl_setopt($ch, CURLOPT_POST, true);  // Tell cURL you want to post something
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); // Define what you want to post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the output in string format
curl_setopt($ch, CURLOPT_TIMEOUT, 40); //Timer for 40 sec
$output = curl_exec ($ch); // Execute
/*print_r($postdata);
$my_array = json_decode($output);
echo "<br>";
print_r($my_array);
echo "cURL Error: " . curl_error($ch);
exit;
//$my_array->refNbr;*/

if(curl_errno($ch))
{
    $ch = curl_init();                    // Initiate cURL
    $url = "https://10.162.104.199:9600/TTSwitchOnPG_API/authRequest"; // Where you want to post data
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_PORT, "9600");
    curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_CAINFO, '/usr/lib/jvm/java-8-openjdk-amd64/jre/lib/security/cacerts');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("cache-control: no-cache","Content-Type:  application/json"));
    curl_setopt($ch, CURLOPT_POST, true);  // Tell cURL you want to post something
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); // Define what you want to post
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the output in string format
    curl_setopt($ch, CURLOPT_TIMEOUT, 65); //Timer for 65 sec
    $output = curl_exec ($ch); // Execute
    if(curl_errno($ch)) {
        if($_POST['env']=='livem' || $_POST['env']=='testm'){
            $afm=array(
				"author" => "xxxx",
                "status" => "FAILURE",
                "errorcode" => "203",
                //"errordesc " => "Initiate response failed",
                "apprcode" => 0,
				"refNbr" => 0,
                "RRN" => 0

            );
            echo json_encode($afm);
            exit;
        }
        else {

            header('Location: ' . $_POST["appredirect"] . '/resp.php?success=true&txn=null&errordesc=Transaction OGS timeout&rrurl=' . $_POST["redirectionurl"]);
        }
    }
    curl_close ($ch);
    // Close cURL handle

    $my_array = json_decode($output);
    /*print_r($postdata);
    echo "<br>";
    print_r($my_array);
    exit;
    //$my_array->refNbr;*/
    if($_POST['env']!="testm" && $_POST['env']!="livem") {
        $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$output."";
        $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    else {
        $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$output."";
        $myfile = file_put_contents('merchantapiMLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
    $respCode=$my_array->respCode;
    //print_r($respCode);
    if($respCode == "00"){
        $refNbr=$my_array->refNbr;
        $RRN=$my_array->RRN;
        $authNbr=$my_array->authNbr;
        $actionid=$_POST['action_id'];
        $tid=$_POST['tid'];
        $terminalId=$_POST['terminalId'];
        $transactionid=$_POST['transactionid'];


        if($_POST['env']=='livem' || $_POST['env']=='testm'){
            $afm=array(
                  "author" => "xxxx",
                    "status" => "success",
                       "errorcode" => $respCode,
                    "apprcode" => $authNbr ,
                "refNbr" => $refNbr,
                "RRN" => $RRN

            );
            echo json_encode($afm);
            exit;
        }
        else {
            header('Location: http://169.38.91.254/api/savetraninfo.php?tid=' . $tid . '&transactionid=' . $transactionid . '&terminalId=' . $terminalId . '&authNbr=' . $authNbr . '&refNbr='
                . $refNbr . '&RRN=' . $RRN . '&env=' . $_POST["env"] . '&appredirect=' . $_POST["appredirect"] . '&actionid=' . $actionid . '&respCode=' . $respCode . '&redirectionurl=' . $_POST["redirectionurl"]
                . '&success=true');
            //header('Location: '.$_POST["appredirect"].'/resp.php?success=true&txn='.$tid.'&errordesc=Transaction Success&rrurl='.$_POST["redirectionurl"]);
            //window.location = appredirect + '/resp.php?success=true&txn='+tid+'&errordesc=Transaction Success&rrurl='+redirectionurl;
        }
    }
    else {
        $refNbr=$my_array->refNbr;
        $RRN=$my_array->RRN;
        $authNbr="";
        $actionid=$_POST['action_id'];
        $tid=$_POST['tid'];
        $transactionid=$_POST['transactionid'];
        $terminalId=$_POST['terminalId'];

        /*
        if ($conn->query($sql) === TRUE) {
            echo 1;
        } else {
            echo 0;
        }
        */
        if($_POST['env']=='livem' || $_POST['env']=='testm'){
            $afm=array(
                 "author" => "xxxx",
                    "status" => "FAILURE",
                       "errorcode" => $respCode,
                    "apprcode" => $authNbr ,
                "refNbr" => $refNbr,
                "RRN" => $RRN

            );
            echo json_encode($afm);
            exit;
        }
        else {
            header('Location: http://169.38.91.254/api/savetraninfo.php?tid=' . $tid . '&transactionid=' . $transactionid . '&terminalId=' . $terminalId . '&authNbr=' . $authNbr . '&refNbr='
                . $refNbr . '&RRN=' . $RRN . '&env=' . $_POST["env"] . '&appredirect=' . $_POST["appredirect"] . '&actionid=' . $actionid . '&respCode=' . $respCode . '&redirectionurl=' . $_POST["redirectionurl"]
                . '&success=false');

            //header('Location: '.$_POST["appredirect"].'/resp.php?success=false&txn='.$tid.'&errordesc=Transaction Failed&rrurl='.$_POST["redirectionurl"]);
            //window.location = appredirect + '/resp.php?success=false&txn=null&errordesc=Transaction Failed&rrurl='+redirectionurl;
        }
    }
}
else {
    curl_close ($ch);
    // Close cURL handle

    $my_array = json_decode($output);
    if($_POST['env']!="testm" && $_POST['env']!="livem") {
        $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$output."";
        $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    else {
        $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$output."";
        $myfile = file_put_contents('merchantapiMLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
    /*$my_array = json_decode($output);
    print_r($postdata);
    echo "<br>";
    print_r($my_array);
    exit;
    $respCode=$my_array->respCode;
    //print_r($respCode);*/
    $respCode=$my_array->respCode;
    if($respCode == "00"){
        $refNbr=$my_array->refNbr;
        $RRN=$my_array->RRN;
        $authNbr=$my_array->authNbr;
        $actionid=$_POST['action_id'];
        $tid=$_POST['tid'];
        $terminalId=$_POST['terminalId'];
        $transactionid=$_POST['transactionid'];

        if($_POST['env']=='livem' || $_POST['env']=='testm'){
            $afm=array(
                "author" => "xxxx",
                    "status" => "success",
                       "errorcode" => $respCode,
                    "apprcode" => $authNbr ,
                "refNbr" => $refNbr,
                "RRN" => $RRN

            );
            echo json_encode($afm);
            exit;
        }
        else {
            header('Location: http://169.38.91.254/api/savetraninfo.php?tid=' . $tid . '&transactionid=' . $transactionid . '&terminalId=' . $terminalId . '&authNbr=' . $authNbr . '&refNbr='
                . $refNbr . '&RRN=' . $RRN . '&env=' . $_POST["env"] . '&appredirect=' . $_POST["appredirect"] . '&actionid=' . $actionid . '&respCode=' . $respCode . '&redirectionurl=' . $_POST["redirectionurl"]
                . '&success=true');
            //header('Location: '.$_POST["appredirect"].'/resp.php?success=true&txn='.$tid.'&errordesc=Transaction Success&rrurl='.$_POST["redirectionurl"]);
            //window.location = appredirect + '/resp.php?success=true&txn='+tid+'&errordesc=Transaction Success&rrurl='+redirectionurl;
        }
    }
    else {
        $refNbr=$my_array->refNbr;
        $RRN=$my_array->RRN;
        $authNbr="";
        $actionid=$_POST['action_id'];
        $tid=$_POST['tid'];
        $transactionid=$_POST['transactionid'];
        $terminalId=$_POST['terminalId'];

        /*
        if ($conn->query($sql) === TRUE) {
            echo 1;
        } else {
            echo 0;
        }
        */
        if($_POST['env']=='livem' || $_POST['env']=='testm'){
            $afm=array(
                "author" => "xxxx",
                    "status" => "FAILURE",
                       "errorcode" => $respCode,
                    "apprcode" => $authNbr ,
                "refNbr" => $refNbr,
                "RRN" => $RRN

            );
            echo json_encode($afm);
            exit;
        }
        else {
            header('Location: http://169.38.91.254/api/savetraninfo.php?tid=' . $tid . '&transactionid=' . $transactionid . '&terminalId=' . $terminalId . '&authNbr=' . $authNbr . '&refNbr='
                . $refNbr . '&RRN=' . $RRN . '&env=' . $_POST["env"] . '&appredirect=' . $_POST["appredirect"] . '&actionid=' . $actionid . '&respCode=' . $respCode . '&redirectionurl=' . $_POST["redirectionurl"]
                . '&success=false');

            //header('Location: '.$_POST["appredirect"].'/resp.php?success=false&txn='.$tid.'&errordesc=Transaction Failed&rrurl='.$_POST["redirectionurl"]);
            //window.location = appredirect + '/resp.php?success=false&txn=null&errordesc=Transaction Failed&rrurl='+redirectionurl;
        }
    }
}


?>