<?php 
include 'includes/header.php';

	//update table on submit
	if (!empty($_POST)) {
		$generalinfoUpdate = "UPDATE generalinfo SET heading='".$_POST["generalinfo_heading"]."', content='".$_POST["generalinfo_content"]."'";
		mysql_query($generalinfoUpdate);
		$pageMsg="<div class='alert alert-success'>The general info section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='generalinfo.php'\">×</button></div>";
	}
	
	$sqlGeneralinfo= mysql_query("SELECT heading, content FROM generalinfo");
	$row  = mysql_fetch_array($sqlGeneralinfo);
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				General Information
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
		<?php 
		if ($pageMsg !="") {
			echo $pageMsg;
		}
		?>
			<form role="generalinfoForm" method="post" action="">

				<div class="form-group">
					<label>Heading</label>
					<input class="form-control input-sm" name="generalinfo_heading" value="<?php echo $row['heading']; ?>" placeholder="Heading">
				</div>

				<div class="form-group">
					<label>Text / HTML</label>
					<textarea class="form-control input-sm tinymce" name="generalinfo_content" rows="20"><?php echo $row['content']; ?></textarea>
					
				</div>

				<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i>Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i>Reset</button>

			</form>

		</div>
	</div>

<?php
include 'includes/footer.php';
?>
