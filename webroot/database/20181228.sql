ALTER TABLE `inventories` ADD `applicant` VARCHAR(60) NULL AFTER `date`;
ALTER TABLE `purchases` CHANGE `industrializations_id` `purchase_requests_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `invoices` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, C - Cancelado, F - Finalizado';
ALTER TABLE `purchase_requests` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, A - Aguardando material, C - Cancelado, F - Finalizado';
ALTER TABLE `requisitions` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, C - Cancelado, F - Finalizado';
ALTER TABLE `sells` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, A - Em andamento, C - Cancelado, F - Finalizado';
ALTER TABLE `purchases` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Pendente, A - Em andamento, C - Cancelado, F - Finalizado';
ALTER TABLE `industrializations` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - Em processo, C - Cancelado, F - Finalizado';
