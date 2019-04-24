<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 26-08-2017
 * Time: 02:52 PM
 */
error_reporting(0);
session_start();
//echo $_SESSION['loaded'];
if ($_SESSION['mangaaaa']=="yes")
{
    // insert query here
	$_SESSION['mangaaaa'] = "";
	unset($_SESSION["mangaaaa"]);
	session_destroy();
	//header('Refresh:1; url= responsemerchant.php?success=false&trans=cancel&txn=null&errordesc=');
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Response</title><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<br>
<div class="container">
    <div class='row'>
	</div>
    <hr class="featurette-divider"></hr>
    <?php if($_GET['rurl']!=""){
        if($_POST['authenticationStatus']=="Y" || $_POST['authenticationStatus']=="A"){
            $conurl=hex2bin($_GET['rurl']).'&success=true&txn='.$_POST['transactionId'];
        }
        else {
            $conurl=hex2bin($_GET['rurl']).'&success=false&txn=null';
        }

        ?>
    <form action="<?php echo $conurl; ?>" id="frm1" method="POST">
    <?php
    }
    else {
        $urll=$_GET['rrurl'];
        $tid=$_GET['tid'];
        $suces=$_GET['success'];
        ?>

    <form action="<?php echo $urll.'&success='.$suces.'&txn='.$tid; ?>" id="frm1" method="POST">
    <?php
    }
    ?>

	<div class='row'>
		<div class='col-md-4'></div>
		<div class='col-md-4 text-center'>
			<div id="canceldiv" style="">
				<div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php if($_POST['details']!=""){ ?>
                        <h4><b><br><?php if($_POST['details']!=""){ echo $_POST['details']; } //$errormessage;?><br><br>
                                <?php if($_POST['authenticationStatus']=="Y" || $_POST['authenticationStatus']=="A"){ echo 'Transaction Successfull. Click OK to Redirect merchant url.'; } ?>
                            </b></h4>
                    <?php } else { ?>
					<h4><b>Transaction was <?php if($_GET['trans']=="cancel"){ echo "Cancelled"; } else if($_GET['trans']=="inactive"){ echo "Timed Out"; } else if($_GET['success']=='true'){ echo 'Transaction Successfull'; } else{ echo "Declined "; } ?><br><?php if($_GET['errordesc']!=""){ echo $_GET['errordesc']; } //$errormessage;?></b></h4> &nbsp; &nbsp; &nbsp;
                    <?php } ?>
                    <button type="hidden" value="submit">Ok</button>
				</div>
			</div>
			</div>
			</div>
		</div>
	<input type="hidden" name="success" value="<?php if($_GET['success']==""){ echo "false"; } else { echo $_GET['success']; }?>"/>
	<input type="hidden" name="txn" value="<?php if($_GET['success']=="false"){ echo "0"; } else { echo $_GET['txn']; }?>"/>
	<input type="hidden" name="errordesc" value="<?php echo $_GET['errordesc']; ?>"/>
</form>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function()
{
	<?php if($_GET['success']=="true"){ ?>
		$("#frm1").submit();
	<?php } ?>
});
</script>
}