<!-- Team Members -->
<?php
	getTeam();

    if ($teamNumRows > 0) {
		echo "<div class='row'>";
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header team' id='team'>".$teamHeading."</h2>";
			echo "</div>";

	        if (!empty($teamContent)) {
	            echo "<div class='col-lg-12'>";
	            echo "<p class='text-center'>".$teamBlurb."</p>";
	            echo "</div>";
	        }

		    while ($rowTeam = mysql_fetch_array($sqlTeam)){
				echo "<div class='col-md-".$teamColWidth." text-center'>";
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