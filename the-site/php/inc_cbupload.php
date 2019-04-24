<?php
require_once('database_config.php');
$user_id = $_SESSION['iid'];
$ds          = DIRECTORY_SEPARATOR;  //1
$t_id = $_POST['transaction_id'];
$cb_id = $_POST['cb_id'];
if (!file_exists('../transactions/'.$t_id)) {
    mkdir('../transactions/'.$t_id, 0777, true);
}
$storeFolder = '../transactions/'.$t_id;   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    if(move_uploaded_file($tempFile,$targetFile))
	{
		//save document info into the database
		$supporting_documents = Array(	"filename" => $_FILES['file']['name'],
										"user_id" => $user_id,
										"cb_id" => $cb_id
		);
		$db->insert('supporting_documents', $supporting_documents);
	}
}
?>      