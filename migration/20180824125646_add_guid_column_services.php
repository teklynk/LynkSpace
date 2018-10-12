<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnServices extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('services');
        $guid->addColumn('guid', 'text', ['after' => 'content'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('services');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
