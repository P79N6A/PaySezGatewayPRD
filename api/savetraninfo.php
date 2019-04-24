<?php
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 25-11-2017
 * Time: 07:54 PM
 */

$duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
$dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";

require_once('encrypt.php');

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$servername = "localhost";
$username = $userd;
$password = $passd;
$dbname = "rebanx";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$refNbr=$_GET['refNbr'] ;
$RRN=$_GET['RRN'];
$respCode=$_GET['respCode'];
$authNbr=$_GET['authNbr'];
$actionid=$_GET['actionid'];
$tid=$_GET['tid'];
$appredirect=$_GET['appredirect'];
$transactionid=$_GET['transactionid'];
$redirectionurl=$_GET['redirectionurl'];
$terminalId=$_GET['terminalId'];
$env=$_GET['env'];

if($env!="testm" && $env!="livem") {
    $log = date("Y-m-d H:i:sa") . "\n\n
    -------------Response Master/visa------------------  \n\nrespcode=" . $respCode . " \nauthNbr=".$authNbr."\n\n";
    $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
}
else {
    $log = date("Y-m-d H:i:sa") . "\n\n
    -------------Response Master/visa------------------ \n\nrespcode=" . $respCode . " \nauthNbr=".$authNbr."\n\n";
    $myfile = file_put_contents('merchantapiMLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
}

$sqlresp = 'select * from errorhandle where e_code="'.$respCode.'"';
$eresp=$conn->query($sqlresp);
$t=$eresp->fetch_assoc();
$edesc=$t['e_desc'];

if ($respCode == "00") {
    $sql = 'UPDATE transactions SET  error_code ="'.$respCode.'", appr_code ="'.$authNbr.'", retrvl_refno ="'.$RRN.'", tid ="'.$terminalId.'", sys_trace_audit_no ="'.$refNbr.'" WHERE 
id_transaction_id="'.$transactionid.'"';
    $conn->query($sql);

    $sql1 = 'UPDATE actions SET success ="success", response_text ="'.$edesc.'", processor_transaction_timestamp ="'.date('h:m:i').'", processor_settlement_date ="'.date('Y-m-d').'" WHERE action_id="'.$actionid.'"';

    $conn->query($sql1);

    header('Location: '.$appredirect.'/resp.php?success=true&txn='.$tid.'&errordesc='.$edesc.'&rrurl='.$redirectionurl);
} else {

    $sql = 'UPDATE transactions SET  error_code ="'.$respCode.'", appr_code ="'.$authNbr.'", retrvl_refno ="'.$RRN.'", tid ="'.$terminalId.'", sys_trace_audit_no ="'.$refNbr.'" WHERE 
id_transaction_id="'.$transactionid.'"';
    $conn->query($sql);

    $sql1 = 'UPDATE actions SET success ="failed", response_text ="'.$edesc.'", processor_transaction_timestamp ="'.date('h:m:i').'", 
processor_settlement_date ="'.date('Y-m-d').'" WHERE action_id="'.$actionid.'"';

    $conn->query($sql1);

    if($respCode==''){
        header('Location: '.$appredirect.'/resp.php?success=false&txn=null&errordesc=Unknown Error&rrurl='.$redirectionurl);
    }
    else {
        header('Location: '.$appredirect.'/resp.php?success=false&txn=null&errordesc='.$edesc.'&rrurl='.$redirectionurl);
    }

}
?>