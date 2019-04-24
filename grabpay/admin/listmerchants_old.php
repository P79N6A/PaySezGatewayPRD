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

// $search_type = 'trans';

// require_once('api/merchant_addupdate_api.php');
// $iid = $_SESSION['iid'];
// $db->where("id",$iid);
// $userDet = $db->getOne('users');


if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7) {

    // var_dump(getTransactions($_SESSION['iid']));die();

    // if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';
        if(!empty($env) && $env == 0) {
            $omg = 'TEST MODE ENABLED';
        }

    } else { 
    ?>
    <style type="text/css">
    #myModal {
    -webkit-transform: translate3d(0, 0, 0);
    }
    </style>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>View Active Merchants</h5>
                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->
                    </div>
                    <div class="ibox-content">
                        <div>
                            <?php
                            $db->where('gp_status','1');
                            $db->where('flag',0);
                            $usersofuser = $db->get('merchants');
                            // if($_POST) {
                            //     // echo "<pre>";
                            //     // print_r($_POST); 
                            //     // exit;
                            //     // require_once('api/alipaymerchantAPI.php');
                            //     // $results = merchantandterminalchecking($_POST);
                            //     $results = merchantaddupdatestatus($_POST, $_POST['pg_merchant_action'],'');
                            //     $results_enc = json_encode($results);
                            //     $results_dec = json_decode($results_enc);
                            //     echo $results_dec->ResponseDesc;
                            //     echo "<br><br>";
                            //     echo "<a href='merchant_add.php'>CREATE ANOTHER MERCHANT</a>";
                            // } else {
                            ?>
                            <style>
                            label {
                                font-weight: bold;
                            }

                            .mrb-15 {
                                margin-bottom: 15px;
                            }

                            @media screen and (max-width: 750px) {
                            tbody, thead { float: left; }
                            thead { min-width: 120px }
                            td,th { display: block }
                            }
                            </style>
                            <div class="row show-grid">

                                    <div class="col-md-12">

                                        <div class="panel panel-primary">

                                                <div class="panel-heading">Merchant Accounts</div>

                                                <div class="panel-body">

                                                     <span class="catitem"></span>

                                                 
                                                     <table border="0" cellpadding="0" cellspacing="6" class="table table-striped">

                                                                <thead>

                                                                    <tr>

                                                                        <th><span class="notice"><b>Merchant_ID</b></span></th>

                                                                        <th><b>Merchant_Name</b></th>

                                                                        <th><b>Merchant_Email</b></th>

                                                                        <th><b>Merchant_Currency</b></th>

                                                                        <th><b>Merchant_Status</b></th>

                                                                        <th><b>Action</b></th>
                                                                    </tr>

                                                                </thead>

                                                            <tbody>
                                                              <?php
                                                                foreach($usersofuser as $row0){ 

                                                                  if($row0['idmerchants']){
                                        
                                                                        ?>
                                                                    <tr class="gradeX" data-level="1" id="level_1_<?php echo $row0['mer_map_id']; ?>" class="agentuser">

                                                                   <!--  <td><a href="editmerchant.php?userid=<?php //echo $row0['id']; ?>"><?php //echo strip_tags( $row0['mer_map_id'] ); ?></td> -->

                                                                      <td class="data"><?php echo $row0['mer_map_id']; ?>
                                                                    </td>

                                                                    <td class="data"><?php echo $merchant_name=$row0['merchant_name']; ?>
                                                                    </td>

                                                                    <td class="data">
                                                                    <?php echo $row0['csemail']; ?>
                                                                    </td>

                                                                    <td class="data">
                                                                     <?php echo $row0['currency_code']; ?>
                                                                    </td>
                                                                         
                                                                    <td class="data">
                                                                    <?php echo $row0['is_active'] == 1 ? 'Active' : 'In-Active'; ?>
                                                                    </td>

                                                                    <td class="data">

                                                                           <!--  <input type="submit" onclick="impersonate('<?php //echo $row0['id']; ?>')" value="Login"> -->
                                                                      <button class = "btn btn-primary btn-xs" data-toggle = "modal" 
                                                                      id="<?php echo $row0['mer_map_id']; ?>" onclick="showdetails(this);" data-target = "#myModal">Details
                                                                      </button>
                                                                          
                                                                      <button class = "btn btn-primary btn-xs" data-toggle = "modal"  id="<?php echo $row0['mer_map_id']; ?>" id="button"
                                                                          onclick="showdetails1(this);" data-target = "#myModal1">Edit
                                                                      </button>

                                                                      <button class = "btn btn-primary btn-xs" data-toggle = "modal" id="button" data-target="#confirm-submit">Delete
                                                                      </button>


                                                                        </td>
                                
                                                                    </tr>

                                                                    <?php  } } 
                                                                    
                                                                    ?> 


                                                        </tbody>

                                                    </table>
                                               </div>
                                            </div>    
                                        </div>
                                    </div>    
                                <!-- </div> -->
                            <!-- <?php } ?> -->
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Modal -->
            <div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog" 
               aria-labelledby = "myModalLabel" aria-hidden = "true">
               
               <div class = "modal-dialog">
                  <div class = "modal-content">
                     
                     <div class = "modal-header">
                        <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                              &times;
                        </button>
                        
                        <h4 class = "modal-title" id = "myModalLabel">
                           Display the Data
                        </h4>
                     </div>
                     
                     <div class = "modal-body">
                      <p>Merchant_Name: <span id="merchant_name"></span></p>
                      <p>Currency_code: <span id="merchant_currencycode"></span></p>
                      <p>Address1: <span id="merchant_address1"></span></p>
                      <p>Address2: <span id="merchant_address2"></span></p>
                      <p>City: <span id="merchant_city"></span></p>
                      <p>State: <span id="merchant_state"></span></p>
                      <p>Country: <span id="merchant_country"></span></p>
                      <p>Zip_code: <span id="merchant_zipcode"></span></p>
                      <p>phone: <span id="merchant_phone"></span></p>
                      <p>Email_id: <span id="merchant_emailid"></span></p>
                      <p>Merchant_id: <span id="merchant_id"></span></p>
                      <p>Mcc: <span id="merchant_mcc"></span></p>
                     </div>         
                  </div><!-- /.modal-content -->
               </div><!-- /.modal-dialog -->
              
            </div><!-- /.modal -->

            <!-- Modal -->
            <div class = "modal fade" id = "myModal1" tabindex = "-1" role = "dialog" 
               aria-labelledby = "myModalLabel" aria-hidden = "true">
               
               <div class = "modal-dialog">
                  <div class = "modal-content">
                     
                     <div class = "modal-header">
                        <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                              &times;
                        </button>
                        
                        <h4 class = "modal-title" id = "myModalLabel">
                           Edit the Data
                        </h4>
                     </div>

                      <div class = "modal-body">

                        <form id='formModal' method='post' action='giocatori.php'>
                        <!-- use a row class -->
                        <div class='row'>
                          <!-- keep the col class by itself -->
                          <div class='col-md-4'>
                            <div class='form-group'>
                              <label>Name</label>
                              <input id='nome_iscrizione' type='text' class='form-control' name='name' value='New name'>
                            </div>
                            <div class='form-group'>
                              <label>Name</label>
                              <input id='nome_iscrizione' type='text' class='form-control' name='name' value='New name'>
                            </div>
                           </div>
                          </div>
                        </form>
                        <table align="center">

                      <tr><td>Merchant_Name:</td> <td><input type="text" name="merchant_name1" id="merchant_name1"></td></tr>
                      <tr><td>Currency_code:</td> <td><input type="text" name="merchant_currencycode1" id="merchant_currencycode1"></td></tr>
                      <tr><td>Address1:</td> <td><input type="text" name="merchant_address11" id="merchant_address11"></td></tr>
                      <tr><td>Address2:</td> <td><input type="text" name="merchant_address21" id="merchant_address21"></td></tr>
                      <tr><td>City:</td> <td><input type="text" name="merchant_city1" id="merchant_city1"></td></tr>
                      <tr><td>State:</td> <td><input type="text" name="merchant_state1" id="merchant_state1"></td></tr>
                      <tr><td>Country:</td> <td><input type="text" name="merchant_country1" id="merchant_country1"></td></tr>
                      <tr><td>Zip_code: </td><td><input type="text" name="merchant_zipcode1" id="merchant_zipcode1"></td></tr>
                      <tr><td>phone:</td> <td><input type="text" name="merchant_phone1" id="merchant_phone1"></td></tr>
                      <tr><td>Email_id:</td> <td><input type="text" name="merchant_emailid1" id="merchant_emailid1"></td></tr>
                      <tr><td>Merchant_id: </td><td><input type="text" name="merchant_id1" id="merchant_id1"></td></tr>
                      <tr><td>Mcc: </td><td><input type="number" name="merchant_mcc1" id="merchant_mcc1"></td></tr>
                      </table>
                     </div>         
                     
                     <div class = "modal-footer">
                        <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                           Close
                        </button>
                        
                        <button type = "button" class = "btn btn-primary">
                           Submit changes
                        </button>
                     </div>
                     
                  </div><!-- /.modal-content -->
               </div><!-- /.modal-dialog -->
              
            </div><!-- /.modal -->

            <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
             <div class="modal-content">
                <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Are you sure you want to submit the following details?

                <!-- We display the details entered by the user here -->
                <table class="table">
                    <tr>
                        <th>Last Name</th>
                        <td id="lname"></td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td id="fname"></td>
                    </tr>
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" id="submit" class="btn btn-success success">Submit</a>
            </div>
               </div>
              </div>
            </div>

        <?php

    // }

} elseif($usertype == 6) {

    echo 'show virtual terminal';

    ajax_redirect('/virtualterminal.php');

} else {

    echo '<a href="testspaysez/login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>



<!-- jQuery library -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>


<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<script>
$(function () { $('#myModal').modal('hide')});
    $('#submitBtn').click(function() {
    /* when the button in the form, display the entered values in the modal */
    $('#lname').text($('#lastname').val());
    $('#fname').text($('#firstname').val());
});

$('#submit').click(function(){
    /* when the submit button in the modal is clicked, submit the form */
    alert('submitting');
    $('#formfield').submit();
});

$(function () { $('#myModal').on('hide.bs.modal', function () {
    alert('you have closed the window');})
});
</script>

<script>
// jquery
function showdetails(button) {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = button.id;
    $.ajax({
        url: "php/inc_reportsearch1.php",
        data: JSON.stringify({'m_id': mer_id, 'type':'getmerchantdetails'}),
        type: 'POST',
        success: function(data) {
            var merchants=JSON.parse(data);
            $('#merchant_name').text(merchants.merchant_name);
            $('#merchant_currencycode').text(merchants.currency_code);
            $('#merchant_address1').text(merchants.address1);
            $('#merchant_address2').text(merchants.address2);
            $('#merchant_city').text(merchants.city);
            $('#merchant_state').text(merchants.us_state);
            $('#merchant_country').text(merchants.country);
            $('#merchant_zipcode').text(merchants.zippostalcode);
            $('#merchant_phone').text(merchants.csphone);
            $('#merchant_emailid').text(merchants.csemail);
            $('#merchant_id').text(merchants.mer_map_id);
            $('#merchant_mcc').text(merchants.mcc);
        },
        error: function(data){
            //error
        }
    });
}

function showdetails1(button) {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = button.id;
    $.ajax({
        url: "php/inc_reportsearch1.php",
        data: JSON.stringify({'m_id': mer_id, 'type':'getmerchantdetails'}),
        type: 'POST',
        success: function(data) {
            var merchants=JSON.parse(data);
            $('#merchant_name1').val(merchants.merchant_name);
            $('#merchant_currencycode1').val(merchants.currency_code);
            $('#merchant_address11').val(merchants.address1);
            $('#merchant_address21').val(merchants.address2);
            $('#merchant_city1').val(merchants.city);
            $('#merchant_state1').val(merchants.us_state);
            $('#merchant_country1').val(merchants.country);
            $('#merchant_zipcode1').val(merchants.zippostalcode);
            $('#merchant_phone1').val(merchants.csphone);
            $('#merchant_emailid1').val(merchants.csemail);
            $('#merchant_id1').val(merchants.mer_map_id);
            $('#merchant_mcc1').val(merchants.mcc);
        },
        error: function(data){
            //error
        }
    });
}

</script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">

<!-- Data picker -->

<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>
<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">
<script type="text/javascript">
    $('.tree').treegrid();
</script>

<!-- ChartJS-->

<script src="js/plugins/chartJs/Chart.min.js"></script>

<script type="text/javascript">

    /**** Sparkline Graph jquery ****/
    $('.sparkline').sparkline('html', { enableTagOptions: true });

    $('.sparkline_1').sparkline('html', { enableTagOptions: true });

    // $(window).on('resize', function() {
    //  $('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

