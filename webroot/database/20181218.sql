CREATE TABLE `inventories` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `code` INT(6) NOT NULL,
  `date` DATE NOT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `inventory_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `inventories_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `vlcost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;