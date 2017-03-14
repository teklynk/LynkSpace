<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'databases.php';

$getCustSection = $_GET['section'];

//Page preview
if ($_GET['preview'] > "") {
    $pagePreviewId = $_GET['preview'];
    $sqlcustomerPreview = mysqli_query($db_conn, "SELECT id, icon, image, name, link, catid, section, content FROM customers WHERE id='$pagePreviewId'");
    $rowCustomerPreview = mysqli_fetch_array($sqlcustomerPreview);

    echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
    echo "<div class='col-lg-12'>";

    if ($rowCustomerPreview['name'] > "") {
        echo "<h4>" . $rowCustomerPreview['name'] . "</h4>";
    }

    if ($rowCustomerPreview['image'] > "") {
        echo "<p><img src='../uploads/" . $_SESSION['loc_id'] . "/" . $rowCustomerPreview['image'] . "' style='max-width:350px; max-height:150px;' /></p>";
    } elseif ($rowCustomerPreview['icon'] > "") {
        echo "<p><i id='customer_icon' style='font-size:6.0em;' class='fa fa-fw fa-" . $rowCustomerPreview['icon'] . "'></i></p>";
    }

    if ($rowCustomerPreview['content'] > "") {
        echo "<br/><p>" . $rowCustomerPreview['content'] . "</p>";
    }

    if ($rowCustomerPreview['link'] > "") {
        echo "<br/><p><b>Page Link:</b> " . $rowCustomerPreview['link'] . "</p>";
    }

    echo "</div>";
}
//loop through the array of customerSections
$custMenuStr = "";
$custArrlength = count($custSections);

for ($x = 0; $x < $custArrlength; $x++) {

    if ($custSections[$x] == $_GET['section']) {

        $isSectionSelected = "SELECTED";

    } else {

        $isSectionSelected = "";

    }

    $custMenuStr .= "<option value=" . $custSections[$x] . " " . $isSectionSelected . ">" . $custSections[$x] . "</option>";

    $custSectionFirstItem = $custSections[0];
}

