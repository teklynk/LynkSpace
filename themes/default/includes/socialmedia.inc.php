<!-- Social Media Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getSocialMediaIcons($_GET['loc_id'], "square", "top");
//EXAMPLE: getSocialMediaIcons("circle","top")
//EXAMPLE: getSocialMediaIcons("square","footer")
if (!empty($socialMediaIcons)) {
    echo $socialMediaIcons;
}
?>