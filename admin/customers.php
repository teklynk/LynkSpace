<?php 
define('inc_access', TRUE);

include 'includes/header.php';

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$uploadMsg = "<div class='alert alert-success'>The file ". basename( $_FILES["fileToUpload"]["name"]) ." has been uploaded.<button type='button' class='close' data-dismiss='alert'>×</button></div>";
	} else {
		$uploadMsg = "";
	}

	//Page preview
	if ($_GET["preview"]>""){
		$pagePreviewId=$_GET["preview"];
		$sqlcustomerPreview = mysqli_query($db_conn, "SELECT id, image, name, link FROM customers WHERE id='$pagePreviewId'");
		$row  = mysqli_fetch_array($sqlcustomerPreview);
			
			echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";			
			echo "<div class='col-lg-12'>";
			if ($row["name"]>""){
				echo "<h4>".$row['name']."</h4>";
			}
			if ($row["image"]>""){
				echo "<p><img src=../uploads/".$row['image']." style='max-width:350px; max-height:150px;' /></p>";
			}
			if ($row["link"]>""){
				echo "<br/><p><i class='fa fa-fw fa-external-link'></i> <a href='".$row['link']."' target='_blank'>Customer Link</a></p>";
			}
			echo "</div>";
	}
?>
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $rowSetup["customersheading"]?>
            </h1>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
