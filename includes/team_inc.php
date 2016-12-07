<!-- Team Members -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

getTeam();

    if ($teamNumRows > 0) {

		echo "<div class='row' id='team'>";
		
		if (!empty($teamHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h1 class='team'>".$teamHeading."</h1>";
			echo "</div>";
		}

        if (!empty($teamBlurb)) {
            echo "<div class='col-lg-12'>";
            echo "<h3>".$teamBlurb."</h3>";
            echo "</div>";
        }

	    while ($rowTeam = mysqli_fetch_array($sqlTeam)){
			echo "<div class='col-md-".$teamColWidth." text-center'>";
			echo "<div class='thumbnail'>";

			if (!empty($rowTeam['image'])){
				echo "<img class='img-responsive' src='uploads/".$_GET['loc_id']."/".$rowTeam['image']."' alt='".$rowTeam['name']."' title='".$rowTeam['name']."'>";
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

			echo "</div>";
			echo "</div>";
			echo "</div>";
		}

		echo "</div>";
	}
?>
<!-- /.row -->