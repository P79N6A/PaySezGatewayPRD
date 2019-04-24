<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 26-08-2017
 * Time: 02:52 PM
 */
error_reporting(0);
session_start();
require_once('encrypt.php');
//echo $_SESSION['loaded'];
if ($_SESSION['mangaaaa']=="yes")
{
    // insert query here
    $_SESSION['mangaaaa'] = "";
    unset($_SESSION["mangaaaa"]);
    session_destroy();
    //header('Refresh:1; url= responsemerchant.php?success=false&trans=cancel&txn=null&errordesc=');
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<br>
<div class="container">
    <div class='row'>
    </div>
    <hr class="featurette-divider"></hr>
    <?php if($_GET['rurl']!=""){
    if($_POST['authenticationStatus']=="Y" || $_POST['authenticationStatus']=="A"){
        $conurl=hex2bin($_GET['rurl']).'&success=true&txn='.$_POST['transactionId'];
    }
    else {
        $conurl=hex2bin($_GET['rurl']).'&success=false&txn=null';
    }

    ?>
    <form action="<?php echo $conurl; ?>" id="frm1" method="POST">
        <?php
        }
        else {
        $urll=$_GET['url']; ?>
        <form action="<?php echo $urll.'&success=false&txn=null'; ?>" id="frm1" method="POST">
            <?php
            }
            ?>


            <?php if($_GET['success']!="true"){

            /*$errorcode=$_GET['errordesc'];
            if($errorcode=="55")
            {
                $errormessage="Incorrect personal identification number";
            }
            else if($errorcode=="75")
            {
                $errormessage="Allowable number of PIN tries exceeded, decline";
            }
            else if($errorcode=="51")
            {
                $errormessage="Not sufficient funds.";
            }
            else if($errorcode=="41")
            {
                $errormessage="Lost card, capture.";
            }
            else if($errorcode=="43")
            {
                $errormessage="Stolen card, capture.";
            }
            else if($errorcode=="05")
            {
                $errormessage="Do not honour/inactive accorunt/Dormant Account";
            }
            else if($errorcode=="54")
            {
                $errormessage="Expired card, decline";
            }
            else if($errorcode=="61")
            {
                $errormessage="Exceeds withdrawal amount limit.";
            }
            else if($errorcode=="65")
            {
                $errormessage="Exceeds withdrawal frequency limit.";
            }
            else if($errorcode=="CI")
            {
                $errormessage="Compliance error code for issuer";
            }
            */
            ?>


            <div class='row'>
                <div class='col-md-4'></div>
                <div class='col-md-4 text-center'>
                    <div id="canceldiv" style="">
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <?php if($_POST['details']!=""){ ?>
                                <h4><b><br><?php if($_POST['details']!=""){ echo $_POST['details']; } //$errormessage;?><br><br>
                                        <?php if($_POST['authenticationStatus']=="Y" || $_POST['authenticationStatus']=="A"){ echo 'Transaction Successfull. Click OK to Redirect merchant url.'; } ?>
                                    </b></h4>
                            <?php } else { ?>
                                <h4><b>Transaction was <?php if($_GET['trans']=="cancel"){ echo "Cancelled"; } else if($_GET['trans']=="inactive"){ echo "Timed Out"; } else{ echo "Declined "; } ?><br><?php if($_GET['errordesc']!=""){ echo $_GET['errordesc']; } //$errormessage;?></b></h4> &nbsp; &nbsp; &nbsp;
                            <?php } ?>
                            <button type="hidden" value="submit">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
</div>
<?php } ?>
<input type="hidden" name="success" value="<?php if($_GET['success']==""){ echo "false"; } else { echo $_GET['success']; }?>"/>
<input type="hidden" name="txn" value="<?php if($_GET['success']=="false"){ echo "0"; } else { echo $_GET['txn']; }?>"/>
<input type="hidden" name="errordesc" value="<?php echo $_GET['errordesc']; ?>"/>
</form>
<?php
/*
echo 'merchantId:'.$_POST['merchantId'].'<br>';
echo 'transactionId:'.$_POST['transactionId'].'<br>';
echo 'enrollmentStatus:'.$_POST['enrollmentStatus'].'<br>';
echo 'authenticationStatus:'.$_POST['authenticationStatus'].'<br>';
echo 'details:'.$_POST['details'].'<br>';
echo 'xid:'.$_POST['xid'].'<br>';
echo 'eci:'.$_POST['eci'].'<br>';
echo 'cavv:'.$_POST['cavv'].'<br>';
echo 'cavvAlg:'.$_POST['cavvAlg'].'<br>';
echo 'mac:'.$_POST['mac'].'<br>';
*/
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
		
$redirectionurl=$_GET['url'];
/*
print_r($redirectionurl);
$redirectionurl=hex2bin($redirectionurl);
print_r($redirectionurl);
exit;
*/
foreach ($_POST as $key => $value) {
        $postdata .= '"' . $key . '" : "' . $value . '",';
}

$logtosend='postvalue='.$postdata.'&env='.$_GET["env"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/loginsert.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $logtosend);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close($ch);
/*
if($_POST['env']!="testm" && $_POST['env']!="livem") {
    $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$postdata."";
    $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
}
else {
    $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------".$postdata."";
    $myfile = file_put_contents('merchantapiMLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
}
*/
$duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
$dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";

$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

$servername = "localhost";
$username = $userd;
$password = $passd;
$dbname = "rebanx";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$trid=$_POST['transactionId'];
$sqlresp = 'select * from transactions where id_transaction_id="'.$trid.'"';
$eresp=$conn->query($sqlresp);
$t=$eresp->fetch_assoc();

//hash get
$htid=$t['id_transaction_id'];
$sqlresphash = 'select * from hash_tab where t_id="'.$htid.'"';
$eresphash=$conn->query($sqlresphash);
$ttt=$eresphash->fetch_assoc();

$edesc=$t['e_desc'];
$trans_date_time=$t['trans_date_time'];
$retrvl_refno=$t['retrvl_refno'];

$amt=sprintf('%012d',$t['amount']);
$sys_trace_audit_no=$t['sys_trace_audit_no'];
$localtrans_time=$t['localtrans_time'];
$localtrans_date=$t['localtrans_date'];
$localtrans_date=$t['localtrans_date'];
$cc_number=$t['cc_number'];
$cc_hash=$ttt['hash_value'];
$expd=$t['exp_date'];
//$cvd2=$t['cavv'];
$cvd2=$_GET['cvv2'];
//$cvd2=hex2bin($cvd2);
//$AAV=substr($_POST['cavv'], -27);
$AAV=$_POST['cavv'];
$cavvalg=sprintf('%03d',$_POST['cavvAlg']);
$AID="00201000005";
$ECIindicator=$_POST['eci'];
$country_code='356';

$mmmid=$_POST['merchantId'];
$sqlresp = 'select * from merchants where mer_map_id="'.$mmmid.'"';
$eresp=$conn->query($sqlresp);
$t=$eresp->fetch_assoc();
$mcc=$t['mcc'];
$tid=$t['terid'];
/*
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}
*/
$cc_num=mc_decrypt($cc_number, $cc_hash);
$appredirect='http://169.38.91.250';
$currency_code="356";

//$addrs	= $t['merchant_name'].$t['address1'].$t['address2'];
$addrs	= $t['merchant_name'];
$city	= $t['city'];
if($city=="null")
{
    $city="";
}
$state= $t['us_state'];
$country= $t['country'];
$length2 = strlen($addrs);
$length3 = strlen($city);
$length4 = strlen($state);
$length5 = strlen($country);

//$card_acc_name_loc1=substr($addrs.$city.$state.$country,0,40);
// address 23 chars
if ($length2 < 23) {
    $addrs .= str_repeat(' ', 23 - $length2);
} else {
    $addrs = substr($addrs, 0, 23);
}
 
// city 13 chars
if ($length3 < 13) {
    $city .= str_repeat(' ', 13 - $length3);
} else {
    $city = substr($city, 0, 13);
}

// state 2 chars
if ($length4 < 2) {
    $state .= str_repeat(' ', 2 - $length4);
} else {
    $state = substr($state, 0, 2);
}

// country 2 chars
if ($length5 < 2) {
    $country .= str_repeat(' ', 2 - $length5);
} else {
    $country = substr($country, 0, 2);
}

$card_acc_name_loc=$addrs.$city.$state.$country;
//$card_acc_name_loc="ABCD Service and PerfecChennai      TNIN";

?>
<form id="myFormvisa" action="http://169.38.91.250/api/visaprocess.php" method="post">
    <input type="hidden" name="Source" value="<?php if($_POST['Source']!="") echo $_POST['Source']; else echo '2'; ?>">
    <input type="hidden" name="walletId" value="<?php echo '0';  ?>">
    <input type="hidden" name="transType" value="<?php if($_POST['transType']!="") echo $_POST['transType']; else echo '00'; ?>">
    <input type="hidden" name="merchantId" value="<?php echo $_POST['merchantId']; ?>">
    <input type="hidden" name="terminalId" value="<?php echo $tid; ?>">
    <!--<input type="hidden" name="merchLocation" value="ABCD Service and PerfecChennai      TNIN">-->
 <input type="hidden" name="merchLocation" value="<?php echo $card_acc_name_loc; ?>">
    <input type="hidden" name="MCC" value="<?php echo $mcc; ?>">
            <input type="hidden" name="transAmount" value="<?php echo $amt; ?>">
            <input type="hidden" name="transCurrCode" value="<?php echo $currency_code; ?>">
            <input type="hidden" name="transCountryCode" value="<?php echo $currency_code; ?>">
            <input type="hidden" name="RRN" value="<?php echo $retrvl_refno; ?>">
            <input type="hidden" name="dateAndTime" value="<?php echo $trans_date_time; ?>">
            <input type="hidden" name="refNbr" value="<?php echo $sys_trace_audit_no; ?>">
            <input type="hidden" name="localDate" value="<?php echo $localtrans_date; ?>">
            <input type="hidden" name="localTime" value="<?php echo $localtrans_time; ?>">
            <input type="hidden" name="cardNo" value="<?php echo $cc_num; ?>">
            <input type="hidden" name="cvv2" value="<?php echo $cvd2; ?>">
            <input type="hidden" name="expDate" value="<?php echo $expd;?>">
            <input type="hidden" name="CAVV" value="<?php if($cavvalg!="") echo $cavvalg; else  echo '000';?>">
            <input type="hidden" name="ECIindicator" value="<?php if($ECIindicator!="") echo $ECIindicator; else  echo '05'; ?>">
            <input type="hidden" name="AuthenticationIndicatorflag" value="<?php echo 'N';?>">
            <input type="hidden" name="appredirect" value="<?php echo $appredirect;?>">
            <input type="hidden" name="transactionId" value="<?php echo sprintf('%011d',$trid)  ;?>">
            <input type="hidden" name="action_id" value="<?php echo $action_id;?>">
            <input type="hidden" name="redirectionurl" value="<?php echo $redirectionurl;?>">
            <input type="hidden" name="revDateAndTime" value="<?php echo $_POST['revDateAndTime'];?>">
            <input type="hidden" name="env" value="<?php echo 'live';?>">
            <input type="hidden" name="paymentIndicator" value="<?php if($_POST['paymentIndicator']!="") echo $_POST['paymentIndicator']; else echo ""; ?>">
            <input type="hidden" name="revResCode" value="<?php if($_POST['revResCode']!="") echo $_POST['revResCode']; else echo ""; ?>">
            <input type="hidden" name="partialRevAmt" value="<?php if($_POST['partialRevAmt']!="") echo $_POST['partialRevAmt']; else echo ""; ?>">

            <input type="hidden" name="AAV" value="<?php if($AAV!="") echo $AAV; else echo ""; ?>">
            <input type="hidden" name="AID" value="<?php if($AID!="") echo $AID; else echo ""; ?>">
            <?php
            $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------\n\npayindicator=".$pindi."\nsource=".$source."\nmerchantid=" . $mmerch . " \ntid=".$tid." \nmerchloca=".$card_acc_name_loc."\nmerchloca2=".$card_acc_name_loc1."\nmcc=".$mappedmcc."\namt=".$amt." \ncurrency=".$currency_code."\nRRN=".$retrieval_ref_number."\ntrandatetime=".$trandt."\nrefNbr=".$stan."\ntrandate=".$tran_date."\ntrantime=".$tran_time."\n\nexpdate=".$expdt."\nappredirect=".$appredirect."\ntable_id=".$id_transaction_id."\nactionid=".$action_id."\nredirect=".$redirectionurl."\n".$addrs."\n".$city."\n".$state."\n".$country."\nAVV=".$AAV."\n\n";
            $logtosend='postvalue='.rawurlencode($log).'&env=live';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://169.38.91.251/api/loginsert.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $logtosend);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
            /*
            if($env!="testm" && $env!="livem") {
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------\n\npayindicator=".$pindi."\nsource=".$source."\nmerchantid=" . $mmerch . " \ntid=".$tid." \nmerchloca=".$card_acc_name_loc."\nmerchloca2=".$card_acc_name_loc1."\nmcc=".$mappedmcc."\namt=".$amt." \ncurrency=".$currency_code."\nRRN=".$retrieval_ref_number."\ntrandatetime=".$trandt."\nrefNbr=".$stan."\ntrandate=".$tran_date."\ntrantime=".$tran_time."\n\nexpdate=".$expdt."\nappredirect=".$appredirect."\ntable_id=".$id_transaction_id."\nactionid=".$action_id."\nredirect=".$redirectionurl."\n".$addrs."\n".$city."\n".$state."\n".$country."\nAVV=".$AAV."\n\n";
                $myfile = file_put_contents('merchantapiLOG.log', $log . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            else {
                $log = date("Y-m-d H:i:sa") . "\n\n
            -----------------------------------\n\npayindicator=".$pindi."\nsource=".$source."\nmerchantid=" . $mmerch . " \ntid=".$tid." \nmerchloca=".$card_acc_name_loc."\nmerchloca2=".$card_acc_name_loc1."\nmcc=".$mappedmcc."\namt=".$amt." \ncurrency=".$currency_code."\nRRN=".$retrieval_ref_number."\ntrandatetime=".$trandt."\nrefNbr=".$stan."\ntrandate=".$tran_date."\ntrantime=".$tran_time."\n\nexpdate=".$expdt."\nappredirect=".$appredirect."\ntable_id=".$id_transaction_id."\nactionid=".$action_id."\nredirect=".$redirectionurl."\n".$addrs."\n".$city."\n".$state."\n".$country."\nAVV=".$AAV."\n\n";
                $myfile = file_put_contents('merchantapiMLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
            }
            */
            ?>
            <?php /*
            foreach ($_POST as $a => $b) {
                echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
            }
             */
    ?>
        </form>


        <script type="text/javascript">
            document.getElementById('myFormvisa').submit();
        </script>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    $(document).ready(function()
    {
        <?php if($_GET['success']=="true"){ ?>
        $("#frm1").submit();
        <?php } ?>
    });
</script>
