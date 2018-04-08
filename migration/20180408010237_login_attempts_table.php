<?php


use Phinx\Migration\AbstractMigration;

class LoginAttemptsTable extends AbstractMigration
{
    public function up()
    {
        $eventsTable = $this->table('login_attempts');
        $eventsTable->addColumn('ip', 'text')
            ->addColumn('attempts', 'integer')
            ->addColumn('datetime', 'datetime')
            ->addIndex(array('id'), array('unique' => true))
            ->save();
    }

    public function down()
    {
        $exists = $this->hasTable('login_attempts');
        if ($exists) {
            $table = $this->table('login_attempts');
            $table->drop();
        }
    }
}
