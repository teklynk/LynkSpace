<!-- Search Locations Section -->
<a name="search" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
getLocList();
getSetup(); //from functions.php

//if ($setupLs2pac == 'true' || $setupLs2kids == 'true') {
    ?>

    <script type="text/javascript" language="javascript">
        //Gets the list of locations
        $(document).ready(function () {
            //jQueryUI AutoComplete
            $(function () {
                var availableTags = [<?php echo rtrim($locationListJson, ",");?>];
                $("#loc_name").autocomplete({
                    source: availableTags
                });
            });
        });
    </script>

    <div class="row" id="searchlocations">
        <div class="col-xs-12 col-lg-12">

            <div class="row">

                <h1 class="text-white">Search School Libraries</h1>

                <div class="panel with-nav-tabs panel-default">
                    <?php
                    if ($setupLs2pac == 'true' || $setupLs2kids == 'true') {
                        ?>
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <?php
                                echo "<li class='active'><a href='#tab1default' data-toggle='tab'>Schools</a></li>";

                                if ($setupSearchDefault == 1) {
                                    if ($setupLs2pac == 'true') {
                                        echo "<li><a href='#tab2default' data-toggle='tab'>LS2 PAC</a></li>";
                                    }
                                    if ($setupLs2kids == 'true') {
                                        echo "<li><a href='#tab3default' data-toggle='tab'>LS2 Kids</a></li>";
                                    }
                                } else {
                                    if ($setupLs2kids == 'true') {
                                        echo "<li><a href='#tab3default' data-toggle='tab'>LS2 Kids</a></li>";
                                    }
                                    if ($setupLs2pac == 'true') {
                                        echo "<li><a href='#tab2default' data-toggle='tab'>LS2PAC</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="panel-body">
                        <div class="tab-content">
                            <!-- Schools Search Form -->
                            <div class="tab-pane fade in active" id="tab1default">
                                <form name="locSearchForm" action="index.php" method="get">
                                    <div id="custom-search-input">
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control" id="loc_name" name="loc_name" placeholder="School Name"/>
                                            <input type="hidden" id="loc_id" name="loc_id" value="<?php echo $_GET['loc_id']; ?>"/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger" type="submit" name="schoolsearch_submit">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php
                            if ($setupLs2pac == 'true') {
                                ?>
                                <!-- LS2PACSearch Form -->
                                <div class="tab-pane fade in" id="tab2default">
                                    <form name="ls2pacForm" method="post" onSubmit="return getSearchString(3, this, TLCDomain, TLCConfig, TLCBranch, 'ls2', true);">
                                        <div id="custom-search-input">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" name="term" placeholder="LS2 PAC"/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-danger" type="submit" name="ls2pac_submit">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }

                            if ($setupLs2kids == 'true') {
                                ?>
                                <!-- LS2Kids Search Form -->
                                <div class="tab-pane fade in" id="tab3default">
                                    <form name="ls2kidspacForm" method="post" onSubmit="return getSearchString(3, this, TLCDomain, TLCConfig, TLCBranch, 'kids5', true);">
                                        <div id="custom-search-input">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" name="term" placeholder="LS2 Kids"/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-danger" type="submit" name="ls2kids_submit">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>

                        </div>

                    </div>
                </div>
                <div class="input-group col-md-12 text-center center-block">
                    <?php
                    //EXAMPLE: getNav($navSection,$dropdown,$pull)
                    getNav('Search', 'false', 'center');
                    ?>
                </div>
            </div>

        </div>
    </div>
    <?php
//}
?>