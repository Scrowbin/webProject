<?php
require_once 'pdo.php';

function chapterExist($mangaID, $number){
    $sql = "SELECT 1 FROM chapter WHERE MangaID = ? AND ChapterNumber = ?";
    $result = pdo_query($sql, $mangaID, $number);
    return !empty($result);
}

function insertChapter($mangaID, $volume, $scangroupName, $uploaderName, $chapterName, $chapterNum) {
    $sql = "INSERT INTO chapter (MangaID, Volume, ScangroupName, UploaderName, ChapterName, ChapterNumber)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    return pdo_execute_return_id($sql,$mangaID, $volume, $scangroupName, $uploaderName, $chapterName, $chapterNum);
}

function insertPage($chapterID, $filePath, $order) {
    $sql = "INSERT INTO chapter_pages (ChapterID, PageNumber, PageLink) VALUES (?, ?, ?)";
    pdo_execute($sql, $chapterID, $order, $filePath);
}

function getUsername($userID){
    $sql = "SELECT Username FROM user where UserID = ?";
    return pdo_query_value($sql,$userID);
}
function getUserID ($username){
    $userID = pdo_query_one('SELECT user.UserID FROM account join user on
    account.username = user.Username where account.username = ?', $username);
    if ($userID===null or $userID==='') return null;
    return $userID['UserID'];
}

function makeComment($chapterID){
    $sql = 'INSERT INTO commentsection (ChapterID) VALUES (?)';
    pdo_execute($sql,$chapterID);
}