<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'uploads.php';

//Upload Action - Do the upload
uploadFile($_POST["uploadFile"], image_dir, 'true', 800, 4, 2048000);

//Delete file
$deleteMsg = "";

//Get the file name from the URL
$getSharedFileName = str_replace('..', '', $_GET["share"]);
$getSharedFileNameArr = explode('/', $getSharedFileName);

$locTypeOption = $_POST['share_location_type'];
$locListOption = $_POST['share_location_list[]'];

//Delete confirm modal
if ($_GET["delete"] && !$_GET["confirm"]) {

    showModalConfirm(
        "confirm",
        "Delete Image?",
        "Are you sure you want to delete: ".$_GET["delete"]."?",
        "uploads.php?loc_id=".$_GET['loc_id']."&delete=".$_GET["delete"]."&confirm=yes",
        false
    );

} elseif ($_GET["delete"] && $_GET["confirm"] == 'yes') {
    //TODO: Delete from shared_uploads table where filename = $_GET["delete"]
    unlink($_GET["delete"]);
    $deleteMsg = "<div class='alert alert-success'>" . $_GET["delete"] . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}

//Share modal window
if ($_GET["share"] && !$_GET["confirm"]) {

    //Check shared_uploads table for any shared images
    $sqlSharedUploadsOption = mysqli_query($db_conn, "SELECT shared, filename, loc_id FROM shared_uploads WHERE filename='".$getSharedFileNameArr[3]."' AND shared <> '' AND loc_id=1");
    $rowSharedUploadsOption = mysqli_fetch_array($sqlSharedUploadsOption);

    //Share settings - modal html
    $shareFormHTML = "<div class='form-group'>
        <form name='share_form' method='post'>
            <label for='share_location_type'>Location Group</label>
            <select id='share_loc_type' class='form-control selectpicker show-tick' data-id='share_loc_type' data-dropup-auto='false' data-size='10' name='share_location_type' title='Share to a location group'><option value=''>None</option>".getLocGroups($rowSharedUploadsOption['shared'])."</select>
                <div class='text-center'>
                    <h3>- OR -</h3>
                </div>
            <label for='share_location_list'>Location(s)</label>
            <select id='share_loc_list' class='form-control selectpicker' multiple data-id='share_loc_list' data-dropup-auto='false' data-size='10' name='share_location_list[]' title='Share to specific location(s)'><option value=''>None</option>".getLocList($rowSharedUploadsOption['shared'])."</select>
        </form>
    </div>";

    showModalConfirm(
        "confirm",
        "Share Image? <br><small>".$_GET['share']."</small>",
        $shareFormHTML,
        "<button type='button' class='btn btn-primary' data-dismiss='modal' onclick=\"window.location.href='uploads.php?loc_id=".$_GET['loc_id']."&share=".$_GET["share"]."&confirm=yes'\"><i class='fa fa-save'></i> Save</button>
    <button type='button' class='btn btn-link' data-dismiss='modal'>Cancel</button>",
        true
    );

} elseif ($_GET["share"] && $_GET["confirm"] == 'yes') {

    if ($locTypeOption <> ''){
        $sharedOptions = $locTypeOption;
    } elseif ($locListOption <> ''){
        $sharedOptions = $locListOption;
    } else {
        $sharedOptions = '';
    }

    //Check shared_uploads table for any shared images
    $sqlSharedUploadsOption = mysqli_query($db_conn, "SELECT shared, filename, loc_id FROM shared_uploads WHERE filename='".$getSharedFileNameArr[3]."' AND loc_id=1");
    $rowSharedUploadsOption = mysqli_fetch_array($sqlSharedUploadsOption);

    if ($rowSharedUploadsOption['filename'] == $getSharedFileNameArr[3]) {
        echo $sharedOptions;
        die();
        //Do Update
        $sharedUploadsOptionUpdate = "UPDATE shared_uploads SET shared='" . $sharedOptions . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE filename='".$getSharedFileNameArr[3]."' AND loc_id=" . $_GET['loc_id'] . " ";
        mysqli_query($db_conn, $sharedUploadsOptionUpdate);
    } else {
        //Do Insert
        $sharedUploadsOptionInsert = "INSERT INTO shared_uploads (shared, filename, datetime, loc_id) VALUES ('" . $sharedOptions . "', '".$getSharedFileNameArr[3]."', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
        mysqli_query($db_conn, $sharedUploadsOptionInsert);
    }

    header("Location: uploads.php?loc_id=" . $_GET['loc_id'] . "");
    echo "<script>window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "';</script>";
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "iDisplayLength": 25,
            "order": [[3, "desc"]],
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
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">Uploads</li>
        </ol>
        <h1 class="page-header">
            Uploads
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
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

        <form name="uploadForm" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="hidden" name="uploadFile" value="1">
            </div>
            <button type="submit" name="upload_submit" class="btn btn-primary" data-toggle="tooltip" data-original-title=".jpg, .gif, .png - 2mb file size limit" data-placement="right"><i class="fa fa-fw fa-upload"></i> Upload
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
                if ($handle = opendir(image_dir)) {

                    $count = 0;

                    while (false !== ($file = readdir($handle))) {

                        if ('.' === $file) continue;
                        if ('..' === $file) continue;
                        //exclude these files
                        if ($file === "Thumbs.db") continue;
                        if ($file === ".DS_Store") continue;
                        if ($file === "index.html") continue;

                        $count++;
                        $modDate = date('m-d-Y, H:i:s', filemtime(image_dir . $file));
                        $fileSize = filesize_formatted(image_dir . $file);

                        //Check shared_uploads table for any shared images
                        $sqlSharedUploads = mysqli_query($db_conn, "SELECT  shared, filename, loc_id FROM shared_uploads WHERE filename='".$file."' AND shared <> '' AND loc_id=1");
                        $rowSharedUploads = mysqli_fetch_array($sqlSharedUploads);

                        if ($rowSharedUploads['filename'] == $file) {
                            $isShared = 'btn btn-primary';
                        } else {
                            $isShared = 'btn btn-default';
                        }

                        echo "<tr data-index='" . $count . "'>
                            <td><a href='#' onclick=\"showMyModal('".str_replace('../','',image_dir).$file." : ".$fileSize."', '".image_dir.$file."')\" title='Preview'>" . $file . "</a></td>";
                            if ($adminIsCheck == "true" && multiBranch == 'true') {
                                //TODO: Check DB, compare image filenames with shared filenames, show that the image is shared.
                                echo "<td class='col-xs-1'>
                                <button type='button' data-toggle='tooltip' title='Share' class='".$isShared."' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "&share=" . image_dir . $file . "'\"><i class='fa fa-fw fa-share-alt'></i></button>
                                <span class='hidden'>".$isShared."</span></td>";
                            }
                            echo "<td class='col-xs-1'>" . $fileSize . "</td>
                            <td class='col-xs-2'>" . $modDate . "</td>
                            <td class='col-xs-1'>
                            <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "&delete=".image_dir.$file."'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                            </tr>";
                    }

                    closedir($handle);
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
                <img id="myModalFile" src="" class="img-responsive center-block" />
            </div>
            <div class="modal-footer">&nbsp;</div>
        </div>
    </div>
</div>

<!-- Modal javascript logic -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#confirm').on('hidden.bs.modal', function(){
            setTimeout(function(){
                window.location.href='uploads.php?loc_id=<?php echo $_GET['loc_id']; ?>';
            }, 100);
        });

        var url = window.location.href;
        if (url.indexOf('delete') != -1 && url.indexOf('confirm') == -1){
            setTimeout(function(){
                $('#confirm').modal('show');
            }, 100);
        }
        if (url.indexOf('share') != -1){
            setTimeout(function(){
                $('#confirm').modal('show');
            }, 100);
        }
    });
</script>

<?php
include_once('includes/footer.inc.php');
?>