-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2020 at 08:20 PM
-- Server version: 10.3.23-MariaDB

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";


-- --------------------------------------------------------

--
-- Table structure for table `account_plans`
--

CREATE TABLE IF NOT EXISTS `account_plans` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `classification` char(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `plangroup` int(11) DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `status` char(1) NOT NULL,
  `recipeexpense` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE IF NOT EXISTS `balances` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `cards_id` int(11) DEFAULT NULL,
  `plannings_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `value` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE IF NOT EXISTS `banks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `agency` varchar(20) NOT NULL,
  `account` varchar(20) NOT NULL,
  `account_type` char(1) DEFAULT NULL,
  `bank_number` varchar(5) NOT NULL,
  `check_emitter` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `boxes`
--

CREATE TABLE IF NOT EXISTS `boxes` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `bill_date` int(2) NOT NULL,
  `title` varchar(100) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `best_after` int(2) NOT NULL,
  `limit` decimal(20,2) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

CREATE TABLE IF NOT EXISTS `costs` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `type` char(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  `cpfcnpj` varchar(25) DEFAULT NULL,
  `ie` varchar(25) DEFAULT NULL,
  `im` varchar(25) DEFAULT NULL,
  `bank` varchar(25) DEFAULT NULL,
  `agency` varchar(25) DEFAULT NULL,
  `account` varchar(25) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(100) DEFAULT NULL,
  `cep` varchar(25) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `phone1` varchar(25) DEFAULT NULL,
  `phone2` varchar(25) DEFAULT NULL,
  `phone3` varchar(25) DEFAULT NULL,
  `phone4` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `vinculapgto` char(1) NOT NULL,
  `duplicadoc` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE IF NOT EXISTS `event_types` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `knowledges`
--

CREATE TABLE IF NOT EXISTS `knowledge` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movements`
--

CREATE TABLE IF NOT EXISTS `movements` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `cards_id` int(11) DEFAULT NULL,
  `plannings_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `document_number` varchar(255) DEFAULT NULL,
  `check_number` varchar(255) DEFAULT NULL,
  `check_name` varchar(255) DEFAULT NULL,
  `check_date` date DEFAULT NULL,
  `recipeexpense` char(1) NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value` decimal(20,2) NOT NULL,
  `value_consolidation` decimal(20,2) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userbaixa` varchar(20) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movements_movement_cards`
--

CREATE TABLE IF NOT EXISTS `movements_movement_cards` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `cards_id` int(11) NOT NULL,
  `movements_id` int(11) NOT NULL,
  `bill_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movement_banks`
--

CREATE TABLE IF NOT EXISTS `movement_banks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `movement_checks_id` int(11) DEFAULT NULL,
  `transfers_id` int(11) DEFAULT NULL,
  `movements_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `recipeexpense` char(1) NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `date_consolidation` date NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `value_consolidation` decimal(20,2) NOT NULL,
  `document_number` varchar(60) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movement_boxes`
--

CREATE TABLE IF NOT EXISTS `movement_boxes` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `movement_checks_id` int(11) DEFAULT NULL,
  `transfers_id` int(11) DEFAULT NULL,
  `movements_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `recipeexpense` char(1) NOT NULL,
  `date` date NOT NULL,
  `bill_date` date DEFAULT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value` decimal(20,2) NOT NULL,
  `value_consolidation` decimal(20,2) NOT NULL,
  `document_number` varchar(60) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movement_cards`
--

CREATE TABLE IF NOT EXISTS `movement_cards` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `cards_id` int(11) NOT NULL,
  `movements_id` int(11) DEFAULT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `bill_date` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `document_number` varchar(60) DEFAULT NULL,
  `recipeexpense` char(1) NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `value_consolidation` decimal(20,2) DEFAULT NULL,
  `date` date NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movement_checks`
--

CREATE TABLE IF NOT EXISTS `movement_checks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `movements_id` int(11) DEFAULT NULL,
  `transfers_id` int(11) DEFAULT NULL,
  `caixaforn` char(1) DEFAULT NULL,
  `check_number` varchar(255) NOT NULL,
  `check_name` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `document_number` varchar(60) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movement_mergeds`
--

CREATE TABLE IF NOT EXISTS `movement_mergeds` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `movements_id` int(11) NOT NULL,
  `movements_merged` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movement_recurrents`
--

CREATE TABLE IF NOT EXISTS `movement_recurrents` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `movements_id` int(11) DEFAULT NULL,
  `movement_cards_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `razao` varchar(60) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `im` varchar(25) DEFAULT NULL,
  `cpfcnpj` varchar(20) DEFAULT NULL,
  `tipo` char(1) NOT NULL,
  `email_cobranca` varchar(255) NOT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `phone1` varchar(20) DEFAULT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `fundacao` date DEFAULT NULL,
  `logomarca` varchar(255) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `dtvalidade` date NOT NULL,
  `plans_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `created`, `modified`, `razao`, `ie`, `cpfcnpj`, `tipo`, `email_cobranca`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `phone1`, `fundacao`, `logomarca`, `username`, `dtvalidade`, `plans_id`, `systemver`) VALUES
(1, '2015-07-01 09:06:37', '2015-07-01 09:06:37', 'Maksoud Rodrigues', '12345', '000.000.000-00', 'F', 'suporte@reiniciando.com.br', 'Rua Sem Nome, 0', 'Farol', 'Maceió', 'AL', '57055-000', '(82) 98133-5598', '1986-02-08', NULL, 'Renée Maksoud', '2030-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plannings`
--

CREATE TABLE IF NOT EXISTS `plannings` (
  `id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `recipeexpense` char(1) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `providers_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `parcels` int(11) NOT NULL,
  `obs` text DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `created`, `modified`, `title`, `value`) VALUES
(1, '2015-07-01 10:40:00', '2015-07-01 10:40:00', 'Pessoal', 123.45),
(2, '2015-07-01 10:40:00', '2015-07-01 10:40:00', 'Simples', 234.56),
(3, '2015-07-01 10:40:00', '2015-07-01 10:40:00', 'Completo', 345.67),
(4, '2015-07-01 16:59:59', '2015-07-01 16:59:59', 'Limitado', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `tipo` char(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  `ie` varchar(25) DEFAULT NULL,
  `im` varchar(25) DEFAULT NULL,
  `cpfcnpj` varchar(25) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(25) DEFAULT NULL,
  `phone1` varchar(25) DEFAULT NULL,
  `phone2` varchar(25) DEFAULT NULL,
  `phone3` varchar(25) DEFAULT NULL,
  `phone4` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `bank` varchar(25) DEFAULT NULL,
  `agency` varchar(25) DEFAULT NULL,
  `account` varchar(25) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `regs`
--

CREATE TABLE IF NOT EXISTS `regs` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `log_type` varchar(60) NOT NULL,
  `function` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `username` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `rule` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `created`, `rule`) VALUES
(1, '2016-08-19 19:41:00', 'super'),
(2, '2016-08-19 19:41:00', 'admin'),
(3, '2016-08-19 19:41:00', 'user'),
(4, '2016-08-19 19:41:00', 'cont');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE IF NOT EXISTS `transfers` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `banks_dest` int(11) DEFAULT NULL,
  `boxes_dest` int(11) DEFAULT NULL,
  `costs_dest` int(11) DEFAULT NULL,
  `account_plans_dest` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `radio_source` varchar(20) DEFAULT NULL,
  `radio_destination` varchar(20) DEFAULT NULL,
  `value` decimal(20,2) NOT NULL,
  `document_number` varchar(60) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `check_date` date DEFAULT NULL,
  `check_number` varchar(20) DEFAULT NULL,
  `check_name` varchar(120) DEFAULT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(80) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sendmail` char(1) NOT NULL DEFAULT '0',
  `language` varchar(5) DEFAULT NULL,
  `last_parameter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `name`, `username`, `password`, `language`, `last_parameter`) VALUES
(1, '2015-07-01 09:06:37', '2015-07-01 09:06:37', 'Renée Maksoud', 'suporte@reiniciando.com.br', 'criptografada', 'pt_BR', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_parameters`
--

CREATE TABLE IF NOT EXISTS `users_parameters` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `mailler` char(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  `rules_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_parameters`
--

INSERT INTO `users_parameters` (`id`, `parameters_id`, `mailler`, `created`, `users_id`, `rules_id`) VALUES
(1, 1, 'N', '2015-07-01 09:06:37', 1, 1);

-- --------------------------------------------------------

--
-- Indexes for table `account_plans`
--
ALTER TABLE `account_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `boxes`
--
ALTER TABLE `boxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `costs_id` (`costs_id`);

--
-- Indexes for table `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `knowledges`
--
ALTER TABLE `knowledge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `cards_id` (`cards_id`),
  ADD KEY `plannings_id` (`plannings_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `account_plans_id` (`account_plans_id`);

--
-- Indexes for table `movements_movement_cards`
--
ALTER TABLE `movements_movement_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `cards_id` (`cards_id`),
  ADD KEY `movements_id` (`movements_id`);

--
-- Indexes for table `movement_banks`
--
ALTER TABLE `movement_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `movement_checks_id` (`movement_checks_id`),
  ADD KEY `transfers_id` (`transfers_id`),
  ADD KEY `movements_id` (`movements_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `account_plans_id` (`account_plans_id`);

--
-- Indexes for table `movement_boxes`
--
ALTER TABLE `movement_boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `movement_checks_id` (`movement_checks_id`),
  ADD KEY `transfers_id` (`transfers_id`),
  ADD KEY `movements_id` (`movements_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `account_plans_id` (`account_plans_id`);

--
-- Indexes for table `movement_cards`
--
ALTER TABLE `movement_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `cards_id` (`cards_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `movements_id` (`movements_id`),
  ADD KEY `account_plans_id` (`account_plans_id`);

--
-- Indexes for table `movement_checks`
--
ALTER TABLE `movement_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `transfers_id` (`transfers_id`),
  ADD KEY `movements_id` (`movements_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `account_plans_id` (`account_plans_id`);

--
-- Indexes for table `movement_mergeds`
--
ALTER TABLE `movement_mergeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `movements_id` (`movements_id`),
  ADD KEY `movements_merged` (`movements_merged`);

--
-- Indexes for table `movement_recurrents`
--
ALTER TABLE `movement_recurrents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `movements_id` (`movements_id`),
  ADD KEY `movement_cards_id` (`movement_cards_id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plannings`
--
ALTER TABLE `plannings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `providers_id` (`providers_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `regs`
--
ALTER TABLE `regs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `banks_dest` (`banks_dest`),
  ADD KEY `boxes_dest` (`boxes_dest`),
  ADD KEY `costs_dest` (`costs_dest`),
  ADD KEY `account_plans_dest` (`account_plans_dest`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_parameters`
--
ALTER TABLE `users_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `rules_id` (`rules_id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_plans`
--
ALTER TABLE `account_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `boxes`
--
ALTER TABLE `boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `costs`
--
ALTER TABLE `costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `knowledges`
--
ALTER TABLE `knowledge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movements_movement_cards`
--
ALTER TABLE `movements_movement_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement_banks`
--
ALTER TABLE `movement_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement_boxes`
--
ALTER TABLE `movement_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement_cards`
--
ALTER TABLE `movement_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement_checks`
--
ALTER TABLE `movement_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement_mergeds`
--
ALTER TABLE `movement_mergeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement_recurrents`
--
ALTER TABLE `movement_recurrents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `plannings`
--
ALTER TABLE `plannings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `regs`
--
ALTER TABLE `regs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_parameters`
--
ALTER TABLE `users_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
