<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'slider.php';

//slide preview
if ($_GET['preview'] > "") {

    $slidePreviewId = $_GET['preview'];

    $sqlSlidePreview = mysqli_query($db_conn, "SELECT id, title, content, link, image, loc_id FROM slider WHERE id=" . $slidePreviewId . " AND loc_id=" . $_SESSION['loc_id'] . " ");
    $rowSlidePreview = mysqli_fetch_array($sqlSlidePreview);

    echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
    echo "<p><img src='../uploads/" . $_SESSION['loc_id'] . "/" . $rowSlidePreview['image'] . "' style='max-width:350px; max-height:150px;' /></p><br/>";
    echo "<p>" . $rowSlidePreview['content'] . "</p>";

    if ($rowSlidePreview['link']) {
        echo "<br/><p><b>Page Link:</b> " . $rowSlidePreview['link'] . "</p>";
    }
}
?>

    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($_GET['newslide'] == 'true') {
                echo "<h1 class='page-header'>Image Slider (New) <button type='reset' class='btn btn-default' onclick='javascript: window.history.go(-1)'><i class='fa fa-fw fa-reply'></i> Cancel</button></h1>";
            } else {
                echo "<h1 class='page-header'>Image Slider</h1>";
            }
            ?>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-12">
<?php

if ($_GET['newslide'] || $_GET['editslide']) {

    $slideMsg = "";

    //Update existing slide
    if ($_GET['editslide']) {
        $theslideId = $_GET['editslide'];
        $slideLabel = "Edit Slide Title";

        //update data on submit
        if (!empty($_POST['slide_title'])) {

            if ($_POST['slider_status'] == 'on') {
                $_POST['slider_status'] = 'true';
            } else {
                $_POST['slider_status'] = 'false';
            }

            $slideUpdate = "UPDATE slider SET title='" . safeCleanStr($_POST['slide_title']) . "', content='" . safeCleanStr($_POST['slide_content']) . "', link='" . safeCleanStr($_POST['slide_link']) . "', image='" . $_POST['slide_image'] . "', loc_type='".safeCleanStr($_POST['location_type'])."', active='" . $_POST['slider_status'] . "', author_name='" . $_SESSION['user_name'] . "' WHERE id='$theslideId' AND loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $slideUpdate);

            $slideMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='slider.php?loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The slide " . safeCleanStr($_POST['slide_title']) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        }

        $sqlSlides = mysqli_query($db_conn, "SELECT id, title, image, content, link, loc_type, active, sort, author_name, datetime, loc_id FROM slider WHERE id='$theslideId' AND loc_id=" . $_GET['loc_id'] . " ");
        $rowSlides = mysqli_fetch_array($sqlSlides);

        //Create new slide
    } elseif ($_GET['newslide']) {

        $slideLabel = "New Slide Title";

        //insert data on submit
        if (!empty($_POST['slide_title'])) {
            $slideInsert = "INSERT INTO slider (title, content, link, image, loc_type, sort, active, author_name, loc_id) VALUES ('" . safeCleanStr($_POST['slide_title']) . "', '" . safeCleanStr($_POST['slide_content']) . "', '" . trim($_POST['slide_link']) . "', '" . $_POST['slide_image'] . "', '".safeCleanStr($_POST['location_type'])."', 0, 'true', '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $slideInsert);

            header("slider.php?loc_id=" . $_GET['loc_id'] . "");
            echo "<script>window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "';</script>";

        }
    }

    //alert messages
    if ($slideMsg != "") {
        echo $slideMsg;
    }

    if ($_GET['editslide']) {
        //active status
        if ($rowSlides['active'] == 'true') {
            $selActive = "CHECKED";
        } else {
            $selActive = "";
        }
    }

    if ($rowSlides['image'] == "") {
        $image = "//placehold.it/350x150&text=No Image";
    } else {
        $image = "../uploads/" . $_GET['loc_id'] . "/" . $rowSlides['image'];
    }

    ?>
    <form name="slideForm" class="dirtyForm" method="post" action="">

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group" id="slideractive">
                    <label>Active</label>
                    <div class="checkbox">
                        <label>
                            <input class="slider_status_checkbox" id="<?php echo $_GET['editslide'] ?>" name="slider_status" type="checkbox" <?php if ($_GET['editslide']) {echo $selActive;} ?> data-toggle="toggle">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <label><?php echo $slideLabel; ?></label>
            <input class="form-control count-text" name="slide_title" maxlength="255" value="<?php if ($_GET['editslide']) {echo $rowSlides['title'];} ?>" placeholder="Slide Title" required>
        </div>
        <hr/>
        <div class="form-group">
            <img src="<?php echo $image; ?>" id="slide_image_preview" style="max-width:350px; max-height:150px;"/>
        </div>

        <div class="form-group">
            <label>Use an Existing Image</label>
            <select class="form-control" name="slide_image" id="slide_image">
                <option value="">None</option>
                <?php
                getImageDropdownList($image_dir);
                ?>
            </select>
        </div>
        <hr/>

        <div class="form-group">
            <label>Link URL</label>
            <input class="form-control count-text" name="slide_link" id="slide_link" maxlength="255" value="<?php if ($_GET['editslide']) {echo $rowSlides['link'];} ?>" >
        </div>

        <div class="form-group">
            <label>Existing Page</label>
            <select class="form-control" name="slide_exist_page" id="slide_exist_page">
                <option value="">None</option>
                <?php
                //Get list of existing pages for the location
                $pagesStr = "";
                $sqlSliderLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active='true' AND loc_id=" . $_GET['loc_id'] . " ORDER BY title ASC ");
                while ($rowSliderLink = mysqli_fetch_array($sqlSliderLink)) {
                    $sliderLinkId = $rowSliderLink['id'];
                    $sliderLinkTitle = $rowSliderLink['title'];

                    $pagesStr .= "<option value='page.php?page_id=" . $sliderLinkId . "&loc_id=".$_GET['loc_id']." '>" . $sliderLinkTitle . "</option>";
                }

                $pagesStr = "<optgroup label='Existing Pages'>" . $pagesStr . "</optgroup>";
                echo $pagesStr;
                ?>
            </select>
        </div>

        <?php
        // if is admin then show the table header
        if ($adminIsCheck == "true") {
            echo "<div class='form-group'>";
            echo "<label>Location Type</label>";
            //loop through the array of location Types
            $locMenuStr = "";
            $locArrlength = count($locTypes);

            for ($x = 0; $x < $locArrlength; $x++) {
                if ($locTypes[$x] == $rowSlides['loc_type']) {
                    $isSectionSelected = "SELECTED";
                } else {
                    $isSectionSelected = "";
                }
                $locMenuStr .= "<option value=" . $locTypes[$x] . " " . $isSectionSelected . ">" . $locTypes[$x] . "</option>";
            }

            echo "<select class='form-control' name='location_type'>";
            echo $locMenuStr;
            echo "</select>";
            echo "</div>";
        } else {
            echo "<input type='hidden' name='location_type' value='".$rowLocations['type']."'/>";
        }
        ?>

        <hr/>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control count-text" rows="3" name="slide_content" placeholder="Text" maxlength="255"><?php if ($_GET['editslide']) {echo $rowSlides['content'];} ?></textarea>
        </div>

        <button type="submit" name="slider_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
        <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Cancel</button>

    </form>

    <?php
} else {
    $deleteMsg = "";
    $deleteConfirm = "";
    $slideMsg = "";
    $delslideId = $_GET['deleteslide'];
    $delslideTitle = $_GET['deletetitle'];

    //delete slide
    if ($_GET['deleteslide'] && $_GET['deletetitle'] && !$_GET['confirm']) {

        $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $delslideTitle . "? <a href='?loc_id=" . $_GET['loc_id'] . "&deleteslide=" . $delslideId . "&deletetitle=" . $delslideTitle . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $deleteMsg;

    } elseif ($_GET['deleteslide'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes') {
        //delete slide after clicking Yes
        $slideDelete = "DELETE FROM slider WHERE id='$delslideId'";
        mysqli_query($db_conn, $slideDelete);

        $deleteMsg = "<div class='alert alert-success'>" . $delslideTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $deleteMsg;
    }

    //update heading on submit
    if (($_POST['save_main'])) {

        if ($_POST['slider_defaults'] == 'on') {
            $_POST['slider_defaults'] = 'true';
        } else {
            $_POST['slider_defaults'] = 'false';
        }

        $setupUpdate = "UPDATE setup SET sliderheading='" . safeCleanStr($_POST['main_heading']) . "', slider_use_defaults='" . safeCleanStr($_POST['slider_defaults']) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
        mysqli_query($db_conn, $setupUpdate);

        for ($i = 0; $i < $_POST['slide_count']; $i++) {

            $slideUpdate = "UPDATE slider SET sort=" . safeCleanStr($_POST['slide_sort'][$i]) . ", loc_type='".safeCleanStr($_POST['location_type'][$i])."' WHERE id=" . $_POST['slide_id'][$i] . " ";
            mysqli_query($db_conn, $slideUpdate);

        }

        $slideMsg = "<div class='alert alert-success'>The slider has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    }

    $sqlSetup = mysqli_query($db_conn, "SELECT sliderheading, slider_use_defaults FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowSetup = mysqli_fetch_array($sqlSetup);

    //get location type from locations table
    $sqlLocations = mysqli_query($db_conn, "SELECT id, type FROM locations WHERE id=" . $_GET['loc_id'] . " ");
    $rowLocations = mysqli_fetch_array($sqlLocations);
    ?>
    <!--modal preview window-->

    <style>
        #webslideDialog iframe {
            width: 100%;
            height: 600px;
            border: none;
        }

        .modal-dialog {
            width: 95%;
        }
    </style>

    <div class="modal fade" id="webslideDialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
                <div class="modal-body">
                    <iframe id="myModalFile" src="" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php
    //use default view
    if ($rowSetup['slider_use_defaults'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }

    if ($_GET['loc_id'] != 1) {
        ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group" id="sliderdefaults">
                    <label>Use Defaults</label>
                    <div class="checkbox">
                        <label>
                            <input class="slider_defaults_checkbox" id="<?php echo $_GET['loc_id'] ?>" name="slider_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
        <?php
    }
    ?>

    <button type="button" class="btn btn-primary" onclick="window.location='?newslide=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-plus'></i> Add a New Slide</button>
    <h2></h2>
    <div class="table-responsive">
    <?php
    if ($slideMsg != "") {
        echo $slideMsg;
    }

    echo "<form name='sliderForm' class='dirtyForm' method='post' action=''>
		<div class='form-group'>
		<label>Heading</label>
		<input class='form-control count-text' name='main_heading' maxlength='255' value='" . $rowSetup['sliderheading'] . "' placeholder='My Slides' required>
		</div>
		<table class='table table-bordered table-hover table-striped'>
		<thead>
		<tr>
		<th>Sort</th>
		<th>Slide Title</th>";
        // if is admin then show the table header
		if ($adminIsCheck == "true") {
            echo "<th>Location Type</th>";
        }
		echo "<th>Active</th>
		<th>Actions</th>
		</tr>
		</thead>
		<tbody>";
    $slideCount = "";
    $sqlslides = mysqli_query($db_conn, "SELECT id, title, image, content, sort, loc_type, active, loc_id FROM slider WHERE loc_id=" . $_GET['loc_id'] . " ORDER BY sort, loc_type, title ASC");
    while ($rowSlides = mysqli_fetch_array($sqlslides)) {
        $slideId = $rowSlides['id'];
        $slideTitle = $rowSlides['title'];
        $slideLocType = $rowSlides['loc_type'];
        $slideContent = $rowSlides['content'];
        $slideSort = $rowSlides['sort'];
        $slideActive = $rowSlides['active'];
        $slideCount++;

        if ($rowSlides['active'] == 'true') {
            $isActive = "CHECKED";
        } else {
            $isActive = "";
        }

        //loop through the array of location Types
        $locMenuStr = "";
        $locArrlength = count($locTypes);
        for ($x = 0; $x < $locArrlength; $x++) {
            if ($locTypes[$x] == $slideLocType) {
                $isSectionSelected = "SELECTED";
            } else {
                $isSectionSelected = "";
            }
            $locMenuStr .= "<option value=" . $locTypes[$x] . " " . $isSectionSelected . ">" . $locTypes[$x] . "</option>";
        }

        echo "<tr>
            <td class='col-xs-1'>
            <input class='form-control' name='slide_sort[]' value='" . $slideSort . "' type='text' maxlength='3'>
            </td>
			<td>
			<input type='hidden' name='slide_id[]' value='" . $slideId . "' >
			<a href='slider.php?loc_id=" . $_GET['loc_id'] . "&editslide=$slideId' title='Edit'>" . $slideTitle . "</a>
			</td>";

        //If admin, show location type drop down list else show a hidden input with the locations type value
        if ($adminIsCheck == "true") {
            echo "<td>";
            echo "<select class='form-control' name='location_type[]'>";
            echo $locMenuStr;
            echo "</select>";
            echo "</td>";
        } else {
            echo "<input type='hidden' name='location_type[]' value='".$rowLocations['type']."' >";
        }
        echo "<td class='col-xs-1'>
			<input data-toggle='toggle' title='Slide Active' class='checkbox slider_status_checkbox' id='" . $slideId . "' type='checkbox' " . $isActive . ">
			</td>
			<td class='col-xs-2'>
			<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . safeCleanStr($slideTitle) . "', 'slider.php?loc_id=" . $_GET['loc_id'] . "&preview=$slideId')\"><i class='fa fa-fw fa-eye'></i></button>
			<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "&deleteslide=$slideId&deletetitle=" . safeCleanStr($slideTitle) . "'\"><i class='fa fa-fw fa-trash'></i></button>
			</td>
			</tr>";
    }

    echo "</tbody>
		</table>
		<input type='hidden' name='slide_count' value='" . $slideCount . "'/>
		<input type='hidden' name='save_main' value='true'/>
		<button type='submit' name='sliderNew_submit' class='btn btn-primary'><i class='fa fa-fw fa-save'></i> Save Changes</button>
		<button type='reset' class='btn btn-default'><i class='fa fa-fw fa-reply'></i> Cancel</button>
		</form>
		</div>";

} //end of long else

echo "</div>
	</div>
	<p></p>";

include_once('includes/footer.inc.php');
?>