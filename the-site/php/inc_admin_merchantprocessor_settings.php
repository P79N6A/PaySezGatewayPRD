<?php
require_once('database_config.php');
require_once('../api/encrypt.php');
$m_id = $_POST['m_id'];
$p_id = $_POST['p_id'];
$g_id = $_POST['g_id'];
$key = '25548680445484262110fbd9d2769a2b58ace60c2aeae971a129009881c2871d';
$apikey = mc_encrypt($m_id.','.$p_id.','.$g_id, $key);
$db->join("merchant_processors_mid m", "p.p_id = m.processor_id", "LEFT");
$db->where("m.merchant_id = ".$m_id." AND m.processor_id = ".$p_id." AND m.gateway_id = ".$g_id." ");
$mpg = $db->getOne("processors p");
$action = ($mpg)?"Update":"Assign";
$start_date = "";
$currency = "USD";
if($mpg) {
	$start_date = date('m/d/Y', strtotime($mpg["start_date"]));
	$currency = $mpg["currency"];
}
?>
<form id="assignprocessor" action="#" method="POST">
<div class="row">
	<div class="col-lg-8">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Settings</h5>
			</div>
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label>Currency</label> 
							<select name="currency" id="currency"  class="form-control required">
							   <option value="XUA">ADB Unit of Account (XUA)</option>
							   <option value="AFN">Afghani (AFN)</option>
							   <option value="DZD">Algerian Dinar (DZD)</option>
							   <option value="ARS">Argentine Peso (ARS)</option>
							   <option value="AMD">Armenian Dram (AMD)</option>
							   <option value="AWG">Aruban Florin (AWG)</option>
							   <option value="AUD">Australian Dollar (AUD)</option>
							   <option value="AZN">Azerbaijanian Manat (AZN)</option>
							   <option value="BSD">Bahamian Dollar (BSD)</option>
							   <option value="BHD">Bahraini Dinar (BHD)</option>
							   <option value="THB">Baht (THB)</option>
							   <option value="PAB">Balboa (PAB)</option>
							   <option value="BBD">Barbados Dollar (BBD)</option>
							   <option value="BYR">Belarussian Ruble (BYR)</option>
							   <option value="BZD">Belize Dollar (BZD)</option>
							   <option value="BMD">Bermudian Dollar (BMD)</option>
							   <option value="VEF">Bolivar (VEF)</option>
							   <option value="BOB">Boliviano (BOB)</option>
							   <option value="XBA">Bond Markets Unit European Composite Unit (EURCO) (XBA)</option>
							   <option value="XBB">Bond Markets Unit European Monetary Unit (E.M.U.-6) (XBB)</option>
							   <option value="XBD">Bond Markets Unit European Unit of Account 17 (E.U.A.-17) (XBD)</option>
							   <option value="XBC">Bond Markets Unit European Unit of Account 9 (E.U.A.-9) (XBC)</option>
							   <option value="BRL">Brazilian Real (BRL)</option>
							   <option value="BND">Brunei Dollar (BND)</option>
							   <option value="BGN">Bulgarian Lev (BGN)</option>
							   <option value="BIF">Burundi Franc (BIF)</option>
							   <option value="XOF">CFA Franc BCEAO (XOF)</option>
							   <option value="XAF">CFA Franc BEAC (XAF)</option>
							   <option value="XPF">CFP Franc (XPF)</option>
							   <option value="CAD">Canadian Dollar (CAD)</option>
							   <option value="CVE">Cape Verde Escudo (CVE)</option>
							   <option value="KYD">Cayman Islands Dollar (KYD)</option>
							   <option value="CLP">Chilean Peso (CLP)</option>
							   <option value="COP">Colombian Peso (COP)</option>
							   <option value="KMF">Comoro Franc (KMF)</option>
							   <option value="CDF">Congolese Franc (CDF)</option>
							   <option value="BAM">Convertible Mark (BAM)</option>
							   <option value="NIO">Cordoba Oro (NIO)</option>
							   <option value="CRC">Costa Rican Colon (CRC)</option>
							   <option value="HRK">Croatian Kuna (HRK)</option>
							   <option value="CUP">Cuban Peso (CUP)</option>
							   <option value="CZK">Czech Koruna (CZK)</option>
							   <option value="GMD">Dalasi (GMD)</option>
							   <option value="DKK">Danish Krone (DKK)</option>
							   <option value="MKD">Denar (MKD)</option>
							   <option value="DJF">Djibouti Franc (DJF)</option>
							   <option value="STD">Dobra (STD)</option>
							   <option value="DOP">Dominican Peso (DOP)</option>
							   <option value="VND">Dong (VND)</option>
							   <option value="XCD">East Caribbean Dollar (XCD)</option>
							   <option value="EGP">Egyptian Pound (EGP)</option>
							   <option value="SVC">El Salvador Colon (SVC)</option>
							   <option value="ETB">Ethiopian Birr (ETB)</option>
							   <option value="EUR">Euro (EUR)</option>
							   <option value="FKP">Falkland Islands Pound (FKP)</option>
							   <option value="FJD">Fiji Dollar (FJD)</option>
							   <option value="HUF">Forint (HUF)</option>
							   <option value="GHS">Ghana Cedi (GHS)</option>
							   <option value="GIP">Gibraltar Pound (GIP)</option>
							   <option value="XAU">Gold (XAU)</option>
							   <option value="HTG">Gourde (HTG)</option>
							   <option value="PYG">Guarani (PYG)</option>
							   <option value="GNF">Guinea Franc (GNF)</option>
							   <option value="GYD">Guyana Dollar (GYD)</option>
							   <option value="HKD">Hong Kong Dollar (HKD)</option>
							   <option value="UAH">Hryvnia (UAH)</option>
							   <option value="ISK">Iceland Krona (ISK)</option>
							   <option value="INR">Indian Rupee (INR)</option>
							   <option value="IRR">Iranian Rial (IRR)</option>
							   <option value="IQD">Iraqi Dinar (IQD)</option>
							   <option value="JMD">Jamaican Dollar (JMD)</option>
							   <option value="JOD">Jordanian Dinar (JOD)</option>
							   <option value="KES">Kenyan Shilling (KES)</option>
							   <option value="PGK">Kina (PGK)</option>
							   <option value="LAK">Kip (LAK)</option>
							   <option value="KWD">Kuwaiti Dinar (KWD)</option>
							   <option value="MWK">Kwacha (MWK)</option>
							   <option value="AOA">Kwanza (AOA)</option>
							   <option value="MMK">Kyat (MMK)</option>
							   <option value="GEL">Lari (GEL)</option>
							   <option value="LVL">Latvian Lats (LVL)</option>
							   <option value="LBP">Lebanese Pound (LBP)</option>
							   <option value="ALL">Lek (ALL)</option>
							   <option value="HNL">Lempira (HNL)</option>
							   <option value="SLL">Leone (SLL)</option>
							   <option value="LRD">Liberian Dollar (LRD)</option>
							   <option value="LYD">Libyan Dinar (LYD)</option>
							   <option value="SZL">Lilangeni (SZL)</option>
							   <option value="LTL">Lithuanian Litas (LTL)</option>
							   <option value="LSL">Loti (LSL)</option>
							   <option value="MGA">Malagasy Ariary (MGA)</option>
							   <option value="MYR">Malaysian Ringgit (MYR)</option>
							   <option value="MUR">Mauritius Rupee (MUR)</option>
							   <option value="MXN">Mexican Peso (MXN)</option>
							   <option value="MXV">Mexican Unidad de Inversion (UDI) (MXV)</option>
							   <option value="MDL">Moldovan Leu (MDL)</option>
							   <option value="MAD">Moroccan Dirham (MAD)</option>
							   <option value="MZN">Mozambique Metical (MZN)</option>
							   <option value="BOV">Mvdol (BOV)</option>
							   <option value="NGN">Naira (NGN)</option>
							   <option value="ERN">Nakfa (ERN)</option>
							   <option value="NAD">Namibia Dollar (NAD)</option>
							   <option value="NPR">Nepalese Rupee (NPR)</option>
							   <option value="ANG">Netherlands Antillean Guilder (ANG)</option>
							   <option value="ILS">New Israeli Sheqel (ILS)</option>
							   <option value="RON">New Romanian Leu (RON)</option>
							   <option value="TWD">New Taiwan Dollar (TWD)</option>
							   <option value="NZD">New Zealand Dollar (NZD)</option>
							   <option value="BTN">Ngultrum (BTN)</option>
							   <option value="KPW">North Korean Won (KPW)</option>
							   <option value="NOK">Norwegian Krone (NOK)</option>
							   <option value="PEN">Nuevo Sol (PEN)</option>
							   <option value="MRO">Ouguiya (MRO)</option>
							   <option value="TOP">Pa'anga (TOP)</option>
							   <option value="PKR">Pakistan Rupee (PKR)</option>
							   <option value="XPD">Palladium (XPD)</option>
							   <option value="MOP">Pataca (MOP)</option>
							   <option value="CUC">Peso Convertible (CUC)</option>
							   <option value="UYU">Peso Uruguayo (UYU)</option>
							   <option value="PHP">Philippine Peso (PHP)</option>
							   <option value="XPT">Platinum (XPT)</option>
							   <option value="GBP">Pound Sterling (GBP)</option>
							   <option value="BWP">Pula (BWP)</option>
							   <option value="QAR">Qatari Rial (QAR)</option>
							   <option value="GTQ">Quetzal (GTQ)</option>
							   <option value="ZAR">Rand (ZAR)</option>
							   <option value="OMR">Rial Omani (OMR)</option>
							   <option value="KHR">Riel (KHR)</option>
							   <option value="MVR">Rufiyaa (MVR)</option>
							   <option value="IDR">Rupiah (IDR)</option>
							   <option value="RUB">Russian Ruble (RUB)</option>
							   <option value="RWF">Rwanda Franc (RWF)</option>
							   <option value="XDR">SDR (Special Drawing Right) (XDR)</option>
							   <option value="SHP">Saint Helena Pound (SHP)</option>
							   <option value="SAR">Saudi Riyal (SAR)</option>
							   <option value="RSD">Serbian Dinar (RSD)</option>
							   <option value="SCR">Seychelles Rupee (SCR)</option>
							   <option value="XAG">Silver (XAG)</option>
							   <option value="SGD">Singapore Dollar (SGD)</option>
							   <option value="SBD">Solomon Islands Dollar (SBD)</option>
							   <option value="KGS">Som (KGS)</option>
							   <option value="SOS">Somali Shilling (SOS)</option>
							   <option value="TJS">Somoni (TJS)</option>
							   <option value="SSP">South Sudanese Pound (SSP)</option>
							   <option value="LKR">Sri Lanka Rupee (LKR)</option>
							   <option value="XSU">Sucre (XSU)</option>
							   <option value="SDG">Sudanese Pound (SDG)</option>
							   <option value="SRD">Surinam Dollar (SRD)</option>
							   <option value="SEK">Swedish Krona (SEK)</option>
							   <option value="CHF">Swiss Franc (CHF)</option>
							   <option value="SYP">Syrian Pound (SYP)</option>
							   <option value="BDT">Taka (BDT)</option>
							   <option value="WST">Tala (WST)</option>
							   <option value="TZS">Tanzanian Shilling (TZS)</option>
							   <option value="KZT">Tenge (KZT)</option>
							   <option value="TTD">Trinidad and Tobago Dollar (TTD)</option>
							   <option value="MNT">Tugrik (MNT)</option>
							   <option value="TND">Tunisian Dinar (TND)</option>
							   <option value="TRY">Turkish Lira (TRY)</option>
							   <option value="TMT">Turkmenistan New Manat (TMT)</option>
							   <option value="AED">UAE Dirham (AED)</option>
							   <option value="USD" selected="selected">US Dollar (USD)</option>
							   <option value="USN">US Dollar (Next day) (USN)</option>
							   <option value="USS">US Dollar (Same day) (USS)</option>
							   <option value="UGX">Uganda Shilling (UGX)</option>
							   <option value="COU">Unidad de Valor Real (COU)</option>
							   <option value="CLF">Unidades de fomento (CLF)</option>
							   <option value="UYI">Uruguay Peso en Unidades Indexadas (URUIURUI) (UYI)</option>
							   <option value="UZS">Uzbekistan Sum (UZS)</option>
							   <option value="VUV">Vatu (VUV)</option>
							   <option value="CHE">WIR Euro (CHE)</option>
							   <option value="CHW">WIR Franc (CHW)</option>
							   <option value="KRW">Won (KRW)</option>
							   <option value="YER">Yemeni Rial (YER)</option>
							   <option value="JPY">Yen (JPY)</option>
							   <option value="CNY">Yuan Renminbi (CNY)</option>
							   <option value="ZMW">Zambian Kwacha (ZMW)</option>
							   <option value="ZWL">Zimbabwe Dollar (ZWL)</option>
							   <option value="PLN">Zloty (PLN)</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>MID</label> 
							<input type="text" class="form-control" name="mid" id="mid" value="<?php echo $mpg["mid"]; ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="checkbox i-checks"><br /><label> <input type="checkbox" value="" name="is_for_moto" id="is_for_moto"<?php echo ($mpg["is_for_moto"] == 1)?"checked='checked'":""; ?>> <i></i> MID is for MOTO transactions </label></div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label>Routing</label> 
							<input type="text" class="form-control required" name="routing" id="routing" value="<?php echo $mpg["routing"]; ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Rebill Routing</label> 
							<input type="text" class="form-control required" name="rebill_routing" id="rebill_routing" value="<?php echo $mpg["rebill_routing"]; ?>">
						</div>
					</div>
					
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row ">
					<div class="col-lg-4">
						<div id="start_date_box"  class="form-group">
							<label>Start Date</label>
							<div class="input-group date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="" class="form-control required" name="start_date"  id="start_date"  value="<?php echo $start_date; ?>">
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Notes</label> 
							<textarea class="form-control" name="notes" id="notes"> <?php echo $mpg["notes"]; ?></textarea>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Descriptor</label> 
							<textarea class="form-control" name="descriptor" id="descriptor"> <?php echo $mpg["descriptor"]; ?></textarea>
						</div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-lg-12">
						<div class="checkbox i-checks"><br /><label> <input type="checkbox" value="" name="is_active" id="is_active" <?php echo ($mpg["is_active"] == 1)?"checked='checked'":""; ?>> <i></i> Active </label></div>
						<div class="checkbox i-checks"><br /><label> <input type="checkbox" value="" name="download_from_platform" id="download_from_platform" <?php echo ($mpg["is_for_moto"] == 1)?"checked='checked'":""; ?>> <i></i> Download From Platform </label></div>
						<div class="checkbox i-checks"><br /><label> <input type="checkbox" value="" name="validate_transaction_data" id="validate_transaction_data" <?php echo ($mpg["is_for_moto"] == 1)?"checked='checked'":""; ?>> <i></i> Validate Transaction Data </label></div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label>API URL - Production</label> 
							<input type="text" class="form-control" name="url_prod" id="url_prod" value="<?php echo $mpg["api_url_production"]; ?>">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>API URL - Testing</label> 
							<input type="text" class="form-control" name="url_test" id="url_test" value="<?php echo $mpg["api_url_testing"]; ?>">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>API KEY</label> 
							<input type="text" class="form-control" name="api_key" id="api_key" readonly value="<?php echo $apikey; ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Transaction Processing Credentials</h5>
			</div>
			<div class="ibox-content">
				<div class="form-group">
					<input type="text" name="username"  id="username" placeholder="Username" class="form-control required" value="<?php echo $mpg["username"]; ?>">
				</div>
				<div class="form-group">
					<input type="text" name="password" id="password" placeholder="Password" class="form-control required" value="<?php echo $mpg["password"]; ?>">
			</div>
			</div>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Settle Data Query Credentials</h5>
			</div>
			<div class="ibox-content">
				<div class="form-group">
					<input type="text" name="sdquery_un" id="sdquery_un" placeholder="Username" class="form-control required" value="<?php echo $mpg["sdquery_un"]; ?>">
				</div>
				<div class="form-group">
					<input type="text" name="sdquery_pwd" id="sdquery_pwd" placeholder="Password" class="form-control required" value="<?php echo $mpg["sdquery_pwd"]; ?>">
			</div>
			</div>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Transaction Permissions</h5>
			</div>
			<div class="ibox-content">
				<div class="checkbox i-checks">
					<label> 
					<input type="checkbox" value="" name="auth" id="auth" <?php echo ($mpg["auth"] == 1)?"checked='checked'":""; ?>> 
					<i></i> Auth </label>
				</div>
				<div class="checkbox i-checks">
					<label> 
					<input type="checkbox" value="" name="capture" id="capture" <?php echo ($mpg["capture"] == 1)?"checked='checked'":""; ?>> 
					<i></i> Capture </label>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="row ">
					<div class="col-lg-6">
					<br />
						<div class="checkbox i-checks">
							<label> 
							<input type="checkbox" value="" name="auto_capture" id="auto_capture" <?php echo ($mpg["auto_capture"] == 1)?"checked='checked'":""; ?>> 
							<i></i>Automated Capture </label>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
					<label>Time to automated capture</label>
					<input type="number" name="delay_hours" id="delay_hours" placeholder="Hours" class="form-control" value="<?php echo $mpg["delay_hours"]; ?>">
				</div>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="checkbox i-checks">
					<label> 
					<input type="checkbox" value="" name="sale" id="sale" <?php echo ($mpg["sale"] == 1)?"checked='checked'":""; ?>> 
					<i></i> Sale </label>
				</div>
				<div class="checkbox i-checks">
					<label> 
					<input type="checkbox" value="" name="refund" id="refund" <?php echo ($mpg["refund"] == 1)?"checked='checked'":""; ?>> 
					<i></i> Refund </label>
				</div>
				<div class="checkbox i-checks">
					<label> 
					<input type="checkbox" value="" name="void" id="void" <?php echo ($mpg["void"] == 1)?"checked='checked'":""; ?>> 
					<i></i> Void </label>
				</div>
			</div>
		</div>
		<input type='hidden' name='merchant_id' value='<?php echo $m_id; ?>' />
		<input type='hidden' name='processor_id' value='<?php echo $p_id; ?>' />
		<input type='hidden' name='gateway_id' value='<?php echo $g_id; ?>' />		
	</div>
