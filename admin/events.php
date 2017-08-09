<?php
define('inc_access', TRUE);
define('tinyMCE', TRUE);
define('datePicker', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'events.php';

$sqlEvent = mysqli_query($db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, author_name, datetime, loc_id FROM events WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowEvent = mysqli_fetch_array($sqlEvent);

//update table on submit
if (!empty($_POST)) {

    if ($_POST['event_defaults'] == 'on') {
        $_POST['event_defaults'] = 'true';
    } else {
        $_POST['event_defaults'] = 'false';
    }

    if ($rowEvent['loc_id'] == $_GET['loc_id']) {
        //Do Update
        $eventUpdate = "UPDATE events SET heading='" . sqlEscapeStr($_POST['event_heading']) . "', alert='" . sqlEscapeStr($_POST['event_alert']) . "', startdate='" . safeCleanStr($_POST['event_startdate']) . "', enddate='" . safeCleanStr($_POST['event_enddate']) . "', calendar='" . $_POST['event_calendar'] . "', use_defaults='" . safeCleanStr($_POST['event_defaults']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
        mysqli_query($db_conn, $eventUpdate);
    } else {
        //Do Insert
        $eventInsert = "INSERT INTO events (heading, alert, startdate, enddate, calendar, use_defaults, author_name, datetime, loc_id) VALUES ('" . sqlEscapeStr($_POST['event_heading']) . "', '" . sqlEscapeStr($_POST['event_alert']) . "', '" . safeCleanStr($_POST['event_startdate']) . "', '" . safeCleanStr($_POST['event_enddate']) . "', '" . $_POST['event_calendar'] . "', '".safeCleanStr($_POST['event_defaults'])."', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
        mysqli_query($db_conn, $eventInsert);
    }

    header("Location: events.php?loc_id=" . $_GET['loc_id'] . "&update=true");
    echo "<script>window.location.href='events.php?loc_id=" . $_GET['loc_id'] . "&update=true ';</script>";
}

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The events section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='events.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li class="active">Events</li>
            </ol>
            <h1 class="page-header">
                Events
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <?php
            if ($errorMsg !="") {
                echo $errorMsg;
            } else {
                echo $pageMsg;
            }

            //use default view
            if ($rowEvent['use_defaults'] == 'true') {
                $selDefaults = "CHECKED";
            } else {
                $selDefaults = "";
            }

            if ($rowEvent['startdate'] == '0000-00-00'){
                $startDate = "";
            } else {
                $startDate = $rowEvent['startdate'];
            }
            if ($rowEvent['enddate'] == '0000-00-00') {
                $endDate = "";
            } else {
                $endDate = $rowEvent['enddate'];
            }

            ?>
            <form name="eventsForm" class="dirtyForm" method="post" action="">

                <?php
                if ($_GET['loc_id'] != 1) {
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="eventdefaults">
                                <label>Use Defaults</label>
                                <div class="checkbox">
                                    <label>
                                        <input class="event_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="event_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
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
                    <input type="text" class="form-control count-text" name="event_heading" maxlength="255" value="<?php echo $rowEvent['heading']; ?>" placeholder="Upcoming Events" autofocus>
                </div>

                <div class="form-group">
                    <label for="event_calendar">Calendar</label>
                    <small>&nbsp;&nbsp;<a href="//support.google.com/calendar/answer/41207?hl=en" target="_blank">How to embed a Google Calendar</a>&nbsp;&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></small>
                    <textarea class="form-control tinymce" name="event_calendar" id="event_calendar" rows="20"><?php echo $rowEvent['calendar']; ?></textarea>
                </div>

                <hr>

                <div class="form-group">
                    <label for="event_alert">Alert Message</label>&nbsp;&nbsp;<small>Displays a prominent alert message on the home page.</small>
                    <textarea class="form-control count-text" name="event_alert" id="event_alert" rows="4" maxlength="999"><?php echo $rowEvent['alert']; ?></textarea>
                </div>

                <!-- date time picker -->
                <div class="col-md-6" style="padding-left:0px;">
                    <div class="form-group">
                        <label for="event_startdate">Start Date</label>&nbsp;&nbsp;<small>Start alert on.</small>
                        <div class="input-group date">
                            <input type="text" class="form-control datepicker" data-provide="datepicker" name="event_startdate" id="event_startdate" value="<?php echo $startDate; ?>" placeholder="YYYY-MM-DD" pattern="<?php echo dateValidationPattern; ?>" />
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
                            <input type="text" class="form-control datepicker" data-provide="datepicker" name="event_enddate" id="event_enddate" value="<?php echo $endDate; ?>" placeholder="YYYY-MM-DD" pattern="<?php echo dateValidationPattern; ?>" />
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div style="clear:both;"></div>

                <hr/>

                <div class="form-group">
                    <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowEvent['datetime'])) . " By: " . $rowEvent['author_name']; ?></small></span>
                </div>

                <button type="submit" name="event_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
            </form>
        </div>
    </div>
<?php
include_once('includes/footer.inc.php');
?>