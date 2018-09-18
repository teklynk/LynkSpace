<?php
define('ALLOW_INC', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'uploads.php';

//Delete file - default
$deleteMsg = "";

//Upload message - default
$uploadMsg = "";

//Get the file name from the URL
if ($_GET["share"]) {
    $urlParam = $_GET["share"];
} elseif ($_GET["delete"]) {
    $urlParam = $_GET["delete"];
} else {
    $urlParam = '';
}

$action = safeCleanStr($_POST["action"]);
$getSharedFileName = str_replace('..', '', $urlParam);
$getSharedFileNameArr = explode('/', $getSharedFileName);
$getFileName = safeCleanStr($getSharedFileNameArr[3])?:null;
$share_location_type = safeCleanStr($_POST['share_location_type'])?:null;
$share_location_list = safeCleanStr($_POST['share_location_list'])?:null;
$fileList = getUploads(1, 'upload', 'ASC'); //returns an array

if ($action == 'uploadFile') {
    //Upload Action - Do the upload
    uploadFile(
        $action == 'uploadFile',
        image_dir,
        'true',
        800,
        4,
        2048000,
        'upload',
        $_GET["loc_id"],
        true,
        true,
        array('png', 'gif', 'jpg')
    );
}

//Delete confirm modal
if ($_GET["delete"] && !$_GET["confirm"]) {

    if ($_GET["isshared"] == 'false') {
        showModalConfirm(
            "confirm",
            "Delete Image?",
            "Are you sure you want to delete: " . $_GET["delete"] . "?",
            "uploads.php?loc_id=" . $_GET['loc_id'] . "&delete=" . $_GET["delete"] . "&confirm=yes&guid=" . $_GET['guid'] . "",
            false
        );
    } else {
        showModalConfirm(
            "confirm",
            "Delete Image?",
            "Are you sure you want to delete: " . $_GET["delete"] . "? <div class='alert alert-warning'><i class='fa fa-chain-broken'></i> <strong>Warning!</strong> This image is shared with other locations. Deleting this image may cause broken links on the site.</div> ",
            "uploads.php?loc_id=" . $_GET['loc_id'] . "&delete=" . $_GET["delete"] . "&confirm=yes&guid=" . $_GET['guid'] . "",
            false
        );
    }

} elseif ($_GET["delete"] && $_GET["confirm"] == 'yes' && $_GET['guid']) {

    //delete file if shared after clicking Yes
    //$sharedFileDelete = "DELETE FROM uploads WHERE file_name='" . $getFileName . "' AND loc_id=" . $_GET['loc_id'] . ";";
    //mysqli_query($db_conn, $sharedFileDelete);

    removeUploads(image_dir, $_GET['delete'], $_GET['guid']);

    //unlink($_GET["delete"]);
    //$deleteMsg = "<div class='alert alert-success'>" . $_GET["delete"] . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}

//Share settings - Actions, Modal, Form - Admin user only feature
if (isset($_GET['share']) && $adminIsCheck == "true" && multiBranch == 'true') {

    //Check shared uploads for any shared images
    $sqlSharedUploadsOption = mysqli_query($db_conn, "SELECT shared, file_name, loc_id FROM uploads WHERE file_name='" . $getFileName . "' AND loc_id=" . $_GET['loc_id'] . ";");
    $rowSharedUploadsOption = mysqli_fetch_array($sqlSharedUploadsOption, MYSQLI_ASSOC);

    //Share setting/options Modal with Form
    showModalConfirm(
        "confirm",
        "Share Image? <br><small>" . $getFileName . "</small>",
        "<form name='share_form' id='share_form' method='post'>
        <div class='form-group'>
            <label for='share_location_type'>Location Group</label>
            <select id='share_loc_type' class='form-control selectpicker show-tick' data-id='share_loc_type' data-dropup-auto='false' data-size='10' name='share_location_type' title='Share to a location group'><option value=''>None</option>" . getLocGroups($rowSharedUploadsOption['shared']) . "</select>
            <div class='text-center'>
                <h3>- OR -</h3>
            </div>
            <label for='share_location_list'>Location(s)</label>
            <select id='share_loc_list' class='form-control selectpicker' multiple='multiple' data-live-search='true' data-id='share_loc_list' data-dropup-auto='false' data-size='10' tabindex='1' name='share_location_list[]' title='Share to specific location(s)'><option value=''>None</option>" . getLocList($rowSharedUploadsOption['shared'], 'true') . "</select>
            <input type='hidden' name='action' value='shareFile'>
            <input type='hidden' name='csrf' value='" . $_SESSION['unique_referrer'] . "'/>
        </div>",
        "<button type='submit' class='btn btn-primary' name='share_submit' form='share_form' value='submit'><i class='fa fa-save'></i> Save</button>
        <button type='button' class='btn btn-link' data-dismiss='modal'>Cancel</button></form>",
        true
    );

    if ($share_location_type || $share_location_list) {

        $locListOptions = implode(',', $share_location_list); //Convert array to string

        if ($share_location_type <> '') {
            $sharedOptions = safeCleanStr($share_location_type); //Clean string
        } elseif ($locListOptions <> '') {
            $sharedOptions = safeCleanStr($locListOptions); //Clean string
        } else {
            $sharedOptions = '';
        }

        if ($rowSharedUploadsOption['file_name'] == $getFileName) {
            //Do Update
            $sharedUploadsOptionUpdate = "UPDATE uploads SET shared='" . $sharedOptions . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE file_name='" . $getFileName . "' AND loc_id=" . $_GET['loc_id'] . ";";
            mysqli_query($db_conn, $sharedUploadsOptionUpdate);
        } else {
            //Do Insert
            $sharedUploadsOptionInsert = "INSERT INTO uploads (shared, file_name, datetime, loc_id) VALUES ('" . $sharedOptions . "', '" . $getFileName . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ");";
            mysqli_query($db_conn, $sharedUploadsOptionInsert);
        }

        header("Location: uploads.php?loc_id=" . $_GET['loc_id'] . "", true, 302);
        echo "<script>window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "';</script>";
    }

}
?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#dataTable').dataTable({
                "iDisplayLength": 25,
                "order": [[2, "desc"]],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
            });
        });
    </script>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li class="active">Uploads</li>
            </ol>
            <h1 class="page-header">
                Uploads
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php if ($uploadMsg != "") {
                echo $uploadMsg;
            }
            if ($deleteMsg != "") {
                echo $deleteMsg;
            }
            if (!is_writable('../uploads')) {
                echo "<div class='alert alert-danger fade in'>Unable to write to the uploads folder. Check folder permissions.</div>";
            }
            ?>

            <form name="uploadForm" id="uploadForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="hidden" name="action" value="uploadFile">
                </div>

                <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                <button type="submit" name="upload_submit" form='uploadForm' class="btn btn-primary"
                        data-toggle="tooltip" data-original-title=".jpg, .gif, .png - 2mb file size limit"
                        data-placement="right"><i class="fa fa-fw fa-upload"></i> Upload
                    Image
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <hr/>
            <div>
                <table class="table table-bordered table-hover table-striped table-responsive dataTable" id="dataTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <?php
                        // if is admin then show the table header
                        if ($adminIsCheck == "true" && multiBranch == 'true') {
                            echo "<th>Shared</th>";
                        }
                        ?>
                        <th>Size</th>
                        <th>Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                        $count = 0;

                        foreach ($fileList as $file) {

                            $count++;
                            $fileSize = filesizeFormatted($file['file_size'],false);

                            if ($file['shared'] <> '') {
                                $isShared = 'btn btn-primary';
                                $isSharedVal = 'true';
                            } else {
                                $isShared = 'btn btn-default';
                                $isSharedVal = 'false';
                            }

                            echo "<tr data-index='" . $count . "'>
                            <td><a href='#' onclick=\"showMyModal('" . str_replace('../', '', image_dir) . $file['file_name'] . " : " . $fileSize . "', '" . image_dir . $file['file_name'] . "')\" title='Preview'>" . $file['file_name'] . "</a></td>";
                            if ($adminIsCheck == "true" && multiBranch == 'true') {
                                echo "<td class='col-xs-1'>
                                <button type='button' data-toggle='tooltip' title='Share' class='" . $isShared . "' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "&share=" . image_dir . $file['file_name'] . "'\"><i class='fa fa-fw fa-share-alt'></i></button>
                                <span class='hidden'>" . $isShared . "</span></td>";
                            }
                            echo "<td class='col-xs-1'>" . $fileSize . "</td>
                            <td class='col-xs-2'>" . $file['datetime'] . "</td>
                            <td class='col-xs-1'>
                            <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "&delete=" . $file['id'] . "&guid=" . $file['guid'] . "&isshared=" . $isSharedVal . "'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                            </tr>";

                        }


                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Uploads Preview Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <img id="myModalFile" src="" class="img-responsive center-block"/>
                </div>
                <div class="modal-footer">&nbsp;</div>
            </div>
        </div>
    </div>

    <!-- Modal javascript logic -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#confirm').on('hidden.bs.modal', function () {
                setTimeout(function () {
                    window.location.href = 'uploads.php?loc_id=<?php echo $_GET['loc_id']; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('delete') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
            if (url.indexOf('share') != -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>

<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>