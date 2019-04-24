<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 26-08-2017
 * Time: 02:52 PM
 */
error_reporting(0);
/*if ($_SESSION['mangaaaa']=="yes")
{
    // insert query here
	$_SESSION['mangaaaa'] = "";
	unset($_SESSION["mangaaaa"]);
	session_destroy();
	//header('Refresh:1; url= responsemerchant.php?success=false&trans=cancel&txn=null&errordesc=');
}
*/
?>
<script language="JavaScript" type="text/javascript"> 
var t = setTimeout("document.myform.submit();",1000); //1 seconds measured in miliseconds
</script>
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

<form role="form" method="post" name="myform" id="formid" action="http://169.38.91.246/fbtest.php">
<!--<form role="form" method="post" name="myform" id="formid" action="http://169.38.91.250/api/smartro.php">-->
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
		<div class='col-md-4'></div>
		<div class='col-md-4 text-center'>
			<div id="canceldiv" style="display:none;">
				<div class="alert alert-success alert-dismissable">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h4><b>Transaction was cancelled</b></h4> &nbsp; &nbsp; &nbsp;
                    <a href="<?php echo $_POST['redirectionurl']; ?>">Ok</a>
				</div>
			</div>
			<?php //$avg="..defaultimg/avatar.jpg"; ?>
			<img src="img/cards/mastercard.png" onerror="this.src='../img/cards/mastercard.png'" style="width:70; height=70" >
			<img src="img/cards/paypa.png" onerror="this.src='../img/cards/paypa.png'"  style="width:70; height=70" >
			<img src="img/cards/rupay.png" onerror="this.src='../img/cards/rupay.png'"  style="width:70; height=50" >
			<img src="img/cards/visa.png" onerror="this.src='../img/cards/visa.png'" style="width:70; height=70" >

		</div>
		<div class='col-md-4'></div>
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
                        <input class='form-control'  type='text' onload="checkcard();" onclick="checkcard();" onkeyup="checkcard();" id="card_no" name="cc_number" value='<?php if($_POST['cc_number']!=""){ $var = $_POST['cc_number'];
				$var = substr_replace($var, str_repeat("X", 8), 4, 8);	echo $var;  } ?>' <?php if($senter=="success"){ echo "disabled"; } ?> required>
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
                    <select  <?php if($senter=="success"){ echo "disabled"; } ?> class='form-control' name="cc_exp_yy" id="cc_exp_yy" required>
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
                    <select  <?php if($senter=="success"){ echo "disabled"; } ?> class='form-control' name="cc_exp_mm" id="cc_exp_mm" required>
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
                    <input type='password' <?php if($senter=="success"){ echo "disabled"; } ?> class='form-control' name='cvv2' maxlength='3' id='cvd2' required>
					<span id="errmsg1" style="color:red;"></span>

                </div>
            </div>
            <div class='form-row' id="namecard" style="display: none;">
                <div class=' form-group required'>
                    <label class='control-label'>&nbsp; &nbsp; Name on card<span class="text-danger">*</span></label>
                    <div class="fake-input">
                        <input class='form-control'  type='text' id="name_on_card" name="name_on_card">
                    </div>
                </div>
            </div>
        </div>
       <div class='col-md-4'>
            Merchant Name: <?php 
			require_once('php/MysqliDb.php'); 
			if($_POST["merchant_id"]!=""){ $mid=$_POST['merchant_id']; } else { $mid="2";
                  }
				  
							$db = new Mysqlidb ('localhost', 'urebanx', 'Rebanxpg', 'rebanx');
							$db->where("idmerchants", $mid);
							$datacon =$db->getOne('merchants');
							echo $datacon['merchant_name'];
							?> <br><br>
							
            Payment Amount: <b><?php if($_POST["currency"]!=""){ echo $_POST["currency"]; } else { echo "INR"; }?> <?php if($_POST["amount"]!=""){ echo $_POST["amount"]; } else { echo "1000"; }?></b>
			<input type="hidden" name="merchant_name" id="mn" value="<?php echo $datacon['merchant_name'];?>">
        </div>
		
    </div>
    <hr class="featurette-divider"></hr>
    <div class='row'>
        <div class='col-md-3'></div>
        <div class='col-md-5'>
            <div class='form-row'>
                <div class='col-xs-12 form-group'>
                <button class="btn btn-lg btn-primary btn-block" id="btn1" type="" <?php if($senter=="success"){ echo "disabled"; } ?>   id="makepayment">Make Payment</button>
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
			<div class='form-row'>
             <!--  <a href="<?php echo $_SERVER['REQUEST_URI'];?>'?success=false&txn=null&errordesc=cancel&url=<?php echo $_POST["redirectionurl"];?>" >Cancel</a> -->
			 <a href="#" onclick="showcancel();">Cancel</a>
            </div>
		</div>
    </div>
    <div class='row'>

            <div class='col-md-2'></div>
            <div class='col-md-8'>
                <div class='form-row'>
                    <div class='col-xs-6 form-group required'>
