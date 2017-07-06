<!-- About Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

echo "<a name='about'></a>";

echo "<div class='page-container container-fluid about'>";
echo "<div class='container bannerwrapper'>";

echo "<div class='row'>";

if (!empty($aboutTitle)) {
    echo "<div class='col-lg-12'>";
    echo "<h1 class='about'>" . $aboutTitle . "</h1>";
    echo "</div>";
}

if (!empty($aboutContent)) {
    echo "<div class='col-xs-12 col-md-12 about-content'>";
    echo $aboutContent;
    echo "</div>";
}

echo "</div>";

echo "</div>";
echo "</div>";

?>