<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}
?>
<!-- Search Site Section -->
<a name="sitesearch" tabindex="-1"></a>

<h1 class="text-white sitesearchheading">Site Search</h1>
<div class="panel panel-default">
    <div class="panel-body">
        <!-- Site Search Form -->
        <form name="siteSearchForm" method="post" action="page.php?loc_id=<?php echo loc_id; ?>">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control" id="sitesearchterm" name="sitesearchterm"
                           value="<?php echo $_POST['sitesearchterm']; ?>" placeholder="Search the web site"/>
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="submit" name="sitesearch_submit">
                            <span class="fa fa-search"></span>
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if (!empty($_POST['sitesearchterm'])) {
    getSiteSearchResults($_POST['sitesearchterm'],false);
}
?>