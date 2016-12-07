<?php
define('inc_access', TRUE);

include 'includes/header.php';

//create sitemap file
$sitemapFileLoc = "../sitemap.xml";
$sitemapfile = fopen($sitemapFileLoc, "w") or die("Unable to open sitemap.xml. Check file permissions.");
$otherPages = array("index.php", "about.php", "team.php", "services.php", "contact.php");

if (!file_exists($sitemapFileLoc)) {
   echo "$sitemapFileLoc does not exist";
}

$writeline = "<?xml version='1.0' encoding='UTF-8'?>\n";
fwrite($sitemapfile, $writeline);
$writeline = "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
fwrite($sitemapfile, $writeline);

//get pages from db
$sqlpages = mysqli_query($db_conn, "SELECT id, datetime, loc_id FROM pages WHERE active='true' ORDER BY datetime DESC");
while ($rowPages  = mysqli_fetch_array($sqlpages)) {
	$pageId=$rowPages['id'];
    $locId=$rowPages['loc_id'];
	$pageDate=$rowPages['datetime'];

	$writeline = "\t<url>\n";
	fwrite($sitemapfile, $writeline);
	$writeline = "\t\t<loc>".str_replace('admin/sitemapbuilder.php/','',htmlspecialchars("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/page.php?page_id=".$pageId."&loc_id=".$locId))."</loc>\n";
	fwrite($sitemapfile, $writeline);
	$writeline = "\t\t<lastmod>".$pageDate."</lastmod>\n";
	fwrite($sitemapfile, $writeline);
	$writeline = "\t\t<changefreq>monthly</changefreq>\n";
	fwrite($sitemapfile, $writeline);
	$writeline = "\t</url>\n";
	fwrite($sitemapfile, $writeline);
}

//other pages
$pagesArrlength = count($otherPages);
for($x = 0; $x < $pagesArrlength; $x++) {
	$writeline = "\t<url>\n";
	fwrite($sitemapfile, $writeline);
	$writeline = "\t\t<loc>".str_replace('admin/sitemapbuilder.php','',htmlspecialchars("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$otherPages[$x]))."</loc>\n";
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
$robotsFileLoc = "../robots.txt";
$robotsfile = fopen($robotsFileLoc, "w") or die("Unable to open robots.txt! Check file permissions.");

if (!file_exists($robotsFileLoc)) {
   echo "$robotsFileLoc does not exist";
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
$writeline = "Sitemap: ".str_replace('admin/sitemapbuilder.php/','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/sitemap.xml");
fwrite($robotsfile, $writeline);

fclose($robotsfile);
echo "<br/>";
echo "<p><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></p>";
echo "<br/>";
echo "<p><i class='fa fa-long-arrow-left'></i> <a href='setup.php'>Back</a></p>";
echo "<p>Sitemap.xml has been updated: <a target='_blank' href=".str_replace('admin/sitemapbuilder.php/','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/sitemap.xml").">View</a><br/>";
echo "Robots.txt has been updated: <a target='_blank' href=".str_replace('admin/sitemapbuilder.php/','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/robots.txt").">View</a></p>";

echo "<script>window.location.href='setup.php?loc_id=".$_SESSION['loc_id']."';</script>";

include 'includes/footer.php';
?>