<?php
define('inc_access', TRUE);

include_once('includes/header.php');

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
    echo "</div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <?php
        if ($_GET['newteam'] == 'true') {
            echo "<h1 class='page-header'>Team (New)</h1>";
        } else {
            echo "<h1 class='page-header'>Team</h1>";
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php

        if ($_GET['newteam'] OR $_GET['editteam']) {

            $teamMsg = "";

            //Update existing team
            if ($_GET['editteam']) {
                $theteamId = $_GET['editteam'];
                $teamLabel = "Edit Team Title";

                //update data on submit
                if (!empty($_POST['team_title'])) {

                    if ($_POST['team_status'] == 'on') {
                        $_POST['team_status'] = 'true';
                    } else {
                        $_POST['team_status'] = 'false';
                    }

                    $teamUpdate = "UPDATE team SET title='" . safeCleanStr($_POST['team_title']) . "', content='" . mysqli_real_escape_string($db_conn, trim($_POST['team_content'])) . "', name='" . safeCleanStr($_POST['team_name']) . "', image='" . $_POST['team_image'] . "', active='" . $_POST['team_status'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id='$theteamId' AND loc_id=" . $_GET['loc_id'] . " ";
                    mysqli_query($db_conn, $teamUpdate);

                    $teamMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='team.php?loc_id=" . $_GET['loc_id'] . "' class='alert-link'>Back</a> | The team member " . safeCleanStr($_POST['team_name']) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                }

                $sqlteam = mysqli_query($db_conn, "SELECT id, title, image, content, name, active, datetime FROM team WHERE id='$theteamId' AND loc_id=" . $_GET['loc_id'] . " ");
                $rowTeam = mysqli_fetch_array($sqlteam);

                //Create new team
            } else if ($_GET['newteam']) {

                $teamLabel = "New Team Title";

                //insert data on submit
                if (!empty($_POST['team_title'])) {
                    $teamInsert = "INSERT INTO team (title, content, image, name, active, datetime, loc_id) VALUES ('" . mysqli_real_escape_string($db_conn, trim($_POST['team_title'])) . "', '" . safeCleanStr($_POST['team_content']) . "', '" . $_POST['team_image'] . "', '" . safeCleanStr($_POST['team_name']) . "', 'true', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ")";
                    mysqli_query($db_conn, $teamInsert);

                    echo "<script>window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "';</script>";

                }
            }

            //alert messages
            if ($teamMsg != "") {
                echo $teamMsg;
            }

            if ($_GET['editteam']) {
                //active status
                if ($rowTeam['active'] == 'true') {
                    $selActive = "CHECKED";
                } else {
                    $selActive = "";
                }
            }

            if ($rowTeam['image'] == "") {
                $thumbNail = "http://placehold.it/140x100&text=No Image";
            } else {
                $thumbNail = "../uploads/" . $_GET['loc_id'] . "/" . $rowTeam['image'];
            }
            ?>

            <form name="teamForm" method="post" action="">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="teamactive">
                            <label>Active</label>
                            <div class="checkbox">
                                <label>
                                    <input class="team_status_checkbox" id="<?php echo $_GET['editteam'] ?>"
                                           name="team_status" type="checkbox" <?php if ($_GET['editteam']) {
                                        echo $selActive;
                                    } ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="form-group">
                    <img src="<?php echo $thumbNail; ?>" id="team_image_preview" style="max-width:140px; height:auto;"/>
                </div>
                <div class="form-group">
                    <label>Use an Existing Image</label>
                    <select class="form-control input-sm" name="team_image" id="team_image">
                        <option value="">None</option>
                        <?php
                        if ($handle = opendir($target_dir)) {
                            while (false !== ($file = readdir($handle))) {
                                if ('.' === $file) continue;
                                if ('..' === $file) continue;
                                if ($file === "Thumbs.db") continue;
                                if ($file === ".DS_Store") continue;
                                if ($file === "index.html") continue;

                                if ($file === $rowTeam['image']) {
                                    $imageCheck = "SELECTED";
                                } else {
                                    $imageCheck = "";
                                }

                                echo "<option value='" . $file . "' $imageCheck>" . $file . "</option>";
                            }
                            closedir($handle);
                        }
                        ?>
                    </select>
                </div>
                <hr/>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control input-sm count-text" name="team_name" maxlength="255"
                           value="<?php if ($_GET['editteam']) {
                               echo $rowTeam['name'];
                           } ?>" placeholder="Name">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control input-sm count-text" name="team_title" maxlength="255"
                           value="<?php if ($_GET['editteam']) {
                               echo $rowTeam['title'];
                           } ?>" placeholder="Title">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control input-sm count-text" rows="3" name="team_content" placeholder="Text"
                              maxlength="255"><?php if ($_GET['editteam']) {
                            echo $rowTeam['content'];
                        } ?></textarea>
                </div>
                <div class="form-group">
                    <span><small><?php if ($_GET['editteam']) {
                                echo "Updated: " . date('m-d-Y, H:i:s', strtotime($rowTeam['datetime']));
                            } ?></small></span>
                </div>

                <button type="submit" name="team_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save
                    Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Cancel</button>

            </form>

            <?php
        } else {
            $deleteMsg = "";
            $deleteConfirm = "";
            $teamMsg = "";
            $delteamId = $_GET['deleteteam'];
            $delteamTitle = $_GET['deletetitle'];
            $moveteamId = $_GET['moveteam'];
            $moveteamTitle = $_GET['movetitle'];

            //delete team
            if ($_GET['deleteteam'] AND $_GET['deletetitle'] AND !$_GET['confirm']) {

                $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $delteamTitle . "? <a href='?deleteteam=" . $delteamId . "&deletetitle=" . safeCleanStr($delteamTitle) . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;

            } elseif ($_GET['deleteteam'] AND $_GET['deletetitle'] AND $_GET['confirm'] == 'yes') {
                //delete team after clicking Yes
                $teamDelete = "DELETE FROM team WHERE id='$delteamId'";
                mysqli_query($db_conn, $teamDelete);

                $deleteMsg = "<div class='alert alert-success'>" . $delteamTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                echo $deleteMsg;
            }

            //move team to top of list
            if (($_GET['moveteam'] AND $_GET['movetitle'])) {
                $teamDateUpdate = "UPDATE team SET datetime='" . date("Y-m-d H:i:s") . "' WHERE id='$moveteamId'";
                mysqli_query($db_conn, $teamDateUpdate);

                $teamMsg = "<div class='alert alert-success'>" . $moveteamTitle . " has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
            }

            //update heading on submit
            if (($_POST['save_main'])) {
                $setupUpdate = "UPDATE setup SET teamheading='" . safeCleanStr($_POST['team_heading']) . "', teamcontent='" . mysqli_real_escape_string($db_conn, trim($_POST['main_content'])) . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $_GET['loc_id'] . " ";
                mysqli_query($db_conn, $setupUpdate);

                $teamMsg = "<div class='alert alert-success'>The team has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
            }

            $sqlSetup = mysqli_query($db_conn, "SELECT teamheading, teamcontent FROM setup WHERE loc_id=" . $_GET['loc_id'] . " ");
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
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                    class="fa fa-times"></i> Close
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe id="myModalFile" src="" frameborder="0"></iframe>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <button type="button" class="btn btn-primary"
                    onclick="window.location='?newteam=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i
                    class='fa fa-fw fa-plus'></i> Add a New Team Member
            </button>
            <h2></h2>
            <div class="table-responsive">
                <?php
                if ($teamMsg != "") {
                    echo $teamMsg;
                }
                ?>
                <form role="teamForm" method="post" action="">
                    <div class="form-group">
                        <label>Heading</label>
                        <input class="form-control input-sm count-text" name="team_heading" maxlength="255"
                               value="<?php echo $rowSetup['teamheading']; ?>" placeholder="My team" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="3" class="form-control input-sm count-text" name="main_content"
                                  placeholder="About our team"
                                  maxlength="255"><?php echo $rowSetup['teamcontent']; ?></textarea>
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sqlTeam = mysqli_query($db_conn, "SELECT id, title, image, content, name, active, loc_id FROM team WHERE loc_id=" . $_GET['loc_id'] . " ORDER BY datetime DESC");
                        while ($rowTeam = mysqli_fetch_array($sqlTeam)) {
                            $teamId = $rowTeam['id'];
                            $teamTitle = $rowTeam['title'];
                            $teamName = $rowTeam['name'];
                            $teamContent = $rowTeam['content'];
                            $teamActive = $rowTeam['active'];

                            if ($rowTeam['active'] == 'true') {
                                $isActive = "CHECKED";
                            } else {
                                $isActive = "";
                            }

                            echo "<tr>
						<td><a href='team.php?loc_id=" . $_GET['loc_id'] . "&editteam=$teamId' title='Edit'>" . $teamName . "</a></td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Team Active' class='checkbox team_status_checkbox' id='$teamId' type='checkbox' " . $isActive . ">
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . safeCleanStr($teamName) . "', 'team.php?loc_id=" . $_GET['loc_id'] . "&preview=$teamId')\"><i class='fa fa-fw fa-eye'></i></button>
						<button type='button' data-toggle='tooltip' title='Move' class='btn btn-default' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "&moveteam=$teamId&movetitle=" . safeCleanStr($teamName) . "'\"><i class='fa fa-fw fa-arrow-up'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='team.php?loc_id=" . $_GET['loc_id'] . "&deleteteam=$teamId&deletetitle=" . safeCleanStr($teamName) . "'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="save_main" value="true"/>

                    <button type="submit" name="teamNew_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                        Save Changes
                    </button>
                    <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Cancel</button>
                </form>
            </div>
            <?php
        } //end of long else

        echo "</div>
	</div>
	<p></p>";

        include_once('includes/footer.php');
        ?>
