<?php
require_once('database_config.php');


   function number_point($value) {
        $myAngloSaxonianNumber = number_format($value, 2, '.', ','); //Conversion of single decimal point to two decimal point ex: 5,678.9 =>5,678.90
        return $myAngloSaxonianNumber;
    }

if(file_get_contents("php://input")) {
	$json = json_decode(file_get_contents("php://input"));
	
	if($json->type == 'getmerchant') {
		$db->where('mer_map_id', $json->m_id);
		$lastid = $db->getone("merchants");

		$cols = Array ("idmerchants", "mso_terminal_id", "active");
		$db->where('idmerchants', $lastid['idmerchants']);
		$db->orderBy("mso_terminal_id","ASC");
		$terminal_List = $db->get("terminal", null, $cols);
		// echo "<pre>";
		// print_r($terminal_List);
		$result = '';
		$result.='<option value="">-- Terminal ID --</option>';
		foreach ($terminal_List as $key => $value) {
			$result.= '<option value="'.$value['mso_terminal_id'].'">'.$value['mso_terminal_id'].'</option>';
		}
		echo $result;
	}

	if($json->type == 'getterminalQR') {
		$db->where('affiliate_id', $json->m_id);
		$merchant_List = $db->getone("merchants");
		echo $merchant_List['qr_url'];
	}
    if($json->type == 'getmerchantupiQR') {
        $db->where('upi_status',"1");
        $db->where('mso_terminal_id', $json->t_id);
        $terminal_List = $db->getone("terminal");
        echo $terminal_List['mso_ter_device_mac'];
    }

	if($json->type == 'gmportal') {
		$db->where('mer_map_id', $json->m_id);
		$mer_detail = $db->getone("merchants");
         $merchant_name=$mer_detail['merchant_name'];
         $address1=$mer_detail['address1'];
         $countrys=$mer_detail['country'];
         $country=substr($countrys,0,2);
         $mcc=$mer_detail['mcc'];
         $mer_map_id=$mer_detail['mer_map_id'];
         $currency_code=$mer_detail['currency_code'];
         $mer_map_id=$mer_detail['mer_map_id'];
         $am_status=$mer_detail['am_status'];

         $patner_query="SELECT * FROM alipay_config WHERE merchant_id='$mer_map_id'";
         $sec_mer_res2 = $db->rawQuery($patner_query);
         $partner_id=$sec_mer_res2[0]['partner_id'];
         $key_md5=$sec_mer_res2[0]['key_md5'];

         $array = array(
         	"merchant_name"=>$merchant_name,
         	"address1"=>$address1,
         	"country"=>$country,
         	"mcc"=>$mcc,
         	"mer_map_id"=>$mer_map_id,
         	"currency_code"=>$currency_code,
         	"am_status"=>$am_status,
         	"partner_id"=>$partner_id,
         	"key_md5"=>$key_md5
         );
		 $result=json_encode($array);
		 echo $result;
		
	}
	if($json->type == 'getmerchantdetele') {
		 $merchant_query = "UPDATE merchants SET flag = '1' WHERE mer_map_id  ='$json->m_id'";
         $pre_merchants_status = $db->rawQuery($merchant_query);
         $merchant_vendor_config = "DELETE  FROM vendor_config WHERE pg_merchant_id ='$json->m_id'";
         $pre_merchants_status = $db->rawQuery($merchant_vendor_config);
         echo $pre_merchants_status[0];
		
	}
    if($json->type == 'getterminaldetele') {
         //print_r($json);
        ///echo  $json->m_id.'&&&&&&&GPT0000001';
        $db->where('mer_map_id',$json->m_id);
        $idmerchants = $db->getOne('merchants');
        //echo $idmerchants['0']['idmerchants'];
        $id =  $idmerchants['idmerchants'];
                // //$idmerchants_query ="SELECT * FROM merchants WHERE mer_map_id ='$json->$m_id'";
        // echo "hi";

        //$idmerchants = $db->rawQuery($idmerchants_query);
        //echo $idmerchants_query;
        // $merchant_idmerchants = $idmerchants['0']['idmerchants'];
         $db->where('idmerchants',$id);
         $db->where('mso_terminal_id',$json->t_id);
         $array= array('flag' =>'1');
         $pre_terminal_status = $db->update('terminal',$array);
         echo $pre_terminal_status;
        //
        //print_r($idmerchants);
        // $array= array('flag' =>'1');
        // $pre_terminal_status = $db->update('terminal',$array);
        // echo $pre_terminal_status;      
    }
		
	if($json->type == 'merchantstatus') {
        // echo $json->m_id;
		$merchants_query="SELECT * FROM merchants WHERE mer_map_id='$json->m_id'";
        $pre_merchant_status = $db->rawQuery($merchants_query);
         $merchant_status=$pre_merchant_status[0]['is_active'];
		 echo $merchant_status;
	}

    if($json->type == 'terminalstatus') {
        $terminal_query="SELECT * FROM terminal WHERE mso_terminal_id='$json->t_id'";
        $pre_terminal_status = $db->rawQuery($terminal_query);
        $terminal_status=$pre_terminal_status[0]['active'];
        echo $terminal_status;
         //echo $ter_detail;
    }
		if($json->type == 'merchantupi') {
			$merchant_name="SELECT * FROM merchants WHERE merchant_name='$json->m_id'";
			$pre_merchnat_id = $db->rawQuery($merchant_name);
			$merchant_details=$pre_merchnat_id[0]['idmerchants'];
		 $merchant_query="SELECT * FROM merchants INNER JOIN merchant_processors_mid ON merchants.idmerchants = merchant_processors_mid.merchant_id WHERE  merchants.idmerchants = '$merchant_details'";
        $pre_merchants_status = $db->rawQuery($merchant_query);

        $txnid = $pre_merchants_status[0]['tax_id'];
        $txnorigin = $pre_merchants_status[0]['cs_first_name'];
         $mobile_number = $pre_merchants_status[0]['csphone'];
         $first_name = $pre_merchants_status[0]['cs_first_name'];
         $last_name = $pre_merchants_status[0]['cs_last_name'];
         $merchant_vaddr = $pre_merchants_status[0]['affiliate_id'];
         $mcc = $pre_merchants_status[0]['mcc'];
         $email = $pre_merchants_status[0]['csemail'];

         $address_details = $pre_merchants_status[0]['address1'];
         $city = $pre_merchants_status[0]['city'];
         $state = $pre_merchants_status[0]['us_state'];
         $country = $pre_merchants_status[0]['country'];
         $pincode = $pre_merchants_status[0]['zippostalcode'];
         $account_type = $pre_merchants_status[0]['account_type'];

         $pan_no = $pre_merchants_status[0]['pan_no'];
         $aadhaar_no = $pre_merchants_status[0]['aadhar_no'];
         $account_number = $pre_merchants_status[0]['accountno'];
         $ifsc = $pre_merchants_status[0]['ifsccode'];
         $mer_map_id = $pre_merchants_status[0]['mer_map_id'];
         $vendor_id = $pre_merchants_status[0]['vendor_id'];

         $req_type = $pre_merchants_status[0]['business_type'];


         $array = array(
            "txnid"=>$txnid,
            "txnorigin"=>$txnorigin,
         	"mobile_number"=>$mobile_number,
         	"first_name"=>$first_name,
         	"last_name"=>$last_name,
         	"merchant_vaddr"=>$merchant_vaddr,
         	"email"=>$email,
         	"mcc"=>$mcc,
         	"address_details"=>$address_details,
         	"city"=>$city,
         	"state"=>$state,
         	"country"=>$country,
         	"pincode"=>$pincode,
         	"account_type"=>$account_type,
         	"pan_no"=>$pan_no,
         	"aadhaar_no"=>$aadhaar_no,
         	"account_number"=>$account_number,
         	"ifsc"=>$ifsc,
         	"mer_map_id"=>$mer_map_id,
         	"vendor_id"=>$vendor_id,
         	"req_type"=>$req_type
         );
		 $result=json_encode($array);
		 echo $result;

		 // echo $merchants_status;
		//echo $pre_merchants_status;
	}

}

