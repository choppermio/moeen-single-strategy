-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2024 at 07:23 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strategy`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_positions`
--

CREATE TABLE `employee_positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_positions`
--

INSERT INTO `employee_positions` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 'مدير تنفيذي', 1, '2024-01-14 12:26:20', '2024-01-14 12:26:20'),
(11, 'مدير مكتب المدير التنفيذي', 11, '2024-02-07 11:52:18', '2024-02-07 11:52:18'),
(12, 'مدير البرامج الشبابية والمعرفة', 12, '2024-02-07 11:52:53', '2024-02-07 11:52:53'),
(13, 'مدير برامج فرع قمم', 13, '2024-02-07 11:53:16', '2024-02-07 11:53:16'),
(14, 'مديرة برامج بنات جدة', 14, '2024-02-07 11:53:29', '2024-02-07 11:53:29'),
(15, 'مديرة برامج لبنات', 15, '2024-02-07 11:53:40', '2024-02-07 11:53:40'),
(16, 'مدير إدارة الاتصال المؤسسي وتنمية الموارد المالية', 16, '2024-02-07 11:54:06', '2024-02-07 11:54:06'),
(17, 'مدير قسم تنمية الموارد المالية', 17, '2024-02-07 11:54:22', '2024-02-07 11:54:22'),
(18, 'مدير قسم العلاقات العامة و الإعلام', 18, '2024-02-07 11:55:07', '2024-02-07 11:55:07'),
(19, 'أخصائي علاقات وإعلام', 19, '2024-02-07 11:55:21', '2024-02-07 11:55:21'),
(20, 'مدير الموارد البشرية والدعم المؤسسي', 20, '2024-02-07 11:55:36', '2024-02-07 11:55:36'),
(21, 'أخصائي موارد بشرية', 21, '2024-02-07 11:55:49', '2024-02-07 11:55:49'),
(22, 'أخصائي خدمات مساندة', 22, '2024-02-07 11:56:03', '2024-02-07 11:56:03'),
(23, 'مدير وحدة التقنية', 23, '2024-02-07 11:56:13', '2024-02-07 11:56:13'),
(24, 'مدير الحوكمة', 24, '2024-02-07 15:38:58', '2024-02-07 15:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `employee_position_relations`
--

CREATE TABLE `employee_position_relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_position_relations`
--

INSERT INTO `employee_position_relations` (`id`, `parent_id`, `child_id`, `created_at`, `updated_at`) VALUES
(16, 16, 17, '2024-02-07 12:00:31', '2024-02-07 12:00:31'),
(17, 16, 18, '2024-02-07 12:00:31', '2024-02-07 12:00:31'),
(18, 12, 13, '2024-02-07 15:32:57', '2024-02-07 15:32:57'),
(19, 12, 14, '2024-02-07 15:32:57', '2024-02-07 15:32:57'),
(20, 12, 15, '2024-02-07 15:32:57', '2024-02-07 15:32:57'),
(21, 20, 21, '2024-02-07 15:33:13', '2024-02-07 15:33:13'),
(22, 20, 22, '2024-02-07 15:33:13', '2024-02-07 15:33:13'),
(23, 20, 23, '2024-02-07 15:33:13', '2024-02-07 15:33:13'),
(24, 18, 19, '2024-02-07 15:34:32', '2024-02-07 15:34:32'),
(29, 4, 11, '2024-02-07 15:39:05', '2024-02-07 15:39:05'),
(30, 4, 12, '2024-02-07 15:39:05', '2024-02-07 15:39:05'),
(31, 4, 16, '2024-02-07 15:39:05', '2024-02-07 15:39:05'),
(32, 4, 20, '2024-02-07 15:39:05', '2024-02-07 15:39:05'),
(33, 4, 24, '2024-02-07 15:39:05', '2024-02-07 15:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hadafstrategies`
--

CREATE TABLE `hadafstrategies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hadafstrategies`
--

INSERT INTO `hadafstrategies` (`id`, `name`, `percentage`, `created_at`, `updated_at`, `user_id`) VALUES
(64, 'هدف استراتيجي', 0, '2024-02-07 14:39:17', '2024-02-07 14:39:17', 11),
(65, 'هدف استراتيجي 2', 50, '2024-02-08 14:05:59', '2024-02-08 14:31:07', 11);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(10, 'App\\Models\\Subtask', 43, 'e1d0f2ea-6dfc-4b4c-9881-80bbc6174d93', 'images', 'تصميم صفحة قيمة المبادرة', 'تصميم-صفحة-قيمة-المبادرة.png', 'image/png', 'public_uploads', 'public_uploads', 315051, '[]', '[]', '[]', '[]', 1, '2024-01-14 13:11:18', '2024-01-14 13:11:18'),
(11, 'App\\Models\\Subtask', 46, 'f17f23ce-2937-4ec5-948c-bd749d79aa97', 'images', 'شهادة تسجيل الجمعية الجديد', 'شهادة-تسجيل-الجمعية-الجديد.pdf', 'application/pdf', 'public_uploads', 'public_uploads', 228518, '[]', '[]', '[]', '[]', 2, '2024-01-19 11:19:44', '2024-01-19 11:19:44'),
(12, 'App\\Models\\Subtask', 47, 'f856ea05-4536-4c22-b671-6eca05d99d0a', 'images', 'شهادة تسجيل الجمعية الجديد', 'شهادة-تسجيل-الجمعية-الجديد.pdf', 'application/pdf', 'public_uploads', 'public_uploads', 228518, '[]', '[]', '[]', '[]', 3, '2024-01-19 11:22:17', '2024-01-19 11:22:17'),
(13, 'App\\Models\\Subtask', 48, '8525bfda-f6fd-4fb9-82b2-349b8c1c1a90', 'images', 'colorize-compare (1)', 'colorize-compare-(1).png', 'image/png', 'public_uploads', 'public_uploads', 404453, '[]', '[]', '[]', '[]', 4, '2024-01-26 15:38:29', '2024-01-26 15:38:29'),
(14, 'App\\Models\\Subtask', 48, 'a5b7d206-4d0e-4680-9ebd-a35280029fcc', 'images', 'aaee', 'aaee.png', 'image/png', 'public_uploads', 'public_uploads', 29175, '[]', '[]', '[]', '[]', 5, '2024-01-26 15:52:10', '2024-01-26 15:52:10'),
(15, 'App\\Models\\Subtask', 52, '939e9096-1537-4220-b634-0228db02415f', 'images', '_انتظار لا تضيع الوقت في الانتظار', '65bcf2278116e_انتظار-لا-تضيع-الوقت-في-الانتظار.jpg', 'image/jpeg', 'public_uploads', 'public_uploads', 241293, '[]', '[]', '[]', '[]', 6, '2024-02-02 10:46:15', '2024-02-02 10:46:15'),
(16, 'App\\Models\\Subtask', 54, 'd993cdc6-023e-4435-807d-0a44dbb9b4e6', 'images', 'مشروع جديد (9) (1)', '65c0bd0876323مشروع-جديد-(9)-(1).png', 'image/png', 'public_uploads', 'public_uploads', 450598, '[]', '[]', '[]', '[]', 7, '2024-02-05 10:48:40', '2024-02-05 10:48:40'),
(17, 'App\\Models\\Subtask', 56, 'eb1c8535-ad32-4c7e-bd26-6e48759238c9', 'images', 'مشروع جديد (9)', '65c1b78496a6fمشروع-جديد-(9).png', 'image/png', 'public_uploads', 'public_uploads', 1004738, '[]', '[]', '[]', '[]', 8, '2024-02-06 04:37:24', '2024-02-06 04:37:24'),
(18, 'App\\Models\\Subtask', 59, '100c5d8c-f2b1-4718-8d57-ad47dac3ac7c', 'images', 'dummy', '65c50fb65b7bedummy.pdf', 'application/pdf', 'public_uploads', 'public_uploads', 13264, '[]', '[]', '[]', '[]', 9, '2024-02-08 14:30:30', '2024-02-08 14:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_10_144628_create_todos_table', 2),
(7, '2023_07_15_142511_done_percentage_to_todos', 3),
(8, '2023_07_16_153036_add_position_to_users_table', 4),
(9, '2023_07_16_153438_add_parent_to_users_table', 5),
(10, '2023_07_16_153817_create_tickets_table', 6),
(11, '2023_07_21_074239_create_moashers_table', 7),
(12, '2023_07_30_074500_create_moashermkmfs_table', 8),
(13, '2023_07_30_074633_create_moasheradastrategies_table', 8),
(14, '2023_07_30_075124_create_moashermkmf_todos_table', 8),
(15, '2023_07_30_090858_create_moashermkmf_todo_table', 9),
(16, '2023_07_30_091744_create_moasheradastrategie_todo_table', 10),
(17, '2023_07_30_092303_create_moasheradastrategy_todo_table', 11),
(18, '2023_08_01_065228_create_hadafstrategies_table', 12),
(19, '2023_08_01_065432_create_mubadaras_table', 12),
(20, '2023_08_01_065807_create_tasks_table', 12),
(21, '2023_08_01_065825_create_subtasks_table', 12),
(22, '2023_08_01_070337_create_moasheradastrategy_mubadara_table', 13),
(23, '2023_08_01_070537_create_moashermkmf_task_table', 13),
(24, '2023_08_01_070848_add_parent_id_to_moasheradastrategies', 14),
(25, '2023_08_01_071257_add_parent_id_to_moashermkmfs', 15),
(26, '2023_08_01_071519_add_done_to_subtasks', 16),
(27, '2023_08_01_122111_add_hadafstrategy_id_to_mubadaras', 17),
(28, '2023_08_03_115729_add_type_to_moashermkmfs', 18),
(29, '2023_08_06_111519_add_user_id_to_hadafstrategies_table', 19),
(30, '2023_08_06_111648_add_user_id_to_mubadaras_table', 19),
(31, '2023_08_06_111747_add_user_id_to_tasks_table', 19),
(32, '2023_08_06_111823_add_user_id_to_subtasks_table', 19),
(33, '2023_08_06_152033_create_media_table', 20),
(34, '2023_08_07_070929_add_to_id_to_tickets_table', 21),
(35, '2023_08_07_071040_add_status_to_tickets_table', 22),
(36, '2023_08_07_072822_add_note_to_tickets_table', 23),
(37, '2023_08_08_152434_add_status_to_subtasks_table', 24),
(38, '2023_10_17_075308_add_fields_to_mubadaras', 25),
(39, '2023_10_17_075749_add_fields_to_tasks', 26),
(40, '2023_11_02_063037_add_complete_to_tasks_table', 27),
(41, '2024_01_04_185815_create_employee_positions_table', 28),
(42, '2024_01_04_185840_create_position_user_table', 29),
(43, '2024_01_04_193922_create_employee_position_relations_table', 30),
(44, '2024_01_08_223413_add_fields_to_subtasks_table', 31),
(45, '2024_01_27_110146_add_notes_to_subtasks_table', 32),
(46, '2024_02_02_111842_create_ticket_transitions_table', 33),
(47, '2024_02_02_112237_add_ticket_id_to_ticket_transitions_table', 34),
(48, '2024_02_02_133958_add_done_time_to_subtasks_table', 35),
(49, '2024_02_04_064511_add_due_time_to_tickets_table', 36);

-- --------------------------------------------------------

--
-- Table structure for table `moasheradastrategies`
--

CREATE TABLE `moasheradastrategies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moasheradastrategies`
--

INSERT INTO `moasheradastrategies` (`id`, `name`, `percentage`, `created_at`, `updated_at`, `parent_id`) VALUES
(37, 'مؤشر استراتيجي', 0, '2024-02-07 14:46:03', '2024-02-07 14:46:03', 64),
(38, 'مؤشر اداء 2', 50, '2024-02-08 14:06:13', '2024-02-08 14:31:07', 65);

-- --------------------------------------------------------

--
-- Table structure for table `moasheradastrategy_mubadara`
--

CREATE TABLE `moasheradastrategy_mubadara` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `moasheradastrategy_id` int(11) NOT NULL,
  `mubadara_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moasheradastrategy_mubadara`
--

INSERT INTO `moasheradastrategy_mubadara` (`id`, `moasheradastrategy_id`, `mubadara_id`, `created_at`, `updated_at`) VALUES
(24, 37, 18, NULL, NULL),
(25, 38, 19, NULL, NULL),
(26, 38, 20, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `moasheradastrategy_todo`
--

CREATE TABLE `moasheradastrategy_todo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `todo_id` int(10) UNSIGNED NOT NULL,
  `moasheradastrategy_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moashermkmfs`
--

CREATE TABLE `moashermkmfs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moashermkmfs`
--

INSERT INTO `moashermkmfs` (`id`, `name`, `percentage`, `created_at`, `updated_at`, `parent_id`, `type`) VALUES
(40, 'كفاءة', 0, '2024-02-07 14:46:41', '2024-02-07 14:46:41', 18, 'mk'),
(41, 'مؤشر كفاءة 2', 0, '2024-02-08 14:07:04', '2024-02-08 14:07:04', 19, 'mk'),
(42, 'مؤشر فعالية 2', 0, '2024-02-08 14:07:13', '2024-02-08 14:07:13', 19, 'mf'),
(43, 'مؤشر فعالية برامج1', 100, '2024-02-08 14:11:26', '2024-02-08 14:31:07', 20, 'mk');

-- --------------------------------------------------------

--
-- Table structure for table `moashermkmf_task`
--

CREATE TABLE `moashermkmf_task` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `moashermkmf_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moashermkmf_task`
--

INSERT INTO `moashermkmf_task` (`id`, `moashermkmf_id`, `task_id`, `created_at`, `updated_at`) VALUES
(44, 40, 25, NULL, NULL),
(45, 41, 26, NULL, NULL),
(46, 42, 26, NULL, NULL),
(47, 43, 27, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `moashermkmf_todo`
--

CREATE TABLE `moashermkmf_todo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `todo_id` int(10) UNSIGNED NOT NULL,
  `moashermkmf_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moashers`
--

CREATE TABLE `moashers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` int(11) NOT NULL,
  `moasher_kafaa_id` int(11) NOT NULL,
  `moasher_fa3lia_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mubadaras`
--

CREATE TABLE `mubadaras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hadafstrategy_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `general_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `estimate_cost` decimal(8,2) DEFAULT NULL,
  `dangers` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mubadaras`
--

INSERT INTO `mubadaras` (`id`, `name`, `percentage`, `parent_id`, `created_at`, `updated_at`, `hadafstrategy_id`, `user_id`, `general_desc`, `date_from`, `date_to`, `estimate_cost`, `dangers`) VALUES
(18, 'مبادرة', 0, 0, '2024-02-07 14:46:22', '2024-02-07 14:46:22', 64, 4, 'يب', '2024-02-07', '2024-02-29', '3.00', '3'),
(19, 'مبادرة 2', 0, 0, '2024-02-08 14:06:41', '2024-02-08 14:06:41', 65, 11, 'وصف', '2024-02-08', '2024-02-29', '1.00', '1'),
(20, 'مبادرة برامج شبابية', 100, 0, '2024-02-08 14:10:45', '2024-02-08 14:31:07', 65, 12, 'مبادرة', '2024-02-08', '2024-02-22', '1.00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position_user`
--

CREATE TABLE `position_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `done` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transfered` tinyint(1) NOT NULL DEFAULT 0,
  `parent_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `finished_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_time` datetime DEFAULT NULL,
  `done_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `name`, `percentage`, `parent_id`, `created_at`, `updated_at`, `done`, `user_id`, `status`, `transfered`, `parent_user_id`, `finished_user_id`, `notes`, `due_time`, `done_time`) VALUES
(57, 'تنظيف اوراق للإرسال', 0, 25, '2024-02-07 14:48:13', '2024-02-07 14:48:13', 0, 11, 'pending', 0, 4, NULL, NULL, '2024-02-07 23:19:00', NULL),
(58, 'إجراء فرعي 2', 0, 26, '2024-02-08 14:08:13', '2024-02-08 14:08:13', 0, 11, 'pending', 0, 4, NULL, NULL, NULL, NULL),
(59, 'مهمة لقسم البرامج', 100, 27, '2024-02-08 14:21:32', '2024-02-08 14:31:29', 1, 13, 'approved', 0, 12, 13, '', '2024-02-07 23:19:00', '2024-02-08 17:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `output` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `marketing_cost` decimal(8,2) NOT NULL,
  `real_cost` decimal(8,2) NOT NULL,
  `sp_week` date DEFAULT NULL,
  `ep_week` date DEFAULT NULL,
  `sr_week` date DEFAULT NULL,
  `er_week` date DEFAULT NULL,
  `r_money_paid` decimal(8,2) NOT NULL,
  `marketing_verified` tinyint(1) NOT NULL,
  `complete_percentage` tinyint(3) UNSIGNED NOT NULL,
  `quality_percentage` tinyint(3) UNSIGNED NOT NULL,
  `evidence` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roi` decimal(8,2) NOT NULL,
  `customers_count` int(11) NOT NULL,
  `perf_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recomm` tinyint(1) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `percentage`, `parent_id`, `created_at`, `updated_at`, `user_id`, `output`, `user`, `marketing_cost`, `real_cost`, `sp_week`, `ep_week`, `sr_week`, `er_week`, `r_money_paid`, `marketing_verified`, `complete_percentage`, `quality_percentage`, `evidence`, `roi`, `customers_count`, `perf_note`, `recomm`, `notes`) VALUES
(25, 'تنظيمية للسكرتير', 0, 18, '2024-02-07 14:47:15', '2024-02-07 14:47:59', 11, NULL, NULL, '1.00', '1.00', '2024-02-07', '2024-02-15', NULL, NULL, '1.00', 1, 1, 1, '1', '1.00', 1, '1', 1, '1'),
(26, 'إجراء رئيسي 2', 0, 19, '2024-02-08 14:07:56', '2024-02-08 14:07:56', NULL, NULL, NULL, '1.00', '1.00', '2024-02-08', '2024-02-22', NULL, NULL, '1.00', 1, 1, 1, '1', '1.00', 1, '1', 1, '1'),
(27, 'إجراء برامج شبابية', 100, 20, '2024-02-08 14:11:58', '2024-02-08 14:31:07', 13, NULL, NULL, '1.00', '1.00', '2024-02-08', '2024-02-21', NULL, NULL, '1.00', 1, 1, 1, '1', '1.00', 1, '1', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `todo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_time` timestamp NULL DEFAULT NULL,
  `from_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `user_id`, `todo_id`, `created_at`, `updated_at`, `to_id`, `status`, `note`, `due_time`, `from_id`) VALUES
(37, 'تذكرة تجربة', 4, 0, '2024-02-07 14:23:03', '2024-02-07 14:23:03', 5, 'pending', '232', '2024-02-07 20:19:00', 4),
(38, 'تنظيف اوراق للإرسال', 4, 0, '2024-02-07 14:37:35', '2024-02-07 14:48:13', 11, 'transfered', '22', '2024-02-08 13:37:00', 4),
(39, 'مهمة لقسم البرامج', 4, 0, '2024-02-08 14:18:56', '2024-02-08 14:21:32', 12, 'transfered', 'ملاحظات', '2024-02-09 18:18:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_transitions`
--

CREATE TABLE `ticket_transitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ticket_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_transitions`
--

INSERT INTO `ticket_transitions` (`id`, `from_state`, `to_state`, `created_at`, `updated_at`, `ticket_id`) VALUES
(29, '4', '5', '2024-02-07 14:23:03', '2024-02-07 14:23:03', 37),
(30, '4', '11', '2024-02-07 14:37:35', '2024-02-07 14:37:35', 38),
(31, '4', '11', '2024-02-07 14:48:13', '2024-02-07 14:48:13', 38),
(32, '4', '12', '2024-02-08 14:18:56', '2024-02-08 14:18:56', 39),
(33, '12', '13', '2024-02-08 14:21:32', '2024-02-08 14:21:32', 39);

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `collection_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `done` int(11) NOT NULL DEFAULT 0,
  `done_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `position`, `level`, `parent`) VALUES
(1, 'حسن المالكي', 'info@shababtops.com', NULL, '$2y$10$fmYd7UtNiDy7CgNrGcqK/.WWGHif1jk32MIfFHsJd6lHtM6tLp566', '0xKSrjiZwZXO4TPbzkhB5OQJ6JRNcmqWFg6xK89ng5OMI05lyr7QtEh7JpPk', NULL, NULL, 'ceo', 1, NULL),
(11, 'أحمد عقاب', 'secretary@qimam.org.sa', NULL, '$2y$10$YDp/aQSKzn2ISYENmnum.uRiTSH1gOmOBGUxDMU9ugdjScX2qGvJ2', NULL, '2024-02-07 11:40:54', '2024-02-07 11:40:54', NULL, NULL, NULL),
(12, 'ايمن غبان', 'pm@qimam.org.sa', NULL, '$2y$10$2CD2AUJG5S63dL6PsmAzouxqNB3pMqEvLgPXAyxF6pN7tLUaHZxQm', 'oKn4cE3JVMFTpJMDppPV0N1Pu3rnUb0UDyVEY75yyany9pJCU4R3x6Ny8E7i', '2024-02-07 11:48:23', '2024-02-07 11:48:23', NULL, NULL, NULL),
(13, 'عبد الله الشمراني', 'a_shomrani@qimam.org.sa', NULL, '$2y$10$mhLEeBkFNF2VPpHejZkL6u8QzuWcXM9i9B3DEjuEVZpBL6uP8hdVa', NULL, '2024-02-07 11:48:46', '2024-02-07 11:48:46', NULL, NULL, NULL),
(14, 'صفية مرزوقي', 'samarzoqi@qimam.org.sa', NULL, '$2y$10$x9mj3H3Go.JVZDSiBlTNxuCxDXVtIEiBMISUZ8SzLKO7kIqJBAaoi', NULL, '2024-02-07 11:49:04', '2024-02-07 11:49:04', NULL, NULL, NULL),
(15, 'سلمى عبد العال', 'saabdulaal@qimam.org.sa', NULL, '$2y$10$R7ysQ2M1l9e5.WrL1GR/ZudoMcw6ZA55NaIEVs7DrpptZauc/8eB2', NULL, '2024-02-07 11:49:20', '2024-02-07 11:49:20', NULL, NULL, NULL),
(16, 'عبد الله محزري', 'AbMahzari@qimam.org.sa', NULL, '$2y$10$o1hL6PCd1Z6plOHPHBpLregcEp2bOiotcMNG13iqoab1O.PRIAVs2', NULL, '2024-02-07 11:49:39', '2024-02-07 11:49:39', NULL, NULL, NULL),
(17, 'ربيع القحطاني', 'rqahtani@qimam.org.sa', NULL, '$2y$10$QE7uW8i3VeO7YPywShZMhudt3AGSEXE7zG89snrpMSMX/Kpk95lli', NULL, '2024-02-07 11:49:57', '2024-02-07 11:49:57', NULL, NULL, NULL),
(18, 'جهاد اليافعي', 'jealyaf3i@qimam.org.sa', NULL, '$2y$10$3LNNgGzvYv2II0Xb6JbvyesH86i0SUyEMELZ25zuXtWR9X5IEG6Di', NULL, '2024-02-07 11:50:14', '2024-02-07 11:50:14', NULL, NULL, NULL),
(19, 'الحسن الشيخي', 'halshaikhi@qimam.org.sa', NULL, '$2y$10$Jaii/qTwdnaH52.MD4vt5.5QAJH8j94NG7aQYWru3pXcMRyCt/O4u', NULL, '2024-02-07 11:50:31', '2024-02-07 11:50:31', NULL, NULL, NULL),
(20, 'عادل العقيلي', 'hrm@qimam.org.sa', NULL, '$2y$10$ffCi.tG1Kj8SnATpAEBlle4BItSTiwoqq1cTNSsmHlhbvB8fOGOYq', NULL, '2024-02-07 11:50:54', '2024-02-07 11:50:54', NULL, NULL, NULL),
(21, 'احمد الزهراني', 'ahmed_alzahrani@qimam.org.sa', NULL, '$2y$10$JXO8DWYGcG7ZI9zDRypvbeBieaNdCrZBR1XyyVzkflthrt.opuEzq', NULL, '2024-02-07 11:51:11', '2024-02-07 11:51:11', NULL, NULL, NULL),
(22, 'فيصل الربعي', 'support_services@qimam.org.sa', NULL, '$2y$10$ZUpERiwR5wCoR7EGds5Mxu7e1v55/Q3a1VrsI6pRtl1DHoR5KOvDG', NULL, '2024-02-07 11:51:27', '2024-02-07 11:51:27', NULL, NULL, NULL),
(23, 'علي باراس', 'it@qimam.org.sa', NULL, '$2y$10$4qg.ID4t7B.LC1TeMdyvduyD3rnynisV0KcpW4o3Adq1XNE2ibJaa', NULL, '2024-02-07 11:51:46', '2024-02-07 11:51:46', NULL, NULL, NULL),
(24, 'مدير الحوكمة', 'governance@qimam.org.sa', NULL, '$2y$10$//fNgRUJAR2.sH6PoPqie.LdM28w5kHJtKMlcmfNzrGRA8L3RY05y', NULL, '2024-02-07 15:38:27', '2024-02-07 15:38:27', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_positions`
--
ALTER TABLE `employee_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_position_relations`
--
ALTER TABLE `employee_position_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_position_relations_parent_id_foreign` (`parent_id`),
  ADD KEY `employee_position_relations_child_id_foreign` (`child_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hadafstrategies`
--
ALTER TABLE `hadafstrategies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moasheradastrategies`
--
ALTER TABLE `moasheradastrategies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moasheradastrategy_mubadara`
--
ALTER TABLE `moasheradastrategy_mubadara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moasheradastrategy_todo`
--
ALTER TABLE `moasheradastrategy_todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moashermkmfs`
--
ALTER TABLE `moashermkmfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moashermkmf_task`
--
ALTER TABLE `moashermkmf_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moashermkmf_todo`
--
ALTER TABLE `moashermkmf_todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moashers`
--
ALTER TABLE `moashers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mubadaras`
--
ALTER TABLE `mubadaras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position_user`
--
ALTER TABLE `position_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_transitions`
--
ALTER TABLE `ticket_transitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_positions`
--
ALTER TABLE `employee_positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `employee_position_relations`
--
ALTER TABLE `employee_position_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `hadafstrategies`
--
ALTER TABLE `hadafstrategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `moasheradastrategies`
--
ALTER TABLE `moasheradastrategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `moasheradastrategy_mubadara`
--
ALTER TABLE `moasheradastrategy_mubadara`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `moasheradastrategy_todo`
--
ALTER TABLE `moasheradastrategy_todo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moashermkmfs`
--
ALTER TABLE `moashermkmfs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `moashermkmf_task`
--
ALTER TABLE `moashermkmf_task`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `moashermkmf_todo`
--
ALTER TABLE `moashermkmf_todo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moashers`
--
ALTER TABLE `moashers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mubadaras`
--
ALTER TABLE `mubadaras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position_user`
--
ALTER TABLE `position_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ticket_transitions`
--
ALTER TABLE `ticket_transitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
