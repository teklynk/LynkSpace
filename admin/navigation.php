<?php
define('inc_access', TRUE);

include 'includes/header.php';

	$getNavSection = $_GET['section'];

	//update table on submit
	if (!empty($_POST)) {

		if (!empty($_POST['nav_newname'])) {

			//Create new category if newcat is true
			if (!empty($_POST['nav_newcat']) AND $_POST['exist_cat']=="") {
				$navNewCat = "INSERT INTO category (name, nav_loc_id) VALUES ('".$_POST['nav_newcat']."', ".$_SESSION['loc_id'].")";
				mysqli_query($db_conn, $navNewCat);

				//get the new cat id
				$sqlNavCatID = mysqli_query($db_conn, "SELECT id, nav_loc_id FROM category WHERE nav_loc_id=".$_SESSION['loc_id']." ORDER BY id DESC LIMIT 1");
				$rowMaxCat = mysqli_fetch_array($sqlNavCatID);
				$navMaxCatId=$rowMaxCat[0];
			}

			if ($_POST['exist_cat']=="" AND $_POST['nav_newcat']>"") {

				$getTheCat=$navMaxCatId; //create & add new category name & get it's id

			} elseif ($_POST['exist_cat']>"" AND $_POST['nav_newcat']>"") {

				$getTheCat=$_POST['exist_cat']; //use existing category id

			} else {

				$getTheCat=0; //None

			}

			$navNew = "INSERT INTO navigation (name, url, sort, catid, section, win, loc_id) VALUES ('".$_POST['nav_newname']."', '".$_POST['nav_newurl']."', 0, $getTheCat, '".$getNavSection."','off', ".$_SESSION['loc_id'].")";
			mysqli_query($db_conn, $navNew);

		}

		for($i=0; $i<$_POST['nav_count']; $i++) {

			if ($_POST['nav_cat'][$i]=="") {
				$_POST['nav_cat'][$i]=0; //None
			}

			$navUpdate = "UPDATE navigation SET sort=".$_POST['nav_sort'][$i].", name='".$_POST['nav_name'][$i]."', url='".$_POST['nav_url'][$i]."', catid=".$_POST['nav_cat'][$i].", loc_id=".$_GET['loc_id']." WHERE id=".$_POST['nav_id'][$i]." ";
			mysqli_query($db_conn, $navUpdate);
		}

		$pageMsg="<div class='alert alert-success fade in' data-alert='alert'>The navigation has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
	}

	//loop through the array of navSections
	$navMenuStr = "";
	$navArrlength = count($navSections);

	for($x = 0; $x < $navArrlength; $x++) {

		if ($navSections[$x]==$_GET['section']) {

			$isSectionSelected="SELECTED";

		} else {

			$isSectionSelected="";

		}

		$navMenuStr = $navMenuStr."<option value=".$navSections[$x]." ".$isSectionSelected.">".$navSections[$x]."</option>";
	}