if(isset($_POST['upi_value']) && $_POST['upi_value']=='upi_value' )
{

	$merchants_vaddr  = (isset($_POST['merchants']) && $_POST['merchants']!='') ? $_POST['merchants'] : '';
   $query = "SELECT * FROM transaction_upi WHERE upi_merchant_vaddr = '$merchants_vaddr' AND upi_reg_active='0'";
   $transactions = $db->rawQuery($query);
   echo "<pre>";
   $i=0;
    if(!empty($transactions)) {
   $result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
        $result .= '<thead>
                        <tr>
                            <th>S.No</th>
                            <th>UPI_TAX_ID</th>
                            <th>UPI_MERCHANT_VADDR</th>
                            <th>UPI_STATUS</th>						
                            <th>UPI_ERR_CODE</th>
                            <th>UPI_REQ_TYPE</th>
                            <th>TRANS_DATETIME</th>				
                            <th>TRANS_AMOUNT</th>				
                        </tr>
                    </thead>
                    <tbody>';
   foreach ($transactions as $value) {
   	$i++;
   	$result .= '<tr class="gradeX">
                            <td style="text-align:center;">'.$i.'</td>
                            <td>'.$value["upi_txn_id"].'</td>
                            <td>'.$value["upi_merchant_vaddr"].'</td>
                            <td>'.$value["upi_status"].'</td>
                            <td>'.$value["upi_err_code"].'</td>							
                            <td>'.$value["upi_req_type"].'</td>
                            <td>'.$value["trans_datetime"].'</td>
                            <td>'.$value["trans_amount"].'</td>							
                        </tr>';

        }
        $result .= '</tbody></table>';
   } else {
   	$result .= "No transactions History";
   }
   echo $result;
}

