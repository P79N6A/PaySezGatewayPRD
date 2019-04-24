<?php require_once( 'header.php'); ?>
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-lg-22">
        <div class="col-lg-22"></div>
    </div>
    <tbody>
        <tr>
            <td>
                <div class="panel panel-primary">
                    <div class="panel-heading">Processor Information</div>
                  <div class="panel-body">

                        <br>
                    <table class="mainarea" id="form_ConfigureProcessor" border="0" cellspacing="0" cellpadding="3">
<input type="hidden" name="processor" value="transpro" id="processor"><input type="hidden" name="mandatory" value="" id="mandatory"><input type="hidden" name="merchant" value="641" id="merchant"><input type="hidden" name="processorid" value="790329" id="processorid"><tbody><tr id="ConfigureProcessor_5_row">
  <td colspan="3">Transact Pro requires the following fields to identify themerchant.  The merchant account provider will have this
    information available for you.</td></tr>
<tr id="id1_row">
	
                    <td id="id1_desc_cell" class="fieldlabel" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="id1_desc_table" style="background: transparent;">
                                    <tbody><tr>
                                        <td></td>
                                        
                                        <td>
                                            <label for="id1" id="label_id1">Merchant GUID</label></td>
                                    </tr>
                                </tbody></table>
                            

                    </td>
	
                    <td id="id1_input_cell">
                        <input type="text" size="25" id="id1" name="id1" value="" onchange="validate('ConfigureProcessor', this);" style=""><nobr>&nbsp;XXXX-XXXX-XXXX-XXXX</nobr></td>
                    <td align="right">    </td>

                </tr>
<tr id="id1_msg" style="display: none;" bgcolor="#FFFBB8"><td colspan="3" style="border-bottom: 1px dashed gray;">The 'Merchant GUID' field contains an error or is empty.</td>
                </tr>
<tr id="id2_row">
	
                    <td id="id2_desc_cell" class="fieldlabel" valign="MIDDLE" align="LEFT">
                                <table cellspacing="0" id="id2_desc_table" style="background: transparent;">
                                    <tbody><tr>
                                        <td></td>
                                        
                                        <td>
                                            <label for="id2" id="label_id2">Processing Password</label></td>
                                    </tr>
                                </tbody></table>
                            

                    </td>
	
                    <td id="id2_input_cell">
                        <input type="text" size="25" id="id2" name="id2" value="" onchange="validate('ConfigureProcessor', this);" style=""><nobr>&nbsp;&nbsp;</nobr></td>
                    <td align="right">    </td>

                </tr>
<tr id="id2_msg" style="display: none;" bgcolor="#FFFBB8"><td colspan="3" style="border-bottom: 1px dashed gray;">The 'Processing Password' field contains an error or is empty.</td>
                </tr>
<tr id="id3_row">
	
                    <td id="id3_desc_cell" class="fieldlabel" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="id3_desc_table" style="background: transparent;">
                                    <tbody><tr>
                                        <td></td>
                                        
                                        <td>
                                            <label for="id3" id="label_id3">Routing String</label></td>
                                    </tr>
                                </tbody></table>
                            

                    </td>
	
                    <td id="id3_input_cell">
                        <input type="text" size="25" id="id3" name="id3" value="" onchange="validate('ConfigureProcessor', this);" style=""><nobr>&nbsp;&nbsp;</nobr></td>
                    <td align="right">    </td>

                </tr>
<tr id="id3_msg" style="display: none;" bgcolor="#FFFBB8"><td colspan="3" style="border-bottom: 1px dashed gray;">The 'Routing String' field contains an error or is empty.</td>
                </tr>
<tr id="id4_row">
	
                    <td id="id4_desc_cell" class="fieldlabel" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="id4_desc_table" style="background: transparent;">
                                    <tbody><tr>
                                        <td></td>
                                        
                                        <td>
                                            <label for="id4" id="label_id4">Recurring Routing String</label></td>
                                    </tr>
                                </tbody></table>
                            

                    </td>
	
                    <td id="id4_input_cell">
                        <input type="text" size="25" id="id4" name="id4" value="" onchange="validate('ConfigureProcessor', this);" style=""><nobr>&nbsp;&nbsp;</nobr></td>
                    <td align="right" id="id4_box_cell"><input type="hidden" id="id4_box_val" value="">    </td>

                </tr>
<tr style="display: none;" bgcolor="#FFFBB8">
  <td colspan="3" style="border-bottom: 1px dashed gray;"></td>
</tr>
<tr style="display: none;" bgcolor="#FFFBB8">
  <td colspan="3" style="border-bottom: 1px dashed gray;">The 'Recurring Routing String' field contains an error or is empty.</td>
</tr>
<tr id="id4_msg" style="display: none;" bgcolor="#FFFfff">
  <td colspan="3" align="right" bgcolor="#FFFfff" style="border-bottom: 1px dashed gray;"></td>
                </tr>
