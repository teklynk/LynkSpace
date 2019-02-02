<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

echo "<div class='page-team'>";

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

require_once( __DIR__ . '/includes/staff.inc.php' );

require_once( __DIR__ . '/includes/databasesfeatured.inc.php' );

echo "</div>";

require_once( __DIR__ . '/includes/footer.inc.php' );
?>