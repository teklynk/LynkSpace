<?php 
define('inc_access', TRUE);

include 'includes/header.php';

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	$uploadMsg = "<div class='alert alert-success'>The file ". basename( $_FILES["fileToUpload"]["name"]) ." has been uploaded.<button type='button' class='close' data-dismiss='alert'>×</button></div>";
} else {
	$uploadMsg = "";
}

//Page preview
if ($_GET["preview"]>""){
	$pagePreviewId=$_GET["preview"];
	$sqlServicesPreview = mysqli_query($db_conn, "SELECT id, title, icon, image, content, link FROM services WHERE id='$pagePreviewId'");
	$row  = mysqli_fetch_array($sqlServicesPreview);
	echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";        
	echo "<div class='col-lg-12'>";

		if ($row["icon"]>""){
			echo "<p style='font-size:6.0em;'><i class='fa fa-fw fa-".$row["icon"]."'></i></p><br/>";
		}
		if ($row["image"]>""){
			echo "<p><img src=../uploads/".$row['image']." style='max-width:350px; max-height:150px;' /></p>";
		}
        if ($row["title"]>""){
			echo "<h4>".$row['title']."</h4>";
		}
		echo "<p>".$row['content']."</p>";

		if ($row["link"]>0){
			echo "<br/><p><i class='fa fa-fw fa-external-link'></i> <a href='../page.php?ref=".$row['link']."' target='_blank'>Page Link</a></p>";
		}
		echo "</div>";
}
?>
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $rowSetup["servicesheading"]?>
            </h1>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
