<?php
function active($currect_page){
	$url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
	$url = end($url_array);  
	// echo $currect_page.'=>'.$url;
	if($currect_page == $url){
		echo 'active'; //class name in css 
	} 
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
   .nav-second-level li .badge {
     position: relative;
     top: -10px;
     right: 14px;
     /* padding: 5px 10px; */
     border-radius: 140%;
     background-color: #c51e03;
     color: white;
}
.badge {
    background-color: #fb0b00;
    color: #5e5e5e;
    font-family: -webkit-pictograph;
    font-size: 11px;
    font-weight: 600;
    padding-bottom: 4px;
    padding-left: 6px;
    padding-right: 6px;
    text-shadow: none;
}

 </style>
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
									function getUserdata3($id){
										global $db;
										$db->where("userid",$id);
										$data = $db->getOne("merchants");
										return $data;
									}

									$username = getUserdata2($_SESSION['iid']);
									if($username['terminal_id'] !='') {
										$db->where("idmerchants",$username['merchant_id']);
										$merchant = $db->getOne("merchants");
										if(isset($merchant['merchant_name'])){
											echo $merchant['merchant_name'];
										}
										$userName = $username['username'];
									} else {
										$merchant = getUserdata3($_SESSION['iid']);
										if(isset($merchant['merchant_name'])){
											echo $merchant['merchant_name'];
										} 
										$userName = '';	
									}

									$count_upi_query = "SELECT COUNT(upi_status) FROM merchants WHERE upi_status='0'";
                                    $count_upi = $db->rawQuery($count_upi_query);
                                    foreach ($count_upi as $key => $value) {
                                    	$count_val=$value;
                                    }

                            		$count_cbp_query = "SELECT COUNT(cbp_status) FROM merchants WHERE cbp_status='1'";
                                    $count_cbp = $db->rawQuery($count_cbp_query);
                                    foreach ($count_cbp as $key => $value) {
                                    	$count_val1=$value;
                                    }
                                    //echo $count_val1['COUNT(cbp_status)'];
									?>

								</strong>

								 </span> 

								 <span class="text-muted text-xs block">

								 <?php

								 if(isset($username['user_type'])){

									 switch ($username['user_type']) {

										case 1:

											echo ($username['username'] == "supremeuser") ? "Supreme Administrator" : "Master Administrator";

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

											echo $userName!='' ? $userName : "Merchant User";

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

							if($username['username'] == "hutchadminuser") {
							?>
							<li class="<?php active('terminal_add.php');active('merchantQR.php');active('users.php');?>" >
								<a href=""><i class="fa fa-magic"></i>
									<span class="nav-label">Administration</span> 
									<span class="fa arrow"></span>
								</a>

								<ul class="nav nav-second-level">
									<li class="<?php active('terminal_add.php');active('merchantQR.php');active('users.php');?>"> 
										<a href=""><i class="fa fa-money"></i> 
											<span class="nav-label">Merchant</span>
											<span class="fa arrow"></span>
										</a>
										<ul class="nav nav-third-level">
											<li class="<?php active('terminal_add.php');?>">
												<a href="terminal_add.php"><span class="nav-label">Add Terminal</span></a>
											</li>
											<li class="<?php active('merchantQR.php');?>">
												<a href="merchantQR.php"><span class="nav-label">Generate QR</span></a>
											</li>
											<li class="<?php active('users.php');?>">
		                        			     <a href="users.php"><span class="nav-label">Users</span> </a>
		                        			 </li>
										</ul>
									</li>
								</ul>
                    		</li>
							<?php
							} else {
					?>
                    <li class="<?php active('merchant_add.php');active('terminal_add.php');active('merchantQR.php');active('mer_reqform.php');active('users.php');active('processormerchantmanager.php');active('vpa_upi_form.php');active('upi_trans_history.php');active('upi_qr_generate.php');active('cbp_merchant_reg.php');?>" >


                        <a href=""><i class="fa fa-magic"></i><span class="nav-label">Administration</span> <span class="fa arrow"></span></a>

						<ul class="nav nav-second-level">

							<li class="<?php active('merchant_add.php');active('terminal_add.php');active('merchantQR.php');active('mer_reqform.php');active('users.php');active('processormerchantmanager.php');active('vpa_upi_form.php');active('upi_trans_history.php');active('upi_qr_generate.php');active('cbp_merchant_reg.php');?>"> 
							
							<a href=""><i class="fa fa-money"></i> <span
                             class="nav-label">Merchant</span><span class="fa arrow"></span></a>

								<ul class="nav nav-third-level">

									<li class="<?php active('merchant_add.php');?>">
										<a href="merchant_add.php"><span class="nav-label">Add Merchant</span></a>
									</li>

									<li class="<?php active('terminal_add.php');?>">
										<a href="terminal_add.php"><span class="nav-label">Add Terminal</span></a>
									</li>

									<li class="<?php active('merchantQR.php');?>">
										<a href="merchantQR.php"><span class="nav-label">Generate QR</span></a>
									</li>

									<li class="<?php active('processormerchantmanager.php');?>">
										<a href="processormerchantmanager.php"><span class="nav-label">Assign Merchants</span></a>
									</li>

									<?php if($username['username'] == "supremeuser") { ?>
									<li class="<?php active('mer_reqform.php');?>">
										<a href="mer_reqform.php"><span class="nav-label">GM Portal</span></a>
									</li>
									<?php } ?>
									<li class="<?php active('users.php');?>">
                        			     <a href="users.php"><span class="nav-label">Users</span> </a></li>
								</ul>

							</li>

							<!-- <li class="<?php // active('fees.php');?>"> <a href="fees.php"><i class="fa fa-dollar"></i> <span class="nav-label">Fees</span></a>
							</li> -->

						</ul>
						<ul class="nav nav-second-level">

							<li class="<?php active('vpa_upi_form.php');active('upi_trans_history.php');active('upi_qr_generate.php');?>" >
							
							<a href=""><i class="fa fa-money"></i> 
								<span class="nav-label1">UPI</span>
								<?php if($count_val['COUNT(upi_status)'] != "0") { ?>
								<i class="fa fa-bell" style="font-size:15px;color:white"></i><span class="badge"><?php echo $count_val['COUNT(upi_status)'];?></span>
								<?php } ?>
								<span class="fa arrow"></span></a>

								<ul class="nav nav-third-level">

									<li class="<?php active('vpa_upi_form.php');?>">
										<a href="vpa_upi_form.php"><span class="nav-label">Merchant_Register</span></a>
									</li>

									<li class="<?php active('upi_trans_history.php');?>">
										<a href="upi_trans_history.php"><span class="nav-label">Transaction_History</span></a>
									</li>

									<li class="<?php active('upi_qr_generate.php');?>">
										<a href="upi_qr_generate.php"><span class="nav-label">Generate Static QR</span></a>
									</li>

								</ul>

							</li>

						 <ul class="nav nav-second-level">

							<li class="<?php active('cbp_merchant_reg.php');?>"> 
							
							<a href=""><i class="fa fa-money"></i> <span
                             class="nav-label">CBP</span>
                             <?php if($count_val1['COUNT(cbp_status)'] != "0") { ?>
								<i class="fa fa-bell" style="font-size:15px;color:white"></i><span class="badge"><?php echo $count_val1['COUNT(cbp_status)'];?></span>
								<?php } ?>
                             <span class="fa arrow"></span></a>

								<ul class="nav nav-third-level">

									<li class="<?php active('cbp_merchant_reg.php');?>">
										<a href="cbp_merchant_reg.php"><span class="nav-label">Merchant Register</span></a>
									</li>

								</ul>

							</li>

							<!-- <li class="<?php // active('fees.php');?>"> <a href="fees.php"><i class="fa fa-dollar"></i> <span class="nav-label">Fees</span></a>
							</li> -->
						 </ul>

						</ul>

						
                    </li>
					<?php }

						}

					}

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 ){

						?>
	                    <!-- <li class="<?php // active('reports.php');?>">
	                        <a href="reports.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> </a>
	                    </li> --> 
	                    <?php // if($username['username'] != "hutchadminuser") { ?> 
	                    <li class="<?php active('adminreports.php'); ?>">
	                        <a href="adminreports.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> </a>
	                    </li>
	                	<?php // } ?>
				
					<?php

						} elseif($usertype == 4 || $usertype == 5) {

							?>

						<!-- 	<li class="<?php // active('merchantreports.php');?>">
								<a href="merchantreports.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> </a>
							</li> -->
							<!-- <li class="<?php // active('sec_mer_reqform.php');?>">
								<a href="sec_mer_reqform.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Sec Merchant Reg</span> </a>
							</li> -->

							<?php

						}

					}
					

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 || $usertype == 2){

					?>

                    <!-- <li class="<?php // active('addagent.php');?>">

                        <a href="addagent.php"><i class="fa fa-user"></i> <span class="nav-label">Add Agent</span> </a>

                    </li> -->

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

                    <!-- <li class="<?php // active('users.php');?>">

                        <a href="users.php"><i class="fa fa-group"></i> <span class="nav-label">Users</span> </a>

                    </li> -->

					<?php

						}

					}

					if(isset($usertype)){

						if($usertype == 1 || $usertype == 3 || $usertype == 5){

							?>

							<!-- <li class="<?php // active('chargebacks.php');active('chargebacks.php?type=cb');?>">

								<a href="chargebacks.php"><i class="fa fa-bank"></i> <span class="nav-label">Chargebacks</span> <span class="fa arrow"></span></a>

								<ul class="nav nav-second-level collapse" aria-expanded="false">

									<li class="<?php // active('chargebacks.php?type=cb');?>"><a href="chargebacks.php?type=cb">Search Chargebacks</a></li>

								</ul>

							</li> -->

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

							

						<!-- <li class="<?php // active('virtualterminal.php');active('virtualterminal.crv.php');?>">

							<a href="virtualterminal.php"><i class="fa fa-desktop"></i> <span class="nav-label">Virtual Terminal</span> <span class="fa arrow"></span></a>

							<ul class="nav nav-second-level collapse" aria-expanded="false">

								<li class="<?php // active('virtualterminal.php');?>"><a href="virtualterminal.php">Sales and Authorizations</a></li>

								<li class="<?php // active('transactions.php');?>"><a href="transactions.php">Search Transactions</a></li>

								<li class="<?php // active('virtualterminal.crv.php');?>"><a href="virtualterminal.crv.php">Captures, Refunds and Voids</a></li>

							</ul>

						</li> -->

						<?php

						}

						

						if($usertype == 4 || $usertype == 5 || $usertype == 6){

							?>

							<!-- <li>

								<a href="merchantapi.php"><i class="fa fa-key"></i> 

								<span class="nav-label">API</span> </a>

							</li> -->

							

						<?php

						}

					}

					?>

                </ul>



            </div>

        </nav>