if(isset($_POST['searchtype']) && $_POST['searchtype'] == 'report') {
	// echo "<pre>";
	// print_r($_POST);
	// exit;

    function custom_echo($x, $length) {
                        if(strlen($x)<=$length) {
                                            return $x;
                            } else { 
                                $y=substr($x,0,$length) . '';
                                return $y;
                            }
    }




	$start_end = explode('-', $_POST['date2']);

	$start_date = (isset($_POST['date2']) && $start_end[0]!='') ? date('Y-m-d 00:00:00',strtotime($start_end[0])) : '';
	$end_date   = (isset($_POST['date2']) && $start_end[1]!='') ? date('Y-m-d 23:59:59',strtotime($start_end[1])) : '';

	// echo $start_date."=>".$end_date; exit;

	// $start_date = (isset($_POST['date_timepicker_start']) && $_POST['date_timepicker_start']!='') ? $_POST['date_timepicker_start'] : '';
	// $end_date   = (isset($_POST['date_timepicker_end']) && $_POST['date_timepicker_end']!='') ? $_POST['date_timepicker_end'] : '';
	$currencies = (isset($_POST['currencies']) && $_POST['currencies']!='') ? $_POST['currencies'] : '';
	$trans_type = (isset($_POST['transaction_type']) && $_POST['transaction_type']!='') ? $_POST['transaction_type'] : '';
	$merchants  = (isset($_POST['merchants']) && $_POST['merchants']!='') ? $_POST['merchants'] : '';
	$terminals  = (isset($_POST['terminal_id']) && $_POST['terminal_id']!='') ? $_POST['terminal_id'] : '';

	$query = "SELECT * FROM gp_transaction WHERE gp_trans_datetime >= '$start_date' AND gp_trans_datetime <= '$end_date' AND gp_transaction_type!=4";

	if($currencies!='') {
		$query.= " AND gp_currency='$currencies'";
	}

	if($trans_type!='') {
		$query.= " AND gp_transaction_type='$trans_type'";
	}

	if($merchants!='') {
		$query.= " AND gp_merchant_id='$merchants'";
	}

	if($terminals!='') {
		$query.= " AND gp_terminal_id='$terminals'";
	}

	$query.= " ORDER BY gp_trans_datetime DESC";
    $result = 'No Transactions Found';
    $transactions = $db->rawQuery($query);

    $i = 0;
    if(!empty($transactions)){
		$result = '<table class="table table-striped table-bordered table-hover dataTables-example">';
        $result .= '<thead>
                        <tr>
                            <th>S.No</th>
                            <th>Transaction<br>Type</th>
                            <th>Transaction ID</th>
                            <th>Refund Original ID</th>						
                            <th>Terminal ID</th>
                            <th>Status</th>
                            <th>Transaction<br>Date</th>				
                            <th>Amount</th>				
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach($transactions as $tr) {
        	$i++;
            $t_id = $tr["id_transaction_id"]; // $_GET['t_id'];

            $transaction_type='';
            if($tr['gp_transaction_type'] == 1) {
                $transaction_type = 'GP - SALE';
            } else if($tr['gp_transaction_type'] == 2) {
                $transaction_type = 'GP - REFUND';
            } else if($tr['gp_transaction_type'] == 3) {
                $transaction_type = 'GP - CANCEL';

            // } else if($tr['gp_transaction_type'] == 4) {
            //     $transaction_type = 'GP - INQUIRY';
            } else if($tr['transaction_type'] == 's1') {
                $transaction_type = 'QR - SALE';
            } else if($tr['transaction_type'] == 's2') {
                $transaction_type = 'QR - REFUND';
            } else if($tr['transaction_type'] == 's3') {
                $transaction_type = 'QR - QUERY';
            } else if($tr['transaction_type'] == 's4') {
                $transaction_type = 'QR - CANCEL';
            } else if($tr['transaction_type'] == 'cb1') {
                $transaction_type = 'CBP - SALE';
            } else if($tr['transaction_type'] == 'cb2') {
                $transaction_type =  'CBP - REFUND';
            } else if($tr['transaction_type'] == 'cb3') {
                $transaction_type =  'CBP - QUERY';
            }

            $transaction_amount='';
            if($tr['gp_transaction_type'] == 2 || $tr['gp_transaction_type'] == 's2' || $tr['gp_transaction_type'] == 'cb2') {
                $transaction_amount = $tr["gp_amount"]/100;
                if (is_float($transaction_amount)) {
                    $transaction_amount =  number_point($transaction_amount);
                    
                } else {
                $transaction_amount = $transaction_amount.'.00';
              } 
                //$transaction_amount = $transaction_amount.'.00';
                //$transaction_amount=number_format($transaction_amount,2);
            } else {
                $transaction_amount = $tr["gp_amount"]/100;
                if (is_float($transaction_amount)) {
                     $transaction_amount =  number_point($transaction_amount);
                }
                else {
                        $transaction_amount = $transaction_amount.'.00';
                    }
                //$transaction_amount=number_format($transaction_amount,2);  
            }

            if($tr['gp_transaction_type'] == 1 || $tr['gp_transaction_type'] == 's1') { 
                if($tr['gp_status'] == "success") { 
                    $sta=$tr['gp_status']; 
                } else { 
                    $sta="transaction not found"; 
                }
            } else if($tr['gp_transaction_type'] == 3) {
                if($tr['gp_status'] =="" && $tr['gp_reason'] ==""){
                    $sta ="success";
                } else {
                    $sta = "fail";
                }
            } else if($tr['gp_transaction_type']==2) {
                if($tr['gp_status'] == ""){
                    $sta = "fail";
                } else{
                    $sta=$tr['gp_status']; 
                }
            } else {
                $sta=$tr['gp_status']; 
            }            

            if($tr['gp_transaction_type'] == 'cb2'){ 
                $trans_out_trade_no= $tr["out_return_no"];
                } else {
                    $trans_out_trade_no= $tr['gp_partnerTxID'];
                }

                if($tr['gp_transaction_type'] == 'cb2') { 
                    $trans_partner_trans_id = $tr["out_trade_no"];
                }else{ 
                     $trans_partner_trans_id = $tr['gp_orig_partnerTxID'];
                }

      //       $db->where("mer_map_id", $tr['merchant_id']);
		    // $datacon =$db->getOne('merchants');
		    //$merchant_name=$datacon['merchant_name'];
            //$merchant_name=substr($datacon['merchant_name'],0,20);
            $result .= '<tr class="gradeX">
                            <td style="text-align:center;">'.$i.'</td>
                            <td>'.$transaction_type.'</td>
                            <td>'.custom_echo($trans_out_trade_no,12).'</td>
                            <td>'.custom_echo($trans_partner_trans_id,12).'</td>
                            <td>'.$tr["gp_terminal_id"].'</td>							
                            <td>'.$sta.'</td>
                            <td>'.$tr["gp_cst_trans_datetime"].'</td>
                            <td>'.$tr["gp_currency"].' '.$transaction_amount.'</td>							
                            <td align="center"><a href="transactiondetails.php?t_id='.$tr["gp_transaction_id"].'" title="Click To View Details"><i class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></i></a></td>
                        </tr>';

        }
        $result .= '</tbody></table>';
    }
    echo $result;

}

