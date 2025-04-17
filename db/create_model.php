<?php
    require_once("pdo.php");

    function insertManga($mangaName){
        $sql = "INSERT INTO manga (
                MangaNameOG, MangaNameEN, MangaDiscription, CoverLink,
                Demographic, ContentRating, PublicationYear, PublicationStatus
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        pdo_execute();
    }
?>