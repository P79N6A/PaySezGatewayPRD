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



$log_path = '/var/www/html/revopay/api/merchantslogs.log';

function poslogs($log) {
    GLOBAL $log_path;
    $myfile = file_put_contents($log_path, $log . PHP_EOL, FILE_APPEND | LOCK_EX);   
    return $myfile;     
}

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

    // var_dump(getTransactions($_SESSION['iid']));die();

    // if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';

        if(!empty($env) && $env == 0){
            $omg = 'TEST MODE ENABLED';
        }
    } else { ?>


    <style type="text/css">
        
                    #myModal {
              -webkit-transform: translate3d(0, 0, 0);
            }
    </style>
        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>LIST TERMINAL</h5>

                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->


                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                           $query = "SELECT * FROM merchants INNER JOIN terminal ON merchants.idmerchants = terminal.idmerchants WHERE terminal.flag='0' ORDER BY terminal.id asc";
                           $usersofuser = $db->rawQuery($query);
                           // echo "<pre>";
                           // print_r($usersofuser);
                           // $sec_mer_res2 = $db->get('terminal');
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
                            // } else
                             {
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
                                 .help {
                                    display:  inline-block;
                                    position: relative;
                                }
                                .info-box {
                                    width:    173px;
                                    right:    -170px;
                                }
                                  /* The Modal (background) */
                                  /*.modal {
                                    display: none; /* Hidden by default */
                                    position: fixed; /* Stay in place */
                                    z-index: 1; /* Sit on top */
                                    padding-top: 100px; /* Location of the box */
                                    left: 0;
                                    top: 0;
                                    width: 100%; /* Full width */
                                    height: 100%; /* Full height */
                                    overflow: auto; /* Enable scroll if needed */
                                    background-color: rgb(0,0,0); /* Fallback color */
                                    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                                  }/*

                                  /* Modal Content 
                                  .modal-content {
                                    position: relative;
                                    background-color: #fefefe;
                                    margin: auto;
                                    padding: 0;
                                    border: 1px solid #888;
                                    width: 80%;
                                    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                                    -webkit-animation-name: animatetop;
                                    -webkit-animation-duration: 0.4s;
                                    animation-name: animatetop;
                                    animation-duration: 0.4s
                                  }*/

                                  /* Add Animation 
                                  @-webkit-keyframes animatetop {
                                    from {top:-300px; opacity:0} 
                                    to {top:0; opacity:1}
                                  }

                                  @keyframes animatetop {
                                    from {top:-300px; opacity:0}
                                    to {top:0; opacity:1}
                                  }

                                  /* The Close Button 
                                  .close {
                                    color: white;
                                    float: right;
                                    font-size: 28px;
                                    font-weight: bold;
                                  }

                                  .close:hover,
                                  .close:focus {
                                    color: #000;
                                    text-decoration: none;
                                    cursor: pointer;
                                  }

                                  .modal-header {
                                    padding: 2px 16px;
                                    background-color: #5cb85c;
                                    color: white;
                                  }

                                  .modal-body {padding: 2px 16px;}

                                  .modal-footer {
                                    padding: 2px 16px;
                                    background-color: #5cb85c;
                                    color: white;
                                  }*/
                            </style>
                             <div class="row show-grid">

                                <div class="col-md-16">

                                  <div class="panel panel-primary">

                                    <div class="panel-heading">Terminal Accounts  <div class="frmSearch">
                                        <b> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Search : </b>
                                        <input type="text" id="search-box" name="ter_id" placeholder="Search Terminal ID" style=" background: cadetblue;"/>
                                        <div id="suggesstion-box"></div>
                                      </div>
                                    </div>

                                    <div class="panel-body" id="cnt"></div>
                                    <div class="panel-body" id="already">
                                        <span class="catitem">
                                        </span>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                          <thead>
                                            <tr>

                                              <th><span class="notice"><b>Merchant_ID <br> Merchant_Name</b></span></th>

                                              <th><b>Terminal_ID</b></th>

                                              <th><b>Terminal_IMEI No</b></th>

                                              <th><b>Terminal_Status</b></th>

                                              <th><b>Action</b></th>
                                                        
                                             </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                            foreach($usersofuser as $row0){ 

                                                   if($row0['idmerchants'])  {

                                              $active = $row0['active'] == 1 ? "Active":"In-Active"; ?>

                                              <tr class="gradeX" data-level="1" id="level_1_<?php echo $row0['mer_map_id']; ?>" class="agentuser">
                                               <td class="data"><?php echo $row0['mer_map_id']."<br>".$row0['merchant_name']; ?></td>

                                               <td class="data"><?php echo $row0['mso_terminal_id']; ?></td>

                                               <td class="data"><?php echo $row0['imei']; ?></td>
                                                                         
                                               <td class="data"><?php echo $active; ?></td>

                                               <td class="data">   
                                                
                                                 <input type="button" class = "btn btn-primary btn-xs" value="Details" onclick="window.location.href='terminal_Details.php?m_id=<?php echo base64_encode( json_encode($row0['mso_terminal_id']) ) ?>'" />

                                                 <input type="button" class = "btn btn-primary btn-xs" value="Edit" onclick="window.location.href='terminal_Editdetails.php?m_id=<?php echo base64_encode( json_encode($row0['mso_terminal_id']) ) ?>'" />
                                                
                                                 <button class = "btn btn-primary btn-xs" class="test" data-toggle = "modal" id="<?php echo $row0['mer_map_id']; ?>" onclick="showdetails(this);" data-target="#confirm-submit" name="<?php echo $row0['merchant_name']; ?>"
                                                   value="<?php echo $row0['mso_terminal_id']; ?>"<?php if($active == "Active") { ?> disabled <?php } ?>   > Delete </button> <?php if($active == "Active") { ?> <div class="help"><div class="info-box"> <a href="#" class="close-button">&times;</a> You active Terminal so
                                                  You will not be able to Delete from Terminal Account. </div><a class='help-button' href='#' title="Click to know more">[?]</a></div> <?php } ?>
                                                </td>
                                              </tr>
                                        <?php } } ?> 


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
            <!-- <div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog" 
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
                  //</div> /.modal-content -->
               <!-- </div> --><!-- /.modal-dialog -->
              
            <!-- </div> --><!-- /.modal --> 

            <!-- Modal -->
           <!--  <div class = "modal fade" id = "myModal1" tabindex = "-1" role = "dialog" 
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
                        use a row class -->
                        <!-- <div class='row'>
                          keep the col class by itself
                          <div class='col-md-4'>
                            <div class='form-group'>
                              <label>Name</label>
                              <input id='merchant_name1' type='text' class='form-control' name='merchant_name1'>
                            </div>
                            <div class='form-group'>
                              <label>Currency_code</label>
                              <input id='merchant_currencycode1' type='text' class='form-control' name='merchant_currencycode1'>
                            </div>
                           <div class='form-group'>
                              <label>Address1</label>
                              <input id='merchant_address11' type='text' class='form-control' name='merchant_address11>
                            </div>
                            <div class='form-group>
                              <label>Address2</label>
                              <input id='merchant_address21' type='text' class='form-control' name='merchant_address21'>
                            </div>
                            <div class='form-group'>
                              <label>City</label>
                              <input id='merchant_city1' type='text' class='form-control' name='merchant_city1'>
                            </div>
                            <div class='form-group'>
                              <label>State</label>
                              <input id='merchant_state1' type='text' class='form-control' name='merchant_state1'>
                            </div>
                            <div class='form-group'>
                              <label>Country</label>
                              <input id='merchant_country1' type='text' class='form-control' name='merchant_country1'>
                            </div>
                            <div class='form-group'>
                              <label>Zip_code</label>
                              <input id='merchant_zipcode1' type='text' class='form-control' name='merchant_zipcode1'>
                            </div>
                            <div class='form-group'>
                              <label>phone</label>
                              <input id='merchant_phone1' type='text' class='form-control' name='merchant_phone1' >
                            </div>
                            <div class='form-group'>
                              <label>Email_id</label>
                              <input id='merchant_emailid1' type='text' class='form-control' name='merchant_emailid1'>
                            </div>
                            <div class='form-group'>
                              <label>Merchant_id</label>
                              <input id='merchant_id1' type='text' class='form-control' name='merchant_id1'>
                            </div>
                            <div class='form-group'>
                              <label>Mcc</label>
                              <input id='merchant_mcc1' type='text' class='form-control' name='merchant_mcc1' >
                            </div>
                           </div>
                          </div>
                        </form>
                     </div>         

                     
                     <div class = "modal-footer">
                        <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                           Close
                        </button>
                        
                        <button type = "button" class = "btn btn-primary">
                           Submit changes
                        </button>
                     </div>
                     
                  </div>
                   -->
                   <!-- /.modal-content -->
               </div><!-- /.modal-dialog -->
              
            </div><!-- /.modal --> 

          <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                Confirm Submit
                 </div>
                <div class="modal-body">
                  Are you sure you want to submit the following details?<br>
                  <!-- input type="text" name="merchant_name" readonly id="merchant_name"> -->
                  <input type="hidden" name="merchant_name1" id="merchant_name1">
                  <input type="hidden" name="terminal_id" id="terminal_id1">
                  <p> Merchant Name:  &ensp;<span id="merchant_name"></span> and Terminal Id: &ensp;<span id="terminal_id"></span> </p>
                  <!-- We display the details entered by the user here -->
                  <!-- <table class="table">
                      <tr>
                          <th>Last Name</th>
                          <td id="lname"></td>
                      </tr>
                      <tr>
                          <th>First Name</th>
                          <td id="fname"></td>
                      </tr>
                  </table> -->

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <a href="#" id="submit" class="btn btn-success success" onclick="submitDelete()">Submit</a>
                 </div>
               </div>
              </div>
            </div>

        <?php

    }

}
    

