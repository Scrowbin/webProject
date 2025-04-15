<?php
    require_once("../db/mangaInfoPdo.php");
    // if (!$isset($_GET['MangaID'])){
    //     exit('invalid mangaid');
    // }
    
    $mangaID = $_GET['MangaID'] ?? 1;
    $mangaInfo = getMangaInfo($mangaID);
    $authorsRaw = getMangaAuthors($mangaID);
    $artistsRaw = getMangaArtists($mangaID);

    $image = $mangaInfo['CoverLink'];
    $pubStatus = $mangaInfo['PublicationStatus'];
    $mangaNameOG = $mangaInfo['MangaNameOG'];
    include("../PHP/upload.php");

?>