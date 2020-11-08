<?php
if ( ! defined( 'ALLOW_INC' ) ) {
    die( 'Direct access not permitted' );
}

getPage( loc_id );

if ( is_array($pageArray) && count($pageArray) > 0 ) {

    echo "<a name='pages' tabindex='-1'></a>";

    echo "<div class='container-fluid services'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='row' id='pages'>";

    if (isset($_GET['keywords'])) {
        echo "<div class='col-12 keyword_results_title'><h5><b>Showing results for:</b> '" . trim($_GET['keywords']) . "'</h5></div>";
    }

    foreach($pageArray as $pageData) {

        $pageDate = date("F jS, Y", strtotime($pageData['created']));

        echo "<div class='col-sm-12 col-md-6 col-lg-4 page-item'>";
        echo "<div class='panel panel-default text-center'>";

        echo "<div class='panel-body'>";

        if ( ! empty( $pageData['title'] ) ) {
            echo "<h1 class='page_title'>" . $pageData['title'] . "</h1>";
        }

        if ( ! empty( $pageData['created'] ) ) {
            echo "<span class='page_created date small'><strong>" . $pageDate . "</strong></span>";
        }

        if ( ! empty( $pageData['image'] ) ) {
            echo "<div class='page_featured_image'><a href='page.php?page_id=" . $pageData['id'] . "&loc_id=" . $pageData['loc_id'] . "'><img src='" . $pageData['image'] . "' border='0'/></a></div>";
        }

        if ( ! empty( $pageData['sub_heading'] ) ) {
            echo "<div class='page_sub_heading'><p>" . $pageData['sub_heading'] . "</p></div>";
        }

        if ( ! empty( $pageData['id'] ) ) {
            echo "<div class='page_read_more_btn'><a href='page.php?page_id=" . $pageData['id'] . "&loc_id=" . $pageData['loc_id'] . "' class='btn btn-primary'>Read More</a></div>";
        }

        echo "</div>";

        echo "</div>";
        echo "</div>";
    }

    echo "</div>";

    echo "</div>";
    echo "</div>";

} else {

    echo "";

}
?>