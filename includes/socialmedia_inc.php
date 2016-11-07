<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

    getSocialMediaIcons("circle");
    //EXAMPLE: getSocialMediaIcons("circle")
    //EXAMPLE: getSocialMediaIcons("square")
    if (!empty($socialMediaIcons)) {
        echo "<div class='row' id='socialmedia'>";

		if (!empty($socialMediaHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header socialmedia'>".$socialMediaHeading."</h2>";
			echo "</div>";
		}
        
        echo "<div class='col-md-12'>";
        echo "<ul class='list-unstyled list-inline list-social-icons'>";

        echo $socialMediaIcons;

        echo "</ul>";
        echo "</div>";

        echo "</div>";
    }
?>