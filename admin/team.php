<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'team.php';

//Page preview
if ($_GET['preview'] > "") {

    $pagePreviewId = $_GET['preview'];

    $sqlteamPreview = mysqli_query($db_conn, "SELECT id, title, image, content, name, loc_id FROM team WHERE id=" . $pagePreviewId . " AND loc_id=" . $_SESSION['loc_id'] . " ");
    $rowTeamPreview = mysqli_fetch_array($sqlteamPreview);

    echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
    echo "<div class='col-lg-12'>";

    if ($rowTeamPreview['image'] > "") {
        echo "<p><img src='../uploads/" . $_SESSION['loc_id'] . "/" . $rowTeamPreview['image'] . "' style='max-width:350px; max-height:150px;' /></p>";
    }

    if ($rowTeamPreview['name'] > "") {
        echo "<h4>" . $rowTeamPreview['name'] . "</h4>";
    }

    if ($rowTeamPreview['title'] > "") {
        echo "<p>" . $rowTeamPreview['title'] . "</p>";
    }

    echo "<p>" . $rowTeamPreview['content'] . "</p>";

    echo "<br/><p><b>Page URL:</b> <a href='../team.php?loc_id=" . $_GET['loc_id'] . "' title='Page URL' target='_blank'>team.php?loc_id=" . $_GET['loc_id'] . "</a></p>";

    echo "</div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <?php
        if ($_GET['newteam'] == 'true') {
            echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='team.php?loc=" . $_GET['loc_id'] . "'>Team</a></li>
            <li class='active'>New Team Member</li>
            </ol>";
            echo "<h1 class='page-header'>Team (New) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
        } elseif ($_GET['editteam']) {
            echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li><a href='team.php?loc=" . $_GET['loc_id'] . "'>Team</a></li>
            <li class='active'>Edit Team</li>
            </ol>";
            echo "<h1 class='page-header'>Team (Edit) <button type='button' class='btn btn-link' onclick='window.history.go(-1)'> Cancel</button></h1>";
        } else {
            echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc=" . $_GET['loc_id'] . "'>Home</a></li>
            <li class='active'>Team</li>
            </ol>";
            echo "<h1 class='page-header'>Team&nbsp;";
            echo "<button type='button' data-toggle='tooltip' data-placement='bottom' title='Preview the Team Page' class='btn btn-info' onclick=\"showMyModal('team.php?loc_id=".$_GET['loc_id']."', '../team.php?loc_id=".$_GET['loc_id']."')\"><i class='fa fa-eye'></i></button>";
            echo "</h1>";
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php

        if ($_GET['newteam'] || $_GET['editteam']) {

            $teamMsg = "";

            //Update existing team
            if ($_GET['editteam']) {
                $theteamId = $_GET['editteam'];
                $teamLabel = "Edit Team Title";

                //update data on submit
                if (!empty($_POST['team_name'])) {

                    $teamUpdate = "UPDATE team SET title='" . safeCleanStr($_POST['team_title']) . "', content='" . sqlEscapeStr($_POST['team_content']) . "', name='" . safeCleanStr($_POST['team_name']) . "', image='" . $_POST['team_image'] . "', author_name='" . $_SESSION['user_name'] . "' WHERE id='$theteamId' AND loc_id=" . $_GET['loc_id'] . " ";
                    mysqli_query($db_conn, $teamUpdate);

                    $teamMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='team.php?loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The team member " . safeCleanStr($_POST['team_name']) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                }

                $sqlteam = mysqli_query($db_conn, "SELECT id, title, image, content, name, sort, active, author_name, datetime FROM team WHERE id='$theteamId' AND loc_id=" . $_GET['loc_id'] . " ");
                $rowTeam = mysqli_fetch_array($sqlteam);

                //Create new team
            } elseif ($_GET['newteam']) {

                $teamLabel = "New Team Title";

                //insert data on submit
                if (!empty($_POST['team_title'])) {
                    $teamInsert = "INSERT INTO team (title, content, image, name, sort, active, author_name, loc_id) VALUES ('" . sqlEscapeStr($_POST['team_title']) . "', '" . safeCleanStr($_POST['team_content']) . "', '" . $_POST['team_image'] . "', '" . safeCleanStr($_POST['team_name']) . "', 0, 'false', '" . $_SESSION['user_name'] . "', " . $_GET['loc_id'] . ")";
                    mysqli_query($db_conn, $teamInsert);

                    header("Location: team.php?loc_id=" . $_GET['loc_id'] . "");
                    echo "<script>window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "';</script>";

                }
            }

            //alert messages
            if ($teamMsg != "") {
                echo $teamMsg;
            }

            if ($rowTeam['image'] == "") {
                $thumbNail = "//placehold.it/140x100&text=No Image";
            } else {
                $thumbNail = "../uploads/" . $_GET['loc_id'] . "/" . $rowTeam['image'];
            }
            ?>
            <div class="col-lg-8">
            <form name="teamForm" class="dirtyForm" method="post" action="">

                <div class="form-group">
                    <img src="<?php echo $thumbNail; ?>" id="team_image_preview" style="max-width:140px; height:auto; background-color: #ccc;"/>
                </div>
                <div class="form-group">
                    <label>Use an Existing Image</label>
                    <select class="form-control" name="team_image" id="team_image">
                        <option value="">None</option>
                        <?php
                        getImageDropdownList(image_dir, $rowTeam['image']);
                        ?>
                    </select>
                </div>
                <hr/>
                <div class="form-group required">
                    <label>Name</label>
                    <input type="text" class="form-control count-text" name="team_name" maxlength="255" value="<?php if ($_GET['editteam']) {echo $rowTeam['name'];} ?>" placeholder="Name" autofocus required>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control count-text" name="team_title" maxlength="255" value="<?php if ($_GET['editteam']) {echo $rowTeam['title'];} ?>" placeholder="Title">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control count-text" rows="3" name="team_content" placeholder="Text" maxlength="999"><?php if ($_GET['editteam']) {echo $rowTeam['content'];} ?></textarea>
                </div>

                <button type="submit" name="team_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

            </form>
            </div>
            <?php
        } else {
            $deleteMsg = "";
            $deleteConfirm = "";
            $teamMsg = "";
            $delteamId = $_GET['deleteteam'];
            $delteamTitle = $_GET['deletetitle'];

            //delete team
            if ($_GET['deleteteam'] && $_GET['deletetitle'] && !$_GET['confirm']) {

                $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $delteamTitle . "? <a href='?deleteteam=" . $delteamId . "&deletetitle=" . safeCleanStr(addslashes($delteamTitle)) . "&confirm=yes' class='alert-link'><i class='fa fa-fw fa-trash'></i> Delete</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;

            } elseif ($_GET['deleteteam'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes') {
                //delete team after clicking Yes
                $teamDelete = "DELETE FROM team WHERE id='$delteamId'";
                mysqli_query($db_conn, $teamDelete);

                $deleteMsg = "<div class='alert alert-success'>" . $delteamTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //update heading on submit
            if (($_POST['save_main'])) {

                $setupUpdate = "UPDATE setup SET teamheading='" . safeCleanStr($_POST['team_heading']) . "', teamcontent='" . sqlEscapeStr($_POST['main_content']) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
                mysqli_query($db_conn, $setupUpdate);

                for ($i = 0; $i < $_POST['team_count']; $i++) {

                    $teamUpdate = "UPDATE team SET sort=" . safeCleanStr($_POST['team_sort'][$i]) . " WHERE id=" . $_POST['team_id'][$i] . " ";
                    mysqli_query($db_conn, $teamUpdate);

                }

                $teamMsg = "<div class='alert alert-success'>The team has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
            }

            $sqlSetup = mysqli_query($db_conn, "SELECT teamheading, team_use_defaults, teamcontent FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
            $rowSetup = mysqli_fetch_array($sqlSetup);
            ?>
            <!--modal preview window-->

            <style>
                #webpageDialog iframe {
                    width: 100%;
                    height: 600px;
                    border: none;
                }

                .modal-dialog {
                    width: 95%;
                }
            </style>

            <div class="modal fade" id="webpageDialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a type="button" class="close" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                            </a>
                            <h4 class="modal-title">&nbsp;</h4>
                        </div>
                        <div class="modal-body">
                            <iframe id="myModalFile" src="" frameborder="0"></iframe>
                        </div>
                        <div class="modal-footer">&nbsp;</div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <?php
            //use default view
            if ($rowSetup['team_use_defaults'] == 'true') {
                $selDefaults = "CHECKED";
            } else {
                $selDefaults = "";
            }

            if ($_GET['loc_id'] != 1) {
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="teamdefaults">
                            <label>Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="team_defaults_checkbox defaults-toggle" id="<?php echo $_GET['loc_id'] ?>" name="team_defaults" type="checkbox" <?php if ($_GET['loc_id']) {echo $selDefaults;} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <?php
            }
            ?>

            <button type="button" class="btn btn-primary" onclick="window.location='?newteam=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-plus'></i> Add a New Team Member</button>
            <h2></h2>
            <div class="table-responsive">
                <?php
                if ($teamMsg != "") {
                    echo $teamMsg;
                }
                ?>
                <form role="teamForm" class="dirtyForm" method="post" action="">
                    <div class="form-group required">
                        <label>Heading</label>
                        <input type="text" class="form-control count-text" name="team_heading" maxlength="255" value="<?php echo $rowSetup['teamheading']; ?>" placeholder="My team" autofocus required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="3" class="form-control count-text" name="main_content" placeholder="About our team" maxlength="255"><?php echo $rowSetup['teamcontent']; ?></textarea>
                    </div>
                    <table class="table table-bordered table-hover table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Name</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $teamCount = "";
                        $sqlTeam = mysqli_query($db_conn, "SELECT id, title, image, content, name, sort, active, loc_id FROM team WHERE loc_id=" . $_GET['loc_id'] . " ORDER BY sort, title ASC");
                        while ($rowTeam = mysqli_fetch_array($sqlTeam)) {
                            $teamId = $rowTeam['id'];
                            $teamTitle = $rowTeam['title'];
                            $teamName = $rowTeam['name'];
                            $teamContent = $rowTeam['content'];
                            $teamActive = $rowTeam['active'];
                            $teamSort = $rowTeam['sort'];
                            $teamCount++;

                            if ($rowTeam['active'] == 'true') {
                                $isActive = "CHECKED";
                            } else {
                                $isActive = "";
                            }

                            echo "<tr>
                        <td class='col-xs-1'>
                        <input class='form-control' name='team_sort[]' value='" . $teamSort . "' type='text' maxlength='3' required>
                        </td>
                        <td>
                        <a href='team.php?loc_id=" . $_GET['loc_id'] . "&editteam=$teamId' title='Edit'>" . $teamName . "</a>
                        <input type='hidden' name='team_id[]' value='" . $teamId . "' >
                        </td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Team Active' class='checkbox team_status_checkbox' id='" . $teamId . "' type='checkbox' " . $isActive . ">
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . safeCleanStr($teamName) . "', 'team.php?loc_id=" . $_GET['loc_id'] . "&preview=$teamId')\"><i class='fa fa-fw fa-eye'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "&deleteteam=$teamId&deletetitle=" . safeCleanStr(addslashes($teamName)) . "'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="save_main" value="true"/>
                    <input type="hidden" name="team_count" value="<?php echo $teamCount; ?> "/>
                    <button type="submit" name="teamNew_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save Changes</button>
                    <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
                </form>
            </div>
            <?php
        } //end of long else

        echo "</div>
	</div>
	<p></p>";

        include_once('includes/footer.inc.php');
        ?>
