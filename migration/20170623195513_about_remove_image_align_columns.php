<?php

use Phinx\Migration\AbstractMigration;

class AboutRemoveImageAlignColumns extends AbstractMigration
{
    public function up()
    {
        //Remove image, image_align columns
        $table = $this->table('aboutus');
        $table->removeColumn('image');
        $table->removeColumn('image_align')
            ->update();
    }

    public function down()
    {
        //Create image, image_align columns
        $table = $this->table('aboutus');
        $table->addColumn('image', 'text', array('after' => 'content'));
        $table->addColumn('image_align', 'text', array('after' => 'image'))
            ->update();
    }
}
