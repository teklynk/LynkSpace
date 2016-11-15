<?php
define('inc_access', TRUE);

include 'includes/header.php';

//slide preview
if ($_GET['preview']>"") {

	$slidePreviewId=$_GET['preview'];

	$sqlSlidePreview = mysqli_query($db_conn, "SELECT id, title, content, link, image, loc_id FROM slider WHERE id=".$slidePreviewId." AND loc_id=".$_SESSION['loc_id']." ");
	$rowSlidePreview = mysqli_fetch_array($sqlSlidePreview );

	echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";
	echo "<p><img src=../uploads/".$_SESSION['loc_id']."/".$rowSlidePreview['image']." style='max-width:350px; max-height:150px;' /></p><br/>";
	echo "<p>".$rowSlidePreview['content']."</p>";

	if ($rowSlidePreview['link']>0) {
		echo "<br/><p><i class='fa fa-fw fa-external-link'></i> <a href='../page.php?loc_id=".$_SESSION['loc_id']."&page_id=".$rowSlidePreview['link']."'>Page Link</a></p>";
	}
}
?>

	<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Image Slider
		</h1>
	</div>
	</div>
	<div class="row">
	<div class="col-lg-12">
<?php

	if ($_GET['newslide'] OR $_GET['editslide']) {

		$slideMsg="";

		//Update existing slide
		if ($_GET['editslide']) {
			$theslideId = $_GET['editslide'];
			$slideLabel = "Edit Slide Title";

			//update data on submit
			if (!empty($_POST['slide_title'])) {

				if ($_POST['slider_status']=='on') {
					$_POST['slider_status']='true';
				} else {
					$_POST['slider_status']='false';
				}

				$slideUpdate = "UPDATE slider SET title='".$_POST['slide_title']."', content='".htmlspecialchars($_POST['slide_content'], ENT_QUOTES)."', link='".$_POST['slide_link']."', image='".$_POST['slide_image']."', active='".$_POST['slider_status']."', datetime='".date("Y-m-d H:i:s")."' WHERE id='$theslideId' AND loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $slideUpdate);

				$slideMsg="<div class='alert alert-success'>The slide ".$_POST['slide_title']." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			}

			$sqlSlides = mysqli_query($db_conn, "SELECT id, title, image, content, link, active, datetime, loc_id FROM slider WHERE id='$theslideId' AND loc_id=".$_GET['loc_id']." ");
			$rowSlides = mysqli_fetch_array($sqlSlides);

		//Create new slide
		} else if ($_GET['newslide']) {

			$slideLabel = "New Slide Title";

			//insert data on submit
			if (!empty($_POST['slide_title'])) {
				$slideInsert = "INSERT INTO slider (title, content, link, image, active, loc_id) VALUES ('".$_POST['slide_title']."', '".htmlspecialchars($_POST['slide_content'], ENT_QUOTES)."', '".$_POST['slide_link']."', '".$_POST['slide_image']."', 'true', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $slideInsert);

				echo "<script>window.location.href='slider.php?loc_id=".$_GET['loc_id']."';</script>";

			}
		}

		//alert messages
		if ($slideMsg != "") {
			echo $slideMsg;
		}

		//get and built pages list
		$sqlGetPages = mysqli_query($db_conn, "SELECT id, title, active FROM pages WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY title");
		$pagesStr = "<option value=''>Custom</option>";

		while ($rowGetPages = mysqli_fetch_array($sqlGetPages)) {
			$getPageId=$rowGetPages['id'];
			$getPageTitle=$rowGetPages['title'];
			$pagesStr = $pagesStr . "<option value=".$getPageId.">".$getPageTitle."</option>";
		}

		if ($_GET['editslide']) {
			//active status
			if ($rowSlides['active']=='true') {
				$selActive="CHECKED";
			} else {
				$selActive="";
			}
		}

		if ($rowSlides['image']=="") {
			$image = "http://placehold.it/350x150&text=No Image";
		} else {
			$image = "../uploads/".$_GET['loc_id']."/".$rowSlides['image'];
		}
?>
	<form name="slideForm" method="post" action="">

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group" id="slideractive">
					<label>Active</label>
					<div class="checkbox">
						<label>
							<input class="slider_status_checkbox" id="<?php echo $_GET['editslide']?>" name="slider_status" type="checkbox" <?php if($_GET['editslide']){echo $selActive;}?> data-toggle="toggle">
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label><?php echo $slideLabel; ?></label>
			<input class="form-control input-sm" name="slide_title" maxlength="255" value="<?php if($_GET['editslide']){echo $rowSlides['title'];} ?>" placeholder="Slide Title">
		</div>
		<hr/>
        <div class="form-group">
        	<img src="<?php echo $image;?>" id="slide_image_preview" style="max-width:350px; max-height:150px;"/>
        </div>

		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control input-sm" name="slide_image" id="slide_image">
				<option value="">None</option>
				<?php
					if ($handle = opendir($target_dir)) {

						while (false !== ($file = readdir($handle))) {
							if ('.' === $file) continue;
							if ('..' === $file) continue;
							if ($file==="Thumbs.db") continue;
							if ($file===".DS_Store") continue;
							if ($file==="index.html") continue;

							if ($file===$rowSlides['image']){
								$imageCheck="SELECTED";
							} else {
								$imageCheck="";
							}

							echo "<option value=".$file." $imageCheck>".$file."</option>";
						}

						closedir($handle);
					}
				?>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Choose a link</label>
			<select class="form-control input-sm" name="slide_link" id="slide_link">
				<option value="">None</option>
				<?php
					$pagesStr = "";
					$sqlSliderLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY title ASC ");
					while ($rowSliderLink = mysqli_fetch_array($sqlSliderLink)) {
						$sliderLinkId = $rowSliderLink['id'];
						$sliderLinkTitle = $rowSliderLink['title'];

						if (ctype_digit($rowSlides['link'])){
							if ($sliderLinkId===$rowSlides['link']) {
								$isSelected="SELECTED";
							} else {
								$isSelected="";
							}
						}

						$pagesStr = $pagesStr . "<option value=".$sliderLinkId." ".$isSelected.">".$sliderLinkTitle."</option>";
					}

					$pagesStr = "<optgroup label='Existing Pages'>".$pagesStr."</optgroup>";
					echo $pagesStr;
				?>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control input-sm" rows="3" name="slide_content" placeholder="Text" maxlength="255"><?php if($_GET['editslide']){echo $rowSlides['content'];} ?></textarea>
		</div>
        <div class="form-group">
			<span><?php if($_GET['editslide']){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($rowSlides['datetime']));} ?></span>
		</div>
		<button type="submit" name="slider_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$slideMsg="";
		$delslideId = $_GET['deleteslide'];
		$delslideTitle = $_GET['deletetitle'];
		$moveslideId = $_GET['moveslide'];
		$moveslideTitle = $_GET['movetitle'];

		//delete slide
		if ($_GET['deleteslide'] AND $_GET['deletetitle'] AND !$_GET['confirm']) {

			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delslideTitle."? <a href='?loc_id=".$_GET['loc_id']."&deleteslide=".$delslideId."&deletetitle=".$delslideTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deleteslide'] AND $_GET['deletetitle'] AND $_GET['confirm']=='yes') {
			//delete slide after clicking Yes
			$slideDelete = "DELETE FROM slider WHERE id='$delslideId'";
			mysqli_query($db_conn, $slideDelete);

			$deleteMsg="<div class='alert alert-success'>".$delslideTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

		//move slide to top of list
		if (($_GET['moveslide'] AND $_GET['movetitle'])) {
			$slidesDateUpdate = "UPDATE slider SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$moveslideId'";
			mysqli_query($db_conn, $slidesDateUpdate);

			$slideMsg="<div class='alert alert-success'>".$moveslideTitle." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
		}

		//update heading on submit
		if (!empty($_POST['main_heading'])) {
			$setupUpdate = "UPDATE setup SET sliderheading='".$_POST['main_heading']."' WHERE loc_id=".$_GET['loc_id']." ";
			mysqli_query($db_conn, $setupUpdate);

			$slideMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='slider.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
		}

	$sqlSetup = mysqli_query($db_conn, "SELECT sliderheading FROM setup WHERE loc_id=".$_GET['loc_id']." ");
	$rowSetup  = mysqli_fetch_array($sqlSetup);
?>
<!--modal preview window-->

<style>
#webslideDialog iframe {
	width: 100%;
	height: 600px;
	frameborder: 0;
	border: none;
}
.modal-dialog {
	width:95%;
}
</style>


 <div class="modal fade" id="webslideDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalTitle"></h4>
      </div>
      <div class="modal-body">
			<iframe id="myModalFile" src="" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<button type="button" class="btn btn-default" onclick="window.location='?newslide=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Slide</button>
		<h2></h2>
		<div class="table-responsive">
    <?php
		if ($slideMsg != "") {
			echo $slideMsg;
		}

		echo "<form name='sliderForm' method='post' action=''>
		<div class='form-group'>
		<label>Heading</label>
		<input class='form-control input-sm' name='main_heading' maxlength='255' value='".$rowSetup['sliderheading']."' placeholder='My Slides'>
		</div>
		<table class='table table-bordered table-hover table-striped'>
		<thead>
		<tr>
		<th>Slide Title</th>
		<th>Active</th>
		<th>Actions</th>
		</tr>
		</thead>
		<tbody>";

		$sqlslides = mysqli_query($db_conn, "SELECT id, title, image, content, active, loc_id FROM slider WHERE loc_id=".$_GET['loc_id']." ORDER BY datetime DESC");
		while ($rowSlides = mysqli_fetch_array($sqlslides)) {
			$slideId=$rowSlides['id'];
			$slideTitle=$rowSlides['title'];
			$slideTumbnail=$rowSlides['image'];
			$slideContent=$rowSlides['content'];
			$slideActive=$rowSlides['active'];

			if ($rowSlides['active']=='true') {
				$isActive="CHECKED";
			} else {
				$isActive="";
			}

			echo "<tr>
			<td><a href='?loc_id=".$_GET['loc_id']."&editslide=$slideId' title='Edit'>".$slideTitle."</a></td>
			<td class='col-xs-1'>
			<input data-toggle='toggle' title='Slide Active' class='checkbox slider_status_checkbox' id='$slideId' type='checkbox' ".$isActive.">
			</td>
			<td class='col-xs-2'>
			<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$slideTitle', '?preview=$slideId')\"><i class='fa fa-fw fa-image'></i></button>
			<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='?loc_id=".$_GET['loc_id']."&moveslide=$slideId&movetitle=$slideTitle'\"><i class='fa fa-fw fa-arrow-up'></i></button>
			<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?loc_id=".$_GET['loc_id']."&deleteslide=$slideId&deletetitle=$slideTitle'\"><i class='fa fa-fw fa-trash'></i></button>
			</td>
			</tr>";
		}

		echo "</tbody>
		</table>
		<button type='submit' name='sliderNew_submit' class='btn btn-default'><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type='reset' class='btn btn-default'><i class='fa fa-fw fa-refresh'></i> Reset</button>
		</form>
		</div>";

	} //end of long else

	echo "</div>
	</div>
	<p></p>";

	include 'includes/footer.php';
?>