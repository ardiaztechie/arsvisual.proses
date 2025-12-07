-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 11:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ars_visual`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin ARS Visual', 'admin@arsvisual.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(3, 'Admin ARS Visual 2', 'admin@arsvisual2.com', '$2y$10$MzkWaMcu0ZL5Bwczl6elMO4DW7VM4RrPB8OYlBd/9wDdv52JJV.uW', '2025-12-06 05:26:14', '2025-12-06 05:26:14');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `dashboard_stats`
-- (See below for the actual view)
--
CREATE TABLE `dashboard_stats` (
`total_portfolio` bigint(21)
,`total_photos` bigint(21)
,`total_videos` bigint(21)
,`total_messages` bigint(21)
,`new_messages` bigint(21)
,`read_messages` bigint(21)
,`replied_messages` bigint(21)
,`total_testimonials` bigint(21)
,`active_team_members` bigint(21)
,`unique_customers` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `service` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `service`, `message`, `event_date`, `location`, `status`, `created_at`) VALUES
(1, 'John Doe', 'john@example.com', '081234567890', 'wedding', 'Saya ingin booking untuk pernikahan tanggal 15 Juni 2025. Mohon info paket dan harga.', NULL, NULL, 'new', '2025-12-06 04:47:33'),
(2, 'Jane Smith', 'jane@example.com', '081234567891', 'corporate', 'Butuh video company profile untuk perusahaan kami. Estimasi budget berapa?', NULL, NULL, 'read', '2025-12-06 04:47:33'),
(3, 'Michael Brown', 'michael@example.com', '081234567892', 'event', 'Event gathering perusahaan bulan depan, butuh dokumentasi foto dan video.', NULL, NULL, 'new', '2025-12-06 04:47:33'),
(4, 'Lisa Wong', 'lisa@example.com', '081234567893', 'product', 'Butuh foto produk untuk katalog online shop. Ada paket per item?', NULL, NULL, 'replied', '2025-12-06 04:47:33'),
(5, 'David Chen', 'david@example.com', '081234567894', 'aerial', 'Tertarik untuk aerial photography untuk property marketing.', NULL, NULL, 'new', '2025-12-06 04:47:33');

-- --------------------------------------------------------

--
-- Stand-in structure for view `monthly_stats`
-- (See below for the actual view)
--
CREATE TABLE `monthly_stats` (
`month` varchar(7)
,`total_messages` bigint(21)
,`unique_customers` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('foto','video') NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `title`, `category`, `description`, `thumbnail`, `file_url`, `created_at`, `updated_at`) VALUES
(1, 'Elegant Wedding Ceremony', 'foto', 'Beautiful outdoor wedding at sunset with stunning decoration', 'travel/asset/seminar.jpg', 'travel/asset/seminar.jpg', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(2, 'Corporate Event Documentation', 'foto', 'Annual company gathering and team building event', 'travel/asset/eventcof.png', 'travel/asset/eventcof.png', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(3, 'Product Photography Session', 'foto', 'Professional product showcase with perfect lighting', 'travel/asset/produkfotografi.png', 'travel/asset/produkfotografi.png', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(4, 'Prewedding Photoshoot', 'foto', 'Romantic prewedding session at the beach', 'travel/asset/weding 1.png', 'travel/asset/weding 1.png', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(5, 'Drone Photography', 'foto', 'Spectacular aerial view of landscape', 'travel/asset/drone.png', 'travel/asset/drone.png', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(6, 'Wedding Highlight Video', 'video', 'Cinematic wedding coverage with emotional moments', 'https://img.youtube.com/vi/rbftAwpr2-U/maxresdefault.jpg', 'https://www.youtube.com/watch?v=rbftAwpr2-U', '2025-12-06 04:47:33', '2025-12-06 04:47:33'),
(7, 'Corporate Profile Video', 'video', 'Professional company introduction and brand story', 'https://img.youtube.com/vi/_BSjj1IZQJQ/maxresdefault.jpg', 'https://www.youtube.com/watch?v=_BSjj1IZQJQ', '2025-12-06 04:47:33', '2025-12-06 04:47:33');

-- --------------------------------------------------------

--
-- Stand-in structure for view `recent_activities`
-- (See below for the actual view)
--
CREATE TABLE `recent_activities` (
`activity_type` varchar(15)
,`activity_desc` varchar(263)
,`activity_time` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `description` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `updated_at`) VALUES
(1, 'site_name', 'ARS Visual', 'text', 'Website name', '2025-12-06 04:47:33'),
(2, 'site_email', 'info@arsvisual.com', 'email', 'Contact email', '2025-12-06 04:47:33'),
(3, 'site_phone', '+62 812-3456-7890', 'text', 'Contact phone', '2025-12-06 04:47:33'),
(4, 'site_address', 'Jl. Fotografi No. 123, Geneneg, Ngawi, Jawa Timur', 'text', 'Office address', '2025-12-06 04:47:33'),
(5, 'instagram_url', 'https://instagram.com/arsvisual', 'url', 'Instagram profile', '2025-12-06 04:47:33'),
(6, 'facebook_url', 'https://facebook.com/arsvisual', 'url', 'Facebook page', '2025-12-06 04:47:33'),
(7, 'youtube_url', 'https://youtube.com/@arsvisual', 'url', 'YouTube channel', '2025-12-06 04:47:33'),
(8, 'whatsapp_number', '6281234567890', 'text', 'WhatsApp business number', '2025-12-06 04:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'travel/asset/arsf.png',
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `order_position` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `role`, `bio`, `photo`, `instagram`, `linkedin`, `facebook`, `twitter`, `order_position`, `is_active`, `created_at`) VALUES
(1, 'Dian Eko Wahyudi', 'Lead Photographer', 'Spesialisasi dalam wedding dan portrait photography dengan pengalaman 8 tahun di industri. Telah mengabadikan lebih dari 200 pernikahan.', 'travel/asset/arsf.png', 'https://instagram.com/dianeko', NULL, NULL, NULL, 1, 1, '2025-12-06 04:47:33'),
(2, 'Ardiaz A.S', 'Creative Director', 'Mengarahkan konsep kreatif dan memastikan setiap project memiliki storytelling yang kuat. Expert dalam visual branding.', 'travel/asset/ardi.jpeg', 'https://instagram.com/ardiaz', NULL, NULL, NULL, 2, 1, '2025-12-06 04:47:33'),
(3, 'Ardhi Setiawan', 'Videographer', 'Expert dalam cinematic videography dan post-production editing menggunakan Adobe Premiere Pro dan DaVinci Resolve.', 'travel/asset/Ardhi Setiawan.jpeg', 'https://www.instagram.com/ardhiux_?igsh=cW90bG5sNm4wNTdt', NULL, NULL, NULL, 3, 1, '2025-12-06 04:47:33'),
(4, 'Maretha Hany', 'Social Media Manager', 'Mengelola media sosial dan menciptakan konten menarik yang memperkuat identitas serta interaksi brand dengan audiens.', 'travel/asset/arsf.png', 'https://instagram.com/maretha', NULL, NULL, NULL, 4, 1, '2025-12-06 04:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `photo` varchar(255) DEFAULT 'travel/asset/arsf.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `city`, `review`, `photo`, `created_at`) VALUES
(1, 'Rina & Dimas', 'Jakarta', 'ARS Visual berhasil mengabadikan hari pernikahan kami dengan sempurna. Hasilnya melebihi ekspektasi! Tim yang profesional dan ramah membuat kami merasa nyaman selama sesi foto.', 'travel/asset/arsf.png', '2025-12-06 04:47:33'),
(2, 'PT. Maju Jaya Indonesia', 'Surabaya', 'Video company profile yang dibuat sangat berkualitas dan profesional. Sangat membantu untuk marketing perusahaan kami. Response time cepat dan hasil memuaskan!', 'travel/asset/arsf.png', '2025-12-06 04:47:33'),
(3, 'Sarah & Budi Santoso', 'Bandung', 'Fotografer yang sangat berpengalaman dan sabar. Hasil foto prewedding kami luar biasa indah! Tempat yang direkomendasikan juga sangat instagramable.', 'travel/asset/arsf.png', '2025-12-06 04:47:33'),
(4, 'CV. Kreatif Indonesia', 'Yogyakarta', 'Event documentation yang detail dan lengkap. Recommended untuk acara korporat! Semua moment penting tertangkap dengan baik.', 'travel/asset/arsf.png', '2025-12-06 04:47:33'),
(5, 'Andi & Siti Nurhaliza', 'Semarang', 'Tim ARS Visual sangat profesional dan kreatif. Hasil video wedding kami seperti film Hollywood! Editing dan color grading nya top banget!', 'travel/asset/arsf.png', '2025-12-06 04:47:33'),
(6, 'Michael & Jessica', 'Bali', 'Amazing service! The team captured every beautiful moment of our destination wedding. Highly recommended for international clients!', 'travel/asset/arsf.png', '2025-12-06 04:47:33'),
(7, 'Dewi Lestari', 'Malang', 'Foto produk untuk online shop saya jadi lebih menarik. Sales meningkat setelah pakai jasa ARS Visual. Worth it!', 'travel/asset/arsf.png', '2025-12-06 04:47:33');

-- --------------------------------------------------------

--
-- Structure for view `dashboard_stats`
--
DROP TABLE IF EXISTS `dashboard_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `dashboard_stats`  AS SELECT (select count(0) from `portfolio`) AS `total_portfolio`, (select count(0) from `portfolio` where `portfolio`.`category` = 'foto') AS `total_photos`, (select count(0) from `portfolio` where `portfolio`.`category` = 'video') AS `total_videos`, (select count(0) from `messages`) AS `total_messages`, (select count(0) from `messages` where `messages`.`status` = 'new') AS `new_messages`, (select count(0) from `messages` where `messages`.`status` = 'read') AS `read_messages`, (select count(0) from `messages` where `messages`.`status` = 'replied') AS `replied_messages`, (select count(0) from `testimonials`) AS `total_testimonials`, (select count(0) from `team` where `team`.`is_active` = 1) AS `active_team_members`, (select count(distinct `messages`.`email`) from `messages`) AS `unique_customers` ;

