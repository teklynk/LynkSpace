<?php
getHottitlesTabs();

if ($hottitlesCount > 0) {
    ?>
    <div class="container-fluid hottitlesCarousel">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <h2 class="page-header"><?php echo $hottitlesHeading; ?></h2>

                    <div id="hottitlesTabs">
                        <div class="panel text-center">
                            <ul class="nav nav-tabs center-tabs">
                                <?php echo $hottitlesTabs; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="carousel slide loader-size-MD" id="hottitlesCarousel">
                        <div class="carousel-inner MD"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
}
?>