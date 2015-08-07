<!-- General Info Section -->
<?php
$sqlGeneralinfo = mysql_query("SELECT heading, content FROM generalinfo");
$rowGeneralinfo = mysql_fetch_array($sqlGeneralinfo);

if ($rowGeneralinfo === FALSE){ 
    die(mysql_error()); // TODO: better error handling
}

if (!empty($rowGeneralinfo["content"])) {
	echo "<div class='row'>";
	
	if (!empty($rowGeneralinfo["heading"])) {
		echo "<div class='col-lg-12'>";
		echo "<h2 class='page-header generalinfo' id='generalinfo'>".$rowGeneralinfo["heading"]."</h2>";
		echo "</div>";
	}

	echo "<div class='col-md-12'>";
	echo $rowGeneralinfo["content"];
	echo "</div>";

	echo "</div>";
}
?>