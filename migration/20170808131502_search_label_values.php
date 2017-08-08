<?php

use Phinx\Migration\AbstractMigration;

class SearchLabelValues extends AbstractMigration
{
    public function up(){
        $this->query('UPDATE config SET searchlabel_ls2pac="Catalog", searchlabel_ls2kids="Kid\'s Catalog";');
    }
    public function down(){
        $this->query('UPDATE config SET searchlabel_ls2pac="", searchlabel_ls2kids="";');
    }
}