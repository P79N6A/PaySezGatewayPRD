<?php
//error_reporting(0);

$data = array();

//should do check here to see if they merchant_processor_mid is enabled to use or not.
$calback = $_POST['callback'];
$refNbr = $_POST['refNbr'];
$respCode = $_POST['respCode'];
$RRN = $_POST['RRN'];
$walletId = $_POST['walletId'];
$transTypeN = $_POST['transType'];
$merchantId = $_POST['merchantId'];
$terminalId = $_POST['terminalId'];
$city = $_POST['city'];
$state = $_POST['state'];
$tinn = $_POST['tinn'];
$token = $_POST['token'];
$transAmount = $_POST['transAmount'];
$transCurrCode = $_POST['transCurrCode'];
$cvv2 = $_POST['cvv2'];
$transCountryCode = $_POST['transCountryCode'];
$dateAndTime = $_POST['dateAndTime'];
$localDate = $_POST['localDate'];
$localTime = $_POST['localTime'];
$expDate = $_POST['expDate'];
$Source = $_POST['Source'];
$MCC = $_POST['MCC'];

            $data = Array(
                "apptype" => $calback,
                "action" => $refNbr,
                "superinst" => $respCode,
                "superinstname" => $RRN,
                "superinst" => $walletId,
                "instname" => $transTypeN,
                "instid" => $merchantId,
                "supermercname" => $terminalId,
                "supermerc" => $city,
                "sponsorname" => $state,
                "sponsorbankid" => $tinn,
                "merchantname" => $token,
                "merchantid" => $transAmount,
                "mso_status" => $transCurrCode,
                "mso_status_date" => $cvv2,
                "mso_merchant_id" => $transCountryCode,
                "mso_region" => $dateAndTime,
                "mso_type" => $localDate,
                "mso_business_nature" => $localTime,
                "mso_mcc" => $expDate,
                "mds_schg_flat" => $Source,
                "mds_schg_percent" => $MCC


            );
            //$id_transaction_id = $db->insert('merchant_api', $data);

            $resdesc='Merchant added';
            $success='S';
            //header('Location: '.$calback.'?refNbr='.$refNbr.'&RRN='.$RRN.'&respCode=00');

?>
<html>
<form action="<?php echo $calback; ?>" id="sub" method="post">
    <input type="hidden" name="refNbr" value="<?php echo $refNbr; ?>">
    <input type="hidden" name="RRN" value="<?php echo $RRN; ?>">
    <input type="hidden" name="respCode" value="<?php echo '00'; ?>">
</form>

</html>

<script type="text/javascript">

    setTimeout(function(){ document.getElementById("sub").submit(); }, 1000);

</script>
