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

                        <h5>CREATE VENDOR</h5>

                        <!-- <p><a target="_blank" href="download.php?file=merchQR/qrimgE01010000000001E0000001.png">Download</a></p> -->

                    </div>

                    <div class="ibox-content">
                        <div>
                            <?php
                            if($_POST) {
                                // echo "<pre>";
                                // print_r($_POST); 
                                // exit;
                                // require_once('api/alipaymerchantAPI.php');
                                // $results = merchantandterminalchecking($_POST);
                                $vendor_name = $_POST['vendor_name'];
                                $data = Array(
                                    "vendor_name" => $_POST['vendor_name'],
                                    // "idmerchants" => $postData['pg_merchant_map_id'],
                                    "vendor_active_status" => $_POST['vendor_status'],
                                    "vendor_payment_options"=>$_POST['vendor_payment_options'],
                                    "vendor_secretkey" => $_POST['vendor_secretkey'],
                                    "vendor_username" => $_POST['vendor_username'],
                                    "vendor_password" => $_POST['vendor_password'],
                                    "ap_mercid" => $_POST['ap_mercid']
                                );
                                $vendor_id = $db->insert('vendor_config', $data);

                                $Emi_tenures = isset($_POST['EMI_TEN']) ? implode('~',$_POST['EMI_TEN']): 0;

                                if($_POST['vendor_payment_options']=="NB") {

                                    if(is_array($_POST['NB'])) {
                                        $bankDet = $_POST['NB'];
                                        foreach ($bankDet as $key => $value) {
                                            //echo $key.'=>'.$value;
                                            //echo "<br>";
                                            $bankDetails = explode('~',$value);
                                            $bank_code = $bankDetails[0];
                                            $bank_name = $bankDetails[1];
                                            //echo $bank_code.'=>'.$bank_name;
                                            //echo "<br>";

                                            $data1 = Array(
                                                "vendor_id" => $vendor_id,
                                                "payment_option" => $_POST['vendor_payment_options'],
                                                "bank_code"=>$bank_code,
                                                "bank_name" => $bank_name,
                                                "Emi_tenures"=>$Emi_tenures
                                            );
                                            $db->insert('vendor_bank_details', $data1);
                                        }
                                    }
                                }

                                if($_POST['vendor_payment_options']=="WT") {

                                    if(is_array($_POST['WT'])) {
                                        $bankDet = $_POST['WT'];
                                        foreach ($bankDet as $key => $value) {
                                            $bankDetails = explode('~',$value);
                                            $bank_code = $bankDetails[0];
                                            $bank_name = $bankDetails[1];
                                            $data1 = Array(
                                                "vendor_id" => $vendor_id,
                                                "payment_option" => $_POST['vendor_payment_options'],
                                                "bank_code"=>$bank_code,
                                                "bank_name" => $bank_name,
                                                "Emi_tenures"=>$Emi_tenures
                                            );
                                            $db->insert('vendor_bank_details', $data1);
                                        }
                                    }
                                }

                                if($_POST['vendor_payment_options']=="CP") {

                                    if(is_array($_POST['CP'])) {
                                        $bankDet = $_POST['CP'];
                                        foreach ($bankDet as $key => $value) {
                                            $bankDetails = explode('~',$value);
                                            $bank_code = $bankDetails[0];
                                            $bank_name = $bankDetails[1];
                                            $data1 = Array(
                                                "vendor_id" => $vendor_id,
                                                "payment_option" => $_POST['vendor_payment_options'],
                                                "bank_code"=>$bank_code,
                                                "bank_name" => $bank_name,
                                                "Emi_tenures"=>$Emi_tenures
                                            );
                                            $db->insert('vendor_bank_details', $data1);
                                        }
                                    }
                                }
                                // echo "<pre>";
                                // print_r ($pre_vendor_bk_status);
                                // print_r($data1);
                                // $db->insert('vendor_bank_details', $data1);
                                echo "Vendor added Successfully";
                                echo "<br><br>";
                                echo "<a href='vendor_add.php'>CREATE ANOTHER VENDOR</a>";
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
                            <form id="form2" action="#"  autocomplete="off" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3 mrb-15">
                                            <label>Vendor Name</label><BR>
                                            <input class="form-control" type="text" name="vendor_name" id="vendor_name">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Vendor Secretkey</label><BR>
                                            <input class="form-control" type="text" name="vendor_secretkey" id="vendor_secretkey">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Vendor Username</label><BR>
                                            <input class="form-control" type="text" name="vendor_username" id="vendor_username">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Vendor Password</label><BR>
                                            <input class="form-control" type="text" name="vendor_password" id="vendor_password">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                            <label>Ap Mercid</label><BR>
                                            <input class="form-control" type="text" name="ap_mercid" id="ap_mercid">
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                          <label>Vendor Payment Options</label><BR>
                                            <select name="vendor_payment_options" class="form-control" id="vendor_payment_options">
                                                <option value="">SELECT</option>
                                                <option value="CP">Card Payment</option>
                                                <option value="NB">Net Banking</option>
                                                <option value="WT">Wallets</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mrb-15">
                                          <label>Vendor Status</label><BR>
                                            <select name="vendor_status" class="form-control" id="vendor_status">
                                                <option value="">SELECT</option>
                                                <option value="1">Active</option>
                                                <option value="2">In-Active</option>
                                            </select>
                                        </div><br><br><br>
                                        <div class="col-sm-3 mrb-15">
                                        </div>
                                        <div class="NB box col-sm-10 mrb-20" id="check" style="display:none;">
                                        <ul>
                                        <input type="checkbox" id="checkall" value=""> check all
                                        </ul> 
                                        <div id="check_net">
                                           <ul>
                                               <li><input type="checkbox" name="NB[]" value="HDF~HDFC BANK">      HDFC BANK</li>   
                                                <li><input type="checkbox" name="NB[]" value="AXIS~AXIS BANK">      AXIS BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="YES~YES BANK">      YES BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="KOT~KOTAK BANK">      KOTAK BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDALB~ALLAHABAD BANK">      ALLAHABAD BANK</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDADB~ANDRA">      ANDRA</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDBBR~BANK OF BARODA">      BANK OF BARODA</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDBOI~BANK OF INDIA">      BANK OF INDIA</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDCNB~CANARA BANK">      CANARA BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDCSB~CATHOLIC SYRIAN BANK">      CATHOLIC SYRIAN BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="CBI~CENTRAL BANK OF INDIA">      CENTRAL BANK OF INDIA</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDCUB~CITY UNION BANK">      CITY UNION BANK</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDCOB~COSMOS BANK">      COSMOS BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDDEN~DENA BANK">      DENA BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDDCB~DEVELOPMENT CREDIT BANK">      DEVELOPMENT CREDIT BANK</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDDLB~DHANLAKSHMI BANK">      DHANLAKSHMI BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDIDB~IDBI BANK">      IDBI BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDIOB~INDIAN OVERSEAS BANK">      INDIAN OVERSEAS BANK</li>  
                                                <li><input type="checkbox" name="NB[]" value="INDBK~INDIAN BANK">      INDIAN BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="IndusInd~INDUSIND BANK">      INDUSIND BANK</li> 
                                                <li><input type="checkbox" name="NB[]" value="BDBDING~ING VYSYA BANK">      ING VYSYA BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDJKB~JAMMU AND KASHMIR BANK">      JAMMU AND KASHMIR BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDKBL~KARNATAKA BANK LTD">      KARNATAKA BANK LTD</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDKVB~KARUR VYSYA BANK">      KARUR VYSYA BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDLVC~LAXMI VILAS BANK">      LAXMI VILAS BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDOBC~ORIENTAL BANK OF COMMERCE">      ORIENTAL BANK OF COMMERCE</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDPSB~PUNJAB AND SIND BANK">      PUNJAB AND SIND BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDPNB~PUNJAB NATIONAL BANK">      PUNJAB NATIONAL BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="RBL~RATNAKAR BANK">      RATNAKAR BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDSIB~SOUTH INDIAN BANK">      SOUTH INDIAN BANK</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDSCB~STANDARD CHARTERED BANK">      STANDARD CHARTERED BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDUBI~UNION BANK OF INDIA">      UNION BANK OF INDIA</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDUNI~UNITED BANK OF INDIA">      UNITED BANK OF INDIA</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDVJB~VIJAYA BANK">      VIJAYA BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="ICICI~ICICI BANK">      ICICI BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="SBINB~STATE BANK OF INDIA">      STATE BANK OF INDIA</li>  
                                                <li><input type="checkbox" name="NB[]" value="MAHNETBNK~BANK OF MAHARASHTRA">      BANK OF MAHARASHTRA</li>
                                                <li><input type="checkbox" name="NB[]" value="SBIBNJ~STATE BANK OF BIKANER AND JAIPUR">      STATE BANK OF BIKANER AND JAIPUR</li>
                                                <li><input type="checkbox" name="NB[]" value="SBH~STATE BANK OF HYDERABAD">      STATE BANK OF HYDERABAD</li>
                                                <li><input type="checkbox" name="NB[]" value="SBM~STATE BANK OF MYSORE">      STATE BANK OF MYSORE</li>
                                                <li><input type="checkbox" name="NB[]" value="SBP~STATE BANK OF PATIALA">      STATE BANK OF PATIALA</li>
                                                <li><input type="checkbox" name="NB[]" value="SBT~STATE BANK OF TRAVANCOR">      STATE BANK OF TRAVANCOR</li>
                                                <li><input type="checkbox" name="NB[]" value="VIJAYA~VIJAYA BANK">      VIJAYA BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="FEDERAL~FEDERAL BANK">      FEDERAL BANK  
                                                <li><input type="checkbox" name="NB[]" value="BDBDBBC~BANK OF BARODA CORPORATE">      BANK OF BARODA CORPORATE</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDDC2~DEVELOPMENT CREDIT BANK CORPORATE">      DEVELOPMENT CREDIT BANK CORPORATE</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDCPN~PNB CORPORATE">      PNB CORPORATE</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDSVC~SHYAMRAO VITTAL">      SHYAMRAO VITTAL</li>
                                                <li><input type="checkbox" name="NB[]" value="SRST~SARASWAT BANK">      SARASWAT BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDSYD~SYNDICATE BAN">      SYNDICATE BAN</li>
                                                <li><input type="checkbox" name="NB[]" value="CORP~CORPORATION BANK">      CORPORATION BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="DEUT~DEUTSCHE BANK">      DEUTSCHE BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="INDBK~INDIAN BANK">      INDIAN BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDUCO~UCOBANK">      UCOBANK</li>
                                                <li><input type="checkbox" name="NB[]" value="INDUSIND~INDUSIND BANK">      INDUSIND BANK</li>
                                                <li><input type="checkbox" name="NB[]" value="BDBDTJB~TJSBBank">      TJSBBank</li>
                                                <li><input type="checkbox" name="NB[]" value="UNBI~UNION BANK Of INDIA">      UNION BANK Of INDIA</li>  
                                                <li><input type="checkbox" name="NB[]" value="BDBDBCB~BASSIENCATHOLICCO-OPERATIVEBank">      BASSIENCATHOLICCO-OPERATIVEBank</li>
                                                <li><input type="checkbox" name="NB[]" value="SRST~SARAWAT BANK">      SARAWAT BANK</li>
                                            </ul>
                                      </div>
                                      </div>
                                      <div class="WT box col-sm-10 mrb-15" id="check1" style="display:none;" >
                                        <ul>
                                            <input type="checkbox" id="checkall1" value=""> check all
                                            </ul> 
                                          <div id="check_net">
                                           <ul>
                                            <li><input type="checkbox" name="WT[]" value="OXI~OxiCash">OxiCash</li>
                                            <li><input type="checkbox" name="WT[]" value="MONEY~MoneyonMobile">MoneyonMobile</li>
                                            <li><input type="checkbox" name="WT[]" value="MOBIK~MobiKwik">MobiKwik</li>
                                            <li><input type="checkbox" name="WT[]" value="PAYU~Payu">Payu</li>
                                            <li><input type="checkbox" name="WT[]" value="QUICK~QuickWallet">QuickWallet</li>
                                            <li><input type="checkbox" name="WT[]" value="OLA~Ola">Ola</li>
                                            <li><input type="checkbox" name="WT[]" value="JIO~JIOMONEY">JIOMONEY</li>
                                            <li><input type="checkbox" name="WT[]" value="HDFCPP~PayZapp">PayZapp</li>
                                            <li><input type="checkbox" name="WT[]" value="SBUD~SBI Buddy">SBI Buddy</li>
                                            <li><input type="checkbox" name="WT[]" value="FREE~FreeCharge">FreeCharge</li>
                                            <li><input type="checkbox" name="WT[]" value="AMAZON~Amazon">Amazon</li></ul>
                                         </div>
                                      </div>
                                      <div class="CP box col-sm-10 mrb-15" id="check2" style="display:none;" >
                                        <ul><h3>EMI BANK</h3>
                                            <input type="checkbox" id="checkall2" value=""> check all
                                            </ul> 
                                          <div id="check_emi_bank">
                                            <ul>
                                            <li><input type="checkbox" name="CP[]" value="AXISEMI~AXIS EMI">AXIS EMI</li>
                                            <li><input type="checkbox" name="CP[]" value="HDFCEMI~HDFC EMI">HDFC EMI</li>
                                            <li><input type="checkbox" name="CP[]" value="KOTAKEMI~KOTAK EMI">KOTAK EMI</li>
                                            <li><input type="checkbox" name="CP[]" value="ICICIEMI~ICICI EMI">ICICI EMI</li>
                                            <li><input type="checkbox" name="CP[]" value="FDATASC~F DATA SC">F DATA SC</li></ul>
                                          </div>
                                        </div>
                                        <div class="CP box col-sm-10 mrb-15" id="check2" style="display:none;" ><br>
                                           <ul><h3>EMI MONTHS</h3>
                                            <input type="checkbox" id="checkall3" value=""> check all
                                            </ul> 
                                          <div id="check_emi_ten">
                                            <ul>
                                            <li><input type="checkbox" name="EMI_TEN[]" value="3">3 MONTHS</li>
                                            <li><input type="checkbox" name="EMI_TEN[]" value="6">6 MONTHS</li>
                                            <li><input type="checkbox" name="EMI_TEN[]" value="9">9 MONTHS</li>
                                            <li><input type="checkbox" name="EMI_TEN[]" value="12">12 MONTHS</li></ul>
                                          </div>
                                         </div>
                                      </div>
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

require_once('footerjs.php'); ?>
<style>
/*.checkboxes li {
    margin:0;
    padding:0;
    list-style:none;
    position: absolute;
}
.checkboxes li {
    display:inline-block;
    width:33.3333%;
}*/
#check li {
    display:inline-block;
    float: left;
    width: 33.333%;
}
#check1 li {
    display:inline-block;
    float: left;
    width: 33.333%;
}
#check2 li {
    display:inline-block;
    float: left;
    width: 33.333%;
}
#check input[type=checkbox]:hover:checked {
  background-color: #a77e2d !important;
  color: #ffffff !important;
  text-rendering: optimizeSpeed;
    width: 13px;
    height: 13px;
    margin: 0;
    margin-right: 1px;
    display: block;
    float: left;
    position: relative;
    cursor: pointer;
    -webkit-box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    -moz-box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    background: #5F95FC;
}
#check1 input[type=checkbox]:hover:checked {
  background-color: #a77e2d !important;
  color: #ffffff !important;
  text-rendering: optimizeSpeed;
    width: 13px;
    height: 13px;
    margin: 0;
    margin-right: 1px;
    display: block;
    float: left;
    position: relative;
    cursor: pointer;
    -webkit-box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    -moz-box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    background: #5F95FC;
    content: '\2714';
}
#check2 input[type=checkbox]:hover:checked {
  background-color: #a77e2d !important;
  color: #ffffff !important;
  text-rendering: optimizeSpeed;
    width: 13px;
    height: 13px;
    margin: 0;
    margin-right: 1px;
    display: block;
    float: left;
    position: relative;
    cursor: pointer;
    -webkit-box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    -moz-box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    box-shadow: inset 0 1px 1px #5F95FC, 0 1px 0 #5F95FC;
    background: #5F95FC;
}
/*#check li:checked {
       /*content: '';
       position: absolute;
       width: 1.2ex;
       height: 0.4ex;*/
      /* background: rgba(0, 0, 0, 0);
       top: 0.9ex;
       left: 0.4ex;
       border: 3px solid blue;
       border-top: none;
       border-right: none;
       -webkit-transform: rotate(-45deg);
       -moz-transform: rotate(-45deg);
       -o-transform: rotate(-45deg);
       -ms-transform: rotate(-45deg);
       transform: rotate(-45deg);*/
    }*/