<!--                        <label class='control-label'>First Name <span class="text-danger">*</span></label>-->
                        <input class='form-control' type='hidden' name="first_name" id="first_name" value='<?php if($_POST["first_name"]!=""){ echo $_POST["first_name"]; } else { echo "greg";
                        }?>'>
                    </div>
                    <div class='col-xs-6 form-group required'>
<!--                        <label class='control-label'>Last Name <span class="text-danger">*</span></label>-->
                        <input class='form-control' type='hidden' name="last_name" id="last_name" value='<?php if($_POST["last_name"]!=""){ echo $_POST["last_name"]; } else { echo "tampa";
                        }?>'>
                    </div>
                </div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group'>
<!--                        <label class='control-label'>Address 1</label>-->
                        <input class='form-control' type='hidden' name="address1" id="address1" value='<?php if($_POST["address1"]!=""){ echo $_POST["address1"]; } else { echo "111 hacker way";
                        }?>'>
                    </div>
                    <div class='col-xs-6 form-group'>
<!--                     <label class='control-label'>Address 2</label>-->
                        <input class='form-control' type='hidden' name="address2" id="address2" value='<?php if($_POST["address2"]!=""){ echo $_POST["address2"]; } else { echo "";
                        }?>'>
                    </div>
                </div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group'>
<!--                        <label class='control-label'>City</label>-->
                        <input class='form-control' type='hidden' name="city" id="city" value='<?php if($_POST["city"]!=""){ echo $_POST["city"]; } else { echo "Bangalore";
                        }?>'>
                    </div>
                    <div class='col-xs-6 form-group'>
<!--                        <label class='control-label'>US State</label>-->
                        <!--<select class='form-control' name="us_state">
                            <option value="">Select state</option>
                            <option value="AA">Armed Forces Americas</option>
                            <option value="AE">Armed Forces Europe</option>
                            <option value="AK">Alaska</option>
                            <option value="AL">Alabama</option>
                            <option value="AP">Armed Forces Pacific</option>
                            <option value="AR">Arkansas</option>
                            <option value="AS">American Samoa</option>
                            <option value="AZ">Arizona</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DC">District of Columbia</option>
                            <option value="DE">Delaware</option>
                            <option value="FL" selected>Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="GU">Guam</option>
                            <option value="HI">Hawaii</option>
                            <option value="IA">Iowa</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MD">Maryland</option>
                            <option value="ME">Maine</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MO">Missouri</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="MS">Mississippi</option>
                            <option value="MT">Montana</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="NE">Nebraska</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NV">Nevada</option>
                            <option value="NY">New York</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="UT">Utah</option>
                            <option value="VA">Virginia</option>
                            <option value="VI">Virgin Islands, U.S.</option>
                            <option value="VT">Vermont</option>
                            <option value="WA">Washington</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WV">West Virginia</option>
                            <option value="WY">Wyoming</option>
                        </select>-->
                        <input class='form-control' type='hidden' name="state_code"  id="us_state" value='<?php if($_POST["state_code"]!=""){ echo $_POST["state_code"]; } else {
                            echo "KA";
                        }?>'>
                    </div>
                </div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group'>
<!--                        <label class='control-label'>Postal Code</label>-->
                        <input class='form-control' type='hidden' name="postal_code" id="postal_code" value='<?php if($_POST["postal_code"]!=""){ echo $_POST["postal_code"]; } else { echo "560001";
                        }?>'>
                    </div>
                    <div class='col-xs-6 form-group'>
