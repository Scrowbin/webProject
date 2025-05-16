-- Create staff_picks table
CREATE TABLE IF NOT EXISTS `staff_picks` (
  `PickID` int(11) NOT NULL AUTO_INCREMENT,
  `MangaID` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `Note` text COLLATE utf8mb4_bin DEFAULT NULL,
  `AddedDate` datetime NOT NULL,
  PRIMARY KEY (`PickID`),
  UNIQUE KEY `MangaID` (`MangaID`),
  KEY `AdminID` (`AdminID`),
  CONSTRAINT `staff_picks_ibfk_1` FOREIGN KEY (`MangaID`) REFERENCES `manga` (`MangaID`) ON DELETE CASCADE,
  CONSTRAINT `staff_picks_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
