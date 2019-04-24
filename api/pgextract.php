<?php
/*$path    = glob("filecombine/*");
$files = array_diff(scandir($path), array('.', '..'));*/
/*$files = array_filter(glob("filecombine/*"), 'is_file');
print_r($files);*/
function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
			$g= file_get_contents($path);
			file_put_contents('/var/www/html/api/output2/'.$value.'.pgp',$g);
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

	print_r($results);
    //return $results;
}

getDirContents('/var/www/html/api/output1/');

?>