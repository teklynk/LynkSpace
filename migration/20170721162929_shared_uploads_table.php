<?php

use Phinx\Migration\AbstractMigration;

class SharedUploadsTable extends AbstractMigration
{

    public function up()
    {
        $sharedUploads = $this->table('shared_uploads');
        $sharedUploads->addColumn('shared', 'text')
            ->addColumn('filename', 'text')
            ->addColumn('datetime', 'datetime')
            ->addColumn('loc_id', 'integer')
            ->addIndex(array('id'), array('unique' => true))
            ->save();
        //Modifies the datetime column so that it grabs the current date when the row s updated. Phinx does not have this natively.
        $this->execute('ALTER TABLE `shared_uploads` MODIFY COLUMN `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        //Add foreign key constraint to loc_id. Delete row when location is deleted. Based on loc_id.
        $this->execute('ALTER TABLE `shared_uploads` ADD CONSTRAINT `shared_uploads_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
    }


    public function down()
    {
        $this->dropTable('shared_uploads');
    }
}