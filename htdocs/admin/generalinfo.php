<?php
define( 'ALLOW_INC', true );

define( 'tinyMCE', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'generalinfo.php';

$generalinfo_defaults = isset( $_POST['generalinfo_defaults'] ) ? safeCleanStr( $_POST['generalinfo_defaults'] ) : null;
$generalinfo_heading  = isset( $_POST['generalinfo_heading'] ) ? safeCleanStr( $_POST['generalinfo_heading'] ) : null;
$generalinfo_content  = isset( $_POST['generalinfo_content'] ) ? trim( $_POST['generalinfo_content'] ) : null;

$sqlGeneralinfo = mysqli_query( $db_conn, "SELECT heading, content, use_defaults, author_name, datetime, loc_id FROM generalinfo WHERE loc_id=" . loc_id . ";" );
$rowGeneralinfo = mysqli_fetch_array( $sqlGeneralinfo, MYSQLI_ASSOC );

//update table on submit
if ( ! empty( $_POST ) ) {

	if ( $generalinfo_defaults == 'on' ) {
		$generalinfo_defaults = 'true';
	} else {
		$generalinfo_defaults = 'false';
	}

	if ( $rowGeneralinfo['loc_id'] == loc_id ) {
		//Do Update
		$generalinfoUpdate = "UPDATE generalinfo SET heading='" . $generalinfo_heading . "', content='" . $generalinfo_content . "', use_defaults='" . $generalinfo_defaults . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . loc_id . ";";
		mysqli_query( $db_conn, $generalinfoUpdate );
	} else {
		//Do Insert
		$generalinfoInsert = "INSERT INTO generalinfo (heading, content, use_defaults, author_name, datetime, loc_id) VALUES ('" . $generalinfo_heading . "', '" . $generalinfo_content . "', 'true', '" . $_SESSION['user_name'] . "', '" . date( "Y-m-d H:i:s" ) . "', " . loc_id . ");";
		mysqli_query( $db_conn, $generalinfoInsert );
	}

	flashMessageSet( 'success', 'The general info section has been updated.' );

	//Redirect back to uploads page
	header( "Location: generalinfo.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='generalinfo.php?loc_id=" . loc_id . "';</script>";
	exit();
}

?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
            <li class="active">General Information</li>
        </ol>
        <h1 class="page-header">
            General Information
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
		<?php

		//Alert messages
		echo flashMessageGet( 'success' );

		//use default view
		if ( $rowGeneralinfo['use_defaults'] == 'true' ) {
			$selDefaults = "CHECKED";
		} else {
			$selDefaults = "";
		}
		?>
        <form name="generalinfoForm" class="dirtyForm" method="post">

			<?php
			if ( loc_id != 1 ) {
				?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="generalinfodefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="generalinfo_defaults_checkbox defaults-toggle"
                                           id="<?php echo loc_id ?>" name="generalinfo_defaults"
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
                <input type="text" class="form-control count-text" name="generalinfo_heading" maxlength="255"
                       value="<?php echo $rowGeneralinfo['heading']; ?>" placeholder="Heading" autofocus required>
            </div>

            <div class="form-group">
                <label>Text / HTML</label>
                <textarea class="form-control tinymce" name="generalinfo_content"
                          rows="20"><?php echo $rowGeneralinfo['content']; ?></textarea>
            </div>

            <div class="form-group">
                <span><small><?php echo "Updated: " . date( 'm-d-Y, H:i:s', strtotime( $rowGeneralinfo['datetime'] ) ) . " By: " . $rowGeneralinfo['author_name']; ?></small></span>
            </div>

            <input type="hidden" name="csrf" value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

            <button type="submit" name="generalinfo_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                Save Changes
            </button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>

    </div>
</div>

<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>