//Redirect to section=1 if section is not in querystring
if ($_GET['section'] == "" && $_GET['loc_id']) {
    header("Location: databases.php?section=" . $custSectionFirstItem . "&loc_id=" . $_GET['loc_id'] . "");
    echo "<script>window.location.href='databases.php?section=" . $custSectionFirstItem . "&loc_id=" . $_GET['loc_id'] . "';</script>";
}
//check if using default location
$sqlSetup = mysqli_query($db_conn, "SELECT customersheading_1, customersheading_2, customersheading_3, customerscontent_1, customerscontent_2, customerscontent_3, databases_use_defaults_1, databases_use_defaults_2, databases_use_defaults_3 FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowSetup = mysqli_fetch_array($sqlSetup);

//set Default toggle depending on which section you are on
if ($_GET['section'] == $custSections[0]) {
    $custSubSection = "1";
    //use default view
    if ($rowSetup['databases_use_defaults_1'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }
} elseif ($_GET['section'] == $custSections[1]){
    $custSubSection = "2";
    //use default view
    if ($rowSetup['databases_use_defaults_2'] == 'true') {
        $selDefaults = "CHECKED";
        $custSubSection = "2";
    } else {
        $selDefaults = "";
    }
} elseif ($_GET['section'] == $custSections[2]){
    $custSubSection = "3";
    //use default view
    if ($rowSetup['databases_use_defaults_3'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }
}
?>
<div class="row">
    <div class="col-lg-10">
        <?php
        if ($_GET['newcustomer'] == 'true') {
            echo "<h1 class='page-header'>Databases (".$_GET['section']." - New) <button type='reset' class='btn btn-default' onclick='javascript: window.history.go(-1)'><i class='fa fa-fw fa-reply'></i> Cancel</button></h1>";
        } else {
            echo "<h1 class='page-header'>Databases (".$_GET['section'].")</h1>";
        }
        ?>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="nav_menu">Database Sections</label>
            <select class="form-control" name="nav_menu" id="nav_menu" autofocus="autofocus">
                <?php echo $custMenuStr; ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php

        if ($_GET['newcustomer'] || $_GET['editcustomer']) {

            $customerMsg = "";

            //Update existing customer
            if ($_GET['editcustomer']) {
                $thecustomerId = $_GET['editcustomer'];
                $customerLabel = "Edit Database Name";

                //update data on submit
                if (!empty($_POST['customer_name'])) {

                    if ($_POST['customer_status'] == 'on') {
                        $_POST['customer_status'] = 'true';
                    } else {
                        $_POST['customer_status'] = 'false';
                    }

                    if ($_POST['customer_featured'] == 'on') {
                        $_POST['customer_featured'] = 'true';
                    } else {
                        $_POST['customer_featured'] = 'false';
                    }

                    $customerUpdate = "UPDATE customers SET name='" . safeCleanStr($_POST['customer_name']) . "', icon='" . $_POST['customer_icon_select'] . "', image='" . $_POST['customer_image_select'] . "', catid='" . safeCleanStr($_POST['customer_exist_cat']) . "', link='" . safeCleanStr($_POST['customer_link']) . "', content='" . sqlEscapeStr($_POST['customer_content']) . "', featured='" . safeCleanStr($_POST['customer_featured']) . "', active='" . $_POST['customer_status'] . "', author_name='" . $_SESSION['user_name'] . "' WHERE id=" . $thecustomerId . " AND loc_id=" . $_GET['loc_id'] . " ";
                    mysqli_query($db_conn, $customerUpdate);

                    $customerMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The database " . safeCleanStr($_POST['customer_name']) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                }

                $sqlCustomer = mysqli_query($db_conn, "SELECT id, icon, image, name, link, catid, section, content, featured, active, author_name, sort, datetime, loc_id FROM customers WHERE section='" . $getCustSection . "' AND id=" . $thecustomerId . " AND loc_id=" . $_GET['loc_id'] . " ");
                $rowCustomer = mysqli_fetch_array($sqlCustomer);

                //Create new customer
            } elseif ($_GET['newcustomer']) {

                $customerLabel = "New Database Name";

                //insert data on submit
                if (!empty($_POST['customer_name'])) {
                    $customerInsert = "INSERT INTO customers (icon, image, name, link, catid, section, content, featured, active, sort, author_name, loc_id) VALUES ('" . $_POST['customer_icon_select'] . "', '" . $_POST['customer_image_select'] . "', '" . $_POST['customer_name'] . "', '" . sqlEscapeStr($_POST['customer_link']) . "', '" . $_POST['customer_exist_cat'] . "', '" . $getCustSection . "', '" . safeCleanStr($_POST['customer_content']) . "', 'false', 'true', 0, '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ")";
                    mysqli_query($db_conn, $customerInsert);

                    echo "<script>window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "';</script>";

                }
            }

            //alert messages
            if ($customerMsg != "") {
                echo $customerMsg;
            }

            if ($_GET['editcustomer']) {
                //active status
                if ($rowCustomer['active'] == 'true') {
                    $selActive = "CHECKED";
                } else {
                    $selActive = "";
                }
                //featured status
                if ($rowCustomer['featured'] == 'true') {
                    $selFeatured = "CHECKED";
                } else {
                    $selFeatured = "";
                }
            }
            ?>

            <form name="customerForm" class="dirtyForm" method="post" action="">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="customeractive">
                            <label>Active</label>
                            <div class="checkbox">
                                <label>
                                    <input class="customer_status_checkbox" id="<?php echo $_GET['editcustomer'] ?>" name="customer_status" type="checkbox" <?php if ($_GET['editcustomer']) {echo $selActive;} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="customerfeatured">
                            <label>Featured</label>
                            <div class="checkbox">
                                <label>
                                    <input class="customer_featured_checkbox" id="<?php echo $_GET['editcustomer'] ?>" name="customer_featured" type="checkbox" <?php if ($_GET['editcustomer']) {echo $selFeatured;} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="form-group">
                    <label><?php echo $customerLabel; ?></label>
                    <input class="form-control count-text" name="customer_name" maxlength="255" value="<?php if ($_GET['editcustomer']) {echo $rowCustomer['name'];} ?>" data-toggle="tooltip" title="To associate the new database with a category, add the new category before adding the database." placeholder="Database Name" required>
                </div>
                <hr/>
                <div class="form-group">
                    <i id="customer_icon" style="font-size:6.0em;" class="fa fa-fw fa-<?php echo $rowCustomer['icon']; ?>"></i>
                </div>
                <div class="form-group">
                    <?php

                    if ($rowCustomer['image'] == "") {
                        $imgSrc = "//placehold.it/2/ffffff/ffffff"; //small image just to give the source a value
                    } else {
                        $imgSrc = "../uploads/" . $_GET['loc_id'] . "/" . $rowCustomer['image'];
                    }

                    echo "<img src='" . $imgSrc . "' id='customer_image_preview' style='max-width:140px; height:auto; display:block;'/>";
                    ?>
                </div>
                <div class="form-group">
                    <label>Choose an icon</label>
                    <select class="form-control" name="customer_icon_select" id="customer_icon_select">
                        <option value="">None</option>
                        <?php

                        $sqlCustomerIcon = mysqli_query($db_conn, "SELECT icon FROM icons_list ORDER BY icon ASC");
                        while ($rowIcon = mysqli_fetch_array($sqlCustomerIcon)) {
                            $icon = $rowIcon['icon'];
                            if ($icon === $rowCustomer['icon']) {
                                $iconCheck = "SELECTED";
                            } else {
                                $iconCheck = "";
                            }
                            echo "<option value='" . $icon . "' " . $iconCheck . ">" . $icon . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Use an Existing Image</label>
                    <select class="form-control" name="customer_image_select" id="customer_image_select">
                        <option value="">None</option>
                        <?php
                        getImageDropdownList($image_dir, $rowCustomer['image']);
                        ?>
                    </select>
                </div>
                <hr/>
                <div class="form-group">
                    <label>Link</label>
                    <input class="form-control count-text" name="customer_link" maxlength="255" value="<?php if ($_GET['editcustomer']) {echo $rowCustomer['link'];} ?>" type="text" placeholder="http://www.google.com">
                </div>
                <div class="form-group">
                    <label for="exist_cat">Category</label>
                    <select class="form-control" name="customer_exist_cat" id="customer_exist_cat">
                        <?php
                        echo "<option value='0'>None</option>";
                        //get and build category list, find selected
                        $sqlCustExistCat = mysqli_query($db_conn, "SELECT id, name, section, sort, cust_loc_id FROM category_customers WHERE section='".$getCustSection."' AND cust_loc_id=" . $_SESSION['loc_id'] . " ORDER BY sort, name");
                        while ($rowExistCustCat = mysqli_fetch_array($sqlCustExistCat)) {

                            if ($rowExistCustCat['id'] != 0) {
                                $custExistCatId = $rowExistCustCat['id'];
                                $custExistCatName = $rowExistCustCat['name'];

                                if ($custExistCatId == $rowCustomer['catid']) {
                                    $isExistCatSelected = "SELECTED";
                                } else {
                                    $isExistCatSelected = "";
                                }

                                echo "<option value=" . $custExistCatId . " " . $isExistCatSelected . ">" . $custExistCatName . "</option>";
                            }

                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control count-text" rows="3" name="customer_content" placeholder="Text" maxlength="255"><?php if ($_GET['editcustomer']) {echo $rowCustomer['content'];} ?></textarea>
                </div>

                <button type="submit" name="customers_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Cancel</button>

            </form>

            <?php
        } else {
            $deleteMsg = "";
            $deleteConfirm = "";
            $customerMsg = "";
            $delcustomerId = $_GET['deletecustomer'];
            $delcustomerName = $_GET['deletename'];

            //delete customer
            if ($_GET['deletecustomer'] && $_GET['deletename'] && !$_GET['confirm']) {
                $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $delcustomerName . "? <a href='?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&deletecustomer=" . $delcustomerId . "&deletename=" . $delcustomerName . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;

            } elseif ($_GET['deletecustomer'] && $_GET['deletename'] && $_GET['confirm'] == 'yes') {
                //delete customer after clicking Yes
                $customerDelete = "DELETE FROM customers WHERE id='$delcustomerId'";
                mysqli_query($db_conn, $customerDelete);

                $deleteMsg = "<div class='alert alert-success'>" . $delcustomerName . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //update heading on submit
            if ($_POST['save_main']) {

                $setupUpdate = "UPDATE setup SET customersheading_$custSubSection='" . safeCleanStr($_POST['customer_heading_'.$custSubSection]) . "', customerscontent_$custSubSection='" . sqlEscapeStr($_POST['main_content_'.$custSubSection]) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
                mysqli_query($db_conn, $setupUpdate);

                for ($i = 0; $i < $_POST['cust_count']; $i++) {

                    if ($_POST['cust_cat'][$i] == "") {
                        $_POST['cust_cat'][$i] = 0; //None
                    }

                    $custCatUpdate = "UPDATE customers SET catid=" . $_POST['cust_cat'][$i] . ", sort=" . safeCleanStr($_POST['cust_sort'][$i]) . ", author_name='" . $_SESSION['user_name'] . "', loc_id=" . $_GET['loc_id'] . " WHERE id=" . $_POST['cust_id'][$i] . " ";
                    mysqli_query($db_conn, $custCatUpdate);

                }

                $customerMsg = "<div class='alert alert-success'>The databases have been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
            }

            $sqlSetup = mysqli_query($db_conn, "SELECT customersheading_$custSubSection, customerscontent_$custSubSection, services_use_defaults FROM setup WHERE loc_id=".$_GET['loc_id']." ");
            $rowSetup  = mysqli_fetch_array($sqlSetup);

            //delete category
            $delCatId = $_GET['deletecat'];
            $delCatTitle = $_GET['deletecatname'];

            //Delete category and set categories to zero
            if ($_GET['deletecat'] && $_GET['deletecatname'] && !$_GET['confirm']) {

                $deleteMsg = "<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete " . safeCleanStr($delCatTitle) . "? <a href='?section=" . $getCustSection . "&deletecat=" . $delCatId . "&deletecatname=" . $delCatTitle . "&loc_id=" . $_GET['loc_id'] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;

            } elseif ($_GET['deletecat'] && $_GET['deletecatname'] && $_GET['confirm'] == 'yes') {

                $custCatUpdate = "UPDATE customers SET catid=0, author_name='" . $_SESSION['user_name'] . "' WHERE loc_id=" . $_GET['loc_id'] . " AND catid='$delCatId'";
                mysqli_query($db_conn, $custCatUpdate);

                //delete category after clicking Yes
                $custCatDelete = "DELETE FROM category_customers WHERE id='$delCatId'";
                mysqli_query($db_conn, $custCatDelete);

                $deleteMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr($delCatTitle) . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //rename category
            $renameMsg = "";
            $renameConfirm = "";
            $renameCatId = $_GET['renamecat'];
            $renameCatTitle = $_GET['newcatname'];
            $renameCatSort = $_GET['newcatsort'];

            //Rename category and set categories to new name
            if ($_GET['renamecat'] && $_GET['newcatname'] && !$_GET['confirm']) {
                $renameMsg = "<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to update " . safeCleanStr($renameCatTitle) . "? <a href='?section=" . $getCustSection . "&renamecat=" . $renameCatId . "&newcatname=" . $renameCatTitle . "&newcatsort=" . $renameCatSort . "&loc_id=" . $_GET['loc_id'] . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $renameMsg;

            } elseif ($_GET['renamecat'] && $_GET['newcatname'] && $_GET['confirm'] == 'yes') {

                $custRenameCatUpdate = "UPDATE category_customers SET name='" . safeCleanStr($renameCatTitle) . "', sort='" . safeCleanStr($renameCatSort) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id='$renameCatId'";
                mysqli_query($db_conn, $custRenameCatUpdate);

                $renameMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . safeCleanStr($renameCatTitle) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $renameMsg;
            }

            // add category
            if ($_GET['addcatname'] > "") {
                $custAddCat = "INSERT INTO category_customers (name, section, sort, author_name, datetime, cust_loc_id) VALUES ('" . safeCleanStr($_GET['addcatname']) . "', '" . $getCustSection . "', " . safeCleanStr($_GET['addcatsort']) . ", '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
                mysqli_query($db_conn, $custAddCat);

                echo "<script>window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_SESSION['loc_id'] . "&addcat=" . $_GET['addcatname'] . "';</script>";

            }

            // add category message
            if (!empty($_GET['addcat'])) {
                $addMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . $_GET['addcat'] . " category has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $addMsg;
            }
            ?>
            <!--modal preview window-->

            <style>
                #webpageDialog iframe {
                    width: 100%;
                    height: 600px;
                    border: none;
                }

                .modal-dialog {
                    width: 95%;
                }
            </style>

            <div class="modal fade" id="webpageDialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                    class="fa fa-times"></i> Close
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe id="myModalFile" src="" frameborder="0"></iframe>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <?php
            if ($_GET['loc_id'] != 1) {
                ?>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="databasesdefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="databases_defaults_checkbox_<?php echo $custSubSection; ?>"  id="<?php echo $_GET['loc_id'] ?>" name="databases_defaults_<?php echo $custSubSection; ?>" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
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
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="cust_newcatsort">Sort Order</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cust_newcatsort" id="cust_newcatsort" maxlength="3">
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <label for="cust_newcat">Category</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cust_newcat" id="cust_newcat" maxlength="255" data-toggle="tooltip" title="To display the category with the database, add the category first before adding the database.">
                                    <span class="input-group-addon" id="add_cat"><i class='fa fa-fw fa-plus' style="color:#337ab7; cursor:pointer;" data-toggle="tooltip" title="Add" onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&addcatsort='+$('#cust_newcatsort').val()+'&addcatname='+$('#cust_newcat').val();"></i></span>
                                    <span class="input-group-addon" id="rename_cat"><i class='fa fa-fw fa-save' style="visibility:hidden; color:#337ab7; cursor:pointer;" data-toggle="tooltip" title="Save" onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&renamecat='+$('#exist_cat').val()+'&newcatname='+$('#cust_newcat').val()+'&newcatsort='+$('#cust_newcatsort').val();"></i></span>
                                    <span class="input-group-addon" id="del_cat"><i class='fa fa-fw fa-trash' style="visibility:hidden; color:#c9302c; cursor:pointer;" data-toggle="tooltip" title="Delete" onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&deletecat='+$('#exist_cat').val()+'&deletecatname='+$('#cust_newcat').val();"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="exist_cat">Edit an Existing Category</label>
                        <select class="form-control" name="exist_cat" id="exist_cat">
                            <?php
                            echo "<option data-sort='0' value='0'>None</option>";
                            //Cat list for adding a new category
                            //get and build category list, find selected
                            $sqlCustExistCat = mysqli_query($db_conn, "SELECT id, name, section, cust_loc_id, sort FROM category_customers WHERE section='" . $getCustSection . "' AND cust_loc_id=" . $_SESSION['loc_id'] . " ORDER BY sort, name");
                            while ($rowExistCustCat = mysqli_fetch_array($sqlCustExistCat)) {

                                if ($rowExistCustCat['id'] != 0) {
                                    $custExistCatId = $rowExistCustCat['id'];
                                    $custExistCatName = $rowExistCustCat['name'];
                                    $custExistCatSort = $rowExistCustCat['sort'];

                                    if ($custExistCatId == $custCat) {
                                        $isExistCatSelected = "SELECTED";
                                    } else {
                                        $isExistCatSelected = "";
                                    }

                                    echo "<option data-sort=" . $custExistCatSort . " value=" . $custExistCatId . " " . $isExistCatSelected . ">" . $custExistCatName . "</option>";
                                }

                            }
                            ?>
                        </select>
                    </div>
                </fieldset>
                <hr/>

            </div>
            <button type="button" class="btn btn-primary" onclick="window.location='?section=<?php echo $getCustSection; ?>&newcustomer=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-plus'></i> Add a New Database</button>
            <h2></h2>
            <div class="table-responsive">
                <?php
                if ($customerMsg != "") {
                    echo $customerMsg;
                }

                ?>
                <form name="customerForm" class="dirtyForm" method="post" action="">
                    <div class="form-group">
                        <label>Heading</label>
                        <input class="form-control count-text" name="customer_heading_<?php echo $custSubSection; ?>" maxlength="255" value="<?php echo $rowSetup['customersheading_'.$custSubSection]; ?>" placeholder="My Database" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="3" class="form-control count-text" name="main_content_<?php echo $custSubSection; ?>" placeholder="About our databases" maxlength="999"><?php echo $rowSetup['customerscontent_'.$custSubSection]; ?></textarea>
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Featured</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $custCount = "";
                        $sqlCustomer = mysqli_query($db_conn, "SELECT id, image, icon, name, link, content, catid, section, featured, author_name, sort, datetime, active, loc_id FROM customers WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . " ORDER BY catid, sort, name ASC");
                        while ($rowCustomer = mysqli_fetch_array($sqlCustomer)) {
                            $customerId = $rowCustomer['id'];
                            $customerName = $rowCustomer['name'];
                            $customerCat = $rowCustomer['catid'];
                            $customerContent = $rowCustomer['content'];
                            $customerLink = $rowCustomer['link'];
                            $customerActive = $rowCustomer['active'];
                            $customerFeatured = $rowCustomer['featured'];
                            $customerSort = $rowCustomer['sort'];
                            $custCount++;

                            if ($rowCustomer['active'] == 'true') {
                                $isActive = "CHECKED";
                            } else {
                                $isActive = "";
                            }

                            if ($rowCustomer['featured'] == 'true') {
                                $isFeatured = "CHECKED";
                            } else {
                                $isFeatured = "";
                            }

                            echo "<tr>
                        <td class='col-xs-1'>
                        <input class='form-control' name='cust_sort[]' value='" . $customerSort . "' type='text' maxlength='3'>
                        </td>
						<td>
						<input type='hidden' name='cust_id[]' value='" . $customerId . "' >
						<a href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&editcustomer=$customerId' title='Edit'>" . $customerName . "</a></td>
						<td>";
                            echo "<select class='form-control' name='cust_cat[]'>'";
                            echo "<option value='0'>None</option>";
                            //get and build category list, find selected
                            $sqlCustCat = mysqli_query($db_conn, "SELECT id, name, section, sort, cust_loc_id FROM category_customers WHERE section='" . $getCustSection . "' AND cust_loc_id=" . $_SESSION['loc_id'] . " ORDER BY name");
                            while ($rowCustCat = mysqli_fetch_array($sqlCustCat)) {
                                if ($rowCustCat['id'] != 0) {
                                    $custCatId = $rowCustCat['id'];
                                    $custCatName = $rowCustCat['name'];
                                    $custCatSort = $rowCustCat['sort'];

                                    if ($custCatId == $customerCat) {
                                        $isCatSelected = "SELECTED";
                                    } else {
                                        $isCatSelected = "";
                                    }

                                    echo "<option value=" . $custCatId . " " . $isCatSelected . ">" . $custCatName . " (".$custCatSort.")</option>";
                                }
                            }
                            echo "</select>";
						echo "</td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Database Featured' class='checkbox customer_featured_checkbox' id='" . $customerId . "' type='checkbox' " . $isFeatured . ">
						</td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Database Active' class='checkbox customer_status_checkbox' id='" . $customerId . "' type='checkbox' " . $isActive . ">
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . safeCleanStr($customerName) . "', 'databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&preview=$customerId')\"><i class='fa fa-fw fa-eye'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&deletecustomer=$customerId&deletename=" . safeCleanStr($customerName) . "'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="cust_count" value="<?php echo $custCount; ?>" />
                    <input type="hidden" name="save_main" value="true"/>
                    <button type="submit" class="btn btn-primary" name="customer_submit"><i class="fa fa-fw fa-save"></i> Save Changes</button>
                    <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Cancel</button>
                </form>
            </div>
            <?php
        } //end of long else

        echo "</div>
	</div>
	<p></p>";

        include_once('includes/footer.inc.php');
        ?>
