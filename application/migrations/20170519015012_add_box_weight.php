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
            ADD COLUMN `boxWeight` FLOAT DEFAULT 0 AFTER `weight`
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}
