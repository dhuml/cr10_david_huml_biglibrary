-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2018 at 11:35 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cr10_david_huml_biglibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `media_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `img_link` varchar(200) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `res_status` varchar(15) DEFAULT NULL,
  `fk_media_creator` int(10) UNSIGNED DEFAULT NULL,
  `fk_publisher` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`media_id`, `title`, `img_link`, `short_description`, `res_status`, `fk_media_creator`, `fk_publisher`) VALUES
(1, 'Dylan', 'img/dylan.jpg', NULL, 'available', 1, 3),
(2, 'City lights', 'img/citylights_image.jpg', NULL, 'available', 2, 5),
(3, 'Lawrence of Arabia', 'img/Lawrence_of_arabia.jpg', NULL, 'available', 3, 5),
(4, 'Diamond Life', 'img/sade-diamond-life.jpg', '', 'not available', 4, 6),
(5, 'Woodwalkers', 'img/woodwalkers.jpg', NULL, 'available', 5, 2),
(6, 'Foundation', 'img/asimov.jpg', NULL, 'available', 6, 10),
(7, 'The Sandman', 'img/Sandman.jpg', NULL, 'not available', 7, 9),
(8, 'Modesty Blaise', 'img/modesty1.jpg', NULL, 'available', 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `media_creators`
--

CREATE TABLE `media_creators` (
  `creator_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media_creators`
--

INSERT INTO `media_creators` (`creator_id`, `first_name`, `last_name`, `type`) VALUES
(1, 'Bob', 'Dylan', 'Singer'),
(2, 'Charlie', 'Chaplin', 'Actor'),
(3, 'Thomas Edward', 'Lawrence', 'Writer'),
(4, 'Sade', NULL, 'Singer'),
(5, 'Katja', 'Brandis', 'Writer'),
(6, 'Isaac', 'Asimov', 'Writer'),
(7, 'Neil', 'Gaiman', 'Writer'),
(8, 'Peter ', 'O\'Donnel', 'Writer');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisher_id` int(10) UNSIGNED NOT NULL,
  `publisher_name` varchar(50) DEFAULT NULL,
  `publisher_adress` varchar(60) DEFAULT NULL,
  `publisher_size` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`publisher_id`, `publisher_name`, `publisher_adress`, `publisher_size`) VALUES
(2, 'Bild', 'Axel-Springer-Straße 65, Berlin', 'big'),
(3, 'Columbia Records', 'New York', 'big'),
(4, 'Unitet Artists', 'Los Angeles, California', 'big'),
(5, 'Columbia Pictures', 'Atlanta', 'big'),
(6, 'Epic', 'New York;', 'medium'),
(7, 'universal', 'santa monica, Californa', NULL),
(8, 'Titan Book', 'London', 'medium'),
(9, 'Vertigo', 'New York', 'medium'),
(10, 'Heyne', 'München', 'small');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `user_email` varchar(30) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`) VALUES
(1, 'david', 'david.huml@gmx.at', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
(2, 'johndoe', 'john.doe@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `fk_media_creator` (`fk_media_creator`),
  ADD KEY `fk_publisher` (`fk_publisher`);

--
-- Indexes for table `media_creators`
--
ALTER TABLE `media_creators`
  ADD PRIMARY KEY (`creator_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `media_creators`
--
ALTER TABLE `media_creators`
  MODIFY `creator_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `publisher_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`fk_media_creator`) REFERENCES `media_creators` (`creator_id`),
  ADD CONSTRAINT `media_ibfk_2` FOREIGN KEY (`fk_publisher`) REFERENCES `publisher` (`publisher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
