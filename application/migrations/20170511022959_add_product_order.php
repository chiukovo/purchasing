<?php

use Phinx\Migration\AbstractMigration;

class AddProductOrder extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            CREATE TABLE `product_order` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `buyer` VARCHAR(200) NULL,
              `orderNum` VARCHAR(200) NULL,
              `county` VARCHAR(200) NULL,
              `district` VARCHAR(200) NULL,
              `zipcode` VARCHAR(100) NULL,
              `addressDetail` VARCHAR(200) NULL,
              `remark` TEXT NULL,
              `productInfo` TEXT NULL,
              `pre_money` float DEFAULT NULL COMMENT '預付款',
              `idCard` VARCHAR(45) COLLATE utf8_unicode_ci NULL,
              `phone` VARCHAR(45) COLLATE utf8_unicode_ci NULL,
              `isPaidOff` INT(2) NOT NULL DEFAULT 0 COMMENT '是否已付清',
              `rate` FLOAT NULL,
              `fare` FLOAT NOT NULL DEFAULT 0 COMMENT '運費',
              `total_cost_us` FLOAT NOT NULL DEFAULT 0,
              `total_cost_nt` FLOAT NOT NULL DEFAULT 0,
              `date` DATE NULL,
              `created_at` datetime DEFAULT NULL,
              `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`));
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("DROP TABLE `product_order`;");
    }
}
