<?php

use Phinx\Migration\AbstractMigration;

class Ls2SearchLabels extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('config');
        $table->addColumn('searchlabel_ls2pac', 'text', array('after' => 'setuppacurl'))
            ->update();
        $table->addColumn('searchlabel_ls2kids', 'text', array('after' => 'searchlabel_ls2pac'))
            ->update();
    }

    public function down()
    {
        $table = $this->table('config');
        $table->removeColumn('searchlabel_ls2pac')
            ->save();
        $table->removeColumn('searchlabel_ls2kids')
            ->save();
    }
}
