<!-- General Info Section -->
<a name="generalinfo" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getGeneralInfo();

if (!empty($generalInfoContent)) {
    echo "<div class='row' id='generalinfo'>";

    if (!empty($generalInfoHeading)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h3 class='generalinfoheading'>" . $generalInfoHeading . "</h3>";
        echo "</div>";
    }

    echo "<div class='col-xs-12 col-md-12'>";
    echo $generalInfoContent;
    echo "</div>";

    echo "</div>";
}
?>