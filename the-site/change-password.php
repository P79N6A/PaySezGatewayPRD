<?php
require_once('header.php');
require_once('php/inc_changepass.php');  
?>       
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Change Password</div>
            <div class="panel-body">
			<label for="title"><?php echo $msg; ?></label><br />
			
			<br />
			<form class="m-t" role="form" action="#" method="post" id="changepass-form">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<input id="oldpassword" name="oldpassword" type="text" class="form-control" placeholder="Old Password">
						</div>
						<div class="form-group">
							<input id="newpass" name="newpass" type="text" class="form-control" placeholder="New Password">
						</div>
						<div class="form-group">
							<input id="cnewpass" name="cnewpass" type="text" class="form-control" placeholder="Confirm New Password">
						</div>
						<button type="submit" class="btn btn-w-m btn-primary">Change Password</button>
						</form>
					</div>
				</div>
            </div>
        </div>
	</div>
    <div class="col-lg-6"></div>
</div>            
<?php require_once('footerjs.php'); ?>
<!-- Jquery Validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>

<script>
	$(document).ready(function(){
		$.validator.addMethod("pwcheck", function(value) {
		   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
			   && /[a-z]/.test(value) // has a lowercase letter
			   && /\d/.test(value) // has a digit
		});
		$("#changepass-form").validate();	
	});
</script>
<?php require_once('footer.php'); ?>