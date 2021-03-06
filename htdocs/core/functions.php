<?php
//Front-end functions used in templates and themes

function getLocation($loc)
{
    global $locationName;
    global $locationActive;
    global $locationID;
    global $db_conn;

    if (isset($loc) && ctype_digit($loc)) {

        $sqlGetLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' AND id=" . $loc . ";");
        $rowGetLocation = mysqli_fetch_array($sqlGetLocation, MYSQLI_ASSOC);

        if ($rowGetLocation['active'] == 'true' && $loc == $rowGetLocation['id']) {
            $locationName = $rowGetLocation['name'];
            $locationActive = $rowGetLocation['active'];
            $locationID = $rowGetLocation['id'];
        } else {
            header("Location: index.php?loc_id=1", true, 302);
            echo "<script>window.location.href='index.php?loc_id=1';</script>";
        }

    }
}

function getLocList($active, $showActiveOnly)
{
    global $locationListJson;
    global $db_conn;

    $active = loc_id;

    if ($showActiveOnly == 'true') {
        $showActive = "WHERE active='true'";
    } else {
        $showActive = "";
    }

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name, active FROM locations " . $showActive . " ORDER BY name ASC;");
    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch, MYSQLI_ASSOC)) {
        $locationListJson .= "'" . $rowLocationSearch['name'] . "',";
    }
    echo $locationListJson;
}

function getPageList()
{
    global $pageListJson;
    global $db_conn;

    $sqlGetPageList = mysqli_query($db_conn, "SELECT title, active FROM pages WHERE active='true';");
    while ($rowPageList = mysqli_fetch_array($sqlGetPageList, MYSQLI_ASSOC)) {
        $pageListJson .= "'" . $rowPageList['title'] . "',";
    }
    echo $pageListJson;
}

function getPage($loc, $start_from = null, $rows_limit = null)
{
    global $pageTitle;
    global $pageSubHeading;
    global $pageContent;
    global $pageKeywords;
    global $pageImage;
    global $pageFeaturedImageActive;
    global $pageCreated;
    global $pageId;
    global $pageArray;
    global $getPageKeywords;
    global $pageHeading;
    global $pageTotal;
    global $db_conn;

    $limit = '';

    if (!is_null($rows_limit) && is_null($start_from)) {
        $limit = 'LIMIT ' . $rows_limit;
    } elseif (!is_null($rows_limit) && !is_null($start_from)) {
        $limit = 'LIMIT ' . $start_from . ',' . $rows_limit;
    }

    $pageArray = array();
    $pageHeading = '';

    if (isset($_GET['page_id']) && !empty($_GET['page_id'])) {
        $pageId = trim($_GET['page_id']);
    } else {
        $pageId = null;
    }

    if (isset($_GET['keywords']) && !empty($_GET['keywords'])) {
        $getPageKeywords = trim($_GET['keywords']);
    } else {
        $getPageKeywords = null;
    }

    if (isset($loc) && !empty($loc)) {

        //get page heading from setup table
        $sqlSetup = mysqli_query($db_conn, "SELECT pageheading FROM setup WHERE loc_id=" . loc_id . " LIMIT 1;");
        $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

        $pageHeading = $rowSetup['pageheading'];

        //Get total number of active pages
        $sqlPageTotal = mysqli_query($db_conn, "SELECT count(id) FROM pages WHERE active='true' AND loc_id=" . $loc . ";");
        $rowPageTotal = mysqli_fetch_row($sqlPageTotal);

        $pageTotal = $rowPageTotal[0];

        //return single page
        if (ctype_digit($pageId)) {
            //get one item where page_id
            $sqlPage = mysqli_query($db_conn, "SELECT id, title, sub_heading, content, keywords, image, featured_image_active, created, active, loc_id FROM pages WHERE active='true' AND id=" . $pageId . " AND loc_id=" . $loc . " LIMIT 1;");
            $rowPage = mysqli_fetch_array($sqlPage, MYSQLI_ASSOC);

            $pageArray = $rowPage;

            if ($rowPage['active'] == 'true' && $pageId == $rowPage['id']) {

                $pageTitle = $rowPage['title'];
                $pageSubHeading = $rowPage['sub_heading'];
                $pageContent = $rowPage['content'];
                $pageKeywords = $rowPage['keywords'];
                $pageImage = $rowPage['image'];
                $pageFeaturedImageActive = $rowPage['featured_image_active'];
                $pageCreated = $rowPage['created'];
            }

            //return an array of all pages
        } elseif (!$pageId) {

            if ($getPageKeywords) {
                //Get total number of active pages where keyword matches
                $sqlPageTotal = mysqli_query($db_conn, "SELECT count(id) FROM pages WHERE active='true' AND keywords LIKE '%" . $getPageKeywords . "%' AND loc_id=" . $loc . ";");
                $rowPageTotal = mysqli_fetch_row($sqlPageTotal);

                $pageTotal = $rowPageTotal[0];

                $sqlPage = mysqli_query($db_conn, "SELECT id, title, sub_heading, content, keywords, image, featured_image_active, active, created, loc_id FROM pages WHERE active='true' AND keywords LIKE '%" . $getPageKeywords . "%' ORDER BY created DESC $limit;");
                $rowPage = mysqli_fetch_all($sqlPage, MYSQLI_ASSOC);
            } else {
                //search using keyword
                $sqlPage = mysqli_query($db_conn, "SELECT id, title, sub_heading, content, keywords, image, featured_image_active, active, created, loc_id FROM pages WHERE active='true' AND loc_id=" . $loc . " ORDER BY created DESC $limit;");
                $rowPage = mysqli_fetch_all($sqlPage, MYSQLI_ASSOC);
            }

            $pageArray = $rowPage;
        }
    }
}

