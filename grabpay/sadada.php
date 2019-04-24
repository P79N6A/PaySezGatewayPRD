<?php 
$url ='https://partner-api.stg-myteksi.com';
$pay_order_url_string = '/grabpay/partner/v1/terminal/qrcode/create?';
$final_url_req =$url.$pay_order_url_string;

$partner_id = '1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
$partner_secret = 'UcEYLPlrSpqWeZeW';
$method_type = 'POST';
$content_type = 'application/json';
$amount ='100';
$msgID ='bf9a9ef6f4cd47479300f0c2ec40661c';
$grabID ='84dfaba5-7a1b-4e91-aa1c-f7ef93895266';//'520499d9-be82-422c-a6da-e4f5eeb6019e';
$terminal_id ='b010f1c9fb724de4962d6f23c5c96afd';//'54f50424894fe164971a3020f';
$currency ='SGD';
$gmt_date = 'Tue, 05 Mar 2019 15:08:07 GMT';//gmdate('D, d M Y H:i:s T');
$partnerTxID ='partner-6e6e4a1aae0f61d2bd92c3b2';
?>
<script src="components/core.js"></script>
<script src="components/enc-base64.js"></script>
<script src="components/sha256.js"></script>
<script src="components/hmac.js"></script>
<script>
    var obj = {
    amount: <?php echo $amount ?>,
    msgID : "<?php echo $msgID ?>",
    grabID : "<?php echo $grabID ?>",
    terminalID : "<?php echo $terminal_id ?>",
    currency : "<?php echo $currency ?>",
    partnerTxID : "<?php echo $partnerTxID ?>"
    };
    console.log(obj);


    var partnerID = "<?php echo $partner_id ?>";
    var partnerSecret = "<?php echo $partner_secret ?>";
    var httpMethod = "<?php echo $method_type ?>";
    var requestURL = "<?php echo $final_url_req ?>";
    //alert(requestURL);
    var contentType = "<?php echo $content_type ?>";
    // var reqBody = JSON.parse('<?php //echo json_encode($request_parameters)?>');
    // var requestBody = JSON.stringify(reqBody);
    //alert(requestBody);
    var requestBody = JSON.stringify(obj);

    console.log(requestBody);
    var timestamp = "<?php echo $gmt_date ?>";

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

function generateHMACSignature(partnerID, partnerSecret, httpMethod, requestURL, contentType, requestBody, timestamp) {
    var requestPath = getPath(requestURL);
    var queryString = getQueryString(requestURL);
    if (httpMethod == 'GET' || !requestBody) {
        var hashedPayload = '';
    } else {
        console.log("body ", requestBody)
        hashedPayload = CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody));
    }
    
    var requestData = [[httpMethod, contentType, timestamp, requestPath+queryString, hashedPayload].join('\n'), '\n'].join('');
    var hmacDigest = CryptoJS.enc.Base64.stringify(CryptoJS.HmacSHA256(requestData, partnerSecret));
    var authHeader = partnerID + ':' + hmacDigest;
    return authHeader;
}

// var partnerID = get('partner_id');
// var partnerSecret = get('partner_secret');
partnerID ='1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
partnerSecret = 'UcEYLPlrSpqWeZeW';

console.log(partnerID);

// generate random variables for the request
var timestampString = new Date().toGMTString();
var msgID = 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });
var partnerTxID = 'partner-xxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });

// set('timestamp', timestampString);
// set('msg_id', msgID);
// set('partner_tx_id', partnerTxID);


// var reqBody = requestBody
//     .replace(/\{\{msg_id\}\}/g, msgID)
// reqBody = reqBody.replace(/\{\{partner_tx_id\}\}/g, partnerTxID)

// set('hmac_signature', generateHMACSignature(partnerID, partnerSecret, request['method'], request['url'], 'application/json', reqBody, timestampString));
console.log('hmac_signature', generateHMACSignature(partnerID, partnerSecret, httpMethod, requestURL, 'application/json', requestBody, timestamp));
</script>

