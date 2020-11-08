<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}

getSetup( loc_id ); //from functions.php

if ( $setupLs2pac == 'true' || $setupLs2kids == 'true' ) {
	?>
    <!-- Search PAC Section -->
    <a name="search" tabindex="-1"></a>

    <div class="row" id="searchpac">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="row">

                <h1 class="text-white searchpacheading">Search</h1>

                <div class="panel with-nav-tabs panel-default">

					<?php
					if ( $setupLs2pac == 'true' && $setupLs2kids == 'true' ) {
						?>
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">

								<?php
								if ( $setupSearchDefault == 1 ) {
									echo "<li class='active'><a href='#tab1default' data-toggle='tab'>" . setupLS2PACLabel . "</a></li>";
									echo "<li><a href='#tab2default' data-toggle='tab'>" . setupLS2KidsLabel . "</a></li>";
								} else {
									echo "<li class='active'><a href='#tab2default' data-toggle='tab'>" . setupLS2KidsLabel . "</a></li>";
									echo "<li><a href='#tab1default' data-toggle='tab'>" . setupLS2PACLabel . "</a></li>";
								}
								?>

                            </ul>
                        </div>
						<?php
					}
					?>
                    <div class="panel-body">
                        <div class="tab-content">

							<?php
							if ( $setupLs2pac == 'true' ) {
								if ( $setupSearchDefault == 1 ) {
									$isDefault1 = 'active';
								} else {
									$isDefault1 = '';
								}
								?>
                                <!-- LS2PACSearch Form -->
                                <div class="tab-pane fade in <?php echo $isDefault1; ?>" id="tab1default">
                                    <form name="ls2pacForm" method="post"
                                          onSubmit="return getSearchString(3, this, TLCDomain, TLCConfig, TLCBranch, 'ls2', true);">
                                        <div id="custom-search-input">
                                            <div class="input-group col-md-12">
                                                <input type="search" class="form-control" name="term"
                                                       placeholder="<?php echo setupLS2PACPlaceholder; ?>"/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-danger" type="submit" name="ls2pac_submit">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								<?php
							}

							if ( $setupLs2kids == 'true' ) {
								if ( $setupSearchDefault == 2 ) {
									$isDefault2 = 'active';
								} else {
									$isDefault2 = '';
								}
								?>
                                <!-- LS2Kids Search Form -->
                                <div class="tab-pane fade in <?php echo $isDefault2; ?>" id="tab2default">
                                    <form name="ls2kidspacForm" method="post"
                                          onSubmit="return getSearchString(3, this, TLCDomain, TLCConfig, TLCBranch, 'kids5', true);">
                                        <div id="custom-search-input">
                                            <div class="input-group col-md-12">
                                                <input type="search" class="form-control" name="term"
                                                       placeholder="<?php echo setupLS2KidsPlaceholder; ?>"/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-danger" type="submit"
                                                            name="ls2packids_submit">
                                                        <span class="fa fa-search"></span>
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
                <div class="input-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center center-block">
					<?php
					//EXAMPLE: getNav($navSection,$dropdown,$pull,$sitesearchlink)
					getNav( loc_id, 'Search', 'false', 'center', 'false' );
					?>
                </div>
            </div>

        </div>
    </div>
	<?php
} else {
    echo "";
}
?>