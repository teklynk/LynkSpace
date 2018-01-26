<?php
//Front-end functions used in templates and themes

if (!defined('inc_access')){
    die('Direct access not permitted');
}

function getLocation($loc){
    global $locationName;
    global $locationActive;
    global $locationID;
    global $db_conn;

    if (ctype_digit($loc)){

        $sqlGetLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' AND id=" . $loc . " ");
        $rowGetLocation = mysqli_fetch_array($sqlGetLocation, MYSQLI_ASSOC);

        if ($rowGetLocation['active'] == 'true' && $loc == $rowGetLocation['id']){
            $locationName = $rowGetLocation['name'];
            $locationActive = $rowGetLocation['active'];
            $locationID = $rowGetLocation['id'];
        } else {
            header("Location: index.php?loc_id=1");
            echo "<script>window.location.href='index.php?loc_id=1';</script>";
        }

    }
}

function getLocList($active, $showActiveOnly){
    global $locationListJson;
    global $db_conn;

    $active = $_GET['loc_id'];

    if ($showActiveOnly == 'true'){
        $showActive = "WHERE active='true'";
    } else {
        $showActive = "";
    }

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name, active FROM locations ".$showActive." ORDER BY name ASC");
    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch, MYSQLI_ASSOC)){
        $locationListJson .= "'" . $rowLocationSearch['name'] . "',";
    }
    echo $locationListJson;
}

function getPageList(){
    global $pageListJson;
    global $db_conn;

    $sqlGetPageList = mysqli_query($db_conn, "SELECT title, active FROM pages WHERE active='true'");
    while ($rowPageList = mysqli_fetch_array($sqlGetPageList, MYSQLI_ASSOC)){
        $pageListJson .= "'" . $rowPageList['title'] . "',";
    }
    echo $pageListJson;
}

function getPage($loc){
    global $pageTitle;
    global $pageContent;
    global $pageRefId;
    global $db_conn;

    if (ctype_digit($_GET['page_id'])){
        $pageRefId = $_GET['page_id'];
        $sqlPage = mysqli_query($db_conn, "SELECT id, title, content, active, loc_id FROM pages WHERE id=" . $pageRefId . " AND loc_id=" . $loc . " ");
        $rowPage = mysqli_fetch_array($sqlPage, MYSQLI_ASSOC);

        if ($rowPage['active'] == 'true' && $pageRefId == $rowPage['id']){

            $pageTitle = $rowPage['title'];
            $pageContent = $rowPage['content'];

        } else {

            $pageTitle = "Page not found";
            $pageContent = "This page is not available.";
        }

    } else {

        $pageTitle = "Page not found";
        $pageContent = "This page is not available.";
    }
}

function getContactInfo($loc){
    global $contactHeading;
    global $contactBlurb;
    global $contactMap;
    global $contactAddress;
    global $contactCity;
    global $contactState;
    global $contactZipcode;
    global $contactPhone;
    global $contactEmail;
    global $contactHours;
    global $contactFormSendToEmail;
    global $contactFormMsg;
    global $db_conn;

    $sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, use_defaults, hours FROM contactus WHERE loc_id=" . $loc . " ");
    $rowContact = mysqli_fetch_array($sqlContact, MYSQLI_ASSOC);

    if ($rowContact['use_defaults'] == "true" || $rowContact['use_defaults'] == "" || $rowContact['use_defaults'] == NULL) {
        $sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, use_defaults, hours FROM contactus WHERE loc_id=1 ");
        $rowContact = mysqli_fetch_array($sqlContact, MYSQLI_ASSOC);
    }

    if ($_GET['msgsent'] == "thankyou"){
        $contactFormMsg = "<div id='success'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='#'\">×</button><strong>Your message has been sent. </strong></div></div>";
    } elseif ($_GET['msgsent'] == "error"){
        $contactFormMsg = "<div id='success'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='#'\">×</button><strong>An error occured while sending your message. </strong></div></div>";
    } else {
        $contactFormMsg = "";
    }

    if (!empty($rowContact['heading'])){
        $contactHeading = $rowContact['heading'];
    }

    if (!empty($rowContact['introtext'])){
        $contactBlurb = $rowContact['introtext'];
    }

    if (!empty($rowContact['mapcode'])){
        $contactMap = $rowContact['mapcode'];
    }

    if (!empty($rowContact['address'])){
        $contactAddress = $rowContact['address'];
    }

    if (!empty($rowContact['city'])){
        $contactCity = $rowContact['city'];
    }

    if (!empty($rowContact['state'])){
        $contactState = $rowContact['state'];
    }

    if (!empty($rowContact['zipcode'])){
        $contactZipcode = $rowContact['zipcode'];
    }

    if (!empty($rowContact['phone'])){
        $contactPhone = $rowContact['phone'];
    }

    if (!empty($rowContact['email'])){
        $contactEmail = $rowContact['email'];
    }

    if (!empty($rowContact['hours'])){
        $contactHours = $rowContact['hours'];
    }

    if (!empty($rowContact['sendtoemail'])){
        $contactFormSendToEmail = $rowContact['sendtoemail'];
    }
}

function getServices($loc){
    global $sqlServicesHeading;
    global $rowServicesHeading;
    global $servicesHeading;
    global $sqlServices;
    global $servicesNumRows;
    global $servicesBlurb;
    global $servicesCount;
    global $servicesIcon;
    global $db_conn;

    $sqlServicesSetup = mysqli_query($db_conn, "SELECT services_use_defaults FROM setup WHERE loc_id=" . $loc . " ");
    $rowServicesSetup = mysqli_fetch_array($sqlServicesSetup, MYSQLI_ASSOC);

    //toggle default location value
    if ($rowServicesSetup['services_use_defaults'] == 'true' || $rowServicesSetup['services_use_defaults'] == "" || $rowServicesSetup['services_use_defaults'] == NULL) {
        $servicesDefaultLoc = 1;
    } else {
        $servicesDefaultLoc = $loc;
    }

    $sqlServicesHeading = mysqli_query($db_conn, "SELECT servicesheading, servicescontent FROM setup WHERE loc_id=" . $servicesDefaultLoc . " ");
    $rowServicesHeading = mysqli_fetch_array($sqlServicesHeading, MYSQLI_ASSOC);

    $servicesHeading = $rowServicesHeading['servicesheading'];

    if (!empty($rowServicesHeading['servicescontent'])){
        $servicesBlurb = $rowServicesHeading['servicescontent'];
    }

    $sqlServices = mysqli_query($db_conn, "SELECT id, icon, image, title, link, content, sort, active FROM services WHERE active='true' AND loc_id=" . $servicesDefaultLoc . " ORDER BY sort, title ASC"); //While loop
    $servicesNumRows = mysqli_num_rows($sqlServices);
    $servicesCount = 0;
}

