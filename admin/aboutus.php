<?php
define('inc_access', TRUE);

include 'includes/header.php';

	$sqlAbout = mysqli_query($db_conn, "SELECT heading, content, image, image_align, loc_id FROM aboutus WHERE loc_id=".$_GET['loc_id']." ");
	$rowAbout = mysqli_fetch_array($sqlAbout);

	//update table on submit
	if (!empty($_POST)) {
		if (!empty($_POST['about_heading'])) {

			if ($rowAbout['loc_id'] == $_GET['loc_id']) {
				//Do Update
				$aboutUpdate = "UPDATE aboutus SET heading='".$_POST['about_heading']."', content='".$_POST['about_content']."', image='".$_POST['about_image']."', image_align='".$_POST['about_image_align']."' WHERE loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $aboutUpdate);
			} else {
				//Do Insert
				$aboutInsert = "INSERT INTO aboutus (heading, content, image, image_align, loc_id) VALUES ('".$_POST['about_heading']."', '".$_POST['about_content']."', '".$_POST['about_image']."', '".$_POST['about_image_align']."', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $aboutInsert);
			}

		}

		echo "<script>window.location.href='aboutus.php?loc_id=".$_GET['loc_id']."&update=true';</script>";
	}

	if ($_GET['update']=='true') {
		$pageMsg = "<div class='alert alert-success'>The about us section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='aboutus.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
	}
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				About Us
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<?php

			if ($pageMsg != "") {
				echo $pageMsg;
			}

			if ($rowAbout['image'] == "") {
				$thumbNail = "http://placehold.it/140x100&text=No Image";
			} else {
				$thumbNail = "../uploads/".$_GET['loc_id']."/".$rowAbout['image'];
			}

			//image align status
			if ($rowAbout['image_align']=="left") {
				$selAlignLeft="SELECTED";
				$selAlignRight="";
			} else {
				$selAlignRight="SELECTED";
				$selAlignLeft="";
			}

			?>
			<form name="aboutForm" method="post" action="">

				<div class="form-group">
					<label>Heading</label>
					<input class="form-control input-sm" name="about_heading" value="<?php echo $rowAbout['heading']; ?>" placeholder="About Me">
				</div>
				<hr/>
			    <div class="form-group">
		        	<img src="<?php echo $thumbNail;?>" id="about_image_preview" style="max-width:140px; height:auto;"/>
		        </div>
			    <div class="form-group">
		            <label>Use an Existing Image</label>
		            <select class="form-control input-sm" name="about_image" id="about_image">
		                <option value="">None</option>
		                <?php
		                    if ($handle = opendir($target_dir)) {
		                        while (false !== ($file = readdir($handle))) {
		                            if ('.' === $file) continue;
		                            if ('..' === $file) continue;
		                            if ($file==="Thumbs.db") continue;
		                            if ($file===".DS_Store") continue;
		                            if ($file==="index.html") continue;

		                            if ($file===$rowAbout['image']){
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
				<div class="form-group">
					<label>Image Alignment</label>
					<select class="form-control input-sm" name="about_image_align">
						<option value="left" <?php echo $selAlignLeft; ?>>Left</option>
						<option value="right" <?php echo $selAlignRight; ?>>Right</option>
					</select>
				</div>
				<hr/>
				<div class="form-group">
					<label>Text / HTML</label>
					<textarea class="form-control input-sm tinymce" name="about_content" rows="20"><?php echo $rowAbout['content']; ?></textarea>

				</div>

				<button type="submit" name="aboutus_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i>Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i>Reset</button>

			</form>

		</div>
	</div>

<?php
	include 'includes/footer.php';
?>
