-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2018 at 08:14 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `authorID` int(10) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`authorID`, `name`, `surname`) VALUES
(1, 'Mesa', 'Selimovic'),
(5, 'Ivo', 'Andric'),
(9, 'Mihail', 'Bulgakov'),
(10, 'Lav', 'Tolstoj'),
(11, 'Franc', 'Kafka'),
(12, 'Dragana', 'Kragulj'),
(13, 'Dzordz', 'Orvel'),
(14, 'Umberto', 'Eko'),
(15, 'Vladimir', 'Nabokov'),
(16, 'Dobrica', 'Cosic'),
(17, 'Milos', 'Crnjanski'),
(18, 'Dzon', 'Banvil');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `bookID` int(10) NOT NULL,
  `bookTitle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `authorID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`bookID`, `bookTitle`, `authorID`) VALUES
(5, 'Tvrdjava', 1),
(6, 'Majstor i Margarita', 9),
(7, 'Rat i mir', 10),
(8, 'Proces', 11),
(9, 'Ekonomija', 12),
(10, 'Travnicka hronika', 5),
(11, 'Ostrvo', 1),
(12, '1984', 13),
(13, 'Tvrdjavaz', 1),
(14, 'Ime ruze', 14),
(15, 'Lolita', 15),
(16, 'Prokleta avlija', 5),
(17, 'Deobe', 16),
(18, 'Seobe', 17),
(19, 'Na Drini cuprija', 5),
(20, 'More', 18);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `bookID` int(10) NOT NULL,
  `authorID` int(10) NOT NULL,
  `reviewContent` text COLLATE utf8_unicode_ci NOT NULL,
  `reviewStars` float NOT NULL,
  `reviewTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewID`, `userID`, `bookID`, `authorID`, `reviewContent`, `reviewStars`, `reviewTime`) VALUES
(25, 1, 6, 9, 'Opravdao epitet pravog klasika knjizevnosti XX veka. Sve preporuke!', 5, '2017-12-15 15:22:51'),
(34, 10, 12, 13, 'Sjajna knjiga, vanvremenka.', 5, '2017-12-17 00:06:43'),
(35, 10, 5, 1, 'Moja omiljena. Uvek je rado procitam.', 5, '2017-12-17 00:09:49'),
(37, 10, 14, 14, 'Jako teska knjiga za citati. Definitivno za one sa dobrom paznjom i koncentracijom. Generalno, veoma dobra knjiga.', 3.5, '2017-12-17 00:14:58'),
(38, 1, 15, 15, 'Svaka preporuka. Moj novi favorit kada je knjizevnost XX veka u pitanju.', 4, '2017-12-17 13:23:10'),
(41, 15, 16, 5, 'Najsvetlija knjiga srpske knjizevnosti XX veka, nema danas vise takvih pisaca i mislilaca kakav je bio Andric.', 3.5, '2017-12-18 19:26:41'),
(45, 1, 18, 17, 'Jako mi se dopada, jedan od boljih naslova koje sam procitao.', 4.5, '2017-12-24 13:39:56'),
(46, 1, 14, 14, 'Fenomenalna, zaista ume da vas natera da odlutate i zaboravite na vreme.', 4.5, '2018-01-21 23:05:04'),
(47, 24, 19, 5, 'Onakva kako se samo moze ocekivati od velikana srpske knjizevnosti kao sto je Ivo Andric. Svaka preporuka.', 5, '2018-01-21 23:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `email`, `active`, `isAdmin`) VALUES
(1, 'darko', 'darko', 'darko', '1', 1),
(10, 'darko1', 'darko1', 'darko1', '1', 0),
(15, 'nikola', 'nikola2232', 'nikola@gmail.com', '0', 0),
(16, 'test', 'password', 'test@darko.rs', '0', 0),
(21, 'petar153', 'petar153', 'petar153@gmail.com', '0', 0),
(22, 'jovan', 'jovan', 'jovan@gmail.com', '0', 0),
(23, 'darko295', 'darkob1995', 'darkob@gmail.com', '0', 0),
(24, 'filip123', 'filip123', 'filip123@gmail.com', '0', 0),
(25, 'pera', 'pera1', 'pera@gmail.com', '1', 0),
(26, 'andrijana', 'andrijana', 'andrijana@gmail.com', '0', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`authorID`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bookID`),
  ADD KEY `authorID` (`authorID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `authorID` (`authorID`),
  ADD KEY `bookID` (`bookID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `authorID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `bookID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`authorID`) REFERENCES `author` (`authorID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`authorID`) REFERENCES `author` (`authorID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `book` (`bookID`),
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
