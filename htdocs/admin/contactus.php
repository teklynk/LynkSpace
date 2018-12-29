<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'contactus.php';

$contact_heading     = isset( $_POST['contact_heading'] ) ? safeCleanStr( $_POST['contact_heading'] ) : null;
$contact_defaults    = isset( $_POST['contact_defaults'] ) ? safeCleanStr( $_POST['contact_defaults'] ) : null;
$contact_introtext   = isset( $_POST['contact_introtext'] ) ? safeCleanStr( $_POST['contact_introtext'] ) : null;
$contact_mapcode     = isset( $_POST['contact_mapcode'] ) ? trim( $_POST['contact_mapcode'] ) : null;
$contact_email       = isset( $_POST['contact_email'] ) ? validateEmail( $_POST['contact_email'] ) : null;
$contact_sendtoemail = isset( $_POST['contact_sendtoemail'] ) ? validateEmail( $_POST['contact_sendtoemail'] ) : null;
$contact_address     = isset( $_POST['contact_address'] ) ? safeCleanStr( $_POST['contact_address'] ) : null;
$contact_city        = isset( $_POST['contact_city'] ) ? safeCleanStr( $_POST['contact_city'] ) : null;
$contact_state       = isset( $_POST['contact_state'] ) ? safeCleanStr( $_POST['contact_state'] ) : null;
$contact_zipcode     = isset( $_POST['contact_zipcode'] ) ? safeCleanStr( $_POST['contact_zipcode'] ) : null;
$contact_phone       = isset( $_POST['contact_phone'] ) ? safeCleanStr( $_POST['contact_phone'] ) : null;
$contact_hours       = isset( $_POST['contact_hours'] ) ? safeCleanStr( $_POST['contact_hours'] ) : null;
$contact_defaults    = isset( $_POST['contact_defaults'] ) ? safeCleanStr( $_POST['contact_defaults'] ) : null;

