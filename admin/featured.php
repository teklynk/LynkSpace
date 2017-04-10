<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'featured.php';

$sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, image, image_align, use_defaults, author_name, datetime, loc_id FROM featured WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowFeatured = mysqli_fetch_array($sqlFeatured);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['featured_heading'])) {

        if ($_POST['featured_defaults'] == 'on') {
            $_POST['featured_defaults'] = 'true';
        } else {
            $_POST['featured_defaults'] = 'false';
        }

        if ($rowFeatured['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $featuredUpdate = "UPDATE featured SET heading='" . safeCleanStr($_POST['featured_heading']) . "', introtext='" . safeCleanStr($_POST['featured_introtext']) . "', content='" . sqlEscapeStr($_POST['featured_content']) . "', image='" . $_POST['featured_image'] . "', image_align='" . $_POST['featured_image_align'] . "', use_defaults='" . safeCleanStr($_POST['featured_defaults']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $featuredUpdate);
        } else {
            //Do Insert
            $featuredInsert = "INSERT INTO featured (heading, introtext, content, image, image_align, use_defaults, author_name, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['featured_heading']) . "', '" . safeCleanStr($_POST['featured_introtext']) . "', '" . trim($_POST['featured_content']) . "', '" . $_POST['featured_image'] . "', '" . $_POST['featured_image_align'] . "',  'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $featuredInsert);
        }

    }

    echo "<script>window.location.href='featured.php?loc_id=" . $_GET['loc_id'] . "&update=true ';</script>";
}

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The featured section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='featured.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li class="active">Feature</li>
            </ol>
            <h1 class="page-header">
                Feature
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <?php
            if ($pageMsg != "") {
                echo $pageMsg;
            }

            if ($rowFeatured['image'] == "") {
                $thumbNail = "//placehold.it/140x100&text=No Image";
            } else {
                $thumbNail = "../uploads/" . $_GET['loc_id'] . "/" . $rowFeatured['image'];
            }

            //image align status
            if ($rowFeatured['image_align'] == "left") {
                $selAlignLeft = "SELECTED";
                $selAlignRight = "";
            } else {
                $selAlignRight = "SELECTED";
                $selAlignLeft = "";
            }
            //use default view
            if ($rowFeatured['use_defaults'] == 'true') {
                $selDefaults = "CHECKED";
            } else {
                $selDefaults = "";
            }
            ?>
            <form name="landingForm" class="dirtyForm" method="post" action="">
                <?php
                if ($_GET['loc_id'] != 1) {
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="featureddefaults">
                                <label>Use Defaults</label>
                                <div class="checkbox">
                                    <label>
                                        <input class="featured_defaults_checkbox" id="<?php echo $_GET['loc_id'] ?>" name="featured_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
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
                    <input class="form-control count-text" name="featured_heading" maxlength="255" value="<?php echo $rowFeatured['heading']; ?>" placeholder="Welcome" autofocus required>
                </div>
                <div class="form-group">
                    <label>Intro Title</label>
                    <input class="form-control count-text" name="featured_introtext" maxlength="255" value="<?php echo $rowFeatured['introtext']; ?>" placeholder="John Doe">
                </div>
                <hr/>
                <div class="form-group">
                    <img src="<?php echo $thumbNail; ?>" id="featured_image_preview" style="max-width:140px; height:auto;"/>
                </div>
                <div class="form-group">
                    <label>Use an Existing Image</label>
                    <select class="form-control" name="featured_image" id="featured_image">
                        <option value="">None</option>
                        <?php
                        getImageDropdownList($image_dir, $rowFeatured['image']);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Image Alignment</label>
                    <select class="form-control" name="featured_image_align">
                        <option value="left" <?php echo $selAlignLeft; ?>>Left</option>
                        <option value="right" <?php echo $selAlignRight; ?>>Right</option>
                    </select>
                </div>
                <hr/>
                <div class="form-group">
                    <label>Text / HTML</label>
                    <textarea class="form-control tinymce" name="featured_content" rows="20"><?php echo $rowFeatured['content']; ?></textarea>
                </div>

                <div class="form-group">
                    <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowFeatured['datetime'])) . " By: " . $rowFeatured['author_name']; ?></small></span>
                </div>

                <button type="submit" name="featured_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
        </div>
        </form>
    </div>
<?php
include_once('includes/footer.inc.php');
?>