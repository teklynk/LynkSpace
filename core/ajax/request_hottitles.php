<!-- Hot titles request -->
<?php
define('inc_access', TRUE);

if (!empty($_GET['rssurl'])) {

    require_once('../functions.php');

    $hottitles_CSS = file_get_contents('../css/core-hottitles.min.css');
    $core_JS = file_get_contents('../js/functions.min.js');

    echo "<style type='text/css'>";
    //echo $hottitles_CSS;
    echo "</style>";

    echo "<script type='text/javascript'>";
    echo $core_JS;
    echo "</script>";

    $rssUrl = $_GET['rssurl'];
    //example: getHottitlesCarousel("http://beacon.tlcdelivers.com:8080/list/dynamic/1921419/rss", 30);
    getHottitlesCarousel($rssUrl, 40);

} else {

    die('Direct access not permitted');

}
?>

