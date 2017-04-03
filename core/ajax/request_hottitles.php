<!-- Hot titles request -->
<?php
define('inc_access', TRUE);

if (!empty($_GET['rssurl'])) {

    require_once('../../db/config.php');
    require_once('../functions.php');

    ?>

    <script type="text/javascript">
        //Hot titles carousel
        $('.owl-carousel').owlCarousel({
            center: true,
            loop: true,
            margin: 10,
            nav: true,
            autoWidth: true,
            //autoHeight: true,
            //adds bootstrap nav buttons
            navText: [
                '<span class="left carousel-control" data-slide="prev"><i class="icon-prev"></i></span>',
                '<span class="right carousel-control" data-slide="next"><i class="icon-next"></i></span>'
            ],
            autoplay: true,
            autoplayTimeout: <?php echo $carouselSpeed; ?>,
            autoplayHoverPause: true,
            items: 6,
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
    //example: getHottitlesCarousel("http://beacon.tlcdelivers.com:8080/list/dynamic/1921419/rss", 'MD', true, 30);
    getHottitlesCarousel($rssUrl, 'MD', true, 50);

} else {

    die('Direct access not permitted');

}
?>

