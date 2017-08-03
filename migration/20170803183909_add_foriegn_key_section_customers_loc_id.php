<?php

use Phinx\Migration\AbstractMigration;

class AddForiegnKeySectionCustomersLocId extends AbstractMigration
{

    public function up()
    {
        $table = $this->table('sections_customers');
        $table->addForeignKey(array('loc_id'), 'locations', array('id'),
                array('delete'=> 'CASCADE', 'update'=> 'CASCADE', 'constraint' => 'sections_customers_loc_id_fk'))
            ->save();
    }

    public function down()
    {

    }
}
