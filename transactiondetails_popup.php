<?php 
require_once( 'header.php');
//require_once('head.php');
//require_once('php/inc_dashboard.php');
//check permission
if(!checkPermission('V'))
    include_once('forbidden.php');

require_once( 'php/inc_chargebacks.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<style type="text/css">
    
.modal-dialog.transaction_detail button.close {
    position: absolute;
    top: 0;
    right: 5px;
    z-index: 1200;
    display: block;
}

.modal-dialog.transaction_detail .modal-header,
.modal-dialog.transaction_detail .modal-footer {
    display: none;
}

.modal-dialog.transaction_detail .modal-body {
    padding: 0;
}

.modal-dialog.transaction_detail .modal-content nav {
    display: none;
}

.modal-dialog.transaction_detail .modal-content #page-wrapper {
    width: 100%;
    margin: 0;
}

</style>

<div id="now">
    <!-- <a href="dashboard.php"> -->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size:40px;">×</button>
    <!-- </a> -->
</div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Transaction Details</h2> 
    
        <ol class="breadcrumb">
            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="transactions.php">Transactions</a>
            </li>
            <li class="active">
                <strong>Transaction Details</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Transaction Details</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if($trans["trade_no"]=="") { ?>
                        <span class="pull-right"><input type="button" class="btn btn-success" value="Call Query" onclick="doQuery();"></span>
                    <?php } ?>
                    <table  class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Transaction ID</th>
                            <td><?php echo $trans["id_transaction_id"]; ?></td>
                        </tr>
                        <tr>
                            <th>Out Trade No.</th>
                            <td><?php echo $trans["out_trade_no"]; ?></td>
                        </tr>
                        <tr>
                            <th>Trade No.</th>
                            <td><?php echo $trans["trade_no"]; ?></td>
                        </tr>
                        <tr>
                            <th>Transaction Type</th>
                            <td><?php echo $trans["product_code"]; ?></td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td><?php echo $trans["currency"].' '.number_format($trans["total_fee"],2); ?></td>
                        </tr>
                        <tr>
                            <th>Buyer Id</th>
                            <td><?php echo $trans["buyer_id"]; ?></td>
                        </tr>
                        <tr>
                            <th>Buyer Email</th>
                            <td><?php echo $trans["buyer_email"]; ?></td>
                        </tr>
                        <tr>
                            <th>Seller Id</th>
                            <td><?php echo $trans["res_seller_id"]; ?></td>
                        </tr>
                        <tr>
                            <th>Seller Email</th>
                            <td><?php echo $trans["res_seller_email"]; ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?php
                                if($trans["trade_status"]=='TRADE_FINISHED') echo wordwrap("The trade succeeds and finishes and is not operable",50,"<br>\n");
                                else if($trans["trade_status"]=='TRADE_SUCCESS') echo wordwrap("The trade succeeds and is operable, such as multi-level royalty distribution, refund, etc.",50,"<br>\n");
                                else if($trans["trade_status"]=='TRADE_CLOSED') echo wordwrap("Trade closed whose payment has not been completed within specified time; <br>Trades closed whose payment has been fully returned when the trade completes.",50,"<br>\n");
                                else if($trans["trade_status"]=='WAIT_BUYER_PAY') echo wordwrap("The trade has been established and is waiting for the buyer to make payment.",50,"<br>\n");
                                else echo "Failed"; ?></td>
                        </tr>
                        <tr>
                            <th>Settled Date</th>
                            <td><?php echo $trans["trans_datetime"]; ?></td>
                        </tr>
                        <!--<tr>
                                    <th>Goods Details</th>
                                    <td><?php /*echo $trans["goods_detail"]; */?></td>
                                </tr>
                                <tr>
                                    <th>Extend Params</th>
                                    <td><?php /*echo wordwrap($trans["extend_params"],50,"<br>\n"); */?></td>
                                </tr>-->
                        <tr>
                            <th>Merchant ID</th>
                            <td><?php echo $trans["merchant_id"]; ?></td>
                        </tr>
                        <tr>
                            <th>Response</th>
                            <td><?php echo $trans["trade_status"]; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <?php
            if(!$is_cb){
                ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Refund Transaction</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="vtrefundform">
                            <div class="row">
                                <div class="col-xs-12 form-group required">
                                    <label class="control-label">Transaction ID <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $trans["id_transaction_id"]; ?>" name="TID" class="form-control required" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 form-group required">
                                    <label class="control-label required">Amount <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo number_format($trans["total_fee"],2); ?>" name="amount" id="amount" class="form-control required">
                                    <input type="hidden" value="<?php echo $trans['trans_datetime']; ?>" id="trandate">
                                    <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" id="todaydate">
                                </div>
                                <div class="col-xs-4 form-group required">
                                    <label class="control-label">Tax <span class="text-danger">*</span></label>
                                    <input type="text" value="0" name="tax" class="form-control required">
                                </div>
                                <div class="col-xs-4 form-group required">
                                    <label class="control-label">Currency <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $trans["currency"]; ?>" name="currency" class="form-control required" readonly>
                                </div>
                            </div>
                            <div class='row'>
                                <!-- <div class='col-xs-12 form-group'>
                                    <input type="hidden" value="<?php //echo $api_key; ?>" name="apikey" class="form-control">
                                    <input type="hidden" value="test" name="env" class="form-control">
                                    <input type="hidden" value="1" name="PartialCancelCode" id="partial" class="form-control">
                                    <input type="hidden" value="AC" name="TransactionType" class="form-control">
                                    <div class="refundresult"></div>
                                    <a class="btn btn-lg btn-primary btn-block refund"
                                    href="transaction.php?t_id=<?php //echo $trans["id_transaction_id"];?>">Cancel</a>
                                </div>
                                <div class='col-xs-12 form-group'>
                                    <button class="btn btn-lg btn-primary btn-block refund" type="submit">Refund</button>
                                </div> -->

                                <div class='col-xs-12 form-group threebtns'>
                                    <input type="hidden" value="<?php echo $api_key; ?>" name="apikey" class="form-control">
                                    <input type="hidden" value="test" name="env" class="form-control">
                                    <input type="hidden" value="1" name="PartialCancelCode" id="partial" class="form-control">
                                    <input type="hidden" value="AC" name="TransactionType" class="form-control">
                                    <div class="refundresult"></div>
                                    <div class="btn-group">
                                        <!-- <button type="button" class="btn btn-primary">Cancel</button>
                                        <button type="button" class="btn btn-primary">Refund</button>
                                        <button type="button" class="btn btn-primary">Partial Refund</button> -->
                                    
                                        <input type="button" class="btn btn-primary" onclick="doCancel();" value="Cancel" <?php if($trans["cancel_flag"]==1) echo
                                        "disabled"; ?>>
                                        <input class="btn btn-primary" type="button" onclick="doRefund();" value="Refund" <?php if($trans["refund_flag"]==1) echo
                                        "disabled"; ?>>
                                        <input class="btn btn-primary" type="button" onclick="doPartialRefund();" value="Partial Refund" <?php if($trans["refund_flag"]==1) echo
                                        "disabled"; ?>></input>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="ibox float-e-margins" style="display: none;">
                <div class="ibox-title">
                    <h5>Credit Card Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table  class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Credit card</th>
                            <td><?php echo $cc_last4; ?></td>
                        </tr>
                        <tr>
                            <th>Credit card Type</th>
                            <td><?php echo $cc_type; ?></td>
                        </tr>
                        <tr>
                            <th>Expire</th>
                            <td><?php echo $cc_exp; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Customer Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table  class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Billing Address:</th>
                            <th>Shipping Address:</th>
                        </tr>
                        <tr>
                            <td><?php
                                // echo $merchantDatas["first_name"]." ".$merchantDatas["last_name"]."<br />";
                                echo $merchantDatas["merchant_name"]."<br />";
                                if($merchantDatas["company"] != " ") echo $merchantDatas["company"]."<br />";
                                echo $merchantDatas["address1"]." ".$merchantDatas["address2"]."<br />";
                                echo $merchantDatas["city"]." ".$merchantDatas["us_state"]."<br />";
                                echo $merchantDatas["zippostal_code"]." ".$merchantDatas["country"]."<br />";
                                echo $merchantDatas["csemail"]."<br />";
                                echo $merchantDatas["csphone"]."<br />";
                                ?></td>
                            <td><?php
                                echo $trans["shipping_first_name"]." ".$trans["shipping_last_name"]."<br />";
                                if($trans["shipping_company"] != " ") echo $trans["company"]."<br />";
                                echo $trans["shipping_address1"]." ".$trans["shipping_address2"]."<br />";
                                echo $trans["shipping_city"]." ".$trans["shipping_us_state"]."<br />";
                                echo $trans["shipping_postal_code"]." ".$trans["shipping_country"]."<br />";
                                echo $trans["shipping_email"]."<br />";
                                echo $trans["shipping_carrier"]." ".$trans["tracking_number"]."<br />";
                                echo $trans["shipping_date"]."<br />";
                                ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($is_cb){ ?>
                <div class="ibox float-e-margins" style="display: none;">
                    <div class="ibox-title">
                        <h5>Chargeback Data</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table  class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Reference Number</th>
                                <td><?php echo $cb["ACQ_REF_NR"]; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo $cb["name"]; ?></td>
                            </tr>
                            <tr>
                                <th>Dispute Result</th>
                                <td><?php echo $cb["dispute_result"]; ?></td>
                            </tr>
                            <tr>
                                <th>Chargeback Amount</th>
                                <td><?php echo number_format($cb["cb_amount"], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Reason Code</th>
                                <td><?php echo $cb["reason_code"]; ?></td>
                            </tr>
                            <tr>
                                <th>Response Date</th>
                                <td><?php echo $cb["response_date"]; ?></td>
                            </tr>
                            <tr>
                                <th>Update Date</th>
                                <td><?php echo $cb["update_date"]; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!--div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="related">
                <div class="ibox-title">
                    <h5>Related Transactions</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div id="related_content"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="customerhistory">
                <div class="ibox-title">
                    <h5>Customer Transaction History</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div id="customerhistory_content"></div>
                </div>
            </div>
        </div>
    </div-->
    
</div>
<input type="hidden" id="t_id" name="t_id" value="<?php echo $t_id; ?>" />
<input type="hidden" id="customer_email" name="customer_email" value="<?php echo $trans["email"]; ?>" />
<?php require_once( 'footerjs.php'); ?>
<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<!-- Chosen -->
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
<script>
    function doCancel() {
        var trandate=$('#trandate').val();
        var todaydate=$('#todaydate').val();

        todaydate=new Date(todaydate);
        trandate=new Date(trandate);

        var difference = todaydate - trandate;
        var daysDifference = Math.floor(difference/1000/60/60);

        // if(daysDifference < 24){
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to cancel?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: function () {
                    $.ajax({
                        method: "POST",
                        url: "alipayapi.php",
                        dataType: "json",
                        data: {from:'pg', action: '4', timestamp: '<?php echo $trans['timestamp']; ?>', WIDout_trade_no: '<?php echo $trans['out_trade_no']; ?>'}
                    })
                        .done(function (msg) {
                            $.alert({
                                title: 'Cancellation !',
                                content: msg['res'] + "\n\n" + msg['desc'],
                                type: 'green',
                                typeAnimated: true,
                            });
                        });
                },
                cancel: function () {

                }
            }
        });
        /*}
        else {
            alert("Unable to perform cancel after 24 hours. Try refund");
        }*/
    }

    function doRefund() {

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to Refund whole amount?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: function () {
                    $.ajax({
                        method: "POST",
                        url: "alipayapi.php",
                        dataType: "json",
                        data: {from:'pg', action: '3', currency: '<?php echo $trans['currency']; ?>', return_amount: '<?php echo $trans['total_fee']; ?>', partner_refund_id:
                                '<?php echo
                            $trans['trade_no'];
                                ?>',
                            partner_trans_id:
                                '<?php echo $trans['out_trade_no']; ?>'}
                    })
                        .done(function (msg) {
                            $.alert({
                                title: 'Refund !',
                                content: msg['res'] + "\n\n" + msg['desc'],
                                type: 'green',
                                typeAnimated: true,
                            });
                        });
                },
                cancel: function () {

                }
            }
        });


    }

    function doPartialRefund() {


        $.confirm({
            title: 'Confirm!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Enter refund amount</label>' +
            '<input type="text" placeholder="Maximum of <?php echo number_format($trans['total_fee'],2); ?>" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Refund amount should not be empty..!');
                            return false;
                        }
                        var tot = <?php echo $trans['total_fee']; ?>;
                        var rgx = /^[0-9]*\.?[0-9]*$/;
                        if(name.match(rgx)==null){
                            $.alert("Entered Invalid amount");
                        } else {
                            if(name <= tot){
                                $.ajax({
                                    method: "POST",
                                    url: "alipayapi.php",
                                    dataType: "json",
                                    data: {from:'pg', action: '3', currency: '<?php echo $trans['currency']; ?>', return_amount: name, partner_refund_id: '<?php echo
                                        $trans['trade_no'];
                                            ?>',
                                        partner_trans_id:
                                            '<?php echo $trans['out_trade_no']; ?>'}
                                })
                                    .done(function (msg) {
                                        $.alert({
                                            title: 'Partial Refund !',
                                            content: msg['res'] + "\n\n" + msg['desc'],
                                            type: 'green',
                                            typeAnimated: true,
                                        });

                                    });
                            } else {
                                $.alert("Refund amount Exceeded");
                            }

                        }
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function doQuery() {

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to call Query API?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: function () {
                    $.ajax({
                        method: "POST",
                        url: "alipayapi.php",
                        data: {from:'pg', action: '8', out_trade_no: '<?php echo $trans['out_trade_no']; ?>'}
                    })
                        .done(function (msg) {
                            if(msg==1){
                                $.alert({
                                    title: 'Query API !',
                                    content: "Query API processed successfully",
                                    type: 'green',
                                    typeAnimated: true,
                                });
                            } else {
                                $.alert({
                                    title: 'Query API !',
                                    content: "Query API process failed",
                                    type: 'green',
                                    typeAnimated: true,
                                });
                            }

                        });
                },
                cancel: function () {

                }
            }
        });


    }

