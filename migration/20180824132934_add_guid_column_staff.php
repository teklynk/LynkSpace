<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnStaff extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('team');
        $guid->addColumn('guid', 'text', ['after' => 'content'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('team');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
