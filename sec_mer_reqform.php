<?php
require_once('header.php');
global $db;

if($_SESSION['user_type'] === 6)
	include_once('forbidden.php');

if ($usertype == 1) {

/*if user is supremeuser*/ 
?>
  <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>SECONDARY MERCHANT</h5>

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
                                                <label>Secondary Merchant </label><BR>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                    console.log(msg);
                    $("#merchant_form").html(msg);
                 
                });
            }
        });

});

</script>

<script>

/* js start */
function secmerchant() {
	 var partner=document.getElementById('partner').value;
     var secondary_merchant_name=document.getElementById('secondary_merchant_name').value;
     var store_id=document.getElementById('store_id').value;

	 var store_name=document.getElementById('store_name').value;
	 var store_country=document.getElementById('store_country').value;
	 var store_address=document.getElementById('store_address').value;
	 var store_industry=document.getElementById('store_industry').value;
	
	if(partner == "") {
			alert('Please Enter the partner');
			return false;
    } 

	if(secondary_merchant_name == "") {
			alert('Please Enter the secondary_merchant_name');
			return false;
    }   
	if(store_id == "") {
			alert('Please Enter the store_id');
			return false;
    }  

	if(store_name == "") {
			alert('Please Enter the store_name');
			return false;
    }  
	if(store_country == "") {
			alert('Please Enter the store_country');
			return false;
    }   
	if(store_address == "") {
			alert('Please Enter the store_address');
            return false;
    }  
	if(store_industry == "") {
			alert('Please Enter the store_industry');
			return false;
    }  
    $.ajax({
        url:"sec_merchant_reg.php", //the page containing php script
        type: "post", //request type,
        data: $('#form1').serialize(),           
        success:function(response){
         if(response =='Registration Success'){
            alert(response);
        }
        else{
    alert(response);
 }
        }
    });
	
}
</script>
<?php require_once('footer.php'); ?>

