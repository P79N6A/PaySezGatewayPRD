<?php

function active($currect_page){

  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;

  $url = end($url_array);  

  if($currect_page == $url){

      echo 'active'; //class name in css 

  } 

}

?>

<nav class="navbar-default navbar-static-side" role="navigation">

            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>

                            <!--img alt="image" class="img-circle" src="img/profile_small.jpg" /-->

                             </span>

                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <span class="clear"> 

								<span class="block m-t-xs"> 

								<strong class="font-bold">

									<?php

									function getUserdata2($id){

									global $db;

										$db->where("id",$id);

										$data = $db->getOne("users");

										return $data;

									}

									$username = getUserdata2($_SESSION['iid']);

									if(isset($username['username'])){

										echo $username['username'];

									} 

									?>

								</strong>

								 </span> 

								 <span class="text-muted text-xs block">

								 <?php

								 if(isset($username['user_type'])){

									 switch ($username['user_type']) {

										case 1:

											echo "Master Administrator";

											break;

										case 2:

											echo "Agent";

											break;

										case 3:

											echo "Agent";

											break;

										case 4:

											echo "Merchant";

											break;

										case 5:

											echo "Merchant";

											break;

										case 6:

											echo "Merchant";

											break;

										case 7:

											echo "Agent";

											break;

									}

								}

								?>

								 <b class="caret"></b>

								 </span> 

							 </span> </a>

                            <ul class="dropdown-menu animated fadeInRight m-t-xs">

								<!--li><a href="viewagent.php">Profile</a></li><li class="divider"></li-->

                                <!--li><a href="options.php">Options</a></li><li class="divider"></li-->

								<li><a href="change-password.php">Change Password</a></li><li class="divider"></li>

                                <?php 

								if(isset($_SESSION['id']) && $_SESSION['id'] != $_SESSION['iid']){

									echo '<li><a href="dashboard.php?ilogout=true">Impersonate Logout</a></li>';	

								}else{

									echo '<li><a href="login.php?logout=true">Logout</a></li>';

								}

								?>

                            </ul>

                        </div>

                        <div class="logo-element">

                            P

                        </div>

                    </li>

					<?php 

					$usertype = $username['user_type'];

					if(isset($usertype)){

						if($usertype != 6 ){

					?>

                    <li class="<?php active('dashboard.php');?>">

                        <a href="dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>

                    </li>

					<?php

						}

					}

					if(isset($usertype)){

						if($usertype == 1){

					?>

                    <li class="<?php active('fees.php');active('processors.php');active('processormerchantmanager.php'); ?>">

                        <a href=""><i class="fa fa-magic"></i><span class="nav-label">Administration</span> <span class="fa arrow"></span></a>

						<ul class="nav nav-second-level">

							<li class="<?php active('processors.php');active('processormerchantmanager.php');?>"> <a href=""><i class="fa fa-money"></i> <span class="nav-label">Processors</span><span class="fa arrow"></span></a>

								<ul class="nav nav-third-level">

									<li class="<?php active('processors.php');?>"> <a href="processors.php"><span class="nav-label">Add/Edit Processor</span> </a></li>

									<li class="<?php active('processormerchantmanager.php');?>"> <a href="processormerchantmanager.php"><span class="nav-label">Assign Merchants</span> </a></li>

								</ul>

							</li>

							<li class="<?php active('fees.php');?>"> <a href="fees.php"><i class="fa fa-dollar"></i> <span class="nav-label">Fees</span></a>

							</li>

						</ul>

                    </li>

					<?php

						}

					}

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 ){

					?>

                    <li class="<?php active('reports.php');?>">

                        <a href="reports.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> </a>

                    </li>  
				
					<?php

						} elseif($usertype == 4 || $usertype == 5) {

							?>

							 <li class="<?php active('reports.php');?>">

								<a href="merchantreports.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> </a>

							</li>

							<?php

						}

					}
if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 ){

					?>

                    <li class="<?php active('reports1.php');?>">

                        <a href="reports1.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> </a>

                    </li>  
				
					<?php

						} elseif($usertype == 4 || $usertype == 5) {

							?>

							 <li class="<?php active('reports1.php');?>">

								<a href="merchantreports.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports Chart</span> </a>

							</li>

							<?php

						}

					}
					
					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 || $usertype == 2){

					?>

                    <li class="<?php active('addagent.php');?>">

                        <a href="addagent.php"><i class="fa fa-user"></i> <span class="nav-label">Add Agent</span> </a>

                    </li>

					<?php

						}

					}

					if(isset($usertype)){

					//do a check here to test if current logged in user has an agent_id before allowed to create a merchant (not in scope)

						if(($usertype == 1 || $usertype == 3 || $usertype == 2) && ($username['agent_id'] > 0)){

					?>

                    <li class="<?php active('addmerchant.php');?>">

                        <a href="addmerchant.php"><i class="fa fa-male"></i> <span class="nav-label">Add Merchant</span> </a>

                    </li>

					<?php

						}

					}

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 || $usertype == 2){

						?>

                    <li class="<?php active('users.php');?>">

                        <a href="users.php"><i class="fa fa-group"></i> <span class="nav-label">Users</span> </a>

                    </li>

					<?php

						}

					}

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 || $usertype == 5){

							?>

							<li class="<?php active('chargebacks.php');active('chargebacks.php?type=cb');?>">

								<a href="chargebacks.php"><i class="fa fa-bank"></i> <span class="nav-label">Chargebacks</span> <span class="fa arrow"></span></a>

								<ul class="nav nav-second-level collapse" aria-expanded="false">

									<li class="<?php active('chargebacks.php?type=cb');?>"><a href="chargebacks.php?type=cb">Search Chargebacks</a></li>

								</ul>

							</li>

							<?php

						}

					}

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 4 || $usertype == 5 || $usertype == 6){

							?>

							<!--li>

								<a href="http://162.248.89.211/api/samplesmartroform.php" target="_blank"><i class="fa fa-desktop"></i> 

								<span class="nav-label">Smartro Transaction</span> </a>

							</li-->

							

						<li class="<?php active('virtualterminal.php');active('virtualterminal.crv.php');?>">

							<a href="virtualterminal.php"><i class="fa fa-desktop"></i> <span class="nav-label">Virtual Terminal</span> <span class="fa arrow"></span></a>

							<ul class="nav nav-second-level collapse" aria-expanded="false">

								<li class="<?php active('virtualterminal.php');?>"><a href="virtualterminal.php">Sales and Authorizations</a></li>

								<li class="<?php active('transactions.php');?>"><a href="transactions.php">Search Transactions</a></li>

								<!--li class="<?php active('virtualterminal.crv.php');?>"><a href="virtualterminal.crv.php">Captures, Refunds and Voids</a></li-->

							</ul>

						</li>

						<?php

						}

						

						if($usertype == 4 || $usertype == 5 || $usertype == 6){

							?>

							<li>

								<a href="merchantapi.php"><i class="fa fa-key"></i> 

								<span class="nav-label">API</span> </a>

							</li>

							

						<?php

						}

					}

					?>

                </ul>



            </div>

        </nav>