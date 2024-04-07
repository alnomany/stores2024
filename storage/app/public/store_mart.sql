-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 20, 2024 at 11:08 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_mart`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `about_content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `android_link` varchar(255) DEFAULT NULL,
  `ios_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile_app_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner_image`
--

CREATE TABLE `banner_image` (
  `id` int(11) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1=category,2=products',
  `product_id` int(11) DEFAULT NULL,
  `section` int(11) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) NOT NULL COMMENT 'calculation with extra\r\n',
  `tax` varchar(255) DEFAULT NULL,
  `extras_id` varchar(255) DEFAULT NULL,
  `extras_name` varchar(255) DEFAULT NULL,
  `extras_price` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` varchar(255) NOT NULL COMMENT 'item original price with qty calculation',
  `variants_id` varchar(255) DEFAULT NULL,
  `variants_name` varchar(255) DEFAULT NULL,
  `variants_price` varchar(255) DEFAULT NULL COMMENT 'item original price',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Yes . 2 = No',
  `attribute` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_domain`
--

CREATE TABLE `custom_domain` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `requested_domain` text NOT NULL,
  `current_domain` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_status`
--

CREATE TABLE `custom_status` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=default,2=process,3=complete,4=cancel',
  `is_available` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 2,
  `order_type` int(11) NOT NULL DEFAULT 1 COMMENT '1=delivery,2=pickup,3=dinein,4=pos',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_status`
--

