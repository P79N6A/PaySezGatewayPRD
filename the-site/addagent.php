<?php require_once( 'header.php');

require_once('php/inc_addagent.php');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Add Agent</h2>
		<p>Please enter the new agent's information in the fields provided below.</p>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox-content">
					<h2 id='result'><?php echo (!empty($result)) ? $result : ''; ?></h2>
					<?php if(!isset($result)){ ?>
					<form id="form" action="#" method="POST" class="wizard-big">
						<h1>Step 1</h1>
						<fieldset>
							<h2>Agent Information</h2>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Business Name *</label>
										<input id="agentname" name="agentname" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Country</label>
										<select name="country" id="country" class="form-control required">
											<option value="US">United States of America</option>
											<option value="AF">Afghanistan</option>
											<option value="AL">Albania</option>
											<option value="DZ">Algeria</option>
											<option value="AS">American Samoa</option>
											<option value="AD">Andorra</option>
											<option value="AO">Angola</option>
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
									 <div class="form-group" id="statebox">
										<label>State</label>
										<select id="us_state" name="us_state" class="form-control required">
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
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Address *</label>
										<input id="address1" name="address1" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Address (Cont)</label>
										<input id="address2" name="address2" type="text" class="form-control">
									</div>
									<div class="form-group">
										<label>City *</label>
										<input id="city" name="city" type="text" class="form-control required" aria-required="true">
									</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
											<label>Zip/Postal Code *</label>
											<input id="zippostalcode" name="zippostalcode" type="text" class="form-control required" aria-required="true">
										</div>
										<div class="form-group">
											<label>Website Address</label>
											<input id="website" name="website" type="text" class="form-control" aria-required="true">
										</div>
										<div class="form-group">
											<label>Time Zone</label>
											<select id="tz_name" name="tz_name" class="form-control required">
												<option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
												<option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
												<option value="-10.0">(GMT -10:00) Hawaii</option>
												<option value="-9.0">(GMT -9:00) Alaska</option>
												<option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
												<option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
												<option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
												<option value="-5.0" selected>(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
												<option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
												<option value="-3.5">(GMT -3:30) Newfoundland</option>
												<option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
												<option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
												<option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
												<option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
												<option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
												<option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
												<option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
												<option value="3.5">(GMT +3:30) Tehran</option>
												<option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
												<option value="4.5">(GMT +4:30) Kabul</option>
												<option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
												<option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
												<option value="5.75">(GMT +5:45) Kathmandu</option>
												<option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
												<option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
												<option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
												<option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
												<option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
												<option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
												<option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
												<option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
											</select>
										</div>
									</div>
							</div>
						</fieldset>
						<h1>Step 2</h1>
						<fieldset>
							<h2>Agent Support Contact Information</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Support Person First name *</label>
										<input id="cs_first_name" name="cs_first_name" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Support Person Last Name *</label>
										<input id="cs_last_name" name="cs_last_name" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Support Person Phone Number *</label>
										<input id="csphone" name="csphone" type="text" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Support Person Fax </label>
										<input id="cs_fax" name="cs_fax" type="text" class="form-control">
									</div>
									<div class="form-group">
										<label>Support Person Email *</label>
										<input id="csemail" name="csemail" type="text" class="form-control required email">
									</div>
								</div>
							</div>
						</fieldset>
						<h1>Step 3</h1>
					  <fieldset>
							<h2>Commission Payment Information</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Account Number *</label>
										<input id="account" name="account" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>ABA/Swift Routing Number *</label>
										<input id="routing" name="routing" type="text" class="form-control required">
									</div>
									<div class="form-group">
										The Legal Company Name, Business Type and Tax ID must match the name on the bank account information above.
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Legal Name(Name on Tax Return) *</label>
										<input id="legal_name" name="legal_name" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Business Type *</label>
										<input id="business_type" name="business_type" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Tax ID(EIN or SSN) *</label>
										<input id="tax_id" name="tax_id" type="text" class="form-control required">
									</div>
								</div>
							</div>
						</fieldset>
						<h1>Finish</h1>
						<fieldset>
							<h2>Account Information</h2>
							<input id="q" name="q" type="hidden" value="true">
							<p>Enter a username which the agent will use to log into their control panel. 
							The username must be 4 to 32 characters long and contain only letters and/or numbers. The password will be emailed to the agent directly.
							</p>
							<div class="col-lg-6">
							<div class="form-group">
								 <label>Username *</label>
								 <input id="username" name="username" type="text" class="form-control required username">
							</div>
							<div class="form-group">
								 <label>Account Email *</label>
								 <input id="email_address" name="email_address" type="text" class="form-control required">
							</div>
							</div>
						</fieldset>
					</form>
					* required field
					</div>
					</div>
					<?php } ?>
				</div>
</div>
   
<!-- Mainly scripts -->

<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<!-- Steps -->
<script src="js/plugins/staps/jquery.steps.min.js"></script>
<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
		/*$.validator.addMethod("username", function() {
			$.ajax({
					method: "POST",
					url: "php/inc_checkusername.php",
					data: { username: $("#username").val() }
				})
				.done(function( msg ) {
					return  msg == "not-exist";	
				});
	}, 'Username is already in use!');
	*/
	

		//change state based on country
		$('select').on('change', function() {
		  alert( this.value );
		});
			
        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function(event, currentIndex, newIndex) {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex) {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18) {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex) {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18) {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3) {
                    $(this).steps("previous");
                }
            },
            onFinishing: function(event, currentIndex) {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
				//change enabled to disabled for live...love greg
                form.validate().settings.ignore = ":disabled";
				
                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                var form = $(this);
				//addAgent('true');
                // Submit form input
                form.submit();
            }
        }).validate({
            errorPlacement: function(error, element) {
                element.before(error);
            },
            rules: {
                confirm: {
                  //  equalTo: "#password"
                }
            }
        });
    });
</script>
<?php require_once( 'footerjs.php'); ?>
<script>
    $(document).ready(function() {
		//change state based on country
		$('#country').on('change', function() {
			var states;
			switch(this.value) {
				case 'US':
					states = '<label>State *</label><select class="form-control required" name="us_state" id="us_state" aria-required="true"><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select>';
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
	});	
</script>
<?php require_once( 'footer.php'); ?>