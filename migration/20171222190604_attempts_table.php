<?php

use Phinx\Migration\AbstractMigration;

class AttemptsTable extends AbstractMigration
{

    public function change()
    {
        $eventsTable = $this->table('login_attempts');
        $eventsTable->addColumn('ip', 'text')
            ->addColumn('attempts', 'integer')
            ->addColumn('datetime', 'datetime')
            ->addIndex(array('id'), array('unique' => true))
            ->save();
        //Modifies the datetime column so that it grabs the current date when the rows updated. Phinx does not have this natively.
        $this->execute('ALTER TABLE `login_attempts` MODIFY COLUMN `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
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
