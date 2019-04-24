<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
 <br>

<div class="container">
<div class='row'>
<h1 class="text-center">Transaction</h1>
 <hr class="featurette-divider"></hr>
</div>
<div class='row'>
<form  role="form" method="post" action="smartro.php">
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>First Name <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="first_name" value='greg'>
		  </div>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Last Name <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="last_name" value='tampa'>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Address 1</label>
			<input class='form-control' type='text' name="address1" value='111 hacker way'>
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Address 2</label>
			<input class='form-control' type='text' name="address2">
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>City</label>
			<input class='form-control' type='text' name="city" value='fort lauderdale'>
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>US State</label>
				<select class='form-control' name="us_state">
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
</select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Postal Code</label>
			<input class='form-control' type='text' name="postal_code" value='33065'>
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Country</label>
			<select class='form-control' name="country">
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
				<option value="CW">Curaçao</option>
				<option value="CY">Cyprus</option>
				<option value="CZ">Czech Republic</option>
				<option value="CI">Côte D'Ivoire</option>
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
				<option value="RE">Réunion</option>
				<option value="BL">Saint Barthélemy</option>
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
				<option value="AX">Åland Islands</option></select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Email <span class="text-danger">*</span></label>
			<input class='form-control' type='email' name="email" value='tester@gregtampa.com'>
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Phone</label>
			<input class='form-control' type='text' name="phone">
		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<h4 class="text-center">Shipping Information</h4>
<hr class="featurette-divider"></hr>
<div class='row'>
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping First Name</label>
			<input class='form-control' type='text' name="shipping_first_name">
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping Last Name</label>
			<input class='form-control' type='text' name="shipping_last_name">
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping Address 1</label>
			<input class='form-control' type='text' name="shipping_address1">
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping Address 2</label>
			<input class='form-control' type='text' name="shipping_address2">
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping City</label>
			<input class='form-control' type='text' name="shipping_city">
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping US State</label>
				<select class='form-control' name="shipping_us_state">
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
				</select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping Postal Code</label>
			<input class='form-control' type='text' name="shipping_postal_code">
		  </div>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping Country</label>
			<select class='form-control' name="shipping_country">
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
				<option value="CW">Curaçao</option>
				<option value="CY">Cyprus</option>
				<option value="CZ">Czech Republic</option>
				<option value="CI">Côte D'Ivoire</option>
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
				<option value="RE">Réunion</option>
				<option value="BL">Saint Barthélemy</option>
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
				<option value="AX">Åland Islands</option>
			</select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group'>
			<label class='control-label'>Shipping Email</label>
			<input class='form-control' type='email' name="shipping_email">
		  </div>
		  <div class='col-xs-6 form-group'>

		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<h4 class="text-center">Billing Information</h4>
<hr class="featurette-divider"></hr>
<div class='row'>
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-5 form-group required'>
			<label class='control-label'>Credit Card <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="cc_number" value='4907639999990022'>
		  </div>
		  <div class='col-xs-2 form-group required'>
			<label class='control-label'>Exp. Year <span class="text-danger">*</span></label>
			<select  class='form-control'name="cc_exp_yy">
				<option value="">Year</option>
				<option value="15" selected>2015</option>
				<option value="16">2016</option>
				<option value="17">2017</option>
				<option value="18">2018</option>
				<option value="19">2019</option>
				<option value="20">2020</option>
				<option value="21">2021</option>
				<option value="22">2022</option>
			</select>
		  </div>
		  <div class='col-xs-3 form-group required'>
			<label class='control-label'>Exp. Month <span class="text-danger">*</span></label>
				<select  class='form-control' name="cc_exp_mm">
					<option value="">Month</option>
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
					<option value="12" selected>December</option>
				</select>
		  </div>
		  <div class='col-xs-2 form-group required'>
			<label class='control-label'>CVV <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="cavv" value='029'>
		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<hr class="featurette-divider"></hr>
<h4 class="text-center">Prefilled Fields</h4>
<div class='row'>
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-12 form-group required'>
			<label class='control-label'>Product Name <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="ponumber" value='some product'>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>ENV <span class="text-danger">*</span></label>
			<select class='form-control' name="env">
				<option value="test" selected>test</option>
				<option value="livetest">livetest</option>
				<option value="live">live</option>
			</select>
		  </div>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>TransactionType <span class="text-danger">*</span></label>
			<select class='form-control'  name="TransactionType">
				<option value="AA" selected>AA(Authorization)</option>
				<option value="AC">AC(Refund)</option>
				<option value="AD">AD(Refund within Network)</option>
				<option value="AQ">AQ(Real_time Capture Request)</option>
				<option value="AS">AS(Verification Approval)</option>
				<option value="SQ">SQ(3D Secure Verification Approval)</option>
			</select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-12 form-group required'>
			<label class='control-label'>API KEY <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="apikey" value='wUPRa6YdT5HXp3N4G5lbiQC7IpleMwx9Iqhcz4XnHIwwI4mfD/RNoL01cG+sVAWekbSGE3OS0+h++wGoU6E86i9TGKrbFTx8BNH3OUwg0XjFCXbPWEJKvMee5eU3nonn|yXCgB9LcSmTbqeSCwBcI/D3CbefeHNBAVoXrB4yFhBg='>
		  </div>
		  <!--div class='col-xs-4 form-group required'>
			<label class='control-label'>Merchant ID <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="merchant_id" value='11'>
		  </div>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>Gateway ID <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="platform_id" value='2'>
		  </div>
		  <div class='col-xs-4 form-group required'>
			<label class='control-label'>Bank ID <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="processor_id" value='1'>
			<input class='form-control' type='hidden' name="supersecret" value='1'>
		  </div-->
		</div>
		<div class='form-row'>
		  <div class='col-xs-12 form-group required'>
			<label class='control-label'>Currency <span class="text-danger">*</span></label>
			<select class='form-control'  name="currency">
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
			</select>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Tax <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="tax" value ='0'>
		  </div>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Amount <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="amount" value='10.06'>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Buyer IP <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="BuyerIP" value='127.0.0.1'>
		  </div>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Buyer ID <span class="text-danger">*</span></label>
			<input class='form-control' type='text' name="BuyerID" value='buyer'>
		  </div>
		</div>
		<div class='form-row'>
		  <div class='col-xs-6 form-group required'>
			<label class='control-label'>Acquire Type <span class="text-danger">*</span></label>
			<select class='form-control'  name="acquireType">
				<option value="0">0</option>
				<option value="1" selected>1</option>
			</select>
		  </div>
		  <div class='col-xs-6 form-group'>
		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<hr class="featurette-divider"></hr>
<div class='row'>
	<div class='col-md-2'></div>
	<div class='col-md-8'>
		<div class='form-row'>
		  <div class='col-xs-12 form-group'>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		  </div>
		</div>
	</div>
	<div class='col-md-2'></div>
</div>
<br /><br />
</form>
</div>
</body>
</html>