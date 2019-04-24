<?php
require_once('header.php');
?>  
<div class="row  border-bottom white-bg dashboard-header">
    <div id="transactionsreports" style="height: 449px; width: 1697.40000152588px;" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
    <form method="post" id="transform" name="transform" ,="" action="https://secure.profitorius.com/cgi-bin//Reports.pl">
        <table>
            <tbody>
                <tr>
                    <td>
                        <fieldset>
                            <legend>Filters</legend>
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="vertical-align:top">
                                            <fieldset>
                                                <legend>Date Range</legend>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Period Start Date</td>
                                                            <td>
                                                                <input id="tsdatepicker" name="tsdatepicker" type="text" style="width: 120px" maxlength="10" readonly="true" class="hasDatepicker">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Period End Date</td>
                                                            <td>
                                                                <input id="tedatepicker" name="tedatepicker" type="text" style="width: 120px" maxlength="10" readonly="true" class="hasDatepicker">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="radio" name="date_tbu" value="settlement">Use settlement date</td>
                                                            <td>
                                                                <input type="radio" name="date_tbu" value="transaction" checked="checked">Use transaction date</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                            <br>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Transaction Type</td>
                                                        <td>
                                                            <select name="action_type" id="action_type">
                                                                <option value="all">All</option>
                                                                <option value="auth">Authorizations</option>
                                                                <option value="capture">Captures</option>
                                                                <option value="sale">Sales</option>
                                                                <option value="refund">Refunds</option>
                                                                <option value="void">Voids</option>
                                                                <option value="settle">Settle</option>
                                                                <option value="authcapture">Authorizations and Captures</option>
                                                                <option value="authcapturerefund">Authorizations, Captures and Refunds</option>
                                                                <option value="salerefund">Sales and Refunds</option>
                                                                <option value="allcb">All Chargebacks</option>
                                                                <option value="visa_cb">Visa Chargebacks</option>
                                                                <option value="mc_cb">MC Chargebacks</option>
                                                                <option value="CUP">China Union Pay Chargebacks</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Transaction Status</td>
                                                        <td>
                                                            <select name="success" id="success">
                                                                <option value="-1" selected="selected">All</option>
                                                                <option value="0">Failed</option>
                                                                <option value="1">Succeeded</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Transaction ID</td>
                                                        <td>
                                                            <input type="text" name="ftrans_id" id="ftrans_id">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Order ID</td>
                                                        <td>
                                                            <input type="number" name="forder_id" id="forder_id">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bank Transaction ID</td>
                                                        <td>
                                                            <input type="text" name="btrans_id" id="btrans_id">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <fieldset>
                                                <legend>Amount Range</legend>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Minimum</td>
                                                            <td>
                                                                <input type="text" name="min_amt" id="min_amt">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Maximum</td>
                                                            <td>
                                                                <input type="text" name="max_amt" id="max_amt">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Customer</legend>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>First Name</td>
                                                            <td>
                                                                <input type="text" name="fname" id="fname">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Last Name</td>
                                                            <td>
                                                                <input type="text" name="lname" id="lname">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone</td>
                                                            <td>
                                                                <input type="text" name="phone" id="phone">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>
                                                                <input type="text" name="email" id="email">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Last 4 digits of
                                                                <br>credit card number</td>
                                                            <td>
                                                                <input type="text" name="ccnum" id="ccnum">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customer IP address</td>
                                                            <td>
                                                                <input type="text" name="ipadd" id="ipadd">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <form method="post" id="transform" name="transform" ,="" action="https://secure.profitorius.com/cgi-bin//trans.dwnld.pl" target="_blank">
        <input type="hidden" name="mid" id="mid" value="1">
        <input type="submit" name="dwnld" id="dwnld" value="Download Transactions" style="width:250px" class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">
    </form>
</div>
</div>
            
<?php
require_once('footerjs.php');
?>
<?php
require_once('footer.php');
?>
