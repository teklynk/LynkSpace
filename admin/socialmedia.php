<?php

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'socialmedia.php';

$sqlSocial = mysqli_query($db_conn, "SELECT heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id FROM socialmedia WHERE loc_id=" . $_GET['loc_id'] . ";");
$rowSocial = mysqli_fetch_array($sqlSocial, MYSQLI_ASSOC);

//update table on submit
if (!empty($_POST)) {

    $social_heading = safeCleanStr($_POST['social_heading']);
    $social_defaults = safeCleanStr($_POST['social_defaults']);
    $social_facebook = trim($_POST['social_facebook']);
    $social_youtube = trim($_POST['social_youtube']);
    $social_twitter = trim($_POST['social_twitter']);
    $social_google = trim($_POST['social_google']);
    $social_pinterest = trim($_POST['social_pinterest']);
    $social_instagram = trim($_POST['social_instagram']);
    $social_tumblr = trim($_POST['social_tumblr']);


    if (!empty($social_heading)) {

        if ($social_defaults == 'on') {
            $social_defaults = 'true';
        } else {
            $social_defaults = 'false';
        }

        if ($rowSocial['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $socialUpdate = "UPDATE socialmedia SET heading='" . $social_heading . "', facebook='" . $social_facebook . "', youtube='" . $social_youtube . "', twitter='" . $social_twitter . "', google='" . $social_google . "', pinterest='" . $social_pinterest . "', instagram='" . $social_instagram . "', tumblr='" . $social_tumblr . "', use_defaults='" . $social_defaults . "' WHERE loc_id=" . $_GET['loc_id'] . ";";
            mysqli_query($db_conn, $socialUpdate);
        } else {
            //Do Insert
            $socialInsert = "INSERT INTO socialmedia (heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id) VALUES ('" . $social_heading . "', '" . $social_facebook . "', '" . $social_youtube . "', '" . $social_twitter . "', '" . $social_google . "', '" . $social_pinterest . "', '" . $social_instagram . "', '" . $social_tumblr . "', '" . $social_defaults . "', " . $_GET['loc_id'] . ");";
            mysqli_query($db_conn, $socialInsert);
        }

    }

    header("Location: socialmedia.php?loc_id=" . $_GET['loc_id'] . "&update=true", true, 301);
    echo "<script>window.location.href='socialmedia.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
}

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The social media section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='socialmedia.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc_id=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">Social Media</li>
        </ol>
        <h1 class="page-header">
            Social Media
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <?php
        if ($errorMsg != "") {
            echo $errorMsg;
        } else {
            echo $pageMsg;
        }
        //use default view
        if ($rowSocial['use_defaults'] == 'true') {
            $selDefaults = "CHECKED";
        } else {
            $selDefaults = "";
        }
        ?>
        <form name="socialmediaForm" class="dirtyForm" method="post" action="">
            <?php
            if ($_GET['loc_id'] != 1) {
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="socialdefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="social_defaults_checkbox defaults-toggle"
                                           id="<?php echo $_GET['loc_id'] ?>" name="social_defaults"
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
            <div class="form-group required">
                <label>Heading</label>
                <input type="text" class="form-control" name="social_heading" maxlength="255"
                       value="<?php echo $rowSocial['heading']; ?>" placeholder="Follow Me" autofocus required>
            </div>
            <div class="form-group">
                <label>Facebook</label>
                <input class="form-control" name="social_facebook" maxlength="255"
                       value="<?php echo $rowSocial['facebook']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.facebook.com/username">
            </div>
            <div class="form-group">
                <label>Twitter</label>
                <input class="form-control" name="social_twitter" maxlength="255"
                       value="<?php echo $rowSocial['twitter']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.twitter.com/username">
            </div>
            <div class="form-group">
                <label>Google+</label>
                <input class="form-control" name="social_google" maxlength="255"
                       value="<?php echo $rowSocial['google']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>"
                       placeholder="https://plus.google.com/8675309/posts">
            </div>
            <div class="form-group">
                <label>Pinterest</label>
                <input class="form-control" name="social_pinterest" maxlength="255"
                       value="<?php echo $rowSocial['pinterest']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.pinterest.com/username/">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input class="form-control" name="social_instagram" maxlength="255"
                       value="<?php echo $rowSocial['instagram']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://www.instagram.com/username/">
            </div>
            <div class="form-group">
                <label>Tumblr</label>
                <input class="form-control" name="social_tumblr" maxlength="255"
                       value="<?php echo $rowSocial['tumblr']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>" placeholder="https://username.tumblr.com/">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input class="form-control" name="social_youtube" maxlength="255"
                       value="<?php echo $rowSocial['youtube']; ?>" type="url"
                       pattern="<?php echo urlValidationPattern; ?>"
                       placeholder="https://www.youtube.com/user/username">
            </div>

            <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

            <button type="submit" name="socialmedia_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>
                Save Changes
            </button>
            <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>

        </form>

    </div>
</div>
<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>
