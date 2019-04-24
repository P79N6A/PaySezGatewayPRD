<html>
<body> 
<center> 
<div id="accu_screen" style="display: none;"></div> 
<div id="accu_keypad" style="display: none;"></div> 
<div id="accu_form" style="display: none;"></div> 
<div id="accu_loading" style="display: none;"></div> 
<div id="accu_issuer" style="display: none;"></div>
</center> 
<form> 
<!--<input type="button" value="Start PIN Pad" onclick="if(Acculynk.browserCheck()){ Acculynk.createForm('<?php echo $gussid; ?>','<?php echo $lfour; ?>', '<?php echo $moduluss;
?>','<?php
echo $exponentss; ?>'); Acculynk.PINPadLoad();  }" />-->
<input type="hidden" name="url" id="url" value="<?php echo $_POST['redirectionurl']; ?>">
</form> 
</body> 
</html> 
<script>
if(Acculynk.browserCheck())
{ 
Acculynk.createForm('<?php echo $gussid; ?>','<?php echo $lfour; ?>', '<?php echo $moduluss;
?>','<?php
echo $exponentss; ?>'); Acculynk.PINPadLoad();  
}
</script>
