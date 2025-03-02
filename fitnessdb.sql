-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 06:15 PM
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
-- Database: `fitnessdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `TrainerID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Specialization` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`TrainerID`, `Name`, `Specialization`) VALUES
(4, 'Carlo Ancheloti (edited)', 'Football'),
(5, 'amir', 'boxing'),
(6, 'Zidane', 'Football');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('User','Trainer','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Name`, `Email`, `Password`, `Role`) VALUES
(1, 'Canelo Alvarez (edited)', 'amir@amir.co', '1234', 'User'),
(2, 'Tony jeffries (edited)', 'tony@yahoo.com', '1234', 'Trainer'),
(4, 'mbappe', 'km9@rma.com', '$2y$10$TCCy8F5MsN2x.Cr0dNkzhODaP8qSDF7srmj/kdAjESO.rdUYerDwy', 'User'),
(7, 'vini jr', 'vini@rma.com', '$2y$10$YjIA4vcsn/t/6WqQdlrYOumjAKduafg9eBqfPH6IWfO7g0eywFJki', 'User'),
(8, 'test', 'da@da.ci', '$2y$10$49iDOJkIkPkGeOyXfv9Vv.v1/QRrc0ixjhM3PDIDA0QHluQifWkme', 'User'),
(9, 'testing', '123@ka.co', '$2y$10$lNRjfyks2PYpb2KWBt/oBOjtzmjqFsly19g8TP3aM9rWwSV2WVmze', 'User'),
(11, 'admin', 'admin@ftm.co.uk', '$2y$10$x/edr..L2P0bkJo7bm37tevqAyYk20DgL27sHdqXZ1FtKRHzpDfBW', 'Admin'),
(14, 'admintest1', 'admin@admin.coo', '$2y$10$xDd0gwIte/rxwWzXSkmGTOneEFurHzNro38b8bEKFpIE.Ot/kTWbq', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `WorkoutID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TrainerID` int(11) DEFAULT NULL,
  `WorkoutTypeID` int(11) DEFAULT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`WorkoutID`, `UserID`, `TrainerID`, `WorkoutTypeID`, `Date`) VALUES
(6, 1, 4, 3, '2025-01-15'),
(7, 2, 5, 2, '2025-02-05'),
(8, 4, 6, 2, '2024-12-31'),
(9, 9, NULL, 1, '2025-02-06'),
(11, 9, 4, 1, '1111-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `workouttypes`
--

CREATE TABLE `workouttypes` (
  `WorkoutTypeID` int(11) NOT NULL,
  `WorkoutType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouttypes`
--

INSERT INTO `workouttypes` (`WorkoutTypeID`, `WorkoutType`) VALUES
(1, 'Boxing'),
(2, 'Football'),
(3, 'Recovery');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`TrainerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`WorkoutID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `TrainerID` (`TrainerID`),
  ADD KEY `WorkoutTypeID` (`WorkoutTypeID`);

--
-- Indexes for table `workouttypes`
--
ALTER TABLE `workouttypes`
  ADD PRIMARY KEY (`WorkoutTypeID`),
  ADD UNIQUE KEY `WorkoutType` (`WorkoutType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `TrainerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `WorkoutID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `workouttypes`
--
ALTER TABLE `workouttypes`
  MODIFY `WorkoutTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
  ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `workouts_ibfk_2` FOREIGN KEY (`TrainerID`) REFERENCES `trainers` (`TrainerID`),
  ADD CONSTRAINT `workouts_ibfk_3` FOREIGN KEY (`WorkoutTypeID`) REFERENCES `workouttypes` (`WorkoutTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