INSERT INTO `custom_status` (`id`, `reorder_id`, `vendor_id`, `name`, `type`, `is_available`, `is_deleted`, `order_type`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Pending', 1, 1, 2, 1, '2023-12-26 05:25:24', '2023-12-26 05:25:24'),
(2, 0, 1, 'Accepted', 2, 1, 2, 1, '2023-12-26 05:25:37', '2023-12-26 05:25:37'),
(3, 0, 1, 'Out For Delivery', 2, 1, 2, 1, '2023-12-26 05:25:52', '2023-12-26 05:25:52'),
(4, 0, 1, 'Complete', 3, 1, 2, 1, '2023-12-26 05:26:05', '2023-12-26 05:26:05'),
(5, 0, 1, 'Cancel', 4, 1, 2, 1, '2023-12-26 05:26:15', '2023-12-26 05:26:15'),
(6, 0, 1, 'Pending', 1, 1, 2, 2, '2023-12-26 05:26:29', '2023-12-26 05:26:29'),
(7, 0, 1, 'Accepted', 2, 1, 2, 2, '2023-12-26 05:26:41', '2023-12-26 05:26:41'),
(8, 0, 1, 'Waiting For Pickup', 2, 1, 2, 2, '2023-12-26 05:27:06', '2023-12-26 05:27:06'),
(9, 0, 1, 'Complete', 3, 1, 2, 2, '2023-12-26 05:27:17', '2023-12-26 05:27:17'),
(10, 0, 1, 'Cancel', 4, 1, 2, 2, '2023-12-26 05:27:33', '2023-12-26 05:27:33'),
(11, 0, 1, 'Pending', 1, 1, 2, 3, '2023-12-26 05:27:47', '2023-12-26 05:27:47'),
(12, 0, 1, 'Accepted', 2, 1, 2, 3, '2023-12-26 05:28:00', '2023-12-26 05:28:00'),
(13, 0, 1, 'In Progress', 2, 1, 2, 3, '2023-12-26 05:28:15', '2023-12-26 05:28:15'),
(14, 0, 1, 'Complete', 3, 1, 2, 3, '2023-12-26 05:28:34', '2023-12-26 05:28:34'),
(15, 0, 1, 'Cancel', 4, 1, 2, 3, '2023-12-26 05:28:48', '2023-12-26 05:28:48'),
(16, 0, 1, 'Pending', 1, 1, 2, 4, '2023-12-26 05:28:59', '2023-12-26 05:28:59'),
(17, 0, 1, 'Complete', 3, 1, 2, 4, '2023-12-26 05:29:17', '2023-12-26 05:29:17'),
(18, 0, 1, 'Cancel', 4, 1, 2, 4, '2023-12-26 05:29:30', '2023-12-26 05:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `deliveryareas`
--

CREATE TABLE `deliveryareas` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footerfeatures`
--

CREATE TABLE `footerfeatures` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fun_fact`
--

CREATE TABLE `fun_fact` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `global_extras`
--

CREATE TABLE `global_extras` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `howitworks`
--

CREATE TABLE `howitworks` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `item_name` text NOT NULL,
  `description` text DEFAULT NULL,
  `item_price` float NOT NULL,
  `item_original_price` float DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `low_qty` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `tax` varchar(255) DEFAULT '0',
  `slug` text DEFAULT NULL,
  `min_order` int(11) DEFAULT NULL,
  `max_order` int(11) DEFAULT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1,
  `has_variants` int(11) NOT NULL DEFAULT 2,
  `variants_json` longtext DEFAULT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `attchment_name` varchar(255) DEFAULT NULL,
  `attchment_file` varchar(255) DEFAULT NULL,
  `download_file` varchar(255) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `stock_management` int(11) NOT NULL COMMENT '1=yes,2=no',
  `is_imported` int(11) DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landing_settings`
--

CREATE TABLE `landing_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `landing_home_banner` varchar(255) DEFAULT NULL,
  `testimonial_image` varchar(255) DEFAULT NULL,
  `subscribe_image` varchar(255) DEFAULT NULL,
  `faq_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `layout` int(11) NOT NULL DEFAULT 1 COMMENT '1=ltr,2=rtl',
  `is_default` int(11) NOT NULL DEFAULT 2 COMMENT '1 = yes , 2 = no',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `image`, `layout`, `is_default`, `is_available`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'flag-6512d2e343e92.png', 1, 1, 1, 2, '2022-12-13 05:15:46', '2023-12-02 00:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2021_12_20_101946_create_settings_table', 2),
(3, '2021_12_20_121616_create_categories_table', 3),
(4, '2021_12_22_072131_create_cuisines_table', 4),
(5, '2021_12_23_065134_create_menuses_table', 5),
(6, '2014_10_12_100000_create_password_resets_table', 6),
(7, '2019_08_19_000000_create_failed_jobs_table', 6),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 6),
(9, '2022_11_14_051836_create_banner_image_table', 6),
(10, '2022_11_14_053221_create_banner_image_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_number` varchar(100) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `payment_id` text DEFAULT NULL,
  `sub_total` varchar(255) NOT NULL,
  `tax` varchar(255) DEFAULT NULL COMMENT 'tax_amount',
  `tax_name` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) NOT NULL,
  `order_type` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Delivery , 2 = Pickup,3="dine in",4="pos"',
  `address` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `building` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `delivery_area` varchar(255) DEFAULT NULL,
  `delivery_charge` varchar(50) DEFAULT NULL,
  `discount_amount` varchar(255) DEFAULT NULL,
  `couponcode` varchar(255) DEFAULT NULL,
  `order_notes` text DEFAULT NULL,
  `customer_name` text DEFAULT NULL,
  `customer_email` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `delivery_time` varchar(255) DEFAULT NULL,
  `order_from` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `status_type` int(11) NOT NULL,
  `is_notification` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Unread , 2 = Read',
  `screenshot` varchar(255) NOT NULL,
  `payment_status` int(11) NOT NULL COMMENT '1=unpaid,2=paid',
  `dinein_table` int(11) DEFAULT NULL,
  `dinein_tablename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `extras_id` varchar(255) DEFAULT NULL,
  `extras_name` varchar(255) DEFAULT NULL,
  `extras_price` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `variants_id` varchar(255) DEFAULT NULL,
  `variants_name` varchar(255) DEFAULT NULL,
  `variants_price` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `payment_name` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `currency` varchar(255) DEFAULT '',
  `image` varchar(255) NOT NULL,
  `public_key` text DEFAULT NULL,
  `secret_key` text DEFAULT NULL,
  `encryption_key` text DEFAULT NULL,
  `environment` int(11) NOT NULL,
  `payment_description` longtext DEFAULT NULL,
  `is_available` int(11) NOT NULL,
  `is_activate` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reorder_id`, `vendor_id`, `payment_name`, `payment_type`, `currency`, `image`, `public_key`, `secret_key`, `encryption_key`, `environment`, `payment_description`, `is_available`, `is_activate`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'COD', 1, '', 'cod.png', NULL, NULL, '', 1, NULL, 1, 1, '2021-09-02 14:06:58', '2023-11-10 15:22:17'),