<!--                        <label class='control-label'>Country</label>-->
                        <!--<select class='form-control' name="country">
                            <option value="">Select country</option>
                            <option value="AF">Afghanistan</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia</option>
                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="BN">Brunei Darussalam</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">Congo, The Democratic Republic Of The</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CW">Cura�ao</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="CI">C�te D'Ivoire</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands (Malvinas)</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="TF">French Southern Territories</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard and McDonald Islands</option>
                            <option value="VA">Holy See (Vatican City State)</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran, Islamic Republic Of</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IM">Isle of Man</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KP">Korea, Democratic People's Republic Of</option>
                            <option value="KR">Korea, Republic of</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Lao People's Democratic Republic</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macao</option>
                            <option value="MK">Macedonia, the Former Yugoslav Republic Of</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia, Federated States Of</option>
                            <option value="MD">Moldova, Republic of</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="AN">Netherlands Antilles</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PW">Palau</option>
                            <option value="PS">Palestine, State of</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="QA">Qatar</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russian Federation</option>
                            <option value="RW">Rwanda</option>
                            <option value="RE">R�union</option>
                            <option value="BL">Saint Barth�lemy</option>
                            <option value="SH">Saint Helena</option>
                            <option value="KN">Saint Kitts And Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="MF">Saint Martin</option>
                            <option value="PM">Saint Pierre And Miquelon</option>
                            <option value="VC">Saint Vincent And The Grenedines</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SX">Sint Maarten</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                            <option value="SS">South Sudan</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard And Jan Mayen</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syrian Arab Republic</option>
                            <option value="TW">Taiwan, Republic Of China</option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania, United Republic of</option>
                            <option value="TH">Thailand</option>
                            <option value="TL">Timor-Leste</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad and Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks and Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option selected="selected" value="US">United States</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="UY">Uruguay</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                            <option value="VN">Vietnam</option>
                            <option value="VG">Virgin Islands, British</option>
                            <option value="VI">Virgin Islands, U.S.</option>
                            <option value="WF">Wallis and Futuna</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                            <option value="AX">�land Islands</option></select>
                            -->
                        <input class='form-control' type='hidden' name="country" id="country" value='<?php if($_POST["country"]!=""){ echo $_POST["country"]; } else { echo "IN";
                        }?>'>
                    </div>
                </div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group required'>
<!--                        <label class='control-label'>Email <span class="text-danger">*</span></label>-->
                        <input class='form-control' type='hidden' name="email" id="email" value='<?php if($_POST["email"]!=""){ echo $_POST["email"]; } else { echo "tester@gregtampa.com";
                        }?>'>
                    </div>
                    <div class='col-xs-6 form-group'>
<!--                        <label class='control-label'>Phone</label>-->
                        <input class='form-control' type='hidden' name="phone" value='<?php if($_POST["phone"]!=""){ echo $_POST["phone"]; } else { echo "9600057231";
                        }?>'>
                    </div>
                </div>
            </div>
            <div class='col-md-2'></div>
    </div>
<!--    <h4 class="text-center">Shipping Information</h4>-->
<!--    <hr class="featurette-divider"></hr>-->
    <div class='row'>

        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping First Name</label>-->
                    <input class='form-control' type='hidden' name='shipping_first_name' id='shipping_first_name' value='<?php if($_POST["shipping_first_name"]!=""){ echo $_POST["shipping_first_name"]; } else { echo "";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group'>
