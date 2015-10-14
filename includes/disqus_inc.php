<?php
	getSetup();

	if ($setupDisqus>"") {
		echo "<div class='row'></div>";
		echo "<div class='col-lg-12  disqus_box'>".$setupDisqus."</div>";
	}
?>