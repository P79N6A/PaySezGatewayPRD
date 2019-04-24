<?php
date_default_timezone_set('Asia/Kolkata');

function randomGen($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

$random_num_arr = randomGen(0,20,1); //generates 20 unique random numbers
$random_num     = sprintf("%03d", $random_num_arr[0]);
?>
<!DOCTYPE html>
<html>
<body>

<h2><center>POS</center></h2>
<div class="content" id="pay" style="display:block;">
        <div class="col-sm-4"></div>
        <div class="col-sm-3">
            <a href="https://www.alipay.com/" class="logo"><img src="img/alipay_logo.png" style="height: 100px; width:100%;"></a><br><br>
            <!-- <form action="alipayapi.php" class="alipayform" method="post" target="_blank"> -->
            <form id="ismForm" action="https://paymentgateway.test.credopay.in/testspaysez/alipayapi_pos_loadtest.php" class="alipayform" method="post">
                <?php $tno="E0000001".date('Ymdhis').$random_num; ?>
                <input type="hidden" name="device" id="device" value="pos">
                <input type="hidden" name="WIDproduct_code" value="OVERSEAS_MBARCODE_PAY" id="product_codeqrpay">
                <input type="hidden" name="WIDsubject" value="Alipay" id="subjectqrpay">
            <table>
                <tr id="tno"><td><b>TERMINAL ID(partner trans id)</b></td><td><input type="text" name="terminal_id" id="terminal_id" value="E0000001"></td></tr>
                <tr id="amt"><td><b>AMOUNT</b></td><td><input type="text" name="amount" id="WIDtotal_fee" value="1"></td></tr>
                <!-- <tr id="ra"><td><b>REFUND AMOUNT</b></td><td><input type="text" name="return_amount" id="return_amount" value=""></td></tr> -->
                <tr id="crncy"><td><b>CURRENCY:</b></td><td>
                <select class="form-control" name="currency" id="currency">
                    <option value="USD">USD</option>
                    <option value="SGD">SGD</option>
                    <option value="MYR">MYR</option>
                    <option value="LKR">LKR</option>
                </select><br></td></tr>
                <tr id="otn"><td><b>OUT TRADE NO</b></td><td><input type="text" name="out_trade_no" id="out_trade_no" value="<?php echo $tno; ?>"></td></tr>
                <tr id="otn"><td><b>Call Back URL</b></td><td><input type="text" name="callback_notify_url" id="callback_notify_url" value="https://123.231.14.207:8080/AliPayCallBack/CallBack"></td></tr>
                <tr id="tmstmp"><td><b>TERMINAL TIME</b></td><td><input type="text" name="terminal_timestamp" id="terminal_timestamp" value="<?php echo date('Ymdhis'); ?>"></td></tr>
                <tr><td><b>TRANSACTION TYPE</b></td><td>
                <select class="form-control" name="tran_req_type" id="tran_req_type">
                    <option value="1">PURCHASE</option>
                    <option value="2">REFUND</option>
                    <option value="3">QUERY</option>
                    <option value="4">CANCEL</option>
                </select><br></td></tr>
                <tr><td></td><td><!-- <input type="submit" name="submit" class="btn btn-primary form-control" value ="Pay"> --></td></tr>
            </table>
                    
            </form>
        </div>
        <div class="col-sm-5"></div>
    </div>

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function() {
        // document.getElementById("formtest").submit();
        $("#ismForm").submit();
    });
    // document.getElementById("formtest").submit();
    </script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script>
                    $('#ttype').on('change',function(){
                        //alert("hi");exit;
                    if( $(this).val()==="1"){
                    $("#ra").hide()
                    $("#tno").show()
                    $("#crncy").show()
                    $("#otn").show()
                    $("#amt").show()
                    $("#tmstmp").show()
                    }
                    if( $(this).val()==="2"){
                    $("#ra").show()
                    $("#tno").show()
                    $("#crncy").show()
                    $("#otn").show()
                    $("#amt").hide()
                    $("#tmstmp").hide()

                    }
                    if( $(this).val()==="4"){
                    $("#tno").show()
                    $("#otn").show()
                    $("#tmstmp").show()
                    $("#amt").hide()
                    $("#crncy").hide()
                    $("#ra").hide()
                    }
                    if( $(this).val()==="3"){
                    $("#tno").show()
                    $("#otn").show()
                    $("#tmstmp").hide()
                    $("#amt").hide()
                    $("#crncy").hide()
                    $("#ra").hide()
                    }
                    
                        });
                </script>
               -->

</body>
</html>


























