<html>
<head>
<script type='text/javascript' src='//code.jquery.com/jquery-2.1.0.js'></script>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$("#select1").change(function () {
    if ($(this).data('options') == undefined) {
        /*Taking an array of all options-2 and kind of embedding it on the select1*/
        $(this).data('options', $('#select2 option').clone());
    }
    var id = $(this).val();
    var options = $(this).data('options').filter('[value=' + id + ']');
    $('#select2').html(options);
});
});//]]>  

</script>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","bob2.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>

</head>
<body>

  
</body>

<form>
<input type='text' onchange="showUser(this.value)" /> 
</form>
<br>

<?php include 'bob2.php'; ?>
<div id="txtHint">  </div>
</body>
</html>