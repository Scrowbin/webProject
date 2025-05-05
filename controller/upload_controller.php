<?php
    require_once("../db/mangaInfoPdo.php");
    // if (!$isset($_GET['MangaID'])){
    //     exit('invalid mangaid');
    // }
    
    $mangaID = $_GET['MangaID'] ?? null;
    if ($mangaID === null){
        exit('No mangaID found');
    }
    $mangaInfo = getMangaInfo($mangaID);
    if ($mangaInfo === null){
        exit('No manga found');
    }
    $authorsRaw = getMangaAuthors($mangaID);
    $artistsRaw = getMangaArtists($mangaID);

    $image = $mangaInfo['CoverLink'];
    $pubStatus = $mangaInfo['PublicationStatus'];
    $mangaNameOG = $mangaInfo['MangaNameOG'];
    include("../PHP/upload.php");

?>