<?php
define('inc_access', TRUE);

include 'includes/header.php';

	$sqlSocial = mysqli_query($db_conn, "SELECT heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, loc_id FROM socialmedia WHERE loc_id=".$_GET['loc_id']." ");
	$rowSocial = mysqli_fetch_array($sqlSocial);

	//update table on submit
	if (!empty($_POST)) {
		if (!empty($_POST['social_heading'])) {

			if ($rowSocial['loc_id'] == $_GET['loc_id']) {
				//Do Update
				$socialUpdate = "UPDATE socialmedia SET heading='".$_POST['social_heading']."', facebook='".$_POST['social_facebook']."', youtube='".$_POST['social_youtube']."', twitter='".$_POST['social_twitter']."', google='".$_POST['social_google']."', pinterest='".$_POST['social_pinterest']."', instagram='".$_POST['social_instagram']."', tumblr='".$_POST['social_tumblr']."' WHERE loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $socialUpdate);
			} else {
				//Do Insert
				$socialInsert = "INSERT INTO socialmedia (heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, loc_id) VALUES ('".$_POST['social_heading']."', '".$_POST['social_facebook']."', '".$_POST['social_youtube']."', '".$_POST['social_twitter']."', '".$_POST['social_google']."', '".$_POST['social_pinterest']."', '".$_POST['social_instagram']."', '".$_POST['social_tumblr']."', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $socialInsert);
			}

		}

		echo "<script>window.location.href='socialmedia.php?loc_id=".$_GET['loc_id']."&update=true';</script>";
	}

	if ($_GET['update']=='true') {
		$pageMsg = "<div class='alert alert-success'>The social media section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='socialmedia.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
	}
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Social Media
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
			<form name="socialmediaForm" method="post" action="">
				<div class="form-group">
					<label>Heading</label>
					<input class="form-control input-sm" name="social_heading" value="<?php echo $rowSocial['heading']; ?>" placeholder="Follow Me">
				</div>
				<div class="form-group">
					<label>Facebook</label>
					<input class="form-control input-sm" name="social_facebook" value="<?php echo $rowSocial['facebook']; ?>" placeholder="https://www.facebook.com/username">
				</div>
				<div class="form-group">
					<label>Twitter</label>
					<input class="form-control input-sm" name="social_twitter" value="<?php echo $rowSocial['twitter']; ?>" placeholder="https://www.twitter.com/username">
				</div>
				<div class="form-group">
					<label>Google+</label>
					<input class="form-control input-sm" name="social_google" value="<?php echo $rowSocial['google']; ?>" placeholder="https://plus.google.com/8675309/posts">
				</div>
				<div class="form-group">
					<label>Pinterest</label>
					<input class="form-control input-sm" name="social_pinterest" value="<?php echo $rowSocial['pinterest']; ?>" placeholder="https://www.pinterest.com/username/">
				</div>
				<div class="form-group">
					<label>Instagram</label>
					<input class="form-control input-sm" name="social_instagram" value="<?php echo $rowSocial['instagram']; ?>" placeholder="https://www.instagram.com/username/">
				</div>
				<div class="form-group">
					<label>Tumblr</label>
					<input class="form-control input-sm" name="social_tumblr" value="<?php echo $rowSocial['tumblr']; ?>" placeholder="https://username.tumblr.com/">
				</div>
				<div class="form-group">
					<label>YouTube</label>
					<input class="form-control input-sm" name="social_youtube" value="<?php echo $rowSocial['youtube']; ?>" placeholder="https://www.youtube.com/user/username">
				</div>

				<button type="submit" name="socialmedia_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

			</form>

		</div>
	</div>
<?php
	include 'includes/footer.php';
?>
