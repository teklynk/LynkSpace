<?php
define('ALLOW_INC', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'databases.php';

$getCustSection = isset($_GET['section']) ? safeCleanStr($_GET['section']) : false;
$getCustPreview = isset($_GET['preview']) ? safeCleanStr($_GET['preview']) : false;

$customerMsg = '';

//Redirect to section=1 if section is not in querystring
if ($getCustSection == "" && $_GET['loc_id']) {
    header("Location: databases.php?section=1&loc_id=" . $_GET['loc_id'] . "", true, 302);
    echo "<script>window.location.href='databases.php?section=1&loc_id=" . $_GET['loc_id'] . "';</script>";
}

//Page preview
if ($getCustPreview > "") {
    $pagePreviewId = $getCustPreview;
    $sqlcustomerPreview = mysqli_query($db_conn, "SELECT id, icon, image, name, link, catid, section, content FROM customers WHERE id=" . $pagePreviewId . ";");
    $rowCustomerPreview = mysqli_fetch_array($sqlcustomerPreview, MYSQLI_ASSOC);

    echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
    echo "<div class='col-lg-12'>";

    if ($rowCustomerPreview['name'] > "") {
        echo "<h4>" . $rowCustomerPreview['name'] . "</h4>";
    }

    if ($rowCustomerPreview['image'] > "") {
        echo "<p><img src='" . $rowCustomerPreview['image'] . "' style='max-width:350px; max-height:150px;' /></p>";
    } elseif ($rowCustomerPreview['icon'] > "") {
        echo "<p><i id='customer_icon' style='font-size:6.0em;' class='fa fa-fw fa-" . $rowCustomerPreview['icon'] . "'></i></p>";
    }

    if ($rowCustomerPreview['content'] > "") {
        echo "<br/><p>" . $rowCustomerPreview['content'] . "</p>";
    }

    if ($rowCustomerPreview['link'] > "") {
        echo "<br/><p><b>Database Link:</b> <a href='" . $rowCustomerPreview['link'] . "' target='_blank'>" . $rowCustomerPreview['link'] . "</a></p>";
    }

    echo "<br/><p><b>Page URL:</b> <a href='../databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&cat_id=" . $rowCustomerPreview['catid'] . "' title='Page URL' target='_blank'>databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&cat_id=" . $rowCustomerPreview['catid'] . "</a></p>";

    echo "</div>";
}

//check if using default location
$sqlSections = mysqli_query($db_conn, "SELECT id, heading, content, section, use_defaults, loc_id FROM sections_customers WHERE loc_id=" . $_GET['loc_id'] . ";");
$rowSections = mysqli_fetch_array($sqlSections, MYSQLI_ASSOC);

//set Default toggle depending on which section you are on
if ($getCustSection == $rowSections['section']) {
    //use default view
    if ($rowSections['use_defaults'] == 'true') {
        $selDefaults = "CHECKED";
    } else {
        $selDefaults = "";
    }
}

//Get sections from loc_id
$sectionCount = 1;
$isSectionSelected = '';
$maxSections = '';
$custMenuStr = "<option value='1'>1</option>";

while ($rowSections = mysqli_fetch_array($sqlSections, MYSQLI_ASSOC)) {
    $sectionCount++;
    if ($rowSections['section'] == $getCustSection) {
        $isSectionSelected = "SELECTED";
    } else {
        $isSectionSelected = "";
    }
    $maxSections = (int)$rowSections['section'];
    $custMenuStr .= "<option value=" . $rowSections['section'] . " " . $isSectionSelected . ">" . $rowSections['section'] . "</option>";
}

?>
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($_GET['newcustomer'] == 'true') {
                echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='databases.php?loc_id=" . $_GET['loc_id'] . "'>Databases</a></li>
            <li>New Database</li>
            <li class='active'>Page: " . $_GET['section'] . "</li>
            </ol>";
            } elseif ($_GET['editcustomer']) {
                echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='databases.php?loc_id=" . $_GET['loc_id'] . "'>Databases</a></li>
            <li class='active'>Edit Database</li>
            <li class='active'>Page: " . $_GET['section'] . "</li>
            </ol>";
            } else {
                echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='databases.php?loc_id=" . $_GET['loc_id'] . "'>Databases</a></li>
            <li class='active'>Page: " . $_GET['section'] . "</li>
            </ol>";
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <h1 class="page-header">
                            <?php
                            if ($_GET['newcustomer'] == 'true' || $_GET['addsection'] == 'true') {
                                echo "Databases (" . $getCustSection . " - New) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
                            } elseif ($_GET['editcustomer']) {
                                echo "Databases (" . $getCustSection . " - Edit) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
                            } else {
                                echo "Databases (" . $getCustSection . ")&nbsp;";
                                echo "<button type='button' data-toggle='tooltip' data-placement='bottom' title='Preview the Databases Page' class='btn btn-info' onclick=\"showMyModal('databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "', '../databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "#databases')\"><i class='fa fa-eye'></i></button>";
                            }
                            ?>
                        </h1>
                    </div>
                </div>
                <?php

                if (!(isset($_GET['newcustomer']) || isset($_GET['editcustomer']))) {

                    ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="nav-section">
                                <label for="nav_menu">Database Pages</label>

                                <div class="input-group">

                                    <select class="form-control selectpicker show-tick" data-container="body"
                                            data-dropup-auto="false" data-size="10" name="nav_menu" id="nav_menu">
                                        <?php echo $custMenuStr; ?>
                                    </select>
                                    <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" data-toggle="tooltip"
                                        data-placement="bottom" title="Add a new Database Page"
                                        onclick="window.location.href='databases.php?section=<?php echo $maxSections + 1; ?>&addsection=true&loc_id=<?php echo $_GET['loc_id']; ?>'"><i
                                        class="fa fa-plus"></i></button>
                                <button class="btn btn-danger" type="button" data-toggle="tooltip"
                                        data-placement="bottom" title="Delete this Database Page"
                                        onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&deletesection=true&loc_id=<?php echo $_GET['loc_id']; ?>'"><i
                                        class="fa fa-trash"></i></button>
                            </span>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-12">
<?php

if (isset($_GET['newcustomer']) || isset($_GET['editcustomer'])) {

    $customer_name = safeCleanStr($_POST['customer_name']);
    $customer_icon_select = safeCleanStr($_POST['customer_icon_select']);
    $customer_image_select = safeCleanStr($_POST['customer_image_select']);
    $customer_exist_cat = safeCleanStr($_POST['customer_exist_cat']);
    $customer_link = safeCleanStr($_POST['customer_link']);
    $customer_content = sqlEscapeStr($_POST['customer_content']);

    //Update existing customer
    if (isset($_GET['editcustomer'])) {
        $thecustomerId = $_GET['editcustomer'];
        $thecustomerGuid = safeCleanStr($_GET['guid']);
        $customerLabel = "Edit Database Name";

        //update data on submit
        if (!empty($customer_name)) {

            $customerUpdate = "UPDATE customers SET name='" . $customer_name . "', icon='" . $customer_icon_select . "', image='" . $customer_image_select . "', catid='" . $customer_exist_cat . "', link='" . $customer_link . "', content='" . $customer_content . "', author_name='" . $_SESSION['user_name'] . "' WHERE id=" . $thecustomerId . " AND loc_id=" . $_GET['loc_id'] . ";";
            mysqli_query($db_conn, $customerUpdate);

            $customerMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The database " . $customer_name . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        }

        $sqlCustomer = mysqli_query($db_conn, "SELECT id, icon, image, name, link, catid, section, content, guid, featured, active, author_name, sort, datetime, loc_id FROM customers WHERE section='" . $getCustSection . "' AND id=" . $thecustomerId . " AND guid='" . $thecustomerGuid . "' AND loc_id=" . $_GET['loc_id'] . ";");
        $rowCustomer = mysqli_fetch_array($sqlCustomer, MYSQLI_ASSOC);

        //Create new customer
    } elseif (isset($_GET['newcustomer'])) {

        $customerLabel = "New Database Name";

        //insert data on submit
        if (!empty($customer_name)) {
            $customerInsert = "INSERT INTO customers (icon, image, name, link, guid, catid, section, content, featured, active, sort, author_name, loc_id) VALUES ('" . $customer_icon_select . "', '" . $customer_image_select . "', '" . $customer_name . "', '" . $customer_link . "', '" . getGuid() . "', " . $customer_exist_cat . ", '" . $getCustSection . "', '" . $customer_content . "', 'false', 'false', 0, '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ");";
            mysqli_query($db_conn, $customerInsert);

	        flashMessageSet('success','The events section has been updated.');

	        //Redirect back to uploads page
	        header("Location: databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "", true, 302);
	        echo "<script>window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "';</script>";
	        exit();
        }
    }

	//Alert messages
	echo flashMessageGet('success');
    ?>
    <div class="col-lg-8">
        <form name="customerForm" class="dirtyForm" method="post" action="">

            <div class="form-group required">
                <label><?php echo $customerLabel; ?></label>
                <input class="form-control count-text" name="customer_name" maxlength="255"
                       value="<?php if ($_GET['editcustomer']) {
                           echo $rowCustomer['name'];
                       } ?>" data-toggle="tooltip" data-placement="bottom"
                       title="To associate the new database with a category, add the new category before adding the database."
                       placeholder="Database Name" autofocus required>
            </div>

            <div class="form-group">
                <i id="customer_icon" style="font-size:6.0em;"
                   class="fa fa-fw fa-<?php echo $rowCustomer['icon']; ?>"></i>
            </div>
            <div class="form-group">
                <?php
                $imgSrc = "//placehold.it/140x100&text=No Image";

                if ($rowCustomer['image'] == "" && $rowCustomer['icon'] > "") {
                    $imgSrc = "//placehold.it/1/ffffff/ffffff"; //small image just to give the source a value
                } elseif ($rowCustomer['image'] > "" && $rowCustomer['icon'] == "") {
                    $imgSrc = $rowCustomer['image'];
                }
                echo "<img src='" . $imgSrc . "' id='customer_image_preview' style='max-width:140px; height:auto; display:block;'/>";
                ?>
            </div>
            <div class="form-group">
                <label for="customer_icon_select">Choose an icon</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="customer_icon_select" id="customer_icon_select">
                    <option value="">None</option>
                    <?php
                    getIconDropdownList($rowCustomer['icon']);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="customer_image_select">Use an Existing Image</label>
                <select class="form-control selectpicker bs-placeholder show-tick" data-container="body"
                        data-dropup-auto="false" data-size="10" name="customer_image_select" id="customer_image_select"
                        title="Choose an existing image">
                    <option value="">None</option>
                    <?php
                    getImageDropdownList($_GET['loc_id'], image_dir, $rowCustomer['image']);
                    ?>
                </select>
            </div>
            <hr/>
            <div class="form-group">
                <label>Link</label>
                <input class="form-control count-text" name="customer_link" maxlength="255"
                       value="<?php if ($_GET['editcustomer']) {
                           echo $rowCustomer['link'];
                       } ?>" type="text" placeholder="http://www.google.com">
            </div>
            <div class="form-group">
                <label for="customer_exist_cat">Category</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="customer_exist_cat" id="customer_exist_cat" title="Choose a category">
                    <?php
                    echo "<option value='0'>None</option>";
                    //get and build category list, find selected
                    $sqlCustExistCat = mysqli_query($db_conn, "SELECT id, name, section, sort, cust_loc_id FROM category_customers WHERE section='" . $getCustSection . "' AND cust_loc_id=" . $_SESSION['loc_id'] . " ORDER BY sort, name;");
                    while ($rowExistCustCat = mysqli_fetch_array($sqlCustExistCat, MYSQLI_ASSOC)) {

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
                <textarea class="form-control count-text" rows="3" name="customer_content" placeholder="Text"
                          maxlength="255"><?php if ($_GET['editcustomer']) {
                        echo $rowCustomer['content'];
                    } ?></textarea>
            </div>

            <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

            <button type="submit" name="customers_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save
                Changes
            </button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>
    </div>

    <?php
} else {
    $deleteMsg = "";
    $deleteConfirm = "";
    $customerMsg = "";
    $delcustomerId = safeCleanStr($_GET['deletecustomer']);
    $delcustomerGuid = safeCleanStr($_GET['guid']);
    $delcustomerName = safeCleanStr(addslashes($_GET['deletename']));
    $deleteSectionName = safeCleanStr(addslashes($deleteSectionName));
    $customer_heading = safeCleanStr($_POST['customer_heading']);
    $main_content = sqlEscapeStr($_POST['main_content']);
    $cust_count = safeCleanStr($_POST['cust_count']);

    //Delete Section and all databases in the section
    if ($deleteSectionName && $_GET['deletesection'] == 'true' && $_GET['loc_id'] && !$_GET['confirm']) {
        showModalConfirm(
            "confirm",
            "Delete Database Page?",
            "Are you sure you want to delete: " . safeCleanStr(addslashes($getCustSection)) . "?",
            "databases.php?loc_id=" . $_GET['loc_id'] . "&section=" . $getCustSection . "&deletesection=true&deletename=" . $getCustSection . "&guid=" . $delcustomerGuid . "&confirm=yes&token=" . $_SESSION['unique_referrer'] . "",
            false
        );

    } elseif ($_GET['deletename'] && $getCustSection && $_GET['deletesection'] == 'true' && $_GET['loc_id'] && $_GET['confirm'] == 'yes' && $delcustomerGuid && $_GET['token'] == $_SESSION['unique_referrer']) {
        //delete section after clicking Yes
        $sectionDelete = "DELETE FROM sections_customers WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . ";";
        mysqli_query($db_conn, $sectionDelete);

        //Delete all databases with in the section
        $sectionDeleteDatabases = "DELETE FROM customers WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . ";";
        mysqli_query($db_conn, $sectionDeleteDatabases);

        echo "<script>window.location.href='databases.php?section=1&loc_id=" . $_SESSION['loc_id'] . "&sectiondeleted=true';</script>";
    }

    //delete customer
    if ($_GET['deletecustomer'] && $_GET['deletename'] && $_GET['loc_id'] && !$_GET['confirm']) {
        showModalConfirm(
            "confirm",
            "Delete Database?",
            "Are you sure you want to delete: " . $delcustomerName . "?",
            "databases.php?loc_id=" . $_GET['loc_id'] . "&section=" . $getCustSection . "&deletecustomer=" . $delcustomerId . "&guid=" . $delcustomerGuid . "&deletename=" . $delcustomerName . "&confirm=yes",
            false
        );

    } elseif ($delcustomerId && $delcustomerName && $_GET['loc_id'] && $delcustomerGuid && $_GET['confirm'] == 'yes') {
        //delete customer after clicking Yes
        $customerDelete = "DELETE FROM customers WHERE id=" . $delcustomerId . " AND guid='" . $delcustomerGuid . "' AND loc_id=" . $_GET['loc_id'] . ";";
        mysqli_query($db_conn, $customerDelete);

        echo "<script>window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_SESSION['loc_id'] . "&deletename=" . $delcustomerName . "&databasedeleted=true';</script>";
    }

    //Display deleted message
    if ($_GET['sectiondeleted'] == true) {
        $deleteMsg = "<div class='alert alert-success'>Section " . $getCustSection . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=1&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $deleteMsg;
    } elseif ($_GET['databasedeleted'] == true) {
        $deleteMsg = "<div class='alert alert-success'>" . $delcustomerName . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $deleteMsg;
    }

    //update heading on submit
    if ($_POST['save_main']) {

        $sqlSections = mysqli_query($db_conn, "SELECT section, loc_id FROM sections_customers WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . ";");
        $rowSection = mysqli_fetch_array($sqlSections, MYSQLI_ASSOC);

        if ($rowSection['loc_id'] == $_GET['loc_id'] && $rowSection['section'] == $getCustSection) {
            //Do update
            $sectionsUpdate = "UPDATE sections_customers SET heading='" . $customer_heading . "', content='" . $main_content . "', section='" . $getCustSection . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . ";";
            mysqli_query($db_conn, $sectionsUpdate);
        } else {
            //Do Insert
            $sectionsInsert = "INSERT INTO sections_customers (heading, content, section, use_defaults, author_name, datetime, loc_id) VALUES ('" . $customer_heading . "', '" . $main_content . "', '" . $getCustSection . "', 'false', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ");";
            mysqli_query($db_conn, $sectionsInsert);
        }

        for ($i = 0; $i < $cust_count; $i++) {

            $cust_cat = safeCleanStr($_POST['cust_cat'][$i]);
            $cust_sort = safeCleanStr($_POST['cust_sort'][$i]);
            $cust_id = safeCleanStr($_POST['cust_id'][$i]);

            if ($cust_cat == "") {
                $cust_cat = 0; //None
            }

            $custCatUpdate = "UPDATE customers SET catid=" . $cust_cat . ", sort=" . $cust_sort . ", author_name='" . $_SESSION['user_name'] . "', loc_id=" . $_GET['loc_id'] . " WHERE id=" . $cust_id . ";";
            mysqli_query($db_conn, $custCatUpdate);

        }

	    flashMessageSet('success','Databases section has been updated');

    }

    //Display updated message
    if ($_GET['databaseupdated'] == true) {
        $customerMsg = "<div class='alert alert-success'>The databases have been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    }

    $sqlSections = mysqli_query($db_conn, "SELECT heading, content, section, use_defaults FROM sections_customers WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . ";");
    $rowSections = mysqli_fetch_array($sqlSections, MYSQLI_ASSOC);

    //delete category
    $delCatId = $_GET['deletecat'];
    $delCatTitle = safeCleanStr(addslashes($_GET['deletecatname']));

    //Delete category and set categories to zero
    if ($_GET['deletecat'] && $_GET['deletecatname'] && !$_GET['confirm']) {
        showModalConfirm(
            "confirm",
            "Delete Database Category?",
            "Are you sure you want to delete: " . $delCatTitle . "?",
            "databases.php?loc_id=" . $_GET['loc_id'] . "&section=" . $getCustSection . "&deletecat=" . $delCatId . "&deletecatname=" . $delCatTitle . "&confirm=yes",
            false
        );

    } elseif ($_GET['deletecat'] && $_GET['deletecatname'] && $_GET['confirm'] == 'yes') {

        $custCatUpdate = "UPDATE customers SET catid=0, author_name='" . $_SESSION['user_name'] . "' WHERE loc_id=" . $_GET['loc_id'] . " AND catid=" . $delCatId . ";";
        mysqli_query($db_conn, $custCatUpdate);

        //delete category after clicking Yes
        $custCatDelete = "DELETE FROM category_customers WHERE id=" . $delCatId . " AND cust_loc_id=" . $_GET['loc_id'] . ";";
        mysqli_query($db_conn, $custCatDelete);

        $deleteMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . $delCatTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $deleteMsg;
    }

    //rename category
    $renameMsg = "";
    $renameConfirm = "";
    $renameCatId = $_GET['renamecat'];
    $renameCatTitle = safeCleanStr(addslashes($_GET['newcatname']));
    $renameCatSort = safeCleanStr($_GET['newcatsort']);

    //Rename category and set categories to new name
    if ($_GET['renamecat'] && $_GET['newcatname']) {

        $custRenameCatUpdate = "UPDATE category_customers SET name='" . $renameCatTitle . "', sort='" . $renameCatSort . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id='$renameCatId';";
        mysqli_query($db_conn, $custRenameCatUpdate);

        $renameMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . $renameCatTitle . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $renameMsg;
    }

    // add category
    if ($_GET['addcatname'] > "") {

        if ($_GET['addcatsort'] == '') {
            $_GET['addcatsort'] = 0;
        }

        $custAddCat = "INSERT INTO category_customers (name, section, sort, author_name, datetime, cust_loc_id) VALUES ('" . safeCleanStr($_GET['addcatname']) . "', '" . $getCustSection . "', " . safeCleanStr($_GET['addcatsort']) . ", '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ");";
        mysqli_query($db_conn, $custAddCat);

        echo "<script>window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_SESSION['loc_id'] . "&addcat=" . $_GET['addcatname'] . "';</script>";

    }

    // add category message
    if (!empty($_GET['addcat'])) {
        $addMsg = "<div class='alert alert-success fade in' data-alert='alert'>" . $_GET['addcat'] . " category has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
        echo $addMsg;
    }

    //Modal preview box
    showModalPreview("webpageDialog");

    if ($_GET['loc_id'] != 1) {
        ?>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group" id="databasesdefaults">
                    <label>Use Defaults</label>
                    <div class="checkbox">
                        <label>
                            <input class="databases_defaults_checkbox defaults-toggle"
                                   id="<?php echo $_GET['loc_id'] ?>" name="databases_defaults"
                                   type="checkbox" <?php if ($_GET['loc_id']) {
                                echo $selDefaults;
                            } ?> data-toggle="toggle">
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
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="cust_newcatsort">Sort Order</label>
                            <input type="number" class="form-control" name="cust_newcatsort" id="cust_newcatsort"
                                   maxlength="3">
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group required">
                            <label for="cust_newcat">Category</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cust_newcat" id="cust_newcat"
                                       maxlength="255" data-toggle="tooltip"
                                       title="To display the category with the database, add the category first before adding the database.">
                                <span class="input-group-addon" id="add_cat"><i class='fa fa-fw fa-plus'
                                                                                style="color:#337ab7; cursor:pointer;"
                                                                                data-toggle="tooltip" title="Add"
                                                                                onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&addcatsort='+$('#cust_newcatsort').val()+'&addcatname='+$('#cust_newcat').val();"></i></span>
                                <span class="input-group-addon" id="rename_cat"><i class='fa fa-fw fa-save'
                                                                                   style="visibility:hidden; color:#337ab7; cursor:pointer;"
                                                                                   data-toggle="tooltip" title="Save"
                                                                                   onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&renamecat='+$('#exist_cat').val()+'&newcatname='+$('#cust_newcat').val()+'&newcatsort='+$('#cust_newcatsort').val();"></i></span>
                                <span class="input-group-addon" id="del_cat"><i class='fa fa-fw fa-trash'
                                                                                style="visibility:hidden; color:#c9302c; cursor:pointer;"
                                                                                data-toggle="tooltip" title="Delete"
                                                                                onclick="window.location.href='databases.php?section=<?php echo $getCustSection; ?>&loc_id=<?php echo $_GET['loc_id']; ?>&deletecat='+$('#exist_cat').val()+'&deletecatname='+$('#cust_newcat').val();"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exist_cat">Edit an Existing Category</label>
                            <select class="form-control selectpicker bs-placeholder show-tick" data-container="body"
                                    data-dropup-auto="false" data-size="10" name="exist_cat" id="exist_cat"
                                    title="Choose an existing category">
                                <?php
                                echo "<option data-sort='0' value='0'>None</option>";
                                //Cat list for adding a new category
                                //get and build category list, find selected
                                $sqlCustExistCat = mysqli_query($db_conn, "SELECT id, name, section, cust_loc_id, sort FROM category_customers WHERE section='" . $getCustSection . "' AND cust_loc_id=" . $_SESSION['loc_id'] . " ORDER BY sort, name");
                                while ($rowExistCustCat = mysqli_fetch_array($sqlCustExistCat, MYSQLI_ASSOC)) {

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
                    </div>
                </fieldset>
                <hr/>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary"
            onclick="window.location='?section=<?php echo $getCustSection; ?>&newcustomer=true&loc_id=<?php echo $_GET['loc_id']; ?>';">
        <i class='fa fa-fw fa-plus'></i> Add a New Database
    </button>
    <h2></h2>
    <div>
        <?php
        //Alert messages
        echo flashMessageGet('success');
        ?>
        <form name="customerForm" class="dirtyForm" method="post" action="">
            <div class="form-group required">
                <label>Heading</label>
                <input class="form-control count-text" name="customer_heading" maxlength="255"
                       value="<?php echo $rowSections['heading']; ?>" placeholder="My Database Page" autofocus required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control count-text" name="main_content" placeholder="About our databases"
                          maxlength="999"><?php echo $rowSections['content']; ?></textarea>
            </div>
            <table class="table table-bordered table-hover table-striped table-responsive">
                <thead>
                <tr>
                    <th>Sort</th>
                    <th>Name</th>
                    <th>Category (Sort)</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $custCount = "";
                $sqlCustomer = mysqli_query($db_conn, "SELECT id, image, icon, name, link, content, guid, catid, section, featured, author_name, sort, datetime, active, loc_id FROM customers WHERE section='" . $getCustSection . "' AND loc_id=" . $_GET['loc_id'] . " ORDER BY catid, sort, name ASC;");
                while ($rowCustomer = mysqli_fetch_array($sqlCustomer, MYSQLI_ASSOC)) {
                    $customerId = $rowCustomer['id'];
                    $customerGuid = safeCleanStr($rowCustomer['guid']);
                    $customerName = safeCleanStr(addslashes($rowCustomer['name']));
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
                        <input class='form-control' name='cust_sort[]' value='" . $customerSort . "' type='number' maxlength='3' required>
                        </td>
						<td>
						<input type='hidden' name='cust_id[]' value='" . $customerId . "' >
						<a href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&editcustomer=" . $customerId . "&guid=" . $customerGuid . "' title='Edit'>" . $customerName . "</a>
						</td>
						<td>";
                    echo "<select class='form-control selectpicker show-tick' data-container='body' data-dropup-auto='false' data-size='10' name='cust_cat[]'>'";
                    echo "<option value='0'>None</option>";
                    //get and build category list, find selected
                    $sqlCustCat = mysqli_query($db_conn, "SELECT id, name, section, sort, cust_loc_id FROM category_customers WHERE section='" . $getCustSection . "' AND cust_loc_id=" . $_SESSION['loc_id'] . " ORDER BY name;");
                    while ($rowCustCat = mysqli_fetch_array($sqlCustCat, MYSQLI_ASSOC)) {
                        if ($rowCustCat['id'] != 0) {
                            $custCatId = $rowCustCat['id'];
                            $custCatName = $rowCustCat['name'];
                            $custCatSort = $rowCustCat['sort'];

                            if ($custCatId == $customerCat) {
                                $isCatSelected = "SELECTED";
                            } else {
                                $isCatSelected = "";
                            }

                            echo "<option value=" . $custCatId . " " . $isCatSelected . ">" . $custCatName . " (" . $custCatSort . ")</option>";
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
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . $customerName . "', 'databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&preview=$customerId')\"><i class='fa fa-fw fa-eye'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='databases.php?section=" . $getCustSection . "&loc_id=" . $_GET['loc_id'] . "&deletecustomer=" . $customerId . "&guid=" . $customerGuid . "&deletename=" . $customerName . "'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
                }
                ?>
                </tbody>
            </table>

            <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

            <input type="hidden" name="cust_count" value="<?php echo $custCount; ?>"/>
            <input type="hidden" name="save_main" value="true"/>
            <button type="submit" class="btn btn-primary" name="customer_submit"><i class="fa fa-fw fa-save"></i> Save
                Changes
            </button>
            <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
        </form>
    </div>
    <?php
} //end of long else

echo "</div>
</div>
<p></p>";
?>
    <!-- Modal javascript logic -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#confirm').on('hidden.bs.modal', function () {
                setTimeout(function () {
                    window.location.href = 'databases.php?loc_id=<?php echo $_GET['loc_id']; ?>&section=<?php echo $getCustSection; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deletecustomer') != -1 || url.indexOf('deletesection') != -1 || url.indexOf('deletecat') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>