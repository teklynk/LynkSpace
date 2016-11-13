<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

session_start();

//overwrite session script name on reload
//Get the page/file name and set it as a variable. Can be used for Ajax calls or page headers.
$_SESSION["file_referer"] = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php
//DB connection string and Global variables
include '../db/config.php';

//IP Range is set in config
if ($IPrange <> '') {
	if (!strstr($_SERVER['REMOTE_ADDR'], $IPrange) ){
		die('Permission denied'); //Do not execute any more code on the page
	}
}
?>
    <meta http-equiv="refresh" content="<?php echo $sessionTimeout * 60;?>;URL='index.php?logout=true'" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap admin panel 2/2/2015">
    <meta name="author" content="Ryan Jones">

    <title>Admin Panel</title>

    <!-- Bootstrap Core 3.3.5 CSS CDN -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Admin Panel CSS -->
    <link rel="stylesheet" type="text/css" href="css/sb-admin.css">

    <!-- Admin Panel Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" >

    <!--Bootstrap-Selects -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css" >

    <!--Bootstrap Toggle-->
    <link rel="stylesheet" type="text/css" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- Admin Panel Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!--Bootstrap-Selects-JS-->
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.js"></script>

    <!--Bootstrap-Toggle-JS-->
    <script type="text/javascript" language="javascript" src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- TinyMCE CDN -->
	<script type="text/javascript" language="javascript"  src="//cdn.tinymce.com/4/tinymce.min.js"></script>

	<!-- DataTables JavaScript CDN -->
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Functions -->
    <script type="text/javascript" language="javascript" src="js/functions.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <noscript><p>Javascript is not enabled in your browser.</p></noscript>

  <?php

	$sqlSetup = mysqli_query($db_conn, "SELECT tinymce, pageheading, servicesheading, sliderheading, teamheading, customersheading FROM setup WHERE id='".$_SESSION['loc_id']."'");
	$rowSetup = mysqli_fetch_array($sqlSetup);

  if (!empty($_GET['loc_id'])){

    //Create session variable from loc_id in querystring. Can use $_SESSION['loc_id'] in place of $_GET['loc_id] if loc_id is not available in the querystring
    $_SESSION['loc_id'] = $_GET['loc_id'];

    $sqlGetLocation = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active=1 AND id='".$_SESSION['loc_id']."'");
    $rowGetLocation = mysqli_fetch_array($sqlGetLocation);

    $_SESSION['loc_name'] = $rowGetLocation['name'];
  }

    $sqlLocations = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true' "); //part of while loop

	if (isset($_SESSION["user_id"]) AND isset($_SESSION["user_name"]) AND $rowSetup["tinymce"]==1) {

        //Initializing variables
        $fileListJson = "";
        $linkListJson = "";

        //Build list of images in uploads folder for tinymce editor
        if ($handle = opendir($image_dir)) {

            while (false !== ($imgfile = readdir($handle))) {
                if ('.' === $imgfile) continue;
                if ('..' === $imgfile) continue;
                if ($imgfile === "Thumbs.db") continue;
                if ($imgfile === ".DS_Store") continue;
                if ($imgfile === "index.html") continue;

                $fileListJson = $fileListJson . "{title: '".$imgfile."', value: '".$image_url.$imgfile."'},";
            }

            closedir($handle);
        }

        //get and build page list for TinyMCE
        $sqlGetPages= mysqli_query($db_conn, "SELECT id, title, active FROM pages WHERE active=1 AND loc_id='".$_GET['loc_id']."' ORDER BY title");
        while ($rowGetPages = mysqli_fetch_array($sqlGetPages)) {
            $getPageId = $rowGetPages['id'];
            $getPageTitle = $rowGetPages['title'];
            $linkListJson = $linkListJson . "{title: '".$getPageTitle."', value: 'page.php?ref=".$getPageId."'},";
        }

	?>
    	<script type="text/javascript">
            $(document).ready(function () {
    			tinymce.init({
    			selector: 'textarea.tinymce',
				theme: 'modern',
    		    plugins: 'link image table code',
    		    image_dimensions: false,
    			object_resizing: false,
    		    document_base_url: '<?php echo $image_baseURL; ?>',
    		    resize: 'both',
    		    image_list: [<?php echo rtrim($fileListJson, ","); ?>],
                link_list: [<?php echo rtrim($linkListJson, ","); ?>],
        		menu: {},
     			toolbar: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code'
    			});
    		});
    	</script>
	<?php
	}
	?>