?>
	<div class="row">
		<div class="col-lg-10">
			<h1 class="page-header">
				Navigation (<?php echo $_GET['section'];?>)
			</h1>
		</div>

		<div class="col-lg-2">
			<div class="form-group">
				<label for="nav_menu">Navigation Sections</label>
				<select class="form-control input-sm" name="nav_menu" id="nav_menu" autofocus="autofocus">
					<?php echo $navMenuStr; ?>
				</select>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
		<?php

		if ($pageMsg != "") {
			echo $pageMsg;
		}

		//get and built pages list
		$pagesStr="";

		$sqlGetPages = mysqli_query($db_conn, "SELECT id, title, active, loc_id FROM pages WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY title");

		while ($rowGetPages = mysqli_fetch_array($sqlGetPages)) {

			$getPageId=$rowGetPages['id'];
			$getPageTitle=$rowGetPages['title'];
			$pagesStr = $pagesStr."<option value=".$getPageId.">".$getPageTitle."</option>";

		}

		$pagesStr = "<optgroup label='Existing Pages'>".$pagesStr."</optgroup>".$extraPages;

		//delete nav
		$deleteMsg="";
		$deleteConfirm="";
		$pageMsg="";
		$delNavId = $_GET['deletenav'];
		$delNavTitle = $_GET['deletename'];

		//Delete nav link
		if ($_GET['deletenav'] AND $_GET['deletename'] AND !$_GET['confirm']) {

			$deleteMsg="<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete ".$delNavTitle."? <a href='?section=".$getNavSection."&deletenav=".$delNavId."&deletename=".$delNavTitle."&loc_id=".$_GET['loc_id']."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deletenav'] AND $_GET['deletename'] AND $_GET['confirm']=='yes') {

			//delete nav after clicking Yes
			$navDelete = "DELETE FROM navigation WHERE id='$delNavId'";
			mysqli_query($db_conn, $navDelete);

			$deleteMsg="<div class='alert alert-success fade in' data-alert='alert'>".$delNavTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

		//delete category
		$delCatId = $_GET['deletecat'];
		$delCatTitle = $_GET['deletecatname'];

		//Delete category and set nav categories to zero
		if ($_GET['deletecat'] AND $_GET['deletecatname'] AND !$_GET['confirm']) {

			$deleteMsg="<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete ".$delCatTitle."? <a href='?section=".$getNavSection."&deletecat=".$delCatId."&deletecatname=".$delCatTitle."&loc_id=".$_GET['loc_id']."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deletecat'] AND $_GET['deletecatname'] AND $_GET['confirm']=='yes') {

			$navCatUpdate = "UPDATE navigation SET catid=0 WHERE loc_id=".$_GET['loc_id']." AND catid='$delCatId'";
			mysqli_query($db_conn, $navCatUpdate);

			//delete category after clicking Yes
			$navCatDelete = "DELETE FROM category WHERE id='$delCatId'";
			mysqli_query($db_conn, $navCatDelete);

			$deleteMsg="<div class='alert alert-success fade in' data-alert='alert'>".$delCatTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

		//rename category
		$renameMsg="";
		$renameConfirm="";
		$renameCatId = $_GET['renamecat'];
		$renameCatTitle = $_GET['newcatname'];

		//Rename category and set nav categories to new name
		if ($_GET['renamecat'] AND $_GET['newcatname'] AND !$_GET['confirm']) {
			$renameMsg="<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to rename ".$renameCatTitle."? <a href='?section=".$getNavSection."&renamecat=".$renameCatId."&newcatname=".$renameCatTitle."&loc_id=".$_GET['loc_id']."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $renameMsg;

		} elseif ($_GET['renamecat'] AND $_GET['newcatname'] AND $_GET['confirm']=='yes') {

			$navRenameCatUpdate = "UPDATE category SET name='".$renameCatTitle."' WHERE id='$renameCatId'";
			mysqli_query($db_conn, $navRenameCatUpdate);

			$renameMsg="<div class='alert alert-success fade in' data-alert='alert'>".$renameCatTitle." has been renamed.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $renameMsg;
		}

		// add category
		if ($_GET['addcatname'] > "") {
            $navAddCat = "INSERT INTO category (name, nav_loc_id) VALUES ('".$_GET['addcatname']."', ".$_SESSION['loc_id'].")";
            mysqli_query($db_conn, $navAddCat);

			echo "<script>window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_SESSION['loc_id']."&addcat=".$_GET['addcatname']."';</script>";

        }
        // add category message
        if (!empty($_GET['addcat'])) {
			$addMsg="<div class='alert alert-success fade in' data-alert='alert'>".$_GET['addcat']." category has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $addMsg;
		}
		?>
			<form name="navForm" method="post" action="">
				<fieldset>
					<div class="form-group">
						<label for="nav_newname">Link Name</label>
						<input type="text" class="form-control input-sm count-text" name="nav_newname" id="nav_newname" maxlength="255">
					</div>
					<div class="form-group">
						<label for="nav_newurl">Link URL</label>
						<input type="text" class="form-control input-sm count-text" name="nav_newurl" id="nav_newurl" maxlength="255">
					</div>
					<div class="form-group">
						<label for="exist_page">Existing Page</label>
						<select class="form-control input-sm" name="exist_page" id="exist_page">
							<?php
								echo "<option value=''>Custom</option>";
								echo $pagesStr;
							?>
						</select>
					</div>
				</fieldset>
				<hr/>
				<fieldset>
					<div class="form-group">
						<label for="nav_newcat">Category</label>
						<div class="input-group">
							<input type="text" class="form-control input-sm" name="nav_newcat" id="nav_newcat" maxlength="255">
                            <span class="input-group-addon" id="add_cat" ><i class='fa fa-fw fa-plus' style="color:#000; cursor:pointer;" data-toggle="tooltip" title="Add" onclick="window.location.href='?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&addcatname='+$('#nav_newcat').val();"></i></span>
                            <span class="input-group-addon" id="rename_cat" ><i class='fa fa-fw fa-save' style="visibility:hidden; color:#000; cursor:pointer;" data-toggle="tooltip" title="Rename" onclick="window.location.href='?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&renamecat='+$('#exist_cat').val()+'&newcatname='+$('#nav_newcat').val();"></i></span>
							<span class="input-group-addon" id="del_cat" ><i class='fa fa-fw fa-trash' style="visibility:hidden; color:#000; cursor:pointer;" data-toggle="tooltip" title="Delete" onclick="window.location.href='?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&deletecat='+$('#exist_cat').val()+'&deletecatname='+$('#nav_newcat').val();"></i></span>
						</div>
					</div>

					<div class="form-group">
						<label for="exist_cat">Existing Category</label>
						<select class="form-control input-sm" name="exist_cat" id="exist_cat">
							<?php
							echo "<option value='0'>None</option>";
							//get and built category list, find selected
							$sqlNavExistCat = mysqli_query($db_conn, "SELECT id, name, nav_loc_id FROM category WHERE nav_loc_id=".$_SESSION['loc_id']." ORDER BY name");
							while ($rowExistNavCat = mysqli_fetch_array($sqlNavExistCat)) {

								if ($rowExistNavCat['id'] != 0) {
									$navExistCatId = $rowExistNavCat['id'];
									$navExistCatName = $rowExistNavCat['name'];

									if ($navExistCatId == $navCat) {
										$isExistCatSelected = "SELECTED";
									} else {
										$isExistCatSelected = "";
									}

									echo "<option value=".$navExistCatId." ".$isExistCatSelected.">".$navExistCatName."</option>";
								}

							}
							?>
						</select>
					</div>
				</fieldset>
				<hr/>
				<table class="table table-bordered table-hover table-striped" id="nav_Table">
					<thead>
						<tr>
							<th>Sort</th>
							<th>Name</th>
							<th>URL</th>
							<th>Category</th>
							<th><i class="fa fa-fw fa-external-link"></i> External</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$navCount="";

						$sqlNav = mysqli_query($db_conn, "SELECT id, name, url, sort, win, catid, loc_id FROM navigation WHERE section='$getNavSection' AND loc_id=".$_GET['loc_id']." ORDER BY sort");
						while ($rowNav = mysqli_fetch_array($sqlNav)) {
							$navId=$rowNav['id'];
							$navName=$rowNav['name'];
							$navURL=$rowNav['url'];
							$navSort=$rowNav['sort'];
							$navWin=$rowNav['win'];
							$navCat=$rowNav['catid'];
							$navSection=$rowNav['section'];
							$navCount++;

							if ($navWin=='true') {
								$isActive="CHECKED";
							} else {
								$isActive="";
							}

							echo "<tr>
							<td class='col-xs-1'><input type='hidden' name='nav_id[]' value=".$navId." >
							<input class='form-control input-sm' name='nav_sort[]' value=".$navSort." type='text' maxlength='3'></td>
							<td><input class='form-control input-sm' name='nav_name[]' value='".$navName."' type='text'></td>
							<td><input class='form-control input-sm' name='nav_url[]' value='".$navURL."' type='text'></td>";
							echo "<td><select class='form-control input-sm' name='nav_cat[]'>'";
							echo "<option value='0'>None</option>";
							//get and built category list, find selected
							$sqlNavCat = mysqli_query($db_conn, "SELECT id, name, nav_loc_id FROM category WHERE nav_loc_id=".$_SESSION['loc_id']." ORDER BY name");
							while ($rowNavCat = mysqli_fetch_array($sqlNavCat)) {
								if ($rowNavCat['id'] != 0) {
									$navCatId = $rowNavCat['id'];
									$navCatName = $rowNavCat['name'];

									if ($navCatId == $navCat) {
										$isCatSelected = "SELECTED";
									} else {
										$isCatSelected = "";
									}

									echo "<option value=".$navCatId." ".$isCatSelected.">".$navCatName."</option>";
								}

							}

							echo "</select></td>
							<td class='col-xs-1'><input data-toggle='toggle' title='Open in a new window' class='checkbox nav_win_checkbox' id='$navId' type='checkbox' ".$isActive."></td>
							<td class='col-xs-1'><button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?section=".$getNavSection."&loc_id=".$_GET['loc_id']."&deletenav=$navId&deletename=".$navName."'\"><i class='fa fa-fw fa-trash'></i></button></td>
							</tr>";
						}

						echo "<input type='hidden' name='nav_count' value=".$navCount." >";
					?>
					</tbody>
				</table>

				<button type="submit" name="nav_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i>Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i>Reset</button>
			</form>

		</div>
	</div>

<?php
	include 'includes/footer.php';
?>
