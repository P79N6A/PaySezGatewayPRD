<?php
error_reporting(0);
require_once('php/inc_login.php');

$msg = '<span style="color:red">';
$fpkeyused = false;
if (isset($_GET['fpkey']) && $_GET['fpkey'] != '')
{
    $fpkeyused = false;
    if (fpcheckreset($_GET['fpkey']))
    {
        $newpass = substr(str_shuffle(str_repeat("23456789abcdefghkmnpqrstuvwxyz", 8)), 0, 8);

        $oldPassword = $newpass;           
        $msg .= ' The code to generate new password for this account is: <b>' . $newpass . '</b>';


        /*$new_hash = create_hash($newpass);
        $userid = fpgetid($_GET['fpkey']);
        if (ResetPass($userid, $new_hash))
        {
            $oldPassword = $newpass;           
            $msg .= ' The code to generate new password for this account is: <b>' . $newpass . '</b>';
        }
        else
        {
            $msg .= 'Opps Something Happened and your password was not updated!';
        }*/
    }
    else
    {
        $msg .= ' link has expired or is invalid';
    }
}
if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword']))
{
    if($_POST['newPassword'] !== $_POST['confirmPassword']) {
        $msg .= ' The new password and confirm password does not match';
    } else {
        $new_hash = create_hash($_POST['newPassword']);
        $userid = fpgetid($_GET['fpkey']);
        if (ResetPass($userid, $new_hash))
        {
            $url = "http://10.162.104.215/testspaysez/grabpay/admin/login.php";
            header('Location: ' . $url);
            exit();
        }
        else
        {
            $msg .='Opps Something Happened and your password was not updated!';
        }
    }
}
$msg .= '</span>';
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>- Transaction Management</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script><!-- jQuery Library-->
        <script src="js/pwstrength.js"></script><!-- Include Your jQUery file here-->

    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <div>
                    <h1 class="logo-name"><img src="/img/logo2.jpg"  alt="logo" width="300px" /></h1>
                </div>
<?php
echo $msg;
if (!$fpkeyused)
{
    ?>
                    <h2>Update Password</h2>
                    <label for="title">Reset your password</label>
                    <form class="m-t" role="form" action="#" method="post">
                        <div class="form-group" id="pwd-container">
                            <input type="text" class="form-control" placeholder="Old Password" name="oldPassword" value="<?php echo isset($oldPassword) ? $oldPassword : ""; ?>" required="" readonly/>
                            <input type="password" class="form-control" placeholder="New Password" id="password" name="newPassword" required="" title="Password must be atleast 8 characters including 1 uppercase letter, 1 lowercase letter, 1 special character and numeric characters" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" minlength="8">
                            <input type="text" class="form-control" placeholder="Confirm Password" name="confirmPassword" required="" title="Password must be atleast 8 characters including 1 uppercase letter, 1 lowercase letter, 1 special character and numeric characters" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" minlength="8">
                            <h5>Password must contain atleast 1 uppercase, 1 lowercase, 1 number, 1 symbol, min 8 chars and max 12 chars.</h5>
                            <div class="form-group" id="progress_bar">
                                <div class="pwstrength_viewport_progress"></div>
                            </div>
                        </div>
                        <!-- <div class="row" id="pwd-container">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="pwstrength_viewport_progress"></div>
                            </div>
                        </div> -->
                        
                        <!-- <div class="row">
                          <div id="messages" class="col-sm-12"></div>
                        </div> -->
                        <button type="submit" id="updatePwdBTN" class="btn btn-primary block full-width m-b">Update Password</button>
                    </form>
    <?php
}
?><br/>
                <a href="passwordpolicy.php" class="m-t"><small>Password Policy</small></a>	
                <p class="m-t"> <small> &copy; <?php echo date("Y") ?></small> </p>
            </div>
        </div>

    </body>

</html>
