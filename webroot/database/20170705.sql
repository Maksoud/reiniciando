ALTER TABLE `account_plans` CHANGE `order` `classification` CHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `account_plans` CHANGE `group` `plangroup` INT(11) NULL DEFAULT NULL;

/*
ALTER TABLE `account_plans` ADD `classification` CHAR(11) NULL AFTER `order`;
ALTER TABLE `account_plans` ADD `plangroup` INT(11) NULL AFTER `group`;
UPDATE `account_plans` SET `classification` = `order`;
UPDATE `account_plans` SET `plangroup` = `group`;
*/