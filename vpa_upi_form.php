<?php
/**
 * Created by PhpStorm.
 * User: GCCOE_01
 * Date: 24-04-2018
 * Time: 05:15 PM
 */
require_once('header.php');

if($_SESSION['user_type'] === 6)
    include_once('forbidden.php');

require_once('php/inc_agents_tree.php');

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$user_id=$_SESSION['iid'];
$event="view";
$auditable_type="CORE PHP AUDIT";
$new_values="";
$old_values="";
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent= $_SERVER['HTTP_USER_AGENT'];
audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip, $user_agent);

$search_type = 'trans';

require_once('api/merchant_addupdate_api.php');

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

    // var_dump(getTransactions($_SESSION['iid']));die();

    // if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';

        if(!empty($env) && $env == 0){
            $omg = 'TEST MODE ENABLED';
        }
    } else { ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>CREATE VPA </h5>

                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                                $db->where("upi_status",'0');
                                $db->orderBy("mer_map_id","asc");
                                $merchantDet = $db->get("merchants");
                                $count_query = "SELECT COUNT(upi_status) FROM merchants WHERE upi_status != NULL";
                                $count = $db->rawQuery($count_query);
                                foreach ($count as $key => $value) {
                                    $count_val=$value;
                                }
                             ?>
                            <style>
                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                            </style>
                            <form method="POST">
                               <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <label>Merchant </label><BR>
                                                <select name="merchantid" class="form-control" id="merchantid">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($merchantDet as $key => $value) {
                                                        echo '<option value="'.$value['merchant_name'].'">'.$value['merchant_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                             </div>
                                    </div><br><br>
                            </form>
                             <div id="merchant_form">
                               <form id="form1" action="vpa_request.php" autocomplete="off" method="POST"  style="display: none;">
                                <input type="hidden" name="vendorId" id="vendorId" value="">
                                <input type="hidden" name="mer_id" id="mer_id" value="">

                                 <div class="row">
                                    <span>
                                    <div class="col-sm-12">
                                        <div class="col-sm-3 mrb-15">
                                            <label>TxnId</label><BR>
                                            <input class="form-control" type="text" readonly  name="txnId" id="txnId" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>TxnOrigin</label><BR>
                                            <input class="form-control" type="text" readonly required  name="txnOrigin" id="txnOrigin" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>MobileNumber</label><BR>
                                            <input class="form-control" type="text" name="mobileNumber" required id="mobileNumber" readonly value="">
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>FirstName</label><BR>
                                            <input class="form-control" type="text" readonly name="firstName" id="firstName" required value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>LastName</label><BR>
                                            <input class="form-control" type="text" readonly name="lastName" id="lastName" required value="">
                                        </div>
    
                                        <div class="col-sm-3 mrb-15">
                                            <label>MerchantVaddr</label><BR>
                                            <input class="form-control" type="text" name="merchantVaddr" id="merchantVaddr" readonly value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>MCC</label><BR>
                                            <input class="form-control" type="text" readonly name="mcc" id="mcc"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Email</label><BR>
                                            <input class="form-control" type="text" readonly name="email" id="email"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>PanNo</label><BR>
                                            <input class="form-control" type="text" readonly name="panNo" id="panNo"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>AadhaarNo</label><BR>
                                            <input class="form-control" type="text" readonly name="aadhaarNo" id="aadhaarNo" value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>AddressDetails</label><BR>
                                            <input class="form-control" type="text" name="addressDetails"  value="" id="addressDetails" readonly required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>AccountNumber</label><BR>
                                            <input class="form-control" type="text" name="accountNumber" id="accountNumber" readonly value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>City</label><BR>
                                            <input class="form-control" type="text" readonly name="city" id="city"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>State</label><BR>
                                            <input class="form-control" type="text" readonly name="state" id="state"  value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Country</label><BR>
                                            <input class="form-control" type="text" readonly name="country" id="country" value="" required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Zipcode</label><BR>
                                            <input class="form-control" type="text" readonly name="zipcode" id="zipcode" value="" required>
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>AccountType</label><BR>
                                            <input class="form-control" type="text" name="accountType" id="accountType" value="" readonly  required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>IFSC</label><BR>
                                            <input class="form-control" type="text" name="ifsc" id="ifsc" value="" readonly  required>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Req Type</label><BR>
                                            <input class="form-control" type="text" name="reqType" id="reqType" readonly value="" required>
                                        </div>
                                        <!-- <div class="col-sm-3 mrb-15">
                                            <label>Merchat Action</label><BR>
                                            <select name="pg_merchant_action" class="form-control"  id="pg_merchant_action">
                                                <option value="0">Action</option>
                                                <option value="1">Add</option>
                                                <option value="2">Update</option>
                                                <option value="3">Status</option>
                                            </select>
                                        </div> -->
                                        
                                    </div>
                                </div>
                                &nbsp; &nbsp; <input type="submit" class="btn btn-warning" value="Submit"><BR>
                                <br><br>
                            </span>
                            </form>
                                

                             </div>
                            <?php } ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php


} elseif($usertype == 6) {

    echo 'show virtual terminal';

    ajax_redirect('/virtualterminal.php');

} else {

    echo '<a href="login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>


<script src="js/plugins/jquery-ui/jquery-ui.min.js">
    

 
</script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script> -->

<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"> -->
 <!-- </script> -->

<!-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.js"></script> -->

<script>

//// jquery
 // $('#pg_merchant_id').on('change', function() {
//     // alert($('#pg_merchant_id').val());
//     // ajax request
//     var merchantVaddr = $('#merchantVaddr').val();
//     $.ajax({
//         url: "php/inc_reportsearch1.php",
//         data: {
//             'merchantVaddr' : merchantVaddr
//         },
//         type: 'POST',
//         dataType: 'json',
//         success: function(data) {
//             // console.log(data);
//             console.log(data.result);
//             if(data.result == true) {
//                 swal('Merchant ID '+merchantVaddr+' Already Exists');
//                 $("#merchantVaddr").val("");
//             }
//         },
//         error: function(data){
//             //error
//         }
//     });
// });

 $(document).ready(function(){
    $("#merchantid").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue==""){
                 $("#form1").hide();
            } else{
                $("#form1" ).show();
               
            }
        });
    }).change();
});


