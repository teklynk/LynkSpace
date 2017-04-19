<!-- About Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
echo "<div class='container-fluid about'>";
echo "<div class='container bannerwrapper'>";

echo "<div class='row'>";

if (!empty($aboutTitle)) {
    echo "<div class='col-lg-12'>";
    echo "<h1 class='about'>" . $aboutTitle . "</h1>";
    echo "</div>";
}

if (!empty($aboutImage)) {

    if ($aboutImageAlign == "right") {
        echo "<div class='col-xs-12 col-md-10'>";
        echo $aboutContent;
        echo "</div>";
        echo "<div class='col-md-2 hidden-xs'>";
        echo $aboutImage;
        echo "</div>";
    } else {
        echo "<div class='col-md-2 hidden-xs'>";
        echo $aboutImage;
        echo "</div>";
        echo "<div class='col-xs-12 col-md-10'>";
        echo $aboutContent;
        echo "</div>";
    }

} else {
    echo "<div class='col-xs-12 col-md-12'>";
    echo $aboutContent;
    echo "</div>";
}

echo "</div>";

echo "</div>";
echo "</div>";

?>