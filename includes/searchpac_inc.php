<!-- Featured Section -->
<?php
if (!defined('inc_access')) {
   die('Direct access not permitted');
}
	getSetup(); //gets search pac options for the loc_id
    getLocList();
		
	echo "<div class='row' id='searchpac'>";

		echo "<div class='col-lg-12'>";

?>
    <script type="text/javascript" language="javascript">
    $(document).ready(function(){
        //jQueryUI AutoComplete
        $(function() {
            var availableTags = [<?php echo rtrim($locationListJson, ",");?>];
            $("#tags").autocomplete({
                source: availableTags
            });
        });
    });
    </script>

    <div class="container">
        <div class="row">
            <h1 class="text-white">Search Schools</h1>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control" id="tags" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <div class="input-group col-md-12 text-center">
                <?php
                //EXAMPLE: getNav($navSection,$dropdown,$pull)
                getNav('Search','true','left');
                ?>
                </div>
            </div>
        </div>
    </div>
<?php

		echo "</div>";

	echo "</div>";
?>
<!-- /.row -->