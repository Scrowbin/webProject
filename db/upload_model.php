<?php
require_once 'pdo.php';
require_once 'account_db.php'; // Thêm để sử dụng hàm getUserID từ account_db.php

function getSlugFromMangaID($mangaID){
    $sql = "SELECT Slug FROM manga WHERE MangaID = ?";
    $result = pdo_query_value($sql, $mangaID);
    return $result;
}
function chapterExist($mangaID, $number){
    $sql = "SELECT 1 FROM chapter WHERE MangaID = ? AND ChapterNumber = ?";
    $result = pdo_query($sql, $mangaID, $number);
    return !empty($result);
}

function insertChapter($mangaID, $volume, $scangroupName, $uploaderName, $chapterName, $chapterNum,$language) {
    $sql = "INSERT INTO chapter (MangaID, Volume, ScangroupName, UploaderName, ChapterName, ChapterNumber, Language)
            VALUES (?, ?, ?, ?, ?, ?,?)";

    return pdo_execute_return_id($sql,$mangaID, $volume, $scangroupName, $uploaderName, $chapterName, $chapterNum,$language);
}

function insertPage($chapterID, $filePath, $order) {
    $sql = "INSERT INTO chapter_pages (ChapterID, PageNumber, PageLink) VALUES (?, ?, ?)";
    pdo_execute($sql, $chapterID, $order, $filePath);
}

function getUsername($userID){
    $sql = "SELECT Username FROM user where UserID = ?";
    return pdo_query_value($sql,$userID);
}
// Đã xóa hàm getUserID vì đã được định nghĩa trong account_db.php

function makeComment($chapterID){
    $sql = 'INSERT INTO commentsection (ChapterID) VALUES (?)';
    pdo_execute($sql,$chapterID);
}