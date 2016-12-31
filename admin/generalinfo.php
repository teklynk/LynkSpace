<?php
define('inc_access', TRUE);

include_once('includes/header.php');

$sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, datetime, loc_id FROM generalinfo WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['generalinfo_heading'])) {

        if ($rowGeneralinfo['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $generalinfoUpdate = "UPDATE generalinfo SET heading='" . safeCleanStr($_POST["generalinfo_heading"]) . "', content='" . mysqli_real_escape_string($db_conn, trim($_POST['generalinfo_content'])) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $generalinfoUpdate);
        } else {
            //Do Insert
            $generalinfoInsert = "INSERT INTO generalinfo (heading, content, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['generalinfo_heading']) . "', '" . mysqli_real_escape_string($db_conn, trim($_POST['generalinfo_content'])) . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $generalinfoInsert);
        }

    }

    echo "<script>window.location.href='generalinfo.php?loc_id=" . $_GET['loc_id'] . "&update=true ';</script>";
}

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The general info section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='generalinfo.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            General Information
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php
        if ($pageMsg != "") {
            echo $pageMsg;
        }
        ?>
        <form name="generalinfoForm" method="post" action="">

            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm count-text" name="generalinfo_heading" maxlength="255"
                       value="<?php echo $rowGeneralinfo['heading']; ?>" placeholder="Heading" required>
            </div>

            <div class="form-group">
                <label>Text / HTML</label>
                <textarea class="form-control input-sm tinymce" name="generalinfo_content"
                          rows="20"><?php echo $rowGeneralinfo['content']; ?></textarea>
            </div>

            <div class="form-group">
                <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowGeneralinfo['datetime'])); ?></small></span>
            </div>

            <button type="submit" name="generalinfo_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                Save Changes
            </button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Cancel</button>

        </form>

    </div>
</div>

<?php
include_once('includes/footer.php');
?>
