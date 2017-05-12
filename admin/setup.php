<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'setup.php';

//Get max location ID number - for creating a new location
$sqlLocationMaxID = mysqli_query($db_conn, "SELECT MAX(id) FROM locations ORDER BY id DESC LIMIT 1");
$rowLocationMaxID = mysqli_fetch_array($sqlLocationMaxID);

//Get highest ID number and add 1. Used for adding a new location.
$locationNewID = $rowLocationMaxID[0] + 1;

//Get location table columns
$sqlLocation = mysqli_query($db_conn, "SELECT id, name, type, active FROM locations WHERE id=" . $_GET['loc_id'] . " ");
$rowLocation = mysqli_fetch_array($sqlLocation);

//Get setup table columns
$sqlSetup = mysqli_query($db_conn, "SELECT title, author, description, keywords, config, ls2pac, ls2kids, searchdefault, logo, author_name, datetime, loc_id FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowSetup = mysqli_fetch_array($sqlSetup);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['site_title'])) {
        $site_keywords = $_POST['site_keywords'];
        $site_author = $_POST['site_author'];
        $site_description = $_POST['site_description'];

        if ($_POST['location_status'] == 'on') {
            $_POST['location_status'] = 'true';
        } else {
            $_POST['location_status'] = 'false';
        }

        //Always set default location to active/true
        if ($_GET['loc_id'] == 1) {
            $_POST['location_status'] = 'true';
        }

        //update table on submit
        if ($rowSetup['loc_id'] == $_GET['loc_id']) {
            //Update Location
            $locationUpdate = "UPDATE locations SET name='" . safeCleanStr($_POST['location_name']) . "', type='" . $_POST['location_type'] . "', active='" . $_POST['location_status'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $locationUpdate);
            //Update Setup
            $setupUpdate = "UPDATE setup SET title='" . safeCleanStr($_POST['site_title']) . "', author='" . safeCleanStr($site_author) . "', keywords='" . safeCleanStr($site_keywords) . "', description='" . safeCleanStr($site_description) . "', config='" . safeCleanStr($_POST['site_config']) . "', logo='" . $_POST['site_logo'] . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $setupUpdate);
        } else {
            //Insert Location
            $locationInsert = "INSERT INTO locations (id, name, type, datetime, active) VALUES (" . $_GET['loc_id'] . ", '" . safeCleanStr($_POST['location_name']) . "', '" . safeCleanStr($_POST['location_type']) . "', '" . date("Y-m-d H:i:s") . "', 'true')";
            mysqli_query($db_conn, $locationInsert);
            //Insert Setup
            $setupInsert = "INSERT INTO setup (title, keywords, description, config, logo, ls2pac, ls2kids, searchdefault, author, pageheading, servicesheading, sliderheading, teamheading, hottitlesheading, servicescontent, teamcontent, slider_use_defaults, navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3, services_use_defaults, team_use_defaults, hottitles_use_defaults, datetime, author_name, loc_id) VALUES ('" . safeCleanStr($_POST['site_title']) . "', '" . safeCleanStr($site_keywords) . "', '" . safeCleanStr($site_description) . "', '" . safeCleanStr($_POST['site_config']) . "', '" . $_POST['site_logo'] . "', 'true', 'true', 1, '" . safeCleanStr($site_author) . "', 'Pages', 'Our Services', 'Slider', 'Meet the Team', 'New Items', '', '', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $setupInsert);
            //Insert Contact defaults
            $contactInsert = "INSERT INTO contactus (heading, use_defaults, datetime, loc_id) VALUES ('Contact Us', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $contactInsert);
            //Insert About defaults
            $aboutInsert = "INSERT INTO aboutus (heading, use_defaults, author_name, datetime, loc_id) VALUES ('About Us', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $aboutInsert);
            //Insert Featured defaults
            $featuredInsert = "INSERT INTO featured (heading, use_defaults, author_name, datetime, loc_id) VALUES ('Feature', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $featuredInsert);
            //Do Insert
            $socialInsert = "INSERT INTO socialmedia (heading, use_defaults, loc_id) VALUES ('Follow Us', 'true', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $socialInsert);
        }

        header("Location: setup.php?loc_id=" . $_GET['loc_id'] . "&update=true");
        echo "<script>window.location.href='setup.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
    }
}

