<!-- <pre lang="php"> -->
<?PHP
header('X-Frame-Options: SAMEORIGIN');
?>
<!-- </pre> -->

<?php

header("Location: login.php");



?>



<!DOCTYPE html>

<html>



<head>



    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title> Transaction Management</title>



    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">



    <link href="css/animate.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">



</head>



<body class="gray-bg">



    <div class="middle-box text-center loginscreen  animated fadeInDown">

        <div>

            <div>

                <h1 class="logo-name"><img src="img/Profitorious.png"  alt="Profitorious" /></h1>

            </div>

            <form class="m-t" role="form" action="dashboard.php">

                <div class="form-group">

                    <input type="text" class="form-control" placeholder="Username" required="">

                </div>

                <div class="form-group"> 

                    <input type="password" class="form-control" placeholder="Password" required="">

                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>



                <a href="#"><small>Forgot password?</small></a>

                <!--p class="text-muted text-center"><small>Do not have an account?</small></p>

                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a-->

            </form>

            <p class="m-t"> <small>Profitorius &copy; 2015</small> </p>

        </div>

    </div>



</body>



</html>

