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

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

//var_dump(getTransactions($_SESSION['iid']));die();

//if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';

        if(!empty($env) && $env == 0){
            $omg = 'TEST MODE ENABLED';
        }
        ?>


    <?php } else { ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>Merchant Upi Static Qr creation </h5>

                    </div>

                    <div class="ibox-content">

                        <div>

                            <?php
                            include "phpqrcode/qrlib.php";

                            if($_POST['merchantid']!="") {

                                // echo "<pre>";
                                // print_r($_POST); exit;
                                // $db->where("idmerchants",$_POST['merchantid']);
                                // $dgot = $db->getOne("merchants");
                                $db->where("affiliate_id",$_POST['merchantid']);
                                $db->where("upi_status",1);
                                $dgot = $db->getOne("merchants");

                                if($dgot['idmerchants'] == "") {
                                    echo "<br><br>";
                                    echo "<center><h4>UPI Merchant ID not found</h4><br><br><a href='upi_qr_generate.php'>Back to CREATE QR</a></center>";
                                } else {
                                  
                                    $merchant_vaddr = $_POST['merchantid'];
                                    // $terminalid = $_POST['terminalid'];

                                    $db->where("affiliate_id",$merchant_vaddr);
                                    $merchant_det = $db->getOne("merchants");
                                    $pa = $merchant_det['affiliate_id'];
                                    $pn = $merchant_det['merchant_name'];
                                     //$vm=$merchant_det['idmerchants'];
                                    //echo $vm;
                                    // die();
                                    //$am = '1';
                                    $mode = '02';
                                    $sign ='werwrwrwrrwrwe';
                                    $orgid = '123456';


                                    $upi_id = 'upi://pay?';

                                    $secretKey = "secret_key";
                                    $postData = array( 
                                        "pa" => $pa, 
                                        "pn" => $pn, 
                                        "mode" => $mode, 
                                        "sign" => $sign, 
                                        "orgid" => $orgid
                                    );

                                

                                     $query_string = http_build_query($postData); 
                                     $upi_data = $upi_id.$query_string;
                                     $signature = base64_encode(hash("sha256", $secretKey, True));
                                    $postData2 = array( 
                                            "pa" => $pa, 
                                            "pn" => $pn,  
                                            "mode" => $mode, 
                                            "sign" => $sign, 
                                             "orgid" => $orgid,
                                            "sign" => $signature
                                        );
                                     $query_string2 = http_build_query($postData2); 
                                     $upi_data_final = $upi_id.$query_string2;
  // header( "Refresh:5;url=test.php?user=".$upi_data_final);

                                    // $text_path = 'merchQR/text_'.$merchantid.".png";
                                    // if(!file_exists($text_path)) {
                                    //     $image_create = text_image_create($_POST['merchantid'],$dgot['merchant_name']);
                                    // }

                                    $path = "merchupiQR/qrimg" .$merchant_vaddr. ".png";
                                    // $qstring = "merchantid=" . $merchantid . "&ifsc=" . $ifsc . "&mcc=" . $mcc . "&merchantname=" . $merchantname . "&city=" . $city . "&pin=" . $pin;
                                    //$qstring = "merchantid=" . $merchantid . "&terminalid=" . $terminalid . "&currency=" . $currency . "&ifsc=" . $ifsc . "&mcc=" . $mcc . "&merchantname=" . $merchantname . "&city=" . $city . "&pin=" . $pin . "&store_name=" . $store_name;
                                    // echo $qstring; exit; die();
                                    //$qstring = base64_encode($upi_data_final);
                                    QRcode::png($upi_data_final, $path, "L", 5, 5);

                                    // //Adding image center to an QRcode starts
                                    // $imgname=$path;
                                    // $logo="merchQR/sha.png";
                                    // $QR = imagecreatefrompng($imgname);
                                    // $logopng = imagecreatefrompng($logo);
                                    // $QR_width = imagesx($QR);
                                    // $QR_height = imagesy($QR);
                                    // $logo_width = imagesx($logopng);
                                    // $logo_height = imagesy($logopng);

                                    // list($newwidth, $newheight) = getimagesize($logo);
                                    // $out = imagecreatetruecolor($QR_width, $QR_width);
                                    // imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
                                    // imagecopyresampled($out, $logopng, $QR_width/2.65, $QR_height/2.65, 0, 0, $QR_width/4, $QR_height/4, $newwidth, $newheight);
                                    // imagepng($out,$imgname);
                                    // imagedestroy($out);

                                    if (file_exists($path)) {

                                        $text_logo="merchTXT/text_".$merchantid.$terminalid.".png";
                                        // $text_logo="merchQR/simpletext.png";
                                        $text_QR = imagecreatefrompng($imgname);
                                        $text_logopng = imagecreatefrompng($text_logo);
                                        $text_QR_width = imagesx($text_QR);
                                        $text_QR_height = imagesy($text_QR);
                                        $text_logo_width = 200; // imagesx($text_logopng);
                                        $text_logo_height = 20; // imagesy($text_logopng);

                                        list($newwidth, $newheight) = getimagesize($text_logo);
                                        $text_out = imagecreatetruecolor($text_QR_width, $text_QR_width);
                                        imagecopyresampled($text_out, $text_QR, 0, 0, 0, 0, $text_QR_width, $text_QR_height, $text_QR_width, $text_QR_height);
                                        imagecopyresampled($text_out, $text_logopng, $text_QR_width - (($text_QR_width/2)+83), $text_QR_height - (($text_QR_height/2)-147), 0, 0, ($text_QR_width/2)+15, ($text_QR_height/2)-147, $newwidth, $newheight);
                                        imagepng($text_out,$imgname);
                                        imagedestroy($text_out);

                                        // echo $text_QR_width - (($text_QR_width/2)+83); 
                                        // echo "<br>";
                                        // echo $text_QR_height - (($text_QR_height/2)-147);
                                        //Adding image center to an QRcode ends  
                                    }

                                    // $ddata = array(
                                    //     "mer_map_id" => $merchantid,
                                    //     "merchant_name" => $merchantname,
                                    //     "currency_code" => $currency,
                                    //     "start_date" => date('Y-m-d'),
                                    //     "address1" => $address,
                                    //     "city" => $city,
                                    //     "us_state" => $state,
                                    //     "country" => $country,
                                    //     "zippostalcode" => $pin,
                                    //     "mcc" => $mcc,
                                    //     "qr_url" => $path
                                    // );
                                    // $val=$db->insert('merchants', $ddata);

                                    $ddata = array(
                                        "qr_url" => $path
                                    );
                                    $db->where('idmerchants', $merchant_det['idmerchants']);
                                    $val = $db->update('merchants', $ddata);

                                    if($val == TRUE) {
                                        echo "<b>QR image generated successfully";
                                        echo "<br><br>";
                                        echo "Path:</b> http://169.38.91.246/testspaysez/" . $path;
                                        echo "<br><br>";
                                        echo "<a href='upi_qr_generate.php'>CREATE ANOTHER</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a target='_blank' href='" . $path . "'>VIEW QR</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a target='_blank' href='download.php?file=".$path."'>DOWNLOAD QR</a>";
                                    }
                                }

                            } else {
                                ?>
                                <style>
                                    label {
                                        font-weight: bold;
                                    }
                                </style>
                                <!-- <center><b><h4>CREATE MERCHANT QR CODE</h4></b></center><BR> -->
                                <?php 
                                $cols = array("idmerchants", "merchant_name", "mer_map_id", "is_active","affiliate_id");
                                $db->where("is_active",1);
                                $db->where("upi_status",1);
                                $db->orderBy("mer_map_id","asc");
                                $merchantDet = $db->get("merchants", null, $cols);
                                ?>
                                <form action="upi_qr_generate.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <label>Merchant UPI ID</label><BR>
                                                <!-- <input class="form-control" type="text" name="merchantid"> -->
                                                <select name="merchantid" class="form-control" id="merchantid">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($merchantDet as $key => $value) {
                                                        echo '<option value="'.$value['affiliate_id'].'">'.$value['affiliate_id'].' - '.$value['merchant_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-sm-3">
                                                <label>Terminal ID</label><BR>
                                                <input class="form-control" type="text" name="terminalid">
                                            </div> -->
                                            <!-- <div class="col-sm-3">
                                                <label>IFSC Code</label><BR>
                                                <input class="form-control" type="text" name="ifsc">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>MCC</label><BR>
                                                <input class="form-control" type="text" name="mcc">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Merchant Name</label><BR>
                                                <input class="form-control" type="text" name="merchantname">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Currency</label><BR>
                                                <input class="form-control" type="text" name="currency" maxlength="3">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Address</label><BR>
                                                <input class="form-control" type="text" name="address">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>City</label><BR>
                                                <input class="form-control" type="text" name="city">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>State</label><BR>
                                                <input class="form-control" type="text" name="state">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Country</label><BR>
                                                <input class="form-control" type="text" name="country">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Pincode</label><BR>
                                                <input class="form-control" type="text" name="pin">
                                            </div> -->
                                        </div>
                                    </div>
                                    &nbsp; &nbsp; 
                                    <div class="row">
                                        <div class="col-sm-12" id="qrcode">
                                            <b>QR Code Already Generated, Please click below to View (OR) Download QR Code</b><br>
                                            <a id="link1" target='_blank' href=''>VIEW QR</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a id="link2" target='_blank' href=''>DOWNLOAD QR</a>
                                        </div>
                                        <div class="col-sm-12" id="qrcode_btn">
                                            <input type="submit" class="btn btn-warning" value="Generate QR">
                                        </div>
                                    </div>
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



<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/tabelizer/jquery.tabelizer.js"></script>

<link rel="stylesheet" href="css/plugins/tabelizer/tabelizer.css">



<!-- Data picker -->

<script>
    $(document).ready(function(){
        $("#qrcode").hide();
        $("#qrcode_btn").hide();
        $("#merchantid").change(function () {
            // alert($(this).val());
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    // contentType: 'application/json',
                    // dataType: 'json',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'getterminalQR'})
                })
                .done(function( msg ) {
                    console.log(msg);
                     if(msg!=''){
                        $("#qrcode_btn").hide();
                        $("#qrcode").show();
                        $("a#link1").attr("href",msg);
                        $("a#link2").attr("href","download.php?file="+msg);
                    } else {
                        $("#qrcode_btn").show();
                        $("#qrcode").hide();
                    }
                });
            } else {
                $("#qrcode_btn").hide();
                $("#qrcode").hide();
            }
        });

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
    $(document).ready(function(){


        /**** Displaying the number of transactions per month in Line graph format ****/

        var lineData = {

            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

            datasets: [

                {

                    label: "Example dataset",

                    fillColor: "rgba(26,179,148,0.5)",

                    strokeColor: "rgba(26,179,148,0.7)",

                    pointColor: "rgba(26,179,148,1)",

                    pointStrokeColor: "#fff",

                    pointHighlightFill: "#fff",

                    pointHighlightStroke: "rgba(26,179,148,1)",

                    data: [<?php echo $transCnts; // echo $transactions_data; ?>]

                },

                {

                    label: "Example dataset",

                    fillColor: "rgba(255,133,0,0.5)",

                    strokeColor: "rgba(255,133,0,1)",

                    pointColor: "rgba(255,133,0,1)",

                    pointStrokeColor: "#fff",

                    pointHighlightFill: "#fff",

                    pointHighlightStroke: "rgba(255,133,0,1)",

                    data: [<?php // echo $transAmts; // echo $chargebacks_data; ?>]

                }

            ]

        };



        var lineOptions = {

            scaleShowGridLines: true,

            scaleGridLineColor: "rgba(0,0,0,.05)",

            scaleGridLineWidth: 1,

            bezierCurve: true,

            bezierCurveTension: 0.4,

            pointDot: true,

            pointDotRadius: 4,

            pointDotStrokeWidth: 1,

            pointHitDetectionRadius: 20,

            datasetStroke: true,

            datasetStrokeWidth: 2,

            datasetFill: true,

            responsive: true,

        };

        var ctx = document.getElementById("lineChart").getContext("2d");

        var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    });

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

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

