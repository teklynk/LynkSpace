<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

	getSetup();
	getPage();

	if (!empty($setupDisqus) AND $pageDisqus != 0) {
		echo "<div class='row'></div>";
		echo "<div class='col-lg-12  disqus_box'>".$setupDisqus."</div>";
	}
?>