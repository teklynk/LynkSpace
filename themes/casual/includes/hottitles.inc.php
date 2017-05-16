<?php
getHottitlesTabs();

if ($hottitlesCount > 0) {
    ?>
    <div class="row hottitlesCarousel">
        <div class="box">

            <div class="col-lg-12">
                <h1><?php echo $hottitlesHeading; ?></h1>
            </div>

            <div class="col-lg-12">

                <div id="hottitlesTabs">
                    <div class="panel text-center">
                        <ul class="nav nav-pills center-tabs">
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
    <?php
}
?>