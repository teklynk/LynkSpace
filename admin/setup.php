<?php
define('inc_access', TRUE);

include 'includes/header.php';

	//Get max location ID number
	$sqlLocationMaxID = mysqli_query($db_conn, "SELECT MAX(id) FROM locations ORDER BY id DESC LIMIT 1");
	$rowLocationMaxID = mysqli_fetch_array($sqlLocationMaxID);

	$locationNewID = $rowLocationMaxID[0]+1;

	//Get location table columns
	$sqlLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE id=".$_GET['loc_id']." ");
	$rowLocation = mysqli_fetch_array($sqlLocation);

	//Get setup table columns
	$sqlSetup = mysqli_query($db_conn, "SELECT title, author, description, keywords, headercode, config, ls2pac, ls2kids, logo, disqus, googleanalytics, tinymce, loc_id FROM setup WHERE loc_id=".$_GET['loc_id']." ");
	$rowSetup = mysqli_fetch_array($sqlSetup);

	//update table on submit
	if (!empty($_POST)) {
		if (!empty($_POST['site_title'])) {
			$site_keywords = filter_var($_POST['site_keywords'], FILTER_SANITIZE_STRING);
			$site_author = filter_var($_POST['site_author'], FILTER_SANITIZE_STRING);
			$site_description = filter_var($_POST['site_description'], FILTER_SANITIZE_STRING);

			//update table on submit
			if ($rowSetup['loc_id'] == $_GET['loc_id']) {
				//Update Setup
				$setupUpdate = "UPDATE setup SET title='".$_POST['site_title']."', author='".$site_author."', keywords='".mysqli_real_escape_string($db_conn, $site_keywords)."', description='".mysqli_real_escape_string($db_conn, $site_description)."', headercode='".mysqli_real_escape_string($db_conn, $_POST['site_header'])."', config='".$_POST['site_config']."', logo='".mysqli_real_escape_string($db_conn, $_POST['site_logo'])."', disqus='".mysqli_real_escape_string($db_conn, $_POST['site_disqus'])."', googleanalytics='".$_POST['site_google']."', tinymce=".$_POST['site_tinymce']." WHERE loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $setupUpdate);
				//Update Location
				$locationUpdate = "UPDATE locations SET name='".$_POST['location_name']."' WHERE id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $locationUpdate);
			} else {
				//Insert Setup
				$setupInsert = "INSERT INTO setup (title, author, description, keywords, headercode, config, logo, disqus, googleanalytics, tinymce, loc_id) VALUES ('".$_POST['site_title']."', '".$site_author."', '".mysqli_real_escape_string($db_conn, $site_description)."', '".mysqli_real_escape_string($db_conn, $site_keywords)."', '".mysqli_real_escape_string($db_conn, $_POST['site_header'])."', '".$_POST['site_config']."', '".$_POST['site_logo']."', '".mysqli_real_escape_string($db_conn, $_POST['site_disqus'])."', '".$_POST['site_google']."', ".$_POST['site_tinymce'].", ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $setupInsert);
				//Insert Location
				$locationInsert = "INSERT INTO locations (id, name, active) VALUES (".$_GET['loc_id'].", '".$_POST['location_name']."', 'true')";
				mysqli_query($db_conn, $locationInsert);
			}

			echo "<script>window.location.href='setup.php?loc_id=".$_GET['loc_id']."&update=true';</script>";

		}
	}

    if ($_GET['update']=='true') {
        $pageMsg = "<div class='alert alert-success'>The setup section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='setup.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
    }
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Setup <?php if($_GET['newlocation'] == 'true'){echo "(New)";}?>
				<small></small>
			</h1>
		</div>
	</div>
   <div class="row">
		<div class="col-lg-8">
		<?php
		//Check if user_level is Admin user
		if ($_SESSION['user_level'] == 1 AND !$_GET['newlocation'] == 'true') {
		?>
			<button type="button" class="btn btn-default" onclick="window.location='?newlocation=true&loc_id=<?php echo $locationNewID; ?>';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Location</button>
			<h2></h2>
		<?php
		}

		if ($pageMsg != "") {
			echo $pageMsg;
		}

		if ($rowSetup['ls2pac'] == 'true') {
			$isActive_ls2pac="CHECKED";
		} else {
			$isActive_ls2pac="";
		}

		if ($rowSetup['ls2kids'] == 'true') {
			$isActive_ls2kids="CHECKED";
		} else {
			$isActive_ls2kids="";
		}

		if ($rowSetup['logo']=="") {
			$logo = "http://placehold.it/140x100&text=No Image";
		} else {
			$logo = "../uploads/".$_GET['loc_id']."/".$rowSetup['logo'];
		}
		?>
			<form role="setupForm" name="setupForm" method="post" action="">

				<div class="form-group">
					<label>Site Title</label>
					<input class="form-control input-sm count-text" name="site_title" maxlength="255" value="<?php echo $rowSetup['title']; ?>" placeholder="My Portfolio Site">
				</div>
				  <div class="form-group">
					<label>Author</label>
					<input class="form-control input-sm count-text" name="site_author" maxlength="255" value="<?php echo $rowSetup['author']; ?>" placeholder="John Doe">
				</div>
				<div class="form-group">
					<label>Keywords</label>
					<textarea class="form-control input-sm count-text" name="site_keywords" rows="3" maxlength="255"><?php echo $rowSetup['keywords']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control input-sm count-text" name="site_description" rows="3" maxlength="255"><?php echo $rowSetup['description']; ?></textarea>
				</div>
				<hr/>
				<div class="form-group">
					<label>PAC Settings</label>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label>Location Name</label>
							<input class="form-control input-sm count-text" name="location_name" maxlength="255" value="<?php echo $rowLocation['name']; ?>">
						</div>
					</div>
				</div>

				<div class="form-group">
					<img src="<?php echo $logo;?>" id="site_logo_preview" style="max-width:140px; height:auto; display:block;"/>
				</div>
				<div class="form-group">
					<label>Choose a Logo</label>
					<select class="form-control input-sm" name="site_logo" id="site_logo">
						<option value="">None</option>
						<?php
						if ($handle = opendir($target_dir)) {

							while (false !== ($file = readdir($handle))) {
								if ('.' === $file) continue;
								if ('..' === $file) continue;
								if ($file==="Thumbs.db") continue;
								if ($file===".DS_Store") continue;
								if ($file==="index.html") continue;

								if ($file===$rowSetup['logo']){
									$logoCheck="SELECTED";
								} else {
									$logoCheck="";
								}

								echo "<option value=".$file." $logoCheck>".$file."</option>";
							}

							closedir($handle);
						}
						?>
					</select>
				</div>

				<div class="row">
					<div class="col-lg-2">
						<div class="form-group">
							<label>PAC Config</label>
							<input class="form-control input-sm count-text" name="site_config" maxlength="10" value="<?php echo $rowSetup['config']; ?>" placeholder="1234">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group" id="searchoptions">
							<label>PAC Search Options</label>
							<div class="checkbox">
								<label>
									<input class="searchopt_checkbox" id="ls2pac" type="checkbox" <?php echo $isActive_ls2pac; ?> data-toggle="toggle">
									LS2PAC
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input class="searchopt_checkbox" id="ls2kids" type="checkbox" <?php echo $isActive_ls2kids; ?> data-toggle="toggle">
									LS2Kids
								</label>
							</div>
						</div>
					</div>
				</div>

                <input type="hidden" name="site_header" value="">

				<input type="hidden" name="site_disqus" value="">

				<input type="hidden" name="site_google" value="">

				<input type="hidden" name="site_tinymce" value="1">

				<hr/>
				<div class="form-group">
					<label>Other Settings</label>
				</div>
				<div class="form-group">
					<label><a href="users.php">Change User Info</a></label>
				</div>
				<div class="form-group">
					<?php
					if (file_exists('../sitemap.xml')) {
						echo "<label><a href='sitemapbuilder.php'>Update Sitemap.xml</a></label>";
						echo "<br/><small>Sitemap Updated: ".date('m-d-Y, H:i:s',filemtime('../sitemap.xml'))."</small>";
					}
					?>
				</div>

				<button type="submit" name="setup_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

			</form>

		</div>
	</div>
<?php
	include 'includes/footer.php';
?>
