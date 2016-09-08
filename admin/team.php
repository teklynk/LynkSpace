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
		$sqlteamPreview = mysql_query("SELECT id, title, image, content, name FROM team WHERE id='$pagePreviewId'");
		$row  = mysql_fetch_array($sqlteamPreview);
			
			echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";			
			echo "<div class='col-lg-12'>";
			if ($row["image"]>""){
				echo "<p><img src=../uploads/".$row['image']." style='max-width:350px; max-height:150px;' /></p>";
			}
			if ($row["name"]>""){
				echo "<h4>".$row['name']."</h4>";
			}
			if ($row["title"]>""){
				echo "<p>".$row['title']."</p>";
			}
			echo "<p>".$row['content']."</p>";
			echo "</div>";
	}
?>
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $rowSetup["teamheading"]?>
            </h1>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
<?php

	if ($_GET["newteam"] OR $_GET["editteam"]) {
		$teamMsg="";
		
		//Update existing team
		if ($_GET["editteam"]) {
			$theteamId = $_GET["editteam"];
			$teamLabel = "Edit Team Title";
			
			//update data on submit
			if (!empty($_POST["team_title"])) {
				$teamUpdate = "UPDATE team SET title='".$_POST["team_title"]."', content='".$_POST["team_content"]."', name='".$_POST["team_name"]."', image='".$_POST["team_image"]."', active=".$_POST["team_status"].", datetime='".date("Y-m-d H:i:s")."' WHERE id='$theteamId'";
				mysql_query($teamUpdate);
				$teamMsg="<div class='alert alert-success'>The team member ".$_POST["team_name"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			}
			
			$sqlteam = mysql_query("SELECT id, title, image, content, name, active, datetime FROM team WHERE id='$theteamId'");
			$row  = mysql_fetch_array($sqlteam);
			
		//Create new team
		} else if ($_GET["newteam"]) {
			$teamLabel = "New Team Title";
			//insert data on submit
			if (!empty($_POST["team_title"])) {
				$teamInsert = "INSERT INTO team (title, content, image, name, active) VALUES ('".$_POST["team_name"]."', '".$_POST["team_content"]."', '".$_POST["team_image"]."', '".$_POST["team_name"]."', ".$_POST["team_status"].")";
				mysql_query($teamInsert);
				$teamMsg="<div class='alert alert-success'>The team member ".$_POST["team_name"]." has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			}
		} 
        
		//alert messages
		if ($uploadMsg !="") {
			echo $uploadMsg;
		}
		
		if ($teamMsg !="") {
			echo $teamMsg;
		}
		
		if ($_GET["editteam"]){ 
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
			$thumbNail = "http://placehold.it/140x100&text=No Image";
		} else {
			$thumbNail = "../uploads/".$row["image"];
		}
?>

	<form role="teamForm" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Status</label>
            <select class="form-control input-sm" name="team_status">
                <option value="1" <?php if($_GET["editteam"]){echo $selActive1;} ?>>Active</option>
                <option value="0" <?php if($_GET["editteam"]){echo $selActive0;} ?>>Draft</option>
            </select>
        </div>
        <hr/>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group">
        	<img src="<?php echo $thumbNail;?>" id="team_image_preview" style="max-width:140px; height:auto;"/>
        </div>
		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control input-sm" name="team_image" id="team_image">
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
		<hr/>
		<div class="form-group">
			<label>Name</label>
			<input class="form-control input-sm" name="team_name" value="<?php if($_GET["editteam"]){echo $row['name'];} ?>" placeholder="Name">
		</div>
		<div class="form-group">
			<label>Title</label>
			<input class="form-control input-sm" name="team_title" value="<?php if($_GET["editteam"]){echo $row['title'];} ?>" placeholder="Title">
		</div>
		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control input-sm" rows="3" name="team_content" placeholder="Text" maxlength="255"><?php if($_GET["editteam"]){echo $row['content'];} ?></textarea>
		</div>
        <div class="form-group">
			<span><?php if($_GET["editteam"]){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($row['datetime']));} ?></span>
		</div>
		<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$teamMsg="";
		$delteamId = $_GET["deleteteam"];
		$delteamTitle = $_GET["deletetitle"];
		$moveteamId = $_GET["moveteam"];
		$moveteamTitle = $_GET["movetitle"];
		
		//delete team
		if ($_GET["deleteteam"] AND $_GET["deletetitle"] AND !$_GET["confirm"]) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delteamTitle."? <a href='?deleteteam=".$delteamId."&deletetitle=".$delteamTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			echo $deleteMsg;
		} elseif ($_GET["deleteteam"] AND $_GET["deletetitle"] AND $_GET["confirm"]=="yes") {
			//delete team after clicking Yes
			$teamDelete = "DELETE FROM team WHERE id='$delteamId'";
			mysql_query($teamDelete);
			$deleteMsg="<div class='alert alert-success'>".$delteamTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			echo $deleteMsg;
		}
		
	//move team to top of list
    if (($_GET["moveteam"] AND $_GET["movetitle"])) {
        $teamDateUpdate = "UPDATE team SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$moveteamId'";
        mysql_query($teamDateUpdate);
        $teamMsg="<div class='alert alert-success'>".$moveteamTitle." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
    }
		
    //update heading on submit
    if (($_POST["save_main"])) {
        $setupUpdate = "UPDATE setup SET teamheading='".$_POST["team_heading"]."', teamcontent='".$_POST["main_content"]."'";
        mysql_query($setupUpdate);
        $teamMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
    }
		
    $sqlSetup = mysql_query("SELECT teamheading, teamcontent FROM setup");
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

	<button type="button" class="btn btn-default" onclick="window.location='?newteam=true';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Team Member</button>
		<h2></h2>
		<div class="table-responsive">
    <?php 
		if ($teamMsg !="") {
			echo $teamMsg;
		}
		?>
			<form role="teamForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm" name="team_heading" value="<?php echo $rowSetup['teamheading']; ?>" placeholder="My team">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control input-sm" name="main_content" placeholder="About our team" maxlength="255"><?php echo $rowSetup['teamcontent']; ?></textarea>
            </div>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
        		<?php 
					$sqlteam = mysql_query("SELECT id, title, image, content, name, active FROM team ORDER BY datetime DESC");
					while ($row  = mysql_fetch_array($sqlteam)) {
						$teamId=$row['id'];
						$teamTitle=$row['title'];
						$teamName=$row['name'];
						$teamTumbnail=$row['image'];
						$teamContent=$row['content'];
						$teamActive=$row['active'];
						if ($row['active']==0){
							$isActive="<i style='color:red;'>(Draft)</i>";
						} else {
							$isActive="";
						}
						echo "<tr>
						<td><a href='?editteam=$teamId' title='Edit'>".$teamName."</a></td>
						<td class='col-xs-1'>
						<span>".$isActive."</span>
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$teamName', '?preview=$teamId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='?moveteam=$teamId&movetitle=$teamName'\"><i class='fa fa-fw fa-arrow-up'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?deleteteam=$teamId&deletetitle=$teamName'\"><i class='fa fa-fw fa-trash'></i></button>
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
