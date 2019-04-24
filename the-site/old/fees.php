<?php require_once( 'header.php'); ?>
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-lg-4"></div>
    <div class="row show-grid">
        <div class="col-md-4">
            <label>Merchants&nbsp;&nbsp;</label>
            <select name="merchantid" id="merchantid" size="1">
                <option value="-1" selected="selected">N/A</option>
                <option value="45" selected="selected">CP-Billconnect help.com</option>
                <option value="44">CP-Invo-help.com</option>
                <option value="24">Romanti.Net</option>
            </select>
            </br>
            </br>
            </br>&nbsp;&nbsp;
            <button type="button" class="btn btn-w-m btn-primary">Get Processor Data</button>
            <button type="button" class="btn btn-w-m btn-default">Reset!</button>
            </br>
            </br>
            </br>
            <label>Processors &nbsp;&nbsp;</label>
            <select name="processorid" id="processorid" size="1">
                <option value="65" selected="selected">Card Program</option>
            </select>
            </br>
            </br>
            </br>&nbsp;&nbsp;
            <button type="button" class="btn btn-w-m btn-primary">&nbsp; &nbsp; &nbsp;&nbsp;Get Fees Data&nbsp; &nbsp; &nbsp;</button>
            <button type="button" class="btn btn-w-m btn-default">Reset!</button>
            <hr />
            <table>
                <tr>
                    <td >
                        <h4>       Billing scheduling</h4>

                        <table>
                            <tbody>
                                <tr>
                                    <td>Number of billing periods per week</td>
                                    <td>
                                        <select name="bperiod" id="bperiod" size="1">
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bill period #1 starts on:</td>
                                    <td>
                                        <select name="bpstart1" id="bpstart1" size="1">
                                            <option value="1" selected="selected">Sunday</option>
                                            <option value="2">Monday</option>
                                            <option value="3">Tuesday</option>
                                            <option value="4">Wednesday</option>
                                            <option value="5">Thursday</option>
                                            <option value="6">Friday</option>
                                            <option value="7">Saturday</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bill period #2 starts on:</td>
                                    <td>
                                        <select name="bpstart2" id="bpstart2" size="1">
                                            <option value="0" selected="selected">N/A</option>
                                            <option value="1">Sunday</option>
                                            <option value="2">Monday</option>
                                            <option value="3">Tuesday</option>
                                            <option value="4">Wednesday</option>
                                            <option value="5">Thursday</option>
                                            <option value="6">Friday</option>
                                            <option value="7">Saturday</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time to settle(weeks)</td>
                                    <td>
                                        <select name="settledelay" id="settledelay" size="1">
                                            <option value="1">One</option>
                                            <option value="2" selected="selected">Two</option>
                                            <option value="3">Three</option>
                                            <option value="4">Four</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <p>&nbsp;</p>
        </div>
        <div class="col-md-4">
            <table>
                <tbody>
                    <tr>
                        <td style="horizontal-align:center;vertical-align:top" colspan="2">
                             <h1>CP-Invo-help.com</h1>

                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" ><b>Voicesave Fees</b>

                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <input type="checkbox" name="usesvr" id="usesvr" checked="checked" form="fform">This merchant uses Voicesave</td>
                                    </tr>
                                    <tr>
                                        <td>Setup Fee</td>
                                        <td>
                                            <input type="text" name="vssetup" id="vssetup" form="fform">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Fee</td>
                                        <td>
                                            <input type="text" name="vsmonthly" id="vsmonthly" form="fform">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fee per call</td>
                                        <td>
                                            <input type="text" name="vspcall" id="vspcall" form="fform">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fee per minute</td>
                                        <td>
                                            <input type="text" name="vspminute" id="vspminute" form="fform">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td align="left" valign="top">
                             <h4><b>Watch Me Click Fees</b></h4>

                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <input type="checkbox" name="useswmc" id="useswmc" checked="checked" form="fform">This merchant uses WatchMeClick</td>
                                    </tr>
                                    <tr>
                                        <td>Setup Fee</td>
                                        <td>
                                            <input type="text" name="wmcsetup" id="wmcsetup" form="fform">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Fee</td>
                                        <td>
                                            <input type="text" name="wmcmonthly" id="wmcmonthly" form="fform">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fee per session</td>
                                        <td>
                                            <input type="text" name="wmcpsession" id="wmcpsession" form="fform">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <th>
                            <h4>Gateway Fees (All fees in US$)</h4>
                        </th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Setup</th>
                        <th>Monthly</th>
                        <th>Transaction fee</th>
                    </tr>
                    <tr id="row1">
                        <td>CP-Invo-help.com
                            <input type="hidden" name="mid1" id="mid1" value="44">
                        </td>
                        <td id="gsetupfee">
                            <input type="text" name="mgsetupfee" id="mgsetupfee" required="required">
                        </td>
                        <td id="gmonthlyfee">
                            <input type="text" name="mgmonthlyfee" id="mgmonthlyfee" required="required">
                        </td>
                        <td id="gtransfee">
                            <input type="text" name="mgtransfee" id="mgtransfee" style="width: 110px" required="required">
                        </td>
                    </tr>
                    <tr id="grow2">
                        <td>Priority
                            <input type="hidden" name="aid11" id="aid11" value="11">
                        </td>
                        <td class="gsetupfee_sub">
                            <input type="text" name="agsetupfee11" id="agsetupfee11" required="required">
                        </td>
                        <td class="gmonthlyfee_sub">
                            <input type="text" name="agmonthlyfee11" id="agmonthlyfee11" required="required">
                        </td>
                        <td class="gtransfee_sub">
                            <input type="text" name="agtransfee11" id="agtransfee11" style="width: 110px" required="required">
                        </td>
                    </tr>
                    <tr id="grow3">
                        <td>Ekbalo
                            <input type="hidden" name="aid17" id="aid17" value="17">
                        </td>
                        <td class="gsetupfee_sub">
                            <input type="text" name="agsetupfee17" id="agsetupfee17" required="required">
                        </td>
                        <td class="gmonthlyfee_sub">
                            <input type="text" name="agmonthlyfee17" id="agmonthlyfee17" required="required">
                        </td>
                        <td class="gtransfee_sub">
                            <input type="text" name="agtransfee17" id="agtransfee17" style="width: 110px" required="required">
                        </td>
                    </tr>
                    <tr id="grow4">
                        <td>Gothe
                            <input type="hidden" name="aid12" id="aid12" value="12">
                        </td>
                        <td class="gsetupfee_sub">
                            <input type="text" name="agsetupfee12" id="agsetupfee12" required="required">
                        </td>
                        <td class="gmonthlyfee_sub">
                            <input type="text" name="agmonthlyfee12" id="agmonthlyfee12" required="required">
                        </td>
                        <td class="gtransfee_sub">
                            <input type="text" name="agtransfee12" id="agtransfee12" style="width: 110px" required="required">
                        </td>
                    </tr>
                    <input type="hidden" name="borg" id="borg" value="1">
                    <tr>
                        <td>Network Merchants Inc.
                            <input type="hidden" name="pid1" id="pid1" value="45">
                        </td>
                        <td class="gsetupfee_sub">
                            <input type="text" name="pgsetupfee" id="pgsetupfee" required="required">
                        </td>
                        <td class="gmonthlyfee_sub">
                            <input type="text" name="pgmonthlyfee" id="pgmonthlyfee" required="required">
                        </td>
                        <td class="gtransfee_sub">
                            <input type="text" name="pgtransfee" id="pgtransfee" style="width: 110px" required="required">
                        </td>
                    </tr>
                    <tr>
                        <td>Profit</td>
                        <td class="gsetupfee_total">
                            <input type="text" name="gsetupfee" id="gsetupfee" disabled="">
                        </td>
                        <td class="gmonthlyfee_total">
                            <input type="text" name="gmonthlyfee" id="gmonthlyfee" disabled="">
                        </td>
                        <td class="gtransfee_total">
                            <input type="text" name="gtransfee" id="gtransfee" style="width: 110px" disabled="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form method="post" id="fform" name="fform" ,="" action="https://secure.profitorius.com/cgi-bin//admin.pl">
         <h4>Bank Fees (All fees in US$)</h4>

        <p>Date Fees are effective:
            <input id="mdatepicker" name="mdatepicker" type="text" style="width: 120px" maxlength="10" required="required" class="hasDatepicker">
        </p>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th >Transaction</th>
                    <th >Authorization</th>
                    <th >Capture</th>
                    <th >Sale</th>
                    <th >Decline</th>
                    <th>efund</th>
                    <th >Chargeback 1</th>
                    <th >Chargeback 2</th>
                    <th >Chargeback
                        <br>Threshold</th>
                    <th >Discount
                        <br>rate (%)</th>
                    <th >AVS Premium</th>
                    <th >CVV Premium</th>
                    <th >Interregional
                        <br>Premium</th>
                    <th >Wire</th>
                    <th>eserve
                        <br>rate (%)</th>
                    <th>eserve
                        <br>period
                        <br>(months)</th>
                    <th >Initial
                        <br>Reserve</th>
                    <th >Setup
                        <br>fee</th>
                    <th >Monthly
                        <br>Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr id="row1">
                    <td>CP-Invo-help.com
                        <input type="hidden" name="mid" id="mid" value="44">
                    </td>
                    <td id="trfee">
                        <input type="text" name="mtrfee" id="mtrfee"  required="required">
                    </td>
                    <td id="aufee">
                        <input type="text" name="maufee" id="maufee" required="required">
                    </td>
                    <td id="cafee">
                        <input type="text" name="mcafee" id="mcafee" required="required">
                    </td>
                    <td id="safee">
                        <input type="text" name="msafee" id="msafee"  required="required">
                    </td>
                    <td id="defee">
                        <input type="text" name="mdefee" id="mdefee"  required="required">
                    </td>
                    <td id="refee">
                        <input type="text" name="mrefee" id="mrefee"  required="required">
                    </td>
                    <td id="cb1fee">
                        <input type="text" name="mcb1fee" id="mcb1fee" required="required">
                    </td>
                    <td id="cb2fee">
                        <input type="text" name="mcb2fee" id="mcb2fee" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="mcbthreshold" id="mcbthreshold" required="required">
                    </td>
                    <td id="drfee">
                        <input type="text" name="mdrfee" id="mdrfee" required="required">
                    </td>
                    <td id="avsfee">
                        <input type="text" name="mavsfee" id="mavsfee" required="required">
                    </td>
                    <td id="cvvfee">
                        <input type="text" name="mcvvfee" id="mcvvfee" required="required">
                    </td>
                    <td id="irfee">
                        <input type="text" name="mirfee" id="mirfee" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="mwfee" id="mwfee"  required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="mrrfee" id="mrrfee" required="required">
                    </td>
                    <td class="skip">
                        <select name="mreserveperiod" id="mreserveperiod" size="1">
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6" selected="selected">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                        </select>
                    </td>
                    <td class="skip">
                        <input type="text" name="minitresrv" id="minitresrv" required="required">
                    </td>
                    <td id="setupfee">
                        <input type="text" name="msetupfee" id="msetupfee" required="required">
                    </td>
                    <td id="monthlyfee">
                        <input type="text" name="mmonthlyfee" id="mmonthlyfee" required="required">
                    </td>
                </tr>
                <tr id="row2">
                    <td>Priority
                        <input type="hidden" name="aidB11" id="aidB11" value="11">
                    </td>
                    <td class="trfee_sub">
                        <input type="text" name="atrfee11" id="atrfee11"  required="required">
                    </td>
                    <td class="aufee_sub">
                        <input type="text" name="aaufee11" id="aaufee11" required="required">
                    </td>
                    <td class="cafee_sub">
                        <input type="text" name="acafee11" id="acafee11" required="required">
                    </td>
                    <td class="safee_sub">
                        <input type="text" name="asafee11" id="asafee11"  required="required">
                    </td>
                    <td class="defee_sub">
                        <input type="text" name="adefee11" id="adefee11"  required="required">
                    </td>
                    <td class="refee_sub">
                        <input type="text" name="arefee11" id="arefee11"  required="required">
                    </td>
                    <td class="cb1fee_sub">
                        <input type="text" name="acb1fee11" id="acb1fee11" required="required">
                    </td>
                    <td class="cb2fee_sub">
                        <input type="text" name="acb2fee11" id="acb2fee11" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="acbthreshold11" id="acbthreshold11" required="required">
                    </td>
                    <td class="drfee_sub">
                        <input type="text" name="adrfee11" id="adrfee11" required="required">
                    </td>
                    <td class="avsfee_sub">
                        <input type="text" name="adavsfee11" id="adavsfee11" required="required">
                    </td>
                    <td class="cvvfee_sub">
                        <input type="text" name="adcvvfee11" id="adcvvfee11" required="required">
                    </td>
                    <td class="irfee_sub">
                        <input type="text" name="adirfee11" id="adirfee11" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="awfee11" id="awfee11"  required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="arrfee11" id="arrfee11" required="required">
                    </td>
                    <td class="skip">
                        <select name="areserveperiod11" id="areserveperiod11" size="1">
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6" selected="selected">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                        </select>
                    </td>
                    <td class="skip">
                        <input type="text" name="ainitresrv11" id="ainitresrv11" required="required">
                    </td>
                    <td class="setupfee_sub">
                        <input type="text" name="amsetupfee11" id="asetupfee11" required="required">
                    </td>
                    <td class="monthlyfee_sub">
                        <input type="text" name="amonthlyfee11" id="mmonthlyfee11&quot;" required="required">
                    </td>
                </tr>
                <tr id="row3">
                    <td>Ekbalo
                        <input type="hidden" name="aidB17" id="aidB17" value="17">
                    </td>
                    <td class="trfee_sub">
                        <input type="text" name="atrfee17" id="atrfee17"  required="required">
                    </td>
                    <td class="aufee_sub">
                        <input type="text" name="aaufee17" id="aaufee17" required="required">
                    </td>
                    <td class="cafee_sub">
                        <input type="text" name="acafee17" id="acafee17" required="required">
                    </td>
                    <td class="safee_sub">
                        <input type="text" name="asafee17" id="asafee17"  required="required">
                    </td>
                    <td class="defee_sub">
                        <input type="text" name="adefee17" id="adefee17"  required="required">
                    </td>
                    <td class="refee_sub">
                        <input type="text" name="arefee17" id="arefee17"  required="required">
                    </td>
                    <td class="cb1fee_sub">
                        <input type="text" name="acb1fee17" id="acb1fee17" required="required">
                    </td>
                    <td class="cb2fee_sub">
                        <input type="text" name="acb2fee17" id="acb2fee17" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="acbthreshold17" id="acbthreshold17" required="required">
                    </td>
                    <td class="drfee_sub">
                        <input type="text" name="adrfee17" id="adrfee17" required="required">
                    </td>
                    <td class="avsfee_sub">
                        <input type="text" name="adavsfee17" id="adavsfee17" required="required">
                    </td>
                    <td class="cvvfee_sub">
                        <input type="text" name="adcvvfee17" id="adcvvfee17" required="required">
                    </td>
                    <td class="irfee_sub">
                        <input type="text" name="adirfee17" id="adirfee17" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="awfee17" id="awfee17"  required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="arrfee17" id="arrfee17" required="required">
                    </td>
                    <td class="skip">
                        <select name="areserveperiod17" id="areserveperiod17" size="1">
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6" selected="selected">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                        </select>
                    </td>
                    <td class="skip">
                        <input type="text" name="ainitresrv17" id="ainitresrv17" required="required">
                    </td>
                    <td class="setupfee_sub">
                        <input type="text" name="amsetupfee17" id="asetupfee17" required="required">
                    </td>
                    <td class="monthlyfee_sub">
                        <input type="text" name="amonthlyfee17" id="mmonthlyfee17&quot;" required="required">
                    </td>
                </tr>
                <tr id="row4">
                    <td>Gothe
                        <input type="hidden" name="aidB12" id="aidB12" value="12">
                    </td>
                    <td class="trfee_sub">
                        <input type="text" name="atrfee12" id="atrfee12"  required="required">
                    </td>
                    <td class="aufee_sub">
                        <input type="text" name="aaufee12" id="aaufee12" required="required">
                    </td>
                    <td class="cafee_sub">
                        <input type="text" name="acafee12" id="acafee12" required="required">
                    </td>
                    <td class="safee_sub">
                        <input type="text" name="asafee12" id="asafee12"  required="required">
                    </td>
                    <td class="defee_sub">
                        <input type="text" name="adefee12" id="adefee12"  required="required">
                    </td>
                    <td class="refee_sub">
                        <input type="text" name="arefee12" id="arefee12"  required="required">
                    </td>
                    <td class="cb1fee_sub">
                        <input type="text" name="acb1fee12" id="acb1fee12" required="required">
                    </td>
                    <td class="cb2fee_sub">
                        <input type="text" name="acb2fee12" id="acb2fee12" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="acbthreshold12" id="acbthreshold12" required="required">
                    </td>
                    <td class="drfee_sub">
                        <input type="text" name="adrfee12" id="adrfee12" required="required">
                    </td>
                    <td class="avsfee_sub">
                        <input type="text" name="adavsfee12" id="adavsfee12" required="required">
                    </td>
                    <td class="cvvfee_sub">
                        <input type="text" name="adcvvfee12" id="adcvvfee12" required="required">
                    </td>
                    <td class="irfee_sub">
                        <input type="text" name="adirfee12" id="adirfee12" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="awfee12" id="awfee12"  required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="arrfee12" id="arrfee12" required="required">
                    </td>
                    <td class="skip">
                        <select name="areserveperiod12" id="areserveperiod12" size="1">
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6" selected="selected">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                        </select>
                    </td>
                    <td class="skip">
                        <input type="text" name="ainitresrv12" id="ainitresrv12" required="required">
                    </td>
                    <td class="setupfee_sub">
                        <input type="text" name="amsetupfee12" id="asetupfee12" required="required">
                    </td>
                    <td class="monthlyfee_sub">
                        <input type="text" name="amonthlyfee12" id="mmonthlyfee12&quot;" required="required">
                    </td>
                </tr>
                <tr id="row5">
                    <td>Card Program
                        <input type="hidden" name="pid" id="pid" value="65">
                    </td>
                    <td class="trfee_sub">
                        <input type="text" name="btrfee" id="btrfee"  required="required">
                    </td>
                    <td class="aufee_sub">
                        <input type="text" name="baufee" id="baufee" required="required">
                    </td>
                    <td class="cafee_sub">
                        <input type="text" name="bcafee" id="bcafee" required="required">
                    </td>
                    <td class="safee_sub">
                        <input type="text" name="bsafee" id="bsafee"  required="required">
                    </td>
                    <td class="defee_sub">
                        <input type="text" name="bdefee" id="bdefee"  required="required">
                    </td>
                    <td class="refee_sub">
                        <input type="text" name="brefee" id="brefee"  required="required">
                    </td>
                    <td class="cb1fee_sub">
                        <input type="text" name="bcb1fee" id="bcb1fee" required="required">
                    </td>
                    <td class="cb2fee_sub">
                        <input type="text" name="bcb2fee" id="bcb2fee" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="bcbthreshold" id="bcbthreshold" required="required">
                    </td>
                    <td class="drfee_sub">
                        <input type="text" name="bdrfee" id="bdrfee" required="required">
                    </td>
                    <td class="avsfee_sub">
                        <input type="text" name="bavsfee" id="bavsfee" required="required">
                    </td>
                    <td class="cvvfee_sub">
                        <input type="text" name="bcvvfee" id="bcvvfee" required="required">
                    </td>
                    <td class="irfee_sub">
                        <input type="text" name="birfee" id="birfee" required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="bwfee" id="bwfee"  required="required">
                    </td>
                    <td class="skip">
                        <input type="text" name="brrfee" id="brrfee" required="required">
                    </td>
                    <td class="skip">
                        <select name="breserveperiod" id="breserveperiod" size="1">
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6" selected="selected">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                        </select>
                    </td>
                    <td class="skip">
                        <input type="text" name="binitresrv" id="binitresrv" required="required">
                    </td>
                    <td class="setupfee_sub">
                        <input type="text" name="bsetupfee" id="bsetupfee" required="required">
                    </td>
                    <td class="monthlyfee_sub">
                        <input type="text" name="bmonthlyfee" id="bmonthlyfee" required="required">
                    </td>
                </tr>
                <tr id="row6">
                    <td>Profit</td>
                    <td class="trfee_total">
                        <input type="text" name="trfee" id="trfee"  disabled="">
                    </td>
                    <td class="aufee_total">
                        <input type="text" name="aufee" id="aufee" disabled="">
                    </td>
                    <td class="cafee_total">
                        <input type="text" name="cafee" id="cafee" disabled="">
                    </td>
                    <td class="safee_total">
                        <input type="text" name="safee" id="safee"  disabled="">
                    </td>
                    <td class="defee_total">
                        <input type="text" name="defee" id="defee"  disabled="">
                    </td>
                    <td class="refee_total">
                        <input type="text" name="refee" id="refee"  disabled="">
                    </td>
                    <td class="cb1fee_total">
                        <input type="text" name="cb1fee" id="cb1fee" disabled="">
                    </td>
                    <td class="cb2fee_total">
                        <input type="text" name="cb2fee" id="cb2fee" disabled="">
                    </td>
                    <td class="skip"></td>
                    <td class="drfee_total">
                        <input type="text" name="drfee" id="drfee" disabled="">
                    </td>
                    <td class="avsfee_total">
                        <input type="text" name="avsfee" id="avsfee" disabled="">
                    </td>
                    <td class="cvvfee_total">
                        <input type="text" name="cvvfee" id="cvvfee" disabled="">
                    </td>
                    <td class="irfee_total">
                        <input type="text" name="irfee" id="irfee" disabled="">
                    </td>
                    <td class="skip"></td>
                    <td class="skip"></td>
                    <td class="skip"></td>
                    <td class="skip"></td>
                    <td class="setupfee_total">
                        <input type="text" name="setupfee" id="setupfee" disabled="">
                    </td>
                    <td class="monthlyfee_total">
                        <input type="text" name="monthlyfee" id="monthlyfee" disabled="">
                    </td>
                </tr>
            </tbody>
        </table>
      <h4>Miscellaneous Fees</h4>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Setup</th>
                    <th>Monthly 1</th>
                    <th>Monthly 2</th>
                    <th>Transaction
                        <br>Fee 1</th>
                    <th>Transaction
                        <br>Fee 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Fee Name</td>
                    <td>
                        <input type="text" name="miscsetupname" id="miscsetupname" required="required">
                    </td>
                    <td>
                        <input type="text" name="miscmonthlyonename" id="miscmonthlyonename" required="required">
                    </td>
                    <td>
                        <input type="text" name="miscmonthlytwoname" id="miscmonthlytwoname" required="required">
                    </td>
                    <td>
                        <input type="text" name="misctransonename" id="misctransonename" required="required">
                    </td>
                    <td>
                        <input type="text" name="misctranstwoname" id="misctranstwoname" required="required">
                    </td>
                </tr>
                <tr id="row1">
                    <td>CP-Invo-help.com</td>
                    <td id="miscsetup">
                        <input type="text" name="miscsetupm" id="miscsetupm" required="required">
                    </td>
                    <td id="miscmonthlyone">
                        <input type="text" name="miscmonthlyonem" id="miscmonthlyonem" required="required">
                    </td>
                    <td id="miscmonthlytwo">
                        <input type="text" name="miscmonthlytwom" id="miscmonthlytwom" required="required">
                    </td>
                    <td id="misctransone">
                        <input type="text" name="misctransonem" id="misctransonem" required="required">
                    </td>
                    <td id="misctranstwo">
                        <input type="text" name="misctranstwom" id="misctranstwom" required="required">
                    </td>
                </tr>
                <tr id="row2">
                    <td>Priority</td>
                    <td class="miscsetup_sub">
                        <input type="text" name="miscsetupa11" id="miscsetupa11" required="required">
                    </td>
                    <td class="miscmonthlyone_sub">
                        <input type="text" name="miscmonthlyonea11" id="miscmonthlyonea11" required="required">
                    </td>
                    <td class="miscmonthlytwo_sub">
                        <input type="text" name="miscmonthlytwoa11" id="miscmonthlytwoa11" required="required">
                    </td>
                    <td class="misctransone_sub">
                        <input type="text" name="misctransonea11" id="misctransonea11" required="required">
                    </td>
                    <td class="misctranstwo_sub">
                        <input type="text" name="misctranstwoa11" id="misctranstwoa11" required="required">
                    </td>
                </tr>
                <tr id="row2">
                    <td>Ekbalo</td>
                    <td class="miscsetup_sub">
                        <input type="text" name="miscsetupa17" id="miscsetupa17" required="required">
                    </td>
                    <td class="miscmonthlyone_sub">
                        <input type="text" name="miscmonthlyonea17" id="miscmonthlyonea17" required="required">
                    </td>
                    <td class="miscmonthlytwo_sub">
                        <input type="text" name="miscmonthlytwoa17" id="miscmonthlytwoa17" required="required">
                    </td>
                    <td class="misctransone_sub">
                        <input type="text" name="misctransonea17" id="misctransonea17" required="required">
                    </td>
                    <td class="misctranstwo_sub">
                        <input type="text" name="misctranstwoa17" id="misctranstwoa17" required="required">
                    </td>
                </tr>
                <tr id="row2">
                    <td>Gothe</td>
                    <td class="miscsetup_sub">
                        <input type="text" name="miscsetupa12" id="miscsetupa12" required="required">
                    </td>
                    <td class="miscmonthlyone_sub">
                        <input type="text" name="miscmonthlyonea12" id="miscmonthlyonea12" required="required">
                    </td>
                    <td class="miscmonthlytwo_sub">
                        <input type="text" name="miscmonthlytwoa12" id="miscmonthlytwoa12" required="required">
                    </td>
                    <td class="misctransone_sub">
                        <input type="text" name="misctransonea12" id="misctransonea12" required="required">
                    </td>
                    <td class="misctranstwo_sub">
                        <input type="text" name="misctranstwoa12" id="misctranstwoa12" required="required">
                    </td>
                </tr>
                <tr>
                    <td>Card Program</td>
                    <td class="miscsetup_sub">
                        <input type="text" name="miscsetupb" id="miscsetupb" required="required">
                    </td>
                    <td class="miscmonthlyone_sub">
                        <input type="text" name="miscmonthlyoneb" id="miscmonthlyoneb" required="required">
                    </td>
                    <td class="miscmonthlytwo_sub">
                        <input type="text" name="miscmonthlytwob" id="miscmonthlytwob" required="required">
                    </td>
                    <td class="misctransone_sub">
                        <input type="text" name="misctransoneb" id="misctransoneb" required="required">
                    </td>
                    <td class="misctranstwo_sub">
                        <input type="text" name="misctranstwob" id="misctranstwob" required="required">
                    </td>
                </tr>
                <tr>
                    <td>Profit</td>
                    <td class="miscsetup_total">
                        <input type="text" name="miscsetup" id="miscsetup" disabled="">
                    </td>
                    <td class="miscmonthlyone_total">
                        <input type="text" name="miscmonthlyone" id="miscmonthlyone" disabled="">
                    </td>
                <td class="miscmonthlytwo_total">
                        <input type="text" name="miscmonthlytwo" id="miscmonthlytwo" disabled="">
                        <table>
                          <thead>
                            <tr>
                              <th >Date Effective</th>
                              <th >Last Date Effective</th>
                              <th >Bill Cyces Per Week</th>
                              <th >Bill Period #1 start day</th>
                              <th >Bill Period #2 start day</th>
                              <th >Time to Settle (weeks)</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                    </table></td>
                    <td class="misctransone_total">
                        <input type="text" name="misctransone" id="misctransone" disabled="">
                    </td>
                    <td class="misctranstwo_total">
                        <input type="text" name="misctranstwo" id="misctranstwo" disabled="">
                    </td>
                </tr>
            </tbody>
        </table>
        </br>
        </br>
        </br>
        <input type="submit" name="feessave" id="feessave" value="Save Data" class="btn btn-w-m btn-default" role="button" aria-disabled="false">
        <input type="reset" value="Reset!" id="feereset" name="feereset" class="btn btn-w-m btn-primary" role="button" aria-disabled="false">
    </form>
    </br>
    </br>
    </hr>
    </br>
    </br>
    <table style="width:100%">
        <tbody>
            <tr>
              <td>
                <h4>Billing Cycle History</h4></td>
                <td>
                    <h4>Gateway Fees</h4>
                    <table>
                        <thead>
                            <tr>
                                <th >Start Date</th>
                                <th >End Date</th>
                                <th >Company Name</th>
                                <th >Setup</th>
                                <th >Monthly</th>
                                <th >Transaction Fee</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Voicesave Fees</h4>
                    <table>
                        <thead>
                            <tr>
                                <th >Start Date</th>
                                <th >End Date</th>
                                <th >Setup</th>
                                <th >Monthly</th>
                                <th >Per Merchant Call</th>
                                <th >Per Minute
                                    <br>Customer Call</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </td>
                <td>
                    <h4>WatchMeClick Fees</h4>
                    <table>
                        <thead>
                            <tr>
                                <th >Start Date</th>
                                <th >End Date</th>
                                <th >Setup Fee</th>
                                <th >Monthly Fee</th>
                                <th >Session Fee</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>Bank Fees</h4>
                    <table>
                        <thead>
                            <tr>
                                <th >Start Date</th>
                                <th >End Date</th>
                                <th >Company Name</th>
                                <th >Transaction
                                    <br>Fee</th>
                                <th >Authorization
                                    <br>Fee</th>
                                <th >Capture
                                    <br>Fee</th>
                                <th >Sale
                                    <br>Fee</th>
                                <th >Decline
                                    <br>Fee</th>
                                <th>efund
                                    <br>Fee</th>
                                <th >Chargeback
                                    <br>Fee 1</th>
                                <th >Chargeback
                                    <br>Fee 2</th>
                                <th >Chargeback
                                    <br>Threshold</th>
                                <th >Discount
                                    <br>Rate</th>
                                <th >AVS Premium</th>
                                <th >CVV Premium</th>
                                <th >Interregional
                                    <br>Premium</th>
                                <th >Wire
                                    <br>Fee</th>
                                <th>eserve
                                    <br>Rate</th>
                                <th>eserve
                                    <br>Period
                                    <br>(Months)</th>
                                <th >Initial
                                    <br>Reserve</th>
                                <th >Setup
                                    <br>Fee</th>
                                <th >Monthly
                                    <br>Fee</th>
                                <th >miscsetup_name</th>
                                <th >miscmonthly_one_name</th>
                                <th >miscmonthly_two_name</th>
                                <th >misctrans_one_name</th>
                                <th >misctrans_two_name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    
</div>
</div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?>