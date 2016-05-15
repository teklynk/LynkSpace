<?php
define('inc_access', TRUE);

include 'includes/header.php';

//create sitemap file
$sitemapFileLoc = "../sitemap.xml";
$sitemapfile = fopen($sitemapFileLoc, "w") or die("Unable to open file!");
$otherPages = array("index.php", "about.php", "team.php", "services.php", "contact.php");

if (!file_exists($sitemapFileLoc)) {
   echo "$sitemapFileLoc does not exist";
}

$writeline = "<?xml version='1.0' encoding='UTF-8'?>\n";
fwrite($sitemapfile, $writeline);
$writeline = "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
fwrite($sitemapfile, $writeline);

//gets pages from db
$sqlpages = mysql_query("SELECT id, datetime FROM pages WHERE active=1 ORDER BY datetime DESC");
while ($rowPages  = mysql_fetch_array($sqlpages)) {
	$pageId=$rowPages['id'];
	$pageDate=$rowPages['datetime'];

	$writeline = "\t<url>\n";
	fwrite($sitemapfile, $writeline);
	$writeline = "\t\t<loc>".str_replace('admin/sitemapbuilder.php/','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/page.php?ref=".$pageId)."</loc>\n";
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
	$writeline = "\t\t<loc>".str_replace('admin/sitemapbuilder.php','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$otherPages[$x])."</loc>\n";
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
$robotsfile = fopen($robotsFileLoc, "w") or die("Unable to open file!");

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
echo "<p><a href='setup.php'>Back</a></p>";
echo "<p>Sitemap.xml has been updated: <a target='_blank' href=".str_replace('admin/sitemapbuilder.php/','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/sitemap.xml").">View</a><br/>";
echo "Robots.txt has been updated: <a target='_blank' href=".str_replace('admin/sitemapbuilder.php/','',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/robots.txt").">View</a></p>";
echo "<br/>";
echo "<img src='images/loading.gif' />";
//header("Location: setup.php");
echo "<script>window.location.href='setup.php';</script>";

include 'includes/footer.php';
?>