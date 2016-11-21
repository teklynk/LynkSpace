<?php
define('inc_access', TRUE);

include 'includes/header.php';

	//Page preview
	if ($_GET['preview']>""){
		$pagePreviewId=$_GET['preview'];
		$sqlcustomerPreview = mysqli_query($db_conn, "SELECT id, image, name, link FROM customers WHERE id='$pagePreviewId'");
		$rowCustomerPreview = mysqli_fetch_array($sqlcustomerPreview);

			echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";
			echo "<div class='col-lg-12'>";

			if ($rowCustomerPreview['name']>""){
				echo "<h4>".$rowCustomerPreview['name']."</h4>";
			}

			if ($rowCustomerPreview['image']>""){
				echo "<p><img src=../uploads/".$_SESSION['loc_id']."/".$rowCustomerPreview['image']." style='max-width:350px; max-height:150px;' /></p>";
			}

			if ($rowCustomerPreview['link']>""){
				echo "<br/><p><i class='fa fa-fw fa-external-link'></i> <a href='".$rowCustomerPreview['link']."' target='_blank'>Customer Link</a></p>";
			}

			echo "</div>";
	}
?>
	<div class="row">
	<div class="col-lg-12">
	<?php
		if ($_GET['newcustomer'] == 'true') {
			echo "<h1 class='page-header'>Customers (New)</h1>";
		} else {
			echo "<h1 class='page-header'>Customers</h1>";
		}
	?>
	</div>
	</div>
	<div class="row">
	<div class="col-lg-12">
<?php

	if ($_GET['newcustomer'] OR $_GET['editcustomer']) {

		$customerMsg="";

		//Update existing customer
		if ($_GET['editcustomer']) {
			$thecustomerId = $_GET['editcustomer'];
			$customerLabel = "Edit Customer Name";

			//update data on submit
			if (!empty($_POST['customer_name'])) {

				if ($_POST['customer_status']=='on') {
					$_POST['customer_status']='true';
				} else {
					$_POST['customer_status']='false';
				}

				$customerUpdate = "UPDATE customers SET name='".$_POST['customer_name']."', image='".$_POST['customer_image']."', link='".$_POST['customer_link']."', active='".$_POST['customer_status']."', datetime='".date("Y-m-d H:i:s")."' WHERE id='$thecustomerId' AND loc_id=".$_GET['loc_id']." ";
				mysqli_query($db_conn, $customerUpdate);

				$customerMsg="<div class='alert alert-success'>The customer ".$_POST['customer_name']." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			}

			$sqlCustomer = mysqli_query($db_conn, "SELECT id, image, name, link, active, datetime, loc_id FROM customers WHERE id='$thecustomerId' AND loc_id=".$_GET['loc_id']." ");
			$rowCustomer = mysqli_fetch_array($sqlCustomer);

		//Create new customer
		} else if ($_GET['newcustomer']) {

			$customerLabel = "New Customer Name";

			//insert data on submit
			if (!empty($_POST['customer_name'])) {
				$customerInsert = "INSERT INTO customers (image, name, link, active, loc_id) VALUES ('".$_POST['customer_image']."', '".$_POST['customer_name']."', '".$_POST['customer_link']."', 'true', ".$_GET['loc_id'].")";
				mysqli_query($db_conn, $customerInsert);

				echo "<script>window.location.href='customers.php?loc_id=".$_GET['loc_id']."';</script>";

			}
		}

		//alert messages
		if ($customerMsg != "") {
			echo $customerMsg;
		}

		if ($_GET['editcustomer']) {
			//active status
			if ($rowCustomer['active']=='true') {
				$selActive="CHECKED";
			} else {
				$selActive="";
			}
		}

		if ($rowCustomer['image']=="") {
			$thumbNail = "http://placehold.it/140x100&text=No Image";
		} else {
			$thumbNail = "../uploads/".$_GET['loc_id']."/".$rowCustomer['image'];
		}
?>

	<form name="customerForm" method="post" action="">

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group" id="customeractive">
					<label>Active</label>
					<div class="checkbox">
						<label>
							<input class="customer_status_checkbox" id="<?php echo $_GET['editcustomer']?>" name="customer_status" type="checkbox" <?php if($_GET['editcustomer']){echo $selActive;}?> data-toggle="toggle">
						</label>
					</div>
				</div>
			</div>
		</div>

        <hr/>
        <div class="form-group">
        	<img src="<?php echo $thumbNail;?>" id="customer_image_preview" style="max-width:140px; height:auto;"/>
        </div>
		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control input-sm" name="customer_image" id="customer_image">
				<option value="">None</option>
				<?php
					if ($handle = opendir($target_dir)) {
						while (false !== ($file = readdir($handle))) {
							if ('.' === $file) continue;
							if ('..' === $file) continue;
							if ($file==="Thumbs.db") continue;
							if ($file===".DS_Store") continue;
							if ($file==="index.html") continue;

							if ($file===$rowCustomer['image']){
								$imageCheck="SELECTED";
							} else {
								$imageCheck="";
							}

							echo "<option value=".$file." $imageCheck>".$file."</option>";
						}
						closedir($handle);
					}
				?>
			</select>
		</div>
		<hr/>
		<div class="form-group">
			<label>Name</label>
			<input class="form-control input-sm" name="customer_name" value="<?php if($_GET['editcustomer']){echo $rowCustomer['name'];} ?>" placeholder="Name">
		</div>
		<div class="form-group">
			<label>Link</label>
			<input class="form-control input-sm" name="customer_link" maxlength="255" value="<?php if($_GET['editcustomer']){echo $rowCustomer['link'];} ?>" type="url" placeholder="http://www.google.com">
		</div>
        <div class="form-group">
			<span><?php if($_GET['editcustomer']){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($rowCustomer['datetime']));} ?></span>
		</div>

		<button type="submit" name="customers_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$customerMsg="";
		$delcustomerId = $_GET['deletecustomer'];
		$delcustomerName = $_GET['deletename'];
		$movecustomerId = $_GET['movecustomer'];
		$movecustomerName = $_GET['movename'];

		//delete customer
		if ($_GET['deletecustomer'] AND $_GET['deletename'] AND !$_GET['confirm']) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delcustomerName."? <a href='?loc_id=".$_GET['loc_id']."&deletecustomer=".$delcustomerId."&deletename=".$delcustomerName."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;

		} elseif ($_GET['deletecustomer'] AND $_GET['deletename'] AND $_GET['confirm']=='yes') {
			//delete customer after clicking Yes
			$customerDelete = "DELETE FROM customers WHERE id='$delcustomerId'";
			mysqli_query($db_conn, $customerDelete);

			$deleteMsg="<div class='alert alert-success'>".$delcustomerName." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
			echo $deleteMsg;
		}

	//move customer to top of list
    if (($_GET['movecustomer'] AND $_GET['movename'])) {
        $customerDateUpdate = "UPDATE customers SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$movecustomerId'";
        mysqli_query($db_conn, $customerDateUpdate);

        $customerMsg="<div class='alert alert-success'>".$movecustomerName." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
    }

    //update heading on submit
    if (($_POST['save_main'])) {
        $setupUpdate = "UPDATE setup SET customersheading='".$_POST['customer_heading']."', customerscontent='".$_POST['main_content']."' WHERE loc_id=".$_GET['loc_id']." ";
        mysqli_query($db_conn, $setupUpdate);

        $customerMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
    }

    $sqlSetup = mysqli_query($db_conn, "SELECT customersheading, customerscontent FROM setup WHERE loc_id=".$_GET['loc_id']." ");
	$rowSetup  = mysqli_fetch_array($sqlSetup);
