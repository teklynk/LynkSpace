<?php

use Phinx\Migration\AbstractMigration;

class NavAddColumnActive extends AbstractMigration
{
    public function up()
    {
        //Create Active column
        $table = $this->table('navigation');
        $table->addColumn('active', 'text', array('after' => 'section'))
            ->update();

        //Update Active status
        $this->query('UPDATE navigation SET active="true" WHERE sort<>0;');
        $this->query('UPDATE navigation SET active="false" WHERE sort=0;');
    }

    public function down()
    {
        //Remove Active column
        $table = $this->table('navigation');
        $table->removeColumn('active')
            ->update();
    }
}
