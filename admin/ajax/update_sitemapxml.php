<?php
//updates the sitemap.xml and robots.txt. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'setup.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {

        //create sitemap file
        $sitemapFileLoc = "../../sitemap.xml";
        $sitemapfile = fopen($sitemapFileLoc, "w") or die("Unable to open sitemap.xml. Check file permissions.");
        $otherPages = array("index.php", "about.php", "team.php", "services.php", "contact.php", "databases.php");

        if (!file_exists($sitemapFileLoc)) {
            die("$sitemapFileLoc does not exist");
        }

        $writeline = "<?xml version='1.0' encoding='UTF-8'?>\n";
        fwrite($sitemapfile, $writeline);
        $writeline = "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
        fwrite($sitemapfile, $writeline);

        //get pages from db
        $sqlpages = mysqli_query($db_conn, "SELECT id, datetime, loc_id FROM pages WHERE active='true' ORDER BY id DESC");
        while ($rowPages = mysqli_fetch_array($sqlpages)) {
            $pageId = $rowPages['id'];
            $locId = $rowPages['loc_id'];
            $pageDate = $rowPages['datetime'];

            $writeline = "\t<url>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<loc>" . str_replace('admin/ajax/update_sitemapxml.php', '', htmlspecialchars("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "page.php?page_id=" . $pageId . "&loc_id=" . $locId)) . "</loc>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<lastmod>" . $pageDate . "</lastmod>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<changefreq>monthly</changefreq>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t</url>\n";
            fwrite($sitemapfile, $writeline);
        }

        //get databases from db
        $sqlCustomers = mysqli_query($db_conn, "SELECT id, section, cust_loc_id FROM category_customers ORDER BY id DESC");
        while ($rowCustomers = mysqli_fetch_array($sqlCustomers)) {
            $custCatId = $rowCustomers['id'];
            $custSection = $rowCustomers['section'];
            $custLocId = $rowCustomers['cust_loc_id'];

            $writeline = "\t<url>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<loc>" . str_replace('admin/ajax/update_sitemapxml.php', '', htmlspecialchars("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "databases.php?section=" . $custSection . "&cat_id=" . $custCatId . "&loc_id=" . $custLocId)) . "</loc>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<changefreq>monthly</changefreq>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t</url>\n";
            fwrite($sitemapfile, $writeline);
        }

        //get locations from db
        $sqlLocations = mysqli_query($db_conn, "SELECT id, name FROM locations WHERE active='true' ORDER BY id DESC");
        while ($rowLocations = mysqli_fetch_array($sqlLocations)) {
            $locId = $rowLocations['id'];
            $locName = $rowLocations['name'];

            $writeline = "\t<url>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<loc>" . str_replace('admin/ajax/update_sitemapxml.php', '', htmlspecialchars("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "index.php?loc_id=" . $locId)) . "</loc>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<changefreq>monthly</changefreq>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t</url>\n";
            fwrite($sitemapfile, $writeline);
        }

        //other pages
        $pagesArrlength = count($otherPages);
        for ($x = 0; $x < $pagesArrlength; $x++) {
            $writeline = "\t<url>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<loc>" . str_replace('admin/ajax/update_sitemapxml.php', '', htmlspecialchars("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $otherPages[$x])) . "</loc>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t\t<changefreq>monthly</changefreq>\n";
            fwrite($sitemapfile, $writeline);
            $writeline = "\t</url>\n";
            fwrite($sitemapfile, $writeline);
        }

        $writeline = "</urlset>";
        fwrite($sitemapfile, $writeline);

        fclose($sitemapfile);

        //create robots.txt
        $robotsFileLoc = "../../robots.txt";
        $robotsfile = fopen($robotsFileLoc, "w") or die("Unable to open robots.txt! Check file permissions.");

        if (!file_exists($robotsFileLoc)) {
            die("$robotsFileLoc does not exist");
        }

        $writeline = "User-agent: *\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /admin/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /css/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /db/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /includes/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /mail/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /core/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Disallow: /js/\n";
        fwrite($robotsfile, $writeline);
        $writeline = "Sitemap: " . str_replace('admin/ajax/update_sitemapxml.php', '', "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "sitemap.xml");
        fwrite($robotsfile, $writeline);

        fclose($robotsfile);
    }

} else {

    die('Direct access not permitted');

}
?>