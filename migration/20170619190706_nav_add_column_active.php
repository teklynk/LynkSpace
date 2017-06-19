<?php

use Phinx\Migration\AbstractMigration;

class NavAddColumnActive extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('navigation');
        $table->addColumn('active', 'text', array('after' => 'section'))
            ->update();
    }

    public function down()
    {
        $table = $this->table('navigation');
        $table->removeColumn('active')
            ->update();
    }
}
