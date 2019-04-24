<?php
require_once( 'header.php'); 
require_once( 'php/inc_user.php');

// set action parameter to set limit what kind of operation is used under what user
// action parameter should be 'view' or 'create'

?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>Users</h2>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li>
				<a href="users.php">Users</a>
			</li>
			<li class="active">
				<strong><?php echo $userlang; ?></strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-7">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo $userlang; ?></h5>
                        <!--div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div-->
                    </div>
                    <div class="ibox-content">
						<form role="form" id="user_edit" action="" method="post">
							<div class="row">
								<div class="col-sm-6 b-r"><h4>User Information</h4>

									<?php if (isset($userinfo)) { ?>
										<div class="form-group"><label>First Name</label><input required type="text" name="first_name" id="first_name" class="form-control required" value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; }else{ echo $userinfo['first_name']; } ?>" /></div>
										<div class="form-group"><label>Last Name</label><input required type="text" name="last_name" id="last_name" class="form-control required"  value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; }else{echo $userinfo['last_name']; } ?>" /></div>
										<div class="form-group"><label>Email</label> <input required type="email" name="email" id="email" class="form-control required email"  value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }else{echo $userinfo['email_address']; } ?>" /></div>
										<div class="form-group"><label>Username</label> <input  <?php if(isset($_GET['userid'])){ echo 'disabled'; }else{ echo '';} ?> type="text" name="username" id="username" class="form-control required"  value="<?php if(isset($_POST['username'])){ echo $_POST['username']; }else{echo $userinfo['username']; } ?>" /></div>
									<?php } else{ ?>
										<div class="form-group"><label>First Name</label> <input required type="text" name="first_name" id="first_name" class="form-control required" value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; } ?>" /></div>
										<div class="form-group"><label>Last Name</label> <input required type="text" name="last_name" id="last_name" class="form-control required"  value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; } ?>" /></div>
										<div class="form-group"><label>Email</label> <input required type="email" name="email" id="email" class="form-control required email"  value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>" /></div>
										<div class="form-group"><label>Username</label><input required <?php if(isset($_GET['userid'])){ echo disabled; }else{ echo '';} ?> type="text" name="username" id="username" class="form-control required"  value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>" /></div>
									<?php } ?>

								</div>	
								<div class="col-sm-6">
									<?php
									if(isset($_GET['userid']) && $_GET['userid'] > 0 ) {
											
											}else{
									?>
									<h4>User Type</h4>
									
									
									<?php 
										// need below for this to work '.$userinfo["user_type"] == 2 ? 'checked' : ''.'
									if (isset($userinfo)) {
										switch ($userinfo["user_type"]){
											case 2:
											break;
										}
									}

									// dd($iiduserdata);
										
									//end need below
									switch($iiduserdata['user_type']){
										case 1:
											echo '
											<div class="radio i-checks">
													<input required type="radio" value="1" name="user_type"> <i></i> Master Administrator (<strong>'.getUserPermissions(1).'</strong>)<br />
													<input required type="radio" value="2" name="user_type"> <i></i> Agent Administrator (<strong>'.getUserPermissions(2).'</strong>)<br />
													<input required type="radio" value="3" name="user_type"> <i></i> Agent (<strong>'.getUserPermissions(3).'</strong>)<br />
													<input required type="radio" value="4" name="user_type"> <i></i> Merchant Administrator (<strong>'.getUserPermissions(4).'</strong>)<br />
													<input required type="radio" value="5" name="user_type"> <i></i> Merchant (<strong>'.getUserPermissions(5).'</strong>)<br />
													<input required type="radio" value="6" name="user_type"> <i></i> Merchant CSR (<strong>'.getUserPermissions(6).'</strong>)<br />
											</div>
											';
											break;											
										case 2:
											echo '
											<div class="radio i-checks"><label><input required type="radio" value="2" name="user_type"> <i></i> Agent Administrator (<strong>'.getUserPermissions(2).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="3" name="user_type"> <i></i> Agent (<strong>'.getUserPermissions(3).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="4" name="user_type"> <i></i> Merchant Administrator (<strong>'.getUserPermissions(4).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="5" name="user_type"> <i></i> Merchant (<strong>'.getUserPermissions(5).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="6" name="user_type"> <i></i> Merchant CSR (<strong>'.getUserPermissions(6).'</strong>)</label></div>
											';
											break;
										case 3:
											echo '
											<div class="radio i-checks"><label><input required type="radio" value="3" name="user_type"> <i></i> Agent (<strong>'.getUserPermissions(3).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="4" name="user_type"> <i></i> Merchant Administrator (<strong>'.getUserPermissions(4).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="5" name="user_type"> <i></i> Merchant (<strong>'.getUserPermissions(5).'</strong>)</label></div>
											<div class="radio i-checks"><label><input required type="radio" value="6" name="user_type"> <i></i> Merchant CSR (<strong>'.getUserPermissions(6).'</strong>)</label></div>
											';
											break;	
										case 4:
											echo '
											<div class="radio i-checks"><label><input type="radio" value="4" name="user_type"> <i></i> Merchant Administrator (<strong>'.getUserPermissions(4).'</strong>)</label></div>
											<div class="radio i-checks"><label><input type="radio" value="5" name="user_type"> <i></i> Merchant (<strong>'.getUserPermissions(5).'</strong>)</label></div>
											<div class="radio i-checks"><label><input type="radio" value="6" name="user_type"> <i></i> Merchant CSR (<strong>'.getUserPermissions(6).'</strong>)</label></div>
											';	
										case 5:
											echo '
											<div class="radio i-checks"><label><input type="radio" value="5" name="user_type"> <i></i> Merchant (<strong>'.getUserPermissions(5).'</strong>)</label></div>
											<div class="radio i-checks"><label><input type="radio" value="6" name="user_type"> <i></i> Merchant CSR (<strong>'.getUserPermissions(6).'</strong>)</label></div>
											';
										case 6:
											echo '
											<div class="radio i-checks"><label><input type="radio" value="6" name="user_type"> <i></i> Merchant CSR (<strong>'.getUserPermissions(6).'</strong>)</label></div>
											';													
										}
										
									}
									?>
									<!--div class="radio i-checks"><label><input <?php#echo $userinfo['user_type'] == 7 ? 'checked' : ''; ?> type="radio" value="7" name="user_type"> <i></i> Super Agent (<strong><?php echo getUserPermissions(7); ?></strong>)</label></div-->
								
								</div>
							</div>
								<?php echo $edituserpage; ?>
								<button type="submit" id="edituser" class="btn btn-md btn-primary pull-left m-t-n-xs"><strong><?php echo $userlang; ?></strong></button>
							</form>
							
							&nbsp;<?php echo $msg; ?>
							
							<?php echo $resetpass; ?>
							
							<div class="clearfix"></div>
						</form>
                    </div>
                </div>
            </div>
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Permission Keys</h5>
                            <!--div class="ibox-tools">
                                <a class="collapse-link"> bvvv
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div-->
                        </div>
                        <div class="ibox-content">
                            <table class="table  table-striped">
					<tbody>
						<tr>
							<td width="20px"><strong><span class="notice">U</span></strong></td>
							<td>User Management</td>
						</tr>
						<tr>
							<td><strong><span class="notice">M </span></strong></td>
							<td>Merchant Management</td>
						</tr>
						<tr>
							<td><strong><span class="notice">A </span></strong></td>
							<td>Agent Management</td>
						</tr>
						<tr>
							<td><strong><span class="notice">C </span></strong></td>
							<td>Configure mids</td>
						</tr>
						<tr>
							<td><strong><span class="notice">F </span></strong></td>
							<td>Edit Fees</td>
						</tr>
						<tr>
							<td><strong><span class="notice">R </span></strong></td>
							<td>View Reports</td>
						</tr>
						<tr>
							<td><strong><span class="notice">S </span></strong></td>
							<td>View Statements</td>
						</tr>
						<tr>
							<td><strong><span class="notice">B </span></strong></td>
							<td>Process Chargebacks</td>
						</tr>
						<tr>
							<td><strong><span class="notice">V </span></strong></td>
							<td>Use Virtual Terminal</td>
						</tr>
					</tbody>
				</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?>

<script type="text/javascript">
	$(document).ready(function(){
		// alert('user!');	

		$.validator.addMethod("alphaNumericRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    	}, "Username must contain only letters, numbers, or dashes.");

		$('form#user_edit').validate({
			rules: {
	            "username": {
	                required: true,
	                alphaNumericRegex: true,
	            },

	            "last_name": {
	            	required: true,
	            	alphaNumericRegex: true,
	            },

				"first_name": {
	            	required: true,
	            	alphaNumericRegex: true,
	            }	            
	        },
	        messages: {
	            "username": {
	                required: "This field is required.",
	                alphaNumericRegex: "Username format not valid"
	            },

	            "last_name": {
	                required: "This field is required.",
	                alphaNumericRegex: "Last Name format not valid"
	            },

            	"first_name": {
	                required: "This field is required.",
	                alphaNumericRegex: "First Name format not valid"
	            }
	        }
		});
	});
</script>