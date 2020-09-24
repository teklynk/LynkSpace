<?php
define( 'ALLOW_INC', true );

define( 'tinyMCE', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'featured.php';

$sqlFeatured = mysqli_query( $db_conn, "SELECT heading, introtext, content, use_defaults, author_name, datetime, loc_id FROM featured WHERE loc_id=" . loc_id . ";" );
$rowFeatured = mysqli_fetch_array( $sqlFeatured, MYSQLI_ASSOC );

//update table on submit
if ( ! empty( $_POST ) ) {

	$featured_defaults  = isset( $_POST['featured_defaults'] ) ? safeCleanStr( $_POST['featured_defaults'] ) : null;
	$featured_heading   = isset( $_POST['featured_heading'] ) ? safeCleanStr( $_POST['featured_heading'] ) : null;
	$featured_introtext = isset( $_POST['featured_introtext'] ) ? safeCleanStr( $_POST['featured_introtext'] ) : null;
	$featured_content   = isset( $_POST['featured_content'] ) ? sqlEscapeStr($_POST['featured_content']) : null;

	if ( $featured_defaults == 'on' ) {
		$featured_defaults = 'true';
	} else {
		$featured_defaults = 'false';
	}

	if ( $rowFeatured['loc_id'] == loc_id ) {
		//Do Update
		$featuredUpdate = "UPDATE featured SET heading='" . $featured_heading . "', introtext='" . $featured_introtext . "', content='" . $featured_content . "', use_defaults='" . $featured_defaults . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . loc_id . ";";
		mysqli_query( $db_conn, $featuredUpdate );
	} else {
		//Do Insert
		$featuredInsert = "INSERT INTO featured (heading, introtext, content, use_defaults, author_name, datetime, loc_id) VALUES ('" . $featured_heading . "', '" . $featured_introtext . "', '" . $featured_content . "', '" . $featured_defaults . "', '" . $_SESSION['user_name'] . "', '" . date( "Y-m-d H:i:s" ) . "', " . loc_id . ");";
		mysqli_query( $db_conn, $featuredInsert );
	}

	$sqlFeatured = mysqli_query( $db_conn, "SELECT heading, introtext, content, use_defaults, author_name, datetime, loc_id FROM featured WHERE loc_id=" . loc_id . ";" );
	$rowFeatured = mysqli_fetch_array( $sqlFeatured, MYSQLI_ASSOC );

	flashMessageSet( 'success', 'The featured section has been updated.' );

	//Redirect back to uploads page
	header( "Location: featured.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='featured.php?loc_id=" . loc_id . "';</script>";
	exit();
}

?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li class="active">Feature</li>
            </ol>
            <h1 class="page-header">
                Feature
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
			<?php

			//Alert messages
			echo flashMessageGet( 'success' );

			//use default view
			if ( $rowFeatured['use_defaults'] == 'true' ) {
				$selDefaults = "CHECKED";
			} else {
				$selDefaults = "";
			}
			?>
            <form name="landingForm" class="dirtyForm" method="post">
				<?php
				if ( loc_id != 1 ) {
					?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="featureddefaults">
                                <label>Use Defaults</label>
                                <div class="checkbox">
                                    <label>
                                        <input class="featured_defaults_checkbox defaults-toggle"
                                               id="<?php echo loc_id ?>" name="featured_defaults"
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
                    <input type="text" class="form-control count-text" name="featured_heading" maxlength="255"
                           value="<?php echo $rowFeatured['heading']; ?>" placeholder="Welcome" autofocus required>
                </div>
                <div class="form-group">
                    <label>Intro Title</label>
                    <input type="text" class="form-control count-text" name="featured_introtext" maxlength="255"
                           value="<?php echo $rowFeatured['introtext']; ?>" placeholder="John Doe">
                </div>
                <hr/>
                <div class="form-group">
                    <label>Text / HTML</label>
                    <textarea class="form-control tinymce" name="featured_content"
                              rows="20"><?php echo $rowFeatured['content']; ?></textarea>
                </div>

                <div class="form-group">
                    <span><small><?php echo "Updated: " . date( 'm-d-Y, H:i:s', strtotime( $rowFeatured['datetime'] ) ) . " By: " . $rowFeatured['author_name']; ?></small></span>
                </div>

                <input type="hidden" name="csrf" value="<?php echo csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                <button type="submit" name="featured_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                    Save Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
            </form>
        </div>
    </div>
<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>