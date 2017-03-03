<!-- Team Section -->
<a name="team" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

//only display the box if team members exist
if ($teamNumRows > 0) {

    echo "<div class='row' id='team'>";
    echo "<div class='box'>";

    echo "<div class='col-lg-12'>";

    if (!empty($teamHeading)) {
        echo "<hr>";
        echo "<h2 class='intro-text text-center'>" . $teamHeading . "</h2>";
        echo "<hr>";
    }

    echo "</div>"; //col-lg-12

    if (!empty($teamBlurb)) {
        echo "<div class='col-md-6'>";
        echo "<p>" . $teamBlurb . "</p>";
        echo "</div>";
        //echo "<div class='clearfix'></div>";
    }

    echo "</div>"; //box
    echo "</div>"; //row

    echo "<div class='row'>";
    echo "<div class='box'>";

    while ($rowTeam = mysqli_fetch_array($sqlTeam)) {
        echo "<div class='col-sm-4 text-center'>";

        if (!empty($rowTeam['image'])) {
            echo "<img class='img-responsive' src='uploads/" . $_GET['loc_id'] . "/" . $rowTeam['image'] . "' alt='" . $rowTeam['name'] . "' title='" . $rowTeam['name'] . "'>";
        }

        echo "<h3>";

        if (!empty($rowTeam['name'])) {
            echo $rowTeam['name'] . "<br>";
        }

        if (!empty($rowTeam['title'])) {
            echo "<small>" . $rowTeam['title'] . "</small>";
        }

        echo "</h3>";

        if (!empty($rowTeam['content'])) {
            echo "<p>" . $rowTeam['content'] . "</p>";
        }

        echo "</div>";
    }

    echo "</div>"; //box
    echo "</div>"; //row
}
?>