<!-- Hot titles request -->
<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

define('inc_access', TRUE);

if (!empty($_GET['rssurl'])) {

    require_once('../../config/config.php');
    require_once('../functions.php');

    ?>

    <script type="text/javascript">
        //Hot titles carousel
        $('.owl-carousel').owlCarousel({
            center: true,
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            autoWidth: true,
            //adds bootstrap nav buttons
            navText: [
                '<span class="left carousel-control" data-slide="prev"><i class="icon-prev"></i></span>',
                '<span class="right carousel-control" data-slide="next"><i class="icon-next"></i></span>'
            ],
            autoplay: true,
            autoplayTimeout: <?php echo carouselSpeed; ?>,
            autoplayHoverPause: true,
            items: 8,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
    </script>

    <?php

    $rssUrl = $_GET['rssurl'];
    //example: getHottitlesCarousel("http://test.library.com:8080/list/dynamic/1921419/rss", 'MD', 'true', 30);
    getHottitlesCarousel($rssUrl, 'MD', 'true', 50);

} else {

    die('URL not found');

}
?>