if($_POST['merchant_id']!="" AND $_POST['merchant']="verify"){
    $merchant_id = $_POST['merchant_id'];
    $query = "SELECT * FROM vendor_config WHERE pg_merchant_id = '$merchant_id'";
    $last = $db->rawQuery($query);
    echo $last['0']['vendor_name'];
} 

function increment($string) {
   return preg_replace_callback('/^([^0-9]*)([0-9]+)([^0-9]*)$/', function($m)
   {
      return $m[1].str_pad($m[2]+1, strlen($m[2]), '0', STR_PAD_LEFT).$m[3];
   }, $string);
}

// Merchant id and/or Terminal id already exists or not
if($_POST['grab_merchant_id']!="") {
    $grab_merchant_id = $_POST['grab_merchant_id'];
    //$grab_merchant_id = preg_replace('/\s+/', '', $grab_merchant_id);
    //$db->where('grab_merchant_id','520499d9-be82-422c-a6da-e4f5eeb6019e');
    $query =  "SELECT * FROM merchants WHERE grab_merchant_id = '$grab_merchant_id'";
    $lastid = $db->rawQuery($query);
    if(!empty($lastid))  {
     $response->result = true;
    } else {
            $lastmerchant_id_query = 'SELECT * FROM merchants WHERE gp_status = 1 AND grab_merchant_id!="" AND grab_merchant_id!=0  ORDER BY idmerchants DESC LIMIT 1';
            $lastmerchant_id = $db->rawQuery($lastmerchant_id_query);
            if(empty($lastmerchant_id)) {
                $response->mer_id ='GPP0000001';
            } else {
                $response->mer_id = increment($lastmerchant_id['0']['mer_map_id']);
            }
          $response->result = false;      
    }
    echo json_encode($response);
 }

if($_POST['grab_terminal_id']!="") {
    $merchant_id = $_POST['merchant_id'];
    $query_idmerchants =  "SELECT * FROM merchants WHERE mer_map_id = '$merchant_id'";
    $idmerchants = $db->rawQuery($query_idmerchants);
    $db->where("idmerchants",$idmerchants['0']['idmerchants']);
    $db->where("grab_terminal_id",$_POST['grab_terminal_id']);
    $terminal_lastid = $db->getone('terminal');
    
    if(!empty($terminal_lastid))  {
         $response->result = true;
    } else {
            $lastmerchant_id_query = 'SELECT * FROM terminal ORDER BY id DESC LIMIT 1';
            $lastmerchant_id = $db->rawQuery($lastmerchant_id_query);
            if(empty($lastmerchant_id)) {
                $response->ter_id ='GPP000000001';
            } else {
                $response->ter_id = increment($lastmerchant_id['0']['mso_terminal_id']);
            }
          $response->result = false;      
    }
	echo json_encode($response);
}

if($_POST['vendor_name']!="" && $_POST['vendor_payment_options']!=""){
    //$response->result = false;
  // $vendr_name = $db->where('vendor_name', $_POST['vendor_name'])->;
    //$lastid = $db->getone("merchants");
    $vendor_name = $_POST['vendor_name'];
    $vendor_payment = $_POST['vendor_payment_options'];
    $vendor_query = "SELECT * FROM vendor_config  WHERE  vendor_name = '$vendor_name' && vendor_payment_options = '$vendor_payment'";
    $pre_vendor_status = $db->rawQuery($vendor_query);
    $count=count($pre_vendor_status);
     if ($count > 0) {
              $response->result = true;                 
        } else {
            $response->result= false;
        } 

   // echo $count;//print_r($pre_vendor_status);
    echo json_encode($response);
  // echo json_encode($result);
}

