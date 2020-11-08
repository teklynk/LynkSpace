<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}

getGeneralInfo( loc_id );

if ($generalInfoActive) {
    if (!empty($generalInfoContent)) {
        echo "<a name='generalinfo' tabindex='-1'></a>";
        echo "<div class='container-fluid page-container row' id='generalinfo'>";

        if (!empty($generalInfoHeading)) {
            echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            echo "<h3 class='generalinfoheading'>" . $generalInfoHeading . "</h3>";
            echo "</div>";
        }

        echo "<div class='col-xs-12 col-md-12'>";
        echo $generalInfoContent;
        echo "</div>";

        echo "</div>";
    }
} else {
    echo "";
}
?>