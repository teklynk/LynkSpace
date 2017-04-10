<?php
session_start();
define('inc_access', TRUE);

include_once('includes/header.inc.php');

//check if user is logged in and is admin and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_GET['newlocation'] != 'true' && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'setup.php') {

    $fileToEdit_dir = $_GET['section'];
    $pageMsg="";

    //array of allowed files that can be edited
    $editFileListArr = array("../themes/".$themeOption."/css/custom-style.css");

    $editFileListArrlength = count($editFileListArr);
    $editFileListStr = "";

    //loop through the array of $editFileListArr
    for ($x = 0; $x < $editFileListArrlength; $x++) {

        if ($editFileListArr[$x] == $_GET['section']) {

            $isSectionSelected = "SELECTED";

        } else {

            $isSectionSelected = "";

        }

        $editFileListStr .= "<option value=" . $editFileListArr[$x] . " " . $isSectionSelected . ">" . $editFileListArr[$x] . "</option>";

        $editFileListArrFirstItem = $editFileListArr[0];
    }

    //Redirect to section=firstarrayitem if section is not in querystring
    if ($_GET['section'] == "" && $_GET['loc_id']) {
        header("Location: editor.php?section=" . $editFileListArrFirstItem . "&loc_id=" . $_GET['loc_id'] . "");
        echo "<script>window.location.href='editor.php?section=" . $editFileListArrFirstItem . "&loc_id=" . $_GET['loc_id'] . "';</script>";
    }

    //do not open file if it is not in the array of allowed files
    if (!in_array($fileToEdit_dir, $editFileListArr, true)) {
        die('Cannot access: ' . $fileToEdit_dir);
    }

    //open file for Reading
    $handle = fopen($fileToEdit_dir, 'r');
    $fileData = fread($handle,filesize($fileToEdit_dir));

    if ($_POST['save_main']) {
        //check if file is in the array
        if (in_array($fileToEdit_dir, $editFileListArr, true)) {
            if (file_exists($fileToEdit_dir)) {
                //open file for Writing
                $handle = fopen($fileToEdit_dir, 'w') or die('Cannot write to file: ' . $fileToEdit_dir . '. Check file permissions.');
                $fileData = sanitizeStr($_POST['edit_file']);
                fwrite($handle, $fileData);

                $pageMsg = "<div class='alert alert-success'>" . $fileToEdit_dir . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='editor.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";

                closedir($handle);
            }
        } else {
            die('Cannot write to: ' . $fileToEdit_dir);
        }
    }
    ?>

        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="setup.php?loc=<?php echo $_GET['loc_id']; ?>">Home</a></li>
                    <li><a href="editor.php?loc=<?php echo $_GET['loc_id']; ?>">File Editor</a></li>
                    <li class="active">Section: <?php echo $_GET['section']; ?></li>
                </ol>
                <h1 class="page-header">
                    File Editor
                </h1>
            </div>

            <div class="col-lg-8">
                <?php
                if ($pageMsg !="") {
                    echo $pageMsg;
                }
                ?>
                <form name="editForm" class="dirtyForm" method="post" action="">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nav_menu">Files</label>
                                <select class="form-control" name="nav_menu" id="nav_menu" autofocus="autofocus">
                                    <?php echo $editFileListStr; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr/>

                    <div class="form-group">
                        <label><?php echo $fileToEdit_dir; ?></label>
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
    <script>
        $(document).ready(function(){
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
            }, 500);
        });
    </script>
    <style>
        .CodeMirror {
            position: relative;
            border: 1px solid #eee;
            border-radius: 5px;
            height: auto;
            width: 100%;
        }
    </style>
<?php
} else {
    die('Direct access not permitted');
}
include_once('includes/footer.inc.php');
?>