<input type="hidden" name="current_mcc" value="7399" id="current_mcc">
</table>
                    <p><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> Edit</button></p>
                  </div>
    </div>
    
    
    
    
    
  <div class="col-lg-22">
        <div class="col-lg-22"></div>
    </div>
    <tbody>
        <tr>
            <td>
                <div class="panel panel-primary">
                    <div class="panel-heading">Currencies
                    
                    </div>
                  <div class="panel-body">

                        <br>
                        <table class="mainarea" id="form_ConfigureProcessor2" border="0" cellspacing="0" cellpadding="3">
                          <input type="hidden" name="processor2" value="transpro" id="processor2">
                          <input type="hidden" name="mandatory2" value="" id="mandatory2">
                          <input type="hidden" name="merchant2" value="641" id="merchant2">
                          <input type="hidden" name="processorid2" value="790329" id="processorid2">
                          <tbody>
                         
                            <tr id="single_currency_row">
                              <td width="709" colspan="2" align="LEFT"> Transact Pro can only be configured for a single currency that must be<br>
                                configured with the processor. </td>
                            </tr>
                            <tr id="currency_row">
                              <td align="LEFT" colspan="2"><nobr>
                                <table width="99%" border="0">
                                  <tr>
                                    <td width="57%">&nbsp;</td>
                                    <td width="12%">&nbsp;</td>
                                    <td width="31%">&nbsp;</td>

                                  </tr>
                                  <tr>
                                    <td>Available Currencies
                                      <br>
                                      <select name="availableCurrency2" size="7" id="availableCurrency2">
                                      <option class="currencyLeft" id="currency_AED2" value="AED">AED - United Arab Emirates Dirham</option>
                                      <option class="currencyLeft" id="currency_AFA2" value="AFA">AFA - </option>
                                      <option class="currencyLeft" id="currency_AMD2" value="AMD">AMD - Armenian Dram</option>
                                      <option class="currencyLeft" id="currency_ANG2" value="ANG">ANG - Netherlands Antillian Guilder</option>
                                      <option class="currencyLeft" id="currency_AOA2" value="AOA">AOA - Kwanza</option>
                                      <option class="currencyLeft" id="currency_ARS2" value="ARS">ARS - Argentine Peso</option>
                                      <option class="currencyLeft" id="currency_AUD2" value="AUD">AUD - Australian Dollar</option>
                                      <option class="currencyLeft" id="currency_AWG2" value="AWG">AWG - Aruban Guilder</option>
                                      <option class="currencyLeft" id="currency_AZM2" value="AZM">AZM - </option>
                                      <option class="currencyLeft" id="currency_BAM2" value="BAM">BAM - Convertible Marks</option>
                                      <option class="currencyLeft" id="currency_BBD2" value="BBD">BBD - Barbados Dollar</option>
                                      <option class="currencyLeft" id="currency_BDT2" value="BDT">BDT - Bangladeshi Taka</option>
                                      <option class="currencyLeft" id="currency_BGN2" value="BGN">BGN - Bulgarian Lev</option>
                                      <option class="currencyLeft" id="currency_BHD2" value="BHD">BHD - Bahraini Dinar</option>
                                      <option class="currencyLeft" id="currency_BIF2" value="BIF">BIF - Burundian Franc</option>
                                      <option class="currencyLeft" id="currency_BMD2" value="BMD">BMD - Bermudian Dollar</option>
                                      <option class="currencyLeft" id="currency_BND2" value="BND">BND - Brunei Dollar</option>
                                      <option class="currencyLeft" id="currency_BOB2" value="BOB">BOB - Boliviano</option>
                                      <option class="currencyLeft" id="currency_BRL2" value="BRL">BRL - Brazilian Real</option>
                                      <option class="currencyLeft" id="currency_BSD2" value="BSD">BSD - Bahamian Dollar</option>
                                      <option class="currencyLeft" id="currency_BTN2" value="BTN">BTN - Ngultrum</option>
                                      <option class="currencyLeft" id="currency_BWP2" value="BWP">BWP - Pula</option>
                                      <option class="currencyLeft" id="currency_BYR2" value="BYR">BYR - Belarussian Ruble</option>
                                      <option class="currencyLeft" id="currency_BZD2" value="BZD">BZD - Belize Dollar</option>
                                      <option class="currencyLeft" id="currency_CAD2" value="CAD">CAD - Canadian Dollar</option>
                                      <option class="currencyLeft" id="currency_CDF2" value="CDF">CDF - Franc Congolais</option>
                                      <option class="currencyLeft" id="currency_CHF2" value="CHF">CHF - Swiss Franc</option>
                                      <option class="currencyLeft" id="currency_CLP2" value="CLP">CLP - Chilean Peso</option>
                                      <option class="currencyLeft" id="currency_CNY2" value="CNY">CNY - Yuan Renminbi</option>
                                      <option class="currencyLeft" id="currency_COP2" value="COP">COP - Colombian Peso</option>
                                      <option class="currencyLeft" id="currency_CRC2" value="CRC">CRC - Costa Rican Colon</option>
                                      <option class="currencyLeft" id="currency_CUP2" value="CUP">CUP - Cuban Peso</option>
                                      <option class="currencyLeft" id="currency_CVE2" value="CVE">CVE - Cape Verde Escudo</option>
                                      <option class="currencyLeft" id="currency_CYP2" value="CYP">CYP - Cyprus Pound</option>
                                      <option class="currencyLeft" id="currency_CZK2" value="CZK">CZK - Czech Koruna</option>
                                      <option class="currencyLeft" id="currency_DJF2" value="DJF">DJF - Djibouti Franc</option>
                                      <option class="currencyLeft" id="currency_DKK2" value="DKK">DKK - Danish Krone</option>
                                      <option class="currencyLeft" id="currency_DOP2" value="DOP">DOP - Dominican Peso</option>
                                      <option class="currencyLeft" id="currency_DZD2" value="DZD">DZD - Algerian Dinar</option>
                                      <option class="currencyLeft" id="currency_EEK2" value="EEK">EEK - Kroon</option>
                                      <option class="currencyLeft" id="currency_EGP2" value="EGP">EGP - Egyptian Pound</option>
                                      <option class="currencyLeft" id="currency_ERN2" value="ERN">ERN - Nakfa</option>
                                      <option class="currencyLeft" id="currency_ETB2" value="ETB">ETB - Ethiopian Birr</option>
                                      <option class="currencyLeft" id="currency_EUR2" value="EUR">EUR - Euro</option>
                                      <option class="currencyLeft" id="currency_FJD2" value="FJD">FJD - Fiji Dollar</option>
                                      <option class="currencyLeft" id="currency_FKP2" value="FKP">FKP - Falkland Islands Pound</option>
                                      <option class="currencyLeft" id="currency_GBP2" value="GBP">GBP - Pound Sterling</option>
                                      <option class="currencyLeft" id="currency_GEL2" value="GEL">GEL - Lari</option>
                                      <option class="currencyLeft" id="currency_GGP2" value="GGP">GGP - </option>
                                      <option class="currencyLeft" id="currency_GHC2" value="GHC">GHC - Cedi</option>
                                      <option class="currencyLeft" id="currency_GIP2" value="GIP">GIP - Gibraltar pound</option>
                                      <option class="currencyLeft" id="currency_GMD2" value="GMD">GMD - Dalasi</option>
                                      <option class="currencyLeft" id="currency_GNF2" value="GNF">GNF - Guinea Franc</option>
                                      <option class="currencyLeft" id="currency_GTQ2" value="GTQ">GTQ - Quetzal</option>
                                      <option class="currencyLeft" id="currency_GYD2" value="GYD">GYD - Guyana Dollar</option>
                                      <option class="currencyLeft" id="currency_HKD2" value="HKD">HKD - Hong Kong Dollar</option>
                                      <option class="currencyLeft" id="currency_HNL2" value="HNL">HNL - Lempira</option>
                                      <option class="currencyLeft" id="currency_HRK2" value="HRK">HRK - Croatian Kuna</option>
                                      <option class="currencyLeft" id="currency_HTG2" value="HTG">HTG - Haiti Gourde</option>
                                      <option class="currencyLeft" id="currency_HUF2" value="HUF">HUF - Forint</option>
                                      <option class="currencyLeft" id="currency_IDR2" value="IDR">IDR - Rupiah</option>
                                      <option class="currencyLeft" id="currency_ILS2" value="ILS">ILS - New Israeli Shekel</option>
                                      <option class="currencyLeft" id="currency_IMP2" value="IMP">IMP - </option>
                                      <option class="currencyLeft" id="currency_INR2" value="INR">INR - Indian Rupee</option>
                                      <option class="currencyLeft" id="currency_IQD2" value="IQD">IQD - Iraqi Dinar</option>
                                      <option class="currencyLeft" id="currency_IRR2" value="IRR">IRR - Iranian Rial</option>
                                      <option class="currencyLeft" id="currency_ISK2" value="ISK">ISK - Iceland Krona</option>
                                      <option class="currencyLeft" id="currency_JEP2" value="JEP">JEP - </option>
                                      <option class="currencyLeft" id="currency_JMD2" value="JMD">JMD - Jamaican Dollar</option>
                                      <option class="currencyLeft" id="currency_JOD2" value="JOD">JOD - Jordanian Dinar</option>
                                      <option class="currencyLeft" id="currency_JPY2" value="JPY">JPY - Japanese Yen</option>
                                      <option class="currencyLeft" id="currency_KES2" value="KES">KES - Kenyan Shilling</option>
                                      <option class="currencyLeft" id="currency_KGS2" value="KGS">KGS - Som</option>
                                      <option class="currencyLeft" id="currency_KHR2" value="KHR">KHR - Riel</option>
                                      <option class="currencyLeft" id="currency_KMF2" value="KMF">KMF - Comoro Franc</option>
                                      <option class="currencyLeft" id="currency_KPW2" value="KPW">KPW - North Korean Won</option>
                                      <option class="currencyLeft" id="currency_KRW2" value="KRW">KRW - South Korean Won</option>
                                      <option class="currencyLeft" id="currency_KWD2" value="KWD">KWD - Kuwaiti Dinar</option>
                                      <option class="currencyLeft" id="currency_KYD2" value="KYD">KYD - Cayman Islands Dollar</option>
                                      <option class="currencyLeft" id="currency_KZT2" value="KZT">KZT - Tenge</option>
                                      <option class="currencyLeft" id="currency_LAK2" value="LAK">LAK - Kip</option>
                                      <option class="currencyLeft" id="currency_LBP2" value="LBP">LBP - Lebanese Pound</option>
                                      <option class="currencyLeft" id="currency_LKR2" value="LKR">LKR - Sri Lanka Rupee</option>
                                      <option class="currencyLeft" id="currency_LRD2" value="LRD">LRD - Liberian Dollar</option>
                                      <option class="currencyLeft" id="currency_LSL2" value="LSL">LSL - Loti</option>
                                      <option class="currencyLeft" id="currency_LTL2" value="LTL">LTL - Lithuanian Litas</option>
                                      <option class="currencyLeft" id="currency_LVL2" value="LVL">LVL - Latvian Lats</option>
                                      <option class="currencyLeft" id="currency_LYD2" value="LYD">LYD - Libyan Dinar</option>
                                      <option class="currencyLeft" id="currency_MAD2" value="MAD">MAD - Moroccan Dirham</option>
                                      <option class="currencyLeft" id="currency_MDL2" value="MDL">MDL - Moldovan Leu</option>
                                      <option class="currencyLeft" id="currency_MGA2" value="MGA">MGA - Malagasy Ariary</option>
                                      <option class="currencyLeft" id="currency_MKD2" value="MKD">MKD - Denar</option>
                                      <option class="currencyLeft" id="currency_MMK2" value="MMK">MMK - Kyat</option>
                                      <option class="currencyLeft" id="currency_MNT2" value="MNT">MNT - Tugrik</option>
                                      <option class="currencyLeft" id="currency_MOP2" value="MOP">MOP - Pataca</option>
                                      <option class="currencyLeft" id="currency_MRO2" value="MRO">MRO - Ouguiya</option>
                                      <option class="currencyLeft" id="currency_MTL2" value="MTL">MTL - Maltese Lira</option>
                                      <option class="currencyLeft" id="currency_MUR2" value="MUR">MUR - Mauritius Rupee</option>
                                      <option class="currencyLeft" id="currency_MVR2" value="MVR">MVR - Rufiyaa</option>
                                      <option class="currencyLeft" id="currency_MWK2" value="MWK">MWK - Kwacha</option>
                                      <option class="currencyLeft" id="currency_MXN2" value="MXN">MXN - Mexican Peso</option>
                                      <option class="currencyLeft" id="currency_MYR2" value="MYR">MYR - Malaysian Ringgit</option>
                                      <option class="currencyLeft" id="currency_MZM2" value="MZM">MZM - </option>
                                      <option class="currencyLeft" id="currency_NAD2" value="NAD">NAD - Namibian Dollar</option>
                                      <option class="currencyLeft" id="currency_NGN2" value="NGN">NGN - Naira</option>
                                      <option class="currencyLeft" id="currency_NIO2" value="NIO">NIO - Cordoba Oro</option>
                                      <option class="currencyLeft" id="currency_NOK2" value="NOK">NOK - Norwegian Krone</option>
                                      <option class="currencyLeft" id="currency_NPR2" value="NPR">NPR - Nepalese Rupee</option>
                                      <option class="currencyLeft" id="currency_NZD2" value="NZD">NZD - New Zealand Dollar</option>
                                      <option class="currencyLeft" id="currency_OMR2" value="OMR">OMR - Rial Omani</option>
                                      <option class="currencyLeft" id="currency_PAB2" value="PAB">PAB - Balboa</option>
                                      <option class="currencyLeft" id="currency_PEN2" value="PEN">PEN - Nuevo Sol</option>
                                      <option class="currencyLeft" id="currency_PGK2" value="PGK">PGK - Kina</option>
                                      <option class="currencyLeft" id="currency_PHP2" value="PHP">PHP - Philippine Peso</option>
                                      <option class="currencyLeft" id="currency_PKR2" value="PKR">PKR - Pakistan Rupee</option>
                                      <option class="currencyLeft" id="currency_PLN2" value="PLN">PLN - Zloty</option>
                                      <option class="currencyLeft" id="currency_PTS2" value="PTS">PTS - </option>
                                      <option class="currencyLeft" id="currency_PYG2" value="PYG">PYG - Guarani</option>
                                      <option class="currencyLeft" id="currency_QAR2" value="QAR">QAR - Qatari Rial</option>
                                      <option class="currencyLeft" id="currency_RON2" value="RON">RON - Romanian New Leu</option>
                                      <option class="currencyLeft" id="currency_RUB2" value="RUB">RUB - Russian Ruble</option>
                                      <option class="currencyLeft" id="currency_RWF2" value="RWF">RWF - Rwanda Franc</option>
                                      <option class="currencyLeft" id="currency_SAR2" value="SAR">SAR - Saudi Riyal</option>
                                      <option class="currencyLeft" id="currency_SBD2" value="SBD">SBD - Solomon Islands Dollar</option>
                                      <option class="currencyLeft" id="currency_SCR2" value="SCR">SCR - Seychelles Rupee</option>
                                      <option class="currencyLeft" id="currency_SDD2" value="SDD">SDD - </option>
                                      <option class="currencyLeft" id="currency_SEK2" value="SEK">SEK - Swedish Krona</option>
                                      <option class="currencyLeft" id="currency_SGD2" value="SGD">SGD - Singapore Dollar</option>
                                      <option class="currencyLeft" id="currency_SHP2" value="SHP">SHP - Saint Helena Pound</option>
                                      <option class="currencyLeft" id="currency_SIT2" value="SIT">SIT - </option>
                                      <option class="currencyLeft" id="currency_SKK2" value="SKK">SKK - Slovak Koruna</option>
                                      <option class="currencyLeft" id="currency_SLL2" value="SLL">SLL - Leone</option>
                                      <option class="currencyLeft" id="currency_SOS2" value="SOS">SOS - Somali Shilling</option>
                                      <option class="currencyLeft" id="currency_SPL2" value="SPL">SPL - </option>
                                      <option class="currencyLeft" id="currency_SRD2" value="SRD">SRD - Surinam Dollar</option>
                                      <option class="currencyLeft" id="currency_STD2" value="STD">STD - Dobra</option>
                                      <option class="currencyLeft" id="currency_SVC2" value="SVC">SVC - El Salvador Colon</option>
                                      <option class="currencyLeft" id="currency_SYP2" value="SYP">SYP - Syrian Pound</option>
                                      <option class="currencyLeft" id="currency_SZL2" value="SZL">SZL - Lilangeni</option>
                                      <option class="currencyLeft" id="currency_THB2" value="THB">THB - Baht</option>
                                      <option class="currencyLeft" id="currency_TJS2" value="TJS">TJS - Somoni</option>
                                      <option class="currencyLeft" id="currency_TMM2" value="TMM">TMM - Manat</option>
                                      <option class="currencyLeft" id="currency_TND2" value="TND">TND - Tunisian Dinar</option>
                                      <option class="currencyLeft" id="currency_TOP2" value="TOP">TOP - Pa'anga</option>
                                      <option class="currencyLeft" id="currency_TRY2" value="TRY">TRY - New Turkish Lira</option>
                                      <option class="currencyLeft" id="currency_TTD2" value="TTD">TTD - Trinidad and Tobago Dollar</option>
                                      <option class="currencyLeft" id="currency_TVD2" value="TVD">TVD - </option>
                                      <option class="currencyLeft" id="currency_TWD2" value="TWD">TWD - New Taiwan Dollar</option>
                                      <option class="currencyLeft" id="currency_TZS2" value="TZS">TZS - Tanzanian Shilling</option>
                                      <option class="currencyLeft" id="currency_UAH2" value="UAH">UAH - Hryvnia</option>
                                      <option class="currencyLeft" id="currency_UGX2" value="UGX">UGX - Uganda Shilling</option>
                                      <option class="currencyLeft" id="currency_UYU2" value="UYU">UYU - Peso Uruguayo</option>
                                      <option class="currencyLeft" id="currency_UZS2" value="UZS">UZS - Uzbekistan Som</option>
                                      <option class="currencyLeft" id="currency_VEF2" value="VEF">VEF - Bolivar Fuerte</option>
                                      <option class="currencyLeft" id="currency_VND2" value="VND">VND - Vietnamese d?ng</option>
                                      <option class="currencyLeft" id="currency_VUV2" value="VUV">VUV - Vatu</option>
                                      <option class="currencyLeft" id="currency_WST2" value="WST">WST - Samoan Tala</option>
                                      <option class="currencyLeft" id="currency_XAF2" value="XAF">XAF - CFA Franc BEAC</option>
                                      <option class="currencyLeft" id="currency_XAG2" value="XAG">XAG - Silver</option>
                                      <option class="currencyLeft" id="currency_XAU2" value="XAU">XAU - Gold</option>
                                      <option class="currencyLeft" id="currency_XCD2" value="XCD">XCD - East Caribbean Dollar</option>
                                      <option class="currencyLeft" id="currency_XDR2" value="XDR">XDR - Special Drawing Rights</option>
                                      <option class="currencyLeft" id="currency_XOF2" value="XOF">XOF - CFA Franc BCEAO</option>
                                      <option class="currencyLeft" id="currency_XPD2" value="XPD">XPD - Palladium</option>
                                      <option class="currencyLeft" id="currency_XPF2" value="XPF">XPF - CFP Franc</option>
                                      <option class="currencyLeft" id="currency_XPT2" value="XPT">XPT - Platinum</option>
                                      <option class="currencyLeft" id="currency_YER2" value="YER">YER - Yemeni Rial</option>
                                      <option class="currencyLeft" id="currency_ZAR2" value="ZAR">ZAR - South African Rand</option>
                                      <option class="currencyLeft" id="currency_ZMK2" value="ZMK">ZMK - Kwacha</option>
                                      <option class="currencyLeft" id="currency_ZWD2" value="ZWD">ZWD - Zimbabwe Dollar</option>
                                    </select></td>
                                    <td align="center"><img src="https://secure.merchantservicecorp.net/shared/images/controls/default/left_move.gif" onclick="removeCurrency()" id="remove2"><img src="https://secure.merchantservicecorp.net/shared/images/controls/default/right_move.gif" onclick="addCurrency()" id="add2"></td>
                                    <td>Added Currencies<br>
                                        <select name="addedCurrency2" size="7" id="addedCurrency2">
                                          <option class="currencyRight" id="currency_USD2" value="USD">USD - US Dollar</option>
                                        </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
                              </nobr></td>
                            </tr>
                          <input type="hidden" name="current_mcc2" value="7399" id="current_mcc2">
                        </table>
                    <p><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> Edit</button></p>

    
    
    
    </div></div> 
    
   
      
   
   
   <div class="panel panel-primary">
                    <div class="panel-heading">Merchant Category Code</div>
                  <div class="panel-body">

