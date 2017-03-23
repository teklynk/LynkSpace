<!-- General Info Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getGeneralInfo();

if (!empty($generalInfoContent)) {
    echo "<div class='container' id='generalinfo'>";

    if (!empty($generalInfoHeading)) {
        echo "<div class='row>";
        echo "<h3 class='generalinfo'>" . $generalInfoHeading . "</h3>";
        echo "</div>";
    }

    echo "<div class='col-lg-12 text-center'>";
    echo $generalInfoContent;
    echo "</div>";

    echo "</div>"; //container
}
?>