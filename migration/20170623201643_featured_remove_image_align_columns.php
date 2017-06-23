<?php

use Phinx\Migration\AbstractMigration;

class FeaturedRemoveImageAlignColumns extends AbstractMigration
{
    public function up()
    {
        //Remove image, image_align columns
        $table = $this->table('featured');
        $table->removeColumn('image');
        $table->removeColumn('image_align')
            ->update();
    }

    public function down()
    {
        //Create image, image_align columns
        $table = $this->table('featured');
        $table->addColumn('image', 'text', array('after' => 'content'));
        $table->addColumn('image_align', 'text', array('after' => 'image'))
            ->update();
    }
}
