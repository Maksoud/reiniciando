--
-- Indexes for table `industrializations`
--
ALTER TABLE `industrializations`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `sells_id` (`sells_id`);

--
-- Indexes for table `industrialization_items`
--
ALTER TABLE `industrialization_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `industrializations_id` (`industrializations_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `inventories_id` (`inventories_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `transporters_id` (`transporters_id`);

--
-- Indexes for table `invoices_purchases_sells`
--
ALTER TABLE `invoices_purchases_sells`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `sells_id` (`sells_id`),
  ADD KEY `purchases_id` (`purchases_id`),
  ADD KEY `invoices_id` (`invoices_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `invoices_id` (`invoices_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `groups_id` (`groups_id`),
  ADD KEY `types_id` (`types_id`);

--
-- Indexes for table `product_groups`
--
ALTER TABLE `product_groups`
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `purchase_requests_id` (`purchase_requests_id`),
  ADD KEY `providers_id` (`providers_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `purchases_id` (`purchases_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `industrializations_id` (`industrializations_id`);

--
-- Indexes for table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `purchase_requests_id` (`purchase_requests_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `industrializations_id` (`industrializations_id`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `requisitions_id` (`requisitions_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `customers_id` (`customers_id`);

--
-- Indexes for table `sell_items`
--
ALTER TABLE `sell_items`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `sells_id` (`sells_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `stock_balances`
--
ALTER TABLE `stock_balances`
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `products_id` (`products_id`);

DROP TABLE `stock`;
DELETE FROM `balances` WHERE `parameters_id` = 0;
DELETE FROM `moviments` WHERE `parameters_id` = 0;