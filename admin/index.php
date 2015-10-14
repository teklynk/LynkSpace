<?php include 'includes/header.php';?>
<?php
unset($_SESSION["user_id"]);
unset($_SESSION["user_name"]);
unset($_SESSION["timeout"]);

$message="";

if (!empty($_POST)) {

  	$result = mysql_query("SELECT username, password, id FROM users WHERE username='".$_POST["username"]."' AND password=password('$_POST[password]')");
	$row  = mysql_fetch_array($result);

	if (is_array($row)) {
		$_SESSION["user_id"] = $row['id'];
		$_SESSION["user_name"] = $row['username'];
        $_SESSION['timeout'] = time();
        
	} else {
		$message = "<div class='alert alert-danger' role='alert'>Invalid Username or Password!<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
	}
}

if (isset($_SESSION["user_id"]) AND isset($_SESSION["user_name"]) AND isset($_SESSION['timeout'])) {
	//header("Location: setup.php");
	echo "<script>window.location.href='setup.php';</script>";
}

?>
<style>
html, body {
	margin-top: 0px !important;
	background-color: #fff !important;
}
.navbar-inverse {
	display:none !important;
}
#wrapper {
	padding-left: 0px !important;
}
.form-signin {
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
}
</style>


    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="message"><?php if ($message!="") {echo $message;} ?></div>
                <div class="panel-body">
                    <form name="frmUser" class="form-signin" method="post" action="">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php 
include 'includes/footer.php';
?>
