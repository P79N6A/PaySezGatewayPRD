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

                        <h5>CREATE MERCHANT</h5>

                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->


                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                            $db->where('gp_status','1');
                            $db->where('flag',0);
                            $usersofuser = $db->get('merchants');
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

                                                  <?php } } ?> 

                                                  </tbody>

                                                </table>
                                               </div>
                                            </div> 

                                        </div>

                                    </div>  

                                </div>  
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php

    }

} elseif($usertype == 6) {

    echo 'show virtual terminal';

    ajax_redirect('/virtualterminal.php');

} else {

    echo '<a href="testspaysez/login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); ?>


<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">

<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>

    $('#pg_merchant_start_date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

</script>

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
    // 	$('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

