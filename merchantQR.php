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

$db->where("id",$user_id);
$userDet = $db->getOne("users");

if ($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5 || $usertype == 7){

//var_dump(getTransactions($_SESSION['iid']));die();

//if user is merchant

    if( $usertype == 4 || $usertype == 5) {

        $omg ='';

        if(!empty($env) && $env == 0){
            $omg = 'TEST MODE ENABLED';
        }
        ?>
        <!-- Overall Transaction Report in Column Tiles 1 -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 report-bk">

                <h3>Design 1</h3>
                <div class="row row-left-right">
                    <div class="col-sm-6 col-md-3 mb pad-left-right">
                        <div class="st-panel st-panel--border">
                            <div class="st-panel__cont">
                                <div class="st-panel__header">
                                    <div class="fluid-cols">
                                        <div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Income</span>
										<small>Month</small>
									</span>
                                            <div class="st-panel__tools">
                                                <div class="st-panel-tool">
                                                    <span class="label label-success">$1,200</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="min-col">

                                        </div>
                                    </div>
                                </div>
                                <div class="st-panel__content">
                                    <div class="text-ellipsis text-center" style="font-size: 24px;">$25,235.00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 mb pad-left-right">
                        <div class="st-panel st-panel--border">
                            <div class="st-panel__cont">
                                <div class="st-panel__header">
                                    <div class="fluid-cols">
                                        <div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Payments</span><small>Out</small>
									</span>
                                        </div>
                                        <div class="min-col">
                                            <div class="st-panel__tools">
                                                <div class="st-panel-tool">
                                                    <div class="sparkline" values="15, 14, 13, 14, 16, 17, 15" sparktype="bar" sparkbarcolor="#45BDDC" sparkbarwidth="3" sparkbarspacing="1" sparkchartrangemin1="0">
                                                        <canvas style="display: inline-block; width: 27px; height: 19px; vertical-align: top;" width="27" height="19"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="st-panel__content">
                                    <div class="text-ellipsis text-center" style="font-size: 24px;">$120,840.00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-2 mb pad-left-right">
                        <div class="st-panel st-panel--border">
                            <div class="st-panel__cont">
                                <div class="st-panel__header">
                                    <div class="fluid-cols">
                                        <div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Rating</span><small>Avg</small>
									</span>
                                        </div>
                                        <div class="min-col">
                                            <div class="st-panel__tools">
                                                <div class="st-panel-tool"><i class="text-warning fa fa-star"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="st-panel__content">
                                    <div class="text-ellipsis text-center" style="font-size: 24px;">4.8</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-2 mb pad-left-right">
                        <div class="st-panel st-panel--border">
                            <div class="st-panel__cont">
                                <div class="st-panel__header">
                                    <div class="fluid-cols">
                                        <div class="expand-col text-ellipsis">
									<span class="st-panel__title">
										<span>Growth</span>
									</span>
                                        </div>
                                        <div class="min-col">
                                            <div class="st-panel__tools">
                                                <div class="st-panel-tool">
                                                    <span class="label label-info">25</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="st-panel__content" style="height: 36px;">
                                    <iframe id="resize-iframe" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                    <div class="sparkline_1" values="8, 2, 4, 3, 5, 4, 3, 5, 5, 6, 3, 9, 7, 3, 5, 6, 9, 5, 6, 7, 2, 3, 9, 6, 6, 7, 8, 10, 15, 16, 17, 15" sparktype="line" sparkwidth="100%" sparkheight="36" sparkfillcolor="#dff7fd" sparklinewidth="1" sparklinecolor="#45BDDC" sparkhighlightlinecolor="#45BDDC" sparkchartrangemin="" sparkspotcolor="" sparkminspotcolor="" sparkmaxspotcolor="">
                                        <canvas width="135" height="36" style="display: inline-block; height: 36px; vertical-align: top;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-2 mb pad-left-right">
                        <div class="st-panel st-panel--border">
                            <div class="st-panel__cont">
                                <div class="st-panel__header">
                                    <div class="fluid-cols">
                                        <div class="expand-col text-ellipsis text-center">
									<span class="st-panel__title">
										<span>Users</span>
									</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="st-panel__content">
                                    <div class="text-ellipsis text-center" style="font-size: 24px;">180 / <small>20</small></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Overall Transaction Report in Column Tiles 2 -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                <h3 style="padding-left: 15px;">Design 2</h3>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Monthly</span>
                            <h5>Income</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">40 886,200</h1>
                            <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                            <small>Total income</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">Annual</span>
                            <h5>Orders</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">275,800</h1>
                            <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                            <small>New orders</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">Today</span>
                            <h5>visits</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">106,120</h1>
                            <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                            <small>New visits</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">Low value</span>
                            <h5>User activity</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">80,600</h1>
                            <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                            <small>In first month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins"><center><span style="color:red"><?php echo $omg; ?></span></center>

                    <div class="ibox-title iboxsummary">

                        <div class="col-xs-3 col-sm-3 no-padding title-sec">
                            <h5>Daily Summary</h5>
                        </div>

                        <div class="col-xs-4 col-sm-3 date-sec">
                            <div class="input-group date datesummary">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" name="date" id="date" type="text" value="<?php // echo date('m/d/Y');?>" >
                            </div>
                        </div>

                        <!-- <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="" class="form-control" name="period_start_date" id="period_start_date">
                        </div> -->

                        <!-- <button type="button" class="btn btn-default btn-sm refbtn">
                            <span class="glyphicon glyphicon-refresh"></span> Refresh
                        </button> -->

                        <a class="btn btn-default btn-sm refbtn" href="#" onclick="callQueryapi();" role="button">
                            <span class="glyphicon glyphicon-refresh"></span> Refresh
                        </a>

                        <div class="ibox-tools toolssummary">

                            <!-- <a id="exportlink" href="phpexcel/report.php?date=<?php //echo date('m/d/Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a> -->

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

                    <!-- <div class="ibox-content">

				<h3 class="pull-left"><?php //echo getUserMerchantName($id); ?><br /></h3>

				<div class="pull-right">

					<label class="col-sm-3 control-label">Date &nbsp;</label>

					<div class="col-sm-3">

						<div class="input-group date">
							<span class="input-group-addon m-b"><i class="fa fa-calendar"></i></span>
							<input class="form-control m-b" name="date" id="date" type="text" value="<?php //echo date('m/d/Y');?>" >
						</div>

					</div>

                </div>

				<div class="clearfix"></div>

			</div> -->

                </div>

            </div>

        </div>

        <div class="clearfix"></div>

        <div class="row rlt_row" style="display: none;">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title  back-change">
                        <h5>Results</h5>
                        <div class="ibox-tools">
                            <a id="exportlink_date" href="php/inc_transsearch.php?date=<?php echo date('m/d/Y');?>" target="_bank"><i class="fa fa-file-excel-o"></i> Export</a>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id="cbresults"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
        <!-- <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          Launch demo modal
        </button> -->

        <!-- Modal -->
        <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div> -->

        <div id="dailyreport" style="display: none;"></div>

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <?php echo $error ; ?>

                    <div class="ibox-title">

                        <h5>Yearly Transactions Chart</h5>

                        <div class="ibox-tools">

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

                    <?php
                    //require_once('php/database_config.php');
                    $iid = $_SESSION['iid'];

                    // $query="SELECT YEAR(server_datetime_trans) AS year, MONTH(server_datetime_trans) AS month, COUNT(DISTINCT id_transaction_id) AS transcount FROM transactions GROUP BY year, month";
                    // $transactions_Curryear = $db->rawQuery($query);

                    $query="SELECT YEAR(transaction.trans_datetime) AS year, MONTH(transaction.trans_datetime) AS month, COUNT(DISTINCT transaction.id_transaction_id) AS transcount, SUM(transaction.total_fee) AS transamount FROM merchants JOIN transaction ON transaction.merchant_id = merchants.idmerchants AND merchants.userid= '$iid' AND YEAR(transaction.trans_datetime) = YEAR(CURDATE()) GROUP BY year, month";
                    $transactions_Curryear = $db->rawQuery($query);

                    $totTransamount = 0;
                    $transCntval = 0;
                    $transCntarr = [];
                    $transAmtarr = [];
                    $i = 1;
                    foreach ($transactions_Curryear as $key) {
                        while($i <= $key['month']) {
                            if($i == $key['month']) {
                                $transCntarr[] = $key['transcount'];

                                $transAmtarr[] = $key['transamount'];
                                $totTransamount+= $key['transamount'];
                            } else {
                                $transCntarr[] = 0;

                                $transAmtarr[] = 0;
                                $totTransamount+= 0;
                            }
                            $i++;
                        }
                    }
                    $transCnts = implode(',', $transCntarr);
                    $transCntval = array_sum($transCntarr);

                    $transAmts = implode(',', $transAmtarr);
                    // echo $transAmts;
                    ?>
                    <div class="ibox-content">

                        <div>

						<span class="pull-right text-right">

						<small>Total value of transactions for the current year</small>

							<br/>

							All transactions:
                            <?php
                            // echo !empty($num_yearly_transactions) ? $num_yearly_transactions : 0;
                            echo $transCntval!= 0 ? $transCntval : 0;
                            ?>

						</span>

                            <h1 class="m-b-xs">$
                                <?php
                                // echo number_format((float)str_replace(',', '', (!empty($total_yearly_transactions)) ? $total_yearly_transactions : 0 ) - (float)str_replace(',', '', (!empty($total_yearly_refunds)) ? $total_yearly_refunds : 0), 2, '.', ',');
                                echo number_format($totTransamount,2);
                                ?>
                            </h1>

                            <h3 class="font-bold no-margins">

                                Transactions

                            </h3>

                            <small></small>

                        </div>



                        <div>

                            <canvas id="lineChart" height="70"></canvas>

                        </div>



                        <div class="m-t-md">

                            <small class="pull-right">

                                <i class="fa fa-clock-o"> </i>

                                <strong>Updated on <?php echo date("m-d-y"); ?></strong>

                            </small>

                            <small>

                                <strong>Analysis of transactions for the current year.</strong>

                            </small>

                        </div>



                    </div>

                </div>

            </div>

        </div>

    <?php } else { ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>Merchant QR creation </h5>

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
                                $db->where("mer_map_id",$_POST['merchantid']);
                                $dgot = $db->getOne("merchants");

                                if($dgot['idmerchants'] == "") {
                                    echo "<br><br>";
                                    echo "<center><h4>Merchant ID not found</h4><br><br><a href='merchantQR.php'>Back to CREATE QR</a></center>";
                                } else {
                                    $merchantid = $_POST['merchantid'];
                                    $terminalid = $_POST['terminalid'];

                                    $db->where("merchant_id",$dgot['idmerchants']);
                                    $merchant_bank_det = $db->getOne("merchant_processors_mid");
                                    $ifsc = $merchant_bank_det['ifsccode'];

                                    $currency = $dgot['currency_code'];
                                    $mcc = $dgot['mcc'];
                                    $merchantname = $dgot['merchant_name'];
                                    $merchantname_exp = explode(" ", $dgot['merchant_name']);
                                    $store_name = $merchantname_exp[0];
                                    $address = $dgot['address'];
                                    $city = $dgot['city'];
                                    $state = $dgot['state'];
                                    $country = $dgot['country'];
                                    $pin = $dgot['zippostalcode'];

                                    // $text_path = 'merchQR/text_'.$merchantid.".png";
                                    // if(!file_exists($text_path)) {
                                    //     $image_create = text_image_create($_POST['merchantid'],$dgot['merchant_name']);
                                    // }

                                    $path = "merchQR/qrimg" .$merchantid.$terminalid. ".png";
                                    // $qstring = "merchantid=" . $merchantid . "&ifsc=" . $ifsc . "&mcc=" . $mcc . "&merchantname=" . $merchantname . "&city=" . $city . "&pin=" . $pin;

                                    if($merchantid == 'E01010000000040') {
                                        $qstring = "merchantid=" . $merchantid . "&terminalid=" . $terminalid . "&currency=" . $currency . "&ifsc=" . $ifsc . "&mcc=" . $mcc . "&merchantname=" . $merchantname . "&city=" . $city . "&pin=" . $pin . "&store_name=" . $store_name."&amount=2";  
                                    } else {
                                        $qstring = "merchantid=" . $merchantid . "&terminalid=" . $terminalid . "&currency=" . $currency . "&ifsc=" . $ifsc . "&mcc=" . $mcc . "&merchantname=" . $merchantname . "&city=" . $city . "&pin=" . $pin . "&store_name=" . $store_name;
                                    }

                                    // echo $qstring; exit; die();
                                    $qstring = base64_encode($qstring);
                                    // QRcode::png("http://169.38.91.246/testspaysez/alipay_en.php?qstring=" . $qstring, $path, "L", 5, 5);
                                    QRcode::png("https://paymentgateway.test.credopay.in/testspaysez/alipay_en.php?qstring=" . $qstring, $path, "L", 4.75, 4.75);

                                    //Adding image center to an QRcode starts
                                    $imgname=$path;
                                    $logo="merchQR/sha.png";
                                    $QR = imagecreatefrompng($imgname);
                                    $logopng = imagecreatefrompng($logo);
                                    $QR_width = imagesx($QR);
                                    $QR_height = imagesy($QR);
                                    $logo_width = imagesx($logopng);
                                    $logo_height = imagesy($logopng);

                                    list($newwidth, $newheight) = getimagesize($logo);
                                    $out = imagecreatetruecolor($QR_width, $QR_width);
                                    imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
                                    imagecopyresampled($out, $logopng, $QR_width/2.65, $QR_height/2.65, 0, 0, $QR_width/4, $QR_height/4, $newwidth, $newheight);
                                    imagepng($out,$imgname);
                                    imagedestroy($out);

                                    if (file_exists($path)) {

                                        $text_logo="merchTXT/text_".$merchantid.$terminalid.".png";
                                        // $text_logo="merchQR/simpletext.png";
                                        $text_QR = imagecreatefrompng($imgname);
                                        $text_logopng = imagecreatefrompng($text_logo);
                                        $text_QR_width = imagesx($text_QR);
                                        $text_QR_height = imagesy($text_QR);
                                        $text_logo_width = 200; // imagesx($text_logopng);
                                        $text_logo_height = 15; // imagesy($text_logopng);

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

                                    // merchTXT/text_E01010000000001E0000001.png

                                    $ddata = array(
                                        "mso_ter_device_mac" => $path
                                    );
                                    $db->where('idmerchants', $dgot['idmerchants']);
                                    $db->where('mso_terminal_id', $terminalid);
                                    $val = $db->update('terminal', $ddata);

                                    if($val == TRUE) {
                                        echo "<b>QR image generated successfully";
                                        echo "<br><br>";
                                        // echo "Path:</b> http://169.38.91.246/testspaysez/" . $path;
                                        echo "Path:</b> https://paymentgateway.test.credopay.in/testspaysez/" . $path;
                                        echo "<br><br>";
                                        echo "<a href='merchantQR.php'>CREATE ANOTHER</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a target='_blank' href='" . $path . "'>VIEW QR</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a target='_blank' href='download.php?file=".$path."'>DOWNLOAD QR</a>";
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
                                if($userDet['username'] == "hutchadminuser") {
                                    $cols = array("idmerchants", "merchant_name", "mer_map_id", "is_active");
                                    $db->where("idmerchants", $userDet['merchant_id']);
                                    $db->where("is_active",1);
                                    $db->orderBy("mer_map_id","asc");
                                    $merchantDet = $db->get("merchants", null, $cols);
                                } else {
                                    $cols = array("idmerchants", "merchant_name", "mer_map_id", "is_active");
                                    $db->where("is_active",1);
                                    $db->orderBy("mer_map_id","asc");
                                    $merchantDet = $db->get("merchants", null, $cols);
                                }
                                ?>
                                <form action="merchantQR.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <label>Merchant ID</label><BR>
                                                <!-- <input class="form-control" type="text" name="merchantid"> -->
                                                <select name="merchantid" class="form-control" id="merchantid">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($merchantDet as $key => $value) {
                                                        echo '<option value="'.$value['mer_map_id'].'">'.$value['mer_map_id'].' - '.$value['merchant_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-sm-3">
                                                <label>Terminal ID</label><BR>
                                                <input class="form-control" type="text" name="terminalid">
                                            </div> -->

                                            <div class="col-md-3">
                                                <label>Terminal ID</label>
                                                <select class="form-control m-b" name="terminalid" id="terminal_id">
                                                    <option value="">-- Terminal ID --</option>
                                                </select>
                                                <input type="hidden" name="qrcode" id="qrcode_1" value="">
                                            </div>
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

        $("#merchantid").change(function () {
            // alert($(this).val());
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    // contentType: 'application/json',
                    // dataType: 'json',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'m_id': $(this).val(), 'type':'getmerchant'})
                })
                .done(function( msg ) {
                    console.log(msg);
                    $("#terminal_id").html(msg);
                });
            } else {
                // alert("Hi");
                var msg = '<option value="">-- Terminal ID --</option>';
                $("#terminal_id").html(msg);
            }
        });


        $("#qrcode").hide();
        $("#qrcode_btn").hide();
        $("#terminal_id").change(function () {
            // alert($(this).val());
            console.log($(this).val());
            if($(this).val()){
                $.ajax({
                    type: 'POST',
                    url: 'php/inc_reportsearch1.php',
                    data: JSON.stringify({'t_id': $(this).val(), 'type':'getterminalQR'})
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
    // 	$('.sparkline').sparkline('html', { enableTagOptions: true });
    // });

</script>

<!--script src="js/demo/chartjs-demo.js"></script-->


<?php require_once('footer.php'); ?>

