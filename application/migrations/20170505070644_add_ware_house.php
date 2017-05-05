<?php

use Phinx\Migration\AbstractMigration;

class AddWareHouse extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            CREATE TABLE `warehouse_setting` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` TEXT COLLATE utf8_unicode_ci NOT NULL,
              `receiver` TEXT COLLATE utf8_unicode_ci NOT NULL,
              `freight` TEXT COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`id`));
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("DROP TABLE `warehouse_setting`;");
    }
}
