
<html> 
<head> 
<script language="javascript" src="https://cert.mwsrec.npci.org.in/MWS/Scripts/MerchantScript_v1.0.js" type="text/javascript"></script> 

</head> 
<body> 

<center> 
<div id="accu_screen" style="display: none;"></div> 
<div id="accu_keypad" style="display: none;"></div> 
<div id="accu_form" style="display: none;"></div> 
<div id="accu_loading" style="display: none;"></div> 
<div id="accu_issuer" style="display: none;"></div>
</center> 
<form> 
<input type="button" value="Start PIN Pad" onclick="if(Acculynk.browserCheck()){ Acculynk.createForm('7b7b13b8-ccc8-22ea-96fe-92c51aa3163c','500000000000000000000001684014', 'A881545F85D683DC8A92B09825CADE99E9B0F3878AEB5F572DB017D8C4BE4F84906D3805F739787147FF99739E580E7D3FFC364ECB0227782F1B5417A5C745AE3F429A68E2256349F461D8817D4F492828A5473422AC31D65CDC710BB7222A161805216EA29EC45D2DCDCBE1EDBB01CBDAF09D5FE691900B5BDF2DDAB8B1D819','010001'); Acculynk.PINPadLoad();} " /> 
</form> 
</body> 
</html> 

<script script language="javascript" type="text/javascript" >
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
} 
</script>
<script language="javascript" type="text/javascript">
//reads the response back from PaySecure
function accu_FunctionResponse(strResponse){
alert(“this is the response that was received ” + strResponse);}
//checks browser compatibility
Acculynk.browserCheck();
//preps the PaySecure for opening
Acculynk.createForm("7b7b13b8-ccc8-22ea-96fe-92c51aa3163c","500000000000000000000001684014", "A881545F85D683DC8A92B09825CADE99E9B0F3878AEB5F572DB017D8C4BE4F84906D3805F739787147FF99739E580E7D3FFC364ECB0227782F1B5417A5C745AE3F429A68E2256349F461D8817D4F492828A5473422AC31D65CDC710BB7222A161805216EA29EC45D2DCDCBE1EDBB01CBDAF09D5FE691900B5BDF2DDAB8B1D819","010001");
//opens the IFrame so consumer can enter their enrollment information
Acculynk.PINPadLoad();
//closes the IFrame
Acculynk._modalHide();
</script>
