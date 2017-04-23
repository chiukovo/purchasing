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
            CREATE TABLE `purchasing`.`order` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `productId` VARCHAR(200) NULL,
              `orderNum` VARCHAR(100) NOT NULL,
              `address` VARCHAR(200) NULL,
              `phone` VARCHAR(45) NULL,
              `idCard` VARCHAR(45) NULL,
              `remarks` TEXT NULL,
              `payment` FLOAT NOT NULL DEFAULT 0,
              `rate` FLOAT NULL,
              `totalWeight` FLOAT NOT NULL DEFAULT 0,
              `boxWeight` FLOAT NOT NULL DEFAULT 0,
              `freight` FLOAT NOT NULL DEFAULT 0,
              `created_at` DATETIME NULL,
            PRIMARY KEY (`id`));
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("DROP TABLE `order`;");
    }
}
