<!DOCTYPE html>
<html>
<body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="components/core.js"></script>
<script src="components/sha256.js"></script>
<script src="components/enc-base64.js"></script>
<script src="components/hmac.js"></script>
<?php 
error_reporting(0);

$obj = "{\n\t\"amount\":100,\n\t\"msgID\":\"21591c260e674d229d5d4c5b535b95b7\",\n\t\"grabID\":\"84dfaba5-7a1b-4e91-aa1c-f7ef93895266\",\n\t\"terminalID\":\"b010f1c9fb724de4962d6f23c5c96afd\",\n\t\"currency\":\"SGD\",\n\t\"partnerTxID\":\"partner-09dd40dc8d6b08f466522082\"\n}";

// echo hash('sha256', $obj);

echo $obj;
echo "<br>";

$timestampString = 'Thu, 07 Mar 2019 08:18:58 GMT';

$final_url_req = 'https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/qrcode/create';
$partnerID = '1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
$partnerSecret = 'UcEYLPlrSpqWeZeW';

$httpMethod  = 'POST';
$requestURL  = $final_url_req;
$contentType = 'application/json';
$timestamp   = $timestampString;

$requestPath = '/grabpay/partner/v1/terminal/qrcode/create';
$queryString = '';

$hashedPayload = base64_encode(hash("SHA256", $obj,true));

echo $hashedPayload;
echo "<br>";

$requestData = $httpMethod."\n".$contentType."\n".$timestamp."\n".$requestPath.$queryString."\n".$hashedPayload."\n";
// $string_to_sign =$method_type."\n".$content_type."\n".$gmt_date."\n".$pay_order_url_string."\n".$content_digest_hash."\n";

echo $requestData;
echo "<br>";

$base64_encoded_hmac_signature = base64_encode(hash_hmac("SHA256", $requestData, $partnerSecret, true));

echo $base64_encoded_hmac_signature;

?>

