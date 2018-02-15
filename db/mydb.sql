-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2018 at 06:03 PM
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
(18, 'Dzon', 'Banvil'),
(19, 'Žoze', 'Samargo'),
(20, 'Antoan', 'Pavlovic Cehov');

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
(14, 'Ime ruze', 14),
(15, 'Lolita', 15),
(16, 'Prokleta avlija', 5),
(17, 'Deobe', 16),
(18, 'Seobe', 17),
(19, 'Na Drini cuprija', 5),
(20, 'More', 18),
(21, 'Godina smrti Rikarda Reisa', 19),
(22, 'Ex ponto', 5),
(23, 'Dervis i smrt', 1),
(24, 'Tihi Don', 20);

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
(47, 24, 19, 5, 'Onakva kako se samo moze ocekivati od velikana srpske knjizevnosti kao sto je Ivo Andric. Svaka preporuka.', 5, '2018-01-21 23:19:48'),
(48, 27, 21, 19, 'Odlicna, zaista sjajna!!', 5, '2018-01-29 20:42:17'),
(50, 28, 22, 5, 'Sjajna zbirka, preporucujem svakome', 4, '2018-02-05 15:23:09'),
(51, 28, 23, 1, 'Neverovatno zanimljiva knjiga, veliku gresku sam napravio kada sam izbegao da je procitam u srednjoj skoli.', 4.5, '2018-02-05 15:26:00'),
(57, 1, 8, 11, 'Nisam odusevljen', 1.5, '2018-02-15 17:03:55'),
(58, 1, 11, 1, 'Ako mene pitate - nema bolje!', 5, '2018-02-15 17:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `passwordHash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `passwordHash`, `email`, `active`, `isAdmin`) VALUES
(1, 'darko', 'darko', '$2y$10$kF2m6c89nyG5v5LWTElV1uluh84HM5P/1/ERlcz.RATnXgAy3UL9G', 'darko', '0', 1),
(10, 'darko1', 'darko1', '$2y$10$T7OvGXBTB9fzVQVU3ZNOsevicpooG9h4GYgjym0lKuMjgH./2OpR.', 'darko1', '1', 1),
(15, 'nikola', 'nikola2232', '$2y$10$W1LsdegQMRPyF6LMiBdLKOPHF54lg27cqwmtxvHEHiV34do14xIwq', 'nikola@gmail.com', '0', 0),
(16, 'test', 'password', '$2y$10$7wYXOhLB0Px.vM0MrXRPgOEeb2RaGN13u7DH7B1zO0XQDvD1niIuu', 'test@darko.rs', '0', 0),
(21, 'petar153', 'petar153', '$2y$10$NgCbZSineGwffLwNbR.cHOrK6dw7wXo6SxxNGJU673E1PYlu2/bo.', 'petar153@gmail.com', '0', 0),
(22, 'jovan', 'jovan', '$2y$10$1HGt9tJSvwLW4mT3gSwM5.Mv7ECPxyV3v6oVeVw9E7gWtsN5qFjPS', 'jovan@gmail.com', '0', 0),
(23, 'darko295', 'darkob1995', '$2y$10$ZS2qrNQHRu3Gg33RLVVACOM0krIkZ03P26MSgBHCgSQeHl3ofsd8y', 'darkob295@gmail.com', '0', 0),
(24, 'filip123', 'filip123', '$2y$10$7TixMiiDERgVvSz7vtHSLeyiTbUea5PEarxe4L3sxF8PQcpIWeg0i', 'filip123@gmail.com', '0', 0),
(25, 'pera', 'pera1', '$2y$10$r40t0oqKnm4IHY.aX3iMTOn8Ihq6UJ3Q0X1XK2l2nOVy5DUJERP.i', 'pera@gmail.com', '1', 0),
(26, 'andrijana', 'andrijana', '$2y$10$EOuoFMYb/HIlmKW7rTcai.eUmYMWuzu6mzWa.50a7mScHVD7wl1Cm', 'andrijana@gmail.com', '0', 0),
(27, 'zika', 'zika123', '$2y$10$Qfl6V4O64JT3UpNwo3aG8.G8p76j1Vk8iXTCryNuDsV5ZBnK8zAyK', 'zika@gmail.com', '0', 0),
(28, 'filip', 'filip123', '$2y$10$AyOQQzhOF1riBTyb5w9LzuAa1TqbfpqUB1svY13RWoE5kVfYyBM0C', 'filip1@gmail.com', '0', 0),
(29, 'mika', 'mikamika', '$2y$10$YMf9CHiw5wBnMmj7tJz2fewOYNytXg2yoqbdgH8azxgXpQw.Ntbdi', 'mika123@yahoo.com', '0', 0),
(30, 'darko1995', 'darkob123', '$2y$10$MIXqq0NiUIRpfcYEobaQLOtYlVKgKnpzBsYLqE8pG3oUwUxRmX3m.', 'darko1995@gmail.com', '0', 0),
(32, 'petar', 'pera123pera', '$2y$10$skXbAI3d1a3sDBgodPlzXezbuOlB6nWqkbEb1yc..36IZ.hJMImn.', 'perapetar@outlook.com', '0', 0),
(33, 'nemanja_fil', 'nemanja!@#$%', '$2y$10$/UVWzRlqbbMimphfH3DwSuJxdl61/2zWSEGUP89x4DH6JSvKa21yS', 'nemanja@gmail.com', '1', 0),
(34, 'darko2', 'darko222', '$2y$10$DRQ.AfDxl/bbHXRvx//jD.BcCzudynUvaAOQYlEfDBFro3LgkcnnO', 'darko2@gmail.com', '0', 0),
(35, 'darko9090', 'darko0909', '$2y$10$aIHgGNyHm9I94bIU1kYtCuWTgEK7vU4UgPORLuHCv5dV36TUiUysm', 'darko9090@gmail.com', '0', 0),
(36, 'darko321', 'dar3213', '$2y$10$M1w4PHsEAZWhQZzSnuTesu8/sIRPzTfNk.BA4SYVZM3yERRG9UQk.', 'darko321@gmail.com', '0', 0),
(37, 'milka', 'milka', '$2y$10$loeziy7PkXFgeVvgAatKiuaY4swwfaQyi3bML3LVu2vsKNjEMvGLm', 'milka123@gmail.com', '1', 0),
(38, 'jovan001', 'jovan12314', '$2y$10$O//iVe1ojEgCvgNV5aqF/e1./Gv77ZmByatRKyaSGLTj46B0DvBcW', 'jovan2001@yahoo.com', '0', 0),
(39, 'jovan0012', 'fjsdhgsdlfkjsdg', '$2y$10$xKCAEtAeEJbXSj6qc72KUei0QluMnV8cHhNWCFYH9bHZ1GLHab0Ga', 'jovan20021@yahoo.com', '0', 0),
(40, 'milos', 'milos32131', '$2y$10$msxUIWJpLOi39BRq0CjIc.zMuqPUax8zQ1ygJnYmAcJGyoUWskl.u', 'milos987@gmail.com', '0', 0);

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
  MODIFY `authorID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `bookID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
