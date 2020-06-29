
CREATE TABLE `industrializations` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `status` char(1) NOT NULL,
  `code` int(6) NOT NULL,
  `inspection` char(1) NOT NULL,
  `penalty` char(1) NOT NULL,
  `databook` char(1) NOT NULL,
  `certificate` char(1) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `industrialization_sells` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `industrializations_id` int(11) NOT NULL,
  `sells_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `groups_id` int(11) DEFAULT NULL,
  `types_id` int(11) NOT NULL,
  `cod_int` int(11) NOT NULL,
  `cod_ext` int(11) DEFAULT NULL,
  `title` varchar(60) NOT NULL,
  `ean` varchar(13) DEFAULT NULL,
  `ncm` varchar(10) DEFAULT NULL,
  `obs` text,
  `minimum` decimal(10,2) NOT NULL,
  `maximum` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product_groups` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `title` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `title` varchar(60) NOT NULL,
  `calc_cost` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `industrializations_id` int(11) DEFAULT NULL,
  `transporters_id` int(11) DEFAULT NULL,
  `providers_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `code` int(6) NOT NULL,
  `nf` int(8) DEFAULT NULL,
  `cfop` int(6) DEFAULT NULL,
  `dtemissaonf` date DEFAULT NULL,
  `freighttype` char(1) NOT NULL,
  `totalipi` decimal(20,2) NOT NULL,
  `totalicms` decimal(20,2) NOT NULL,
  `totalicmssubst` decimal(20,2) NOT NULL,
  `totalfreight` decimal(20,2) DEFAULT NULL,
  `totaldiscount` decimal(20,2) NOT NULL,
  `grandtotal` decimal(20,2) NOT NULL,
  `dtdelivery` date DEFAULT NULL,
  `applicant` varchar(60) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchases_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `icms` decimal(10,2) NOT NULL,
  `icmssubst` decimal(10,2) NOT NULL,
  `ipi` decimal(10,2) NOT NULL,
  `vlunity` decimal(10,2) NOT NULL,
  `vldiscount` decimal(10,2) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `date` date NOT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_order_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchase_orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_order_requests` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchase_requests_id` int(11) NOT NULL,
  `purchase_orders_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_purchase_orders` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchase_orders_id` int(11) NOT NULL,
  `purchases_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_requests` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `industrializations_id` int(11) NOT NULL,
  `code` int(6) NOT NULL,
  `date` date NOT NULL,
  `applicant` varchar(60) NOT NULL,
  `authorizer` varchar(60) NOT NULL,
  `dtauth` date NOT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_request_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchase_requests_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `requisitions` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `date` date NOT NULL,
  `industrializations_id` int(11) NOT NULL,
  `applicant` varchar(60) DEFAULT NULL,
  `authorizer` varchar(60) DEFAULT NULL,
  `dtauth` date DEFAULT NULL,
  `status` char(1) NOT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `requisition_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `requisitions_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sells` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `transporters_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `code` int(6) NOT NULL,
  `nf` int(8) DEFAULT NULL,
  `cfop` int(6) DEFAULT NULL,
  `dtemissaonf` date DEFAULT NULL,
  `freighttype` char(1) NOT NULL,
  `paymenttype` char(3) NOT NULL,
  `deadline` date DEFAULT NULL,
  `totalipi` decimal(20,2) NOT NULL,
  `totalicms` decimal(20,2) NOT NULL,
  `totalicmssubst` decimal(20,2) NOT NULL,
  `totalfreight` decimal(20,2) NOT NULL,
  `totaldiscount` decimal(20,2) NOT NULL,
  `grandtotal` decimal(20,2) NOT NULL,
  `dtdelivery` date DEFAULT NULL,
  `applicant` varchar(20) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sell_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `sells_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `icms` decimal(10,2) NOT NULL,
  `icmssubst` decimal(10,2) NOT NULL,
  `ipi` decimal(10,2) NOT NULL,
  `vlunity` decimal(10,2) NOT NULL,
  `vldiscount` decimal(10,2) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `vlcost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `stock_balances` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `vlcost` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transporters` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `type` char(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `cpfcnpj` varchar(20) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `phone1` varchar(20) DEFAULT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `telefone3` varchar(20) DEFAULT NULL,
  `telefone4` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `bank` varchar(20) DEFAULT NULL,
  `agency` varchar(20) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `industrializations`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `industrialization_items`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `industrialization_sells`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `product_groups`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_order_requests`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_purchase_orders`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `purchase_request_items`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `requisition_items`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `sell_items`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `stock_balances`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `transporters`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `industrializations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `industrialization_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `industrialization_sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `product_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_order_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchase_request_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `requisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `requisition_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sell_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `stock_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `transporters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;