(2, 2, 1, 'RazorPay', 2, 'INR', 'razorpay.png', 'rzp_test_4r8y0wDMkrUDFn', 'nEDuJlpL3x2BqHxYlQBYtrto', '', 1, NULL, 1, 1, '2021-09-02 14:06:58', '2023-11-28 11:13:04'),
(3, 3, 1, 'Stripe', 3, 'USD', 'stripe.png', 'pk_test_51IjNgIJwZppK21ZQa6e7ZVOImwJ2auI54TD6xHici94u7DD5mhGf1oaBiDyL9mX7PbN5nt6Weap4tmGWLRIrslCu00d8QgQ3nI', 'sk_test_51IjNgIJwZppK21ZQK85uLARMdhtuuhA81PB24VDfiqSW8SXQZKrZzvbpIkigEb27zZPBMF4UEG7PK9587Xresuc000x8CdE22A', 'sk_test_51IjNgIJwZppK21ZQK85uLARMdhtuuhA81PB24VDfiqSW8SXQZKrZzvbpIkigEb27zZPBMF4UEG7PK9587Xresuc000x8CdE22A', 1, NULL, 1, 1, '2021-09-02 14:06:58', '2023-11-28 11:15:07'),
(4, 5, 1, 'Flutterwave', 4, 'NGN', 'flutterwave.png', 'FLWPUBK_TEST-4de3dcae2196d3aaf5594d600f32fab6-X', 'FLWSECK_TEST-1140781769b7bd5cfd6b3fb6d5704017-X', 'FLWSECK_TEST863a39eb1475', 1, NULL, 1, 1, '2021-10-21 07:28:05', '2023-11-28 11:20:57'),
(5, 4, 1, 'Paystack', 5, 'GHS', 'paystack.png', 'pk_test_8a6a139a3bae6e41cbbbc41f4d7b65d4da9f7967', 'sk_test_6ab143b6f0c2a209373adeef55a64411c1a91ae9', '', 1, NULL, 1, 1, '2021-10-21 07:28:12', '2023-11-28 11:16:41'),
(6, 1, 1, 'Bank Transfer', 6, '', 'banktransfer.png', NULL, NULL, '', 0, '<p>Bank Information</p>\r\n\r\n<p>Bank Name : StoreMart&nbsp;Bank<br />\r\nAccount Holder Name : StoreMart<br />\r\nAccount Number :&nbsp;4242424242424242<br />\r\nIFSC code : BANK325125</p>\r\n\r\n<p>UPI Information<br />\r\n<br />\r\nGoogle Pay : +985641245223<br />\r\nPhonePe :&nbsp;+985641245223</p>', 1, 1, '2021-10-21 07:28:12', '2024-01-16 18:21:02'),
(7, 7, 1, 'Mercado Pago', 7, 'R$', 'mercadopago.png', 'APP_USR-3693146734015792-042811-c6deca56df8ac66e83efb5334c46110c-126508225', 'APP_USR-3693146734015792-042811-c6deca56df8ac66e83efb5334c46110c-126508225', '', 1, NULL, 1, 2, '2021-10-21 07:28:12', '2023-11-28 11:41:33'),
(8, 6, 1, 'PayPal', 8, 'USD', 'paypal.png', 'AcRx7vvy79nbNxBemacGKmnnRe_CtxkItyspBS_eeMIPREwfCEIfPg1uX-bdqPrS_ZFGocxEH_SJRrIJ', 'EGtgNkjt3I5lkhEEzicdot8gVH_PcFiKxx6ZBiXpVrp4QLDYcVQQMLX6MMG_fkS9_H0bwmZzBovb4jLP', '', 1, NULL, 1, 2, '2021-10-21 07:28:12', '2023-11-28 11:34:36'),
(9, 8, 1, 'MyFatoorah', 9, 'KWT', 'myfatoorah.png', 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL', 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL', '', 1, NULL, 1, 2, '2021-10-21 07:28:12', '2023-11-28 11:45:29'),
(10, 9, 1, 'toyyibPay', 10, 'RM', 'toyyibpay.png', 'ts75iszg', 'luieh2jt-8hpa-m2xv-wrkv-ejrfvhjppnsj', '', 1, NULL, 1, 2, '2021-10-21 07:28:12', '2023-12-21 14:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pixcel_settings`
--

CREATE TABLE `pixcel_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `twitter_pixcel_id` varchar(255) DEFAULT NULL,
  `facebook_pixcel_id` varchar(255) DEFAULT NULL,
  `linkedin_pixcel_id` varchar(255) DEFAULT NULL,
  `google_tag_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `features` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` float NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `themes_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_type` int(11) NOT NULL COMMENT '1 = duration, 2 = days',
  `duration` varchar(255) NOT NULL COMMENT '1=1 month\r\n2=3 month\r\n3=6 month\r\n4=1\r\n year\r\n\r\n\r\n',
  `days` int(11) NOT NULL,
  `order_limit` int(11) NOT NULL,
  `appointment_limit` int(11) NOT NULL,
  `custom_domain` int(11) NOT NULL COMMENT '1=yes,2=no',
  `google_analytics` int(11) NOT NULL COMMENT '1=yes,2=no',
  `pos` int(11) NOT NULL COMMENT '1 = Yes , 2 = No',
  `vendor_app` int(11) NOT NULL,
  `customer_app` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `role_management` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `pwa` int(11) DEFAULT NULL,
  `is_available` int(11) DEFAULT 1 COMMENT '1=Yes\r\n2=No\r\n',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `coupons` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `themes` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `blogs` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `social_logins` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `sound_notification` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `whatsapp_message` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `telegram_message` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `pixel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privacypolicy`
--

CREATE TABLE `privacypolicy` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `privacypolicy_content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `privacypolicy`
--

INSERT INTO `privacypolicy` (`id`, `vendor_id`, `privacypolicy_content`, `created_at`, `updated_at`) VALUES
(1, 1, '<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>​​​​​​​</p>', '2024-01-09 08:46:40', '2024-01-10 01:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_imported` int(11) DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `offer_code` varchar(255) NOT NULL,
  `offer_type` int(11) NOT NULL COMMENT '1=fixed,2=percentage',
  `offer_amount` varchar(255) NOT NULL,
  `min_amount` int(11) NOT NULL,
  `usage_type` int(11) DEFAULT NULL COMMENT '1=Limited time\r\n,2=multiple times',
  `usage_limit` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `description` longtext NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotionalbanner`
--

CREATE TABLE `promotionalbanner` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `add` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  `manage` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_manager`
--

CREATE TABLE `role_manager` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` longtext NOT NULL,
  `is_available` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL COMMENT '1=yes,2=no',
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_position` varchar(255) NOT NULL,
  `currency_formate` int(11) NOT NULL,
  `maintenance_mode` int(11) DEFAULT 2 COMMENT '1 = yes, 2 = no',
  `checkout_login_required` int(11) DEFAULT 2 COMMENT '1 = Yes , 2 = No',
  `logo` varchar(255) NOT NULL DEFAULT 'default-logo.png',
  `favicon` varchar(255) NOT NULL DEFAULT 'favicon-.png',
  `delivery_type` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `copyright` varchar(255) NOT NULL,
  `website_title` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `og_image` varchar(255) NOT NULL DEFAULT 'og_image.png',
  `whatsapp_widget` longtext DEFAULT NULL,
  `whatsapp_message` longtext NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `telegram_message` longtext DEFAULT NULL,
  `telegram_access_token` text DEFAULT NULL,
  `telegram_chat_id` text DEFAULT NULL,
  `item_message` text NOT NULL,
  `language` int(11) NOT NULL DEFAULT 1,
  `template` int(11) NOT NULL DEFAULT 1,
  `primary_color` varchar(255) NOT NULL DEFAULT '#171a29',
  `secondary_color` varchar(255) NOT NULL DEFAULT '#171a29',
  `cname_title` text DEFAULT NULL,
  `cname_text` text DEFAULT NULL,
  `interval_time` varchar(255) NOT NULL,
  `interval_type` int(11) NOT NULL,
  `time_format` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `banner` varchar(255) NOT NULL DEFAULT 'default-banner.png',
  `tracking_id` varchar(255) DEFAULT NULL,
  `view_id` varchar(255) DEFAULT NULL,
  `firebase` longtext DEFAULT NULL,
  `cover_image` varchar(255) NOT NULL DEFAULT 'default-cover.png',
  `notification_sound` varchar(255) NOT NULL DEFAULT 'notification.mp3',
  `recaptcha_version` varchar(255) DEFAULT NULL,
  `google_recaptcha_site_key` varchar(255) DEFAULT NULL,
  `google_recaptcha_secret_key` varchar(255) DEFAULT NULL,
  `score_threshold` varchar(255) DEFAULT NULL,
  `cookie_text` text DEFAULT NULL,
  `cookie_button_text` text DEFAULT NULL,
  `app_title` varchar(255) DEFAULT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `theme_color` varchar(255) DEFAULT NULL,
  `pwa` int(11) DEFAULT NULL,
  `app_logo` varchar(255) DEFAULT NULL,
  `mail_driver` varchar(255) DEFAULT NULL,
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_fromaddress` varchar(255) DEFAULT NULL,
  `mail_fromname` varchar(255) DEFAULT NULL,
  `landing_page` int(11) NOT NULL,
  `google_client_id` varchar(255) NOT NULL,
  `google_client_secret` varchar(255) NOT NULL,
  `google_redirect_url` varchar(255) NOT NULL DEFAULT 'http://your-domain-url.com/checklogin/google/callback-google',
  `facebook_client_id` varchar(255) NOT NULL,
  `facebook_client_secret` varchar(255) NOT NULL,
  `facebook_redirect_url` varchar(255) NOT NULL DEFAULT 'http://your-domain-url.com/checklogin/facebook/callback-facebook',
  `web_host` varchar(255) DEFAULT NULL,
  `refund_policy` longtext NOT NULL,
  `facebook_mode` int(11) DEFAULT NULL,
  `google_mode` int(11) DEFAULT NULL,
  `subscribe_image` varchar(255) DEFAULT NULL,
  `order_detail_image` varchar(255) DEFAULT NULL,
  `languages` varchar(255) NOT NULL DEFAULT 'en',
  `default_language` varchar(255) NOT NULL DEFAULT 'en',
  `product_ratting_switch` int(11) NOT NULL,
  `decimal_separator` int(11) DEFAULT 1 COMMENT '1=dot,2=comma',
  `ordertype_date_time` int(11) DEFAULT 2 COMMENT '1=yes,2=no',
  `per_slot_limit` int(11) DEFAULT 1,
  `online_order` int(11) NOT NULL DEFAULT 1 COMMENT '1 = yes , 2 = no',
  `custom_domain` text DEFAULT NULL,
  `google_review` text DEFAULT NULL,
  `product_type` int(11) DEFAULT 1 COMMENT '1=physical,2=digital',
  `min_order_amount` varchar(255) DEFAULT '0',
  `shopify_store_url` text DEFAULT NULL,
  `shopify_access_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vendor_register` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `vendor_id`, `currency`, `currency_position`, `currency_formate`, `maintenance_mode`, `checkout_login_required`, `logo`, `favicon`, `delivery_type`, `timezone`, `address`, `email`, `mobile`, `description`, `contact`, `copyright`, `website_title`, `meta_title`, `meta_description`, `og_image`, `whatsapp_widget`, `whatsapp_message`, `whatsapp_number`, `telegram_message`, `telegram_access_token`, `telegram_chat_id`, `item_message`, `language`, `template`, `primary_color`, `secondary_color`, `cname_title`, `cname_text`, `interval_time`, `interval_type`, `time_format`, `banner`, `tracking_id`, `view_id`, `firebase`, `cover_image`, `notification_sound`, `recaptcha_version`, `google_recaptcha_site_key`, `google_recaptcha_secret_key`, `score_threshold`, `cookie_text`, `cookie_button_text`, `app_title`, `app_name`, `background_color`, `theme_color`, `pwa`, `app_logo`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_fromaddress`, `mail_fromname`, `landing_page`, `google_client_id`, `google_client_secret`, `google_redirect_url`, `facebook_client_id`, `facebook_client_secret`, `facebook_redirect_url`, `web_host`, `refund_policy`, `facebook_mode`, `google_mode`, `subscribe_image`, `order_detail_image`, `languages`, `default_language`, `product_ratting_switch`, `decimal_separator`, `ordertype_date_time`, `per_slot_limit`, `online_order`, `custom_domain`, `google_review`, `product_type`, `min_order_amount`, `shopify_store_url`, `shopify_access_token`, `created_at`, `updated_at`, `vendor_register`) VALUES
(1, 1, '$', 'left', 2, 2, 1, 'logo-659e361bd3634.png', 'favicon-659e361bd3d55.png', '', 'Asia/Kolkata', '456 Park Avenue, New York, NY 10022', 'paponapp2244@gmail.com', '', NULL, '+919016996697', 'Copyright © 2024 Papon IT Solutions. All Rights Reserved', 'StoreMart | Online SaaS', 'StoreMart SaaS - Online Product Selling Business Builder SaaS', 'StoreMart is a software as a service (SaaS) platform that allows users to build and manage an online store for selling products. It provides users with a range of features and tools to help them create and customize their store, add and manage products, process orders, and handle payments. StoreMart also includes marketing and analytics tools to help users promote their store and track their performance. It is designed to be user-friendly and easy to use, making it a good option for people who want to start an online store without a lot of technical expertise.', 'og_image-659e37061f33b.png', NULL, '', '9016996697', NULL, NULL, NULL, '', 1, 1, '#74ad00', '#121212', 'Read All Instructions Carefully Before Sending Custom Domain Request', '<p>If you&#39;re using cPanel or Plesk then you need to manually add custom domain in your server with the same root directory as the script&#39;s installation&nbsp;and user need to point their custom domain A record with your server IP. Example : 68.178.145.4</p>', '', 0, 2, '', 'UA-168896572-2', '284502084', 'AAAAlio1OzI:APA91bG85HXcf1TKLW_T8CqOh2HwYPTb58yxLyv93v9e1tRvEojTNFi9Um-sFQHzTZ_O6w6gjy1KNwhKF72hW0wvaHElwJGTrsVKELGAGc_Ff0r1arQBMZwwX9gNXz-mKMMZVigUUl86', '', '', 'v3', '6Ld32eclAAAAAF5Fn3AfhsZt7lnJIhD14aCHt51g', '6Ld32eclAAAAAGpWG9ZX0pElrnN9bxH9RPpfEQqg', '0.5', 'Your experience on this site will be improved by allowing cookies.', 'I Agree', NULL, NULL, NULL, NULL, NULL, NULL, 'sendmail', 'smtp.gmail.com', '587', 'paponapp2244@gmail.com', 'vpwhohsncejvdyfp', 'tls', 'hello@example.com', 'papon', 1, '670042885445-cmq6tngijf26gjbmjcq73m5r5s94q0up.apps.googleusercontent.com', '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', 'http://your-domain-url.com/checklogin/google/callback-google', '5824705190970928', '62e852fbb48ce4c9c5e7d605f8a436fa', 'http://your-domain-url.com/checklogin/facebook/callback-facebook', 'web_host', '<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>​​​​​​​</p>', 1, 1, NULL, NULL, 'ar,en,de', 'en', 0, 1, 2, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, '2023-07-26 21:04:57', '2024-01-12 01:38:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` text NOT NULL,
  `link` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_category`
--

CREATE TABLE `store_category` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systemaddons`
--

CREATE TABLE `systemaddons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `version` varchar(20) NOT NULL,
  `activated` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systemaddons`
--

INSERT INTO `systemaddons` (`id`, `name`, `unique_identifier`, `version`, `activated`, `image`, `type`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Blogs', 'blog', '3.5', 1, 'blog.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(2, 'Coupons', 'coupon', '3.5', 1, 'coupons.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(3, 'Customer Login', 'customer_login', '3.5', 1, 'customer_login.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(4, 'Language Translation', 'language', '3.5', 1, 'language.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(5, 'Sound Notification', 'notification', '3.5', 1, 'notification.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(6, 'Personalised Slug', 'unique_slug', '3.5', 1, 'unique_slug.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(7, 'Whatsapp Message', 'whatsapp_message', '3.5', 1, 'whatsapp_message.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(8, 'Allow Without Subscription', 'allow_without_subscription', '3.5', 1, 'allow_without_subscription.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41'),
(9, 'Subscription', 'subscription', '3.5', 1, 'subscription.jpg', 1, 100, '2024-01-20 22:47:41', '2024-01-20 22:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `tax` varchar(255) NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `terms_content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `vendor_id`, `terms_content`, `created_at`, `updated_at`) VALUES
(1, 1, '<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>​​​​​​​</p>', '2024-01-10 01:04:12', '2024-01-10 01:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `star` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timings`
--

CREATE TABLE `timings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `open_time` varchar(30) NOT NULL,
  `break_start` varchar(255) NOT NULL,
  `break_end` varchar(255) NOT NULL,
  `close_time` varchar(30) NOT NULL,
  `is_always_close` tinyint(1) NOT NULL COMMENT '1 For Yes, 2 For No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `transaction_number` varchar(255) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL COMMENT 'payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10',
  `payment_id` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `grand_total` float NOT NULL,
  `tax` varchar(255) DEFAULT '0',
  `offer_amount` float DEFAULT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `duration` varchar(255) NOT NULL COMMENT '1=1 Month,\r\n2=3Month\r\n3=6 Month\r\n4=1 Year',
  `days` int(11) DEFAULT NULL,
  `purchase_date` varchar(255) NOT NULL,
  `service_limit` varchar(255) NOT NULL,
  `appoinment_limit` varchar(255) NOT NULL,
  `custom_domain` int(11) NOT NULL COMMENT '1 = yes, 2 = no',
  `google_analytics` int(11) NOT NULL COMMENT '1 = yes, 2 = no',
  `pos` int(11) NOT NULL COMMENT '1 = yes, 2 = no',
  `vendor_app` int(11) NOT NULL COMMENT '1 = Yes , 2 = No',
  `customer_app` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `role_management` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `pwa` int(11) DEFAULT NULL,
  `coupons` int(11) DEFAULT NULL,
  `themes` int(11) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `themes_id` varchar(255) DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 = pending, 2 = yes/BankTransferAccepted,3=no/BankTransferDeclined',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blogs` int(11) DEFAULT NULL,
  `social_login` int(11) DEFAULT NULL,
  `sound_notification` int(11) DEFAULT NULL,
  `whatsapp_message` int(11) DEFAULT NULL,
  `telegram_message` int(11) DEFAULT NULL,
  `pixel` int(11) DEFAULT NULL,
  `features` varchar(255) DEFAULT NULL,
  `tax_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `login_type` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Admin,2=vendor,3=driver,4=User/Customer',
  `description` text DEFAULT NULL,
  `token` longtext DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `plan_id` varchar(255) DEFAULT NULL,
  `purchase_amount` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(255) DEFAULT NULL,
  `available_on_landing` int(11) NOT NULL DEFAULT 2 COMMENT '1 = Yes , 2 = No',
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `free_plan` int(11) NOT NULL DEFAULT 0,
  `is_delivery` tinyint(1) DEFAULT NULL COMMENT '1=Yes,2=No',
  `allow_without_subscription` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_verified` tinyint(1) NOT NULL COMMENT '1=Yes,2=No',
  `is_available` tinyint(1) NOT NULL COMMENT '1=Yes,2=No',
  `remember_token` varchar(100) DEFAULT NULL,
  `license_type` text DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `custom_domain` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `store_id`, `name`, `slug`, `email`, `mobile`, `image`, `password`, `google_id`, `facebook_id`, `login_type`, `type`, `description`, `token`, `country_id`, `city_id`, `plan_id`, `purchase_amount`, `purchase_date`, `available_on_landing`, `payment_id`, `payment_type`, `free_plan`, `is_delivery`, `allow_without_subscription`, `is_verified`, `is_available`, `remember_token`, `license_type`, `role_id`, `vendor_id`, `custom_domain`, `created_at`, `updated_at`) VALUES
(1, NULL, 'StoreMart', 'admin', 'admin@gmail.com', '+919016996697', 'profile-65a0e5867f72d.png', '$2y$10$BGzS523wDK3hKQO1iZb6Z.Y6AgATl.LXccaa.WhGzxNVnEJHoy5SC', NULL, NULL, 'normal', 1, NULL, 'cNjSsm-TREC9n58ZQeIDBL:APA91bHSLQ2S9VFhM2yGoQJG7d-noXkcsVXRQi8Y-XSUJIFZQgzF75Kbu5beKH8dGUZ9SqIND3yauVdcG6-SwcVjU4oIjpJUx5JC9cORZp-NvPtNkJT1IMLb0KgnN68UWAtzwvri8KqT', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 0, NULL, 2, 2, 2, NULL, 'Extended License', 0, 0, NULL, '2022-08-15 23:01:17', '2024-01-12 01:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `original_price` float DEFAULT 0,
  `qty` int(11) DEFAULT 0,
  `min_order` int(11) DEFAULT NULL,
  `max_order` int(11) DEFAULT NULL,
  `low_qty` int(11) DEFAULT NULL,
  `stock_management` int(11) NOT NULL COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_image`
--
ALTER TABLE `banner_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_item_id_foreign` (`item_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_domain`
--
ALTER TABLE `custom_domain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_status`
--
ALTER TABLE `custom_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveryareas`
--
ALTER TABLE `deliveryareas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footerfeatures`
--
ALTER TABLE `footerfeatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fun_fact`
--
ALTER TABLE `fun_fact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_extras`
--
ALTER TABLE `global_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `howitworks`
--
ALTER TABLE `howitworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_settings`
--
ALTER TABLE `landing_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pixcel_settings`
--
ALTER TABLE `pixcel_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacypolicy`
--
ALTER TABLE `privacypolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotionalbanner`
--
ALTER TABLE `promotionalbanner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_manager`
--
ALTER TABLE `role_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_category`
--
ALTER TABLE `store_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systemaddons`
--
ALTER TABLE `systemaddons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timings`
--
ALTER TABLE `timings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner_image`
--
ALTER TABLE `banner_image`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_domain`
--
ALTER TABLE `custom_domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_status`
--
ALTER TABLE `custom_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `deliveryareas`
--
ALTER TABLE `deliveryareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footerfeatures`
--
ALTER TABLE `footerfeatures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fun_fact`
--
ALTER TABLE `fun_fact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `global_extras`
--
ALTER TABLE `global_extras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `howitworks`
--
ALTER TABLE `howitworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_settings`
--
ALTER TABLE `landing_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pixcel_settings`
--
ALTER TABLE `pixcel_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privacypolicy`
--
ALTER TABLE `privacypolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotionalbanner`
--
ALTER TABLE `promotionalbanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_manager`
--
ALTER TABLE `role_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_category`
--
ALTER TABLE `store_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `systemaddons`
--
ALTER TABLE `systemaddons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timings`
--
ALTER TABLE `timings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
