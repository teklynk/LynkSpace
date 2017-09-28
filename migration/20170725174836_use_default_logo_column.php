<?php

use Phinx\Migration\AbstractMigration;

class UseDefaultLogoColumn extends AbstractMigration
{

    public function up()
    {
        //Create logo_use_defaults column
        $table = $this->table('setup');
        $table->addColumn('logo_use_defaults', 'text', array('after' => 'hottitles_use_defaults'))
            ->update();

        //Update Active status
        $this->query('UPDATE setup SET logo_use_defaults="true";');
    }

    public function down()
    {
        //Create logo_use_defaults column
        $table = $this->table('setup');
        $table->removeColumn('logo_use_defaults')
            ->save();
    }
}
