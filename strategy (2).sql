-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 06:20 PM
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
(1, 'المدير التنفيذي', 1, NULL, NULL),
(2, 'مدير مكتب الإستراتيجية', 2, NULL, NULL),
(3, 'إدارة التقنية', 5, '2024-01-05 06:16:56', '2024-01-05 06:16:56');

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
(4, 1, 2, '2024-01-06 14:38:59', '2024-01-06 14:38:59'),
(5, 3, 1, '2024-01-06 14:38:59', '2024-01-06 14:38:59'),
(6, 3, 2, '2024-01-06 14:58:42', '2024-01-06 14:58:42');

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
(1, 'تمكين الشباب في المهارات الحياتية والمهنية', 31, NULL, '2023-10-09 10:42:33', 1),
(4, 'تحسين استهلاك الكهرباء في المنازل', 0, '2023-08-03 03:57:47', '2023-08-03 03:57:47', NULL),
(5, 'جديد', 0, '2023-08-03 04:06:53', '2023-08-03 04:06:53', NULL),
(6, 'هدف استراتيجي تجربة', 0, '2023-08-06 03:54:04', '2023-08-06 03:54:04', 6),
(7, 'هدف استراتيجي علي', 0, '2023-08-08 08:20:14', '2023-08-08 08:20:14', NULL),
(8, 'هدف استراتيجي باراس', 0, '2023-08-08 08:21:45', '2023-08-08 08:21:45', NULL),
(9, 'استثمار وتفعيل المتطوعين', 0, '2023-08-09 03:18:57', '2023-08-09 03:18:57', NULL),
(10, 'تمكين الشباب في المهارات الحياتية والمهنية', 0, '2023-08-23 09:16:35', '2023-08-23 09:16:35', 5),
(11, 'هدف واحد', 0, '2023-08-23 09:22:37', '2023-08-23 09:22:37', 5),
(12, 'هدف استراتيجي تجربة', 0, '2023-08-23 10:11:18', '2023-08-23 10:11:18', 1),
(13, 'هدف استراتيجي تجربة 10', 0, '2023-08-23 10:31:14', '2023-08-23 10:31:14', 5),
(14, 'هدف استراتيجية جديد', 100, '2023-08-23 15:00:01', '2023-08-23 15:42:15', 5),
(15, 'استثمار وتفعيل المتطوعين', 75, '2023-10-05 07:23:30', '2023-10-05 08:49:25', 5),
(16, 'gg', 0, '2023-10-31 03:55:11', '2023-10-31 03:55:11', 1),
(17, 'e', 0, '2023-11-02 04:17:18', '2023-11-02 04:17:18', 1),
(18, 'هدف التجربة 10', 0, '2024-01-07 12:00:32', '2024-01-07 12:00:32', 3);

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
(1, 'App\\Models\\Subtask', 29, '78ad308f-6429-4623-a359-cd4d2156c585', 'images', 'اجراءات تعميد مشروع', 'اجراءات-تعميد-مشروع.pdf', 'application/pdf', 'public', 'public', 574036, '[]', '[]', '[]', '[]', 1, '2023-08-23 15:06:45', '2023-08-23 15:06:45'),
(2, 'App\\Models\\Subtask', 30, 'a4a05908-24af-4d94-ad3b-000b9e12bd78', 'images', 'اجراءات تعميد مشروع', 'اجراءات-تعميد-مشروع.pdf', 'application/pdf', 'public', 'public', 574036, '[]', '[]', '[]', '[]', 2, '2023-08-23 15:14:06', '2023-08-23 15:14:06'),
(3, 'App\\Models\\Subtask', 31, 'dc1e16a4-21f6-47ed-90a5-9932b584cc0b', 'images', 'اجراءات تعميد مشروع', 'اجراءات-تعميد-مشروع.pdf', 'application/pdf', 'public', 'public', 574036, '[]', '[]', '[]', '[]', 3, '2023-08-23 15:14:15', '2023-08-23 15:14:15'),
(4, 'App\\Models\\Subtask', 32, '003192ce-a2d5-47e7-8a5c-012e6b3851d0', 'images', 'غلاف أنا إيجابي[103]', 'غلاف-أنا-إيجابي[103].png', 'image/png', 'public', 'public', 3103080, '[]', '[]', '[]', '[]', 4, '2023-10-05 08:47:30', '2023-10-05 08:47:30'),
(5, 'App\\Models\\Subtask', 33, '09daf4ef-4375-4761-993e-368ccd9cdc1d', 'images', 'أنا إيجابي غلاف[101]', 'أنا-إيجابي-غلاف[101].jpg', 'image/jpeg', 'public', 'public', 235520, '[]', '[]', '[]', '[]', 5, '2023-10-05 08:47:50', '2023-10-05 08:47:50'),
(6, 'App\\Models\\Subtask', 34, '6ddef51a-6851-4205-8af7-cde79c37ca7b', 'images', 'غلاف أنا إيجابي[103]', 'غلاف-أنا-إيجابي[103].png', 'image/png', 'public', 'public', 3103080, '[]', '[]', '[]', '[]', 6, '2023-10-09 10:41:34', '2023-10-09 10:41:34'),
(7, 'App\\Models\\Subtask', 36, '3fceeb41-22b8-4309-9085-f48a3ca56c74', 'images', 'New Project', 'New-Project.png', 'image/png', 'public', 'public', 172885, '[]', '[]', '[]', '[]', 7, '2024-01-10 12:55:32', '2024-01-10 12:55:32'),
(8, 'App\\Models\\Subtask', 36, '96af273d-f004-4449-95fd-15000cbd8bf8', 'images', 'qim', 'qim.jpg', 'image/jpeg', 'public_uploads', 'public_uploads', 332062, '[]', '[]', '[]', '[]', 8, '2024-01-10 13:53:53', '2024-01-10 13:53:53'),
(9, 'App\\Models\\Subtask', 8, '227025f2-098d-4fc5-b1ab-802ce029d34b', 'images', 'qim', 'qim.jpg', 'image/jpeg', 'public_uploads', 'public_uploads', 332062, '[]', '[]', '[]', '[]', 9, '2024-01-10 13:57:22', '2024-01-10 13:57:22');

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
(44, '2024_01_08_223413_add_fields_to_subtasks_table', 31);

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
(1, 'عدد الشباب الذين تم تمكينهم في المهارات الحياتية والمهنية', 23, NULL, '2023-08-23 15:40:10', 1),
(2, 'الشباب المتحقق لديهم معايير الاختيار \r\n', 44, NULL, '2023-10-09 10:42:33', 1),
(3, 'متوسط الأثر المتحقق للشباب الممكنين وفق منهجية قمم لقياس الأثر التنموي', 25, NULL, '2023-10-09 10:42:33', 1),
(6, 'dsf', 0, '2023-08-03 04:24:37', '2023-08-03 04:24:37', 5),
(7, 'مؤشر 1', 0, '2023-08-08 09:02:19', '2023-08-08 09:02:19', 8),
(8, 'عدد الفرص التطوعية', 0, '2023-08-09 03:20:23', '2023-08-09 03:20:23', 9),
(9, 'عدد المتطوعين الفاعلين', 0, '2023-08-09 03:20:38', '2023-08-09 03:20:38', 9),
(10, 'متوسط تطبيق المعيار الوطني', 0, '2023-08-09 03:20:54', '2023-08-09 03:20:54', 9),
(11, 'عدد الشباب الذين تم تمكينهم في المهارات الحياتية والمهنية', 0, '2023-08-23 09:18:00', '2023-08-23 09:18:00', NULL),
(12, 'مؤشر واحد', 0, '2023-08-23 09:22:47', '2023-08-23 09:22:47', NULL),
(13, 'مؤشر واحد', 0, '2023-08-23 09:23:19', '2023-08-23 09:23:19', NULL),
(14, 'مؤشر استراتيجي تجربة', 0, '2023-08-23 10:11:31', '2023-08-23 10:11:31', 12),
(15, 'مؤشر تجربة 10', 0, '2023-08-23 10:31:28', '2023-08-23 10:31:28', 13),
(16, 'مؤشر استراتيجي جديد', 100, '2023-08-23 15:00:18', '2023-08-23 15:42:15', 14),
(17, 'عدد الفرص التطوعية الفاعلة في المنصة الوطنية للعمل التطوعي', 75, '2023-10-05 07:25:15', '2023-10-05 08:49:25', 15),
(18, 'مؤشر 10', 0, '2024-01-07 12:52:25', '2024-01-07 12:52:25', 18);

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
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 2, 2, NULL, NULL),
(4, 2, 3, NULL, NULL),
(5, 3, 1, NULL, NULL),
(6, 3, 3, NULL, NULL),
(10, 1, 7, NULL, NULL),
(11, 3, 7, NULL, NULL),
(12, 8, 8, NULL, NULL),
(13, 9, 8, NULL, NULL),
(14, 10, 8, NULL, NULL),
(15, 15, 9, NULL, NULL),
(16, 16, 10, NULL, NULL),
(17, 17, 11, NULL, NULL),
(18, 17, 12, NULL, NULL),
(19, 18, 13, NULL, NULL);

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

