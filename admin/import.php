<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'import.php';

// Only allow super-admin users access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['super_admin'] == false || $_SESSION['user_level'] != 1) {

    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}
//Create the backup folder
if (!file_exists(__DIR__ . '/backups/')) {
    @mkdir(__DIR__ . '/backups/', 0755);
}
//Check that backups folder is writable.
if (!is_writeable(__DIR__ . '/backups/')){
    $pageMsg = "<div class='alert alert-danger'>" . __DIR__ . "/backups is not writable. Check folder permissions.</div>";
}

//update table on submit
if ($_POST['save_main']) {

    if ($_FILES['csvLocationsImport']['size'] > 0) {

        //Create a backup of the locations table.
        databaseDumpBackup(__DIR__ . '/backups/', 'locations');

        //Create a backup of the setup table.
        databaseDumpBackup(__DIR__ . '/backups/', 'setup');

        //Create a backup of the contactus table.
        databaseDumpBackup(__DIR__ . '/backups/', 'contactus');

        //example csv headers
        //name,type,config,address,city,state,zipcode,phone,email,hours

        $rowCount = 0;
        $skip_row_number = array('1');

        //get the csv file
        $locationsFile = $_FILES['csvLocationsImport']['tmp_name'];
        $handle = fopen($locationsFile, 'r');

        //Turn off foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=0');

        if (!empty($_POST['empty_locTables'])) {
            //Truncate tables
            mysqli_query($db_conn, 'TRUNCATE TABLE locations');
            mysqli_query($db_conn, 'TRUNCATE TABLE setup');
            mysqli_query($db_conn, 'TRUNCATE TABLE contactus');
        } else {
            $locationSelect = mysqli_query($db_conn, "SELECT MAX(id) FROM locations LIMIT 1");
            $locationCount = mysqli_fetch_array($locationSelect);
        }

        while (($locData = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($locData[0]) {

                $rowCount ++;
                $locationCount ++;

                //skip first row of csv
                if (in_array($rowCount, $skip_row_number)) {
                    continue;
                }

                if (!empty($_POST['empty_locTables'])) {
                    $locIdCount = $rowCount - 1;
                } else {
                    $locIdCount = $locationCount[0] + $rowCount - 1;
                }

                //Insert into locations table
                $locationInsert = "INSERT INTO locations (id, name, type, datetime, active) VALUES (" . $locIdCount . ", '" . safeCleanStr(addslashes($locData[0])) . "', '" . safeCleanStr(addslashes($locData[1])) . "', '" . date("Y-m-d H:i:s") . "', 'true')";
                mysqli_query($db_conn, $locationInsert);

                //Insert into setup table
                $setupInsert = "INSERT INTO setup (title, config, ls2pac, ls2kids, searchdefault, pageheading, servicesheading, sliderheading, teamheading, hottitlesheading, slider_use_defaults, navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3, services_use_defaults, team_use_defaults, hottitles_use_defaults, datetime, author_name, loc_id) VALUES ('" . safeCleanStr(addslashes($locData[0])) . "', '" . safeCleanStr(addslashes($locData[2])) . "', 'true', 'true', 3, 'Pages', 'Our Services', 'Slides', 'Meet the Team', 'New Titles', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['user_name'] . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $setupInsert);

                $contactInsert = "INSERT INTO contactus (email, sendtoemail, address, city, state, zipcode, phone, hours, datetime, loc_id) VALUES ('" . safeCleanStr(addslashes($locData[8])) . "', '" . safeCleanStr(addslashes($locData[8])) . "', '" . safeCleanStr(addslashes($locData[3])) . "', '" . safeCleanStr(addslashes($locData[4])) . "', '" . safeCleanStr(addslashes($locData[5])) . "', '" . safeCleanStr(addslashes($locData[6])) . "', '" . safeCleanStr(addslashes($locData[7])) . "', '" . safeCleanStr(addslashes($locData[9])) . "', '" . date("Y-m-d H:i:s") . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $contactInsert);

                //Insert About defaults
                $aboutInsert = "INSERT INTO aboutus (heading, use_defaults, author_name, datetime, loc_id) VALUES ('About Us', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $aboutInsert);

                //Insert Featured defaults
                $featuredInsert = "INSERT INTO featured (heading, use_defaults, author_name, datetime, loc_id) VALUES ('Feature', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $featuredInsert);

                //Do Insert
                $socialInsert = "INSERT INTO socialmedia (heading, use_defaults, loc_id) VALUES ('Follow Us', 'true', " . $locIdCount . ")";
                mysqli_query($db_conn, $socialInsert);

            }
        }

        //Turn on foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=1');
    }

    //Pages Import
    if ($_FILES['csvPagesImport']['size'] > 0) {

        //Create a backup of the locations table.
        databaseDumpBackup(__DIR__ . '/backups/', 'pages');

        //example csv headers
        //title,content,url

        $pageGetUrl = '';
        $pageContent = '';
        $rowCount = 0;
        $skip_row_number = array('1');

        //get the csv file
        $pagesFile = $_FILES['csvPagesImport']['tmp_name'];
        $handle = fopen($pagesFile, 'r');

        //Turn off foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=0');

        if (!empty($_POST['empty_pagesTables'])) {
            //Truncate table
            mysqli_query($db_conn, 'TRUNCATE TABLE pages');
        } else {
            $pagesSelect = mysqli_query($db_conn, "SELECT MAX(id) FROM pages LIMIT 1");
            $pagesCount = mysqli_fetch_array($pagesSelect);
        }

        while (($pageData = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($pageData[0]) {

                $rowCount ++;

                //skip first row of csv
                if (in_array($rowCount, $skip_row_number)) {
                    continue;
                }

                if (!empty($_POST['empty_pagesTables'])) {
                    $locIdCount = $rowCount - 1;
                } else {
                    $locIdCount = $locationCount[0] + $rowCount - 1;
                }

                //If a page URL exists in the csv
                if (!empty($pageData[2])) {
                    $html = file_get_contents($pageData[2]) or die('Error accessing file');
                    $dom = new domDocument;

                    // load the html into the object
                    $dom->loadHTML($html);
                    $dom->preserveWhiteSpace = false;

                    //YSM 6.x html containers
                    if ($dom->getElementById('maincontent')) {
                        $extracted_contents = $dom->getElementById('maincontent');
                    } elseif ($dom->getElementById('maincontentwithnav')) {
                        $extracted_contents = $dom->getElementById('maincontentwithnav');
                    } else {
                        $extracted_contents = $dom->getElementsByTagName('body');
                    }

                    //Removes html from pageContent and just gets the text
                    $pageContent = $dom->saveHTML($extracted_contents);
                    $pageContent = sanitizeStr($pageContent);
                    $pageContent = strip_tags($pageContent);
                } else {
                    $pageContent = $pageData[1];
                }

                //Insert into pages table
                $pagesInsert = "INSERT INTO pages (title, content, active, loc_id) VALUES ('" . safeCleanStr(addslashes($pageData[0])) . "', '" . safeCleanStr(addslashes($pageContent)) . "', 'true', 1)";
                mysqli_query($db_conn, $pagesInsert);

            }
        }

        //Turn on foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=1');
    }

    header("Location: import.php?loc_id=" . $_GET['loc_id'] . "&update=true");
    echo "<script>window.location.href='import.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
}
if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The data has been imported.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='import.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Settings</a></li>
                <li class="active">Import Data</li>
            </ol>
            <h1 class="page-header">
                Import Data
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($errorMsg !="") {
                echo $errorMsg;
            } else {
                echo $pageMsg;
            }
            ?>

            <form name="importForm" class="dirtyForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <p>
                        <i class="fa fa-download"></i> <a href="import/templates/locations.csv" download="locations.csv">Download the CSV Template</a>
                    </p>
                </div>
                <div class="form-group">
                    <label>Import Locations</label>
                    <input type="file" name="csvLocationsImport" id="csvLocationsImport">
                    <input type="hidden" name="importLocationsCSV" value="1">

                    <div class="checkbox">
                        <label><input type="checkbox" name="empty_locTables"><small>Truncate "locations, setup, contactus" Tables?</small></label>
                    </div>
                </div>

                <hr/>
                <div class="form-group">
                    <p>
                        <i class="fa fa-download"></i> <a href="import/templates/pages.csv" download="pages.csv">Download the CSV Template</a>
                    </p>
                </div>
                <div class="form-group">
                    <label>Import Pages</label>
                    <input type="file" name="csvPagesImport" id="csvPagesImport">
                    <input type="hidden" name="importPagesCSV">

                    <div class="checkbox">
                        <label><input type="checkbox" name="empty_pagesTables"><small>Truncate "pages" Table?</small></label>
                    </div>
                </div>

                <hr/>

                <input type="hidden" name="save_main" value="true"/>
                <button type="submit" name="importForm_submit" class="btn btn-primary" data-toggle="tooltip" data-original-title=".csv - 2mb file size limit" data-placement="right"><i class="fa fa-fw fa-upload"></i> Import CSV(s)</button>
                <small>
                </small>
            </form>
        </div>
    </div>

<?php
include_once('includes/footer.inc.php');
?>