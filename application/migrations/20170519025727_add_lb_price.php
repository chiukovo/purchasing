<?php

use Phinx\Migration\AbstractMigration;

class AddLbPrice extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            ALTER TABLE `product_order`
            ADD COLUMN `lb_price` FLOAT DEFAULT 0 AFTER `fare`
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}
