ALTER TABLE `invoices` CHANGE `nf` `nf` VARCHAR(10) NOT NULL;
ALTER TABLE `invoices` CHANGE `paymenttype` `paymenttype` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `purchases` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized';
ALTER TABLE `sells` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized';
