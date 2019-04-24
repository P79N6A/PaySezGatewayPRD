<?php

include_once('php/database_config.php');

    //check permission
    if(!checkPermission('V'))
        include_once('forbidden.php');

$t_id = $_GET['t_id'];
if(isset($t_id) && $t_id !='')
{

	//validate if it is a valid transaction id
	$db->where("id_transaction_id", $t_id);
    $transaction = $db->getOne("transactions");

    if($transaction) {

		//create PDF with the latest data
		include_once ("transaction-pdf.php");

		$dir = "transactions/".$t_id;
		$zip = new ZipArchive();
		$filename = "transactions/tmp/TransactionDetails-".$t_id.".zip";

		//touch($filename);

		if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
			exit("cannot open <$filename>\n");
		}
		$dh  = opendir($dir);
		$io=1;
		while (false != ($docname = readdir($dh))) {
		    if (strpos($docname, 'transaction') !== false) {
                $zip->addFile($dir . '/' . $docname, $docname);

            }
			$io++;
		}

		echo "numfiles: " . $zip->numFiles . "\n";
		echo "status:" . $zip->status . "\n";
		$zip->close();
        header( 'Location: '.$filename ) ;
    } else {
    	die('Not a valid transaction ID.');
    }
}
?>