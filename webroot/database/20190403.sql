CREATE TABLE `product_titles` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `title` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `product_titles`
  ADD PRIMARY KEY (`id`),
  ADD INDEX(`providers_id`),
  ADD INDEX(`products_id`),
  ADD INDEX(`parameters_id`);

ALTER TABLE `products` DROP `cod_ext`;

ALTER TABLE `purchases_purchase_requests` 
  ADD INDEX(`parameters_id`),
  ADD INDEX(`purchases_id`),
  ADD INDEX(`purchase_requests_id`);