-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 04:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manga`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `activated` bit(1) NOT NULL,
  `activate_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `activated`, `activate_token`) VALUES
(1, 'damian123', '$2y$10$tkbGp.J4KMLcteHIfMPz/eCqIihB94koZZgk7oLz9pUwtXue/yOx2', 'khangkhangng2005@gmail.com', b'1', ''),
(2, 'viktor123', '$2y$10$FOIiXH56YGrjFpttnastWOzYDQ1g/l9GnivtLrf8AVVhTjpAk6YUW', 'charlottebullet3107@gmail.com', b'1', ''),
(3, 'dante123', '$2y$10$BgklQWIqVF77nRJHuFYjE.HBjVJSj8qJ/woxkTUbghEkTr55Cj8se', 'abcdef@gmail.com', b'1', ''),
(4, 'Nguvlra', '$2y$10$Ly0RDyKhACCP1E.0ig0bqukOoLQ4/MbzppV0xJcEmcYfrk.Fwvj6S', 'kongudau2@gmail.com', b'1', ''),
(5, 'Bababoey', '$2y$10$bZvprCGXt2ZMVpAADu8vruEi6QTApeWj6J83RZEJfxmusNnTmGGXi', 'hjiisan8man@gmail.com', b'1', ''),
(6, 'Nguvlra123', '$2y$10$axNk07NbQlXWnREo2fSbAe366RF1fxQcT1zFCIFrocbXT5NQaLYgu', 'hjiisanman@gmail.com', b'1', '195b52feb560d30cd7f03d52c5c6b808c13671614d8565eb65bf1b82ec36c395');

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `ArtistID` int(11) NOT NULL,
  `ArtistName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`ArtistID`, `ArtistName`) VALUES
(1, 'Keiyama Kei'),
(2, 'Abe Tsukasa');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `AuthorID` int(11) NOT NULL,
  `AuthorName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`AuthorID`, `AuthorName`) VALUES
(1, 'Zuino'),
(2, 'Yomada Kanehito'),
(3, 'Mikami Saka');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `MangaID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`MangaID`, `UserID`) VALUES
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `ChapterID` int(11) NOT NULL,
  `MangaID` int(11) NOT NULL,
  `Volume` decimal(3,1) NOT NULL,
  `ScangroupName` varchar(20) NOT NULL,
  `UploaderName` varchar(20) NOT NULL,
  `UploadTime` datetime NOT NULL DEFAULT current_timestamp(),
  `ChapterName` varchar(50) NOT NULL,
  `ChapterNumber` decimal(4,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`ChapterID`, `MangaID`, `Volume`, `ScangroupName`, `UploaderName`, `UploadTime`, `ChapterName`, `ChapterNumber`) VALUES
(1, 1, 1.0, 'Kin', 'Kin', '2023-04-07 00:00:00', 'Exciting Animal Mysteries', 1.0),
(2, 1, 1.0, 'Kin', 'Kin', '2023-04-06 16:16:36', 'Beyond the Pale of Vengeance', 2.0),
(3, 1, 1.0, 'Kin', 'Kin', '2023-04-03 16:17:49', 'Laid-back Mountain Climbing Mini Guide', 3.0),
(4, 1, 1.0, 'Kin', 'Kin', '2023-04-04 16:22:00', 'Textbook on eco-energy saving', 4.0),
(5, 1, 1.0, 'Kin', 'Kin', '2023-04-04 16:22:00', 'You can do it! Tidying up!', 5.0),
(6, 1, 1.0, 'Kin', 'Kin', '2023-04-04 16:24:24', 'Wandering Blue Part 1', 6.0),
(7, 1, 1.0, 'Kin', 'Kin', '2023-04-05 16:24:24', 'Ishidaira-kun and Middle-school Library', 6.5),
(8, 2, 1.0, 'I\'d Rather Sleep', 'fevant', '2025-04-15 14:56:00', 'Rintaro and Kaoruko', 1.0),
(9, 2, 1.0, 'I\'d Rather Sleep', 'fevant', '2025-04-15 14:56:00', 'Chidori and Kikyo', 2.0),
(10, 2, 1.0, 'I\'d Rather Sleep', 'fevant', '2025-04-15 14:56:38', 'Test Prep', 3.0),
(11, 3, 1.0, 'Kirei Cake', 'UnChosen', '2025-04-15 14:58:38', 'The End of the Adventure', 1.0),
(12, 3, 1.0, 'Kirei Cake', 'UnChosen', '2025-04-15 14:58:38', 'The Priest\'s Lie', 2.0),
(13, 3, 1.0, 'Kirei Cake', 'Bored_Pray', '2025-04-15 14:59:52', 'Blue Moonweed', 3.0),
(14, 3, 1.0, 'Kirei Cake', 'UnChosen', '2025-04-15 14:59:52', 'The Mage\'s Secret', 4.0);

-- --------------------------------------------------------

--
-- Table structure for table `chapter_pages`
--

CREATE TABLE `chapter_pages` (
  `ChapterID` int(11) NOT NULL,
  `PageNumber` tinyint(4) NOT NULL,
  `PageLink` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chapter_pages`
