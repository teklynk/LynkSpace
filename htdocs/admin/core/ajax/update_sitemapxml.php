<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
	die( 'Direct access not permitted' );
}

//updates the sitemap.xml and robots.txt. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['user_level'] == 1 && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'siteoptions.php' ) {

	require_once( __DIR__ . '/../../../../config/config.php' );

	if ( ! empty( $_GET ) && $_GET['update'] ) {

		$sitemapFileLoc = "../../../sitemap.xml";

		$otherPages = array( "index.php", "staff.php", "services.php", "contact.php", "databases.php" );

		if ( ! file_exists( $sitemapFileLoc ) ) {
			die( "$sitemapFileLoc does not exist" . PHP_EOL );
		}

		if ( ! is_writable( $sitemapFileLoc ) ) {
			die( "Unable to write to sitemap.xml. Check file permissions." . PHP_EOL );
		}

		$sitemapfile = fopen( $sitemapFileLoc, "w" ) or die( "Unable to open sitemap.xml. Check file permissions." );

		//Clear the file
		ftruncate( $sitemapFileLoc, 0 );

		$writeline = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		fwrite( $sitemapfile, $writeline );
		$writeline = "<urlset xmlns=\"https://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		fwrite( $sitemapfile, $writeline );

		//get pages from config
		$sqlpages = mysqli_query( $db_conn, "SELECT id, datetime, loc_id FROM pages WHERE active='true' ORDER BY id DESC;" );
		while ( $rowPages = mysqli_fetch_array( $sqlpages, MYSQLI_ASSOC ) ) {
			$pageId   = $rowPages['id'];
			$locId    = $rowPages['loc_id'];
			$pageDate = $rowPages['datetime'];

			$writeline = "\t<url>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<loc>" . htmlspecialchars( serverUrlStr . "/page.php?page_id=" . $pageId . "&loc_id=" . $locId ) . "</loc>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<lastmod>" . $pageDate . "</lastmod>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<changefreq>monthly</changefreq>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t</url>\n";
			fwrite( $sitemapfile, $writeline );
		}

		//get databases from config
		$sqlCustomers = mysqli_query( $db_conn, "SELECT id, section, cust_loc_id FROM category_customers ORDER BY id DESC;" );
		while ( $rowCustomers = mysqli_fetch_array( $sqlCustomers, MYSQLI_ASSOC ) ) {
			$custCatId   = $rowCustomers['id'];
			$custSection = $rowCustomers['section'];
			$custLocId   = $rowCustomers['cust_loc_id'];

			$writeline = "\t<url>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<loc>" . htmlspecialchars( serverUrlStr . "/databases.php?section=" . $custSection . "&cat_id=" . $custCatId . "&loc_id=" . $custLocId ) . "</loc>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<changefreq>monthly</changefreq>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t</url>\n";
			fwrite( $sitemapfile, $writeline );
		}

		//get locations from config
		$sqlLocations = mysqli_query( $db_conn, "SELECT id, name FROM locations WHERE active='true' ORDER BY id DESC;" );
		while ( $rowLocations = mysqli_fetch_array( $sqlLocations, MYSQLI_ASSOC ) ) {
			$locId   = $rowLocations['id'];
			$locName = $rowLocations['name'];

			$writeline = "\t<url>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<loc>" . htmlspecialchars( serverUrlStr . "/index.php?loc_id=" . $locId ) . "</loc>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<changefreq>monthly</changefreq>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t</url>\n";
			fwrite( $sitemapfile, $writeline );
		}

		//other pages
		$pagesArrlength = count( $otherPages );
		for ( $x = 0; $x < $pagesArrlength; $x ++ ) {
			$writeline = "\t<url>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<loc>" . htmlspecialchars( serverUrlStr . "/" . $otherPages[ $x ] ) . "</loc>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t\t<changefreq>monthly</changefreq>\n";
			fwrite( $sitemapfile, $writeline );
			$writeline = "\t</url>\n";
			fwrite( $sitemapfile, $writeline );
		}

		$writeline = "</urlset>";
		fwrite( $sitemapfile, $writeline );

		fclose( $sitemapfile );

		//create robots.txt
		$robotsFileLoc = "../../robots.txt";

		if ( ! is_writable( $robotsFileLoc ) ) {
			die( "Unable to write to robots.txt. Check file permissions." . PHP_EOL );
		}

		if ( ! file_exists( $robotsFileLoc ) ) {
			die( "$robotsFileLoc does not exist" . PHP_EOL );
		}

		$robotsfile = fopen( $robotsFileLoc, "w" ) or die( "Unable to open robots.txt! Check file permissions." );

		//Clear the file
		ftruncate( $robotsFileLoc, 0 );

		$writeline = "User-agent: *\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /admin/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /ajax/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /css/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /config/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /includes/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /themes/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /mail/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /core/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /js/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /migration/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Disallow: /vendor/\n";
		fwrite( $robotsfile, $writeline );
		$writeline = "Sitemap: " . serverUrlStr . "/sitemap.xml";
		fwrite( $robotsfile, $writeline );

		fclose( $robotsfile );
	}

	die( 'Created Sitemap.xml and Robots.txt' . PHP_EOL );

} else {

	die( 'Direct access not permitted' );

}
?>