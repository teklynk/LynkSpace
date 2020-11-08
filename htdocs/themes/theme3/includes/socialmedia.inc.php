<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}

getSocialMediaIcons( loc_id, "square", "top" );
//EXAMPLE: getSocialMediaIcons("circle","top")
//EXAMPLE: getSocialMediaIcons("square","footer")
if ( ! empty( $socialMediaIcons ) && $socialMediaActive) {
	echo $socialMediaIcons;
}
?>