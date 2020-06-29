ALTER TABLE `purchase_items` ADD `pericms` DECIMAL(10,2) NULL AFTER `icms`;
ALTER TABLE `purchase_items` ADD `peripi` DECIMAL(10,2) NULL AFTER `ipi`;
ALTER TABLE `purchase_items` ADD `pericmssubst` DECIMAL(10,2) NULL AFTER `icmssubst`;
ALTER TABLE `purchase_items` CHANGE `vlunity` `vlunity` DECIMAL(10,4) NOT NULL;
ALTER TABLE `purchase_items` CHANGE `quantity` `quantity` DECIMAL(10,4) NOT NULL;
ALTER TABLE `invoices` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `invoices_purchases_sells` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `invoice_items` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `invoice_items` ADD `pericms` DECIMAL(10,2) NULL AFTER `icms`;
ALTER TABLE `invoice_items` ADD `peripi` DECIMAL(10,2) NULL AFTER `ipi`;
ALTER TABLE `invoice_items` ADD `pericmssubst` DECIMAL(10,2) NULL AFTER `icmssubst`;
ALTER TABLE `industrializations` DROP `deadline`;
DROP TABLE `purchase_orders`, `purchase_order_items`, `purchase_order_requests`, `purchase_purchase_orders`;
ALTER TABLE `industrializations` DROP `customers_id`, DROP `providers_id`;
ALTER TABLE `purchase_requests` CHANGE `industrializations_id` `industrializations_id` INT(1) NULL;
ALTER TABLE `purchase_requests` CHANGE `authorizer` `authorizer` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `purchase_requests` CHANGE `dtauth` `dtauth` DATE NULL;
ALTER TABLE `requisitions` CHANGE `industrializations_id` `industrializations_id` INT(11) NULL;

