ALTER TABLE `requisitions` ADD `type` CHAR(1) NOT NULL COMMENT 'I - in, O - out' AFTER `username`;
ALTER TABLE `requisitions` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'F - finalized, C - cancelled';
ALTER TABLE `sells` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, D - in delivery, C - cancelled, F - finalized';
ALTER TABLE `purchases` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, D - in delivery, C - cancelled, F - finalized';
ALTER TABLE `purchase_requests` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, A - in progress, C - cancelled, F - finalized';
ALTER TABLE `invoices` CHANGE `type` `type` CHAR(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing';
ALTER TABLE `invoices` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, C - cancelled, F - finalized';
ALTER TABLE `industrializations` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P - pending, C - cancelled, F - finalized';
ALTER TABLE `inventories` CHANGE `status` `status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'A - active, C - cancelled';
