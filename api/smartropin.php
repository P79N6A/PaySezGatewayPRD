<html>
<head> 
<script language="javascript" src="https://mwsrec.npci.org.in/MWS/Scripts/MerchantScript_v1.0.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head> 
<body>
<?php
$partner_id=$_GET['partner_id'];
$merchant_password=$_GET['merchant_password'];
$transsid=$_GET['transsid'];
$auth_amount=$_GET['auth_amount'];
$CallerID=$_GET['CallerID'];
$currency_code=$_GET['currency_code'];
$Token=$_GET['Token'];
$Version=$_GET['Version'];
$UserID=$_GET['UserID'];
$lfour=$_GET['lfour'];
$gussid=$_GET['gussid'];
$moduluss=$_GET['moduluss'];
$exponentss=$_GET['exponentss'];
$card_no=$_GET['cardno'];
$mn=$_GET['mn'];
$amount=$_GET['amount'];
$env=$_GET['env'];
$url=urldecode($_GET['url']);

?>
<input type="hidden" value="<?php echo $url; ?>" name="url" id="url">
<input type="hidden" value="<?php echo $card_no; ?>" name="card_no" id="card_no">
<input type="hidden" value="<?php echo $mn; ?>" name="mn" id="mn">
<input type="hidden" value="<?php echo $amount; ?>" name="amount" id="amount">
<center>
<div id="accu_screen" style="display: none;"></div> 
<div id="accu_keypad" style="display: none;"></div> 
<div id="accu_form" style="display: none;"></div> 
<div id="accu_loading" style="display: none;"></div> 
<div id="accu_issuer" style="display: none;"></div>
</center> 
<form> 
<input type="button" value="Start PIN Pad" onclick="if(Acculynk.browserCheck()){ Acculynk.createForm('<?php echo $gussid;?>','<?php echo $lfour;?>', '<?php echo $moduluss;?>','<?php echo $exponentss;?>'); Acculynk.PINPadLoad();} " />
</form> 
</body> 
</html> 

<script language="javascript" type="text/javascript">
//checks browser compatibility
Acculynk.browserCheck();
//preps the PaySecure for opening
Acculynk.createForm('<?php echo $gussid;?>','<?php echo $lfour;?>', '<?php echo $moduluss;?>','<?php echo $exponentss;?>');
//opens the IFrame so consumer can enter their enrollment information
Acculynk.PINPadLoad();
//closes the IFrame
Acculynk._modalHide();
</script>

