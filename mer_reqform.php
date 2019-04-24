<?php
require_once('header.php');
global $db;

if($_SESSION['user_type'] === 6)
	include_once('forbidden.php');

if ($usertype == 1) {

/*if user is supremeuser*/ 
?>
<style type="text/css">
    
 alert {

        height:300;
        weight:300;
    }

  .downright {
  position: absolute;
  down: 8px;
  right: 30px;
  font-size: 18px;
}

</style>
  <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5> MERCHANT REGISTERATION</h5>

                    </div>

                    <div class="ibox-content">
                        <div>
                            <style>


                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                            </style>

                            <?php 
                                $db->where("am_status",0);
                                $db->orderBy("mer_map_id","asc");
                                $merchantDet = $db->get("merchants");
                             ?>

                            <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <label>Merchant Details</label><BR>
                                                <select name="merchantid" class="form-control" id="merchantid">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($merchantDet as $key => $value) {
                                                        echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                             </div>
                                    </div><br><br>
                                </form>

                            <div id="merchant_form">
                                <form id="form1" method="POST" onsubmit="return secmerchant()"  style="display: none;">
                                    <div class="row">
                                    <input class="form-control" type="hidden" name="sign" id="sign" value="">
                                            <input class="form-control" type="hidden" name="_input_charset" id="_input_charset" value="utf-8">
                                        <div class="col-sm-3 mrb-15">
                                            <label>partner</label><BR>
                                            <input class="form-control" type="text"  readonly name="partner" id="partner" value="">
                                        </div>
                                            <input class="form-control" type="hidden" name="service" id="service" value="alipay.overseas.secmerchant.offline.maintain">
                                        <div class="col-sm-3 mrb-15">
                                            <label>secondary_merchant_name</label><BR>
                                            <input class="form-control" type="text" readonly name="secondary_merchant_name" id="secondary_merchant_name" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>secondary_merchant_id</label><BR>
                                            <input class="form-control" type="text" readonly name="secondary_merchant_id" id="secondary_merchant_id" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>store_id</label><BR>
                                            <input class="form-control" type="text"  readonly name="store_id" id="store_id" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>store_name</label><BR>
                                            <input class="form-control" type="text" readonly name="store_name" id="store_name" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>store_country</label><BR>
                                            <input class="form-control" type="text" readonly name="store_country" id="store_country" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>store_address</label><BR>
                                            <input class="form-control" type="text" readonly name="store_address" id="store_address" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>store_industry</label><BR>
                                            <input class="form-control" type="text" readonly name="store_industry" id="store_industry" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>contact_email</label><BR>
                                            <input class="form-control" type="text" readonly name="csemail" id="csemail" value="">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>contact_no</label><BR>
                                            <input class="form-control" type="text" readonly name="csphone" id="csphone" value="">
                                        </div>
                                
                               <input class="form-control" type="hidden" readonly name="req_type" id="req_type" value="am"><BR>
                                &nbsp; &nbsp; <div class="downright"><input type="submit" name="submit" onclick="return validation()" class="btn btn-warning"  value="Submit"></div><BR>
                                <br><br>
                            </form>
                             </div>
                           <?php } ?>
                        </div>

                       </div>
                       
                    </div>

                </div>

            </div>



        </div>


<?php


require_once('footerjs.php'); ?>

<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>




<script type="text/javascript">
    
$(document).ready(function(){

        $("#merchantid").change(function(){
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'gmportal'})
                })
                .done(function( msg ) {
                    $('#form1').show();
                    console.log(msg);
                    var obj = JSON.parse(msg);
                    console.log(obj.merchant_name);
                    $('#secondary_merchant_name').val(obj.merchant_name);
                    $('#partner').val(obj.partner_id);
                    $('#store_address').val(obj.address1);
                    $('#store_country').val(obj.country);
                    $('#store_name').val(obj.merchant_name);
                    $('#store_industry').val(obj.mcc);
                    $('#store_id').val(obj.mer_map_id);
                    $('#secondary_merchant_id').val(obj.mer_map_id);
                    $('#csemail').val(obj.csemail);
                    $('#csphone').val(obj.csphone);
                    $('#sign').val(obj.key_md5);
                    // $("#merchant_form").html(msg);
                 
                });
            }
        });

});

</script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>  

 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
>  


<script>

/* js start */


//  Bind the event handler to the "submit" JavaScript event
function validation() {
    // Get the Login Name value and trim it
     var partner=document.getElementById('partner').value;
     var secondary_merchant_name=document.getElementById('secondary_merchant_name').value;
     var store_id=document.getElementById('store_id').value;

     var store_name=document.getElementById('store_name').value;
     var store_country=document.getElementById('store_country').value;
     var store_address=document.getElementById('store_address').value;
     var store_industry=document.getElementById('store_industry').value;
     var csemail=document.getElementById('csemail').value;
     var csphone=document.getElementById('csphone').value;
    
    if(partner == "") {
            swal('Please Enter the partner');
            return false;
    } 

    if(secondary_merchant_name == "") {
            swal('Please Enter the secondary_merchant_name');
            return false;
    }   
    if(store_id == "") {
            swal('Please Enter the store_id');
            return false;
    }  

    if(store_name == "") {
            swal('Please Enter the store_name');
            return false;
    }  
    if(store_country == "") {
            swal('Please Enter the store_country');
            return false;
    }   
    if(store_address == "") {
        swal('Please Enter the store_address');
        return false;

    }  
    if(store_industry == "") {
            swal('Please Enter the store_industry');
            return false;
    }
    if(csemail == "") {
            swal('Please Enter the csemail');
            return false;
    }
    if(csphone == "") {
            swal('Please Enter the csphone');
            return false;
    }    
}

function secmerchant() {
    $.ajax({
        url:"merchant_reg.php", //the page containing php script
        type: "post", //request type,
        data: $('#form1').serialize(),           
        success:function(response){
         if(response =="Registration Not Success Retry"){
           alert('Registration Not Success Retry');
           alert(response);
        }
        else{
            alert('Registration Success');
            alert(response);
 }
        }
    });
	
}
</script>
<?php require_once('footer.php'); ?>

