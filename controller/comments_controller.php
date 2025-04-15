<?php
    require('../db/commentsPdo.php');
    if (!isset($_GET['commentsID'])){
        exit('Invalid comment section');
    }
    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;
    $isLoggedIn = false;
    if ($userID !=null || $username!= null){
        $isLoggedIn =true;
    }
     
    $commentsID = $_GET['commentsID'];
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