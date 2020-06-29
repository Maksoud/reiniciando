ALTER TABLE `balances` ADD `created` DATETIME NOT NULL AFTER `parameters_id`;
ALTER TABLE `balances` ADD `modified` DATETIME NOT NULL AFTER `created`;

ALTER TABLE `banks` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `banks` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `banks` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `boxes` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `boxes` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `boxes` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `cards` CHANGE `providers_id` `providers_id` INT(11) NULL;

ALTER TABLE `coins` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `coins` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `coins` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `costs` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `costs` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `costs` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `customers` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `customers` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `customers` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `customers` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `document_types` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `document_types` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `document_types` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `event_types` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `event_types` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `event_types` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `moviments` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `moviments` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `moviments` CHANGE `documento` `documento` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `moviments` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moviments` CHANGE `contabil` `contabil` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moviments` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `moviment_banks` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `moviment_banks` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `moviment_banks` CHANGE `valorbaixa` `valorbaixa` DECIMAL(20,2) NOT NULL;
ALTER TABLE `moviment_banks` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moviment_banks` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `moviment_boxes` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `moviment_boxes` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `moviment_boxes` CHANGE `contabil` `contabil` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moviment_boxes` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moviment_boxes` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `moviment_cards` CHANGE `coins_id` `coins_id` INT(11) NULL;

ALTER TABLE `moviment_checks` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `moviment_checks` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `moviment_checks` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moviment_checks` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `transfers` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `transfers` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `transfers` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `transfers` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `parameters` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `parameters` CHANGE `modified` `modified` DATETIME NOT NULL;

ALTER TABLE `providers` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `providers` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `providers` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `providers` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `plannings` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `plannings` CHANGE `modified` `modified` DATETIME NOT NULL;
ALTER TABLE `plannings` CHANGE `username` `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `regs` CHANGE `created` `created` DATETIME NOT NULL;

ALTER TABLE `users` CHANGE `created` `created` DATETIME NOT NULL;
ALTER TABLE `users` CHANGE `modified` `modified` DATETIME NOT NULL;
