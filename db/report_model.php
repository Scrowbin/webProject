<?php
    require_once("../db/pdo.php");
    function sendMangaReport($userID,$mangaID,$type, $description){
        $sql = "INSERT INTO report_manga (`UserID`, `MangaID`, `ReportType`, `Description`) VALUES (?,?,?,?)";
        pdo_execute($sql,$userID,$mangaID,$type, $description);
    }

    function sendChapterReport($userID,$chapterID,$type, $description){
        $sql = "INSERT INTO `report_chapter` (`UserID`, `ChapterID`, `ReportType`, `Description`) VALUES (?,?,?,?)";
        pdo_execute($sql,$userID,$chapterID,$type, $description);
    }

    function getMangaReports($limit, $offset){
        $sql = "SELECT r.*, u.Username, m.CoverLink,m.MangaNameOG,m.Slug
        FROM report_manga r 
        JOIN user u ON r.UserID = u.UserID 
        JOIN manga m ON m.MangaID = r.MangaID 
        WHERE r.Resolved = 0 
        LIMIT ? OFFSET ?";
        return pdo_query_int($sql, $limit, $offset);
    }
    
    function getChapterReports($limit, $offset){
        $sql = "SELECT r.*, u.Username, c.ChapterNumber,c.ChapterName,m.MangaNameOG
        FROM report_chapter r 
        JOIN user u ON r.UserID = u.UserID 
        JOIN chapter c ON c.ChapterID = r.ChapterID 
        JOIN manga m ON c.MangaID = m.MangaID
        WHERE r.Resolved = 0 
        LIMIT ? OFFSET ?";
        return pdo_query_int($sql, $limit, $offset);
    }

    function resolveMangaReport($reportID){
        $sql = "UPDATE report_manga SET Resolved = 1 WHERE ReportID = ?";
        pdo_execute($sql, $reportID);
    }
    
    function resolveChapterReport($reportID){
        $sql = "UPDATE report_chapter SET Resolved = 1 WHERE ReportID = ?";
        pdo_execute($sql, $reportID);
    }
    