function getCCType($CCNumber) {
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

function getUserType($id) {
	global $db;
	$db->where("id",$id);
    $data = $db->getOne("users");
	return $data['user_type'];
}

$iid = $_SESSION['iid'];

$usertype = getUserType($iid);

foreach ($_POST as $key => $value) {
	filter_input(INPUT_POST, $key);
	$$key = $_POST[$key];
	$key = $value;
}

$date_timepicker_start = $_POST['start_date']; // $date_timepicker_start;
$date_timepicker_end = $_POST['end_date']; // $date_timepicker_end;

if(isset($_POST['from_dash']) && $_POST['from_dash'] == 1) { // From Dashboard
	$sdate = date('Y-m-d H:i:s', strtotime($_POST['start_date']. ':00')); // $date_timepicker_start;
	$edate = date('Y-m-d H:i:s', strtotime($_POST['end_date']. ':59')); // $date_timepicker_end;
} else {
	$sdate = $_POST['start_date']; // $date_timepicker_start;
	$edate = $_POST['end_date']; // $date_timepicker_end;
}

$currencies = $_POST['currencies'];
$transaction_type = $_POST['transaction_type'];

// echo "<pre>";
// print_r($_POST); 
// exit;
// die();

function number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
}

if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='0' && $transaction_type=='0') {

	$que1 ="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
	$data1 = $db->rawQuery($que1);

	$que2 ="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('2','s2','cb2') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime >='$sdate' AND gp_transaction.gp_trans_datetime <='$edate'";
	$data2 = $db->rawQuery($que2);

	// echo "<pre>";
	// print_r($data2); exit;
	$que3 ="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_status) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('4','s4') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
	$data3 = $db->rawQuery($que3);

	if($data1) {
		foreach($data1 as $var1){
			$total_count = $var1['countt'];
			$total_amount= $var1['total'];
		}
	}
	if($data2) {
		foreach($data2 as $var2){
			$refund_count = $var2['countt'];
			$refund_amount= $var2['total'];
		}
	}
	if($data3) {
		foreach($data3 as $var3){
			$cancel_count = $var3['countt'];
			$cancel_amount= $var3['total'];
		}
	}
	?>
	<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
		<thead>
			<tr>
				<th>Transactions Type</th>        
				<th>Number of Transaction</th>
				<th>Total Amount</th> 
			</tr>        
		</thead>		
		<tbody>       
			<tr class="gradeA odd" role="row">
				<td class="sorting_1">Total Sale Transactions</td>				
				<td><?php if($total_count=='0'){ echo '0'; } else { echo $total_count; }?></td>
				<td><?php if($total_amount==''){ echo '0'; } else {  $total_amount = $total_amount/100; echo number_point($total_amount); }?></td>				
			</tr>
			<tr class="gradeA even" role="row">
				<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php if($refund_count==''){ echo '0'; } else { echo $refund_count; } ?></td>
				<td><?php if($refund_amount==''){ echo '0'; } else {  $refund_amount = $refund_amount/100;
                    echo "-".number_point($refund_amount); } ?></td>				
			</tr>
			<tr class="gradeA odd" role="row">
				<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php if($cancel_count=='') { echo '0';} else { echo $cancel_count; } ?></td>
				<td><?php if($cancel_amount==''){ echo '0';} else { $cancel_amount = $cancel_amount/100; echo "-".number_point($cancel_amount); } ?></td>				
			</tr>		
		</tbody>
		<!-- <tfoot>
			<tr>
				<th rowspan="1" colspan="1">Transactions</th>       
				<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
				<th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
			</tr>
		</tfoot> -->
	</table>
	<?php

} else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='0' && $transaction_type!='0') 
{
		if($transaction_type == 'sale') {
			$que1 ="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('1','s1','cb1') AND gp_transaction.gp_status='success' AND  gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
			$data1 = $db->rawQuery($que1);
			if($data1) {
				foreach($data1 as $var1){
					$total_count = $var1['countt'];
					$total_amount= $var1['total'];
				}
			}
			?>
			<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
				<thead>
					<tr>
					<th>Transactions Type</th>        
					<th>Number of Transaction</th>
					<th>Total Amount</th>
					</tr>         
				</thead>		
			<tbody>       
				<tr class="gradeA odd" role="row">
					<td class="sorting_1">Total Sale Transactions</td>				
					<td><?php if($total_count=='0'){ echo '0'; } else { echo $total_count; }?></td>
					<td><?php if($total_amount==''){ echo '0'; } else { $total_amount = $total_amount/100;echo  number_point($total_amount); }?></td>					
				</tr>        
			</tbody>
			<!-- <tfoot>
			<tr>
			<th rowspan="1" colspan="1">Transactions</th>  
			<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
			<th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
			</tr>
			</tfoot> -->
			</table>
		<?php
		} else if($transaction_type == 'refund') {
			$que2 ="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('2','s2','cb2') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
			$data2 = $db->rawQuery($que2);
			if($data2) {
				foreach($data2 as $var2){
					$refund_count = $var2['countt'];
					$refund_amount= $var2['total'];
				}
			}
			?>
			<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
				<thead>
					<tr>
						<th>Transactions Type</th>        
						<th>Number of Transaction</th>
						<th>Total Amount</th>   
					</tr>      
				</thead>		
				<tbody>  
					<tr class="gradeA even" role="row">
						<td class="sorting_1">Total Refund Transactions</td>				
						<td><?php if($refund_count==''){ echo '0'; } else { echo $refund_count; } ?></td>
						<td><?php if($refund_amount==''){ echo '0'; } else { $refund_amount = $refund_amount/100; echo "-". number_point($refund_amount); } ?></td>			
					</tr>       
				</tbody>
				<!-- <tfoot>
					<tr>
						<th rowspan="1" colspan="1">Transactions</th>      
						<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
						<th tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
					</tr>
				</tfoot> -->
			</table> 
			<?php
		} else if($transaction_type == 'cancel') {
			$que3 ="SELECT COUNT(DISTINCT gp_transaction.gp_transaction_id) AS countt, SUM(gp_transaction.gp_amount) AS total FROM merchants JOIN gp_transaction ON gp_transaction.gp_merchant_id = merchants.mer_map_id AND merchants.userid= '$iid' AND gp_transaction.gp_transaction_type IN ('3','s4') AND gp_transaction.gp_status='success' AND gp_transaction.gp_trans_datetime>='$sdate' AND gp_transaction.gp_trans_datetime<='$edate'";
			$data3 = $db->rawQuery($que3);
			if($data3) {
				foreach($data3 as $var3){
					$cancel_count = $var3['countt'];
					$cancel_amount= $var3['total'];
				}
			}
			?>
			<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
				<thead>
					<tr>
						<th>Transactions Type</th>        
						<th>Number of Transaction</th>
						<th>Total Amount</th>
					</tr>         
				</thead>		
			<tbody> 
				<tr class="gradeA odd" role="row">
					<td class="sorting_1">Total Cancel Transactions </td>				
					<td><?php if($cancel_count=='') { echo '0';} else { echo $cancel_count; } ?></td>
					<td><?php if($cancel_amount==''){ echo '0';} else { $cancel_amount = $cancel_amount/100 ; echo "-".number_point($cancel_amount); } ?></td>	
				</tr>		
			</tbody>
			<!-- <tfoot>
				<tr>
					<th rowspan="1" colspan="1">Transactions</th>   
					<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
					<th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
				</tr>
			</tfoot> -->
			</table> 
			<?php
		}
}

