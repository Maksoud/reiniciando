ALTER TABLE  `parameters` DROP  `mf_coins_id` ,
DROP  `mf_document_types_id` ,
DROP  `mf_carriers_id` ,
DROP  `mf_event_types_id` ,
DROP  `mf_contabil` ,
DROP  `mf_costs_id` ,
DROP  `mf_account_plans_id` ,
DROP  `mc_coins_id` ,
DROP  `mc_creditodebito` ,
DROP  `mc_contabil` ,
DROP  `mc_event_boxes_id` ,
DROP  `mc_costs_id` ,
DROP  `mc_account_plans_id` ,
DROP  `mb_coins_id` ,
DROP  `mb_creditodebito` ,
DROP  `mb_contabil` ,
DROP  `mb_event_banks_id` ,
DROP  `mb_event_types_id` ,
DROP  `mb_costs_id` ,
DROP  `mb_account_plans_id` ,
DROP  `mt_coins_id` ,
DROP  `mt_contabil` ,
DROP  `mt_event_types_id` ,
DROP  `mt_costs_id` ,
DROP  `mt_account_plans_id` ,
DROP  `mh_coins_id` ,
DROP  `mh_event_banks_id` ,
DROP  `mh_event_boxes_id` ,
DROP  `mh_event_types_id` ,
DROP  `mh_contabil` ,
DROP  `mh_costs_id` ,
DROP  `mh_account_plans_id` ,
DROP  `mensalidade` ,
DROP  `periodo_ativacao` ;

DROP TABLE transporters;

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `plans` (`id`, `created`, `modified`, `title`, `value`) VALUES ('1', '2018-05-25 10:40:00', '2018-05-25 10:40:00', 'Pessoal', '358.80');
INSERT INTO `plans` (`id`, `created`, `modified`, `title`, `value`) VALUES ('2', '2018-05-25 10:40:00', '2018-05-25 10:40:00', 'Simples', '838.80');
INSERT INTO `plans` (`id`, `created`, `modified`, `title`, `value`) VALUES ('3', '2018-05-25 10:40:00', '2018-05-25 10:40:00', 'Completo', '1558.80');

ALTER TABLE `parameters` CHANGE `plano` `plans_id` INT( 11 ) NULL ;
UPDATE `parameters` SET `plans_id`= 3 WHERE `parameters`.`id` = 1;
UPDATE `parameters` SET `plans_id`= 3 WHERE `parameters`.`id` = 11;
UPDATE `parameters` SET `plans_id`= 1 WHERE `parameters`.`id` = 12;
UPDATE `parameters` SET `plans_id`= 3 WHERE `parameters`.`id` = 13;
UPDATE `parameters` SET `plans_id`= 3 WHERE `parameters`.`id` = 79;