<!--                 <label class='control-label'>Shipping Last Name</label>-->
                    <input class='form-control' type='hidden' name='shipping_last_name' id='shipping_last_name'  value='<?php if($_POST["shipping_last_name"]!=""){ echo $_POST["shipping_last_name"]; } else { echo "";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping Address 1</label>-->
                    <input class='form-control' type='hidden' name='shipping_address1' id='shipping_address1' value='<?php if($_POST["shipping_address1"]!=""){ echo $_POST["shipping_address1"]; } else { echo "";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping Address 2</label>-->
                    <input class='form-control' type='hidden' name='shipping_address2' value='<?php if($_POST["shipping_address2"]!=""){ echo $_POST["shipping_address2"]; } else { echo ""; }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping City</label>-->
                    <input class='form-control' type='hidden' name='shipping_city' value='<?php if($_POST["shipping_city"]!=""){ echo $_POST["shipping_city"]; } else { echo "Bangalore";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping US State</label>-->
                    <!--<select class='form-control' name="shipping_us_state">
                        <option value="">Select state</option>
                        <option value="AA">Armed Forces Americas</option>
                        <option value="AE">Armed Forces Europe</option>
                        <option value="AK">Alaska</option>
                        <option value="AL">Alabama</option>
                        <option value="AP">Armed Forces Pacific</option>
                        <option value="AR">Arkansas</option>
                        <option value="AS">American Samoa</option>
                        <option value="AZ">Arizona</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DC">District of Columbia</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="GU">Guam</option>
                        <option value="HI">Hawaii</option>
                        <option value="IA">Iowa</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MD">Maryland</option>
                        <option value="ME">Maine</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MO">Missouri</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="MS">Mississippi</option>
                        <option value="MT">Montana</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="NE">Nebraska</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NV">Nevada</option>
                        <option value="NY">New York</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UM">United States Minor Outlying Islands</option>
                        <option value="UT">Utah</option>
                        <option value="VA">Virginia</option>
                        <option value="VI">Virgin Islands, U.S.</option>
                        <option value="VT">Vermont</option>
                        <option value="WA">Washington</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WV">West Virginia</option>
                        <option value="WY">Wyoming</option>
                    </select>-->
                    <input class='form-control' type='hidden' name="shipping_us_state" id="shipping_us_state" value='<?php if($_POST["shipping_us_state"]!=""){ echo $_POST["shipping_us_state"]; } else { echo "KA";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
					<!--<label class='control-label'>Shipping Postal Code</label>-->
                    <input class='form-control' type='hidden' name="shipping_postal_code" id="shipping_postal_code" value='<?php if($_POST["shipping_postal_code"]!=""){ echo $_POST["shipping_postal_code"]; } else { echo "560001";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping Country</label>-->
                    <!--<select class='form-control' name="shipping_country">
                        <option value="">Select country</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AQ">Antarctica</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BV">Bouvet Island</option>
                        <option value="BR">Brazil</option>
                        <option value="IO">British Indian Ocean Territory</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CX">Christmas Island</option>
                        <option value="CC">Cocos (Keeling) Islands</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CG">Congo</option>
                        <option value="CD">Congo, The Democratic Republic Of The</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CW">Cura�ao</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="CI">C�te D'Ivoire</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands (Malvinas)</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="TF">French Southern Territories</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GG">Guernsey</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HT">Haiti</option>
                        <option value="HM">Heard and McDonald Islands</option>
                        <option value="VA">Holy See (Vatican City State)</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IR">Iran, Islamic Republic Of</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Ireland</option>
                        <option value="IM">Isle of Man</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JE">Jersey</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KP">Korea, Democratic People's Republic Of</option>
                        <option value="KR">Korea, Republic of</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Lao People's Democratic Republic</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macao</option>
                        <option value="MK">Macedonia, the Former Yugoslav Republic Of</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia, Federated States Of</option>
                        <option value="MD">Moldova, Republic of</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="ME">Montenegro</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="AN">Netherlands Antilles</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau</option>
                        <option value="PS">Palestine, State of</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russian Federation</option>
                        <option value="RW">Rwanda</option>
                        <option value="RE">R�union</option>
                        <option value="BL">Saint Barth�lemy</option>
                        <option value="SH">Saint Helena</option>
                        <option value="KN">Saint Kitts And Nevis</option>
                        <option value="LC">Saint Lucia</option>
                        <option value="MF">Saint Martin</option>
                        <option value="PM">Saint Pierre And Miquelon</option>
                        <option value="VC">Saint Vincent And The Grenedines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome and Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SX">Sint Maarten</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                        <option value="SS">South Sudan</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard And Jan Mayen</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syrian Arab Republic</option>
                        <option value="TW">Taiwan, Republic Of China</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania, United Republic of</option>
                        <option value="TH">Thailand</option>
                        <option value="TL">Timor-Leste</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option selected="selected" value="US">United States</option>
                        <option value="UM">United States Minor Outlying Islands</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                        <option value="VN">Vietnam</option>
                        <option value="VG">Virgin Islands, British</option>
                        <option value="VI">Virgin Islands, U.S.</option>
                        <option value="WF">Wallis and Futuna</option>
                        <option value="EH">Western Sahara</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                        <option value="AX">�land Islands</option>
                    </select>-->
                    <input class='form-control' type='hidden' name="shipping_country" id="shipping_country" value='<?php if($_POST["shipping_country"]!=""){ echo $_POST["shipping_country"]; } else { echo "IN";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