exit;

die();


if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='0' && $transaction_type=='0') {

	$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' group by cancel_flag";
    $que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id Group By refund_flag";
    $que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction_alipay";


						$data1 = $db->rawQuery($que1); 
						$data2 = $db->rawQuery($que2); 
						$data3 = $db->rawQuery($que3); 
							foreach($data1 as $var1){
								 $number_count = $var1['countc'];
								 $cancel_amount= $var1['total'];
							}
							foreach($data2 as $var2){
								 $refund_count = $var2['countr'];
								 $refund_amount= $var2['total'];
							}
							foreach($data3 as $var3){
								 $total_count = $var3['countt'];
								 $total_amount= $var3['total'];
							}
  ?>
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>       
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Sale Transactions</td>				
				<td><?php echo $total_count; ?></td>
				<td><?php $total_amount = $total_amount/100; echo number_point($total_amount); ?></td>			
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php echo $refund_count; ?></td>
				<td><?php $refund_amoun = $refund_amount/100; echo number_point($refund_amount); ?></td>				
		  </tr>
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php echo $number_count; ?></td>
				<td><?php $cancel_amount = $cancel_amount/100; echo number_point($cancel_amount); ?></td>				
		  </tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th> 
		<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
        <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
        </tr>
        </tfoot>
      </table>   
	  
<?php } else if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='0' && $transaction_type=='refund') { 
		$que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id Group By refund_flag";
				$data2 = $db->rawQuery($que2); 
				foreach($data2 as $var2){
					 $refund_count = $var2['countr'];
					 $refund_amount= $var2['total'];
							
				}
?>
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
		<tbody>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php echo $refund_count; ?></td>
				<td><?php  $refund_amount = $refund_amount/100; echo number_point($refund_amount); ?></td>				
		  </tr>     
		</tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>     
			<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>  
<?php  }  else if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='0' && $transaction_type=='sale' ) { 
		$que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction";
				$data3 = $db->rawQuery($que3); 
					foreach($data3 as $var3){
						 $total_count = $var3['countt'];
						 $total_amount= $var3['total'];
								
					} 	 	
?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>
		      <tbody>             
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php echo $total_count; ?></td>
				<td><?php $total_amount = $total_amount/100; echo number_point($total_amount); ?></td>				
		  </tr>   
		</tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>             
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>  

<?php  } else if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='0' && $transaction_type=='cancel') {  

		$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' group by cancel_flag";   
				$data1 = $db->rawQuery($que1);
				foreach($data1 as $var1){
					 $number_count = $var1['countc'];
					 $cancel_amount= $var1['total'];
							
} ?>
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>  
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php echo $number_count; ?></td>
				<td><?php $cancel_amount = $cancel_amount/100; echo number_point($cancel_amount); ?></td>
			</tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>       
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>   
 
<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='0' && $transaction_type=='0') { 

	$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' AND  trans_datetime>='$sdate' AND trans_datetime<='$edate' group by cancel_flag ";
   $que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id where trans_datetime>='$sdate' AND trans_datetime<='$edate' Group By refund_flag ";
   $que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction where trans_datetime>='$sdate' AND trans_datetime<='$edate'";
					$data1 = $db->rawQuery($que1); 
					$data2 = $db->rawQuery($que2); 
					$data3 = $db->rawQuery($que3); 
		foreach($data1 as $var1){
			 $number_count = $var1['countc'];
			 $cancel_amount= $var1['total'];
					
		}
		foreach($data2 as $var2){
			 $refund_count = $var2['countr'];
			 $refund_amount= $var2['total'];
					
		}
		foreach($data3 as $var3){
			 $total_count = $var3['countt'];
			 $total_amount= $var3['total'];
					
		}
 ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
     <tbody>       
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Sale Transactions</td>				
				<td><?php if($total_count=='0'){ echo '0'; } else{ echo $total_count; }?></td>
				<td><?php if($total_amount==''){ echo '0'; } else{ $total_amount = $total_amount/100; echo number_point($total_amount); }?></td>				
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php if($refund_count==''){ echo '0'; } else { echo $refund_count; } ?></td>
				<td><?php if($refund_amount==''){ echo '0'; } else { $refund_amount = $refund_amount/100; echo number_point($refund_amount); } ?></td>				
		  </tr>
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php if($number_count=='') { echo '0';} else { echo $number_count; } ?></td>
				<td><?php if($cancel_amount==''){ echo '0';} else { $cancel_amount = $cancel_amount/100; echo number_point($cancel_amount); } ?></td>				
		  </tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>       
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>   

<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='0' && $transaction_type=='cancel'){ 
	$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' AND  trans_datetime>='$sdate' AND trans_datetime<='$edate' group by cancel_flag "; 
				$data1 = $db->rawQuery($que1); 
				foreach($data1 as $var1){
					 $number_count = $var1['countc'];
					 $cancel_amount= $var1['total'];
}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody> 
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php if($number_count=='') { echo '0';} else { echo $number_count; } ?></td>
				<td><?php if($cancel_amount==''){ echo '0';} else { $cancel_amount = $cancel_amount /100; echo number_point($cancel_amount); } ?></td>	
				
		  </tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>   
			<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table> 
<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='0' && $transaction_type=='refund') {
   $que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id where trans_datetime>='$sdate' AND trans_datetime<='$edate' Group By refund_flag ";   
		$data2 = $db->rawQuery($que2); 
		foreach($data2 as $var2){
			 $refund_count = $var2['countr'];
			 $refund_amount= $var2['total'];					
		}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>  
           <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
			<td><?php if($refund_count==''){ echo '0'; } else { echo $refund_count; } ?></td>
				<td><?php if($refund_amount==''){ echo '0'; } else { $refund_amount = $refund_amount/100; echo number_point($refund_amount); } ?></td>			
		  </tr>       
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>      
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>  
<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='0' && $transaction_type=='sale') {
	   $que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction where trans_datetime>='$sdate' AND trans_datetime<='$edate'";
  
			$data3 = $db->rawQuery($que3); 
			foreach($data3 as $var3){
				 $total_count = $var3['countt'];
				 $total_amount= $var3['total'];						
			}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>       
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Sale Transactions</td>				
				<td><?php if($total_count=='0'){ echo '0'; } else{ echo $total_count; }?></td>
				<td><?php if($total_amount==''){ echo '0'; } else{ $total_amount = $total_amount/100; echo
                number_point($total_amount); }?></td>					
		  </tr>        
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>  
                <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>   


<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='USD' && $transaction_type=='0') { 

	$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' AND  trans_datetime>='$sdate' AND trans_datetime<='$edate' group by cancel_flag ";
   $que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id where trans_datetime>='$sdate' AND trans_datetime<='$edate' Group By refund_flag ";
   $que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction where trans_datetime>='$sdate' AND trans_datetime<='$edate'";   
					 
					$data1 = $db->rawQuery($que1); 
					$data2 = $db->rawQuery($que2); 
					$data3 = $db->rawQuery($que3); 
							foreach($data1 as $var1){
								 $number_count = $var1['countc'];
								 $cancel_amount= $var1['total'];										
							}
							foreach($data2 as $var2){
								 $refund_count = $var2['countr'];
								 $refund_amount= $var2['total'];										
							}
							foreach($data3 as $var3){
								 $total_count = $var3['countt'];
								 $total_amount= $var3['total'];										
						}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
     <tbody>       
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Sale Transactions</td>				
				<td><?php if($total_count=='0'){ echo '0'; } else{ echo $total_count; }?></td>
				<td><?php if($total_amount==''){ echo '0'; } else{ $total_amount= $total_amount/100; echo 
                    number_point($total_amount); }?></td>				
		  </tr>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php if($refund_count==''){ echo '0'; } else { echo $refund_count; } ?></td>
				<td><?php if($refund_amount==''){ echo '0'; } else { $refund_amount = $refund_amount/100; echo number_point($refund_amount); } ?></td>				
		  </tr>
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php if($number_count=='') { echo '0';} else { echo $number_count; } ?></td>
				<td><?php if($cancel_amount==''){ echo '0';} else { $cancel_amount = $cancel_amount/100;  echo number_point($cancel_amount); } ?></td>				
		  </tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>             
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>   
	
<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='USD' && $transaction_type=='sale') {
	$que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction where trans_datetime>='$sdate' AND trans_datetime<='$edate'";
  
			$data3 = $db->rawQuery($que3); 
			foreach($data3 as $var3){
				 $total_count = $var3['countt'];
				 $total_amount= $var3['total'];						
			}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>       
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Sale Transactions</td>				
				<td><?php if($total_count=='0'){ echo '0'; } else{ echo $total_count; }?></td>
				<td><?php if($total_amount==''){ echo '0'; } else{$total_amount=$total_amount/100; echo  number_point($total_amount); }?></td>			
		  </tr>        
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>  
                <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table> 
<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='USD' && $transaction_type=='refund'){
$que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id where trans_datetime>='$sdate' AND trans_datetime<='$edate' Group By refund_flag ";   
		$data2 = $db->rawQuery($que2); 
		foreach($data2 as $var2){
			 $refund_count = $var2['countr'];
			 $refund_amount= $var2['total'];					
		}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>  
           <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php if($refund_count==''){ echo '0'; } else { echo $refund_count; } ?></td>
				<td><?php if($refund_amount==''){ echo '0'; } else { $refund_amount = $refund_amount/100; echo number_point($refund_amount); } ?></td>					
		  </tr>       
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>      
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>
<?php } else if($date_timepicker_start!='' && $date_timepicker_end!=''  && $currencies=='USD' && $transaction_type=='cancel'){ 
$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' AND  trans_datetime>='$sdate' AND trans_datetime<='$edate' group by cancel_flag "; 
				$data1 = $db->rawQuery($que1); 
				foreach($data1 as $var1){
					 $number_count = $var1['countc'];
					 $cancel_amount= $var1['total'];
}
  ?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody> 
          <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php if($number_count=='') { echo '0';} else { echo $number_count; } ?></td>
				<td><?php if($cancel_amount==''){ echo '0';} else { $cancel_amount = $cancel_amount/100; echo number_point($cancel_amount); } ?></td>	
		  </tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>   
			<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>
<?php }  else if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='USD' && $transaction_type=='refund') { 
		$que2="SELECT count(refund_flag) as countr,sum(r.refund_amount) as total FROM transaction t INNER JOIN refund r ON r.refund_id = t.refund_id Group By refund_flag";
				$data2 = $db->rawQuery($que2); 
				foreach($data2 as $var2){
					 $refund_count = $var2['countr'];
					 $refund_amount= $var2['total'];
							
				}
?>
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
		<tbody>
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php echo $refund_count; ?></td>
				<td><?php $refund_amount=$refund_amount/100; echo number_point($refund_amount); ?></td>				
		  </tr>     
		</tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>     
			<th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>  
<?php  }  else if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='USD' && $transaction_type=='sale' ) { 
		$que3="select count(id_transaction_id) as countt,sum(total_fee) as total from transaction";
				$data3 = $db->rawQuery($que3); 
					foreach($data3 as $var3){
						 $total_count = $var3['countt'];
						 $total_amount= $var3['total'];
								
					} 	 	
?>		
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>
		      <tbody>             
        <tr class="gradeA even" role="row">
			<td class="sorting_1">Total Refund Transactions</td>				
				<td><?php echo $total_count; ?></td>
				<td><?php $total_amount =$total_amount/100; echo number_point($total_amount); ?></td>				
		  </tr>   
		</tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>             
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>  

<?php  } else if($date_timepicker_start=='' && $date_timepicker_end==''  && $currencies=='USD' && $transaction_type=='cancel') {  

		$que1="select count(cancel_flag) as countc,sum(total_fee) as total from transaction where cancel_flag='1' group by cancel_flag";   
				$data1 = $db->rawQuery($que1);
				foreach($data1 as $var1){
					 $number_count = $var1['countc'];
					 $cancel_amount= $var1['total'];
							
} ?>
<table class="table table-striped table-bordered table-hover" role="grid" aria-describedby="editable_info">
      <thead>
        <tr><th>Transactions Type</th>        
          <th>Number of Transaction</th>
          <th>Total Amount</th>         
        </thead>		
      <tbody>  
        <tr class="gradeA odd" role="row">
			<td class="sorting_1">Total Cancel Transactions </td>				
				<td><?php echo $number_count; ?></td>
				<td><?php $cancel_amount = $cancel_amount/100; echo number_point($cancel_amount); ?></td>
			</tr>		
        </tbody>
      <tfoot>
        <tr><th rowspan="1" colspan="1">Transactions</th>       
          <th tabindex="0"  rowspan="1" colspan="1">Number of Transaction</th>
          <th  tabindex="0"  rowspan="1" colspan="1">Total Amount</th>
          </tr>
        </tfoot>
      </table>

<?php } else {
	echo "Please select Correct Options";
}
?>

