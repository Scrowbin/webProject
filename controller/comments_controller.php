<?php
    require('../db/commentsPdo.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;
    $isLoggedIn = false;
    if ($userID !=null || $username!= null){
        $isLoggedIn =true;
    }
    $mangaSlug = $_GET['slug'];
    $chapter = str_replace("-",".",$_GET['chapter'])??null;
    $commentsID = getCommentSectionIDBySlug($mangaSlug,$chapter) ?? 0;
    if ($commentsID==null || $commentsID==0){
        exit('This comment section doesnt exist yet');
    }
    $page = $_GET['page'] ?? 1; // if page is not set, default to 1

    $mangaInfo = getMangaDetails($commentsID);
    $mangaID = $mangaInfo['MangaID'];
    $authorsRaw = getMangaAuthors($mangaID);
    $artistsRaw = getMangaArtists($mangaID);

    $chapterInfo =getChapterID($commentsID);
    $chapterID = $chapterInfo['ChapterID'];
    $chapterName = $chapterInfo['ChapterName'];
    $chapterNumber = $chapterInfo['ChapterNumber'];
    include('../PHP/comments.php');
?>