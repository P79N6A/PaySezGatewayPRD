<?php

    
    if($_POST && !isset($_POST['cardno'])) {
        require_once('api/encrypt.php');
        $secureData_enc = dec_enc('encrypt', $_POST['amount'].$_POST['cardnum'].$_POST['card_cvv'].$_POST['expiry_mm'].$_POST['expiry_yy']);
        echo $secureData_enc;
        die();
    }


	$CCNumber=$_GET['cardno'];
	$CCNumber=$_POST['cardno'];
    //	$CCNumber=document.getElementById.value("cc_number");
    $creditcardTypes = array(
        array('Name'=>'American Express','cardLength'=>array(15),'cardPrefix'=>array('34', '37'))
    ,array('Name'=>'Maestro','cardLength'=>array(12, 13, 14, 15, 16, 17, 18, 19),'cardPrefix'=>array('5018', '5020', '5038', '6304', '6759', '6761', '6763'))
    ,array('Name'=>'Mastercard','cardLength'=>array(16),'cardPrefix'=>array('51', '52', '53', '54', '55'))
    ,array('Name'=>'Visa','cardLength'=>array(13,16),'cardPrefix'=>array('4'))
    ,array('Name'=>'JCB','cardLength'=>array(16),'cardPrefix'=>array('3528', '3529', '353', '354', '355', '356', '357', '358'))
    ,array('Name'=>'Discover','cardLength'=>array(16),'cardPrefix'=>array('6011', '622126', '622127', '622128', '622129', '62213',
            '62214', '62215', '62216', '62217', '62218', '62219',
            '6222', '6223', '6224', '6225', '6226', '6227', '6228',
            '62290', '62291', '622920', '622921', '622922', '622923',
            '622924', '622925', '644', '645', '646', '647', '648',
            '649', '65'))
    ,array('Name'=>'Solo','cardLength'=>array(16, 18, 19),'cardPrefix'=>array('6334', '6767'))
    ,array('Name'=>'Unionpay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('622126', '622127', '622128', '622129', '62213', '62214',
            '62215', '62216', '62217', '62218', '62219', '6222', '6223',
            '6224', '6225', '6226', '6227', '6228', '62290', '62291',
            '622920', '622921', '622922', '622923', '622924', '622925'))
    ,array('Name'=>'Diners Club','cardLength'=>array(14),'cardPrefix'=>array('300', '301', '302', '303', '304', '305', '36'))
    ,array('Name'=>'Diners Club US','cardLength'=>array(16),'cardPrefix'=>array('54', '55'))
    ,array('Name'=>'Diners Club Carte Blanche','cardLength'=>array(14),'cardPrefix'=>array('300','305'))
    ,array('Name'=>'Laser','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6304', '6706', '6771', '6709'))
    ,array('Name'=>'Rupay','cardLength'=>array(16, 17, 18, 19),'cardPrefix'=>array('6073', '6079', '6078', '6069', '6072', '6074', '6522', '6521', '6070', '6071', '6522', '6528', '6581'))
    );
    $CCNumber= trim($CCNumber);
    $type='Unknown';
    foreach ($creditcardTypes as $card)
	{
        if (! in_array(strlen($CCNumber),$card['cardLength'])) {
            continue;
        }
        $prefixes = '/^('.implode('|',$card['cardPrefix']).')/';
        if(preg_match($prefixes,$CCNumber) == 1 ){
            $type= $card['Name'];
			break;
        }
    }
	
    echo trim($type);


?>