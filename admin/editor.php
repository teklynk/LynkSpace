<?php
session_start();
define('inc_access', TRUE);
define('codeMirror', TRUE);

include_once('includes/header.inc.php');

// Only allow Admin users have access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1) {
    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}

$pageMsg="";

//css file that can be edited
$fileToEdit_dir = "../themes/".themeOption."/css/custom-style.css";

//Dynamic CSS - Location of dynamic-style.php that is inside the themes folder
include_once("../themes/".themeOption."/css/dynamic-style.php");

//check if file is writable
if (!is_writable($fileToEdit_dir)) {
    die("<div class='alert alert-danger fade in'>Unable to write to ".$fileToEdit_dir.". Check file permissions.</div>");
}

//open file for Reading
$handle = fopen($fileToEdit_dir, 'r');
$fileData = fread($handle,filesize($fileToEdit_dir));

if ($_POST['save_main']) {

    for ($i = 0; $i < $_POST['element_count']; $i++) {

        $sqlThemeOptions = mysqli_query($db_conn, "SELECT id, themename, selector, property, cssvalue, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND selector='".safeCleanStr($_POST['selector'][$i])."' AND loc_id=" . $_GET['loc_id'] . " ");
        $rowThemeOptions = mysqli_fetch_array($sqlThemeOptions);

        if ($rowThemeOptions['themename'] == themeOption && $rowThemeOptions['selector'] == safeCleanStr($_POST['selector'][$i]) && $rowThemeOptions['property'] == safeCleanStr($_POST['property'][$i])) {
            //Do Update
            $themeOptionUpdate = "UPDATE theme_options SET themename='" . themeOption . "', selector='" . safeCleanStr($_POST['selector'][$i]) . "', property='" . safeCleanStr($_POST['property'][$i]) . "', cssvalue='" . $_POST['cssvalue'][$i] . "', datetime='" . date("Y-m-d H:i:s") . "', loc_id=" . $_GET['loc_id'] . " WHERE themename='" . themeOption . "' AND selector='" . safeCleanStr($_POST['selector'][$i]) . "' AND property='" . safeCleanStr($_POST['property'][$i]) . "' AND loc_id=" . $_GET['loc_id'] . " ";
            mysqli_query($db_conn, $themeOptionUpdate);
        } else {
            //Do Insert
            if ($_POST['cssvalue'][$i] != '#000000') { //Color Picker defaults to #000000 if the value is empty. To check if the value is empty, you have to check if value = #000000
                $themeOptionInsert = "INSERT INTO theme_options (themename, selector, property, cssvalue, datetime, loc_id) VALUES ('" . themeOption . "', '" . safeCleanStr($_POST['selector'][$i]) . "', '" . safeCleanStr($_POST['property'][$i]) . "', '" . $_POST['cssvalue'][$i] . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
                mysqli_query($db_conn, $themeOptionInsert);
            }
        }
    }

    if (file_exists($fileToEdit_dir)) {
        //open file for Writing
        $handle = fopen($fileToEdit_dir, 'w') or die('Unable to write to ' . $fileToEdit_dir . '. Check file permissions.');
        $fileData = sanitizeStr($_POST['edit_file']);
        fwrite($handle, $fileData);

        $pageMsg = "<div class='alert alert-success'>Theme has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='editor.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";

        closedir($handle);
    } else {
        die("<div class='alert alert-danger fade in'>Unable to write to ".$fileToEdit_dir.". Check file permissions.</div>");
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id']; ?>">Home</a></li>
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id']; ?>">Settings</a></li>
            <li><a href="siteoptions.php?loc=<?php echo $_GET['loc_id']; ?>">Site Options</a></li>
            <li class="active">Theme Editor</li>
        </ol>
        <h1 class="page-header">
            Theme Editor (Theme: <?php echo ucwords(themeOption); ?>)
        </h1>
    </div>

    <div class="col-lg-8">
        <?php
        if ($errorMsg !="") {
            echo $errorMsg;
        } else {
            echo $pageMsg;
        }
        if (!is_writable($fileToEdit_dir)) {
            die("<div class='alert alert-danger fade in'>Unable to write to ".$fileToEdit_dir.". Check file permissions.</div>");
        }
        ?>
        <form name="editForm" class="dirtyForm" method="post">

            <?php

            //Check if dynamic-style.php variables exist
            if (isset($themeCssSelectors) && isset($themeCssProperties)){
                echo "<small>&nbsp;&nbsp;Change the theme base colors.</small>";
                echo "<div class='well'>";

                $elementCount = 0;
                //Gets the themeproperties from $fileDynamicCSS_dir
                foreach ($themeCssSelectors as $key => $value) {
                    $elementCount ++;
                    //Gets themeoptions
                    $sqlThemeOptions = mysqli_query($db_conn, "SELECT id, themename, selector, property, cssvalue, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND selector='".$themeCssSelectors[$key]."' AND property='".$themeCssProperties[$key]."' AND loc_id=" . $_GET['loc_id'] . " ");
                    $rowThemeOptions = mysqli_fetch_array($sqlThemeOptions);
                    echo "<div class='form-group'>".$themeCssSelectors[$key].": <input type='hidden' name='selector[]' value='".$themeCssSelectors[$key]."'><input type='hidden' name='property[]' value='".$themeCssProperties[$key]."' ><input type='color' name='cssvalue[]' value='".$rowThemeOptions['cssvalue']."'></div>";
                }

                echo "<input type='hidden' name='element_count' value='".$elementCount."'>";
                echo "</div>";
            }

            ?>

            <div class="form-group">
                <label for="edit_file"><?php echo $fileToEdit_dir; ?></label>
                <small>
                    &nbsp;&nbsp;Over-ride theme CSS styles or add your own CSS.
                </small>
                <textarea id="edit_file" class="form-control" name="edit_file" rows="60"><?php echo $fileData; ?></textarea>
            </div>
            <div class="form-group">
            <span><small>
                <?php
                if (file_exists($fileToEdit_dir)) {
                    echo "Updated: ".date('m-d-Y, H:i:s',filemtime($fileToEdit_dir));
                }
                ?>
            </small></span>
            </div>
            <input type="hidden" name="save_main" value="true"/>
            <button type="submit" name="editor_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>

    </div>
</div><!--close main container-->

<!--CodeMirror JS & CSS -->
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        if ($('#edit_file').length){
            var editor = CodeMirror.fromTextArea(document.getElementById('edit_file'), {
                lineNumbers: true,
                mode: 'text/css',
                autofocus: true,
                matchBrackets: true,
                styleActiveLine: true,
                indentWithTabs: true
            });
            setTimeout(function() {
                editor.refresh();
            }, 300);
        }
    });
</script>
<style type="text/css">
    .CodeMirror {
        position: relative;
        border: 1px solid #eee;
        overflow: hidden;
        background: #fff;
        height: 500px;
        width: 100%;
    }
</style>
<?php

include_once('includes/footer.inc.php');
?>