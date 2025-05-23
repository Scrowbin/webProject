<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once("../db/latestUpdates_model.php");


    $page = $_GET['page'] ?? 1;
    $limit = 4;
    $offset = ($page - 1) * $limit;
    $chapters = getUpdates(1000,0);
    $isLatestUpdates = true;
    $pathPrefix = '../'; // Define path prefix for includes relative to controller directory

    $grouped = [];
    foreach ($chapters as $chapter) {
        $manga = $chapter['MangaID'];
        $commentSectionID =   getCommentSectionID($chapter['ChapterID']) ?? 0;
        $chapter['CommentSectionID'] = $commentSectionID;
        $chapter['NumOfComments'] = getNumOfComment($commentSectionID)  ?? 0;
        $grouped[$manga][] = $chapter;
    }
        // Now sort and trim each manga's chapter list
    foreach ($grouped as $mangaID => &$chapterList) {
        // Sort chapters by ChapterNumber descending
        usort($chapterList, function ($a, $b) {
            return floatval($b['ChapterNumber']) <=> floatval($a['ChapterNumber']);
        });

        $chapterList = array_slice($chapterList, 0, 3);
    }

    $grouped = array_values($grouped);
    //lấy 4 cái manga per pagination
    $totalManga = count($grouped); // <- for pagination logic
    $totalPages = ceil($totalManga / $limit);
    $currentPage = $_GET['page'] ?? 1;
    $grouped = array_slice($grouped, $offset, $limit);
    unset($chapterList);
    include("../PHP/latestUpdates.php");
?>