<?php

	if ($_GET["newservice"] OR $_GET["editservice"]) {
		$serviceMsg="";
		
		//Update existing service
		if ($_GET["editservice"]) {
			$theserviceId = $_GET["editservice"];
			$serviceLabel = "Edit Service Title";
			
			//update data on submit
			if (!empty($_POST["service_title"])) {
				$servicesUpdate = "UPDATE services SET title='".$_POST["service_title"]."', content='".$_POST["service_content"]."', link=".$_POST["service_link"].", icon='".$_POST["service_icon_select"]."', image='".$_POST["service_image_select"]."', active=".$_POST["service_status"].",datetime='".date("Y-m-d H:i:s")."' WHERE id='$theserviceId'";
				mysqli_query($db_conn, $servicesUpdate);
				$serviceMsg="<div class='alert alert-success'>The service ".$_POST["service_title"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
			}
			
			$sqlServices = mysqli_query($db_conn, "SELECT id, title, icon, image, content, link, active, datetime FROM services WHERE id='$theserviceId'");
			$row  = mysqli_fetch_array($sqlServices);
			
		//Create new service
		} else if ($_GET["newservice"]) {
			$serviceLabel = "New Service Title";
			//insert data on submit
			if (!empty($_POST["service_title"])) {
				$servicesInsert = "INSERT INTO services (title, content, icon, image, link, active) VALUES ('".$_POST["service_title"]."', '".$_POST["service_content"]."', '".$_POST["service_icon_select"]."', '".$_POST["service_image_select"]."', ".$_POST["service_link"].", ".$_POST["service_status"].")";
				mysqli_query($db_conn, $servicesInsert);
				$serviceMsg="<div class='alert alert-success'>The service ".$_POST["service_title"]." has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
			}
		} 
        
		//alert messages
		if ($uploadMsg !="") {
			echo $uploadMsg;
		}
		
		if ($serviceMsg !="") {
			echo $serviceMsg;
		}
		
		if ($_GET["editservice"]){ 
			//active status		
			if ($row['active']==1) {
				$selActive1="SELECTED";
				$selActive0="";
			} else {
				$selActive0="SELECTED";
				$selActive1="";
			}
		}
?>

	<form role="serviceForm" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Status</label>
            <select class="form-control input-sm" name="service_status">
                <option value="1" <?php if($_GET["editservice"]){echo $selActive1;} ?>>Active</option>
                <option value="0" <?php if($_GET["editservice"]){echo $selActive0;} ?>>Draft</option>
            </select>
        </div>
		<div class="form-group">
			<label><?php echo $serviceLabel; ?></label>
			<input class="form-control input-sm" name="service_title" value="<?php if($_GET["editservice"]){echo $row['title'];} ?>" placeholder="Service Title">
		</div>
		<hr/>
		<div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
    	</div>
		<div class="form-group"> 
			<i id="service_icon" style="font-size:6.0em;" class="fa fa-fw fa-<?php echo $row["icon"]; ?>"></i>
		</div>
		<div class="form-group">
		<?php

	        if ($row["image"]=="") {
				$imgSrc = "http://placehold.it/2/ffffff/ffffff"; //small image just to give the source a value
			} else {
				$imgSrc = "../uploads/".$row["image"];
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
						if ($icon===$row['icon']){
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
							if ($file===$row['image']){
								$imageCheck="SELECTED";
							} else {
								$imageCheck="";
							}
							echo "<option value=".$file." ".$imageCheck.">".$file."</option>";
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
					$sqlServicesLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active=1 ORDER BY title ASC");
					while ($rowLink = mysqli_fetch_array($sqlServicesLink)) {
						$serviceLinkId=$rowLink['id'];
						$serviceLinkTitle=$rowLink['title'];

						if ($serviceLinkId===$row['link']){
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
			<textarea class="form-control input-sm" rows="3" name="service_content" placeholder="Text" maxlength="255"><?php if($_GET["editservice"]){echo $row['content'];} ?></textarea>
		</div>
        <div class="form-group">
			<span><?php if($_GET["editservice"]){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($row['datetime']));} ?></span>
		</div>
		<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$serviceMsg="";
		$delserviceId = $_GET["deleteservice"];
		$delserviceTitle = $_GET["deletetitle"];
		$moveserviceId = $_GET["moveservice"];
		$moveserviceTitle = $_GET["movetitle"];
		
		//delete service
		if ($_GET["deleteservice"] AND $_GET["deletetitle"] AND !$_GET["confirm"]) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delserviceTitle."? <a href='?deleteservice=".$delserviceId."&deletetitle=".$delserviceTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
			echo $deleteMsg;
		} elseif ($_GET["deleteservice"] AND $_GET["deletetitle"] AND $_GET["confirm"]=="yes") {
			//delete service after clicking Yes
			$servicesDelete = "DELETE FROM services WHERE id='$delserviceId'";
			mysqli_query($db_conn, $servicesDelete);
			$deleteMsg="<div class='alert alert-success'>".$delserviceTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
			echo $deleteMsg;
		}
		
	//move services to top of list
    if (($_GET["moveservice"] AND $_GET["movetitle"])) {
        $servicesDateUpdate = "UPDATE services SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$moveserviceId'";
        mysqli_query($db_conn, $servicesDateUpdate);
        $serviceMsg="<div class='alert alert-success'>".$moveserviceTitle." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
    }
		
    //update heading on submit
    if (($_POST["save_main"])) {
        $setupUpdate = "UPDATE setup SET servicesheading='".$_POST["main_heading"]."', servicescontent='".$_POST["main_content"]."'";
        mysqli_query($db_conn, $setupUpdate);
        $serviceMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
    }
		
    $sqlSetup = mysqli_query($db_conn, "SELECT servicesheading, servicescontent FROM setup");
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

	<button type="button" class="btn btn-default" onclick="window.location='?newservice=true';"><i class='fa fa-fw fa-paper-plane'></i> Add a New service</button>
		<h2></h2>
		<div class="table-responsive">
    <?php 
		if ($serviceMsg !="") {
			echo $serviceMsg;
		}
		?>
			<form role="servicesForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm" name="main_heading" value="<?php echo $rowSetup['servicesheading']; ?>" placeholder="My Services">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control input-sm" name="main_content" placeholder="About our services" maxlength="255"><?php echo $rowSetup['servicescontent']; ?></textarea>
            </div>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Service Title</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
        		<?php 
					$sqlServices = mysqli_query($db_conn, "SELECT id, title, icon, content, link, active FROM services ORDER BY datetime DESC");
					while ($row  = mysqli_fetch_array($sqlServices)) {
						$serviceId=$row['id'];
						$serviceTitle=$row['title'];
						$serviceTumbnail=$row['icon'];
						$serviceContent=$row['content'];
						$serviceActive=$row['active'];
						if ($row['active']==0){
							$isActive="<i style='color:red;'>(Draft)</i>";
						} else {
							$isActive="";
						}
						echo "<tr>
						<td><a href='?editservice=$serviceId' title='Edit'>".$serviceTitle."</a></td>
						<td class='col-xs-1'>
						<span>".$isActive."</span>
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$serviceTitle', '?preview=$serviceId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='?moveservice=$serviceId&movetitle=$serviceTitle'\"><i class='fa fa-fw fa-arrow-up'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?deleteservice=$serviceId&deletetitle=$serviceTitle'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
					}
				?>
				</tbody>
			</table>
			<input type="hidden" name="save_main" value="true" />
            <button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
			</form>
		</div>
<?php
	}
?>
		</div>
	</div>
	<p></p>

<?php
include 'includes/footer.php';
?>