function getTeam($loc){
    global $sqlTeamHeading;
    global $rowTeamHeading;
    global $sqlTeam;
    global $teamHeading;
    global $teamBlurb;
    global $teamImage;
    global $teamTitle;
    global $teamName;
    global $teamContent;
    global $teamNumRows;
    global $db_conn;

    $sqlTeamSetup = mysqli_query($db_conn, "SELECT team_use_defaults FROM setup WHERE loc_id=" . $loc . " ");
    $rowTeamSetup = mysqli_fetch_array($sqlTeamSetup, MYSQLI_ASSOC);

    //toggle default location value
    if ($rowTeamSetup['team_use_defaults'] == 'true' || $rowTeamSetup['team_use_defaults'] == "" || $rowTeamSetup['team_use_defaults'] == NULL) {
        $teamDefaultLoc = 1;
    } else {
        $teamDefaultLoc = $loc;
    }

    $sqlTeamHeading = mysqli_query($db_conn, "SELECT teamheading, teamcontent FROM setup WHERE loc_id=" . $teamDefaultLoc . " ");
    $rowTeamHeading = mysqli_fetch_array($sqlTeamHeading, MYSQLI_ASSOC);

    $teamHeading = $rowTeamHeading['teamheading'];

    if (!empty($rowTeamHeading['teamcontent'])){
        $teamBlurb = $rowTeamHeading['teamcontent'];
    }

    $sqlTeam = mysqli_query($db_conn, "SELECT id, image, title, name, content, sort, active FROM team WHERE active='true' AND loc_id=" . $teamDefaultLoc . " ORDER BY sort, title ASC"); //While loop
    $teamNumRows = mysqli_num_rows($sqlTeam);
}

function getNav($loc, $navSection, $dropdown, $pull){
    //EXAMPLE: getNav($_GET['loc_id'], 'Top','true','right','true')
    global $db_conn;
    global $navLinksID;
    global $navLinksSort;
    global $navLinksName;
    global $navLinksUrl;
    global $navLinksCatId;
    global $navLinksSection;
    global $navLinksActive;
    global $navLinksWin;
    global $navLinksLocId;
    global $navLinksDateTime;
    global $navLinks_CatId;
    global $navLinks_CatName;
    global $navLinks_CatNavLocId;
    global $navCatLinksID;
    global $navCatLinksSort;
    global $navCatLinksName;
    global $navCatLinksUrl;
    global $navCatLinksCatID;
    global $navSections;

    echo "<ul class='nav navbar-nav navbar-$pull navbar-$navSection text-$pull'>";

    if ($dropdown == "true"){
        $dropdownToggle = "dropdown-toggle";
        $dataToggle = "dropdown";
        $dropdown = "dropdown nav-$navSection";
        $dropdownMenu = "dropdown-menu";
        $dropdownCaret = "<b class='caret'></b>";
    } else {
        $dropdownToggle = "";
        $dataToggle = "";
        $dropdown = "nav-$navSection";
        $dropdownMenu = "cat-links";
        $dropdownCaret = "";
    }

    //loop through the array of navSections - config.php
    $navSectionIndex1 = "";
    $navSectionIndex2 = "";
    $navSectionIndex3 = "";

    $navArrlength = count($navSections); //from config.php

    for ($x = 0; $x < $navArrlength; $x++) {
        $navSectionIndex1 = $navSections[0];
        $navSectionIndex2 = $navSections[1];
        $navSectionIndex3 = $navSections[2];
    }

    //check if using default location
    $sqlNavDefaults = mysqli_query($db_conn, "SELECT navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3 FROM setup WHERE loc_id=" . $loc . " ");
    $rowNavDefaults = mysqli_fetch_array($sqlNavDefaults, MYSQLI_ASSOC);

    //toggle default location value if conditions are true
    if ($navSection == $navSectionIndex1 && $rowNavDefaults['navigation_use_defaults_1'] == 'true') {
        $navDefaultLoc = 1;
    } elseif ($navSection == $navSectionIndex2 && $rowNavDefaults['navigation_use_defaults_2'] == 'true') {
        $navDefaultLoc = 1;
    } elseif ($navSection == $navSectionIndex3 && $rowNavDefaults['navigation_use_defaults_3'] == 'true') {
        $navDefaultLoc = 1;
    } else {
        $navDefaultLoc = $loc;
    }

    $sqlNavLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category_navigation ON navigation.catid=category_navigation.id WHERE section='$navSection' AND active='true' AND loc_id=" . $navDefaultLoc . " ORDER BY navigation.sort, navigation.name ASC");
    //returns: navigation.id, navigation.sort, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.active, navigation.win, navigation.loc_id, navigation.datetime, category_navigation.id, category_navigation.cat_name, category_navigation.loc_id, category_navigation.nav_loc_id
    $tempLink = 0;

    while ($rowNavLinks = mysqli_fetch_array($sqlNavLinks, MYSQLI_ASSOC)) {

        //Variables for $sqlNavLinks SQL Join
        $navLinksID = $rowNavLinks[0];
        $navLinksSort = $rowNavLinks[1];
        $navLinksName = $rowNavLinks[2];
        $navLinksUrl = $rowNavLinks[3];
        $navLinksCatId = $rowNavLinks[4];
        $navLinksSection = $rowNavLinks[5];
        $navLinksActive = $rowNavLinks[6];
        $navLinksWin = $rowNavLinks[7];
        $navLinksLocId = $rowNavLinks[8];
        $navLinksDateTime = $rowNavLinks[9];
        $navLinks_Author = $rowNavLinks[10];
        $navLinks_CatId = $rowNavLinks[11];
        $navLinks_CatName = $rowNavLinks[12];
        $navLinks_CatNavLocId = $rowNavLinks[13];

        //Check if link contains shortcode
        $navLinksUrl = getShortCode($navLinksUrl);

        //New Window
        if ($navLinksWin == 'true' || $navLinksWin == 'on'){
            $navWin = "target='_blank'";
        } else {
            $navWin = "";
        }

        //Create category - drop down menus
        if ($navLinksCatId == $navLinks_CatId && $navLinksCatId != 0){ //NOTE: 0=None in the category table

            if ($navLinksCatId != $tempLink){

                $sqlNavCatLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category_navigation ON navigation.catid=category_navigation.id WHERE section='$navSection' AND category_navigation.id=" . $navLinksCatId . " AND active='true' AND loc_id='" . $navDefaultLoc . "' ORDER BY navigation.sort, navigation.name ASC");
                //returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.active, navigation.win, navigation.loc_id, navigation.datetime, category_navigation.id, category_navigation.cat_name, category_navigation.nav_loc_id

                echo "<li class='$dropdown'>";
                echo "<a href='#' class='cat-$navSection' data-toggle='$dataToggle'>" . $navLinks_CatName . " $dropdownCaret</a>";
                echo "<ul class='$dropdownMenu'>";
                while ($rowNavCatLinks = mysqli_fetch_array($sqlNavCatLinks, MYSQLI_ASSOC)){

                    //Variables for $rowNavCatLinks SQL Join
                    $navCatLinksID = $rowNavCatLinks[0];
                    $navCatLinksSort = $rowNavCatLinks[1];
                    $navCatLinksName = $rowNavCatLinks[2];
                    $navCatLinksUrl = $rowNavCatLinks[3];
                    $navCatLinksCatID = $rowNavCatLinks[4];
                    $navCatLinksCatSection = $rowNavCatLinks[5];
                    $navCatLinksActive = $rowNavCatLinks[6];
                    $navCatLinksWin = $rowNavCatLinks[7];

                    //Check if cat link contains shortcode
                    $navCatLinksUrl = getShortCode($navCatLinksUrl);

                    //New Window
                    if ($navCatLinksWin == 'true' || $navCatLinksWin == 'on'){
                        $navCatWin = "target='_blank'";
                    } else {
                        $navCatWin = "";
                    }

                    echo "<li>";
                    echo "<a href='" . $navCatLinksUrl . "' $navCatWin>" . $navCatLinksName . "</a>";
                    echo "</li>";
                }
                echo "</ul>";
                echo "</li>";
            }

        } else {
            echo "<li>";
            echo "<a href='" . $navLinksUrl . "' $navWin>" . $navLinksName . "</a>";
            echo "</li>";
        }

        $tempLink = $navLinksCatId;

    }

    echo "</ul>";
}