--
-- Dumping data for table `moasheradastrategy_todo`
--

INSERT INTO `moasheradastrategy_todo` (`id`, `todo_id`, `moasheradastrategy_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, NULL),
(2, 4, 2, NULL, NULL);

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
(1, 'عدد الشباب المستفيدين', 25, NULL, '2023-08-23 15:40:10', 1, 'تات'),
(2, 'عدد الأدلة', 25, NULL, '2023-08-23 15:40:10', 1, NULL),
(3, 'عدد المواد التدريبية', 47, NULL, '2023-08-02 13:50:17', 1, NULL),
(4, 'عدد المتوظفين', 25, NULL, '2023-08-23 15:40:10', 1, NULL),
(5, 'دليل واحد', 25, NULL, '2023-08-23 15:40:10', 1, NULL),
(6, 'عدد ساعات التدريب', 47, NULL, '2023-08-02 13:50:17', 1, NULL),
(7, 'عدد الشباب المستفيدين', 16, NULL, '2023-08-02 13:50:17', 2, NULL),
(8, 'عدد الأدلة', 16, NULL, '2023-08-02 13:50:17', 2, NULL),
(9, 'عدد المواد التدريبية', 92, NULL, '2023-08-02 13:50:17', 2, NULL),
(10, 'عدد المتوظفين', 16, NULL, '2023-08-02 13:50:17', 2, NULL),
(11, 'دليل واحد', 16, NULL, '2023-08-02 13:50:17', 2, NULL),
(12, 'عدد ساعات التدريب', 92, NULL, '2023-08-02 13:50:17', 2, NULL),
(13, 'عدد الشباب المستفيدين', 40, NULL, '2023-08-02 13:50:17', 3, NULL),
(14, 'عدد الأدلة', 40, NULL, '2023-08-02 13:50:17', 3, NULL),
(15, 'عدد المواد التدريبية', 58, NULL, '2023-08-02 13:50:17', 3, NULL),
(16, 'عدد المتوظفين', 40, NULL, '2023-08-02 13:50:17', 3, NULL),
(17, 'دليل واحد', 40, NULL, '2023-08-02 13:50:17', 3, NULL),
(18, 'عدد ساعات التدريب', 58, NULL, '2023-08-02 13:50:17', 3, NULL),
(23, 'مؤشر كفاءة اختبار', 0, '2023-08-03 09:08:03', '2023-08-03 09:08:03', 1, NULL),
(24, 'تطابق متطلبات دليل المعيار الوطني', 0, '2023-08-09 03:23:08', '2023-08-09 03:23:08', 8, 'mk'),
(25, 'عدد أدلة عمل التطوع الداخلية', 0, '2023-08-09 03:23:35', '2023-08-09 03:23:35', 8, 'mk'),
(26, 'عدد الفرص التطوعية المرفوعة على المنصة', 0, '2023-08-09 03:23:53', '2023-08-09 03:23:53', 8, 'mf'),
(27, 'عدد المتطوعين الفاعلين', 0, '2023-08-09 03:24:07', '2023-08-09 03:24:07', 8, 'mf'),
(28, 'مؤشر كفاءة وفاعلية 10', 0, '2023-08-23 10:32:40', '2023-08-23 10:32:40', 9, 'mk'),
(29, 'مؤشر كفاءة جديد', 100, '2023-08-23 15:01:00', '2023-08-23 15:42:15', 10, 'mk'),
(30, 'مؤشر فعالية جديد', 100, '2023-08-23 15:01:15', '2023-08-23 15:42:15', 10, 'mf'),
(31, 'إعداد دليل التطوع', 50, '2023-10-05 07:28:38', '2023-10-05 08:49:25', 11, 'mk'),
(32, 'عدد المتطوعين في الفرص التطوعية', 100, '2023-10-05 07:29:08', '2023-10-05 08:49:15', 11, 'mf'),
(33, 'مؤشر كفاءة 10', 0, '2024-01-07 13:02:24', '2024-01-07 13:02:24', 13, 'mk'),
(34, 'مؤشر فعالية 10', 0, '2024-01-07 13:02:36', '2024-01-07 13:02:36', 13, 'mf');

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
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 2, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 2, NULL, NULL),
(9, 7, 3, NULL, NULL),
(10, 8, 3, NULL, NULL),
(11, 9, 4, NULL, NULL),
(12, 10, 3, NULL, NULL),
(13, 11, 3, NULL, NULL),
(14, 12, 4, NULL, NULL),
(15, 13, 5, NULL, NULL),
(16, 14, 5, NULL, NULL),
(17, 15, 6, NULL, NULL),
(18, 16, 5, NULL, NULL),
(19, 17, 5, NULL, NULL),
(20, 18, 6, NULL, NULL),
(21, 23, 9, NULL, NULL),
(22, 24, 11, NULL, NULL),
(23, 25, 11, NULL, NULL),
(24, 24, 12, NULL, NULL),
(25, 25, 12, NULL, NULL),
(26, 26, 13, NULL, NULL),
(27, 27, 13, NULL, NULL),
(28, 26, 14, NULL, NULL),
(29, 27, 14, NULL, NULL),
(30, 28, 15, NULL, NULL),
(31, 29, 16, NULL, NULL),
(32, 30, 16, NULL, NULL),
(33, 31, 17, NULL, NULL),
(34, 32, 18, NULL, NULL),
(35, 31, 19, NULL, NULL),
(36, 33, 20, NULL, NULL),
(37, 34, 20, NULL, NULL);

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

--
-- Dumping data for table `moashermkmf_todo`
--

INSERT INTO `moashermkmf_todo` (`id`, `todo_id`, `moashermkmf_id`, `created_at`, `updated_at`) VALUES
(1, 10, 1, NULL, NULL),
(2, 10, 2, NULL, NULL);

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
(13, 'مبادرة 10', 0, 0, '2024-01-07 12:59:00', '2024-01-07 12:59:00', 18, 3, 'مبادرة 10', '2024-01-07', '2024-01-24', '100.00', 'مخاطرة 10');

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
  `finished_user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `name`, `percentage`, `parent_id`, `created_at`, `updated_at`, `done`, `user_id`, `status`, `transfered`, `parent_user_id`, `finished_user_id`) VALUES