--

INSERT INTO `chapter_pages` (`ChapterID`, `PageNumber`, `PageLink`) VALUES
(1, 1, '1.png'),
(1, 2, '2.png'),
(1, 3, '3.png'),
(1, 4, '4.png'),
(1, 5, '5.png'),
(1, 6, '6.png'),
(1, 7, '7.png'),
(1, 8, '8.png'),
(1, 9, '9.png'),
(1, 10, '10.png'),
(1, 11, '11.png'),
(1, 12, '12.png'),
(1, 13, '13.png'),
(1, 14, '14.png'),
(1, 15, '15.png'),
(1, 16, '16.png'),
(1, 17, '17.png'),
(1, 18, '18.png'),
(1, 19, '19.png'),
(1, 20, '20.png'),
(1, 21, '21.png'),
(1, 22, '22.png'),
(1, 23, '23.png'),
(1, 24, '24.png'),
(1, 25, '25.png'),
(1, 26, '26.png'),
(1, 27, '27.png'),
(1, 28, '28.png'),
(1, 29, '29.png'),
(1, 30, '30.png'),
(1, 31, '31.png'),
(1, 32, '32.png'),
(1, 33, '33.png'),
(1, 34, '34.png'),
(1, 35, '35.png'),
(1, 36, '36.png'),
(1, 37, '37.png'),
(1, 38, '38.png'),
(1, 39, '39.png'),
(1, 40, '40.png'),
(1, 41, '41.png'),
(1, 42, '42.png'),
(1, 43, '43.png'),
(1, 44, '44.png'),
(2, 1, '1.jpg'),
(2, 2, '2.jpg'),
(2, 3, '3.jpg'),
(2, 4, '4.jpg'),
(2, 5, '5.jpg'),
(2, 6, '6.jpg'),
(2, 7, '7.jpg'),
(2, 8, '8.jpg'),
(2, 9, '9.jpg'),
(2, 10, '10.jpg'),
(2, 11, '11.jpg'),
(2, 12, '12.jpg'),
(2, 13, '13.jpg'),
(2, 14, '14.jpg'),
(2, 15, '15.jpg'),
(2, 16, '16.jpg'),
(2, 17, '17.jpg'),
(2, 18, '18.jpg'),
(2, 19, '19.jpg'),
(2, 20, '20.jpg'),
(2, 21, '21.jpg'),
(2, 22, '22.jpg'),
(2, 23, '23.jpg'),
(2, 24, '24.jpg'),
(2, 25, '25.jpg'),
(2, 26, '26.jpg'),
(2, 27, '27.jpg'),
(2, 28, '28.jpg'),
(2, 29, '29.jpg'),
(2, 30, '30.jpg'),
(2, 31, '31.jpg'),
(11, 1, '1.jfif'),
(11, 2, '2.jfif'),
(11, 3, '3.png'),
(11, 4, '4.png'),
(11, 5, '5.png'),
(11, 6, '6.png'),
(11, 7, '7.png'),
(11, 8, '8.png'),
(11, 9, '9.png'),
(11, 10, '10.png'),
(11, 11, '11.png'),
(11, 12, '12.png'),
(11, 13, '13.png'),
(11, 14, '14.png'),
(11, 15, '15.png'),
(11, 16, '16.png'),
(11, 17, '17.png'),
(11, 18, '18.png'),
(11, 19, '19.png'),
(11, 20, '20.png'),
(11, 21, '21.png'),
(11, 22, '22.png'),
(11, 23, '23.png'),
(11, 24, '24.png'),
(11, 25, '25.png'),
(11, 26, '26.png'),
(11, 27, '27.png'),
(11, 28, '28.png'),
(11, 29, '29.png'),
(11, 30, '30.png'),
(11, 31, '31.png'),
(11, 32, '32.png'),
(11, 33, '33.png'),
(11, 34, '34.png'),
(11, 35, '35.png');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `CommentSectionID` int(11) NOT NULL,
  `CommentText` tinytext NOT NULL,
  `UserID` int(11) NOT NULL,
  `ReplyID` int(11) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`CommentID`, `CommentSectionID`, `CommentText`, `UserID`, `ReplyID`, `CreatedAt`) VALUES
