<?php
session_start();
define('inc_access', TRUE);
define('codeMirror', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'editor.php';

// Only allow Admin users have access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1) {
    header('Location: index.php?logout=true', true, 301);
    echo "<script>window.location.href='index.php?logout=true';</script>";
}

$pageMsg = "";

//css file that can be edited
$fileToEdit_dir = "../themes/" . themeOption . "/css/custom-style.css";

//Dynamic CSS - Location of dynamic-style.php that is inside the themes folder
require_once(__DIR__ . "/../themes/" . themeOption . "/css/dynamic-style.php");

//check if file is writable
if (!is_writable($fileToEdit_dir)) {
    die("<div class='alert alert-danger fade in'>Unable to write to " . $fileToEdit_dir . ". Check file permissions.</div>");
}

//open file for Reading
$handle = fopen($fileToEdit_dir, 'r');
$fileData = fread($handle, filesize($fileToEdit_dir));

if ($_POST['save_main']) {

    $theme_defaults = $_POST['theme_defaults'];
    $element_count = $_POST['element_count'];
    $edit_file = sanitizeStr($_POST['edit_file']);

    //use theme defaults
    if ($theme_defaults == 'on') {
        $theme_defaults = 'true';
    } else {
        $theme_defaults = 'false';
    }

    for ($i = 0; $i < $element_count; $i++) {

        $selector = $_POST['selector'][$i];
        $property = $_POST['property'][$i];
        $cssvalue = $_POST['cssvalue'][$i];

        $sqlThemeOptions = mysqli_query($db_conn, "SELECT id, themename, selector, property, cssvalue, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND selector='" . $selector . "' AND loc_id=" . $_GET['loc_id'] . ";");
        $rowThemeOptions = mysqli_fetch_array($sqlThemeOptions, MYSQLI_ASSOC);

        if ($rowThemeOptions['themename'] == themeOption && $rowThemeOptions['selector'] == $selector && $rowThemeOptions['property'] == $property) {
            //Do Update
            $themeOptionUpdate = "UPDATE theme_options SET themename='" . themeOption . "', selector='" . $selector . "', property='" . $property . "', cssvalue='" . $cssvalue . "', datetime='" . date("Y-m-d H:i:s") . "', loc_id=" . $_GET['loc_id'] . " WHERE themename='" . themeOption . "' AND selector='" . $selector . "' AND property='" . $property . "' AND loc_id=" . $_GET['loc_id'] . ";";
            mysqli_query($db_conn, $themeOptionUpdate);
        } else {
            //Do Insert
            if ($cssvalue[$i] != '#000000') { //Color Picker defaults to #000000 if the value is empty. To check if the value is empty, you have to check if value = #000000
                $themeOptionInsert = "INSERT INTO theme_options (themename, selector, property, cssvalue, datetime, loc_id) VALUES ('" . themeOption . "', '" . $selector . "', '" . $property . "', '" . $cssvalue . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
                mysqli_query($db_conn, $themeOptionInsert);
            }
        }
    }

    //Update Setup
    $setupUpdate = "UPDATE setup SET theme_use_defaults='" . $theme_defaults . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . ";";
    mysqli_query($db_conn, $setupUpdate);

    //Only Default location can see this
    if ($_GET['loc_id'] == 1) {
        if (file_exists($fileToEdit_dir)) {
            //open file for Writing
            $handle = fopen($fileToEdit_dir, 'w') or die('Unable to write to ' . $fileToEdit_dir . '. Check file permissions.');
            $fileData = $edit_file;
            fwrite($handle, $fileData);

            closedir($handle);
        } else {
            die("<div class='alert alert-danger fade in'>Unable to write to " . $fileToEdit_dir . ". Check file permissions.</div>");
        }
    }

    $pageMsg = "<div class='alert alert-success'>Theme has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='editor.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";

}

