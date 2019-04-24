<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 26-08-2017
 * Time: 02:52 PM
 */
error_reporting(0);
session_start();
//echo $_SESSION['loaded'];
if ($_SESSION['mangaaaa']=="yes")
{
    // insert query here
	$_SESSION['mangaaaa'] = "";
	unset($_SESSION["mangaaaa"]);
	session_destroy();
	//header('Refresh:1; url= responsemerchant.php?success=false&trans=cancel&txn=null&errordesc=');
}
?>
<style>
    .fake-input { position: relative; width:100%; padding-left: 16px; padding-right: 16px; }
    .fake-input input { border:none: background:#fff; display:block; width: 100%; box-sizing: border-box }
    .fake-input img { position: absolute; top: 2px; right: 17px }
</style>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fb Test page</title><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<br>

<form action="http://test.shoppercrux.com/index.php?route=payment/xpayment/confirm" id="frm1" method="POST">
<div class="container">
    <div class='row'>
	
        <img src="img/cards/citylogo.png" onerror="this.src='../img/cards/citylogo.png'" style="width: 300px;height: 150px;" ><br>
		<!--<img src="img/cards/cubllogo.png" onerror="this.src='../img/cards/cubllogo.png'" style="height: 40px;">-->
<!--        <h1 class="text-center">Transaction</h1>-->
<!--        <hr class="featurette-divider"></hr>-->
	
	</div>
    <h4 class="text-center">Billing Information</h4>
    <hr class="featurette-divider"></hr>
	<div class='row'>
		<div class='col-md-3'></div>
		<div class='col-md-6 text-center'>
		<?php if($_GET['success']!="true"){ ?>
			<div class="alert alert-success alert-dismissable">
					<h4><b>Transaction was <?php if($_GET['trans']=="cancel"){ echo "Cancelled"; } else if($_GET['trans']=="inactive"){ echo "Timed Out"; } else{ echo "Declined "; } ?><br><?php if($_GET['errordesc']!=""){ echo $_GET['errordesc']; } //$errormessage;?></b></h4> &nbsp; &nbsp; &nbsp;
                   <button type="hidden" value="submit">Ok</button>
				</div>
		<?php } ?>
		</div>
		<input type="hidden" name="success" value="<?php if($_GET['success']==""){ echo "false"; } else { echo $_GET['success']; }?>"/>
		<input type="hidden" name="txn" value="<?php if($_GET['success']=="false"){ echo "0"; } else { echo $_GET['txn']; }?>"/>
		<input type="hidden" name="errordesc" value="<?php echo $_GET['errordesc']; ?>"/>
		<div class='col-md-3'></div>
	</div>
	<div class='row'>
		<div class='col-md-5'></div>
		<div class='col-md-4'>
			
		</div>
		<div class='col-md-4'></div>
	</div>
    <div class='row'>
        <div class='col-md-3'></div>
        <div class='col-md-5'>
            <div class='form-row'>
                <div class=' form-group required'>
                    <label class='control-label'>&nbsp; &nbsp; Card Number<span class="text-danger">*</span></label>
                    <div class="fake-input">
                        <input class='form-control'  type='text' onload="checkcard();" onclick="checkcard();" onkeyup="checkcard();" id="card_no" name="cc_number" value='<?php echo $_GET['cn']; ?>' disabled required>
						<span id="errmsg" style="color:red;"></span>
                        <img src="img/cards/amex.png"  onerror="this.src='../img/cards/amex.png'"   id="amex" style="display:none;" width=50 />
                        <img src="img/cards/visa.png"  onerror="this.src='../img/cards/visa.png'"  id="visa" style="display:none;" width=50 />
                        <img src="img/cards/mastercard.png" onerror="this.src='../img/cards/maestro.png'" id="mastercard" style="display:none;" width=50 />
                        <img src="img/cards/maestro.png"  onerror="this.src='../img/cards/maestro.png'"  id="maestro" style="display:none;" width=50 />
                        <img src="img/cards/jcb.png"  onerror="this.src='../img/cards/jcb.png'"  id="jcb" style="display:none;" width=50 />
                        <img src="img/cards/discover.png"  onerror="this.src='../img/cards/discover.png'" id="discover" style="display:none;" width=50 />
                        <img src="img/cards/solo.png"  onerror="this.src='../img/cards/solo.png'"  id="solo" style="display:none;" width=50 />
                        <img src="img/cards/diners.png"  onerror="this.src='../img/cards/diners.png'"  id="diners" style="display:none;" width=50 />
                        <img src="img/cards/laser.png"  onerror="this.src='../img/cards/laser.png'"  id="laser" style="display:none;" width=50 />
                        <img src="img/cards/paypa.png"  onerror="this.src='../img/cards/paypa.png'"  id="paypa" style="display:none;" width=50 />
                        <img src="img/cards/rupay.png"  onerror="this.src='../img/cards/rupay.png'"  id="rupay" style="display:none;" width=50 />
                    </div>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-sm-4 form-group required'>
                    <label class='control-label'>Exp. Year <span class="text-danger">*</span></label>
                    <select  disabled class='form-control' name="cc_exp_yy" id="cc_exp_yy" required>
                        <option value="">Select Year</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
                <div class='col-sm-5 form-group required'>
                    <label class='control-label'>Exp. Month <span class="text-danger">*</span></label>
                    <select  disabled class='form-control' name="cc_exp_mm" id="cc_exp_mm" required>
                        <option value="">Select Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
				<div class='col-sm-3 form-group required'>
                    <label class='control-label'>CVD2 <span class="text-danger">*</span></label>
                    <input type='password'  disabled class='form-control' name='cavv' value="***" maxlength='3' id='cvd2' required>
					<span id="errmsg1" style="color:red;"></span>

                </div>
            </div>
        </div>
       <div class='col-md-4'>
            Merchant Name: <?php 
			
							echo $_GET['mn'];
							?> <br><br>
							
            Payment Amount: <b><?php echo $_GET["am"];?></b>
			<input type="hidden" name="merchant_name" value="<?php echo $datacon['merchant_name'];?>">
        </div>
		
    </div>
    <hr class="featurette-divider"></hr>
    <div class='row'>
        <div class='col-md-3'></div>
        <div class='col-md-5'>
            <div class='form-row'>
                <div class='col-xs-12 form-group'>
                <button class="btn btn-lg btn-primary btn-block" type="" disabled id="makepayment">Make Payment</button>
					<!--<button class="btn btn-lg btn-primary btn-block" type="button" data-toggle="modal" data-target="#myModal" onclick="loadDoc();" data-backdrop="static" data-keyboard="false" >Make Payment</button>-->
                </div>
            </div>
        </div>
        <div class='col-md-4'></div>
    </div>
	    <div class='row'>
        <div class='col-md-4'></div>
        <div class='col-md-4'>
            
        </div>
        <div class='col-md-4'>
			
		</div>
    </div>
    <div class='row'>

          
        </div>
        <div class='col-md-2'></div>
    </div>
<!--    <hr class="featurette-divider"></hr>-->

    <br /><br />

</div>
</form>
</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="top: 250px;">
        <div class="modal-header">
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
		<div id="loadtestpost">
		
		</div>
        
      </div>
      
    </div>
  </div>

</div>
</form>
</body>
</html>
<script>
$(document).ready(function()
{
	<?php if($_GET['success']=="true"){ ?>
		$("#frm1").submit();
	<?php } ?>
});
</script>

<script>
function loadDoc()
{	
  var card_no				=	$('#card_no').val();
  var cc_exp_yy				=	$('#cc_exp_yy').val();
  var cc_exp_mm				=	$('#cc_exp_mm').val();
  var cvd2					=	$('#cvd2').val();
  var first_name			=	$('#first_name').val();
  var last_name				=	$('#last_name').val();
  var address2				=	$('#address2').val();
  var city					=	$('#city').val();
  var us_state				=	$('#us_state').val();
  var postal_code			=	$('#postal_code').val();
  var country				=	$('#country').val();
  var email					=	$('#email').val();
  var phone					=	$('#phone').val();
  var shipping_first_name	=	$('#shipping_first_name').val();
  var shipping_last_name	=	$('#shipping_last_name').val();
  var shipping_address1		=	$('#shipping_address1').val();
  var shipping_address2		=	$('#shipping_address2').val();
  var shipping_city			=	$('#shipping_city').val();
  var shipping_us_state		=	$('shipping_us_state').val();
  var shipping_postal_code		=	$('#shipping_postal_code').val();
  var shipping_country		=	$('#shipping_country').val();
  var shipping_email		=	$('#shipping_email').val();
  var ponumber				=	$('#ponumber').val();
  var env					=	$('#env').val();
  var TransactionType		=	$('#TransactionType').val();
  var merchant_id			=	$('#merchant_id').val();
  var processor_id			=	$('#processor_id').val();
  var platform_id			=	$('#platform_id').val();
  var gateway_id			=	$('#gateway_id').val();
  var supersecret			=	$('#supersecret').val();
  var currency				=	$('#currency').val();
  var tax					=	$('#tax').val();
  var amount				=	$('#amount').val();
  var BuyerIP				=	$('#BuyerIP').val();
  var BuyerID				=	$('#BuyerID').val();
  var acquireType			=	$('#acquireType').val();
  var redirectionurl			=	$('#redirectionurl').val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() 
  {
    if (this.readyState == 4 && this.status == 200) 
	{
      document.getElementById("loadtestpost").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "api/smartro.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("card_no="+card_no+"&cc_exp_yy="+cc_exp_yy+"&cc_exp_mm="+cc_exp_mm+"&cvd2="+cvd2+"&first_name="+first_name+"&last_name="+last_name+"&address2="+address2+"&city="+city+"&us_state="+us_state+"&postal_code="+postal_code+"&country="+country+"&email="+email+"&phone="+phone+"&shipping_first_name="+shipping_first_name+"&shipping_last_name="+shipping_last_name+"&shipping_address1="+shipping_address1+"&shipping_address2="+shipping_address2+"&shipping_city="+shipping_city+"&shipping_us_state="+shipping_us_state+"&shipping_postal_code="+shipping_postal_code+"&shipping_country="+shipping_country+"&shipping_email="+shipping_email+"&ponumber="+ponumber+"&env="+env+"&env="+env+"&TransactionType="+TransactionType+"&merchant_id="+merchant_id+"&processor_id="+processor_id+"&platform_id="+platform_id+"&gateway_id="+gateway_id+"&supersecret="+supersecret+"&currency="+currency+"&tax="+tax+"&amount="+amount+"&BuyerIP="+BuyerIP+"&BuyerID="+BuyerID+"&acquireType="+acquireType+"&redirectionurl="+redirectionurl);
}
function showcancel()
{
	 $('#card_no').val('');
	// $('#card_no').val('');
	 $("#makepayment").attr("disabled","disabled");
	 $('#canceldiv').show();
     //$('#diners').hide();
	
}
function checkcard()
{

        var st=$('#card_no').val();
        $.ajax({
            type: 'POST',
            url: "<?php echo 'cardtype.php?cardno=';?>"+st,
            data: {
                'cardno': st
            },
            success: function (data) {
                //var str = ;
                //alert(data);
                var aaa= data.trim();
                if (aaa == "American Express")
                {
                    $('#amex').show();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').hide();

                }
                else if(aaa=="Maestro")
                {
                    $('#amex').hide();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').show();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').hide();
                }
                else if(aaa=="Mastercard")
                {
                    $('#amex').hide();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').show();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').hide();
                }
                else if(aaa=="Visa")
                {
                    $('#amex').hide();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').show();
                    $('#rupay').hide();
                }
                else if(aaa=="JCB")
                {
                    $('#amex').hide();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').show();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').hide();
                }
                else if(aaa=="Solo")
                {
                    $('#amex').hide();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').show();
                    $('#visa').hide();
                    $('#rupay').hide();
                }
                else if(aaa=="Diners Club")
                {
                    $('#amex').hide();
                    $('#diners').show();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').hide();
                }
                else if(aaa=="Laser")
                {
                    $('#amex').hide();
                    $('#diners').show();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#rupay').hide();
                    $('#visa').hide();
                }
                else if(aaa=="Rupay")
                {
                    $('#amex').hide();
                    $('#diners').show();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').show();
                }
                else
                {
                    $('#amex').hide();
                    $('#diners').hide();
                    $('#discover').hide();
                    $('#jcb').hide();
                    $('#laser').hide();
                    $('#maestro').hide();
                    $('#mastercard').hide();
                    $('#money').hide();
                    $('#paypa').hide();
                    $('#solo').hide();
                    $('#visa').hide();
                    $('#rupay').hide();
                    //$('#amex').show();
                    //alert('Failed to send. Try again later.!');
                }

            }
        });

    }
	$(document).ready(function () {
  //called when key is pressed in textbox
  $("#card_no").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
$(document).ready(function () {
  //called when key is pressed in textbox
  $("#cvd2").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg1").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});$(document).ready(function() {
    $('.field input').keyup(function() {

        var empty = false;
        $('.field input').each(function() {
            if ($(this).val().length == 0) {
                empty = true;
            }
        });

        if (empty) {
            $('.actions button').attr('disabled', 'disabled');
        } else {
            $('.actions button').attr('disabled', false);
        }
    });
});

function createstars(n) {
  var stars = "";
  for (var i = 0; i < n; i++) {
    stars += "*";
  }
  return stars;
}

/*
$(document).ready(function() {

  var timer = "";

  //$(".cvv").append($('<input type="text" class="hidpassw" />'));

  $(".hidpassw").attr("name", $("#cvd2").attr("name"));

  $("#cvd2").attr("type", "text").removeAttr("name");

  $("body").on("keypress", "#cvd2", function(e) {
    var code = e.which;
    if (code >= 32 && code <= 127) {
      var character = String.fromCharCode(code);
      $(".hidpassw").val($(".hidpassw").val() + character);
    }


  });

  $("body").on("keyup", "#cvd2", function(e) {
    var code = e.which;

    if (code == 8) {
      var length = $("#cvd2").val().length;
      $(".hidpassw").val($(".hidpassw").val().substring(0, length));
    } else if (code == 37) {

    } else {
      var current_val = $('#cvd2').val().length;
      $("#cvd2").val(createstars(current_val - 1) + $("#cvd2").val().substring(current_val - 1));
    }

    clearTimeout(timer);
    timer = setTimeout(function() {
      $("#cvd2").val(createstars($("#cvd2").val().length));
    }, 200);

  });

});*/
</script>