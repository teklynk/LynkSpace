<?php
define('ALLOW_INC', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'hottitles.php';

$delhottitlesId = isset( $_GET['deletehottitles'] ) ? safeCleanStr( $_GET['deletehottitles'] ) : null;
$delhottitlesTitle = isset( $_GET['deletetitle'] ) ? safeCleanStr( $_GET['deletetitle'] ) : null;
$delhottitlesGuid = isset( $_GET['guid'] ) ? safeCleanStr( $_GET['guid'] ) : null;
$delhottitlesToken = isset( $_GET['token'] ) ? safeCleanStr( $_GET['token'] ) : null;

//get location type from locations table
$sqlLocations = mysqli_query($db_conn, "SELECT id, type FROM locations WHERE id=" . loc_id . ";");
$rowLocations = mysqli_fetch_array($sqlLocations, MYSQLI_ASSOC);

?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
            <li class="active">Hot Titles</li>
        </ol>
        <h1 class="page-header">
            Hot Titles
        </h1>
    </div>
</div>
<?php

echo flashMessageGet('success');

//delete hottitle
if ($delhottitlesId && $delhottitlesTitle && !$_GET['confirm']) {

    showModalConfirm(
        "confirm",
        "Delete Hot Title?",
        "Are you sure you want to delete: " . $delhottitlesTitle . "?",
        "hottitles.php?loc_id=" . loc_id . "&deletehottitles=" . $delhottitlesId . "&guid=" . $delhottitlesGuid . "&deletetitle=" . $delhottitlesTitle . "&confirm=yes",
        false
    );


} elseif ($delhottitlesId && $delhottitlesTitle && $_GET['confirm'] == 'yes' && $delhottitlesGuid) {
    //delete hot title after clicking Yes
    $hottitlesDelete = "DELETE FROM hottitles WHERE id=" . $delhottitlesId . " AND guid='" . $delhottitlesGuid . "' AND loc_id=" . loc_id . ";";
    mysqli_query($db_conn, $hottitlesDelete);

    flashMessageSet('success', $delhottitlesTitle . " has been deleted.");

	//Redirect back to main page
	header( "Location: hottitles.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='hottitles.php?loc_id=" . loc_id . "';</script>";
	exit();

}

//update heading on submit
if (!empty($_POST['save_main'])) {

    $main_heading = safeCleanStr($_POST['main_heading']);
    $hottitles_count = safeCleanStr($_POST['hottitles_count']);

    $setupUpdate = "UPDATE setup SET hottitlesheading='" . $main_heading . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . loc_id . ";";
    mysqli_query($db_conn, $setupUpdate);

    for ($i = 0; $i < $hottitles_count; $i++) {

        $hottitles_sort = isset( $_POST['hottitles_sort'][$i] ) ? safeCleanStr( $_POST['hottitles_sort'][$i] ) : null;
        $hottitles_title = isset( $_POST['hottitles_title'][$i] ) ? safeCleanStr( $_POST['hottitles_title'][$i] ) : null;
        $hottitles_url = isset( $_POST['hottitles_url'][$i] ) ? validateUrl( $_POST['hottitles_url'][$i] ) : null;
        $location_type = isset( $_POST['location_type'][$i] ) ? safeCleanStr( $_POST['location_type'][$i] ) : null;
        $hottitles_id = isset( $_POST['hottitles_id'][$i] ) ? safeCleanStr( $_POST['hottitles_id'][$i] ) : null;

        $hottitlesUpdate = "UPDATE hottitles SET sort=" . $hottitles_sort . ", title='" . $hottitles_title . "', url='" . $hottitles_url . "', loc_type='" . $location_type . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=" . $hottitles_id . " AND loc_id=" . loc_id . ";";
        mysqli_query($db_conn, $hottitlesUpdate);
    }

    flashMessageSet('success', 'The hot titles section has been updated.');

	//Redirect back to main page
	header( "Location: hottitles.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='hottitles.php?loc_id=" . loc_id . "';</script>";
	exit();

}

if ($_POST['add_hottitles']) {

    $hottitles_title = isset( $_POST['hottitles_title'] ) ? safeCleanStr( $_POST['hottitles_title'] ) : null;
    $hottitles_url = isset( $_POST['hottitles_url'] ) ? safeCleanStr( $_POST['hottitles_url'] ) : null;
    $location_type = isset( $_POST['location_type'] ) ? safeCleanStr( $_POST['location_type'] ) : null;

    //Insert Hot Titles
    if (strpos($hottitles_url, 'econtent') || strpos($hottitles_url, 'dynamic') || strpos($hottitles_url, 'static')) {
        if (!empty($hottitles_sort)) {
            $hottitles_sort = safeCleanStr($_POST['hottitles_sort']);
        } else {
            $hottitles_sort = 0;
        }

        $hottitlesInsert = "INSERT INTO hottitles (sort, title, url, guid, loc_type, loc_id, active, datetime) VALUES (" . $hottitles_sort . ", '" . $hottitles_title . "', '" . $hottitles_url . "', '" . getGuid() . "', '" . $location_type . "', " . loc_id . ", 'false', '" . date("Y-m-d H:i:s") . "')";
        mysqli_query($db_conn, $hottitlesInsert);

        flashMessageSet('success', 'The hot titles has been updated.');

	    //Redirect back to main page
	    header( "Location: hottitles.php?loc_id=" . loc_id . "", true, 302 );
	    echo "<script>window.location.href='hottitles.php?loc_id=" . loc_id . "';</script>";
	    exit();

    } else {

        flashMessageSet('danger', $hottitles_url . " is not a valid RSS feed.");

	    //Redirect back to main page
	    header( "Location: hottitles.php?loc_id=" . loc_id . "", true, 302 );
	    echo "<script>window.location.href='hottitles.php?loc_id=" . loc_id . "';</script>";
	    exit();
    }

}

$sqlSetup = mysqli_query($db_conn, "SELECT hottitlesheading, hottitles_use_defaults FROM setup WHERE loc_id=" . loc_id . ";");
$rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

//use default location
if ($rowSetup['hottitles_use_defaults'] == 'true') {
    $selDefaults = ' CHECKED ';
} else {
    $selDefaults = '';
}

if (loc_id != 1) {
    ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group" id="hottitlesdefaults">
                <label>Use Defaults</label>
                <div class="checkbox">
                    <label>
                        <input class="hottitles_defaults_checkbox defaults-toggle" id="<?php echo loc_id ?>"
                               name="hottitles_defaults" type="checkbox" <?php if (loc_id) {
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
<!-- Add user form-->
<button type="button" class="btn btn-primary" data-toggle="collapse" id="addHottitles_button"
        data-target="#addHottitlesDiv">
    <i class='fa fa-fw fa-plus'></i> Add a List
</button>
<h2></h2>

<div id="addHottitlesDiv" class="accordion-body collapse panel-body">

    <div class="row">
        <div class="col-lg-8">
            <fieldset class="well">
                <form name="addhottitlesForm" class="dirtyForm" method="post">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="hottitles_sort">Sort Order</label>
                            <input type="number" class="form-control" name="hottitles_sort" id="hottitles_sort"
                                   maxlength="3">
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group required">
                            <label for="hottitles_title">Title</label>
                            <input class="form-control" type="text" name="hottitles_title" id="hottitles_title"
                                   maxlength="255"
                                   placeholder="Title" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group required">
                            <label for="hottitles_url">Saved Search RSS URL</label>
                            <input class="form-control" type="url" name="hottitles_url" id="hottitles_url"
                                   maxlength="255"
                                   pattern="<?php echo urlValidationPattern; ?>"
                                   placeholder="http://mydomain.com:8080/list/dynamic/8675309/rss" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <?php
                        if ($adminIsCheck == "true") {
                            ?>
                            <div class="form-group">
                                <label for="location_type">Location Group</label>
                                <select class="form-control selectpicker bs-placeholder show-tick" data-container="body"
                                        data-dropup-auto="false" data-size="10" name="location_type" id="location_type"
                                        title="Choose a location group">
                                    <?php echo getLocGroups(); ?>
                                </select>
                            </div>
                            <?php
                        } else {
                            echo "<input type='hidden' name='location_type' value='" . $rowLocations['type'] . "'/>";
                        }
                        ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">

                            <input type="hidden" name="csrf"
                                   value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                            <input type="hidden" name="add_hottitles" value="true"/>
                            <button type="submit" name="hottitlesAdd_submit" class="btn btn-primary"><i
                                    class='fa fa-fw fa-save'></i> Save Changes
                            </button>
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
                <div class="form-group required">
                    <label>Heading</label>
                    <input type="text" class="form-control count-text" name="main_heading" id="main_heading"
                           maxlength="255"
                           value="<?php echo $rowSetup['hottitlesheading']; ?>" placeholder="New Titles" autofocus
                           required>
                </div>
                <div>
                    <table class="table table-bordered table-hover table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Title</th>
                            <th>URL</th>

                            <?php
                            // if is admin then show the table header
                            if ($adminIsCheck == "true") {
                                echo "<th>Location Group</th>";
                            }
                            ?>

                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $hottitlesCount = "";
                        $sqlHottitles = mysqli_query($db_conn, "SELECT id, sort, title, url, guid, loc_type, active, loc_id FROM hottitles WHERE loc_id=" . loc_id . " ORDER BY sort, loc_type, title ASC;");
                        while ($rowHottitles = mysqli_fetch_array($sqlHottitles, MYSQLI_ASSOC)) {
                            $hottitlesId = $rowHottitles['id'];
                            $hottitlesSort = $rowHottitles['sort'];
                            $hottitlesTitle = safeCleanStr(addslashes($rowHottitles['title']));
                            $hottitlesUrl = validateUrl(safeCleanStr($rowHottitles['url']));
                            $hottitlesGuid = safeCleanStr($rowHottitles['guid']);
                            $hottitlesLocType = $rowHottitles['loc_type'];
                            $hottitlesActive = $rowHottitles['active'];
                            $hottitlesCount++;

                            if ($rowHottitles['active'] == 'true') {
                                $isActive = "CHECKED";
                            } else {
                                $isActive = "";
                            }

                            echo "<tr>
                            <td class='col-xs-1'>
                                <input class='form-control' name='hottitles_sort[]' value='" . $hottitlesSort . "' type='number' maxlength='3' required>
                            </td>
                            
                            <td>
                                <input type='hidden' name='hottitles_id[]' value='" . $hottitlesId . "' >
                                <input class='form-control' name='hottitles_title[]' value='" . $hottitlesTitle . "' type='text' maxlength='255' required>
                            </td>";

                            echo "<td><input class='form-control' type='url' name='hottitles_url[]' value='" . $hottitlesUrl . "' pattern='" . urlValidationPattern . "' maxlength='255' required></td>";

                            //If admin, show location type drop down list else show a hidden input with the locations type value
                            if ($adminIsCheck == "true") {
                                echo "<td>";
                                echo "<select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='location_type[]'>";
                                echo getLocGroups($hottitlesLocType);
                                echo "</select>";
                                echo "</td>";
                            } else {
                                echo "<input type='hidden' name='location_type[]' value='" . $rowLocations['type'] . "' >";
                            }

                            echo "<td class='col-xs-1'>
                                <input data-toggle='toggle' title='Hottitle Active' class='checkbox hottitles_status_checkbox' id='" . $hottitlesId . "' type='checkbox' " . $isActive . ">
                            </td>";

                            echo "<td class='col-xs-2'>
                                <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='hottitles.php?loc_id=" . loc_id . "&deletehottitles=" . $hottitlesId . "&guid=" . $hottitlesGuid . "&deletetitle=" . $hottitlesTitle . "'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                        </tr>";
                        } ?>
                        </tbody>
                    </table>
                </div>

                <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                <input type="hidden" name="hottitles_count" value="<?php echo $hottitlesCount; ?>"/>
                <input type="hidden" name="save_main" value="true"/>
                <button type="submit" name="hottitlesMain_submit" class="btn btn-primary"><i
                        class="fa fa-fw fa-save"></i> Save Changes
                </button>
                <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
            </form>
        </div>
    </div>
</div>
<!-- Modal javascript logic -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#confirm').on('hidden.bs.modal', function () {
            setTimeout(function () {
                window.location.href = 'hottitles.php?loc_id=<?php echo loc_id; ?>';
            }, 100);
        });

        var url = window.location.href;
        if (url.indexOf('deletehottitles') != -1 && url.indexOf('confirm') == -1) {
            setTimeout(function () {
                $('#confirm').modal('show');
            }, 100);
        }
    });
</script>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>
