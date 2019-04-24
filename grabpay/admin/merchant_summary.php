<?php
require_once('php/database_config.php');
require_once('phpexcel/Classes/PHPExcel.php');
require_once('phpexcel/Classes/PHPExcel/IOFactory.php');
// ini_set('precision', '15');

// Create new PHPExcel object

          

          // $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='GPT0000001' AND vendor_config.vendor_name='grabpay'";

          // $vendor_details = $db->rawQuery($sql); 
          // $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
          // $grabpay_MDR = explode('|',$merchants_MDR);

          // function excelnew(){

          if ($_GET['merchant_id']) {


            $merchant_id = $_GET['merchant_id'];

            $date = (isset($_GET['date'])) ? date('Y-m-d ',strtotime($_GET['date'])) : '';

            //$start_date = (isset($_GET['date'])) ? date('Y-m-d ',strtotime($_GET['date'])) : '';

            
          
            $today = date("dmY");
            $rand = sprintf("%04d", rand(0,9999));
            $unique = $today . $rand;
          

            function getPercentOfNumber($number, $percent){
                      return ($percent / 100) * $number;
            }

            function number_point($value) {
              $myAngloSaxonianNumber = number_format($value, 2, '.', ','); // -> 5,678.90 
              return $myAngloSaxonianNumber;
            }

            $sql ="SELECT * FROM merchants INNER JOIN vendor_config ON vendor_config.pg_merchant_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id' AND vendor_config.vendor_name='grabpay'";

            $sql_query ="SELECT * FROM merchants INNER JOIN merchant_processors_mid ON merchant_processors_mid.mer_map_id = merchants.mer_map_id WHERE merchants.mer_map_id ='$merchant_id'";
            $merchants_bankDetails = $db->rawQuery($sql_query);

            $vendor_details = $db->rawQuery($sql); 
            $merchants_MDR =  $vendor_details['0']['merchant_MDR'];
            $grabpay_MDR = explode('|',$merchants_MDR);

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

          $objPHPExcel->getActiveSheet()->setCellValue('C1', "Merchant Settlement Summary Report");


          $date_1 = date('Y-m-d');

          $date1 = date('Y-m-d', strtotime('-1 day', strtotime($date_1)));


              foreach(range('F3','F6') as $columnID)
              {
                  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
              }

          // $today = date("Ymd");
          // $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
          // $unique = $today . $rand;

          // $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);


          $objPHPExcel->getActiveSheet()->setCellValue('B3', "Merchant Name");

          $objPHPExcel->getActiveSheet()->setCellValue('B4', "DBA Name");

          $objPHPExcel->getActiveSheet()->setCellValue('B5', "Merchant id");

          $objPHPExcel->getActiveSheet()->setCellValue('B6', "Merchant Bank A/c No");

          $objPHPExcel->getActiveSheet()->setCellValue('B7', "Bank Code");

          $objPHPExcel->getActiveSheet()->setCellValue('B8', "Branch Code");

          $objPHPExcel->getActiveSheet()->setCellValue('B9', "Bank Name");



          $objPHPExcel->getActiveSheet()->setCellValue('C3', $merchants_bankDetails['0']['merchant_name']);

          $objPHPExcel->getActiveSheet()->setCellValue('C4', "DBA Name");

          $objPHPExcel->getActiveSheet()->setCellValue('C5', $merchants_bankDetails['0']['mer_map_id']);

          $objPHPExcel->getActiveSheet()->setCellValueExplicit('C6', $merchants_bankDetails['0']['accountno'], PHPExcel_Cell_DataType::TYPE_STRING);

          $objPHPExcel->getActiveSheet()->setCellValue('C7', $merchants_bankDetails['0']['ifsccode']);

          $objPHPExcel->getActiveSheet()->setCellValue('C8', "----");

          $objPHPExcel->getActiveSheet()->setCellValue('C9', "-----");





          $objPHPExcel->getActiveSheet()->setCellValue('E3', "Settlement No");

          

          

         // $objPHPExcel->getActiveSheet()->setCellValue('F3', $unique);

          $objPHPExcel->getActiveSheet()->setCellValueExplicit('F3', $unique, PHPExcel_Cell_DataType::TYPE_STRING);


          $objPHPExcel->getActiveSheet()->setCellValue('E4', "Statement Generated Date");

          $objPHPExcel->getActiveSheet()->setCellValue('F4', $today = date("F j, Y, g:i a"));

          $objPHPExcel->getActiveSheet()->setCellValue('E5', "Settlement Currency");

          $objPHPExcel->getActiveSheet()->setCellValue('F5', $merchants_bankDetails['0']['currency_code']);



            $objPHPExcel->getActiveSheet()
                        ->getStyle('F3:F6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        //   $objPHPExcel->getActiveSheet()->setCellValue('G7', "Statement No  :");
          
        //   $objPHPExcel->getActiveSheet()->setCellValue('G8', "Statement Generated Date :");
           
        //    $objPHPExcel->getActiveSheet()->setCellValue('H8',$today = date("F j, Y, g:i a"));
           
        //    $objPHPExcel->getActiveSheet()->setCellValue('G9', "Settlement Currency");
           
        //    $objPHPExcel->getActiveSheet()->setCellValue('H9', "SGD");

        //    $objPHPExcel->getActiveSheet()->setCellValue('C10', "Transaction Details");

        //   $objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($styleArray_tr);
          
         $objPHPExcel->createSheet();

          for ($col = 'A'; $col != 'F'; $col++) {
                 $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
              }
          // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A11:I11');

           $objPHPExcel->getActiveSheet()->getStyle("A9")->getFont()->setBold(true);

           //$objPHPExcel->getActiveSheet()->getStyle('A9:G9')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

           //$objPHPExcel->getActiveSheet()->getStyle('B10:G10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        //    $i=9;
        // for ($col = 'A'; $col != 'F'; $col++) {
        //          $objPHPExcel->getActiveSheet()->getColumnDimension($col.$i)->setAutoSize(true);
        //          $i++;
        //       }

           $objPHPExcel->getActiveSheet()->setCellValue('B10', "Description");

           $objPHPExcel->getActiveSheet()->setCellValue('C10', "Settlement Date");

           $objPHPExcel->getActiveSheet()->setCellValue('D10', "Trans Count");

           $objPHPExcel->getActiveSheet()->setCellValue('E10', "Gross Amount");

           $objPHPExcel->getActiveSheet()->setCellValue('F10', "MDR");

           $objPHPExcel->getActiveSheet()->setCellValue('G10', "Net Amount");

           $objPHPExcel->getActiveSheet()->getStyle('A10:G10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

          //    //$objPHPExcel->getActiveSheet()->getStyle('A10:I10')->getFill()->getStartColor()->setARGB('29bb04');
        //                   // Add some data
           $objPHPExcel->getActiveSheet()->getStyle("B10:G10")->getFont()->setBold(true);

    


            $sql ="SELECT count(gp_transaction_id) as trans_count,sum(gp_amount) as total  FROM gp_transaction WHERE gp_merchant_id ='$merchant_id' AND  gp_transaction_type='1'  AND gp_status='success' AND gp_trans_date = '$date'";

            $details = $db->rawQuery($sql);

             $sql_query ="SELECT count(gp_transaction_id) as trans_count,sum(gp_amount) as total  FROM gp_transaction WHERE gp_merchant_id ='$merchant_id' AND  gp_transaction_type='2' AND gp_status='success' AND gp_trans_date = '$date'";

            $details_refund = $db->rawQuery($sql_query);

            $objPHPExcel->getActiveSheet()->setCellValue('B13', "Grapay");

            $objPHPExcel->getActiveSheet()->setCellValue('B15', "Alipay");


            $objPHPExcel->getActiveSheet()->setCellValue('B17', "Wechat");


            $objPHPExcel->getActiveSheet()->setCellValue('B21', "Refund Transaction:-");

            $objPHPExcel->getActiveSheet()->setCellValue('E19', "Total Payable Amount");

            $objPHPExcel->getActiveSheet()->getStyle("B21")->getFont()->setBold(true);

             $objPHPExcel->getActiveSheet()->setCellValue('B23', "Grapay");

             $date = date('d/m/Y', strtotime($date));

            $objPHPExcel->getActiveSheet()->setCellValue('C13', $date);


            $objPHPExcel->getActiveSheet()->setCellValue('C15', $date);


            $objPHPExcel->getActiveSheet()->setCellValue('C17', $date);

            $objPHPExcel->getActiveSheet()->setCellValue('C23', $date);


            //$objPHPExcel->getActiveSheet()->setCellValue('F3', $date);

            // $objPHPExcel->getActiveSheet()->setCellValue('E24', "Total Payable Amount");
            $objPHPExcel->getActiveSheet()->getStyle("E19")->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

            $objPHPExcel->getActiveSheet()
                        ->getStyle('B:G')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $objPHPExcel->getActiveSheet()->setCellValue('D13', $details['0']['trans_count']);


            $objPHPExcel->getActiveSheet()->setCellValue('E13','$ '.$details['total'] = number_point($details['0']['total']/100));

            $objPHPExcel->getActiveSheet()->setCellValue('F13','$ '.$details['mdr'] = number_point(getPercentOfNumber($details['total'],$grabpay_MDR['1'])));

            $objPHPExcel->getActiveSheet()->setCellValue('G13','$ '.$details['net'] = number_point($details['total']-$details['mdr']));




            $objPHPExcel->getActiveSheet()->setCellValue('D15', $details_alipay['0']['trans_count'] = 0);


            $objPHPExcel->getActiveSheet()->setCellValue('E15','$ '.$details_alipay['total'] = number_point($details_alipay['0']['total']/100));

            $objPHPExcel->getActiveSheet()->setCellValue('F15','$ '.$details['mdr'] = number_point(getPercentOfNumber($details_alipay['total'],$grabpay_MDR['1'])));

            $objPHPExcel->getActiveSheet()->setCellValue('G15','$ '.$details_alipay['net'] = number_point($details_alipay['total']-$details_alipay['mdr']));




            $objPHPExcel->getActiveSheet()->setCellValue('D17',$details_wechat['0']['trans_count'] = 0);


            $objPHPExcel->getActiveSheet()->setCellValue('E17','$ '.$details_wechat['total'] = number_point($details_wechat['0']['total']/100));

            $objPHPExcel->getActiveSheet()->setCellValue('F17','$ '.$details_wechat['mdr'] = number_point(getPercentOfNumber($details_wechat['total'],$grabpay_MDR['1'])));

            $objPHPExcel->getActiveSheet()->setCellValue('G17','$ '.$details_wechat['net'] = number_point($details_wechat['total']-$details_wechat['mdr']));





            $objPHPExcel->getActiveSheet()->setCellValue('D23', $details_refund['0']['trans_count']);

            $objPHPExcel->getActiveSheet()->setCellValue('E23', '$ '.$details_refund['total']=number_point($details_refund['0']['total']/100));

              // $objPHPExcel->getActiveSheet()->setCellValue('F21', $details_refund['mdr']=getPercentOfNumber($details_refund['total'],$grabpay_MDR['1']));

            $objPHPExcel->getActiveSheet()->setCellValue('G23','$ '.$details_refund['net'] = number_point($details_refund['total']-$details_refund['mdr']));


            $objPHPExcel->getActiveSheet()->getStyle('G23')->getNumberFormat()->setFormatCode('#,##0.00');

               

            $objPHPExcel->getActiveSheet()
                        ->getStyle('C3:C9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objPHPExcel->getActiveSheet()->setCellValue('G19','$ '.$total =number_point($details_wechat['net']+$details['net']+$details_alipay['net'] ));




            $objPHPExcel->getActiveSheet()->getStyle('B27:G27')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              $objPHPExcel->getActiveSheet()->getStyle('B28:G28')->getFill()->getStartColor()->setARGB('29bb04');

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B27:G27');

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B28:G28');

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B29:G29');

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B30:G30');


            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B31:G31');

              //$objPHPExcel->getActiveSheet()->getStyle('A10:I10')->getFill()->getStartColor()->setARGB('29bb04');
            $objPHPExcel->getActiveSheet()->setCellValue('B27',"Merchant will be receiving total Merchant Settlement amount ".' $ '.$total." within Three working days and the payable");
              
            $objPHPExcel->getActiveSheet()->setCellValue('B28',"amount will be credit into Company Bank account accordingly.");


            $objPHPExcel->getActiveSheet()->setCellValue('B30',"Please contact us at inquiry@revopay.sg or +65 6280 1688 if you require any assiatant pertaining to the");

              $objPHPExcel->getActiveSheet()->setCellValue('B31',"Merchant Settlement report.");

       
              $objPHPExcel->getActiveSheet()->setTitle('Merchant_summary_Details');
            //       // // Create a new worksheet, after the default sheet

            // Redirect output to a client’s web browser (Excel5)
              header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="Merchant_Summary Report('.$merchant_id.').xls"');
              header('Cache-Control: max-age=0');
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
              $objWriter->save('php://output');
      }
?>