</script>
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>

<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    

<!-- <script src="https://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script> -->


<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>

<script>
    
$(document).ready(function(){

        $("#merchantid").change(function(){
            if($(this).val()){
               var value=$(this).val();
               console.log(value);
                if(value==""){
                 $("#form1").hide();
                }
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'merchantupi'})
                })
                .done(function( msg ) {
                    console.log(msg);
                    //$("#merchant_form").html(msg);
                    $('#form1').show();
                    console.log(msg);
                    var obj = JSON.parse(msg);
                    $('#txnId').val(obj.txnid);
                    var taxorigin=obj.txnorigin;
                    if(taxorigin){
                    var taxorigin = taxorigin.substr(0,3).toUpperCase();
                    }
                    $('#txnOrigin').val(taxorigin);
                    $('#mobileNumber').val(obj.mobile_number);
                    $('#firstName').val(obj.first_name);
                    $('#lastName').val(obj.last_name);
                    $('#merchantVaddr').val(obj.merchant_vaddr);
                    $('#mcc').val(obj.mcc);
                    $('#email').val(obj.email);
                    $('#addressDetails').val(obj.address_details);
                    $('#city').val(obj.city);
                    $('#state').val(obj.state);
                    $('#country').val(obj.country);
                    $('#zipcode').val(obj.pincode);
                    $('#accountType').val(obj.account_type);
                    //var account_type=obj.account_type;
                    //var formObj = account_type;
                    //$("#accountType").filter(function() {
                    //may want to use $.trim in here
                    //return $(this).text() == account_type; 
                    //}).prop('selected', true);
                    $('#panNo').val(obj.pan_no);
                    $('#aadhaarNo').val(obj.aadhaar_no);
                    $('#accountNumber').val(obj.account_number);
                    $('#ifsc').val(obj.ifsc);
                    $('#mer_id').val(obj.mer_map_id);
                    $('#vendorId').val(obj.vendor_id);
                    $('#reqType').val(obj.req_type);
                });
            }
        });

});

