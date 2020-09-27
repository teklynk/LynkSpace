<?php
define( 'ALLOW_INC', true );

define( 'tinyMCE', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'events.php';

$sqlEvent = mysqli_query( $db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, active, author_name, datetime, loc_id FROM events WHERE loc_id=" . loc_id . ";" );
$rowEvent = mysqli_fetch_array( $sqlEvent, MYSQLI_ASSOC );

//update table on submit
if ( ! empty( $_POST ) ) {
	$event_defaults  = isset( $_POST['event_defaults'] ) ? safeCleanStr( $_POST['event_defaults'] ) : null;
	$event_heading   = isset( $_POST['event_heading'] ) ? safeCleanStr( $_POST['event_heading'] ) : null;
	$event_alert     = isset( $_POST['event_alert'] ) ? safeCleanStr( $_POST['event_alert'] ) : null;
	$event_startdate = dateTimeFormat( 1, safeCleanStr( $_POST['event_startdate'] ) );
	$event_enddate   = dateTimeFormat( 1, safeCleanStr( $_POST['event_enddate'] ) );
	$event_calendar  = isset( $_POST['event_calendar'] ) ? sqlEscapeStr($_POST['event_calendar']) : null;
    $event_active  = isset( $_POST['event_active'] ) ? safeCleanStr($_POST['event_active']) : null;

    //default check
	if ( $event_defaults == 'on' ) {
		$event_defaults = 'true';
	} else {
		$event_defaults = 'false';
	}

	//active check
    if ( $event_active == 'on' ) {
        $event_active = 'true';
    } else {
        $event_active = 'false';
    }

	if ( $rowEvent['loc_id'] == loc_id ) {
		//Do Update
		$eventUpdate = "UPDATE events SET heading='" . $event_heading . "', alert='" . $event_alert . "', startdate='" . $event_startdate . "', enddate='" . $event_enddate . "', calendar='" . $event_calendar . "', use_defaults='" . $event_defaults . "', active='" . $event_active . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . loc_id . ";";
		mysqli_query( $db_conn, $eventUpdate );
	} else {
		//Do Insert
		$eventInsert = "INSERT INTO events (heading, alert, startdate, enddate, calendar, use_defaults, active, author_name, datetime, loc_id) VALUES ('" . $event_heading . "', '" . $event_alert . "', '" . $event_startdate . "', '" . $event_enddate . "', '" . $event_calendar . "', '" . $event_defaults . "', '" . $event_active . "', ''" . $_SESSION['user_name'] . "', '" . date( "Y-m-d H:i:s" ) . "', " . loc_id . ");";
		mysqli_query( $db_conn, $eventInsert );
	}

	$sqlEvent = mysqli_query( $db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, active, author_name, datetime, loc_id FROM events WHERE loc_id=" . loc_id . ";" );
	$rowEvent = mysqli_fetch_array( $sqlEvent, MYSQLI_ASSOC );

	flashMessageSet( 'success', 'The events section has been updated.' );

	//Redirect back to uploads page
	header( "Location: events.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='events.php?loc_id=" . loc_id . "';</script>";
	exit();
}

?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li class="active">Alerts & Events</li>
            </ol>
            <h1 class="page-header">
                Alerts & Events
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
			<?php
			//Alert messages
			echo flashMessageGet( 'success' );

			//use default view
			if ( $rowEvent['use_defaults'] == 'true' ) {
				$selDefaults = "CHECKED";
			} else {
				$selDefaults = "";
			}

			//Active
            if ( $rowEvent['active'] == 'true' ) {
                $selActive = "CHECKED";
            } else {
                $selActive = "";
            }

			if ( $rowEvent['startdate'] == '0000-00-00' || $rowEvent['startdate'] == '' || $rowEvent['startdate'] == null ) {
				$startDate = "";
			} else {
				$startDate = dateTimeFormat( 1, $rowEvent['startdate'] );
			}

			if ( $rowEvent['enddate'] == '0000-00-00' || $rowEvent['enddate'] == '' || $rowEvent['enddate'] == null ) {
				$endDate = "";
			} else {
				$endDate = dateTimeFormat( 1, $rowEvent['enddate'] );
			}

			?>
            <form name="eventsForm" class="dirtyForm" method="post">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="eventactive">
                            <label>Active</label>
                            <div class="checkbox">
                                <label>
                                    <input class="event_active_checkbox"
                                           id="<?php echo loc_id ?>" name="event_active"
                                           type="checkbox" <?php if ( loc_id ) {
                                        echo $selActive;
                                    } ?> data-toggle="toggle">
                                </label>
                                <small>
                                    &nbsp;&nbsp;Display/Hide on web site
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

				<?php
				if ( loc_id != 1 ) {
					?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="eventdefaults">
                                <label>Use Defaults</label>
                                <div class="checkbox">
                                    <label>
                                        <input class="event_defaults_checkbox defaults-toggle"
                                               id="<?php echo loc_id ?>" name="event_defaults"
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
                <div class="form-group">
                    <label for="event_heading">Heading</label>
                    <input type="text" class="form-control count-text" name="event_heading" maxlength="255"
                           value="<?php echo $rowEvent['heading']; ?>" placeholder="Upcoming Events" autofocus>
                </div>

                <div class="form-group">
                    <label for="event_calendar">Calendar</label>
                    <small>&nbsp;&nbsp;<a href="//support.google.com/calendar/answer/41207?hl=en" target="_blank">How to
                            embed a Google Calendar</a>&nbsp;&nbsp;<i class="fa fa-external-link"
                                                                      aria-hidden="true"></i></small>
                    <textarea class="form-control tinymce" name="event_calendar" id="event_calendar"
                              rows="20"><?php echo $rowEvent['calendar']; ?></textarea>
                </div>

                <hr>

                <div class="form-group">
                    <label for="event_alert">Alert Message</label>&nbsp;&nbsp;<small>Displays a prominent alert message
                        on the home page.
                    </small>
                    <textarea class="form-control count-text" name="event_alert" id="event_alert" rows="4"
                              maxlength="999"><?php echo $rowEvent['alert']; ?></textarea>
                </div>

                <!-- date time picker -->
                <div class="col-md-6" style="padding-left:0px;">
                    <div class="form-group">
                        <label for="event_startdate">Start Date</label>&nbsp;&nbsp;<small>Start alert on.</small>
                        <div class="input-group date">
                            <input type="date" class="form-control" name="event_startdate" id="event_startdate"
                                   value="<?php echo $startDate; ?>" placeholder="mm/dd/yyyy"
                                   pattern="<?php echo dateValidationPattern; ?>"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding-right:0px;">
                    <div class="form-group">
                        <label for="event_enddate">End Date</label>&nbsp;&nbsp;<small>End alert on.</small>
                        <div class="input-group date">
                            <input type="date" class="form-control" name="event_enddate" id="event_enddate"
                                   value="<?php echo $endDate; ?>" placeholder="mm/dd/yyyy"
                                   pattern="<?php echo dateValidationPattern; ?>"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div style="clear:both;"></div>

                <hr/>

                <div class="form-group">
                    <span><small><?php echo "Updated: " . date( 'm-d-Y, H:i:s', strtotime( $rowEvent['datetime'] ) ) . " By: " . $rowEvent['author_name']; ?></small></span>
                </div>

                <input type="hidden" name="csrf" value="<?php echo csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                <button type="submit" name="event_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save
                    Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
            </form>
        </div>
    </div>
<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>