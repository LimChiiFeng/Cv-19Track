-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2020 at 10:19 AM
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
-- Database: `v2_ct`
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
  `result` varchar(300) DEFAULT NULL,
  `resultDate` date DEFAULT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `covidtest`
--

INSERT INTO `covidtest` (`testID`, `testDate`, `kitID`, `patientUsername`, `testerUsername`, `result`, `resultDate`, `status`) VALUES
(14, '2020-10-20', 16, 'Patient02', 'Tester01', NULL, NULL, 'pending'),
(15, '2020-10-20', 3, 'Patient03', 'Tester01', 'Negative', '2020-10-23', 'complate'),
(16, '2020-10-20', 4, 'Patient04', 'Tester01', 'Negative', '2020-10-23', 'complate'),
(17, '2020-10-21', 4, 'Patient05', 'Tester01', NULL, NULL, 'pending'),
(18, '2020-10-21', 10, 'Patient06', 'Tester02', NULL, NULL, 'pending'),
(19, '2020-10-21', 15, 'Patient07', 'Tester02', NULL, NULL, 'pending'),
(21, '2020-10-23', 5, 'Patient06', 'Tester02', 'Positive', '2020-10-23', 'complate'),
(22, '2020-10-23', 16, 'Patient04', 'Tester01', 'Negative', '2020-10-23', 'complate'),
(23, '2020-10-23', 16, 'Patient05', 'Tester01', NULL, NULL, 'pending'),
(24, '2020-10-23', 2, 'Patient07', 'Tester02', 'Negative', '2020-10-23', 'complate'),
(25, '2020-10-23', 2, 'Patient08', 'Tester02', NULL, NULL, 'pending'),
(26, '2020-10-23', 2, 'Patient06', 'Tester02', NULL, NULL, 'pending'),
(27, '2020-10-24', 13, 'Patient09', 'Tester06', 'Negative', '2020-10-24', 'complate'),
(28, '2020-10-24', 11, 'Patient09', 'Tester06', NULL, NULL, 'pending'),
(29, '2020-10-24', 18, 'Patient10', 'Tester07', NULL, NULL, 'pending'),
(30, '2020-10-24', 12, 'Patient11', 'Tester05', NULL, NULL, 'pending');

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
(2, 'Test Centre 2'),
(4, 'HELP Test Centre'),
(5, 'HELP Subang Test Centre');

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

--
-- Dumping data for table `testkit`
--

