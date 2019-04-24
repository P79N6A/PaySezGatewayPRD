<?php error_reporting( E_ALL ); ?>
<?php
require_once('header.php');
global $db;

if($_SESSION['user_type'] === 6)
    include_once('forbidden.php');

require_once('api/merchant_addupdate_api.php');

$log_path = '/var/www/html/testspaysez/api/merchantslogs.log';

date_default_timezone_set('Asia/Kolkata');

function poslogs($log) {
          GLOBAL $log_path;
          $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
          return $myfile;     
  }

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7) {
 ?>
  <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5> CHANGE TERMINAL STATUS</h5>&nbsp;&nbsp;
                        <?php
                        /**** Terminal Status Update ****/
                         if(isset($_SESSION['descrtn'])) {
                            echo "-&nbsp;&nbsp;";
                            echo $_SESSION['descrtn'];
                            unset($_SESSION['descrtn']);
                          }
                         if(isset($_POST['submit'])) {
                               $db->where("mer_map_id", $_POST['pg_merchant_id']);
                               $merchDet = $db->getOne('merchants');
                               $results = terminaladdupdatestatus($_POST, $_POST['pg_terminal_action'],$merchDet['idmerchants']);
                               $results += array("user" => $_SESSION['username']);
                               $results_enc = json_encode($results);
                               $results_dec = json_decode($results_enc);
                               $_SESSION['descrtn'] = $results_dec->ResponseDesc;
                               if($_SESSION['descrtn']!='') {
                                  $logs = "Terminal Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
                                  poslogs($logs);
                             }
                             header('Location: ' . $_SERVER['PHP_SELF']);
                          }
                    ?>
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

                               //$db->where("am_status",0);
                                 $db->orderBy("mer_map_id","asc");
                                 $merchantDet = $db->get("merchants");
                             ?>

                            <form action=""  method="POST" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3  mrb-15">
                                            <!-- <label>Merchant ID</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_id" id="pg_merchant_id">
                                         </div> -->

                                          <label>Merchant_Id</label><BR>
                                          <select name="pg_merchant_id" class="form-control" id="merchantid">
                                                <option value="">Select</option>
                                                    <?php
                                                     foreach ($merchantDet as $key => $value) {
                                                     echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>';
                                                    }
                                                    
                                                    ?>
                                           </select>
                                        </div>
                                        <div class="col-sm-3  mrb-15">
                                          <label>Terminal_Id</label><BR>
                                          <select name="pg_terminal_id" class="form-control" id="pg_terminal_id">
                                                  <option value="">-- Terminal ID --</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Terminal_Status</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_status1" readonly id="pg_terminal_status1" value="">
                                        </div>
                                        <div class="ibox-content">
                                         <div class="col-sm-9 col-md-9 col-lg-9">
                                            <div class="view">
                                                <div class="col-sm-3 mrb-15">
                                                    <label>Terminal_Change_Status</label><BR>
                                                        <div>
                                                            <select name="pg_terminal_status" class="form-control" id="pg_terminal_status" >
                                                               <option class="level-0"  value="1" >Active</option>
                                                               <option class="level-1"  value="2" >In-Active</option>
                                                            </select>
                                                        </div>
                                                        <input class="form-control" type="hidden" name="pg_terminal_action" id="pg_terminal_action" value="3">
                                                </div><br>
                                                &nbsp; &nbsp; <input type="submit" name="submit" class="btn btn-warning" value="Submit"><BR>
                                            </div>
                                        </div> <br><br>
                                      <div>
                            </form>
                        </div>
                <?php } ?>
                    </div>


                </div>

            </div>

        </div>
<?php
require_once('footerjs.php'); 
require_once('footer.php'); 
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    
$(document).ready(function(){

        $("#merchantid").change(function(){
          var empty =$(this).val();
           if (!empty) {
                        $('#pg_terminal_id').val('');
                        $('#pg_terminal_status1').val('');
                        $(".view" ).hide(); 
                        $('#pg_terminal_id').empty();
                        var newOption = $('<option value="">-- Terminal ID --</option>');
                         $('#pg_terminal_id').append(newOption);
                          //$('#pg_terminal_status').empty();
                    } 
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'getmerchant'})
                })
                .done(function( msg ) {
                    console.log(msg);
                     //var msg = '<option value="">-- Terminal ID --</option>';
                    $("#pg_terminal_id").html(msg);
                    $('#pg_terminal_status1').val('');
                    $(".view" ).hide(); 


                });
            }
        });

});
$(document).ready(function(){
        $("#pg_terminal_id").change(function(){
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'t_id': $(this).val(), 'type':'terminalstatus'})
                })
                .done(function( msg ) {
                    console.log(msg);
                     //var msg = '<option value="">-- Terminal ID --</option>';
                     //var msg = '<option value="">-- Terminal ID --</option>';
                   if(msg==1) {
                         terminalact="Active";
                         $("#pg_terminal_status1").val(terminalact);
                         $('option[class="level-0"]').hide();
                         $('option[class="level-1"]').show();
                         $('option[class="level-1"]').attr("selected",true);
                         $('option[class="level-0"]').attr("selected",false);
                    } else  {
                            terminalinact="In-Active";
                            $("#pg_terminal_status1").val(terminalinact);
                            $('option[class="level-1"]').hide();
                            $('option[class="level-0"]').show();
                            $('option[class="level-0"]').attr("selected",true);
                            $('option[class="level-1"]').attr("selected",false);
                   }
                });
            }
        });

});

</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#pg_terminal_id").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue==0) {
                     $(".view").hide();
                     $("#pg_terminal_status1").val('');
            } else {
                     $(".view" ).show();  
            }
        });
    }).change();
});
</script>

