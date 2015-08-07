<!-- Team Members -->
<?php
    $sqlTeamHeading = mysql_query("SELECT teamheading, teamcontent FROM setup");
    $rowTeamHeading = mysql_fetch_array($sqlTeamHeading);

    $sqlTeam = mysql_query("SELECT id, image, title, name, content, active FROM team WHERE active=1 ORDER BY datetime DESC"); //While loop
    $num_rows = mysql_num_rows($sqlTeam);
    $teamCount=0;

    if ($num_rows==2) {
    	$colWidth=6;
    } elseif ($num_rows==3) {
    	$colWidth=4;
    } elseif ($num_rows==4) {
    	$colWidth=3;
    }

    if ($num_rows > 0) {
		echo "<div class='row'>";
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header team' id='team'>".$rowTeamHeading['teamheading']."</h2>";
			echo "</div>";

	        if (!empty($rowTeamHeading['teamcontent'])) {
	            echo "<div class='col-lg-12'>";
	            echo "<p class='text-center'>".$rowTeamHeading['teamcontent']."</p>";
	            echo "</div>";
	        }

		    while ($rowTeam = mysql_fetch_array($sqlTeam)){
			    $teamCount++;
				echo "<div class='col-md-".$colWidth." text-center'>";
				echo "<div class='thumbnail'>";

				if (!empty($rowTeam['image'])){
					echo "<img class='img-responsive' src='uploads/".$rowTeam['image']."' alt='".$rowTeam['name']."' title='".$rowTeam['name']."'>";
				}
				
				echo "<div class='caption'>";

				echo "<h3>";

				if (!empty($rowTeam['name'])){
					echo $rowTeam['name']."<br>";
				}

				if (!empty($rowTeam['title'])){
					echo "<small>".$rowTeam['title']."</small>";
				}

				echo "</h3>";

				if (!empty($rowTeam['content'])){
					echo "<p>".$rowTeam['content']."</p>";
				}

				//echo "<ul class='list-inline'>";
				//echo "<li><a href='#'><i class='fa fa-2x fa-facebook-square'></i></a>";
				//echo "</li>";
				//echo "<li><a href='#'><i class='fa fa-2x fa-linkedin-square'></i></a>";
				//echo "</li>";
				//echo "<li><a href='#'><i class='fa fa-2x fa-twitter-square'></i></a>";
				//echo "</li>";
				//echo "</ul>";

				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
		echo "</div>";
	}
?>
<!-- /.row -->