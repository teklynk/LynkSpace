<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        include 'db/dbsetup.php'; //contains DB connection string and global variables

        $sqlSetup = mysql_query("SELECT title, author, keywords, description, headercode, googleanalytics FROM setup");
        $rowSetup  = mysql_fetch_array($sqlSetup);
        
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $rowSetup["description"];?>">
    <meta name="keywords" content="<?php echo $rowSetup["keywords"];?>">
    <meta name="author" content="<?php echo $rowSetup["author"];?>">

    <title><?php echo $rowSetup["title"];?></title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" type="text/css" href="css/modern-business.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <?php
    if ($customCss_url != "") {
        echo "<link rel='stylesheet' type='text/css' href='".$customCss_url."' >";
    }
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
    if (!empty($rowSetup["headercode"])) {
        echo $rowSetup["headercode"]."\n";
    }

    if (!empty($rowSetup["googleanalytics"])) {
        $googleID = $rowSetup["googleanalytics"];
    ?>
        <script type="text/javascript">
            
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $googleID ?>']);
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
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id='top' role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo $rowSetup["title"];?></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php 
                    $sqlNavLinks = mysql_query("SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='Top' AND sort>0 ORDER BY sort");
                    //returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, category.id, category.name
                    $tempLink = 0;
					while ($rowNavLinks = mysql_fetch_array($sqlNavLinks)) {
						
                        if ($rowNavLinks[4] == $rowNavLinks[7] AND $rowNavLinks[4] != 29) { //NOTE: 29=None in the category table
							if ($rowNavLinks[4] != $tempLink) {
								$sqlNavCatLinks = mysql_query("SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='Top' AND category.id=".$rowNavLinks[4]." AND sort>0 ORDER BY sort");
								//returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, category.id, category.name
                                echo "<li class='dropdown'>";
									echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$rowNavLinks[8]." <b class='caret'></b></a>";
									echo "<ul class='dropdown-menu'>";
									while ($rowNavCatLinks = mysql_fetch_array($sqlNavCatLinks)) {
										echo "<li>";
										echo "<a href='".$rowNavCatLinks[3]."'>".$rowNavCatLinks[2]."</a>";
										echo "</li>";
									}
									echo "</ul>";
								echo "</li>";
							}
                        } else {
                            echo "<li>";
                            echo "<a href='".$rowNavLinks[3]."'>".$rowNavLinks[2]."</a>";
                            echo "</li>";
                        }

						$tempLink = $rowNavLinks[4];
					}
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>