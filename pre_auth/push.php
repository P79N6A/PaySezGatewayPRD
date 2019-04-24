
<?php

// function sendFCM($mess,$id) {
// $url = 'https://fcm.googleapis.com/fcm/send';
// $fields = array (
//         'to' => $id,
//         'notification' => array (
//                 "body" => $mess,
//                 "title" => "Title",
//                 "icon" => "myicon"
//         )
// );
// $fields = json_encode ( $fields );
// $headers = array (
//         'Authorization: key=' . "AIzaSyA9vpL9OuX6moOYw-4n3YTSXpoSGQVGnyM",
//         'Content-Type: application/json'
// );

// $ch = curl_init ();
// curl_setopt ( $ch, CURLOPT_URL, $url );
// curl_setopt ( $ch, CURLOPT_POST, true );
// curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
// curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
// curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

// $result = curl_exec ( $ch );
// curl_close ( $ch );
// }




// API access key from Google API's Console
define( 'SERVER_API_KEY', 'AIzaSyAX04vww54cIFvyJ2q8vXvj5VYMTHCLM3c');
$tokens =['dI0-5wQr3Uo:APA91bEtdpWp6tpdcdh86LKwlny3B-HoMpv3GFJnv6EtvhwmjfHvbf5iY4SUkCh7nEJ15VnANBI5njA3fHsLcHNsgAvBRSugTtvcr6NoEnh2dDLA5g42G5VuEcQJ0O2YUHgSih6LzrnS'];
// prep the bundle
// $msg = [
// 	'message' 	=> 'EBENEZER',
// 	'title'		=> 'This is a title. title',
// 	'subtitle'	=> 'This is a subtitle. subtitle',
// 	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
// 	'vibrate'	=> 1,
// 	'sound'		=> 1

// ];

$response=array(
	'msgID' => 'EBENEZER' , 
	'qrcode' =>'rq'
);
$characters = json_decode($response,true);

$msg =array(
    $msgID_res      => $characters['msgID'],
    $qrcode_res     => $characters['qrcode'],
   // $txID_res       => $characters['txID'],
   // $devmsg         => $characters['devMessage'],
   // $arg            => $characters['arg']
);

//$msg=json_encode($msgs); 

$payloads =array(
	'registration_ids' 	=> $tokens,
	'data'			=> $msg
);
 
$headers =array(
	'Authorization: key=' . SERVER_API_KEY,
	'Content-Type: application/json'
);

$payload=json_encode($payloads); 
 echo $payload;
 echo "<br><br>";


$curl= curl_init();

curl_setopt_array($curl,array(
CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
CURLOPT_RETURNTRANSFER=> true,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => json_encode($payload),
CURLOPT_HTTPHEADER => $headers
));
$response=curl_exec($curl);
$err=curl_error($curl);
curl_close($curl); 

if($err){
	echo "cURL Error #:". $err;
}
else{
	echo $response;
}


// $ch = curl_init();
// curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/fcm/send' );
// curl_setopt( $ch,CURLOPT_POST, true ); 
// curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
// curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
// curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
// curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
// $result = curl_exec($ch );
// curl_close( $ch );
// echo $result;

?>