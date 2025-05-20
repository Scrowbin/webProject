-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 20, 2025 lúc 04:46 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `manga`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `activated` bit(1) NOT NULL,
  `activate_token` varchar(255) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `password`, `email`, `activated`, `activate_token`, `reset_token`, `reset_token_expiry`) VALUES
('Bababoey', '$2y$10$bZvprCGXt2ZMVpAADu8vruEi6QTApeWj6J83RZEJfxmusNnTmGGXi', 'hjiisan8man@gmail.com', b'1', '', NULL, NULL),
('Nguvlra', '$2y$10$Ly0RDyKhACCP1E.0ig0bqukOoLQ4/MbzppV0xJcEmcYfrk.Fwvj6S', 'kongudau2@gmail.com', b'1', '', NULL, NULL),
('Nguvlra123', '$2y$10$axNk07NbQlXWnREo2fSbAe366RF1fxQcT1zFCIFrocbXT5NQaLYgu', 'hjiisanman@gmail.com', b'1', '195b52feb560d30cd7f03d52c5c6b808c13671614d8565eb65bf1b82ec36c395', NULL, NULL),
('damian123', '$2y$10$oynziSDxwuGBb9ZX4V437epDsQIcCSmoFyWzxfT5jAzZjD100PaXS', 'eugene123@gmail.com', b'1', '', NULL, NULL),
('engraver123', '$2y$10$8BDAcMwPFRPpSick/UjQm.mARJ5PkGX5SZdsXMIVyHiO60qxQDsU6', 'khangkhangng200528@gmail.com', b'1', '', NULL, NULL),
('lacrimosa123', '$2y$10$rA55JL8fh2mqF/ZAQucajOhFOxiizgfZjHfwDqBpC2Jx9ajRcqD9C', 'charlottebullet3107@gmail.com', b'1', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `announcement`
--

CREATE TABLE `announcement` (
  `announcementID` int(11) NOT NULL,
  `content` text NOT NULL,
  `expirteAt` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `announcement`
--

INSERT INTO `announcement` (`announcementID`, `content`, `expirteAt`, `isActive`) VALUES
(9, '<p>abc</p>', NULL, 0),
(10, '<p>hẻ</p>', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `artist`
--

CREATE TABLE `artist` (
  `ArtistID` int(11) NOT NULL,
  `ArtistName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `artist`
--

INSERT INTO `artist` (`ArtistID`, `ArtistName`) VALUES
(1, 'Keiyama Kei'),
(2, 'Abe Tsukasa'),
(3, 'Megame'),
(4, 'Yukimura Makoto'),
(11, '123123123'),
(12, 'Oda'),
(13, 'NTBHH'),
(14, '12312'),
(15, 'Kobayashi Yuugo'),
(16, 'Araki Hirohiko'),
(17, 'Miura Kouji'),
(18, 'Fuji Ryousuke'),
(19, 'Oda Eiichiro'),
(20, 'Sako Toshio'),
(21, 'Kentaro Miura');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `author`
--

CREATE TABLE `author` (
  `AuthorID` int(11) NOT NULL,
  `AuthorName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `author`
--

INSERT INTO `author` (`AuthorID`, `AuthorName`) VALUES
(1, 'Zuino'),
(2, 'Yomada Kanehito'),
(3, 'Mikami Saka'),
(5, 'Megame'),
(6, 'Yukimura Makoto'),
(13, '123123123'),
(14, 'Oda'),
(15, 'NTBHH'),
(16, '12312'),
(17, 'Kobayashi Yuugo'),
(18, 'Araki Hirohiko'),
(19, 'Miura Kouji'),
(20, 'katarina'),
(21, 'Oda Eiichiro'),
(22, 'Sako Toshio'),
(23, 'Kentaro Miura');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookmark`
--

CREATE TABLE `bookmark` (
  `MangaID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `bookmark`
--

INSERT INTO `bookmark` (`MangaID`, `UserID`) VALUES
(1, 3),
(3, 3),
(5, 3),
(22, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapter`
--

CREATE TABLE `chapter` (
  `ChapterID` int(11) NOT NULL,
  `MangaID` int(11) NOT NULL,
  `Volume` decimal(3,1) NOT NULL,
  `ScangroupName` varchar(20) NOT NULL,
  `UploaderName` varchar(20) NOT NULL,
  `UploadTime` datetime NOT NULL DEFAULT current_timestamp(),
  `ChapterName` varchar(50) NOT NULL,
  `ChapterNumber` decimal(4,1) NOT NULL,
  `Language` varchar(20) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `chapter`
--

INSERT INTO `chapter` (`ChapterID`, `MangaID`, `Volume`, `ScangroupName`, `UploaderName`, `UploadTime`, `ChapterName`, `ChapterNumber`, `Language`) VALUES
(1, 1, 1.0, 'Kin', 'Kin', '2023-04-07 00:00:00', 'Exciting Animal Mysteries', 1.0, 'en'),
(2, 1, 1.0, 'Kin', 'Kin', '2023-04-06 16:16:36', 'Beyond the Pale of Vengeance', 2.0, 'en'),
(3, 1, 1.0, 'Kin', 'Kin', '2023-04-03 16:17:49', 'Laid-back Mountain Climbing Mini Guide', 3.0, 'en'),
(4, 1, 1.0, 'Kin', 'Kin', '2023-04-04 16:22:00', 'Textbook on eco-energy saving', 4.0, 'en'),
(5, 1, 1.0, 'Kin', 'Kin', '2023-04-04 16:22:00', 'You can do it! Tidying up!', 5.0, 'en'),
(6, 1, 1.0, 'Kin', 'Kin', '2023-04-04 16:24:24', 'Wandering Blue Part 1', 6.0, 'en'),
(7, 1, 1.0, 'Kin', 'Kin', '2023-04-05 16:24:24', 'Ishidaira-kun and Middle-school Library', 6.5, 'en'),
(11, 3, 1.0, 'Kirei Cake', 'UnChosen', '2025-04-15 14:58:38', 'The End of the Adventure', 1.0, 'en'),
(12, 3, 1.0, 'Kirei Cake', 'UnChosen', '2025-04-15 14:58:38', 'The Priest\'s Lie', 2.0, 'en'),
(13, 3, 1.0, 'Kirei Cake', 'Bored_Pray', '2025-04-15 14:59:52', 'Blue Moonweed', 3.0, 'en'),
(14, 3, 1.0, 'Kirei Cake', 'UnChosen', '2025-04-15 14:59:52', 'The Mage\'s Secret', 4.0, 'en'),
(24, 5, 1.0, 'Normanni', 'Anonymous', '2025-04-28 11:56:42', 'Normander', 1.0, 'en'),
(37, 19, 1.0, '', 'Nguvlra123', '2025-05-08 07:04:54', 'Mechanisms', 1.0, 'en'),
(38, 20, 1.0, '', 'Nguvlra123', '2025-05-08 07:15:36', 'First touchs', 1.0, 'en'),
(39, 19, 1.0, '', 'Nguvlra123', '2025-05-08 07:16:56', 'The Japanese Person on Hawaiʻi Island', 2.0, 'en'),
(40, 19, 1.0, '', 'Nguvlra123', '2025-05-08 07:17:41', 'Search for the Diamond in the Mansion', 3.0, 'en'),
(41, 21, 1.0, '', 'Nguvlra123', '2025-05-08 07:26:59', 'You Have to go to Nationals', 2.0, 'en'),
(42, 21, 1.0, '', 'Nguvlra123', '2025-05-08 07:27:28', 'Giả vờ như người lạ', 3.0, 'vn'),
(43, 4, 1.0, '', 'Nguvlra123', '2025-05-08 07:34:03', 'Mizudako-chan Attacks!', 0.0, 'en'),
(44, 5, 1.0, '', 'Nguvlra123', '2025-05-08 07:43:25', 'Somewhere Not Here', 2.0, 'en'),
(45, 22, 1.0, '', 'Nguvlra123', '2025-05-08 08:01:30', 'WHAT DO YOU PLAY GAMES FOR?', 1.0, 'en'),
(46, 22, 1.0, '', 'Nguvlra123', '2025-05-08 08:03:27', 'Something Unique', 2.0, 'en'),
(47, 22, 1.0, '', 'Nguvlra123', '2025-05-08 08:04:33', 'Night Fight', 3.0, 'en'),
(48, 22, 1.0, '', 'Nguvlra123', '2025-05-08 08:05:31', 'A Unique Chain Reaction', 4.0, 'en'),
(49, 2, 1.0, '', 'Nguvlra123', '2025-05-08 08:08:03', 'Rintaro and Kaoruko', 1.0, 'en'),
(50, 23, 1.0, '', 'Nguvlra123', '2025-05-08 08:12:38', 'Romance Dawn', 1.0, 'en'),
(51, 1, 9.0, '', 'Nguvlra123', '2025-05-10 12:18:53', 'Vol. 9 Extras', 70.5, 'en');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapter_pages`
--

CREATE TABLE `chapter_pages` (
  `ChapterID` int(11) NOT NULL,
  `PageNumber` tinyint(4) NOT NULL,
  `PageLink` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `chapter_pages`
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
(11, 35, '35.png'),
(24, 1, '1.jfif'),
(24, 2, '2.jfif'),
(24, 3, '3.jfif'),
(24, 4, '4.jfif'),
(24, 5, '5.jfif'),
(24, 6, '6.jfif'),
(24, 7, '7.jfif'),
(24, 8, '8.jfif'),
(24, 9, '9.jfif'),
(24, 10, '10.jfif'),
(24, 11, '11.jfif'),
(37, 1, '1.png'),
(37, 2, '2.png'),
(37, 3, '3.png'),
(37, 4, '4.png'),
(37, 5, '5.png'),
(37, 6, '6.png'),
(38, 1, '1.png'),
(38, 2, '2.png'),
(38, 3, '3.png'),
(38, 4, '4.png'),
(38, 5, '5.png'),
(38, 6, '6.png'),
(38, 7, '7.png'),
(39, 1, '1.png'),
(39, 2, '2.png'),
(39, 3, '3.png'),
(39, 4, '4.png'),
(39, 5, '5.png'),
(39, 6, '6.png'),
(39, 7, '7.png'),
(40, 1, '1.png'),
(40, 2, '2.png'),
(40, 3, '3.png'),
(40, 4, '4.png'),
(40, 5, '5.png'),
(40, 6, '6.png'),
(40, 7, '7.png'),
(41, 1, '1.jfif'),
(41, 2, '2.jfif'),
(41, 3, '3.jfif'),
(42, 1, '1.jfif'),
(42, 2, '2.jfif'),
(42, 3, '3.jfif'),
(42, 4, '4.jfif'),
(42, 5, '5.jfif'),
(43, 1, '1.png'),
(43, 2, '2.png'),
(43, 3, '3.png'),
(43, 4, '4.png'),
(43, 5, '5.png'),
(44, 1, '1.jfif'),
(44, 2, '2.jfif'),
(44, 3, '3.jfif'),
(44, 4, '4.jfif'),
(44, 5, '5.jfif'),
(45, 1, '1.png'),
(45, 2, '2.png'),
(45, 3, '3.png'),
(45, 4, '4.png'),
(45, 5, '5.png'),
(45, 6, '6.png'),
(45, 7, '7.png'),
(45, 8, '8.png'),
(45, 9, '9.png'),
(45, 10, '10.png'),
(45, 11, '11.png'),
(45, 12, '12.png'),
(45, 13, '13.png'),
(45, 14, '14.png'),
(45, 15, '15.png'),
(45, 16, '16.png'),
(45, 17, '17.png'),
(45, 18, '18.png'),
(45, 19, '19.png'),
(45, 20, '20.png'),
(46, 1, '1.png'),
(46, 2, '2.png'),
(46, 3, '3.png'),
(46, 4, '4.png'),
(46, 5, '5.png'),
(47, 1, '1.jfif'),
(47, 2, '2.jfif'),
(47, 3, '3.jfif'),
(47, 4, '4.jfif'),
(47, 5, '5.jfif'),
(48, 1, '1.png'),
(48, 2, '2.png'),
(48, 3, '3.png'),
(48, 4, '4.png'),
(48, 5, '5.png'),
(49, 1, '1.png'),
(49, 2, '2.png'),
(49, 3, '3.png'),
(49, 4, '4.png'),
(49, 5, '5.png'),
(50, 1, '1.jpeg'),
(50, 2, '2.jpeg'),
(50, 3, '3.jpeg'),
(50, 4, '4.jpeg'),
(50, 5, '5.jpeg'),
(50, 6, '6.jpeg'),
(50, 7, '7.jpeg'),
(50, 8, '8.jpeg'),
(50, 9, '9.jpeg'),
(50, 10, '10.jpeg'),
(50, 11, '11.jpeg'),
(50, 12, '12.jpeg'),
(50, 13, '13.jpeg'),
(50, 14, '14.jpeg'),
(50, 15, '15.jpeg'),
(50, 16, '16.jpeg'),
(50, 17, '17.jpeg'),
(50, 18, '18.jpeg'),
(50, 19, '19.jpeg'),
(50, 20, '20.jpeg'),
(50, 21, '21.jpeg'),
(50, 22, '22.jpeg'),
(50, 23, '23.jpeg'),
(50, 24, '24.jpeg'),
(50, 25, '25.jpeg'),
(50, 26, '26.jpeg'),
(50, 27, '27.jpeg'),
(50, 28, '28.jpeg'),
(50, 29, '29.jpeg'),
(50, 30, '30.jpeg'),
(51, 1, '1.png'),
(51, 2, '2.png'),
(51, 3, '3.png'),
(51, 4, '4.png'),
(51, 5, '5.png'),
(51, 6, '6.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
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
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`CommentID`, `CommentSectionID`, `CommentText`, `UserID`, `ReplyID`, `CreatedAt`) VALUES
(1, 1, 'Hello mọi người, đây là comment hí hí hí hí ihi1.\r\nNghĩa Trang BHH, lolooollol.', 1, 0, '2025-04-10 08:24:24'),
(2, 1, 'Hell o word/\r\ntôi là ngu vl ra. wow za', 2, 0, '2025-04-10 08:27:24'),
(5, 1, 'Hello world programmed to work and not to feel.', 1, 1, '2025-04-14 16:25:03'),
(6, 1, 'Hello world programmed to work and not to feel.', 1, 1, '2025-04-14 16:26:33'),
(7, 8, 'frieren is so cool', 1, 0, '2025-04-15 16:02:34'),
(8, 8, 'hello!', 3, 0, '2025-04-15 16:41:00'),
(9, 8, 'wowza', 3, 7, '2025-04-15 16:41:09'),
(10, 9, 'whats up people', 3, 0, '2025-05-02 14:15:44'),
(11, 15, 'I have no enemies', 3, 0, '2025-05-02 15:01:42'),
(12, 40, 'hello', 3, 0, '2025-05-10 12:25:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `commentsection`
--

CREATE TABLE `commentsection` (
  `CommentSectionID` int(11) NOT NULL,
  `ChapterID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `commentsection`
--

INSERT INTO `commentsection` (`CommentSectionID`, `ChapterID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(8, 11),
(9, 12),
(10, 13),
(11, 14),
(15, 24),
(28, 37),
(29, 38),
(30, 39),
(31, 40),
(32, 41),
(33, 42),
(34, 43),
(35, 44),
(36, 45),
(37, 46),
(38, 47),
(39, 48),
(40, 49),
(41, 50),
(42, 51);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manga`
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
  `PublicationStatus` enum('Ongoing','Completed','Hiatus','Cancelled') NOT NULL,
  `Slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `manga`
--

INSERT INTO `manga` (`MangaID`, `MangaNameOG`, `MangaNameEN`, `MangaDiscription`, `CoverLink`, `OriginalLanguage`, `ContentRating`, `MagazineDemographic`, `PublicationYear`, `PublicationStatus`, `Slug`) VALUES
(1, 'Zeikin de Katta Hon', 'Books Bought With Taxes', '<p>Ishidaira is a delinquent who visited the library for the first time since elementary school. But then, he was pointed out by Hayasemaru and Shirai, who works at the library, that he has not returned a book that he borrowed ten years ago. A manga about how Ishidaira went from trying to borrow a book from a library to working there instead.</p>', 'm1.jpg', 'Japanese', 'Safe', 'Seinen', 2021, 'Ongoing', 'zeikin-de-katta-hon'),
(2, 'Kaoru Hana wa Rin to Saku', 'The Fragrant Flower Blooms With Dignity', 'In a certain place, there are two neighboring high schools. Chidori High School, a bottom-feeder boys\' school where idiots gather, and Kikyo Girls\' School, a well-established girls\' school. Rintaro Tsumugi, a strong and quiet second year student at Chidori High School, meets Kaoruko Waguri, a girl who comes as a customer while helping out at his family\'s cake shop. Rintaro feels comfortable spending time with Kaoruko, but she is a student at Kikyo Girls, a neighboring school that thoroughly dislikes Chidori High.', 'm2.jpg', 'Japanese', 'Safe', 'Shounen', 2021, 'Ongoing', 'kaoru-hana-wa-rin-to-saku'),
(3, 'Sousou no Frieren\r\n\r\n', 'Frieren at the Funeral\r\n', 'The adventure is over but life goes on for an elf mage just beginning to learn what living is all about. Elf mage Frieren and her courageous fellow adventurers have defeated the Demon King and brought peace to the land. With the great struggle over, they all go their separate ways to live a quiet life. But as an elf, Frieren, nearly immortal, will long outlive the rest of her former party. How will she come to terms with the mortality of her friends? How can she find fulfillment in her own life, and can she learn to understand what life means to the humans around her? Frieren begins a new journey to find the answer.', 'm3.jpg', 'Japanese', 'Safe', 'Shounen', 2020, 'Hiatus', 'sousou-no-frieren'),
(4, 'Mizudako-chan kara wa Nigerarenai!', 'You Can\'t Escape from Mizudako-chan!', 'Akigai Kanisuke is an ordinary high school boy. His daily life changes when Mizuda Yuuko (a.k.a. Mizudako-chan), a demi-human girl, transfers to his school.', 'm4.jpg', 'Japanese', 'Safe', 'Seinen', 2023, 'Ongoing', 'mizudako-chan-kara-wa-nigerarenai'),
(5, 'Vinland Saga', 'Vinland Saga', 'As a child, Thorfinn sat at the feet of the great Leif Ericson and thrilled to wild tales of a land far to the west. But his youthful fantasies were shattered by a mercenary raid. Raised by the Vikings who murdered his family, Thorfinn became a terrifying warrior, forever seeking to kill the band\'s leader, Askeladd, and avenge his father. Sustaining Thorfinn through his ordeal are his pride in his family and his dreams of a fertile westward land, a land without war or slavery… the land Leif called Vinland.', 'm5.jpg', 'Japanese', 'Suggestive', 'Seinen', 2005, 'Ongoing', 'vinland-saga'),
(19, 'JoJo\'s Bizarre Adventure Part 9 - The JOJOLands', 'ジョジョの奇妙な冒険 Part9 The JOJOLands', '<p>O&rsquo;ahu, present day. Dua Lipa is the trending musician, and COVID is still a major concern. On this island lives a 15-year-old boy named Jodio Joestar. Living with his brother and mother, he acts as a dealer for certain illegal substances. One day, his employer comes and shows him an excellent find: a Japanese person has landed in Hawaii with a diamond worth over six million dollars. Normally it would be impossible to steal, but for someone with a stand&hellip;</p>\r\n<p>This is a story of a young boy and his quest to become rich.</p>', 'm19.jpg', 'English', 'Safe', 'Shounen', 2023, 'Ongoing', 'jojos-bizarre-adventure-part-9-the-jojolands'),
(20, 'Ao Ashi', 'アオアシ', '<p style=\"text-align: justify;\">Aoi Ashito is a third year middle school student from Ehime. Behind his raw game hides his immense talent, but Ashito suffers a huge setback because of his overly straightforward personality.</p>\r\n<p style=\"text-align: justify;\">One day the youth team manager of J1 club Tokyo City Esperion, Fukuda Tetsuya, appears in front of him. Fukuda sees his limitless potential and invites him to take part in his team\'s tryouts in Tokyo.</p>\r\n<p style=\"text-align: justify;\">The story of the boy who will revolutionize football in Japan rapidly begins to unfold.</p>', 'm20.jpg', 'English', 'Safe', 'Shounen', 2015, 'Ongoing', 'ao-ashi'),
(21, 'Ao no Hako', 'Blue Box', '<p>Taiki Inomata is on the boys\' badminton team at sports powerhouse Eimei Junior and Senior High. He\'s in love with basketball player Chinatsu Kano, the older girl he trains alongside every morning in the gym. One Spring day, their relationship takes a sharp turn ... And thus begins this brand-new series of love, sports and youth!</p>', 'm21.jpg', 'English', 'Safe', 'Shounen', 2021, 'Ongoing', 'ao-no-hako'),
(22, 'Shangri-La Frontier ~Kusoge Hunter, Kamige ni Idoman to su~', 'Shangri-La Frontier: From Trash Game Hunter to God-Tier Gamer!', '<p style=\"text-align: justify;\">Second-year high school student Rakuro Hizutome loves nothing more than finding so-called \"trash games\" and beating the crap out of them. When he decides to change things up by playing a new, \"god-tier\" VR game known as Shangri-La Frontier (aka. SLF), he does what he does best: min-maxes, skips the prologue, and jumps straight into action! Rakuro may be a seasoned gamer, but a meeting with an old rival will change the fate of every SLF player forever.</p>\r\n<p style=\"text-align: justify;\">Clad in nothing but shorts and a bird mask, Rakuro (player name: Sunraku) launches into the world of SLF. Things are going well at first as he takes down a goblin, a bunny, and even a python. But then Sunraku comes up against a huge, hard-hitting wolf known as Lycagon the Nightslayer. Will Sunraku\'s years of \"trash game\" experience be enough, or is he about to suffer a rude awakening just a few hours into his SLF adventure?</p>', 'm22.webp', 'Japanese', 'Safe', 'Shounen', 2020, 'Ongoing', 'shangri-la-frontier-kusoge-hunter-kamige-ni-idoman-to-su'),
(23, 'ワンピース', 'One Piece', '<p style=\"text-align: justify;\">Gol D. Roger, a man referred to as the \"Pirate King,\" is set to be executed by the World Government. But just before his demise, he confirms the existence of a great treasure, One Piece, located somewhere within the vast ocean known as the Grand Line. Announcing that One Piece can be claimed by anyone worthy enough to reach it, the Pirate King is executed and the Great Age of Pirates begins.</p>\r\n<p style=\"text-align: justify;\">Twenty-two years later, a young man by the name of Monkey D. Luffy is ready to embark on his own adventure, searching for One Piece and striving to become the new Pirate King. Armed with just a straw hat, a small boat, and an elastic body, he sets out on a fantastic journey to gather his own crew and a worthy ship that will take them across the Grand Line to claim the greatest status on the high seas.</p>', 'm23.jpg', 'Japanese', 'Suggestive', 'Shounen', 1997, 'Ongoing', 'one-piece'),
(24, 'Usogui', 'Lie Eater', '<p>There are gamblers out there who even bet their lives as ante. But to secure the integrity of these life-threatening gambles, a violent and powerful organization by the name of &ldquo;Kakerou&rdquo; referees these games as a neutral party. Follow Baku Madarame a.k.a. Usogui (The Lie Eater) as he gambles against maniacal opponents at games &ndash; such as Escape the Abandoned Building, Old Maid, and Hangman &ndash; to ultimately &ldquo;out-gamble&rdquo; and control the neutral organization of Kakerou itself.</p>', 'm24.jpg', 'Japanese', 'Suggestive', 'Seinen', 2008, 'Completed', 'usogui'),
(25, 'ベルセルク', 'Berserk', '<p>Guts, known as the Black Swordsman, seeks sanctuary from the demonic forces attracted to him and his woman because of a demonic mark on their necks, and also vengeance against the man who branded him as an unholy sacrifice.</p>\r\n<p>Aided only by his titanic strength gained from a harsh childhood lived with mercenaries, a gigantic sword, and an iron prosthetic left hand, Guts must struggle against his bleak destiny, all the while fighting with a rage that might strip him of his humanity.</p>\r\n<p><em><strong>Won the 6th Osamu Tezuka Cultural Prize Excellence Award in 2002.</strong></em></p>', 'm25.jpg', 'Japanese', 'Erotica', 'Shounen', 1989, 'Ongoing', 'berserk');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manga_artist`
--

CREATE TABLE `manga_artist` (
  `MangaID` int(11) NOT NULL,
  `ArtistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `manga_artist`
--

INSERT INTO `manga_artist` (`MangaID`, `ArtistID`) VALUES
(1, 1),
(3, 2),
(4, 3),
(5, 4),
(19, 16),
(20, 15),
(21, 17),
(22, 18),
(23, 19),
(24, 20),
(25, 21);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manga_author`
--

CREATE TABLE `manga_author` (
  `MangaID` int(11) NOT NULL,
  `AuthorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `manga_author`
--

INSERT INTO `manga_author` (`MangaID`, `AuthorID`) VALUES
(1, 1),
(2, 3),
(3, 2),
(4, 5),
(5, 6),
(19, 18),
(20, 17),
(21, 19),
(22, 20),
(23, 21),
(24, 22),
(25, 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manga_tag`
--

CREATE TABLE `manga_tag` (
  `MangaID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `manga_tag`
--

INSERT INTO `manga_tag` (`MangaID`, `TagID`) VALUES
(1, 16),
(1, 18),
(1, 30),
(1, 43),
(2, 16),
(2, 18),
(2, 28),
(2, 30),
(2, 63),
(3, 4),
(3, 14),
(3, 18),
(3, 19),
(3, 30),
(3, 40),
(3, 50),
(3, 54),
(4, 16),
(4, 28),
(4, 30),
(4, 53),
(4, 63),
(4, 65),
(5, 4),
(5, 13),
(5, 14),
(5, 18),
(5, 21),
(5, 27),
(5, 28),
(5, 30),
(5, 32),
(5, 33),
(5, 51),
(5, 52),
(5, 66),
(5, 74),
(19, 6),
(19, 8),
(20, 4),
(21, 16),
(21, 18),
(21, 28),
(21, 30),
(22, 70),
(22, 72),
(23, 2),
(23, 13),
(23, 14),
(23, 16),
(23, 17),
(23, 18),
(23, 19),
(24, 13),
(24, 18),
(24, 26),
(24, 27),
(24, 32),
(24, 49),
(24, 51),
(24, 74),
(25, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

CREATE TABLE `rating` (
  `UserID` int(11) NOT NULL,
  `MangaID` int(11) NOT NULL,
  `Rating` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `rating`
--

INSERT INTO `rating` (`UserID`, `MangaID`, `Rating`) VALUES
(3, 1, '10'),
(3, 3, '9'),
(3, 19, '10'),
(3, 21, '8'),
(3, 22, '7');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `report_chapter`
--

CREATE TABLE `report_chapter` (
  `ReportID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ChapterID` int(11) NOT NULL,
  `ReportType` varchar(50) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Resolved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `report_chapter`
--

INSERT INTO `report_chapter` (`ReportID`, `UserID`, `ChapterID`, `ReportType`, `Description`, `Resolved`) VALUES
(1, 3, 1, 'incorrect_group', '', 1),
(3, 3, 51, 'Incorrect group', 'itss the wrong group !!!', 1),
(4, 3, 51, 'Other', 'a', 1),
(5, 3, 50, 'Missing pages', '', 1),
(6, 3, 50, 'Missing pages', '', 1),
(7, 3, 50, 'Missing pages', '', 1),
(8, 3, 50, 'Other', '', 1),
(9, 3, 50, 'Other', '', 1),
(10, 3, 50, 'Missing pages', '', 1),
(11, 3, 50, 'Other', '', 1),
(12, 3, 51, 'Missing pages', '', 1),
(13, 3, 51, 'Official release/Raw', '', 1),
(14, 3, 51, 'Incorrect or duplicate pages', '', 1),
(15, 3, 51, 'Pages out of order', '', 1),
(16, 3, 51, 'Other', '', 1),
(17, 3, 51, 'Other', '', 1),
(18, 3, 51, 'Other', '', 1),
(19, 3, 51, 'Wrong manga', '', 1),
(20, 3, 51, 'Watermarked', '', 1),
(21, 3, 2, 'Other', '', 1),
(22, 3, 2, 'Watermarked', '', 1),
(23, 3, 2, 'Watermarked', '', 1),
(24, 3, 2, 'Released before raws', '', 1),
(25, 3, 2, 'Released before raws', '', 1),
(26, 3, 2, 'Wrong manga', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `report_manga`
--

CREATE TABLE `report_manga` (
  `ReportID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `MangaID` int(11) NOT NULL,
  `ReportType` varchar(30) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Resolved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `report_manga`
--

INSERT INTO `report_manga` (`ReportID`, `UserID`, `MangaID`, `ReportType`, `Description`, `Resolved`) VALUES
(2, 3, 1, 'missing_cover', '', 1),
(3, 3, 19, 'duplicate', '', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff_picks`
--

CREATE TABLE `staff_picks` (
  `PickID` int(11) NOT NULL,
  `MangaID` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `Note` text DEFAULT NULL,
  `AddedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `staff_picks`
--

INSERT INTO `staff_picks` (`PickID`, `MangaID`, `AdminID`, `Note`, `AddedDate`) VALUES
(3, 22, 3, '', '2025-05-16 16:45:28'),
(4, 3, 3, '', '2025-05-16 16:45:39'),
(5, 23, 3, '', '2025-05-16 16:46:13'),
(6, 21, 3, '', '2025-05-16 16:46:16'),
(7, 20, 3, '', '2025-05-16 16:46:18'),
(8, 1, 3, '', '2025-05-16 16:46:21'),
(9, 4, 3, '', '2025-05-16 16:46:24'),
(10, 2, 3, '', '2025-05-16 16:46:27'),
(11, 5, 3, '', '2025-05-16 16:46:29'),
(12, 19, 3, '', '2025-05-16 16:46:32'),
(13, 24, 3, '', '2025-05-16 16:46:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tag`
--

CREATE TABLE `tag` (
  `TagID` int(11) NOT NULL,
  `TagGroup` enum('Format','Genre','Theme','Content') NOT NULL,
  `TagName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `tag`
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
(22, 'Genre', 'Horror'),
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
(75, 'Content', 'Sexual Violence'),
(76, 'Genre', ' Isekai');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Joined` datetime NOT NULL DEFAULT current_timestamp(),
  `Avatar` varchar(50) NOT NULL DEFAULT 'avatar_default.png',
  `Role` varchar(10) NOT NULL DEFAULT 'user',
  `banner` varchar(50) NOT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `Location` varchar(100) NOT NULL,
  `AboutField` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Joined`, `Avatar`, `Role`, `banner`, `DateOfBirth`, `Location`, `AboutField`) VALUES
(1, 'Nguvlra', '2025-04-09 15:58:19', 'avatar_default.png', 'user', '', NULL, '', ''),
(2, 'Bababoey', '2025-04-10 07:28:54', 'avatar_default.png', 'user', '', NULL, '', ''),
(3, 'Nguvlra123', '2025-04-15 16:35:13', 'avatars_3_1747238101.png', 'admin', 'banners_3_1747227599.png', '2002-08-08 00:00:00', '', ''),
(5, 'damian123', '2025-05-16 17:21:18', 'avatar_default.png', 'user', '', NULL, '', ''),
(13, 'engraver123', '2025-05-17 20:54:34', 'avatar_default.png', 'user', '', NULL, '', ''),
(16, 'lacrimosa123', '2025-05-17 21:46:16', 'avatar_default.png', 'user', '', NULL, '', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);

--
-- Chỉ mục cho bảng `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcementID`);

--
-- Chỉ mục cho bảng `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`ArtistID`);

--
-- Chỉ mục cho bảng `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`AuthorID`);

--
-- Chỉ mục cho bảng `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`MangaID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Chỉ mục cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`ChapterID`),
  ADD KEY `MangaID` (`MangaID`);

--
-- Chỉ mục cho bảng `chapter_pages`
--
ALTER TABLE `chapter_pages`
  ADD PRIMARY KEY (`ChapterID`,`PageNumber`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `CommentSectionID` (`CommentSectionID`);

--
-- Chỉ mục cho bảng `commentsection`
--
ALTER TABLE `commentsection`
  ADD PRIMARY KEY (`CommentSectionID`),
  ADD KEY `ChapterID` (`ChapterID`);

--
-- Chỉ mục cho bảng `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`MangaID`);

--
-- Chỉ mục cho bảng `manga_artist`
--
ALTER TABLE `manga_artist`
  ADD PRIMARY KEY (`MangaID`,`ArtistID`),
  ADD KEY `ArtistID` (`ArtistID`);

--
-- Chỉ mục cho bảng `manga_author`
--
ALTER TABLE `manga_author`
  ADD PRIMARY KEY (`MangaID`,`AuthorID`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Chỉ mục cho bảng `manga_tag`
--
ALTER TABLE `manga_tag`
  ADD PRIMARY KEY (`MangaID`,`TagID`),
  ADD KEY `TagID` (`TagID`);

--
-- Chỉ mục cho bảng `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`UserID`,`MangaID`),
  ADD KEY `MangaID` (`MangaID`);

--
-- Chỉ mục cho bảng `report_chapter`
--
ALTER TABLE `report_chapter`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `UserID` (`UserID`,`ChapterID`),
  ADD KEY `ChapterID` (`ChapterID`);

--
-- Chỉ mục cho bảng `report_manga`
--
ALTER TABLE `report_manga`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `MangaID` (`MangaID`),
  ADD KEY `UserID` (`UserID`);

--
-- Chỉ mục cho bảng `staff_picks`
--
ALTER TABLE `staff_picks`
  ADD PRIMARY KEY (`PickID`),
  ADD UNIQUE KEY `MangaID` (`MangaID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Chỉ mục cho bảng `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`TagID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `Username` (`Username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `artist`
--
ALTER TABLE `artist`
  MODIFY `ArtistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `author`
--
ALTER TABLE `author`
  MODIFY `AuthorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `chapter`
--
ALTER TABLE `chapter`
  MODIFY `ChapterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `commentsection`
--
ALTER TABLE `commentsection`
  MODIFY `CommentSectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `manga`
--
ALTER TABLE `manga`
  MODIFY `MangaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `report_chapter`
--
ALTER TABLE `report_chapter`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `report_manga`
--
ALTER TABLE `report_manga`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `staff_picks`
--
ALTER TABLE `staff_picks`
  MODIFY `PickID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tag`
--
ALTER TABLE `tag`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chapter_pages`
--
ALTER TABLE `chapter_pages`
  ADD CONSTRAINT `chapter_pages_ibfk_1` FOREIGN KEY (`ChapterID`) REFERENCES `chapter` (`ChapterID`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`CommentSectionID`) REFERENCES `commentsection` (`CommentSectionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `commentsection`
--
ALTER TABLE `commentsection`
  ADD CONSTRAINT `commentsection_ibfk_1` FOREIGN KEY (`ChapterID`) REFERENCES `chapter` (`ChapterID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `manga_artist`
--
ALTER TABLE `manga_artist`
  ADD CONSTRAINT `manga_artist_ibfk_1` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `manga_artist_ibfk_2` FOREIGN KEY (`ArtistID`) REFERENCES `artist` (`ArtistID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `manga_author`
--
ALTER TABLE `manga_author`
  ADD CONSTRAINT `manga_author_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `author` (`AuthorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `manga_author_ibfk_2` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `manga_tag`
--
ALTER TABLE `manga_tag`
  ADD CONSTRAINT `manga_tag_ibfk_1` FOREIGN KEY (`TagID`) REFERENCES `tag` (`TagID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `manga_tag_ibfk_2` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `report_chapter`
--
ALTER TABLE `report_chapter`
  ADD CONSTRAINT `report_chapter_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_chapter_ibfk_2` FOREIGN KEY (`ChapterID`) REFERENCES `chapter` (`ChapterID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `report_manga`
--
ALTER TABLE `report_manga`
  ADD CONSTRAINT `report_manga_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_manga_ibfk_2` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `staff_picks`
--
ALTER TABLE `staff_picks`
  ADD CONSTRAINT `staff_picks_ibfk_1` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_picks_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
