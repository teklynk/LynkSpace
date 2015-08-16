<?php
$sqlSocialMedia = mysql_query("SELECT * FROM socialmedia");
$rowSocialMedia = mysql_fetch_array($sqlSocialMedia);
if (!empty($rowSocialMedia["facebook"])) {
    echo "<div class='row'>";

    if (!empty($rowSocialMedia["heading"])){
        echo "<div class='col-lg-12'>";
        echo "<h2 class='page-header socialmedia'>".$rowSocialMedia["heading"]."</h2>";
        echo "</div>";
    }
    
    echo "<div class='col-md-12'>";
    echo "<ul class='list-unstyled list-inline list-social-icons'>";
                                    
        if (!empty($rowSocialMedia["facebook"])){
            echo "<li><a href=".$rowSocialMedia["facebook"]."><i class='fa fa-facebook-square fa-2x'></i></a></li>";
        }

        if (!empty($rowSocialMedia["google"])){
            echo "<li><a href=".$rowSocialMedia["google"]."><i class='fa fa-google-plus-square fa-2x'></i></a></li>";
        }

        if (!empty($rowSocialMedia["github"])){
            echo "<li><a href=".$rowSocialMedia["github"]."><i class='fa fa-github-square fa-2x'></i></a></li>";
        }

        if (!empty($rowSocialMedia["twitter"])){
            echo "<li><a href=".$rowSocialMedia["twitter"]."><i class='fa fa-twitter-square fa-2x'></i></a></li>";
        }

        if (!empty($rowSocialMedia["linkedin"])){
            echo "<li><a href=".$rowSocialMedia["linkedin"]."><i class='fa fa-linkedin-square fa-2x'></i></a></li>";
        }

    echo "</ul>";
    echo "</div>";

    echo "</div>";
}
?>