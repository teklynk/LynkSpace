<?php
define('ALLOW_INC', true);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'socialmedia.php';

$socialCount = 0;

$sqlSetup = mysqli_query($db_conn, "SELECT socialmediaheading, socialmedia_use_defaults FROM setup WHERE loc_id=" . loc_id . ";");
$rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

//onload, get data from table as array
$sqlSocial = mysqli_query($db_conn, "SELECT id, sort, name, url, active, guid FROM sociallinks WHERE loc_id=" . loc_id . " ORDER BY sort, name;");
$rowSocial = mysqli_fetch_all($sqlSocial, MYSQLI_ASSOC);

$delSocialTitle = isset($_GET['deletename']) ? safeCleanStr(addslashes($_GET['deletename'])) : null;
$delSocialId = isset($_GET['deletesociallink']) ? safeCleanStr(addslashes($_GET['deletesociallink'])) : null;
$delSocialToken = isset($_GET['token']) ? safeCleanStr($_GET['token']) : null;
$delSocialGuid = isset($_GET['guid']) ? safeCleanStr($_GET['guid']) : null;

//delete action
if ($delSocialId && $delSocialTitle && !$_GET['confirm']) {
    showModalConfirm(
        "confirm",
        "Delete Social Link?",
        "Are you sure you want to delete: " . $delSocialTitle . "?",
        "socialmedia.php?loc_id=" . loc_id . "&deletesociallink=" . $delSocialId . "&deletename=" . $delSocialTitle . "&guid=" . $delSocialGuid . "&confirm=yes&token=" . $_SESSION['unique_referrer'] . "",
        false
    );
} elseif ($delSocialId && $delSocialTitle && $_GET['confirm'] == 'yes' && $delSocialToken == $_SESSION['unique_referrer']) {

    //delete nav after clicking Yes
    $socialDelete = "DELETE FROM sociallinks WHERE id=" . $delSocialId . " AND guid='" . $delSocialGuid . "' AND loc_id=" . loc_id . ";";
    mysqli_query($db_conn, $socialDelete);

    flashMessageSet('success', $delSocialTitle . " has been deleted.");

    //Redirect back to uploads page
    header("Location: socialmedia.php?loc_id=" . loc_id . "", true, 302);
    echo "<script>window.location.href='socialmedia.php?loc_id=" . loc_id . "';</script>";
    exit();
}

//on post
if (!empty($_POST)) {

    //values for setup table
    $social_active = isset($_POST['social_active']) ? safeCleanStr($_POST['social_active']) : null;
    $social_heading = isset($_POST['social_heading']) ? safeCleanStr(addslashes($_POST['social_heading'])) : null;
    $social_defaults = isset($_POST['social_defaults']) ? sqlEscapeStr($_POST['social_defaults']) : null;

    //values for sociallinks post data
    $social_sort_new = isset($_POST['social_sort_new']) ? safeCleanStr($_POST['social_sort_new']) : null;
    $social_name_new = isset($_POST['social_name_new']) ? safeCleanStr($_POST['social_name_new']) : null;
    $social_url_new = isset($_POST['social_url_new']) ? safeCleanStr($_POST['social_url_new']) : null;
    $socialCount = isset($_POST['social_count']) ? safeCleanStr($_POST['social_count']) : null;

    if (!empty($social_heading)) {

        if ($social_defaults == 'on') {
            $social_defaults = 'true';
        } else {
            $social_defaults = 'false';
        }

        $setupUpdate = "UPDATE setup SET socialmediaheading='" . $social_heading . "', socialmedia_use_defaults='" . $social_defaults . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . loc_id . ";";
        mysqli_query($db_conn, $setupUpdate);

    }

    if (!empty($social_name_new)) {

        //Do Insert
        $socialInsert = "INSERT INTO sociallinks (sort, name, url, author_name, DATETIME, active, loc_id, guid) VALUES ('" . $social_sort_new . "', '" . $social_name_new . "', '" . $social_url_new . "', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', 0, " . loc_id . ", '" . getGuid() . "');";
        mysqli_query($db_conn, $socialInsert);

    } else {

        for ($i = 0; $i < $socialCount; $i++) {

            $social_sort = isset($_POST['social_sort'][$i]) ? safeCleanStr($_POST['social_sort'][$i]) : null;
            $social_name = isset($_POST['social_name'][$i]) ? safeCleanStr($_POST['social_name'][$i]) : null;
            $social_url = isset($_POST['social_url'][$i]) ? safeCleanStr($_POST['social_url'][$i]) : null;
            $social_id = isset($_POST['social_id'][$i]) ? safeCleanStr($_POST['social_id'][$i]) : null;

            $socialUpdate = "UPDATE sociallinks SET sort=" . $social_sort . ", name='" . $social_name . "', url='" . $social_url . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date("Y-m-d H:i:s") . "', loc_id=" . loc_id . " WHERE id=" . $social_id . ";";
            mysqli_query($db_conn, $socialUpdate);

        }

    }

    flashMessageSet('success', "The social media section has been updated.");

    //Redirect back to socialmedia page
    header("Location: socialmedia.php?loc_id=" . loc_id . "", true, 302);
    echo "<script>window.location.href='socialmedia.php?loc_id=" . loc_id . "';</script>";
    exit();
}

