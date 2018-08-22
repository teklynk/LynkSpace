<?php

use Phinx\Migration\AbstractMigration;

class PageGuidColumn extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('pages');
        $guid->addColumn('guid', 'text', ['after' => 'content'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('pages');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
