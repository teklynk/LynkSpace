<?php

use Phinx\Migration\AbstractMigration;

class ConfigTimeOutValues extends AbstractMigration
{
    public function up()
    {
        $this->query('UPDATE config SET session_timeout=60 WHERE session_timeout = 3600');
        $this->query('UPDATE config SET carousel_speed="5" WHERE carousel_speed = 5000');
    }

    public function down()
    {
        $this->query('UPDATE config SET session_timeout=3600 WHERE session_timeout = 60');
        $this->query('UPDATE config SET carousel_speed="5000" WHERE carousel_speed = 5');
    }
}