function getContactInfo($loc)
{
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
    global $contactActive;
    global $db_conn;

    if (isset($loc) && !empty($loc)) {

        $sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, use_defaults, hours, active FROM contactus WHERE active = 'true' AND loc_id=" . $loc . ";");
        $rowContact = mysqli_fetch_array($sqlContact, MYSQLI_ASSOC);

        if ($rowContact['use_defaults'] == "true" || $rowContact['use_defaults'] == "" || $rowContact['use_defaults'] == null) {
            $sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, use_defaults, hours, active FROM contactus WHERE active = 'true' AND loc_id=1;");
            $rowContact = mysqli_fetch_array($sqlContact, MYSQLI_ASSOC);
        }

        if ($rowContact) {

            $contactActive = true;

            if (isset($_GET['msgsent']) == "thankyou") {
                $contactFormMsg = "<div id='success'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='#'\">×</button><strong>Your message has been sent. </strong></div></div>";
            } elseif (isset($_GET['msgsent']) == "error") {
                $contactFormMsg = "<div id='success'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='#'\">×</button><strong>An error occured while sending your message. </strong></div></div>";
            } else {
                $contactFormMsg = "";
            }

            if (!empty($rowContact['heading'])) {
                $contactHeading = $rowContact['heading'];
            }

            if (!empty($rowContact['introtext'])) {
                $contactBlurb = $rowContact['introtext'];
            }

            if (!empty($rowContact['mapcode'])) {
                $contactMap = $rowContact['mapcode'];
            }

            if (!empty($rowContact['address'])) {
                $contactAddress = $rowContact['address'];
            }

            if (!empty($rowContact['city'])) {
                $contactCity = $rowContact['city'];
            }

            if (!empty($rowContact['state'])) {
                $contactState = $rowContact['state'];
            }

            if (!empty($rowContact['zipcode'])) {
                $contactZipcode = $rowContact['zipcode'];
            }

            if (!empty($rowContact['phone'])) {
                $contactPhone = $rowContact['phone'];
            }

            if (!empty($rowContact['email'])) {
                $contactEmail = $rowContact['email'];
            }

            if (!empty($rowContact['hours'])) {
                $contactHours = $rowContact['hours'];
            }

            if (!empty($rowContact['sendtoemail'])) {
                $contactFormSendToEmail = $rowContact['sendtoemail'];
            }

        } else {

            $contactActive = false;

        }
    }
}

function getServices($loc)
{
    global $sqlServicesHeading;
    global $rowServicesHeading;
    global $servicesHeading;
    global $sqlServices;
    global $servicesNumRows;
    global $servicesBlurb;
    global $servicesCount;
    global $servicesIcon;
    global $db_conn;

    if (isset($loc) && !empty($loc)) {

        $sqlServicesSetup = mysqli_query($db_conn, "SELECT services_use_defaults FROM setup WHERE loc_id=" . $loc . ";");
        $rowServicesSetup = mysqli_fetch_array($sqlServicesSetup, MYSQLI_ASSOC);

        //toggle default location value
        if ($rowServicesSetup['services_use_defaults'] == 'true' || $rowServicesSetup['services_use_defaults'] == "" || $rowServicesSetup['services_use_defaults'] == null) {
            $servicesDefaultLoc = 1;
        } else {
            $servicesDefaultLoc = $loc;
        }

        $sqlServicesHeading = mysqli_query($db_conn, "SELECT servicesheading, servicescontent FROM setup WHERE loc_id=" . $servicesDefaultLoc . ";");
        $rowServicesHeading = mysqli_fetch_array($sqlServicesHeading, MYSQLI_ASSOC);

        $servicesHeading = $rowServicesHeading['servicesheading'];

        if (!empty($rowServicesHeading['servicescontent'])) {
            $servicesBlurb = $rowServicesHeading['servicescontent'];
        }

        $sqlServices = mysqli_query($db_conn, "SELECT id, icon, image, title, link, content, sort, active FROM services WHERE active='true' AND loc_id=" . $servicesDefaultLoc . " ORDER BY sort, title ASC;"); //While loop
        $servicesNumRows = mysqli_num_rows($sqlServices);
        $servicesCount = 0;
    }
}

function getTeam($loc)
{
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

    if (isset($loc) && !empty($loc)) {

        $sqlTeamSetup = mysqli_query($db_conn, "SELECT team_use_defaults FROM setup WHERE loc_id=" . $loc . ";");
        $rowTeamSetup = mysqli_fetch_array($sqlTeamSetup, MYSQLI_ASSOC);

        //toggle default location value
        if ($rowTeamSetup['team_use_defaults'] == 'true' || $rowTeamSetup['team_use_defaults'] == "" || $rowTeamSetup['team_use_defaults'] == null) {
            $teamDefaultLoc = 1;
        } else {
            $teamDefaultLoc = $loc;
        }

        $sqlTeamHeading = mysqli_query($db_conn, "SELECT teamheading, teamcontent FROM setup WHERE loc_id=" . $teamDefaultLoc . ";");
        $rowTeamHeading = mysqli_fetch_array($sqlTeamHeading, MYSQLI_ASSOC);

        $teamHeading = $rowTeamHeading['teamheading'];

        if (!empty($rowTeamHeading['teamcontent'])) {
            $teamBlurb = $rowTeamHeading['teamcontent'];
        }

        $sqlTeam = mysqli_query($db_conn, "SELECT id, image, title, name, content, sort, active FROM team WHERE active='true' AND loc_id=" . $teamDefaultLoc . " ORDER BY sort, title ASC;"); //While loop
        $teamNumRows = mysqli_num_rows($sqlTeam);
    }
}