?>
<!--modal preview window-->

<style>
#webpageDialog iframe {
	width: 100%;
	height: 600px;
	frameborder: 0;
	border: none;
}
.modal-dialog {
	width:95%;
}
</style>

 <div class="modal fade" id="webpageDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalTitle"></h4>
      </div>
      <div class="modal-body">
			<iframe id="myModalFile" src="" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<button type="button" class="btn btn-default" onclick="window.location='?newcustomer=true&loc_id=<?php echo $_GET['loc_id']; ?>';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Customer</button>
		<h2></h2>
		<div class="table-responsive">
    <?php
		if ($customerMsg != "") {
			echo $customerMsg;
		}
		?>
			<form name="customerForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm" name="customer_heading" maxlength="255" value="<?php echo $rowSetup['customersheading']; ?>" placeholder="My customer" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control input-sm" name="main_content" placeholder="About our customers" maxlength="255"><?php echo $rowSetup['customerscontent']; ?></textarea>
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
					$sqlCustomer = mysqli_query($db_conn, "SELECT id, image, name, link, active, loc_id FROM customers WHERE loc_id=".$_GET['loc_id']." ORDER BY datetime DESC");
					while ($rowCustomer = mysqli_fetch_array($sqlCustomer)) {
						$customerId=$rowCustomer['id'];
						$customerName=$rowCustomer['name'];
						$customerTumbnail=$rowCustomer['image'];
						$customerLink=$rowCustomer['link'];
						$customerActive=$rowCustomer['active'];

						if ($rowCustomer['active']=='true') {
							$isActive="CHECKED";
						} else {
							$isActive="";
						}

						echo "<tr>
						<td><a href='?loc_id=".$_GET['loc_id']."&editcustomer=$customerId' title='Edit'>".$customerName."</a></td>
						<td class='col-xs-1'>
						<input data-toggle='toggle' title='Customer Active' class='checkbox customer_status_checkbox' id='$customerId' type='checkbox' ".$isActive.">
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$customerName', '?preview=$customerId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='?loc_id=".$_GET['loc_id']."&movecustomer=$customerId&movename=$customerName'\"><i class='fa fa-fw fa-arrow-up'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?loc_id=".$_GET['loc_id']."&deletecustomer=$customerId&deletename=$customerName'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
					}
				?>
				</tbody>
			</table>
			<input type="hidden" name="save_main" value="true" />
            <button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
			</form>
		</div>
<?php
	} //end of long else

echo "</div>
	</div>
	<p></p>";

include 'includes/footer.php';
?>
