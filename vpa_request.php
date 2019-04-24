<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Success -->
<div id ="success_msg"class="container" style='display:none'>
  <h2><center>Response Message:</center></h2>
  <div class="alert alert-success">
    <strong>Success!</strong> 
  </div>
</div>
<!--FAIL -->
<div id ="fail_msg"class="container" style='display:none'>
  <h2><center>Response Message:</center></h2>
  <div class="alert alert-danger">
    <strong>Failure!</strong>
  </div>
</div>
<?php 
/**
 * Created by RV.
 * Date: 11-12-2018
 * Time: 17:25 PM
 */
$duser = "yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=";
$dcode = "66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=";

$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";

require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';
require_once('api/encrypt.php');
error_reporting(0);
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);

date_default_timezone_set('Asia/Kolkata');
require_once("alipay.config.php");
$db = new Mysqlidb ($confighost, $userd, $passd, $alipay_config['dataBase_con']);

$log_path = $upi_config['log-path'];

/** Log File Function starts **/
function poslogs($log) {
   GLOBAL $log_path;
$myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
return $myfile;     
}
/**  Log File Function Ends **/

/* To fetch result data as tag function - starts */
function get_from_tag($string, $start, $end) {
        $string = ' ' .$string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $test="testttt";
        return substr($string, $ini, $len);
        //return $test;
    }
/* To fetch result data as tag function - starts */

