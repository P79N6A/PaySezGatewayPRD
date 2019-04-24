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

//var_dump(getTransactions($_SESSION['iid']));die();

//if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';

        if(!empty($env) && $env == 0){
            $omg = 'TEST MODE ENABLED';
        }
        ?>

        <div id="dailyreport" style="display: none;"></div>

    <?php } else { ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>Add Terminal</h5>

                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                             $db->where('gp_status', "1");
                             $merchant_det = $db->get('merchants');
                            if($_POST) {
                                // echo "<pre>";
                                // print_r($_POST); exit;
                                // include_once ('api/alipaymerchantAPI.php');
                                // merchantaddupdatestatus($_POST, $_POST['pg_merchant_action']);
                                $db->where('mer_map_id', $_POST['pg_merchant_id']);
                                $lastid = $db->getone("merchants");

                                $results = terminaladdupdatestatus($_POST, $_POST['pg_terminal_action'],$lastid['idmerchants']);
                                $results_enc = json_encode($results);
                                $results_dec = json_decode($results_enc);
                                echo $results_dec->ResponseDesc;
                                echo "<br><br>";
                                echo "<a href='terminal_add.php'>CREATE ANOTHER TERMINAL</a>";
                            } else {
                            ?>
                            <style>
                                label {
                                    font-weight: bold;
                                }

                                .mrb-15 {
                                    margin-bottom: 15px;
                                }
                            </style>
                            <form action="terminal_add.php" onsubmit="return terminal()" autocomplete="off" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3  mrb-15">
                                            <label>Merchant ID</label><BR>
                                            <select name="pg_merchant_id" class="form-control" id="pg_merchant_id">
                                                <option value="">Select</option>
                                            <?php
                                                foreach ($merchant_det as $key => $value) {
                                                        echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3  mrb-15">
                                            <label>Grab_Terminal ID</label><BR>
                                            <input class="form-control" type="text" name="grab_terminal_id" id="grab_terminal_id">
                                        </div>
                                        <div class="col-sm-3  mrb-15">
                                            <label>Terminal ID</label><BR>
                                            <input class="form-control" type="text" readonly name="pg_terminal_id" id="pg_terminal_id">
                                        </div>
										<div class="col-sm-3  mrb-15">
                                            <label>Terminal Address</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_address" id="pg_terminal_address"></>
                                        </div>
										<div class="col-sm-3  mrb-15">
                                            <label>Terminal State</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_state"id="pg_terminal_state">
                                        </div>
										<div class="col-sm-3  mrb-15">
                                            <label>Terminal City</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_city" id="pg_terminal_city">
                                        </div>

										<div class="col-sm-3  mrb-15">
                                            <label>Terminal Pincode</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_pincode" id="pg_terminal_pincode">
                                        </div>
                                        <div class="col-sm-3  mrb-15">
                                            <label>Terminal IMEI No</label><BR>
                                            <input class="form-control" type="text" name="pg_terminal_imei" id="pg_terminal_imei">
                                        </div>
                                        <div class="col-sm-3  mrb-15">
                                            <label>Terminal Status</label><BR>
                                            <select name="pg_terminal_status" class="form-control" id="pg_terminal_status" >
                                                <option value="0" selected="selected">Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">In-Active</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="pg_terminal_action" id="pg_terminal_action" value="1">
                                        </div>
                                        <!-- <div class="col-sm-3  mrb-15">
                                            <label>Terminal Action</label><BR>
                                            <select name="pg_terminal_action" class="form-control" id="pg_terminal_action">
                                                <option value="" selected="selected">Action</option>
                                                <option value="1">Add</option>
                                                <option value="2">Update</option>
                                                <option value="3">Status</option>
                                            </select>
                                        </div> -->
                                    </div>
                                </div>
                                &nbsp; &nbsp; <input type="submit" class="btn btn-warning" value="Submit"><BR>
                                <br><br>
                            </form>
                            <?php } ?>
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

    echo '<a href="login.php"> Please Login Again</a>';

}

require_once('footerjs.php'); 
?>

<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">

<script>

    // jquery

// $(document).on('change','#pg_merchant_id',function(){
//          $(this).val();
//                $("#grab_terminal_id").val("");
//                $("#pg_terminal_id").val("");
// });

$(document).ready(function(){ 
  $('#pg_merchant_id').change(function(){ 
   // alert($('#pg_merchant_id :selected').text());
     var mer_id = $('#pg_merchant_id').val();
     $.ajax({
        url: "php/inc_reportsearch1.php",
        data: {
            'merchant' : 'verify',
            'merchant_id' : mer_id,
        },
        type: 'POST',
        success: function(data) {
            // console.log(data);
            console.log(data);
            // if(data.result == true) {
            //     swal('Grab_Terminal ID '+ter_id+' Already Exists');
            //     $("#grab_terminal_id").val("");
            //     $("#pg_terminal_id").val("");
            // }
            //  if (data.ter_id) {
            //     $("#pg_terminal_id").val(data.ter_id);
            // }
        },
        error: function(data){
            //error
        }
    });

  });
});
document.getElementsByTagName('select')[0].onchange = function() {
  var index = this.selectedIndex;
  var inputText = this.children[index].innerHTML.trim();
  //console.log(index);
  if(index=="0") {
     $("#grab_terminal_id").val("");
     $("#pg_terminal_id").val("");

  }
}

$('#grab_terminal_id').on('change', function() {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = $('#pg_merchant_id').val();
    var ter_id = $('#grab_terminal_id').val();
    //console.log(mer_id+"=>"+ter_id);
    $.ajax({
        url: "php/inc_reportsearch1.php",
        data: {
            'merchant_id' : mer_id,
            'grab_terminal_id' : ter_id
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            console.log(data);
            if(data.result == true) {
                swal('Grab_Terminal ID '+ter_id+' Already Exists');
                $("#grab_terminal_id").val("");
                $("#pg_terminal_id").val("");
            }
             if (data.ter_id) {
                $("#pg_terminal_id").val(data.ter_id);
            }
        },
        error: function(data){
            //error
        }
    });
});
$('#grab_terminal_id').on('change', function() {
    // alert($('#pg_merchant_id').val());
    // ajax request
    var mer_id = $('#pg_merchant_id').val();
    var ter_id = $('#grab_terminal_id').val();
    console.log(mer_id+"=>"+ter_id);
});

function terminal() {
    
    var pg_merchant_id = document.getElementById('pg_merchant_id').value;
    var pg_terminal_id =document.getElementById('pg_terminal_id').value;
    var pg_terminal_address = document.getElementById('pg_terminal_address').value;
    var pg_terminal_state   = document.getElementById('pg_terminal_state').value;
    var pg_terminal_city=document.getElementById('pg_terminal_city').value;
    var pg_terminal_pincode=document.getElementById('pg_terminal_pincode').value;
    var pg_terminal_imei=document.getElementById('pg_terminal_imei').value;

    var e = document.getElementById("pg_terminal_status");
    var pg_terminal_status = e.options[e.selectedIndex].value;

    // var e1 = document.getElementById("pg_terminal_action");
    // var pg_terminal_action = e1.options[e1.selectedIndex].value;

    if(pg_merchant_id == "") {
        // document.getElementById('pg_merchant_id').focus();
        swal('Please Enter the Merchant Id');
        return false;
    }

    if(pg_terminal_id == "") {
        swal('Please Enter the Terminal Id');
        return false;
    }

    if(pg_terminal_id.length != 12) {
        swal(' Terminal Id should be of length 13');
        return false;
    }
    if(pg_terminal_imei == "") {
        swal('Please Enter the Terminal IMEI No');
        return false;
    }
    if(pg_terminal_imei.length != 15) {
        swal(' Terminal IMEI No should be of length 15');
        return false;
    }

    if(pg_terminal_address == "") {
        swal('Please Enter the Terminal_Address');
        return false;
    }

    if(pg_terminal_state == "") {
        swal('Please Enter the Terminal_State');
        return false;
    }

    if(pg_terminal_city == "") {
        swal('Please Enter the Terminal_City');
        return false;
    }

    if(pg_terminal_pincode == "") {
        swal('Please Enter the Terminal_Pincode');
        return false;
    }

    if(pg_terminal_status == 0) {
        swal('Please Enter the Merchant_Status');
        return false;
    }

    // if(pg_terminal_action == "") {
    //     swal('Please Enter the Terminal_Action');
    //     return false;
    // }

    // return false;


    // var pg_merchant_id = document.getElementById('pg_merchant_id').value;
    // var pg_terminal_id =document.getElementById('pg_terminal_id').value;
    // var pg_terminal_address = document.getElementById('pg_terminal_address').value;
    // var pg_terminal_state   = document.getElementById('pg_terminal_state').value;
    // var pg_terminal_city=document.getElementById('pg_terminal_city').value;
    // var pg_terminal_pincode=document.getElementById('pg_terminal_pincode').value;
    // var pg_merchant_status=document.getElementById('pg_merchant_status').value;
    // var pg_merchant_action=document.getElementById('pg_merchant_action').value;

    // alert(pg_merchant_id);

    // if(pg_merchant_id == "") {
    //     swal('Please Enter the Merchant_Id');
    //     document.getElementById('pg_merchant_id');
    //     return false
    // } else {
    //     document.getElementById('pg_merchant_id');
    // }

    // if(pg_terminal_id == "") {
    //     swal('Please Enter the Terminal_Id');
    //     document.getElementById('pg_terminal_id');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_id');
    // }

    // if(pg_terminal_id.length != 8) {
    //     swal(' Terminal_Id should be of length 8');
    //     document.getElementById("pg_terminal_id");
    //     return false;
    // } else {
    //     document.getElementById("pg_terminal_id");
    // }

    // if(pg_terminal_address == "") {
    //     swal('Please Enter the Terminal_Address');
    //     document.getElementById('pg_terminal_address');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_address');
    // }

    // if(pg_terminal_state == "") {
    //     swal('Please Enter the Terminal_State');
    //     document.getElementById('pg_terminal_state');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_state');
    // }

    // if(pg_terminal_city == "") {
    //     swal('Please Enter the Terminal_City');
    //     document.getElementById('pg_terminal_city');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_city');
    // }

    // if(pg_terminal_pincode == "") {
    //     swal('Please Enter the Terminal_Pincode');
    //     document.getElementById('pg_terminal_pincode');
    //     return false
    // } else {
    //     document.getElementById('pg_terminal_pincode');
    // }

    // if(pg_merchant_status == "") {
    //     swal('Please Enter the Merchant_Status');
    //     document.getElementById('pg_merchant_status');
    //     return false
    // } else {
    //     document.getElementById('pg_merchant_status');
    // }

    // if(pg_merchant_action == "") {
    //     swal('Please Enter the Merchant_Action');
    //     document.getElementById('pg_merchant_action');
    //     return false
    // } else {
    //     document.getElementById('pg_merchant_action');
    // }
}
</script>

<!-- Data picker -->

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>
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
    $(document).ready(function(){


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

</script>



<script type="text/javascript" src="js/plugins/treegrid/jquery.treegrid.js"></script>

<link rel="stylesheet" href="css/plugins/treegrid/jquery.treegrid.css">



<script type="text/javascript">

    $('.tree').treegrid();

</script>



<!-- ChartJS-->

<script src="js/plugins/chartJs/Chart.min.js"></script>

<script type="text/javascript">

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
    // 	$('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

