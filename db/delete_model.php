<?php
require_once('pdo.php');

function getCommentSectionID($chapterID){
    $sql = "SELECT CommentSectionID FROM commentsection WHERE ChapterID = ?";
    return pdo_query_value($sql,$chapterID);
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