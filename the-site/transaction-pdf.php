<?php
$dir = dirname(__FILE__);
require_once('pdf/tcpdf/tcpdf.php');
require_once( 'php/inc_chargebacks.php');

if (!file_exists('transactions/'.$t_id)) {
    mkdir('transactions/'.$t_id, 0777, true);
}
// Include the main TCPDF library (search for installation path).

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

$success = ($trans["success"]==1)?"Succeeded":"Failed";

// Set some content to print
$page1 = '<h5>Transaction Details</h5><table border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Transaction ID</th>
									<td>'.$trans["transaction_id"].'</td>
								</tr>';
								if($is_cb){ 
$page1 .= 						'<tr>
									<th>Processor ID</th>
									<td>'.$processorsname.'</td>
								</tr>';
								} 
$page1 .= 						'<tr>
									<th>Platform ID</th>
									<td>'.$trans["platform_id"].'</td>
								</tr>
								<tr>
									<th>Transaction Type</th>
									<td>'.$trans["action_type"].'</td>
								</tr>
								<tr>
									<th>Amount</th>
									<td>'.number_format($trans["amount"],2).'</td>
								</tr>
								<tr>
									<th>Shipping</th>
									<td>'.number_format($trans["shipping"]).'</td>
								</tr>
								<tr>
									<th>Tax</th>
									<td>'.number_format($trans["tax"],2).'</td>
								</tr>
								<tr>
									<th>Currency</th>
									<td>'.$trans["currency"].'</td>
								</tr>
								<tr>
									<th>Transaction Result</th>
									<td>'.$success.'</td>
								</tr>
								<tr>
									<th>Status</th>
									<td>'.ucfirst($trans["condition"]).'</td>
								</tr>
								<tr>
									<th>Settled Date</th>
									<td>'.$trans["processor_settlement_date"].'</td>
								</tr>
								<tr>
									<th>Authorization Code</th>
									<td>'.$trans["authorization_code"].'</td>
								</tr>
								<tr>
									<th>PO Number</th>
									<td>'.$trans["ponumber"].'</td>
								</tr>
								<tr>
									<th>Order ID</th>
									<td>'.$trans["order_id"].'</td>
								</tr>
								<tr>
									<th>Order Description</th>
									<td>'.$trans["order_description"].'</td>
								</tr>
								<tr>
									<th>Transaction date</th>
									<td>'.$trans["transaction_date"].'</td>
								</tr>
								<tr>
									<th>IP Address</th>
									<td>'.$trans["ipaddress"].'</td>
								</tr>
								<tr>
									<th>Affiliate</th>
									<td>'.$trans["mdf_6"].'</td>
								</tr>
								<tr>
									<th>Affiliate ID</th>
									<td>'.$trans["mdf_7"].'</td>
								</tr>
								<tr>
									<th>Rebill</th>
									<td>'.$trans["rebill_number"].'</td>
								</tr>
								<tr>
									<th>Response</th>
									<td>'.$trans["response_text"].'</td>
								</tr>
							</tbody>
						</table>';
$html = <<<page1
$page1
page1;

$pdf->writeHTML($html, true, false, true, false, ''); 

// ---------------------------------------------------------
/**************** page 2*********************/
/*********************************************/
$page2 = '<h5>Credit Card Details</h5><table border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Credit card</th>
									<td>'.$trans["cc_number"].'</td>
								</tr>
								<tr>
									<th>Credit card Type</th>
									<td>'.getCCType($trans["cc_number"]).'</td>
								</tr>
								<tr>
									<th>CC Hash</th>
									<td>'.$trans["cc_hash"].'</td>
								</tr>
								<tr>
									<th>Expire</th>
									<td>'.$trans["cc_exp"].'</td>
								</tr>
							</tbody>
						</table>';

$page2 .= '<br /><br /><h5>Customer Details</h5><table  border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Billing Address:</th>
									<th>Shipping Address:</th>
								</tr>
								<tr>
									<td>'.$trans["first_name"].' '.$trans["last_name"].'<br />'; 
										if($trans["company"] != " ") $page2 .= $trans["company"].'<br />'; 
										$page2 .= $trans["address1"].' '.$trans["address2"].'<br />'; 
										$page2 .= $trans["city"].' '.$trans["us_state"].'<br />'; 
										$page2 .= $trans["postal_code"].' '.$trans["country"].'<br />'; 
										$page2 .= $trans["email"].'<br />'; 
										$page2 .= $trans["phone"].'<br /></td>
									<td>'. $trans["shipping_first_name"].' '.$trans["shipping_last_name"].'<br />'; 
										if($trans["shipping_company"] != " ") $page2 .= $trans["company"].'<br />'; 
										$page2 .= $trans["shipping_address1"].' '.$trans["shipping_address2"].'<br />'; 
										$page2 .= $trans["shipping_city"].' '.$trans["shipping_us_state"].'<br />'; 
										$page2 .= $trans["shipping_postal_code"].' '.$trans["shipping_country"].'<br />'; 
										$page2 .= $trans["shipping_email"].'<br />'; 
										$page2 .= $trans["shipping_carrier"].' '.$trans["tracking_number"].'<br />'; 
										$page2 .= $trans["shipping_date"].'<br /></td>
								</tr>
							</tbody>
						</table>';

$pdf->AddPage();
$html=<<<page2
$page2
page2;

$pdf->writeHTML($html, true, false, true, false, ''); 

// ---------------------------------------------------------
/**************** page 3*********************/
/*********************************************/
$page3 = '<h5>Chargeback Data</h5><table border="1" border-color="#e7eaec"  style="font-size: 14px;padding: 8px 10px;">
							<tbody>
								<tr>
									<th>Refference Number</th>
									<td>'.$cb["ACQ_REF_NR"].'</td>
								</tr>
								<tr>
									<th>Status</th>
									<td>'.$cb["name"].'</td>
								</tr>
								<tr>
									<th>Dispute Result</th>
									<td>'.$cb["dispute_result"].'</td>
								</tr>
								<tr>
									<th>Chargeback Amount</th>
									<td>'.number_format($cb["cb_amount"], 2).'</td>
								</tr>
								<tr>
									<th>Reason Code</th>
									<td>'.$cb["reason_code"].'</td>
								</tr>
								<tr>
									<th>Response Date</th>
									<td>'.$cb["response_date"].'</td>
								</tr>
								<tr>
									<th>Update Date</th>
									<td>'.$cb["update_date"].'</td>
								</tr>
							</tbody>
						</table>';


$pdf->AddPage();
$html=<<<page3
$page3
page3;

$pdf->writeHTML($html, true, false, true, false, ''); 

// reset pointer to the last page 
 $pdf->lastPage(); 

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($dir.'/transactions/'.$t_id.'/transaction-'.$t_id.'.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+
