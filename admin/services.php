<?php
define('inc_access', TRUE);

include 'includes/header.php';

//Page preview
if ($_GET['preview']>"") {

	$pagePreviewId=$_GET['preview'];

	$sqlServicesPreview = mysqli_query($db_conn, "SELECT id, title, icon, image, content, link, loc_id FROM services WHERE id='$pagePreviewId' AND loc_id=".$_SESSION['loc_id']." ");
	$rowServicesPreview  = mysqli_fetch_array($sqlServicesPreview);

	echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";
	echo "<div class='col-lg-12'>";

	if ($rowServicesPreview['icon']>"") {
		echo "<p style='font-size:6.0em;'><i class='fa fa-fw fa-".$rowServicesPreview['icon']."'></i></p><br/>";
	}

	if ($rowServicesPreview['image']>"") {
		echo "<p><img src=../uploads/".$rowServicesPreview['image']." style='max-width:350px; max-height:150px;' /></p>";
	}

	if ($rowServicesPreview['title']>"") {
		echo "<h4>".$rowServicesPreview['title']."</h4>";
	}
	echo "<p>".$rowServicesPreview['content']."</p>";

	if ($rowServicesPreview['link']>0) {
		echo "<br/><p><i class='fa fa-fw fa-external-link'></i> <a href='../page.php?ref=".$rowServicesPreview['link']."&loc_id=".$_SESSION['loc_id']."' target='_blank'>Page Link</a></p>";
	}

	echo "</div>";
}
?>
	<div class="row">
	<div class="col-lg-12">
	<?php
		if ($_GET['newservice'] == 'true') {
			echo "<h1 class='page-header'>Services (New)</h1>";
		} else {
			echo "<h1 class='page-header'>Services</h1>";
		}
	?>
	</div>
	</div>
	<div class="row">
	<div class="col-lg-12">
