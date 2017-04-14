<!-- Search Site Section -->
<a name="sitesearch" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getPageList(); //from functions.php

?>

<script type="text/javascript" language="javascript">
    //Gets the list of pages
    $(document).ready(function () {
        //jQueryUI AutoComplete
        $(function () {
            var availableSearchTitles = [<?php echo rtrim($pageListJson . $pageTagsJson, ",");?>];
            //var availableSearchTags = [<?php echo rtrim($pageTagsJson, ",");?>];
            $('#site_search').autocomplete({
                source: availableSearchTitles,
                minLength: 3,
                select: function(event, ui) {
                    $('#site_search').val(ui.item.value);
                    $('form[name="siteSearchForm"]').submit();
                }
            });
        });
    });
</script>

<div class="row" id="searchsite">
    <div class="col-xs-12 col-lg-12">
        <div class="row">
            <h1 class="text-white">Site Search</h1>
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- Site Search Form -->
                    <form name="siteSearchForm" method="get">
                        <div id="custom-search-input">
                            <div class="input-group col-md-12">
                                <input type="text" class="form-control" id="site_search" name="site_search" placeholder="Search the web site"/>
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
</div>