(1, 1, 'Hello mọi người, đây là comment hí hí hí hí ihi1.\r\nNghĩa Trang BHH, lolooollol.', 1, 0, '2025-04-10 08:24:24'),
(2, 1, 'Hell o word/\r\ntôi là ngu vl ra. wow za', 2, 0, '2025-04-10 08:27:24'),
(5, 1, 'Hello world programmed to work and not to feel.', 1, 1, '2025-04-14 16:25:03'),
(6, 1, 'Hello world programmed to work and not to feel.', 1, 1, '2025-04-14 16:26:33'),
(7, 8, 'frieren is so cool', 1, 0, '2025-04-15 16:02:34'),
(8, 8, 'hello!', 3, 0, '2025-04-15 16:41:00'),
(9, 8, 'wowza', 3, 7, '2025-04-15 16:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `commentsection`
--

CREATE TABLE `commentsection` (
  `CommentSectionID` int(11) NOT NULL,
  `ChapterID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `commentsection`
--

INSERT INTO `commentsection` (`CommentSectionID`, `ChapterID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 11),
(8, 11),
(9, 12),
(10, 13),
(11, 14),
(12, 8),
(13, 9),
(14, 10);

-- --------------------------------------------------------

--
-- Table structure for table `manga`
--

CREATE TABLE `manga` (
  `MangaID` int(11) NOT NULL,
  `MangaNameOG` tinytext NOT NULL,
  `MangaNameEN` tinytext NOT NULL,
  `MangaDiscription` text NOT NULL,
  `CoverLink` varchar(50) NOT NULL,
  `OriginalLanguage` varchar(20) NOT NULL,
  `ContentRating` enum('Safe','Suggestive','Erotica','Suggestive/Erotica') NOT NULL,
  `MagazineDemographic` enum('Shounen','Shoujo','Seinen','Josei','None') NOT NULL,
  `PublicationYear` int(4) NOT NULL,
  `PublicationStatus` enum('Ongoing','Completed','Hiatus','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `manga`
--

INSERT INTO `manga` (`MangaID`, `MangaNameOG`, `MangaNameEN`, `MangaDiscription`, `CoverLink`, `OriginalLanguage`, `ContentRating`, `MagazineDemographic`, `PublicationYear`, `PublicationStatus`) VALUES
(1, 'Zeikin de Katta Hon', 'Books Bought With Taxes\n', 'Ishidaira is a delinquent who visited the library for the first time since elementary school. But then, he was pointed out by Hayasemaru and Shirai, who works at the library, that he has not returned a book that he borrowed ten years ago. A manga about how Ishidaira went from trying to borrow a book from a library to working there instead.', 'm1.jpg', 'Japanese', 'Safe', 'Seinen', 2021, 'Ongoing'),
(2, 'Kaoru Hana wa Rin to Saku', 'The Fragrant Flower Blooms With Dignity', 'In a certain place, there are two neighboring high schools. Chidori High School, a bottom-feeder boys\' school where idiots gather, and Kikyo Girls\' School, a well-established girls\' school. Rintaro Tsumugi, a strong and quiet second year student at Chidori High School, meets Kaoruko Waguri, a girl who comes as a customer while helping out at his family\'s cake shop. Rintaro feels comfortable spending time with Kaoruko, but she is a student at Kikyo Girls, a neighboring school that thoroughly dislikes Chidori High.', 'm2.jpg', 'Japanese', 'Safe', 'Shounen', 2021, 'Ongoing'),
(3, 'Sousou no Frieren\r\n\r\n', 'Frieren at the Funeral\r\n', 'The adventure is over but life goes on for an elf mage just beginning to learn what living is all about. Elf mage Frieren and her courageous fellow adventurers have defeated the Demon King and brought peace to the land. With the great struggle over, they all go their separate ways to live a quiet life. But as an elf, Frieren, nearly immortal, will long outlive the rest of her former party. How will she come to terms with the mortality of her friends? How can she find fulfillment in her own life, and can she learn to understand what life means to the humans around her? Frieren begins a new journey to find the answer.', 'm3.jpg', 'Japanese', 'Safe', 'Shounen', 2020, 'Hiatus');

-- --------------------------------------------------------

--
-- Table structure for table `manga_artist`
--

CREATE TABLE `manga_artist` (
  `MangaID` int(11) NOT NULL,
  `ArtistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `manga_artist`
--

INSERT INTO `manga_artist` (`MangaID`, `ArtistID`) VALUES
(1, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `manga_author`
--

CREATE TABLE `manga_author` (
  `MangaID` int(11) NOT NULL,
  `AuthorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `manga_author`
--

INSERT INTO `manga_author` (`MangaID`, `AuthorID`) VALUES
(1, 1),
(2, 3),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `manga_tag`
--

CREATE TABLE `manga_tag` (
  `MangaID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `manga_tag`
--

INSERT INTO `manga_tag` (`MangaID`, `TagID`) VALUES
(1, 43),
(1, 30),
(1, 18),
(1, 16),
(2, 28),
(2, 16),
(2, 18),
(2, 63),
(2, 30),
(3, 4),
(3, 54),
(3, 40),
(3, 14),
(3, 50),
(3, 18),
(3, 19),
(3, 30);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `UserID` int(11) NOT NULL,
  `MangaID` int(11) NOT NULL,
  `Rating` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`UserID`, `MangaID`, `Rating`) VALUES
(3, 3, '10');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `TagID` int(11) NOT NULL,
  `TagGroup` enum('Format','Genre','Theme','Content') NOT NULL,
  `TagName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`TagID`, `TagGroup`, `TagName`) VALUES
(1, 'Format', '4-Koma'),
(2, 'Format', 'Adaptation'),
(3, 'Format', 'Anthology'),
(4, 'Format', 'Award Winning'),
(5, 'Format', 'Doujinshi'),
(6, 'Format', 'Fan Colored'),
(7, 'Format', 'Full Color'),
(8, 'Format', 'Long Strip'),
(9, 'Format', 'Official Colored'),
(10, 'Format', 'Oneshot'),
(11, 'Format', 'Self-Published'),
(12, 'Format', 'Web Comic'),
(13, 'Genre', 'Action'),
(14, 'Genre', 'Adventure'),
(15, 'Genre', 'Boys\' Love'),
(16, 'Genre', 'Comedy'),
(17, 'Genre', 'Crime'),
(18, 'Genre', 'Drama'),
(19, 'Genre', 'Fantasy'),
(20, 'Genre', 'Girls\' Love'),
(21, 'Genre', 'Historical'),
(22, 'Genre', 'Horror Isekai'),
(23, 'Genre', 'Magical Girls'),
(24, 'Genre', 'Mecha'),
(25, 'Genre', 'Medical'),
(26, 'Genre', 'Mystery'),
(27, 'Genre', 'Psychological'),
(28, 'Genre', 'Romance'),
(29, 'Genre', 'Sci-Fi'),
(30, 'Genre', 'Slice of Life'),
(31, 'Genre', 'Superhero'),
(32, 'Genre', 'Thriller'),
(33, 'Genre', 'Tragedy'),
(34, 'Genre', 'Wuxia'),
(35, 'Genre', 'Philosophical'),
(36, 'Genre', 'Sports'),
(37, 'Theme', 'Aliens'),
(38, 'Theme', 'Animals'),
(39, 'Theme', 'Cooking'),
(40, 'Theme', 'Demons'),
(41, 'Theme', 'Genderswap'),
(42, 'Theme', 'Crossdressing'),
(43, 'Theme', 'Delinquents'),
(44, 'Theme', 'Ghosts'),
(45, 'Theme', 'Gyaru'),
(46, 'Theme', 'Harem'),
(47, 'Theme', 'Incest'),
(48, 'Theme', 'Loli'),
(49, 'Theme', 'Mafia'),
(50, 'Theme', 'Magic'),
(51, 'Theme', 'Martial Arts'),
(52, 'Theme', 'Military'),
(53, 'Theme', 'Monster Girls'),
(54, 'Theme', 'Monsters'),
(55, 'Theme', 'Music'),
(56, 'Theme', 'Ninja'),
(57, 'Theme', 'Office Workers'),
(58, 'Theme', 'Police'),
(59, 'Theme', 'Post-Apocalyptic'),
(60, 'Theme', 'Reincarnation'),
(61, 'Theme', 'Reverse Harem'),
(62, 'Theme', 'Samurai'),
(63, 'Theme', 'School Life'),
(64, 'Theme', 'Shota'),
(65, 'Theme', 'Supernatural'),
(66, 'Theme', 'Survival'),
(67, 'Theme', 'Time Travel'),
(68, 'Theme', 'Traditional Games'),
(69, 'Theme', 'Vampires'),
(70, 'Theme', 'Video Games'),
(71, 'Theme', 'Villainess'),
(72, 'Theme', 'Virtual Reality'),
(73, 'Theme', 'Zombies'),
(74, 'Content', 'Gore'),
(75, 'Content', 'Sexual Violence');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Joined` datetime NOT NULL DEFAULT current_timestamp(),
  `Avatar` varchar(50) NOT NULL DEFAULT 'avatar_default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Joined`, `Avatar`) VALUES
(1, 'Nguvlra', '2025-04-09 15:58:19', 'avatar_default.png'),
(2, 'Bababoey', '2025-04-10 07:28:54', 'avatar_default.png'),
(3, 'Nguvlra123', '2025-04-15 16:35:13', 'avatar_default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`ArtistID`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`AuthorID`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`ChapterID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`);

--
-- Indexes for table `commentsection`
--
ALTER TABLE `commentsection`
  ADD PRIMARY KEY (`CommentSectionID`);

--
-- Indexes for table `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`MangaID`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`TagID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `ArtistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `AuthorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `ChapterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `commentsection`
--
ALTER TABLE `commentsection`
  MODIFY `CommentSectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `manga`
--
ALTER TABLE `manga`
  MODIFY `MangaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
