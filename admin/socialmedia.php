<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'socialmedia.php';

$sqlSocial = mysqli_query($db_conn, "SELECT heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id FROM socialmedia WHERE loc_id=" . $_GET['loc_id'] . " ");
$rowSocial = mysqli_fetch_array($sqlSocial);

//update table on submit
if (!empty($_POST)) {
    if (!empty($_POST['social_heading'])) {

        if ($_POST['social_defaults'] == 'on') {
            $_POST['social_defaults'] = 'true';
        } else {
            $_POST['social_defaults'] = 'false';
        }

        if ($rowSocial['loc_id'] == $_GET['loc_id']) {
            //Do Update
            $socialUpdate = "UPDATE socialmedia SET heading='" . safeCleanStr($_POST['social_heading']) . "', facebook='" . trim($_POST['social_facebook']) . "', youtube='" . trim($_POST['social_youtube']) . "', twitter='" . trim($_POST['social_twitter']) . "', google='" . trim($_POST['social_google']) . "', pinterest='" . trim($_POST['social_pinterest']) . "', instagram='" . trim($_POST['social_instagram']) . "', tumblr='" . trim($_POST['social_tumblr']) . "', use_defaults='" . safeCleanStr($_POST['social_defaults']) . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $socialUpdate);
        } else {
            //Do Insert
            $socialInsert = "INSERT INTO socialmedia (heading, facebook, youtube, twitter, google, pinterest, instagram, tumblr, use_defaults, loc_id) VALUES ('" . safeCleanStr($_POST['social_heading']) . "', '" . trim($_POST['social_facebook']) . "', '" . trim($_POST['social_youtube']) . "', '" . trim($_POST['social_twitter']) . "', '" . trim($_POST['social_google']) . "', '" . trim($_POST['social_pinterest']) . "', '" . trim($_POST['social_instagram']) . "', '" . trim($_POST['social_tumblr']) . "', '" . safeCleanStr($_POST['social_defaults']) . "', " . $_GET['loc_id'] . ")";
            mysqli_query($db_conn, $socialInsert);
        }

    }

    header("Location: socialmedia.php?loc_id=" . $_GET['loc_id'] . "&update=true");
    echo "<script>window.location.href='socialmedia.php?loc_id=" . $_GET['loc_id'] . "&update=true';</script>";
}

if ($_GET['update'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The social media section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='socialmedia.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
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
        if ($errorMsg !="") {
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
                                    <input class="social_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="social_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <?php
            }
            ?>
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control" name="social_heading" maxlength="255" value="<?php echo $rowSocial['heading']; ?>" placeholder="Follow Me" autofocus required>
            </div>
            <div class="form-group">
                <label>Facebook</label>
                <input class="form-control" name="social_facebook" maxlength="255" value="<?php echo $rowSocial['facebook']; ?>" type="url" placeholder="https://www.facebook.com/username">
            </div>
            <div class="form-group">
                <label>Twitter</label>
                <input class="form-control" name="social_twitter" maxlength="255" value="<?php echo $rowSocial['twitter']; ?>" type="url" placeholder="https://www.twitter.com/username">
            </div>
            <div class="form-group">
                <label>Google+</label>
                <input class="form-control" name="social_google" maxlength="255" value="<?php echo $rowSocial['google']; ?>" type="url" placeholder="https://plus.google.com/8675309/posts">
            </div>
            <div class="form-group">
                <label>Pinterest</label>
                <input class="form-control" name="social_pinterest" maxlength="255" value="<?php echo $rowSocial['pinterest']; ?>" type="url" placeholder="https://www.pinterest.com/username/">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input class="form-control" name="social_instagram" maxlength="255" value="<?php echo $rowSocial['instagram']; ?>" type="url" placeholder="https://www.instagram.com/username/">
            </div>
            <div class="form-group">
                <label>Tumblr</label>
                <input class="form-control" name="social_tumblr" maxlength="255" value="<?php echo $rowSocial['tumblr']; ?>" type="url" placeholder="https://username.tumblr.com/">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input class="form-control" name="social_youtube" maxlength="255" value="<?php echo $rowSocial['youtube']; ?>" type="url" placeholder="https://www.youtube.com/user/username">
            </div>

            <button type="submit" name="socialmedia_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save Changes</button>
            <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>

        </form>

    </div>
</div>
<?php
include_once('includes/footer.inc.php');
?>