<?php

	if ($_GET['newservice'] OR $_GET['editservice']) {
		$serviceMsg="";

		//Update existing service
		if ($_GET['editservice']) {
			$theserviceId = $_GET['editservice'];
			$serviceLabel = "Edit Service Title";

			//update data on submit
			if (!empty($_POST['service_title'])) {

				if ($_POST['service_status']=='on') {
					$_POST['service_status']='true';
				} else {
					$_POST['service_status']='false';
				}

				$servicesUpdate = "UPDATE services SET title='".htmlspecialchars(strip_tags(trim($_POST['service_title'])), ENT_QUOTES)."', content='".htmlspecialchars(strip_tags(trim($_POST['service_content'])), ENT_QUOTES)."', link=".$_POST['service_link'].", icon='".$_POST['service_icon_select']."', image='".$_POST['service_image_select']."', active='".$_POST['service_status']."', datetime='".date("Y-m-d H:i:s")."' WHERE id='$theserviceId' AND loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $servicesUpdate);

				$serviceMsg="<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='services.php?loc_id=".$_GET['loc_id']."' class='alert-link'>Back</a> | The service ".htmlspecialchars(strip_tags($_POST['service_title']), ENT_QUOTES)." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			}

			$sqlServices = mysqli_query($db_conn, "SELECT id, title, icon, image, content, link, active, datetime, loc_id FROM services WHERE id='$theserviceId' AND loc_id=".$_GET['loc_id']." ");
			$rowServices = mysqli_fetch_array($sqlServices);

		//Create new service
		} else if ($_GET['newservice']) {

			$serviceLabel = "New Service Title";

			//insert data on submit
			if (!empty($_POST['service_title'])) {
				$servicesInsert = "INSERT INTO services (title, content, icon, image, link, active, datetime, loc_id) VALUES ('".htmlspecialchars(strip_tags(trim($_POST['service_title'])), ENT_QUOTES)."', '".htmlspecialchars(strip_tags(trim($_POST['service_content'])), ENT_QUOTES)."', '".$_POST['service_icon_select']."', '".$_POST['service_image_select']."', ".$_POST['service_link'].", 'true', '".date("Y-m-d H:i:s")."', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $servicesInsert);

				echo "<script>window.location.href='services.php?loc_id=".$_GET['loc_id']."';</script>";

			}
		}

		//alert messages
		if ($serviceMsg != "") {
			echo $serviceMsg;
		}

		if ($_GET['editservice']) {
			//active status
			if ($rowServices['active']=='true') {
				$selActive="CHECKED";
			} else {
				$selActive="";
			}
		}
?>

	<form name="serviceForm" method="post" action="">

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group" id="servicesactive">
					<label>Active</label>
					<div class="checkbox">
						<label>
							<input class="services_status_checkbox" id="<?php echo $_GET['editservice']?>" name="service_status" type="checkbox" <?php if($_GET['editservice']){echo $selActive;}?> data-toggle="toggle">
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="form-group">
			<label><?php echo $serviceLabel; ?></label>
			<input class="form-control input-sm count-text" name="service_title" maxlength="255" value="<?php if($_GET['editservice']){echo $rowServices['title'];} ?>" placeholder="Service Title">
		</div>
		<hr/>
		<div class="form-group">
			<i id="service_icon" style="font-size:6.0em;" class="fa fa-fw fa-<?php echo $rowServices['icon']; ?>"></i>
		</div>
		<div class="form-group">
			<?php

			if ($rowServices['image']=="") {
				$imgSrc = "http://placehold.it/2/ffffff/ffffff"; //small image just to give the source a value
			} else {
				$imgSrc = "../uploads/".$_GET['loc_id']."/".$rowServices['image'];
			}

			echo "<img src='".$imgSrc."' id='service_image_preview' style='max-width:140px; height:auto; display:block;'/>";
			?>
		</div>
		<div class="form-group">
			<label>Choose an icon</label>
			<select class="form-control input-sm" name="service_icon_select" id="service_icon_select">
				<option value="">None</option>
				<?php

				$sqlServicesIcon = mysqli_query($db_conn, "SELECT icon FROM services_icons ORDER BY icon ASC");
				while ($rowIcon = mysqli_fetch_array($sqlServicesIcon)) {
					$icon=$rowIcon['icon'];
					if ($icon===$rowServices['icon']) {
						$iconCheck="SELECTED";
					} else {
						$iconCheck="";
					}
					echo "<option value=".$icon." ".$iconCheck.">".$icon."</option>";
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control input-sm" name="service_image_select" id="service_image_select">
				<option value="">None</option>
				<?php
				if ($handle = opendir($target_dir)) {
					while (false !== ($file = readdir($handle))) {
						if ('.' === $file) continue;
						if ('..' === $file) continue;
						if ($file==="Thumbs.db") continue;
						if ($file===".DS_Store") continue;
						if ($file==="index.html") continue;
						if ($file===$rowServices['image']){
							$imageCheck="SELECTED";
						} else {
							$imageCheck="";
						}
						echo "<option value='".$file."' ".$imageCheck.">".$file."</option>";
					}
					closedir($handle);
				}
				?>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Choose a link</label>
			<select class="form-control input-sm" name="service_link">
				<option value="0">None</option>
				<?php
				$pagesStr="";
				$sqlServicesLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY title ASC");
				while ($rowServicesLink = mysqli_fetch_array($sqlServicesLink)) {
					$serviceLinkId=$rowServicesLink['id'];
					$serviceLinkTitle=$rowServicesLink['title'];

					if ($serviceLinkId===$rowServices['link']) {
						$isSelected="SELECTED";
					} else {
						$isSelected="";
					}

					$pagesStr =  $pagesStr . "<option value=".$serviceLinkId." ".$isSelected.">".$serviceLinkTitle."</option>";
				}

				$pagesStr = "<optgroup label='Existing Pages'>".$pagesStr."</optgroup>";
				echo $pagesStr;
				?>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control input-sm count-text" rows="3" name="service_content" placeholder="Text" maxlength="255"><?php if($_GET['editservice']){echo $rowServices['content'];} ?></textarea>
		</div>
		<div class="form-group">
			<span><?php if($_GET['editservice']){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($rowServices['datetime']));} ?></span>
		</div>
		<button type="submit" name="sservices_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$serviceMsg="";
		$delserviceId = $_GET['deleteservice'];
		$delserviceTitle = $_GET['deletetitle'];
		$moveserviceId = $_GET['moveservice'];
		$moveserviceTitle = $_GET['movetitle'];

		//delete service
		if ($_GET['deleteservice'] AND $_GET['deletetitle'] AND !$_GET['confirm']) {

			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delserviceTitle."? <a href='?loc_id=".$_GET['loc_id']."&deleteservice=".$delserviceId."&deletetitle=".$delserviceTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deleteservice'] AND $_GET['deletetitle'] AND $_GET['confirm']=='yes') {
			//delete service after clicking Yes
			$servicesDelete = "DELETE FROM services WHERE id='$delserviceId'";
			mysqli_query($db_conn, $servicesDelete);

			$deleteMsg="<div class='alert alert-success'>".$delserviceTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

		//move services to top of list
		if (($_GET['moveservice'] AND $_GET['movetitle'])) {
			$servicesDateUpdate = "UPDATE services SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$moveserviceId'";
			mysqli_query($db_conn, $servicesDateUpdate);

			$serviceMsg="<div class='alert alert-success'>".$moveserviceTitle." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
		}

		//update heading on submit
		if (($_POST['save_main'])) {
			$setupUpdate = "UPDATE setup SET servicesheading='".htmlspecialchars(strip_tags($_POST['main_heading']), ENT_QUOTES)."', servicescontent='".htmlspecialchars(strip_tags($_POST['main_content']), ENT_QUOTES)."', datetime='".date("Y-m-d H:i:s")."' WHERE loc_id=".$_GET['loc_id']." ";
			mysqli_query($db_conn, $setupUpdate);

			$serviceMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
		}

		$sqlSetup = mysqli_query($db_conn, "SELECT servicesheading, servicescontent FROM setup WHERE loc_id=".$_GET['loc_id']." ");
		$rowSetup  = mysqli_fetch_array($sqlSetup);
?>
<!--modal preview window-->

<style>
	#webserviceDialog iframe {
		width: 100%;
		height: 600px;
		frameborder: 0;
		border: none;
	}
	.modal-dialog {
		width:95%;
	}
</style>


<div class="modal fade" id="webserviceDialog">
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

	<button type="button" class="btn btn-default" onclick="window.location='?newservice=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-paper-plane'></i> Add a New service</button>
	<h2></h2>
	<div class="table-responsive">
		<?php
		if ($serviceMsg != "") {
			echo $serviceMsg;
		}
		?>
		<form name="servicesForm" method="post" action="">
			<div class="form-group">
				<label>Heading</label>
				<input class="form-control input-sm count-text" name="main_heading" maxlength="255" value="<?php echo $rowSetup['servicesheading']; ?>" placeholder="My Services" required>
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea rows="3" class="form-control input-sm count-text" name="main_content" placeholder="About our services" maxlength="255"><?php echo $rowSetup['servicescontent']; ?></textarea>
			</div>
			<table class="table table-bordered table-hover table-striped">
				<thead>
				<tr>
					<th>Service Title</th>
					<th>Active</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sqlServices = mysqli_query($db_conn, "SELECT id, title, icon, content, link, active, loc_id FROM services WHERE loc_id=".$_GET['loc_id']." ORDER BY datetime DESC");
				while ($rowServices  = mysqli_fetch_array($sqlServices)) {
					$serviceId=$rowServices['id'];
					$serviceTitle=$rowServices['title'];
					$serviceTumbnail=$rowServices['icon'];
					$serviceContent=$rowServices['content'];
					$serviceActive=$rowServices['active'];

					if ($rowServices['active']=='true') {
						$isActive="CHECKED";
					} else {
						$isActive="";
					}

				echo "<tr>
				<td><a href='services.php?loc_id=".$_GET['loc_id']."&editservice=$serviceId' title='Edit'>".$serviceTitle."</a></td>
				<td class='col-xs-1'>
				<input data-toggle='toggle' title='Service Active' class='checkbox services_status_checkbox' id='$serviceId' type='checkbox' ".$isActive.">
				</td>
				<td class='col-xs-2'>
				<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('".htmlspecialchars($serviceTitle, ENT_QUOTES)."', 'services.php?loc_id=".$_GET['loc_id']."&preview=$serviceId')\"><i class='fa fa-fw fa-image'></i></button>
				<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."&moveservice=$serviceId&movetitle=".htmlspecialchars($serviceTitle, ENT_QUOTES)."'\"><i class='fa fa-fw fa-arrow-up'></i></button>
				<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."&deleteservice=$serviceId&deletetitle=".htmlspecialchars($serviceTitle, ENT_QUOTES)."'\"><i class='fa fa-fw fa-trash'></i></button>
				</td>
				</tr>";
				}
				?>
				</tbody>
			</table>
			<input type="hidden" name="save_main" value="true" />
			<button type="submit" name='servicesNew_submit' class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
		</form>
	</div>

	<?php
	} //end of long else
	echo "</div>
	</div>
	<p></p>";

	include 'includes/footer.php';
?>