-- --------------------------------------------------------

--
-- Structure for view `monthly_stats`
--
DROP TABLE IF EXISTS `monthly_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `monthly_stats`  AS SELECT date_format(`messages`.`created_at`,'%Y-%m') AS `month`, count(0) AS `total_messages`, count(distinct `messages`.`email`) AS `unique_customers` FROM `messages` GROUP BY date_format(`messages`.`created_at`,'%Y-%m') ORDER BY date_format(`messages`.`created_at`,'%Y-%m') DESC ;

-- --------------------------------------------------------

--
-- Structure for view `recent_activities`
--
DROP TABLE IF EXISTS `recent_activities`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `recent_activities`  AS SELECT 'New Message' AS `activity_type`, concat(`messages`.`name`,' - ',`messages`.`service`) AS `activity_desc`, `messages`.`created_at` AS `activity_time` FROM `messages` WHERE `messages`.`created_at` >= current_timestamp() - interval 7 dayunion allselect 'New Portfolio' AS `activity_type`,concat(`portfolio`.`title`,' (',`portfolio`.`category`,')') AS `activity_desc`,`portfolio`.`created_at` AS `activity_time` from `portfolio` where `portfolio`.`created_at` >= current_timestamp() - interval 7 day union all select 'New Testimonial' AS `activity_type`,concat(`testimonials`.`name`,' from ',`testimonials`.`city`) AS `activity_desc`,`testimonials`.`created_at` AS `activity_time` from `testimonials` where `testimonials`.`created_at` >= current_timestamp() - interval 7 day order by `activity_time` desc limit 20  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_key` (`setting_key`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order` (`order_position`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
