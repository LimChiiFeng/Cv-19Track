-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2020 at 04:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ct`
--

-- --------------------------------------------------------

--
-- Table structure for table `covidtest`
--

CREATE TABLE `covidtest` (
  `testID` int(5) NOT NULL,
  `testDate` date NOT NULL,
  `kitID` int(5) NOT NULL,
  `patientUsername` varchar(30) NOT NULL,
  `testerUsername` varchar(30) NOT NULL,
  `result` varchar(300) NOT NULL,
  `resultDate` date NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `testcentre`
--

CREATE TABLE `testcentre` (
  `centreID` int(5) NOT NULL,
  `centreName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testcentre`
--

INSERT INTO `testcentre` (`centreID`, `centreName`) VALUES
(1, 'Test Centre 1'),
(2, 'Test Centre 2');

-- --------------------------------------------------------

--
-- Table structure for table `testkit`
--

CREATE TABLE `testkit` (
  `testName` varchar(40) NOT NULL,
  `kitID` int(10) NOT NULL,
  `availableStock` int(255) NOT NULL DEFAULT 0,
  `centreID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(15) NOT NULL,
  `password` varchar(300) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `patientType` varchar(20) DEFAULT NULL,
  `symptoms` varchar(15) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `centreID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `email`, `type`, `patientType`, `symptoms`, `position`, `centreID`) VALUES
('Officer1', '$2y$10$86nk5bDfeL/2lS/87TZV2uSUPBfBm0XGWxGbIHDrlQfLRSwfeEiAy', 'Emilia', NULL, 'centreOfficer', NULL, NULL, 'Manager', 1),
('Officer2', '$2y$10$kAXhADhY4XqSLn7FCDrbReHDVOTJEnfPbmyKR0hnYN1U7uaETR8ve', 'Rein', NULL, 'centreOfficer', NULL, NULL, 'Manager', 2),
('Patient1', '$2y$10$zh5Wxlg7ySOrrh/Q.WVJi.G/Bvo9RNCbpJUMw75ep2w52jd/NRXtC', 'Patient1', 'patient1@gmail.com', 'patient', 'returnee', 'None', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `covidtest`
--
ALTER TABLE `covidtest`
  ADD PRIMARY KEY (`testID`),
  ADD KEY `kitID` (`kitID`),
  ADD KEY `patientName` (`patientUsername`),
  ADD KEY `testerName` (`testerUsername`);

--
-- Indexes for table `testcentre`
--
ALTER TABLE `testcentre`
  ADD PRIMARY KEY (`centreID`);

--
-- Indexes for table `testkit`
--
ALTER TABLE `testkit`
  ADD PRIMARY KEY (`kitID`),
  ADD KEY `centreID` (`centreID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `centreID` (`centreID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `covidtest`
--
ALTER TABLE `covidtest`
  MODIFY `testID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testcentre`
--
ALTER TABLE `testcentre`
  MODIFY `centreID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testkit`
--
ALTER TABLE `testkit`
  MODIFY `kitID` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `covidtest`
--
ALTER TABLE `covidtest`
  ADD CONSTRAINT `covidtest_ibfk_1` FOREIGN KEY (`kitID`) REFERENCES `testkit` (`kitID`),
  ADD CONSTRAINT `covidtest_ibfk_2` FOREIGN KEY (`patientUsername`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `covidtest_ibfk_3` FOREIGN KEY (`testerUsername`) REFERENCES `user` (`username`);

--
-- Constraints for table `testkit`
--
ALTER TABLE `testkit`
  ADD CONSTRAINT `testkit_ibfk_1` FOREIGN KEY (`centreID`) REFERENCES `testcentre` (`centreID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`centreID`) REFERENCES `testcentre` (`centreID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
