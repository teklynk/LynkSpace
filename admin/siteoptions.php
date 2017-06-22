<?php
session_start();
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'siteoptions.php';

//check if user is logged in and is admin
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_SESSION['session_hash'] == md5($_SESSION['user_name'])) {
    $pageMsg = "";

    if ($_POST['save_main']) {
        //Update record in DB
        $configUpdate = "UPDATE config SET customer_id='" . safeCleanStr($_POST['site_customer_id']) . "', theme='" . safeCleanStr($_POST['site_theme']) . "', loc_types='" . safeCleanStr($_POST['site_loc_types']) . "', analytics='" . safeCleanStr($_POST['site_analytics']) . "', session_timeout=" . safeCleanStr($_POST['site_session_timeout']) . ", carousel_speed='" . safeCleanStr($_POST['site_carousel_speed']) . "', setuppacurl='" . validateUrl($_POST['site_pacurl']) . "', homepageurl='" . validateUrl($_POST['site_homepageurl']) . "', iprange='" . safeCleanStr($_POST['site_iprange']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=1 ";
        mysqli_query($db_conn, $configUpdate);

        $pageMsg = "<div class='alert alert-success'>Site options have been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='siteoptions.php'\">×</button></div>";
    }

    //Get data
    $sqlConfig = mysqli_query($db_conn, "SELECT customer_id, theme, iprange, multibranch, loc_types, homepageurl, setuppacurl, session_timeout, carousel_speed, analytics, datetime, author_name FROM config WHERE id=1 ");
    $rowConfig = mysqli_fetch_array($sqlConfig);

    //Get theme names from themes folder
    $themeDirectories = glob('../themes/*' , GLOB_ONLYDIR);

    // Build themes drop down list
    foreach($themeDirectories as $themes) {
        $themes = str_replace('../themes/', '', $themes);
        $themesImg = '../themes/'.$themes.'/screenshot.png.png';

        if ($themes == $rowConfig['theme']) {
            $isThemeSelected = "SELECTED";
        } else {
            $isThemeSelected = "";
        }

        $themesStr .= "<option value=" . $themes . " " . $isThemeSelected . ">" . ucwords($themes) . "</option>";
    }
?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Settings</a></li>
                <li class="active">Site Options</li>
            </ol>
            <h1 class="page-header">
                Site Options
            </h1>
        </div>

        <div class="col-lg-8">
            <?php
            if ($errorMsg !="") {
                echo $errorMsg;
            } else {
                echo $pageMsg;
            }
            if (!is_writable('../sitemap.xml')) {
                echo "<div class='alert alert-danger'>Unable to write to sitemap.xml. Check file permissions.</div>";
            }
            if (!is_writable('../robots.txt')) {
                echo "<div class='alert alert-danger'>Unable to write to robots.txt. Check file permissions.</div>";
            }
            //multibranch active
            if ($rowConfig['multibranch'] == 'true') {
                $selActive = "CHECKED";
            } else {
                $selActive = "";
            }
            ?>
            <form name="siteoptionsform" class="dirtyForm" method="post">
                <div class="form-group">
                    <a href="../themes/<?php echo $rowConfig['theme']; ?>/screenshot.png" target="_blank" id="theme_href_preview">
                        <img src="../themes/<?php echo $rowConfig['theme']; ?>/screenshot_thumb.png" id="theme_image_preview" style="height:240px; width:280px; background:url('//placehold.it/280x240&text=No Image') 0 0 no-repeat;" data-toggle="tooltip" data-original-title="Click to enlarge" data-placement="right"/>
                    </a>
                </div>
                <div class="form-group">
                    <label>Themes</label>
                    <select class="form-control" name="site_theme" id="site_theme">
                        <?php
                        echo $themesStr;
                        ?>
                    </select>
                </div>
                <div class="form-group" id="file_editor">
                    <button type="button" data-toggle="tooltip" class="delete_location btn btn-primary" name="file_editor" onclick="window.location='editor.php?loc_id=<?php echo $_GET['loc_id']; ?>';">
                        <i class='fa fa-fw fa-edit'></i> File Editor
                    </button>
                    <small>
                        &nbsp;&nbsp;Over-ride theme CSS styles and other files.&nbsp;&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                    </small>
                </div>
                <hr/>
                <div class="form-group">
                    <label>Customer ID</label>
                    <input type="text" class="form-control count-text" name="site_customer_id" maxlength="10" value="<?php echo $rowConfig['customer_id']; ?>" placeholder="8675309">
                </div>
                <div class="form-group" id="multibranchactive">
                    <label>Multibranch</label>
                    <div class="checkbox">
                        <label>
                            <input class="multibranch_checkbox" id="multibranch_active" name="multibranch_active" type="checkbox" <?php echo $selActive; ?> data-toggle="toggle">
                        </label>
                    </div>
                </div>
                <?php
                if ($rowConfig['multibranch'] == 'true') {
                    echo "<div class='form-group'>";
                    echo "<label>Location Groups</label>";
                    echo "<input type='text' class='form-control count-text' name='site_loc_types' maxlength='255' value='". $rowConfig['loc_types'] ."' placeholder='1,2,3,4,5'>";
                    echo "</div>";
                } else {
                    echo "<input type='hidden' name='site_loc_types' value='Default'>";
                }
                ?>
                <div class="form-group">
                    <label>Home Page URL</label>
                    <input type="url" pattern="<?php echo urlValidationPattern; ?>" class="form-control count-text" name="site_homepageurl" maxlength="100" value="<?php echo $rowConfig['homepageurl']; ?>" placeholder="http://www.myhomepage.com">
                </div>
                <div class="form-group">
                    <label>PAC URL</label>
                    <input type="url" pattern="<?php echo urlValidationPattern; ?>" class="form-control count-text" name="site_pacurl" maxlength="100" value="<?php echo $rowConfig['setuppacurl']; ?>" placeholder="http://www.librarypac.com">
                </div>
                <div class="form-group">
                    <label>Carousel Speed</label>
                    <input type="text" class="form-control count-text" name="site_carousel_speed" maxlength="10" value="<?php echo $rowConfig['carousel_speed']; ?>" placeholder="5000">
                </div>
                <div class="form-group">
                    <label>Admin Session Log Out Time Limit</label>
                    <input type="text" class="form-control count-text" name="site_session_timeout" maxlength="10" value="<?php echo $rowConfig['session_timeout']; ?>" placeholder="3600">
                </div>
                <hr/>
                <div class="form-group">
                    <label>Admin Panel IP Range Access</label>
                    <small>
                        &nbsp;&nbsp;Restrict access to an external or internal IP address.&nbsp;&nbsp;Your IP address is <?php echo getRealIpAddr();?>&nbsp;&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                    </small>
                    <input type="text" class="form-control count-text" name="site_iprange" maxlength="20" value="<?php echo $rowConfig['iprange']; ?>" placeholder="192.168.0." data-toggle="tooltip" data-original-title="Use Carefully!" data-placement="top">
                </div>
                <hr/>
                <div class="form-group">
                    <label>Website Analytics</label>
                    <input type="text" class="form-control count-text" name="site_analytics" maxlength="20" value="<?php echo $rowConfig['analytics']; ?>" placeholder="UA-XXXXXX-Y">
                </div>
                <div class="form-group" id="sitemap_builder">
                    <button type="button" data-toggle="tooltip" class="sitemap_builder btn btn-primary" name="sitemap_builder">
                        <i class='fa fa-fw fa-refresh'></i> Update Sitemap.xml
                    </button>
                    <small>
                        &nbsp;&nbsp;Generate a search engine site map for web crawlers.&nbsp;&nbsp;<i class="fa fa-fw fa-info-circle"></i>
                    </small>
                    <br/>
                    <small class="sitemap_builder_msg">
                    <?php
                    if (!is_writable('../sitemap.xml')) {
                        echo "<p class='text-danger'>Unable to write to sitemap.xml. Check file permissions.</p><br/>";
                    }
                    if (!is_writable('../robots.txt')) {
                        echo "<p class='text-danger'>Unable to write to robots.txt. Check file permissions.</p><br/>";
                    }
                    ?>
                    </small>
                </div>
                <hr/>
                <div class="form-group">
                    <span><small><?php echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowConfig['datetime'])) . " By: " . $rowConfig['author_name']; ?></small></span>
                </div>
                <input type="hidden" name="save_main" value="true"/>
                <button type="submit" name="siteoptionsform_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

            </form>

        </div>
    </div><!--close main container-->
<?php

} else {
    //redirect user if not admin
    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}
include_once('includes/footer.inc.php');
?>