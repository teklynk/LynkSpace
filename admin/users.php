<?php 
define('inc_access', TRUE);

	include 'includes/header.php';

	$sqlUsers= mysqli_query($db_conn, "SELECT username, password, email, id FROM users WHERE id=".$_SESSION['user_id']." ");
	$rowUsers= mysqli_fetch_array($sqlUsers);

	//update table on submit
	if (!empty($_POST)) {
		$username = trim($_POST['user_name']);
		$useremail = trim(filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL));
		$userpass = trim($_POST['user_password']);
		$userpassconfirm = trim($_POST['user_password_confirm']);
		$userid = $_POST['user_id'];

		if ($userpass == $userpassconfirm) {
			$usersUpdate = "UPDATE users SET username='".$username."', password=password('".$userpass."'), email='".$useremail."' WHERE id=".$userid." ";
			mysqli_query($db_conn, $usersUpdate);

			$pageMsg = "<div class='alert alert-success'>The user has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">x</button></div>";
		} else {
			$pageMsg = "<div class='alert alert-danger'>Passwords do not match.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">x</button></div>";
		}

	}

	if ($_GET['updatepassword'] == 'true') {
		$pageMsg = "<div class='alert alert-warning'>Please update your password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='users.php?loc_id=".$_GET['loc_id']."'\"></button></div>";
	}
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				User Manager
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8">
			<?php 
			if ($pageMsg != "") {
				echo $pageMsg;
			}
			?>
			<form name="userForm" method="post" action="users.php">

				<div class="form-group">
					<label>User Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
					    <input class="form-control" type="text" name="user_name" maxlength="255" value="<?php echo $rowUsers['username']; ?>" placeholder="User name" required>
                    </div>
				</div>
				<div class="form-group">
                    <label>User Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
					    <input class="form-control" type="email" name="user_email" maxlength="255" value="<?php echo $rowUsers['email']; ?>" placeholder="Email Address" required>
                    </div>
                </div>
				<div class="form-group">
                    <label>User Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
					    <input class="form-control" type="password" name="user_password" value="" placeholder="Password" required>
                    </div>
				</div>
				<div class="form-group">
					<label>Password Confirm</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
					    <input class="form-control" type="password" name="user_password_confirm" value="" placeholder="Password Confirm" required>
                    </div>
				</div>
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />

				<button type="submit" name="user_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i>Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i>Reset</button>

			</form>

		</div>
	</div>

<?php
	include 'includes/footer.php';
?>
