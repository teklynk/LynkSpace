<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'socialmedia.php';

$sqlSocial = mysqli_query( $db_conn, "SELECT heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id FROM socialmedia WHERE loc_id=" . loc_id . ";" );
$rowSocial = mysqli_fetch_array( $sqlSocial, MYSQLI_ASSOC );

//update table on submit
if ( ! empty( $_POST ) ) {

	$social_heading   = isset( $_POST['social_heading'] ) ? safeCleanStr( addslashes( $_POST['social_heading'] ) ) : null;
	$social_defaults  = isset( $_POST['social_defaults'] ) ? safeCleanStr( $_POST['social_defaults'] ) : null;
	$social_facebook  = isset( $_POST['social_facebook'] ) ? safeCleanStr( $_POST['social_facebook'] ) : null;
	$social_youtube   = isset( $_POST['social_youtube'] ) ? safeCleanStr( $_POST['social_youtube'] ) : null;
	$social_twitter   = isset( $_POST['social_twitter'] ) ? safeCleanStr( $_POST['social_twitter'] ) : null;
	$social_google    = isset( $_POST['social_google'] ) ? safeCleanStr( $_POST['social_google'] ) : null;
	$social_pinterest = isset( $_POST['social_pinterest'] ) ? safeCleanStr( $_POST['social_pinterest'] ) : null;
	$social_instagram = isset( $_POST['social_instagram'] ) ? safeCleanStr( $_POST['social_instagram'] ) : null;
	$social_tumblr    = isset( $_POST['social_tumblr'] ) ? safeCleanStr( $_POST['social_tumblr'] ) : null;

	if ( ! empty( $social_heading ) ) {

		if ( $social_defaults == 'on' ) {
			$social_defaults = 'true';
		} else {
			$social_defaults = 'false';
		}

		if ( $rowSocial['loc_id'] == loc_id ) {
			//Do Update
			$socialUpdate = "UPDATE socialmedia SET heading='" . $social_heading . "', facebook='" . $social_facebook . "', youtube='" . $social_youtube . "', twitter='" . $social_twitter . "', google='" . $social_google . "', pinterest='" . $social_pinterest . "', instagram='" . $social_instagram . "', tumblr='" . $social_tumblr . "', use_defaults='" . $social_defaults . "' WHERE loc_id=" . loc_id . ";";
			mysqli_query( $db_conn, $socialUpdate );
		} else {
			//Do Insert
			$socialInsert = "INSERT INTO socialmedia (heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id) VALUES ('" . $social_heading . "', '" . $social_facebook . "', '" . $social_youtube . "', '" . $social_twitter . "', '" . $social_google . "', '" . $social_pinterest . "', '" . $social_instagram . "', '" . $social_tumblr . "', '" . $social_defaults . "', " . loc_id . ");";
			mysqli_query( $db_conn, $socialInsert );
		}

	}

	$sqlSocial = mysqli_query( $db_conn, "SELECT heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id FROM socialmedia WHERE loc_id=" . loc_id . ";" );
	$rowSocial = mysqli_fetch_array( $sqlSocial, MYSQLI_ASSOC );

	flashMessageSet( 'success', "The social media section has been updated." );
}

?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
            <li class="active">Social Media</li>
        </ol>
        <h1 class="page-header">
            Social Media
        </h1>
    </div>
</div>

<?php echo flashMessageGet( 'success' ); ?>

<div class="row">
    <div class="col-lg-8">
		<?php

		//use default view
		if ( $rowSocial['use_defaults'] == 'true' ) {
			$selDefaults = "CHECKED";
		} else {
			$selDefaults = "";
		}
		?>
        <form name="socialmediaForm" class="dirtyForm" method="post">
			<?php
			if ( loc_id != 1 ) {
				?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="socialdefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="social_defaults_checkbox defaults-toggle"
                                           id="<?php echo loc_id ?>" name="social_defaults"
                                           type="checkbox" <?php if ( loc_id ) {
										echo $selDefaults;
									} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
				<?php
			}
			?>
            <div class="form-group required">
                <label>Heading</label>
                <input type="text" class="form-control" name="social_heading" maxlength="255"
                       value="<?php echo $rowSocial['heading']; ?>" placeholder="Follow Me" autofocus required>
            </div>
            <div class="form-group">
                <label>Facebook</label>
                <input class="form-control" name="social_facebook" maxlength="255"
                       value="<?php echo $rowSocial['facebook']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.facebook.com/username">
            </div>
            <div class="form-group">
                <label>Twitter</label>
                <input class="form-control" name="social_twitter" maxlength="255"
                       value="<?php echo $rowSocial['twitter']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.twitter.com/username">
            </div>
            <div class="form-group">
                <label>Google+</label>
                <input class="form-control" name="social_google" maxlength="255"
                       value="<?php echo $rowSocial['google']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>"
                       placeholder="https://plus.google.com/8675309/posts">
            </div>
            <div class="form-group">
                <label>Pinterest</label>
                <input class="form-control" name="social_pinterest" maxlength="255"
                       value="<?php echo $rowSocial['pinterest']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.pinterest.com/username/">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input class="form-control" name="social_instagram" maxlength="255"
                       value="<?php echo $rowSocial['instagram']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.instagram.com/username/">
            </div>
            <div class="form-group">
                <label>Tumblr</label>
                <input class="form-control" name="social_tumblr" maxlength="255"
                       value="<?php echo $rowSocial['tumblr']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://username.tumblr.com/">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input class="form-control" name="social_youtube" maxlength="255"
                       value="<?php echo $rowSocial['youtube']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>"
                       placeholder="https://www.youtube.com/user/username">
            </div>

            <input type="hidden" name="csrf" value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

            <button type="submit" name="socialmedia_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>
                Save Changes
            </button>
            <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>

        </form>

    </div>
</div>
<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>
