<?php 
include 'includes/header.php';

	//update table on submit
	if (!empty($_POST)) {
		$setupUpdate = "UPDATE setup SET title='".$_POST["site_title"]."', author='".$_POST["site_author"]."', keywords='".$_POST["site_keywords"]."', description='".$_POST["site_description"]."', headercode='".mysql_real_escape_string($_POST["site_header"])."', disqus='".mysql_real_escape_string($_POST['site_disqus'])."', googleanalytics='".$_POST["site_google"]."', tinymce=".$_POST["site_tinymce"]." ";
		mysql_query($setupUpdate);
		$pageMsg="<div class='alert alert-success'>The setup section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='setup.php'\">×</button></div>";
	}
	
	$sqlSetup = mysql_query("SELECT title, author, description, keywords, headercode, disqus, googleanalytics, tinymce FROM setup");
	$row  = mysql_fetch_array($sqlSetup);
	
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Setup
				<small></small>
			</h1>
		</div>
	</div>
   <div class="row">
		<div class="col-lg-8">
		<?php 
		if ($pageMsg !="") {
			echo $pageMsg;
		}
		?>
			<form role="setupForm" method="post" action="setup.php">

				<div class="form-group">
					<label>Site Title</label>
					<input class="form-control input-sm" name="site_title" value="<?php echo $row['title']; ?>" placeholder="My Portfolio Site">
				</div>
				  <div class="form-group">
					<label>Author</label>
					<input class="form-control input-sm" name="site_author" value="<?php echo $row['author']; ?>" placeholder="John Doe">
				</div>
				<div class="form-group">
					<label>Keywords</label>
					<textarea class="form-control input-sm" name="site_keywords" rows="3" maxlength="255"><?php echo $row['keywords']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control input-sm" name="site_description" rows="3" maxlength="255"><?php echo $row['description']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Header Code</label>
					<textarea class="form-control input-sm" name="site_header" rows="3" placeholder="Add javascript to your main page header"><?php echo $row['headercode']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Disqus.com Universal Code <small><a href="https://disqus.com/admin/universalcode/" target="_blank">Setup Instructions</a></small></label>
					<textarea class="form-control input-sm" name="site_disqus" rows="3" placeholder="Add Disqus comment system to your web pages"><?php echo $row['disqus']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Google Analytics</label>
					<input class="form-control input-sm" name="site_google" value="<?php echo $row['googleanalytics']; ?>" placeholder="UA-XXXX-Y">
				</div>
				<?php
					if ($row['tinymce']==1) {
						$selEditor1="SELECTED";
						$selEditor0="";
					} else {
						$selEditor0="SELECTED";
						$selEditor1="";
					}
				?>
				<div class="form-group">
					<label>TinyMCE / WYSIWYG Editor</label>
					<select class="form-control input-sm" name="site_tinymce">
						<option value="1" <?php echo $selEditor1; ?>>On</option>
						<option value="0" <?php echo $selEditor0; ?>>Off</option>
					</select>
				</div>
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
					<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
					<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

			</form>

		</div>
	</div>
<?php
include 'includes/footer.php';
?>
