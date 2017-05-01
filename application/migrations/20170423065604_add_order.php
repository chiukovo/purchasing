<?php

use Phinx\Migration\AbstractMigration;

class AddOrder extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            CREATE TABLE `purchase_order` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `productId` VARCHAR(200) NULL,
              `date` DATETIME NULL,
              `idCard` VARCHAR(45) NULL,
              `payment` FLOAT NOT NULL DEFAULT 0,
              `rate` FLOAT NULL,
              `total_cost_us` FLOAT NOT NULL DEFAULT 0,
              `total_cost_nt` FLOAT NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`));
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("DROP TABLE `purchase_order`;");
    }
}
