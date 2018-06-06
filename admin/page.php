<?php
define('tinyMCE', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'page.php';

?>
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($_GET['newpage'] == 'true') {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc_id=" . $_GET['loc_id'] . "'>Home</a></li>
                <li><a href='page.php?loc_id=" . $_GET['loc_id'] . "'>Pages</a></li>
                <li class='active'>New Page</li>
                </ol>";
                echo "<h1 class='page-header'>Pages (New) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
            } elseif ($_GET['editpage']) {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc_id=" . $_GET['loc_id'] . "'>Home</a></li>
                <li><a href='page.php?loc_id=" . $_GET['loc_id'] . "'>Pages</a></li>
                <li class='active'>Edit Page</li>
                </ol>";
                echo "<h1 class='page-header'>Pages (Edit) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
            } else {
                echo "<ol class='breadcrumb'>
                <li><a href='setup.php?loc_id=" . $_GET['loc_id'] . "'>Home</a></li>
                <li class='active'>Pages</li>
                </ol>";
                echo "<h1 class='page-header'>Pages</h1>";
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php

            if ($_GET['newpage'] || $_GET['editpage']) {

                $page_title = safeCleanStr($_POST['page_title']);
                $page_content = sqlEscapeStr($_POST['page_content']);
                $page_keywords = sqlEscapeStr($_POST['page_keywords']);

                // Update existing page
                if ($_GET['editpage']) {

                    $thePageId = $_GET['editpage'];
                    $pageLabel = "Edit Page Title";

                    //update data on submit
                    if (!empty($_POST['page_title'])) {

                        $pageUpdate = "UPDATE pages SET title='" . $page_title . "', content='" . $page_content . "', keywords='" . $page_keywords . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=" . $thePageId . ";";
                        mysqli_query($db_conn, $pageUpdate);

                        $pageMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='page.php?loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The page " . $page_title . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                    }

                    $sqlPages = mysqli_query($db_conn, "SELECT id, title, content, keywords, active, author_name, datetime, loc_id FROM pages WHERE id=" . $thePageId . " AND loc_id=" . $_GET['loc_id'] . ";");
                    $rowPages = mysqli_fetch_array($sqlPages, MYSQLI_ASSOC);

                    //Create new page
                } elseif ($_GET['newpage']) {

                    $pageLabel = "New Page Title";

                    //insert data on submit
                    if (!empty($page_title)) {
                        $pageInsert = "INSERT INTO pages (title, content, keywords, active, author_name, datetime, loc_id) VALUES ('" . $page_title . "', '" . $page_content . "', '" . $page_keywords . "', 'false', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ");";
                        mysqli_query($db_conn, $pageInsert);

                        header("Location: page.php?loc_id=" . $_GET['loc_id'] . "", true, 301);
                        echo "<script>window.location.href='page.php?loc_id=" . $_GET['loc_id'] . "';</script>";
                    }
                }

                //alert messages
                if ($errorMsg != "") {
                    echo $errorMsg;
                } else {
                    echo $pageMsg;
                }
                ?>
                <div class="col-lg-12">
                    <form name="pageForm" class="dirtyForm" method="post">

                        <div class="form-group required">
                            <label><?php echo $pageLabel; ?></label>
                            <input type="text" class="form-control count-text" name="page_title" maxlength="255"
                                   value="<?php if ($_GET['editpage']) {
                                       echo $rowPages['title'];
                                   } ?>" placeholder="Page Title" autofocus required>
                        </div>

                        <div class="form-group">
                            <label>Page Keywords</label>
                            <input type="text" class="form-control count-text" name="page_keywords" maxlength="999"
                                   value="<?php if ($_GET['editpage']) {
                                       echo $rowPages['keywords'];
                                   } ?>" placeholder="tech, coding, tutorials, books">
                        </div>

                        <hr/>

                        <?php
                        $sqlSetup = mysqli_query($db_conn, "SELECT loc_id FROM setup WHERE loc_id=" . $_GET['loc_id'] . ";");
                        $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);
                        ?>

                        <div class="form-group">
                            <label>Text / HTML</label>
                            <textarea class="form-control tinymce" rows="20" name="page_content"
                                      id="page_content"><?php if ($_GET['editpage']) {
                                    echo $rowPages['content'];
                                } ?></textarea>
                        </div>

                        <div class="form-group">
                            <span><small><?php if ($_GET['editpage']) {
                                        echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowPages['datetime'])) . " By: " . $rowPages['author_name'];
                                    } ?></small></span>
                        </div>

                        <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                        <button type="submit" name="page_submit" class="btn btn-primary"><i
                                    class='fa fa-fw fa-save'></i> Save Changes
                        </button>
                        <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

                    </form>
                </div>

            <?php

            } else {

            $deleteMsg = "";
            $deleteConfirm = "";
            $pageMsg = "";
            $delPageId = $_GET['deletepage'];
            $delPageTitle = safeCleanStr(addslashes($_GET['deletetitle']));
            $main_heading = safeCleanStr($_POST['main_heading']);

            //delete page
            if ($_GET['deletepage'] && $_GET['deletetitle'] && !$_GET['confirm']) {
                showModalConfirm(
                    "confirm",
                    "Delete Page?",
                    "Are you sure you want to delete: " . $delPageTitle . "?",
                    "page.php?loc_id=" . $_GET['loc_id'] . "&deletepage=" . $delPageId . "&deletetitle=" . $delPageTitle . "&confirm=yes&token=" . $_SESSION['unique_referrer'] . "",
                    false
                );

            } elseif ($_GET['deletepage'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes' && $_GET['token'] == $_SESSION['unique_referrer']) {

                //delete page after clicking Yes
                $pageDelete = "DELETE FROM pages WHERE id=" . $delPageId . " AND loc_id=" . $_GET['loc_id'] . ";";
                mysqli_query($db_conn, $pageDelete);

                $deleteMsg = "<div class='alert alert-success'>" . safeCleanStr($delPageTitle) . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //update heading on submit
            if (!empty($main_heading)) {

                $setupUpdate = "UPDATE setup SET pageheading='" . $main_heading . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . ";";
                mysqli_query($db_conn, $setupUpdate);

                $pageMsg = "<div class='alert alert-success'>The pages have been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
            }

            $sqlSetup = mysqli_query($db_conn, "SELECT pageheading FROM setup WHERE loc_id=" . $_GET['loc_id'] . ";");
            $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

            //Modal preview box
            showModalPreview("webpageDialog");
            ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#dataTable').dataTable({
                            "iDisplayLength": 25,
                            "order": [[0, "desc"]],
                            "columnDefs": [{
                                "targets": 'no-sort',
                                "orderable": false
                            }]
                        });
                    });
                </script>
                <button type="button" class="btn btn-primary"
                        onclick="window.location='?newpage=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i
                            class='fa fa-fw fa-plus'></i> Add a New Page
                </button>
                <h2></h2>
                <div>
                    <?php
                    if ($errorMsg != "") {
                        echo $errorMsg;
                    } else {
                        echo $pageMsg;
                    }
                    ?>
                    <form name="pageForm" class="dirtyForm" method="post" action="">
                        <div class="form-group required">
                            <label>Heading</label>
                            <input type="text" class="form-control count-text" name="main_heading" maxlength="255"
                                   value="<?php echo $rowSetup['pageheading']; ?>" placeholder="My page" autofocus
                                   required>
                        </div>
                        <hr/>
                        <table class="table table-bordered table-hover table-striped table-responsive dataTable"
                               id="dataTable">
                            <thead>
                            <tr>
                                <th>Page Title</th>
                                <th>Active</th>
                                <th class="no-sort">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sqlPages = mysqli_query($db_conn, "SELECT id, title, content, keywords, active, loc_id FROM pages WHERE loc_id=" . $_GET['loc_id'] . " ORDER BY datetime DESC;");
                            while ($rowPages = mysqli_fetch_array($sqlPages, MYSQLI_ASSOC)) {

                                $pageId = $rowPages['id'];
                                $pageTitle = safeCleanStr($rowPages['title']);
                                $pageContent = $rowPages['content'];
                                $pageKeywords = $rowPages['keywords'];
                                $pageActive = $rowPages['active'];

                                if ($rowPages['active'] == 'true') {
                                    $isActive = "CHECKED";
                                } else {
                                    $isActive = "";
                                }

                                echo "<tr>
                                <td><a href='page.php?loc_id=" . $_GET['loc_id'] . "&editpage=$pageId' title='Edit'>" . $pageTitle . "</a></td>
                                <td class='col-xs-1'>
                                <input data-toggle='toggle' title='Page Active' class='checkbox page_status_checkbox' id='$pageId' type='checkbox' " . $isActive . ">
                                </td>
                                <td class='col-xs-2'>
                                <button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('page.php?loc_id=" . $_GET['loc_id'] . "&page_id=" . $pageId . "', '../page.php?loc_id=" . $_GET['loc_id'] . "&page_id=" . $pageId . "')\"><i class='fa fa-fw fa-eye'></i></button>
                                <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='page.php?loc_id=" . $_GET['loc_id'] . "&deletepage=$pageId&deletetitle=" . $pageTitle . "'\"><i class='fa fa-fw fa-trash'></i></button>
                                </td>
                                </tr>";

                            }
                            ?>
                            </tbody>
                        </table>

                        <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                        <button type="submit" name="pageNew_submit" class="btn btn-primary"><i
                                    class='fa fa-fw fa-save'></i> Save Changes
                        </button>
                        <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>
                    </form>
                </div>
                <?php
            } //end of long else statement
            ?>
        </div>
    </div>
    <p></p>

    <!-- Modal javascript logic -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#confirm').on('hidden.bs.modal', function () {
                setTimeout(function () {
                    window.location.href = 'page.php?loc_id=<?php echo $_GET['loc_id']; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deletepage') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>