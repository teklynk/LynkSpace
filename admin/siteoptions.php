<?php
session_start();
define('inc_access', TRUE);

include_once('includes/header.inc.php');

//check if user is logged in and is admin and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_GET['newlocation'] != 'true' && $_SESSION['session_hash'] == md5($_SESSION['user_name'])) {
    $pageMsg = "";

    if ($_POST['save_main']) {
        //Update record in DB
        $configUpdate = "UPDATE config SET customer_id='" . safeCleanStr($_POST['site_customer_id']) . "', theme='" . safeCleanStr($_POST['site_theme']) . "', analytics='" . safeCleanStr($_POST['site_analytics']) . "', session_timeout=" . safeCleanStr($_POST['site_session_timeout']) . ", carousel_speed='" . safeCleanStr($_POST['site_carousel_speed']) . "', setuppacurl='" . validateUrl($_POST['site_pacurl']) . "', searchform='" . sqlEscapeStr($_POST['site_search_widget']) . "', homepageurl='" . validateUrl($_POST['site_homepageurl']) . "', iprange='" . safeCleanStr($_POST['site_iprange']) . "', multibranch='" . safeCleanStr($_POST['site_multibranch']) . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=1 ";
        mysqli_query($db_conn, $configUpdate);

        $pageMsg = "<div class='alert alert-success'>Site options have been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='siteoptions.php'\">×</button></div>";
    }

    //Get data
    $sqlConfig = mysqli_query($db_conn, "SELECT customer_id, theme, iprange, multibranch, homepageurl, setuppacurl, searchform, session_timeout, carousel_speed, analytics, datetime, author_name FROM config WHERE id=1 ");
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

        $themesStr .= "<option value=" . $themes . " " . $isThemeSelected . ">" . $themes . "</option>";
    }

    // Multibranch options
    $multiBranchOption = array("true", "false");

    // Build multibranch drop down list
    foreach($multiBranchOption as $multiBranch) {

        if ($multiBranch == $rowConfig['multibranch']) {
            $isMultiBranchSelected = "SELECTED";
        } else {
            $isMultiBranchSelected = "";
        }

        $multiBranchStr .= "<option value=" . $multiBranch . " " . $isMultiBranchSelected . ">" . $multiBranch . "</option>";
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
            ?>
            <form name="siteoptionsform" class="dirtyForm" method="post">
                <div class="form-group">
                    <a href="../themes/<?php echo $rowConfig['theme']; ?>/screenshot.png" target="_blank" id="theme_href_preview">
                        <img src="../themes/<?php echo $rowConfig['theme']; ?>/screenshot_thumb.png" id="theme_image_preview" style="height:240px; width:280px;" data-toggle="tooltip" data-original-title="Click to enlarge" data-placement="right"/>
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
                        &nbsp;&nbsp;Over-ride theme CSS styles and other files.&nbsp;&nbsp;<i class="fa fa-question-circle-o"></i>
                    </small>
                </div>
                <hr/>
                <div class="form-group">
                    <label>Customer ID</label>
                    <input class="form-control count-text" name="site_customer_id" maxlength="10" value="<?php echo $rowConfig['customer_id']; ?>" placeholder="8675309">
                </div>
                <div class="form-group">
                    <label>Multi-Branch</label>
                    <select class="form-control" name="site_multibranch" id="site_multibranch">
                        <?php
                        echo $multiBranchStr;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Home Page URL</label>
                    <input class="form-control count-text" name="site_homepageurl" maxlength="100" value="<?php echo $rowConfig['homepageurl']; ?>" placeholder="http://www.myhomepage.com">
                </div>
                <div class="form-group">
                    <label>PAC URL</label>
                    <input class="form-control count-text" name="site_pacurl" maxlength="100" value="<?php echo $rowConfig['setuppacurl']; ?>" placeholder="http://www.librarypac.com">
                </div>
                <div class="form-group">
                    <label>Default Search Widget</label>
                    <textarea class="form-control count-text" name="site_search_widget" rows="6" maxlength="999"><?php echo $rowConfig['searchform']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Carousel Speed</label>
                    <input class="form-control count-text" name="site_carousel_speed" maxlength="10" value="<?php echo $rowConfig['carousel_speed']; ?>" placeholder="5000">
                </div>
                <div class="form-group">
                    <label>Admin Session Log Out Time Limit</label>
                    <input class="form-control count-text" name="site_session_timeout" maxlength="10" value="<?php echo $rowConfig['session_timeout']; ?>" placeholder="3600">
                </div>
                <hr/>
                <div class="form-group">
                    <label>Admin Panel IP Range Access</label>
                    <small>
                        &nbsp;&nbsp;Restrict access to an external or internal IP address.&nbsp;&nbsp;Your IP address is <?php echo getRealIpAddr();?>&nbsp;&nbsp;<i class="fa fa-question-circle-o"></i>
                    </small>
                    <input class="form-control count-text" name="site_iprange" maxlength="20" value="<?php echo $rowConfig['iprange']; ?>" placeholder="192.168.0." data-toggle="tooltip" data-original-title="Use Carefully!" data-placement="top">
                </div>
                <hr/>
                <div class="form-group">
                    <label>Web Site Analytics</label>
                    <input class="form-control count-text" name="site_analytics" maxlength="20" value="<?php echo $rowConfig['analytics']; ?>" placeholder="UA-XXXXXX-Y">
                </div>
                <div class="form-group" id="sitemap_builder">
                    <button type="button" data-toggle="tooltip" class="sitemap_builder btn btn-primary" name="sitemap_builder">
                        <i class='fa fa-fw fa-refresh'></i> Update Sitemap.xml
                    </button>
                    <small>
                        &nbsp;&nbsp;Generate a search engine site map for web crawlers.&nbsp;&nbsp;<i class="fa fa-question-circle-o"></i>
                    </small>
                    <br/>
                    <small class="sitemap_builder_msg status_msg"></small>
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
    die('Direct access not permitted');
}
include_once('includes/footer.inc.php');
?>