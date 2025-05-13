<?php
    require_once 'pdo.php';
    require_once 'mangaInfoPdo.php';

    //này sẽ lấy mấy cái gần nhất trong vòng 1 ngày từ cùng 1 manga mà thôi
    function getUpdates($limit, $offset) {
        $sql = "
            SELECT
                c.*,
                m.MangaNameOG,
                m.CoverLink
            FROM chapter c
            JOIN (
                SELECT
                    MangaID,
                    MAX(UploadTime) as LatestUpload
                FROM chapter
                GROUP BY MangaID
            ) latest ON c.MangaID = latest.MangaID
                   AND c.UploadTime >= DATE_SUB(latest.LatestUpload, INTERVAL 1 DAY)
            JOIN manga m ON m.MangaID = c.MangaID
            ORDER BY c.UploadTime DESC
            LIMIT ? OFFSET ?
        ";
        return pdo_query_int($sql, $limit, $offset);
    }

    function getComments($chapterID){
        $sql = "SELECT
                    cs.CommentSectionID,
                    COUNT(c.CommentID) as NumOfComments
                FROM
                commentsection cs
                JOIN
                comment c
                ON
                cs.CommentSectionID = c.CommentSectionID
                WHERE
                cs.ChapterID = ?
                GROUP BY
                cs.CommentSectionID
                ";
        return pdo_query_one($sql,$chapterID);
    }
    function getUpdatesBookmark($userID,$limit, $offset) {
        $sql = "
            SELECT
                c.*,
                m.MangaNameOG,
                m.CoverLink
            FROM chapter c
            JOIN (
                SELECT
                    MangaID,
                    MAX(UploadTime) as LatestUpload
                FROM chapter
                GROUP BY MangaID
            ) latest ON c.MangaID = latest.MangaID
                   AND c.UploadTime >= DATE_SUB(latest.LatestUpload, INTERVAL 1 DAY)
            JOIN manga m ON m.MangaID = c.MangaID
            JOIN bookmark b ON m.MangaID = b.MangaID
            WHERE b.UserID = ?
            ORDER BY c.UploadTime DESC
            LIMIT ? OFFSET ?
        ";
        return pdo_query_int($sql,$userID, $limit, $offset);
    }
    function getRecent($limit){
        $sql = "SELECT m.* from manga m
                ORDER BY m.MangaID DESC
                LIMIT ?";
        return pdo_query_int($sql,$limit);
    }
    function getLibrary($userID,$limit){
        $sql = "SELECT m.* from manga m
                JOIN bookmark b
                ON m.MangaID = b.MangaID
                WHERE b.UserID = ?
                ORDER BY m.MangaID DESC
                LIMIT ?";
        return pdo_query_int($sql,$userID,$limit);
    }
    // Function getCommentSectionID moved to mangaInfoPdo.php to avoid duplication
    function getNumOfComment($commentSectionID){
        $sql = "SELECT COUNT(*) AS NumOfComments from comment WHERE CommentSectionID = ?";
        return pdo_query_value($sql, $commentSectionID);
    }
?>