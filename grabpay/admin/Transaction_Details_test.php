<?php
// require_once('php/database_config.php');
// require_once('phpexcel/Classes/PHPExcel.php');
// require_once('phpexcel/Classes/PHPExcel/IOFactory.php');
require_once 'vendor/autoload.php';   
use Dompdf\Dompdf;

 


            // instantiate and use the dompdf class
            $htmlcontent = '
              
                        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                        <link rel="stylesheet" type="text/css" href="https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/css/pdf.css">
                        <div class="container">
                            <div class="row>
                                            <div class=" col-md-12">
                                <center>
                                    <h4>Merchant Transaction Detail Report(GPT0000001)</h4>
                                </center> 
                                <div class="col-md-12 mt-40">
                                    <center>
                                        <h4>Transaction Details</h4>
                                    </center>
                                    <div class="row">
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
                                                </tr>

                                                <tr>
                                                    <td>1</td>
                                                    <td>Grabpay</td>
                                                    <td></td>
                                                    <td>GPT000000002</td>
                                                    <td>0</td>
                                                    <td>0 sale</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>-----</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                        </div>
            '; 
            $filename = uniqid().'.pdf';
            $dompdf = new Dompdf();
            $dompdf->loadHtml($htmlcontent);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream($filename);
 
?>