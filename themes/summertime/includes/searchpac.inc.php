<!-- Search PAC Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');

    getLocList($_GET['loc_id'], 'true');
    getSetup($_GET['loc_id']); //from functions.php
}
?>
<script type="text/javascript" language="javascript">
    //Gets the list of locations
    $(document).ready(function () {
        //jQueryUI AutoComplete
        $(function () {
            var availableTags = [<?php echo rtrim($locationListJson, ",");?>];
            $('#loc_name').autocomplete({
                source: availableTags,
                minLength: 3,
                select: function(event, ui) {
                    $('#loc_name').val(ui.item.value);
                    $('form[name="locSearchForm"]').submit();
                }
            });
        });
    });
</script>
<?php
if ($setupSearchDefault == 1) {
    $searchFilters = "<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
        <span id='search_concept'>Catalog</span> <span class='caret'></span>
    </button>
    <ul class='dropdown-menu' role='menu'>
        <li><a href=''>Kid's Catalog</a></li>
    </ul>";
} elseif ($setupSearchDefault == 2) {
    $searchFilters = "<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
        <span id='search_concept'>Kid's Catalog</span> <span class='caret'></span>
    </button>
    <ul class='dropdown-menu' role='menu'>
        <li><a href=''>Catalog</a></li>
    </ul>";
}
?>
<form name="ls2pacForm" method="post" onSubmit="return getSearchString(3, this, TLCDomain, TLCConfig, TLCBranch, 'ls2', true);">

    <div class="input-group">
        <div class="input-group-btn search-panel">
            <?php echo $searchFilters;?>
        </div>
        <input type="hidden" name="search_param" value="all" id="search_param">
        <input type="text" class="form-control" name="term" placeholder=""/>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
        </span>
    </div>

</form>


