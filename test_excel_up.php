<?php
date_default_timezone_set('Asia/Kolkata');
require_once('php/MysqliDb.php');
require 'kint/Kint.class.php';

$duser = 'yDE/TrQHm18mpS3RrwN/wbPh0kvXAfdIph3FoPlSKEA09bFNyAxe+SqUTvvKokx+Oc86J8zgj4kwo0w2FF6VmNLKhq4lJJ6e86/CKT1pr7X66YKJRy53vg9RU+7x4LZ+|l+qjcJVHfeTV5kmCl5R5ul3BXa8x8UuLd38avQrguZk=';
$dcode = '66AViGfKIS6rl6mKqtQMfGNkm3Ot32VDl09fnnoKvoAAi2UwrHMRonupBTRYTo8EnCNbJnnEFM85B6UqQVPlTRKx5IJCpxo2YGSb3Gut1xsgW/t0QPOEURmGhzqlVFmX|n8yrMY64A6rflVbIZM6uHJYMaddFHoijBjtyQjrFs3c=';

//$db = new Mysqlidb ('localhost', 'wwwreban_xxx', '8#JmVm&PGo-m', 'wwwreban_xxx');
$dkey="ec89434eca0835aa83b0f4cc3553a9dab4c5001366b8bf347637a3e644937967";
require_once('api/encrypt.php');
$userd=mc_decrypt($duser, $dkey);
$passd=mc_decrypt($dcode, $dkey);
$db   = new Mysqlidb ('10.162.104.214', $userd, $passd, 'testSpaysez');
$conn = mysqli_connect('10.162.104.214', $userd, $passd, 'testSpaysez');
// $conn = mysqli_connect("localhost","root","test","phpsamples");

require_once('vendor/php-excel-reader/excel_reader2.php');
// require_once('vendor/SpreadsheetReader.php');

// if (isset($_POST["import"])) {
// 	echo "<pre>";
// 	print_r($_FILES["file"]);
// 	exit;
// }

if (isset($_POST["import"])) {

  	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  	if(in_array($_FILES["file"]["type"],$allowedFileType)) {

  		// echo $_FILES['file']['name']; exit;

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $data = new Spreadsheet_Excel_Reader($targetPath);

		echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
		
		for($i=0;$i<count($data->sheets);$i++) { // Loop to get all sheets in a file.
			
			if(count($data->sheets[$i][cells])>0) { // checking sheet not empty

				echo "Sheet $i:<br /><br />Total rows in sheet ($i+1)  ".count($data->sheets[$i][cells])."<br />";

				for($j=1;$j<=count($data->sheets[$i][cells]);$j++) { // loop used to get each row of the sheet
				 
					// echo $data->sheets[$i][cells][$j][1]."=>".$data->sheets[$i][cells][$j][2]."<br>";
					/*$name 	     = trim($data->sheets[$i][cells][$j][1]);
					$description = trim($data->sheets[$i][cells][$j][2]);

					$query = "insert into tbl_info(name,description) values('".$name."','".$description."')";
					$result = mysqli_query($conn, $query);*/

					$dataDet = Array(
					    "name" => trim($data->sheets[$i][cells][$j][1]),
					    "description" => trim($data->sheets[$i][cells][$j][2])
				    );
				    $id_merchant_id = $db->insert('tbl_info', $dataDet);
				}
			}
		}

	} else { 
	    $type = "error";
	    $message = "Invalid File Type. Upload Excel File.";
	}
}
?>

<!DOCTYPE html>
<html>    
<head>
<style>    
body {
	font-family: Arial;
	width: 550px;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
</head>

<body>
    <h2>Import Excel File into MySQL Database using PHP</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
         
<?php
    $sqlSelect = "SELECT * FROM tbl_info";
    $result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0)
{
?>
        
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>

            </tr>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>                  
        <tbody>
        <tr>
            <td><?php  echo $row['name']; ?></td>
            <td><?php  echo $row['description']; ?></td>
        </tr>
<?php
    }
?>
        </tbody>
    </table>
<?php 
} 
?>

</body>
</html>