<script>

    function getPath(url) {
        var pathRegex = /.+?\:\/\/.+?(\/.+?)(?:#|\?|$)/;
        var result = url.match(pathRegex);
        if(!result){
            pathRegex = /\/.*/;
            result = url.match(pathRegex);
            return result && result.length == 1 ? result[0] : '';
        }
        return result && result.length > 1 ? result[1] : '';
    }

    function getQueryString(url) {
        var arrSplit = url.split('?');
        return arrSplit.length > 1 ? url.substring(url.indexOf('?')) : '';
    }

    // var obj = {
    //     amount:100,
    //     msgID :"79160ab4b1d848f59783c9939daf988c",
    //     grabID :"84dfaba5-7a1b-4e91-aa1c-f7ef93895266",
    //     terminalID:"b010f1c9fb724de4962d6f23c5c96afd",
    //     currency:"SGD",
    //     partnerTxID:"partner-61d74e359f83be034e3189cd"
    // };


    // { "amount":100, "msgID":"21591c260e674d229d5d4c5b535b95b7", "grabID":"84dfaba5-7a1b-4e91-aa1c-f7ef93895266", "terminalID":"b010f1c9fb724de4962d6f23c5c96afd", "currency":"SGD", "partnerTxID":"partner-09dd40dc8d6b08f466522082" }

    var timestampString = 'Thu, 07 Mar 2019 08:18:58 GMT';
    // var msgID = '';
    // var partnerTxID = '';

    var final_url_req = 'https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/qrcode/create';
    var partnerID = '1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
    var partnerSecret = 'UcEYLPlrSpqWeZeW';

    var httpMethod  = 'POST';
    var requestURL  = final_url_req;
    var contentType = 'application/json';
    // var requestBody = obj; // JSON.stringify(obj);
    var timestamp   = timestampString;


    var obj = "{\n\t\"amount\":100,\n\t\"msgID\":\"21591c260e674d229d5d4c5b535b95b7\",\n\t\"grabID\":\"84dfaba5-7a1b-4e91-aa1c-f7ef93895266\",\n\t\"terminalID\":\"b010f1c9fb724de4962d6f23c5c96afd\",\n\t\"currency\":\"SGD\",\n\t\"partnerTxID\":\"partner-09dd40dc8d6b08f466522082\"\n}";

    console.log(obj);

    var requestBody = obj; //  CryptoJS.SHA256(JSON.stringify(obj));

    console.log(requestBody);

    // var hashedPayload = CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody)); // CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody));
    // console.log("hashedPayload ", hashedPayload);

    var requestPath = getPath(requestURL);
    //alert(requestPath);
    var queryString = getQueryString(requestURL);
    //alert(queryString);
    if (httpMethod == 'GET' || !requestBody) {
        var hashedPayload = '';
    } else {
        console.log("body ", requestBody)
        hashedPayload = CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody));
        console.log("hashedPayload ", hashedPayload)
    }
    //alert(requestPath+queryString);

    var requestData = [[httpMethod, contentType, timestamp, requestPath+queryString, hashedPayload].join('\n'), '\n'].join('');
    console.log(requestData);

    var hmacDigest = CryptoJS.enc.Base64.stringify(CryptoJS.HmacSHA256(requestData, partnerSecret));
    console.log(hmacDigest);

    var authHeader = partnerID + ':' + hmacDigest;
    console.log(authHeader);

    // // var timestampString = new Date().toGMTString();
    // // var msgID = 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });
    // // var partnerTxID = 'partner-xxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });

    // var timestampString = '';
    // var msgID = '';
    // var partnerTxID = '';

    // var final_url_req = 'https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/qrcode/create';
    // var partnerID = '1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
    // var partnerSecret = 'UcEYLPlrSpqWeZeW';

    // var grabID ='84dfaba5-7a1b-4e91-aa1c-f7ef93895266';
    // var terminalID ='b010f1c9fb724de4962d6f23c5c96afd';
    // var currency ='SGD';

    // // var obj = {
    // //     amount: 100,
    // //     msgID : msgID,
    // //     grabID : grabID,
    // //     terminalID : terminalID,
    // //     currency : currency,
    // //     partnerTxID : partnerTxID
    // // };


    // var obj = { "amount":100, "msgID":"79160ab4b1d848f59783c9939daf988c", "grabID":"84dfaba5-7a1b-4e91-aa1c-f7ef93895266", "terminalID":"b010f1c9fb724de4962d6f23c5c96afd", "currency":"SGD", "partnerTxID":"partner-61d74e359f83be034e3189cd" }

    // var httpMethod = 'POST';
    // var requestURL = final_url_req;
    // var contentType = 'application/json';
    // var requestBody = obj; // JSON.stringify(obj);
    // var timestamp = timestampString;


    // var hashedPayload = CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody));
    // console.log("hashedPayload ", hashedPayload);



    // console.log(generateHMACSignature(partnerID,partnerSecret,httpMethod,requestURL,contentType,requestBody,timestamp));

    // // var hmac = generateHMACSignature(partnerID,partnerSecret,httpMethod,requestURL,contentType,requestBody,timestamp);
    // var hmac = '';

    // //alert(req_obj); 
    // function getPath(url) {
    //     var pathRegex = /.+?\:\/\/.+?(\/.+?)(?:#|\?|$)/;
    //     var result = url.match(pathRegex);
    //     if(!result){
    //         pathRegex = /\/.*/;
    //         result = url.match(pathRegex);
    //         return result && result.length == 1 ? result[0] : '';
    //     }
    //     return result && result.length > 1 ? result[1] : '';
    // }

    // function getQueryString(url) {
    //     var arrSplit = url.split('?');
    //     return arrSplit.length > 1 ? url.substring(url.indexOf('?')) : '';
    // }

    // function generateHMACSignature(partnerID, partnerSecret, httpMethod, requestURL, contentType, requestBody, timestamp) {
    //     //alert('hi');
    //     var requestPath = getPath(requestURL);
    //     //alert(requestPath);
    //     var queryString = getQueryString(requestURL);
    //     //alert(queryString);
    //     if (httpMethod == 'GET' || !requestBody) {
    //         var hashedPayload = '';
    //     } else {
    //         console.log("body ", requestBody)
    //         hashedPayload = CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody));
    //         console.log("hashedPayload ", hashedPayload)
    //     }
    //     //alert(requestPath+queryString);

    //     var requestData = [[httpMethod, contentType, timestamp, requestPath+queryString, hashedPayload].join('\n'), '\n'].join('');
    //     //alert(requestData);
    //     var hmacDigest = CryptoJS.enc.Base64.stringify(CryptoJS.HmacSHA256(requestData, partnerSecret));
    //     var authHeader = partnerID + ':' + hmacDigest;
    //     //alert(authHeader);
    //     return authHeader;
    // }

    // var settings = {
    //   "async": true,
    //   "crossDomain": true,
    //   "url": "https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/qrcode/create",
    //   "method": "POST",
    //   "headers": {
    //     "Authorization": hmac,
    //     "Date": timestamp,
    //     "Content-Type": "application/json",
    //     "cache-control": "no-cache"
    //   },
    //   "processData": false,
    //   "data": "{\n    \"amount\": 100,\n    \"msgID\": \""+msgID+"\",\n    \"grabID\": \""+grabID+"\",\n    \"terminalID\": \""+terminalID+"\",\n    \"currency\": \""+currency+"\",\n    \"partnerTxID\": \""+partnerTxID+"\"\n}"
    // }

    // console.log(settings);

    // $.ajax(settings).done(function (response) {
    //     console.log(response);
    // });

</script>

</body>
</html> 