INSERT INTO `testkit` (`testName`, `kitID`, `availableStock`, `centreID`) VALUES
('Test Kit 1', 1, 6, 2),
('Test kit 2', 2, 1, 2),
('Test kit 1', 3, 13, 1),
('Test kit 3', 4, 120, 1),
('Test Kit 4', 5, 12, 2),
('Test Kit 5', 6, 23, 2),
('EKF Diagnostics', 10, 22, 2),
('Test Kit 1', 11, 3, 4),
('Test Kit 2', 12, 9, 4),
('Test Kit 5', 13, 28, 4),
('Test Kit 3', 14, 4, 2),
('Test Kit 51', 15, 29, 2),
('Test Kit ABC ', 16, 61, 1),
('STANDARD Q COVID-19 IgM/IgG Duo', 17, 10, 5),
('SARS-COV-2 test kit VRI', 18, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(15) NOT NULL,
  `password` varchar(300) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(15) NOT NULL,
  `patientType` varchar(20) DEFAULT NULL,
  `symptoms` varchar(100) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `centreID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `type`, `patientType`, `symptoms`, `position`, `centreID`) VALUES
('Officer1', '$2y$10$86nk5bDfeL/2lS/87TZV2uSUPBfBm0XGWxGbIHDrlQfLRSwfeEiAy', 'Emilia', 'centreOfficer', NULL, NULL, 'Manager', 1),
('Officer2', '$2y$10$kAXhADhY4XqSLn7FCDrbReHDVOTJEnfPbmyKR0hnYN1U7uaETR8ve', 'Rein', 'centreOfficer', NULL, NULL, 'Manager', 2),
('Officer3', '$2y$10$rTBpW2xiixE9zCSVPDdMIOv8Jz.Xz.vG8p0rvQIg8BgUfhSvMnanG', 'Pork', 'centreOfficer', NULL, NULL, 'Manager', 5),
('Officer4', '$2y$10$lgI8j6OtQF601pRqyY5swOv5y27yfN4M6w8eshsb29uHU.pj0BymO', 'Rika', 'centreOfficer', NULL, NULL, 'Manager', NULL),
('Officer5', '$2y$10$WiufOWxi8lRehqM30tnEQegvOREOo1K5PuX8cQs9PR7FCwE5bZoJC', 'Officer5', 'centreOfficer', NULL, NULL, 'Manager', 4),
('Officer6', '$2y$10$itVPNfCgPAc1nTNr2yVBU.ZZn3RfnBqE/UK9rif4zWxHxCqXQUDS2', 'Saitama', 'centreOfficer', NULL, NULL, 'Manager', NULL),
('Officer7', '$2y$10$bAfcVdjXU/2nQotEpVB/b.LklC3tl5YM3i44XsrgIn9dDep9yAUa2', 'Asuna', 'centreOfficer', NULL, NULL, 'Manager', NULL),
('Patient02', '$2y$10$OYT5IIotsSDUv5ZZ5vOO5Ol0fm0lMrCaz/pOwX.1aJUv0Bg/iPghK', 'Maple', 'patient', 'Quarantined', 'Yesaaa', NULL, 1),
('Patient03', '$2y$10$nUCF88aPaU4q8rxRh..Je.ml.NPYrMDBpiMNoZuvOUyyu4ee8r5BO', 'Salay', 'patient', 'Quarantined', 'None', NULL, 1),
('Patient04', '$2y$10$TDEEnZtR1F7QgP96NmWaIuJfyf.6uha9mV2TZlKCn1rEtW/b3w2RG', 'Rock', 'patient', 'Infected', 'AAhsjh2', NULL, 1),
('Patient05', '$2y$10$qOBXU4OmmDIpe9SKkkACt.u8xAKddp422BFKojEIiNdIMhtlZeRx2', 'July', 'patient', 'Close Contact', 'Hot', NULL, 1),
('Patient06', '$2y$10$xRVE58t5RwuUp0WGTDdRVudEYr1svCeHmgTZFbZmG6KG5ZaEL92VC', 'Queen', 'patient', 'Returnee', 'None', NULL, 2),
('Patient07', '$2y$10$h5tev0xV4Ocn4mXIUu9Oi.fkEx4Gvw901glFh4BIsLz5zU8rGJ2fu', 'Hawk', 'patient', 'Suspected', '5 Days', NULL, 2),
('Patient08', '$2y$10$Srlv2Yq5jZKfb0uMcjfWPeTxeBAHv/FBoAzklkFZsPR8LYA3LUvO2', 'Patient08', 'patient', 'Close Contact', ' Yessssssss', NULL, 2),
('Patient09', '$2y$10$oHXUF8g6r3P0VUzeT3Ac/OtOVpITW3UuI6fdA1/sT8uF4jHbRFND2', 'Jupiter', 'patient', 'Close Contact', 'YES', NULL, 4),
('Patient10', '$2y$10$xuyO793pObLUYPTg4x3UuusF.yofZBZ.XoCVfMr.iJWUSytgqmf4K', 'Miya', 'patient', 'Returnee', ' None', NULL, 5),
('Patient11', '$2y$10$OqAlGPJTUpdwK/X91TLSveL98ABvKtSI46hWNwPHZJ1nvvVhZ6CGu', 'Juliet', 'patient', 'Quarantined', ' None', NULL, 4),
('Tester01', '$2y$10$zlMReGxUkBYYcV9LAf4WzeMj4V7TowujIMunoIR95cMMus0L8JN2a', 'Sion', 'centreOfficer', 'returnee', 'None', 'Tester', 1),
('Tester02', '$2y$10$syhvLBptHQE5EGxcwa75juPXCWdqp/2GjRVJU918m2TdTRexBV9S.', 'Jack', 'centreOfficer', 'returnee', 'None', 'Tester', 2),
('Tester03', '$2y$10$gKveBQaDr6XXJ7JOjiB09eZmP5852rtYbNSH4pWZH2nKFXGqIC4VG', 'Risa', 'centreOfficer', NULL, NULL, 'Tester', 4),
('Tester04', '$2y$10$4OsSyEFQo5ISg9Wtx1XCburEdSzXX4FG68Z/NFcZ6RFHe8e.W3rm.', 'Kyen', 'centreOfficer', NULL, NULL, 'Tester', 1),
('Tester05', '$2y$10$O.Mk1e1xIxj/5l21iB9g6eFQz7rFbJRCn7wviDrnFPcS2hs9TgXyy', 'Minotaur', 'centreOfficer', NULL, NULL, 'Tester', 4),
('Tester06', '$2y$10$/qTkRDQIxocDpopLvM8EY.dViAWR28Pycunzq3gCHG6FJHD55PI/C', 'Ali', 'centreOfficer', NULL, NULL, 'Tester', 4),
('Tester07', '$2y$10$y787Kb97Wlr0sDcMGfZcO.2WXQRCT0v/JC.PSSc44ertX/llEQV7y', 'Neptune', 'centreOfficer', NULL, NULL, 'Tester', 5),
('Tester08', '$2y$10$VXO2ui6zhSRu/w7AWGD0SeH6LXvhYuH6AJhN5mlQ4FTAfL7K5fPjy', 'Xin Zhao', 'centreOfficer', NULL, NULL, 'Tester', 5);

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
  MODIFY `testID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `testcentre`
--
ALTER TABLE `testcentre`
  MODIFY `centreID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testkit`
--
ALTER TABLE `testkit`
  MODIFY `kitID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
