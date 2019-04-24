<?php
require_once('php/database_config.php');
// require_once('../phpexcel/Classes/PHPExcel.php');
// require_once('../phpexcel/Classes/PHPExcel/IOFactory.php'); 
require_once 'vendor/autoload.php';  
use Dompdf\Dompdf;


function getPercentOfNumber($number, $percent) {
    return ($percent / 100) * $number;
}
function number_point($value) {
    $myAngloSaxonianNumber = number_format($value, 2, '.', ','); // -> 5,678.90 
    return $myAngloSaxonianNumber;
}


if($_GET['merchant_id']) {

      $merchant_id = $_GET['merchant_id'];


      $date = (isset($_GET['date'])) ? date('Y-m-d ',strtotime($_GET['date'])) : '';
        
      $today = date("dmY");
      $rand = sprintf("%04d", rand(0,9999));
      $unique = $today . $rand;

      $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id' AND vendor_config.vendor_name='alipay'";

      $sql_query ="SELECT * FROM merchants INNER JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id'";
            $merchants_bankDetails = $db->rawQuery($sql_query);

      $vendor_details = $db->rawQuery($sql); 
      $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
      $grabpay_MDR = explode('|',$merchants_MDR);


      $date_1 = date('Y-m-d');

      $date1 = date('Y-m-d', strtotime('-1 day', strtotime($date_1)));



      $sql ="SELECT count(id_transaction_id) as trans_count,sum(total_fee ) as total  FROM transaction_alipay WHERE merchant_id ='$merchant_id' AND  transaction_type='1'  AND result_code='SUCCESS' AND trade_status='TRADE_SUCCESS' AND trans_date = '$date'";

      $details_alipay = $db->rawQuery($sql);

      $sql_query ="SELECT count(id_transaction_id) as trans_count,sum(refund_amount) as total  FROM transaction_alipay WHERE merchant_id ='$merchant_id' AND transaction_type='2' AND result_code='success' AND trans_date = '$date'";

      $details_refund = $db->rawQuery($sql_query);

      $date = date('d/m/Y', strtotime($date));

      $today_new = date("F j, Y, g:i a");

      ///grabpay--start--------------------------------//
      $details['0']['trans_count'] =0;

      $details['total'] = number_point($details['0']['total']/100);

      $details['mdr'] = number_point(getPercentOfNumber($details['total'],$grabpay_MDR['1']));

      $details['net'] = number_point($details['total']-$details['mdr']);

      ///grabpay- End---------------------------------//

      ///alipay-start--------------------------------//

      $details_alipay['total'] = number_point($details_alipay['0']['total']);

      $details_alipay['mdr'] = number_point(getPercentOfNumber($details_alipay['total'],$grabpay_MDR['1']));

      $details_alipay['net'] = number_point($details_alipay['total']-$details_alipay['mdr']);

      ///alipay-End---------------------------------//


      ///Wechat-start--------------------------------//
      $details_wechat['0']['trans_count'] = 0;

      $details_wechat['total'] = number_point($details_wechat['0']['total']/100);

      $details_wechat['mdr'] = number_point(getPercentOfNumber($details_wechat['total'],$grabpay_MDR['1']));

      $details_wechat['net'] = number_point($details_wechat['total']-$details_wechat['mdr']);

      ///Wechat-End--------------------------------//


      ///Total amount the all ///
      $total = number_point($details_wechat['net']+$details['net']+$details_alipay['net']);

      /////end///////////////




       ///grabpay_refund-start--------------------------------//

      $details_refund['total']=number_point($details_refund['0']['total']);

      $details_refund['mdr']=number_point(getPercentOfNumber($details_refund['total'],$grabpay_MDR['1']));

      $details_refund['net'] = number_point($details_refund['total']-$details_refund['mdr']);

      ///grabpay_refund-End--------------------------------//
 





            


            // instantiate and use the dompdf class 
            // <link rel="stylesheet" type="text/css" href="https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/css/pdf.css">
            $htmlcontent = '
                     <html>
                        <link rel="stylesheet" type="text/css"
                href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="http://localhost:8080/paysez/admin/css/pdf.css">
            <div class="container" style="    margin-top: -50px;">
               <img src="https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/img/revopay-logo.jpg" width="100px"/>
                <div class="row>
                    <div class=" col-md-10">
                    <center>
                        <h4><b>Merchant Settlement Summary Report</b></h4>
                    </center>

                    <div class="col-md-10" style="margin-top: 20px;">
                        <div class="row">
                            <table class="offtable">
                                <tbody>
                                    <tr>
                                        <td>Merchant Name :</td>
                                        <td>'.$merchants_bankDetails['0']['merchant_name'].'</td>
                                    </tr>
                                    <tr>
                                        <td>DBA Name :</td>
                                        <td>DBA Name</td>
                                    </tr>
                                    <tr>
                                        <td>Merchant id :</td>
                                        <td>'.$merchants_bankDetails['0']['mer_map_id'].'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>


                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="row">
                            <table class="offtable">
                                <tbody>
                                    <tr>
                                        <td>Mechant Bank A/C No :</td>
                                        <td>'.$merchants_bankDetails['0']['accountno'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Code :</td>
                                        <td>'.$merchants_bankDetails['0']['ifsccode'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Branch Code : </td>
                                        <td>----</td>
                                    </tr>
                                </tbody>
                            </table>


                            <table class="offtable">
                                <tbody>
                                    <tr>
                                        <td>Statement No :</td>
                                        <td>'.$unique.'</td>
                                    </tr>
                                    <tr>
                                        <td>Statement Generated Date :</td>
                                        <td>'.$today_new.'</td>
                                    </tr>
                                    <tr>
                                        <td>Settlement Currency :</td>
                                        <td>'.$merchants_bankDetails['0']['currency_code'].'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-10">
                        <center>
                            <h4><b>Transaction Details</b></h4>
                        </center>
                        <div class="row">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Description</th>
                                        <th>Settlement Date</th>
                                        <th>Trans Count</th>
                                        <th>Gross Amount</th>
                                        <th>MDR</th>
                                        <th>Net Amount</th>
                                    </tr>

                                    <tr>
                                        <td>Grapay</td>
                                        <td>'.$date.'</td>
                                        <td>'.$details['0']['trans_count'].'</td>
                                        <td>$ '.$details['total'].'</td>
                                        <td>$ '.$details['mdr'].'</td>
                                        <td>$ '.$details['net'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Alipay</td>
                                        <td>'.$date.'</td>
                                        <td>'.$details_alipay['0']['trans_count'].'</td>
                                        <td>$ '.$details_alipay['total'].'</td>
                                        <td>$ '.$details_alipay['mdr'].'</td>
                                        <td>$ '.$details_alipay['net'].'</td>
                                    </tr>
                                    <tr>
                                        <td>WeChat</td>
                                        <td>'.$date.'</td>
                                        <td>'.$details_wechat['0']['trans_count'].'</td>
                                        <td>$ '.$details_wechat['total'].'</td>
                                        <td>$ '.$details_wechat['mdr'].'</td>
                                        <td>$ '.$details_wechat['net'].'</td>
                                    </tr>
                                    <tr>
                                        <td><b>Refund Transaction:-</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total Payable Amount</b></td>
                                        <td>$ '.$total.'</td>
                                    </tr>
                                    <tr>
                                        <td>Alipay</td>
                                        <td>'.$date.'</td>
                                        <td>'.$details_refund['0']['trans_count'].'</td>
                                        <td>$ '.$details_refund['total'].'</td>
                                        <td>$ '.$details_refund['mdr'].'</td>
                                        <td>$ '.$details_refund['net'].'</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <tr>
                                    <td>  <p> Merchant will be receiving total Merchant Settlement amount <b> $ '.$total.'</b> within Three working days and the payable amount will be credit into Company Bank account accordingly.Please contact us at inquiry@revopay.sg or +65 6280 1688 if you require any assiatant pertaining to the Merchant Settlement report</p> </td>
                                </tr>
                            </table>
                           
                        </div> 
                    </div> 
                    

                </div>
            </div>
            </div>
            </html>
            ';

            // echo $htmlcontent;
            // exit;

            $filename = 'merchant_summary_for_alipay_'.date('Y-m-d').'.pdf';  
            $dompdf = new Dompdf();
            $dompdf->set_option('isRemoteEnabled', TRUE); 
            $dompdf->loadHtml($htmlcontent);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream($filename);

}

?>