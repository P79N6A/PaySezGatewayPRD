<?php 
$xml=$_POST['request_parameters'];
print_r($xml);exit;
$result = '<?xml version="1.0" encoding="utf-8"?>
<response>
<result_code>SUCCESS</result_code>
<sign>wewrweionijb212b42hj3bhjfh</sign>
<sign_type>MD5</sign_type>
</response>';
return $result;
                      


?>