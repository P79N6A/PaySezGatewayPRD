<?php
require_once('header.php');
?> 
<p>Date: <input type="text" id="datepicker"></p>  
<div class="row  border-bottom white-bg dashboard-header">
    <div class="row show-grid">
        <div class="col-md-2">
            <label>Date Range</label>
            <select class="form-control m-b" name="date_range" id="date_range">
                <option>All</option>
                <option>Last Day</option>
                <option>Last Week</option>
                <option>Last Month</option>
                <option>Last Months</option>
				<option>Last Year</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Processor</label>
            <select class="form-control m-b" name="processor" id="processor">
                <option>All</option>
                <option>Pasta Banks</option>
                <option>RIB</option>
                <option>BIB</option>
                <option>Balticums</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Card Types</label>
            <select class="form-control m-b" name="card_yypes" id="card_types">
                <option>All</option>
                <option>Visa</option>
                <option>Mastercard</option>
                <option>AMEX</option>
                <option>CUP</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Currencies</label>
            <select class="form-control m-b" name="currencies" id="currencies">
                <option>All</option>
                <option>USD</option>
                <option>CAN</option>
                <option>EUR</option>
                <option>GBP</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Transaction Type</label>
            <select class="form-control m-b" name="transaction_type" id="transaction_type">
                <option>Any</option>
                <option>Sale</option>
                <option>Refund/Credit</option>
                <option>Authorize Only</option>
                <option>Capture</option>
				<option>Void</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Recurring</label>
            <select class="form-control m-b" name="recurring" id="recurring">
                <option>All</option>
                <option>1st</option>
                <option>2nd</option>
                <option>3rd</option>
                <option>4th</option>
            </select>
        </div>
		<div class="col-md-2">
            <label>Reseller</label>
            <select class="form-control m-b" name="reseller" id="reseller">
                <option>All</option>
                <option>Bigdog</option>
                <option>TVPS</option>
                <option>EMPSS</option>
                <option>PASPX</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Merchants</label>
            <select class="form-control m-b" name="merchants" id="merchants">
                <option>All</option>
                <option>Vrev</option>
                <option>Clearly</option>
                <option>Fisher</option>
                <option>Purvaida</option>
            </select>
        </div>
		<div class="col-md-2">
            <label>MID</label>
            <select class="form-control m-b" name="mid" id="mid">
                <option>All</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Bin</label>
            <select class="form-control m-b" name="bin" id="bin">
				<option>All</option>
                <option>Top 10</option>
                <option>Top 15</option>
                <option>Top 25</option>
                <option>Top 50</option>
                <option>Top 100</option>
                <option>Top 250</option>
            </select>
        </div>
    </div>
</div>
            
<?php
require_once('footerjs.php');
?>
<?php
require_once('footer.php');
?>
<?php
require_once('header.php');
?> 


    <link href="css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<!--
<p>Date: <input type="text" id="datepicker"></p>  
<div class="row  border-bottom white-bg dashboard-header">
    <div class="row show-grid">
        <div class="col-md-2">
            <label>Date Range</label>
            <select class="form-control m-b" name="date_range" id="date_range">
                <option>All</option>
                <option>Last Day</option>
                <option>Last Week</option>
                <option>Last Month</option>
                <option>Last Months</option>
				<option>Last Year</option>
            </select>
        </div>
    -->    
        
        
        
        
        
        
<div  class="input-group-date">

<lable>Date From:</label>
    <input type="hidden" id="out_inizio" />
    <input type="text" id="data_inizio" />


<lable>Date To:</lable>
    <input type="hidden" id="out_fine" />
    <input type="text" id="data_fine" />
    <p id="out_fine" />
