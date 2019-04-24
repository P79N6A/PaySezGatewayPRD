<?php
function randomGen($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

$random_num_arr = randomGen(0,20,1); //generates 20 unique random numbers
$random_num     = sprintf("%02d", $random_num_arr[0]);
// echo randomGen(0,20,20);

if(isset($_POST)) {
	echo "<pre>";
	print_r($_POST);
}
echo "<br>";
echo $_POST['out_trade_no_anthr'].date('YmdHis').$random_num;
echo "<br>";
echo $random_num;
?>