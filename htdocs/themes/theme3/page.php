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
        $keywords .= "<span class='keyword_link'><a href='index.php?loc_id=" . loc_id . "&keywords=" . $keyword . "' class='link'>" . $keyword . "</a></span>";
    }
}

if (is_array($pageArray) && array_count_values($pageArray) > 0) {

    echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
    echo "<div class='container bannerwrapper'>";

    echo "</div>";
    echo "</div>";

    echo "<div class='container'>";
    echo "<div class='row row_pad content' id='page'>";

    echo "<div class='col-sm-12 col-md-12 col-lg-12 '>";

    require_once(__DIR__ . '/includes/searchsite.inc.php');

    if ( ! empty( $pageTitle ) ) {
        echo "<h2 class='page_title'>" . $pageTitle . "</h2>";

        if ($pageDate) {
            echo "<span class='date small'><i class='fa fa-calendar' aria-hidden='true'></i>&nbsp;" . $pageDate . "</span>";
        } else {
            echo "<p><br /></p>";
        }
        if ($pageAuthor) {
            echo "<span class='author small'><i class='fa fa-user' aria-hidden='true'></i>&nbsp;" . $pageAuthor . "</span>";
        } else {
            echo "<p><br /></p>";
        }
        if ($keywords) {
            echo "<span class='keywords small'><i class='fa fa-tags' aria-hidden='true'></i>&nbsp;" . rtrim($keywords, ',') . "</span>";
        } else {
            echo "<p><br /></p>";
        }

    }

    echo "</div>";

    echo "<div class='col-sm-12 col-md-12 col-lg-12 page-content'>";

    if (!empty($pageImage && $pageFeaturedImageActive == 'true')) {
        echo "<img src='" . $pageImage . "' border='0' class='float-left img-thumbnail w-50 mr-12 mb-8' alt=''>" . $pageContent;
    } else {
        echo $pageContent;
    }

    echo "</div>";

    echo "<div class='disqus-box'>" . getDisqusCode('http://' . $serverHostname, $_SESSION['unique_referrer']) . "</div>";

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
    <div class='row'><div class='col-sm-12 col-md-12 col-lg-12 page-content'>";

    require_once(__DIR__ . '/includes/pagenotfound.inc.php');

    echo "</div></div>
    </div>
    </div>";
}

require_once(__DIR__ . '/includes/footer.inc.php');
?>