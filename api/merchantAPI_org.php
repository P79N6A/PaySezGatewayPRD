<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 21-09-2017
 * Time: 04:36 PM
 */

require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
$duser="cCtYUrEC8ok9OkEqLHidl83hahAQsyQStjoWYBJ73kH+VMh8Gwqf86lbhEv2FFcxLGnBLINIpnXEwJYsGQSZ+RULJdanODrzZlpomFT92TLllldbxr3hugtlonMUl32E|0Cbtfu05lx5DxurXbLb5tjKAaNbxPLwOt/1Vnzhk2NI=";
$dcode="3V2cmh3dWI4o83unpdBrRTu3oI1vwCTrN3KLYeHh2yzhx9RhAMYkfIkMPSNqOW3qWQSHS3iwyNAguzrEMUvcE5fUk/UplGmT2XbCiczUE7lQYrii8pl2+T2pQ9mgqfJN|8Z3Gobl3gr+o2f/6N8bJMx7fNjsMDkrQzOi2Qb9a/44=";
//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
require_once('encrypt.php');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);
$db = new Mysqlidb ('10.162.104.221', $userd, $passd, 'rebanx');
$db1 = new Mysqlidb ('10.162.104.221', $userd, $passd, 'mpi');
header('Content-Type: application/json');

if($_POST['Action']=='1'){
    //Getting data from merchant table based on POST merchant id
    $db->where('idmerchants',$_POST['mer_map_id']);
    $lastid = $db->getone("merchants");

    //Getting data from merchant table based on POST mappedid
    $db->where('mer_map_id',$_POST['merchantid']);
    $lastid2 = $db->getone("merchants");

    if($_POST['merchant_name']!="" && $_POST['mer_map_id']!="" && $_POST['start_date']!="" && $_POST['address1']!="" && $_POST['city']!="" && $_POST['us_state']!="" && $_POST['country']!="" && $_POST['zippostalcode']!="" && $_POST['csphone']!="" && $_POST['csemail']!="" && $_POST['merchantid']!="" && $_POST['mcc']!="" && $_POST['terid']!="") {
        if ($lastid['idmerchants'] == "" && $lastid2['idmerchants'] == "") {

            $data_mid = array(
                "merchant_id" => $_POST['mer_map_id'],
                "processor_id" => 3,
                "gateway_id" => 3,
                "mer_map_id" => $_POST['merchantid'],
                "accountno" => $_POST['accountno'],
                "ifsccode" => $_POST['ifsccode']
            );

            $data = Array(
                "merchant_name" => $_POST['merchant_name'],
                "idmerchants" => $_POST['mer_map_id'],
                "start_date" => $_POST['start_date'],
                "address1" => $_POST['address1'],
                "address2" => $_POST['address2'],
                "city" => $_POST['city'],
                "us_state" => $_POST['us_state'],
                "country" => $_POST['country'],
                "zippostalcode" => $_POST['zippostalcode'],
                "csphone" => $_POST['csphone'],
                "csemail" => $_POST['csemail'],
                "mer_map_id" => $_POST['merchantid'],
                "mcc" => $_POST['mcc'],
                "terid" => $_POST['terid'],
            );

            $id_transaction_id = $db->insert('merchants', $data);
            $mappedid = $_POST['merchant_id'];
            //$mappedid =$_POST['mer_map_id'];
            $data1 = Array(
                "MID" => $_POST['merchantid'],
                //"MID" => $_POST['mer_map_id'],
                "SID" => 'MC',
                "TDS_MID" => $_POST['merchantid'],
                //"TDS_MID" => $_POST['mer_map_id'],
                "TDS_MPASS" => '',
                "TDS_MNAME" => $_POST['merchant_name'],
                "TDS_MCOUNTRYC" => '702',
                "TDS_ACQBIN" => '523724',
                "TDS_CLCERTKSID" => 'mcsslclient',
                "TDS_CLCERTALIAS" => 'mcmpiclient2017',
                "TDS_CLPRIKSID" => 'mcsslclient',
                "TDS_CLPRIKALIAS" => 'mcmpiclient2017',
                "TDS_MURL" => 'https://paymentgateway.test.credopay.in',
                "TDS_ENABLED" => 'y'
            );

            //Insert data to merchant and threedsmer_tab table
            $db1->insert('threedsmer_tab', $data1);
            $db->insert('merchant_processors_mid', $data_mid);

            $resdesc = 'Merchant added';
            $success = '00';
        } else {
            $resdesc = 'Merchant ID/Mapped ID Already exist';
            $success = '01';
        }
    } else {
        $resdesc = 'Missing Mandatory Parameters';
        $success = '04';
    }

}
else if($_POST['Action']=='2'){
    if($_POST['merchantid']!="") {
        //Getting data from merchant table based on POST merchant id
        $db->where('mer_map_id', $_POST['merchantid']);
        $lastid = $db->getone("merchants");

        if ($lastid['idmerchants'] != "") {

            //Getting data for merchant_processor_mid table starts
            if ($_POST['mer_map_id'] != "")
                $data_mid["merchant_id"] = $_POST['mer_map_id'];

            if ($_POST['merchantid'] != "")
                $data_mid["mer_map_id"] = $_POST['merchantid'];

            if ($_POST['accountno'] != "")
                $data_mid["accountno"] = $_POST['accountno'];

            if ($_POST['ifsccode'] != "")
                $data_mid["ifsccode"] = $_POST['ifsccode'];
            //Getting for merchant_processor_mid table ends

            //Getting for threedsmer_tab table starts
            if ($_POST['merchantid'] != "") {
                $data1["MID"] = $_POST['merchantid'];
                $data1["TDS_MID"] = $_POST['merchantid'];
            }

            if ($_POST['merchant_name'] != "")
                $data1["TDS_MNAME"] = $_POST['merchant_name'];
            //Getting for threedsmer_tab table ends

            //update threedsmer_tab table
            $db1->where('MID', $lastid['mer_map_id']);
            $db1->update('threedsmer_tab', $data1);

            //Getting for merchants table starts
            if ($_POST['merchant_name'] != "")
                $data["merchant_name"] = $_POST['merchant_name'];

            if ($_POST['mer_map_id'] != "")
                $data["idmerchants"] = $_POST['mer_map_id'];

            if ($_POST['start_date'] != "")
                $data["start_date"] = $_POST['start_date'];

            if ($_POST['address1'] != "")
                $data["address1"] = $_POST['address1'];

            if ($_POST['address2'] != "")
                $data["address2"] = $_POST['address2'];

            if ($_POST['city'] != "")
                $data["city"] = $_POST['city'];

            if ($_POST['us_state'] != "")
                $data["us_state"] = $_POST['us_state'];

            if ($_POST['country'] != "")
                $data["country"] = $_POST['country'];

            if ($_POST['zippostalcode'] != "")
                $data["zippostalcode"] = $_POST['zippostalcode'];

            if ($_POST['csphone'] != "")
                $data["csphone"] = $_POST['csphone'];

            if ($_POST['csemail'] != "")
                $data["csemail"] = $_POST['csemail'];

            if ($_POST['mer_map_id'] != "")
                $data["mer_map_id"] = $_POST['mer_map_id'];

            if ($_POST['mcc'] != "")
                $data["mcc"] = $_POST['mcc'];

            if ($_POST['terid'] != "")
                $data["terid"] = $_POST['terid'];
            //Getting for merchants table ends

            //Update merchants table
            $db->where('idmerchants', $lastid['idmerchants']);
            $db->update('merchants', $data);

            //Update processor mid table
            $db->where("merchant_id", $lastid['idmerchants']);
            $db->update('merchant_processors_mid', $data_mid);

            $resdesc = 'Merchant updated successfully';
            $success = '00';
        } else {
            $resdesc = 'Merchant not found';
            $success = '02';
        }
    } else {
        $resdesc = 'Missing Mandatory Parameters';
        $success = '04';
    }
}
else if($_POST['Action']=='3'){
    if($_POST['merchantid']!="" && $_POST['terid']!="") {

        //inactive the merchant
        $data=array("is_active" => 0);
        $db->where('mer_map_id', $_POST['merchantid']);
        $db->update('merchants', $data);
        $resdesc = 'Merchant In-Actived successully';
        $success = '00';
        /*
        //Getting data from merchant table based on POST merchant id
        $db->where('mer_map_id', $_POST['merchantid']);
        $lastid = $db->getone("merchants");

        if ($lastid['idmerchants'] != "") {
            //delete data from merchants table
            $db->where('idmerchants', $lastid['idmerchants']);
            $db->delete('merchants');

            //delete data from threedsmer_tab table
            $db1->where('MID', $lastid['mer_map_id']);
            $db1->delete('threedsmer_tab');

            //delete data from merchant_processors_mid table
            $db->where('merchant_id', $lastid['idmerchants']);
            $db->delete('merchant_processors_mid');

            $resdesc = 'Deleted successully';
            $success = '00';
        } else {
            $resdesc = 'Merchant not found';
            $success = '03';
        }
        */
    } else {
        $resdesc = 'Missing Mandatory Parameters';
        $success = '04';
    }
} else {
    $resdesc = 'Unknown Action';
    $success = '05';
}
$results = [
    "errordesc" => $resdesc,
    "success" => $success
];

echo json_encode($results);

?>