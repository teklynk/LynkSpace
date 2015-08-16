<!-- Header Carousel -->
<?php
    $sqlSlider = mysql_query("SELECT id, title, image, link, content, active FROM slider WHERE active=1 ORDER BY datetime DESC"); //While loop
    $num_rows = mysql_num_rows($sqlSlider);
    $slideCount=0;

    if ($num_rows > 0) {
        echo "<header id='myCarousel' class='carousel slide'>";
        //Wrapper for slides -->
        echo "<div class='carousel-inner'>";
        while ($rowSlider  = mysql_fetch_array($sqlSlider)) {
            $slideCount++;

            if ($slideCount==1) {
                $slideActive = "active";
            } else {
                $slideActive = "";
            }

            echo "<div class='item $slideActive'>";

            if ($rowSlider["image"] != "") {
                echo "<div class='fill' style='background-image:url(uploads/".$rowSlider['image'].");'></div>";
            } else {
                echo "<div class='fill'></div>";
            }

            echo "<div class='carousel-caption'>";
            echo "<h2>".$rowSlider["title"]."</h2>";
            echo "<p>".$rowSlider["content"]."</p>";
            if (!empty($rowSlider['link'])){
                echo "<a href='page.php?ref=".$rowSlider['link']."' class='btn btn-primary'>Learn More</a>";
            }
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";

        //Controls -->
        echo "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>";
        echo "<span class='icon-prev'></span>";
        echo "</a>";
        echo "<a class='right carousel-control' href='#myCarousel' data-slide='next'>";
        echo "<span class='icon-next'></span>";
        echo "</a>";
        echo "</header>";
    }
?>