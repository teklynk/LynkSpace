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
            echo "<div class='col-lg-12'>";
            echo "<h2 class='page-header generalinfo'>".$generalInfoHeading."</h2>";
            echo "</div>";
        }

        echo "<div class='col-md-12 geninfo-content'>";
        echo $generalInfoContent;
        echo "</div>";

    echo "</div>";
}
?>