<?php

	if ($_GET["newcustomer"] OR $_GET["editcustomer"]) {
		$customerMsg="";
		
		//Update existing customer
		if ($_GET["editcustomer"]) {
			$thecustomerId = $_GET["editcustomer"];
			$customerLabel = "Edit Customer Name";
			
			//update data on submit
			if (!empty($_POST["customer_name"])) {
				$customerUpdate = "UPDATE customers SET name='".$_POST["customer_name"]."', image='".$_POST["customer_image"]."', link='".$_POST["customer_link"]."', active=".$_POST["customer_status"].", datetime='".date("Y-m-d H:i:s")."' WHERE id='$thecustomerId'";
				mysqli_query($db_conn, $customerUpdate);
				$customerMsg="<div class='alert alert-success'>The customer ".$_POST["customer_name"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php'\">×</button></div>";
			}
			
			$sqlcustomer = mysqli_query($db_conn, "SELECT id, image, name, link, active, datetime FROM customers WHERE id='$thecustomerId'");
			$row  = mysqli_fetch_array($sqlcustomer);
			
		//Create new customer
		} else if ($_GET["newcustomer"]) {
			$customerLabel = "New Customer Name";
			//insert data on submit
			if (!empty($_POST["customer_name"])) {
				$customerInsert = "INSERT INTO customers (image, name, link, active) VALUES ('".$_POST["customer_image"]."', '".$_POST["customer_name"]."', '".$_POST["customer_link"]."',  ".$_POST["customer_status"].")";
				mysqli_query($db_conn, $customerInsert);
				//echo $customerInsert;
				$customerMsg="<div class='alert alert-success'>The customer ".$_POST["customer_name"]." has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php'\">×</button></div>";
			}
		} 
        
		//alert messages
		if ($uploadMsg !="") {
			echo $uploadMsg;
		}
		
		if ($customerMsg !="") {
			echo $customerMsg;
		}
		
		if ($_GET["editcustomer"]){ 
			//active status		
			if ($row['active']==1) {
				$selActive1="SELECTED";
				$selActive0="";
			} else {
				$selActive0="SELECTED";
				$selActive1="";
			}
		}

		if ($row["image"]=="") {
			$thumbNail = "http://placehold.it/140x100&text=No Image";
		} else {
			$thumbNail = "../uploads/".$row["image"];
		}
?>

	<form role="customerForm" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Status</label>
            <select class="form-control input-sm" name="customer_status">
                <option value="1" <?php if($_GET["editcustomer"]){echo $selActive1;} ?>>Active</option>
                <option value="0" <?php if($_GET["editcustomer"]){echo $selActive0;} ?>>Draft</option>
            </select>
        </div>
        <hr/>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
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
							if ($file===$row['image']){
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
			<input class="form-control input-sm" name="customer_name" value="<?php if($_GET["editcustomer"]){echo $row['name'];} ?>" placeholder="Name">
		</div>
		<div class="form-group">
			<label>Link</label>
			<input class="form-control input-sm" name="customer_link" value="<?php if($_GET["editcustomer"]){echo $row['link'];} ?>" placeholder="http://www.google.com">
		</div>
        <div class="form-group">
			<span><?php if($_GET["editcustomer"]){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($row['datetime']));} ?></span>
		</div>
		
		<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$customerMsg="";
		$delcustomerId = $_GET["deletecustomer"];
		$delcustomerName = $_GET["deletename"];
		$movecustomerId = $_GET["movecustomer"];
		$movecustomerName = $_GET["movename"];
		
		//delete customer
		if ($_GET["deletecustomer"] AND $_GET["deletename"] AND !$_GET["confirm"]) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delcustomerName."? <a href='?deletecustomer=".$delcustomerId."&deletename=".$delcustomerName."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php'\">×</button></div>";
			echo $deleteMsg;
		} elseif ($_GET["deletecustomer"] AND $_GET["deletename"] AND $_GET["confirm"]=="yes") {
			//delete customer after clicking Yes
			$customerDelete = "DELETE FROM customers WHERE id='$delcustomerId'";
			mysqli_query($db_conn, $customerDelete);
			$deleteMsg="<div class='alert alert-success'>".$delcustomerName." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php'\">×</button></div>";
			echo $deleteMsg;
		}
		
	//move customer to top of list
    if (($_GET["movecustomer"] AND $_GET["movename"])) {
        $customerDateUpdate = "UPDATE customers SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$movecustomerId'";
        mysqli_query($db_conn, $customerDateUpdate);
        $customerMsg="<div class='alert alert-success'>".$movecustomerName." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php'\">×</button></div>";
    }
		
    //update heading on submit
    if (($_POST["save_main"])) {
        $setupUpdate = "UPDATE setup SET customersheading='".$_POST["customer_heading"]."', customerscontent='".$_POST["main_content"]."'";
        mysqli_query($db_conn, $setupUpdate);
        $customerMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='customers.php'\">×</button></div>";
    }
		
    $sqlSetup = mysqli_query($db_conn, "SELECT customersheading, customerscontent FROM setup");
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

	<button type="button" class="btn btn-default" onclick="window.location='?newcustomer=true';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Customer</button>
		<h2></h2>
		<div class="table-responsive">
    <?php 
		if ($customerMsg !="") {
			echo $customerMsg;
		}
		?>
			<form role="customerForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm" name="customer_heading" value="<?php echo $rowSetup['customersheading']; ?>" placeholder="My customer">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control input-sm" name="main_content" placeholder="About our customers" maxlength="255"><?php echo $rowSetup['customerscontent']; ?></textarea>
            </div>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
        		<?php 
					$sqlcustomer = mysqli_query($db_conn, "SELECT id, image, name, link, active FROM customers ORDER BY datetime DESC");
					while ($row  = mysqli_fetch_array($sqlcustomer)) {
						$customerId=$row['id'];
						$customerName=$row['name'];
						$customerTumbnail=$row['image'];
						$customerLink=$row['link'];
						$customerActive=$row['active'];
						if ($row['active']==0){
							$isActive="<i style='color:red;'>(Draft)</i>";
						} else {
							$isActive="";
						}
						echo "<tr>
						<td><a href='?editcustomer=$customerId' title='Edit'>".$customerName."</a></td>
						<td class='col-xs-1'>
						<span>".$isActive."</span>
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$customerName', '?preview=$customerId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='?movecustomer=$customerId&movename=$customerName'\"><i class='fa fa-fw fa-arrow-up'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?deletecustomer=$customerId&deletename=$customerName'\"><i class='fa fa-fw fa-trash'></i></button>
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
	}
?>
		</div>
	</div>
	<p></p>

<?php
include 'includes/footer.php';
?>
