-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2018 at 07:26 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cdip_hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `emp_training_info`
--

CREATE TABLE `emp_training_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `training_name` varchar(50) NOT NULL,
  `training_period` varchar(50) NOT NULL,
  `training_institute` varchar(100) NOT NULL,
  `training_place` varchar(50) NOT NULL,
  `training_marks` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actions`
--

CREATE TABLE `tbl_actions` (
  `id` int(11) NOT NULL,
  `action_name` varchar(20) NOT NULL,
  `action_id` tinyint(4) NOT NULL,
  `action_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_actions`
--

INSERT INTO `tbl_actions` (`id`, `action_name`, `action_id`, `action_status`) VALUES
(1, 'List', 1, 1),
(2, 'Save', 2, 1),
(3, 'Update', 3, 1),
(4, 'Delete', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `emp_id` int(11) NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell_no` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_photo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_label` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL DEFAULT '181',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `emp_id`, `first_name`, `last_name`, `admin_name`, `email_address`, `cell_no`, `admin_password`, `admin_photo`, `access_label`, `org_code`, `created_at`, `updated_at`) VALUES
(1, 2397, 'Zahidul', 'Islam', 'polash', 'polashcdip@gmail.com', '01844006822', 'e10adc3949ba59abbe56e057f20f883e', '1505034887.jpg', 1, 181, NULL, NULL),
(2, 3000, 'Deep Roy', 'Moulik', 'deep', 'deepcdip@gmail.com', '01844079372', 'e10adc3949ba59abbe56e057f20f883e', '1519012369.jpg', 1, 181, NULL, NULL),
(3, 2002, 'Mahmuda', 'Akhter', 'Mahmuda', 'mahmudacdip@gmail.com', '017381', 'e10adc3949ba59abbe56e057f20f883e', 'avatar.png', 1, 181, NULL, NULL),
(4, 11, 'Pronab', 'Mondal', 'Pronab', 'pronab@gmail.com', '21', 'e10adc3949ba59abbe56e057f20f883e', 'avatar.png', 1, 181, NULL, NULL),
(5, 3305, 'Deponker', 'Ray', 'Deponker', 'deponkar@gmail.com', '01748998128', 'e10adc3949ba59abbe56e057f20f883e', 'avatar.png', 12, 181, NULL, NULL),
(6, 1230, 'Mohammad', 'Ali', 'ali', 'alicdip@gmail.com', '01844006811', 'e10adc3949ba59abbe56e057f20f883e', '1522751201.jpg', 3, 181, NULL, NULL),
(7, 2138, 'Gazi Zahid', 'Ahsan', 'gazi', 'gazicdip@gmail.com', '01844006812', 'e10adc3949ba59abbe56e057f20f883e', '1522751388.jpg', 3, 181, NULL, NULL),
(8, 527, 'Abdur', 'Rouf', 'roufe', 'roufecdip@gmail.com', '01844006813', 'e10adc3949ba59abbe56e057f20f883e', '1522751626.jpg', 3, 181, NULL, NULL),
(9, 2540, 'Tazul', 'Islam', 'tazul', 'tazulcdip@gmail.com', '01844006815', 'e10adc3949ba59abbe56e057f20f883e', '1522751737.jpg', 3, 181, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_user_role`
--

CREATE TABLE `tbl_admin_user_role` (
  `id` int(11) NOT NULL,
  `admin_role_name` varchar(50) NOT NULL,
  `role_description` text NOT NULL,
  `role_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin_user_role`
--

INSERT INTO `tbl_admin_user_role` (`id`, `admin_role_name`, `role_description`, `role_status`) VALUES
(1, 'Super Admin', 'This is Super Admin', 1),
(2, 'Admin', 'This is Admin', 1),
(3, 'HR Admin', 'This is HR Admin', 1),
(4, 'Pay Role Admin', 'This is Pay Role Admin', 1),
(5, 'HR Entry Checker', 'This is HR Entry Checker', 1),
(6, 'Pay Role Entry Checker', 'This is Pay Role Entry Checker', 1),
(7, 'HR Data Entry', '---', 1),
(8, 'Pay Role Data Entry', '---', 1),
(9, 'HR- Branch Admin', '---', 1),
(10, 'Pay Role - Branch Admin', 'uuuuuuuuuu', 1),
(11, 'aaa', 'aaa', 2),
(12, 'Employee', 'This is User Role', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_info`
--

CREATE TABLE `tbl_appointment_info` (
  `id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `emp_name_bangla` varchar(50) DEFAULT NULL,
  `fathers_name` varchar(50) NOT NULL,
  `fathers_name_bangla` varchar(50) NOT NULL,
  `emp_village` varchar(50) NOT NULL,
  `emp_village_bangla` varchar(50) NOT NULL,
  `emp_po` varchar(50) NOT NULL,
  `emp_po_bangla` varchar(50) NOT NULL,
  `emp_district` varchar(10) NOT NULL,
  `emp_thana` varchar(10) NOT NULL,
  `joining_date` date NOT NULL,
  `joining_branch` varchar(10) NOT NULL,
  `join_as` tinyint(4) NOT NULL,
  `period` varchar(50) NOT NULL,
  `gross_salary` varchar(10) NOT NULL,
  `diposit_money` varchar(10) NOT NULL,
  `emp_designation` tinyint(4) NOT NULL,
  `emp_department` tinyint(4) NOT NULL,
  `grade_code` int(5) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `next_permanent_date` date NOT NULL,
  `reported_to` varchar(20) NOT NULL,
  `joined_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appointment_info`
--

INSERT INTO `tbl_appointment_info` (`id`, `sarok_no`, `emp_id`, `letter_date`, `emp_name`, `emp_name_bangla`, `fathers_name`, `fathers_name_bangla`, `emp_village`, `emp_village_bangla`, `emp_po`, `emp_po_bangla`, `emp_district`, `emp_thana`, `joining_date`, `joining_branch`, `join_as`, `period`, `gross_salary`, `diposit_money`, `emp_designation`, `emp_department`, `grade_code`, `grade_step`, `next_permanent_date`, `reported_to`, `joined_date`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`, `status`) VALUES
(1, 1, 3305, '2017-05-02', 'Dipankar Roy', 'দীপঙ্কর রয়', 'Sonot Kumar Roy', 'সনত কুমার রয়', 'Borodia', 'বড়দিয়া', 'Kalia', 'কালিয়া', '33', '235', '2017-05-10', '0', 1, '6', '40000', '5000', 17, 3, 83, 0, '2017-11-10', '1', '2017-05-02', '2018-05-10 05:56:27', '2018-05-10 05:56:27', 1, NULL, 181, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_letter`
--

CREATE TABLE `tbl_appointment_letter` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `letter_body` text NOT NULL,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_appointment_letter`
--

INSERT INTO `tbl_appointment_letter` (`id`, `emp_id`, `letter_body`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 3305, '<h2>নিয়োগপত্র</h2>\r\n\r\n<p>আইডি নং&nbsp; : 3305<br />\r\nতারিখ&nbsp; &nbsp; &nbsp; &nbsp; :&nbsp; 2017-05-02<br />\r\nপ্রতি,&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp; দীপঙ্কর রয়<br />\r\nপিতা&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: সনত কুমার রয়<br />\r\nগ্রাম&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :&nbsp;বড়দিয়া<br />\r\nপোঃ&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp;কালিয়া<br />\r\nউপজেলা :<br />\r\nজেলা&nbsp; &nbsp; &nbsp; &nbsp;:</p>\r\n\r\n<p>জনাব,</p>\r\n\r\n<p>আপনার আবেদন ও সাক্ষাতের ভিত্তিতে আপনাকে <strong> সিনিয়ার এরিয়া ম্যানেজার । </strong> পদে নিম্নলিখিত শর্তে অস্থায়ীভাবে নিয়োগ দেয়া হলো।</p>\r\n\r\n<ul>\r\n	<li>আপনাকে সংস্থায় 6 মাস শিক্ষানবিসকালিন (Probation Period )দায়িত্ব পালন করতে হবে।</li>\r\n	<li>শিক্ষানবিস সময়ে (Probation Period) আপনাকে মাসিক সর্বসাকুল্যে 40000 /- টাকা বেতন দেয়া হবে। 6 মাস শিক্ষানবিসকাল (Probation Period) শেষে স্থায়ীকরনের জন্য আপনাকে আবেদন করতে হবে। আপনার কাজের মান কতৃপক্ষের নিকত সন্তসজনক বিবেচিত হলে তাদের সুপারিশের ভিত্তিতে আপনাকে স্থায়ী করা হবে এবং সংস্থার নিয়ম অনুযায়ী নির্ধারিত বেতন স্কেলে বেতন-ভাতা প্রদান করা হবে।</li>\r\n	<li>আপনি সংস্থার নিয়ম অনুযায়ী উৎসব ভাতা পাবেন।</li>\r\n	<li>সংস্থার নিয়ম অনুসারে ছুটি ভোগ করতে পারবেন।</li>\r\n	<li>আপনাকে সংস্থার সর্ব প্রকার নিয়ম-নিতি মেনে চলতে হবে।</li>\r\n	<li>শিক্ষানবিসকালিন সময়ে (Probation Period) আপনাকে বিনা ক্ষতিপূরণে, বিনা নোটিশে চাকরি হতে অব্যাহতি দেয়া যাবে।</li>\r\n	<li>চাকরি হতে পদত্যাগ চাইলে একমাস পূর্বে লিখিত ভাবে জানাতে হবে অন্যথায় একমাসের মূল বেতনের সমপরিমাণ টাকা নোটিশ -পে হিসেবে কর্তন হবে অথবা সংস্থা ইচ্ছা করলে আপনাকে একমাসের বেতনের সমপরিমাণ টাকা নোটিশ -পে দিয়ে চাকরি হতে অব্যাহতি প্রদান করতে পারবে।</li>\r\n	<li>ভবিষ্যতে সংস্থা কত্রিক নিয়োগ সংক্রান্ত বিষয়ে কোন পরিবর্তন আনা হলে তা মেনে নিয়ে সংস্থার চাহিদা মোতাবেক প্রয়োজনীয় ডকুমেন্ট সরবরাহ করতে বাধ্য থাকবেন। ডকুমেন্টস সরবরাহে ব্যথতার কারনে আপনার নিয়োগ সংস্থা কত্রিক বাতিল করার প্রয়োজনীয়তা দেখা দিলে সেক্ষেত্রে আপনার কোন ওজর আপত্তি গ্রহণযোগ্য হবে না।</li>\r\n	<li>আপনি আপনার কাজের জন্য 1 । এর নিকট দায়বদ্ধ থাকবেন।</li>\r\n</ul>\r\n\r\n<p>ধন্যবাদান্তে,</p>\r\n\r\n<p><br />\r\nমোহাম্মাদ ইয়াহিয়া<br />\r\nনির্বাহী পরিচালক</p>\r\n\r\n<p>উপরক্ত শর্তাবলী আপনার নিকট গ্রহণযোগ্য হলে সিনিয়ার এরিয়া ম্যানেজার । পদে অদ্য 2017-05-10 তারিখে সংস্থার প্রধান কার্যালয় ব্রাঞ্ছের ক্রেডিট প্রোগ্রাম যোগদান করবেন।</p>\r\n\r\n<p>অনুলিপিঃ</p>\r\n\r\n<p>১. পরিচালক (প্রোগ্রাম)।<br />\r\n১.ক্রেডিট প্রোগ্রাম<br />\r\n৩. হিসাব বিভাগ।<br />\r\n৪. ব্যক্তিগত ফাইল।</p>\r\n\r\n<p>&nbsp;</p>', 1, 1, '2018-05-10 06:03:59', '2018-05-10 06:03:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_area`
--

CREATE TABLE `tbl_area` (
  `id` int(11) NOT NULL,
  `area_name` varchar(30) NOT NULL,
  `area_code` tinyint(4) NOT NULL,
  `zone_code` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_area`
--

INSERT INTO `tbl_area` (`id`, `area_name`, `area_code`, `zone_code`, `status`) VALUES
(1, 'Narayangonj', 1, 1, 1),
(2, 'Sonargaon', 2, 1, 1),
(3, 'Munshigonj', 3, 1, 1),
(4, 'Titas', 4, 1, 1),
(5, 'Nobabgonj', 5, 1, 1),
(6, 'Kuti', 6, 2, 1),
(7, 'Solimgonj', 7, 2, 1),
(8, 'Moinamoti', 8, 2, 1),
(9, 'Mohonpur', 9, 2, 1),
(10, 'Dharkar', 10, 2, 1),
(11, 'Ashulia', 11, 3, 1),
(12, 'Gazipur', 12, 3, 1),
(13, 'Pabna', 13, 3, 1),
(14, 'Sahjadpur', 14, 3, 1),
(15, 'Chadpur', 15, 4, 1),
(16, 'Laksham', 16, 4, 1),
(17, 'Hazigonj', 17, 4, 1),
(18, 'Laxmipur', 18, 4, 1),
(19, 'Chittagonj', 19, 5, 1),
(20, 'Feni', 20, 5, 1),
(21, 'Noakhali', 21, 5, 1),
(22, 'Bazra', 22, 5, 1),
(23, 'Rajshahi', 23, 6, 1),
(24, 'Nator', 24, 6, 1),
(25, 'Boraigram', 25, 6, 1),
(26, 'Chapainobabgonj', 26, 6, 1),
(27, 'Head Office', 0, 0, 1),
(28, 'Charigram', 27, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_board`
--

CREATE TABLE `tbl_board` (
  `id` int(11) NOT NULL,
  `board_name` varchar(50) NOT NULL,
  `board_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_board`
--

INSERT INTO `tbl_board` (`id`, `board_name`, `board_id`) VALUES
(1, 'Dhaka', 0),
(2, 'Rajsahi', 1),
(3, 'Comilla', 2),
(4, 'Jessore', 3),
(5, 'Chittagong', 4),
(6, 'Barishal', 5),
(7, 'Sylhet', 6),
(8, 'Dinajpur', 7),
(9, 'Madrasah', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_board_university`
--

CREATE TABLE `tbl_board_university` (
  `id` int(11) NOT NULL,
  `board_uni_code` smallint(6) NOT NULL,
  `board_uni_name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_board_university`
--

INSERT INTO `tbl_board_university` (`id`, `board_uni_code`, `board_uni_name`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(2, 1, 'Dhaka Board', 1, '2017-11-09 10:12:19', '2017-12-04 09:14:09', NULL, NULL, 181),
(3, 2, 'Rajshahi Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(4, 3, 'Comilla Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(5, 4, 'Dinajpur Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(6, 5, 'Sylhet Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(7, 6, 'Jessor Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(8, 7, 'Borishal Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(9, 8, 'Chittagong Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(10, 9, 'National University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(11, 10, 'Dhaka University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(12, 11, 'Rajshahi University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(13, 12, 'Jahangirnagar University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(14, 14, 'World University Of Bangladesh', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(15, 15, 'Asa University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(16, 16, 'Stamford University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(17, 17, 'Green University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(18, 18, 'Asian University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(19, 19, 'Khulna University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(20, 20, 'Comilla University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(21, 21, 'Chittagong University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(22, 22, 'Jagannath University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(23, 23, 'Borishal University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(24, 24, 'Rokeya University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(25, 28, 'Islamic University, Khustia', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(26, 29, 'Bangladesh Madrasha Education Board', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(27, 33, 'IBAIS University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(28, 35, 'N/A', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(29, 36, 'Madrasa', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(30, 37, 'Daffodil Int University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(31, 38, 'Open University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(32, 39, 'Bangladesh Tech Edu Board, Dhaka', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(33, 40, 'Rajshahi City College', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(34, 41, 'School', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(35, 42, 'Comilla Teacher Trai College', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(36, 43, 'High school', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(37, 44, 'Pundra University of Science & Technology, Bogra', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(38, 45, 'Darul Ahsan University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(39, 46, 'University of Asia Pacific', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(40, 47, 'IUBAT, Bangladesh', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(41, 48, 'Eastern University, Dhaka', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(42, 49, 'East West University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(43, 50, 'Bangladesh Agricultural University, Mymensingh', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(44, 51, 'Prime University', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(45, 52, 'Premier University of Technology', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(46, 53, 'Intermediate & Secondary Edu Boards BD', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(47, 54, 'BUBT', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(48, 55, 'Shanta-Mariam University of Creative Technology', 1, '2017-11-09 10:12:19', NULL, NULL, NULL, 181),
(49, 56, 'aa', 1, '2017-11-13 06:04:37', '2017-11-13 06:08:09', NULL, NULL, 181),
(50, 57, 'ab', 1, '2017-11-13 06:08:17', '2017-11-13 06:08:17', NULL, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `br_id` int(11) NOT NULL,
  `br_code` varchar(10) NOT NULL,
  `branch_name` varchar(30) NOT NULL,
  `br_name_bangla` varchar(50) NOT NULL,
  `branch_contact_no` varchar(11) NOT NULL DEFAULT '01844006800',
  `branch_email` varchar(50) NOT NULL DEFAULT 'cdipbd@gmail.com',
  `branch_address` varchar(250) NOT NULL DEFAULT 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.',
  `start_date` date NOT NULL,
  `area_code` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`br_id`, `br_code`, `branch_name`, `br_name_bangla`, `branch_contact_no`, `branch_email`, `branch_address`, `start_date`, `area_code`, `status`) VALUES
(1, '1', 'Kuti', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 6, 1),
(2, '2', 'Dharkar', 'ধরখার', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 10, 1),
(3, '3', 'Chargas', 'চারগাস', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 10, 1),
(4, '4', 'Bitghar', 'বিটঘর', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 10, 1),
(5, '5', 'Hyderabad', 'হায়দ্রাবাদ', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 6, 1),
(6, '6', 'Srikail', 'শ্রিকাইল', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 7, 1),
(7, '7', 'Salimgonj', 'সলিমগঞ্জ', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 7, 1),
(8, '8', 'Ruposhdi', 'রুপসদি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 7, 1),
(9, '9', 'Maona', 'মাওনা', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 12, 1),
(10, '10', 'South Bangura', 'দক্ষিন বাঙ্গুরা', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 9, 1),
(11, '11', 'Sahebabad', 'সাহেবাবাদ', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 6, 1),
(12, '12', 'Bholachong', 'ভোলাচং', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 7, 1),
(13, '13', 'Bharasar Bazar', 'ভরসার বাজার', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(14, '14', 'Mohonpur', 'মোহনপুর', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 9, 1),
(15, '15', 'Joina', 'জইনা', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 12, 1),
(16, '16', 'Moinamoti', 'ময়নামতি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(17, '17', 'Nimshar', 'নিমসার', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 9, 1),
(18, '18', 'Hajigonj', 'হাজিগঞ্জ', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 17, 1),
(19, '19', 'Rahimanagor', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 17, 1),
(20, '20', 'Shahrasti', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 17, 1),
(21, '21', 'Waruk', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 17, 1),
(22, '22', 'Rampur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 15, 1),
(23, '23', 'Gazipur Sadar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 12, 1),
(24, '24', 'Porabari', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 12, 1),
(25, '25', 'Rajabari', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 12, 1),
(26, '26', 'Board Bazar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 11, 1),
(27, '27', 'Pubail', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 11, 1),
(28, '28', 'Ashulia', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 11, 1),
(29, '29', 'Kashimpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 11, 1),
(30, '30', 'Nayarhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 11, 1),
(31, '31', 'Sonargaon', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 2, 1),
(32, '32', 'Modonpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 2, 1),
(33, '33', 'Araihazar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 2, 1),
(34, '34', 'Modongonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(35, '35', 'Bhaberchar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 2, 1),
(36, '36', 'Tongibari', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 3, 1),
(37, '37', 'Abdullahpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(38, '38', 'Munshigonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(39, '39', 'Srinagar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 3, 1),
(40, '40', 'Sirajdikhan', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 3, 1),
(41, '41', 'Zamidarhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 20, 1),
(42, '42', 'Khalipharhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 21, 1),
(43, '43', 'Bajra', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 22, 1),
(44, '44', 'Chandragonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 18, 1),
(45, '45', 'Dagonbhuiya', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 20, 1),
(46, '46', 'Raipur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 18, 1),
(47, '47', 'Haidergonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 18, 1),
(48, '48', 'Laxmipur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 18, 1),
(49, '49', 'Ramgonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 15, 1),
(50, '50', 'Faridgonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 15, 1),
(51, '51', 'Barera', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(52, '52', 'Madhaiya', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 9, 1),
(53, '53', 'Mahamaya', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 15, 1),
(54, '54', 'Chapapur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(55, '55', 'Nabigonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(56, '56', 'Naopara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 3, 1),
(57, '57', 'Nodona', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 22, 1),
(58, '58', 'Mandari', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 18, 1),
(59, '59', 'Maizdi', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 21, 1),
(60, '60', 'Dasherhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 21, 1),
(61, '61', 'Bagmara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 16, 1),
(62, '62', 'Bipulashar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 22, 1),
(63, '63', 'Laksham', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 16, 1),
(64, '64', 'Nangolkot', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 16, 1),
(65, '65', 'Khilabazar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 22, 1),
(66, '66', 'Mudafforgonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 16, 1),
(67, '67', 'Bangla Bazar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 21, 1),
(68, '68', 'Kankirhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 20, 1),
(69, '69', 'Sonapur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 21, 1),
(70, '70', 'Chatkhil', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 22, 1),
(71, '71', 'Miar Bazar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(72, '72', 'Kamalla', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 9, 1),
(73, '73', 'Torpurchandi', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 15, 1),
(74, '74', 'Changolnaiya', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 20, 1),
(75, '75', 'Zinshar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 16, 1),
(76, '76', 'Siddirgonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(77, '77', 'Islampur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 3, 1),
(78, '78', 'Kaldaha', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 20, 1),
(79, '79', 'Gawsia', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 2, 1),
(80, '80', 'Juranpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 4, 1),
(81, '81', 'Baroiyerhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 19, 1),
(82, '82', 'Bara Kumira', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 19, 1),
(83, '83', 'Colonelhat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 19, 1),
(84, '84', 'Raipur (Gouripur)', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 4, 1),
(85, '85', 'Mirsharai', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 19, 1),
(86, '86', 'Meghna', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 4, 1),
(87, '87', 'Titas', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 4, 1),
(88, '88', 'Sachar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 17, 1),
(89, '89', 'Mathabhanga', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 4, 1),
(90, '90', 'Sitakunda', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 19, 1),
(91, '91', 'Kashinathpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 14, 1),
(92, '92', 'C&B Bazar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 14, 1),
(93, '93', 'Sathia', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 14, 1),
(94, '94', 'Ananto', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 13, 1),
(95, '95', 'Balurchar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 13, 1),
(96, '96', 'Debettor', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 13, 1),
(97, '97', 'Rajapur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 25, 1),
(98, '98', 'Harishpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 24, 1),
(99, '99', 'Putia', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 23, 1),
(100, '100', 'Katakhali', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 23, 1),
(101, '101', 'Sujanagar', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 13, 1),
(102, '102', 'Aotapara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 25, 1),
(103, '103', 'Noldanga', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 24, 1),
(104, '104', 'Taherpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 24, 1),
(105, '105', 'Paba', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 23, 1),
(106, '106', 'Bhangura', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 13, 1),
(107, '107', 'Bhagatipara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 24, 1),
(108, '108', 'Bonpara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 25, 1),
(109, '109', 'Gurudaspur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 25, 1),
(110, '110', 'Singra', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 24, 1),
(111, '118', 'Ullapara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 14, 1),
(112, '119', 'Shahjadpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 14, 1),
(113, '120', 'Gopalpur (Lalpur)', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 25, 1),
(114, '112', 'Bhagha', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 23, 1),
(115, '113', 'Mohanpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 23, 1),
(116, '111', 'Tanor', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 26, 1),
(117, '114', 'Godagari', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 26, 1),
(118, '115', 'Chapainawabganj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 26, 1),
(119, '116', 'Shibgonj', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 26, 1),
(120, '117', 'Bholahat', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 26, 1),
(121, '121', 'Nayanpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 6, 1),
(122, '122', 'Gopinathpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 6, 1),
(123, '123', 'Salimabad', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 7, 1),
(124, '124', 'Lalpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 10, 1),
(125, '125', 'Gosaipur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 10, 1),
(126, '126', 'Rohitpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 5, 1),
(127, '127', 'Basta (Abdullapur)', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 5, 1),
(128, '128', 'Hijoltola', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 5, 1),
(129, '129', 'Galimpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 5, 1),
(130, '130', 'Joypara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 5, 1),
(131, '0', 'Head Office', 'প্রধান কার্যালয়', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 0, 1),
(132, '38-2', 'Munshigonj -2 ', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(133, '76-2', 'Siddirgonj -2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(134, '34-2', 'Modongonj -2 ', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(135, '55-2', 'Nabigonj - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 1, 1),
(136, '32-2', 'Modonpur - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 2, 1),
(137, '1-2', 'Kuti - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 6, 1),
(138, '7-2', 'Salimgonj - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 7, 1),
(139, '16-2', 'Moinamoti - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(140, '54-2', 'Chapapur - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(141, '13-2', 'Bharasar Bazar - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 8, 1),
(142, '3-2', 'Chargas - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 10, 1),
(143, '9-2', 'Maona - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 12, 1),
(144, '63-2', 'Laksham - 2', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 16, 1),
(145, '132', 'Charigram', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 27, 1),
(146, '133', 'Hemayetpur', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 27, 1),
(147, '134', 'Zamrita', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 27, 1),
(148, '135', 'Zamsha', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 27, 1),
(149, '136', 'Shikaripara', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 27, 1),
(150, '131', 'Gopaldi', 'কুটি', '01844006800', 'cdipbd@gmail.com', 'CDIP Bhaban House # 17, Road # 13 Pisciculture Housing Society Shekhertek, Adabor, Dhaka - 1207.', '2001-01-01', 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crime`
--

CREATE TABLE `tbl_crime` (
  `id` int(11) NOT NULL,
  `crime_subject` varchar(100) NOT NULL,
  `crime_detail` text NOT NULL,
  `punishment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_crime`
--

INSERT INTO `tbl_crime` (`id`, `crime_subject`, `crime_detail`, `punishment`, `status`) VALUES
(1, 'Taka curi', 'this is for taka curi', 'bbbbbbbbb', 1),
(2, 'Offioce Faki', 'this is for office faki', 'dddddddd', 1),
(3, 'Oniom', 'gtfrg gg', 'Suspend', 1),
(4, 'ghftgh', 'ttttttttttt', 'hfth', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_degree_level`
--

CREATE TABLE `tbl_degree_level` (
  `id` tinyint(11) NOT NULL,
  `level_id` tinyint(4) NOT NULL,
  `level_name` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_degree_level`
--

INSERT INTO `tbl_degree_level` (`id`, `level_id`, `level_name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(1, 1, '1st', '2017-11-09 10:23:43', NULL, NULL, NULL, 181),
(2, 2, '2nd', '2017-11-09 10:23:43', NULL, NULL, NULL, 181),
(3, 3, '3rd', '2017-11-09 10:23:43', NULL, NULL, NULL, 181),
(4, 4, '4th', '2017-11-09 10:23:43', NULL, NULL, NULL, 181),
(5, 5, '5th', '2017-11-09 10:23:43', NULL, NULL, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_demotion`
--

CREATE TABLE `tbl_demotion` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `br_joined_date` date NOT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` varchar(5) NOT NULL,
  `grade_code` tinyint(4) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `department_code` tinyint(4) NOT NULL,
  `report_to` varchar(10) NOT NULL,
  `next_increment_date` date NOT NULL,
  `demotion_type` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_bangla` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`id`, `department_id`, `department_name`, `department_bangla`, `status`) VALUES
(1, 1, 'HRD', 'হিউম্যান রিসোর্স ডিপার্টমেন্ট', 1),
(2, 2, 'Accounts', 'একাউন্টস বিভাগ', 1),
(3, 3, 'Program (Credit)', 'ক্রেডিট প্রোগ্রাম', 1),
(4, 4, 'Information Technology (IT)', 'ইনফর্মেশন টেকনোলোজি', 1),
(5, 5, 'Education', 'শিক্ষা', 1),
(6, 6, 'Health', 'স্বাস্থ্য', 1),
(7, 7, 'Cultural', 'সংস্কৃতি', 1),
(8, 8, 'MIS', 'এম আই এস', 1),
(9, 9, 'Agricultute', 'কৃষি', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(100) NOT NULL,
  `designation_bangla` varchar(100) NOT NULL,
  `is_reportable` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`id`, `designation_name`, `designation_bangla`, `is_reportable`, `status`) VALUES
(1, 'ED', 'এক্সিকিউটিভ ডিরেক্টর', 1, 1),
(2, 'Director Program', 'পরিচালক প্রোগ্রাম', 1, 1),
(3, 'Deputy Director', 'ডেপুটি ডিরেক্টর', 1, 1),
(4, 'GM', 'জেনারাল ম্যানেজার', 1, 1),
(5, 'DGM', 'ডেপুটি জেনারাল ম্যানেজার', 1, 1),
(6, 'Accounts Officer', 'হিসাব রক্ষক', 0, 1),
(7, 'IT Officer', 'আইটি অফিসার।', 0, 1),
(8, 'Soft. Engneer', 'সফটওয়ার ইঞ্জিনিয়ার', 0, 1),
(9, 'Branch Manager', 'ব্রাঞ্ছ ম্যানেজার', 1, 1),
(10, 'Branch Accountant', 'হিসাব রক্ষক', 1, 1),
(11, 'Field Officer', 'ফিল্ড অফিসার', 0, 1),
(12, 'Area Manager', 'এরিয়া ম্যানেজার', 1, 1),
(13, 'Zonal Manager', 'জোনাল ম্যানেজার', 0, 1),
(14, 'MIS Officer', 'এম আই এস অফিসার', 0, 1),
(15, 'Sr IT Officer', 'সি. আইটি অফিসার', 0, 1),
(16, 'Jr. Field Officer', 'জুনি. ফিল্ড অফিসার', 0, 1),
(17, 'Sr.Area Manager', 'সিনিয়ার এরিয়া ম্যানেজার', 1, 1),
(18, 'AGM (IT)', 'এ.জি.এম(আইটি)', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

CREATE TABLE `tbl_district` (
  `id` int(11) NOT NULL,
  `district_code` tinyint(4) NOT NULL,
  `district_name` varchar(30) NOT NULL,
  `district_bangla` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_district`
--

INSERT INTO `tbl_district` (`id`, `district_code`, `district_name`, `district_bangla`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(4, 1, 'Dhaka', NULL, 1, '2017-11-05 12:40:13', '2017-12-04 07:05:58', NULL, NULL, 181),
(5, 2, 'Sirajgonj', NULL, 1, '2017-11-05 12:40:13', '2017-12-04 09:15:28', NULL, NULL, 181),
(6, 3, 'Bogra', NULL, 1, '2017-11-05 12:40:13', '2017-12-04 08:24:22', NULL, NULL, 181),
(7, 4, 'Kishoregonj', NULL, 1, '2017-11-05 12:40:13', '2017-12-04 09:01:31', NULL, NULL, 181),
(8, 5, 'Joypurhat', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(9, 6, 'Gaibanda', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(10, 7, 'Laxmipur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(11, 8, 'Jamalpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(12, 9, 'Netrakona', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(13, 10, 'Narshingdi', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(14, 11, 'Gazipur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(15, 12, 'Comilla', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(16, 13, 'Dinajpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(17, 14, 'Manikgonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(18, 15, 'Panchgor', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(19, 16, 'Tangail', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(20, 17, 'Nilphamari', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(21, 18, 'Feni', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(22, 19, 'Pabna', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(23, 20, 'Chandpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(24, 21, 'B-Baria', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(25, 22, 'Barishal', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(26, 23, 'Mymensing', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(27, 24, 'Coxbazar', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(28, 25, 'Sunamgonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(29, 26, 'Rangpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(30, 27, 'Rajshahi', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(31, 28, 'Pirojpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(32, 29, 'Kushtia', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(33, 30, 'Sherpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(34, 31, 'Kurigram', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(35, 32, 'Lalmonirhat', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(36, 33, 'Narail', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(37, 34, 'Thakurgao', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(38, 35, 'Jhalokathi', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(39, 36, 'Naoga', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(40, 37, 'Jessore', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(41, 38, 'Gopalgonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(42, 39, 'Jhinadaha', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(43, 40, 'Munshigonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(44, 41, 'Hobigonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(45, 42, 'Narayongonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(46, 43, 'Bagerhat', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(47, 44, 'Patuakhali', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(48, 45, 'Nator', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(49, 46, 'Barguna', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(50, 47, 'Sathkhira', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(51, 48, 'Bhola', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(52, 49, 'Madaripur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(53, 50, 'Noakhali', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(54, 51, 'Razbari', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(55, 52, 'Chittagong', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(56, 53, 'Shariatpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(57, 54, 'Chapainobabgonj', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(58, 55, 'Khulna', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(59, 56, 'Sylhet', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(60, 57, 'Mowlovibazar', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(61, 58, 'Faridpur', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(62, 59, 'Magura', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(63, 60, 'Chuadanga', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(64, 61, 'Khagrasori', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(65, 62, 'Phanchagarh', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(66, 63, 'Rangamati', NULL, 1, '2017-11-05 12:40:13', NULL, NULL, NULL, 181),
(67, 64, 'AAaa', NULL, 1, '2017-11-11 09:56:39', '2017-11-12 06:11:59', NULL, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_edms_category`
--

CREATE TABLE `tbl_edms_category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_edms_category`
--

INSERT INTO `tbl_edms_category` (`category_id`, `category_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Probition', 1, '2017-11-26 00:00:00', NULL),
(2, 'Increment', 1, '2017-11-26 00:00:00', NULL),
(3, 'Permanent', 1, '2017-11-26 15:06:19', NULL),
(4, 'Permanent Application', 1, '2017-11-27 09:51:22', NULL),
(5, 'Appointment letter', 1, '2018-02-24 14:38:48', NULL),
(6, 'join letter', 1, '2018-02-24 15:06:08', NULL),
(7, 'Money receipt', 1, '2018-02-24 15:10:47', NULL),
(8, 'Parents agreement', 1, '2018-02-24 15:23:56', NULL),
(9, 'Transfer', 1, '2018-02-24 15:33:48', NULL),
(10, 'Note sheet', 1, '2018-02-24 15:55:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_edms_document`
--

CREATE TABLE `tbl_edms_document` (
  `document_id` int(10) UNSIGNED NOT NULL,
  `subcat_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `document_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effect_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_edms_subcategory`
--

CREATE TABLE `tbl_edms_subcategory` (
  `subcat_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_edms_subcategory`
--

INSERT INTO `tbl_edms_subcategory` (`subcat_id`, `category_id`, `subcategory_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Education', 1, NULL, NULL),
(2, 4, 'Training', 1, NULL, NULL),
(3, 4, 'Experience', 1, NULL, NULL),
(4, 4, 'Refference', 1, NULL, NULL),
(5, 4, 'Photo', 1, NULL, NULL),
(6, 4, 'Others paper', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_basic_info`
--

CREATE TABLE `tbl_emp_basic_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `emp_thumb_id` int(11) DEFAULT NULL,
  `emp_name_eng` varchar(50) NOT NULL,
  `emp_name_ban` varchar(50) DEFAULT NULL,
  `father_name` varchar(50) NOT NULL,
  `mother_name` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `country_id` smallint(6) NOT NULL,
  `contact_num` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `national_id` varchar(30) NOT NULL,
  `maritial_status` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `present_add` varchar(150) NOT NULL,
  `vill_road` varchar(50) NOT NULL,
  `post_office` varchar(50) NOT NULL,
  `district_code` smallint(6) NOT NULL,
  `thana_code` smallint(6) NOT NULL,
  `permanent_add` varchar(150) NOT NULL,
  `org_join_date` date NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_emp_basic_info`
--

INSERT INTO `tbl_emp_basic_info` (`id`, `emp_id`, `emp_thumb_id`, `emp_name_eng`, `emp_name_ban`, `father_name`, `mother_name`, `birth_date`, `nationality`, `religion`, `country_id`, `contact_num`, `email`, `national_id`, `maritial_status`, `gender`, `blood_group`, `present_add`, `vill_road`, `post_office`, `district_code`, `thana_code`, `permanent_add`, `org_join_date`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(1, 3305, NULL, 'Dipankar Roy', 'দীপঙ্কর রয়', 'Sonot Kumar Roy', 'GRTDG', '2018-05-10', 'GVTRDG', 'Hinduism', 1, '01729070195', 'dipankar@gmail.com', '5875', 'Married', 'Male', 'B+', 'JHYGJH', 'Borodia', 'Kalia', 33, 235, 'Vill: Borodia, Post: Kalia, Thana: Narail, Dist: Narail', '2017-05-10', NULL, '2018-05-10 12:09:09', NULL, 1, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_education`
--

CREATE TABLE `tbl_emp_education` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `exam_name` int(11) NOT NULL,
  `exam_subject` int(11) NOT NULL,
  `board_uni` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `gpa` varchar(10) DEFAULT NULL,
  `pass_year` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_edu_info`
--

CREATE TABLE `tbl_emp_edu_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `exam_code` smallint(6) NOT NULL,
  `subject_code` smallint(6) NOT NULL,
  `result` varchar(10) NOT NULL,
  `pass_year` smallint(6) NOT NULL,
  `school_code` smallint(6) NOT NULL,
  `level_id` tinyint(4) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_exp_info`
--

CREATE TABLE `tbl_emp_exp_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `experience_period` varchar(50) NOT NULL,
  `organization_name` varchar(80) NOT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_general_info`
--

CREATE TABLE `tbl_emp_general_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `fathers_name` varchar(30) NOT NULL,
  `monthers_name` varchar(30) NOT NULL,
  `date_of_birth` date NOT NULL,
  `religion` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `marrital_status` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `nid_no` varchar(50) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `joining_date` date NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `village` varchar(30) NOT NULL,
  `post_office` varchar(30) NOT NULL,
  `police_station` tinyint(4) NOT NULL,
  `district` tinyint(4) NOT NULL,
  `present_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_neces_phone`
--

CREATE TABLE `tbl_emp_neces_phone` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `relation` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_other`
--

CREATE TABLE `tbl_emp_other` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `op_subject` varchar(50) NOT NULL,
  `op_details` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_photo`
--

CREATE TABLE `tbl_emp_photo` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `emp_photo` varchar(50) NOT NULL,
  `org_code` smallint(6) DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_ref_info`
--

CREATE TABLE `tbl_emp_ref_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `rf_name` varchar(50) NOT NULL,
  `rf_occupation` varchar(50) NOT NULL,
  `rf_address` varchar(100) NOT NULL,
  `rf_mobile` varchar(20) NOT NULL,
  `rf_email` varchar(50) DEFAULT NULL,
  `rf_national_id` varchar(30) DEFAULT NULL,
  `rf_remarks` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_salary`
--

CREATE TABLE `tbl_emp_salary` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `effect_date` date NOT NULL,
  `transection` tinyint(4) NOT NULL,
  `plus_item_id` varchar(250) NOT NULL,
  `plus_item` varchar(250) NOT NULL,
  `minus_item_id` varchar(250) NOT NULL,
  `minus_item` varchar(250) NOT NULL,
  `salary_basic` int(11) NOT NULL,
  `total_plus` varchar(30) NOT NULL,
  `payable` varchar(30) NOT NULL,
  `total_minus` varchar(30) NOT NULL,
  `net_payable` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_emp_salary`
--

INSERT INTO `tbl_emp_salary` (`id`, `emp_id`, `effect_date`, `transection`, `plus_item_id`, `plus_item`, `minus_item_id`, `minus_item`, `salary_basic`, `total_plus`, `payable`, `total_minus`, `net_payable`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(1, 3305, '2018-05-10', 1, '2,4,7', '0,0,0', '3,5,6', '0,0,0', 40000, '0', '40000', '0', '40000', '2018-05-10 06:14:19', '2018-05-10 06:14:19', 1, 1, 181),
(2, 3305, '2017-11-14', 2, '2,3,6', '12863,3859,2573', '2,4,7', '2573,1286,643', 25725, '19295', '45020', '4502', '40518', '2018-05-10 06:20:53', '2018-05-10 06:20:53', 1, 1, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_training`
--

CREATE TABLE `tbl_emp_training` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `br_code` smallint(6) NOT NULL,
  `designation_code` smallint(6) NOT NULL,
  `tr_date_from` date NOT NULL,
  `tr_date_to` date NOT NULL,
  `tr_venue` varchar(50) NOT NULL,
  `tr_venue_other` varchar(50) DEFAULT NULL,
  `tr_result` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_training_detail`
--

CREATE TABLE `tbl_emp_training_detail` (
  `id` int(11) NOT NULL,
  `training_no` int(11) NOT NULL,
  `training_name` varchar(50) NOT NULL,
  `institute_name` varchar(50) NOT NULL,
  `tr_date_from` date NOT NULL,
  `tr_date_to` date NOT NULL,
  `tr_venue` varchar(50) NOT NULL,
  `tr_venue_other` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) NOT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_training_result`
--

CREATE TABLE `tbl_emp_training_result` (
  `id` int(11) NOT NULL,
  `training_detail_id` int(11) NOT NULL COMMENT 'primary_key to tbl_emp_training_detail',
  `training_no` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `br_code` varchar(10) NOT NULL,
  `designation_code` smallint(6) NOT NULL,
  `tr_result` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_train_info`
--

CREATE TABLE `tbl_emp_train_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `train_name` varchar(70) NOT NULL,
  `train_period` date NOT NULL,
  `train_period_to` date DEFAULT NULL,
  `institute` varchar(100) NOT NULL,
  `palace` varchar(50) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_name`
--

CREATE TABLE `tbl_exam_name` (
  `exam_code` smallint(6) NOT NULL,
  `exam_name` varchar(30) NOT NULL,
  `level_id` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_exam_name`
--

INSERT INTO `tbl_exam_name` (`exam_code`, `exam_name`, `level_id`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(2, 'HSC', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(3, 'BA', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(4, 'B.Com', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(5, 'BSS', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(6, 'BSc', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(7, 'BBA', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(8, 'CSE', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(9, 'MA', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(10, 'M.Com', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(11, 'MS', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(12, 'MBA', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(13, 'Diploma Eng.', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(14, 'Computer Course', 5, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(15, 'LLB (Honours)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(16, 'LLM', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(17, 'SSC', 1, 1, '2017-11-09 10:28:47', '2017-12-04 09:21:29', NULL, NULL, 181),
(18, 'B.Sc(Hon)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(19, 'M.Sc', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(20, 'Alim', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(21, 'Class-8', 1, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(22, 'BSS(hon)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(23, 'BA(Hon)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(24, 'Dakhil', 1, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(25, 'Kamil', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(26, 'MSS', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(27, 'Fazil', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(28, 'HSC(Voc)', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(29, 'B.Com(Hon)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(30, 'B.ED', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(31, 'Fazil (Special)', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(32, 'Fadil', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(33, 'SSC (VOC)', 1, 1, '2017-11-09 10:28:47', '2017-12-04 06:53:27', NULL, NULL, 181),
(34, 'Class-9', 1, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(35, 'Diploma', 2, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(36, 'BBS', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(37, 'Class-10', 1, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(38, 'MBS', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(39, 'BAE(Agriculture)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(40, 'BBS(Hon)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(41, 'Jr.SC', 1, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(42, 'MDS', 4, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(43, 'Fazil B.A. (Special)', 3, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(44, 'Fazil(BA)', 0, 1, '2017-11-09 10:28:47', NULL, NULL, NULL, 181),
(45, 'aa', 1, 1, '2017-11-13 06:53:26', '2017-11-13 08:08:31', NULL, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_experience_info`
--

CREATE TABLE `tbl_experience_info` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `join_date` date NOT NULL,
  `leave_date` date NOT NULL,
  `organization_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_financial_year`
--

CREATE TABLE `tbl_financial_year` (
  `id` int(10) UNSIGNED NOT NULL,
  `f_year_from` date NOT NULL,
  `f_year_to` date NOT NULL,
  `user_code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_financial_year`
--

INSERT INTO `tbl_financial_year` (`id`, `f_year_from`, `f_year_to`, `user_code`, `created_at`, `updated_at`) VALUES
(1, '2017-07-01', '2018-06-30', 1, '2017-11-08 18:00:00', NULL),
(2, '2018-07-01', '2019-06-30', 1, '2017-11-08 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_grade`
--

CREATE TABLE `tbl_grade` (
  `id` int(11) NOT NULL,
  `grade_name` varchar(100) NOT NULL,
  `scale_id` int(11) NOT NULL,
  `start_from` date DEFAULT NULL,
  `end_to` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_grade`
--

INSERT INTO `tbl_grade` (`id`, `grade_name`, `scale_id`, `start_from`, `end_to`, `status`) VALUES
(1, 'Grade - 1', 1, '2007-02-01', '2008-06-30', 1),
(2, 'Grade - 2', 2, '2007-02-01', '2008-06-30', 1),
(3, 'Grade - 3', 3, '2007-02-01', '2008-06-30', 1),
(4, 'Grade - 4', 4, '2007-02-01', '2008-06-30', 1),
(5, 'Grade - 5', 5, '2007-02-01', '2008-06-30', 1),
(6, 'Grade -  6', 6, '2007-02-01', '2008-06-30', 1),
(7, 'Grade - 7', 7, '2007-02-01', '2008-06-30', 1),
(8, 'Grade - 8', 8, '2007-02-01', '2008-06-30', 1),
(9, 'Grade - 9', 9, '2007-02-01', '2008-06-30', 1),
(10, 'Grade 10', 10, '2007-02-01', '2008-06-30', 1),
(11, 'Grade 11', 11, '2007-02-01', '2008-06-30', 1),
(12, 'Grade 12', 12, '2007-02-01', '2008-06-30', 1),
(13, 'Grade 13', 13, '2007-02-01', '2008-06-30', 1),
(14, 'Grade 14', 14, '2007-02-01', '2008-06-30', 1),
(15, 'Grade 15', 15, '2007-02-01', '2008-06-30', 1),
(16, 'Grade 16', 16, '2007-02-01', '2008-06-30', 1),
(17, 'Grade - 1', 17, '2008-07-01', '2010-06-30', 1),
(18, 'Grade - 2', 18, '2008-07-01', '2010-06-30', 1),
(19, 'Grade - 3', 19, '2008-07-01', '2010-06-30', 1),
(20, 'Grade - 4', 20, '2008-07-01', '2010-06-30', 1),
(21, 'Grade - 5', 21, '2008-07-01', '2010-06-30', 1),
(22, 'Grade - 6', 22, '2008-07-01', '2010-06-30', 1),
(23, 'Grade - 7', 23, '2008-07-01', '2010-06-30', 1),
(24, 'Grade - 8', 24, '2008-07-01', '2010-06-30', 1),
(25, 'Grade - 9', 25, '2008-07-01', '2010-06-30', 1),
(26, 'Grade - 10', 26, '2008-07-01', '2010-06-30', 1),
(27, 'Grade - 11', 27, '2008-07-01', '2010-06-30', 1),
(28, 'Grade - 12', 28, '2008-07-01', '2010-06-30', 1),
(29, 'Grade - 13', 29, '2008-07-01', '2010-06-30', 1),
(30, 'Grade - 14', 30, '2008-07-01', '2010-06-30', 1),
(31, 'Grade - 15', 31, '2008-07-01', '2010-06-30', 1),
(32, 'Grade - 16', 32, '2008-07-01', '2010-06-30', 1),
(33, 'Grade - 17', 33, '2008-07-01', '2010-06-30', 1),
(34, 'Grade - 18', 34, '2008-07-01', '2010-06-30', 1),
(35, 'Grade 1', 35, '2010-07-01', '2014-06-30', 1),
(36, 'Grade 2 ', 36, '2010-07-01', '2014-06-30', 1),
(37, 'Grade 2', 37, '2010-07-01', '2014-06-30', 1),
(38, 'Grade 4', 38, '2010-07-01', '2014-06-30', 1),
(39, 'Grade 5', 39, '2010-07-01', '2014-06-30', 1),
(40, 'Grade 6', 40, '2010-07-01', '2014-06-30', 1),
(41, 'Grade 7', 41, '2010-07-01', '2014-06-30', 1),
(42, 'Grade 8', 42, '2010-07-01', '2014-06-30', 1),
(43, 'Grade 9', 43, '2010-07-01', '2014-06-30', 1),
(44, 'Grade 10', 44, '2010-07-01', '2014-06-30', 1),
(45, 'Grade 11', 45, '2010-07-01', '2014-06-30', 1),
(46, 'Grade 12', 46, '2010-07-01', '2014-06-30', 1),
(47, 'Grade 13', 47, '2010-07-01', '2014-06-30', 1),
(48, 'Grade 14', 48, '2010-07-01', '2014-06-30', 1),
(49, 'Grade 15', 49, '2010-07-01', '2014-06-30', 1),
(50, 'Grade 16', 50, '2010-07-01', '2014-06-30', 1),
(51, 'Grade 17', 51, '2010-07-01', '2014-06-30', 1),
(52, 'Grade 18', 52, '2010-07-01', '2014-06-30', 1),
(53, 'No-1', 53, '2010-07-01', '2014-06-30', 1),
(54, 'No-2', 54, '2010-07-01', '2014-06-30', 1),
(55, 'No-3', 55, '2010-07-01', '2014-06-30', 1),
(56, 'No-4', 56, '2010-07-01', '2014-06-30', 1),
(57, 'Grade 1', 57, '2014-07-01', '2016-03-11', 1),
(58, 'Grade 2', 58, '2014-07-01', '2016-03-11', 1),
(59, 'Grade 3', 59, '2014-07-01', '2016-03-11', 1),
(60, 'Grade 4', 60, '2014-07-01', '2016-03-11', 1),
(61, 'Grade 5', 61, '2014-07-01', '2016-03-11', 1),
(62, 'Grade 6', 62, '2014-07-01', '2016-03-11', 1),
(63, 'Grade 7', 63, '2014-07-01', '2016-03-11', 1),
(64, 'Grade 8', 64, '2014-07-01', '2016-03-11', 1),
(65, 'Grade 9', 65, '2014-07-01', '2016-03-11', 1),
(66, 'Grade 10', 66, '2014-07-01', '2016-03-11', 1),
(67, 'Grade 11', 67, '2014-07-01', '2016-03-11', 1),
(68, 'Grade 12', 68, '2014-07-01', '2016-03-11', 1),
(69, 'Grade 13', 69, '2014-07-01', '2016-03-11', 1),
(70, 'Grade 14', 70, '2014-07-01', '2016-03-11', 1),
(71, 'Grade 15', 71, '2014-07-01', '2016-03-11', 1),
(72, 'Grade 16', 72, '2014-07-01', '2016-03-11', 1),
(73, 'Grade 17', 73, '2014-07-01', '2016-03-11', 1),
(74, 'Grade 1', 74, '2016-03-11', '2018-06-30', 1),
(75, 'Grade 2', 75, '2016-03-11', '2018-06-30', 1),
(76, 'Grade 3', 76, '2016-03-11', '2018-06-30', 1),
(77, 'Grade 4', 77, '2016-03-11', '2018-06-30', 1),
(78, 'Grade 5', 78, '2016-03-11', '2018-06-30', 1),
(79, 'Grade 6', 79, '2016-03-11', '2018-06-30', 1),
(80, 'Grade 7', 80, '2016-03-11', '2018-06-30', 1),
(81, 'Grade 8', 81, '2016-03-11', '2018-06-30', 1),
(82, 'Grade 9', 82, '2016-03-11', '2018-06-30', 1),
(83, 'Grade 10', 83, '2016-03-11', '2018-06-30', 1),
(84, 'Grade 11', 84, '2016-03-11', '2018-06-30', 1),
(85, 'Grade 12', 85, '2016-03-11', '2018-06-30', 1),
(86, 'Grade 13', 86, '2016-03-11', '2018-06-30', 1),
(87, 'Grade 14', 87, '2016-03-11', '2018-06-30', 1),
(88, 'Grade 15', 88, '2016-03-11', '2018-06-30', 1),
(89, 'Grade 16', 89, '2016-03-11', '2018-06-30', 1),
(90, 'Grade 17', 90, '2016-03-11', '2018-06-30', 1),
(91, 'Grade 18', 91, '2016-03-11', '2018-06-30', 1),
(92, 'Grade 19', 92, '2016-03-11', '2018-06-30', 1),
(93, 'NG 1', 93, '2016-03-11', '2018-06-30', 1),
(94, 'NG 2', 94, '2016-03-11', '2018-06-30', 1),
(95, 'NG 3', 95, '2016-03-11', '2018-06-30', 1),
(96, 'NG 4', 96, '2016-03-11', '2018-06-30', 1),
(97, 'Others 1 ', 97, '2016-03-11', '2018-06-30', 2),
(98, 'Others 2', 98, '2016-03-11', '2018-06-30', 2),
(99, 'Others 3', 99, '2016-03-11', '2018-06-30', 2),
(100, 'Others 4', 100, '2016-03-11', '2018-06-30', 2),
(101, 'Others 5', 101, '2016-03-11', '2018-06-30', 2),
(102, 'Others 6', 102, '2016-03-11', '2018-06-30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_subject`
--

CREATE TABLE `tbl_group_subject` (
  `id` int(11) NOT NULL,
  `subject_code` smallint(6) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_group_subject`
--

INSERT INTO `tbl_group_subject` (`id`, `subject_code`, `subject_name`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(2, 2, 'Science', 1, '2017-11-09 10:19:33', '2017-12-04 09:18:24', NULL, NULL, 181),
(3, 3, 'Arts', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(4, 4, 'Commerce', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(5, 5, 'Accounting', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(6, 6, 'Management', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(7, 7, 'Bengali', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(8, 8, 'English', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(9, 9, 'Islamic History', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(10, 10, 'Social Science', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(11, 11, 'Physics', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(12, 12, 'Chemistry', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(13, 13, 'Biology', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(14, 14, 'Botany', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(15, 15, 'History', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(16, 16, 'Arabic', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(17, 17, 'Computer Science', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(18, 19, 'Computer Diploma', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(19, 22, 'Law', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(20, 23, 'General', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(21, 27, 'HRM', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(22, 28, 'Statistics', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(23, 29, 'Finance', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(24, 30, 'Agriculture', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(25, 31, 'General Science', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(26, 32, 'Economics', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(27, 33, 'Computer Opr', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(28, 34, 'Electrical', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(29, 35, 'Commerce(Diploma)', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(30, 36, 'Political Science', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(31, 37, 'Hadis', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(32, 38, 'Anthropology', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(33, 39, 'Ent Development', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(34, 40, 'Diploma in Business', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(35, 41, 'Sociology', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(36, 42, 'Sec.Science', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(37, 43, 'Zoology', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(38, 44, 'Social Welfare', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(39, 45, 'Genaral Mach', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(40, 46, 'Food Process', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(41, 47, 'Compatmental', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(42, 48, 'Hadith', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(43, 49, 'Fazil BA (Special)', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(44, 50, 'Library & IT', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(45, 51, 'Audio Video System', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(46, 52, 'Building Maintenance', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(47, 53, 'Business Management', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(48, 54, 'Farm Machinery', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(49, 55, 'Islamic Studies', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(50, 56, 'Philosophy', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(51, 57, 'Agro Food', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(52, 58, 'Computer & IT', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(53, 59, 'Automotive', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(54, 60, 'Automobile', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(55, 61, 'Desvelopment studies', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(56, 62, 'Tailaring', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(57, 63, 'Mechanical', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(58, 64, 'Marketing', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(59, 65, 'Geography & Environment', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(60, 66, 'Psychology', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(61, 67, 'Power Tech', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(62, 68, 'Mathematics', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(63, 69, 'Civil Constructio', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(64, 70, 'Social Work', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(65, 71, 'Others', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(66, 72, 'Computer Tec.', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(67, 73, 'Electrical and Elec Eng.', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(68, 74, 'N/A', 1, '2017-11-09 10:19:33', NULL, NULL, NULL, 181),
(69, 75, 'aa', 1, '2017-11-13 06:31:27', '2017-11-13 06:31:44', NULL, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_heldup`
--

CREATE TABLE `tbl_heldup` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `br_code` varchar(10) NOT NULL,
  `designation_code` smallint(6) NOT NULL,
  `what_heldup` varchar(50) NOT NULL,
  `heldup_time` varchar(20) NOT NULL,
  `heldup_until_date` date NOT NULL,
  `heldup_cause` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_increment`
--

CREATE TABLE `tbl_increment` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `br_joined_date` date NOT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` varchar(5) NOT NULL,
  `grade_code` tinyint(4) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `department_code` tinyint(4) NOT NULL,
  `report_to` varchar(4) NOT NULL,
  `next_increment_date` date NOT NULL,
  `increment_type` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_increment_letter`
--

CREATE TABLE `tbl_increment_letter` (
  `id` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `increment_date` date NOT NULL,
  `next_increment_date` date DEFAULT NULL,
  `grade_code` int(11) NOT NULL,
  `old_basic` int(11) NOT NULL,
  `branch_type` tinyint(4) NOT NULL,
  `letter_heading` text NOT NULL,
  `letter_body_1` text NOT NULL,
  `letter_body_2` text NOT NULL,
  `letter_body_3` text NOT NULL,
  `incre_letter_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_increment_letter_body`
--

CREATE TABLE `tbl_increment_letter_body` (
  `id` int(11) NOT NULL,
  `letter_heading` text NOT NULL,
  `letter_body_1` text,
  `letter_body_2` text,
  `letter_body_3` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_increment_letter_emp`
--

CREATE TABLE `tbl_increment_letter_emp` (
  `id` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `increment_date` date NOT NULL,
  `next_increment_date` date DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `designation_code` int(11) NOT NULL,
  `br_code` int(11) NOT NULL,
  `grade_code` int(11) NOT NULL,
  `old_basic` int(11) NOT NULL,
  `new_basic` int(11) NOT NULL,
  `plus_item_id` varchar(100) NOT NULL,
  `plus_item` varchar(100) NOT NULL,
  `minus_item_id` varchar(100) NOT NULL,
  `minus_item` varchar(100) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `total_minus` int(11) NOT NULL,
  `net_pay` int(11) NOT NULL,
  `branch_type` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_balance`
--

CREATE TABLE `tbl_leave_balance` (
  `id` int(10) UNSIGNED NOT NULL,
  `emp_id` int(11) NOT NULL,
  `branch_code` int(11) NOT NULL,
  `f_year_id` tinyint(4) NOT NULL,
  `cum_balance` tinyint(4) NOT NULL,
  `current_open_balance` tinyint(4) NOT NULL,
  `no_of_days` tinyint(4) NOT NULL,
  `cum_close_balance` tinyint(4) NOT NULL,
  `current_close_balance` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_update_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_leave_balance`
--

INSERT INTO `tbl_leave_balance` (`id`, `emp_id`, `branch_code`, `f_year_id`, `cum_balance`, `current_open_balance`, `no_of_days`, `cum_close_balance`, `current_close_balance`, `status`, `last_update_date`, `created_at`, `updated_at`) VALUES
(1, 3305, 0, 1, 0, 18, 0, 0, 18, 1, '2018-05-10', '2018-05-10 05:56:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_history`
--

CREATE TABLE `tbl_leave_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `emp_id` int(11) NOT NULL,
  `f_year_id` tinyint(4) NOT NULL,
  `designation_code` int(11) NOT NULL,
  `branch_code` tinyint(4) NOT NULL,
  `type_id` int(11) NOT NULL,
  `is_pay` tinyint(4) DEFAULT NULL,
  `application_date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `leave_remain` tinyint(4) NOT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `approved_id` int(11) DEFAULT NULL,
  `sup_status` tinyint(4) DEFAULT '0',
  `appr_status` tinyint(4) DEFAULT '0' COMMENT '1=approved,2=rejected',
  `appr_from_date` date DEFAULT NULL,
  `appr_to_date` date DEFAULT NULL,
  `sup_recom_date` date DEFAULT NULL,
  `appr_appr_date` date DEFAULT NULL,
  `no_of_days_appr` int(11) DEFAULT NULL,
  `tot_earn_leave` int(11) DEFAULT NULL,
  `leave_adjust` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_type`
--

CREATE TABLE `tbl_leave_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_days` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `sta_tus` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_leave_type`
--

INSERT INTO `tbl_leave_type` (`id`, `type_name`, `no_of_days`, `created_by`, `updated_by`, `sta_tus`, `org_code`, `created_at`, `updated_at`) VALUES
(1, 'Casual', 18, 1, 1, 1, 181, '2017-11-08 18:00:00', NULL),
(2, 'Meternity', 36, 1, 1, 1, 181, '2017-11-09 04:03:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_tran`
--

CREATE TABLE `tbl_master_tran` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `transection_type` tinyint(4) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `br_joined_date` date DEFAULT NULL,
  `next_increment_date` date DEFAULT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` varchar(10) NOT NULL,
  `grade_code` tinyint(5) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `basic_salary` int(11) NOT NULL,
  `department_code` tinyint(4) NOT NULL,
  `report_to` varchar(4) NOT NULL,
  `is_permanent` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1 is for Probation, 2 = permanent,3=masterrole',
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_master_tran`
--

INSERT INTO `tbl_master_tran` (`id`, `emp_id`, `sarok_no`, `transection_type`, `letter_date`, `effect_date`, `br_joined_date`, `next_increment_date`, `designation_code`, `br_code`, `grade_code`, `grade_step`, `basic_salary`, `department_code`, `report_to`, `is_permanent`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(1, 3305, 1, 1, '2017-05-02', '2017-05-10', '2017-05-10', NULL, 17, '0', 83, 0, 40000, 3, '1', 1, 1, '2018-05-10 05:56:27', '2018-05-10 05:56:27', 1, 1, 181),
(2, 3305, 2, 2, '2017-11-14', '2017-11-14', '2017-05-10', '2018-07-01', 17, '115', 83, 5, 25725, 3, '1', 2, 1, '2018-05-10 06:15:56', '2018-05-10 06:15:56', 1, 1, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movement_register`
--

CREATE TABLE `tbl_movement_register` (
  `move_id` int(10) UNSIGNED NOT NULL,
  `emp_id` int(11) NOT NULL,
  `area_code` int(11) DEFAULT NULL,
  `branch_code` int(11) DEFAULT NULL,
  `destination` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_date` date NOT NULL,
  `leave_time` time NOT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `comments` varchar(90) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_navbar`
--

CREATE TABLE `tbl_navbar` (
  `nav_id` int(11) NOT NULL,
  `nav_group_id` tinyint(4) NOT NULL,
  `nav_name` varchar(50) NOT NULL,
  `user_access` varchar(100) NOT NULL,
  `nav_action` varchar(200) NOT NULL,
  `nav_order` smallint(6) NOT NULL DEFAULT '1',
  `nav_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_navbar`
--

INSERT INTO `tbl_navbar` (`nav_id`, `nav_group_id`, `nav_name`, `user_access`, `nav_action`, `nav_order`, `nav_status`) VALUES
(1, 1, 'Dashboard', '1,2,3,4', '/dashboard', 0, 1),
(2, 6, 'Manage Menu Group', '1', '/manage-menu-group', 0, 1),
(3, 6, 'Manage Menu', '1', '/manage-menu', 0, 1),
(4, 2, 'Appointment', '1,2,3', '/employee-appointment', 1, 1),
(5, 2, 'Probation', '1,2,3', '/probation', 3, 1),
(6, 3, 'Branch', '1', '/manage-branch', 0, 1),
(7, 3, 'Area', '1', '/manage-area', 0, 1),
(8, 3, 'Zone', '1', '/manage-zone', 0, 1),
(9, 6, 'User Manager', '1', '/manage-user', 0, 1),
(10, 2, 'Permanent', '1,2,3', '/permanent', 4, 1),
(11, 2, 'Increment', '1,2,3', '/increment', 5, 1),
(12, 2, 'Promotion', '1,2,3', '/promotion', 7, 1),
(13, 2, 'Transfer', '1,2,3', '/transfer', 8, 1),
(14, 2, 'Punishment', '1,2,3', '/punishment', 9, 1),
(15, 2, 'Fine', '1', '/fine', 10, 0),
(16, 2, 'Explanation', '1', '/explanation', 11, 0),
(17, 2, 'Held up', '1,2,3', '/heldup', 12, 1),
(18, 2, 'Resignation', '1,2,3', '/resignation', 13, 1),
(19, 2, 'Training', '1,2,3', '/training', 14, 1),
(20, 2, 'Terms and Condition', '1', '/terms-condition', 15, 0),
(21, 2, 'Others Letter', '1', '/emp-others', 15, 0),
(22, 2, 'View Records', '1,2,3', '/view-records', 16, 1),
(23, 6, 'Manage User Role', '1', '/user-role', 0, 1),
(24, 6, 'Role wise Permission', '1', '/role-permission', 0, 0),
(25, 6, 'Org. Manager', '1', '/org-manager', 0, 1),
(26, 3, 'Grade', '1', '/config-grade', 0, 1),
(27, 3, 'Designation', '1', '/config-designation', 0, 1),
(28, 3, 'Department', '1', '/config-department', 0, 1),
(29, 3, 'Scale', '1', '/config-scale', 0, 1),
(30, 2, 'Employee (CV)', '1,2,3', '/emp-cv', 2, 1),
(31, 2, 'Appointment Letter', '1,2,3', '/appointment-letter', 2, 1),
(32, 3, 'Salary (+)', '1,3,4', '/salary-plus', 1, 1),
(33, 3, 'Salary (-)', '1,3,4', '/salary-minus', 1, 1),
(34, 4, 'Staff Salary', '1,2,3,4', '/staff-salary', 1, 1),
(35, 2, 'Increment Generate', '1,2,3', '/increment-generate', 6, 1),
(36, 3, 'Offence', '1,2,3', '/settings-offense', 1, 1),
(37, 3, 'Punishment Type', '1,2', '/punishment-type', 1, 1),
(38, 7, 'Application', '12', '/emp-leave', 1, 1),
(39, 7, 'Recommend', '12', '/recommend-leave', 1, 1),
(40, 7, 'Approved', '12', '/approved-leave', 1, 1),
(41, 7, 'Year Closing', '12', '/year-close', 1, 1),
(42, 8, 'Add Document', '1,2,3', '/edms-document', 1, 1),
(43, 8, 'View Document', '1,2,3', '/document-view1', 1, 1),
(44, 7, 'Add Movement', '12', '/movement', 1, 1),
(45, 9, 'Approved Movement', '1,2,3', '/movement_approved', 1, 1),
(46, 9, 'Manage Office Order', '1,2,3', '/office_order', 1, 1),
(47, 4, 'Staff Security', '1,2,3,4', '/staff-security', 1, 1),
(48, 3, 'District', '1,2,3', '/district', 1, 1),
(49, 3, 'Thana', '1,2,3', '/thana', 1, 1),
(50, 3, 'Board / University', '1,2,3', '/board-university', 1, 1),
(51, 3, 'Group Subject', '1,2,3', '/group-subject', 1, 1),
(52, 3, 'Exam', '1,2,3', '/exam', 1, 1),
(53, 2, 'Increment Letter', '1,2,3', '/increment-letter', 6, 1),
(54, 3, 'Increment Letter Sample', '1,2,3', '/incre-letter-config/create', 15, 1),
(55, 5, 'Customized Report', '1,2,3', '/customized-report', 1, 1),
(56, 5, 'Transaction Report', '1,2,3', '/transactional-report', 2, 1),
(57, 5, 'Service Length Report', '1,2,3', '/service-length-report', 3, 1),
(58, 5, 'Grade wise Staff', '1,2,3', '/grade-staff-list', 0, 1),
(59, 5, 'Branch Wise Staff', '1,2,3', '/branch-staff-list', 0, 1),
(60, 4, 'Salary Adjustment', '1,2,3,4', '/salary-adjustment', 2, 1),
(61, 3, 'Transfer Causes', '1,2,3,4', '/transfer-remarks', 15, 1),
(62, 2, 'Demotion', '1,2,3', '/demotion', 6, 1),
(63, 5, 'Leave Report', '1,2,3', '/leave_report', 6, 1),
(64, 3, 'Edms Category', '1,2,3', '/edms-category', 20, 1),
(65, 3, 'Edms Subcategory', '1,2,3', '/edms-subcategory', 21, 1),
(66, 10, 'All Staff List', '1,2,3', '/all-staff-list', 0, 1),
(67, 10, 'Branch Staff List', '1,2,3', '/branch-staff-list', 0, 1),
(68, 10, 'Area Staff List', '1,2,3', '/area-staff-list', 0, 1),
(69, 10, 'Staff Type List', '1,2,3', '/staff-type-list', 0, 1),
(70, 10, 'Dropout Staff List', '1,2,3', '/dropout-staff', 0, 1),
(71, 10, 'Staff Joining Report', '1,2,3', '/staff-joining', 0, 1),
(72, 10, 'Staff Strength Report', '1,2,3', '/staff-strength', 0, 1),
(73, 10, 'Employee Status', '1,2,3', '/employee-status', 0, 1),
(74, 2, 'Final Payment', '1,2,3', '/final-payment', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_navbar_group`
--

CREATE TABLE `tbl_navbar_group` (
  `nav_group_id` int(11) NOT NULL,
  `nav_group_name` varchar(50) NOT NULL,
  `grpup_icon` varchar(100) NOT NULL,
  `is_sub_menu` tinyint(4) NOT NULL,
  `sl_order` tinyint(4) NOT NULL,
  `user_access` varchar(50) NOT NULL DEFAULT '1',
  `nav_group_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_navbar_group`
--

INSERT INTO `tbl_navbar_group` (`nav_group_id`, `nav_group_name`, `grpup_icon`, `is_sub_menu`, `sl_order`, `user_access`, `nav_group_status`) VALUES
(1, 'Dashboard', '<i class=\"fa fa-tachometer\" aria-hidden=\"true\"></i>', 0, 1, '1,2,3', 1),
(2, 'Employee', '<i class=\"fa fa-user\" aria-hidden=\"true\"></i>', 1, 2, '1,3', 1),
(3, 'Settings', '<i class=\"fa fa-cogs\" aria-hidden=\"true\"></i>', 1, 4, '1,3', 1),
(4, 'Pay Roll', '<i class=\"fa fa-money\"></i>', 1, 3, '1,2,3', 1),
(5, 'Reports', '<i class=\"fa fa-file\"></i>', 1, 5, '1', 1),
(6, 'Config', '<i class=\"fa fa-cog\"></i>', 1, 6, '1', 1),
(7, 'Employee Leave', '<i class=\"fa fa-automobile\"></i>', 1, 5, '12', 1),
(8, 'Document', '<i class=\"fa fa-book\"></i>', 1, 6, '1,2,3', 1),
(9, 'Others', '<i class=\"fa fa-bug\"></i>', 1, 7, '1,2,3', 1),
(10, 'Basic Reports', '<i class=\"fa fa-dashboard\"></i>', 1, 8, '1,2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_necessary_phone_no`
--

CREATE TABLE `tbl_necessary_phone_no` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `relation` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `national_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offfice_order`
--

CREATE TABLE `tbl_offfice_order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `title` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ogranization`
--

CREATE TABLE `tbl_ogranization` (
  `org_id` int(11) NOT NULL,
  `org_full_name` varchar(50) NOT NULL,
  `org_short_name` varchar(30) NOT NULL,
  `org_code` int(11) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `org_logo` varchar(50) NOT NULL,
  `favicon` varchar(50) NOT NULL DEFAULT 'favicon_default.png',
  `org_address` text NOT NULL,
  `org_contact` varchar(11) NOT NULL,
  `org_email` varchar(100) NOT NULL,
  `org_web_address` varchar(100) NOT NULL,
  `org_start_date` date NOT NULL,
  `org_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_ogranization`
--

INSERT INTO `tbl_ogranization` (`org_id`, `org_full_name`, `org_short_name`, `org_code`, `reg_no`, `org_logo`, `favicon`, `org_address`, `org_contact`, `org_email`, `org_web_address`, `org_start_date`, `org_status`) VALUES
(1, 'Center for Development Innovation and Practices', 'CDIP', 181, 'aaaaaa', 'cdip.png', 'favicon.png', 'CDIP Bhaban\r\nHouse # 17, Road # 13\r\nPisciculture Housing Society\r\nShekhertek, Adabor, Dhaka - 1207.', '9141891', 'cdipbd@gmail.com', 'www.cdipbd.org', '1990-10-24', 2),
(2, 'Dragon Fruit', 'Dragon', 5985, '8788', 'lion-715852_960_720.png', 'favicon_default.png', 'Amazone Forest', '989898', 'amazon@gmail.com', 'www.qwer.com', '2017-11-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permanent`
--

CREATE TABLE `tbl_permanent` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `br_joined_date` date NOT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` varchar(5) NOT NULL,
  `grade_code` tinyint(4) NOT NULL,
  `grade_step` tinyint(5) NOT NULL,
  `department_code` tinyint(5) NOT NULL,
  `report_to` varchar(5) NOT NULL,
  `next_increment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_permanent`
--

INSERT INTO `tbl_permanent` (`id`, `emp_id`, `sarok_no`, `letter_date`, `effect_date`, `br_joined_date`, `designation_code`, `br_code`, `grade_code`, `grade_step`, `department_code`, `report_to`, `next_increment_date`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`, `status`) VALUES
(1, 3305, 2, '2017-11-14', '2017-11-14', '2017-05-10', 17, '115', 83, 5, 3, '1', '2018-07-01', '2018-05-10 06:15:56', '2018-05-10 06:15:56', 1, 1, 181, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_probation`
--

CREATE TABLE `tbl_probation` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `br_joined_date` date NOT NULL,
  `designation_code` int(5) NOT NULL,
  `br_code` varchar(10) NOT NULL,
  `grade_code` int(5) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `department_code` tinyint(4) NOT NULL,
  `report_to` varchar(4) NOT NULL,
  `probation_time` varchar(20) NOT NULL,
  `next_permanent_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_probation`
--

INSERT INTO `tbl_probation` (`id`, `emp_id`, `sarok_no`, `letter_date`, `effect_date`, `br_joined_date`, `designation_code`, `br_code`, `grade_code`, `grade_step`, `department_code`, `report_to`, `probation_time`, `next_permanent_date`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`, `status`) VALUES
(1, 3305, 1, '2017-05-02', '2017-05-10', '2017-05-10', 17, '0', 83, 0, 3, '1', '6', '2017-05-10', '2018-05-10 05:56:27', '2018-05-10 05:56:27', 1, 1, 181, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_promotion`
--

CREATE TABLE `tbl_promotion` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `br_joined_date` date NOT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` varchar(5) NOT NULL,
  `grade_code` tinyint(4) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `department_code` int(11) NOT NULL,
  `report_to` varchar(5) NOT NULL,
  `next_increment_date` date NOT NULL,
  `promotion_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_punishment`
--

CREATE TABLE `tbl_punishment` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `crime_id` int(11) DEFAULT NULL,
  `punishment_type` tinyint(4) NOT NULL,
  `punishment_details` text NOT NULL,
  `punishment_by` tinyint(4) NOT NULL,
  `fine_amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `grade_code` tinyint(4) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `department_code` tinyint(4) NOT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_punishment_type`
--

CREATE TABLE `tbl_punishment_type` (
  `id` int(11) NOT NULL,
  `punishment_type` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_punishment_type`
--

INSERT INTO `tbl_punishment_type` (`id`, `punishment_type`, `status`) VALUES
(1, 'Warning', 1),
(2, 'Financial Penalty', 1),
(3, 'Strong Warning', 1),
(4, 'Censure', 1),
(5, 'Explanation', 1),
(6, 'Misappropriations', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reference`
--

CREATE TABLE `tbl_reference` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `nid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resignation`
--

CREATE TABLE `tbl_resignation` (
  `id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `resignation_by` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `grade_code` tinyint(4) NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `department_code` tinyint(4) NOT NULL,
  `designation_code` tinyint(4) NOT NULL,
  `br_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_result`
--

CREATE TABLE `tbl_result` (
  `result_id` int(11) NOT NULL,
  `result` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_result`
--

INSERT INTO `tbl_result` (`result_id`, `result`) VALUES
(1, '1st'),
(2, '2nd'),
(3, 'A+'),
(4, 'A'),
(5, 'A-'),
(6, 'B'),
(7, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_adjustment`
--

CREATE TABLE `tbl_salary_adjustment` (
  `id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `basic_salary` varchar(10) NOT NULL,
  `adjustment_amount` varchar(10) NOT NULL,
  `new_basic_salary` varchar(10) NOT NULL,
  `adjustment_note` text NOT NULL,
  `grade_step` tinyint(4) NOT NULL,
  `designation_code` int(11) NOT NULL,
  `department_code` int(11) NOT NULL,
  `br_code` varchar(5) NOT NULL,
  `grade_code` int(11) NOT NULL,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `org_code` int(11) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_minus`
--

CREATE TABLE `tbl_salary_minus` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1',
  `percentage` varchar(4) NOT NULL,
  `fixed_amount` int(5) NOT NULL DEFAULT '0',
  `ho_bo` tinyint(4) NOT NULL,
  `designation_for` tinyint(4) NOT NULL DEFAULT '0',
  `epmloyee_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=all,1=probation,2=permanent,3=master role',
  `active_from` date DEFAULT NULL,
  `active_upto` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salary_minus`
--

INSERT INTO `tbl_salary_minus` (`id`, `item_name`, `type`, `percentage`, `fixed_amount`, `ho_bo`, `designation_for`, `epmloyee_status`, `active_from`, `active_upto`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`, `status`) VALUES
(1, 'P.F.', 1, '10', 0, 0, 0, 1, '2007-01-01', '2018-07-04', '2017-12-04 03:43:11', '2017-12-04 03:43:11', 1, 1, 181, 1),
(2, 'P.F.', 1, '10', 0, 1, 0, 0, '2007-01-01', '2019-12-28', '2017-12-04 03:44:41', '2017-12-04 03:44:41', 1, 1, 181, 1),
(3, 'H.Rent', 1, '10', 0, 0, 0, 0, '2007-01-01', '2018-06-30', '2017-12-04 03:44:54', '2017-12-04 03:44:54', 1, 1, 181, 1),
(4, 'H.Rent', 1, '5', 0, 1, 0, 0, '2007-01-01', '2018-06-30', '2017-12-04 03:45:05', '2017-12-04 03:45:05', 1, 1, 181, 1),
(5, 'Ins.Fund', 1, '1', 0, 0, 0, 0, '2007-01-01', '2019-01-01', '2017-12-04 03:45:37', '2017-12-04 03:45:37', 1, 7, 181, 1),
(6, 'Death Coverage', 1, '1', 0, 0, 0, 0, '2007-01-01', '2020-06-30', '2018-02-05 10:32:53', '2018-02-05 10:32:53', 1, 7, 181, 1),
(7, 'Death Coverage', 1, '2.5', 0, 1, 0, 0, '2007-01-01', '2020-06-30', '2018-03-10 04:02:07', '2018-03-10 04:02:07', 1, 1, 181, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_plus`
--

CREATE TABLE `tbl_salary_plus` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1',
  `percentage` tinyint(4) NOT NULL,
  `fixed_amount` int(5) NOT NULL DEFAULT '0',
  `ho_bo` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 is for H/O  1 is B/O',
  `designation_for` tinyint(4) NOT NULL DEFAULT '0',
  `active_from` date DEFAULT NULL,
  `epmloyee_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=all,1=probation,2=permanent,3=master role',
  `active_upto` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salary_plus`
--

INSERT INTO `tbl_salary_plus` (`id`, `item_name`, `type`, `percentage`, `fixed_amount`, `ho_bo`, `designation_for`, `active_from`, `epmloyee_status`, `active_upto`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`, `status`) VALUES
(1, 'H.Rent', 2, 0, 500, 1, 12, '2007-01-01', 2, '2019-01-01', '2017-12-03 10:35:55', '2017-12-03 10:35:55', 1, 1, 181, 1),
(2, 'H.Rent', 1, 50, 0, 2, 0, '2007-01-01', 2, '2018-06-30', '2017-12-03 10:36:28', '2017-12-03 10:36:28', 1, 1, 181, 1),
(3, 'Medical', 1, 15, 0, 1, 0, '2007-01-01', 0, '2019-01-01', '2017-12-03 10:49:16', '2017-12-03 10:49:16', 1, 1, 181, 1),
(4, 'Medical', 1, 20, 0, 0, 0, '2007-01-01', 0, '2019-01-01', '2017-12-03 10:49:25', '2017-12-03 10:49:25', 1, 1, 181, 1),
(5, 'Conveyance', 2, 0, 5000, 2, 5, '2007-01-01', 0, '2018-06-30', '2017-12-03 10:50:14', '2017-12-03 10:50:14', 1, 1, 181, 1),
(6, 'Conveyance', 1, 10, 0, 1, 0, '2007-01-01', 0, '2018-06-30', '2017-12-03 10:50:21', '2017-12-03 10:50:21', 1, 1, 181, 1),
(7, 'P.F.', 1, 10, 0, 0, 0, '2007-01-01', 0, '2018-06-30', '2017-12-03 10:52:47', '2017-12-03 10:52:47', 1, 1, 181, 1),
(8, 'P.F.', 1, 10, 0, 1, 0, '2007-01-01', 0, '2019-01-01', '2017-12-03 10:52:51', '2017-12-03 10:52:51', 1, 1, 181, 0),
(9, 'Dearness', 1, 0, 0, 1, 0, '2007-01-01', 0, '2016-07-31', '2017-12-03 10:53:02', '2017-12-03 10:53:02', 1, 1, 181, 0),
(10, 'Dearness', 1, 0, 0, 0, 0, '2007-01-01', 0, '2016-07-31', '2017-12-03 10:53:07', '2017-12-03 10:53:07', 1, 7, 181, 1),
(11, 'Field', 2, 0, 100, 0, 13, '2007-01-01', 0, '2018-06-30', '2017-12-03 10:53:20', '2017-12-03 10:53:20', 1, 1, 181, 1),
(12, 'Mobile', 1, 0, 0, 0, 0, '2007-01-01', 2, '2018-06-30', '2017-12-03 10:53:32', '2017-12-03 10:53:32', 1, 1, 181, 1),
(13, 'Mobile', 1, 10, 0, 1, 0, '2007-01-01', 0, '2018-06-30', '2017-12-03 10:53:36', '2017-12-03 10:53:36', 1, 1, 181, 0),
(14, 'Hardship (A)', 1, 0, 0, 1, 0, '2007-01-01', 0, '2019-01-01', '2017-12-03 10:53:46', '2017-12-03 10:53:46', 1, 1, 181, 0),
(15, 'Test Item', 1, 10, 0, 1, 0, '2019-01-01', 0, '2020-06-30', '2018-02-05 10:32:14', '2018-02-05 10:32:14', 1, 1, 181, 0),
(16, 'test', 2, 0, 100, 0, 5, '2018-05-01', 0, '2018-09-30', '2018-05-07 04:57:34', '2018-05-07 04:57:34', 1, 1, 181, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sarok`
--

CREATE TABLE `tbl_sarok` (
  `id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `transection_type` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sarok`
--

INSERT INTO `tbl_sarok` (`id`, `sarok_no`, `emp_id`, `letter_date`, `transection_type`, `created_at`) VALUES
(1, 1, 3305, '2017-05-02', 1, '2018-05-10 05:56:27'),
(2, 2, 3305, '2017-11-14', 2, '2018-05-10 06:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scale`
--

CREATE TABLE `tbl_scale` (
  `id` int(11) NOT NULL,
  `scale_id` int(11) NOT NULL,
  `scale_name` varchar(100) NOT NULL,
  `scale_basic_1st_step` int(11) NOT NULL,
  `increment_amount` int(11) NOT NULL,
  `final_bareer` varchar(30) NOT NULL,
  `start_from` date DEFAULT NULL,
  `end_to` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_scale`
--

INSERT INTO `tbl_scale` (`id`, `scale_id`, `scale_name`, `scale_basic_1st_step`, `increment_amount`, `final_bareer`, `start_from`, `end_to`, `status`) VALUES
(1, 1, '2100-150-4950', 2100, 150, '4950', '2007-02-01', '2008-06-30', 1),
(2, 2, '2600-150-5450', 2600, 150, '5450', '2007-02-01', '2008-06-30', 1),
(3, 3, '3000-150-5850', 3000, 150, '5850', '2007-02-01', '2008-06-30', 1),
(4, 4, '3400-175-6725', 3400, 175, '6725', '2007-02-01', '2008-06-30', 1),
(5, 5, '3875--175-7200', 3875, 175, '7200', '2007-02-01', '2008-06-30', 1),
(6, 6, '4300-175-7625', 4300, 175, '6725', '2007-02-01', '2008-06-30', 1),
(7, 7, '6500-200-10300', 6500, 200, '10300', '2007-02-01', '2008-06-30', 1),
(8, 8, '7500-200-11300', 7500, 200, '11300', '2007-02-01', '2008-06-30', 1),
(9, 9, '8000-225-12275', 8000, 225, '12275', '2007-02-01', '2008-06-30', 1),
(10, 10, '8500-225-12775', 8500, 225, '12775', '2007-02-01', '2008-06-30', 1),
(11, 11, '9000-250-13750', 9000, 250, '13750', '2007-02-01', '2008-06-30', 1),
(12, 12, '9500-275-14725', 9500, 275, '14725', '2007-02-01', '2008-06-30', 1),
(13, 13, '10000-300-15700', 10000, 300, '15700', '2007-02-01', '2008-06-30', 1),
(14, 14, '10500-325-16675', 10500, 325, '16675', '2007-02-01', '2008-06-30', 1),
(15, 15, '11000-350-17650', 11000, 350, '17650', '2007-02-01', '2008-06-30', 1),
(16, 16, '25000-375-32125', 25000, 375, '32125', '2007-02-01', '2008-06-30', 1),
(17, 17, '30000-600-39000', 30000, 600, '39000', '2008-07-01', '2010-06-30', 1),
(18, 18, '18000-550-26250', 18000, 550, '26250', '2008-07-01', '2010-06-30', 1),
(19, 19, '17000-550-25250', 17000, 550, '25250', '2008-07-01', '2010-06-30', 1),
(20, 20, '15000-500-22500', 16000, 550, '24250', '2008-07-01', '2010-06-30', 1),
(21, 21, '14000-500-21500', 15000, 500, '22500', '2008-07-01', '2010-06-30', 1),
(22, 22, '13000-450-19750', 14000, 450, '21500', '2008-07-01', '2010-06-30', 1),
(23, 23, '11500-450-18250', 13000, 450, '19750', '2008-07-01', '2010-06-30', 1),
(24, 24, '11500-450-18250', 11500, 450, '18250', '2008-07-01', '2010-06-30', 1),
(25, 25, '10500-400-16500', 10500, 400, '16500', '2008-07-01', '2010-06-30', 1),
(26, 26, '9500-400-15500', 9500, 400, '15500', '2008-07-01', '2010-06-30', 1),
(27, 27, '7700-350-12950', 7700, 350, '12950', '2008-07-01', '2010-06-30', 1),
(28, 28, '6700-300-11200', 6700, 300, '11200', '2008-07-01', '2010-06-30', 1),
(29, 29, '6000-300-10500', 6000, 300, '10500', '2008-07-01', '2010-06-30', 1),
(30, 30, '5500-250-9250', 5500, 250, '9250', '2008-07-01', '2010-06-30', 1),
(31, 31, '5000-200-8750', 4500, 200, '7500', '2008-07-01', '2010-06-30', 1),
(32, 32, '4500-200-7500', 4500, 200, '7500', '2008-07-01', '2010-06-30', 1),
(33, 33, '4000-200-7000', 4000, 200, '7000', '2008-07-01', '2010-06-30', 1),
(34, 34, '2500-100-4000', 2500, 100, '4000', '2008-07-01', '2010-06-30', 1),
(35, 35, '33000-1200-51000', 33000, 1200, '51000', '2010-07-01', '2014-06-30', 1),
(36, 36, '19800-1150-37050', 19800, 1150, '37050', '2010-07-01', '2014-06-30', 1),
(37, 37, '19550-1100-36050', 19550, 1100, '36050', '2010-07-01', '2014-06-30', 1),
(38, 38, '18400-1100-34900', 18400, 1100, '34900', '2010-07-01', '2014-06-30', 1),
(39, 39, '17250-1000-32250', 17250, 1000, '32250', '2010-07-01', '2014-06-30', 1),
(40, 40, '16100-950-30350', 16100, 950, '30350', '2010-07-01', '2014-06-30', 1),
(41, 41, '15350-900-28850', 15350, 900, '28850', '2010-07-01', '2014-06-30', 1),
(42, 42, '13200-800-25200', 13200, 800, '25200', '2010-07-01', '2014-06-30', 1),
(43, 43, '12300-750-23500', 12300, 750, '23500', '2010-07-01', '2014-06-30', 1),
(44, 44, '11100-700-21600', 11100, 700, '21600', '2010-07-01', '2014-06-30', 1),
(45, 45, '9250-600-18250', 9250, 600, '18250', '2010-07-01', '2014-06-30', 1),
(46, 46, '7900-550-16150', 7900, 550, '16150', '2010-07-01', '2014-06-30', 1),
(47, 47, '6750-500-14250', 6750, 500, '14250', '2010-07-01', '2014-06-30', 1),
(48, 48, '6300-400-12300', 6300, 400, '12300', '2010-07-01', '2014-06-30', 1),
(49, 49, '5750-375-11375', 5750, 375, '11375', '2010-07-01', '2014-06-30', 1),
(50, 50, '5200-350-10450', 5200, 350, '10450', '2010-07-01', '2014-06-30', 1),
(51, 51, '4800-325-9675', 4800, 325, '9675', '2010-07-01', '2014-06-30', 1),
(52, 52, '3450-300-7950', 3450, 300, '7950', '2010-07-01', '2014-06-30', 1),
(53, 53, '5000-250-8750', 5000, 250, '8750', '2010-07-01', '2014-06-30', 1),
(54, 54, '4500-250-8250', 4500, 250, '8250', '2010-07-01', '2014-06-30', 1),
(55, 55, '3700-250-7450', 3700, 250, '7450', '2010-07-01', '2014-06-30', 1),
(56, 56, '2500-250-6250', 2500, 250, '6250', '2010-07-01', '2014-06-30', 1),
(57, 57, '75000-11250-255000', 75000, 11250, '255000', '2014-07-01', '2016-03-11', 1),
(58, 58, '30000-3000-5100 (EB) - 4500-91500', 30000, 3000, '91500', '2014-07-01', '2016-03-11', 1),
(59, 59, '28000-2800-47600 (EB) - 4200-85400', 2800, 2800, '85400', '2014-07-01', '2016-03-11', 1),
(60, 60, '26000-2600-44200 (EB)- 3900 -79300', 26000, 2600, '79300', '2014-07-01', '2016-03-11', 1),
(61, 61, '24000-2400-40800 (EB) - 3600-73200', 24000, 2400, '73200', '2014-07-01', '2016-03-11', 1),
(62, 62, '21000-2100- 35700(EB) - 32150- 64050', 21000, 2100, '64050', '2014-07-01', '2016-03-11', 1),
(63, 63, '20000-2000- 3400 (EB) - 3000- 61000', 20000, 2000, '61000', '2014-07-01', '2016-03-11', 1),
(64, 64, '17150-1715- 29155 (EB) - 2573-52312', 17150, 1715, '52312', '2014-07-01', '2016-03-11', 1),
(65, 65, '16000-1600- 27200 (EB) - 2500 - 48800', 16000, 1600, '48000', '2014-07-01', '2016-03-11', 1),
(66, 66, '14400-1440- 24480 (EB) - 2160- 43920', 14400, 1440, '43920', '2014-07-01', '2016-03-11', 1),
(67, 67, '12000-1200-20400 (EB) - 1800-3600', 12000, 1200, '2600', '2014-07-01', '2016-03-11', 1),
(68, 68, '10270-1027-17459 (EB) - 1541-31328', 10270, 1027, '31328', '2014-07-01', '2016-03-11', 1),
(69, 69, '8750-875-14875 (EB) - 1313-26692', 8750, 875, '26692', '2014-07-01', '2016-03-11', 1),
(70, 70, '8200-820-13940 (EB) - 1323-25010', 8200, 820, '25010', '2014-07-01', '2016-03-11', 1),
(71, 71, '7500-750-12750 (EB) - 1125-22875', 7500, 750, '22875', '2014-07-01', '2016-03-11', 1),
(72, 72, '6750-675-11475 (EB) - 1013-20592', 6750, 675, '20592', '2014-07-01', '2016-03-11', 1),
(73, 73, '6500-650-11050 (EB) - 975-19825', 6500, 650, '19825', '2014-07-01', '2016-03-11', 1),
(74, 74, '75000-11250-255000', 75000, 11250, '255000', '2016-03-12', '2018-06-30', 1),
(75, 75, '30000-3000-51000(EB)-4500-91500', 30000, 3000, '91500', '2016-03-12', '2018-06-30', 1),
(76, 76, '29000-2900-49300(EB)-4350-88450', 29000, 2900, '88450', '2016-03-12', '2018-06-30', 1),
(77, 77, '28000-2800-47600(EB)-4200-85400', 28000, 2800, '85400', '2016-03-12', '2018-06-30', 1),
(78, 78, '26000-2600-44200(EB)-3900-79300', 26000, 2600, '79300', '2016-03-12', '2018-06-30', 1),
(79, 79, '24000-2400-40800(EB)-2600-73200', 24000, 2400, '73200', '2016-03-12', '2018-06-30', 1),
(80, 80, '21000-2100-35700(EB)-3150-64050', 21000, 2100, '64050', '2016-03-12', '2018-06-30', 1),
(81, 81, '20500-2050-34850(EB)-3075-62525', 20500, 2050, '62525', '2016-03-12', '2018-06-30', 1),
(82, 82, '20000-2000-34000(EB)-3000-61000', 20000, 2000, '61000', '2016-03-12', '2018-06-30', 1),
(83, 83, '17150-1715-29155(EB)-2573-915523120', 17150, 1715, '52312', '2016-03-12', '2018-06-30', 1),
(84, 84, '16000-1600-27200(EB)-2400-48800', 16000, 1600, '48800', '2016-03-12', '2018-06-30', 1),
(85, 85, '14400 - 1440 - 24480 (EB) - 2160 - 43920', 14400, 1440, '43920', '2016-03-12', '2018-06-30', 1),
(86, 86, '12000-1200-20400(EB)-1800-36600', 12000, 1200, '36600', '2016-03-12', '2018-06-30', 1),
(87, 87, '10270-1027-17459(EB)-1541-31328', 10270, 1027, '31328', '2016-03-12', '2018-06-30', 1),
(88, 88, '8750-875-14875(EB)-1313-26692', 8750, 875, '26692', '2016-03-12', '2018-06-30', 1),
(89, 89, '8200-820-13940(EB)-1230-25010', 8200, 820, '25010', '2016-03-12', '2018-06-30', 1),
(90, 90, '7500-750-12750(EB)-1125-22875', 7500, 750, '22875', '2016-03-12', '2018-06-30', 1),
(91, 91, '6750-675-11475(EB)-1013-20592', 6750, 675, '20592', '2016-03-12', '2018-06-30', 1),
(92, 92, '6500-650-11050(EB)-975-19825', 6500, 650, '19825', '2016-03-12', '2018-06-30', 1),
(93, 93, '6500-650-16900', 6500, 950, '16900', '2016-03-12', '2018-06-30', 1),
(94, 94, '6000-600-15600', 6000, 600, '15600', '2016-03-12', '2018-06-30', 1),
(95, 95, '5500-550-14300', 5500, 550, '14300', '2016-03-12', '2018-06-30', 1),
(96, 96, '5000-500-13000', 5000, 500, '13000', '2016-03-12', '2018-06-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_security`
--

CREATE TABLE `tbl_staff_security` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `diposit_date` date NOT NULL,
  `diposit_amount` float(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`status_id`, `status_name`) VALUES
(1, 'Active'),
(2, 'Cancel');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_code` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`id`, `subject_name`, `subject_code`) VALUES
(1, 'Scince', 1),
(2, 'Arts', 2),
(3, 'Commers', 3),
(4, 'English', 4),
(5, 'Computer Scince', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thana`
--

CREATE TABLE `tbl_thana` (
  `id` int(11) NOT NULL,
  `thana_code` int(11) NOT NULL,
  `thana_name` varchar(30) NOT NULL,
  `thana_bangla` varchar(50) DEFAULT NULL,
  `district_code` smallint(6) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_thana`
--

INSERT INTO `tbl_thana` (`id`, `thana_code`, `thana_name`, `thana_bangla`, `district_code`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(2, 1, 'Dhamrai', NULL, 1, 1, '2017-11-05 12:50:42', '2017-12-04 08:52:20', NULL, NULL, 181),
(3, 2, 'Sirajgonj sadar', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(4, 3, 'Shahazanpur', NULL, 3, 1, '2017-11-05 12:50:42', '2017-12-04 09:07:26', NULL, NULL, 181),
(5, 4, 'Bajitpur', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(6, 5, 'AA', NULL, 5, 1, '2017-11-05 12:50:42', '2017-12-04 09:07:21', NULL, NULL, 181),
(7, 6, 'Gaibanda Sadar', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(8, 7, 'Laxmipur Sadar', NULL, 7, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(9, 8, 'Melandaha', NULL, 8, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(10, 9, 'East Dhala', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(11, 10, 'Belab', NULL, 10, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(12, 11, 'Shariyakindi', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(13, 12, 'Shreepur', NULL, 11, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(14, 13, 'Moradnagar', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(15, 14, 'Ghoraghat', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(16, 15, 'Dhunat', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(17, 16, 'Ghior', NULL, 14, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(18, 17, 'Bhoda', NULL, 15, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(19, 18, 'Gopalpur', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(20, 19, 'Bhayapur', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(21, 20, 'jaldaka', NULL, 17, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(22, 21, 'Debidar', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(23, 22, 'Parsuram', NULL, 18, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(24, 23, 'Bhangura', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(25, 24, 'Shadullapur', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(26, 25, 'Haziganj', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(27, 26, 'Nangalkot', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(28, 27, 'Nabinagor', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(29, 28, 'B.baria Sador', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(30, 29, 'Akhaura', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(31, 30, 'Sorail', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(32, 31, 'Nasirnogor', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(33, 32, 'Agoyal Jhara', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(34, 33, 'B.baria', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(35, 34, 'Kochua', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(36, 35, 'Kandua', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(37, 36, 'Fulbaria', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(38, 37, 'Goforgao', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(39, 38, 'Motlob', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(40, 39, 'Kalihati', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(41, 40, 'Islampur', NULL, 8, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(42, 41, 'Netrokona Sadar', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(43, 42, 'Gouripur', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(44, 43, 'Khilgao', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(45, 44, 'Horirampur', NULL, 14, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(46, 45, 'Kutubdia', NULL, 24, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(47, 46, 'Fulpur', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(48, 47, 'Dhormopasha', NULL, 25, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(49, 48, 'Kaliakoir', NULL, 11, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(50, 49, 'Roygonj', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(51, 50, 'Muktagasa', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(52, 51, 'Mithapukur', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(53, 52, 'Pirgasa', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(54, 53, 'Durgapur', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(55, 54, 'Dawodkandi', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(56, 55, 'Jamalpur', NULL, 8, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(57, 56, 'Kolmakanda', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(58, 57, 'Bramonpara', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(59, 58, 'Adomdighi', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(60, 59, 'Nazirpur', NULL, 28, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(61, 60, 'Kushtia', NULL, 29, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(62, 61, 'Durgapur', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(63, 62, 'Serpur Sadar', NULL, 30, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(64, 63, 'Sharishabari', NULL, 8, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(65, 64, 'Chandina', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(66, 65, 'Shaharasti', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(67, 66, 'Jaypurhat', NULL, 5, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(68, 67, 'Nagashor', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(69, 68, 'Laksham', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(70, 69, 'Kazipur', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(71, 70, 'Kotoali', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(72, 71, 'Valuka', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(73, 72, 'Lalmonirhat', NULL, 32, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(74, 73, 'Nagarpur', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(75, 74, 'Naragathi', NULL, 33, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(76, 75, 'Raygonj', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(77, 76, 'Sador', NULL, 34, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(78, 77, 'Solonga', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(79, 78, 'Kosba', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(80, 79, 'Manikgonj', NULL, 14, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(81, 80, 'Syedpur', NULL, 17, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(82, 81, 'Dowlotpur', NULL, 29, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(83, 82, 'Atpara', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(84, 83, 'Gobindogonj', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(85, 84, 'Razapur', NULL, 35, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(86, 85, 'Tarakanda', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(87, 86, 'Manda', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(88, 87, 'Abhynagar', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(89, 88, 'Tungipara', NULL, 38, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(90, 89, 'Nilphamari', NULL, 17, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(91, 90, 'Gaibandha', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(92, 91, 'Mahendigonj', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(93, 92, 'Gazipur Sadar', NULL, 11, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(94, 93, 'Shylakupa', NULL, 39, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(95, 94, 'Sherpur', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(96, 95, 'Monohordi', NULL, 10, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(97, 96, 'Vhoyrob', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(98, 97, 'Pakundia', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(99, 98, 'Tungibari', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(100, 99, 'Madhobpur', NULL, 41, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(101, 100, 'Fatullah', NULL, 42, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(102, 101, 'Austogram', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(103, 102, 'Ramgoti', NULL, 7, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(104, 103, 'Modhupur', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(105, 104, 'Shundorgonj', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(106, 105, 'Jhinadaha', NULL, 39, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(107, 106, 'Trishal', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(108, 107, 'Bara', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(109, 108, 'Nagarbatha', NULL, 39, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(110, 109, 'Kotwali', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(111, 110, 'Morolgonj', NULL, 43, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(112, 111, 'Bodorgonj', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(113, 112, 'Ishorgonj', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(114, 113, 'Sadar', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(115, 114, 'Bawfall', NULL, 44, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(116, 115, 'Nockla', NULL, 30, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(117, 116, 'Kalihati', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(118, 117, 'Singra', NULL, 45, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(119, 118, 'Khansama', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(120, 119, 'Bamna', NULL, 46, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(121, 120, 'Puthia', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(122, 121, 'Dawangonj', NULL, 8, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(123, 122, 'Pirgonj', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(124, 123, 'Kotiadi', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(125, 124, 'Ullahpara', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(126, 125, 'Lalpur', NULL, 45, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(127, 126, 'Ramgonj', NULL, 7, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(128, 127, 'Charghat', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(129, 128, 'Homna', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(130, 129, 'Kolaboa', NULL, 47, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(131, 130, 'Charfashio', NULL, 48, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(132, 131, 'Delduar', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(133, 132, 'Kotoali', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(134, 133, 'Kotoali', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(135, 134, 'Dhon Bari', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(136, 135, 'Bagmara', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(137, 136, 'Burichang', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(138, 137, 'Uttara', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(139, 138, 'Sribordi', NULL, 30, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(140, 139, 'Rajoyir', NULL, 49, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(141, 140, 'Nobabgonj', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(142, 141, 'Comilla Sadar', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(143, 142, 'Madaripur', NULL, 49, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(144, 143, 'Chatmoho', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(145, 144, 'Niamotpur', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(146, 145, 'Batagi', NULL, 46, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(147, 146, 'Bhola Sadar', NULL, 48, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(148, 147, 'Gowro Nadi', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(149, 148, 'Hatibandha', NULL, 32, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(150, 149, 'Shamnagor', NULL, 47, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(151, 150, 'Madargonj', NULL, 8, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(152, 151, 'Gabtoli', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(153, 152, 'Charjobbor', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(154, 153, 'Hatia', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(155, 154, 'Baliakandi', NULL, 51, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(156, 155, 'Boraigram', NULL, 45, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(157, 156, 'Dimla', NULL, 17, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(158, 157, 'Kalkini', NULL, 49, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(159, 158, 'Dumki', NULL, 44, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(160, 159, 'Nolbhanga', NULL, 45, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(161, 160, 'Rupgonj', NULL, 42, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(162, 161, 'Kalai', NULL, 5, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(163, 162, 'Domar', NULL, 17, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(164, 163, 'Sadar Myazdi', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(165, 164, 'Suborno Char', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(166, 165, 'Akkalpur', NULL, 5, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(167, 166, 'Gozaria', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(168, 167, 'Polash Bari', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(169, 168, 'Shibpur', NULL, 10, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(170, 169, 'Debigonj', NULL, 15, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(171, 170, 'Chandpur', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(172, 171, 'Shibgonj', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(173, 172, 'Kumarkhali', NULL, 29, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(174, 173, 'Razarhat', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(175, 174, 'Palash', NULL, 10, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(176, 175, 'Bagati Para', NULL, 45, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(177, 176, 'FotiKchori', NULL, 52, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(178, 177, 'Chowddo Gram', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(179, 178, 'Mothbaria', NULL, 28, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(180, 179, 'Chitol Mari', NULL, 43, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(181, 180, 'Golachipa', NULL, 44, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(182, 181, 'Sadar', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(183, 182, 'Kapasia', NULL, 11, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(184, 183, 'Kashobpur', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(185, 184, 'Badalgasi', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(186, 185, 'Sudharam', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(187, 186, 'Mohammadpur', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(188, 187, 'Chowgasa', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(189, 188, 'Chagoalnail', NULL, 18, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(190, 189, 'Pabna Sadar', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(191, 190, 'Cowlia', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(192, 191, 'Doshmina', NULL, 44, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(193, 192, 'Banaripara', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(194, 193, 'Patuakhali', NULL, 44, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(195, 194, 'Damuja', NULL, 53, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(196, 195, 'Bashail', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(197, 196, 'Sadar South', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(198, 197, 'Ulirpur', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(199, 198, 'Borhanuddi', NULL, 48, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(200, 199, 'Sadar', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(201, 200, 'Nachol', NULL, 54, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(202, 201, 'Parbotipur', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(203, 202, 'Komolnagar', NULL, 7, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(204, 203, 'Dowlatpur', NULL, 55, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(205, 204, 'Nojipur', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(206, 205, 'Mirsarai', NULL, 52, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(207, 206, 'Bagomgonj', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(208, 207, 'Jokigonj', NULL, 56, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(209, 208, 'Komolgonj', NULL, 57, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(210, 209, 'Dhamrai Hat', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(211, 210, 'Demra', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(212, 211, 'Sujanagor', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(213, 212, 'Dawlotkha', NULL, 48, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(214, 213, 'Ishordi', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(215, 214, 'Kishoregonj', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(216, 215, 'Setakundo', NULL, 52, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(217, 216, 'Sonagazi', NULL, 18, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(218, 217, 'Nandail', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(219, 218, 'Bianibazar', NULL, 56, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(220, 219, 'Amtoli', NULL, 46, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(221, 220, 'Ghatail', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(222, 221, 'Sadar', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(223, 222, 'Kolaroa', NULL, 47, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(224, 223, 'Jheneigati', NULL, 30, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(225, 224, 'Hobigonj', NULL, 41, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(226, 225, 'Aditmari', NULL, 32, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(227, 226, 'Raypur', NULL, 7, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(228, 227, 'Faridpur', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(229, 228, 'Bahubol', NULL, 41, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(230, 229, 'Mokshudpur', NULL, 38, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(231, 230, 'Dagonbhuya', NULL, 18, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(232, 231, 'Naoga', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(233, 232, 'Sariakandi', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(234, 233, 'Shivgonj', NULL, 54, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(235, 234, 'Vhober Char', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(236, 235, 'Narail', NULL, 33, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(237, 236, 'Chadpur', NULL, 59, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(238, 237, 'Borura', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(239, 238, 'Mohadebpur', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(240, 239, 'Faridgong', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(241, 240, 'Nalita Bari', NULL, 30, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(242, 241, 'Gongachora', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(243, 242, 'Potia', NULL, 52, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(244, 243, 'Anowara', NULL, 52, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(245, 244, 'Saturia', NULL, 14, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(246, 245, 'Khulna', NULL, 55, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(247, 246, 'Taragonj', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(248, 247, 'Damurhuda', NULL, 60, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(249, 248, 'Feni Sadar', NULL, 18, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(250, 249, 'Bijoynogar', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(251, 250, 'Asasuni', NULL, 47, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(252, 251, 'Purbadhala', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(253, 252, 'Mohalsori', NULL, 61, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(254, 253, 'Birol', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(255, 254, 'Kobirhat', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(256, 255, 'Companygonj', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(257, 256, 'Barishal Sadar', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(258, 257, 'Mirzagonj', NULL, 44, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(259, 258, 'Patgram', NULL, 32, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(260, 259, 'Mirzapur', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(261, 260, 'Monohorgonj', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(262, 261, 'Rangpur Sadar', NULL, 26, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(263, 262, 'Atwari', NULL, 62, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(264, 263, 'Borkol', NULL, 63, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(265, 264, 'Dighinala', NULL, 61, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(266, 265, 'Babugonj', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(267, 266, 'Kahalu', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(268, 267, 'Mitamoi', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(269, 268, 'Lowhogonj', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(270, 269, 'Lowhojong', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(271, 270, 'SouthKha', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(272, 271, 'Hizla', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(273, 272, 'Dowara Bazar', NULL, 25, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(274, 273, 'Lalmoho', NULL, 48, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(275, 274, 'Sonaimuri', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(276, 275, 'Kuliachar', NULL, 4, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(277, 276, 'Gandaria', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(278, 277, 'Nobigonj', NULL, 41, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(279, 278, 'Rani Nogor', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(280, 279, 'Kaligonj', NULL, 11, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(281, 280, 'Savar', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(282, 281, 'Naria', NULL, 53, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(283, 282, 'Motihar', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(284, 283, 'Kotalipara', NULL, 38, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(285, 284, 'Kathalia', NULL, 35, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(286, 285, 'Bakergonj', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(287, 286, 'Magura Sadar', NULL, 59, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(288, 287, 'Khaliajuri', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(289, 288, 'Noapara', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(290, 289, 'Munshigonj Sadar', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(291, 290, 'Shahjadpur', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(292, 291, 'Bancharampur', NULL, 21, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(293, 292, 'Mohammadpur', NULL, 59, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(294, 293, 'Kaligonj', NULL, 39, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(295, 294, 'Hymchar', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(296, 295, 'Mowlovibazar Sadar', NULL, 57, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(297, 296, 'Adorsho Sadar', NULL, 12, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(298, 297, 'Kotchandpur', NULL, 39, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(299, 298, 'Kurigram Sader', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(300, 299, 'Churunaghat', NULL, 41, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(301, 300, 'Sunamgonj sadar', NULL, 25, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(302, 301, 'Chowhali', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(303, 302, 'Sadar', NULL, 56, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(304, 303, 'Madhukhali', NULL, 58, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(305, 304, 'Chandanaish', NULL, 52, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(306, 305, 'Sonargao', NULL, 42, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(307, 306, 'Sathia', NULL, 19, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(308, 307, 'Raipura', NULL, 10, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(309, 308, 'Noakhali Sador', NULL, 50, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(310, 309, 'Nalchity', NULL, 35, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(311, 310, 'Sadar', NULL, 47, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(312, 311, 'Mohongonj', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(313, 312, 'Jibon nagar', NULL, 60, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(314, 313, 'Ramu', NULL, 24, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(315, 314, 'Chilmari', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(316, 315, 'Mirpur', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(317, 316, 'Mirpur-14', NULL, 1, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(318, 317, 'Tetulia', NULL, 15, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(319, 318, 'Goshair Hat', NULL, 53, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(320, 319, 'Tangail', NULL, 16, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(321, 320, 'Nasarabad', NULL, 28, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(322, 321, 'Monirampur', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(323, 322, 'Kaharol', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(324, 323, 'Tarash', NULL, 2, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(325, 324, 'Panksha', NULL, 51, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(326, 325, 'Bhandaria', NULL, 28, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(327, 326, 'Sirazdikha', NULL, 40, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(328, 327, 'Bagharpara', NULL, 37, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(329, 328, 'Nator Sadar', NULL, 45, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(330, 329, 'Muladi', NULL, 22, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(331, 330, 'Bhurungamari', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(332, 331, 'Barhatta', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(333, 332, 'Dumuria', NULL, 55, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(334, 333, 'Roumari', NULL, 31, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(335, 334, 'Chapainobabgonj Sadar', NULL, 54, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(336, 335, 'Pachbibi', NULL, 5, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(337, 336, 'Paikgasa', NULL, 55, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(338, 337, 'Kaligonj', NULL, 32, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(339, 338, 'South Motlob', NULL, 20, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(340, 339, 'Haluaghat', NULL, 23, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(341, 340, 'Baliadangi', NULL, 34, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(342, 341, 'Kotwali', NULL, 58, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(343, 342, 'Fullshori', NULL, 6, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(344, 343, 'Fullbari', NULL, 13, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(345, 344, 'Bondor', NULL, 42, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(346, 345, 'Modo', NULL, 9, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(347, 346, 'Debigonj', NULL, 62, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(348, 347, 'Nondigram', NULL, 3, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(349, 348, 'Rupsha', NULL, 55, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(350, 349, 'Bagha', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(351, 350, 'Tanor', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(352, 351, 'Godagari', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(353, 352, 'Debhata', NULL, 47, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(354, 353, 'Mohonpur', NULL, 27, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(355, 354, 'Sapahara', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(356, 355, 'Koira', NULL, 55, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(357, 356, 'Attrai', NULL, 36, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(358, 357, 'Lohagora', NULL, 33, 1, '2017-11-05 12:50:42', NULL, NULL, NULL, 181),
(359, 358, 'aa', NULL, 64, 1, '2017-11-12 07:05:06', '2017-11-12 08:08:49', NULL, NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transections`
--

CREATE TABLE `tbl_transections` (
  `transaction_id` int(11) NOT NULL,
  `transaction_name` varchar(50) NOT NULL,
  `transection_table` varchar(50) NOT NULL,
  `is_effect_salary` tinyint(4) NOT NULL DEFAULT '1',
  `transaction_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_transections`
--

INSERT INTO `tbl_transections` (`transaction_id`, `transaction_name`, `transection_table`, `is_effect_salary`, `transaction_status`) VALUES
(1, 'Probation', 'tbl_probation', 1, 1),
(2, 'Permanent', 'tbl_permanent', 1, 1),
(3, 'Increment', 'tbl_increment', 1, 1),
(4, 'Promotion', 'tbl_promotion', 1, 1),
(5, 'Transfer', 'tbl_transfer', 1, 1),
(6, 'Punishment', 'tbl_punishment', 0, 1),
(7, 'Heldup', 'tbl_heldup', 0, 1),
(8, 'Resignation', 'tbl_resignation', 0, 1),
(9, 'Salary Adjustment', 'tbl_salary_adjustment', 0, 1),
(10, 'Demotion', 'tbl_demotion', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer`
--

CREATE TABLE `tbl_transfer` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `sarok_no` int(11) NOT NULL,
  `letter_date` date NOT NULL,
  `effect_date` date DEFAULT NULL,
  `br_joined_date` date NOT NULL,
  `br_code` varchar(6) NOT NULL,
  `designation_code` smallint(6) DEFAULT NULL,
  `grade_code` smallint(6) DEFAULT NULL,
  `grade_step` int(11) NOT NULL,
  `department_code` smallint(6) DEFAULT NULL,
  `next_increment_date` date NOT NULL,
  `report_to` int(11) DEFAULT NULL,
  `remarks` tinyint(4) NOT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `org_code` smallint(6) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer_remarks`
--

CREATE TABLE `tbl_transfer_remarks` (
  `id` int(11) NOT NULL,
  `remarks_note` varchar(250) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` tinyint(4) NOT NULL,
  `updated_by` tinyint(4) NOT NULL,
  `org_code` int(11) NOT NULL DEFAULT '181'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_transfer_remarks`
--

INSERT INTO `tbl_transfer_remarks` (`id`, `remarks_note`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `org_code`) VALUES
(1, 'Test', 1, '2018-05-10 05:00:19', '2018-05-10 05:00:19', 1, 1, 181);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_permissions`
--

CREATE TABLE `tbl_user_permissions` (
  `id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `permission` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_permissions`
--

INSERT INTO `tbl_user_permissions` (`id`, `user_role_id`, `nav_id`, `permission`, `status`, `updated_at`) VALUES
(38, 4, 32, '1', 1, '2017-12-03 09:34:29'),
(40, 4, 32, '1', 1, '2017-12-03 09:34:29'),
(42, 4, 33, '1', 1, '2017-12-03 09:34:51'),
(44, 4, 33, '1', 1, '2017-12-03 09:34:51'),
(46, 4, 34, '1', 1, '2017-12-04 04:40:11'),
(48, 4, 34, '1', 1, '2017-12-04 04:40:11'),
(70, 2, 35, '1', 1, '2017-12-06 06:13:40'),
(99, 2, 36, '1', 1, '2017-12-23 08:41:25'),
(102, 2, 37, '1', 1, '2017-12-23 09:30:51'),
(122, 2, 38, '1', 1, '2017-12-27 03:55:22'),
(125, 2, 39, '1', 1, '2017-12-27 03:55:54'),
(128, 2, 40, '1', 1, '2017-12-27 03:56:25'),
(131, 2, 41, '1', 1, '2017-12-27 03:57:03'),
(134, 2, 42, '1', 1, '2017-12-27 03:59:18'),
(137, 2, 43, '1', 1, '2017-12-27 03:59:57'),
(140, 2, 44, '1', 1, '2017-12-27 04:02:24'),
(143, 2, 45, '1', 1, '2017-12-27 04:03:04'),
(146, 2, 46, '1', 1, '2017-12-27 04:03:38'),
(148, 12, 38, '1', 1, '2017-12-27 08:21:13'),
(149, 12, 39, '1', 1, '2017-12-27 08:21:21'),
(150, 12, 40, '1', 1, '2017-12-27 08:21:30'),
(151, 12, 41, '1', 1, '2017-12-27 08:21:42'),
(152, 12, 44, '1', 1, '2017-12-27 09:37:16'),
(182, 4, 47, '1', 1, '2017-12-31 08:07:28'),
(184, 2, 48, '1', 1, '2018-02-03 09:33:33'),
(187, 2, 49, '1', 1, '2018-02-03 09:35:26'),
(190, 2, 50, '1', 1, '2018-02-03 09:36:16'),
(193, 2, 51, '1', 1, '2018-02-03 09:36:48'),
(196, 2, 52, '1', 1, '2018-02-03 09:37:21'),
(198, 2, 30, '1', 1, '2018-02-03 10:41:45'),
(382, 2, 53, '1', 1, '2018-02-19 04:18:00'),
(386, 2, 54, '1', 1, '2018-02-24 05:37:21'),
(389, 2, 55, '1', 1, '2018-02-27 04:49:05'),
(392, 2, 56, '1', 1, '2018-02-27 04:50:19'),
(395, 2, 57, '1', 1, '2018-02-27 04:50:57'),
(533, 2, 58, '1', 1, '2018-03-10 09:23:22'),
(536, 2, 59, '1', 1, '2018-03-10 10:17:16'),
(539, 2, 60, '1', 1, '2018-03-19 10:42:39'),
(541, 4, 60, '1', 1, '2018-03-19 10:42:39'),
(591, 2, 61, '1', 1, '2018-03-25 08:57:43'),
(593, 4, 61, '1', 1, '2018-03-25 08:57:43'),
(644, 2, 62, '1', 1, '2018-03-27 04:28:33'),
(646, 1, 30, '1,2,3', 1, '2018-03-27 04:28:46'),
(647, 1, 31, '1,2', 1, '2018-03-27 04:28:46'),
(648, 1, 5, '1,2,3', 1, '2018-03-27 04:28:46'),
(649, 1, 10, '1,2,3', 1, '2018-03-27 04:28:46'),
(650, 1, 11, '1,2,3', 1, '2018-03-27 04:28:46'),
(651, 1, 12, '1,2,3', 1, '2018-03-27 04:28:46'),
(652, 1, 14, '1,2,3', 1, '2018-03-27 04:28:46'),
(653, 1, 32, '1,2,3', 1, '2018-03-27 04:28:46'),
(654, 1, 33, '1,2,3', 1, '2018-03-27 04:28:46'),
(655, 1, 34, '1,2,3', 1, '2018-03-27 04:28:46'),
(656, 1, 35, '1,2', 1, '2018-03-27 04:28:46'),
(657, 1, 4, '1,2,3', 1, '2018-03-27 04:28:46'),
(658, 1, 15, '1,2,3', 1, '2018-03-27 04:28:46'),
(659, 1, 20, '1,2,3', 1, '2018-03-27 04:28:46'),
(660, 1, 36, '1,2,3', 1, '2018-03-27 04:28:46'),
(661, 1, 37, '1,2,3', 1, '2018-03-27 04:28:46'),
(662, 1, 13, '1,2,3', 1, '2018-03-27 04:28:46'),
(663, 1, 38, '1,2,3', 1, '2018-03-27 04:28:46'),
(664, 1, 39, '1,2,3', 1, '2018-03-27 04:28:46'),
(665, 1, 40, '1,2,3', 1, '2018-03-27 04:28:46'),
(666, 1, 41, '1,2,3', 1, '2018-03-27 04:28:46'),
(667, 1, 42, '1,2,3', 1, '2018-03-27 04:28:46'),
(668, 1, 43, '1,2,3', 1, '2018-03-27 04:28:46'),
(669, 1, 44, '1,2,3', 1, '2018-03-27 04:28:46'),
(670, 1, 45, '1,2,3', 1, '2018-03-27 04:28:46'),
(671, 1, 46, '1,2,3', 1, '2018-03-27 04:28:46'),
(672, 1, 17, '1,2,3', 1, '2018-03-27 04:28:46'),
(673, 1, 47, '1,2,3', 1, '2018-03-27 04:28:46'),
(674, 1, 48, '1,2,3', 1, '2018-03-27 04:28:46'),
(675, 1, 49, '1,2,3', 1, '2018-03-27 04:28:46'),
(676, 1, 50, '1,2,3', 1, '2018-03-27 04:28:47'),
(677, 1, 51, '1,2,3', 1, '2018-03-27 04:28:47'),
(678, 1, 52, '1,2,3', 1, '2018-03-27 04:28:47'),
(679, 1, 26, '1,2,3', 1, '2018-03-27 04:28:47'),
(680, 1, 27, '1,2,3', 1, '2018-03-27 04:28:47'),
(681, 1, 28, '1,2,3', 1, '2018-03-27 04:28:47'),
(682, 1, 29, '1,2,3', 1, '2018-03-27 04:28:47'),
(683, 1, 9, '1', 1, '2018-03-27 04:28:47'),
(684, 1, 16, '1', 1, '2018-03-27 04:28:47'),
(685, 1, 53, '1', 1, '2018-03-27 04:28:47'),
(686, 1, 24, '1', 1, '2018-03-27 04:28:47'),
(687, 1, 54, '1', 1, '2018-03-27 04:28:47'),
(688, 1, 55, '1', 1, '2018-03-27 04:28:47'),
(689, 1, 56, '1', 1, '2018-03-27 04:28:47'),
(690, 1, 57, '1', 1, '2018-03-27 04:28:47'),
(691, 1, 58, '1', 1, '2018-03-27 04:28:47'),
(692, 1, 59, '1', 1, '2018-03-27 04:28:47'),
(693, 1, 60, '1,2,3,4', 1, '2018-03-27 04:28:47'),
(694, 1, 61, '1,2,3', 1, '2018-03-27 04:28:47'),
(695, 1, 62, '1,2,3', 1, '2018-03-27 04:28:47'),
(696, 1, 63, '1', 1, '2018-04-02 03:48:05'),
(697, 2, 63, '1', 1, '2018-04-02 03:48:05'),
(699, 1, 64, '1', 1, '2018-04-02 03:48:34'),
(700, 2, 64, '1', 1, '2018-04-02 03:48:34'),
(702, 1, 65, '1', 1, '2018-04-02 03:49:02'),
(703, 2, 65, '1', 1, '2018-04-02 03:49:03'),
(705, 1, 66, '1', 1, '2018-04-02 08:10:38'),
(706, 2, 66, '1', 1, '2018-04-02 08:10:38'),
(707, 1, 67, '1', 1, '2018-04-02 08:11:13'),
(708, 2, 67, '1', 1, '2018-04-02 08:11:13'),
(710, 1, 68, '1', 1, '2018-04-02 08:11:39'),
(711, 2, 68, '1', 1, '2018-04-02 08:11:39'),
(714, 1, 69, '1', 1, '2018-04-02 08:12:52'),
(715, 2, 69, '1', 1, '2018-04-02 08:12:52'),
(717, 1, 70, '1', 1, '2018-04-02 08:13:16'),
(718, 2, 70, '1', 1, '2018-04-02 08:13:16'),
(720, 1, 71, '1', 1, '2018-04-02 08:13:40'),
(721, 2, 71, '1', 1, '2018-04-02 08:13:40'),
(723, 1, 72, '1', 1, '2018-04-02 08:14:00'),
(724, 2, 72, '1', 1, '2018-04-02 08:14:00'),
(726, 1, 73, '1', 1, '2018-04-02 08:14:21'),
(727, 2, 73, '1', 1, '2018-04-02 08:14:21'),
(729, 1, 74, '1', 1, '2018-04-02 08:31:31'),
(730, 2, 74, '1', 1, '2018-04-02 08:31:31'),
(732, 2, 4, '1', 1, '2018-04-03 10:40:22'),
(734, 2, 5, '1', 1, '2018-04-03 10:40:29'),
(736, 2, 10, '1', 1, '2018-04-03 10:40:37'),
(738, 2, 11, '1', 1, '2018-04-03 10:40:45'),
(740, 2, 12, '1', 1, '2018-04-03 10:40:53'),
(742, 1, 22, '1', 1, '2018-04-03 10:41:12'),
(743, 2, 22, '1', 1, '2018-04-03 10:41:12'),
(745, 2, 13, '1', 1, '2018-04-03 10:41:23'),
(747, 2, 14, '1', 1, '2018-04-03 10:41:32'),
(749, 2, 17, '1', 1, '2018-04-03 10:41:39'),
(751, 1, 18, '1', 1, '2018-04-03 10:41:46'),
(752, 2, 18, '1', 1, '2018-04-03 10:41:46'),
(754, 1, 19, '1', 1, '2018-04-03 10:42:11'),
(755, 2, 19, '1', 1, '2018-04-03 10:42:11'),
(757, 2, 34, '1', 1, '2018-04-03 10:43:35'),
(759, 2, 47, '1', 1, '2018-04-03 10:43:39'),
(813, 2, 31, '1', 1, '2018-04-07 04:53:12'),
(871, 3, 35, '1,2,3', 1, '2018-04-15 08:50:29'),
(872, 3, 36, '1,2,3', 1, '2018-04-15 08:50:29'),
(873, 3, 38, '1,2,3', 1, '2018-04-15 08:50:29'),
(874, 3, 39, '1,2,3', 1, '2018-04-15 08:50:29'),
(875, 3, 40, '1,2,3', 1, '2018-04-15 08:50:29'),
(876, 3, 41, '1,2,3', 1, '2018-04-15 08:50:29'),
(877, 3, 42, '1,2,3', 1, '2018-04-15 08:50:29'),
(878, 3, 43, '1,2,3', 1, '2018-04-15 08:50:29'),
(879, 3, 44, '1,2,3', 1, '2018-04-15 08:50:29'),
(880, 3, 45, '1,2,3', 1, '2018-04-15 08:50:29'),
(881, 3, 46, '1,2,3', 1, '2018-04-15 08:50:29'),
(882, 3, 48, '1,2,3', 1, '2018-04-15 08:50:29'),
(883, 3, 49, '1,2,3', 1, '2018-04-15 08:50:29'),
(884, 3, 50, '1,2,3', 1, '2018-04-15 08:50:29'),
(885, 3, 51, '1,2,3', 1, '2018-04-15 08:50:29'),
(886, 3, 52, '1,2,3', 1, '2018-04-15 08:50:29'),
(887, 3, 30, '1,2,3', 1, '2018-04-15 08:50:29'),
(888, 3, 53, '1,2,3', 1, '2018-04-15 08:50:29'),
(889, 3, 54, '1,2,3', 1, '2018-04-15 08:50:29'),
(890, 3, 55, '1,2,3', 1, '2018-04-15 08:50:29'),
(891, 3, 56, '1,2,3', 1, '2018-04-15 08:50:29'),
(892, 3, 57, '1,2,3', 1, '2018-04-15 08:50:29'),
(893, 3, 58, '1,2,3', 1, '2018-04-15 08:50:29'),
(894, 3, 59, '1,2,3', 1, '2018-04-15 08:50:29'),
(895, 3, 60, '1,2,3', 1, '2018-04-15 08:50:29'),
(896, 3, 61, '1,2,3', 1, '2018-04-15 08:50:29'),
(897, 3, 62, '1,2,3', 1, '2018-04-15 08:50:29'),
(898, 3, 63, '1,2,3', 1, '2018-04-15 08:50:29'),
(899, 3, 64, '1,2,3', 1, '2018-04-15 08:50:29'),
(900, 3, 65, '1,2,3', 1, '2018-04-15 08:50:29'),
(901, 3, 67, '1,2,3', 1, '2018-04-15 08:50:29'),
(902, 3, 68, '1,2,3', 1, '2018-04-15 08:50:29'),
(903, 3, 66, '1,2,3', 1, '2018-04-15 08:50:29'),
(904, 3, 69, '1,2,3', 1, '2018-04-15 08:50:29'),
(905, 3, 70, '1,2,3', 1, '2018-04-15 08:50:29'),
(906, 3, 71, '1,2,3', 1, '2018-04-15 08:50:29'),
(907, 3, 72, '1,2,3', 1, '2018-04-15 08:50:29'),
(908, 3, 73, '1,2,3', 1, '2018-04-15 08:50:29'),
(909, 3, 74, '1,2,3', 1, '2018-04-15 08:50:29'),
(910, 3, 4, '1,2,3', 1, '2018-04-15 08:50:29'),
(911, 3, 5, '1,2,3', 1, '2018-04-15 08:50:29'),
(912, 3, 10, '1,2,3', 1, '2018-04-15 08:50:29'),
(913, 3, 11, '1,2,3', 1, '2018-04-15 08:50:29'),
(914, 3, 12, '1,2,3', 1, '2018-04-15 08:50:29'),
(915, 3, 22, '1,2,3', 1, '2018-04-15 08:50:29'),
(916, 3, 13, '1,2,3', 1, '2018-04-15 08:50:29'),
(917, 3, 14, '1,2,3', 1, '2018-04-15 08:50:29'),
(918, 3, 17, '1,2,3', 1, '2018-04-15 08:50:29'),
(919, 3, 18, '1,2,3', 1, '2018-04-15 08:50:29'),
(920, 3, 19, '1,2,3', 1, '2018-04-15 08:50:29'),
(921, 3, 34, '1,2,3', 1, '2018-04-15 08:50:29'),
(922, 3, 47, '1,2,3', 1, '2018-04-15 08:50:29'),
(923, 3, 31, '1,2,3', 1, '2018-04-15 08:50:29'),
(924, 3, 32, '1,2,3', 1, '2018-04-15 08:50:29'),
(925, 3, 33, '1,2,3', 1, '2018-04-15 08:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zone`
--

CREATE TABLE `tbl_zone` (
  `zone_id` int(11) NOT NULL,
  `zone_name` varchar(50) NOT NULL,
  `zone_code` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_zone`
--

INSERT INTO `tbl_zone` (`zone_id`, `zone_name`, `zone_code`, `status`) VALUES
(1, 'Narayangonj', 1, 1),
(2, 'Comilla', 2, 1),
(3, 'Dhaka', 3, 1),
(4, 'Chadpur', 4, 1),
(5, 'Chittagonj', 5, 1),
(6, 'Rajshahi', 6, 1),
(7, 'Head Office', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_training_info`
--
ALTER TABLE `emp_training_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_actions`
--
ALTER TABLE `tbl_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_admin_user_role`
--
ALTER TABLE `tbl_admin_user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_appointment_info`
--
ALTER TABLE `tbl_appointment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_appointment_letter`
--
ALTER TABLE `tbl_appointment_letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_area`
--
ALTER TABLE `tbl_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_board`
--
ALTER TABLE `tbl_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_board_university`
--
ALTER TABLE `tbl_board_university`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`br_id`);

--
-- Indexes for table `tbl_crime`
--
ALTER TABLE `tbl_crime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_degree_level`
--
ALTER TABLE `tbl_degree_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_demotion`
--
ALTER TABLE `tbl_demotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_district`
--
ALTER TABLE `tbl_district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_edms_category`
--
ALTER TABLE `tbl_edms_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_edms_document`
--
ALTER TABLE `tbl_edms_document`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `tbl_edms_subcategory`
--
ALTER TABLE `tbl_edms_subcategory`
  ADD PRIMARY KEY (`subcat_id`);

--
-- Indexes for table `tbl_emp_basic_info`
--
ALTER TABLE `tbl_emp_basic_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- Indexes for table `tbl_emp_education`
--
ALTER TABLE `tbl_emp_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_edu_info`
--
ALTER TABLE `tbl_emp_edu_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_exp_info`
--
ALTER TABLE `tbl_emp_exp_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_general_info`
--
ALTER TABLE `tbl_emp_general_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_neces_phone`
--
ALTER TABLE `tbl_emp_neces_phone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_other`
--
ALTER TABLE `tbl_emp_other`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_photo`
--
ALTER TABLE `tbl_emp_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_ref_info`
--
ALTER TABLE `tbl_emp_ref_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_salary`
--
ALTER TABLE `tbl_emp_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_training`
--
ALTER TABLE `tbl_emp_training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_training_detail`
--
ALTER TABLE `tbl_emp_training_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_training_result`
--
ALTER TABLE `tbl_emp_training_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_train_info`
--
ALTER TABLE `tbl_emp_train_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_exam_name`
--
ALTER TABLE `tbl_exam_name`
  ADD PRIMARY KEY (`exam_code`);

--
-- Indexes for table `tbl_experience_info`
--
ALTER TABLE `tbl_experience_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_financial_year`
--
ALTER TABLE `tbl_financial_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_grade`
--
ALTER TABLE `tbl_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_group_subject`
--
ALTER TABLE `tbl_group_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_heldup`
--
ALTER TABLE `tbl_heldup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_increment`
--
ALTER TABLE `tbl_increment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_increment_letter`
--
ALTER TABLE `tbl_increment_letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_increment_letter_body`
--
ALTER TABLE `tbl_increment_letter_body`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_increment_letter_emp`
--
ALTER TABLE `tbl_increment_letter_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_leave_balance`
--
ALTER TABLE `tbl_leave_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_leave_history`
--
ALTER TABLE `tbl_leave_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_leave_type`
--
ALTER TABLE `tbl_leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_tran`
--
ALTER TABLE `tbl_master_tran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movement_register`
--
ALTER TABLE `tbl_movement_register`
  ADD PRIMARY KEY (`move_id`);

--
-- Indexes for table `tbl_navbar`
--
ALTER TABLE `tbl_navbar`
  ADD PRIMARY KEY (`nav_id`);

--
-- Indexes for table `tbl_navbar_group`
--
ALTER TABLE `tbl_navbar_group`
  ADD PRIMARY KEY (`nav_group_id`);

--
-- Indexes for table `tbl_necessary_phone_no`
--
ALTER TABLE `tbl_necessary_phone_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_offfice_order`
--
ALTER TABLE `tbl_offfice_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_ogranization`
--
ALTER TABLE `tbl_ogranization`
  ADD PRIMARY KEY (`org_id`);

--
-- Indexes for table `tbl_permanent`
--
ALTER TABLE `tbl_permanent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_probation`
--
ALTER TABLE `tbl_probation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sarok_no` (`sarok_no`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- Indexes for table `tbl_promotion`
--
ALTER TABLE `tbl_promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_punishment`
--
ALTER TABLE `tbl_punishment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_punishment_type`
--
ALTER TABLE `tbl_punishment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reference`
--
ALTER TABLE `tbl_reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_resignation`
--
ALTER TABLE `tbl_resignation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_result`
--
ALTER TABLE `tbl_result`
  ADD PRIMARY KEY (`result_id`);

--
-- Indexes for table `tbl_salary_adjustment`
--
ALTER TABLE `tbl_salary_adjustment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salary_minus`
--
ALTER TABLE `tbl_salary_minus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salary_plus`
--
ALTER TABLE `tbl_salary_plus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sarok`
--
ALTER TABLE `tbl_sarok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_scale`
--
ALTER TABLE `tbl_scale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_staff_security`
--
ALTER TABLE `tbl_staff_security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_thana`
--
ALTER TABLE `tbl_thana`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transections`
--
ALTER TABLE `tbl_transections`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transfer_remarks`
--
ALTER TABLE `tbl_transfer_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_permissions`
--
ALTER TABLE `tbl_user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_zone`
--
ALTER TABLE `tbl_zone`
  ADD PRIMARY KEY (`zone_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_training_info`
--
ALTER TABLE `emp_training_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_actions`
--
ALTER TABLE `tbl_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_admin_user_role`
--
ALTER TABLE `tbl_admin_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_appointment_info`
--
ALTER TABLE `tbl_appointment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_appointment_letter`
--
ALTER TABLE `tbl_appointment_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_area`
--
ALTER TABLE `tbl_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_board`
--
ALTER TABLE `tbl_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_board_university`
--
ALTER TABLE `tbl_board_university`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `br_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `tbl_crime`
--
ALTER TABLE `tbl_crime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_degree_level`
--
ALTER TABLE `tbl_degree_level`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_demotion`
--
ALTER TABLE `tbl_demotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_district`
--
ALTER TABLE `tbl_district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_edms_category`
--
ALTER TABLE `tbl_edms_category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_edms_document`
--
ALTER TABLE `tbl_edms_document`
  MODIFY `document_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_edms_subcategory`
--
ALTER TABLE `tbl_edms_subcategory`
  MODIFY `subcat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_emp_basic_info`
--
ALTER TABLE `tbl_emp_basic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_emp_education`
--
ALTER TABLE `tbl_emp_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_edu_info`
--
ALTER TABLE `tbl_emp_edu_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_exp_info`
--
ALTER TABLE `tbl_emp_exp_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_general_info`
--
ALTER TABLE `tbl_emp_general_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_neces_phone`
--
ALTER TABLE `tbl_emp_neces_phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_other`
--
ALTER TABLE `tbl_emp_other`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_photo`
--
ALTER TABLE `tbl_emp_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_ref_info`
--
ALTER TABLE `tbl_emp_ref_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_salary`
--
ALTER TABLE `tbl_emp_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_emp_training`
--
ALTER TABLE `tbl_emp_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_training_detail`
--
ALTER TABLE `tbl_emp_training_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_training_result`
--
ALTER TABLE `tbl_emp_training_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_train_info`
--
ALTER TABLE `tbl_emp_train_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_exam_name`
--
ALTER TABLE `tbl_exam_name`
  MODIFY `exam_code` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_experience_info`
--
ALTER TABLE `tbl_experience_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_financial_year`
--
ALTER TABLE `tbl_financial_year`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_grade`
--
ALTER TABLE `tbl_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tbl_group_subject`
--
ALTER TABLE `tbl_group_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tbl_heldup`
--
ALTER TABLE `tbl_heldup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_increment`
--
ALTER TABLE `tbl_increment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_increment_letter`
--
ALTER TABLE `tbl_increment_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_increment_letter_body`
--
ALTER TABLE `tbl_increment_letter_body`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_increment_letter_emp`
--
ALTER TABLE `tbl_increment_letter_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_leave_balance`
--
ALTER TABLE `tbl_leave_balance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_leave_history`
--
ALTER TABLE `tbl_leave_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_leave_type`
--
ALTER TABLE `tbl_leave_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_master_tran`
--
ALTER TABLE `tbl_master_tran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_movement_register`
--
ALTER TABLE `tbl_movement_register`
  MODIFY `move_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_navbar`
--
ALTER TABLE `tbl_navbar`
  MODIFY `nav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tbl_navbar_group`
--
ALTER TABLE `tbl_navbar_group`
  MODIFY `nav_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_necessary_phone_no`
--
ALTER TABLE `tbl_necessary_phone_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_offfice_order`
--
ALTER TABLE `tbl_offfice_order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_ogranization`
--
ALTER TABLE `tbl_ogranization`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_permanent`
--
ALTER TABLE `tbl_permanent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_probation`
--
ALTER TABLE `tbl_probation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_promotion`
--
ALTER TABLE `tbl_promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_punishment`
--
ALTER TABLE `tbl_punishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_punishment_type`
--
ALTER TABLE `tbl_punishment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_reference`
--
ALTER TABLE `tbl_reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_resignation`
--
ALTER TABLE `tbl_resignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_result`
--
ALTER TABLE `tbl_result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_salary_adjustment`
--
ALTER TABLE `tbl_salary_adjustment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_salary_minus`
--
ALTER TABLE `tbl_salary_minus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_salary_plus`
--
ALTER TABLE `tbl_salary_plus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_sarok`
--
ALTER TABLE `tbl_sarok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_scale`
--
ALTER TABLE `tbl_scale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `tbl_staff_security`
--
ALTER TABLE `tbl_staff_security`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_thana`
--
ALTER TABLE `tbl_thana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT for table `tbl_transections`
--
ALTER TABLE `tbl_transections`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transfer_remarks`
--
ALTER TABLE `tbl_transfer_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_permissions`
--
ALTER TABLE `tbl_user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=926;

--
-- AUTO_INCREMENT for table `tbl_zone`
--
ALTER TABLE `tbl_zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