//Get setup table columns
$sqlSetup = mysqli_query($db_conn, "SELECT theme_use_defaults, loc_id FROM setup WHERE loc_id=" . $_GET['loc_id'] . ";");
$rowSetup = mysqli_fetch_array($sqlSetup, MYSQLI_ASSOC);
?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo $_GET['loc_id']; ?>">Home</a></li>
                <li class="active">Theme Editor</li>
            </ol>
            <h1 class="page-header">
                Theme Editor
            </h1>
        </div>

        <div class="col-lg-8">
            <?php
            if ($errorMsg != "") {
                echo $errorMsg;
            } else {
                echo $pageMsg;
            }
            //use default theme
            if ($rowSetup['theme_use_defaults'] == 'true') {
                $selThemeDefaults = "CHECKED";
            } else {
                $selThemeDefaults = "";
            }
            if (!is_writable($fileToEdit_dir)) {
                die("<div class='alert alert-danger fade in'>Unable to write to " . $fileToEdit_dir . ". Check file permissions.</div>");
            }

            if ($_GET['loc_id'] != 1) {
                ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" id="themedefaults">
                            <label for="theme_defaults">Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="theme_defaults_checkbox defaults-toggle"
                                           id="<?php echo $_GET['loc_id'] ?>" name="theme_defaults"
                                           type="checkbox" <?php if ($_GET['loc_id']) {
                                        echo $selThemeDefaults;
                                    } ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <?php
            }

            echo "<form name='editForm' class='dirtyForm' method='post' action=''>";

            //Check if dynamic-style.php variables exist
            if (isset($themeCssSelectors) && isset($themeCssProperties)){
            echo "<label for='edit_base_theme_options'><i class='fa fa-paint-brush'></i>&nbsp;&nbsp;Theme Colors</label>
                        <small>&nbsp;&nbsp;Change the theme base colors.</small>";
            echo "<div class='well'>";

            $elementCount = 0;

            foreach ($themeCssSelectors

            as $key => $value) {

            $elementCount++;

            //Gets themeoptions
            $sqlThemeOptions = mysqli_query($db_conn, "SELECT id, themename, selector, property, cssvalue, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND selector='" . $themeCssSelectors[$key] . "' AND property='" . $themeCssProperties[$key] . "' AND loc_id=" . $_GET['loc_id'] . ";");
            $rowThemeOptions = mysqli_fetch_array($sqlThemeOptions, MYSQLI_ASSOC);

            echo "<div class='row'>
                        <div class='col-lg-4'>
                            <label for='cssvalue[]'>" . $themeCssLabels[$key] . "</label>
                            <div class='input-group'>
                                <input type='color' data-toggle='tooltip' data-original-title='Click to change color' class='form-control' name='cssvalue[]' id='cssval-" . $elementCount . "' value='" . $rowThemeOptions['cssvalue'] . "'>
                                <input type='hidden' name='selector[]' value='" . $themeCssSelectors[$key] . "'>
                                <input type='hidden' name='property[]' value='" . $themeCssProperties[$key] . "'>";
            ?>
            <span class="input-group-btn">
                                    <button type="button" data-toggle='tooltip' data-original-title='Reset color'
                                            class="btn btn-default" id="reset-color" title='Reset'
                                            onclick="document.getElementById('<?php echo "cssval-" . $elementCount; ?>').value='#000000';"><i
                                                class="fa fa-refresh"></i></button>
                                </span>
        </div>
        <br>
    </div>
    </div>

    <?php
}

    echo "<input type='hidden' name='element_count' value='" . $elementCount . "'>";
    echo "</div>";
}

?>
<?php
//Only Default location can see this
if ($_GET['loc_id'] == 1) {
    ?>
    <div class="form-group">
        <label for="edit_file"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo $fileToEdit_dir; ?></label>
        <small>
            &nbsp;&nbsp;Override theme CSS styles or add your own CSS.
        </small>
        <textarea id="edit_file" class="form-control" name="edit_file" rows="60"><?php echo $fileData; ?></textarea>
    </div>
    <?php
}
?>
    <div class="form-group">
                <span><small>
                    <?php
                    //if (file_exists($fileToEdit_dir)) {
                    //    echo "Updated: ".date('m-d-Y, H:i:s',filemtime($fileToEdit_dir));
                    //}
                    ?>
                </small></span>
    </div>

    <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

    <input type="hidden" name="save_main" value="true"/>
    <button type="submit" name="editor_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes
    </button>
    <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

    </form>

    </div>
    </div><!--close main container-->

    <!--CodeMirror JS & CSS -->
    <script type="text/javascript" language="javascript">
        $(document).ready(function () {
            if ($('#edit_file').length) {
                var editor = CodeMirror.fromTextArea(document.getElementById('edit_file'), {
                    lineNumbers: true,
                    mode: 'text/css',
                    autofocus: false,
                    matchBrackets: true,
                    styleActiveLine: true,
                    indentWithTabs: true
                });
                setTimeout(function () {
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

require_once(__DIR__ . '/includes/footer.inc.php');
?>