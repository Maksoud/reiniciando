ALTER TABLE `balances` CHANGE `created` `created` DATETIME NULL DEFAULT NULL;
ALTER TABLE `balances` CHANGE `modified` `modified` DATETIME NULL DEFAULT NULL;
ALTER TABLE `account_plans` CHANGE `order` `order` CHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `transporters` ADD PRIMARY KEY(`id`);
ALTER TABLE `transporters` ADD INDEX(`id`);
ALTER TABLE `transporters` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
