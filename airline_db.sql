-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 09:12 PM
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
-- Database: `airline_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FlightID` int(11) DEFAULT NULL,
  `SeatID` int(11) DEFAULT NULL,
  `PassengerID` int(11) DEFAULT NULL,
  `BookingTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingID`, `UserID`, `FlightID`, `SeatID`, `PassengerID`, `BookingTime`) VALUES
(5, 4, 2, 193, 8, '2024-07-12 16:23:16'),
(6, 4, 2, 193, 9, '2024-07-12 16:23:16'),
(7, 4, 2, 193, 10, '2024-07-12 16:35:43'),
(8, 4, 2, 193, 11, '2024-07-12 16:35:43'),
(9, 4, 2, 193, 12, '2024-07-12 16:43:35'),
(10, 4, 2, 193, 13, '2024-07-12 16:43:35'),
(11, 4, 2, 193, 14, '2024-07-12 16:45:00'),
(12, 4, 2, 193, 15, '2024-07-12 16:45:00'),
(13, 4, 2, 193, 17, '2024-07-12 16:50:10'),
(14, 4, 2, 193, 18, '2024-07-12 16:50:10'),
(15, 4, 2, 193, 19, '2024-07-12 16:53:15'),
(16, 4, 2, 193, 20, '2024-07-12 16:53:15'),
(17, 4, 2, 193, 21, '2024-07-12 16:54:02'),
(18, 4, 2, 193, 22, '2024-07-12 16:54:02'),
(19, 4, 2, 193, 23, '2024-07-12 16:54:28'),
(20, 4, 2, 193, 24, '2024-07-12 16:54:28'),
(21, 4, 2, 193, 25, '2024-07-12 16:59:55'),
(22, 4, 2, 193, 26, '2024-07-12 16:59:55'),
(23, 4, 2, 193, 27, '2024-07-12 17:00:22'),
(24, 4, 2, 193, 28, '2024-07-12 17:00:22'),
(25, 4, 2, 193, 29, '2024-07-12 17:02:27'),
(26, 4, 2, 193, 30, '2024-07-12 17:02:27'),
(27, 4, 2, 193, 31, '2024-07-12 17:05:36'),
(28, 4, 2, 193, 32, '2024-07-12 17:05:36');

--
-- Triggers `booking`
--
DELIMITER $$
CREATE TRIGGER `before_booking_insert` BEFORE INSERT ON `booking` FOR EACH ROW BEGIN
    DECLARE latest_user_id INT;
    DECLARE latest_flight_id INT;
    DECLARE latest_seat_id INT;
    DECLARE latest_passenger_id INT;

    -- Get the latest UserID
    SELECT `UserID` INTO latest_user_id
    FROM `user`
    ORDER BY `UserID` DESC
    LIMIT 1;

    -- Get the latest FlightID
    SELECT `FlightID` INTO latest_flight_id
    FROM `flight`
    ORDER BY `FlightID` DESC
    LIMIT 1;

    -- Get the latest SeatID
    SELECT `SeatID` INTO latest_seat_id
    FROM `seat`
    ORDER BY `SeatID` DESC
    LIMIT 1;

    -- Get the latest PassengerID
    SELECT `PassengerID` INTO latest_passenger_id
    FROM `passenger`
    ORDER BY `PassengerID` DESC
    LIMIT 1;

    -- Set the NEW values
    SET NEW.`UserID` = latest_user_id;
    SET NEW.`FlightID` = latest_flight_id;
    SET NEW.`SeatID` = latest_seat_id;
    SET NEW.`PassengerID` = latest_passenger_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `FlightID` int(11) NOT NULL,
  `PlaneID` int(11) DEFAULT NULL,
  `FlightNumber` varchar(20) NOT NULL,
  `DepartureTime` datetime NOT NULL,
  `ArrivalTime` datetime NOT NULL,
  `DepartureLocation` varchar(255) NOT NULL,
  `ArrivalLocation` varchar(255) NOT NULL,
  `fare` int(6) NOT NULL,
  `Duration Time` int(11) NOT NULL,
  `CabinClass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`FlightID`, `PlaneID`, `FlightNumber`, `DepartureTime`, `ArrivalTime`, `DepartureLocation`, `ArrivalLocation`, `fare`, `Duration Time`, `CabinClass`) VALUES
(1, 1, 'FL123', '2024-07-10 08:00:00', '2024-07-10 10:00:00', 'New York', 'Los Angeles', 10000, 0, 0),
(2, 2, 'FL456', '2024-07-11 09:00:00', '2024-07-11 11:00:00', 'Chicago', 'Miami', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `PassengerID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `AgeGroup` enum('adult','senior','child','infant') NOT NULL,
  `SeatNumber` varchar(10) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `MealPreference` enum('none','veg','non-veg','vegan','kosher','halal') DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`PassengerID`, `UserID`, `Name`, `Age`, `AgeGroup`, `SeatNumber`, `Email`, `PhoneNumber`, `MealPreference`) VALUES
