<?php
define('inc_access', TRUE);

include_once ('includes/header.inc.php');

$_SESSION['file_referer'] = 'services.php';

//Page preview
if ($_GET['preview']>"") {

	$pagePreviewId=$_GET['preview'];

	$sqlServicesPreview = mysqli_query($db_conn, "SELECT id, title, icon, image, content, link, loc_id FROM services WHERE id='$pagePreviewId' AND loc_id=".$_SESSION['loc_id']." ");
	$rowServicesPreview  = mysqli_fetch_array($sqlServicesPreview);

	echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
	echo "<div class='col-lg-12'>";

	if ($rowServicesPreview['icon']>"") {
		echo "<p style='font-size:6.0em;'><i class='fa fa-fw fa-".$rowServicesPreview['icon']."'></i></p><br/>";
	}

	if ($rowServicesPreview['image']>"") {
		echo "<p><img src='../uploads/".$_SESSION['loc_id']."/".$rowServicesPreview['image']."' style='max-width:350px; max-height:150px;' /></p>";
	}

	if ($rowServicesPreview['title']>"") {
		echo "<h4>".$rowServicesPreview['title']."</h4>";
	}
	echo "<p>".$rowServicesPreview['content']."</p>";

	if ($rowServicesPreview['link']) {
		echo "<br/><p><b>Page Link:</b> <a href='" . $rowServicesPreview['link'] . "' target='_blank'>" . $rowServicesPreview['link'] . "</a></p>";
	}

	echo "</div>";
}
?>
	<div class="row">
	<div class="col-lg-12">
	<?php
		if ($_GET['newservice'] == 'true') {
		    echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='services.php?loc=" . $_GET['loc_id'] . "'>Services</a></li>
            <li class='active'>New Services</li>
            </ol>";
			echo "<h1 class='page-header'>Services (New) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
		} elseif ($_GET['editservice']) {
            echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='services.php?loc=" . $_GET['loc_id'] . "'>Services</a></li>
            <li class='active'>Edit Services</li>
            </ol>";
            echo "<h1 class='page-header'>Services (Edit) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
		} else {
			echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li class='active'>Services</li>
            </ol>";
			echo "<h1 class='page-header'>Services</h1>";
		}
	?>
	</div>
	</div>
	<div class="row">
	<div class="col-lg-12">
