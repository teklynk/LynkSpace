<?php

use Phinx\Migration\AbstractMigration;

class UserPasswordResetHash extends AbstractMigration
{
    public function up()
    {
        //Create password_rest hash column
        $table = $this->table('users');
        $table->addColumn('password_reset', 'text', array('after' => 'password'))
            ->update();
        //Create password_reset_date column
        $table = $this->table('users');
        $table->addColumn('password_reset_date', 'date', array('after' => 'password_reset'))
            ->update();
    }

    public function down()
    {
        //Remove password_reset column
        $table = $this->table('users');
        $table->removeColumn('password_reset')
            ->update();
        //Remove password_reset_date column
        $table = $this->table('users');
        $table->removeColumn('password_reset_date')
            ->update();
    }
}
