<?php
    require_once("../db/mangaInfoPdo.php");
    require_once("../db/editChapter.php");
    $chapterID = $_GET['ChapterID'] ?? null;
    if ($chapterID === null){
        exit('No chapterID found');
    }
    $chapterInfo = getChapterInfo($chapterID);
    $mangaID = $chapterInfo["MangaID"]??0;
    if ($mangaID==0){
        exit('No manga found');
    }
    $mangaInfo = getMangaInfo($mangaID);
    if ($mangaInfo === null){
        exit('No manga found');
    }

    $mode = "edit";
    $authorsRaw = getMangaAuthors($mangaID);
    $artistsRaw = getMangaArtists($mangaID);

    $image = $mangaInfo['CoverLink'];
    $pubStatus = $mangaInfo['PublicationStatus'];
    $mangaNameOG = $mangaInfo['MangaNameOG'];

    $chapterPages = getChapterPages($chapterID);
    //chapterinfo

    include("../PHP/upload.php");

?>