<script type="text/javascript" >
    function accu_FunctionResponse(strResponse){
        switch (strResponse) {
            case 'ACCU000': //Enrollment was completed successfully.
                Acculynk._modalHide();
                break;
            case 'ACCU200': //user pressed 'cancel' button
                Acculynk._modalHide();
                break;
            case 'ACCU400': //user was inactive
                Acculynk._modalHide();
                break;
            case 'ACCU600': //invalid data was posted to PaySecure
                Acculynk._modalHide();
                break;
            case 'ACCU800': //general catch all error
                Acculynk._modalHide();
                break;
            case 'ACCU999': //modal popup was opened successfully
//no action necessary, but open for Issuer to use
                break;
            default:
                break;
        }
        var url=document.getElementById("url").value;
        if(strResponse=="ACCU000")
        {
            $.ajax({
                type:'POST',
                url:'checkAuthorize.php',
                dataType: "json",
                data:{'partner_id':'<?php echo $partner_id; ?>', 'merchant_password':'<?php echo $merchant_password; ?>', 'tran_id':'<?php echo $transsid; ?>', 'auth_amount':'<?php echo $auth_amount; ?>', 'currency_code':'<?php echo $currency_code; ?>', 'Token':'<?php echo $Token; ?>',  'Version':'<?php echo $Version; ?>',  'CallerID':'<?php echo $CallerID; ?>',  'UserID':'<?php echo $UserID; ?>',  'Password':'<?php echo $Password; ?>', 'env':'<?php echo $env; ?>'},
                success:function(data){
                    var res	=data['res1'];
                    var res2=data['res2'];
                    var res4=data['res4'];
                    var res3=data['res3'];
                    var res1 = res.split(" ");
                    var url=document.getElementById("url").value;
                    var cn=document.getElementById("card_no").value;
                    var mn=document.getElementById("mn").value;
                    var am=document.getElementById("amount").value;
                    ///  alert(res1[1]);
                    // alert(res1[2]);
                    //alert(res1[3]);
                    //alert(res1[4]);
                    //alert(res1[5]);
                    // alert(res1[6]);
                    //alert(res1[7]);
                    if(res2=='tsfailure')
                    {
                        //window.location=url+"?errordesc=Timeout on Transaction status check&success=false&txn="+res3;
                        window.location.assign("fbtestbackground.php?url="+url+"&errordesc=Timeout on Transaction status check&success=false&txn="+res3+"&cn="+cn+"&mn="+mn+"&am="+am);
                        //window.location.assign(url+"?errordesc=Timeout on Transaction status check&success=false&txn="+res3);
                    }
                    else if(res2=='tssuccess')
                    {
                        //window.location=url+"?&success=true&txn="+res1[6]+"errordesc="+res1[3];
                        if(res1[3]=="I"){
                            window.location.assign("fbtestbackground.php?url="+url+"&success=true&txn="+res1[4]+"&errordesc=Transaction status success&cn="+cn+"&mn="+mn+"&am="+am);
                        }
                        else {
                            window.location.assign("fbtestbackground.php?url="+url+"&success=false&txn="+res1[4]+"&errordesc="+res1[3]+"&cn="+cn+"&mn="+mn+"&am="+am);
                        }

                    }
                    else if(res1[1]=='success')
                    {                    				 //window.location=url+"?success=true&txn="+data['res3']+"errordesc="+res1[3];
                        window.location.assign("fbtestbackground.php?url="+url+"&success=true&txn="+data['res3']+"&errordesc="+data['res4']+"&cn="+cn+"&mn="+mn+"&am="+am);
                    }
                    else
                    {
                        window.location.assign("fbtestbackground.php?url="+url+"&success=false&txn="+data['res3']+"&errordesc="+data['res4']+"&cn="+cn+"&mn="+mn+"&am="+am);
                    }
                    //alert(res1[1]);
                }
            });

        }
        else if(strResponse=="ACCU200")
        {
            //alert("workign");
            //alert(cn);
            //window.location.assign("fbtestbackground.php?success=false&trans=cancel&cn="+cn+"&mn="+mn+"&am="+am);
            window.location.assign("responsemerchant.php?url="+url+"&success=false&trans=cancel&errordesc=ACCU200 Error");

        }
        else if(strResponse=="ACCU400")
        {
            //window.location.assign("responsemerchant.php?url="+url+"&success=false&trans=inactive&cn="+cn+"&mn="+mn+"&am="+am);
            <?php $log = date("Y-m-d H:i:sa")."\n\n
-----------------------------------\n\n ACCU400- User was Inactive \n\n";
            $myfile = file_put_contents('merchantapiLOG.log', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
            ?>
            window.location.assign("responsemerchant.php?url="+url+"&success=false&trans=inactive&errordesc=ACCU400 Error");

        }
        else if(strResponse=="ACCU600")
        {
            //window.location.assign("responsemerchant.php?url="+url+"&success=false&cn="+cn+"&mn="+mn+"&am="+am);

            window.location.assign("responsemerchant.php?url="+url+"&success=false&errordesc=ACCU600 Error");

        }
        else if(strResponse=="ACCU800")
        {
            //window.location.assign("fbtestbackground.php?url="+url+"&success=false&cn="+cn+"&mn="+mn+"&am="+am);

            window.location.assign("responsemerchant.php?url="+url+"&success=false&errordesc=ACCU800 Error");

        }


    }
    $("#LinkButton1").click(function()
    {
        //alert("testtt");
        var url=document.getElementById("url").value;
        window.location.assign(url+"?success=false&txn=null&errordesc=pressed cancel button");
    });
    $("#LinkButton12").click(function()
    {
        //alert("testtt");
        var url=document.getElementById("url").value;
        window.location.assign(url+"?success=false&txn=null&errordesc=pressed cancel button");
    });

    $("#LinkButton13").click(function()
    {
        alert("testtt");
        var url=document.getElementById("url").value;
        window.location.assign(url+"?success=false&txn=null&errordesc=pressed cancel button");
    });
    /*
     window.onbeforeunload = function(event)
     {
     return confirm("Confirm Form Resubmission");
     };

     */
    $(document.body).on("keydown", this, function (event) {
        if (event.keyCode == 116) {
            if(confirm("Confirm Form Resubmission \n\nThe page that you're looking for used information that you entered. Returning to that page might cause any action that you took to be repeated. Do you want to continue?")){
                location.reload();
            }
            else {
                return false;
            }
        }
    });

    history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
    window.addEventListener('popstate', function(event)
    {
        var result = confirm("Are You Sure? This page is asking you to confirm that you want to leave - Transaction will be cancelled.");
        if (result) {
            //Logic to delete the item

            //window.location.assign("responsemerchant.php?success=false&trans=cancel&errordesc=");
            var url=document.getElementById("url").value;
            window.location.assign("rbredirect.php?url="+url);
        }
        //return "Leaving this page will reset the wizard";

    });

</script>