<table id="form_ConfigureProcessor4" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr id="mcc_row">
    <tr id="search_mcc_row">
      <td id="search_mcc_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="search_mcc_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td>
              <label for="search_mcc" id="label_search_mcc">Search MCC</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="search_mcc_input_cell"><input type="text" maxlength="4" onkeydown="return blockEnter(event);" onkeyup="searchMcc();" id="search_mcc" name="search_mcc" value="" onchange="searchMcc();validate('ConfigureProcessor', this);">
      </td>
      <td align="right" id="search_mcc_box_cell"></td>
    </tr>
    <tr id="top_category_row">
      <td id="top_category_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="top_category_desc_table">
        <tbody>
          <tr>
            <td><img id="top_category_val_img" src="https://secure.merchantservicecorp.net/shared/images/clear.gif" width="18" height="18"> </td>
            <td>
              <label for="top_category" id="label_top_category">Category</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="top_category_input_cell"><select name="top_category" id="top_category" onchange="changeMcc();validate('ConfigureProcessor', this);">
         
        <option value="0" title="-- Select Category --">-- Select Category --</option>
         
        <option value="1" title="Airlines, Airports">Airlines, Airports</option>
         
        <option value="2" title="Associations/Organizations">Associations/Organizations</option>
         
        <option value="3" title="Automobile Dealers and Stores">Automobile Dealers and Stores</option>
         
        <option value="4" title="Automobile Rental">Automobile Rental</option>
         
        <option value="5" selected="selected" title="Business Services">Business Services</option>
         
        <option value="6" title="Clothing Stores">Clothing Stores</option>
         
        <option value="7" title="Contracted Services">Contracted Services</option>
         
        <option value="8" title="Educational Services and Child Care">Educational Services and Child Care</option>
         
        <option value="9" title="Entertainment Services">Entertainment Services</option>
         
        <option value="10" title="Financial & Real Estate services">Financial &amp; Real Estate services</option>
         
        <option value="11" title="Food, Drug, Liquor Stores, Restaurants and bars">Food, Drug, Liquor Stores, Restaurants and bars</option>
         
        <option value="12" title="Hotels and Motels, and other Lodgging">Hotels and Motels, and other Lodgging</option>
         
        <option value="13" title="Medical Services">Medical Services</option>
         
        <option value="14" title="Miscellaneous Stores">Miscellaneous Stores</option>
         
        <option value="15" title="Personal Services">Personal Services</option>
         
        <option value="16" title="Repair and Other Rental Services">Repair and Other Rental Services</option>
         
        <option value="17" title="Retail Stores">Retail Stores</option>
         
        <option value="18" title="Transportation">Transportation</option>
         
        <option value="19" title="Utilities">Utilities</option>
         
        <option value="20" title="Wholesale Distributors and Manufacturers">Wholesale Distributors and Manufacturers</option>
         
      </select>
      </td>
      <td align="right" id="top_category_box_cell"></td>
    </tr>
    <tr id="mcc_row">
      <td id="mcc_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="mcc_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td>
              <label for="mcc" id="label_mcc">Merchant Category Code</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="mcc_input_cell"><select name="mcc" id="mcc" onchange="setMcc();validate('ConfigureProcessor', this);">
          
        <option value="5960">5960 - Direct Marketing- Insurance Service</option>
        <option value="5961">5961 - Mail Order Houses Including Catalog Order Stores, Book/Record Clubs</option>
        <option value="5962">5962 - Direct Marketing - Travel</option>
        <option value="5963">5963 - Door-to-Door Sales</option>
        <option value="5964">5964 - Direct Marketing - Catalog Merchant</option>
        <option value="5965">5965 - Direct Marketing - Catalog and Catalog and Retail Merchant</option>
        <option value="5966">5966 - Direct Marketing- Outbound Telemarketing</option>
        <option value="5967">5967 - Direct Marketing - Inbound Teleservices</option>
        <option value="5968">5968 - Direct Marketing - Continuity/Subscription</option>
        <option value="5969">5969 - Direct Marketing - not listed elsewhere</option>
        <option value="7311">7311 - Advertising Services</option>
        <option value="7321">7321 - Consumer Credit Reporting Agencies</option>
        <option value="7332">7332 - Blueprinting and Photocopying Services</option>
        <option value="7333">7333 - Commercial Photography, Art and Graphics</option>
        <option value="7338">7338 - Quick Copy, Reproduction and Blueprinting Services</option>
        <option value="7339">7339 - Stenographic and Secretarial Support Services</option>
        <option value="7342">7342 - Exterminating and Disinfecting Services</option>
        <option value="7349">7349 - Cleaning and Maintenance, Janitorial Services</option>
        <option value="7361">7361 - Employment Agencies, Temporary Help Services</option>
        <option value="7372">7372 - Computer Programming</option>
        <option value="7375">7375 - Information Retrieval Services</option>
        <option value="7379">7379 - Computer Maintenance and Repair Services</option>
        <option value="7392">7392 - Consulting, Public Relations Services</option>
        <option value="7393">7393 - Detective Agencies</option>
        <option value="7394">7394 - Equipment Rental and Leasing Services</option>
        <option value="7395">7395 - Photo Developing, Photo Finishing Laboratories</option>
        <option value="7399">7399 - Misc. Business Services</option>
        <option value="8111">8111 - Legal Services and Attorneys</option>
      </select>
      </td>
    </tr>
  </tbody>
