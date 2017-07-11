<!-- Search PAC Section -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');

    getSetup(); //from functions.php
}

if ($setupLs2pac == 'true' || $setupLs2kids == 'true') {

    if ($setupLs2pac == 'true') {
        ?>
        <!-- LS2PACSearch Form -->

        <form name="ls2pacForm" method="post" onSubmit="return getSearchString(3, this, TLCDomain, TLCConfig, TLCBranch, 'ls2', true);">
            <div class="input-group pull-right">
                <h1>Search the Catalog</h1>
                <input type="text" class="form-control form-group" name="term" placeholder="LS2 PAC"/>

                <select class="form-control form-group" id="sel1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>

                <button class="form-control form-group btn btn-primary" type="submit">Search</button>
            </div>

        </form>

        <?php
    }
}
?>