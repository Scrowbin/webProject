<?php

require_once __DIR__ . '/../config/bootstrap.php';
    require_once __DIR__ . "/../models/mangaInfoPdo.php";
    require_once __DIR__ . "/../models/editChapter.php";

    $slug = $_GET['slug'] ?? null;
    $mangaID = getMangaIDFromSlug($slug);
    $chapterNumber = str_replace('-', '.', $_GET['chapter']);
    $chapterID = getChapterID($slug,$chapterNumber) ?? null;
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

    include __DIR__ . "/../views/upload.php";

?>