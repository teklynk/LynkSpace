<?php


use Phinx\Migration\AbstractMigration;

class PageKeywords extends AbstractMigration
{
    public function change()
    {
        $users = $this->table('pages');
        $users->addColumn('keywords', 'text', ['after' => 'content'])
            ->save();
    }

    public function down()
    {
        $users = $this->table('pages');
        $users->removeColumn('keywords', 'text')
            ->save();
    }
}
