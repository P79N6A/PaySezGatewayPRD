<?php  
if($_POST) {
    require_once('api/encrypt.php');

    if($_POST['amount']!='' && $_POST['cardnum']!='' && $_POST['card_cvv']!='' && $_POST['expiry_mm']!='' && $_POST['expiry_yy']!='') {
		$secureData_enc = dec_enc('encrypt', $_POST['amount'].$_POST['cardnum'].$_POST['card_cvv'].$_POST['expiry_mm'].$_POST['expiry_yy']);
		echo $secureData_enc;
    } else if($_POST['amount']!='' && $_POST['bankCode']!='') {
		$secureData_enc = dec_enc('encrypt', $_POST['amount'].$_POST['bankCode']);
		echo $secureData_enc;
    } else if($_POST['amount']!='' && $_POST['prepaid_radio']!='') {
		$secureData_enc = dec_enc('encrypt', $_POST['amount'].$_POST['prepaid_radio']);
		echo $secureData_enc;
    } else {
    	echo '';
    }

    if(isset($_POST['from']) && $_POST['from'] == 'EMI_Cal') {
        // echo "<pre>";
        // print_r($_POST); exit;

        $b_code = explode(":", $_POST['bank_code']);
        $bankCode = $b_code[0];
        $vendor_id = $b_code[1];
        $emi_tenures = explode("~", $b_code[2]);
        $emi_tenures_percent = explode("~", $b_code[3]);
        $min_amount = $b_code[4];
        $pay_amount = $b_code[5];
        $payment_option = $_POST['p_type'];

        // Purchase amount is greater or equal to Bank's minimum transaction amount
        if($min_amount > 0 && $pay_amount >= $min_amount) { 
            $result = '<table class="table table-striped table-bordered table-hover dataTables-example" style="font-family: monospace; font-size: 14px;">';
                //$result .='<table class="table table-hover table-responsive">';
            $result .='<thead style="font-weight: 600;">
                            <tr data-level="header" class="header">
                                <th>EMI<br>Tenure</th>
                                <th>Interest<br>Rate (%)</th>
                                <th>Monthly<br>Payment (EMI)</th>
                                <th>Total<br>Interest Payable</th>
                            </tr>
                        </thead>
                        <tbody>';

            for ($i=0; $i < count($emi_tenures); $i++) { 

                // EMI Calculation
                $amount      = $pay_amount; // 3000;
                $rate[$i]    = ($emi_tenures_percent[$i] / 100) / 12; // Monthly interest rate
                $term[$i]    = $emi_tenures[$i]; // Term in months
                $emi_amt[$i] = $amount * $rate[$i] * (pow(1 + $rate[$i], $term[$i]) / (pow(1 + $rate[$i], $term[$i]) - 1));
                $tot_emi[$i] = $emi_amt[$i] * $term[$i];
                $int_amt[$i] = $tot_emi[$i] - $amount;

                $result .= '<tr class="gradeX">
                            <td><input type="radio" name="emitenure" value="'.$emi_tenures[$i].'"> '.$emi_tenures[$i].' Months</td>
                            <td>'.number_format($emi_tenures_percent[$i], 2).' %</td>
                            <td>Rs. '.number_format($emi_amt[$i], 2).'</td>
                            <td>Rs. '.number_format($int_amt[$i], 2).'</td>
                            </tr>';
            }
            $result .='</tbody></table>';

            $result .='<br><p>Please <a href="'.$_POST['tnc_link'].'" target="_blank">Click here</a> to read the bank Terms and Conditions';

        } else if($min_amount == 0) {
            $result = '<h5 style="color:#e23939;">Selected Bank EMI does not having minimum purchase amount</h5>';
        } else {
            $result = '<h5 style="color:#e23939;">Selected Bank EMI Valid only minimum transaction <br>of Rs. '.$min_amount.'</h5>';
        }
        echo $result;
    }
    
    die();
}