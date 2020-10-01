<?php
if ( ! defined( 'ALLOW_INC' ) ) {
    die( 'Direct access not permitted' );
}
?>
    <!-- Pages Section -->
    <a name="pages" tabindex="-1"></a>
<?php

getPage( loc_id );

echo "<a name='pages'></a>";

if ( count($pageArray) > 0 ) {
    echo "<div class='container-fluid services'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='row' id='pages'>";

    foreach($pageArray as $pageData) {

        echo "<div class='col-sm-6 col-md-6 col-lg-6 page-item'>";
        echo "<div class='panel panel-default text-center'>";

        echo "<div class='panel-body'>";

        if ( ! empty( $pageData['image'] ) ) {
            echo "<a href='page.php?page_id=" . $pageData['id'] . "&loc_id=" . $pageData['loc_id'] . "'><img src='" . $pageData['image'] . "' border='0' class='img-responsive'/></a>";
        }

        if ( ! empty( $pageData['title'] ) ) {
            echo "<h1>" . $pageData['title'] . "</h1>";
        }

        if ( ! empty( $pageData['content'] ) ) {
            echo "<p>" . $pageData['content'] . "</p>";
        }

        if ( ! empty( $pageData['id'] ) ) {
            echo "<a href='page.php?page_id=" . $pageData['id'] . "&loc_id=" . $pageData['loc_id'] . "' class='btn btn-primary'>Read More</a>";
        }

        echo "</div>";

        echo "</div>";
        echo "</div>";
    }

    echo "</div>";

    echo "</div>";
    echo "</div>";

}
?>