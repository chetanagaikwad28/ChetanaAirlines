-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 11:38 PM
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
(1, 201, 'SG501', '2024-07-18 10:30:00', '2024-07-18 12:30:00', 'Delhi', 'Mumbai', 4500, 120, 1),
(2, 202, '6E302', '2024-07-18 13:00:00', '2024-07-18 15:00:00', 'Mumbai', 'Bangalore', 4000, 120, 2),
(3, 203, 'AI505', '2024-07-18 16:00:00', '2024-07-18 18:00:00', 'Bangalore', 'Hyderabad', 3500, 120, 1),
(4, 204, 'UK303', '2024-07-18 19:00:00', '2024-07-18 21:00:00', 'Hyderabad', 'Chennai', 3000, 120, 3),
(5, 205, 'G8101', '2024-07-18 22:00:00', '2024-07-19 00:30:00', 'Chennai', 'Kolkata', 5000, 150, 2),
(6, 206, '6E204', '2024-07-19 01:00:00', '2024-07-19 03:30:00', 'Kolkata', 'Delhi', 5500, 150, 1),
(7, 207, 'AI709', '2024-07-19 10:30:00', '2024-07-19 12:30:00', 'Delhi', 'Jaipur', 3200, 120, 2),
(8, 208, 'UK407', '2024-07-19 13:00:00', '2024-07-19 15:00:00', 'Jaipur', 'Ahmedabad', 3700, 120, 1),
(9, 209, 'SG708', '2024-07-19 16:00:00', '2024-07-19 18:00:00', 'Ahmedabad', 'Surat', 2800, 120, 3),
(10, 210, '6E408', '2024-07-19 19:00:00', '2024-07-19 21:00:00', 'Surat', 'Pune', 4100, 120, 1),
(11, 211, 'AI511', '2024-07-19 22:00:00', '2024-07-20 00:30:00', 'Pune', 'Goa', 4300, 150, 2),
(12, 212, 'G8123', '2024-07-20 01:00:00', '2024-07-20 03:30:00', 'Goa', 'Mumbai', 3900, 150, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`FlightID`),
  ADD KEY `PlaneID` (`PlaneID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `FlightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`PlaneID`) REFERENCES `plane` (`PlaneID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
