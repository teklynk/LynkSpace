<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');
//Page Content container start -->
echo "<div class='container'>";

?>
    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <?php
                if ($_GET['loc_id'] == 1 && $multiBranch == "true") {
                    include 'includes/searchlocations.inc.php';
                } else {
                    include 'includes/searchpac.inc.php';
                }
                ?>
            </div>
        </div>
    </div>
<?php

echo "<div class='row'>";
echo "<div class='box'>";
echo "<div class='col-lg-12'>";
echo "<div class='calContainer loader panel-body'>";
echo "<div class='iframe hidden'>";
echo "<iframe class='hottitles-iframe embed-responsive-item' seamless src='themes/casual/includes/calendar.inc.php?loc_id=".$_GET['loc_id']."'></iframe>";
//echo "<iframe class='hottitles-iframe embed-responsive-item' seamless src='themes/casual/includes/hottitles.inc.php?loc_id=".$_GET['loc_id']."&rssurl=".$hottitlesUrl."'></iframe>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

include_once('includes/footer.inc.php');
?>