ALTER TABLE `regs` CHANGE `table` `function` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

/*
ALTER TABLE `regs` ADD `function` VARCHAR(60) NOT NULL AFTER `table`;
UPDATE `regs` SET `function` = `table`;
*/