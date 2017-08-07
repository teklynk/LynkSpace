<!-- Search PAC Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');

    getSetup($_GET['loc_id']); //from functions.php
}
?>
<script type="text/javascript" language="javascript">
    //Gets the list of locations
    $(document).ready(function () {
        //jQueryUI AutoComplete
        $(function () {
            var availableTags = [<?php getLocList($_GET['loc_id'], 'true');?>];
            $('#search_term').autocomplete({
                source: availableTags,
                minLength: 3,
                select: function(event, ui) {
                    $('#search_term').val(ui.item.value);
                    $('form[name="searchform"]').submit();
                }
            });
        });
    });
</script>

<nav class="navbar navbar-default">
    <div class="nav nav-justified navbar-nav">

        <form class="navbar-form navbar-search" id="searchform" role="search" name="ls2pacForm" method="post" action="" target="_blank">
            <div class="input-group">

                <div class="input-group-btn">
                    <?php if ($setupSearchDefault == 1) { ?>
                    <button type="button" class="btn btn-search btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-search"></span>
                        <span class="label-icon">Catalog</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-left" role="menu">
                        <?php if ($setupLs2pac== 'true') {?>
                            <li>
                                <a href="#" onclick="$('#search_term').attr('name', 'term'), $('#searchform').attr('action', '<?php echo setupPACURL; ?>');">
                                    <span class="glyphicon glyphicon-search"></span>
                                    <span class="label-icon">Catalog</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($setupLs2kids == 'true') {?>
                            <li>
                                <a href="#" onclick="$('#search_term').attr('name', 'searchString'), $('#searchform').attr('action', '<?php echo setupPACURL."/kids"; ?>');">
                                    <span class="glyphicon glyphicon-search"></span>
                                    <span class="label-icon">Kid's Catalog</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="#" onclick="$('#search_term').attr('name', 'term'), $('#searchform').attr('action', 'index.php');">
                                <span class="glyphicon glyphicon-search"></span>
                                <span class="label-icon">Location Search</span>
                            </a>
                        </li>
                    </ul>
                    <?php } elseif($setupSearchDefault == 2) { ?>
                    <button type="button" class="btn btn-search btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-search"></span>
                        <span class="label-icon">Kid's Catalog</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-left" role="menu">
                        <?php if ($setupLs2kids == 'true') {?>
                            <li>
                                <a href="#" onclick="$('#search_term').attr('name', 'searchString'), $('#searchform').attr('action', '<?php echo setupPACURL."/kids"; ?>');">
                                    <span class="glyphicon glyphicon-search"></span>
                                    <span class="label-icon">Kid's Catalog</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($setupLs2pac == 'true') {?>
                            <li>
                                <a href="#" onclick="$('#search_term').attr('name', 'term'), $('#searchform').attr('action', '<?php echo setupPACURL; ?>');">
                                    <span class="glyphicon glyphicon-search"></span>
                                    <span class="label-icon">Catalog</span>
                                </a>
                            </li>
                        <?php } ?>

                    <?php } ?>
                        <li>
                            <a href="#" onclick="$('#search_term').attr('name', 'term'), $('#searchform').attr('action', 'index.php');">
                                <span class="glyphicon glyphicon-search"></span>
                                <span class="label-icon">Location Search</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="config" id="search_config" value="<?php echo $setupConfig; ?>">
                <input type="hidden" name="section" id="search_section" value="search">
                <input type="text" name="term" id="search_term" class="form-control" value="">

                <div class="input-group-btn">
                    <button type="submit" class="btn btn-search btn-default btn-success">
                        GO
                    </button>
                </div>

            </div>
        </form>

    </div>
</nav>

<script type="text/javascript" language="javascript">
    $(function(){
        <?php if ($setupSearchDefault == 1 && $setupLs2pac == 'true') { ?>
            $('#searchform').attr('action', '<?php echo setupPACURL; ?>');
        <?php } elseif ($setupSearchDefault == 2 && $setupLs2kids == 'true') { ?>
            $('#searchform').attr('action', '<?php echo setupPACURL."/kids"; ?>');
        <?php } else { ?>
            $('#searchform').attr('action', 'sitesearch.php?loc_id=<?php echo $_GET['loc_id']; ?>');
        <?php } ?>

        $(".input-group-btn .dropdown-menu li a").click(function(){
            var selText = $(this).html();
            $(this).parents('.input-group-btn').find('.btn-search').html(selText);
        });
    });
</script>