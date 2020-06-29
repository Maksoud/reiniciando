ALTER TABLE `products` CHANGE `types_id` `types_id` INT(11) NULL;
ALTER TABLE `inventories` ADD `status` CHAR(1) NULL COMMENT 'A = Ativo; C = Cancelado.' AFTER `obs`;