</head>
<body>

    <div id="wrapper">
<?php
    if (isset($_SESSION["loggedIn"])) {
?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Admin Panel <?php if (!empty($_SESSION['loc_name'])) {echo ' - ' . $_SESSION['loc_name']; }?></a>

            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo $_SESSION["user_name"];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="../index.php?loc_id=<?php echo $_SESSION["loc_id"];?>" target="_blank"><i class="fa fa-fw fa-home"></i> View My Site</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
             </ul>
             <ul class="nav navbar-right top-nav">
                  <li style="margin-top:8px;">
                    <form name="loc_menu" method="get">
                    <select class="selectpicker" data-container="body" data-width="auto" data-size="10" data-live-search="true" name="loc_id" id="loc_id">
                      <?php
                      while ($rowLocations = mysqli_fetch_array($sqlLocations)) {

                        if ($rowLocations['id'] == $_GET['loc_id']) {
                          $loc_menu_select = "SELECTED";
                        } else {
                          $loc_menu_select = "";
                        }

                        echo "<option data-icon='fa fa-fw fa-building' value=".$rowLocations['id']." $loc_menu_select>".$rowLocations['name']."</option>";
                      }
                      ?>
                    </select>
                    <input type="submit" name="loc_submit" class="btn btn-default" value="Go">
                    </form>
                   </li>
              </ul>

              <?php

              if (isset($_SESSION['loc_id'])) {
                $setLocId = "loc_id=".$_SESSION['loc_id'];
              } else {
                $setLocId = "";
              }
              ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="setup.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-gear"></i> Setup</a>
                    </li>
                    <li>
                        <a href="slider.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-photo"></i> Image Slider</a>
                    </li>
                    <li>
                        <a href="featured.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-rocket"></i> Featured</a>
                    </li>
                    <li>
                        <a href="page.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-list"></i> Pages</a>
                    </li>
                    <li>
                        <a href="navigation.php?section=<?php echo $navSections[0] ."&".$setLocId;?>"><i class="fa fa-fw fa-bars"></i> Navigation</a>
                    </li>
                    <li>
                        <a href="aboutus.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-file-text"></i> About Us</a>
                    </li>
                    <li>
                        <a href="contactus.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-building"></i> Contact Us</a>
                    </li>
                    <li>
                        <a href="socialmedia.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-facebook-square"></i> Social Media</a>
                    </li>
                    <li>
                        <a href="generalinfo.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-file-text"></i> General Info</a>
                    </li>
                    <li>
                        <a href="services.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-list"></i> Services</a>
                    </li>
                    <li>
                        <a href="team.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-list"></i> Team</a>
                    </li>
                    <li>
                        <a href="customers.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-list"></i> Customers</a>
                    </li>
                    <li>
                        <a href="uploads.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-folder"></i> Uploads</a>
                    </li>
                    <li>
                        <a href="editor.php?<?php echo $setLocId;?>"><i class="fa fa-fw fa-css3"></i> Styles</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<?php
    } //end of big if

    if (!$_SESSION['loggedIn']) {
        if (basename($_SERVER['PHP_SELF']) != 'index.php') {
            if (basename($_SERVER['PHP_SELF']) != 'install.php') {
                echo "Not signed in!";
                header('Location: index.php?logout=true');
            }
        }
    }

    echo "<div id='page-wrapper'>";
    echo "<div class='container-fluid'>";
?>