<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <?php

    if (!defined('inc_access')) {
        die('Direct access not permitted');
    }

    //DB connection string and Global variables
    require_once '../config/config.php';
    //Admin panel functions
    require_once('core/functions.php');

    //If Super Admin then bypass iprange restriction.
    //super admin
    if ($_SESSION['super_admin'] == false && basename($_SERVER['PHP_SELF']) != 'index.php'){
    //IP Range is set in config and contains numbers
        if (!empty($IPrange)) {
            if (!strstr(getRealIpAddr(), $IPrange)) {
                die('Permission denied'); //Do not execute any more code on the page
            }
        }
    }

    ?>
    <meta http-equiv="refresh" content="<?php echo $sessionTimeout; ?>; URL=index.php?logout=true"/>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="images/favicon.ico"/>

    <title>YouSeeMore - Admin Panel</title>

    <!-- Core CSS Libraries -->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/css/admin.min.css">

    <!-- Admin Panel Fonts -->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/css/font-awesome.min.css">

    <!-- Admin Panel CSS -->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/css/sb-admin.min.css">

    <!-- Custom Fonts from: localfont.com -->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/css/fonts.min.css">

    <!-- Core JS Libraries -->
    <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/js/admin.min.js"></script>

    <?php
    if (defined('tinyMCE')) {
    ?>
    <!-- TinyMCE -->
    <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/js/tinymce/tinymce.min.js"></script>
    <?php
    }
    ?>

    <?php
    if (defined('codeMirror')) {
    ?>
        <!-- CodeMirror -->
        <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/css/codemirror/lib/codemirror.min.css">
        <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/js/codemirror/lib/codemirror.min.js"></script>
        <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/js/codemirror/mode/css/css.min.js"></script>
    <?php
    }
    ?>

    <!-- Custom Functions -->
    <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'].$subDirectory; ?>/admin/js/functions.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lte IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <noscript>Javascript is not enabled in your browser.</noscript>

    <?php
    $sqlSetup = mysqli_query($db_conn, "SELECT pageheading, servicesheading, sliderheading, teamheading, customersheading, loc_id FROM setup WHERE loc_id=" . $_SESSION['loc_id'] . " ");
    $rowSetup = mysqli_fetch_array($sqlSetup);

    if (!empty($_GET['loc_id'])) {

        //Create session variable from loc_id in querystring. Can use $_SESSION['loc_id'] in place of $_GET['loc_id] if loc_id is not available in the querystring
        $_SESSION['loc_id'] = $_GET['loc_id'];

        $sqlGetLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' AND id=" . $_SESSION['loc_id'] . " ");
        $rowGetLocation = mysqli_fetch_array($sqlGetLocation);

        $_SESSION['loc_name'] = $rowGetLocation['name'];
    }

    $sqlLocations = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' "); //part of while loop

    //TinyMCE setup
    if (defined('tinyMCE') && isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

        //Initializing variables
        $fileListJson = "";
        $linkListJson = "";

        //Build list of images in uploads folder for tinymce
        if ($handle = opendir($image_dir)) {

            while (false !== ($imgfile = readdir($handle))) {
                if ('.' === $imgfile) continue;
                if ('..' === $imgfile) continue;
                if ($imgfile === "Thumbs.db") continue;
                if ($imgfile === ".DS_Store") continue;
                if ($imgfile === "index.html") continue;
                $allimgfiles[] = strtolower($imgfile);
            }
            closedir($handle);
        }
        sort($allimgfiles);
        foreach($allimgfiles as $imgfile) {
            $fileListJson .= "{title: '" . $imgfile . "', value: '" . $image_url . $imgfile . "'},";
        }

        //get and build page list for TinyMCE
        $sqlGetPages = mysqli_query($db_conn, "SELECT id, title, active FROM pages WHERE active='true' AND loc_id=" . $_GET['loc_id'] . " ORDER BY title");
        while ($rowGetPages = mysqli_fetch_array($sqlGetPages)) {
            $getPageId = $rowGetPages['id'];
            $getPageTitle = $rowGetPages['title'];
            $linkListJson .= "{title: '" . $getPageTitle . "', value: 'page.php?loc_id=" . $_GET['loc_id'] . "&page_id=" . $getPageId . "'},";
        }

        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                if ($('textarea.tinymce').length){
                    tinymce.init({
                        selector: 'textarea.tinymce',
                        height: 500,
                        theme: 'modern',
                        plugins: 'save link image media lists paste code',
                        convert_urls: false,
                        paste_data_images: false,
                        paste_as_text: true,
                        paste_auto_cleanup_on_paste: true,
                        paste_remove_styles: true,
                        paste_remove_styles_if_webkit: true,
                        paste_strip_class_attributes: true,
                        image_dimensions: false,
                        object_resizing: false,
                        document_base_url: '<?php echo $image_baseURL; ?>',
                        resize: 'both',
                        image_list: [<?php echo rtrim($fileListJson, ","); ?>],
                        link_list: [<?php echo rtrim($linkListJson, ","); ?>],
                        menubar: false,
                        toolbar_items_size: 'small',
                        toolbar: 'save insertfile undo redo | bold italic removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
                        media_live_embeds: true
                    });
                }
            });
        </script>
        <?php
    }
    ?>
</head>
<body>
<!--[if lte IE 9]>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger fade in" role="alert" >
                <h4>Did you know that your Internet Explorer is out of date?</h4>
                <p>To get the best possible experience using our site we recommend that you use Google Chrome. To visit the Chrome download page, click the Get Chrome button below.</p>
                <p><a href="http://www.google.com/chrome/browser/" target="_blank" class="btn btn-danger">Get Chrome</a></p>
            </div>
        </div>
    </div>
