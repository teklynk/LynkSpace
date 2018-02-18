<?php

use Phinx\Migration\AbstractMigration;

class PrependImagePathToImages extends AbstractMigration
{

    public function up()
    {
        $this->query('UPDATE setup SET logo=CONCAT_WS(\'\', \'../uploads/1/\', logo) WHERE logo != "";');
        $this->query('UPDATE customers SET image=CONCAT_WS(\'\', \'../uploads/1/\', image) WHERE image != "";');
        $this->query('UPDATE services SET image=CONCAT_WS(\'\', \'../uploads/1/\', image) WHERE image != "";');
        $this->query('UPDATE slider SET image=CONCAT_WS(\'\', \'../uploads/1/\', image) WHERE image != "";');
        $this->query('UPDATE team SET image=CONCAT_WS(\'\', \'../uploads/1/\', image) WHERE image != "";');
    }

    public function down()
    {
        $this->query('UPDATE setup SET logo=replace(logo, \'../uploads/1/\', \'\') WHERE logo != "";');
        $this->query('UPDATE customers SET image=replace(image, \'../uploads/1/\', \'\') WHERE image != "";');
        $this->query('UPDATE services SET image=replace(image, \'../uploads/1/\', \'\') WHERE image != "";');
        $this->query('UPDATE slider SET image=replace(image, \'../uploads/1/\', \'\') WHERE image != "";');
        $this->query('UPDATE team SET image=replace(image, \'../uploads/1/\', \'\') WHERE image != "";');
    }
}
