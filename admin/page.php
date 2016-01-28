<?php 
define('MyConst', TRUE);

include 'includes/header.php';
//Page preview
if ($_GET["preview"]>""){
	$pagePreviewId=$_GET["preview"];
	$sqlPagePreview = mysql_query("SELECT id, title, image, content FROM pages WHERE id='$pagePreviewId'");
	$row = mysql_fetch_array($sqlPagePreview);
		echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";
		if ($row["title"]>""){
			echo "<h4>".$row['title']."</h4>";
		}
		if ($row["image"]>""){
			echo "<p><img src=../uploads/".$row['image']." style='max-width:350px; max-height:150px;' /></p>";
		}
		echo $row['content'];
}
?>
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $rowSetup["pageheading"]?>
            </h1>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
<?php

	if ($_GET["newpage"] OR $_GET["editpage"]) {
		//Upload function
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$pageMsg="";
		
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$uploadMsg = "<div class='alert alert-success'>The file ". basename( $_FILES["fileToUpload"]["name"]) ." has been uploaded.<button type='button' class='close' data-dismiss='alert'>×</button></div>";
		} else {
			$uploadMsg = "";
		}
		
		//Update existing page
		if ($_GET["editpage"]) {
			$thePageId = $_GET["editpage"];
			$pageLabel = "Edit Page Title";
			
			//update data on submit
			if (!empty($_POST["page_title"])) {
				$pageUpdate = "UPDATE pages SET title='".$_POST["page_title"]."', content='".$_POST["page_content"]."', image='".$_POST["page_image"]."', image_align='".$_POST["page_image_align"]."', active=".$_POST["page_status"].", datetime='".date("Y-m-d H:i:s")."' WHERE id='$thePageId'";
				mysql_query($pageUpdate);
				$pageMsg="<div class='alert alert-success'>The page ".$_POST["page_title"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
			}
			
			$sqlPages = mysql_query("SELECT id, title, image, content, active, datetime, image_align FROM pages WHERE id='$thePageId'");
			$row  = mysql_fetch_array($sqlPages);
			
		//Create new page
		} else if ($_GET["newpage"]) {
			$pageLabel = "New Page Title";
			//insert data on submit
			if (!empty($_POST["page_title"])) {
				$pageInsert = "INSERT INTO pages (title, content, image, image_align, active) VALUES ('".$_POST["page_title"]."', '".$_POST["page_content"]."', '".$_POST["page_image"]."', '".$_POST["page_image_align"]."', ".$_POST["page_status"].")";
				mysql_query($pageInsert);
				$pageMsg="<div class='alert alert-success'>The page ".$_POST["page_title"]." has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
			}
		}

		//alert messages
		if ($uploadMsg !="") {
			echo $uploadMsg;
		}
		
		if ($pageMsg !="") {
			echo $pageMsg;
		}
		
		if ($_GET["editpage"]){ 
			//active status		
			if ($row['active']==1) {
				$selActive1="SELECTED";
				$selActive0="";
			} else {
				$selActive0="SELECTED";
				$selActive1="";
			}
		}

		if ($row["image"]=="") {
			$image = "http://placehold.it/140x100&text=No Image";
		} else {
			$image = "../uploads/".$row["image"];
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
	<form role="pageForm" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Status</label>
            <select class="form-control input-sm" name="page_status">
                <option value="1" <?php if($_GET["editpage"]){echo $selActive1;}?>>Active</option>
                <option value="0" <?php if($_GET["editpage"]){echo $selActive0;} ?>>Draft</option>
            </select>
        </div>
		<div class="form-group">
			<label><?php echo $pageLabel; ?></label>
			<input class="form-control input-sm" name="page_title" value="<?php if($_GET["editpage"]){echo $row['title'];} ?>" placeholder="Page Title">
		</div>
		<hr/>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group">
        	<img src="<?php echo $image;?>" id="page_image_preview" style="max-width:140px; height:auto; display:block;"/>
        </div>
		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control input-sm" name="page_image" id="page_image">
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
			<select class="form-control input-sm" name="page_image_align">
				<option value="left" <?php echo $selAlignLeft; ?>>Left</option>
				<option value="right" <?php echo $selAlignRight; ?>>Right</option>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Text / HTML</label>
			<textarea class="form-control input-sm tinymce" rows="20" name="page_content" id="page_content"><?php if($_GET["editpage"]){echo $row['content'];} ?></textarea>
		</div>
        <div class="form-group">
			<span><?php if($_GET["editpage"]){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($row['datetime']));} ?></span>
		</div>
		<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$pageMsg="";
		$delPageId = $_GET["deletepage"];
		$delPageTitle = $_GET["deletetitle"];
		$movePageId = $_GET["movepage"];
		$movePageTitle = $_GET["movetitle"];
		
		//delete page
		if ($_GET["deletepage"] AND $_GET["deletetitle"] AND !$_GET["confirm"]) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delPageTitle."? <a href='?deletepage=".$delPageId."&deletetitle=".$delPageTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
			echo $deleteMsg;
		} elseif ($_GET["deletepage"] AND $_GET["deletetitle"] AND $_GET["confirm"]=="yes") {
			//delete page after clicking Yes
			$pageDelete = "DELETE FROM pages WHERE id='$delPageId'";
			mysql_query($pageDelete);
			$deleteMsg="<div class='alert alert-success'>".$delPageTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
			echo $deleteMsg;
		}
		
			//move pages to top of list
		if (($_GET["movepage"] AND $_GET["movetitle"])) {
			$pagesDateUpdate = "UPDATE pages SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$movePageId'";
			mysql_query($pagesDateUpdate);
			$pageMsg="<div class='alert alert-success'>".$movePageTitle." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
		}
		
		//update heading on submit
		if (!empty($_POST["main_heading"])) {
			$setupUpdate = "UPDATE setup SET pageheading='".$_POST["main_heading"]."'";
			mysql_query($setupUpdate);
			$pageMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
		}
		
    $sqlSetup = mysql_query("SELECT pageheading FROM setup");
	$rowSetup  = mysql_fetch_array($sqlSetup);
