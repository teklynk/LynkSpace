<?php

use Phinx\Migration\AbstractMigration;

class SearchPlaceholderColumnsAndValues extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('config');
        $table->addColumn('searchplaceholder_ls2pac', 'text', array('after' => 'searchlabel_ls2pac'))
            ->update();
        $table->addColumn('searchplaceholder_ls2kids', 'text', array('after' => 'searchlabel_ls2kids'))
            ->update();
        $this->query('UPDATE config SET searchplaceholder_ls2kids="Find children\'s book and more.", searchplaceholder_ls2pac="Find anything at the library. Start here.";');
    }

    public function down()
    {
        $table = $this->table('config');
        $table->removeColumn('searchplaceholder_ls2pac')
            ->update();
        $table->removeColumn('searchplaceholder_ls2kids')
            ->update();
    }
}
