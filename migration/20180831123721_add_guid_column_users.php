<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnUsers extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('users');
        $guid->addColumn('guid', 'text', ['after' => 'level'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('users');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