$pageMsg = '';

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The setup section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='setup.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
} elseif ($_GET['deleteloc'] == 'true') {
    $pageMsg = "<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete this location? <a href='?loc_id=" . $_GET['loc_id'] . "&deleteloc=" . $_GET['loc_id'] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='setup.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}

//delete a location and all references to it in the config. this will do a cascading delete where loc_id = id
if ($_SESSION['user_level'] == 1 && $multiBranch == 'true' && $_GET['loc_id'] != 1 && $_GET['newlocation'] != 'true') {
    if ($_GET['loc_id'] && $_GET['deleteloc'] && $_GET['confirm'] == 'yes') {
        $locDelete = "DELETE FROM locations WHERE id=" . $_GET['loc_id'] . " ";
        mysqli_query($db_conn, $locDelete);

        //Delete the uploads folder if it exists, uses rrmdir() from functions.php
        if (file_exists($image_dir)) {
            rrmdir($image_dir);
        }

        header("Location: setup.php?loc_id=1");
        echo "<script>window.location.href='setup.php?loc_id=1';</script>";
    }
}

?>
    <div class="row">
        <div class="col-lg-12">
            <?php if ($_GET['newlocation'] == 'true') {
                echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Settings</a></li>
            <li class='active'>New Location</li>
            </ol>";
                echo "<h1 class='page-header'>Settings (New) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
            } else {
                echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li class='active'>Settings</li>
            </ol>";
                echo "<h1 class='page-header'>Settings </h1>";
            }
            ?>
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

            if ($rowLocation['active'] == 'true') {
                $isActive_location = "CHECKED";
            } else {
                $isActive_location = "";
            }

            if ($rowSetup['ls2pac'] == 'true') {
                $isActive_ls2pac = "CHECKED";
            } else {
                $isActive_ls2pac = "";
            }

            if ($rowSetup['ls2kids'] == 'true') {
                $isActive_ls2kids = "CHECKED";
            } else {
                $isActive_ls2kids = "";
            }

            if ($rowSetup['searchdefault'] == '1') {
                $isActive_default1 = "CHECKED";
                $isActive_default2 = "";
            } elseif ($rowSetup['searchdefault'] == '2') {
                $isActive_default1 = "";
                $isActive_default2 = "CHECKED";
            }

            if ($rowSetup['logo'] == "") {
                $logo = "//placehold.it/140x100&text=No Image";
            } else {
                $logo = "../uploads/" . $_GET['loc_id'] . "/" . $rowSetup['logo'];
            }
            ?>

            <form name="setupForm" id="setupForm" class="dirtyForm" method="post" action="">
                <!-- Admin Options Panel/Well-->
                <?php
                //Admin Options and Settings
                //Check if user_level is Admin user and default location
                if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_GET['newlocation'] != 'true') {
                    ?>
                    <fieldset class="well">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Admin Options</label>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_GET['newlocation'] != 'true') {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="site_options">
                                        <button type="button" class="delete_location btn btn-primary" name="site_options" onclick="window.location='siteoptions.php?loc_id=<?php echo $_GET['loc_id']; ?>';">
                                            <i class='fa fa-fw fa-edit'></i> Site Options
                                        </button>
                                        <small>
                                            &nbsp;&nbsp;Edit global website settings, themes, styles.&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php
                            //only show this button to super-admin
                            if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_SESSION['super_admin'] == true) {
                                ?>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group" id="site_options">
                                            <button type="button" class="delete_location btn btn-primary" name="site_options" onclick="window.location='import.php?loc_id=<?php echo $_GET['loc_id']; ?>';">
                                                <i class='fa fa-fw fa-upload'></i> Import CSV
                                            </button>
                                            <small>
                                                &nbsp;&nbsp;Bulk add locations and web page content.&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        //Check if user_level is Admin user
                        if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $multiBranch == 'true' && $_GET['newlocation'] != 'true') {
                            ?>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="new_location">
                                        <button type="button" class="btn btn-primary" onclick="window.location='setup.php?newlocation=true&loc_id=<?php echo $locationNewID; ?>';"><i class='fa fa-fw fa-plus'></i> Add a New Location</button>
                                        <small>
                                            &nbsp;&nbsp;Add a new branch / location to the website.&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $multiBranch == 'true' && $_GET['loc_id'] != 1) {
                            ?>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="delete_location">
                                        <button type="button" class="delete_location btn btn-danger" name="delete_location" data-toggle="tooltip" data-original-title="Use Carefully!" data-placement="top" onclick="window.location='setup.php?deleteloc=true&loc_id=<?php echo $_GET['loc_id']; ?>';">
                                            <i class='fa fa-fw fa-trash'></i> Delete this Location
                                        </button>
                                        <small>
                                            &nbsp;&nbsp;Permanently delete this location.&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <?php
                        }

                        //Check if user_level is Admin user and is Multibranch
                        if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $multiBranch == 'true' && $_GET['loc_id'] != 1) {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="location_active">
                                        <label>Active</label>
                                        <div class="checkbox">
                                            <label>
                                                <input class="location_status_checkbox" id="<?php echo $_GET['loc_id'] ?>" name="location_status" type="checkbox" <?php if ($_GET['loc_id']) {echo $isActive_location;} ?> data-toggle="toggle">
                                            </label>
                                            <small>
                                                &nbsp;&nbsp;Make this location active.&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </fieldset><!-- well -->
                    <hr/>
                    <?php
                }
                ?>

                <div class="form-group">
                    <label>Site Title</label>
                    <input type="text" class="form-control count-text" name="site_title" maxlength="255" value="<?php echo $rowSetup['title']; ?>" placeholder="My Website" autofocus required>
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" class="form-control count-text" name="site_author" maxlength="255" value="<?php echo $rowSetup['author']; ?>" placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label>Keywords</label>
                    <textarea type="text" class="form-control count-text" name="site_keywords" rows="3" maxlength="999"><?php echo $rowSetup['keywords']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control count-text" name="site_description" rows="3" maxlength="999"><?php echo $rowSetup['description']; ?></textarea>
                </div>
                <hr/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Location Name</label>
                            <input type="text" class="form-control count-text" name="location_name" maxlength="255" value="<?php echo $rowLocation['name']; ?>" required>
                        </div>
                    </div>
                </div>
                <?php
                //loop through the array of location Types
                $locMenuStr = "";
                $locArrlength = count($locTypes);

                for ($x = 0; $x < $locArrlength; $x++) {

                    if ($locTypes[$x] == $rowLocation['type']) {

                        $isSectionSelected = "SELECTED";

                    } else {

                        $isSectionSelected = "";

                    }

                    $locMenuStr .= "<option value=" . $locTypes[$x] . " " . $isSectionSelected . ">" . $locTypes[$x] . "</option>";
                }

                if ($multiBranch == 'true') {
                    ?>
                    <div class="form-group">
                        <label for="location_type">Location Type</label>
                        <select class="form-control" name="location_type" id="location_type">
                            <?php echo $locMenuStr; ?>
                        </select>
                    </div>
                    <?php
                } else {
                    echo "<input type='hidden' name='location_type' id='location_type' value='Default'/>";
                }
                ?>

                <div class="form-group">
                    <img src="<?php echo $logo; ?>" id="site_logo_preview" style="max-width:140px; height:auto; display:block; background-color: #ccc;"/>
                </div>

                <div class="form-group">
                    <label>Choose a Logo</label>
                    <select class="form-control" name="site_logo" id="site_logo">
                        <option value="">None</option>
                        <?php
                        getImageDropdownList($image_dir, $rowSetup['logo']);
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>PAC Config</label>
                            <input type="text" class="form-control count-text" name="site_config" maxlength="10" value="<?php echo $rowSetup['config']; ?>" placeholder="1234">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" id="searchoptions">
                            <label>PAC Search Options</label>
                            <div class="checkbox">
                                <label>
                                    <input class="searchopt_checkbox ls2pac_active" id="ls2pac" type="checkbox" <?php echo $isActive_ls2pac; ?> data-toggle="toggle">LS2 PAC
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input class="searchopt_radio ls2pac_default" name="defaultsearch" type="radio" value="1" <?php echo $isActive_default1; ?>>Use as Default
                                </label>
                            </div>
                            <h1></h1>
                            <div class="checkbox">
                                <label>
                                    <input class="searchopt_checkbox ls2kids_active" id="ls2kids" type="checkbox" <?php echo $isActive_ls2kids; ?> data-toggle="toggle">LS2 Kids
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input class="searchopt_radio ls2kids_default" name="defaultsearch" type="radio" value="2" <?php echo $isActive_default2; ?>>Use as Default
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="form-group">
                    <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowSetup['datetime'])) . " By: " . $rowSetup['author_name']; ?></small></span>
                </div>

                <button type="submit" name="setup_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

            </form>

        </div>
    </div>
<?php
include_once('includes/footer.inc.php');
?>