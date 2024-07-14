-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 09:23 AM
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
  `BookingTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('booked','cancelled') NOT NULL DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 'AI101', '2024-07-15 08:00:00', '2024-07-15 11:00:00', 'Delhi', 'Mumbai', 5000, 180, 0),
(2, 2, 'FL456', '2024-07-11 09:00:00', '2024-07-11 11:00:00', 'Chicago', 'Miami', 0, 0, 0),
(3, 1, 'FL123', '2024-07-10 08:00:00', '2024-07-10 10:00:00', 'New York', 'Los Angeles', 10000, 0, 0),
(4, 2, 'SG202', '2024-07-14 12:00:00', '2024-07-14 14:30:00', 'Mumbai', 'Bangalore', 4500, 150, 1),
(5, 3, '6E303', '2024-07-14 15:00:00', '2024-07-14 17:00:00', 'Bangalore', 'Hyderabad', 3500, 120, 1),
(6, 4, 'G804', '2024-07-14 18:00:00', '2024-07-14 21:00:00', 'Hyderabad', 'Chennai', 4000, 180, 2),
(7, 5, 'UK505', '2024-07-14 06:00:00', '2024-07-14 08:30:00', 'Chennai', 'Kolkata', 5500, 150, 2),
(8, 1, 'AI606', '2024-07-14 09:00:00', '2024-07-14 11:30:00', 'Kolkata', 'Delhi', 6000, 150, 1),
(9, 2, 'SG707', '2024-07-14 10:00:00', '2024-07-14 12:00:00', 'Delhi', 'Jaipur', 3000, 120, 1),
(10, 3, '6E808', '2024-07-14 13:00:00', '2024-07-14 15:00:00', 'Jaipur', 'Ahmedabad', 3200, 120, 2),
(11, 4, 'G909', '2024-07-14 14:00:00', '2024-07-14 17:00:00', 'Ahmedabad', 'Pune', 4800, 180, 2),
(12, 5, 'UK010', '2024-07-14 16:00:00', '2024-07-14 19:00:00', 'Pune', 'Goa', 4000, 180, 1);

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
(32, 1, 'fast', 2, 'adult', '2A', 'mike@hotmail.com', '12364789523', 'veg'),
(33, 1, 'prakash', 16, 'adult', '3A', 'pkamzare@gmail.com', '9405528955', 'vegan'),
(34, 1, 'fast', 8, 'senior', '4A', 'mike@hotmail.com', '12364789523', 'non-veg'),
(35, NULL, 'saurabh', 62, 'senior', '9A', 'saurabh@hotmail.com', '8799983202', 'veg'),
(36, NULL, 'saurabh', 62, 'senior', '9A', 'saurabh@hotmail.com', '8799983202', 'veg'),
(37, 3, 'saurabh', 62, 'senior', '9A', 'saurabh@hotmail.com', '8799983202', 'veg');

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
(2, 'Airbus A320'),
(3, 'Airbus A320'),
(4, 'Boeing 737'),
(5, 'Airbus A321'),
(6, 'Boeing 787'),
(7, 'Airbus A330'),
(8, 'Airbus A320'),
(9, 'Boeing 737'),
(10, 'Airbus A321'),
(11, 'Boeing 787'),
(12, 'Airbus A330');

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
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `FlightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `PassengerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `plane`
--
ALTER TABLE `plane`
  MODIFY `PlaneID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `SeatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3197;

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
