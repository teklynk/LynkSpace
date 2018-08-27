<?php


use Phinx\Migration\AbstractMigration;

class AddGuidColumnSlider extends AbstractMigration
{
    public function up()
    {
        $guid = $this->table('slider');
        $guid->addColumn('guid', 'text', ['after' => 'content'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('slider');
        $users->removeColumn('guid', 'text')
            ->save();
    }
}
