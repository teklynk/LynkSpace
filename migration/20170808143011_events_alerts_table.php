<?php

use Phinx\Migration\AbstractMigration;

class EventsAlertsTable extends AbstractMigration
{
    public function up(){
        $eventsTable = $this->table('events');
        $eventsTable->addColumn('heading', 'text')
            ->addColumn('alert', 'text')
            ->addColumn('startdate', 'date')
            ->addColumn('enddate', 'date')
            ->addColumn('calendar', 'text')
            ->addColumn('use_defaults', 'text')
            ->addColumn('author_name', 'text')
            ->addColumn('datetime', 'datetime')
            ->addColumn('loc_id', 'integer')
            ->addIndex(array('id'), array('unique' => true))
            ->save();
        //Modifies the datetime column so that it grabs the current date when the rows updated. Phinx does not have this natively.
        $this->execute('ALTER TABLE `events` MODIFY COLUMN `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        //Add foreign key constraint to loc_id. Delete row when location is deleted. Based on loc_id.
        $this->execute('ALTER TABLE `events` ADD CONSTRAINT `events_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down(){
        $exists = $this->hasTable('events');
        if ($exists) {
            $table = $this->table('events');
            $table->drop();
        }
    }
}
