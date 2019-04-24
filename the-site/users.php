<?php require_once( 'header.php'); ?>

<?php require_once( 'php/inc_users.php'); ?>

<div class="tab-content" id="tab-content">

	</div>

<div class="row  border-bottom white-bg dashboard-header">

    <div class="col-lg-10">

        <div class="col-lg-10">

		</div>

    </div>

    

   <div class="row show-grid">

         <div class="col-md-6"><div class="panel panel-primary">

                    <div class="panel-heading">User Accounts</div>

                    <div class="panel-body">

		<span class="catitem"></span>

                     

		<table border="0" cellpadding="0" cellspacing="3" class="table table-striped">

			<thead>

				<tr>

					<th><span class="notice"><b>Username</b></span></th>

					<th><b>Permissions</b></th>

				</tr>

			</thead>

			<tbody>

				<?php


			foreach($usersofuser as $row0){ 

	

				if($row0['id']){

				?>

			<tr data-level="1" id="level_1_<?php echo $row0['id']; ?>" class="agentuser">

				<td><a href="user.php?userid=<?php echo $row0['id']; ?>"><?php echo strip_tags( $row0['username'] ); ?></a></td>

				<td class="data">

					<?php echo getUserPermissions($row0['user_type']); ?>

				</td>

				<td class="data">

					<input type="submit" onclick="impersonate('<?php echo $row0['id']; ?>')" value="Login">

				</td>

			</tr>

			<?php } }

			?>

			</tbody>

		</table>

            

        </br>

    

    

    </div>

    </div>

	

	</div>

        <div class="col-md-6">

		<div class="panel panel-primary">

        <div class="panel-heading">User Permissions</div>

        <div class="panel-body">

            <table class="table">

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

	

<?php 

	if($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 7) { ?>

	<a class="btn btn-primary btn-block" href="user.php">Click Here to Add A New User Account</a>

	<?php } ?>	

    </div>

  </div>    

  </div>

 

<script>

function impersonate(uid) {

	if (uid == "") {

		document.getElementById("tab-content").innerHTML = showAgent('accinfo');

		return;

	} else {

		if (window.XMLHttpRequest) {

			// code for IE7+, Firefox, Chrome, Opera, Safari

			xmlhttp = new XMLHttpRequest();

		} else {

			// code for IE6, IE5

			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

		}

		xmlhttp.onreadystatechange = function() {

			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				document.getElementById("tab-content").innerHTML = xmlhttp.responseText;

			}

		}

		xmlhttp.open("GET", "php/inc_viewagent.php?q=accinfo&iid=" + uid, true);

		xmlhttp.send();

	}

}

</script>

<?php require_once( 'footerjs.php'); ?>

<?php require_once( 'footer.php'); ?>

