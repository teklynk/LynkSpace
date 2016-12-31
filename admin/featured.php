<?php
define('inc_access', TRUE);

include_once ('includes/header.php');

$sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, image, image_align, datetime, loc_id FROM featured WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowFeatured = mysqli_fetch_array($sqlFeatured);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['featured_heading'])) {

        if ($rowFeatured['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $featuredUpdate = "UPDATE featured SET heading='" . safeCleanStr($_POST['featured_heading']) . "', introtext='" . safeCleanStr($_POST['featured_introtext']) . "', content='" . mysqli_real_escape_string($db_conn, trim($_POST['featured_content'])) . "', image='" . $_POST['featured_image'] . "', image_align='" . $_POST['featured_image_align'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $featuredUpdate);
        } else {
            //Do Insert
            $featuredInsert = "INSERT INTO featured (heading, introtext, content, image, image_align, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['featured_heading']) . "', '" . safeCleanStr($_POST['featured_introtext']) . "', '" . trim($_POST['featured_content']) . "', '" . $_POST['featured_image'] . "', '" . $_POST['featured_image_align'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
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
            <h1 class="page-header">
                Feature
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($pageMsg != "") {
                echo $pageMsg;
            }

            if ($rowFeatured['image'] == "") {
                $thumbNail = "http://placehold.it/140x100&text=No Image";
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
            ?>
            <form name="landingForm" method="post" action="">
                <div class="form-group">
                    <label>Heading</label>
                    <input class="form-control input-sm count-text" name="featured_heading" maxlength="255"
                           value="<?php echo $rowFeatured['heading']; ?>" placeholder="Welcome" required>
                </div>
                <div class="form-group">
                    <label>Intro Title</label>
                    <input class="form-control input-sm count-text" name="featured_introtext" maxlength="255"
                           value="<?php echo $rowFeatured['introtext']; ?>" placeholder="John Doe">
                </div>
                <hr/>
                <div class="form-group">
                    <img src="<?php echo $thumbNail; ?>" id="featured_image_preview"
                         style="max-width:140px; height:auto;"/>
                </div>
                <div class="form-group">
                    <label>Use an Existing Image</label>
                    <select class="form-control input-sm" name="featured_image" id="featured_image">
                        <option value="">None</option>
                        <?php
                        if ($handle = opendir($target_dir)) {
                            while (false !== ($file = readdir($handle))) {
                                if ('.' === $file) continue;
                                if ('..' === $file) continue;
                                if ($file === "Thumbs.db") continue;
                                if ($file === ".DS_Store") continue;
                                if ($file === "index.html") continue;
                                if ($file === $rowFeatured['image']) {
                                    $imageCheck = "SELECTED";
                                } else {
                                    $imageCheck = "";
                                }
                                echo "<option value='" . $file . "' $imageCheck>" . $file . "</option>";
                            }
                            closedir($handle);
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Image Alignment</label>
                    <select class="form-control input-sm" name="featured_image_align">
                        <option value="left" <?php echo $selAlignLeft; ?>>Left</option>
                        <option value="right" <?php echo $selAlignRight; ?>>Right</option>
                    </select>
                </div>
                <hr/>
                <div class="form-group">
                    <label>Text / HTML</label>
                    <textarea class="form-control input-sm tinymce" name="featured_content"
                              rows="20"><?php echo $rowFeatured['content']; ?></textarea>
                </div>

                <div class="form-group">
                    <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowFeatured['datetime'])); ?></small></span>
                </div>

                <button type="submit" name="featured_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                    Save Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Cancel</button>
        </div>
        </form>
    </div>
<?php
include_once ('includes/footer.php');
?>