require_once('footerjs.php'); ?>


<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>


<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<!-- <script src = "https://code.jquery.com/jquery-1.10.2.js"></script> -->
<!-- <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->


<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>


<script>

// jquery

// $(document).ready(function($){

//   $('.help-button').on('click', function(e){
//     e.preventDefault();
//     $(this).siblings('.info-box').show();
//   });

//   $('.close-button').on('click', function(e){
//     e.preventDefault();
//     $(this).parents('.info-box').hide();
//   });
// });


function merchant() {
  var pg_merchant_id=document.getElementById('pg_merchant_id').value;
  var pg_merchant_name=document.getElementById('pg_merchant_name').value;
  var pg_merchant_start_date=document.getElementById('pg_merchant_start_date').value;
  var pg_merchant_city=document.getElementById('pg_merchant_city').value;
  var pg_merchant_state=document.getElementById('pg_merchant_state').value;
  var pg_merchant_country=document.getElementById('pg_merchant_country').value;
  var pg_merchant_postalcode=document.getElementById('pg_merchant_postalcode').value;
  var pg_merchant_phone=document.getElementById('pg_merchant_phone').value;
  var pg_merchant_email=document.getElementById('pg_merchant_email').value;
  var pg_merchant_mcc=document.getElementById('pg_merchant_mcc').value;
  var pg_ifsccode=document.getElementById('pg_ifsccode').value;
  var pg_accountno=document.getElementById('pg_accountno').value;

    var e = document.getElementById("pg_merchant_status");
    var pg_merchant_status = e.options[e.selectedIndex].value;
  //var pg_merchant_status=document.getElementById('pg_merchant_status').value;

    // var e1 = document.getElementById("pg_merchant_action");
    // var pg_merchant_action = e1.options[e1.selectedIndex].value;

    var e2 = document.getElementById("pg_merchant_currency");
    var pg_merchant_currency=e2.options[e2.selectedIndex].value;
  
  if(pg_merchant_id == "") {
      swal('Please Enter the Merchant_Id');
      return false
    } 

    if(pg_merchant_id != "") {
        $.ajax({
            url: "php/inc_reportsearch1.php",
            data: {
                'merchant_id' : pg_merchant_id
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                console.log(data.result);
                if(data.result == true) {
                    swal('Merchant ID Already Exists');
                }
            },
            error: function(data){
                //error
            }
        });
        // return false;
    }

  if(pg_merchant_name == "") {
      swal('Please Enter the Merchant_Name');
      return false
    }   
  if(pg_merchant_start_date == "") {
      swal('Please Enter the Merchant_Start_Date');
      return false
    }  
  if(pg_merchant_city == "") {
      swal('Please Enter the Merchant_City');
      return false
    }  
  if(pg_merchant_state == "") {
      swal('Please Enter the Merchant_State');
      return false
    }   
  if(pg_merchant_country == "") {
      swal('Please Enter the Merchant_Country');
      return false
    }  
  if(pg_merchant_postalcode == "") {
      swal('Please Enter the Merchant_Postalcode');
      return false;
    }  
  
    if(!(/^[0-9]+$/.test(document.getElementById('pg_merchant_postalcode').value))) {
      swal(" Merchant_Postalcode contains only number!");
        return false;
    }

  if(pg_merchant_phone == "") {
    swal('Please Enter the  Merchant_Phone');
    return false;
    }

    if(!(/^[0-9]+$/.test(document.getElementById('pg_merchant_phone').value))) {
        swal(" Merchant_Phone contains only number!");
        return false;
    }

  if(pg_merchant_phone.length != 12) {
    swal(' Merchant_Phone should be of length 12');
    return false;
    }  
  if(pg_merchant_email == "")  {
      swal('Please Enter the Merchant_Email');
      return false;
    }  
    
    if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById('pg_merchant_email').value))) {
        swal("invalid Mail format!");
        return false;
    }

  if(pg_merchant_mcc == "")  {
    swal('Please Enter the Merchant_Mcc');
    return false
    }

    if (!(/^[0-9]+$/.test(document.getElementById('pg_merchant_mcc').value)))   {
        swal(" Merchant_Mcc contains only number!");
        return false;
    }

  if(pg_ifsccode == "") {
      swal('Please Enter the ifsccode');
      return false
    } 
  if(pg_accountno == "")  {
      swal('Please Enter the Accountno');
      return false
    }

    if(pg_merchant_currency == 0)  {
        swal('Please Select the Currency');
        return false
    }

  if(!(/^[0-9]+$/.test(document.getElementById('pg_accountno').value)))  {
        swal(" Accountno contains only number!");
        return false;
    }

  if(pg_merchant_status == 0)  {
    swal('Please Enter the Merchant_Status');
    return false
    } 
    // if(pg_merchant_action == 0)  {
    // swal('Please Enter the Merchant_Action');
    // return false
    // }

}
</script>

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

    function callQueryapi() {
        $.ajax({
            method: "POST",
            url: "alipayapi.php",
            data: {action: '7' }
        })
            .done(function (msg) {
                if(msg==1)
                    location.reload();
                else
                    alert("All Transactions are up to date");
            });
    }
  $(function() {
            $("#tooltip-1").tooltip();
            $("#tooltip-2").tooltip();
  });

    $(document).ready(function(){

      $('.info-box').hide();
        $('.date-sec .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            dateFormat: 'yyyy-mm-dd',
            autoclose: true
        });

        var mid_1 = '<?php echo $mid; ?>';
        // alert(mid_1);

        $.ajax({

            method: "POST",

            url: "php/inc_dailyreport.php",

            data: { mid: mid_1 }

        })

            .done(function( msg ) {

                $("#dailyreport").html(msg);

            });

        $('#date').datepicker({

            todayBtn: "linked",

            keyboardNavigation: false,

            forceParse: false,

            calendarWeeks: true,

            autoclose: true

        });

        $("#date").change(function () {

            $.ajax({

                method: "POST",

                url: "php/inc_dailyreport.php",

                data: { date: $(this).val() }

            })

                .done(function( msg ) {

                    $("#dailyreport").html(msg);

                    $("#exportlink").attr("href", "phpexcel/report.php?date="+$("#date").val());

                });

        });

        var table1 = $('#table1').tabelize({

            /*onRowClick : function(){

             alert('test');

             }*/

            fullRowClickable : true,

            onReady : function(){

                console.log('ready');

            },

            onBeforeRowClick :  function(){

                console.log('onBeforeRowClick');

            },

            onAfterRowClick :  function(){

                console.log('onAfterRowClick');

            },

        });



        //$('#table1 tr').removeClass('contracted').addClass('expanded l1-first');

    });


    $(document).ready(function(){

  $("div#cnt").hide();

  $("#search-box").keyup(function() {
    console.log($(this).val().length);
    if($(this).val().length > 0) {
      $("div#already").hide();
      $("div#cnt").show();
    } else {
      $("div#already").show();
      $("div#cnt").hide();
    }
    $.ajax({
      type: "POST",
      url: "php/inc_merchant_search.php",
      data:'keyword1='+$(this).val()+'&usertype='+<?php echo $usertype; ?>,
      // beforeSend: function(){
      //  $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
      // },
      success: function(msg) {
        console.log(msg);

        $("#cnt").html(msg);
        if(msg.slice(0,21) == 'No Transactions Found') {
          $("#exportlink_date").hide();
          } else {
          $("#exportlink_date").show();
          }
        $('.dataTables-example').dataTable({
          destroy: true,
          "order": [[ 0, "asc" ]],
          responsive: true,
          "dom": 'T<"clear">lfrtip',
          "tableTools": {
            "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
          }
        });
        $('input:checkbox').change(function(){ 
          if($(this).attr('id') == 'selectall') 
          {
            jqCheckAll2( this.id);
          }
        });

       // $('.info-box').hide();
        // $("#suggesstion-box").show();
        // $("#suggesstion-box").html(data);
        // $("#search-box").css("background","#FFF");
      }
    });
    var table2 = $('#table2').tabelize({
      fullRowClickable : true,
      onReady : function(){
        console.log('ready');
      },
      onBeforeRowClick :  function(){
        console.log('onBeforeRowClick');
      },
      onAfterRowClick :  function(){
        console.log('onAfterRowClick');
      },
    });
  });

});