function getSetup($loc){
    global $setupTitle;
    global $setupAuthor;
    global $setupKeywords;
    global $setupDescription;
    global $setupConfig;
    global $setupLs2pac;
    global $setupLs2kids;
    global $setupSearchDefault;
    global $setupLogo;
    global $setupLogoDefaults;
    global $db_conn;

    $sqlSetup = mysqli_query($db_conn, "SELECT title, author, keywords, description, config, logo, logo_use_defaults, ls2pac, ls2kids, searchdefault, loc_id FROM setup WHERE loc_id=" . $loc . " ");
    $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

    $setupDescription = $rowSetup['description'];
    $setupKeywords = $rowSetup['keywords'];
    $setupAuthor = $rowSetup['author'];
    $setupTitle = $rowSetup['title'];
    $setupConfig = $rowSetup['config'];
    $setupLogo = $rowSetup['logo'];
    $setupLs2pac = $rowSetup['ls2pac'];
    $setupLs2kids = $rowSetup['ls2kids'];
    $setupSearchDefault = $rowSetup['searchdefault'];
    $setupLogoDefaults = $rowSetup['logo_use_defaults'];
}

function getLogo($loc, $type){
    global $db_conn;
    global $getLogo;

    $sqlGetLogoDefault = mysqli_query($db_conn, "SELECT logo, loc_id FROM setup WHERE loc_id=1 ");
    $rowGetLogoDefault = mysqli_fetch_array($sqlGetLogoDefault, MYSQLI_ASSOC);
    $defaultLogo = $rowGetLogoDefault['logo'];

    $sqlGetLogoOptions = mysqli_query($db_conn, "SELECT logo, logo_use_defaults, loc_id FROM setup WHERE loc_id=" . $loc . " ");
    $rowGetLogoOptions = mysqli_fetch_array($sqlGetLogoOptions, MYSQLI_ASSOC);

    if ($rowGetLogoOptions['logo_use_defaults'] == 'true') {
        $getLogo = $defaultLogo;
    } else {
        $getLogo = $rowGetLogoOptions['logo'];
    }

    if ($type == 'absolute'){
        echo str_replace('..', serverUrlStr, $getLogo);
    } elseif ($type == 'relative') {
        echo $getLogo;
    } else {
        echo $getLogo;
    }

}

