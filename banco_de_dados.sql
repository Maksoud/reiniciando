-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2020 at 07:23 PM
-- Server version: 8.0.19
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reinicia_financeiro`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_plans`
--

CREATE TABLE `account_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `plangroup` bigint UNSIGNED DEFAULT NULL,
  `classification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipeexpense` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `banks_id` bigint UNSIGNED DEFAULT NULL,
  `boxes_id` bigint UNSIGNED DEFAULT NULL,
  `cards_id` bigint UNSIGNED DEFAULT NULL,
  `plannings_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_number` int DEFAULT NULL,
  `check_emitter` tinyint(1) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boxes`
--

CREATE TABLE `boxes` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_day` int NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `best_after` int NOT NULL,
  `limit` decimal(10,2) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

CREATE TABLE `costs` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razao_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpfcnpj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `im` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vinculapgto` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duplicadoc` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge`
--

CREATE TABLE `knowledge` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(135, '2014_10_12_000000_create_users_table', 1),
(136, '2019_08_19_000000_create_failed_jobs_table', 1),
(137, '2020_07_18_045354_knowledge', 1),
(138, '2020_07_18_045356_plans', 1),
(139, '2020_07_18_045357_roles', 1),
(140, '2020_07_18_045358_parameters', 1),
(141, '2020_07_18_045359_users_parameters', 1),
(142, '2020_07_18_045400_account_plans', 1),
(143, '2020_07_18_045401_costs', 1),
(144, '2020_07_18_045402_document_types', 1),
(145, '2020_07_18_045403_event_types', 1),
(146, '2020_07_18_045404_banks', 1),
(147, '2020_07_18_045405_boxes', 1),
(148, '2020_07_18_045406_cards', 1),
(149, '2020_07_18_045407_customers', 1),
(150, '2020_07_18_045408_providers', 1),
(151, '2020_07_18_045409_plannings', 1),
(152, '2020_07_18_045410_transfers', 1),
(153, '2020_07_18_045411_movements', 1),
(154, '2020_07_18_045412_movement_checks', 1),
(155, '2020_07_18_045413_movement_banks', 1),
(156, '2020_07_18_045414_movement_boxes', 1),
(157, '2020_07_18_045415_movement_cards', 1),
(158, '2020_07_18_045418_movements_movement_cards', 1),
(159, '2020_07_18_045419_movement_mergeds', 1),
(160, '2020_07_18_045420_movement_recurrents', 1),
(161, '2020_07_18_045421_balances', 1),
(162, '2020_07_18_045425_regs', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movements`
--

CREATE TABLE `movements` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `banks_id` bigint UNSIGNED DEFAULT NULL,
  `boxes_id` bigint UNSIGNED DEFAULT NULL,
  `cards_id` bigint UNSIGNED DEFAULT NULL,
  `plannings_id` bigint UNSIGNED DEFAULT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `event_types_id` bigint UNSIGNED DEFAULT NULL,
  `document_types_id` bigint UNSIGNED DEFAULT NULL,
  `providers_id` bigint UNSIGNED DEFAULT NULL,
  `customers_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipeexpense` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value_consolidation` decimal(10,2) DEFAULT NULL,
  `user_consolidation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contabil` tinyint(1) NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movements_movement_cards`
--

CREATE TABLE `movements_movement_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `movements_id` bigint UNSIGNED NOT NULL,
  `cards_id` bigint UNSIGNED NOT NULL,
  `bill_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movement_banks`
--

CREATE TABLE `movement_banks` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `banks_id` bigint UNSIGNED DEFAULT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `event_types_id` bigint UNSIGNED DEFAULT NULL,
  `document_types_id` bigint UNSIGNED DEFAULT NULL,
  `providers_id` bigint UNSIGNED DEFAULT NULL,
  `customers_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `transfers_id` bigint UNSIGNED DEFAULT NULL,
  `movements_id` bigint UNSIGNED DEFAULT NULL,
  `movement_checks_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipeexpense` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value_consolidation` decimal(10,2) DEFAULT NULL,
  `user_consolidation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contabil` tinyint(1) NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movement_boxes`
--

CREATE TABLE `movement_boxes` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `boxes_id` bigint UNSIGNED DEFAULT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `event_types_id` bigint UNSIGNED DEFAULT NULL,
  `document_types_id` bigint UNSIGNED DEFAULT NULL,
  `providers_id` bigint UNSIGNED DEFAULT NULL,
  `customers_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `transfers_id` bigint UNSIGNED DEFAULT NULL,
  `movements_id` bigint UNSIGNED DEFAULT NULL,
  `movement_checks_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipeexpense` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value_consolidation` decimal(10,2) DEFAULT NULL,
  `user_consolidation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contabil` tinyint(1) NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movement_cards`
--

CREATE TABLE `movement_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `banks_id` bigint UNSIGNED DEFAULT NULL,
  `boxes_id` bigint UNSIGNED DEFAULT NULL,
  `cards_id` bigint UNSIGNED DEFAULT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `event_types_id` bigint UNSIGNED DEFAULT NULL,
  `providers_id` bigint UNSIGNED DEFAULT NULL,
  `customers_id` bigint UNSIGNED DEFAULT NULL,
  `document_types_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `movements_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipeexpense` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value_consolidation` decimal(10,2) DEFAULT NULL,
  `user_consolidation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contabil` tinyint(1) NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movement_checks`
--

CREATE TABLE `movement_checks` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `banks_id` bigint UNSIGNED DEFAULT NULL,
  `boxes_id` bigint UNSIGNED DEFAULT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `event_types_id` bigint UNSIGNED DEFAULT NULL,
  `providers_id` bigint UNSIGNED DEFAULT NULL,
  `customers_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `transfers_id` bigint UNSIGNED DEFAULT NULL,
  `movements_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box_provider` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_consolidation` date DEFAULT NULL,
  `value_consolidation` decimal(10,2) DEFAULT NULL,
  `user_consolidation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contabil` tinyint(1) NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movement_mergeds`
--

CREATE TABLE `movement_mergeds` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `movements_id` bigint UNSIGNED NOT NULL,
  `movements_merged` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movement_recurrents`
--

CREATE TABLE `movement_recurrents` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `movements_id` bigint UNSIGNED NOT NULL,
  `movement_cards_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plans_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razao_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `im` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpfcnpj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` int DEFAULT NULL,
  `phone1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plannings`
--

CREATE TABLE `plannings` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `providers_id` bigint UNSIGNED DEFAULT NULL,
  `customers_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipeexpense` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `bill_date` date NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `parcels` int NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razao_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpfcnpj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `im` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regs`
--

CREATE TABLE `regs` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `log_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `function` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `banks_id` bigint UNSIGNED DEFAULT NULL,
  `boxes_id` bigint UNSIGNED DEFAULT NULL,
  `costs_id` bigint UNSIGNED DEFAULT NULL,
  `event_types_id` bigint UNSIGNED DEFAULT NULL,
  `document_types_id` bigint UNSIGNED DEFAULT NULL,
  `account_plans_id` bigint UNSIGNED DEFAULT NULL,
  `banks_dest` bigint UNSIGNED DEFAULT NULL,
  `boxes_dest` bigint UNSIGNED DEFAULT NULL,
  `costs_dest` bigint UNSIGNED DEFAULT NULL,
  `account_plans_dest` bigint UNSIGNED DEFAULT NULL,
  `order_number` int NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `radio_source` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `radio_destination` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_consolidation` date NOT NULL,
  `value_consolidation` decimal(10,2) NOT NULL,
  `contabil` tinyint(1) NOT NULL,
  `obs` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_parameter` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_parameters`
--

CREATE TABLE `users_parameters` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parameters_id` bigint UNSIGNED NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `roles_id` bigint UNSIGNED NOT NULL,
  `mailler` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_plans`
--
ALTER TABLE `account_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_plans_parameters_id_foreign` (`parameters_id`),
  ADD KEY `account_plans_plangroup_foreign` (`plangroup`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balances_parameters_id_foreign` (`parameters_id`),
  ADD KEY `balances_banks_id_foreign` (`banks_id`),
  ADD KEY `balances_boxes_id_foreign` (`boxes_id`),
  ADD KEY `balances_cards_id_foreign` (`cards_id`),
  ADD KEY `balances_plannings_id_foreign` (`plannings_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `boxes`
--
ALTER TABLE `boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boxes_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cards_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `costs_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_types_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_types_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledge`
--
ALTER TABLE `knowledge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movements_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movements_banks_id_foreign` (`banks_id`),
  ADD KEY `movements_boxes_id_foreign` (`boxes_id`),
  ADD KEY `movements_cards_id_foreign` (`cards_id`),
  ADD KEY `movements_plannings_id_foreign` (`plannings_id`),
  ADD KEY `movements_costs_id_foreign` (`costs_id`),
  ADD KEY `movements_event_types_id_foreign` (`event_types_id`),
  ADD KEY `movements_document_types_id_foreign` (`document_types_id`),
  ADD KEY `movements_providers_id_foreign` (`providers_id`),
  ADD KEY `movements_customers_id_foreign` (`customers_id`),
  ADD KEY `movements_account_plans_id_foreign` (`account_plans_id`);

--
-- Indexes for table `movements_movement_cards`
--
ALTER TABLE `movements_movement_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movements_movement_cards_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movements_movement_cards_movements_id_foreign` (`movements_id`),
  ADD KEY `movements_movement_cards_cards_id_foreign` (`cards_id`);

--
-- Indexes for table `movement_banks`
--
ALTER TABLE `movement_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_banks_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movement_banks_banks_id_foreign` (`banks_id`),
  ADD KEY `movement_banks_costs_id_foreign` (`costs_id`),
  ADD KEY `movement_banks_event_types_id_foreign` (`event_types_id`),
  ADD KEY `movement_banks_document_types_id_foreign` (`document_types_id`),
  ADD KEY `movement_banks_providers_id_foreign` (`providers_id`),
  ADD KEY `movement_banks_customers_id_foreign` (`customers_id`),
  ADD KEY `movement_banks_account_plans_id_foreign` (`account_plans_id`),
  ADD KEY `movement_banks_transfers_id_foreign` (`transfers_id`),
  ADD KEY `movement_banks_movements_id_foreign` (`movements_id`),
  ADD KEY `movement_banks_movement_checks_id_foreign` (`movement_checks_id`);

--
-- Indexes for table `movement_boxes`
--
ALTER TABLE `movement_boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_boxes_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movement_boxes_boxes_id_foreign` (`boxes_id`),
  ADD KEY `movement_boxes_costs_id_foreign` (`costs_id`),
  ADD KEY `movement_boxes_event_types_id_foreign` (`event_types_id`),
  ADD KEY `movement_boxes_document_types_id_foreign` (`document_types_id`),
  ADD KEY `movement_boxes_providers_id_foreign` (`providers_id`),
  ADD KEY `movement_boxes_customers_id_foreign` (`customers_id`),
  ADD KEY `movement_boxes_account_plans_id_foreign` (`account_plans_id`),
  ADD KEY `movement_boxes_transfers_id_foreign` (`transfers_id`),
  ADD KEY `movement_boxes_movements_id_foreign` (`movements_id`),
  ADD KEY `movement_boxes_movement_checks_id_foreign` (`movement_checks_id`);

--
-- Indexes for table `movement_cards`
--
ALTER TABLE `movement_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_cards_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movement_cards_banks_id_foreign` (`banks_id`),
  ADD KEY `movement_cards_boxes_id_foreign` (`boxes_id`),
  ADD KEY `movement_cards_cards_id_foreign` (`cards_id`),
  ADD KEY `movement_cards_costs_id_foreign` (`costs_id`),
  ADD KEY `movement_cards_event_types_id_foreign` (`event_types_id`),
  ADD KEY `movement_cards_providers_id_foreign` (`providers_id`),
  ADD KEY `movement_cards_customers_id_foreign` (`customers_id`),
  ADD KEY `movement_cards_document_types_id_foreign` (`document_types_id`),
  ADD KEY `movement_cards_account_plans_id_foreign` (`account_plans_id`),
  ADD KEY `movement_cards_movements_id_foreign` (`movements_id`);

--
-- Indexes for table `movement_checks`
--
ALTER TABLE `movement_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_checks_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movement_checks_banks_id_foreign` (`banks_id`),
  ADD KEY `movement_checks_boxes_id_foreign` (`boxes_id`),
  ADD KEY `movement_checks_costs_id_foreign` (`costs_id`),
  ADD KEY `movement_checks_event_types_id_foreign` (`event_types_id`),
  ADD KEY `movement_checks_providers_id_foreign` (`providers_id`),
  ADD KEY `movement_checks_customers_id_foreign` (`customers_id`),
  ADD KEY `movement_checks_account_plans_id_foreign` (`account_plans_id`),
  ADD KEY `movement_checks_transfers_id_foreign` (`transfers_id`),
  ADD KEY `movement_checks_movements_id_foreign` (`movements_id`);

--
-- Indexes for table `movement_mergeds`
--
ALTER TABLE `movement_mergeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_mergeds_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movement_mergeds_movements_id_foreign` (`movements_id`),
  ADD KEY `movement_mergeds_movements_merged_foreign` (`movements_merged`);

--
-- Indexes for table `movement_recurrents`
--
ALTER TABLE `movement_recurrents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_recurrents_parameters_id_foreign` (`parameters_id`),
  ADD KEY `movement_recurrents_movements_id_foreign` (`movements_id`),
  ADD KEY `movement_recurrents_movement_cards_id_foreign` (`movement_cards_id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_plans_id_foreign` (`plans_id`);

--
-- Indexes for table `plannings`
--
ALTER TABLE `plannings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plannings_parameters_id_foreign` (`parameters_id`),
  ADD KEY `plannings_costs_id_foreign` (`costs_id`),
  ADD KEY `plannings_providers_id_foreign` (`providers_id`),
  ADD KEY `plannings_customers_id_foreign` (`customers_id`),
  ADD KEY `plannings_account_plans_id_foreign` (`account_plans_id`);

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
  ADD KEY `providers_parameters_id_foreign` (`parameters_id`);

--
-- Indexes for table `regs`
--
ALTER TABLE `regs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regs_parameters_id_foreign` (`parameters_id`),
  ADD KEY `regs_users_id_foreign` (`users_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_parameters_id_foreign` (`parameters_id`),
  ADD KEY `transfers_banks_id_foreign` (`banks_id`),
  ADD KEY `transfers_boxes_id_foreign` (`boxes_id`),
  ADD KEY `transfers_costs_id_foreign` (`costs_id`),
  ADD KEY `transfers_event_types_id_foreign` (`event_types_id`),
  ADD KEY `transfers_document_types_id_foreign` (`document_types_id`),
  ADD KEY `transfers_account_plans_id_foreign` (`account_plans_id`),
  ADD KEY `transfers_banks_dest_foreign` (`banks_dest`),
  ADD KEY `transfers_boxes_dest_foreign` (`boxes_dest`),
  ADD KEY `transfers_costs_dest_foreign` (`costs_dest`),
  ADD KEY `transfers_account_plans_dest_foreign` (`account_plans_dest`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_parameters`
--
ALTER TABLE `users_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_parameters_parameters_id_foreign` (`parameters_id`),
  ADD KEY `users_parameters_users_id_foreign` (`users_id`),
  ADD KEY `users_parameters_roles_id_foreign` (`roles_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_plans`
--
ALTER TABLE `account_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boxes`
--
ALTER TABLE `boxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `costs`
--
ALTER TABLE `costs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge`
--
ALTER TABLE `knowledge`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `movements`
--
ALTER TABLE `movements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movements_movement_cards`
--
ALTER TABLE `movements_movement_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movement_banks`
--
ALTER TABLE `movement_banks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movement_boxes`
--
ALTER TABLE `movement_boxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movement_cards`
--
ALTER TABLE `movement_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movement_checks`
--
ALTER TABLE `movement_checks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movement_mergeds`
--
ALTER TABLE `movement_mergeds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movement_recurrents`
--
ALTER TABLE `movement_recurrents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plannings`
--
ALTER TABLE `plannings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regs`
--
ALTER TABLE `regs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_parameters`
--
ALTER TABLE `users_parameters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_plans`
--
ALTER TABLE `account_plans`
  ADD CONSTRAINT `account_plans_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_plans_plangroup_foreign` FOREIGN KEY (`plangroup`) REFERENCES `account_plans` (`id`);

--
-- Constraints for table `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balances_banks_id_foreign` FOREIGN KEY (`banks_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `balances_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `balances_cards_id_foreign` FOREIGN KEY (`cards_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `balances_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `balances_plannings_id_foreign` FOREIGN KEY (`plannings_id`) REFERENCES `plannings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
  ADD CONSTRAINT `banks_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `boxes`
--
ALTER TABLE `boxes`
  ADD CONSTRAINT `boxes_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `costs`
--
ALTER TABLE `costs`
  ADD CONSTRAINT `costs_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `document_types`
--
ALTER TABLE `document_types`
  ADD CONSTRAINT `document_types_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_types`
--
ALTER TABLE `event_types`
  ADD CONSTRAINT `event_types_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movements`
--
ALTER TABLE `movements`
  ADD CONSTRAINT `movements_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `movements_banks_id_foreign` FOREIGN KEY (`banks_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_cards_id_foreign` FOREIGN KEY (`cards_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `movements_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_document_types_id_foreign` FOREIGN KEY (`document_types_id`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `movements_event_types_id_foreign` FOREIGN KEY (`event_types_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `movements_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_plannings_id_foreign` FOREIGN KEY (`plannings_id`) REFERENCES `plannings` (`id`),
  ADD CONSTRAINT `movements_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movements_movement_cards`
--
ALTER TABLE `movements_movement_cards`
  ADD CONSTRAINT `movements_movement_cards_cards_id_foreign` FOREIGN KEY (`cards_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_movement_cards_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_movement_cards_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movement_banks`
--
ALTER TABLE `movement_banks`
  ADD CONSTRAINT `movement_banks_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `movement_banks_banks_id_foreign` FOREIGN KEY (`banks_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_banks_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `movement_banks_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_banks_document_types_id_foreign` FOREIGN KEY (`document_types_id`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `movement_banks_event_types_id_foreign` FOREIGN KEY (`event_types_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `movement_banks_movement_checks_id_foreign` FOREIGN KEY (`movement_checks_id`) REFERENCES `movement_checks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_banks_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_banks_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_banks_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_banks_transfers_id_foreign` FOREIGN KEY (`transfers_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movement_boxes`
--
ALTER TABLE `movement_boxes`
  ADD CONSTRAINT `movement_boxes_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `movement_boxes_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_boxes_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `movement_boxes_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_boxes_document_types_id_foreign` FOREIGN KEY (`document_types_id`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `movement_boxes_event_types_id_foreign` FOREIGN KEY (`event_types_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `movement_boxes_movement_checks_id_foreign` FOREIGN KEY (`movement_checks_id`) REFERENCES `movement_checks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_boxes_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_boxes_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_boxes_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_boxes_transfers_id_foreign` FOREIGN KEY (`transfers_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movement_cards`
--
ALTER TABLE `movement_cards`
  ADD CONSTRAINT `movement_cards_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `movement_cards_banks_id_foreign` FOREIGN KEY (`banks_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_cards_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_cards_cards_id_foreign` FOREIGN KEY (`cards_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_cards_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `movement_cards_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_cards_document_types_id_foreign` FOREIGN KEY (`document_types_id`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `movement_cards_event_types_id_foreign` FOREIGN KEY (`event_types_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `movement_cards_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_cards_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_cards_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movement_checks`
--
ALTER TABLE `movement_checks`
  ADD CONSTRAINT `movement_checks_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `movement_checks_banks_id_foreign` FOREIGN KEY (`banks_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_checks_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_checks_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `movement_checks_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_checks_event_types_id_foreign` FOREIGN KEY (`event_types_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `movement_checks_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_checks_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_checks_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_checks_transfers_id_foreign` FOREIGN KEY (`transfers_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movement_mergeds`
--
ALTER TABLE `movement_mergeds`
  ADD CONSTRAINT `movement_mergeds_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_mergeds_movements_merged_foreign` FOREIGN KEY (`movements_merged`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_mergeds_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movement_recurrents`
--
ALTER TABLE `movement_recurrents`
  ADD CONSTRAINT `movement_recurrents_movement_cards_id_foreign` FOREIGN KEY (`movement_cards_id`) REFERENCES `movement_cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_recurrents_movements_id_foreign` FOREIGN KEY (`movements_id`) REFERENCES `movements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movement_recurrents_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parameters`
--
ALTER TABLE `parameters`
  ADD CONSTRAINT `parameters_plans_id_foreign` FOREIGN KEY (`plans_id`) REFERENCES `plans` (`id`);

--
-- Constraints for table `plannings`
--
ALTER TABLE `plannings`
  ADD CONSTRAINT `plannings_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `plannings_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `plannings_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plannings_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plannings_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `regs`
--
ALTER TABLE `regs`
  ADD CONSTRAINT `regs_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `regs_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_account_plans_dest_foreign` FOREIGN KEY (`account_plans_dest`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `transfers_account_plans_id_foreign` FOREIGN KEY (`account_plans_id`) REFERENCES `account_plans` (`id`),
  ADD CONSTRAINT `transfers_banks_dest_foreign` FOREIGN KEY (`banks_dest`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_banks_id_foreign` FOREIGN KEY (`banks_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_boxes_dest_foreign` FOREIGN KEY (`boxes_dest`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_costs_dest_foreign` FOREIGN KEY (`costs_dest`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `transfers_costs_id_foreign` FOREIGN KEY (`costs_id`) REFERENCES `costs` (`id`),
  ADD CONSTRAINT `transfers_document_types_id_foreign` FOREIGN KEY (`document_types_id`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `transfers_event_types_id_foreign` FOREIGN KEY (`event_types_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `transfers_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_parameters`
--
ALTER TABLE `users_parameters`
  ADD CONSTRAINT `users_parameters_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_parameters_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_parameters_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
