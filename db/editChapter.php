<?php
require_once("pdo.php");
function getChapterID($mangaSlug, $chapterNumber){
        $sql = 'SELECT ChapterID
                FROM chapter c
                JOIN manga m
                ON c.MangaID = m.MangaID
                WHERE m.Slug = ? AND c.ChapterNumber = ?';
        return pdo_query_value($sql,$mangaSlug,$chapterNumber);
    }
function getChapterPages($chapterID){
    $sql = "SELECT PageLink FROM chapter_pages WHERE ChapterID = ? ORDER BY PageNumber";
    $result = pdo_query($sql,$chapterID);
    return array_column($result, 'PageLink');

}
function insertPage($chapterID, $filePath, $order) {
    $sql = "INSERT INTO chapter_pages (ChapterID, PageNumber, PageLink) VALUES (?, ?, ?)";
    pdo_execute($sql, $chapterID, $order, $filePath);
}

function getMangaID($chapterID): string{
    $sql = "SELECT MangaID FROM chapter WHERE ChapterID = ?";
    $result = pdo_query_value($sql,$chapterID);
    return $result;

}

function chapterExist($chapterID){
    $sql = "SELECT 1 FROM chapter WHERE ChapterID = ?";
    $result = pdo_query($sql, $chapterID);
    return !empty($result);
}
function getChapterInfo($chapterID){
    $sql = "SELECT * FROM chapter WHERE ChapterID = ?";
    return pdo_query_one($sql,$chapterID);
}

function editInfo($chapterID, $volume, $chapterScangroup, $chapterName, $chapterNumber, $language) {
    $sql = "UPDATE `chapter` 
            SET `Volume` = ?, 
                `ScangroupName` = ?, 
                `ChapterName` = ?, 
                `ChapterNumber` = ?,
                `Language` = ?
            WHERE `ChapterID` = ?";
    pdo_execute($sql, $volume, $chapterScangroup, $chapterName, $chapterNumber,$language, $chapterID);
}

function deleteOldPages($chapterID){
    $sql = "DELETE FROM chapter_pages WHERE ChapterID = ?";
    pdo_execute($sql,$chapterID);
}