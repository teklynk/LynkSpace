<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'hottitles.php';

$pageMsg = "";
$deleteMsg = "";

//get location type from locations table
$sqlLocations = mysqli_query($db_conn, "SELECT id, type FROM locations WHERE id=" . $_GET['loc_id'] . " ");
$rowLocations = mysqli_fetch_array($sqlLocations);

?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">Hot Titles</li>
        </ol>
        <h1 class="page-header">
            Hot Titles
        </h1>
    </div>
</div>
<?php

if ($_GET['update'] == 'true'){
    $pageMsg = "<div class='alert alert-success'>The hot titles has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='hottitles.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";

    if ($errorMsg !="") {
        echo $errorMsg;
    } else {
        echo $pageMsg;
    }

} else {
    $pageMsg = '';
}

if ($deleteMsg != "") {
    echo $deleteMsg;
}

$delhottitlesId = $_GET['deletehottitles'];
$delhottitlesTitle = $_GET['deletetitle'];

//delete hottitle
if ($_GET['deletehottitles'] && $_GET['deletetitle'] && !$_GET['confirm']) {

    $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $delhottitlesTitle . "? <a href='?loc_id=" . $_GET['loc_id'] . "&deletehottitles=" . $delhottitlesId . "&deletetitle=" . safeCleanStr(addslashes($delhottitlesTitle)) . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='hottitles.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    echo $deleteMsg;

} elseif ($_GET['deletehottitles'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes') {
    //delete hot title after clicking Yes
    $hottitlesDelete = "DELETE FROM hottitles WHERE id='$delhottitlesId'";
    mysqli_query($db_conn, $hottitlesDelete);

    $deleteMsg = "<div class='alert alert-success'>" . $delhottitlesTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='hottitles.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    echo $deleteMsg;
}

//update heading on submit
if (($_POST['save_main'])) {

    $setupUpdate = "UPDATE setup SET hottitlesheading='" . safeCleanStr($_POST['main_heading']) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
    mysqli_query($db_conn, $setupUpdate);

    for ($i = 0; $i < $_POST['hottitles_count']; $i++) {
        $errorMsg = "";
        $hottitlesUpdate = "UPDATE hottitles SET sort=" . safeCleanStr($_POST['hottitles_sort'][$i]) . ", title='" . safeCleanStr($_POST['hottitles_title'][$i]) . "', url='" . validateUrl($_POST['hottitles_url'][$i]) . "', loc_type='" . safeCleanStr($_POST['location_type'][$i]) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=" . $_POST['hottitles_id'][$i] . " ";
        mysqli_query($db_conn, $hottitlesUpdate);
    }
    if ($errorMsg == "") {
        header("Location: hottitles.php?loc_id=" . $_GET['loc_id'] . "&update=true");
        echo "<script>window.location.href='hottitles.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
    }
}

if (($_POST['add_hottitles'])) {
    $errorMsg = "";
    //Insert Hot Titles
    $hottitlesInsert = "INSERT INTO hottitles (sort, title, url, loc_type, loc_id, active, datetime) VALUES (" . safeCleanStr($_POST['hottitles_sort']) . ", '" . safeCleanStr($_POST['hottitles_title']) . "', '" . validateUrl($_POST['hottitles_url']) . "', '" . safeCleanStr($_POST['location_type']) . "', " . $_GET['loc_id'] . ", 'true', '" . date("Y-m-d H:i:s") . "')";
    mysqli_query($db_conn, $hottitlesInsert);
    if ($errorMsg == "") {
        header("Location: hottitles.php?loc_id=" . $_GET['loc_id'] . "&update=true");
        echo "<script>window.location.href='hottitles.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
    }
}

$sqlSetup = mysqli_query($db_conn, "SELECT hottitlesheading, hottitles_use_defaults FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowSetup = mysqli_fetch_array($sqlSetup);

//use default location
if ($rowSetup['hottitles_use_defaults'] == 'true') {
    $selDefaults = "CHECKED";
} else {
    $selDefaults = "";
}

if ($_GET['loc_id'] != 1) {
    ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group" id="hottitlesdefaults">
                <label>Use Defaults</label>
                <div class="checkbox">
                    <label>
                        <input class="hottitles_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="hottitles_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                    </label>
                </div>
            </div>
        </div>
    </div>

    <hr/>
    <?php
}
?>
<!-- Add user form-->
<button type="button" class="btn btn-primary" data-toggle="collapse" id="addHottitles_button" data-target="#addHottitlesDiv">
    <i class='fa fa-fw fa-plus'></i> Add a List
</button>
<h2></h2>

<div id="addHottitlesDiv" class="accordion-body collapse panel-body">

    <div class="row">
        <div class="col-lg-8">
            <fieldset class="well">
                <form name="addhottitlesForm" class="dirtyForm" method="post" action="">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="hottitles_sort">Sort Order</label>
                            <input type="text" class="form-control" name="hottitles_sort" id="hottitles_sort" maxlength="3" required>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            <label for="hottitles_title">Title</label>
                            <input class="form-control" type="text" name="hottitles_title" maxlength="255" placeholder="Title" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="hottitles_url">Saved Search RSS URL</label>
                            <input class="form-control" type="url" name="hottitles_url" maxlength="255" pattern="<?php echo $urlValidationPattern; ?>" placeholder="http://mydomain.com:8080/list/dynamic/8675309/rss" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <?php
                        //loop through the array of location Types
                        $locMenuStr = "";
                        $locArrlength = count($locTypes);
                        for ($x = 0; $x < $locArrlength; $x++) {
                            $locMenuStr .= "<option value=" . $locTypes[$x] . ">" . $locTypes[$x] . "</option>";
                        }

                        if ($adminIsCheck == "true") {
                            ?>
                            <div class="form-group">
                                <label for="location_type">Location Type</label>
                                <select class='form-control' name='location_type' id='location_type'>
                                    <?php echo $locMenuStr; ?>
                                </select>
                            </div>
                            <?php
                        } else {
                            echo "<input type='hidden' name='location_type' value='".$rowLocations['type']."'/>";
                        }
                        ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="hidden" name="add_hottitles" value="true"/>
                            <button type="submit" name="hottitlesAdd_submit" class="btn btn-primary"><i class='fa fa-fw fa-plus'></i> Add List</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <hr/>
        </div>
    </div>
</div>

<!--Users table-->
<div class="row">
    <div class="col-lg-12">
        <div>
            <form name="hottitlesForm" class="dirtyForm" method="post" action="">
                <div class="form-group">
                    <label>Heading</label>
                    <input type="text" class="form-control count-text" name="main_heading" maxlength="255" value="<?php echo $rowSetup['hottitlesheading']; ?>" placeholder="New Titles" autofocus required>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>Sort</th>
                        <th>Title</th>
                        <th>URL</th>

                        <?php
                        // if is admin then show the table header
                        if ($adminIsCheck == "true") {
                            echo "<th>Location Type</th>";
                        }
                        ?>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $hottitlesCount = "";
                    $sqlHottitles = mysqli_query($db_conn, "SELECT id, sort, title, url, loc_type, active, loc_id FROM hottitles WHERE loc_id=" . $_GET['loc_id'] . " ORDER BY sort, loc_type, title ASC");
                    while ($rowHottitles = mysqli_fetch_array($sqlHottitles)) {
                        $hottitlesId = $rowHottitles['id'];
                        $hottitlesSort = $rowHottitles['sort'];
                        $hottitlesTitle = $rowHottitles['title'];
                        $hottitlesUrl = $rowHottitles['url'];
                        $hottitlesLocType = $rowHottitles['loc_type'];
                        $hottitlesActive = $rowHottitles['active'];
                        $hottitlesCount++;

                        if ($rowHottitles['active'] == 'true') {
                            $isActive = "CHECKED";
                        } else {
                            $isActive = "";
                        }

                        //loop through the array of location Types
                        $locMenuStr = "";
                        $locArrlength = count($locTypes);
                        for ($x = 0; $x < $locArrlength; $x++) {
                            if ($locTypes[$x] == $hottitlesLocType) {
                                $isSectionSelected = "SELECTED";
                            } else {
                                $isSectionSelected = "";
                            }
                            $locMenuStr .= "<option value=" . $locTypes[$x] . " " . $isSectionSelected . ">" . $locTypes[$x] . "</option>";
                        }

                        echo "<tr>
                            <td class='col-xs-1'>
                                <input class='form-control' name='hottitles_sort[]' value='" . $hottitlesSort . "' type='text' maxlength='3' required>
                            </td>
                            
                            <td>
                                <input type='hidden' name='hottitles_id[]' value='" . $hottitlesId . "' >
                                <input class='form-control' name='hottitles_title[]' value='" . $hottitlesTitle . "' type='text' maxlength='255'>
                            </td>";

                            echo "<td><input class='form-control' type='url' name='hottitles_url[]' value='".$hottitlesUrl."' pattern='".$urlValidationPattern."' maxlength='255' required></td>";

                            //If admin, show location type drop down list else show a hidden input with the locations type value
                            if ($adminIsCheck == "true") {
                                echo "<td>";
                                echo "<select class='form-control' name='location_type[]'>";
                                echo $locMenuStr;
                                echo "</select>";
                                echo "</td>";
                            } else {
                                echo "<input type='hidden' name='location_type[]' value='".$rowLocations['type']."' >";
                            }

                            echo "<td class='col-xs-1'>
                                <input data-toggle='toggle' title='Hottitle Active' class='checkbox hottitles_status_checkbox' id='" . $hottitlesId . "' type='checkbox' " . $isActive . ">
                            </td>";

                            echo "<td class='col-xs-2'>
                                <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='hottitles.php?loc_id=" . $_GET['loc_id'] . "&deletehottitles=$hottitlesId&deletetitle=" . safeCleanStr(addslashes($hottitlesTitle)) . "'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                        </tr>";
                    } ?>
                    </tbody>
                </table>
                </div>
                <input type="hidden" name="hottitles_count" value="<?php echo $hottitlesCount; ?>"/>
                <input type="hidden" name="save_main" value="true"/>
                <button type="submit" name="hottitlesMain_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.inc.php');
?>
