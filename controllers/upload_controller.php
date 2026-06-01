<?php

require_once __DIR__ . '/../config/bootstrap.php';
    require_once __DIR__ . "/../models/mangaInfoPdo.php";
    
    $slug = $_GET['slug'] ?? null;

    $mangaID = getMangaIDFromSlug($slug);
    if ($mangaID === null){
        exit('No mangaID found');
    }
    $mangaInfo = getMangaInfo($mangaID);
    if ($mangaInfo === null){
        exit('No manga found');
    }
    $authorsRaw = getMangaAuthors($mangaID);
    $artistsRaw = getMangaArtists($mangaID);
    $mode = "upload";
    $image = $mangaInfo['CoverLink'];
    $pubStatus = $mangaInfo['PublicationStatus'];
    $mangaNameOG = $mangaInfo['MangaNameOG'];

    include __DIR__ . "/../views/upload.php";

?>