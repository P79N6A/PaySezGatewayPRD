<?php

require_once( 'header.php'); 


//check permission
if(!checkPermission('U'))
    include_once('forbidden.php');

require_once('php/inc_user.php');

require_once('php/inc_reports.php');

// set action parameter to set limit what kind of operation is used under what user
// action parameter should be 'view' or 'create'
// echo "ahii";

?>
<script src="js/pwstrength.js"></script>
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
<?php
	echo $resetMsg;
	if ($resetPassword)
	{
?> 
<div class="middle-box text-center loginscreen animated fadeInDown">
	<div class="row">
	    <h2>Update Password</h2>
	    <label for="title">Reset <?php if(isset($_POST['username'])){ echo $_POST['username']; }else{echo $userinfo['username']; } ?>  password</label>
	    <form class="m-t" role="form" action="#" method="post">
	        <div class="form-group" id="pwd-container">
	            <input type="text" class="form-control" placeholder="Old Password" name="oldPassword" value="<?php echo isset($oldPassword) ? $oldPassword : ""; ?>" required="" readonly/>
	            <input type="password" class="form-control" placeholder="New Password" name="newPassword" id="password" required="" title="Password must be atleast 8 characters including 1 uppercase letter, 1 lowercase letter, 1 special character and numeric characters" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" minlength="8">
	            <input type="text" class="form-control" placeholder="Confirm Password" name="confirmPassword" required="" title="Password must be atleast 8 characters including 1 uppercase letter, 1 lowercase letter, 1 special character and numeric characters" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" minlength="8">
	            <h5>Password must contain atleast 1 uppercase, 1 lowercase, 1 number, 1 symbol, min 8 chars and max 12 chars.</h5>
	            <div class="form-group" id="progress_bar">
                    <div class="pwstrength_viewport_progress"></div>
                </div>
	        </div>
	        <button type="submit" id="updatePwdBTN" class="btn btn-primary block full-width m-b">Update Password</button>
	    </form>
		<a href="passwordpolicy.php" class="m-t"><small>Password Policy</small></a>	
    </div>
</div>
<?php
}
?><br/>

<?php
	if($editUserDetails)
	{
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    	<div class="col-lg-7">
        	<div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo $userlang;?></h5>
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
								<div class="form-group"><label>Merchants</label>
									<select class="form-control m-b" name="merchants" id="merchants">
										<option value="">-- All Merchants --</option>
										<?php foreach($user_merchants as $user_merchant) { ?>
											<option value="<?php echo $user_merchant['idmerchants']; ?>"
												<?php if($user_merchant['idmerchants'] == $_POST['merchants']) { ?> selected="selected" <?php } ?>
												<?php if($user_merchant['idmerchants'] == $userinfo['usr_merchant']) { ?> selected="selected" <?php } ?> >
												<?php echo $user_merchant['merchant_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group"><label>Email</label> <input required type="email" name="email" id="email" class="form-control required email"  value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }else{echo $userinfo['email_address']; } ?>" /></div>
								<div class="form-group"><label>Username</label> <input  <?php if(isset($_GET['userid'])){ echo 'disabled'; }else{ echo '';} ?> type="text" name="username" id="username" class="form-control required"  value="<?php if(isset($_POST['username'])){ echo $_POST['username']; }else{echo $userinfo['username']; } ?>" /></div>

							<?php } else{ ?>
							<div class="form-group"><label>Merchants</label>
									<select class="form-control m-b" name="merchants" id="merchants">
										<option value="">-- All Merchants --</option>
										<?php foreach($user_merchants as $user_merchant) { ?>
											<option value="<?php echo $user_merchant['idmerchants']; ?>" 
												<?php if($user_merchant['idmerchants'] == $_POST['merchants']) { ?> selected="selected" <?php } ?> >
												<?php echo $user_merchant['merchant_name']; ?></option>
										<?php } ?>
									</select>
								</div>
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

									if($iiduserdata['username'] == 'supremeuser') {
									echo '
									<div class="radio i-checks">
											<input required type="radio" value="5" name="user_type"> <i></i> Merchant (<strong>'.getUserPermissions(5).'</strong>)<br />
									</div>
									';	
									} else {
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
									}
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
						<br>
						<button type="submit" id="edituser" class="btn btn-md btn-primary pull-left m-t-n-xs"><strong><?php echo $userlang; ?></strong></button>

						<a href="passwordpolicy.php">Password Policy</a>
						
					</form>
					
					&nbsp;<?php echo $msg; ?>
					
					<?php echo $resetpass; ?><br>
					
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
                <table class="table table-striped">
					<tbody>
						<?php
							if (in_array('U', $userinfo['user_roles'])) {
						?>
						<tr>
							<td width="20px"><strong><span class="notice">U </span></strong></td>
							<td>User Management</td>
						</tr>
						<?php
							}
							if (in_array('M', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">M </span></strong></td>
							<td>Merchant Management</td>
						</tr>
						<?php
							}
							if (in_array('A', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">A </span></strong></td>
							<td>Agent Management</td>
						</tr>
						<?php
							}
							if (in_array('C', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">C </span></strong></td>
							<td>Configure mids</td>
						</tr>
						<?php
							}
							if (in_array('F', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">F </span></strong></td>
							<td>Edit Fees</td>
						</tr>
						<?php
							}
							if (in_array('R', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">R </span></strong></td>
							<td>View Reports</td>
						</tr>
						<?php
							}
							if (in_array('S', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">S </span></strong></td>
							<td>View Statements</td>
						</tr>
						<?php
							}
							if (in_array('B', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">B </span></strong></td>
							<td>Process Chargebacks</td>
						</tr>
						<?php
							}
							if (in_array('V', $userinfo['user_roles'])) {
						?>
						<tr>
							<td><strong><span class="notice">V </span></strong></td>
							<td>Use Virtual Terminal</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<?php require_once('footerjs.php'); ?>
<?php require_once('footer.php'); ?>

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