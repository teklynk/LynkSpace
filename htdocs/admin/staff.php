<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'staff.php';

$deleteConfirm = '';
$delteamId     = isset( $_GET['team_title'] ) ? safeCleanStr( $_GET['team_title'] ) : null;
$delteamTitle  = isset( $_GET['deletetitle'] ) ? safeCleanStr( $_GET['deletetitle'] ) : null;
$getTeamToken  = isset( $_GET['token'] ) ? safeCleanStr( $_GET['token'] ) : null;
$getNewTeam    = isset( $_GET['newteam'] ) ? safeCleanStr( $_GET['newteam'] ) : null;
$theTeamGuid   = isset( $_GET['guid'] ) ? safeCleanStr( $_GET['guid'] ) : null;
$pagePreviewId = isset( $_GET['preview'] ) ? safeCleanStr( $_GET['preview'] ) : null;
$theTeamId     = isset( $_GET['editteam'] ) ? safeCleanStr( $_GET['editteam'] ) : null;

//Page preview
if ( $pagePreviewId > "" ) {

	$sqlteamPreview = mysqli_query( $db_conn, "SELECT id, title, image, content, name, loc_id FROM team WHERE id=" . $pagePreviewId . " AND loc_id=" . $_SESSION['loc_id'] . ";" );
	$rowTeamPreview = mysqli_fetch_array( $sqlteamPreview, MYSQLI_ASSOC );

	echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
	echo "<div class='col-lg-12'>";

	if ( $rowTeamPreview['image'] > "" ) {
		echo "<p><img src='" . $rowTeamPreview['image'] . "' style='max-width:350px; max-height:150px;' /></p>";
	}

	if ( $rowTeamPreview['name'] > "" ) {
		echo "<h4>" . $rowTeamPreview['name'] . "</h4>";
	}

	if ( $rowTeamPreview['title'] > "" ) {
		echo "<p>" . $rowTeamPreview['title'] . "</p>";
	}

	echo "<p>" . $rowTeamPreview['content'] . "</p>";

	echo "<br/><p><b>Page URL:</b> <a href='../staff.php?loc_id=" . loc_id . "' title='Page URL' target='_blank'>staff.php?loc_id=" . loc_id . "</a></p>";

	echo "</div>";
}
?>

<div class="row">
    <div class="col-lg-12">
		<?php
		if ( $getNewTeam == 'true' ) {
			echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
            <li><a href='staff.php?loc_id=" . loc_id . "'>Staff</a></li>
            <li class='active'>New Staff Member</li>
            </ol>";
			echo "<h1 class='page-header'>Staff (New) <a href='staff.php' class='btn btn-link' role='button'> Cancel</a></h1>";
		} elseif ( $theTeamId ) {
			echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
            <li><a href='staff.php?loc_id=" . loc_id . "'>Staff</a></li>
            <li class='active'>Edit Staff</li>
            </ol>";
			echo "<h1 class='page-header'>Staff (Edit) <a href='staff.php' role='button' class='btn btn-link'> Cancel</a></h1>";
		} else {
			echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
            <li class='active'>Staff</li>
            </ol>";
			echo "<h1 class='page-header'>Staff&nbsp;";
			echo "<button type='button' data-toggle='tooltip' data-placement='bottom' title='Preview the Staff Page' class='btn btn-info' onclick=\"showMyModal('../staff.php?loc_id=" . loc_id . "', '../staff.php?loc_id=" . loc_id . "#team')\"><i class='fa fa-eye'></i></button>";
			echo "</h1>";
		}
		?>
    </div>
</div>

<?php echo flashMessageGet( 'success' ); ?>

