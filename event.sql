-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 11:16 PM
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
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `HOST` varchar(255) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `EventDescription` text NOT NULL,
  `EventTime` datetime NOT NULL,
  `MaxCapacity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `HOST`, `EventName`, `EventDescription`, `EventTime`, `MaxCapacity`) VALUES
(4, 'css@css.com', 'Test 34', 'Test 34', '2025-01-24 13:06:00', 50),
(6, 'css@css.com', 'Test 56', 'Test 56', '2025-01-30 13:11:00', 50),
(7, 'css@css.com', 'Test 67', 'Test 67', '2025-01-23 13:12:00', 50),
(8, 'css@css.com', 'Test 65', 'Test 65', '2025-01-23 13:12:00', 50),
(9, 'css@css.com', 'Test 99', 'Test 99', '2025-01-21 13:12:00', 50),
(11, 'css@css.com', 'Test 4', 'Test 4', '2025-01-01 13:14:00', 50),
(12, 'css@css.com', 'Test 31', 'Test 31', '2025-01-25 13:17:00', 50),
(13, 'css@css.com', 'Jarir', 'Jarir', '2025-01-01 13:50:00', 50),
(14, 'jarir1234', 'Main Event', 'Main Event', '2025-01-25 04:18:00', 0),
(15, 'css@css.com', 'Blitz Play', 'Blitz Play', '2025-01-26 03:10:00', 2),
(16, 'css@css.com', 'Finalizer', 'Finalizer', '2025-01-26 03:53:00', 3),
(17, 'css@css.com', 'Finalizer-X', 'Finalizer-X', '2025-01-30 03:54:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `RegistrationID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `EventID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`RegistrationID`, `Name`, `Email`, `Address`, `Phone`, `EventID`) VALUES
(1, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 15),
(2, 'Sunilkhan', 'proitpark1@gmail.com', 'Talaimari', '01615406040', 15),
(3, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 4),
(4, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 11),
(5, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 9),
(6, 'Sunilkhan', 'proitpark1@gmail.com', 'Talaimari', '01615406040', 9),
(7, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(8, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(9, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(10, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(11, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(12, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(13, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(14, 'Jarir Ahmed', 'jarircse16@gmail.com', 'Talaimari\r\nRajshahi', '01615406040', 7),
(15, 'Jaber Ahmed', 'jaber1113@gmail.com', 'Talaimari', '01615406040', 12),
(16, 'Jaber Ahmed', 'jaber1113@gmail.com', 'Talaimari', '01615406040', 12),
(17, 'Jaber Ahmed', 'jaber1113@gmail.com', 'Talaimari', '01615406040', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'jarir1234', 'jarir1234@gmail.com', '$2y$10$4mxH6DiURfPDJRME4OIUdOhG.EE4jZgB1wiOKZhTFVhk72Yk8ZbAa'),
(2, 'css@css.com', 'css@css.com', '$2y$10$293G63kpgqZc70GwKgRJ9.XGyky8B3n2YVp83/QBwATXauSnd0UO6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `HOST` (`HOST`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`RegistrationID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `RegistrationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`HOST`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
