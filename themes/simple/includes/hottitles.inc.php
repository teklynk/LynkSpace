<!-- Hot titles iframe -->
<?php
define('inc_access', TRUE);
include_once '../../../db/config.php';
include_once '../../../core/functions.php';
$rssUrl = $_GET['rssurl'];
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Bootstrap Core CSS CDN -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Default template CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/css/core-style.min.css">
    <!-- theme template CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/themes/<?php echo $themeOption ?>/css/cps-style.min.css">
    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Core js file-->
    <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/js/functions.min.js"></script>
    <style>
        html, head, body {padding:0; margin:0; border: none; background: transparent; overflow: hidden;}
    </style>
</head>
<body>

    <div class="carousel slide hottitlesCarousel" data-ride="carousel" data-type="multi" data-interval="5000" id="hottitlesCarousel">
        <div class="carousel-inner">
            <?php
            //example: getHottitlesCarousel($xmlurl, $maxcnt, $colmd, $colsm, $colxs);
            getHottitlesCarousel($rssUrl, 50, 2, 6, 12);
            ?>
        </div>
        <a class="left carousel-control" href="#hottitlesCarousel" data-slide="prev"><i class="fa-chevron-left icon-prev"></i></a>
        <a class="right carousel-control" href="#hottitlesCarousel" data-slide="next"><i class="fa-chevron-right icon-next"></i></a>
    </div>

</body>
</html>