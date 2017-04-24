<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'import.php';

//check if user is logged in and is admin and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_SESSION['session_hash'] == md5($_SESSION['user_name'])) {

//update table on submit
if (!empty($_POST)) {
    if ($_FILES['csvLocationsImport']['size'] > 0) {

        //get the csv file
        $file = $_FILES['csvLocationsImport']['tmp_name'];
        $handle = fopen($file, 'r');
        $rowCount = 0;
        $skip_row_number = array('1');

        //Truncate tables
        mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=0');
        mysqli_query($db_conn,'TRUNCATE TABLE locations');
        mysqli_query($db_conn,'TRUNCATE TABLE setup');
        mysqli_query($db_conn, "TRUNCATE TABLE contactus");

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0]) {

                $rowCount ++;

                //skip first row of csv
                if (in_array($rowCount, $skip_row_number)) {
                    continue;
                }

                $locIdCount = $rowCount - 1;

                //Do Insert
                $locationInsert = "INSERT INTO locations (id, name, type, datetime, active) VALUES (" . $locIdCount . ", '" . safeCleanStr(addslashes($data[0])) . "', '" . safeCleanStr(addslashes($data[1])) . "', '" . date("Y-m-d H:i:s") . "', 'true')";
                mysqli_query($db_conn, $locationInsert);

                $setupInsert = "INSERT INTO setup (title, config, ls2pac, ls2kids, datetime, author_name, loc_id) VALUES ('" . safeCleanStr(addslashes($data[0])) . "', '" . safeCleanStr(addslashes($data[2])) . "', 'true', 'true', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['user_name'] . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $setupInsert);

                $contactInsert = "INSERT INTO contactus (email, sendtoemail, address, city, state, zipcode, phone, datetime, loc_id) VALUES ('" . safeCleanStr(addslashes($data[8])) . "', '" . safeCleanStr(addslashes($data[8])) . "', '" . safeCleanStr(addslashes($data[3])) . "', '" . safeCleanStr(addslashes($data[4])) . "', '" . safeCleanStr(addslashes($data[5])) . "', '" . safeCleanStr(addslashes($data[6])) . "', '" . safeCleanStr(addslashes($data[7])) . "', '" . date("Y-m-d H:i:s") . "', " . $locIdCount . ")";
                mysqli_query($db_conn, $contactInsert);
            }
        }

        header("Location: import.php?loc_id=" . $_GET['loc_id'] . "&update=true");
        echo "<script>window.location.href='import.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
    }

    mysqli_query($db_conn,'SET FOREIGN_KEY_CHECKS=1');

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
        <form name="importForm" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Import Locations</label>
                <input type="file" name="csvLocationsImport" id="csvLocationsImport">
                <input type="hidden" name="importLocationsCSV" value="1">
            </div>

            <hr/>

            <div class="form-group">
                <label>Import Pages</label>
                <input type="file" name="csvPagesImport" id="csvPagesImport">
                <input type="hidden" name="importPagesCSV" value="1">
            </div>

            <?php
            $pageUrl = file_get_contents('https://teklynk.com/');

            preg_match('/<title>([^<]+)<\/title>/i', $pageUrl, $matches);
            $title = $matches[1];
            echo strip_tags($title);

            preg_match('~<body[^>]*>(.*?)</body>~si', $pageUrl, $matches2);
            $tagContents = $matches2[1];
            echo strip_tags($tagContents);

            ?>

            <hr/>

            <button type="submit" name="importForm_submit" class="btn btn-primary" data-toggle="tooltip" data-original-title=".csv - 2mb file size limit" data-placement="right"><i class="fa fa-fw fa-upload"></i> Import CSV(s)</button>
            <small>
                &nbsp;&nbsp;Over-ride theme CSS styles and other files.&nbsp;&nbsp;<i class="fa fa-question-circle-o"></i>
            </small>
        </form>
    </div>
</div>

<?php
} else {
    die('Direct access not permitted');
}

include_once('includes/footer.inc.php');
?>