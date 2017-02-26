<!-- Hot titles Section -->
<?php
if (!defined('inc_access')) {
   die('Direct access not permitted');
}
$savedSearches = array("http://beacon.tlcdelivers.com:8080/list/dynamic/1921425/rss","http://beacon.tlcdelivers.com:8080/list/dynamic/200144044/rss");
?>

<div class="carousel slide" data-ride="carousel" data-type="multi" data-interval="false" id="hottitlesCarousel">
    <div class="carousel-inner">
        <?php
        getHottitlesCarousel($savedSearches[0], 20, 2, 6, 12);
        ?>
    </div>
    <a class="left carousel-control" href="#hottitlesCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left icon-prev"></i></a>
    <a class="right carousel-control" href="#hottitlesCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right icon-next"></i></a>
</div>


