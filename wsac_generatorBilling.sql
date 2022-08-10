-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2022 at 12:04 PM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wsacres`
--

-- --------------------------------------------------------

--
-- Table structure for table `wsac_generatorBilling`
--

CREATE TABLE `wsac_generatorBilling` (
  `id` int(11) NOT NULL,
  `account` varchar(10) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `physicaladdress` varchar(250) NOT NULL,
  `physicalcity` varchar(250) NOT NULL,
  `physicalstate` varchar(250) NOT NULL,
  `physicalzipcode` varchar(250) NOT NULL,
  `duedate` date NOT NULL,
  `lastbill` bigint(50) NOT NULL,
  `paymentreceived` bigint(50) NOT NULL,
  `balance` bigint(50) NOT NULL,
  `currentcharge` bigint(50) NOT NULL,
  `totalcharge` bigint(50) NOT NULL,
  `readdate` date NOT NULL,
  `processfee` bigint(50) NOT NULL,
  `waterusage` bigint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wsac_generatorBilling`
--

INSERT INTO `wsac_generatorBilling` (`id`, `account`, `firstname`, `lastname`, `physicaladdress`, `physicalcity`, `physicalstate`, `physicalzipcode`, `duedate`, `lastbill`, `paymentreceived`, `balance`, `currentcharge`, `totalcharge`, `readdate`, `processfee`, `waterusage`) VALUES
(1, '54DL', 'Richard', 'Niles', '45 Bellmawr Drive', 'Rochester', 'NH', '03867', '2022-08-10', 123, 321, 421, 521, 621, '2022-08-02', 1, 750);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wsac_generatorBilling`
--
ALTER TABLE `wsac_generatorBilling`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
