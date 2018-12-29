<?php
session_start();

define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'siteoptions.php';

//Keeps user in the default location when on this page. Only Default loc can edit this page.
if ( loc_id != 1 ) {
	header( 'Location: siteoptions.php?loc_id=1', true, 302 );
	echo "<script>window.location.href='siteoptions.php?loc_id=1';</script>";
	exit();
}

//check if user is logged in and is admin
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['user_level'] == 1 && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) ) {

	if ( isset( $_POST['save_main'] ) ) {

		$site_customer_id     = isset( $_POST['site_customer_id'] ) ? safeCleanStr( $_POST['site_customer_id'] ) : null;
		$site_theme           = isset( $_POST['site_theme'] ) ? safeCleanStr( $_POST['site_theme'] ) : null;
		$site_loc_types       = isset( $_POST['site_loc_types'] ) ? safeCleanStr( $_POST['site_loc_types'] ) : null;
		$site_analytics       = isset( $_POST['site_analytics'] ) ? safeCleanStr( $_POST['site_analytics'] ) : null;
		$site_session_timeout = isset( $_POST['site_session_timeout'] ) ? safeCleanStr( $_POST['site_session_timeout'] ) : null;
		$site_carousel_speed  = isset( $_POST['site_carousel_speed'] ) ? safeCleanStr( $_POST['site_carousel_speed'] ) : null;
		$site_pacurl          = isset( $_POST['site_pacurl'] ) ? validateUrl( $_POST['site_pacurl'] ) : null;
		$ls2pac_label         = isset( $_POST['ls2pac_label'] ) ? safeCleanStr( $_POST['ls2pac_label'] ) : null;
		$ls2pac_placeholder   = isset( $_POST['ls2pac_placeholder'] ) ? safeCleanStr( $_POST['ls2pac_placeholder'] ) : null;
		$ls2kids_label        = isset( $_POST['ls2kids_label'] ) ? safeCleanStr( $_POST['ls2kids_label'] ) : null;
		$ls2kids_placeholder  = isset( $_POST['ls2kids_placeholder'] ) ? safeCleanStr( $_POST['ls2kids_placeholder'] ) : null;
		$site_homepageurl     = isset( $_POST['site_homepageurl'] ) ? validateUrl( $_POST['site_homepageurl'] ) : null;
		$site_iprange         = isset( $_POST['site_iprange'] ) ? safeCleanStr( $_POST['site_iprange'] ) : null;

		//Update record in DB
		$configUpdate = "UPDATE config SET customer_id='" . $site_customer_id . "', theme='" . $site_theme . "', loc_types='" . $site_loc_types . "', analytics='" . $site_analytics . "', session_timeout=" . $site_session_timeout . ", carousel_speed='" . $site_carousel_speed . "', setuppacurl='" . $site_pacurl . "', searchlabel_ls2pac='" . $ls2pac_label . "', searchplaceholder_ls2pac='" . $ls2pac_placeholder . "', searchlabel_ls2kids='" . $ls2kids_label . "', searchplaceholder_ls2kids='" . $ls2kids_placeholder . "', homepageurl='" . $site_homepageurl . "', iprange='" . $site_iprange . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE id=1;";
		mysqli_query( $db_conn, $configUpdate );

		flashMessageSet( 'success', "Site options have been updated." );

		//Redirect back to main page
		header( "Location: siteoptions.php?loc_id=" . loc_id . "", true, 302 );
		echo "<script>window.location.href='siteoptions.php?loc_id=" . loc_id . "';</script>";
		exit();
	}

	//Get data
	$sqlConfig = mysqli_query( $db_conn, "SELECT customer_id, theme, iprange, multibranch, loc_types, homepageurl, setuppacurl, searchlabel_ls2pac, searchplaceholder_ls2pac, searchlabel_ls2kids, searchplaceholder_ls2kids, session_timeout, carousel_speed, analytics, datetime, author_name FROM config WHERE id=1;" );
	$rowConfig = mysqli_fetch_array( $sqlConfig, MYSQLI_ASSOC );

	?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Settings</a></li>
                <li class="active">Site Options</li>
            </ol>
            <h1 class="page-header">
                Site Options
            </h1>
        </div>


        <div class="col-lg-8">

			<?php
			//alert messages
			echo flashMessageGet( 'success' );

			if ( ! is_writable( '../sitemap.xml' ) ) {
				echo "<div class='alert alert-warning'>Unable to write to sitemap.xml. Check file permissions.</div>";
			}
			if ( ! is_writable( '../robots.txt' ) ) {
				echo "<div class='alert alert-warning'>Unable to write to robots.txt. Check file permissions.</div>";
			}
			//multibranch active
			if ( $rowConfig['multibranch'] == 'true' ) {
				$selActive = "CHECKED";
			} else {
				$selActive = "";
			}
			?>
            <form name="siteoptionsform" class="dirtyForm" method="post">
                <div class="form-group">
                    <a href="../themes/<?php echo $rowConfig['theme']; ?>/screenshot.png" target="_blank"
                       id="theme_href_preview">
                        <img src="../themes/<?php echo $rowConfig['theme']; ?>/screenshot_thumb.png"
                             id="theme_image_preview"
                             style="max-height:240px; background:url('//placehold.it/280x240&text=No Image') 0 0 no-repeat;"
                             data-toggle="tooltip" data-original-title="Click to enlarge" data-placement="right"/>
                    </a>
                </div>
                <div class="form-group" style="margin-bottom:20px;">
                    <label for="site_theme">Themes</label>
                    <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                            data-size="10" name="site_theme" id="site_theme">
						<?php
						echo getThemesDropdownList( $rowConfig['theme'] );
						?>
                    </select>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="site_customer_id">Customer ID</label>
                    <input type="text" class="form-control count-text" name="site_customer_id" maxlength="10"
                           value="<?php echo $rowConfig['customer_id']; ?>" placeholder="8675309">
                </div>
                <div class="form-group" id="multibranchactive">
                    <label for="multibranch_active">Multibranch</label>
                    <small>
                        &nbsp;&nbsp;Multiple sites or locations
                    </small>
                    <div class="checkbox">
                        <label>
                            <input class="multibranch_checkbox" id="multibranch_active" name="multibranch_active"
                                   type="checkbox" <?php echo $selActive; ?> data-toggle="toggle">
                        </label>
                    </div>
                </div>
				<?php
				if ( $rowConfig['multibranch'] == 'true' ) {
					echo "<div class='form-group'>";
					echo "<label for='site_loc_types'>Location Groups</label>";
					echo "<input type='text' class='form-control count-text' name='site_loc_types' maxlength='255' value='" . $rowConfig['loc_types'] . "' placeholder='1,2,3,4,5'>";
					echo "</div>";
				} else {
					echo "<input type='hidden' name='site_loc_types' value='Default'>";
				}
				?>
                <div class="form-group">
                    <label for="site_homepageurl">Home Page URL</label>
                    <input type="url" pattern="<?php echo urlValidationPattern; ?>" class="form-control count-text"
                           name="site_homepageurl" maxlength="100" value="<?php echo $rowConfig['homepageurl']; ?>"
                           placeholder="http://www.myhomepage.com">
                </div>
                <div class="form-group">
                    <label for="site_pacurl">PAC URL</label>
                    <input type="url" pattern="<?php echo urlValidationPattern; ?>" class="form-control count-text"
                           name="site_pacurl" maxlength="100" value="<?php echo $rowConfig['setuppacurl']; ?>"
                           placeholder="http://www.librarypac.com">
                </div>
                <div class="col-md-6" style="padding-left:0px;">
                    <div class="form-group">
                        <label for="ls2pac_label">LS2 PAC : Search Label</label>
                        <small>
                            &nbsp;&nbsp;Label for the LS2 PAC search box.
                        </small>
                        <input type="text" class="form-control count-text" name="ls2pac_label" id="ls2pac_label"
                               maxlength="255" value="<?php echo $rowConfig['searchlabel_ls2pac']; ?>"
                               placeholder="Catalog"/>
                    </div>
                </div>
                <div class="col-md-6" style="padding-right:0px;">
                    <div class="form-group">
                        <label for="ls2kids_label">LS2 Kids : Search Label</label>
                        <small>
                            &nbsp;&nbsp;Label for the LS2 Kids search box.
                        </small>
                        <input type="text" class="form-control count-text" name="ls2kids_label" id="ls2kids_label"
                               maxlength="255" value="<?php echo $rowConfig['searchlabel_ls2kids']; ?>"
                               placeholder="Kid's Catalog"/>
                    </div>
                </div>
                <div class="col-md-6" style="padding-left:0px;">
                    <div class="form-group">
                        <label for="ls2pac_placeholder">LS2 PAC : Placeholder</label>
                        <small>
                            &nbsp;&nbsp;Placeholder text for the LS2 PAC search box.
                        </small>
                        <input type="text" class="form-control count-text" name="ls2pac_placeholder"
                               id="ls2pac_placeholder" maxlength="255"
                               value="<?php echo $rowConfig['searchplaceholder_ls2pac']; ?>"
                               placeholder="Find anything at the library. Start here."/>
                    </div>
                </div>
                <div class="col-md-6" style="padding-right:0px;">
                    <div class="form-group">
                        <label for="ls2kids_placeholder">LS2 Kids : Placeholder</label>
                        <small>
                            &nbsp;&nbsp;Placeholder text for the LS2 Kids search box.
                        </small>
                        <input type="text" class="form-control count-text" name="ls2kids_placeholder"
                               id="ls2kids_placeholder" maxlength="255"
                               value="<?php echo $rowConfig['searchplaceholder_ls2kids']; ?>"
                               placeholder="Find children's book and more."/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="site_carousel_speed">Carousel Speed</label>
                    <small>
                        &nbsp;&nbsp;Seconds
                    </small>
                    <input type="text" class="form-control count-text" name="site_carousel_speed" maxlength="5"
                           value="<?php echo $rowConfig['carousel_speed']; ?>" placeholder="5000">
                </div>
                <div class="form-group">
                    <label for="site_session_timeout">Admin Session Log Out Time Limit</label>
                    <small>
                        &nbsp;&nbsp;Minutes
                    </small>
                    <input type="text" class="form-control count-text" name="site_session_timeout" maxlength="5"
                           value="<?php echo $rowConfig['session_timeout']; ?>" placeholder="3600">
                </div>
                <hr/>
                <div class="form-group">
                    <label for="site_iprange">Admin Panel IP Range Access</label>
                    <small>
                        &nbsp;&nbsp;Restrict access to external and/or internal IP addresses.&nbsp;&nbsp;Your IP address
                        is <?php echo getRealIpAddr(); ?>
                    </small>
                    <input type="text" class="form-control count-text" name="site_iprange" maxlength="999"
                           value="<?php echo $rowConfig['iprange']; ?>" placeholder="192.168.0,10.10.0,127.0.0"
                           data-toggle="tooltip" data-original-title="Use Carefully!" data-placement="top">
                </div>
                <hr/>
                <div class="form-group">
                    <label for="site_analytics">Website Analytics</label>
                    <input type="text" class="form-control count-text" name="site_analytics" maxlength="20"
                           value="<?php echo $rowConfig['analytics']; ?>" placeholder="UA-XXXXXX-Y">
                </div>
                <div class="form-group" id="sitemap_builder">
                    <button type="button" data-toggle="tooltip" class="sitemap_builder btn btn-primary"
                            name="sitemap_builder">
                        <i class='fa fa-fw fa-cog'></i> Update Sitemap.xml
                    </button>
                    <small>
                        &nbsp;&nbsp;Generate a search engine site map for web crawlers.
                    </small>
                    <br/>
                    <small class="sitemap_builder_msg"></small>
                </div>
                <hr/>
                <div class="form-group">
                    <span><small><?php echo "Updated: " . date( 'm-d-Y, H:i:s', strtotime( $rowConfig['datetime'] ) ) . " By: " . $rowConfig['author_name']; ?></small></span>
                </div>

                <input type="hidden" name="csrf" value="<?php echo csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                <input type="hidden" name="save_main" value="true"/>
                <button type="submit" name="siteoptionsform_submit" class="btn btn-primary"><i
                            class='fa fa-fw fa-save'></i> Save Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

            </form>

        </div>
    </div><!--close main container-->
	<?php

} else {
	//redirect user if not admin
	header( 'Location: index.php?logout=true', true, 302 );
	echo "<script>window.location.href='index.php?logout=true';</script>";
}
require_once( __DIR__ . '/includes/footer.inc.php' );
?>