$(document).ready(function($){

  $('.help-button').on('click', function(e){
    e.preventDefault();
    $(this).siblings('.info-box').show();
  });

  $('.close-button').on('click', function(e){

    //alert('hi');
    e.preventDefault();
    //alert('hi');
    $(this).parents('.info-box').hide();
  });
});


function codeAddress() {
     //        if(msg.slice(0,21) == 'No Transactions Found') {
          // $("#exportlink_date").hide();
          // } else {
          // $("#exportlink_date").show();
          // }
        $('.dataTables-example').dataTable({
          destroy: true,
          "order": [[ 1, "desc" ]],
          responsive: true,
          "dom": 'T<"clear">lfrtip',
          "tableTools": {
            "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
          }
        });
        $('input:checkbox').change(function(){ 
          if($(this).attr('id') == 'selectall') 
          {
            jqCheckAll2( this.id);
          }
        });

        var s = '';
        var num = isNaN(parseInt(s)) ? 0 : parseInt(s);
        }
  window.onload = codeAddress;

</script>



<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>

<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">



<script type="text/javascript">

    $('.tree').treegrid();

</script>



<!-- ChartJS-->

<script src="js/plugins/chartJs/Chart.min.js"></script>

<script type="text/javascript">

    // $(function () {
    // $(document).ready(function(){


    //     /**** Displaying the number of transactions per month in Line graph format ****/

    //     var lineData = {

    //         labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

    //         datasets: [

    //             {

    //                 label: "Example dataset",

    //                 fillColor: "rgba(26,179,148,0.5)",

    //                 strokeColor: "rgba(26,179,148,0.7)",

    //                 pointColor: "rgba(26,179,148,1)",

    //                 pointStrokeColor: "#fff",

    //                 pointHighlightFill: "#fff",

    //                 pointHighlightStroke: "rgba(26,179,148,1)",

    //                 data: [<?php echo $transCnts; // echo $transactions_data; ?>]

    //             },

    //             {

    //                 label: "Example dataset",

    //                 fillColor: "rgba(255,133,0,0.5)",

    //                 strokeColor: "rgba(255,133,0,1)",

    //                 pointColor: "rgba(255,133,0,1)",

    //                 pointStrokeColor: "#fff",

    //                 pointHighlightFill: "#fff",

    //                 pointHighlightStroke: "rgba(255,133,0,1)",

    //                 data: [<?php // echo $transAmts; // echo $chargebacks_data; ?>]

    //             }

    //         ]

    //     };



    //     var lineOptions = {

    //         scaleShowGridLines: true,

    //         scaleGridLineColor: "rgba(0,0,0,.05)",

    //         scaleGridLineWidth: 1,

    //         bezierCurve: true,

    //         bezierCurveTension: 0.4,

    //         pointDot: true,

    //         pointDotRadius: 4,

    //         pointDotStrokeWidth: 1,

    //         pointHitDetectionRadius: 20,

    //         datasetStroke: true,

    //         datasetStrokeWidth: 2,

    //         datasetFill: true,

    //         responsive: true,

    //     };

    //     var ctx = document.getElementById("lineChart").getContext("2d");

    //     var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    // });

    /**** Daily Summary Report for selecting date from picker ****/
    $('#date').on("change", function () {
        // alert($(this).val());
        var selected_date = $(this).val();
        if(selected_date!='') {
            $('.rlt_row').show();
        }

        $.ajax({
            method: "POST",
            url: "php/inc_<?php echo $search_type; ?>search.php",
            data: {S_Date: selected_date}
        })
            .done(function( msg ) {
                $("#cbresults").html(msg);
                $('.dataTables-example').dataTable({
                    "order": [[ 1, "desc" ]],
                    responsive: true,
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                    }
                });
                $('input:checkbox').change(function() {
                    if($(this).attr('id') == 'selectall') {
                        jqCheckAll2( this.id);
                    }
                });
                function jqCheckAll2( id ) {
                    $("INPUT[type='checkbox']").attr('checked', $('#' + id).is(':checked'));
                }

                $("#exportlink_date").attr("href", "php/inc_transsearch.php?date="+selected_date);
            });

    });

    /**** Sparkline Graph jquery ****/
    $('.sparkline').sparkline('html', { enableTagOptions: true });

    $('.sparkline_1').sparkline('html', { enableTagOptions: true });

    // $(window).on('resize', function() {
    //  $('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>



