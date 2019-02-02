<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}
?>
    <!-- Social Media Section -->
<?php

getSocialMediaIcons( loc_id, "circle", "footer" );
//EXAMPLE: getSocialMediaIcons("circle","top")
//EXAMPLE: getSocialMediaIcons("square","footer")
if ( ! empty( $socialMediaIcons ) ) {
	echo $socialMediaIcons;
}
?>