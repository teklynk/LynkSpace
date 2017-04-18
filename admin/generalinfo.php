<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'generalinfo.php';

$sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, use_defaults, author_name, datetime, loc_id FROM generalinfo WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['generalinfo_heading'])) {

        if ($_POST['generalinfo_defaults'] == 'on') {
            $_POST['generalinfo_defaults'] = 'true';
        } else {
            $_POST['generalinfo_defaults'] = 'false';
        }

        if ($rowGeneralinfo['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $generalinfoUpdate = "UPDATE generalinfo SET heading='" . safeCleanStr($_POST["generalinfo_heading"]) . "', content='" . sqlEscapeStr($_POST['generalinfo_content']) . "', use_defaults='" . safeCleanStr($_POST['generalinfo_defaults']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $generalinfoUpdate);
        } else {
            //Do Insert
            $generalinfoInsert = "INSERT INTO generalinfo (heading, content, use_defaults, author_name, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['generalinfo_heading']) . "', '" . sqlEscapeStr($_POST['generalinfo_content']) . "', 'true', ''" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
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
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">General Information</li>
        </ol>
        <h1 class="page-header">
            General Information
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <?php
        if ($errorMsg !="") {
            echo $errorMsg;
        } else {
            echo $pageMsg;
        }
        //use default view
        if ($rowGeneralinfo['use_defaults'] == 'true') {
            $selDefaults = "CHECKED";
        } else {
            $selDefaults = "";
        }
        ?>
        <form name="generalinfoForm" class="dirtyForm" method="post" action="">

            <?php
            if ($_GET['loc_id'] != 1) {
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="generalinfodefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="generalinfo_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="generalinfo_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <?php
            }
            ?>

            <div class="form-group">
                <label>Heading</label>
                <input class="form-control count-text" name="generalinfo_heading" maxlength="255" value="<?php echo $rowGeneralinfo['heading']; ?>" placeholder="Heading" autofocus required>
            </div>

            <div class="form-group">
                <label>Text / HTML</label>
                <textarea class="form-control tinymce" name="generalinfo_content" rows="20"><?php echo $rowGeneralinfo['content']; ?></textarea>
            </div>

            <div class="form-group">
                <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowGeneralinfo['datetime'])) . " By: " . $rowGeneralinfo['author_name']; ?></small></span>
            </div>

            <button type="submit" name="generalinfo_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>

    </div>
</div>

<?php
include_once('includes/footer.inc.php');
?>
