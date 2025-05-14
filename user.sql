-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 14, 2025 lúc 11:06 AM
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
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Joined` datetime NOT NULL DEFAULT current_timestamp(),
  `Avatar` varchar(50) NOT NULL DEFAULT 'avatar_default.png',
  `Role` varchar(10) NOT NULL DEFAULT 'user',
  `banner` varchar(50) NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Joined`, `Avatar`, `Role`, `banner`, `DateOfBirth`, `Location`) VALUES
(1, 'Nguvlra', '2025-04-09 15:58:19', 'avatar_default.png', 'user', '', NULL, ''),
(2, 'Bababoey', '2025-04-10 07:28:54', 'avatar_default.png', 'user', '', NULL, ''),
(3, 'Nguvlra123', '2025-04-15 16:35:13', 'avatar_3_{time()}.png', 'admin', 'banner_3_{time()}.png', NULL, ''),
(4, 'damian123', '2025-05-08 07:50:49', 'avatar_default.png', 'user', '', NULL, ''),
(5, 'eugene123', '2025-05-14 12:00:56', 'avatar_default.png', 'user', '', NULL, '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
