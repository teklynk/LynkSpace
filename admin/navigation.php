<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'navigation.php';

$getNavSection = $_GET['section'];

//update table on submit
if (!empty($_POST)) {

    if (!empty($_POST['nav_newname'])) {

        //Create new category if newcat is true
        if (!empty($_POST['nav_newcat']) && $_POST['exist_cat'] == "") {
            $navNewCat = "INSERT INTO category_navigation (name, author_name, datetime, nav_loc_id) VALUES ('" . safeCleanStr($_POST['nav_newcat']) . "', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $navNewCat);

            //get the new cat id
            $sqlNavCatID = mysqli_query($db_conn, "SELECT id, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " ORDER BY id DESC LIMIT 1");
            $rowMaxCat = mysqli_fetch_array($sqlNavCatID);
            $navMaxCatId = $rowMaxCat[0];
        }

        if ($_POST['exist_cat'] == "" && $_POST['nav_newcat'] > "") {

            $getTheCat = $navMaxCatId; //create & add new category name & get it's id

        } elseif ($_POST['exist_cat'] > "" && $_POST['nav_newcat'] > "") {

            $getTheCat = $_POST['exist_cat']; //use existing category id

        } else {

            $getTheCat = 0; //None

        }

        $navNew = "INSERT INTO navigation (name, url, sort, catid, section, win, author_name, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['nav_newname']) . "', '" . $_POST['nav_newurl'] . "', 0, $getTheCat, '" . $getNavSection . "','off', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
        mysqli_query($db_conn, $navNew);

    }

    for ($i = 0; $i < $_POST['nav_count']; $i++) {

        if ($_POST['nav_cat'][$i] == "") {
            $_POST['nav_cat'][$i] = 0; //None
        }

        $navUpdate = "UPDATE navigation SET sort=" . $_POST['nav_sort'][$i] . ", name='" . safeCleanStr($_POST['nav_name'][$i]) . "', url='" . trim($_POST['nav_url'][$i]) . "', catid=" . $_POST['nav_cat'][$i] . ", author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "', loc_id=" . $_GET['loc_id'] . " WHERE id=" . $_POST['nav_id'][$i] . " ";
        mysqli_query($db_conn, $navUpdate);
    }

    $pageMsg = "<div class='alert alert-success fade in' data-alert='alert'>The navigation has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}

//loop through the array of navSections
$navMenuStr = "";
$navArrlength = count($navSections);

for ($x = 0; $x < $navArrlength; $x++) {

    if ($navSections[$x] == $_GET['section']) {

        $isSectionSelected = "SELECTED";

    } else {

        $isSectionSelected = "";

    }

    $navMenuStr .= "<option value=" . $navSections[$x] . " " . $isSectionSelected . ">" . $navSections[$x] . "</option>";

    $navSectionFirstItem = $navSections[0];
}

//Redirect to section=top if section is not in querystring
if ($_GET['section'] == "" && $_GET['loc_id']) {
    header("Location: navigation.php?section=" . $navSectionFirstItem . "&loc_id=" . $_GET['loc_id'] . "");
    echo "<script>window.location.href='navigation.php?section=" . $navSectionFirstItem . "&loc_id=" . $_GET['loc_id'] . "';</script>";
}

//check if using default location
$sqlSetup = mysqli_query($db_conn, "SELECT navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3 FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowSetup = mysqli_fetch_array($sqlSetup);

//set Default toggle depending on which navigation you are on
if ($_GET['section'] == $navSections[0]) {
    $navSubSection = "1";
    //use default view
    if ($rowSetup['navigation_use_defaults_1'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }
} elseif ($_GET['section'] == $navSections[1]){
    $navSubSection = "2";
    //use default view
    if ($rowSetup['navigation_use_defaults_2'] == 'true') {
        $selDefaults = "CHECKED";
        $navSubSection = "2";
    } else {
        $selDefaults = "";
    }
} elseif ($_GET['section'] == $navSections[2]){
    $navSubSection = "3";
    //use default view
    if ($rowSetup['navigation_use_defaults_3'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }
}
?>
    <div class="row">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li><a href="navigation.php?loc=<?php echo $_GET['loc_id'] ?>">Navigation</a></li>
                <li class="active"><?php echo $_GET['section']; ?></li>
            </ol>
            <h1 class="page-header">
                Navigation (<?php echo $_GET['section']; ?>)
            </h1>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="nav_menu">Navigation Sections</label>
                <select class="form-control" name="nav_menu" id="nav_menu">
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
            $pagesStr = "";

            $sqlGetPages = mysqli_query($db_conn, "SELECT id, title, active, loc_id FROM pages WHERE active='true' AND loc_id=" . $_GET['loc_id'] . " ORDER BY title");

            while ($rowGetPages = mysqli_fetch_array($sqlGetPages)) {

                $getPageId = $rowGetPages['id'];
                $getPageTitle = $rowGetPages['title'];
                $pagesStr .= "<option value=" . $getPageId . ">" . $getPageTitle . "</option>";

            }

            $pagesStr = "<optgroup label='Existing Pages'>" . $pagesStr . "</optgroup>" . $extraPages;

            //delete nav
            $deleteMsg = "";
            $deleteConfirm = "";
            $pageMsg = "";
            $delNavId = $_GET['deletenav'];
            $delNavTitle = safeCleanStr($_GET['deletename']);

            //Delete nav link
            if ($_GET['deletenav'] && $_GET['deletename'] && !$_GET['confirm']) {

                $deleteMsg = "<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete " . safeCleanStr($delNavTitle) . "? <a href='?section=" . $getNavSection . "&deletenav=" . $delNavId . "&deletename=" . $delNavTitle . "&loc_id=" . $_GET['loc_id'] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;

            } elseif ($_GET['deletenav'] && $_GET['deletename'] && $_GET['confirm'] == 'yes') {

                //delete nav after clicking Yes
                $navDelete = "DELETE FROM navigation WHERE id='$delNavId'";
                mysqli_query($db_conn, $navDelete);

                $deleteMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr($delNavTitle) . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //delete category
            $delCatId = $_GET['deletecat'];
            $delCatTitle = $_GET['deletecatname'];

            //Delete category and set nav categories to zero
            if ($_GET['deletecat'] && $_GET['deletecatname'] && !$_GET['confirm']) {

                $deleteMsg = "<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete " . safeCleanStr($delCatTitle) . "? <a href='?section=" . $getNavSection . "&deletecat=" . $delCatId . "&deletecatname=" . $delCatTitle . "&loc_id=" . $_GET['loc_id'] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;

            } elseif ($_GET['deletecat'] && $_GET['deletecatname'] && $_GET['confirm'] == 'yes') {

                $navCatUpdate = "UPDATE navigation SET catid=0, author_name='" . $_SESSION['user_name'] . "' WHERE loc_id=" . $_GET['loc_id'] . " AND catid='$delCatId'";
                mysqli_query($db_conn, $navCatUpdate);

                //delete category after clicking Yes
                $navCatDelete = "DELETE FROM category_navigation WHERE id='$delCatId'";
                mysqli_query($db_conn, $navCatDelete);

                $deleteMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr($delCatTitle) . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //rename category
            $renameMsg = "";
            $renameConfirm = "";
            $renameCatId = $_GET['renamecat'];
            $renameCatTitle = $_GET['newcatname'];

            //Rename category and set nav categories to new name
            if ($_GET['renamecat'] && $_GET['newcatname'] && !$_GET['confirm']) {
                $renameMsg = "<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to rename " . safeCleanStr($renameCatTitle) . "? <a href='?section=" . $getNavSection . "&renamecat=" . $renameCatId . "&newcatname=" . $renameCatTitle . "&loc_id=" . $_GET['loc_id'] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $renameMsg;

            } elseif ($_GET['renamecat'] && $_GET['newcatname'] && $_GET['confirm'] == 'yes') {

                $navRenameCatUpdate = "UPDATE category_navigation SET name='" . safeCleanStr($renameCatTitle) . "', nav_section='" . safeCleanStr($_GET['section']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id='$renameCatId'";
                mysqli_query($db_conn, $navRenameCatUpdate);

                $renameMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr($renameCatTitle) . " has been renamed.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $renameMsg;
            }

            // add category
            if ($_GET['addcatname'] > "") {
                $navAddCat = "INSERT INTO category_navigation (name, nav_section, author_name, datetime, nav_loc_id) VALUES ('" . safeCleanStr($_GET['addcatname']) . "', '" . safeCleanStr($_GET['section']) . "', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
                mysqli_query($db_conn, $navAddCat);

                echo "<script>window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_SESSION['loc_id'] . "&addcat=" . $_GET['addcatname'] . "';</script>";

            }

            // add category message
            if (!empty($_GET['addcat'])) {
                $addMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . $_GET['addcat'] . " category has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $addMsg;
            }

            if ($_GET['loc_id'] != 1) {
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="navigationdefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="navigation_defaults_checkbox_<?php echo $navSubSection ?>" id="<?php echo $_GET['loc_id'] ?>" name="navigation_defaults_<?php echo $navSubSection ?>" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <?php
            }
            ?>

            <!-- Category Section -->
            <button type="button" class="btn btn-primary" data-toggle="collapse" id="addCat_button" data-target="#addCatDiv">
                <i class='fa fa-fw fa-plus'></i> Add / Edit a Category
            </button>
            <h2></h2>

            <div id="addCatDiv" class="accordion-body collapse panel-body">

                <fieldset class="well">
                    <div class="form-group">
                        <label for="nav_newcat">Category</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nav_newcat" id="nav_newcat" maxlength="255" data-toggle="tooltip" title="Create a new category first, and then create the associated links.">
                            <span class="input-group-addon" id="add_cat"><i class='fa fa-fw fa-plus' style="color:#337ab7; cursor:pointer;" data-toggle="tooltip" title="Add" onclick="window.location.href='navigation.php?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&addcatname='+$('#nav_newcat').val();"></i></span>
                            <span class="input-group-addon" id="rename_cat"><i class='fa fa-fw fa-save' style="visibility:hidden; color:#337ab7; cursor:pointer;" data-toggle="tooltip" title="Save" onclick="window.location.href='navigation.php?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&renamecat='+$('#exist_cat').val()+'&newcatname='+$('#nav_newcat').val();"></i></span>
                            <span class="input-group-addon" id="del_cat"><i class='fa fa-fw fa-trash' style="visibility:hidden; color:#c9302c; cursor:pointer;" data-toggle="tooltip" title="Delete" onclick="window.location.href='navigation.php?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&deletecat='+$('#exist_cat').val()+'&deletecatname='+$('#nav_newcat').val();"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exist_cat">Edit an Existing Category</label>
                        <select class="form-control" name="exist_cat" id="exist_cat">
                            <?php
                            echo "<option value='0'>None</option>";
                            //get and build category list, find selected
                            $sqlNavExistCat = mysqli_query($db_conn, "SELECT id, name, nav_section, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " AND nav_section='".$_GET['section']."' ORDER BY name");
                            while ($rowExistNavCat = mysqli_fetch_array($sqlNavExistCat)) {

                                if ($rowExistNavCat['id'] != 0) {
                                    $navExistCatId = $rowExistNavCat['id'];
                                    $navExistCatName = $rowExistNavCat['name'];

                                    echo "<option value=" . $navExistCatId . ">" . $navExistCatName . "</option>";
                                }

                            }
                            ?>
                        </select>
                    </div>
                </fieldset>
                <hr/>
            </div>

            <!-- Nav Link Section -->
            <form name="navForm" class="dirtyForm" method="post" action="">
                <fieldset>
                    <div class="form-group">
                        <label for="nav_newname">Link Name</label>
                        <input type="text" class="form-control count-text" name="nav_newname" id="nav_newname" maxlength="255" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nav_newurl">Link URL</label>
                        <input type="text" class="form-control count-text" name="nav_newurl" id="nav_newurl" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="exist_page">Existing Page</label>
                        <select class="form-control" name="exist_page" id="exist_page">
                            <?php
                            echo "<option value=''>Custom</option>";
                            echo $pagesStr;
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
                        <th>External Link</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $navCount = "";

                    $sqlNav = mysqli_query($db_conn, "SELECT id, name, url, sort, win, section, catid, loc_id FROM navigation WHERE section='$getNavSection' AND loc_id=" . $_GET['loc_id'] . " ORDER BY sort");
                    while ($rowNav = mysqli_fetch_array($sqlNav)) {
                        $navId = $rowNav['id'];
                        $navName = $rowNav['name'];
                        $navURL = $rowNav['url'];
                        $navSort = $rowNav['sort'];
                        $navWin = $rowNav['win'];
                        $navCat = $rowNav['catid'];
                        $navSection = $rowNav['section'];
                        $navCount++;

                        if ($navWin == 'true') {
                            $isActive = "CHECKED";
                        } else {
                            $isActive = "";
                        }

                        echo "<tr>
							<td class='col-xs-1'><input type='hidden' name='nav_id[]' value='" . $navId . "' >
							<input class='form-control' name='nav_sort[]' value='" . $navSort . "' type='text' maxlength='3' data-toggle='tooltip' title='If you would like to hide the Navigation link, enter a Sort Order of 0.'></td>
							<td><input class='form-control' name='nav_name[]' value='" . $navName . "' type='text'></td>
							<td><input class='form-control' name='nav_url[]' value='" . $navURL . "' type='text'></td>";
                        echo "<td><select class='form-control' name='nav_cat[]'>'";
                        echo "<option value='0'>None</option>";
                        //get and build category list, find selected
                        $sqlNavCat = mysqli_query($db_conn, "SELECT id, name, nav_section, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " AND nav_section='".$_GET['section']."' ORDER BY name");
                        while ($rowNavCat = mysqli_fetch_array($sqlNavCat)) {
                            if ($rowNavCat['id'] != 0) {
                                $navCatId = $rowNavCat['id'];
                                $navCatName = $rowNavCat['name'];

                                if ($navCatId == $navCat) {
                                    $isCatSelected = "SELECTED";
                                } else {
                                    $isCatSelected = "";
                                }

                                echo "<option value=" . $navCatId . " " . $isCatSelected . ">" . $navCatName . "</option>";
                            }
                        }

                        echo "</select></td>
							<td class='col-xs-1'><input data-toggle='toggle' title='Open in a new window' class='checkbox nav_win_checkbox' id='$navId' type='checkbox' " . $isActive . "></td>
							<td class='col-xs-1'><button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "&deletenav=$navId&deletename=" . safeCleanStr($navName) . "'\"><i class='fa fa-fw fa-trash'></i></button></td>
							</tr>";
                    }

                    echo "<input type='hidden' name='nav_count' value=" . $navCount . " >";
                    ?>
                    </tbody>
                </table>

                <button type="submit" name="nav_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
            </form>

        </div>
    </div>

<?php
include_once('includes/footer.inc.php');
?>