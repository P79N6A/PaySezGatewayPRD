<?php
//error_reporting(0);
require_once('../php/MysqliDb.php');
require '../kint/Kint.class.php';
//error_reporting(E_ALL);
//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$db = new Mysqlidb ('localhost', 'urebanx', 'Rebanxpg', 'rebanx');
//$db = new Mysqlidb ('localhost', 'root', '', 'rebanx1');
$data = array();
//require_once('encrypt.php');
header('Content-Type: application/json');

	//should do check here to see if they merchant_processor_mid is enabled to use or not.
	$AppType=$_POST['AppType'];
	if($AppType == 'ME'){
		if($_POST['Action']=='1'){

            $db->where('merchantid',$_POST['merchantid']);
            $lastid = $db->getone("merchant_api");

            if($lastid['merchantid']!="") {
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Merchant already exist';
                $success='F';
            }
            else {
                $data = Array(
                    "apptype" => $_POST['AppType'],
                    "action" => $_POST['Action'],
                    "superinst" => $_POST['superinst'],
                    "superinstname" => $_POST['superinstname'],
                    "superinst" => $_POST['superinst'],
                    "instname" => $_POST['instname'],
                    "instid" => $_POST['instid'],
                    "supermercname" => $_POST['supermercname'],
                    "supermerc" => $_POST['supermerc'],
                    "sponsorname" => $_POST['sponsorname'],
                    "sponsorbankid" => $_POST['sponsorbankid'],
                    "merchantname" => $_POST['merchantname'],
                    "merchantid" => $_POST['merchantid'],
                    "mso_status" => $_POST['mso_status'],
                    "mso_status_date" => $_POST['mso_status_date'],
                    "mso_merchant_id" => $_POST['mso_merchant_id'],
                    "mso_region" => $_POST['mso_region'],
                    "mso_type" => $_POST['mso_type'],
                    "mso_business_nature" => $_POST['mso_business_nature'],
                    "mso_mcc" => $_POST['mso_mcc'],
                    "mds_schg_flat" => $_POST['mds_schg_flat'],
                    "mds_schg_percent" => $_POST['mds_schg_percent'],
                    "mso_tcc" => $_POST['mso_tcc'],
                    "mso_res_address" => $_POST['mso_res_address'],
                    "mso_res_cty" => $_POST['mso_res_cty'],
                    "mso_res_state" => $_POST['mso_res_state'],
                    "mso_res_pin" => $_POST['mso_res_pin'],
                    "mso_cont_name" => $_POST['mso_cont_name'],
                    "mso_cont_mobile" => $_POST['mso_cont_mobile'],
                    "mso_cont_alt_mobile" => $_POST['mso_cont_alt_mobile'],
                    "mso_cont_telephone" => $_POST['mso_cont_telephone'],
                    "mso_cont_email" => $_POST['mso_cont_email'],
                    "mso_max_daily_floor_limit" => $_POST['mso_max_daily_floor_limit'],
                    "mso_max_weekly_floor_limit" => $_POST['mso_max_weekly_floor_limit'],
                    "mso_max_monthly_floor_limit" => $_POST['mso_max_monthly_floor_limit'],
                    "mso_velocity_check_minutes" => $_POST['mso_velocity_check_minutes'],
                    "mso_velocity_check_txn_count" => $_POST['mso_velocity_check_txn_count']

                );
                $id_transaction_id = $db->insert('merchant_api', $data);
                $resdesc='Merchant added';
                $success='S';
			}
		}
		else if($_POST['Action']=='2'){
            $db->where('merchantid',$_POST['merchantid']);
            $lastid = $db->getone("merchant_api");

            if($lastid['merchantid']!="") {
                $data = Array(
                    "apptype" => $_POST['AppType'],
                    "action" => $_POST['Action'],
                    "superinst" => $_POST['superinst'],
                    "superinstname" => $_POST['superinstname'],
                    "superinst" => $_POST['superinst'],
                    "instname" => $_POST['instname'],
                    "instid" => $_POST['instid'],
                    "supermercname" => $_POST['supermercname'],
                    "supermerc" => $_POST['supermerc'],
                    "sponsorname" => $_POST['sponsorname'],
                    "sponsorbankid" => $_POST['sponsorbankid'],
                    "merchantname" => $_POST['merchantname'],
                    "merchantid" => $_POST['merchantid'],
                    "mso_status" => $_POST['mso_status'],
                    "mso_status_date" => $_POST['mso_status_date'],
                    "mso_merchant_id" => $_POST['mso_merchant_id'],
                    "mso_region" => $_POST['mso_region'],
                    "mso_type" => $_POST['mso_type'],
                    "mso_business_nature" => $_POST['mso_business_nature'],
                    "mso_mcc" => $_POST['mso_mcc'],
                    "mds_schg_flat" => $_POST['mds_schg_flat'],
                    "mds_schg_percent" => $_POST['mds_schg_percent'],
                    "mso_tcc" => $_POST['mso_tcc'],
                    "mso_res_address" => $_POST['mso_res_address'],
                    "mso_res_cty" => $_POST['mso_res_cty'],
                    "mso_res_state" => $_POST['mso_res_state'],
                    "mso_res_pin" => $_POST['mso_res_pin'],
                    "mso_cont_name" => $_POST['mso_cont_name'],
                    "mso_cont_mobile" => $_POST['mso_cont_mobile'],
                    "mso_cont_alt_mobile" => $_POST['mso_cont_alt_mobile'],
                    "mso_cont_telephone" => $_POST['mso_cont_telephone'],
                    "mso_cont_email" => $_POST['mso_cont_email'],
                    "mso_max_daily_floor_limit" => $_POST['mso_max_daily_floor_limit'],
                    "mso_max_weekly_floor_limit" => $_POST['mso_max_weekly_floor_limit'],
                    "mso_max_monthly_floor_limit" => $_POST['mso_max_monthly_floor_limit'],
                    "mso_velocity_check_minutes" => $_POST['mso_velocity_check_minutes'],
                    "mso_velocity_check_txn_count" => $_POST['mso_velocity_check_txn_count']
                );
                $db->update('merchant_api', $data, array('merchantid' => $_POST['merchantid']));
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Merchant updated successfully';
                $success='S';
            }
            else {
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Merchant not found';
                $success='F';
			}
		}
		else if($_POST['Action']=='3'){
            $db->where('merchantid',$_POST['merchantid']);
            $lastid = $db->getone("merchant_api");

            if($lastid['merchantid']!=""){
                $data = Array (
                    "mso_activity_flag" => '0'
                );
                $db->update('merchant_api', $data, array('merchantid'=> $_POST['merchantid']) );
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Blocked successully';
                $success='S';
			}
			else {
                $resdesc='Merchant not found';
                $id_transaction_id =$lastid['uniqueid'];
                $success='F';
			}

		}
		else {

		}

		$results = [
				"UniqueId" 	=> $id_transaction_id,
				"ResponseDesc" 	=> $resdesc,
				"ResponseCode" => $success
		];

		echo json_encode($results);
	}
	elseif($AppType == 'ST'){
		if($_POST['Action']=='1') {
            $db->where('store_id',$_POST['store_id']);
            $lastid = $db->getone("merchant_api");

            if($lastid['store_id']!="") {
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Store already exist';
                $success='F';

            }
            else{
                $data = Array(
                    "apptype" => $_POST['AppType'],
                    "action" => $_POST['Action'],
                    "superinst" => $_POST['superinst'],
                    "superinstname" => $_POST['superinstname'],
                    "superinst" => $_POST['superinst'],
                    "instname" => $_POST['instname'],
                    "instid" => $_POST['instid'],
                    "supermercname" => $_POST['supermercname'],
                    "supermerc" => $_POST['supermerc'],
                    "sponsorname" => $_POST['sponsorname'],
                    "sponsorbankid" => $_POST['sponsorbankid'],
                    "merchantname" => $_POST['merchantname'],
                    "merchantid" => $_POST['merchantid'],
                    "mso_status" => $_POST['mso_status'],
                    "mso_status_date" => $_POST['mso_status_date'],
                    "mso_merchant_id" => $_POST['mso_merchant_id'],
                    "mso_region" => $_POST['mso_region'],
                    "mso_type" => $_POST['mso_type'],
                    "mso_business_nature" => $_POST['mso_business_nature'],
                    "mso_mcc" => $_POST['mso_mcc'],
                    "mds_schg_flat" => $_POST['mds_schg_flat'],
                    "mds_schg_percent" => $_POST['mds_schg_percent'],
                    "mso_tcc" => $_POST['mso_tcc'],
                    "mso_res_address" => $_POST['mso_res_address'],
                    "mso_res_cty" => $_POST['mso_res_cty'],
                    "mso_res_state" => $_POST['mso_res_state'],
                    "mso_res_pin" => $_POST['mso_res_pin'],
                    "mso_cont_name" => $_POST['mso_cont_name'],
                    "mso_cont_mobile" => $_POST['mso_cont_mobile'],
                    "mso_cont_alt_mobile" => $_POST['mso_cont_alt_mobile'],
                    "mso_cont_telephone" => $_POST['mso_cont_telephone'],
                    "mso_cont_email" => $_POST['mso_cont_email'],
                    "mso_max_daily_floor_limit" => $_POST['mso_max_daily_floor_limit'],
                    "mso_max_weekly_floor_limit" => $_POST['mso_max_weekly_floor_limit'],
                    "mso_max_monthly_floor_limit" => $_POST['mso_max_monthly_floor_limit'],
                    "mso_velocity_check_minutes" => $_POST['mso_velocity_check_minutes'],
                    "mso_velocity_check_txn_count" => $_POST['mso_velocity_check_txn_count'],
                    "storename" => $_POST['storename'],
                    "store_id" => $_POST['store_id'],
                    "address1" => $_POST['address1'],
                    "phone_no" => $_POST['phone_no'],
                    "city" => $_POST['city'],
                    "zip_code" => $_POST['zip_code'],
                    "mobile_no" => $_POST['mobile_no'],
                    "email_address" => $_POST['email_address'],
                    "lastmodified_date" => $_POST['lastmodified_date'],
                    "status" => $_POST['status']

                );
                $id_transaction_id = $db->insert('merchant_api', $data);
                $resdesc='Store added';
                $success='S';
			}
        }
        else if($_POST['Action']=='2'){
            $db->where('store_id',$_POST['store_id']);
            $lastid = $db->getone("merchant_api");

            if($lastid['store_id']!="") {
                $data = Array(
                    "apptype" => $_POST['AppType'],
                    "action" => $_POST['Action'],
                    "superinst" => $_POST['superinst'],
                    "superinstname" => $_POST['superinstname'],
                    "superinst" => $_POST['superinst'],
                    "instname" => $_POST['instname'],
                    "instid" => $_POST['instid'],
                    "supermercname" => $_POST['supermercname'],
                    "supermerc" => $_POST['supermerc'],
                    "sponsorname" => $_POST['sponsorname'],
                    "sponsorbankid" => $_POST['sponsorbankid'],
                    "merchantname" => $_POST['merchantname'],
                    "merchantid" => $_POST['merchantid'],
                    "mso_status" => $_POST['mso_status'],
                    "mso_status_date" => $_POST['mso_status_date'],
                    "mso_merchant_id" => $_POST['mso_merchant_id'],
                    "mso_region" => $_POST['mso_region'],
                    "mso_type" => $_POST['mso_type'],
                    "mso_business_nature" => $_POST['mso_business_nature'],
                    "mso_mcc" => $_POST['mso_mcc'],
                    "mds_schg_flat" => $_POST['mds_schg_flat'],
                    "mds_schg_percent" => $_POST['mds_schg_percent'],
                    "mso_tcc" => $_POST['mso_tcc'],
                    "mso_res_address" => $_POST['mso_res_address'],
                    "mso_res_cty" => $_POST['mso_res_cty'],
                    "mso_res_state" => $_POST['mso_res_state'],
                    "mso_res_pin" => $_POST['mso_res_pin'],
                    "mso_cont_name" => $_POST['mso_cont_name'],
                    "mso_cont_mobile" => $_POST['mso_cont_mobile'],
                    "mso_cont_alt_mobile" => $_POST['mso_cont_alt_mobile'],
                    "mso_cont_telephone" => $_POST['mso_cont_telephone'],
                    "mso_cont_email" => $_POST['mso_cont_email'],
                    "mso_max_daily_floor_limit" => $_POST['mso_max_daily_floor_limit'],
                    "mso_max_weekly_floor_limit" => $_POST['mso_max_weekly_floor_limit'],
                    "mso_max_monthly_floor_limit" => $_POST['mso_max_monthly_floor_limit'],
                    "mso_velocity_check_minutes" => $_POST['mso_velocity_check_minutes'],
                    "mso_velocity_check_txn_count" => $_POST['mso_velocity_check_txn_count'],
                    "storename" => $_POST['storename'],
                    "store_id" => $_POST['store_id'],
                    "address1" => $_POST['address1'],
                    "phone_no" => $_POST['phone_no'],
                    "city" => $_POST['city'],
                    "zip_code" => $_POST['zip_code'],
                    "mobile_no" => $_POST['mobile_no'],
                    "email_address" => $_POST['email_address'],
                    "lastmodified_date" => $_POST['lastmodified_date'],
                    "status" => $_POST['status']

                );
                $db->update('merchant_api', $data,  array('store_id'=> $_POST['store_id']));
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Store updated successfully';
                $success='S';
            }
            else {

            }
		}
		else if($_POST['Action']=='3'){
            $db->where('store_id',$_POST['store_id']);
            $lastid = $db->getone("merchant_api");

            if($lastid['store_id']!=""){
                $data = Array (
                    "mso_activity_flag" => '0'
                );
                $db->update('merchant_api', $data, array('store_id'=> $_POST['store_id']) );
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Store Blocked successully';
                $success='S';
            }
            else {
                $resdesc='Store not found';
                $id_transaction_id =$lastid['uniqueid'];
                $success='F';
            }
        }
        else {

		}
        $results = [
            "UniqueId" 	=> $id_transaction_id,
            "ResponseDesc" 	=> $resdesc,
            "ResponseCode" => $success
        ];

		echo json_encode($results);
	}
	elseif($AppType == 'TM'){

        if($_POST['Action']=='1') {
            $db->where('mso_terminal_id',$_POST['mso_terminal_id']);
            $lastid = $db->getone("merchant_api");

            if($lastid['mso_terminal_id']!="") {
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Terminal already exist';
                $success='F';

            }
            else{
                $data = Array (
                    "apptype" => $_POST['AppType'],
                    "action" => $_POST['Action'],
                    "superinst" => $_POST['superinst'],
                    "superinstname" => $_POST['superinstname'],
                    "superinst" => $_POST['superinst'],
                    "instname" => $_POST['instname'],
                    "instid" => $_POST['instid'],
                    "supermercname" => $_POST['supermercname'],
                    "supermerc" => $_POST['supermerc'],
                    "sponsorname" => $_POST['sponsorname'],
                    "sponsorbankid" => $_POST['sponsorbankid'],
                    "merchantname" => $_POST['merchantname'],
                    "merchantid" => $_POST['merchantid'],
                    "mso_status" => $_POST['mso_status'],
                    "mso_status_date" => $_POST['mso_status_date'],
                    "mso_merchant_id" => $_POST['mso_merchant_id'],
                    "mso_region" => $_POST['mso_region'],
                    "mso_type" => $_POST['mso_type'],
                    "mso_business_nature" => $_POST['mso_business_nature'],
                    "mso_mcc" => $_POST['mso_mcc'],
                    "mds_schg_flat" => $_POST['mds_schg_flat'],
                    "mds_schg_percent" => $_POST['mds_schg_percent'],
                    "mso_tcc" => $_POST['mso_tcc'],
                    "mso_res_address" => $_POST['mso_res_address'],
                    "mso_res_cty" => $_POST['mso_res_cty'],
                    "mso_res_state" => $_POST['mso_res_state'],
                    "mso_res_pin" => $_POST['mso_res_pin'],
                    "mso_cont_name" => $_POST['mso_cont_name'],
                    "mso_cont_mobile" => $_POST['mso_cont_mobile'],
                    "mso_cont_alt_mobile" => $_POST['mso_cont_alt_mobile'],
                    "mso_cont_telephone" => $_POST['mso_cont_telephone'],
                    "mso_cont_email" => $_POST['mso_cont_email'],
                    "mso_max_daily_floor_limit" => $_POST['mso_max_daily_floor_limit'],
                    "mso_max_weekly_floor_limit" => $_POST['mso_max_weekly_floor_limit'],
                    "mso_max_monthly_floor_limit" => $_POST['mso_max_monthly_floor_limit'],
                    "mso_velocity_check_minutes" => $_POST['mso_velocity_check_minutes'],
                    "mso_velocity_check_txn_count" => $_POST['mso_velocity_check_txn_count'],
                    "storename" => $_POST['storename'],
                    "store_id" => $_POST['store_id'],
                    "address1" => $_POST['address1'],
                    "phone_no" => $_POST['phone_no'],
                    "city" => $_POST['city'],
                    "zip_code" => $_POST['zip_code'],
                    "mobile_no" => $_POST['mobile_no'],
                    "email_address" => $_POST['email_address'],
                    "lastmodified_date" => $_POST['lastmodified_date'],
                    "status" => $_POST['status'],
                    "mso_terminal_id" => $_POST['mso_terminal_id'],
                    "mso_ter_creation_date" => $_POST['mso_ter_creation_date'],
                    "mso_ter_install_date" => $_POST['mso_ter_install_date'],
                    "mso_ter_activation_date" => $_POST['mso_ter_activation_date'],
                    "mso_ter_status" => $_POST['mso_ter_status'],
                    "mso_ter_location" => $_POST['mso_ter_location'],
                    "mso_ter_city_name" => $_POST['mso_ter_city_name'],
                    "mso_ter_state_code" => $_POST['mso_ter_state_code'],
                    "mso_ter_country_code" => $_POST['mso_ter_country_code'],
                    "mso_terminal_model" => $_POST['mso_terminal_model'],
                    "mso_ter_branch" => $_POST['mso_ter_branch'],
                    "mso_ter_cur_code" => $_POST['mso_ter_cur_code'],
                    "mso_ter_max_daily_floor_limit" => $_POST['mso_ter_max_daily_floor_limit'],
                    "mso_ter_max_weekly_floor_limit" => $_POST['mso_ter_max_weekly_floor_limit'],
                    "mso_ter_monthly_floor_limit" => $_POST['mso_ter_monthly_floor_limit'],
                    "mso_ter_device_mac" => $_POST['mso_ter_device_mac'],

                );
                $id_transaction_id = $db->insert('merchant_api', $data);
                $resdesc='Terminal added';
                $success='S';
            }
        }
        else if($_POST['Action']=='2'){
            $db->where('mso_terminal_id',$_POST['mso_terminal_id']);
            $lastid = $db->getone("merchant_api");

            if($lastid['mso_terminal_id']!="") {
                $data = Array(
                    "apptype" => $_POST['AppType'],
                    "action" => $_POST['Action'],
                    "superinst" => $_POST['superinst'],
                    "superinstname" => $_POST['superinstname'],
                    "superinst" => $_POST['superinst'],
                    "instname" => $_POST['instname'],
                    "instid" => $_POST['instid'],
                    "supermercname" => $_POST['supermercname'],
                    "supermerc" => $_POST['supermerc'],
                    "sponsorname" => $_POST['sponsorname'],
                    "sponsorbankid" => $_POST['sponsorbankid'],
                    "merchantname" => $_POST['merchantname'],
                    "merchantid" => $_POST['merchantid'],
                    "mso_status" => $_POST['mso_status'],
                    "mso_status_date" => $_POST['mso_status_date'],
                    "mso_merchant_id" => $_POST['mso_merchant_id'],
                    "mso_region" => $_POST['mso_region'],
                    "mso_type" => $_POST['mso_type'],
                    "mso_business_nature" => $_POST['mso_business_nature'],
                    "mso_mcc" => $_POST['mso_mcc'],
                    "mds_schg_flat" => $_POST['mds_schg_flat'],
                    "mds_schg_percent" => $_POST['mds_schg_percent'],
                    "mso_tcc" => $_POST['mso_tcc'],
                    "mso_res_address" => $_POST['mso_res_address'],
                    "mso_res_cty" => $_POST['mso_res_cty'],
                    "mso_res_state" => $_POST['mso_res_state'],
                    "mso_res_pin" => $_POST['mso_res_pin'],
                    "mso_cont_name" => $_POST['mso_cont_name'],
                    "mso_cont_mobile" => $_POST['mso_cont_mobile'],
                    "mso_cont_alt_mobile" => $_POST['mso_cont_alt_mobile'],
                    "mso_cont_telephone" => $_POST['mso_cont_telephone'],
                    "mso_cont_email" => $_POST['mso_cont_email'],
                    "mso_max_daily_floor_limit" => $_POST['mso_max_daily_floor_limit'],
                    "mso_max_weekly_floor_limit" => $_POST['mso_max_weekly_floor_limit'],
                    "mso_max_monthly_floor_limit" => $_POST['mso_max_monthly_floor_limit'],
                    "mso_velocity_check_minutes" => $_POST['mso_velocity_check_minutes'],
                    "mso_velocity_check_txn_count" => $_POST['mso_velocity_check_txn_count'],
                    "storename" => $_POST['storename'],
                    "store_id" => $_POST['store_id'],
                    "address1" => $_POST['address1'],
                    "phone_no" => $_POST['phone_no'],
                    "city" => $_POST['city'],
                    "zip_code" => $_POST['zip_code'],
                    "mobile_no" => $_POST['mobile_no'],
                    "email_address" => $_POST['email_address'],
                    "lastmodified_date" => $_POST['lastmodified_date'],
                    "status" => $_POST['status']

                );
                $db->update('merchant_api', $data,  array('mso_terminal_id'=> $_POST['mso_terminal_id']));
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Terminal updated successfully';
                $success='S';
            }
            else {

            }
        }
        else if($_POST['Action']=='3'){
            $db->where('mso_terminal_id',$_POST['mso_terminal_id']);
            $lastid = $db->getone("merchant_api");

            if($lastid['mso_terminal_id']!=""){
                $data = Array (
                    "mso_activity_flag" => '0'
                );
                $db->update('merchant_api', $data, array('mso_terminal_id'=> $_POST['mso_terminal_id']) );
                $id_transaction_id =$lastid['uniqueid'];
                $resdesc='Terminal Blocked successully';
                $success='S';
            }
            else {
                $resdesc='Terminal not found';
                $id_transaction_id =$lastid['uniqueid'];
                $success='F';
            }
        }
        else {

        }
        $results = [
            "UniqueId" 	=> $id_transaction_id,
            "ResponseDesc" 	=> $resdesc,
            "ResponseCode" => $success
        ];

        echo json_encode($results);


	}
	else {
		
	}

?>