</table>
<br>
<a href="javascript:void(0);" onclick="toggleMoreFields(this, 'merchant_defined'); return false;"></a><br>
 
          </div>
    </div>   
   
   
   
   
   <div class="panel panel-primary">
                    <div class="panel-heading">Account Classification</div>
                  <div class="panel-body">

<table id="form_ConfigureProcessor5" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr id="default_transaction_type_row">
      <td id="default_transaction_type_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="default_transaction_type_desc_table">
        <tbody>
          <tr>
            <td> </td>
            <td><label for="default_transaction_type" id="label_default_transaction_type">Classification</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="default_transaction_type_input_cell"><select name="default_transaction_type" id="default_transaction_type" onchange="validate('ConfigureProcessor', this);">
         
        <option value="ecommerce" selected="selected" title="E-Commerce">E-Commerce</option>
         
        <option value="moto" title="MOTO">MOTO</option>
         
      </select>
      </td>
    </tr>
  </tbody>
</table>
<a href="javascript:void(0);" onclick="toggleMoreFields(this, 'merchant_defined'); return false;"></a><br>
 
          </div>
    </div>   
    
   
   
   
   
   
   
   
   
      <div class="panel panel-primary">
                    <div class="panel-heading">Payment Types Allowed</div>
                  <div class="panel-body">

