<?php

use Phinx\Migration\AbstractMigration;

class AddFieldProduct extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("
            ALTER TABLE `product`
            DROP COLUMN `discount`,
            CHANGE COLUMN `amount` `amount` INT(11) NOT NULL DEFAULT 0 COMMENT '數量' ,
            CHANGE COLUMN `weight` `weight` FLOAT NOT NULL DEFAULT 0 COMMENT '重量' ,
            CHANGE COLUMN `remark` `remark` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT '備註' ,
            ADD COLUMN `standard` VARCHAR(200) NULL COMMENT '規格' AFTER `remark`;
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}
