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
    }


    public function down()
    {
        $this->dropTable('shared_uploads');
    }
}
