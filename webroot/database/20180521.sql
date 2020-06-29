ALTER TABLE  `plannings` ADD  `creditodebito` CHAR( 1 ) NOT NULL AFTER  `modified` ;
ALTER TABLE  `plannings` ADD  `customers_id` INT( 11 ) NULL AFTER  `creditodebito` ;
ALTER TABLE  `plannings` ADD  `vencimento` DATE NOT NULL AFTER  `data` ;
ALTER TABLE  `plannings` ADD  `account_plans_id` INT( 11 ) NULL AFTER  `modified` ;
ALTER TABLE  `plannings` ADD  `costs_id` INT( 11 ) NULL AFTER  `account_plans_id` ;