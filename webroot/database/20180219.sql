ALTER TABLE `payments` ADD `created` DATETIME NULL AFTER `id`, 
                       ADD `modified` DATETIME NULL AFTER `created`;