<table id="form_ConfigureProcessor6" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr id="ConfigureProcessor_21_row">
      <td colspan="3">Select the type of card processors that have been setup by
        Transact Pro for this merchant.
        <strong>WARNING: If you choose one of the card processor below
          (i.e. American Express) that has not been setup by
          Transact Pro, the amount processed will not be 
          deposited to the merchant's account.</strong></td>
    </tr>
    <tr id="paymenttypes_1_row">
      <td width="293" align="LEFT" valign="MIDDLE" id="paymenttypes_1_desc_cell"><table cellspacing="0" id="paymenttypes_1_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td><label for="paymenttypes_1" id="label_paymenttypes_1">Visa</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td width="66" id="paymenttypes_1_input_cell"><input type="checkbox" title="" id="paymenttypes_1" name="paymenttypes_1" checked="">
      </td>
      <td width="804" align="right" id="paymenttypes_1_box_cell"></td>
    </tr>
    <tr id="paymenttypes_2_row">
      <td id="paymenttypes_2_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="paymenttypes_2_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td>
              <label for="paymenttypes_2" id="label_paymenttypes_2">Mastercard</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="paymenttypes_2_input_cell"><input type="checkbox" title="" id="paymenttypes_2" name="paymenttypes_2" checked="">
      </td>
      <td align="right" id="paymenttypes_2_box_cell"></td>
    </tr>
    <tr id="paymenttypes_64_row">
      <td id="paymenttypes_64_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="paymenttypes_64_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td><label for="paymenttypes_64" id="label_paymenttypes_64">Maestro</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="paymenttypes_64_input_cell"><input type="checkbox" title="" id="paymenttypes_64" name="paymenttypes_64">
      </td>
    </tr>
  </tbody>
