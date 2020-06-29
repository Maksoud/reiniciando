ALTER TABLE `products` CHANGE `minimum` `minimum` DECIMAL(10,4) NULL DEFAULT NULL;
ALTER TABLE `products` CHANGE `maximum` `maximum` DECIMAL(10,4) NULL DEFAULT NULL;
ALTER TABLE `stock_balances` CHANGE `quantity` `quantity` DECIMAL(10,4) NOT NULL;
ALTER TABLE `purchases` ADD `dtauth` DATE NULL AFTER `authorizer`;
ALTER TABLE `sells` ADD `dtauth` DATE NULL AFTER `authorizer`;
