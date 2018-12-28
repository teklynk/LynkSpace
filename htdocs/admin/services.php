<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'services.php';

$deleteMsg       = "";
$deleteConfirm   = "";
$serviceMsg      = "";
$delserviceId    = sanitizeInt( $_GET['deleteservice'] );
$delserviceTitle = safeCleanStr( addslashes( $_GET['deletetitle'] ) );
$delserviceGuid  = safeCleanStr( $_GET['guid'] );
$pagePreviewId   = sanitizeInt( $_GET['preview'] );
$theserviceId    = sanitizeInt( $_GET['editservice'] );
$theServiceGuid  = safeCleanStr( $_GET['guid'] );
$newService      = safeCleanStr( $_GET['newservice'] );

//Page preview
if ( $pagePreviewId > "" ) {

	$sqlServicesPreview = mysqli_query( $db_conn, "SELECT id, title, icon, image, content, link, loc_id FROM services WHERE id=" . $pagePreviewId . " AND loc_id=" . $_SESSION['loc_id'] . ";" );
	$rowServicesPreview = mysqli_fetch_array( $sqlServicesPreview, MYSQLI_ASSOC );

	echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";
	echo "<div class='col-lg-12'>";

	if ( $rowServicesPreview['icon'] > "" ) {
		echo "<p style='font-size:6.0em;'><i class='fa fa-fw fa-" . $rowServicesPreview['icon'] . "'></i></p><br/>";
	}

	if ( $rowServicesPreview['image'] > "" ) {
		echo "<p><img src='" . $rowServicesPreview['image'] . "' style='max-width:350px; max-height:150px;' /></p>";
	}

	if ( $rowServicesPreview['title'] > "" ) {
		echo "<h4>" . $rowServicesPreview['title'] . "</h4>";
	}
	echo "<p>" . $rowServicesPreview['content'] . "</p>";

	if ( $rowServicesPreview['link'] ) {
		echo "<br/><p><b>Page Link:</b> <a href='" . $rowServicesPreview['link'] . "' target='_blank'>" . $rowServicesPreview['link'] . "</a></p>";
	}

	echo "<br/><p><b>Page URL:</b> <a href='../services.php?loc_id=" . loc_id . "' title='Page URL' target='_blank'>services.php?loc_id=" . loc_id . "</a></p>";

	echo "</div>";
}
?>
    <div class="row">
        <div class="col-lg-12">
			<?php
			if ( $newService == 'true' ) {
				echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
            <li><a href='services.php?loc_id=" . loc_id . "'>Services</a></li>
            <li class='active'>New Services</li>
            </ol>";
				echo "<h1 class='page-header'>Services (New) <a href='services.php' role='button' class='btn btn-link'> Cancel</a></h1>";
			} elseif ( $theserviceId ) {
				echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
            <li><a href='services.php?loc_id=" . loc_id . "'>Services</a></li>
            <li class='active'>Edit Services</li>
            </ol>";
				echo "<h1 class='page-header'>Services (Edit) <a href='services.php' role='button' class='btn btn-link'> Cancel</a></h1>";
			} else {
				echo "<ol class='breadcrumb'>
            <li><a href='setup.php?loc_id=" . loc_id . "'>Home</a></li>
            <li class='active'>Services</li>
            </ol>";
				echo "<h1 class='page-header'>Services&nbsp;";
				echo "<button type='button' data-toggle='tooltip' data-placement='bottom' title='Preview the Services Page' class='btn btn-info' onclick=\"showMyModal('../services.php?loc_id=" . loc_id . "', '../services.php?loc_id=" . loc_id . "#services')\"><i class='fa fa-eye'></i></button>";
				echo "</h1>";
			}
			?>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-12">
<?php

