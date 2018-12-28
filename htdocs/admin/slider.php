<?php
define('ALLOW_INC', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'slider.php';

$pagePreviewId = isset($_GET['preview']) ? $_GET['preview'] : NULL;
$slide_count = isset($_POST['slide_count']) ? $_POST['slide_count'] : NULL;
$delslideToken = isset($_GET['token']) ? $_GET['token'] : NULL;
$delslideTitle = isset($_GET['deletetitle']) ? $_GET['deletetitle'] : NULL;
$theslideGuid = isset($_GET['guid']) ? $_GET['guid'] : NULL;
$delslideId = isset($_GET['deleteslide']) ? $_GET['deleteslide'] : NULL;
$newSlide = isset($_GET['newslide']) ? $_GET['newslide'] : NULL;
$editSlide = isset($_GET['editslide']) ? $_GET['editslide'] : NULL;

//slide preview
if ($pagePreviewId > "") {

    $sqlSlidePreview = mysqli_query($db_conn, "SELECT id, title, content, link, image, loc_id FROM slider WHERE id=" . $pagePreviewId . " AND loc_id=" . $_SESSION['loc_id'] . ";");
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
$sqlLocations = mysqli_query($db_conn, "SELECT id, type FROM locations WHERE id=" . loc_id . ";");
$rowLocations = mysqli_fetch_array($sqlLocations, MYSQLI_ASSOC);
?>

    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($newSlide == 'true') {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
                <li><a href='slider.php?loc_id=" . loc_id . "'>Image Slider</a></li>
                <li class='active'>New Slide</li>
                </ol>";
                echo "<h1 class='page-header'>Image Slider (New) <a href='slider.php' class='btn btn-link' role='button'> Cancel</a></h1>";
            } elseif ($editSlide) {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
                <li><a href='slider.php?loc_id=" . loc_id . "'>Image Slider</a></li>
                <li class='active'>Edit Slide</li>
                </ol>";
                echo "<h1 class='page-header'>Image Slider (Edit) <a href='slider.php' class='btn btn-link'> Cancel</a></h1>";
            } else {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
                <li class='active'>Image Slider</li>
                </ol>";
                echo "<h1 class='page-header'>Image Slider</h1>";
            }
            ?>
        </div>
    </div>

    <?php echo flashMessageGet( 'success' ); ?>

    <div class="row">
    <div class="col-lg-12">
<?php

if ($newSlide == 'true' || $editSlide) {

    $theslideId = $editSlide;
    $slideLabel = "Edit Slide Title";
    $slide_title = safeCleanStr(addslashes($_POST['slide_title']));
    $slide_content = safeCleanStr($_POST['slide_content']);
    $start_date = dateTimeFormat(1, $_POST['start_date']);
    $end_date = dateTimeFormat(1, $_POST['end_date']);
    $slide_link = safeCleanStr($_POST['slide_link']);
    $slide_image = safeCleanStr($_POST['slide_image']);
    $location_type = safeCleanStr($_POST['location_type']);

    //Update existing slide
    if ($editSlide) {

        //update data on submit
        if (!empty($_POST)) {

            $slideUpdate = "UPDATE slider SET title='" . $slide_title . "', content='" . $slide_content . "', startdate='" . $start_date . "', enddate='" . $end_date . "', link='" . $slide_link . "', image='" . $slide_image . "', loc_type='" . $location_type . "', author_name='" . $_SESSION['user_name'] . "' WHERE id=" . $theslideId . " AND guid='" . $theslideGuid . "' AND loc_id=" . loc_id . ";";
            mysqli_query($db_conn, $slideUpdate);

	        flashMessageSet( 'success', $slide_title . " has been updated." );

	        //Redirect back to uploads page
	        header( "Location: slider.php?loc_id=" . loc_id . "", true, 302 );
	        echo "<script>window.location.href='slider.php?loc_id=" . loc_id . "';</script>";
	        exit();

        }

        $sqlSlides = mysqli_query($db_conn, "SELECT id, title, image, content, guid, startdate, enddate, link, loc_type, active, sort, author_name, datetime, loc_id FROM slider WHERE id=" . $theslideId . " AND guid='" . $theslideGuid . "' AND loc_id=" . loc_id . ";");
        $rowSlides = mysqli_fetch_array($sqlSlides, MYSQLI_ASSOC);

        //Create new slide
    } elseif ($newSlide == 'true') {

        $slideLabel = "New Slide Title";

        //insert data on submit
        if (!empty($_POST)) {
            $slideInsert = "INSERT INTO slider (title, content, guid, link, image, startdate, enddate, loc_type, sort, active, author_name, loc_id) VALUES ('" . $slide_title . "', '" . $slide_content . "', '" . getGuid() . "', '" . $slide_link . "', '" . $slide_image . "', '" . $start_date . "', '" . $end_date . "', '" . $location_type . "', 0, 'false', '" . $_SESSION['user_name'] . "', " . loc_id . ");";
            mysqli_query($db_conn, $slideInsert);

	        flashMessageSet( 'success', $slide_title . " has been added." );

	        //Redirect back to uploads page
	        header( "Location: slider.php?loc_id=" . loc_id . "", true, 302 );
	        echo "<script>window.location.href='slider.php?loc_id=" . loc_id . "';</script>";
	        exit();
        }
    }

    if ($rowSlides['image'] == "") {
        $image = "//placehold.it/350x150&text=No Image";
    } else {
        $image = $rowSlides['image'];
    }

    ?>

    <div class="col-lg-8">
        <form name="slideForm" class="dirtyForm" method="post">

            <div class="form-group required">
                <label for="slide_title"><?php echo $slideLabel; ?></label>
                <input class="form-control count-text" name="slide_title" maxlength="255"
                       value="<?php if ($editSlide) {
                           echo $rowSlides['title'];
                       } ?>" placeholder="Slide Title" autofocus required>
            </div>
            <hr/>
            <div class="form-group">
                <img src="<?php echo $image; ?>" id="slide_image_preview"
                     style="max-width:350px; max-height:150px; background-color: #ccc;"/>
            </div>

            <div class="form-group">
                <label for="slide_image">Use an Existing Image</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="slide_image" id="slide_image" title="Choose an existing image">
                    <option value="">None</option>
                    <?php
                    echo getImageDropdownList(loc_id, $rowSlides['image']);
                    ?>
                </select>
            </div>
            <hr/>

            <div class="form-group">
                <label for="slide_exist_page">Existing Page</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="slide_exist_page" id="slide_exist_page" title="Choose an existing page">
                    <option value="">None</option>
                    <?php
                    echo getPages(loc_id);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="slide_link">Link URL</label>
                <input class="form-control count-text" name="slide_link" id="slide_link" maxlength="255"
                       value="<?php if ($editSlide) {
                           echo $rowSlides['link'];
                       } ?>">
            </div>

            <?php
            // if is admin then show the table header
            if ($adminIsCheck == 'true') {
                echo "<div class='form-group'>";
                echo "<label for='location_type'>Location Group</label>";

                echo "<select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='location_type' title='Set the location group'>";
                echo getLocGroups($rowSlides['loc_type']);
                echo "</select>";
                echo "</div>";
            } else {
                echo "<input type='hidden' name='location_type' value='" . $rowLocations['type'] . "'/>";
            }
            ?>

            <?php
            if ($rowSlides['startdate'] == '0000-00-00' || $rowSlides['startdate'] == '') {
                $startDate = "";
            } else {
                $startDate = dateTimeFormat(1, $rowSlides['startdate']);
            }
            if ($rowSlides['enddate'] == '0000-00-00' || $rowSlides['enddate'] == '') {
                $endDate = "";
            } else {
                $endDate = dateTimeFormat(1, $rowSlides['enddate']);
            }

            ?>

            <!-- date time picker -->
            <div class="col-md-6" style="padding-left:0px;">
                <div class="form-group required">
                    <label for="start_date">Start Date</label>
                    <div class="input-group date">
                        <input type="date" class="form-control" name="start_date" id="start_date"
                               value="<?php echo $startDate; ?>" placeholder="mm/dd/yyyy"
                               pattern="<?php echo dateValidationPattern; ?>" required/>
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
                        <input type="date" class="form-control" name="end_date" id="end_date"
                               value="<?php echo $endDate; ?>" placeholder="mm/dd/yyyy"
                               pattern="<?php echo dateValidationPattern; ?>" required/>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <label for="slide_content">Description</label>
                <textarea class="form-control count-text" rows="3" name="slide_content" placeholder="Text"
                          maxlength="255"><?php if ($editSlide) {
                        echo $rowSlides['content'];
                    } ?></textarea>
            </div>

            <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

            <button type="submit" name="slider_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save
                Changes
            </button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>
    </div>

    <?php
} else {


    //delete slide
    if ($delslideId && $delslideTitle && !$_GET['confirm']) {

        showModalConfirm(
            "confirm",
            "Delete Slide?",
            "Are you sure you want to delete: " . $delslideTitle . "?",
            "slider.php?loc_id=" . loc_id . "&deleteslide=" . $delslideId . "&guid=" . $theslideGuid . "&deletetitle=" . $delslideTitle . "&confirm=yes&token=" . $_SESSION['unique_referrer'] . ""
        );

    } elseif ($delslideId && $_GET['deletetitle'] && $_GET['confirm'] == 'yes' && $theslideGuid && $delslideToken == $_SESSION['unique_referrer']) {
        //delete slide after clicking Yes
        $slideDelete = "DELETE FROM slider WHERE id=" . $delslideId . " AND guid='" . $theslideGuid . "' AND loc_id=" . loc_id . ";";
        mysqli_query($db_conn, $slideDelete);

	    flashMessageSet( 'success', $delslideTitle . " has been deleted." );

	    //Redirect back to uploads page
	    header( "Location: slider.php?loc_id=" . loc_id . "", true, 302 );
	    echo "<script>window.location.href='slider.php?loc_id=" . loc_id . "';</script>";
	    exit();
    }

    //update heading on submit
    if (isset($_POST['save_main'])) {

        $slider_defaults = safeCleanStr($_POST['slider_defaults']);
        $main_heading = safeCleanStr($_POST['main_heading']);

        if ($slider_defaults == 'on') {
            $slider_defaults = 'true';
        } else {
            $slider_defaults = 'false';
        }

        $setupUpdate = "UPDATE setup SET sliderheading='" . $main_heading . "', slider_use_defaults='" . $slider_defaults . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . loc_id . ";";
        mysqli_query($db_conn, $setupUpdate);

        for ($i = 0; $i < $slide_count; $i++) {

            $slide_sort = safeCleanStr($_POST['slide_sort'][$i]);
            $slide_startdate = dateTimeFormat(1, $_POST['slide_startdate'][$i]);
            $slide_enddate = dateTimeFormat(1, $_POST['slide_enddate'][$i]);
            $location_type = safeCleanStr($_POST['location_type'][$i]);
            $slide_id = safeCleanStr($_POST['slide_id'][$i]);

            $slideUpdate = "UPDATE slider SET sort=" . $slide_sort . ", startdate='" . $slide_startdate . "', enddate='" . $slide_enddate . "', loc_type='" . $location_type . "' WHERE id=" . $slide_id . ";";
            mysqli_query($db_conn, $slideUpdate);

        }

	    flashMessageSet( 'success', 'The slider has been updated.' );

	    //Redirect back to uploads page
	    header( "Location: slider.php?loc_id=" . loc_id . "", true, 302 );
	    echo "<script>window.location.href='slider.php?loc_id=" . loc_id . "';</script>";
	    exit();

    }

    $sqlSetup = mysqli_query($db_conn, "SELECT sliderheading, slider_use_defaults FROM setup WHERE loc_id=" . loc_id . ";");
    $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

    //Modal preview box
    showModalPreview("webslideDialog");

    //use default view
    if ($rowSetup['slider_use_defaults'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }

    if (loc_id != 1) {
        ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group" id="sliderdefaults">
                    <label for="slider_defaults">Use Defaults</label>
                    <div class="checkbox">
                        <label>
                            <input class="slider_defaults_checkbox defaults-toggle" id="<?php echo loc_id ?>"
                                   name="slider_defaults" type="checkbox" <?php if (loc_id) {
                                echo $selDefaults;
                            } ?> data-toggle="toggle">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
        <?php
    }
    ?>

    <button type="button" class="btn btn-primary"
            onclick="window.location='?newslide=true&loc_id=<?php echo loc_id; ?>';"><i
            class='fa fa-fw fa-plus'></i> Add a New Slide
    </button>
    <h2></h2>
    <div>
    <?php
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
    if ($adminIsCheck == 'true') {
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
    $sqlslides = mysqli_query($db_conn, "SELECT id, title, image, content, guid, sort, startdate, enddate, loc_type, active, loc_id FROM slider WHERE loc_id=" . loc_id . " ORDER BY sort, loc_type, title ASC;");
    while ($rowSlides = mysqli_fetch_array($sqlslides, MYSQLI_ASSOC)) {
        $slideId = safeCleanStr($rowSlides['id']);
        $slideGuid = safeCleanStr($rowSlides['guid']);
        $slideTitle = safeCleanStr(addslashes($rowSlides['title']));
        $slideLocType = safeCleanStr($rowSlides['loc_type']);
        $slideContent = sqlEscapeStr($rowSlides['content']);
        $slideSort = safeCleanStr($rowSlides['sort']);
        $slideStartDate = dateTimeFormat(1, $rowSlides['startdate']);
        $slideEndDate = dateTimeFormat(1, $rowSlides['enddate']);
        $slideActive = safeCleanStr($rowSlides['active']);
        $slideCount++;

        if ($rowSlides['active'] == 'true') {
            $isActive = "CHECKED";
        } else {
            $isActive = "";
        }

        echo "<tr>
            <td class='col-xs-1'>
            <input class='form-control' name='slide_sort[]' value='" . $slideSort . "' type='number' maxlength='3' required>
            </td>
			<td>
			<input type='hidden' name='slide_id[]' value='" . $slideId . "' >
			<a href='slider.php?loc_id=" . loc_id . "&editslide=" . $slideId . "&guid=" . $slideGuid . "' title='Edit'>" . $slideTitle . "</a>
			</td>";

        //If admin, show location type drop down list else show a hidden input with the locations type value
        if ($adminIsCheck == 'true') {
            echo "<td>";
            echo "<select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='location_type[]'>";
            echo getLocGroups($slideLocType);
            echo "</select>";
            echo "</td>";
        } else {
            echo "<input type='hidden' name='location_type[]' value='" . $rowLocations['type'] . "' >";
        }
        echo "<td class='col-xs-1'>
            <div class='date'>
            <input class='form-control' name='slide_startdate[]' value='" . $slideStartDate . "' type='date' maxlength='10' placeholder='mm/dd/yyyy' pattern='" . dateValidationPattern . "' required>
            </div>
            </td>";
        echo "<td class='col-xs-1'>
            <div class='date'>
            <input class='form-control' name='slide_enddate[]' value='" . $slideEndDate . "' type='date' maxlength='10' placeholder='mm/dd/yyyy' pattern='" . dateValidationPattern . "' required>
            </div>
            </td>";
        echo "<td class='col-xs-1'>
			<input data-toggle='toggle' title='Slide Active' class='checkbox slider_status_checkbox' id='" . $slideId . "' type='checkbox' " . $isActive . ">
			</td>
			<td class='col-xs-2'>
			<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . $slideTitle . "', 'slider.php?loc_id=" . loc_id . "&preview=".$slideId."')\"><i class='fa fa-fw fa-eye'></i></button>
			<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='slider.php?loc_id=" . loc_id . "&deleteslide=".$slideId."&guid=".$slideGuid."&deletetitle=" . $slideTitle . "'\"><i class='fa fa-fw fa-trash'></i></button>
			</td>
			</tr>";
    }

    echo "</tbody>
		</table>";
    ?>

    <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

    <?php
    echo "<input type='hidden' name='slide_count' value='" . $slideCount . "'/>
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
        $(document).ready(function () {
            $('#confirm').on('hidden.bs.modal', function () {
                setTimeout(function () {
                    window.location.href = 'slider.php?loc_id=<?php echo loc_id; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deleteslide') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>