<?php 
require_once( 'header.php');
require_once( 'php/common_functions.php');
$merchant_name = "admin";
if ($usertype == 1) {
	$VTMerchants = getVTMerchantsofAdmin();
} else {	
	if(!empty($mid) && $mid > 0) {
		$merchant_name = getUserMerchantName($id);
		$merchant_processors = getUserMerchantProcessors($mid);
		}
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Virtual Terminal</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li>
				<a href="dashboard.php">Virtual Terminal</a>
			</li>
			<li class="active">
				<strong>Sales and Authorizations</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row" id="cb-filter">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Sale/Authorization</h5>&nbsp;&nbsp;&nbsp;<small><span class="text-danger">**</span> denotes required information</small>
			</div>
			<div class="ibox-content">
			<?php if($usertype !=1 && (!empty($merchant_processors) && count($merchant_processors) == 0 )) { ?>
			<div class="alert alert-danger">
				You don't have any processors set up!
			</div>
			<?php } else { ?>
			<form id="vtform">
				<div class="row">
					<div class="col-sm-4 b-r">
						<?php if($usertype == 1) { ?>
							<h3 class="m-t-none m-b">Merchants</h3>
							<select name="merchant_id" id="merchant_id" class="form-control m-b chosen-select required" tabindex="2">
								<option value="0">-- Select Merchant --</option>
								<?php foreach($VTMerchants as $merchant) { ?>
								<option <?php if(isset($_POST['merchant_id'])){if($_POST['merchant_id'] == $merchant['idmerchants']){echo selected;}} ?>  value="<?php echo $merchant['idmerchants']; ?>"><?php echo $merchant['merchant_name']; ?></option>
								<?php } ?>
							</select>
						<?php } else { ?>
							<h3 class="m-t-none m-b">Merchant</h3>
							<h5><?php echo $merchant_name; ?></h5>
							<input type="hidden" value="<?php if(!empty($mid)) echo $mid; ?>" name="merchant_id" id="merchant_id">
						<?php } ?>
					</div>
					<?php if($usertype == 1) { ?>
						<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Processor</h3>
						<div id="processoridbox">
							<label>-- First Select a Merchant --</label>
						</div>
						</div>
						<div class="col-sm-4"><h3 class="m-t-none m-b">Gateway</h3>
							<div id="gatewaybox">
								<label>-- First Select a Processor --</label>
							</div>
						</div>
					<?php } elseif(!empty($merchant_processors) && count($merchant_processors) == 1) { ?>
						<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Processor</h3>
							<h5><?php echo $merchant_processors[0]['processor_name']; ?></h5>
							<input type="hidden" value="<?php echo $merchant_processors[0]['processor_id']; ?>" id="processor_id" name="processor_id">
						</div>
						<div class="col-sm-4"><h3 class="m-t-none m-b">Gateway</h3>
							<h5><?php echo $merchant_processors[0]['gateway_name']; ?></h5>
							<input type="hidden" value="<?php echo $merchant_processors[0]['gateway_id']; ?>" id="gateway_id" name="gateway_id">
						</div>
					<?php } else { ?>
						<div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Processor</h3>
							<select class="form-control m-b  chosen-select required" id="processor_id" name="processor_id" chosen>
								<?php foreach($merchant_processors as $merchant_processor) { ?>
								<option value="<?php echo $merchant_processor['processor_id']; ?>"><?php echo $merchant_processor['processor_name']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-4"><h3 class="m-t-none m-b">Gateway</h3>
							<div id="gatewaybox">
								<label>-- First Select a Processor --</label>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Billing Information</h3>
							<div class="form-group">
								<label>Credit Card Number <span class="text-danger">**</span></label> 
								<input type="text" class="form-control required" name="cc_number" id="cc_number" value="">
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
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
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class='control-label'>Exp. Month <span class="text-danger">*</span></label>
										<select  class='form-control required' name="cc_exp_mm">
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
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class='control-label'>CVV <span class="text-danger">*</span></label>
										<input class='form-control required' type='text' name="cavv">
									</div>
								</div>
							</div>
					</div>
					<div class="col-sm-6"><h3 class="m-t-none m-b">Order Information</h3>
						<div class="form-group">
							<label>Order ID  <span class="text-danger">**</span></label> 
							<input type="text" class="form-control required" name="ponumber" id="ponumber">
						</div>
						<div class="form-group">
							<label>Order Description  </label> 
							<input type="text" class="form-control" name="order_description" id="order_description">
						</div>
						<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
											<label>Total Amount <span class="text-danger">**</span></label> 
											<input type="text" class="form-control required" name="amount" id="amount">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Currency</label> 
										<select name="currency" id="currency" class="form-control m-b">
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
								<div class="col-sm-4">
									<div class="form-group">
										<label>Tax </label> 
										<input type="text" class="form-control required" name="tax" id="tax" value="0">
									</div>
								</div>
						</div>
				</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Billing Address</h3>
						<div class="form-group">
							<label>First Name  <span class="text-danger">**</span></label> 
							<input type="text" class="form-control required" name="first_name" id="first_name">
						</div>
						<div class="form-group">
							<label>Last Name  <span class="text-danger">**</span></label> 
							<input type="text" class="form-control required" name="last_name" id="last_name">
						</div>
						<div class="form-group">
							<label>Address </label> 
							<input type="text" class="form-control" name="address1" id="address1">
						</div>
						<div class="form-group">
							<label>Address (cont.)</label> 
							<input type="text" class="form-control" name="address2" id="address2">
						</div>
						<div class="form-group">
							<label>City  </label> 
							<input type="text" class="form-control" name="city" id="city">
						</div>
						<div class="form-group">
							<label>ZIP/Postal Code  </label> 
							<input type="text" class="form-control" name="postal_code" id="postal_code">
						</div>
						<div class='form-group'>
							<label class='control-label'>Country</label>
							<select class='form-control' name="country" id="country">
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
						<div class="form-group" id="statebox">
								<label>State</label>
								<select id="us_state" name="us_state" class="form-control">
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="DC">District Of Columbia</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
						</div>
						<div class="form-group">
							<label>Phone </label> 
							<input type="text" class="form-control" name="phone" id="phone">
						</div>
						<div class="form-group">
							<label>Email  <span class="text-danger">**</span></label> 
							<input type="email" class="form-control required" name="email" id="email">
						</div>
					</div>
					<div class="col-sm-6"><h3 class="m-t-none m-b">Shipping Address</h3>
						<div>
							<input type="checkbox" name="check-address" id="check-address"> <i></i> The shipping address is the same as the billing address. 
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<label>First Name</label> 
							<input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name">
						</div>
						<div class="form-group">
							<label>Last Name </label> 
							<input type="text" class="form-control" name="shipping_last_name" id="shipping_last_name">
						</div>
						 <div class="form-group">
							<label>Country </label>
							<select name="shipping_country" id="shipping_country" class="form-control">
								<option value="US">United States of America</option>
								<option value="AF">Afghanistan</option>
								<option value="AL">Albania</option>
								<option value="DZ">Algeria</option>
								<option value="AS">American Samoa</option>
								<option value="AD">Andorra</option>
								<option value="AG">Angola</option>
								<option value="AI">Anguilla</option>
								<option value="AG">Antigua &amp; Barbuda</option>
								<option value="AR">Argentina</option>
								<option value="AA">Armenia</option>
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
								<option value="BL">Bonaire</option>
								<option value="BA">Bosnia &amp; Herzegovina</option>
								<option value="BW">Botswana</option>
								<option value="BR">Brazil</option>
								<option value="BC">British Indian Ocean Ter</option>
								<option value="BN">Brunei</option>
								<option value="BG">Bulgaria</option>
								<option value="BF">Burkina Faso</option>
								<option value="BI">Burundi</option>
								<option value="KH">Cambodia</option>
								<option value="CM">Cameroon</option>
								<option value="CA">Canada</option>
								<option value="IC">Canary Islands</option>
								<option value="CV">Cape Verde</option>
								<option value="KY">Cayman Islands</option>
								<option value="CF">Central African Republic</option>
								<option value="TD">Chad</option>
								<option value="CD">Channel Islands</option>
								<option value="CL">Chile</option>
								<option value="CN">China</option>
								<option value="CI">Christmas Island</option>
								<option value="CS">Cocos Island</option>
								<option value="CO">Colombia</option>
								<option value="CC">Comoros</option>
								<option value="CG">Congo</option>
								<option value="CK">Cook Islands</option>
								<option value="CR">Costa Rica</option>
								<option value="CT">Cote D Ivoire</option>
								<option value="HR">Croatia</option>
								<option value="CU">Cuba</option>
								<option value="CB">Curacao</option>
								<option value="CY">Cyprus</option>
								<option value="CZ">Czech Republic</option>
								<option value="DK">Denmark</option>
								<option value="DJ">Djibouti</option>
								<option value="DM">Dominica</option>
								<option value="DO">Dominican Republic</option>
								<option value="TM">East Timor</option>
								<option value="EC">Ecuador</option>
								<option value="EG">Egypt</option>
								<option value="SV">El Salvador</option>
								<option value="GQ">Equatorial Guinea</option>
								<option value="ER">Eritrea</option>
								<option value="EE">Estonia</option>
								<option value="ET">Ethiopia</option>
								<option value="FA">Falkland Islands</option>
								<option value="FO">Faroe Islands</option>
								<option value="FJ">Fiji</option>
								<option value="FI">Finland</option>
								<option value="FR">France</option>
								<option value="GF">French Guiana</option>
								<option value="PF">French Polynesia</option>
								<option value="FS">French Southern Ter</option>
								<option value="GA">Gabon</option>
								<option value="GM">Gambia</option>
								<option value="GE">Georgia</option>
								<option value="DE">Germany</option>
								<option value="GH">Ghana</option>
								<option value="GI">Gibraltar</option>
								<option value="GB">Great Britain</option>
								<option value="GR">Greece</option>
								<option value="GL">Greenland</option>
								<option value="GD">Grenada</option>
								<option value="GP">Guadeloupe</option>
								<option value="GU">Guam</option>
								<option value="GT">Guatemala</option>
								<option value="GN">Guinea</option>
								<option value="GY">Guyana</option>
								<option value="HT">Haiti</option>
								<option value="HW">Hawaii</option>
								<option value="HN">Honduras</option>
								<option value="HK">Hong Kong</option>
								<option value="HU">Hungary</option>
								<option value="IS">Iceland</option>
								<option value="IN">India</option>
								<option value="ID">Indonesia</option>
								<option value="IA">Iran</option>
								<option value="IQ">Iraq</option>
								<option value="IR">Ireland</option>
								<option value="IM">Isle of Man</option>
								<option value="IL">Israel</option>
								<option value="IT">Italy</option>
								<option value="JM">Jamaica</option>
								<option value="JP">Japan</option>
								<option value="JO">Jordan</option>
								<option value="KZ">Kazakhstan</option>
								<option value="KE">Kenya</option>
								<option value="KI">Kiribati</option>
								<option value="NK">Korea North</option>
								<option value="KS">Korea South</option>
								<option value="KW">Kuwait</option>
								<option value="KG">Kyrgyzstan</option>
								<option value="LA">Laos</option>
								<option value="LV">Latvia</option>
								<option value="LB">Lebanon</option>
								<option value="LS">Lesotho</option>
								<option value="LR">Liberia</option>
								<option value="LY">Libya</option>
								<option value="LI">Liechtenstein</option>
								<option value="LT">Lithuania</option>
								<option value="LU">Luxembourg</option>
								<option value="MO">Macau</option>
								<option value="MK">Macedonia</option>
								<option value="MG">Madagascar</option>
								<option value="MY">Malaysia</option>
								<option value="MW">Malawi</option>
								<option value="MV">Maldives</option>
								<option value="ML">Mali</option>
								<option value="MT">Malta</option>
								<option value="MH">Marshall Islands</option>
								<option value="MQ">Martinique</option>
								<option value="MR">Mauritania</option>
								<option value="MU">Mauritius</option>
								<option value="ME">Mayotte</option>
								<option value="MX">Mexico</option>
								<option value="MI">Midway Islands</option>
								<option value="MD">Moldova</option>
								<option value="MC">Monaco</option>
								<option value="MN">Mongolia</option>
								<option value="MS">Montserrat</option>
								<option value="MA">Morocco</option>
								<option value="MZ">Mozambique</option>
								<option value="MM">Myanmar</option>
								<option value="NA">Nambia</option>
								<option value="NU">Nauru</option>
								<option value="NP">Nepal</option>
								<option value="AN">Netherland Antilles</option>
								<option value="NL">Netherlands (Holland, Europe)</option>
								<option value="NV">Nevis</option>
								<option value="NC">New Caledonia</option>
								<option value="NZ">New Zealand</option>
								<option value="NI">Nicaragua</option>
								<option value="NE">Niger</option>
								<option value="NG">Nigeria</option>
								<option value="NW">Niue</option>
								<option value="NF">Norfolk Island</option>
								<option value="NO">Norway</option>
								<option value="OM">Oman</option>
								<option value="PK">Pakistan</option>
								<option value="PW">Palau Island</option>
								<option value="PS">Palestine</option>
								<option value="PA">Panama</option>
								<option value="PG">Papua New Guinea</option>
								<option value="PY">Paraguay</option>
								<option value="PE">Peru</option>
								<option value="PH">Philippines</option>
								<option value="PO">Pitcairn Island</option>
								<option value="PL">Poland</option>
								<option value="PT">Portugal</option>
								<option value="PR">Puerto Rico</option>
								<option value="QA">Qatar</option>
								<option value="ME">Republic of Montenegro</option>
								<option value="RS">Republic of Serbia</option>
								<option value="RE">Reunion</option>
								<option value="RO">Romania</option>
								<option value="RU">Russia</option>
								<option value="RW">Rwanda</option>
								<option value="NT">St Barthelemy</option>
								<option value="EU">St Eustatius</option>
								<option value="HE">St Helena</option>
								<option value="KN">St Kitts-Nevis</option>
								<option value="LC">St Lucia</option>
								<option value="MB">St Maarten</option>
								<option value="PM">St Pierre &amp; Miquelon</option>
								<option value="VC">St Vincent &amp; Grenadines</option>
								<option value="SP">Saipan</option>
								<option value="SO">Samoa</option>
								<option value="AS">Samoa American</option>
								<option value="SM">San Marino</option>
								<option value="ST">Sao Tome &amp; Principe</option>
								<option value="SA">Saudi Arabia</option>
								<option value="SN">Senegal</option>
								<option value="RS">Serbia</option>
								<option value="SC">Seychelles</option>
								<option value="SL">Sierra Leone</option>
								<option value="SG">Singapore</option>
								<option value="SK">Slovakia</option>
								<option value="SI">Slovenia</option>
								<option value="SB">Solomon Islands</option>
								<option value="OI">Somalia</option>
								<option value="ZA">South Africa</option>
								<option value="ES">Spain</option>
								<option value="LK">Sri Lanka</option>
								<option value="SD">Sudan</option>
								<option value="SR">Suriname</option>
								<option value="SZ">Swaziland</option>
								<option value="SE">Sweden</option>
								<option value="CH">Switzerland</option>
								<option value="SY">Syria</option>
								<option value="TA">Tahiti</option>
								<option value="TW">Taiwan</option>
								<option value="TJ">Tajikistan</option>
								<option value="TZ">Tanzania</option>
								<option value="TH">Thailand</option>
								<option value="TG">Togo</option>
								<option value="TK">Tokelau</option>
								<option value="TO">Tonga</option>
								<option value="TT">Trinidad &amp; Tobago</option>
								<option value="TN">Tunisia</option>
								<option value="TR">Turkey</option>
								<option value="TU">Turkmenistan</option>
								<option value="TC">Turks &amp; Caicos Is</option>
								<option value="TV">Tuvalu</option>
								<option value="UG">Uganda</option>
								<option value="UA">Ukraine</option>
								<option value="AE">United Arab Emirates</option>
								<option value="GB">United Kingdom</option>
								<option value="UY">Uruguay</option>
								<option value="UZ">Uzbekistan</option>
								<option value="VU">Vanuatu</option>
								<option value="VS">Vatican City State</option>
								<option value="VE">Venezuela</option>
								<option value="VN">Vietnam</option>
								<option value="VB">Virgin Islands (Brit)</option>
								<option value="VA">Virgin Islands (USA)</option>
								<option value="WK">Wake Island</option>
								<option value="WF">Wallis &amp; Futana Is</option>
								<option value="YE">Yemen</option>
								<option value="ZR">Zaire</option>
								<option value="ZM">Zambia</option>
								<option value="ZW">Zimbabwe</option>
							</select>
						</div>
						<div class="form-group" id="statebox_ship">
								<label>State</label>
								<select id="shipping_us_state" name="shipping_us_state" class="form-control">
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="DC">District Of Columbia</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
						</div>
						<div class="form-group">
							<label>Address </label> 
							<input type="text" class="form-control" name="shipping_address1" id="shipping_address1">
						</div>
						<div class="form-group">
							<label>Address (cont.)</label> 
							<input type="text" class="form-control" name="shipping_address2" id="shipping_address2">
						</div>
						<div class="form-group">
							<label>City </label> 
							<input type="text" class="form-control" name="shipping_city" id="shipping_city">
						</div>
						<div class="form-group">
							<label>ZIP/Postal Code</label> 
							<input type="text" class="form-control" name="shipping_postal_code" id="shipping_postal_code">
						</div>
						<div class="form-group">
							<label>Email </label> 
							<input type="email" class="form-control" name="shipping_email" id="shipping_email">
						</div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-sm-6 b-r">
						<div class="form-group">
							<label class="control-label">ENV <span class="text-danger">*</span></label>
							<select name="env" class="form-control required">
								<option selected="" value="test">test</option>
								<option value="livetest">livetest</option>
								<option value="live">live</option>
							</select>
						</div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-sm-6"></div>
					<div class="col-sm-6">
						<div class="row">
							<div class="chargecardresult"></div>
							<input type="hidden" value="127.0.0.1" name="BuyerIP" class="form-control required">
							<input type="hidden" value="<?php echo $merchant_name ?>" name="BuyerID" id="buyerid" class="form-control required">
							<input type="hidden" value="1" name="acquireType" class="form-control required">
							<input type="hidden" value="AA" name="TransactionType" class="form-control required">
							<input type="hidden" value="3wse8326!@" name="supersecret" class="form-control required">
							<button class="btn btn-primary btn-lg btn-block chargecard" type="submit"><i class="fa fa-check"></i> Charge/Authorize Card</button>
						</div>
					</div>
				</div>
			</form>
			<?php } ?>
			</div>
		</div>
	</div>
</div>

</div>
<input type="checkbox" name="checkbox" id="checkbox">
<?php require_once( 'footerjs.php'); ?>
<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<!-- Chosen -->
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
<script>
    $(document).ready(function() {
		
		//shipping as billing
		$('#check-address').on("change", function(){
			if ($('#check-address').is(":checked")){
				$('#shipping_first_name').val($('#first_name').val());
				$('#shipping_last_name').val($('#last_name').val());
				$('#shipping_address1').val($('#address1').val());
				$('#shipping_address2').val($('#address2').val());
				$('#shipping_city').val($('#city').val());
				$('#shipping_postal_code').val($('#postal_code').val());
				$('#shipping_email').val($('#email').val());
				var state = $('#us_state option:selected').val();
				$('#shipping_us_state option[value=' + state + ']').attr('selected','selected');
				var country = $('#country option:selected').val();
				$('#shipping_country option[value=' + country + ']').attr('selected','selected');
			} else { 
				//Clear on uncheck
				$('#shipping_first_name').val();
				$('#shipping_last_name').val();
				$('#shipping_address1').val();
				$('#shipping_address2').val();
				$('#shipping_city').val();
				$('#shipping_postal_code').val();
				$('#shipping_email').val();
				$('#shipping_us_state option[value=Nothing]').attr('selected','selected');
				$('#shipping_country option[value=Nothing]').attr('selected','selected');
			};

		});
		$("#vtform").validate({
			submitHandler: function(form) {
				$(".chargecardresult").html("Sending...please wait");
				
				var postData = $("#vtform").serializeArray();
				$.ajax({
					method: "POST",
					url: "../api/smartro.php",
					data: postData
				})
				.done(function( msg ) {
					var result;
					if(msg.success == 0){
						result = '<div class="alert alert-danger">'+msg.ResponseMessage+'</div>';
					} else {
						result = '<div class="alert alert-success">'+msg.ResponseMessage+'</div>';
					}
					$(".chargecardresult").html(result);
				});
				
			}
		});

		//change state based on country
		$('#country').on('change', function() {
			var states;
			switch(this.value) {
				case 'US':
					states = '<label>State <span class="text-danger">**</span></label><select class="form-control required" name="us_state" id="us_state" aria-required="true"><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select>';
					break;
				case 'CA':
					states = '<label>State *</label><select class="form-control required" name="us_state" id="us_state" aria-required="true"><option value="AB">Alberta</option><option value="BC">British Columbia</option><option value="MB">Manitoba</option><option value="NB">New Brunswick</option><option value="NL">Newfoundland and Labrador</option><option value="NT">Northwest Territories</option><option value="NS">Nova Scotia</option><option value="NU">Nunavut</option><option value="ON">Ontario</option><option value="PE">Prince Edward Island</option><option value="QC">Quebec</option><option value="SK">Saskatchewan</option><option value="YT">Yukon</option></select>';
					break;
				default:
					states = '<label>Providence *</label><input type="text" class="form-control required" name="us_state" id="us_state" aria-required="true">';
					break;
			} 
		  $('#statebox').html(states);
		});
		$('#country_ship').on('change', function() {
			var states;
			switch(this.value) {
				case 'US':
					states = '<label>State <span class="text-danger">**</span></label><select class="form-control required" name="us_state" id="us_state" aria-required="true"><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select>';
					break;
				case 'CA':
					states = '<label>State *</label><select class="form-control required" name="us_state" id="us_state" aria-required="true"><option value="AB">Alberta</option><option value="BC">British Columbia</option><option value="MB">Manitoba</option><option value="NB">New Brunswick</option><option value="NL">Newfoundland and Labrador</option><option value="NT">Northwest Territories</option><option value="NS">Nova Scotia</option><option value="NU">Nunavut</option><option value="ON">Ontario</option><option value="PE">Prince Edward Island</option><option value="QC">Quebec</option><option value="SK">Saskatchewan</option><option value="YT">Yukon</option></select>';
					break;
				default:
					states = '<label>Providence *</label><input type="text" class="form-control required" name="us_state" id="us_state" aria-required="true">';
					break;
			} 
		  $('#statebox_ship').html(states);
		});
		
		$("#merchant_id").change(function () {
			if($(this).val()){
				$.ajax({
					method: "POST",
					url: "php/inc_admin_merchantprocessors.php",
					data: { m_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?> }
				})
				.done(function( msg ) {
					$("#processoridbox").html(msg);
					var config = {
					'.chosen-select'           : {},
					'.chosen-select-deselect'  : {allow_single_deselect:true},
					'.chosen-select-no-single' : {disable_search_threshold:10},
					'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
					'.chosen-select-width'     : {width:"95%"}
					}
					for (var selector in config) {
						$(selector).chosen(config[selector]);
					} 
					$("#processor_id").change(function () {
						var m_val = $("#merchant_id").val();
						if($(this).val()){
							$.ajax({
								method: "POST",
								url: "php/inc_admin_merchantgateway.php",
								data: { m_id: m_val, p_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?> }
							})
							.done(function( msg ) {
								$("#gatewaybox").html(msg);
								$("#gateway_id").change(function () {
									if($(this).val()){
										$.ajax({
											method: "POST",
											url: "php/inc_admin_mpg_fees.php",
											data: { m_id: $("#merchant_id").val(), p_id: $("#processor_id").val(), g_id: $(this).val() }
										})
										.done(function( msg ) {
											$("#settings").html(msg);
										});
									}
								});
								var config = {
								'.chosen-select'           : {},
								'.chosen-select-deselect'  : {allow_single_deselect:true},
								'.chosen-select-no-single' : {disable_search_threshold:10},
								'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
								'.chosen-select-width'     : {width:"95%"}
							}
							for (var selector in config) {
								$(selector).chosen(config[selector]);
							}
							
								});
						} 
					});
				});
			}
		});	

		$("#processor_id").change(function () {
						var m_val = $("#merchant_id").val();
						if($(this).val()){
							$.ajax({
								method: "POST",
								url: "php/inc_admin_merchantgateway.php",
								data: { m_id: m_val, p_id: $(this).val(), u_id: <?php echo $_SESSION['iid']; ?> }
							})
							.done(function( msg ) {
								$("#gatewaybox").html(msg);
								$("#gateway_id").change(function () {
									if($(this).val()){
										$.ajax({
											method: "POST",
											url: "php/inc_admin_mpg_fees.php",
											data: { m_id: $("#merchant_id").val(), p_id: $("#processor_id").val(), g_id: $(this).val() }
										})
										.done(function( msg ) {
											$("#settings").html(msg);
										});
									}
								});
								var config = {
								'.chosen-select'           : {},
								'.chosen-select-deselect'  : {allow_single_deselect:true},
								'.chosen-select-no-single' : {disable_search_threshold:10},
								'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
								'.chosen-select-width'     : {width:"95%"}
							}
							for (var selector in config) {
								$(selector).chosen(config[selector]);
							}
							
								});
						} 
					});
		
		var config = {
			'.chosen-select'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
		
	});	
</script>
<?php require_once( 'footer.php'); ?> 