$(document).ready(function(){
    $("#vtrefundform").validate({
        submitHandler: function(form) {
            if($("#amount").val() < <?php echo $trans["total_fee"]; ?>)
            {
                $("#partial").val(1);
            } else {
                $("#partial").val(0);
            }
            $(".refundresult").html("Sending...please wait");
            
            $.ajax({
                method: "POST",
                url: "../api/smartro.php",
                data: $("#vtrefundform").serializeArray()
            })
            .done(function( msg ) {
                var result;
                if(msg.success == 0){
                    result = '<div class="alert alert-danger">'+msg.ResponseMessage+'</div>';
                } else {
                    result = '<div class="alert alert-success">'+msg.ResponseMessage+'</div>';
                }
                $(".refundresult").html(result);
            });
        }
    }); 
    $("#related .fa-chevron-down").click(function () {
        $("#related_content").html("Loading...");
        $.ajax({
            method: "POST",
            url: "php/inc_relatedtransactions.php",
            data: { t_id: $("#t_id").val() }
        })
        .done(function( msg ) {
            $("#related_content").html(msg);
        });
    });
    
    $("#related .fa-chevron-up").click(function () {
        $('#related_content').hide();
    });
    
    $("#customerhistory .fa-chevron-down").click(function () {
        $("#customerhistory_content").html("Loading...");
        $.ajax({
            method: "POST",
            url: "php/inc_customertransactionshistory.php",
            data: { customer_email: $("#customer_email").val() }
        })
        .done(function( msg ) {
            $("#customerhistory_content").html(msg);
        });
    });
    
    $("#customerhistory .fa-chevron-up").click(function () {
        $('#customerhistory_content').hide();
    });
        
});
</script>
<?php require_once('footer.php'); ?> 