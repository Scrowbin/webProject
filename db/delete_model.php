<?php
require_once 'pdo.php';
require_once 'mangaInfoPdo.php';

// Function getCommentSectionID moved to mangaInfoPdo.php to avoid duplication
function getSlugFromMangaID($mangaID){
    $sql = "SELECT Slug FROM manga WHERE MangaID = ?";
    $result = pdo_query_value($sql, $mangaID);
    return $result;
}
function deleteChapterPages($chapterID){
    $sql = "DELETE FROM chapter_pages WHERE ChapterID = ?";
    pdo_execute($sql,$chapterID);
}

function deleteComments($commentSectionID){
    $sql = "DELETE FROM comment WHERE CommentSectionID = ?";
    pdo_execute($sql,$commentSectionID);
}

function deleteCommentSection($commentSectionID){
    $sql = "DELETE FROM commentsection WHERE CommentSectionID = ?";
    pdo_execute($sql,$commentSectionID);
}

function deleteChapter($chapterID){
    $sql = "DELETE FROM chapter WHERE ChapterID = ?";
    pdo_execute($sql,$chapterID);
}