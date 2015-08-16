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

		if ($rowPage === FALSE){ 
		    die(mysql_error()); // TODO: better error handling
		}

		if ($rowPage['active']=1 AND $_GET["ref"]>"" AND $pageRefId=$rowPage['id']) {
			if ($rowPage["image"]>"") {
				$pageImage = "<img class='img-responsive' src='uploads/".$rowPage["image"]."' alt='".$rowPage["title"]."' title='".$rowPage["title"]."'>";
			} else {
				$pageImage = "";
			}
			$pageTitle = $rowPage['title'];
			$pageContent = $rowPage["content"];
			$pageImageAlign = $rowPage["image_align"];
		} else {
		    echo "<div class='col-lg-12'>";
		    echo "<h2 class='page-header'>Page not found</h2>";
		    echo "</div>";

		    echo "<div class='col-lg-12'>";
		    echo "<p>This page has been removed.</p>";
		    echo "</div>";
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

	if ($rowAbout === FALSE){ 
	    die(mysql_error()); // TODO: better error handling
	}

	if (!empty($rowAbout["heading"])){
		$aboutTitle = $rowAbout["heading"];
	}

	if (!empty($rowAbout["content"])) {
		$aboutContent = $rowAbout["content"];
	}

	if (!empty($rowAbout["image"])) {
		$aboutImage = "<img class='img-responsive' src='uploads/".$rowAbout["image"]."' alt='".$rowAbout["image"]."' title='".$rowAbout["image"]."'>";
	} else {
		$aboutImage = "";
	}

	$aboutImageAlign = $rowAbout["image_align"];
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

    $sqlServicesHeading = mysql_query("SELECT servicesheading, servicescontent FROM setup");
    $rowServicesHeading = mysql_fetch_array($sqlServicesHeading);

    $servicesHeading = $rowServicesHeading['servicesheading'];

    if (!empty($rowServicesHeading['servicescontent'])) {
    	$servicesBlurb= $rowServicesHeading['servicescontent'];
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
    }

    //TODO: Build arrays for each object
}

function getNav($navSection,$dropdown,$pull){
	//EXAMPLE: getNav('Top','true','right');
    echo "<ul class='nav navbar-nav navbar-$pull'>";
		if ($dropdown == "true"){
			$dropdownToggle = "class='dropdown-toggle'";
			$dataToggle = "data-toggle='dropdown'";
			$dropdown = "class='dropdown nav-$navSection'";
			$dropdownMenu = "class='dropdown-menu'";
			$dropdownCaret = "<b class='caret'></b>";
		} else {
			$dropdownToggle = "";
			$dataToggle = "";
			$dropdown = "class='nav-$navSection'";
			$dropdownMenu = "";
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
			
                    echo "<li $dropdown>";
						echo "<a href='#' $dropdownToggle $dataToggle>".$rowNavLinks[8]." $dropdownCaret</a>";
						echo "<ul $dropdownMenu>";
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

?>