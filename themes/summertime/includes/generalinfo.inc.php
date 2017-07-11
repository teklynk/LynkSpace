<!-- General Info Section -->
<a name="generalinfo" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getGeneralInfo();

if (!empty($generalInfoContent)) {

    if (!empty($generalInfoHeading)) {
        echo "<div>";
        echo "<h3 class='generalinfoheading'>" . $generalInfoHeading . "</h3>";
        echo "</div>";
    }

    echo "<div>";
    echo $generalInfoContent;
    echo "</div>";
}
?>