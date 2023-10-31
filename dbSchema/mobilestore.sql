CREATE DATABASE if not exists mobilestore;
use mobilestore;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2023 at 08:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobilestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminreg`
--

CREATE TABLE `adminreg` (
  `adid` varchar(255) NOT NULL,
  `adname` varchar(255) NOT NULL,
  `ademail` varchar(255) NOT NULL,
  `adphno` varchar(255) NOT NULL,
  `adpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminreg`
--

INSERT INTO `adminreg` (`adid`, `adname`, `ademail`, `adphno`, `adpassword`) VALUES
('Admi517', 'Admin', 'subhradipdas69@gmail.com', '9635760356', '12345'),
('new364', 'new', 'me@gmail.com', '6789032156', '12345'),
('Subh290', 'Subhratb', 'subhradipdas@gmail.com', '9635760312', '12345'),
('Subh809', 'Subhra', 'subhradipdas6969@gmail.com', '9635760319', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `userid` varchar(255) NOT NULL,
  `proid` varchar(255) NOT NULL,
  `quan` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`userid`, `proid`, `quan`) VALUES
('Subh576', 'phon579', 2),
('Subh576', 'phon758', 1),
('Subh576', 'smar203', 1),
('Subh576', 'smar351', 1),
('Subh576', 'smar612', 1),
('Subh576', 'smar988', 1),
('Subh601', 'phon579', 1),
('Subh601', 'phon758', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `proid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quan` int(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `proimage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`proid`, `name`, `price`, `quan`, `brand`, `proimage`) VALUES
('mobi612', 'mobile', 12345, 0, 'realme', '../uploadImage/3.png'),
('phon579', 'phone', 12000, 23, 'xiome', '../uploadImage/1.png'),
('phon758', 'phone', 12389, 23, 'xiome', '../uploadImage/2.png'),
('smar203', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar283', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar289', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar351', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar379', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar382', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar403', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar460', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar553', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar601', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar612', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar703', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar720', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar810', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar836', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar930', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar965', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png'),
('smar988', 'smart phone', 456789, 12, 'apple', '../uploadImage/3.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phno` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `propic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `email`, `phno`, `address`, `dob`, `password`, `propic`) VALUES
('Subh576', 'Subhradip Das', 'subhradipdas6969@gmail.com', '9635760319', 'none', '2023-09-04', '12345', ''),
('Subh601', 'Subhra', 'mail@gmail.com', '123456789', 'none', '2023-09-13', '12345', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminreg`
--
ALTER TABLE `adminreg`
  ADD PRIMARY KEY (`adid`),
  ADD UNIQUE KEY `ademail` (`ademail`),
  ADD UNIQUE KEY `adphno` (`adphno`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`userid`,`proid`),
  ADD KEY `proid` (`proid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`proid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phno` (`phno`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`proid`) REFERENCES `product` (`proid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
