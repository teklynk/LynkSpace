<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

echo "<div class='page-databases'>";

require_once( __DIR__ . '/includes/featured.inc.php' );

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ( loc_id == 1 && multiBranch == 'true' ) {
	require_once( __DIR__ . '/includes/searchlocations.inc.php' );
} else {
	require_once( __DIR__ . '/includes/searchpac.inc.php' );
}

echo "</div>";
echo "</div>";

if ( ! empty( $_GET['cat_id'] ) ) {
	require_once( __DIR__ . '/includes/databases_catid.inc.php' );
} else {
	require_once( __DIR__ . '/includes/databases.inc.php' );
}

echo "</div>";


require_once( __DIR__ . '/includes/footer.inc.php' );
?>