<?php
require_once('php/inc_login.php');
$msg = '';
if (isset($_GET['logout']))
{
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
if (isset($_POST['username']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = loginUser($username, $password);
    if ($result != false)
    {
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
        $_SESSION['id'] = $result['id'];
        $_SESSION['iid'] = $result['id']; //<--need to encrypt this
        $_SESSION['username'] = $result['username'];
        $_SESSION['first_name'] = $result['first_name'];
        $_SESSION['last_name'] = $result['last_name'];
        $_SESSION['user_type'] = $result['user_type'];
        header("location:/dashboard.php"); //to redirect back to "index.php" after logging out
        exit();
    }
    else
    {
        $msg = '<div class="error">Bad Username/Password</div>';
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
    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <div>
                    <h1 class="logo-name"><img src="/img/logo.jpg"  alt="logo"  width="200px"/></h1>
                </div>
<?php echo $msg; ?>
                <form class="m-t" role="form" action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <a href="forgot-password.php"><small>Forgot password?</small></a>
                    <!--p class="text-muted text-center"><small>Do not have an account?</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a-->
                </form>
                <p class="m-t"> <small> &copy; 2016</small> </p>
            </div>
        </div>

    </body>

</html>