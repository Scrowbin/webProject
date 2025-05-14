<?php
    require_once("pdo.php");

    function insertManga($MangaID,$NameOG, $NameEN, $mangaDesc,$OGLanguage, $coverLink, $demographic, $content_rating, $publication_year, $publication_status,$slug) {
        $sql = "INSERT INTO manga (MangaID,MangaNameOG, MangaNameEN, MangaDiscription, OriginalLanguage, CoverLink, MagazineDemographic, ContentRating, PublicationYear, PublicationStatus, Slug)
                VALUES (?,?, ?, ?, ?, ?, ?, ?,?, ?, ?)";
        pdo_execute($sql,$MangaID, $NameOG, $NameEN, $mangaDesc,$OGLanguage, $coverLink, $demographic, $content_rating, $publication_year, $publication_status, $slug);
    }

    function mangaExist($mangaNameEN,$mangaNameOG){
        $sql = "SELECT MangaID FROM manga WHERE MangaNameEN = ? OR MangaNameOG = ? OR MangaNameEN = ? OR MangaNameOG = ?";
        return pdo_query_value($sql,$mangaNameEN,$mangaNameEN,$mangaNameOG,$mangaNameOG);
    }
    
    function getLatestID(){
        $sql = "SELECT MangaID FROM manga ORDER BY MangaID DESC LIMIT 1";
        return pdo_query_value($sql);
    }

    function artistExist($artistName){
        $sql = "SELECT ArtistID FROM artist where ArtistName = ?";
        $row = pdo_query_value($sql,$artistName);
        // If no row is found, return null instead of false
        if ($row === false) {
            return null;
        }

        return $row;  // Return the result if found
    }
    function authorExist($artistName){
        $sql = "SELECT AuthorID FROM author where AuthorName = ?";
        $row = pdo_query_value($sql,$artistName);
        if ($row === false) {
            return null;
        }

        return $row;  // Return the result if found
    }

    function insertArtist($artistName){
        $sql = "INSERT INTO artist (ArtistName) VALUES (?)";
        return pdo_execute_return_id($sql,$artistName);
    }

    function insertAuthor($authorName){
        $sql = "INSERT INTO author (AuthorName) VALUES (?)";
        return pdo_execute_return_id($sql,$authorName);
    }

    function assignAuthorManga($mangaID,$authorID){
        $sql = "INSERT INTO manga_author (MangaID, AuthorID) VALUES (?,?)";
        return pdo_execute($sql,$mangaID,$authorID);
    }
    function assignArtistManga($mangaID,$authorID){
        $sql = "INSERT INTO manga_artist (MangaID, ArtistID) VALUES (?,?)";
        return pdo_execute($sql,$mangaID,$authorID);
    }

    function getTagID($tagName){
        $sql = "SELECT TagID FROM tag WHERE TagName = ?";
        return pdo_query_value($sql,$tagName);
    }

    function mapMangaWithTag($mangaID, $tagID){
        $sql = "INSERT INTO manga_tag (MangaID, TagID) VALUES (?,?)";
        return pdo_execute($sql,$mangaID,$tagID);
    }

?>