</table>
<a href="javascript:void(0);" onclick="toggleMoreFields(this, 'merchant_defined'); return false;"></a><br>
 
          </div>
    </div>   
    
    
    
    
    
       <div class="panel panel-primary">
                    <div class="panel-heading">Account Limitations</div>
                  <div class="panel-body">
<table id="form_ConfigureProcessor7" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr id="ConfigureProcessor_26_row">
      <td colspan="3">Enter the maximum amounts for this merchant account.
        <strong>NOTE: These limits only apply to VISA/MasterCard.</strong></td>
    </tr>
    <tr id="maxticket_row">
      <td width="165" align="LEFT" valign="MIDDLE" id="maxticket_desc_cell"><table cellspacing="0" id="maxticket_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td><label for="maxticket" id="label_maxticket">Max Ticket Amount</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td width="176" id="maxticket_input_cell"><input type="text" size="15" id="maxticket" name="maxticket" value="50.00" onchange="validate('ConfigureProcessor', this);">
        ex. 1500.00</td>
      <td width="512" align="right" id="maxticket_box_cell"></td>
    </tr>
    <tr id="monthlyvolume_row">
      <td id="monthlyvolume_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="monthlyvolume_desc_table">
        <tbody>
          <tr>
            <td></td>
            <td><label for="monthlyvolume" id="label_monthlyvolume">Max Monthly Volume</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="monthlyvolume_input_cell"><input type="text" size="15" id="monthlyvolume" name="monthlyvolume" value="100.00" onchange="validate('ConfigureProcessor', this);">
        ex. 10000.00</td>
    </tr>
  </tbody>
