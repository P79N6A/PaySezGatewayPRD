<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!-- <a href="/"><img src="img/logo2.jpg" alt="logo" height="50px" style="margin:10px;" /></a> -->
            <!-- <a href="/Spaysez/dashboard.php"><img src="img/Spaysezlogo.jpg" alt="logo" height="40px" style="margin:10px;" /></a> -->
            <a href="/testspaysez/dashboard.php"><img src="img/spimg/Logo-Transparent.png" alt="logo" height="40px" style="margin:10px;" /></a>
        </div>
        <!-- <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="chargebacks.php"><button class="btn btn-outline btn-danger" type="button"><?php #echo $chargebacks ?> New Chargebacks</button></a>
            </li>
            <li>

                <i class="fa fa-sign-out">
                <?php
                // if (isset($_SESSION['id']) && $_SESSION['id'] != $_SESSION['iid'])
                // {
                //     echo '<a href="dashboard.php?ilogout=true">log out</a></i> ';
                // }
                // else
                // {
                //     echo '<a href="login.php?logout=true">log out</a></i> ';
                // }
                ?>

            </li>
        </ul> -->

        <!-- <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $_SESSION['iid']) { ?>
        <a class="btn btn-default btn-sm logoutbtn" href="dashboard.php?ilogout=true" role="button">
            <span class="glyphicon glyphicon-log-out"></span>Log out
        </a>
        <?php } else { ?>
        <a class="btn btn-default btn-sm logoutbtn" href="login.php?logout=true" role="button">
            <span class="glyphicon glyphicon-log-out"></span>Log out
        </a>
        <?php } ?> -->

        <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $_SESSION['iid']) { ?>
        <div class="navigation">
            <a class="button" href="dashboard.php?ilogout=true">
                <img src="img/logout-img.png">
                <div class="logout">LOGOUT</div>
            </a>
        </div>
        <?php } else { ?>
        <div class="navigation">
            <a class="button" href="login.php?logout=true">
                <img src="img/logout-img.png">
                <div class="logout">LOGOUT</div>
            </a>
        </div>
        <?php } ?>

    </nav>
</div>


