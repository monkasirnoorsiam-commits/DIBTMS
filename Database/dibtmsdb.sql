-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2025 at 10:46 AM
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
-- Database: `dibtmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ad_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ad_id`) VALUES
(100001),
(100002),
(100003);

-- --------------------------------------------------------

--
-- Table structure for table `bus_managers`
--

CREATE TABLE `bus_managers` (
  `m_id` int(6) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_managers`
--

INSERT INTO `bus_managers` (`m_id`, `salary`) VALUES
(200001, 60000);

-- --------------------------------------------------------

--
-- Table structure for table `bus_seats`
--

CREATE TABLE `bus_seats` (
  `bus_no` int(6) NOT NULL,
  `seat_no` int(2) NOT NULL,
  `vacant` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_seats`
--

INSERT INTO `bus_seats` (`bus_no`, `seat_no`, `vacant`) VALUES
(1001, 1, 0),
(1001, 2, 1),
(1001, 3, 1),
(1001, 4, 1),
(1001, 5, 1),
(1001, 6, 1),
(1001, 7, 1),
(1001, 8, 1),
(1001, 9, 1),
(1001, 10, 1),
(1002, 1, 1),
(1002, 2, 1),
(1002, 3, 1),
(1002, 4, 1),
(1002, 5, 1),
(1002, 6, 1),
(1002, 7, 1),
(1002, 8, 1),
(1002, 9, 1),
(1002, 10, 1),
(1002, 11, 1),
(1002, 12, 1),
(1002, 13, 1),
(1002, 14, 1),
(1002, 15, 1),
(1002, 16, 1),
(1002, 17, 1),
(1002, 18, 1),
(1002, 19, 1),
(1002, 20, 1),
(1002, 21, 1),
(1002, 22, 1),
(1002, 23, 1),
(1002, 24, 1),
(1002, 25, 1),
(1002, 26, 1),
(1002, 27, 1),
(1002, 28, 1),
(1002, 29, 1),
(1002, 30, 1),
(1001, 11, 1),
(1001, 12, 1),
(1001, 13, 1),
(1001, 14, 1),
(1001, 15, 1),
(1001, 16, 1),
(1001, 17, 1),
(1001, 18, 1),
(1001, 19, 1),
(1001, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bus_service`
--

CREATE TABLE `bus_service` (
  `bus_no` int(6) NOT NULL,
  `m_id` int(6) NOT NULL,
  `type` varchar(20) NOT NULL,
  `total_seats` int(99) NOT NULL,
  `description` varchar(100) NOT NULL,
  `cost` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_service`
--

INSERT INTO `bus_service` (`bus_no`, `m_id`, `type`, `total_seats`, `description`, `cost`) VALUES
(1001, 200001, 'AC', 20, 'Gulshan - Dhanmondi - Banani - Uttara Premium Service ', 100),
(1002, 200001, 'Non-AC', 30, 'Gulistan - Mohammadpur - Puran Dhaka - Mohakhali Regular Service', 50);

-- --------------------------------------------------------

--
-- Table structure for table `manages`
--

CREATE TABLE `manages` (
  `m_id` int(6) NOT NULL,
  `ad_id` int(6) NOT NULL,
  `assigned_duties` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `p_id` int(6) NOT NULL,
  `discount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`p_id`, `discount`) VALUES
(300001, 0.05),
(300002, 0.05);

-- --------------------------------------------------------

--
-- Table structure for table `payment_options`
--

CREATE TABLE `payment_options` (
  `p_id` int(6) NOT NULL,
  `banking_service_name` varchar(20) NOT NULL,
  `acc_number` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_options`
--

INSERT INTO `payment_options` (`p_id`, `banking_service_name`, `acc_number`, `amount`) VALUES
(300001, 'Nagad', '01716498488', 4905);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `p_id` int(6) NOT NULL,
  `bus_no` int(6) NOT NULL,
  `comments` varchar(100) NOT NULL,
  `ratings` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride_history`
--

CREATE TABLE `ride_history` (
  `p_id` int(6) NOT NULL,
  `bus_no` int(6) NOT NULL,
  `start_from` varchar(50) NOT NULL,
  `end_at` varchar(50) NOT NULL,
  `time` time NOT NULL,
  `ride_cost` int(6) NOT NULL,
  `seat_info` varchar(50) NOT NULL,
  `ride_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_history`
--

INSERT INTO `ride_history` (`p_id`, `bus_no`, `start_from`, `end_at`, `time`, `ride_cost`, `seat_info`, `ride_date`) VALUES
(300001, 1001, 'Dhanmondi', 'Banani', '12:00:00', 95, '[ 1, , , , ,  ]', '2025-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `s_id` int(6) NOT NULL,
  `shift` time NOT NULL,
  `type` varchar(20) NOT NULL,
  `manager_id` int(6) NOT NULL,
  `assigned_duties` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `bus_no` int(6) NOT NULL,
  `time` time NOT NULL,
  `start_from` varchar(25) NOT NULL,
  `end_at` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`bus_no`, `time`, `start_from`, `end_at`) VALUES
(1002, '08:30:00', 'Gulistan', 'Mohammadpur'),
(1002, '10:30:00', 'Mohammadpur', 'Puran Dhaka'),
(1002, '12:30:00', 'Puran Dhaka', 'Mohakhali'),
(1002, '14:30:00', 'Mohakhali', 'Puran Dhaka'),
(1001, '10:00:00', 'Gulshan', 'Dhanmondi'),
(1001, '12:00:00', 'Dhanmondi', 'Banani'),
(1001, '14:00:00', 'Banani', 'Uttara'),
(1001, '16:00:00', 'Uttara', 'Banani'),
(1001, '18:00:00', 'Banani', 'Dhanmondi'),
(1001, '20:00:00', 'Dhanmondi', 'Gulshan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_no` varchar(11) NOT NULL,
  `password` char(255) NOT NULL,
  `nid` varchar(10) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `no_of_rides` int(4) NOT NULL,
  `age` int(3) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_no`, `password`, `nid`, `date_of_birth`, `address`, `no_of_rides`, `age`, `reg_date`) VALUES
(100001, 'MD. Fahim Abdullah Kayfe', 'admin1@gmail.com', '01333333331', '$2y$10$3JPcYf.82smcs9lbs6vB8.vqfaiXmDzCLty5m.gSm9vplAZmrb1Xe', '1234567891', '2000-07-04', 'Puran Dhaka', 0, 24, '2025-12-17 22:08:36'),
(100002, 'Md. Monkasir Noor Siam', 'admin2@yahoo.com', '01333333332', '$2y$10$LljqqSr9INxu/VEE4M057.y0bv/jlMzSxqyeJZC/v0I0gaRSX6b/i', '1651819412', '2001-09-19', 'Shewrapara', 0, 23, '2025-12-19 09:50:46'),
(100003, 'Md. Samiul Islam', 'admin3@outlook.com', '01333333333', '$2y$10$fevYZKuTZm3vNO81Fzio1OaLxmbmacd3XktsGNneqzcBlGg84kaBi', '1181616039', '2002-08-02', 'Karwan Bazar', 0, 23, '2025-12-19 09:57:15'),
(200001, 'Md. Sohel Ahmed', 'manager1@gmail.com', '01444444441', '$2y$10$yJtQFTOLTckdbwoo7Wa2TehJ8raqYs5lmKdwh/IHgbOdg4ilmaO1C', '1234567892', '2001-05-19', 'Mirpur', 0, 23, '2025-12-17 22:13:46'),
(300001, 'nafis', 'nafis@gmail.com', '01651614891', '$2y$10$0/AMXYX2E3dBW38SLhaBDucrpKboOHi82nZPF1YGQ6Vqan7H2y1.G', '1651614844', '2001-02-21', 'Mirpur-10', 0, 24, '2025-12-18 09:31:22'),
(300002, 'Mahin Mosaddek', 'mahin@gmail.com', '01484599822', '$2y$10$E84.Fon.OJZPVZNpA5Ww..Tq4w1KFc1AU34dbg2rqHuPCbZ40NYB.', '1651894985', '2003-03-06', 'Gulshan', 0, 22, '2025-12-21 10:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `verifies`
--

CREATE TABLE `verifies` (
  `ad_id` int(6) NOT NULL,
  `p_id` int(6) NOT NULL,
  `confirmation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Indexes for table `bus_managers`
--
ALTER TABLE `bus_managers`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `m_id` (`m_id`);

--
-- Indexes for table `bus_seats`
--
ALTER TABLE `bus_seats`
  ADD KEY `bus_no` (`bus_no`);

--
-- Indexes for table `bus_service`
--
ALTER TABLE `bus_service`
  ADD PRIMARY KEY (`bus_no`),
  ADD UNIQUE KEY `bus_no` (`bus_no`);

--
-- Indexes for table `manages`
--
ALTER TABLE `manages`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `m_id` (`m_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `p_id` (`p_id`);

--
-- Indexes for table `payment_options`
--
ALTER TABLE `payment_options`
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD KEY `p_id` (`p_id`),
  ADD KEY `bus_no` (`bus_no`);

--
-- Indexes for table `ride_history`
--
ALTER TABLE `ride_history`
  ADD KEY `p_id` (`p_id`),
  ADD KEY `bus_no` (`bus_no`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_no` (`phone_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nid` (`nid`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `verifies`
--
ALTER TABLE `verifies`
  ADD KEY `ad_id` (`ad_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bus_managers`
--
ALTER TABLE `bus_managers`
  ADD CONSTRAINT `bus_managers_ibfk_1` FOREIGN KEY (`m_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bus_seats`
--
ALTER TABLE `bus_seats`
  ADD CONSTRAINT `bus_seats_ibfk_1` FOREIGN KEY (`bus_no`) REFERENCES `bus_service` (`bus_no`);

--
-- Constraints for table `manages`
--
ALTER TABLE `manages`
  ADD CONSTRAINT `manages_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `admins` (`ad_id`),
  ADD CONSTRAINT `manages_ibfk_2` FOREIGN KEY (`m_id`) REFERENCES `bus_managers` (`m_id`);

--
-- Constraints for table `passengers`
--
ALTER TABLE `passengers`
  ADD CONSTRAINT `passengers_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_options`
--
ALTER TABLE `payment_options`
  ADD CONSTRAINT `payment_options_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `passengers` (`p_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `passengers` (`p_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`bus_no`) REFERENCES `bus_service` (`bus_no`);

--
-- Constraints for table `ride_history`
--
ALTER TABLE `ride_history`
  ADD CONSTRAINT `ride_history_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `passengers` (`p_id`),
  ADD CONSTRAINT `ride_history_ibfk_2` FOREIGN KEY (`bus_no`) REFERENCES `bus_service` (`bus_no`);

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `staffs_ibfk_2` FOREIGN KEY (`manager_id`) REFERENCES `bus_managers` (`m_id`);

--
-- Constraints for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD CONSTRAINT `time_slots_ibfk_1` FOREIGN KEY (`bus_no`) REFERENCES `bus_service` (`bus_no`);

--
-- Constraints for table `verifies`
--
ALTER TABLE `verifies`
  ADD CONSTRAINT `verifies_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `admins` (`ad_id`),
  ADD CONSTRAINT `verifies_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `passengers` (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
