<?php
error_reporting(0);
require_once('php/inc_login.php');

$msg = '<span style="color:red">';
$fpkeyused = false;
if (isset($_GET['fpkey']) && $_GET['fpkey'] != '')
{
    $fpkeyused = true;
    if (fpcheckreset($_GET['fpkey']))
    {
        $newpass = substr(str_shuffle(str_repeat("23456789abcdefghkmnpqrstuvwxyz", 8)), 0, 8);
        $new_hash = create_hash($newpass);
        $userid = fpgetid($_GET['fpkey']);
        if (ResetPass($userid, $new_hash))
        {
            $msg .= ' The new password for this account is: <b>' . $newpass . '</b>';
        }
        else
        {
            $msg .='Opps Something Happened and your password was not updated!';
        }
    }
    else
    {
        $msg .= ' link has expired or is invalid';
    }
}
if (isset($_POST['username']))
{
    if (checkEmailUser($_POST['email'], $_POST['username']))
    {
        $fpstring = fpstring($_POST['username']);
        $url = "http://10.162.104.215/Spaysez/new_password.php?fpkey=" . $fpstring;
        header('Location: ' . $url);
        exit();
        /*if (forgotPass($_POST['email'], $_POST['username']))
        {
            $msg .= ' An email has been dispatched to the email provided with a link to reset your password.';
        }
        else
        {
            $msg .= ' The Email has failed to be sent please contact support';
        }*/
    }
    else
    {
        $msg .= ' The Email and Username does not match.';
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

    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <div>
                    <!-- <h1 class="logo-name"><img src="/img/logo2.jpg"  alt="logo" width="300px" /></h1> -->
                    <h1 class="logo-name"><img src="img/spimg/Logo-Transparent.png"  alt="logo" width="300px" /></h1>
                </div>
<?php
echo $msg;
if (!$fpkeyused)
{
    ?>
                    <h2>Reset Password</h2>
                    <label for="title">Forgot your password? <!--We will resend you your password.-->Please enter your email address below to receive it.</label>
                    <form class="m-t" role="form" action="#" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""; ?>" required="">
                            <input type="username" class="form-control" placeholder="Username" name="username" required="">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Reset Password</button>


    <!--p class="text-muted text-center"><small>Do not have an account?</small></p>
    <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a-->
                    </form>
    <?php
}
?><br/>
                <a href="login.php"><small>Return to Login</small></a>&nbsp; | &nbsp;
					<a href="passwordpolicy.php"><small>Password Policy</small></a>
                <p class="m-t"> <small> &copy; <?php echo date("Y") ?></small> </p>
            </div>
        </div>

    </body>

</html>
