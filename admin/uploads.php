<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'uploads.php';

//Create location upload folder if it does not exist.
if (is_numeric($_GET['loc_id'])) {
    if (!file_exists($image_dir)) {
        @mkdir($image_dir, 0755);
    }
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    $fileExt = substr(basename($_FILES["fileToUpload"]["name"]), -4);

    //Check if file is a image format
    if ($fileExt == ".png" || $fileExt == ".jpg" || $fileExt == ".gif") {
        //rename file if it contains spaces, parenthesis, apostrophes or other characters and low case the file name
        $search = array('(', ')', ' ', '\'');
        $replace = array('-', '', '-', '');

        rename($target_file, str_replace($search, $replace, strtolower($target_file)));

        $uploadMsg = "<div class='alert alert-success' style='margin-top:12px;'>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    } else {
        //Delete the file if it does meet the fileExt rule
        unlink($target_file);
        $uploadMsg = "<div class='alert alert-danger' style='margin-top:12px;'>The file " . basename($_FILES["fileToUpload"]["name"]) . " is not allowed.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    }

} else {
    $uploadMsg = "";
}

//Delete file
$deleteMsg = "";
if ($_GET["delete"] && !$_GET["confirm"]) {
    $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $_GET["delete"] . "? <a href='uploads.php?loc_id=" . $_GET['loc_id'] . "&delete=" . $_GET["delete"] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
} elseif ($_GET["delete"] && $_GET["confirm"] == 'yes') {
    unlink($_GET["delete"]);
    $deleteMsg = "<div class='alert alert-success'>" . $_GET["delete"] . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dataTable').dataTable({
                "iDisplayLength": 25,
                "order": [[1, "desc"]],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
            });
        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Uploads
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if ($uploadMsg != "") {
                echo $uploadMsg;
            } ?>
            <?php if ($deleteMsg != "") {
                echo $deleteMsg;
            } ?>
            <form role="uploadForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="hidden" name="uploadFile" value="1">
                </div>
                <button type="submit" name="upload_submit" data-toggle="tooltip" class="btn btn-primary" data-original-title=".jpg, .gif, .png" data-placement="right"><i class="fa fa-fw fa-upload"></i> Upload
                    Image
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <hr/>
            <div>
                <table class="table table-bordered table-hover table-striped dataTable" id="dataTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($handle = opendir($image_dir)) {

                        $count = 0;

                        while (false !== ($file = readdir($handle))) {
                            if ('.' === $file) continue;
                            if ('..' === $file) continue;
                            //exclude these files
                            if ($file === "Thumbs.db") continue;
                            if ($file === ".DS_Store") continue;
                            if ($file === "index.html") continue;

                            $count++;
                            $modDate = date('m-d-Y, H:i:s', filemtime($image_dir . $file));

                            echo "<tr data-index='" . $count . "'>
								<td><a href='#' onclick=\"showMyModal('$file', '$image_dir$file')\" title='Preview'>" . $file . "</a></td>
								<td class='col-xs-3'>" . $modDate . "</td>
								<td class='col-xs-1'>
								<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "&delete=$image_dir$file'\"><i class='fa fa-fw fa-trash'></i></button>
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

<?php
//Check if user_level is Admin user and default location
if ($_SESSION['user_level'] == 1 && $multiBranch == 'true' && $_GET['loc_id'] == 1) {
    ?>

    <hr/>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group" id="copyfiles">
                <button data-toggle="tooltip" class="copy_files_to_locs btn btn-primary" id="<?php echo $_GET['loc_id'] ?>" name="copy_files_to_locs" data-original-title="Use Carefully!" data-placement="right">
                    <i class='fa fa-fw fa-copy'></i> Copy Files To ALL Locations
                </button>
                <br/>
                <small class="copy_files_to_locs_msg status_msg"></small>
            </div>
        </div>
    </div>

    <?php
}
?>
    <!-- /.row -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <h4 class="modal-title" id="myModalTitle" style="text-align: left;"></h4>
                </div>
                <div class="modal-body">
                    <img id="myModalFile" src="" class="img-responsive center-block"/>
                </div>
                <div class="modal-footer">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
include_once('includes/footer.inc.php');
?>