function getNav($loc, $navSection, $dropdown, $pull)
{
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

    if ($dropdown == "true") {
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

    if (isset($loc) && !empty($loc)) {

        //check if using default location
        $sqlNavDefaults = mysqli_query($db_conn, "SELECT navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3 FROM setup WHERE loc_id=" . $loc . ";");
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

        $sqlNavLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category_navigation ON navigation.catid=category_navigation.id WHERE section='" . $navSection . "' AND active='true' AND loc_id=" . $navDefaultLoc . " ORDER BY navigation.sort, navigation.name ASC;");
        //returns: navigation.id, navigation.sort, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.active, navigation.win, navigation.loc_id, navigation.datetime, category_navigation.id, category_navigation.cat_name, category_navigation.loc_id, category_navigation.nav_loc_id
        $tempLink = 0;

        while ($rowNavLinks = mysqli_fetch_array($sqlNavLinks)) {

            //Variables for $sqlNavLinks SQL Join
            $navLinksID = $rowNavLinks[0];
            $navLinksSort = $rowNavLinks[1];
            $navLinksName = $rowNavLinks[2];
            $navLinksUrl = $rowNavLinks[3];
            $navLinksGuid = $rowNavLinks[4];
            $navLinksCatId = $rowNavLinks[5];
            $navLinksSection = $rowNavLinks[6];
            $navLinksActive = $rowNavLinks[7];
            $navLinksWin = $rowNavLinks[8];
            $navLinksLocId = $rowNavLinks[9];
            $navLinksDateTime = $rowNavLinks[10];
            $navLinks_Author = $rowNavLinks[11];
            $navLinks_CatId = $rowNavLinks[12];
            $navLinks_CatName = $rowNavLinks[13];
            $navLinks_CatNavLocId = $rowNavLinks[14];

            //Check if link contains shortcode
            $navLinksUrl = getShortCode($navLinksUrl);

            //New Window
            if ($navLinksWin == 'true' || $navLinksWin == 'on') {
                $navWin = "target='_blank'";
            } else {
                $navWin = "";
            }

            //Create category - drop down menus
            if ($navLinksCatId == $navLinks_CatId && $navLinksCatId != 0) { //NOTE: 0=None in the category table

                if ($navLinksCatId != $tempLink) {

                    $sqlNavCatLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category_navigation ON navigation.catid=category_navigation.id WHERE section='" . $navSection . "' AND category_navigation.id=" . $navLinksCatId . " AND active='true' AND loc_id=" . $navDefaultLoc . " ORDER BY navigation.sort, navigation.name ASC;");
                    //returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.active, navigation.win, navigation.loc_id, navigation.datetime, category_navigation.id, category_navigation.cat_name, category_navigation.nav_loc_id

                    echo "<li class='$dropdown'>";
                    echo "<a href='#' class='cat-$navSection' data-toggle='$dataToggle'>" . $navLinks_CatName . " $dropdownCaret</a>";
                    echo "<ul class='$dropdownMenu'>";
                    while ($rowNavCatLinks = mysqli_fetch_array($sqlNavCatLinks)) {

                        //Variables for $rowNavCatLinks SQL Join
                        $navCatLinksID = $rowNavCatLinks[0];
                        $navCatLinksSort = $rowNavCatLinks[1];
                        $navCatLinksName = $rowNavCatLinks[2];
                        $navCatLinksUrl = $rowNavCatLinks[3];
                        $navCatLinksGuid = $rowNavCatLinks[4];
                        $navCatLinksCatID = $rowNavCatLinks[5];
                        $navCatLinksCatSection = $rowNavCatLinks[6];
                        $navCatLinksActive = $rowNavCatLinks[7];
                        $navCatLinksWin = $rowNavCatLinks[8];

                        //Check if cat link contains shortcode
                        $navCatLinksUrl = getShortCode($navCatLinksUrl);

                        //New Window
                        if ($navCatLinksWin == 'true' || $navCatLinksWin == 'on') {
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
}

function getSetup($loc)
{
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

    if (isset($loc) && !empty($loc)) {

        $sqlSetup = mysqli_query($db_conn, "SELECT title, author, keywords, description, config, logo, logo_use_defaults, ls2pac, ls2kids, searchdefault, loc_id FROM setup WHERE loc_id=1;");
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
}

function getLogo($loc, $type)
{
    global $db_conn;
    global $getLogo;

    if (isset($loc) && !empty($loc)) {
        $sqlGetLogoDefault = mysqli_query($db_conn, "SELECT logo, loc_id FROM setup WHERE loc_id=1;");
        $rowGetLogoDefault = mysqli_fetch_array($sqlGetLogoDefault, MYSQLI_ASSOC);
        $defaultLogo = $rowGetLogoDefault['logo'];

        $sqlGetLogoOptions = mysqli_query($db_conn, "SELECT logo, logo_use_defaults, loc_id FROM setup WHERE loc_id=" . $loc . ";");
        $rowGetLogoOptions = mysqli_fetch_array($sqlGetLogoOptions, MYSQLI_ASSOC);

        if ($rowGetLogoOptions['logo_use_defaults'] == 'true') {
            $getLogo = $defaultLogo;
        } else {
            $getLogo = $rowGetLogoOptions['logo'];
        }

        if ($type == 'absolute') {
            echo str_replace('..', serverUrlStr, $getLogo);
        } elseif ($type == 'relative') {
            echo $getLogo;
        } else {
            echo $getLogo;
        }
    }
}

function getCoreHeader($loc, $addHeader = null)
{
    getLocation($loc);
    getSetup($loc);

    global $setupConfig;
    global $setupTitle;
    global $setupAuthor;
    global $setupDescription;
    global $pageTitle;
    global $contactHeading;
    global $servicesHeading;
    global $teamHeading;
    global $customerHeading;

    //Call these functions depending on which page you are visiting
    //Sets the page title and calls the main function for each page.
    switch (basename($_SERVER['PHP_SELF'])) {
        case "page.php":
            getPage(loc_id);
            $theTitle = $setupTitle . " - " . $pageTitle;
            break;
        case "contact.php":
            getContactInfo(loc_id);
            $theTitle = $setupTitle . " - " . $contactHeading;
            break;
        case "services.php":
            getServices(loc_id);
            $theTitle = $setupTitle . " - " . $servicesHeading;
            break;
        case "staff.php":
            getTeam(loc_id);
            $theTitle = $setupTitle . " - " . $teamHeading;
            break;
        case "databases.php":
            getCustomers(loc_id, null);
            $theTitle = $setupTitle . " - " . $customerHeading;
            break;
        default:
            $theTitle = $setupTitle;
    }

    if (isset($_GET['page_id'])) {
        $pageId = $_GET['page_id'];
    } else {
        $pageId = null;
    }
    ?>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
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
    <meta name="keywords" content="<?php getKeywords($loc, $pageId); ?>">
    <meta name="author" content="<?php echo $setupAuthor; ?>">

    <title><?php echo $theTitle; ?></title>

    <link rel="shortcut icon" type="image/x-icon"
          href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/images/favicon.ico">

    <!-- Core CSS Libraries -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/assets/css/main.min.css?v=<?php echo ysmVersion; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/assets/css/jquery-ui-1.10.4.custom.min.css?v=<?php echo ysmVersion; ?>"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/assets/css/font-awesome.min.css?v=<?php echo ysmVersion; ?>">

    <!-- Default CSS - Do not remove-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/assets/css/core-style.min.css?v=<?php echo ysmVersion; ?>">

    <!--Dynamic CSS -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/assets/css/dynamic-style.php?loc_id=<?php echo $loc; ?>">

    <!-- Core JS Libraries -->
    <script type="text/javascript" language="javascript"
            src="<?php echo serverUrlStr; ?>/themes/assets/js/main.min.js?v=<?php echo ysmVersion; ?>"></script>
    <script type="text/javascript" language="javascript"
            src="<?php echo serverUrlStr; ?>/themes/assets/js/jquery-ui-1.10.4.custom.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- LS2 search script -->
    <script type="text/javascript" language="javascript"
            src="<?php echo serverUrlStr; ?>/themes/assets/js/searchscript.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- Core js file-->
    <script type="text/javascript" language="javascript"
            src="<?php echo serverUrlStr; ?>/themes/assets/js/functions.min.js?v=<?php echo ysmVersion; ?>"></script>

    <?php if (!empty(setupPACURL)) { ?>
    <!-- getSearchString (version #, this, domain, config, branch, searchBoxType [ls2, kids5, kids, classic]?, new window?)-->
    <script type="text/javascript" language="javascript">
        var TLCDomain = "<?php echo setupPACURL; ?>";
        var TLCConfig = "<?php echo $setupConfig; ?>";
        var TLCBranch = "";
        var TLCClassicDomain = "<?php echo setupPACURL; ?>";
        var TLCClassicConfig = "<?php echo $setupConfig; ?>";
    </script>
<?php } ?>

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
function getDynamicCss($loc)
{
    global $db_conn;

    header('Content-type: text/css; charset: UTF-8');
    header('Cache-control: must-revalidate');

    //Get setup table columns
    $sqlSetup = mysqli_query($db_conn, "SELECT theme_use_defaults, loc_id FROM setup WHERE loc_id=" . loc_id . ";");
    $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

    if ($rowSetup['theme_use_defaults'] == 'true') {
        $locId = 1;
    } else {
        $locId = $loc;
    }

    //Gets themeoptions
    $sqlGetThemeOpions = mysqli_query($db_conn, "SELECT id, themename, selector, property, cssvalue, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND loc_id=" . $locId . ";");
    while ($rowGetThemeOpions = mysqli_fetch_array($sqlGetThemeOpions, MYSQLI_ASSOC)) {
        //Color Picker defaults to #000000 if the value is empty. To check if the value is empty, you have to check if value = #000000
        if (trim($rowGetThemeOpions['cssvalue']) != '#000000') {
            echo $rowGetThemeOpions['selector'] . " {" . trim($rowGetThemeOpions['property']) . ": " . trim($rowGetThemeOpions['cssvalue']) . " !important;}" . PHP_EOL;
        }
    }
}

//Gets the image path and converts it to absolute image path.
function getAbsoluteImagePath($imagePath)
{
    if (strpos($imagePath, '../uploads/') !== false) {
        $absolutePath = serverUrlStr . str_replace('../', '/', $imagePath);
    } else {
        $absolutePath = $imagePath;
    }

    return $absolutePath;
}

function array_in_string($str, array $arr)
{

    foreach ($arr as $arr_value) {

        if (strpos($str, $arr_value) !== false) {

            return true;

        }

    }

    return false;
}

function getSocialMediaIcons($loc, $shape = null, $section = null, $size = null)
{
    //EXAMPLE: getSocialMediaIcons($_GET['loc_id'], "circle","top")
    //EXAMPLE: getSocialMediaIcons($_GET['loc_id'], "square","footer")
    global $socialMediaIcons;
    global $socialMediaArray;
    global $socialMediaHeading;
    global $socialMediaActive;
    global $db_conn;

    if (!$size) {
        $size = 2;
    }

    $socialMediaArray = array();
    $iconsArray = array();
    $socialMediaHeading = "";
    $socialMediaIcons = "";

    if (isset($loc) && !empty($loc)) {

        $sqlSetup = mysqli_query($db_conn, "SELECT socialmedia_use_defaults, socialmediaheading FROM setup WHERE loc_id=" . $loc . ";");
        $rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);

        //use default location
        if ($rowSetup['socialmedia_use_defaults'] == "true" || $rowSetup['socialmedia_use_defaults'] == "" || $rowSetup['socialmedia_use_defaults'] == null) {
            $sqlSocialMediaArray = mysqli_query($db_conn, "SELECT id, sort, name, url FROM sociallinks WHERE active='true' AND loc_id=1 ORDER BY sort, name;");
        } else {
            $sqlSocialMediaArray = mysqli_query($db_conn, "SELECT id, sort, name, url FROM sociallinks WHERE active='true' AND loc_id=" . $loc . " ORDER BY sort, name;");
        }

        $socialMediaArray = mysqli_fetch_all($sqlSocialMediaArray, MYSQLI_ASSOC);

        //Array of font-awesome icons
        $sqlIcons = mysqli_query($db_conn, "SELECT icon FROM icons_list;");
        $icons = mysqli_fetch_all($sqlIcons, MYSQLI_ASSOC);

        //create array of icon values
        foreach ($icons as $iconKey => $iconValue) {
            $iconsArray[] = $iconValue['icon'];
        }

        if (!empty($socialMediaArray)) {

            $socialMediaActive = true;

            if (!empty($rowSetup['socialmediaheading'])) {
                $socialMediaHeading = $rowSetup['socialmediaheading'];
            }

            foreach ($socialMediaArray as $socialMediaIcon) {
                if (in_array(trim($socialMediaIcon['name']), $iconsArray)) {
                    $socialMediaIcons .= "<a href=" . trim(strtolower($socialMediaIcon['url'])) . " target='_blank'><span class='fa-stack fa-" . $size . "x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-" . trim(strtolower($socialMediaIcon['name'])) . " fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
                } else {
                    //if no font-awesome icon is found
                    $socialMediaIcons .= "<a href=" . trim(strtolower($socialMediaIcon['url'])) . " target='_blank'><span class='fa-stack fa-" . $size . "x social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-link fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
                }
            }

        } else {

            $socialMediaActive = false;

        }
    }
}

function getCustomers($loc, $custType)
{
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

    if (isset($loc) && !empty($loc)) {
        if (!empty($_GET['section'])) {
            $customerSection = $_GET['section'];
        } else {
            $customerSection = '1';
        }

        //get the default values from setup table where get loc_id
        $sqlCustomerSetup = mysqli_query($db_conn, "SELECT use_defaults, section FROM sections_customers WHERE section='" . $customerSection . "' AND loc_id=" . $loc . ";");
        $rowCustomerSetup = mysqli_fetch_array($sqlCustomerSetup, MYSQLI_ASSOC);

        //toggle default location value if conditions are true
        if ($customerSection == $rowCustomerSetup['section'] && $rowCustomerSetup['use_defaults'] == 'true') {
            $custDefaultLoc = 1;
        } else {
            $custDefaultLoc = $loc;
        }

        //sets to use defaults if conditions are true where loc_id = $custDefaultLoc
        $sqlCustomerSetup = mysqli_query($db_conn, "SELECT use_defaults, section, heading, content FROM sections_customers WHERE section='" . $customerSection . "' AND loc_id=" . $custDefaultLoc . ";");
        $rowCustomerSetup = mysqli_fetch_array($sqlCustomerSetup, MYSQLI_ASSOC);

        //toggle default location value if conditions are true
        if ($customerSection == $rowCustomerSetup['section'] && $rowCustomerSetup['use_defaults'] == 'true') {
            $customerHeading = $rowCustomerSetup['heading'];
            $customerBlurb = $rowCustomerSetup['content'];
        }

        //Get Category
        //If cat_id=int then display a page of databases for only that category
        if (!empty($_GET['cat_id'])) {
            $sqlCatCustomers = mysqli_query($db_conn, "SELECT id, name, sort FROM category_customers WHERE id IN (SELECT catid, section FROM customers WHERE section='" . $customerSection . "' AND catid = " . $_GET['cat_id'] . " AND loc_id=" . $custDefaultLoc . ");");
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

        $sqlCustomers = mysqli_query($db_conn, "SELECT id, image, icon, name, section, link, catid, content, featured, sort, datetime, active, loc_id FROM customers WHERE active='true' AND " . $customerSectionWhere . " " . $customerCatWhere . " loc_id=" . $custDefaultLoc . " ORDER BY catid, sort, NAME ASC;"); //While loop
        $customerNumRows = mysqli_num_rows($sqlCustomers);
    }

}

function getSlider($loc, $sliderType, $array_only = null)
{
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
    global $sliderArray;
    global $db_conn;

    $sliderOrderBy = '';
    $sliderArray = array();

    if ($sliderType == "slide") {
        $sliderOrderBy = "ORDER BY sort, title ASC";
    } elseif ($sliderType == "random" || $sliderType == "") {
        $sliderOrderBy = "ORDER BY RAND() LIMIT 1";
    }

    $sliderCount = 0;
    $imagePath = $loc;

    if (isset($loc) && !empty($loc)) {
        //get location type from locations table
        $sqlLocations = mysqli_query($db_conn, "SELECT id, name, type FROM locations WHERE id=" . $loc . ";");
        $rowLocations = mysqli_fetch_array($sqlLocations, MYSQLI_ASSOC);

        $sliderLocType = $rowLocations['type'];

        if ($sliderLocType == '' || $sliderLocType == null || $sliderLocType == $locTypes[0]) {
            $locTypeWhere = "loc_type IN ('" . $locTypes[0] . "', 'All') AND ";
        } else {
            $locTypeWhere = "loc_type IN ('" . $sliderLocType . "', 'All') AND ";
        }

        //get the default value from setup table
        $sqlSliderSetup = mysqli_query($db_conn, "SELECT slider_use_defaults FROM setup WHERE loc_id=" . $loc . ";");
        $rowSliderSetup = mysqli_fetch_array($sqlSliderSetup, MYSQLI_ASSOC);

        $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, loc_type, sort, startdate, enddate, active, loc_id FROM slider WHERE active='true' AND " . $locTypeWhere . " loc_id=" . $loc . " " . $sliderOrderBy . ";");
        $sliderNumRows = mysqli_num_rows($sqlSlider);

        //use default location
        if ($rowSliderSetup['slider_use_defaults'] == "true" || $rowSliderSetup['slider_use_defaults'] == "" || $rowSliderSetup['slider_use_defaults'] == null) {
            $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, loc_type, sort, startdate, enddate, active, loc_id FROM slider WHERE active='true' AND " . $locTypeWhere . " loc_id=1 " . $sliderOrderBy . ";");
            $sliderNumRows = mysqli_num_rows($sqlSlider);

            $imagePath = 1; //the default location
        }

        //hide carousel arrows if only one image is available
        if ($sliderNumRows == 1) {
            echo "<style>#sliderCarousel .carousel-control {display: none !important;}</style>";
        }

        //build html for slider
        if ($sliderNumRows > 0 && $array_only == null) {

            if ($sliderType == "slide") {

                //Wrapper for slides
                echo "<div class='carousel-inner'>";
                while ($rowSlider = mysqli_fetch_array($sqlSlider, MYSQLI_ASSOC)) {

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

            } elseif ($sliderType == "random") {
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

        } else {
            return $sliderArray = mysqli_fetch_all($sqlSlider, MYSQLI_ASSOC);
        }
    }
}

function getGeneralInfo($loc)
{
    global $generalInfoContent;
    global $generalInfoHeading;
    global $generalInfoActive;
    global $db_conn;

    if (isset($loc) && !empty($loc)) {
        $sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, active, use_defaults FROM generalinfo WHERE active='true' AND loc_id=" . $loc . ";");
        $rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo, MYSQLI_ASSOC);

        if ($rowGeneralinfo) {
            $generalInfoActive = true;

            //use default location
            if ($rowGeneralinfo['use_defaults'] == "true" || $rowGeneralinfo['use_defaults'] == "" || $rowGeneralinfo['use_defaults'] == null) {
                $sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, use_defaults FROM generalinfo WHERE active='true' AND loc_id=1;");
                $rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo, MYSQLI_ASSOC);
            }

            if (!empty($rowGeneralinfo['content'])) {
                $generalInfoContent = $rowGeneralinfo['content'];
            }

            if (!empty($rowGeneralinfo['heading'])) {
                $generalInfoHeading = $rowGeneralinfo['heading'];
            }

        } else {
            $generalInfoActive = false;
        }
    }

}

function getFeatured($loc)
{
    global $featuredContent;
    global $featuredHeading;
    global $featuredBlurb;
    global $featuredActive;
    global $imagePath;
    global $db_conn;

    if (isset($loc) && !empty($loc)) {
        $sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, active, use_defaults FROM featured WHERE active='true' AND loc_id=" . $loc . ";");
        $rowFeatured = mysqli_fetch_array($sqlFeatured, MYSQLI_ASSOC);
        $imagePath = $loc;

        if ($rowFeatured) {
            $featuredActive = true;

            if ($rowFeatured['use_defaults'] == "true" || $rowFeatured['use_defaults'] == "" || $rowFeatured['use_defaults'] == null) {
                $sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, active FROM featured WHERE active='true' AND loc_id=1;");
                $rowFeatured = mysqli_fetch_array($sqlFeatured, MYSQLI_ASSOC);

                $imagePath = 1;
            }

            if (!empty($rowFeatured['heading'])) {
                $featuredHeading = $rowFeatured['heading'];
            }

            if (!empty($rowFeatured['introtext'])) {
                $featuredBlurb = $rowFeatured['introtext'];
            }

            if (!empty($rowFeatured['content'])) {
                $featuredContent = $rowFeatured['content'];
            }

        } else {

            $featuredActive = false;

        }

    }

}

function getEvents($loc)
{
    global $eventAlert;
    global $eventHeading;
    global $eventStartdate;
    global $eventEnddate;
    global $eventCalendar;
    global $eventAlertDateCheck;
    global $eventActive;
    global $db_conn;

    if (isset($loc) && !empty($loc)) {
        $sqlEvent = mysqli_query($db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, active, author_name, datetime, loc_id FROM events WHERE active='true' AND loc_id=" . $loc . ";");
        $rowEvent = mysqli_fetch_array($sqlEvent, MYSQLI_ASSOC);

        if ($rowEvent) {

            $eventActive = true;

            if ($rowEvent['use_defaults'] == "true" || $rowEvent['use_defaults'] == "" || $rowEvent['use_defaults'] == null) {
                $sqlEvent = mysqli_query($db_conn, "SELECT heading, alert, startdate, enddate, calendar, use_defaults, active, author_name, datetime, loc_id FROM events WHERE active='true' AND loc_id=1;");
                $rowEvent = mysqli_fetch_array($sqlEvent, MYSQLI_ASSOC);
            }

            if (!empty($rowEvent['heading'])) {
                $eventHeading = $rowEvent['heading'];
            }

            if (!empty($rowEvent['alert'])) {
                $eventAlert = $rowEvent['alert'];
                $eventStartdate = $rowEvent['startdate'];
                $eventEnddate = $rowEvent['enddate'];

                if (strtotime(date('Y-m-d')) >= strtotime($eventStartdate) && strtotime(date('Y-m-d')) <= strtotime($eventEnddate)) {
                    $eventAlertDateCheck = 'true';
                } else {
                    $eventAlertDateCheck = 'false';
                }
            }

            if (!empty($rowEvent['calendar'])) {
                $eventCalendar = $rowEvent['calendar'];
            }

        } else {

            $eventActive = false;

        }
    }
}

function getHottitlesCarousel($xmlurl, $jacketSize, $dummyJackets, $maxcnt)
{
    //getHottitlesCarousel("http://mylibrary.com:8080/list/dynamic/1921419/rss", 'MD', 'true', 30);

    $jacketSize = strtoupper($jacketSize);

    $checkUrl = 'https://ls2content.tlcdelivers.com/tlccontent?customerid=' . customerNumber . '&appid=ls2pac&requesttype=BOOKJACKET-SM&isbn=123456789';

    //Check if customerid is set up on the content server
    if (!empty(customerNumber)) {

        $ch = curl_init($checkUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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

        die('URL not found or parameters are not correct. Customer number not set in Admin -> Site Options.');
    }

    if (isset($xmlurl)) {
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
            $xmlimage = "https://ls2content.tlcdelivers.com/tlccontent?customerid=" . customerNumber . "&appid=ls2pac&requesttype=BOOKJACKET-" . $jacketSize . "&isbn=" . $xmlisbn . "";

            //http://173.163.174.146:8080/?config=ysm#section=search&term=The Black Book
            $xmllink = setupPACURL . "/?config=ysm#section=search&term=" . $xmltitle;

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
                    echo "<a href='" . htmlspecialchars($xmllink, ENT_QUOTES) . "' title='" . htmlspecialchars($xmltitle, ENT_QUOTES) . "' target='_blank' data-resource-isbn='" . $xmlisbn . "' data-item-count='" . $itemcount . "'><span class='dummy-title'>" . htmlspecialchars($xmltitle, ENT_QUOTES) . "</span><img class='dummy-jacket $jacketSize img-responsive center-block' src='../themes/assets/images/gray-bookjacket-" . strtolower($jacketSize) . ".png'></a>";
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
                    echo "<a href='" . htmlspecialchars($xmllink, ENT_QUOTES) . "' title='" . htmlspecialchars($xmltitle, ENT_QUOTES) . "' target='_blank' data-resource-id='" . $xmlResourceId . "' data-item-count='" . $itemcount . "'><span class='dummy-title'>" . htmlspecialchars($xmltitle, ENT_QUOTES) . "</span><img class='dummy-jacket $jacketSize img-responsive center-block' src='../themes/assets/images/gray-bookjacket-" . strtolower($jacketSize) . ".png'></a>";
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

function getHottitlesTabs($loc)
{
    global $hottitlesTile;
    global $hottitlesUrl;
    global $hottitlesLoadFirstUrl;
    global $hottitlesLocID;
    global $hottitlesTabs;
    global $hottitlesCount;
    global $hottitlesHeading;
    global $locTypes;
    global $db_conn;

    if (isset($loc) && !empty($loc)) {
        //get the heading value from setup table
        $sqlHottitlesSetup = mysqli_query($db_conn, "SELECT hottitlesheading, loc_id FROM setup WHERE loc_id=" . $loc . ";");
        $rowHottitlesSetup = mysqli_fetch_array($sqlHottitlesSetup, MYSQLI_ASSOC);
        $hottitlesHeading = $rowHottitlesSetup['hottitlesheading'];

        //get location type from locations table
        $sqlLocations = mysqli_query($db_conn, "SELECT id, name, type FROM locations WHERE id=" . $loc . ";");
        $rowLocations = mysqli_fetch_array($sqlLocations, MYSQLI_ASSOC);

        if ($rowLocations['type'] == '' || $rowLocations['type'] == null || $rowLocations['type'] == $locTypes[0]) {
            $hottitlesLocType = $rowLocations['type'];
            $locTypeWhere = "loc_type IN ('" . $locTypes[0] . "', 'All') AND";
        } else {
            $hottitlesLocType = $rowLocations['type'];
            $locTypeWhere = "loc_type IN ('" . $hottitlesLocType . "', 'All') AND";
        }

        //get the default value from setup table
        $sqlHottitlesSetup = mysqli_query($db_conn, "SELECT hottitlesheading, hottitles_use_defaults, loc_id FROM setup WHERE loc_id=" . $loc . ";");
        $rowHottitlesSetup = mysqli_fetch_array($sqlHottitlesSetup, MYSQLI_ASSOC);

        $sqlHottitles = mysqli_query($db_conn, "SELECT id, title, url, loc_type, sort, active, loc_id FROM hottitles WHERE active='true' AND $locTypeWhere loc_id=" . $loc . " ORDER BY sort ASC;");
        $hottitlesLocID = $loc;

        //use default location
        if ($rowHottitlesSetup['hottitles_use_defaults'] == "true" || $rowHottitlesSetup['hottitles_use_defaults'] == "" || $rowHottitlesSetup['hottitles_use_defaults'] == null) {
            $sqlHottitles = mysqli_query($db_conn, "SELECT id, title, url, loc_type, sort, active, loc_id FROM hottitles WHERE active='true' AND $locTypeWhere loc_id=1 ORDER BY sort ASC;");
            $hottitlesLocID = 1;
        }

        $hottitlesCount = 0;

        while ($rowHottitles = mysqli_fetch_array($sqlHottitles, MYSQLI_ASSOC)) {

            $hottitlesSort = trim($rowHottitles['sort']);
            $hottitlesTile = trim($rowHottitles['title']);
            $hottitlesUrl = trim($rowHottitles['url']);
            $hottitlesLocType = trim($rowHottitles['loc_type']);
            $hottitlesCount++;

            //Set active tab on initial page load where count=1
            if ($hottitlesCount == 1) {
                $hotActive = 'active';
                $hottitlesLoadFirstUrl = $hottitlesUrl;
            } else {
                $hotActive = '';
            }

            if ($hottitlesCount > 0 && $hottitlesUrl) {
                $hottitlesTabs .= "<li class='hot-tab $hotActive'><a data-toggle='tab' onclick=\"toggleSrc('$hottitlesUrl', '$hottitlesLocID', '$hottitlesCount');\">$hottitlesTile</a></li>";
            }
        }
    }
}

function getSiteSearchResults($searchTerm, $showPageContent)
{
    //getSiteSearchResults('how do i check out a book', true = shows page contents in search results)
    global $db_conn;
    global $siteSearchId;
    global $siteSearchLodId;
    global $siteSearchTitle;
    global $siteSearchContent;
    global $siteSearchCount;

    $siteSearchTerm = "%" . mysqli_real_escape_string($db_conn, strip_tags(trim($searchTerm))) . "%";
    $siteSearchCount = 0;

    $sqlSiteSearch = mysqli_query($db_conn, "SELECT id, title, content, keywords, active, loc_id FROM pages WHERE title LIKE '$siteSearchTerm' OR content LIKE '$siteSearchTerm' OR keywords LIKE '$siteSearchTerm' ORDER BY title ASC;");

    while ($rowSiteSearch = mysqli_fetch_array($sqlSiteSearch, MYSQLI_ASSOC)) {
        $siteSearchCount++;
        $siteSearchId = $rowSiteSearch['id'];
        $siteSearchLodId = $rowSiteSearch['loc_id'];
        $siteSearchTitle = $rowSiteSearch['title'];
        $siteSearchContent = $rowSiteSearch['content'];
        $siteSearchKeywords = $rowSiteSearch['keywords'];
        $siteSearchActive = $rowSiteSearch['active'];

        if ($siteSearchActive == 'true') {
            echo "<hr/><h3 class='post-title'><a href='page.php?loc_id=$siteSearchLodId&page_id=$siteSearchId' target='_self'>" . $siteSearchTitle . "</a></h3>" . PHP_EOL;

            if ($showPageContent == 'true') {
                echo "<p class='post-content'>" . $siteSearchContent . "</p><br/>" . PHP_EOL;
            }
        }
    }
}

function getUrlContents($getUrl)
{
    $ch = curl_init();
    $timeout = 10;
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo "HTTP status " . $http_status . ". Error loading URL. " . curl_error($ch);
        curl_close($ch);
        die();
    }
    curl_close($ch);

    return $data;
}

//Call - getSetup is used everywhere
getSetup(loc_id);

//Random string generator - used to create a unique md5 referrer
function generateRandomString($length = 10)
{
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
function getShortCode($urlStr)
{
    global $setupConfig;

    //add a space to the front of var so that str_replace will see it. strange, right?
    $urlStr = ' ' . $urlStr;

    $urlStr = str_replace('[pac_url]', setupPACURL, $urlStr);

    $urlStr = str_replace('[homepage_url]', homePageURL, $urlStr);

    $urlStr = str_replace('[config]', $setupConfig, $urlStr);

    $urlStr = str_replace('[loc_id]', loc_id, $urlStr);

    return trim($urlStr);
}

//Google Analytic Tracker Code
function getGoogleAnalyticsTrackingCode($uidcode)
{
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
function getGoogleTranslateCode($languages)
{
    if (!empty($languages)) {
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
        return true;
    } else {
        return false;
    }
}

//Disqus service
function getDisqusCode($page_url, $unique_identifier)
{

    if (!empty(disqus_url)) {
        ?>
        <!-- Disqus service -->
        <div id="disqus_thread"></div>
        <script type="text/javascript" language="javascript">
            var disqus_config = function () {
                this.page.url = '<?php echo $page_url; ?>';
                this.page.identifier = '<?php echo $unique_identifier; ?>';
            };
            (function () {
                var d = document, s = d.createElement('script');
                s.src = '<?php echo disqus_url; ?>/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <?php
    }
}

//Keywords
function getKeywords($loc, $pageId = null)
{
    getSetup($loc);
    getPage($loc);

    global $keywords;
    global $setupKeywords;
    global $pageKeywords;

    if ($pageId && $pageKeywords != '') {
        $keywords = $pageKeywords;
    } else {
        $keywords = $setupKeywords;
    }

    echo $keywords;
}

//Renders binary images from database or other source.
function renderBinaryImage($mimeType, $fileData)
{
    $imageSource = "data:image/" . $mimeType . ";base64," . base64_encode($fileData) . "";

    return $imageSource;
}

//$type = success, warning, info, danger
function flashMessageSet($type, $message)
{
    if (!isset($_SESSION['message'][$type])) {
        $_SESSION['message'][$type] = "<div class='alert alert-" . $type . "'>" . $message . "</div>";
    }

    return $_SESSION['message'][$type];
}

//$type = success, warning, info, danger
function flashMessageGet($type)
{
    $message = isset($_SESSION['message'][$type]) ? $_SESSION['message'][$type] : null;

    if (!is_null($message)) {
        unset($_SESSION['message'][$type]);
    }

    return $message;
}

//redirect to default location if loc_id or script name not defined
if (empty(loc_id)) {

    if (basename($_SERVER['PHP_SELF']) == "") {
        $pageRedirect = 'index.php?loc_id=1';
    } else {
        $pageRedirect = basename($_SERVER['PHP_SELF']) . '?loc_id=1';
    }

    header("Location: $pageRedirect", true, 302);
    echo "<script>window.location.href='" . $pageRedirect . "';</script>";

} elseif (multiBranch == "false" && loc_id != 1) {
    header("Location: index.php?loc_id=1", true, 302);
    echo "<script>window.location.href='index.php?loc_id=1';</script>";
}

//location search box redirect to loc_id where loc_name = querystring
if (!empty($_GET['loc_name'])) {

    $sqlLocName = mysqli_query($db_conn, "SELECT name, id, active FROM locations WHERE active='true' AND name='" . $_GET['loc_name'] . "' LIMIT 1;");
    $rowLocName = mysqli_fetch_array($sqlLocName, MYSQLI_ASSOC);

    header("Location: " . basename($_SERVER['PHP_SELF']) . "?loc_id=" . $rowLocName['id'] . "", true, 302);
    echo "<script>window.location.href='" . basename($_SERVER['PHP_SELF']) . '?loc_id=' . $rowLocName['id'] . "';</script>";
}
?>