<!--                    <label class='control-label'>Shipping Email</label>-->
                    <input class='form-control' type='hidden' name="shipping_email" id="shipping_email" value='<?php if($_POST["shipping_email"]!=""){ echo $_POST["shipping_email"]; } else { echo "";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group'>

                </div>
            </div>
        </div>
        <div class='col-md-2'></div>
    </div>

<!--    <h4 class="text-center">Prefilled Fields</h4>-->
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='form-row'>
                <div class='col-xs-12 form-group required'>
<!--                    <label class='control-label'>Product Name <span class="text-danger">*</span></label>-->
                    <input class='form-control' type='hidden' name="ponumber" id="ponumber" value='<?php if($_POST["orderid"]!=""){ echo $_POST["orderid"]; } else { echo "234";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>ENV <span class="text-danger">*</span></label>-->
                    <!--<select class='form-control' name="env">
                        <option value="test">test</option>
                        <option value="livetest">livetest</option>
                        <option value="live" selected>live</option>
                    </select>-->
                    <input class='form-control' type='hidden' name="env"  id="env" value='<?php if($_POST["env"]!=""){ echo $_POST["env"]; } else { echo "live";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>TransactionType <span class="text-danger">*</span></label>-->
                    <!--<select class='form-control'  name="TransactionType">
                        <option value="AA" selected>AA(Authorization)</option>
                        <option value="AC">AC(Refund)</option>
                        <option value="AD">AD(Refund within Network)</option>
                        <option value="AQ">AQ(Real_time Capture Request)</option>
                        <option value="AS">AS(Verification Approval)</option>
                        <option value="SQ">SQ(3D Secure Verification Approval)</option>
                    </select>-->
                    <input class='form-control' type='hidden' name="TransactionType"  id="TransactionType"  value='<?php if($_POST["TransactionType"]!=""){ echo $_POST["TransactionType"]; } else { echo "AA";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <!--<div class='col-xs-12 form-group required'>
                    <label class='control-label'>API KEY <span class="text-danger">*</span></label>
                    <input class='form-control' type='text' name="apikey" value=''>
                </div>-->
                <div class='col-xs-4 form-group required'>
<!--                  <label class='control-label'>Merchant ID <span class="text-danger">*</span></label>-->
                  <input class='form-control' type='hidden' name="merchant_id" id="merchant_id" value='<?php if($_POST["merchant_id"]!=""){ echo $_POST["merchant_id"]; } else { echo "206";
                  }?>'>
                </div>
                <div class='col-xs-4 form-group required'>
<!--                  <label class='control-label'>Gateway ID <span class="text-danger">*</span></label>-->
                  <input class='form-control' type='hidden' name="platform_id" id="platform_id"  value='<?php if($_POST["platform_id"]!=""){ echo $_POST["platform_id"]; } else { echo "3";
                  }?>'>
                </div>
                <div class='col-xs-4 form-group required'>
<!--                  <label class='control-label'>Bank ID <span class="text-danger">*</span></label>-->
                  <input class='form-control' type='hidden' name="processor_id" id="processor_id" value='<?php if($_POST["processor_id"]!=""){ echo $_POST["processor_id"]; } else { echo "3";
                  }?>'>
                  <input class='form-control' type='hidden' name="gateway_id" id="gateway_id" value='<?php if($_POST["gateway_id"]!=""){ echo $_POST["gateway_id"]; } else { echo "3";
                  }?>'>
                  <input class='form-control' type='hidden' name="supersecret" id="supersecret" value='<?php if($_POST["supersecret"]!=""){ echo $_POST["supersecret"]; } else { echo "1";
                  }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-12 form-group required'>
