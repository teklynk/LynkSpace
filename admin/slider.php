<?php
define('inc_access', TRUE);
define('datePicker', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'slider.php';

//slide preview
if ($_GET['preview'] > "") {

    $slidePreviewId = $_GET['preview'];

    $sqlSlidePreview = mysqli_query($db_conn, "SELECT id, title, content, link, image, loc_id FROM slider WHERE id=" . $slidePreviewId . " AND loc_id=" . $_SESSION['loc_id'] . " ");
    $rowSlidePreview = mysqli_fetch_array($sqlSlidePreview);

    echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
    echo "<h4>" . $rowSlidePreview['title'] . "</h4>";
    echo "<p><img src='" . $rowSlidePreview['image'] . "' style='max-width:350px; max-height:150px;' /></p><br/>";
    echo "<p>" . $rowSlidePreview['content'] . "</p>";

    if ($rowSlidePreview['link']) {
        echo "<br/><p><b>Link:</b> <a href='" . $rowSlidePreview['link'] . "' target='_blank'>" . $rowSlidePreview['link'] . "</a></p>";
    }
}

//get location type from locations table
$sqlLocations = mysqli_query($db_conn, "SELECT id, type FROM locations WHERE id=" . $_GET['loc_id'] . " ");
$rowLocations = mysqli_fetch_array($sqlLocations);
?>

    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($_GET['newslide'] == 'true') {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
                <li><a href='slider.php?loc=" . $_GET['loc_id'] . "'>Image Slider</a></li>
                <li class='active'>New Slide</li>
                </ol>";
                echo "<h1 class='page-header'>Image Slider (New) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
            } elseif ($_GET['editslide']) {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
                <li><a href='slider.php?loc=" . $_GET['loc_id'] . "'>Image Slider</a></li>
                <li class='active'>Edit Slide</li>
                </ol>";
                echo "<h1 class='page-header'>Image Slider (Edit) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
            } else {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
                <li class='active'>Image Slider</li>
                </ol>";
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

            $slideUpdate = "UPDATE slider SET title='" . safeCleanStr($_POST['slide_title']) . "', content='" . safeCleanStr($_POST['slide_content']) . "', startdate='" . safeCleanStr($_POST['start_date']) . "', enddate='" . safeCleanStr($_POST['end_date']) . "', link='" . safeCleanStr($_POST['slide_link']) . "', image='" . $_POST['slide_image'] . "', loc_type='".safeCleanStr($_POST['location_type'])."', author_name='" . $_SESSION['user_name'] . "' WHERE id='$theslideId' AND loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $slideUpdate);

            $slideMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='slider.php?loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The slide " . safeCleanStr($_POST['slide_title']) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        }

        $sqlSlides = mysqli_query($db_conn, "SELECT id, title, image, content, startdate, enddate, link, loc_type, active, sort, author_name, datetime, loc_id FROM slider WHERE id='$theslideId' AND loc_id=" . $_GET['loc_id'] . " ");
        $rowSlides = mysqli_fetch_array($sqlSlides);

        //Create new slide
    } elseif ($_GET['newslide']) {

        $slideLabel = "New Slide Title";

        //insert data on submit
        if (!empty($_POST['slide_title'])) {
            $slideInsert = "INSERT INTO slider (title, content, link, image, startdate, enddate, loc_type, sort, active, author_name, loc_id) VALUES ('" . safeCleanStr($_POST['slide_title']) . "', '" . safeCleanStr($_POST['slide_content']) . "', '" . safeCleanStr($_POST['slide_link']) . "', '" . $_POST['slide_image'] . "', '" . safeCleanStr($_POST['start_date']) . "', '" . safeCleanStr($_POST['end_date']) . "', '".safeCleanStr($_POST['location_type'])."', 0, 'false', '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $slideInsert);

            header("slider.php?loc_id=" . $_GET['loc_id'] . "");
            echo "<script>window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "';</script>";

        }
    }

    //alert messages
    if ($slideMsg != "") {
        echo $slideMsg;
    }

    if ($rowSlides['image'] == "") {
        $image = "//placehold.it/350x150&text=No Image";
    } else {
        $image = $rowSlides['image'];
    }

    ?>
    <div class="col-lg-8">
        <form name="slideForm" class="dirtyForm" method="post" action="">

            <div class="form-group required">
                <label for="slide_title"><?php echo $slideLabel; ?></label>
                <input class="form-control count-text" name="slide_title" maxlength="255" value="<?php if ($_GET['editslide']) {echo $rowSlides['title'];} ?>" placeholder="Slide Title" autofocus required>
            </div>
            <hr/>
            <div class="form-group">
                <img src="<?php echo $image; ?>" id="slide_image_preview" style="max-width:350px; max-height:150px; background-color: #ccc;"/>
            </div>

            <div class="form-group">
                <label for="slide_image">Use an Existing Image</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="slide_image" id="slide_image" title="Choose an existing image">
                    <option value="" >None</option>
                    <?php
                    getImageDropdownList($_GET['loc_id'], image_dir, $rowSlides['image']);
                    ?>
                </select>
            </div>
            <hr/>

            <div class="form-group">
                <label for="slide_exist_page">Existing Page</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="slide_exist_page" id="slide_exist_page" title="Choose an existing page">
                    <option value="">None</option>
                    <?php
                    echo getPages($_GET['loc_id']);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="slide_link">Link URL</label>
                <input class="form-control count-text" name="slide_link" id="slide_link" maxlength="255" value="<?php if ($_GET['editslide']) {echo $rowSlides['link'];} ?>" >
            </div>

            <?php
            // if is admin then show the table header
            if ($adminIsCheck == "true") {
                echo "<div class='form-group'>";
                echo "<label for='location_type'>Location Group</label>";

                echo "<select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='location_type' title='Set the location group'>";
                echo getLocGroups($rowSlides['loc_type']);
                echo "</select>";
                echo "</div>";
            } else {
                echo "<input type='hidden' name='location_type' value='".$rowLocations['type']."'/>";
            }
            ?>

            <?php
            if ($rowSlides['startdate'] == '0000-00-00'){
                $startDate = "";
            } else {
                $startDate = $rowSlides['startdate'];
            }
            if ($rowSlides['enddate'] == '0000-00-00') {
                $endDate = "";
            } else {
                $endDate = $rowSlides['enddate'];
            }

            ?>

            <!-- date time picker -->
            <div class="col-md-6" style="padding-left:0px;">
                <div class="form-group required">
                    <label for="start_date">Start Date</label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" data-provide="datepicker" name="start_date" id="start_date" value="<?php echo $startDate; ?>" placeholder="YYYY-MM-DD" pattern="<?php echo dateValidationPattern; ?>" required/>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="padding-right:0px;">
                <div class="form-group required">
                    <label for="end_date">End Date</label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" data-provide="datepicker" name="end_date" id="end_date" value="<?php echo $endDate; ?>" placeholder="YYYY-MM-DD" pattern="<?php echo dateValidationPattern; ?>" required/>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <label for="slide_content">Description</label>
                <textarea class="form-control count-text" rows="3" name="slide_content" placeholder="Text" maxlength="255"><?php if ($_GET['editslide']) {echo $rowSlides['content'];} ?></textarea>
            </div>

            <button type="submit" name="slider_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>
    </div>

    <?php
} else {
    $deleteMsg = "";
    $deleteConfirm = "";
    $slideMsg = "";
    $delslideId = $_GET['deleteslide'];
    $delslideTitle = safeCleanStr(addslashes($_GET['deletetitle']));

    //delete slide
    if ($_GET['deleteslide'] && $_GET['deletetitle'] && !$_GET['confirm']) {

        showModalConfirm(
            "confirm",
            "Delete Slide?",
            "Are you sure you want to delete: ".$delslideTitle."?",
            "slider.php?loc_id=".$_GET['loc_id']."&deleteslide=".$delslideId."&deletetitle=".$delslideTitle."&confirm=yes"
        );

    } elseif ($_GET['deleteslide'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes') {
        //delete slide after clicking Yes
        $slideDelete = "DELETE FROM slider WHERE id=".$delslideId." AND loc_id=" . $_GET['loc_id'] . " ";
        mysqli_query($db_conn, $slideDelete);

        $deleteMsg = "<div class='alert alert-success'>" . $delslideTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $deleteMsg;
    }

    //update heading on submit
    if (($_POST['save_main'])) {
        //var_dump($_POST);
        //die();

        if ($_POST['slider_defaults'] == 'on') {
            $_POST['slider_defaults'] = 'true';
        } else {
            $_POST['slider_defaults'] = 'false';
        }

        $setupUpdate = "UPDATE setup SET sliderheading='" . safeCleanStr($_POST['main_heading']) . "', slider_use_defaults='" . safeCleanStr($_POST['slider_defaults']) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
        mysqli_query($db_conn, $setupUpdate);

        for ($i = 0; $i < $_POST['slide_count']; $i++) {

            $slideUpdate = "UPDATE slider SET sort=" . safeCleanStr($_POST['slide_sort'][$i]) . ", startdate='" . safeCleanStr($_POST['slide_startdate'][$i]) . "', enddate='" . safeCleanStr($_POST['slide_enddate'][$i]) . "', loc_type='".safeCleanStr($_POST['location_type'][$i])."' WHERE id=" . $_POST['slide_id'][$i] . " ";
            mysqli_query($db_conn, $slideUpdate);

        }

        $slideMsg = "<div class='alert alert-success'>The slider has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    }

    $sqlSetup = mysqli_query($db_conn, "SELECT sliderheading, slider_use_defaults FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowSetup = mysqli_fetch_array($sqlSetup);

    //Modal preview box
    showModalPreview("webslideDialog");

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
                    <label for="slider_defaults">Use Defaults</label>
                    <div class="checkbox">
                        <label>
                            <input class="slider_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="slider_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
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
    <div>
    <?php
    if ($slideMsg != "") {
        echo $slideMsg;
    }

    echo "<form name='sliderForm' class='dirtyForm' method='post' action=''>
		<div class='form-group required'>
		<label for='main_heading'>Heading</label>
		<input class='form-control count-text' name='main_heading' maxlength='255' value='" . $rowSetup['sliderheading'] . "' placeholder='My Slides' autofocus required>
		</div>
		<table class='table table-bordered table-hover table-striped table-responsive'>
		<thead>
		<tr>
		<th>Sort</th>
		<th>Slide Title</th>";
    // if is admin then show the table header
    if ($adminIsCheck == "true") {
        echo "<th>Location Group</th>";
    }

    echo "<th>Start Date</th>
        <th>End Date</th>
        <th>Active</th>
		<th>Actions</th>
		</tr>
		</thead>
		<tbody>";
    $slideCount = "";
    $sqlslides = mysqli_query($db_conn, "SELECT id, title, image, content, sort, startdate, enddate, loc_type, active, loc_id FROM slider WHERE loc_id=" . $_GET['loc_id'] . " ORDER BY sort, loc_type, title ASC");
    while ($rowSlides = mysqli_fetch_array($sqlslides)) {
        $slideId = $rowSlides['id'];
        $slideTitle = $rowSlides['title'];
        $slideLocType = $rowSlides['loc_type'];
        $slideContent = $rowSlides['content'];
        $slideSort = $rowSlides['sort'];
        $slideStartDate = $rowSlides['startdate'];
        $slideEndDate = $rowSlides['enddate'];
        $slideActive = $rowSlides['active'];
        $slideCount++;

        if ($rowSlides['active'] == 'true') {
            $isActive = "CHECKED";
        } else {
            $isActive = "";
        }

        echo "<tr>
            <td class='col-xs-1'>
            <input class='form-control' name='slide_sort[]' value='" . $slideSort . "' type='text' maxlength='3' required>
            </td>
			<td>
			<input type='hidden' name='slide_id[]' value='" . $slideId . "' >
			<a href='slider.php?loc_id=" . $_GET['loc_id'] . "&editslide=$slideId' title='Edit'>" . $slideTitle . "</a>
			</td>";

        //If admin, show location type drop down list else show a hidden input with the locations type value
        if ($adminIsCheck == "true") {
            echo "<td>";
            echo "<select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='location_type[]'>";
            echo getLocGroups($slideLocType);
            echo "</select>";
            echo "</td>";
        } else {
            echo "<input type='hidden' name='location_type[]' value='".$rowLocations['type']."' >";
        }
        echo "<td class='col-xs-1'>
            <div class='date'>
            <input class='form-control datepicker' data-provide='datepicker' name='slide_startdate[]' value='" . $slideStartDate . "' type='text' maxlength='12' placeholder='YYYY-MM-DD' pattern='".dateValidationPattern."' required>
            </div>
            </td>";
        echo "<td class='col-xs-1'>
            <div class='date'>
            <input class='form-control datepicker' data-provide='datepicker'  name='slide_enddate[]' value='" . $slideEndDate . "' type='text' maxlength='12' placeholder='YYYY-MM-DD' pattern='".dateValidationPattern."' required>
            </div>
            </td>";
        echo "<td class='col-xs-1'>
			<input data-toggle='toggle' title='Slide Active' class='checkbox slider_status_checkbox' id='" . $slideId . "' type='checkbox' " . $isActive . ">
			</td>
			<td class='col-xs-2'>
			<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . safeCleanStr($slideTitle) . "', 'slider.php?loc_id=" . $_GET['loc_id'] . "&preview=$slideId')\"><i class='fa fa-fw fa-eye'></i></button>
			<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='slider.php?loc_id=" . $_GET['loc_id'] . "&deleteslide=$slideId&deletetitle=" . safeCleanStr(addslashes($slideTitle)) . "'\"><i class='fa fa-fw fa-trash'></i></button>
			</td>
			</tr>";
    }

    echo "</tbody>
		</table>
		<input type='hidden' name='slide_count' value='" . $slideCount . "'/>
		<input type='hidden' name='save_main' value='true'/>
		<button type='submit' name='sliderNew_submit' class='btn btn-primary'><i class='fa fa-fw fa-save'></i> Save Changes</button>
		<button type='reset' class='btn btn-default'><i class='fa fa-fw fa-reply'></i> Reset</button>
		</form>
		</div>";

} //end of long else

echo "</div>
	</div>
	<p></p>";

?>
    <!-- Modal javascript logic -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#confirm').on('hidden.bs.modal', function(){
                setTimeout(function(){
                    window.location.href='slider.php?loc_id=<?php echo $_GET['loc_id']; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deleteslide') != -1 && url.indexOf('confirm') == -1){
                setTimeout(function(){
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
include_once('includes/footer.inc.php');
?>