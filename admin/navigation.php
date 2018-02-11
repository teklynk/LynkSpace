<?php
define('inc_access', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'navigation.php';

$getNavSection = $_GET['section'];

//update table on submit
if (!empty($_POST)) {

    $nav_newname = (string)safeCleanStr($_POST['nav_newname']);

    if (!empty($nav_newname)) {

        $nav_newcat = (int)safeCleanStr($_POST['nav_newcat']);
        $exist_cat = (int)$_POST['exist_cat'];
        $exist_cat_main = (int)$_POST['exist_cat_main'];
        $nav_newurl = (string)safeCleanStr($_POST['nav_newurl']);


        //Create new category if newcat is true
        if (!empty($nav_newcat) && $exist_cat == "") {
            $navNewCat = "INSERT INTO category_navigation (cat_name, author_name, datetime, nav_loc_id) VALUES ('" . $nav_newcat . "', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $navNewCat);

            //get the new cat id
            $sqlNavCatID = mysqli_query($db_conn, "SELECT id, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " ORDER BY id DESC LIMIT 1");
            $rowMaxCat = mysqli_fetch_array($sqlNavCatID, MYSQLI_ASSOC);
            $navMaxCatId = $rowMaxCat[0];
        }

        if ($exist_cat == "" && $nav_newcat > "") {

            $getTheCat = $navMaxCatId; //create & add new category name & get it's id

        } elseif ($exist_cat > "" && $nav_newcat > "") {

            $getTheCat = $exist_cat; //use existing category id from add/edit category section

        } elseif ($exist_cat_main > 0) {

            $getTheCat = $exist_cat_main; //use existing category id from main page

        } else {

            $getTheCat = 0; //None

        }

        $navNew = "INSERT INTO navigation (name, url, sort, catid, section, active, win, author_name, datetime, loc_id) VALUES ('" . $nav_newname . "', '" . $nav_newurl . "', 0, $getTheCat, '" . $getNavSection . "', 'false', 'false', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
        mysqli_query($db_conn, $navNew);

    }

    $nav_count = (int)$_POST['nav_count'];

    for ($i = 0; $i < $nav_count; $i++) {

        $nav_sort = (int)$_POST['nav_sort'][$i];
        $nav_name = (string)safeCleanStr($_POST['nav_name'][$i]);
        $nav_url = (string)safeCleanStr($_POST['nav_url'][$i]);
        $nav_cat = (int)$_POST['nav_cat'][$i];
        $nav_id = (int)$_POST['nav_id'][$i];

        if ($nav_cat == "") {
            $nav_cat = 0; //None
        }

        $navUpdate = "UPDATE navigation SET sort=" . $nav_sort . ", name='" . $nav_name . "', url='" . $nav_url. "', catid=" . $nav_cat . ", author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "', loc_id=" . $_GET['loc_id'] . " WHERE id=" . $nav_id . ";";
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
    header("Location: navigation.php?section=" . $navSectionFirstItem . "&loc_id=" . $_GET['loc_id'] . "",  true,  301);
    echo "<script>window.location.href='navigation.php?section=" . $navSectionFirstItem . "&loc_id=" . $_GET['loc_id'] . "';</script>";
}

//check if using default location
$sqlSetup = mysqli_query($db_conn, "SELECT navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3 FROM setup WHERE loc_id=" . $_GET['loc_id'] . ";");
$rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

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
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo $_GET['loc_id']; ?>">Home</a></li>
                <li><a href="navigation.php?loc_id=<?php echo $_GET['loc_id']; ?>">Navigation</a></li>
                <li class="active">Section: <?php echo $_GET['section']; ?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Navigation (<?php echo $_GET['section']; ?>)
                    </h1>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="nav-section">
                            <label for="nav_menu">Navigation Sections</label>
                            <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="nav_menu" id="nav_menu">
                                <?php echo $navMenuStr; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php

            if ($errorMsg !="") {
                echo $errorMsg;
            } else {
                echo $pageMsg;
            }

            //delete nav
            $deleteMsg = "";
            $deleteConfirm = "";
            $pageMsg = "";
            $delNavId = $_GET['deletenav'];
            $delNavTitle = safeCleanStr(addslashes($_GET['deletename']));

            //Delete nav link
            if ($_GET['deletenav'] && $_GET['deletename'] && !$_GET['confirm']) {
                showModalConfirm(
                    "confirm",
                    "Delete Navigation Link?",
                    "Are you sure you want to delete: ".$delNavTitle."?",
                    "navigation.php?loc_id=".$_GET['loc_id']."&section=".$getNavSection."&deletenav=".$delNavId."&deletename=".$delNavTitle."&confirm=yes",
                    false
                );

            } elseif ($_GET['deletenav'] && $_GET['deletename'] && $_GET['confirm'] == 'yes') {

                //delete nav after clicking Yes
                $navDelete = "DELETE FROM navigation WHERE id=".$delNavId." AND " . $_GET['loc_id'] . ";";
                mysqli_query($db_conn, $navDelete);

                $deleteMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr($delNavTitle) . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //delete category
            $delCatId = $_GET['deletecat'];
            $delCatTitle = safeCleanStr(addslashes($_GET['deletecatname']));

            //Delete category and set nav categories to zero
            if ($_GET['deletecat'] && $_GET['deletecatname'] && !$_GET['confirm']) {
                showModalConfirm(
                    "confirm",
                    "Delete Navigation Category?",
                    "Are you sure you want to delete: ".$delCatTitle."?",
                    "navigation.php?loc_id=".$_GET['loc_id']."&section=".$getNavSection."&deletecat=".$delCatId."&deletecatname=".$delCatTitle."&confirm=yes",
                    false
                );

            } elseif ($_GET['deletecat'] && $_GET['deletecatname'] && $_GET['confirm'] == 'yes') {

                $navCatUpdate = "UPDATE navigation SET catid=0, author_name='" . $_SESSION['user_name'] . "' WHERE loc_id=" . $_GET['loc_id'] . " AND catid='$delCatId';";
                mysqli_query($db_conn, $navCatUpdate);

                //delete category after clicking Yes
                $navCatDelete = "DELETE FROM category_navigation WHERE id=".$delCatId." AND loc_id=" . $_GET['loc_id'] . ";";
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
            if ($_GET['renamecat'] && $_GET['newcatname']) {

                $navRenameCatUpdate = "UPDATE category_navigation SET cat_name='" . safeCleanStr(addslashes($renameCatTitle)) . "', nav_section='" . safeCleanStr($_GET['section']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id='$renameCatId'";
                mysqli_query($db_conn, $navRenameCatUpdate);

                $renameMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr(addslashes($renameCatTitle)) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $renameMsg;
            }

            // add category
            if ($_GET['addcatname'] > "") {
                $navAddCat = "INSERT INTO category_navigation (cat_name, nav_section, author_name, datetime, nav_loc_id) VALUES ('" . safeCleanStr($_GET['addcatname']) . "', '" . safeCleanStr($_GET['section']) . "', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
                mysqli_query($db_conn, $navAddCat);
                header("Location: navigation.php?section=" . $getNavSection . "&loc_id=" . $_SESSION['loc_id'] . "&addcat=" . $_GET['addcatname'] . "",  true,  301);
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
                                <label for="navigation_defaults_<?php echo $navSubSection ?>">
                                    <input class="navigation_defaults_checkbox_<?php echo $navSubSection ?> defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="navigation_defaults_<?php echo $navSubSection ?>" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
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
                <div class="row">
                    <div class="col-lg-8">
                        <fieldset class="well">
                            <div class="col-lg-12">
                                <div class="form-group required">
                                    <label for="nav_newcat">Category</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nav_newcat" id="nav_newcat" maxlength="255" data-toggle="tooltip" title="Create a new category first, and then create the associated links." required>
                                        <span class="input-group-addon" id="add_cat"><i class='fa fa-fw fa-plus' style="color:#337ab7; cursor:pointer;" data-toggle="tooltip" title="Add" onclick="window.location.href='navigation.php?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&addcatname='+$('#nav_newcat').val();"></i></span>
                                        <span class="input-group-addon" id="rename_cat"><i class='fa fa-fw fa-save' style="visibility:hidden; color:#337ab7; cursor:pointer;" data-toggle="tooltip" title="Save" onclick="window.location.href='navigation.php?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&renamecat='+$('#exist_cat').val()+'&newcatname='+$('#nav_newcat').val();"></i></span>
                                        <span class="input-group-addon" id="del_cat"><i class='fa fa-fw fa-trash' style="visibility:hidden; color:#c9302c; cursor:pointer;" data-toggle="tooltip" title="Delete" onclick="window.location.href='navigation.php?section=<?php echo $getNavSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&deletecat='+$('#exist_cat').val()+'&deletecatname='+$('#nav_newcat').val();"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="exist_cat">Edit an Existing Category</label>
                                    <select class="form-control selectpicker bs-placeholder show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="exist_cat" id="exist_cat" title="Choose an existing category">
                                        <?php
                                        echo "<option value='0'>None</option>";
                                        //get and build category list, find selected
                                        $sqlNavExistCat = mysqli_query($db_conn, "SELECT id, cat_name, nav_section, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " AND nav_section='".$_GET['section']."' ORDER BY cat_name");
                                        while ($rowExistNavCat = mysqli_fetch_array($sqlNavExistCat, MYSQLI_ASSOC)) {

                                            if ($rowExistNavCat['id'] != 0) {
                                                $navExistCatId = $rowExistNavCat['id'];
                                                $navExistCatName = $rowExistNavCat['cat_name'];

                                                echo "<option value=" . $navExistCatId . ">" . $navExistCatName . "</option>";
                                            }

                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <hr/>
                    </div>
                </div>
            </div>

            <!-- Nav Link Section -->
            <form name="navForm" class="dirtyForm" method="post" action="">
                <fieldset>
                    <div class="form-group">
                        <label for="exist_page">Existing Page</label>
                        <select class="form-control selectpicker bs-placeholder show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="exist_page" id="exist_page" title="Choose an existing page">
                            <?php
                            echo "<option value=''>None</option>";
                            echo getPages($_GET['loc_id']);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nav_newname">Link Name</label>
                        <input type="text" class="form-control count-text" name="nav_newname" id="nav_newname" maxlength="255" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nav_newurl">Link URL</label>
                        <input type="text" class="form-control count-text" name="nav_newurl" id="nav_newurl" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="exist_cat_main">Existing Category</label>
                        <select class="form-control selectpicker bs-placeholder show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="exist_cat_main" id="exist_cat_main" title="Choose an existing category">
                            <?php
                            echo "<option value='0'>None</option>";
                            //get and build category list, find selected
                            $sqlNavExistCat = mysqli_query($db_conn, "SELECT id, cat_name, nav_section, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " AND nav_section='".$_GET['section']."' ORDER BY cat_name");
                            while ($rowExistNavCat = mysqli_fetch_array($sqlNavExistCat, MYSQLI_ASSOC)) {

                                if ($rowExistNavCat['id'] != 0) {
                                    $navExistCatId = $rowExistNavCat['id'];
                                    $navExistCatName = $rowExistNavCat['cat_name'];

                                    echo "<option value=" . $navExistCatId . ">" . $navExistCatName . "</option>";
                                }

                            }
                            ?>
                        </select>
                    </div>
                </fieldset>
                <hr/>
                <div>
                <table class="table table-bordered table-hover table-striped table-responsive" id="nav_Table">
                    <thead>
                    <tr>
                        <th>Sort</th>
                        <th>Link Name</th>
                        <th>Link URL</th>
                        <th>Category</th>
                        <th>External Link</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $navCount = "";

                    $sqlNav = mysqli_query($db_conn, "SELECT id, name, url, sort, active, win, section, catid, loc_id FROM navigation WHERE section='$getNavSection' AND loc_id=" . $_GET['loc_id'] . " ORDER BY sort, catid");
                    while ($rowNav = mysqli_fetch_array($sqlNav, MYSQLI_ASSOC)) {
                        $navId = $rowNav['id'];
                        $navName = $rowNav['name'];
                        $navURL = $rowNav['url'];
                        $navSort = $rowNav['sort'];
                        $navActive = $rowNav['active'];
                        $navWin = $rowNav['win'];
                        $navCat = $rowNav['catid'];
                        $navSection = $rowNav['section'];
                        $navCount++;

                        if ($navWin == 'true') {
                            $isActive = "CHECKED";
                        } else {
                            $isActive = "";
                        }
                        if ($navActive == 'true') {
                            $isActiveLink = "CHECKED";
                        } else {
                            $isActiveLink = "";
                        }

                        echo "<tr>
							<td class='col-xs-1'><input type='hidden' name='nav_id[]' value='" . $navId . "' >
							<input class='form-control' name='nav_sort[]' value='" . $navSort . "' type='text' maxlength='3' required></td>
							<td><input class='form-control' name='nav_name[]' value='" . $navName . "' type='text'></td>
							<td><input class='form-control' name='nav_url[]' value='" . $navURL . "' type='text'></td>";
                        echo "<td><select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='nav_cat[]'>'";
                        echo "<option value='0'>None</option>";
                        //get and build category list, find selected
                        $sqlNavCat = mysqli_query($db_conn, "SELECT id, cat_name, nav_section, nav_loc_id FROM category_navigation WHERE nav_loc_id=" . $_SESSION['loc_id'] . " AND nav_section='".$_GET['section']."' ORDER BY cat_name");
                        while ($rowNavCat = mysqli_fetch_array($sqlNavCat, MYSQLI_ASSOC)) {
                            if ($rowNavCat['id'] != 0) {
                                $navCatId = $rowNavCat['id'];
                                $navCatName = $rowNavCat['cat_name'];

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
							<td class='col-xs-1'><input data-toggle='toggle' title='Active' class='checkbox nav_active_checkbox' id='$navId' type='checkbox' " . $isActiveLink . "></td>
							<td class='col-xs-1'><button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='navigation.php?section=" . $getNavSection . "&loc_id=" . $_GET['loc_id'] . "&deletenav=$navId&deletename=" . safeCleanStr(addslashes($navName)) . "'\"><i class='fa fa-fw fa-trash'></i></button></td>
							</tr>";
                    }

                    echo "<input type='hidden' name='nav_count' value=" . $navCount . " >";
                    ?>
                    </tbody>
                </table>
                </div>

                <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                <button type="submit" name="nav_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
            </form>

        </div>
    </div>

    <!-- Modal javascript logic -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#confirm').on('hidden.bs.modal', function(){
                setTimeout(function(){
                    window.location.href='navigation.php?loc_id=<?php echo $_GET['loc_id']; ?>&section=<?php echo $_GET['section']; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deletenav') != -1 || url.indexOf('deletecat') != -1 && url.indexOf('confirm') == -1){
                setTimeout(function(){
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>