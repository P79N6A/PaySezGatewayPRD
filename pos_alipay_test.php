<?php 
if(isset($_POST['device']) && $_POST['device'] == 'pos_precreate'){

    $ttype = $_POST['ttype']; //print_r($ttype);exit; //description of ttype = transaction type(purchase -1,refund-2,query-3,cancel-4)
    if($ttype == 1) {  // Purchase request
    	print_r($_POST);exit;
    $device = $_POST['device'];
    $product_code =$_POST['WIDproduct_code'];
    $subject = $_POST['WIDsubject'];
    $terminal_id = $_POST['terminal_no'];
    $amount = $_POST['WIDtotal_fee'];
    $currency = $_POST['currency'];
    $terminal_time = $_POST['timestamp'];
    $out_trade_no = $_POST['WIDout_trade_no'];
    //$ttype = $_POST['ttype'];
    //$refund_amount = $_POST['return_amount'];
    echo $device.'<br>';
    echo $terminal_id.'<br>';
    echo $amount.'<br>';
    echo $currency.'<br>';
    echo $terminal_time.'<br>';
    echo $out_trade_no.'<br>';
    echo $ttype.'<br>';
    echo $string;
    echo $refund_amount;
    echo $product_code;
    echo $subject;
}else if($ttype == 2){
	$device = $_POST['device'];
	$currency = $_POST['currency'];
	$out_trade_no = $_POST['WIDout_trade_no'];
	$partner_refund_id = $_POST['partner_refund_id'];
	$return_amount = $_POST['return_amount'];
    // $product_code =$_POST['WIDproduct_code'];
    // $subject = $_POST['WIDsubject'];
    // $terminal_id = $_POST['terminal_no'];
    // $amount = $_POST['WIDtotal_fee'];
    // $terminal_time = $_POST['timestamp'];
    //$ttype = $_POST['ttype'];
    //$refund_amount = $_POST['return_amount'];
    echo $device.'<br>';
    echo $currency.'<br>';
    echo $out_trade_no.'<br>';
    echo $partner_refund_id.'<br>';
    echo $ttype.'<br>';
    echo $refund_amount;
   }
   else if($ttype == 3){
   	$device = $_POST['device'];
	$out_trade_no = $_POST['WIDout_trade_no'];
    $terminal_id = $_POST['terminal_no'];
    echo $device.'<br>';
    echo $out_trade_no.'<br>';
    echo $terminal_id.'<br>';
    echo $ttype;

   } else if($ttype == 4){
	$device = $_POST['device'];
	$out_trade_no = $_POST['WIDout_trade_no'];
	$timestamp = $_POST['timestamp'];
    $terminal_id = $_POST['terminal_no'];
    echo $device.'<br>';
    echo $timestamp.'<br>';
    echo $out_trade_no.'<br>';
    echo $terminal_id.'<br>';
    echo $ttype;

   }
}



?>