?>
<!--modal preview window-->

<style>
#webpageDialog iframe {
	width: 100%;
	height: 600px;
	frameborder: 0;
	border: none;
}
.modal-dialog {
	width:95%;
}
</style>


 <div class="modal fade" id="webpageDialog">
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

	<button type="button" class="btn btn-default" onclick="window.location='?newpage=true';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Page</button>
		<h2></h2>
		<div class="table-responsive">
    <?php 
		if ($pageMsg !="") {
			echo $pageMsg;
		}
	?>
			<form role="pageForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm" name="main_heading" value="<?php echo $rowSetup['pageheading']; ?>" placeholder="My page">
            </div>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Page Title</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
        <?php 
					$sqlPages = mysql_query("SELECT id, title, image, content, active FROM pages ORDER BY datetime DESC");
					while ($row  = mysql_fetch_array($sqlPages)) {
						$pageId=$row['id'];
						$pageTitle=$row['title'];
						$pageTumbnail=$row['image'];
						$pageContent=$row['content'];
						$pageActive=$row['active'];
						if ($row['active']==0){
							$isActive="<i style='color:red;'>(Draft)</i>";
						} else {
							$isActive="";
						}
						echo "<tr>
						<td>".$pageTitle."</td>
						<td class='col-xs-1'>
						<span>".$isActive."</span>
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$pageTitle', '?preview=$pageId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Edit' class='btn btn-xs btn-default' onclick=\"window.location.href='?editpage=$pageId'\"><i class='fa fa-fw fa-edit'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?deletepage=$pageId&deletetitle=$pageTitle'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
					}
		?>
				</tbody>
			</table>
            <button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
			</form>
		</div>
<?php
	} //end of long else
?>
		</div>
	</div>
	<p></p>

<?php
include 'includes/footer.php';
?>
