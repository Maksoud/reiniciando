ALTER TABLE  `users` ADD  `language` VARCHAR( 5 ) NULL ;
UPDATE  `users` SET  `language` =  'pt_BR' WHERE  `users`.`id` <> 1;