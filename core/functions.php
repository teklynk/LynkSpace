<?php

if (!defined('inc_access')){
    die('Direct access not permitted');
}

function getLocation(){
    global $locationName;
    global $locationActive;
    global $locationID;
    global $db_conn;

    if (ctype_digit($_GET['loc_id'])){

        $sqlGetLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' AND id=" . $_GET['loc_id'] . " ");
        $rowGetLocation = mysqli_fetch_array($sqlGetLocation);

        if ($rowGetLocation['active'] == 'true' && $_GET['loc_id'] == $rowGetLocation['id']){
            $locationName = $rowGetLocation['name'];
            $locationActive = $rowGetLocation['active'];
            $locationID = $rowGetLocation['id'];
        } else {
            header("Location: index.php?loc_id=1");
            echo "<script>window.location.href='index.php?loc_id=1';</script>";
        }

    }
}

function getLocList(){
    global $locationListJson;
    global $locationIDListJson;
    global $db_conn;

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true'");
    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch)){
        $locationListJson .= "'" . $rowLocationSearch['name'] . "',";
        $locationIDListJson .= "'" . $rowLocationSearch['id'] . "',";
    }
}

function getPage(){
    global $pageImage;
    global $pageTitle;
    global $pageContent;
    global $pageImageAlign;
    global $pageRefId;
    global $db_conn;

    if (ctype_digit($_GET['page_id'])){
        $pageRefId = $_GET['page_id'];
        $sqlPage = mysqli_query($db_conn, "SELECT id, title, image, image_align, content, active, loc_id FROM pages WHERE id=" . $pageRefId . " AND loc_id=" . $_GET['loc_id'] . " ");
        $rowPage = mysqli_fetch_array($sqlPage);

        if ($rowPage['active'] == 'true' && $pageRefId == $rowPage['id']){

            if ($rowPage['image'] > ""){
                $pageImage = "<img src='uploads/" . $_GET['loc_id'] . "/" . $rowPage['image'] . "' alt='" . $rowPage['title'] . "' title='" . $rowPage['title'] . "'>";
            }

            $pageTitle = $rowPage['title'];
            $pageContent = $rowPage['content'];
            $pageImageAlign = $rowPage['image_align'];

        } else {

            $pageTitle = "Page not found";
            $pageContent = "This page is not available.";
        }

    } else {

        $pageTitle = "Page not found";
        $pageContent = "This page is not available.";
    }
}

