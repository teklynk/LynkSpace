<?php
if (!defined('ALLOW_INC')) {
	die('Direct access not permitted');
}
?>
<!-- General Info Section -->
<a name="generalinfo" tabindex="-1"></a>
<?php

getGeneralInfo(loc_id);

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