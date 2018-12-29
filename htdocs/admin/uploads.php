<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'uploads.php';

$getUploadGuid = isset( $_GET['guid'] ) ? safeCleanStr( $_GET['guid'] ) : null;
$getUploadId   = isset( $_GET['delete'] ) ? safeCleanStr( $_GET['delete'] ) : null;
$action        = isset( $_POST['action'] ) ? safeCleanStr( $_POST['action'] ) : null;
$getConfirm    = isset( $_GET['confirm'] ) ? safeCleanStr( $_GET['confirm'] ) : null;
$getIsShared   = isset( $_GET['share'] ) ? safeCleanStr( $_GET['share'] ) : null;
$share_location_type = isset( $_POST['share_location_type'] ) ? safeCleanStr( $_POST['share_location_type'] ) : null;
$share_location_list = isset( $_POST['share_location_list'] ) ? safeCleanStr( $_POST['share_location_list'] ) : null;

$fileList = getAllUploads( 1, 'upload', loc_id, 'ASC' ); //returns an array

//Upload Action - Do the upload
if ( ! empty( $_POST ) && $action == 'uploadFile' ) {
//function fileUploads($postAction, $target, $maxFileSize = 2048000, $type = null, $type_id = null, $user = null, $loc_id, $uniqueFileNames = true, $storeOnDb = true, $storeOnDisk = true, $allowedFileTypes = array())

	fileUploads(
		$action == 'uploadFile',
		image_dir,
		2048000,
		'upload',
		loc_id,
		$_SESSION['user_name'],
		loc_id,
		true,
		true,
		true,
		array( 'png', 'gif', 'jpg' )
	);

	flashMessageSet( 'success', 'The file has been uploaded.' );

	//Redirect
	header( "Location: uploads.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='uploads.php?loc_id=" . loc_id . "';</script>";
	exit();
}

//Delete confirm modal
if ( $getUploadId && ! $getConfirm ) {

	$theFile = getSingleUploads( $getUploadId, $getUploadGuid );

	if ( $getIsShared == 'false' ) {
		showModalConfirm(
			"confirm",
			"Delete File?",
			"Are you sure you want to delete: " . $theFile['file_name'] . "?",
			"uploads.php?loc_id=" . loc_id . "&delete=" . $getUploadId . "&confirm=yes&guid=" . $getUploadGuid . "",
			false
		);
	} else {
		showModalConfirm(
			"confirm",
			"Delete File?",
			"Are you sure you want to delete: " . $theFile['file_name'] . "? <div class='alert alert-warning'><i class='fa fa-chain-broken'></i> <strong>Warning!</strong> This image is shared with other locations. Deleting this image may cause broken links on the site.</div> ",
			"uploads.php?loc_id=" . loc_id . "&delete=" . $getUploadId . "&confirm=yes&guid=" . $getUploadGuid . "",
			false
		);
	}

} elseif ( $getUploadId && $getConfirm == 'yes' && $getUploadGuid ) {
	//Remove and delete the file
	deleteUploads( image_dir, $getUploadId, $getUploadGuid );

	flashMessageSet( 'success', 'The file has been deleted.' );

	//Redirect back to uploads page
	header( "Location: uploads.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='uploads.php?loc_id=" . loc_id . "';</script>";
	exit();
}

//TODO: Refactor shared files logic and queries. Can be improved and reduced
//Share settings - Actions, Modal, Form - Admin user only feature
if ( $getIsShared && $adminIsCheck == "true" && multiBranch == 'true' ) {

	$theFile = getSingleUploads( $getUploadId, $getUploadGuid );

	//Check shared_uploads table for any shared images
	$sqlSharedUploadsOption = mysqli_query($db_conn, "SELECT shared, guid, loc_id FROM uploads WHERE guid='" . $getUploadGuid . "' AND loc_id=" . loc_id . ";");
	$rowSharedUploadsOption = mysqli_fetch_array($sqlSharedUploadsOption, MYSQLI_ASSOC);

	//Share setting/options Modal with Form
	showModalConfirm(
		"confirm",
		"Share Image? <br><small>" . $theFile['file_name'] . "</small>",
		"<form name='share_form' id='share_form' method='post' action=''>
        <div class='form-group'>
            <label for='share_location_type'>Location Group</label>
            <select id='share_location_type' class='form-control selectpicker show-tick' data-id='share_location_type' data-dropup-auto='false' data-size='10' name='share_location_type' title='Share to a location group'><option value=''>None</option>" . getLocGroups( $rowSharedUploadsOption['shared'] ) . "</select>
            <div class='text-center'>
                <h3>- OR -</h3>
            </div>
            <label for='share_location_list'>Location(s)</label>
            <select id='share_location_list' class='form-control selectpicker' multiple='multiple' data-live-search='true' data-id='share_location_list' data-dropup-auto='false' data-size='10' tabindex='1' name='share_location_list[]' title='Share to specific location(s)'><option value=''>None</option>" . getLocList( $rowSharedUploadsOption['shared'], 'true' ) . "</select>
            <input type='hidden' name='action' value='shareFile'/>
        </div>",
		"<input type='hidden' name='csrf' value='" .  csrf_validate( $_SESSION['unique_referrer'] ) . "'>
        <button type='submit' class='btn btn-primary' name='share_submit' form='share_form' value='submit'><i class='fa fa-save'></i> Save</button>
        <button type='button' class='btn btn-link' data-dismiss='modal'>Cancel</button>
        </form>",
		true
	);

	if ( $share_location_type || $share_location_list ) {

		$locListOptions = implode( ',', $share_location_list ); //Convert array to string

		if ( $share_location_type ) {
			$sharedOptions = $share_location_type;
		} elseif ( $locListOptions) {
			$sharedOptions = $locListOptions;
		} else {
			$sharedOptions = "";
		}

		//die($sharedOptions);

		if ( $rowSharedUploadsOption['guid'] == $getUploadGuid && $sharedOptions) {
			//Do Update
			$sharedUploadsOptionUpdate = "UPDATE uploads SET shared='" . $sharedOptions . "', datetime='" . date( "Y-m-d H:i:s" ) . "' WHERE guid='" . $getUploadGuid . "' AND loc_id=" . loc_id . ";";
			mysqli_query( $db_conn, $sharedUploadsOptionUpdate );

			flashMessageSet( 'success', 'The file is now being shared.' );

			header( "Location: uploads.php?loc_id=" . loc_id . "", true, 302 );
			echo "<script>window.location.href='uploads.php?loc_id=" . loc_id . "';</script>";
			exit();
		}
	}

}
?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li class="active">Uploads</li>
            </ol>
            <h1 class="page-header">
                Uploads
            </h1>
        </div>
    </div>

<?php
//Alert messages
echo flashMessageGet( 'success' );
echo flashMessageGet( 'danger' );

if ( ! is_writable( '../uploads' ) ) {
	echo "<div class='alert alert-warning fade in'>Unable to write to the uploads folder. Check folder permissions.</div>";
}
?>

    <div class="row">
        <div class="col-lg-12">
            <form name="uploadForm" id="uploadForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="hidden" name="action" value="uploadFile">
                </div>

                <input type="hidden" name="csrf" value="<?php echo csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                <button type="submit" name="upload_submit" id="upload_submit" form='uploadForm'
                        class="btn btn-primary disabled"
                        data-toggle="tooltip" data-original-title=".jpg, .gif, .png - 2mb file size limit"
                        data-placement="right" disabled><i class="fa fa-fw fa-upload"></i> Upload
                    Image
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <hr/>
            <div>
                <table class="table table-bordered table-hover table-striped table-responsive dataTable" id="dataTable">
                    <thead>
                    <tr>
                        <th>Name</th>
						<?php
						// if is admin then show the table header
						if ( $adminIsCheck == 'true' && multiBranch == 'true' ) {
							echo "<th>Shared</th>";
						}
						?>
                        <th>Size</th>
                        <th>Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php

					$count = 0;

					foreach ( $fileList as $file ) {

						$count ++;
						$fileSize = filesizeFormatted( $file['file_size'], false );

						if ( $file['shared'] <> '' ) {
							$isShared    = 'btn btn-primary';
							$isSharedVal = 'true';
						} else {
							$isShared    = 'btn btn-default';
							$isSharedVal = 'false';
						}

						//Check if file is binary in the database.
						if ( $file['file_data'] ) {
							$previewSource = renderBinaryImage( $file['file_mime'], $file['file_data'] );
						} else {
							$previewSource = image_dir . $file['file_name'];
						}

						//Preview modal
						echo "<tr data-index='" . $count . "'>
                            <td><a href='#' onclick=\"showMyModal('" . str_replace( '../', '', image_dir ) . $file['file_name'] . " : " . $fileSize . "', '" . $previewSource . "')\" title='Preview'>" . $file['file_name'] . "</a></td>";

						if ( $adminIsCheck == 'true' && multiBranch == 'true' ) {
							echo "<td class='col-xs-1'>
                                <button type='button' data-toggle='tooltip' title='Share' class='" . $isShared . "' onclick=\"window.location.href='uploads.php?loc_id=" . loc_id . "&share=" . $file['id'] . "&guid=" . $file['guid'] . "'\"><i class='fa fa-fw fa-share-alt'></i></button>
                                <span class='hidden'>" . $isShared . "</span></td>";
						}

						echo "<td class='col-xs-1'>" . $fileSize . "</td>
                            <td class='col-xs-2'>" . $file['datetime'] . "</td>
                            <td class='col-xs-1'>
                            <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='uploads.php?loc_id=" . loc_id . "&delete=" . $file['id'] . "&guid=" . $file['guid'] . "&isshared=" . $isSharedVal . "'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                            </tr>";

					}

					?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Uploads Preview Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <img id="myModalFile" src="" class="img-responsive center-block"/>
                </div>
                <div class="modal-footer">&nbsp;</div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#confirm').on('hidden.bs.modal', function () {
                setTimeout(function () {
                    window.location.href = 'uploads.php?loc_id=<?php echo loc_id; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('delete') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
            if (url.indexOf('share') != -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
            $('#dataTable').dataTable({
                "iDisplayLength": 25,
                "order": [[2, "desc"]],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
            });
        });
    </script>

<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>