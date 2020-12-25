<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}

getSocialMediaIcons( loc_id, "square", "top", 1);
//EXAMPLE: getSocialMediaIcons(loc_id, "circle","top", size)
//EXAMPLE: getSocialMediaIcons(loc_id, "square","footer", size)
if ( ! empty( $socialMediaIcons ) && $socialMediaActive) {
	echo $socialMediaIcons;
}
?>