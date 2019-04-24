<?php
session_start();
class MD5HtmlBuildSubmit {

function buildMD5Data($parameter) {   
    $Md5_key_sign = $this->buildmd5($parameter);
    $sign = $Md5_key_sign;
    $sign_type = "MD5";

    // Sort array

    ksort($parameter);

    if (array_key_exists('notify_url', $parameter)) {
        $notify_url=$this->url($parameter,$sign,$sign_type);
        return $notify_url;
    } else {
function build_http_query( $parameter ){    
    $query_array = array();

    foreach( $parameter as $key => $key_value ){

    $query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );

    }

    return implode('&', $query_array );

}

    $build=build_http_query($parameter);
    $AddToEnd='&sign='.$sign.'&sign_type='.$sign_type;
    $finalString = implode(array($build,$AddToEnd));
    return $finalString;
}
}
 function url($parameter,$sign,$sign_type) {
    $empty_notify_url=array("notify_url"=>"");
    $array1=array_replace($parameter,$empty_notify_url);
   
    function build_http_query( $array1 ){

    $query_array = array();

    foreach( $array1 as $key => $key_value ){

    $query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );

    }

    return implode('&', $query_array );

    }

    $build=build_http_query($array1);
    //$replace_notify= str_replace("&notify_url=","&notify_url=http://169.38.91.246/Spaysez/notify_alipay.php",$build);// live
    $replace_notify= str_replace("&notify_url=","&notify_url=http://169.38.91.246/testspaysez/notify_alipay.php",$build); //test
    $AddToEnd='&sign='.$sign.'&sign_type='.$sign_type;
    $finalString = implode(array($replace_notify,$AddToEnd));
    return $finalString;
}

function buildmd5($parameter) {

    ksort($parameter);
    reset($parameter);

    $html_build = implode('&', array_map(
     function ($v, $k) {
        if(is_array($v)){
             return $k.'[]='.implode('&'.$k.'[]='& $v);
         }else{
             return $k.'='.$v;
         }
     }, 
     $parameter, 
     array_keys($parameter)
    )); 
    //$sign = "og8qf0j66v2vlpjv0z4oyxtzoumowndp";// test
    $sign = $_SESSION['sign'];// test
    //$sign="6o3b4dubtf8olusby6hkwg8vk299cz2t"; //live
    $Md5 = $html_build.$sign;
    return md5($Md5);
}
function get_from_tag($string, $start, $end) {
        $string = ' ' .$string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $test="testttt";
        return substr($string, $ini, $len);
        //return $test;
    }
}
?>