/* Data receiving from VPA request -start */ 
$txnId = $_POST['txnId'];
$txnOrigin = $_POST['txnOrigin'];
$mobileNumber = $_POST['mobileNumber'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$merchantVaddr = $_POST['merchantVaddr'];
$mcc = $_POST['mcc'];
$email = $_POST['email'];
$panNo = $_POST['panNo'];
$aadhaarNo = $_POST['aadhaarNo'];
$addressDetails = $_POST['addressDetails'];
$accountNumber = $_POST['accountNumber'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$zipcode = $_POST['zipcode'];
$accountType = $_POST['accountType'];
$ifsc = $_POST['ifsc'];
$vendorId = $_POST['vendorId'];
$reqType = $_POST['reqType'];
$merchant_id = $_POST['mer_id'];
//print_r($_POST);exit;
/* Data receiving from VPA request -end */

//#################################################//

/* Data receiving from  Transaction History -start */
$ver = $_POST['ver'];
$hts = $_POST['hts'];
$MsgId = $_POST['MsgId'];
$tts = $_POST['tts'];
$ttype = $_POST['ttype'];
$addr = $_POST['addr'];
$name = $_POST['name'];
$ptype = $_POST['ptype'];
$code = $_POST['code'];
$id = $_POST['Id'];
/* Data receiving from  Transaction History -End */

/* Request data into xml */

if($reqType == 'Create_VPA') { 
       $request_parameters ='<?xml version="1.0" encoding="UTF-8"?>
  <MerchantWebSvcReq>
  <SvcHeader>
  <txnId>'.$txnId.'</txnId><txnOrigin>'.$txnOrigin.'</txnOrigin>
  </SvcHeader>
  <txnInfo>
  <ReqType>Create_VPA</ReqType>               
  <merchantDetails>
              <mobileNumber>'.$mobileNumber.'</mobileNumber>
              <firstName>'.$firstName.'</firstName>
              <lastName>'.$lastName.'</lastName>       
              <merchantVaddr>'.$merchantVaddr.'</merchantVaddr> 
              <mcc>'.$mcc.'</mcc>
              <email>'.$email.'</email>
              <panNo>'.$panNo.'</panNo>
              <aadhaarNo>'.$aadhaarNo.'</aadhaarNo>
              <addressDetails>'.$addressDetails.'</addressDetails></merchantDetails><merchantBankDetails>
             <accountNumber>'.$accountNumber.'</accountNumber>
             <accountType>'.$accountType.'</accountType>
             <ifsc>'.$ifsc.'</ifsc></merchantBankDetails>
  </txnInfo>
  </MerchantWebSvcReq>';
      
       $request_data = date("Y-m-d H:i:s") . " UPI VPA Request Data:" . $request_parameters . " \n\n";
       poslogs($request_data);

       /*transaction table insert data*/
         $trans_parameter = array(
          'upi_req_type' => $reqType,
          'upi_txn_id' => $txnId,
          'upi_txn_origin' => $txnOrigin,
          'upi_mobile_no' => $mobileNumber,
          'upi_firstName' => $firstName,
          'upi_lastName' => $lastName,
          'upi_merchant_vaddr' => $merchantVaddr,
          'upi_merchant_id' => $merchant_id,
          'upi_mcc' => $mcc,
          'upi_email' => $email,
          'upi_panNo' => $panNo,
          'upi_aadharNo' => $aadhaarNo,
          'upi_address' => $addressDetails,
          'upi_accountNumber' => $accountNumber,
          'upi_accountType' => $accountType,
          'upi_ifsc' => $ifsc,
          'trans_datetime' => date('Y-m-d H:i:s'),
          'trans_time_gmt' => gmdate('Y-m-d H:i:s')
            );

         $trans_insert_data = date("Y-m-d H:i:s") . " UPI VPA Data Insert in table:" . $trans_parameter . " \n\n";
         poslogs($trans_insert_data);

         $vpa_request_insert = $db->insert('transaction_upi', $trans_parameter);

          /* URL to send request for VPA */
          // $upi_url = 'http://localhost:8080/UPIServices/ MerchantServices?ReqType=Create_VPA&Handle_Id=””(test)';
         // $upi_url = 'https://paymentgateway.test.credopay.in/testspaysez/mer_services_test.php?';
          //$upi_url = '182.19.52.55?';
          //$url = 'http://182.19.52.55:8080/UPIServices/MerchantServices?ReqType=Create_VPA';
          $url ='http://182.19.52.55:8081/UPIServices/MerchantServices?TxnType=Create_VPA';

         $request_url = date("Y-m-d H:i:s") . " UPI -VPA Request URL:" . $url . " \n\n";
              poslogs($request_url);

          //     $curl = curl_init();
          //    curl_setopt_array($curl, array(
          //    CURLOPT_PORT => '8080',
          //    CURLOPT_URL => $upi_url,
          //    CURLOPT_RETURNTRANSFER => true,
          //    CURLOPT_ENCODING => "",
          //    CURLOPT_MAXREDIRS => 10,
          //    CURLOPT_TIMEOUT => 30,
          //    CURLOPT_SSL_VERIFYPEER => false,
          //    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          //    CURLOPT_CUSTOMREQUEST => "POST",
          //    CURLOPT_POSTFIELDS => urlencode($request_parameters),
          //    CURLOPT_FOLLOWLOCATION => 1,
          //    CURLOPT_HTTPHEADER => array(
          //     "Cache-Control: no-cache",
          //     "Content-Type: text/xml"
          //   ),
          // ));
          // $response = curl_exec($curl);
          // $err = curl_error($curl);
          // curl_close($curl);
        //$url = "http://59.162.33.102:9301/Avalability";

        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
// Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $request_parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        //convert the XML result into array
        //$array_data = json_decode(json_encode(simplexml_load_string($response)), true);

        // print_r('<pre>');
        // print_r($array_data);
        // print_r('</pre>');
          if (curl_errno($ch)) {
            $log = date("Y-m-d H:i:s") . " UPI VPA Create Response:" . curl_errno($ch) . " \n\n";
            poslogs($log);
            echo "cURL Error #:" . curl_errno($ch);
          } else {
            $log = date("Y-m-d H:i:s") . " UPI VPA Create Response:" . $response . " \n\n";
            poslogs($log);
          }

            /*Success or Failure Response From UPI for VPA request */
            $res_txnOrigin = get_from_tag($response, '<txnOrigin>','</txnOrigin>');
            $res_errCode = get_from_tag($response, '<errCode>','</errCode>');
            $res_errDesc = get_from_tag($response, '<errDesc>','</errDesc>');
            $res_merchantID = get_from_tag($response, '<merchantID>','</merchantID>');
            $res_mobileNumber = get_from_tag($response, '<mobileNumber>','</mobileNumber>');
            $res_merchantVaddr = get_from_tag($response, '<merchantVaddr>','</merchantVaddr>');
            $res_ReqType = get_from_tag($response, '<ReqType>','</ReqType>');
            $res_status = get_from_tag($response, '<status>','</status>');

            if($res_errCode == '000' && $res_errDesc == 'SUCCESS'){
              $success_data = array(
                  "upi_txn_origin" => $res_txnOrigin,
                  "upi_err_code" => $res_errCode,
                  "upi_err_desc" => $res_errDesc,
                  "upi_merchant_id" => $res_merchantID,
                  "upi_mobile_no" => $res_mobileNumber,
                  "upi_merchant_vaddr" => $res_merchantVaddr,
                  "upi_req_type" => $res_ReqType,
                  "upi_status" => $res_status,
                  "upi_reg_active" => 1
              );
              $trans_res_sucs = date("Y-m-d H:i:s") . "UPI Transaction Response update in table:" . json_encode($success_data) . " \n\n";
                  poslogs($trans_res_sucs);

              /* Updating Transaction table after success response */
              $db->where("upi_merchant_vaddr", $res_merchantVaddr);
              $db->where("upi_req_type",$res_ReqType);
              $trans_sucs_update = $db->update('transaction_upi', $success_data);

              $merchant_status = array(
                'mer_map_id' => $res_merchantID,
                'upi_status' => 1
              );
              $db->where("affiliate_id", $res_merchantVaddr);
              $db->where("business_type",$res_ReqType);
              $merchant_status_upd = $db->update('merchants',$merchant_status);
            
              //echo $res_status;
              if($res_errDesc == 'SUCCESS'){?>
              <script type="text/javascript">$('#success_msg').show()</script>
              <?php
            }
              header( "Refresh:3;url=https://paymentgateway.test.credopay.in/testspaysez/vpa_upi_form.php");
              exit;
              }else if($res_errCode == '709' && $res_errDesc == 'FAILURE'){
                  $failure_data = array(
                  'upi_txn_origin' => $res_txnOrigin,
                  'upi_err_code' => $res_errCode,
                  'upi_err_desc' => $res_errDesc,
                  'upi_mobile_no' => $res_mobileNumber,
                  'upi_merchant_vaddr' => $res_merchantVaddr,
                  'upi_req_type' => $res_ReqType,
                  'upi_status' => $res_status
                );
                $trans_res_fail = date("Y-m-d H:i:s") . "UPI Transaction Response update in table:" . json_encode($failure_data) . " \n\n";
                  poslogs($trans_res_fail);

              /* Updating Transaction table after failure response */
              $db->where("upi_merchant_vaddr", $res_merchantVaddr);
              $db->where("upi_req_type",$res_ReqType);
              $trans_fail_update = $db->update('transaction_upi', $success_data);

              //echo $res_status;
              if($res_errDesc == 'FAILURE'){?>
              <script type="text/javascript">$('#fail_msg').show()</script>
              <?php
            }
              header( "Refresh:3;url=https://paymentgateway.test.credopay.in/testspaysez/vpa_upi_form.php");
              exit;

              }

}else if($reqType == 2) {
        // $trans_notify = '<upi:RespTxnConfirmation xmlns:upi="http://npci.org/upi/schema/">
        // <Head ver="1.0" ts="" orgId="" msgId="" />
        // <Txn id="" note="" refId="" refUrl="" ts="" type="TxnConfirmation"
        //   orgTxnId="" />
        // <Resp reqMsgId="" result="SUCCESS" errCode="" />
        // </upi:RespTxnConfirmation>';
        $ver = $_POSt['ver'];
        $ts = $_POSt['ts'];
        $MsgId = $_POSt['MsgId'];
        $id = $_POST['id'];

        //Txn 
        
        $ts = $_POSt['ts'];
        $Type = $_POST['Type'];
        $orgTxnId = $_POST['orgTxnId'];
        $custRef  = $_POST['custRef '];
        $orgRespCode  = $_POST['orgRespCode'];
        $orgErrCode = $_POST['orgRespCode '];

        $notify_parameter = array(
          'upi_ver' => $mer_id,
          'upi_ts' => $txnId,
          'upi_msg_id' => $txnOrigin,
          'upi_txn_id' => $reqType,
          'upi_type' => $accountNumber,
          'upi_org_txn_id' => $accountNumber,
          'upi_cust_ref' => $accountNumber,
          'upi_org_resp_code' => $accountNumber,
          'upi_org_err_code' => $accountNumber,
          'trans_datetime' => date('Y-m-d H:i:s'),
          'trans_time_gmt' => gmdate('Y-m-d H:i:s')
        );

      $notify_data = date("Y-m-d H:i:s") . " UPI Notify Data Insert in table:" . $notify_parameter . " \n\n";
      poslogs($notify_data);

      $notify_data_insert = $db->insert('transaction_upi', $notify_parameter);


}else if($reqType == 'TxnHistory') {
      $history ='<ReqTxnHistory>
      <Head ver="'.$ver.'" ts="'.$hts.'" msgId="'.$msgId.'" />
      <Txn id="'.$id.'" ts="'.$tts.'" type="'.$ttype.'" />
      <Payees>
      <Payee addr="'.$addr.'" name="'.$name.'" type="'.$ptype.'" code="'.$code.'">
      </Payee>
      </Payees>
      </ReqTxnHistory>';

      $trans_history_data = date("Y-m-d H:i:s") . " UPI -Transaction History Request Data:" . $history . " \n\n";
            poslogs($trans_history_data);


      /*transaction table insert data*/
        $history_parameter = array(
          'upi_ver' => $ver,
          'upi_hts' => $hts,
          'upi_msg_id' => $msgId,
          'upi_txn_id' => $id,
          'upi_tts' => $tts,
          'upi_type' => $ttype,
          'upi_payee_addr' => $addr,
          'upi_payee_name' => $name,
          'upi_payee_type' => $ptype,
          'upi_mcc' => $mcc,
          'trans_datetime' => date('Y-m-d H:i:s'),
          'trans_time_gmt' => gmdate('Y-m-d H:i:s')
        );

        $history_insert_data = date("Y-m-d H:i:s") . " UPI Transaction History Data Insert in table:" . $history_parameter . " \n\n";
        poslogs($history_insert_data);

        $hist_request_insert = $db->insert('transaction_upi', $history_parameter);


      /* URL to send request for VPA */
      $upi_url = 'http://localhost:8080/PSPNewWeb/PSPExtendedSyncServlet?channelCode=&bankCode=cub&serviceName=ReqTxnHistory';

      $request_url = date("Y-m-d H:i:s") . " UPI -Transaction History Request URL:" . $upi_url . " \n\n";
            poslogs($request_url);

      $curl = curl_init();
      //print_r($request_parameters);exit;
          curl_setopt_array($curl, array(
            CURLOPT_PORT => '8080',
            CURLOPT_URL => $upi_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $history,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => array(
              "Cache-Control: no-cache",
              "Content-Type: text/xml",
              "Content-Length:".strlen($history)
            ),
          ));
          $response = curl_exec($curl);
          $err = curl_error($curl);
          curl_close($curl);
          if ($err) {
            $log = date("Y-m-d H:i:s") . " UPI -Transaction Request Response:" . $err . " \n\n";
            poslogs($log);
            echo "cURL Error #:" . $err;
          } else {
            $log = date("Y-m-d H:i:s") . " UPI -Transaction Request Response:" . $response . " \n\n";
              poslogs($log);
            echo $response;
          }

          /*Transaction Response From UPI for request */
          $res_ver = get_from_tag($response, '<ver>','</ver>');
          $res_hts = get_from_tag($response, '<ts>','</ts>');
          $res_msgId = get_from_tag($response, '<msgId>','</msgId>');
          $res_txn_id = get_from_tag($response, '<id>','</id>');
          $res_type = get_from_tag($response, '<type>','</type>');
          $res_result = get_from_tag($response, '<result>','</result>');
          $res_errCode = get_from_tag($response, '<errCode>','</errCode>');
          $res_TxnDetl_id = get_from_tag($response, '<TxnDetl id>','</TxnDetl id>');
          $res_Payer_vpa = get_from_tag($response, '<Payer_vpa>','</Payer_vpa>');
          $res_fromAccNo = get_from_tag($response, '<fromAccNo>','</fromAccNo>');
          $res_amount = get_from_tag($response, '<amount>','</amount>');
          $res_txnDateTime = get_from_tag($response, '<txnDateTime>','</txnDateTime>');
          $res_status = get_from_tag($response, '<status>','</status>');

        if($res_errCode == '000' && $res_result == 'SUCCESS'){
          //code for sucesss
            $success_data = array(
              "upi_ver" => $res_ver,
              "upi_hts" => $res_hts,
              "upi_msg_id" => $res_msgId,
              "upi_txn_id" => $res_txn_id,
              "upi_type" => $res_type,
              "upi_result" => $res_result,
              "upi_err_code" => $res_errCode,
              "upi_txn_id" => $res_TxnDetl_id,
              "upi_payer_vpa" => $res_Payer_vpa,
              "upi_payer_acct_no" => $res_fromAccNo,
              "upi_amount" => $res_amount,
              "upi_payer_txnDateTime" => $res_txnDateTime,
              "upi_status" => $res_status  
          );
          $history_res_sucs = date("Y-m-d H:i:s") . "UPI Transaction Response update in table:" . json_encode($success_data) . " \n\n";
              poslogs($history_res_sucs);

          /* Updating Transaction table after success response */
          $db->where("upi_merchant_vaddr", $addr);
          $db->where("upi_req_type",$reqType);
          $history_sucs_update = $db->update('transaction_upi', $success_data);
      
          //echo $res_status;
          if($res_result == 'SUCCESS'){?>
          <script type="text/javascript">$('#success_msg').show()</script>
          <?php
            }
          header( "Refresh:3;url=https://paymentgateway.test.credopay.in/testspaysez/vpa_upi_form.php");
          exit;
      }else if($res_errCode == '709' && $res_result == 'FAILURE'){
            $failure_data = array(
            'upi_txn_origin' => $res_txnOrigin,
            'upi_err_code' => $res_errCode,
            'upi_err_desc' => $res_errDesc,
            'upi_mobile_no' => $res_mobileNumber,
            'upi_merchant_vaddr' => $res_merchantVaddr,
            'upi_req_type' => $res_ReqType,
            'upi_status' => $res_status
               );
            $history_res_fail = date("Y-m-d H:i:s") . "UPI Transaction Response update in table:" . json_encode($failure_data) . " \n\n";
              poslogs($history_res_fail);

             /* Updating Transaction table after failure response */
            $db->where("upi_merchant_vaddr", $addr);
            $db->where("upi_req_type",$res_ReqType);
            $trans_fail_update = $db->update('transaction_upi', $success_data);

            //echo $res_status;
                if($res_errDesc == 'FAILURE'){?>
                <script type="text/javascript">$('#fail_msg').show()</script>
                <?php
               }
                header( "Refresh:3;url=https://paymentgateway.test.credopay.in/testspaysez/vpa_upi_form.php");
                exit;

        }///
}


?>
</body>
</html>