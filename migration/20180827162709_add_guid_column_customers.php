<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnCustomers extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('customers');
        $guid->addColumn('guid', 'text', ['after' => 'content'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('customers');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