</div>
        
       
        
        
        
     
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <div class="col-md-2">
            <label>Processor</label>
            <select class="form-control m-b" name="processor" id="processor">
                <option>All</option>
                <option>Pasta Banks</option>
                <option>RIB</option>
                <option>BIB</option>
                <option>Balticums</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Card Types</label>
            <select class="form-control m-b" name="card_yypes" id="card_types">
                <option>All</option>
                <option>Visa</option>
                <option>Mastercard</option>
                <option>AMEX</option>
                <option>CUP</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Currencies</label>
            <select class="form-control m-b" name="currencies" id="currencies">
                <option>All</option>
                <option>USD</option>
                <option>CAN</option>
                <option>EUR</option>
                <option>GBP</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Transaction Type</label>
            <select class="form-control m-b" name="transaction_type" id="transaction_type">
                <option>Any</option>
                <option>Sale</option>
                <option>Refund/Credit</option>
                <option>Authorize Only</option>
                <option>Capture</option>
				<option>Void</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Recurring</label>
            <select class="form-control m-b" name="recurring" id="recurring">
                <option>All</option>
                <option>1st</option>
                <option>2nd</option>
                <option>3rd</option>
                <option>4th</option>
            </select>
        </div>
		<div class="col-md-2">
            <label>Reseller</label>
            <select class="form-control m-b" name="reseller" id="reseller">
                <option>All</option>
                <option>Bigdog</option>
                <option>TVPS</option>
                <option>EMPSS</option>
                <option>PASPX</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Merchants</label>
            <select class="form-control m-b" name="merchants" id="merchants">
                <option>All</option>
                <option>Vrev</option>
                <option>Clearly</option>
                <option>Fisher</option>
                <option>Purvaida</option>
            </select>
        </div>
		<div class="col-md-2">
            <label>MID</label>
            <select class="form-control m-b" name="mid" id="mid">
                <option>All</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Bin</label>
            <select class="form-control m-b" name="bin" id="bin">
				<option>All</option>
                <option>Top 10</option>
                <option>Top 15</option>
                <option>Top 25</option>
                <option>Top 50</option>
                <option>Top 100</option>
                <option>Top 250</option>
            </select>
        </div>
    </div>
</div>










    <!-- Mainly scripts -->

    <script src="js/bootstrap.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

   <!-- JSKnob -->
   <script src="js/plugins/jsKnob/jquery.knob.js"></script>

   <!-- Input Mask-->
    <script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

   <!-- Data picker -->
   <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

   <!-- NouSlider -->
   <script src="js/plugins/nouslider/jquery.nouislider.min.js"></script>

   <!-- Switchery -->
   <script src="js/plugins/switchery/switchery.js"></script>

    <!-- IonRangeSlider -->
    <script src="js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Color picker -->
    <script src="js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <!-- Image cropper -->
    <script src="js/plugins/cropper/cropper.min.js"></script>

 
        
        
<script>
$(function () {
    function parseSeconds(stringyDate) {
        var d = new Date(stringyDate),
            s = 0;
        if (stringyDate.length > 0) {
            s = d.valueOf() / 1000;
        }
        return s;
    }
    $("#data_inizio").datepicker({
        altField: '#mod_available_date_id_start',
        altFormat: '@',
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onSelect: function (selectedDate) {
            var d = new Date(selectedDate),
                s = parseSeconds(selectedDate);
            if (s > 0) {
                //display to user
                $('p#out_inizio').text(d.valueOf() + ' divided by 1000 is ' + s);
                //store in hidden field.
                $('input#out_inizio').val(s);
            } else {
                $('p#out_inizio').text('No date selected');
            }
            //set min date on other picker
            $("#data_fine").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#data_fine").datepicker({
        altField: '#mod_available_date_id_finish',
        altFormat: '@',
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onSelect: function (selectedDate) {
            var d = new Date(selectedDate),
                s = parseSeconds(selectedDate);
            if (s > 0) {
                //display to user
                $('p#out_fine').text(d.valueOf() + ' divided by 1000 is ' + s);
                //store in hidden field.
                $('input#out_fine').val(s);
            } else {
                $('p#out_fine').text('No date selected');
            }
            //set min date on other picker
            $("#data_inizio").datepicker("option", "maxDate", selectedDate);
        }
    });
});
</script>


















            
<?php
require_once('footerjs.php');
?>
<?php
require_once('footer.php');
?>
