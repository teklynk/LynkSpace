<?php

use Phinx\Migration\AbstractMigration;

class ColumnThemeUseDefaults extends AbstractMigration
{

    public function up()
    {
        //Create Active column
        $table = $this->table('setup');
        $table->addColumn('theme_use_defaults', 'text', array('after' => 'logo_use_defaults'))
            ->update();

        //Update theme_use_defaults status
        $this->query('UPDATE setup SET theme_use_defaults="true";');
    }

    public function down()
    {
        //Create logo_use_defaults column
        $table = $this->table('setup');
        $table->removeColumn('theme_use_defaults')
            ->save();
    }
}
