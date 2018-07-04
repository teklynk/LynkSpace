<!-- Search Site Section -->
<a name="sitesearch" tabindex="-1"></a>

<div class="col-xs-12 col-lg-12" id="sitesearch">
    <div class="row">
        <h1 class="text-white sitesearchheading">Site Search</h1>
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Site Search Form -->
                <form name="siteSearchForm" method="post" action="sitesearch.php?loc_id=<?php echo $_GET['loc_id']; ?>">
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
    </div>
</div>