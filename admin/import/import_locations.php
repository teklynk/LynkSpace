<?php
//connect to the database
$connect = mysql_connect("localhost","username","password");
mysql_select_db("mydatabase",$connect); //select the table
//

if ($_FILES[csv][size] > 0) {

    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");

    //loop through the csv file and insert into database
    do {
        if ($data[0]) {
            mysql_query("INSERT INTO contacts (contact_first, contact_last, contact_email) VALUES 
                ( 
                    '".addslashes($data[0])."', 
                    '".addslashes($data[1])."', 
                    '".addslashes($data[2])."' 
                ) 
            ");
        }
        //$featuredInsert = "INSERT INTO featured (heading, introtext, content, image, image_align, use_defaults, author_name, datetime, loc_id) VALUES ('" . safeCleanStr($_POST['featured_heading']) . "', '" . safeCleanStr($_POST['featured_introtext']) . "', '" . trim($_POST['featured_content']) . "', '" . $_POST['featured_image'] . "', '" . $_POST['featured_image_align'] . "',  'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
        //$setupInsert = "INSERT INTO setup (title, keywords, description, config, logo, ls2pac, ls2kids, searchdefault, author, pageheading, servicesheading, sliderheading, teamheading, hottitlesheading, customersheading_1, customersheading_2, customersheading_3, servicescontent, customerscontent_1, customerscontent_2, customerscontent_3, teamcontent, slider_use_defaults, databases_use_defaults_1, databases_use_defaults_2, databases_use_defaults_3, navigation_use_defaults_1, navigation_use_defaults_2, navigation_use_defaults_3, services_use_defaults, team_use_defaults, hottitles_use_defaults, datetime, author_name, loc_id) VALUES ('" . safeCleanStr($_POST['site_title']) . "', '" . safeCleanStr($site_keywords) . "', '" . safeCleanStr($site_description) . "', '" . safeCleanStr($_POST['site_config']) . "', '" . $_POST['site_logo'] . "', 'true', 'true', 1, '" . safeCleanStr($site_author) . "', 'Pages', 'Service', 'Slider', 'Meet the Team', 'Resources', '', '', '', '', '', '', '', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ")";
        //$locationInsert = "INSERT INTO locations (id, name, type, datetime, active) VALUES (" . $_GET['loc_id'] . ", '" . safeCleanStr($_POST['location_name']) . "', '" . safeCleanStr($_POST['location_type']) . "', '" . date("Y-m-d H:i:s") . "', 'true')";

    } while ($data = fgetcsv($handle,1000,",","'"));
    //

    //redirect
    header('Location: import.php?success=1'); die;

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Import a CSV File with PHP & MySQL</title>
</head>

<body>

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    Choose your file: <br />
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>