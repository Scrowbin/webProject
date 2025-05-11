<?php
require_once 'pdo.php';
require_once 'mangaInfoPdo.php';

function getChapterInfo($chapterIDs){
    $chaptersInfo = [];
    if (!empty($chapterIDs)){
        foreach($chapterIDs as $chapterID){
            $sql = "SELECT
                c.*,
                m.MangaNameOG,
                m.CoverLink,
                m.OriginalLanguage
            FROM chapter c
            JOIN manga m
            ON c.MangaID = m.MangaID
            WHERE ChapterID = ?";
            $result = pdo_query_one($sql,$chapterID);
            if ($result) {
                $chaptersInfo[] = $result;
            }
        }
    }
    return $chaptersInfo;
}
// Function getCommentSectionID moved to mangaInfoPdo.php to avoid duplication
function getNumOfComment($commentSectionID){
    $sql = "SELECT COUNT(*) AS NumOfComments from comment WHERE CommentSectionID = ?";
    return pdo_query_value($sql, $commentSectionID);
}