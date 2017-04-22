<?php

use Phinx\Migration\AbstractMigration;

class AddProductNum extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            ALTER TABLE `product` ADD COLUMN `amount` INT(11) NOT NULL DEFAULT 0 AFTER `name`;
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("ALTER TABLE `product` DROP COLUMN `amount`;");
    }
}