</style>

<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>

// jquery
$('#vendor_payment_options').on('change', function() {
    ///alert($('#vendor_payment_options').val());

    // ajax request
    var vendor_name=$('#vendor_name').val();
    var vendor_payment_options = $('#vendor_payment_options').val();
    $.ajax({
        url: "php/inc_reportsearch1.php",
        data: {
            'vendor_name':vendor_name,
         'vendor_payment_options':vendor_payment_options
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            console.log(data.result);
            if(data.result == true) {
                if (vendor_payment_options=="NB") {
                        vendor_payment_options="Net Banking";
                    } else if(vendor_payment_options=="WT") {
                        vendor_payment_options="Wallets";
                    } else {
                        vendor_payment_options="Card Payment";
                        //$(".box").not(".red").hide();
                        //$(".red").show();
                    }
             swal('Vendor '+vendor_name+' Already Exists in  ' +vendor_payment_options);
             $(".NB").hide();
             $(".WT").hide();
             $(".CP").hide();
             $('#vendor_payment_options').prop({defaultSelected: true});
              // $("#vendor_payment_options").val("0");
                //$('#vendor_payment_options').prop('selectedIndex',0);
               // $('select option[value="1"]').attr("selected",true);
               $('#vendor_payment_options option[value=0]').attr('selected','selected');
                $('#vendor_payment_options option').prop('selected', function() {
                    return this.defaultSelected;
                 }); 

               // $('#vendor_payment_options').trigger("change");
            }
        },
        error: function(data){
            //error
        }
    });
});

