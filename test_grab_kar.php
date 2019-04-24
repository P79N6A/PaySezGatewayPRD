<!DOCTYPE html>
<html>
<body>
    
<script src="components/core.js"></script>
<script src="components/enc-base64.js"></script>
<script src="components/sha256.js"></script>
<script src="components/hmac.js"></script>
<?php 
error_reporting(0);
?>

<script>

    // var timestampString = new Date().toGMTString();
    // var msgID = 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });
    // var partnerTxID = 'partner-xxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8); return v.toString(16); });

    var timestampString = '';
    var msgID = '';
    var partnerTxID = '';

    var final_url_req = 'https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/qrcode/create';
    var partnerID = '1f62bf7c-1d1f-43b5-88f0-d0c73ccab12c';
    var partnerSecret = 'UcEYLPlrSpqWeZeW';

    var grabID ='84dfaba5-7a1b-4e91-aa1c-f7ef93895266';
    var terminalID ='b010f1c9fb724de4962d6f23c5c96afd';
    var currency ='SGD';

    var obj = {
        amount: 100,
        msgID : msgID,
        grabID : grabID,
        terminalID : terminalID,
        currency : currency,
        partnerTxID : partnerTxID
    };

    var httpMethod = 'POST';
    var requestURL = final_url_req;
    var contentType = 'application/json';
    var requestBody = JSON.stringify(obj);
    var timestamp = timestampString;

    console.log(generateHMACSignature(partnerID,partnerSecret,httpMethod,requestURL,contentType,requestBody,timestamp));

    // var hmac = generateHMACSignature(partnerID,partnerSecret,httpMethod,requestURL,contentType,requestBody,timestamp);
    var hmac = '';

    //alert(req_obj); 
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
        //alert('hi');
        var requestPath = getPath(requestURL);
        //alert(requestPath);
        var queryString = getQueryString(requestURL);
        //alert(queryString);
        if (httpMethod == 'GET' || !requestBody) {
            var hashedPayload = '';
        } else {
            // console.log("body ", requestBody)
            hashedPayload = CryptoJS.enc.Base64.stringify(CryptoJS.SHA256(requestBody));
        }
        //alert(requestPath+queryString);

        var requestData = [[httpMethod, contentType, timestamp, requestPath+queryString, hashedPayload].join('\n'), '\n'].join('');
        //alert(requestData);
        var hmacDigest = CryptoJS.enc.Base64.stringify(CryptoJS.HmacSHA256(requestData, partnerSecret));
        var authHeader = partnerID + ':' + hmacDigest;
        //alert(authHeader);
        return authHeader;
    }

    var settings = {
      "async": true,
      "crossDomain": true,
      "url": "https://partner-api.stg-myteksi.com/grabpay/partner/v1/terminal/qrcode/create",
      "method": "POST",
      "headers": {
        "Authorization": hmac,
        "Date": timestamp,
        "Content-Type": "application/json",
        "cache-control": "no-cache"
      },
      "processData": false,
      "data": "{\n    \"amount\": 100,\n    \"msgID\": \""+msgID+"\",\n    \"grabID\": \""+grabID+"\",\n    \"terminalID\": \""+terminalID+"\",\n    \"currency\": \""+currency+"\",\n    \"partnerTxID\": \""+partnerTxID+"\"\n}"
    }

    console.log(settings);

    $.ajax(settings).done(function (response) {
        console.log(response);
    });

</script>

</body>
</html> 