</div>
<![endif]-->

<div id="wrapper">
    <?php
    if (isset($_SESSION['loggedIn'])) {
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="admin-topnav">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a type="button" id="button-menu" class="pull-left"><i class="fa fa-dedent"></i></a>
            <a class="navbar-brand">YOUSEEMORE</a>

            <?php
            if ($multiBranch == 'true' && isset($_SESSION['loc_list']) && $_SESSION['user_level'] == 1) {
            ?>
            <ul class="nav navbar-right top-nav">
                <li class="loc-select">

                    <select class="selectpicker selectpicker-auto" data-container="body" data-dropup-auto="false" data-width="auto" data-size="10" data-live-search="true" name="loc_id_list" id="loc_id_list">
                        <?php
                            echo $_SESSION['loc_list'];
                        ?>
                    </select>

                </li>
            </ul>
            <?php
            }
            ?>

        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">

            <!-- Updates and Alerts Button-->
            <li class="update-menu">
                <?php echo $_SESSION['updates_available']; ?>
            </li>

            <li class="dropdown user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class='img-circle' src="<?php echo getGravatar($_SESSION['user_email'], 24); ?>"/> <?php echo $_SESSION['user_name']; ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="../index.php?loc_id=<?php echo $_SESSION['loc_id']; ?>" target="_blank"><i class="fa fa-fw fa-home"></i> View My Site</a>
                    </li>
                    <li>
                        <a href="users.php?loc_id=<?php echo $_SESSION['loc_id']; ?>"><i class="fa fa-fw fa-user-circle"></i> My Account</a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><i class="fa fa-fw fa-question-circle"></i> Help</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>

        <?php

        if (isset($_SESSION['loc_id'])) {
            $setLocId = "loc_id=" . $_SESSION['loc_id'];
        } else {
            $setLocId = "";
        }

        ?>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse" id="admin-sidenav">
            <ul class="nav navbar-nav side-nav">
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'setup.php'){echo "class='active'";}?>>
                    <a href="setup.php?<?php echo $setLocId; ?>" title="Settings"><i class="fa fa-fw fa-cog"></i> Settings</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'featured.php'){echo "class='active'";}?>>
                    <a href="featured.php?<?php echo $setLocId; ?>" title="Feature"><i class="fa fa-fw fa-magic"></i> Feature</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'slider.php'){echo "class='active'";}?>>
                    <a href="slider.php?<?php echo $setLocId; ?>" title="Image Slider"><i class="fa fa-fw fa-picture-o"></i> Image Slider</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'navigation.php'){echo "class='active'";}?>>
                    <a href="navigation.php?section=<?php echo $navSections[0] . "&" . $setLocId; ?>" title="Navigation"><i class="fa fa-fw fa-bars"></i> Navigation</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'page.php'){echo "class='active'";}?>>
                    <a href="page.php?<?php echo $setLocId; ?>" title="Pages"><i class="fa fa-fw fa-file-text"></i> Pages</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'aboutus.php'){echo "class='active'";}?>>
                    <a href="aboutus.php?<?php echo $setLocId; ?>" title="About Us"><i class="fa fa-fw fa-building"></i> About</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'contactus.php'){echo "class='active'";}?>>
                    <a href="contactus.php?<?php echo $setLocId; ?>" title="Contact Us"><i class="fa fa-fw fa-map-marker"></i> Contact</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'socialmedia.php'){echo "class='active'";}?>>
                    <a href="socialmedia.php?<?php echo $setLocId; ?>" title="Social Media"><i class="fa fa-fw fa-share-square"></i> Social Media</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'services.php'){echo "class='active'";}?>>
                    <a href="services.php?<?php echo $setLocId; ?>" title="Services"><i class="fa fa-fw fa-list-alt"></i> Services</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'team.php'){echo "class='active'";}?>>
                    <a href="team.php?<?php echo $setLocId; ?>" title="Team"><i class="fa fa-fw fa-address-card"></i> Team</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'hottitles.php'){echo "class='active'";}?>>
                    <a href="hottitles.php?<?php echo $setLocId; ?>" title="Hot Titles"><i class="fa fa-fw fa-fire"></i> Hot Titles</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'databases.php'){echo "class='active'";}?>>
                    <a href="databases.php?section=<?php echo $custSections[0] . "&" . $setLocId; ?>" title="Databases"><i class="fa fa-fw fa-link"></i> Databases</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'generalinfo.php'){echo "class='active'";}?>>
                    <a href="generalinfo.php?<?php echo $setLocId; ?>" title="General Info"><i class="fa fa-fw fa-info-circle"></i> General Info</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'uploads.php'){echo "class='active'";}?>>
                    <a href="uploads.php?<?php echo $setLocId; ?>" title="Uploads"><i class="fa fa-fw fa-upload"></i> Uploads</a>
                </li>
                <?php
                if ($_SESSION['user_level'] == 1) {
                    echo "<li ";
                        if (basename($_SERVER['PHP_SELF']) == 'usermanager.php'){echo "class='active'";}
                    echo  " >";
                    echo "<a href='usermanager.php?".$setLocId."' title='User Manager'><i class='fa fa-fw fa-users'></i> User Manager</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
<?php
} //end of big if

if (!$_SESSION['loggedIn']) {
    if (basename($_SERVER['PHP_SELF']) != 'index.php') {
        if (basename($_SERVER['PHP_SELF']) != 'install.php') {
            header('Location: index.php?logout=true');
            echo "<script>window.location.href='index.php?logout=true';</script>";
        }
    }
}

echo "<div id='page-wrapper'>";
echo "<div class='container-fluid'>";
?>