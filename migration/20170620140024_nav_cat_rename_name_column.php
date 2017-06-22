<?php

use Phinx\Migration\AbstractMigration;

class NavCatRenameNameColumn extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('category_navigation');
        $table->renameColumn('name', 'cat_name');
    }

    public function down()
    {
        $table = $this->table('category_navigation');
        $table->renameColumn('cat_name', 'name');
    }
}
