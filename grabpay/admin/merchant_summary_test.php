<?php
// require_once('../php/database_config.php');
// require_once('../phpexcel/Classes/PHPExcel.php');
// require_once('../phpexcel/Classes/PHPExcel/IOFactory.php'); 
require_once 'vendor/autoload.php';  
use Dompdf\Dompdf;
 


            

            // instantiate and use the dompdf class
            $htmlcontent = '
              
                        <link rel="stylesheet" type="text/css"
                href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/css/pdf.css">
            <div class="container">
                <div class="row>
                    <div class=" col-md-12">
                    <center>
                        <h4>Merchant Settlement Summary Report</h4>
                    </center>

                    <div class="col-md-12 mt-40">
                        <div class="row">
                            <table class="offtable">
                                <tbody>
                                    <tr>
                                        <td>Merchant Name</td>
                                        <td>GPtestuser</td>
                                    </tr>
                                    <tr>
                                        <td>DBA Name</td>
                                        <td>DBA Name</td>
                                    </tr>
                                    <tr>
                                        <td>Merchant id</td>
                                        <td>GPT0000001</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>


                    <div class="col-md-12 mt-40">
                        <div class="row">
                            <table class="offtable">
                                <tbody>
                                    <tr>
                                        <td>Mechant Bank A/C No:</td>
                                        <td>GPtestuser</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Code</td>
                                        <td>DBA Name</td>
                                    </tr>
                                    <tr>
                                        <td>Branch Code</td>
                                        <td>GPT0000001</td>
                                    </tr>
                                </tbody>
                            </table>


                            <table class="offtable">
                                <tbody>
                                    <tr>
                                        <td>Statement No</td>
                                        <td>GPtestuser</td>
                                    </tr>
                                    <tr>
                                        <td>Statement Generated Date</td>
                                        <td>DBA Name</td>
                                    </tr>
                                    <tr>
                                        <td>Settlement Currency</td>
                                        <td>GPT0000001</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-12 mt-40">
                        <center>
                            <h4>Transaction Details</h4>
                        </center>
                        <div class="row">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>TID</th>
                                        <th>Transaction Date</th>
                                        <th>Transaction Type</th>
                                        <th>Gross Amount</th>
                                        <th>MDR</th>
                                        <th>Net Amount</th>
                                        <th>Settlement Date</th>
                                    </tr>

                                    <tr>
                                        <td>E0000008</td>
                                        <td>14/01/2019 9:35:27 PM</td>
                                        <td>Sale</td>
                                        <td>200</td>
                                        <td>6.00</td>
                                        <td>194.00</td>
                                        <td>18/01/2019 12:00:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>E0000008</td>
                                        <td>14/01/2019 9:35:27 PM</td>
                                        <td>Sale</td>
                                        <td>200</td>
                                        <td>6.00</td>
                                        <td>194.00</td>
                                        <td>18/01/2019 12:00:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>E0000008</td>
                                        <td>14/01/2019 9:35:27 PM</td>
                                        <td>Sale</td>
                                        <td>200</td>
                                        <td>6.00</td>
                                        <td>194.00</td>
                                        <td>18/01/2019 12:00:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>E0000008</td>
                                        <td>14/01/2019 9:35:27 PM</td>
                                        <td>Sale</td>
                                        <td>200</td>
                                        <td>6.00</td>
                                        <td>194.00</td>
                                        <td>18/01/2019 12:00:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>E0000008</td>
                                        <td>14/01/2019 9:35:27 PM</td>
                                        <td>Sale</td>
                                        <td>200</td>
                                        <td>6.00</td>
                                        <td>194.00</td>
                                        <td>18/01/2019 12:00:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>E0000008</td>
                                        <td>14/01/2019 9:35:27 PM</td>
                                        <td>Sale</td>
                                        <td>200</td>
                                        <td>6.00</td>
                                        <td>194.00</td>
                                        <td>18/01/2019 12:00:00 AM</td>
                                    </tr>
                                    <tr class="lastrow">
                                        <td></td>
                                        <td>Total Transaction Count : 20</td>
                                        <td>Total Amount</td>
                                        <td>8830.00</td>
                                        <td>730.00</td>
                                        <td>8565.00</td>
                                    </tr>

                                    <tr class="lastrow">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Net Settlement</td>
                                        <td
                                            style="border-top: solid 1px #dddddd !important; border-bottom: solid 1px #dddddd !important;">
                                            8565.00</td>
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

?>/'.$pdfname);
            // echo $pdfname;
            // exit;
            header('Content-Type: application/pdf'); 
            header('Content-Disposition: attachment; filename="'.$pdfname.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize('pdf/'.$pdfname));
            flush(); // Flush system output buffer
            readfile('pdf/'.$pdfname);
            exit;

?>