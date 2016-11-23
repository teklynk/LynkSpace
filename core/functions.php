<?php
define('inc_access', TRUE);

function getLocation() {
	global $locationName;
	global $locationActive;
	global $locationID;
	global $db_conn;

	if (ctype_digit($_GET['loc_id'])) {

		$sqlGetLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' AND id=".$_GET['loc_id']." ");
		$rowGetLocation = mysqli_fetch_array($sqlGetLocation);

		if ($rowGetLocation['active']=='true' AND $_GET['loc_id']==$rowGetLocation['id']) {
			$locationName = $rowGetLocation['name'];
			$locationActive = $rowGetLocation['active'];
			$locationID = $rowGetLocation['id'];
		} else {
			header('Location: index.php?loc_id=1');
		}

	}
}

function getPage() {
	global $pageImage;
	global $pageTitle;
	global $pageContent;
	global $pageImageAlign;
  	global $pageDisqus;
	global $pageRefId;
	global $db_conn;

	if (ctype_digit($_GET['page_id'])) {
		$pageRefId = $_GET['page_id'];
		$sqlPage = mysqli_query($db_conn, "SELECT id, title, image, image_align, content, active, disqus, loc_id FROM pages WHERE id=".$pageRefId." AND loc_id=".$_GET['loc_id']." ");
		$rowPage = mysqli_fetch_array($sqlPage);



		if ($rowPage['active']=='true' AND $pageRefId==$rowPage['id']) {

			if ($rowPage['image']>"") {
				$pageImage = "<img class='img-responsive' src='uploads/".$_GET['loc_id']."/".$rowPage['image']."' alt='".$rowPage['title']."' title='".$rowPage['title']."'>";
			}

			$pageTitle = $rowPage['title'];
			$pageContent = $rowPage['content'];
			$pageImageAlign = $rowPage['image_align'];
			$pageDisqus = $rowPage['disqus'];

		} else {

      		$pageTitle = "Page not found";
		  	$pageContent = "This page is not available.";
		}

	} else {

    	$pageTitle = "Page not found";
		$pageContent = "This page is not available.";
	}
}

function getAbout() {
	global $aboutTitle;
	global $aboutContent;
	global $aboutImage;
	global $aboutImageAlign;
	global $db_conn;

	$sqlAbout = mysqli_query($db_conn, "SELECT heading, content, image, image_align, loc_id FROM aboutus WHERE loc_id=".$_GET['loc_id']." ");
	$rowAbout = mysqli_fetch_array($sqlAbout);

	if (!empty($rowAbout['heading'])) {
		$aboutTitle = $rowAbout['heading'];
	}

	if (!empty($rowAbout['content'])) {
		$aboutContent = $rowAbout['content'];
	}

	if (!empty($rowAbout['image'])) {
		$aboutImage = "<img class='img-responsive' src='uploads/".$_GET['loc_id']."/".$rowAbout['image']."' alt='".$rowAbout['image']."' title='".$rowAbout['image']."'>";
	}

	$aboutImageAlign = $rowAbout['image_align'];
}

