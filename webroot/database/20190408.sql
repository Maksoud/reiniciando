ALTER TABLE `products` CHANGE `cod_int` `code` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `products` CHANGE `groups_id` `product_groups_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `products` CHANGE `types_id` `product_types_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `product_titles` DROP `providers_id`;
ALTER TABLE `product_titles` ADD `obs` TEXT NULL AFTER `title`;
