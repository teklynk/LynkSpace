<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnHotTitles extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('hottitles');
        $guid->addColumn('guid', 'text', ['after' => 'url'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('hottitles');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
