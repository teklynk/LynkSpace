<?php
define('inc_access', TRUE);

include 'includes/header.php';

//Page preview
if ($_GET['preview']>"") {

	$pagePreviewId=$_GET['preview'];

	$sqlPagePreview = mysqli_query($db_conn, "SELECT id, title, image, content, loc_id FROM pages WHERE id=".$pagePreviewId." AND loc_id=".$_SESSION['loc_id']." ");
	$rowPagePreview = mysqli_fetch_array($sqlPagePreview);

	echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";

	if ($rowPagePreview['title']>""){
		echo "<h4>".$rowPagePreview['title']."</h4>";
	}

	if ($rowPagePreview['image']>"") {
		echo "<p><img src=../uploads/".$_SESSION['loc_id']."/".$rowPagePreview['image']." style='max-width:350px; max-height:150px;' /></p>";
	}

	echo $rowPagePreview['content'];
}
?>
<div class="row">
<div class="col-lg-12">
<?php
	if ($_GET['newpage'] == 'true') {
		echo "<h1 class='page-header'>Pages (New)</h1>";
	} else {
		echo "<h1 class='page-header'>Pages</h1>";
	}
?>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<?php

	if ($_GET['newpage'] OR $_GET['editpage']) {

		// Update existing page
		if ($_GET['editpage']) {
			$thePageId = $_GET['editpage'];
			$pageLabel = "Edit Page Title";

			//update data on submit
			if (!empty($_POST['page_title'])) {

				if ($_POST['page_status']=='on') {
					$_POST['page_status']='true';
				} else {
					$_POST['page_status']='false';
				}

				$pageUpdate = "UPDATE pages SET title='".htmlspecialchars(strip_tags(trim($_POST['page_title'])), ENT_QUOTES)."', content='".trim($_POST['page_content'])."', image='".$_POST['page_image']."', image_align='".$_POST['page_image_align']."', active='".$_POST['page_status']."', disqus='".$_POST['page_disqus']."', datetime='".date("Y-m-d H:i:s")."' WHERE id=".$thePageId." ";
				mysqli_query($db_conn, $pageUpdate);

				$pageMsg="<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='page.php?loc_id=".$_GET['loc_id']."' class='alert-link'>Back</a> | The page ".htmlspecialchars(strip_tags($_POST['page_title']), ENT_QUOTES)." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			}

			$sqlPages = mysqli_query($db_conn, "SELECT id, title, image, content, active, datetime, image_align, disqus, loc_id FROM pages WHERE id=".$thePageId." AND loc_id=".$_GET['loc_id']." ");
			$rowPages = mysqli_fetch_array($sqlPages);

		//Create new page
		} else if ($_GET['newpage']) {

			$pageLabel = "New Page Title";

			//insert data on submit
			if (!empty($_POST['page_title'])) {
				$pageInsert = "INSERT INTO pages (title, content, image, image_align, active, disqus, datetime, loc_id) VALUES ('".htmlspecialchars(strip_tags(trim($_POST['page_title'])), ENT_QUOTES)."', '".trim($_POST['page_content'])."', '".$_POST['page_image']."', '".$_POST['page_image_align']."', 'true', 'true', '".date("Y-m-d H:i:s")."', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $pageInsert);

				echo "<script>window.location.href='page.php?loc_id=".$_GET['loc_id']."';</script>";

			}
		}

		//alert messages
		if ($pageMsg !="") {
			echo $pageMsg;
		}

		if ($_GET['editpage']) {
			//active status
			if ($rowPages['active']=='true') {
				$selActive="CHECKED";
			} else {
				$selActive="";
			}

			//comments status
			if ($rowPages['disqus']=='true') {
				$selDisqus="CHECKED";
			} else {
				$selDisqus="";
			}
		}

		if ($rowPages['image']=="") {
			$image = "http://placehold.it/140x100&text=No Image";
		} else {
			$image = "../uploads/".$_GET['loc_id']."/".$rowPages['image'];
		}

		//image align status
		if ($rowPages['image_align']=="left") {
			$selAlignLeft="SELECTED";
			$selAlignRight="";
		} else {
			$selAlignRight="SELECTED";
			$selAlignLeft="";
		}
?>
	<form name="pageForm" method="post" action="">

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group" id="pageactive">
					<label>Active</label>
					<div class="checkbox">
						<label>
							<input class="page_status_checkbox" id="<?php echo $_GET['editpage']?>" name="page_status" type="checkbox" <?php if($_GET['editpage']){echo $selActive;}?> data-toggle="toggle">
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="form-group">
			<label><?php echo $pageLabel; ?></label>
			<input class="form-control input-sm count-text" name="page_title" maxlength="255" value="<?php if($_GET['editpage']){echo $rowPages['title'];} ?>" placeholder="Page Title">
		</div>
		<hr/>
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

							if ($file===$rowPages['image']){
								$imageCheck="SELECTED";
							} else {
								$imageCheck="";
							}

							echo "<option value='".$file."' $imageCheck>".$file."</option>";
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

		<?php
		$sqlSetup = mysqli_query($db_conn, "SELECT disqus, loc_id FROM setup WHERE loc_id=".$_GET['loc_id']." ");
		$rowSetup = mysqli_fetch_array($sqlSetup);

		// Hide Disqus option if disqus is not enabled on Setup page.
		if (empty($rowSetup['disqus'])) {

			echo "<input type='hidden' name='page_disqus' value='false'>";

		} else {
		?>

		<div class="row" style="display:none;">
			<div class="col-lg-4">
				<div class="form-group" id="pagedisqus">
					<label>Allow Comments (Disqus)</label>
					<div class="checkbox">
						<label>
							<input class="checkbox page_disqus_checkbox" id="<?php echo $_GET['editpage']?>" name="page_disqus" type="checkbox" <?php if($_GET['editpage']){echo $selDisqus;}?> data-toggle="toggle">
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
			<label>Text / HTML</label>
			<textarea class="form-control input-sm tinymce" rows="20" name="page_content" id="page_content"><?php if($_GET['editpage']){echo $rowPages['content'];} ?></textarea>
		</div>
        <div class="form-group">
			<span><?php if($_GET['editpage']){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($rowPages['datetime']));} ?></span>
		</div>
		<button type="submit" name="page_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$pageMsg="";
		$delPageId = $_GET['deletepage'];
		$delPageTitle = $_GET['deletetitle'];

		//delete page
		if ($_GET['deletepage'] AND $_GET['deletetitle'] AND !$_GET['confirm']) {

			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".htmlspecialchars($delPageTitle, ENT_QUOTES)."? <a href='page.php?loc_id=".$_GET['loc_id']."&deletepage=".$delPageId."&deletetitle=".$delPageTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deletepage'] AND $_GET['deletetitle'] AND $_GET['confirm']=='yes') {

			//delete page after clicking Yes
			$pageDelete = "DELETE FROM pages WHERE id='$delPageId'";
			mysqli_query($db_conn, $pageDelete);

			$deleteMsg="<div class='alert alert-success'>".$delPageTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

		//update heading on submit
		if (!empty($_POST['main_heading'])) {

			$setupUpdate = "UPDATE setup SET pageheading='".htmlspecialchars(strip_tags(trim($_POST['main_heading'])), ENT_QUOTES)."', datetime='".date("Y-m-d H:i:s")."' WHERE loc_id=".$_GET['loc_id']." ";
			mysqli_query($db_conn, $setupUpdate);

			$pageMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
		}

		$sqlSetup = mysqli_query($db_conn, "SELECT pageheading FROM setup WHERE loc_id=".$_GET['loc_id']." ");
		$rowSetup  = mysqli_fetch_array($sqlSetup);
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
<script type="text/javascript">
$(document).ready(function() {
    $('#dataTable').dataTable({
        "iDisplayLength": 25,
        "order": [[ 0, "desc" ]],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false,
        }]
    });
});
</script>
		<button type="button" class="btn btn-default" onclick="window.location='?newpage=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Page</button>
		<h2></h2>
		<div class="table-responsive">
			<?php
				if ($pageMsg !="") {
					echo $pageMsg;
				}
			?>
			<form name="pageForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm count-text" name="main_heading" maxlength="255" value="<?php echo $rowSetup['pageheading']; ?>" placeholder="My page" required>
            </div>
			<hr/>
			<table class="table table-bordered table-hover table-striped dataTable" id="dataTable">
				<thead>
					<tr>
						<th>Page Title</th>
						<th>Active</th>
						<th class="no-sort">Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$sqlPages = mysqli_query($db_conn, "SELECT id, title, image, content, active, loc_id FROM pages WHERE loc_id=".$_GET['loc_id']." ORDER BY datetime DESC");
					while ($rowPages = mysqli_fetch_array($sqlPages)) {

						$pageId=$rowPages['id'];
						$pageTitle=$rowPages['title'];
						$pageTumbnail=$rowPages['image'];
						$pageContent=$rowPages['content'];
						$pageActive=$rowPages['active'];

						if ($rowPages['active']=='true') {
							$isActive="CHECKED";
						} else {
							$isActive="";
						}

						echo "<tr>
						<td><a href='page.php?loc_id=".$_GET['loc_id']."&editpage=$pageId' title='Edit'>".$pageTitle."</a></td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Page Active' class='checkbox page_status_checkbox' id='$pageId' type='checkbox' ".$isActive.">
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('".htmlspecialchars($pageTitle, ENT_QUOTES)."', 'page.php?loc_id=".$_GET['loc_id']."&preview=$pageId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='page.php?loc_id=".$_GET['loc_id']."&deletepage=$pageId&deletetitle=".htmlspecialchars($pageTitle, ENT_QUOTES)."'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";

					}
				?>
				</tbody>
			</table>

            <button type="submit" name="pageNew_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
			</form>
		</div>
<?php
	} //end of long else statement
?>
		</div>
	</div>
	<p></p>

<?php
	include 'includes/footer.php';
?>