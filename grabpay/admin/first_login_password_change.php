<?php
require_once('php/inc_login.php');  
session_start();

if (isset($_POST['newpass']) && isset($_POST['cnewpass']))
{
    if($_POST['newpass'] !== $_POST['cnewpass']) {
        $msg = ' The new password and confirm password does not match';
    } else {
		$new_hash = create_hash($_POST['newpass']);
        $userid = $_SESSION['id'];
        if (updatePassword($userid, $new_hash))
        {
            header("location:/testspaysez/dashboard.php");
            exit();
        }
        else
        {
            $msg ='Opps Something Happened and your password was not updated!';
        }
    }
}

?>  

<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Transaction Management</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="manifest" href="/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script><!-- jQuery Library-->
        <script src="js/pwstrength.js"></script><!-- Include Your jQUery file here for password strength-->
    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <div>
                <!-- <h1 class="logo-name"><img src="img/logo2.jpg"  alt="logo"  width="300px"/></h1> -->
                <!-- <h1 class="logo-name"><img src="img/Spaysezlogo.jpg"  alt="logo"  width="300px"/></h1> -->
                <h1 class="logo-name"><img src="img/spimg/Logo-Transparent.png"  alt="logo" width="300px"/></h1>
                </div>
                <?php echo $msg; ?>
                <label for="title">Reset your password</label>
                <form class="m-t" role="form" action="#" method="post">
					<div class="row">
						<div class="form-group">
							<input id="password" name="newpass" type="password" class="form-control" placeholder="New Password" required="" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" minlength="8">
						</div>
						<div class="form-group">
							<input id="cnewpass" name="cnewpass" type="password" class="form-control" placeholder="Confirm New Password" required="" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" minlength="8">
						</div>
						<h5>Password must contain atleast 1 uppercase, 1 lowercase, 1 number, 1 symbol, min 8 chars and max 12 chars.</h5>
                        <div class="form-group" id="progress_bar">
                            <div class="pwstrength_viewport_progress"></div>
                        </div>
                        <div class="form-group">
                        	<button type="submit" class="btn btn-w-m btn-primary">Change Password</button>
                        </div>
						<br><br>
						<a href="passwordpolicy.php"><b>Password Policy</b></a>
					</div>
	            </form>
                <p class="m-t"> <small> &copy; 2018</small> </p>
            </div>
        </div>

    </body>

</html>



<!--<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Change Password</div>
            <div class="panel-body">
			<label for="title"><?php echo $msg; ?></label><br />
			
			<br />
			<form class="m-t" role="form" action="#" method="post" id="changepass-form">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<input id="oldpassword" name="oldpassword" type="text" class="form-control" placeholder="Old Password">
						</div>
						<div class="form-group">
							<input id="newpass" name="newpass" type="text" class="form-control" placeholder="New Password">
						</div>
						<div class="form-group">
							<input id="cnewpass" name="cnewpass" type="text" class="form-control" placeholder="Confirm New Password">
						</div>
						<button type="submit" class="btn btn-w-m btn-primary">Change Password</button>
						<br><br>
						<a href="passwordpolicy.php"><b>Password Policy</b></a>
					</div>
				</div>
            </form>
        </div>
	</div>
    <div class="col-lg-6"></div>
</div> -->           
<?php require_once('footerjs.php'); ?>
<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>

<script>
	$(document).ready(function(){
		$.validator.addMethod("pwcheck", function(value) {
		   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
			   && /[a-z]/.test(value) // has a lowercase letter
			   && /\d/.test(value) // has a digit
		});
		$("#changepass-form").validate();	
	});
</script>