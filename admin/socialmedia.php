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
				$socialUpdate = "UPDATE socialmedia SET heading='".htmlspecialchars(strip_tags($_POST['social_heading']), ENT_QUOTES)."', facebook='".$_POST['social_facebook']."', youtube='".$_POST['social_youtube']."', twitter='".$_POST['social_twitter']."', google='".$_POST['social_google']."', pinterest='".$_POST['social_pinterest']."', instagram='".$_POST['social_instagram']."', tumblr='".$_POST['social_tumblr']."' WHERE loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $socialUpdate);
			} else {
				//Do Insert
				$socialInsert = "INSERT INTO socialmedia (heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, loc_id) VALUES ('".htmlspecialchars(strip_tags($_POST['social_heading']), ENT_QUOTES)."', '".$_POST['social_facebook']."', '".$_POST['social_youtube']."', '".$_POST['social_twitter']."', '".$_POST['social_google']."', '".$_POST['social_pinterest']."', '".$_POST['social_instagram']."', '".$_POST['social_tumblr']."', ".$_GET['loc_id'].")";
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
					<input class="form-control input-sm" name="social_heading" maxlength="255" value="<?php echo $rowSocial['heading']; ?>" placeholder="Follow Me" required>
				</div>
				<div class="form-group">
					<label>Facebook</label>
					<input class="form-control input-sm" name="social_facebook" maxlength="255" value="<?php echo $rowSocial['facebook']; ?>" type="url" placeholder="https://www.facebook.com/username">
				</div>
				<div class="form-group">
					<label>Twitter</label>
					<input class="form-control input-sm" name="social_twitter" maxlength="255" value="<?php echo $rowSocial['twitter']; ?>" type="url" placeholder="https://www.twitter.com/username">
				</div>
				<div class="form-group">
					<label>Google+</label>
					<input class="form-control input-sm" name="social_google" maxlength="255" value="<?php echo $rowSocial['google']; ?>" type="url" placeholder="https://plus.google.com/8675309/posts">
				</div>
				<div class="form-group">
					<label>Pinterest</label>
					<input class="form-control input-sm" name="social_pinterest" maxlength="255" value="<?php echo $rowSocial['pinterest']; ?>" type="url" placeholder="https://www.pinterest.com/username/">
				</div>
				<div class="form-group">
					<label>Instagram</label>
					<input class="form-control input-sm" name="social_instagram" maxlength="255" value="<?php echo $rowSocial['instagram']; ?>" type="url" placeholder="https://www.instagram.com/username/">
				</div>
				<div class="form-group">
					<label>Tumblr</label>
					<input class="form-control input-sm" name="social_tumblr" maxlength="255" value="<?php echo $rowSocial['tumblr']; ?>" type="url" placeholder="https://username.tumblr.com/">
				</div>
				<div class="form-group">
					<label>YouTube</label>
					<input class="form-control input-sm" name="social_youtube" maxlength="255" value="<?php echo $rowSocial['youtube']; ?>" type="url" placeholder="https://www.youtube.com/user/username">
				</div>

				<button type="submit" name="socialmedia_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

			</form>

		</div>
	</div>
<?php
	include 'includes/footer.php';
?>