$sqlContact = mysqli_query( $db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours, use_defaults, author_name, datetime, loc_id FROM contactus WHERE loc_id=" . loc_id . ";" );
$rowContact = mysqli_fetch_array( $sqlContact, MYSQLI_ASSOC );

//update table on submit
if ( ! empty( $_POST ) ) {

	if ( $contact_defaults == 'on' ) {
		$contact_defaults = 'true';
	} else {
		$contact_defaults = 'false';
	}

	if ( $rowContact['loc_id'] == loc_id ) {
		//Do Update
		$contactUpdate = "UPDATE contactus SET heading='" . $contact_heading . "', introtext='" . $contact_introtext . "', mapcode='" . $contact_mapcode . "', email='" . $contact_email . "', sendtoemail='" . $contact_sendtoemail . "', address='" . $contact_address . "', city='" . $contact_city . "', state='" . $contact_state . "', zipcode='" . $contact_zipcode . "', phone='" . $contact_phone . "', hours='" . $contact_hours . "', use_defaults='" . $contact_defaults . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . loc_id . ";";
		mysqli_query( $db_conn, $contactUpdate );
	} else {
		//Do Insert
		$contactInsert = "INSERT INTO contactus (heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours, use_defaults, author_name, datetime, loc_id) VALUES ('" . $contact_heading . "', '" . $contact_introtext . "', '" . $contact_mapcode . "', '" . $contact_email . "', '" . $contact_sendtoemail . "', '" . $contact_address . "', '" . $contact_city . "', '" . $contact_state . "', '" . $contact_zipcode . "', '" . $contact_phone . "', '" . $contact_hours . "', 'true', '" . $_SESSION['user_name'] . "', '" . date( "Y-m-d H:i:s" ) . "', " . loc_id . ");";
		mysqli_query( $db_conn, $contactInsert );
	}

	$sqlContact = mysqli_query( $db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours, use_defaults, author_name, datetime, loc_id FROM contactus WHERE loc_id=" . loc_id . ";" );
	$rowContact = mysqli_fetch_array( $sqlContact, MYSQLI_ASSOC );

	flashMessageSet( 'success', 'The contact section has been updated.' );

	//Redirect back to uploads page
	header( "Location: contactus.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='contactus.php?loc_id=" . loc_id . "';</script>";
	exit();
}

?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li class="active">Contact</li>
            </ol>
            <h1 class="page-header">
                Contact&nbsp;<button type="button" data-toggle="tooltip" data-placement="bottom"
                                     title="Preview the Contact Page" class="btn btn-info"
                                     onclick="showMyModal('../contact.php?loc_id=<?php echo loc_id; ?>', '../contact.php?loc_id=<?php echo loc_id; ?>#contact')">
                    <i class="fa fa-eye"></i></button>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
			<?php
			//Alert messages
			echo flashMessageGet( 'success' );

			//use default view
			if ( $rowContact['use_defaults'] == 'true' ) {
				$selDefaults = "CHECKED";
			} else {
				$selDefaults = "";
			}
			?>
            <form name="contactForm" class="dirtyForm" method="post">
				<?php
				if ( loc_id != 1 ) {
					?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="contactdefaults">
                                <label>Use Defaults</label>
                                <div class="checkbox">
                                    <label>
                                        <input class="contact_defaults_checkbox defaults-toggle"
                                               id="<?php echo loc_id ?>" name="contact_defaults"
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
                    <label for="contact_heading">Heading</label>
                    <input type="text" class="form-control count-text" name="contact_heading" maxlength="255"
                           value="<?php echo $rowContact['heading']; ?>" placeholder="Contact Me" autofocus required>
                </div>
                <div class="form-group">
                    <label for="contact_introtext">Intro Text</label>
                    <textarea class="form-control count-text" name="contact_introtext" rows="3"
                              maxlength="999"><?php echo $rowContact['introtext']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="contact_mapcode">Map Embed Code</label>
                    <small>&nbsp;&nbsp;<a
                                href="//support.google.com/maps/answer/144361?co=GENIE.Platform%3DDesktop&hl=en"
                                target="_blank">How to embed a Google Map</a>&nbsp;&nbsp;<i class="fa fa-external-link"
                                                                                            aria-hidden="true"></i>
                    </small>
                    <textarea class="form-control count-text" name="contact_mapcode" rows="3" maxlength="999"
                              placeholder="Map embed code goes here"><?php echo $rowContact['mapcode']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="contact_address">Street Address</label>
                    <input type="text" class="form-control count-text count-text" name="contact_address" maxlength="255"
                           value="<?php echo $rowContact['address']; ?>" placeholder="123 Main Street">
                </div>
                <div class="form-group">
                    <label for="contact_city">City</label>
                    <input type="text" class="form-control count-text" name="contact_city" maxlength="100"
                           value="<?php echo $rowContact['city']; ?>" placeholder="Beverly Hills">
                </div>
                <div class="form-group">
                    <label for="contact_state">State</label>
                    <input type="text" class="form-control count-text" name="contact_state" maxlength="100"
                           value="<?php echo $rowContact['state']; ?>" placeholder="CA">
                </div>
                <div class="form-group">
                    <label for="contact_zipcode">ZIP Code</label>
                    <input type="text" class="form-control count-text" name="contact_zipcode" maxlength="12"
                           pattern="<?php echo postalcodeValidationPattern ?>"
                           value="<?php echo $rowContact['zipcode']; ?>" placeholder="90210">
                </div>
                <div class="form-group">
                    <label for="contact_phone">Phone</label>
                    <input class="form-control count-text" name="contact_phone" maxlength="100"
                           pattern="<?php echo phoneValidationPattern ?>"
                           value="<?php echo $rowContact['phone']; ?>" type="tel" placeholder="555-5555">
                </div>
                <div class="form-group">
                    <label for="contact_hours">Hours</label>
                    <textarea class="form-control count-text" name="contact_hours" rows="3" maxlength="255"
                              placeholder="Monday - Friday: 9-5, Saturday: 9-3, Sunday: Closed"><?php echo $rowContact['hours']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="contact_email">Main Contact Email</label>
                    <input class="form-control count-text" name="contact_email"
                           pattern="<?php echo emailValidationPattern; ?>" maxlength="100"
                           value="<?php echo $rowContact['email']; ?>" type="email" placeholder="john.doe@email.com">
                </div>
                <div class="form-group">
                    <label for="contact_sendtoemail">Comment Form Email</label>
                    <input class="form-control count-text" name="contact_sendtoemail"
                           pattern="<?php echo emailValidationPattern; ?>" maxlength="100"
                           value="<?php echo $rowContact['sendtoemail']; ?>" type="email"
                           placeholder="john.doe@email.com">
                </div>

                <div class="form-group">
                    <span><small><?php echo "Updated: " . date( 'm-d-Y, H:i:s', strtotime( $rowContact['datetime'] ) ) . " By: " . $rowContact['author_name']; ?></small></span>
                </div>

                <input type="hidden" name="csrf" value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                <button type="submit" name="contact_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                    Save Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

            </form>

        </div>
    </div>
    <!--modal preview window-->
<?php
//Modal preview box
showModalPreview( "webpageDialog" );

require_once( __DIR__ . '/includes/footer.inc.php' );
?>