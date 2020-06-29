
CREATE TABLE `purchases_purchase_requests` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchases_id` int(11) NOT NULL,
  `purchase_requests_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `purchases_purchase_requests`
  ADD PRIMARY KEY (`id`);