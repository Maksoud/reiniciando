ALTER TABLE `sell_items` CHANGE `quantity` `quantity` DECIMAL(10,4) NOT NULL;
ALTER TABLE `sell_items` CHANGE `vlunity` `vlunity` DECIMAL(10,4) NOT NULL;


ALTER TABLE `sell_items` ADD `pericms` DECIMAL(10,2) NULL AFTER `icms`;
ALTER TABLE `sell_items` ADD `pericmssubst` DECIMAL(10,2) NULL AFTER `icmssubst`;
ALTER TABLE `sell_items` ADD `peripi` DECIMAL(10,2) NULL AFTER `ipi`;
