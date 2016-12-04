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
            $("#loc_name").autocomplete({
                source: availableTags
            });
        });
    });
    </script>

    <div class="container">
        <div class="row">
            <h1 class="text-white">Search Schools</h1>
            <form name="locSearchForm" action="" method="get">
            <div id="custom-search-input">
                <div class="input-group col-md-12">

                    <input type="text" class="form-control" id="loc_name" name="loc_name" placeholder="School Name" />
                    <input type="hidden" id="loc_id" name="loc_id" value="<?php echo $_GET['loc_id'];?>" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="submit">
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
            </form>
        </div>
    </div>
<?php

		echo "</div>";

	echo "</div>";
?>
<!-- /.row -->