if ( $newService == 'true' || $theserviceId ) {

	$serviceMsg = "";

	//Update existing service
	if ( $theserviceId ) {

		$serviceLabel = "Edit Service Title";

		//update data on submit
		if ( ! empty( $_POST['service_title'] ) ) {

			$servicesUpdate = "UPDATE services SET title='" . safeCleanStr( $_POST['service_title'] ) . "', content='" . sqlEscapeStr( $_POST['service_content'] ) . "', link='" . safeCleanStr( $_POST['service_link'] ) . "', icon='" . $_POST['service_icon_select'] . "', image='" . $_POST['service_image_select'] . "', author_name='" . $_SESSION['user_name'] . "' WHERE id=" . $theserviceId . " AND loc_id=" . loc_id . " AND guid='" . $theServiceGuid . "';";
			mysqli_query( $db_conn, $servicesUpdate );

			$serviceMsg = "<div class='alert alert-success'><i class='fa fa-long-arrow-left'></i><a href='services.php?loc_id=" . loc_id . "' class='alert-link'>Back</a> | The service " . safeCleanStr( $_POST['service_title'] ) . " has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php?loc_id=" . loc_id . "'\">×</button></div>";
		}

		$sqlServices = mysqli_query( $db_conn, "SELECT id, title, icon, image, content, link, active, author_name, datetime, loc_id FROM services WHERE id=" . $theserviceId . " AND loc_id=" . loc_id . ";" );
		$rowServices = mysqli_fetch_array( $sqlServices, MYSQLI_ASSOC );

		//Create new service
	} elseif ( $newService == 'true' ) {

		$serviceLabel = "New Service Title";

		//insert data on submit
		if ( ! empty( $_POST['service_title'] ) ) {
			$servicesInsert = "INSERT INTO services (title, content, guid, icon, image, link, active, sort, author_name, loc_id) VALUES ('" . sqlEscapeStr( $_POST['service_title'] ) . "', '" . safeCleanStr( $_POST['service_content'] ) . "', '" . getGuid() . "', '" . $_POST['service_icon_select'] . "', '" . $_POST['service_image_select'] . "', '" . safeCleanStr( $_POST['service_link'] ) . "', 'false', 0, '" . $_SESSION['user_name'] . "', " . loc_id . ");";
			mysqli_query( $db_conn, $servicesInsert );

			flashMessageSet( 'success', 'The services section has been updated.' );

			//Redirect back to uploads page
			header( "Location: services.php?loc_id=" . loc_id . "", true, 302 );
			echo "<script>window.location.href='services.php?loc_id=" . loc_id . "';</script>";
			exit();
		}
	}

	//Alert messages
	echo flashMessageGet( 'success' );
	?>
    <div class="col-lg-8">
        <form name="serviceForm" class="dirtyForm" method="post" action="">

            <div class="form-group required">
                <label for="service_title"><?php echo $serviceLabel; ?></label>
                <input type="text" class="form-control count-text" name="service_title" maxlength="255"
                       value="<?php if ( $theserviceId ) {
					       echo $rowServices['title'];
				       } ?>" placeholder="Service Title" autofocus required>
            </div>
            <hr/>
            <div class="form-group">
                <i id="service_icon" style="font-size:6.0em;"
                   class="fa fa-fw fa-<?php echo $rowServices['icon']; ?>"></i>
            </div>
            <div class="form-group">
				<?php
				$imgSrc = "//placehold.it/140x100&text=No Image";

				if ( $rowServices['image'] == "" && $rowServices['icon'] > "" ) {
					$imgSrc = "//placehold.it/1/ffffff/ffffff"; //small image just to give the source a value
				} elseif ( $rowServices['image'] > "" && $rowServices['icon'] == "" ) {
					$imgSrc = $rowServices['image'];
				}
				echo "<img src='" . $imgSrc . "' id='service_image_preview' style='max-width:140px; height:auto; display:block; background-color: #ccc;'/>";
				?>
            </div>
            <div class="form-group">
                <label for="service_icon_select">Choose an icon</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="service_icon_select" id="service_icon_select" title="Choose an icon">
                    <option value="">None</option>
					<?php
					echo getIconDropdownList( $rowServices['icon'] );
					?>
                </select>
            </div>
            <div class="form-group">
                <label for="service_image_select">Use an Existing Image</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="service_image_select" id="service_image_select"
                        title="Choose an existing image">
                    <option value="">None</option>
					<?php
					echo getImageDropdownList( loc_id, $rowServices['image'] );
					?>
                </select>
            </div>
            <hr/>

            <div class="form-group">
                <label for="service_exist_page">Existing Page</label>
                <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false"
                        data-size="10" name="service_exist_page" id="service_exist_page"
                        title="Choose an existing page">
                    <option value="">None</option>
					<?php
					echo getPages( loc_id );
					?>
                </select>
            </div>

            <div class="form-group">
                <label for="service_link">Link URL</label>
                <input type="text" class="form-control count-text" name="service_link" id="service_link" maxlength="255"
                       value="<?php if ( $theserviceId ) {
					       echo $rowServices['link'];
				       } ?>">
            </div>

            <hr/>
            <div class="form-group">
                <label for="service_content">Description</label>
                <textarea class="form-control count-text" rows="3" name="service_content" placeholder="Text"
                          maxlength="999"><?php if ( $theserviceId ) {
						echo $rowServices['content'];
					} ?></textarea>
            </div>

            <input type="hidden" name="csrf" value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

            <button type="submit" name="sservices_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save
                Changes
            </button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>
    </div>

	<?php
} else {

	//delete service
	if ( $delserviceId && $delserviceTitle && ! $_GET['confirm'] ) {

		showModalConfirm(
			"confirm",
			"Delete Service?",
			"Are you sure you want to delete: " . $delserviceTitle . "?",
			"services.php?loc_id=" . loc_id . "&deleteservice=" . $delserviceId . "&deletetitle=" . $delserviceTitle . "&confirm=yes&guid=" . $delserviceGuid . "&token=" . $_SESSION['unique_referrer'] . "",
			false
		);

	} elseif ( $delserviceId && $delserviceTitle && $_GET['confirm'] == 'yes' && $delserviceGuid && $_GET['token'] == $_SESSION['unique_referrer'] ) {
		//delete service after clicking Yes
		$servicesDelete = "DELETE FROM services WHERE id=" . $delserviceId . " AND guid='" . $delserviceGuid . "' AND loc_id=" . loc_id . ";";
		mysqli_query( $db_conn, $servicesDelete );

		flashMessageSet( 'success', $delserviceTitle . " has been deleted." );

		//Redirect back to uploads page
		header( "Location: services.php?loc_id=" . loc_id . "", true, 302 );
		echo "<script>window.location.href='services.php?loc_id=" . loc_id . "';</script>";
		exit();
	}

	//update heading on submit
	if ( $_POST['save_main'] ) {

		if ( $_POST['services_defaults'] == 'on' ) {
			$_POST['services_defaults'] = 'true';
		} else {
			$_POST['services_defaults'] = 'false';
		}

		$setupUpdate = "UPDATE setup SET servicesheading='" . safeCleanStr( $_POST['main_heading'] ) . "', servicescontent='" . sqlEscapeStr( $_POST['main_content'] ) . "', services_use_defaults='" . safeCleanStr( $_POST['services_defaults'] ) . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . loc_id . ";";
		mysqli_query( $db_conn, $setupUpdate );

		for ( $i = 0; $i < $_POST['service_count']; $i ++ ) {

			$servicesUpdate = "UPDATE services SET sort=" . safeCleanStr( $_POST['service_sort'][ $i ] ) . " WHERE id=" . $_POST['service_id'][ $i ] . ";";
			mysqli_query( $db_conn, $servicesUpdate );

		}

		flashMessageSet( 'success', 'The services section has been updated.' );
	}

	$sqlSetup = mysqli_query( $db_conn, "SELECT servicesheading, servicescontent, services_use_defaults FROM setup WHERE loc_id=" . loc_id . ";" );
	$rowSetup = mysqli_fetch_array( $sqlSetup, MYSQLI_ASSOC );

	//Modal preview box
	showModalPreview( "webserviceDialog" );

	//use default view
	if ( $rowSetup['services_use_defaults'] == 'true' ) {
		$selDefaults = "CHECKED";
	} else {
		$selDefaults = "";
	}

	if ( loc_id != 1 ) {
		?>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group" id="servicesdefaults">
                    <label for="services_defaults">Use Defaults</label>
                    <div class="checkbox">
                        <label>
                            <input class="services_defaults_checkbox defaults-toggle" id="<?php echo loc_id ?>"
                                   name="services_defaults" type="checkbox" <?php if ( loc_id ) {
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
            onclick="window.location='?newservice=true&loc_id=<?php echo loc_id; ?>';"><i
                class='fa fa-fw fa-plus'></i> Add a New Service
    </button>
    <h2></h2>
    <div>
		<?php
		echo flashMessageGet( 'success' );
		?>
        <form name="servicesForm" class="dirtyForm" method="post">
            <div class="form-group required">
                <label>Heading</label>
                <input class="form-control count-text" name="main_heading" maxlength="255"
                       value="<?php echo $rowSetup['servicesheading']; ?>" placeholder="My Services" autofocus required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control count-text" name="main_content" placeholder="About our services"
                          maxlength="255"><?php echo $rowSetup['servicescontent']; ?></textarea>
            </div>
            <table class="table table-bordered table-hover table-striped table-responsive">
                <thead>
                <tr>
                    <th>Sort</th>
                    <th>Service Title</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$serviceCount = "";
				$sqlServices  = mysqli_query( $db_conn, "SELECT id, title, icon, content, guid, link, sort, active, loc_id FROM services WHERE loc_id=" . loc_id . " ORDER BY sort ASC;" );
				while ( $rowServices = mysqli_fetch_array( $sqlServices, MYSQLI_ASSOC ) ) {
					$serviceId       = $rowServices['id'];
					$serviceTitle    = $rowServices['title'];
					$serviceTumbnail = $rowServices['icon'];
					$serviceContent  = $rowServices['content'];
					$serviceActive   = $rowServices['active'];
					$serviceSort     = $rowServices['sort'];
					$serviceGuid     = $rowServices['guid'];
					$serviceCount ++;

					if ( $rowServices['active'] == 'true' ) {
						$isActive = "CHECKED";
					} else {
						$isActive = "";
					}

					echo "<tr>
				<td class='col-xs-1'>
				<input class='form-control' name='service_sort[]' value='" . $serviceSort . "' type='number' maxlength='3' required>
				</td>
				<td>
				<input type='hidden' name='service_id[]' value='" . $serviceId . "' >
				<a href='services.php?loc_id=" . loc_id . "&editservice=" . $serviceId . "&guid=" . $serviceGuid . "' title='Edit'>" . $serviceTitle . "</a>
				</td>
				<td class='col-xs-1'>
				<input data-toggle='toggle' title='Service Active' class='checkbox services_status_checkbox' id='" . $serviceId . "' type='checkbox' " . $isActive . ">
				</td>
				<td class='col-xs-2'>
				<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-info' onclick=\"showMyModal('" . safeCleanStr( $serviceTitle ) . "', 'services.php?loc_id=" . loc_id . "&preview=" . $serviceId . "')\"><i class='fa fa-fw fa-eye'></i></button>
				<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' onclick=\"window.location.href='services.php?loc_id=" . loc_id . "&deleteservice=" . $serviceId . "&deletetitle=" . safeCleanStr( addslashes( $serviceTitle ) ) . "&guid=" . $serviceGuid . "'\"><i class='fa fa-fw fa-trash'></i></button>
				</td>
				</tr>";
				}
				?>
                </tbody>
            </table>

            <input type="hidden" name="csrf" value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

            <input type="hidden" name="service_count" value="<?php echo $serviceCount; ?>"/>
            <input type="hidden" name="save_main" value="true"/>
            <button type="submit" name="servicesNew_submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>
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
                    window.location.href = 'services.php?loc_id=<?php echo loc_id; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deleteservice') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>