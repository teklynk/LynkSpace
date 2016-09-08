<?php
define('inc_access', TRUE);

include 'includes/header.php';

		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$fileExt = substr(basename( $_FILES["fileToUpload"]["name"]),-4);
			if ($fileExt==".png" || $fileExt==".jpg" || $fileExt==".gif") {
				$uploadMsg = "<div class='alert alert-success' style='margin-top:12px;'>The file ". basename( $_FILES["fileToUpload"]["name"]) . " has been uploaded.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php'\">×</button></div>";
			} else {
				unlink($target_file);
				$uploadMsg = "<div class='alert alert-danger' style='margin-top:12px;'>The file ". basename( $_FILES["fileToUpload"]["name"]) . " is not allowed.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php'\">×</button></div>";
			}
		} else {
			$uploadMsg = "";
		}
		
		$deleteMsg = "";
		//Delete file
		if ($_GET["delete"] AND !$_GET["confirm"]) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$_GET["delete"]."? <a href='?delete=".$_GET["delete"]."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php'\">×</button></div>";
		} elseif ($_GET["delete"] AND $_GET["confirm"]=="yes") {
			unlink($target_dir.$_GET["delete"]);
			$deleteMsg="<div class='alert alert-success'>".$_GET["delete"]." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php'\">×</button></div>";
		}
?>
<script>
$(document).ready(function() {
	$('#example').dataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [{
		"targets": 'no-sort',
		"orderable": false,
		}]
	});
});
</script>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Uploads
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
        <?php if ($uploadMsg !="") {echo $uploadMsg ;} ?>
        <?php if ($deleteMsg !="") {echo $deleteMsg ;} ?>
		<form role="uploadForm" method="post" action="" enctype="multipart/form-data">
			<div class="form-group">
				<label>Upload Image</label>
				<input type="file" name="fileToUpload" id="fileToUpload">
			</div>
			<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-upload'></i> Upload Image</button>
		</form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h2>Images</h2>
			<div>
				<table class="table table-bordered table-hover table-striped dataTable" id="example">
					<thead>
						<tr>
							<th>Name</th>
							<th>Date</th>
							<th class="no-sort">Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if ($handle = opendir($target_dir)) {
						$count = 0;
						
							while (false !== ($file = readdir($handle))) {
								if ('.' === $file) continue;
								if ('..' === $file) continue;
								//exclude these files
								if ($file==="Thumbs.db") continue;
								if ($file===".DS_Store") continue;
								if ($file==="index.html") continue;
								$count++;
								$modDate = date('m-d-Y, H:i:s',filemtime($target_dir.$file));
								echo "<tr data-index='".$count."'>
								<td><a href='#' onclick=\"showMyModal('$file', '$target_dir$file')\" title='Preview'>".$file."</a></td>
								<td class='col-xs-3'>".$modDate."</td>
								<td class='col-xs-1'>
								<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?delete=$target_dir$file'\"><i class='fa fa-fw fa-trash'></i></button>
								</td>
								</tr>";
							}

							closedir($handle);
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
 <!-- /.row -->
 <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalTitle"></h4>
      </div>
      <div class="modal-body">
			<img id="myModalFile" src="" class="img-responsive center-block" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
include 'includes/footer.php';
?>
