<?php 
if(isset($_POST['device']) && $_POST['device'] == 'pos'){
    $device = $_POST['device'];
    $terminal_no = $_POST['terminal_no'];
    $amount = $_POST['amount'];
    $currency = $_POST['currency'];
    $terminal_time = $_POST['ter_time_stamp'];
    $out_trade_no = $_POST['out_trade_no'];
    $ttype = $_POST['ttype'];
    echo $device.'<br>';
    echo $terminal_no.'<br>';
    echo $amount.'<br>';
    echo $currency.'<br>';
    echo $terminal_time.'<br>';
    echo $out_trade_no.'<br>';
    echo $ttype;
}else{
echo 'not authorised to proceed';
exit;
}




?>