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
  `order` char(11) DEFAULT NULL,
  `classification` char(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `group` int(11) DEFAULT NULL,
  `plangroup` int(11) DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `status` char(1) NOT NULL,
  `receitadespesa` char(1) NOT NULL
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
  `banco` varchar(100) NOT NULL,
  `agencia` varchar(20) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `tipoconta` char(1) DEFAULT NULL,
  `numbanco` varchar(5) NOT NULL,
  `emitecheque` char(1) NOT NULL,
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
  `providers_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `vencimento` int(2) NOT NULL,
  `title` varchar(100) NOT NULL,
  `bandeira` varchar(20) NOT NULL,
  `melhor_dia` int(2) NOT NULL,
  `limite` decimal(20,2) DEFAULT NULL,
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
  `tipo` char(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fantasia` varchar(255) DEFAULT NULL,
  `cpfcnpj` varchar(25) DEFAULT NULL,
  `ie` varchar(25) DEFAULT NULL,
  `banco` varchar(25) DEFAULT NULL,
  `agencia` varchar(25) DEFAULT NULL,
  `conta` varchar(25) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(25) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `telefone1` varchar(25) DEFAULT NULL,
  `telefone2` varchar(25) DEFAULT NULL,
  `telefone3` varchar(25) DEFAULT NULL,
  `telefone4` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL,
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
-- Table structure for table `industrializations`
--

CREATE TABLE IF NOT EXISTS `industrializations` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `sells_id` int(11) DEFAULT NULL,
  `code` int(6) NOT NULL,
  `date` date DEFAULT NULL,
  `inspecao` char(1) DEFAULT NULL,
  `multa` char(1) DEFAULT NULL,
  `databook` char(1) DEFAULT NULL,
  `certificado` varchar(255) DEFAULT NULL COMMENT 'Certificado de matéria-prima; Certificado de Garantia; Certificado de calibração de equipamento.',
  `pit` char(1) DEFAULT NULL COMMENT 'Plano de Inspeção e Testes',
  `fichaEmergencia` char(1) DEFAULT NULL,
  `fluido` varchar(80) DEFAULT NULL,
  `projeto` char(1) DEFAULT NULL,
  `temperatura` varchar(80) DEFAULT NULL,
  `are` char(1) DEFAULT NULL COMMENT 'Aditivo de Reforço Estrutural',
  `instalacao` varchar(255) DEFAULT NULL COMMENT 'Tipo de Instalação',
  `posCura` char(1) DEFAULT NULL,
  `pintura` varchar(80) DEFAULT NULL,
  `duracao` varchar(80) DEFAULT NULL,
  `compraTerceiros` varchar(255) DEFAULT NULL,
  `localEntrega` varchar(255) DEFAULT NULL,
  `resinabq` varchar(80) DEFAULT NULL COMMENT 'Barreira Química',
  `catalizadorbq` varchar(80) DEFAULT NULL COMMENT 'Barreira Química',
  `espessurabq` varchar(80) DEFAULT NULL COMMENT 'Barreira Química',
  `resinare` varchar(80) DEFAULT NULL COMMENT 'Reforço Estrutural',
  `catalizadorre` varchar(80) DEFAULT NULL COMMENT 'Reforço Estrutural',
  `espessurare` varchar(80) DEFAULT NULL COMMENT 'Reforço Estrutural',
  `emitente` varchar(80) DEFAULT NULL,
  `qualidade` varchar(80) DEFAULT NULL,
  `autorizacao1` varchar(80) DEFAULT NULL,
  `autorizacao2` varchar(80) DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'P - in progress, C - cancelled, F - finalized'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `industrialization_items`
--

CREATE TABLE IF NOT EXISTS `industrialization_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `industrializations_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE IF NOT EXISTS `inventories` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `code` int(6) NOT NULL,
  `date` date NOT NULL,
  `applicant` varchar(60) DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT 'A - active, C - cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE IF NOT EXISTS `inventory_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `inventories_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `vlcost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `transporters_id` int(11) DEFAULT NULL,
  `type` char(2) NOT NULL COMMENT 'S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing',
  `cfop` int(6) DEFAULT NULL,
  `nf` varchar(10) NOT NULL,
  `dtemissaonf` date NOT NULL,
  `dtdelivery` date DEFAULT NULL,
  `endingdate` date DEFAULT NULL,
  `freighttype` char(3) NOT NULL,
  `paymenttype` varchar(60) NOT NULL,
  `totalipi` decimal(10,2) NOT NULL,
  `totalicms` decimal(10,2) NOT NULL,
  `totalicmssubst` decimal(10,2) NOT NULL,
  `totalfreight` decimal(10,2) NOT NULL,
  `totaldiscount` decimal(10,2) NOT NULL,
  `grandtotal` decimal(10,2) NOT NULL,
  `status` char(1) NOT NULL COMMENT 'P - in progress, C - cancelled, F - finalized',
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices_purchases_sells`
--

CREATE TABLE IF NOT EXISTS `invoices_purchases_sells` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `sells_id` int(11) DEFAULT NULL,
  `purchases_id` int(11) DEFAULT NULL,
  `invoices_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `invoices_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `imobilizado` char(1) DEFAULT NULL,
  `icms` decimal(10,2) DEFAULT NULL,
  `pericms` decimal(10,2) DEFAULT NULL,
  `icmssubst` decimal(10,2) DEFAULT NULL,
  `pericmssubst` decimal(10,2) DEFAULT NULL,
  `ipi` decimal(10,2) DEFAULT NULL,
  `peripi` decimal(10,2) DEFAULT NULL,
  `vlunity` decimal(10,4) NOT NULL,
  `vldiscount` decimal(10,2) DEFAULT NULL,
  `vltotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `knowledges`
--

CREATE TABLE IF NOT EXISTS `knowledges` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviments`
--

CREATE TABLE IF NOT EXISTS `moviments` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
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
  `coins_id` int(11) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `cheque` varchar(255) DEFAULT NULL,
  `nominal` varchar(255) DEFAULT NULL,
  `emissaoch` date DEFAULT NULL,
  `creditodebito` char(1) NOT NULL,
  `data` date NOT NULL,
  `vencimento` date NOT NULL,
  `dtbaixa` date DEFAULT NULL,
  `valor` decimal(20,2) NOT NULL,
  `valorbaixa` decimal(20,2) DEFAULT NULL,
  `historico` varchar(255) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userbaixa` varchar(20) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviments_moviment_cards`
--

CREATE TABLE IF NOT EXISTS `moviments_moviment_cards` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `cards_id` int(11) NOT NULL,
  `moviments_id` int(11) NOT NULL,
  `vencimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviment_banks`
--

CREATE TABLE IF NOT EXISTS `moviment_banks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `moviment_checks_id` int(11) DEFAULT NULL,
  `transfers_id` int(11) DEFAULT NULL,
  `moviments_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `coins_id` int(11) DEFAULT NULL,
  `creditodebito` char(1) NOT NULL,
  `data` date NOT NULL,
  `vencimento` date NOT NULL,
  `dtbaixa` date NOT NULL,
  `valor` decimal(20,2) NOT NULL,
  `valorbaixa` decimal(20,2) NOT NULL,
  `documento` varchar(60) DEFAULT NULL,
  `historico` varchar(100) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviment_boxes`
--

CREATE TABLE IF NOT EXISTS `moviment_boxes` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `moviment_checks_id` int(11) DEFAULT NULL,
  `transfers_id` int(11) DEFAULT NULL,
  `moviments_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `coins_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `creditodebito` char(1) NOT NULL,
  `data` date NOT NULL,
  `vencimento` date DEFAULT NULL,
  `dtbaixa` date DEFAULT NULL,
  `valor` decimal(20,2) NOT NULL,
  `valorbaixa` decimal(20,2) NOT NULL,
  `documento` varchar(60) DEFAULT NULL,
  `historico` varchar(100) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviment_cards`
--

CREATE TABLE IF NOT EXISTS `moviment_cards` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `cards_id` int(11) NOT NULL,
  `moviments_id` int(11) DEFAULT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `coins_id` int(11) DEFAULT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `vencimento` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `documento` varchar(60) DEFAULT NULL,
  `creditodebito` char(1) NOT NULL,
  `valor` decimal(20,2) NOT NULL,
  `valorbaixa` decimal(20,2) DEFAULT NULL,
  `data` date NOT NULL,
  `dtbaixa` date DEFAULT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviment_checks`
--

CREATE TABLE IF NOT EXISTS `moviment_checks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `moviments_id` int(11) DEFAULT NULL,
  `transfers_id` int(11) DEFAULT NULL,
  `coins_id` int(11) DEFAULT NULL,
  `caixaforn` char(1) DEFAULT NULL,
  `cheque` varchar(255) NOT NULL,
  `nominal` varchar(255) DEFAULT NULL,
  `data` date NOT NULL,
  `valor` decimal(20,2) NOT NULL,
  `documento` varchar(60) DEFAULT NULL,
  `historico` varchar(100) NOT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviment_mergeds`
--

CREATE TABLE IF NOT EXISTS `moviment_mergeds` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `moviments_id` int(11) NOT NULL,
  `moviments_merged` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviment_recurrents`
--

CREATE TABLE IF NOT EXISTS `moviment_recurrents` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `moviments_id` int(11) DEFAULT NULL,
  `moviment_cards_id` int(11) DEFAULT NULL
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
  `cpfcnpj` varchar(20) DEFAULT NULL,
  `tipo` char(1) NOT NULL,
  `email_cobranca` varchar(255) NOT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `fundacao` date DEFAULT NULL,
  `logomarca` varchar(255) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `dtvalidade` date NOT NULL,
  `plans_id` int(11) DEFAULT NULL,
  `systemver` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `created`, `modified`, `razao`, `ie`, `cpfcnpj`, `tipo`, `email_cobranca`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `telefone`, `fundacao`, `logomarca`, `username`, `dtvalidade`, `plans_id`, `systemver`) VALUES
(1, '2015-07-01 09:06:37', '2015-07-01 09:06:37', 'Maksoud Rodrigues', '12345', '000.000.000-00', 'F', 'suporte@reiniciando.com.br', 'Rua Sem Nome, 0', 'Farol', 'Maceió', 'AL', '57055-000', '(82) 98133-5598', '1986-02-08', NULL, 'Renée Maksoud', '2030-01-01', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `parameters_id` int(11) NOT NULL,
  `vencimento` date NOT NULL,
  `periodo` int(2) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `plannings`
--

CREATE TABLE IF NOT EXISTS `plannings` (
  `id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `creditodebito` char(1) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `providers_id` int(11) NOT NULL,
  `coins_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `vencimento` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `parcelas` int(11) NOT NULL,
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
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `product_groups_id` int(11) DEFAULT NULL,
  `product_types_id` int(11) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `title` varchar(120) NOT NULL,
  `ean` varchar(13) DEFAULT NULL,
  `ncm` varchar(10) DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `minimum` decimal(10,4) DEFAULT NULL,
  `maximum` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_groups`
--

CREATE TABLE IF NOT EXISTS `product_groups` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `title` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_titles`
--

CREATE TABLE IF NOT EXISTS `product_titles` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `title` varchar(120) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE IF NOT EXISTS `product_types` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `title` varchar(60) NOT NULL,
  `calc_cost` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `fantasia` varchar(255) DEFAULT NULL,
  `ie` varchar(25) DEFAULT NULL,
  `cpfcnpj` varchar(25) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(25) DEFAULT NULL,
  `telefone1` varchar(25) DEFAULT NULL,
  `telefone2` varchar(25) DEFAULT NULL,
  `telefone3` varchar(25) DEFAULT NULL,
  `telefone4` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `banco` varchar(25) DEFAULT NULL,
  `agencia` varchar(25) DEFAULT NULL,
  `conta` varchar(25) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `providers_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `code` int(6) NOT NULL,
  `freighttype` char(1) NOT NULL,
  `paymenttype` varchar(60) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `totalipi` decimal(20,2) DEFAULT NULL,
  `totalicms` decimal(20,2) DEFAULT NULL,
  `totalicmssubst` decimal(20,2) DEFAULT NULL,
  `totalfreight` decimal(20,2) DEFAULT NULL,
  `totaldiscount` decimal(20,2) DEFAULT NULL,
  `grandtotal` decimal(20,2) DEFAULT NULL,
  `endingdate` date DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized',
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchases_purchase_requests`
--

CREATE TABLE IF NOT EXISTS `purchases_purchase_requests` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchases_id` int(11) NOT NULL,
  `purchase_requests_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE IF NOT EXISTS `purchase_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchases_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `imobilizado` char(1) DEFAULT NULL,
  `icms` decimal(10,2) DEFAULT NULL,
  `pericms` decimal(10,2) DEFAULT NULL,
  `icmssubst` decimal(10,2) DEFAULT NULL,
  `pericmssubst` decimal(10,2) DEFAULT NULL,
  `ipi` decimal(10,2) DEFAULT NULL,
  `peripi` decimal(10,2) DEFAULT NULL,
  `vlunity` decimal(10,4) DEFAULT NULL,
  `vldiscount` decimal(10,2) DEFAULT NULL,
  `vltotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE IF NOT EXISTS `purchase_requests` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `industrializations_id` int(1) DEFAULT NULL,
  `code` int(6) NOT NULL,
  `date` date NOT NULL,
  `applicant` varchar(60) NOT NULL,
  `authorizer` varchar(60) DEFAULT NULL,
  `dtauth` date DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'P - pending, A - in progress, C - cancelled, F - finalized',
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request_items`
--

CREATE TABLE IF NOT EXISTS `purchase_request_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `purchase_requests_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `deadline` date DEFAULT NULL
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
-- Table structure for table `requisitions`
--

CREATE TABLE IF NOT EXISTS `requisitions` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `type` char(1) NOT NULL COMMENT 'I - in, O - out',
  `code` int(6) NOT NULL,
  `date` date NOT NULL,
  `industrializations_id` int(11) DEFAULT NULL,
  `applicant` varchar(60) DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'F - finalized, C - cancelled',
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `requisition_items`
--

CREATE TABLE IF NOT EXISTS `requisition_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `requisitions_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL
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
-- Table structure for table `sells`
--

CREATE TABLE IF NOT EXISTS `sells` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `code` int(6) NOT NULL,
  `customercode` varchar(25) DEFAULT NULL,
  `freighttype` char(1) NOT NULL,
  `paymenttype` varchar(60) DEFAULT NULL,
  `shipment` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `totalquantity` decimal(10,2) DEFAULT NULL,
  `totalipi` decimal(20,2) DEFAULT NULL,
  `totalicms` decimal(20,2) DEFAULT NULL,
  `totalicmssubst` decimal(20,2) DEFAULT NULL,
  `totalfreight` decimal(20,2) DEFAULT NULL,
  `totaldiscount` decimal(20,2) DEFAULT NULL,
  `grandtotal` decimal(20,2) DEFAULT NULL,
  `endingdate` date DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized',
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sell_items`
--

CREATE TABLE IF NOT EXISTS `sell_items` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `sells_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `imobilizado` char(1) DEFAULT NULL,
  `icms` decimal(10,2) DEFAULT NULL,
  `pericms` decimal(10,2) DEFAULT NULL,
  `icmssubst` decimal(10,2) DEFAULT NULL,
  `pericmssubst` decimal(10,2) DEFAULT NULL,
  `ipi` decimal(10,2) DEFAULT NULL,
  `peripi` decimal(10,2) DEFAULT NULL,
  `vlunity` decimal(10,4) DEFAULT NULL,
  `vldiscount` decimal(10,2) DEFAULT NULL,
  `vltotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `vlcost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_balances`
--

CREATE TABLE IF NOT EXISTS `stock_balances` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `vlcost` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `support_contacts`
--

CREATE TABLE IF NOT EXISTS `support_contacts` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `ordem` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `mail` varchar(255) NOT NULL,
  `resposta` text DEFAULT NULL,
  `status` char(1) NOT NULL,
  `username` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE IF NOT EXISTS `transfers` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `banks_id` int(11) DEFAULT NULL,
  `boxes_id` int(11) DEFAULT NULL,
  `costs_id` int(11) DEFAULT NULL,
  `coins_id` int(11) DEFAULT NULL,
  `account_plans_id` int(11) DEFAULT NULL,
  `document_types_id` int(11) DEFAULT NULL,
  `event_types_id` int(11) DEFAULT NULL,
  `banks_dest` int(11) DEFAULT NULL,
  `boxes_dest` int(11) DEFAULT NULL,
  `costs_dest` int(11) DEFAULT NULL,
  `account_plans_dest` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `programacao` date DEFAULT NULL,
  `radio_origem` varchar(20) DEFAULT NULL,
  `radio_destino` varchar(20) DEFAULT NULL,
  `valor` decimal(20,2) NOT NULL,
  `documento` varchar(60) DEFAULT NULL,
  `historico` varchar(100) NOT NULL,
  `emissaoch` date DEFAULT NULL,
  `cheque` varchar(20) DEFAULT NULL,
  `nominal` varchar(120) DEFAULT NULL,
  `contabil` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  `obs` text DEFAULT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transporters`
--

CREATE TABLE IF NOT EXISTS `transporters` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `type` char(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fantasia` varchar(255) DEFAULT NULL,
  `ie` varchar(25) DEFAULT NULL,
  `im` varchar(25) DEFAULT NULL,
  `cpfcnpj` varchar(25) DEFAULT NULL,
  `contato` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(25) DEFAULT NULL,
  `telefone1` varchar(25) DEFAULT NULL,
  `telefone2` varchar(25) DEFAULT NULL,
  `telefone3` varchar(25) DEFAULT NULL,
  `telefone4` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `banco` varchar(20) DEFAULT NULL,
  `agencia` varchar(25) DEFAULT NULL,
  `conta` varchar(25) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `obs` text DEFAULT NULL
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
  `redefinir_senha` varchar(255) DEFAULT NULL,
  `tutorial` char(1) DEFAULT NULL,
  `language` varchar(5) DEFAULT NULL,
  `last_parameter` int(11) DEFAULT NULL,
  `module` char(1) NOT NULL DEFAULT 'F' COMMENT 'S = stock, F = finance, A = all'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `name`, `username`, `password`, `sendmail`, `redefinir_senha`, `tutorial`, `language`, `last_parameter`, `module`) VALUES
(1, '2015-07-01 09:06:37', '2015-07-01 09:06:37', 'Renée Maksoud', 'suporte@reiniciando.com.br', 'criptografada', 'S', '', '0', 'pt_BR', 1, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `users_parameters`
--

CREATE TABLE IF NOT EXISTS `users_parameters` (
  `id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL,
  `sendmail` char(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  `rules_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_parameters`
--

INSERT INTO `users_parameters` (`id`, `parameters_id`, `sendmail`, `created`, `users_id`, `rules_id`) VALUES
(1, 1, 'N', '2015-07-01 09:06:37', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE IF NOT EXISTS `versions` (
  `financeiro` varchar(20) NOT NULL,
  `estoque` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`financeiro`, `estoque`) VALUES
('9.15.3.19', '0.6.3.19');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `industrializations`
--
ALTER TABLE `industrializations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `sells_id` (`sells_id`);

--
-- Indexes for table `industrialization_items`
--
ALTER TABLE `industrialization_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `industrializations_id` (`industrializations_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `inventories_id` (`inventories_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `transporters_id` (`transporters_id`);

--
-- Indexes for table `invoices_purchases_sells`
--
ALTER TABLE `invoices_purchases_sells`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `sells_id` (`sells_id`),
  ADD KEY `purchases_id` (`purchases_id`),
  ADD KEY `invoices_id` (`invoices_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `invoices_id` (`invoices_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `knowledges`
--
ALTER TABLE `knowledges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moviments`
--
ALTER TABLE `moviments`
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
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `coins_id` (`coins_id`);

--
-- Indexes for table `moviments_moviment_cards`
--
ALTER TABLE `moviments_moviment_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `cards_id` (`cards_id`),
  ADD KEY `moviments_id` (`moviments_id`);

--
-- Indexes for table `moviment_banks`
--
ALTER TABLE `moviment_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `moviment_checks_id` (`moviment_checks_id`),
  ADD KEY `transfers_id` (`transfers_id`),
  ADD KEY `moviments_id` (`moviments_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `coins_id` (`coins_id`);

--
-- Indexes for table `moviment_boxes`
--
ALTER TABLE `moviment_boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `moviment_checks_id` (`moviment_checks_id`),
  ADD KEY `transfers_id` (`transfers_id`),
  ADD KEY `moviments_id` (`moviments_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `coins_id` (`coins_id`);

--
-- Indexes for table `moviment_cards`
--
ALTER TABLE `moviment_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `cards_id` (`cards_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `moviments_id` (`moviments_id`),
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `coins_id` (`coins_id`);

--
-- Indexes for table `moviment_checks`
--
ALTER TABLE `moviment_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `transfers_id` (`transfers_id`),
  ADD KEY `moviments_id` (`moviments_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `coins_id` (`coins_id`);

--
-- Indexes for table `moviment_mergeds`
--
ALTER TABLE `moviment_mergeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `moviments_id` (`moviments_id`),
  ADD KEY `moviments_merged` (`moviments_merged`);

--
-- Indexes for table `moviment_recurrents`
--
ALTER TABLE `moviment_recurrents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `moviments_id` (`moviments_id`),
  ADD KEY `moviment_cards_id` (`moviment_cards_id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `plannings`
--
ALTER TABLE `plannings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `coins_id` (`coins_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `groups_id` (`product_groups_id`),
  ADD KEY `types_id` (`product_types_id`);

--
-- Indexes for table `product_groups`
--
ALTER TABLE `product_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `product_titles`
--
ALTER TABLE `product_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `providers_id` (`providers_id`);

--
-- Indexes for table `purchases_purchase_requests`
--
ALTER TABLE `purchases_purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `purchases_id` (`purchases_id`),
  ADD KEY `purchase_requests_id` (`purchase_requests_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `purchases_id` (`purchases_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `industrializations_id` (`industrializations_id`);

--
-- Indexes for table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `purchase_requests_id` (`purchase_requests_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `regs`
--
ALTER TABLE `regs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `industrializations_id` (`industrializations_id`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `requisitions_id` (`requisitions_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `customers_id` (`customers_id`);

--
-- Indexes for table `sell_items`
--
ALTER TABLE `sell_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `sells_id` (`sells_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `stock_balances`
--
ALTER TABLE `stock_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `support_contacts`
--
ALTER TABLE `support_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_id` (`parameters_id`),
  ADD KEY `banks_id` (`banks_id`),
  ADD KEY `boxes_id` (`boxes_id`),
  ADD KEY `costs_id` (`costs_id`),
  ADD KEY `coins_id` (`coins_id`),
  ADD KEY `account_plans_id` (`account_plans_id`),
  ADD KEY `document_types_id` (`document_types_id`),
  ADD KEY `event_types_id` (`event_types_id`),
  ADD KEY `banks_dest` (`banks_dest`),
  ADD KEY `boxes_dest` (`boxes_dest`),
  ADD KEY `costs_dest` (`costs_dest`),
  ADD KEY `account_plans_dest` (`account_plans_dest`);

--
-- Indexes for table `transporters`
--
ALTER TABLE `transporters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `parameters_id` (`parameters_id`);

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
-- AUTO_INCREMENT for table `industrializations`
--
ALTER TABLE `industrializations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `industrialization_items`
--
ALTER TABLE `industrialization_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices_purchases_sells`
--
ALTER TABLE `invoices_purchases_sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `knowledges`
--
ALTER TABLE `knowledges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviments`
--
ALTER TABLE `moviments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviments_moviment_cards`
--
ALTER TABLE `moviments_moviment_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviment_banks`
--
ALTER TABLE `moviment_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviment_boxes`
--
ALTER TABLE `moviment_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviment_cards`
--
ALTER TABLE `moviment_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviment_checks`
--
ALTER TABLE `moviment_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviment_mergeds`
--
ALTER TABLE `moviment_mergeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moviment_recurrents`
--
ALTER TABLE `moviment_recurrents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_groups`
--
ALTER TABLE `product_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `regs`
--
ALTER TABLE `regs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requisition_items`
--
ALTER TABLE `requisition_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sell_items`
--
ALTER TABLE `sell_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_balances`
--
ALTER TABLE `stock_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `support_contacts`
--
ALTER TABLE `support_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transporters`
--
ALTER TABLE `transporters`
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
