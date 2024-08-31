-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 01:06 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ws2_queuing`
--

-- --------------------------------------------------------

--
-- Table structure for table `limit_tb`
--

CREATE TABLE `limit_tb` (
  `limit_id` int(11) NOT NULL,
  `limit_no` int(11) NOT NULL,
  `limit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `limit_tb`
--

INSERT INTO `limit_tb` (`limit_id`, `limit_no`, `limit_date`) VALUES
(4, 2, '2023-05-03'),
(5, 5, '2023-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `queue_list`
--

CREATE TABLE `queue_list` (
  `queue_id` int(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=accepted, 2=finished, 3=failed',
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `created_timestamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `queue_list`
--

INSERT INTO `queue_list` (`queue_id`, `user_id`, `service_id`, `status`, `date_created`, `created_timestamp`) VALUES
(1, 7, 3, 1, '2023-04-25', '2023-04-26 01:40:06'),
(2, 7, 1, 0, '2023-04-25', '2023-04-26 01:40:06'),
(30, 7, 4, 0, '2023-04-26', '2023-04-26 04:17:17'),
(67, 7, 2, 0, '2023-05-03', '2023-05-03 02:49:09'),
(72, 21, 4, 2, '2023-05-04', '2023-05-04 15:22:41'),
(76, 21, 1, 2, '2022-04-04', '2023-05-05 05:05:57'),
(79, 21, 2, 2, '2023-05-04', '2023-05-04 13:31:23'),
(80, 19, 1, 1, '2023-05-04', '2023-05-04 13:49:18'),
(83, 19, 4, 2, '2023-05-04', '2023-05-04 22:11:54'),
(85, 19, 1, 2, '2023-05-05', '2023-05-05 09:55:55'),
(86, 23, 4, 2, '2023-05-05', '2023-05-05 09:57:31'),
(87, 23, 1, 2, '2023-04-04', '2023-05-16 15:21:13'),
(89, 23, 2, 3, '2023-05-17', '2023-05-17 12:42:04'),
(90, 23, 3, 1, '2023-05-17', '2023-05-17 12:43:16'),
(91, 19, 1, 1, '2023-05-17', '2023-05-17 12:44:07'),
(92, 29, 4, 1, '2023-05-19', '2023-05-19 10:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `queue_transaction`
--

CREATE TABLE `queue_transaction` (
  `trans_id` int(11) NOT NULL,
  `processor_id` int(11) NOT NULL,
  `queue_id` int(11) NOT NULL,
  `trans_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=accepted, 2=finished, 3=failed',
  `trans_date` date NOT NULL DEFAULT current_timestamp(),
  `countdown` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `queue_transaction`
--

INSERT INTO `queue_transaction` (`trans_id`, `processor_id`, `queue_id`, `trans_status`, `trans_date`, `countdown`) VALUES
(5, 16, 76, 2, '2022-04-04', '2023-05-04 21:06:06'),
(6, 20, 79, 2, '2023-05-04', '2023-05-04 07:04:32'),
(7, 20, 80, 1, '2023-05-04', '2023-05-04 07:04:32'),
(10, 16, 72, 2, '2023-05-04', '2023-05-04 07:22:41'),
(18, 16, 83, 2, '2023-05-04', '2023-05-04 14:11:54'),
(19, 16, 85, 2, '2023-05-05', '2023-05-05 01:55:55'),
(20, 16, 86, 2, '2023-05-05', '2023-05-05 01:57:31'),
(21, 16, 87, 2, '2023-04-04', '2023-05-16 07:20:51'),
(23, 20, 89, 3, '2023-05-17', '2023-05-17 04:42:04'),
(24, 17, 90, 1, '2023-05-17', '2023-05-17 04:43:16'),
(25, 16, 91, 1, '2023-05-17', '2023-05-17 04:44:07'),
(26, 16, 92, 1, '2023-05-19', '2023-05-19 02:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `service_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_name`, `service_desc`) VALUES
(1, 'Cedula', 'Cedulaaaaaaaaaaaaa'),
(2, 'Mayor\'s Permit', 'Mayor\'s Permittttt'),
(3, 'Tricycle Permit', 'Tricycle Permitttt'),
(4, 'Business Permit', 'Business Permitt'),
(7, 'eme lang ', 'eme eme langgg');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_windows`
--

CREATE TABLE `transaction_windows` (
  `transwindow_id` int(30) NOT NULL,
  `service_id` int(30) NOT NULL,
  `window_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_windows`
--

INSERT INTO `transaction_windows` (`transwindow_id`, `service_id`, `window_id`) VALUES
(2, 1, 1),
(3, 2, 2),
(4, 3, 2),
(5, 1, 3),
(6, 2, 3),
(11, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `u_name` text NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 3 COMMENT '1 = Admin, 2= staff, 3=client',
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `u_name`, `type`, `username`, `password`, `phone`) VALUES
(1, 'Chrissha Maee', 1, 'admin@gmail.com', 'Admin123!', ''),
(7, 'fhjuvbj', 3, 'c@gmail.com', '123456', ''),
(8, 'bshvhbsa', 3, 'admin1@gmail.com', '123456', ''),
(16, 'Jomary Davalos', 2, 'j@gmail.com', 'J123456!', ''),
(17, 'May Balbin', 2, 'm@gmail.com', '123456', ''),
(19, 'Marlon Castillo', 3, 'm@mail.com', '123456', ''),
(20, 'Nicole Castillo', 2, 'n@gmail.com', '123456', ''),
(21, 'Kerstin Balbin', 3, 'tin@mail.com', '123456', ''),
(22, 'Jnorlynne Duque', 2, 'dbf@wdj.com', '123456', ''),
(23, 'Rodolfo Abracia', 3, 'r@mail.com', '123456', ''),
(24, 'Deoff Torrado', 2, 'd@email.com', '123456', ''),
(28, 'Chrissdssha Maee', 3, 'asdsdmin@gmail.com', '123456', '1234-908-6789'),
(29, 'hgffgfdjgf', 3, 'djhfjd@hgf.com', '123456A!', '1235-867-9077');

-- --------------------------------------------------------

--
-- Table structure for table `window`
--

CREATE TABLE `window` (
  `window_id` int(11) NOT NULL,
  `window_name` varchar(50) NOT NULL,
  `window_desc` text NOT NULL,
  `processor_id` int(11) NOT NULL,
  `w_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `window`
--

INSERT INTO `window` (`window_id`, `window_name`, `window_desc`, `processor_id`, `w_status`) VALUES
(1, 'Window 1', 'Windowwwwwwwwww 1', 16, 1),
(2, 'Window 2', 'Windowwwwwwwwww 2', 17, 1),
(3, 'Window 3', 'Windowwwwwwwwww 3', 20, 1),
(8, 'Window 4', 'sxvdsbd', 24, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `limit_tb`
--
ALTER TABLE `limit_tb`
  ADD PRIMARY KEY (`limit_id`);

--
-- Indexes for table `queue_list`
--
ALTER TABLE `queue_list`
  ADD PRIMARY KEY (`queue_id`),
  ADD KEY `fk_service_id_queue` (`service_id`),
  ADD KEY `fk_queue_user` (`user_id`);

--
-- Indexes for table `queue_transaction`
--
ALTER TABLE `queue_transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `fk_pID` (`processor_id`),
  ADD KEY `fk_queueID` (`queue_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `transaction_windows`
--
ALTER TABLE `transaction_windows`
  ADD PRIMARY KEY (`transwindow_id`),
  ADD KEY `fk_trans_serviceid` (`service_id`),
  ADD KEY `fk_trans_windows_id` (`window_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `window`
--
ALTER TABLE `window`
  ADD PRIMARY KEY (`window_id`),
  ADD KEY `fk_processorid` (`processor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `limit_tb`
--
ALTER TABLE `limit_tb`
  MODIFY `limit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `queue_list`
--
ALTER TABLE `queue_list`
  MODIFY `queue_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `queue_transaction`
--
ALTER TABLE `queue_transaction`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaction_windows`
--
ALTER TABLE `transaction_windows`
  MODIFY `transwindow_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `window`
--
ALTER TABLE `window`
  MODIFY `window_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `queue_list`
--
ALTER TABLE `queue_list`
  ADD CONSTRAINT `fk_queue_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_service_id_queue` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `queue_transaction`
--
ALTER TABLE `queue_transaction`
  ADD CONSTRAINT `fk_pID` FOREIGN KEY (`processor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_queueID` FOREIGN KEY (`queue_id`) REFERENCES `queue_list` (`queue_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_windows`
--
ALTER TABLE `transaction_windows`
  ADD CONSTRAINT `fk_trans_serviceid` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_windows_id` FOREIGN KEY (`window_id`) REFERENCES `window` (`window_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `window`
--
ALTER TABLE `window`
  ADD CONSTRAINT `fk_processorid` FOREIGN KEY (`processor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
