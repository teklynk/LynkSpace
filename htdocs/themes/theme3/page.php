<?php
define('ALLOW_INC', true);

require_once(__DIR__ . '/includes/header.inc.php');

echo "<div class='page-page'>";

require_once(__DIR__ . '/includes/featured.inc.php');

//reformat the created date to human readable
$pageDate = date("F jS, Y", strtotime($pageCreated));

//define variables that only exist in this file
$pageKeywordsArray = array();
$keyword = '';
$keywords = '';

//split keywords into links
if (!empty($pageKeywords)) {
    $pageKeywordsArray = explode(',', $pageKeywords);

    foreach ($pageKeywordsArray as $keyword) {
        $keyword = trim($keyword);
        $keywords .= "<span class='keyword_link'><a href='index.php?loc_id=" . loc_id . "&keywords=" . $keyword . "'>" . $keyword . "</a></span>";
    }
}

if (is_array($pageArray) && count($pageArray) > 0) {

    echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
    echo "<div class='container bannerwrapper'>";

    echo "</div>";
    echo "</div>";

    echo "<div class='container'>";
    echo "<div class='row row_pad content' id='page'>";

    echo "<div class='col-lg-12'>";
    echo "<h1 class='page'>" . $pageTitle . "</h1>";
    echo "<span class='date small'><strong>" . $pageDate . "</strong></span>";
    echo "<span class='keywords small'><i class='fa fa-tags' aria-hidden='true'></i>&nbsp;<strong>" . rtrim($keywords, ',') . "</strong></span>";
    echo "</div>";

    echo "<div class='col-xs-12 col-lg-12 page-content'>";

    if (!empty($pageImage && $pageFeaturedImageActive == 'true')) {
        echo "<div class='col-md-4'><img src='" . $pageImage . "' border='0' class='img-responsive page-image'></div>";
        echo "<div class='col-md-8'>" . $pageContent . "</div>";
    } else {
        echo "<div class='col-md-12'>" . $pageContent . "</div>";
    }

    echo "</div>";

    echo "<div>" . getDisqusCode('http://' . $serverHostname, $_SESSION['unique_referrer']) . "</div>";

    echo "</div>";
    echo "</div>";

    echo "</div>";

} else {

    echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
    echo "<div class='container bannerwrapper'>";

    echo "</div>";
    echo "</div>";
    echo "<div class='container' id='pages'>
    <div class='content'>
    <div class='row row_pad'>";

        require_once(__DIR__ . '/includes/pagenotfound.inc.php');

    echo "</div>
    </div>
    </div>";
}

require_once(__DIR__ . '/includes/footer.inc.php');
?>