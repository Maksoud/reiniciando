ALTER TABLE `moviment_banks` ADD INDEX(`parameters_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`banks_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`costs_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`document_types_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`event_types_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`moviment_checks_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`transfers_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`moviments_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`providers_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`customers_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`account_plans_id`);
ALTER TABLE `moviment_banks` ADD INDEX(`coins_id`);

ALTER TABLE `moviments` ADD INDEX(`parameters_id`);
ALTER TABLE `moviments` ADD INDEX(`banks_id`);
ALTER TABLE `moviments` ADD INDEX(`boxes_id`);
ALTER TABLE `moviments` ADD INDEX(`cards_id`);
ALTER TABLE `moviments` ADD INDEX(`plannings_id`);
ALTER TABLE `moviments` ADD INDEX(`costs_id`);
ALTER TABLE `moviments` ADD INDEX(`event_types_id`);
ALTER TABLE `moviments` ADD INDEX(`providers_id`);
ALTER TABLE `moviments` ADD INDEX(`customers_id`);
ALTER TABLE `moviments` ADD INDEX(`document_types_id`);
ALTER TABLE `moviments` ADD INDEX(`account_plans_id`);
ALTER TABLE `moviments` ADD INDEX(`coins_id`);

ALTER TABLE `moviments_moviment_cards` ADD INDEX(`parameters_id`);
ALTER TABLE `moviments_moviment_cards` ADD INDEX(`cards_id`);
ALTER TABLE `moviments_moviment_cards` ADD INDEX(`moviments_id`);

ALTER TABLE `moviment_boxes` ADD INDEX(`parameters_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`boxes_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`costs_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`document_types_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`event_types_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`moviment_checks_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`transfers_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`moviments_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`providers_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`customers_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`account_plans_id`);
ALTER TABLE `moviment_boxes` ADD INDEX(`coins_id`);

ALTER TABLE `moviment_cards` ADD INDEX(`parameters_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`cards_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`banks_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`boxes_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`costs_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`document_types_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`event_types_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`moviments_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`account_plans_id`);
ALTER TABLE `moviment_cards` ADD INDEX(`coins_id`);

ALTER TABLE `moviment_checks` ADD INDEX(`parameters_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`banks_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`boxes_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`costs_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`event_types_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`transfers_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`moviments_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`providers_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`account_plans_id`);
ALTER TABLE `moviment_checks` ADD INDEX(`coins_id`);

ALTER TABLE `moviment_mergeds` ADD INDEX(`parameters_id`);
ALTER TABLE `moviment_mergeds` ADD INDEX(`moviments_id`);
ALTER TABLE `moviment_mergeds` ADD INDEX(`moviments_merged`);

ALTER TABLE `moviment_recurrents` ADD INDEX(`parameters_id`);
ALTER TABLE `moviment_recurrents` ADD INDEX(`moviments_id`);
ALTER TABLE `moviment_recurrents` ADD INDEX(`moviment_cards_id`);

ALTER TABLE `plannings` ADD INDEX(`parameters_id`);
ALTER TABLE `plannings` ADD INDEX(`providers_id`);
ALTER TABLE `plannings` ADD INDEX(`coins_id`);

ALTER TABLE `transfers` ADD INDEX(`parameters_id`);
ALTER TABLE `transfers` ADD INDEX(`banks_id`);
ALTER TABLE `transfers` ADD INDEX(`boxes_id`);
ALTER TABLE `transfers` ADD INDEX(`costs_id`);
ALTER TABLE `transfers` ADD INDEX(`coins_id`);
ALTER TABLE `transfers` ADD INDEX(`account_plans_id`);
ALTER TABLE `transfers` ADD INDEX(`document_types_id`);
ALTER TABLE `transfers` ADD INDEX(`event_types_id`);
ALTER TABLE `transfers` ADD INDEX(`banks_dest`);
ALTER TABLE `transfers` ADD INDEX(`boxes_dest`);
ALTER TABLE `transfers` ADD INDEX(`costs_dest`);
ALTER TABLE `transfers` ADD INDEX(`account_plans_dest`);

ALTER TABLE `users_parameters` ADD INDEX(`users_id`);
ALTER TABLE `users_parameters` ADD INDEX(`rules_id`);
ALTER TABLE `users_parameters` ADD INDEX(`parameters_id`);

ALTER TABLE `account_plans` ADD INDEX(`parameters_id`);
ALTER TABLE `balances` ADD INDEX(`parameters_id`);
ALTER TABLE `banks` ADD INDEX(`parameters_id`);
ALTER TABLE `boxes` ADD INDEX(`parameters_id`);
ALTER TABLE `cards` ADD INDEX(`parameters_id`);
ALTER TABLE `cards` ADD INDEX(`providers_id`);
ALTER TABLE `cards` ADD INDEX(`costs_id`);
ALTER TABLE `coins` ADD INDEX(`parameters_id`);
ALTER TABLE `costs` ADD INDEX(`parameters_id`);
ALTER TABLE `customers` ADD INDEX(`parameters_id`);
ALTER TABLE `document_types` ADD INDEX(`parameters_id`);
ALTER TABLE `event_types` ADD INDEX(`parameters_id`);
ALTER TABLE `payments` ADD INDEX(`parameters_id`);
ALTER TABLE `providers` ADD INDEX(`parameters_id`);
ALTER TABLE `regs` ADD INDEX(`parameters_id`);
ALTER TABLE `regs` ADD INDEX(`users_id`);
ALTER TABLE `support_contacts` ADD INDEX(`parameters_id`);
ALTER TABLE `transporters` ADD INDEX(`parameters_id`);