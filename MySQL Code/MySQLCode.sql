-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2025 at 03:13 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u642322888_mydb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`u642322888_ltc4061`@`127.0.0.1` PROCEDURE `insert_employee_with_log` (IN `fname` VARCHAR(45), IN `lname` VARCHAR(45), IN `bdate` DATE, IN `sdate` DATE, IN `phone` VARCHAR(10), IN `addressID` INT, IN `dept` VARCHAR(3), IN `etype` ENUM('Civilian','Uniform'), IN `estatus` VARCHAR(45), IN `shield` VARCHAR(5))   BEGIN
    INSERT INTO employees (
        FirstName, LastName, BirthDate, StartDate,
        PhoneNumber, AddressID, DepartmentID,
        EmploymentType, EmploymentStatus, ShieldNumber
    ) VALUES (
        fname, lname, bdate, sdate,
        phone, addressID, dept,
        etype, estatus, shield
    );

    INSERT INTO employee_log (employee_name, action)
    VALUES (CONCAT(fname, ' ', lname), 'Inserted');
END$$

--
-- Functions
--
CREATE DEFINER=`u642322888_ltc4061`@`127.0.0.1` FUNCTION `get_employee_fullname` (`emp_id` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci DETERMINISTIC BEGIN
    DECLARE full_name VARCHAR(100);

    SELECT CONCAT(FirstName, ' ', LastName)
    INTO full_name
    FROM employees
    WHERE employeeID = emp_id;

    RETURN full_name;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `AddressID` int(11) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(45) NOT NULL,
  `State` varchar(2) NOT NULL,
  `ZipCode` varchar(5) NOT NULL,
  `employees_employeeID` int(11) NOT NULL,
  `employees_investigations_InvestigationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`AddressID`, `Street`, `City`, `State`, `ZipCode`, `employees_employeeID`, `employees_investigations_InvestigationID`) VALUES
(9, '25 Davis Ave', 'Port Washington', 'NY', '11050', 21, 0),
(10, '111 Main Street', 'Queens', 'NY', '11354', 24, 0),
(13, '455 Vampire Road', 'Staten Island', 'NY', '10301', 29, 0),
(14, '24-7 Street', 'New York', 'NY', '10038', 39, 0),
(100, '123 10th Ave', 'New York', 'NY', '10011', 40, 0),
(101, '456 Hudson St', 'New York', 'NY', '10014', 41, 0),
(102, '1 Police Plaza', 'New York', 'NY', '10038', 42, 0),
(103, '12 5th Ave', 'New York', 'NY', '10003', 43, 0),
(104, '99 7th Ave', 'New York', 'NY', '10011', 44, 0),
(105, '1010 Park Ave', 'New York', 'NY', '10028', 45, 0),
(107, '78 2nd St', 'New York', 'NY', '10002', 47, 0),
(109, '21 Queens Blvd', 'Queens', 'NY', '11375', 49, 0),
(110, '42 Gotham St', 'Brooklyn', 'NY', '11201', 50, 0),
(111, '35 Crime Alley', 'Brooklyn', 'NY', '11215', 51, 0),
(120, '500 Broadway', 'New York', 'NY', '10012', 48, 0),
(128, '935 Pennsylvania Ave', 'Washington', 'DC', '20535', 53, 0),
(155, 'J Edgar Hoover Bldg', 'Washington', 'DC', '20535', 54, 0),
(156, 'FBI Academy Rd', 'Quantico', 'VA', '22134', 52, 0),
(157, '31 Spooner Street', 'Quahog', 'RI', '02906', 58, 0),
(158, '50 1st Ave 3rd FL', 'New York', 'NY', '10009', 46, 0),
(159, '742 Evergreen Terrace', 'Springfield', 'OR', '97403', 25, 0),
(160, '123 Skeleton Way', 'New York', 'NY', '10038', 55, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `average_age_by_department`
-- (See below for the actual view)
--
CREATE TABLE `average_age_by_department` (
`DepartmentID` varchar(3)
,`DepartmentName` varchar(100)
,`AverageAge` decimal(22,1)
);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DepartmentID` varchar(3) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DepartmentID`, `DepartmentName`) VALUES
('001', 'First Division'),
('002', 'Second Division'),
('003', 'Third Division'),
('004', 'Fourth Division'),
('005', 'Fifth Division'),
('006', 'Intelligence Division'),
('007', 'Transportation Division'),
('008', 'Support Services'),
('009', 'Headquarters'),
('010', 'Investigations Division');

-- --------------------------------------------------------

--
-- Stand-in structure for view `departmentsummary`
-- (See below for the actual view)
--
CREATE TABLE `departmentsummary` (
`DepartmentID` varchar(3)
,`DepartmentName` varchar(100)
,`total_employees` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `employeeauditlog`
--

CREATE TABLE `employeeauditlog` (
  `LogID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `ValuesChanged` text NOT NULL,
  `UpdatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employeeauditlog`
--

INSERT INTO `employeeauditlog` (`LogID`, `EmployeeID`, `FirstName`, `LastName`, `ValuesChanged`, `UpdatedAt`) VALUES
(1, 55, 'Jack', 'Skellington', 'SSN: \"987450125\" → \"987-45-0125\", AddressID: \"152\" → \"153\", ', '2025-05-03 18:25:41'),
(2, 54, 'Dana', 'Scully', 'PhoneNumber: \"9171112240\" → \"9171112241\", ', '2025-05-03 18:28:54'),
(3, 52, 'Clarice', 'Starling', 'PhoneNumber: \"9171112245\" → \"9171112246\", ShieldNumber: \"1128\" → \"1129\", ', '2025-05-03 18:29:22'),
(4, 46, 'Danny', 'Reagan', 'Gender: \"Male\" → \"Non-Binary\", ', '2025-05-03 19:36:08'),
(5, 55, 'Jack', 'Skellington', 'PhoneNumber: \"6461234569\" → \"6461234561\", SSN: \"987-45-0125\" → \"987450125\", ', '2025-05-05 01:24:32'),
(6, 43, 'Kate', 'Beckett', 'DepartmentID: \"004\" → \"006\", ', '2025-05-05 07:32:06'),
(7, 24, 'John', 'Smith', 'DepartmentID: \"002\" → \"009\", ', '2025-05-05 07:42:50'),
(8, 50, 'Harvey', 'Bullock', 'EmploymentStatus: \"Active\" → \"Inactive\", ', '2025-05-05 07:44:28'),
(9, 80, 'Test', 'User 7', 'LastName: \"User 7\" → \"User 7a\", ', '2025-05-06 07:13:56'),
(10, 80, 'Test', 'User 7a', 'Employee Deleted', '2025-05-06 07:48:16'),
(11, 81, 'Test', 'User 8', 'Employee Deleted', '2025-05-06 07:52:25'),
(12, 82, 'Test', 'User 9', 'Employee Deleted', '2025-05-06 07:58:30'),
(13, 85, 'Test', 'User 11', 'LastName: \"User 11\" → \"User 11a\", ', '2025-05-07 01:40:38'),
(14, 85, 'Test', 'User 11a', 'Employee Deleted', '2025-05-07 01:41:03'),
(15, 55, 'Jack', 'Skellington', 'SSN: \"987450125\" → \"987-45-0125\", ', '2025-05-07 03:00:31'),
(16, 86, 'Test', 'User 13', 'Employee Deleted', '2025-05-07 03:00:39'),
(17, 83, 'Test', 'User 10', 'Employee Deleted', '2025-05-07 03:00:42');

-- --------------------------------------------------------

--
-- Stand-in structure for view `EmployeeDirectory`
-- (See below for the actual view)
--
CREATE TABLE `EmployeeDirectory` (
`employeeID` int(11)
,`FullName` varchar(91)
,`Age` bigint(21)
,`PhoneNumber` varchar(10)
,`EmploymentType` enum('Civilian','Uniform')
,`ShieldNumber` varchar(5)
,`Gender` enum('Male','Female','Non-Binary','Other','Prefer not to say')
);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeID` int(11) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `BirthDate` date NOT NULL,
  `StartDate` date NOT NULL,
  `PhoneNumber` varchar(10) NOT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `DepartmentID` varchar(3) DEFAULT NULL,
  `EmploymentType` enum('Civilian','Uniform') NOT NULL,
  `EmploymentStatus` enum('Active','Inactive') NOT NULL,
  `ShieldNumber` varchar(5) DEFAULT NULL,
  `SSN` char(11) DEFAULT NULL,
  `Gender` enum('Male','Female','Non-Binary','Other','Prefer not to say') DEFAULT NULL,
  `investigations_InvestigationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeID`, `FirstName`, `LastName`, `BirthDate`, `StartDate`, `PhoneNumber`, `AddressID`, `DepartmentID`, `EmploymentType`, `EmploymentStatus`, `ShieldNumber`, `SSN`, `Gender`, `investigations_InvestigationID`) VALUES
(21, 'Chance', 'Pants', '2012-08-15', '2012-11-18', '9174441234', 9, '010', 'Civilian', 'Active', 'none', '489-24-9296', 'Female', 0),
(24, 'John', 'Smith', '1985-03-13', '2025-03-12', '9871234567', 10, '009', 'Uniform', 'Active', '989', '515-41-8280', 'Male', 0),
(25, 'Homer', 'Simpson', '1956-05-12', '1989-12-17', '4474557246', 159, '003', 'Civilian', 'Active', 'none', '109-56-3465', 'Male', 0),
(29, 'Lazlo', 'Cravensworth', '1712-01-01', '2025-04-06', '3471234567', 13, '001', 'Civilian', 'Active', 'none', '303-22-1749', 'Non-Binary', 0),
(39, 'Jack', 'Bauer', '1970-04-01', '2020-04-01', '1234567890', 14, '010', 'Uniform', 'Active', '24', '369-52-7655', 'Male', 0),
(40, 'Olivia', 'Benson', '1970-01-01', '1999-09-20', '9171112233', 100, '010', 'Uniform', 'Active', '987', '151-46-3967', 'Female', 0),
(41, 'Elliot', 'Stabler', '1966-08-01', '1999-09-20', '9171112234', 101, '002', 'Uniform', 'Active', '124', '132-14-8805', 'Male', 0),
(42, 'Andy', 'Sipowicz', '1959-06-10', '1993-09-21', '9171112235', 102, '003', 'Uniform', 'Active', '103', '525-14-2039', 'Male', 0),
(43, 'Kate', 'Beckett', '1980-11-17', '2009-03-09', '9171112236', 103, '006', 'Uniform', 'Active', '8472', '768-22-9011', 'Female', 0),
(44, 'John', 'Kelly', '1963-05-02', '1993-09-21', '9171112237', 104, '005', 'Uniform', 'Active', '201', '593-86-4342', 'Male', 0),
(45, 'Frank', 'Reagan', '1950-07-20', '2010-09-24', '9171112238', 105, '006', 'Uniform', 'Active', '1', '323-72-1979', 'Male', 0),
(46, 'Danny', 'Reagan', '1975-09-15', '2010-09-24', '9171112239', 158, '007', 'Uniform', 'Active', '7223', '790-89-6190', 'Non-Binary', 0),
(47, 'Jamie', 'Reagan', '1985-03-03', '2010-09-24', '9171112240', 107, '010', 'Uniform', 'Active', '561', '537-65-8602', 'Male', 0),
(48, 'Abbie', 'Carmichael', '1973-12-12', '1999-09-20', '9171112243', 120, '008', 'Uniform', 'Active', '1347', '272-17-2803', 'Female', 0),
(49, 'Joe', 'West', '1970-02-20', '2014-10-07', '9171112242', 109, '009', 'Uniform', 'Active', '238', '395-93-6376', 'Male', 0),
(50, 'Harvey', 'Bullock', '1965-07-17', '2014-09-22', '9171112243', 110, '010', 'Uniform', 'Inactive', '999', '517-80-1249', 'Male', 0),
(51, 'Jim', 'Gordon', '1972-01-15', '2014-09-22', '9171112244', 111, '002', 'Uniform', 'Active', '1971', '822-11-8241', 'Male', 0),
(52, 'Clarice', 'Starling', '1965-06-10', '1991-01-30', '9171112246', 156, '003', 'Uniform', 'Active', '1129', '155-88-2851', 'Female', 0),
(53, 'Fox', 'Mulder', '1961-10-13', '1993-09-10', '9171112247', 128, '004', 'Uniform', 'Active', '4511', '462-31-1028', 'Male', 0),
(54, 'Dana', 'Scully', '1964-02-23', '1993-09-10', '9171112241', 155, '005', 'Uniform', 'Active', '991', '432-40-6356', 'Female', 0),
(55, 'Jack', 'Skellington', '1983-10-29', '2025-02-02', '6461234561', 160, '008', 'Civilian', 'Active', 'none', '987-45-0125', 'Male', 0),
(58, 'Peter', 'Griffin', '1963-09-22', '2024-09-20', '9871239876', 157, '004', 'Civilian', 'Active', 'none', '123-456-000', 'Male', 0);

--
-- Triggers `employees`
--
DELIMITER $$
CREATE TRIGGER `after_employee_insert` AFTER INSERT ON `employees` FOR EACH ROW BEGIN
    INSERT INTO employee_log (employee_name, action)
    VALUES (
        CONCAT(NEW.FirstName, ' ', NEW.LastName),
        'Inserted via trigger'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_employee_update` BEFORE UPDATE ON `employees` FOR EACH ROW BEGIN
    DECLARE changes TEXT DEFAULT '';

    IF NOT OLD.FirstName <=> NEW.FirstName THEN
        SET changes = CONCAT(changes, 'FirstName: "', OLD.FirstName, '" → "', NEW.FirstName, '", ');
    END IF;

    IF NOT OLD.LastName <=> NEW.LastName THEN
        SET changes = CONCAT(changes, 'LastName: "', OLD.LastName, '" → "', NEW.LastName, '", ');
    END IF;

    IF NOT OLD.BirthDate <=> NEW.BirthDate THEN
        SET changes = CONCAT(changes, 'BirthDate: "', OLD.BirthDate, '" → "', NEW.BirthDate, '", ');
    END IF;

    IF NOT OLD.StartDate <=> NEW.StartDate THEN
        SET changes = CONCAT(changes, 'StartDate: "', OLD.StartDate, '" → "', NEW.StartDate, '", ');
    END IF;

    IF NOT OLD.PhoneNumber <=> NEW.PhoneNumber THEN
        SET changes = CONCAT(changes, 'PhoneNumber: "', OLD.PhoneNumber, '" → "', NEW.PhoneNumber, '", ');
    END IF;

    IF NOT OLD.DepartmentID <=> NEW.DepartmentID THEN
        SET changes = CONCAT(changes, 'DepartmentID: "', OLD.DepartmentID, '" → "', NEW.DepartmentID, '", ');
    END IF;

    IF NOT OLD.EmploymentType <=> NEW.EmploymentType THEN
        SET changes = CONCAT(changes, 'EmploymentType: "', OLD.EmploymentType, '" → "', NEW.EmploymentType, '", ');
    END IF;

    IF NOT OLD.EmploymentStatus <=> NEW.EmploymentStatus THEN
        SET changes = CONCAT(changes, 'EmploymentStatus: "', OLD.EmploymentStatus, '" → "', NEW.EmploymentStatus, '", ');
    END IF;

    IF NOT OLD.ShieldNumber <=> NEW.ShieldNumber THEN
        SET changes = CONCAT(changes, 'ShieldNumber: "', OLD.ShieldNumber, '" → "', NEW.ShieldNumber, '", ');
    END IF;

    IF NOT OLD.SSN <=> NEW.SSN THEN
        SET changes = CONCAT(changes, 'SSN: "', OLD.SSN, '" → "', NEW.SSN, '", ');
    END IF;

    IF NOT OLD.Gender <=> NEW.Gender THEN
        SET changes = CONCAT(changes, 'Gender: "', OLD.Gender, '" → "', NEW.Gender, '", ');
    END IF;

    -- IF NOT OLD.AddressID <=> NEW.AddressID THEN
    --    SET changes = CONCAT(changes, 'AddressID: "', OLD.AddressID, '" → "', NEW.AddressID, '", ');
    -- END IF;

    IF NOT OLD.investigations_InvestigationID <=> NEW.investigations_InvestigationID THEN
        SET changes = CONCAT(changes, 'InvestigationID: "', OLD.investigations_InvestigationID, '" → "', NEW.investigations_InvestigationID, '", ');
    END IF;

    IF changes != '' THEN
        SET changes = LEFT(changes, LENGTH(changes) - 2); -- remove trailing comma and space
        INSERT INTO employeeauditlog (EmployeeID, FirstName, LastName, ValuesChanged)
        VALUES (OLD.employeeID, OLD.FirstName, OLD.LastName, changes);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_log`
--

CREATE TABLE `employee_log` (
  `log_id` int(11) NOT NULL,
  `employee_name` varchar(100) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `action_time` timestamp NULL DEFAULT current_timestamp(),
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_log`
--

INSERT INTO `employee_log` (`log_id`, `employee_name`, `action`, `action_time`, `EmployeeID`) VALUES
(1, 'Trigger Test', 'Inserted via trigger', '2025-04-29 19:30:48', NULL),
(2, 'Jack Bauer', 'Inserted via trigger', '2025-04-29 19:33:53', NULL),
(3, 'John Pance', 'Inserted via trigger', '2025-04-29 20:07:44', NULL),
(4, 'Jack Bauer', 'Inserted via trigger', '2025-04-29 20:36:02', NULL),
(5, 'Olivia Benson', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(6, 'Elliot Stabler', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(7, 'Andy Sipowicz', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(8, 'Kate Beckett', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(9, 'John Kelly', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(10, 'Frank Reagan', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(11, 'Danny Reagan', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(12, 'Jamie Reagan', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(13, 'Abbie Carmichael', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(14, 'Joe West', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(15, 'Harvey Bullock', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(16, 'Jim Gordon', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(17, 'Clarice Starling', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(18, 'Fox Mulder', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(19, 'Dana Scully', 'Inserted via trigger', '2025-04-30 01:22:26', NULL),
(20, 'Jack Skellington', 'Inserted via trigger', '2025-05-02 22:05:02', NULL),
(21, 'Jac Skellington', 'Inserted via trigger', '2025-05-03 00:08:32', NULL),
(22, 'Tiny Tim', 'Inserted via trigger', '2025-05-03 02:10:51', NULL),
(23, 'Peter Griffin', 'Inserted via trigger', '2025-05-03 19:35:29', NULL),
(24, 'Homer Simpson', 'Inserted via trigger', '2025-05-04 18:39:46', NULL),
(25, 'Tiny dA', 'Inserted via trigger', '2025-05-06 04:47:19', NULL),
(26, 'Dana Smith', 'Inserted via trigger', '2025-05-06 04:58:30', NULL),
(27, 'Michael Jackson', 'Inserted via trigger', '2025-05-06 05:08:01', NULL),
(28, 'Abraham Lincoln', 'Inserted via trigger', '2025-05-06 05:45:28', NULL),
(29, 'George Washington', 'Inserted via trigger', '2025-05-06 05:51:23', NULL),
(30, 'Test Test', 'Inserted via trigger', '2025-05-06 05:56:35', NULL),
(31, 'Mark Twain', 'Inserted via trigger', '2025-05-06 06:03:47', NULL),
(32, 'Bill Clinton', 'Inserted via trigger', '2025-05-06 06:16:31', NULL),
(33, 'Test User 1', 'Inserted via trigger', '2025-05-06 06:27:42', NULL),
(34, 'Test User 2', 'Inserted via trigger', '2025-05-06 06:29:33', NULL),
(35, 'Test User 3', 'Inserted via trigger', '2025-05-06 06:30:25', NULL),
(36, 'Test User 4', 'Inserted via trigger', '2025-05-06 06:31:17', NULL),
(37, 'Test User 5', 'Inserted via trigger', '2025-05-06 06:43:05', NULL),
(38, 'Test User 6', 'Inserted via trigger', '2025-05-06 06:44:09', NULL),
(39, 'Test User 7', 'Inserted via trigger', '2025-05-06 06:49:19', NULL),
(40, 'Test User 7', 'Inserted via trigger', '2025-05-06 06:56:51', NULL),
(41, 'Test User 8', 'Inserted via trigger', '2025-05-06 07:51:59', NULL),
(42, 'Test User 9', 'Inserted via trigger', '2025-05-06 07:58:26', NULL),
(43, 'Test User 10', 'Inserted via trigger', '2025-05-06 08:04:00', NULL),
(44, 'Test User 11', 'Inserted via trigger', '2025-05-07 01:40:17', NULL),
(45, 'Test User 13', 'Inserted via trigger', '2025-05-07 02:59:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE `evidence` (
  `evidenceID` int(11) NOT NULL,
  `InvestigationID` int(11) NOT NULL,
  `EvidenceType` enum('Digital','Physical','Documents','Other') NOT NULL,
  `Description` text NOT NULL,
  `DateCollected` date NOT NULL,
  `DateInvoiced` date NOT NULL,
  `investigations_InvestigationID` int(11) NOT NULL,
  `CollectedBy` int(11) NOT NULL,
  `employees_employeeID` int(11) NOT NULL,
  `employees_investigations_InvestigationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evidence`
--

INSERT INTO `evidence` (`evidenceID`, `InvestigationID`, `EvidenceType`, `Description`, `DateCollected`, `DateInvoiced`, `investigations_InvestigationID`, `CollectedBy`, `employees_employeeID`, `employees_investigations_InvestigationID`) VALUES
(14, 38, 'Documents', 'Witness statement from neighbor', '2025-04-28', '2025-04-29', 38, 39, 0, 0),
(15, 39, 'Digital', 'Audio recording from 911 call regarding false claim', '2025-04-27', '2025-04-28', 39, 21, 0, 0),
(16, 40, 'Documents', 'Signed confession from subject', '2025-04-30', '2025-05-01', 40, 39, 0, 0),
(17, 41, 'Physical', 'Recovered counterfeit bills', '2025-04-29', '2025-04-30', 41, 40, 0, 0),
(18, 42, 'Digital', 'Security camera footage disproving subject timeline', '2025-05-01', '2025-05-02', 42, 21, 0, 0),
(19, 43, 'Documents', 'Medical report showing injuries to victim', '2025-05-02', '2025-05-03', 43, 39, 0, 0),
(20, 44, 'Physical', 'Plastic bag with unknown substance', '2025-05-03', '2025-05-04', 44, 40, 0, 0),
(21, 45, 'Physical', 'Notebook', '2025-05-04', '2025-05-05', 45, 46, 0, 0),
(22, 46, 'Digital', 'Email evidence of bribery attempt', '2025-05-05', '2025-05-06', 46, 47, 0, 0),
(23, 47, 'Documents', 'Signed bank statement showing transfer', '2025-05-06', '2025-05-07', 47, 21, 0, 0),
(24, 48, 'Documents', 'Statement from suspect regarding incident', '2025-05-07', '2025-05-08', 48, 39, 0, 0),
(25, 49, 'Physical', 'Confiscated baton allegedly used in use-of-force event', '2025-05-08', '2025-05-09', 49, 40, 0, 0),
(26, 58, 'Digital', 'Bodycam footage ', '2025-05-05', '2025-05-06', 58, 47, 0, 0);

--
-- Triggers `evidence`
--
DELIMITER $$
CREATE TRIGGER `trg_evidence_delete_audit` AFTER DELETE ON `evidence` FOR EACH ROW BEGIN
    INSERT INTO evidenceauditlog (
        EvidenceID,
        InvestigationID,
        CollectedBy,
        ValuesChanged
    )
    VALUES (
        OLD.evidenceID,
        OLD.InvestigationID,
        OLD.CollectedBy,
        'Record Deleted'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_evidence_update_audit` AFTER UPDATE ON `evidence` FOR EACH ROW BEGIN
    IF NOT (
        OLD.InvestigationID <=> NEW.InvestigationID AND
        OLD.EvidenceType <=> NEW.EvidenceType AND
        OLD.Description <=> NEW.Description AND
        OLD.DateCollected <=> NEW.DateCollected AND
        OLD.DateInvoiced <=> NEW.DateInvoiced AND
        OLD.CollectedBy <=> NEW.CollectedBy
    ) THEN
        INSERT INTO evidenceauditlog (
            EvidenceID,
            InvestigationID,
            CollectedBy,
            ValuesChanged
        )
        VALUES (
            NEW.evidenceID,
            NEW.InvestigationID,
            NEW.CollectedBy,
            CONCAT_WS(', ',
                IF(OLD.InvestigationID <=> NEW.InvestigationID, NULL, CONCAT('InvestigationID: ', OLD.InvestigationID, ' → ', NEW.InvestigationID)),
                IF(OLD.EvidenceType <=> NEW.EvidenceType, NULL, CONCAT('EvidenceType: ', OLD.EvidenceType, ' → ', NEW.EvidenceType)),
                IF(OLD.Description <=> NEW.Description, NULL, CONCAT('Description: ', OLD.Description, ' → ', NEW.Description)),
                IF(OLD.DateCollected <=> NEW.DateCollected, NULL, CONCAT('DateCollected: ', OLD.DateCollected, ' → ', NEW.DateCollected)),
                IF(OLD.DateInvoiced <=> NEW.DateInvoiced, NULL, CONCAT('DateInvoiced: ', OLD.DateInvoiced, ' → ', NEW.DateInvoiced)),
                IF(OLD.CollectedBy <=> NEW.CollectedBy, NULL, CONCAT('CollectedBy: ', OLD.CollectedBy, ' → ', NEW.CollectedBy))
            )
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `evidenceauditlog`
--

CREATE TABLE `evidenceauditlog` (
  `LogID` int(11) NOT NULL,
  `EvidenceID` int(11) NOT NULL,
  `InvestigationID` int(11) DEFAULT NULL,
  `CollectedBy` int(11) DEFAULT NULL,
  `ValuesChanged` text DEFAULT NULL,
  `UpdatedAt` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evidenceauditlog`
--

INSERT INTO `evidenceauditlog` (`LogID`, `EvidenceID`, `InvestigationID`, `CollectedBy`, `ValuesChanged`, `UpdatedAt`) VALUES
(1, 26, 58, 47, 'Description: Bodycam footage review → Bodycam footage ', '2025-05-06 18:28:48'),
(2, 26, 58, 47, 'Description: Bodycam footage review → Bodycam footage \n', '2025-05-06 18:28:48'),
(3, 25, 49, 40, 'Description: Confiscated baton allegedly used in use-of-force event → Confiscated baton', '2025-05-06 18:35:06'),
(4, 25, 49, 40, 'Description: Confiscated baton allegedly used in use-of-force event → Confiscated baton', '2025-05-06 18:35:13'),
(5, 25, 49, 40, 'Description: Confiscated baton allegedly used in use-of-force event → Confiscated baton', '2025-05-06 18:37:06'),
(6, 25, 49, 40, 'Description: Confiscated baton allegedly used in use-of-force event → Confiscated baton', '2025-05-06 18:37:41'),
(7, 32, 58, 50, 'Description: Bank statements → Bank statement', '2025-05-06 18:54:53'),
(8, 32, 58, 50, 'Description: Bank statement → Bank statements', '2025-05-06 18:56:07'),
(9, 32, 58, 50, 'DELETED: Type=Physical, Description=Bank statements, DateCollected=2025-05-01, DateInvoiced=2025-05-05', '2025-05-06 18:57:49'),
(10, 32, 58, 50, 'Record Deleted', '2025-05-06 18:57:49');

-- --------------------------------------------------------

--
-- Stand-in structure for view `evidenceview`
-- (See below for the actual view)
--
CREATE TABLE `evidenceview` (
`evidenceID` int(11)
,`InvestigationID` int(11)
,`CaseNumber` varchar(20)
,`EvidenceType` enum('Digital','Physical','Documents','Other')
,`Description` text
,`DateCollected` date
,`DateInvoiced` date
,`CollectedByID` int(11)
,`CollectedByName` varchar(91)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `evidence_per_investigation`
-- (See below for the actual view)
--
CREATE TABLE `evidence_per_investigation` (
`InvestigationID` int(11)
,`CaseNumber` varchar(20)
,`EvidenceCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `firearms`
--

CREATE TABLE `firearms` (
  `firearmID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Make` varchar(45) NOT NULL,
  `Model` varchar(45) NOT NULL,
  `SerialNumber` varchar(45) NOT NULL,
  `DateAdded` date NOT NULL,
  `QualificationDate` date NOT NULL,
  `DateSurrendered` date DEFAULT NULL,
  `Status` enum('Active','Surrendered','Confiscated','Lost','Stolen','Destroyed') NOT NULL,
  `employees_employeeID` int(11) NOT NULL,
  `employees_investigations_InvestigationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `firearms`
--

INSERT INTO `firearms` (`firearmID`, `EmployeeID`, `Make`, `Model`, `SerialNumber`, `DateAdded`, `QualificationDate`, `DateSurrendered`, `Status`, `employees_employeeID`, `employees_investigations_InvestigationID`) VALUES
(1, 24, 'Sig Sauer', 'P320', 'SN-P32024', '2024-01-10', '2024-01-25', NULL, 'Active', 0, 0),
(2, 39, 'Beretta', 'PX4 Storm', 'SN-PX439', '2024-01-15', '2024-01-30', NULL, 'Active', 0, 0),
(3, 40, 'Smith & Wesson', 'SD9 VE', 'SN-SD940', '2024-01-20', '2024-02-04', NULL, 'Active', 0, 0),
(4, 41, 'Glock', '26 Gen5', 'SN-G2641', '2024-01-25', '2024-02-10', NULL, 'Active', 0, 0),
(5, 42, 'Sig Sauer', 'P938', 'SN-P93842', '2024-01-30', '2024-02-15', NULL, 'Active', 0, 0),
(6, 43, 'Beretta', 'M9', 'SN-M943', '2024-02-01', '2024-02-16', NULL, 'Active', 0, 0),
(7, 44, 'Smith & Wesson', 'Shield EZ', 'SN-EZ44', '2024-02-05', '2024-02-20', NULL, 'Active', 0, 0),
(8, 45, 'Glock', '43X', 'SN-G4345', '2024-02-10', '2024-02-25', NULL, 'Active', 0, 0),
(9, 46, 'Sig Sauer', 'P365', 'SN-P36546', '2024-02-15', '2024-03-01', NULL, 'Active', 0, 0),
(10, 47, 'Beretta', '92X RDO', 'SN-92X47', '2024-02-20', '2024-03-05', NULL, 'Active', 0, 0),
(11, 48, 'Smith & Wesson', 'Bodyguard 380', 'SN-BG48', '2024-02-25', '2024-03-12', NULL, 'Active', 0, 0),
(12, 49, 'Glock', '17 Gen5', 'SN-G1749', '2024-03-01', '2024-03-15', NULL, 'Active', 0, 0),
(13, 50, 'Glock', '43', 'SN-G4450', '2024-03-05', '2024-03-20', NULL, 'Active', 0, 0),
(14, 51, 'Sig Sauer', 'P220', 'SN-P22051', '2024-03-10', '2024-03-25', NULL, 'Active', 0, 0),
(15, 52, 'Beretta', 'M9A1', 'SN-M9A152', '2024-03-15', '2024-03-30', NULL, 'Active', 0, 0),
(16, 53, 'Smith & Wesson', 'M&P40', 'SN-MP4053', '2024-03-20', '2024-04-04', NULL, 'Active', 0, 0),
(17, 54, 'Glock', '19 Gen5', 'SN-G1954', '2024-03-25', '2024-04-10', NULL, 'Active', 0, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `firearmView`
-- (See below for the actual view)
--
CREATE TABLE `firearmView` (
`EmployeeName` varchar(91)
,`Make` varchar(45)
,`Model` varchar(45)
,`SerialNumber` varchar(45)
,`DateAdded` date
,`QualificationDate` date
,`Status` enum('Active','Surrendered','Confiscated','Lost','Stolen','Destroyed')
);

-- --------------------------------------------------------

--
-- Table structure for table `investigationauditlog`
--

CREATE TABLE `investigationauditlog` (
  `LogID` int(11) NOT NULL,
  `InvestigationID` int(11) NOT NULL,
  `CaseNumber` varchar(255) DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT 'system',
  `ValuesChanged` text NOT NULL,
  `UpdatedAt` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigationauditlog`
--

INSERT INTO `investigationauditlog` (`LogID`, `InvestigationID`, `CaseNumber`, `UpdatedBy`, `ValuesChanged`, `UpdatedAt`) VALUES
(1, 48, '2025-00048', NULL, 'PrimaryAllegation: Other -> Overtime Abuse\n', '2025-05-05 08:43:34'),
(2, 47, '2025-00047', NULL, 'StartDate: 2025-05-06 -> 2025-05-02\n', '2025-05-05 08:48:00'),
(3, 47, '2025-00047', NULL, 'PrimaryAllegation: Bribery -> False Filings\n', '2025-05-07 02:00:47'),
(4, 47, '2025-00047', NULL, 'PrimaryAllegation: False Filings -> Theft of Services\n', '2025-05-07 02:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `investigations`
--

CREATE TABLE `investigations` (
  `InvestigationID` int(11) NOT NULL,
  `CaseNumber` varchar(20) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date DEFAULT NULL,
  `CaseStatus` enum('Open','Closed') NOT NULL,
  `employees_employeeID` int(11) NOT NULL,
  `employees_investigations_InvestigationID` int(11) NOT NULL,
  `PrimaryAllegation` enum('Fraud','Use of Force','Contraband','False Filings','Theft of Services','Overtime Abuse','Bribery','Other') NOT NULL DEFAULT 'Other',
  `Disposition` enum('Substantiated','Unsubstantiated','Dismissed') DEFAULT NULL,
  `DispositionDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigations`
--

INSERT INTO `investigations` (`InvestigationID`, `CaseNumber`, `StartDate`, `EndDate`, `CaseStatus`, `employees_employeeID`, `employees_investigations_InvestigationID`, `PrimaryAllegation`, `Disposition`, `DispositionDate`) VALUES
(38, '2025-00038', '2025-04-28', '0000-00-00', 'Open', 39, 0, 'Other', NULL, NULL),
(39, '2025-00039', '2025-04-27', '0000-00-00', 'Open', 21, 0, 'False Filings', NULL, NULL),
(40, '2025-00040', '2025-04-10', '2025-05-02', 'Closed', 39, 0, 'Other', 'Substantiated', '2025-05-03'),
(41, '2025-00041', '2025-04-29', NULL, 'Open', 40, 0, 'Fraud', NULL, NULL),
(42, '2025-00042', '2025-05-01', '0000-00-00', 'Open', 21, 0, 'False Filings', NULL, NULL),
(43, '2025-00043', '2025-05-02', '2025-05-02', 'Closed', 39, 0, 'Other', 'Unsubstantiated', '2025-05-02'),
(44, '2025-00044', '2025-05-03', '0000-00-00', 'Closed', 40, 0, 'Contraband', 'Unsubstantiated', '2025-05-05'),
(45, '2025-00045', '2025-05-02', '0000-00-00', 'Open', 39, 0, 'Other', NULL, NULL),
(46, '2025-00046', '2025-05-05', '2025-05-05', 'Closed', 47, 0, 'Bribery', 'Substantiated', '2025-05-05'),
(47, '2025-00047', '2025-05-02', '0000-00-00', 'Open', 21, 0, 'Theft of Services', NULL, NULL),
(48, '2025-00048', '2025-05-07', '0000-00-00', 'Open', 39, 0, 'Overtime Abuse', NULL, NULL),
(49, '2025-00049', '2025-05-08', '0000-00-00', 'Open', 40, 0, 'Use of Force', NULL, NULL),
(58, '2025-00058', '2025-05-05', NULL, 'Open', 47, 0, 'Other', NULL, NULL);

--
-- Triggers `investigations`
--
DELIMITER $$
CREATE TRIGGER `trg_investigations_update` AFTER UPDATE ON `investigations` FOR EACH ROW BEGIN
    DECLARE changes TEXT DEFAULT '';
    DECLARE oldInvName VARCHAR(100);
    DECLARE newInvName VARCHAR(100);

    -- Fetch old investigator name
    SELECT CONCAT(FirstName, ' ', LastName)
    INTO oldInvName
    FROM employees
    WHERE employeeID = OLD.employees_employeeID;

    -- Fetch new investigator name
    SELECT CONCAT(FirstName, ' ', LastName)
    INTO newInvName
    FROM employees
    WHERE employeeID = NEW.employees_employeeID;

    -- Compare other fields
    IF OLD.StartDate <> NEW.StartDate THEN
        SET changes = CONCAT(changes, 'StartDate: ', OLD.StartDate, ' -> ', NEW.StartDate, '\n');
    END IF;
    IF OLD.EndDate <> NEW.EndDate THEN
        SET changes = CONCAT(changes, 'EndDate: ', OLD.EndDate, ' -> ', NEW.EndDate, '\n');
    END IF;
    IF OLD.CaseStatus <> NEW.CaseStatus THEN
        SET changes = CONCAT(changes, 'CaseStatus: ', OLD.CaseStatus, ' -> ', NEW.CaseStatus, '\n');
    END IF;
    IF OLD.PrimaryAllegation <> NEW.PrimaryAllegation THEN
        SET changes = CONCAT(changes, 'PrimaryAllegation: ', OLD.PrimaryAllegation, ' -> ', NEW.PrimaryAllegation, '\n');
    END IF;

    -- Compare and log investigator change using names
    IF OLD.employees_employeeID <> NEW.employees_employeeID THEN
        SET changes = CONCAT(changes, 'Investigator: "', oldInvName, '" → "', newInvName, '"\n');
    END IF;

    IF LENGTH(changes) > 0 THEN
        INSERT INTO investigationauditlog (InvestigationID, CaseNumber, UpdatedBy, ValuesChanged, UpdatedAt)
        VALUES (OLD.InvestigationID, OLD.CaseNumber, NULL, changes, NOW());
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `InvestigationSummary`
-- (See below for the actual view)
--
CREATE TABLE `InvestigationSummary` (
`DepartmentID` varchar(3)
,`InvestigationCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `InvestigatorActivity`
-- (See below for the actual view)
--
CREATE TABLE `InvestigatorActivity` (
`employeeID` int(11)
,`InvestigatorName` varchar(91)
,`TotalInvestigations` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `subjectauditlog`
--

CREATE TABLE `subjectauditlog` (
  `LogID` int(11) NOT NULL,
  `InvestigationID` int(11) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Notes` text DEFAULT NULL,
  `ActionTaken` varchar(20) DEFAULT 'DELETE',
  `ActionTime` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjectauditlog`
--

INSERT INTO `subjectauditlog` (`LogID`, `InvestigationID`, `EmployeeID`, `Role`, `Notes`, `ActionTaken`, `ActionTime`) VALUES
(1, 49, 49, '', '', 'Deleted', '2025-05-06 09:11:29');

-- --------------------------------------------------------

--
-- Stand-in structure for view `subjectauditlogview`
-- (See below for the actual view)
--
CREATE TABLE `subjectauditlogview` (
`LogID` int(11)
,`CaseNumber` varchar(20)
,`EmployeeName` varchar(91)
,`Role` varchar(50)
,`Notes` text
,`ActionTaken` varchar(20)
,`ActionTime` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `SubjectEmployeeSummary`
-- (See below for the actual view)
--
CREATE TABLE `SubjectEmployeeSummary` (
`employeeID` int(11)
,`EmployeeName` varchar(91)
,`TimesListedAsSubject` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `SubjectRoleSummary`
-- (See below for the actual view)
--
CREATE TABLE `SubjectRoleSummary` (
`Role` enum('Subject','Witness','Victim','Complainant','Other')
,`RoleCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int(11) NOT NULL,
  `InvestigationID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Role` enum('Subject','Witness','Victim','Complainant','Other') NOT NULL,
  `Notes` text DEFAULT NULL,
  `LastUpdated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `InvestigationID`, `EmployeeID`, `Role`, `Notes`, `LastUpdated`) VALUES
(9, 38, 29, '', 'Vampirism', NULL),
(10, 40, 29, '', 'Test', NULL),
(11, 41, 42, '', 'Fraud', NULL),
(36, 42, 24, '', 'Witness claimed suspicious behavior.', NULL),
(38, 45, 29, '', 'Subject matched description.', NULL),
(39, 46, 41, 'Victim', 'Forced to pay $3,000', NULL),
(40, 47, 52, '', '', NULL),
(41, 46, 52, '', '', NULL),
(47, 48, 55, '', '', NULL),
(48, 43, 52, '', '', NULL);

-- --------------------------------------------------------

--
-- Structure for view `average_age_by_department`
--
DROP TABLE IF EXISTS `average_age_by_department`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `average_age_by_department`  AS SELECT `d`.`DepartmentID` AS `DepartmentID`, `d`.`DepartmentName` AS `DepartmentName`, round(avg(timestampdiff(YEAR,`e`.`BirthDate`,curdate())),1) AS `AverageAge` FROM (`employees` `e` join `departments` `d` on(`e`.`DepartmentID` = `d`.`DepartmentID`)) GROUP BY `d`.`DepartmentID`, `d`.`DepartmentName` ORDER BY `d`.`DepartmentName` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `departmentsummary`
--
DROP TABLE IF EXISTS `departmentsummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `departmentsummary`  AS SELECT `d`.`DepartmentID` AS `DepartmentID`, `d`.`DepartmentName` AS `DepartmentName`, count(`e`.`employeeID`) AS `total_employees` FROM (`departments` `d` left join `employees` `e` on(`d`.`DepartmentID` = lpad(`e`.`DepartmentID`,3,'0'))) GROUP BY `d`.`DepartmentID`, `d`.`DepartmentName` ;

-- --------------------------------------------------------

--
-- Structure for view `EmployeeDirectory`
--
DROP TABLE IF EXISTS `EmployeeDirectory`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `EmployeeDirectory`  AS SELECT `employees`.`employeeID` AS `employeeID`, concat(`employees`.`FirstName`,' ',`employees`.`LastName`) AS `FullName`, timestampdiff(YEAR,`employees`.`BirthDate`,curdate()) AS `Age`, `employees`.`PhoneNumber` AS `PhoneNumber`, `employees`.`EmploymentType` AS `EmploymentType`, `employees`.`ShieldNumber` AS `ShieldNumber`, `employees`.`Gender` AS `Gender` FROM `employees` ;

-- --------------------------------------------------------

--
-- Structure for view `evidenceview`
--
DROP TABLE IF EXISTS `evidenceview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `evidenceview`  AS SELECT `e`.`evidenceID` AS `evidenceID`, `e`.`InvestigationID` AS `InvestigationID`, `i`.`CaseNumber` AS `CaseNumber`, `e`.`EvidenceType` AS `EvidenceType`, `e`.`Description` AS `Description`, `e`.`DateCollected` AS `DateCollected`, `e`.`DateInvoiced` AS `DateInvoiced`, `emp`.`employeeID` AS `CollectedByID`, concat(`emp`.`FirstName`,' ',`emp`.`LastName`) AS `CollectedByName` FROM ((`evidence` `e` join `investigations` `i` on(`e`.`InvestigationID` = `i`.`InvestigationID`)) left join `employees` `emp` on(`e`.`CollectedBy` = `emp`.`employeeID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `evidence_per_investigation`
--
DROP TABLE IF EXISTS `evidence_per_investigation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `evidence_per_investigation`  AS SELECT `i`.`InvestigationID` AS `InvestigationID`, `i`.`CaseNumber` AS `CaseNumber`, count(`e`.`evidenceID`) AS `EvidenceCount` FROM (`investigations` `i` left join `evidence` `e` on(`i`.`InvestigationID` = `e`.`InvestigationID`)) GROUP BY `i`.`InvestigationID`, `i`.`CaseNumber` ORDER BY `i`.`CaseNumber` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `firearmView`
--
DROP TABLE IF EXISTS `firearmView`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `firearmView`  AS SELECT concat(`e`.`FirstName`,' ',`e`.`LastName`) AS `EmployeeName`, `f`.`Make` AS `Make`, `f`.`Model` AS `Model`, `f`.`SerialNumber` AS `SerialNumber`, `f`.`DateAdded` AS `DateAdded`, `f`.`QualificationDate` AS `QualificationDate`, `f`.`Status` AS `Status` FROM (`firearms` `f` join `employees` `e` on(`f`.`EmployeeID` = `e`.`employeeID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `InvestigationSummary`
--
DROP TABLE IF EXISTS `InvestigationSummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `InvestigationSummary`  AS SELECT `e`.`DepartmentID` AS `DepartmentID`, count(distinct `i`.`InvestigationID`) AS `InvestigationCount` FROM (`employees` `e` join `investigations` `i` on(`i`.`employees_employeeID` = `e`.`employeeID`)) GROUP BY `e`.`DepartmentID` ;

-- --------------------------------------------------------

--
-- Structure for view `InvestigatorActivity`
--
DROP TABLE IF EXISTS `InvestigatorActivity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `InvestigatorActivity`  AS SELECT `e`.`employeeID` AS `employeeID`, concat(`e`.`FirstName`,' ',`e`.`LastName`) AS `InvestigatorName`, count(`i`.`InvestigationID`) AS `TotalInvestigations` FROM (`employees` `e` join `investigations` `i` on(`i`.`employees_employeeID` = `e`.`employeeID`)) WHERE `e`.`DepartmentID` = '010' GROUP BY `e`.`employeeID`, `e`.`FirstName`, `e`.`LastName` ;

-- --------------------------------------------------------

--
-- Structure for view `subjectauditlogview`
--
DROP TABLE IF EXISTS `subjectauditlogview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `subjectauditlogview`  AS SELECT `l`.`LogID` AS `LogID`, `i`.`CaseNumber` AS `CaseNumber`, concat(`e`.`FirstName`,' ',`e`.`LastName`) AS `EmployeeName`, `l`.`Role` AS `Role`, `l`.`Notes` AS `Notes`, `l`.`ActionTaken` AS `ActionTaken`, `l`.`ActionTime` AS `ActionTime` FROM ((`subjectauditlog` `l` left join `investigations` `i` on(`l`.`InvestigationID` = `i`.`InvestigationID`)) left join `employees` `e` on(`l`.`EmployeeID` = `e`.`employeeID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `SubjectEmployeeSummary`
--
DROP TABLE IF EXISTS `SubjectEmployeeSummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `SubjectEmployeeSummary`  AS SELECT `e`.`employeeID` AS `employeeID`, concat(`e`.`FirstName`,' ',`e`.`LastName`) AS `EmployeeName`, count(`s`.`InvestigationID`) AS `TimesListedAsSubject` FROM (`subjects` `s` join `employees` `e` on(`s`.`EmployeeID` = `e`.`employeeID`)) GROUP BY `e`.`employeeID`, `e`.`FirstName`, `e`.`LastName` ;

-- --------------------------------------------------------

--
-- Structure for view `SubjectRoleSummary`
--
DROP TABLE IF EXISTS `SubjectRoleSummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u642322888_ltc4061`@`127.0.0.1` SQL SECURITY DEFINER VIEW `SubjectRoleSummary`  AS SELECT `subjects`.`Role` AS `Role`, count(0) AS `RoleCount` FROM `subjects` GROUP BY `subjects`.`Role` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`AddressID`,`employees_employeeID`,`employees_investigations_InvestigationID`),
  ADD UNIQUE KEY `unique_employee_address` (`employees_employeeID`),
  ADD KEY `fk_addresses_employees1_idx` (`employees_employeeID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `employeeauditlog`
--
ALTER TABLE `employeeauditlog`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `fk_auditlog_employee` (`EmployeeID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeID`,`investigations_InvestigationID`),
  ADD KEY `fk_employees_department` (`DepartmentID`),
  ADD KEY `fk_employees_address` (`AddressID`);

--
-- Indexes for table `employee_log`
--
ALTER TABLE `employee_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_log_employee` (`EmployeeID`);

--
-- Indexes for table `evidence`
--
ALTER TABLE `evidence`
  ADD PRIMARY KEY (`evidenceID`,`InvestigationID`,`investigations_InvestigationID`,`employees_employeeID`,`employees_investigations_InvestigationID`,`CollectedBy`),
  ADD KEY `fk_evidence_investigations1_idx` (`investigations_InvestigationID`),
  ADD KEY `fk_evidence_employees1_idx` (`CollectedBy`);

--
-- Indexes for table `evidenceauditlog`
--
ALTER TABLE `evidenceauditlog`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `firearms`
--
ALTER TABLE `firearms`
  ADD PRIMARY KEY (`firearmID`,`employees_employeeID`,`employees_investigations_InvestigationID`,`EmployeeID`),
  ADD KEY `fk_firearms_employees1_idx` (`EmployeeID`);

--
-- Indexes for table `investigationauditlog`
--
ALTER TABLE `investigationauditlog`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `InvestigationID` (`InvestigationID`);

--
-- Indexes for table `investigations`
--
ALTER TABLE `investigations`
  ADD PRIMARY KEY (`InvestigationID`,`employees_employeeID`,`employees_investigations_InvestigationID`),
  ADD UNIQUE KEY `CaseNumber_UNIQUE` (`CaseNumber`),
  ADD UNIQUE KEY `CaseNumber` (`CaseNumber`),
  ADD KEY `fk_investigations_employees1_idx` (`employees_employeeID`);

--
-- Indexes for table `subjectauditlog`
--
ALTER TABLE `subjectauditlog`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `InvestigationID` (`InvestigationID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`),
  ADD KEY `InvestigationID` (`InvestigationID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `employeeauditlog`
--
ALTER TABLE `employeeauditlog`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `employee_log`
--
ALTER TABLE `employee_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `evidenceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `evidenceauditlog`
--
ALTER TABLE `evidenceauditlog`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `firearms`
--
ALTER TABLE `firearms`
  MODIFY `firearmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `investigationauditlog`
--
ALTER TABLE `investigationauditlog`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `investigations`
--
ALTER TABLE `investigations`
  MODIFY `InvestigationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `subjectauditlog`
--
ALTER TABLE `subjectauditlog`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_address_employee` FOREIGN KEY (`employees_employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`),
  ADD CONSTRAINT `fk_employees_department` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`);

--
-- Constraints for table `employee_log`
--
ALTER TABLE `employee_log`
  ADD CONSTRAINT `fk_log_employee` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`employeeID`);

--
-- Constraints for table `evidence`
--
ALTER TABLE `evidence`
  ADD CONSTRAINT `fk_evidence_employees1` FOREIGN KEY (`CollectedBy`) REFERENCES `employees` (`employeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evidence_investigations1` FOREIGN KEY (`investigations_InvestigationID`) REFERENCES `investigations` (`InvestigationID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `firearms`
--
ALTER TABLE `firearms`
  ADD CONSTRAINT `fk_firearms_employees1` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`employeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `investigationauditlog`
--
ALTER TABLE `investigationauditlog`
  ADD CONSTRAINT `investigationauditlog_ibfk_1` FOREIGN KEY (`InvestigationID`) REFERENCES `investigations` (`InvestigationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `investigations`
--
ALTER TABLE `investigations`
  ADD CONSTRAINT `fk_investigations_employees1` FOREIGN KEY (`employees_employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subjectauditlog`
--
ALTER TABLE `subjectauditlog`
  ADD CONSTRAINT `subjectauditlog_ibfk_1` FOREIGN KEY (`InvestigationID`) REFERENCES `investigations` (`InvestigationID`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjectauditlog_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`employeeID`) ON DELETE SET NULL;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`InvestigationID`) REFERENCES `investigations` (`InvestigationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
