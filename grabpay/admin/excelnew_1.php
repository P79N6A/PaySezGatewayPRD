<?php
require_once('php/database_config.php');
require_once('phpexcel/Classes/PHPExcel.php');
require_once('phpexcel/Classes/PHPExcel/IOFactory.php');


// Create new PHPExcel object



          // $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='GPT0000001' AND vendor_config.vendor_name='grabpay'";

          // $vendor_details = $db->rawQuery($sql); 
          // $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
          // $grabpay_MDR = explode('|',$merchants_MDR);

       //    // function excelnew(){
       // print_r($_POST);
       // die();
      if($_GET['merchant_id'] && $_GET['date']) {
          
          $merchant_id = $_GET['merchant_id'];

          $date = $_GET['date'];


            function getPercentOfNumber($number, $percent){
                      return ($percent / 100) * $number;
            }
            function number_point($value) {
              $myAngloSaxonianNumber = number_format($value, 2, '.', ','); // -> 5,678.90 
              return $myAngloSaxonianNumber;
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
                    'size'  => 13
                ));

            $objPHPExcel->getActiveSheet()->setCellValue('A1', "Daily Merchant Settlement Details".'('.$$merchants_bankDetails['0']['mer_map_id'].')');


            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);


            $objPHPExcel->getActiveSheet()->setCellValue('B3', "1557 keppal Road");

            $objPHPExcel->getActiveSheet()->setCellValue('B4', "Singapore");

            $objPHPExcel->getActiveSheet()->setCellValue('A7', "Merchant ID  :   GPT0000001");
            $objPHPExcel->getActiveSheet()->setCellValue('A8', "Bank Id         :".$merchants_bankDetails['0']['ifsccode']);

            $objPHPExcel->getActiveSheet()->setCellValue('A9', "Account number  :".$merchants_bankDetails['0']['accountno']);

            $objPHPExcel->getActiveSheet()->setCellValue('G7', "Statement No  :");
            
            $objPHPExcel->getActiveSheet()->setCellValue('G8', "Statement Generated Date :");
             
             $objPHPExcel->getActiveSheet()->setCellValue('H8',$today = date("F j, Y, g:i a"));
             
             $objPHPExcel->getActiveSheet()->setCellValue('G9', "Settlement Currency");
             
             $objPHPExcel->getActiveSheet()->setCellValue('H9', "SGD");

             $objPHPExcel->getActiveSheet()->setCellValue('C10', "Transaction Details");

            $objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($styleArray_tr);
            
            $objPHPExcel->createSheet();

            for ($col = 'A'; $col != 'J'; $col++) {
                   $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                            }
             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A11:I11');

             $objPHPExcel->getActiveSheet()->getStyle("A12")->getFont()->setBold(true);

             //$objPHPExcel->getActiveSheet()->getStyle('A10:I10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             //$objPHPExcel->getActiveSheet()->getStyle('A10:I10')->getFill()->getStartColor()->setARGB('29bb04');
                            // Add some data
             $objPHPExcel->getActiveSheet()->getStyle("A12:J12")->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('A12:J12')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // Rename sheet

              // $objPHPExcel->getActiveSheet()->getStyle('B12:J12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              //$db->where('gp_transaction_type','1');
             //echo "<pre>";
              $db->where('mer_map_id',$merchant_id);
              $merchants_idmerchants =$db->get('merchants');
              //print_r($merchants_terminal['0']['idmerchants']);
              $merchant_id = $merchants_idmerchants['0']['idmerchants'];
              //echo $merchant_id;
              $db->where('idmerchants',$merchant_id);
              //print_r($db);

              $Terminal_ids = $db->get('terminal');
              $i=12;

              //$previous_date = date('Y-m-d', strtotime(' +1 day'));
              //$prev_date = date('Y-m-d');


              //$objPHPExcel->getActiveSheet()->getStyle('E13:J13')->getNumberFormat()->setFormatCode('#,##0.00');

              foreach ($Terminal_ids as $details){
                    //echo $details['mso_terminal_id'];
                   $objPHPExcel->getActiveSheet()->getStyle("A".$i.":J".$i)->getFont()->setBold(true);
                   $objPHPExcel->setActiveSheetIndex(0)
                               ->setCellValue('B'.$i, 'Terminal_id')
                               ->setCellValue('C'.$i, 'Transaction date')
                               ->setCellValue('D'.$i, 'Transaction type')
                               ->setCellValue('E'.$i, 'Gross Amount')
                               ->setCellValue('F'.$i, 'MDR')
                               ->setCellValue('G'.$i, 'Net Payment')
                               ->setCellValue('H'.$i, 'Settlement Date');

                    $objPHPExcel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray(
                              array(
                                  'fill' => array(
                                      'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                      'color' => array('rgb' => 'FFFF4D')
                                  )
                              ));

                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $r=1;
                       //$db->where('gp_transaction_type','1');
                       //$db->where('gp_merchant_id','GPT0000001');
                       //$db->where('gp_terminal_id',$details['mso_terminal_id']);
                       //$db->where('gp_status','success');
                    $terminal_id = $details['mso_terminal_id'];
                        // echo $terminal_id;
                        // echo "<br>";
                    $sql ="SELECT * FROM gp_transaction WHERE gp_merchant_id ='GPT0000001' AND  gp_transaction_type='1' AND gp_status='success' AND gp_terminal_id='$terminal_id' AND gp_trans_date = $date";
                       //$details1=$db->get('gp_transaction');
                    $details1 = $db->rawQuery($sql);

                    $i++;

                    $len = count($details1);

                    if (!empty($details1)) {
                        
                                      foreach($details1 AS $subrow) {

                                            // echo "<pre>";
                                            //echo $subrow['gp_terminal_id'];
                                            //echo "<br>";

                                          

                                            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                            $objPHPExcel->getActiveSheet()->getStyle('E'.$i.':J'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                            $objPHPExcel->getActiveSheet()
                                              ->getStyle('B'.$i.':J'.$i)
                                              ->getAlignment()
                                              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                             // Miscellaneous glyphs, UTF-8
                                             $objPHPExcel->setActiveSheetIndex(0)
                                                          ->setCellValue('A'.$i, $r)
                                                          ->setCellValue('B'.$i, $subrow['gp_terminal_id'])
                                                          ->setCellValue('C'.$i, $subrow['gp_trans_datetime'])
                                                          ->setCellValue('D'.$i, "sale")
                                                          ->setCellValue('E'.$i, $subrow['gp_amount'] =number_point($subrow['gp_amount'])/100)
                                                          ->setCellValue('F'.$i, $subrow['mdr_amount']=getPercentOfNumber($subrow['gp_amount'],$grabpay_MDR['1']))
                                                          ->setCellValue('G'.$i, $subrow['net_amount']=$subrow['gp_amount']-$subrow['mdr_amount'])
                                                          ->setCellValue('H'.$i,$date);
                                                  
                                                            $sum+=$subrow['gp_amount'];
                                                            $summdr+=$subrow['mdr_amount'];
                                                            $sumnet+=$subrow['net_amount'];
                                                            $sumdate+=$date;
                                                             $i++;
                                                          	 $r++;
                                          // echo $sum;
                                          // echo "<br>";
                                          }
                            } else {
                                            $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('A'.$i, $r)
                                            ->setCellValue('B'.$i, $terminal_id)
                                            ->setCellValue('C'.$i, '0')
                                            ->setCellValue('D'.$i, "0 sale")
                                            ->setCellValue('E'.$i, '0')
                                            ->setCellValue('F'.$i, '0')
                                            ->setCellValue('G'.$i, '0')
                                            ->setCellValue('H'.$i, $date);
                                              $sum='0';
                                              $summdr='0';
                                              $sumnet='0';
                                              $sumdate='0';
                            }
                           
                           $i++;
                          $objPHPExcel->getActiveSheet()->getStyle('E'.$i.':J'.$i)->getNumberFormat()->setFormatCode('#,##0.00');

                          $objPHPExcel->getActiveSheet()
                                      ->getStyle('B'.$i.':J'.$i)
                                      ->getAlignment()
                                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                           $objPHPExcel->setActiveSheetIndex(0)
                                       ->setCellValue('B'.$i, 'Total transaction Count:'.$no=$r-1)
                                       ->setCellValue('C'.$i, "Total Amount")
                                       ->setCellValue('D'.$i, "amount")
                                       ->setCellValue('E'.$i, $sum)
                                       ->setCellValue('F'.$i, $summdr)
                                       ->setCellValue('G'.$i, $sumnet)
                                       ->setCellValue('H'.$i, $sumdate)
                                       ->setCellValue('F'.$i=$i+4, "Net Settlement")
                                       ->setCellValue('G'.$i, $sumnet);//
                            $sum=0;
                            $summdr=0;
                            $sumnet=0;
                            $$sumdate=0;
                            $sumnet=0;
                          $i=$i+5;
              }

          $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$i=$i+4,'*This is a system generated statement.');           
          $objPHPExcel->getActiveSheet()->setTitle('Name of Sheet 1');
          //       // // Create a new worksheet, after the default sheet

          // Redirect output to a client’s web browser (Excel5)
         // $filepath = "https://paymentgateway.test.credopay.in/testspaysez/grabpay/admin/";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;Merchant_id(GPT0000001).xls');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            //return $filepath;
        }
?>