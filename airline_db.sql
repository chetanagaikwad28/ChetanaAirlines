-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 10:15 AM
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

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`SeatID`, `FlightID`, `SeatNumber`, `Status`, `IsFireExit`, `LockUntil`) VALUES
(5357, 1, '1A', 'free', '0', NULL),
(5358, 1, '1B', 'free', '0', NULL),
(5359, 1, '1C', 'free', '0', NULL),
(5360, 1, '1D', 'free', '0', NULL),
(5361, 1, '1E', 'free', '0', NULL),
(5362, 1, '1F', 'free', '1', NULL),
(5363, 1, '2A', 'free', '0', NULL),
(5364, 1, '2B', 'free', '0', NULL),
(5365, 1, '2C', 'free', '0', NULL),
(5366, 1, '2D', 'free', '0', NULL),
(5367, 1, '2E', 'free', '0', NULL),
(5368, 1, '2F', 'free', '1', NULL),
(5369, 1, '3A', 'free', '0', NULL),
(5370, 1, '3B', 'free', '0', NULL),
(5371, 1, '3C', 'free', '0', NULL),
(5372, 1, '3D', 'free', '0', NULL),
(5373, 1, '3E', 'free', '0', NULL),
(5374, 1, '3F', 'free', '1', NULL),
(5375, 1, '4A', 'free', '0', NULL),
(5376, 1, '4B', 'free', '0', NULL),
(5377, 1, '4C', 'free', '0', NULL),
(5378, 1, '4D', 'free', '0', NULL),
(5379, 1, '4E', 'free', '0', NULL),
(5380, 1, '4F', 'free', '1', NULL),
(5381, 1, '5A', 'free', '0', NULL),
(5382, 1, '5B', 'free', '0', NULL),
(5383, 1, '5C', 'free', '0', NULL),
(5384, 1, '5D', 'free', '0', NULL),
(5385, 1, '5E', 'free', '0', NULL),
(5386, 1, '5F', 'free', '1', NULL),
(5387, 1, '6A', 'free', '0', NULL),
(5388, 1, '6B', 'free', '0', NULL),
(5389, 1, '6C', 'free', '0', NULL),
(5390, 1, '6D', 'free', '0', NULL),
(5391, 1, '6E', 'free', '0', NULL),
(5392, 1, '6F', 'free', '1', NULL),
(5393, 1, '7A', 'free', '0', NULL),
(5394, 1, '7B', 'free', '0', NULL),
(5395, 1, '7C', 'free', '0', NULL),
(5396, 1, '7D', 'free', '0', NULL),
(5397, 1, '7E', 'free', '0', NULL),
(5398, 1, '7F', 'free', '0', NULL),
(5399, 1, '8A', 'free', '0', NULL),
(5400, 1, '8B', 'free', '0', NULL),
(5401, 1, '8C', 'free', '0', NULL),
(5402, 1, '8D', 'free', '0', NULL),
(5403, 1, '8E', 'free', '0', NULL),
(5404, 1, '8F', 'free', '0', NULL),
(5405, 1, '9A', 'free', '0', NULL),
(5406, 1, '9B', 'free', '0', NULL),
(5407, 1, '9C', 'free', '0', NULL),
(5408, 1, '9D', 'free', '0', NULL),
(5409, 1, '9E', 'free', '0', NULL),
(5410, 1, '9F', 'free', '0', NULL),
(5411, 1, '10A', 'free', '0', NULL),
(5412, 1, '10B', 'free', '0', NULL),
(5413, 1, '10C', 'free', '0', NULL),
(5414, 1, '10D', 'free', '0', NULL),
(5415, 1, '10E', 'free', '0', NULL),
(5416, 1, '10F', 'free', '0', NULL),
(5417, 2, '1A', 'free', '0', NULL),
(5418, 2, '1B', 'free', '0', NULL),
(5419, 2, '1C', 'free', '0', NULL),
(5420, 2, '1D', 'free', '0', NULL),
(5421, 2, '1E', 'free', '0', NULL),
(5422, 2, '1F', 'free', '1', NULL),
(5423, 2, '2A', 'free', '0', NULL),
(5424, 2, '2B', 'free', '0', NULL),
(5425, 2, '2C', 'free', '0', NULL),
(5426, 2, '2D', 'free', '0', NULL),
(5427, 2, '2E', 'free', '0', NULL),
(5428, 2, '2F', 'free', '1', NULL),
(5429, 2, '3A', 'free', '0', NULL),
(5430, 2, '3B', 'free', '0', NULL),
(5431, 2, '3C', 'free', '0', NULL),
(5432, 2, '3D', 'free', '0', NULL),
(5433, 2, '3E', 'free', '0', NULL),
(5434, 2, '3F', 'free', '1', NULL),
(5435, 2, '4A', 'free', '0', NULL),
(5436, 2, '4B', 'free', '0', NULL),
(5437, 2, '4C', 'free', '0', NULL),
(5438, 2, '4D', 'free', '0', NULL),
(5439, 2, '4E', 'free', '0', NULL),
(5440, 2, '4F', 'free', '1', NULL),
(5441, 2, '5A', 'free', '0', NULL),
(5442, 2, '5B', 'free', '0', NULL),
(5443, 2, '5C', 'free', '0', NULL),
(5444, 2, '5D', 'free', '0', NULL),
(5445, 2, '5E', 'free', '0', NULL),
(5446, 2, '5F', 'free', '1', NULL),
(5447, 2, '6A', 'free', '0', NULL),
(5448, 2, '6B', 'free', '0', NULL),
(5449, 2, '6C', 'free', '0', NULL),
(5450, 2, '6D', 'free', '0', NULL),
(5451, 2, '6E', 'free', '0', NULL),
(5452, 2, '6F', 'free', '1', NULL),
(5453, 2, '7A', 'free', '0', NULL),
(5454, 2, '7B', 'free', '0', NULL),
(5455, 2, '7C', 'free', '0', NULL),
(5456, 2, '7D', 'free', '0', NULL),
(5457, 2, '7E', 'free', '0', NULL),
(5458, 2, '7F', 'free', '0', NULL),
(5459, 2, '8A', 'free', '0', NULL),
(5460, 2, '8B', 'free', '0', NULL),
(5461, 2, '8C', 'free', '0', NULL),
(5462, 2, '8D', 'free', '0', NULL),
(5463, 2, '8E', 'free', '0', NULL),
(5464, 2, '8F', 'free', '0', NULL),
(5465, 2, '9A', 'free', '0', NULL),
(5466, 2, '9B', 'free', '0', NULL),
(5467, 2, '9C', 'free', '0', NULL),
(5468, 2, '9D', 'free', '0', NULL),
(5469, 2, '9E', 'free', '0', NULL),
(5470, 2, '9F', 'free', '0', NULL),
(5471, 2, '10A', 'free', '0', NULL),
(5472, 2, '10B', 'free', '0', NULL),
(5473, 2, '10C', 'free', '0', NULL),
(5474, 2, '10D', 'free', '0', NULL),
(5475, 2, '10E', 'free', '0', NULL),
(5476, 2, '10F', 'free', '0', NULL),
(5477, 3, '1A', 'free', '0', NULL),
(5478, 3, '1B', 'free', '0', NULL),
(5479, 3, '1C', 'free', '0', NULL),
(5480, 3, '1D', 'free', '0', NULL),
(5481, 3, '1E', 'free', '0', NULL),
(5482, 3, '1F', 'free', '1', NULL),
(5483, 3, '2A', 'free', '0', NULL),
(5484, 3, '2B', 'free', '0', NULL),
(5485, 3, '2C', 'free', '0', NULL),
(5486, 3, '2D', 'free', '0', NULL),
(5487, 3, '2E', 'free', '0', NULL),
(5488, 3, '2F', 'free', '1', NULL),
(5489, 3, '3A', 'free', '0', NULL),
(5490, 3, '3B', 'free', '0', NULL),
(5491, 3, '3C', 'free', '0', NULL),
(5492, 3, '3D', 'free', '0', NULL),
(5493, 3, '3E', 'free', '0', NULL),
(5494, 3, '3F', 'free', '1', NULL),
(5495, 3, '4A', 'free', '0', NULL),
(5496, 3, '4B', 'free', '0', NULL),
(5497, 3, '4C', 'free', '0', NULL),
(5498, 3, '4D', 'free', '0', NULL),
(5499, 3, '4E', 'free', '0', NULL),
(5500, 3, '4F', 'free', '1', NULL),
(5501, 3, '5A', 'free', '0', NULL),
(5502, 3, '5B', 'free', '0', NULL),
(5503, 3, '5C', 'free', '0', NULL),
(5504, 3, '5D', 'free', '0', NULL),
(5505, 3, '5E', 'free', '0', NULL),
(5506, 3, '5F', 'free', '1', NULL),
(5507, 3, '6A', 'free', '0', NULL),
(5508, 3, '6B', 'free', '0', NULL),
(5509, 3, '6C', 'free', '0', NULL),
(5510, 3, '6D', 'free', '0', NULL),
(5511, 3, '6E', 'free', '0', NULL),
(5512, 3, '6F', 'free', '1', NULL),
(5513, 3, '7A', 'free', '0', NULL),
(5514, 3, '7B', 'free', '0', NULL),
(5515, 3, '7C', 'free', '0', NULL),
(5516, 3, '7D', 'free', '0', NULL),
(5517, 3, '7E', 'free', '0', NULL),
(5518, 3, '7F', 'free', '0', NULL),
(5519, 3, '8A', 'free', '0', NULL),
(5520, 3, '8B', 'free', '0', NULL),
(5521, 3, '8C', 'free', '0', NULL),
(5522, 3, '8D', 'free', '0', NULL),
(5523, 3, '8E', 'free', '0', NULL),
(5524, 3, '8F', 'free', '0', NULL),
(5525, 3, '9A', 'free', '0', NULL),
(5526, 3, '9B', 'free', '0', NULL),
(5527, 3, '9C', 'free', '0', NULL),
(5528, 3, '9D', 'free', '0', NULL),
(5529, 3, '9E', 'free', '0', NULL),
(5530, 3, '9F', 'free', '0', NULL),
(5531, 3, '10A', 'free', '0', NULL),
(5532, 3, '10B', 'free', '0', NULL),
(5533, 3, '10C', 'free', '0', NULL),
(5534, 3, '10D', 'free', '0', NULL),
(5535, 3, '10E', 'free', '0', NULL),
(5536, 3, '10F', 'free', '0', NULL),
(5537, 4, '1A', 'free', '0', NULL),
(5538, 4, '1B', 'free', '0', NULL),
(5539, 4, '1C', 'free', '0', NULL),
(5540, 4, '1D', 'free', '0', NULL),
(5541, 4, '1E', 'free', '0', NULL),
(5542, 4, '1F', 'free', '1', NULL),
(5543, 4, '2A', 'free', '0', NULL),
(5544, 4, '2B', 'free', '0', NULL),
(5545, 4, '2C', 'free', '0', NULL),
(5546, 4, '2D', 'free', '0', NULL),
(5547, 4, '2E', 'free', '0', NULL),
(5548, 4, '2F', 'free', '1', NULL),
(5549, 4, '3A', 'free', '0', NULL),
(5550, 4, '3B', 'free', '0', NULL),
(5551, 4, '3C', 'free', '0', NULL),
(5552, 4, '3D', 'free', '0', NULL),
(5553, 4, '3E', 'free', '0', NULL),
(5554, 4, '3F', 'free', '1', NULL),
(5555, 4, '4A', 'free', '0', NULL),
(5556, 4, '4B', 'free', '0', NULL),
(5557, 4, '4C', 'free', '0', NULL),
(5558, 4, '4D', 'free', '0', NULL),
(5559, 4, '4E', 'free', '0', NULL),
(5560, 4, '4F', 'free', '1', NULL),
(5561, 4, '5A', 'free', '0', NULL),
(5562, 4, '5B', 'free', '0', NULL),
(5563, 4, '5C', 'free', '0', NULL),
(5564, 4, '5D', 'free', '0', NULL),
(5565, 4, '5E', 'free', '0', NULL),
(5566, 4, '5F', 'free', '1', NULL),
(5567, 4, '6A', 'free', '0', NULL),
(5568, 4, '6B', 'free', '0', NULL),
(5569, 4, '6C', 'free', '0', NULL),
(5570, 4, '6D', 'free', '0', NULL),
(5571, 4, '6E', 'free', '0', NULL),
(5572, 4, '6F', 'free', '1', NULL),
(5573, 4, '7A', 'free', '0', NULL),
(5574, 4, '7B', 'free', '0', NULL),
(5575, 4, '7C', 'free', '0', NULL),
(5576, 4, '7D', 'free', '0', NULL),
(5577, 4, '7E', 'free', '0', NULL),
(5578, 4, '7F', 'free', '0', NULL),
(5579, 4, '8A', 'free', '0', NULL),
(5580, 4, '8B', 'free', '0', NULL),
(5581, 4, '8C', 'free', '0', NULL),
(5582, 4, '8D', 'free', '0', NULL),
(5583, 4, '8E', 'free', '0', NULL),
(5584, 4, '8F', 'free', '0', NULL),
(5585, 4, '9A', 'free', '0', NULL),
(5586, 4, '9B', 'free', '0', NULL),
(5587, 4, '9C', 'free', '0', NULL),
(5588, 4, '9D', 'free', '0', NULL),
(5589, 4, '9E', 'free', '0', NULL),
(5590, 4, '9F', 'free', '0', NULL),
(5591, 4, '10A', 'free', '0', NULL),
(5592, 4, '10B', 'free', '0', NULL),
(5593, 4, '10C', 'free', '0', NULL),
(5594, 4, '10D', 'free', '0', NULL),
(5595, 4, '10E', 'free', '0', NULL),
(5596, 4, '10F', 'free', '0', NULL),
(5597, 5, '1A', 'free', '0', NULL),
(5598, 5, '1B', 'free', '0', NULL),
(5599, 5, '1C', 'free', '0', NULL),
(5600, 5, '1D', 'free', '0', NULL),
(5601, 5, '1E', 'free', '0', NULL),
(5602, 5, '1F', 'free', '1', NULL),
(5603, 5, '2A', 'free', '0', NULL),
(5604, 5, '2B', 'free', '0', NULL),
(5605, 5, '2C', 'free', '0', NULL),
(5606, 5, '2D', 'free', '0', NULL),
(5607, 5, '2E', 'free', '0', NULL),
(5608, 5, '2F', 'free', '1', NULL),
(5609, 5, '3A', 'free', '0', NULL),
(5610, 5, '3B', 'free', '0', NULL),
(5611, 5, '3C', 'free', '0', NULL),
(5612, 5, '3D', 'free', '0', NULL),
(5613, 5, '3E', 'free', '0', NULL),
(5614, 5, '3F', 'free', '1', NULL),
(5615, 5, '4A', 'free', '0', NULL),
(5616, 5, '4B', 'free', '0', NULL),
(5617, 5, '4C', 'free', '0', NULL),
(5618, 5, '4D', 'free', '0', NULL),
(5619, 5, '4E', 'free', '0', NULL),
(5620, 5, '4F', 'free', '1', NULL),
(5621, 5, '5A', 'free', '0', NULL),
(5622, 5, '5B', 'free', '0', NULL),
(5623, 5, '5C', 'free', '0', NULL),
(5624, 5, '5D', 'free', '0', NULL),
(5625, 5, '5E', 'free', '0', NULL),
(5626, 5, '5F', 'free', '1', NULL),
(5627, 5, '6A', 'free', '0', NULL),
(5628, 5, '6B', 'free', '0', NULL),
(5629, 5, '6C', 'free', '0', NULL),
(5630, 5, '6D', 'free', '0', NULL),
(5631, 5, '6E', 'free', '0', NULL),
(5632, 5, '6F', 'free', '1', NULL),
(5633, 5, '7A', 'free', '0', NULL),
(5634, 5, '7B', 'free', '0', NULL),
(5635, 5, '7C', 'free', '0', NULL),
(5636, 5, '7D', 'free', '0', NULL),
(5637, 5, '7E', 'free', '0', NULL),
(5638, 5, '7F', 'free', '0', NULL),
(5639, 5, '8A', 'free', '0', NULL),
(5640, 5, '8B', 'free', '0', NULL),
(5641, 5, '8C', 'free', '0', NULL),
(5642, 5, '8D', 'free', '0', NULL),
(5643, 5, '8E', 'free', '0', NULL),
(5644, 5, '8F', 'free', '0', NULL),
(5645, 5, '9A', 'free', '0', NULL),
(5646, 5, '9B', 'free', '0', NULL),
(5647, 5, '9C', 'free', '0', NULL),
(5648, 5, '9D', 'free', '0', NULL),
(5649, 5, '9E', 'free', '0', NULL),
(5650, 5, '9F', 'free', '0', NULL),
(5651, 5, '10A', 'free', '0', NULL),
(5652, 5, '10B', 'free', '0', NULL),
(5653, 5, '10C', 'free', '0', NULL),
(5654, 5, '10D', 'free', '0', NULL),
(5655, 5, '10E', 'free', '0', NULL),
(5656, 5, '10F', 'free', '0', NULL),
(5657, 6, '1A', 'free', '0', NULL),
(5658, 6, '1B', 'free', '0', NULL),
(5659, 6, '1C', 'free', '0', NULL),
(5660, 6, '1D', 'free', '0', NULL),
(5661, 6, '1E', 'free', '0', NULL),
(5662, 6, '1F', 'free', '1', NULL),
(5663, 6, '2A', 'free', '0', NULL),
(5664, 6, '2B', 'free', '0', NULL),
(5665, 6, '2C', 'free', '0', NULL),
(5666, 6, '2D', 'free', '0', NULL),
(5667, 6, '2E', 'free', '0', NULL),
(5668, 6, '2F', 'free', '1', NULL),
(5669, 6, '3A', 'free', '0', NULL),
(5670, 6, '3B', 'free', '0', NULL),
(5671, 6, '3C', 'free', '0', NULL),
(5672, 6, '3D', 'free', '0', NULL),
(5673, 6, '3E', 'free', '0', NULL),
(5674, 6, '3F', 'free', '1', NULL),
(5675, 6, '4A', 'free', '0', NULL),
(5676, 6, '4B', 'free', '0', NULL),
(5677, 6, '4C', 'free', '0', NULL),
(5678, 6, '4D', 'free', '0', NULL),
(5679, 6, '4E', 'free', '0', NULL),
(5680, 6, '4F', 'free', '1', NULL),
(5681, 6, '5A', 'free', '0', NULL),
(5682, 6, '5B', 'free', '0', NULL),
(5683, 6, '5C', 'free', '0', NULL),
(5684, 6, '5D', 'free', '0', NULL),
(5685, 6, '5E', 'free', '0', NULL),
(5686, 6, '5F', 'free', '1', NULL),
(5687, 6, '6A', 'free', '0', NULL),
(5688, 6, '6B', 'free', '0', NULL),
(5689, 6, '6C', 'free', '0', NULL),
(5690, 6, '6D', 'free', '0', NULL),
(5691, 6, '6E', 'free', '0', NULL),
(5692, 6, '6F', 'free', '1', NULL),
(5693, 6, '7A', 'free', '0', NULL),
(5694, 6, '7B', 'free', '0', NULL),
(5695, 6, '7C', 'free', '0', NULL),
(5696, 6, '7D', 'free', '0', NULL),
(5697, 6, '7E', 'free', '0', NULL),
(5698, 6, '7F', 'free', '0', NULL),
(5699, 6, '8A', 'free', '0', NULL),
(5700, 6, '8B', 'free', '0', NULL),
(5701, 6, '8C', 'free', '0', NULL),
(5702, 6, '8D', 'free', '0', NULL),
(5703, 6, '8E', 'free', '0', NULL),
(5704, 6, '8F', 'free', '0', NULL),
(5705, 6, '9A', 'free', '0', NULL),
(5706, 6, '9B', 'free', '0', NULL),
(5707, 6, '9C', 'free', '0', NULL),
(5708, 6, '9D', 'free', '0', NULL),
(5709, 6, '9E', 'free', '0', NULL),
(5710, 6, '9F', 'free', '0', NULL),
(5711, 6, '10A', 'free', '0', NULL),
(5712, 6, '10B', 'free', '0', NULL),
(5713, 6, '10C', 'free', '0', NULL),
(5714, 6, '10D', 'free', '0', NULL),
(5715, 6, '10E', 'free', '0', NULL),
(5716, 6, '10F', 'free', '0', NULL),
(5717, 7, '1A', 'free', '0', NULL),
(5718, 7, '1B', 'free', '0', NULL),
(5719, 7, '1C', 'free', '0', NULL),
(5720, 7, '1D', 'free', '0', NULL),
(5721, 7, '1E', 'free', '0', NULL),
(5722, 7, '1F', 'free', '1', NULL),
(5723, 7, '2A', 'free', '0', NULL),
(5724, 7, '2B', 'free', '0', NULL),
(5725, 7, '2C', 'free', '0', NULL),
(5726, 7, '2D', 'free', '0', NULL),
(5727, 7, '2E', 'free', '0', NULL),
(5728, 7, '2F', 'free', '1', NULL),
(5729, 7, '3A', 'free', '0', NULL),
(5730, 7, '3B', 'free', '0', NULL),
(5731, 7, '3C', 'free', '0', NULL),
(5732, 7, '3D', 'free', '0', NULL),
(5733, 7, '3E', 'free', '0', NULL),
(5734, 7, '3F', 'free', '1', NULL),
(5735, 7, '4A', 'free', '0', NULL),
(5736, 7, '4B', 'free', '0', NULL),
(5737, 7, '4C', 'free', '0', NULL),
(5738, 7, '4D', 'free', '0', NULL),
(5739, 7, '4E', 'free', '0', NULL),
(5740, 7, '4F', 'free', '1', NULL),
(5741, 7, '5A', 'free', '0', NULL),
(5742, 7, '5B', 'free', '0', NULL),
(5743, 7, '5C', 'free', '0', NULL),
(5744, 7, '5D', 'free', '0', NULL),
(5745, 7, '5E', 'free', '0', NULL),
(5746, 7, '5F', 'free', '1', NULL),
(5747, 7, '6A', 'free', '0', NULL),
(5748, 7, '6B', 'free', '0', NULL),
(5749, 7, '6C', 'free', '0', NULL),
(5750, 7, '6D', 'free', '0', NULL),
(5751, 7, '6E', 'free', '0', NULL),
(5752, 7, '6F', 'free', '1', NULL),
(5753, 7, '7A', 'free', '0', NULL),
(5754, 7, '7B', 'free', '0', NULL),
(5755, 7, '7C', 'free', '0', NULL),
(5756, 7, '7D', 'free', '0', NULL),
(5757, 7, '7E', 'free', '0', NULL),
(5758, 7, '7F', 'free', '0', NULL),
(5759, 7, '8A', 'free', '0', NULL),
(5760, 7, '8B', 'free', '0', NULL),
(5761, 7, '8C', 'free', '0', NULL),
(5762, 7, '8D', 'free', '0', NULL),
(5763, 7, '8E', 'free', '0', NULL),
(5764, 7, '8F', 'free', '0', NULL),
(5765, 7, '9A', 'free', '0', NULL),
(5766, 7, '9B', 'free', '0', NULL),
(5767, 7, '9C', 'free', '0', NULL),
(5768, 7, '9D', 'free', '0', NULL),
(5769, 7, '9E', 'free', '0', NULL),
(5770, 7, '9F', 'free', '0', NULL),
(5771, 7, '10A', 'free', '0', NULL),
(5772, 7, '10B', 'free', '0', NULL),
(5773, 7, '10C', 'free', '0', NULL),
(5774, 7, '10D', 'free', '0', NULL),
(5775, 7, '10E', 'free', '0', NULL),
(5776, 7, '10F', 'free', '0', NULL),
(5777, 8, '1A', 'free', '0', NULL),
(5778, 8, '1B', 'free', '0', NULL),
(5779, 8, '1C', 'free', '0', NULL),
(5780, 8, '1D', 'free', '0', NULL),
(5781, 8, '1E', 'free', '0', NULL),
(5782, 8, '1F', 'free', '1', NULL),
(5783, 8, '2A', 'free', '0', NULL),
(5784, 8, '2B', 'free', '0', NULL),
(5785, 8, '2C', 'free', '0', NULL),
(5786, 8, '2D', 'free', '0', NULL),
(5787, 8, '2E', 'free', '0', NULL),
(5788, 8, '2F', 'free', '1', NULL),
(5789, 8, '3A', 'free', '0', NULL),
(5790, 8, '3B', 'free', '0', NULL),
(5791, 8, '3C', 'free', '0', NULL),
(5792, 8, '3D', 'free', '0', NULL),
(5793, 8, '3E', 'free', '0', NULL),
(5794, 8, '3F', 'free', '1', NULL),
(5795, 8, '4A', 'free', '0', NULL),
(5796, 8, '4B', 'free', '0', NULL),
(5797, 8, '4C', 'free', '0', NULL),
(5798, 8, '4D', 'free', '0', NULL),
(5799, 8, '4E', 'free', '0', NULL),
(5800, 8, '4F', 'free', '1', NULL),
(5801, 8, '5A', 'free', '0', NULL),
(5802, 8, '5B', 'free', '0', NULL),
(5803, 8, '5C', 'free', '0', NULL),
(5804, 8, '5D', 'free', '0', NULL),
(5805, 8, '5E', 'free', '0', NULL),
(5806, 8, '5F', 'free', '1', NULL),
(5807, 8, '6A', 'free', '0', NULL),
(5808, 8, '6B', 'free', '0', NULL),
(5809, 8, '6C', 'free', '0', NULL),
(5810, 8, '6D', 'free', '0', NULL),
(5811, 8, '6E', 'free', '0', NULL),
(5812, 8, '6F', 'free', '1', NULL),
(5813, 8, '7A', 'free', '0', NULL),
(5814, 8, '7B', 'free', '0', NULL),
(5815, 8, '7C', 'free', '0', NULL),
(5816, 8, '7D', 'free', '0', NULL),
(5817, 8, '7E', 'free', '0', NULL),
(5818, 8, '7F', 'free', '0', NULL),
(5819, 8, '8A', 'free', '0', NULL),
(5820, 8, '8B', 'free', '0', NULL),
(5821, 8, '8C', 'free', '0', NULL),
(5822, 8, '8D', 'free', '0', NULL),
(5823, 8, '8E', 'free', '0', NULL),
(5824, 8, '8F', 'free', '0', NULL),
(5825, 8, '9A', 'free', '0', NULL),
(5826, 8, '9B', 'free', '0', NULL),
(5827, 8, '9C', 'free', '0', NULL),
(5828, 8, '9D', 'free', '0', NULL),
(5829, 8, '9E', 'free', '0', NULL),
(5830, 8, '9F', 'free', '0', NULL),
(5831, 8, '10A', 'free', '0', NULL),
(5832, 8, '10B', 'free', '0', NULL),
(5833, 8, '10C', 'free', '0', NULL),
(5834, 8, '10D', 'free', '0', NULL),
(5835, 8, '10E', 'free', '0', NULL),
(5836, 8, '10F', 'free', '0', NULL),
(5837, 9, '1A', 'free', '0', NULL),
(5838, 9, '1B', 'free', '0', NULL),
(5839, 9, '1C', 'free', '0', NULL),
(5840, 9, '1D', 'free', '0', NULL),
(5841, 9, '1E', 'free', '0', NULL),
(5842, 9, '1F', 'free', '1', NULL),
(5843, 9, '2A', 'free', '0', NULL),
(5844, 9, '2B', 'free', '0', NULL),
(5845, 9, '2C', 'free', '0', NULL),
(5846, 9, '2D', 'free', '0', NULL),
(5847, 9, '2E', 'free', '0', NULL),
(5848, 9, '2F', 'free', '1', NULL),
(5849, 9, '3A', 'free', '0', NULL),
(5850, 9, '3B', 'free', '0', NULL),
(5851, 9, '3C', 'free', '0', NULL),
(5852, 9, '3D', 'free', '0', NULL),
(5853, 9, '3E', 'free', '0', NULL),
(5854, 9, '3F', 'free', '1', NULL),
(5855, 9, '4A', 'free', '0', NULL),
(5856, 9, '4B', 'free', '0', NULL),
(5857, 9, '4C', 'free', '0', NULL),
(5858, 9, '4D', 'free', '0', NULL),
(5859, 9, '4E', 'free', '0', NULL),
(5860, 9, '4F', 'free', '1', NULL),
(5861, 9, '5A', 'free', '0', NULL),
(5862, 9, '5B', 'free', '0', NULL),
(5863, 9, '5C', 'free', '0', NULL),
(5864, 9, '5D', 'free', '0', NULL),
(5865, 9, '5E', 'free', '0', NULL),
(5866, 9, '5F', 'free', '1', NULL),
(5867, 9, '6A', 'free', '0', NULL),
(5868, 9, '6B', 'free', '0', NULL),
(5869, 9, '6C', 'free', '0', NULL),
(5870, 9, '6D', 'free', '0', NULL),
(5871, 9, '6E', 'free', '0', NULL),
(5872, 9, '6F', 'free', '1', NULL),
(5873, 9, '7A', 'free', '0', NULL),
(5874, 9, '7B', 'free', '0', NULL),
(5875, 9, '7C', 'free', '0', NULL),
(5876, 9, '7D', 'free', '0', NULL),
(5877, 9, '7E', 'free', '0', NULL),
(5878, 9, '7F', 'free', '0', NULL),
(5879, 9, '8A', 'free', '0', NULL),
(5880, 9, '8B', 'free', '0', NULL),
(5881, 9, '8C', 'free', '0', NULL),
(5882, 9, '8D', 'free', '0', NULL),
(5883, 9, '8E', 'free', '0', NULL),
(5884, 9, '8F', 'free', '0', NULL),
(5885, 9, '9A', 'free', '0', NULL),
(5886, 9, '9B', 'free', '0', NULL),
(5887, 9, '9C', 'free', '0', NULL),
(5888, 9, '9D', 'free', '0', NULL),
(5889, 9, '9E', 'free', '0', NULL),
(5890, 9, '9F', 'free', '0', NULL),
(5891, 9, '10A', 'free', '0', NULL),
(5892, 9, '10B', 'free', '0', NULL),
(5893, 9, '10C', 'free', '0', NULL),
(5894, 9, '10D', 'free', '0', NULL),
(5895, 9, '10E', 'free', '0', NULL),
(5896, 9, '10F', 'free', '0', NULL),
(5897, 10, '1A', 'free', '0', NULL),
(5898, 10, '1B', 'free', '0', NULL),
(5899, 10, '1C', 'free', '0', NULL),
(5900, 10, '1D', 'free', '0', NULL),
(5901, 10, '1E', 'free', '0', NULL),
(5902, 10, '1F', 'free', '1', NULL),
(5903, 10, '2A', 'free', '0', NULL),
(5904, 10, '2B', 'free', '0', NULL),
(5905, 10, '2C', 'free', '0', NULL),
(5906, 10, '2D', 'free', '0', NULL),
(5907, 10, '2E', 'free', '0', NULL),
(5908, 10, '2F', 'free', '1', NULL),
(5909, 10, '3A', 'free', '0', NULL),
(5910, 10, '3B', 'free', '0', NULL),
(5911, 10, '3C', 'free', '0', NULL),
(5912, 10, '3D', 'free', '0', NULL),
(5913, 10, '3E', 'free', '0', NULL),
(5914, 10, '3F', 'free', '1', NULL),
(5915, 10, '4A', 'free', '0', NULL),
(5916, 10, '4B', 'free', '0', NULL),
(5917, 10, '4C', 'free', '0', NULL),
(5918, 10, '4D', 'free', '0', NULL),
(5919, 10, '4E', 'free', '0', NULL),
(5920, 10, '4F', 'free', '1', NULL),
(5921, 10, '5A', 'free', '0', NULL),
(5922, 10, '5B', 'free', '0', NULL),
(5923, 10, '5C', 'free', '0', NULL),
(5924, 10, '5D', 'free', '0', NULL),
(5925, 10, '5E', 'free', '0', NULL),
(5926, 10, '5F', 'free', '1', NULL),
(5927, 10, '6A', 'free', '0', NULL),
(5928, 10, '6B', 'free', '0', NULL),
(5929, 10, '6C', 'free', '0', NULL),
(5930, 10, '6D', 'free', '0', NULL),
(5931, 10, '6E', 'free', '0', NULL),
(5932, 10, '6F', 'free', '1', NULL),
(5933, 10, '7A', 'free', '0', NULL),
(5934, 10, '7B', 'free', '0', NULL),
(5935, 10, '7C', 'free', '0', NULL),
(5936, 10, '7D', 'free', '0', NULL),
(5937, 10, '7E', 'free', '0', NULL),
(5938, 10, '7F', 'free', '0', NULL),
(5939, 10, '8A', 'free', '0', NULL),
(5940, 10, '8B', 'free', '0', NULL),
(5941, 10, '8C', 'free', '0', NULL),
(5942, 10, '8D', 'free', '0', NULL),
(5943, 10, '8E', 'free', '0', NULL),
(5944, 10, '8F', 'free', '0', NULL),
(5945, 10, '9A', 'free', '0', NULL),
(5946, 10, '9B', 'free', '0', NULL),
(5947, 10, '9C', 'free', '0', NULL),
(5948, 10, '9D', 'free', '0', NULL),
(5949, 10, '9E', 'free', '0', NULL),
(5950, 10, '9F', 'free', '0', NULL),
(5951, 10, '10A', 'free', '0', NULL),
(5952, 10, '10B', 'free', '0', NULL),
(5953, 10, '10C', 'free', '0', NULL),
(5954, 10, '10D', 'free', '0', NULL),
(5955, 10, '10E', 'free', '0', NULL),
(5956, 10, '10F', 'free', '0', NULL),
(5957, 11, '1A', 'free', '0', NULL),
(5958, 11, '1B', 'free', '0', NULL),
(5959, 11, '1C', 'free', '0', NULL),
(5960, 11, '1D', 'free', '0', NULL),
(5961, 11, '1E', 'free', '0', NULL),
(5962, 11, '1F', 'free', '1', NULL),
(5963, 11, '2A', 'free', '0', NULL),
(5964, 11, '2B', 'free', '0', NULL),
(5965, 11, '2C', 'free', '0', NULL),
(5966, 11, '2D', 'free', '0', NULL),
(5967, 11, '2E', 'free', '0', NULL),
(5968, 11, '2F', 'free', '1', NULL),
(5969, 11, '3A', 'free', '0', NULL),
(5970, 11, '3B', 'free', '0', NULL),
(5971, 11, '3C', 'free', '0', NULL),
(5972, 11, '3D', 'free', '0', NULL),
(5973, 11, '3E', 'free', '0', NULL),
(5974, 11, '3F', 'free', '1', NULL),
(5975, 11, '4A', 'free', '0', NULL),
(5976, 11, '4B', 'free', '0', NULL),
(5977, 11, '4C', 'free', '0', NULL),
(5978, 11, '4D', 'free', '0', NULL),
(5979, 11, '4E', 'free', '0', NULL),
(5980, 11, '4F', 'free', '1', NULL),
(5981, 11, '5A', 'free', '0', NULL),
(5982, 11, '5B', 'free', '0', NULL),
(5983, 11, '5C', 'free', '0', NULL),
(5984, 11, '5D', 'free', '0', NULL),
(5985, 11, '5E', 'free', '0', NULL),
(5986, 11, '5F', 'free', '1', NULL),
(5987, 11, '6A', 'free', '0', NULL),
(5988, 11, '6B', 'free', '0', NULL),
(5989, 11, '6C', 'free', '0', NULL),
(5990, 11, '6D', 'free', '0', NULL),
(5991, 11, '6E', 'free', '0', NULL),
(5992, 11, '6F', 'free', '1', NULL),
(5993, 11, '7A', 'free', '0', NULL),
(5994, 11, '7B', 'free', '0', NULL),
(5995, 11, '7C', 'free', '0', NULL),
(5996, 11, '7D', 'free', '0', NULL),
(5997, 11, '7E', 'free', '0', NULL),
(5998, 11, '7F', 'free', '0', NULL),
(5999, 11, '8A', 'free', '0', NULL),
(6000, 11, '8B', 'free', '0', NULL),
(6001, 11, '8C', 'free', '0', NULL),
(6002, 11, '8D', 'free', '0', NULL),
(6003, 11, '8E', 'free', '0', NULL),
(6004, 11, '8F', 'free', '0', NULL),
(6005, 11, '9A', 'free', '0', NULL),
(6006, 11, '9B', 'free', '0', NULL),
(6007, 11, '9C', 'free', '0', NULL),
(6008, 11, '9D', 'free', '0', NULL),
(6009, 11, '9E', 'free', '0', NULL),
(6010, 11, '9F', 'free', '0', NULL),
(6011, 11, '10A', 'free', '0', NULL),
(6012, 11, '10B', 'free', '0', NULL),
(6013, 11, '10C', 'free', '0', NULL),
(6014, 11, '10D', 'free', '0', NULL),
(6015, 11, '10E', 'free', '0', NULL),
(6016, 11, '10F', 'free', '0', NULL),
(6017, 12, '1A', 'free', '0', NULL),
(6018, 12, '1B', 'free', '0', NULL),
(6019, 12, '1C', 'free', '0', NULL),
(6020, 12, '1D', 'free', '0', NULL),
(6021, 12, '1E', 'free', '0', NULL),
(6022, 12, '1F', 'free', '1', NULL),
(6023, 12, '2A', 'free', '0', NULL),
(6024, 12, '2B', 'free', '0', NULL),
(6025, 12, '2C', 'free', '0', NULL),
(6026, 12, '2D', 'free', '0', NULL),
(6027, 12, '2E', 'free', '0', NULL),
(6028, 12, '2F', 'free', '1', NULL),
(6029, 12, '3A', 'free', '0', NULL),
(6030, 12, '3B', 'free', '0', NULL),
(6031, 12, '3C', 'free', '0', NULL),
(6032, 12, '3D', 'free', '0', NULL),
(6033, 12, '3E', 'free', '0', NULL),
(6034, 12, '3F', 'free', '1', NULL),
(6035, 12, '4A', 'free', '0', NULL),
(6036, 12, '4B', 'free', '0', NULL),
(6037, 12, '4C', 'free', '0', NULL),
(6038, 12, '4D', 'free', '0', NULL),
(6039, 12, '4E', 'free', '0', NULL),
(6040, 12, '4F', 'free', '1', NULL),
(6041, 12, '5A', 'free', '0', NULL),
(6042, 12, '5B', 'free', '0', NULL),
(6043, 12, '5C', 'free', '0', NULL),
(6044, 12, '5D', 'free', '0', NULL),
(6045, 12, '5E', 'free', '0', NULL),
(6046, 12, '5F', 'free', '1', NULL),
(6047, 12, '6A', 'free', '0', NULL),
(6048, 12, '6B', 'free', '0', NULL),
(6049, 12, '6C', 'free', '0', NULL),
(6050, 12, '6D', 'free', '0', NULL),
(6051, 12, '6E', 'free', '0', NULL),
(6052, 12, '6F', 'free', '1', NULL),
(6053, 12, '7A', 'free', '0', NULL),
(6054, 12, '7B', 'free', '0', NULL),
(6055, 12, '7C', 'free', '0', NULL),
(6056, 12, '7D', 'free', '0', NULL),
(6057, 12, '7E', 'free', '0', NULL),
(6058, 12, '7F', 'free', '0', NULL),
(6059, 12, '8A', 'free', '0', NULL),
(6060, 12, '8B', 'free', '0', NULL),
(6061, 12, '8C', 'free', '0', NULL),
(6062, 12, '8D', 'free', '0', NULL),
(6063, 12, '8E', 'free', '0', NULL),
(6064, 12, '8F', 'free', '0', NULL),
(6065, 12, '9A', 'free', '0', NULL),
(6066, 12, '9B', 'free', '0', NULL),
(6067, 12, '9C', 'free', '0', NULL),
(6068, 12, '9D', 'free', '0', NULL),
(6069, 12, '9E', 'free', '0', NULL),
(6070, 12, '9F', 'free', '0', NULL),
(6071, 12, '10A', 'free', '0', NULL),
(6072, 12, '10B', 'free', '0', NULL),
(6073, 12, '10C', 'free', '0', NULL),
(6074, 12, '10D', 'free', '0', NULL),
(6075, 12, '10E', 'free', '0', NULL),
(6076, 12, '10F', 'free', '0', NULL);

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
  MODIFY `SeatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6077;

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