<script type="text/javascript">
function submitDelete(){
     /* when the submit button in the modal is clicked, submit the form */
    //alert('submitting');
    var mer_id = $('#merchant_name1').val();
    var ter_id = $('#terminal_id1').val();
    $('.modal').modal('hide');
    // alert(mer_id);
    // alert(ter_id);
     //$('#mer_map_id').val($(this).data('prod-id'));
     $.ajax({
        url: "php/inc_reportsearch1.php",
        data: JSON.stringify({'m_id':mer_id,'t_id': ter_id,'type':'getterminaldetele'}),
        type: 'POST',
        success: function(data) {
          $('.modal').modal('hide');
           swal("Deleted!", "It was succesfully deleted!", "success").then(function(){
              location.reload();
            });
        },
        error: function(data){
            //error
        }
    });
    //$('#formfield').submit();
    }

  function showdetails(button) {
    //alert($('#pg_merchant_id').val());
    // ajax request
    var ter_id = button.value;
    var mer_name = button.name;
    var mer_id = button.id;
    // alert(ter_id);
    // alert(mer_name);
    
    $('#merchant_name').text(mer_name);
    $('#merchant_name1').val(mer_id);
    $('#terminal_id').text(ter_id);
    $('#terminal_id1').val(ter_id);

    //document.getElementById("merchant_name").innerHTML = mer_id;
  }

</script>





<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

