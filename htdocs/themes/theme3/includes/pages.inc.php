<?php
if (!defined('ALLOW_INC')) {
    die('Direct access not permitted');
}

if (isset($_GET['pg_num'])) {
    $pageNum = $_GET['pg_num'];
} else {
    $pageNum = 1;
}

$pageLimit = 4;

$start_from = ($pageNum - 1) * $pageLimit;

getPage(loc_id, $start_from, $pageLimit);

$total_pages = ceil($pageTotal / $pageLimit);

$pgCount = 0;

if (is_array($pageArray) && count($pageArray) > 0) {

    echo "<a name='pages' tabindex='-1'></a>";

    echo "<div class='container-fluid pages'>";
    echo "<div class='container bannerwrapper'>";

    if (!empty($pageHeading)) {
        echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
        echo "<h1 class='text-left servicesheading'>" . $pageHeading . "</h1>";
        echo "</div>";
    }

    echo "<div class='row' id='pages'>";

    if (isset($_GET['keywords']) && !empty($_GET['keywords'])) {
        echo "<div class='col-12 keyword_results_title'><h5><b>Showing results for:</b> '" . trim($_GET['keywords']) . "'</h5></div>";
    }

    foreach ($pageArray as $pageData) {

        $pageDate = date("F jS, Y", strtotime($pageData['created']));
        $pgCount++;

        echo "<div class='col-sm-12 col-md-6 col-lg-6 page-item'>";
        echo "<div class='panel panel-default text-center'>";

        echo "<div class='panel-body'>";

        if (!empty($pageData['title'])) {
            echo "<h2 class='page_title'>" . $pageData['title'] . "</h2>";
        }

        if (!empty($pageData['created'])) {
            echo "<span class='page_created date small'><i class='fa fa-calendar' aria-hidden='true'></i>&nbsp;<strong>" . $pageDate . "</strong></span>";
        }

        if (!empty($pageData['image'])) {
            echo "<div class='page_featured_image'><a href='page.php?page_id=" . $pageData['id'] . "&loc_id=" . $pageData['loc_id'] . "'><img src='" . $pageData['image'] . "' border='0'/></a></div>";
        }

        if (!empty($pageData['sub_heading'])) {
            echo "<div class='page_sub_heading'><p>" . $pageData['sub_heading'] . "</p></div>";
        }

        if (!empty($pageData['id'])) {
            echo "<div class='page_read_more_btn'><a href='page.php?page_id=" . $pageData['id'] . "&loc_id=" . $pageData['loc_id'] . "' class='btn btn-primary'>Read More</a></div>";
        }

        echo "</div>";

        echo "</div>";
        echo "</div>";

        if ($pgCount % 2 == 0) {
            echo "<div class='clearfix'></div>";
        }

    }

    //pagination stuff
    echo "<div class='clearfix'></div>";

    $pagLink = "<ul class='pagination'>";

    for ($i = 1; $i <= $total_pages; $i++) {

        if ($pageNum == $i) {
            $pageActive = 'active';
        } else {
            $pageActive = '';
        }

        $pagLink .= "<li class='page-item " . $pageActive . "'><a class='page-link' href='index.php?loc_id=" . $pageData['loc_id'] . "&keywords=" . $_GET['keywords']. "&pg_num=" . $i . "'>" . $i . "</a></li>";
    }

    echo $pagLink . "</ul>";

    echo "</div>";

    echo "</div>";
    echo "</div>";

} else {

    echo "";

}
?>