<div class="row">
    <div class="col-lg-12">
		<?php

		if ( $getNewTeam == 'true' || $theTeamId ) {

			$teamLabel      = "Edit Staff Title";
			$theTeamName    = isset( $_POST['team_name'] ) ? safeCleanStr( addslashes( $_POST['team_name'] ) ) : null;
			$theTeamTitle   = isset( $_POST['team_title'] ) ? safeCleanStr( addslashes( $_POST['team_title'] ) ) : null;
			$theTeamContent = isset( $_POST['team_content'] ) ? $_POST['team_content'] : null;
			$theTeamImage   = isset( $_POST['team_image'] ) ? sqlEscapeStr( $_POST['team_image'] ) : null;


			$sqlteam = mysqli_query( $db_conn, "SELECT id, title, image, content, name, sort, active, author_name, datetime FROM team WHERE id='$theTeamId' AND loc_id=" . loc_id . ";" );
			$rowTeam = mysqli_fetch_array( $sqlteam, MYSQLI_ASSOC );

			//Update existing team
			if ( $theTeamId ) {

				//update data on submit
				if ( ! empty( $theTeamName ) ) {

					$teamUpdate = "UPDATE team SET title='" . $theTeamTitle . "', content='" . $theTeamContent . "', name='" . $theTeamName . "', image='" . $theTeamImage . "', author_name='" . $_SESSION['user_name'] . "' WHERE id=" . $theTeamId . " AND loc_id=" . loc_id . " AND guid='" . $theTeamGuid . "';";
					mysqli_query( $db_conn, $teamUpdate );

					flashMessageSet( 'success', $theTeamName . " has been updated." );

					//Redirect back to uploads page
					header( "Location: staff.php?loc_id=" . loc_id . "", true, 302 );
					echo "<script>window.location.href='staff.php?loc_id=" . loc_id . "';</script>";
					exit();
				}

				//Create new team
			} elseif ( $getNewTeam ) {

				$teamLabel = "New Staff Title";

				//insert data on submit
				if ( ! empty( $theTeamTitle ) ) {
					$teamInsert = "INSERT INTO team (title, content, guid, image, name, sort, active, author_name, loc_id) VALUES ('" . $theTeamTitle . "', '" . $theTeamContent . "', '" . getGuid() . "', '" . $theTeamImage . "', '" . $theTeamName . "', 0, 'false', '" . $_SESSION['user_name'] . "', " . loc_id . ");";
					mysqli_query( $db_conn, $teamInsert );

					flashMessageSet( 'success', $theTeamName . " has been added." );

					//Redirect back to uploads page
					header( "Location: staff.php?loc_id=" . loc_id . "", true, 302 );
					echo "<script>window.location.href='staff.php?loc_id=" . loc_id . "';</script>";
					exit();

				}
			}

			if ( $rowTeam['image'] == '' ) {
				$thumbNail = "//placehold.it/140x100&text=No Image";
			} else {
				$thumbNail = $rowTeam['image'];
			}
			?>
            <div class="col-lg-8">
                <form name="teamForm" class="dirtyForm" method="post">

                    <div class="form-group">
                        <img src="<?php echo $thumbNail; ?>" id="team_image_preview"
                             style="max-width:140px; height:auto; background-color: #ccc;"/>
                    </div>
                    <div class="form-group">
                        <label for="team_image">Use an Existing Image</label>
                        <select class="form-control selectpicker show-tick" data-container="body"
                                data-dropup-auto="false" data-size="10" name="team_image" id="team_image"
                                title="Choose an existing image">
                            <option value="">None</option>
							<?php
							echo getImageDropdownList( loc_id, $rowTeam['image'] );
							?>
                        </select>
                    </div>
                    <hr/>
                    <div class="form-group required">
                        <label>Name</label>
                        <input type="text" class="form-control count-text" name="team_name" maxlength="255"
                               value="<?php if ( $theTeamId ) {
							       echo $rowTeam['name'];
						       } ?>" placeholder="Name" autofocus required>
                    </div>
                    <div class="form-group required">
                        <label>Title</label>
                        <input type="text" class="form-control count-text" name="team_title" maxlength="255"
                               value="<?php if ( $theTeamId ) {
							       echo $rowTeam['title'];
						       } ?>" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control count-text" rows="3" name="team_content" placeholder="Text"
                                  maxlength="999"><?php if ( $theTeamId ) {
								echo $rowTeam['content'];
							} ?></textarea>
                    </div>

                    <input type="hidden" name="csrf" value="<?php echo csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                    <button type="submit" name="team_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i>
                        Save Changes
                    </button>
                    <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

                </form>
            </div>
			<?php
		} else {

			//delete team
			if ( $delteamId && $delteamTitle && ! $_GET['confirm'] ) {

				showModalConfirm(
					"confirm",
					"Delete Staff?",
					"Are you sure you want to delete: " . $delteamTitle . "?",
					"staff.php?loc_id=" . loc_id . "&deleteteam=" . $delteamId . "&deletetitle=" . $delteamTitle . "&confirm=yes&guid=" . $theTeamGuid . "&token=" . $_SESSION['unique_referrer'] . "",
					false
				);

			} elseif ( $delteamId && $delteamTitle && $_GET['confirm'] == 'yes' && $theTeamGuid && $getTeamToken == $_SESSION['unique_referrer'] ) {
				//delete team after clicking Yes
				$teamDelete = "DELETE FROM team WHERE id=" . $delteamId . " AND guid='" . $theTeamGuid . "' AND loc_id=" . loc_id . ";";
				mysqli_query( $db_conn, $teamDelete );

				flashMessageSet( 'success', $delteamTitle . " has been deleted." );

				//Redirect back to main page
				header( "Location: staff.php?loc_id=" . loc_id . "", true, 302 );
				echo "<script>window.location.href='staff.php?loc_id=" . loc_id . "';</script>";
				exit();
			}

			//update heading on submit
			if ( isset( $_POST['save_main'] ) ) {
				$setupTeamHeading = isset( $_POST['team_heading'] ) ? safeCleanStr( $_POST['team_heading'] ) : null;
				$setupTeamContent = isset( $_POST['main_content'] ) ? safeCleanStr( $_POST['main_content'] ) : null;
				$postTeamCount    = isset( $_POST['team_count'] ) ? safeCleanStr( $_POST['team_count'] ) : null;
				$postTeamSort     = isset( $_POST['team_sort'] ) ? safeCleanStr( $_POST['team_sort'] ) : null;
				$postTeamId       = isset( $_POST['team_id'] ) ? safeCleanStr( $_POST['team_id'] ) : null;

				$setupUpdate = "UPDATE setup SET teamheading='" . $setupTeamHeading . "', teamcontent='" . $setupTeamContent . "', datetime='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . loc_id . ";";
				mysqli_query( $db_conn, $setupUpdate );

				for ( $i = 0; $i < $postTeamCount; $i ++ ) {

					$teamUpdate = "UPDATE team SET sort=" . $postTeamSort[ $i ] . " WHERE id=" . $postTeamId[ $i ] . ";";
					mysqli_query( $db_conn, $teamUpdate );

				}

				flashMessageSet( 'success', "The staff has been updated." );

				//Redirect back to uploads page
				header( "Location: staff.php?loc_id=" . loc_id . "", true, 302 );
				echo "<script>window.location.href='staff.php?loc_id=" . loc_id . "';</script>";
				exit();
			}

			$sqlSetup = mysqli_query( $db_conn, "SELECT teamheading, team_use_defaults, teamcontent FROM setup WHERE loc_id=" . loc_id . ";" );
			$rowSetup = mysqli_fetch_array( $sqlSetup, MYSQLI_ASSOC );

			//Modal preview box
			showModalPreview( "webpageDialog" );

			//use default view
			if ( $rowSetup['team_use_defaults'] == 'true' ) {
				$selDefaults = ' CHECKED ';
			} else {
				$selDefaults = '';
			}

			if ( loc_id != 1 ) {
				?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" id="teamdefaults">
                            <label for="team_defaults">Use Defaults</label>
                            <div class="checkbox">
                                <label>
                                    <input class="team_defaults_checkbox defaults-toggle"
                                           id="<?php echo loc_id ?>" name="team_defaults"
                                           type="checkbox" <?php if ( loc_id ) {
										echo $selDefaults;
									} ?> data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
				<?php
			}
			?>

            <button type="button" class="btn btn-primary"
                    onclick="window.location='?newteam=true&loc_id=<?php echo loc_id; ?>';"><i
                        class='fa fa-fw fa-plus'></i> Add a New Staff Member
            </button>
            <h2></h2>
            <div>

                <form name="teamForm" class="dirtyForm" method="post" action="">
                    <div class="form-group required">
                        <label>Heading</label>
                        <input type="text" class="form-control count-text" name="team_heading" maxlength="255"
                               value="<?php echo $rowSetup['teamheading']; ?>" placeholder="My team" autofocus required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="3" class="form-control count-text" name="main_content"
                                  placeholder="About our team"
                                  maxlength="255"><?php echo $rowSetup['teamcontent']; ?></textarea>
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
						$teamCount = '';
						$sqlTeam   = mysqli_query( $db_conn, "SELECT id, title, image, content, guid, name, sort, active, loc_id FROM team WHERE loc_id=" . loc_id . " ORDER BY sort, title ASC;" );
						while ( $rowTeam = mysqli_fetch_array( $sqlTeam, MYSQLI_ASSOC ) ) {
							$teamId      = $rowTeam['id'];
							$teamTitle   = $rowTeam['title'];
							$teamName    = safeCleanStr( addslashes( $rowTeam['name'] ) );
							$teamContent = $rowTeam['content'];
							$teamActive  = $rowTeam['active'];
							$teamSort    = $rowTeam['sort'];
							$teamGuid    = $rowTeam['guid'];
							$teamCount ++;

							if ( $rowTeam['active'] == 'true' ) {
								$isActive = ' CHECKED ';
							} else {
								$isActive = '';
							}

							echo "<tr>
                        <td class='col-xs-1'>
                        <input class='form-control' name='team_sort[]' value='" . $teamSort . "' type='number' maxlength='3' required>
                        </td>
                        <td>
                        <a href='staff.php?loc_id=" . loc_id . "&editteam=" . $teamId . "&guid=" . $teamGuid . "' title='Edit'>" . $teamName . "</a>
                        <input type='hidden' name='team_id[]' value='" . $teamId . "' >
                        </td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Staff Active' class='checkbox team_status_checkbox' id='" . $teamId . "' type='checkbox' " . $isActive . ">
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . $teamName . "', 'staff.php?loc_id=" . loc_id . "&preview=" . $teamId . "')\"><i class='fa fa-fw fa-eye'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='staff.php?loc_id=" . loc_id . "&deleteteam=" . $teamId . "&deletetitle=" . $teamName . "&guid=" . $teamGuid . "'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
						}
						?>
                        </tbody>
                    </table>

                    <input type="hidden" name="csrf" value="<?php echo csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                    <input type="hidden" name="save_main" value="true"/>
                    <input type="hidden" name="team_count" value="<?php echo $teamCount; ?> "/>
                    <button type="submit" name="teamNew_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>
                        Save Changes
                    </button>
                    <button type="reset" class="btn btn-default"><i class="fa fa-fw fa-reply"></i> Reset</button>
                </form>
            </div>
			<?php
		} //end of long else

		echo "</div>
	</div>
	<p></p>";
		?>
        <!-- Modal javascript logic -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#confirm').on('hidden.bs.modal', function () {
                    setTimeout(function () {
                        window.location.href = 'staff.php?loc_id=<?php echo loc_id; ?>';
                    }, 100);
                });

                var url = window.location.href;
                if (url.indexOf('deleteteam') != -1 && url.indexOf('confirm') == -1) {
                    setTimeout(function () {
                        $('#confirm').modal('show');
                    }, 100);
                }
            });
        </script>
		<?php
		require_once( __DIR__ . '/includes/footer.inc.php' );
		?>
