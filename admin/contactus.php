<?php
define('inc_access', TRUE);

include 'includes/header.php';

	$sqlContact = mysqli_query($db_conn, "SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours, loc_id FROM contactus WHERE loc_id=".$_GET['loc_id']." ");
	$rowContact = mysqli_fetch_array($sqlContact);

	//update table on submit
	if (!empty($_POST['contact_heading'])) {

		if($rowContact['loc_id'] == $_GET['loc_id']){
			//Do Update
			$contactUpdate = "UPDATE contactus SET heading='".$_POST['contact_heading']."', introtext='".$_POST['contact_introtext']."', mapcode='".mysqli_real_escape_string($db_conn, $_POST['contact_mapcode'])."', email='".$_POST['contact_email']."', sendtoemail='".$_POST['contact_sendtoemail']."', address='".$_POST['contact_address']."', city='".$_POST['contact_city']."', state='".$_POST['contact_state']."', zipcode='".$_POST['contact_zipcode']."', phone='".$_POST['contact_phone']."', hours='".$_POST['contact_hours']."' WHERE loc_id=".$_GET['loc_id']." ";
			mysqli_query($db_conn, $contactUpdate);
		} else {
			//Do Insert
			$contactInsert = "INSERT INTO contactus (heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours, loc_id) VALUES ('".$_POST['contact_heading']."', '".$_POST['contact_introtext']."', '".mysqli_real_escape_string($db_conn, $_POST['contact_mapcode'])."', '".$_POST["contact_email"]."', '".$_POST['contact_sendtoemail']."', '".$_POST['contact_address']."', '".$_POST['contact_city']."', '".$_POST['contact_state']."', '".$_POST['contact_zipcode']."', '".$_POST['contact_phone']."', '".$_POST['contact_hours']."', ".$_GET['loc_id'].")";
			mysqli_query($db_conn, $contactInsert);
		}

		echo "<script>window.location.href='contactus.php?loc_id=".$_GET['loc_id']."&update=true ';</script>";

	}

	if ($_GET['update']=='true') {
		$pageMsg = "<div class='alert alert-success'>The contact section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='contactus.php?loc_id=".$_GET['loc_id']."'\">×</button></div>";
	}
?>

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Contact Us
			</h1>
		</div>
	</div>

	 <div class="row">
		<div class="col-lg-8">
			<?php
			if ($pageMsg != "") {
				echo $pageMsg;
			}
			?>
			<form name="contactForm" method="post" action="">

				<div class="form-group">
					<label>Heading</label>
					<input class="form-control input-sm count-text" name="contact_heading" maxlength="255" value="<?php echo $rowContact['heading']; ?>"  placeholder="Contact Me" required>
				</div>
                <div class="form-group">
					<label>Intro Text</label>
					<textarea class="form-control input-sm count-text" name="contact_introtext" rows="3" maxlength="999"><?php echo $rowContact['introtext']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Map Code</label>
					<textarea class="form-control input-sm count-text" name="contact_mapcode" rows="3" maxlength="999" placeholder="Map embed code goes here"><?php echo $rowContact['mapcode']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Street Address</label>
					<input class="form-control input-sm count-text count-text" name="contact_address" maxlength="255" value="<?php echo $rowContact['address']; ?>" placeholder="123 Fake Street">
				</div>
				<div class="form-group">
					<label>City</label>
					<input class="form-control input-sm count-text" name="contact_city" maxlength="100" value="<?php echo $rowContact['city']; ?>" placeholder="Beverly Hills">
				</div>
				<div class="form-group">
					<label>State</label>
					<input class="form-control input-sm count-text" name="contact_state" maxlength="100" value="<?php echo $rowContact['state']; ?>" placeholder="CA">
				</div>
				<div class="form-group">
					<label>Zipcode</label>
					<input class="form-control input-sm count-text" name="contact_zipcode" maxlength="100" value="<?php echo $rowContact['zipcode']; ?>" placeholder="90210">
				</div>
				<div class="form-group">
					<label>Phone</label>
					<input class="form-control input-sm count-text" name="contact_phone" maxlength="100" value="<?php echo $rowContact['phone']; ?>" type="tel" placeholder="555-5555">
				</div>
				<div class="form-group">
					<label>Hours</label>
					<textarea class="form-control input-sm count-text" name="contact_hours" rows="3" maxlength="255"><?php echo $rowContact['hours']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input class="form-control input-sm count-text" name="contact_email" maxlength="100" value="<?php echo $rowContact['email']; ?>" type="email" placeholder="john.doe@email.com">
				</div>
				<div class="form-group">
					<label>Send To Email</label>
					<input class="form-control input-sm count-text" name="contact_sendtoemail" maxlength="100" value="<?php echo $rowContact['sendtoemail']; ?>" type="email" placeholder="john.doe@email.com">
				</div>

				<button type="submit" name="contact_submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

			</form>

		</div>
	</div>

<?php
	include 'includes/footer.php';
?>