</table>
<a href="javascript:void(0);" onclick="toggleMoreFields(this, 'merchant_defined'); return false;"></a><br>
 
          </div>
    </div>   
    
   


       <div class="panel panel-primary">
                    <div class="panel-heading">Duplicate Velocity Controls</div>
                  <div class="panel-body"><table id="form_ConfigureProcessor8" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr id="ConfigureProcessor_30_row2">
      <td colspan="3">Here you may set whether transactions sent through this processor are
        checked for duplicates. Checking 'Allow Merchant Override' lets merchants
        disable duplicate transaction checking by setting the Duplicate Threshold
        manually on a per-transaction basis.</td>
    </tr>
    <tr id="dup_checking_row2">
      <td width="252" align="LEFT" valign="MIDDLE" id="dup_checking_desc_cell2"><table cellspacing="0" id="dup_checking_desc_table2">
        <tbody>
          <tr>
            <td></td>
            <td><label for="dup_checking4" id="label_dup_checking">Enable Duplicate Checking</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td width="185" id="dup_checking_input_cell2"><input type="checkbox" title="" id="dup_checking4" name="dup_checking2" checked="">
      </td>
      <td width="611" align="right" id="dup_checking_box_cell2"></td>
    </tr>
    <tr id="dup_allow_override_row2">
      <td id="dup_allow_override_desc_cell2" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="dup_allow_override_desc_table2">
        <tbody>
          <tr>
            <td></td>
            <td><label for="dup_allow_override" id="label_dup_allow_override">Allow Merchant Override</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="dup_allow_override_input_cell2"><input type="checkbox" title="" id="dup_allow_override" name="dup_allow_override2">
      </td>
      <td align="right" id="dup_allow_override_box_cell2"></td>
    </tr>
    <tr id="dup_seconds_row2">
      <td id="dup_seconds_desc_cell2" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="dup_seconds_desc_table2">
        <tbody>
          <tr>
            <td></td>
            <td><label for="dup_seconds" id="label_dup_seconds">Duplicate Threshold</label>
            </td>
          </tr>
        </tbody>
      </table></td>
      <td id="dup_seconds_input_cell2"><input type="text" maxlength="11" size="11" id="dup_seconds" name="dup_seconds2" value="1200" onchange="validate('ConfigureProcessor', this);">
        (in seconds)</td>
    </tr>
  </tbody>
