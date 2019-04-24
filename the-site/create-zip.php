<?php
$t_id = $_GET['t_id'];
if(isset($t_id) && $t_id !='')
{
	//create PDF with the latest data
	include_once ("transaction-pdf.php");
	
	$dir = "transactions/".$t_id;
	$zip = new ZipArchive();
	$filename = "transactions/tmp/TransactionDetails-".$t_id.".zip";

	if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
		exit("cannot open <$filename>\n");
	}

	$dh  = opendir($dir);
	while (false !== ($docname = readdir($dh))) {
		$zip->addFile($dir.'/'.$docname);
	}
	echo "numfiles: " . $zip->numFiles . "\n";
	echo "status:" . $zip->status . "\n";
	$zip->close();
	header( 'Location: '.$filename ) ;
}
?>