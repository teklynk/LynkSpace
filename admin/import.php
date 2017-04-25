<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'import.php';

// Only allow super-admin users access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1 && $_SESSION['super_admin'] == false) {

    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}

//update table on submit
if ($_POST['save_main']) {

    //var_dump($_POST);
   // die();

    if ($_FILES['csvLocationsImport']['size'] > 0) {

        //example csv headers
        //name,type,config,address,city,state,zipcode,phone,email,hours

        $rowCount = 0;
        $skip_row_number = array('1');

        //get the csv file
        $lacotionsFile = $_FILES['csvLocationsImport']['tmp_name'];
        $handle = fopen($lacotionsFile, 'r');

        //Turn off foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=0');

        if ($_POST['empty_locTables'] == 'on') {
            //Truncate tables
            mysqli_query($db_conn, 'TRUNCATE TABLE locations');
            mysqli_query($db_conn, 'TRUNCATE TABLE setup');
            mysqli_query($db_conn, 'TRUNCATE TABLE contactus');
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0]) {

                $rowCount ++;

                //skip first row of csv
                if (in_array($rowCount, $skip_row_number)) {
                    continue;
                }

                $locIdCount = $rowCount - 1;

                //Insert into locations table
                $locationInsert = "INSERT INTO locations (id, name, type, datetime, active) VALUES (" . $locIdCount . ", '" . safeCleanStr(addslashes($data[0])) . "', '" . safeCleanStr(addslashes($data[1])) . "', '" . date("Y-m-d H:i:s") . "', 'true')";
                mysqli_query($db_conn, $locationInsert);

                if (!$locationInsert){
                    echo "<div class='import_error_msg alert-danger'>";
                    echo mysqli_error($db_conn) . PHP_EOL;
                    echo "</div>";
                }

                //Insert into setup table
                $setupInsert = "INSERT INTO setup (title, config, ls2pac, ls2kids, searchdefault, pageheading, servicesheading, sliderheading, teamheading, hottitlesheading, customersheading_1, customersheading_2, customersheading_3, slider_use_defaults, databases_use_defaults_1, databases_use_defaults_2, databases_use_defaults_3, navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3, services_use_defaults, team_use_defaults, hottitles_use_defaults, datetime, author_name, loc_id) VALUES ('" . safeCleanStr(addslashes($data[0])) . "', '" . safeCleanStr(addslashes($data[2])) . "', 'true', 'true', 3, 'Pages', 'Our Services', 'Slides', 'Meet the Team', 'New Titles', 'Resources', 'Recommended Websites', 'Librarian Links', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['user_name'] . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $setupInsert);

                if (!$setupInsert){
                    echo "<div class='import_error_msg alert-danger'>";
                    echo mysqli_error($db_conn) . PHP_EOL;
                    echo "</div>";
                }

                $contactInsert = "INSERT INTO contactus (email, sendtoemail, address, city, state, zipcode, phone, hours, datetime, loc_id) VALUES ('" . safeCleanStr(addslashes($data[8])) . "', '" . safeCleanStr(addslashes($data[8])) . "', '" . safeCleanStr(addslashes($data[3])) . "', '" . safeCleanStr(addslashes($data[4])) . "', '" . safeCleanStr(addslashes($data[5])) . "', '" . safeCleanStr(addslashes($data[6])) . "', '" . safeCleanStr(addslashes($data[7])) . "', '" . safeCleanStr(addslashes($data[9])) . "', '" . date("Y-m-d H:i:s") . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $contactInsert);

                if (!$contactInsert){
                    echo "<div class='import_error_msg alert-danger'>";
                    echo mysqli_error($db_conn) . PHP_EOL;
                    echo "</div>";
                }
            }
        }

        //Turn on foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=1');
    }

    //Pages Import
    if ($_FILES['csvPagesImport']['size'] > 0) {

        //example csv headers
        //title,content

        $rowCount = 0;
        $skip_row_number = array('1');

        //get the csv file
        $lacotionsFile = $_FILES['csvPagesImport']['tmp_name'];
        $handle = fopen($lacotionsFile, 'r');

        //Turn off foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=0');

        if ($_POST['empty_pagesTables'] == 'on') {
            //Truncate table
            mysqli_query($db_conn, 'TRUNCATE TABLE pages');
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0]) {

                $rowCount ++;

                //skip first row of csv
                if (in_array($rowCount, $skip_row_number)) {
                    continue;
                }

                $locIdCount = $rowCount - 1;

                //Insert into locations table
                $locationInsert = "INSERT INTO locations (id, name, type, datetime, active) VALUES (" . $locIdCount . ", '" . safeCleanStr(addslashes($data[0])) . "', '" . safeCleanStr(addslashes($data[1])) . "', '" . date("Y-m-d H:i:s") . "', 'true')";
                mysqli_query($db_conn, $locationInsert);

                if (!$locationInsert){
                    echo "<div class='import_error_msg alert-danger'>";
                    echo mysqli_error($db_conn) . PHP_EOL;
                    echo "</div>";
                }

                //Insert into setup table
                $setupInsert = "INSERT INTO setup (title, config, ls2pac, ls2kids, searchdefault, pageheading, servicesheading, sliderheading, teamheading, hottitlesheading, customersheading_1, customersheading_2, customersheading_3, slider_use_defaults, databases_use_defaults_1, databases_use_defaults_2, databases_use_defaults_3, navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3, services_use_defaults, team_use_defaults, hottitles_use_defaults, datetime, author_name, loc_id) VALUES ('" . safeCleanStr(addslashes($data[0])) . "', '" . safeCleanStr(addslashes($data[2])) . "', 'true', 'true', 3, 'Pages', 'Our Services', 'Slides', 'Meet the Team', 'New Titles', 'Resources', 'Recommended Websites', 'Librarian Links', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['user_name'] . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $setupInsert);

                if (!$setupInsert){
                    echo "<div class='import_error_msg alert-danger'>";
                    echo mysqli_error($db_conn) . PHP_EOL;
                    echo "</div>";
                }

                $contactInsert = "INSERT INTO contactus (email, sendtoemail, address, city, state, zipcode, phone, hours, datetime, loc_id) VALUES ('" . safeCleanStr(addslashes($data[8])) . "', '" . safeCleanStr(addslashes($data[8])) . "', '" . safeCleanStr(addslashes($data[3])) . "', '" . safeCleanStr(addslashes($data[4])) . "', '" . safeCleanStr(addslashes($data[5])) . "', '" . safeCleanStr(addslashes($data[6])) . "', '" . safeCleanStr(addslashes($data[7])) . "', '" . safeCleanStr(addslashes($data[9])) . "', '" . date("Y-m-d H:i:s") . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $contactInsert);

                if (!$contactInsert){
                    echo "<div class='import_error_msg alert-danger'>";
                    echo mysqli_error($db_conn) . PHP_EOL;
                    echo "</div>";
                }
            }
        }

        //Turn on foreign key constraints
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=1');
    }

    if ($_GET['update'] == 'true') {
        $pageMsg = "<div class='alert alert-success'>The data has been imported.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='import.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    }
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

        <div class="instructions">
            <p>
            Import data into the CSV template and upload.
            </p>
            <hr/>
        </div>

        <form name="importForm" class="dirtyForm" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <p>
                    <a href="import/templates/locations.csv" download="locations.csv"><p>Download the CSV Template</p></a>
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
                    <a href="import/templates/pages.csv" download="pages.csv"><p>Download the CSV Template?</p></a>
                </p>
            </div>
            <div class="form-group">
                <label>Import Pages</label>
                <input type="file" name="csvPagesImport" id="csvPagesImport">
                <input type="hidden" name="importPagesCSV">

                <div class="checkbox">
                    <label><input type="checkbox" name="empty_pagesTables" value="0"><small>Truncate "pages" Table</small></label>
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