<?php
require_once('php/database_config.php');
require_once('phpexcel/Classes/PHPExcel.php');
require_once('phpexcel/Classes/PHPExcel/IOFactory.php');




      if($_GET['merchant_id']) {
          
          $merchant_id = $_GET['merchant_id'];

          ///$merchant_id = preg_replace('/\s+/', '', $merchant_id);

           //$date = $_GET['date'];



          $start_date = (isset($_GET['period_start_date'])) ? date('Y-m-d ',strtotime($_GET['period_start_date'])) : '';
          $end_date   = (isset($_GET['period_end_date'])) ? date('Y-m-d ',strtotime($_GET['period_end_date'])) : '';


            function getPercentOfNumber($number, $percent){
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


          // print_r($_POST);
          // die();
            $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id' AND vendor_config.vendor_name='grabpay'";

            $sql_query ="SELECT * FROM merchants INNER JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id'";
            $merchants_bankDetails = $db->rawQuery($sql_query);

            $vendor_details = $db->rawQuery($sql); 
            $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
            $grabpay_MDR = explode('|',$merchants_MDR);

            // print_r($merchants_bankDetails);
            // die();

            // Create new PHPExcel object

            $objPHPExcel = new PHPExcel();

            // Create a first sheet, representing sales data
            $objPHPExcel->setActiveSheetIndex(0);
            // $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Daily Merchant Settlement Details ');

            //  $objPHPExcel->getActiveSheet()->setCellValue('C3', "Transaction details");

            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FF0000'),
                    'size'  => 15,
                    'name'  => 'Verdana'
                ));
            $styleArray_tr = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 10
                ));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:J1');

            $objPHPExcel->getActiveSheet()->setCellValue('B1', "Merchant Transaction Detail Report".'('.$merchants_bankDetails['0']['mer_map_id'].')');


           $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);

          // // $objPHPExcel->getActiveSheet()
          //             ->getStyle('A1')
          //             ->getAlignment()
          //             ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // $objPHPExcel->getActiveSheet()->setCellValue('B3', $merchants_bankDetails['0']['address1']);

            // $objPHPExcel->getActiveSheet()->setCellValue('B4', $merchants_bankDetails['0']['country']);

            // $objPHPExcel->getActiveSheet()->setCellValue('A7', "Merchant ID  :   ".$merchants_bankDetails['0']['mer_map_id']);
            // $objPHPExcel->getActiveSheet()->setCellValue('A8', "Bank Id         :".$merchants_bankDetails['0']['ifsccode']);

            // $objPHPExcel->getActiveSheet()->setCellValue('A9', "Account number  :".$merchants_bankDetails['0']['accountno']);

            // // $objPHPExcel->getActiveSheet()->setCellValue('G7', "Statement No  :");
            
            // $objPHPExcel->getActiveSheet()->setCellValue('G8', "Statement Generated Date :");
             
            //  $objPHPExcel->getActiveSheet()->setCellValue('H8',$today = date("F j, Y, g:i a"));
             
            //  $objPHPExcel->getActiveSheet()->setCellValue('G9', "Settlement Currency");
             
            //  $objPHPExcel->getActiveSheet()->setCellValue('H9',$merchants_bankDetails['0']['currency_code'] );

             //$objPHPExcel->getActiveSheet()->setCellValue('C10', "Transaction Details");

            //$objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($styleArray_tr);
            
            $objPHPExcel->createSheet();
            // $j = 6;
            // for ($col = 'A'; $col != 'J'; $col++) {
            //     $objPHPExcel->getActiveSheet()->getColumnDimension($col.$j)->setAutoSize(true);
            // }
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A11:H11');

             $objPHPExcel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);

             //$objPHPExcel->getActiveSheet()->getStyle('A10:I10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             //$objPHPExcel->getActiveSheet()->getStyle('A10:I10')->getFill()->getStartColor()->setARGB('29bb04');
                            // Add some data
             $objPHPExcel->getActiveSheet()->getStyle("A6:J6")->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // Rename sheet

             $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("5");
             $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
             $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
             $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
             $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("25");
             $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("15");
             $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("15");
             $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("10");
             $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("15");
             $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("25");
              // $objPHPExcel->getActiveSheet()->getStyle('B12:J12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              //$db->where('gp_transaction_type','1');
             //echo "<pre>";
              $db->where('mer_map_id',$merchant_id);
              $merchants_idmerchants =$db->get('merchants');
              //print_r($merchants_terminal['0']['idmerchants']);
              $idmerchants = $merchants_idmerchants['0']['idmerchants'];
              //echo $merchant_id;
              $db->where('idmerchants',$idmerchants);
              //print_r($db);



              $Terminal_ids = $db->get('terminal');

              $partner_id = $db->get('grabpay_config');

              $i=6;

              $previous_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
              //$prev_date = date('Y-m-d');


              //$objPHPExcel->getActiveSheet()->getStyle('E13:J13')->getNumberFormat()->setFormatCode('#,##0.00');

              foreach ($Terminal_ids as $details){
                    //echo $details['mso_terminal_id'];
                   $objPHPExcel->getActiveSheet()->getStyle("A".$i.":J".$i)->getFont()->setBold(true);
                   $objPHPExcel->setActiveSheetIndex(0)
                               ->setCellValue('A'.$i, 'S.No')
                               ->setCellValue('B'.$i, 'Payment type')
                               ->setCellValue('C'.$i, 'Transaction ID')
                               ->setCellValue('D'.$i, 'Terminal_id')
                               ->setCellValue('E'.$i, 'Transaction date')
                               ->setCellValue('F'.$i, 'Transaction type')
                               ->setCellValue('G'.$i, 'Gross Amount')
                               ->setCellValue('H'.$i, 'MDR')
                               ->setCellValue('I'.$i, 'Net Payment')
                               ->setCellValue('J'.$i, 'Settlement Date');

                    // $objPHPExcel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray(
                    //           array(
                    //               'fill' => array(
                    //                   'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                   'color' => array('rgb' => 'FFFF4D')
                    //               )
                    //           ));

                    $objPHPExcel->getActiveSheet()
                                      ->getStyle('A'.$i)
                                      ->getAlignment()
                                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $r=1;
                       //$db->where('gp_transaction_type','1');
                       //$db->where('gp_merchant_id','GPT0000001');
                       //$db->where('gp_terminal_id',$details['mso_terminal_id']);
                       //$db->where('gp_status','success');
                    $terminal_id = $details['mso_terminal_id'];
                        // echo $terminal_id;
                        // echo "<br>";
                    $sql ="SELECT * FROM gp_transaction WHERE gp_trans_date >= '$start_date' AND gp_trans_date <= '$end_date' AND gp_merchant_id ='$merchant_id' AND  gp_transaction_type='1' AND gp_status='success' AND gp_terminal_id='$terminal_id' order by gp_trans_datetime";
                       //$details1=$db->get('gp_transaction');
                    $details1 = $db->rawQuery($sql);

                    $i++;

                    $len = count($details1);

                    if (!empty($details1)) {
                        
                                      foreach($details1 AS $subrow) {

                                            // echo "<pre>";
                                            //echo $subrow['gp_terminal_id'];
                                            //echo "<br>";
                                        $subrow['gp_partnerTxID'] = custom_echo($subrow['gp_partnerTxID'],12);
                                          

                                            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('F'.$i.':J'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                            $objPHPExcel->getActiveSheet()
                                              ->getStyle('B'.$i.':J'.$i)
                                              ->getAlignment()
                                              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                             // Miscellaneous glyphs, UTF-8
                                             $objPHPExcel->setActiveSheetIndex(0)
                                                          ->setCellValue('A'.$i, $r)
                                                          ->setCellValue('B'.$i, "Grabpay")
                                                          ->setCellValueExplicit('C'.$i, $subrow['gp_partnerTxID'], PHPExcel_Cell_DataType::TYPE_STRING)
                                                          ->setCellValue('D'.$i, $subrow['gp_terminal_id'])
                                                          ->setCellValue('E'.$i, $subrow['gp_trans_datetime'])
                                                          ->setCellValue('F'.$i, "sale")
                                                          ->setCellValue('G'.$i, $subrow['gp_amount'] = $subrow['gp_amount']/100)
                                                          ->setCellValue('H'.$i, $subrow['mdr_amount']=getPercentOfNumber($subrow['gp_amount'],$grabpay_MDR['1']))
                                                          ->setCellValue('I'.$i, $subrow['net_amount']=$subrow['gp_amount']-$subrow['mdr_amount'])
                                                          ->setCellValue('J'.$i,"---");
                                                            $sum+=$subrow['gp_amount'];
                                                            $summdr+=$subrow['mdr_amount'];
                                                            $sumnet+=$subrow['net_amount'];
                                                            $sumdate+=$previous_date;

                                                             $i++;
                                                          	 $r++;
                                          // echo $sum;
                                          // echo "<br>";
                                          }
                            } else {
                                            $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('A'.$i, $r)
                                            ->setCellValue('B'.$i,"Grabpay")
                                            ->setCellValue('C'.$i, "---")
                                            ->setCellValue('D'.$i, $terminal_id)
                                            ->setCellValue('E'.$i, '0')
                                            ->setCellValue('F'.$i, "0 sale")
                                            ->setCellValue('G'.$i, '0')
                                            ->setCellValue('H'.$i, '0')
                                            ->setCellValue('I'.$i, '0')
                                            ->setCellValue('J'.$i, "---");

                                $objPHPExcel->getActiveSheet()
                                      ->getStyle('A'.$i.':J'.$i)
                                      ->getAlignment()
                                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                                              $sum='0';
                                              $summdr='0';
                                              $sumnet='0';
                                              $sumdate='0';
                            }
                           
                           $i++;
                          $objPHPExcel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->getNumberFormat()->setFormatCode('#,##0.00');

                          $objPHPExcel->getActiveSheet()
                                      ->getStyle('B'.$i.':J'.$i)
                                      ->getAlignment()
                                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                           $objPHPExcel->setActiveSheetIndex(0)
                                       ->setCellValue('B'.$i, '')
                                       ->setCellValue('C'.$i, "")
                                       ->setCellValue('D'.$i, "")
                                       ->setCellValue('E'.$i, "")
                                       ->setCellValue('F'.$i, "")
                                       ->setCellValue('G'.$i, "")
                                       ->setCellValue('H'.$i, "");//
                            $sum=0;
                            $summdr=0;
                            $sumnet=0;
                            $$sumdate=0;
                            $sumnet=0;
                          $i=$i+5;
              }

          $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$i=$i+4,'*This is a system generated statement.');           
          $objPHPExcel->getActiveSheet()->setTitle('Merchant_Transaction_Details');
          //       // // Create a new worksheet, after the default sheet

          // Redirect output to a client’s web browser (Excel5)
         // $filepath = "https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/";
            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;Transaction_Details('.$merchant_id.').xls');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            // $objWriter->save('php://output');



              header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="Merchant_Transaction_Details_For_Grabpay('.$merchant_id.').xls"');
              header('Cache-Control: max-age=0');
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
              $objWriter->save('php://output');
            //return $filepath;
         }
?>