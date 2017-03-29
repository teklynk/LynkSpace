<!-- Hot titles request -->
<?php
define('inc_access', TRUE);

if (!empty($_GET['rssurl'])) {

    require_once('../functions.php');

    $bootstrap_CSS = file_get_contents('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css');
    $hottitles_CSS = file_get_contents('../css/core-hottitles.min.css');
    $jquery_JS = file_get_contents('//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js');
    $bootstrap_JS = file_get_contents('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js');
    $core_JS = file_get_contents('../js/functions.min.js');

    echo "<style type='text/css'>";
        echo $bootstrap_CSS;
        echo $hottitles_CSS;
    echo "</style>";

    echo "<script type='text/javascript'>";
        echo $jquery_JS;
        echo $bootstrap_JS;
        echo $core_JS;
    echo "</script>";

    $rssUrl = $_GET['rssurl'];
    //example: getHottitlesCarousel("http://beacon.tlcdelivers.com:8080/list/dynamic/1921419/rss", 30);
    getHottitlesCarousel($rssUrl, 50);

} else {

    die('Direct access not permitted');

}
?>