function getCoreHeader($loc, $addHeader=null){
    getLocation($loc);
    getSetup($loc);
    global $setupConfig;
    global $setupTitle;
    global $setupAuthor;
    global $setupKeywords;
    global $setupDescription;
    ?>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="refresh" content="3600; url=index.php?loc_id=<?php echo $loc; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=yes">
    <meta property="og:title" content="<?php echo $setupTitle; ?>"/>
    <meta property="og:url" content="<?php echo serverUrlStr; ?>"/>
    <meta property="og:site_name" content="<?php echo $setupTitle; ?>"/>
    <meta property="og:description" content="<?php echo $setupTitle; ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?php getLogo($loc, 'absolute'); ?>"/>
    <meta name="description" content="<?php echo $setupDescription; ?>">
    <meta name="keywords" content="<?php echo $setupKeywords; ?>">
    <meta name="author" content="<?php echo $setupAuthor; ?>">

    <title><?php echo $setupTitle; ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/images/favicon.ico">

    <!-- Core CSS Libraries -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/main.min.css?v=<?php echo ysmVersion; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/jquery-ui-1.10.4.custom.min.css?v=<?php echo ysmVersion; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/font-awesome.min.css?v=<?php echo ysmVersion; ?>">

    <!-- Default CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/core-style.min.css?v=<?php echo ysmVersion; ?>">

    <!--Dynamic CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/dynamic-style.php?loc_id=<?php echo $loc; ?>">

    <!-- Core JS Libraries -->
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/main.min.js?v=<?php echo ysmVersion; ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/jquery-ui-1.10.4.custom.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- LS2 search script -->
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/searchscript.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- Core js file-->
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/functions.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- getSearchString (version #, this, domain, config, branch, searchBoxType [ls2, kids5, kids, classic]?, new window?)-->
    <script type="text/javascript" language="javascript">
        var TLCDomain = "<?php echo setupPACURL; ?>";
        var TLCConfig = "<?php echo $setupConfig; ?>";
        var TLCBranch = "";
        var TLCClassicDomain = "<?php echo setupPACURL; ?>";
        var TLCClassicConfig = "<?php echo $setupConfig; ?>";
    </script>

    <?php
    //Google Analytics UID
    if (!empty(site_analytics)) {
        getGoogleAnalyticsTrackingCode(site_analytics);
    }
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <noscript>Javascript is not enabled in your browser.</noscript>
    <?php
    //if addHeader parameter exists.
    echo "\n" . $addHeader . "\n";
}

//Theme options
function getDynamicCss($loc){
    global $db_conn;

    header('Content-type: text/css; charset: UTF-8');
    header('Cache-control: must-revalidate');

    //Get setup table columns
    $sqlSetup = mysqli_query($db_conn, "SELECT theme_use_defaults, loc_id FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

    if ($rowSetup['theme_use_defaults'] == 'true') {
        $locId = 1;
    } else {
        $locId = $loc;
    }

    //Gets themeoptions
    $sqlGetThemeOpions = mysqli_query($db_conn, "SELECT id, themename, selector, property, cssvalue, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND loc_id=" . $locId . " ");
    while ($rowGetThemeOpions = mysqli_fetch_array($sqlGetThemeOpions, MYSQLI_ASSOC)){
        if (trim($rowGetThemeOpions['cssvalue']) != '#000000'){//Color Picker defaults to #000000 if the value is empty. To check if the value is empty, you have to check if value = #000000
            echo $rowGetThemeOpions['selector'] . " {" . trim($rowGetThemeOpions['property']) . ": " . trim($rowGetThemeOpions['cssvalue']) . " !important;}" . PHP_EOL;
        }
    }
}

//Gets the image path and converts it to absolute image path.
function getAbsoluteImagePath($imagePath){
    if (strpos($imagePath, '../uploads/') !== false){
        $absolutePath = serverUrlStr . str_replace('../', '/', $imagePath);
    } else {
        $absolutePath = $imagePath;
    }
    return $absolutePath;
}

function getSocialMediaIcons($loc, $shape, $section){
    //EXAMPLE: getSocialMediaIcons($_GET['loc_id'], "circle","top")
    //EXAMPLE: getSocialMediaIcons($_GET['loc_id'], "square","footer")
    global $socialMediaIcons;
    global $socialMediaHeading;
    global $sqlSocialMedia;
    global $rowSocialMedia;
    global $db_conn;

    $sqlSocialMedia = mysqli_query($db_conn, "SELECT * FROM socialmedia WHERE loc_id=" . $loc . " ");
    $rowSocialMedia = mysqli_fetch_array($sqlSocialMedia, MYSQLI_ASSOC);

    //use default location
    if ($rowSocialMedia['use_defaults'] == "true" || $rowSocialMedia['use_defaults'] == "" || $rowSocialMedia['use_defaults'] == NULL) {
        $sqlSocialMedia = mysqli_query($db_conn, "SELECT * FROM socialmedia WHERE loc_id=1 ");
        $rowSocialMedia = mysqli_fetch_array($sqlSocialMedia, MYSQLI_ASSOC);
    }

    $socialMediaHeading = "";
    $socialMediaIcons = "";

    if (!empty($rowSocialMedia['heading'])){
        $socialMediaHeading = $rowSocialMedia['heading'];
    }

    if (!empty($rowSocialMedia['facebook'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['facebook']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-facebook fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['google'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['google']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-google-plus fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['pinterest'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['pinterest']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-pinterest fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['twitter'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['twitter']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-twitter fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['instagram'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['instagram']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-instagram fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['youtube'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['youtube']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-youtube fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['tumblr'])){
        $socialMediaIcons .= "<a href=" . trim($rowSocialMedia['tumblr']) . " target='_blank'><span class='fa-stack fa-2x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-tumblr fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }
}

function getCustomers($loc, $custType){
    //getCustomers($_GET['loc_id'], 'featured')
    //getCustomers($_GET['loc_id'], NULL)
    global $sqlCustomers;
    global $customerHeading;
    global $customerBlurb;
    global $customerNumRows;
    global $customerFeatured;
    global $customerIcon;
    global $customerSort;
    global $customerCatId;
    global $customerCatName;
    global $customerCatSort;
    global $custDefaultLoc;
    global $customerSection;
    global $db_conn;

    if (!empty($_GET['section'])) {
        $customerSection = $_GET['section'];
    } else {
        $customerSection = '1';
    }

    //get the default values from setup table where get loc_id
    $sqlCustomerSetup = mysqli_query($db_conn, "SELECT use_defaults, section FROM sections_customers WHERE section='".$customerSection."' AND loc_id=" . $loc . " ");
    $rowCustomerSetup = mysqli_fetch_array($sqlCustomerSetup, MYSQLI_ASSOC);

    //toggle default location value if conditions are true
    if ($customerSection == $rowCustomerSetup['section'] && $rowCustomerSetup['use_defaults'] == 'true') {
        $custDefaultLoc = 1;
    } else {
        $custDefaultLoc = $loc;
    }

    //sets to use defaults if conditions are true where loc_id = $custDefaultLoc
    $sqlCustomerSetup = mysqli_query($db_conn, "SELECT use_defaults, section, heading, content FROM sections_customers WHERE section='".$customerSection."' AND loc_id=" . $custDefaultLoc . " ");
    $rowCustomerSetup = mysqli_fetch_array($sqlCustomerSetup, MYSQLI_ASSOC);

    //toggle default location value if conditions are true
    if ($customerSection == $rowCustomerSetup['section'] && $rowCustomerSetup['use_defaults'] == 'true') {
        $customerHeading = $rowCustomerSetup['heading'];
        $customerBlurb = $rowCustomerSetup['content'];
    }

    //Get Category
    //If cat_id=int then display a page of databases for only that category
    if (!empty($_GET['cat_id'])) {
        $sqlCatCustomers = mysqli_query($db_conn, "SELECT id, name, sort FROM category_customers WHERE id IN (SELECT catid, section FROM customers WHERE section='".$customerSection."' AND catid = " . $_GET['cat_id'] . " AND loc_id=" . $custDefaultLoc . ")");
        $rowCatCustomers = mysqli_fetch_array($sqlCatCustomers, MYSQLI_ASSOC);
        $customerCatId = $rowCatCustomers[0];
        $customerCatName = $rowCatCustomers[1];
        $customerCatSort = $rowCatCustomers[2];
        $customerCatWhere = "catid=" . $_GET['cat_id'] . " AND ";
    } else {
        $customerCatWhere = "";
    }

    if ($custType == "featured") {
        $customerSectionWhere = "featured='true' AND ";
    } else {
        $customerSectionWhere = "section='" . $customerSection . "' AND ";
    }

    $sqlCustomers = mysqli_query($db_conn, "SELECT id, image, icon, name, section, link, catid, content, featured, sort, datetime, active, loc_id FROM customers WHERE active='true' AND " . $customerSectionWhere . " " . $customerCatWhere . " loc_id=" . $custDefaultLoc . " ORDER BY catid, sort, name ASC"); //While loop
    $customerNumRows = mysqli_num_rows($sqlCustomers);

}

function getSlider($loc, $sliderType){
    //EXAMPLE: getSlider($_GET['loc_id'], "slide")
    //EXAMPLE: getSlider($_GET['loc_id'], "random")
    global $sliderLink;
    global $sliderCount;
    global $sliderTitle;
    global $sliderContent;
    global $sliderImage;
    global $sliderImageList;
    global $sliderImageArr;
    global $sliderLocType;
    global $imagePath;
    global $locTypes;
    global $db_conn;

    if ($sliderType == "slide"){
        $sliderOrderBy = "ORDER BY sort, title ASC";
    } elseif ($sliderType == "random" || $sliderType == ""){
        $sliderOrderBy = "ORDER BY RAND() LIMIT 1";
    }

    $sliderCount = 0;
    $imagePath = $loc;

    //get location type from locations table
    $sqlLocations = mysqli_query($db_conn, "SELECT id, name, type FROM locations WHERE id=" . $loc . " ");
    $rowLocations = mysqli_fetch_array($sqlLocations, MYSQLI_ASSOC);

    $sliderLocType = $rowLocations['type'];

    if ($sliderLocType == '' || $sliderLocType == NULL || $sliderLocType == $locTypes[0]){
        $locTypeWhere = "loc_type IN ('".$locTypes[0]."', 'All') AND ";
    } else {
        $locTypeWhere = "loc_type IN ('".$sliderLocType."', 'All') AND ";
    }

    //get the default value from setup table
    $sqlSliderSetup = mysqli_query($db_conn, "SELECT slider_use_defaults FROM setup WHERE loc_id=" . $loc . " ");
    $rowSliderSetup = mysqli_fetch_array($sqlSliderSetup, MYSQLI_ASSOC);

    $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, loc_type, sort, startdate, enddate, active, loc_id FROM slider WHERE active='true' AND $locTypeWhere loc_id=" . $loc . " $sliderOrderBy");
    $sliderNumRows = mysqli_num_rows($sqlSlider);

    //use default location
    if ($rowSliderSetup['slider_use_defaults'] == "true" || $rowSliderSetup['slider_use_defaults'] == "" || $rowSliderSetup['slider_use_defaults'] == NULL) {
        $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, loc_type, sort, startdate, enddate, active, loc_id FROM slider WHERE active='true' AND $locTypeWhere loc_id=1 $sliderOrderBy");
        $sliderNumRows = mysqli_num_rows($sqlSlider);

        $imagePath = 1; //the default location
    }

    //hide carousel arrows if only one image is available
    if ($sliderNumRows == 1){
        echo "<style>#sliderCarousel .carousel-control {display: none !important;}</style>";
    }

    if ($sliderNumRows > 0){

        if ($sliderType == "slide"){

            //Wrapper for slides
            echo "<div class='carousel-inner'>";
            while ($rowSlider = mysqli_fetch_array($sqlSlider, MYSQLI_ASSOC)){

                //check if slide is with in date range
                if (strtotime(date('Y-m-d')) >= strtotime($rowSlider['startdate']) && strtotime(date('Y-m-d')) <= strtotime($rowSlider['enddate'])) {

                    $sliderCount++;

                    if ($sliderCount == 1) {
                        $slideActive = "active";
                    } else {
                        $slideActive = "";
                    }

                    echo "<div class='item $slideActive'>";

                    if (!empty($rowSlider['image'])) {
                        echo "<div class='fill img-responsive img-full' style='background-image:url(" . getAbsoluteImagePath($rowSlider['image']) . ");'></div>";
                    } else {
                        echo "<div class='fill img-responsive img-full'></div>";
                    }

                    echo "<div class='carousel-caption'>";

                    echo "<h2>" . $rowSlider['title'] . "</h2>";
                    echo "<p>" . $rowSlider['content'] . "</p>";


                    if ($rowSlider['link']) {
                        echo "<a target='_blank' href='" . $rowSlider['link'] . "' class='btn btn-primary slider-link'>Learn More</a>";
                    }

                    echo "</div>"; //.carousel-caption

                    echo "</div>"; //.item

                } //end of startdate check

                $sliderImageList .= getAbsoluteImagePath($rowSlider['image']) . ",";

            }//end of while loop

            //Controls
            echo "<a class='left carousel-control' href='#sliderCarousel' data-slide='prev'>";
            echo "<i class='icon-prev'></i>";
            echo "</a>";
            echo "<a class='right carousel-control' href='#sliderCarousel' data-slide='next'>";
            echo "<i class='icon-next'></i>";
            echo "</a>";

            echo "</div>"; //.carousel-inner

        } elseif ($sliderType == "random"){
            $rowSlider = mysqli_fetch_array($sqlSlider, MYSQLI_ASSOC);
            //check if slide is with in date range
            if (strtotime(date('Y-m-d')) >= strtotime($rowSlider['startdate']) && strtotime(date('Y-m-d')) <= strtotime($rowSlider['enddate'])) {

                echo "<div class='carousel-inner'>";

                echo "<div class='item active'>";

                if (!empty($rowSlider['image'])) {
                    echo "<div class='fill' style='background-image:url(" . getAbsoluteImagePath($rowSlider['image']) . ");'></div>";
                } else {
                    echo "<div class='fill'></div>";
                }

                echo "<div class='carousel-caption'>";

                echo "<h2>" . $rowSlider['title'] . "</h2>";
                echo "<p>" . $rowSlider['content'] . "</p>";

                if ($rowSlider['link']) {
                    echo "<a target='_blank' href='" . $rowSlider['link'] . "' class='btn btn-primary'>Learn More</a>";
                }

                echo "</div>"; //.carousel-caption

                echo "</div>"; //.item

                echo "</div>"; //.carousel-inner

                $sliderImageList = getAbsoluteImagePath($rowSlider['image']);
            }
        } else {
            $rowSlider = mysqli_fetch_array($sqlSlider, MYSQLI_ASSOC);
            $sliderLink = $rowSlider['link'];
            $sliderTitle = $rowSlider['title'];
            $sliderContent = $rowSlider['content'];
            $sliderImage = getAbsoluteImagePath($rowSlider['image']);
            $sliderLocType = $rowSlider['loc_type'];
            $sliderImageList = getAbsoluteImagePath($rowSlider['image']);
        }

        //Clean sliderImageList
        $sliderImageList = rtrim($sliderImageList, ",");
        $sliderImageArr = explode(",", $sliderImageList);

    }
}
function getGeneralInfo($loc){
    global $generalInfoContent;
    global $generalInfoHeading;
    global $db_conn;

    $sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, use_defaults FROM generalinfo WHERE loc_id=" . $loc . " ");
    $rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo, MYSQLI_ASSOC);

    //use default location
    if ($rowGeneralinfo['use_defaults'] == "true" || $rowGeneralinfo['use_defaults'] == "" || $rowGeneralinfo['use_defaults'] == NULL){
        $sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, use_defaults FROM generalinfo WHERE loc_id=1 ");
        $rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo, MYSQLI_ASSOC);
    }

    if (!empty($rowGeneralinfo['content'])){
        $generalInfoContent = $rowGeneralinfo['content'];
    }

    if (!empty($rowGeneralinfo['heading'])){
        $generalInfoHeading = $rowGeneralinfo['heading'];
    }
}
function getFeatured($loc){
    global $featuredContent;
    global $featuredHeading;
    global $featuredBlurb;
    global $imagePath;
    global $db_conn;

    $sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, use_defaults FROM featured WHERE loc_id=" . $loc . " ");
    $rowFeatured = mysqli_fetch_array($sqlFeatured, MYSQLI_ASSOC);
    $imagePath = $loc;

    if ($rowFeatured['use_defaults'] == "true" || $rowFeatured['use_defaults'] == "" || $rowFeatured['use_defaults'] == NULL){
        $sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content FROM featured WHERE loc_id=1 ");
        $rowFeatured = mysqli_fetch_array($sqlFeatured, MYSQLI_ASSOC);

        $imagePath = 1;
    }

    if (!empty($rowFeatured['heading'])){
        $featuredHeading = $rowFeatured['heading'];
    }

    if (!empty($rowFeatured['introtext'])){
        $featuredBlurb = $rowFeatured['introtext'];
    }

    if (!empty($rowFeatured['content'])){
        $featuredContent = $rowFeatured['content'];
    }

}
function getEvents($loc){
    global $eventAlert;
    global $eventHeading;
    global $eventStartdate;
    global $eventEnddate;
    global $eventCalendar;
    global $eventAlertDateCheck;
    global $db_conn;

    $sqlEvent = mysqli_query($db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, author_name, datetime, loc_id FROM events WHERE loc_id=" . $loc . " ");
    $rowEvent = mysqli_fetch_array($sqlEvent, MYSQLI_ASSOC);

    if ($rowEvent['use_defaults'] == "true" || $rowEvent['use_defaults'] == "" || $rowEvent['use_defaults'] == NULL){
        $sqlEvent = mysqli_query($db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, author_name, datetime, loc_id FROM events WHERE loc_id=1");
        $rowEvent = mysqli_fetch_array($sqlEvent, MYSQLI_ASSOC);
    }

    if (!empty($rowEvent['heading'])){
        $eventHeading = $rowEvent['heading'];
    }

    if (!empty($rowEvent['alert'])){
        $eventAlert = $rowEvent['alert'];
        $eventStartdate = $rowEvent['startdate'];
        $eventEnddate = $rowEvent['enddate'];

        if (strtotime(date('Y-m-d')) >= strtotime($eventStartdate) && strtotime(date('Y-m-d')) <= strtotime($eventEnddate)) {
            $eventAlertDateCheck = 'true';
        } else {
            $eventAlertDateCheck = 'false';
        }
    }

    if (!empty($rowEvent['calendar'])){
        $eventCalendar = $rowEvent['calendar'];
    }
}

function getHottitlesCarousel($xmlurl, $jacketSize, $dummyJackets, $maxcnt) {
    //getHottitlesCarousel("http://mylibrary.com:8080/list/dynamic/1921419/rss", 'MD', 'true', 30);

    $jacketSize = strtoupper($jacketSize);

    $checkUrl = 'https://ls2content.tlcdelivers.com/tlccontent?customerid='.customerNumber.'&appid=ls2pac&requesttype=BOOKJACKET-SM&isbn=123456789';

    //Check if customerid is set up on the content server
    if (!empty(customerNumber)) {

        $ch = curl_init($checkUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        //Check for 404 (file not found) OR 403 (access denied)
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_status != 200 || curl_errno($ch) > 0) {
            echo "HTTP status: " . $http_status . ". Error loading URL. " . curl_errno($ch) . "." . PHP_EOL;
            echo "Not a valid Customer ID " . customerNumber . "." . PHP_EOL;
            curl_close($ch);
            die();
        }

        curl_close($ch);

    } else {

        die('URL not found or parameters are not correct.');
    }

    if (!empty($xmlurl)) {
        $ch = curl_init();
        $timeout = 20;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $xmlurl);    // get the url contents
        $xmldata = curl_exec($ch); // execute curl request
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //catch and print error message
        if ($http_status != 200 || curl_errno($ch) > 0) {
            echo "HTTP status: " . $http_status . ". Error loading URL. " . curl_errno($ch) . PHP_EOL;
            echo "Could not read " . $xmlurl . "." . PHP_EOL;
            curl_close($ch);
            die();
        }

        curl_close($ch);

        $xmlfeed = simplexml_load_string($xmldata);

    } else {

        die('URL not found or parameters are not correct.');
    }

    $itemcount = 0;

    //Use the ls2content round-robin load balancer
    $loadBalancerArr = array(NULL, 2, 3, 4);
    $loadBalancer = $loadBalancerArr[array_rand($loadBalancerArr)];

    //Set a maximum maxcnt
    if ($maxcnt >= 50) {
        $maxcnt = 50;
    }

    echo "<div class='owl-carousel owl-theme'>";
        if (strstr($xmlurl, '/econtent/')) {
            //Content server XML Lists - NYTimes

            foreach ($xmlfeed->Book as $xmlitem) {

                $itemcount++;

                //get title node for each book
                $xmltitle = (string)$xmlitem->Title;

                //get ISBN node for each book
                $xmlisbn = (string)$xmlitem->ISBN;

                //https://ls2content2.tlcdelivers.com/tlccontent?customerid=960748&appid=ls2pac&requesttype=BOOKJACKET-MD&isbn=9781597561075
                $xmlimage = "https://ls2content".$loadBalancer.".tlcdelivers.com/tlccontent?customerid=".customerNumber."&appid=ls2pac&requesttype=BOOKJACKET-$jacketSize&isbn=$xmlisbn";

                //http://173.163.174.146:8080/?config=ysm#section=search&term=The Black Book
                $xmllink = setupPACURL."/?config=ysm#section=search&term=".$xmltitle;

                //Gets the image dimensions from the xmltheimage url as an array.
                $xmlimagesize = getimagesize($xmlimage);
                $xmlimagewidth = $xmlimagesize[0];
                $xmlimageheight = $xmlimagesize[1];

                echo "<div class='item'>";

                //Check if has book jacket based on the image size (1x1)
                if ($xmlimageheight > '1' && $xmlimagewidth > '1') {
                    echo "<a href='" . htmlspecialchars($xmllink, ENT_QUOTES) . "' title='" . htmlspecialchars($xmltitle, ENT_QUOTES) . "' target='_blank' data-resource-isbn='" . $xmlisbn . "' data-item-count='" . $itemcount . "'><img src='" . htmlspecialchars($xmlimage, ENT_QUOTES) . "' class='img-responsive center-block $jacketSize'></a>";
                } else {
                    if ($dummyJackets == 'true') {
                        //TLC dummy book jacket img
                        echo "<a href='" . htmlspecialchars($xmllink, ENT_QUOTES) . "' title='" . htmlspecialchars($xmltitle, ENT_QUOTES) . "' target='_blank' data-resource-isbn='" . $xmlisbn . "' data-item-count='" . $itemcount . "'><span class='dummy-title'>" . htmlspecialchars($xmltitle, ENT_QUOTES) . "</span><img class='dummy-jacket $jacketSize img-responsive center-block' src='../core/images/gray-bookjacket-".strtolower($jacketSize).".png'></a>";
                    }
                }

                echo "</div>";

                //stop parsing xml once it reaches the max count
                if ($itemcount == $maxcnt) {
                    break;
                }
            }
        } elseif (strstr($xmlurl, '/list/')) {
            //LS2PAC Saved Search XML Lists

            foreach ($xmlfeed->channel->item as $xmlitem) {

                $itemcount++;

                //get title node for each book
                $xmltitle = (string)$xmlitem->title;

                //get url for each book
                $xmllink = (string)$xmlitem->link;

                //Get the ResourceID from the xmllink
                parse_str($xmllink, $xmllinkArray);
                $xmlResourceId = $xmllinkArray['resourceId'];

                //get image url from img tag in the description node
                preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', (string)$xmlitem->description, $xmltheimage);

                //set the image url. clean the image url string
                $xmlimage = $xmltheimage[1];

                //Replace http with https
                $xmlimage = trim(str_replace('http:', 'https:', $xmlimage));

                //Use the ls2content round-robin load balancer
                $xmlimage = trim(str_replace("ls2content", "ls2content".$loadBalancer."", $xmlimage));

                if ($jacketSize == 'SM') {
                    $xmlimage = trim(str_replace('BOOKJACKET-MD', 'BOOKJACKET-SM', $xmlimage));
                    $xmlimage = trim(str_replace('BOOKJACKET-LG', 'BOOKJACKET-SM', $xmlimage));
                } elseif ($jacketSize == 'MD') {
                    $xmlimage = trim(str_replace('BOOKJACKET-SM', 'BOOKJACKET-MD', $xmlimage));
                    $xmlimage = trim(str_replace('BOOKJACKET-LG', 'BOOKJACKET-MD', $xmlimage));
                } elseif ($jacketSize == 'LG') {
                    $xmlimage = trim(str_replace('BOOKJACKET-SM', 'BOOKJACKET-LG', $xmlimage));
                    $xmlimage = trim(str_replace('BOOKJACKET-MD', 'BOOKJACKET-LG', $xmlimage));
                }

                //Gets the image dimensions from the xmltheimage url as an array.
                $xmlimagesize = getimagesize($xmltheimage[1]);
                $xmlimagewidth = $xmlimagesize[0];
                $xmlimageheight = $xmlimagesize[1];

                echo "<div class='item'>";

                //Check if has book jacket based on the image size (1x1)
                if ($xmlimageheight > '1' && $xmlimagewidth > '1') {
                    echo "<a href='" . htmlspecialchars($xmllink, ENT_QUOTES) . "' title='" . htmlspecialchars($xmltitle, ENT_QUOTES) . "' target='_blank' data-resource-id='" . $xmlResourceId . "' data-item-count='" . $itemcount . "'><img src='" . htmlspecialchars($xmlimage, ENT_QUOTES) . "' class='img-responsive center-block $jacketSize'></a>";
                } else {
                    if ($dummyJackets == true) {
                        //TLC dummy book jacket img
                        echo "<a href='" . htmlspecialchars($xmllink, ENT_QUOTES) . "' title='" . htmlspecialchars($xmltitle, ENT_QUOTES) . "' target='_blank' data-resource-id='" . $xmlResourceId . "' data-item-count='" . $itemcount . "'><span class='dummy-title'>" . htmlspecialchars($xmltitle, ENT_QUOTES) . "</span><img class='dummy-jacket $jacketSize img-responsive center-block' src='../core/images/gray-bookjacket-".strtolower($jacketSize).".png'></a>";
                    }
                }

                echo "</div>";

                //stop parsing xml once it reaches the max count
                if ($itemcount == $maxcnt) {
                    break;
                }

            } //end for loop
        }
    echo "</div>";
}

function getHottitlesTabs($loc){
    global $hottitlesTile;
    global $hottitlesUrl;
    global $hottitlesLoadFirstUrl;
    global $hottitlesLocID;
    global $hottitlesTabs;
    global $hottitlesCount;
    global $hottitlesHeading;
    global $locTypes;
    global $db_conn;

    //get the heading value from setup table
    $sqlHottitlesSetup = mysqli_query($db_conn, "SELECT hottitlesheading, loc_id FROM setup WHERE loc_id=" . $loc. " ");
    $rowHottitlesSetup = mysqli_fetch_array($sqlHottitlesSetup, MYSQLI_ASSOC);
    $hottitlesHeading = $rowHottitlesSetup['hottitlesheading'];

    //get location type from locations table
    $sqlLocations = mysqli_query($db_conn, "SELECT id, name, type FROM locations WHERE id=" . $loc . " ");
    $rowLocations = mysqli_fetch_array($sqlLocations, MYSQLI_ASSOC);

    if ($rowLocations['type'] == '' || $rowLocations['type'] == NULL || $rowLocations['type'] == $locTypes[0]){
        $hottitlesLocType = $rowLocations['type'];
        $locTypeWhere = "loc_type IN ('".$locTypes[0]."', 'All') AND";
    } else {
        $hottitlesLocType = $rowLocations['type'];
        $locTypeWhere = "loc_type IN ('".$hottitlesLocType."', 'All') AND";
    }

    //get the default value from setup table
    $sqlHottitlesSetup = mysqli_query($db_conn, "SELECT hottitlesheading, hottitles_use_defaults, loc_id FROM setup WHERE loc_id=" . $loc . " ");
    $rowHottitlesSetup = mysqli_fetch_array($sqlHottitlesSetup, MYSQLI_ASSOC);

    $sqlHottitles = mysqli_query($db_conn, "SELECT id, title, url, loc_type, sort, active, loc_id FROM hottitles WHERE active='true' AND $locTypeWhere loc_id=" . $loc . " ORDER BY sort ASC");
    $hottitlesLocID = $loc;

    //use default location
    if ($rowHottitlesSetup['hottitles_use_defaults'] == "true" || $rowHottitlesSetup['hottitles_use_defaults'] == "" || $rowHottitlesSetup['hottitles_use_defaults'] == NULL) {
        $sqlHottitles = mysqli_query($db_conn, "SELECT id, title, url, loc_type, sort, active, loc_id FROM hottitles WHERE active='true' AND $locTypeWhere loc_id=1 ORDER BY sort ASC");
        $hottitlesLocID = 1;
    }

    $hottitlesCount = 0;

    while ($rowHottitles = mysqli_fetch_array($sqlHottitles, MYSQLI_ASSOC)) {

        $hottitlesSort = trim($rowHottitles['sort']);
        $hottitlesTile = trim($rowHottitles['title']);
        $hottitlesUrl = trim($rowHottitles['url']);
        $hottitlesLocType = trim($rowHottitles['loc_type']);
        $hottitlesCount ++;

        //Set active tab on initial page load where count=1
        if ($hottitlesCount == 1) {
            $hotActive = 'active';
            $hottitlesLoadFirstUrl = $hottitlesUrl;
        } else {
            $hotActive = '';
        }

        if ($hottitlesCount > 0) {
            $hottitlesTabs .=  "<li class='hot-tab $hotActive'><a data-toggle='tab' onclick=\"toggleSrc('$hottitlesUrl', '$hottitlesLocID', '$hottitlesCount');\">$hottitlesTile</a></li>";
        }
    }
}

function getSiteSearchResults($searchTerm, $showPageContent) {
    //getSiteSearchResults('how do i check out a book', true = shows page contents in search results)
    global $db_conn;
    global $siteSearchId;
    global $siteSearchLodId;
    global $siteSearchTitle;
    global $siteSearchContent;
    global $siteSearchCount;

    $siteSearchTerm = "%".mysqli_real_escape_string($db_conn, strip_tags(trim($searchTerm)))."%";
    $siteSearchCount = 0;

    $sqlSiteSearch = mysqli_query($db_conn, "SELECT id, title, content, active, loc_id FROM pages WHERE title LIKE '$siteSearchTerm' OR content LIKE '$siteSearchTerm' ORDER BY title ASC ");

    while ($rowSiteSearch = mysqli_fetch_array($sqlSiteSearch, MYSQLI_ASSOC)) {
        $siteSearchCount ++;
        $siteSearchId = $rowSiteSearch['id'];
        $siteSearchLodId = $rowSiteSearch['loc_id'];
        $siteSearchTitle = $rowSiteSearch['title'];
        $siteSearchContent = $rowSiteSearch['content'];
        $siteSearchActive = $rowSiteSearch['active'];

        if ($siteSearchActive == 'true') {
            echo "<hr/><h3 class='post-title'><a href='page.php?loc_id=$siteSearchLodId&page_id=$siteSearchId' target='_self'>" . $siteSearchTitle . "</a></h3>" . PHP_EOL;

            if ($showPageContent == 'true') {
                echo "<p class='post-content'>" . $siteSearchContent . "</p><br/>" . PHP_EOL;
            }
        }
    }
}

function getUrlContents($getUrl) {
    $ch = curl_init();
    $timeout = 10;
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo "HTTP status ".$http_status.". Error loading URL. " .curl_error($ch);
        curl_close($ch);
        die();
    }
    curl_close($ch);

    return $data;
}

//Call - getSetup is used everywhere
getSetup($_GET['loc_id']);

//Random string generator - used to create a unique md5 referrer
function generateRandomString($length = 10){
    global $randomString;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return md5($randomString);
}

//Short Code function. Use [my_vals] in the Admin Panel to pull in values from the database
function getShortCode($urlStr){
    global $setupConfig;

    //add a space to the front of var so that str_replace will see it. strange, right?
    $urlStr = ' ' . $urlStr;

    $urlStr = str_replace('[pac_url]', setupPACURL, $urlStr);

    $urlStr = str_replace('[homepage_url]', homePageURL, $urlStr);

    $urlStr = str_replace('[config]', $setupConfig, $urlStr);

    $urlStr = str_replace('[loc_id]', $_GET['loc_id'], $urlStr);

    return trim($urlStr);
}
//Google Analytic Tracker Code
function getGoogleAnalyticsTrackingCode($uidcode){
    if (!empty($uidcode)) {
        ?>
        <!-- Google Analytics -->
        <script type="text/javascript" language="javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $uidcode; ?>']);
            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <?php
    }
}
//Google Translate Widget
//getGoogleTranslateCode('ar,en,es,fr,pl,tl,uk,ur,vi,zh-CN')
function getGoogleTranslateCode($languages){
    ?>
    <!-- Google Translate -->
    <div id="google_translate_element"></div>
    <script type="text/javascript" language="javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: '<?php echo $languages; ?>',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <?php
}

//Call these functions depending on which page you are visiting
//Sets the page title and calls the main function for each page.
if (basename($_SERVER['PHP_SELF']) == "page.php"){
    getPage($_GET['loc_id']);
    $theTitle = $setupTitle . " - " . $pageTitle;
} elseif (basename($_SERVER['PHP_SELF']) == "contact.php"){
    getContactInfo($_GET['loc_id']);
    $theTitle = $setupTitle . " - " . $contactHeading;
} elseif (basename($_SERVER['PHP_SELF']) == "services.php"){
    getServices($_GET['loc_id']);
    $theTitle = $setupTitle . " - " . $servicesHeading;
} elseif (basename($_SERVER['PHP_SELF']) == "staff.php"){
    getTeam($_GET['loc_id']);
    $theTitle = $setupTitle . " - " . $teamHeading;
} elseif (basename($_SERVER['PHP_SELF']) == "databases.php"){
    getCustomers($_GET['loc_id'], NULL);
    $theTitle = $setupTitle . " - " . $customerHeading;
} else {
    $theTitle = $setupTitle;
}

//redirect to default location if loc_id or script name not defined
if (empty($_GET['loc_id'])){

    if (basename($_SERVER['PHP_SELF']) == ""){
        $pageRedirect = 'index.php?loc_id=1';
    } else {
        $pageRedirect = basename($_SERVER['PHP_SELF']) . '?loc_id=1';
    }

    header("Location: $pageRedirect");
    echo "<script>window.location.href='" . $pageRedirect . "';</script>";

} elseif (multiBranch == "false" && $_GET['loc_id'] != 1){
    header("Location: index.php?loc_id=1");
    echo "<script>window.location.href='index.php?loc_id=1';</script>";
}

//location search box redirect to loc_id where loc_name = querystring
if (!empty($_GET['loc_name'])){

    $sqlLocName = mysqli_query($db_conn, "SELECT name, id, active FROM locations WHERE active='true' AND name='" . $_GET['loc_name'] . "' LIMIT 1");
    $rowLocName = mysqli_fetch_array($sqlLocName, MYSQLI_ASSOC);

    header("Location: " . basename($_SERVER['PHP_SELF']) . "?loc_id=" . $rowLocName['id'] . "");
    echo "<script>window.location.href='" . basename($_SERVER['PHP_SELF']) . '?loc_id=' . $rowLocName['id'] . "';</script>";
}
?>