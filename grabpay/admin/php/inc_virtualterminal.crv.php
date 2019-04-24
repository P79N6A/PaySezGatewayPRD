
<?php 

$zip = new ZipArchive();
$filename = "./test112.zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

$zip->addFromString("testfilephp.txt" . time(), "#1 This is a test string added as testfilephp.txt.\n");
$zip->addFromString("testfilephp2.txt" . time(), "#2 This is a test string added as testfilephp2.txt.\n");
$zip->addFile($thisdir . "/too.php","/testfromfile.php");
echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();
/*
https://secure.profitorius.com/cgi-bin/api.pl?username=yourusername&password=yourpassword&processor=xx&type=void&tid=nnnnnnnnnnnnnn
https://secure.profitorius.com/cgi-bin/api.pl?username=yourusername&password=yourpassword&processor=xx&type=capture&tid=nnnnnnnnnnnnnn&tamnt=90.00
https://secure.profitorius.com/cgi-bin/api.pl?username=yourusername&password=yourpassword&processor=xx&type=refund&tid=nnnnnnnnnnnnnn&tamnt=85.00
$response = file_get_contents('http://example.com/path/to/api/call?param1=5');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "THE URL TO THE SERVICE");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, POST DATA);
$result = curl_exec($ch);


print_r($result);
curl_close($ch);

$result = file_get_contents('http://accounting.cardgenius.com/api/api.php?rquest=buyPoints&email='.$_POST["email"].'&award='.$award.'&award_type='.$award_type.'&reason=purchase', 0, stream_context_create(array( 'http' => array( 'timeout' => 1 ) ) ));
$result = json_decode($result, true);
*/
?>