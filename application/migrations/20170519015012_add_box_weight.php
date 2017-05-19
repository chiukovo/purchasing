<?php

use Phinx\Migration\AbstractMigration;

class AddBoxWeight extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            ALTER TABLE `product`
            ADD COLUMN `boxWeight` VARCHAR(200) NULL DEFAULT NULL AFTER `weight`
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}
