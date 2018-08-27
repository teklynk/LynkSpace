<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnNavigation extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('navigation');
        $guid->addColumn('guid', 'text', ['after' => 'url'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('navigation');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