$(document).on('change','#vendor_payment_options',function(){
     var vendor_payment_options=$(this).find("option:selected").attr('value');
    // alert($(this).find("option:selected").attr('value'));
     if($(this).find("option:selected").attr('value')!=""){
    if (vendor_payment_options=="NB") {
                        //vendor_payment_options="Net Banking";
                        $(".box").not(".NB").hide();
                        $(".NB").show();
                    } else if(vendor_payment_options=="WT") {
                        //vendor_payment_options="Wallets";
                        $(".box").not(".WT").hide();
                        $(".WT").show();
                    } else {
                        //vendor_payment_options="Card Payment";
                        //$(".box").not(".red").hide();
                        $(".box").not(".CP").hide();
                        $(".CP").show();
                    }
        } else{
            $(".NB").hide();
            $(".WT").hide();
            $(".CP").hide();
            //alert(vendor_payment_options);
        }        
          });

$(document).ready(function() {
    //alert("hi");
        // validate signup form on keyup and submit
        $("#form2").validate({
            rules: {
                vendor_name: { required:true,
                      //minlength:1,
                      //maxlength:35,
                      //regex:/^[a-zA-z0-9]+$/ 
                  },
                vendor_secretkey: { required:true,
                      //minlength:1,
                      //maxlength:3,
                      //regex:/^[a-zA-z0-9]+$/ 
                  },
                vendor_username: { required:true,
                      //minlength:1,
                      //maxlength:10,
                      //regex:/^[0-9]+$/ 
                  },
                vendor_password: { required:true,
                      //minlength:1,
                      //maxlength:25,
                      //regex:/^[a-zA-z0-9]+$/ 
                  },
                ap_mercid: { required:true,
                      //minlength:1,
                      //maxlength:25,
                     // regex:/^[a-zA-z0-9]+$/
                      },
                vendor_payment_options: { required:true,
                      //minlength:1,
                      //maxlength:25,
                     // regex:/^[a-zA-z0-9]+$/
                      },
                vendor_status: { required:true,
                      //minlength:1,
                      //maxlength:25,
                     // regex:/^[a-zA-z0-9]+$/
                      }
                },
                 
            messages: {
                vendor_name:{
                 required: "<font color=red>Please enter your Vendor Name</font>",
                // minlength: "<font color=red>Your txnId must be at least 1 characters long</font>",
                 //maxlength: "<font color=red>Your txnId must be at least 35 characters long</font>",
               //  regex: "<font color=red>Your txnId must be Alphanumeric</font>"
                },
                 
                vendor_secretkey:{
                    required:  "<font color=red>Please enter your Vendor Secretkey</font>",
                   // minlength: "<font color=red>Your txnOrigin must be at least 1 characters long</font>",
                  //  maxlength: "<font color=red>Your txnOrigin maximum 3 characters long</font>",
                 //   regex: "<font color=red>Your txnOrigin must be Alphanumeric</font>"
                },
                vendor_username:{
                    required: "<font color=red>Please enter your Vendor Username</font>",
                    //minlength: "<font color=red>Your MobileNumber must be at least 1 characters long</font>",
                    //maxlength: "<font color=red>Your MobileNumber must be at least 10 characters long</font>",
                    //regex: "<font color=red>Your MobileNumber must be Numeric</font>"
                },
                vendor_password:{
                    required: "<font color=red>Please enter your Vendor Password</font>",
                    //minlength: "<font color=red>Your MobileNumber must be at least 1 characters long</font>",
                    //maxlength: "<font color=red>Your MobileNumber must be at least 10 characters long</font>",
                    //regex: "<font color=red>Your MobileNumber must be Numeric</font>"
                },
                 
                ap_mercid: {
                    required: "<font color=red>Please provide a Ap mercid</font>",
                    minlength: "<font color=red>Your firstName must be at least 1 characters long</font>",
                    maxlength: "<font color=red>Your firstName must be at least 25 characters long</font>",
                    regex: "<font color=red>Your firstName must be Alphanumeric</font>"
                },
                vendor_payment_options: {
                    required: "<font color=red>Please provide a Vendor Payment Options</font>",
                    minlength: "<font color=red>Your firstName must be at least 1 characters long</font>",
                    maxlength: "<font color=red>Your firstName must be at least 25 characters long</font>",
                    regex: "<font color=red>Your firstName must be Alphanumeric</font>"
                },
                vendor_status: {
                    required: "<font color=red>Please provide a Vendor Status</font>",
                    minlength: "<font color=red>Your firstName must be at least 1 characters long</font>",
                    maxlength: "<font color=red>Your firstName must be at least 25 characters long</font>",
                    regex: "<font color=red>Your firstName must be Alphanumeric</font>"
                },
                 
                //agree: "Please accept our policy"
             
            }
    });
    $('#form2 input').on('keyup blur', function () { // fires on every keyup & blur
        if ($('#form2').valid()) {                   // checks form for validity
            $('button.btn').prop('disabled', false);        // enables button
        } else {
            $('button.btn').prop('disabled', 'disabled');   // disables button
        }
    });
});
$("#checkall").change(function () {
    $("input[name='NB[]']").prop('checked', $(this).prop("checked"));
});
$("#checkall1").change(function () {
    $("input[name='WT[]']").prop('checked', $(this).prop("checked"));
});
$("#checkall2").change(function () {
    $("input[name='CP[]']").prop('checked', $(this).prop("checked"));
});
$("#checkall3").change(function () {
    $("input[name='EMI_TEN[]']").prop('checked', $(this).prop("checked"));
});

// $(document).ready(function() {
//   $('#checkall2').click(function() {
//     var checked = $(this).prop('checked');
//     $('#check_emi_bank').find('input:checkbox').prop('checked', checked);
//   });
//   $('#checkall3').click(function() {
//     var checked = $(this).prop('checked');
//     $('#check_emi_ten').find('input:checkbox').prop('checked', checked);
//   });
// })
</script> 
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#vendor_payment_options').click(function(){
        var inputValue = $(this).attr("value");

    });
});
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
    // 	$('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

