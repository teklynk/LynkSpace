<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <?php
      include 'db/config.php'; //contains DB connection string and global variables
      include 'core/functions.php'; //contains functions used on every front-end template

      getLocation();
    ?>
    <meta http-equiv="refresh" content="3600;URL='index.php?loc_id=<?php echo $_GET['loc_id'];?>'">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $setupDescription;?>">
    <meta name="keywords" content="<?php echo $setupKeywords;?>">
    <meta name="author" content="<?php echo $setupAuthor;?>">

    <title><?php echo $theTitle;?></title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Default template CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="css/modern-business.css">

    <!-- Custom Override CSS Template - Stored in config.php-->
    <?php

    echo $customCss;

    if (!empty($googleAnalytics)) {
    ?>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $googleAnalytics;?>']);
            _gaq.push(['_trackPageview']);

            (function() {
              var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
              ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    <?php
    }
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <noscript><p>Javascript is not enabled in your browser.</p></noscript>
</head>

<body>

<!-- Navigation -->
<nav class="navbar cpsNavBar" id='top' role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed navbarButton" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
            <img class="pull-left" src="images/cpslogo_v2@2x.png" width="144" alt="" title="" border="0" /> <span class="navbar-brand hidden-xs navTitle"> <?php echo $setupTitle;?></span>
            <!-- This section is used if there is a long site name when viewed on mobile the name is shortened -->
            <a class="navbar-brand visible-xs navTitleSmall" href="index.php?loc_id=<?php echo $_GET['loc_id'];?>"><?php echo $setupTitle;?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse navTabs" id="navbar" aria-expanded="false">
            <?php
                //EXAMPLE: getNav($navSection,$dropdown,$pull)
                getNav('Top','true','left');
            ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
