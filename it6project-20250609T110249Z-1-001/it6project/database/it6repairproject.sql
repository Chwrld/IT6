-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2025 at 10:48 AM
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
-- Database: `it6repairproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `appliances`
--

CREATE TABLE `appliances` (
  `ApplianceID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `Brand` varchar(50) DEFAULT NULL,
  `Product` varchar(50) DEFAULT NULL,
  `Model_No` varchar(50) DEFAULT NULL,
  `Serial_No` varchar(50) DEFAULT NULL,
  `Warranty_end` date DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `First_name` varchar(50) DEFAULT NULL,
  `Last_name` varchar(50) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Phone_no` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `PartID` int(11) NOT NULL,
  `Part_No` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partsused`
--

CREATE TABLE `partsused` (
  `UsageID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `PartID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Parts_Total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicedetail`
--

CREATE TABLE `servicedetail` (
  `ServiceDetailID` int(11) NOT NULL,
  `ReportID` int(11) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `Service_Type` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Labor_Cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicereport`
--

CREATE TABLE `servicereport` (
  `ReportID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `ApplianceID` int(11) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `Date_In` date DEFAULT NULL,
  `Date_pulled_out` date DEFAULT NULL,
  `Date_Repaired` date DEFAULT NULL,
  `Date_Delivered` date DEFAULT NULL,
  `Service_type` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Complaint` text DEFAULT NULL,
  `Cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `First_name` varchar(50) DEFAULT NULL,
  `Last_name` varchar(50) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactionID` int(11) NOT NULL,
  `ReportID` int(11) DEFAULT NULL,
  `Parts_Total` decimal(10,2) DEFAULT NULL,
  `Labor_Total` decimal(10,2) DEFAULT NULL,
  `Total_Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Status` varchar(50) DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL,
  `Received_By` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliances`
--
ALTER TABLE `appliances`
  ADD PRIMARY KEY (`ApplianceID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`PartID`);

--
-- Indexes for table `partsused`
--
ALTER TABLE `partsused`
  ADD PRIMARY KEY (`UsageID`),
  ADD KEY `ServiceDetailID` (`ServiceDetailID`),
  ADD KEY `PartID` (`PartID`);

--
-- Indexes for table `servicedetail`
--
ALTER TABLE `servicedetail`
  ADD PRIMARY KEY (`ServiceDetailID`),
  ADD KEY `ReportID` (`ReportID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `servicereport`
--
ALTER TABLE `servicereport`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `ApplianceID` (`ApplianceID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `ReportID` (`ReportID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appliances`
--
ALTER TABLE `appliances`
  MODIFY `ApplianceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `PartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partsused`
--
ALTER TABLE `partsused`
  MODIFY `UsageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicedetail`
--
ALTER TABLE `servicedetail`
  MODIFY `ServiceDetailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicereport`
--
ALTER TABLE `servicereport`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appliances`
--
ALTER TABLE `appliances`
  ADD CONSTRAINT `appliances_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partsused`
--
ALTER TABLE `partsused`
  ADD CONSTRAINT `partsused_ibfk_1` FOREIGN KEY (`ServiceDetailID`) REFERENCES `servicedetail` (`ServiceDetailID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partsused_ibfk_2` FOREIGN KEY (`PartID`) REFERENCES `parts` (`PartID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicedetail`
--
ALTER TABLE `servicedetail`
  ADD CONSTRAINT `servicedetail_ibfk_1` FOREIGN KEY (`ReportID`) REFERENCES `servicereport` (`ReportID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicedetail_ibfk_2` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicereport`
--
ALTER TABLE `servicereport`
  ADD CONSTRAINT `servicereport_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicereport_ibfk_2` FOREIGN KEY (`ApplianceID`) REFERENCES `appliances` (`ApplianceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicereport_ibfk_3` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`ReportID`) REFERENCES `servicereport` (`ReportID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