function getAbout(){
    global $aboutTitle;
    global $aboutContent;
    global $aboutImage;
    global $aboutImageAlign;
    global $imagePath;
    global $db_conn;

    $sqlAbout = mysqli_query($db_conn, "SELECT heading, content, image, image_align, use_defaults, loc_id FROM aboutus WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowAbout = mysqli_fetch_array($sqlAbout);
    $imagePath = $_GET['loc_id'];

    if ($rowAbout['use_defaults'] == "true" || $rowAbout['use_defaults'] == "" || $rowAbout['use_defaults'] == NULL) {
        $sqlAbout = mysqli_query($db_conn, "SELECT heading, content, image, image_align, loc_id FROM aboutus WHERE loc_id=1");
        $rowAbout = mysqli_fetch_array($sqlAbout);

        $imagePath = 1;
    }

    if (!empty($rowAbout['heading'])){
        $aboutTitle = $rowAbout['heading'];
    }

    if (!empty($rowAbout['content'])){
        $aboutContent = $rowAbout['content'];
    }

    if (!empty($rowAbout['image'])){
        $aboutImage = "<img src='uploads/" . $imagePath . "/" . $rowAbout['image'] . "' alt='" . $rowAbout['image'] . "' title='" . $rowAbout['image'] . "'>";
    }

    $aboutImageAlign = $rowAbout['image_align'];
}

function getContactInfo(){
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
    global $emailValidatePattern;

    global $db_conn;

    $emailValidatePattern = "(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}";

    $sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, use_defaults, hours FROM contactus WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowContact = mysqli_fetch_array($sqlContact);

    if ($rowContact['use_defaults'] == "true" || $rowContact['use_defaults'] == "" || $rowContact['use_defaults'] == NULL) {
        $sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, use_defaults, hours FROM contactus WHERE loc_id=1 ");
        $rowContact = mysqli_fetch_array($sqlContact);
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

function getServices(){
    global $sqlServicesHeading;
    global $rowServicesHeading;
    global $servicesHeading;
    global $sqlServices;
    global $servicesNumRows;
    global $servicesBlurb;
    global $servicesCount;
    global $servicesIcon;
    global $db_conn;

    $sqlServicesSetup = mysqli_query($db_conn, "SELECT services_use_defaults FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowServicesSetup = mysqli_fetch_array($sqlServicesSetup);

    //toggle default location value
    if ($rowServicesSetup['services_use_defaults'] == 'true' || $rowServicesSetup['services_use_defaults'] == "" || $rowServicesSetup['services_use_defaults'] == NULL) {
        $servicesDefaultLoc = 1;
    } else {
        $servicesDefaultLoc = $_GET['loc_id'];
    }

    $sqlServicesHeading = mysqli_query($db_conn, "SELECT servicesheading, servicescontent FROM setup WHERE loc_id=" . $servicesDefaultLoc . " ");
    $rowServicesHeading = mysqli_fetch_array($sqlServicesHeading);

    $servicesHeading = $rowServicesHeading['servicesheading'];

    if (!empty($rowServicesHeading['servicescontent'])){
        $servicesBlurb = $rowServicesHeading['servicescontent'];
    }

    $sqlServices = mysqli_query($db_conn, "SELECT id, icon, image, title, link, content, active FROM services WHERE active='true' AND loc_id=" . $servicesDefaultLoc . " ORDER BY datetime DESC"); //While loop
    $servicesNumRows = mysqli_num_rows($sqlServices);
    $servicesCount = 0;
}

function getTeam(){
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

    $sqlTeamSetup = mysqli_query($db_conn, "SELECT team_use_defaults FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowTeamSetup = mysqli_fetch_array($sqlTeamSetup);

    //toggle default location value
    if ($rowTeamSetup['team_use_defaults'] == 'true' || $rowTeamSetup['team_use_defaults'] == "" || $rowTeamSetup['team_use_defaults'] == NULL) {
        $teamDefaultLoc = 1;
    } else {
        $teamDefaultLoc = $_GET['loc_id'];
    }

    $sqlTeamHeading = mysqli_query($db_conn, "SELECT teamheading, teamcontent FROM setup WHERE loc_id=" . $teamDefaultLoc . " ");
    $rowTeamHeading = mysqli_fetch_array($sqlTeamHeading);

    $teamHeading = $rowTeamHeading['teamheading'];

    if (!empty($rowTeamHeading['teamcontent'])){
        $teamBlurb = $rowTeamHeading['teamcontent'];
    }

    $sqlTeam = mysqli_query($db_conn, "SELECT id, image, title, name, content, active FROM team WHERE active='true' AND loc_id=" . $teamDefaultLoc . " ORDER BY datetime DESC"); //While loop
    $teamNumRows = mysqli_num_rows($sqlTeam);
}

function getNav($navSection, $dropdown, $pull){
    //EXAMPLE: getNav('Top','true','right')
    global $db_conn;
    global $navLinksID;
    global $navLinksSort;
    global $navLinksName;
    global $navLinksUrl;
    global $navLinksCatId;
    global $navLinksSection;
    global $navLinksWin;
    global $navLinksLocId;
    global $navLinksDateTime;
    global $navLinks_CatId;
    global $navLinks_CatName;
    global $navLinks_CatNavLocId;
    global $navLinks_CatDateTime;
    global $navCatLinksID;
    global $navCatLinksSort;
    global $navCatLinksName;
    global $navCatLinksUrl;
    global $navCatLinksCatID;
    global $navSections;

    echo "<ul class='nav navbar-nav navbar-$pull navbar-$navSection'>";
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
    $sqlNavDefaults = mysqli_query($db_conn, "SELECT navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3 FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowNavDefaults = mysqli_fetch_array($sqlNavDefaults);

    //toggle default location value if conditions are true
    if ($navSection == $navSectionIndex1 && $rowNavDefaults['navigation_use_defaults_1'] == 'true') {
        $navDefaultLoc = 1;
    } elseif ($navSection == $navSectionIndex2 && $rowNavDefaults['navigation_use_defaults_2'] == 'true') {
        $navDefaultLoc = 1;
    } elseif ($navSection == $navSectionIndex3 && $rowNavDefaults['navigation_use_defaults_3'] == 'true') {
        $navDefaultLoc = 1;
    } else {
        $navDefaultLoc = $_GET['loc_id'];
    }

    $sqlNavLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='$navSection' AND sort>0 AND loc_id=" . $navDefaultLoc . " ORDER BY sort");
    //returns: navigation.id, navigation.sort, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, navigation.loc_id, navigation.datetime, category.id, category.name, category.loc_id, category.nav_loc_id
    $tempLink = 0;

    while ($rowNavLinks = mysqli_fetch_array($sqlNavLinks)) {

        //Variables for $sqlNavLinks SQL Join
        $navLinksID = $rowNavLinks[0];
        $navLinksSort = $rowNavLinks[1];
        $navLinksName = $rowNavLinks[2];
        $navLinksUrl = $rowNavLinks[3];
        $navLinksCatId = $rowNavLinks[4];
        $navLinksSection = $rowNavLinks[5];
        $navLinksWin = $rowNavLinks[6];
        $navLinksLocId = $rowNavLinks[7];
        $navLinksDateTime = $rowNavLinks[8];
        $navLinks_Author = $rowNavLinks[9];
        $navLinks_CatId = $rowNavLinks[10];
        $navLinks_CatName = $rowNavLinks[11];
        $navLinks_CatNavLocId = $rowNavLinks[12];

        //Check if link contains shortcode
        $navLinksUrl = getShortCode($navLinksUrl);

        //New Window
        if ($navLinksWin == 'true'){
            $navWin = "target='_blank'";
        } else {
            $navWin = "";
        }

        //Create category - drop down menus
        if ($navLinksCatId == $navLinks_CatId && $navLinksCatId != 0){ //NOTE: 0=None in the category table

            if ($navLinksCatId != $tempLink){

                $sqlNavCatLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='$navSection' AND category.id=" . $navLinksCatId . " AND sort>0 AND loc_id='" . $navDefaultLoc . "' ORDER BY sort");
                //returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, navigation.loc_id, navigation.datetime, category.id, category.name, category.nav_loc_id

                echo "<li class='$dropdown'>";
                echo "<a href='#' class='cat-$navSection' data-toggle='$dataToggle'>" . $navLinks_CatName . " $dropdownCaret</a>";
                echo "<ul class='$dropdownMenu'>";
                while ($rowNavCatLinks = mysqli_fetch_array($sqlNavCatLinks)){

                    //Variables for $rowNavCatLinks SQL Join
                    $navCatLinksID = $rowNavCatLinks[0];
                    $navCatLinksSort = $rowNavCatLinks[1];
                    $navCatLinksName = $rowNavCatLinks[2];
                    $navCatLinksUrl = $rowNavCatLinks[3];
                    $navCatLinksCatID = $rowNavCatLinks[4];
                    $navCatLinksCatSection = $rowNavCatLinks[5];
                    $navCatLinksWin = $rowNavCatLinks[6];

                    //Check if cat link contains shortcode
                    $navCatLinksUrl = getShortCode($navCatLinksUrl);

                    //New Window
                    if ($navCatLinksWin == 'true'){
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

function getSetup(){
    global $setupTitle;
    global $setupAuthor;
    global $setupKeywords;
    global $setupDescription;
    global $setupConfig;
    global $setupLs2pac;
    global $setupLs2kids;
    global $setupSearchDefault;
    global $setupLogo;
    global $db_conn;

    $sqlSetup = mysqli_query($db_conn, "SELECT title, author, keywords, description, config, logo, ls2pac, ls2kids, searchdefault, loc_id FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowSetup = mysqli_fetch_array($sqlSetup);

    $setupDescription = $rowSetup['description'];
    $setupKeywords = $rowSetup['keywords'];
    $setupAuthor = $rowSetup['author'];
    $setupTitle = $rowSetup['title'];
    $setupConfig = $rowSetup['config'];
    $setupLogo = $rowSetup['logo'];
    $setupLs2pac = $rowSetup['ls2pac'];
    $setupLs2kids = $rowSetup['ls2kids'];
    $setupSearchDefault = $rowSetup['searchdefault'];
}

function getSocialMediaIcons($shape, $section){
    //EXAMPLE: getSocialMediaIcons("circle","top")
    //EXAMPLE: getSocialMediaIcons("square","footer")
    global $socialMediaIcons;
    global $socialMediaHeading;
    global $sqlSocialMedia;
    global $rowSocialMedia;
    global $db_conn;

    $sqlSocialMedia = mysqli_query($db_conn, "SELECT * FROM socialmedia WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowSocialMedia = mysqli_fetch_array($sqlSocialMedia);

    //use default location
    if ($rowSocialMedia['use_defaults'] == "true" || $rowSocialMedia['use_defaults'] == "" || $rowSocialMedia['use_defaults'] == NULL) {
        $sqlSocialMedia = mysqli_query($db_conn, "SELECT * FROM socialmedia WHERE loc_id=1 ");
        $rowSocialMedia = mysqli_fetch_array($sqlSocialMedia);
    }

    $socialMediaIcons = "";

    if (!empty($rowSocialMedia['heading'])){
        $socialMediaHeading = $rowSocialMedia['heading'];
    }

    if (!empty($rowSocialMedia['facebook'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['facebook'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-facebook fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['google'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['google'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-google-plus fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['pinterest'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['pinterest'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-pinterest fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['twitter'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['twitter'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-twitter fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['instagram'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['instagram'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-instagram fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['youtube'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['youtube'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-youtube fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }

    if (!empty($rowSocialMedia['tumblr'])){
        $socialMediaIcons .= "<a class='pull-right' href=" . $rowSocialMedia['tumblr'] . " target='_blank'><span class='fa-stack fa-lg social-$section'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-tumblr fa-stack-1x fa-lg fa-inverse-socialmedia'></i></span></a>";
    }
}

function getCustomers($custType){
    global $sqlCustomers;
    global $customerHeading;
    global $customerBlurb;
    global $customerNumRows;
    global $customerFeatured;
    global $customerIcon;
    global $customerCatId;
    global $customerCatName;
    global $customerSection;
    global $custDefaultLoc;
    global $custSections;
    global $db_conn;

    //loop through the array of custSections - config.php
    $custSectionIndex1 = "";
    $custSectionIndex2 = "";
    $custSectionIndex3 = "";

    $custArrlength = count($custSections); //from config.php

    for ($x = 0; $x < $custArrlength; $x++) {
        $custSectionIndex1 = $custSections[0];
        $custSectionIndex2 = $custSections[1];
        $custSectionIndex3 = $custSections[2];
    }

    if (!empty($_GET['section'])) {
        $customerSection = $_GET['section'];
    } else {
        $customerSection = $custSections[0];
    }

    //get the default values from setup table where get loc_id
    $sqlCustomerSetup = mysqli_query($db_conn, "SELECT databases_use_defaults_1, databases_use_defaults_2, databases_use_defaults_3 FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowCustomerSetup = mysqli_fetch_array($sqlCustomerSetup);

    //toggle default location value if conditions are true
    if ($customerSection == $custSectionIndex1 && $rowCustomerSetup['databases_use_defaults_1'] == 'true') {
        $custDefaultLoc = 1;
    } elseif ($customerSection == $custSectionIndex2 && $rowCustomerSetup['databases_use_defaults_2'] == 'true') {
        $custDefaultLoc = 1;
    } elseif ($customerSection == $custSectionIndex3 && $rowCustomerSetup['databases_use_defaults_3'] == 'true') {
        $custDefaultLoc = 1;
    } else {
        $custDefaultLoc = $_GET['loc_id'];
    }

    //sets to use defaults if conditions are true where loc_id = $custDefaultLoc
    $sqlCustomerSetup = mysqli_query($db_conn, "SELECT databases_use_defaults_1, databases_use_defaults_2, databases_use_defaults_3, customersheading_1, customersheading_2, customersheading_3, customerscontent_1, customerscontent_2, customerscontent_3 FROM setup WHERE loc_id=" . $custDefaultLoc . " ");
    $rowCustomerSetup = mysqli_fetch_array($sqlCustomerSetup);

    //toggle default location value if conditions are true
    if ($customerSection == $custSectionIndex1 && $rowCustomerSetup['databases_use_defaults_1'] == 'true') {
        $customerHeading = $rowCustomerSetup['customersheading_1'];
        $customerBlurb = $rowCustomerSetup['customerscontent_1'];
    } elseif ($customerSection == $custSectionIndex2 && $rowCustomerSetup['databases_use_defaults_2'] == 'true') {
        $customerHeading = $rowCustomerSetup['customersheading_2'];
        $customerBlurb = $rowCustomerSetup['customerscontent_2'];
    } elseif ($customerSection == $custSectionIndex3 && $rowCustomerSetup['databases_use_defaults_3'] == 'true') {
        $customerHeading = $rowCustomerSetup['customersheading_3'];
        $customerBlurb = $rowCustomerSetup['customerscontent_3'];
    }

    //Get Category
    //If cat_id=int then display a page of databases for only that category
    if (!empty($_GET['cat_id'])) {
        $sqlCatCustomers = mysqli_query($db_conn, "SELECT id, name FROM category_customers WHERE id IN (SELECT catid FROM customers WHERE catid = " . $_GET['cat_id'] . " AND loc_id=" . $custDefaultLoc . ")");
        $rowCatCustomers = mysqli_fetch_array($sqlCatCustomers);
        $customerCatId = $rowCatCustomers[0];
        $customerCatName = $rowCatCustomers[1];
        $customerCatWhere = "catid=" . $_GET['cat_id'] . " AND ";
    } else {
        $customerCatWhere = "";
    }

    if ($custType == "featured") {
        $customerSectionWhere = "";
    } else {
        $customerSectionWhere = "section='" . $customerSection . "' AND ";
    }

    $sqlCustomers = mysqli_query($db_conn, "SELECT id, image, icon, name, section, link, catid, content, featured, datetime, active, loc_id FROM customers WHERE active='true' AND " . $customerSectionWhere . " " . $customerCatWhere . " loc_id=" . $custDefaultLoc . " ORDER BY datetime DESC "); //While loop
    $customerNumRows = mysqli_num_rows($sqlCustomers);

}

function getSlider($sliderType){
    //EXAMPLE: getSlider("slide")
    //EXAMPLE: getSlider("random")
    global $sliderLink;
    global $sliderTitle;
    global $sliderContent;
    global $sliderImage;
    global $imagePath;
    global $db_conn;

    if ($sliderType == "slide"){
        $sliderOrderBy = "ORDER BY datetime DESC";
    } elseif ($sliderType == "random" || $sliderType == ""){
        $sliderOrderBy = "ORDER BY RAND() LIMIT 1";
    }

    $sliderCount = 0;
    $imagePath = $_GET['loc_id'];

    //get the default value from setup table
    $sqlSliderSetup = mysqli_query($db_conn, "SELECT slider_use_defaults, loc_id FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowSliderSetup = mysqli_fetch_array($sqlSliderSetup);

    $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, active, loc_id FROM slider WHERE active='true' AND loc_id=" . $_GET['loc_id'] . " $sliderOrderBy");
    $sliderNumRows = mysqli_num_rows($sqlSlider);

    //use default location
    if ($rowSliderSetup['slider_use_defaults'] == "true" || $rowSliderSetup['slider_use_defaults'] == "" || $rowSliderSetup['slider_use_defaults'] == NULL) {
        $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, active, loc_id FROM slider WHERE active='true' AND loc_id=1 $sliderOrderBy");
        $sliderNumRows = mysqli_num_rows($sqlSlider);

        $imagePath = 1; //the default location
    }

    //hide carousel arrows if only one image is available
    if ($sliderNumRows == 1){
        echo "<style>.carousel-control {display: none !important;}</style>";
    }

    if ($sliderNumRows > 0){

        if ($sliderType == "slide"){
            echo "<header id='myCarousel' class='carousel slide'>";
            //Wrapper for slides
            echo "<div class='carousel-inner'>";
            while ($rowSlider = mysqli_fetch_array($sqlSlider)){
                $sliderCount++;

                if ($sliderCount == 1){
                    $slideActive = "active";
                } else {
                    $slideActive = "";
                }

                echo "<div class='item $slideActive'>";

                if (!empty($rowSlider['image'])){
                    echo "<div class='fill' style='background-image:url(uploads/" . $imagePath . "/" . $rowSlider['image'] . ");'></div>";
                } else {
                    echo "<div class='fill'></div>";
                }

                echo "<div class='carousel-caption'>";

                echo "<h2>" . $rowSlider['title'] . "</h2>";
                echo "<p>" . $rowSlider['content'] . "</p>";

                if (!empty($rowSlider['link'])){
                    if (ctype_digit($rowSlider['link'])){
                        echo "<a href='page.php?page_id=" . $rowSlider['link'] . "&loc_id=" . $rowSlider['loc_id'] . "' class='btn btn-primary'>Learn More</a>";
                    } else {
                        echo "<a href='" . $rowSlider['link'] . "' class='btn btn-primary'>Learn More</a>";
                    }
                }

                echo "</div>"; //.carousel-caption

                echo "</div>"; //.item
            }

            echo "</div>"; //.carousel-inner

            //Controls
            echo "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>";
            echo "<span class='icon-prev'></span>";
            echo "</a>";
            echo "<a class='right carousel-control' href='#myCarousel' data-slide='next'>";
            echo "<span class='icon-next'></span>";
            echo "</a>";

            echo "</header>";

        } elseif ($sliderType == "random"){
            $rowSlider = mysqli_fetch_array($sqlSlider);
            echo "<header id='myCarousel' class='carousel slide'>";

            echo "<div class='carousel-inner'>";

            echo "<div class='item active'>";

            if (!empty($rowSlider['image'])){
                echo "<div class='fill' style='background-image:url(uploads/" . $imagePath . "/" . $rowSlider['image'] . ");'></div>";
            } else {
                echo "<div class='fill'></div>";
            }

            echo "<div class='carousel-caption'>";

            echo "<h2>" . $rowSlider['title'] . "</h2>";
            echo "<p>" . $rowSlider['content'] . "</p>";

            if (!empty($rowSlider['link'])){
                if (ctype_digit($rowSlider['link'])){
                    echo "<a href='page.php?page_id=" . $rowSlider['link'] . "&loc_id=" . $rowSlider['loc_id'] . "' class='btn btn-primary'>Learn More</a>";
                } else {
                    echo "<a href='" . $rowSlider['link'] . "' class='btn btn-primary'>Learn More</a>";
                }
            }

            echo "</div>"; //.carousel-caption

            echo "</div>"; //.item

            echo "</div>"; //.carousel-inner

            echo "</header>";

        } else {
            $rowSlider = mysqli_fetch_array($sqlSlider);
            $sliderLink = $rowSlider['link'];
            $sliderTitle = $rowSlider['title'];
            $sliderContent = $rowSlider['content'];
            $sliderImage = $rowSlider['image'];
        }

    }
}

function getGeneralInfo(){
    global $generalInfoContent;
    global $generalInfoHeading;
    global $db_conn;

    $sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, use_defaults FROM generalinfo WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo);

    //use default location
    if ($rowGeneralinfo['use_defaults'] == "true" || $rowGeneralinfo['use_defaults'] == "" || $rowGeneralinfo['use_defaults'] == NULL){
        $sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content, use_defaults FROM generalinfo WHERE loc_id=1 ");
        $rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo);
    }

    if (!empty($rowGeneralinfo['content'])){
        $generalInfoContent = $rowGeneralinfo['content'];
    }

    if (!empty($rowGeneralinfo['heading'])){
        $generalInfoHeading = $rowGeneralinfo['heading'];
    }
}

function getFeatured(){
    global $featuredContent;
    global $featuredHeading;
    global $featuredBlurb;
    global $featuredImage;
    global $featuredImageAlign;
    global $imagePath;
    global $db_conn;

    $sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, image, image_align, use_defaults FROM featured WHERE loc_id=" . $_GET['loc_id'] . " ");
    $rowFeatured = mysqli_fetch_array($sqlFeatured);
    $imagePath = $_GET['loc_id'];

    if ($rowFeatured['use_defaults'] == "true" || $rowFeatured['use_defaults'] == "" || $rowFeatured['use_defaults'] == NULL){
        $sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, image, image_align FROM featured WHERE loc_id=1 ");
        $rowFeatured = mysqli_fetch_array($sqlFeatured);

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

    if (!empty($rowFeatured['image'])){
        $featuredImage = "<img class='img-landing hidden-xs' src='uploads/" . $imagePath . "/" . $rowFeatured['image'] . "' alt='" . $rowFeatured['image'] . "' title='" . $rowFeatured['image'] . "'>";
    }

    $featuredImageAlign = $rowFeatured['image_align'];
}

//Call - getSetup is used everywhere
getSetup();

//Random password generator for password reset
function generateRandomString($length = 10){
    global $randomString;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

//Short Code function. Use [my_vals] in the Admin Panel to pull in values from the database
function getShortCode($urlStr){
    global $setupConfig;
    global $setupPACURL;
    global $homePageURL;

    if (strpos($urlStr, '[pac_url]') == true) {
        $urlStr = str_replace('[pac_url]', $setupPACURL, $urlStr);
    } elseif (strpos($urlStr, '[homepage_url]') == true) {
        $urlStr = str_replace('[homepage_url]', $homePageURL, $urlStr);
    } elseif (strpos($urlStr, '[config]') == true) {
        $urlStr = str_replace('[config]', $setupConfig, $urlStr);
    } elseif (strpos($urlStr, '[loc_id]') == true) {
        $urlStr = str_replace('[loc_id]', $_GET['loc_id'], $urlStr);
    }

    return $urlStr;
}

//Call these functions depending on which page you are visiting
//Sets the page title and calls the main function for each page.
if (basename($_SERVER['PHP_SELF']) == "page.php"){
    getPage();
    $theTitle = $setupTitle . " - " . $pageTitle;
} elseif (basename($_SERVER['PHP_SELF']) == "about.php"){
    getAbout();
    $theTitle = $setupTitle . " - " . $aboutTitle;
} elseif (basename($_SERVER['PHP_SELF']) == "contact.php"){
    getContactInfo();
    $theTitle = $setupTitle . " - " . $contactHeading;
} elseif (basename($_SERVER['PHP_SELF']) == "services.php"){
    getServices();
    $theTitle = $setupTitle . " - " . $servicesHeading;
} elseif (basename($_SERVER['PHP_SELF']) == "team.php"){
    getTeam();
    $theTitle = $setupTitle . " - " . $teamHeading;
} elseif (basename($_SERVER['PHP_SELF']) == "databases.php"){
    getCustomers(NULL);
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

} elseif ($multiBranch == "false" && $_GET['loc_id'] != 1){
    header("Location: index.php?loc_id=1");
    echo "<script>window.location.href='index.php?loc_id=1';</script>";
}

//School search box redirect to loc_id where name = querystring loc_name
if (!empty($_GET['loc_name'])){

    $sqlLocName = mysqli_query($db_conn, "SELECT name, id, active FROM locations WHERE active='true' AND name='" . $_GET['loc_name'] . "' LIMIT 1");
    $rowLocName = mysqli_fetch_array($sqlLocName);

    header("Location: " . basename($_SERVER['PHP_SELF']) . "?loc_id=" . $rowLocName['id'] . "");
    echo "<script>window.location.href='" . basename($_SERVER['PHP_SELF']) . '?loc_id=' . $rowLocName['id'] . "';</script>";
}
?>