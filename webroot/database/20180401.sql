ALTER TABLE `moviment_cards` ADD `customers_id` INT(11) NULL AFTER `coins_id`, 
                             ADD `providers_id` INT(11) NULL AFTER `customers_id`;