<?php
require_once("pdo.php");
function getChapterPages($chapterID){
    $sql = "SELECT PageLink FROM chapter_pages WHERE ChapterID = ? ORDER BY PageNumber";
    $result = pdo_query($sql,$chapterID);
    return array_column($result, 'PageLink');

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

function editInfo($chapterID, $volume, $chapterScangroup, $chapterName, $chapterNumber) {
    $sql = "UPDATE `chapter` 
            SET `Volume` = ?, 
                `ScangroupName` = ?, 
                `ChapterName` = ?, 
                `ChapterNumber` = ?
            WHERE `ChapterID` = ?";
    pdo_execute($sql, $volume, $chapterScangroup, $chapterName, $chapterNumber, $chapterID);
}

function deleteOldPages($chapterID){
    $sql = "DELETE FROM chapter_pages WHERE ChapterID = ?";
    pdo_execute($sql,$chapterID);
}