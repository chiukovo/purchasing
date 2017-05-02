<?php

use Phinx\Migration\AbstractMigration;

class AddProduct extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            CREATE TABLE `product` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
              `weight` float DEFAULT NULL,
              `amount` int(11) NOT NULL DEFAULT 0,
              `money` float DEFAULT NULL,
              `discount` float DEFAULT NULL,
              `remark` text COLLATE utf8_unicode_ci,
              `created_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("DROP TABLE `product`;");
    }
}