</div>
</form>
<div class="row">
	<div class="col-lg-8"></div>
	<div class="col-lg-4">
		<div id="result"></div>
		<button class="btn btn-w-m btn-block btn-primary assign"><?php echo $action; ?></button>
	</div>
</div>

<script src="../js/jquery-2.1.1.js"></script>
<!-- Data picker -->
<script src="../js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Jquery Validate -->
<script src="../js/plugins/validate/jquery.validate.min.js"></script>
<!-- iCheck -->
<script src="../js/plugins/iCheck/icheck.min.js"></script>

<script>
	$(document).ready(function(){
		 $('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
			
		$('#currency option[value=<?php echo $currency; ?>]').attr('selected','selected');
		$('#start_date_box .input-group.date').datepicker({
											todayBtn: "linked",
											keyboardNavigation: false,
											forceParse: false,
											calendarWeeks: true,
											autoclose: true
										});
		$(".assign").click(function () {
			$("#assignprocessor").validate();
			var postData = $("#assignprocessor").serializeArray();
			$.ajax({
				method: "POST",
				url: "php/inc_admin_assign_merchantprocessor.php",
				data:  postData
			})
			.done(function( msg ) {
				$("#result").html(msg);
				$(".assign").html("Update");
			});
		});
		
	});
</script>