<?php 
function getPage(){
	global $pageImage;
	global $pageTitle;
	global $pageContent;
	global $pageImageAlign;

	if ($_GET["ref"]>""){
		$pageRefId=$_GET["ref"];
		$sqlPage = mysql_query("SELECT id, title, image, image_align, content, active FROM pages WHERE id='$pageRefId'");
		$rowPage = mysql_fetch_array($sqlPage);

		if ($rowPage['active']=1 AND $pageRefId=$rowPage['id']) {

			if ($rowPage["image"]>"") {
				$pageImage = "<img class='img-responsive' src='uploads/".$rowPage["image"]."' alt='".$rowPage["title"]."' title='".$rowPage["title"]."'>";
			}

			$pageTitle = $rowPage['title'];
			$pageContent = $rowPage["content"];
			$pageImageAlign = $rowPage["image_align"];

		} else {

            $pageTitle = "Page not found";
		    $pageContent = "This page has been removed.";

		}

	}
}

function getAbout(){
	global $aboutTitle;
	global $aboutContent;
	global $aboutImage;
	global $aboutImageAlign;

	$sqlAbout = mysql_query("SELECT heading, content, image, image_align FROM aboutus");
	$rowAbout = mysql_fetch_array($sqlAbout);

	if (!empty($rowAbout["heading"])){
		$aboutTitle = $rowAbout["heading"];
	}

	if (!empty($rowAbout["content"])) {
		$aboutContent = $rowAbout["content"];
	}

	if (!empty($rowAbout["image"])) {
		$aboutImage = "<img class='img-responsive' src='uploads/".$rowAbout["image"]."' alt='".$rowAbout["image"]."' title='".$rowAbout["image"]."'>";
	}

	$aboutImageAlign = $rowAbout["image_align"];
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

	$sqlContact = mysql_query("SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours FROM contactus");
	$rowContact = mysql_fetch_array($sqlContact);

    if ($_GET["msgsent"]=="thankyou") {
        $contactFormMsg = "<div id='success'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='#'\">×</button><strong>Your message has been sent. </strong></div></div>";
    } else if ($_GET["msgsent"]=="error") {
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
}

function getServices(){
	global $sqlServicesHeading;
	global $rowServicesHeading;
	global $servicesHeading;
	global $sqlServices;
	global $servicesNumRows;
	global $servicesColWidth;
	global $servicesBlurb;
	global $servicesCount;
	global $servicesIcon;

    $sqlServicesHeading = mysql_query("SELECT servicesheading, servicescontent FROM setup");
    $rowServicesHeading = mysql_fetch_array($sqlServicesHeading);

    $servicesHeading = $rowServicesHeading['servicesheading'];

    if (!empty($rowServicesHeading['servicescontent'])) {
    	$servicesBlurb = $rowServicesHeading['servicescontent'];
	}

    $sqlServices = mysql_query("SELECT id, icon, image, title, link, content, active FROM services WHERE active=1 ORDER BY datetime DESC"); //While loop
    $servicesNumRows = mysql_num_rows($sqlServices);
    $servicesCount=0;

    if ($servicesNumRows==2) {
        $servicesColWidth=6;
    } elseif ($servicesNumRows==3) {
        $servicesColWidth=4;
    } elseif ($servicesNumRows==4) {
        $servicesColWidth=3;
    } else {
    	$servicesColWidth=2;
    }
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
	global $teamColWidth;

	$sqlTeamHeading = mysql_query("SELECT teamheading, teamcontent FROM setup");
    $rowTeamHeading = mysql_fetch_array($sqlTeamHeading);

    $teamHeading = $rowTeamHeading['teamheading'];

    if (!empty($rowTeamHeading['teamcontent'])) {
    	$teamBlurb = $rowTeamHeading['teamcontent'];
	}

    $sqlTeam = mysql_query("SELECT id, image, title, name, content, active FROM team WHERE active=1 ORDER BY datetime DESC"); //While loop
    $teamNumRows = mysql_num_rows($sqlTeam);	

    if ($teamNumRows==2) {
    	$teamColWidth=6;
    } elseif ($teamNumRows==3) {
    	$teamColWidth=4;
    } elseif ($teamNumRows==4) {
    	$teamColWidth=3;
    } else {
    	$teamColWidth=2;
    }
}

function getNav($navSection,$dropdown,$pull){
	//EXAMPLE: getNav('Top','true','right')
    echo "<ul class='nav navbar-nav navbar-$pull'>";

		if ($dropdown=="true"){
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

        $sqlNavLinks = mysql_query("SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='$navSection' AND sort>0 ORDER BY sort");
        //returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, category.id, category.name
        $tempLink = 0;
		while ($rowNavLinks = mysql_fetch_array($sqlNavLinks)) {
			
            if ($rowNavLinks[4] == $rowNavLinks[7] AND $rowNavLinks[4] != 29) { //NOTE: 29=None in the category table

				if ($rowNavLinks[4] != $tempLink) {
					$sqlNavCatLinks = mysql_query("SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='$navSection' AND category.id=".$rowNavLinks[4]." AND sort>0 ORDER BY sort");
					//returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, category.id, category.name
			
                    echo "<li class='$dropdown'>";
						echo "<a href='#' class='cat-$navSection' data-toggle='$dataToggle'>".$rowNavLinks[8]." $dropdownCaret</a>";
						echo "<ul class='$dropdownMenu'>";
						while ($rowNavCatLinks = mysql_fetch_array($sqlNavCatLinks)) {
							echo "<li>";
							echo "<a href='".$rowNavCatLinks[3]."'>".$rowNavCatLinks[2]."</a>";
							echo "</li>";
						}
						echo "</ul>";
					echo "</li>";
				}

            } else {
                echo "<li>";
                echo "<a href='".$rowNavLinks[3]."'>".$rowNavLinks[2]."</a>";
                echo "</li>";
            }

			$tempLink = $rowNavLinks[4];
		}
    echo "</ul>";
}

function getSetup(){
	global $setupTitle;
	global $setupAuthor;
	global $setupKeywords;
	global $setupDescription;
	global $setupHeadercode;
	global $setupGoogleanalytics;

    $sqlSetup = mysql_query("SELECT title, author, keywords, description, headercode, googleanalytics FROM setup");
    $rowSetup  = mysql_fetch_array($sqlSetup);

    $setupDescription = $rowSetup["description"];
    $setupKeywords = $rowSetup["keywords"];
    $setupAuthor = $rowSetup["author"];
    $setupTitle = $rowSetup["title"];
    $setupGoogleanalytics = $rowSetup["googleanalytics"];

    if (!empty($rowSetup["headercode"])) {
        $setupHeadercode = $rowSetup["headercode"]."\n";
    }

    if (!empty($rowSetup["googleanalytics"])) {
        $setupGoogleanalytics = $rowSetup["googleanalytics"];
    }
}

function getSocialMediaIcons(){
	global $socialMediaIcons;
	global $socialMediaHeading;
	global $sqlSocialMedia;
	global $rowSocialMedia;

	$sqlSocialMedia = mysql_query("SELECT * FROM socialmedia");
	$rowSocialMedia = mysql_fetch_array($sqlSocialMedia);

	$socialMediaIcons = "";

	if (!empty($rowSocialMedia["heading"])){
		$socialMediaHeading = $rowSocialMedia["heading"];
	}

    if (!empty($rowSocialMedia["facebook"])){
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia["facebook"]."><i class='fa fa-facebook-square fa-2x'></i></a></li>";
    }

    if (!empty($rowSocialMedia["google"])){
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia["google"]."><i class='fa fa-google-plus-square fa-2x'></i></a></li>";
    }

    if (!empty($rowSocialMedia["github"])){
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia["github"]."><i class='fa fa-github-square fa-2x'></i></a></li>";
    }

    if (!empty($rowSocialMedia["twitter"])){
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia["twitter"]."><i class='fa fa-twitter-square fa-2x'></i></a></li>";
    }

    if (!empty($rowSocialMedia["linkedin"])){
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia["linkedin"]."><i class='fa fa-linkedin-square fa-2x'></i></a></li>";
    }

    $socialMediaIcons = "<ul class='list-unstyled list-inline list-social-icons'>".$socialMediaIcons."</ul>";
}

function getCustomers(){
	global $sqlCustomerHeading;
	global $rowCustomerHeading;
	global $sqlCustomers;
	global $customerHeading;
	global $customerBlurb;
	global $customerNumRows;
	global $customerColWidth;

    $sqlCustomerHeading = mysql_query("SELECT customersheading, customerscontent FROM setup");
    $rowCustomerHeading = mysql_fetch_array($sqlCustomerHeading);

	if (!empty($rowCustomerHeading['customersheading'])) {
	    $customerHeading = $rowCustomerHeading['customersheading'];
	}

    if (!empty($rowCustomerHeading['customerscontent'])) {
    	$customerBlurb= $rowCustomerHeading['customerscontent'];
	}

    $sqlCustomers = mysql_query("SELECT image, name, link, active FROM customers WHERE active=1 ORDER BY datetime DESC"); //While loop
    $customerNumRows = mysql_num_rows($sqlCustomers);	

    if ($customerNumRows==2) {
    	$customerColWidth=6;
    } elseif ($customerNumRows==3) {
    	$customerColWidth=4;
    } elseif ($customerNumRows==4) {
    	$customerColWidth=3;
    } else {
    	$customerColWidth=2;
    }
}

function getSlider($sliderType) {
    //EXAMPLE: getSlider("slide")
    //EXAMPLE: getSlider("random")
    
	if ($sliderType=="slide") {
		$sliderOrderBy = "ORDER BY datetime DESC";
	} else if ($sliderType=="random") {
		$sliderOrderBy = "ORDER BY RAND() LIMIT 1";
	}

    $sqlSlider = mysql_query("SELECT id, title, image, link, content, active FROM slider WHERE active=1 $sliderOrderBy");
    $sliderNumRows = mysql_num_rows($sqlSlider);
    $sliderCount=0;

    if ($sliderNumRows > 0) {
        echo "<header id='myCarousel' class='carousel slide'>";
        //Wrapper for slides
        echo "<div class='carousel-inner'>";

        if ($sliderType=="slide") {

            while ($rowSlider  = mysql_fetch_array($sqlSlider)) {
                $sliderCount++;

                if ($sliderCount==1) {
                    $slideActive = "active";
                } else {
                    $slideActive = "";
                }

                echo "<div class='item $slideActive'>";

                if ($rowSlider["image"] > "") {
                    echo "<div class='fill' style='background-image:url(uploads/".$rowSlider['image'].");'></div>";
                } else {
                    echo "<div class='fill'></div>";
                }

                echo "<div class='carousel-caption'>";
                echo "<h2>".$rowSlider["title"]."</h2>";
                echo "<p>".$rowSlider["content"]."</p>";

                if (!empty($rowSlider['link'])){
                    echo "<a href='page.php?ref=".$rowSlider['link']."' class='btn btn-primary'>Learn More</a>";
                }

                echo "</div>";

                echo "</div>";
            }

        } else if ($sliderType=="random" OR $sliderCount==1) {
        	$rowSlider  = mysql_fetch_array($sqlSlider);

        	if ($rowSlider["image"] > "") {
                echo "<div class='fill' style='background-image:url(uploads/".$rowSlider['image'].");'></div>";
            } else {
                echo "<div class='fill'></div>";
            }

            echo "<div class='carousel-caption'>";
            echo "<h2>".$rowSlider["title"]."</h2>";
            echo "<p>".$rowSlider["content"]."</p>";

            if (!empty($rowSlider['link'])){
                echo "<a href='page.php?ref=".$rowSlider['link']."' class='btn btn-primary'>Learn More</a>";
            }
        }

        echo "</div>"; //.carousel-inner

		if ($sliderType=="slide") {
            //Controls
            echo "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>";
            echo "<span class='icon-prev'></span>";
            echo "</a>";
            echo "<a class='right carousel-control' href='#myCarousel' data-slide='next'>";
            echo "<span class='icon-next'></span>";
            echo "</a>";
        }

        echo "</header>";
    }
}

function getGeneralInfo(){
	global $generalInfoContent;
	global $generalInfoHeading;

	$sqlGeneralinfo = mysql_query("SELECT heading, content FROM generalinfo");
	$rowGeneralinfo = mysql_fetch_array($sqlGeneralinfo);

	if (!empty($rowGeneralinfo["content"])) {
		$generalInfoContent = $rowGeneralinfo["content"];
	}

	if (!empty($rowGeneralinfo["heading"])) {
		$generalInfoHeading = $rowGeneralinfo["heading"];
	}
}

function getFeatured(){
	global $featuredContent;
	global $featuredHeading;
	global $featuredBlurb;
	global $featuredImage;
	global $featuredImageAlign;

	$sqlFeatured = mysql_query("SELECT heading, introtext, content, image, image_align FROM featured");
	$rowFeatured = mysql_fetch_array($sqlFeatured);

	if (!empty($rowFeatured["introtext"])) {
		$featuredBlurb = $rowFeatured["introtext"];
	}

	if (!empty($rowFeatured["content"])) {
		$featuredContent = $rowFeatured["content"];
	}

	if (!empty($rowFeatured["heading"])) {
		$featuredHeading = $rowFeatured["heading"];
	}
	if ($rowFeatured["image"] > "") {
		$featuredImage = "<img class='img-responsive' src='uploads/".$rowFeatured["image"]."' alt='".$rowFeatured["image"]."' title='".$rowFeatured["image"]."'>";
	}

	$featuredImageAlign = $rowFeatured["image_align"];
}

//Call - getSetup is used everywhere
getSetup();

//Call these functions depending on which page you are visiting
if ($_GET['ref']>""){
    getPage();
    $theTitle = $setupTitle." - ".$pageTitle;
} else if (basename($_SERVER['PHP_SELF'])=="about.php"){
    getAbout();
    $theTitle = $setupTitle." - ".$aboutTitle;
} else if (basename($_SERVER['PHP_SELF'])=="contact.php"){
    getContactInfo();
    $theTitle = $setupTitle." - ".$contactHeading;
} else if (basename($_SERVER['PHP_SELF'])=="services.php"){
    getServices();
    $theTitle = $setupTitle." - ".$servicesHeading;
} else if (basename($_SERVER['PHP_SELF'])=="team.php"){
    getTeam();
    $theTitle = $setupTitle." - ".$teamHeading;
} else {
    $theTitle = $setupTitle;
}
?>