?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
            <li class="active">Social Media</li>
        </ol>
        <h1 class="page-header">
            Social Media
        </h1>
    </div>
</div>

<?php echo flashMessageGet('success'); ?>

<div class="row">
    <div class="col-lg-8">
        <?php

        //use default view
        if ($rowSocial['use_defaults'] == 'true') {
            $selDefaults = "CHECKED";
        } else {
            $selDefaults = "";
        }

        ?>
        <form name="socialmediaForm" class="dirtyForm" method="post">

            <?php
            if (loc_id != 1) {
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="socialdefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="social_defaults_checkbox defaults-toggle"
                                           id="<?php echo loc_id ?>" name="social_defaults"
                                           type="checkbox" <?php if (loc_id) {
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

            <div class="form-group required">
                <label>Heading</label>
                <input type="text" class="form-control" name="social_heading" maxlength="255"
                       value="<?php echo $rowSetup['socialmediaheading']; ?>" placeholder="Follow Me" autofocus
                       required>
            </div>

            <div class="row">
                <div class="col-lg-1"><label>Sort</label></div>
                <div class="col-lg-4"><label>Name</label></div>
                <div class="col-lg-5"><label>URL</label></div>
                <div class="col-lg-1"><label>Active</label></div>
                <div class="col-lg-1"><label>Actions</label></div>
            </div>

            <?php
            //loop through rows in sociallinks table
            foreach ($rowSocial as $social) {

                $socialCount++;

                $socialActive = safeCleanStr($social['active']);

                if ($socialActive == 'true') {
                    $isActiveLink = "CHECKED";
                } else {
                    $isActiveLink = "";
                }

                ?>
                <div class="row mb-8" id="social_Table">
                    <div class="col-lg-1">
                        <input class="form-control" name="social_sort[]" maxlength="2" min="0" max="99"
                               value="<?php echo $social['sort']; ?>" type="number" placeholder="">
                    </div>
                    <div class="col-lg-4">
                        <input class="form-control" name="social_name[]" maxlength="255"
                               value="<?php echo $social['name']; ?>" type="text" placeholder="">
                    </div>
                    <div class="col-lg-5">
                        <input class="form-control" name="social_url[]" maxlength="255"
                               value="<?php echo $social['url']; ?>" type="url"
                               pattern="<?php echo urlValidationPattern; ?>" placeholder="">
                        <input type="hidden" name="social_id[]" value="<?php echo $social['id']; ?>">
                    </div>
                    <div class="col-lg-1">
                        <div class="checkbox" style="display: inline-block; margin: 0;">
                            <label>
                                <input class="sociallink_active_checkbox"
                                       id="<?php echo $social['id'] ?>" name="sociallink_active"
                                       type="checkbox" <?php echo $isActiveLink; ?> data-toggle="toggle">
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger'
                                onclick='window.location.href="socialmedia.php?loc_id=<?php echo loc_id; ?>&deletesociallink=<?php echo $social['id']; ?>&deletename=<?php echo $social['name']; ?>&guid=<?php echo $social['guid']; ?>"'>
                            <i class='fa fa-fw fa-trash'></i></button>
                    </div>
                </div>
                <?php
            }
            ?>

            <hr />

            <div class="row">
                <div class="col-lg-1">
                    <input class="form-control" name="social_sort_new" maxlength="2" min="0" max="99"
                           value="" type="number" placeholder="0">
                    <small>Order #</small>
                </div>

                <div class="col-lg-4">
                    <input class="form-control" name="social_name_new" maxlength="255"
                           value="" type="text" placeholder="Social Media">
                    <small>Text shown for the link</small>
                </div>

                <div class="col-lg-5">
                    <input class="form-control" name="social_url_new" maxlength="255"
                           value="" type="url"
                           pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.socialmedia.com">
                    <small>Where should the link go? Type the full url, like this: https://socialmedia.com/user</small>
                </div>
                <div class="col-lg-1">

                </div>
                <div class="col-lg-1">

                </div>
            </div>

            <div class="row mt-16">
                <div class="col-lg-12">
                    <input type="hidden" name="social_count" value="<?php echo $socialCount; ?>">
                    <input type="hidden" name="csrf" value="<?php echo csrf_validate($_SESSION['unique_referrer']); ?>"/>

                    <button type="submit" name="socialmedia_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>
                        Save Changes
                    </button>
                    <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
                </div>
            </div>

        </form>

    </div>
</div>

<!-- Modal javascript logic -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#confirm').on('hidden.bs.modal', function () {
            setTimeout(function () {
                window.location.href = 'socialmedia.php?loc_id=<?php echo loc_id; ?>';
            }, 100);
        });

        var url = window.location.href;
        if (url.indexOf('deletesociallink') != -1 && url.indexOf('confirm') == -1) {
            setTimeout(function () {
                $('#confirm').modal('show');
            }, 100);
        }
    });
</script>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>