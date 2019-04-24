<?php
require_once('database_config.php');
$t_id = $_GET['t_id'];
//$t_id = '191175672e35dcfd904b58763060cd7e2d1b45bc';
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Profitorius');
$pdf->SetTitle('Transaction Details');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('Transaction Details');

// set default header data
$pdf->SetHeaderData('Profitorious.png', PDF_HEADER_LOGO_WIDTH, 'Transaction Details' , $t_id, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$page1 = 'page1';
$html = <<<page1
$page1
page1;

$pdf->writeHTML($html, true, false, true, false, ''); 

// ---------------------------------------------------------
/**************** page 2*********************/
/*********************************************/
$page2 = "page2";

$pdf->AddPage();
$html=<<<page2
$page2
page2;

$pdf->writeHTML($html, true, false, true, false, ''); 

// reset pointer to the last page 
 $pdf->lastPage(); 

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('../transactions/transaction.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
