<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

	getSetup();
	getPage(); //needed to get page_id and check if disqus is active for that page.

	if (!empty($setupDisqus) AND $pageDisqus != 0) {
		echo "<div class='row'></div>";
		echo "<div class='col-lg-12 col-xs-12  disqus_box'>".$setupDisqus."</div>";
	}
?>