ALTER TABLE  `parameters` ADD  `systemver` FLOAT NULL ;
UPDATE `parameters` SET `systemver` =  '2' WHERE  `parameters`.`id` = 1;
UPDATE `parameters` SET `systemver` =  '2' WHERE  `parameters`.`id` = 11;
UPDATE `parameters` SET `systemver` =  '2' WHERE  `parameters`.`id` = 12;
UPDATE `parameters` SET `systemver` =  '2' WHERE  `parameters`.`id` = 13;
UPDATE `parameters` SET `systemver` =  '2' WHERE  `parameters`.`id` = 79;
UPDATE `parameters` SET `systemver` =  '1.5' WHERE  `parameters`.`systemver` IS NULL;

ALTER TABLE `users` DROP `systemver`;