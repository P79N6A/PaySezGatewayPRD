<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <a href="/"><img src="/img/logo.jpg" alt="logo" height="50px" style="margin:10px;" /></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="chargebacks.php"><button class="btn btn-outline btn-danger" type="button"><?php #echo $chargebacks ?> New Chargebacks</button></a>
            </li>
            <li>

                <i class="fa fa-sign-out">
                <?php
                if (isset($_SESSION['id']) && $_SESSION['id'] != $_SESSION['iid'])
                {
                    echo '<a href="dashboard.php?ilogout=true">log out</a></i> ';
                }
                else
                {
                    echo '<a href="login.php?logout=true">log out</a></i> ';
                }
                ?>
            </li>
        </ul>

    </nav>
</div>


