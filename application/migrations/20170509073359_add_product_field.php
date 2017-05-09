<?php

use Phinx\Migration\AbstractMigration;

class AddProductField extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            ALTER TABLE `product`
            ADD COLUMN `warehouse` INT(11) NULL DEFAULT NULL AFTER `code`,
            ADD COLUMN `receiver` INT(11) NULL DEFAULT NULL AFTER `warehouse`,
            ADD COLUMN `freight` INT(11) NULL DEFAULT NULL AFTER `receiver`,
            ADD COLUMN `tracking_code` VARCHAR(200) NULL DEFAULT NULL AFTER `freight`;
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}