<!--                    <label class='control-label'>Currency <span class="text-danger">*</span></label>-->
                    <!--<select class='form-control'  name="currency">
                        <option value="USD" selected>USD(US Dollar)</option>
                        <option value="JPY">JPY(Japanese Yen)</option>
                        <option value="EUR">EUR(Euro)</option>
                        <option value="HKD">HKD(Hong Kong Dollar)</option>
                        <option value="GBP">GBP(British Pound)</option>
                        <option value="SGD">SGD(Singapore Dollar)</option>
                        <option value="AUD">AUD(Australian Dollar)</option>
                        <option value="THB">THB(Thailand Baht)</option>
                        <option value="CAD">CAD(Canadian Dollar)</option>
                        <option value="RUB">RUB(Russian Dollar)</option>
                        <option value="CNY">CNY(Chinese Yuan)</option>
                    </select>-->
                  <input class='form-control' type='hidden' name="currency"  id="currency"   value="<?php if($_POST["currency"]!=""){ echo $_POST["currency"]; } else { echo "IND";
                    }?>">
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>Tax <span class="text-danger">*</span></label>-->
                    <input class='form-control' type='hidden' name="tax" id="tax" value ='<?php if($_POST["tax"]!=""){ echo $_POST["tax"]; } else { echo "0";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>Amount <span class="text-danger">*</span></label>-->
                    <input class='form-control' type='hidden' name="amount" id="amount" value='<?php if($_POST["amount"]!=""){ echo $_POST["amount"]; } else { echo "1006";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>Buyer IP <span class="text-danger">*</span></label>-->
                    <input class='form-control' type='hidden' name="BuyerIP" id="BuyerIP" value='<?php if($_POST["BuyerIP"]!=""){ echo $_POST["BuyerIP"]; } else { echo "127.0.0.1";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>Buyer ID <span class="text-danger">*</span></label>-->
                    <input class='form-control' type='hidden' name="BuyerID" id="BuyerID" value='<?php if($_POST["BuyerID"]!=""){ echo $_POST["BuyerID"]; } else { echo "buyer";
                    }?>'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group required'>
<!--                    <label class='control-label'>Acquire Type <span class="text-danger">*</span></label>-->
<!--                    <select class='form-control'  name="acquireType">
                        <option value="0">0</option>
                        <option value="1" selected>1</option>
                    </select>-->
                    <input class='form-control' type='hidden' name="acquireType" id="acquireType" value='<?php if($_POST["acquireType"]!=""){ echo $_POST["acquireType"]; } else { echo "1";
                    }?>'>
                </div>
                <div class='col-xs-6 form-group'>
					<?php $redirect=$_POST["redirectionurl"]; ?>
					<input type="hidden" name="redirectionurl" id="redirectionurl" value="<?php if($redirect!=""){ echo $_POST["redirectionurl"]; } else { echo "http://localhost/html/fbtest"; }?>">
                </div>
            </div>
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
<div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
<div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
<center><img src="load.gif" alt="Loading" id='gif'></center>
Please Wait! <Br> <b style="color: red;"></b>
</div>
</div>
<script type="text/javascript">
  //document.getElementById("formid").submit(); 
</script>
<script type="text/javascript">

$(document).ready(function(){
    $("#makepayment").click(function(){
        $("#checking").show();
    });
   
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
                    $('#namecard').show();
                    $("#name_on_card").attr('required', false);

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
                    $('#namecard').show();
                    $("#name_on_card").attr('required', false);
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
                    $('#namecard').show();
                    $("#name_on_card").attr('required', true);
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
                    $('#namecard').show();
                    $("#name_on_card").attr('required', true);
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
                    $('#namecard').hide();
                    $("#name_on_card").attr('required', false);
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
                    $('#namecard').hide();
                    $("#name_on_card").attr('required', false);
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
                    $('#namecard').hide();
                    $("#name_on_card").attr('required', false);
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
                    $('#namecard').hide();
                    $("#name_on_card").attr('required', false);
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
                    $('#namecard').hide();
                    $("#name_on_card").attr('required', false);
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
                    $('#namecard').hide();
                    $("#name_on_card").attr('required', false);
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