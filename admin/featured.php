<?php 
define('inc_access', TRUE);

include 'includes/header.php';
	
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$uploadMsg = "<div class='alert alert-success'>The file ". basename( $_FILES["fileToUpload"]["name"]) ." has been uploaded.<button type='button' class='close' data-dismiss='alert'>×</button></div>";
	} else {
		$uploadMsg = "";
	}
	
	//update table on submit
	if (!empty($_POST)) {
		$featuredUpdate = "UPDATE featured SET heading='".$_POST["featured_heading"]."', introtext='".$_POST["featured_introtext"]."', content='".$_POST["featured_content"]."', image='".$_POST["featured_image"]."', image_align='".$_POST["featured_image_align"]."' ";
		mysqli_query($db_conn, $featuredUpdate);
		$pageMsg="<div class='alert alert-success'>The featured section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='featured.php'\">×</button></div>";
	}
	
	$sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, image, image_align FROM featured");
	$row  = mysqli_fetch_array($sqlFeatured);
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<?php echo $rowFeatured["heading"]?>
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
		<?php 
		if ($uploadMsg !="") {
			echo $uploadMsg;
		}
		if ($pageMsg !="") {
			echo $pageMsg;
		}

		if ($row["image"]=="") {
			$thumbNail = "http://placehold.it/140x100&text=No Image";
		} else {
			$thumbNail = "../uploads/".$row["image"];
		}
		
		//image algin status		
		if ($row['image_align']=="left") {
			$selAlignLeft="SELECTED";
			$selAlignRight="";
		} else {
			$selAlignRight="SELECTED";
			$selAlignLeft="";
		}
		?>
		<form role="landingForm" method="post" action="" enctype="multipart/form-data">
			<div class="form-group">
				<label>Heading</label>
				<input class="form-control input-sm" name="featured_heading" value="<?php echo $row['heading']; ?>"  placeholder="Welcome">
			</div>
			<div class="form-group">
				<label>Intro Title</label>
				<input class="form-control input-sm" name="featured_introtext" value="<?php echo $row['introtext']; ?>" placeholder="John Doe">
			</div>
			<hr/>
			<div class="form-group">
	            <label>Upload Image</label>
	            <input type="file" name="fileToUpload" id="fileToUpload">
	    	</div>
	        <div class="form-group">
	        	<img src="<?php echo $thumbNail;?>" id="featured_image_preview" style="max-width:140px; height:auto;"/>
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
	                            if ($file==="Thumbs.db") continue;
	                            if ($file===".DS_Store") continue;
	                            if ($file==="index.html") continue;
	                            if ($file===$row['image']){
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
				<select class="form-control input-sm" name="featured_image_align">
					<option value="left" <?php echo $selAlignLeft; ?>>Left</option>
					<option value="right" <?php echo $selAlignRight; ?>>Right</option>
				</select>
			</div>
			<hr/>
	        <div class="form-group">
				<label>Text / HTML</label>
				<textarea class="form-control input-sm tinymce" name="featured_content" rows="20"><?php echo $row['content']; ?></textarea>
			</div>

			<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
		</div>
		</form>
	</div>
<?php 
include 'includes/footer.php';
?>