<?php

	if ($_GET['newservice'] || $_GET['editservice']) {
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

				$servicesUpdate = "UPDATE services SET title='".safeCleanStr($_POST['service_title'])."', content='".sqlEscapeStr($_POST['service_content'])."', link='".safeCleanStr($_POST['service_link'])."', icon='".$_POST['service_icon_select']."', image='".$_POST['service_image_select']."', active='".$_POST['service_status']."', author_name='".$_SESSION['user_name']."' WHERE id='$theserviceId' AND loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $servicesUpdate);

				$serviceMsg="<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='services.php?loc_id=".$_GET['loc_id']."' class='alert-link'>Back</a> | The service ".safeCleanStr($_POST['service_title'])." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			}

			$sqlServices = mysqli_query($db_conn, "SELECT id, title, icon, image, content, link, active, author_name, datetime, loc_id FROM services WHERE id='$theserviceId' AND loc_id=".$_GET['loc_id']." ");
			$rowServices = mysqli_fetch_array($sqlServices);

		//Create new service
		} elseif ($_GET['newservice']) {

			$serviceLabel = "New Service Title";

			//insert data on submit
			if (!empty($_POST['service_title'])) {
				$servicesInsert = "INSERT INTO services (title, content, icon, image, link, active, author_name, loc_id) VALUES ('".sqlEscapeStr($_POST['service_title'])."', '".safeCleanStr($_POST['service_content'])."', '".$_POST['service_icon_select']."', '".$_POST['service_image_select']."', '".safeCleanStr($_POST['service_link'])."', 'true', '".$_SESSION['user_name']."', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $servicesInsert);

				header("Location: services.php?loc_id=".$_GET['loc_id']."");
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
    <div class="col-lg-8">
	<form name="serviceForm" class="dirtyForm" method="post" action="">

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
		<div class="form-group required">
			<label><?php echo $serviceLabel; ?></label>
			<input type="text" class="form-control count-text" name="service_title" maxlength="255" value="<?php if($_GET['editservice']){echo $rowServices['title'];} ?>" placeholder="Service Title" autofocus required>
		</div>
		<hr/>
		<div class="form-group">
			<i id="service_icon" style="font-size:6.0em;" class="fa fa-fw fa-<?php echo $rowServices['icon']; ?>"></i>
		</div>
		<div class="form-group">
			<?php

			if ($rowServices['image']=="") {
				$imgSrc = "//placehold.it/2/ffffff/ffffff"; //small image just to give the source a value
			} else {
				$imgSrc = "../uploads/".$_GET['loc_id']."/".$rowServices['image'];
			}

			echo "<img src='".$imgSrc."' id='service_image_preview' style='max-width:140px; height:auto; display:block; background-color: #ccc;'/>";
			?>
		</div>
		<div class="form-group">
			<label>Choose an icon</label>
			<select class="form-control selectpicker ays-ignore" data-container="body" data-dropup-auto="false" data-size="10" name="service_icon_select" id="service_icon_select">
				<option value="">None</option>
				<?php
					getIconDropdownList($rowServices['icon']);
				?>
			</select>
		</div>
		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control" name="service_image_select" id="service_image_select">
				<option value="">None</option>
				<?php
                    getImageDropdownList($image_dir, $rowServices['image']);
                ?>
			</select>
		</div>
		<hr/>

		<div class="form-group">
            <label>Link URL</label>
            <input type="text" class="form-control count-text" name="service_link" id="service_link" maxlength="255" value="<?php if ($_GET['editservice']) {echo $rowServices['link'];} ?>" >
        </div>

		<div class="form-group">
			<label>Existing Page</label>
			<select class="form-control" name="service_exist_page" id="service_exist_page">
				<option value="">None</option>
				<?php
				$pagesStr="";
				$sqlServicesLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY title ASC");
				while ($rowServicesLink = mysqli_fetch_array($sqlServicesLink)) {
					$serviceLinkId=$rowServicesLink['id'];
					$serviceLinkTitle=$rowServicesLink['title'];

					$pagesStr .= "<option value='page.php?page_id=" . $serviceLinkId . "&loc_id=".$_GET['loc_id']." '>" . $serviceLinkTitle . "</option>";
				}

				$pagesStr = "<optgroup label='Existing Pages'>".$pagesStr."</optgroup>";
				echo $pagesStr;
				?>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control count-text" rows="3" name="service_content" placeholder="Text" maxlength="999"><?php if($_GET['editservice']){echo $rowServices['content'];} ?></textarea>
		</div>

		<button type="submit" name="sservices_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

	</form>
	</div>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$serviceMsg="";
		$delserviceId = $_GET['deleteservice'];
		$delserviceTitle = $_GET['deletetitle'];

		//delete service
		if ($_GET['deleteservice'] && $_GET['deletetitle'] && !$_GET['confirm']) {

			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delserviceTitle."? <a href='?loc_id=".$_GET['loc_id']."&deleteservice=".$delserviceId."&deletetitle=".safeCleanStr(addslashes($delserviceTitle))."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deleteservice'] && $_GET['deletetitle'] && $_GET['confirm']=='yes') {
			//delete service after clicking Yes
			$servicesDelete = "DELETE FROM services WHERE id='$delserviceId'";
			mysqli_query($db_conn, $servicesDelete);

			$deleteMsg="<div class='alert alert-success'>".$delserviceTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

		//update heading on submit
		if (($_POST['save_main'])) {

			if ($_POST['services_defaults'] == 'on') {
				$_POST['services_defaults'] = 'true';
			} else {
				$_POST['services_defaults'] = 'false';
			}

			$setupUpdate = "UPDATE setup SET servicesheading='".safeCleanStr($_POST['main_heading'])."', servicescontent='".sqlEscapeStr($_POST['main_content'])."', services_use_defaults='" . safeCleanStr($_POST['services_defaults']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=".$_GET['loc_id']." ";
			mysqli_query($db_conn, $setupUpdate);

			for ($i = 0; $i < $_POST['service_count']; $i++) {

				$servicesUpdate = "UPDATE services SET sort=" . safeCleanStr($_POST['service_sort'][$i]) . " WHERE id=" . $_POST['service_id'][$i] . " ";
				mysqli_query($db_conn, $servicesUpdate);

			}

			$serviceMsg="<div class='alert alert-success'>The services have been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
		}

		$sqlSetup = mysqli_query($db_conn, "SELECT servicesheading, servicescontent, services_use_defaults FROM setup WHERE loc_id=".$_GET['loc_id']." ");
		$rowSetup  = mysqli_fetch_array($sqlSetup);
?>
<!--modal preview window-->

<style>
	#webserviceDialog iframe {
		width: 100%;
		height: 600px;
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
                <a type="button" class="close" data-dismiss="modal">
                   <i class="fa fa-times"></i>
                </a>
                <h4 class="modal-title">&nbsp;</h4>
			</div>
			<div class="modal-body">
				<iframe id="myModalFile" src="" frameborder="0"></iframe>
			</div>
			<div class="modal-footer">&nbsp;</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <?php
    //use default view
    if ($rowSetup['services_use_defaults'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }

    if ($_GET['loc_id'] != 1) {
        ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group" id="servicesdefaults">
                    <label>Use Defaults</label>
                    <div class="checkbox">
                        <label>
                            <input class="services_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="services_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
        <?php
    }
    ?>

	<button type="button" class="btn btn-primary" onclick="window.location='?newservice=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-plus'></i> Add a New Service</button>
	<h2></h2>
	<div class="table-responsive">
		<?php
		if ($serviceMsg != "") {
			echo $serviceMsg;
		}
		?>
		<form name="servicesForm" class="dirtyForm" method="post" action="">
			<div class="form-group required">
				<label>Heading</label>
				<input class="form-control count-text" name="main_heading" maxlength="255" value="<?php echo $rowSetup['servicesheading']; ?>" placeholder="My Services" autofocus required>
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea rows="3" class="form-control count-text" name="main_content" placeholder="About our services" maxlength="255"><?php echo $rowSetup['servicescontent']; ?></textarea>
			</div>
			<table class="table table-bordered table-hover table-striped table-responsive">
				<thead>
				<tr>
					<th>Sort</th>
					<th>Service Title</th>
					<th>Active</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$serviceCount = "";
				$sqlServices = mysqli_query($db_conn, "SELECT id, title, icon, content, link, sort, active, loc_id FROM services WHERE loc_id=".$_GET['loc_id']." ORDER BY sort ASC");
				while ($rowServices  = mysqli_fetch_array($sqlServices)) {
					$serviceId=$rowServices['id'];
					$serviceTitle=$rowServices['title'];
					$serviceTumbnail=$rowServices['icon'];
					$serviceContent=$rowServices['content'];
					$serviceActive=$rowServices['active'];
					$serviceSort=$rowServices['sort'];
					$serviceCount++;

					if ($rowServices['active']=='true') {
						$isActive="CHECKED";
					} else {
						$isActive="";
					}

				echo "<tr>
				<td class='col-xs-1'>
				<input class='form-control' name='service_sort[]' value='" . $serviceSort . "' type='text' maxlength='3' required>
				</td>
				<td>
				<input type='hidden' name='service_id[]' value='" . $serviceId . "' >
				<a href='services.php?loc_id=".$_GET['loc_id']."&editservice=$serviceId' title='Edit'>".$serviceTitle."</a>
				</td>
				<td class='col-xs-1'>
				<input data-toggle='toggle' title='Service Active' class='checkbox services_status_checkbox' id='" . $serviceId . "' type='checkbox' ".$isActive.">
				</td>
				<td class='col-xs-2'>
				<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('".safeCleanStr($serviceTitle)."', 'services.php?loc_id=".$_GET['loc_id']."&preview=$serviceId')\"><i class='fa fa-fw fa-eye'></i></button>
				<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='services.php?loc_id=".$_GET['loc_id']."&deleteservice=$serviceId&deletetitle=".safeCleanStr(addslashes($serviceTitle))."'\"><i class='fa fa-fw fa-trash'></i></button>
				</td>
				</tr>";
				}
				?>
				</tbody>
			</table>
			<input type="hidden" name="service_count" value="<?php echo $serviceCount; ?>"/>
			<input type="hidden" name="save_main" value="true"/>
			<button type="submit" name="servicesNew_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save Changes</button>
			<button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
		</form>
	</div>

	<?php
	} //end of long else
	echo "</div>
	</div>
	<p></p>";

	include_once ('includes/footer.inc.php');
?>