function getContactInfo() {
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

	$sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours FROM contactus WHERE loc_id=".$_GET['loc_id']." ");
	$rowContact = mysqli_fetch_array($sqlContact);

    if ($_GET['msgsent']=="thankyou") {
        $contactFormMsg = "<div id='success'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='#'\">×</button><strong>Your message has been sent. </strong></div></div>";
    } elseif ($_GET['msgsent']=="error") {
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

function getServices() {
	global $sqlServicesHeading;
	global $rowServicesHeading;
	global $servicesHeading;
	global $sqlServices;
	global $servicesNumRows;
	global $servicesColWidth;
	global $servicesBlurb;
	global $servicesCount;
	global $servicesIcon;
	global $db_conn;

    $sqlServicesHeading = mysqli_query($db_conn, "SELECT servicesheading, servicescontent FROM setup WHERE loc_id=".$_GET['loc_id']." ");
    $rowServicesHeading = mysqli_fetch_array($sqlServicesHeading);

    $servicesHeading = $rowServicesHeading['servicesheading'];

    if (!empty($rowServicesHeading['servicescontent'])) {
    	$servicesBlurb = $rowServicesHeading['servicescontent'];
	}

    $sqlServices = mysqli_query($db_conn, "SELECT id, icon, image, title, link, content, active FROM services WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY datetime DESC"); //While loop
    $servicesNumRows = mysqli_num_rows($sqlServices);
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

function getTeam() {
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
	global $db_conn;

	$sqlTeamHeading = mysqli_query($db_conn, "SELECT teamheading, teamcontent FROM setup WHERE loc_id=".$_GET['loc_id']." ");
    $rowTeamHeading = mysqli_fetch_array($sqlTeamHeading);

    $teamHeading = $rowTeamHeading['teamheading'];

    if (!empty($rowTeamHeading['teamcontent'])) {
    	$teamBlurb = $rowTeamHeading['teamcontent'];
	}

    $sqlTeam = mysqli_query($db_conn, "SELECT id, image, title, name, content, active FROM team WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY datetime DESC"); //While loop
    $teamNumRows = mysqli_num_rows($sqlTeam);

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

function getNav($navSection,$dropdown,$pull) {
	//EXAMPLE: getNav('Top','true','right')
	global $db_conn;
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

	$sqlNavLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='$navSection' AND sort>0 AND loc_id='".$_GET['loc_id']."' ORDER BY sort");
	//returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, navigation.loc_id, category.id, category.name, category.loc_id, category.nav_loc_id
	$tempLink = 0;

	while ($rowNavLinks = mysqli_fetch_array($sqlNavLinks)) {

		if ($rowNavLinks[6]=='true') {
			$navWin = "target='_blank'";
		} else {
            $navWin = "";
        }

		if ($rowNavLinks[4] == $rowNavLinks[8] AND $rowNavLinks[4] != 0) { //NOTE: 0=None in the category table

			if ($rowNavLinks[4] != $tempLink) {
				$sqlNavCatLinks = mysqli_query($db_conn, "SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='$navSection' AND category.id=".$rowNavLinks[4]." AND sort>0 AND loc_id='".$_GET['loc_id']."' ORDER BY sort");
				//returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, navigation.loc_id, category.id, category.name, category.nav_loc_id

				echo "<li class='$dropdown'>";
				echo "<a href='#' class='cat-$navSection' data-toggle='$dataToggle'>".$rowNavLinks[9]." $dropdownCaret</a>";
				echo "<ul class='$dropdownMenu'>";
				while ($rowNavCatLinks = mysqli_fetch_array($sqlNavCatLinks)) {
					echo "<li>";
					echo "<a href='".$rowNavCatLinks[3]."' $navWin>".$rowNavCatLinks[2]."</a>";
					echo "</li>";
				}
				echo "</ul>";
				echo "</li>";
			}

		} else {
			echo "<li>";
			echo "<a href='".$rowNavLinks[3]."' $navWin>".$rowNavLinks[2]."</a>";
			echo "</li>";
		}

		$tempLink = $rowNavLinks[4];

	}
	echo "</ul>";
}

function getSetup() {
	global $setupTitle;
	global $setupAuthor;
	global $setupKeywords;
	global $setupDescription;
    global $setupConfig;
    global $setupLs2pac;
    global $setupLs2kids;
	global $db_conn;

    $sqlSetup = mysqli_query($db_conn, "SELECT title, author, keywords, description, config, ls2pac, ls2kids, loc_id FROM setup WHERE loc_id=".$_GET['loc_id']." ");
    $rowSetup  = mysqli_fetch_array($sqlSetup);

    $setupDescription = $rowSetup['description'];
    $setupKeywords = $rowSetup['keywords'];
    $setupAuthor = $rowSetup['author'];
    $setupTitle = $rowSetup['title'];
    $setupConfig = $rowSetup['config'];
    $setupLs2pac = $rowSetup['ls2pac'];
    $setupLs2kids = $rowSetup['ls2kids'];
}

function getSocialMediaIcons($shape) {
    //EXAMPLE: getSocialMediaIcons("circle")
    //EXAMPLE: getSocialMediaIcons("square")
	global $socialMediaIcons;
	global $socialMediaHeading;
	global $sqlSocialMedia;
	global $rowSocialMedia;
	global $db_conn;

	$sqlSocialMedia = mysqli_query($db_conn, "SELECT * FROM socialmedia WHERE loc_id=".$_GET['loc_id']." ");
	$rowSocialMedia = mysqli_fetch_array($sqlSocialMedia);

	$socialMediaIcons = "";

	if (!empty($rowSocialMedia['heading'])) {
		$socialMediaHeading = $rowSocialMedia['heading'];
	}

    if (!empty($rowSocialMedia['facebook'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['facebook']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-facebook fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    if (!empty($rowSocialMedia['google'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['google']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-google-plus fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    if (!empty($rowSocialMedia['pinterest'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['pinterest']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-pinterest fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    if (!empty($rowSocialMedia['twitter'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['twitter']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-twitter fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    if (!empty($rowSocialMedia['instagram'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['instagram']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-instagram fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    if (!empty($rowSocialMedia['youtube'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['youtube']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-youtube fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    if (!empty($rowSocialMedia['tumblr'])) {
        $socialMediaIcons = $socialMediaIcons . "<li><a href=".$rowSocialMedia['tumblr']." target='_blank'><span class='fa-stack fa-lg'><i class='fa fa-$shape fa-stack-2x'></i><i class='fa fa-tumblr fa-stack-1x fa-inverse'></i></span></a></li>";
    }

    //$socialMediaIcons = "<ul class='list-unstyled list-inline list-social-icons'>".$socialMediaIcons."</ul>";
}

function getCustomers() {
	global $sqlCustomerHeading;
	global $rowCustomerHeading;
	global $sqlCustomers;
	global $customerHeading;
	global $customerBlurb;
	global $customerNumRows;
	global $customerColWidth;
	global $db_conn;

    $sqlCustomerHeading = mysqli_query($db_conn, "SELECT customersheading, customerscontent FROM setup WHERE loc_id=".$_GET['loc_id']." ");
    $rowCustomerHeading = mysqli_fetch_array($sqlCustomerHeading);

	if (!empty($rowCustomerHeading['customersheading'])) {
	    $customerHeading = $rowCustomerHeading['customersheading'];
	}

    if (!empty($rowCustomerHeading['customerscontent'])) {
        $customerBlurb = $rowCustomerHeading['customerscontent'];
    }

    $sqlCustomers = mysqli_query($db_conn, "SELECT image, name, link, active, loc_id FROM customers WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY datetime DESC"); //While loop
    $customerNumRows = mysqli_num_rows($sqlCustomers);

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

function getDatabases() {
    global $sqlDatabasesHeading;
    global $rowDatabasesHeading;
    global $sqlDatabases;
    global $databasesHeading;
    global $databasesBlurb;
    global $databasesNumRows;
    global $databasesColWidth;
    global $db_conn;

    $sqlDatabasesHeading = mysqli_query($db_conn, "SELECT databasesheading, databasescontent FROM setup WHERE loc_id=".$_GET['loc_id']." ");
    $rowDatabasesHeading = mysqli_fetch_array($sqlDatabasesHeading);

    if (!empty($rowDatabasesHeading['databasesheading'])) {
        $databasesHeading = $rowDatabasesHeading['databasesheading'];
    }

    if (!empty($rowDatabasesHeading['databasescontent'])) {
        $databasesBlurb = $rowDatabasesHeading['databasescontent'];
    }

    $sqlDatabases = mysqli_query($db_conn, "SELECT image, name, link, active, loc_id FROM databases WHERE active='true' AND loc_id=".$_GET['loc_id']." ORDER BY datetime DESC"); //While loop
    $databasesNumRows = mysqli_num_rows($sqlDatabases);

    if ($databasesNumRows==2) {
        $databasesColWidth=6;
    } elseif ($databasesNumRows==3) {
        $databasesColWidth=4;
    } elseif ($databasesNumRows==4) {
        $databasesColWidth=3;
    } else {
        $databasesColWidth=2;
    }
}

function getSlider($sliderType) {
    //EXAMPLE: getSlider("slide")
    //EXAMPLE: getSlider("random")
    global $sliderLink;
    global $sliderTitle;
    global $sliderContent;
    global $sliderImage;
	global $db_conn;

	if ($sliderType=="slide") {
		$sliderOrderBy = "ORDER BY datetime DESC";
	} else if ($sliderType=="random" OR $sliderType=="") {
		$sliderOrderBy = "ORDER BY RAND() LIMIT 1";
	}

    $sqlSlider = mysqli_query($db_conn, "SELECT id, title, image, link, content, active, loc_id FROM slider WHERE active='true' AND loc_id=".$_GET['loc_id']." $sliderOrderBy");
    $sliderNumRows = mysqli_num_rows($sqlSlider);
    $sliderCount=0;

    //hide carousel arrows if only one image is available
    if ($sliderNumRows == 1) {
        echo "<style>.carousel-control {display: none !important;}</style>";
    }

    if ($sliderNumRows > 0) {

        if ($sliderType=="slide") {
            echo "<header id='myCarousel' class='carousel slide'>";
            //Wrapper for slides
            echo "<div class='carousel-inner'>";
            while ($rowSlider = mysqli_fetch_array($sqlSlider)) {
                $sliderCount++;

                if ($sliderCount==1) {
                    $slideActive = "active";
                } else {
                    $slideActive = "";
                }

                echo "<div class='item $slideActive'>";

                if (!empty($rowSlider['image'])) {
                    echo "<div class='fill' style='background-image:url(uploads/".$_GET['loc_id']."/".$rowSlider['image'].");'></div>";
                } else {
                    echo "<div class='fill'></div>";
                }

                echo "<div class='carousel-caption'>";

                echo "<h2>".$rowSlider['title']."</h2>";
                echo "<p>".$rowSlider['content']."</p>";

                if (!empty($rowSlider['link'])) {
					if (ctype_digit($rowSlider['link'])) {
						echo "<a href='page.php?page_id=".$rowSlider['link']."&loc_id=".$_GET['loc_id']."' class='btn btn-primary'>Learn More</a>";
					} else {
						echo "<a href='".$rowSlider['link']."' class='btn btn-primary'>Learn More</a>";
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

        } else if ($sliderType=="random") {
        	$rowSlider = mysqli_fetch_array($sqlSlider);
            echo "<header id='myCarousel' class='carousel slide'>";

            echo "<div class='carousel-inner'>";

            echo "<div class='item active'>";

        	if (!empty($rowSlider['image'])) {
                echo "<div class='fill' style='background-image:url(uploads/".$_GET['loc_id']."/".$rowSlider['image'].");'></div>";
            } else {
                echo "<div class='fill'></div>";
            }

            echo "<div class='carousel-caption'>";

            echo "<h2>".$rowSlider['title']."</h2>";
            echo "<p>".$rowSlider['content']."</p>";

			if (!empty($rowSlider['link'])) {
				if (ctype_digit($rowSlider['link'])) {
					echo "<a href='page.php?page_id=".$rowSlider['link']."&loc_id=".$_GET['loc_id']."' class='btn btn-primary'>Learn More</a>";
				} else {
					echo "<a href='".$rowSlider['link']."' class='btn btn-primary'>Learn More</a>";
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

function getGeneralInfo() {
	global $generalInfoContent;
	global $generalInfoHeading;
	global $db_conn;

	$sqlGeneralinfo = mysqli_query($db_conn, "SELECT heading, content FROM generalinfo WHERE loc_id=".$_GET['loc_id']." ");
	$rowGeneralinfo = mysqli_fetch_array($sqlGeneralinfo);

	if (!empty($rowGeneralinfo['content'])) {
		$generalInfoContent = $rowGeneralinfo['content'];
	}

	if (!empty($rowGeneralinfo['heading'])) {
		$generalInfoHeading = $rowGeneralinfo['heading'];
	}
}

function getFeatured() {
	global $featuredContent;
	global $featuredHeading;
	global $featuredBlurb;
	global $featuredImage;
	global $featuredImageAlign;
	global $db_conn;

	$sqlFeatured = mysqli_query($db_conn, "SELECT heading, introtext, content, image, image_align FROM featured WHERE loc_id=".$_GET['loc_id']." ");
	$rowFeatured = mysqli_fetch_array($sqlFeatured);

	if (!empty($rowFeatured['heading'])) {
        $featuredHeading = $rowFeatured['heading'];
    }

    if (!empty($rowFeatured['introtext'])) {
		$featuredBlurb = $rowFeatured['introtext'];
	}

	if (!empty($rowFeatured['content'])) {
		$featuredContent = $rowFeatured['content'];
	}

	if (!empty($rowFeatured['image'])) {
		$featuredImage = "<img class='img-responsive' src='uploads/".$_GET['loc_id']."/".$rowFeatured['image']."' alt='".$rowFeatured['image']."' title='".$rowFeatured['image']."'>";
	}

	$featuredImageAlign = $rowFeatured['image_align'];
}

//Call - getSetup is used everywhere
getSetup();

//Call these functions depending on which page you are visiting
//Sets the page title
if (is_numeric($_GET['page_id'])>"") {
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

//redirect to default location if loc_id not defined
if (empty($_GET['loc_id'])) {
    header('Location: ?loc_id=1');
}
?>