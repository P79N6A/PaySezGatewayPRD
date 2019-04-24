<?php 

$zip = new ZipArchive();
$filename = "./test112.zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

$zip->addFromString("testfilephp2.txt", "#2 This is a test string added as testfilephp2.txt.\n");
$zip->addFile("favicon.png");
echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();
?>