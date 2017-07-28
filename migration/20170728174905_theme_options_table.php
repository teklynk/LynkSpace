<?php

use Phinx\Migration\AbstractMigration;

class ThemeOptionsTable extends AbstractMigration
{

    public function up()
    {
        $sharedUploads = $this->table('theme_options');
        $sharedUploads->addColumn('themename', 'text')
            ->addColumn('themeoptions', 'text')
            ->addColumn('datetime', 'datetime')
            ->addColumn('loc_id', 'integer')
            ->addIndex(array('id'), array('unique' => true))
            ->save();
        //Modifies the datetime column so that it grabs the current date when the rows updated. Phinx does not have this natively.
        $this->execute('ALTER TABLE `theme_options` MODIFY COLUMN `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        //Add foreign key constraint to loc_id. Delete row when location is deleted. Based on loc_id.
        $this->execute('ALTER TABLE `theme_options` ADD CONSTRAINT `theme_options_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
    }


    public function down()
    {
        $exists = $this->hasTable('theme_options');
        if ($exists) {
            $table = $this->table('theme_options');
            $table->drop();
        }
    }
}
