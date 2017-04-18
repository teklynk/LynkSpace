<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'aboutus.php';

$sqlAbout = mysqli_query($db_conn, "SELECT heading, content, image, image_align, author_name, datetime, use_defaults, loc_id FROM aboutus WHERE loc_id=" . $_GET['loc_id'] . " ");
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
            $aboutUpdate = "UPDATE aboutus SET heading='" . safeCleanStr($_POST['about_heading']) . "', content='" . sqlEscapeStr($_POST['about_content']) . "', image='" . $_POST['about_image'] . "', image_align='" . $_POST['about_image_align'] . "', use_defaults='" . safeCleanStr($_POST['aboutus_defaults']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $aboutUpdate);
        } else {
            //Do Insert
            $aboutInsert = "INSERT INTO aboutus (heading, content, image, image_align, use_defaults, author_name, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['about_heading']) . "', '" . sqlEscapeStr($_POST['about_content']) . "', '" . $_POST['about_image'] . "', '" . $_POST['about_image_align'] . "', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
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
        <h1 class="page-header">
            About
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

        if ($rowAbout['image'] == "") {
            $thumbNail = "//placehold.it/140x100&text=No Image";
        } else {
            $thumbNail = "../uploads/" . $_GET['loc_id'] . "/" . $rowAbout['image'];
        }

        //image align status
        if ($rowAbout['image_align'] == "left") {
            $selAlignLeft = "SELECTED";
            $selAlignRight = "";
        } else {
            $selAlignRight = "SELECTED";
            $selAlignLeft = "";
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
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control count-text" name="about_heading" maxlength="255" value="<?php echo $rowAbout['heading']; ?>" placeholder="About Me" autofocus required>
            </div>
            <hr/>
            <div class="form-group">
                <img src="<?php echo $thumbNail; ?>" id="about_image_preview" style="max-width:140px; height:auto;"/>
            </div>
            <div class="form-group">
                <label>Use an Existing Image</label>
                <select class="form-control" name="about_image" id="about_image">
                    <option value="">None</option>
                    <?php
                    getImageDropdownList($image_dir, $rowAbout['image']);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Image Alignment</label>
                <select class="form-control" name="about_image_align">
                    <option value="left" <?php echo $selAlignLeft; ?>>Left</option>
                    <option value="right" <?php echo $selAlignRight; ?>>Right</option>
                </select>
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

<?php
include_once('includes/footer.inc.php');
?>
