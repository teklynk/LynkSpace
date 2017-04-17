<!-- General Info Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getGeneralInfo();

if (!empty($generalInfoContent)) {
    echo "<div class='container' id='generalinfo'>";

    if (!empty($generalInfoHeading)) {
        echo "<div class='row'>";
        echo "<div class='col-lg-12'>";
        echo "<h2 class='generalinfo'>" . $generalInfoHeading . "</h2>";
        echo "</div>";
        echo "</div>";
    }

    if (!empty($generalInfoContent)) {
        echo "<div class='row'>";
        echo "<div class='col-lg-12'>";
        echo $generalInfoContent;
        echo "</div>";
        echo "</div>";
    }

    echo "</div>"; //container
}
?>