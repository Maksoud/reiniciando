DROP TABLE `industrialization_sells`;

ALTER TABLE `sells` DROP `transporters_id`, DROP `nf`, DROP `cfop`, DROP `dtdelivery`, DROP `dtemissaonf`;
ALTER TABLE `purchases` DROP `transporters_id`, DROP `nf`, DROP `cfop`, DROP `dtdelivery`, DROP `dtemissaonf`;

ALTER TABLE `sells` ADD `authorizer` VARCHAR(20) NULL AFTER `applicant`;
ALTER TABLE `purchases` ADD `authorizer` VARCHAR(20) NULL AFTER `applicant`;

ALTER TABLE `purchases` ADD `paymenttype` CHAR(3) NULL AFTER `freighttype`;
ALTER TABLE `purchases` ADD `deadline` DATE NULL AFTER `paymenttype`;

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `transporters_id` int(11) DEFAULT NULL,
  `type` char(1) NOT NULL,
  `cfop` int(6) DEFAULT NULL,
  `nf` int(10) NOT NULL,
  `dtemissaonf` date NOT NULL,
  `dtdelivery` date DEFAULT NULL,
  `freighttype` char(3) NOT NULL,
  `paymenttype` varchar(12) NOT NULL,
  `totalipi` decimal(10,2) NOT NULL,
  `totalicms` decimal(10,2) NOT NULL,
  `totalicmssubst` decimal(10,2) NOT NULL,
  `totalfreight` decimal(10,2) NOT NULL,
  `totaldiscount` decimal(10,2) NOT NULL,
  `grandtotal` decimal(10,2) NOT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `invoices_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `icms` decimal(10,2) DEFAULT NULL,
  `icmssubst` decimal(10,2) DEFAULT NULL,
  `ipi` decimal(10,2) DEFAULT NULL,
  `vlunity` decimal(10,4) NOT NULL,
  `vldiscount` decimal(10,2) DEFAULT NULL,
  `vltotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `industrializations` ADD `customers_id` INT(11) NULL AFTER `username`, ADD `providers_id` INT(11) NULL AFTER `customers_id`;
ALTER TABLE `industrializations` ADD `sells_id` INT(11) NULL AFTER `providers_id`;
ALTER TABLE `industrializations` ADD `deadline` DATE NULL AFTER `certificate`;

CREATE TABLE `invoices_purchases_sells` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `sells_id` int(11) DEFAULT NULL,
  `purchases_id` int(11) DEFAULT NULL,
  `invoices_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `invoices_purchases_sells`
  ADD PRIMARY KEY (`id`);

