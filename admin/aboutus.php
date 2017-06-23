<?php
define('inc_access', TRUE);
define('tinyMCE', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'aboutus.php';

$sqlAbout = mysqli_query($db_conn, "SELECT heading, content, author_name, datetime, use_defaults, loc_id FROM aboutus WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowAbout = mysqli_fetch_array($sqlAbout);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['about_heading'])) {

        if ($_POST['aboutus_defaults'] == 'on') {
            $_POST['aboutus_defaults'] = 'true';
        } else {
            $_POST['aboutus_defaults'] = 'false';
        }

        if ($rowAbout['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $aboutUpdate = "UPDATE aboutus SET heading='" . safeCleanStr($_POST['about_heading']) . "', content='" . sqlEscapeStr($_POST['about_content']) . "', use_defaults='" . safeCleanStr($_POST['aboutus_defaults']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $aboutUpdate);
        } else {
            //Do Insert
            $aboutInsert = "INSERT INTO aboutus (heading, content, use_defaults, author_name, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['about_heading']) . "', '" . sqlEscapeStr($_POST['about_content']) . "', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $aboutInsert);
        }

    }

    header("Location: aboutus.php?loc_id=" . $_GET['loc_id'] . "&update=true");
    echo "<script>window.location.href='aboutus.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
}

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The about us section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='aboutus.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">About</li>
        </ol>
        <div class="col-lg-4">
            <h1 class="page-header">
                About&nbsp;<button type="button" data-toggle="tooltip" data-placement="bottom" title="Preview this Page" class="btn btn-info" onclick="showMyModal('about.php?loc_id=<?php echo $_GET['loc_id']; ?>', '../about.php?loc_id=<?php echo $_GET['loc_id']; ?>')"><i class="fa fa-eye"></i></button>
            </h1>
        </div>

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
        if ($rowAbout['use_defaults'] == 'true') {
            $selDefaults = "CHECKED";
        } else {
            $selDefaults = "";
        }

        ?>

        <form name="aboutForm" class="dirtyForm" method="post" action="">
            <?php
                if ($_GET['loc_id'] != 1) {
            ?>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group" id="aboutusdefaults">
                        <label>Use Defaults</label>
                        <div class="checkbox">
                            <label>
                                <input class="aboutus_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="aboutus_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <?php
                }
            ?>
            <div class="form-group required">
                <label>Heading</label>
                <input type="text" class="form-control count-text" name="about_heading" maxlength="255" value="<?php echo $rowAbout['heading']; ?>" placeholder="About Me" autofocus required>
            </div>
            <hr/>
            <div class="form-group">
                <label>Text / HTML</label>
                <textarea class="form-control tinymce" name="about_content" rows="20"><?php echo $rowAbout['content']; ?></textarea>
            </div>

            <div class="form-group">
                <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowAbout['datetime'])) . " By: ". $rowAbout['author_name'] ?></small></span>
            </div>

            <button type="submit" name="aboutus_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>

    </div>
</div>
<!--modal preview window-->
<style>
    #webpageDialog iframe {
        width: 100%;
        height: 600px;
        border: none;
    }

    .modal-dialog {
        width: 95%;
    }
</style>

<div class="modal fade" id="webpageDialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </a>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <div class="modal-body">
                <iframe id="myModalFile" src="" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">&nbsp;</div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
include_once('includes/footer.inc.php');
?>
