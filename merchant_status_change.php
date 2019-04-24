<?php

require_once('header.php');

if($_SESSION['user_type'] === 6)
    include_once('forbidden.php');

// require_once('php/inc_agents_tree.php');

// $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $user_id=$_SESSION['iid'];
// $event="view";
// $auditable_type="CORE PHP AUDIT";
// $new_values="";
// $old_values="";
// $ip = $_SERVER['REMOTE_ADDR'];
// $user_agent= $_SERVER['HTTP_USER_AGENT'];
// audittrails($user_id, $event, $auditable_type, $new_values, $old_values,$url, $ip, $user_agent);

// $search_type = 'trans';

require_once('api/merchant_addupdate_api.php');

$log_path = '/var/www/html/testspaysez/api/merchantslogs.log';

?>

<?php
date_default_timezone_set('Asia/Kolkata');

function poslogs($log) {
    GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
}

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

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
                        <h5>CHANGE MERCHANT STATUS</h5>&nbsp;&nbsp;

                        <?php
                        /**** Merchant Status Update ****/
                        if (isset($_SESSION['descrtn'])) {
                            echo "-&nbsp;&nbsp;";
                            echo $_SESSION['descrtn'];
                            unset($_SESSION['descrtn']);
                        }

                        if(isset($_POST['submit'])) {
                            $db->where("mer_map_id", $_POST['pg_merchant_id']);
                            $merchDet = $db->getOne('merchants');
                            $results = merchantaddupdatestatus($_POST, $_POST['pg_merchant_action'],$merchDet['idmerchants']);
                            $results += array("user" => $_SESSION['username']);
                            $results_enc = json_encode($results);
                            $results_dec = json_decode($results_enc);
                            // echo $results_dec->ResponseDesc;
                            $_SESSION['descrtn'] = $results_dec->ResponseDesc;
                            if($_SESSION['descrtn']!='') {
                                $logs = "Merchant Active Log:".date("Y-m-d H:i:s") . "," .json_encode($results). " \n\n";
                                poslogs($logs);
                            }
                            // $_SESSION['descrtn'] = $results_dec->ResponseDesc;
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
                                // $db->where("idmerchants !='' ");
                                $db->orderBy("mer_map_id","asc");
                                $merchantDet = $db->get("merchants");
                             ?>

                            <form action=""  method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3 mrb-15">
                                            <!--<label>Merchant ID</label><BR>
                                            <input class="form-control" type="text" name="pg_merchant_id" id="pg_merchant_id"> -->

                                            <label>Merchant_Id</label><BR>
                                            <select name="pg_merchant_id" class="form-control" id="pg_merchant_id" >
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($merchantDet as $key => $value) {
                                                    echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-3 mrb-15">
                                            <label>Merchant_Status</label><BR>
                                            <input type="text" class="form-control" name="pg_merchant_status1" readonly id="pg_merchant_status1" value="" >
                                        </div>

                                    </div>
                                    <div class="ibox-content">
                                        <div class="view" >
                                            <div class="col-sm-3 mrb-16">
                                            <label>Merchant_Change_Status</label><BR>
        
                                            <select name="pg_merchant_status" class="form-control" id="pg_merchant_status" >
                                                <option class="level-0"  value="1" >Active</option>
                                                <option class="level-1"  value="2" >In-Active</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="pg_merchant_action" id="pg_merchant_action" value="3">
                                        </div><br>
                                        &nbsp; &nbsp; <input type="submit" name="submit" class="btn btn-warning" value="Submit">

                                    </div>
                                </div>
                                                                
                            </form>
                            </div>

                    </div>

                </div>

            </div>

        </div>
<?php
    }
}

?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

 $(document).ready(function(){
    $("#pg_merchant_id").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue==0){
                $("#pg_merchant_status1").val('');
                 $(".view").hide();
            } else{
                $(".view" ).show();
               
            }
        });
    }).change();
});


</script>

<script type="text/javascript">
    
$(document).ready(function(){

        $("#pg_merchant_id").change(function(){

            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'merchantstatus'})
                })
                .done(function(msg) {
                    var merchantstatus;
                   // console.log(msg);
                    if(msg==1)
                        {
                         merchantstatusact="Active";
                        $("#pg_merchant_status1").val(merchantstatusact);
                        $('option[class="level-0"]').hide();
                        $('option[class="level-1"]').show();
                        $('option[class="level-1"]').attr("selected",true);
                        $('option[class="level-0"]').attr("selected",false);
                     } else  {
                         merchantstatusinact="In-Active";
                        $("#pg_merchant_status1").val(merchantstatusinact);
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

