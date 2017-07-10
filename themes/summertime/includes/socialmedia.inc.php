<!-- Social Media Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getSocialMediaIcons("square", "top");
//EXAMPLE: getSocialMediaIcons("circle","top")
//EXAMPLE: getSocialMediaIcons("square","footer")
if (!empty($socialMediaIcons)) {
    echo $socialMediaIcons;
}
?>