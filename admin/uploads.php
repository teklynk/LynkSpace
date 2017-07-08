<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'uploads.php';

//Upload Action - Do the upload
if (isset($_POST["uploadFile"])){
    uploadFile($_POST["uploadFile"], image_dir);
}

//Delete file
$deleteMsg = "";

if ($_GET["delete"] && !$_GET["confirm"]) {

    showModalConfirm(
        "confirm",
        "Delete Image?",
        "Are you sure you want to delete: ".$_GET["delete"]."?",
        "uploads.php?loc_id=".$_GET['loc_id']."&delete=".$_GET["delete"]."&confirm=yes"
    );

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
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-responsive dataTable" id="dataTable">
                    <thead>
                    <tr>
                        <th>Name</th>
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

                            echo "<tr data-index='" . $count . "'>
								<td><a href='#' onclick=\"showMyModal('".str_replace('../','',image_dir).$file."', '".image_dir.$file."')\" title='Preview'>" . strtolower($file) . "</a></td>
								<td class='col-xs-3'>" . $modDate . "</td>
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

<?php
//Check if user_level is Admin user and default location
if ($_SESSION['user_level'] == 1 && multiBranch == 'true' && $_GET['loc_id'] == 1) {
    ?>

    <hr/>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group" id="copyfiles">
                <button type="button" class="copy_files_to_locs btn btn-primary" id="<?php echo $_GET['loc_id'] ?>" name="copy_files_to_locs" data-toggle="tooltip" data-original-title="Use Carefully!" data-placement="right">
                    <i class='fa fa-fw fa-cog'></i> Copy Files To ALL Locations
                </button>
                <br/>
                <small class="copy_files_to_locs_msg">
                    <?php
                    if (!is_writable('../uploads')) {
                        echo "Unable to write to the uploads folder. Check folder permissions.";
                    }
                    ?>
                </small>
            </div>
        </div>
    </div>

    <?php
}
?>

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
    });
</script>
<?php
include_once('includes/footer.inc.php');
?>