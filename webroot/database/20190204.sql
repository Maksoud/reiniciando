ALTER TABLE `requisitions` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'F - Finalizado, C - Cancelado';
ALTER TABLE `requisitions` DROP `authorizer`, DROP `dtauth`;
ALTER TABLE `industrializations` ADD `date` DATE NULL AFTER `code`;
ALTER TABLE `sells` ADD `shipment` DATE NULL AFTER `paymenttype`;
ALTER TABLE `sells` ADD `customercode` VARCHAR(25) NULL AFTER `code`;
ALTER TABLE `sells` DROP `applicant`, DROP `authorizer`;
ALTER TABLE `sells` CHANGE `dtauth` `endingdate` DATE NULL DEFAULT NULL;
ALTER TABLE `purchases` DROP `applicant`, DROP `authorizer`;
ALTER TABLE `purchases` CHANGE `dtauth` `endingdate` DATE NULL DEFAULT NULL;
