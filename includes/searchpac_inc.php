<!-- Featured Section -->
<?php
if (!defined('inc_access')) {
   die('Direct access not permitted');
}
	getSetup(); //gets search pac options for the loc_id
	//getLocation(); //gets location name if needed
		
	echo "<div class='row' id='searchpac'>";

		echo "<div class='col-lg-12'>";
?>
	<div class="container">
		<div class="row">
			<h2>Search Schools</h2>
			<div id="custom-search-input">
				<div class="input-group col-md-12">
					<input type="text" class="  search-query form-control" placeholder="Search" />
					<span class="input-group-btn">
						<button class="btn btn-danger" type="button">
							<span class=" glyphicon glyphicon-search"></span>
						</button>
					</span>
				</div>
				<?php
				//EXAMPLE: getNav($navSection,$dropdown,$pull)
				getNav('Footer','true','left');
				?>
			</div>
		</div>
	</div>
<?php
		echo "</div>";

	echo "</div>";
?>
<!-- /.row -->