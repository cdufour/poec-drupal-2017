-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2017 at 02:26 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajax`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `type` enum('creature','sorcery','enchantement','') NOT NULL,
  `color` enum('blue','red','green','black','white','multicolor') NOT NULL,
  `img` varchar(255) NOT NULL,
  `popularity` int(11) NOT NULL,
  `edition_id` int(11) NOT NULL,
  `illustrator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`id`, `name`, `body`, `type`, `color`, `img`, `popularity`, `edition_id`, `illustrator_id`) VALUES
(1, 'Shivan Dragon', '', 'creature', 'red', 'card-shivan-dragon.jpg', 3, 1, 2),
(2, 'Serra Angel', '', 'creature', 'white', 'card-serra-angel.jpg', 2, 1, 0),
(3, 'Zombify', '', 'sorcery', 'black', 'card-zombify.jpg', 1, 2, 1),
(4, 'Call of Nature', '', 'enchantement', 'green', '', 27, 1, 0),
(5, 'Nissa Angel', '', 'creature', 'multicolor', 'card-jace-cunning-castaway.jpg', 6, 2, 1),
(6, 'Furious zomby', '', 'creature', 'black', '', 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `edition`
--

CREATE TABLE `edition` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `edition`
--

INSERT INTO `edition` (`id`, `name`, `date_start`, `date_end`) VALUES
(1, 'Kaladesh', '2017-05-01', '2017-10-31'),
(2, 'Ixalan', '2017-11-10', '2018-02-10');

-- --------------------------------------------------------

--
-- Table structure for table `illustrator`
--

CREATE TABLE `illustrator` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `illustrator`
--

INSERT INTO `illustrator` (`id`, `firstname`, `lastname`, `country`) VALUES
(1, 'Paolo', 'Del Priore', 'Pologne'),
(2, 'Monica', 'Bellucci', 'Italie');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edition`
--
ALTER TABLE `edition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `illustrator`
--
ALTER TABLE `illustrator`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `edition`
--
ALTER TABLE `edition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `illustrator`
--
ALTER TABLE `illustrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