$.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        var check = false;
        return this.optional(element) || regexp.test(value);
    },
    "Please check your input."
);
$(document).ready(function() {
    //alert("hi");
        // validate signup form on keyup and submit
        $("#form1").validate({
            rules: {
                txnId: { required:true,
                      minlength:1,
                      maxlength:35,
                      regex:/^[a-zA-z0-9]+$/ },
                txnOrigin: { required:true,
                      minlength:1,
                      maxlength:3,
                      regex:/^[a-zA-z0-9]+$/ },
                mobileNumber: { required:true,
                      minlength:1,
                      maxlength:10,
                      regex:/^[0-9]+$/ },
                firstName: { required:true,
                      minlength:1,
                      maxlength:25,
                      regex:/^[a-zA-z0-9]+$/ },
                lastName: { required:true,
                      minlength:1,
                      maxlength:25,
                      regex:/^[a-zA-z0-9]+$/ },
                merchantVaddr: { required:true,
                      minlength:1,
                      maxlength:35,
                      regex:/^[@.a-zA-Z0-9]+$/ },
                mcc: { required:true,
                      minlength:1,
                      maxlength:4,
                      regex:/^[0-9]+$/ },
                panNo: { required:true,
                      minlength:1,
                      maxlength:10,
                      regex:/^[a-zA-z0-9]+$/ },
                aadhaarNo: { required:true,
                      minlength:1,
                      maxlength:12,
                      regex:/^[0-9]+$/ },
                addressDetails: { required:true,
                      minlength:1,
                      maxlength:35,
                      regex:/^[a-zA-z0-9]+$/ },
                accountNumber: { required:true,
                      minlength:1,
                      maxlength:20,
                      regex:/^[0-9]+$/ },
                accountType:"required",
                ifsc: { required:true,
                      minlength:1,
                      maxlength:12,
                      regex:/^[a-zA-z0-9]+$/ },
                reqType:"required",
                },
                 
            messages: {
                txnId:{
                 required: "<font color=red>Please enter your txnId</font>",
                 minlength: "<font color=red>Your txnId must be at least 1 characters long</font>",
                 maxlength: "<font color=red>Your txnId must be at least 35 characters long</font>",
                 regex: "<font color=red>Your txnId must be Alphanumeric</font>"
                },
                 
                txnOrigin:{
                    required:  "<font color=red>Please enter your txnOrigin</font>",
                    minlength: "<font color=red>Your txnOrigin must be at least 1 characters long</font>",
                    maxlength: "<font color=red>Your txnOrigin maximum 3 characters long</font>",
                    regex: "<font color=red>Your txnOrigin must be Alphanumeric</font>"
                },
                mobileNumber:{
                    required: "<font color=red>Please enter your MobileNumber</font>",
                    minlength: "<font color=red>Your MobileNumber must be at least 1 characters long</font>",
                    maxlength: "<font color=red>Your MobileNumber must be at least 10 characters long</font>",
                    regex: "<font color=red>Your MobileNumber must be Numeric</font>"
                },
                 
                firstName: {
                    required: "<font color=red>Please provide a firstName</font>",
                    minlength: "<font color=red>Your firstName must be at least 1 characters long</font>",
                    maxlength: "<font color=red>Your firstName must be at least 25 characters long</font>",
                    regex: "<font color=red>Your firstName must be Alphanumeric</font>"
                },
                lastName: {
                    required: "<font color=red>Please provide a lastName</font>",
                    minlength: "<font color=red>Your lastName must be at least 1 characters long</font>",
                   maxlength: "<font color=red>Your lastName must be at least 25 characters long</font>",
                   regex: "<font color=red>Your lastName must be Alphanumeric</font>"
                },
                merchantVaddr:{
                    required: "<font color=red>Please enter your merchantVaddr address</font>",
                    minlength: "<font color=red>Your merchantVaddr must be at least 1 characters long</font>",
                   maxlength: "<font color=red>Your merchantVaddr must be at least 35 characters long</font>",
                   regex: "<font color=red>Your merchantVaddr must be special characters only “.” and “@” and Alphanumeric</font>"
                },
                mcc:{
                required: "<font color=red>Please enter your mcc </font>",
                minlength: "<font color=red>Your mcc must be at least 1 characters long</font>",
                maxlength: "<font color=red>Your mcc must be at least 4 characters long</font>",
                regex: "<font color=red>Your mcc must be Numeric</font>"
                },
                panNo:{
                required: "<font color=red>Please enter your panNo </font>",
                minlength: "<font color=red>Your panNo must be at least 1 characters long</font>",
                maxlength: "<font color=red>Your panNo must be at least 10 characters long</font>",
                regex: "<font color=red>Your mcc must be Alphanumeric</font>"
                },
                aadhaarNo:{
                required: "<font color=red>Please enter your aadhaarNo </font>",
                minlength: "<font color=red>Your aadhaarNo must be at least 1 characters long</font>",
                maxlength: "<font color=red>Your aadhaarNo must be at least 12 characters long</font>",
                regex: "<font color=red>Your aadhaarNo must be Numeric</font>"
                },
                addressDetails:{
                required: "<font color=red>Please enter your addressDetails </font>",
                minlength: "<font color=red>Your addressDetails must be at least 1 characters long</font>",
                maxlength: "<font color=red>Your addressDetails must be at least 35 characters long</font>",
                regex: "<font color=red>Your addressDetails must be AlphaNumeric</font>"
                },
                accountNumber:{
                required: "<font color=red>Please enter your accountNumber </font>",
                minlength: "<font color=red>Your accountNumber must be at least 1 characters long</font>",
                maxlength: "<font color=red>Your accountNumber must be at least 20 characters long</font>",
                regex: "<font color=red>Your accountNumber must be Numeric</font>"
                },
                accountType:{
                    required:"<font color=red>Please enter your accountType</font>"
                },
                ifsc:{
                required: "<font color=red>Please enter your ifsc </font>",
                minlength: "<font color=red>Your ifsc must be at least 1 characters long</font>",
                maxlength: "<font color=red>Your ifsc must be at least 12 characters long</font>",
                regex: "<font color=red>Your ifsc must be Numeric</font>"
                },
                reqType:{
                    required:"<font color=red>Please select your  reqType</font>"
                }
                 
                //agree: "Please accept our policy"
 
            }
    });
    $('#form1 input').on('keyup blur', function () { // fires on every keyup & blur
        if ($('#form1').valid()) {                   // checks form for validity
            $('button.btn').prop('disabled', false);        // enables button
        } else {
            $('button.btn').prop('disabled', 'disabled');   // disables button
        }
    });
});
</script> 

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script> -->


<!--script src="js/demo/chartjs-demo.js"></script-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<?php require_once('footer.php'); ?>