</table>
<a href="javascript:void(0);" onclick="toggleMoreFields(this, 'merchant_defined'); return false;"></a><br>
 
          </div>
    </div>      
   
   
   
   
   
   
   
 <div class="panel panel-primary">
                    <div class="panel-heading">Required Merchant Defined Fields</div>
                  <div class="panel-body"><table id="form_ConfigureProcessor3" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr id="ConfigureProcessor_35_row">
      <td colspan="3">Select the fields that must be filled out by the merchant. 
        <strong>WARNING: It is strongly recommended that you inform merchants
          before making fields required. This gives them the opportunity to
          make sure they are passing the information. If you do not notify
          them and they are not passing the required information,
          transactions will be denied immediately!</strong></td>
    </tr>
    <tr id="required_fields_64_row">
      <td width="196" align="LEFT" valign="MIDDLE" id="required_fields_64_desc_cell">
        <table cellspacing="0" id="required_fields_64_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_64" id="label_required_fields_64">Name</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td width="235" id="required_fields_64_input_cell"><input type="checkbox" title="" id="required_fields_64" name="required_fields_64" checked="">
      </td>
      <td width="788" align="right" id="required_fields_64_box_cell"></td>
    </tr>
    <tr id="required_fields_2048_row">
      <td id="required_fields_2048_desc_cell" valign="MIDDLE" align="LEFT"><table cellspacing="0" id="required_fields_2048_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_2048" id="label_required_fields_2048">Company</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_2048_input_cell"><input type="checkbox" title="" id="required_fields_2048" name="required_fields_2048" checked="">
      </td>
      <td align="right" id="required_fields_2048_box_cell"></td>
    </tr>
    <tr id="required_fields_2_row">
      <td id="required_fields_2_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_2_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_2" id="label_required_fields_2">Address</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_2_input_cell"><input type="checkbox" title="" id="required_fields_2" name="required_fields_2" checked="">
      </td>
      <td align="right" id="required_fields_2_box_cell"></td>
    </tr>
    <tr id="required_fields_4_row">
      <td id="required_fields_4_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_4_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_4" id="label_required_fields_4">City</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_4_input_cell"><input type="checkbox" title="" id="required_fields_4" name="required_fields_4" checked="">
      </td>
      <td align="right" id="required_fields_4_box_cell"></td>
    </tr>
    <tr id="required_fields_512_row">
      <td id="required_fields_512_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_512_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_512" id="label_required_fields_512">State</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_512_input_cell"><input type="checkbox" title="" id="required_fields_512" name="required_fields_512" checked="">
      </td>
      <td align="right" id="required_fields_512_box_cell"></td>
    </tr>
    <tr id="required_fields_8_row">
      <td id="required_fields_8_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_8_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_8" id="label_required_fields_8">Zipcode</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_8_input_cell"><input type="checkbox" title="" id="required_fields_8" name="required_fields_8" checked="">
      </td>
      <td align="right" id="required_fields_8_box_cell"></td>
    </tr>
    <tr id="required_fields_16_row">
      <td id="required_fields_16_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_16_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_16" id="label_required_fields_16">Country</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_16_input_cell"><input type="checkbox" title="" id="required_fields_16" name="required_fields_16">
      </td>
      <td align="right" id="required_fields_16_box_cell"></td>
    </tr>
    <tr id="required_fields_1_row">
      <td id="required_fields_1_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_1_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_1" id="label_required_fields_1">Phone Number</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_1_input_cell"><input type="checkbox" title="" id="required_fields_1" name="required_fields_1">
      </td>
      <td align="right" id="required_fields_1_box_cell"></td>
    </tr>
    <tr id="required_fields_32_row">
      <td id="required_fields_32_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_32_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_32" id="label_required_fields_32">Email Address</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_32_input_cell"><input type="checkbox" title="" id="required_fields_32" name="required_fields_32">
      </td>
      <td align="right" id="required_fields_32_box_cell"></td>
    </tr>
    <tr id="required_fields_134217728_row">
      <td id="required_fields_134217728_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_134217728_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_134217728" id="label_required_fields_134217728">Driver's License</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_134217728_input_cell"><input type="checkbox" title="" id="required_fields_134217728" name="required_fields_134217728">
      </td>
      <td align="right" id="required_fields_134217728_box_cell"></td>
    </tr>
    <tr id="required_fields_268435456_row">
      <td id="required_fields_268435456_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0" id="required_fields_268435456_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td>Driver's License State</td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_268435456_input_cell"><input type="checkbox" title="" id="required_fields_268435456" name="required_fields_268435456">
      </td>
      <td align="right" id="required_fields_268435456_box_cell"></td>
    </tr>
    <tr id="required_fields_536870912_row">
      <td id="required_fields_536870912_desc_cell" valign="MIDDLE" align="LEFT">
        <table cellspacing="0">
          <tbody>
            <tr>
              <td></td>
              <td>Driver's License DOB</td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_536870912_input_cell"><input type="checkbox" title="" id="required_fields_536870912" name="required_fields_536870912">
      </td>
      <td align="right" id="required_fields_536870912_box_cell"></td>
    </tr>
    <tr id="required_fields_1073741824_row">
      <td id="required_fields_1073741824_desc_cell" valign="MIDDLE" align="LEFT"><span id="required_fields_1073741824_desc">
        <table cellspacing="0" id="required_fields_1073741824_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_1073741824" id="label_required_fields_1073741824">Social Security Number</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_1073741824_input_cell"><input type="checkbox" title="" id="required_fields_1073741824" name="required_fields_1073741824">
        <table cellspacing="0" cellpadding="0">
          <tr id="ConfigureProcessor_88_row">
            <td colspan="3">Enter a description for this Transact Pro account. This
              allows the merchant to identify between multiple
              accounts.</td>
          </tr>
          <tr id="name_row">
            <td width="237" align="LEFT" valign="MIDDLE" id="name_desc_cell"><span id="name_desc">
              <table cellspacing="0" id="name_desc_table">
                <tbody>
                  <tr>
                    <td></td>
                    <td><label for="name" id="label_name">Account Description</label></td>
                  </tr>
                </tbody>
              </table>
            </td>
            <td width="153" id="name_input_cell"><input type="text" maxlength="25" size="20" id="name" name="name" value="Rietumu" onChange="validate('ConfigureProcessor', this);"></td>
            <td width="525" align="right"></td>
          </tr>
          <tr id="id_row">
            <td id="id_desc_cell" valign="MIDDLE" align="LEFT"><span id="id_desc">
              <table cellspacing="0" id="id_desc_table">
                <tbody>
                  <tr>
                    <td></td>
                    <td><label for="id" id="label_id">&nbsp;Processor ID</label></td>
                  </tr>
                </tbody>
              </table>
            </td>
            <td id="id_input_cell"><em>rietumu</em></td>
            <td align="right"></td>
          </tr>
          <tr id="ConfigureProcessor_submit_button_row">
            <td align="center" colspan="2"><input type="submit" id="ConfigureProcessor_submit_button" name="ConfigureProcessor_submit_button" value="Save"></td>
          </tr>
        </table></td>
      <td align="right" id="required_fields_1073741824_box_cell"></td>
    </tr>
    <tr id="required_fields_128_row">
      <td id="required_fields_128_desc_cell" valign="MIDDLE" align="LEFT"><span id="required_fields_128_desc">
        <table cellspacing="0" id="required_fields_128_desc_table">
          <tbody>
            <tr>
              <td></td>
              <td><label for="required_fields_128" id="label_required_fields_128">Card Security Code</label></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td id="required_fields_128_input_cell"><select name="required_fields_128" id="required_fields_128" onchange="validate('ConfigureProcessor', this);">
         
        <option value="" title="Not Required">Not Required</option>
         
        <option value="yes" title="Always Required">Always Required</option>
         
        <option value="first" selected="selected" title="Required on First Transaction">Required on First Transaction</option>
         
      </select>
      </td>
    </tr>
  </tbody>
</table>
<br>
 
          </div>
    </div>     
   
   
   
   
   
   
   
<div class="panel panel-primary">
                    <div class="panel-heading">Required Merchant Defined Fields</div>
                  <div class="panel-body">
<a href="javascript:void(0);" onclick="toggleMoreFields(this, 'merchant_defined'); return false;">More fields...</a><br>
 
          </div>
    </div>   
    
    
    
    
    
    
    
   
   
   
   
   
    
    
<div class="panel panel-primary">
                    <div class="panel-heading">Account Identification</div>
                  <div class="panel-body">
<br>
                    <p><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> Edit</button></p>
                  </div>
    </div>
    
    
    
    
    
   
</div>
</div>
</div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?>