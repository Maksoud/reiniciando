ALTER TABLE `users` ADD `module` CHAR(1) NOT NULL DEFAULT 'F' COMMENT 'S = stock, F = finance, A = all' AFTER `last_parameter`;
UPDATE users SET users.module = 'F' WHERE users.module = '';