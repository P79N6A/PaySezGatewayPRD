<?php
require_once('php/database_config.php');
// require_once('phpexcel/Classes/PHPExcel.php');
// require_once('phpexcel/Classes/PHPExcel/IOFactory.php');

require_once 'vendor/autoload.php';   
use Dompdf\Dompdf;

function getPercentOfNumber($number, $percent) {
    return ($percent / 100) * $number;
}
function number_point($value) {
    $myAngloSaxonianNumber = number_format($value, 2, '.', ','); // -> 5,678.90 
    return $myAngloSaxonianNumber;
}
function custom_echo($x, $length) {
     if(strlen($x)<=$length) {
              return $x;
       } else { 
        $y=substr($x,0,$length) . '';
        return $y;
      }
}

if($_GET['merchant_id']) {

      $merchant_id = $_GET['merchant_id'];

      $htmlcontent = '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <link rel="stylesheet" type="text/css" href="https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/css/pdf.css">
                    <div class="container">
                        <div class="row>
                            <div class=" col-md-12">
                            <center>
                                <h4><b>Merchant Transaction Detail Report('.$merchant_id.')</b></h4>
                            </center>
                            <div class="col-md-12 mt-40">
                              <center>
                                  <h4><b>Transaction Details</b></h4>
                              </center>
                              ';


      ///$merchant_id = preg_replace('/\s+/', '', $merchant_id);
      //$date = $_GET['date'];
      $start_date = (isset($_GET['period_start_date'])) ? date('Y-m-d ',strtotime($_GET['period_start_date'])) : '';
      $end_date   = (isset($_GET['period_end_date'])) ? date('Y-m-d ',strtotime($_GET['period_end_date'])) : '';
      // print_r($_POST);
      // die();
      $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id' AND vendor_config.vendor_name='grabpay'";

      $sql_query ="SELECT * FROM merchants INNER JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id'";
      $merchants_bankDetails = $db->rawQuery($sql_query);

      $vendor_details = $db->rawQuery($sql); 
      $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
      $grabpay_MDR = explode('|',$merchants_MDR);

      $db->where('mer_map_id',$merchant_id);
      $merchants_idmerchants =$db->get('merchants');
      //print_r($merchants_terminal['0']['idmerchants']);
      $idmerchants = $merchants_idmerchants['0']['idmerchants'];
      //echo $merchant_id;
      $db->where('idmerchants',$idmerchants);
      //print_r($db);

      $Terminal_ids = $db->get('terminal');

      $partner_id = $db->get('grabpay_config');

      $previous_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));


      foreach ($Terminal_ids as $details){


          $terminal_id = $details['mso_terminal_id'];
            // echo $terminal_id;
            // echo "<br>";
          $sql ="SELECT * FROM gp_transaction WHERE gp_trans_datetime >= '$start_date' AND gp_trans_datetime <= '$end_date' AND gp_merchant_id ='$merchant_id' AND  gp_transaction_type='1' AND gp_status='success' AND gp_terminal_id='$terminal_id' order by gp_trans_datetime ";
           //$details1=$db->get('gp_transaction');
          $details1 = $db->rawQuery($sql);
          if(!empty($details1)){
              $htmlcontent.= '<div class="row">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <th>S.No</th>
                                              <th>Payment type</th>
                                              <th>Transaction ID</th>
                                              <th>Terminal_id</th>
                                              <th>Transaction date</th>
                                              <th>Transaction type</th>
                                              <th>Gross Amount</th>
                                              <th>MDR</th>
                                              <th>Net Payment</th>
                                              <th>Settlement Date</th>
                                          </tr>';
          }
          
          $i=0;
          foreach ($details1 as $trans_Details) {
            $i++;
              // print_r($merchants_bankDetails);
            $trans_Details['gp_amount'] = number_point($trans_Details['gp_amount']/100);
            $trans_Details['mdr_amount'] = number_point(getPercentOfNumber($trans_Details['gp_amount'],$grabpay_MDR['1']));
            $trans_Details['net_amount'] = number_point($trans_Details['gp_amount']-$trans_Details['mdr_amount']);
            $trans_Details['gp_partnerTxID'] = custom_echo($trans_Details['gp_partnerTxID'],12);
            $htmlcontent.= '
              <tr>
                  <td>'.$i.'</td>
                  <td>Grabpay</td>
                  <td>'.$trans_Details['gp_partnerTxID'].'</td>
                  <td>'.$trans_Details['gp_terminal_id'].'</td>
                  <td>'.$trans_Details['gp_trans_datetime'].'</td>
                  <td>sale</td>
                  <td>'.$trans_Details['gp_amount'].'</td>
                  <td>'.$trans_Details['mdr_amount'].'</td>
                  <td>'.$trans_Details['net_amount'].'</td>
                  <td>-----</td>
              </tr>';
          }

          $htmlcontent.= '</tbody>
                                  </table>
                              </div>'; 

      }


      $htmlcontent.= '</div></div></div></div>';


      $filename = uniqid().'.pdf';
      $dompdf = new Dompdf();
      $dompdf->loadHtml($htmlcontent);
      $dompdf->setPaper('A4', 'landscape');
      $dompdf->render();
      $dompdf->stream($filename);


      exit;
      die();
}


      // if($_GET['merchant_id']) {
          
      //     $merchant_id = $_GET['merchant_id'];
      //     ///$merchant_id = preg_replace('/\s+/', '', $merchant_id);
      //     //$date = $_GET['date'];
      //     $start_date = (isset($_GET['period_start_date'])) ? date('Y-m-d ',strtotime($_GET['period_start_date'])) : '';
      //     $end_date   = (isset($_GET['period_end_date'])) ? date('Y-m-d ',strtotime($_GET['period_end_date'])) : '';
      //     // print_r($_POST);
      //     // die();
      //     $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id' AND vendor_config.vendor_name='grabpay'";

      //     $sql_query ="SELECT * FROM merchants INNER JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id'";
      //     $merchants_bankDetails = $db->rawQuery($sql_query);

      //     $vendor_details = $db->rawQuery($sql); 
      //     $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
      //     $grabpay_MDR = explode('|',$merchants_MDR);

      //     $db->where('mer_map_id',$merchant_id);
      //     $merchants_idmerchants =$db->get('merchants');
      //     //print_r($merchants_terminal['0']['idmerchants']);
      //     $idmerchants = $merchants_idmerchants['0']['idmerchants'];
      //     //echo $merchant_id;
      //     $db->where('idmerchants',$idmerchants);
      //     //print_r($db);

      //     $Terminal_ids = $db->get('terminal');

      //     $partner_id = $db->get('grabpay_config');

      //     $previous_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));

      //     $htmlcontent = '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      //               <link rel="stylesheet" type="text/css" href="https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/css/pdf.css">
      //               <div class="container">
      //                   <div class="row>
      //                       <div class=" col-md-12">
      //                       <center>
      //                           <h4>Merchant Transaction Detail Report(GPT0000001)</h4>
      //                       </center>';

      //         foreach ($Terminal_ids as $details){

      //           $htmlcontent.= '<div class="col-md-12 mt-40">
      //                               <center>
      //                                   <h4>Transaction Details</h4>
      //                               </center>
      //                               <div class="row">
      //                                   <table class="table">
      //                                       <tbody>
      //                                           <tr>
      //                                               <th>S.No</th>
      //                                               <th>Payment type</th>
      //                                               <th>Transaction ID</th>
      //                                               <th>Terminal_id</th>
      //                                               <th>Transaction date</th>
      //                                               <th>Transaction type</th>
      //                                               <th>Gross Amount</th>
      //                                               <th>MDR</th>
      //                                               <th>Net Payment</th>
      //                                               <th>Settlement Date</th>
      //                                           </tr>';


      //           $terminal_id = $details['mso_terminal_id'];
      //             // echo $terminal_id;
      //             // echo "<br>";
      //           $sql ="SELECT * FROM gp_transaction WHERE gp_trans_datetime >= '$start_date' AND gp_trans_datetime <= '$end_date' AND gp_merchant_id ='$merchant_id' AND  gp_transaction_type='1' AND gp_status='success' AND gp_terminal_id='$terminal_id' order by gp_trans_datetime ";
      //            //$details1=$db->get('gp_transaction');
      //           $details1 = $db->rawQuery($sql);

      //           $i++;
      //           echo "<pre>";
      //           foreach ($details1 as $merchants_bankDetails) {
      //             print_r($merchants_bankDetails);
      //           }

      //           $htmlcontent.= '</tbody>
      //                                   </table>
      //                               </div>
      //                           </div>'; 

      //         }

      //         $htmlcontent.= '</div>
      //                   </div>
      //                   </div>';

      //         $filename = uniqid().'.pdf';
      //         $dompdf = new Dompdf();
      //         $dompdf->loadHtml($htmlcontent);
      //         $dompdf->setPaper('A4', 'landscape');
      //         $dompdf->render();
      //         $dompdf->stream($filename);

      // }


            
