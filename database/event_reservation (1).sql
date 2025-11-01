-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 12:12 AM
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
-- Database: `event_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_type` varchar(100) NOT NULL,
  `event_specific_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`event_specific_details`)),
  `total_expected_guests` int(11) NOT NULL DEFAULT 0,
  `attendee_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attendee_categories`)),
  `menu_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`menu_items`)),
  `decorations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`decorations`)),
  `sound` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sound`)),
  `total_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('PENDING','ACCEPT','DECLINE') DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `name`, `contact_number`, `address`, `event_date`, `event_time`, `event_type`, `event_specific_details`, `total_expected_guests`, `attendee_categories`, `menu_items`, `decorations`, `sound`, `total_cost`, `status`, `created_at`, `updated_at`) VALUES
(32, 27, 'Joshua Dizon', '09217296202', 'Zone 3 Unzad Villasis, Pangasinan', '2025-10-27', '08:00:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 75, '{\"Family\":25,\"Friends\":10,\"Colleagues\":15,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"price\":85,\"quantity\":1},{\"name\":\"Tamarind-Glazed Chicken wings\",\"price\":110,\"quantity\":1},{\"name\":\"Spaghetti\",\"price\":120,\"quantity\":3}]', '[{\"name\":\"Roses\",\"price\":400,\"quantity\":1},{\"name\":\"Tulips\",\"price\":350,\"quantity\":1}]', '[{\"name\":\"Basic Audio\",\"price\":1000,\"quantity\":1}]', 2305.00, 'ACCEPT', '2025-10-26 12:53:22', '2025-10-26 13:49:37'),
(33, 27, 'Joline Dizon', '09217296202', 'Zone 3 Unzad Villasis, Pangasinan', '2025-10-28', '21:00:00', 'Birthday', '{\"celebrant_name\":\"Joline\",\"age_type\":\"Years\",\"age_value\":\"19\"}', 20, '{\"Family\":10,\"Friends\":0,\"Colleagues\":5,\"VIP Guests\":5}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":2,\"price\":110}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350}]', '[{\"name\":\"Basic Audio\",\"price\":1000},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Clown\",\"price\":400}]', 3255.00, 'ACCEPT', '2025-10-26 13:54:17', '2025-10-26 13:59:18'),
(34, 27, 'Jasper Dizon', '09217296202', 'Unzad', '2025-11-01', '22:00:00', 'Graduation', '{\"graduate_name\":\"pola aw aw\",\"degree\":\"bsit\"}', 1, '{\"Family\":1,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":2,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":2,\"price\":110}]', '[]', '[{\"name\":\"Basic Audio\",\"price\":1000},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Live Band\",\"price\":1500}]', 3690.00, 'ACCEPT', '2025-10-26 14:08:03', '2025-10-26 14:08:32'),
(35, 27, 'Park Jeongwoo', '12345678910', 'South Korea', '2026-09-28', '18:30:00', 'Birthday', '{\"celebrant_name\":\"Park Jeongwoo\",\"age_type\":\"Years\",\"age_value\":\"22\"}', 50, '{\"Family\":3,\"Friends\":10,\"Colleagues\":28,\"VIP Guests\":9}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"price\":85,\"quantity\":2},{\"name\":\"Tamarind-Glazed Chicken wings\",\"price\":110,\"quantity\":2},{\"name\":\"Kesong Puti Caprese Skewers\",\"price\":90,\"quantity\":2},{\"name\":\"Prawn Cocktails\",\"price\":130,\"quantity\":2},{\"name\":\"Stuffed Mushroom\",\"price\":95,\"quantity\":2},{\"name\":\"French Onion dip cups\",\"price\":80,\"quantity\":2},{\"name\":\"Cheese Broccoli Puffs\",\"price\":85,\"quantity\":1},{\"name\":\"Spanish Tortilla\",\"price\":100,\"quantity\":2},{\"name\":\"Spaghetti\",\"price\":120,\"quantity\":5},{\"name\":\"Shrimp Carbonara Pasta\",\"price\":150,\"quantity\":5},{\"name\":\"Honey Glazed Salmon with Rice\",\"price\":230,\"quantity\":5},{\"name\":\"Beef Metchado with Rice\",\"price\":180,\"quantity\":5},{\"name\":\"Curried Chicken and Rice Casserole\",\"price\":160,\"quantity\":5},{\"name\":\"Cordon Bleu\",\"price\":170,\"quantity\":5},{\"name\":\"Lemon and Garlic Roast Chicken\",\"price\":160,\"quantity\":5},{\"name\":\"Beef Wellington\",\"price\":3888,\"quantity\":5},{\"name\":\"Beer Braised Beef with Clams\",\"price\":220,\"quantity\":5},{\"name\":\"Royal Select\",\"price\":180,\"quantity\":5},{\"name\":\"Wine Selection\",\"price\":200,\"quantity\":5},{\"name\":\"Chivas Regal\",\"price\":230,\"quantity\":5},{\"name\":\"Premium Bar Package\",\"price\":250,\"quantity\":5},{\"name\":\"Jack Daniels\",\"price\":220,\"quantity\":5},{\"name\":\"Cheese Stuffed Crispy Potato\",\"price\":85,\"quantity\":20}]', '[{\"name\":\"Peonies\",\"price\":500,\"quantity\":1},{\"name\":\"Dahlia\",\"price\":320,\"quantity\":1},{\"name\":\"Fairy light Canopy\",\"price\":2500,\"quantity\":1},{\"name\":\"Dance floor Illumination\",\"price\":1800,\"quantity\":1},{\"name\":\"Balloon Arrangement (Party)\",\"price\":1500,\"quantity\":1},{\"name\":\"Light Up Letters\",\"price\":3000,\"quantity\":1},{\"name\":\"Photo Booth Corner\",\"price\":1100,\"quantity\":1},{\"name\":\"Disco Ball and lights\",\"price\":1000,\"quantity\":1},{\"name\":\"Memory Wall\",\"price\":900,\"quantity\":1},{\"name\":\"Crystal Curtain\",\"price\":1800,\"quantity\":1},{\"name\":\"Feather Centerpiece\",\"price\":1200,\"quantity\":1}]', '[{\"name\":\"Basic Audio\",\"price\":1000,\"quantity\":1}]', 51575.00, 'ACCEPT', '2025-10-26 14:21:19', '2025-10-26 14:22:48'),
(36, 27, 'Josh', '0912345678', 'South Korea', '2025-10-25', '22:00:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 60, '{\"Family\":20,\"Friends\":20,\"Colleagues\":20,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"price\":85,\"quantity\":1},{\"name\":\"Tamarind-Glazed Chicken wings\",\"price\":110,\"quantity\":1},{\"name\":\"Kesong Puti Caprese Skewers\",\"price\":90,\"quantity\":1},{\"name\":\"Prawn Cocktails\",\"price\":130,\"quantity\":1},{\"name\":\"Stuffed Mushroom\",\"price\":95,\"quantity\":1},{\"name\":\"French Onion dip cups\",\"price\":80,\"quantity\":1},{\"name\":\"Cheese Broccoli Puffs\",\"price\":85,\"quantity\":1},{\"name\":\"Spanish Tortilla\",\"price\":100,\"quantity\":1},{\"name\":\"Proscuitto-Wrapped Melon\",\"price\":120,\"quantity\":1},{\"name\":\"Buckeye Bundt Cake\",\"price\":110,\"quantity\":1},{\"name\":\"Cake Pops\",\"price\":85,\"quantity\":1},{\"name\":\"Cheese Cake\",\"price\":120,\"quantity\":20}]', '[]', '[{\"name\":\"Basic Audio\",\"price\":1000,\"quantity\":1},{\"name\":\"MCs (Host)\",\"price\":800,\"quantity\":1},{\"name\":\"Live Band\",\"price\":1500,\"quantity\":1}]', 6790.00, 'DECLINE', '2025-10-26 14:28:30', '2025-10-26 14:29:20'),
(37, 27, 'Joshua Dizon', '0912345678', 'Unzad', '2025-10-31', '10:58:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 0, '{\"Family\":0,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":2,\"price\":85}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350}]', '[{\"name\":\"Standard System\",\"price\":1800},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Live Band\",\"price\":1500}]', 5020.00, 'ACCEPT', '2025-10-26 14:58:59', '2025-10-28 05:25:59'),
(38, 27, 'Josh', '0912345678', 'Unzad', '2025-10-31', '03:54:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 2, '{\"Family\":1,\"Friends\":0,\"Colleagues\":1,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":1,\"price\":110},{\"name\":\"Kesong Puti Caprese Skewers\",\"quantity\":1,\"price\":90},{\"name\":\"Prawn Cocktails\",\"quantity\":1,\"price\":130}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350},{\"name\":\"Lilies\",\"price\":380},{\"name\":\"Peonies\",\"price\":500},{\"name\":\"Purple Orchid\",\"price\":450},{\"name\":\"Ranunculus\",\"price\":300}]', '[{\"name\":\"Standard System\",\"price\":1800},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Live Band\",\"price\":1500}]', 6895.00, 'ACCEPT', '2025-10-26 19:58:16', '2025-10-27 14:15:44'),
(39, 27, 'Josh', '0912345678', 'Unzad', '2025-10-31', '15:59:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 1, '{\"Family\":1,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":1,\"price\":110},{\"name\":\"Kesong Puti Caprese Skewers\",\"quantity\":1,\"price\":90},{\"name\":\"Prawn Cocktails\",\"quantity\":1,\"price\":130}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350},{\"name\":\"Lilies\",\"price\":380}]', '[]', 1545.00, 'ACCEPT', '2025-10-26 19:59:51', '2025-10-29 05:37:18'),
(40, 34, 'Julian Supeña', '0912345678', 'Unzad', '2025-10-31', '04:02:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 10, '{\"Family\":2,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"price\":85,\"quantity\":2},{\"name\":\"Tamarind-Glazed Chicken wings\",\"price\":110,\"quantity\":2},{\"name\":\"Prawn Cocktails\",\"price\":130,\"quantity\":5},{\"name\":\"Beef Wellington\",\"price\":3888,\"quantity\":1}]', '[{\"name\":\"Fairy light Canopy\",\"price\":2500,\"quantity\":1}]', '[]', 7428.00, 'ACCEPT', '2025-10-26 20:03:25', '2025-10-28 05:25:49'),
(41, 27, 'Joshua Dizon', '0912345678', 'Unzad', '2025-10-31', '08:30:00', 'Birthday', '{\"celebrant_name\":\"Josh\",\"age_type\":\"Years\",\"age_value\":\"22\"}', 1, '{\"Family\":1,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":1,\"price\":110}]', '[]', '[]', 195.00, 'DECLINE', '2025-10-27 00:24:44', '2025-10-28 05:25:55'),
(42, 27, 'Josh', '0912345678', 'Unzad', '2025-10-31', '19:15:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 5, '{\"Family\":2,\"Friends\":1,\"Colleagues\":1,\"VIP Guests\":1}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"price\":85,\"quantity\":1},{\"name\":\"Tamarind-Glazed Chicken wings\",\"price\":110,\"quantity\":1},{\"name\":\"Kesong Puti Caprese Skewers\",\"price\":90,\"quantity\":1},{\"name\":\"Prawn Cocktails\",\"price\":130,\"quantity\":1},{\"name\":\"Stuffed Mushroom\",\"price\":95,\"quantity\":1},{\"name\":\"French Onion dip cups\",\"price\":80,\"quantity\":1},{\"name\":\"Beef Wellington\",\"price\":388,\"quantity\":50}]', '[{\"name\":\"Roses\",\"price\":400,\"quantity\":1},{\"name\":\"Tulips\",\"price\":350,\"quantity\":1},{\"name\":\"Lilies\",\"price\":380,\"quantity\":1},{\"name\":\"Peonies\",\"price\":500,\"quantity\":1}]', '[{\"name\":\"Standard System\",\"price\":1800,\"quantity\":1},{\"name\":\"MCs (Host)\",\"price\":800,\"quantity\":1},{\"name\":\"Live Band\",\"price\":1500,\"quantity\":1}]', 25720.00, 'ACCEPT', '2025-10-27 23:31:51', '2025-10-27 23:33:29'),
(43, 35, 'Andrei', '0912345678', 'Mangatarem', '2026-01-01', '00:00:00', 'Reunion', '{\"group_name\":\"Agacite\",\"occasion\":\"Happy New Year\"}', 20, '{\"Family\":3,\"Friends\":6,\"Colleagues\":2,\"VIP Guests\":9}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":1,\"price\":110},{\"name\":\"Kesong Puti Caprese Skewers\",\"quantity\":1,\"price\":90},{\"name\":\"Prawn Cocktails\",\"quantity\":1,\"price\":130},{\"name\":\"Stuffed Mushroom\",\"quantity\":1,\"price\":95},{\"name\":\"French Onion dip cups\",\"quantity\":1,\"price\":80},{\"name\":\"Cheese Broccoli Puffs\",\"quantity\":1,\"price\":85},{\"name\":\"Spanish Tortilla\",\"quantity\":1,\"price\":100},{\"name\":\"Proscuitto-Wrapped Melon\",\"quantity\":1,\"price\":120},{\"name\":\"Spaghetti\",\"quantity\":1,\"price\":120},{\"name\":\"Shrimp Carbonara Pasta\",\"quantity\":1,\"price\":150},{\"name\":\"Honey Glazed Salmon with Rice\",\"quantity\":1,\"price\":230},{\"name\":\"Beef Metchado with Rice\",\"quantity\":1,\"price\":180},{\"name\":\"Curried Chicken and Rice Casserole\",\"quantity\":1,\"price\":160},{\"name\":\"Cordon Bleu\",\"quantity\":1,\"price\":170},{\"name\":\"Lemon and Garlic Roast Chicken\",\"quantity\":1,\"price\":160},{\"name\":\"Beef Wellington\",\"quantity\":1,\"price\":3888},{\"name\":\"Beer Braised Beef with Clams\",\"quantity\":1,\"price\":220},{\"name\":\"Royal Select\",\"quantity\":1,\"price\":180},{\"name\":\"Wine Selection\",\"quantity\":1,\"price\":200},{\"name\":\"Chivas Regal\",\"quantity\":1,\"price\":230},{\"name\":\"Premium Bar Package\",\"quantity\":1,\"price\":250},{\"name\":\"Jack Daniels\",\"quantity\":1,\"price\":220},{\"name\":\"Cheese Cake\",\"quantity\":1,\"price\":120},{\"name\":\"Tiramisu\",\"quantity\":1,\"price\":130},{\"name\":\"Macaroons\",\"quantity\":1,\"price\":90},{\"name\":\"Cup Cake\",\"quantity\":1,\"price\":80},{\"name\":\"Charcuterie\",\"quantity\":1,\"price\":150},{\"name\":\"Buckeye Bundt Cake\",\"quantity\":1,\"price\":110},{\"name\":\"Cake Pops\",\"quantity\":1,\"price\":85},{\"name\":\"Strawberry Pretzel Salad\",\"quantity\":1,\"price\":100},{\"name\":\"Carrot Cake\",\"quantity\":1,\"price\":115}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350},{\"name\":\"Lilies\",\"price\":380},{\"name\":\"Peonies\",\"price\":500},{\"name\":\"Purple Orchid\",\"price\":450},{\"name\":\"Ranunculus\",\"price\":300},{\"name\":\"Celosia\",\"price\":250},{\"name\":\"Dahlia\",\"price\":320},{\"name\":\"Chrysanthemum\",\"price\":280},{\"name\":\"Fairy light Canopy\",\"price\":2500},{\"name\":\"Up Lighting Glow\",\"price\":500},{\"name\":\"Dance floor Illumination\",\"price\":1800},{\"name\":\"Gobo Lightning\",\"price\":800},{\"name\":\"Chandeliers\",\"price\":1200},{\"name\":\"Mason Jar Light\",\"price\":200},{\"name\":\"Mirror Ball Tunnel\",\"price\":3500},{\"name\":\"Water Ripple Lighting\",\"price\":1500},{\"name\":\"Laser Tunnel Entrance\",\"price\":4000},{\"name\":\"Balloon Arrangement (Party)\",\"price\":1500},{\"name\":\"Balloon Arrangement (Formal)\",\"price\":2500},{\"name\":\"Light Up Letters\",\"price\":3000},{\"name\":\"Photo Booth Corner\",\"price\":1100},{\"name\":\"Disco Ball and lights\",\"price\":1000},{\"name\":\"Memory Wall\",\"price\":900},{\"name\":\"Crystal Curtain\",\"price\":1800},{\"name\":\"Feather Centerpiece\",\"price\":1200},{\"name\":\"Bubble Machine\",\"price\":600}]', '[{\"name\":\"Basic Audio\",\"price\":1000},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Live Band\",\"price\":1500},{\"name\":\"Clown\",\"price\":400}]', 44763.00, 'ACCEPT', '2025-10-28 04:49:22', '2025-10-28 05:08:20'),
(44, 35, 'Andrei', '0912345678', 'Zone 3 Unzad Villasis, Pangasinan', '2026-09-21', '00:00:00', 'Wedding', '{\"groom_name\":\"andrei\",\"bride_name\":\"edmilyn\"}', 21, '{\"Family\":21,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Beer Braised Beef with Clams\",\"quantity\":1,\"price\":220}]', '[{\"name\":\"Roses\",\"price\":400}]', '[{\"name\":\"Premium Package\",\"price\":2500}]', 3120.00, 'ACCEPT', '2025-10-28 04:57:13', '2025-10-28 05:06:58'),
(45, 27, 'Andrei', '0912345678', 'Unzad', '2025-10-31', '14:22:00', 'Christening', '{\"child_name\":\"JJ\",\"godparents\":\"Sir bert\"}', 2, '{\"Family\":2,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":1,\"price\":110},{\"name\":\"Kesong Puti Caprese Skewers\",\"quantity\":1,\"price\":90}]', '[]', '[]', 285.00, 'ACCEPT', '2025-10-28 06:22:30', '2025-10-28 06:22:49'),
(46, 36, 'Luis', '1234567890', 'Mangatarem', '2025-10-29', '10:00:00', 'Christening', '{\"child_name\":\"Luis Jr\",\"godparents\":\"Luis\"}', 9, '{\"Family\":3,\"Friends\":0,\"Colleagues\":6,\"VIP Guests\":0}', '[{\"name\":\"Cheese Cake\",\"quantity\":3,\"price\":120},{\"name\":\"Tiramisu\",\"quantity\":2,\"price\":130},{\"name\":\"Macaroons\",\"quantity\":2,\"price\":90},{\"name\":\"Cup Cake\",\"quantity\":3,\"price\":80},{\"name\":\"Charcuterie\",\"quantity\":3,\"price\":150}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350},{\"name\":\"Lilies\",\"price\":380},{\"name\":\"Fairy light Canopy\",\"price\":2500},{\"name\":\"Up Lighting Glow\",\"price\":500}]', '[{\"name\":\"Premium Package\",\"price\":2500},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Live Band\",\"price\":1500}]', 10420.00, 'ACCEPT', '2025-10-28 12:40:46', '2025-10-28 12:43:10'),
(47, 38, 'Joshua', '0912345678', 'Unzad', '2025-10-29', '22:14:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 4, '{\"Family\":3,\"Friends\":0,\"Colleagues\":1,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":1,\"price\":85},{\"name\":\"Tamarind-Glazed Chicken wings\",\"quantity\":1,\"price\":110}]', '[{\"name\":\"Roses\",\"price\":400},{\"name\":\"Tulips\",\"price\":350},{\"name\":\"Lilies\",\"price\":380},{\"name\":\"Fairy light Canopy\",\"price\":2500},{\"name\":\"Up Lighting Glow\",\"price\":500},{\"name\":\"Dance floor Illumination\",\"price\":1800}]', '[{\"name\":\"Basic Audio\",\"price\":1000},{\"name\":\"MCs (Host)\",\"price\":800},{\"name\":\"Live Band\",\"price\":1500}]', 9425.00, 'ACCEPT', '2025-10-29 05:36:13', '2025-10-29 05:38:31'),
(48, 27, 'Andrei', '0912345678', 'Zone 3 Unzad Villasis, Pangasinan', '2025-10-31', '20:47:00', 'Wedding', '{\"groom_name\":\"Joshua\",\"bride_name\":\"Julian\"}', 0, '{\"Family\":0,\"Friends\":0,\"Colleagues\":0,\"VIP Guests\":0}', '[{\"name\":\"Cheese Stuffed Crispy Potato\",\"quantity\":2,\"price\":85}]', '[]', '[]', 170.00, 'PENDING', '2025-10-29 12:47:33', '2025-10-29 12:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `inbox_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`inbox_id`, `user_id`, `booking_id`, `message`, `is_read`, `created_at`) VALUES
(32, NULL, 32, 'Your booking (ID: 32) has been ACCEPTED! Ok po i accept it', 0, '2025-10-26 12:56:19'),
(33, NULL, 33, 'Your booking (ID: 33) has been ACCEPTED! OK po tanggap namen otw na', 0, '2025-10-26 13:55:07'),
(34, 27, 34, 'Your booking (ID: 34) has been ACCEPTED! Ok fine', 0, '2025-10-26 14:08:32'),
(35, 27, 35, 'Your booking (ID: 35) has been ACCEPTED! OK FINE', 0, '2025-10-26 14:22:48'),
(36, 27, 36, 'Your booking (ID: 36) has been DECLINED. SORRY PO', 0, '2025-10-26 14:29:20'),
(37, 27, 38, 'Your booking (ID: 38) has been ACCEPTED! ', 0, '2025-10-27 14:15:44'),
(38, 27, 42, 'Your booking (ID: 42) has been ACCEPTED! ', 0, '2025-10-27 23:33:29'),
(39, 35, 44, 'Your booking (ID: 44) has been ACCEPTED! ok nigga', 0, '2025-10-28 05:06:58'),
(40, 35, 43, 'Your booking (ID: 43) has been ACCEPTED! nani ohayo', 0, '2025-10-28 05:08:20'),
(41, 34, 40, 'Your booking (ID: 40) has been ACCEPTED! ', 0, '2025-10-28 05:25:49'),
(42, 27, 41, 'Your booking (ID: 41) has been DECLINED. ', 0, '2025-10-28 05:25:55'),
(43, 27, 37, 'Your booking (ID: 37) has been ACCEPTED! ', 0, '2025-10-28 05:25:59'),
(44, 27, 45, 'Your booking (ID: 45) has been ACCEPTED! ', 0, '2025-10-28 06:22:49'),
(45, 36, 46, 'Your booking (ID: 46) has been ACCEPTED! Ok po otw na', 0, '2025-10-28 12:43:10'),
(46, 27, 39, 'Your booking (ID: 39) has been ACCEPTED! Ok po', 0, '2025-10-29 05:37:18'),
(47, 38, 47, 'Your booking (ID: 47) has been ACCEPTED! Ok po', 0, '2025-10-29 05:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(400) NOT NULL,
  `password` varchar(550) NOT NULL,
  `role` enum('user','owner') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'Admin@12345', '$2y$10$VS71QTysGTP0pBMqHKhhsucNHMIZym4tgBqgyFfB4yaV9vcwieOGe', 'owner'),
(27, 'Joshua Dizon', '$2y$10$.Mr5Mv5sWUsF9gxotKHCjOPeoRt9g2Q0cgvwJX9rFQUDmVGs74May', 'user'),
(34, 'Julian', '$2y$10$c0Yu6vYAUiT9f1q62e4N7eABPzpqTURTk0weVEdaUxljJLvlRWMo2', 'user'),
(35, 'Andrei', '$2y$10$hrEh4k3GYhheiF1H/8.gjenP89Tp4ixL5u3erkU5etcb2nFdjVkNG', 'user'),
(36, 'Luis', '$2y$10$1Epjc5DIUxv4aC3igletI.DgBHqNUfg0gPawY5fUXO3ReYmiT4t5i', 'user'),
(37, 'Joshuaa', '$2y$10$0uh4jY52OQJFg0r71lCojuOS54QtXsDnEtr1ITqDWp3QEmYSRT19u', 'user'),
(38, 'Joshu', '$2y$10$3P0jKDfhG1zk2PyUofR24..c3.xaCAp1DG4GPisShh72MdybNuuC6', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`inbox_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `inbox_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