(1, 'الإجراء 1 للمهة 1', 24, 1, NULL, NULL, 0, 5, 'NULL', 0, NULL, NULL),
(2, 'الإجراء 2 للمهة 1', 53, 1, NULL, NULL, 0, 1, 'NULL', 0, NULL, NULL),
(3, 'الإجراء 3 للمهة 1', 21, 1, NULL, NULL, 0, 1, 'NULL', 0, NULL, NULL),
(4, 'الإجراء 1 للمهة 2', 17, 2, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(5, 'الإجراء 2 للمهة 2', 50, 2, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(6, 'الإجراء 3 للمهة 2', 75, 2, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(7, 'الإجراء 1 للمهة 1', 11, 3, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(8, 'الإجراء 2 للمهة 1', 24, 3, NULL, '2024-01-10 13:57:22', 0, NULL, 'pending-approval', 0, NULL, NULL),
(9, 'الإجراء 3 للمهة 1', 13, 3, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(10, 'الإجراء 1 للمهة 2', 85, 4, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(11, 'الإجراء 2 للمهة 2', 90, 4, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(12, 'الإجراء 3 للمهة 2', 100, 4, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(13, 'الإجراء 1 للمهة 1', 15, 5, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(14, 'الإجراء 2 للمهة 1', 80, 5, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(15, 'الإجراء 3 للمهة 1', 24, 5, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(16, 'الإجراء 1 للمهة 2', 21, 6, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(17, 'الإجراء 2 للمهة 2', 66, 6, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(18, 'الإجراء 3 للمهة 2', 88, 6, NULL, NULL, 0, NULL, 'NULL', 0, NULL, NULL),
(21, 'subtask test', 0, 10, '2023-08-03 09:27:36', '2023-08-03 09:27:36', 0, NULL, 'NULL', 0, NULL, NULL),
(22, 'تذكرة تجربة', 0, 1, '2023-08-07 06:32:24', '2023-08-07 06:32:24', 0, 5, 'NULL', 0, NULL, NULL),
(23, 'مهمة فرعية 1', 0, 11, '2023-08-09 03:28:06', '2023-08-09 03:28:06', 0, NULL, 'NULL', 0, NULL, NULL),
(24, 'مهمة فرعية 2', 0, 11, '2023-08-09 03:28:15', '2023-08-09 03:28:15', 0, NULL, 'NULL', 0, NULL, NULL),
(25, 'مهمة فرعية 3', 0, 11, '2023-08-09 03:28:26', '2023-08-09 03:28:26', 0, NULL, 'NULL', 0, NULL, NULL),
(26, 'مهمة فرعية 11', 0, 12, '2023-08-09 03:29:34', '2023-08-09 03:29:34', 0, NULL, 'NULL', 0, NULL, NULL),
(27, 'مهمة فرعية 22', 0, 13, '2023-08-09 03:30:23', '2023-08-09 03:30:23', 0, 3, '', 0, NULL, NULL),
(28, 'مهمة فرعية 1111', 0, 14, '2023-08-09 03:30:51', '2023-08-09 03:30:51', 0, NULL, 'NULL', 0, NULL, NULL),
(29, 'مهمة فرعية 10', 0, 15, '2023-08-23 10:46:03', '2023-08-23 15:06:45', 0, 4, 'pending-approval', 0, NULL, NULL),
(30, 'مهمة فرعية جديدة', 100, 16, '2023-08-23 15:01:41', '2023-08-23 15:40:10', 1, 4, 'approved', 0, NULL, NULL),
(31, 'مهمة جديدة2', 100, 16, '2023-08-23 15:01:50', '2023-08-23 15:42:15', 1, 4, 'pending-approval', 0, NULL, NULL),
(32, 'العمل على جمع معلومات الدليل', 50, 17, '2023-10-05 07:30:00', '2023-10-05 08:49:25', 2, 4, 'approved', 0, NULL, NULL),
(33, 'رفع الفرص التطوعية في المنصة', 100, 18, '2023-10-05 07:31:18', '2023-10-05 08:49:15', 1, 4, 'approved', 0, NULL, NULL),
(34, 'حصر أعداد المتطوعين', 50, 17, '2023-10-05 08:59:35', '2023-10-09 10:42:33', 2, 4, 'approved', 0, NULL, NULL),
(35, 'مهمة فرعية 10', 3, 20, '2024-01-07 13:12:05', '2024-01-08 20:53:43', 0, 1, 'pending', 0, 3, NULL),
(36, 'تذكرة 10', 0, 20, '2024-01-10 12:54:22', '2024-01-10 12:55:32', 0, 3, 'pending-approval', 0, 3, NULL);

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
(1, 'الإجراء الأول', 25, 1, NULL, '2023-10-09 10:42:33', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(2, 'الإجراء الثاني', 47, 1, NULL, '2023-10-09 10:42:33', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(3, 'الإجراء الأول(2)', 16, 2, NULL, '2023-08-02 13:50:16', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(4, 'الإجراء الثاني(2)', 92, 2, NULL, '2023-10-09 10:42:33', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(5, 'الإجراء الأول(3)', 40, 3, NULL, '2023-10-09 10:42:33', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(6, 'الإجراء الثاني(3)', 58, 3, NULL, '2023-10-09 10:42:33', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(9, 'task test', 0, 0, '2023-08-03 09:18:49', '2023-08-03 09:18:49', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(10, 'subtask test', 0, 0, '2023-08-03 09:26:06', '2023-08-03 09:26:06', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(11, 'تقييم الإحتياج من الكوادر التطوعية', 0, 8, '2023-08-09 03:25:51', '2023-08-09 03:25:51', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(12, 'تقييم الإحتياج التدريبي للمتطوعين', 0, 8, '2023-08-09 03:26:25', '2023-08-09 03:26:25', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(13, 'تنفيذ مصفوفة تحفيز المتطوعين', 0, 8, '2023-08-09 03:26:50', '2023-08-09 03:26:50', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(14, 'تنفيذ مصفوفة اختيار المتطوعين', 0, 8, '2023-08-09 03:27:13', '2023-08-09 03:27:13', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(15, 'مهمة رئيسية 10', 0, 9, '2023-08-23 10:34:59', '2023-08-23 10:34:59', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(16, 'مهمة جديدة', 100, 10, '2023-08-23 15:01:28', '2023-08-23 15:42:15', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(17, 'إعداد الدليل الإجرائي للتطوع', 50, 11, '2023-10-05 07:29:38', '2023-10-05 08:49:25', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(18, 'تسجيل المتطوعين في الفرص التطوعية', 100, 11, '2023-10-05 07:30:59', '2023-10-05 08:49:15', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', 0, 0, 0, NULL, '0.00', 0, NULL, 0, NULL),
(19, '11', 0, 11, '2023-11-02 06:19:05', '2023-11-02 06:19:05', NULL, NULL, NULL, '11.00', '11.00', '2023-11-02', '2023-11-10', NULL, NULL, '11.00', 11, 11, 11, '11', '11.00', 11, '11', 11, '11'),
(20, 'إجراء 10', 0, 13, '2024-01-07 13:10:37', '2024-01-07 13:10:37', NULL, NULL, NULL, '1000.00', '100.00', '2024-01-16', '2024-01-09', NULL, NULL, '1000.00', 100, 10, 10, '10', '10000.00', 111, '1', 1, '1');

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
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `user_id`, `todo_id`, `created_at`, `updated_at`, `to_id`, `status`, `note`) VALUES
(1, 'تجربة تاسك', 5, 0, '2023-07-16 14:03:45', '2023-08-24 16:47:49', 1, 'pending-approval', '1'),
(2, 'ييي', 4, 0, '2023-07-16 14:49:24', '2023-07-16 14:49:24', 2, 'pending', NULL),
(3, 'مهمة تجريبية عن طريق نظام التكت', 4, 0, '2023-08-07 04:27:43', '2023-08-24 16:50:15', 5, 'pending-approval', NULL),
(4, 'تذكرة تجربة', 1, 0, '2023-08-07 04:32:09', '2023-08-07 06:32:24', 3, 'transfered', 'ملاحظة تجربة'),
(5, 'تذكرة تجربة 333', 4, 0, '2023-08-24 16:35:17', '2023-08-24 16:54:34', 4, 'pending', NULL),
(6, 'حصر أعداد المتطوعين', 5, 0, '2023-10-05 08:58:20', '2023-10-05 08:59:35', 5, 'transfered', 'نريد بشكل عاجل حصر أعداد المتطوعين'),
(7, 'تذكرة 10', 1, 3, '2024-01-10 11:45:13', '2024-01-10 12:54:22', 3, 'transfered', NULL);

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

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `task`, `level`, `collection_id`, `user_id`, `created_at`, `updated_at`, `done`, `done_percentage`) VALUES
(1, 'تحسين بيئة العمل', 1, 0, 4, NULL, '2023-07-25 02:26:49', 0, 17),
(2, 'البيئة الرقمية', 2, 1, 4, NULL, '2023-07-21 11:07:33', 0, 33),
(3, 'البيئة المكتبية', 2, 1, 4, NULL, '2023-07-25 02:26:49', 0, 0),
(4, 'اوفيس', 3, 2, 4, NULL, '2023-07-21 11:07:33', 0, 33),
(5, 'مكتب', 3, 3, 4, NULL, '2023-07-25 02:26:49', 0, 0),
(6, 'حزمة 365', 4, 4, 4, NULL, '2023-07-25 02:26:49', 0, 33),
(7, 'برنامج وورد', 5, 6, 4, NULL, '2023-07-25 02:26:49', 0, 33),
(8, 'زر التوسيط', 6, 7, 4, NULL, '2023-07-21 09:29:47', 1, 100),
(9, 'زر اليمين', 6, 7, 4, NULL, '2023-07-21 09:35:16', 0, 0),
(10, 'برنامج اكسل', 5, 6, 4, NULL, '2023-07-21 09:22:46', 0, 0),
(11, 'ديكور', 4, 5, 4, NULL, '2023-07-21 11:07:33', 0, 0),
(12, 'دولاب', 5, 11, 4, NULL, '2023-07-21 09:27:53', 0, 0),
(13, 'رف 1', 6, 12, 4, NULL, '2023-07-16 11:50:59', 0, 0),
(14, 'رف 2', 6, 12, 4, NULL, NULL, 0, 0),
(16, 'زر تغيير الخط', 6, 7, 5, '2023-07-21 11:07:32', '2023-07-21 11:07:32', 0, 0),
(17, 'حزمة 2019', 4, 4, 4, NULL, '2023-07-25 02:26:49', 0, 33);

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
(1, 'منتصر الشيخ', 'ab@ab.com', NULL, '$2y$10$fmYd7UtNiDy7CgNrGcqK/.WWGHif1jk32MIfFHsJd6lHtM6tLp566', 'jFgpFdWsbfp4g3Tkngz7XP8NGXfuXBmeDgnY1oNHZOnmOPBbsHD0bQsG63qg', NULL, NULL, 'ceo', 1, NULL),
(2, 'عثمان حكمي', 'othman@gmail.com', NULL, '', NULL, NULL, NULL, 'helper', 2, 1),
(3, 'فهمي', 'fahmi@gmail.com', NULL, '', NULL, NULL, NULL, 'manager', 3, 2),
(4, 'محمد دعبول', 'd@d.com', NULL, '$2y$10$7DTQOISmgrdRiSzyCQUL.OxpGL4Fi9IttjwC7ssWAePlR6jC2CD6W', 'PqILzxMQRojEbZzeJgdb2J0zgHCv7CDPgd6pe6dfDw50b1oje4JIeayKDABX', NULL, NULL, 'employee', 4, 5),
(5, 'ali', 'ali@ali.com', NULL, '$2y$10$fmYd7UtNiDy7CgNrGcqK/.WWGHif1jk32MIfFHsJd6lHtM6tLp566', '6c7yApAJru4ALgKDpJWOTQ0QBi99TUnBOLQmkhdLDcoepgFkp3MBlj7hYjcd', '2023-07-21 08:28:10', '2023-07-21 08:28:10', NULL, NULL, NULL),
(6, 'ali baras', 'baras@qimam.org.sa', NULL, '$2y$10$7DTQOISmgrdRiSzyCQUL.OxpGL4Fi9IttjwC7ssWAePlR6jC2CD6W', NULL, '2023-08-08 08:10:38', '2023-08-08 08:10:38', NULL, NULL, 7),
(7, 'sami', 'sami@sami.com', NULL, '$2y$10$7DTQOISmgrdRiSzyCQUL.OxpGL4Fi9IttjwC7ssWAePlR6jC2CD6W', 'MrCuPDGDlK82T9VQRefRPWrdrDFZBJqqJLKCHYsbnYmUV7dGV136ONblkEbK', '2023-08-09 02:44:13', '2023-08-09 02:44:13', NULL, NULL, NULL);

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
-- Indexes for table `position_user`
--
ALTER TABLE `position_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_user_user_id_foreign` (`user_id`),
  ADD KEY `position_user_position_id_foreign` (`position_id`);

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
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_positions`
--
ALTER TABLE `employee_positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_position_relations`
--
ALTER TABLE `employee_position_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hadafstrategies`
--
ALTER TABLE `hadafstrategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `moasheradastrategies`
--
ALTER TABLE `moasheradastrategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `moasheradastrategy_mubadara`
--
ALTER TABLE `moasheradastrategy_mubadara`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `moasheradastrategy_todo`
--
ALTER TABLE `moasheradastrategy_todo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `moashermkmfs`
--
ALTER TABLE `moashermkmfs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `moashermkmf_task`
--
ALTER TABLE `moashermkmf_task`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `moashermkmf_todo`
--
ALTER TABLE `moashermkmf_todo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `moashers`
--
ALTER TABLE `moashers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mubadaras`
--
ALTER TABLE `mubadaras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `position_user`
--
ALTER TABLE `position_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_position_relations`
--
ALTER TABLE `employee_position_relations`
  ADD CONSTRAINT `employee_position_relations_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `employee_positions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_position_relations_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `employee_positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `position_user`
--
ALTER TABLE `position_user`
  ADD CONSTRAINT `position_user_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `employee_positions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `position_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