(1, 1, 'John Doe', 25, 'adult', '', NULL, NULL, 'none'),
(8, 3, 'prakash', 2, 'adult', '1A', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(9, 3, 'fast', 2, 'adult', '2A', 'mike@hotmail.com', '12364789523', 'veg'),
(10, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(11, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(12, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(13, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(14, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(15, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(16, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(17, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(18, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(19, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(20, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(21, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(22, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(23, 1, 'prakash', 2, 'adult', 'A1', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(24, 1, 'fast', 2, 'adult', 'A2', 'mike@hotmail.com', '12364789523', 'veg'),
(25, 1, 'prakash', 2, 'adult', '1A', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(26, 1, 'fast', 2, 'adult', '2A', 'mike@hotmail.com', '12364789523', 'veg'),
(27, 1, 'prakash', 2, 'adult', '1A', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(28, 1, 'fast', 2, 'adult', '2A', 'mike@hotmail.com', '12364789523', 'veg'),
(29, 1, 'prakash', 2, 'adult', '1A', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(30, 1, 'fast', 2, 'adult', '2A', 'mike@hotmail.com', '12364789523', 'veg'),
(31, 1, 'prakash', 2, 'adult', '1A', 'pkamzare@gmail.com', '9405528955', 'non-veg'),
(32, 1, 'fast', 2, 'adult', '2A', 'mike@hotmail.com', '12364789523', 'veg');

-- --------------------------------------------------------

--
-- Table structure for table `plane`
--

CREATE TABLE `plane` (
  `PlaneID` int(11) NOT NULL,
  `PlaneModel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plane`
--

INSERT INTO `plane` (`PlaneID`, `PlaneModel`) VALUES
(1, 'Boeing 737'),
(2, 'Airbus A320');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `SeatID` int(11) NOT NULL,
  `FlightID` int(11) DEFAULT NULL,
  `SeatNumber` varchar(10) NOT NULL,
  `Status` enum('booked','locked','free') DEFAULT 'free',
  `IsFireExit` enum('1','0') NOT NULL DEFAULT '0',
  `LockUntil` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`SeatID`, `FlightID`, `SeatNumber`, `Status`, `IsFireExit`, `LockUntil`) VALUES
(134, 1, '1A', 'free', '0', NULL),
(135, 1, '1B', 'free', '0', NULL),
(136, 1, '1C', 'free', '0', NULL),
(137, 1, '1D', 'free', '0', NULL),
(138, 1, '1E', 'free', '0', NULL),
(139, 1, '1F', 'free', '0', NULL),
(140, 1, '2A', 'free', '0', NULL),
(141, 1, '2B', 'free', '0', NULL),
(142, 1, '2C', 'free', '0', NULL),
(143, 1, '2D', 'free', '0', NULL),
(144, 1, '2E', 'free', '0', NULL),
(145, 1, '2F', 'free', '0', NULL),
(146, 1, '3A', 'free', '0', NULL),
(147, 1, '3B', 'free', '0', NULL),
(148, 1, '3C', 'free', '0', NULL),
(149, 1, '3D', 'locked', '0', NULL),
(150, 1, '3E', 'free', '0', NULL),
(151, 1, '3F', 'free', '0', NULL),
(152, 1, '4A', 'free', '0', NULL),
(153, 1, '4B', 'free', '0', NULL),
(154, 1, '4C', 'free', '0', NULL),
(155, 1, '4D', 'booked', '0', NULL),
(156, 1, '4E', 'free', '0', NULL),
(157, 1, '4F', 'free', '0', NULL),
(158, 1, '5A', 'free', '0', NULL),
(159, 1, '5B', 'free', '0', NULL),
(160, 1, '5C', 'locked', '0', NULL),
(161, 1, '5D', 'free', '0', NULL),
(162, 1, '5E', 'free', '0', NULL),
(163, 1, '5F', 'free', '0', NULL),
(164, 1, '6A', 'booked', '0', NULL),
(165, 1, '6B', 'free', '0', NULL),
(166, 1, '6C', 'free', '0', NULL),
(167, 1, '6D', 'free', '0', NULL),
(168, 1, '6E', 'free', '0', NULL),
(169, 1, '6F', 'free', '0', NULL),
(170, 1, '7A', 'free', '0', NULL),
(171, 1, '7B', 'free', '0', NULL),
(172, 1, '7C', 'free', '0', NULL),
(173, 1, '7D', 'free', '0', NULL),
(174, 1, '7E', 'free', '0', NULL),
(175, 1, '7F', 'free', '0', NULL),
(176, 1, '8A', 'free', '0', NULL),
(177, 1, '8B', 'free', '0', NULL),
(178, 1, '8C', 'free', '0', NULL),
(179, 1, '8D', 'free', '0', NULL),
(180, 1, '8E', 'free', '0', NULL),
(181, 1, '8F', 'free', '0', NULL),
(182, 1, '9A', 'free', '0', NULL),
(183, 1, '9B', 'free', '0', NULL),
(184, 1, '9C', 'free', '0', NULL),
(185, 1, '9D', 'free', '0', NULL),
(186, 1, '9E', 'free', '0', NULL),
(187, 1, '9F', 'free', '0', NULL),
(188, 1, '10A', 'free', '1', NULL),
(189, 1, '10B', 'free', '1', NULL),
(190, 1, '10C', 'free', '1', NULL),
(191, 1, '10D', 'free', '1', NULL),
(192, 1, '10E', 'free', '1', NULL),
(193, 1, '10F', 'free', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `Age`, `is_admin`) VALUES
(1, 'Admin', 'admin@example.com', '81dc9bdb52d04dc20036dbd8313ed055', 30, 1),
(3, 'Pankaj Samudree', 'cheturawat@gmail.com', '$2y$10$n7Tt2BfakSqLhCynfVFJa.Ef2xKOHEpc.u53p9LH1SIKdVmyCQFuG', 41, 0),
(4, 'Chetana Gaikwad', 'chetanagaikwad28@gmail.com', '$2y$10$4jZ4f..k7ckYa7DEGpmd1uhFoJIQa6zF9RSbACJcVBtHvSN9iscHO', 21, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `FlightID` (`FlightID`),
  ADD KEY `SeatID` (`SeatID`),
  ADD KEY `PassengerID` (`PassengerID`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`FlightID`),
  ADD KEY `PlaneID` (`PlaneID`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`PassengerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `plane`
--
ALTER TABLE `plane`
  ADD PRIMARY KEY (`PlaneID`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`SeatID`),
  ADD KEY `PlaneID` (`FlightID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `FlightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `PassengerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `plane`
--
ALTER TABLE `plane`
  MODIFY `PlaneID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `SeatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`FlightID`) REFERENCES `flight` (`FlightID`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`SeatID`) REFERENCES `seat` (`SeatID`),
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`PassengerID`) REFERENCES `passenger` (`PassengerID`);

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`PlaneID`) REFERENCES `plane` (`PlaneID`);

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`FlightID`) REFERENCES `plane` (`PlaneID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
