ALTER TABLE `users_parameters` ADD `sendmail` CHAR(1) NULL AFTER `parameters_id`;
UPDATE `users_parameters` SET `sendmail` = 'S' WHERE `users_parameters`.`id` = 2;
UPDATE `users_parameters` SET `sendmail` = 'S' WHERE `users_parameters`.`id` = 27;
UPDATE `users_parameters` SET `sendmail` = 'S' WHERE `users_parameters`.`id` = 126;

UPDATE `users_parameters` SET sendmail = 'S' WHERE users_id IN (13, 88, 89);
UPDATE `users_parameters` SET sendmail = 'N' WHERE users_id NOT IN (13, 88, 89);
