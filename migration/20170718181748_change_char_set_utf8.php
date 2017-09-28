<?php

use Phinx\Migration\AbstractMigration;

class ChangeCharSetUtf8 extends AbstractMigration
{
    public function up()
    {
        $this->execute('ALTER DATABASE CHARACTER SET utf8');
        $this->execute('ALTER DATABASE COLLATE=utf8_unicode_ci');
        $this->execute('ALTER TABLE config CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE locations CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE sections_customers CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE hottitles CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {

    }
}
